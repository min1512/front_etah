<?php

class Goods2 extends MY_Controller
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
        $this->load->model('goods2_m');
        $this->load->model('goods_m');
    }

    /**
     * 카테고리 소분류 상품 리스트
     */
    public function list_get()
    {
        $data = array();
        $data['cate_cd'	] = $this->uri->segment(3);
        $data['type'	] = 'lp';
        $data['cate_gb'	] = 'S';

        //카테고리 상품조회
        self::_goods_list($data);
    }

    /**
     * 카테고리 중분류 상품 리스트
     */
    public function mid_list_get()
    {
        $data = array();
        $data['cate_cd'	] = $this->uri->segment(3);
        $data['type'	] = 'lp';
        $data['cate_gb'	] = 'M';

        //카테고리 상품조회
        self::_goods_list($data);
    }

    /**
     * 카테고리 상품 리스트 페이징
     */
    public function page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page']	= $page;
        $get_vars['type'] = 'lp';

        //카테고리 상품조회
        self::_goods_list($get_vars);
    }

    /**
     * 상품검색
     */
    public function search_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'] = $page;
        $get_vars['type'] = 'srp';

        //카테고리 상품조회
        self::_goods_list($get_vars);
    }

    /**
     * 상품검색 페이징
     */
    public function search_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'] = $page;
        $get_vars['type'] = 'srp';

        //카테고리 상품조회
        self::_goods_list($get_vars);
    }

    /**
     * 카테고리 상품 리스트
     */
    public function _goods_list($param)
    {
        /* model_m */
        $this->load->model('category_m');

        $data = array();
        //카테고리 리스트
        if($param['type'] == 'lp'){
            $arrCate = array();
            $category = $this->category_m->get_category_detail($param['cate_cd'], $param['cate_gb']);
//var_dump($category);
            //카테고리 네비게이션
            $row = $this->category_m->get_list_by_category($category['CATE_CODE1']);
            for($i=0; $i<count($row); $i++){
                $arr_cate_cd1[$i] = $row[$i]['CATEGORY_DISP_CD'];
                $arr_cate_nm1[$i] = $row[$i]['CATEGORY_DISP_NM'];
                $row2 = $this->category_m->get_list_by_category($row[$i]['CATEGORY_DISP_CD']);
                for($j=0; $j<count($row2); $j++){
                    $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_DISP_CD'];
                    $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_DISP_NM'];
                }
            }
            $arrCate['CATEGORY_CD1'	] = $arr_cate_cd1;
            $arrCate['CATEGORY_NM1'	] = $arr_cate_nm1;
            $arrCate['CATEGORY_CD2'	] = $arr_cate_cd2;
            $arrCate['CATEGORY_NM2'	] = $arr_cate_nm2;

            $data['url'] = "page";

            if($param['cate_gb'] == 'S'){		//소분류
                $cate_attr = $this->category_m->get_category_attr($param['cate_cd']);
                $category_list = "";
            }else if($param['cate_gb'] == 'M'){	//중분류
                $cate_attr = "";
                $category_list = $this->category_m->get_list_by_category($param['cate_cd']);
            }
            $data['category_attr'] = $cate_attr;
            $data['category_list'] = $category_list;

//			var_dump($data['category_attr']);
//var_dump($arrCate);

        }
        //검색결과
        else if($param['type'] == 'srp'){
            $category['CATE_CODE3'] = $param['cate_cd'];
            //검색결과 카테고리 네비게이션
            $arrCate = $this->goods2_m->get_category_list_by_search($param);
            $data['url'] = "search_page";

        }

        $param['keyword'		] = empty($param['keyword'			]) ? ''	 : $param['keyword'		  ];
        $param['r_keyword'		] = empty($param['r_keyword'		]) ? ''	 : $param['r_keyword'	  ];
        $param['cate_cd'		] = empty($param['cate_cd'			]) ? ''	 : $param['cate_cd'		  ];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];
        $param['brand_cd'		] = empty($param['brand_cd'			]) ? ''	 : $param['brand_cd'	  ];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'	  ];
        $param['attr'			] = empty($param['attr'				]) ? ''	 : $param['attr'		  ];
        $param['arr_cate'		] = empty($param['arr_cate'			]) ? ''	 : $param['arr_cate'	  ];

        //상품개수
        $totalCnt = $this->goods2_m->get_goods_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //상품리스트
        $goodsList = $this->goods2_m->get_goods_list($param);
        //브랜드개수
        $brand_cnt = $this->goods2_m->get_brand_goods_count($param);

//		if($param['r_keyword']) $param['keyword'] = $param['r_keyword'];

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods2/'.$data['url'];
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
        $data['type'			] = $param['type'			];
        $data['page'			] = $param['page'			];
        $data['keyword'			] = $param['keyword'		];
        $data['r_keyword'		] = $param['r_keyword'		];
        $data['price_limit'		] = $param['price_limit'	];
        $data['brand_cd'		] = $param['brand_cd'		];
        $data['order_by'		] = $param['order_by'		];
        $data['limit'			] = $param['limit_num_rows'	];
        $data['attr_cd'			] = $param['attr'			];
        $data['cate_cd'			] = $param['cate_cd'		];
        $data['arr_cate'		] = $param['arr_cate'		];
        $data['nav'				] = $arrCate;
        $data['category'		] = $category;
        $data['goods'			] = $goodsList;
        $data['total_cnt'		] = $totalCnt;
        $data['brand_cnt'		] = $brand_cnt;
        $data['search_cnt'		] = empty($param['search_cnt']) ? $totalCnt : $param['search_cnt'];
        $data['cate_gb'			] = $param['cate_gb'];
//		$data['brand_cnt'		] = $this->category_m->get_test_brand();

//var_Dump($param['attr']);

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
        $this->load->view('goods/category_list');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    /**
     * 브랜드샵
     */
    public function brand_get()
    {
        $data['brand_cd' ] = $this->uri->segment(3);
        $data['cate_cd'  ] = "";
        $data['order_by' ] = "";
        $data['keyword'	 ] = "";
        $data['r_keyword'] = "";
        $data['gubun'	 ] = "N";

        //브랜드 상품조회
        self::_brand_goods_list($data);
    }

    /**
     * 브랜드샵 페이징
     */
    public function brand_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	 ] = $page;
        $get_vars['cate_cd'	 ] = "";
        $get_vars['order_by' ] = "";
        $get_vars['r_keyword'] = "";
        $get_vars['gubun'	 ] = "Y";

        //카테고리 상품조회
        self::_brand_goods_list($get_vars);
    }

    /**
     * 브랜드샵 상품리스트
     */
    public function _brand_goods_list($param)
    {
        $data = array();

        $brand = $this->goods2_m->get_brand_detail($param['brand_cd']);

        $param['keyword'		] = empty($param['keyword'			]) ? ''	 : $param['keyword'		  ];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 40  : $param['limit_num_rows'];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'	  ];
        $param['attr'			] = empty($param['attr'				]) ? ''	 : $param['attr'		  ];

        //상품개수
        $totalCnt = $this->goods2_m->get_goods_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //상품리스트
        $goodsList = $this->goods2_m->get_goods_list($param);


        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods2/brand_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
        $data['page'			] = $param['page'			];
        $data['keyword'			] = $param['keyword'		];
        $data['price_limit'		] = $param['price_limit'	];
        $data['brand_cd'		] = $param['brand_cd'		];
        $data['order_by'		] = $param['order_by'		];
        $data['limit'			] = $param['limit_num_rows'	];
        $data['gubun'			] = $param['gubun'			];
        $data['brand'			] = $brand;
        $data['goods'			] = $goodsList;
        $data['total_cnt'		] = $totalCnt;


//var_Dump($param);

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
        $this->load->view('goods/brand_shop');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    /**
     * Goods Acount 클릭시
     */
    public function goods_action_post()
    {
        /* model_m */
        $this->load->model('mywiz_m');

        $param = $this->input->post();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');

        //CART 담기
        if($param['mode'] == 'C'){
        }
        //WISH LISH 담기
        else if($param['mode'] == 'W'){
            if($this->mywiz_m->get_wish_list_by_cust_no_n_goods_cd($param, 'Y')){
                $this->response(array('status' => 'error', 'message' => '이미 관심상품에 등록된 상품입니다.'), 200);
            }
            if($this->mywiz_m->get_wish_list_by_cust_no_n_goods_cd($param, 'N')){
                if(!$this->mywiz_m->update_interest($param, 'Y'))	$this->response(array('status' => 'error', 'message' => '이미 관심상품에 등록된 상품입니다.'), 200);
            }else if(!$this->mywiz_m->register_add_wish_list($param)){
                $this->response(array('status' => 'error', 'message' => '잠시 후 다시 시도하여 주시기 바랍니다.'), 200);
            }

        }
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 검색결과 리스트
     */
    public function goods_search2_get()
    {
        $param = $this->input->get();

        $param['attr'			] = "";
        $param['brand_nm'		] = empty($param['brand_nm'			]) ? ''  : $param['brand_nm'];
        $param['cate_nm'		] = empty($param['cate_nm'			]) ? ''  : $param['cate_nm'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'];
        $param['page'			] = $this->uri->segment(3);

//		$category['CATE_CODE3'] = $param['cate_cd'];
        $keyword = $param['keyword'];

        /* 결과 내 재검색 */
        if($param['r_keyword']){
            $keyword = str_replace('||','&',$param['r_keyword']);
        }

//		var_dump($keyword);

//		//검색결과 카테고리 네비게이션
//		$arrCate = $this->goods2_m->get_category_list_by_search($param);

        //브랜드개수
//		$brand_cnt = $this->goods2_m->get_brand_goods_count($param);


        /* 페이징 */
        $limit_num_rows	= "10000";
        $startPos = ($param['page']-1) * $limit_num_rows;


//		$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&q.options={fields:['goods_nm^5','brand_nm^2']}&return=_all_fields,_score";

        $strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score";

//		$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("두닷")."&size=20&start=0&sort=goods_sort_score+desc&return=_all_fields,_score";

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);

        $search_data = json_decode($result, true);
        $totalCnt = $search_data['hits']['found'];

//		var_dump( json_decode($result, true) ).PHP_EOL;

        $arr_brand = array();
        $arr_brand_nm = array();

        //브랜드 그룹
        $bidx = 0;
        foreach($search_data['hits']['hit'] as $brow){
            $arr_brand[$bidx] = $brow['fields']['brand_nm'];
            $bidx ++;
        }

        //브랜드별 상품개수 담음
        if($arr_brand){
            asort($arr_brand);

            $str_brand = $arr_brand[0];
            $arr_brand_nm[$str_brand] = 0;

            foreach($arr_brand as $brand){
                if($str_brand == $brand){
                    $arr_brand_nm[$brand] ++;
                }else{
                    $str_brand = $brand;
                    $arr_brand_nm[$brand] = 1;
                }
            }
        }

        $arr_cate = array();
        $arr_cate_nm = array();

        //카테고리 그룹
        $cidx = 0;
        foreach($search_data['hits']['hit'] as $crow){
            @$arr_cate[$cidx] = $crow['fields']['category_1_nm'];
            $cidx ++;
        }

        //카테고리별 상품개수 담음
        if($arr_cate){
            asort($arr_cate);

            $str_cate = $arr_cate[0];
            $arr_cate_nm[$str_cate] = 0;

            foreach($arr_cate as $cate){
                if($str_cate == $cate){
                    $arr_cate_nm[$cate] ++;
                }else{
                    $str_cate = $cate;
                    $arr_cate_nm[$cate] = 1;
                }
            }
        }

//		var_dump($arr_cate_nm);

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];

        /* 페이징 */
        $startPos = ($param['page']-1) * $param['limit_num_rows'];
        $limit_num_rows	= $param['limit_num_rows'];

        /* 브랜드 검색 */
        if($param['brand_nm']) $keyword = $keyword.'&('.substr($param['brand_nm'],1).')';

//		var_dump(substr($param['brand_nm'],1));

        /* 카테고리 검색 */
        if($param['cate_nm']) $keyword = $keyword.'&'.$param['cate_nm'];

        $strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score";

        var_dump("http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".$keyword."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score");

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);

        $search_result = json_decode($result, true);

//		var_dump($search_result);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods2/goods_search';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $search_result['hits']['found'];
        $config['per_page'		] = $limit_num_rows;
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
//		$data['category'	] = $category;
//		$data['nav'			] = $arrCate;
        $data['search_cnt'	] = empty($param['search_cnt']) ? $totalCnt : $param['search_cnt'];
//		$data['brand_cnt'	] = $brand_cnt;

        $data['keyword'		] = $param['keyword'];
        $data['order_by'	] = $param['order_by'];
        $data['r_keyword'	] = $param['r_keyword'];
        $data['price_limit'	] = '';
        $data['limit'		] = $limit_num_rows;
        $data['page'		] = $param['page'];
        $data['brand_nm'	] = $param['brand_nm'];
        $data['cate_nm'		] = $param['cate_nm'];
        $data['goods'		] = $search_result['hits']['hit'];
        $data['arr_brand_nm'] = $arr_brand_nm;
        $data['arr_cate_nm'	] = $arr_cate_nm;

//var_dump($param['cate_nm']);
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
        $this->load->view('goods/goods_search');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }


    /**
     * 선택한 멀티옵션 정보 가져오기
     */
    public function goods_moption_post()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $param = $this->input->post();
        $param2 = $param;
//var_dump($param2);
        $option = $this->goods_m->get_goods_moption_info($param2);

        $this->response(array('status' => 'ok', 'option_code' => $option['GOODS_OPTION_CD'], 'moption1' => $option['M_OPTION_1'], 'moption2' => $option['M_OPTION_2'], 'moption3' => $option['M_OPTION_3'], 'moption4' => $option['M_OPTION_4'], 'moption5' => $option['M_OPTION_5'], 'option_add_price' => $option['GOODS_OPTION_ADD_PRICE'], 'option_qty' =>$option['QTY']), 200);
    }


    /**
     * 상품 상세 보기	2016-07-08
     */
    public function detail_get()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $goods_code = $this->uri->segment(3, '');
        $param = array();

        if( empty($goods_code) ) show_error('상품코드가 없습니다.', 403);

        //Load MODEL
        $this->load->model('goods_m');

        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($goods_code);

        //상품 쿠폰 정보 구하기
        $param['goods_code'	] = $goods_code;
        $param['brand_code'	] = $goods['BRAND_CD'];
        $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
        $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

        //상품 속성 정보 구하기
        $goods_class = $this->goods_m->get_goods_class($goods_code);
        $data['goods_class'		] = $goods_class;

        //상품 설명 리스트 갯수
        $goods_desc = $this->goods_m->get_goods_desc($goods_code);
        $data['goods_desc_cnt'	] = count($goods_desc);

        //동일 브랜드 상품 구하기
        $brand_goods = $this->goods_m->get_brand_goods($goods['BRAND_CD'], $goods_code);
        $data['brand_goods'		] = $brand_goods;

        //상품 옵션 구하기
        $goods_option = $this->goods_m->get_goods_option($goods_code);
        $data['goods_option'	] = $goods_option;

        $goods_moption1 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_1');
        $data['goods_moption1'	] = $goods_moption1;

        $goods_moption2 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_2');
        $data['goods_moption2'	] = $goods_moption2;

        $goods_moption3 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_3');
        $data['goods_moption3'	] = $goods_moption3;

        $goods_moption4 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_4');
        $data['goods_moption4'	] = $goods_moption4;

        $goods_moption5 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_5');
        $data['goods_moption5'	] = $goods_moption5;

        //상품 추가배송비 지역 구하기
        $goods_add_deli = $this->goods_m->get_goods_add_deli($param);
        $data['goods_add_deli'	] = $goods_add_deli;

        //상품 배송불가지역 구하기
        $goods_no_deli = $this->goods_m->get_goods_no_deli($param);
        $data['goods_no_deli'	] = $goods_no_deli;

        //상품 이미지 구하기
        $goods_img = $this->goods_m->get_goods_img($goods_code);

        for($i=0; $i<count($goods_img); $i++){
            $goods['img'	][$i] = $goods_img[$i]['IMG_URL'];
        }

        $data['goods'] = $goods;

        $coupon_info = "";
        $coupon_price = 0;
        if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000){
                    $coupon_info = "쿠폰 ".($goods_seller_coupon['COUPON_FLAT_RATE']/10)."% (최대 ".$goods_seller_coupon['MAX_DISCOUNT']."원 할인)";
                    $coupon_price = $goods['SELLING_PRICE'] - $goods_seller_coupon['MAX_DISCOUNT'];
                } else {
                    $coupon_info = "쿠폰 ".($goods_seller_coupon['COUPON_FLAT_RATE']/10)."%";
                    $coupon_price = $goods['SELLING_PRICE'] - floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                }
            }
            else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $coupon_info = "쿠폰 ".number_format($goods_seller_coupon['COUPON_FLAT_AMT'])."원";
                $coupon_price = $goods['SELLING_PRICE'] - $goods_seller_coupon['COUPON_FLAT_AMT'];
            }

            $data['goods']['SELLER_COUPON_CD'			] = $goods_seller_coupon['COUPON_CD'];
            $data['goods']['SELLER_COUPON_METHOD'		] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
            $data['goods']['SELLER_COUPON_FLAT_RATE'	] = $goods_seller_coupon['COUPON_FLAT_RATE'];
            $data['goods']['SELLER_COUPON_FLAT_AMT'		] = $goods_seller_coupon['COUPON_FLAT_AMT'];
            $data['goods']['SELLER_COUPON_MAX_DISCOUNT'	] = $goods_seller_coupon['MAX_DISCOUNT'];
        }

        if($goods_item_coupon){	//상품에 아이템쿠폰이 붙어있을경우
            if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                if($coupon_info == ""){
                    if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
                        $coupon_info = "쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."% [최대 ".$goods_item_coupon['MAX_DISCOUNT']."원 할인]";
                    } else {
                        $coupon_info = "쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."%";
                    }
                } else {
                    if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
                        $coupon_info .= " + 쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."% [최대 ".$goods_item_coupon['MAX_DISCOUNT']."원 할인]";
                    } else {
                        $coupon_info .= " + 쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."%";
                    }
                }

                if($coupon_price == 0){
                    if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
                        $coupon_price = $goods['SELLING_PRICE'] - $goods_item_coupon['MAX_DISCOUNT'];
                    } else {
                        $coupon_price = $goods['SELLING_PRICE'] - floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                    }
                } else {
                    if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
                        $coupon_price = $goods['SELLING_PRICE'] - $goods_item_coupon['MAX_DISCOUNT'];
                    } else {
                        $coupon_price = $coupon_price - floor($coupon_price * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                    }
                }
            }
            else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                if($coupon_info == ""){
                    $coupon_info = "쿠폰 ".number_format($goods_item_coupon['COUPON_FLAT_AMT'])."원";
                } else {
                    $coupon_info .= " + 쿠폰 ".number_format($goods_item_coupon['COUPON_FLAT_AMT'])."원";
                }

                if($coupon_price == 0){
                    $coupon_price = $goods['SELLING_PRICE'] - $goods_item_coupon['COUPON_FLAT_AMT'];
                } else {
                    $coupon_price = $coupon_price - $goods_item_coupon['COUPON_FLAT_AMT'];
                }
            }

            $data['goods']['ITEM_COUPON_CD'				] = $goods_item_coupon['COUPON_CD'];
            $data['goods']['ITEM_COUPON_METHOD'			] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
            $data['goods']['ITEM_COUPON_FLAT_RATE'		] = $goods_item_coupon['COUPON_FLAT_RATE'];
            $data['goods']['ITEM_COUPON_FLAT_AMT'		] = $goods_item_coupon['COUPON_FLAT_AMT'];
            $data['goods']['ITEM_COUPON_MAX_DISCOUNT'	] = $goods_item_coupon['MAX_DISCOUNT'];
        }

        $data['goods']['COUPON_INFO'	] = $coupon_info;
        $data['goods']['COUPON_PRICE'	] = $coupon_price;		//할인 적용가

//			$data['goods']['COUPON_PERCENT'	] = $goods_coupon['COUPON_PERCENT'];
//			$data['goods']['COUPON_PRICE'	] = $goods_coupon['COUPON_PRICE'];
//			$data['goods']['COUPON_CD'		] = $goods_coupon['COUPON_CD'];

        /**
         * 상품평 템플릿 구성
         */
        $temp = array();
        $temp['goods_code'	] = $goods_code;
        $paging_limit	= 3;
        $goods_comment_num = $this->goods_m->get_goods_comment_cnt($goods_code);		//상품평 전체 갯수 불러오기
        $total_goods_comment_val = $this->goods_m->get_goods_comment($goods_code, 0, 0);		//상품평 전체 평점 불러오기
        $goods_comment		= $this->goods_m->get_goods_comment($goods_code, 1, $paging_limit);	//상품평 불러오기
        $temp['total_comment_val'	] = $total_goods_comment_val;
        $temp['goods_comment'		] = $goods_comment;

        //페이징 구성
        $temp['page'		] = 1;		//현재페이지
        $temp['total_page'	] = ceil($goods_comment_num['cnt'] / $paging_limit);		//전체 페이지 갯수
        $temp['limit_num'	] = $paging_limit;					//한 페이지에 보여주는 갯수
        $temp['total_cnt'	] = $goods_comment_num['cnt'];		//전체 갯수

        $comment_template = $this->load->view('goods/template_comment', $temp, TRUE);
        $data['comment_template'] = $comment_template;
        /**
         * 상품 문의 템플릿 구성
         */
        $paging_limit	= 5;
        $goods_qna_num = $this->goods_m->get_goods_qna_cnt($goods_code);
        $goods_qna		= $this->goods_m->get_goods_qna($goods_code, 1, $paging_limit);
        $temp['goods_qna'	] = $goods_qna;

        //페이징 구성
        $temp['page'		] = 1;		//현재페이지
        $temp['total_page'	] = ceil($goods_qna_num['cnt'] / $paging_limit);		//전체 페이지 갯수
        $temp['limit_num'	] = $paging_limit;				//한 페이지에 보여주는 갯수
        $temp['total_cnt'	] = $goods_qna_num['cnt'];		//전체 갯수

        $qna_template = $this->load->view('goods/template_qna', $temp, TRUE);
        $data['qna_template'] = $qna_template;
        $data['title'	] = $goods['GOODS_NM'];
        $data['img'	] = $goods['img'][0];

        /**
         * 최근 본 상품 쿠키 저장
         */
        $this->load->library('etah_lib');
        $this->etah_lib->set_cookie_new_goods($goods_code);

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['add_wrap'] = ' wrap__vip';

        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        $this->load->view('include/header', $data);
        $this->load->view('include/layout');
        $this->load->view('goods/detail2' ,$data);
//		$this->load->view('goods/org_detail' ,$data);
        $this->load->view('include/footer');
    }

    /**
     * 검색결과 리스트
     */
    public function goods_search3_get()
    {
        $param = $this->input->get();

        $param['attr'			] = "";
        $param['brand_nm'		] = empty($param['brand_nm'			]) ? ''  : $param['brand_nm'];
        $param['cate_nm'		] = empty($param['cate_nm'			]) ? ''  : $param['cate_nm'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'];
        $param['page'			] = $this->uri->segment(3);

//		$category['CATE_CODE3'] = $param['cate_cd'];
        $keyword = $param['keyword'];

        /* 결과 내 재검색 */
        if($param['r_keyword']){
            $keyword = str_replace('||','&',$param['r_keyword']);
        }

//		var_dump($param['r_keyword']);

//		//검색결과 카테고리 네비게이션
//		$arrCate = $this->goods_m->get_category_list_by_search($param);

        //브랜드개수
//		$brand_cnt = $this->goods_m->get_brand_goods_count($param);


        /* 페이징 */
        $limit_num_rows	= "10000";
        $startPos = ($param['page']-1) * $limit_num_rows;


//		$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&&sort=goods_sort_score+desc&q.options={fields:['goods_nm^5','brand_nm^2']}&return=_all_fields,_score";

        $hostname = $_SERVER["HTTP_HOST"]; //도메인명(호스트)명을 구합니다.

        if($hostname != 'dev.etah.co.kr'){
            $strRequestUri = "http://search-etahnew-mbcz3klcd5d2zt4hvl6krpopnm.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score";
        }else{
            $strRequestUri = "http://search-etahnew-mbcz3klcd5d2zt4hvl6krpopnm.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score";
        }

//		$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("두닷")."&size=20&start=0&sort=goods_sort_score+desc&return=_all_fields,_score";

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);

        $search_data = json_decode($result, true);
        $totalCnt = $search_data['hits']['found'];

//		var_dump( json_decode($result, true) ).PHP_EOL;

        $arr_brand = array();
        $arr_brand_nm = array();

        //브랜드 그룹
        $bidx = 0;
        foreach($search_data['hits']['hit'] as $brow){
            $arr_brand[$bidx] = $brow['fields']['brand_nm'];
            $bidx ++;
        }

        //브랜드별 상품개수 담음
        if($arr_brand){
            asort($arr_brand);

            $str_brand = $arr_brand[0];
            $arr_brand_nm[$str_brand] = 0;

            foreach($arr_brand as $brand){
                if($str_brand == $brand){
                    $arr_brand_nm[$brand] ++;
                }else{
                    $str_brand = $brand;
                    $arr_brand_nm[$brand] = 1;
                }
            }
        }

        $arr_cate = array();
        $arr_cate_nm = array();

        //카테고리 그룹
        $cidx = 0;
        foreach($search_data['hits']['hit'] as $crow){
            @$arr_cate[$cidx] = $crow['fields']['category_1_nm'];
            $cidx ++;
        }

        //카테고리별 상품개수 담음
        if($arr_cate){
            asort($arr_cate);

            $str_cate = $arr_cate[0];
            $arr_cate_nm[$str_cate] = 0;

            foreach($arr_cate as $cate){
                if($str_cate == $cate){
                    $arr_cate_nm[$cate] ++;
                }else{
                    $str_cate = $cate;
                    $arr_cate_nm[$cate] = 1;
                }
            }
        }

//		var_dump($arr_cate_nm);

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];

        /* 페이징 */
        $startPos = ($param['page']-1) * $param['limit_num_rows'];
        $limit_num_rows	= $param['limit_num_rows'];

        /* 브랜드 검색 */
        if($param['brand_nm']) $keyword = $keyword.'&('.substr($param['brand_nm'],1).')';

//		var_dump(substr($param['brand_nm'],1));

        /* 카테고리 검색 */
        if($param['cate_nm']) $keyword = $keyword.'&'.$param['cate_nm'];

        if($hostname != 'dev.etah.co.kr'){
            $strRequestUri = "http://search-etahnew-mbcz3klcd5d2zt4hvl6krpopnm.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score";
        }else{
            $strRequestUri = "http://search-etahnew-mbcz3klcd5d2zt4hvl6krpopnm.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score";
        }

//var_dump("http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".$keyword."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_sort_score+desc&return=_all_fields,_score");

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);

        $search_result = json_decode($result, true);

//		var_dump($search_result);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods/goods_search';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $search_result['hits']['found'];
        $config['per_page'		] = $limit_num_rows;
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
//		$data['category'	] = $category;
//		$data['nav'			] = $arrCate;
        $data['search_cnt'	] = empty($param['search_cnt']) ? $totalCnt : $param['search_cnt'];
//		$data['brand_cnt'	] = $brand_cnt;

        $data['keyword'		] = $param['keyword'];
        $data['order_by'	] = $param['order_by'];
        $data['r_keyword'	] = $param['r_keyword'];
        $data['price_limit'	] = '';
        $data['limit'		] = $limit_num_rows;
        $data['page'		] = $param['page'];
        $data['brand_nm'	] = $param['brand_nm'];
        $data['cate_nm'		] = $param['cate_nm'];
        $data['goods'		] = $search_result['hits']['hit'];
        $data['arr_brand_nm'] = $arr_brand_nm;
        $data['arr_cate_nm'	] = $arr_cate_nm;

//var_dump($param['cate_nm']);
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
        $this->load->view('goods/goods_search');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }

    /**
     * 검색결과 리스트
     */
    public function goods_search4_get()
    {
        /* model_m */
        $this->load->model('goods2_m');
        $param = $this->input->get();

        $param['attr'			] = "";
        $param['brand_nm'		] = empty($param['brand_nm'			]) ? ''  : $param['brand_nm'];
        $param['cate_cd'		] = empty($param['cate_cd'			]) ? ''  : $param['cate_cd'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'B' : $param['order_by'];
        $param['page'			] = $this->uri->segment(3);

        $keyword  = $param['keyword'];
        $keyword2 = $param['keyword'];

        /*검색어 히스토리 저장*/
        $this->goods2_m->reg_search_history($param['keyword']);

        /* 결과 내 재검색 */
        if($param['r_keyword']){
            $keyword = str_replace('||','&',$param['r_keyword']);
        }

        /* 페이징 */
        $limit_num_rows	= 10000;
        $startPos       = 0;
        $field          = '';
        $sort           = '';
        $field2         = '';
        $sort2          = '';
        $case           = 0;
        $search_data = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$field,$sort,$field2,$sort2,$case);

        $totalCnt = $search_data['hits']['found'];

        $arr_brand = array();
        $arr_brand_nm = array();

        $arr_cate		= array();
        $arr_cate_cd	= array();
        $arr_cate_nm	= array();

        $arr_cate2		= array();
        $arr_cate_cd2	= array();
        $arr_cate_nm2	= array();

        $arr_cate3		= array();
        $arr_cate_cd3	= array();
        $arr_cate_nm3	= array();

        //카테고리 그룹
        $cidx = 0;
        foreach($search_data['hits']['hit'] as $crow){
            @$arr_cate[$cidx]		= $crow['fields']['category_1_nm'];
            @$arr_cate_cd[$cidx]	= $crow['fields']['category_1_cd'];
            @$arr_cate2[$cidx]		= $crow['fields']['category_2_nm'];
            @$arr_cate_cd2[$cidx]	= $crow['fields']['category_2_cd'];
            @$arr_cate3[$cidx]		= $crow['fields']['category_3_nm'];
            @$arr_cate_cd3[$cidx]	= $crow['fields']['category_3_cd'];
            $cidx ++;
        }

        //카테고리별 상품개수 담음 (대카테)
        if($arr_cate){

            $str_cate = $arr_cate[0];

            /** 배열 초기값 셋팅 **/
            foreach($arr_cate as $cate){
                $arr_cate_nm[$cate]['cnt'] = 0;
            }

            $cidx = 0;
            foreach($arr_cate as $cate){

                $arr_cate_nm[$cate]['cnt'] ++;

                if($cate == $arr_cate[$cidx]){
                    $arr_cate_nm[$cate]['code'] = $arr_cate_cd[$cidx];
                    $arr_cate_nm[$cate]['keyword'] = $arr_cate[$cidx];
                }
                $cidx ++;
            }
        }

        //카테고리별 상품개수 담음 (중카테)
        if($arr_cate2){

            $str_cate = $arr_cate2[0];

            /** 배열 초기값 셋팅 **/
            foreach($arr_cate2 as $cate2){
                $arr_cate_nm2[$cate2]['cnt'] = 0;
            }

            $cidx = 0;
            foreach($arr_cate2 as $cate2){

                $arr_cate_nm2[$cate2]['cnt'] ++;

                if($cate2 == $arr_cate2[$cidx]){
                    $arr_cate_nm2[$cate2]['code'		] = $arr_cate_cd2[$cidx];
                    $arr_cate_nm2[$cate2]['parent_code'	] = $arr_cate_cd[$cidx];

                    $arr_cate_nm2[$cate2]['keyword'	] = $arr_cate[$cidx].'&'.$arr_cate2[$cidx];
                }

                $cidx ++;
            }
        }

        //카테고리별 상품개수 담음 (소카테)
        if($arr_cate3){

            $str_cate = $arr_cate3[0];

            /** 배열 초기값 셋팅 **/
            foreach($arr_cate3 as $cate3){
                $arr_cate_nm3[$cate3]['cnt'] = 0;
            }

            $cidx = 0;
            foreach($arr_cate3 as $cate3){

                $arr_cate_nm3[$cate3]['cnt'] ++;

                if($cate3 == $arr_cate3[$cidx]){
                    $arr_cate_nm3[$cate3]['code'		] = $arr_cate_cd3[$cidx];
                    $arr_cate_nm3[$cate3]['parent_code'	] = $arr_cate_cd2[$cidx];

                    $arr_cate_nm3[$cate3]['keyword'	] = $arr_cate[$cidx].'&'.$arr_cate2[$cidx].'&'.$arr_cate3[$cidx];
                }

                $arr_cate_nm3[$cate3]['code'] = $arr_cate_cd3[$cidx];
                $cidx ++;
            }
        }

        arsort($arr_cate_nm);
        arsort($arr_cate_nm2);
        arsort($arr_cate_nm3);

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];

        /* 페이징 */
        $startPos = ($param['page']-1) * $param['limit_num_rows'];
        $limit_num_rows	= $param['limit_num_rows'];

        /* 브랜드 검색 */
        if($param['brand_nm']) {
            $bkeyword = $keyword;
            $brand_nm = substr($param['brand_nm'], 1);
            $brand_nm2 = explode('|',$brand_nm);

            for($i=0;$i<count($brand_nm2); $i++) {
                $brand_cd[$i] = $this->goods2_m->get_brand_cd($brand_nm2[$i]);
            }
            $brand_cd2 = '';
            for($i=0;$i<count($brand_cd); $i++) {
                $brand_cd2 .= '|'.$brand_cd[$i]['brand_cd'];
            }

            $keyword = $keyword . '&(' . substr($brand_cd2, 1) . ')';
        }

        /* 카테고리 검색 */
        if($param['cate_cd']){
//			$param['cate_nm'] = str_replace("%%",'&',$param['cate_nm']);
//            $cate_key = explode('&',$param['cate_nm']);
            $cate_key = explode('|', $param['cate_cd']);

            $key_num = count($cate_key);
            if($key_num == 1){
//                $param['category_1_nm'] = $this->goods2_m->get_category_cd($cate_key[0]);
//                $keyword = $keyword . '&'.$param['category_1_nm']['CATEGORY_DISP_CD'];
                $keyword = $keyword . '&'.$cate_key[0];
            }else if($key_num == 2){
//                $param['category_2_nm'] = $this->goods2_m->get_category_cd($cate_key[1]);
//                $keyword = $keyword . '&'.$param['category_2_nm']['CATEGORY_DISP_CD'];
                $keyword = $keyword . '&'.$cate_key[1];
            }
            //$keyword = $keyword.'&'.$param['cate_nm'];
        }
        switch($param['order_by']){
            //신상품순
            case 'A' :	$field = "goods_cd";
                $sort = "desc";break;
            //인기순
            case 'B' : $field = "goods_priority";
                $sort = "asc";
                $field2 = "goods_sort_score";
                $sort2 = "desc";break;
            //낮은가격순
            case 'C' :	$field = "selling_price";
                $sort = "asc";
                $field2 = "goods_cd";
                $sort2 = "desc";break;
            //높은가격순
            case 'D' :	$field = "selling_price";
                $sort = "desc";
                $field2 = "goods_cd";
                $sort2 = "desc";break;
        }
        $case = 1;

        echo $keyword;
        $search_result = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$field,$sort,$field2,$sort2,$case);

        $goods_cd  = "";
        $arr_price = array();

        foreach($search_result['hits']['hit'] as $grow){
            $goods_cd .= ",".$grow['fields']['goods_cd'];
        }
        $goods_cd = substr($goods_cd, 1);

        if($goods_cd){
            $price = $this->goods2_m->get_goods_price_by_search($goods_cd);
            foreach($price as $prow){
                $arr_price[$prow['GOODS_CD']]['SELLING_PRICE'		   ] = $prow['SELLING_PRICE'		  ];
                $arr_price[$prow['GOODS_CD']]['RATE_PRICE_S'		   ] = $prow['RATE_PRICE_S'			  ];
                $arr_price[$prow['GOODS_CD']]['RATE_PRICE_G'		   ] = $prow['RATE_PRICE_G'			  ];
                $arr_price[$prow['GOODS_CD']]['AMT_PRICE_S'			   ] = $prow['AMT_PRICE_S'			  ];
                $arr_price[$prow['GOODS_CD']]['AMT_PRICE_G'			   ] = $prow['AMT_PRICE_G'			  ];
                $arr_price[$prow['GOODS_CD']]['COUPON_CD_S'			   ] = $prow['COUPON_CD_S'			  ];
                $arr_price[$prow['GOODS_CD']]['COUPON_CD_G'			   ] = $prow['COUPON_CD_G'			  ];
                $arr_price[$prow['GOODS_CD']]['DELIV_POLICY_NO'		   ] = $prow['DELIV_POLICY_NO'		  ];
                $arr_price[$prow['GOODS_CD']]['PATTERN_TYPE_CD'		   ] = $prow['PATTERN_TYPE_CD'		  ];
                $arr_price[$prow['GOODS_CD']]['DELI_LIMIT'			   ] = $prow['DELI_LIMIT'			  ];
                $arr_price[$prow['GOODS_CD']]['DELI_COST'			   ] = $prow['DELI_COST'			  ];
                $arr_price[$prow['GOODS_CD']]['GOODS_MILEAGE_SAVE_RATE'] = $prow['GOODS_MILEAGE_SAVE_RATE'];
                $arr_price[$prow['GOODS_CD']]['DEAL'                   ] = $prow['DEAL'                   ];
                $arr_price[$prow['GOODS_CD']]['GONGBANG'               ] = $prow['GONGBANG'               ];
            }
        }


        //검색결과 재정렬
        if($param['order_by']=='C' || $param['order_by']=='D') {
            //할인가 구하기
            for($i=0;$i<count($search_result['hits']['hit']);$i++){
                $price = $this->goods2_m->get_goods_price_by_search($search_result['hits']['hit'][$i]['fields']['goods_cd']);

                if($price[0]['COUPON_CD_S'] || $price[0]['COUPON_CD_G']){
                    $discount_price = $price[0]['SELLING_PRICE'] - ($price[0]['RATE_PRICE_S']+$price[0]['RATE_PRICE_G']) - ($price[0]['AMT_PRICE_S']+$price[0]['AMT_PRICE_G']);
                } else {
                    $discount_price = $price[0]['SELLING_PRICE'];
                }

                array_push($search_result['hits']['hit'][$i], $discount_price);
            }

            //배열 재정렬
            if($param['order_by']=='C') {
                $sort = array();
                foreach($search_result['hits']['hit'] as $key => $value) {
                    $sort[$key] = $value[0];
                }
                array_multisort($sort, SORT_ASC, $search_result['hits']['hit']);
            }
            if($param['order_by']=='D') {
                $sort = array();
                foreach($search_result['hits']['hit'] as $key => $value) {
                    $sort[$key] = $value[0];
                }
                array_multisort($sort, SORT_DESC, $search_result['hits']['hit']);
            }
        }


        if($param['brand_nm']) $keyword2 = $bkeyword;
        if($param['r_keyword']){
            $keyword2 = str_replace('||','&',$param['r_keyword']);
        }


        /* 페이징 */
        $startPos2 = 0;
        $limit_num_rows2 = 10000;

        if($param['cate_cd']){
//            $param['cate_nm'] = str_replace("%%",'&',$param['cate_nm']);
            $cate_cd = str_replace("|",'&',$param['cate_cd']);
            $keyword2 = $keyword2.'&'.$cate_cd;
        }

        $search_brand = self::_cloudsearch($keyword2,$limit_num_rows2,$startPos2,$field,$sort,$field2,$sort2,$case);
        $goods_cd2 = "";
        foreach($search_brand['hits']['hit'] as $grow){
            $goods_cd2 .= ",".$grow['fields']['goods_cd'];
        }
        $goods_cd2 = substr($goods_cd2, 1);

        if($goods_cd2) {
            $brand = $this->goods2_m->get_brand_by_search($goods_cd2);
            for ($i = 0; $i < count($brand); $i++) {
                $arr_brand_nm['BRAND_NM' ][$i] = $brand[$i]['BRAND_NM' ];
                $arr_brand_nm['BRAND_CNT'][$i] = $brand[$i]['BRAND_CNT'];
            }
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods2/goods_search';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $search_result['hits']['found'];
        $config['per_page'		] = $limit_num_rows;
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['search_cnt'	] = empty($param['search_cnt']) ? $totalCnt : $param['search_cnt'];
        $data['arr_price'	] = $arr_price;
        $data['keyword'		] = $param['keyword'];
        $data['order_by'	] = $param['order_by'];
        $data['r_keyword'	] = $param['r_keyword'];
        $data['price_limit'	] = '';
        $data['limit'		] = $limit_num_rows;
        $data['page'		] = $param['page'];
        $data['brand_nm'	] = $param['brand_nm'];
        $data['cate_cd'		] = $param['cate_cd'];
        $data['goods'		] = $search_result['hits']['hit'];
        $data['arr_brand_nm'] = $arr_brand_nm;
        $data['arr_cate_nm'	] = $arr_cate_nm;
        $data['arr_cate_nm2'] = $arr_cate_nm2;
        $data['arr_cate_nm3'] = $arr_cate_nm3;

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
        $this->load->view('goods/goods_search2');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }



    /**
     * 검색결과 리스트
     * 2020.01.06
     */
    public function goods_search_get()
    {
        /* model_m */
        $this->load->model('goods2_m');
        $param = $this->input->get();

        $gubun    = $param['gb'];
        $keyword  = $param['keyword'];

        //텍스트 값 정제
        $keyword = trim($keyword);
        $keyword = preg_replace('/\r\n|\t|\0|\r|\n/','',  $keyword  );
        $keyword = str_replace('"', '', $keyword );
        $keyword = preg_replace("/[\/\\\:'\"\^`\_|]/i", "",  $keyword  );
        if( isset($gubun) ) {
            /* 검색결과 상세리스트 이동 */
            self::_goods_search_detail($param);
        }
        else {
            /* 검색어 히스토리 저장 */
//            if($_SERVER['HTTP_X_FORWARDED_FOR'] != '1.221.31.141') {  //역삼사무실
            if($_SERVER['HTTP_X_FORWARDED_FOR'] != '112.217.100.186' && $_SERVER['HTTP_X_FORWARDED_FOR'] != '106.243.163.42') {
                $this->goods2_m->reg_search_history($param['keyword']);
            }

            /* 상품 */
            $limit_num_rows	= 10000;
            $startPos       = 0;
            $field          = '';
            $sort           = '';
            $field2         = '';
            $sort2          = '';
            $case           = 0;

            $arr_fq = array();
            $arr_sort = array();

            $arr_sort['field_A'] = $field;
            $arr_sort['sort_A' ] = $sort;
            $arr_sort['field_B'] = $field2;
            $arr_sort['sort_B' ] = $sort2;
            $search_data = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case); //검색결과 전체 상품 추출


            $target_cd = "";
            foreach($search_data['hits']['hit'] as $grow){
                $target_cd .= ",".$grow['fields']['goods_cd'];
            }
            $target_cd = substr($target_cd, 1);

            $goods_total_cnt = $search_data['hits']['found'];

            $limit_num_rows = 9;
            $search_result = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case); //검색결과 상품 5개 추출

            $goods_cd  = "";
            $arr_price = array();

            foreach($search_result['hits']['hit'] as $grow){
                $goods_cd .= ",".$grow['fields']['goods_cd'];
            }
            $goods_cd = substr($goods_cd, 1);

            if($goods_cd){
                $price = $this->goods2_m->get_goods_price_by_search($goods_cd);
                foreach($price as $prow){
                    $arr_price[$prow['GOODS_CD']]['SELLING_PRICE'		   ] = $prow['SELLING_PRICE'		  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_S'		   ] = $prow['RATE_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_G'		   ] = $prow['RATE_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_S'			   ] = $prow['AMT_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_G'			   ] = $prow['AMT_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_S'			   ] = $prow['COUPON_CD_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_G'			   ] = $prow['COUPON_CD_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELIV_POLICY_NO'		   ] = $prow['DELIV_POLICY_NO'		  ];
                    $arr_price[$prow['GOODS_CD']]['PATTERN_TYPE_CD'		   ] = $prow['PATTERN_TYPE_CD'		  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_LIMIT'			   ] = $prow['DELI_LIMIT'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_COST'			   ] = $prow['DELI_COST'			  ];
                    $arr_price[$prow['GOODS_CD']]['GOODS_MILEAGE_SAVE_RATE'] = $prow['GOODS_MILEAGE_SAVE_RATE'];
                    $arr_price[$prow['GOODS_CD']]['DEAL'                   ] = $prow['DEAL'                   ];
                    $arr_price[$prow['GOODS_CD']]['GONGBANG'               ] = $prow['GONGBANG'               ];
                }
            }


            $param['start'   ] = 0;
            $param['limit'   ] = 4;
            $param['code'    ] = $target_cd;
            $param['order_by'] = 'A';

            /* 브랜드 */
            $search_brand = $this->goods2_m->get_search_brand($param);

            if($target_cd != ''){
                /* 연관 태그 */
//                $search_tag = $this->goods2_m->get_search_tag($param, $keyword);

                /* 키워드 관련 태그 */
                $search_tag = $this->goods2_m->get_search_tag_by_keyword($keyword);
            }

            /* 기획전 */
            $search_planEvent_cnt   = $this->goods2_m->get_search_plan_event_cnt($param);
            $search_planEvent       = $this->goods2_m->get_search_plan_event($param);

            /* 매거진 */
            $search_magazine_cnt    = $this->goods2_m->get_search_magazine_cnt($param);
            $search_magazine        = $this->goods2_m->get_search_magazine($param);

            $total_cnt = count($search_brand)+count($search_tag)+$search_planEvent_cnt['CNT']+$search_magazine_cnt['CNT']+$goods_total_cnt;

            $data['search_cnt'	  ] = $total_cnt;
            $data['arr_price'	  ] = $arr_price;
            $data['keyword'		  ] = $param['keyword'];
            $data['goods'		  ] = $search_result['hits']['hit'];
            $data['brand'		  ] = $search_brand;
            $data['tag'		      ] = $search_tag;
            $data['planEvent'	  ] = $search_planEvent;
            $data['magazine'	  ] = $search_magazine;
            $data['goods_cnt'     ] = $goods_total_cnt;
            $data['planEvent_cnt' ] = $search_planEvent_cnt['CNT'];
            $data['magazine_cnt'  ] = $search_magazine_cnt['CNT'];

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
            $this->load->view('goods/goods_search');
            $this->load->view('include/layout');
            $this->load->view('include/footer');
        }
    }

    /**
     * 검색결과 리스트 상세
     * 2020.01.06
     */
    public function _goods_search_detail($param)
    {
        $gb      = $param['gb'];
        $keyword = ($gb == 'T')?$param['tag_keyword']:$param['keyword'];

        //텍스트 값 정제
        $keyword = trim($keyword);
        $keyword = preg_replace('/\r\n|\t|\0|\r|\n/','',  $keyword  );
        $keyword = str_replace('"', '', $keyword );
        $keyword = preg_replace("/[\/\\\:'\"\^`\_|]/i", "",  $keyword  );

        $page = empty($this->uri->segment(3)) ? 1  : $this->uri->segment(3);

        /* 검색필터 */
        $param['brand'      ] = empty($param['brand'        ]) ? ''    : $param['brand'       ];  //브랜드
        $param['order_by'   ] = empty($param['order_by'     ]) ? 'A'   : $param['order_by'    ];  //정렬순위
        $param['category'   ] = empty($param['category'     ]) ? ''    : $param['category'    ];  //카테고리
        $param['deliv_type' ] = empty($param['deliv_type'   ]) ? ''    : $param['deliv_type'  ];  //무료배송여부
        $param['price_limit'] = empty($param['price_limit'  ]) ? ''    : $param['price_limit' ];  //가격
        $param['country'    ] = empty($param['country'      ]) ? ''    : $param['country'     ];  //국가
        $param['tag_keyword'] = empty($param['tag_keyword'  ]) ? ''    : $param['tag_keyword' ];  //연관태그

        /* 상품정보 가져오기 */
        $limit_num_rows	= 10000;
        $startPos       = 0;
        $field          = '';
        $sort           = '';
        $field2         = '';
        $sort2          = '';
        $case           = 0;

        $arr_fq = array();
        $arr_sort = array();

        $arr_sort['field_A'] = $field;
        $arr_sort['sort_A' ] = $sort;
        $arr_sort['field_B'] = $field2;
        $arr_sort['sort_B' ] = $sort2;
        $search_data = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case); //검색결과 전체 상품 추출

        $target_cd = "";
        foreach($search_data['hits']['hit'] as $grow){
            $target_cd .= ",".$grow['fields']['goods_cd'];
        }
        $code = substr($target_cd, 1);


        $temp['code'    ] = $code;  //검색결과 상품코드
        $temp['limit'   ] = '60';
        $temp['start'   ] = ($page-1) * $temp['limit'];
        $temp['order_by'] = $param['order_by'];
        $temp['category'] = $param['category'];
        $temp['keyword' ] = $param['keyword' ];

        /* 기획전 검색상세 */
        if($gb == 'E') {
            $totalCnt   = $this->goods2_m->get_search_plan_event_cnt($temp);    //전체개수
            $list       = $this->goods2_m->get_search_plan_event($temp);        //기획전 리스트

            $cur_category = array();
            $arr_cate1 = array();
            $arr_cate2 = array();

            $category_list_info = $this->goods2_m->get_search_plan_event_category($temp);    //기획전 카테고리

            foreach($category_list_info as $crow) {
                //현재 설정된 카테고리
                if(!empty($crow['CURRENT_CATE'])) {
                    $cur_category['CATE_CD1'] = $crow['CATEGORY_CD1'];
                    $cur_category['CATE_NM1'] = $crow['CATEGORY_NM1'];
                    $cur_category['CATE_CD2'] = $crow['CATEGORY_CD2'];
                    $cur_category['CATE_NM2'] = $crow['CATEGORY_NM2'];
                }

                //카테고리 리스트
                $arr_cate1[$crow['CATEGORY_CD1']]['CODE'] = $crow['CATEGORY_CD1'];
                $arr_cate1[$crow['CATEGORY_CD1']]['NAME'] = $crow['CATEGORY_NM1'];

                $arr_cate2[$crow['CATEGORY_CD2']]['CODE'] = $crow['CATEGORY_CD2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['NAME'] = $crow['CATEGORY_NM2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['PARENT_CODE'] = $crow['CATEGORY_CD1'];
            }

            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods2/goods_search';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt['CNT'];
            $config['per_page'		] = $temp['limit'];
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);

            $data['pagination'	    ] = $this->pagination->create_links();

            $data['list'            ] = $list;
            $data['list_cnt'        ] = $totalCnt['CNT'];
            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['cur_category'    ] = $cur_category;
        }

        /* 매거진 검색상세 */
        if($gb == 'M') {
            $totalCnt   = $this->goods2_m->get_search_magazine_cnt($temp);    //전체개수
            $list       = $this->goods2_m->get_search_magazine($temp);    //매거진 리스트

            $cur_category = array();
            $arr_cate1 = array();
            $arr_cate2 = array();

            $category_list_info = $this->goods2_m->get_search_magazine_category($temp);    //매거진 카테고리

            foreach($category_list_info as $crow) {
                //현재 설정된 카테고리
                if(!empty($crow['CURRENT_CATE'])) {
                    $cur_category['CATE_CD1'] = $crow['CATEGORY_CD1'];
                    $cur_category['CATE_NM1'] = $crow['CATEGORY_NM1'];
                    $cur_category['CATE_CD2'] = $crow['CATEGORY_CD2'];
                    $cur_category['CATE_NM2'] = $crow['CATEGORY_NM2'];
                }

                //카테고리 리스트
                $arr_cate1[$crow['CATEGORY_CD1']]['CODE'] = $crow['CATEGORY_CD1'];
                $arr_cate1[$crow['CATEGORY_CD1']]['NAME'] = $crow['CATEGORY_NM1'];

                $arr_cate2[$crow['CATEGORY_CD2']]['CODE'] = $crow['CATEGORY_CD2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['NAME'] = $crow['CATEGORY_NM2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['PARENT_CODE'] = $crow['CATEGORY_CD1'];
            }


            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods2/goods_search';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt['CNT'];
            $config['per_page'		] = $temp['limit'];
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);

            $data['pagination'	    ] = $this->pagination->create_links();

            $data['list'            ] = $list;
            $data['list_cnt'        ] = $totalCnt['CNT'];
            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['cur_category'    ] = $cur_category;
        }

        /* 상품,태그 검색상세 */
        if( ($gb == 'G') || ($gb == 'T') ) {

            $arr_brand = array();   //브랜드
            $arr_cate1 = array();   //카테고리1
            $arr_cate2 = array();   //카테고리2
            $arr_cate3 = array();   //카테고리3

            $cur_category = array(); //선택한 카테고리정보
            $arr_country = array();  //국가
            $arr_sellingPrice = array();   //가격

            //검색필터 설정
            foreach($search_data['hits']['hit'] as $srow) {
                //브랜드 리스트
                $brand_cd = $srow['fields']['brand_cd'];
                $brand_nm = $srow['fields']['brand_nm'];

                $arr_brand[$brand_cd]['NM'] = $brand_nm;
                $arr_brand[$brand_cd]['CNT'] = $arr_brand[$brand_cd]['CNT']+1;

                //카테고리 리스트
                $cate_cd1 = $srow['fields']['category_1_cd'];
                $cate_nm1 = $srow['fields']['category_1_nm'];
                $cate_cd2 = $srow['fields']['category_2_cd'];
                $cate_nm2 = $srow['fields']['category_2_nm'];
                $cate_cd3 = $srow['fields']['category_3_cd'];
                $cate_nm3 = $srow['fields']['category_3_nm'];

                $arr_cate1[$cate_cd1]['CODE'] = $cate_cd1;
                $arr_cate1[$cate_cd1]['NAME'] = $cate_nm1;

                $arr_cate2[$cate_cd2]['CODE'] = $cate_cd2;
                $arr_cate2[$cate_cd2]['NAME'] = $cate_nm2;
                $arr_cate2[$cate_cd2]['PARENT_CODE'] = $cate_cd1;

                $arr_cate3[$cate_cd3]['CODE'] = $cate_cd3;
                $arr_cate3[$cate_cd3]['NAME'] = $cate_nm3;
                $arr_cate3[$cate_cd3]['PARENT_CODE'] = $cate_cd2;

                //선택한 카테고리 정보
                if($param['category']==$cate_cd3) {
                    $cur_category['CATE_CD1'] = $cate_cd1;
                    $cur_category['CATE_NM1'] = $cate_nm1;
                    $cur_category['CATE_CD2'] = $cate_cd2;
                    $cur_category['CATE_NM2'] = $cate_nm2;
                    $cur_category['CATE_CD3'] = $cate_cd3;
                    $cur_category['CATE_NM3'] = $cate_nm3;
                }

                //국가 리스트
                $country_cd = $srow['fields']['country_cd'];
                $arr_country[$country_cd]['NM'] = $this->goods2_m->get_countryInfo($country_cd);

                //가격
                $price = $srow['fields']['selling_price'];
                if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
            }

            $data['arr_brand'       ] = $arr_brand;
            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['arr_cate3'       ] = $arr_cate3;
            $data['arr_country'     ] = $arr_country;
            $data['arr_sellingPrice'] = $arr_sellingPrice;
            $data['cur_category'    ] = $cur_category;          //선택한 카테고리정보


            //페이징
            $limit_num_rows	= $temp['limit'];
            $startPos       = $temp['start'];
            $field          = '';
            $sort           = '';
            $field2         = '';
            $sort2          = '';
            $case           = 1;

            $arr_fq   = array();    //검색필터
            $arr_sort = array();    //정렬순위

            //정렬
            switch($param['order_by']){
                case 'A' :  //인기순
                    $field = "goods_priority";$sort = "asc";
                    $field2 = "goods_sort_score";$sort2 = "desc";
                    break;
                case 'B' :  //신상품순
                    $field = "goods_cd";$sort = "desc";
                    break;
                case 'C' :  //낮은가격순
                    $field = "selling_price";$sort = "asc";
                    $field2 = "goods_cd";$sort2 = "desc";
                    break;
                case 'D' :  //높은가격순
                    $field = "selling_price";$sort = "desc";
                    $field2 = "goods_cd";$sort2 = "desc";
                    break;
            }

            $arr_sort['field_A'] = $field;
            $arr_sort['sort_A' ] = $sort;
            $arr_sort['field_B'] = $field2;
            $arr_sort['sort_B' ] = $sort2;

            $arr_fq['brand'     ] = $param['brand'      ];  //검색필터 브랜드
            $arr_fq['category'  ] = $param['category'   ];  //검색필터 카테고리
            $arr_fq['price'     ] = $param['price_limit'];  //검색필터 가격
            $arr_fq['country'   ] = $param['country'    ];  //검색필터 국가
            $arr_fq['deliv_type'] = $param['deliv_type' ];  //검색필터 무료배송

            $search_result = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case);   //검색결과 페이징
            $totalCnt = $search_result['hits']['found'];  //전체개수 (검색필터적용)


            //가격할인정보 구하기
            $goods_cd  = "";
            $arr_price = array();

            foreach($search_result['hits']['hit'] as $grow){
                $goods_cd .= ",".$grow['fields']['goods_cd'];
            }
            $goods_cd = substr($goods_cd, 1);

            if($goods_cd){
                $price = $this->goods2_m->get_goods_price_by_search($goods_cd);
                foreach($price as $prow){
                    $arr_price[$prow['GOODS_CD']]['SELLING_PRICE'		   ] = $prow['SELLING_PRICE'		  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_S'		   ] = $prow['RATE_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_G'		   ] = $prow['RATE_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_S'			   ] = $prow['AMT_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_G'			   ] = $prow['AMT_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_S'			   ] = $prow['COUPON_CD_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_G'			   ] = $prow['COUPON_CD_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELIV_POLICY_NO'		   ] = $prow['DELIV_POLICY_NO'		  ];
                    $arr_price[$prow['GOODS_CD']]['PATTERN_TYPE_CD'		   ] = $prow['PATTERN_TYPE_CD'		  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_LIMIT'			   ] = $prow['DELI_LIMIT'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_COST'			   ] = $prow['DELI_COST'			  ];
                    $arr_price[$prow['GOODS_CD']]['GOODS_MILEAGE_SAVE_RATE'] = $prow['GOODS_MILEAGE_SAVE_RATE'];
                    $arr_price[$prow['GOODS_CD']]['DEAL'                   ] = $prow['DEAL'                   ];
                    $arr_price[$prow['GOODS_CD']]['GONGBANG'               ] = $prow['GONGBANG'               ];
                }
            }

            //검색결과 재정렬 (가격순일때 할인가로 재정렬)
            if($param['order_by']=='C' || $param['order_by']=='D') {
                //할인가 구하기
                for($i=0;$i<count($search_result['hits']['hit']);$i++){
                    $price = $this->goods2_m->get_goods_price_by_search($search_result['hits']['hit'][$i]['fields']['goods_cd']);

                    if($price[0]['COUPON_CD_S'] || $price[0]['COUPON_CD_G']){
                        $discount_price = $price[0]['SELLING_PRICE'] - ($price[0]['RATE_PRICE_S']+$price[0]['RATE_PRICE_G']) - ($price[0]['AMT_PRICE_S']+$price[0]['AMT_PRICE_G']);
                    } else {
                        $discount_price = $price[0]['SELLING_PRICE'];
                    }

                    array_push($search_result['hits']['hit'][$i], $discount_price);
                }

                //배열 재정렬
                if($param['order_by']=='C') {    //낮은가격순
                    $sort = array();
                    foreach($search_result['hits']['hit'] as $key => $value) {
                        $sort[$key] = $value[0];
                    }
                    array_multisort($sort, SORT_ASC, $search_result['hits']['hit']);
                }
                if($param['order_by']=='D') {    //높은가격순
                    $sort = array();
                    foreach($search_result['hits']['hit'] as $key => $value) {
                        $sort[$key] = $value[0];
                    }
                    array_multisort($sort, SORT_DESC, $search_result['hits']['hit']);
                }
            }

            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods2/goods_search';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt;
            $config['per_page'		] = $limit_num_rows;
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);


            $data['pagination'	    ] = $this->pagination->create_links();

            $data['list'            ] = $search_result['hits']['hit'];
            $data['list_cnt'        ] = $totalCnt;
            $data['arr_price'       ] = $arr_price;
        }

        $data['keyword'		    ] = $param['keyword'    ];  //검색어
        $data['gubun'           ] = $gb;                    //검색상세 구분
        $data['brand'           ] = $param['brand'      ];  //브랜드
        $data['order_by'        ] = $param['order_by'   ];  //정렬순위
        $data['category'        ] = $param['category'   ];  //카테고리
        $data['deliv_type'      ] = $param['deliv_type' ];  //배송비
        $data['price_limit'     ] = $param['price_limit'];  //가격
        $data['country'         ] = $param['country'    ];  //국가
        $data['tag_keyword'     ] = $param['tag_keyword'];  //연관태그 키워드

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
        $this->load->view('goods/goods_search_detail');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }


    /**
     * 2018.04.20
     * 클라우드 서치 모듈
     */
    public function _cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case){

        /* 2018.10.10
         * 에타 검색 도메인 이원화
         * 기존 도메인 : search-etah         예비 도메인 : search-etahnew
         */

        if($case == 1) {

            $fqUrl   = "";
            $sortUrl = "";

            /* 정렬기준 2개 */
            if($arr_sort['field_B'] != '') {
                $sortUrl = $arr_sort['field_A']."+".$arr_sort['sort_A'].",".$arr_sort['field_B']."+".$arr_sort['sort_B'];
            }else {
                $sortUrl = $arr_sort['field_A']."+".$arr_sort['sort_A'];
            }


            $brandUrl   = "";
            $cateUrl    = "";
            $countryUrl = "";
            $priceUrl   = "";
            $delivUrl   = "";

            /* 검색필터 브랜드 */
            if( $arr_fq['brand'] ) {
                $arr_brand = array_filter(explode("|", $arr_fq['brand']));
                foreach($arr_brand as $brand) {
                    $brandUrl .= "+(term+field%3Dbrand_cd+'".$brand."')";
                }
                $brandUrl = "+(or".$brandUrl.")";
            }

            /* 검색필터 카테고리 */
            if( $arr_fq['category'] ) {
                $cateUrl = "+(term+field%3Dcategory_3_cd+'".$arr_fq['category']."')";
            }

            /* 검색필터 국가 */
            if( $arr_fq['country'] ) {
                $arr_country = explode("|", substr($arr_fq['country'],1));
                foreach($arr_country as $country) {
                    $countryUrl .= "+(term+field%3Dcountry_cd+'".$country."')";
                }
                $countryUrl = "+(or".$countryUrl.")";
            }

            /* 검색필터 가격 */
            if( $arr_fq['price'] ) {
                $arr_price = explode("|", $arr_fq['price']);

                if($arr_price[0]=='' || $arr_price[1]=='') {
                    $pri = "{".$arr_price[0].",".$arr_price[1]."}";
                }
                else {
                    $pri = "[".$arr_price[0].",".$arr_price[1]."]";
                }
                $priceUrl = "+(range+field%3Dselling_price+".$pri.")";

            }

            /* 검색필터 무료배송 */
            if( $arr_fq['deliv_type'] ) {
                $delivUrl = "+(term+field%3Ddelivery_pattern+'".$arr_fq['deliv_type']."')";
            }


            if( $brandUrl!='' || $cateUrl!='' || $countryUrl!='' || $priceUrl!='' || $delivUrl!='' ) {
                $fqUrl = "&fq=(and".$brandUrl.$cateUrl.$countryUrl.$priceUrl.$delivUrl.")";
            }


//            $fqUrl = "&fq=(and+(or+(term+field%3Dcountry_cd+'KR')))";
//            $fqUrl = "&fq=(and+(term+field%3Dcategory_1_cd+'23000000')+(or+(term+field%3Dcountry_cd+'JP')+(term+field%3Dcountry_cd+'KR')))";

//            $keyword = $keyword."&17000000"
//            $key = "q=".urlencode($keyword)."&fq=selling_price:{,20000}";
            $strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."".$fqUrl."&size=".$limit_num_rows."&start=".$startPos."&sort=".$sortUrl."+&return=_all_fields,_score";
        }else {
            $strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_priority+asc,goods_sort_score+desc&return=_all_fields,_score";
        }
        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);
        $search_result = json_decode($result, true);

        return $search_result;
    }
}