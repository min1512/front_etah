<?php

class Goods extends MY_Controller
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
        $this->load->model('goods_m');
    }

    /**
     * 상품가격정보 불러오기
     */
    public function goods_price_post()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $param = $this->input->post();

        $goods_info = $this->goods_m->get_goods_price($param['goods_code']);

        if(!$goods_info){
            $this->response(array('status' => 'error', 'message' => '존재하지 않는 상품코드입니다.'), 200);
        }

        $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
        $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');
        //================================== 판매가 기준 할인 계산법
        $seller_coupon_percent	= 0;
        $seller_coupon_amt		= 0;
        $item_coupon_percent	= 0;
        $item_coupon_amt		= 0;

        if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $seller_coupon_amt = floor($goods_info['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT']/$goods_info['SELLING_PRICE']*100);
            }
        }

        if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
            if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $item_coupon_amt = floor($goods_info['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT']/$goods_info['SELLING_PRICE']*100);
            }
        }

        if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
            $tot_coupon_amt		= $seller_coupon_amt + $item_coupon_amt;
            $tot_coupon_price	= $goods_info['SELLING_PRICE'] - $tot_coupon_amt;
            $tot_coupon_percent = $seller_coupon_percent + $item_coupon_percent;
        } else {
            $tot_coupon_amt		= 0;
            $tot_coupon_price	= $goods_info['SELLING_PRICE'];
            $tot_coupon_percent = 0;
        }

        $this->response(array('status' => 'ok', 'selling_price' => $goods_info['SELLING_PRICE'], 'coupon_price' => $tot_coupon_price), 200);
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

        }

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];
        $param['cate_gb'		] = empty($param['cate_gb'			]) ? ''	 : $param['cate_gb'		  ];
        $param['cate_cd'		] = empty($param['cate_cd'			]) ? ''	 : $param['cate_cd'		  ];
        $param['arr_cate'		] = empty($param['arr_cate'			]) ? ''	 : $param['arr_cate'	  ];
        $param['attr'			] = empty($param['attr'				]) ? ''	 : $param['attr'		  ];
        $param['brand_cd'		] = empty($param['brand_cd'			]) ? ''	 : $param['brand_cd'	  ];
        $param['map_nm'		    ] = empty($param['map_nm'			]) ? ''	 : $param['map_nm'	      ];
        $param['order_by'		] = empty($param['order_by'			]) ? 'B' : $param['order_by'	  ];
        $param['deliv_type'	    ] = empty($param['deliv_type'		]) ? ''	 : $param['deliv_type'	  ];
        $param['country'	    ] = empty($param['country'		    ]) ? ''	 : $param['country'	      ];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];
        $param['deli_policy_no'	] = "";

        //상품개수
        $totalCnt = $this->goods_m->get_goods_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //상품리스트
        $goodsList = $this->goods_m->get_goods_list($param);

        //브랜드개수
        $brand_cnt = $this->goods_m->get_brand_goods_count($param);

        //지역개수(공방클래스)
        $map_cnt = $this->goods_m->get_map_goods_count($param);


        //전상품리스트
        $temp['limit_num_rows'  ] = 99999;
        $temp['page'            ] = 1;
        $temp['cate_gb'         ] = $param['cate_gb'    ];
        $temp['cate_cd'         ] = $param['cate_cd'    ];
        $temp['arr_cate'        ] = $param['arr_cate'   ];
        $temp['attr'            ] = $param['attr'       ];
        $temp['brand_cd'        ] = $param['brand_cd'   ];
        $temp['map_nm'          ] = $param['map_nm'     ];

        $all_goodsList = $this->goods_m->get_goods_list($temp);     //상품리스트 전체

        $arr_country        = array();  //국가
        $arr_sellingPrice   = array();  //가격

        foreach($all_goodsList as $all_goods) {
            //국가 리스트
            $country_cd = $all_goods['COUNTRY_CD'];
            $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

            //가격
            $price = $all_goods['SELLING_PRICE'];
            if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
        }

        $data['arr_country'     ] = $arr_country;
        $data['arr_sellingPrice'] = $arr_sellingPrice;



        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods/'.$data['url'];
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
        $data['type'			] = $param['type'			];
        $data['page'			] = $param['page'			];

        $data['limit'			] = $param['limit_num_rows'	];
        $data['cate_gb'			] = $param['cate_gb'        ];
        $data['cate_cd'			] = $param['cate_cd'		];
        $data['arr_cate'		] = $param['arr_cate'		];
        $data['attr_cd'			] = $param['attr'			];
        $data['brand_cd'		] = $param['brand_cd'		];
        $data['map_nm'		    ] = $param['map_nm'		    ];
        $data['order_by'		] = $param['order_by'		];
        $data['deliv_type'		] = $param['deliv_type'		];
        $data['country'		    ] = $param['country'		];
        $data['price_limit'		] = $param['price_limit'	];

        $data['nav'				] = $arrCate;
        $data['category'		] = $category;
        $data['goods'			] = $goodsList;
        $data['total_cnt'		] = $totalCnt;
        $data['brand_cnt'		] = $brand_cnt;
        $data['map_cnt'         ] = $map_cnt;



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
        $data['srp'      ] = $this->input->get('srp');
//        $data['cate_cd'  ] = "";
//        $data['deli_policy_no'] = "";
//        $data['order_by' ] = "";
//        $data['keyword'	 ] = "";
//        $data['r_keyword'] = "";
//        $data['gubun'	 ] = "N";

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
//        if(!$get_vars['cate_cd'	 ]) {
//            $get_vars['cate_cd'] = "";
//        }else{
//
//            $param = explode('/', $get_vars['cate_cd']);
//            $get_vars['fcate_nm'] = $param[0];
//
//
//            if($get_vars['cate_gb'] == 'M') {
//                $get_vars['cate_cd'] = $param[1];
//            }else if($get_vars['cate_gb'] == 'S'){
//                $get_vars['cate_cd'] = $param[2];
//            }else{
//                $get_vars['cate_cd'] = $param[0];
//            }
//        }
//        $get_vars['deli_policy_no'] = "";
//        $get_vars['order_by' ] = "";
//        $get_vars['r_keyword'] = "";
//        $get_vars['gubun'	 ] = "Y";

        //print_r($get_vars);
        //카테고리 상품조회
        self::_brand_goods_list($get_vars);
    }


    /**
     * 브랜드샵 상품리스트
     */
    public function _brand_goods_list($param)
    {
        $data = array();

        $brand   = $this->goods_m->get_brand_detail($param['brand_cd']);    //브랜드정보
        $data['brand'			] = $brand;

        $param['page'			] = empty($param['page'				]) ? '1' : $param['page'		  ];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 40  : $param['limit_num_rows'];
        $param['cate_gb'		] = empty($param['cate_gb'			]) ? 'S' : $param['cate_gb'	      ];
        $param['cate_cd'		] = empty($param['cate_cd'			]) ? ''	 : $param['cate_cd'	      ];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];
        $param['order_by'		] = empty($param['order_by'			]) ? 'B' : $param['order_by'	  ];
        $param['deliv_type'		] = empty($param['deliv_type'		]) ? ''  : $param['deliv_type'	  ];
        $param['country'		] = empty($param['country'		    ]) ? ''  : $param['country'	      ];
        $param['srp'		    ] = empty($param['srp'			    ]) ? ''  : $param['srp'			  ];

        //공방 브랜드관페이지
        if($brand['BRAND_CATEGORY_CD'] == 4010) {

            $gallery = $this->goods_m->get_brand_gallery($param['brand_cd']);   //공방브랜드 갤러리

            //작가님 클래스
            $param['cate_gb'] = 'M';
            $param['cate_cd'] = '24010000';
            $classList  = $this->goods_m->get_goods_list($param);
            $classCnt   = $this->goods_m->get_goods_list_count($param);

            //공방 제작 상품
            $param['cate_cd'] = '24020000';
            $goodsCnt = $this->goods_m->get_goods_list_count($param);
            $param['limit_num_rows'] = 4;
            $goodsList = $this->goods_m->get_goods_list($param);

            //상품평 템플릿 구성
            $temp = array();
            $temp['goods_code'	] = $param['brand_cd'];
            $paging_limit	= 5;
            $goods_comment_num = $this->goods_m->get_goods_comment_cnt($param['brand_cd']);		//상품평 전체 갯수 불러오기
            $total_goods_comment_val = $this->goods_m->get_goods_comment($param['brand_cd'], 0, 0);		//상품평 전체 평점 불러오기
            $goods_comment		= $this->goods_m->get_goods_comment($param['brand_cd'], 1, $paging_limit);	//상품평 불러오기
            $temp['total_comment_val'	] = $total_goods_comment_val;
            $temp['goods_comment'		] = $goods_comment;

            //페이징 구성
            $temp['page'		] = 1;		//현재페이지
            $temp['total_page'	] = ceil($goods_comment_num['cnt'] / $paging_limit);		//전체 페이지 갯수
            $temp['limit_num'	] = $paging_limit;					//한 페이지에 보여주는 갯수
            $temp['total_cnt'	] = $goods_comment_num['cnt'];		//전체 갯수
            $temp['template_gb' ] = 'B';
            $comment_template = $this->load->view('goods/template_comment', $temp, TRUE);

            $data['comment_template'] = $comment_template;
            $data['goods'			] = $goodsList;
            $data['class'			] = $classList;
            $data['goods_cnt'		] = $goodsCnt;
            $data['class_cnt'		] = $classCnt;
            $data['gallery'			] = $gallery;
        }
        //일반 브랜드관페이지
        else {
            log_message('DEBUG', '========= brand get');
            $totalCnt = $this->goods_m->get_goods_list_count($param);
            $data['total_cnt'       ] = $totalCnt;

            //상품리스트
            $goodsList = $this->goods_m->get_goods_list($param);
            $data['goods'			] = $goodsList;

            //전체상품정보 구하기
            $iparam = array();
            $iparam['brand_cd'] = $param['brand_cd'];
            $all_goodsList = $this->goods_m->get_goods_list($iparam);

            $arr_cate1 = array();   //카테고리1
            $arr_cate2 = array();   //카테고리2
            $arr_cate3 = array();   //카테고리3

            $cur_category = array(); //선택한 카테고리정보
            $arr_country = array();  //국가
            $arr_sellingPrice = array();   //가격

            foreach($all_goodsList as $all_goods) {
                //카테고리 리스트
                $arr_cate1[$all_goods['CATEGORY_CD1']]['CODE'] = $all_goods['CATEGORY_CD1'];
                $arr_cate1[$all_goods['CATEGORY_CD1']]['NAME'] = $all_goods['CATEGORY_NM1'];

                $arr_cate2[$all_goods['CATEGORY_CD2']]['CODE'] = $all_goods['CATEGORY_CD2'];
                $arr_cate2[$all_goods['CATEGORY_CD2']]['NAME'] = $all_goods['CATEGORY_NM2'];
                $arr_cate2[$all_goods['CATEGORY_CD2']]['PARENT_CODE'] = $all_goods['CATEGORY_CD1'];

                $arr_cate3[$all_goods['CATEGORY_CD3']]['CODE'] = $all_goods['CATEGORY_CD3'];
                $arr_cate3[$all_goods['CATEGORY_CD3']]['NAME'] = $all_goods['CATEGORY_NM3'];
                $arr_cate3[$all_goods['CATEGORY_CD3']]['PARENT_CODE'] = $all_goods['CATEGORY_CD2'];

                //선택한 카테고리 정보
                if($param['cate_cd']==$all_goods['CATEGORY_CD3']) {
                    $cur_category['CATE_CD1'] = $all_goods['CATEGORY_CD1'];
                    $cur_category['CATE_NM1'] = $all_goods['CATEGORY_NM1'];
                    $cur_category['CATE_CD2'] = $all_goods['CATEGORY_CD2'];
                    $cur_category['CATE_NM2'] = $all_goods['CATEGORY_NM2'];
                    $cur_category['CATE_CD3'] = $all_goods['CATEGORY_CD3'];
                    $cur_category['CATE_NM3'] = $all_goods['CATEGORY_NM3'];
                }

                //국가 리스트
                $country_cd = $all_goods['COUNTRY_CD'];
                $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

                //가격
                $price = $all_goods['SELLING_PRICE'];
                if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
            }

            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['arr_cate3'       ] = $arr_cate3;
            $data['arr_country'     ] = $arr_country;
            $data['arr_sellingPrice'] = $arr_sellingPrice;
            $data['cur_category'    ] = $cur_category;


            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods/brand_page';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt;
            $config['per_page'		] = $param['limit_num_rows'];
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);

            $data['pagination'		] = $this->pagination->create_links();
        }

        $data['brand_cd'		] = $param['brand_cd'		];
        $data['page'			] = $param['page'			];
        $data['limit'			] = $param['limit_num_rows'	];
        $data['cate_gb'		    ] = $param['cate_gb'	    ];
        $data['cate_cd'		    ] = $param['cate_cd'	    ];
        $data['price_limit'	    ] = $param['price_limit'	];
        $data['deliv_type'	    ] = $param['deliv_type'	    ];
        $data['country'	        ] = $param['country'	    ];
        $data['order_by'		] = $param['order_by'		];
        $data['srp'		        ] = $param['srp'		    ];


        //상품개수
//        if($param['cate_gb']) {
//            $catedata = $param['cate_gb'];
//            $totalCnt = $this->goods_m->get_goods_list_count($param);
//            $param['cate_gb'] = '';
//            $toCnt = $this->goods_m->get_goods_list_count($param);
//            $data['total_cnt'       ] = $toCnt;
//            if(empty($param['page'])){
//                $param['page'] = 1;
//            }
//            if($totalCnt != 0){
//                $totalPage = ceil($totalCnt / $param['limit_num_rows']);
//            }
        //카테고리별 상품 개수
        //$nav_List = $this->goods_m->get_brand_list_count($param,(int)$toCnt,'');

        //대분류 카테고리 상품개수
        //$cate_count = $this->goods_m->get_brand_list_count($param,(int)$toCnt, 1);

        //소분류 카테고리 상품개수
        //$s_nav_List = $this->goods_m->get_brand_list_count($param,(int)$toCnt, 2);

//            $cate_parent = array();
//            $cate_grand  = array();
//            for ($i = 0; $i < count($nav_List); $i++ ){
//                $cate_parent[$i] =  $nav_List[$i]['PARENT_CATEGORY_DISP_CD'];
//                $cate_grand[$i]  =  $nav_List[$i]['GRAND_CATE_CD'          ];
//            }
//            $result   = array_unique($cate_parent);
//            $g_result = array_unique($cate_grand);
//            rsort($result);
//            rsort($g_result);
//            //상위 카테고리
//            $data['cate_nm'         ]  = $this->goods_m->get_brand_cate($result);
//            $data['grand_cate_nm'   ]  = $this->goods_m->get_brand_cate($g_result);
//            $param['cate_gb'] = $catedata;
        //상품리스트
//            $goodsList = $this->goods_m->get_goods_list($param);
//        }else{
//            $totalCnt = $this->goods_m->get_goods_list_count($param);
//            $data['total_cnt'       ] = $totalCnt;
//
//            if(empty($param['page'])){
//                $param['page'] = 1;
//            }
//            if($totalCnt != 0){
//                $totalPage = ceil($totalCnt / $param['limit_num_rows']);
//            }
        //카테고리별 상품 개수
        //$nav_List = $this->goods_m->get_brand_list_count($param,(int)$totalCnt, '');

        //대분류 카테고리 상품개수
        //$cate_count = $this->goods_m->get_brand_list_count($param,(int)$totalCnt, 1);

        //소분류 카테고리 상품개수
        //$s_nav_List = $this->goods_m->get_brand_list_count($param,(int)$totalCnt, 2);

//            $cate_parent = array();
//            $cate_grand  = array();
//            for ($i = 0; $i < count($nav_List); $i++ ){
//                $cate_parent[$i] =  $nav_List[$i]['PARENT_CATEGORY_DISP_CD'];
//                $cate_grand[$i]  =  $nav_List[$i]['GRAND_CATE_CD'          ];
//            }
//            $result   = array_unique($cate_parent);
//            $g_result = array_unique($cate_grand);
//            rsort($result);
//            rsort($g_result);
//            //상위 카테고리
//            $data['cate_nm'         ]  = $this->goods_m->get_brand_cate($result);
//            $data['grand_cate_nm'   ]  = $this->goods_m->get_brand_cate($g_result);
        //상품리스트
//            $goodsList = $this->goods_m->get_goods_list($param);
//        }

//        //페이지네비게이션
//        $this->load->library('pagination');
//        $config['base_url'		] = base_url().'goods/brand_page';
//        $config['uri_segment'	] = '3';
//        $config['total_rows'	] = $totalCnt;
//        $config['per_page'		] = $param['limit_num_rows'];
//        $config['num_links'		] = '10';
//        $config['suffix'		] = '?'.http_build_query($param, '&');
//        $this->pagination->initialize($config);

        //$data['map']['x'] = "";
        //$data['map']['y'] = "";

        //지도 삽입
        /*if($brand['MAP_URL']){
            $addr = $brand['MAP_URL'];
            $hostname = $_SERVER["HTTP_HOST"];

            if($hostname == 'dev.etah.co.kr'){
                $cId = "kdc3WyjKgWP3No_KOHcf";
                $cSecret = "EH7UX94Djl";
            }else{
                $cId = "BHJiGh78L7DhXoXjOLhe";
                $cSecret = "2KLiUQX2Ko";
            }

            $addr = urlencode($addr);
            $url = "https://openapi.naver.com/v1/map/geocode?encoding=utf-8&coord=latlng&output=json&query=".$addr;

            $headers = array();
            $headers[] = "GET https://openapi.naver.com/v1/map/geocode?".$addr;
            $headers[] ="Host: openapi.naver.com";
            $headers[] ="Accept:";
            $headers[] ="Content-Type: application/json";
            $headers[] ="X-Naver-Client-Id: ".$cId;
            $headers[] ="X-Naver-Client-Secret: ".$cSecret;
            $headers[] ="Connection: Close";

            $result = self::_getHttp($url, $headers);
            var_dump($result);
            $data['map'] = $result['result']['items'][0]['point'];

            var_dump($result['result']['items'][0]['point']);
        }

        var_dump($data['map']);*/

//        //공방 브랜드관페이지
//        if($brand['BRAND_CATEGORY_CD'] == 4010) {
//            //작가님 클래스
//            $param['cate_gb'] = 'M';
//            $param['cate_cd'] = '24010000';
//            $classList = $this->goods_m->get_goods_list($param);
//            $classCnt = $this->goods_m->get_goods_list_count($param);
//
//            //공방 제작 상품
//            $param['cate_cd'] = '24020000';
//            $goodsCnt = $this->goods_m->get_goods_list_count($param);
//            $param['limit_num_rows'] = 4;
//            $goodsList = $this->goods_m->get_goods_list($param);
//
//            //상품평 템플릿 구성
//            $temp = array();
//            $temp['goods_code'	] = $param['brand_cd'];
//            $paging_limit	= 5;
//            $goods_comment_num = $this->goods_m->get_goods_comment_cnt($param['brand_cd']);		//상품평 전체 갯수 불러오기
//            $total_goods_comment_val = $this->goods_m->get_goods_comment($param['brand_cd'], 0, 0);		//상품평 전체 평점 불러오기
//            $goods_comment		= $this->goods_m->get_goods_comment($param['brand_cd'], 1, $paging_limit);	//상품평 불러오기
//            $temp['total_comment_val'	] = $total_goods_comment_val;
//            $temp['goods_comment'		] = $goods_comment;
//
//            //페이징 구성
//            $temp['page'		] = 1;		//현재페이지
//            $temp['total_page'	] = ceil($goods_comment_num['cnt'] / $paging_limit);		//전체 페이지 갯수
//            $temp['limit_num'	] = $paging_limit;					//한 페이지에 보여주는 갯수
//            $temp['total_cnt'	] = $goods_comment_num['cnt'];		//전체 갯수
//            $temp['template_gb' ] = 'B';
//            $comment_template = $this->load->view('goods/template_comment', $temp, TRUE);
//
////            $comment_template = $this->load->view('goods/template_comment2', $temp, TRUE);
//
//
//            $data['comment_template'] = $comment_template;
//
//
//            $data['comment_template'] = $comment_template;
//        }

//        $data['pagination'		] = $this->pagination->create_links();
//        $data['page'			] = $param['page'			];
//        $data['keyword'			] = $param['keyword'		];
//        $data['price_limit'	    ] = $param['price_limit'	];
//        $data['brand_cd'		] = $param['brand_cd'		];
//        $data['order_by'		] = $param['order_by'		];
//        $data['limit'			] = $param['limit_num_rows'	];
//        $data['gubun'			] = $param['gubun'			];
//        $data['brand'			] = $brand;
//        $data['goods'			] = $goodsList;
//        $data['class'			] = $classList;
//        $data['goods_cnt'		] = $goodsCnt;
//        $data['class_cnt'		] = $classCnt;
//        $data['gallery'			] = $gallery;
        //$data['total_cnt'		] = $totalCnt;
//		$data['nav'             ] = $nav_List;
//		$data['s_nav'           ] = $s_nav_List;
//		if($param['cate_cd']) {
//            $data['nav_cd'  ] = $param['cate_cd'];
//            $data['fcate_nm'] = $param['fcate_nm'];
//            $data['cate_gb' ] = $param['cate_gb'];
//        }
//        for($i = 0; $i < count( $data['grand_cate_nm']); $i++){
//		    for($j = 0; $j <count($cate_count); $j++){
//                if( $data['grand_cate_nm'][$i]['CATEGORY_DISP_CD'] == $cate_count[$j]['GRAND_CATE_CD']){
//                    $data['grand_cate_nm'][$i]['cnt'] = $cate_count[$j]['cnt'];
//                }
//            }
//        }

        //var_dump($goodsList);



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
     * curl 통신 하기
     */
    public function _getHttp($url, $headers=null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result,1);
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
     * 검색결과 리스트 2017-02-15 중분류추가 2017-02-16 소분류 추가
     */
    public function goods_search_get()
    {
        /* model_m */
        $this->load->model('goods2_m');
        $param = $this->input->get();

        $param['attr'			] = "";
        $param['brand_nm'		] = empty($param['brand_nm'			]) ? ''  : $param['brand_nm'];
        $param['cate_nm'		] = empty($param['cate_nm'			]) ? ''  : $param['cate_nm'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'B' : $param['order_by'];
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
//		$startPos = ($param['page']-1) * $limit_num_rows;
        $startPos = 0;

//		$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&&sort=_score+desc&q.options={fields:['goods_nm^5','brand_nm^2']}&return=_all_fields,_score";

//		$hostname = $_SERVER["HTTP_HOST"]; //도메인명(호스트)명을 구합니다.

//		if($hostname == 'dev.etah.co.kr'){
//			$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=_score+desc&return=_all_fields,_score";
//		}else{
        $strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=_score+desc&return=_all_fields,_score";
//		}

//		$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("두닷")."&size=20&start=0&sort=_score+desc&return=_all_fields,_score";

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

//var_dump($search_data);

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

//			var_dump($arr_brand);
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
            arsort($arr_brand_nm);
        }

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

//		var_dump($arr_cate_cd);
//var_dump($arr_cate2);
        //카테고리별 상품개수 담음 (대카테)
        if($arr_cate){
//			asort($arr_cate);
//			asort($arr_cate_cd);

            $str_cate = $arr_cate[0];

            /** 배열 초기값 셋팅 **/
            foreach($arr_cate as $cate){
                $arr_cate_nm[$cate]['cnt'] = 0;
            }

            $cidx = 0;
            foreach($arr_cate as $cate){
//				if($str_cate == $cate){
                $arr_cate_nm[$cate]['cnt'] ++;
//				}
//				else{
//					$str_cate = $cate;
//					$arr_cate_nm[$cate]['cnt'] = 1;
//				}

                if($cate == $arr_cate[$cidx]){
                    $arr_cate_nm[$cate]['code'] = $arr_cate_cd[$cidx];
                }
                $cidx ++;
            }
        }
//var_dump($arr_cate_nm);
        //카테고리별 상품개수 담음 (중카테)
        if($arr_cate2){
//			asort($arr_cate2);

            $str_cate = $arr_cate2[0];

            /** 배열 초기값 셋팅 **/
            foreach($arr_cate2 as $cate2){
                $arr_cate_nm2[$cate2]['cnt'] = 0;
            }

            $cidx = 0;
            foreach($arr_cate2 as $cate2){
//				if($str_cate == $cate2){
                $arr_cate_nm2[$cate2]['cnt'] ++;
//				}else{
//					$str_cate = $cate2;
//					$arr_cate_nm2[$cate2]['cnt'] = 1;
//				}

                if($cate2 == $arr_cate2[$cidx]){
                    $arr_cate_nm2[$cate2]['code'		] = $arr_cate_cd2[$cidx];
                    $arr_cate_nm2[$cate2]['parent_code'	] = $arr_cate_cd[$cidx];
                }

//				$cate_detail_result = $this->category_m->get_category_detail($arr_cate_cd2[$cidx],'M');
//				var_dump($cate_detail_result);
//				$arr_cate_nm2[$cate2]['parent_code'] = $cate_detail_result['CATE_CODE1'];

                $cidx ++;
            }
        }

        //카테고리별 상품개수 담음 (소카테)
        if($arr_cate3){
//			asort($arr_cate3);

            $str_cate = $arr_cate3[0];

            /** 배열 초기값 셋팅 **/
            foreach($arr_cate3 as $cate3){
                $arr_cate_nm3[$cate3]['cnt'] = 0;
            }

            $cidx = 0;
            foreach($arr_cate3 as $cate3){
//				if($str_cate == $cate3){
                $arr_cate_nm3[$cate3]['cnt'] ++;
//				}else{
//					$str_cate = $cate3;
//					$arr_cate_nm3[$cate3]['cnt'] = 1;
//				}

                if($cate3 == $arr_cate3[$cidx]){
                    $arr_cate_nm3[$cate3]['code'		] = $arr_cate_cd3[$cidx];
                    $arr_cate_nm3[$cate3]['parent_code'	] = $arr_cate_cd2[$cidx];
                }

                $arr_cate_nm3[$cate3]['code'] = $arr_cate_cd3[$cidx];
                $cidx ++;
            }
        }

        arsort($arr_cate_nm);
        arsort($arr_cate_nm2);
        arsort($arr_cate_nm3);
//		var_dump($arr_cate_nm3);

//		var_dump($arr_cate_nm);

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];

        /* 페이징 */
        $startPos = ($param['page']-1) * $param['limit_num_rows'];
        $limit_num_rows	= $param['limit_num_rows'];

        /* 브랜드 검색 */
        if($param['brand_nm']) $keyword = $keyword.'&('.substr($param['brand_nm'],1).')';

//		var_dump(substr($param['brand_nm'],1));

        /* 카테고리 검색 */
        if($param['cate_nm']){
            $param['cate_nm'] = str_replace("%%",'&',$param['cate_nm']);
            $keyword = $keyword.'&'.$param['cate_nm'];
        }
//var_dump($keyword);
        switch($param['order_by']){
            case 'A' :	$field = "goods_cd";
                $sort = "desc"; break;
            case 'B' :	$field = "_score";
                $sort = "desc"; break;
            case 'C' :	$field = "selling_price";
                $sort = "asc"; break;
            case 'D' :	$field = "selling_price";
                $sort = "desc"; break;
        }

//		if($hostname == 'dev.etah.co.kr'){
//			$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=_score+desc&return=_all_fields,_score";
//		}else{
        $strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=".$field."+".$sort."+&return=_all_fields,_score";
//		}
//var_dump($keyword);
//var_dump($strRequestUri);
//var_dump("http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".$keyword."&size=".$limit_num_rows."&start=".$startPos."&sort=_score+desc&return=_all_fields,_score");

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);

        $search_result = json_decode($result, true);

        $goods_cd = "";
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
            }

        }


//		var_dump($arr_price);



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
        $data['arr_price'	] = $arr_price;
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

        $option = $this->goods_m->get_goods_moption_info($param2);

        if(!$option) {
            $this->response(array('status' => 'single'), 200);
        } else {
            $this->response(array('status' => 'ok', 'moption_result' => $option['MOPTION_RESULT'], 'option_code' => $option['GOODS_OPTION_CD'], 'moption1' => $option['M_OPTION_1'], 'moption2' => $option['M_OPTION_2'], 'moption3' => $option['M_OPTION_3'], 'moption4' => $option['M_OPTION_4'], 'moption5' => $option['M_OPTION_5'], 'option_add_price' => $option['GOODS_OPTION_ADD_PRICE'], 'option_qty' =>$option['QTY'], 'option_subqty' => $option['SUB_QTY']), 200);
        }

    }

    /**
     * 상품 상세 쿠폰 레이어
     */
    public function coupon_layer_post()
    {
        $this->load->model('goods_m');
        $this->load->model('cart_m');

        $param = $this->input->post();

        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($param['goods_code']);

        //상품 쿠폰 정보 구하기
        $param['brand_code'	] = $goods['BRAND_CD'];
        $param['category_mng_code'] = $goods['CATEGORY_MNG_CD3'];

        $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
        $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

        $data['goods'] = $goods;

        $coupon_info = "";
        $coupon_price = 0;

//================================== 판매가 기준 할인 계산법
        $seller_coupon_percent	= 0;
        $seller_coupon_amt		= 0;
        $item_coupon_percent	= 0;
        $item_coupon_amt		= 0;

        if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }

            $data['goods']['SELLER_COUPON_CD'			] = $goods_seller_coupon['COUPON_CD'];
            $data['goods']['SELLER_COUPON_METHOD'		] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
            $data['goods']['SELLER_COUPON_FLAT_RATE'	] = $goods_seller_coupon['COUPON_FLAT_RATE'];
            $data['goods']['SELLER_COUPON_FLAT_AMT'		] = $goods_seller_coupon['COUPON_FLAT_AMT'];
            $data['goods']['SELLER_COUPON_MAX_DISCOUNT'	] = $goods_seller_coupon['MAX_DISCOUNT'];
            $data['goods']['SELLER_COUPON_AMT'			] = $seller_coupon_amt;
        }

        if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
            if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }

            $data['goods']['ITEM_COUPON_CD'				] = $goods_item_coupon['COUPON_CD'];
            $data['goods']['ITEM_COUPON_METHOD'			] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
            $data['goods']['ITEM_COUPON_FLAT_RATE'		] = $goods_item_coupon['COUPON_FLAT_RATE'];
            $data['goods']['ITEM_COUPON_FLAT_AMT'		] = $goods_item_coupon['COUPON_FLAT_AMT'];
            $data['goods']['ITEM_COUPON_MAX_DISCOUNT'	] = $goods_item_coupon['MAX_DISCOUNT'];
            $data['goods']['ITEM_COUPON_AMT'			] = $item_coupon_amt;
        }
//var_dump($seller_coupon_percent);
//var_dump($item_coupon_percent);
//var_dump($seller_coupon_amt);
//var_dump($item_coupon_amt);
        if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
            $data['goods']['COUPON_AMT'		] = $seller_coupon_amt + $item_coupon_amt;
            $data['goods']['COUPON_PRICE'	] = $goods['SELLING_PRICE'] - $seller_coupon_amt - $item_coupon_amt;
            $data['goods']['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
        } else {
            $data['goods']['COUPON_AMT'			] = 0;
            $data['goods']['COUPON_PRICE'		] = $goods['SELLING_PRICE'];
            $data['goods']['COUPON_SALE_PERCENT'] = 0;
        }

        /** 사용 가능한 쿠폰 리스트 가져오기 */
        $auto_coupon = $this->cart_m->get_coupon_info($param, 'AUTO');
        $cust_coupon = $this->cart_m->get_coupon_info($param, 'ADD');


        for($i = 0; $i<count($auto_coupon); $i++){
            if($auto_coupon[$i]['COUPON_DC_METHOD_CD'] == 'RATE') {
                $coupon_num = explode('.', $auto_coupon[$i]['COUPON_SALE']);

                if ($coupon_num[1] == '0') {
                    $auto_coupon[$i]['COUPON_SALE'] = $coupon_num[0];
                }
            }
        }
        $data['AUTO_COUPON_LIST'] = $auto_coupon;
        $data['CUST_COUPON_LIST'] = $cust_coupon;

        $data['option_add_price'] = $param['option_add_price'];
        $data['idx'				] = $param['idx'];
        $data['coupon_num']    =   $coupon_num;

        $coupon_layer = $this->load->view('goods/coupon_layer.php', $data, TRUE); //쿠폰 레이어 열기

        $this->response(array('status' => 'ok', 'coupon_layer'=>$coupon_layer), 200);
    }

    /**
     * 상품 상세 - 방문예약 레이어
     */
    public function reservation_layer_post()
    {
        $param = $this->input->post();

        $data['goods_cd'] = $param['goods_cd'];

        $reservation_layer = $this->load->view('goods/reservation_layer.php', $data, TRUE); //쿠폰 레이어 열기

        $this->response(array('status' => 'ok', 'reservation_layer' => $reservation_layer), 200);
    }

    /**
     * 상품 상세 - 방문에약
     */
    public function visit_reservation_post()
    {
        $param = $this->input->post();

        $param['mob_no'] = $param['tel1']."-".$param['tel2']."-".$param['tel3'];

        $arr = explode("-", $param['time']);
        $param['start_dt' ] = $param['date']." ".$arr[0].":00";
        $param['end_dt'   ] = $param['date']." ".$arr[1].":00";

        $result = $this->goods_m->reg_reservation($param);

        //Load MODEL
        $this->load->model('order_m');

        if($result) {
            //방문예약정보 SMS발송 - 고객
            $kakao['SMS_MSG_GB_CD'] = 'KAKAO';
            $kakao['MSG'] = "[에타홈] 예약완료

".$param['name']." 고객님, 클러프트 매장
방문 예약이 완료되었습니다^^

클러프트에서
확인전화 드릴 예정입니다

조금만 기다려 주세요 ~!

▶ 예약자: ".$param['name']."
▶ 예약일: ".$param['date']." ".$param['time']."

▼예약확인▼
http://m.etahome.co.kr/visit/cust/".$result;
            $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019110514075716788360151';
            $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
            $kakao['DEST_PHONE'] = str_replace('-','',$param['mob_no']);
            $sendSMS = $this->order_m->send_sms_kakao($kakao);

            //방문예약정보 SMS발송 - 업체
            $kakao['SMS_MSG_GB_CD'] = 'KAKAO';
            $kakao['MSG'] = "[에타] 예약알람

".$param['name']." 고객님이 클러프트 매장 방문을 예약했습니다^^
고객님께 전화해 예약일을 확정해주세요

▶ 예약자: ".$param['name']."
▶ 예약일: ".$param['date']." ".$param['time']."

▼예약확인▼
http://m.etah.co.kr/visit/seller/".$result;
            $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019110514100822317727188';
            $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
            $kakao['DEST_PHONE'] = '01093777877';
            $sendSMS = $this->order_m->send_sms_kakao($kakao);

            $this->response(array('status' => 'ok', 'message' => '예약 성공'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => '예약 실패'), 200);
        }

    }

    /**
     * 상품 상세 보기
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
        $this->load->model('main_m');
        $this->load->model('cart_m');
        $this->load->model('mywiz_m');

        //유입경로 확인
        $utm = $this->input->get();
        if(isset($utm)){
            if(strpos(@$utm['utm_source'], 'wonder_shopping') !== false){    //원더쇼핑 유입
                setcookie('funnel', 'wonder', time() + 3600,'/');
            }
        }

        //상품 클릭수 증가
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; //AWS ping 접속 제외
        if(!empty($ip)) {
            $click = $this->goods_m->goods_click($goods_code);
        }

        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($goods_code);

        //연결된 태그이름 배열로 저장
        if(!empty($goods['TAG_NM'])){
            $data['tag'] = explode('|', $goods['TAG_NM']);
        }

        if(empty($goods)){	//상품코드에 일치하는 상품이 없을 경우 에러페이지 보여주기
            /**
             * 최근 본 상품 쿠키 저장
             */
            $this->load->library('etah_lib');

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
            $this->load->view('template/error_404');
            $this->load->view('include/footer');
        } else {
            //네이버페이 구매버튼 가능여부
            if($goods['CATEGORY_MNG_CD2']==24010000 || $goods['GOODS_STATE_CD']!='03'){ //공방클래스, 품절/일시정지
                $data['ENABLE'] = 'N';
            } else {
                $data['ENABLE'] = 'Y';
            }

//			//상품 구매가이드 변수 기본 셋팅
//			$data['goods_guide'		] = 'N';
//			$data['category_guide'	] = 'N';
//			$data['brand_guide'		] = 'N';
//
//			//상품 구매가이드 구하기 (상품)
//			$goods_guide	= $this->goods_m->get_goods_guide_info($goods_code, 'GOODS');
//			if($goods_guide){
//				$data['goods_guide'	] = 'Y';
//			}
//
//			//상품 구매가이드 구하기 (카테고리)
//			$category_guide	= $this->goods_m->get_goods_guide_info($goods_code, 'CATEGORY');
//			if($category_guide){
//				$data['category_guide'	] = 'Y';
//			}
//
//			//상품 구매가이드 구하기 (브랜드)
//			$brand_guide	= $this->goods_m->get_goods_guide_info($goods_code, 'BRAND');
//			if($brand_guide){
//				$data['brand_guide'	] = 'Y';
//			}

            //상품 구매가이드 구하기 (상품&카테고리&브랜드)
            $goods_buy_guide = $this->goods_m->get_goods_guide_info($goods_code);
            $data['goods_buy_guide'] = $goods_buy_guide;

            if($goods_buy_guide){
                $data['goods_buy_guide'] = $goods_buy_guide;
            } else {
                $data['goods_buy_guide'] = '';
            }

            //상품 쿠폰 정보 구하기
            $param['goods_code'	] = $goods_code;
            $param['brand_code'	] = $goods['BRAND_CD'];
            $param['category_mng_code'] = $goods['CATEGORY_MNG_CD3'];
            $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
            $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

            //상품 속성 정보 구하기
            $goods_class = $this->goods_m->get_goods_class($goods_code);
            $data['goods_class'		] = $goods_class;

//			//상품 설명 리스트 갯수
//			$goods_desc = $this->goods_m->get_goods_desc($goods_code);
//			$data['goods_desc_cnt'	] = count($goods_desc);


//            if($goods['CATEGORY_MNG_CD2'] == 24010000) {
//                //관련상품 구하기
//                $relate_goods = $this->goods_m->get_goods('R', $goods['CATEGORY_MNG_CD2'], $goods_code, '');
//                $data['relate_goods'    ] = $relate_goods;
//
//                //공방제작 상품 구하기
//                $made_goods = $this->goods_m->get_goods('M', 24020000, $goods_code, $goods['BRAND_CD']);
//                $data['made_goods'    ] = $made_goods;
//            } else {
//                //동일 브랜드 상품 구하기
//                $brand_goods2 = $this->goods_m->get_brand_goods($goods['BRAND_CD'], $goods_code, $goods['CATEGORY_MNG_CD3']);
//                if(!empty($brand_goods2)) {
//                    if( count($brand_goods2) > 3 ) { $limit = 3; }
//                    else { $limit = count($brand_goods2); }
//
//                    for ($i = 0; $i < $limit; $i++) {
//                        $brand_goods[$i] = $brand_goods2[$i];
//                    }
//                    $data['brand_goods'] = $brand_goods;
//                }
//            }

            //상품 태그 구하기
            $data['tag'] = $this->goods_m->get_goods_tag($goods_code);

            //에타 이벤트 배너
            $data['event'] = $this->main_m->get_main_banner('WEB_GOODS_BANNER');

            //MD추천멘트
            $data['mdTalk'] = $this->goods_m->get_mdTalk($goods_code);

            //상품이 포함된 기획전
            $plan_event = $this->goods_m->get_plan_event_in_goods('A', $goods_code, '');

            if (count($plan_event) == 0) { //상품 포함된 기획전 없을때 -> 인기기획전
                $plan_event = $this->goods_m->get_plan_event_in_goods('B', $goods_code, $goods['CATEGORY_MNG_CD1']);

                if(count($plan_event)==0){
                    $plan_event = $this->goods_m->get_plan_event_in_goods('B', $goods_code, '');
                }
            }
            $data['plan_event'] = $plan_event;

            //상품이 포함된 매거진
            $magazine = $this->goods_m->get_magazine_in_goods('A', $goods_code, '');
            if (count($magazine) == 0) { //상품 포함된 매거진 없을때 -> 인기매거진
                $magazine = $this->goods_m->get_magazine_in_goods('B', $goods_code, $goods['CATEGORY_MNG_CD1']);
            }
            $data['magazine'] = $magazine;

            //카테고리 베스트 상품
            $data['category_goods'] = $this->goods_m->get_goods('C', $goods['CATEGORY_MNG_CD3'], $goods_code, $goods['BRAND_CD']);

            //브랜드 베스트 상품
            $data['brand_goods'] = $this->goods_m->get_goods('B', '', $goods_code, $goods['BRAND_CD']);

            //상품 옵션 구하기
            $goods_option = $this->goods_m->get_goods_option($goods_code);
            $data['goods_option'	] = $goods_option;

            //상품 옵션정보 구하기
            $goods_option_info = $this->goods_m->get_goods_option_info($goods_code);
            if( empty($goods_option_info) ){
                $goods_option_info['M_OPTION_1_NM'] = '선택1';
                $goods_option_info['M_OPTION_2_NM'] = '선택2';
                $goods_option_info['M_OPTION_3_NM'] = '선택3';
                $goods_option_info['M_OPTION_4_NM'] = '선택4';
                $goods_option_info['M_OPTION_5_NM'] = '선택5';
            }
            $data['goods_option_info'	] = $goods_option_info;

            if($goods_option){
                $goods_moption1 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_1');
                $data['goods_moption1'	] = $goods_moption1;

                if($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1'){
                    $goods_moption2 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_2');
                    $data['goods_moption2'	] = $goods_moption2;
                }

                if(($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_2')){
                    $goods_moption3 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_3');
                    $data['goods_moption3'	] = $goods_moption3;
                }

                if(($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_2') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_3')){
                    $goods_moption4 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_4');
                    $data['goods_moption4'	] = $goods_moption4;
                }

                if(($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_2') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_3') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_4')){
                    $goods_moption5 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_5');
                    $data['goods_moption5'	] = $goods_moption5;
                }

                //상품옵션구하기 테스트
                if($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_5'){
                    $max_moption = '5';
                } else if($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_4'){
                    $max_moption = '4';
                } else if($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_3'){
                    $max_moption = '3';
                } else if($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_2'){
                    $max_moption = '2';
                } else {
                    $max_moption = '1';
                }

                $template_option_list = $this->goods_m->get_template_option_list($goods_code, $max_moption);
//				var_dump($template_option_list);
//                array_multisort($template_option_list['GOODS_OPTION_CD'], SORT_ASC);
//                arsort($template_option_list['GOODS_OPTION_CD'])
                $data['template_option_list'] = $template_option_list;
                $data['MOPTION_RESULT']	= $goods_option[0]['MOPTION_RESULT'];
            } else {
                $data['goods_moption1'		] = '';
                $data['goods_moption2'		] = '';
                $data['goods_moption3'		] = '';
                $data['goods_moption4'		] = '';
                $data['goods_moption5'		] = '';
                $data['MOPTION_RESULT'		] = '';
                $data['template_option_list'] = '';
            }
//var_dump($template_option_list);
            //상품 정보고시 구하기
            $goods_extend		= $this->goods_m->get_goods_extend($param);
            if($goods_extend){
                $goods_extend_info	= $this->goods_m->get_goods_exnted_info($goods_extend['kind']);

                $data['goods_extend'		] = $goods_extend;
                $data['goods_extend_info'	] = $goods_extend_info;
            }

            //상품 추가배송비 지역 구하기
            if($goods['ADD_DELIVERY']){
                $goods_add_deli = $this->goods_m->get_goods_add_deli($param);
                $data['goods_add_deli'	] = $goods_add_deli;
            }

            //상품 배송불가지역 구하기
            if($goods['NO_DELIVERY']){
                $goods_no_deli = $this->goods_m->get_goods_no_deli($param);
                $data['goods_no_deli'	] = $goods_no_deli;
            }

            //상품 이미지 구하기
            $goods_img = $this->goods_m->get_goods_img($goods_code);

            for ($i = 0; $i < count($goods_img); $i++) {
                $goods['img'][$i] = $goods_img[$i]['IMG_URL'];
            }

            $data['goods'] = $goods;


            $coupon_info = "";
            $coupon_price = 0;

            //================================== 판매가 기준 할인 계산법
            $seller_coupon_percent	= 0;
            $seller_coupon_amt		= 0;
            $item_coupon_percent	= 0;
            $item_coupon_amt		= 0;

            if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
                if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                    $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                    $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                    if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                        $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                    }
                } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                    $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                    $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
                }

                $data['goods']['SELLER_COUPON_CD'			] = $goods_seller_coupon['COUPON_CD'];
                $data['goods']['SELLER_COUPON_METHOD'		] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
                $data['goods']['SELLER_COUPON_FLAT_RATE'	] = $goods_seller_coupon['COUPON_FLAT_RATE'];
                $data['goods']['SELLER_COUPON_FLAT_AMT'		] = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $data['goods']['SELLER_COUPON_MAX_DISCOUNT'	] = $goods_seller_coupon['MAX_DISCOUNT'];
                $data['goods']['SELLER_COUPON_AMT'			] = $seller_coupon_amt;
            }

            if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
                if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                    $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                    $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                    if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                        $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                    }
                } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                    $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                    $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
                }

                $data['goods']['ITEM_COUPON_CD'				] = $goods_item_coupon['COUPON_CD'];
                $data['goods']['ITEM_COUPON_METHOD'			] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
                $data['goods']['ITEM_COUPON_FLAT_RATE'		] = $goods_item_coupon['COUPON_FLAT_RATE'];
                $data['goods']['ITEM_COUPON_FLAT_AMT'		] = $goods_item_coupon['COUPON_FLAT_AMT'];
                $data['goods']['ITEM_COUPON_MAX_DISCOUNT'	] = $goods_item_coupon['MAX_DISCOUNT'];
                $data['goods']['ITEM_COUPON_AMT'			] = $item_coupon_amt;
            }
            //var_dump($seller_coupon_percent);
            //var_dump($item_coupon_percent);
            //var_dump($seller_coupon_amt);
            //var_dump($item_coupon_amt);
            if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
                $data['goods']['COUPON_AMT'		] = $seller_coupon_amt + $item_coupon_amt;
                $data['goods']['COUPON_PRICE'	] = $goods['SELLING_PRICE'] - ($seller_coupon_amt + $item_coupon_amt);
                $data['goods']['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
            } else {
                $data['goods']['COUPON_AMT'			] = 0;
                $data['goods']['COUPON_PRICE'		] = $goods['SELLING_PRICE'];
                $data['goods']['COUPON_SALE_PERCENT'] = 0;
            }

            //====================================== 순차적 할인 계산법
            //		if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            //			if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
            //				if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000){
            //					$coupon_info = "쿠폰 ".($goods_seller_coupon['COUPON_FLAT_RATE']/10)."% (최대 ".$goods_seller_coupon['MAX_DISCOUNT']."원 할인)";
            //					$coupon_price = $goods['SELLING_PRICE'] - $goods_seller_coupon['MAX_DISCOUNT'];
            //				} else {
            //					$coupon_info = "쿠폰 ".($goods_seller_coupon['COUPON_FLAT_RATE']/10)."%";
            //					$coupon_price = $goods['SELLING_PRICE'] - floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
            //				}
            //			}
            //			else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
            //				$coupon_info = "쿠폰 ".number_format($goods_seller_coupon['COUPON_FLAT_AMT'])."원";
            //				$coupon_price = $goods['SELLING_PRICE'] - $goods_seller_coupon['COUPON_FLAT_AMT'];
            //			}
            //
            //			$data['goods']['SELLER_COUPON_CD'			] = $goods_seller_coupon['COUPON_CD'];
            //			$data['goods']['SELLER_COUPON_METHOD'		] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
            //			$data['goods']['SELLER_COUPON_FLAT_RATE'	] = $goods_seller_coupon['COUPON_FLAT_RATE'];
            //			$data['goods']['SELLER_COUPON_FLAT_AMT'		] = $goods_seller_coupon['COUPON_FLAT_AMT'];
            //			$data['goods']['SELLER_COUPON_MAX_DISCOUNT'	] = $goods_seller_coupon['MAX_DISCOUNT'];
            //		}
            //
            //		if($goods_item_coupon){	//상품에 아이템쿠폰이 붙어있을경우
            //			if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
            //				if($coupon_info == ""){
            //					if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
            //						$coupon_info = "쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."% [최대 ".$goods_item_coupon['MAX_DISCOUNT']."원 할인]";
            //					} else {
            //						$coupon_info = "쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."%";
            //					}
            //				} else {
            //					if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
            //						$coupon_info .= " + 쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."% [최대 ".$goods_item_coupon['MAX_DISCOUNT']."원 할인]";
            //					} else {
            //						$coupon_info .= " + 쿠폰 ".($goods_item_coupon['COUPON_FLAT_RATE']/10)."%";
            //					}
            //				}
            //
            //				if($coupon_price == 0){
            //					if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
            //						$coupon_price = $goods['SELLING_PRICE'] - $goods_item_coupon['MAX_DISCOUNT'];
            //					} else {
            //						$coupon_price = $goods['SELLING_PRICE'] - floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
            //					}
            //				} else {
            //					if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000){
            //						$coupon_price = $goods['SELLING_PRICE'] - $goods_item_coupon['MAX_DISCOUNT'];
            //					} else {
            //						$coupon_price = $coupon_price - floor($coupon_price * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
            //					}
            //				}
            //			}
            //			else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
            //				if($coupon_info == D""){
            //					$coupon_info = "쿠폰 ".number_format($goods_item_coupon['COUPON_FLAT_AMT'])."원";
            //				} else {
            //					$coupon_info .= " + 쿠폰 ".number_format($goods_item_coupon['COUPON_FLAT_AMT'])."원";
            //				}
            //
            //				if($coupon_price == 0){
            //					$coupon_price = $goods['SELLING_PRICE'] - $goods_item_coupon['COUPON_FLAT_AMT'];
            //				} else {
            //					$coupon_price = $coupon_price - $goods_item_coupon['COUPON_FLAT_AMT'];
            //				}
            //			}
            //
            //			$data['goods']['ITEM_COUPON_CD'				] = $goods_item_coupon['COUPON_CD'];
            //			$data['goods']['ITEM_COUPON_METHOD'			] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
            //			$data['goods']['ITEM_COUPON_FLAT_RATE'		] = $goods_item_coupon['COUPON_FLAT_RATE'];
            //			$data['goods']['ITEM_COUPON_FLAT_AMT'		] = $goods_item_coupon['COUPON_FLAT_AMT'];
            //			$data['goods']['ITEM_COUPON_MAX_DISCOUNT'	] = $goods_item_coupon['MAX_DISCOUNT'];
            //		}
            //
            //		$data['goods']['COUPON_INFO'	] = $coupon_info;
            //		$data['goods']['COUPON_PRICE'	] = $coupon_price;		//할인 적용가


            //			$data['goods']['COUPON_PERCENT'	] = $goods_coupon['COUPON_PERCENT'];
            //			$data['goods']['COUPON_PRICE'	] = $goods_coupon['COUPON_PRICE'];
            //			$data['goods']['COUPON_CD'		] = $goods_coupon['COUPON_CD'];


            /** 사용 가능한 쿠폰 리스트 가져오기 */
            $auto_coupon = $this->cart_m->get_coupon_info($param, 'AUTO');
            $cust_coupon = $this->cart_m->get_coupon_info($param, 'ADD');
            $data['AUTO_COUPON_LIST'] = $auto_coupon;
            $data['CUST_COUPON_LIST'] = $cust_coupon;

            /**
             * 상품평 템플릿 구성
             */
            $temp = array();
            $temp['goods_code'	] = $goods_code;
            $paging_limit	= 3;
            $goods_comment_num = $this->goods_m->get_goods_comment_cnt($goods_code);		//상품평 전체 갯수 불러오기
            $total_goods_comment_val = $this->goods_m->get_goods_comment($goods_code, 0, 0);		//상품평 전체 평점 불러오기
            $goods_comment		= $this->goods_m->get_goods_comment($goods_code, 1, $paging_limit);	//상품평 불러오기
            //상품평 첨부파일 가져오기
            for($i=0;$i<count($goods_comment);$i++){
                $iparam['comment_no'] = $goods_comment[$i]['CUST_GOODS_COMMENT'];
                $goods_comment[$i]['FILE_PATH'] = $this->mywiz_m->get_goods_comment_file($iparam);
            }

            $temp['total_comment_val'	] = $total_goods_comment_val;
            $temp['goods_comment'		] = $goods_comment;

            //페이징 구성
            $temp['page'		] = 1;		//현재페이지
            $temp['total_page'	] = ceil($goods_comment_num['cnt'] / $paging_limit);		//전체 페이지 갯수
            $temp['limit_num'	] = $paging_limit;					//한 페이지에 보여주는 갯수
            $temp['total_cnt'	] = $goods_comment_num['cnt'];		//전체 갯수
            $data['cmt_total'  ] = $goods_comment_num['cnt'];    //상품평 전체 갯수

            if($goods['CATEGORY_MNG_CD2'] == 24010000) {
                $temp['template_gb'] = 'B';
            } else {
                $temp['template_gb'] = 'A';
            }
            $comment_template = $this->load->view('goods/template_comment', $temp, TRUE);
            $data['comment_template'] = $comment_template;


//            if($goods['CATEGORY_MNG_CD2'] == 24010000) {
//                //공방클래스 상품상세페이지 상품평
//                $comment_template = $this->load->view('goods/template_comment2', $temp, TRUE);
//                $data['comment_template'] = $comment_template;
//            } else {
//                //일반 상품상세페이지 상품평
//                $comment_template = $this->load->view('goods/template_comment', $temp, TRUE);
//                $data['comment_template'] = $comment_template;
//            }


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
            $data['qna_total'   ] = $goods_qna_num['cnt'];    //상품 문의 전체 갯수


            /**
             * 상품 구매가이드 템플릿 구성
             */
            $temp = array();
            $temp['goods_name'	] = $goods['GOODS_NM'];
            $temp['category_name'	] = $goods['CATEGORY_MNG_NM3'];
            $temp['brand_name'	] = $goods['BRAND_NM'];
//			  $temp['goods_guide'	] = $goods_guide;
//			  $temp['category_guide'] = $category_guide;
//			  $temp['brand_guide'	] = $brand_guide;
            $temp['goods_buy_guide'] = $goods_buy_guide;

            $data['goods_buy_guide_template'] = $this->load->view('goods/template_guide', $temp, TRUE);

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
            $data['op_gb'] = 'detail';

            /**
             * 퀵 레이아웃
             */
            $this->load->library('quick_lib');
            $data['quick'] =  $this->quick_lib->get_quick_layer();

            $this->load->view('include/header', $data);
            $this->load->view('include/layout');
            $this->load->view('goods/detail' ,$data);
            $this->load->view('include/footer');

            //2018.06.13 대진침대 홈화면 리다이렉트
            if($param['goods_code'] == 1100225 || $param['goods_code'] == 1100223){
                redirect('/');
            }
        }
    }


    /* 상품 설명 리스트 아이프레임 불러오기 */
    public function iframe_prd_get()
    {
        $goods_code = $_GET['goods_code'];
        $subvendor_code = $_GET['subvendor_code'];
        //Load MODEL
        $this->load->model('goods_m');

        //상품 설명 리스트 구하기
        $goods_desc = $this->goods_m->get_goods_desc($goods_code);

        //시크릿딜 이미지 구하기
        $this->load->model('main_m');
        $data['cBanner'] = $this->main_m->get_main_banner('WEB_GOODS_BANNER');

        $data['goods_desc'] = $goods_desc;

        if($data['goods_desc'][0]['TEMPLATE_GB_CD'] != null) {
            //상품 이미지 구하기
            $goods_img = $this->goods_m->get_goods_img($goods_code);

            for ($i = 0; $i < count($goods_img); $i++) {
                $data['img'][$i] = $goods_img[$i];
            }
        }
        $this->load->view('goods/iframe_prd_info', $data);
    }

    /**
     * 상품평 페이징
     */
    public function comment_paging_post()
    {
        $param			= $this->input->post();
        $goods_code	= $param['goods_code'];
        $page			= $param['page'];
        $limit			= $param['limit'];

        //Load MODEL
        $this->load->model('goods_m');
        $this->load->model('mywiz_m');

        $goods_comment = $this->goods_m->get_goods_comment($goods_code, $page, $limit); //상품평 가져오기

        //상품평 첨부파일 가져오기
        for($i=0;$i<count($goods_comment);$i++){
            $iparam['comment_no'] = $goods_comment[$i]['CUST_GOODS_COMMENT'];
            $goods_comment[$i]['FILE_PATH'] = $this->mywiz_m->get_goods_comment_file($iparam);
        }

        $this->response(array('status' => 'ok', 'comment' => $goods_comment), 200);
    }

    /**
     * 상품 문의 페이징
     */
    public function qna_paging_post()
    {
        $param			= $this->input->post();
        $goods_code	= $param['goods_code'];
        $page			= $param['page'];
        $limit			= $param['limit'];

        //Load MODEL
        $this->load->model('goods_m');

        $goods_qna = $this->goods_m->get_goods_qna($goods_code, $page, $limit);

//		 var_dump($goods_qna);

        $this->response(array('status' => 'ok', 'qna' => $goods_qna), 200);

    }

    /**
     * 이벤트 페이지
     */
    public function event_get()
    {
        $event_cd = $this->uri->segment(3, '');

        //기획전 클릭수 증가
        $click = $this->goods_m->event_click($event_cd);

        $event = $this->goods_m->get_plan_event($event_cd);

        $data['event'] = $event[0];
        $data['goods'] = $event;

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
        $this->load->view('include/layout');
        $this->load->view('goods/event' ,$data);
        $this->load->view('include/footer');
    }

    /**
     * 이벤트 페이지 쿠폰 다운로드
     */
    public function get_event_coupon_post()
    {
        $param = $this->input->post();

        $coupon_info		= $this->goods_m->coupon_info($param['coupon_code']);					//쿠폰 정보
        $coupon_check		= $this->goods_m->event_coupon_check($param['coupon_code'], 'Y', '');	//쿠폰 발급받았는지 체크
        $use_coupon_check	= $this->goods_m->event_coupon_check($param['coupon_code'], 'N', '');	//쿠폰을 발급받아서 사용한게 있는지 체크
        $today_get_coupon	= $this->goods_m->event_coupon_check($param['coupon_code'], 'N', date("Y-m-d"));	//쿠폰을 발급받아서 사용한게 있는지 체크

        if($coupon_check){
            $this->response(array('status' => 'error', 'message' => '이미 사용하지 않은 해당 쿠폰이 존재합니다.'), 200);
        } else {
            if(count($use_coupon_check) >= $coupon_info['BUYER_MAX_DOWN_QTY']){
                $this->response(array('status' => 'error', 'message' => '최대 쿠폰 발급 횟수를 초과하였습니다.'), 200);
            } else {
                if( count($today_get_coupon) >= $coupon_info['DAY_ISSUE_LIMIT_QTY']){
                    $this->response(array('status' => 'error', 'message' => '오늘 발급 받을 수 있는 최대 횟수를 초과하였습니다.'), 200);
                } else {
                    $bring_coupon = $this->goods_m->bring_event_coupon($param['coupon_code']);
                }
            }
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 페이스북 공유하기
     */
    public function share_facebook_get()
    {
        $data = $this->input->get();
//		 var_dump($data);

        $this->load->view('goods/share_facebook', $data);
    }

    /**
     * best item
     */
    public function best_item_get()
    {
        $category = $this->input->get('C', TRUE);

        $data = array();
        $data['goods'] = $this->goods_m->get_best_item($category);

        if(empty($category)) {
            $data['CATE_CD'] = '';
            $data['CATE_NM'] = '전체';
        } else {
            /* model_m */
            $this->load->model('category_m');

            $cateInfo = $this->category_m->get_category_detail($category, 'S');
            $data['CATE_CD'] = $cateInfo['CATE_CODE3'];
            $data['CATE_NM'] = $cateInfo['CATE_NAME3'];
        }

//	var_dump($data['goods']);

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
        $this->load->view('include/layout');
        $this->load->view('goods/best_item');
        $this->load->view('include/footer');
    }

    /**
     * 묶음배송상품리스트
     */
    public function bundle_delivery_get()
    {
        $data['goods_code'	] = $this->uri->segment(3);
//        $data['cate_cd'		] = "";
//        $data['brand_cd'	] = "";
//        $data['order_by'	] = "";
//        $data['keyword'		] = "";
//        $data['r_keyword'	] = "";
//        $data['gubun'		] = "N";

        //브랜드 상품조회
        self::_bundle_delivery_list($data);
    }

    /**
     * 묶음배송상품리스트 페이징
     */
    public function bundle_delivery_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	 ] = $page;
//        $get_vars['cate_cd'	 ] = "";
//        $get_vars['order_by' ] = "";
//        $get_vars['r_keyword'] = "";
//        $get_vars['brand_cd' ] = "";
//        $get_vars['gubun'	 ] = "Y";

        //카테고리 상품조회
        self::_bundle_delivery_list($get_vars);
    }

    /**
     * 묶음배송상품 리스트 보기
     */
    public function _bundle_delivery_list($param)
    {
        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($param['goods_code']);

        $data['goods'] = $goods;

        $param['deli_policy_no'] = $goods['DELIV_POLICY_NO'];

        //상품 할인금액 구하기
        $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
        $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

        //================================== 판매가 기준 할인 계산법
        $seller_coupon_percent	= 0;
        $seller_coupon_amt		= 0;
        $item_coupon_percent	= 0;
        $item_coupon_amt		= 0;

        if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }
        }

        if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
            if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }
        }

        if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
            $data['goods']['COUPON_AMT'		] = $seller_coupon_amt + $item_coupon_amt;
            $data['goods']['COUPON_PRICE'	] = $goods['SELLING_PRICE'] - $seller_coupon_amt - $item_coupon_amt;
            $data['goods']['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
        } else {
            $data['goods']['COUPON_AMT'			] = 0;
            $data['goods']['COUPON_PRICE'		] = $goods['SELLING_PRICE'];
            $data['goods']['COUPON_SALE_PERCENT'] = 0;
        }

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 40  : $param['limit_num_rows'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'	  ];
        $param['cate_gb'	    ] = empty($param['cate_gb'		    ]) ? 'S' : $param['cate_gb'	      ];
        $param['cate_cd'	    ] = empty($param['cate_cd'		    ]) ? ''	 : $param['cate_cd'	      ];
        $param['deliv_type'	    ] = empty($param['deliv_type'		]) ? ''	 : $param['deliv_type'	  ];
        $param['country'	    ] = empty($param['country'		    ]) ? ''	 : $param['country'	      ];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];

        //상품개수
        $totalCnt = $this->goods_m->get_goods_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //상품리스트
        $goodsList = $this->goods_m->get_goods_list($param);


        //전체상품정보 구하기
        $iparam = array();
        $iparam['deli_policy_no'] = $param['deli_policy_no'];
        $all_goodsList = $this->goods_m->get_goods_list($iparam);

        $arr_cate1 = array();   //카테고리1
        $arr_cate2 = array();   //카테고리2
        $arr_cate3 = array();   //카테고리3

        $cur_category = array(); //선택한 카테고리정보
        $arr_country = array();  //국가
        $arr_sellingPrice = array();   //가격

        foreach($all_goodsList as $all_goods) {
            //카테고리 리스트
            $arr_cate1[$all_goods['CATEGORY_CD1']]['CODE'] = $all_goods['CATEGORY_CD1'];
            $arr_cate1[$all_goods['CATEGORY_CD1']]['NAME'] = $all_goods['CATEGORY_NM1'];

            $arr_cate2[$all_goods['CATEGORY_CD2']]['CODE'] = $all_goods['CATEGORY_CD2'];
            $arr_cate2[$all_goods['CATEGORY_CD2']]['NAME'] = $all_goods['CATEGORY_NM2'];
            $arr_cate2[$all_goods['CATEGORY_CD2']]['PARENT_CODE'] = $all_goods['CATEGORY_CD1'];

            $arr_cate3[$all_goods['CATEGORY_CD3']]['CODE'] = $all_goods['CATEGORY_CD3'];
            $arr_cate3[$all_goods['CATEGORY_CD3']]['NAME'] = $all_goods['CATEGORY_NM3'];
            $arr_cate3[$all_goods['CATEGORY_CD3']]['PARENT_CODE'] = $all_goods['CATEGORY_CD2'];

            //선택한 카테고리 정보
            if($param['cate_cd']==$all_goods['CATEGORY_CD3']) {
                $cur_category['CATE_CD1'] = $all_goods['CATEGORY_CD1'];
                $cur_category['CATE_NM1'] = $all_goods['CATEGORY_NM1'];
                $cur_category['CATE_CD2'] = $all_goods['CATEGORY_CD2'];
                $cur_category['CATE_NM2'] = $all_goods['CATEGORY_NM2'];
                $cur_category['CATE_CD3'] = $all_goods['CATEGORY_CD3'];
                $cur_category['CATE_NM3'] = $all_goods['CATEGORY_NM3'];
            }

            //국가 리스트
            $country_cd = $all_goods['COUNTRY_CD'];
            $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

            //가격
            $price = $all_goods['SELLING_PRICE'];
            if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
        }

        $data['arr_cate1'       ] = $arr_cate1;
        $data['arr_cate2'       ] = $arr_cate2;
        $data['arr_cate3'       ] = $arr_cate3;
        $data['arr_country'     ] = $arr_country;
        $data['arr_sellingPrice'] = $arr_sellingPrice;
        $data['cur_category'    ] = $cur_category;


        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods/bundle_delivery_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
        $data['page'			] = $param['page'			];
        $data['price_limit'		] = $param['price_limit'	];
        $data['deli_policy_no'	] = $param['deli_policy_no'	];
        $data['order_by'		] = $param['order_by'		];
        $data['cate_gb'		    ] = $param['cate_gb'		];
        $data['cate_cd'		    ] = $param['cate_cd'		];
        $data['deliv_type'		] = $param['deliv_type'		];
        $data['country'		    ] = $param['country'		];
        $data['limit'			] = $param['limit_num_rows'	];
        $data['goods_code'		] = $param['goods_code'		];
        $data['goodsList'		] = $goodsList;
        $data['total_cnt'		] = $totalCnt;


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
        $this->load->view('include/layout');
        $this->load->view('goods/bundle_delivery' ,$data);
        $this->load->view('include/footer');


    }

    /**
     * 네이버페이 - 찜하기
     */
    function naver_pick_post(){
        $param = $this->input->post();

        $param['goods_img'] = $this->goods_m->get_goodsImageResizing($param['goods_cd'], '300');   //  리사이징 이미지 가져오기

        $queryString = 'SHOP_ID='.urlencode('np_chfrl677135');
        $queryString .= '&CERTI_KEY='.urlencode('50CE9CAD-5C85-483E-910E-2FDA41D0E26C');
        $queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';

        $queryString .= '&ITEM_ID='.urlencode($param['goods_cd']);
        $queryString .= '&ITEM_NAME='.urlencode($param['goods_name']);
        $queryString .= '&ITEM_UPRICE='.$param['goods_price'];
        $queryString .= '&ITEM_IMAGE='.urlencode($param['goods_img']);
        $queryString .= '&ITEM_URL='.urlencode(base_url().'goods/detail/'.$param['goods_cd']);

        $req_addr = 'ssl://pay.naver.com';
        $req_url = 'POST /customer/api/wishlist.nhn HTTP/1.1'; // utf-8
        $req_host = 'pay.naver.com';
        $req_port = 443;

        $nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);
        if ($nc_sock) {
            fwrite($nc_sock, $req_url."\r\n" );
            fwrite($nc_sock, "Host: ".$req_host.":".$req_port."\r\n" );
            fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf8\r\n"); // utf-8
            fwrite($nc_sock, "Content-length: ".strlen($queryString)."\r\n");
            fwrite($nc_sock, "Accept: */*\r\n");
            fwrite($nc_sock, "\r\n");
            fwrite($nc_sock, $queryString."\r\n");
            fwrite($nc_sock, "\r\n");

            // get header
            while(!feof($nc_sock)){
                $header=fgets($nc_sock,4096);
                if($header=="\r\n"){
                    break;
                } else {
                    $headers .= $header;
                }
            }
            // get body
            while(!feof($nc_sock)){
                $bodys.=fgets($nc_sock,4096);
            }

            fclose($nc_sock);

            $resultCode = substr($headers,9,3);

            if ($resultCode == 200) {
                // success
                $itemId = $bodys;
                $wishlistPopupUrl = "https://pay.naver.com/customer/wishlistPopup.nhn ";

                $this->response(array('status'=>'ok', 'itemId'=>$itemId, 'url'=>$wishlistPopupUrl),200);
            } else {
                // fail
                $this->response(array('status'=>'fail', 'message'=>'잠시 후 다시 시도해주세요.'),200);
            }
        } else {
            exit(-1);
            $this->response(array('status'=>'fail', 'message'=>'잠시 후 다시 시도해주세요.'),200);
        }

    }

    /**
     * 클러프트관
     */
    public function special_get()
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
        $this->load->view('include/layout');
        $this->load->view('goods/special_kluft' ,$data);
        $this->load->view('include/footer');
    }

}