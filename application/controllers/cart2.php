<?php

class Cart2 extends MY_Controller
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
		$this->load->model('cart_m');


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
//		var_dump($this->session->userdata('EMS_U_NO_'));
//		$cart = $this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_'));
		$row = $this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_'));

		//모델 LOAD
		$this->load->model('goods_m');
		$this->load->model('mywiz_m');

		$data['mycoupon_cnt'	] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기
		$data['mileage'			] = $this->mywiz_m->get_mileage_by_cust();			//보유 마일리지 가져오기
		$data['recommend_goods'	] = $this->cart_m->get_cart_best_goods();		//장바구니 추천상품

		$cart	= array();

		for($i=0; $i<count($row); $i++){
			$param = array();
			$param['goods_code'			] = $row[$i]['GOODS_CD'];
			$param['brand_code'			] = $row[$i]['BRAND_CD'];
			$param['category_mng_code'	] = $row[$i]['CATEGORY_MNG_CD'];

			//상품 쿠폰 구하기(셀러 & 상품)
			$goods_seller_coupon = $this->goods_m->get_goods_coupon_info($param, 'SELLER');	//상품별 셀러할인쿠폰 가져오기
			$goods_item_coupon   = $this->goods_m->get_goods_coupon_info($param, 'GOODS');	//상품별 상품할인쿠폰 가져오기
			$coupon_price = 0;

			if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
				if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
					$coupon_price = $row[$i]['SELLING_PRICE'] - floor($row[$i]['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);

					if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $coupon_price){	//최대금액을 넘을경우 최대금액으로 적용
						$coupon_price = $row[$i]['SELLING_PRICE'] - $goods_seller_coupon['MAX_DISCOUNT'];
					}
				}
				else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
					$coupon_price = $row[$i]['SELLING_PRICE'] - $goods_seller_coupon['COUPON_FLAT_AMT'];
				}

				$row[$i]['SELLER_COUPON_CD'	] = $goods_seller_coupon['COUPON_CD'];
				$row[$i]['SELLER_COUPON_AMT'] = $row[$i]['SELLING_PRICE'] - $coupon_price;
			}

			if($goods_item_coupon){	//상품에 아이템쿠폰이 붙어있을경우
				if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
					if($coupon_price == 0){
						$coupon_price = $row[$i]['SELLING_PRICE'] - floor($row[$i]['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);

						if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $coupon_price){	//최대금액을 넘을경우 최대금액으로 적용
							$coupon_price = $row[$i]['SELLING_PRICE'] - $goods_item_coupon['MAX_DISCOUNT'];
						}
					} else {
						$coupon_price = $coupon_price - floor($coupon_price * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);

						if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $coupon_price){	//최대금액을 넘을경우 최대금액으로 적용
							$coupon_price = $coupon_price - $goods_item_coupon['MAX_DISCOUNT'];
						}
					}
				}
				else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
					if($coupon_price == 0){
						$coupon_price = $row[$i]['SELLING_PRICE'] - $goods_item_coupon['COUPON_FLAT_AMT'];
					} else {
						$coupon_price = $coupon_price - $goods_item_coupon['COUPON_FLAT_AMT'];
					}
				}

				$row[$i]['ITEM_COUPON_CD'	] = $goods_item_coupon['COUPON_CD'];

				if($goods_seller_coupon){
					$row[$i]['ITEM_COUPON_AMT'	] = $row[$i]['SELLING_PRICE'] - $coupon_price - $row[$i]['SELLER_COUPON_AMT'];
				} else {
					$row[$i]['ITEM_COUPON_AMT'	] = $row[$i]['SELLING_PRICE'] - $coupon_price;
				}
			}

			if($coupon_price > 0){	//할인금액이 있을경우
				$row[$i]['COUPON_AMT'	] = $row[$i]['SELLING_PRICE'] - $coupon_price;	//	할인금액
				$row[$i]['COUPON_PRICE'	] = $coupon_price;	//할인적용가
			} else {
				$row[$i]['COUPON_AMT'	] = 0;
				$row[$i]['COUPON_PRICE'	] = $row[$i]['SELLING_PRICE'];
			}
//var_dump($row[$i]);
			//상품 옵션 구하기
			$goods_option = $this->goods_m->get_goods_option($param['goods_code']);
			$row[$i]['GOODS_OPTION'		] = $goods_option;

//			$row[$i]['COUPON_PERCENT'	] = $goods_coupon['COUPON_PERCENT'];
//			$row[$i]['COUPON_AMT'		] = $goods_coupon['COUPON_AMT'];
//			$row[$i]['COUPON_PRICE'		] = $goods_coupon['COUPON_PRICE'];
			$row[$i]['SELLER_COUPON_CD'	] = isset($goods_seller_coupon['COUPON_CD']) ? $goods_seller_coupon['COUPON_CD'] : "";
			$row[$i]['ITEM_COUPON_CD'	] = isset($goods_item_coupon['COUPON_CD']) ? $goods_item_coupon['COUPON_CD'] : "";

			/** 사용 가능한 쿠폰 리스트 가져오기 */
			$auto_coupon = $this->cart_m->get_coupon_info($param, 'AUTO');

			for($j=0; $j<count($auto_coupon); $j++){
				if($auto_coupon[$j]['COUPON_KIND_CD'] == 'GOODS'){	//만약 GOODS쿠폰이 있다면
					$param['DUPLICATE'] = "";		// 배열을 생성함으로써 DUPLICATE가 Y인것만 보여주기
					break;
				}
			}

			$cust_coupon = $this->cart_m->get_coupon_info($param, 'ADD');
			$row[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
			$row[$i]['CUST_COUPON_LIST'] = $cust_coupon;

			$goods_add_deli = $this->goods_m->get_goods_add_deli($param);		//상품별 도서산간지역 추가배송비 가져오기

			$row[$i]['ADD_DELIVERY'] = $goods_add_deli;

			$cart[$row[$i]['DELI_CODE']][] = $row[$i];
		}
		$data['cart'		] = $cart;

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
		$this->load->view('cart/cart_step1', $data);
		$this->load->view('include/footer');

	}

	/** 장바구니 -> 주문/결제 페이지로 이동시 변수 이동 **/
	public function OrderInfo_post()
	{
		$param = $this->input->post();

		self::Step2_OrderInfo_get($param);
	}

	public function OrderInfo_get()
	{
		$this->load->view('template/error_404');
	}

	/** 상품상세 -> 바로구매 (비회원) 이동시 변수 이동 **/
	public function GuestOrder_post()
	{
		$param = $this->input->post();

		self::GuestOrder_get($param);
	}

	public function GuestOrder_get()
	{
		$param = $this->input->post();

		if(!$param){
			$this->load->view('template/error_404');
		} else {

		$data['param']	= $param;

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
		$this->load->view('cart/cart_nonmember2', $data);
		$this->load->view('include/footer');
		}
	}

	/**
	 * 주문/결제 페이지 Load
	 */
	public function Step2_OrderInfo_get()
	{
		//비회원 로그인시 세션 날리기
		if($this->session->userdata('EMS_U_ID_') == 'GUEST'){
			$this->session->sess_destroy();
		}

		$param = $this->input->post();
		error_reporting(E_ALL);
ini_set('display_errors', 1);
		//모델 LOAD
		$this->load->model('mywiz_m');
		$this->load->model('goods_m');
		$this->load->model('order_m');

		//최근 배송지 초기값 세팅
		$data['RECEIVER_NM'			] = "";
		$data['RECEIVER_ZIPCODE'	] = "";
		$data['RECEIVER_ADDR1'		] = "";
		$data['RECEIVER_ADDR2'		] = "";
		$data['RECEIVER_PHONE_NO'	] = "";
		$data['RECEIVER_MOB_NO'		] = "";

		if($this->session->userdata('EMS_U_NO_')){
			$last_deliv = $this->order_m->get_last_order_deliv($this->session->userdata('EMS_U_NO_'));

			if($last_deliv){
				$data['last_deliv'			] = $last_deliv;
				$data['RECEIVER_NM'			] = $last_deliv['RECEIVER_NM'];
				$data['RECEIVER_ZIPCODE'	] = $last_deliv['RECEIVER_ZIPCODE'];
				$data['RECEIVER_ADDR1'		] = $last_deliv['RECEIVER_ADDR1'];
				$data['RECEIVER_ADDR2'		] = $last_deliv['RECEIVER_ADDR2'];
				$data['RECEIVER_PHONE_NO'	] = $last_deliv['RECEIVER_PHONE_NO'];
				$data['RECEIVER_MOB_NO'		] = $last_deliv['RECEIVER_MOB_NO'];
			}
		}

		$data['mycoupon_cnt'		] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기
		$data['mileage'				] = $this->mywiz_m->get_mileage_by_cust();			//보유 마일리지 가져오기
		$data['cust_delivery'		] = $this->mywiz_m->get_delivery_list($param);
		$data['mycoupon'			] = $this->cart_m->get_cust_coupon_info();			//보유 쿠폰

		if(!isset($param['chkGoods']) && !isset($param['order_gb'])){	//바로구매 시
//			var_dump("************************바로구매***************************");
//			var_dump($param);
			$deli_code = $param['deli_code'];
	for($i=0; $i<count($param['goods_option_code']); $i++){
			$cart[$i]['GOODS_CD'				] = $param['goods_code'				];
			$cart[$i]['GOODS_NM'				] = $param['goods_name'				];
			$cart[$i]['GOODS_IMG'				] = $param['goods_img'				];
			$cart[$i]['BRAND_CD'				] = $param['brand_code'				];
			$cart[$i]['BRAND_NM'				] = $param['brand_name'				];
			$cart[$i]['GOODS_OPTION_CD'			] = $param['goods_option_code'		][$i];
			$cart[$i]['GOODS_OPTION_NM'			] = $param['goods_option_name'		][$i];
			$cart[$i]['GOODS_OPTION_ADD_PRICE'	] = $param['goods_option_add_price'	][$i];
			$cart[$i]['GOODS_CNT'				] = $param['goods_cnt'				][$i];
			$cart[$i]['GOODS_PRICE_CD'			] = $param['goods_price_code'		];
			$cart[$i]['SELLING_PRICE'			] = $param['goods_selling_price'	];
			$cart[$i]['STREET_PRICE'			] = $param['goods_street_price'		];
			$cart[$i]['FACTORY_PRICE'			] = $param['goods_factory_price'	];
			$cart[$i]['GOODS_MILEAGE_SAVE_RATE'	] = $param['goods_mileage_save_rate'];
//			$cart[$i]['DISCOUNT_PRICE'			] = $param['goods_discount_price'	];
			$cart[$i]['SELLER_COUPON_CODE'		] = explode('||', $param['goods_coupon_code_s'])[0];
			$cart[$i]['ITEM_COUPON_CODE'		] = explode('||', $param['goods_coupon_code_i'])[0];

			if($param['goods_coupon_code_s'] != ""){	//상품 셀러쿠폰 할인금액 계산 (옵션추가금액때문에 여기서 계산)
				if(explode('||', $param['goods_coupon_code_s'])[1] == 'RATE'){
					$cart[$i]['SELLER_COUPON_AMT'] = $param['goods_selling_price']* (explode('||', $param['goods_coupon_code_s'])[2]/1000);

					if(explode('||', $param['goods_coupon_code_s'])[3] != 0 && explode('||', $param['goods_coupon_code_s'])[3] < $cart[$i]['SELLER_COUPON_AMT']){	//최대금액을 넘을경우 최대금액으로 적용
						$cart[$i]['SELLER_COUPON_AMT'] = explode('||', $param['goods_coupon_code_s'])[3];
					}
				} else {
					$cart[$i]['SELLER_COUPON_AMT'] = explode('||', $param['goods_coupon_code_s'])[2];
				}
			} else {
				$cart[$i]['SELLER_COUPON_AMT'] = 0;
			}

			if($param['goods_coupon_code_i'] != ""){	//상품 아이템쿠폰 할인금액 계산 (옵션추가금액때문에 여기서 계산)
				if($param['goods_coupon_code_s'] != ""){	//셀러쿠폰이 있었을경우
					if(explode('||', $param['goods_coupon_code_i'])[1] == 'RATE'){
//var_dump($cart[0]['SELLER_COUPON_AMT']);
						$cart[$i]['ITEM_COUPON_AMT'] = floor(($param['goods_selling_price']-$cart[$i]['SELLER_COUPON_AMT']) * (explode('||', $param['goods_coupon_code_i'])[2]/1000));
//var_dump($cart[0]['ITEM_COUPON_AMT']);
//var_dump(explode('||', $param['goods_coupon_code_i'])[3]);
						if(explode('||', $param['goods_coupon_code_i'])[3] != 0 && explode('||', $param['goods_coupon_code_i'])[3] < $cart[$i]['ITEM_COUPON_AMT']){	//최대금액을 넘을경우 최대금액으로 적용
							$cart[$i]['ITEM_COUPON_AMT'] = explode('||', $param['goods_coupon_code_i'])[3];
						}
					} else {
						$cart[$i]['ITEM_COUPON_AMT'] = explode('||', $param['goods_coupon_code_i'])[2];
					}
				} else {
					if(explode('||', $param['goods_coupon_code_i'])[1] == 'RATE'){
						$cart[$i]['ITEM_COUPON_AMT'] = $param['goods_selling_price'] * (explode('||', $param['goods_coupon_code_i'])[2]/1000);
//var_dump(explode('||', $param['goods_coupon_code_i'])[3]);
						if(explode('||', $param['goods_coupon_code_i'])[3] != 0 && explode('||', $param['goods_coupon_code_i'])[3] < $cart[$i]['ITEM_COUPON_AMT']){	//최대금액을 넘을경우 최대금액으로 적용
							$cart[$i]['ITEM_COUPON_AMT'] = explode('||', $param['goods_coupon_code_i'])[3];
						}
					} else {
						$cart[$i]['ITEM_COUPON_AMT'] = explode('||', $param['goods_coupon_code_i'])[2];
					}
				}
			} else {
				$cart[$i]['ITEM_COUPON_AMT'] = 0;
			}
			$cart[$i]['DISCOUNT_PRICE'			] = ($cart[$i]['SELLER_COUPON_AMT'] + $cart[$i]['ITEM_COUPON_AMT'])*$param['goods_cnt'][$i];
			$cart[$i]['ADD_DISCOUNT_PRICE'		] = "0";		//추가 할인금액 0
			$cart[$i]['COUPON_NUM'				] = "";
			$cart[$i]['ADD_COUPON_CODE'			] = "";
			$cart[$i]['ADD_COUPON_NUM'			] = "";

			if(($param['goods_selling_price'] - $param['goods_discount_price']) * $param['goods_cnt'][$i] < $param['deli_limit']){
				$cart[$i]['DELIVERY_PRICE'		] = $param['deli_cost'	];
			} else {
				$cart[$i]['DELIVERY_PRICE'		] = "0";
			}

			$cart[$i]['DELIV_POLICY_NO'			] = $param['deli_policy_no'			];

			$goods_add_deli = $this->goods_m->get_goods_add_deli($param);		//상품별 도서산간지역 추가배송비 가져오기
			$cart[$i]['ADD_DELIVERY'				] = $goods_add_deli;

			$data['cart'][$deli_code."||".$cart[$i]['DELIVERY_PRICE']][] = $cart[$i];		//배송코드(업체코드_배송정책코드)||배송비(묶음적용)
	}	//END FOR

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
					$cart[$i]['GOODS_OPTION_ADD_PRICE'		] = $param['goods_option_add_price'		][$i];
					$cart[$i]['GOODS_CNT'					] = $param['goods_cnt'					][$i];
					$cart[$i]['GOODS_IMG'					] = $param['goods_img'					][$i];
					$cart[$i]['GOODS_PRICE_CD'				] = $param['goods_price_code'			][$i];
					$cart[$i]['SELLING_PRICE'				] = $param['goods_selling_price'		][$i];
					$cart[$i]['STREET_PRICE'				] = $param['goods_street_price'			][$i];
					$cart[$i]['FACTORY_PRICE'				] = $param['goods_factory_price'		][$i];
					$cart[$i]['GOODS_MILEAGE_SAVE_RATE'		] = $param['goods_mileage_save_rate'	][$i];
					$cart[$i]['DISCOUNT_PRICE'				] = $param['goods_discount_price'		][$i];
					$cart[$i]['ADD_DISCOUNT_PRICE'			] = $param['goods_add_discount_price'	][$i];
					$cart[$i]['SELLER_COUPON_CODE'			] = $param['goods_coupon_code_s'		][$i];
					$cart[$i]['SELLER_COUPON_AMT'			] = $param['goods_coupon_amt_s'			][$i];
					$cart[$i]['ITEM_COUPON_CODE'			] = $param['goods_coupon_code_i'		][$i];
					$cart[$i]['ITEM_COUPON_AMT'				] = $param['goods_coupon_amt_i'			][$i];
//					$cart[$i]['COUPON_NUM'					] = $param['goods_coupon_num'			][$i];
					$cart[$i]['ADD_COUPON_CODE'				] = $param['goods_add_coupon_code'		][$i];
					$cart[$i]['ADD_COUPON_NUM'				] = $param['goods_add_coupon_num'		][$i];
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
						$cart[$cnt]['GOODS_OPTION_ADD_PRICE'	] = $param['goods_option_add_price'		][$cnt];
						$cart[$cnt]['GOODS_CNT'					] = $param['goods_cnt'					][$cnt];
						$cart[$cnt]['GOODS_IMG'					] = $param['goods_img'					][$cnt];
						$cart[$cnt]['GOODS_PRICE_CD'			] = $param['goods_price_code'			][$cnt];
						$cart[$cnt]['SELLING_PRICE'				] = $param['goods_selling_price'		][$cnt];
						$cart[$cnt]['STREET_PRICE'				] = $param['goods_street_price'			][$cnt];
						$cart[$cnt]['FACTORY_PRICE'				] = $param['goods_factory_price'		][$cnt];
						$cart[$cnt]['GOODS_MILEAGE_SAVE_RATE'	] = $param['goods_mileage_save_rate'	][$cnt];
						$cart[$cnt]['DISCOUNT_PRICE'			] = $param['goods_discount_price'		][$cnt];
						$cart[$cnt]['ADD_DISCOUNT_PRICE'		] = $param['goods_add_discount_price'	][$cnt];
						$cart[$cnt]['SELLER_COUPON_CODE'		] = $param['goods_coupon_code_s'		][$cnt];
						$cart[$cnt]['SELLER_COUPON_AMT'			] = $param['goods_coupon_amt_s'			][$cnt];
						$cart[$cnt]['ITEM_COUPON_CODE'			] = $param['goods_coupon_code_i'		][$cnt];
						$cart[$cnt]['ITEM_COUPON_AMT'			] = $param['goods_coupon_amt_i'			][$cnt];
//						$cart[$cnt]['COUPON_NUM'				] = $param['goods_coupon_num'			][$cnt];
						$cart[$cnt]['ADD_COUPON_CODE'			] = $param['goods_add_coupon_code'		][$cnt];
						$cart[$cnt]['ADD_COUPON_NUM'			] = $param['goods_add_coupon_num'		][$cnt];
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
				$cart[$i]['GOODS_OPTION_ADD_PRICE'	] = $param['goods_option_add_price'		][$i];
				$cart[$i]['GOODS_CNT'				] = $param['goods_cnt'					][$i];
				$cart[$i]['GOODS_IMG'				] = $param['goods_img'					][$i];
				$cart[$i]['GOODS_PRICE_CD'			] = $param['goods_price_code'			][$i];
				$cart[$i]['SELLING_PRICE'			] = $param['goods_selling_price'		][$i];
				$cart[$i]['STREET_PRICE'			] = $param['goods_street_price'			][$i];
				$cart[$i]['FACTORY_PRICE'			] = $param['goods_factory_price'		][$i];
				$cart[$i]['GOODS_MILEAGE_SAVE_RATE'	] = $param['goods_mileage_save_rate'	][$i];
				$cart[$i]['DISCOUNT_PRICE'			] = $param['goods_discount_price'		][$i];
				$cart[$i]['ADD_DISCOUNT_PRICE'		] = $param['goods_add_discount_price'	][$i];
				$cart[$i]['SELLER_COUPON_CODE'		] = $param['goods_coupon_code_s'		][$i];
				$cart[$i]['SELLER_COUPON_AMT'		] = $param['goods_coupon_amt_s'			][$i];
				$cart[$i]['ITEM_COUPON_CODE'		] = $param['goods_coupon_code_i'		][$i];
				$cart[$i]['ITEM_COUPON_AMT'			] = $param['goods_coupon_amt_i'			][$i];
//				$cart[$i]['COUPON_NUM'				] = $param['goods_coupon_num'			][$i];
				$cart[$i]['ADD_COUPON_CODE'			] = $param['goods_add_coupon_code'		][$i];
				$cart[$i]['ADD_COUPON_NUM'			] = $param['goods_add_coupon_num'		][$i];
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
	 * 주문/결제 완료 페이지 Load
	 */
	public function Step3_Order_finish_get()
	{
//		error_reporting(E_ALL);
//ini_set('display_errors', 1);
		$order_no = $_GET['order_no'];

		//모델 LOAD
		$this->load->model('order_m');

		$order = $this->order_m->get_order_info($order_no);
		$refer = $this->order_m->get_order_refer_info($order_no);

		$data['order'] = $order;

		for($i=0; $i<count($refer); $i++){
			$data['refer'][$refer[$i]['DELIV_POLICY_NO']][] = $refer[$i];
		}
		$data['order_no'] = $order_no;

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
		$this->load->view('cart/cart_step3', $data);
		$this->load->view('include/footer');
	}

	/**
	 * 장바구니에 상품 담기
	 */
	public function insert_cart_post()
	{
		error_reporting(E_ALL);
ini_set('display_errors', 1);
		$param = $this->input->post();

		$param2 = array();
		$param2['cust_no'		] = $param['cust_no'];
		$param2['goods_code'	] = $param['goods_code'];

		for($i=0; $i<count($param['goods_option_code']); $i++){
			$param2['goods_option_code'	] = $param['goods_option_code'][$i];
			$param2['goods_cnt'			] = $param['goods_cnt'][$i];

			$ChkCart = $this->cart_m->chk_cart($param2);		//동일 상품&옵션이 담겨있는지 확인하기

			if($ChkCart){
				$param2['cart_no'] = $ChkCart['CART_NO'];
				$param2['cnt'	] = $ChkCart['CART_QTY'] + $param2['goods_cnt'];
				$param2['gb'	] = 'CNT';

				$UpdCart = $this->cart_m->upd_cart($param2);
			} else {
				$AddCart = $this->cart_m->add_cart($param2);		//장바구니에 담기
			}
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

		 $param2 = array();
		 $param2['gb'		] = $param['gb'];
		 $param2['cart_no'	] = $param['cart_no'];
		 $param2['cnt'		] = $param['cnt'];
		 $param2['option_code'] = explode('||',$param['option_code'])[0];

		 $UpdCart = $this->cart_m->upd_cart($param2);	//변경
		 $this->response(array('status' => 'ok'), 200);
//========================================================================
//		 //모델 LOAD
//		 $this->load->model('goods_m');
//
//		 $ChkOptionQTY = $this->goods_m->get_goods_option_qty($param2['option_code']);
//
//		 if($ChkOptionQTY['QTY'] >= $param2['cnt']){	//구매하고자 하는 수량이 재고수량보다 적을경우
//			$UpdCart = $this->cart_m->upd_cart($param2);	//변경
//			$this->response(array('status' => 'ok'), 200);
//		 } else {
//			$this->response(array('status' => 'error', 'message' => '현재 이 상품의 주문가능한 재고수량은 '.$ChkOptionQTY['QTY'].'개 입니다. '.$ChkOptionQTY['QTY'].'개 이하로 선택해주세요.'), 200);
//		 }
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
		 error_reporting(E_ALL);
ini_set('display_errors', 1);
		 $param = $this->input->post();

		 $no_deli  = $this->cart_m->get_no_delivery($param);		//배송불가지역인지 확인
//var_dump($no_deli);
		 if($no_deli){	//배송불가지역일경우
			 $this->response(array('status' => 'error', 'message' => $no_deli['DELIV_AREA_NM']."에 배송이 불가능한 상품이 있습니다. \n상품별 배송지역을 확인해주세요."), 200);
		 } else {
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



}