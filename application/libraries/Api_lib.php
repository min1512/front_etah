<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * API 통신 라이브러리
 * User: 조용준
 * Date: 2015/02/12
 * API 연결 라이브러리
 */

class Api_lib {

	protected $_ci;

	public function __construct()
	{
		$this->_ci =& get_instance();
	}

	/**
	 * 이카고 인증키 생성
	 *
	 * @param $reqFunctionVal
	 *
	 * @retrun ecargo_key_val
	 */	
	public function get_ecargo_keyval($reqFunctionVal)
	{
		$customer_id = "EM";
		$user_login = "yic";	
		$user_password = "YICcom0105";
		$req_function = $reqFunctionVal;
		date_default_timezone_set("Asia/Seoul");
		
		$ticket = $customer_id.' '.$user_login.' '.hash('sha256', $user_password).' '.date('Ymd').' '.$req_function;		
		$ticket = base64_encode($ticket);
		$ticket = strtr($ticket, '+/=','-_,');
		
		return $ticket;		
	}

	/**
	 * 이카고 API 통신
	 *
	 * @param $data
	 * @param $reqFunctionVal
	 *
	 * @retrun $result
	 */
	public function send_ecargo_api($data, $reqFunctionVal)
	{	
		$ticket = $this->get_ecargo_keyval($reqFunctionVal);
		
		$val = $ticket;
		$val .= CHR(13).CHR(10).$data;			
		$val = urlencode($val);
		
		$CURL = curl_init();
		
		/* 운영/개발에 따라서 저장 위치가 틀림 */
		$urlDiv = explode(".", $_SERVER['HTTP_HOST']);		
		$strRequestUri ='';
		if( $urlDiv[0] == 'devadmin' || $urlDiv[0] == 'devapi' ){
			
			/* test */
			$strRequestUri = "http://ecapp.ecargo.asia:400/api/in/";	
			
		}else{
			
			/* real */
			$strRequestUri = "http://ecapp.ecargo.asia:200/api/in/";			
		}
			
		$send_data = "send_data=".$val;

		curl_setopt($CURL, CURLOPT_URL, $strRequestUri );
		curl_setopt($CURL, CURLOPT_CUSTOMREQUEST, "POST");		 
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1 );
		curl_setopt($CURL, CURLOPT_TIMEOUT, 600 );
		curl_setopt($CURL, CURLOPT_POST, 1 );		
		curl_setopt($CURL, CURLOPT_POSTFIELDS, $send_data );
		
		$result = curl_exec($CURL);

		curl_close($CURL);
		
		return $result;
	}

	/**
	 * EMS API
	 *
	 * @param $traceNo
	 *
	 * @retrun $result
	 */
	public function send_ems_trace_api($traceNo)
	{	
		$val = "regkey=2714b254209c07ff61422869507186&target=emsTrace&query=".$traceNo;

		$CURL = curl_init();
		
		$strRequestUri = "http://biz.epost.go.kr/KpostPortal/openapi";
		
		curl_setopt($CURL, CURLOPT_URL, $strRequestUri );
		curl_setopt($CURL, CURLOPT_HEADER, 0 );
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1 );
		curl_setopt($CURL, CURLOPT_TIMEOUT,	600 );
		curl_setopt($CURL, CURLOPT_POST, 1 );
		curl_setopt($CURL, CURLOPT_POSTFIELDS,	$val  );
		
		$result = curl_exec($CURL);

		curl_close($CURL);
		
		try{
			$result = @new SimpleXMLElement( trim( $result ), LIBXML_NOCDATA );
		}catch ( Exception $e ){
			echo "error";
		}
		
		/*						
		echo CHR(10).CHR(13)."sortingdate=".$result->itemlist->item[11]->sortingdate;
		echo CHR(10).CHR(13)."eventhms=".$result->itemlist->item[11]->eventhms;
		echo CHR(10).CHR(13)."eventregiponm=".$result->itemlist->item[11]->eventregiponm;
		echo CHR(10).CHR(13)."delivrsltnm=".$result->itemlist->item[11]->delivrsltnm;
		echo CHR(10).CHR(13)."nondelivreasnnm=".$result->itemlist->item[11]->nondelivreasnnm;
		echo CHR(10).CHR(13)."eventnm=".$result->itemlist->item[11]->eventnm;
		echo CHR(10).CHR(13)."eventymd=".$result->itemlist->item[11]->eventymd;
		echo CHR(10).CHR(13)."upucd=".$result->itemlist->item[11]->upucd;		
		echo CHR(10).CHR(13);
		var_dump($result);			
		*/
		
		return $result;
	}

	

}