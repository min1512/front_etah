<!DOCTYPE html>
<html lang="ko-KR">

<head>
    <title>에타홈 - 집에 관한 모든 것</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="홈&펫&직구, 국내부터 해외까지 가구/소품/주방 등 홈퍼니싱 전문 온라인샵!">
    <meta name="viewport" content="user-scalable=yes, width=1280">
    <?
    $uri_val = $this->uri->segment(1, 0);
    $uri_val .= "/".$this->uri->segment(2, 0);

    $description	= "";
    $metaOgTitle	= "ETAHOME";
    $metaOgUrl		= current_url();
//    $metaOgImg		= "http://www.etah.co.kr/assets/images/common/etah_image.png";
    $metaOgImg		= "http://ui.etah.co.kr/assets/images/data/etah_image.png";

    if($uri_val){
        switch($uri_val) {
            case 'goods/detail':
                $metaOgTitle = "[".@$goods['BRAND_NM']."] ".@$goods['GOODS_NM'];
                $metaOgImg = @$goods['IMG_URL'];
                break;

            case 'magazine/detail':
                $metaOgTitle = @$detail['TITLE'];
                $metaOgImg = @$detail['IMG_URL'];
                break;

            case 'goods/brand':
                $metaOgTitle = @$brand['BRAND_NM'];
                $metaOgImg = (@$brand['WEB_BRAND_IMG_URL']==''?@$brand['BANNER_IMG_URL']:@$brand['WEB_BRAND_IMG_URL']);
                break;

            case 'goods/event':
                $metaOgTitle = @$event['TITLE'];
                $metaOgImg = @$event['EVENT_IMG_URL'];
                break;

            default	:
                break;
        }
    }

    if($metaOgImg == '') {/*$metaOgImg = "http://www.etah.co.kr/assets/images/common/etah_image.png";*/$metaOgImg = "http://ui.etah.co.kr/assets/images/data/etah_image.png";}
    ?>
    <meta property="og:title"           content="<?=$metaOgTitle?>"/>
    <meta property="og:type"            content="website"/>
    <meta property="og:url"             content="<?=$metaOgUrl?>"/>
    <meta property="og:image"           content="<?=$metaOgImg?>"/>
    <meta property="og:site_name"       content="ETAHOME"/>
    <meta property="fb:app_id"          content=""/>
    <meta property="og:description"     content="홈&펫&직구, 국내부터 해외까지 가구/소품/주방 등 홈퍼니싱 전문 온라인샵!">


    <!--		<meta name="naver-site-verification" content="54a86b68cc34cc4188be49ba4ad9fcf4dbd1827d"/>-->
    <meta name="naver-site-verification" content="73746fe4565e9c13ab3b0443ab5671f7a6c8252c" />
    <!--<meta name="naver-site-verification" content="73746fe4565e9c13ab3b0443ab5671f7a6c8252c"/>-->
    <meta name="google-site-verification" content="YO5SBGWikBH0VeqBzn8LEr0xUO4MNQyHqu_Gc5Oekqo" />

    <link rel="canonical" href="<?=base_url()?>"><!-- 네이버 서치 어드바이저 선호 링크 -->
    <link rel="stylesheet" href="/assets/css/common.css?ver=2.7.8">
    <link rel="shortcut icon" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon.ico">
    <link rel="apple-touch-icon" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon.png">
    <link rel="apple-touch-icon" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-60.png"><!-- 비 레티나 -->
    <link rel="apple-touch-icon" sizes="76x76" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-76.png"><!-- 아이패드 -->
    <link rel="apple-touch-icon" sizes="120x120" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-60@2x.png"><!-- 레티나 기기 -->
    <link rel="apple-touch-icon" sizes="152x152" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-76@2x.png"><!-- 레티나 패드 -->
    <link rel="apple-touch-icon-precomposed" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-60.png"><!-- 구형/ 안드로이드 -->
    <!--[if IE 8]>
    <link rel="stylesheet" href="/assets/css/iehack.css">
    <![endif]-->
    <span itemscope="" itemtype="http://schema.org/Organization">
            <link itemprop="url" href="<?=base_url()?>">
            <a itemprop="sameAs" href="https://blog.naver.com/etah_blog"></a>
            <a itemprop="sameAs" href="https://www.instagram.com/etahcompany/"></a>
            <a itemprop="sameAs" href="https://www.facebook.com/etahcompany"></a>
            <a itemprop="sameAs" href="https://www.youtube.com/channel/UCVEBa0D-0coHeJu9LYO5l0Q?view_as=subscriber"></a>
        </span>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="/assets/js2/goods_func.js"></script>
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>

    <!-- 크롬에 버튼 테두리 없애기 -->
    <style>button {outline:none;}input {outline:none;}
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: none; opacity: 0.7; background-color: #ddd; z-index: 9999}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 9999}
    </style>
    <!--네이버 애널리틱스 스크립트 -->
    <script type="text/javascript" src="https://wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "47933926cdee40";
        wcs_do();
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120204887-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-120204887-1');
    </script>
    <script type="text/javascript">
        var HOST = "<?=$_SERVER['HTTP_HOST'] ?>";
        var URI= "<?= $_SERVER['REQUEST_URI'] ?>";
        var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson','iPad','MI','hp-tablet');

        for (var word in mobileKeyWords) {if (navigator.userAgent.match(mobileKeyWords[word]) != null){if(HOST == "staging.etah.co.kr") {if(URI != "") {location.href = "http://stagingm.etah.co.kr" + URI;}
        else {location.href = "http://stagingm.etah.co.kr/";}} else if(HOST == "etah.co.kr" || HOST == "www.etah.co.kr") {if(URI != "") {
            if(URI == '/category/main/10000000') URI = '/category/main?cate_cd=10000000';
            else if(URI == '/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
            location.href = "http://m.etah.co.kr" + URI;
        }
        else {location.href = "http://m.etah.co.kr";}}}}
    </script>
    <script>
        function execDaumPostcode(pcode, pcode2, paddr1, paddr2, paddr3) {
            new daum.Postcode({oncomplete: function(data) {var fullAddr = '';var extraAddr = '';if (data.userSelectedType === 'R') {fullAddr = data.roadAddress;} else {fullAddr = data.jibunAddress;}
                    console.log(data.buildingCode);console.log(data);if(data.userSelectedType === 'R'){if(data.bname !== ''){extraAddr += data.bname;}if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);}fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');}document.getElementById(pcode).value = data.zonecode;if(pcode2 !== ''){
                        document.getElementById(pcode2).value = data.zonecode;}document.getElementById(paddr1).value = fullAddr;if(paddr2 !== ''){document.getElementById(paddr2).value = fullAddr;}document.getElementById(paddr3).focus();
                }}).open();}
    </script>
</head>

<body <?=isset($main) ? "data-showroom='true' data-collection='true' data-newitem='true'" : ""?> >
<div id="loading">
    <img id="loading-image" src="/assets/js2/loading.gif" width="150" alt="Loading..." />
</div>
<div class="wrap<?=isset($add_wrap) ? $add_wrap : ''?> <?=isset($wrap__vip) ? $wrap__vip : ''?>">
    <div class="header">
        <div class="min_area">
            <!-- logo // -->
            <h1 class="etah_logo">
                <a href="/">
                    <span class="spr-common spr_logo"></span>ETAHOME
                    <span class="spr-common spr_logo_t"></span>
                    <span class="spr-common spr_logo_a"></span>
                    <span class="spr-common spr_logo_text"></span>
                    <!--<img src="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/assets/images/common/etahome_ko_W_.png" />-->
                </a>
            </h1>
            <!-- // logo -->

            <!-- user menu // -->
            <div class="user_menu">
                <ul class="user_menu_list">
                    <?php if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST'){	?>
                        <li class="user_menu_item"><!--<?php echo $this->session->userdata('EMS_U_NAME_');?>--><?php echo $this->session->userdata('EMS_U_ID_');?>님 <!--환영합니다!--></li>
                        <li class="user_menu_item"><a href="/member/logout">로그아웃</a></li>
                        <li class="user_menu_item"><a href="/mywiz">마이페이지</a></li>
                    <?php } else{?>
                        <li class="user_menu_item"><a href="https://<?=$_SERVER['HTTP_HOST']?>/member/login">로그인</a></li>
                        <li class="user_menu_item"><a href="https://<?=$_SERVER['HTTP_HOST']?>/member/member_join1">회원가입</a></li>
                    <?php }?>

                    <li class="user_menu_item"><a href="/customer/">고객센터</a></li>
                </ul>
            </div>
            <!-- // user menu -->

            <!-- search // -->
            <div class="search">
                <form action="">
                    <fieldset class="search_form">
                        <legend>검색</legend>
                        <input type="text"	 id="head_search" class="search_input" placeholder="Search" onKeyPress="javascript:if(event.keyCode == 13){ search(''); return false;}" >
                        <button type="button" class="search_submit" title="검색" onClick="javaScript:search('');"><span class="spr-common"></span></button>
                    </fieldset>
                </form>
            </div>
            <!-- // search -->
        </div>

        <!-- GNB // -->
        <div class="gnb" id="gnb">
            <ul class="gnb_list">
                <li class="gnb_item">
                    <a href="<?=base_url()?>category/main/10000000" class="gnb_link">카테고리</a>
                    <!-- 활성화시 클래스 active 추가 -->
                    <div class="gnb_sub" style="display: none;">
                        <ul class="gnb_sub_list1">
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/10000000" class="gnb_sub_link1">가구</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10010000" class="gnb_sub_link">침대/매트리스</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10020000" class="gnb_sub_link">기능성침대</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10030000" class="gnb_sub_link">화장대</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10040000" class="gnb_sub_link">옷장/드레스룸</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10050000" class="gnb_sub_link">서랍장</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10060000" class="gnb_sub_link">수납장</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10070000" class="gnb_sub_link">식탁/테이블</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10080000" class="gnb_sub_link">의자</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10090000" class="gnb_sub_link">소파</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10100000" class="gnb_sub_link">거실가구</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10110000" class="gnb_sub_link">책상</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10120000" class="gnb_sub_link">서재용 의자</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10130000" class="gnb_sub_link">책장/책꽂이</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10140000" class="gnb_sub_link">키즈가구</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/10150000" class="gnb_sub_link">DIY반제품가구</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/423" class="category_banner">
                                            <img src="<?=base_url()?>assets/images/common/gnb_banner_01.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/11000000" class="gnb_sub_link1">인테리어소품</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11020000" class="gnb_sub_link">액자/월데코</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11030000" class="gnb_sub_link">명화/특수 액자</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11070000" class="gnb_sub_link">시계</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11010000" class="gnb_sub_link">빈액자</a>
                                        </li>
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/11040000" class="gnb_sub_link">사진 액자</a>-->
                                        <!--                                                </li>-->

                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11050000" class="gnb_sub_link">거울</a>
                                        </li>
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/11060000" class="gnb_sub_link">시계</a>-->
                                        <!--                                                </li>-->
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11100000" class="gnb_sub_link">토이</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11090000" class="gnb_sub_link">소품/조화</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11080000" class="gnb_sub_link">캔들/퍼퓸/디퓨져</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/11110000" class="gnb_sub_link">크리스마스/기타</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/474" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_02_190220.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/14000000" class="gnb_sub_link1">조명</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/14120000" class="gnb_sub_link">스탠드</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/14010000" class="gnb_sub_link">거실/방 조명</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/14030000" class="gnb_sub_link">펜던트/주방조명</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/14050000" class="gnb_sub_link">센서등/현관등</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/14090000" class="gnb_sub_link">벽등</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/14140000" class="gnb_sub_link">LED전구/램프/전기부품</a>
                                        </li>
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/14150000" class="gnb_sub_link">생활가전</a>-->
                                        <!--                                                </li>-->
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/14160000" class="gnb_sub_link">주방가전</a>-->
                                        <!--                                                </li>-->
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/14170000" class="gnb_sub_link">계절가전</a>-->
                                        <!--                                                </li>-->
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/372" class="category_banner">
                                            <img src="<?=base_url()?>assets/images/common/gnb_banner_04.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/19000000" class="gnb_sub_link1">주방</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19060000" class="gnb_sub_link">컵/물병/보온병</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19050000" class="gnb_sub_link">커피/차 용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19070000" class="gnb_sub_link">칼/도마/주방용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19080000" class="gnb_sub_link">주방잡화/패브릭</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19030000" class="gnb_sub_link">식기/식기세트</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19090000" class="gnb_sub_link">밀폐/보관용기</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19100000" class="gnb_sub_link">수저/포크/세트</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19020000" class="gnb_sub_link">후라이팬/웍</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19010000" class="gnb_sub_link">냄비/솥/주전자</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19040000" class="gnb_sub_link">와인/주류용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/19130000" class="gnb_sub_link">유아식기/빨대컵</a>
                                        </li>
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/19120000" class="gnb_sub_link">식품</a>-->
                                        <!--                                                </li>-->
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/394" class="category_banner">
                                            <img src="<?=base_url()?>assets/images/common/gnb_banner_08.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/22000000" class="gnb_sub_link1">식품</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22010000" class="gnb_sub_link">차/커피/음료</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22020000" class="gnb_sub_link">쨈/꿀/조미료</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22030000" class="gnb_sub_link">베이커리/베이킹</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22040000" class="gnb_sub_link">스낵/견과</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22050000" class="gnb_sub_link">헬스/다이어트식품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22060000" class="gnb_sub_link">쌀/잡곡</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22070000" class="gnb_sub_link">채소</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22080000" class="gnb_sub_link">축산물/계란</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22090000" class="gnb_sub_link">수산물/건어물</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22100000" class="gnb_sub_link">김치/반찬</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22110000" class="gnb_sub_link">과일</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/22120000" class="gnb_sub_link">간편식/냉장/냉동</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/507" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_05_190220.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/21000000" class="gnb_sub_link1">디지털/가전</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/21010000" class="gnb_sub_link">계절가전</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/21020000" class="gnb_sub_link">생활가전</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/21030000" class="gnb_sub_link">주방가전</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/21040000" class="gnb_sub_link">디지털기기</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/list/21020200" class="category_banner">
                                            <img src="<?=base_url()?>assets/images/common/gnb_banner_13.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/17000000" class="gnb_sub_link1">생활/욕실</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17020000" class="gnb_sub_link">옷걸이</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17080000" class="gnb_sub_link">생활잡화</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17090000" class="gnb_sub_link">여행/캠핑</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17100000" class="gnb_sub_link">세제/세정제</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17040000" class="gnb_sub_link">휴지통/청소용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17030000" class="gnb_sub_link">정리함</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17010000" class="gnb_sub_link">행거/선반</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17050000" class="gnb_sub_link">건조대/바스켓</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/17070000" class="gnb_sub_link">욕실용품</a>
                                        </li>
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/17100000" class="gnb_sub_link">뷰티</a>-->
                                        <!--                                                </li>-->
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/brand/EB00583" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_07_190220.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/15000000" class="gnb_sub_link1">침구</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15040000" class="gnb_sub_link">베개/침구/커버</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15020000" class="gnb_sub_link">다운 침구</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15030000" class="gnb_sub_link">침구세트</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15050000" class="gnb_sub_link">솜류</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15080000" class="gnb_sub_link">계절침구</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15070000" class="gnb_sub_link">러그/카페트</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15090000" class="gnb_sub_link">홈패브릭 소품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15060000" class="gnb_sub_link">커튼/블라인드</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/15110000" class="gnb_sub_link">맞춤제작카페트</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/brand/EB01212" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_08_190130.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/23000000" class="gnb_sub_link1">뷰티</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <!--                                                <li class="gnb_sub_item">-->
                                        <!--                                                    <a href="--><?//=base_url()?><!--goods/mid_list/23010000" class="gnb_sub_link">메이크업</a>-->
                                        <!--                                                </li>-->
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/23020000" class="gnb_sub_link">스킨케어</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/23030000" class="gnb_sub_link">바디/헤어케어</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/23040000" class="gnb_sub_link">뷰티기기/소품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/23050000" class="gnb_sub_link">헬스케어</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/23060000" class="gnb_sub_link">다이어트케어</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/508" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_09_190220.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/13000000" class="gnb_sub_link1">DIY</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13010000" class="gnb_sub_link">철물/하드웨어</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13020000" class="gnb_sub_link">선반/찬넬/앵글</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13030000" class="gnb_sub_link">도어락/손잡이</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13040000" class="gnb_sub_link">접착/실링/광택</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13060000" class="gnb_sub_link">도색/페인트</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13070000" class="gnb_sub_link">수공구</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13080000" class="gnb_sub_link">전동공구/계측기</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13110000" class="gnb_sub_link">벽지/도배</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13120000" class="gnb_sub_link">인테리어필름/시트지</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13130000" class="gnb_sub_link">타일/파벽돌</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13140000" class="gnb_sub_link">바닥/몰딩</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13150000" class="gnb_sub_link">작업/안전/소화기</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13160000" class="gnb_sub_link">환기/배기</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/13170000" class="gnb_sub_link">그래픽스티커</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/brand/EB00360" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_10_190109.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>category/main/16000000" class="gnb_sub_link1">가드닝</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/16010000" class="gnb_sub_link">가드닝소품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/16020000" class="gnb_sub_link">화분</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/16030000" class="gnb_sub_link">플라워</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/mid_list/16040000" class="gnb_sub_link">화병</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/brand/EB02553" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_11_190109.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/24010000" class="gnb_sub_link1">에타홈클래스</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="gnb_item">
                    <a href="<?=base_url()?>goods/best_item" class="gnb_link">베스트</a>
                </li>
                <li class="gnb_item">
                    <a href="<?=base_url()?>goods/event/586" class="gnb_link">특가</a>
                </li>


                <li class="gnb_item">
                    <a href="<?=base_url()?>category/main/20000000" class="gnb_link ico1">직구샵</a>
                    <div class="gnb_sub" style="display: none;">
                        <ul class="gnb_sub_list1">
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20010000" class="gnb_sub_link1">가구</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20020000" class="gnb_sub_link1">인테리어소품</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20030000" class="gnb_sub_link1">DIY</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20040000" class="gnb_sub_link1">조명/가전</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20050000" class="gnb_sub_link1">침구</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20060000" class="gnb_sub_link1">가드닝</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20070000" class="gnb_sub_link1">생활/욕실</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20080000" class="gnb_sub_link1">반려동물</a>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/20090000" class="gnb_sub_link1">주방</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!--<li class="gnb_item">
                    <a href="<?/*=base_url()*/?>goods/event/234 " class="gnb_link">MD 픽!</a>
                </li>-->
                <li class="gnb_item">
                    <a href="<?=base_url()?>magazine" class="gnb_link">컨텐츠</a>
                </li>
                <!--<li class="gnb_item">
                    <a href="<?/*=base_url()*/?>goods/special" class="gnb_link">클러프트관</a>
                </li>-->


                <li class="gnb_item">
                    <a href="<?=base_url()?>category/main/18000000" class="gnb_link">펫</a>
                    <div class="gnb_sub" style="display: none;">
                        <ul class="gnb_sub_list1">
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/18050000" class="gnb_sub_link1">애견용품</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050100" class="gnb_sub_link">브랜드별사료</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050200" class="gnb_sub_link">수제사료</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050300" class="gnb_sub_link">수제간식</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050400" class="gnb_sub_link">육포/져키</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050500" class="gnb_sub_link">껌/간식</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050600" class="gnb_sub_link">영양제</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050700" class="gnb_sub_link">의약부외품/케어용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050700" class="gnb_sub_link">위생/배변용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050900" class="gnb_sub_link">목욕용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051000" class="gnb_sub_link">미용용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051100" class="gnb_sub_link">식기</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051200" class="gnb_sub_link">물병/사료통</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051300" class="gnb_sub_link">애견용집</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051400" class="gnb_sub_link">계단/펜스/매트</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051500" class="gnb_sub_link">이동가방</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051600" class="gnb_sub_link">이동장/캐리어/기타</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051700" class="gnb_sub_link">애견장난감</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051800" class="gnb_sub_link">훈련용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18051900" class="gnb_sub_link">애견의류</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18052000" class="gnb_sub_link">애견신발/액세서리</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18052100" class="gnb_sub_link">목줄/이름표</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/327" class="category_banner">
                                            <img src="<?=base_url()?>assets/images/common/gnb_banner_09_1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/18060000" class="gnb_sub_link1">고양이용품</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060100" class="gnb_sub_link">브랜드별사료</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060200" class="gnb_sub_link">캔/파우치 사료</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060300" class="gnb_sub_link">간식/캣닙</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060400" class="gnb_sub_link">영양제</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="--><?=base_url()?><!--goods/list/18050500" class="gnb_sub_link">껌/간식</a>
                                        </li>=>제외
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18050600" class="gnb_sub_link">영양제</a>
                                        </li>=>제외
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060500" class="gnb_sub_link">고양이모래</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060600" class="gnb_sub_link">고양이화장실</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060700" class="gnb_sub_link">고양이장난감</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060800" class="gnb_sub_link">스크래처</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18060900" class="gnb_sub_link">캣타워</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18061000" class="gnb_sub_link">이동가방/캐리어</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18061100" class="gnb_sub_link">고양이집</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18061200" class="gnb_sub_link">식기/물병/사료통</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18061300" class="gnb_sub_link">목욕/위생용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18061400" class="gnb_sub_link">고양이패션/액세서리</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/305" class="category_banner">
                                            <img src="<?=base_url()?>assets/images/common/gnb_banner_10_1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/18010000" class="gnb_sub_link1">소동물/관상어</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18010100" class="gnb_sub_link">소동물/기타동물용품</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18010200" class="gnb_sub_link">관상어용품</a>
                                        </li>

                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/253" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_14_190220.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                            <li class="gnb_sub_item1">
                                <a href="<?=base_url()?>goods/mid_list/18070000" class="gnb_sub_link1">반려동물 서비스</a>
                                <div class="gnb_sub2" style="display: none;">
                                    <ul class="gnb_sub_list">
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18070100" class="gnb_sub_link">반려동물 장례서비스</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18070200" class="gnb_sub_link">반려동물 스튜디오</a>
                                        </li>
                                        <li class="gnb_sub_item">
                                            <a href="<?=base_url()?>goods/list/18070300" class="gnb_sub_link">반려동물 호텔링</a>
                                        </li>
                                    </ul>
                                    <div class="category_banner_area">
                                        <a href="<?=base_url()?>goods/event/511" class="category_banner">
                                            <img src="http://ui.etah.co.kr/assets/images/common/gnb_banner_15_190220.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="gnb_sub_bg"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>



            </ul>
        </div>
        <!-- GNB // -->
    </div>
    <script type="text/javascript">
        //=======================================
        // trim 함수
        //=======================================
        function trim(s){
            s = s.replace(/^\s*/,'').replace(/\s*$/,'');
            return s;
        }
        //====================================
        // 검색
        //====================================
        function search(val)
        {
            var page = 1;
            var keyword = document.getElementById("head_search").value;
            var r_keyword = "";
            var cate_cd = "";
            if(val == 'r'){if($('#r_keyword').val()){r_keyword = document.getElementById("r_keyword").value+"||"+document.getElementById("contents_search").value;}else{
                r_keyword = document.getElementById("keyword").value+"||"+document.getElementById("contents_search").value;}//검색어가 없을때
                if(!trim(r_keyword)) return false;}else{
                //검색어가 없을때
                if(!trim(keyword)) return false;}
            var param = "";
//				param += "page="	+ page;
//				param += "&keyword="+ keyword;
//				param += "&r_keyword="+ r_keyword;
//				param += "&cate_cd="+ cate_cd;
//				document.location.href = "/goods2/goods_search/"+page+"?"+param;

            document.location.href = "/goods2/goods_search?keyword="+keyword;
        }
        //=====================================
        // action 클릭시
        //=====================================
        function jsGoodsAction(mode, share, val, img, title){
            var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
            //CART 담기
            if(mode == 'C'){
//					if(SESSION_ID == ''){
//						if(confirm("")){
//							location.href = '/member/login';
//						}
//					}
            }
            //WISH LIST 담기
            else if(mode == 'W'){
                if(SESSION_ID == ''){
                    setTimeout(function(){
                        if(confirm("로그인 후에 이용하실 수 있습니다. 로그인 하시겠습니까?")){
                            location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                            return false;
                        }
                        else{
                            return false;
                        }
                    },100);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '/goods/goods_action',
                        dataType: 'json',
                        async : true,
                        data: {	mode : mode, goods_cd : val },
                        error: function(res) {
                            alert('Database Error');
                        },
                        success: function(res) {
                            if(res.status == 'ok'){
                                alert('관심상품에 등록되었습니다.');
                                location.reload();
                            }
                            else{
                                if(res.message) alert(res.message);
                            }
                        }
                    })
                }
            }
            //SNS 공유
            else if(mode == 'S'){
                var url = '<?=base_url()?>goods/detail/'+val;
                //페이스북
                if(share == 'F'){
                    window.open('/goods/share_facebook?title='+title+'&img='+img+'&goods_code='+val,"","width=550, height=300, status=yes, resizable=yes, scrollbars=no");
                }
                //인스타그램
                else if(share == 'I'){
                }
                //카카오스토리
                else if(share == 'K'){
                    shareStory(url,title);
                }
                //핀터레스트
                else if(share == 'P'){
                    window.open("http://www.pinterest.com/pin/create/button/?url="+url+"&media="+img+"&description="+"[ETAHOME] "+encodeURIComponent(title),"","width=800, height=300, status=yes, resizable=no, scrollbars=no");
                }
            }
        }
        //=====================================
        // 카카오스토리 공유하기
        //=====================================
        function shareStory(url, text) {
            Kakao.Story.share({
                url: url,
                text: text
            });
        }
    </script>

    <script>
        //알림창 딜레이 0.15초 (크롬에서 알림창이 그냥 닫혀버림)
        function alertDelay(message) {
            timeout = setTimeout(function(){
                alert(message);
            }, 150);
        }
    </script>