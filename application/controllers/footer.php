<?php
/**
 * User: Joe, Yong June
 * Date: 2016/04/04
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends MY_Controller
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
        $this->load->model('footer_m');

        /* form */
        $this->load->helper(array('form','date','url'));

        /* form_validation */
        $this->load->library('form_validation');
    }


    /**
     * ETAH 소개
     */
    public function about_etah_get()
    {

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
        $this->load->view('template/footer/about_etah');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 이용약관
     */
    public function use_clause_get()
    {

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
        $this->load->view('template/footer/use_clause');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 개인정보 취급방침
     */
    public function personal_info_get()
    {

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
        $this->load->view('template/footer/personal_info');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 입점문의
     */
    public function inquiry_for_office_get()
    {
        $this->load->model('category_m');

        $data['category_list'] = $this->category_m->get_list_by_category();

//		var_dump($data['category_list']);

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
        $this->load->view('template/footer/inquiry_for_office');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 문의하기
     */
    public function inquiry_for_office_post()
    {
        /* 파라메타 체크 */
        $this->form_validation->set_rules('company_nm', '회사명', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '회사명을 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('post_no', '우편번호', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '우편번호를 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('post_no', '우편번호', 'numeric');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '정상적인 우편번호가 아닙니다.'), 200);
        }

        $this->form_validation->set_rules('address1', '주소', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '주소를 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('address2', '상세주소', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '상세주소를 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('brand_goods_nm', '브랜드/상품명', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '브랜드/상품명을 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('phone', '전화번호를', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '전화번호를 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('email', '이메일', 'required');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '이메일을 입력해주세요.'), 200);
        }

        $this->form_validation->set_rules('email', '이메일', 'valid_email');
        if( $this->form_validation->run() == FALSE ){
            $this->response(array('status' => 'err', 'message' => '유효한 이메일 주소가 아닙니다.'), 200);
        }

        $param = $this->input->post();
        if($param['category'] == 'write') $param['category'] = $param['category_write'];

		$param['company_desc'] = str_replace("'", "", $param['company_desc']);

        $office_id = $this->footer_m->register_que($param);

        //첨부파일 확인
        if($_FILES['fileUpload']['name']){
            $this->load->helper(array('form', 'url'));

            $image_path = '/webservice_root/etah_front/assets/uploads';

            if ( ! @is_dir($image_path)){
                $this->response(array('status' => 'error upload fail_comment_NO Directory'));
            }

            $config['upload_path'	] = $image_path;
            $config['allowed_types'	] = 'ppt|pptx|pdf';
            $config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
                $error = array('error' => $this->upload->display_errors());
                $this->response(array('status' => 'error', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
            }else{
                $data = $this->upload->data();
                //s3 파일전송
                $result = self::_s3_upload($data, $office_id);

                if($result){
                    $this->response(array('status' => 'ok', 'message' => '파일업로드 성공!'));
                } else {
                    $this->response(array('status' => 'ok', 'message' => '파일업로드 실패!'));
                }
            }
        } else {
            if(!empty($office_id)) {
                $this->response(array('status' => 'ok', 'message' => '입점문의 등록에 성공했습니다.'));
            } else {
                $this->response(array('status' => 'err', 'message' => '입점문의 등록에 실패했습니다.' ));
            }
        }
    }

    /**
     * s3 파일전송
     */
    public function _s3_upload($param, $office_id)
    {
        $date = date("YmdHis", time());

        $title = $office_id."_".$date."_".$param['raw_name'];

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_front/assets/uploads/'.$param['file_name']);

        if (S3::putObject($input, 'image.etah.co.kr', 'inquiry_for_office/'.$office_id.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
            $title = 'http://image.etah.co.kr/inquiry_for_office/'.$office_id.'/'.$title.$param['file_ext'];

            $result = $this->footer_m->update_que_file_path($title, $office_id);
            if($result) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 우편번호 찾기 레이어
     */
    public function search_address_post()
    {
        $this->load->model('cart_m');

        $param = $this->input->post();

        $data = array();
        $data['deliv_sido_list'	] = $this->cart_m->get_post_sido();		//주소찾기 시/도 select box data
        $data['gubun'			] = $param['gubun'];
        $search_address = $this->load->view('mywiz/search_address.php', $data, TRUE); //우편번호 검색

        $this->response(array('status' => 'ok', 'search_address'=>$search_address), 200);
    }



}