<?php

class Magazine extends MY_Controller
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

        /* model_m */
        $this->load->model('magazine_m');
        $this->load->model('member_m');
    }

    public function index_get()
    {
        $data = array();
        self::main_get($data);

    }

    /**
     * 매거진 리스트 메인화면
     */
    public function main_get()
    {
        //매거진 카테고리
        $row = $this->magazine_m->get_list_by_magazineCategory('');
        for($i=0;$i<count($row);$i++) {
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_NM'];
            $row2 = $this->magazine_m->get_list_by_magazineCategory($row[$i]['CATEGORY_CD']);
            for($j=0;$j<count($row2);$j++) {
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'            ] = $arrCate;

        ///매거진 리스트
        $count = array();
        for($i=0;$i<count($arr_cate_cd1);$i++) {
            $count[$i] = $this->magazine_m->get_magazine_list_count('M', $arr_cate_cd1[$i]);    //매거진 총개수
        }

        $data['count'] = $count;

        $data['homejok' ] = $this->magazine_m->get_magazine_list('T', '', '40000000', ''); //홈족피디아
        $data['trend'   ] = $this->magazine_m->get_magazine_list('T', '', '50000000', ''); //트렌드매거진
        $data['class'   ] = $this->magazine_m->get_magazine_list('T', '', '70000000', ''); //에타클래스
        $data['brand'   ] = $this->magazine_m->get_magazine_list('T', '', '60000000', ''); //브랜드소개
        $data['event'   ] = $this->magazine_m->get_magazine_list('T', '', '90000000', ''); //이벤트



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
        $this->load->view('magazine/magazine_main_list');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }


    /**
     * 중카 매거진 리스트
     */
    public function mid_list_get() {
        $cate_cd        = $this->uri->segment(3);
        $param['page']  = $this->uri->segment(5);

        $data['category'] = $this->magazine_m->get_category_info($cate_cd); //카테고리 정보

        $param['limit_num_rows'	] = 16;
        $totalCnt = $this->magazine_m->get_magazine_list_count('M', $cate_cd);  //매거진 총개수
        $data['totalCnt'] = $totalCnt;

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //정렬기준
        $order = $this->input->get();
        $order_by = $order['kind'];
        if(empty($order_by)) {$order_by = 'A';}

        $data['order'] = $order_by;
        $data['list'] = $this->magazine_m->get_magazine_list('M', $param, $cate_cd, $order_by);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'magazine/mid_list/'.$cate_cd.'/magazine_page';
        $config['uri_segment'	] = '5';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

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


        /**
         * 매거진 카테고리
         */
        $row = $this->magazine_m->get_list_by_magazineCategory('');
        for($i=0;$i<count($row);$i++) {
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_NM'];
            $row2 = $this->magazine_m->get_list_by_magazineCategory($row[$i]['CATEGORY_CD']);
            for($j=0;$j<count($row2);$j++) {
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'            ] = $arrCate;

        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_mid_list');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }


    /**
     * 소카 매거진 리스트
     */
    public function list_get() {
        $cate_cd        = $this->uri->segment(3);
        $param['page']  = $this->uri->segment(5);

        $data['category'] = $this->magazine_m->get_category_info($cate_cd);     //카테고리정보

        $param['limit_num_rows'	] = 16;
        $totalCnt = $this->magazine_m->get_magazine_list_count('S', $cate_cd);  //매거진 총개수
        $data['totalCnt'] = $totalCnt;

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //정렬기준
        $order = $this->input->get();
        $order_by = $order['kind'];
        if(empty($order_by)) $order_by = 'A';

        $data['order'] = $order_by;
        $data['list'] = $this->magazine_m->get_magazine_list('S', $param, $cate_cd, $order_by);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'magazine/list/'.$cate_cd.'/magazine_page';
        $config['uri_segment'	] = '5';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

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

        /**
         * 매거진 카테고리
         */
        $row = $this->magazine_m->get_list_by_magazineCategory('');
        for($i=0;$i<count($row);$i++) {
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_NM'];
            $row2 = $this->magazine_m->get_list_by_magazineCategory($row[$i]['CATEGORY_CD']);
            for($j=0;$j<count($row2);$j++) {
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'            ] = $arrCate;


        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_list');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }


    /**
     * 매거진 컨텐트
     */
    public function detail_get()
    {
        $data = array();
        $magazine_no = $this->uri->segment(3);
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $data['magazine'    ] = $this->magazine_m->get_magazine_contents($magazine_no);
        $data['detail'      ] = $this->magazine_m->get_detail($magazine_no);

        $love_check = $this->magazine_m->magazine_love_chk($magazine_no, $cust_no);
        if($love_check != 0) $data['heart'] = 'Y';

        $paging_limit	= 5;
        $magazine_comment_num = $data['detail']['COMMENT_CNT'];	//매거진 댓글 전체 갯수 불러오기
        $data['magazine_comment'] = $this->magazine_m->get_magazine_comment_list($magazine_no, 1, $paging_limit);	//댓글 불러오기

        //페이징 구성
        $data['page'		] = 1;		//현재페이지
        $data['total_page'	] = ceil($magazine_comment_num / $paging_limit);	//전체 페이지 갯수
        $data['limit_num'	] = $paging_limit;					//한 페이지에 보여주는 갯수


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

        /**
         * 매거진 카테고리
         */
        $row = $this->magazine_m->get_list_by_magazineCategory('');
        for($i=0;$i<count($row);$i++) {
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_NM'];
            $row2 = $this->magazine_m->get_list_by_magazineCategory($row[$i]['CATEGORY_CD']);
            for($j=0;$j<count($row2);$j++) {
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'            ] = $arrCate;

        //카테고리 코드(구분)
        $cateGubun = substr($data['detail']['CATEGORY_CD2'],0,1);
        $data['categoryGubun'  ] = $cateGubun;

        $param['magazine_no'   ] = $magazine_no;
        $param['brand_cd'      ] = $data['detail']['BRAND_CD'];

        if($cateGubun == 4 || $cateGubun == 5 || $cateGubun == 6) {
            $data['magazineGoods'] = $this->magazine_m->get_goods('M', $param); // 매거진에 나온 상품
        } else if($cateGubun == 7) {
            $data['magazineGoods'] = $this->magazine_m->get_goods('G', $param); //공방 상품
        }

        // 관련 상품 추천
        for($i=0;$i<count($data['magazineGoods']);$i++) {
            $category[$i] = $data['magazineGoods'][$i]['CATEGORY_CD'];
            $goods[$i] = $data['magazineGoods'][$i]['GOODS_CD'];
        }
        $param['category'   ] = implode(', ', array_unique($category));
        $param['goods'      ] = implode(', ', array_unique($goods));

        if($param['category'] && $param['goods'])  {
            $data['magazineAboutGoods'] = $this->magazine_m->get_goods('R', $param);
        }

        // 다른 매거진 더보기
        $data['otherMagazine'] = $this->magazine_m->get_other_magazine($data['detail']['CATEGORY_CD2'], $magazine_no);

        $data['wrap__vip'] = 'wrap__vip';
        $data['op_gb'] = 'magazine';

        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_detail');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    /**
     *  매거진 댓글 페이징
     */
    public function comment_paging_post()
    {
        $param			= $this->input->post();

        $magazine_no	= $param['magazine_no'];
        $page			= $param['page'];
        $limit			= $param['limit'];

        $magazine_comment = $this->magazine_m->get_magazine_comment_list($magazine_no, $page, $limit);

        $this->response(array('status' => 'ok', 'comment' => $magazine_comment), 200);
    }

    /**
     * 매거진 좋아요
     */
    public function magazine_love_post()
    {
        $param          = $this->input->post();
        $member_no		= $this->session->userdata('EMS_U_NO_');
        $magazine_no	= $param['magazine_no'];

        //좋아요 여부 확인
        $love_check = $this->magazine_m->magazine_love_chk($magazine_no, $member_no);

        if($love_check == 0) {
            if($this->magazine_m->magazine_love($magazine_no, $member_no, 'Y')) {
                $this->response(array('status' => 'ok'), 200);
            } else {
                $this->response(array('status' => 'error', 'message' => '잠시후 다시 시도해주세요'), 200);
            }
        }
        else {
            if($this->magazine_m->magazine_love($magazine_no, $member_no, 'N')) {
                $this->response(array('status' => 'ok'), 200);
            } else {
                $this->response(array('status' => 'error', 'message' => '잠시후 다시 시도해주세요'), 200);
            }
        }
    }

    /**
     * 매거진 공유하기
     */
    public function magazine_share_post()
    {
        $param = $this->input->post();

        $this->magazine_m->magazine_share($param['magazine_no']);
    }

    /**
     * 매거진 댓글 등록
     */
    public function comment_regist_post()
    {
        $param                      = $this->input->post();
        $param['mem_no']		    = $this->session->userdata('EMS_U_NO_');

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        //첨부파일 확인
        if($_FILES['fileUpload']['name']){
            $this->load->helper(array('form', 'url'));

            $image_path = '/webservice_root/etah_front/assets/uploads';

            if ( ! @is_dir($image_path)){
                $this->response(array('status' => 'error upload fail_comment_NO Directory'));
            }

            $config['upload_path'	] = $image_path;
            $config['allowed_types'	] = 'gif|jpg|jpeg';
            $config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
                $error = array('error' => $this->upload->display_errors());
                $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
            }else{
                $data = $this->upload->data();
                //s3 파일전송
                $param['file_url'] = self::_s3_upload($data);

                if(!$param['file_url']) {
                    $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
                }
            }
        }

        if( $this->magazine_m->regist_comment($param) ) {
            $this->response(array('status' => 'ok', 'message'=>'댓글 등록 성공!'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message'=>'잠시 후 다시 시도해주세요.'), 200);
        }

    }

    /**
     * 매거진 댓글 수정 레이어
     */
    public function comment_update_layer_post()
    {
        $param = $this->input->post();
        $data = array();

        $data['comment_no'	] = $param['comment_no'];
        $data['comment'		] = $this->magazine_m->get_magazine_comment($param['comment_no']);

        $data['comment']['CONTENTS'] = str_replace("<br />", "\n", $data['comment']['CONTENTS']);

        if($data['comment']) {
            $modify_comment = $this->load->view('mywiz/modify_magazine_comment.php', $data, TRUE);
            $this->response(array('status' => 'ok', 'modify_comment'=>$modify_comment), 200);
        } else {
            $this->response(array('status' => 'fail', 'message'=>'수정할 수 없는 댓글 입니다.'), 200);
        }

    }

    /**
     * 매거진 댓글 수정
     */
    public function comment_update_post()
    {
        $param                      = $this->input->post();
        $param['mem_no']		    = $this->session->userdata('EMS_U_NO_');

        $param['comment_txt'] = str_replace("\\","\\\\",$param['comment_txt']);
        $param['comment_txt'] = str_replace("'","\'",$param['comment_txt']);
        $param['comment_txt'] = str_replace("\n","<br />",$param['comment_txt']);

        //매거진 상세페이지 댓글 수정
        if($param['gubun'] == 'A')  $param['file_url'] = '';

        //매거진 이벤트 상세페이지 댓글 수정
        else if($param['gubun'] == 'B') {
            //첨부파일 확인
            if($_FILES['fileUpload']['name']){
                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_front/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_comment_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg';
                $config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

                $this->load->library('upload', $config);

                if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
                    $error = array('error' => $this->upload->display_errors());
                    $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
                }else{
                    $data = $this->upload->data();
                    //s3 파일전송
                    $param['file_url'] = self::_s3_upload($data);

                    if(!$param['file_url']) {
                        $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
                    }
                }
            }
        }

        if( $this->magazine_m->update_comment($param) ) {
            $this->response(array('status' => 'ok', 'message'=>'댓글 등록 성공!'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => '수정 실패하였습니다. 잠시 후 다시 시도해주세요.'), 200);
        }
    }

    /**
     * s3 파일전송
     */
    public function _s3_upload($param)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');
        $date = date("YmdHis", time());

        $title = $cust_no.$date;

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_front/assets/uploads/'.$param['file_name']);
        if (S3::putObject($input, 'image.etah.co.kr', 'magazine_comment/'.$cust_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
//			echo "File uploaded.";

            $title = 'http://image.etah.co.kr/magazine_comment/'.$cust_no.'/'.$title.$param['file_ext'];

            return $title;
        } else {
            return false;
        }
    }


    /**
     * 매거진 댓글 삭제
     */
    public function comment_delete_post()
    {
        $param = $this->input->post();

        if($this->magazine_m->delete_comment($param)) {
            $this->response(array('status' => 'ok', 'message' => '삭제 성공!'), 200);
        } else {
            $this->response(array('status' => 'error', 'message' => '삭제 실패!'), 200);
        }

    }

    /**
     * 매거진 상품 모아보기
     */
    public function goods_plus_get()
    {
        $param = $this->input->get();
        $param['magazine_no'] = $param['magazineCode'];
        $data['cate_cd'] = $param['category'];

        $param['limit_num_rows'	] = 16;
        $data['totalCnt'] = $this->magazine_m->get_magazine_plus_count($param);

        if(empty($param['page'])) $param['page'] = 1;
        $data['goodsList'] = $this->magazine_m->get_goods('M', $param);


        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'magazine/goods_plus?magazineCode='.$param['magazineCode'].'&category='.$param['cate_cd'];
        $config['total_rows'	] = $data['totalCnt'];
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['page_query_string'] = true;
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

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

        /**
         * 매거진 카테고리
         */
        $row = $this->magazine_m->get_list_by_magazineCategory('');
        for($i=0;$i<count($row);$i++) {
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_NM'];
            $row2 = $this->magazine_m->get_list_by_magazineCategory($row[$i]['CATEGORY_CD']);
            for($j=0;$j<count($row2);$j++) {
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'            ] = $arrCate;


        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_goods');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

}
?>