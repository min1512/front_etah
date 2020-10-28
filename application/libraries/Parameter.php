<?php
/**
 * Created by Parameter.php.
 * User: jemoonjong
 * Date: 2014. 1. 20.
 * Time: 오후 2:34
 * To change this template use File | Settings | File Templates.
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parameter {

	protected $_ci;

	public function __construct()
	{
		$this->_ci =& get_instance();
	}

	/**
	 * 파라메타값 검증 모듈
	 *
	 * @param array $key
	 */
	public function check($key = array(), &$error = null)
	{
		$method = strtolower($this->_ci->input->server('REQUEST_METHOD', ));

		$result = array();
		$param_key = '';		//잘못된 key값 문자열로 저장
		$param_val = '';		//잘못된 value값 문자열로 저장

		foreach($key as $k => $v)
		{
			if(is_array($v))
			{

				if( ! in_array($this->_ci->{$method}($k), $v)) {
					$param_key .= $k.",";
					if(isset($error)) $error[$k] = trim($this->_ci->{$method}($k, FALSE));
				}
				else {
					$result[$k] = trim($this->_ci->{$method}($k, FALSE));
				}

			}
			else {
				if($v) {
					if($this->_ci->{$method}($k) == '') {
						$param_val .= $k.",";
						if(isset($error)) $error[$k] = trim($this->_ci->{$method}($k));
					}
					else {
						$result[$k] = trim($this->_ci->{$method}($k, FALSE));
					}
				}
				else {
					$result[$k] = trim($this->_ci->{$method}($k, FALSE));
				}
			}
		}

		/* 파라메타 키값 에러시 */
		if( ! empty($param_key) ) {
			if( isset($error) ) return $result;
			else $this->_ci->response(array('error' => lang('E_9002').'['.$param_key.']'), 403);
		}

		/* 파라메타 키의 값 에러시 */
		if( ! empty($param_val) ) {
			if( isset($error) ) return $result;
			else $this->_ci->response(array('error' => lang('E_9001').'['.$param_val.']'), 403);
		}


		return $result;
	}





}