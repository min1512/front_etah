<?php

class Customer extends MY_Controller
{

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

		/* model_m */
		$this->load->model('customer_m');
	}

	public function index_get()
	{
		self::main_get();

	}

	/**
	 * 고객센터 메인
	 */
	public function main_get()
	{

		$data = array();
		$param = array();

		$param['page'			] = 1;
		$param['limit_num_rows'	] = 5;
		$param['keyword'		] = "";
		$param['type'			] = "";

		$data['notice'	] = $this->customer_m->get_notice_list($param);

		$param['limit_num_rows'	] = 10;

		$data['faq'		] = $this->customer_m->get_faq_list($param);
		$data['faq_cnt'	] = $this->customer_m->get_faq_list_count($param);
		$data['keyword'	] = $param['keyword'];
		$data['type'	] = "";
		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		/**
		 * 퀵 레이아웃
		 */
		$this->load->library('quick_lib');
		$data['quick'] =  $this->quick_lib->get_quick_layer();
//var_dump($data['quick']['view']);

		$this->load->view('include/header', $data);
		$this->load->view('include/customer_nav');
		$this->load->view('customer/customer');
		$this->load->view('include/layout');
		$this->load->view('include/footer');

	}

	/**
	 * FAQ
	 */
	public function faq_get()
	{
		$data = array();
		$data['keyword'	] = "";
		$data['type'	] = $this->uri->segment(3);

		//공지사항 리스트
		self::_faq_list($data);

	}

	/**
	 * FAQ 페이지
	 */
	public function faq_page_get($page = 1)
	{
		$get_vars = $this->input->get();
		$get_vars['page'] = $page;

		//공지사항 리스트
		self::_faq_list($get_vars);
	}

	/**
	 * FAQ 리스트
	 */
	public function _faq_list($param)
	{
		$data = array();

		$param['limit_num_rows'	] = 10;

		$totalCnt = $this->customer_m->get_faq_list_count($param);

		if(empty($param['page'])){
			$param['page'] = 1;
		}
		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		$faq= $this->customer_m->get_faq_list($param);


		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'customer/faq_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['faq'			] = $faq;
		$data['total_cnt'	] = $totalCnt;
		$data['page'		] = $param['page'];
		$data['sNum'		] = $param['limit_num_rows'	];
		$data['keyword'		] = $param['keyword'];
		$data['type'		] = $param['type'];

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		/**
		 * 퀵 레이아웃
		 */
		$this->load->library('quick_lib');
		$data['quick'] =  $this->quick_lib->get_quick_layer();
//var_dump($data['quick']['view']);

		$this->load->view('include/header', $data);
		$this->load->view('include/customer_nav');
		$this->load->view('customer/customer_faq');
		$this->load->view('include/layout');
		$this->load->view('include/footer');

	}

	/**
	 * 공지사항
	 */
	public function notice_get()
	{
		$data = array();

		//공지사항 리스트
		self::_notice_list($data);
	}

	/**
	 * 공지사항 페이지
	 */
	public function notice_page_get($page = 1)
	{
		$get_vars = $this->input->get();
		$get_vars['page'	 ] = $page;

		//공지사항 리스트
		self::_notice_list($get_vars);
	}


	/**
	 * 공지사항 리스트
	 */
	public function _notice_list($param)
	{
		$param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 10 : $param['limit_num_rows'];
		$param['page'			] = empty($param['page'				]) ? 1  : $param['page'			];

		 //공지사항 개수
		$totalCnt = $this->customer_m->get_notice_list_count($param);

		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'customer/notice_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['notice'		] = $this->customer_m->get_notice_list($param);
		$data['total_cnt'	] = $totalCnt;
		$data['page'		] = $param['page'];
		$data['sNum'		] = $param['limit_num_rows'	];
		$data['keyword'		] = "";
		$data['type'		] = "";

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		/**
		 * 퀵 레이아웃
		 */
		$this->load->library('quick_lib');
		$data['quick'] =  $this->quick_lib->get_quick_layer();
//var_dump($data['quick']['view']);

		$this->load->view('include/header', $data);
		$this->load->view('include/customer_nav');
		$this->load->view('customer/customer_notice');
		$this->load->view('include/layout');
		$this->load->view('include/footer');
	}


	/**
	 * 1:1문의하기
	 */
	public function register_qna_get()
	{
		$data = array();

//		phpinfo();

		$param['limit_num_rows'	] = 5;
		$param['page'			] = empty($param['page'				]) ? 1 : $param['page'			];
		$totalPage = 0;

		$totalCnt = $this->customer_m->get_order_list_count_by_customer($param);

		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		if($totalPage > 5){
			$data['cnt_page'] = 5;
		}else{
			$data['cnt_page'] = $totalPage;
		}

		$data['keyword'		] = "";
		$data['type'		] = "QNA";
		$data['qna_type'	] = $this->customer_m->get_qna_type_list();
		$data['order'		] = $this->customer_m->get_order_list_by_customer($param);
		$data['total_cnt'	] = $totalCnt;
		$data['total_page'	] = $totalPage;

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		/**
		 * 퀵 레이아웃
		 */
		$this->load->library('quick_lib');
		$data['quick'] =  $this->quick_lib->get_quick_layer();
//var_dump($data['order']);

		$this->load->view('include/header', $data);
		$this->load->view('include/customer_nav');
		$this->load->view('customer/register_qna');
		$this->load->view('include/layout');
		$this->load->view('include/footer');
	}

	/**
	 * 1:1문의하기 주문내역 페이징
	 */
	public function order_page_post()
	{
		$param = $this->input->post();

		$param['limit_num_rows'	] = 4;

		$order = $this->customer_m->get_order_list_by_customer($param);


		$this->response(array('status'=>'ok', 'order'=>$order), 200);
	}

	/**
	 * 1:1문의등록
	 */
	public function register_qna_post()
	{
		$param = $this->input->post();

//		var_dump($param);
//		var_dump($_FILES);

		$cust_id = $this->session->userdata('EMS_U_ID_');
		$cust_no = $this->session->userdata('EMS_U_NO_');

		if(($cust_id == 'GUEST') || ($cust_id == '')) $cust_no = "guest";

		$param = str_replace("\n", '<br>', $param);
		$param = str_replace("'","\'",$param);

		$param['qna_no'] = $this->customer_m->register_qna($param);

		$this->customer_m->register_qna_contents($param);

		if($param['order_refer_no']) $this->customer_m->register_map_cs_n_order_refer($param);

		//첨부파일 확인
		if($_FILES['fileUpload']['name']){

			$this->load->helper(array('form', 'url'));

			$image_path = '/webservice_root/etah_front/assets/uploads';

			if ( ! @is_dir($image_path)){
				$this->response(array('status' => 'error upload fail_qna_NO Directory'));
			}

			$config['upload_path'	] = $image_path;
			$config['allowed_types'	] = 'gif|jpg|jpeg';
			$config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
				$error = array('error' => $this->upload->display_errors());
				$this->response(array('status' => 'error upload fail_qna', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
			}else{
				$data = $this->upload->data();

//				var_dump($data);
				//s3 파일전송
				self::_s3_upload($data, 'cs', $param['qna_no']);
			}
		}

		if($cust_no ==  "guest"){ //비회원
			//1:1문의 내역 이메일 메일 발송
			$mailParam["kind"		] = "qna";
			$mailParam["title"		] = $param['title'];
			$mailParam["content"	] = $param['content'];
			$mailParam["name"		] = $param['name'];
			$mailParam["type"		] = $param['type'];
			$mailParam["phone"		] = $param['phone'];
			$mailParam["email"		] = $param['email'];
			$mailParam["date"		] = date("Y년 m월 d일", time());
//					var_dump($mailParam);
			self::_background_send_mail($mailParam);
		}

		$this->response(array('status'=>'ok'));
	}

	/**
	 * 파일 업로드
	 */
	public function do_upload_post()
	{
		$ftp = "";
		$data_main = "";
		$data = "";
		$param	= $this->input->post();

//		var_dump($param);
//		var_dump($_FILES);

		$cust_no = $this->session->userdata('EMS_U_NO_');

		$this->load->helper(array('form', 'url'));

		$image_path = '/webservice_root/etah_front/assets/uploads';

		if ( ! @is_dir($image_path))
		{
			$this->response(array('status' => 'error upload fail_qna_NO Directory'));
		}

		$config['upload_path'	] = $image_path;
		$config['allowed_types'	] = 'gif|jpg|jpeg';
		$config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

		$this->load->library('upload', $config);
			if($_FILES['fileUpload']['name'] != "") {
				// 업로드
				if ( !$this->upload->do_upload('fileUpload'))
				{
					$error = array('error' => $this->upload->display_errors());
					$this->response(array('status' => 'error upload fail_qna', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
				}
				else
				{
					$data = $this->upload->data();

//					var_dump($data);
					//s3 파일전송
					self::_s3_upload($data);
				}
			}

		$this->response(array('status' => 'ok'));
	}

	/**
	 * 1:1문의 수정
	 */
	public function modify_qna_post()
	{
		$param = $this->input->post();
//		var_dump($_FILES);
//		var_dump($param);

		$param = str_replace("\n", '<br>', $param);
		$param = str_replace("'","\'",$param);

		$this->customer_m->update_qna($param);
		$this->customer_m->update_qna_content($param);

		//첨부파일 확인
		if($_FILES['fileUpload']['name']){

			$this->load->helper(array('form', 'url'));

			$image_path = '/webservice_root/etah_front/assets/uploads';

			if ( ! @is_dir($image_path)){
				$this->response(array('status' => 'error upload fail_qna_NO Directory'));
			}

			$config['upload_path'	] = $image_path;
			$config['allowed_types'	] = 'gif|jpg|jpeg';
			$config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
				$error = array('error' => $this->upload->display_errors());
				$this->response(array('status' => 'error upload fail_qna', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
			}else{
				$data = $this->upload->data();

//				var_dump($data);
				//s3 파일전송
				self::_s3_upload($data, 'cs', $param['qna_no']);
			}
		}

		$this->response(array('status' => 'ok'), 200);
	}


	/**
	 * s3 파일전송
	 */
	public function _s3_upload($param, $kind, $kind_no)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		$date = date("YmdHis", time());

		$title = $kind_no."_".$date;

		//Load Library
		$this->load->library('s3');

		$input = S3::inputFile('/webservice_root/etah_front/assets/uploads/'.$param['file_name']);
		if (S3::putObject($input, 'image.etah.co.kr', $kind.'/'.$cust_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
//			echo "File uploaded.";

			$title = 'http://image.etah.co.kr/'.$kind.'/'.$cust_no.'/'.$title.$param['file_ext'];
			if($kind == 'cs'){
				$this->customer_m->update_cs_qna_file_path($title, $kind_no);
			}
		}else{
//			echo "Failed to upload file.";
		}

	}

	/**
	 * 1:1문의 완료
	 */
	public function qna_finish_get()
	{
		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		$this->load->view('include/header', $data);
		$this->load->view('customer/register_qna_finish');
		$this->load->view('include/footer');
	}

	/**
	 * 1:1문의확인
	 */
	public function qna_list_get()
	{
		$data = array();
		$data['gb'			] = '01';
		$data['gb_nm'		] = 'p_qna';
		$data['date_type'	] = '0';
		$data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
		$data['date_to'		] = date("Y-m-d", time());
		$data['nav'			] = "PQ";

		//1:1문의 리스트 조회
		self::_qna_list($data);
	}

	/**
	 * 1:1문의 페이징
	 */
	public function qna_page_get($page = 1)
	{
		$get_vars = $this->input->get();
		$get_vars['gb'		] = '01';
		$get_vars['gb_nm'	] = 'p_qna';
		$get_vars['page'	] = $page;
		$get_vars['nav'		] = "PQ";

		//1:1문의 리스트 조회
		self::_qna_list($get_vars);
	}

	/**
	 * 활동 및 문의 리스트
	 */
	public function _qna_list($param)
	{
		$data = array();

		$this->load->model('mywiz_m');

		$param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

		$totalCnt = $this->mywiz_m->get_qna_list_count($param);

		if(empty($param['page'])){
			$param['page'] = 1;
		}
		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		$qna_list = $this->mywiz_m->get_qna_list($param);


		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'customer/qna_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['qna_list'	] = $qna_list;
		$data['date_type'	] = $param['date_type'];
		$data['date_from'	] = $param['date_from'];
		$data['date_to'		] = $param['date_to'];
		$data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
		$data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
		$data['nav'			] = $param['nav'];
		$data['total_cnt'	] = $totalCnt;
		$data['cancel_apply'] = "";
		$data['keyword'		] = "";
		$data['type'		] = "";

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		/**
		 * 퀵 레이아웃
		 */
		$this->load->library('quick_lib');
		$data['quick'] =  $this->quick_lib->get_quick_layer();

		$this->load->view('include/header', $data);
		$this->load->view('include/customer_nav');
		$this->load->view('mywiz/p_qna');
		$this->load->view('include/layout');
		$this->load->view('include/footer');

	}


	public function test_upload_get()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$date = date("YmdHis", time());
		var_dump($cust_no.$date);
		$this->load->view('customer/test');

//		var_dump(phpinfo());
	}


	/**
	 * 메일 작성
	 */
	private function _background_send_mail($param)
	{
		set_time_limit(0);

		$this->load->helper('url');
		$url = site_url("/customer/background_send_mail");

		$type = "POST";

		foreach ($param as $key => &$val) {
			if (is_array($val)) $val = implode(',', $val);
			$post_params[] = $key.'='.urlencode($val);
		}

		$post_string = implode('&', $post_params);

		$parts=parse_url($url);

		if ($parts['scheme'] == 'http') {
			$fp = fsockopen($parts['host'], isset($parts['port'])?$parts['port']:80, $errno, $errstr, 30);
		}
		else if ($parts['scheme'] == 'https') {
			$fp = fsockopen("ssl://" . $parts['host'], isset($parts['port'])?$parts['port']:443, $errno, $errstr, 30);
		}

		// Data goes in the path for a GET request
		if('GET' == $type) $parts['path'] .= '?'.$post_string;

		$out = "$type ".$parts['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$parts['host']."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-Length: ".strlen($post_string)."\r\n";
		$out.= "Connection: Close\r\n\r\n";

		// Data goes in the request body for a POST request
		if ('POST' == $type && isset($post_string)) $out.= $post_string;

		fwrite($fp, $out);
		fclose($fp);

	}

	public function background_send_mail_post()
	{
		set_time_limit(0);

        $param = $this->post();

		$this->load->helper('string');
		$this->load->library('email');

		$body = self::_mail_template($param['kind']); //메일 템플릿 가져오기

		//1:1문의 메일 발송
        if($param['kind'] == "qna"){
            $subject = "[ETAHOME] 고객님의 1:1문의가 정상적으로 등록되었습니다.";

			$body = str_replace("{{type}}"		, $param['type'	  ]	  , $body);
            $body = str_replace("{{name}}"		, $param['name'	  ]   , $body);
            $body = str_replace("{{phone}}"		, $param['phone'  ]   , $body);
			$body = str_replace("{{title}}"		, $param['title'  ]   , $body);
			$body = str_replace("{{content}}"	, $param['content']   , $body);
			$body = str_replace("{{date}}"		, $param['date'   ]   , $body);
            $body = str_replace("{{homepage}}"  , config_item('url')  , $body);
        }

        $receive = $param['email'];

		$this->email->sendmail($receive, $subject, $body, 'info@etah.co.kr', 'ETA HOME');
	}

	/**
	 * 메일 템플릿 가져오기
	 */
	private function _mail_template($type = 'join')
	{
		$body = $this->load->view('template/email/'.$type.'/email_body.php', '', TRUE);

		return $body;
	}

	public function test_email_get()
	{
		$this->load->view('template/email/qna/email_body');

	}

    /**
     * 문의 게시판
     * 2018.10.24
     */
    public function qna_list_all_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	 ] = $page;

//        var_dump($get_vars);
        //1:1문의 리스트 조회
        self::_qna_list_all($get_vars);
    }

    public function _qna_list_all($param)
    {
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 15 : $param['limit_num_rows'];
        $param['page'			] = empty($param['page'				]) ? 1  : $param['page'			];

        //공지사항 개수
        $totalCnt = $this->customer_m->get_qna_list_count($param);
        $qna_list = $this->customer_m->get_qna_list($param);


        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'customer/qna_list_all';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['qna_list'	] = $qna_list;
        $data['total_cnt'	] = $totalCnt;
        $data['page'		] = $param['page'];
        $data['sNum'		] = $param['limit_num_rows'];
        $data['keyword'		] = "";
        $data['type'		] = "QNA_LIST";

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];

        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        $this->load->view('include/header', $data);
        $this->load->view('include/customer_nav');
        $this->load->view('customer/qna_list');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

}
