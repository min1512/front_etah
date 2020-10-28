<?php
/**
 * User: Joe, Yong June
 * Date: 2016/04/04
 * @property main_m $main_m
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller
{

	function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        //$header = $this->output->get_output();
        //echo $header;
        /*$code = http_response_code();
        echo $code;*/
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}

		parent::__construct();

		/* model_m */
		$this->load->model('main_m');
	}

	public function index_get()
	{
		self::main_get();

	}

	public function https_get()
	{
		echo "https test".PHP_EOL;
		echo "<img src=http://image.etah.co.kr/mallBanner/CATE_MENU_11000000_1/16_20170814181930_170810_gnb_banner_1.jpg >".PHP_EOL;
	}

    /**
     * 메인화면 테스트중
     * @auth 박상현
     */
	public function testmain_get(){
        //header("Cache-Control:public, max-age=60, must-revalidate");
        $data = array();

        /* TOP BANNER */
        $data['top'			] = $this->main_m->get_md_goods('MAIN_TOP');

        //메인롤링배너 DB에서 가져오기
        $top_disp_html		= $data['top'][0]['DISP_HTML'];

        $rolling_top = str_replace("</li><li class=\"main_banner_item\"","</li>','<li class=\"main_banner_item\"",$top_disp_html);
        $rolling_top = substr($rolling_top, 0, strlen($rolling_top)-4);

        $data['rolling_top']	= $rolling_top;
        //

        /* NEW ITEM */
        $data['new_item'	] = $this->main_m->get_md_goods('MAIN_NEW_ITEM');

        /* NEW BRAND */
        $data['new_brand'	] = $this->main_m->get_md_goods('MAIN_NEW_BRAND');

        /* SHOW ROOM */
        $data['showroom'	] = $this->main_m->get_md_goods('MAIN_SHOWROOM');

        /* BEST 상품 */
        //$data['best_goods'	] = $this->main_m->get_best_goods();    // 3.6초

        /* 에타 초이스 */
        $data['etah_choice'	] = $this->main_m->get_md_goods_choice('MAIN_ETAH_CHOICE'); // 3.5초

        /* CLLECTION */
        $data['collection_t'] = $this->main_m->get_md_goods('MAIN_COLLECTION_TITL'); //TITL 오타아님
        $data['collection'	] = $this->main_m->get_md_goods_collection('MAIN_COLLECTION');

        /* MAGAZINE */
        $magazine = $this->main_m->get_md_goods('MAIN_MAGAZINE');

        for($i=0; $i<count($magazine); $i++){
            $magazine[$i]['NAME'] = explode('||',$magazine[$i]['NAME']);
        }
        $data['magazine'	] = $magazine;

        /* 브랜드 */
        $data['brand_menu'	] = $this->main_m->get_md_goods_brand_menu();   // 5.9초 ~ 6초
        $data['brand'		] = $this->main_m->get_md_goods_brand();

//		/* 브랜드2 */
//		$data['brand2'		] = $this->main_m->get_md_goods_brand('MAIN_BRAND2');
//
//		/* 브랜드3 */
//		$data['brand3'		] = $this->main_m->get_md_goods_brand('MAIN_BRAND3');
//
//		/* 브랜드4 */
//		$data['brand4'		] = $this->main_m->get_md_goods_brand('MAIN_BRAND4');

        $data['main'		] = true;

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data1['menu'] = $category_menu['category'];

        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();
//var_dump($data['quick']['view']);

        $this->load->view('include/header', $data);
        $this->load->view('testmain');
        $this->load->view('include/layout');
        $this->load->view('include/footer');

    }


    /**
     * 메인화면.
     * @auth 박상현
     */
	public function main_org2_get()
	{
		$data = array();
		/**
		 * 상품 카테고리 및 상품 정보 웹캐시 이용
		 * 매일 24:00:01 를 기준으로 캐시 삭제
		 */
		$this->load->helper('file');
		$deleteDay = date("Ymd",time());
		$f = read_file('./application/cache/cache_delete_day.php');
		if(!$f || $f < $deleteDay) {
			$this->main_m->cache_delete();
			write_file('./application/cache/cache_delete_day.php', $deleteDay);
			delete_files('./application/cache/menu_serialize.php');
		}

        /* TOP BANNER */
        $data['top'			] = $this->main_m->get_md_goods('MAIN_TOP');

        //메인롤링배너 DB에서 가져오기
        $top_disp_html		= $data['top'][0]['DISP_HTML'];

//        $rolling_top = str_replace("</li><li class=\"main_banner_item\"","</li>','<li class=\"main_banner_item\"",$top_disp_html);
//        $rolling_top = substr($rolling_top, 0, strlen($rolling_top)-4);

        $data['rolling_top']	= $top_disp_html;
        //
//var_dump($data['rolling_top']);
        /* NEW ITEM */
        $data['new_item'	] = $this->main_m->get_md_goods('MAIN_NEW_ITEM');

        /* NEW BRAND */
        $data['new_brand'	] = $this->main_m->get_md_goods('MAIN_NEW_BRAND');

        /* SHOW ROOM */
        $data['showroom'	] = $this->main_m->get_md_goods('MAIN_SHOWROOM');

        /* 에타 초이스 */
        $data['etah_choice'	] = $this->main_m->get_md_goods_choice('MAIN_ETAH_CHOICE'); // 3.5초

        /* CLLECTION */
        $data['collection_t'] = $this->main_m->get_md_goods('MAIN_COLLECTION_TITL'); //TITL 오타아님
        $data['collection'	] = $this->main_m->get_md_goods_collection('MAIN_COLLECTION');

        /* MAGAZINE */
        $magazine = $this->main_m->get_md_goods('MAIN_MAGAZINE');

        for($i=0; $i<count($magazine); $i++){
            $magazine[$i]['NAME'] = explode('||',$magazine[$i]['NAME']);
        }
        $data['magazine'	] = $magazine;

        /* 브랜드 */
        $data['brand_menu'	] = $this->main_m->get_md_goods_brand_menu();   // 5.9초 ~ 6초
        $data['brand'		] = $this->main_m->get_md_goods_brand();

        $data['main'		] = true;

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data1['menu'] = $category_menu['category'];

        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        $this->load->view('include/header', $data);
        $this->load->view('testmain');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
	}

    public function main_org_get()
	{
		$data = array();

		/* TOP BANNER */
		$data['top'			] = $this->main_m->get_md_goods('MAIN_TOP');

		//메인롤링배너 DB에서 가져오기
		$top_disp_html		= $data['top'][0]['DISP_HTML'];

		$rolling_top = str_replace("</li><li class=\"main_banner_item\"","</li>','<li class=\"main_banner_item\"",$top_disp_html);
		$rolling_top = substr($rolling_top, 0, strlen($rolling_top)-4);

		$data['rolling_top']	= $rolling_top;
		//

		/* NEW ITEM */
		$data['new_item'	] = $this->main_m->get_md_goods('MAIN_NEW_ITEM');

		/* NEW BRAND */
		$data['new_brand'	] = $this->main_m->get_md_goods('MAIN_NEW_BRAND');

		/* SHOW ROOM */
		$data['showroom'	] = $this->main_m->get_md_goods('MAIN_SHOWROOM');

		/* BEST 상품 */
		$data['best_goods'	] = $this->main_m->get_best_goods();

		/* 에타 초이스 */
		$data['etah_choice'	] = $this->main_m->get_md_goods_choice('MAIN_ETAH_CHOICE');

		/* CLLECTION */
		$data['collection_t'] = $this->main_m->get_md_goods('MAIN_COLLECTION_TITL'); //TITL 오타아님
		$data['collection'	] = $this->main_m->get_md_goods('MAIN_COLLECTION');

		/* MAGAZINE */
		$magazine = $this->main_m->get_md_goods('MAIN_MAGAZINE');

		for($i=0; $i<count($magazine); $i++){
			$magazine[$i]['NAME'] = explode('||',$magazine[$i]['NAME']);
		}
		$data['magazine'	] = $magazine;

		/* 브랜드 */
		$data['brand_menu'	] = $this->main_m->get_md_goods_brand_menu();
		$data['brand'		] = $this->main_m->get_md_goods_brand();

//		/* 브랜드2 */
//		$data['brand2'		] = $this->main_m->get_md_goods_brand('MAIN_BRAND2');
//
//		/* 브랜드3 */
//		$data['brand3'		] = $this->main_m->get_md_goods_brand('MAIN_BRAND3');
//
//		/* 브랜드4 */
//		$data['brand4'		] = $this->main_m->get_md_goods_brand('MAIN_BRAND4');

		$data['main'		] = true;

//		/**
//		 * 상단 카테고리 데이타
//		 */
//		$this->load->library('etah_lib');
//		$category_menu = $this->etah_lib->get_category_menu();
//		$data['menu'] = $category_menu['category'];

//		/**
//		 * 퀵 레이아웃
//		 */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();
////var_dump($data['quick']['view']);

//		$this->load->view('include/header');
		$this->load->view('main_org', $data);
//		$this->load->view('include/layout');
//		$this->load->view('include/footer');

	}

    /**
     * 메인화면.
     * @auth 김현아
     */
    public function main_get(){
        $data = array();

        /*MAIN_BANNER*/
        $data['top'             ] = $this->main_m->get_main_banner('WEB_MAIN_TOP');
        $data['event'           ] = $this->main_m->get_main_banner('MAIN_EVENT');

        /*에타딜*/
        $data['etahDeal'        ] = $this->main_m->get_md_goods_choice('MAIN_RCMD');

        /*홈족피디아*/
        $data['homejokAll'      ] = $this->main_m->get_md_goods('MAIN_HOMEJOK');
        $data['homejok1'        ] = $this->main_m->get_magazine('40010000');    //리빙백서
        $data['homejok2'        ] = $this->main_m->get_magazine('40030000');    //감성생활
        $data['homejok3'        ] = $this->main_m->get_magazine('40020000');    //홈족TIP
        $data['homejok4'        ] = $this->main_m->get_magazine('40040000');    //해외직구

        /*베스트 후기*/
        $data['best_review'     ] = $this->main_m->get_md_best_review('MAIN_BEST_REVIEW');

        /*인기 키워드*/
        $keyword = $this->main_m->get_md_goods('MAIN_HOT_KEYWORD');
        $data['hashtag'         ] = $this->main_m->get_hashtag($keyword[0]['BANNER_CD']);

        unset($keyword[0]);
        $data['best_keyword'    ] = $keyword;

        /*MD Pick*/
        $data['md_pick'         ] = $this->main_m->get_md_goods_choice('MAIN_ETAH_CHOICE');

        /*Brand Focus*/
        $data['brand_focus'     ] = $this->main_m->get_brand_focus();

        /*인기 매거진*/
        $data['magazine1'       ] = $this->main_m->get_md_goods('MAIN_MAGAZINE1');
        $data['magazine2'       ] = $this->main_m->get_md_goods('MAIN_MAGAZINE2');
        $data['magazine3'       ] = $this->main_m->get_md_goods('MAIN_MAGAZINE3');

        /*공방클래스*/
        $data['class_magazine'  ] = $this->main_m->get_md_goods('MAIN_CLASS_MAGAZINE');
        $data['class_goods'     ] = $this->main_m->get_md_goods_choice('MAIN_CLASS_GOODS');


        /**
         * 카테고리 메뉴
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];

        /**
         * 퀵 레이어 메뉴
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        $this->load->view('include/header', $data);
        $this->load->view('new_main');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    public function uiTest_get() {
        $this->load->view('include/testHeader');
        $this->load->view('goods/test');
    }

}