<?php
/**
 * 배대지 사이트 고객
 * User: 조용준
 * Date: 2014/11/14
 * 사용자 common util
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_lib {

	protected $_ci;

	public function __construct()
	{
		$this->_ci =& get_instance();
	}

	/**
	 * URI 가져오기
	 *
	 * @retrun $uri
	 */
	public function get_uri()
	{
		 /* uri 값 셋팅 */
	   $_uriValue = $this->_ci->uri->uri_string();
	   
	   if( !empty($_uriValue) ) 
	   	$_uriValue = "/".$_uriValue;
	      
	   return $_uriValue;
	}

	/**
	 * Login 체크 (true: 로그인, false: 로그인 아님)
	 *
	 * @retrun boolean
	 */
	public function check_login()
	{
		$_login_yn = false;
		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
		
		// 세션 YEXPRESS_R_LOGIN_YN=TRUE 이고 YEXPRESS_R_GB='2' 이면 로그인 상태임
		//if( $this->_ci->session->userdata('YEXPRESS_R_LOGIN_YN') == TRUE && $this->_ci->session->userdata('YEXPRESS_R_GB') == '2' ){			
		if( $_param['tntnhan_r_id'] == TRUE && $_param['tntnhan_r_gb'] == '2' ){			
			$_login_yn = true;
		}	
	      
	   return $_login_yn;
	}
	
	/**
	 * Eximbay 수수료 계산
	 *
	 * @param $card_money
	 *
	 * @retrun int
	 */
	public function get_card_fee($card_money)
	{
		$_d_card_fee = '0.031';
		$_tmp_money = intval($card_money);

		if($_tmp_money > 0)
			return round($_tmp_money * $_d_card_fee,0);
		else
			return 0;
	}
	
	/**
	 * 세션값 가져오기
	 *
	 * @retrun array
	 */	
	public function get_sess_info()
	{
		$_param = array();

		$this->_ci->load->library('encrypt');		
		
		   	
		$_param['tntnhan_r_id'] 					= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_id') );
		$_param['tntnhan_r_pw']					= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_pw') );		
		$_param['tntnhan_r_pw_confirm'] 	= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_pw_confirm') );		
		
		$_param['tntnhan_r_dummy'] 			= $this->_ci->session->userdata('tntnhan_r_dummy');
		$_param['tntnhan_r_login_yn'] 			= $this->_ci->session->userdata('tntnhan_r_login_yn');
						
		$_param['tntnhan_r_gb'] 					= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_gb') );	   
	   $_param['tntnhan_r_cust_post_no'] 	= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_cust_post_no') );
	   $_param['tntnhan_r_grade'] 				= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_grade') );
	   $_param['tntnhan_r_ip'] 					= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_ip') );
	   $_param['tntnhan_r_time'] 				= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_time') );
	   $_param['tntnhan_r_site_id'] 				= $this->_ci->encrypt->aes_decrypt( $this->_ci->session->userdata('tntnhan_r_site_id') );
	      
	   return $_param;
	}

	/**
	 * tntnhan_r_id 세션값 가져오기
	 *
	 * @retrun tntnhan_r_id
	 */	
	public function get_sess_tntnhan_r_id()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_id'];
	}
	
	/**
	 * tntnhan_r_pw 세션값 가져오기
	 *
	 * @retrun tntnhan_r_pw
	 */	
	public function get_sess_tntnhan_r_pw()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_pw'];
	}	

	/**
	 * tntnhan_r_pw_confirm 세션값 가져오기
	 *
	 * @retrun tntnhan_r_pw_confirm
	 */	
	public function get_sess_tntnhan_r_pw_confirm()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_pw_confirm'];
	}	

	/**
	 * tntnhan_r_dummy 세션값 가져오기
	 *
	 * @retrun tntnhan_r_dummy
	 */	
	public function get_sess_tntnhan_r_dummy()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_dummy'];
	}	

	/**
	 * tntnhan_r_login_yn 세션값 가져오기
	 *
	 * @retrun tntnhan_r_login_yn
	 */	
	public function get_sess_tntnhan_r_login_yn()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_login_yn'];
	}	

	/**
	 * tntnhan_r_gb 세션값 가져오기
	 *
	 * @retrun tntnhan_r_gb
	 */	
	public function get_sess_tntnhan_r_gb()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_gb'];
	}	

	/**
	 * tntnhan_r_cust_post_no 세션값 가져오기
	 *
	 * @retrun tntnhan_r_cust_post_no
	 */	
	public function get_sess_tntnhan_r_cust_post_no()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_cust_post_no'];
	}	
	
	/**
	 * tntnhan_r_grade 세션값 가져오기
	 *
	 * @retrun tntnhan_r_grade
	 */	
	public function get_sess_tntnhan_r_grade()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_grade'];
	}	
	
	/**
	 * tntnhan_r_ip 세션값 가져오기
	 *
	 * @retrun tntnhan_r_ip
	 */	
	public function get_sess_tntnhan_r_ip()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_ip'];
	}	
	
	/**
	 * tntnhan_r_time 세션값 가져오기
	 *
	 * @retrun tntnhan_r_time
	 */	
	public function get_sess_tntnhan_r_time()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_time'];
	}	
	
	/**
	 * tntnhan_r_site_id 세션값 가져오기
	 *
	 * @retrun tntnhan_r_site_id
	 */	
	public function get_sess_tntnhan_r_site_id()
	{		
		// 세션값 가져오기
		$_param = $this->get_sess_info();
				
	   return $_param['tntnhan_r_site_id'];
	}	

   /**
	 * 조건 세션 값 초기화 
	 *
	 * @param
	 *
	 * @retrun
	 
	public function set_init_condition()
	{
		// 세션 초기화
		$sess_data = array();
		$sess_data['sDy'] = '';
		$sess_data['eDy'] = '';
		$sess_data['sort_gb'] = '';
		$sess_data['offset'] = '';
		$sess_data['ord_sts_cd'] = '';
		$sess_data['ord_dtl_proc_sts_cd'] = '';
		$sess_data['ord_dtl_sts_cd'] = '';
		$sess_data['ord_web_cd'] = '';
		$sess_data['selectSchFlag'] = '';
		$sess_data['schKeyWord'] = '';		
		$sess_data['mappingYn'] = '';		
		$sess_data['multiPackingYn'] = '';
		
		$this->_ci->session->set_userdata($sess_data);
		
		return true;
	} 
	*/	

}