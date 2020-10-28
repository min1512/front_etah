<div class="footer">
    <ul class="footer_menu_list">
        <li class="footer_menu_item">
            <a href="/footer/about_etah">에타홈 소개</a>
        </li>
        <li class="footer_menu_item">
            <a href="/footer/use_clause">이용약관</a>
        </li>
        <li class="footer_menu_item">
            <a href="/footer/personal_info">개인정보취급방침</a>
        </li>
        <li class="footer_menu_item">
            <a href="/footer/inquiry_for_office">입점/제휴문의</a>
        </li>
        <li class="footer_menu_item">
            <a href="/customer/notice">공지사항</a>
        </li>
        <li class="footer_menu_item">
            <a href="#">고객센터 : Tel. 1522-5572, 평일 10:00~17:30 (점심시간 : 12:00~13:00), 주말, 공휴일 휴무</a><!--<span class="spr-common spr_bg_bar_02"></span>-->
        </li>
    </ul>

    <ul class="footer_sns_list">
        <li class="footer_sns_item">
            <a href="https://www.facebook.com/etahome.co.kr" title="페이스북" target="_blank" class="footer_sns_link ico_facebook spr-common"></a>
        </li>
        <li class="footer_sns_item">
            <a href="https://www.instagram.com/etahome_kr" title="인스타그램" target="_blank" class="footer_sns_link ico_instagram spr-common"></a>
        </li><!-- https://www.instagram.com/etahcompany/ -->
        <li class="footer_sns_item">
            <a href="https://blog.naver.com/etah_blog" title="네이버 에타홈 블로그" target="_blank" class="footer_sns_link ico_blog2 spr-common"></a>
        </li>
        <li class="footer_sns_item">
            <a href="https://pf.kakao.com/_fXkqC" title="카카오톡" target="_blank" class="footer_sns_link ico_kakao spr-common"></a>
        </li>
        <li class="footer_sns_item">
            <a href="https://www.youtube.com/etahome" title="유튜브" target="_blank" class="footer_sns_link ico_youtube spr-common"></a>
        </li><!-- https://www.youtube.com/channel/UCVEBa0D-0coHeJu9LYO5l0Q?view_as=subscriber -->
        <li class="footer_sns_item">
            <a href="https://tv.naver.com/etah" title="네이버 에타홈" target="_blank" class="footer_sns_link ico_naver_tv spr-common"></a>
        </li>
    </ul>
    <ul class="footer_info">
        <li class="footer_info_item">(주)에타<span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item">대표이사 : 김의종<span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item">서울특별시 성동구 성수이로 22길 37, 아크밸리지식산업센터 906호 에타홈 (ETAH, 37, Seongsui-ro 22-gil, Seongdong-gu, Seoul, Republic of Korea (04798)<span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item">사업자등록번호 : 423-81-00385<span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item">통신판매업 신고번호 : 2020-서울성동-00699 호</li>
    </ul>
    <ul class="footer_info">
        <li class="footer_info_item">건강기능식품판매영업신고증 : 제2018-0106933호 <span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item">의료기기판매영업신고증 : 제8227호 <span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item">수입식품등 인터넷 구매대행업 영업등록 : 제 20180003396호 <span class="spr-common spr_bg_bar_02"></span></li>
    </ul>
    <ul class="footer_info">
        <li class="footer_info_item">입점/제휴 문의 : <a href="mailto:admin@etah.co.kr">admin@etah.co.kr</a><span class="spr-common spr_bg_bar_02"></span></li>
        <li class="footer_info_item"><a href="mailto:admin@etah.co.kr" class="footer-menu-link">대량구매문의 (02-569-6227)</a></li><!-- (02-569-6228) -->
        <li class="footer_info_item">
            <button type="button" class="footer_info_btn" onclick="window.open('http://www.ftc.go.kr/info/bizinfo/communicationViewPopup.jsp?wrkr_no=4238100385','사업자정보조회','width=750,height=700,location=no,status=no,scrollbars=yes');">사업정보확인</button>
        </li>
    </ul>
    <p class="copyright">
        copyright ⓒ 2016 etah. All rights reserved.
        <!--copyright ⓒ 2016 etahome. All rights reserved.-->
    </p>
</div>


<script src="/assets/js/common.js?ver=1.0"></script>
<script src="/assets/js2/jquery.cookie.js"></script>
<script type="text/javascript" src="/assets/js2/iframeheight.js"></script>
<script src="/assets/js/jquery.lazyload.min.js"></script>

<!-- 아이프레임 높이 자동 조정 js -->
<script type="text/javascript">
    $(function(){
        $('.iframe').iframeHeight({

            resizeMaxTry         : 2,
            resizeWaitTime       : 300,
            minimumHeight        : 100,
            defaultHeight        : 100,
            heightOffset         : 90,
            exceptPages          : "",
            debugMode            : false,
            visibilitybeforeload : true,
            blockCrossDomain     : true,
            externalHeightName   : "bodyHeight",
            onMessageFunctionName: "getHeight",
            domainName           : "*",
            watcher              : true,

            watcherTime          : 400

        });
    });
</script>

<script type="text/javascript">
    $(function()
    { // document ready

        /* ---------------------------------------------------------------------------
            # etahUi.gnb(	_option, _callback );
            - _option : Object or Function ( _option 을 생략하고 _callback 만 전달 가능. )
            - _callback : Function
            ## default setting
            {
                box : $('#gnb'),
                depth1 : $('#gnb').find('a.gnb_link'),
                sub_box : $('#gnb').find('div.gnb_sub')
            }
        --------------------------------------------------------------------------- */
        etahUi.gnb(); // gnb

        /* ---------------------------------------------------------------------------
            # etahUi.quick ( _option );
            - _option : Object

            ## default setting
            {
                box : $('#quick'),
                area : $('#quick').find('.quick_box'),
                contents : $('#quick').find('.quick_contents'),
                q_btns : $('#quick').find('li.quick_menu_item'),
                close : $('#quick').find('.cart_close')
            }
        --------------------------------------------------------------------------- */
        etahUi.quick(); // quick

        // window resize
        etahUi.layoutController();

        // toggle contetns
        etahUi.toggleUi();

        // layer controll
        etahUi.layerController();

        // 리스트 페이지 버튼
        etahUi.lpBtnView();

        // 2016.06.10 lnb 관련 스크립트 실행 구문 추가.
        if ($('#nav').get(0) !== undefined) {
            etahUi.toggleMenu();
        }

    });

    $(window).on('load', function() { // window load

        // addScrollEvent.
        $(window).on('scroll', etahUi.quickScroll); // quick menu scroll


        // 상품 오버시 기능 버튼 활성화.
        etahUi.goodsAction();

        //가격 옵션 초기값
        $('.limit_price').html($('#formMailSelect3').val());
    });

    //옵션 - 가격 실시간 값
    var rangeSlider = function() {
        $('#formMailSelect3').on('input', function() {
            $('.limit_price').html(this.value);
        });
    };

    rangeSlider();

//    2020.02.27 주석처리
//    $('#srp-cate').hide();
//    $('.srp-cate-tit').click(function(){
//        $('#srp-cate').toggle();
//    });
//
//    //srp-cate
//    (function($) {
//        var srpCateUI = {
//            click: function(target, speed) {
//                var _self = this,
//                    $target = $(target);
//                _self.speed = speed || 300;
//                $target.each(function() {
//                    if (findChildren($(this))) {
//                        return;
//                    }
//                    $(this).addClass('noDepth');
//                });
//
//                function findChildren(obj) {
//                    return obj.find('> ul').length > 0;
//                }
//                $target.on('click', 'a', function(e) {
//                    e.stopPropagation();
//                    var $this = $(this),
//                        $depthTarget = $this.next(),
//                        $siblings = $this.parent().siblings();
//                    $this.parent('li').find('ul li').removeClass('on');
//                    $siblings.removeClass('on');
//                    $siblings.find('ul').slideUp(250);
//                    if ($depthTarget.css('display') == 'none') {
//                        _self.activeOn($this);
//                        $depthTarget.slideDown(_self.speed);
//                    } else {
//                        $depthTarget.slideUp(_self.speed);
//                        _self.activeOff($this);
//                    }
//                })
//            },
//            activeOff: function($target) {
//                $target.parent().removeClass('on');
//            },
//            activeOn: function($target) {
//                $target.parent().addClass('on');
//            }
//        }; // Call srpCateUI
//        $(function() {
//            srpCateUI.click('#srp-cate li', 300)
//        });
//    }(jQuery));


    //====================================
    // 인쇄
    //====================================
    function printDiv(divName)
    {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>

<!-- 2017-02-23 추가 -->
<!-- 공통 적용 스크립트 , 모든 페이지에 노출되도록 설치. 단 전환페이지 설정값보다 항상 하단에 위치해야함 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"> </script>
<script type="text/javascript">
    if (!wcs_add) var wcs_add={};
    wcs_add["wa"] = "s_51fd0fb4ae2b";
    if (!_nasa) var _nasa={};
    wcs.inflow();
    wcs_do(_nasa);
</script>

<!-- WIDERPLANET  SCRIPT START 2017.3.29 -->
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",   /*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
						*주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",	/*광고주 코드*/
                ty:"Home",	/*트래킹태그 타입*/
                device:"web"	/*디바이스 종류 (web 또는 mobile)*/

            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET  SCRIPT END 2017.3.29 -->

<? if(@$Nshopping == 'order'){?>

    <script type="text/javascript">
        // Account ID 적용
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "s_51fd0fb4ae2b";

        // 추가 정보로 넣을 객체 생성
        var _nao={};

        // 유입여부 판단
        if (wcs.isCPA) {
            // 주문채널 정보 추가
            _nao["chn"] = "AD";
            // 주문 정보 추가 - 복수일 경우 콤마(,)로 구분
            _nao["order"]=[<? $idx1=0; $idx2=0; foreach($refer as $goods_grp){ foreach($goods_grp as $row){ if(($idx1 != 0) || ($idx2 != 0)){?>, <?}?>{"oid":<?=$order_no?>, "poid":<?=$row['ORDER_REFER_NO']?>, "pid":<?=$row['GOODS_CD']?>, "name":"<?=$row['GOODS_NM']?>", "cnt":<?=$row['ORD_QTY']?>, "price":<?=$row['TOTAL_PRICE']?>}<? $idx2.=1;}$idx1.=1;}?>];
            // wcs.CPAOrder 함수 호출 - _nao를 인자로 입력함.
            wcs.CPAOrder(_nao);
        }

    </script>

<?} else {?>
    <script type="text/javascript">
        // Account ID 적용
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "s_51fd0fb4ae2b";
        //유입 추적 함수 호출
        wcs.inflow("etahome.co.kr");
    </script>

<?}?>

</body>

</html>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K9B5N2X');</script>
<!-- End Google Tag Manager -->