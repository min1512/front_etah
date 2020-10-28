    <link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css?ver=1">
    <link rel="stylesheet" href="/assets/css/brand.css?ver=1.3">
    <link rel="stylesheet" href="/assets/css/display.css?ver=1.6">


<?
//브랜드관 - 공방
if( $brand['BRAND_CATEGORY_CD'] == 4010 ){?>
        <div class="contents brand2">
            <?
            //검색결과페이지에서 브랜드관으로 넘어온 경우 네비바 표시
            if($srp != ''){?>
                <div class="location position_area">
                    <h2 class="title_page title_page__line">
                        검색결과
                    </h2>
                    <ul class="location_list position_right">
                        <li class="location_item"><a href="#">홈</a><span class="spr-common spr_arrow_right"></span></li>
                        <li class="location_item"><a href="#">검색결과</a><span class="spr-common spr_arrow_right"></span></li>
                        <li class="location_item"><a href="#" class="active">브랜드</a></li>
                    </ul>
                </div>
            <?}?>

            <div class="section brand2_visual">
                <div class="img"><img src="<?=$brand['BANNER_IMG_URL']?$brand['BANNER_IMG_URL']:$brand['TITLE_BG_IMG_URL']?>" alt=""></div>
                <div class="txt">
                    <div class="txt_inner">
                        <span class="txt2" style="font-size: 62px;"><?=$brand['BRAND_NM']?></span>
                        <p style="margin-top:50px;"><?=$brand['WEB_BRAND_DESC']?></p>
                    </div>
                </div>
            </div>

            <div class="section brand2_about">
                <div class="brand2_about_wrap1">
                    <div class="video" style="margin-bottom:32px;">
                        <iframe src="https://www.youtube.com/embed/<?=$brand['VIDEO_TITLE_CD']?>?autoplay=1&loop=1&playlist=<?=$brand['VIDEO_TITLE_CD']?>&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="link_banner">
                        <a href="<?=$brand['VIDEO_URL']?$brand['VIDEO_URL']:"https://www.youtube.com/channel/UCVEBa0D-0coHeJu9LYO5l0Q"?>"><img src="/assets/images/data/main/sample46.jpg" alt=""></a>
                    </div>
                    <div class="link_banner">
                        <a href="<?=$brand['MAGAZINE_NO']?"/magazine/detail/".$brand['MAGAZINE_NO']:"/magazine/mid_list/70000000"?>"><img src="/assets/images/data/main/sample47.jpg" alt=""></a>
                    </div>
                </div>
                <div class="brand2_about_wrap2">
                    <?
                    //브랜드이미지
                    if(count($gallery) != 0){?>
                        <div class="clearfix">
                            <? for($a=1;$a<4;$a++){  ?>
                                <div class="class owl-carousel c0<?=$a?>">
                                    <? for($b=($a-1);$b<count($gallery);$b+=3){ ?>
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$gallery[$b]['IMG_URL']?>"/>
                                            </div>
                                        </div>
                                    <?}?>
                                </div>
                            <?}?>
                        </div>
                        <ul class="class-owl-dots">
                            <li class="owl-dot active" data="0"></li>
                            <li class="owl-dot" data="1"></li>
                            <li class="owl-dot" data="2"></li>
                        </ul>
                    <?
                    //브랜드 이미지 없는경우 기본이미지
                    } else {?>
                        <div class="clearfix">
                            <div class="class owl-carousel">
                                <div class="item">
                                    <img src="/assets/images/data/main/sample48.jpg" style="width:600px;height:468px;"/>
                                </div>
                            </div>
                        </div>
                    <?}?>
                    <div id="map" class="map"></div>
                    <div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);">
                        <a href="https://map.kakao.com" target="_blank" style="float: left;">
                            <img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px">
                        </a>
                        <div style="float: right; position: relative; top: 1px; font-size: 11px;">
                            <a id="path" target="_blank" href="#" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a>
                        </div>
                    </div>
                </div>
            </div>

            <?if(count($class)!=0){?>
                <div class="section brand2_class">
                    <h4 class="title_style">작가님 클래스</h4>
                    <div class="prd_list">
                        <?for($i=0;$i<(count($class)>4?4:count($class));$i++){?>
                            <div class="item">
                                <a href="/goods/detail/<?=$class[$i]['GOODS_CD']?>">
                                    <div class="img-wrap auto-img">
                                        <div class="img">
                                            <img src="<?=$class[$i]['IMG_URL']?>">
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$class[$i]['INTEREST_CNT']?></span>
                                        </div>
                                        <div class="tag-wrap">
                                            <span class="circle-tag class"><em class="blk">에타홈<br>클래스</em></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="title"><?=$class[$i]['BRAND_NM']?></p>
                                        <p class="sub"><span class="tag <?=$class[$i]['CLASS_TYPE']=='원데이'? 'yellow':'black'?>"><?=$class[$i]['CLASS_TYPE']?></span> <?=$class[$i]['GOODS_NM']?></p>
                                        <p class="price">판매가 <strong><?=number_format( $class[$i]['SELLING_PRICE'] )?></strong></p>
                                    </div>
                                </a>
                            </div>
                        <?}?>

                        <?if(count($class)>4){?>
                            <div class="btn-wrap">
                                <span class="btn item-more" id="classPlus" style="cursor:pointer;">클래스 더 보기</span>
                            </div>
                            <?for($i=4;$i<count($class);$i++){?>
                                <div class="item classPlusList">
                                    <a href="/goods/detail/<?=$class[$i]['GOODS_CD']?>">
                                        <div class="img-wrap auto-img">
                                            <div class="img">
                                                <img src="<?=$class[$i]['IMG_URL']?>">
                                            </div>
                                            <div class="layer"></div>
                                            <div class="status">
                                                <span class="like"><?=$class[$i]['INTEREST_CNT']?></span>
                                            </div>
                                            <div class="tag-wrap">
                                                <span class="circle-tag class"><em class="blk">에타홈<br>클래스</em></span>
                                            </div>
                                        </div>
                                        <div class="txt">
                                            <p class="title"><?=$class[$i]['BRAND_NM']?></p>
                                            <p class="sub"><span class="tag <?=$class[$i]['CLASS_TYPE']=='원데이'? 'yellow':'black'?>"><?=$class[$i]['CLASS_TYPE']?></span> <?=$class[$i]['GOODS_NM']?></p>
                                            <p class="price">판매가 <strong><?=number_format($class[$i]['SELLING_PRICE'])?></strong></p>
                                        </div>
                                    </a>
                                </div>
                            <?}?>
                        <?}?>
                    </div>
                </div>
            <?}?>

            <?if(count($goods)!=0){?>
                <div class="section brand2_prd">
                    <h4 class="title_style">공방 제작 상품</h4>
                    <?if($goods_cnt>4){?>
                        <div class="btn-wrap">
                            <a href="/goods/page/1?kind=B&cate_cd=20020000&limit_num_rows=40&page=1&brand_cd=|EB02846&order_by=B&cate_gb=M" class="btn_more">
                                <span>더보기</span>
                            </a>
                        </div>
                    <?}?>
                    <div class="prd_list">
                        <?foreach($goods as $grow){?>
                            <div class="item">
                                <a href="/goods/detail/<?=$grow['GOODS_CD']?>">
                                    <div class="img-wrap auto-img">
                                        <div class="img">
                                            <img src="<?=$grow['IMG_URL']?>">
                                        </div>
                                        <div class="tag-wrap">
                                            <span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="title"><?=$grow['BRAND_NM']?></p>
                                        <p class="sub"><?=$grow['GOODS_NM']?></p>
                                        <p class="price">
                                            <?
                                            if($grow['COUPON_CD_S'] || $grow['COUPON_CD_G']){
                                                $price = $grow['SELLING_PRICE'] - ($grow['RATE_PRICE_S'] + $grow['RATE_PRICE_G']) - ($grow['AMT_PRICE_S'] + $grow['AMT_PRICE_G']);
                                                echo "판매가 <strong>".number_format($price)."</strong>";
                                                ?>
                                                <span class="discount">
                                                    <?=number_format($grow['SELLING_PRICE'])?>
                                                    (<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100)?>%)
                                                </span>
                                            <?}else{
                                                echo "판매가 <strong>".number_format($price = $grow['SELLING_PRICE'])."</strong>";
                                            }?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        <?}?>
                    </div>
                </div>
            <?}?>

            <div class="section vip_prd_info_cont" id="prdComment" style="display: block;">
                <?=$comment_template?>
            </div>
        </div>

        <script src="/assets/js/common.js?ver=1.2.1"></script>
        <script src="/assets/js/owl.carousel.min.js?ver=1.2.1"></script>
        <script>
            (function($) {
                $(document).ready(function() {
                    //클래스 슬라이드(이미지 3개 동시 롤링)
                    owl = $(".class.owl-carousel").owlCarousel({
                        animateOut: 'fadeOut',
                        mouseDrag: false,
                        items: 1,
                        loop: true,
                        autoHeight: false,
                        smartSpeed: 100,
                        autoplay: true,
                        autoplayTimeout: 7000,
                        nav: false,
                        dots: true,
                        center:true,
                        dotsContainer: '.class-owl-dots'
                    });
                    $('.class-owl-dots').on('click', 'li', function(e) {
                        owl.trigger('to.owl.carousel', [$(this).index(), 300]);
                    });
                });
            })(jQuery);

            //calculate image size
            function calcImgSize() {
                $("img", ".auto-img").each(function() {
                    var $el = $(this);
                    $el.parents(".img").addClass(function() {
                        var $height = $el.height();
                        var $width = $el.width();
                        if ($height > $width) return "port";
                        else return "land";
                    });
                });
            };
            //이미지가 모두 로드 된 후 실행
            jQuery.event.add(window,"load",function(){
                calcImgSize();
            });
        </script>


        <script>
            $(document).ready(function(){
                //클래스 더보기
                $(".classPlusList").hide();

                $("#classPlus").click(function(){
                    $("#classPlus").hide();
                    $(".classPlusList").show();
                });

                //상품평 쓰기 버튼 숨기기
                $(".btn_write").hide();
            })
        </script>

        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a05f67602dc7a0ac2ef1a72c27e5f706&libraries=services"></script>
        <script>
            var mapContainer = document.getElementById('map'), // 지도를 표시할 div
                mapOption = {
                    center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
                    level: 3 // 지도의 확대 레벨
                };

            // 지도를 생성합니다
            var map = new daum.maps.Map(mapContainer, mapOption);

            // 주소-좌표 변환 객체를 생성합니다
            var geocoder = new daum.maps.services.Geocoder();

            // 주소로 좌표를 검색합니다
            geocoder.addressSearch('<?=$brand['MAP_URL']?>', function(result, status) {

                // 정상적으로 검색이 완료됐으면
                if (status === daum.maps.services.Status.OK) {

                    var coords = new daum.maps.LatLng(result[0].y, result[0].x);
                    x = result[0].y;
                    y = result[0].x;

                    // 결과값으로 받은 위치를 마커로 표시합니다
                    var marker = new daum.maps.Marker({
                        map: map,
                        position: coords
                    });

                    // 인포윈도우로 장소에 대한 설명을 표시합니다
                    var infowindow = new daum.maps.InfoWindow({
                        content: '<div style="width:300px;text-align:center;padding:6px 0;">' +
                        '<span style="font-weight:600;"><?=$brand['BRAND_NM']?><br/><?=$brand['MAP_URL']?></span>' +
                        '</div>'
                    });
                    infowindow.open(map, marker);

                    // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                    map.setCenter(coords);


                    var path = 'https://map.kakao.com/link/to/<?=$brand['MAP_URL']?>' + ','+ x + ',' + y;

                    $("#path").attr("href",path);
                }
            });
        </script>

<?}
//브랜드관(기본)
else{?>
        <div class="contents brand_page contents__nav srp">
            <?
            //검색결과페이지에서 브랜드관으로 넘어온 경우 네비바 표시
            if($srp != ''){?>
                <div class="contents_inner ">
                    <div class="location position_area">
                        <h2 class="title_page title_page__line">
                            검색결과
                        </h2>
                        <ul class="location_list position_right">
                            <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                            <li class="location_item"><a href="/goods2/goods_search?keyword=<?=$srp?>">검색결과</a><span class="spr-common spr_arrow_right"></span></li>
                            <li class="location_item"><a href="#" class="active">브랜드</a></li>
                        </ul>
                    </div>
                </div>
            <?}?>

            <div class="brand_visual brand_visual__min" style="background:url('<?=(!empty($brand['TITLE_BG_IMG_URL']))?$brand['TITLE_BG_IMG_URL']:'/assets/images/brand/bg_brand_default.jpg'?>') repeat-x 50% 0;">
                <h2 class="brand_visual_title"><?=$brand['BRAND_NM']?></h2>
            </div>

            <?if($brand['WEB_BRAND_DESC']){?>
                <div class="brand_about">
                    <h4 class="title_style">ABOUT BRAND</h4>
                    <div class="brand_about_inner">
                        <div class="brand_about_img">
                            <?if($brand['WEB_BRAND_LOGO_URL']){?><img src="<?=$brand['WEB_BRAND_LOGO_URL']?>" alt="" /><?}else{echo $brand['BRAND_NM'];}?>
                        </div>
                        <div class="brand_about_text">
<!--                            <span class="blank"></span>-->
                            <p class="brand_about_text_item"><?=$brand['WEB_BRAND_DESC']?></p>
                        </div>
                    </div>
                </div>
            <?}?>

            <?if($brand['BANNER_IMG_URL']){?>
                <div class="brand_issue">
                    <h4 class="title_style">BRAND ISSUE</h4>
                    <div class="brand_issue_image">
                        <a href="<?=$brand['BANNER_LINK']?>"><img src="<?=$brand['BANNER_IMG_URL']?>" alt="" /></a>
                        <p class="brand_issue_text">
                            <em class="bold"></em>
                        </p>
                    </div>
                </div>
            <?}?>

            <div class="contents_inner ">
                <div class="basic_goods_list">
                    <h2 class="title_page title_page__line">
                        <b>상품</b><em class="bold_yel">(<?=number_format($total_cnt)?>개)</em>
                    </h2>

                    <!-- 카테고리 필터 -->
                    <div class="option_button position_area srp_option_area">
                        <div class="position_left">
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit1">
                                    <? switch ($order_by) {
                                        case 'A':echo '신상품순';break;
                                        case 'B':echo '인기순';break;
                                        case 'C':echo '낮은가격순';break;
                                        case 'D':echo '높은가격순';break;
                                    } ?>
                                </h4>
                                <ul id="srp-cate" class="srp-cate1">
                                    <li><a href="#none" <?= ($order_by == 'A') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'A');">신상품순</a></li>
                                    <li><a href="#none" <?= ($order_by == 'B') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'B');">인기순</a></li>
                                    <li><a href="#none" <?= ($order_by == 'C') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'C');">낮은가격순</a></li>
                                    <li><a href="#none" <?= ($order_by == 'D') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'D');">높은가격순</a></li>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit2"><?=(!empty($cur_category))?$cur_category['CATE_NM3']:'카테고리 전체'?></h4>
                                <ul id="srp-cate" class="srp-cate2">
                                    <li><a href="#none" <?=(empty($cur_category))?'class="on"':''?> onclick="javaScript:search_goods('C', '');">카테고리 전체</a></li>
                                    <?foreach ($arr_cate1 as $c1) { ?>
                                        <li <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><a href="#none"><?= $c1['NAME'] ?></a>
                                            <ul <?=($cur_category['CATE_CD1']==$c1['CODE'])?'style="display:block;"':''?>>
                                                <?
                                                foreach ($arr_cate2 as $c2) {
                                                    if ($c2['PARENT_CODE'] == $c1['CODE']) { ?>
                                                        <li <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><a href="#none"><?= $c2['NAME'] ?></a>
                                                            <ul <?=($cur_category['CATE_CD2']==$c2['CODE'])?'style="display:block;"':''?>>
                                                                <?foreach ($arr_cate3 as $c3) {
                                                                    if ($c3['PARENT_CODE'] == $c2['CODE']) {
                                                                        ?>
                                                                        <li><a href="#none" onclick="javaScript:search_goods('C', '<?= $c3['CODE'] ?>');"  <?=($cur_category['CATE_CD3']==$c3['CODE'])?'class="on"':''?>><?= $c3['NAME'] ?></a></li>
                                                                    <?}
                                                                } ?>
                                                            </ul>
                                                        </li>
                                                        <?
                                                    }
                                                } ?>
                                            </ul>
                                        </li>
                                        <?
                                    } ?>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit3">배송</h4>
                                <ul id="srp-cate" class="srp-cate3">
                                    <li>
                                        <a href="#none" class="free-deli">무료배송만
                                            <div class="checkbox-switch">
                                                <input type="checkbox" value="1" name="status" class="input-checkbox" id="toolbar-active" onclick="search_goods('D','');" <?=($deliv_type=='FREE')?'checked':''?>>
                                                <div class="checkbox-animate">
                                                    <span class="checkbox-off">OFF</span>
                                                    <span class="checkbox-on">ON</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit4">국가</h4>
                                <ul id="srp-cate" class="srp-cate4">
                                    <?
                                    $srp_country = explode("|", substr($country,1));

                                    $i = 0;
                                    foreach ($arr_country as $key => $value) {
                                        ?>
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <input type="checkbox" class="checkbox" id="CountryCheck<?= $i ?>" value="<?=$key?>" name="search_country" <?=(in_array($key,$srp_country) || $country=='')?'checked':''?>>
                                                <label class="checkbox_label"
                                                       for="CountryCheck<?= $i ?>"><?= $value['NM'] ?><?= ($key != 'KR') ? '직구' : '' ?></label>
                                            </a>
                                        </li>
                                        <?
                                        $i++;
                                    } ?>
                                    <li>
                                        <div class="confirm-btn">
                                            <button type="button"  onclick="search_goods('N','');">확인</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit5">가격</h4>
                                <?
                                $price_min = min($arr_sellingPrice);
                                $price_max = max($arr_sellingPrice);

                                //최소값, 최대값 재설정
                                if ($price_min < 10000) $price_min = 1000; //1천원

                                if ($price_max > 300000) $price_min = 100000;    //10만원
                                if ($price_max > 3000000) $price_min = 1000000;   //100만원

                                //기준금액단위 설정
                                if( (($price_max - $price_min) > 3000000) && ($price_min > 1000000) ) {
                                    $limit = 1000000; //100만원
                                } else if( (($price_max - $price_min) > 300000) && ($price_min > 100000) ){
                                    $limit = 100000; //10만원
                                } else if( (($price_max - $price_min) < 30000)){
                                    $limit = 5000; //5천원
                                } else {
                                    $limit = 10000; //1만원
                                }

                                $price_min = ceil($price_min / $limit) * $limit;
                                $price_max = floor($price_max / $limit) * $limit;

                                $price_range = ($price_max - $price_min) / 3;
                                $price_range = floor($price_range / $limit) * $limit;
                                ?>
                                <ul id="srp-cate" class="srp-cate5">
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price0">
                                                <input type="radio" id="price0" class="common-radio-btn" name="radio" <?=($price_limit=='')?'checked':''?>>
                                                <span class="common-radio-text" onclick="javaScript:search_goods('P', '');">전체</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price1">
                                                <?$range = '0|'.(string)$price_min?>
                                                <input type="radio" id="price1" class="common-radio-btn" name="radio" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text" onclick="javaScript:search_goods('P', '<?=$range?>');"><?=number_format($price_min)?>원 이하</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price2">
                                                <?$range = (string)$price_min.'|'.(string)($price_min+($price_range*1))?>
                                                <input type="radio" id="price2" class="common-radio-btn" name="radio" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text" onclick="javaScript:search_goods('P', '<?=$range?>');"><?=number_format($price_min)?>원 ~ <?=number_format($price_min+($price_range*1))?>원</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price3">
                                                <?$range = (string)$price_min+($price_range*1).'|'.(string)($price_min+($price_range*2))?>
                                                <input type="radio" id="price3" class="common-radio-btn" name="radio" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text" onclick="javaScript:search_goods('P', '<?=$range?>');"><?=number_format($price_min+($price_range*1))?>원 ~ <?=number_format($price_min+($price_range*2))?>원</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price4">
                                                <?$range = (string)($price_min+($price_range*2)).'|'.(string)($price_min+($price_range*3))?>
                                                <input type="radio" id="price4" class="common-radio-btn" name="radio" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text" onclick="javaScript:search_goods('P', '<?=$range?>');"><?=number_format($price_min+($price_range*2))?>원 ~ <?=number_format($price_min+($price_range*3))?>원</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#">
                                            <label class="common-radio-label" for="price5">
                                                <?$range = (string)($price_min+($price_range*3)).'|'?>
                                                <input type="radio" id="price5" class="common-radio-btn" name="radio" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text" onclick="javaScript:search_goods('P', '<?=$range?>');"><?=number_format($price_min+($price_range*3))?>원 이상</span>
                                            </label>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- //카테고리 필터 -->
                    <ul class="goods_list">
                        <?foreach($goods as $grow){?>
                            <li class="goods_item">
                                <div class="img">
                                    <a href="/goods/detail/<?=$grow['GOODS_CD']?>"  class="img_link">
                                        <img src="<?=$grow['IMG_URL']?>" alt="" width="290" height="290">
                                        <div class="tag-wrap">
                                            <?if(isset($grow['GOODS_PRIORITY'])){?>
                                                <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                            <?}?>
                                        </div>
                                    </a>
                                    <ul class="goods_action_menu">
                                        <li class="goods_action_item">
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$grow['GOODS_CD']?>','','');">
                                                <span class="spr-common spr-heart2"></span>
                                                <span class="spr-common spr-bgcircle2"></span>
                                                <span class="button_text">Add wish list</span>
                                            </button>
                                        </li>
                                        <li class="goods_action_item goods_action_sns">
                                            <button type="button" class="action_btn action_btn__sns">
                                                <span class="spr-common spr_share"></span>
                                                <span class="spr-common spr-bgcircle2"></span>
                                                <span class="button_text">share</span>
                                            </button>
                                            <ul class="goods_sns_list">
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$grow['IMG_URL']?>','<?=$grow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_pinter"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">핀터레스트</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','','<?=$grow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_kakao"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">카카오스토리</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','','');">
                                                        <span class="spr-common spr_share_facebook"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">페이스북</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <a href="/goods/detail/<?=$grow['GOODS_CD']?>"  class="goods_item_link">
                                <span class="brand">
                                    <?=$grow['BRAND_NM']?>
                                </span>
                                    <span class="name"><?=$grow['GOODS_NM']?></span>
                                    <span class="price">
                                    <?
                                    if($grow['COUPON_CD_S'] || $grow['COUPON_CD_G']){
                                        $price = $grow['SELLING_PRICE'] - ($grow['RATE_PRICE_S'] + $grow['RATE_PRICE_G']) - ($grow['AMT_PRICE_S'] + $grow['AMT_PRICE_G']);
                                        echo number_format($price);
                                        $sale_percent = (($grow['SELLING_PRICE'] - $price)/$grow['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <!--<span class="dc_price">
                                        <s class="del_price"><?=number_format($grow['SELLING_PRICE'])?></s> (<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                    </span>	-->
                                        <span class="dc_price">
                                        <s class="del_price"><?=number_format($grow['SELLING_PRICE'])?></s> (<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                    </span>
                                        <!--<span class="spr-common spr_ico_coupon"></span>-->
                                    <?}else{
                                        echo number_format($price = $grow['SELLING_PRICE']);
                                    }?>
                                </span>
                                    <span class="icon_block">
                                    <?if($grow['COUPON_CD_S'] || $grow['COUPON_CD_G']){
                                        ?>
                                        <span class="spr-common spr_ico_coupon"></span>
                                        <?
                                    }
                                    if($grow['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                        ?>
                                        <span class="spr-common spr_ico_mileage"></span>
                                        <?
                                    }
                                    if(($grow['PATTERN_TYPE_CD'] == 'FREE') || ( $grow['DELI_LIMIT'] > 0 && $price > $grow['DELI_LIMIT'])){
                                        ?>
                                        <span class="spr-common spr_ico_free_shipping"></span>
                                    <?}?>
                                </span>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>

                <?=$pagination?>
            </div>
        </div>
        <script type="text/javaScript">
//			var gubun = "<?//=$gubun?>//";
//			var map = "<?//=$brand['MAP_URL']?>//";
////			if(gubun == "Y") $("#brand_product").attr("tabindex", -1).focus();
//
//			//지도 삽입
//			if(map != ""){
//				create_map();
//			}
//
//			//====================================
//			// 지도 생성
//			//====================================
//			function create_map(){
//				var HOME_PATH = window.HOME_PATH || 'https://navermaps.github.io/maps.js/docs';
//
//				var point_x = "<?//=$map['x']?>//",
//					point_y = "<?//=$map['y']?>//",
//					position = new naver.maps.LatLng(point_y, point_x),
//					mapOptions = {	center: position.destinationPoint(0, 300),
//									size : new naver.maps.Size(1218, 338),
//									zoom: 10,
//									minZoom: 1, //지도의 최소 줌 레벨
//									zoomControl: true, //줌 컨트롤의 표시 여부
//									zoomControlOptions: { //줌 컨트롤의 옵션
//										position: naver.maps.Position.TOP_LEFT
//									}
//								};
//
//
//				var map = new naver.maps.Map('map_view', mapOptions);
//
//				//setOptions 메서드를 통해 옵션을 조정할 수도 있습니다.
//				map.setOptions("mapTypeControl", true); //지도 유형 컨트롤의 표시 여부
//
//				var markerOptions = {
//					position: position,
//					map: map,
//					icon: {
//						url: HOME_PATH +'/img/example/pin_default.png',
//						size: new naver.maps.Size(22, 35),
//						origin: new naver.maps.Point(0, 0),
//						anchor: new naver.maps.Point(11, 35)
//					},
//					shadow: {
//						url: HOME_PATH +'/img/example/shadow-pin_default.png',
//						size: new naver.maps.Size(40, 35),
//						origin: new naver.maps.Point(0, 0),
//						anchor: new naver.maps.Point(11, 35)
//					},
//					animation: naver.maps.Animation.BOUNCE
//				};

//				alert(HOME_PATH);

//				// min/max 줌 레벨
//				$("#min-max-zoom").on("click", function(e) {
//					e.preventDefault();
//
//					if (map.getOptions("minZoom") === 10) {
//						map.setOptions({
//							minZoom: 1,
//							maxZoom: 14
//						});
//						$(this).val(this.name + ': 1 ~ 14');
//					} else {
//						map.setOptions({
//							minZoom: 10,
//							maxZoom: 12
//						});
//						$(this).val(this.name + ': 10 ~ 12');
//					}
//				});

//				var marker = new naver.maps.Marker(markerOptions);
//
//				var contentString = [
//						'<div class="iw_inner"  style="width:100%; height:100%; margin-top:2px; margin-left:8px; margin-right:8px; margin-bottom:2px;" >',
//						'   <b><h3 style="font-size:10pt;"><?//=$brand["BRAND_NM"]?>//</h3></b>',
//						'   <p><?//=$brand["MAP_URL"]?>//<br />',
//						'   </p>',
//						'</div>'
//					].join('');
//
//				var infowindow = new naver.maps.InfoWindow({
//					content: contentString
//				});
//
//				naver.maps.Event.addListener(marker, "click", function(e) {
//					if (infowindow.getMap()) {
//						infowindow.close();
//					} else {
//						infowindow.open(map, marker);
//					}
//				});
//
//				infowindow.open(map, marker);


        // 지도 인터랙션 옵션
        //$("#interaction").on("click", function(e) {
        //    e.preventDefault();
        //
        //    if (map.getOptions("draggable")) {
        //        map.setOptions({ //지도 인터랙션 끄기
        //            draggable: false,
        //            pinchZoom: false,
        //            scrollWheel: false,
        //            keyboardShortcuts: false,
        //            disableDoubleTapZoom: true,
        //            disableDoubleClickZoom: true,
        //            disableTwoFingerTapZoom: true
        //        });
        //
        //        $(this).removeClass("control-on");
        //    } else {
        //        map.setOptions({ //지도 인터랙션 켜기
        //            draggable: true,
        //            pinchZoom: true,
        //            scrollWheel: true,
        //            keyboardShortcuts: true,
        //            disableDoubleTapZoom: false,
        //            disableDoubleClickZoom: false,
        //            disableTwoFingerTapZoom: false
        //        });
        //
        //        $(this).addClass("control-on");
        //    }
        //});

        // 관성 드래깅 옵션
        //$("#kinetic").on("click", function(e) {
        //    e.preventDefault();
        //
        //    if (map.getOptions("disableKineticPan")) {
        //        map.setOptions("disableKineticPan", false); //관성 드래깅 켜기
        //        $(this).addClass("control-on");
        //    } else {
        //        map.setOptions("disableKineticPan", true); //관성 드래깅 끄기
        //        $(this).removeClass("control-on");
        //    }
        //});

        // 타일 fadeIn 효과
        //$("#tile-transition").on("click", function(e) {
        //    e.preventDefault();
        //
        //    if (map.getOptions("tileTransition")) {
        //        map.setOptions("tileTransition", false); //타일 fadeIn 효과 끄기
        //
        //        $(this).removeClass("control-on");
        //    } else {
        //        map.setOptions("tileTransition", true); //타일 fadeIn 효과 켜기
        //        $(this).addClass("control-on");
        //    }
        //});

        // min/max 줌 레벨
        //$("#min-max-zoom").on("click", function(e) {
        //    e.preventDefault();
        //
        //    if (map.getOptions("minZoom") === 10) {
        //        map.setOptions({
        //            minZoom: 1,
        //            maxZoom: 14
        //        });
        //        $(this).val(this.name + ': 1 ~ 14');
        //    } else {
        //        map.setOptions({
        //            minZoom: 10,
        //            maxZoom: 12
        //        });
        //        $(this).val(this.name + ': 10 ~ 12');
        //    }
        //});

        //지도 컨트롤
        //$("#controls").on("click", function(e) {
        //    e.preventDefault();
        //
        //    if (map.getOptions("scaleControl")) {
        //        map.setOptions({ //모든 지도 컨트롤 숨기기
        //            scaleControl: false,
        //            logoControl: false,
        //            mapDataControl: false,
        //            zoomControl: false,
        //            mapTypeControl: false
        //        });
        //        $(this).removeClass('control-on');
        //    } else {
        //        map.setOptions({ //모든 지도 컨트롤 보이기
        //            scaleControl: true,
        //            logoControl: true,
        //            mapDataControl: true,
        //            zoomControl: true,
        //            mapTypeControl: true
        //        });
        //        $(this).addClass('control-on');
        //    }
        //});

        //$("#interaction, #tile-transition, #controls").addClass("control-on");

        //				var markerCount = 0;
        //
        //				var oSize = new naver.maps.Size(28, 37);
        //				var oOffset = new naver.maps.Size(14, 37);
        //				var oIcon = new naver.maps.Icon('http://static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);
        //
        //				var mapInfoTestWindow = new naver.maps.InfoWindow(); // - info window 생성
        //				mapInfoTestWindow.setVisible(false); // - infowindow 표시 여부 지정.
        //				oMap.addOverlay(mapInfoTestWindow);     // - 지도에 추가.
        //
        //				var oLabel = new naver.maps.MarkerLabel(); // - 마커 라벨 선언.
        //				oMap.addOverlay(oLabel); // - 마커 라벨 지도에 추가. 기본은 라벨이 보이지 않는 상태로 추가됨.
        //
        //				mapInfoTestWindow.attach('changeVisible', function(oCustomEvent) {
        //						if (oCustomEvent.visible) {
        //								oLabel.setVisible(false);
        //						}
        //				});


        //			}


        //====================================
        // 조건별 검색
        //====================================
        function search_goods(kind, val)
        {
            var page		= '<?=$page?>';
            var	brand_cd	= '<?=$brand_cd?>';
            var cate_gb     = '<?=$cate_gb?>';

            var cate_cd     = '<?=$cate_cd?>';
            var order_by    = '<?=$order_by?>';
            var deliv_type  = '<?=$deliv_type?>';
            var country     = '<?=$country?>';
            var price_limit = '<?=$price_limit?>';

            var srp = '<?=$srp?>';

            //정렬
            if(kind=='O') {
                order_by = val;
                page	 = 1;
            }

            //카테고리
            if(kind=='C') {
                cate_cd = val;
                page	 = 1;
            }

            //배송
            if(kind=='D') {
                if($('input:checkbox[name="status"]').is(":checked")) {
                    val = 'FREE';
                } else {
                    val = '';
                }

                deliv_type = val;
                page	    = 1;
            }

            //국가
            if(kind=='N') {
                $("input[name=search_country]:checked").each(function() {
                    val += '|'+$(this).val();
                });

                country = val;
                page	 = 1;
            }

            //가격
            if(kind=='P') {
                price_limit = val;
                page	 = 1;
            }

            document.location.href = "/goods/brand_page/"+page+"?srp="+srp+"&brand_cd="+brand_cd+"&cate_cd="+cate_cd+"&cate_gb="+cate_gb+"&order_by="+order_by+"&deliv_type="+deliv_type+"&country="+country+"&price_limit="+price_limit;


        }
        /*$(".nav_list a").click(function(){
            $(this).next().slideToggle().parent().siblings().children(".nav_list_2depth");
            return true;
        });*/
        </script>
        <!--GA script-->
        <script>
            //Impression
        //    ga('require', 'ecommerce', 'ecommerce.js');
        //    <?//foreach ($goods as $grow){?>
        //    ga('ecommerce:addImpression', {
        //        'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
        //        'name': "<?//=$grow['GOODS_NM']?>//",
        //        'category': <?//=$grow['CATEGORY_CD']?>//,
        //        'brand': '<?//=$grow['BRAND_NM']?>//',
        //        'list': 'Brand_shop Results'
        //    });
        //    <?//}?>
        //    ga('ecommerce:send');
        //
        //    //action
        //    function onProductClick(param,param2) {
        //        var goods_cd = param;
        //        var goods_nm = param2;
        //        ga('ecommerce:addProduct', {
        //            'id': goods_cd,
        //            'name': goods_nm
        //        });
        //        ga('ecommerce:setAction', 'click', {list: 'Brand_shop Results'});
        //
        //        // Send click with an event, then send user to product page.
        //        ga('send', 'event', 'UX', 'click', 'Results', {
        //            hitCallback: function() {
        //                //alert(goods_cd + '/' + goods_nm);
        //                document.location = '/goods/detail/'+goods_cd;
        //            }
        //        });
        //    }
        </script>
        <!--/GA script-->
<?}?>
<!-- // 일반브랜드 페이지 -->
