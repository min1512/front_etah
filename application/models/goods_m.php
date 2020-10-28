<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods_m extends CI_Model {

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
     * 상품 상세 옵션 배열을 만들기 위한 리스트
     */
    public function get_template_option_list($goods_code, $max_moption)
    {
        $query = "
			(
				select distinct         /*  > etah_front > goods_m > get_template_option_list > 상품 상세 옵션 배열을 만들기 위한 리스트 */
					  concat(t.RN1, '' )												as SEQ
					, t.GB1																as OPT_NAME
					, if( 1 = ".$max_moption.", t.GOODS_OPTION_CD, 0 )					as GOODS_OPTION_CD
					, if( 1 = ".$max_moption.", t.QTY, 99 )								as GOODS_OPTION_QTY
					, if( 1 = ".$max_moption.", op.GOODS_OPTION_ADD_PRICE, 0 )			as GOODS_OPTION_ADD_PRICE
				from
					(	select
							  o.GOODS_OPTION_CD
							, o.GOODS_OPTION_NM
							, o.QTY
							, o.GOODS_OPTION_PRICE_NO
							, case	when @aa1 = o.M_OPTION_1	then @rownum1 else @rownum1 := @rownum1 + 1	end		as RN1
							, @aa1 := o.M_OPTION_1				as GB1
						from
							DAT_GOODS_OPTION	o
							, (SELECT @aa1:=0, @rownum1:=0 FROM dual)   r1
							, (SELECT @aa2:=0, @rownum2:=0 FROM dual)   r2
						where
							o.GOODS_CD	= ".$goods_code."
						and	o.USE_YN	= 'Y'
						and o.QTY > 0
						order by
							o.M_OPTION_1
							, o.M_OPTION_2
					)	t
					inner join
						DAT_GOODS_OPTION_PRICE		op
					on	op.GOODS_OPTION_PRICE_NO	= t.GOODS_OPTION_PRICE_NO
			)
			union all
			(
				select distinct
					  concat(t.RN1, '|', t.RN2 )										as SEQ
					, t.GB2																as OPT_NAME
					, if( 2 = ".$max_moption.", t.GOODS_OPTION_CD, 0 )					as GOODS_OPTION_CD
					, if( 2 = ".$max_moption.", t.QTY, 99 )								as GOODS_OPTION_QTY
					, if( 2 = ".$max_moption.", op.GOODS_OPTION_ADD_PRICE, 0 )			as GOODS_OPTION_ADD_PRICE
				from
					(	select
							  o.GOODS_OPTION_CD
							, o.GOODS_OPTION_NM
							, o.QTY
							, o.GOODS_OPTION_PRICE_NO
							, case	when @aa21 = o.M_OPTION_1	then @rownum21 else @rownum21 := @rownum21 + 1	end		as RN1
							, case  when @aa21 != o.M_OPTION_1	then @rownum22 := 1
									when @aa22 = concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum22 else @rownum22 := @rownum22 + 1 end		as RN2
							, @aa21 := o.M_OPTION_1								as GB1
							, @aa22 := concat(o.M_OPTION_1,'/',o.M_OPTION_2)	as GB2
						from
							DAT_GOODS_OPTION	o
							, (SELECT @aa21:=0, @rownum21:=0 FROM dual)   r1
							, (SELECT @aa22:=0, @rownum22:=0 FROM dual)   r2
						where
							o.GOODS_CD	= ".$goods_code."
						and	o.USE_YN	= 'Y'
						and o.QTY > 0
						order by
							o.M_OPTION_1
							, o.M_OPTION_2
					)	t
					inner join
						DAT_GOODS_OPTION_PRICE		op
					on	op.GOODS_OPTION_PRICE_NO	= t.GOODS_OPTION_PRICE_NO
			)
			union all
			(
				select distinct
					  concat(t.RN1, '|', t.RN2, '|', t.RN3 )							as SEQ
					, t.GB3																as OPT_NAME
					, if( 3 = ".$max_moption.", t.GOODS_OPTION_CD, 0 )					as GOODS_OPTION_CD
					, if( 3 = ".$max_moption.", t.QTY, 99 )								as GOODS_OPTION_QTY
					, if( 3 = ".$max_moption.", op.GOODS_OPTION_ADD_PRICE, 0 )			as GOODS_OPTION_ADD_PRICE
				from
					(	select
							  o.GOODS_OPTION_CD
							, o.GOODS_OPTION_NM
							, o.QTY
							, o.GOODS_OPTION_PRICE_NO
							, case	when @aa31 = o.M_OPTION_1	then @rownum31 else @rownum31 := @rownum31 + 1	end		as RN1
							, case  when @aa31 != o.M_OPTION_1	then @rownum32 := 1
									when @aa32 = concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum32 else @rownum32 := @rownum32 + 1 end		as RN2
							, case  when @aa31 != o.M_OPTION_1 or @aa32 != concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum33 := 1
									when @aa33 = concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)	then @rownum33 else @rownum33 := @rownum33 + 1 end		as RN3
							, @aa31 := o.M_OPTION_1												as GB1
							, @aa32 := concat(o.M_OPTION_1,'/',o.M_OPTION_2)					as GB2
							, @aa33 := concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)	as GB3
						from
							DAT_GOODS_OPTION	o
							, (SELECT @aa31:=0, @rownum31:=0 FROM dual)   r1
							, (SELECT @aa32:=0, @rownum32:=0 FROM dual)   r2
							, (SELECT @aa33:=0, @rownum33:=0 FROM dual)   r3
						where
							o.GOODS_CD	= ".$goods_code."
						and	o.USE_YN	= 'Y'
						and o.QTY > 0
						order by
							o.M_OPTION_1
							, o.M_OPTION_2
							, o.M_OPTION_3
					)	t
					inner join
						DAT_GOODS_OPTION_PRICE		op
					on	op.GOODS_OPTION_PRICE_NO	= t.GOODS_OPTION_PRICE_NO
			)
			union all
			(
				select distinct
					  concat(t.RN1, '|', t.RN2, '|', t.RN3, '|', t.RN4 )				as SEQ
					, t.GB4																as OPT_NAME
					, if( 4 = ".$max_moption.", t.GOODS_OPTION_CD, 0 )					as GOODS_OPTION_CD
					, if( 4 = ".$max_moption.", t.QTY, 99 )								as GOODS_OPTION_QTY
					, if( 4 = ".$max_moption.", op.GOODS_OPTION_ADD_PRICE, 0 )			as GOODS_OPTION_ADD_PRICE
				from
					(	select
							  o.GOODS_OPTION_CD
							, o.GOODS_OPTION_NM
							, o.QTY
							, o.GOODS_OPTION_PRICE_NO
							, case	when @aa41 = o.M_OPTION_1	then @rownum41 else @rownum41 := @rownum41 + 1	end		as RN1
							, case  when @aa41 != o.M_OPTION_1	then @rownum42 := 1
									when @aa42 = concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum42 else @rownum42 := @rownum42 + 1 end		as RN2
							, case  when @aa41 != o.M_OPTION_1 or @aa42 != concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum43 := 1
									when @aa43 = concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)	then @rownum43 else @rownum43 := @rownum43 + 1 end		as RN3
							, case  when @aa41 != o.M_OPTION_1 or @aa42 != concat(o.M_OPTION_1,'/',o.M_OPTION_2) or @aa43 != concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)	then @rownum44 := 1
									when @aa44 = concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4)	then @rownum44 else @rownum44 := @rownum44 + 1 end		as RN4
							, @aa41 := o.M_OPTION_1																as GB1
							, @aa42 := concat(o.M_OPTION_1,'/',o.M_OPTION_2)									as GB2
							, @aa43 := concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)					as GB3
							, @aa44 := concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4)	as GB4
						from
							DAT_GOODS_OPTION	o
							, (SELECT @aa41:=0, @rownum41:=0 FROM dual)   r1
							, (SELECT @aa42:=0, @rownum42:=0 FROM dual)   r2
							, (SELECT @aa43:=0, @rownum43:=0 FROM dual)   r3
							, (SELECT @aa44:=0, @rownum44:=0 FROM dual)   r4
						where
							o.GOODS_CD	= ".$goods_code."
						and	o.USE_YN	= 'Y'
						and o.QTY > 0
						order by
							o.M_OPTION_1
							, o.M_OPTION_2
							, o.M_OPTION_3
							, o.M_OPTION_4
					)	t
					inner join
						DAT_GOODS_OPTION_PRICE		op
					on	op.GOODS_OPTION_PRICE_NO	= t.GOODS_OPTION_PRICE_NO
			)
			union all
			(
				select
					  concat(t.RN1, '|', t.RN2, '|', t.RN3, '|', t.RN4, '|', t.RN5 )	as SEQ
					, t.GB5																as OPT_NAME
					, if( 5 = ".$max_moption.", t.GOODS_OPTION_CD, 0 )					as GOODS_OPTION_CD
					, if( 5 = ".$max_moption.", t.QTY, 99 )								as GOODS_OPTION_QTY
					, if( 5 = ".$max_moption.", op.GOODS_OPTION_ADD_PRICE, 0 )			as GOODS_OPTION_ADD_PRICE
				from
					(	select
							  o.GOODS_OPTION_CD
							, o.GOODS_OPTION_NM
							, o.QTY
							, o.GOODS_OPTION_PRICE_NO
							, case	when @aa51 = o.M_OPTION_1	then @rownum51 else @rownum51 := @rownum51 + 1	end		as RN1
							, case  when @aa51 != o.M_OPTION_1	then @rownum52 := 1
									when @aa52 = concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum52 else @rownum52 := @rownum52 + 1 end		as RN2
							, case  when @aa51 != o.M_OPTION_1 or @aa52 != concat(o.M_OPTION_1,'/',o.M_OPTION_2)	then @rownum53 := 1
									when @aa53 = concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)	then @rownum53 else @rownum53 := @rownum53 + 1 end		as RN3
							, case  when @aa51 != o.M_OPTION_1 or @aa52 != concat(o.M_OPTION_1,'/',o.M_OPTION_2) or @aa53 != concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)	then @rownum54 := 1
									when @aa54 = concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4)	then @rownum54 else @rownum54 := @rownum54 + 1 end		as RN4
							, case  when @aa51 != o.M_OPTION_1 or @aa52 != concat(o.M_OPTION_1,'/',o.M_OPTION_2) or @aa53 != concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3) or @aa54 != concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4)	then @rownum55 := 1
									when @aa55 = concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4,'/',o.M_OPTION_5)	then @rownum55 else @rownum55 := @rownum55 + 1 end		as RN5
							, @aa51 := o.M_OPTION_1																		as GB1
							, @aa52 := concat(o.M_OPTION_1,'/',o.M_OPTION_2)											as GB2
							, @aa53 := concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3)							as GB3
							, @aa54 := concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4)			as GB4
							, @aa55 := concat(o.M_OPTION_1,'/',o.M_OPTION_2,'/',o.M_OPTION_3,'/',M_OPTION_4,'/',o.M_OPTION_5)	as GB5
						from
							DAT_GOODS_OPTION	o
							, (SELECT @aa51:=0, @rownum51:=0 FROM dual)   r1
							, (SELECT @aa52:=0, @rownum52:=0 FROM dual)   r2
							, (SELECT @aa53:=0, @rownum53:=0 FROM dual)   r3
							, (SELECT @aa54:=0, @rownum54:=0 FROM dual)   r4
							, (SELECT @aa55:=0, @rownum55:=0 FROM dual)   r5
						where
							o.GOODS_CD	= ".$goods_code."
						and	o.USE_YN	= 'Y'
						and o.QTY > 0
						order by
							o.M_OPTION_1
							, o.M_OPTION_2
							, o.M_OPTION_3
							, o.M_OPTION_4
							, o.M_OPTION_5
					)	t
					inner join
						DAT_GOODS_OPTION_PRICE		op
					on	op.GOODS_OPTION_PRICE_NO	= t.GOODS_OPTION_PRICE_NO
			)
			order by GOODS_OPTION_CD ASC		
		";
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 상품 가격 정보
     */
    public function get_goods_price($goods_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_price > ETAH 상품 가격 정보 데이터 구하기 */
				  g.GOODS_CD
				, g.GOODS_NM
				, price.GOODS_PRICE_CD
				, price.STREET_PRICE
				, price.SELLING_PRICE
				, price.FACTORY_PRICE
			from
				DAT_GOODS		g

			inner join
				DAT_GOODS_PRICE			price
			on	 price.GOODS_PRICE_CD	= g.GOODS_PRICE_CD
			and price.USE_YN			= 'Y'

			where
				1 = 1
			and g.GOODS_CD	= '".$goods_code."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 상품 상세 정보
     */
    public function get_goods_detail_info($goods_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_detail_info > ETAH 상품 상세 정보 데이터 구하기 */
				  g.GOODS_CD
			--	, g.GOODS_NM
				, ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
				, cm1.CATEGORY_MNG_CD					as CATEGORY_MNG_CD1
				, cm1.CATEGORY_NM 						as CATEGORY_MNG_NM1
				, cm2.CATEGORY_MNG_CD					as CATEGORY_MNG_CD2
				, cm2.CATEGORY_NM 						as CATEGORY_MNG_NM2
				, g.CATEGORY_MNG_CD						as CATEGORY_MNG_CD3
				, cm3.CATEGORY_NM 						as CATEGORY_MNG_NM3
				, g.MODEL_NM
				, gp.GOODS_STS_CD						as GOODS_STATE_CD
				, gp2.GOODS_STS_CD_NM					as GOODS_STATE
				, price.GOODS_PRICE_CD
				, price.STREET_PRICE
				, price.SELLING_PRICE
				, price.FACTORY_PRICE
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)			as GOODS_MILEAGE_SAVE_RATE
				, dp.DELIV_COMPANY_CD
				, cd.CD_NM								as DELIV_COMPANY_NM
				, dp.RETURN_DELIV_COST
				, subvenreturn.VENDOR_SUBVENDOR_CD
				, subvenreturn.RETURN_ZIPCODE
				, subvenreturn.RETURN_ADDR
				, concat(g.VENDOR_SUBVENDOR_CD,'_',g.DELIV_POLICY_NO)	as DELI_CODE
				, max(dpp.DELIV_COST_DECIDE_VAL)		as DELI_LIMIT
				, max(dpp.DELIV_COST)					as DELI_COST
				, gd.DESCRIPTION
				, b.BRAND_CD
				, b.BRAND_NM
				, b.WEB_BRAND_LOGO_URL					as BRAND_LOGO_IMG
				, b.WEB_BRAND_IMG_URL					as BRAND_IMG
				, b.WEB_BRAND_DESC						as BRAND_DESC
				, b.MAP_URL                             as BRAND_ADDRESS
				, b.WEB_DISP_YN
				, dp.DELIV_POLICY_NO
				, dp.PATTERN_TYPE_CD
				, dp.PACK_YN                            as PACKED_DELI
				, vs.VENDOR_SUBVENDOR_TEL
				, max(adc.DELIV_POLICY_ADD_DELIV_COST_NO)	as ADD_DELIVERY
				, max(nodeliv.DELIV_POLICY_NO_DELIV_NO)		as NO_DELIVERY
			--	, gi.IMG_URL
			    , ifnull(im.IMG_URL, gi.IMG_URL)     as IMG_URL
				, vs.SEND_NATION
				, g.BUY_LIMIT_CD
				, g.BUY_LIMIT_QTY
				, g.TAX_GB_CD
				, g.VENDOR_SUBVENDOR_CD
				, vs.VENDOR_CD
				, cg.START_DT
				, cg.END_DT
				, if(cg.CLASS_TYPE='ONE', '원데이', if(cg.CLASS_TYPE='MANY', '다회차', ''))                   as CLASS_TYPE
                , cg.ADDRESS	
                
                , if((length(gc.GRADE_VAL)=1)
                    , sum(gc.GRADE_VAL)
                    , sum(substring(gc.GRADE_VAL,1,1))/count(gc.CUST_GOODS_COMMENT)
                        + sum(substring(gc.GRADE_VAL,2,1))/count(gc.CUST_GOODS_COMMENT)
                        + sum(substring(gc.GRADE_VAL,3,1))/count(gc.CUST_GOODS_COMMENT)
                        + sum(substring(gc.GRADE_VAL,4,1))/count(gc.CUST_GOODS_COMMENT))/4	      as TOTAL_GRADE_VAL
                , (select PLAN_EVENT_REFER_CD from DAT_PLAN_EVENT_GOODS
                    where GOODS_CD = g.GOODS_CD and PLAN_EVENT_CODE in (586,587) limit 1)         as DEAL
                        	          
  			from
				DAT_GOODS		g
				
            left join 
                DAT_GOODS_MD_MOD        gmm
            on g.GOODS_CD 				= gmm.GOODS_CD
            and gmm.USE_YN 				= 'Y'
				
			inner join
				DAT_CATEGORY_MNG		cm3
			on g.CATEGORY_MNG_CD				= cm3.CATEGORY_MNG_CD

			inner join
				DAT_CATEGORY_MNG		cm2
			on cm3.PARENT_CATEGORY_MNG_CD		= cm2.CATEGORY_MNG_CD

			inner join
				DAT_CATEGORY_MNG		cm1
			on	cm2.PARENT_CATEGORY_MNG_CD		= cm1.CATEGORY_MNG_CD
			and cm1.PARENT_CATEGORY_MNG_CD		IS NULL

			inner join
				DAT_GOODS_PROGRESS		gp
			on gp.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
			and gp.USE_YN				= 'Y'

			inner join
				COD_GOODS_STS_CD		gp2
			on gp2.GOODS_STS_CD			= gp.GOODS_STS_CD

			inner join
				DAT_GOODS_PRICE			price
			on	price.GOODS_PRICE_CD	= g.GOODS_PRICE_CD
			and price.USE_YN			= 'Y'

			left join
				MAP_GOODS_MILEAGE_N_GOODS		mileage
			on	mileage.GOODS_MILEAGE_N_GOODS_NO	= g.GOODS_MILEAGE_N_GOODS_NO
			and mileage.USE_YN	= 'Y'

			inner join
				DAT_DELIV_POLICY		dp
			on	dp.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and dp.USE_YN			= 'Y'

			left join
				DAT_VENDOR_SUBVENDOR		vs
			on vs.VENDOR_SUBVENDOR_CD	= dp.VENDOR_SUBVENDOR_CD
			and vs.USE_YN = 'Y'

			left join
				DAT_VENDOR_SUBVENDOR_RETURN_ADDR		subvenreturn
			on subvenreturn.VENDOR_SUBVENDOR_CD	= vs.VENDOR_SUBVENDOR_CD
			and subvenreturn.USE_YN = 'Y'

			left join
				DAT_DELIV_POLICY_PATTERN		dpp
			on dpp.DELIV_POLICY_NO	= dp.DELIV_POLICY_NO

			left join
				COD_DELIV_COMPANY			cd
			on cd.DELIV_COMPANY_CD	= dp.DELIV_COMPANY_CD

			left join
				DAT_GOODS_DESC				gd
			on gd.GOODS_CD		= g.GOODS_CD
			and gd.USE_YN		= 'Y'

			inner join
				DAT_BRAND		b
			on	b.BRAND_CD		= g.BRAND_CD

			left join
				DAT_DELIV_POLICY_ADD_DELIV_COST		adc
			on	adc.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and adc.USE_YN			= 'Y'

			left join
				DAT_DELIV_POLICY_NO_DELIV			nodeliv
			on	nodeliv.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and nodeliv.USE_YN			= 'Y'

			inner join
				DAT_GOODS_IMAGE			gi
			on	gi.GOODS_CD				= g.GOODS_CD
			and	gi.TYPE_CD				= 'TITLE'
			
			left join
                DAT_GOODS_IMAGE_MD		im
            on	g.GOODS_CD				= im.GOODS_CD
            and	im.TYPE_CD				= 'TITLE'
			
			left join 
			    MAP_CLASS_GOODS cg
			on g.GOODS_CD               = cg.GOODS_CD
			and cg.USE_YN               = 'Y'
			
			left join 
			    DAT_CUST_GOODS_COMMENT  gc
            on g.GOODS_CD               = gc.GOODS_CD
            and gc.USE_YN               ='Y'
            
			where
				1 = 1
			and g.USE_YN	= 'Y'
			and g.GOODS_CD	= '".$goods_code."'

			group by
				g.GOODS_CD
		";
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 상품 태그 정보
     */
    public function get_goods_tag($goods_code){
        $query = "
            select      /*  > etah_front > goods_m > get_goods_tag > ETAH 상품 태그 조회 */
                t.TAG_NO
                , t.TAG_NM 
            from 
                DAT_TAG t 
                
            inner join 
                MAP_TAG_N_GOODS tg 
            on t.TAG_NO = tg.TAG_NO 
            and tg.AVAIL_FLAG = 'Y'
            
            left join
            	MAP_TAG_N_GOODS tg2
            on t.TAG_NO = tg2.TAG_NO
            and tg2.AVAIL_FLAG = 'Y'
            
            where 
                tg.GOODS_CD = '".$goods_code."' 
                and t.AVAIL_FLAG = 'Y'
                
            group by t.TAG_NO     
            
            order by 
            count(tg2.GOODS_CD) desc, t.TAG_NO desc
                 
            limit 15
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 MD 추천멘트
     */
    public function get_mdTalk($goods_code){
        $query = "
            select    /*  > etah_front > goods_m > get_mdTalk > ETAH MD 추천멘트 조회 */
                m.GOODS_DESC_MD_GB_CD
                , m.HEADER_DESC
            from 
                DAT_GOODS_DESC_MD m
            where 
                1=1
            and m.GOODS_CD = '".$goods_code."'
            and m.USE_YN = 'Y'
            order by m.DISP_SORT
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 이 상품이 포함된 기획전
     */
    public function get_plan_event_in_goods($gubun, $goods_code, $cate_cd)
    {
        $query_where = "";

        if($gubun =='A') {      //상품이 포함된 기획전
            $query_where = "and eg.GOODS_CD = '".$goods_code."'";
        }

        if($gubun == 'B') {     //인기기획전
            //카테고리 지정
            switch( $cate_cd ) {
                case '10000000' :   $category = '1030';break;
                case '11000000' :   $category = '2010';break;
                case '13000000' :   $category = '2020';break;
                case '14000000' :   $category = '2030';break;
                case '15000000' :   $category = '1040';break;
                case '16000000' :   $category = '1010';break;
                case '17000000' :   $category = '1020,1050';break;
                case '18000000' :   $category = '3040';break;
                case '19000000' :   $category = '3010';break;
                case '21000000' :   $category = '3020,3030';break;
                case '22000000' :   $category = '1060';break;
                case '23000000' :   $category = '1070';break;
                case '24000000' :   $category = '4010';break;
                default : $category = '1010,1020,1030,1040,1050,1060,1070,2010,2020,2030,3010,3020,3030,3040';break;
            }

            $query_where = "and e.BRAND_CATEGORY_CD in (".$category.")";
        }

        $query = "
            select          /*  > etah_front > goods_m > get_plan_event_in_goods > 상품상세 기획전 가져오기 */
                e.PLAN_EVENT_CD
                , e.TITLE
                , e.IMG_URL
                , '".$gubun."' as GUBUN
            from 
                  DAT_PLAN_EVENT e
            inner join DAT_PLAN_EVENT_GOODS eg
            on e.PLAN_EVENT_CD = eg.PLAN_EVENT_CODE
            
            where 1=1
                  and e.USE_YN = 'Y'
                  and e.DISP_YN = 'Y'
            $query_where
            group by e.PLAN_EVENT_CD
            order by e.HITS desc, e.PLAN_EVENT_CD desc
            limit 4
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 이 상품이 포함된 매거진
     */
    public function get_magazine_in_goods($gubun, $goods_code, $cate_cd)
    {
        $query_join = "";
        $query_where = "";

        if($gubun =='A') {      //상품이 포함된 매거진
            $query_join = "
            inner join MAP_MAGAZINE_GOODS g 
            on m.MAGAZINE_NO = g.MAGAZINE_NO
            and g.GOODS_CD = '".$goods_code."'
            ";
        }

        if($gubun == 'B') {     //인기매거진
            //카테고리 지정
            if($cate_cd == '24000000') $query_where = "and left(m.CATEGORY_CD, 1) in (7)";
            else $query_where = "and left(m.CATEGORY_CD, 1) in (5,6)";
        }

        $query = "
            select      /*  > etah_front > goods_m > get_magazine_in_goods > 상품상세 매거진 가져오기 */
                m.MAGAZINE_NO
                , m.TITLE
                , m.IMG_URL
                , '".$gubun."' as GUBUN
            
            from 
                DAT_MAGAZINE m
            $query_join
            
            where 1=1
            and m.USE_YN = 'Y'
            $query_where
            
            group by m.MAGAZINE_NO
            order by m.HITS desc, m.MAGAZINE_NO desc
            limit 4
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 옵션 재고수량
     */
    public function get_goods_option_qty($goods_option_code)
    {
        $query = "
				select	/*  > etah_front > goods_m > get_goods_option_qty > ETAH 상품 옵션 재고수량 */
					ifnull(go.QTY, 0)		as QTY
				from
					DAT_GOODS_OPTION		go
				where
					1 = 1
				and go.GOODS_OPTION_CD		= '".$goods_option_code."'
			";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 상품 정보고시 정보
     */
    public function get_goods_extend($param)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_extend > ETAH 상품 정보고시 정보 */
				  ge.GOODS_CD		as goods_code
				, ge.KIND			as kind
				, ge.ARTICLE0		as article0
				, ge.ARTICLE1		as article1
				, ge.ARTICLE2		as article2
				, ge.ARTICLE3		as article3
				, ge.ARTICLE4		as article4
				, ge.ARTICLE5		as article5
				, ge.ARTICLE6		as article6
				, ge.ARTICLE7		as article7
				, ge.ARTICLE8		as article8
				, ge.ARTICLE9		as article9
				, ge.ARTICLE10		as article10
				, ge.ARTICLE11		as article11
				, ge.ARTICLE12		as article12
				, ge.REG_DT			as registerd_time
				, ge.UPD_DT			as last_updated_time
			from
				DAT_GOODS_GOR_EXTEND		ge
			where
				ge.GOODS_CD = '".$param['goods_code']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 상품 정보고시 항목 설명 정보
     */
    public function get_goods_exnted_info($kind_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_exnted_info > ETAH 상품 정보고시 항목 설명 정보 */
				  gi.KIND_CD			as kind_code
                , gi.KIND_NM			as kind_name
                , gi.BRANCH_CD			as branch_code
                , gi.BRANCH_NM			as branch_name
                , gi.ARTICLE_FIELD_NM	as article_code
				, substring(gi.ARTICLE_FIELD_NM,8,2)		as numbering
			from
				DAT_GOODS_GOR_EXTEND_INFO		gi
			where
				gi.KIND_CD       = '".$kind_code."'
			order by
				numbering*1 asc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 쿠폰 정보
     */
    public function get_goods_coupon_info($param, $gubun)
    {
        $query = "
			select	/*  > etah_front > goods_m > get_goods_coupon_info > ETAH 상품(아이템) 쿠폰 정보 구하기 */
				   cpn.COUPON_CD
				 , cpn.DC_COUPON_NM
				 , ifnull(cpn.WEB_DISP_DC_COUPON_NM, cpn.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
				 , cpn.COUPON_KIND_CD
				 , cpn.COUPON_DC_METHOD_CD
				 , cpn.COUPON_FLAT_RATE
				 , cpn.COUPON_FLAT_AMT
				 , ifnull(cpn.MAX_DISCOUNT, 0)		as	MAX_DISCOUNT
				 , TO_DAYS(date_format(cpn.COUPON_END_DT,\"%Y-%m-%d\")) - TO_DAYS(date_format(cpn.COUPON_START_DT,\"%Y-%m-%d\")) as OBJECT_CD
			from
				DAT_COUPON			cpn

			inner join
				DAT_COUPON_PROGRESS		cpp
			on	cpp.COUPON_CD	= cpn.COUPON_CD
			and cpp.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
											from	DAT_COUPON_PROGRESS
											where	COUPON_CD	= cpp.COUPON_CD
										)
			and cpp.USE_YN		= 'Y'

			left join
				MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp
			on	mcp.COUPON_CD	= cpn.COUPON_CD
			and	mcp.USE_YN		= 'Y'

			where
				1 = 1
			and cpn.USE_YN = 'Y'
			and cpn.COUPON_KIND_CD = '".$gubun."'
			and cpn.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'GOODS'
			and if(cpn.COUPON_START_DT is null, 1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())
		--	and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
			and cpp.COUPON_PROGRESS_STS_CD	= '03'
			and mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'

			order by
					OBJECT_CD ASC,cpn.COUPON_CD	desc
			limit	1
		";

        /* 모든 RATE 쿠폰을 AMT로 변환 & 반올림한 금액으로, 이미 AMT인 쿠폰은 값이 들어갈 때 1원 단위 불가 => MD는 1원 단위로 금액 입력가능 */
        $queryNew = "
                select	/*  > etah_front > goods_m > get_goods_coupon_info > ETAH 상품(아이템) 쿠폰 정보 구하기 */
				   cpn.COUPON_CD
				 , cpn.DC_COUPON_NM
				 , ifnull(cpn.WEB_DISP_DC_COUPON_NM, cpn.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
				 , cpn.COUPON_KIND_CD
				 , if(cpn.COUPON_DC_METHOD_CD = 'RATE', 'AMT', cpn.COUPON_DC_METHOD_CD) AS COUPON_DC_METHOD_CD
				 , if(cpn.COUPON_DC_METHOD_CD = 'RATE', 0, cpn.COUPON_FLAT_RATE) AS COUPON_FLAT_RATE
				 , if(cpn.COUPON_DC_METHOD_CD = 'RATE', 
				        (SELECT 
				            round(gp.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000 )/10)*10 
				        FROM DAT_GOODS g 
				        INNER JOIN DAT_GOODS_PRICE gp 
				            ON g.GOODS_PRICE_CD = gp.GOODS_PRICE_CD 
				            AND g.GOODS_CD = '".$param['goods_code']."')
				        , cpn.COUPON_FLAT_AMT)                                                              AS COUPON_FLAT_AMT
				 , ifnull(cpn.MAX_DISCOUNT, 0)		as	MAX_DISCOUNT
				 , TO_DAYS(date_format(cpn.COUPON_END_DT,'%Y-%m-%d')) - TO_DAYS(date_format(cpn.COUPON_START_DT,'%Y-%m-%d')) as OBJECT_CD
                from
                    DAT_COUPON			cpn
    
                inner join
                    DAT_COUPON_PROGRESS		cpp
                on	cpp.COUPON_CD	= cpn.COUPON_CD
                and cpp.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
                                                from	DAT_COUPON_PROGRESS
                                                where	COUPON_CD	= cpp.COUPON_CD
                                            )
                and cpp.USE_YN		= 'Y'
    
                left join
                    MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp
                on	mcp.COUPON_CD	= cpn.COUPON_CD
                and	mcp.USE_YN		= 'Y'
    
                where
                    1 = 1
                and cpn.USE_YN = 'Y'
                and cpn.COUPON_KIND_CD = '".$gubun."'
                and cpn.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'GOODS'
                and if(cpn.COUPON_START_DT is null, 1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())
            --	and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
                and cpp.COUPON_PROGRESS_STS_CD	= '03'
                and mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'
    
                order by
                        OBJECT_CD ASC,cpn.COUPON_CD	desc
                limit	1
        "; //2020-05-18 쿠폰 반올림 시스템 적용

        $db = self::_slave_db();
        return $db->query($queryNew)->row_array();
    }


    /**
     * 상품 속성 정보
     */
    public function get_goods_class($goods_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_class > ETAH 상품 속성 데이터 구하기 */
				  gca.GOODS_CLASSIFICATION_ATTR_CD_NM	as CLASS_ATTR_SUB
				, gca2.GOODS_CLASSIFICATION_ATTR_CD_NM	as CLASS_ATTR_MAIN
			from
				DAT_GOODS			g

			left join
				MAP_CLASS_ATTR_N_GOODS		mca
			on mca.GOODS_CD	= g.GOODS_CD
			and mca.USE_YN	= 'Y'

			inner join
				DAT_GOODS_CLASSIFICATION_ATTR			gca
			on gca.GOODS_CLASSIFICATION_ATTR_CD	= mca.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO
			and gca.USE_YN						= 'Y'

			inner join
				DAT_GOODS_CLASSIFICATION_ATTR			gca2
			on gca.PARENT_GOODS_CLASSIFICATION_ATTR_CD	= gca2.GOODS_CLASSIFICATION_ATTR_CD

			where
				1 = 1
			and g.GOODS_CD = '".$goods_code."'
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 이미지 정보
     */
    public function get_goods_img($goods_code)
    {
        $query = "
		    select      /*  > etah_front > goods_m > get_goods_img > ETAH 상품 이미지 데이터 구하기 */
				a.TYPE_CD
				, a.IMG_URL
				, a.GUBUN
            from 
                (
                    select 
                        gi.TYPE_CD
                        , gi.SEQ
                        , gi.IMG_URL
                        , 'B' as GUBUN
                    from DAT_GOODS_IMAGE gi
                    where 
                    1=1
                    and gi.GOODS_CD = '".$goods_code."'
                    and gi.USE_YN = 'Y'
                    
                    union all
                    
                    select 
                        gim.TYPE_CD
                        , gim.SEQ
                        , gim.IMG_URL
                        , 'A' as GUBUN
                    from DAT_GOODS_IMAGE_MD gim
                    where 
                    1=1
                    and gim.GOODS_CD = '".$goods_code."'
                    and gim.USE_YN = 'Y'
                ) a
            
            order by a.GUBUN, a.SEQ
		 ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 상세리스트 정보
     */
    public function get_goods_desc($goods_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_desc > ETAH 상품 상세리스트 정보 구하기 */
				  gdb.GOODS_DESC_BLOG_GB_CD
				, gdb.HEADER_DESC
				, g.VENDOR_SUBVENDOR_CD
				, gdt.TITLE_IMG_URL
				, gdt.NOTICE_IMG_URL
			    , gdt.DELIV_IMG_URL
			    , gdt.TEMPLATE_GB_CD
			    , b.BRAND_NM
			    , vs.VENDOR_CD
			    , sn.IMG_URL		as SUBVENDOR_NOTICE
			from
				DAT_GOODS_DESC_BLOG		gdb
			inner join DAT_GOODS g
			on g.GOODS_CD = gdb.GOODS_CD
			
			inner join DAT_BRAND b
			on b.BRAND_CD = g.BRAND_CD	
			
			left join DAT_VENDOR_SUBVENDOR		vs
			on vs.VENDOR_SUBVENDOR_CD	= g.VENDOR_SUBVENDOR_CD
			and vs.USE_YN = 'Y'
			
			left outer join MAP_GOODS_DESC_TEMPLATE_N_SUBVENDOR mdt
			on g.VENDOR_SUBVENDOR_CD =  mdt.VENDOR_SUBVENDOR_CD
			
			left outer join DAT_GOODS_DESC_TEMPLATE gdt
			on gdt.GOODS_DESC_TEMPLATE = mdt.GOODS_DESC_TEMPLATE
			
			left join DAT_GOODS_SUBVENDOR_NOTICE	sn
			on sn.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
			and sn.USE_YN = 'Y'
			and sn.START_DT < now()
			and sn.END_DT > now()
							
			where
				1 = 1
			and gdb.GOODS_CD = '".$goods_code."'
			and gdb.USE_YN = 'Y'

			order by
				gdb.DISP_SORT		asc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 동일한 브랜드의 추천상품
     */
    public function get_brand_goods($brand_code, $goods_code, $cate_code)
    {
        $query = "("."
		          SELECT           /*  > etah_front > goods_m > get_brand_goods > ETAH 상품과 동일한 브랜드의 추천 상품 데이터 구하기 */
		                 g.GOODS_CD
		               , g.GOODS_NM
		               , b.BRAND_CD
		               , b.BRAND_NM
		           --    , gi.IMG_URL
                       , ifnull(im.IMG_URL, gi.IMG_URL)   as IMG_URL
		               , price.SELLING_PRICE
		               , eg.PLAN_EVENT_REFER_CD		as DEAL 
                  FROM
		          DAT_GOODS_SORT_SCORE		ranking
                    
                  INNER JOIN
		          DAT_GOODS				    g ON g.GOODS_CD			    = ranking.GOODS_CD
                  INNER JOIN
		          DAT_GOODS_PROGRESS		gp ON gp.GOODS_PROGRESS_NO	= g.GOODS_PROGRESS_NO
                  INNER JOIN
		          COD_GOODS_STS_CD		    gp2 ON gp2.GOODS_STS_CD		= gp.GOODS_STS_CD
                  LEFT JOIN
		          DAT_GOODS_PRICE		    price ON g.GOODS_PRICE_CD   = price.GOODS_PRICE_CD
                  INNER JOIN
		          DAT_GOODS_IMAGE			gi ON gi.GOODS_CD			= g.GOODS_CD 
		          AND                       gi.SEQ				        = 0
		          LEFT JOIN
		          DAT_GOODS_IMAGE_MD        im ON im.GOODS_CD			= g.GOODS_CD 
		          AND                       im.SEQ				        = 0
                  INNER JOIN
		          DAT_BRAND				    b ON b.BRAND_CD			    = g.BRAND_CD
		          LEFT JOIN           
		          DAT_PLAN_EVENT_GOODS      eg ON g.GOODS_CD            = eg.GOODS_CD
				  AND                       eg.PLAN_EVENT_CODE          in (586,587)  
		          
                  WHERE
		          1 = 1 AND 
		          b.BRAND_CD		= ? AND 
		          g.GOODS_CD		!= ? AND 
		          g.WEB_DISP_YN	    = 'Y' AND 
		          gp.GOODS_STS_CD	= '03'
        
                  ORDER BY
		          ranking.GOODS_SORT_SCORE DESC, ranking.GOODS_CD DESC
                  LIMIT 3) 

                 union all

                 (SELECT
		                g.GOODS_CD
		              , g.GOODS_NM
		              , b.BRAND_CD
		              , b.BRAND_NM
		              , gi.IMG_URL
		              , price.SELLING_PRICE
		              , eg.PLAN_EVENT_REFER_CD		as DEAL 
                 FROM
		         DAT_GOODS	g		
                 INNER JOIN
		         DAT_GOODS_PROGRESS	     gp ON gp.GOODS_PROGRESS_NO	   = g.GOODS_PROGRESS_NO
                 INNER JOIN
		         COD_GOODS_STS_CD		 gp2 ON gp2.GOODS_STS_CD	   = gp.GOODS_STS_CD
                 LEFT JOIN
		         DAT_GOODS_PRICE		 price ON g.GOODS_PRICE_CD	   = price.GOODS_PRICE_CD
                 INNER JOIN
		         DAT_GOODS_IMAGE		gi ON gi.GOODS_CD			   = g.GOODS_CD 
		         AND                    gi.SEQ				           = 0
                 INNER JOIN
		         DAT_BRAND				b ON b.BRAND_CD			       = g.BRAND_CD
		         LEFT JOIN           
		         DAT_PLAN_EVENT_GOODS   eg ON g.GOODS_CD            = eg.GOODS_CD
				 AND                    eg.PLAN_EVENT_CODE          in (586,587)  
                 
                 WHERE
		         1 = 1 AND
		         g.CATEGORY_MNG_CD  = ?   AND 
		         g.GOODS_CD		    != ?  AND 
		         g.WEB_DISP_YN	    = 'Y' AND 
		         gp.GOODS_STS_CD	= '03'
                 
                 ORDER BY
                 rand() LIMIT 3)";

        $db = self::_slave_db();
        $result = $db->query($query, array($brand_code, $goods_code, $cate_code, $goods_code))->result_array();
        //바인딩 처리.
//        log_message('DEBUG','========================='.$db->last_query());
        return $result;
    }

    /**
     * 추천상품
     */
    public function get_goods($gubun, $parent_cate, $goods_code, $brand_code)
    {
        $query_where = "";
        $query_limit = "";

        //카테고리 추천상품
        if($gubun == 'C') {
            $query_where = "
                and g.CATEGORY_MNG_CD             = '".$parent_cate."'
                and g.GOODS_CD                   != '".$goods_code."'
                and g.BRAND_CD                   != '".$brand_code."'
            ";
            $query_limit = "limit 6";
        }
        //브랜드 추천상품
        if($gubun == 'B') {
            $query_where = "
                and g.BRAND_CD                    = '".$brand_code."'
                and g.GOODS_CD                   != '".$goods_code."'
            ";
            $query_limit = "limit 6";
        }

        $query = "
			select      /*  > etah_front > goods_m > get_goods > 추천상품 */
                      g.GOODS_CD
                --  , g.GOODS_NM
                    , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
                    , b.BRAND_CD
                    , b.BRAND_NM
                    , ifnull(gim.IMG_URL, gi.IMG_URL)   as IMG_URL
                    , price.SELLING_PRICE
                    
                    , dp.DELIV_POLICY_NO
                    , dp.PATTERN_TYPE_CD
                    , max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
                    , max(dpp.DELIV_COST)								as DELI_COST
                    , if(round(price.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, round(price.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_S
                    , if(round(price.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, round(price.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_G
                    , ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
                    , ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
                    , cpn_s.COUPON_CD									as COUPON_CD_S
                    , cpn_g.COUPON_CD									as COUPON_CD_G
                    , ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
                    
                    , if(left(g.CATEGORY_MNG_CD, 4)=2401, 'C', if(left(g.CATEGORY_MNG_CD, 4)=2402, 'G', ''))    as CLASS_GUBUN
                    , (select PLAN_EVENT_REFER_CD from DAT_PLAN_EVENT_GOODS
                        where GOODS_CD = g.GOODS_CD and PLAN_EVENT_CODE in (586,587) limit 1)        as DEAL
			from
                    DAT_GOODS	g
                    left join DAT_GOODS_MD_MOD                 gmm
                            on g.GOODS_CD                       = gmm.GOODS_CD
                            and gmm.USE_YN                      = 'Y'
                    left join DAT_CATEGORY_MNG                 cm
                            on g.CATEGORY_MNG_CD                = cm.CATEGORY_MNG_CD
                    inner join DAT_GOODS_PROGRESS              gp
                            on g.GOODS_PROGRESS_NO              = gp.GOODS_PROGRESS_NO
                    inner join COD_GOODS_STS_CD	            gp2
                            on gp.GOODS_STS_CD                  = gp2.GOODS_STS_CD
                    left join DAT_GOODS_PRICE                  price
                            on g.GOODS_PRICE_CD                 = price.GOODS_PRICE_CD
                    inner join DAT_GOODS_IMAGE                 gi
                            on gi.GOODS_CD                      = g.GOODS_CD
                            and gi.SEQ                          = 0
                    left join DAT_GOODS_IMAGE_MD               gim
                            on gim.GOODS_CD                     = g.GOODS_CD
                            and gim.SEQ                         = 0        
                    inner join DAT_BRAND                       b
                            on b.BRAND_CD                       = g.BRAND_CD
                    left join DAT_GOODS_SORT_SCORE	            ranking
                            on g.GOODS_CD                       = ranking.GOODS_CD
                    left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
                            on	mileage.GOODS_MILEAGE_N_GOODS_NO= g.GOODS_MILEAGE_N_GOODS_NO
                            and mileage.USE_YN					= 'Y'
                    inner join	DAT_DELIV_POLICY				dp
                        on	dp.DELIV_POLICY_NO					= g.DELIV_POLICY_NO
                        and dp.USE_YN							= 'Y'
                    left join	DAT_DELIV_POLICY_PATTERN		dpp
                        on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO
                        left join	BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
                        on	g.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD
                    left join	BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
                        on	g.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD
				
            where
                    1 = 1
                    and g.WEB_DISP_YN                = 'Y'
                    and gp.GOODS_STS_CD              = '03'
                    $query_where
            group by 
                    g.GOODS_CD
            order by
                    ranking.GOODS_SORT_SCORE desc, g.HITS desc, g.GOODS_CD desc
            $query_limit
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 상품 옵션
     */
    public function get_goods_option($goods_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_option > ETAH 상품의 옵션 데이터 구하기 */
				  go.GOODS_OPTION_CD
				, go.GOODS_CD
				, go.GOODS_OPTION_NM
				, go.M_OPTION_1
				, go.M_OPTION_2
				, go.M_OPTION_3
				, go.M_OPTION_4
				, go.M_OPTION_5
				, ifnull(go.QTY, 0)				as QTY
				, ifnull(gop.GOODS_OPTION_ADD_PRICE, 0)		as GOODS_OPTION_ADD_PRICE
				, case	when	M_OPTION_5 != '' then	'M_OPTION_5'
						when 	M_OPTION_4 != '' then	'M_OPTION_4'
						when	M_OPTION_3 != '' then	'M_OPTION_3'
						when	M_OPTION_2 != '' then	'M_OPTION_2'
						when	M_OPTION_1 != '' then	'M_OPTION_1'
				  end							as MOPTION_RESULT
			from
				DAT_GOODS_OPTION			go

			left join
				DAT_GOODS_OPTION_PRICE		gop
			on gop.GOODS_OPTION_PRICE_NO	= go.GOODS_OPTION_PRICE_NO
			and gop.USE_YN	= 'Y'

			where
				1 = 1
			and go.GOODS_CD	= '".$goods_code."'
			and go.USE_YN	= 'Y'
			order by
				go.GOODS_OPTION_CD	asc
		";
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 옵션 정보
     */
    public function get_goods_option_info($goods_code)
    {
        $query = "
            SELECT 
                    oi.M_OPTION_1_NM
                    , oi.M_OPTION_2_NM
                    , oi.M_OPTION_3_NM
                    , oi.M_OPTION_4_NM
                    , oi.M_OPTION_5_NM
            FROM 
                    DAT_GOODS_OPTION_INFO oi 
            WHERE 
                    oi.GOODS_CD = '".$goods_code."'
                    and oi.USE_YN = 'Y'
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 상품의 멀티옵션 정보
     */
    public function get_goods_moption($goods_code, $moption)
    {
        $query = "
			select		/*	> etah_front > goods_m > get_goods_moption > ETAH 상품의 멀티옵션 데이터 구하기 */
				  go.GOODS_OPTION_CD
				, go.M_OPTION_1
				, go.M_OPTION_2
				, go.M_OPTION_3
				, go.M_OPTION_4
				, go.M_OPTION_5
				, ifnull(max(go.QTY),0)		as QTY
			from
				DAT_GOODS_OPTION			go

			left join
				DAT_GOODS_OPTION_PRICE		gop
			on gop.GOODS_OPTION_PRICE_NO	= go.GOODS_OPTION_PRICE_NO
			and gop.USE_YN	= 'Y'

			where
				1 = 1
			and go.GOODS_CD		= '".$goods_code."'
			and go.".$moption."	!= ''
			and go.USE_YN		= 'Y'

			group by
				".$moption."

			order by
				go.GOODS_OPTION_CD	asc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 선택한 멀티옵션들의 옵션 정보
     */
    public function get_goods_moption_info($param)
    {
        $query_moption1 = "";
        $query_moption2 = "";
        $query_moption3 = "";
        $query_moption4 = "";
        $query_moption5 = "";
        $subquery_moption1 = "";
        $subquery_moption2 = "";
        $subquery_moption3 = "";
        $subquery_moption4 = "";
        $subquery_moption5 = "";
        $group_moption	= "";
        $sub_moption	= "";

        if($param['moption1'] != ''){
            $query_moption1 = " \nand go.M_OPTION_1 = '".$param['moption1']."'	";
            $group_moption	= "group by go.M_OPTION_2";
            $sub_moption	= 'M_OPTION_1';
            $subquery_moption1 = " \nand M_OPTION_1 = '".$param['moption1']."'	";
        }
        if($param['moption2'] != ''){
            $query_moption2 = "	\nand go.M_OPTION_2 = '".$param['moption2']."'	";
            $group_moption	= "group by go.M_OPTION_3";
            $sub_moption	= 'M_OPTION_2';
            $subquery_moption2 = "	\nand M_OPTION_2 = '".$param['moption2']."'	";
        }
        if($param['moption3'] != ''){
            $query_moption3 = "	\nand go.M_OPTION_3 = '".$param['moption3']."'	";
            $group_moption	= "group by go.M_OPTION_4";
            $sub_moption	= 'M_OPTION_3';
            $subquery_moption3 = "	\nand M_OPTION_3 = '".$param['moption3']."'	";
        }
        if($param['moption4'] != ''){
            $query_moption4 = "	\nand go.M_OPTION_4 = '".$param['moption4']."'	";
            $group_moption	= "group by go.M_OPTION_5";
            $sub_moption	= 'M_OPTION_4';
            $subquery_moption4 = "	\nand M_OPTION_4 = '".$param['moption4']."'	";
        }
        if($param['moption5'] != ''){
            $query_moption5 = "	\nand M_OPTION_5 = '".$param['moption5']."'	";
            $group_moption	= "";
            $subquery_moption5 = "	\nand M_OPTION_5 = '".$param['moption5']."'	";
        }

        $query = "
			select      /*  > etah_front > goods_m > get_goods_moption_info > 선택한 멀티옵션들의 옵션 정보 */
				  go.GOODS_OPTION_CD
				, go.GOODS_CD
				, go.GOODS_OPTION_NM
				, go.M_OPTION_1
				, go.M_OPTION_2
				, go.M_OPTION_3
				, go.M_OPTION_4
				, go.M_OPTION_5
				, ifnull(go.QTY, 0)				as QTY
				, ifnull(gop.GOODS_OPTION_ADD_PRICE, 0)		as GOODS_OPTION_ADD_PRICE
				, case	when	M_OPTION_5 != '' then	'M_OPTION_5'
						when 	M_OPTION_4 != '' then	'M_OPTION_4'
						when	M_OPTION_3 != '' then	'M_OPTION_3'
						when	M_OPTION_2 != '' then	'M_OPTION_2'
						when	M_OPTION_1 != '' then	'M_OPTION_1'
				  end							as MOPTION_RESULT
				,(	SELECT	max(QTY)
					FROM	DAT_GOODS_OPTION
					WHERE
						1 = 1
					AND GOODS_CD	= '".$param['goods_code']."'
					AND USE_YN		= 'Y'
					$subquery_moption1
					$subquery_moption2
					$subquery_moption3
					$subquery_moption4
					$subquery_moption5
					GROUP BY
						$sub_moption
				  )		as SUB_QTY
			from
				DAT_GOODS_OPTION			go
			left join
				DAT_GOODS_OPTION_PRICE		gop
			on gop.GOODS_OPTION_PRICE_NO	= go.GOODS_OPTION_PRICE_NO
			and gop.USE_YN = 'Y'

			where
				1 = 1
			and go.GOODS_CD		= '".$param['goods_code']."'
			and go.USE_YN 		= 'Y'
			$query_moption1
			$query_moption2
			$query_moption3
			$query_moption4
			$query_moption5
			$group_moption
		";
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }



    /**
     * 상품 구매가이드 정보
     */
    public function get_goods_guide_info_org($goods_code, $gb)
    {
        $goods_join	= "";
        $category_join	= "";
        $brand_join	= "";

        if($gb == 'GOODS')	{ //상품구매가이드일 경우
            $goods_join	= "		inner join
										MAP_BUY_GUIDE_N_GOODS		map_g
									on	map_g.GOODS_CD		= g.GOODS_CD
									and map_g.USE_YN		= 'Y'

									inner join
										DAT_BUY_GUIDE				guide
									on	guide.BUY_GUIDE_NO	= map_g.BUY_GUIDE_NO
									and guide.USE_YN		= 'Y'
								";
        } else if($gb == 'CATEGORY'){	//카테고리 가이드일 경우
            $category_join	= "		inner join
										MAP_BUY_GUIDE_N_CATEGORY	map_c
									on	map_c.CATEGORY_CD		= g.CATEGORY_MNG_CD
									and map_c.USE_YN		= 'Y'

									inner join
										DAT_BUY_GUIDE				guide
									on	guide.BUY_GUIDE_NO	= map_c.BUY_GUIDE_NO
									and guide.USE_YN		= 'Y'
								";
        } else if($gb == 'BRAND'){	//브랜드 가이드일 경우
            $brand_join	= "		inner join
										MAP_BUY_GUIDE_N_BRAND		map_b
									on	map_b.BRAND_CD		= g.BRAND_CD
									and map_b.USE_YN		= 'Y'

									inner join
										DAT_BUY_GUIDE				guide
									on	guide.BUY_GUIDE_NO	= map_b.BUY_GUIDE_NO
									and guide.USE_YN		= 'Y'
								";
        }

        $query = "
			select		/* > etah_front > goods_m > get_goods_guide_info_org > ETAH 상품의 구매가이드 정보 구하기 */
				  guide.BUY_GUIDE_NO
				, guide.TITLE
				, guide_b.DISP_SORT
				, guide_b.BUY_GUIDE_BLOG_GB_CD
				, guide_b.HEADER_DESC
			from
				DAT_GOODS				g

			$goods_join
			$category_join
			$brand_join

			inner join
				DAT_BUY_GUIDE_BLOG		guide_b
			on	guide_b.BUY_GUIDE_NO	= guide.BUY_GUIDE_NO
			and guide_b.USE_YN			= 'Y'

			where
				1 = 1
			and g.GOODS_CD = '".$goods_code."'

			order by
				guide_b.DISP_SORT
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 구매가이드 정보
     */
    public function get_goods_guide_info($goods_code)
    {
        $query = "
			select		/* > etah_front > goods_m > get_goods_guide_info > ETAH 상품의 구매가이드 정보 구하기 */
				  t.BUY_GUIDE_NO
				, t.TITLE
				, t.DISP_SORT
				, t.BUY_GUIDE_BLOG_GB_CD
				, t.HEADER_DESC
				, t.gubun
			from
				(
					(select		
							  guide.BUY_GUIDE_NO
							, guide.TITLE
							, guide_b.DISP_SORT
							, guide_b.BUY_GUIDE_BLOG_GB_CD
							, guide_b.HEADER_DESC
							, 'GOODS_GUIDE'			as gubun
						from
							DAT_GOODS				g

						inner join
								MAP_BUY_GUIDE_N_GOODS		map_g
							on	map_g.GOODS_CD		= g.GOODS_CD
							and map_g.USE_YN		= 'Y'

							inner join
								DAT_BUY_GUIDE				guide
							on	guide.BUY_GUIDE_NO	= map_g.BUY_GUIDE_NO
							and guide.USE_YN		= 'Y'

						inner join
							DAT_BUY_GUIDE_BLOG		guide_b
						on	guide_b.BUY_GUIDE_NO	= guide.BUY_GUIDE_NO
						and guide_b.USE_YN			= 'Y'

						where
							1 = 1
						and g.GOODS_CD = '".$goods_code."'

						order by
							guide_b.DISP_SORT
					)
					union all
					(
						select		/* > etah_front > goods_m > get_goods_guide_info > ETAH 상품의 구매가이드 정보 구하기 */
							  guide.BUY_GUIDE_NO
							, guide.TITLE
							, guide_b.DISP_SORT
							, guide_b.BUY_GUIDE_BLOG_GB_CD
							, guide_b.HEADER_DESC
							, 'CATEGORY_GUIDE'		as guide
						from
							DAT_GOODS				g

						inner join
							MAP_BUY_GUIDE_N_CATEGORY	map_c
						on	map_c.CATEGORY_CD		= g.CATEGORY_MNG_CD
						and map_c.USE_YN		= 'Y'

						inner join
							DAT_BUY_GUIDE				guide
						on	guide.BUY_GUIDE_NO	= map_c.BUY_GUIDE_NO
						and guide.USE_YN		= 'Y'

						inner join
							DAT_BUY_GUIDE_BLOG		guide_b
						on	guide_b.BUY_GUIDE_NO	= guide.BUY_GUIDE_NO
						and guide_b.USE_YN			= 'Y'

						where
							1 = 1
						and g.GOODS_CD = '".$goods_code."'

						order by
							guide_b.DISP_SORT
					)
					union all
					(
						select		/* > etah_front > goods_m > get_goods_guide_info > ETAH 상품의 구매가이드 정보 구하기 */
							  guide.BUY_GUIDE_NO
							, guide.TITLE
							, guide_b.DISP_SORT
							, guide_b.BUY_GUIDE_BLOG_GB_CD
							, guide_b.HEADER_DESC
							, 'BRAND_GUIDE'			as gubun
						from
							DAT_GOODS				g

						inner join
							MAP_BUY_GUIDE_N_BRAND		map_b
						on	map_b.BRAND_CD		= g.BRAND_CD
						and map_b.USE_YN		= 'Y'

						inner join
							DAT_BUY_GUIDE				guide
						on	guide.BUY_GUIDE_NO	= map_b.BUY_GUIDE_NO
						and guide.USE_YN		= 'Y'

						inner join
							DAT_BUY_GUIDE_BLOG		guide_b
						on	guide_b.BUY_GUIDE_NO	= guide.BUY_GUIDE_NO
						and guide_b.USE_YN			= 'Y'

						where
							1 = 1
						and g.GOODS_CD = '".$goods_code."'

						order by
							guide_b.DISP_SORT
					)
				)	t

		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 상품 추가 배송비 정보
     */
    public function get_goods_add_deli($param)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_add_deli > ETAH 상품의 추가 배송비 정보 구하기 */
				  g.GOODS_CD
				, g.GOODS_NM
				, g.DELIV_POLICY_NO
				, adc.DELIV_POLICY_ADD_DELIV_COST_NO
				, adc.ADD_DELIV_COST
				, da.DELIV_AREA_CD
				, da.DELIV_AREA_NM
			from
				DAT_GOODS		g

			left join
				DAT_DELIV_POLICY_ADD_DELIV_COST		adc
			on	adc.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and adc.USE_YN			= 'Y'

			left join
				DAT_DELIV_AREA		da
			on	da.DELIV_AREA_CD	= adc.DELIV_AREA_CD
			and da.USE_YN			= 'Y'

			where
				1 = 1
			and g.USE_YN	= 'Y'
			and g.GOODS_CD	= '".$param['goods_code']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품 배송 불가 지역 정보
     */
    public function get_goods_no_deli($param)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_no_deli > ETAH 상품의 배송 불가지역 정보 구하기 */
				  g.GOODS_CD
				, g.GOODS_NM
				, g.DELIV_POLICY_NO
				, nodeliv.DELIV_POLICY_NO_DELIV_NO
				, da.DELIV_AREA_CD
				, da.DELIV_AREA_NM
			from
				DAT_GOODS		g

			left join
				DAT_DELIV_POLICY_NO_DELIV			nodeliv
			on	nodeliv.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and nodeliv.USE_YN			= 'Y'

			left join
				DAT_DELIV_AREA		da
			on	da.DELIV_AREA_CD	= nodeliv.DELIV_AREA_CD
			and da.USE_YN			= 'Y'

			where
				1 = 1
			and g.USE_YN	= 'Y'
			and g.GOODS_CD	= '".$param['goods_code']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품평 정보
     */
    public function get_goods_comment($code, $page, $limit)
    {
        if($page == 0){
            $query_limit = "";
        } else {
            $startPos = $limit * ($page - 1);
            $query_limit = "limit $startPos, $limit	";
        }

        $query_from = "";
        $query_where = "";

        //상품페이지
        if(is_numeric($code)) {
//            $query_where = "and gc.GOODS_CD = '".$code."'";
            $pre_query = "
                SELECT    /*  > etah_front > goods_m > get_goods_comment > 상품평 상품연동 내역 조회 */
                GROUP_CONCAT(C.MAP_GOODS_CD SEPARATOR ',') AS SEARCH_CD
                FROM MAP_GOODS_N_COMMENT C 
                WHERE C.GOODS_CD = '".$code."'
                AND C.USE_YN = 'Y'
		     ";

            $db = self::_slave_db();
            $pre_result =  $db->query($pre_query)->row_array();

            if( $pre_result['SEARCH_CD'] != '' ) {
                $target_cd = $code.','.$pre_result['SEARCH_CD'];
            } else {
                $target_cd = $code;
            }

            $query_where = "and gc.GOODS_CD in ( ".$target_cd." )";
        }
        //브랜드페이지
        else {
            $query_from = "left join DAT_GOODS g on gc.GOODS_CD = g.GOODS_CD left join DAT_BRAND b on g.BRAND_CD = b.BRAND_CD";
            $query_where = "and b.BRAND_CD = '".$code."'";
        }

        $query = "
			select      /*  > etah_front > goods_m > get_goods_comment > 상품평 정보 조회 */
				  gc.CUST_GOODS_COMMENT
				, gc.GOODS_CD
				, gc.CUST_NO
				, ifnull(concat(left(gc.WRITER_ID,3),'****'), concat(left(c.CUST_ID,3),'****'))	as CUST_ID
				, gc.`CONTENTS`
				, ifnull(r.GOODS_OPTION_NM, o.GOODS_OPTION_NM) as GOODS_OPTION_NM
				, gc.GRADE_VAL
				, substring(gc.GRADE_VAL,1,1)		as GRADE_VAL01
				, substring(gc.GRADE_VAL,2,1)		as GRADE_VAL02
				, substring(gc.GRADE_VAL,3,1)		as GRADE_VAL03
				, substring(gc.GRADE_VAL,4,1)		as GRADE_VAL04
				, if((length(gc.GRADE_VAL)= 1), gc.GRADE_VAL, ((substring(gc.GRADE_VAL,1,1) + substring(gc.GRADE_VAL,2,1) + substring(gc.GRADE_VAL,3,1) + substring(gc.GRADE_VAL,4,1))/4))		as TOTAL_GRADE_VAL
				, left(gc.CUST_GOODS_COMMENT_REG_DT,10)		as CUST_GOODS_COMMENT_REG_DT
			from
				DAT_CUST_GOODS_COMMENT		gc
				
			left join
				DAT_CUST		c
			on c.CUST_NO	= gc.CUST_NO
			
			left join
				DAT_ORDER_REFER r
			on gc.ORDER_REFER_NO = r.ORDER_REFER_NO
			
			left join 
				DAT_GOODS_OPTION o
			on gc.GOODS_OPTION_CD = o.GOODS_OPTION_CD
		  
			
            $query_from
            
			where
				1 = 1
			and gc.USE_YN	= 'Y'
			$query_where

            group by 
                gc.CUST_GOODS_COMMENT
                
			order by
				gc.CUST_GOODS_COMMENT_REG_DT	desc

			$query_limit
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 상품평 정보 갯수
     */
    public function get_goods_comment_cnt($code)
    {
        $query_where = "";
        $query_from = "";
        //상품페이지
        if(is_numeric($code)) {
//            $query_where = "and gc.GOODS_CD = '".$code."'";
            $pre_query = "
                SELECT    /*  > etah_front > goods_m > get_goods_comment_cnt > 상품평 상품연동 내역 조회 */
                GROUP_CONCAT(C.MAP_GOODS_CD SEPARATOR ',') AS SEARCH_CD
                FROM MAP_GOODS_N_COMMENT C 
                WHERE C.GOODS_CD = '".$code."'
                AND C.USE_YN = 'Y'
		     ";

            $db = self::_slave_db();
            $pre_result =  $db->query($pre_query)->row_array();

            if( $pre_result['SEARCH_CD'] != '' ) {
                $target_cd = $code.','.$pre_result['SEARCH_CD'];
            } else {
                $target_cd = $code;
            }

            $query_where = "and gc.GOODS_CD in ( ".$target_cd." )";
        }
        //브랜드페이지
        else {
            $query_from = "left join DAT_GOODS g on gc.GOODS_CD = g.GOODS_CD left join DAT_BRAND b on g.BRAND_CD = b.BRAND_CD";
            $query_where = "and b.BRAND_CD = '".$code."'";
        }

        $query = "
			select    /*  > etah_front > goods_m > get_goods_comment_cnt > 상품평 정보 조회 (count) */
				count(CUST_GOODS_COMMENT)		as cnt
			from
				DAT_CUST_GOODS_COMMENT		gc
			    $query_from
			where
				1 = 1
			and gc.USE_YN	= 'Y'
			$query_where
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 상품 문의 정보
     */
    public function get_goods_qna($goods_code, $page, $limit)
    {
        $startPos = $limit * ($page - 1);

        $query = "
			select		/*  > etah_front > goods_m > get_goods_qna > ETAH 상품의 문의 정보 */
				  c.CS_NO
				, if(c.CS_QUE_TYPE_CD = 'GOODS', '상품', '배송')	as CS_QUE_TYPE_CD
				, c.QUE_CUST_NM
				, cr.TITLE							as Q_TITLE
				, cr.`CONTENTS`						as Q_CONTENTS
				, cr2.`CONTENTS`					as A_CONTENTS
				, if(cr2.CS_NO is null, '답변대기', '답변완료')	as ANSWER_YN
				, cu.CUST_ID						as REAL_ID
				, concat(left(cu.CUST_ID,3),'****')	as CUST_ID
				, c.SECRET_YN
				, left(cr.REG_DT,10)				as REG_DT
			from
				DAT_CS		 c

			inner join
				DAT_CS_CONTENTS_REPLY		cr
			on cr.CS_NO	= c.CS_NO
			and cr.KIND = 'Q'

			left join
				DAT_CS_CONTENTS_REPLY		cr2
			on cr2.CS_NO	= c.CS_NO
			and cr2.KIND = 'A'

			inner join
				MAP_CS_N_GOODS				mc
			on mc.CS_NO	= c.CS_NO

			inner join
				DAT_CUST					cu
			on cu.CUST_NO = c.CUST_NO

			where
				1 = 1
			and mc.GOODS_CD = '".$goods_code."'

			order by
				c.CS_NO	desc

			limit ".$startPos.", ".$limit."
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /* 상품 문의 정보 갯수 */
    public function get_goods_qna_cnt($goods_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > get_goods_qna_cnt > ETAH 상품의 문의 정보 갯수 */
				  count(c.CS_NO)		as cnt
			from
				DAT_CS		 c

			inner join
				DAT_CS_CONTENTS_REPLY		cr
			on cr.CS_NO	= c.CS_NO
			and cr.KIND = 'Q'

			left join
				DAT_CS_CONTENTS_REPLY		cr2
			on cr2.CS_NO	= c.CS_NO
			and cr2.KIND = 'A'

			inner join
				MAP_CS_N_GOODS				mc
			on mc.CS_NO	= c.CS_NO

			inner join
				DAT_CUST					cu
			on cu.CUST_NO = c.CUST_NO

			where
				1 = 1
			and mc.GOODS_CD = '".$goods_code."'

			order by
				c.CS_NO	desc

		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 카테고리별 브랜드 상품 개수
     */
    public function get_brand_goods_count($param)
    {
        $str_brand_cd			= "";
        $query_category			= "";
        $query_category_attr	= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
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
					on	mc.CATEGORY_DISP_CD				= ma.CATEGORY_DISP_CD
					and ma.USE_YN						= 'Y'
					and ma.GOODS_CLASSIFICATION_ATTR_CD	in ('".$str_attr_cd."')
				inner join	MAP_CLASS_ATTR_N_GOODS 		mag
					on 	mc.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO
			";
        }


        $query = "
			select	/*  > etah_front > goods_m > get_brand_goods_count > ETAH 브랜드 상품개수 구하기 */
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
								$query_category_attr
								where	mc.USE_YN					= 'Y'
								$query_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD
				where
					1 = 1
			--	and	b.WEB_DISP_YN = 'Y'
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
//		var_dump($query);
//		log_message('debug', '============================ get_brand_goods_count : '.$query);

        return $db->query($query)->result_array();
    }

    /**
     * 카테고리별 지역 상품 개수 (공방클래스)
     */
    public function get_map_goods_count($param)
    {
        $query_category			= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 지역 체크 */
        if($param['map_nm']){
            $str_map_nm = str_replace('|',"','", $param['map_nm']);
            $str_map_nm = substr($str_map_nm, 3);
        }

        $query = "
            select      /*  > etah_front > goods_m > get_map_goods_count > ETAH 지역 상품개수 구하기(공방클래스) */
                    cg.ADDRESS		                    as MAP
                    , count(distinct g.GOODS_CD)		as MAP_CNT
                    , ifnull(cg2.ADDRESS,'N')	        as FLAG_YN
            from 
                    MAP_CLASS_GOODS     cg
                    inner join DAT_GOODS                      g
                        on cg.GOODS_CD                         = g.GOODS_CD
                        and g.WEB_DISP_YN                      = 'Y'
                    inner join DAT_GOODS_PROGRESS             gp
                        on cg.GOODS_CD                         = gp.GOODS_CD
                        and g.GOODS_PROGRESS_NO                = gp.GOODS_PROGRESS_NO
                        and gp.GOODS_STS_CD                    = '03'
                    inner join MAP_CATEGORY_DISP_N_GOODS      mc
                        on mc.GOODS_CD                         = cg.GOODS_CD
                        and mc.USE_YN                          = 'Y'
                    inner join DAT_CATEGORY_DISP              c
                        on mc.CATEGORY_DISP_CD                 = c.CATEGORY_DISP_CD
                        and c.USE_YN                           = 'Y'
                        $query_category
                    left join MAP_CLASS_GOODS                 cg2
                        on cg.CLASS_GOODS_NO                   = cg2.CLASS_GOODS_NO
                        and cg2.ADDRESS                        in ('".$str_map_nm."')
            group by
                    cg.ADDRESS
		";
        $db = self::_slave_db();
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
        $query_country          = "";
        $query_order_by			= "";
        $query_out_order_by		= "";
        $query_sort_table		= "";
        $query_category_attr	= "";
        $query_deli_policy		= "";
        $query_free_delivery    = "";
        $query_goods_cd         = "";
        $query_onlyOverSeaQuery = "";
//var_dump($param);
        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

        /* 상품코드 - 직구SHOP 메인 */
        if($param['goods_cd']){
            $query_goods_cd = "and g.VENDOR_GOODS_CD in (".$param['goods_cd'].")";
        }

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){		//소분류
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){	//중분류
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";

                if($param['arr_cate']){
                    $str_cate_cd = str_replace('|',"','", $param['arr_cate']);
                    if(strpos($str_cate_cd, ',')) $str_cate_cd = substr($str_cate_cd, 3);
                    $query_mid_category = "and c.CATEGORY_DISP_CD in ('".$str_cate_cd."')";
                }
            }else if($param['cate_gb'] == 'L'){ //대분류
                $query_category = "and c3.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 금액제한 */
        if($param['price_limit']){
            $arr_price_limit = explode("|", $param['price_limit']);

            if( $arr_price_limit[1]=='' ) {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."'";
            } else {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."' and pri.SELLING_PRICE <= '".$arr_price_limit[1]."'";
            }
        }

        /* 국가 체크 */
        if($param['country']) {
            $country_list = "";
            $arr_country = explode("|", substr($param['country'],1));

            if( in_array("KR", $arr_country) ) {
                if( count($arr_country)>1 ) {
                    foreach($arr_country as $cntry){
                        if($cntry != 'KR') {
                            $country_list .= ", '".$cntry."'";
                        }
                    }
                    $query_country = "and ( (cnc.COUNTRY_CD is null) or (cnc.COUNTRY_CD in (".substr($country_list,2).")) )";
                } else {
                    $query_country = "and cnc.COUNTRY_CD is null";
                }
            } else {
                $query_country = "and cnc.COUNTRY_CD in ('".str_replace("|", "','", substr($param['country'],1))."')";
            }
        }

        /* 무료배송 체크 */
        if($param['deliv_type']) {
            $query_free_delivery = "and dp.PATTERN_TYPE_CD = 'FREE'";
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            if(strpos($str_brand_cd, ',')) $str_brand_cd = substr($str_brand_cd, 3);
            $query_brand = "and b.BRAND_CD in ('".$str_brand_cd."')";

        }

        /* 지역 체크 (공방클래스) */
        if($param['map_nm']){
            $str_map_nm = str_replace('|',"','", $param['map_nm']);
            if(strpos($str_map_nm, ',')) $str_map_nm = substr($str_map_nm, 3);
            $query_map = "and cg.ADDRESS in ('".$str_map_nm."')";
        }

        /* 묶음배송정책 체크 */
        if($param['deli_policy_no']){
            $query_deli_policy = "and g.DELIV_POLICY_NO = '".$param['deli_policy_no']."'	";
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
					on 	mc.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO
			";
        }

        /* 정렬 */
        if($param['order_by']){
            switch($param['order_by']){
                case 'A' :	//신상품순
                    $query_order_by = "order by g.GOODS_CD desc";
                    $query_out_order_by = "order by t.GOODS_CD desc"; break;
                case 'B' :	//인기순
                    $query_order_by = "order by eg.GOODS_PRIORITY is null asc, sort.GOODS_SORT_SCORE desc, g.GOODS_CD desc";
                    $query_out_order_by = "order by t.GOODS_PRIORITY IS NULL ASC, t.GOODS_SORT_SCORE desc, t.GOODS_CD desc"; break;
                case 'C' :	//낮은가격순
                    $query_order_by = "order by pri.SELLING_PRICE asc, g.GOODS_CD desc";
                    $query_out_order_by ="order by COUPON_PRICE asc, t.GOODS_CD desc"; break;
                case 'D' :	//높은가격순
                    $query_order_by = "order by pri.SELLING_PRICE desc, g.GOODS_CD desc";
                    $query_out_order_by ="order by COUPON_PRICE desc, t.GOODS_CD desc"; break;
            }
        }

        /* 오직 직구샵에만 노출 2020-04-23 김설 팀장 요청 */
        if ( substr($param['cate_cd'], 0, 2) != '20' && !empty($param['cate_cd'])) {
            $query_onlyOverSeaQuery = 'where t.VENDOR_SUBVENDOR_CD not in (SELECT nope.VENDOR_SUBVENDOR_CD FROM DAT_VENDOR_SUBVENDOR nope WHERE nope.VENDOR_CD IN (96, 236))';
        }


        $query = "

			select /*  > etah_front > goods_m > get_goods_list > ETAH 상품리스트 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.CATEGORY_CD1
				, t.CATEGORY_NM1
				, t.CATEGORY_CD2
				, t.CATEGORY_NM2
				, t.CATEGORY_CD3
				, t.CATEGORY_NM3
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
				, round( if(floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))	/10)*10	as RATE_PRICE_S
				, round( if(floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))	/10)*10	as RATE_PRICE_G     /*2020-05-18 RATE만 반올림 처리 */ 
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
                
                , t.COUNTRY_CD
                , t.COUNTRY_NM
			from
			(
				select
					g.GOODS_CD
				--	, g.GOODS_NM
                    , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
					, c3.CATEGORY_DISP_CD as CATEGORY_CD1
					, c3.CATEGORY_DISP_NM as CATEGORY_NM1
					, c2.CATEGORY_DISP_CD as CATEGORY_CD2
					, c2.CATEGORY_DISP_NM as CATEGORY_NM2
					, c.CATEGORY_DISP_CD  as CATEGORY_CD3
					, c.CATEGORY_DISP_NM  as CATEGORY_NM3
					, g.PROMOTION_PHRASE
					, g.BRAND_CD
					, g.GOODS_MILEAGE_N_GOODS_NO
					, g.DELIV_POLICY_NO
					, g.VENDOR_SUBVENDOR_CD
					, b.BRAND_NM
					, pri.SELLING_PRICE
					, sort.GOODS_SORT_SCORE
                    , count(ig.INTEREST_GOODS_NO)     as INTEREST_CNT
                    , cg.ADDRESS
                    , if(c.PARENT_CATEGORY_DISP_CD='24010000', 'C', if(c.PARENT_CATEGORY_DISP_CD='24020000', 'G', ''))  as CLASS_GUBUN
                    , if(cg.CLASS_TYPE='ONE', '원데이', if(cg.CLASS_TYPE='MANY', '다회차', '공방상품'))                   as CLASS_TYPE
                    , eg.GOODS_PRIORITY
                    , if(eg.PLAN_EVENT_REFER_CD, 'DEAL', '')	as DEAL
                    , IFNULL(cnc.COUNTRY_CD, 'KR')          AS COUNTRY_CD
                    , IFNULL(cntry.COUNTRY_KO_NM, '한국')	AS COUNTRY_NM

				from
					DAT_GOODS 				g
                left join DAT_GOODS_MD_MOD            gmm
                    on g.GOODS_CD                       = gmm.GOODS_CD
                    and gmm.USE_YN                      = 'Y'
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
					/*
				inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
								$query_category_attr
								where	mc.USE_YN					= 'Y'
								$query_category
								$query_mid_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD
				*/
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
                    
                $query_category_attr
            
				
				left join	DAT_GOODS_SORT_SCORE	sort
					on	g.GOODS_CD		= sort.GOODS_CD
                left join DAT_INTEREST_GOODS       ig
				    on g.GOODS_CD       = ig.GOODS_CD
				left join MAP_CLASS_GOODS          cg
				    on g.GOODS_CD       = cg.GOODS_CD
                left join DAT_PLAN_EVENT_GOODS      eg
                    on g.GOODS_CD              = eg.GOODS_CD
                    and eg.PLAN_EVENT_CODE    in (586,587)
                INNER JOIN DAT_VENDOR_SUBVENDOR suv
                    ON suv.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
                INNER JOIN DAT_VENDOR v
                    ON v.VENDOR_CD = suv.VENDOR_CD
                LEFT JOIN MAP_COMPANY_N_COUNTRY cnc
                    ON v.COMPANY_CD = cnc.COMPANY_CD
                LEFT JOIN DAT_COUNTRY cntry
                    ON cntry.COUNTRY_CD = cnc.COUNTRY_CD
                    
                inner join	DAT_DELIV_POLICY				dp
                    on	dp.DELIV_POLICY_NO					= g.DELIV_POLICY_NO
                    and dp.USE_YN							= 'Y'
                    
				$query_sort_table

				where
					1 = 1
				and g.WEB_DISP_YN = 'Y'
				$query_brand
				$query_deli_policy
				$query_price_limit
				$query_country
				$query_map
				$query_category
				$query_free_delivery
				$query_goods_cd
				
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
				
			$query_onlyOverSeaQuery

			group by
				t.GOODS_CD
			$query_out_order_by


		";

//        var_dump($query);

        $db = self::_slave_db();

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
        $query_category_attr	= "";
        $query_mid_category		= "";
        $query_deli_policy		= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){		//소분류
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){	//중분류
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";

                if($param['arr_cate']){
                    $str_cate_cd = str_replace('|',"','", $param['arr_cate']);
                    if(strpos($str_cate_cd, ',')) $str_cate_cd = substr($str_cate_cd, 3);
                    $query_mid_category = "and c.CATEGORY_DISP_CD in ('".$str_cate_cd."')";
                }
            }else if($param['cate_gb'] == 'L'){ //대분류
                $query_category = "and c3.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 금액제한 */
        if($param['price_limit']){
            $arr_price_limit = explode("|", $param['price_limit']);

            if( $arr_price_limit[1]=='' ) {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."'";
            } else {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."' and pri.SELLING_PRICE <= '".$arr_price_limit[1]."'";
            }
        }

        /* 국가 체크 */
        if($param['country']) {
            $country_list = "";
            $arr_country = explode("|", substr($param['country'],1));

            if( in_array("KR", $arr_country) ) {
                if( count($arr_country)>1 ) {
                    foreach($arr_country as $cntry){
                        if($cntry != 'KR') {
                            $country_list .= ", ".$cntry;
                        }
                    }
                    $query_country = "and ( (cnc.COMPANY_CD is null) or (cnc.COMPANY_CD in (".substr($country_list,1).")) )";
                } else {
                    $query_country = "and cnc.COMPANY_CD is null";
                }
            } else {
                $query_country = "and cnc.COMPANY_CD in (".str_replace("|", ",", substr($param['country'],1)).")";
            }
        }

        /* 무료배송 체크 */
        if($param['deliv_type']) {
            $query_free_delivery = "and dp.PATTERN_TYPE_CD = 'FREE'";
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            if(strpos($str_brand_cd, ',')) $str_brand_cd = substr($str_brand_cd, 3);
            $query_brand = "and b.BRAND_CD in ('".$str_brand_cd."')";

        }

        /* 지역 체크 (공방클래스) */
        if($param['map_nm']){
            $str_map_nm = str_replace('|',"','", $param['map_nm']);
            if(strpos($str_map_nm, ',')) $str_map_nm = substr($str_map_nm, 3);
            $query_map = "and cg.ADDRESS in ('".$str_map_nm."')";
        }

        /* 묶음배송정책 체크 */
        if($param['deli_policy_no']){
            $query_deli_policy = "and g.DELIV_POLICY_NO = '".$param['deli_policy_no']."'	";
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
					on 	mc.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO

			";
        }

        $query = "
			select	/*  > etah_front > goods_m > get_goods_list_count > ETAH 상품리스트 개수 */
				count(distinct g.GOODS_CD)			as CNT
			from
				DAT_GOODS 				g
			inner join	DAT_BRAND 					b
				on	g.BRAND_CD 						= b.BRAND_CD
			--	and	b.WEB_DISP_YN					= 'Y'
		/*	inner join	MAP_CATEGORY_DISP_N_GOODS	m
				on	g.GOODS_CD						= m.GOODS_CD
			inner join	DAT_CATEGORY_DISP 			c
				on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
		*/
			inner join	DAT_GOODS_PRICE				pri
				on	g.GOODS_CD 						= pri.GOODS_CD
				and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_PROGRESS			gp
				on	g.GOODS_CD 						= gp.GOODS_CD
				and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
				and	gp.GOODS_STS_CD					= '03'
		/*	inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
								--	and	c.WEB_DISP_YN				= 'Y'
								$query_category_attr
								where	mc.USE_YN					= 'Y'
								$query_category
								$query_mid_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD
			*/
			  INNER JOIN MAP_CATEGORY_DISP_N_GOODS     mc
                    ON mc.GOODS_CD                      = g.GOODS_CD
                    and mc.USE_YN					    = 'Y'
              INNER JOIN  DAT_CATEGORY_DISP             c
                    on c.CATEGORY_DISP_CD               = mc.CATEGORY_DISP_CD
                    and	c.USE_YN 					    = 'Y'
                    $query_mid_category
                    
              left join MAP_CLASS_GOODS          cg
				    on g.GOODS_CD       = cg.GOODS_CD
              inner join	DAT_DELIV_POLICY				dp
                    on	dp.DELIV_POLICY_NO					= g.DELIV_POLICY_NO
                    and dp.USE_YN							= 'Y'
              INNER JOIN DAT_VENDOR_SUBVENDOR suv
                    ON suv.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
              INNER JOIN DAT_VENDOR v
                    ON v.VENDOR_CD = suv.VENDOR_CD
              LEFT JOIN MAP_COMPANY_N_COUNTRY cnc
                    ON v.COMPANY_CD = cnc.COMPANY_CD
              LEFT JOIN DAT_COUNTRY cntry
                    ON cntry.COUNTRY_CD = cnc.COUNTRY_CD
                    
              $query_category_attr

			where
				1 = 1
			and	g.WEB_DISP_YN = 'Y'
			$query_brand
			$query_deli_policy
			$query_price_limit
            $query_country
            $query_map
            $query_category
            $query_free_delivery

		";
        $db = self::_slave_db();
//		var_dump($query);
//		log_message('debug', '============================ get_goods_list_count : '.$query);
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
			select	/*  > etah_front > goods_m > get_category_list_by_search > ETAH 검색결과 카테고리 구하기 */
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
			select	/*  > etah_front > goods_m > get_brand_detail > ETAH 브랜드 정보 구하기 */
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
				, b.TITLE_BG_IMG_URL
				, b.BANNER_IMG_URL
				, b.BANNER_LINK
				, b.MAP_URL
                , b.VIDEO_TITLE_CD
                , b.VIDEO_URL
                , m.MAGAZINE_NO
			from
				DAT_BRAND	b
				left join DAT_MAGAZINE m 
						on b.BRAND_CD = m.BRAND_CD
						and m.USE_YN = 'Y'
			/*
				left join	MAP_COUPON_APPLICATION_SCOPE_OBJECT m
					on	m.COUPON_APPLICATION_SCOPE_OBJECT_CD 	= b.BRAND_CD
					and m.USE_YN								= 'Y'
				left join	DAT_COUPON 							c
					on 	c.COUPON_CD 							= m.COUPON_CD
					and c.USE_YN								= 'Y'
			*/

			where
				b.BRAND_CD		= '".$brand_cd."'
			and	b.WEB_DISP_YN	= 'Y'
			and	b.USE_YN		= 'Y'

		";
        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->row_array();
    }

    /**
     * 브랜드 갤러리 이미지 구하기
     */
    public function get_brand_gallery($brand_cd) {
        $query = "
                    SELECT    /*  > etah_front > goods_m > get_brand_gallery > 브랜드 갤러리 이미지 구하기 */
                            BG.IMG_URL
                    FROM
                            MAP_BRAND_IMAGE_GALLERY BG
                    WHERE
                            BG.BRAND_CD = '".$brand_cd."'
        ";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * BEST ITEM
     */
    public function get_best_item($category=null)
    {
        $query_category = "";

        if( !empty($category) ) {
            $query_category = "and cm2.PARENT_CATEGORY_MNG_CD = ".$category;
        }

        $query = "
			select 		/*  > etah_front > goods_m > get_best_item > ETAH BEST ITEM */
			t.GOODS_CD
			, t.GOODS_NM
			, t.PROMOTION_PHRASE
			, t.BRAND_NM
			, i.IMG_URL												as IMG_URL_E
		--	, if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
            , ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, i.IMG_URL))		as IMG_URL
			, pri.SELLING_PRICE
			, dp.DELIV_POLICY_NO
			, dp.PATTERN_TYPE_CD
			, max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
			, max(dpp.DELIV_COST)								as DELI_COST
		/*	, sum(if(cpn.MAX_DISCOUNT > 0,
				if(round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
				 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
				 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
			 )													as RATE_PRICE
			, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
			, max(cpn.COUPON_CD)								as COUPON_CD		*/
			, round ( if(floor(pri.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(pri.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))/10)*10		as RATE_PRICE_S
			, round ( if(floor(pri.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(pri.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))/10)*10		as RATE_PRICE_G /*기존 round 없었음 2020-05-18*/
			, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
			, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
			, cpn_s.COUPON_CD									as COUPON_CD_S
			, cpn_g.COUPON_CD									as COUPON_CD_G
			, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
			, t.CATEGORY_MNG_CD                                 as CATEGORY_CD
			, eg.PLAN_EVENT_REFER_CD		                    as DEAL   
			, t.TOP_CATE_CD                                     as TOP_CATE_CD
			, t.TOP_CATE_NM                                     as TOP_CATE_NM
			, if(left(t.CATEGORY_MNG_CD, 4)=2401, 'C', if(left(t.CATEGORY_MNG_CD, 4)=2402, 'G', ''))    as CLASS_GUBUN 
		from
		(
			select
				g.GOODS_CD
			--	, g.GOODS_NM
                , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
				, g.PROMOTION_PHRASE
				, g.GOODS_PRICE_CD
				, g.GOODS_MILEAGE_N_GOODS_NO
				, g.DELIV_POLICY_NO
				, b.BRAND_NM
				, sort.GOODS_SORT_SCORE
				, g.CATEGORY_MNG_CD
				, cm3.CATEGORY_MNG_CD       as TOP_CATE_CD
				, cm3.CATEGORY_NM           as TOP_CATE_NM
				, g.HITS
			from
				DAT_GOODS g
			left join DAT_GOODS_MD_MOD 			gmm
                on g.GOODS_CD 						= gmm.GOODS_CD
                and gmm.USE_YN 						= 'Y'	
				
			inner join	DAT_BRAND					b
				on	g.BRAND_CD						= b.BRAND_CD
			--	and b.WEB_DISP_YN					= 'Y'

			inner join	DAT_GOODS_PROGRESS 			gp
				on	g.GOODS_CD						= gp.GOODS_CD
				and g.GOODS_PROGRESS_NO				= gp.GOODS_PROGRESS_NO
				and	gp.GOODS_STS_CD					= '03'
			inner join	DAT_GOODS_SORT_SCORE		sort
				on	g.GOODS_CD 						= sort.GOODS_CD
				
            inner join DAT_CATEGORY_MNG            cm1
                on g.CATEGORY_MNG_CD                = cm1.CATEGORY_MNG_CD
            inner join DAT_CATEGORY_MNG            cm2
                on cm1.PARENT_CATEGORY_MNG_CD       = cm2.CATEGORY_MNG_CD
            inner join DAT_CATEGORY_MNG            cm3
                on cm2.PARENT_CATEGORY_MNG_CD       = cm3.CATEGORY_MNG_CD
                
			where
				g.USE_YN = 'Y'
			and	g.WEB_DISP_YN = 'Y'
			$query_category
	--		and sort.GOODS_SORT_SCORE != '9999999.999'	/* 2017-02-20 우선전시상품 BEST에서 제거 */
			order by
				sort.GOODS_SORT_SCORE desc, g.HITS desc ,g.GOODS_CD desc
			limit 100

			)		t
			inner join	DAT_GOODS_IMAGE					i
				on	t.GOODS_CD							= i.GOODS_CD
				and	i.TYPE_CD							= 'TITLE'
			left join	 DAT_GOODS_IMAGE_RESIZING 		gir
				on 	t.GOODS_CD							= gir.GOODS_CD
				and	gir.TYPE_CD							= '400'
            left join	DAT_GOODS_IMAGE_MD		        im
                on	t.GOODS_CD							= im.GOODS_CD
                and	im.TYPE_CD							= 'TITLE'
            left join	 DAT_GOODS_IMAGE_RESIZING_MD 	girm
                on 	t.GOODS_CD							= girm.GOODS_CD
                and	girm.TYPE_CD						= '400'
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

			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
				on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD
				

			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD
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
						--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
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
						--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD
*/
			group by t.GOODS_CD

			order by
				t.GOODS_SORT_SCORE desc, t.HITS desc, t.GOODS_CD desc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 기획전
     */
    public function get_plan_event($event_cd)
    {
        if($event_cd == 586 || $event_cd == 587 || $event_cd == 704 ) {  //에타딜 이벤트페이지, 에타홈 고객 특가 기획전(2020.09.11 김설팀장 요청)
            $query_order = "order by  ec.PLAN_EVENT_CATEGORY_CD, eg.GOODS_PRIORITY";
        }else {
            $query_order = "order by  ec.PLAN_EVENT_CATEGORY_CD, eg2.GOODS_PRIORITY is null ASC, eg2.GOODS_PRIORITY, eg.GOODS_PRIORITY";
        }

        $query = "
			select	/*  > etah_front > goods_m > get_plan_event > ETAH 기획전*/
					e.PLAN_EVENT_CD 
					, e.BRAND_CATEGORY_CD
					, e.TITLE
					, e.IMG_URL											as EVENT_IMG_URL
					, left(e.START_TIME,10)								as START_TIME
					, left(e.END_TIME,10)								as END_TIME
					, e.TIP
					, e.COUPON_CD										as EVENT_COUPON_CD
					, e.COUPON_IMG										as EVENT_COUPON_IMG
					, c.WEB_DISP_DC_COUPON_NM							as EVENT_COUPON_NM
					, c.ISSUE_COUPON_DESC
					, ec.PLAN_EVENT_CATEGORY_CD
					, ec.NAME
					, eg.GOODS_PRIORITY
					, g.GOODS_CD
				--	, g.GOODS_NM
                    , ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
					, b.BRAND_NM
				--	, i.IMG_URL
				--	, if(gir.IMG_URL is null, i.IMG_URL, gir.IMG_URL)		as IMG_URL
				    , if(right(im.IMG_URL, 3)='gif', im.IMG_URL, if(right(i.IMG_URL,3)='gif', i.IMG_URL, ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, i.IMG_URL))))   as IMG_URL
                --    , ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, i.IMG_URL))		as IMG_URL
					, dp.DELIV_POLICY_NO
					, dp.PATTERN_TYPE_CD
					, max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
					, max(dpp.DELIV_COST)								as DELI_COST
					, pri.SELLING_PRICE
				/*	, sum(if(cpn.MAX_DISCOUNT > 0,
						if(round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
						 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
						 round(pri.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
					 )													as RATE_PRICE
					, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE
					, max(cpn.COUPON_CD)								as COUPON_CD	*/
					, round( if(floor(pri.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(pri.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))/10) * 10		as RATE_PRICE_S
					, round( if(floor(pri.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(pri.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))/10) * 10		as RATE_PRICE_G
					, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
					, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
					, cpn_s.COUPON_CD									as COUPON_CD_S
					, cpn_g.COUPON_CD									as COUPON_CD_G
					, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
					, g.CATEGORY_MNG_CD								    as CATEGORY_CD
					, eg2.PLAN_EVENT_REFER_CD	                        as DEAL
                    , if(left(g.CATEGORY_MNG_CD, 4)=2401, 'C', (if(left(g.CATEGORY_MNG_CD, 4)=2402, 'G', '')))  as GONGBANG
			from 	DAT_PLAN_EVENT e

			inner join	DAT_PLAN_EVENT_CATEGORY 		ec
			on e.PLAN_EVENT_CD 							= ec.PLAN_EVENT_CODE

			inner join	DAT_PLAN_EVENT_GOODS 			eg
			on e.PLAN_EVENT_CD 							= eg.PLAN_EVENT_CODE
			and ec.PLAN_EVENT_CATEGORY_CD 				= eg.PLAN_EVENT_CATEGORY_CD
			
			left join	DAT_PLAN_EVENT_GOODS 			eg2
			on eg.GOODS_CD								= eg2.GOODS_CD
			and eg2.PLAN_EVENT_CODE                    in ( 586, 587 ) 

			inner join	DAT_GOODS						g
			on	eg.GOODS_CD								= g.GOODS_CD
			and	g.WEB_DISP_YN							= 'Y'
			
			left join DAT_GOODS_MD_MOD 				gmm
            on g.GOODS_CD 								= gmm.GOODS_CD
            and gmm.USE_YN 								= 'Y'

			inner join	DAT_BRAND						b
			on	g.BRAND_CD								= b.BRAND_CD
		--	and	b.WEB_DISP_YN							= 'Y'

			inner join	DAT_GOODS_PROGRESS 				p
			on	g.GOODS_CD								= p.GOODS_CD
			and g.GOODS_PROGRESS_NO						= p.GOODS_PROGRESS_NO
			and p.GOODS_STS_CD							= '03'

			inner join	DAT_GOODS_PRICE					pri
			on	g.GOODS_CD								= pri.GOODS_CD
			and g.GOODS_PRICE_CD						= pri.GOODS_PRICE_CD

			inner join	DAT_GOODS_IMAGE					i
				on	g.GOODS_CD							= i.GOODS_CD
				and	i.TYPE_CD							= 'TITLE'

			left join	 DAT_GOODS_IMAGE_RESIZING 		gir
				on 	g.GOODS_CD							= gir.GOODS_CD
				and	gir.TYPE_CD							= '400'
				
            left join	DAT_GOODS_IMAGE_MD		        im
                on	g.GOODS_CD							= im.GOODS_CD
                and	im.TYPE_CD							= 'TITLE'
                
            left join	 DAT_GOODS_IMAGE_RESIZING_MD 	girm
                on 	g.GOODS_CD							= girm.GOODS_CD
                and	girm.TYPE_CD						= '400'

			inner join	DAT_DELIV_POLICY				dp
				on	dp.DELIV_POLICY_NO					= g.DELIV_POLICY_NO
				and dp.USE_YN							= 'Y'
			left join	DAT_DELIV_POLICY_PATTERN		dpp
				on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO

			left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
				on	mileage.GOODS_MILEAGE_N_GOODS_NO	= g.GOODS_MILEAGE_N_GOODS_NO
				and mileage.USE_YN						= 'Y'
			left join	DAT_COUPON						c
				on c.COUPON_CD							= e.COUPON_CD
				and c.USE_YN							= 'Y'
				and	if(c.COUPON_START_DT is null,  1 = 1, c.COUPON_START_DT	<= now()	and c.COUPON_END_DT	>= now())

			
			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
				on	g.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD
				

			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
				on	g.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD

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
						--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

						--	inner join DAT_COUPON_PROGRESS cpp
						--		on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
						--		and cpp.COUPON_PROGRESS_STS_CD		= '03'
						--		and	cpp.USE_YN						= 'Y'
						) cpn_s
				on	g.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD

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
						--		and cpn.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn.COUPON_START_DT is null,  1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())

						--	inner join DAT_COUPON_PROGRESS cpp
						--		on	cpn.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
						--		and cpp.COUPON_PROGRESS_STS_CD		= '03'
						--		and	cpp.USE_YN						= 'Y'
						) cpn_g
				on	g.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD

*/
			where	e.USE_YN = 'Y'
			and		e.PLAN_EVENT_CD = ?

		--	group by eg.PLAN_EVENT_REFER_CD
            group by g.GOODS_CD, ec.NAME

			$query_order
		";

        $db = self::_slave_db();
        //var_dump($query);
        return $db->query($query, array($event_cd))->result_array();
    }

    /**
     * 쿠폰 정보 확인
     */
    public function coupon_info($coupon_code)
    {
        $query = "
			select		/*  > etah_front > goods_m > coupon_info > 쿠폰 정보 확인 */
				  c.COUPON_CD
				, c.DC_COUPON_NM
				, c.BUYER_MAX_DOWN_QTY
				, c.DAY_ISSUE_LIMIT_QTY
				, c.USE_YN
				, c.REG_DT
			from
				DAT_COUPON		c
			where
				c.COUPON_CD = '".$coupon_code."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }


    /**
     * 기획전 쿠폰이 이미 발급받은 쿠폰인지 확인
     */
    public function event_coupon_check($coupon_code, $use_yn, $date)
    {
        $query_date = '';

        if($date != ''){
            $query_date = "and date_format(cc.REG_DT,'%Y-%m-%d') = '".$date."'	";
        }

        $query = "
			select		/*  > etah_front > goods_m > event_coupon_check > 기획전 쿠폰이 이미 발급받은 쿠폰인지 확인 */
				  CUST_COUPON_NO
				, CUST_NO
				, COUPON_CD
				, USE_YN
				, REG_DT
			from
				DAT_CUST_COUPON		cc
			where
				1 = 1
			and cc.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
			and cc.COUPON_CD	= '".$coupon_code."'
			and cc.USE_YN		= '".$use_yn."'
			$query_date

			order by
				cc.CUST_COUPON_NO	desc
		";
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 기획전 쿠폰 발급
     */
    public function bring_event_coupon($coupon_code)
    {
        $query = "
			insert into	DAT_CUST_COUPON     /*  > etah_front > goods_m > bring_event_coupon > 기획전 쿠폰 발급 */
			(
				  CUST_NO
				, COUPON_CD
				, COUPON_GET_CD
			)
			values
			(
				  '".$this->session->userdata('EMS_U_NO_')."'
				, '".$coupon_code."'
				, '04'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 브랜드 카테고리별 상품 개수 구하기
     * 2018.03.22 @auth 박상현
     */
    public function get_brand_list_count($param,$total_cnt,$group_key){
        $query_brand			= "";

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            if(strpos($str_brand_cd, ',')) $str_brand_cd = substr($str_brand_cd, 3);
            $query_brand = "and b.BRAND_CD in ('".$str_brand_cd."')";

        }
        if($group_key == 1){
            $query_group = "GRAND_CATE_CD";
        }else if($group_key == 2){
            $query_group = "t.CATEGORY_DISP_CD";
        }else{
            $query_group = "t.PARENT_CATEGORY_DISP_CD";
        }


        $query = "
			select /*  > etah_front > goods_m > get_brand_list_count > ETAH 브랜드 카테고리별 상품개수 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.BRAND_CD
				, t.BRAND_NM
				, t.CATEGORY_DISP_CD
				, t.CATEGORY_DISP_NM
				, t.PARENT_CATEGORY_DISP_CD
				, count(t.CATEGORY_DISP_CD) as cnt
				,(select a.PARENT_CATEGORY_DISP_CD
		
		      		from DAT_CATEGORY_DISP a
		
		      		where
			  				1=1
		      		and a.CATEGORY_DISP_CD = t.PARENT_CATEGORY_DISP_CD) as GRAND_CATE_CD
		      		
		        ,(select a.CATEGORY_DISP_NM
		
		      		from DAT_CATEGORY_DISP a
		
		      		where
			  				1=1
		      		and a.CATEGORY_DISP_CD = GRAND_CATE_CD) as GRAND_CATE_NM
		        ,(select a.CATEGORY_DISP_NM
		
		      		from DAT_CATEGORY_DISP a
		
		      		where
			  				1=1
		      		and a.CATEGORY_DISP_CD = t.PARENT_CATEGORY_DISP_CD) as F_CATE_NM				
			from
			(
				select
					g.GOODS_CD
					, g.GOODS_NM
					, g.BRAND_CD
					, b.BRAND_NM
					, c.CATEGORY_DISP_CD
					, c.CATEGORY_DISP_NM
					, c.PARENT_CATEGORY_DISP_CD

				from
					DAT_GOODS 				g
				inner join	DAT_BRAND 					b
					on	g.BRAND_CD 						= b.BRAND_CD
					and b.WEB_DISP_YN					= 'Y'
				inner join	MAP_CATEGORY_DISP_N_GOODS	m
					on	g.GOODS_CD						= m.GOODS_CD
				inner join	DAT_CATEGORY_DISP 			c
					on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
				inner join	DAT_GOODS_PROGRESS			gp
					on	g.GOODS_CD 						= gp.GOODS_CD
					and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
					and	gp.GOODS_STS_CD					= '03'
				inner join	COD_GOODS_STS_CD			gs
					on	gp.GOODS_STS_CD 				= gs.GOODS_STS_CD
				inner join	(	select	distinct mc.GOODS_CD
									from	MAP_CATEGORY_DISP_N_GOODS 	mc
									inner join	DAT_CATEGORY_DISP 		c
										on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
										and	c.USE_YN 				= 'Y'
									where	mc.USE_YN					= 'Y'
								) mc
					on	g.GOODS_CD						= mc.GOODS_CD
				
					where
						1 = 1
					and g.WEB_DISP_YN = 'Y'
					$query_brand

					order by	 g.GOODS_CD desc
					limit ?, ?
				) t
				group by
					$query_group
				order by	 t.GOODS_CD desc
		";

        $db = self::_slave_db();
        //log_message('debug', '============================ get_brand_list_count : '.$query);

        return $db->query($query, array(0,$total_cnt))->result_array();
    }

    /**
     * 브랜드 카테고리별 상위카테고리 구하기
     */
    public function get_brand_cate($param){
        $result = array();

        for($i = 0; $i<count($param); $i++) {
            $query = "
			  select /*  > etah_front > goods_m > get_brand_cate > ETAH 브랜드 상위카테고리 */
			  		  CATEGORY_DISP_CD
		              ,PARENT_CATEGORY_DISP_CD
		              ,CATEGORY_DISP_NM
		
		      from DAT_CATEGORY_DISP
		
		      where
			  1=1
		      and CATEGORY_DISP_CD in(?)
		  ";
            $db = self::_slave_db();
            $result[$i] = $db->query($query, array($param[$i]))->row_array();
        }
        //log_message('debug', '============================ get_brand_list_count : '.$query);

        return $result;
    }

    /**
     * 상품 클릭 수
     */
    public function goods_click($goods_code)
    {
        $query = "
             update          /*  > etah_front > goods_m > goods_click > 상품 클릭 수 증가 */
                    DAT_GOODS g 
             set
                    g.HITS = g.HITS+1 
             where 
                    g.GOODS_CD = '".$goods_code."'
         ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 기획전 클릭 수
     */
    public function event_click($event_cd)
    {
        $query = "
             update         /*  > etah_front > goods_m > event_click > 기획전 클릭 수 증가 */
                    DAT_PLAN_EVENT e
             set
                    e.HITS = e.HITS+1 
             where 
                    e.PLAN_EVENT_CD = '".$event_cd."'
         ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 리사이징 이미지 가져오기
     */
    public function get_goodsImageResizing($goods_cd, $size)
    {
        $query = "
           select       /*  > etah_front > goods_m > get_goodsImageResizing > 리사이징 이미지 가져오기 */
                    i.GOODS_CD
                     , ifnull(imr.IMG_URL, ifnull(im.GOODS_CD, ifnull(ir.IMG_URL, i.IMG_URL)))	as IMG_URL
            from 
                    DAT_GOODS_IMAGE i
         
             left join DAT_GOODS_IMAGE_RESIZING ir
             on i.GOODS_CD = ir.GOODS_CD
             and ir.USE_YN = 'Y'
             and ir.TYPE_CD = '".$size."'
             
             left join DAT_GOODS_IMAGE_MD im
             on i.GOODS_CD = im.GOODS_CD
             and im.USE_YN = 'Y'
             
             left join DAT_GOODS_IMAGE_RESIZING_MD imr
             on i.GOODS_CD = imr.GOODS_CD
             and imr.USE_YN = 'Y'
             and imr.TYPE_CD = '".$size."'
             
            where 
                    1=1
            and i.GOODS_CD = '".$goods_cd."' 
            and i.USE_YN = 'Y'
        ";

        $db = self::_slave_db();
        $row = $db->query($query)->row_array();

        return $row['IMG_URL'];
    }

    /**
     * 네이버페이 - 옵션명 재설정 (장바구니)
     */
    public function set_optionName($goods_cd, $option_cd)
    {
        $query = "
        select    /*  > etah_front > goods_m > set_optionName > 네이버페이 - 옵션명 재설정 (장바구니) */
             case 
                when go.M_OPTION_5 != '' then concat(go.M_OPTION_1, '/', go.M_OPTION_2, '/', go.M_OPTION_3, '/', go.M_OPTION_4, '/', go.M_OPTION_5)
                when go.M_OPTION_4 != '' then concat(go.M_OPTION_1, '/', go.M_OPTION_2, '/', go.M_OPTION_3, '/', go.M_OPTION_4)
                when go.M_OPTION_3 != '' then concat(go.M_OPTION_1, '/', go.M_OPTION_2, '/', go.M_OPTION_3)
                when go.M_OPTION_2 != '' then concat(go.M_OPTION_1, '/', go.M_OPTION_2)
                else go.M_OPTION_1  
            end	                      as OPT_NM
        from 
            DAT_GOODS_OPTION go 
        where 
            1=1
        and go.GOODS_OPTION_CD = '".$option_cd."' 
        and go.GOODS_CD = '".$goods_cd."'
        ";

        $db = self::_slave_db();
        $row = $db->query($query)->row_array();

        return $row['OPT_NM'];
    }

    /**
     * 매장방문 예약하기
     */
    public function reg_reservation($param)
    {
        $db = self::_master_db();

        //예약정보 insert
        if($param['goods_cd'] != '') {
            $column = ", GOODS_CD";
            $value = ", '".$param['goods_cd']."'";
        } else {
            $column = "";
            $value = "";
        }

        $query1 = "
            insert into     DAT_RESERVATION_INFO     /*  > etah_front > goods_m > reg_reservation > 매장방문 예약하기 */
            (
                    CUST_NM
                    , MOB_NO
                    , VISIT_START_DT
                    , VISIT_END_DT
                    $column
            )
            values (
                  '".$param['name']."'
                  , '".$param['mob_no']."'
                  , '".$param['start_dt']."'
                  , '".$param['end_dt']."'
                  $value
            )
        ";

        $db->query($query1);
        $reserve_no = $db->insert_id();


        //예약 진행상태 insert
        $query2 = "
            insert into     DAT_RESERVATION_PROGRESS    /*  > etah_front > goods_m > reg_reservation > 예약 진행상태 추가 */
            (
                    RESERVATION_NO
                    , RESERVATION_STS_CD
            )
            values (
                  '".$reserve_no."'
                  , '01'
            )
        ";
        $db->query($query2);
        $reservation_progress_no = $db->insert_id();


        //예약 진행상태코드 update
        $query3 = "
            update      /*  > etah_front > goods_m > reg_reservation > 예약 진행상태코드 수정 */
                      DAT_RESERVATION_INFO i
            set 
                      i.RESERVATION_PROC_STS_NO = '".$reservation_progress_no."'
            where 
                      i.RESERVATION_NO = '".$reserve_no."'
        ";
        $db->query($query3);

        return $reserve_no;
    }

}