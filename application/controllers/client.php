<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 조용준 -------
 * Date: 2016.05.26.
 */

class Client extends MY_Controller
{
	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}

		parent::__construct();

	}

	public function index_get()
	{
		//self::stockList_get();
		echo phpinfo();
	}
	
	public function test_get()
	{
		echo urlencode('쇼파 & 의자');
	}
	
	
	/**
	 * 테스트 > cloudsearch
	 */
	public function clientCloudsearch_get()
	{
		/*
			http://staging.etah.co.kr/client/clientCloudsearch
		
			http://dev.etah.co.kr/client/clientCloudsearch
		*/

		//&fq=brand_nm%3A'%ED%8F%AC%ED%8A%B8%EB%A9%94%EB%A6%AC%EC%98%A8'

		//$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("럭셔리")."&size=20&start=0&&sort=_score+desc&q.options={fields:['goods_nm^5','brand_nm^2']}&return=_all_fields,_score";
		//$strRequestUri = "http://search-etahtest-gqrshacc632qy5d7jx436x6m5u.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("[두닷] 모던브릿지_AD 두닷(dodot) 스툴 의자 가구")."&fq=brand_nm%3A'".urlencode("포트메리온")."'&size=20&start=0&sort=_score+desc&return=_all_fields,_score";
		//$strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("봄세일")."&category_1_nm=".urlencode("침구/패브릭")."&size=20&start=0&sort=_score+desc&return=_all_fields,_score";
		$strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode("봄세일")."&size=20&start=0&sort=_score+desc&return=_all_fields,_score";

		$CURL = curl_init();
		curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
		curl_setopt($CURL, CURLOPT_HEADER, 0 );
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
		curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
		$result = curl_exec($CURL);
		curl_close($CURL);

		var_dump( json_decode($result, true) ).PHP_EOL;
	}

	/**
	 * 테스트 > S3
	 */
	public function clientS3_get()
	{
		/*
			http://dev.etah.co.kr/client/clientS3
		*/

		// Load Library
		$this->load->library('s3');

		$input = S3::inputFile('/webservice_root/etah_front/assets/images/common/sprite-cart.png');
		if (S3::putObject($input, 'image.etah.co.kr', 'goods/0000/1234567.jpg', S3::ACL_PUBLIC_READ)) {
			echo "File uploaded";
		}else{
			echo "Failed to upload file";
		}


	}

	public function check_test_get(){
        /* staging.etah.co.kr/client/check_test */
        $this->load->model('order_m');
        $param = '20180716306732';
        $param1 = 'ETAH201807161531701529863';
        $OrderInfo = $this->order_m->get_pay_N_order_info_kcp($param, $param1);	//결제번호, 주문상세번호 가져오기
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

        $kakao['MSG'] = "[에타] 주문완료
 
주문이 완료 되었습니다.
배송이 시작되면 
다시 안내드릴게요.^^

▶주문번호: ".$OrderInfo['ORDER_NO']."
▶상품명: ".$goods_str."
▶주문금액: ".$pay_sum."원
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
        $kakao['DEST_PHONE'] = '01066236553';
        $kakao['KAKAO_ATTACHED_FILE'] = 'btn_mywiz_order.json';
        if($Goods_info['SENDER_NM']) {
            $this->order_m->send_sms_kakao($kakao);
        }

        print_r( $Goods_info['SENDER_MOB_NO'].'/'.$Goods_info['RECEIVER_MOB_NO']);

    }
}


