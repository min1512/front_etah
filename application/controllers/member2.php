<?php

class Member2 extends MY_Controller
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

	/** 상품상세 -> 비회원 로그인 페이지로 이동시 변수 이동 **/
	public function Guestlogin_post()
	{
		$param = $this->input->post();

		self::login_get($param);
	}

	/**
	 * 로그인
	 */
	 public function login_get()
	{
		//비회원 로그인 경우 파라미터 가져옴
		$param = $this->input->post();

		//로그인 상태에서는 로그인 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_')){
			if(isset($_GET['return_url'])){
				redirect($_GET['return_url'], 'refresh');
			} else{
				redirect('/', 'refresh');
			}
		}

		$returnUrl = ($this->agent->is_referral()) ? $this->agent->referrer() : '/';
		if(preg_match('/member\/login/i', $returnUrl)) {
			$returnUrl = '/';
		}

		if(strpos($returnUrl,'join_finish')){
			$returnUrl	= '/';
		}

		if(isset($_GET['return_url'])){
			$returnUrl = $_GET['return_url'];
		}

		$data['returnUrl'] = $returnUrl;

		if(isset($param)){
			var_dump($param);
				$data['param'				] = $param;
				$data['guest_gb'			] = $param['guest_gb'];
			for($i=0; $i<count($param['goods_option_code']); $i++){
				$data['goods_code'				][$i] = $param['goods_code'];
				$data['goods_cnt'				][$i] = $param['goods_cnt'][$i];
				$data['goods_option_code'		][$i] = $param['goods_option_code'][$i];
				$data['goods_option_name'		][$i] = $param['goods_option_name'][$i];
				$data['goods_option_add_price'	][$i] = $param['goods_option_add_price'][$i];
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
		$this->load->view('member/member_login2', $data);
		$this->load->view('include/footer');
	}

	/**
	 * 회원 로그인 세션 모듈
	 */
	 public function login_post()
	{
		 $param = $this->input->post();

		 $param = str_replace("\\","\\\\",$param);
		 $param = str_replace("'","\'",$param);
		 $param = str_replace("\n","<br />",$param);

		 $mem_id = strtolower($param['mem_id']);
		 $mem_pwd = $param['mem_password'];

		 //Load MODEL
		 $this->load->model('member_m');

		 //회원 정보 구하기
		 if($param['login_gb'] == 'id'){
			 $Member = $this->member_m->get_member_info_pw1($mem_id, $mem_pwd);
			 if( empty($Member) ) $this->response(array('status'=>'error', 'message'=>'일치하는 회원데이터가 없습니다.'), 200);
		 } else if($param['login_gb'] == 'email'){
			 $Member = $this->member_m->get_member_info_pw2($mem_id, $mem_pwd);
			 if( empty($Member) ) $this->response(array('status'=>'error', 'message'=>'일치하는 회원데이터가 없습니다.'), 200);
		 }

		 //로그인 세션 만들기
		 $this->load->library('encrypt');

		 $dummy = date("d").$mem_id.date("y").$this->input->server('REMOTE_ADDR');
		 $sess_data = array(
			'EMS_U_NO_'			=>	$Member['CUST_NO'],
			'EMS_U_ID_'			=>	$Member['CUST_ID'],
			'EMS_U_PWD_'		=>	$this->encrypt->aes_encrypt($mem_pwd),
			'EMS_U_PWD2_'		=>	'',
			'EMS_U_GRADE_'		=>	$this->encrypt->aes_encrypt($Member['CUST_LEVEL_CD']),
			'EMS_U_DUMMY_'		=>	md5($dummy),
			'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
			'EMS_U_TIME_'		=>	time(),
			'EMS_U_NAME_'		=>	$Member['CUST_NM'],
			'EMS_U_EMAIL_'		=>	$Member['EMAIL'],
			'EMS_U_MOB_'		=>	$Member['MOB_NO'],
			'EMS_U_SITE_ID_'	=>	'ETAH'
		 );
		 $this->session->set_userdata($sess_data);

		 $AccessLog = $this->member_m->regist_login_log($Member);

		 $this->response(array('status' => 'ok', 'mem_id' => $mem_id), 200);
	}

	/**
	 * 비회원 로그인 세션 모듈
	 */
	 public function guest_login_post()
	{
		 $param = $this->input->post();
		 $mem_id = 'GUEST';

		 //Load MODEL
		 $this->load->model('member_m');

		 //비회원 로그인이 가능한지 여부 확인
		 $Exists_guest = $this->member_m->check_guest_login($param);

		 if(!$Exists_guest){
			 $this->response(array('status' => 'error', 'message' => '해당하는 정보가 없습니다.'), 200);
		 }

		 //로그인 세션 만들기
		 $this->load->library('encrypt');

		 $dummy = date("d").$mem_id.date("y").$this->input->server('REMOTE_ADDR');
		 $sess_data = array(
			'EMS_U_NO_'			=>	$param['order_no'],
			'EMS_U_ID_'			=>	$mem_id,
			'EMS_U_PWD_'		=>	'',
			'EMS_U_PWD2_'		=>	'',
			'EMS_U_GRADE_'		=>	'',
			'EMS_U_DUMMY_'		=>	md5($dummy),
			'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
			'EMS_U_TIME_'		=>	time(),
			'EMS_U_NAME_'		=>	$param['order_name'],
			'EMS_U_EMAIL_'		=>	'',
			'EMS_U_SITE_ID_'	=>	'ETAH'
		 );
		 $this->session->set_userdata($sess_data);

//		 $AccessLog = $this->member_m->regist_login_log($Member);

		 $this->response(array('status' => 'ok', 'mem_id' => $mem_id), 200);
	}

	/**
	 * 로그아웃 모듈
	 */
	 public function logout_get()
	{
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}

	/**
	 * 회원가입
	 */
	 public function member_join_get()
	{
		//비회원 로그인시 세션 날리기
		if($this->session->userdata('EMS_U_ID_') == 'GUEST'){
			$this->session->sess_destroy();
		}

		//로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		//이용약관
		$data['clause'] = $this->load->view('template/clause/clause_1.php', '', TRUE);

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
		$this->load->view('member/member_join', $data);
		$this->load->view('include/footer');
	}

	/**
	 * 회원 아이디 중복 검사 모듈
	 */
	 public function id_check_post()
	{
		$param = $this->input->post();
		$mem_id = strtolower($param['mem_id']);

		//사용불가능 아이디검사
		$limitId = array('root','daemon','sync','shutdown','halt','mail','news','uucp','operator','games','gopher','nobody','vcsa','mailnull','rpcuser','nfsnobody','nscd','ident','radvd','named','pcap','mysql','postgres','oracle','administrator','master','webmaster','operator','admin','sysadmin','system','test','guest','anonymous','sysop','moderator','babara','okcashbag','boradori','assajapan');
		if(in_array($mem_id, $limitId)) {
			$this->response(array('status'=>'error', 'message'=>'사용할 수 없는 아이디입니다.'), 200);
		}

		//Load MODEL
		$this->load->model('member_m');

		//회원 정보 데이타 구하기
		$row = $this->member_m->get_member_info_id($mem_id);
		if( ! empty($row) ) {
			$this->response(array('status'=>'error', 'message'=>'이미 사용중인 아이디입니다.'), 200);
		}
		else {
			$this->response(array('status' => 'ok', 'mem_id' => $mem_id), 200);
		}
	}

	/**
	 * 회원 이메일 중복 검사 & 인증번호 생성 모듈
	 */
	 public function email_check_post()
	{
		$param = $this->input->post();
		$mem_email = $param['mem_email'];

		//Load MODEL
		$this->load->model('member_m');

		//회원 정보 데이타 구하기
		$row = $this->member_m->get_member_info_email($mem_email);
		if( ! empty($row) ) {
			$this->response(array('status'=>'error', 'message'=>'이미 사용중인 이메일입니다.'), 200);
		}
		else {
			//이메일 인증코드 생성
			$cal_num = array(8,6,4,2,3,5,9,7);
			$tmp_auth	 = "";
			$tmp_authchr = "";
			$tmp_authnum = array();

			for($i=0; $i<8; $i++){	//난수 8자리 생성
				mt_srand((double)microtime()*1000000);
				$tmp_authnum[$i] = mt_rand(0,9);
				$tmp_auth .= $tmp_authnum[$i];
			}

			//CHECK DIGIT 값 구하기
			for($i=0; $i<8; $i++){		//STEP 01
				$digit_1[$i] = $cal_num[$i] * $tmp_authnum[$i];
			}

			$digit_2 = array_sum($digit_1);			//STEP 02
			$digit_3 = ( $digit_2 - ($digit_2 % 11)) / 11;		//STEP 03
			$digit_4 = ceil( $digit_2 % 11 );		//STEP 04
			$digit_5 = $digit_3 - $digit_4;			//STEP 05 :: 최종 DIGIT 값

			if($digit_5 >= 10){
				$chk_digit01 = substr($digit_5,0,1);
				$chk_digit02 = substr($digit_5,1,1);
			} else {
				$chk_digit01 = "0";
				$chk_digit02 = $digit_5;
			}

			for($i=0; $i<3; $i++){		//알파벳 난수 3자리 생성
				mt_srand((double)microtime()*1000000);
				$tmp_authchr .= substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0,51), 1);
			}

			$tmp_authcode = $tmp_authchr.$tmp_auth.$chk_digit01.$chk_digit02;			//최종 인증코드값

			//이메일 인증 메일 발송
			$mailParam["kind"		] = "email_auth";
			$mailParam["tmp_code"	] = $tmp_authcode;
			$mailParam["mem_email"	] = $mem_email;
			self::_background_send_mail($mailParam);

			$cur_date = date("Y-m-d H:i:s");

			$email_cert = $this->member_m->regist_email_cert($mem_email, $tmp_authcode, $cur_date);		//이메일 인증 테이블에 insert

			$this->response(array('status' => 'ok', 'mem_email' => $mem_email, 'auth_code' => $tmp_authcode), 200);
		}
	}

	/**
	 * 회원 이메일 인증번호 확인 모듈
	 */
	 public function email_auth_check_post()
	{
		 $param = $this->input->post();

		 $auth_code = $param['auth_code'];
		 $chk_digit = substr($auth_code,11,2);		//CHECK DIGIT값

		 //비교를 위한 값 설정
		 $tmp_authnum = array();
		 for($i=0; $i<8; $i++){
			 $tmp_authnum[$i] = substr($auth_code,$i+3,1);
		 }

		 //CHECK DIGIT 값 확인하기
		 $cal_num = array(8,6,4,2,3,5,9,7);

		 for($i=0; $i<8; $i++){		//STEP 01
			 $digit_1[$i] = $cal_num[$i] * $tmp_authnum[$i];
		 }

		 $digit_2 = array_sum($digit_1);		//STEP 02
		 $digit_3 = ( $digit_2 - ($digit_2 % 11)) / 11;		//STEP 03
		 $digit_4 = ceil( $digit_2 % 11 );		//STEP 04
		 $digit_5 = $digit_3 - $digit_4;		//STEP 05 :: 최종 DIGIT 값

		 //Load MODEL
		 $this->load->model('member_m');

		 if($digit_5 != $chk_digit){
			 $email_cert = $this->member_m->update_email_cert($param['mem_email'], $auth_code, $cur_date, 'ERR');		//이메일 인증 update

			 $this->response(array('status' => 'error', 'message'=>'CHECK DIGIT값이 일치하지 않습니다.'), 200);
		 }

		 $cur_date = date("Y-m-d H:i:s");
		 $email_cert = $this->member_m->update_email_cert($param['mem_email'], $auth_code, $cur_date, 'SUC');		//이메일 인증 update

		 $this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 회원가입
	 */
	 public function join_post()
	{
		 $param = $this->input->post();

		 //Load MODEL
		 $this->load->model('member_m');

		 if(!$param['mem_birth1']){		//생년월일 입력 안했을 경우
			 $param['mem_birth'] = 'N';
		 } else {
			 $param['mem_birth'] = $param['mem_birth1'].$param['mem_birth2'].$param['mem_birth3'];
		 }

		 if(!isset($param['mem_gender'])){	//성별 선택 안했을 경우
			 $param['mem_gender'] = 'N';
		 }

		 if(!isset($param['Agree_yn'])){	//수신동의 선택 안했을 경우
			 $param['Agree_yn'] = 'N';
		 }

		 $mem_mobile_no = $param['mem_mobile1']."-".$param['mem_mobile2']."-".$param['mem_mobile3'];

		 $exists_member = $this->member_m->get_member_info_mobile($mem_mobile_no);

		 if( ! empty($exists_member) ) {
			$this->response(array('status'=>'error', 'message'=>'이미 사용중인 휴대폰번호입니다.'), 200);
		 }
//var_dump($param);
		 //회원가입
		 $this->member_m->regist_member($param);

		 //회원가입 완료 이메일 메일 발송
		 $mailParam["kind"		] = "join";
		 $mailParam["mem_id"	] = $param['mem_id'];
		 $mailParam["mem_email"	] = $param['chk_email'];
		 $mailParam["mem_name"	] = $param['mem_name'];
		 self::_background_send_mail($mailParam);

		 $this->response(array('status'=>'ok'), 200);
	}

	/**
	 * 회원가입 완료
	 */
	 public function join_finish_post()
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
		$this->load->view('member/member_join_finish');
		$this->load->view('include/footer');
	}


	/**
	 * 메일 작성
	 */
	private function _background_send_mail($param)
	{
		set_time_limit(0);

		$this->load->helper('url');
		$url = site_url("/member/background_send_mail");

		$type = "POST";

		foreach ($param as $key => &$val) {
			if (is_array($val)) $val = implode(',', $val);
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
		set_time_limit(0);

        $param = $this->post();

		$this->load->helper('string');
		$this->load->library('email');

		$body = self::_mail_template($param['kind']); //메일 템플릿 가져오기

        //이메일 인증
        if($param['kind'] == "email_auth"){
            $subject = "ETAHOME 회원가입 인증 메일입니다.";

            $body = str_replace("{{mem_id}}"    , $param['mem_email']	, $body);
            $body = str_replace("{{auth_code}}" , $param['tmp_code'	]	, $body);
            $body = str_replace("{{join_date}}" , date('Y-m-d')			, $body);
        }
		//회원가입 메일 발송
		else if($param['kind'] == "join"){
			$subject = "회원가입을 축하드립니다!";

			$body = str_replace("{{mem_id}}"    , $param['mem_id'	]	, $body);
            $body = str_replace("{{mem_email}}" , $param['mem_email']	, $body);
			$body = str_replace("{{mem_name}}"	, $param['mem_name'	]	, $body);
            $body = str_replace("{{join_date}}" , date('Y-m-d')			, $body);
		}
        //임시비밀번호 메일 발송
        else if($param['kind'] == "id_pass"){
            $subject = "ETAHOME 비밀번호 재설정을 위한 임시비밀번호 발급 메일입니다.";

            $body = str_replace("{{mem_id}}"    , $param['mem_id'       ]   , $body);
			$body = str_replace("{{mem_name}}"	, $param['mem_name'		]	, $body);
            $body = str_replace("{{mem_pw}}"    , $param['tmp_password'	]   , $body);
            $body = str_replace("{{reg_date}}"  , $param['mem_regdate'  ]   , $body);
            $body = str_replace("{{homepage}}"  , config_item('url')        , $body);
        }

        $receive = $param['mem_email'];

		$this->email->sendmail($receive, $subject, $body, 'info@etah.co.kr', 'ETA HOME');
	}

	/**
	 * 메일 템플릿 가져오기
	 */
	private function _mail_template($type = 'join')
	{
		$body = $this->load->view('template/email/'.$type.'/email_body.php', '', TRUE);

		return $body;
	}

	/**
	 * 회원탈퇴
	 */
	 public function leave_get()
	{
		//load model
		$this->load->model('mywiz_m');

		$data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
		$data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
		$data['nav'			] = "ML";
		$data['cancel_apply'] = "";

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
		$this->load->view('include/mypage_nav', $data);
		$this->load->view('member/member_leave');
		$this->load->view('include/layout');
		$this->load->view('include/footer');

	}

	/**
	 * 회원탈퇴
	 */
	 public function leave_post()
	{
		//Load MODEL
		$this->load->model('member_m');

		$param = $this->input->post();

		if(!$this->member_m->regist_member_leave($param)) $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
		if(!$this->member_m->update_useyn($param)) $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);

		$this->response(array('status'=>'ok'), 200);
	}

	/**
	 * 회원탈퇴 완료
	 */
	 public function leave_finish_get()
	{
	 	$this->session->sess_destroy();

		$this->load->model('mywiz_m');

		$data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
		$data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
		$data['nav'			] = "ML";
		$data['cancel_apply'] = "";

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
		$this->load->view('include/mypage_nav', $data);
		$this->load->view('member/member_leave_finish');
		$this->load->view('include/layout');
		$this->load->view('include/footer');

	}

	/**
	 * ID찾기
	 */
	 public function id_search_get()
	{
		 //로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		$data['type'	] = 'id';
		$data['title'	] = '아이디 찾기';

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		$this->load->view('include/header', $data);
		$this->load->view('member/member_search');
		$this->load->view('include/footer');

	}

	/**
	 * ID찾기
	 */
	 public function password_search_get()
	{
		 //로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		$data['type'	] = 'password';
		$data['title'	] = '비밀번호 찾기';

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		$this->load->view('include/header', $data);
		$this->load->view('member/member_search');
		$this->load->view('include/footer');

	}

	/**
	 * 비밀번호 찾기
	 */
	 public function search_member_post()
	{
		$this->load->model('member_m');

		$param = $this->input->post();

		if(!$member = $this->member_m->get_search_member($param)) $this->response(array('status'=>'error', 'message'=>'일치하는 회원정보가 없습니다.'), 200);

		if($param['type'] == 'password'){
			//임시패스워드 세팅
			$tmp_password = "";
			for($i=0; $i<10; $i++){
				mt_srand((double)microtime()*1000000);
				$tmp_password .= substr("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0,61), 1);
			}

//			$tmp_password = "test1234";
			if(!$this->member_m->update_temp_password($param, $tmp_password)) $this->response(array('status'=>'error', 'message'=>'error'), 200);


		//임시 비밀번호 메일 발송
		$mailParam["kind"			] = "id_pass";
		$mailParam["mem_id"			] = $member['CUST_ID'];
		$mailParam["mem_name"		] = $member['CUST_NM'];
		$mailParam["tmp_password"	] = $tmp_password;
		$mailParam["mem_email"		] = $member['EMAIL'];
		$mailParam["mem_regdate"	] = $member['REG_DT'];
		self::_background_send_mail($mailParam);
		}
		$this->response(array('status'=>'ok', 'member'=>$member), 200);
	}

	/**
	 * 비밀번호 찾기 완료
	 */
	 public function search_finish_post()
	{
		 //로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		$data['member'] = $this->input->post();
//var_dump($data['member']);
		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];

		$this->load->view('include/header', $data);
		$this->load->view('member/member_search_finish');
//		$this->load->view('include/layout');
		$this->load->view('include/footer');

	}




}