<?php
/**
 * Created by PhpStorm.
 * User: jemoonjong
 * Date: 2014. 7. 15.
 * Time: 오후 4:32
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_m extends CI_Model {

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

		public function cache_delete()
	{
		$db = self::_slave_db();
		$db->cache_delete_all();
	}

	/**
	 * 테스트
	 *
	 * @return mixed
	 */
	public function get_test()
	{
		$query = " SELECT A.CUST_NO      /*  > etah_front > main_m > get_test > 고객 조회 */
							        ,A.CUST_ID
							        ,A.CUST_NM
							        ,A.MOB_NO
							        ,A.EMAIL
						   FROM DAT_CUST A ";

		$db = self::_slave_db();
		$rows = $db->query($query)->result_array();

		return $rows;
	}

	/**
	 * BEST 상품
	 *
	 * @return mixed
	 */
	public function get_best_goods()
	{
		$query = "
			select 		/*  > etah_front > main_m > get_best_goods > ETAH BEST ITEM */
				t.GOODS_CD
				, t.GOODS_NM
				, t.PROMOTION_PHRASE
				, t.BRAND_NM
			--	, i.IMG_URL
				, if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
				, pri.SELLING_PRICE
				, sum(if(cpn.MAX_DISCOUNT > 0,
					if(round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
					 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
					 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
				 )													as RATE_PRICE
				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
				, max(cpn.COUPON_CD)								as COUPON_CD
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
			from
			(
				select
					g.GOODS_CD
					, g.GOODS_NM
					, g.PROMOTION_PHRASE
					, g.GOODS_PRICE_CD
					, g.GOODS_MILEAGE_N_GOODS_NO
					, b.BRAND_NM
					, sort.GOODS_SORT_SCORE
				from
					DAT_GOODS g
				inner join	DAT_BRAND					b
					on	g.BRAND_CD						= b.BRAND_CD
				--	and b.WEB_DISP_YN					= 'Y'

				inner join	DAT_GOODS_PROGRESS 			gp
					on	g.GOODS_CD						= gp.GOODS_CD
					and g.GOODS_PROGRESS_NO				= gp.GOODS_PROGRESS_NO
					and	gp.GOODS_STS_CD					= '03'
				inner join	DAT_GOODS_SORT_SCORE		sort
					on	g.GOODS_CD 						= sort.GOODS_CD
				where
					g.USE_YN = 'Y'
				and	g.WEB_DISP_YN = 'Y'
				and sort.GOODS_SORT_SCORE != '9999999.999'	/* 2017-02-20 우선전시상품 BEST에서 제거 */
				order by
					sort.GOODS_SORT_SCORE desc, g.GOODS_CD desc
				limit 8

				)		t
				inner join	DAT_GOODS_IMAGE					i
					on	t.GOODS_CD							= i.GOODS_CD
					and	i.TYPE_CD							= 'TITLE'

				left join	 DAT_GOODS_IMAGE_RESIZING 		gir
					on 	t.GOODS_CD							= gir.GOODS_CD
					and	gir.TYPE_CD							= '300'

				inner join	DAT_GOODS_PRICE					pri
					on	t.GOODS_CD 							= pri.GOODS_CD
					and t.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
				left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
					on	mileage.GOODS_MILEAGE_N_GOODS_NO	= t.GOODS_MILEAGE_N_GOODS_NO
					and mileage.USE_YN						= 'Y'

				/*left join	(	select	mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD
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
							--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
									and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

								inner join DAT_COUPON_PROGRESS cpp
									on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
									and cpp.COUPON_PROGRESS_STS_CD		= '03'
									and	cpp.USE_YN						= 'Y'
							) cpn
					on	t.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
*/                left join	(	select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER
						
						union all
						
						select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS
				) cpn
				on	t.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
				group by t.GOODS_CD

				order by
				t.GOODS_SORT_SCORE desc, t.GOODS_CD desc
		";

		$db = self::_slave_db();
		$rows = $db->query($query)->result_array();

		return $rows;
	}

	/**
	 * 상품 구하기
	 *
	 * @return mixed
	 */
	public function get_md_goods($gubun)
	{
		$query = "
			select	/*  > etah_front > main_m > get_md_goods > ETAH 에타 메인 상품 */
				mdG.GOODS_CD
				, mdG.BANNER_CD
			--	, g.GOODS_NM
				, ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
				, g.PROMOTION_PHRASE
				, b.BRAND_NM
				, REPLACE (if(mdG.IMG_URL = '',i.IMG_URL, ifnull(mdG.IMG_URL,i.IMG_URL)), 'http://' ,'https://s3-ap-northeast-1.amazonaws.com/' )			as IMG_URL
				, REPLACE (if(mdG.IMG_URL = '', mag.IMG_URL, ifnull(mdG.IMG_URL, mag.IMG_URL)), 'http://' , 'https://s3-ap-northeast-1.amazonaws.com/' )	as MAGAZINE_IMG_URL
				, if(mdG.SEQ in ('3','6'), '609', '304')	as BRAND_SIZE
				, pri.SELLING_PRICE
				, mdG.SEQ
				, mdG.LINK_URL
				, mdG.NAME
				, mdG.DISP_HTML
				, cm.CATEGORY_NM
				, mag.TITLE
				, count(distinct ml.MAGAZINE_LOVE_NO)	        as LOVE
                , count(distinct mcom.CUST_MAGAZINE_COMMENT)	as COMMENT
                , mag.`SHARE`
                , mag.HITS
			from
				DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
			left join	DAT_GOODS 				g
				on	g.GOODS_CD					= mdG.GOODS_CD
				and	g.USE_YN					= 'Y'
				and g.WEB_DISP_YN				= 'Y'
            left join DAT_GOODS_MD_MOD         gmm
                on g.GOODS_CD                   = gmm.GOODS_CD
                and gmm.USE_YN                  = 'Y'
			left join	DAT_BRAND 				b
				on	g.BRAND_CD 					= b.BRAND_CD
			--	and	b.WEB_DISP_YN				= 'Y'
			left join	DAT_GOODS_IMAGE			i
				on 	g.GOODS_CD  				= i.GOODS_CD
				and i.TYPE_CD					= 'TITLE'
			left join	DAT_GOODS_PRICE			pri
				on 	g.GOODS_CD					= pri.GOODS_CD
				and	g.GOODS_PRICE_CD 			= pri.GOODS_PRICE_CD
			left join	DAT_MAGAZINE			mag
				on	mdG.GOODS_CD				= mag.MAGAZINE_NO
            left join	DAT_CATEGORY_MAGAZINE	cm
				on mag.CATEGORY_CD              = cm.CATEGORY_CD
            left join MAP_MAGAZINE_LOVE        ml
                    on mdG.GOODS_CD             = ml.MAGAZINE_NO
            left join DAT_CUST_MAGAZINE_COMMENT mcom
                    on mdG.GOODS_CD             = mcom.MAGAZINE_NO
                    and mcom.USE_YN             = 'Y'
			where
				mdG.GUBUN = '".$gubun."'
            group by
                mdG.SEQ
			order by
				mdG.SEQ ";

		$db = self::_slave_db();
		$rows = $db->query($query)->result_array();

        for ($i=0; $i<sizeof($rows); $i++){
            $rows[$i]['IMG_URL'] = str_replace("http://","https://s3-ap-northeast-1.amazonaws.com/",$rows[$i]['IMG_URL']);
            $rows[$i]['MAGAZINE_IMG_URL'] = str_replace("http://","https://s3-ap-northeast-1.amazonaws.com/",$rows[$i]['MAGAZINE_IMG_URL']);
        }

		return $rows;
	}


	/**
	 * 에타 초이스
	 */
	public function get_md_goods_choice($gubun)
	{
        $class_column = "";
        $class_query = "";
	    if($gubun == 'MAIN_CLASS_GOODS') {
	        $class_column = "
            , if(cg.CLASS_TYPE='ONE', '원데이', if(cg.CLASS_TYPE='MANY', '다회차', '공방상품'))     as CLASS
            , cg.ADDRESS	as ADDRESS
	        ";

            $class_query = "left join MAP_CLASS_GOODS cg on mdG.GOODS_CD = cg.GOODS_CD";
        }

		$query = "
			select	/*  > etah_front > main_m > get_md_goods_choice > ETAH 에타 초이스 상품 */
				g.GOODS_CD
			--	, g.GOODS_NM
                , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
				, b.BRAND_NM
				, REPLACE(if(mdG.IMG_URL = '', ifnull(im.IMG_URL, i.IMG_URL), mdG.IMG_URL),'http://image.etah.co.kr','https://s3-ap-northeast-1.amazonaws.com/image.etah.co.kr' )		as IMG_URL
			--	, if(mdG.IMG_URL = '',i.IMG_URL, ifnull(mdG.IMG_URL,i.IMG_URL))			as IMG_URL
			--	, if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
				, pri.SELLING_PRICE
				, mdG.SEQ
				, mdG.LINK_URL
				, mdG.RGB
				, if(mdG.NAME != '', mdG.NAME, g.GOODS_NM)			as NAME
				, mdG.DISP_HTML
				, round( sum(if(cpn.MAX_DISCOUNT > 0,
					if(floor(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
					 floor(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
					 floor(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
				 )/10)*10													as RATE_PRICE
				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
				, max(cpn.COUPON_CD)								as COUPON_CD
				, dp.PATTERN_TYPE_CD
				-- , dpp.DELIV_COST_DECIDE_VAL                         as DELI_LIMIT
				, (select   DELIV_COST_DECIDE_VAL from DAT_DELIV_POLICY_PATTERN		
					where  DELIV_POLICY_NO = dp.DELIV_POLICY_NO and  DELIV_COST_DECIDE_VAL > 0 limit 1) as  DELI_LIMIT
					
				, (select PLAN_EVENT_REFER_CD from DAT_PLAN_EVENT_GOODS
					where GOODS_CD = mdG.GOODS_CD and PLAN_EVENT_CODE in (586,587) limit 1)  as DEAL
				
				, if(left(g.CATEGORY_MNG_CD, 4)=2401, 'C', (if(left(g.CATEGORY_MNG_CD, 4)=2402, 'G', '')))  as GONGBANG
				$class_column
			from
				DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
				
				left join	DAT_GOODS						g
					on	mdG.GOODS_CD						= g.GOODS_CD
					and	g.WEB_DISP_YN						= 'Y'
					
                left join DAT_GOODS_MD_MOD                 gmm
                    on g.GOODS_CD                           = gmm.GOODS_CD
                    and gmm.USE_YN                          = 'Y'
					
				left join	DAT_BRAND 						b
					on	g.BRAND_CD 							= b.BRAND_CD
				--	and	b.WEB_DISP_YN						= 'Y'
				
				left join	DAT_GOODS_IMAGE 				i
					on 	g.GOODS_CD  						= i.GOODS_CD
					and i.TYPE_CD							= 'TITLE'

				left join	 DAT_GOODS_IMAGE_RESIZING 		gir
					on 	g.GOODS_CD							= gir.GOODS_CD
					and	gir.TYPE_CD							= '300'
					
                left join DAT_GOODS_IMAGE_MD				im
					on	g.GOODS_CD  					    = im.GOODS_CD
					and im.TYPE_CD							= 'TITLE' 

				left join	DAT_GOODS_PRICE 				pri
					on 	g.GOODS_CD							= pri.GOODS_CD
					and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
                    
				left join DAT_DELIV_POLICY                   dp
                    on g.DELIV_POLICY_NO                      = dp.DELIV_POLICY_NO
                    
				/*left join DAT_DELIV_POLICY_PATTERN           dpp
                    on dp.DELIV_POLICY_NO                     = dpp.DELIV_POLICY_NO*/
					
					
				/*left join	(	select	mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD
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
						--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn
				on	g.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD*/
				left join	(	select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER
						
						union all
						
						select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS
				) cpn
				on	g.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
				$class_query
			where
				mdG.GUBUN = '".$gubun."'

			group by
				g.GOODS_CD

			order by
				mdG.SEQ

		";

		$db = self::_slave_db();
//		var_dump($query);
        $result = $db->query($query)->result_array();
      //  log_message("DEBUG", "========".$db -> last_query());

		return $result;
	}

    /**
     * 에타 콜렉션
     * 2018.10.18 추가
     */
    public function get_md_goods_collection($gubun)
    {
        $query = "
			select	/*  > etah_front > main_m > get_md_goods_collection > ETAH 에타 콜렉션 상품 */
				  g.GOODS_CD
				, g.GOODS_NM
				, g.PROMOTION_PHRASE
				, b.BRAND_NM
				, if(mdG.IMG_URL = '',i.IMG_URL, ifnull(mdG.IMG_URL,i.IMG_URL))			as IMG_URL
				, pri.SELLING_PRICE
				, mdG.LINK_URL
				, if(mdG.NAME != '', mdG.NAME, g.GOODS_NM)			as NAME
				, sum(if(cpn.MAX_DISCOUNT > 0,
					if(round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
					 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
					 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
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
				left join	DAT_GOODS_IMAGE 				i
					on 	g.GOODS_CD  						= i.GOODS_CD
					and i.TYPE_CD							= 'TITLE'
				left join	DAT_GOODS_PRICE 				pri
					on 	g.GOODS_CD							= pri.GOODS_CD
					and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
				left join	(	select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER
						
						union all
						
						select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS
				) cpn
				on	g.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
			where
				mdG.GUBUN = '".$gubun."'

			group by
				g.GOODS_CD

			order by
				mdG.SEQ

		";
        $db = self::_slave_db();
        $result = $db->query($query)->result_array();

        return $result;
    }

	/**
	 * 에타 브랜드탭 메뉴
	 */
	public function get_md_goods_brand_menu()
	{
		$query = "
			select 	mdG.GUBUN   /*  > etah_front > main_m > get_md_goods_brand_menu > ETAH 에타 브랜드탭 메뉴 */
					, mdG.NAME
					, mdG.IMG_URL
			from 	DAT_MAINCATEGORY_MDGOODS_DISP mdG
			where	mdG.GUBUN in ('MAIN_BRAND1', 'MAIN_BRAND2', 'MAIN_BRAND3', 'MAIN_BRAND4')
			and 	mdG.SEQ = 0

			order by
				mdG.GUBUN
		";
		$db = self::_slave_db();
//		var_dump($query);
		return $db->query($query)->result_array();
	}

	/**
	 * 에타 브랜드탭
	 */
	public function get_md_goods_brand()
	{
		$query = "
			select	/*  > etah_front > main_m > get_md_goods_brand > ETAH 에타 브랜드탭 상품 */
				mdG.GUBUN
				, g.GOODS_CD
				, g.GOODS_NM
				, b.BRAND_NM
				, if(mdG.IMG_URL = '',i.IMG_URL, ifnull(mdG.IMG_URL,i.IMG_URL))			as IMG_URL
				, pri.SELLING_PRICE
				, mdG.SEQ
				, mdG.LINK_URL
				, mdG.RGB
				, mdG.NAME
				, mdG.DISP_HTML
				, sum(if(cpn.MAX_DISCOUNT > 0,
					if(round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
					 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
					 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
				 )													as RATE_PRICE
				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
				, max(cpn.COUPON_CD)								as COUPON_CD
			from
				DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
				inner join	DAT_GOODS						g
					on	mdG.GOODS_CD						= g.GOODS_CD
					and	g.WEB_DISP_YN						= 'Y'
				inner join	DAT_BRAND 						b
					on	g.BRAND_CD 							= b.BRAND_CD
				--	and	b.WEB_DISP_YN						= 'Y'
				inner join	DAT_GOODS_IMAGE 				i
					on 	g.GOODS_CD  						= i.GOODS_CD
					and i.TYPE_CD							= 'TITLE'
				inner join	DAT_GOODS_PRICE 				pri
					on 	g.GOODS_CD							= pri.GOODS_CD
					and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
				/*left join	(	select	mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD
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
						--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn
				on	g.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD*/
				left join	(	select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER
						
						union all
						
						select 
							COUPON_APPLICATION_SCOPE_OBJECT_CD
							, COUPON_CD
							, COUPON_DC_METHOD_CD
							, COUPON_FLAT_RATE
							, COUPON_FLAT_AMT
							, MIN_AMT
							, MAX_DISCOUNT
						from BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS
				) cpn
				on	g.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
			where
					mdG.GUBUN in ('MAIN_BRAND1', 'MAIN_BRAND2', 'MAIN_BRAND3', 'MAIN_BRAND4')

			group by
				g.GOODS_CD

			order by
				mdG.GUBUN , mdG.SEQ

		";
		$db = self::_slave_db();
//		var_dump($query);
		return $db->query($query)->result_array();
	}

    /**
     * 메인 배너
     */
    public function get_main_banner($gubun) {
        $query="
                 select /*  > etah_front > main_m > get_main_banner > ETAH 메인배너 */
                        b.KIND_GB_CD
                        , b.BANNER_MAIN_TITLE
                        , b.BANNER_SUB_TITLE
                        , b.BANNER_SUB_TITLE_2
                        , b.BANNER_FONT_CLASS_GB_CD1
                        , b.BANNER_FONT_CLASS_GB_CD2
                        , b.BANNER_FONT_CLASS_GB_CD3
                        , b.BANNER_FONTCOLOR_CLASS_GB_CD1
                        , b.BANNER_FONTCOLOR_CLASS_GB_CD2
                        , b.BANNER_FONTCOLOR_CLASS_GB_CD3
                        , b.BANNER_FONTWEIGHT_CLASS_GB_CD1
                        , b.BANNER_FONTWEIGHT_CLASS_GB_CD2
                        , b.BANNER_FONTWEIGHT_CLASS_GB_CD3
                        , b.BANNER_FONT_SIZE1
                        , b.BANNER_FONT_SIZE2
                        , b.BANNER_FONT_SIZE3
                        , REPLACE (b.BANNER_IMG_URL, 'http://image.etah.co.kr', 'https://s3-ap-northeast-1.amazonaws.com/image.etah.co.kr' ) as BANNER_IMG_URL   
                        , REPLACE (b.BANNER_LINK_URL, 'http://image.etah.co.kr', 'https://s3-ap-northeast-1.amazonaws.com/image.etah.co.kr' ) as BANNER_LINK_URL
                        , CASE b.BANNER_LOCATION     WHEN 'R' THEN 'right'
                                                      WHEN 'M' THEN 'center'
                                                      WHEN 'L' THEN 'left'      
                                                      END                       as BANNER_LOCATION
 
                from 
                        DAT_BANNER b
                where
                		b.USE_YN = 'Y'
                		and b.KIND_GB_CD = '".$gubun."'
               order by 
               		    b.DISP_SORT
         ";

        $db = self::_slave_db();
        $rows = $db->query($query)->result_array();

        return $rows;
    }

    /**
     * 에타 베스트리뷰
     */
    public function get_md_best_review($gubun) {
        $query = "
                select    	/*  > etah_front > main_m > get_md_best_review > ETAH 에타 베스트리뷰 */
                        g.GOODS_CD
                        , REPLACE(ifnull(ifnull(girm.IMG_URL, gim.IMG_URL), ifnull(gir.IMG_URL, gi.IMG_URL)),'http://image.etah.co.kr' ,'https://s3-ap-northeast-1.amazonaws.com/image.etah.co.kr')		as IMG_URL
                        , gc.`CONTENTS`
                        , b.BRAND_NM
                     -- , g.GOODS_NM
                        , ifnull(gmm.NAME, g.GOODS_NM)      as GOODS_NM
                        , ifnull(c.CUST_ID, gc.WRITER_ID)	as CUST_ID
                        , gc.REG_DT
                from 
                        DAT_MAINCATEGORY_MDGOODS_DISP    md
                        
                        inner join DAT_CUST_GOODS_COMMENT gc
                        on md.GOODS_CD = gc.CUST_GOODS_COMMENT
                        
                        left join DAT_CUST c
                        on gc.CUST_NO = c.CUST_NO
                        
                        inner join DAT_GOODS  g
                        on gc.GOODS_CD = g.GOODS_CD
                        
                        left join DAT_GOODS_MD_MOD gmm
                        on g.GOODS_CD = gmm.GOODS_CD
                        and gmm.USE_YN = 'Y'
                        
                        inner join DAT_BRAND b
                        on g.BRAND_CD  = b.BRAND_CD
                        
                        inner join DAT_GOODS_IMAGE  gi
                        on g.GOODS_CD  = gi.GOODS_CD
                        and gi.TYPE_CD = 'TITLE'
                        
                        left join DAT_GOODS_IMAGE_RESIZING gir
                        on g.GOODS_CD = gir.GOODS_CD
                        and gir.TYPE_CD = '300'
                        
                        left join DAT_GOODS_IMAGE_MD    gim
                         on g.GOODS_CD  = gim.GOODS_CD
                        and gim.TYPE_CD  = 'TITLE'
                        
                       left join DAT_GOODS_IMAGE_RESIZING_MD  girm
                        on g.GOODS_CD = girm.GOODS_CD
                        and girm.TYPE_CD = '300'
                where
                        md.GUBUN = '".$gubun."'
                order by
                        md.SEQ
        ";

        $db = self::_slave_db();

        $rows = $db->query($query)->result_array();

        return $rows;
    }

    /**
     * 에타 인기키워드
     */
    public function get_hashtag($tag_no) {
        $query = "
                select    	/*  > etah_front > main_m > get_hashtag > ETAH 에타 인기키워드 */
                        t.TAG_NM 
                from 
                        DAT_TAG t
                where
                        t.TAG_NO in ($tag_no)
                        and t.AVAIL_FLAG = 'Y'
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 에타 브랜드포커스
     */
    public function get_brand_focus(){
        $query = "
            select      	/*  > etah_front > main_m > get_brand_focus > ETAH 에타 브랜드포커스 */
                        md1.NAME
                        , md1.LINK_URL
                        , REPLACE(md1.IMG_URL,'http://image.etah.co.kr','https://s3-ap-northeast-1.amazonaws.com/image.etah.co.kr')		as LOGO_IMG_URL
                        , md1.DISP_HTML    
                        , REPLACE(md2.IMG_URL,'http://image.etah.co.kr','https://s3-ap-northeast-1.amazonaws.com/image.etah.co.kr') as IMG_URL
            from 
                        DAT_MAINCATEGORY_MDGOODS_DISP md1 
                        inner join DAT_MAINCATEGORY_MDGOODS_DISP md2 
                                on md1.GUBUN        = md2.GUBUN 
                                and md1.GUBUN_NM    = md2.GUBUN_NM 
                                and md1.IMG_URL     != md2.IMG_URL
            where 
                        md1.GUBUN = 'MAIN_BRAND_FOCUS'
            group by
                        md1.GUBUN_NM
            order by
                        md1.SEQ
        ";

        $db = self::_slave_db();
        $rows = $db->query($query)->result_array();

        return $rows;
    }

    /**
     * 홈족피디아
     */
    public function get_magazine( $cate_cd ){
        $query = "
            select    /*  > etah_front > main_m > get_magazine > ETAH 에타 홈족피디아 */
                    m.MAGAZINE_NO
                    , m.TITLE
                    , m.HITS
                    , REPLACE(m.IMG_URL, 'http://' , 'https://s3-ap-northeast-1.amazonaws.com/') AS IMG_URL
            from 
                    DAT_MAGAZINE m 
            where 
                    m.CATEGORY_CD = '".$cate_cd."'
                    and m.USE_YN = 'Y'
            order by 
                    m.MAGAZINE_NO desc
            limit 5
        ";

        $db = self::_slave_db();
        $rows = $db->query($query)->result_array();

        return $rows;
    }


}http://dev.etah.co.kr/goods/detail/688