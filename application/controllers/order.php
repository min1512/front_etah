<?php
/**
 * @property order_m $order_m
 * User: 박상현
 * Date:
 */
class Order extends MY_Controller
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
        $this->load->model('order_m');


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


    public function process_post()
    {
        log_message("DEBUG", "controll-process in ==============================================");
//		error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $param = $this->input->post();
        $date = date("Y-m-d H:i:s", time());

        log_message("DEBUG", "controll-process in-param ".json_encode($param)."==============================================");

        $kcp_log_data1 = $param['imp_uid'];
        $kcp_log_data2 = $param['kcp_temp_data'];

        //모델 LOAD
        $this->load->model('mywiz_m');
        $this->load->model('member_m');
        $kakao_no					= $this->session->userdata('EMS_U_NO_');

        if($param['buyerid'] != 'GUEST'){
            $order_info			= $this->member_m->get_member_info_id($param['buyerid']);	//주문자 정보 가져오기
        } else {
            $order_info			= '';
        }

        log_message("DEBUG", "controll-process in-orderInfo ".$order_info."==============================================");

        $param['buyerzipcode'	] = isset($order_info['ZIPCODE']) ? $order_info['ZIPCODE'] : "";
        $param['buyeraddr1'		] = isset($order_info['ADDR1']) ? $order_info['ADDR1'] : "";
        $param['buyeraddr2'		] = isset($order_info['ADDR2']) ? $order_info['ADDR2'] : "";
        $param['buyermobno'		] = isset($order_info['MOB_NO']) ? $order_info['MOB_NO'] : "";


        log_message("DEBUG", "controll-process in-setOrder1 ".json_encode($param)."==============================================");
        log_message("DEBUG", "controll-process in-setOrder2 ".$date."==============================================");

        $order_no			= $this->order_m->set_order($param, $date);		//주문 마스타 생성

        log_message("DEBUG", "controll-process in-orderNo ".$order_no."==============================================");

        for($i=0; $i<count($param['group_deli_policy_no']); $i++){
            $group = array();
            $group['deli_policy_no'	] = $param['group_deli_policy_no'][$i];
            $group['deli_cost'		] = $param['group_delivery_price'][$i] + $param['group_add_delivery_price'][$i];

            $order_deliv_fee_no = $this->order_m->set_order_deli_fee($order_no, $group);		//주문 배송비 생성

            for($j=0; $j<count($param['goods_code']); $j++){
                if($param['goods_deli_policy_no'][$j] == $group['deli_policy_no']){
                    $param2 = array();
                    $param2['goods_code'			] = $param['goods_code'][$j];
                    $param2['goods_name'			] = $param['goods_name'][$j];
                    $param2['goods_option_code'		] = $param['goods_option_code'][$j];
                    $param2['goods_option_name'		] = $param['goods_option_name'][$j];
                    $param2['goods_option_add_price'] = $param['goods_option_add_price'][$j];
                    $param2['goods_cnt'				] = $param['goods_cnt'][$j];
                    $param2['goods_price'			] = $param['goods_price_code'][$j];
                    $param2['goods_street_price'	] = $param['goods_street_price'][$j];
                    $param2['goods_selling_price'	] = $param['goods_selling_price'][$j];
                    $param2['goods_factory_price'	] = $param['goods_factory_price'][$j];
                    $param2['total_price'			] = ($param['goods_selling_price'][$j]+$param['goods_option_add_price'][$j])*$param['goods_cnt'][$j];
                    $param2['goods_mileage_saving_amt'] = $param['goods_mileage_save_amt'][$j];		//적립예정마일리지

                    $order_refer_no = $this->order_m->set_order_refer($order_no, $order_deliv_fee_no, $param2);		//주문 상세 생성
                    $param['order_refer_no'][$j] = $order_refer_no;
                    $order_refer_progress_no	= $this->order_m->set_order_refer_progress($order_refer_no, 'OA01');	//주문 상태 생성
                    $update_order_refer_state	= $this->order_m->upd_order_refer_state($order_refer_no, $order_refer_progress_no);	//주문상태 업데이트
//					if($param['buyerid'] != '' && $param['buyercode'] != ''){	//비회원이 아니라면
                    $update_user_cart_state		= $this->order_m->upd_cart_state($param2, $param['buyercode']);		//주문 상품 장바구니에 제거
//					}
                    $update_goods_option_cnt	= $this->order_m->upd_option_cnt($param2);		//주문 상품 재고 차감

                    if($param2['goods_mileage_saving_amt'] > 0 && $param['buyerid'] != 'GUEST'){	//적립할 마일리지 금액이 있다면 && 회원이라면
                        $param['CUST_NO'		] = $param['buyercode'];
                        $cust_mileage_info = $this->mywiz_m->get_mileage_info($param);
                        if($cust_mileage_info){
                            $param['org_mileage'	] = $cust_mileage_info['MILEAGE_AMT'];		//기존에 갖고 있던 마일리지
                            $param['pay_mileage_amt'] = $cust_mileage_info['PAY_MILEAGE_AMT'];	//기존에 사용한 마일리지 총합계
                        } else {
                            $param['org_mileage'		] = 0;
                            $param['pay_mileage_amt'	] = 0;
                        }
                        $param['goods_mileage_saving_amt'] = $param2['goods_mileage_saving_amt'];

                        $cust_mileage_save = $this->order_m->set_cust_mileage_save($order_refer_no, $param, $date);
                        $upd_cust_save_mileage = $this->order_m->upd_cust_pay_mileage($param,'save');

                    }

                }	//END if

            }	//END for

        }	//END for

        $order_delivery = $this->order_m->set_order_delivery($order_no, $param);		//주문 배송지 정보

        $pay_no = $this->order_m->set_order_pay($order_no, $param, $date);

        if($param['order_payment_type'] != '04') {
            $order_pay_dtl = $this->order_m->set_order_pay_dtl($pay_no, $param, $date);
        }

        if($param['order_payment_type'] == '01'){	//신용카드 결제
            $order_pay_dtl_card = $this->order_m->upd_order_pay_dtl_card($pay_no, $param);
            $upd_order_pay_state = $this->order_m->upd_order_pay_state($pay_no);	//결제완료일자 업데이트

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA03');	//주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        } else if($param['order_payment_type'] == '03'){	//실시간 계좌이체
            $order_pay_dtl_bank = $this->order_m->upd_order_pay_dtl_bank($pay_no, $param, $date);
            $upd_order_pay_state = $this->order_m->upd_order_pay_state($pay_no);	//결제완료일자 업데이트

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA03');	//주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        } else if($param['order_payment_type'] == '05'){	//휴대폰 결제
            $order_pay_dtl_phone = $this->order_m->upd_order_pay_dtl_phone($pay_no, $param, $date);
            $upd_order_pay_state = $this->order_m->upd_order_pay_state($pay_no);	//결제완료일자 업데이트

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA03');	//주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        } else if($param['order_payment_type'] == '02'){	//무통장입금
            $order_pay_dtl_bank = $this->order_m->upd_order_pay_dtl_vbank($pay_no, $param, $date);

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA02');	//주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        } else if($param['order_payment_type'] == '08'){    //ARS 결제
            $order_pay_dtl_vars = $this->order_m->upd_order_pay_dtl_vars($pay_no, $param, $date);

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA02');	//주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        }

        if($param['use_mileage'] > 0 && $param['buyerid'] != 'GUEST'){	//마일리지를 사용했다면 && 회원이라면
            $order_pay_dtl_mileage_no = $this->order_m->set_order_pay_dtl_mileage($pay_no, $param, $date);
            $param['CUST_NO'] = $param['buyercode'];
            $cust_mileage_info = $this->mywiz_m->get_mileage_info($param);
//			$param['cust_mileage_no'] = $cust_mileage_info['CUST_MILEAGE_NO'];	//컬럼없어짐
            $param['org_mileage'] = $cust_mileage_info['MILEAGE_AMT'];		//기존에 갖고 있던 마일리지
            $param['pay_mileage_amt'] = $cust_mileage_info['PAY_MILEAGE_AMT'];	//기존에 사용한 마일리지 총합계

            $cust_mileage_pay = $this->order_m->set_cust_mileage_pay($order_pay_dtl_mileage_no, $param, $date);
            $upd_cust_pay_mileage = $this->order_m->upd_cust_pay_mileage($param,'pay');

            //전액 마일리지 결제
            $real_pay_amt = $param['total_order_money']+$param['total_delivery_money']-$param['total_discount_money']-$param['use_mileage'];
            if($real_pay_amt == 0)  {
                $upd_order_pay_state = $this->order_m->upd_order_pay_state($pay_no);	//결제완료일자 업데이트

                for($i=0; $i<count($param['goods_code']); $i++){
                    $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA03');	//주문 상태 생성
                    $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
                }	//END for
            }
        }
//var_dump($param);
        for($i=0; $i<count($param['goods_coupon_code_s']); $i++){	//상품 셀러 쿠폰
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['goods_coupon_code_s'][$i];		//상품쿠폰코드
            $param2['goods_coupon_num'			] = "";			//상품쿠폰번호
            $param2['goods_discount_price'		] = floor($param['goods_coupon_amt_s'][$i])*$param['goods_cnt'][$i];		//상품쿠폰할인적용금액(갯수총합계)
//var_dump($param2);
            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(상품쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
            }	//END if
        }	//END for

        for($i=0; $i<count($param['goods_coupon_code_i']); $i++){	//상품 아이템 쿠폰
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['goods_coupon_code_i'][$i];		//상품쿠폰코드
            $param2['goods_coupon_num'			] = "";			//상품쿠폰번호
            $param2['goods_discount_price'		] = floor($param['goods_coupon_amt_i'][$i])*$param['goods_cnt'][$i];		//상품쿠폰할인적용금액(갯수총합계)

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(상품쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
            }	//END if
        }	//END for

        for($i=0; $i<count($param['goods_add_coupon_code']); $i++){	//상품 추가 쿠폰
            $param2 = array();
            $param2['goods_coupon_no'			] = $param['goods_add_coupon_no'][$i];
            $param2['goods_coupon_code'			] = $param['goods_add_coupon_code'][$i];	//추가쿠폰코드
            $param2['goods_coupon_num'			] = $param['goods_add_coupon_num'][$i];		//추가쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_add_discount_price'][$i];	//추가쿠폰할인적용금액
            $param2['cust_no'					] = $param['buyercode'];					//고객코드

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(중복쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
                if($param2['goods_coupon_num'] != ''){	//쿠폰번호가 있다면
                    $coupon_dtl_use	= $this->order_m->upd_coupon_dtl($param2, $date);		//쿠폰상세에 쿠폰 상태 변경
                }
                if($param['buyerid'] != 'GUEST'){	//비회원이 아닐경우
                    $cust_coupon_use = $this->order_m->upd_cust_coupon($param2, $order_no);	//사용쿠폰 상태 변경
                }
            }	//END if
        }	//END for

        if($param['cart_coupon_code'] != ""){	//고객쿠폰을 사용했다면 (함수사용안함)
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['cart_coupon_code'];			//고객쿠폰코드
            $param2['goods_coupon_num'			] = $param['cart_coupon_num'];			//고객쿠폰번호
            $param2['goods_discount_price'		] = $param['cart_coupon_amt'];			//고객쿠폰할인적용금액
            $param2['cust_no'					] = $param['buyercode'];				//고객코드

            $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(중복쿠폰)
            if($param2['goods_coupon_num'] != ''){	//쿠폰번호가 있다면
                $coupon_dtl_use	= $this->order_m->upd_coupon_dtl($param2, $date);		//쿠폰상세에 쿠폰 상태 변경
            }
            $cust_coupon_use = $this->order_m->upd_cust_coupon($param2, $order_no);	//사용쿠폰 상태 변경
        }

        //비구매회원 -> 구매회원으로 변경
        if($param['buyerid'] != 'GUEST') {    //비회원이 아닐경우
            $this->order_m->upd_cust_level($order_info['CUST_NO']);
        }

        if($param['buyertel'] != "" && $kakao_no != 5109){		//주문 완료 SMS 발송


            $kakao = array();
            $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
            //           log_message('DEBUG','===========kakao message');
            /*$sParam = array();
            $sParam['DEST_PHONE'] = str_replace('-','',$param['buyertel']);
            $sParam['GUBN_VAL'  ] = 'QUIK';
            $sParam['MSG'       ] = '[ETAH]'.$param['order_name'].'님, 주문해주셔서 감사합니다! 마이페이지 > 주문번호('.$order_no.')';*/

//			$sendSMS = $this->order_m->set_order_sms($sParam);
            $pay_sum = $param['total_order_money']+$param['total_delivery_money']-$param['total_discount_money']-$param['use_mileage'];
            $Gcount = count($param['goods_code']);
            if($Gcount > 1){
                $num = $Gcount - 1;
                $goods_str = $param['goods_name'][0]." 외 ".$num."개";
            }else{
                $goods_str = $param['goods_name'][0];
            }

            if($param['order_payment_type'] == '02'){
                $kakao['MSG'] = "[에타홈] 주문완료 

".$param['order_name']."님 주문해주셔서 감사합니다.
무통장 입금 계좌 안내드립니다 ^^

▶주문번호 : ".$order_no."
▶상품명 : ".$goods_str."
▶입금 요청 금액 : ".number_format($pay_sum)."원
▶은행명 : ".$param['vbank_name']."
▶계좌번호 : ".$param['vbank_num']."
▶예금주 : ㈜에타
▶입금마감일 : ".date("Y-m-d H:i:s", strtotime($param['vbank_date']))."

※  주문 후 시간 이내 입금확인이 안될 시 주문이 자동취소 됩니다. 기한내 입금 부탁드려요!";
                $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813532922317755347';
                $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
                if($param['buyermobno'] != '' || $param['buyermobno'] != null){
                    $kakao['DEST_PHONE'] = str_replace('-','',$param['buyermobno']);
                }else{
                    $kakao['DEST_PHONE'] = str_replace('-','',$param['buyertel']);
                }
                $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';
                $sendSMS = $this->order_m->send_sms_kakao($kakao);

            }else if($param['order_payment_type'] == '08'){
                $kakao['MSG'] = "[에타홈] 주문완료 

".$param['order_name']."님 주문해주셔서 감사합니다.
ARS 결제 가상번호 안내드립니다^^

▶주문번호 : ".$order_no."
▶상품명 : ".$goods_str."
▶결제 요청금액 : ".number_format($pay_sum)."원
▶가상번호 : ".$param['vnum_no']."
▶결제 유효기간 : ".date("Y-m-d H:i:s", strtotime($param['expr_dt']))."

※ 가상번호로 통화해 결제를 완료해주세요.

※ 주문 후 시간 이내 결제확인이 안될 시 주문이 자동취소 됩니다. 기한내 결제 부탁드려요!";
                $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813545516788953360';
                $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
                if($param['buyermobno'] != '' || $param['buyermobno'] != null){
                    $kakao['DEST_PHONE'] = str_replace('-','',$param['buyermobno']);
                }else{
                    $kakao['DEST_PHONE'] = str_replace('-','',$param['buyertel']);
                }
                $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';
                $sendSMS = $this->order_m->send_sms_kakao($kakao);

            }else{
                $kakao['MSG'] = "[에타홈] 주문완료
 
주문이 완료 되었습니다.
배송이 시작되면 
다시 안내드릴게요.^^

▶주문번호: ".$order_no."
▶상품명: ".$goods_str."
▶주문금액: ".number_format($pay_sum)."원
* 주문금액은 쿠폰할인 및 
즉시 할인금액이 반영 되지 않은 상품 금액 입니다.

 ※ 발송 예정일은 
상품 재고 현황에 따라 
변경 될 수 있습니다.

※ 가구 등 설치가 필요하거나 
화물로 배송되는 상품의 경우
업체에서 연락드려 
배송일 협의가 진행됩니다.

※ 해외직구 상품의 배송기간은 
최대 1달 걸리니 상세페이지나 
고객센터(1522-5572)를 통해 
예정일을 확인해주세요!";
                $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813560816788648361';
                $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
                if($param['buyermobno'] != '' || $param['buyermobno'] != null){
                    $kakao['DEST_PHONE'] = str_replace('-','',$param['buyermobno']);
                }else{
                    $kakao['DEST_PHONE'] = str_replace('-','',$param['buyertel']);
                }
                $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';
                $sendSMS = $this->order_m->send_sms_kakao($kakao);
                // 2019.10.10
                // 공방상품 체크 추가
                for ($i=0; $i<count($param['goods_code']); $i++){
                    $row = $this->order_m->check_class_goods($param['goods_code'][$i]);
                    if($row['BRAND_NM'] != NULL){
                        $ckakao = array();
                        $ckakao['buyer'         ] = $param['order_name'    ];
                        $ckakao['goods_nm'      ] = $param['goods_name'    ][$i];
                        $ckakao['order_refer_cd'] = $param['order_refer_no'][$i];
                        $ckakao['dest_phone'    ] = $kakao['DEST_PHONE'    ];
                        $ckakao['send_phone'    ] = $row['MOB_NO'];
                        self::class_kakao_send($ckakao);
                    }
                }

            }
//            $sendSMS = $this->order_m->send_sms_kakao($kakao);

        }

//		//주문 완료 이메일 메일 발송
        if($param['buyeremail'] != ""){
            $mailParam = array();
            $mailParam["kind"		] = "order";
            $mailParam["mem_name"	] = $param['buyername'];
            $mailParam["mem_email"	] = $param['buyeremail'];
            $Mail_order				  = $this->order_m->get_order_info($order_no);
            $Mail_order_refer		  = $this->order_m->get_order_refer_info($order_no);

            for ($i=0; $i<count($Mail_order_refer); $i++){
                $mailParam["order_refer_key"		][$i] = $Mail_order_refer[$i]['ORDER_REFER_NO'];
                $mailParam["goods_code"				][$i] = $Mail_order_refer[$i]['GOODS_CD'];
                $mailParam["goods_name"				][$i] = $Mail_order_refer[$i]['GOODS_NM'];
                $mailParam["goods_brand_name"		][$i] = $Mail_order_refer[$i]['BRAND_NM'];
                $mailParam["goods_img"				][$i] = $Mail_order_refer[$i]['IMG_URL'];
                $mailParam["goods_option_name"		][$i] = $Mail_order_refer[$i]['GOODS_OPTION_NM'];
                $mailParam["goods_cnt"				][$i] = $Mail_order_refer[$i]['ORD_QTY'];
                $mailParam["goods_price"			][$i] = $Mail_order_refer[$i]['SELLING_PRICE'];
                $mailParam["goods_discount_price"	][$i] = $Mail_order_refer[$i]['DC_AMT'];
                $mailParam["goods_option_add_price"	][$i] = $Mail_order_refer[$i]['GOODS_OPTION_ADD_PRICE'];
                $mailParam["goods_total_price"		][$i] = $Mail_order_refer[$i]['TOTAL_PRICE'];
            }

            $mailParam["order_receiver_name"		] = $Mail_order['RECEIVER_NM'];
            $mailParam["order_deliv_msg"			] = $Mail_order['DELIV_MSG'];
            $mailParam["order_card_company"			] = $Mail_order['CARD_COMPANY_NM'];
            $mailParam["order_card_fee"				] = $Mail_order['CARD_FEE_AMT'];
            $mailParam["order_card_month"			] = $Mail_order['CARD_MONTH'];
            $mailParam["order_free_interest_yn"		] = $Mail_order['FREE_INTEREST_YN'];
            $mailParam["order_bank_name"			] = $Mail_order['BANK_NM'];
            $mailParam["order_bank_account_no"		] = $Mail_order['BANK_ACCOUNT_NO'];
            $mailParam["order_deposit_deadline"		] = $Mail_order['DEPOSIT_DEADLINE_DY'];
            $mailParam["order_deposit_cust_nm"		] = $Mail_order['DEPOSIT_CUST_NM'];
            $mailParam["order_delivery_amt"			] = $Mail_order['DELIV_COST_AMT'];
            $mailParam["order_discount_amt"			] = $Mail_order['DC_AMT'];
            $mailParam["order_amt"					] = $Mail_order['ORDER_AMT'];
            $mailParam["order_mileage_amt"			] = $Mail_order['MILEAGE_AMT'];
            $mailParam["total_pay_sum"				] = $Mail_order['TOTAL_PAY_SUM'];
            $mailParam["order_real_pay_amt"			] = $Mail_order['REAL_PAY_AMT'];
            $mailParam["order_pay_kind_code"		] = $Mail_order['ORDER_PAY_KIND_CD'];
            $mailParam["order_pay_kind_name"		] = $Mail_order['ORDER_PAY_KIND_CD_NM'];
            $mailParam["order_receiver_addr"		] = $Mail_order['RECEIVER_ADDR1']." ".$Mail_order['RECEIVER_ADDR2'];
            $mailParam["order_receiver_zipcode"		] = $Mail_order['RECEIVER_ZIPCODE'];
            $mailParam["order_phone"				] = $Mail_order['RECEIVER_PHONE_NO'];
            $mailParam["order_mobno"				] = $Mail_order['RECEIVER_MOB_NO'];
            $mailParam["goods_row"					] = count($Mail_order_refer);
            $mailParam["date"						] = $date;
            $mailParam["order_no"					] = $order_no;
            $mailParam["vars_vnum_no"				] = $Mail_order['VARS_VNUM_NO'];
            $mailParam["vars_expr_dt"				] = $Mail_order['VARS_EXPR_DT'];

            self::_background_send_mail($mailParam);
        }


        $this->order_m->set_temptno_data($kcp_log_data1, $kcp_log_data2);
        $this->response(array('status' => 'ok', 'order_no' => $order_no), 200);

    }	//END function

    /**
     * 아임포트 Notification
     * 아임포트에서 보내는 가상계좌, 무통장입금에 대한 상태 변경값 처리
     */
    public function IamPort_Notification_post()
    {
        $param = $this->input->post();	//param { imp_uid : 아임포트 결제고유번호, merchant_uid : 상점에서 전달한 고유번호 }

        $OrderInfo = $this->order_m->get_pay_N_order_info($param['imp_uid']);	//결제번호, 주문상세번호 가져오기

//		var_dump($OrderInfo);
        //20171128 이진호 아임포트에서 보내는 가상계좌 , 무통장 입금에 대한 상태 변경값 처리에 대한 로그
        $this->order_m->import_noti_info_log($param['imp_uid'], $param['merchant_uid'], $param['status']);

        if(!$OrderInfo){
            echo "No Order";
            return false;
        }

        foreach ($OrderInfo as $OrderRow){
            if($OrderRow['ORDER_REFER_PROC_STS_CD'] == 'OA02'){	//결제중(미입금)상태일때만 업데이트

                $upd_paydtl_state			= $this->order_m->upd_order_pay_dtl_vbank_state($param['imp_uid']);	//결제상세 상태 업데이트
                $upd_pay_state				= $this->order_m->upd_order_pay_state($OrderRow['PAY_NO']);		//결제 상태 업데이트
                $order_refer_progress_no	= $this->order_m->set_order_refer_progress($OrderRow['ORDER_REFER_NO'], 'OA03'); //주문상태로그생성
                $upd_order_refer_state		= $this->order_m->upd_order_refer_state($OrderRow['ORDER_REFER_NO'], $order_refer_progress_no);	//주문상태 업데이트

                if($order_refer_progress_no){
                    echo "Update Success!!";

                } else {
                    echo "Error!";
                }
            } else {
                echo "주문상태가 결제중(미입금)상태가 아닙니다.";
            }
        }
    }


    /**
     * 메일 작성
     */
    private function _background_send_mail($param)
    {
//				error_reporting(E_ALL);
//ini_set('display_errors', 1);
        set_time_limit(0);

        $this->load->helper('url');
        $url = site_url("/order/background_send_mail");

        $type = "POST";

        foreach ($param as $key => &$val) {
            if (is_array($val)) $val = implode('|||', $val);
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
//				error_reporting(E_ALL);
//ini_set('display_errors', 1);
        set_time_limit(0);

        $param = $this->post();

        $buyername = $param['mem_name'];

        $data['goods_row'] = $param['goods_row'];		//주문 상품 수

        $order_refer_key		= explode('|||', $param['order_refer_key']);
        $goods_code				= explode('|||', $param['goods_code']);
        $goods_name				= explode('|||', $param['goods_name']);
        $goods_brand_name		= explode('|||', $param['goods_brand_name']);
        $goods_img				= explode('|||', $param['goods_img']);
        $goods_option_name		= explode('|||', $param['goods_option_name']);
        $goods_cnt				= explode('|||', $param['goods_cnt']);
        $goods_price			= explode('|||', $param['goods_price']);
        $goods_discount_price	= explode('|||', $param['goods_discount_price']);
        $goods_option_add_price	= explode('|||', $param['goods_option_add_price']);
        $goods_total_price		= explode('|||', $param['goods_total_price']);

        for ($i=0; $i<$param['goods_row']; $i++){
            $data['goods'][$i]['order_refer_key'		] = $order_refer_key[$i];
            $data['goods'][$i]['goods_code'				] = $goods_code[$i];
            $data['goods'][$i]['goods_name'				] = $goods_name[$i];
            $data['goods'][$i]['goods_brand_name'		] = $goods_brand_name[$i];
            $data['goods'][$i]['goods_img'				] = $goods_img[$i];
            $data['goods'][$i]['goods_option_name'		] = $goods_option_name[$i];
            $data['goods'][$i]['goods_cnt'				] = $goods_cnt[$i];
            $data['goods'][$i]['goods_price'			] = $goods_price[$i];
            $data['goods'][$i]['goods_discount_price'	] = $goods_discount_price[$i];
            $data['goods'][$i]['goods_option_add_price'	] = $goods_option_add_price[$i];
            $data['goods'][$i]['goods_total_price'		] = $goods_total_price[$i];
        }

        $data['order_receiver_name'		] = $param['order_receiver_name'];
        $data['order_deliv_msg'			] = $param['order_deliv_msg'];
        $data['order_card_company'		] = $param['order_card_company'];
        $data['order_card_fee'			] = $param['order_card_fee'];
        $data['order_card_month'		] = $param['order_card_month'];
        $data['order_free_interest_yn'	] = $param['order_free_interest_yn'];
        $data['order_bank_name'			] = $param['order_bank_name'];
        $data['order_bank_account_no'	] = $param['order_bank_account_no'];
        $data['order_deposit_deadline'	] = $param['order_deposit_deadline'];
        $data['order_deposit_cust_nm'	] = $param['order_deposit_cust_nm'];
        $data['order_delivery_amt'		] = $param['order_delivery_amt'];
        $data['order_discount_amt'		] = $param['order_discount_amt'];
        $data['order_amt'				] = $param['order_amt'];
        $data['order_mileage_amt'		] = $param['order_mileage_amt'];
        $data['total_pay_sum'			] = $param['total_pay_sum'];
        $data['order_real_pay_amt'		] = $param['order_real_pay_amt'];
        $data['order_pay_kind_code'		] = $param['order_pay_kind_code'];
        $data['order_pay_kind_name'		] = $param['order_pay_kind_name'];
        $data['order_receiver_addr'		] = $param['order_receiver_addr'];
        $data['order_receiver_zipcode'	] = $param['order_receiver_zipcode'];
        $data['order_phone'				] = $param['order_phone'];
        $data['order_mobno'				] = $param['order_mobno'];
        $data['date'					] = $param['date'];
        $data['order_no'				] = $param['order_no'];
        $data['gb'						] = $param['gb'];
        $data['vars_vnum_no'			] = $param['vars_vnum_no'];
        $data['vars_expr_dt'			] = $param['vars_expr_dt'];


        /**
         * 구매 메일 발송
         */
        $this->load->helper('string');
        $this->load->library('email');

        $body = self::_mail_template($data); //메일 템플릿 가져오기

        //이메일 인증
        $subject = "ETA HOME 주문하신 상품내역입니다!";

        $body = str_replace("{{mem_name}}"	 	, $buyername	, $body);
        $body = str_replace("{{order_date}}" 	, date('Ymd')	, $body);

        $receive = $param['mem_email'];

        $this->email->sendmail($receive, $subject, $body, 'info@etah.co.kr', 'ETA HOME Mall');

    }

    /**
     * 메일 템플릿 가져오기
     */
    private function _mail_template($data)
    {
        $body = $this->load->view('template/email/order/email_body.php', $data, TRUE);

        return $body;
    }


    /**
     *kcp 결제 요청 결과값 처리
     */
    public function kcpCli_post(){

        include APPPATH ."/third_party/KCP/cfg/site_conf_inc.php";
        $this->load->library('C_PP_CLI');
        $result = "fail";
        $kcp_log_data = $_POST["kcp_log_data"];

        /* ============================================================================== */
        /* =   01. 지불 요청 정보 설정                                                  = */
        /* = -------------------------------------------------------------------------- = */
        $req_tx         = $_POST[ "req_tx"         ]; // 요청 종류
        $tran_cd        = $_POST[ "tran_cd"        ]; // 처리 종류
        /* = -------------------------------------------------------------------------- = */
        $cust_ip        = getenv( "REMOTE_ADDR"    ); // 요청 IP
        $ordr_idxx      = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호
        $good_name      = $_POST[ "good_name"      ]; // 상품명
        /* = -------------------------------------------------------------------------- = */
        $res_cd         = "";                         // 응답코드
        $res_msg        = "";                         // 응답메시지
        $res_en_msg     = "";                         // 응답 영문 메세지
        $tno            = $_POST[ "tno"            ]; // KCP 거래 고유 번호
        $vcnt_yn        = $_POST[ "vcnt_yn"        ]; // 가상계좌 에스크로 사용 유무
        /* = -------------------------------------------------------------------------- = */
        $buyr_name      = $_POST[ "buyr_name"      ]; // 주문자명
        $buyr_tel1      = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호
        $buyr_tel2      = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
        $buyr_mail      = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소
        /* = -------------------------------------------------------------------------- = */
        $use_pay_method = $_POST[ "use_pay_method" ]; // 결제 방법
        $bSucc          = "";                         // 업체 DB 처리 성공 여부
        /* = -------------------------------------------------------------------------- = */
        $app_time       = "";                         // 승인시간 (모든 결제 수단 공통)
        $total_amount   = 0;                          // 복합결제시 총 거래금액
        $amount         = "";                         // KCP 실제 거래 금액
        $coupon_mny     = "";                         // 쿠폰금액
        /* = -------------------------------------------------------------------------- = */
        $card_cd        = "";                         // 신용카드 코드
        $card_name      = "";                         // 신용카드 명
        $app_no         = "";                         // 신용카드 승인번호
        $noinf          = "";                         // 신용카드 무이자 여부
        $quota          = "";                         // 신용카드 할부개월
        $partcanc_yn    = "";                         // 부분취소 가능유무
        $card_bin_type_01 = "";                       // 카드구분1
        $card_bin_type_02 = "";                       // 카드구분2
        $card_mny       = "";                         // 카드결제금액
        /* = -------------------------------------------------------------------------- = */
        $bank_name      = "";                         // 은행명
        $bank_code      = "";                         // 은행코드
        $bk_mny         = "";                         // 계좌이체결제금액
        /* = -------------------------------------------------------------------------- = */
        $bankname       = "";                         // 입금할 은행명
        $depositor      = "";                         // 입금할 계좌 예금주 성명
        $account        = "";                         // 입금할 계좌 번호
        $va_date        = "";                         // 가상계좌 입금마감시간
        /* = -------------------------------------------------------------------------- = */
        $pnt_issue      = "";                         // 결제 포인트사 코드
        $pnt_amount     = "";                         // 적립금액 or 사용금액
        $pnt_app_time   = "";                         // 승인시간
        $pnt_app_no     = "";                         // 승인번호
        $add_pnt        = "";                         // 발생 포인트
        $use_pnt        = "";                         // 사용가능 포인트
        $rsv_pnt        = "";                         // 총 누적 포인트
        /* = -------------------------------------------------------------------------- = */
        $commid         = "";                         // 통신사 코드
        $mobile_no      = "";                         // 휴대폰 코드
        /* = -------------------------------------------------------------------------- = */
        $shop_user_id   = $_POST[ "shop_user_id"   ]; // 가맹점 고객 아이디
        $tk_van_code    = "";                         // 발급사 코드
        $tk_app_no      = "";                         // 상품권 승인 번호
        /* = -------------------------------------------------------------------------- = */
        $cash_yn        = $_POST[ "cash_yn"        ]; // 현금영수증 등록 여부
        $cash_authno    = "";                         // 현금 영수증 승인 번호
        $cash_tr_code   = $_POST[ "cash_tr_code"   ]; // 현금 영수증 발행 구분
        $cash_id_info   = $_POST[ "cash_id_info"   ]; // 현금 영수증 등록 번호
        $cash_no        = "";                         // 현금 영수증 거래 번호
        /* ============================================================================== */
        /* =   01-1. 에스크로 지불 요청 정보 설정                                       = */
        /* = -------------------------------------------------------------------------- = */
        $escw_used      = $_POST[  "escw_used"     ]; // 에스크로 사용 여부
        $pay_mod        = $_POST[  "pay_mod"       ]; // 에스크로 결제처리 모드
        $deli_term      = $_POST[  "deli_term"     ]; // 배송 소요일
        $bask_cntx      = $_POST[  "bask_cntx"     ]; // 장바구니 상품 개수
        $good_info      = $_POST[  "good_info"     ]; // 장바구니 상품 상세 정보
        $rcvr_name      = $_POST[  "rcvr_name"     ]; // 수취인 이름
        $rcvr_tel1      = $_POST[  "rcvr_tel1"     ]; // 수취인 전화번호
        $rcvr_tel2      = $_POST[  "rcvr_tel2"     ]; // 수취인 휴대폰번호
        $rcvr_mail      = $_POST[  "rcvr_mail"     ]; // 수취인 E-Mail
        $rcvr_zipx      = $_POST[  "rcvr_zipx"     ]; // 수취인 우편번호
        $rcvr_add1      = $_POST[  "rcvr_add1"     ]; // 수취인 주소
        $rcvr_add2      = $_POST[  "rcvr_add2"     ]; // 수취인 상세주소
        $escw_yn        = "";                         // 에스크로 여부
        /* = -------------------------------------------------------------------------- = */
        /* =   01. 지불 요청 정보 설정 END                                              = */
        /* ============================================================================== */

        /* ============================================================================== */
        /* =   02. 인스턴스 생성 및 초기화(변경 불가)                                   = */
        /* = -------------------------------------------------------------------------- = */
        /* =       결제에 필요한 인스턴스를 생성하고 초기화 합니다.                     = */
        /* = -------------------------------------------------------------------------- = */
        $c_PayPlus = new C_PP_CLI;

        $c_PayPlus->mf_clear();
        /* ------------------------------------------------------------------------------ */
        /* =   02. 인스턴스 생성 및 초기화 END                                          = */
        /* ============================================================================== */


        /* ============================================================================== */
        /* =   03. 처리 요청 정보 설정                                                  = */
        /* = -------------------------------------------------------------------------- = */
        /* = -------------------------------------------------------------------------- = */
        /* =   03-1. 승인 요청 정보 설정                                                = */
        /* = -------------------------------------------------------------------------- = */

        if ( $req_tx == "pay" )
        {
            /* 1원은 실제로 업체에서 결제하셔야 될 원 금액을 넣어주셔야 합니다. 결제금액 유효성 검증 */
            //$c_PayPlus->mf_set_ordr_data( "ordr_mony",  "1" );                                   
            $c_PayPlus->mf_set_ordr_data( "ordr_mony",  $_POST[ "good_mny"         ] );
            $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
        }
        /* ------------------------------------------------------------------------------ */
        /* =   03.  처리 요청 정보 설정 END                                             = */
        /* ============================================================================== */

        /* ============================================================================== */
        /* =   04. 실행                                                                 = */
        /* = -------------------------------------------------------------------------- = */
        if ( $tran_cd != "" )
        {
            $c_PayPlus->mf_do_tx( "", $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "",
                $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                $cust_ip, "3", 0, 0, $g_conf_log_path); // 응답 전문 처리
        }
        else
        {
            $c_PayPlus->m_res_cd  = "9562";
            $c_PayPlus->m_res_msg = "연동 오류| tran_cd값이 설정되지 않았습니다.";
        }

        $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
        $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
        /* $res_en_msg = $c_PayPlus->mf_get_res_data( "res_en_msg" );  // 결과 영문 메세지 */
        /* = -------------------------------------------------------------------------- = */
        /* =   04. 실행 END                                                             = */
        /* ============================================================================== */


        /* ============================================================================== */
        /* =   05. 승인 결과 값 추출                                                    = */
        /* = -------------------------------------------------------------------------- = */
        /* =   수정하지 마시기 바랍니다.                                                = */
        /* = -------------------------------------------------------------------------- = */
        if ( $req_tx == "pay" )
        {
            if( $res_cd == "0000" )
            {
                $tno       = $c_PayPlus->mf_get_res_data( "tno"       ); // KCP 거래 고유 번호
                $amount    = $c_PayPlus->mf_get_res_data( "amount"    ); // KCP 실제 거래 금액
                $pnt_issue = $c_PayPlus->mf_get_res_data( "pnt_issue" ); // 결제 포인트사 코드
                $coupon_mny = $c_PayPlus->mf_get_res_data( "coupon_mny" ); // 쿠폰금액

                /* = -------------------------------------------------------------------------- = */
                /* =   05-1. 신용카드 승인 결과 처리                                            = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "100000000000" )
                {
                    $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // 카드사 코드
                    $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // 카드사 명
                    $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // 승인시간
                    $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // 승인번호
                    $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // 무이자 여부
                    $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // 할부 개월 수
                    $partcanc_yn = $c_PayPlus->mf_get_res_data( "partcanc_yn" ); // 부분취소 가능유무
                    $card_bin_type_01 = $c_PayPlus->mf_get_res_data( "card_bin_type_01" ); // 카드구분1
                    $card_bin_type_02 = $c_PayPlus->mf_get_res_data( "card_bin_type_02" ); // 카드구분2
                    $card_mny = $c_PayPlus->mf_get_res_data( "card_mny" ); // 카드결제금액

                    /* = -------------------------------------------------------------- = */
                    /* =   05-1.1. 복합결제(포인트+신용카드) 승인 결과 처리             = */
                    /* = -------------------------------------------------------------- = */
                    if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                    {
                        $pnt_amount   = $c_PayPlus->mf_get_res_data ( "pnt_amount"   ); // 적립금액 or 사용금액
                        $pnt_app_time = $c_PayPlus->mf_get_res_data ( "pnt_app_time" ); // 승인시간
                        $pnt_app_no   = $c_PayPlus->mf_get_res_data ( "pnt_app_no"   ); // 승인번호
                        $add_pnt      = $c_PayPlus->mf_get_res_data ( "add_pnt"      ); // 발생 포인트
                        $use_pnt      = $c_PayPlus->mf_get_res_data ( "use_pnt"      ); // 사용가능 포인트
                        $rsv_pnt      = $c_PayPlus->mf_get_res_data ( "rsv_pnt"      ); // 총 누적 포인트
                        $total_amount = $amount + $pnt_amount;                          // 복합결제시 총 거래금액
                    }
                }

                /* = -------------------------------------------------------------------------- = */
                /* =   05-2. 계좌이체 승인 결과 처리                                            = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "010000000000" )
                {
                    $app_time  = $c_PayPlus->mf_get_res_data( "app_time"   );  // 승인 시간
                    $bank_name = $c_PayPlus->mf_get_res_data( "bank_name"  );  // 은행명
                    $bank_code = $c_PayPlus->mf_get_res_data( "bank_code"  );  // 은행코드
                    $bk_mny    = $c_PayPlus->mf_get_res_data( "bk_mny"     );  // 계좌이체결제금액
                }

                /* = -------------------------------------------------------------------------- = */
                /* =   05-3. 가상계좌 승인 결과 처리                                            = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "001000000000" )
                {
                    $bankname  = $c_PayPlus->mf_get_res_data( "bankname"  ); // 입금할 은행 이름
                    $depositor = $c_PayPlus->mf_get_res_data( "depositor" ); // 입금할 계좌 예금주
                    $account   = $c_PayPlus->mf_get_res_data( "account"   ); // 입금할 계좌 번호
                    $va_date   = $c_PayPlus->mf_get_res_data( "va_date"   ); // 가상계좌 입금마감시간
                }

                /* = -------------------------------------------------------------------------- = */
                /* =   05-4. 포인트 승인 결과 처리                                              = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000100000000" )
                {
                    $pt_idno      = $c_PayPlus->mf_get_res_data( "pt_idno"      ); // 결제 및 인증 아이디
                    $pnt_amount   = $c_PayPlus->mf_get_res_data( "pnt_amount"   ); // 적립금액 or 사용금액
                    $pnt_app_time = $c_PayPlus->mf_get_res_data( "pnt_app_time" ); // 승인시간
                    $pnt_app_no   = $c_PayPlus->mf_get_res_data( "pnt_app_no"   ); // 승인번호
                    $add_pnt      = $c_PayPlus->mf_get_res_data( "add_pnt"      ); // 발생 포인트
                    $use_pnt      = $c_PayPlus->mf_get_res_data( "use_pnt"      ); // 사용가능 포인트
                    $rsv_pnt      = $c_PayPlus->mf_get_res_data( "rsv_pnt"      ); // 총 누적 포인트
                }

                /* = -------------------------------------------------------------------------- = */
                /* =   05-5. 휴대폰 승인 결과 처리                                              = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000010000000" )
                {
                    $app_time  = $c_PayPlus->mf_get_res_data( "hp_app_time"  ); // 승인 시간
                    $van_cd    = $c_PayPlus->mf_get_res_data( "van_cd"       ); // 결제 건의 결제 사 코드
                    $van_id    = $c_PayPlus->mf_get_res_data( "van_id"       ); // 결제 건의 실물/컨텐츠 구분
                    $commid    = $c_PayPlus->mf_get_res_data( "commid"       ); // 통신사 코드
                    $mobile_no = $c_PayPlus->mf_get_res_data( "mobile_no"    ); // 휴대폰 번호
                }

                /* = -------------------------------------------------------------------------- = */
                /* =   05-6. 상품권 승인 결과 처리                                              = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000000001000" )
                {
                    $app_time    = $c_PayPlus->mf_get_res_data( "tk_app_time"  ); // 승인 시간
                    $tk_van_code = $c_PayPlus->mf_get_res_data( "tk_van_code"  ); // 발급사 코드
                    $tk_app_no   = $c_PayPlus->mf_get_res_data( "tk_app_no"    ); // 승인 번호
                }

                /* = -------------------------------------------------------------------------- = */
                /* =   05-7. 현금영수증 결과 처리                                               = */
                /* = -------------------------------------------------------------------------- = */
                $cash_authno  = $c_PayPlus->mf_get_res_data( "cash_authno"  ); // 현금 영수증 승인 번호
                $cash_no      = $c_PayPlus->mf_get_res_data( "cash_no"      ); // 현금 영수증 거래 번호
            }
            /* = -------------------------------------------------------------------------- = */
            /* =   05-8. 에스크로 여부 결과 처리                                            = */
            /* = -------------------------------------------------------------------------- = */
            $escw_yn = $c_PayPlus->mf_get_res_data( "escw_yn"  ); // 에스크로 여부
        }

        /* = -------------------------------------------------------------------------- = */
        /* =   05. 승인 결과 처리 END                                                   = */
        /* ============================================================================== */

        /* ============================================================================== */
        /* =   06. 승인 및 실패 결과 DB처리                                             = */
        /* = -------------------------------------------------------------------------- = */
        /* =       결과를 업체 자체적으로 DB처리 작업하시는 부분입니다.                 = */
        /* = -------------------------------------------------------------------------- = */

        if ( $req_tx == "pay" )
        {

            /* = -------------------------------------------------------------------------- = */
            /* =   06-1. 승인 결과 DB 처리(res_cd == "0000")                                = */
            /* = -------------------------------------------------------------------------- = */
            /* =        각 결제수단을 구분하시어 DB 처리를 하시기 바랍니다.                 = */
            /* = -------------------------------------------------------------------------- = */
            if( $res_cd == "0000" )
            {
                // 06-1-1. 신용카드
                if ( $use_pay_method == "100000000000" )
                {
                    // 06-1-1-1. 복합결제(신용카드 + 포인트)
                    if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                    {
                    }
                }
                // 06-1-2. 계좌이체
                if ( $use_pay_method == "010000000000" )
                {
                }
                // 06-1-3. 가상계좌
                if ( $use_pay_method == "001000000000" )
                {
                }
                // 06-1-4. 포인트
                if ( $use_pay_method == "000100000000" )
                {
                }
                // 06-1-5. 휴대폰
                if ( $use_pay_method == "000010000000" )
                {
                }
                // 06-1-6. 상품권
                if ( $use_pay_method == "000000001000" )
                {
                }
            }
            /* = -------------------------------------------------------------------------- = */
            /* =   06.-2 승인 및 실패 결과 DB처리                                             = */
            /* ============================================================================== */
            else if ( $req_cd != "0000" )
            {
            }
        }
        /* = -------------------------------------------------------------------------- = */
        /* =   06. 승인 및 실패 결과 DB 처리 END                                        = */
        /* = ========================================================================== = */


        /* = ========================================================================== = */
        /* =   07. 승인 결과 DB 처리 실패시 : 자동취소                                  = */
        /* = -------------------------------------------------------------------------- = */
        /* =      승인 결과를 DB 작업 하는 과정에서 정상적으로 승인된 건에 대해         = */
        /* =      DB 작업을 실패하여 DB update 가 완료되지 않은 경우, 자동으로          = */
        /* =      승인 취소 요청을 하는 프로세스가 구성되어 있습니다.                   = */
        /* =                                                                            = */
        /* =      DB 작업이 실패 한 경우, bSucc 라는 변수(String)의 값을 "false"        = */
        /* =      로 설정해 주시기 바랍니다. (DB 작업 성공의 경우에는 "false" 이외의    = */
        /* =      값을 설정하시면 됩니다.)                                              = */
        /* = -------------------------------------------------------------------------- = */

        // 승인 결과 DB 처리 에러시 bSucc값을 false로 설정하여 거래건을 취소 요청
        $bSucc = "";

        if ( $req_tx == "pay" )
        {
            if( $res_cd == "0000" )
            {
                if ( $bSucc == "false" )
                {
                    $c_PayPlus->mf_clear();

                    $tran_cd = "00200000";

                    /* ============================================================================== */
                    /* =   07-1.자동취소시 에스크로 거래인 경우                                     = */
                    /* = -------------------------------------------------------------------------- = */
                    // 취소시 사용하는 mod_type
                    $bSucc_mod_type = "";

                    // 에스크로 가상계좌 건의 경우 가상계좌 발급취소(STE5)
                    if ( $escw_yn == "Y" && $use_pay_method == "001000000000" )
                    {
                        $bSucc_mod_type = "STE5";
                    }
                    // 에스크로 가상계좌 이외 건은 즉시취소(STE2)
                    else if ( $escw_yn == "Y" )
                    {
                        $bSucc_mod_type = "STE2";
                    }
                    // 에스크로 거래 건이 아닌 경우(일반건)(STSC)
                    else
                    {
                        $bSucc_mod_type = "STSC";
                    }
                    /* = -------------------------------------------------------------------------- = */
                    /* =   07-1. 자동취소시 에스크로 거래인 경우 처리 END                           = */
                    /* = ========================================================================== = */

                    $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                    $c_PayPlus->mf_set_modx_data( "mod_type", $bSucc_mod_type              );  // 원거래 변경 요청 종류
                    $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                    $c_PayPlus->mf_set_modx_data( "mod_desc", "가맹점 결과 처리 오류 - 가맹점에서 취소 요청" );  // 변경 사유

                    $c_PayPlus->mf_do_tx( "", $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "",
                        $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                        $cust_ip, "3", 0, 0, $g_conf_log_path); // 응답 전문 처리

                    $res_cd  = $c_PayPlus->m_res_cd;
                    $res_msg = $c_PayPlus->m_res_msg;
                }
            }
        }
        // End of [res_cd = "0000"]
        /* = -------------------------------------------------------------------------- = */
        /* =   07. 승인 결과 DB 처리 END                                                = */
        /* = ========================================================================== = */

        $kcp_msg			= iconv("EUC-KR", "UTF-8",$res_msg);
        $kcp_cardname		= iconv("EUC-KR", "UTF-8",$card_name);
        $kcp_bankname		= iconv("EUC-KR", "UTF-8",$bank_name);
        $kcp_vbankname		= iconv("EUC-KR", "UTF-8",$bankname);
        $kcp_vdepositor		= iconv("EUC-KR", "UTF-8",$depositor);
        $kcp_card_cd		= iconv("EUC-KR", "UTF-8",$card_cd);
        $kcp_van_cd		    = iconv("EUC-KR", "UTF-8",$van_cd);
        $kcp_van_id		    = iconv("EUC-KR", "UTF-8",$van_id);
        $kcp_commid		    = iconv("EUC-KR", "UTF-8",$commid);

        //kcp 결제 정보 저장
        $kcp_param						= [];
        $kcp_param['SEQ']				= $ordr_idxx;
        $kcp_param['RES_CD']			= $res_cd;
        $kcp_param['RES_MSG']			= $kcp_msg;
        $kcp_param['TNO']				= $tno;
        $kcp_param['AMOUNT']			= $amount;
        $kcp_param['ESCW_YN']			= $pay_mod;
        $kcp_param['CARD_CD']			= $kcp_card_cd;
        $kcp_param['CARD_NAME']			= $kcp_cardname;
        $kcp_param['CARD_APP_TIME']		= $app_no;
        $kcp_param['CARD_NOINF']		= $app_time;
        $kcp_param['CARD_NOINF_TYPE']	= $noinf;
        $kcp_param['CARD_QUOTA']		= $quota;
        $kcp_param['CARD_MNY']			= $card_mny;
        $kcp_param['CARD_COUPON_MNY']	= $coupon_mny;
        $kcp_param['CARD_PARTCANC_YN']	= $partcanc_yn;
        $kcp_param['CARD_BIN_TYPE_01']	= $card_bin_type_01;
        $kcp_param['CARD_BIN_TYPE_02']	= $card_bin_type_02;
        $kcp_param['BANK_CODE']			= $bank_code;
        $kcp_param['BANK_NAME']			= $kcp_bankname;
        $kcp_param['BANK_APP_TIME']		= $app_time;
        $kcp_param['BANK_BK_MNY']		= $bk_mny;
        $kcp_param['BANK_CASH_AUTHNO']	= $cash_authno;
        $kcp_param['BANK_CASH_NO']		= $cash_no;
        $kcp_param['VCNT_BANKNAME']		= $kcp_vbankname;
        $kcp_param['VCNT_BANKCODE']		= $kcp_vdepositor;
        $kcp_param['VCNT_ACCOUNT']		= $account;
        $kcp_param['VCNT_VA_DATE']		= $va_date;
        $kcp_param['VCNT_APP_TIME']		= $app_time;
        $kcp_param['MOBX_COMMID']       = $kcp_commid;
        $kcp_param['MOBX_MOBILE_NO']    = $mobile_no;
        $kcp_param['MOBX_VAN_CD']       = $kcp_van_cd;
        $kcp_param['MOBX_VAN_ID']       = $kcp_van_id;

        $this->order_m->saveKCPLOG($kcp_param);

        log_message("DEBUG", "kcpPayResult :".$tno."(".$res_cd.")==============================================");

        $this->response(array('res_cd' => $res_cd, 'message' => $kcp_msg, 'tno' => $tno
        , 'card_name' => $kcp_cardname, 'card_quota' => $quota
        , 'vbank_name' => $kcp_vbankname, 'vbank_num' => $account
        , 'vbank_date' => $va_date, 'tel_code' => $kcp_commid,'mob_no' => $mobile_no, 'pg_tid' => $ordr_idxx, 'kcp_log_data' => $kcp_log_data
        ), 200);

    }

    /**
     * kcp 가상계좌 결제 알림
     */
    public function kcpBankNoti_post()
    {
        $result = '9999';
        log_message('DEBUG', "kcpBankNoti post START==================================== ");

//         setlocale(LC_CTYPE, 'ko_KR.euc-kr');

        $param = $this->input->post();
//         setlocale(LC_CTYPE, 'ko_KR.euc-kr');

//         log_message("DEBUG", "=======setlocale======================================================param=====".json_encode($param));

        $kakao = array();
        //$arr = array("210.122.73.58", "203.238.36.173", "203.238.36.178");
        //$ipAddr = $this->input->ip_address();

        $ipAddr = $_SERVER['REMOTE_ADDR'];

        /*	접속 ip 체크 : 210.122.73.58 , 203.238.36.173, 203.238.36.178 에서 온 요청만 처리함!
            param { tno : kcp 결제고유번호, order_no : 주문생성시 생성한 주문번호(ETAH201712123344..), site_cd:가맹점코드, tx_cd: TX00(가상계좌 입금 통보) ,
                ipgm_mnyx : 입금자가 실제 입금한 입금 금액 }
        */

        //log_message('DEBUG' , "kcpBankNoti_post , ipAddr = ".$ipAddr);

        //if(in_array($ipAddr ,$arr)){
        //if($ipAddr == "210.122.73.58" || $ipAddr == "203.238.36.173" || $ipAddr == "203.238.36.178"){
        //결제통보내역 로그 저장
        $this->order_m->kcp_noti_info_log($param['tno'], $param['order_no'], $param['tx_cd'], $param['ipgm_mnyx']);

        //tx_cd = TX00(가상계좌 입금 통보) 인 경우
        if ($param['tx_cd'] == 'TX00') {

            $OrderInfo = $this->order_m->get_pay_N_order_info_kcp($param['tno'], $param['order_no']);    //결제번호, 주문상세번호 가져오기
            if (isset($OrderInfo)) {

                if ($OrderInfo[0]['ORDER_REFER_PROC_STS_CD'] == 'OA02'){
                    $paydata = $this->order_m->get_OrderPayinfo($OrderInfo[0]['ORDER_PAY_DTL_NO']);
                    $Goods_info = $this->order_m->get_Orderinfo($OrderInfo[0]['ORDER_NO']);
                    $pay_sum = $paydata['PAY_AMT'];
                    $Gcount = count($OrderInfo);
                    if($Gcount > 1){
                        $num = $Gcount - 1;
                        $goods_str = $Goods_info['GOODS_NM']." 외 ".$num."개";
                    }else{
                        $goods_str = $Goods_info['GOODS_NM'];
                    }
                    $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
                    $kakao['MSG'] = "[에타홈] 주문완료
 
주문이 완료 되었습니다.
배송이 시작되면 
다시 안내드릴게요.^^

▶주문번호: ".$OrderInfo[0]['ORDER_NO']."
▶상품명: ".$goods_str."
▶주문금액: ".number_format($pay_sum)."원
* 주문금액은 쿠폰할인 및 
즉시 할인금액이 반영 되지 않은 상품 금액 입니다.

 ※ 발송 예정일은 
상품 재고 현황에 따라 
변경 될 수 있습니다.

※ 가구 등 설치가 필요하거나 
화물로 배송되는 상품의 경우
업체에서 연락드려 
배송일 협의가 진행됩니다.

※ 해외직구 상품의 배송기간은 
최대 1달 걸리니 상세페이지나 
고객센터(1522-5572)를 통해 
예정일을 확인해주세요!";
                    $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813560816788648361';
                    $kakao['KAKAO_SENDER_KEY'   ] = '1682e1e3f3186879142950762915a4109f2d04a2';
                    if($Goods_info['SENDER_MOB_NO'] != '' || $Goods_info['SENDER_MOB_NO'] != null) {
                        $kakao['DEST_PHONE'] = str_replace('-', '', $Goods_info['SENDER_MOB_NO']);
                    }else{
                        $kakao['DEST_PHONE'] = str_replace('-', '', $Goods_info['RECEIVER_MOB_NO']);
                    }
                    $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';

                    if($Goods_info['SENDER_NM']) {
                        $this->order_m->send_sms_kakao($kakao);
                    }
                    //링크프라이스 주문건일시 실적전송.
                    if($OrderInfo[0]['LPRICE_NO'] != null || $OrderInfo[0]['LPRICE_NO'] != ''){
                        self::lprice($OrderInfo[0]['ORDER_NO']);
                    }
                }

                foreach ($OrderInfo as $OrderRow) {
                    if ($OrderRow['ORDER_REFER_PROC_STS_CD'] == 'OA02') {    //결제중(미입금)상태일때만 업데이트

                        $upd_paydtl_state = $this->order_m->upd_order_pay_dtl_vbank_state_kcp($OrderRow['ORDER_PAY_DTL_NO']);    //결제상세 상태 업데이트
                        $upd_pay_state = $this->order_m->upd_order_pay_state($OrderRow['PAY_NO']);        //결제 상태 업데이트
                        $order_refer_progress_no = $this->order_m->set_order_refer_progress($OrderRow['ORDER_REFER_NO'], 'OA03'); //주문상태로그생성
                        $upd_order_refer_state = $this->order_m->upd_order_refer_state($OrderRow['ORDER_REFER_NO'], $order_refer_progress_no);    //주문상태 업데이트
                        $result = '0000';
                    }
                }
            }
        }
        //}

        log_message('DEBUG', "kcpBankNoti post result : ".$result."==================================== ");
        log_message('DEBUG', "kcpBankNoti post END==================================== ");
//        return $this->response(array('result' => $result));
        echo '<html><body><form><input type="hidden" name="result" value="'.$result.'"></form></body></html>';
    }

    /**
     * kcp ARS 결제 알림
     */
    public function kcpArsNoti_post()
    {
        $noti = $this->input->post();

        log_message("DEBUG", "=======================".json_encode($noti));

        $param['site_cd'    ] = $_POST['site_cd'    ];
        $param['tno'        ] = $_POST['tno'        ];
        $param['order_no'   ] = $_POST['order_no'   ];
        $param['tx_cd'      ] = $_POST['tx_cd'      ];
        $param['tx_tm'      ] = $_POST['tx_tm'      ];
        $param['res_cd'     ] = $_POST['res_cd'     ];
        $param['phon_mny'   ] = $_POST['phon_mny'   ];
        $param['phon_no'    ] = $_POST['phon_no'    ];
        $param['order_nm'   ] = $_POST['order_nm'   ];
        $param['card_no'    ] = $_POST['card_no'    ];
        $param['card_cd'    ] = $_POST['card_cd'    ];
        $param['acqu_cd'    ] = $_POST['acqu_cd'    ];
        $param['app_no'     ] = $_POST['app_no'     ];
        $param['bizx_numb'  ] = $_POST['bizx_numb'  ];
        $param['noinf'      ] = $_POST['noinf'      ];
        $param['card_quota' ] = $_POST['card_quota' ];

        //ARS 결제 결과메시지 설정
        if($param['res_cd'] == '0000') {
            $param['res_mesg'] = '정상처리';
        } else {
            $param['res_mesg'] = '';
        }

        //ARS 결제 매입사 이름 설정
        switch($param['acqu_cd']) {
            case 'CCKM' :
                $param['acqu_name'] = 'KB국민카드';
                break;
            case 'CCNH' :
                $param['acqu_name'] = 'NH농협카드';
                break;
            case 'CCBC' :
                $param['acqu_name'] = 'BC카드';
                break;
            case 'CCKE' :
                $param['acqu_name'] = '외환카드';
                break;
            case 'CCAM' :
                $param['acqu_name'] = '롯데아멕스카드';
                break;
            case 'CCHN' :
                $param['acqu_name'] = '하나SK카드';
                break;
            case 'CCSS' :
                $param['acqu_name'] = '삼성카드';
                break;
            case 'CCLG' :
                $param['acqu_name'] = '신한카드';
                break;
            case 'CCKE' :
                $param['acqu_name'] = '외환카드';
                break;
            case 'CCDI' :
                $param['acqu_name'] = '현대카드';
                break;
            default :
                $param['acqu_name'] = '';
                break;
        }

        $kakao = array();

        //결제통보내역 로그 저장
        $param['amount'    ] = $this->order_m->get_VarsKcpLog($param);
        $this->order_m->saveVarsKCPLOG($param);

        //tx_cd = TX09(ARS 결제 통보) 인 경우
        if($param['tx_cd'] == 'TX09'){

            $OrderInfo = $this->order_m->get_pay_N_order_info_kcp_ars($param['order_no']);	//결제번호, 주문상세번호 가져오기
            if(isset($OrderInfo)){

                if ($OrderInfo[0]['ORDER_REFER_PROC_STS_CD'] == 'OA02'){
                    $paydata = $this->order_m->get_OrderPayinfo($OrderInfo[0]['ORDER_PAY_DTL_NO']);
                    $Goods_info = $this->order_m->get_Orderinfo($OrderInfo[0]['ORDER_NO']);
                    $pay_sum = $paydata['PAY_AMT'];
                    $Gcount = count($OrderInfo);
                    if($Gcount > 1){
                        $num = $Gcount - 1;
                        $goods_str = $Goods_info['GOODS_NM']." 외 ".$num."개";
                    }else{
                        $goods_str = $Goods_info['GOODS_NM'];
                    }
                    $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
                    $kakao['MSG'] = "[에타홈] 주문완료
 
주문이 완료 되었습니다.
배송이 시작되면 
다시 안내드릴게요.^^

▶주문번호: ".$OrderInfo[0]['ORDER_NO']."
▶상품명: ".$goods_str."
▶주문금액: ".number_format($pay_sum)."원
* 주문금액은 쿠폰할인 및 
즉시 할인금액이 반영 되지 않은 상품 금액 입니다.

 ※ 발송 예정일은 
상품 재고 현황에 따라 
변경 될 수 있습니다.

※ 가구 등 설치가 필요하거나 
화물로 배송되는 상품의 경우
업체에서 연락드려 
배송일 협의가 진행됩니다.

※ 해외직구 상품의 배송기간은 
최대 1달 걸리니 상세페이지나 
고객센터(1522-5572)를 통해 
예정일을 확인해주세요!";
                    $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813560816788648361';
                    $kakao['KAKAO_SENDER_KEY'   ] = '1682e1e3f3186879142950762915a4109f2d04a2';
                    if($Goods_info['SENDER_MOB_NO'] != '' || $Goods_info['SENDER_MOB_NO'] != null) {
                        $kakao['DEST_PHONE'] = str_replace('-', '', $Goods_info['SENDER_MOB_NO']);
                    }else{
                        $kakao['DEST_PHONE'] = str_replace('-', '', $Goods_info['RECEIVER_MOB_NO']);
                    }
                    $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';

                    if($Goods_info['SENDER_NM']) {
                        $this->order_m->send_sms_kakao($kakao);
                    }
                }

                foreach ($OrderInfo as $OrderRow){
                    if($OrderRow['ORDER_REFER_PROC_STS_CD'] == 'OA02'){	//결제중(미입금)상태일때만 업데이트

                        $upd_paydtl_state			= $this->order_m->upd_order_pay_dtl_vars2($OrderRow['ORDER_PAY_DTL_NO'], $param);	//결제상세 상태 업데이트
                        $upd_pay_state				= $this->order_m->upd_order_pay_state($OrderRow['PAY_NO']);		//결제 상태 업데이트
                        $order_refer_progress_no	= $this->order_m->set_order_refer_progress($OrderRow['ORDER_REFER_NO'], 'OA03'); //주문상태로그생성
                        $upd_order_refer_state		= $this->order_m->upd_order_refer_state($OrderRow['ORDER_REFER_NO'], $order_refer_progress_no);	//주문상태 업데이트
                        $result = '0000';
                    }
                }
            }
        }
        //}
//        return $this->response(array('result' => $result));
        echo '<html><body><form><input type="hidden" name="result" value="'.$result.'"></form></body></html>';
    }


    /**
     * kcp 가상계좌 결제 알림
     */
    public function kcpBankNoti_get(){

//         setlocale(LC_CTYPE, 'ko_KR.euc-kr');

        $result = '9999';
        log_message('DEBUG' , "kcpBankNoti get START==================================== ");

        $param = $this->input->get();
        $kakao = array();
//         log_message('DEBUG' , "kcpBankNoti1 post==================================== ".$param['tno']);
//         log_message('DEBUG' , "kcpBankNoti2 post==================================== ".$param['order_no']);
//         log_message('DEBUG' , "kcpBankNoti3 post==================================== ".$param['tx_cd']);
//         log_message('DEBUG' , "kcpBankNoti4 post==================================== ".$param['ipgm_mnyx']);
        //$arr = array("210.122.73.58", "203.238.36.173", "203.238.36.178");
        //$ipAddr = $this->input->ip_address();

        $ipAddr = $_SERVER['REMOTE_ADDR'];

        /*	접속 ip 체크 : 210.122.73.58 , 203.238.36.173, 203.238.36.178 에서 온 요청만 처리함!
            param { tno : kcp 결제고유번호, order_no : 주문생성시 생성한 주문번호(ETAH201712123344..), site_cd:가맹점코드, tx_cd: TX00(가상계좌 입금 통보) ,
                ipgm_mnyx : 입금자가 실제 입금한 입금 금액 }
        */

        //log_message('DEBUG' , "kcpBankNoti_post , ipAddr = ".$ipAddr);

        //if(in_array($ipAddr ,$arr)){
        //if($ipAddr == "210.122.73.58" || $ipAddr == "203.238.36.173" || $ipAddr == "203.238.36.178"){

        //tx_cd = TX00(가상계좌 입금 통보) 인 경우
        if($param['tx_cd'] == 'TX00'){
            //결제통보내역 로그 저장
            $this->order_m->kcp_noti_info_log($param['tno'], $param['order_no'], $param['tx_cd'], $param['ipgm_mnyx']);

            $OrderInfo = $this->order_m->get_pay_N_order_info_kcp($param['tno'], $param['order_no']);	//결제번호, 주문상세번호 가져오기
            if(isset($OrderInfo)){

                if ($OrderInfo[0]['ORDER_REFER_PROC_STS_CD'] == 'OA02'){
                    $paydata = $this->order_m->get_OrderPayinfo($OrderInfo[0]['ORDER_PAY_DTL_NO']);
                    $Goods_info = $this->order_m->get_Orderinfo($OrderInfo[0]['ORDER_NO']);
                    $pay_sum = $paydata['PAY_AMT'];
                    $Gcount = count($OrderInfo);
                    if($Gcount > 1){
                        $num = $Gcount - 1;
                        $goods_str = $Goods_info['GOODS_NM']." 외 ".$num."개";
                    }else{
                        $goods_str = $Goods_info['GOODS_NM'];
                    }
                    $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
                    $kakao['MSG'] = "[에타홈] 주문완료
 
주문이 완료 되었습니다.
배송이 시작되면 
다시 안내드릴게요.^^

▶주문번호: ".$OrderInfo[0]['ORDER_NO']."
▶상품명: ".$goods_str."
▶주문금액: ".number_format($pay_sum)."원
* 주문금액은 쿠폰할인 및 
즉시 할인금액이 반영 되지 않은 상품 금액 입니다.

 ※ 발송 예정일은 
상품 재고 현황에 따라 
변경 될 수 있습니다.

※ 가구 등 설치가 필요하거나 
화물로 배송되는 상품의 경우
업체에서 연락드려 
배송일 협의가 진행됩니다.

※ 해외직구 상품의 배송기간은 
최대 1달 걸리니 상세페이지나 
고객센터(1522-5572)를 통해 
예정일을 확인해주세요!";
                    $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813560816788648361';
                    $kakao['KAKAO_SENDER_KEY'   ] = '1682e1e3f3186879142950762915a4109f2d04a2';
                    if($Goods_info['SENDER_MOB_NO'] != '' || $Goods_info['SENDER_MOB_NO'] != null) {
                        $kakao['DEST_PHONE'] = str_replace('-', '', $Goods_info['SENDER_MOB_NO']);
                    }else{
                        $kakao['DEST_PHONE'] = str_replace('-', '', $Goods_info['RECEIVER_MOB_NO']);
                    }
                    $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';

                    if($Goods_info['SENDER_NM']) {
                        $this->order_m->send_sms_kakao($kakao);
                    }

                    //링크프라이스 주문건일시 실적전송.
                    if($OrderInfo[0]['LPRICE_NO'] != null || $OrderInfo[0]['LPRICE_NO'] != ''){
                        self::lprice($OrderInfo[0]['ORDER_NO']);
                    }
                }

                foreach ($OrderInfo as $OrderRow){
                    if($OrderRow['ORDER_REFER_PROC_STS_CD'] == 'OA02'){	//결제중(미입금)상태일때만 업데이트

                        $upd_paydtl_state			= $this->order_m->upd_order_pay_dtl_vbank_state_kcp($OrderRow['ORDER_PAY_DTL_NO']);	//결제상세 상태 업데이트
                        $upd_pay_state				= $this->order_m->upd_order_pay_state($OrderRow['PAY_NO']);		//결제 상태 업데이트
                        $order_refer_progress_no	= $this->order_m->set_order_refer_progress($OrderRow['ORDER_REFER_NO'], 'OA03'); //주문상태로그생성
                        $upd_order_refer_state		= $this->order_m->upd_order_refer_state($OrderRow['ORDER_REFER_NO'], $order_refer_progress_no);	//주문상태 업데이트
                        $result = '0000';
                    }
                }
            }
        }

        log_message('DEBUG', "kcpBankNoti get result : ".$result."==================================== ");
        log_message('DEBUG', "kcpBankNoti get END==================================== ");
//        return $this->response(array('result' => $result));
        echo '<html><body><form><input type="hidden" name="result" value="'.$result.'"></form></body></html>';
//        echo '<html><body><form><input type="hidden" name="result" value="'.$result.'"></form></body></html>';
    }


    public function kcpBankNoti1_post(){
        $param = $this->input->post();

        $this->load->view('order/kcpBankNoti', array('param'=>$param));
    }

    /**
     * 주문정보 임시저장
     * @auth beom
     */
    public function process_temp_post()
    {
        $param = $this->input->post();

        $tempOrderInfo = array();
        //구매자 정보
        $tempOrderInfo['buyerid']                       = $param['buyerid'];
        $tempOrderInfo['buyercode']                     = $param['buyercode'];
        //배송지 정보
        $tempOrderInfo['order_name']                    = $param['order_name'];
        $tempOrderInfo['buyermobno']                    = $param['buyertel'];
        $tempOrderInfo['buyeremail']                    = $param['buyeremail'];
        $tempOrderInfo['buyerzipcode']                  = $param['buyerzipcode'];
        $tempOrderInfo['buyeraddr1']                    = $param['buyeraddr1'];
        $tempOrderInfo['buyeraddr2']                    = $param['buyeraddr2'];
        $tempOrderInfo['selRefundBank']                 = $param['selRefundBank'];
        $tempOrderInfo['txtRefundAccount']              = $param['txtRefundAccount'];
        $tempOrderInfo['txtRefundCust']                 = $param['txtRefundCust'];
        $tempOrderInfo['order_recipient']               = $param['order_recipient'];
        $tempOrderInfo['order_phone']                   = $param['order_phone'];
        $tempOrderInfo['order_mobile']                  = $param['order_mobile'];
        $tempOrderInfo['order_postnum']                 = $param['order_postnum'];
        $tempOrderInfo['order_addr1']                   = $param['order_addr1'];
        $tempOrderInfo['order_addr2']                   = $param['order_addr2'];
        $tempOrderInfo['shipping_floor']                = $param['shipping_floor'];
        $tempOrderInfo['shipping_step_width']           = $param['shipping_step_width'];
        $tempOrderInfo['shipping_elevator']             = $param['shipping_elevator'];
        $tempOrderInfo['order_request']                 = $param['order_request'];
        $tempOrderInfo['orderCustomsNum']               = $param['orderCustomsNum'];
        //배송비 정보

        $tempOrderInfo['group_deli_policy_no']          = json_encode($param['group_deli_policy_no'],true);
        $tempOrderInfo['group_delivery_price']          = json_encode($param['group_delivery_price'], true);
        $tempOrderInfo['group_add_delivery_price']      = json_encode($param['group_add_delivery_price'], true);
        //상품정보
        $tempOrderInfo['goods_code']                    = json_encode($param['goods_code'], true);
        $tempOrderInfo['goods_name']                    = json_encode($param['goods_name'], true);
        $tempOrderInfo['goods_option_code']             = json_encode($param['goods_option_code'], true);
        $tempOrderInfo['goods_option_name']             = json_encode($param['goods_option_name'], true);
        $tempOrderInfo['goods_option_add_price']        = json_encode($param['goods_option_add_price'], true);
        $tempOrderInfo['goods_cnt']                     = json_encode($param['goods_cnt'], true);
        $tempOrderInfo['goods_price_code']              = json_encode($param['goods_price_code'], true);
        $tempOrderInfo['goods_street_price']            = json_encode($param['goods_street_price'], true);
        $tempOrderInfo['goods_selling_price']           = json_encode($param['goods_selling_price'], true);
        $tempOrderInfo['goods_factory_price']           = json_encode($param['goods_factory_price'], true);
        $tempOrderInfo['goods_mileage_save_amt']        = json_encode($param['goods_mileage_save_amt'], true);
        $tempOrderInfo['goods_deli_policy_no']          = json_encode($param['goods_deli_policy_no'], true);

        //쿠폰정보
        $tempOrderInfo['goods_coupon_code_s']           = json_encode($param['goods_coupon_code_s'], true);
        $tempOrderInfo['goods_coupon_amt_s']            = json_encode($param['goods_coupon_amt_s'], true);
        $tempOrderInfo['goods_coupon_code_i']           = json_encode($param['goods_coupon_code_i'], true);
        $tempOrderInfo['goods_coupon_amt_i']            = json_encode($param['goods_coupon_amt_i'], true);
        $tempOrderInfo['goods_add_coupon_no']           = json_encode($param['goods_add_coupon_no'], true);
        $tempOrderInfo['goods_add_coupon_code']         = json_encode($param['goods_add_coupon_code'], true);
        $tempOrderInfo['goods_add_coupon_num']          = json_encode($param['goods_add_coupon_num'], true);
        $tempOrderInfo['goods_add_discount_price']      = json_encode($param['goods_add_discount_price'], true);


        //결제정보
        $tempOrderInfo['total_order_money']             = $param['total_order_money'];
        $tempOrderInfo['total_delivery_money']          = $param['total_delivery_money'];
        $tempOrderInfo['total_discount_money']          = $param['total_discount_money'];
        $tempOrderInfo['use_mileage']                   = $param['use_mileage'];
        $tempOrderInfo['order_payment_type']            = $param['order_payment_type'];

        $tempOrderInfo['cart_coupon_code']              = $param['cart_coupon_code'];
        $tempOrderInfo['cart_coupon_num']               = $param['cart_coupon_num'];
        $tempOrderInfo['cart_coupon_amt']               = $param['cart_coupon_amt'];

        $tempOrderInfo['escrowuse']                     = $param['escrowuse'];
        $tempOrderInfo['browser_info']                  = $param['browser_info'];

        $order_no	= $this->order_m->set_temp_order($tempOrderInfo);		// 임시주문  생성

        $this->response(array('status' => 'ok', 'order_no' => $order_no), 200);
    }

    /**
     * kcp 가상계좌 결제 알림
     */
    public function external_pay_post(){

        $param = $this->input->post();

        $dToday		= date("Y", time());
        $dmonth		= date("m", time());
        $ddate		= date("d", time());
        $dhour		= date("H", time());
        $dmin		= date("i", time());
        //$d_date = $dToday.$dtime;
        //$order_idxx = "ETAH" + $year + "" + $month + "" + $date + "" + $time;
        $order_idxx = "ETAH".$dToday."".$dmonth."".$ddate."".$dhour."".$dmin."000000000";
        $kcp_param						= [];
        $kcp_param['SEQ']				= $order_idxx;
        $kcp_param['RES_CD']			= '0000';
        $kcp_param['RES_MSG']			= '정상처리';
        $kcp_param['TNO']				= $dToday."".$dmonth."".$ddate."".$dhour."".$dmin."59";
        $kcp_param['AMOUNT']			= $param['total_order_money'];
        $kcp_param['ESCW_YN']			= 'N';
        $kcp_param['EXTERNAL_PAY']      = '외부결제';
        $kcp_param['EXTERNAL_PAY_NM']   = $param['external_paytype'];


        $this->order_m->saveExKCPLOG($kcp_param); // kcp 로그 저장.


        $date = date("Y-m-d H:i:s", time());

        //모델 LOAD
        $this->load->model('mywiz_m');
        $this->load->model('member_m');

        $param['order_payment_type'] = '06';
        $param['imp_uid'           ] = $kcp_param['TNO'];


        if($param['buyerid'] != 'GUEST'){
            $order_info			= $this->member_m->get_member_info_id($param['buyerid']);	//주문자 정보 가져오기
        } else {
            $order_info			= '';
        }

        $param['buyerzipcode'	] = isset($order_info['ZIPCODE']) ? $order_info['ZIPCODE'] : "";
        $param['buyeraddr1'		] = isset($order_info['ADDR1']) ? $order_info['ADDR1'] : "";
        $param['buyeraddr2'		] = isset($order_info['ADDR2']) ? $order_info['ADDR2'] : "";
        $param['buyermobno'		] = isset($order_info['MOB_NO']) ? $order_info['MOB_NO'] : "";
        $order_no			= $this->order_m->set_order($param, $date);		//주문 마스타 생성

        for($i=0; $i<count($param['group_deli_policy_no']); $i++){
            $group = array();
            $group['deli_policy_no'	] = $param['group_deli_policy_no'][$i];
            $group['deli_cost'		] = $param['group_delivery_price'][$i] + $param['group_add_delivery_price'][$i];

            $order_deliv_fee_no = $this->order_m->set_order_deli_fee($order_no, $group);		//주문 배송비 생성

            for($j=0; $j<count($param['goods_code']); $j++){
                if($param['goods_deli_policy_no'][$j] == $group['deli_policy_no']){
                    $param2 = array();
                    $param2['goods_code'			] = $param['goods_code'][$j];
                    $param2['goods_name'			] = $param['goods_name'][$j];
                    $param2['goods_option_code'		] = $param['goods_option_code'][$j];
                    $param2['goods_option_name'		] = $param['goods_option_name'][$j];
                    $param2['goods_option_add_price'] = $param['goods_option_add_price'][$j];
                    $param2['goods_cnt'				] = $param['goods_cnt'][$j];
                    $param2['goods_price'			] = $param['goods_price_code'][$j];
                    $param2['goods_street_price'	] = $param['goods_street_price'][$j];
                    $param2['goods_selling_price'	] = $param['goods_selling_price'][$j];
                    $param2['goods_factory_price'	] = $param['goods_factory_price'][$j];
                    $param2['total_price'			] = ($param['goods_selling_price'][$j]+$param['goods_option_add_price'][$j])*$param['goods_cnt'][$j];
                    $param2['goods_mileage_saving_amt'] = $param['goods_mileage_save_amt'][$j];		//적립예정마일리지

                    $order_refer_no = $this->order_m->set_order_refer($order_no, $order_deliv_fee_no, $param2);		//주문 상세 생성
                    $param['order_refer_no'][$j] = $order_refer_no;
                    $order_refer_progress_no	= $this->order_m->set_order_refer_progress($order_refer_no, 'OA01');	//주문 상태 생성
                    $update_order_refer_state	= $this->order_m->upd_order_refer_state($order_refer_no, $order_refer_progress_no);	//주문상태 업데이트
//					if($param['buyerid'] != 'GUEST' && $param['buyercode'] != ''){	//비회원이 아니라면
                    $update_user_cart_state		= $this->order_m->upd_cart_state($param2, $param['buyercode']);		//주문 상품 장바구니에 제거
//					}
                    $update_goods_option_cnt	= $this->order_m->upd_option_cnt($param2);		//주문 상품 재고 차감

                    if($param2['goods_mileage_saving_amt'] > 0 && $param['buyerid'] != 'GUEST'){	//적립할 마일리지 금액이 있다면 && 회원이라면
                        $param['CUST_NO'		] = $param['buyercode'];
                        $cust_mileage_info = $this->mywiz_m->get_mileage_info($param);
                        if($cust_mileage_info){
                            $param['org_mileage'	] = $cust_mileage_info['MILEAGE_AMT'];		//기존에 갖고 있던 마일리지
                            $param['pay_mileage_amt'] = $cust_mileage_info['PAY_MILEAGE_AMT'];	//기존에 사용한 마일리지 총합계
                        } else {
                            $param['org_mileage'		] = 0;
                            $param['pay_mileage_amt'	] = 0;
                        }
                        $param['goods_mileage_saving_amt'] = $param2['goods_mileage_saving_amt'];

                        $cust_mileage_save = $this->order_m->set_cust_mileage_save($order_refer_no, $param, $date);
                        $upd_cust_save_mileage = $this->order_m->upd_cust_pay_mileage($param,'save');

                    }

                }	//END if

            }	//END for

        }	//END for

        $order_delivery = $this->order_m->set_order_delivery($order_no, $param);		//주문 배송지 정보

        $pay_no = $this->order_m->set_order_pay($order_no, $param, $date);

        $order_pay_dtl = $this->order_m->set_order_pay_dtl($pay_no, $param, $date);

        //$this->response(array('status' => 'ok', 'message' => $order_no), 200);
        if($param['order_payment_type'] == '06'){	//외부 결제
            $order_pay_dtl_card = $this->order_m->upd_order_pay_dtl_external($pay_no, $param);
            $upd_order_pay_state = $this->order_m->upd_order_pay_state($pay_no);	//결제완료일자 업데이트

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA03');	//주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        }

        if($param['use_mileage'] > 0 && $param['buyerid'] != 'GUEST'){	//마일리지를 사용했다면 && 회원이라면
            $order_pay_dtl_mileage_no = $this->order_m->set_order_pay_dtl_mileage($pay_no, $param, $date);
            $param['CUST_NO'] = $param['buyercode'];
            $cust_mileage_info = $this->mywiz_m->get_mileage_info($param);
//			$param['cust_mileage_no'] = $cust_mileage_info['CUST_MILEAGE_NO'];	//컬럼없어짐
            $param['org_mileage'] = $cust_mileage_info['MILEAGE_AMT'];		//기존에 갖고 있던 마일리지
            $param['pay_mileage_amt'] = $cust_mileage_info['PAY_MILEAGE_AMT'];	//기존에 사용한 마일리지 총합계

            $cust_mileage_pay = $this->order_m->set_cust_mileage_pay($order_pay_dtl_mileage_no, $param, $date);
            $upd_cust_pay_mileage = $this->order_m->upd_cust_pay_mileage($param,'pay');
        }

        for($i=0; $i<count($param['goods_coupon_code_s']); $i++){	//상품 셀러 쿠폰
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['goods_coupon_code_s'][$i];		//상품쿠폰코드
            $param2['goods_coupon_num'			] = "";			//상품쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_coupon_amt_s'][$i]*$param['goods_cnt'][$i];		//상품쿠폰할인적용금액(갯수총합계)

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(상품쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
            }	//END if
        }	//END for

        for($i=0; $i<count($param['goods_coupon_code_i']); $i++){	//상품 아이템 쿠폰
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['goods_coupon_code_i'][$i];		//상품쿠폰코드
            $param2['goods_coupon_num'			] = "";			//상품쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_coupon_amt_i'][$i]*$param['goods_cnt'][$i];		//상품쿠폰할인적용금액(갯수총합계)

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(상품쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
            }	//END if
        }	//END for

        for($i=0; $i<count($param['goods_add_coupon_code']); $i++){	//상품 추가 쿠폰
            $param2 = array();
            $param2['goods_coupon_no'			] = $param['goods_add_coupon_no'][$i];
            $param2['goods_coupon_code'			] = $param['goods_add_coupon_code'][$i];	//추가쿠폰코드
            $param2['goods_coupon_num'			] = $param['goods_add_coupon_num'][$i];		//추가쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_add_discount_price'][$i];	//추가쿠폰할인적용금액
            $param2['cust_no'					] = $param['buyercode'];					//고객코드

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(중복쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
                if($param2['goods_coupon_num'] != ''){	//쿠폰번호가 있다면
                    $coupon_dtl_use	= $this->order_m->upd_coupon_dtl($param2, $date);		//쿠폰상세에 쿠폰 상태 변경
                }
                if($param['buyerid'] != 'GUEST'){	//비회원이 아닐경우
                    $cust_coupon_use = $this->order_m->upd_cust_coupon($param2, $order_no);	//사용쿠폰 상태 변경
                }
            }	//END if
        }	//END for

        if($param['cart_coupon_code'] != ""){	//고객쿠폰을 사용했다면 (함수사용안함)
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['cart_coupon_code'];			//고객쿠폰코드
            $param2['goods_coupon_num'			] = $param['cart_coupon_num' ];			//고객쿠폰번호
            $param2['goods_discount_price'		] = $param['cart_coupon_amt' ];			//고객쿠폰할인적용금액
            $param2['cust_no'					] = $param['buyercode'];				//고객코드

            $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(중복쿠폰)
            if($param2['goods_coupon_num'] != ''){	//쿠폰번호가 있다면
                $coupon_dtl_use	= $this->order_m->upd_coupon_dtl($param2, $date);		//쿠폰상세에 쿠폰 상태 변경
            }
            $cust_coupon_use = $this->order_m->upd_cust_coupon($param2, $order_no);	//사용쿠폰 상태 변경
        }
        self::process_temp2($param);

        $this->response(array('status' => 'ok', 'order_no' => $order_no), 200);
    }
    public function process_temp2($param)
    {

        $tempOrderInfo = array();
        //구매자 정보
        $tempOrderInfo['imp_uid']                       = $param['imp_uid'];
        $tempOrderInfo['buyerid']                       = $param['buyerid'];
        $tempOrderInfo['buyercode']                     = $param['buyercode'];
        //배송지 정보
        $tempOrderInfo['order_name']                    = $param['order_name'];
        $tempOrderInfo['buyermobno']                    = NULL;
        $tempOrderInfo['buyeremail']                    = $param['buyeremail'];
        $tempOrderInfo['buyerzipcode']                  = NULL;
        $tempOrderInfo['buyeraddr1']                    = NULL;
        $tempOrderInfo['buyeraddr2']                    = NULL;
        $tempOrderInfo['order_recipient']               = $param['order_recipient'];
        $tempOrderInfo['order_phone']                   = $param['order_phone'];
        $tempOrderInfo['order_mobile']                  = $param['buyertel'];
        $tempOrderInfo['order_postnum']                 = $param['order_postnum'];
        $tempOrderInfo['order_addr1']                   = $param['order_addr1'];
        $tempOrderInfo['order_addr2']                   = $param['order_addr2'];
        $tempOrderInfo['shipping_floor']                = $param['shipping_floor'];
        $tempOrderInfo['shipping_step_width']           = $param['shipping_step_width'];
        $tempOrderInfo['shipping_elevator']             = $param['shipping_elevator'];
        $tempOrderInfo['order_request']                 = $param['order_request'];
        $tempOrderInfo['orderCustomsNum']               = $param['orderCustomsNum'];
        //배송비 정보

        $tempOrderInfo['group_deli_policy_no']          = json_encode($param['group_deli_policy_no'],true);
        $tempOrderInfo['group_delivery_price']          = json_encode($param['group_delivery_price'], true);
        $tempOrderInfo['group_add_delivery_price']      = json_encode($param['group_add_delivery_price'], true);
        //상품정보
        $tempOrderInfo['goods_code']                    = json_encode($param['goods_code'], true);
        $tempOrderInfo['goods_name']                    = json_encode($param['goods_name'], true);
        $tempOrderInfo['goods_option_code']             = json_encode($param['goods_option_code'], true);
        $tempOrderInfo['goods_option_name']             = json_encode($param['goods_option_name'], true);
        $tempOrderInfo['goods_option_add_price']        = json_encode($param['goods_option_add_price'], true);
        $tempOrderInfo['goods_cnt']                     = json_encode($param['goods_cnt'], true);
        $tempOrderInfo['goods_price_code']              = json_encode($param['goods_price_code'], true);
        $tempOrderInfo['goods_street_price']            = json_encode($param['goods_street_price'], true);
        $tempOrderInfo['goods_selling_price']           = json_encode($param['goods_selling_price'], true);
        $tempOrderInfo['goods_factory_price']           = json_encode($param['goods_factory_price'], true);
        $tempOrderInfo['goods_mileage_save_amt']        = json_encode($param['goods_mileage_save_amt'], true);
        $tempOrderInfo['goods_deli_policy_no']          = json_encode($param['goods_deli_policy_no'], true);

        //쿠폰정보
        $tempOrderInfo['goods_coupon_code_s']           = json_encode($param['goods_coupon_code_s'], true);
        $tempOrderInfo['goods_coupon_amt_s']            = json_encode($param['goods_coupon_amt_s'], true);
        $tempOrderInfo['goods_coupon_code_i']           = json_encode($param['goods_coupon_code_i'], true);
        $tempOrderInfo['goods_coupon_amt_i']            = json_encode($param['goods_coupon_amt_i'], true);
        $tempOrderInfo['goods_add_coupon_no']           = json_encode($param['goods_add_coupon_no'], true);
        $tempOrderInfo['goods_add_coupon_code']         = json_encode($param['goods_add_coupon_code'], true);
        $tempOrderInfo['goods_add_coupon_num']          = json_encode($param['goods_add_coupon_num'], true);
        $tempOrderInfo['goods_add_discount_price']      = json_encode($param['goods_add_discount_price'], true);


        //결제정보
        $tempOrderInfo['total_order_money']             = $param['total_order_money'];
        $tempOrderInfo['total_delivery_money']          = $param['total_delivery_money'];
        $tempOrderInfo['total_discount_money']          = $param['total_discount_money'];
        $tempOrderInfo['use_mileage']                   = $param['use_mileage'];
        $tempOrderInfo['order_payment_type']            = $param['order_payment_type'];

        $tempOrderInfo['cart_coupon_code']              = $param['cart_coupon_code'];
        $tempOrderInfo['cart_coupon_num']               = $param['cart_coupon_num'];
        $tempOrderInfo['cart_coupon_amt']               = $param['cart_coupon_amt'];

        $tempOrderInfo['escrowuse']                     = $param['escrowuse'];
        $tempOrderInfo['browser_info']                  = $param['browser_info'];

        $this->order_m->set_temp_order2($tempOrderInfo);		// 임시주문  생성

    }

    /**
     * 링크 프라이스 실적 전송 - 무통장입금 입금되었을시 호출
     */
    public function lprice($param)
    {
        $send_data = array();
        $search_order_code = $param;    // order code from complete payment page

        $send_data = $this->order_m->get_lprice_order($search_order_code);

//data send
        if (!empty($send_data)) {
            define("LP_URL", "https://service.linkprice.com/lppurchase_cps_v3.php");
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'content' => json_encode($send_data),
                    'header' => "Content-type: application/json\r\n"
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents(LP_URL, false, $context);
        }
    }

    /**
     * 2018.12.12
     * Kakao Pay 추가
     *
     * @auth 박상현
     */

    /**
     * 카카오 페이 결제 준비
     */
    public function kakao_pay_get()
    {
        $param = $this->input->get();

        //기본값 세팅
        $cid = 'C908080116';    //가맹점 cid
        $qty = 0;               //상품수량
        $Cmsg = '';             //다중 상품이름
        $tax_goods_cd = '';     //과세, 면세 구분 상품코드
        $host = $_SERVER['HTTP_HOST']; //현재 호스트

        $order_info = $this->order_m->get_temp_order($param['temp_no']);

        $goods_count = count(json_decode($order_info['GOODS_CODE']));
        $goods_nm    = json_decode($order_info['GOODS_NAME'],true);
        $goods_gb    = json_decode($order_info['GOODS_CODE']);
        $goods_qty   = json_decode($order_info['GOODS_CNT' ]);

        for($i = 0; $i < count($goods_qty); $i++){
            $qty += (int)$goods_qty[$i]['GOODS_CNT'];
        }
        if($goods_count > 1){
            $cnt = $goods_count - 1;
            $Cmsg =  ' 외 '.$cnt.'건';
        }


        $total_amount = ($order_info['TOTAL_ORDER_MONEY'] + $order_info['TOTAL_DELIVERY_MONEY']) - ($order_info['TOTAL_DISCOUNT_MONEY'] + $order_info['USE_MILEAGE']);

        // 과세, 비과세, 부가세 금액 계산.
        // 과세액 = round(총결제금액 / 1.1)
        // 비과세 = 총결제금액 – 과세금액 – 부가가 치세
        // 부가가치세 = (총결제금액 – 과세금액) 상품총액의 10%

        for($i = 0; $i < count($goods_gb); $i++){
            $tax_goods_cd .= ",".$goods_gb[$i]['GOODS_CODE'];
        }
        $tax_goods_cd = substr($tax_goods_cd, 1);
        $tax_gb = $this->order_m->get_goodsTaxGb($tax_goods_cd);
        //과세
        $tmpTotalTaxableAmt = ceil($total_amount/1.1);
        //부가가치세
        $tmpTotalVatAmt = $total_amount - $tmpTotalTaxableAmt;
        //비과세
        $tmpTotalTaxFreeAmt = $total_amount - $tmpTotalTaxableAmt - $tmpTotalVatAmt;

        $tcnt = count($tax_gb);
        if($tcnt == 1 && $tax_gb[0]['TAX_GB_CD'] == '00'){
            //면세 상품만 샀을경우.
            $tmpTotalVatAmt = 0;
            $tmpTotalTaxFreeAmt = $total_amount;
        }

        $order_no        = $param['order_no'];
        $buyer_id        = $order_info['BUYER_ID'];
        $goods           = $goods_nm[0].$Cmsg;
        $quantity        = $qty;
        $vat_amount      = $tmpTotalVatAmt;
        $tax_free_amount = $tmpTotalTaxFreeAmt;
        $approval_url    = urlencode('https://'.$host.'/order/kakao_pay_finish?order_no='.$order_no.'&temp_no='.$param['temp_no']);
        $fail_url        = urlencode('https://'.$host.'/order/kakao_pay_fail?order_no='.$order_no);
        $cancel_url      = urlencode('https://'.$host.'/order/kakao_pay_cancel?order_no='.$order_no.'&temp_no='.$param['temp_no']);

        $post_data = 'cid='.$cid.
            '&partner_order_id='.$order_no.
            '&partner_user_id='.$buyer_id.
            '&item_name='.$goods.
            '&quantity='.$quantity.
            '&total_amount='.$total_amount.
            '&tax_free_amount='.$tax_free_amount.
            '&vat_amount='.$vat_amount.
            '&approval_url='.$approval_url.
            '&fail_url='.$fail_url.
            '&cancel_url='.$cancel_url;

        $url = "https://kapi.kakao.com/v1/payment/ready";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: KakaoAK 5417f3f0785547c4351b4ced11fa60c9'
        ,'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $result = json_decode($response,true);

        if($status_code == 200){
            $this->order_m->set_kakao_tid($result['tid'], $param['temp_no']);
            redirect($result['next_redirect_pc_url']);
        }else{
            $this->order_m->set_order_dismiss($order_no);
            echo ("<script language=javascript> alert('호출에 실패했습니다. 잠시후 다시 시도해주시길 바랍니다.');self.close();</script>");
        }
    }

    /**
     * 카카오 페이 결제 취소
     */
    public function kakao_pay_cancel_get()
    {
        $kakao_param = $this->input->get();
        $order_no = $kakao_param['order_no'];
        $pay_info = $this->order_m->get_temp_order($kakao_param['temp_no']);

        $cid = 'C908080116';
        $post_data = 'cid='.$cid.
            '&tid='.$pay_info['KCP_TNO'];

        $url = "https://kapi.kakao.com/v1/payment/order";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: KakaoAK 5417f3f0785547c4351b4ced11fa60c9'
        ,'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $result = json_decode($response,true);

        if($result['status'] == 'QUIT_PAYMENT') {
            $this->order_m->set_order_dismiss($order_no);
            echo("<script language=javascript> alert('사용자 취소');self.close();</script>");
        }
    }

    /**
     * 카카오 페이 결제 실패
     */
    public function kakao_pay_fail_get()
    {
        $kakao_param = $this->input->get();
        $this->order_m->set_order_dismiss($kakao_param['order_no']);
        echo("<script language=javascript> alert('결제 실패');self.close();</script>");
    }

    /**
     * 카카오 페이 결제 승인
     */
    public function kakao_pay_finish_get()
    {
        $kakao_param = $this->input->get();
        $pay_info = $this->order_m->get_temp_order($kakao_param['temp_no']);

        $cid = 'C908080116';
        $order_no = $kakao_param['order_no'];

        $post_data = 'cid='.$cid.
            '&tid='.$pay_info['KCP_TNO'].
            '&partner_order_id='.$kakao_param['order_no'].
            '&partner_user_id='.$pay_info['BUYER_ID'].
            '&pg_token='.$kakao_param['pg_token'];

        $url = "https://kapi.kakao.com/v1/payment/approve";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: KakaoAK 5417f3f0785547c4351b4ced11fa60c9'
        ,'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $result = json_decode($response,true);

        if($status_code == 200){
            //결제 완료.
            //KAKAO 로그생성과 에타 주문생성.
            $result['status'               ] = 'SUCCESS_PAYMENT';
            $result['order_no'             ] = $order_no;
            $result['code'                 ] = 200;
            $result['amount'               ] = json_encode($result['amount'], true);
            $result['approved_id'          ] = $result['card_info']['approved_id'          ];
            $result['bin'                  ] = $result['card_info']['bin'                  ];
            $result['card_mid'             ] = $result['card_info']['card_mid'             ];
            $result['card_type'            ] = $result['card_info']['card_type'            ];
            $result['install_month'        ] = $result['card_info']['install_month'        ];
            $result['purchase_corp'        ] = $result['card_info']['purchase_corp'        ];
            $result['purchase_corp_code'   ] = $result['card_info']['purchase_corp_code'   ];
            $result['issuer_corp'          ] = $result['card_info']['issuer_corp'          ];
            $result['issuer_corp_code'     ] = $result['card_info']['issuer_corp_code'     ];
            $result['interest_free_install'] = $result['card_info']['interest_free_install'];
            $result['card_item_code'       ] = $result['card_info']['card_item_code'       ];

            $this->order_m->saveKakaoLOG($result);       //결제 로그 생성.
            $this->process_kakao($pay_info,$kakao_param);//에타 주문 생성.

            echo ("<script language=javascript> 
                    var order_no = $order_no;
                    var url = window.opener.location.host;
                    window.opener.location.href = 'https://'+url+'/cart/Step3_Order_finish?order_no='+order_no;</script>"); // 결제 완료창 이동.
            echo ("<script language=javascript> self.close();</script>");
        }else{
            //결제 실패.
            $result['status'               ] = 'FAIL_PAYMENT';
            $result['order_no'             ] = $order_no;
            $result['method_result_code'   ] = $result['extras']['method_result_code'];
            $result['method_result_message'] = $result['extras']['method_result_message'];
            $this->order_m->saveKakaoLOG($result);
            $error_msg = $result['code'].'\n'.$result['method_result_message'];
            $this->order_m->set_order_dismiss($order_no);
            echo ("<script language=javascript> alert($error_msg);self.close();</script>");
        }
    }

    /**
     * 카카오 페이 주문생성
     */
    public function process_kakao($pay_info, $kakao_param)
    {
        $date = date("Y-m-d H:i:s", time());

        //모델 LOAD
        $this->load->model('mywiz_m');
        $this->load->model('member_m');

        $param = array();
        $param['buyerid'                 ]      = $pay_info['BUYER_ID'  ];
        $param['buyercode'               ]      = $pay_info['BUYER_CODE'];
        //배송지 정보
        $param['order_name'              ]      = $pay_info['ORDER_NAME'         ];
        $param['buyermobno'              ]      = $pay_info['BUYERMOBNO'         ];
        $param['buyeremail'              ]      = $pay_info['BUYEREMAIL'         ];
        $param['buyerzipcode'            ]      = $pay_info['BUYERZIPCODE'       ];
        $param['buyeraddr1'              ]      = $pay_info['BUYERADDR1'         ];
        $param['buyeraddr2'              ]      = $pay_info['BUYERADDR2'         ];
        $param['order_recipient'         ]      = $pay_info['ORDER_RECIPIENT'    ];
        $param['order_phone'             ]      = $pay_info['ORDER_PHONE'        ];
        $param['order_mobile'            ]      = $pay_info['ORDER_MOBILE'       ];
        $param['order_postnum'           ]      = $pay_info['ORDER_POSTNUM'      ];
        $param['order_addr1'             ]      = $pay_info['ORDER_ADDR1'        ];
        $param['order_addr2'             ]      = $pay_info['ORDER_ADDR2'        ];
        $param['shipping_floor'          ]      = $pay_info['SHIPPING_FLOOR'     ];
        $param['shipping_step_width'     ]      = $pay_info['SHIPPING_STEP_WIDTH'];
        $param['shipping_elevator'       ]      = $pay_info['SHIPPING_ELEVATOR'  ];
        $param['order_request'           ]      = $pay_info['ORDER_REQUEST'      ];
        $param['orderCustomsNum'         ]      = $pay_info['ORDERCUSTOMSNUM'    ];

        $param['group_deli_policy_no'    ]      = json_decode($pay_info['GROUP_DELI_POLICY_NO'    ], true);
        $param['group_delivery_price'    ]      = json_decode($pay_info['GROUP_DELIVERY_PRICE'    ], true);
        $param['group_add_delivery_price']      = json_decode($pay_info['GROUP_ADD_DELIVERY_PRICE'], true);
        //상품정보
        $param['goods_code'              ]      = json_decode($pay_info['GOODS_CODE'              ], true);
        $param['goods_name'              ]      = json_decode($pay_info['GOODS_NAME'              ], true);
        $param['goods_option_code'       ]      = json_decode($pay_info['GOODS_OPTION_CODE'       ], true);
        $param['goods_option_name'       ]      = json_decode($pay_info['GOODS_OPTION_NAME'       ], true);
        $param['goods_option_add_price'  ]      = json_decode($pay_info['GOODS_OPTION_ADD_PRICE'  ], true);
        $param['goods_cnt'               ]      = json_decode($pay_info['GOODS_CNT'               ], true);
        $param['goods_price_code'        ]      = json_decode($pay_info['GOODS_PRICE_CODE'        ], true);
        $param['goods_street_price'      ]      = json_decode($pay_info['GOODS_STREET_PRICE'      ], true);
        $param['goods_selling_price'     ]      = json_decode($pay_info['GOODS_SELLING_PRICE'     ], true);
        $param['goods_factory_price'     ]      = json_decode($pay_info['GOODS_FACTORY_PRICE'     ], true);
        $param['goods_mileage_save_amt'  ]      = json_decode($pay_info['GOODS_MILEAGE_SAVE_AMT'  ], true);
        $param['goods_deli_policy_no'    ]      = json_decode($pay_info['GOODS_DELI_POLICY_NO'    ], true);

        //쿠폰정보
        $param['goods_coupon_code_s'     ]      = json_decode($pay_info['GOODS_COUPON_CODE_S'     ], true);
        $param['goods_coupon_amt_s'      ]      = json_decode($pay_info['GOODS_COUPON_AMT_S'      ], true);
        $param['goods_coupon_code_i'     ]      = json_decode($pay_info['GOODS_COUPON_CODE_I'     ], true);
        $param['goods_coupon_amt_i'      ]      = json_decode($pay_info['GOODS_COUPON_AMT_I'      ], true);
        $param['goods_add_coupon_no'     ]      = json_decode($pay_info['GOODS_ADD_COUPON_NO'     ], true);
        $param['goods_add_coupon_code'   ]      = json_decode($pay_info['GOODS_ADD_COUPON_CODE'   ], true);
        $param['goods_add_coupon_num'    ]      = json_decode($pay_info['GOODS_ADD_COUPON_NUM'    ], true);
        $param['goods_add_discount_price']      = json_decode($pay_info['GOODS_ADD_DISCOUNT_PRICE'], true);


        //결제정보
        $param['total_order_money'       ]      = $pay_info['TOTAL_ORDER_MONEY'   ];
        $param['total_delivery_money'    ]      = $pay_info['TOTAL_DELIVERY_MONEY'];
        $param['total_discount_money'    ]      = $pay_info['TOTAL_DISCOUNT_MONEY'];
        $param['use_mileage'             ]      = $pay_info['USE_MILEAGE'         ];
        $param['order_payment_type'      ]      = $pay_info['ORDER_PAYMENT_TYPE'  ];

        $param['cart_coupon_code'        ]      = $pay_info['CART_COUPON_CODE'    ];
        $param['cart_coupon_num'         ]      = $pay_info['CART_COUPON_NUM'     ];
        $param['cart_coupon_amt'         ]      = $pay_info['CART_COUPON_AMT'     ];

        if($param['buyerid'] != 'GUEST'){
            $order_info			= $this->member_m->get_member_info_id($param['buyerid']);	//주문자 정보 가져오기
        } else {
            $order_info			= '';
        }

        $param['buyerzipcode'	] = isset($order_info['ZIPCODE']) ? $order_info['ZIPCODE'] : "";
        $param['buyeraddr1'		] = isset($order_info['ADDR1'  ]) ? $order_info['ADDR1'  ] : "";
        $param['buyeraddr2'		] = isset($order_info['ADDR2'  ]) ? $order_info['ADDR2'  ] : "";
        $param['buyermobno'		] = isset($order_info['MOB_NO' ]) ? $order_info['MOB_NO' ] : "";

        $order_no			= $kakao_param['order_no']; //주문 번호

        for($i=0; $i<count($param['group_deli_policy_no']); $i++){
            $group = array();
            $group['deli_policy_no'	] = $param['group_deli_policy_no'][$i];
            $group['deli_cost'		] = $param['group_delivery_price'][$i] + $param['group_add_delivery_price'][$i];

            $order_deliv_fee_no = $this->order_m->set_order_deli_fee($order_no, $group); //주문 배송비 생성

            for($j=0; $j<count($param['goods_code']); $j++){
                if($param['goods_deli_policy_no'][$j] == $group['deli_policy_no']){
                    $param2 = array();
                    $param2['goods_code'			] = $param['goods_code'            ][$j];
                    $param2['goods_name'			] = $param['goods_name'            ][$j];
                    $param2['goods_option_code'		] = $param['goods_option_code'     ][$j];
                    $param2['goods_option_name'		] = $param['goods_option_name'     ][$j];
                    $param2['goods_option_add_price'] = $param['goods_option_add_price'][$j];
                    $param2['goods_cnt'				] = $param['goods_cnt'             ][$j];
                    $param2['goods_price'			] = $param['goods_price_code'      ][$j];
                    $param2['goods_street_price'	] = $param['goods_street_price'    ][$j];
                    $param2['goods_selling_price'	] = $param['goods_selling_price'   ][$j];
                    $param2['goods_factory_price'	] = $param['goods_factory_price'   ][$j];
                    $param2['total_price'			] = ($param['goods_selling_price'  ][$j]+$param['goods_option_add_price'][$j])*$param['goods_cnt'][$j];
                    $param2['goods_mileage_saving_amt'] = $param['goods_mileage_save_amt'][$j]; //적립예정마일리지

                    $order_refer_no = $this->order_m->set_order_refer($order_no, $order_deliv_fee_no, $param2); //주문 상세 생성
                    $param['order_refer_no'][$j] = $order_refer_no;
                    $order_refer_progress_no	= $this->order_m->set_order_refer_progress($order_refer_no, 'OA01');	            //주문 상태 생성
                    $update_order_refer_state	= $this->order_m->upd_order_refer_state($order_refer_no, $order_refer_progress_no);	//주문상태 업데이트
                    $update_user_cart_state		= $this->order_m->upd_cart_state($param2, $param['buyercode']);		                //주문 상품 장바구니에 제거
                    $update_goods_option_cnt	= $this->order_m->upd_option_cnt($param2);		                                    //주문 상품 재고 차감

                    if($param2['goods_mileage_saving_amt'] > 0 && $param['buyerid'] != 'GUEST'){ //적립할 마일리지 금액이 있다면 && 회원이라면
                        $param['CUST_NO'		] = $param['buyercode'];
                        $cust_mileage_info = $this->mywiz_m->get_mileage_info($param);
                        if($cust_mileage_info){
                            $param['org_mileage'	] = $cust_mileage_info['MILEAGE_AMT'];		//기존에 갖고 있던 마일리지
                            $param['pay_mileage_amt'] = $cust_mileage_info['PAY_MILEAGE_AMT'];	//기존에 사용한 마일리지 총합계
                        } else {
                            $param['org_mileage'		] = 0;
                            $param['pay_mileage_amt'	] = 0;
                        }
                        $param['goods_mileage_saving_amt'] = $param2['goods_mileage_saving_amt'];
                        $cust_mileage_save     = $this->order_m->set_cust_mileage_save($order_refer_no, $param, $date);
                        $upd_cust_save_mileage = $this->order_m->upd_cust_pay_mileage($param,'save');
                    }
                }	//END if

            }	//END for

        }	//END for

        $order_delivery = $this->order_m->set_order_delivery($order_no, $param); //주문 배송지 정보
        $pay_no = $this->order_m->set_order_pay($order_no, $param, $date);
        $order_pay_dtl = $this->order_m->set_order_pay_dtl($pay_no, $param, $date);

        if($param['order_payment_type'] == '07'){ //카카오 페이
            $param['imp_uid'] = $pay_info['KCP_TNO'];
            $order_pay_dtl_card  = $this->order_m->upd_order_pay_dtl_kakao_pay($pay_no, $param);
            $upd_order_pay_state = $this->order_m->upd_order_pay_state($pay_no); //결제완료일자 업데이트

            for($i=0; $i<count($param['goods_code']); $i++){
                $order_refer_progress_no  = $this->order_m->set_order_refer_progress($param['order_refer_no'][$i], 'OA03');	                //주문 상태 생성
                $update_order_refer_state = $this->order_m->upd_order_refer_state($param['order_refer_no'][$i], $order_refer_progress_no);	//주문상태 업데이트
            }	//END for
        }

        if($param['use_mileage'] > 0 && $param['buyerid'] != 'GUEST'){ //마일리지를 사용했다면 && 회원이라면
            $order_pay_dtl_mileage_no = $this->order_m->set_order_pay_dtl_mileage($pay_no, $param, $date);
            $param['CUST_NO'] = $param['buyercode'];
            $cust_mileage_info = $this->mywiz_m->get_mileage_info($param);
            $param['org_mileage'] = $cust_mileage_info['MILEAGE_AMT'];		    //기존에 갖고 있던 마일리지
            $param['pay_mileage_amt'] = $cust_mileage_info['PAY_MILEAGE_AMT'];	//기존에 사용한 마일리지 총합계

            $cust_mileage_pay = $this->order_m->set_cust_mileage_pay($order_pay_dtl_mileage_no, $param, $date);
            $upd_cust_pay_mileage = $this->order_m->upd_cust_pay_mileage($param,'pay');
        }

        for($i=0; $i<count($param['goods_coupon_code_s']); $i++){ //상품 셀러 쿠폰
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['goods_coupon_code_s'][$i];		//상품쿠폰코드
            $param2['goods_coupon_num'			] = "";			                            //상품쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_coupon_amt_s'][$i]*$param['goods_cnt'][$i]; //상품쿠폰할인적용금액(갯수총합계)

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no      = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);                     //결제 할인 상세 생성(상품쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
            }	//END if
        }	//END for

        for($i=0; $i<count($param['goods_coupon_code_i']); $i++){ //상품 아이템 쿠폰
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['goods_coupon_code_i'][$i];		//상품쿠폰코드
            $param2['goods_coupon_num'			] = "";			                            //상품쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_coupon_amt_i'][$i]*$param['goods_cnt'][$i]; //상품쿠폰할인적용금액(갯수총합계)

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	                      //결제 할인 상세 생성(상품쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
            }	//END if
        }	//END for

        for($i=0; $i<count($param['goods_add_coupon_code']); $i++){	//상품 추가 쿠폰
            $param2 = array();
            $param2['goods_coupon_no'			] = $param['goods_add_coupon_no'][$i];
            $param2['goods_coupon_code'			] = $param['goods_add_coupon_code'][$i];	//추가쿠폰코드
            $param2['goods_coupon_num'			] = $param['goods_add_coupon_num'][$i];		//추가쿠폰번호
            $param2['goods_discount_price'		] = $param['goods_add_discount_price'][$i];	//추가쿠폰할인적용금액
            $param2['cust_no'					] = $param['buyercode'];					//고객코드

            if($param2['goods_coupon_code'] != ''){
                $pay_dc_no      = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	//결제 할인 상세 생성(중복쿠폰)
                $map_dc_n_order = $this->order_m->set_map_dc_n_order($pay_dc_no, $param['order_refer_no'][$i]);
                if($param2['goods_coupon_num'] != ''){	//쿠폰번호가 있다면
                    $coupon_dtl_use	= $this->order_m->upd_coupon_dtl($param2, $date);		//쿠폰상세에 쿠폰 상태 변경
                }
                if($param['buyerid'] != 'GUEST'){	//비회원이 아닐경우
                    $cust_coupon_use = $this->order_m->upd_cust_coupon($param2, $order_no);	//사용쿠폰 상태 변경
                }
            }	//END if
        }	//END for

        if($param['cart_coupon_code'] != ""){ //고객쿠폰을 사용했다면 (함수사용안함)
            $param2 = array();
            $param2['goods_coupon_code'			] = $param['cart_coupon_code'];			//고객쿠폰코드
            $param2['goods_coupon_num'			] = $param['cart_coupon_num' ];			//고객쿠폰번호
            $param2['goods_discount_price'		] = $param['cart_coupon_amt' ];			//고객쿠폰할인적용금액
            $param2['cust_no'					] = $param['buyercode'       ];	    	//고객코드

            $pay_dc_no = $this->order_m->set_order_pay_dc_dtl($pay_no, $param2);	    //결제 할인 상세 생성(중복쿠폰)
            if($param2['goods_coupon_num'] != ''){	//쿠폰번호가 있다면
                $coupon_dtl_use	= $this->order_m->upd_coupon_dtl($param2, $date);		//쿠폰상세에 쿠폰 상태 변경
            }
            $cust_coupon_use = $this->order_m->upd_cust_coupon($param2, $order_no);	    //사용쿠폰 상태 변경
        }

        //비구매회원 -> 구매회원으로 변경
        if($param['buyerid'] != 'GUEST') {    //비회원이 아닐경우
            $this->order_m->upd_cust_level($order_info['CUST_NO']);
        }

        if($param['buyermobno'] != ""){		//주문 완료 SMS 발송
            $kakao = array();
            $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
            $pay_sum = $param['total_order_money']+$param['total_delivery_money']-$param['total_discount_money']-$param['use_mileage'];
            $Gcount = count($param['goods_code']);
            if($Gcount > 1){
                $num = $Gcount - 1;
                $goods_str = $param['goods_name'][0]." 외 ".$num."개";
            }else{
                $goods_str = $param['goods_name'][0];
            }

            $kakao['MSG'] = "[에타홈] 주문완료
 
주문이 완료 되었습니다.
배송이 시작되면 
다시 안내드릴게요.^^

▶주문번호: ".$order_no."
▶상품명: ".$goods_str."
▶주문금액: ".number_format($pay_sum)."원
* 주문금액은 쿠폰할인 및 
즉시 할인금액이 반영 되지 않은 상품 금액 입니다.

 ※ 발송 예정일은 
상품 재고 현황에 따라 
변경 될 수 있습니다.

※ 가구 등 설치가 필요하거나 
화물로 배송되는 상품의 경우
업체에서 연락드려 
배송일 협의가 진행됩니다.

※ 해외직구 상품의 배송기간은 
최대 1달 걸리니 상세페이지나 
고객센터(1522-5572)를 통해 
예정일을 확인해주세요!";
            $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813560816788648361';
            $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
            if($param['buyermobno'] != '' || $param['buyermobno'] != null){
                $kakao['DEST_PHONE'] = str_replace('-','',$param['buyermobno']);
            }else{
                $kakao['DEST_PHONE'] = str_replace('-','',$param['order_mobile']);
            }
            $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';

            $sendSMS = $this->order_m->send_sms_kakao($kakao);

        }

//		//주문 완료 이메일 메일 발송
        if($param['buyeremail'] != ""){
            $mailParam = array();
            $mailParam["kind"		] = "order";
            $mailParam["mem_name"	] = $param['order_name'];
            $mailParam["mem_email"	] = $param['buyeremail'];
            $Mail_order				  = $this->order_m->get_order_info($order_no);
            $Mail_order_refer		  = $this->order_m->get_order_refer_info($order_no);

            for ($i=0; $i<count($Mail_order_refer); $i++){
                $mailParam["order_refer_key"		][$i] = $Mail_order_refer[$i]['ORDER_REFER_NO'];
                $mailParam["goods_code"				][$i] = $Mail_order_refer[$i]['GOODS_CD'];
                $mailParam["goods_name"				][$i] = $Mail_order_refer[$i]['GOODS_NM'];
                $mailParam["goods_brand_name"		][$i] = $Mail_order_refer[$i]['BRAND_NM'];
                $mailParam["goods_img"				][$i] = $Mail_order_refer[$i]['IMG_URL'];
                $mailParam["goods_option_name"		][$i] = $Mail_order_refer[$i]['GOODS_OPTION_NM'];
                $mailParam["goods_cnt"				][$i] = $Mail_order_refer[$i]['ORD_QTY'];
                $mailParam["goods_price"			][$i] = $Mail_order_refer[$i]['SELLING_PRICE'];
                $mailParam["goods_discount_price"	][$i] = $Mail_order_refer[$i]['DC_AMT'];
                $mailParam["goods_option_add_price"	][$i] = $Mail_order_refer[$i]['GOODS_OPTION_ADD_PRICE'];
                $mailParam["goods_total_price"		][$i] = $Mail_order_refer[$i]['TOTAL_PRICE'];
            }

            $mailParam["order_receiver_name"		] = $Mail_order['RECEIVER_NM'];
            $mailParam["order_deliv_msg"			] = $Mail_order['DELIV_MSG'];
            $mailParam["order_card_company"			] = $Mail_order['CARD_COMPANY_NM'];
            $mailParam["order_card_fee"				] = $Mail_order['CARD_FEE_AMT'];
            $mailParam["order_card_month"			] = $Mail_order['CARD_MONTH'];
            $mailParam["order_free_interest_yn"		] = $Mail_order['FREE_INTEREST_YN'];
            $mailParam["order_bank_name"			] = $Mail_order['BANK_NM'];
            $mailParam["order_bank_account_no"		] = $Mail_order['BANK_ACCOUNT_NO'];
            $mailParam["order_deposit_deadline"		] = $Mail_order['DEPOSIT_DEADLINE_DY'];
            $mailParam["order_deposit_cust_nm"		] = $Mail_order['DEPOSIT_CUST_NM'];
            $mailParam["order_delivery_amt"			] = $Mail_order['DELIV_COST_AMT'];
            $mailParam["order_discount_amt"			] = $Mail_order['DC_AMT'];
            $mailParam["order_amt"					] = $Mail_order['ORDER_AMT'];
            $mailParam["order_mileage_amt"			] = $Mail_order['MILEAGE_AMT'];
            $mailParam["total_pay_sum"				] = $Mail_order['TOTAL_PAY_SUM'];
            $mailParam["order_real_pay_amt"			] = $Mail_order['REAL_PAY_AMT'];
            $mailParam["order_pay_kind_code"		] = $Mail_order['ORDER_PAY_KIND_CD'];
            $mailParam["order_pay_kind_name"		] = $Mail_order['ORDER_PAY_KIND_CD_NM'];
            $mailParam["order_receiver_addr"		] = $Mail_order['RECEIVER_ADDR1']." ".$Mail_order['RECEIVER_ADDR2'];
            $mailParam["order_receiver_zipcode"		] = $Mail_order['RECEIVER_ZIPCODE'];
            $mailParam["order_phone"				] = $Mail_order['RECEIVER_PHONE_NO'];
            $mailParam["order_mobno"				] = $Mail_order['RECEIVER_MOB_NO'];
            $mailParam["goods_row"					] = count($Mail_order_refer);
            $mailParam["date"						] = $date;
            $mailParam["order_no"					] = $order_no;
            $mailParam["vars_vnum_no"				] = $Mail_order['VARS_VNUM_NO'];
            $mailParam["vars_expr_dt"				] = $Mail_order['VARS_EXPR_DT'];

            self::_background_send_mail($mailParam);
        }

        return true;
    }

    /**
     * 카카오 페이 임시데이터 저장
     */
    public function process_temp_kakao_post()
    {
        $param = $this->input->post();
        $date  = date("Y-m-d H:i:s", time());

        $tempOrderInfo = array();

        //구매자 정보
        $tempOrderInfo['buyerid'                 ]      = $param['buyerid'  ];
        $tempOrderInfo['buyercode'               ]      = $param['buyercode'];

        //배송지 정보
        $tempOrderInfo['order_name'              ]      = $param['order_name'         ];
        $tempOrderInfo['buyermobno'              ]      = $param['buyermobno'         ];
        $tempOrderInfo['buyeremail'              ]      = $param['buyeremail'         ];
        $tempOrderInfo['buyerzipcode'            ]      = $param['buyerzipcode'       ];
        $tempOrderInfo['buyeraddr1'              ]      = $param['buyeraddr1'         ];
        $tempOrderInfo['buyeraddr2'              ]      = $param['buyeraddr2'         ];
        $tempOrderInfo['order_recipient'         ]      = $param['order_recipient'    ];
        $tempOrderInfo['order_phone'             ]      = $param['order_phone'        ];
        $tempOrderInfo['order_mobile'            ]      = $param['buyertel'           ];
        $tempOrderInfo['order_postnum'           ]      = $param['order_postnum'      ];
        $tempOrderInfo['order_addr1'             ]      = $param['order_addr1'        ];
        $tempOrderInfo['order_addr2'             ]      = $param['order_addr2'        ];
        $tempOrderInfo['shipping_floor'          ]      = $param['shipping_floor'     ];
        $tempOrderInfo['shipping_step_width'     ]      = $param['shipping_step_width'];
        $tempOrderInfo['shipping_elevator'       ]      = $param['shipping_elevator'  ];
        $tempOrderInfo['order_request'           ]      = $param['order_request'      ];
        $tempOrderInfo['orderCustomsNum'         ]      = $param['orderCustomsNum'    ];

        //배송비 정보
        $tempOrderInfo['group_deli_policy_no'    ]      = json_encode($param['group_deli_policy_no'    ], true);
        $tempOrderInfo['group_delivery_price'    ]      = json_encode($param['group_delivery_price'    ], true);
        $tempOrderInfo['group_add_delivery_price']      = json_encode($param['group_add_delivery_price'], true);

        //상품정보
        $tempOrderInfo['goods_code'              ]      = json_encode($param['goods_code'            ], true);
        $tempOrderInfo['goods_name'              ]      = json_encode($param['goods_name'            ], true);
        $tempOrderInfo['goods_option_code'       ]      = json_encode($param['goods_option_code'     ], true);
        $tempOrderInfo['goods_option_name'       ]      = json_encode($param['goods_option_name'     ], true);
        $tempOrderInfo['goods_option_add_price'  ]      = json_encode($param['goods_option_add_price'], true);
        $tempOrderInfo['goods_cnt'               ]      = json_encode($param['goods_cnt'             ], true);
        $tempOrderInfo['goods_price_code'        ]      = json_encode($param['goods_price_code'      ], true);
        $tempOrderInfo['goods_street_price'      ]      = json_encode($param['goods_street_price'    ], true);
        $tempOrderInfo['goods_selling_price'     ]      = json_encode($param['goods_selling_price'   ], true);
        $tempOrderInfo['goods_factory_price'     ]      = json_encode($param['goods_factory_price'   ], true);
        $tempOrderInfo['goods_mileage_save_amt'  ]      = json_encode($param['goods_mileage_save_amt'], true);
        $tempOrderInfo['goods_deli_policy_no'    ]      = json_encode($param['goods_deli_policy_no'  ], true);

        //쿠폰정보
        $tempOrderInfo['goods_coupon_code_s'     ]      = json_encode($param['goods_coupon_code_s'     ], true);
        $tempOrderInfo['goods_coupon_amt_s'      ]      = json_encode($param['goods_coupon_amt_s'      ], true);
        $tempOrderInfo['goods_coupon_code_i'     ]      = json_encode($param['goods_coupon_code_i'     ], true);
        $tempOrderInfo['goods_coupon_amt_i'      ]      = json_encode($param['goods_coupon_amt_i'      ], true);
        $tempOrderInfo['goods_add_coupon_no'     ]      = json_encode($param['goods_add_coupon_no'     ], true);
        $tempOrderInfo['goods_add_coupon_code'   ]      = json_encode($param['goods_add_coupon_code'   ], true);
        $tempOrderInfo['goods_add_coupon_num'    ]      = json_encode($param['goods_add_coupon_num'    ], true);
        $tempOrderInfo['goods_add_discount_price']      = json_encode($param['goods_add_discount_price'], true);


        //결제정보
        $tempOrderInfo['total_order_money'       ]      = $param['total_order_money'   ];
        $tempOrderInfo['total_delivery_money'    ]      = $param['total_delivery_money'];
        $tempOrderInfo['total_discount_money'    ]      = $param['total_discount_money'];
        $tempOrderInfo['use_mileage'             ]      = $param['use_mileage'         ];
        $tempOrderInfo['order_payment_type'      ]      = $param['order_payment_type'  ];

        $tempOrderInfo['cart_coupon_code'        ]      = $param['cart_coupon_code'];
        $tempOrderInfo['cart_coupon_num'         ]      = $param['cart_coupon_num' ];
        $tempOrderInfo['cart_coupon_amt'         ]      = $param['cart_coupon_amt' ];

        $tempOrderInfo['escrowuse'               ]      = $param['escrowuse'   ];
        $tempOrderInfo['browser_info'            ]      = $param['browser_info'];

        $temp_no = $this->order_m->set_temp_order($tempOrderInfo);		// 임시주문  생성

        $order_no = $this->order_m->set_order($param,$date);            // 카카오 주문번호 생성.

        $this->response(array('status' => 'ok', 'order_no' => $order_no, 'temp_no'=> $temp_no), 200);
    }


    /**
     * ARS 결제 요청
     */
    public function process_temp_ars_post()
    {
        $param = $this->input->post();

        setlocale(LC_CTYPE, 'ko_KR.euc-kr');

        include APPPATH ."/third_party/KCP_ARS/cfg/site_conf_inc.php";
        $this->load->library('C_PAYPLUS_CLI');

        $param["good_name"] = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", " ", $param["good_name"]);
        $param["buyr_name"] = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", " ", $param["buyr_name"]);

        /* ============================================================================== */
        /* =   01. 지불 요청 정보 설정                                                  = */
        /* = -------------------------------------------------------------------------- = */
        $pay_method       = iconv("UTF-8", "EUC-KR",$param[ "pay_method"        ]);       // 결제 방법
        $ordr_idxx        = iconv("UTF-8", "EUC-KR",$param[ "ordr_idxx"         ]);       // 주문 번호
        $phon_mny         = iconv("UTF-8", "EUC-KR",$param[ "phon_mny"          ]);       // 결제 금액

        /* = -------------------------------------------------------------------------- = */
        $good_name        = iconv("UTF-8", "EUC-KR",$param[ "good_name"         ]);       // 상품 정보
        $buyr_name        = iconv("UTF-8", "EUC-KR",$param[ "buyr_name"         ]);       // 주문자 이름
        $soc_no           = "";       // 주민등록번호
        /* = -------------------------------------------------------------------------- = */
        $req_tx           = iconv("UTF-8", "EUC-KR",$param[ "req_tx"            ]);       // 요청 종류
        $quota            = "";       // 할부개월 수
        /* = -------------------------------------------------------------------------- = */
        $comm_id           = iconv("UTF-8", "EUC-KR",$param[ "comm_id"          ]);       // 이동통신사코드
        $phon_no           = iconv("UTF-8", "EUC-KR",$param[ "phon_no"          ]);       // 전화번호
        $call_no          = "";       // 상담원 전화번호
        $expr_dt           = iconv("UTF-8", "EUC-KR",$param[ "expr_dt"          ]);       // 결제 유효기간
        /* = -------------------------------------------------------------------------- = */
        $tx_cd            = "";                                 // 트랜잭션 코드
        /* = -------------------------------------------------------------------------- = */
        $res_cd           = "";                                 // 결과코드
        $res_msg          = "";                                 // 결과메시지
        $ars_trade_no     = "";                                 // 결제거래번호
        $app_time         = "";                                 // 처리시간
        /* = -------------------------------------------------------------------------- = */
        $card_no          = "";                                 // 카드번호
        $card_expiry      = "";                                 // 카드유효기간
        $card_quota       = "";                                 // 카드할부개월
        /* = -------------------------------------------------------------------------- = */
        $ars_tx_key       = "";                                 // ARS주문번호(ARS거래키)
        $ordr_nm          = "";                                 // 요청자 이름
        $site_nm          = "";                                 // 요청 사이트명
        /* = -------------------------------------------------------------------------- = */
        $cert_flg           = iconv("UTF-8", "EUC-KR",$param[ "cert_flg"        ]);       // 인증 비인증 구분
        $sig_flg          = "";                                 // 호전환 구분
        $vnum_no          = "";                                 // ARS 결제요청 전화번호
        /* = -------------------------------------------------------------------------- = */
        $ars_trade_no     = "";      // ARS 등록 거래번호
        /* ============================================================================== */

        /* ============================================================================== */
        /* =   02. 인스턴스 생성 및 초기화                                              = */
        /* = -------------------------------------------------------------------------- = */
        $c_PayPlus  = new C_PAYPLUS_CLI;
        $c_PayPlus->mf_clear();
        /* ============================================================================== */


        /* ============================================================================== */
        /* =   03. 처리 요청 정보 설정, 실행                                            = */
        /* = -------------------------------------------------------------------------- = */

        /* = -------------------------------------------------------------------------- = */
        /* =   03-1. 승인 요청                                                          = */
        /* = -------------------------------------------------------------------------- = */
        // 업체 환경 정보
        $cust_ip    = getenv( "REMOTE_ADDR" );

        // 거래 등록 요청 시
        if ( $req_tx == "pay"  )
        {
            $tx_cd = "00100700";

            // 공통 정보
            $common_data_set = "";
            $common_data_set .= $c_PayPlus->mf_set_data_us( "amount"   , $phon_mny    );
            $common_data_set .= $c_PayPlus->mf_set_data_us( "cust_ip"  , $cust_ip  );

            $c_PayPlus->mf_add_payx_data( "common", $common_data_set );

            // 주문 정보
            $c_PayPlus->mf_set_ordr_data( "ordr_idxx",  $ordr_idxx );  // 주문 번호
            $c_PayPlus->mf_set_ordr_data( "good_name",  $good_name );  // 상품 정보
            $c_PayPlus->mf_set_ordr_data( "buyr_name",  $buyr_name );  // 주문자 이름

            // 요청 정보
            $phon_data_set  = "";
            $phon_data_set .= $c_PayPlus->mf_set_data_us( "phon_mny", $phon_mny );  // 요청금액
            $phon_data_set .= $c_PayPlus->mf_set_data_us( "phon_no",  $phon_no  );  // 요청 전화번호
            $phon_data_set .= $c_PayPlus->mf_set_data_us( "comm_id",  $comm_id  );  // 이동통신사 코드
            if (!expr_dt == "")
            {
                $phon_data_set .= $c_PayPlus->mf_set_data_us( "expr_dt",  $expr_dt  );  // 결제 유효기간
            }

            // 요청수단에 따른 구분

            if ($pay_method == "VARS")
            {
                $phon_data_set .= $c_PayPlus->mf_set_data_us( "phon_txtype",  "11600000"  );  // 결제수단 설정
                $phon_data_set .= $c_PayPlus->mf_set_data_us( "cert_flg",  $cert_flg      );  // 인증, 비인증 설정
            }

            $c_PayPlus->mf_add_payx_data( "phon",  $phon_data_set );

        }

        /* ============================================================================== */
        /* =   03-3. 실행                                                               = */
        /* ------------------------------------------------------------------------------ */
        if ( strlen($tx_cd) > 0 )
        {
            $c_PayPlus->mf_do_tx( "",                $g_conf_home_dir, $g_conf_site_cd,
                $g_conf_site_key,  $tx_cd,           "",
                $g_conf_gw_url,    $g_conf_gw_port,  "payplus_cli_slib",
                $ordr_idxx,        $cust_ip,         "3",
                "",                "0" );

        }
        else
        {
            $c_PayPlus->m_res_cd  = "9562";
            $c_PayPlus->m_res_msg = "연동 오류";
        }
        $res_cd  = $c_PayPlus->m_res_cd;                      // 결과 코드
        $res_msg = $c_PayPlus->m_res_msg;                     // 결과 메시지

        /* ============================================================================== */


        /* ============================================================================== */
        /* =   04. 승인 결과 처리                                                       = */
        /* = -------------------------------------------------------------------------- = */
        if ( $req_tx ==  "pay"  )
        {
            /* = -------------------------------------------------------------------------- = */
            /* =   04-1. 요청 결과 추출                                                     = */
            /* = -------------------------------------------------------------------------- = */
            $ars_trade_no  = $c_PayPlus->mf_get_res_data( "ars_trade_no"  );    // ARS 등록번호
            $app_time      = $c_PayPlus->mf_get_res_data( "app_time"      );    // 요청 시간
            $phon_mny      = $c_PayPlus->mf_get_res_data( "phon_mny"      );    // 요청 금액
            $phon_no       = $c_PayPlus->mf_get_res_data( "phon_no"       );    // 요청 전화 or 핸드폰 번호
            $expr_dt       = $c_PayPlus->mf_get_res_data( "expr_dt"       );    // 결제 유효기간

            $ordr_idxx     = $c_PayPlus->mf_get_res_data( "ordr_idxx"     );    // 가맹점 주문번호
            $good_name     = $c_PayPlus->mf_get_res_data( "good_name"     );    // 상품명
            $ordr_nm       = $c_PayPlus->mf_get_res_data( "ordr_nm"       );    // 요청자 이름

            $site_nm       = $c_PayPlus->mf_get_res_data( "site_nm"       );    // 가맹점 사이트 명

            $cert_flg      = $c_PayPlus->mf_get_res_data( "cert_flg"      );    // 인증 or 비인증 구분
            $sig_flg       = $c_PayPlus->mf_get_res_data( "sig_flg"       );    // 호전환 구분
            $vnum_no       = $c_PayPlus->mf_get_res_data( "vnum_no"       );    // ARS 결제요청 전화번호

            $res_msg       = $c_PayPlus->mf_get_res_data( "res_msg"       );    // ARS 결제 요청 결과 메시지


            // 인코딩변환 (EUC-KR > UTF-8)
            $ars_trade_no   = iconv("EUC-KR", "UTF-8" , $ars_trade_no);
            $app_time       = iconv("EUC-KR", "UTF-8" , $app_time);
            $phon_mny       = iconv("EUC-KR", "UTF-8" , $phon_mny);
            $phon_no        = iconv("EUC-KR", "UTF-8" , $phon_no);
            $expr_dt        = iconv("EUC-KR", "UTF-8" , $expr_dt);

            $ordr_idxx      = iconv("EUC-KR", "UTF-8" , $ordr_idxx);

            $cert_flg       = iconv("EUC-KR", "UTF-8" , $cert_flg);
            $vnum_no        = iconv("EUC-KR", "UTF-8" , $vnum_no);

            $res_msg        = iconv("EUC-KR", "UTF-8" , $res_msg);


            //kcp 결제 정보 저장
            $kcp_param						= [];
            $kcp_param['RES_CD'         ]	= $res_cd;
            $kcp_param['RES_MSG'        ]	= $res_msg;
            $kcp_param['ORDR_IDXX'      ]	= $ordr_idxx;
            $kcp_param['PHON_MNY'       ]	= $phon_mny;
            $kcp_param['COMM_ID'        ]   = $comm_id;
            $kcp_param['PHON_NO'        ]	= $phon_no;
            $kcp_param['VNUM_NO'        ]	= $vnum_no;
            $kcp_param['CERT_FLG'       ]	= $cert_flg;
            $kcp_param['APP_TIME'       ]	= $app_time;
            $kcp_param['EXPR_DT'        ]	= $expr_dt;
            $kcp_param['ARS_TRADE_NO'   ]	= $ars_trade_no;

            $this->order_m->saveVarsLOG($kcp_param);

            $this->response(array('res_cd' => $res_cd, 'res_msg'=>$res_msg, 'vnum_no'=>$vnum_no,  'expr_dt'=>$expr_dt, 'ars_trade_no'=>$ars_trade_no, 'pg_tid' => $ordr_idxx), 200);
        }
        /* ============================================================================== */
    }

    public function class_kakao_send($param)
    {

        $buyer       = $param['buyer'];
        $goods_nm    = $param['goods_nm'];
        $order_refer = $param['order_refer_cd'];
        $date = date('Y-m-d H:i');


        $kakao = array();
        $kakao['SMS_MSG_GB_CD'      ] = 'KAKAO';
        $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2020030415033603031744681';
        $kakao['KAKAO_SENDER_KEY'   ] = '1682e1e3f3186879142950762915a4109f2d04a2';
        $kakao['DEST_PHONE'] = $param['send_phone'];

        $kakao['MSG'] ="[에타홈] 공방클래스 주문알람

".$buyer."고객님께서 
클래스 결제를 완료했습니다!
(".$date.")

고객님과 통화하고 
시간을 입력해주세요! 
(24시간 이내)

주문확인과 시간입력은 
‘주문 조회하기‘를 클릭하세요!

* 수업완료 후 정산을 위해 [이용완료 확인] 버튼을 꼭 눌러주세요.

▶상품명 : ".$goods_nm."

▼주문 조회하기▼
http://m.etahome.co.kr/order/order_seller/".$order_refer;
        $this->order_m->send_sms_kakao($kakao);

        $kakao = array();
        $kakao['SMS_MSG_GB_CD'      ] = 'KAKAO';
        $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101813580616788427362';
        $kakao['KAKAO_SENDER_KEY'   ] = '1682e1e3f3186879142950762915a4109f2d04a2';
        $kakao['DEST_PHONE'] = $param['dest_phone'];

        $kakao['MSG'] ="[에타홈] 공방클래스 결제완료

".$buyer."고객님, 공방클래스 결제가 완료되었습니다.^^

공방에서 곧 연락이 갈거예요~
조금만 기다려 주세요!

클래스 주문은 하단의 
‘주문 조회하기’ 를 통해 확인하세요!

▶상품명 : ".$goods_nm."

▼주문 조회하기▼
http://m.etah.co.kr/order/order_buyer/".$order_refer;
        $this->order_m->send_sms_kakao($kakao);

        return true;

    }

    /**
     * 네이버페이 결제
     */
    public function naver_pay_post()
    {
        $param = $this->input->post();

        self::naver_pay_get($param);
    }

    #########################################################
    ## 주문 정보 전송
    #########################################################
    public function naver_pay_get($object)
    {
        $request =  $this->genOrderForm($object);

        // 주문 등록 API 호출
        $url = "https://api.pay.naver.com/o/customer/api/order/v20/register";
        $ci = curl_init();

        $headers = array('Content-Type: application/xml; charset=utf-8;');
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_POST, TRUE);
        curl_setopt($ci, CURLOPT_TIMEOUT, 10);
        curl_setopt($ci, CURLOPT_POSTFIELDS, $request);

        // 주문 등록 후 결과값 확인
        $response = curl_exec($ci);
        curl_close ($ci);

        $param = explode(':', $response);

        if ($param[0] == 'SUCCESS') {   //성공일 경우
            $requestParam = "/".$param[1]."/".$param[2];
        }

        //주문서 URL 재전송 (redirect)
        $redirectUrl = "https://order.pay.naver.com/customer/buy".$requestParam;

        header("Location:".$redirectUrl);
        exit();
    }


    #########################################################
    ## 주문정보 생성
    #########################################################
    public function genOrderForm($product)
    {
        $this->load->model('goods_m');

        $data = '<?xml version="1.0" encoding="utf-8"?>';
        $data .= '<order>';


#################### 장바구니 구매 ####################
        if( isset($product['order_gb']) ) {
            //장바구니 선택된 상품만큼 배열에 담음
            for($arr=0; $arr<count($product['chkGoods']); $arr++) {
                $chk = explode("||", $product['chkGoods'][$arr]);
                $cnt = $chk[0];

                //이미지
                $resizingImg = $this->goods_m->get_goodsImageResizing($product['goods_code'][$cnt], '300');   //  리사이징 이미지 가져오기
                $product['goods_img'][$cnt] = str_replace(array('%3A', '%2F', '%3F', '%3D', '%26'), array(':', '/', '?', '=', '&'), urlencode($resizingImg));   //한글 인코딩

                //옵션명 - 멀티옵션명
                $opt_name = $this->goods_m->set_optionName($product['goods_code'][$cnt], $product['goods_option_code'][$cnt]);

                $data .= '<product>';
                //할인적용금액 (추가할인 포함X)
                $price = $product['goods_selling_price'][$cnt] - $product['goods_discount_price'][$cnt];
                $data .= '<basePrice>'.$price.'</basePrice>';
                $data .= '<ecMallProductId>'.$product['goods_code'][$cnt].'</ecMallProductId>';      /*네이버쇼핑 EP 의 mall_pid. 네이버쇼핑 가맹점이면 네이버쇼핑 EP 의 mall_pid 와 동일한 값을 입력해야 한다.*/
                $data .= '<id>'.$product['goods_code'][$cnt].'</id>';
                $data .= '<imageUrl><![CDATA['.$product['goods_img'][$cnt].']]></imageUrl>';
                $data .= '<infoUrl><![CDATA['.base_url().'.co.kr/goods/detail/'.$product['goods_code'][$cnt].']]></infoUrl>';
                $data .= '<name><![CDATA['.$product['goods_name'][$cnt].']]></name>';


                /*옵션 상품 정보*/
                $data .= '<option>';
                $data .= '<manageCode>'.$product['goods_option_code'][$cnt].'</manageCode>';  //옵션 관리 코드
                $data .= '<price>'.$product['goods_option_add_price'][$cnt].'</price>';   //옵션별 추가 금액
                $data .= '<quantity>'.$product['goods_cnt'][$cnt].'</quantity>';   //옵션 상품 주문 수량
                /*선택한 옵션 정보*/
                $data .= '<selectedItem>';
                $data .= '<name><![CDATA[옵션명]]></name>';  //선택한 옵션명
                $data .= '<type>SELECT</type>';
                $data .= '<value>';
                $data .= '<id>'.$product['goods_option_code'][$cnt].'</id>';  //선택한 옵션값을 대표하는 ID
                $data .= '<text><![CDATA['.trim($opt_name).']]></text>';  //선택한 옵션값의 텍스트 값
                $data .= '</value>';
                $data .= '</selectedItem>';

                $data .= '</option>';


                //동일한 상품이 존재할 경우
                if( ($arr+1) < count($product['chkGoods']) ) {
                    $chk_b = explode("||", $product['chkGoods'][$arr+1]);
                    $cnt_b = $chk_b[0];

                    //동일한 상품 중복일 경우
                    if($product['goods_code'][$cnt]==$product['goods_code'][$cnt_b]) {
                        /*옵션 상품 정보*/
                        $data .= '<option>';
                        $data .= '<manageCode>'.$product['goods_option_code'][$cnt_b].'</manageCode>';  //옵션 관리 코드
                        $data .= '<price>'.$product['goods_option_add_price'][$cnt_b].'</price>';   //옵션별 추가 금액
                        $data .= '<quantity>'.$product['goods_cnt'][$cnt_b].'</quantity>';   //옵션 상품 주문 수량
                        /*선택한 옵션 정보*/
                        $data .= '<selectedItem>';
                        $data .= '<name><![CDATA[옵션명]]></name>';  //선택한 옵션명
                        $data .= '<type>SELECT</type>';
                        $data .= '<value>';
                        $data .= '<id>'.$product['goods_option_code'][$cnt_b].'</id>';  //선택한 옵션값을 대표하는 ID
                        $data .= '<text><![CDATA['.trim($product['goods_option_name'][$cnt_b]).']]></text>';  //선택한 옵션값의 텍스트 값
                        $data .= '</value>';
                        $data .= '</selectedItem>';

                        $data .= '</option>';

                        $arr = $arr+1;
                    }
                }


                /*
                배송정책정리
                1. 무료배송(FREE)		: 배송비유형feeType:FREE/ 배송비결제방식feePayType:FREE/ 묶음배송BundleGroupAvailable(Y)
                2. 조건부무료(PRICE)	    : 배송비유형feeType:CONDITIONAL_FREE/ 배송비결제방식feePayType:PREPAYED/ 묶음배송BundleGroupAvailable(Y)
                3. 착불선결제(STATIC)	: 배송비유형feeTypeCHARGE_BY_QUANTITY/ 배송비결제방식feePayType:PREPAYED/ 묶음배송BundleGroupAvailable(N)
                4. 배송비별도표기(NONE)	: 배송비유형feeType:CHARGE/ 배송비결제방식feePayTypeCASH_ON_DELIVERY/ 묶음배송BundleGroupAvailable(N)
                */
                /*배송비 정책 정보*/
                $data .= '<shippingPolicy>';
                /*수량별 배송비 부과 정책*/
                if( $product['deli_pattern'][$cnt] == 'STATIC' ) {
                    $data .= '<chargeByQuantity>';
                    $data .= '<type>REPEAT</type>';    //배송비 부과방식
                    $data .= '<repeatQuantity>1</repeatQuantity>'; //배송비 부과 단위 수량
                    $data .= '</chargeByQuantity>';
                }

                /*조건부 무료 정책 정보*/
                if( $product['deli_pattern'][$cnt] == 'PRICE' && $product['deli_limit'][$cnt] != 0 ) {
                    $data .= '<conditionalFree>';
                    $data .= '<basePrice>'.$product['deli_limit'][$cnt].'</basePrice>'; //기준금액
                    $data .= '</conditionalFree>';
                }

                if( $product['deli_pattern'][$cnt] == 'FREE' ){
                    $data .= '<feePayType>FREE</feePayType>';   //배송비 결제 방법
                    $data .= '<feePrice>0</feePrice>';    //기본 배송비
                    $data .= '<feeType>FREE</feeType>';   //배송비 유형
                    $data .= '<groupId>'.$product['deli_policy_no'][$cnt].'</groupId>';    //배송비 묶음 그룹 ID
                    $data .= '<method>DELIVERY</method>';   //배송 방법.
                } else if( $product['deli_pattern'][$cnt] == 'PRICE' ){
                    $data .= '<feePayType>PREPAYED</feePayType>';   //배송비 결제 방법
                    $data .= '<feePrice>'.$product['deli_cost'][$cnt].'</feePrice>';    //기본 배송비
                    if($product['deli_limit'][$cnt] == 0) {
                        $data .= '<feeType>CHARGE</feeType>';   //배송비 유형
                    } else {
                        $data .= '<feeType>CONDITIONAL_FREE</feeType>';   //배송비 유형
                    }
                    $data .= '<groupId>'.$product['deli_policy_no'][$cnt].'</groupId>';    //배송비 묶음 그룹 ID
                    $data .= '<method>DELIVERY</method>';   //배송 방법.
                } else if( $product['deli_pattern'][$cnt] == 'STATIC' ){
                    $data .= '<feePayType>PREPAYED</feePayType>';   //배송비 결제 방법
                    $data .= '<feePrice>'.$product['deli_cost'][$cnt].'</feePrice>';    //기본 배송비
                    $data .= '<feeType>CHARGE_BY_QUANTITY</feeType>';   //배송비 유형
                    $data .= '<groupId>'.$product['deli_policy_no'][$cnt].'</groupId>';    //배송비 묶음 그룹 ID
                    $data .= '<method>DELIVERY</method>';   //배송 방법.
                } else if( $product['deli_pattern'][$cnt] == 'NONE' ){
                    $data .= '<feePayType>CASH_ON_DELIVERY</feePayType>';   //배송비 결제 방법
                    $data .= '<feePrice>0</feePrice>';    //기본 배송비
                    $data .= '<feeType>CHARGE</feeType>';   //배송비 유형
                    $data .= '<groupId>'.$product['deli_policy_no'][$cnt].'</groupId>';    //배송비 묶음 그룹 ID
                    $data .= '<method>DIRECT_DELIVERY</method>';   //배송 방법.
                }
                $data .= '</shippingPolicy>';

                /* 상품의 과세종류 */
                if($product['goods_tax_gb_cd'][$cnt] == '00') { //면세
                    $data .= '<taxType>TAX_FREE</taxType>';
                } else if($product['goods_tax_gb_cd'][$cnt] == '01') {  //과세
                    $data .= '<taxType>TAX</taxType>';
                } else if($product['goods_tax_gb_cd'][$cnt] == '02') {  //영세
                    $data .= '<taxType>ZERO_TAX</taxType>';
                }
                $data .= '</product>';
            }
        }
#################### 상세페이지 구매 ####################
        else {
            //이미지
            $resizingImg = $this->goods_m->get_goodsImageResizing($product['goods_code'], '300');   //  리사이징 이미지 가져오기
            $product['goods_img'] = str_replace(array('%3A', '%2F', '%3F', '%3D', '%26'), array(':', '/', '?', '=', '&'), urlencode($resizingImg));   //한글 인코딩

            $data .= '<product>';
            //할인적용금액 (추가할인 포함X)
            $price = $product['goods_selling_price'] - $product['goods_discount_price'];
            $data .= '<basePrice>'.$price.'</basePrice>';
            $data .= '<ecMallProductId>'.$product['goods_code'].'</ecMallProductId>';      /*네이버쇼핑 EP 의 mall_pid. 네이버쇼핑 가맹점이면 네이버쇼핑 EP 의 mall_pid 와 동일한 값을 입력해야 한다.*/
            $data .= '<id>'.$product['goods_code'].'</id>';
            $data .= '<imageUrl><![CDATA['.$product['goods_img'].']]></imageUrl>';
            $data .= '<infoUrl><![CDATA['.base_url().'goods/detail/'.$product['goods_code'].']]></infoUrl>';
            $data .= '<name><![CDATA['.$product['goods_name'].']]></name>';


            /*옵션 상품 정보*/
            for($a=0;$a<count($product['goods_option_code']);$a++){
                $data .= '<option>';
                $data .= '<manageCode>'.$product['goods_option_code'][$a].'</manageCode>';  //옵션 관리 코드
                $data .= '<price>'.$product['goods_option_add_price'][$a].'</price>';   //옵션별 추가 금액
                $data .= '<quantity>'.$product['goods_cnt'][$a].'</quantity>';   //옵션 상품 주문 수량
                /*선택한 옵션 정보*/
                $data .= '<selectedItem>';
                $data .= '<name><![CDATA[옵션명]]></name>';  //선택한 옵션명
                $data .= '<type>SELECT</type>';
                $data .= '<value>';
                $data .= '<id>'.$product['goods_option_code'][$a].'</id>';  //선택한 옵션값을 대표하는 ID
                $data .= '<text><![CDATA['.trim($product['goods_option_name'][$a]).']]></text>';  //선택한 옵션값의 텍스트 값
                $data .= '</value>';
                $data .= '</selectedItem>';

                $data .= '</option>';
            }

            /*
            배송정책정리
            1. 무료배송(FREE)		: 배송비유형feeType:FREE/ 배송비결제방식feePayType:FREE/ 묶음배송BundleGroupAvailable(Y)
            2. 조건부무료(PRICE)	    : 배송비유형feeType:CONDITIONAL_FREE/ 배송비결제방식feePayType:PREPAYED/ 묶음배송BundleGroupAvailable(Y)
            3. 착불선결제(STATIC)	: 배송비유형feeTypeCHARGE_BY_QUANTITY/ 배송비결제방식feePayType:PREPAYED/ 묶음배송BundleGroupAvailable(N)
            4. 배송비별도표기(NONE)	: 배송비유형feeType:CHARGE/ 배송비결제방식feePayTypeCASH_ON_DELIVERY/ 묶음배송BundleGroupAvailable(N)
            */
            /*배송비 정책 정보*/
            $data .= '<shippingPolicy>';
            /*수량별 배송비 부과 정책*/
            if( $product['goods_deliv_pattern_type'] == 'STATIC' ) {
                $data .= '<chargeByQuantity>';
                $data .= '<type>REPEAT</type>';    //배송비 부과방식
                $data .= '<repeatQuantity>1</repeatQuantity>'; //배송비 부과 단위 수량
                $data .= '</chargeByQuantity>';
            }

            /*조건부 무료 정책 정보*/
            if( $product['goods_deliv_pattern_type'] == 'PRICE' && $product['deli_limit'] != 0) {
                $data .= '<conditionalFree>';
                $data .= '<basePrice>'.$product['deli_limit'].'</basePrice>'; //기준금액
                $data .= '</conditionalFree>';
            }

            if( $product['goods_deliv_pattern_type'] == 'FREE' ){
                $data .= '<feePayType>FREE</feePayType>';   //배송비 결제 방법
                $data .= '<feePrice>0</feePrice>';    //기본 배송비
                $data .= '<feeType>FREE</feeType>';   //배송비 유형
                $data .= '<groupId>'.$product['deli_policy_no'].'</groupId>';    //배송비 묶음 그룹 ID
                $data .= '<method>DELIVERY</method>';   //배송 방법.
            } else if( $product['goods_deliv_pattern_type'] == 'PRICE' ){
                $data .= '<feePayType>PREPAYED</feePayType>';   //배송비 결제 방법
                $data .= '<feePrice>'.$product['deli_cost'].'</feePrice>';    //기본 배송비
                if($product['deli_limit'] == 0) {
                    $data .= '<feeType>CHARGE</feeType>';   //배송비 유형
                } else {
                    $data .= '<feeType>CONDITIONAL_FREE</feeType>';   //배송비 유형
                }
                $data .= '<groupId>'.$product['deli_policy_no'].'</groupId>';    //배송비 묶음 그룹 ID
                $data .= '<method>DELIVERY</method>';   //배송 방법.
            } else if( $product['goods_deliv_pattern_type'] == 'STATIC' ){
                $data .= '<feePayType>PREPAYED</feePayType>';   //배송비 결제 방법
                $data .= '<feePrice>'.$product['deli_cost'].'</feePrice>';    //기본 배송비
                $data .= '<feeType>CHARGE_BY_QUANTITY</feeType>';   //배송비 유형
                $data .= '<groupId>'.$product['deli_policy_no'].'</groupId>';    //배송비 묶음 그룹 ID
                $data .= '<method>DELIVERY</method>';   //배송 방법.
            } else if( $product['goods_deliv_pattern_type'] == 'NONE' ){
                $data .= '<feePayType>CASH_ON_DELIVERY</feePayType>';   //배송비 결제 방법
                $data .= '<feePrice>0</feePrice>';    //기본 배송비
                $data .= '<feeType>CHARGE</feeType>';   //배송비 유형
                $data .= '<groupId>'.$product['deli_policy_no'].'</groupId>';    //배송비 묶음 그룹 ID
                $data .= '<method>DIRECT_DELIVERY</method>';   //배송 방법.
            }
            $data .= '</shippingPolicy>';

            /* 상품의 과세종류 */
            if($product['goods_tax_gb_cd'] == '00') { //면세
                $data .= '<taxType>TAX_FREE</taxType>';
            } else if($product['goods_tax_gb_cd'] == '01') {  //과세
                $data .= '<taxType>TAX</taxType>';
            } else if($product['goods_tax_gb_cd'] == '02') {  //영세
                $data .= '<taxType>ZERO_TAX</taxType>';
            }
            $data .= '</product>';
        }

        $data .= '<merchantId>np_chfrl677135</merchantId>';   /*상점 ID. 네이버페이에 가입 승인될 때 정해진다. */
        if( isset($product['order_gb']) ) { //장바구니 구매
            $data .= '<backUrl><![CDATA['.base_url().'.co.kr/cart]]></backUrl>';
        } else {    //상세페이지 구매
            $data .= '<backUrl><![CDATA['.base_url().'.co.kr/goods/detail/'.$product['goods_code'].']]></backUrl>';
        }
        $data .= '<interface>';
        $data .= '<cpaInflowCode>'.$_COOKIE['CPAValidator'].'</cpaInflowCode>';     /*네이버쇼핑 CPA 코드*/
        $data .= '<naverInflowCode>'.$_COOKIE['NA_CO'].'</naverInflowCode>';     /*네이버 서비스 유입 경로 코드*/
        $data .= '<saClickId>'.$_COOKIE['NVADID'].'</saClickId>';     /*SA CLICK ID*/
        $data .= '</interface>';
        $data .= '<certiKey>50CE9CAD-5C85-483E-910E-2FDA41D0E26C</certiKey>';       /*인증키. 네이버페이에 가입 승인될 때 정해진다. */
        $data .= '</order>';

        return $data;

    }
}