<?php

class Category extends MY_Controller
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
        $this->load->model('category_m');
    }

    /**
     * 카테고리 메인
     */
    public function main_get()
    {
        $param   = $this->input->get();
        $cate_cd = $this->uri->segment(3);



        $data    = array();
        $arrCate = array();

        $category = $this->category_m->get_category_detail($cate_cd, 'S');

        //네비게이션
        $row = $this->category_m->get_list_by_category($cate_cd);

        for($i=0; $i<count($row); $i++){
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_DISP_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_DISP_NM'];

            $row2 = $this->category_m->get_list_by_category($row[$i]['CATEGORY_DISP_CD']);
            for($j=0; $j<count($row2); $j++){
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_DISP_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_DISP_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'			] = $arrCate;
        $data['category'	] = $category;

        //WEEKLY BEST
        //2017.08.28 이진호
        //WEEKLY BEST 목록 batch로 변경, 에타초이스 select table 변경
        $start_weekly = self::get_time();
        $data['weekly_best'	] = $this->category_m->get_weekly_best_goods_batch($cate_cd, $param['cate_oversea'] );
        $end_weekly = self::get_time();
        log_message('DEBUG', '=========== 주간 베스트 실행 시간 : '.($end_weekly-$start_weekly));

        if($cate_cd != 20000000) {
            //카테고리 TOP 배너
            $gubun = "CATE_TOP_".$cate_cd;
            $data['top'			] = $this->category_m->get_md_goods($gubun);
            $data['top_html'	] = str_replace("\n", '', $data['top'][0]['DISP_HTML']);
            $data['top_html'	] = str_replace('"', '\'', $data['top_html'	]);

            //에타 초이스
            $gubun = "CATE_CHOICE_".$cate_cd;
            //2017.08.28 이진호
            //에타 초이스 목록 batch로 변경, 에타초이스 select table 변경
            $data['md_goods'	] = $this->category_m->get_md_goods_choice_batch($gubun);

            //카테고리 BOTTOM 배너
            $gubun = "CATE_RCMD_".$cate_cd;
            $data['rcmd'		] = $this->category_m->get_md_goods($gubun);
        } else {
            $this->load->model('goods_m');

            //직구SHOP 메인에 보여지는 상품 설정 (BMH상품코드)
            $goods = "114425029,115226550,114426055,114424308,114425443,114932598,114396518,114649050,114425805,114425471,114426347,114425677,114841601,115052527,112446653,112197342,115182074,114287362,113781589,112248802,114850912,114859010,114745411,115030673,111547318,109826130,114203651,115013473,114591925,113723924,113372551,112688187,111319443,114669545,113870822,109826561";

            //상품리스트
            $param['limit_num_rows'  ] = 9999;
            $param['page'            ] = 1;
            $param['goods_cd'        ] = $goods;

            $param['cate_gb'		] = empty($param['cate_gb'			]) ? 'S' : $param['cate_gb'	      ];
            $param['cate_cd'		] = empty($param['cate_cd'			]) ? ''	 : $param['cate_cd'	      ];
            $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];
            $param['order_by'	    ] = empty($param['order_by'			]) ? 'B' : $param['order_by'	  ];
            $param['deliv_type'	    ] = empty($param['deliv_type'		]) ? ''  : $param['deliv_type'	  ];
            $param['country'		] = empty($param['country'		    ]) ? ''  : $param['country'	      ];

            $start_weekly = self::get_time();
            $data['goods_list'] = $this->goods_m->get_goods_list($param);     //상품리스트
            $data['weekly_best'	] = $this->category_m->get_weekly_best_goods_batch($cate_cd, $param['cate_oversea'] );
            $end_weekly = self::get_time();
            log_message('DEBUG', '=========== 상품리스트 실행 시간 : '.($end_weekly-$start_weekly));

            $arr_cate1 = array();   //카테고리1
            $arr_cate2 = array();   //카테고리2
            $arr_cate3 = array();   //카테고리3

            $cur_category = array(); //선택한 카테고리정보
            $arr_country = array();  //국가
            $arr_sellingPrice = array();   //가격

            $temp['limit_num_rows'  ] = 9999;
            $temp['page'            ] = 1;
            $temp['goods_cd'        ] = $goods;
            $temp['cate_oversea'    ] = $param['cate_oversea'];
            $start_weekly = self::get_time();
            $all_goodsList = $this->goods_m->get_goods_list($temp);     //상품리스트 전체
            $end_weekly = self::get_time();
            log_message('DEBUG', '=========== 상품리스트 전체 실행 시간 : '.($end_weekly-$start_weekly));

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

            $data['cate_gb'		] = $param['cate_gb'	      ];
            $data['cate_cd'		] = $param['cate_cd'	      ];
            $data['price_limit'	] = $param['price_limit'	  ];
            $data['order_by'	] = $param['order_by'	      ];
            $data['deliv_type'	] = $param['deliv_type'	      ];
            $data['country'		] = $param['country'	      ];

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
        $this->load->view('goods/category_main');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    /**
     * 카테고리 메인 - 직구SHOP
     */
    public function _main_global($param)
    {
        $category = $this->category_m->get_category_detail($param['cate_cd'], 'S');

        //네비게이션
        $row = $this->category_m->get_list_by_category($param['cate_cd']);
        for($i=0; $i<count($row); $i++){
            $arr_cate_cd1[$i] = $row[$i]['CATEGORY_DISP_CD'];
            $arr_cate_nm1[$i] = $row[$i]['CATEGORY_DISP_NM'];
            $row2 = $this->category_m->get_list_by_category($row[$i]['CATEGORY_DISP_CD']);
            for($j=0; $j<count($row2); $j++){
                $arr_cate_cd2[$i][$j] = $row2[$j]['CATEGORY_DISP_CD'];
                $arr_cate_nm2[$i][$j] = $row2[$j]['CATEGORY_DISP_NM'];
            }
        }

        $arrCate['CATEGORY_CD1'] = $arr_cate_cd1;
        $arrCate['CATEGORY_NM1'] = $arr_cate_nm1;
        $arrCate['CATEGORY_CD2'] = $arr_cate_cd2;
        $arrCate['CATEGORY_NM2'] = $arr_cate_nm2;

        $data['nav'			] = $arrCate;
        $data['category'	] = $category;


        //카테고리리스트
        $category_list = $this->category_m->get_list_by_category($param['cate_cd']);
        //브랜드개수
        $brand_cnt = $this->category_m->get_brand_global_goods_count($param);
        //상품리스트
        $goodsList = $this->category_m->get_global_goods_list($param);

        $data['category_list'] = $category_list;
        $data['brand_cnt'    ] = $brand_cnt;
        $data['goods'        ] = $goodsList;
        $data['brand_cd'     ] = $param['brand_cd'      ];
        $data['arr_cate'     ] = $param['arr_cate'      ];
        $data['price_limit'  ] = $param['price_limit'   ];
        $data['limit'        ] = $param['limit_num_rows'];
        $data['order_by'     ] = $param['order_by'      ];

        $this->load->view('include/header', $data);
        $this->load->view('goods/category_main_global');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }



    function get_time() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }



}
	