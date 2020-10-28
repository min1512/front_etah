<?php

class Batch extends MY_Controller
{
	protected $methods = array(
		//'index_get' => array('log' => 0)
	);

	function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}

		parent::__construct();
		/* model_m */
		$this->load->model('batch_m');

	}


	/**
	* 에타 초이스 batch 매일 06:00 실행
	* 에타 초이스 테이블 초기화 및 데이터 업데이트
	**/
	public function etah_choice_get(){
		//table truncate
		echo "============================== etah_choice_get start ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;

		$truncate = $this->batch_m->truncat_table_etah_choice();
		if($truncate){
			$result = $this->batch_m->select_etah_choice();
			foreach($result as $row){
				if($row['GOODS_CD']){
					$this->batch_m->insert_etah_choice($row);
				}
			}
			echo "============================== etah_choice_get success ===========================".PHP_EOL;
		}else{
			echo "============================== etah_choice_get fail ===========================".PHP_EOL;
		}
		echo json_encode("============================== etah_choice_get end ".date("Y-m-d A h:i:s")."===========================".PHP_EOL);
	}


	/**
	* 에타 weekley batch 매일 06:00 실행
	* 에타 weekley best 테이블 초기화 및 데이터 업데이트
	**/
	public function etah_weekley_get(){
		//table truncate
		echo "============================== etah_weekley_get start ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;

		$truncate = $this->batch_m->truncat_table_etah_weekley();
		$cate = array('10000000','11000000','13000000','14000000','15000000'
                     ,'16000000','17000000','18000000','19000000','20000000','21000000','22000000','23000000');

		if($truncate){
            for ($i=0; $i < count($cate); $i++) {
                $result = $this->batch_m->select_etah_weekley($cate[$i]);

                foreach ($result as $row) {
                    if ($row['GOODS_CD']) {
                        echo $row['GOODS_CD'];
                        $this->batch_m->insert_etah_weekley($row);
                    }
                }
            }
			echo "============================== etah_weekley_get success ===========================".PHP_EOL;
		}else{

			echo "============================== etah_weekley_get fail ===========================".PHP_EOL;
		}
		echo "============================== etah_weekley_get end ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;	
	}

	/**
	* 에타 쿠폰적용대상 batch 매일 06:00 실행
	* 에타 BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER  테이블 초기화 및 데이터 업데이트
	**/
	public function etah_coupon_seller_get(){
		//table truncate
		echo "============================== etah_coupon_seller_get start ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;	
		//$truncate = $this->batch_m->truncat_table_coupon_seller();

        $TIME = date("H:i", time()).':00';
        echo $TIME.PHP_EOL;
        $result = $this->batch_m->select_coupon_seller();

        if('05:50:00' < $TIME && $TIME < '08:00:00') {
            $seq = '01';
        }else if('09:50:00' < $TIME && $TIME < '12:00:00'){
            $seq = '02';
        }else{
            $seq = '03';
        }

        if($result) {
            foreach ($result as $row) {
                if ($row['COUPON_APPLICATION_SCOPE_OBJECT_CD']) {
                    $this->batch_m->insert_coupon_seller($row,$seq);
                }
            }
            echo "============================== etah_coupon_seller_get success ===========================".PHP_EOL;
        }else{
            echo "============================== etah_coupon_seller_get fail ===========================".PHP_EOL;
        }

        if($this->batch_m->delete_coupon_seller($seq)){
            echo "============================== etah_coupon_seller_get end ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;
        }else{
            echo "============================== etah_coupon_seller_get fail_delete ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;
        }

        //echo "============================== etah_coupon_goods_get start ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;
        /*$truncate = $this->batch_m->truncat_table_coupon_seller();
        if($truncate){
            $result = $this->batch_m->select_coupon_seller();
            foreach($result as $row){
                if($row['COUPON_APPLICATION_SCOPE_OBJECT_CD']){
                    //echo $row['COUPON_APPLICATION_SCOPE_OBJECT_CD'];
                    $this->batch_m->insert_coupon_seller($row);
                }
            }
            echo "============================== etah_coupon_goods_get success ===========================".PHP_EOL;
        }else{
            echo "============================== etah_coupon_goods_get fail ===========================".PHP_EOL;
        }
        echo "============================== etah_coupon_goods_get end ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;*/


    }

	/**
	* 에타 쿠폰적용대상 batch 매일 06:00 실행
	* 에타 BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS  테이블 초기화 및 데이터 업데이트
	**/
	public function etah_coupon_goods_get(){
		//table truncate
		echo "============================== etah_coupon_goods_get start ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;
        $TIME = date("H:i", time()).':00';
        echo $TIME.PHP_EOL;
        $result = $this->batch_m->select_coupon_goods();

        if('05:50:00' < $TIME && $TIME < '08:00:00') {
            $seq = '01';
        }else if('09:50:00' < $TIME && $TIME < '12:00:00'){
            $seq = '02';
        }else{
            $seq = '03';
        }

        if($result) {
            foreach ($result as $row) {
                if ($row['COUPON_APPLICATION_SCOPE_OBJECT_CD']) {
                    $this->batch_m->insert_coupon_goods($row,$seq);
                }
            }
            echo "============================== etah_coupon_seller_get success ===========================".PHP_EOL;
        }else{
            echo "============================== etah_coupon_seller_get fail ===========================".PHP_EOL;
        }

        if($this->batch_m->delete_coupon_goods($seq)){
            echo "============================== etah_coupon_seller_get end ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;
        }else{
            echo "============================== etah_coupon_seller_get fail_delete ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;
        }

		/*$truncate = $this->batch_m->truncat_table_coupon_goods();
		if($truncate){
			$result = $this->batch_m->select_coupon_goods();
			foreach($result as $row){
				if($row['COUPON_APPLICATION_SCOPE_OBJECT_CD']){
					//echo $row['COUPON_APPLICATION_SCOPE_OBJECT_CD'];
					$this->batch_m->insert_coupon_goods($row);
				}
			}
			echo "============================== etah_coupon_goods_get success ===========================".PHP_EOL;
		}else{
			echo "============================== etah_coupon_goods_get fail ===========================".PHP_EOL;
		}
		echo "============================== etah_coupon_goods_get end ".date("Y-m-d A h:i:s")."===========================".PHP_EOL;	*/
	}

	/**
	*에타 모바일 상품 판매중인 브랜드 리스트 보기용
	*/
	public function etah_brandList_display_update_get()
	{
		echo "==============================  etah_brandList_display_update_get ".date("Y-m-d A h:i:s")."===========================<br>".PHP_EOL;	
		
		$table = "DAT_BRAND";
		
		$result = $this->batch_m->update_brand_list($table);

		echo "============================== etah_brandList_display_update_get success ===========================<br>".PHP_EOL;
		
		echo "============================== etah_brandList_display_update_get end ".date("Y-m-d A h:i:s")."===========================<br>".PHP_EOL;	
	}


    /**
     * 에타 회원가입 축하 마일리지 적립 batch : 10분마다 실행
     **/
    public function etah_mileage_default_get(){
        $result = $this->batch_m->select_mileage_default();
        foreach($result as $row){
            if($row['CUST_NO']){
               // log_message("DEBUG", "===========CUST_NO = ".$row['CUST_NO']);
                $this->batch_m->insert_mileage_default($row['CUST_NO']);
            }
        }
    }

    /**
     * 에타 에스크로 상태변경 요청(배송시작) batch
     */
    public function etah_escw_deliv_start_get(){
        include APPPATH ."/third_party/KCP/cfg/site_conf_inc.php";
        $this->load->library('C_PP_CLI');

        /** 에스크로 결제일 시 ESCROW_FLG = N값을넣어준다
        batch 실행 후 ESCROW_FLG = Y 으로 변경
         **/
        $deliv_list = $this->batch_m->select_delive_escrow();

        /*req_tx = 'mod_escrow';
        mode_type = 'STE1';
        tno
        deli_numb = '운송장번호(배송 시에 택배 회사를 이용하지 않는 자가 배송의 경우에는 반드시 “0000” 입력)'
        deli_corp = '택배회사명(배송시에 택배회사를 이용하지 않는 자체 배송의 경우에는 반드시 “자가배송)'
        */

        foreach ($deliv_list as $row){

            /* ============================================================================== */
            /* =   01. 구매후 취소 요청 정보 설정                                           = */
            /* = -------------------------------------------------------------------------- = */
            $req_tx            = 'mod_escrow'; // 요청종류
            $cust_ip           = getenv( "REMOTE_ADDR"      ); // 요청 IP
            $tran_cd           = "";
            $res_cd            = "";                                                       // 응답코드
            $res_msg           = "";                                                       // 응답메시지
            /* ============================================================================== */
            $mod_type          = 'STE1';                // 변경수단 - STE1 :배송시작
            $tno               = $row[ "IMP_UID"            ]; // 거래번호
            $mod_desc          = $_POST[ "mod_desc"         ]; // 취소사유
            $mod_depositor     = $_POST[ "mod_depositor"    ]; // 환불계좌주명(환불시에만 사용)
            $mod_account       = $_POST[ "mod_account"      ]; // 환불계좌번호(환불시에만 사용)
            $mod_bankcode      = $_POST[ "mod_bankcode"     ]; // 환불은행코드(환불시에만 사용)
            $mod_sub_type      = $_POST[ "mod_sub_type"     ]; // 취소상세구분
            $sub_mod_type      = $_POST[ "sub_mod_type"     ]; // 취소유형
            /* ============================================================================== */
            $vcnt_yn           = $_POST[ "vcnt_yn"          ]; // 상태변경시 계좌이체, 가상계좌 여부
            /* = -------------------------------------------------------------------------- = */
            $y_rem_mny         = $_POST[ "rem_mny"          ]; // 환불 가능 금액
            $y_mod_mny         = $_POST[ "mod_mny"          ]; // 환불 금액
            $y_tax_mny         = $_POST[ "tax_mny"          ]; // 부분취소 과세금액
            $y_free_mod_mny    = $_POST[ "free_mod_mny"     ]; // 부분취소 비과세금액
            $y_add_tax_mny     = $_POST[ "add_tax_mny"      ]; // 부분취소 부과세 금액
            $y_refund_account  = $_POST[ "a_refund_account" ]; // 환불계좌번호
            $y_refund_nm       = $_POST[ "a_refund_nm"      ]; // 환불계좌주명
            $y_bank_code       = $_POST[ "a_bank_code"      ]; // 은행코드
            $y_mod_desc_cd     = $_POST[ "mod_desc_cd"      ]; // 취소구분
            $y_mod_desc        = $_POST[ "mod_desc"         ]; // 취소사유
            /* = -------------------------------------------------------------------------- = */
            /* =   01. 구매후 취소 요청 정보 설정 END                                       = */
            /* ============================================================================== */

            /* ============================================================================== */
            /* =   02. 인스턴스 생성 및 초기화(변경 불가)                                   = */
            /* = -------------------------------------------------------------------------- = */
            /* =               결제에 필요한 인스턴스를 생성하고 초기화 합니다.             = */
            /* =               ※ 주의 ※ 이 부분은 변경하지 마십시오                       = */
            /* = -------------------------------------------------------------------------- = */
            $c_PayPlus = new C_PP_CLI;
            $c_PayPlus->mf_clear();
            /* ------------------------------------------------------------------------------ */
            /* =   02. 인스턴스 생성 및 초기화 END                                          = */
            /* ============================================================================== */


            /* ============================================================================== */
            /* =   03. 처리 요청 정보 설정                                                  = */
            /* = -------------------------------------------------------------------------- = */
            /* = -------------------------------------------------------------------------- = */
            /* =   03-1. 에스크로 상태변경 요청                                             = */
            /* = -------------------------------------------------------------------------- = */
            if ( $req_tx == "mod_escrow" )
            {
                $c_PayPlus->mf_set_modx_data( "tno",        $row[ "IMP_UID"       ] );      // KCP 원거래 거래번호
                $c_PayPlus->mf_set_modx_data( "mod_ip",     $cust_ip              );      // 변경 요청자 IP
                $c_PayPlus->mf_set_modx_data( "mod_desc",   "배송시작" );      // 변경 사유

                if( $mod_type == "STE9_C"  || $mod_type == "STE9_CP" ||
                    $mod_type == "STE9_A"  || $mod_type == "STE9_AP" ||
                    $mod_type == "STE9_AR" || $mod_type == "STE9_V"  ||
                    $mod_type == "STE9_VP" )
                {
                    $tran_cd = "70200200";
                    $c_PayPlus->mf_set_modx_data( "mod_type"    , "STE9"         );
                    $c_PayPlus->mf_set_modx_data( "mod_desc_cd" , $y_mod_desc_cd );
                    $c_PayPlus->mf_set_modx_data( "mod_desc"    , $y_mod_desc    );

                    if( $mod_type == "STE9_C" )
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STSC"            );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC03"          );
                    }
                    else if( $mod_type == "STE9_CP" )
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STPC"            );
                        $c_PayPlus->mf_set_modx_data( "part_canc_yn"    , "Y"               );
                        $c_PayPlus->mf_set_modx_data( "rem_mny"         , $y_rem_mny        );
                        $c_PayPlus->mf_set_modx_data( "amount"          , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_mny"         , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC03"          );
                        //$c_PayPlus->mf_set_modx_data( "tax_flag"        , "TG03"            ); // 복합과세 부분취소
                        //$c_PayPlus->mf_set_modx_data( "mod_tax_mny"     , $y_tax_mny        ); // 공급가 부분취소 금액
                        //$c_PayPlus->mf_set_modx_data( "mod_free_mny"    , $y_free_mod_mny   ); // 비과세 부분취소 금액
                        //$c_PayPlus->mf_set_modx_data( "mod_vat_mny"     , $y_add_tax_mny    ); // 부가세 부분취소 금액
                    }
                    else if( $mod_type == "STE9_A")
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STSC"            );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC03"          );
                    }
                    else if( $mod_type == "STE9_AP")
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STPC"            );
                        $c_PayPlus->mf_set_modx_data( "part_canc_yn"    , "Y"               );
                        $c_PayPlus->mf_set_modx_data( "rem_mny"         , $y_rem_mny        );
                        $c_PayPlus->mf_set_modx_data( "amount"          , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_mny"         , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC04"          );
                        //$c_PayPlus->mf_set_modx_data( "tax_flag"        , "TG03"            ); // 복합과세 부분취소
                        //$c_PayPlus->mf_set_modx_data( "mod_tax_mny"     , $y_tax_mny        ); // 공급가 부분취소 금액
                        //$c_PayPlus->mf_set_modx_data( "mod_free_mny"    , $y_free_mod_mny   ); // 비과세 부분취소 금액
                        //$c_PayPlus->mf_set_modx_data( "mod_vat_mny"     , $y_add_tax_mny    ); // 부가세 부분취소 금액
                    }
                    else if( $mod_type == "STE9_AR")
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STHD"            );
                        $c_PayPlus->mf_set_modx_data( "mod_mny"         , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC04"          );
                        $c_PayPlus->mf_set_modx_data( "mod_bankcode"    , $y_bank_code      );
                        $c_PayPlus->mf_set_modx_data( "mod_account"     , $y_refund_account );
                        $c_PayPlus->mf_set_modx_data( "mod_depositor"   , $y_refund_nm      );
                    }
                    else if( $mod_type == "STE9_V")
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STHD"            );
                        $c_PayPlus->mf_set_modx_data( "mod_mny"         , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC00"          );
                        $c_PayPlus->mf_set_modx_data( "mod_bankcode"    , $y_bank_code      );
                        $c_PayPlus->mf_set_modx_data( "mod_account"     , $y_refund_account );
                        $c_PayPlus->mf_set_modx_data( "mod_depositor"   , $y_refund_nm      );
                    }
                    else if( $mod_type == "STE9_VP")
                    {
                        $c_PayPlus->mf_set_modx_data( "sub_mod_type"    , "STPD"            );
                        $c_PayPlus->mf_set_modx_data( "mod_mny"         , $y_mod_mny        );
                        $c_PayPlus->mf_set_modx_data( "rem_mny"         , $y_rem_mny        );
                        $c_PayPlus->mf_set_modx_data( "mod_sub_type"    , "MDSC04"          );
                        $c_PayPlus->mf_set_modx_data( "mod_bankcode"    , $y_bank_code      );
                        $c_PayPlus->mf_set_modx_data( "mod_account"     , $y_refund_account );
                        $c_PayPlus->mf_set_modx_data( "mod_depositor"   , $y_refund_nm      );
                        //$c_PayPlus->mf_set_modx_data( "tax_flag"        , "TG03"            ); // 복합과세 부분취소
                        //$c_PayPlus->mf_set_modx_data( "mod_tax_mny"     , $y_tax_mny        ); // 공급가 부분취소 금액
                        //$c_PayPlus->mf_set_modx_data( "mod_free_mny"    , $y_free_mod_mny   ); // 비과세 부분취소 금액
                        //$c_PayPlus->mf_set_modx_data( "mod_vat_mny"     , $y_add_tax_mny    ); // 부가세 부분취소 금액
                        $c_PayPlus->mf_set_modx_data( "part_canc_yn"    , "Y"               );
                    }
                }
                else
                {
                    $tran_cd = "00200000";

                    $c_PayPlus->mf_set_modx_data( "mod_type",   $mod_type                           );      // 원거래 변경 요청 종류

                    if ( $mod_type == "STE1")                                                                  // 상태변경 타입이 [배송요청]인 경우
                    {
                        //log_message("DEBUG", " =============== ".$row["DELIV_COMPANY_NM"]);
                        //$deli_corp = iconv("UTF-8", "EUC-KR", $row["DELIV_COMPANY_NM"]);
                        //$deli_corp = mb_convert_encoding($row["DELIV_COMPANY_NM"],"EUC-KR", "UTF-8" );
                        //log_message("DEBUG", " ===============euckr ".$deli_corp);

                        $c_PayPlus->mf_set_modx_data( "deli_numb", $row[ "INVOICE_NO" ] );      // 운송장 번호
                        $c_PayPlus->mf_set_modx_data( "deli_corp", $row["DELIV_COMPANY_NM"]);      // 택배 업체명
                        //$c_PayPlus->mf_set_modx_data( "deli_corp",  mb_convert_encoding($row["DELIV_COMPANY_NM"], "EUC-KR", "UTF-8") );      // 택배 업체명
                    }
                    if ( $mod_type == "STE2" || $mod_type == "STE4" )                                       // 상태변경 타입이 [즉시취소] 또는 [취소]인 계좌이체, 가상계좌의 경우
                    {
                        if ( $vcnt_yn == "Y" )
                        {
                            $c_PayPlus->mf_set_modx_data( "refund_account", $mod_account    );  // 환불수취계좌번호
                            $c_PayPlus->mf_set_modx_data( "refund_nm",      $mod_depositor  );  // 환불수취계좌주명
                            $c_PayPlus->mf_set_modx_data( "bank_code",      $mod_bankcode      );  // 환불수취은행코드
                        }
                    }
                }
            }
            /* = -------------------------------------------------------------------------- = */
            /* =   03. 에스크로 상태변경 요청 END                                           = */
            /* = -------------------------------------------------------------------------- = */

            /* ============================================================================== */
            /* =   04. 실행                                                                 = */
            /* = -------------------------------------------------------------------------- = */
            if ( $tran_cd != "" )
            {

                $c_PayPlus->mf_do_tx( "", $g_conf_home_dir, $g_conf_site_cd, $g_conf_site_key, $tran_cd, "",
                    $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                    $cust_ip, $g_conf_log_level, 0, 0, $g_conf_log_path ); // 응답 전문 처리

                $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
                $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
                log_message("DEBUG","=========================res_msg : ".iconv("EUC-KR", "UTF-8", $res_msg));
                log_message("DEBUG","==========================res_cd : ".$res_cd);
                if($res_cd == "0000"){
                    $this->batch_m->update_delive_escrow($row['IMP_UID']);
                }
            }
            else
            {
                $c_PayPlus->m_res_cd  = "9562";
                $c_PayPlus->m_res_msg = "연동 오류|Payplus Plugin이 설치되지 않았거나 tran_cd값이 설정되지 않았습니다.";
            }

            /* = -------------------------------------------------------------------------- = */
            /* =   04. 실행 END                                                             = */
            /* ============================================================================== */


            /* ================================================================================== */
            /* =   05.구매확인 후 취소 성공 결과 처리										    = */
            /* = ------------------------------------------------------------------------------ = */
            if ( $req_tx == "mod" )
            {
                if( $res_cd == "0000" )
                {
                    //$this->batch_m->update_delive_escrow($row['ORDER_PAY_DTL_NO']);
                } // End of [res_cd = "0000"]


                /* ================================================================================== */
                /* =   05.구매확인 후 취소 실패 결과 처리                                          = */
                /* ================================================================================== */
                else
                {
                }
            } // End of Process


            //* ============================================================================= */
            /* =   05. 폼 구성 및 결과페이지 호출                                           = */
            /* = -------------------------------------------------------------------------- = */

        }

    }



}
