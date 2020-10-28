
<script type="text/javascript">
    //========================================
    //오늘 하루 창 닫기
    //========================================
    $(document).ready(function() {
        if($.cookie('layer_main_pop01') != 'hidden'){
            $('#layer_main_pop01').show();
            $('#layer_main_pop01').css('visibility','visible');
        }else{
            $('#layer_main_pop01').hide();
        }

        $('#full_layer_close').click(function() {
            var chkd = $("#formMainClose").is(":checked");
            if(chkd){
                $.cookie('layer_main_pop01', 'hidden', {expires : 1});
            }
            $('#layer_main_pop01').hide();
        });
    });

    //=====================================
    // Weekly Theme, Brand Focus 탭 변경
    //=====================================
    function changeItemBrandTab(val){
        var brandCont = $('#newBrand');
        if (val == 'B')
        {
            $('#main_tab_brand').addClass('active');
            $('#main_tab_item').removeClass('active');
            if (!brandCont.data('html'))
            {
                brandCont.html($('#newBrandHtml').html());
                brandCont.data('html', true);
            }
            $('#newBrand').css("display", "");
            $('#newItem').css("display", "none");

        }
        else
        {
            $('#main_tab_item').addClass('active');
            $('#main_tab_brand').removeClass('active');
            $('#newItem').css("display", "");
            $('#newBrand').css("display", "none");
        }
    }

    //=====================================
    // 브랜드 탭 변경
    //=====================================
    function changeBrandTab(idx) {
        for(i=1; i<5; i++){
            if(i == idx){
                $("#mainBrandCont0"+i).css('display','block');
                $("#main_brand_tab_item_0"+i).addClass('active');
            }else{
                $("#mainBrandCont0"+i).css('display','none');
                $("#main_brand_tab_item_0"+i).removeClass ('active');
            }
        }
    }

    //=====================================
    // Weekly Theme, Brand Focus 랜덤 설정
    //=====================================
    function getRandomArbitrary(min, max) {
        return Math.random() * ( max - min ) + min;
    }
</script>   
            <div class="quick" id="quick">
                <div class="quick_menu">
                    <ul class="quick_menu_list">
                        <li class="quick_menu_item">
                            <a href="#cart_area" onclick="changeTitle('cart','장바구니');">
                                <span class="spr-common spr-bag"></span>
                                <span class="counter">0</span>
                            </a>
                        </li>
                        <li class="quick_menu_item">
                            <a href="#wish_area" onclick="changeTitle('wish','관심상품');">
                                <span class="spr-common spr-heart"></span>
                                <span class="counter">0</span>
                            </a>
                        </li>
                        <li class="quick_menu_item">
                            <a href="#view_area" onclick="changeTitle('view','최근 본 상품');">
                                <span class="spr-common spr-clock"></span>
                                <span class="counter">0</span>
                            </a>
                        </li>
                    </ul>
                    <a href="#top" type="button" class="quick_top">
                        <span class="spr-common arrow_top"></span> TOP
                    </a>
                    <div class="quick_menu_bg"></div>
                </div>
                <div class="quick_box" style="right:-293px;">
                    <h3 class="cart_title" id="title_quick">장바구니 <a href="/cart" class="spr-common spr_btn_go cart_go" title="장바구니 바로가기"></a></h3>
                    <a href="#close" class="cart_close spr-common spr-close" title="장바구니 닫기"></a>
                    <ul class="quick_menu_list quick_menu_list__inner">
                        <li class="quick_menu_item active">
                            <a href="#cart_area" onclick="changeTitle('cart','장바구니');">
                                <span class="spr-common spr-bag"></span>
                                <span class="counter">0</span>
                                <span class="spr-common spr-bgcircle"></span>
                            </a>
                        </li>
                        <li class="quick_menu_item">
                            <a href="#wish_area" onclick="changeTitle('wish','관심상품');">
                                <span class="spr-common spr-heart"></span>
                                <span class="counter">0</span>
                                <span class="spr-common spr-bgcircle"></span>
                            </a>
                        </li>
                        <li class="quick_menu_item">
                            <a href="#view_area" onclick="changeTitle('view','최근 본 상품');">
                                <span class="spr-common spr-clock"></span>
                                <span class="counter">0</span>
                                <span class="spr-common spr-bgcircle"></span>
                            </a>
                        </li>
                    </ul>
                    <div class="quick_contents" id="cart_area" style="display:none;">
                                                    <p class="quick_prd_none">해당 상품이 없습니다.</p>
                                                <div class="page" id="cart_page">
                            <ul class="page_list">
                                <li class="page_item active"><a href="javaScript:pageNavigation('C',1);">1</a></li>
                                                            </ul>
                                                    </div>
                    </div>
                    <div class="quick_contents" id="wish_area">
                                                    <p class="quick_prd_none">해당 상품이 없습니다.</p>
                                                <div class="page" id="wish_page">
                            <ul class="page_list">
                                <li class="page_item active"><a href="javaScript:pageNavigation('W',1);">1</a></li>
                                                            </ul>
                                                    </div>
                    </div>
                    <div class="quick_contents" id="view_area" style="display:none">
                                                    <p class="quick_prd_none">해당 상품이 없습니다.</p>
                                                <div class="page" id="view_page">
                            <ul class="page_list">
                                <li class="page_item active"><a href="javaScript:pageNavigation('V',1);">1</a></li>
                                                            </ul>
                                                    </div>
                    </div>
                </div>
            </div>

            <script type="text/javaScript">
            function pageNavigation( type, page ){
                var cnt = "";

                switch (type){
                    case 'C': cnt = "0"; 
                              page_int = "2";
                              page_type = "#cart_page"; 
                              quick_type = "#quick_cart"; break;
                    case 'W': cnt = "0"; 
                              page_int = "6";
                              page_type = "#wish_page"; 
                              quick_type = "#quick_wish"; break;
                    case 'V': cnt = "0"; 
                              page_int = "6";
                              page_type = "#view_page"; 
                              quick_type = "#quick_view"; break;
                }
              //alert(cnt);
                $.ajax({
                    type: 'POST',
                    url: '/quick/page',
                    dataType: 'json',
                    data: {type : type, page : page},
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            var str_result = "";
                            var str_page = "";
                            var pre = "<a href=\"javaScript:pageNavigation(\'"+type+"\',"+(page-1)+");\" class='page_prev'> <span class='spr-common spr_arrow_left'></span>Pre</a>";
                            var next = "<a href=\"javaScript:pageNavigation(\'"+type+"\',"+(page+1)+");\" class='page_next'> Next   <span class='spr-common spr_arrow_right'></span></a>";

                            if(page == 1) pre = "";
                            if(Math.ceil((cnt/page_int)) <= page) next = "";

                            for(i=0; i<res.result.length; i++){
                                str_result += "<li class='goods_item'> <a href='/goods/detail/"+res.result[i]['GOODS_CD']+"' class='goods_item_link'> <span class='img'><img src='"+res.result[i]['IMG_URL']+"' alt=''  width='100' height='100'></span> <span class='brand'>"+res.result[i]['BRAND_NM']+"</span> <span class='name'>"+res.result[i]['GOODS_NM']+"</span> <span class='name'>"+res.result[i]['GOODS_OPTION_NM']+"</span> <span class='price'>"+res.result[i]['SELLING_PRICE'].replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,')+"</span>   </a></li>";
                            }
                            if(page % 2 == 0){
                                str_page = pre+" <ul class='page_list'> <li class='page_item'><a href=\"javaScript:pageNavigation('"+type+"',"+(page-1)+");\">"+(page-1)+"</a></li><li class='page_item active'><a href=\"javaScript:pageNavigation(\'"+type+"\',"+page+");\">"+page+"</a></li></ul>"+next;
                            }else{
                                str_page = pre+" <ul class='page_list'> <li class='page_item active'><a href=\"javaScript:pageNavigation('"+type+"',"+page+");\">"+page+"</a></li>";
                                if(Math.ceil((cnt/page_int)) > page) str_page += "<li class='page_item'><a href=\"javaScript:pageNavigation(\'"+type+"\',"+(page+1)+");\">"+(page+1)+"</a></li></ul>"+next;
                            }

                            $(page_type).html(str_page);
                            $(quick_type).html(str_result);

                        }
                        else alert(res.message);
                    }
                });
            }

            function changeTitle(kind, val){
                kind == 'wish' ? kind = 'mywiz/interest' : kind = kind;
                if(kind == 'view'){//최근본상품
                    $("#title_quick").text(val);
                }else{
                    $("#title_quick").html(val+' <a href="/'+kind+'" class="spr-common spr_btn_go cart_go" title="장바구니 바로가기"></a>');
                }
            }
            </script>
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
                        <a href="https://www.facebook.com/etahcompany" target="_blank" class="footer_sns_link ico_facebook spr-common"></a>
                    </li>
                    <li class="footer_sns_item">
                        <a href="https://www.instagram.com/etahcompany/" target="_blank" class="footer_sns_link ico_instagram spr-common"></a>
                    </li>
                    <li class="footer_sns_item">
                        <a href="https://blog.naver.com/etah_blog" target="_blank" class="footer_sns_link ico_blog2 spr-common"></a>
                    </li>
                    <li class="footer_sns_item">
                        <a href="https://pf.kakao.com/_fXkqC" target="_blank" class="footer_sns_link ico_kakao spr-common"></a>
                    </li>
                </ul>
                <ul class="footer_info">
                    <li class="footer_info_item">(주)에타<span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item">대표이사 : 김의종<span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item">서울시 강남구 논현로71길 18, 4층<span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item">사업자등록번호 : 423-81-00385<span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item">통신판매업 신고번호 : 제 2016-서울강남-02548호</li>
                </ul>
                <ul class="footer_info">
                    <li class="footer_info_item">건강기능식품판매영업신고증 : 제2018-0106933호 <span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item">의료기기판매영업신고증 : 제8227호 <span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item">수입식품등 인터넷 구매대행업 영업등록 : 제 20180003396호 <span class="spr-common spr_bg_bar_02"></span></li>
                </ul>
                <ul class="footer_info">
                    <li class="footer_info_item">입점/제휴 문의 : <a href="mailto:admin@etah.co.kr">admin@etah.co.kr</a><span class="spr-common spr_bg_bar_02"></span></li>
                    <li class="footer_info_item"><a href="mailto:admin@etah.co.kr" class="footer-menu-link">대량구매문의 (02-569-6228)</a></li>
                    <li class="footer_info_item">
                        <button type="button" class="footer_info_btn" onclick="window.open('http://www.ftc.go.kr/info/bizinfo/communicationViewPopup.jsp?wrkr_no=4238100385','사업자정보조회','width=750,height=700,location=no,status=no,scrollbars=yes');">사업정보확인</button>
                    </li>
                </ul>
                <p class="copyright">
                    copyright ⓒ 2016 etah. All rights reserved.
                </p>
            </div>


    <script src="/server/web/assets/js/common.js"></script>
    <script src="/server/web/assets/js2/jquery.cookie.js"></script>
    <script type="text/javascript" src="/server/web/assets/js2/iframeheight.js"></script>
    <script src="/server/web/assets/js/jquery.lazyload.min.js"></script>

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
                    # etahUi.gnb(   _option, _callback );
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
                if ($('#nav').get(0) !== undefined)
                {
                    etahUi.toggleMenu();
                }

            });
            $(window).on('load', function()
            { // window load

                // addScrollEvent.
                $(window).on('scroll', etahUi.quickScroll); // quick menu scroll


                // 상품 오버시 기능 버튼 활성화.
                etahUi.goodsAction();

//              etahUi.bigBanner();
            });

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
        <div id="wp_tg_cts" style="display:none;"><script id="wp_id_script_1555045940839" src="//altg.widerplanet.com/delivery/wp.js"></script><script id="wp_tag_script_1555045941177" src="//astg.widerplanet.com/delivery/wpc.php?v=1&amp;ver=4.0&amp;r=1&amp;md=bs&amp;ga=1e8gqn1-1ac4n29-3-1&amp;eid=4-adb3c1a9f7a9238fe26c04c1b9bcc11f96aef0d3d2648bff00c02c8f7c666ace19f0a9d57583a0e86750ae4edc57b3c3ab7fc76170dda909f9b452265d96d9f57fc92cc71dd9ca451d050d8581fb2884&amp;ty=Home&amp;ti=35025&amp;device=web&amp;charset=UTF-8&amp;tc=1555045941177&amp;ref=https%3A%2F%2Fwww.google.com%2F&amp;loc=http%3A%2F%2Fwww.etah.co.kr%2F"></script></div>
        <script type="text/javascript">
        var wptg_tagscript_vars = wptg_tagscript_vars || [];
        wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",   /*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
                        *주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025", /*광고주 코드*/
                ty:"Home",  /*트래킹태그 타입*/
                device:"web"    /*디바이스 종류 (web 또는 mobile)*/

            };
        }));
        </script>
        <script type="text/javascript" async="" src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
        <!-- // WIDERPLANET  SCRIPT END 2017.3.29 -->

                <script type="text/javascript">
            // Account ID 적용
            if(!wcs_add) var wcs_add = {};
            wcs_add["wa"] = "s_51fd0fb4ae2b";
            //유입 추적 함수 호출
            wcs.inflow("etah.co.kr");
        </script>

        
    


            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-K9B5N2X');</script>
            <!-- End Google Tag Manager --></div><div style="display: none; visibility: hidden;"><script>!function(b,e,f,g,a,c,d){b.fbq||(a=b.fbq=function(){a.callMethod?a.callMethod.apply(a,arguments):a.queue.push(arguments)},b._fbq||(b._fbq=a),a.push=a,a.loaded=!0,a.version="2.0",a.queue=[],c=e.createElement(f),c.async=!0,c.src=g,d=e.getElementsByTagName(f)[0],d.parentNode.insertBefore(c,d))}(window,document,"script","//connect.facebook.net/en_US/fbevents.js");fbq("init","1242607849162818");fbq("track","PageView");</script>
<noscript></noscript></div></body></html>