<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends MY_Controller
{
	protected $methods = array(
		//'index_get' => array('log' => 0)
	);
	private $query_debug;

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

		/**
		 * 쿼리 밴치마킹
		 */
		$this->query_debug = FALSE;

		//API Key 사용시 해당 값을 설정하면 키검사를 하지 않음
		$this->_allow = TRUE;
//		$this->load->model('delivery_m');
		$this->load->model('order_m');
	}


	/**
	 * delivery
	 *
	 */
	public function index_get()
	{error_reporting(E_ALL);
ini_set('display_errors', 1);
//		var_dump("sss");
//		var_dump($_GET['order_refer_no']);
		$mailParam	= array();

		//대상주문조회
		$targetOrder					= $this->order_m->get_order_delivery_mail($_GET['order_refer_no']);

		$mailParam['order_name'			] = $targetOrder['SENDER_NM'];
		$mailParam['order_email'		] = $targetOrder['SENDER_EMAIL'];
		$mailParam['order_no'			] = $targetOrder['ORDER_NO'];
		$mailParam['order_refer_no'		] = $targetOrder['ORDER_REFER_NO'];
		$mailParam['goods_code'			] = $targetOrder['GOODS_CD'];
		$mailParam['goods_name'			] = $targetOrder['GOODS_NM'];
		$mailParam['goods_option_code'	] = $targetOrder['GOODS_OPTION_CD'];
		$mailParam['goods_option_name'	] = $targetOrder['GOODS_OPTION_NM'];
		$mailParam['brand_code'			] = $targetOrder['BRAND_CD'];
		$mailParam['brand_name'			] = $targetOrder['BRAND_NM'];
		$mailParam['deliv_date'			] = $targetOrder['DELIV_DT'];
		$mailParam['deliv_company_code'	] = $targetOrder['DELIV_COMPANY_CD'];
		$mailParam['deliv_company_name'	] = $targetOrder['DELIV_COMPANY_NM'];
		$mailParam['invoice_no'			] = $targetOrder['INVOICE_NO'];
		$mailParam['receiver_name'		] = $targetOrder['RECEIVER_NM'];
		$mailParam['receiver_addr'		] = $targetOrder['RECEIVER_ADDR'];
		$mailParam['order_date'			] = $targetOrder['ORD_DT'];

		//배송추적
		if($targetOrder['DELIV_COMPANY_CD'] == '10'){
			$DeliAddress = "https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?sid1=";			//우체국택배
		}else if($targetOrder['DELIV_COMPANY_CD'] == '23' || $targetOrder['DELIV_COMPANY_CD'] == '03'|| $targetOrder['DELIV_COMPANY_CD'] == '40'){
			$DeliAddress = "http://www.cjgls.co.kr/kor/service/service_tracking.asp?slipno=";				//CJ GLS, 대한통운
		}else if($targetOrder['DELIV_COMPANY_CD'] == '19'){
			$DeliAddress = "http://www.hanjin.co.kr/Delivery_html/inquiry/result_waybill.jsp?wbl_num=";		//한진택배
		}else if($targetOrder['DELIV_COMPANY_CD'] == '20'){
			$DeliAddress = "http://www.hlc.co.kr/personalService/tracking/06/tracking_goods_result.jsp?InvNo=";	//현대택배
		}else if($targetOrder['DELIV_COMPANY_CD'] == '24'){
			$DeliAddress = "http://www.kgbls.co.kr/sub/trace.asp?f_slipno=";									//KGB택배
		}else if($targetOrder['DELIV_COMPANY_CD'] == '27'){
			$DeliAddress = "http://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceNoView.aspx?&gubun=slipno&slipno=";	//로젠택배
		}else{
			$DeliAddress = "";
		}

		$mailParam["delivAddress"		] = $DeliAddress;


		//구매메일발송
		self::_background_send_mail($mailParam);
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
		$url = site_url("/delivery/background_send_mail");

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

		$buyername = $param['order_name'];

		$data['order_no'				] = $param['order_no'];				//주문번호
		$data['order_refer_no'			] = $param['order_refer_no'];		//주문상세번호
		$data['goods_code'				] = $param['goods_code'];			//상품코드
		$data['goods_name'				] = $param['goods_name'];			//상품이름
		$data['goods_option_code'		] = $param['goods_option_code'];	//옵션코드
		$data['goods_option_name'		] = $param['goods_option_name'];	//옵션이름
		$data['brand_code'				] = $param['brand_code'];			//브랜드코드
		$data['brand_name'				] = $param['brand_name'];			//브랜드이름
		$data['deliv_date'				] = $param['deliv_date'];			//발송일
		$data['deliv_company_code'		] = $param['deliv_company_code'];	//택배사코드
		$data['deliv_company_name'		] = $param['deliv_company_name'];	//택배사명
		$data['invoice_no'				] = $param['invoice_no'];			//송장번호
		$data['receiver_name'			] = $param['receiver_name'];		//수취인 이름
		$data['receiver_addr'			] = $param['receiver_addr'];		//수취인 주소
		$data['order_date'				] = $param['order_date'];			//주문일
		$data['delivAddress'			] = $param['delivAddress'];			//송장조회

		/**
		 * 구매 메일 발송
		 */
		$this->load->helper('string');
		$this->load->library('email');

		$body = self::_mail_template($data); //메일 템플릿 가져오기

		//이메일 인증
		$subject = "주문하신 상품이 발송되었습니다.";

		$body = str_replace("{{mem_name}}"	 	, $buyername	, $body);
		$body = str_replace("{{order_date}}" 	, date('Ymd')	, $body);

		$receive = $param['order_email'];

		$this->email->sendmail($receive, $subject, $body, 'info@etah.co.kr', 'ETA HOME');
	}

	/**
	 * 메일 템플릿 가져오기
	 */
	private function _mail_template($data)
	{
		$body = $this->load->view('template/email/delivery/email_body.php', $data, TRUE);

		return $body;
	}

}