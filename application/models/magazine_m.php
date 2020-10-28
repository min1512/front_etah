<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Magazine_m extends CI_Model {

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
     * 매거진 카테고리 리스트
     */
    public function get_list_by_magazineCategory($parent_cd) {
        if( !empty($parent_cd) ) {
            $query = "
				select    /*  > etah_front > magazine_m > get_list_by_magazineCategory > 매거진 카테고리 리스트 */
							c.CATEGORY_CD		as	CATEGORY_CD
							, c.CATEGORY_NM 	as	CATEGORY_NM
				from 
							DAT_CATEGORY_MAGAZINE c
				where 
							c.PARENT_CATEGORY_CD = '".$parent_cd."'
							and c.USE_YN ='Y'
				order by
				            c.SORT_VAL
			";
        } else {
            $query = "
				select    /*  > etah_front > magazine_m > get_list_by_magazineCategory > 매거진 카테고리 리스트 */
							c.CATEGORY_CD		as	CATEGORY_CD
							, c.CATEGORY_NM 	as	CATEGORY_NM
				from 
							DAT_CATEGORY_MAGAZINE c
				where 
							c.PARENT_CATEGORY_CD is null
							and c.USE_YN ='Y'
                order by
				            c.SORT_VAL
			";
        }

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 매거진 카테고리 정보
     */
    public function get_category_info($cateCode) {
        $query = "
                select    /*  > etah_front > magazine_m > get_category_info > 매거진 카테고리 정보 */
                        c.CATEGORY_CD
                        ,c.CATEGORY_NM
                from 
                        DAT_CATEGORY_MAGAZINE	c
                where 
                        c.CATEGORY_CD = '".$cateCode."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 매거진 리스트
     */
    public function get_magazine_list($gubun, $param, $cate_cd, $order_by) {
        if( !empty($param) ){
            $limit_num_rows         = $param['limit_num_rows'];
            $startPos               = ($param['page'] - 1) * $limit_num_rows;
        }

        $order_where = "";
        if($order_by == 'A')	{$query_order = "order by m.MAGAZINE_NO desc";}  //최신순
        if($order_by == 'B')	{$query_order = "order by m.HITS desc, LOVE desc, m.MAGAZINE_NO desc";}  //인기순
        if($order_by == 'C')	{$order_where = "and m.END_DT>now()";    $query_order = "order by m.START_DT desc, m.MAGAZINE_NO desc";}    //진행중
        if($order_by == 'D')	{$order_where = "and m.END_DT<now()";    $query_order = "order by m.START_DT desc, m.MAGAZINE_NO desc";}    //종료

        //대카테고리
        if($gubun == 'T'){
            $query_where = "and c.PARENT_CATEGORY_CD= $cate_cd";
            $query_order = "order by m.REG_DT desc";
            $query_limit = "limit 4";
        }
        //중카테고리
        if($gubun == 'M'){
            $query_where = $order_where." and c.PARENT_CATEGORY_CD=$cate_cd";
            $query_limit = "limit $startPos, $limit_num_rows ";
        }
        //소카테고리
        if($gubun == 'S'){
            $query_where = $order_where."and m.CATEGORY_CD=$cate_cd";
            $query_limit = "limit $startPos, $limit_num_rows ";
        }

        $query = "
                        select      /*  > etah_front > magazine_m > get_magazine_list > 매거진 리스트 */
                                m.MAGAZINE_NO
                                , c.CATEGORY_NM	
                                , m.TITLE
                                , m.IMG_URL
                                , m.HITS
                                , m.`SHARE`
                                , count(l.MAGAZINE_LOVE_NO) as LOVE
                                , m.REG_DT
                                , m.START_DT
                                , m.END_DT
                         from 
                                DAT_MAGAZINE m 
                                 left join DAT_CATEGORY_MAGAZINE c 
                                        on m.CATEGORY_CD	=	c.CATEGORY_CD 
                                 left join MAP_MAGAZINE_LOVE l
                                        on l.MAGAZINE_NO = m.MAGAZINE_NO 
                         where 
                                1=1
                                and m.USE_YN='Y' 
                                $query_where
                         group by m.MAGAZINE_NO
                         $query_order
                         $query_limit
                    ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     *매거진 리스트 개수
     */
    public function get_magazine_list_count($gubun, $catecd) {
        if($gubun == 'M') {
            $query = "
				select     /*  > etah_front > magazine_m > get_magazine_list > 매거진 리스트 개수 */
						count(*) as cnt 
				from 
						DAT_MAGAZINE m 
						left join DAT_CATEGORY_MAGAZINE c 
							on m.CATEGORY_CD = c.CATEGORY_CD 
				where 
						m.USE_YN='Y' 
						and m.CATEGORY_CD is not null 
						and c.PARENT_CATEGORY_CD='".$catecd."'
			";
        }
        if($gubun == 'S') {
            $query = "
    			select     /*  > etah_front > magazine_m > get_magazine_list > 매거진 리스트 개수 */
    					count(*) as cnt
				from 
						DAT_MAGAZINE m 
				where 
						m.USE_YN='Y' 
						and m.CATEGORY_CD = '".$catecd."'
    		";
        }

        $db = self::_slave_db();
        $data = $db->query($query)->row_array();
        return $data['cnt'];
    }

    /**
     * 매거진 컨텐츠
     */
    public function get_magazine_contents($magazine_no)
    {
        $query = "
                 select   /*  > etah_front > magazine_m > get_magazine_contents > 매거진 컨텐츠 */
                   --     m.MAGAZINE_NO
                   --     , m.TITLE
                   --     , m.ADDRESS
                   --     , b.MAP_URL       as ADDRESS
                        mc.MAGAZINE_CONTENTS_GB_CD
                        , mc.HEADER_DESC
                        , mc.REG_DT
                   --     , m.END_DT
                        , mc.DISP_SORT
                from 
                        DAT_MAGAZINE m
                        left join DAT_MAGAZINE_CONTENTS mc
                              on m.MAGAZINE_NO = mc.MAGAZINE_NO
                 --       left join DAT_BRAND b
                 --       	  on m.BRAND_CD = b.BRAND_CD
                where
                        mc.MAGAZINE_NO = '".$magazine_no."'
                order by
                     mc.DISP_SORT
		";

        // 매거진 조회수 증가
        $query2 = "
        	update    /*  > etah_front > magazine_m > get_magazine_contents > 매거진 조회수 증가 */
        			DAT_MAGAZINE m 
			set 
					m.HITS = m.HITS+1 
			where m.MAGAZINE_NO = '".$magazine_no."'
        ";

        $db = self::_master_db();
        $db->query($query2);

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 매거진 정보
     */
    public function get_detail($magazine_no) {
        $query = "
                     select     /*  > etah_front > magazine_m > get_detail > 매거진 정보 */
                                m.MAGAZINE_NO
                                , m.TITLE
                                , m.IMG_URL
                                , cm.CATEGORY_CD      as CATEGORY_CD2
                                , cm.CATEGORY_NM      as CATEGORY_NM2
                                , cm2.CATEGORY_CD     as CATEGORY_CD1
                                , cm2.CATEGORY_NM     as CATEGORY_NM1
                                , if(left(cm.PARENT_CATEGORY_CD,1)='8', m.ADDRESS, if(left(cm.PARENT_CATEGORY_CD,1)='7', b.MAP_URL, ''))	as ADDRESS
                                , m.BRAND_CD
                                , m.END_DT
                                , m.REG_DT
                                , m.HITS
                                , m.`SHARE`
                                , count(distinct ml.MAGAZINE_LOVE_NO)         as LOVE_CNT
                                , count(distinct cmc.CUST_MAGAZINE_COMMENT)   as COMMENT_CNT
                     from
                                DAT_MAGAZINE m
                                left join	MAP_MAGAZINE_LOVE           ml
                                        on m.MAGAZINE_NO                = ml.MAGAZINE_NO
                                left join	DAT_CUST_MAGAZINE_COMMENT   cmc
                                        on m.MAGAZINE_NO                = cmc.MAGAZINE_NO
                                        and cmc.USE_YN                  = 'Y'
                                left join DAT_CATEGORY_MAGAZINE        cm
                                        on m.CATEGORY_CD                = cm.CATEGORY_CD
                                left join DAT_CATEGORY_MAGAZINE        cm2
                                        on cm.PARENT_CATEGORY_CD        = cm2.CATEGORY_CD
                                left join DAT_BRAND                    b
                                        on m.BRAND_CD                   = b.BRAND_CD
                     where
                                m.MAGAZINE_NO = '".$magazine_no."'
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 매거진 상품조회
     */
    public function get_goods($gubun, $param) {
        $query_from = "";
        $query_where = "";
        $query_limit = "";
        $query_column = "";
        $query_column2 = "";

        //매거진에 나온 상품
        if($gubun == 'M') {
            $query_from = "right join MAP_MAGAZINE_GOODS mg on mg.GOODS_CD = g.GOODS_CD";
            $query_where = "and mg.MAGAZINE_NO = '".$param['magazine_no']."'";
        }
        //관련 상품
        else if($gubun == 'R') {
            $query_limit = "limit 3";
            if($param['category'] && $param['goods']) {
                $query_where = "and g.CATEGORY_MNG_CD in (".$param['category'].") and g.GOODS_CD not in (".$param['goods'].")";
            }
        }
        //공방 상품
        else if($gubun == 'G') {
            $query_limit = "limit 3";
            $query_column = ", t.CLASS_GUBUN";
            $query_column2 = ", if(left(cm.CATEGORY_MNG_CD, 4)='2401', 'C', if(left(cm.CATEGORY_MNG_CD, 4)='2402', 'G', '')) as CLASS_GUBUN";
            $query_from = "left join DAT_CATEGORY_MNG cm on g.CATEGORY_MNG_CD = cm.CATEGORY_MNG_CD";
            $query_where = "and b.BRAND_CD = '".$param['brand_cd']."' and cm.PARENT_CATEGORY_MNG_CD in (24010000, 24020000)";
        }

        $query = "
                select 	      /*  > etah_front > magazine_m > get_goods > 매거진 상품조회 */
                        t.GOODS_CD
                        , t.GOODS_NM
                        , t.BRAND_NM
                    --    , if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
                        , ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, i.IMG_URL))		as IMG_URL
                        , pri.SELLING_PRICE
                        , dp.DELIV_POLICY_NO
                        , dp.PATTERN_TYPE_CD
                        , max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
                        , max(dpp.DELIV_COST)								as DELI_COST
                        , if(round(pri.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, round(pri.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_S
                        , if(round(pri.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, round(pri.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_G
                        , ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
                        , ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
                        , cpn_s.COUPON_CD									as COUPON_CD_S
                        , cpn_g.COUPON_CD									as COUPON_CD_G
                        , ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
                        , t.CATEGORY_MNG_CD							        as CATEGORY_CD
                        , eg.PLAN_EVENT_REFER_CD		                    as DEAL
                        $query_column
            
                from (     select
                                g.GOODS_CD
                                , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
                             -- , g.GOODS_NM
                                , g.GOODS_PRICE_CD
                                , g.GOODS_MILEAGE_N_GOODS_NO
                                , g.DELIV_POLICY_NO
                                , b.BRAND_NM
                                , sort.GOODS_SORT_SCORE
                                , g.CATEGORY_MNG_CD
                                $query_column2
                            from
                                DAT_GOODS g
                            $query_from
                            left join DAT_GOODS_MD_MOD             gmm
                                on g.GOODS_CD 				        = gmm.GOODS_CD
                                and gmm.USE_YN 					    = 'Y'
                            inner join	DAT_BRAND					b
                                on	g.BRAND_CD						= b.BRAND_CD
                            inner join	DAT_GOODS_PROGRESS 			gp
                                on	g.GOODS_CD						= gp.GOODS_CD
                                and g.GOODS_PROGRESS_NO				= gp.GOODS_PROGRESS_NO
                                and	gp.GOODS_STS_CD					= '03'
                            left join	DAT_GOODS_SORT_SCORE		sort
                                on	g.GOODS_CD 						= sort.GOODS_CD
                            where
                                g.USE_YN = 'Y'
                            and	g.WEB_DISP_YN = 'Y'
                            $query_where
                            order by
                                sort.GOODS_SORT_SCORE desc, g.GOODS_CD desc
                            $query_limit
                        ) t
                        inner join	DAT_GOODS_IMAGE					i
                            on	t.GOODS_CD							= i.GOODS_CD
                            and	i.TYPE_CD							= 'TITLE'
                        left join	 DAT_GOODS_IMAGE_RESIZING 		gir
                            on 	t.GOODS_CD							= gir.GOODS_CD
                            and	gir.TYPE_CD							= '300'
                        left join	DAT_GOODS_IMAGE_MD		        im
                            on	t.GOODS_CD							= im.GOODS_CD
                            and	im.TYPE_CD							= 'TITLE'
                        left join	 DAT_GOODS_IMAGE_RESIZING_MD 	girm
                            on 	t.GOODS_CD							= girm.GOODS_CD
                            and	girm.TYPE_CD						= '300'
                        inner join	DAT_GOODS_PRICE					pri
                            on	t.GOODS_CD 							= pri.GOODS_CD
                            and t.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
                        inner join	DAT_DELIV_POLICY				dp
                            on	dp.DELIV_POLICY_NO					= t.DELIV_POLICY_NO
                            and dp.USE_YN							= 'Y'
                        left join	DAT_DELIV_POLICY_PATTERN		dpp
                            on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO
                        left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
                            on	mileage.GOODS_MILEAGE_N_GOODS_NO	= t.GOODS_MILEAGE_N_GOODS_NO
                            and mileage.USE_YN						= 'Y'
                        left join DAT_PLAN_EVENT_GOODS             eg
                            on t.GOODS_CD                           = eg.GOODS_CD
                            and eg.PLAN_EVENT_CODE                  in (586,587)  
                        left join	BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
                            on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD
                        left join	BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
                            on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD
            
                        group by t.GOODS_CD
            
                        order by
                            t.GOODS_SORT_SCORE desc, t.GOODS_CD desc
                ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 매거진 상품 수 조회
     */
    public function get_magazine_plus_count($param) {
        $query = "
               select      /*  > etah_front > magazine_m > get_magazine_plus_count > 매거진 상품 수 조회 */
                        count(*) 	as cnt
               from
                        MAP_MAGAZINE_GOODS	mg
                        inner join DAT_GOODS g
                        on g.GOODS_CD = mg.GOODS_CD
                        inner join DAT_GOODS_PROGRESS	gp
                        on g.GOODS_PROGRESS_NO = gp.GOODS_PROGRESS_NO
                        and gp.GOODS_STS_CD = '03'
               where
                        mg.MAGAZINE_NO =  ".$param['magazineCode']."
        ";

        $db = self::_slave_db();
        $row = $db->query($query)->row_array();
        return $row['cnt'];
    }

    /**
     * 다른 매거진 더보기
     */
    public function get_other_magazine($catecd, $magazine_no) {
        $query = "
			select 	     /*  > etah_front > magazine_m > get_other_magazine > 다른 매거진 더보기 */
                        m.MAGAZINE_NO
                        , m.TITLE
                        , m.IMG_URL
                        , c.CATEGORY_NM
			from
                        DAT_MAGAZINE m
                        left JOIN DAT_CATEGORY_MAGAZINE c
                                on m.CATEGORY_CD = c.CATEGORY_CD
			where 
                        m.USE_YN = 'Y' 
                        and m.CATEGORY_CD='".$catecd."'
                        and m.MAGAZINE_NO != '".$magazine_no."'
			order by
                        m.HITS desc
                        , m.REG_DT desc
            limit 3
    	";


        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 매거진 댓글 리스트
     */
    public function get_magazine_comment_list($magazine_no, $page, $limit) {
        if($page == 0){
            $query_limit = "";
        } else {
            $startPos = $limit * ($page - 1);
            $query_limit = "limit $startPos, $limit	";
        }

        $query = "
			select 	     /*  > etah_front > magazine_m > get_magazine_comment_list > 매거진 댓글 리스트 */
			            com.CUST_MAGAZINE_COMMENT           as COMMENT_NO
						, com.`CONTENTS`
						, com.FILE_PATH
						, left(com.CUST_MAGAZINE_COMMENT_REG_DT, 10)	as REG_DT
						, com.CUST_NO
						, c.CUST_ID
						, c.CUST_NM
			from 		
			            DAT_CUST_MAGAZINE_COMMENT com 
						inner join 	DAT_CUST c 
								on com.CUST_NO = c.CUST_NO 
			where 
						com.USE_YN='Y'
						and com.MAGAZINE_NO = '".$magazine_no."'
			order by 
						com.CUST_MAGAZINE_COMMENT desc
			$query_limit
    	";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 매거진 댓글 조회
     */
    public function get_magazine_comment($comment_no) {
        $query = "
            select     /*  > etah_front > magazine_m > get_magazine_comment > 매거진 댓글 조회 */
                    c.CUST_MAGAZINE_COMMENT   as COMMENT_NO
                    , c.MAGAZINE_NO           as MAGAZINE_NO
                    , c.CUST_NO               as CUST_NO
                    , c.`CONTENTS`            as CONTENTS
                    , c.FILE_PATH             as FILE_PATH
            from 
                    DAT_CUST_MAGAZINE_COMMENT c 
            where 
                    c.CUST_MAGAZINE_COMMENT = '".$comment_no."'
                    and c.USE_YN = 'Y'
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 매거진 댓글 등록
     */
    public function regist_comment($param) {
        $query = "
                insert into DAT_CUST_MAGAZINE_COMMENT	(    /*  > etah_front > magazine_m > regist_comment > 매거진 댓글 등록 */
						  MAGAZINE_NO
						, CUST_NO
						, `CONTENTS`
						";
        if(!empty($param['file_url'])) {
            $query .= ", FILE_PATH";
        }
        $query .= "
        , CUST_MAGAZINE_COMMENT_REG_DT
					)
					values
					(
						  '".$param['magazine_no']."'
						, '".$param['mem_no']."'
						, '".$param['comment_contents']."'
        ";
        if(!empty($param['file_url'])) {
            $query .= ", '".$param['file_url']."'";
        }
        $query .= "     , now()
					)
        ";
        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 매거진 댓글 수정
     */
    public function update_comment($param) {
        $query = "
            update     /*  > etah_front > magazine_m > update_comment > 매거진 댓글 수정 */
                DAT_CUST_MAGAZINE_COMMENT
            set 
                `CONTENTS` = '".$param['comment_txt']."'
                , FILE_PATH = '".$param['file_url']."'
                , UPD_USER_CD = '".$param['mem_no']."'
            where 
                CUST_MAGAZINE_COMMENT = '".$param['comment_no']."'
        ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 매거진 댓글 삭제
     */
    public function delete_comment($param) {
        $query = "
            update     /*  > etah_front > magazine_m > delete_comment > 매거진 댓글 삭제 */
                    DAT_CUST_MAGAZINE_COMMENT mc
            set
                    mc.USE_YN = 'N'
            where 
                    mc.CUST_MAGAZINE_COMMENT = ".$param['comment_no']."
        ";
        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 매거진 공유하기
     */
    public function magazine_share($magazine_no) {
        $query = "
                update    /*  > etah_front > magazine_m > magazine_share > 매거진 공유하기 */
                    DAT_MAGAZINE m
                set
                    m.SHARE = m.SHARE+1
                where
                    m.MAGAZINE_NO = '".$magazine_no."'
        ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 매거진 좋아요
     */
    public function magazine_love($magazine_no, $cust_no, $status) {
        //좋아요
        if($status == 'Y') {
            $query = "
			insert into     /*  > etah_front > magazine_m > magazine_love > 매거진 좋아요 */
			        MAP_MAGAZINE_LOVE (MAGAZINE_NO, CUST_NO) 
            values
                    ('".$magazine_no."', '".$cust_no."' )
		";
        }
        //좋아요 취소
        else {
            $query = "
			delete from     /*  > etah_front > magazine_m > magazine_love > 매거진 좋아요 취소 */
                    MAP_MAGAZINE_LOVE
			where 
                    CUST_NO = '".$cust_no."' 
                    and MAGAZINE_NO = '".$magazine_no."' 
			";
        }

        $db = self::_master_db();
        return $db->query($query);
    }


    /**
     * 좋아요 리스트 확인
     */
    public function magazine_love_chk($magazine_no, $cust_no)
    {
        $query = "
            select 	    /*  > etah_front > magazine_m > magazine_love_chk > 매거진 좋아요 리스트 확인 */
                        count(*)	as cnt
            from 
                        MAP_MAGAZINE_LOVE L 
            where 
                        L.MAGAZINE_NO = '" . $magazine_no . "'
                        AND L.CUST_NO= '" . $cust_no . "'
            ";

        $db = self::_slave_db();
        $row = $db->query($query)->row_array();

        return $row['cnt'];
    }

}

?>
