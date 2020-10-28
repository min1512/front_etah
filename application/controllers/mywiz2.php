<?php

class Mywiz2 extends MY_Controller
{
	protected $methods = array(
		//'index_get' => array('log' => 0)
	);

	function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}

		parent::__construct();


		/**
		 * 로그 기록 여부 설정
		 */
		$method_id = explode(".", $this->uri->segment(2));
		if( ! empty($method_id[0])) {
			$method_type = strtolower($method);
			$funtion = $method_id[0]."_".$method_type;
			if(!config_item('log')) $this->methods[$funtion] = array('log' => 0);
		}

		//API Key 사용시 해당 값을 설정하면 키검사를 하지 않음
		$this->_allow = TRUE;

		//Load MODEL
		 $this->load->model('mywiz2_m');

		 //비로그인 상태에서는 회원정보 페이지 접근 불가
		if(!$this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');
	}


	/**
	 * 상품평 등록하기
	 */
	 public function comment_regist_post()
	{
		 $param = $this->input->post();
 		 $param['grade_val'] = $param['grade_val01'].$param['grade_val02'].$param['grade_val03'].$param['grade_val04'];

		 $this->load->model('member_m');

		 $param = str_replace("\\","\\\\",$param);
		 $param = str_replace("'","\'",$param);
		 $param = str_replace("\n","<br />",$param);

		 $member = $this->member_m->get_member_info_id($this->session->userdata('EMS_U_ID_'));

		 $param['mem_no'	] = $member['CUST_NO'];
		 $param['mem_name'	] = $member['CUST_NM'];

		 $comment_yn	= $this->mywiz2_m->get_goods_order_refer($param);

		 if(count($comment_yn) == 0){
			 $this->response(array('status' => 'error', 'message' => '해당 상품을 구매하신 내역이 없습니다.'), 200);
			 return false;
		 }

		 $param['order_refer_code'] = $comment_yn[0]['ORDER_REFER_NO'];

		 for($i=0; $i<count($comment_yn); $i++){
			 $exists_comment = $this->mywiz2_m->get_exists_comment_order($param);

			 if($exists_comment['cnt'] == 1){	//이미 주문상세번호에 해당하는 상품평이 등록되어있다면 넘기기
				 if($i+1 == count($comment_yn)){
					 $this->response(array('status' => 'error', 'message' => '이미 상품평을 입력하셨습니다.'), 200);
					 return false;
				 }
				 $param['order_refer_code'] = $comment_yn[$i+1]['ORDER_REFER_NO'];
			 } else {
				 break;
			 }
		 }

		 $param['goods_comment_no'] = $this->mywiz2_m->regist_comment($param);

		 //첨부파일 확인
		 if($_FILES['fileUpload']['name']){

			$cust_no = $this->session->userdata('EMS_U_NO_');

			$this->load->helper(array('form', 'url'));

			$image_path = '/webservice_root/etah_front_test/assets/uploads';

			if ( ! @is_dir($image_path)){
				$this->response(array('status' => 'error upload fail_comment_NO Directory'));
			}

			$config['upload_path'	] = $image_path;
			$config['allowed_types'	] = 'gif|jpg|jpeg';
			$config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
				$error = array('error' => $this->upload->display_errors());
				$this->response(array('status' => 'error upload fail_comment', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
			}else{
				$data = $this->upload->data();

//				var_dump($data);
				//s3 파일전송
				self::_s3_upload($data, $param['goods_comment_no']);
			}
		}

		 $this->response(array('status' => 'ok'), 200);
	}

	/**
	 * s3 파일전송
	 */
	public function _s3_upload($param, $goods_comment_no)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		$date = date("YmdHis", time());

		$title = $cust_no.$date;

		//Load Library
		$this->load->library('s3');

		$input = S3::inputFile('/webservice_root/etah_front_test/assets/uploads/'.$param['file_name']);
		if (S3::putObject($input, 'img.etah.co.kr', 'cust_goods_comment/'.$cust_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
//			echo "File uploaded.";

			$title = 'http://img.etah.co.kr/cust_goods_comment/'.$cust_no.'/'.$title.$param['file_ext'];
			$this->mywiz2_m->update_goods_comment_file_path($title, $goods_comment_no);
		}else{
			echo "Failed to upload file.";
		}
	}



}