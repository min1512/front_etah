<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_m extends CI_Model {

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
	 * 카테고리 리스트 parent_code
	 */
	public function get_list_by_category($parent_code = null)
	{
		if($parent_code){
            $query = "
                select	/*  > etah_front > category_m > get_list_by_category > ETAH 카테고리 구하기 */
					c.CATEGORY_DISP_CD
					, c.CATEGORY_DISP_NM
					, c.PARENT_CATEGORY_DISP_CD
					, c.USE_YN
				from
					DAT_CATEGORY_DISP 	c
                where
                    c.PARENT_CATEGORY_DISP_CD	= '".$parent_code."'
				and c.USE_YN					= 'Y'
				and c.WEB_DISP_YN				= 'Y'
                order by
					c.SORT_VAL, c.CATEGORY_DISP_CD
            ";
        }else{
			$query = "
				select	/*  > etah_front > category_m > get_list_by_category > ETAH 카테고리 구하기 */
					c.CATEGORY_DISP_CD
					, c.CATEGORY_DISP_NM
					, c.PARENT_CATEGORY_DISP_CD
					, c.USE_YN
				from
					DAT_CATEGORY_DISP 	c
				where
					c.PARENT_CATEGORY_DISP_CD is null
				and c.USE_YN = 'Y'
				and c.WEB_DISP_YN				= 'Y'
				order by
					c.SORT_VAL, c.CATEGORY_DISP_CD
            ";
        }
		$db = self::_master_db();
		//log_message('debug', '============================ get_list_by_category : '.$query);
		return $db->query($query)->result_array();
	}

	/**
	 * 카테고리 정보
	 */
	public function get_category_detail($cate_code, $cate_gb)
	{
		if($cate_gb){
			switch($cate_gb){
				case 'S' : $query_cate = "
								c3.CATEGORY_DISP_CD	= '".$cate_code."'
							and c3.USE_YN			= 'Y'"; break;
				case 'M' : $query_cate = "
								c2.CATEGORY_DISP_CD	= '".$cate_code."'
							and c2.USE_YN			= 'Y'"; break;
			}
		}
        //$cate_code = 20020100

		$query = "
			select	/*  > etah_front > category_m > get_category_detail > ETAH 카테고리 정보 구하기 */
				c3.CATEGORY_DISP_CD				as CATE_CODE3
				, c3.CATEGORY_DISP_NM			as CATE_NAME3
				, c2.CATEGORY_DISP_CD			as CATE_CODE2
				, c2.CATEGORY_DISP_NM			as CATE_NAME2
				, c1.CATEGORY_DISP_CD			as CATE_CODE1
				, c1.CATEGORY_DISP_NM			as CATE_NAME1
				, if('".$cate_gb."' = 'S',c3.CATEGORY_DISP_NM, c2.CATEGORY_DISP_NM) as CATE_TITLE
			from
				DAT_CATEGORY_DISP 	c3
			left join	DAT_CATEGORY_DISP c2
				on	c3.PARENT_CATEGORY_DISP_CD = c2.CATEGORY_DISP_CD
				and	c2.WEB_DISP_YN	= 'Y'
			left join	DAT_CATEGORY_DISP c1
				on	c2.PARENT_CATEGORY_DISP_CD = c1.CATEGORY_DISP_CD
				and	c1.WEB_DISP_YN	= 'Y'
			where
				$query_cate
			and c3.WEB_DISP_YN = 'Y'
			order by
				c3.SORT_VAL, c3.CATEGORY_DISP_CD
		";
		$db = self::_master_db();
		//log_message('debug', '============================ get_category_detail : '.$query);

	//var_dump($query);
		return $db->query($query)->row_array();
		
	//	$str = $db->last_query();
	//	log_message('debug', '============================ last_query : '.$str);
	}

	/**
	 * 카테고리별 하위속성
	 */
	public function get_category_attr($cate_code)
	{
		$query = "
			select	/*  > etah_front > category_m > get_category_attr > ETAH 카테고리 하위속성 구하기 */
		--		c1.CATEGORY_DISP_CD						as CATE_CODE1
		--		, c1.CATEGORY_DISP_NM					as CATE_NAME1
		--		, c2.CATEGORY_DISP_CD					as CATE_CODE2
		--		, c2.CATEGORY_DISP_NM					as CATE_NAME2
		--		, c3.CATEGORY_DISP_CD					as CATE_CODE3
		--		, c3.CATEGORY_DISP_NM					as CATE_NAME3
				 a1.GOODS_CLASSIFICATION_ATTR_CD		as ATTR_CODE1
				, a1.GOODS_CLASSIFICATION_ATTR_CD_NM	as ATTR_NAME1
				, a2.GOODS_CLASSIFICATION_ATTR_CD		as ATTR_CODE2
				, a2.GOODS_CLASSIFICATION_ATTR_CD_NM	as ATTR_NAME2
			from
				DAT_CATEGORY_DISP 	c3
		--	inner join	DAT_CATEGORY_DISP 								c2
		--		on	c3.PARENT_CATEGORY_DISP_CD 							= c2.CATEGORY_DISP_CD
		--	inner join	DAT_CATEGORY_DISP 								c1
		--		on	c2.PARENT_CATEGORY_DISP_CD 							= c1.CATEGORY_DISP_CD
			inner join 	MAP_CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR 	m
				on	m.CATEGORY_DISP_CD 									= c3.CATEGORY_DISP_CD
				and m.USE_YN											= 'Y'
			inner join	DAT_GOODS_CLASSIFICATION_ATTR					a2
				on	a2.GOODS_CLASSIFICATION_ATTR_CD						= m.GOODS_CLASSIFICATION_ATTR_CD
			inner join	DAT_GOODS_CLASSIFICATION_ATTR 					a1
				on	a2.PARENT_GOODS_CLASSIFICATION_ATTR_CD 				= a1.GOODS_CLASSIFICATION_ATTR_CD
			where
				c3.CATEGORY_DISP_CD = '".$cate_code."'
			and	c3.WEB_DISP_YN = 'Y'
			order by
				a1.GOODS_CLASSIFICATION_ATTR_CD_NM, a2.GOODS_CLASSIFICATION_ATTR_CD_NM

		";
		$db = self::_master_db();
		//log_message('debug', '============================ get_category_attr : '.$query);
//		var_dump($query);
		return $db->query($query)->result_array();
	}

	/**
	 * 에타 카테고리 메인
	 */
	public function get_md_goods($gubun)
	{
		$query = "
			select	/*  > etah_front > category_m > get_md_goods > ETAH 에타 카테고리 메인 */
				g.GOODS_CD
				, g.GOODS_NM
				, b.BRAND_NM
				, ifnull(mdG.IMG_URL, i.IMG_URL)					as IMG_URL
				, pri.SELLING_PRICE
				, mdG.SEQ
				, mdG.LINK_URL
				, if(mdG.SEQ = '2', 'cpp_goods_item__big', if(mdG.SEQ = '5', 'min_layout_item', if(mdG.SEQ = '6', 'cpp_goods_item__big min_layout_item', '')))	as CLASS_NM
				, mdG.RGB
				, mdG.DISP_HTML
			from
				DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
				left join	DAT_GOODS						g
					on	mdG.GOODS_CD						= g.GOODS_CD
					and	g.WEB_DISP_YN						= 'Y'
				left join	DAT_BRAND 						b
					on	g.BRAND_CD 							= b.BRAND_CD
				--	and	b.WEB_DISP_YN						= 'Y'
				left join	DAT_GOODS_IMAGE 				i
					on 	g.GOODS_CD  						= i.GOODS_CD
					and i.TYPE_CD							= 'TITLE'
				left join	DAT_GOODS_PRICE 				pri
					on 	g.GOODS_CD							= pri.GOODS_CD
					and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
			where
				mdG.GUBUN = '".$gubun."'

			order by
				mdG.SEQ
            limit 1
		";
		$db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ get_md_goods : '.$query);
		return $db->query($query)->result_array();
	}


	/**
	 * 에타 초이스 by batch table
	 * 2017.08.28 이진호
	 */
	public function get_md_goods_choice_batch($gubun)
	{
		$query = "
			select	/*  > etah_front > category_m > get_md_goods_choice_batch > ETAH 에타 초이스 상품 구하기 (by batch table) */
				bat.GOODS_CD
				, bat.GOODS_NM
				, bat.BRAND_NM
				, bat.IMG_URL
				, bat.SELLING_PRICE
				, bat.SEQ
				, bat.LINK_URL
				, bat.NAME
				, bat.RGB
				, bat.DISP_HTML
				, bat.RATE_PRICE
				, bat.AMT_PRICE
				, bat.COUPON_CD
				, eg.PLAN_EVENT_REFER_CD		as DEAL 
			from
				BAT_ETAH_CHOICE   bat
                left join DAT_PLAN_EVENT_GOODS    eg
                on bat.GOODS_CD                    = eg.GOODS_CD
                and eg.PLAN_EVENT_CODE             in (586,587)  	
			where
				GUBUN = '".$gubun."'
			group by
				GOODS_CD
			order by
				SEQ  asc
			limit 3	
				
		";
		$db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ get_md_goods_choice : '.$query);
		return $db->query($query)->result_array();
	}

	/**
	 * 에타 초이스
	 */
	public function get_md_goods_choice($gubun)
	{
		$query = "
			select	/*  > etah_front > category_m > get_md_goods_choice > ETAH 에타 초이스 상품 구하기 */
				g.GOODS_CD
				, g.GOODS_NM
				, b.BRAND_NM
				, if(mdG.IMG_URL = '',i.IMG_URL, ifnull(mdG.IMG_URL,i.IMG_URL))			as IMG_URL
				, pri.SELLING_PRICE
				, mdG.SEQ
				, mdG.LINK_URL
				, if(mdG.NAME != '' , mdG.NAME, g.GOODS_NM)								as NAME
				, mdG.RGB
				, mdG.DISP_HTML
				, sum(if(cpn.MAX_DISCOUNT > 0,
					if(floor(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
					 floor(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
					 floor(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
				 )													as RATE_PRICE
				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
				, max(cpn.COUPON_CD)								as COUPON_CD
			from
				DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
				left join	DAT_GOODS						g
					on	mdG.GOODS_CD						= g.GOODS_CD
					and	g.WEB_DISP_YN						= 'Y'
				left join	DAT_BRAND 						b
					on	g.BRAND_CD 							= b.BRAND_CD
				--	and	b.WEB_DISP_YN						= 'Y'
				left join	DAT_GOODS_IMAGE 				i
					on 	g.GOODS_CD  						= i.GOODS_CD
					and i.TYPE_CD							= 'TITLE'
				left join	DAT_GOODS_PRICE 				pri
					on 	g.GOODS_CD							= pri.GOODS_CD
					and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
				left join	(	select	convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
									, cpn.COUPON_CD
									, cpn.COUPON_DC_METHOD_CD
									, cpn.COUPON_FLAT_RATE
									, cpn.COUPON_FLAT_AMT
									, cpn.MIN_AMT
									, cpn.MAX_DISCOUNT
							from
								MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
							inner join DAT_COUPON	cpn
								on	mcp.COUPON_CD					 = cpn.COUPON_CD
								and cpn.COUPON_KIND_CD				 in ('GOODS','SELLER')
								and cpn.USE_YN						 = 'Y'
								and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn
				on	g.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
			where
				mdG.GUBUN = '".$gubun."'

			group by
				g.GOODS_CD

			order by
				mdG.SEQ

		";
		$db = self::_master_db();
//		var_dump($query);
		//log_message('debug', '============================ get_md_goods_choice : '.$query);
		return $db->query($query)->result_array();
	}


	/**
	 * WEEKLY BEST  상품
	 */
	public function get_weekly_best_goods($cate_cd)
	{
		$date_from = date("Y-m-d", strtotime("-1 week"));
		$date_to = date("Y-m-d", time());

		$query = "
			select	/*  > etah_front > category_m > get_weekly_best_goods > ETAH WEEKLY BEST 구하기 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.BRAND_NM
				, t.SELLING_PRICE
			--	, i.IMG_URL
				, if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
				, dp.DELIV_POLICY_NO
				, dp.PATTERN_TYPE_CD
				, max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
				, max(dpp.DELIV_COST)								as DELI_COST
			/*	, sum(if(cpn.MAX_DISCOUNT > 0,
				if(round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
				 round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
				 round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
			 )													as RATE_PRICE
				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
				, max(cpn.COUPON_CD)								as COUPON_CD	*/
				, if(floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_S
				, if(floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_G
				, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
				, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
				, cpn_s.COUPON_CD									as COUPON_CD_S
				, cpn_g.COUPON_CD									as COUPON_CD_G
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
			from

			(
				select
					g.GOODS_CD
					, g.GOODS_NM
					, b.BRAND_NM
					, pri.SELLING_PRICE
					, sort.GOODS_SORT_SCORE
					, g.GOODS_MILEAGE_N_GOODS_NO
					, g.DELIV_POLICY_NO

				from
					DAT_GOODS g
					inner join	(	select	distinct
										mc.GOODS_CD
									from	MAP_CATEGORY_DISP_N_GOODS 	mc
									inner join	DAT_CATEGORY_DISP				c3
										on	mc.CATEGORY_DISP_CD					= c3.CATEGORY_DISP_CD
								--		and	c3.WEB_DISP_YN						= 'Y'
									inner join	DAT_CATEGORY_DISP				c2
										on	c3.PARENT_CATEGORY_DISP_CD			= c2.CATEGORY_DISP_CD
										and c2.PARENT_CATEGORY_DISP_CD			= '".$cate_cd."'
								--		and	c2.WEB_DISP_YN						= 'Y'

								where	mc.USE_YN					= 'Y'

							) m
						on	g.GOODS_CD							= m.GOODS_CD

					inner join	DAT_BRAND						b
						on	g.BRAND_CD							= b.BRAND_CD
					--	and	b.WEB_DISP_YN						= 'Y'
					inner join	DAT_GOODS_PROGRESS				p
						on	g.GOODS_CD							= p.GOODS_CD
						and	g.GOODS_PROGRESS_NO					= p.GOODS_PROGRESS_NO
						and	p.GOODS_STS_CD						= '03'
					inner join	DAT_GOODS_PRICE					pri
						on	g.GOODS_CD							= pri.GOODS_CD
						and	g.GOODS_PRICE_CD					= pri.GOODS_PRICE_CD
					left join	DAT_GOODS_SORT_SCORE			sort
						on	g.GOODS_CD							= sort.GOODS_CD

					where
						g.WEB_DISP_YN = 'Y'

					order by
						sort.GOODS_SORT_SCORE desc
					limit 0, 12
				) t

				inner join	DAT_GOODS_IMAGE						i
					on	t.GOODS_CD								= i.GOODS_CD
					and	i.TYPE_CD								= 'TITLE'
				left join	 DAT_GOODS_IMAGE_RESIZING 		gir
					on 	t.GOODS_CD								= gir.GOODS_CD
					and	gir.TYPE_CD								= '400'
				inner join	DAT_DELIV_POLICY					dp
					on	dp.DELIV_POLICY_NO						= t.DELIV_POLICY_NO
					and dp.USE_YN								= 'Y'
				left join	DAT_DELIV_POLICY_PATTERN			dpp
					on dpp.DELIV_POLICY_NO						= dp.DELIV_POLICY_NO
				left join	MAP_GOODS_MILEAGE_N_GOODS			mileage
					on	mileage.GOODS_MILEAGE_N_GOODS_NO		= t.GOODS_MILEAGE_N_GOODS_NO
					and mileage.USE_YN							= 'Y'

				left join	(	select	convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
									, cpn.COUPON_CD
									, cpn.COUPON_DC_METHOD_CD
									, cpn.COUPON_FLAT_RATE
									, cpn.COUPON_FLAT_AMT
									, cpn.MIN_AMT
									, cpn.MAX_DISCOUNT
							from
								MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
							inner join DAT_COUPON	cpn
								on	mcp.COUPON_CD					 = cpn.COUPON_CD
								and cpn.COUPON_KIND_CD				 in ('SELLER')
								and cpn.USE_YN						 = 'Y'
								and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn_s
				on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD

				left join	(	select	convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
									, cpn.COUPON_CD
									, cpn.COUPON_DC_METHOD_CD
									, cpn.COUPON_FLAT_RATE
									, cpn.COUPON_FLAT_AMT
									, cpn.MIN_AMT
									, cpn.MAX_DISCOUNT
							from
								MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
							inner join DAT_COUPON	cpn
								on	mcp.COUPON_CD					 = cpn.COUPON_CD
								and cpn.COUPON_KIND_CD				 in ('GOODS')
								and cpn.USE_YN						 = 'Y'
								and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD

			group by
				t.GOODS_CD

			order by t.GOODS_SORT_SCORE desc



		";
		$db = self::_master_db();
//		var_dump($query);
		//log_message('debug', '============================ get_weekly_best_goods : '.$query);
		return $db->query($query)->result_array();
	}




	/**
	 * WEEKLY BEST  상품
	 */
	public function get_weekly_best_goods_batch($cate_cd)
	{
		$date_from = date("Y-m-d", strtotime("-1 week"));
		$date_to = date("Y-m-d", time());


		$query = "
			select	      /*  > etah_front > category_m > get_weekly_best_goods_batch > WEEKLY BEST  상품 (by batch table) */
				bat.GOODS_CD
				, bat.GOODS_NM
				, bat.BRAND_NM
				, bat.SELLING_PRICE
				, bat.IMG_URL
				, bat.DELIV_POLICY_NO
				, bat.PATTERN_TYPE_CD
				, bat.DELI_LIMIT
				, bat.DELI_COST
				, round( bat.RATE_PRICE_S / 10) * 10 as RATE_PRICE_S
				, round( bat.RATE_PRICE_G / 10) * 10 as RATE_PRICE_G
				, bat.AMT_PRICE_S
				, bat.AMT_PRICE_G
				, bat.COUPON_CD_S
				, bat.COUPON_CD_G
				, bat.GOODS_MILEAGE_SAVE_RATE
				, bat.PARENT_CATEGORY_DISP_CD
				, bat.GOODS_SORT_SCORE
				, (select 
                      eg.PLAN_EVENT_REFER_CD 
                      from 
                      DAT_PLAN_EVENT_GOODS eg 
                      where 
                      bat.GOODS_CD = eg.GOODS_CD 
                      and eg.PLAN_EVENT_CODE in (586,587) 
                      limit 1
                    )                                         as DEAL
			from
				BAT_ETAH_WEEK_BEST    bat
			where 
				PARENT_CATEGORY_DISP_CD			= '".$cate_cd."' 
			order by
				GOODS_SORT_SCORE desc
			
			limit 0, 12
		";
		$db = self::_master_db();
//		var_dump($query);
		//log_message('debug', '============================ get_weekly_best_goods_batch : '.$query);
		return $db->query($query)->result_array();
	}


	/**
     * 직구SHOP 메인
     * 카테고리별 브랜드 상품 개수
     */
    public function get_brand_global_goods_count($param)
    {
        $str_brand_cd			= "";
        $query_category			= "";
        $query_search_keyword	= "";

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            $str_brand_cd = substr($str_brand_cd, 3);
        }

        /* 상품코드 */
        if($param['goods_cd'])  $query_search_keyword = "and g.VENDOR_GOODS_CD in (".$param['goods_cd'].")";

        $query = "
			select	/*  > etah_front > category_m > get_brand_global_goods_count > ETAH 직구SHOP 카테고리별 브랜드 상품 개수 */
				bb.BRAND_CD
				, bb.BRAND_NM
				, b.GOODS_CNT
				, ifnull(lb.BRAND_CD,'N')	as FLAG_YN
			from
			(
				select
					b.BRAND_CD			as CODE
					, count(g.GOODS_CD)	as GOODS_CNT
				from	DAT_BRAND b
					inner join	DAT_GOODS					g
						on 	g.BRAND_CD						= b.BRAND_CD
						and g.WEB_DISP_YN					= 'Y'
					inner join	DAT_GOODS_PROGRESS			gp
						on	g.GOODS_CD 						= gp.GOODS_CD
						and g.GOODS_PROGRESS_NO				= gp.GOODS_PROGRESS_NO
						and	gp.GOODS_STS_CD					= '03'
					inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
								--	and c.WEB_DISP_YN				= 'Y'
								inner join DAT_CATEGORY_DISP	CD3
									on mc.CATEGORY_DISP_CD			= CD3.CATEGORY_DISP_CD
                                inner join DAT_CATEGORY_DISP CD2
                                    on CD3.PARENT_CATEGORY_DISP_CD	= CD2.CATEGORY_DISP_CD
                                    and CD2.PARENT_CATEGORY_DISP_CD = '20000000'
								where	mc.USE_YN					= 'Y'
								$query_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD
				where
					1 = 1
			--	and	b.WEB_DISP_YN = 'Y'
				$query_search_keyword
				group by
					CODE
			) b
			inner join	DAT_BRAND		bb
				on 	bb.BRAND_CD			= b.CODE
			left join	DAT_BRAND		lb
				on 	lb.BRAND_CD			= b.CODE
				and lb.BRAND_CD 		in('".$str_brand_cd."')
			order by
				bb.BRAND_NM ASC
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 직구SHOP 메인
     * 상품리스트
     */
    public function get_global_goods_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = 0;
        $query_mid_category		= "";
        $query_brand			= "";
        $query_price_limit		= "";
        $query_order_by			= "";
        $query_out_order_by		= "";
        $query_sort_table		= "";

        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

        /* 카테고리 */
        if($param['arr_cate']){
            $str_cate_cd = str_replace('|',"','", $param['arr_cate']);
            if(strpos($str_cate_cd, ',')) $str_cate_cd = substr($str_cate_cd, 3);
            $query_mid_category = "and c.PARENT_CATEGORY_DISP_CD in ('".$str_cate_cd."')";
        }

        /* 금액제한 */
        if($param['price_limit']){
            if($param['price_limit'] == '50'){
                $query_price_limit = "and pri.SELLING_PRICE >= '300000'";
            }else{
                $query_price_limit = "and pri.SELLING_PRICE <= '".$param['price_limit']."0000'";
            }
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            if(strpos($str_brand_cd, ',')) $str_brand_cd = substr($str_brand_cd, 3);
            $query_brand = "and b.BRAND_CD in ('".$str_brand_cd."')";

        }


        /* 정렬 */
        if($param['order_by']){
            switch($param['order_by']){
                case 'A' :	$query_order_by = "order by g.GOODS_CD desc";
                    $query_out_order_by = "order by t.GOODS_CD desc"; break; //신상품순
                case 'B' :	$query_sort_table = "";
                    $query_order_by = "order by eg.GOODS_PRIORITY is null asc, sort.GOODS_SORT_SCORE desc, g.GOODS_CD desc";
                    $query_out_order_by = "order by t.GOODS_PRIORITY IS NULL ASC, t.GOODS_SORT_SCORE desc, t.GOODS_CD desc"; break;	//인기순
                case 'C' :	$query_order_by = "order by pri.SELLING_PRICE asc, g.GOODS_CD desc";
                    $query_out_order_by ="order by COUPON_PRICE asc, t.GOODS_CD desc"; break;	//낮은가격순
                case 'D' :	$query_order_by = "order by pri.SELLING_PRICE desc, g.GOODS_CD desc";
                    $query_out_order_by ="order by COUPON_PRICE desc, t.GOODS_CD desc"; break;	//높은가격순
            }
        }

        /* 공급사상품코드 */
        $query_search_keyword = "and g.VENDOR_GOODS_CD in (".$param['goods_cd'].")";

        $query = "

			select /*  > etah_front > goods_m > get_goods_list > ETAH 상품리스트 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.T_CATEGORY_CD
				, t.T_CATEGORY_NM
				, t.PROMOTION_PHRASE
				, t.BRAND_CD
				, t.BRAND_NM
				, t.SELLING_PRICE
				
				, if( (cpn_s.COUPON_CD is not null) || (cpn_g.COUPON_CD is not null),
						( t.SELLING_PRICE
							 - (
							 		ifnull(if(floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000))),0)
							 		+ifnull(if(floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000))),0)
							 	)
							 - (ifnull(cpn_s.COUPON_FLAT_AMT, 0)+ifnull(cpn_g.COUPON_FLAT_AMT, 0))
						),
						t.SELLING_PRICE
					)                                                                           as COUPON_PRICE
					
				, t.INTEREST_CNT
                , ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, gi.IMG_URL))		as IMG_URL
				, dp.DELIV_POLICY_NO
				, dp.PATTERN_TYPE_CD
				, max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
				, if(floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_S
				, if(floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_G
				, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
				, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
				, cpn_s.COUPON_CD									as COUPON_CD_S
				, cpn_g.COUPON_CD									as COUPON_CD_G
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
				
                , t.CLASS_GUBUN
                , t.CLASS_TYPE
                , t.ADDRESS
                , t.GOODS_PRIORITY
                , t.DEAL
			from
			(
				select
					g.GOODS_CD
					, g.GOODS_NM
					, c3.CATEGORY_DISP_CD as T_CATEGORY_CD
					, c3.CATEGORY_DISP_NM as T_CATEGORY_NM
					, g.PROMOTION_PHRASE
					, g.BRAND_CD
					, g.GOODS_MILEAGE_N_GOODS_NO
					, g.DELIV_POLICY_NO
					, b.BRAND_NM
					, pri.SELLING_PRICE
					, sort.GOODS_SORT_SCORE
                    , count(ig.INTEREST_GOODS_NO)     as INTEREST_CNT
                    , cg.ADDRESS
                    , if(c.PARENT_CATEGORY_DISP_CD='24010000', 'C', if(c.PARENT_CATEGORY_DISP_CD='24020000', 'G', ''))  as CLASS_GUBUN
                    , if(cg.CLASS_TYPE='ONE', '원데이', if(cg.CLASS_TYPE='MANY', '다회차', '공방상품'))                   as CLASS_TYPE
                    , eg.GOODS_PRIORITY
                    , if(eg.PLAN_EVENT_REFER_CD, 'DEAL', '')	as DEAL

				from
					DAT_GOODS 				g
				inner join	DAT_BRAND 					b
					on	g.BRAND_CD 						= b.BRAND_CD
			/*	inner join	MAP_CATEGORY_DISP_N_GOODS	mcg
					on	g.GOODS_CD						= mcg.GOODS_CD
				inner join	DAT_CATEGORY_DISP 			c
					on	mcg.CATEGORY_DISP_CD 			= c.CATEGORY_DISP_CD
					*/
				inner join	DAT_GOODS_PRICE 			pri
					on	g.GOODS_CD 						= pri.GOODS_CD
					and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
				inner join	DAT_GOODS_PROGRESS			gp
					on	g.GOODS_CD 						= gp.GOODS_CD
					and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
					and	gp.GOODS_STS_CD					= '03'
				inner join	COD_GOODS_STS_CD			gs
					on	gp.GOODS_STS_CD 				= gs.GOODS_STS_CD
			
                INNER JOIN MAP_CATEGORY_DISP_N_GOODS     mc
                    ON mc.GOODS_CD                        = g.GOODS_CD
                    and mc.USE_YN					      = 'Y'
                INNER JOIN     DAT_CATEGORY_DISP         c
                    on    c.CATEGORY_DISP_CD              = mc.CATEGORY_DISP_CD
                    and	c.USE_YN 					       = 'Y'
                    $query_mid_category
                INNER JOIN      DAT_CATEGORY_DISP         c2
                    ON  c.PARENT_CATEGORY_DISP_CD         = c2.CATEGORY_DISP_CD
                INNER JOIN      DAT_CATEGORY_DISP         c3
                    ON  c2.PARENT_CATEGORY_DISP_CD         = c3.CATEGORY_DISP_CD
                    and c2.PARENT_CATEGORY_DISP_CD         = '20000000'
                  
				
				left join	DAT_GOODS_SORT_SCORE	sort
					on	g.GOODS_CD		= sort.GOODS_CD
                left join DAT_INTEREST_GOODS       ig
				    on g.GOODS_CD       = ig.GOODS_CD
				left join MAP_CLASS_GOODS          cg
				    on g.GOODS_CD       = cg.GOODS_CD
                left join DAT_PLAN_EVENT_GOODS      eg
                    on g.GOODS_CD              = eg.GOODS_CD
                    and eg.PLAN_EVENT_CODE    in (586,587)
				$query_sort_table

				where
					1 = 1
				and g.WEB_DISP_YN = 'Y'
				$query_brand
				$query_price_limit
				$query_search_keyword
				
				group by g.GOODS_CD

				$query_order_by
				$query_limit
			) t

			inner join	DAT_GOODS_IMAGE					gi
				on 	t.GOODS_CD 							= gi.GOODS_CD
				and	gi.TYPE_CD							= 'TITLE'
			left join	 DAT_GOODS_IMAGE_RESIZING 		gir
				on 	t.GOODS_CD							= gir.GOODS_CD
				and	gir.TYPE_CD							= '400'
            left join	DAT_GOODS_IMAGE_MD		        im
                on	t.GOODS_CD							= im.GOODS_CD
                and	im.TYPE_CD							= 'TITLE'
            left join	 DAT_GOODS_IMAGE_RESIZING_MD 	girm
                on 	t.GOODS_CD							= girm.GOODS_CD
                and	girm.TYPE_CD						= '400'
			inner join	DAT_DELIV_POLICY				dp
				on	dp.DELIV_POLICY_NO					= t.DELIV_POLICY_NO
				and dp.USE_YN							= 'Y'
			left join	DAT_DELIV_POLICY_PATTERN		dpp
				on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO
			left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
				on	mileage.GOODS_MILEAGE_N_GOODS_NO	= t.GOODS_MILEAGE_N_GOODS_NO
				and mileage.USE_YN						= 'Y'
			
			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
				on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD
				

			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD

			group by
				t.GOODS_CD
			$query_out_order_by


		";

        $db = self::_slave_db();

        return $db->query($query)->result_array();
    }

}