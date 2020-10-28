<?php

class Quick extends MY_Controller
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

	}

	 
	public function page_post()
	{
		$param = $this->input->post();

		$this->load->library('quick_lib');
//var_dump($param['type']);

error_reporting(E_ALL);
ini_set('display_errors', 1);
		if($param['type'] == 'C'){
			$result =  $this->quick_lib->get_quick_cart($param['page']);
		}else if($param['type'] == 'W'){
			$result =  $this->quick_lib->get_quick_wish($param['page']);
		}else if($param['type'] == 'V'){
			$result =  $this->quick_lib->get_quick_view($param['page']);
		}

//		if($param['type'] == 'C'){
//			$result = $this->quick_lib->get_quick_layer($param['page']);
//		}else($param['type'] == 'W'){
//			$result = $this->quick_lib->get_quick_layer($param['page']);
//		}else($param['type'] == 'V'){
//			$result = $this->quick_lib->get_quick_layer($param['page']);
//		}


		/**
		 * 퀵 레이아웃
		 */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();
//		var_dump($result);

		$this->response(array('status' => 'ok', 'result'=> $result), 200);
	}
}
?>