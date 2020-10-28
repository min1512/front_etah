<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: jemoonjong
 * Date: 13. 2. 13.
 * Time: 오후 4:42
 * To change this template use File | Settings | File Templates.
 */

class MY_Encrypt extends CI_Encrypt {
	protected $_ci;
	protected $key;
	protected $iv;

	function __construct()
	{
		parent::__construct();
		$this->_ci =& get_instance();

		$this->key = md5(config_item('aes_key'), TRUE);
		$this->iv = config_item('aes_iv');
	}


	/**
	 * MY_Encrypt::ssl_encrypted()
	 *
	 * 사용자마다의 데이타 전송 암호화 모듈
	 *
	 * @param $uid
	 * @param $data
	 *
	 * @return array
	 */
	public function ssl_encrypted($uid, $data)
	{
		$result = array();

		$this->_ci->load->helper('string');
		//$aes_key = random_string('unique');
		$aes_key = substr(random_string('unique'),0,32);
		$aes_iv = substr(random_string('unique'),16,16);

		/* 사용자 고유 Public KEY */
		$user_public_key = $this->_ssl_user_public_key($uid);

		/* 고유 Public Key를 이용하여 AES KEY를 암호화 시킴 */
		$result['aes_key'] = urlencode(base64_encode($this->_ssl_encrypt($aes_key.$aes_iv, $user_public_key)));

		/* 전송할 데이타를 AES 키를 이용하여 암호화 시킴 */
		$result['data'] = urlencode(base64_encode($this->aes_encrypt($data, $aes_key, $aes_iv)));

		return $result;
	}




	public function device_ssl_encrypted($device_key, $data)
	{
		$result = array();

		$this->_ci->load->helper('string');
		//$aes_key = random_string('unique');
		$aes_key = substr(random_string('unique'),0,32);
		$aes_iv = substr(random_string('unique'),16,16);

		/* 디바이스에서 넘어온 고유 Public KEY */
		//CI에서 SQL인젝션때문에 +를 공백처리함으로 다시 공백을 +로 변경
		$public_key = str_replace(' ','+',$device_key);
		$public_key = str_replace('-----BEGIN+PUBLIC+KEY-----','-----BEGIN PUBLIC KEY-----',$public_key);
		$public_key = str_replace('-----END+PUBLIC+KEY-----','-----END PUBLIC KEY-----',$public_key);
		$user_public_key = openssl_pkey_get_public($public_key);

		/* 고유 Public Key를 이용하여 AES KEY를 암호화 시킴 */
		$result['aes_key'] = urlencode(base64_encode($this->_ssl_encrypt($aes_key.$aes_iv, $user_public_key)));

		/* 전송할 데이타를 AES 키를 이용하여 암호화 시킴 */
		$result['data'] = urlencode(base64_encode($this->aes_encrypt($data, $aes_key, $aes_iv)));

		return $result;
	}


	/**
	 * MY_Encrypt::default_ssl_decrypted()
	 *
	 * 기본 RSA키로 복화화 시킴
	 *
	 * @param $args
	 *
	 * @return string
	 */
	public function default_ssl_decrypted($args)
	{
		$args = urldecode($args);

		$private_key_file = config_item('ssl_private_key');
		$rsa_pri_key = openssl_pkey_get_private(@file_get_contents($private_key_file));

		return $this->_ssl_decrypt($args, $rsa_pri_key);
	}


	/**
	 * MY_Encrypt::user_ssl_decrypted()
	 *
	 * 사용자고유 RSA키로 복화화 시킴
	 *
	 * @param $args
	 * @param $uid
	 *
	 * @return string
	 */
	public function user_ssl_decrypted($args, $uid = '')
	{
		$args = urldecode($args);

		/* 데이타베이스 연결 */
		$this->_ci->load->helper('array');
		$database = random_element(config_item('slave'));
		$db = $this->_ci->load->database($database,TRUE);

		if($uid) {
			$split_uid = explode("|", $uid);
			if(empty($split_uid[1])) return FALSE;
			$uid_site_id = $split_uid[0].$split_uid[1];
			$row = $db->where('concat(uid,site_id)', $uid_site_id)->get('tbl_user_rsa')->row();
		}
		else {
			$row = '';
		}

		if( ! empty($row) && ! empty($row->server_private_key))
		{
			//CI에서 SQL인젝션때문에 +를 공백처리함으로 다시 공백을 +로 변경
			$private_key_file = str_replace(' ','+',$row->server_private_key);
			$private_key_file = str_replace('-----BEGIN+PRIVATE+KEY-----','-----BEGIN PRIVATE KEY-----',$private_key_file);
			$private_key_file = str_replace('-----END+PRIVATE+KEY-----','-----END PRIVATE KEY-----',$private_key_file);

			//추가
			//서버에서 RSA키 생성시 RSA 키워드가 존재할수도 있음.
			$private_key_file = str_replace('-----BEGIN+RSA+PRIVATE+KEY-----','-----BEGIN RSA PRIVATE KEY-----',$private_key_file);
			$private_key_file = str_replace('-----END+RSA+PRIVATE+KEY-----','-----END RSA PRIVATE KEY-----',$private_key_file);

			/*log_message("error", "----------- RSA PRIVATE KEY start -----------");
			log_message('error', $private_key_file);
			log_message("error", "----------- RSA PRIVATE KEY start -----------");*/

			$rsa_pri_key = openssl_pkey_get_private($private_key_file);
		}
		else
		{
			$private_key_file = config_item('ssl_private_key');
			$rsa_pri_key = openssl_pkey_get_private(@file_get_contents($private_key_file));
		}

		return $this->_ssl_decrypt($args, $rsa_pri_key);
	}


	/**
	 * MY_Encrypt::aes_decrypt()
	 *
	 * AES 복호화 모듈
	 *
	 * @param $encrypt
	 *
	 * @return mixed
	 */
	public function aes_decrypt($encrypt)
	{
		/* 아래의 코드를 넣으면 디코딩이 안됨 
		$encrypt = urldecode($encrypt);
		*/
						
		$this->_ci->load->helper('aes_encryption');
		$aes = new AES_Encryption();
		$aes->init($this->key, $this->iv, 'PKCS7', 'cbc');

		$decrypt_txt = base64_decode($encrypt);
		$decrypted = $aes->decrypt($decrypt_txt);

		$aes->end();

		return $decrypted;
	}


	/**
	 * MY_Encrypt::aes_encrypt()
	 *
	 * AES 암호화 모듈
	 *
	 * @param $decrypt
	 *
	 * @return string
	 */
	public function aes_encrypt($decrypt)
	{
		$this->_ci->load->helper('aes_encryption');
		$aes = new AES_Encryption();
		$aes->init($this->key, $this->iv, 'PKCS7', 'cbc');

		$encrypted = base64_encode($aes->encrypt($decrypt));

		$aes->end();

		return $encrypted;
	}



	/**
	 * MY_Encrypt::create_certificate()
	 *
	 * 사용자마다의 고유 RSA키 만들기
	 *
	 * @return array
	 */
	public function create_certificate()
	{
		// generate private key
		$rsaKey = openssl_pkey_new(array(
			'private_key_bits' => 2048,
			'private_key_type' => OPENSSL_KEYTYPE_RSA));

		// convert public key to OpenSSH format
		$privKey = openssl_pkey_get_private($rsaKey);
		openssl_pkey_export($privKey, $pem); //Private Key
		$publicKey = openssl_pkey_get_details($privKey);

		$rsa = array();
		$rsa['public_key'] = trim($publicKey['key']);
		$rsa['private_key'] = trim($pem);

		return $rsa;
	}


	/**
	 * 고객사 파라메타 RSA 암호화 모듈
	 *
	 * @param $site_id
	 * @param $data
	 *
	 * @return string
	 */
	public function custom_ssl_encrypted($site_id, $data)
	{
		if(read_file(APPPATH.'libraries/custom_module/'.$site_id.'/public_key.pem')){
			$user_public_key = openssl_pkey_get_public(@file_get_contents(APPPATH.'libraries/custom_module/'.$site_id.'/public_key.pem'));
		}else{
			/* 기본 모듈 호출 */
			$user_public_key = openssl_pkey_get_public(@file_get_contents(APPPATH.'libraries/custom_module/default_public_key.pem'));
		}

		/* 고유 Public Key를 이용하여 data를 암호화 시킴 */
		$result = urlencode(base64_encode($this->_ssl_encrypt($data, $user_public_key)));

		return $result;
	}


	/**
	 * 고객사 파라메타 RSA 복호화 모듈
	 *
	 * @param $site_id
	 * @param $data
	 *
	 * @return string
	 */
	public function custom_ssl_decrypted($site_id, $data)
	{
		//$data = urldecode($data);

		if(read_file(APPPATH.'libraries/custom_module/'.$site_id.'/private_key.pem')){
			$rsa_pri_key = openssl_pkey_get_private(@file_get_contents(APPPATH.'libraries/custom_module/'.$site_id.'/private_key.pem'));
		}else{
			/* 기본 모듈 호출 */
			$rsa_pri_key = openssl_pkey_get_private(@file_get_contents(APPPATH.'libraries/custom_module/default_private_key.pem'));
		}

		return $this->_ssl_decrypt($data, $rsa_pri_key);
	}


	/**
	 * private key 암호화 모듈
	 *
	 * @param $site_id
	 * @param $data
	 *
	 * @return string
	 */
	public function custom_ssl_pri_encrypted($site_id, $data)
	{
		if(read_file(APPPATH.'libraries/custom_module/'.$site_id.'/private_key.pem')){
			$user_private_key = openssl_pkey_get_private(@file_get_contents(APPPATH.'libraries/custom_module/'.$site_id.'/private_key.pem'));
		}else{
			/* 기본 모듈 호출 */
			$user_private_key = openssl_pkey_get_private(@file_get_contents(APPPATH.'libraries/custom_module/default_private_key.pem'));
		}

		/* 고유 Public Key를 이용하여 data를 암호화 시킴 */
		$result = urlencode(base64_encode($this->_ssl_pri_encrypt($data, $user_private_key)));

		return $result;
	}


	/**
	 * public key 복호화 모듈
	 *
	 * @param $site_id
	 * @param $data
	 *
	 * @return string
	 */
	public function custom_ssl_pub_decrypted($site_id, $data)
	{
		$data = urldecode($data);

		if(read_file(APPPATH.'libraries/custom_module/'.$site_id.'/public_key.pem')){
			$rsa_pub_key = openssl_pkey_get_public(@file_get_contents(APPPATH.'libraries/custom_module/'.$site_id.'/public_key.pem'));
		}else{
			/* 기본 모듈 호출 */
			$rsa_pub_key = openssl_pkey_get_public(@file_get_contents(APPPATH.'libraries/custom_module/default_public_key.pem'));
		}

		return $this->_ssl_pub_decrypt($data, $rsa_pub_key);
	}



	/**
	 * MY_Encrypt::_ssl_decrypt()
	 *
	 * RSA 복호화 모듈
	 *
	 * @param $args
	 * @param $pri_key
	 *
	 * @return string
	 */
	private function _ssl_decrypt($args, $pri_key)
	{
		$decrypt_text = '';
		$args = base64_decode($args);

		@openssl_private_decrypt($args, $decrypt_text, $pri_key);
		@openssl_free_key($pri_key);

		return $decrypt_text;
	}


	/**
	 * MY_Encrypt::_ssl_encrypt()
	 *
	 * RSA 암호화 모듈
	 *
	 * @param $str
	 * @param $pub_key
	 *
	 * @return string
	 */
	private function _ssl_encrypt($str, $pub_key)
	{
		$encrypt_text = '';
		@openssl_public_encrypt($str, $encrypt_text, $pub_key);
		@openssl_free_key($pub_key);

		return $encrypt_text;
	}


	/**
	 * private key로 암호화 리턴
	 *
	 * @param $str
	 * @param $pri_key
	 *
	 * @return string
	 */
	private function _ssl_pri_encrypt($str, $pri_key)
	{
		$encrypt_text = '';
		@openssl_private_encrypt($str, $encrypt_text, $pri_key);
		@openssl_free_key($pri_key);

		return $encrypt_text;
	}

	/**
	 * public key로 복호화 리턴
	 *
	 * @param $args
	 * @param $pub_key
	 *
	 * @return string
	 */
	private function _ssl_pub_decrypt($args, $pub_key)
	{
		$decrypt_text = '';
		$args = base64_decode($args);

		@openssl_public_decrypt($args, $decrypt_text, $pub_key);
		@openssl_free_key($pub_key);

		return $decrypt_text;
	}


	/**
	 * 사용자 고유의 SSL키 값 구하기
	 *
	 * @param $uid
	 *
	 * @return resource
	 */
	private function _ssl_user_public_key($uid)
	{
		/* 데이타베이스 연결 */
		$this->_ci->load->helper('array');
		$database = random_element(config_item('slave'));
		$db = $this->_ci->load->database($database,TRUE);

		$row = $db->select('device_public_key')->where('concat(uid,site_id)', $uid)->get('tbl_user_rsa')->row_array();
		if(!empty($row) && ! empty($row['device_public_key']))
		{
			$public_key = $row['device_public_key'];
			//CI에서 SQL인젝션때문에 +를 공백처리함으로 다시 공백을 +로 변경
			$public_key = str_replace(' ','+',$public_key);
			$public_key = str_replace('-----BEGIN+PUBLIC+KEY-----','-----BEGIN PUBLIC KEY-----',$public_key);
			$public_key = str_replace('-----END+PUBLIC+KEY-----','-----END PUBLIC KEY-----',$public_key);

			$rsa_pub_key = openssl_pkey_get_public($public_key);
		}
		else
		{
			$public_key = config_item('ssl_public_key');
			$rsa_pub_key = openssl_pkey_get_public(@file_get_contents($public_key));
		}

		return $rsa_pub_key;
	}

}