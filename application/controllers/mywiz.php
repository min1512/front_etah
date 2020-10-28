<?php

class Mywiz extends MY_Controller
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
        $this->load->model('mywiz_m');

        //비로그인 상태에서는 회원정보 페이지 접근 불가
        if(!$this->session->userdata('EMS_U_ID_')) redirect('/member/login', 'refresh');
    }


    public function index_get()
    {
        self::mypage_get();

    }

    /**
     * 마이페이지
     */
    public function mypage_get()
    {
        $data = array();
        $param= array();


        $param['gb'				] = "01";
        $param['date_type'		] = "-1";
        $param['page'			] = "1";
        $param['limit_num_rows'	] = 5;

        $data['qna_list'	] = $this->mywiz_m->get_qna_list($param);

        $param['limit_num_rows'	] = 3;
        $param['nav'			] = "";

        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();				//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();					//잔여 마일리지
        $data['nav'			] = $param['nav'];
//		$data['cancel_apply'] = $this->load->view('mywiz/cancel_apply.php', '', TRUE);	//취소신청

        $order = $this->mywiz_m->get_order_list($param);
        $cnt_order_refer = array();

        $order_no = "";
        foreach($order	as $row){
            if($order_no == $row['ORDER_NO']){
                $cnt_order_refer[$row['ORDER_NO']] ++;
            }else{
                $cnt_order_refer[$row['ORDER_NO']] = 1;
            }
            $order_no = $row['ORDER_NO'];
        }
        $data['cnt_order_refer'] = $cnt_order_refer;


        $data['order'		] = $order;
        $data['order_state'	] = $this->mywiz_m->get_order_state_by_cust_no();			//주문상태

        //외부결제인 경우
        if( $order[0]['ORDER_PAY_KIND_CD']=='09' ){
            $data['external'] = 'external';
        }

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/mypage');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 주문/배송조회
     */
    public function order_get()
    {
        $data = array();

        $data['title'		] = "주문/배송조회";
        $data['nav'			] = "OD";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 month"));
        $data['date_to'		] = date("Y-m-d", time());

        //주문 리스트 조회
        self::_order_list($data);
    }

    /**
     * 취소/반품/교환신청
     */
    public function apply_order_get()
    {
        $data = array();

        $data['title'		] = "취소/반품신청";
        $data['nav'			] = "OA";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 month"));
        $data['date_to'		] = date("Y-m-d", time());

        //주문 리스트 조회
        self::_order_list($data);

    }

    /**
     * 증빙서류발급
     */
    public function print_order_get()
    {
        $data = array();

        $data['title'		] = "증빙서류발급";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 month"));
        $data['date_to'		] = date("Y-m-d", time());
        $data['nav'			] = "OP";

        //주문 리스트 조회
        self::_order_list($data);

    }

    /**
     * 주문리스트 페이징
     */
    public function order_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'] = $page;

        //주문 리스트 조회
        self::_order_list($get_vars);
    }


    /**
     * 주문 리스트
     */
    public function _order_list($param)
    {
        $param['limit_num_rows'	] = 5;

        $totalCnt = $this->mywiz_m->get_order_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $order = $this->mywiz_m->get_order_list($param);								//최근주문
        $cnt_order_refer = array();
        $cnt_delivery	 = array();

        $order_no = "";
        $deli_no = "";
        foreach($order	as $row){
            if($order_no == $row['ORDER_NO']){
                $cnt_order_refer[$row['ORDER_NO']] ++;
            }else{
                $cnt_order_refer[$row['ORDER_NO']] = 1;
            }
            if(empty($cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']])){
                $cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']] = 0;
            }
            if($deli_no == $row['DELIV_POLICY_NO']){
                $cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']] ++;
            }else{
                $cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']] = 1;
            }
            $order_no = $row['ORDER_NO'];
            $deli_no = $row['DELIV_POLICY_NO'];
        }
        $data['cnt_order_refer'	] = $cnt_order_refer;
        $data['cnt_delivery'	] = $cnt_delivery;

//		var_dump($cnt_delivery);
//		var_dump($cnt_order_refer);

        //외부결제인 경우
        if( $order[0]['ORDER_PAY_KIND_CD']=='09' ){
            $data['external'] = 'external';
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/order_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();

        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();				//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();					//잔여 마일리지
        $data['reason_list'	] = $this->mywiz_m->get_cancel_return_reason();
//		$data['cancel_apply'] = $this->load->view('mywiz/cancel_apply.php', $data, TRUE); //취소신청
        $data['order'		] = $order;
        $data['title'		] = $param['title'];
        $data['nav'			] = $param['nav'];
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];


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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/order_delivery');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 주문상세
     */
    public function order_detail_get()
    {
        $order_no = $this->uri->segment(3);

        $data = array();

        $order = $this->mywiz_m->get_order_detail($order_no);

        $data['order'		] = $order[0];
        $data['order_dtl'	] = $order;
//		$data['cancel_apply'] = $this->load->view('mywiz/cancel_apply.php', '', TRUE); //취소신청
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
        $data['state_cd'	] = array('OC21','OC22','OR21','OR22');				//취반품 환불완료코드
        $data['nav'			] = "";

        //외부결제인 경우
        if( $order[0]['ORDER_PAY_KIND_CD']=='09' ){
            $data['external'] = 'external';
        }

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/order_detail');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }



    /**
     * 취소/반품/교환현황
     */
    public function current_order_get()
    {
        $data = array();

        $data['nav'			] = "OC";
        $data['title'		] = "취소/반품현황";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());

        //주문 현황 리스트 조회
        self::_current_order($data);
    }

    /**
     * 주문리스트 페이징
     */
    public function current_order_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'] = $page;

        //주문 현황 리스트 조회
        self::_current_order($get_vars);
    }

    /**
     * 환불/입금내역
     */
    public function deposit_order_get()
    {
        $data = array();

        $data['nav'			] = "OR";
        $data['title'		] = "환불/입금내역";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());

        //주문 현황 리스트 조회
        self::_current_order($data);
    }

    /**
     * 취소/반품/교환현황 리스트
     */
    public function _current_order($param)
    {
        $param['limit_num_rows'	] = 5;

        $totalCnt = $this->mywiz_m->get_order_cancel_return_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $order_list = $this->mywiz_m->get_order_cancel_return_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/current_order_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

        $data['order_list'	] = $order_list;
        $data['total_cnt'	] = $totalCnt;
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
        $data['nav'			] = $param['nav'];
        $data['title'		] = $param['title'];
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/order_cancel_return');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    /**
     * 관심상품
     */
    public function interest_get()
    {
        $data = array();
        $data['page'		] = 1;

        //관심상품 조회
        self::_interest_list($data);
    }

    /**
     * 관심상품 페이징
     */
    public function interest_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'] = $page;

        //관심상품 조회
        self::_interest_list($get_vars);
    }

    /**
     * 관심상품
     */
    public function _interest_list($param)
    {
        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_interest_list_count();

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }
        $wish_list = $this->mywiz_m->get_interest_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/interest_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
        $data['wish_list'		] = $wish_list;
        $data['total_cnt'		] = $totalCnt;
        $data['coupon'			] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'			] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
        $data['nav'				] = "I";
//		$data['cancel_apply'	] = "";

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/interest');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 관심상품 삭제
     */
    public function delete_interest_post()
    {
        $param = $this->input->post();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');

        if(!$this->mywiz_m->update_interest($param,'N')) $this->response(array('status' => 'error'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 관심상품 선택삭제
     */
    public function chk_delete_interest_post()
    {
        $param = $this->input->post();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');

        foreach($param['goodsArr'] as $row){
            $param['goods_cd'] = $row;
            if(!$this->mywiz_m->update_interest($param,'N')) $this->response(array('status' => 'error'), 200);
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 1:1문의
     */
    public function p_qna_get()
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
    public function p_qna_page_get($page = 1)
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
     * Q&A
     */
    public function qna_get()
    {
        $data = array();
        $data['gb'			] = '02';
        $data['gb_nm'		] = 'qna';
        $data['date_type'	] = '0';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());
        $data['nav'			] = "Q";

        //qna 리스트 조회
        self::_qna_list($data);
    }

    /**
     * Q&A 페이징
     */
    public function qna_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['gb'		] = '02';
        $get_vars['gb_nm'	] = 'qna';
        $get_vars['page'	] = $page;
        $get_vars['nav'		] = "Q";

        //qna 리스트 조회
        self::_qna_list($get_vars);
    }

    /**
     * 활동 및 문의 리스트
     */
    public function _qna_list($param)
    {
        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_qna_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $qna_list = $this->mywiz_m->get_qna_list($param);
//var_dump($totalPage);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/'.$param['gb_nm'].'_page';
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
//		$data['cancel_apply'] = "";
        $data['page'		] = $param['page'];
        $data['sNum'		] = $param['limit_num_rows'	];

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/'.$param['gb_nm']);
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 상품 문의 등록하기
     */
    public function qna_regist_post()
    {
        $param = $this->input->post();

        $this->load->model('member_m');

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        $member = $this->member_m->get_member_info_id($param['mem_id']);

        $param['mem_no'	] = $member['CUST_NO'];
        $param['mem_name'	] = $member['CUST_NM'];
        $param['mem_mobile'] = $member['MOB_NO'];
        $param['mem_email' ] = $member['EMAIL'];
        $param['date'		] = date("Y-m-d H:i:s", time());

        $qna_no = $this->mywiz_m->regist_qna($param, 'T');
        $param['qna_no'] = $qna_no;

        $qna_content	= $this->mywiz_m->regist_qna($param, 'C');
        $map_qna		= $this->mywiz_m->regist_map_qna_N_goods($param);

        $this->response(array('status' => 'ok'), 200);

    }

    /**
     * 상품 문의 수정하기
     */
    public function update_goods_qna_post()
    {
        $param = $this->input->post();

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        $this->mywiz_m->update_goods_qna($param);


        $this->response(array('status' => 'ok'), 200);

    }

    /**
     * 1:1문의 수정
     */
    public function modify_qna_get()
    {
        $this->load->model('customer_m');
        $data = array();
        $qna_no = $this->uri->segment(3);

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

        $data['gb_nm'		] = 'qna';
        $data['nav'			] = "PQ";
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
        $data['qna_type'	] = $this->customer_m->get_qna_type_list();			//문의상세구분

        $data['qna'			] = $this->mywiz_m->get_qna_detail($qna_no);		//문의내용
        $data['order'		] = $this->customer_m->get_order_list_by_customer($param);
        $data['total_cnt'	] = $totalCnt;
        $data['total_page'	] = $totalPage;

        $data['qna_no'		] = $qna_no;



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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/modify_qna');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 문의 삭제
     */
    public function delete_qna_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->delete_qna($param, 'DAT_CS');
        $this->mywiz_m->delete_qna($param, 'DAT_CS_CONTENTS_REPLY');

//		var_dump($param);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 선택 문의 삭제
     */
    public function chk_delete_qna_post()
    {
        $param = $this->input->post();
        $qParam = array();

        foreach($param['qnaArr'] as $qna_no){
            $qParam['qna_no'] = $qna_no;
            $this->mywiz_m->delete_qna($qParam, 'DAT_CS');
            $this->mywiz_m->delete_qna($qParam, 'DAT_CS_CONTENTS_REPLY');
        }

//		var_dump($param);

        $this->response(array('status' => 'ok'), 200);
    }


    /**
     * 마일리지
     */
    public function mileage_get()
    {
        $data = array();
        $data['date_type'] = '0';
        $data['date_from'] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'	 ] = date("Y-m-d", time());


        //마일리지 리스트 조회
        self::_mileage_list($data);
    }

    /**
     * 마일리지
     */
    public function mileage_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //마일리지 조회
        self::_mileage_list($get_vars);
    }

    /**
     * 마일리지 리스트
     */
    public function _mileage_list($param)
    {
        $data = array();

        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_mileage_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $mileage_list = $this->mywiz_m->get_mileage_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/mileage_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['mileage_list'] = $mileage_list;
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
        $data['nav'			] = "M";
//		$data['cancel_apply'] = "";

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/mileage');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 쿠폰
     */
    public function coupon_get()
    {
        $data = array();
        $data['goods_cd'] = "";

        //쿠폰 리스트 조회
        self::_coupon_list($data);
    }

    /**
     * 쿠폰 페이지
     */
    public function coupon_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //쿠폰조회
        self::_coupon_list($get_vars);
    }

    /**
     * 쿠폰 리스트
     */
    public function _coupon_list($param)
    {
        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];
        $param['last_coupon'	] = empty($param['last_coupon'		]) ? ""  : $param['limit_num_rows'];

        if($param['goods_cd'] && $param['goods_cd'] != 'undefined'){
            $totalCnt = $this->mywiz_m->get_coupon_count_search_by_goods_code($param);
        }else{
            $totalCnt = $this->mywiz_m->get_coupon_list_count($param);
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        if($param['goods_cd'] && $param['goods_cd'] != 'undefined'){
            $coupon_list = $this->mywiz_m->get_coupon_search_by_goods_code($param);
        }else{
            $coupon_list = $this->mywiz_m->get_coupon_list($param);
        }



        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/coupon_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['coupon_list'	] = $coupon_list;
        $data['last_coupon'	] = $param['last_coupon'];
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
        $data['goods_cd'	] = $param['goods_cd'];
        $data['nav'			] = "C";
//		$data['cancel_apply'] = "";
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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/coupon');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 배송지관리
     */
    public function delivery_get()
    {
        $data = array();

        //배송지관리 조회
        self::_delivery_list($data);
    }

    /**
     * 배송지관리 페이지
     */
    public function delivery_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //배송지관리 조회
        self::_delivery_list($get_vars);
    }

    /**
     * 배송지관리 리스트
     */
    public function _delivery_list($param)
    {

        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_delivery_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $delivery = $this->mywiz_m->get_delivery_list($param);					//배송지

        $idx=0;
        foreach($delivery as $row){
            $delivery[$idx]['arr_mob'] =  explode('-',$row['MOB_NO']);
            $idx++;
        }

//		var_dump($delivery);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/delivery_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['delivery'	] = $delivery;
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리
//		$data['cancel_apply'] = "";
        $data['nav'			] = "D";

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/delivery');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
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


    /**
     * 배송지등록
     */
    public function register_delivery_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->register_delivery($param);

//		var_dump($param);
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 배송지수정
     */
    public function update_delivery_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->update_delivery($param);

//		var_dump($param);
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 배송지삭제
     */
    public function delete_delivery_post()
    {
        $param = $this->input->post();

        if(!$this->mywiz_m->delete_delivery($param['deliv_no'])){
            $this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);

        }
        $this->response(array('status' => 'ok'), 200);

    }


    /**
     * 기본배송지 설정
     */
    public function base_delivery_post()
    {
        $param = $this->input->post();

        if(!$this->mywiz_m->update_base_delivery('N')){
            $this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
        }else{
            if(!$this->mywiz_m->update_base_delivery('Y',$param['deliv_no'])){
                $this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
            }else{
                $this->response(array('status' => 'ok'), 200);
            }
        }
    }

    /**
     * 비밀번호 확인
     */
    public function check_password_get()
    {
        $type  = $this->uri->segment(3);
        if($type){
            switch($type){
                case 'D' :	$data['title'] = '배송지관리'; break;
                case 'MI':	$data['title'] = '개인정보 수정'; break;
                case 'ML':	$data['title'] = '회원탈퇴'; break;
                case 'MS':	$data['title'] = '간편로그인 연동'; break;
            }
        }
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리
//		$data['cancel_apply'] = "";
        $data['nav'			] = $type;

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/check_password');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 비밀번호 확인
     */
    public function check_password_post()
    {
        //Load MODEL
        $this->load->model('member_m');

        $param = $this->input->post();

        $cust_id = $this->session->userdata('EMS_U_ID_');

        if($this->member_m->get_member_info_pw1($cust_id, $param['password'])){
            $this->response(array('status' => 'ok'), 200);
        }else{
            $this->response(array('status' => 'error', 'message' => '비밀번호가 일치하지 않습니다.'), 200);
        }
    }

    /**
     * 개인정보 수정
     */
    public function myinfo_get()
    {
        $data = array();

        $info = $this->mywiz_m->get_member_info_by_cust_no();	//회원정보
        $info['arr_email'] = explode('@',$info['EMAIL']);
        $info['arr_phone'] = explode('-',$info['MOB_NO']);

        if(empty($info['arr_phone'][1]) && empty($info['arr_phone'][2])){
            $info['arr_phone'][1] = "";
            $info['arr_phone'][2] = "";
        }

//		var_dump($info['arr_phone']);

        $data['info'		] = $info;
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리
//		$data['cancel_apply'] = "";
        $data['nav'			] = "MI";

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/modify_myinfo');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 이메일 중복확인
     */
    public function check_email_post()
    {
        $param = $this->input->post();

        if($this->mywiz_m->get_check_email($param['email'])){
            $this->response(array('status' => 'error', 'message'=>'이미 사용중인 이메일입니다.'), 200);
        }
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 개인정보 수정
     */
    public function myinfo_post()
    {
        $param = $this->input->post();

        if($param['member_birth1']){
            $param['member_birth'] = $param['member_birth1'].$param['member_birth2'].$param['member_birth3'];
        }else{
            $param['member_birth'] = "";
        }

        if($param['mob_phone2']){
            $param['mob_phone'] = $param['mob_phone1']."-".$param['mob_phone2']."-".$param['mob_phone3'];
        }else{
            $param['mob_phone'] = "";
        }

        if(!$param['mem_gender']){
            $param['mem_gender'] = 'NULL';
        }
        if(!$param['petYn']){
            $param['petYn'] = 'NULL';
        }
        if(!$param['merry']){
            $param['merry'] = 'NULL';
        }

        if(!$this->mywiz_m->update_member_info($param)){
            $this->response(array('status' => 'error', 'message'=>'잠시 후에 다시 시도하여 주시기 바랍니다.'), 200);
        }

        //추천인 적립
        if($param['chk_rcmdId'] != ''){
            $this->load->model('member_m');
            $this->member_m->insert_mileage_recommendId($param['chk_rcmdId']);
        }

        $this->response(array('status' => 'ok'), 200);

    }

    /**
     * 상품평
     */
    public function goods_comment_get()
    {
        $data = array();
        $data['date_type'	] = '0';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());

        //배송지관리 조회
        self::_goods_comment_list($data);
    }

    /**
     * 배송지관리 페이지
     */
    public function comment_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //배송지관리 조회
        self::_goods_comment_list($get_vars);
    }


    /**
     * 상품평 리즈스
     */
    public function _goods_comment_list($param)
    {
        $param['limit_num_rows'	] = 5;

        $totalCnt = $this->mywiz_m->get_goods_comment_count_by_cust($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/comment_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

        $data['comment'		] = $this->mywiz_m->get_goods_comment_by_cust($param);

        //상품평 첨부파일 가져오기
        for($i=0;$i<count($data['comment']);$i++){
            $iparam['comment_no'] = $data['comment'][$i]['CUST_GOODS_COMMENT'];
            $data['comment'][$i]['FILE_PATH'] = $this->mywiz_m->get_goods_comment_file($iparam);
        }

        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리
//		$data['cancel_apply'] = "";
        $data['nav'			] = "GM";
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];
//
//		var_dump($data['comment']);

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/goods_comment');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 상품평 수정하기
     */
    public function update_goods_comment_get()
    {
        $param            = $this->input->get();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');  //고객번호

        $data = array();

        $data['comment']               = $this->mywiz_m->get_goods_comment_detail($param);	//상품평
        $data['comment']['FILE_PATH']  = $this->mywiz_m->get_goods_comment_file($param); //상품평 첨부파일

        if($data['comment']) {
            $modify_comment = $this->load->view('mywiz/modify_goods_comment.php', $data, TRUE);		//상품평 수정

            $this->response(array('status' => 'ok', 'modify_comment'=>$modify_comment), 200);
        } else {
            $this->response(array('status' => 'fail', 'modify_comment'=>'Database Error'), 200);
        }
    }

    public function update_goods_comment_post()
    {
        $param = $this->input->post();

//		$param = str_replace("\\","\\\\\\",$param);
        $param = str_replace("\n", '<br />', $param);
        $param = str_replace("'","\'",$param);


        //첨부파일 확인 - 기존에 파일 있었음
        if($param['fileGb'] == "isEx") {
            //첨부파일 업로드
            if($_FILES['fileUpload2']['name']){

                $retUrl = array();

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_front/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg|png';

                $this->load->library('upload', $config);

                //파일 압축해서 하나씩 업로드
                for($a=0;$a<count($_FILES['fileUpload2']['tmp_name']);$a++) {
                    if($_FILES['fileUpload2']['name'][$a] != '') {
                        //파일 크기 5MB 이상 -> 압축안함
                        if ($_FILES['fileUpload2']['size'][$a] > 5500000) {
                            $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                        } //파일 크기 5MB 이하 -> 압축해서 업로드
                        else {

                            if ($_FILES['fileUpload2']['size'][$a] < 5500000 && $_FILES['fileUpload2']['size'][$a] > 2000000) {
                                $quality = 50;
                            } else {
                                $quality = 75;
                            }

                            $file_name = $_FILES['fileUpload2']['name'][$a];
                            $url = '/webservice_root/etah_front/assets/uploads/'.$file_name;


                            $info = getimagesize($_FILES['fileUpload2']['tmp_name'][$a]);

                            if ($info['mime'] == 'image/jpeg')
                                $image = imagecreatefromjpeg($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/gif')
                                $image = imagecreatefromgif($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/png')
                                $image = imagecreatefrompng($_FILES['fileUpload2']['tmp_name'][$a]);

                            imagejpeg($image, $url, $quality);


                            $rparam['file_name' ] = $_FILES['fileUpload2']['name'][$a];
                            $rparam['file_ext'  ] = '.jpg';


                            $retTitle = self::_s3_upload($rparam, $param['goods_comment_no']);

                            unlink($image_path.'/'.$file_name);

                            //파일 덮어씌우기
                            if($param['file_no2'][$a] != '') {
                                $this->mywiz_m->update_goods_comment_file_path($retTitle, $param['file_no2'][$a]);
                            }
                            //파일 새로추가
                            else {
                                $this->mywiz_m->insert_goods_comment_file_path($retTitle, $param['comment_cd']);
                            }
                        }
                    } else {
                        //기존 첨부파일 삭제
                        if($param['file_url2'][$a] == '') {
                            $this->mywiz_m->update_goods_comment_file_path('', $param['file_no2'][$a]);
                        }
                    }
                }

            }
        }
        //첨부파일 확인 - 기존에 파일 없었음 (새로등록)
        else {
            if($_FILES['fileUpload2']['name']){
                $retUrl = array();

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_front/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg|png';

                $this->load->library('upload', $config);


                //파일 압축해서 하나씩 업로드
                for($a=0;$a<count($_FILES['fileUpload2']['tmp_name']);$a++) {
                    if($_FILES['fileUpload2']['name'][$a] != '') {
                        //파일 크기 5MB 이상 -> 압축안함
                        if ($_FILES['fileUpload2']['size'][$a] > 5500000) {
                            $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                        } //파일 크기 5MB 이하 -> 압축해서 업로드
                        else {

                            if ($_FILES['fileUpload2']['size'][$a] < 5500000 && $_FILES['fileUpload2']['size'][$a] > 2000000) {
                                $quality = 50;
                            } else {
                                $quality = 75;
                            }

                            $file_name = $_FILES['fileUpload2']['name'][$a];
                            $url = '/webservice_root/etah_front/assets/uploads/'.$file_name;


                            $info = getimagesize($_FILES['fileUpload2']['tmp_name'][$a]);

                            if ($info['mime'] == 'image/jpeg')
                                $image = imagecreatefromjpeg($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/gif')
                                $image = imagecreatefromgif($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/png')
                                $image = imagecreatefrompng($_FILES['fileUpload2']['tmp_name'][$a]);

                            imagejpeg($image, $url, $quality);


                            $rparam['file_name' ] = $_FILES['fileUpload2']['name'][$a];
                            $rparam['file_ext'  ] = '.jpg';


                            $retTitle = self::_s3_upload($rparam, $param['goods_comment_no']);

                            unlink($image_path.'/'.$file_name);

                            $this->mywiz_m->insert_goods_comment_file_path($retTitle, $param['comment_cd']);
                        }
                    }
                }
            }
        }


        if(!$this->mywiz_m->update_goods_comment($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 상품평 수정이 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 상품평 수정하기
     */
    public function update_image_post()
    {
        $param = $this->input->post();

//		$this->response(array('status'=>'ok', 'message'=>$param),200);
//		var_dump($param['idx']);
//		var_dump($_FILES['fileUpload_'.$param['idx']]);
//		var_dump($param['comment_cd']);

        //첨부파일 확인
        if($_FILES['editFileUpload']['name']){

            $this->load->helper(array('form', 'url'));

            $image_path = '/webservice_root/etah_front/assets/uploads';

            if ( ! @is_dir($image_path)){
                $this->response(array('status' => 'error upload fail_qna_NO Directory'));
            }

            $config['upload_path'	] = $image_path;
            $config['allowed_types'	] = 'gif|jpg|jpeg';
            $config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['editFileUpload']['name']);

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload('editFileUpload')){ //업로드 에러시
                $error = array('error' => $this->upload->display_errors());
                $this->response(array('status' => 'error upload fail_comment', 'param' => $param, 'data' => $error, 'size' => $_FILES['editFileUpload']['size']));
            }else{
                $data = $this->upload->data();
//var_dump($data);
                //s3 파일전송
                self::_s3_upload($data, $param['comment_cd']);
            }
        }

//		if(!$this->mywiz_m->update_goods_comment($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 상품평 수정이 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 상품평 삭제
     */
    public function delete_goods_comment_post()
    {
        $param = $this->input->post();

        if(!$this->mywiz_m->delete_goods_comment($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 상품평 삭제가 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 상품평 등록하기 (상품상세페이지 하단에 위치)
     */
    public function comment_regist_post()
    {
        $mileage = 0;
        $param = $this->input->post();
        $param['grade_val'] = @$param['grade_val01'].@$param['grade_val02'].@$param['grade_val03'].@$param['grade_val04'].@$param['grade_val05'];

        $this->load->model('member_m');

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        $member = $this->member_m->get_member_info_id($this->session->userdata('EMS_U_ID_'));

        $param['mem_no'	    ] = $member['CUST_NO'];
        $param['mem_name'	] = $member['CUST_NM'];

        $comment_yn	= $this->mywiz_m->get_goods_order_refer($param);

        if(count($comment_yn) == 0){
            $this->response(array('status' => 'error', 'message' => '해당 상품을 구매하신 내역이 없습니다.'), 200);
            return false;
        }

        $param['order_refer_code'] = $comment_yn[0]['ORDER_REFER_NO'];

        for($i=0; $i<count($comment_yn); $i++){
            $exists_comment = $this->mywiz_m->get_exists_comment_order($param);

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

        $chk_mileage = $this->mywiz_m->get_exists_all_comment_order($param);
        $mileage_yn = $chk_mileage['cnt'];

        $payinfo = $this->mywiz_m->get_payinfo($param['order_refer_code']);
        $mileage_std = $payinfo['REAL_PAY_AMT'];

        $param['goods_comment_no'] = $this->mywiz_m->regist_comment($param);

        $mileage = 1000;

        //첨부파일 확인
        if($_FILES['fileUpload']['name']){
            $retUrl = array();

            $this->load->helper(array('form', 'url'));

            $image_path = '/webservice_root/etah_front/assets/uploads';

            if ( ! @is_dir($image_path)){
                $this->response(array('status' => 'error upload fail_NO Directory'));
            }

            $config['upload_path'	] = $image_path;
            $config['allowed_types'	] = 'gif|jpg|jpeg|png';

            $this->load->library('upload', $config);

            //파일 압축해서 하나씩 업로드
            for($a=0;$a<count($_FILES['fileUpload']['tmp_name']);$a++) {
                if($_FILES['fileUpload']['name'][$a] != '') {
                    //파일 크기 5MB 이상 -> 압축안함
                    if ($_FILES['fileUpload']['size'][$a] > 5500000) {
                        $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                    } //파일 크기 5MB 이하 -> 압축해서 업로드
                    else {

                        if ($_FILES['fileUpload']['size'][$a] < 5500000 && $_FILES['fileUpload']['size'][$a] > 2000000) {
                            $quality = 50;
                        } else {
                            $quality = 75;
                        }


                        $file_name = $_FILES['fileUpload']['name'][$a];
                        $url = '/webservice_root/etah_front/assets/uploads/'.$file_name;


                        $info = getimagesize($_FILES['fileUpload']['tmp_name'][$a]);

                        if ($info['mime'] == 'image/jpeg')
                            $image = imagecreatefromjpeg($_FILES['fileUpload']['tmp_name'][$a]);

                        elseif ($info['mime'] == 'image/gif')
                            $image = imagecreatefromgif($_FILES['fileUpload']['tmp_name'][$a]);

                        elseif ($info['mime'] == 'image/png')
                            $image = imagecreatefrompng($_FILES['fileUpload']['tmp_name'][$a]);

                        imagejpeg($image, $url, $quality);



                        $rparam['file_name' ] = $_FILES['fileUpload']['name'][$a];
                        $rparam['file_ext'  ] = '.jpg';


                        $retTitle = self::_s3_upload($rparam, $param['goods_comment_no']);

                        unlink($image_path.'/'.$file_name);

                        $this->mywiz_m->insert_goods_comment_file_path($retTitle, $param['goods_comment_no']);

                    }

                    $mileage = 2000;
                }
            }

        }

        //마일리지 적립해주기.
        $param['mileage'] = $mileage;
        if( ($mileage_std > 5000 ) && ($mileage_yn == 0) ) {
            $this->mywiz_m->insert_mileage_comment($param);
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

        $title = $cust_no.$date.$param['file_name'];

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_front/assets/uploads/'.$param['file_name']);
        if (S3::putObject($input, 'image.etah.co.kr', 'cust_goods_comment/'.$cust_no.'/'.$title, S3::ACL_PUBLIC_READ)) {

            $title = 'http://image.etah.co.kr/cust_goods_comment/'.$cust_no.'/'.$title;
//            $this->mywiz_m->update_goods_comment_file_path($title, $goods_comment_no);
        }else{
            $title = "";
        }

        return $title;
    }

    /**
     * 취소신청 레이어 오픈
     */
    public function cancel_apply_format_post()
    {
        $order_refer_no = $this->input->post('order_refer_no');

        $data['order'] = $this->mywiz_m->get_order_refer_detail($order_refer_no);

        $data['reason_list'	] = $this->mywiz_m->get_cancel_return_reason();

        $cancel_apply = $this->load->view('mywiz/cancel_apply.php', $data, TRUE); //취소신청


        $this->response(array('status' => 'ok', 'cancel_apply'=>$cancel_apply), 200);
    }

    /**
     * 취소신청
     */
    public function cancel_apply_post()
    {
        $param = $this->input->post();
        $kakao = array();

        $this->mywiz_m->update_cancel_return_ues_yn($param);
        if(!$cancel_return_no = $this->mywiz_m->register_order_cancel($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$progress_no = $this->mywiz_m->register_order_refer_progress($param, $cancel_return_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$this->mywiz_m->update_order_refer($param, $progress_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);

        //sms 발송
        $order_info = $this->mywiz_m->get_Orderinfo($param);
//        log_message('DEBUG','==============='.$order_info);
        $pay = $order_info['SELLING_PRICE'] * $param['qty'];
//        log_message('DEBUG','==============='.$pay);
        $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
        $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101814040516788575364';
        $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
        if($order_info['SENDER_MOB_NO'] != '') {
            $kakao['DEST_PHONE'] = str_replace('-', '', $order_info['SENDER_MOB_NO']);
        }else{
            $kakao['DEST_PHONE'] = str_replace('-', '', $order_info['RECEIVER_MOB_NO']);
        }
        $kakao['MSG'] ="[에타홈] 주문취소

주문이 취소되었습니다.
더 좋은상품을 제공해 드릴 수 있도록 노력하겠습니다!


▶상품명:".$order_info['GOODS_NM']."
▶주문번호:".$order_info['ORDER_NO']."
▶취소금액:".$order_info['REAL_PAY_AMT']."
".base_url()."mywiz/order_detail/".$order_info['ORDER_NO']."

※ 환불은 시스템에따라 영업시간을 기준으로 2~3일 정도 소요됩니다.";
//        $kakao['KAKAO_ATTACHED_FILE'] = null;
//        log_message('DEBUG','===========kakao msg'.$kakao['MSG']);
//        log_message('DEBUG','===========kakao msg'.$kakao['KAKAO_TEMPLATE_CODE']);
//        log_message('DEBUG','===========kakao msg'.$kakao['KAKAO_SENDER_KEY']);
//        log_message('DEBUG','===========kakao msg'.$kakao['DEST_PHONE']);
//        log_message('DEBUG','===========kakao msg'.$kakao['KAKAO_ATTACHED_FILE']);
        $sendSMS = $this->mywiz_m->send_sms_kakao($kakao);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 반품신청 레이어 오픈
     */
    public function return_apply_format_post()
    {
        $order_refer_no = $this->input->post('order_refer_no');

        $data['order'] = $this->mywiz_m->get_order_refer_detail($order_refer_no);

        $data['reason_list'		] = $this->mywiz_m->get_cancel_return_reason();
        $data['deli_list'		] = $this->mywiz_m->get_delivery_company();
        $data['return_type'		] = $this->mywiz_m->get_return_collection_type();
        $data['return_pay_type'	] = $this->mywiz_m->get_return_pay_type();

        $cancel_apply = $this->load->view('mywiz/return_apply.php', $data, TRUE); //취소신청


        $this->response(array('status' => 'ok', 'cancel_apply'=>$cancel_apply), 200);
    }

    /**
     * 반품신청
     */
    public function return_apply_post()
    {
        $param = $this->input->post();
//var_dumP($param);
        $this->mywiz_m->update_cancel_return_ues_yn($param);
        if(!$cancel_return_no = $this->mywiz_m->register_order_return($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$progress_no = $this->mywiz_m->register_order_refer_progress($param, $cancel_return_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$this->mywiz_m->update_order_refer($param, $progress_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok', 'return_no' => $cancel_return_no), 200);
    }

    /**
     * 반품신청 - 이미지첨부
     */
    public function return_apply_image_post()
    {
        $param = $this->input->post();

        $return_no = $param['return_no'];   //반품번호

        if($_FILES['fileUpload']['name']){
            $retUrl = array();

            $this->load->helper(array('form', 'url'));

            $image_path = '/webservice_root/etah_front/assets/uploads';

            if ( ! @is_dir($image_path)){
                $this->response(array('status' => 'error upload fail_NO Directory'));
            }

            $config['upload_path'	] = $image_path;
            $config['allowed_types'	] = 'gif|jpg|jpeg|png';

            $this->load->library('upload', $config);

            //파일 압축해서 하나씩 업로드
            for($a=0;$a<count($_FILES['fileUpload']['tmp_name']);$a++) {
                if($_FILES['fileUpload']['name'][$a] != '') {

                    //파일 크기 5MB 이상 -> 압축안함
                    if ($_FILES['fileUpload']['size'][$a] > 5500000) {
                        $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                    }

                    //파일 크기 5MB 이하 -> 압축해서 업로드
                    else {

                        if ($_FILES['fileUpload']['size'][$a] < 5500000 && $_FILES['fileUpload']['size'][$a] > 2000000) {
                            $quality = 50;
                        } else {
                            $quality = 75;
                        }


                        $file_name = $_FILES['fileUpload']['name'][$a];
                        $url = '/webservice_root/etah_front/assets/uploads/'.$file_name;


                        $info = getimagesize($_FILES['fileUpload']['tmp_name'][$a]);

                        if ($info['mime'] == 'image/jpeg')
                            $image = imagecreatefromjpeg($_FILES['fileUpload']['tmp_name'][$a]);

                        elseif ($info['mime'] == 'image/gif')
                            $image = imagecreatefromgif($_FILES['fileUpload']['tmp_name'][$a]);

                        elseif ($info['mime'] == 'image/png')
                            $image = imagecreatefrompng($_FILES['fileUpload']['tmp_name'][$a]);

                        imagejpeg($image, $url, $quality);



                        $rparam['file_name' ] = $_FILES['fileUpload']['name'][$a];
                        $rparam['file_ext'  ] = '.jpg';


                        $retTitle = self::_s3_upload_return($rparam, $return_no);

                        unlink($image_path.'/'.$file_name);

                        $this->mywiz_m->register_order_return_file_path($retTitle, $return_no);
                    }
                }
            }

        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * s3 파일전송 - 반품 첨부파일
     */
    public function _s3_upload_return($param, $return_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');
        $date = date("YmdHis", time());

        $title = $return_no.'_'.$date.'_'.$param['file_name'];

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_front/assets/uploads/'.$param['file_name']);
        if (S3::putObject($input, 'image.etah.co.kr', 'cancel_return/'.$cust_no.'/'.$return_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
            $title = 'http://image.etah.co.kr/cancel_return/'.$cust_no.'/'.$return_no.'/'.$title.$param['file_ext'];
        }else{
            $title = "";
        }

        return $title;
    }

    /**
     * 증빙서류 영수증
     */
    public function print_receipt_post()
    {
        $order_no = $this->input->post('order_no');

        $order = $this->mywiz_m->get_order_detail($order_no);

        $idx = strlen($order[0]['TOTAL_PAY_SUM']);
        $pidx = 0;
        $arr_total_pay = array();

        for($i=1; $i<=9; $i++){
            if($i > (9-$idx)){
                $arr_total_pay[$i] = substr($order[0]['TOTAL_PAY_SUM'],$pidx,1);
                $pidx ++;
            }else{
                $arr_total_pay[$i] = "&nbsp;";
            }
        }

//		for($i=8; $i<=0; $i--){
//			if($idx > $i){


        $data['arr_total_pay'] = $arr_total_pay;

//		var_dump($arr_total_pay);

        $data['order'		] = $order[0];
        $data['order_dtl'	] = $order;

        $receipt = $this->load->view('mywiz/print_receipt.php', $data, TRUE); //영수증


        $this->response(array('status' => 'ok', 'receipt'=>$receipt), 200);
    }

    /**
     * 카드매출전표
     */
    public function print_card_statement_post()
    {
        $order_no = $this->input->post('order_no');

        $order = $this->mywiz_m->get_order_detail($order_no);


        $order = $order[0];
//		$data['order_dtl'	] = $order;

//var_dump($data['order']);
//		$data['card_statement'] = $this->load->view('mywiz/print_card_statement.php', $data, TRUE); //영수증


        $this->response(array('status' => 'ok', 'order'=>$order), 200);
    }

    /**
     * 현금영수증
     */
    public function print_cash_receipt_post()
    {
        $order_no = $this->input->post('order_no');

        $order = $this->mywiz_m->get_order_detail($order_no);


        $data['order'		] = $order[0];
//		$data['order_dtl'	] = $order;

        $card_statement = $this->load->view('mywiz/print_card_statement.php', $data, TRUE); //영수증


        $this->response(array('status' => 'ok', 'card_statement'=>$card_statement), 200);
    }

    /**
     * SNS연동
     */
    public function sns_get()
    {
        $data = array();

        $info    = $this->mywiz_m->get_member_info_by_cust_no();	//회원정보
        $snsinfo = $this->mywiz_m->get_snsdata();
        $info['arr_email'] = explode('@',$info['EMAIL']);
        $info['arr_phone'] = explode('-',$info['MOB_NO']);

        if(empty($info['arr_phone'][1]) && empty($info['arr_phone'][2])){
            $info['arr_phone'][1] = "";
            $info['arr_phone'][2] = "";
        }

        $data['info'		] = $info;
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리
        $data['sns_data'    ] = $snsinfo['SNS_KIND_CD'];
        $data['nav'			] = "MS";

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
        $this->load->view('include/mypage_nav', $data);
        $this->load->view('mywiz/mywiz_sns');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

}