<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quick_m extends CI_Model {

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
	 * 관심상품 정보 구하기
	 *
	 * @return bool
	 */
	public function get_wish_goods($page)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return FALSE;

		$startPos = ($page - 1) * 6;

        $query = "
			select	/*  > etah_front > quick_m > get_wish_goods > ETAH 관심상품 정보 구하기 */
				ig.INTEREST_GOODS_NO
				, g.GOODS_NM
				, g.GOODS_CD
				, gi.IMG_URL
				, pri.SELLING_PRICE
				, b.BRAND_NM
				, ''						as GOODS_OPTION_NM

			from
				DAT_CUST c
				inner join	DAT_INTEREST_GOODS 	ig
					on 	c.CUST_NO 				= ig.CUST_NO
					and ig.USE_YN				= 'Y'
				inner join	DAT_GOODS 			g
					on	ig.GOODS_CD 			= g.GOODS_CD
				inner join	DAT_GOODS_PROGRESS	p
					on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
					and p.USE_YN				= 'Y'
					and p.GOODS_STS_CD			= '03'
				inner join	DAT_BRAND			b
					on	g.BRAND_CD				= b.BRAND_CD
				inner join	DAT_GOODS_IMAGE		gi
					on	g.GOODS_CD 				= gi.GOODS_CD
					and gi.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_PRICE		pri
					on	g.GOODS_CD				= pri.GOODS_CD
					and g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			where
				c.CUST_NO = '".$cust_no."'
			and c.USE_YN = 'Y'
			order by
				ig.UPD_DT desc

        ";
		$query .= "limit $startPos, 6";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 관심상품 정보 count
	 *
	 * @return bool
	 */
	public function get_wish_goods_count()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return 0;

        $query = "
           select	/*  > etah_front > quick_m > get_wish_goods_count > 관심상품 정보 count */
				count(ig.INTEREST_GOODS_NO)		as total_cnt


			from
				DAT_CUST c
				inner join	DAT_INTEREST_GOODS 	ig
					on 	c.CUST_NO 				= ig.CUST_NO
					and ig.USE_YN				= 'Y'
				inner join	DAT_GOODS 			g
					on	ig.GOODS_CD 			= g.GOODS_CD
				inner join	DAT_GOODS_PROGRESS	p
					on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
					and p.USE_YN				= 'Y'
					and p.GOODS_STS_CD			= '03'
				inner join	DAT_GOODS_IMAGE		gi
					on	g.GOODS_CD 				= gi.GOODS_CD
					and gi.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_PRICE		pri
					on	g.GOODS_CD				= pri.GOODS_CD
					and g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			where
				c.CUST_NO = '".$cust_no."'
			and c.USE_YN = 'Y'
			order by
				ig.UPD_DT desc
        ";

		$db = self::_slave_db();
		$row = $db->query($query)->row_array();

		return $row['total_cnt'];
	}

	/**
	 * 장바구니에 담은 상품 가져오기
	 */
	public function get_cart_goods($page)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return FALSE;

		$startPos = ($page - 1) * 2;

		$query = "
			select		/*  > etah_front > quick_m > get_cart_goods > ETAH 장바구니에 담은 상품 가져오기 */
				  c.CART_NO
				, c.GOODS_CD
				, g.GOODS_NM
				, gi.IMG_URL
				, b.BRAND_NM
				, gp.SELLING_PRICE
				, go.GOODS_OPTION_NM

			from
				DAT_CART		c

			inner join	DAT_GOODS			g
				on	g.GOODS_CD				= c.GOODS_CD
				and g.USE_YN				= 'Y'
			inner join	DAT_GOODS_PROGRESS	p
				on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
				and p.USE_YN				= 'Y'
				and p.GOODS_STS_CD			= '03'
				inner join	DAT_GOODS_PRICE	gp
				on	gp.GOODS_CD				= g.GOODS_CD
				and gp.USE_YN				= 'Y'
				and g.GOODS_PRICE_CD		= gp.GOODS_PRICE_CD
			left join	DAT_GOODS_IMAGE		gi
				on	gi.GOODS_CD				= g.GOODS_CD
				and gi.TYPE_CD				= 'TITLE'
				and gi.USE_YN				= 'Y'
			inner join	DAT_BRAND			b
				on	b.BRAND_CD				= g.BRAND_CD
				and b.USE_YN				= 'Y'
			inner join	DAT_GOODS_OPTION	go
				on	go.GOODS_OPTION_CD		= c.GOODS_OPTION_CD
				and go.USE_YN				= 'Y'

			where
				1 = 1
			and c.USE_YN	= 'Y'
			and c.CUST_NO	= '".$cust_no."'

			order by
				c.CART_NO asc

		";

		$query .= "limit $startPos, 2";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 장바구니에 담은 상품 개수
	 */
	public function get_cart_goods_count()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return 0;

		$query = "
			select		/*  > etah_front > quick_m > get_cart_goods_count > ETAH 장바구니에 담은 상품 개수 가져오기 */
				  count(c.CART_NO)			as total_cnt
			from
				DAT_CART		c

			inner join	DAT_GOODS			g
				on	g.GOODS_CD				= c.GOODS_CD
				and g.USE_YN				= 'Y'
			inner join	DAT_GOODS_PROGRESS	p
				on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
				and p.USE_YN				= 'Y'
				and p.GOODS_STS_CD			= '03'
				inner join	DAT_GOODS_PRICE	gp
				on	gp.GOODS_CD				= g.GOODS_CD
				and gp.USE_YN				= 'Y'
				and g.GOODS_PRICE_CD		= gp.GOODS_PRICE_CD
			left join	DAT_GOODS_IMAGE		gi
				on	gi.GOODS_CD				= g.GOODS_CD
				and gi.TYPE_CD				= 'TITLE'
				and gi.USE_YN				= 'Y'
			inner join	DAT_BRAND			b
				on	b.BRAND_CD				= g.BRAND_CD
				and b.USE_YN				= 'Y'

			where
				1 = 1
			and c.USE_YN	= 'Y'
			and c.CUST_NO	= '".$cust_no."'

			order by
				c.CART_NO asc
		";

		$db = self::_slave_db();
		$row = $db->query($query)->row_array();
//var_dump($query);
		return $row['total_cnt'];
	}

	/**
	 * 최근 본 상품 구하기
	 * @return int
	 */
	public function get_view_goods($page)
	{
		//만약 최근 검색한 상품데이타의 쿠키값이 없다면 0갯수를 리턴
		$cookie_view_goods = get_cookie('VIEWGOODS');
		if( empty($cookie_view_goods)) return FALSE;

		$sort = array();
		$goods = array();
		$strGoodsCode = "";
		$arrGoodsCode = explode('|',$cookie_view_goods);
//var_dump($arrGoodsCode);
		$startPos = ($page - 1) * 6;

		if($arrGoodsCode){
			$idx = 0;
//			foreach($arrGoodsCode as $goods_cd){
//				$strGoodsCode .= ",'".$goods_cd."'";
//				$sort[$goods_cd] = $idx;
//				$idx++;
//			}
			for($i=$startPos; $i<($startPos+6); $i++){
				if(isset($arrGoodsCode[$i])){
					$strGoodsCode .= ",'".$arrGoodsCode[$i]."'";
					$sort[$arrGoodsCode[$i]] = $idx;
					$idx++;
				}
			}
			$strGoodsCode = substr($strGoodsCode,1);
		}

//		var_dump($sort);


//var_dump($startPos);
		$query = "
			select	/*  > etah_front > quick_m > get_view_goods > ETAH 최근 본 상품 */
					g.GOODS_CD
					, g.GOODS_NM
					, b.BRAND_NM
				--	, i.IMG_URL
                    , ifnull(im.IMG_URL, i.IMG_URL) as IMG_URL
					, pri.SELLING_PRICE
					, ''					as GOODS_OPTION_NM
			from	DAT_GOODS g
			inner join	DAT_BRAND 			b
				on	g.BRAND_CD 				= b.BRAND_CD
			inner join	DAT_GOODS_PROGRESS 	p
				on	g.GOODS_CD 				= p.GOODS_CD
				and	g.GOODS_PROGRESS_NO 	= p.GOODS_PROGRESS_NO
			--	and	p.GOODS_STS_CD 			= '03'
			inner join	DAT_GOODS_PRICE
			pri
				on	g.GOODS_CD				= pri.GOODS_CD
				and	g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_IMAGE 	i
				on	g.GOODS_CD 				= i.GOODS_CD
				and	i.TYPE_CD 				= 'TITLE'
            left join	DAT_GOODS_IMAGE_MD 	im
				on	g.GOODS_CD 				= im.GOODS_CD
				and	im.TYPE_CD 				= 'TITLE'


			where	g.GOODS_CD in (".$strGoodsCode.")
			and		g.USE_YN = 'Y'
		";
		$query .= "limit 0, 6";

		$db = self::_slave_db();
		$result = $db->query($query)->result_array();

		foreach($result as $row){
			$sort_idx = $sort[$row['GOODS_CD']];
			$goods[$sort_idx] = $row;
		}

		$result = array();
		for($i=0; $i<count($goods); $i++){
//			if(isset($goods[$i])){
			$result[$i] = $goods[$i];
//			}
		}

		return $result;

	}

	/**
	 * 최근 본 상품 개수
	 * @return int
	 */
	public function get_view_goods_count()
	{
		//만약 최근 검색한 상품데이타의 쿠키값이 없다면 0갯수를 리턴
		$cookie_view_goods = get_cookie('VIEWGOODS');
		if( empty($cookie_view_goods)) return 0;
		$strGoodsCode = "";
		$arrGoodsCode = explode('|',$cookie_view_goods);

		if($arrGoodsCode){
			foreach($arrGoodsCode as $goods_cd){
				$strGoodsCode .= ",'".$goods_cd."'";
			}
			$strGoodsCode = substr($strGoodsCode,1);
		}
//var_dump($strGoodsCode);

		$query = "
			select	/*  > etah_front > quick_m > get_view_goods_count > ETAH 최근 본 상품 개수 */
					count(g.GOODS_CD)	as total_cnt

			from	DAT_GOODS g
			inner join	DAT_BRAND 			b
				on	g.BRAND_CD 				= b.BRAND_CD
			inner join	DAT_GOODS_PROGRESS 	p
				on	g.GOODS_CD 				= p.GOODS_CD
				and	g.GOODS_PROGRESS_NO 	= p.GOODS_PROGRESS_NO
				and	p.GOODS_STS_CD 			= '03'
			inner join	DAT_GOODS_PRICE		pri
				on	g.GOODS_CD				= pri.GOODS_CD
				and	g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_IMAGE 	i
				on	g.GOODS_CD 				= i.GOODS_CD
				and	i.TYPE_CD 				= 'TITLE'


			where	g.GOODS_CD in (".$strGoodsCode.")
			and		g.USE_YN = 'Y'
		";

		$db = self::_slave_db();
		$row = $db->query($query)->row_array();

		return $row['total_cnt'];
	}

}