<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mywiz2_m extends CI_Model {

	protected $_ci;
	protected $mdb;
	protected $sdb;

	public function __construct()
	{
		parent::__construct();
		$this->_ci =& get_instance();
	}

	private function _slave_db()
	{
		if( ! empty($this->sdb) ) return $this->sdb;

		/* 데이타베이스 연결 */
		$this->load->helper('array');
		$database = random_element(config_item('slave'));
		$this->sdb = $this->load->database($database,TRUE);

		return $this->sdb;
	}

	private function _master_db()
	{
		if( ! empty($this->mdb) ) return $this->mdb;

		/* 데이타베이스 연결 */
		$this->load->helper('array');
		$database = random_element(config_item('master'));
		$this->mdb = $this->load->database($database,TRUE);

		return $this->mdb;
	}

	/**
	 * 고객 상품평 등록
	 */
	 public function regist_comment($param)
	{
		$query = "
			insert into DAT_CUST_GOODS_COMMENT	(   /* etah_front > mywiz2_m > regist_comment > 고객 상품평 등록 */
				  GOODS_CD
				, CUST_NO
				, ORDER_REFER_NO
				, `CONTENTS`
				, GRADE_VAL
				, CUST_GOODS_COMMENT_REG_DT
			)
			values
			(
				  '".$param['goods_code']."'
				, '".$param['mem_no']."'
				, '".$param['order_refer_code']."'
				, '".$param['comment_contents']."'
				, '".$param['grade_val']."'
				, now()
			)
		";

		$db = self::_master_db();
		$result = $db->query($query);
		$rs_identity = $db->insert_id();

		return $rs_identity;
	}

	/**
	 * 고객 상품평을 등록하기 전에 해당 상품을 구매했는지 주문상세번호 가져오기
	 */
	 public function get_goods_order_refer($param)
	{
		$query = "
			select     /* etah_front > mywiz2_m > get_goods_order_refer > 상품구매했는지 체크 */
				r.ORDER_REFER_NO
			from
				DAT_ORDER		o
			inner join
				DAT_ORDER_REFER		r
			on r.ORDER_NO		= o.ORDER_NO
			inner join
				DAT_ORDER_REFER_PROGRESS		rp
			on  rp.ORDER_REFER_PROC_STS_NO	= r.ORDER_REFER_PROC_STS_NO
			-- and rp.ORDER_REFER_PROC_STS_NO	= 'OE02'

			where
				1 = 1
			and o.CUST_NO	= '".$param['mem_no']."'
			and r.GOODS_CD	= '".$param['goods_code']."'

			order by
				r.ORDER_REFER_NO	asc
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 해당 주문상세번호의 상품평을 등록한 적이 있는지 여부 확인
	 */
	public function get_exists_comment_order($param)
	{
		$query = "
			select    /* etah_front > mywiz2_m > get_exists_comment_order > 상품평을 등록한 적이 있는지 체크 */
				count(gc.CUST_GOODS_COMMENT)	as cnt
			from
				DAT_CUST_GOODS_COMMENT		gc
			where
				1 = 1
			and gc.GOODS_CD			= '".$param['goods_code']."'
			and gc.CUST_NO			= '".$param['mem_no']."'
			and gc.ORDER_REFER_NO	= '".$param['order_refer_code']."'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	/**
	 * 고객 상품평 첨부파일 경로 업데이트
	 */
	 public function update_goods_comment_file_path($title, $goods_comment_no)
	{
		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "
			update	DAT_CUST_GOODS_COMMENT      /* etah_front > mywiz2_m > update_goods_comment_file_path > 고객 상품평 첨부파일 경로 업데이트 */
			set		FILE_PATH = '".$title."'

			where	CUST_GOODS_COMMENT = '".$goods_comment_no."'
		";

		$db = self::_master_db();
		return $db->query($query);

	}

}