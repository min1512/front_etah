<?php

class Cart_org extends MY_Controller
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

		/* model_m */
		$this->load->model('cart_m_org');


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
	}

	public function test_get()
	{
		$data = array();


		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		$this->load->view('include/header', $data);
		$this->load->view('cart/test', $data);
		$this->load->view('include/layout');
		$this->load->view('include/footer');
	}

	/**
	 * 장바구니 페이지 Load
	 */
	public function index_get()
	{
//		$cart = $this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_'));
		$row = $this->cart_m_org->get_cart_goods($this->session->userdata('EMS_U_NO_'));

		//모델 LOAD
		$this->load->model('goods_m');
		$this->load->model('mywiz_m');

		$data['mycoupon_cnt'] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기

//		for($i=0; $i<count($cart); $i++){
//			$param = array();
//			$param['goods_code'] = $cart[$i]['GOODS_CD'];
//			$param['brand_code'] = $cart[$i]['BRAND_CD'];
//			$goods_coupon = $this->goods_m->get_goods_coupon_info($param);		//상품별 자동 할인쿠폰 가져오기
//
//			$cart[$i]['COUPON_PERCENT'	] = $goods_coupon['COUPON_PERCENT'];
//			$cart[$i]['COUPON_AMT'		] = $goods_coupon['COUPON_AMT'];
//			$cart[$i]['COUPON_PRICE'	] = $goods_coupon['COUPON_PRICE'];
//			$cart[$i]['COUPON_CD'		] = $goods_coupon['COUPON_CD'];
//
//			/** 사용 가능한 쿠폰 리스트 가져오기 */
//			$auto_coupon = $this->cart_m->get_coupon_info($param, 'AUTO_DC');
//			$cust_coupon = $this->cart_m->get_coupon_info($param, 'CUST_DOWNLOAD');
//			$cart[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
//			$cart[$i]['CUST_COUPON_LIST'] = $cust_coupon;
//
//			$goods_add_deli = $this->goods_m->get_goods_add_deli($param);		//상품별 도서산간지역 추가배송비 가져오기
//
//			$cart[$i]['ADD_DELIVERY'] = $goods_add_deli;
//		}
		$cart	= array();

		for($i=0; $i<count($row); $i++){
			$param = array();
			$param['goods_code'] = $row[$i]['GOODS_CD'];
			$param['brand_code'] = $row[$i]['BRAND_CD'];
			$goods_coupon = $this->goods_m->get_goods_coupon_info($param);		//상품별 자동 할인쿠폰 가져오기

			//상품 옵션 구하기
			$goods_option = $this->goods_m->get_goods_option($param['goods_code']);
			$row[$i]['GOODS_OPTION'		] = $goods_option;

			$row[$i]['COUPON_PERCENT'	] = $goods_coupon['COUPON_PERCENT'];
			$row[$i]['COUPON_AMT'		] = $goods_coupon['COUPON_AMT'];
			$row[$i]['COUPON_PRICE'		] = $goods_coupon['COUPON_PRICE'];
			$row[$i]['COUPON_CD'		] = $goods_coupon['COUPON_CD'];

			/** 사용 가능한 쿠폰 리스트 가져오기 */
			$auto_coupon = $this->cart_m_org->get_coupon_info($param, 'AUTO_DC');
			$cust_coupon = $this->cart_m_org->get_coupon_info($param, 'CUST_DOWNLOAD');
			$row[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
			$row[$i]['CUST_COUPON_LIST'] = $cust_coupon;

			$goods_add_deli = $this->goods_m->get_goods_add_deli($param);		//상품별 도서산간지역 추가배송비 가져오기

			$row[$i]['ADD_DELIVERY'] = $goods_add_deli;

			$cart[$row[$i]['DELI_CODE']][] = $row[$i];
		}
		$data['cart'] = $cart;

//var_dump($data['cart']);

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
		$this->load->view('cart/cart_step1_org', $data);
		$this->load->view('include/footer');

	}

	/** 장바구니 -> 주문/결제 페이지로 이동시 변수 이동 **/
	public function OrderInfo_post()
	{
		$param = $this->input->post();

		self::Step2_OrderInfo_get($param);
	}

	/**
	 * 주문/결제 페이지 Load
	 */
	public function Step2_OrderInfo_get()
	{
		$param = $this->input->post();
//		error_reporting(E_ALL);
//ini_set('display_errors', 1);
		//모델 LOAD
		$this->load->model('mywiz_m');
		$this->load->model('goods_m');

		$data['mycoupon_cnt'		] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기

		if(!isset($param['chkGoods'])){	//바로구매 시
//			var_dump("************************바로구매***************************");
//			var_dump($param);
			$deli_code = $param['deli_code'];

			$cart[0]['GOODS_CD'					] = $param['goods_code'				];
			$cart[0]['GOODS_NM'					] = $param['goods_name'				];
			$cart[0]['GOODS_IMG'				] = $param['goods_img'				];
			$cart[0]['BRAND_CD'					] = $param['brand_code'				];
			$cart[0]['BRAND_NM'					] = $param['brand_name'				];
			$cart[0]['GOODS_OPTION_CD'			] = explode('||', $param['goods_option_code'])[0];
			$cart[0]['GOODS_OPTION_NM'			] = explode('||', $param['goods_option_code'])[1];
			$cart[0]['GOODS_CNT'				] = $param['goods_cnt'				];
			$cart[0]['GOODS_PRICE_CD'			] = $param['goods_price_code'		];
			$cart[0]['SELLING_PRICE'			] = $param['goods_selling_price'	];
			$cart[0]['STREET_PRICE'				] = $param['goods_street_price'		];
			$cart[0]['FACTORY_PRICE'			] = $param['goods_factory_price'	];
			$cart[0]['DISCOUNT_PRICE'			] = $param['goods_discount_price'	];
			$cart[0]['ADD_DISCOUNT_PRICE'		] = "0";		//추가 할인금액 0
			$cart[0]['COUPON_CODE'				] = $param['goods_coupon_code'		];
			$cart[0]['ADD_COUPON_CODE'			] = "";

			if(($param['goods_selling_price'] - $param['goods_discount_price']) * $param['goods_cnt'] < $param['deli_limit']){
				$cart[0]['DELIVERY_PRICE'		] = $param['deli_cost'	];
			} else {
				$cart[0]['DELIVERY_PRICE'		] = "0";
			}

			$cart[0]['DELIV_POLICY_NO'			] = $param['deli_policy_no'			];

			$goods_add_deli = $this->goods_m->get_goods_add_deli($param);		//상품별 도서산간지역 추가배송비 가져오기
			$cart[0]['ADD_DELIVERY'				] = $goods_add_deli;

			$data['cart'][$deli_code."||".$cart[0]['DELIVERY_PRICE']][] = $cart[0];		//배송코드(업체코드_배송정책코드)||배송비(묶음적용)

		} else {
//			var_dump("************************장바구니***************************");
//			var_dump($param);
			if($param['order_gb'] == 'A'){	//전체상품주문
				for($i=0; $i<count($param['cart_code']); $i++){
					$deli_code = $param['deli_code'][$i];

					$cart[$i]['GOODS_CD'					] = $param['goods_code'					][$i];
					$cart[$i]['GOODS_NM'					] = $param['goods_name'					][$i];
					$cart[$i]['BRAND_CD'					] = $param['brand_code'					][$i];
					$cart[$i]['BRAND_NM'					] = $param['brand_name'					][$i];
					$cart[$i]['GOODS_OPTION_CD'				] = $param['goods_option_code'			][$i];
					$cart[$i]['GOODS_OPTION_NM'				] = $param['goods_option_name'			][$i];
					$cart[$i]['GOODS_CNT'					] = $param['goods_cnt'					][$i];
					$cart[$i]['GOODS_IMG'					] = $param['goods_img'					][$i];
					$cart[$i]['GOODS_PRICE_CD'				] = $param['goods_price_code'			][$i];
					$cart[$i]['SELLING_PRICE'				] = $param['goods_selling_price'		][$i];
					$cart[$i]['STREET_PRICE'				] = $param['goods_street_price'			][$i];
					$cart[$i]['FACTORY_PRICE'				] = $param['goods_factory_price'		][$i];
					$cart[$i]['DISCOUNT_PRICE'				] = $param['goods_discount_price'		][$i];
					$cart[$i]['ADD_DISCOUNT_PRICE'			] = $param['goods_add_discount_price'	][$i];
					$cart[$i]['COUPON_CODE'					] = $param['goods_coupon_code'			][$i];
					$cart[$i]['ADD_COUPON_CODE'				] = $param['goods_add_coupon_code'		][$i];
					$cart[$i]['DELIVERY_PRICE'				] = $param['goods_delivery_price'		][$i];
					$cart[$i]['DELIV_POLICY_NO'				] = $param['deli_policy_no'				][$i];

					$param2['goods_code'] = $param['goods_code'][$i];
					$goods_add_deli = $this->goods_m->get_goods_add_deli($param2);		//상품별 도서산간지역 추가배송비 가져오기
					$cart[$i]['ADD_DELIVERY'				] = $goods_add_deli;

					$data['cart'][$deli_code][] = $cart[$i];
				}

			} else if($param['order_gb'] == 'C'){	//선택상품주문
				for($i=0; $i<count($param['chkGoods']); $i++){
					$chk = explode("||",$param['chkGoods'][$i]);
//					var_dump($chk);
//					for($j=0; $j<count($chk); $j++){
//						var_dump("???");
						$cnt = $chk[0];
						$deli_code = $param['chk_deli_code'][$cnt];

						$cart[$cnt]['GOODS_CD'					] = $param['goods_code'					][$cnt];
						$cart[$cnt]['GOODS_NM'					] = $param['goods_name'					][$cnt];
						$cart[$cnt]['BRAND_CD'					] = $param['brand_code'					][$cnt];
						$cart[$cnt]['BRAND_NM'					] = $param['brand_name'					][$cnt];
						$cart[$cnt]['GOODS_OPTION_CD'			] = $param['goods_option_code'			][$cnt];
						$cart[$cnt]['GOODS_OPTION_NM'			] = $param['goods_option_name'			][$cnt];
						$cart[$cnt]['GOODS_CNT'					] = $param['goods_cnt'					][$cnt];
						$cart[$cnt]['GOODS_IMG'					] = $param['goods_img'					][$cnt];
						$cart[$cnt]['GOODS_PRICE_CD'			] = $param['goods_price_code'			][$cnt];
						$cart[$cnt]['SELLING_PRICE'				] = $param['goods_selling_price'		][$cnt];
						$cart[$cnt]['STREET_PRICE'				] = $param['goods_street_price'			][$cnt];
						$cart[$cnt]['FACTORY_PRICE'				] = $param['goods_factory_price'		][$cnt];
						$cart[$cnt]['DISCOUNT_PRICE'			] = $param['goods_discount_price'		][$cnt];
						$cart[$cnt]['ADD_DISCOUNT_PRICE'		] = $param['goods_add_discount_price'	][$cnt];
						$cart[$cnt]['COUPON_CODE'				] = $param['goods_coupon_code'			][$cnt];
						$cart[$cnt]['ADD_COUPON_CODE'			] = $param['goods_add_coupon_code'		][$cnt];
						$cart[$cnt]['DELIVERY_PRICE'			] = $param['goods_delivery_price'		][$cnt];
						$cart[$cnt]['DELIV_POLICY_NO'			] = $param['deli_policy_no'				][$cnt];

						$param2['goods_code'] = $param['goods_code'][$cnt];
						$goods_add_deli = $this->goods_m->get_goods_add_deli($param2);		//상품별 도서산간지역 추가배송비 가져오기
						$cart[$cnt]['ADD_DELIVERY'				] = $goods_add_deli;
						$data['cart'][$deli_code][] = $cart[$cnt];
//					}
				}
//				var_dump($data['cart']);

			} else if($param['order_gb'] == 'D'){	//바로상품주문
				$i = explode("||",$param['direct_code'])[0];
				$deli_code = explode("||",$param['deli_code'][$i])[0];

				$cart[$i]['GOODS_CD'				] = $param['goods_code'					][$i];
				$cart[$i]['GOODS_NM'				] = $param['goods_name'					][$i];
				$cart[$i]['BRAND_CD'				] = $param['brand_code'					][$i];
				$cart[$i]['BRAND_NM'				] = $param['brand_name'					][$i];
				$cart[$i]['GOODS_OPTION_CD'			] = $param['goods_option_code'			][$i];
				$cart[$i]['GOODS_OPTION_NM'			] = $param['goods_option_name'			][$i];
				$cart[$i]['GOODS_CNT'				] = $param['goods_cnt'					][$i];
				$cart[$i]['GOODS_IMG'				] = $param['goods_img'					][$i];
				$cart[$i]['GOODS_PRICE_CD'			] = $param['goods_price_code'			][$i];
				$cart[$i]['SELLING_PRICE'			] = $param['goods_selling_price'		][$i];
				$cart[$i]['STREET_PRICE'			] = $param['goods_street_price'			][$i];
				$cart[$i]['FACTORY_PRICE'			] = $param['goods_factory_price'		][$i];
				$cart[$i]['DISCOUNT_PRICE'			] = $param['goods_discount_price'		][$i];
				$cart[$i]['ADD_DISCOUNT_PRICE'		] = $param['goods_add_discount_price'	][$i];
				$cart[$i]['COUPON_CODE'				] = $param['goods_coupon_code'			][$i];
				$cart[$i]['ADD_COUPON_CODE'			] = $param['goods_add_coupon_code'		][$i];
				$cart[$i]['DELIVERY_PRICE'			] = $param['goods_delivery_price'		][$i];
				$cart[$i]['DELIV_POLICY_NO'			] = $param['deli_policy_no'				][$i];

				$param2['goods_code'] = $param['goods_code'][$i];
				$goods_add_deli = $this->goods_m->get_goods_add_deli($param2);		//상품별 도서산간지역 추가배송비 가져오기
				$cart[$i]['ADD_DELIVERY'			] = $goods_add_deli;

				$data['cart'][$deli_code."||".$param['goods_delivery_price'		][$i]][] = $cart[$i];
			}
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
		$this->load->view('include/layout');
		$this->load->view('cart/cart_step2', $data);
		$this->load->view('include/footer');
	}

	/**
	 * 나의쿠폰리스트
	 *
	 * @return mixed
	 */
    public function coupon_2_get()
    {
//		error_reporting(E_ALL);
//ini_set('display_errors', 1);
		$mem_id			= $this->uri->segment('3');
//		var_dump($mem_id);
		$g_amt			= $this->uri->segment('4');
		$coupon_key		= $this->uri->segment('5');

		$data = array();

        $data['mem_id'		] = $mem_id;
        $data['g_amt'		] = $g_amt;
        $data['coupon_key'	] = $coupon_key;

		//현재 통화정보
//		$rst_currency = $this->cart_m->get_currency();
//		$data['currency'] = $rst_currency;

        //load model
//        $this->load->model('cart_m');

//		if( ! empty($mem_id) && $mem_id != 'GUEST') $data['my_coupon'] = $this->cart_m->get_coupon_info($mem_id);
//		else $data['my_coupon'] = array();


		$this->load->view('cart/coupon_list', $data);
    }

	/**
	 * 장바구니에 상품 담기
	 */
	public function insert_cart_post()
	{
		$param = $this->input->post();

		$ChkCart = $this->cart_m->chk_cart($param);		//동일 상품&옵션이 담겨있는지 확인하기

		if($ChkCart){
			$param['cart_no'] = $ChkCart['CART_NO'];
			$param['cnt'	] = $ChkCart['CART_QTY'] + $param['goods_cnt'];
			$param['gb'		] = 'CNT';

			$UpdCart = $this->cart_m->upd_cart($param);
		} else {
			$AddCart = $this->cart_m->add_cart($param);		//장바구니에 담기
		}

		$this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 장바구니에서 상품 제거
	 */
	 public function del_cart_post()
	{
		 $param = $this->input->post();
		 $cart_no = $param['chkGoods'];

		 if(count($cart_no) != 0){
			 for($i=0; $i<count($cart_no); $i++){
				 $DelCart = $this->cart_m->del_cart($cart_no[$i]);	//장바구니에서 상품 제거
			 }
		 }

		 $this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 장바구니 옵션/수량 변경
	 */
	 public function chg_cart_post()
	{
		 $param = $this->input->post();

		 $UpdCart = $this->cart_m->upd_cart($param);

		 $this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 관심상품 등록
	 */
	 public function reg_interest_post()
	{
		 $param = $this->input->post();

		 //마이페이지 모델 LOAD
		 $this->load->model('mywiz_m');

		 $RegInter = $this->mywiz_m->register_add_wish_list($param);

		 $this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 우편번호 검색 모듈
	 */
	 public function get_postnum_post()
	{
		 $param = $this->input->post();

		 $old_addr = $this->cart_m->get_postnum_old($param);		//지번 주소
		 $new_addr = $this->cart_m->get_postnum_new($param);		//도로명 주소
//		 var_dump($old_addr);

		 $Old_addr_html = "";
		 $New_addr_html = "";
		 $idx = 0;

		 foreach($old_addr as $row){
			 $old_sido				= $row['SIDO'];
			 $old_sigungu			= $row['SIGUNGU'];
			 $old_eupmyeondong		= $row['EUPMYEONDONG'];
			 $old_ri				= $row['RI'];
			 $old_doseo				= $row['DOSEO'];
			 $old_bungi				= $row['BUNGI'];
			 $old_building_nm		= $row['BUILDING_NM'];
			 $old_zip_code			= substr($row['ZIPCODE'],0,3)."-".substr($row['ZIPCODE'],3,3);

			 $Old_addr_html .= "<li class='postal_code_item'>";
			 $Old_addr_html .= "<input type='hidden' name='addr_v1[]' value='".$old_sido." ".$old_sigungu." ".$old_eupmyeondong." ".$old_ri." ".$old_doseo." ".$old_bungi." ".$old_building_nm."'>";
			 $Old_addr_html .= "<input type='hidden' name='addr_post1[]' value='".$old_zip_code."'>";
			 $Old_addr_html .= "<a href='javascript:jsPastepost(\"1\",".$idx.");'>";
			 $Old_addr_html .= "<span class='address'>".$old_sido." ".$old_sigungu." ".$old_eupmyeondong." ".$old_ri." ".$old_doseo." ".$old_bungi." ".$old_building_nm."</span>";
			 $Old_addr_html .= "<span class='code'>".$old_zip_code."</span>";
			 $Old_addr_html .= "</a>";
			 $Old_addr_html .= "</li>";

			 $idx ++;
		 }

		 $idx = 0;
		 foreach($new_addr as $row){
			 $new_sido				= $row['SIDO'];
			 $new_sigungu			= $row['SIGUNGU'];
			 $new_road_nm			= $row['ROAD_NM'];
			 $new_road_no			= $row['ROAD_NO'];
			 $new_building_nm		= $row['BUILDING_NM'];
			 $new_lawdong_building_nm	= $row['LAWDONG_BUILDING_NM'];
			 $new_lawdong_nm		= $row['LAWDONG_NM'];
			 $new_admindong_nm		= $row['ADMINDONG_NM'];
			 $new_gibun_bungi		= $row['GIBUN_BUNGI'];
			 $new_zip_code			= $row['ZIPCODE'];

			 $New_addr_html .= "<li class='postal_code_item'>";
			 $New_addr_html .= "<input type='hidden' name='addr_v2[]' value='".$new_sido." ".$new_sigungu." ".$new_road_nm." ".$new_road_no." ".$new_building_nm." ".$new_lawdong_building_nm."'>";
			 $New_addr_html .= "<input type='hidden' name='addr_post2[]' value='".$new_zip_code."'>";
			 $New_addr_html .= "<a href='javascript:jsPastepost(\"2\",".$idx.");'>";
			 $New_addr_html .= "<span class='address'>".$new_sido." ".$new_sigungu." ".$new_road_nm." ".$new_road_no." ".$new_building_nm." ".$new_lawdong_building_nm."</span>";
			 $New_addr_html .= "<span class='code'>".$new_zip_code."</span>";
			 $New_addr_html .= "</a>";
			 $New_addr_html .= "</li>";

			 $idx ++;
		 }

		  $this->response(array('status' => 'ok', 'old_addr' => $Old_addr_html, 'old_addr_cnt' => count($old_addr), 'new_addr' => $New_addr_html, 'new_addr_cnt' => count($new_addr)), 200);

	}

	/**
	 * 추가 배송비 모듈
	 */
	 public function get_add_delivery_post()
	{
		 $param = $this->input->post();

		 $add_deli = $this->cart_m->get_add_delivery_cost($param);

		 if(!$add_deli){
			 $delivery_cost = 0;
		 } else {
			 $delivery_cost = $add_deli['ADD_DELIV_COST'];
		 }

//		 var_dump($delivery_cost);
		 $this->response(array('status' => 'ok', 'add_delivery_price' => $delivery_cost), 200);

	}



}