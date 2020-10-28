<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_m_org extends CI_Model {

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
	 * 장바구니에 동일상품&옵션이 담겨있는지 확인
	 */
	 public function chk_cart($param)
	{
		 $query = "
			select		/*  > etah_front > cart_m_org > chk_cart > ETAH 장바구니에 동일 상품&옵션이 담겨있는지 확인 */
				  CART_NO
				, CART_QTY
			from
				DAT_CART		c
			where
				1 = 1
			and c.CUST_NO			= '".$param['cust_no']."'
			and c.GOODS_CD			= '".$param['goods_code']."'
			and c.GOODS_OPTION_CD	= '".$param['goods_option_code']."'
			and c.USE_YN			= 'Y'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}


	/**
	 * 장바구니에 상품 담기
	 */
	public function add_cart($param)
	{
		$query = "
			insert into	DAT_CART	(   /*  > etah_front > cart_m_org > add_cart > 장바구니에 상품 담기 */
				CUST_NO
			  , GOODS_CD
			  , GOODS_OPTION_CD
			  , CART_QTY
			)
			values
			(
				'".$param['cust_no']."'
			  , '".$param['goods_code']."'
			  , '".$param['goods_option_code']."'
			  , '".$param['goods_cnt']."'
			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 장바구니에서 상품 제거
	 */
	public function del_cart($cart_no)
	{
//		$query = "
//			delete from	DAT_CART
//			where
//				1 = 1
//			and CART_NO	= '".$cart_no."'
//		";

		$query = "
			update	DAT_CART    /*  > etah_front > cart_m_org > del_cart > 장바구니에 상품 제거 */
			set	USE_YN	= 'N'
			where
				1 = 1
			and CART_NO = '".$cart_no."'
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 장바구니에서 옵션/수량 변경
	 */
	 public function upd_cart($param)
	{
		 if($param['gb'] == 'CNT'){
			 $query = "
				update	DAT_CART      /*  > etah_front > cart_m_org > del_cart > 장바구니에 수량 변경 */
				set
					CART_QTY	= '".$param['cnt']."'
				where
					1 = 1
				and CART_NO		= '".$param['cart_no']."'
			";
		 } else if($param['gb'] == 'OPT'){
			 $query = "
				update	DAT_CART      /*  > etah_front > cart_m_org > del_cart > 장바구니에 옵션 변경 */
				set
					 GOODS_OPTION_CD	= '".$param['option_code']."'
					, CART_QTY			= '".$param['cnt']."'
				where
					1 = 1
				and CART_NO		= '".$param['cart_no']."'
			";
		 }

		 $db = self::_master_db();
		 return $db->query($query);
	}

	/**
	 * 장바구니에 담은 상품 가져오기
	 */
	public function get_cart_goods($cust_no)
	{
		$query = "
			select		/*  > etah_front > cart_m_org > get_cart_goods > ETAH 장바구니에 담은 상품 가져오기 */
				  c.CART_NO
				, c.CUST_NO
				, c.GOODS_CD
				, c.GOODS_OPTION_CD
				, c.CART_QTY		as GOODS_CNT
				, g.GOODS_NM
				, gi.IMG_URL		as GOODS_IMG
				, b.BRAND_CD
				, b.BRAND_NM
				, go.GOODS_OPTION_NM
				, price.GOODS_PRICE_CD
				, price.SELLING_PRICE
				, price.STREET_PRICE
				, price.FACTORY_PRICE
				, concat(g.VENDOR_SUBVENDOR_CD,'_',g.DELIV_POLICY_NO)	as DELI_CODE
				, dp.PATTERN_TYPE_CD
				, max(dpp.DELIV_COST_DECIDE_VAL)		as DELI_LIMIT
				, max(dpp.DELIV_COST)					as DELI_COST
				, dp.DELIV_POLICY_NO

			from
				DAT_CART		c

			left join
				DAT_GOODS		g
			on	g.GOODS_CD	= c.GOODS_CD
			and g.USE_YN	= 'Y'

			inner join
				DAT_GOODS_PROGRESS		gp
			on	gp.GOODS_PROGRESS_NO	= g.GOODS_PROGRESS_NO
			and gp.USE_YN			= 'Y'
			and gp.GOODS_STS_CD		= '03'

			inner join
				COD_GOODS_STS_CD		gp2
			on	gp2.GOODS_STS_CD	= gp.GOODS_STS_CD

			inner join
				DAT_GOODS_PRICE		price
			on	price.GOODS_CD	= g.GOODS_CD
			and price.USE_YN	= 'Y'

			left join
				DAT_GOODS_IMAGE		gi
			on	gi.GOODS_CD = g.GOODS_CD
			and gi.TYPE_CD	= 'TITLE'
			and gi.USE_YN	= 'Y'

			left join
				DAT_GOODS_OPTION		go
			on	go.GOODS_OPTION_CD	= c.GOODS_OPTION_CD
			and go.USE_YN			= 'Y'

			inner join
				DAT_BRAND			b
			on	b.BRAND_CD	= g.BRAND_CD
			and b.USE_YN	= 'Y'

			inner join
				DAT_DELIV_POLICY		dp
			on	dp.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and dp.USE_YN			= 'Y'

			left join
				DAT_DELIV_POLICY_PATTERN		dpp
			on dpp.DELIV_POLICY_NO	= dp.DELIV_POLICY_NO

			where
				1 = 1
			and c.USE_YN	= 'Y'
			and c.CUST_NO	= '".$cust_no."'

			group by
				c.CART_NO
			order by
				c.CART_NO asc
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 해당 상품의 쿠폰 정보 가져오기
	 */
	 public function get_coupon_info($param, $METHOD)
	{
		 $query_duplication		= "";	//중복쿠폰 여부
		 $query_duplication1	= "";
		 $query_duplication2	= "";
		 $query_duplication3	= "";
		 $query_cust			= "";	//고객쿠폰 여부

		 if($METHOD == 'CUST_DOWNLOAD'){
			 $query_duplication		= "\nand cpn.DUPLICATE_DC_CD	!= 'NONE'	";
			 $query_duplication1	= "\nand cpn1.DUPLICATE_DC_CD	!= 'NONE'	";
			 $query_duplication2	= "\nand cpn2.DUPLICATE_DC_CD	!= 'NONE'	";
			 $query_duplication3	= "\nand cpn3.DUPLICATE_DC_CD	!= 'NONE'	";
			 $query_cust			= "\nand cc.CUST_NO				 = '".$this->session->userdata('EMS_U_NO_')."'	";
		 }

		 $query = "
			select		/*  > etah_front > cart_m_org > get_coupon_info > 해당 상품의 쿠폰 정보 가져오기 */
				  cp.COUPON_CD
				, cp.DC_COUPON_NM
				, cp.COUPON_SALE
				, cp.MAX_DISCOUNT
				, cp.COUPON_DC_METHOD_CD
				, cp.COUPON_END_DT
			from	(	select	/* 상품 쿠폰 */
							  cpn.COUPON_CD
							, cpn.DC_COUPON_NM
							, cpn.COUPON_DC_METHOD_CD
							, ifnull(case	when cpn.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn.COUPON_FLAT_RATE / 10)
											when cpn.COUPON_DC_METHOD_CD = 'AMT' then cpn.COUPON_FLAT_AMT
											end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
							, cpn.MAX_DISCOUNT
							, cpn.COUPON_END_DT
							, 'cpn_g'	as gubun
						from
							DAT_COUPON		cpn
						inner join
							DAT_COUPON_PROGRESS		cpp
						on	cpp.COUPON_CD	= cpn.COUPON_CD
						and cpp.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
														from	DAT_COUPON_PROGRESS
														where	COUPON_CD	= cpp.COUPON_CD
													)
						and cpp.USE_YN = 'Y'

						left join
							MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp
						on mcp.COUPON_CD	= cpn.COUPON_CD
						and mcp.USE_YN = 'Y'

						where
							1 = 1
						and cpn.USE_YN = 'Y'
						and cpn.COUPON_APPLICATION_SCOPE_CD	= 'GOODS'
						and cpn.COUPON_START_DT	<= now()
						and cpn.COUPON_END_DT	>= now()
						and cpn.COUPON_GIVE_METHOD_CD	= '".$METHOD."'
						$query_duplication
						and cpp.COUPON_PROGRESS_STS_CD	= '03'
						and mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'

						UNION ALL

						select	/* 브랜드 쿠폰 */
							  cpn1.COUPON_CD
							, cpn1.DC_COUPON_NM
							, cpn1.COUPON_DC_METHOD_CD
							, ifnull(case	when cpn1.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn1.COUPON_FLAT_RATE / 10)
											when cpn1.COUPON_DC_METHOD_CD = 'AMT' then cpn1.COUPON_FLAT_AMT
											end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
							, cpn1.MAX_DISCOUNT
							, cpn1.COUPON_END_DT
							, 'cpn_b'	as gubun
						from
							DAT_COUPON		cpn1
						inner join
							DAT_COUPON_PROGRESS		cpp1
						on	cpp1.COUPON_CD			= cpn1.COUPON_CD
						and cpp1.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
														from	DAT_COUPON_PROGRESS
														where	COUPON_CD	= cpp1.COUPON_CD
													)
						and cpp1.USE_YN = 'Y'

						left join
							MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp1
						on mcp1.COUPON_CD	= cpn1.COUPON_CD
						and mcp1.USE_YN = 'Y'

						where
							1 = 1
						and cpn1.USE_YN = 'Y'
						and cpn1.COUPON_APPLICATION_SCOPE_CD	= 'BRAND'
						and cpn1.COUPON_START_DT	<= now()
						and cpn1.COUPON_END_DT		>= now()
						and cpn1.COUPON_GIVE_METHOD_CD	= '".$METHOD."'
						$query_duplication1
						and cpp1.COUPON_PROGRESS_STS_CD	= '03'
						and mcp1.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['brand_code']."'

						UNION ALL

						select	/* 카테고리 쿠폰 */
							  cpn2.COUPON_CD
							, cpn2.DC_COUPON_NM
							, cpn2.COUPON_DC_METHOD_CD
							, ifnull(case	when cpn2.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn2.COUPON_FLAT_RATE / 10)
											when cpn2.COUPON_DC_METHOD_CD = 'AMT' then cpn2.COUPON_FLAT_AMT
											end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
							, cpn2.MAX_DISCOUNT
							, cpn2.COUPON_END_DT
							, 'cpn_c'	as gubun
						from
							DAT_COUPON		cpn2
						inner join
							DAT_COUPON_PROGRESS		cpp2
						on	cpp2.COUPON_CD	= cpn2.COUPON_CD
						and cpp2.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
														from	DAT_COUPON_PROGRESS
														where	COUPON_CD	= cpp2.COUPON_CD
													)
						and cpp2.USE_YN = 'Y'

						left join
							MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp2
						on mcp2.COUPON_CD	= cpn2.COUPON_CD
						and mcp2.USE_YN = 'Y'

						where
							1 = 1
						and cpn2.USE_YN = 'Y'
						and cpn2.COUPON_APPLICATION_SCOPE_CD	= 'CATEGORY'
						and cpn2.COUPON_START_DT	<= now()
						and cpn2.COUPON_END_DT		>= now()
						and cpn2.COUPON_GIVE_METHOD_CD	= '".$METHOD."'
						$query_duplication2
						and cpp2.COUPON_PROGRESS_STS_CD	= '03'
						and mcp2.COUPON_APPLICATION_SCOPE_OBJECT_CD	= ''

						UNION ALL

						select	/* 셀러 쿠폰 */
							  cpn3.COUPON_CD
							, cpn3.DC_COUPON_NM
							, cpn3.COUPON_DC_METHOD_CD
							, ifnull(case	when cpn3.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn3.COUPON_FLAT_RATE / 10)
											when cpn3.COUPON_DC_METHOD_CD = 'AMT' then cpn3.COUPON_FLAT_AMT
											end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
							, cpn3.MAX_DISCOUNT
							, cpn3.COUPON_END_DT
							, 'cpn_s'	as gubun
						from
							DAT_COUPON		cpn3
						inner join
							DAT_COUPON_PROGRESS		cpp3
						on	cpp3.COUPON_CD	= cpn3.COUPON_CD
						and cpp3.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
														from	DAT_COUPON_PROGRESS
														where	COUPON_CD	= cpp3.COUPON_CD
													)
						and cpp3.USE_YN = 'Y'

						left join
							MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp3
						on mcp3.COUPON_CD	= cpp3.COUPON_CD
						and mcp3.USE_YN = 'Y'

						where
							1 = 1
						and cpn3.USE_YN = 'Y'
						and cpn3.COUPON_APPLICATION_SCOPE_CD	= 'SELLER'
						and cpn3.COUPON_START_DT	<= now()
						and cpn3.COUPON_END_DT	>= now()
						and cpn3.COUPON_GIVE_METHOD_CD	= '".$METHOD."'
						$query_duplication3
						and cpp3.COUPON_PROGRESS_STS_CD	= '03'
						and mcp3.COUPON_APPLICATION_SCOPE_OBJECT_CD	= ''
			/*
						UNION ALL

						select
							  cpn4.COUPON_CD
							, cpn4.DC_COUPON_NM
							, 4	as gubun
						from
							DAT_COUPON		cpn4
						inner join
							DAT_COUPON_PROGRESS		cpp4
						on cpp4.COUPON_CD	= cpn4.COUPON_CD
						and cpp4.USE_YN = 'Y'

						left join
							MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp4
						on mcp4.COUPON_CD	= cpp4.COUPON_CD
						and mcp4.USE_YN = 'Y'

						where
							1 = 1
						and cpn4.USE_YN = 'Y'
						and cpp4.COUPON_PROGRESS_STS_CD	= '03'
						and cpn4.COUPON_APPLICATION_SCOPE_CD	= 'CUST'
						and mcp4.COUPON_APPLICATION_SCOPE_OBJECT_CD	= ''	*/

				)	cp

			left join
				DAT_CUST_COUPON			cc
			on	cc.COUPON_CD	= cp.COUPON_CD

			where
				1 = 1
			$query_cust
		";
//var_dump($query);
		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}


	/**
	 * 우편번호 검색 (지번주소)
	 */
	 public function get_postnum_old($param)
	{
		 $query = "
			select		/*  > etah_front > cart_m_org > get_postnum_old > 우편번호 검색 (지번주소) */
				  zo.ZIPCODE
				, zo.SIDO
				, zo.SIGUNGU
				, zo.EUPMYEONDONG
				, zo.RI
				, zo.DOSEO
				, zo.BUNGI
				, zo.BUILDING_NM
			from
				DAT_ZIPCODE_OLD		zo
			where
				1 = 1
			and zo.EUPMYEONDONG	like '%".$param['dong']."%'

			order by
				zo.SIDO, zo.SIGUNGU, zo.EUPMYEONDONG, zo.RI, zo.DOSEO, zo.BUNGI, zo.BUILDING_NM		asc
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}


	/**
	 * 우편번호 검색 (도로명주소)
	 */
	 public function get_postnum_new($param)
	{
		 $query = "
			select		/*  > etah_front > cart_m_org > get_postnum_new > 우편번호 검색 (도로명주소) */
				  zn.ZIPCODE
				, zn.SIDO
				, zn.SIGUNGU
				, zn.EUPMYEONDONG
				, zn.ROAD_NM
				, zn.ROAD_NO
				, zn.BUILDING_NM
				, zn.LAWDONG_BUILDING_NM
				, zn.LAWDONG_NM
				, zn.ADMINDONG_NM
				, zn.GIBUN_BUNGI
			from
				DAT_ZIPCODE_NEW		zn
			where
				1 = 1
			and (zn.ROAD_NM	like '%".$param['dong']."%' or zn.BUILDING_NM like '%".$param['dong']."%' or zn.LAWDONG_NM like '%".$param['dong']."%')

			group by
				zn.ROAD_NM, zn.ROAD_NO

			order by
				zn.SIDO, zn.SIGUNGU, zn.ROAD_NM, zn.ROAD_NO, zn.BUILDING_NM		asc
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 도서산간지역 추가배송비 여부
	 */
	 public function get_add_delivery_cost($param)
	{
		 $query = "
			select		/*  > etah_front > cart_m_org > get_add_delivery_cost > 도서산간지역 추가배송비 여부 */
				  adc.DELIV_POLICY_NO
				, adc.DELIV_POLICY_ADD_DELIV_COST_NO
				, adc.DELIV_AREA_CD
				, adc.ADD_DELIV_COST
				, da.DELIV_AREA_NM
				, anz.ZIPCODE

			from
				DAT_DELIV_POLICY_ADD_DELIV_COST		adc

			left join
				DAT_DELIV_AREA						da
			on	da.DELIV_AREA_CD	= adc.DELIV_AREA_CD
			and da.USE_YN			= 'Y'

			left join
				MAP_DELIV_AREA_N_ZIPCODE			anz
			on anz.DELIV_AREA_CD	= da.DELIV_AREA_CD
			and anz.USE_YN			= 'Y'

			where
				1 = 1
			and adc.DELIV_POLICY_NO	= '".$param['deli_policy_no']."'
			and anz.ZIPCODE			= '".$param['postnum']."'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

}