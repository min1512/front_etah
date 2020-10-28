<?php

class Lprice extends MY_Controller
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


        /**
         * 로그 기록 여부 설정
         */
        $method_id = explode(".", $this->uri->segment(2));
        if( ! empty($method_id[0])) {
            $method_type = strtolower($method);
            $funtion = $method_id[0]."_".$method_type;
            if(!config_item('log')) $this->methods[$funtion] = array('log' => 0);
        }

        //API Key 사용시 해당 값을 설정하면 키검사를 하지 않음
        $this->_allow = TRUE;

        /* model_m */
        $this->load->model('order_m');
    }

    public function index_get()
    {
        self::Gateway_Linkprice();
    }

    /**
     * 2018.10.02 Linkprice 추가
     */
    // 링크프라이스 Gateway
    public function Gateway_Linkprice(){

        define(RETURN_DAYS,15);			    //광고 인정 기간(Cookie expire time)
        $lpinfo = $_REQUEST["lpinfo"];		//어필리에이트 정보(Affiliate info)
        $url = $_REQUEST["url"];			//이동할 페이지(URL of redirection)
        $domain = '.etah.co.kr';	//서비스 중인 도메인 (Domain in service)
        if ($lpinfo == "" ||  $url == "")  {
            // alert: LPMS: Parameter Error
            echo "<html><head><script type=\"text/javascript\">
            alert('LPMS: Unable to connect. Contact your linkprice site representative');
            history.go(-1);
            </script></head></html>";
            exit;
        }
        Header("P3P:CP=\"NOI DEVa TAIa OUR BUS UNI\"");
        if (RETURN_DAYS == 0) {
            SetCookie("LPINFO", $lpinfo, 0, "/", $domain);
        } else {
            SetCookie("LPINFO", $lpinfo, time() + (RETURN_DAYS * 24 * 60 * 60), "/", $domain);
        }
        Header("Location: ".$url);
    }

    // 링크프라이스 daily_fix
    public function daily_fix_get()
    {
        //URL : www.etah.co.kr/lprice/daily_fix?yyyymmdd=2018xxxx

        $param = $this->input->get();

        $year = substr($param['yyyymmdd'],0,4);
        $mon  = substr($param['yyyymmdd'],4,2);
        $day  = substr($param['yyyymmdd'],6,2);

        $daily_day = $year.'-'.$mon.'-'.$day;
        //echo $daily_day;
        $daily_fix = array();
        $daily_fix = $this->order_m->get_lprice_daily($daily_day);
        echo json_encode($daily_fix);
    }

    // 링크프라이스 자동실적 취소
    public function auto_cancel_get()
    {
        $param = $this->input->get();

        $order_code   = $param['order_code'  ];
        $product_code = $param['product_code'];

        $auto_cancel = $this->order_m->get_lprice_cancel_List($order_code,$product_code);

        header('Content-Type: application/json');
        echo json_encode($auto_cancel);
    }

    public function check_test_get()
    {
//        $result = $this->order_m->get_lprice_order(100014212);
//
//        json_encode($result);
//
//        print_r( $result);

        echo $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
}