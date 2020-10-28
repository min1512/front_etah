<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch_m extends CI_Model {

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
     * insert table
     *
     * @return mixed
     */
    public function insert_table( $table_name, $param )
    {
        $db = self::_master_db();
        $query_insert = $db->insert_string( $table_name, $param );

        try{
            $db->query( $query_insert );
        }catch( Exception $E ){

            return false;
        }
//log_message('DEBUG', '=========='.$db->last_query());
        return $db->insert_id();
    }

    /**
     * delete data
     *
     * @return mixed
     */
    public function delete_data( $table_name, $where_condition )
    {
        $db = self::_master_db();

        $query_delete = "
            delete from $table_name
            where
                $where_condition
        ";
        $result = $db->query( $query_delete );

        return $result;
    }

	/**
	 * BAT_ETAH_CHOICE table  비우기
	 */
	public function truncat_table_etah_choice(){
		$result = false;
		$db = self::_master_db();
		
		if ($db->simple_query("truncate table BAT_ETAH_CHOICE")){
			$result = true;
			echo "------------------------------ truncate table BAT_ETAH_CHOICE success ------------------------------".PHP_EOL;
		}else{
			$result = false;
			echo "------------------------------ truncate table BAT_ETAH_CHOICE fail ------------------------------".PHP_EOL;
		}
		
		return $result;
	}

	/**
	*etah choice 데이터 가져오기
	**/
	public function select_etah_choice(){
		$query = "
			select    	/*  > etah_front > batch_m > select_etah_choice > etah choice 데이터 가져오기 */
				g.GOODS_CD
			--	, g.GOODS_NM
                , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
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
				, mdG.GUBUN
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
		--	where not mdG.GUBUN = 'MAIN_ETAH_CHOICE'
		    where mdG.GUBUN like 'CATE_CHOICE_%'
			
			group by
					g.GOODS_CD, mdG.GUBUN
		";
		$db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ select_etah_choice : '.$query);
		echo "------------------------------ select_etah_choice ------------------------------".PHP_EOL;
		echo "------------------------------ ".$query." ------------------------------".PHP_EOL;
		return $db->query($query)->result_array();
	}


	/**
	* etah choice 데이터 입력
	*/
	public function insert_etah_choice($param){
		
		$db = self::_master_db();
		$query_insert = $db->insert_string( "BAT_ETAH_CHOICE", $param );
		try{
            $db->query( $query_insert );
			echo "------------------------------ insert_etah_choice sucess ------------------------------".PHP_EOL;
        }catch( Exception $E ){
			echo "------------------------------ insert_etah_choice fail".$E." ------------------------------".PHP_EOL;
            return false;
        }

	}


	/**
	 * BAT_ETAH_WEEK_BEST table  비우기
	 */
	public function truncat_table_etah_weekley(){
		$result = false;
		$db = self::_master_db();
		
		if ($db->simple_query("truncate table BAT_ETAH_WEEK_BEST")){
			$result = true;
			echo "------------------------------ truncate table BAT_ETAH_WEEK_BEST success ------------------------------".PHP_EOL;
		}else{
			$result = false;
			echo "------------------------------ truncate table BAT_ETAH_WEEK_BEST fail ------------------------------".PHP_EOL;
		}
		
		return $result;
	}


	/**
	*etah weekley 데이터 가져오기
	**/
	public function select_etah_weekley($param){
        log_message('DEBUG', '============================ select_etah_weekley : in model');
		$query = "
			select	/*  > etah_front > batch_m > select_etah_weekley > etah weekley 데이터 가져오기 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.BRAND_NM
				, t.SELLING_PRICE
			--	, i.IMG_URL
			--	, if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
                , ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, i.IMG_URL))		as IMG_URL
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
				, if(round(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, round(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_S
				, if(round(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, round(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_G
				, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
				, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
				, cpn_s.COUPON_CD									as COUPON_CD_S
				, cpn_g.COUPON_CD									as COUPON_CD_G
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
				, t.PARENT_CATEGORY_DISP_CD
				, t.GOODS_SORT_SCORE				

			from

			(
				select
					g.GOODS_CD
				--	, g.GOODS_NM
                    , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
					, b.BRAND_NM
					, pri.SELLING_PRICE
					, sort.GOODS_SORT_SCORE
					, g.GOODS_MILEAGE_N_GOODS_NO
					, g.DELIV_POLICY_NO
					,m.PARENT_CATEGORY_DISP_CD

				from
					DAT_GOODS g
					left join DAT_GOODS_MD_MOD                gmm
                        on g.GOODS_CD                          = gmm.GOODS_CD
                        and gmm.USE_YN                         = 'Y'
					inner join	(	select	distinct
										mc.GOODS_CD
										, c2.PARENT_CATEGORY_DISP_CD
									from	MAP_CATEGORY_DISP_N_GOODS 	mc
									inner join	DAT_CATEGORY_DISP				c3
										on	mc.CATEGORY_DISP_CD					= c3.CATEGORY_DISP_CD
								--		and	c3.WEB_DISP_YN						= 'Y'
									inner join	DAT_CATEGORY_DISP				c2
										on	c3.PARENT_CATEGORY_DISP_CD			= c2.CATEGORY_DISP_CD
										and c2.PARENT_CATEGORY_DISP_CD IN (SELECT A.CATEGORY_DISP_CD FROM DAT_CATEGORY_DISP A WHERE A.PARENT_CATEGORY_DISP_CD IS NULL )
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
					#limit 0, 12
				) t
				inner join	DAT_GOODS_IMAGE						i
					on	t.GOODS_CD								= i.GOODS_CD
					and	i.TYPE_CD								= 'TITLE'
				left join	 DAT_GOODS_IMAGE_RESIZING 		    gir
					on 	t.GOODS_CD								= gir.GOODS_CD
					and	gir.TYPE_CD								= '400'
                left join	DAT_GOODS_IMAGE_MD		            im
					on	t.GOODS_CD								= im.GOODS_CD
					and	im.TYPE_CD								= 'TITLE'
				left join	 DAT_GOODS_IMAGE_RESIZING_MD 		girm
					on 	t.GOODS_CD								= girm.GOODS_CD
					and	girm.TYPE_CD							= '400'
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
			
			where t.PARENT_CATEGORY_DISP_CD = ?
			group by
				t.GOODS_CD
			order by t.GOODS_SORT_SCORE desc
			
			limit 0 , 12
			
		";
		$db = self::_master_db();
        $result = $db->query($query, $param)->result_array();
		echo "------------------------------ select_etah_weekley ------------------------------".PHP_EOL;
		echo "------------------------------ ".$query." ------------------------------".PHP_EOL;
		return $result;
	}


	/**
	* etah weekley 데이터 입력
	*/
	public function insert_etah_weekley($param){
		
		$db = self::_master_db();
		$query_insert = $db->insert_string( "BAT_ETAH_WEEK_BEST", $param );
		try{
            $db->query( $query_insert );
			echo "------------------------------ insert_etah_weekley success ------------------------------".PHP_EOL;
        }catch( Exception $E ){
			//log_message('error', '============================ insert_etah_weekley : '.$E);
			echo "------------------------------ insert_etah_weekley fail".$E." ------------------------------".PHP_EOL;
            return false;
        }

        return true;
	}


	/**
	 * BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER table  비우기
	 */
	public function truncat_table_coupon_seller(){
		$result = false;
		$db = self::_master_db();
		
		if ($db->simple_query("truncate table BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER")){
			$result = true;
			echo "------------------------------ truncate table BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER success ------------------------------".PHP_EOL;
		}else{
			$result = false;
			echo "------------------------------ truncate table BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER fail ------------------------------".PHP_EOL;
		}
		
		return $result;
	}


	/**
	* seller coupon 데이터 가져오기
	**/
	public function select_coupon_seller(){
		$query = "
			select	  /*  > etah_front > batch_m > select_coupon_seller > seller coupon 데이터 가져오기 */
			        convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
					, cpn_s.COUPON_CD
					, cpn_s.COUPON_DC_METHOD_CD
					, cpn_s.COUPON_FLAT_RATE
					, cpn_s.COUPON_FLAT_AMT
					, cpn_s.MIN_AMT
					, cpn_s.MAX_DISCOUNT
			from
				MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
			inner join DAT_COUPON	cpn_s
				on	mcp.COUPON_CD					 = cpn_s.COUPON_CD
				and cpn_s.COUPON_KIND_CD				 in ('SELLER')
				and cpn_s.USE_YN						 = 'Y'
			--		and cpn_s.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
				and	if(cpn_s.COUPON_START_DT is null,  1 = 1, cpn_s.COUPON_START_DT	<= now()	and cpn_s.COUPON_END_DT	>= now())

			inner join DAT_COUPON_PROGRESS cpp
				on	cpn_s.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
				and cpp.COUPON_PROGRESS_STS_CD		= '03'
				and	cpp.USE_YN						= 'Y'
			inner join DAT_GOODS g
				on g.GOODS_CD = mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	
			inner join DAT_GOODS_PROGRESS p
				on p.GOODS_PROGRESS_NO = g.GOODS_PROGRESS_NO
				and p.GOODS_STS_CD = '03'	
		";
		$db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ select_coupon_seller : '.$query);
		echo "------------------------------ select_coupon_seller ------------------------------".PHP_EOL;
		echo "------------------------------ ".$query." ------------------------------".PHP_EOL;
		return $db->query($query)->result_array();
	}

	
	/**
	* seller coupon 데이터 입력
	*/
	public function insert_coupon_seller($param,$seq){
		
		$db = self::_master_db();
		$param['TIME_SEQ'] = $seq;
		self::delete_data("BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER","COUPON_APPLICATION_SCOPE_OBJECT_CD = '".$param['COUPON_APPLICATION_SCOPE_OBJECT_CD']."'");
		$query_insert = $db->insert_string( "BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER", $param );
		try{
            $db->query( $query_insert );
			echo "------------------------------ insert_coupon_seller success ------------------------------".PHP_EOL;
        }catch( Exception $E ){
			//log_message('error', '============================ insert_coupon_seller : '.$E);
			echo "------------------------------ insert_coupon_seller fail".$E." ------------------------------".PHP_EOL;
            return false;
        }
	}


	/**
	 * BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS table  비우기
	 */
	public function truncat_table_coupon_goods(){
		$result = false;
		$db = self::_master_db();
		
		if ($db->simple_query("truncate table BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS")){
			$result = true;
			echo "------------------------------ truncate table BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER success ------------------------------".PHP_EOL;
		}else{
			$result = false;
			echo "------------------------------ truncate table BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER fail ------------------------------".PHP_EOL;
		}
		
		return $result;
	}


	/**
	* goods coupon 데이터 가져오기
	**/
	public function select_coupon_goods(){
		$query = "
			select	  /*  > etah_front > batch_m > select_coupon_goods > goods coupon 데이터 가져오기 */
			        convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
					, cpn_s.COUPON_CD
					, cpn_s.COUPON_DC_METHOD_CD
					, cpn_s.COUPON_FLAT_RATE
					, cpn_s.COUPON_FLAT_AMT
					, cpn_s.MIN_AMT
					, cpn_s.MAX_DISCOUNT
			from
				MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
			inner join DAT_COUPON	cpn_s
				on	mcp.COUPON_CD					 = cpn_s.COUPON_CD
				and cpn_s.COUPON_KIND_CD				 in ('GOODS')
				and cpn_s.USE_YN						 = 'Y'
			--		and cpn_s.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
				and	if(cpn_s.COUPON_START_DT is null,  1 = 1, cpn_s.COUPON_START_DT	<= now()	and cpn_s.COUPON_END_DT	>= now())

			inner join DAT_COUPON_PROGRESS cpp
				on	cpn_s.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
				and cpp.COUPON_PROGRESS_STS_CD		= '03'
				and	cpp.USE_YN						= 'Y'
			inner join DAT_GOODS g
				on g.GOODS_CD = mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	
			inner join DAT_GOODS_PROGRESS p
				on p.GOODS_PROGRESS_NO = g.GOODS_PROGRESS_NO
				and p.GOODS_STS_CD = '03'	
				
			group by  cpn_s.COUPON_CD	
		";
		$db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ select_coupon_goods : '.$query);
		echo "------------------------------ select_coupon_goods ------------------------------".PHP_EOL;
		echo "------------------------------ ".$query." ------------------------------".PHP_EOL;
		return $db->query($query)->result_array();
	}

	
	/**
	* goods coupon 데이터 입력
	*/
	public function insert_coupon_goods($param,$seq){
		
		$db = self::_master_db();
        $param['TIME_SEQ'] = $seq;
        self::delete_data("BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS","COUPON_APPLICATION_SCOPE_OBJECT_CD = '".$param['COUPON_APPLICATION_SCOPE_OBJECT_CD']."'");
		$query_insert = $db->insert_string( "BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS", $param );
		try{
            $db->query( $query_insert );
			echo "------------------------------ insert_coupon_goods success ------------------------------".PHP_EOL;
        }catch( Exception $E ){
			//log_message('error', '============================ insert_coupon_goods : '.$E);
			echo "------------------------------ insert_coupon_goods fail".$E." ------------------------------".PHP_EOL;
            return false;
        }
	}


    /**
     * 모바일용 브랜드 리스트 업데이트용(판매중인 상품이 있는 브랜드만 보이게)
     */
    public function update_brand_list($table){

        $db = self::_master_db();

        //브랜드전시여부 N 일괄변경
        $query1 = "update DAT_BRAND set BRAND_DISP_YN = 'N'";
        $db->query($query1);

        //판매중인 상품이 있는 브랜드만 브랜드전시여부 Y 변경
        $rows = self::select_brand_list();

        foreach($rows as $row)
        {
            $query2 = "update DAT_BRAND set BRAND_DISP_YN = 'Y' where BRAND_CD = '".$row['BRAND_CD']."'";
            $db->query($query2);
        }

//		$data = array('BRAND_DISP_YN' => 'Y');
//
//		foreach($rows as $row)
//		{
//			$where = "BRAND_CD = '$row[BRAND_CD]'";
//			$query_update = $db->update_string( $table, $data, $where );
//
//			try{
//				$result = $db->query($query_update);
//			}
//			catch(Exception $E){
//				echo "------------------------------ update_brand_list fail".$E." ------------------------------<br>".PHP_EOL;
//				return false;
//			}
//		}
    }
	
	/**
	* 모바일용 브랜드 리스트 출력(상품판매중인 브랜드 리스트)
	*/
	public function select_brand_list()
	{
		$db = self::_master_db();
		
		$query_select = "select b.BRAND_CD    /*  > etah_front > batch_m > select_brand_list > 모바일용 브랜드 리스트 출력 */
							, b.BRAND_NM
							, b.BRAND_NM_FST_LETTER

						from DAT_BRAND b

						inner join DAT_GOODS g
							on b.BRAND_CD = g.BRAND_CD

						inner join (
										select rdgp.GOODS_PROGRESS_NO as GOODS_PROGRESS_NO,
											rdgp.GOODS_CD as GOODS_CD,
											rdgp.GOODS_STS_CD as GOODS_STS_CD
										from(
												select	max(dgp.GOODS_PROGRESS_NO) as GOODS_PROGRESS_NO,
													dgp.GOODS_CD,
													dgp.GOODS_STS_CD
												from DAT_GOODS_PROGRESS dgp
												group by dgp.GOODS_CD
											) t1
										inner join DAT_GOODS_PROGRESS rdgp
											on t1.GOODS_PROGRESS_NO = rdgp.GOODS_PROGRESS_NO
											and t1.GOODS_CD = rdgp.GOODS_CD
										where rdgp.GOODS_STS_CD = '03'
									) t2
							on g.GOODS_CD = t2.GOODS_CD

						where  b.USE_YN = 'Y'
						and b.MOB_DISP_YN = 'Y'
						group by b.BRAND_NM, b.BRAND_CATEGORY_CD
						order by b.BRAND_NM_FST_LETTER, b.BRAND_NM
					";
		echo "------------------------------ select_brand_list ------------------------------<br>".PHP_EOL;
		return $db->query($query_select)->result_array();			
	}

	/**
     * 회원가입 마일리지 적립 대상 조회
     */
	public function select_mileage_default(){
        $db = self::_master_db();

        $query_select = "select c.CUST_NO    /*  > etah_front > batch_m > select_mileage_default > 회원가입 마일리지 적립 대상 조회 */
						  from DAT_CUST c
						where  c.DEFAULT_MILEAGE = 'N'
					";
        return $db->query($query_select)->result_array();
    }

    /**
     * 회원가입 마일리지 적립
     */
    public function insert_mileage_default($custNo){
        $db = self::_master_db();

        $query1 = "
				insert into	DAT_CUST_MILEAGE    /*  > etah_front > batch_m > insert_mileage_default > 회원가입 마일리지 적립 (총마일리지액) */
				(CUST_NO,SAVE_MILEAGE_AMT, MILEAGE_AMT, REG_USER_CD)
				values(
					?, 2000, 2000, 246)
					on duplicate key update
						CUST_NO= ?
						, SAVE_MILEAGE_AMT=SAVE_MILEAGE_AMT+ 2000
						, MILEAGE_AMT=MILEAGE_AMT+ 2000
			";

        $db->query($query1, array($custNo, $custNo));

        $query2 = "
				insert into	DAT_CUST_MILEAGE_SAVING   /*  > etah_front > batch_m > insert_mileage_default > 회원가입 마일리지 적립 (적립내역) */
				(CUST_NO,ORDER_REFER_NO, ORDER_DT, MILEAGE_SAVING_AMT, SAVE_YN,
				 SAVE_DT, SAVING_REASON_GB_CD, SAVING_REASON_ETC, REG_USER_CD)
				values(
					?, ?, ?, 2000, 'Y', now(), 'EVENT', '회원가입 축하 이벤트', 246)
			";

        $db->query($query2, array($custNo, 200010663, '2017-12-20 18:21:23'));


        $query3 = "
				update DAT_CUST   /*  > etah_front > batch_m > insert_mileage_default > 회원가입 마일리지 적립여부 수정 */
				set DEFAULT_MILEAGE ='Y'
				where CUST_NO = ?
			";

        $db->query($query3, $custNo);

        $timenow = date("Y-m-d H:i:s");
        $timetarget = "2019-09-17 14:00:00";
        $timetarget2 = "2019-09-23 23:59:59";

        $str_now = strtotime($timenow);
        $str_target = strtotime($timetarget);
        $str_target2 = strtotime($timetarget2);

        if($str_target < $str_now && $str_now < $str_target2) {

        $query4 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
                  values(1337750,?,14)";

        $db->query($query4, $custNo);

        $query5 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
              values(1337751,?,14)";

        $db->query($query5, $custNo);

        $query6 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
              values(1337752,?,14)";

        $db->query($query6, $custNo);

        $query7 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
                  values(?, 1337750,'01',14)";

        $db->query($query7, $custNo);

        $query8 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
              values(?, 1337751,'01',14)";

        $db->query($query8, $custNo);

        $query9 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
              values(?, 1337752,'01',14)";

        $db->query($query9, $custNo);

        }



//        $timenow = date("Y-m-d H:i:s");
//        $timetarget = "2018-12-31 12:15:00";
//        $timetarget2 = "2019-01-13 23:59:59";
//
//        $str_now = strtotime($timenow);
//        $str_target = strtotime($timetarget);
//        $str_target2 = strtotime($timetarget2);
//
//        if($str_target < $str_now && $str_now < $str_target2) {
//
//        $query4 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1184818,?,14)";
//
//        $db->query($query4, $custNo);
////        log_message("DEBUG", "===========CUST_NO1 = ".$db->last_query());
//
//        $query5 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1184819,?,14)";
//
//        $db->query($query5, $custNo);
////        log_message("DEBUG", "===========CUST_NO2 = ".$db->last_query());
//        $query6 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1184820,?,14)";
//
//        $db->query($query6, $custNo);
////        log_message("DEBUG", "===========CUST_NO3 = ".$db->last_query());
//        $query7 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1184818,'01',14)";
//
//        $db->query($query7, $custNo);
////        log_message("DEBUG", "===========CUST_NO5 = ".$db->last_query());
//        $query8 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1184819,'01',14)";
//
//        $db->query($query8, $custNo);
////        log_message("DEBUG", "===========CUST_NO6 = ".$db->last_query());
//        $query9 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1184820,'01',14)";
//
//        $db->query($query9, $custNo);
////        log_message("DEBUG", "===========CUST_NO7 = ".$db->last_query());
//
//        }
    }


    /**
     * 에스크로 결제 완료주문중 배송시작 된 주문 리스트
     * @auth beom
     */
    public function select_delive_escrow(){
        $db = self::_master_db();

        $query_select = "select r.ORDER_NO   /*  > etah_front > batch_m > select_delive_escrow > 에스크로 결제 완료주문중 배송시작 된 주문 리스트 */
                                , r.INVOICE_NO
                                , r.DELIV_COMPANY_CD
                                , d.ORDER_PAY_DTL_NO
                                , if(r.DELIV_COMPANY_CD = 99 , 'ETC', (select CD_NM_EN from COD_DELIV_COMPANY where DELIV_COMPANY_CD = r.DELIV_COMPANY_CD)) as DELIV_COMPANY_NM
                                , if(r.DELIV_COMPANY_CD = 99 , '0000', r.INVOICE_NO) as INVOICE_NO
                                , d.IMP_UID
                        from
                            DAT_ORDER_REFER r
                            inner join DAT_ORDER o
                                on r.ORDER_NO = o.ORDER_NO
                            inner join DAT_ORDER_PAY p
                                on o.ORDER_NO = p.ORDER_NO
                                and p.ORDER_PAY_STS_CD = '02'
                            inner join DAT_ORDER_PAY_DTL d
                                on p.PAY_NO = d.PAY_NO
                                and d.ESCROW_YN = 'Y'
                        		and d.ESCROW_FLG = 'N'
                        where r.INVOICE_NO is not null
                           
                                            ";
        return $db->query($query_select)->result_array();

    }

    /**
     * 에스크로 배송시작 통신 성공 후 상태값 변경
     * @auth beom
     */
    public function update_delive_escrow($order_pay_dtl_no){
        $db = self::_master_db();

        $query = "
				update DAT_ORDER_PAY_DTL    /*  > etah_front > batch_m > update_delive_escrow > 에스크로 배송시작 통신 성공 후 상태값 변경 */
				set ESCROW_FLG ='Y'
				where IMP_UID = ?
			";

        $db->query($query, $order_pay_dtl_no);
    }

    /**
     * 남은 쿠폰 데이터 지우기
     * @auth beom
     */
    public function delete_coupon_seller($seq)
    {
        $mdb = self::_master_db();

        $mdb->trans_begin();

        self::delete_data('BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER',"NOT TIME_SEQ = '".$seq."'");

        if ( $mdb->trans_status() === FALSE ){
            $mdb->trans_rollback();
            return false;
        }else{
            $mdb->trans_commit();
            return true;
        }
    }

    public function delete_coupon_goods($seq)
    {
        $mdb = self::_master_db();

        $mdb->trans_begin();

        self::delete_data('BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS',"NOT TIME_SEQ = '".$seq."'");

        if ( $mdb->trans_status() === FALSE ){
            $mdb->trans_rollback();
            return false;
        }else{
            $mdb->trans_commit();
            return true;
        }
    }
}