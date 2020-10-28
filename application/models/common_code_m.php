<?php
/**
 * Created by 공통코드
 * User: 조용준
 * Date: 2014.11.17
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_code_m extends CI_Model {

    protected $_ci;
    protected $mdb;
    protected $sdb;

    public function __construct()
    {
        parent::__construct();
        $this->_ci =& get_instance();
    }

    // SMS문자 보내기 위한 DB 연결
    private function _sms_db()
    {
        if( ! empty($this->sdb) ) return $this->sdb;

        /* 데이타베이스 연결 */
        $this->load->helper('array');
        $database = random_element(config_item('sms'));
        $this->sdb = $this->load->database($database,TRUE);

        return $this->sdb;
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
     * COD_COUNTRY 국가코드
     *
     * @return 리스트
     */
    public function get_cod_country_list()
    {

        $query = " SELECT A.NATION_CD      /*  > etah_front > common_code_m > get_cod_country_list > 국가코드 */
						 	        ,A.ENG_NATION_CD_NM
						 			 ,A.NATION_CD_NM
									 ,A.EMS_PRC_APPLY_AREA_CD
									 ,A.INT_TEL_AREA_CD
						   FROM COD_COUNTRY A
					    WHERE 1=1 ";

        $db = self::_slave_db();
        $db->cache_on();
        $rows = $db->query($query)->result_array();
        $db->cache_off();

        return $rows;
    }

    /**
     * COD_QNA_GB 문의구분코드
     *
     * @return 리스트
     */
    public function get_cod_qna_gb_list()
    {

        $query = " SELECT A.QNA_GB_CD      /*  > etah_front > common_code_m > get_cod_qna_gb_list > 문의구분코드 */
						 	        ,A.QNA_GB_CD_NM
						 			 ,A.ENG_CD_NM
									 ,A.CN_CD_NM
						   FROM COD_QNA_GB A
					    WHERE 1=1 ";

        $db = self::_slave_db();
        $db->cache_on();
        $rows = $db->query($query)->result_array();
        $db->cache_off();

        return $rows;
    }

    /**
     * SMS발송
     *
     * @param $argPhoneNo
     * @param $argMsg
     *
     * @return boolean
     */
    public function reg_send_sms($argPhoneNo, $argMsg)
    {
        /*
            다우 SMS CS번호 (인증받은번호) : 01049929228
        */

        $query = " INSERT INTO uds_msg    /*  > etah_front > common_code_m > reg_send_sms > SMS발송 */
		               (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE, MSG_BODY) 
		               VALUES 
		               (0, now()+0, now(), now(), ?, '01049929228', ? ) ";

        $db = self::_sms_db();
        return $db->query( $query, array( $argPhoneNo, $argMsg ) );
    }

    /**
     * COD_CN_POST 중국우편번호 (대분류)
     *
     * @return 리스트
     */
    public function get_cod_cn_post_level1_list()
    {

        $query = " SELECT CONCAT(A.LEVEL1,'  ',A.LEVEL1_PINYIN) AS LEVEL1   /*  > etah_front > common_code_m > get_cod_cn_post_level1_list > 중국우편번호 (대분류) 조회 */
									 ,A.LEVEL1_PINYIN
						   FROM COD_CN_POST A
					GROUP BY A.LEVEL1
									 ,A.LEVEL1_PINYIN
					ORDER BY A.LEVEL1 ";

        $db = self::_slave_db();

        return $db->query($query)->result_array();
    }

    /**
     * COD_CN_POST 중국우편번호 (중분류)
     *
     * @return 리스트
     */
    public function get_cod_cn_post_level2_list($argLevelPinyic1)
    {

        $query = " SELECT CONCAT(A.LEVEL2,'  ',A.LEVEL2_PINYIN) AS LEVEL2     /*  > etah_front > common_code_m > get_cod_cn_post_level2_list > 중국우편번호 (중분류) 조회 */
							        ,A.LEVEL2_PINYIN
						   FROM COD_CN_POST A
						 WHERE A.LEVEL1_PINYIN= ?
					GROUP BY A.LEVEL2
								      ,A.LEVEL2_PINYIN
					 ORDER BY A.LEVEL2 ";

        $db = self::_slave_db();

        $rows = $db->query($query, array( $argLevelPinyic1 ) )->result_array();

        return $rows;
    }

    /**
     * COD_CN_POST 중국우편번호 (소분류)
     *
     * @return 리스트
     */
    public function get_cod_cn_post_level3_list($argLevelPinyic2)
    {

        $query = " 	SELECT CONCAT(A.LEVEL3,'  ',A.LEVEL3_PINYIN) AS LEVEL3      /*  > etah_front > common_code_m > get_cod_cn_post_level3_list > 중국우편번호 (소분류) 조회 */
								       ,A.LEVEL3_PINYIN
								       ,A.ZIPCODE
								       ,A.LEVEL1
			 							,A.LEVEL1_PINYIN
 	       							,A.LEVEL2
 	       							,A.LEVEL2_PINYIN
 	       							,A.NATION_ZONE_CD
							 FROM COD_CN_POST A
						    WHERE A.LEVEL2_PINYIN= ?
					   GROUP BY A.LEVEL3
								        ,A.LEVEL3_PINYIN
								        ,A.ZIPCODE
						ORDER BY A.LEVEL3 ";

        $db = self::_slave_db();

        $rows = $db->query($query, array( $argLevelPinyic2 ) )->result_array();

        return $rows;
    }

    /**
     * COD_CN_POST 중국우편번호 (소분류) 상세항목
     *
     * @return 리스트
     */
    public function get_cod_cn_post_level3_info($argLevelPinyic1, $argLevelPinyic2, $argLevelPinyic3)
    {

        $query = " 	SELECT A.ZIPCODE      /*  > etah_front > common_code_m > get_cod_cn_post_level3_info > 중국우편번호 (소분류) 상세항목 조회 */
								       ,A.LEVEL1
			 							,A.LEVEL1_PINYIN
 	       							,A.LEVEL2
 	       							,A.LEVEL2_PINYIN
 	       							,A.LEVEL3
								       ,A.LEVEL3_PINYIN
								       ,A.NATION_ZONE_CD
							 FROM COD_CN_POST A
						    WHERE 1=1
						       AND A.LEVEL1_PINYIN= ?  
						       AND A.LEVEL2_PINYIN= ?  
						       AND A.LEVEL3_PINYIN= ? ";

        $db = self::_slave_db();

        $rows = $db->query($query, array( $argLevelPinyic1, $argLevelPinyic2, $argLevelPinyic3 ) )->result_array();

        return $rows;
    }

    /**
     * COD_LOGICS 택배사 리스트
     *
     * @return 리스트
     */
    public function get_cod_logics_list()
    {

        $query = " SELECT A.LOGICS_CD     /*  > etah_front > common_code_m > get_cod_logics_list > 택배사 리스트 조회 */
							        ,A.LOGICS_CD_NM
							        ,A.PREMIUM_CD
							        ,A.EMS_CUST_NO
							        ,A.EMS_APPR_NO
						   FROM COD_LOGICS A ";

        $db = self::_slave_db();

        return $db->query($query)->result_array();
    }

    /**
     * COD_QUIT_CD 탈퇴사유코드
     *
     * @return 리스트
     */
    public function get_cod_quit_cd_list()
    {

        $query = " 	SELECT A.QUIT_CD      /*  > etah_front > common_code_m > get_cod_quit_cd_list > 탈퇴사유코드 조회 */
								       ,A.QUIT_CD_NM
								       ,A.ENG_CD_NM
								       ,A.CN_CD_NM
							 FROM COD_QUIT_CD A ";

        $db = self::_slave_db();

        return $db->query($query)->result_array();
    }

}
