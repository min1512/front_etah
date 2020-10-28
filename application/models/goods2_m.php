<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods2_m extends CI_Model {

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
     * 카테고리별 브랜드 상품 개수
     */
    public function get_brand_goods_count($param)
    {
        $str_brand_cd			= "";
        $query_category			= "";
        $query_search_keyword	= "";
        $query_category_attr	= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){
                $query_category = "and	m.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            $str_brand_cd = substr($str_brand_cd, 3);
        }

        /* 카테고리 속성 검색 */
        if($param['attr']){
            $str_attr_cd = str_replace('|',"','", $param['attr']);
            if(strpos($str_attr_cd, ',')) $str_attr_cd = substr($str_attr_cd, 3);
//var_dump($str_attr_cd);

            $query_category_attr = "
				inner join 	MAP_CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR 	ma
					on	m.CATEGORY_DISP_CD				= ma.CATEGORY_DISP_CD
					and ma.USE_YN						= 'Y'
					and ma.GOODS_CLASSIFICATION_ATTR_CD	in ('".$str_attr_cd."')
				inner join	MAP_CLASS_ATTR_N_GOODS 		mag
					on 	g.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO
			";
        }

        /* 검색 */
//		if($param['keyword']) $query_search_keyword = "and	(g.GOODS_NM like '%".$param['keyword']."%' or g.PROMOTION_PHRASE like '%".$param['keyword']."%' or b.BRAND_NM = '".$param['keyword']."')";
        if($param['keyword']) $query_search_keyword = "and	g.GOODS_NM like '".$param['keyword']."%'";

        /* 걸과 내 재검색 */
        if($param['r_keyword']){
            $str_keyword = "";
            $arr_keyword = explode('||', $param['r_keyword']);
            $i = 0;
            foreach($arr_keyword as $key){
                if($i == 0){
                    $query_search_keyword .= "and (g.GOODS_NM like '%".$key."%' or g.PROMOTION_PHRASE like '%".$key."%' or b.BRAND_NM = '".$key."')";
                }else{
                    $query_search_keyword .= "\nand (g.GOODS_NM = '".$key."' or g.PROMOTION_PHRASE = '".$key."' or b.BRAND_NM = '".$key."')";
                }
                $i++;
            }
        }

        $query = "
			select	/*  > etah_front > goods2_m > get_brand_goods_count > ETAH 브랜드 상품개수 구하기 */
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
					inner join	DAT_GOODS_PROGRESS			gp
						on	g.GOODS_CD 						= gp.GOODS_CD
						and g.GOODS_PROGRESS_NO				= gp.GOODS_PROGRESS_NO
						and	gp.GOODS_STS_CD					= '03'
					inner join	MAP_CATEGORY_DISP_N_GOODS	m
						on	m.GOODS_CD 						= g.GOODS_CD
					inner join	DAT_CATEGORY_DISP 			c
						on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
					$query_category_attr
				where
					1 = 1
					$query_search_keyword
					$query_category
				group by
					CODE
			) b
			inner join	DAT_BRAND		bb
				on 	bb.BRAND_CD			= b.CODE
			left join	DAT_BRAND		lb
				on 	lb.BRAND_CD			= b.CODE
				and lb.BRAND_CD 		in('".$str_brand_cd."')
			order by
				bb.BRAND_NM
		";
        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 카테고리별 상품 구하기
     */
    public function get_goods_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;
        $query_category			= "";
        $query_mid_category		= "";
        $query_brand			= "";
        $query_price_limit		= "";
        $query_order_by			= "";
        $query_search_keyword	= "";
        $query_category_attr	= "";
//var_dump($param);
        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){		//소분류
                $query_category = "and	m.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){	//중분류
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";

                if($param['arr_cate']){
                    $str_cate_cd = str_replace('|',"','", $param['arr_cate']);
                    if(strpos($str_cate_cd, ',')) $str_cate_cd = substr($str_cate_cd, 3);
                    $query_mid_category = "and c.CATEGORY_DISP_CD in ('".$str_cate_cd."')";
                }
            }
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

        /* 카테고리 속성 검색 */
        if($param['attr']){
            $str_attr_cd = str_replace('|',"','", $param['attr']);
            if(strpos($str_attr_cd, ',')) $str_attr_cd = substr($str_attr_cd, 3);
//var_dump($str_attr_cd);
            $query_category_attr = "
				inner join 	MAP_CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR 	ma
					on	c.CATEGORY_DISP_CD				= ma.CATEGORY_DISP_CD
					and ma.USE_YN						= 'Y'
					and ma.GOODS_CLASSIFICATION_ATTR_CD	in ('".$str_attr_cd."')
				inner join	MAP_CLASS_ATTR_N_GOODS 		mag
					on 	g.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO
			";
        }

        /* 정렬 */
        if($param['order_by']){
            switch($param['order_by']){
                case 'A' : $query_order_by = "order by	g.GOODS_CD desc"; break; //신상품순
                case 'B' : $query_order_by = ""; break;	//인기순
                case 'C' : $query_order_by = "order by	pri.SELLING_PRICE asc"; break;	//낮은가격순
                case 'D' : $query_order_by = "order by	pri.SELLING_PRICE desc"; break;	//높은가격순
            }
        }

        /* 검색 */
        if($param['keyword']) $query_search_keyword = "and	(g.GOODS_NM like '%".$param['keyword']."%' or g.PROMOTION_PHRASE like '%".$param['keyword']."%' or b.BRAND_NM = '".$param['keyword']."')";

        /* 걸과 내 재검색 */
        if($param['r_keyword']){
            $str_keyword = "";
            $arr_keyword = explode('||', $param['r_keyword']);
            $i = 0;
            foreach($arr_keyword as $key){
                if($i == 0){
                    $query_search_keyword .= "and (g.GOODS_NM like '%".$key."%' or g.PROMOTION_PHRASE like '%".$key."%' or b.BRAND_NM = '".$key."')";
                }else{
                    $query_search_keyword .= "\nand (g.GOODS_NM = '".$key."' or g.PROMOTION_PHRASE = '".$key."' or b.BRAND_NM = '".$key."')";
                }
                $i++;
            }
        }

        $query = "
			select	/*  > etah_front > goods2_m > get_goods_list > ETAH 상품리스트 */
				g.GOODS_CD
				, g.GOODS_NM
				, g.PROMOTION_PHRASE
				, g.BRAND_CD
				, b.BRAND_NM
				, c.CATEGORY_DISP_CD
				, c.CATEGORY_DISP_NM
				, pri.SELLING_PRICE
				, gi.IMG_URL
			from
				DAT_GOODS 				g
			inner join	DAT_BRAND 					b
				on	g.BRAND_CD 						= b.BRAND_CD
			inner join	MAP_CATEGORY_DISP_N_GOODS	m
				on	g.GOODS_CD						= m.GOODS_CD
			inner join	DAT_CATEGORY_DISP 			c
				on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
			inner join	DAT_GOODS_PRICE 			pri
				on	g.GOODS_CD 						= pri.GOODS_CD
				and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_PROGRESS			gp
				on	g.GOODS_CD 						= gp.GOODS_CD
				and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
				and	gp.GOODS_STS_CD					= '03'
			inner join	COD_GOODS_STS_CD			gs
				on	gp.GOODS_STS_CD 				= gs.GOODS_STS_CD
			inner join	DAT_GOODS_IMAGE				gi
				on 	g.GOODS_CD 						= gi.GOODS_CD
				and	gi.TYPE_CD						= 'TITLE'
			$query_category_attr
			where
				1 = 1
			$query_category
			$query_brand
			$query_price_limit
			$query_search_keyword
			$query_mid_category
			group by
				g.GOODS_CD
			$query_order_by
			$query_limit

		";
        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 카테고리별 상품 개수 구하기
     */
    public function get_goods_list_count($param)
    {
        $query_price_limit		= "";
        $query_category			= "";
        $query_brand			= "";
        $query_search_keyword	= "";
        $query_category_attr	= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){
                $query_category = "and	m.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
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

        /* 카테고리 속성 검색 */
        if($param['attr']){
            $str_attr_cd = str_replace('|',"','", $param['attr']);
            if(strpos($str_attr_cd, ',')) $str_attr_cd = substr($str_attr_cd, 3);
//var_dump($str_attr_cd);
            $query_category_attr = "
				inner join 	MAP_CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR 	ma
					on	c.CATEGORY_DISP_CD				= ma.CATEGORY_DISP_CD
					and ma.USE_YN						= 'Y'
					and ma.GOODS_CLASSIFICATION_ATTR_CD	in ('".$str_attr_cd."')
				inner join	MAP_CLASS_ATTR_N_GOODS 		mag
					on 	g.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO

			";
        }

        /* 검색 */
        if($param['keyword']) $query_search_keyword = "and	(g.GOODS_NM like '%".$param['keyword']."%' or g.PROMOTION_PHRASE like '%".$param['keyword']."%' or b.BRAND_NM = '".$param['keyword']."')";

        /* 걸과 내 재검색 */
        if($param['r_keyword']){
            $str_keyword = "";
            $arr_keyword = explode('||', $param['r_keyword']);
            $i = 0;
            foreach($arr_keyword as $key){
                if($i == 0){
                    $query_search_keyword .= "and (g.GOODS_NM like '%".$key."%' or g.PROMOTION_PHRASE like '%".$key."%' or b.BRAND_NM = '".$key."')";
                }else{
                    $query_search_keyword .= "\nand (g.GOODS_NM = '".$key."' or g.PROMOTION_PHRASE = '".$key."' or b.BRAND_NM = '".$key."')";
                }
                $i++;
            }
        }

        $query = "
			select	/*  > etah_front > goods2_m > get_goods_list_count > ETAH 상품리스트 개수 */
				count(distinct g.GOODS_CD)			as CNT
			from
				DAT_GOODS 				g
			inner join	DAT_BRAND 					b
				on	g.BRAND_CD 						= b.BRAND_CD
			inner join	MAP_CATEGORY_DISP_N_GOODS	m
				on	g.GOODS_CD						= m.GOODS_CD
			inner join	DAT_CATEGORY_DISP 			c
				on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
			inner join	DAT_GOODS_PRICE				pri
				on	g.GOODS_CD 						= pri.GOODS_CD
				and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_PROGRESS			gp
				on	g.GOODS_CD 						= gp.GOODS_CD
				and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
				and	gp.GOODS_STS_CD					= '03'
			$query_category_attr
			where
				1 = 1
			$query_category
			$query_brand
			$query_price_limit
			$query_search_keyword

		";
        $db = self::_slave_db();
//		var_dump($query);
        $data = $db->query($query)->row_array();
        return $data['CNT'];
    }

    /**
     * 검색결과별 카테고리
     */
    public function get_category_list_by_search($param)
    {
        $query_search_keyword = "";

        /* 검색 */
//		if($param['keyword']) $query_search_keyword = "and	(g.GOODS_NM like '%".$param['keyword']."%' or g.PROMOTION_PHRASE like '%".$param['keyword']."%' or b.BRAND_NM = '".$param['keyword']."')";
        if($param['keyword']) $query_search_keyword = "and	g.GOODS_NM like '".$param['keyword']."%'";

        /* 걸과 내 재검색 */
        if($param['r_keyword']){
            $str_keyword = "";
            $arr_keyword = explode('||', $param['r_keyword']);
            $i = 0;
            foreach($arr_keyword as $key){
                if($i == 0){
                    $query_search_keyword .= "and (g.GOODS_NM like '%".$key."%' or g.PROMOTION_PHRASE like '%".$key."%' or b.BRAND_NM = '".$key."')";
                }else{
                    $query_search_keyword .= "\nand (g.GOODS_NM = '".$key."' or g.PROMOTION_PHRASE = '".$key."' or b.BRAND_NM = '".$key."')";
                }
                $i++;
            }
        }

        $query = "
			select	/*  > etah_front > goods2_m > get_category_list_by_search > ETAH 검색결과 카테고리 구하기 */
				c1.CATEGORY_DISP_CD				as CATE_CODE1
				, c1.CATEGORY_DISP_NM			as CATE_NAME1
				, count(distinct g.GOODS_CD)	as CATE_CNT
				, c3.CATEGORY_DISP_CD			as CATE_CODE3
			from
				DAT_GOODS			g
			inner join	DAT_BRAND					b
				on	g.BRAND_CD						= b.BRAND_CD
			inner join	MAP_CATEGORY_DISP_N_GOODS	m
				on 	g.GOODS_CD						= m.GOODS_CD
			inner join	DAT_GOODS_PROGRESS			p
				on	p.GOODS_PROGRESS_NO				= g.GOODS_PROGRESS_NO
				and p.USE_YN						= 'Y'
				and p.GOODS_STS_CD					= '03'
			inner join	DAT_CATEGORY_DISP			c3
				on	m.CATEGORY_DISP_CD				= c3.CATEGORY_DISP_CD
			inner join	DAT_CATEGORY_DISP			c2
				on 	c3.PARENT_CATEGORY_DISP_CD		= c2.CATEGORY_DISP_CD
			inner join	DAT_CATEGORY_DISP			c1
				on 	c2.PARENT_CATEGORY_DISP_CD		= c1.CATEGORY_DISP_CD
			where
				1 = 1
				$query_search_keyword
			group by
				c1.CATEGORY_DISP_CD
			order by
				c1.CATEGORY_DISP_CD

		";
        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }


    /**
     * 브랜드 정보 구하기
     */
    public function get_brand_detail($brand_cd)
    {
        $query = "
			select	/*  > etah_front > goods2_m > get_brand_detail > ETAH 브랜드 정보 구하기 */
				b.BRAND_CD
				, b.PARENT_BRAND_CD
				, b.BRAND_CATEGORY_CD
				, b.BRAND_NM
				, b.BRAND_ENG_NM
				, b.WEB_BRAND_LOGO_URL
				, b.WEB_BRAND_IMG_URL
				, b.WEB_BRAND_DESC
				, b.MOB_BRAND_LOGO_URL
				, b.MOB_BRAND_IMG_URL
				, b.MOB_BRAND_DESC
				, c.DC_COUPON_NM

			from
				DAT_BRAND	b
				left join	MAP_COUPON_APPLICATION_SCOPE_OBJECT m
					on	m.COUPON_APPLICATION_SCOPE_OBJECT_CD 	= b.BRAND_CD
					and m.USE_YN								= 'Y'
				left join	DAT_COUPON 							c
					on 	c.COUPON_CD 							= m.COUPON_CD
					and c.USE_YN								= 'Y'

			where b.BRAND_CD = '".$brand_cd."'

		";
        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->row_array();
    }

    /**
     * 검색결과 가격 가져오기
     */
    public function get_goods_price_by_search($goods_cd)
    {
//		$query = "
//			select	/*  > etah_front > goods_m > get_goods_price_by_search > ETAH 검색결과 가격 가져오기 */
//				t.GOODS_CD
//				, t.GOODS_NM
//				, t.SELLING_PRICE
//				, sum(if(cpn.MAX_DISCOUNT > 0,
//					if(round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
//					 round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
//					 round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
//				 )													as RATE_PRICE
//				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
//				, max(cpn.COUPON_CD)								as COUPON_CD
//				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
//			from
//				 (
//					 select
//						g.GOODS_CD
//						, g.GOODS_NM
//						, g.GOODS_MILEAGE_N_GOODS_NO
//						, pri.SELLING_PRICE
//					from
//						DAT_GOODS g
//						inner join	DAT_GOODS_PROGRESS 		p
//							on	g.GOODS_CD 					= p.GOODS_CD
//							and	g.GOODS_PROGRESS_NO			= p.GOODS_PROGRESS_NO
//						--	and p.GOODS_STS_CD				= '03'
//						inner join	DAT_GOODS_PRICE			pri
//							on	g.GOODS_CD					= pri.GOODS_CD
//							and	g.GOODS_PRICE_CD			= pri.GOODS_PRICE_CD
//
//					 where g.GOODS_CD in (".$goods_cd.")
//
//				 )	t
//
//				left join	DAT_GOODS_SORT_SCORE 	sort
//					on 	t.GOODS_CD					= sort.GOODS_CD
//				left join	MAP_GOODS_MILEAGE_N_GOODS			mileage
//					on	mileage.GOODS_MILEAGE_N_GOODS_NO		= t.GOODS_MILEAGE_N_GOODS_NO
//					and mileage.USE_YN							= 'Y'
//				left join	(	select	convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
//										, cpn.COUPON_CD
//										, cpn.COUPON_DC_METHOD_CD
//										, cpn.COUPON_FLAT_RATE
//										, cpn.COUPON_FLAT_AMT
//										, cpn.MIN_AMT
//										, cpn.MAX_DISCOUNT
//								from
//									MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
//								inner join DAT_COUPON	cpn
//									on	mcp.COUPON_CD					 = cpn.COUPON_CD
//									and cpn.COUPON_KIND_CD				 in ('GOODS','SELLER')
//									and cpn.USE_YN						 = 'Y'
//									and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
//									and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())
//
//								inner join DAT_COUPON_PROGRESS cpp
//									on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
//									and cpp.COUPON_PROGRESS_STS_CD		= '03'
//									and	cpp.USE_YN						= 'Y'
//							) cpn
//					on	t.GOODS_CD = cpn.COUPON_APPLICATION_SCOPE_OBJECT_CD
//
//			 group by	t.GOODS_CD
//
//			 order by sort.GOODS_SORT_SCORE desc
//
//		";

        $query = "
			select	/*  > etah_front > goods2_m > get_goods_price_by_search > ETAH 검색결과 가격 가져오기 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.SELLING_PRICE
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
				, round( if(round(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, round(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))/10)*10		as RATE_PRICE_S
				, round( if(round(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, round(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))/10)*10		as RATE_PRICE_G
				, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
				, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
				, cpn_s.COUPON_CD									as COUPON_CD_S
				, cpn_g.COUPON_CD									as COUPON_CD_G
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
				, t.BRAND_NM                                        as BRAND_NM
				, eg.PLAN_EVENT_REFER_CD	                        as DEAL
				, if(left(t.CATEGORY_MNG_CD, 4)=2401, 'C', (if(left(t.CATEGORY_MNG_CD, 4)=2402, 'G', '')))  as GONGBANG
			from
				 (
					 select
						g.GOODS_CD
						, g.GOODS_NM
						, g.GOODS_MILEAGE_N_GOODS_NO
						, g.DELIV_POLICY_NO
						, pri.SELLING_PRICE
						, b.BRAND_NM
						, g.CATEGORY_MNG_CD
					from
						DAT_GOODS g
						inner join	DAT_GOODS_PROGRESS 		p
							on	g.GOODS_CD 					= p.GOODS_CD
							and	g.GOODS_PROGRESS_NO			= p.GOODS_PROGRESS_NO
						--	and p.GOODS_STS_CD				= '03'
						inner join	DAT_GOODS_PRICE			pri
							on	g.GOODS_CD					= pri.GOODS_CD
							and	g.GOODS_PRICE_CD			= pri.GOODS_PRICE_CD
                        inner join DAT_BRAND b
							on g.BRAND_CD			=		b.BRAND_CD
					 where g.GOODS_CD in (".$goods_cd.")

				 )	t

				left join	DAT_GOODS_SORT_SCORE 	sort
					on 	t.GOODS_CD					= sort.GOODS_CD
				inner join	DAT_DELIV_POLICY				dp
					on	dp.DELIV_POLICY_NO					= t.DELIV_POLICY_NO
					and dp.USE_YN							= 'Y'
				left join	DAT_DELIV_POLICY_PATTERN		dpp
					on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO
				left join	MAP_GOODS_MILEAGE_N_GOODS			mileage
					on	mileage.GOODS_MILEAGE_N_GOODS_NO		= t.GOODS_MILEAGE_N_GOODS_NO
					and mileage.USE_YN							= 'Y'
				
				left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
				on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD

			   left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD
				
				left join DAT_PLAN_EVENT_GOODS	    eg
                on t.GOODS_CD					    = eg.GOODS_CD
                and eg.PLAN_EVENT_CODE		        in ( 586, 587 ) 
/*					
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
*/
							
			 group by	t.GOODS_CD

			 order by sort.GOODS_SORT_SCORE desc

		";
        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }
    /**
     * 검색결과 브랜드 가져오기
     */
    public function get_brand_by_search($goods_cd)
    {
        $query = "
			select	/*  > etah_front > goods2_m > get_brand_by_search > ETAH 검색결과 브랜드 가져오기 */
				  b.BRAND_CD              as BRAND_CD
				 ,b.BRAND_NM              as BRAND_NM
				, COUNT(b.BRAND_CD)       as BRAND_CNT
				
			from
				  DAT_GOODS g
				  inner join DAT_BRAND b
				  on g.BRAND_CD			=		b.BRAND_CD
				  where g.GOODS_CD in (".$goods_cd.")

			 group by	b.BRAND_CD
			 order by b.BRAND_NM asc
		";
        $db = self::_slave_db();
        //var_dump($query);
        return $db->query($query)->result_array();
    }

    public function get_brand_cd($brand_nm){

        $query = "
			select    /*  > etah_front > goods2_m > get_brand_cd > 브랜드 코드 가져오기 */
			    b.BRAND_CD as brand_cd     
			from DAT_BRAND b
            where b.BRAND_NM = ?
			";

        $db = self::_slave_db();
        //var_dump($query);
        //log_message('debug', '============================ get_best_item : '.$query);
        return $db->query($query, $brand_nm)->row_array();
    }

    public function get_category_cd($cate_nm){

        $query ="
            select    /*  > etah_front > goods2_m > get_category_cd > 카테고리 코드 가져오기 */
                  * 
            from DAT_CATEGORY_DISP disp
            where disp.CATEGORY_DISP_NM = ?
            order by disp.REG_DT asc
            limit 1
        ";

        $db = self::_slave_db();
        //var_dump($query);
        //log_message('debug', '============================ get_best_item : '.$query);
        return $db->query($query, $cate_nm)->row_array();
    }

    /**
     * 검색어 히스토리 저장
     */
    public function reg_search_history($keyword)
    {
        $cur_time = date("Y-m-d H:i:s", time());

        $query = "
            insert into DAT_SEARCH_HST   	/*  > etah_front > goods2_m > reg_search_history > ETAH 검색어 히스토리 저장 */
			(
			    IP
				, KEYWORD
				, SEARCH_DT
				, DEVICE_TYPE
			)
			 values
			(
			    '".$_SERVER['HTTP_X_FORWARDED_FOR']."'
				, '".$keyword."'
				, '".$cur_time."'
				, 'W'
			)
        ";
        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 검색결과 브랜드 가져오기
     * 2020.01.06
     */
    public function get_search_brand($param)
    {
        // 검색어 모든 공백 제거
        $param['keyword'] = preg_replace("/\s+/", "", $param['keyword']);

        $query = "
            select    /*  > etah_front > goods2_m > get_search_brand > ETAH 검색결과 브랜드 가져오기 */
                    b.BRAND_CD
                    , b.BRAND_NM 
            from 
                    DAT_BRAND b 
                    
            where   1=1 
            and REPLACE(b.BRAND_NM, ' ', '')  like '%".$param['keyword']."%'
            and b.USE_YN = 'Y'
            and b.BRAND_DISP_YN = 'Y'
            and b.WEB_DISP_YN = 'Y'
            
            order by
                    b.BRAND_CD desc
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 검색결과 연관태그 가져오기
     * 2020.01.06
     */
    public function get_search_tag($param, $keyword)
    {
        $keywordQuery = $keyword ? $keyword : '';


        $query = "
            select    /*  > etah_front > goods2_m > get_search_tag > ETAH 검색결과 연관태그 가져오기 */
                    t.TAG_NO
                    , t.TAG_NM 
            from 
                    DAT_TAG t 
                    
            inner join MAP_TAG_N_GOODS tg 
            on t.TAG_NO = tg.TAG_NO
            
            where   1=1
            and tg.GOODS_CD in (".$param['code'].")
            and t.AVAIL_FLAG = 'Y'
            and tg.AVAIL_FLAG = 'Y'
            
            group by t.TAG_NO
            
            order by field(t.TAG_NM, '".$keywordQuery."') desc,t.TAG_NO desc
        ";

        //해당 태그 우선 정렬

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 키워드로 태그 가져오기
     * 2020.04.23
     */
    public function get_search_tag_by_keyword($keyword)
    {
        $keywordQuery = $keyword ? " and t.TAG_NM like '%".$keyword."%' " : '';


        $query = "
            select    /*  > etah_front > goods2_m > get_search_tag > ETAH 검색결과 연관태그 가져오기 */
                    t.TAG_NO
                    , t.TAG_NM 
            from 
                    DAT_TAG t 
                    
            inner join MAP_TAG_N_GOODS tg 
            on t.TAG_NO = tg.TAG_NO
            
            where   1=1
            and t.AVAIL_FLAG = 'Y'
            and tg.AVAIL_FLAG = 'Y'
            $keywordQuery

            group by t.TAG_NO
            
            order by field(t.TAG_NM, '".$keyword."') desc,t.TAG_NO desc
        ";
        //해당 태그 우선 정렬

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 검색결과 기획전 가져오기
     * 2020.01.06
     */
    public function get_search_plan_event($param)
    {
        $start = $param['start'];
        $limit = $param['limit'];

        $query_code = "";       //상품코드
        $query_order = "";      //정렬순위
        $query_category = "";   //카테고리

        if($param['order_by']) {
            if($param['order_by']=='A')     $query_order = "order by e.HITS desc, e.PLAN_EVENT_CD desc";  //인기순
            if($param['order_by']=='B')     $query_order = "order by e.PLAN_EVENT_CD desc";  //최신순
        }

        if($param['category'] != '')    $query_category = "and e.BRAND_CATEGORY_CD = '".$param['category']."'";
        if($param['code'] != '')        $query_code = "or eg.GOODS_CD in (".$param['code'].")";

        // 검색어 모든 공백 제거
        $param['keyword'] = preg_replace("/\s+/", "", $param['keyword']);


        $query = "
            select    /*  > etah_front > goods2_m > get_search_plan_event > ETAH 검색결과 기획전 가져오기 */
                    e.PLAN_EVENT_CD
                    , e.BRAND_CATEGORY_CD
                    , e.TITLE
                    , e.IMG_URL
            from 
                    DAT_PLAN_EVENT e 
                    
            inner join DAT_PLAN_EVENT_GOODS eg 
            on e.PLAN_EVENT_CD = eg.PLAN_EVENT_CODE
            
            where 1=1
            and (REPLACE(e.TITLE, ' ', '')  like '%".$param['keyword']."%' ".$query_code.")
            and e.USE_YN = 'Y'
            and e.DISP_YN = 'Y'
            $query_category
            
            group by e.PLAN_EVENT_CD
            
            $query_order
            
            limit $start, $limit
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    public function get_search_plan_event_cnt($param)
    {
        $query_code = "";       //상품코드
        $query_category = "";   //카테고리

        if($param['category'] != '')    $query_category = "and e.BRAND_CATEGORY_CD = '".$param['category']."'";
        if($param['code'] != '')        $query_code = "or eg.GOODS_CD in (".$param['code'].")";

        // 검색어 모든 공백 제거
        $param['keyword'] = preg_replace("/\s+/", "", $param['keyword']);


        $query = "
            select    /*  > etah_front > goods2_m > get_search_plan_event_cnt > ETAH 검색결과 기획전 개수 가져오기 */
                    count(distinct e.PLAN_EVENT_CD)   as CNT
            from 
                    DAT_PLAN_EVENT e 
                    
            inner join DAT_PLAN_EVENT_GOODS eg 
            on e.PLAN_EVENT_CD = eg.PLAN_EVENT_CODE
            
            where 1=1
            and (REPLACE(e.TITLE, ' ', '')  like '%".$param['keyword']."%' ".$query_code.")
            and e.USE_YN = 'Y'
            and e.DISP_YN = 'Y'
            $query_category
          
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 기획전 카테고리 정보 가져오기
     */
    public function get_search_plan_event_category($temp)
    {
        $query_code = "";           //상품코드
        $query_cur_category = "";   //현재카테고리

        // 검색어 모든 공백 제거
        $temp['keyword'] = preg_replace("/\s+/", "", $temp['keyword']);

        //상품코드
        if($temp['code'] != '') {
            $query_code = "or eg.GOODS_CD in (".$temp['code'].")";
        }

        //현재카테고리
        if($temp['category'] != '') {
            $query_cur_category = "and c3.BRAND_CATEGORY_CD = ".$temp['category'];
        } else {
            $query_cur_category = "and c3.BRAND_CATEGORY_CD is null ";
        }

        $query = "
            select     /*  > etah_front > goods2_m > get_search_plan_event_category > ETAH 검색결과 기획전 카테고리 정보 가져오기 */
                    c.BRAND_CATEGORY_CD       as CATEGORY_CD2
                    , c.BRAND_CATEGORY_NM     as CATEGORY_NM2
                    , c2.BRAND_CATEGORY_CD	  as CATEGORY_CD1
                    , c2.BRAND_CATEGORY_NM	  as CATEGORY_NM1
                    , c3.BRAND_CATEGORY_CD    as CURRENT_CATE
            from 
                    DAT_BRAND_CATEGORY c 
                    
            inner join DAT_BRAND_CATEGORY c2
            on c.PARENT_CD = c2.BRAND_CATEGORY_CD 
                    
            inner join DAT_PLAN_EVENT e 
            on c.BRAND_CATEGORY_CD = e.BRAND_CATEGORY_CD
            and e.USE_YN = 'Y'
            and e.DISP_YN = 'Y'
            
            inner join DAT_PLAN_EVENT_GOODS eg
            on e.PLAN_EVENT_CD = eg.PLAN_EVENT_CODE
            
            left join DAT_BRAND_CATEGORY c3 
            on c.BRAND_CATEGORY_CD = c3.BRAND_CATEGORY_CD
            $query_cur_category
            
            where 1=1 
            and (REPLACE(e.TITLE, ' ', '')  like '%".$temp['keyword']."%' ".$query_code.")
            and c.USE_YN = 'Y' 
            and c.WEB_DISP_YN = 'Y'
            
            group by c.BRAND_CATEGORY_CD
            
            order by c.BRAND_CATEGORY_CD
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 검색결과 매거진 가져오기
     * 2020.01.06
     */
    public function get_search_magazine($param)
    {
        $start = $param['start'];
        $limit = $param['limit'];

        $query_code = "";       //상품코드
        $query_order = "";      //정렬순위
        $query_category = "";   //카테고리

        if($param['order_by']) {
            if($param['order_by']=='A')     $query_order = "order by m.HITS desc, count(distinct ml.MAGAZINE_LOVE_NO) desc, m.MAGAZINE_NO desc";  //인기순
            if($param['order_by']=='B')     $query_order = "order by m.MAGAZINE_NO desc";  //최신순
        }

        if($param['category'] != '')    $query_category = "and cm.CATEGORY_CD = '".$param['category']."'";
        if($param['code'] != '')        $query_code = "or mg.GOODS_CD in (".$param['code'].")";

        // 검색어 모든 공백 제거
        $param['keyword'] = preg_replace("/\s+/", "", $param['keyword']);


        $query = "
            select    /*  > etah_front > goods2_m > get_search_magazine > ETAH 검색결과 매거진 가져오기 */
                    m.MAGAZINE_NO
                    , m.TITLE
                    , cm.CATEGORY_CD
                    , cm.CATEGORY_NM
                    , m.IMG_URL
                    , m.HITS
                    , m.`SHARE`
                    , count(distinct ml.MAGAZINE_LOVE_NO) as LOVE
                    , m.REG_DT
                    , m.START_DT
                    , m.END_DT
            from 
                    DAT_MAGAZINE m 
            
            inner join DAT_CATEGORY_MAGAZINE cm
            on m.CATEGORY_CD = cm.CATEGORY_CD
            
            left join MAP_MAGAZINE_GOODS mg 
            on m.MAGAZINE_NO = mg.MAGAZINE_NO
            
            left join MAP_MAGAZINE_LOVE ml 
            on m.MAGAZINE_NO = ml.MAGAZINE_NO
            
            where   1=1
            and (REPLACE(m.TITLE, ' ', '')  like '%".$param['keyword']."%' ".$query_code.")
            and m.USE_YN = 'Y'
            $query_category
            
            group by m.MAGAZINE_NO 
            
            $query_order
            
            limit $start, $limit
        ";
//        var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    public function get_search_magazine_cnt($param)
    {
        $query_code = "";       //상품코드
        $query_category = "";   //카테고리

        if($param['category'] != '')    $query_category = "and m.CATEGORY_CD = '".$param['category']."'";
        if($param['code'] != '')        $query_code = "or mg.GOODS_CD in (".$param['code'].")";

        // 검색어 모든 공백 제거
        $param['keyword'] = preg_replace("/\s+/", "", $param['keyword']);


        $query = "
            select    /*  > etah_front > goods2_m > get_search_magazine_cnt > ETAH 검색결과 매거진 개수 가져오기 */
                    count(distinct m.MAGAZINE_NO )  as CNT
            from 
                    DAT_MAGAZINE m 
          
            left join MAP_MAGAZINE_GOODS mg 
            on m.MAGAZINE_NO = mg.MAGAZINE_NO
          
            where   1=1
            and (REPLACE(m.TITLE, ' ', '')  like '%".$param['keyword']."%' ".$query_code.")
            and m.USE_YN = 'Y'
            $query_category
          
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 매거진 카테고리 정보 가져오기
     */
    public function get_search_magazine_category($temp)
    {
        $query_code = "";       //상품코드
        $query_cur_category = "";   //현재카테고리

        // 검색어 모든 공백 제거
        $temp['keyword'] = preg_replace("/\s+/", "", $temp['keyword']);

        //상품코드
        if($temp['code'] != '') {
            $query_code = "or mg.GOODS_CD in (".$temp['code'].")";
        }

        //현재카테고리
        if($temp['category'] != '') {
            $query_cur_category = "and cm3.CATEGORY_CD = ".$temp['category'];
        } else {
            $query_cur_category = "and cm3.CATEGORY_CD is null ";
        }


        $query = "
            select     /*  > etah_front > goods2_m > get_search_magazine_category > ETAH 검색결과 매거진 카테고리 정보 가져오기 */
                    cm2.CATEGORY_CD       as CATEGORY_CD1
                    , cm2.CATEGORY_NM     as CATEGORY_NM1
                    , cm.CATEGORY_CD      as CATEGORY_CD2
                    , cm.CATEGORY_NM      as CATEGORY_NM2
                    , cm3.CATEGORY_CD     as CURRENT_CATE
            from 
                    DAT_CATEGORY_MAGAZINE cm
                    
            inner join DAT_CATEGORY_MAGAZINE cm2
            on cm.PARENT_CATEGORY_CD = cm2.CATEGORY_CD
            
            inner join DAT_MAGAZINE m
            on cm.CATEGORY_CD =  m.CATEGORY_CD
            and m.USE_YN = 'Y'
            
            left join MAP_MAGAZINE_GOODS mg
            on m.MAGAZINE_NO = mg.MAGAZINE_NO
            
            left join DAT_CATEGORY_MAGAZINE cm3
            on cm.CATEGORY_CD = cm3.CATEGORY_CD
            $query_cur_category
            
            where 1=1 
            and (REPLACE(m.TITLE, ' ', '')  like '%".$temp['keyword']."%' ".$query_code.")
            
            group by cm.CATEGORY_CD
            
            order by cm.CATEGORY_CD
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 검색결과 - 국가정보
     */
    public function get_countryInfo($code)
    {
        $query = "
        SELECT 
                c.COUNTRY_NO
                , c.COUNTRY_CD
                , c.COUNTRY_KO_NM 
        FROM 
                DAT_COUNTRY c 
        WHERE 
                c.COUNTRY_CD = '".$code."'
        ";

        $db = self::_slave_db();
        $result = $db->query($query)->row_array();

        return $result['COUNTRY_KO_NM'];
    }

}