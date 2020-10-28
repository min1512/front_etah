<link rel="stylesheet" href="/assets/css/main.css?var=2.4.1">
<link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css">

<div class="wrap_new2019">
    <!-- 2019-04-23 김지혜 수정 -->
    <div class="contents main">
        <!-- main_banner_area -->
        <div class="main_banner_area">
            <div class="banner_left">
                <div class="owl-carousel">
                    <?foreach($top as $row) {?>
                        <div class="item">
                            <a href="<?=$row['BANNER_LINK_URL']?>">
                                <div class="img"><img src="<?=$row['BANNER_IMG_URL']?>" alt=""></div>
                                <div class="txt" style="text-align: <?=$row['BANNER_LOCATION']?>;">
                                    <div class="txt_inner">
                                        <p class="txt1" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD1']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD1']?>;
                                                font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD1']?>; font-size: <?=$row['BANNER_FONT_SIZE1']?>px;"><?=$row['BANNER_MAIN_TITLE']?></p>
                                        <p class="txt2" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD2']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD2']?>;
                                                font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD2']?>; font-size: <?=$row['BANNER_FONT_SIZE2']?>px;"><?=$row['BANNER_SUB_TITLE']?></p>
                                        <span class="btn">자세히 보러가기</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?}?>
                </div>
            </div>

            <div class="banner_right">
                <div class="inner">
                    <div class="owl-carousel">
                        <?foreach($event as $erow){?>
                            <a href="<?=$erow['BANNER_LINK_URL']?>" class="item">
                                <div class="img"><img src="<?=$erow['BANNER_IMG_URL']?>" alt=""></div>
                            </a>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
        <!-- //main_banner_area -->

        <!-- today_area -->
        <div class="today_area">
            <h4 class="title_style">에타홈 특가</h4>
            <!--<h5 class="title_style_sub">MD가 추천하는 에타딜 상품</h5>-->
            <div class="main_goods_list">
                <a href="/goods/event/586" class="btn_more">
                    <span>더보기</span>
                </a>
                <ul>
                    <?foreach($etahDeal as $row) {?>
                        <li>
                            <a href="<?=$row['LINK_URL']?>" class="best_goods">
                                <img src="<?=$row['IMG_URL']?>" alt="">
                                <div class="tag-wrap">
                                    <?
                                    $price = $row['SELLING_PRICE'] - $row['RATE_PRICE'] - $row['AMT_PRICE'];
                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                    $sale_percent = strval($sale_percent);
                                    $sale_percent_array = explode('.',$sale_percent);
                                    $sale_percent_string = $sale_percent_array[0];
                                    ?>
                                    <?if(isset($row['DEAL'])){?>
                                        <?if($sale_percent_string == 0){?>
                                            <!--<span class="circle-tag deal"><em class="blk" style="color:#000">에타<br>딜</em></span>-->
                                        <?} else {?>
                                            <span class="circle-tag sale">~<em class="blk"><?=$sale_percent_string?></em>%</span>
                                        <?}?>
                                    <?}?>
                                    <?if($row['GONGBANG']=='G'){?>
                                        <!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>-->
                                    <?}else if($row['GONGBANG']=='C'){?>
                                        <!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>-->
                                    <?}?>
                                </div>
                                <div class="cover hidden">자세히 보러가기 &nbsp;&gt;</div>
                            </a>
                            <a href="<?=$row['LINK_URL']?>" class="best_txt"><?=$row['NAME']?></a>
                            <?if( ($row['PATTERN_TYPE_CD']=='FREE') ||
                                (($row['PATTERN_TYPE_CD']=='PRICE') && ($row['DELI_LIMIT']>0 && $row['DELI_LIMIT']<($row['SELLING_PRICE']-$row['RATE_PRICE']-$row['AMT_PRICE']))) ){
                            ?>
                                <span class="icon_block">
                                    <span class="spr-common spr_ico_free_shipping"></span>
                                </span>
                            <?}?>
                        </li>
                    <?}?>
                </ul>
            </div>
        </div>
        <!-- //today_area -->

        <!-- homejok_pedia  홈족피디아-->
        <div class="homejok_pedia">
            <div class="inner">
                <div class="inner_tit">
                    <a href="/magazine/mid_list/40000000">
                    <div class="left">
                        <h4>
                            <span class="txt1"><img src="/assets/images/data/main/homejok_roof.png"><br/>홈족피디아</span>
                            <span class="txt2"><img src="/assets/images/data/main/homejok_main_2.png"> 이거 알고 있었어?</span>
                        </h4>
                    </div>
                    </a>
                    <div class="right">
                        <div class="top">
                            <!--<h4 class="title_style">집순이 집돌이 PICK!</h4>
                            <h5 class="title_style_sub">집순이 집돌이 PICK!</h5>-->
                        </div>
                    </div>
                </div>
                <div class="tabmenu">
                    <ul>
                        <li id="tab1" class="btnCon">
                            <input type="radio" checked name="tabmenu" id="tabmenu1">
                            <label for="tabmenu1">전체보기
                                <a href="/magazine/mid_list/40000000" class="links1 on"><span class="btn">더보기</span></a>
                            </label>
                            <div class="tabCon" >
                                <div class="item all_view">
                                    <div class="img-wrap auto-img all_img1">
                                        <a href="/magazine/detail/<?=$homejokAll[0]['GOODS_CD']?>">
                                            <div class="img">
                                                <img src="<?=$homejokAll[0]['MAGAZINE_IMG_URL']?>">
                                            </div>
                                            <div class="layers"></div>
                                            <div class="status">
                                                <span class="txt"><?=$homejokAll[0]['TITLE']?></span>
                                                <p class="h_view"><span>VIEW</span> <?=$homejokAll[0]['HITS']?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="img-wrap auto-img all_img2">
                                        <ul class="all_img_list">
                                            <?for($i=1;$i<5;$i++){?>
                                            <li>
                                                <a href="/magazine/detail/<?=$homejokAll[$i]['GOODS_CD']?>">
                                                    <div class="img">
                                                        <img src="<?=$homejokAll[$i]['MAGAZINE_IMG_URL']?>">
                                                    </div>
                                                    <div class="status sub">
                                                        <span class="txt"><?=$homejokAll[$i]['TITLE']?></span>
                                                        <p class="h_view">조회 <?=$homejokAll[$i]['HITS']?></p>
                                                    </div>
                                                </a>
                                            </li>
                                            <?}?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li id="tab2" class="btnCon">
                            <input type="radio" name="tabmenu" id="tabmenu2">
                            <label for="tabmenu2">리빙백서
                                <a href="/magazine/list/40010000" class="links2"><span class="btn">더보기</span></a>
                            </label>
                            <div class="tabCon">
                                <div class="item all_view">
                                    <?if(count($homejok1)!=0){?>
                                        <div class="img-wrap auto-img all_img1">
                                            <a href="/magazine/detail/<?=$homejok1[0]['MAGAZINE_NO']?>">
                                                <div class="img">
                                                    <img src="<?=$homejok1[0]['IMG_URL']?>">
                                                </div>
                                                <div class="layers"></div>
                                                <div class="status">
                                                    <span class="txt"><?=$homejok1[0]['TITLE']?></span>
                                                    <p class="h_view"><span>VIEW</span> <?=$homejok1[0]['HITS']?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="img-wrap auto-img all_img2">
                                            <ul class="all_img_list">
                                                <?for($i=1;$i<count($homejok1);$i++){?>
                                                    <li>
                                                        <a href="/magazine/detail/<?=$homejok1[$i]['MAGAZINE_NO']?>">
                                                            <div class="img">
                                                                <img src="<?=$homejok1[$i]['IMG_URL']?>">
                                                            </div>
                                                            <div class="status sub">
                                                                <span class="txt"><?=$homejok1[$i]['TITLE']?></span>
                                                                <p class="h_view">조회 <?=$homejok1[$i]['HITS']?></p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?}?>
                                            </ul>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        </li>
                        <li id="tab3" class="btnCon"><input type="radio" name="tabmenu" id="tabmenu3">
                            <label for="tabmenu3">감성생활
                                <a href="/magazine/list/40030000"><span class="btn">더보기</span></a>
                            </label>
                            <div class="tabCon">
                                <div class="item all_view">
                                    <?if(count($homejok2)!=0){?>
                                        <div class="img-wrap auto-img all_img1">
                                            <a href="/magazine/detail/<?=$homejok2[0]['MAGAZINE_NO']?>">
                                                <div class="img">
                                                    <img src="<?=$homejok2[0]['IMG_URL']?>">
                                                </div>
                                                <div class="layers"></div>
                                                <div class="status">
                                                    <span class="txt"><?=$homejok2[0]['TITLE']?></span>
                                                    <p class="h_view"><span>VIEW</span> <?=$homejok2[0]['HITS']?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="img-wrap auto-img all_img2">
                                            <ul class="all_img_list">
                                                <?for($i=1;$i<count($homejok2);$i++){?>
                                                    <li>
                                                        <a href="/magazine/detail/<?=$homejok2[$i]['MAGAZINE_NO']?>">
                                                            <div class="img">
                                                                <img src="<?=$homejok2[$i]['IMG_URL']?>">
                                                            </div>
                                                            <div class="status sub">
                                                                <span class="txt"><?=$homejok2[$i]['TITLE']?></span>
                                                                <p class="h_view">조회 <?=$homejok2[$i]['HITS']?></p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?}?>
                                            </ul>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        </li>
                        <li id="tab4" class="btnCon"><input type="radio" name="tabmenu" id="tabmenu4">
                            <label for="tabmenu4">홈족TIP
                                <a href="/magazine/list/40020000"><span class="btn">더보기</span></a>
                            </label>
                            <div class="tabCon">
                                <div class="item all_view">
                                    <?if(count($homejok3)!=0){?>
                                        <div class="img-wrap auto-img all_img1">
                                            <a href="/magazine/detail/<?=$homejok3[0]['MAGAZINE_NO']?>">
                                                <div class="img">
                                                    <img src="<?=$homejok3[0]['IMG_URL']?>">
                                                </div>
                                                <div class="layers"></div>
                                                <div class="status">
                                                    <span class="txt"><?=$homejok3[0]['TITLE']?></span>
                                                    <p class="h_view"><span>VIEW</span> <?=$homejok3[0]['HITS']?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="img-wrap auto-img all_img2">
                                            <ul class="all_img_list">
                                                <?for($i=1;$i<count($homejok3);$i++){?>
                                                    <li>
                                                        <a href="/magazine/detail/<?=$homejok3[$i]['MAGAZINE_NO']?>">
                                                            <div class="img">
                                                                <img src="<?=$homejok3[$i]['IMG_URL']?>">
                                                            </div>
                                                            <div class="status sub">
                                                                <span class="txt"><?=$homejok3[$i]['TITLE']?></span>
                                                                <p class="h_view">조회 <?=$homejok3[$i]['HITS']?></p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?}?>
                                            </ul>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        </li>
                        <li id="tab5" class="btnCon"><input type="radio" name="tabmenu" id="tabmenu5">
                            <label for="tabmenu5">해외직구
                                <a href="/magazine/list/40040000"><span class="btn">더보기</span></a>
                            </label>
                            <div class="tabCon">
                                <div class="item all_view">
                                    <?if(count($homejok4)!=0){?>
                                        <div class="img-wrap auto-img all_img1">
                                            <a href="/magazine/detail/<?=$homejok4[0]['MAGAZINE_NO']?>">
                                                <div class="img">
                                                    <img src="<?=$homejok4[0]['IMG_URL']?>">
                                                </div>
                                                <div class="layers"></div>
                                                <div class="status">
                                                    <span class="txt"><?=$homejok4[0]['TITLE']?></span>
                                                    <p class="h_view"><span>VIEW</span> <?=$homejok4[0]['HITS']?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="img-wrap auto-img all_img2">
                                            <ul class="all_img_list">
                                                <?for($i=1;$i<count($homejok4);$i++){?>
                                                    <li>
                                                        <a href="/magazine/detail/<?=$homejok4[$i]['MAGAZINE_NO']?>">
                                                            <div class="img">
                                                                <img src="<?=$homejok4[$i]['IMG_URL']?>">
                                                            </div>
                                                            <div class="status sub">
                                                                <span class="txt"><?=$homejok4[$i]['TITLE']?></span>
                                                                <p class="h_view">조회 <?=$homejok4[$i]['HITS']?></p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?}?>
                                            </ul>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //homejok_pedia 홈족피디아-->

        <!-- bestreview_area -->
        <div class="bestreview_area">
            <h4 class="title_style">베스트 후기</h4>
            <h5 class="title_style_sub">에타홈 회원이라면 누구나!</h5>
            <div class="review_list">
                <div class="owl-carousel">
                    <div class="item">
                        <ul>
                            <?foreach($best_review as $row){?>
                                <li>
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="pic">
                                        <img src="<?=$row['IMG_URL']?>" alt="" style="width:232px; height: 226px;"/>
                                        <div class="cover hidden">자세히 보러가기 &nbsp;&gt;</div>
                                    </a>
                                    <div class="inner">
                                        <div class="review_txt">
                                            <a href="/goods/detail/<?=$row['GOODS_CD']?>"><?=$row['CONTENTS']?></a>
                                        </div>
                                        <span class="nm_txt"><?=$row['BRAND_NM']?></span>
                                        <span class="prd_txt"><?=$row['GOODS_NM']?></span>
                                        <!--                                    <img src="../../assets/images/data/main/idpic.jpg" class="idpic" alt=""/>-->
                                        <div class="btm_txt" style="left:285px;">
                                            <span class="id_txt"><?=substr($row['CUST_ID'],0,3)."****"?></span>
                                            <span class="date_txt"><?=substr($row['REG_DT'], 0, 10)?></span>
                                        </div>
                                    </div>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- //bestreview_area -->

        <!-- keyword_area -->
        <div class="keyword_area">
            <?php
            function toWeekNum($timestamp) {
                $w = date('w', mktime(0,0,0, date('n',$timestamp), 1, date('Y',$timestamp)));
                return ceil(($w + date('j',$timestamp) -1) / 7);
            }
            switch(toWeekNum(time())) {
                case 1: $weekNo = '첫';  break;
                case 2: $weekNo = '둘';  break;
                case 3: $weekNo = '셋';  break;
                case 4: $weekNo = '넷';  break;
                case 5: $weekNo = '다섯';  break;
            }
            ?>
            <div class="inner">
                <h4 class="title_style">인기 키워드</h4>
                <h5 class="title_style_sub"><?=date('n')?>월 <?=$weekNo?>째주 인기 키워드</h5>
                <div class="search_area">
                    <form action="">
                        <fieldset class="search_keyword">
                            <legend>검색</legend>
                            <input type="text" class="search_input" id="main_search" placeholder="찾는 키워드가 없으시면 간편하게 검색하세요~" onkeypress="javascript:if(event.keyCode == 13){ mainSearch(''); return false;}">
                            <button type="button" class="search_submit" title="검색" onclick="javaScript:mainSearch('');">검색하기</button>
                        </fieldset>
                    </form>
                </div>

                <div class="tag_area">
                    <?foreach($hashtag as $tag){?>
                        <a href="/goods2/goods_search?keyword=<?=$tag['TAG_NM']?>&gb=T&tag_keyword=<?=$tag['TAG_NM']?>">#<?=$tag['TAG_NM']?></a>
                    <?}?>
                </div>

                <div class="pic_area">
                    <ul class="">
                        <?foreach($best_keyword as $key) {?>
                            <li>
                                <?if($key['LINK_URL']){?>
                                    <a href="<?=$key['LINK_URL']?>">
                                <?} else {?>
                                    <a href="/goods2/goods_search?keyword=<?=$key['NAME']?>&gb=T&tag_keyword=<?=$key['NAME']?>">
                                <?}?>
                                    <div class="img-wrap">
                                        <div class="img">
                                            <img src="<?=$key['IMG_URL']?>" alt=""/>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <div class="txt-inner">
                                            <span>#<?=$key['NAME']?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //keyword_area -->

        <!-- cate_area -->
        <div class="cate_area">
            <div class="inner">
                <div class="owl-carousel">
                    <a href="/goods/mid_list/24010000" class="item">
                        <img src="/assets/images/main/img_cate00.jpg" />
                        <span>에타홈 클래스</span>
                    </a>
                    <a href="/category/main/10000000" class="item">
                        <img src="/assets/images/main/img_cate01.jpg" />
                        <span>가구</span>
                    </a>
                    <a href="/category/main/11000000" class="item">
                        <img src="/assets/images/main/img_cate02.jpg" />
                        <span>소품</span>
                    </a>
                    <a href="/category/main/14000000" class="item">
                        <img src="/assets/images/main/img_cate03.jpg" />
                        <span>조명</span>
                    </a>
                    <a href="/category/main/19000000" class="item">
                        <img src="/assets/images/main/img_cate04.jpg" />
                        <span>주방</span>
                    </a>
                    <a href="/category/main/22000000" class="item">
                        <img src="/assets/images/main/img_cate05.jpg" />
                        <span>식품</span>
                    </a>
                    <a href="/category/main/21000000" class="item">
                        <img src="/assets/images/main/img_cate06.jpg?ver=1.0" />
                        <span>디지털/가전</span>
                    </a>
                    <a href="/category/main/17000000" class="item">
                        <img src="/assets/images/main/img_cate07.jpg?ver=1.0" />
                        <span>생활/욕실</span>
                    </a>
                    <a href="/category/main/15000000" class="item">
                        <img src="/assets/images/main/img_cate08.jpg" />
                        <span>침구</span>
                    </a>
                    <a href="/category/main/23000000" class="item">
                        <img src="/assets/images/main/img_cate09.jpg?ver=1.0" />
                        <span>뷰티</span>
                    </a>
                    <a href="/category/main/13000000" class="item">
                        <img src="/assets/images/main/img_cate10.jpg" />
                        <span>DIY</span>
                    </a>
                    <a href="/category/main/16000000" class="item">
                        <img src="/assets/images/main/img_cate11.jpg" />
                        <span>가드닝</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- //cate_area -->

        <!-- mdpic_area -->
        <div class="mdpic_area">
            <div class="inner">
                <h4 class="title_style">
                    <span class="txt1">홈&amp;펫&amp;직구</span>
                    <span class="txt2">MD Pick</span>
                </h4>
            </div>
            <div class="inner_content">
                <div class="owl-carousel">
                    <?
                    for($i=0;$i<count($md_pick);$i+=4) {
                        echo "<div class=\"item\">";
                        for ($j=$i; $j < ($i+4); $j++) {
                           ?>
                            <a href="/goods/detail/<?=$md_pick[$j]['GOODS_CD']?>">
                                <img src="<?=$md_pick[$j]['IMG_URL']?>" style="height: 293.5px;"/>
                                <div class="tag-wrap">
                                    <?if(!empty($md_pick[$j]['DEAL'])){?><?}?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                </div>
                                <span class="txt1"><?=$md_pick[$j]['BRAND_NM']?></span>
                                <span class="txt2"><?=$md_pick[$j]['GOODS_NM']?></span>
                                <span class="txt3">판매가</span>
                                <?
                                if($md_pick[$j]['COUPON_CD']){
                                    $price = $md_pick[$j]['SELLING_PRICE'] - $md_pick[$j]['RATE_PRICE'] - $md_pick[$j]['AMT_PRICE'];
                                    echo "<span class=\"txt4\">".number_format($price)."</span>";

                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                    $sale_percent = (($md_pick[$j]['SELLING_PRICE'] - $price)/$md_pick[$j]['SELLING_PRICE']*100);
                                    $sale_percent = strval($sale_percent);
                                    $sale_percent_array = explode('.',$sale_percent);
                                    $sale_percent_string = $sale_percent_array[0];
                                    ?>
                                    <span class="txt5">
                                    <?=number_format($md_pick[$j]['SELLING_PRICE'])?> (<?=floor((($md_pick[$j]['SELLING_PRICE']-$price)/$md_pick[$j]['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)
								</span>
                                <?}else{
                                    echo "<span class=\"txt4\">".number_format($md_pick[$j]['SELLING_PRICE'])."</span>";
                                }
                                ?>
                            </a>
                        <?
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- //mdpic_area -->

        <!-- brand_area -->
        <div class="brand_area">
            <div class="inner">
                <h4 class="title_style">Brand Focus</h4>

                <div class="brand-focus-nav">
                    <?for($i=0;$i<count($brand_focus);$i++){?>
                        <a href="#none" class="brand<?=$i+1?>"><?=$brand_focus[$i]['NAME']?></a>
                    <?}?>
                </div>

                <div class="brand-focus-list owl-carousel">
                    <?for($j=0;$j<count($brand_focus);$j++){?>
                        <div class="item brand<?=$j+1?>">
                            <div class="img">
                                <img src="<?=$brand_focus[$j]['LOGO_IMG_URL']?>" class="logo" style="height:120px;"/>
                            </div>
                            <span class="txt1"><?=nl2br($brand_focus[$j]['DISP_HTML'])?></span>
                            <a href="<?=$brand_focus[$j]['LINK_URL']?>" class="btn1">브랜드관 바로가기</a>
                            <a href="<?=$brand_focus[$j]['LINK_URL']?>"><img src="<?=$brand_focus[$j]['IMG_URL']?>" /></a>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
        <!-- //brand_area -->

        <!-- magazine_area -->
        <div class="magazine_area">
            <div class="inner">
                <h4 class="title_style">트렌드 매거진</h4>
                <h5 class="title_style_sub" style="text-align: left;">에타홈 회원분들의 관심으로 만들어진</h5>

                <div class="tab_body_wrap owl-carousel">
                    <div class="tab_body prd_list links1">
                        <?foreach($magazine1 as $row){?>
                            <div class="item">
                                <a href="/magazine/detail/<?=$row['GOODS_CD']?>">
                                    <div class="img-wrap auto-img">
                                        <div class="img">
                                            <img src="<?=$row['MAGAZINE_IMG_URL']?>" class="bg"/>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$row['LOVE']?></span>
                                            <span class="comment"><?=$row['COMMENT']?></span>
                                            <span class="share"><?=$row['SHARE']?></span>
                                            <span class="view">조회 <?=$row['HITS']?></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="title"><span class="tag yellow">TYPE</span> <?=$row['CATEGORY_NM']?></p>
                                        <p class="sub"><?=$row['TITLE']?></p>
                                    </div>
                                </a>
                            </div>
                        <?}?>
                    </div>
                    <div class="tab_body prd_list links2">
                        <?foreach($magazine2 as $row){?>
                            <div class="item">
                                <a href="/magazine/detail/<?=$row['GOODS_CD']?>">
                                    <div class="img-wrap auto-img">
                                        <div class="img">
                                            <img src="<?=$row['MAGAZINE_IMG_URL']?>" class="bg"/>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$row['LOVE']?></span>
                                            <span class="comment"><?=$row['COMMENT']?></span>
                                            <span class="share"><?=$row['SHARE']?></span>
                                            <span class="view">조회 <?=$row['HITS']?></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="title"><span class="tag yellow">TYPE</span> <?=$row['CATEGORY_NM']?></p>
                                        <p class="sub"><?=$row['TITLE']?></p>
                                    </div>
                                </a>
                            </div>
                        <?}?>
                    </div>
                    <div class="tab_body prd_list links3">
                        <?foreach($magazine3 as $row){?>
                            <div class="item">
                                <a href="/magazine/detail/<?=$row['GOODS_CD']?>">
                                    <div class="img-wrap auto-img">
                                        <div class="img">
                                            <img src="<?=$row['MAGAZINE_IMG_URL']?>" class="bg"/>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$row['LOVE']?></span>
                                            <span class="comment"><?=$row['COMMENT']?></span>
                                            <span class="share"><?=$row['SHARE']?></span>
                                            <span class="view">조회 <?=$row['HITS']?></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="title"><span class="tag yellow">TYPE</span> <?=$row['CATEGORY_NM']?></p>
                                        <p class="sub"><?=$row['TITLE']?></p>
                                    </div>
                                </a>
                            </div>
                        <?}?>
                    </div>
                </div>

                <div class="links">
                    <ul>
                        <li>
                            <a href="/magazine/list/50010000" class="links1 on">
                                <span class="txt">생활 tip</span>
                                <span class="btn">바로가기</span>
                            </a>
                        </li>
                        <li>
                            <a href="/magazine/list/50020000" class="links2">
                                <span class="txt">인테리어 tip</span>
                                <span class="btn">바로가기</span>
                            </a>
                        </li>
                        <li>
                            <a href="/magazine/mid_list/60000000" class="links3">
                                <span class="txt">브랜드소개</span>
                                <span class="btn">바로가기</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //magazine_area -->

        <!-- class_area -->
        <div class="class_area">
            <div class="inner">
                <div class="left">
                    <h4>
                        <span class="txt1">올 어바웃</span>
                        <span class="txt2">에타홈 클래스</span>
                    </h4>

                    <div class="prd_list owl-carousel">
                        <?foreach($class_magazine as $mrow){?>
                            <div class="item">
                                <a href="/magazine/detail/<?=$mrow['GOODS_CD']?>">
                                    <div class="img-wrap auto-img">
                                        <div class="img">
                                            <img src="<?=$mrow['MAGAZINE_IMG_URL']?>"/>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="title"><span class="tag yellow">매거진</span> <?=$mrow['CATEGORY_NM']?></p>
                                        <p class="sub"><?=$mrow['TITLE']?></p>
                                    </div>
                                </a>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div class="right">
                    <div class="top">
                        <h4 class="title_style">에타홈 클래스</h4>
                        <h5 class="title_style_sub">평범한 하루를 특별하게 만들어주는 ...</h5>
                        <a href="/goods/mid_list/24010000" class="btn_more">
                            <span>더보기</span>
                        </a>
                    </div>

                    <div class="prd_list">
                        <?foreach($class_goods as $grow){?>
                        <div class="item">
                            <a href="/goods/detail/<?=$grow['GOODS_CD']?>">
                                <div class="img-wrap auto-img">
                                    <div class="img">
                                        <img src="<?=$grow['IMG_URL']?>">
                                    </div>
<!--                                    <div class="layer"></div>-->
<!--                                    <div class="status">-->
<!--                                        <span class="like">21</span>-->
<!--                                    </div>-->
                                </div>
                                <div class="txt">
                                    <p class="title">
                                        <?if($grow['CLASS'] == '공방상품'){?>
                                            <span class="tag yellow"><?=$grow['CLASS']?></span>
                                        <?} else{?>
                                            <span class="tag yellow"><?=$grow['ADDRESS']?></span>
                                            <span class="tag yellow"><?=$grow['CLASS']?></span>
                                        <?}?>
                                        <?=$grow['BRAND_NM']?>
                                    </p>
                                    <p class="sub"><?=$grow['GOODS_NM']?></p>
                                    <p class="price">판매가
                                        <?
                                        if($grow['COUPON_CD']){
                                            $price = $grow['SELLING_PRICE'] - $grow['RATE_PRICE'] - $grow['AMT_PRICE'];
                                            echo "<strong>".number_format($price)."</strong>";

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($grow['SELLING_PRICE'] - $price)/$grow['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <span class="discount">
                                                <?=number_format($grow['SELLING_PRICE'])?> (<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)
                                            </span>
                                        <?}else{
                                            echo "<strong>".number_format($grow['SELLING_PRICE'])."</strong>";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
        <!-- //class_area -->

        <!-- insta_area -->
        <div class="insta_area">
            <div class="inner">
                <h4 class="title_style">Instagram</h4>
                <h5 class="title_style_sub">follow @etahome_kr</h5>
                <ul class="list" id="instafeed-gallery-feed"></ul>
            </div>
        </div>
        <!-- //insta_area -->

        <!-- store-btn-area -->
        <div class="store-btn-area">
            <div class="inner">
                <a href="<?=base_url()?>footer/inquiry_for_office" class="btn-yellow large">브랜드 입점문의</a>
                <a href="https://forms.gle/WBEjJENCXqLvjFio7" onclick="window.open(this.href,'','width=510, height=620, scrollbars=yes'); return false;" class="btn-yellow large">에타홈클래스 입점신청</a>
            </div>
        </div>
        <!-- //store-btn-area -->
    </div>

</div>

<script src="/assets/js/common.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>

<!-- insta_area 2020.07.29 인스타 재연동 완료(PC) 이상민  -->
<script>
//    var  token = 'IGQVJVVXJaZA0x1T2l4c3o1bGJTSy12R3hHSGlxNUFtNEZAIZA2c1ZAEI2NlVhaEwzeFFBTEhsYzZAaWWtBSUlfN3hRWXk3TVZAyeU5LdC1oMmJxWE8tbmxCTHFpM1NucHNScHNkWFAxOHZAjT2ZAtSGtwam5DRQZDZD', // access token.
//        userid = 316600399471144, // User ID - get it in source HTML of your Instagram profile or look at the next example :)
//        num_photos = 14; // how much photos do you want to get

    $.ajax({
        url: 'https://graph.instagram.com/me/media?fields=id,caption,media_url,media_type,permalink,thumbnail_url&access_token=IGQVJYQkhXR0VqTUJncjFHRkJKOF9rUUk3VEt1bFhVU3RzQkY3ZADVfZAlo2MkRoaWRYbnBaamtFVEttMjl1NjgtM3NqOE1pYzFwUTNOLXJzRHVqR21kQ0ZAYTFhKdlB1T0R2MkVUYVN4czRqbDh0ZAWdkagZDZD',
        dataType: 'jsonp',
        type: 'GET',
//        data: {access_token: token, count: num_photos},
        success: function(data){
            console.log(data);
//                $("#instafeed-gallery-feed").append('<ul class="list">');

            for( x in data.data){
                if(x <14){
                    var img = data.data[x];
//                    console.log(data.data[5]);
                    if(data.data[x]['media_type'] == 'CAROUSEL_ALBUM'){
                        $("#instafeed-gallery-feed").append('<li>' +
                            '<a target="_blank" href="'+img['permalink']+'">'+
                            '<img  src="'+img['media_url']+'" style=\"width:206px;height:206px;\">' + '</a>'+
                            '</li>');
                    }else if(data.data[x]['media_type'] == 'VIDEO'){
                        $("#instafeed-gallery-feed").append('<li>' +
                            '<a target="_blank" href="'+img['permalink']+'">'+
                            '<img  src="'+img['thumbnail_url']+'" style=\"width:206px;height:206px;\">' + '</a>'+
                            '</li>');
                    }
                }
            }
//            for( x in data.data ){
//                $("#instafeed-gallery-feed").append('<li>' +
//                    '<a target="_blank" href="'+data.data[x].link+'">'+
//                    '<img  src="'+data.data[x].images.low_resolution.url+'" style=\"width:206px;height:206px;\">' + '</a>'+
//                    '</li>');

                // data.data[x].images.low_resolution.url - URL of image, 306х306
                // data.data[x].images.thumbnail.url - URL of image 150х150  썸네일 이미지
                // data.data[x].images.standard_resolution.url - URL of image 612х612   기본 이미지
                // data.data[x].link - Instagram post URL   인스타그램 사진 URL

//                $("#instafeed-gallery-feed").append('</ul>');
        },
        error: function(data){
            console.log(data); // send the error notifications to console
        }
    });
</script>
<!-- insta_area// -->

<script>
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
    function mainSearch(val)
    {
        var page = 1;
        var keyword = document.getElementById("main_search").value;
        var r_keyword = "";
        var cate_cd = "";


        if(val == 'r'){
            if($('#r_keyword').val()){
                r_keyword = document.getElementById("r_keyword").value+"||"+document.getElementById("contents_search").value;
            }else{
                r_keyword = document.getElementById("keyword").value+"||"+document.getElementById("contents_search").value;
            }
            //검색어가 없을때
            if(!trim(r_keyword)) return false;
        }else{
            //검색어가 없을때
            if(!trim(keyword)) return false;
        }

//        var param = "";
//        param += "page="			+ page;
//        param += "&keyword="		+ keyword;
//        param += "&r_keyword="		+ r_keyword;
//        param += "&cate_cd="		+ cate_cd;
//        document.location.href = "/goods2/goods_search/"+page+"?"+param;

        document.location.href = "/goods2/goods_search?keyword="+keyword;
    }
</script>

<script>
    (function($) {
        $(document).ready(function(){
            // 팝업슬라이드
            $(".layer_main01 .layer_cont").owlCarousel({
                items: 1,
                loop: true,
                autoHeight: true,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 5000,
                nav: false,
                dots: true
            });

            // 메인배너영역 > 왼쪽 슬라이드
            $(".banner_left .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                items: 1,
                loop: true,
                autoHeight: false,
                smartSpeed: 100,
                autoplay: true,
                autoplayTimeout: 4000,
                nav: false,
                dots: true,
                center:true
            });

            // 메인배너영역 > 오른쪽 슬라이드
            $(".banner_right .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                items: 1,
                loop: true,
                autoHeight: false,
                smartSpeed: 100,
                autoplay: true,
                autoplayTimeout: 3000,
                nav: false,
                dots: true,
                center:true
            });

            // 베스트후기 슬라이드
            $(".bestreview_area .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                loop: true,
                items:1,
                margin:26,
                smartSpeed: 100,
                nav: false,
                dots: false
            });

            // 카테고리 슬라이드
            $(".cate_area .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                loop: true,
                items:7,
                margin:26,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed: 300,
                nav: true,
                dots: false
            });

            // mdpic 슬라이드
            $(".mdpic_area .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                loop: true,
                items:1,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed: 100,
                nav: false,
                dots: true
            });

            // Brand Focus 슬라이드
            $(function() {
                //visual slide
                var visualSlide = $(".brand_area .owl-carousel");
                var btnVsualNav = $(".brand-focus-nav");
                var syncedSecondary = true;
                btnVsualNav.children("a").eq(0).addClass("on");
                visualSlide.owlCarousel({
                    animateOut: 'fadeOut',
                    mouseDrag: false,
                    loop: true,
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    smartSpeed: 100,
                    nav: false,
                    dots: true
                }).on("changed.owl.carousel", syncPosition);
                btnVsualNav.on("changed.owl.carousel", syncPosition2);
                function syncPosition(el) {
                    var count = el.item.count - 1;
                    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
                    if (current < 0) {
                        current = count;
                    }
                    if (current > count) {
                        current = 0;
                    }
                    btnVsualNav.find("a").removeClass("on").eq(current).addClass("on");
                }
                function syncPosition2(el) {
                    if (syncedSecondary) {
                        var number = el.item.index;
                        visualSlide.data("owl.carousel").to(number, 100, true);
                    }
                }
                btnVsualNav.on("click", "a", function(e) {
                    e.preventDefault();
                    var number = $(this).index();
                    visualSlide.data("owl.carousel").to(number, 300, true);
                });
            });

            // Magazine 슬라이드
            $(function() {
                //visual slide
                var visualSlide = $(".magazine_area .owl-carousel");
                var btnVsualNav = $(".magazine_area .links");
                var syncedSecondary = true;
                btnVsualNav.children("a").eq(0).addClass("on");
                visualSlide.owlCarousel({
                    animateOut: 'fadeOut',
                    mouseDrag: false,
                    loop: true,
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    smartSpeed: 100,
                    nav: false,
                    dots: true
                }).on("changed.owl.carousel", syncPosition);
                btnVsualNav.on("changed.owl.carousel", syncPosition2);
                function syncPosition(el) {
                    var count = el.item.count - 1;
                    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
                    if (current < 0) {
                        current = count;
                    }
                    if (current > count) {
                        current = 0;
                    }
                    btnVsualNav.find("a").removeClass("on").eq(current).addClass("on");
                }
                function syncPosition2(el) {
                    if (syncedSecondary) {
                        var number = el.item.index;
                        visualSlide.data("owl.carousel").to(number, 100, true);
                    }
                }
                $('.magazine_area .links .links1').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 0)
                });
                $('.magazine_area .links .links2').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 1)
                });
                $('.magazine_area .links .links3').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 2)
                });
            });

            // homejok_pedia 슬라이드
            $(function() {
                //visual slide
                var visualSlide = $(".homejok_pedia .owl-carousel");
                var btnVsualNav = $(".homejok_pedia .links");
                var syncedSecondary = true;
                btnVsualNav.children("a").eq(0).addClass("on");
                visualSlide.owlCarousel({
                    animateOut: 'fadeOut',
                    mouseDrag: false,
                    loop: true,
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    smartSpeed: 100,
                    nav: false,
                    dots: true
                }).on("changed.owl.carousel", syncPosition);
                btnVsualNav.on("changed.owl.carousel", syncPosition2);
                function syncPosition(el) {
                    var count = el.item.count - 1;
                    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
                    if (current < 0) {
                        current = count;
                    }
                    if (current > count) {
                        current = 0;
                    }
                    btnVsualNav.find("a").removeClass("on").eq(current).addClass("on");
                }
                function syncPosition2(el) {
                    if (syncedSecondary) {
                        var number = el.item.index;
                        visualSlide.data("owl.carousel").to(number, 100, true);
                    }
                }
                $('.homejok_pedia .links .links1').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 0)
                });
                $('.homejok_pedia .links .links2').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 1)
                });
                $('.homejok_pedia .links .links3').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 2)
                });
                $('.homejok_pedia .links .links4').hover(function(){
                    visualSlide.trigger('to.owl.carousel', 3)
                });
            });

            // 공방 슬라이드
            $(".class_area .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                loop: true,
                items: 1,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed: 100,
                nav: false,
                dots: true
            });

            //오늘의 추천 이미지 커버 효과
            $(".main_goods_list a").mouseover (function(){
                $(this).find(".cover").removeClass("hidden");
            });

            //오늘의 추천 이미지 커버 효과
            $(".main_goods_list a").mouseout (function(){
                $(this).find(".cover").addClass("hidden");
            });

            //베스트리뷰 이미지 커버 효과
            $(".review_list a").mouseover (function(){
                $(this).find(".cover").removeClass("hidden");
            });

            //베스트리뷰 이미지 커버 효과
            $(".review_list a").mouseout (function(){
                $(this).find(".cover").addClass("hidden");
            });
        });
    })(jQuery);

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
                if ($height < $width) return "port";
                else return "land";
            });
        });
    };
    //이미지가 모두 로드 된 후 실행
    jQuery.event.add(window,"load",function(){
        calcImgSize();
    });
</script>


<script src="/assets/js/jquery.lazyload.min.js"></script>
<!-- lazyload 추가. -->

<script id="showRoom-template" type="text/x-handlebars-template">

    <div class="goods_img">
        <img src="{{src}}" width="120" height="120" alt="">
    </div>
    <span class="brand">
			{{brand}}
		</span>
    <span class="name">{{name}}</span>
    <span class="price">{{price}}</span>
    <a href="{{link}}" class="goods_link">Detail View <span class="spr-common spr_arrow_right"></span></a>

</script>

<script id="collection-template" type="text/x-handlebars-template">
    //2018-10-18 김지혜 삭제
    /*{{#list}}
    <li class="collection_item">
        <span class="collection_img"><img src="{{src}}" alt=""></span>
        <div class="collection_info">
            <span class="title">{{brand}}</span>
            <span class="option">{{name}}</span>
            <strong class="price js-price">

            </strong> {{#if info}}
            <span class="info">Information</span>
            <span class="info_text">{{{info}}}</span> {{/if}}
            <a href="{{link}}" class="btn_detail_view">Detail View<span class="spr-common spr_arrow_right"></span></a>
        </div>
    </li>
    {{/list}}*/
    //2018-10-18 김지혜 삭제  -- end
</script>
<!-- <li class="main_banner_item" style="background:url(/assets/images/data/main_banner_160921_01.jpg) no-repeat 50% 0">
    <a href="#" class="main_banner_link">
        <em class="title" style="text-align:center; width:100%; left:0; top:120px">내추럴한 거실 분위기 연출법</em>
        <span class="description" style="text-align:center; width:100%; left:0; top:195px">오크의 잔잔하고 고급스러운 온기가 느껴지는 내추럴우드 거실장</span>
    </a>
</li>
<li class="main_banner_item" style="background:url(/assets/images/data/main_banner_160921_02.jpg) no-repeat 50% 0">
    <a href="#" class="main_banner_link">
        <em class="title" style="width:100%; left:360px; top:199px; color:#604226;">북유럽 스타일을 완성하는 <br>패브릭 소품 기획전</em>
        <span class="description" style="width:100%; left:360px; top:335px; color:#604226;">상상후, 라임라잇, 데코토닉의 디자인 쿠션으로 북유럽 거실을 완성하세요.</span>
    </a>
</li>
<li class="main_banner_item" style="background:url(/assets/images/data/main_banner_160921_03.jpg) no-repeat 50% 0">
    <a href="#" class="main_banner_link">
        <em class="title" style="text-align:center; width:100%; left:0; top:120px;">패브릭소파로 연출하는 인테리어</em>
        <span class="description" style="text-align:center; width:100%; left:0; top:195px;" >편안한 패브릭 소파가 있는 거실공간을 만들어 보세요.</span>
    </a>
</li>
<li class="main_banner_item" style="background:url(/assets/images/data/main_banner_160921_04.jpg) no-repeat 50% 0">
    <a href="#" class="main_banner_link">
        <em class="title" style="width:100%; left:362px; top:179px">밤잠 설치는 <br />나의 가족을 위한 <br />시원한 침구</em>
        <span class="description" style="width:100%; left:362px; top:378px">체감 온도 낮춰주는 세사, 쉐르단, 나라데코 등의 ‘여름 침구’</span>
    </a>
</li> -->
<script>
    var collectionData = {
        list: [
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_01.jpg',
                'brand': '디센',
                'name': '패브릭퀼팅 132 에펠',
                'price': '72,000',
                'dc_price': '69,900',
                'info': '인체공학&유선형 디자인의<br />암체어 의자입니다. 튼튼한 하부 <br />프레임 및 원목다리로 제작된 <br />아이템 입니다 '
            },
            { // info 없을 경우
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_02.jpg',
                'brand': 'Hpix',
                'name': 'FLIP AROUND - LIGHT ASH',
                'price': '360,000',
                'dc_price': '348,000',
                // 'info' : '사이드 테이블, 스툴, 트레이 <br />겸용 제품입니다. 손잡이를 아래쪽으로<br />뒤집어서 다리와 연결하면 스툴이<br />됩니다. 디자인과 실용성을 모두 갖춘<br />스마트한 아이템입니다.'
            },
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_03.jpg',
                'brand': 'Hpix',
                'name': 'FLIP AROUND - LIGHT ASH',
                'price': '360,000',
                'dc_price': '348,000',
                'info': '사이드 테이블, 스툴, 트레이 <br />겸용 제품입니다. 손잡이를 아래쪽으로<br />뒤집어서 다리와 연결하면 스툴이<br />됩니다. 디자인과 실용성을 모두 갖춘<br />스마트한 아이템입니다.'
            },
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_04.jpg',
                'brand': '디센',
                'name': '패브릭퀼팅 132 에펠',
                'price': '69,900',
                'dc_price': '0',
                'info': '인체공학&유선형 디자인의<br />암체어 의자입니다. 튼튼한 하부 <br />프레임 및 원목다리로 제작된 <br />아이템 입니다 '
            },
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_01.jpg',
                'brand': 'Hpix',
                'name': 'FLIP AROUND - LIGHT ASH',
                'price': '360,000',
                'dc_price': '348,000',
                'info': '사이드 테이블, 스툴, 트레이 <br />겸용 제품입니다. 손잡이를 아래쪽으로<br />뒤집어서 다리와 연결하면 스툴이<br />됩니다. 디자인과 실용성을 모두 갖춘<br />스마트한 아이템입니다.'
            },
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_02.jpg',
                'brand': 'Hpix',
                'name': 'FLIP AROUND - LIGHT ASH',
                'price': '360,000',
                'dc_price': '348,000',
                'info': '사이드 테이블, 스툴, 트레이 <br />겸용 제품입니다. 손잡이를 아래쪽으로<br />뒤집어서 다리와 연결하면 스툴이<br />됩니다. 디자인과 실용성을 모두 갖춘<br />스마트한 아이템입니다.'
            },
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_03.jpg',
                'brand': 'Hpix',
                'name': 'FLIP AROUND - LIGHT ASH',
                'price': '360,000',
                'dc_price': '348,000',
                'info': '사이드 테이블, 스툴, 트레이 <br />겸용 제품입니다. 손잡이를 아래쪽으로<br />뒤집어서 다리와 연결하면 스툴이<br />됩니다. 디자인과 실용성을 모두 갖춘<br />스마트한 아이템입니다.'
            },
            {
                'link': '#',
                'src': '/assets/images/data/160808_main_collection_04.jpg',
                'brand': 'Hpix',
                'name': 'FLIP AROUND - LIGHT ASH',
                'price': '360,000',
                'dc_price': '348,000',
                'info': '사이드 테이블, 스툴, 트레이 <br />겸용 제품입니다. 손잡이를 아래쪽으로<br />뒤집어서 다리와 연결하면 스툴이<br />됩니다. 디자인과 실용성을 모두 갖춘<br />스마트한 아이템입니다.'
            }]
    };

    /*
        -- YIC 쪽 http://www.etah.co.kr/assets/js2/goods_func.js 의 OpGoods_price 를 참고하여 신규 작성.
        -- callback 함수를 호출 할 수 있도록 수정.
        -- ui.etah 에서는 동작 하지 않음.
        -- dev 혹은 real 에 올라가야 확인이 가능.....
    */
    function OpGoods_price__call(goods_code, callback)
    {
        $.ajax(
            {
                type: 'POST',
                async: false,
                url: '/goods/goods_price',
                dataType: 'json',
                data:
                    {
                        goods_code: goods_code
                    },
                error: function(res)
                {
                    // alert('Database Error');

                    // locall test code S
                    // var price = {
                    // 	'selling_price' : 16000, // 판매가
                    // 	'coupon_price'  : 14000 // 할인적용가 / 할인적용가가 없을 경우 0
                    // };
                    // if( callback ) {
                    // 	callback ( price );
                    // }
                    // else {
                    // 	return price;
                    // }
                    // locall test code E
                },
                success: function(res)
                {
                    if (res.status == 'ok')
                    {
                        var price = {
                            'selling_price': res.selling_price, // 판매가
                            'coupon_price': res.coupon_price // 할인적용가 / 할인적용가가 없을 경우 0
                        };
                        if (callback)
                        {
                            callback(price);
                        }
                        else
                        {
                            return price;
                        }
                    }
                    else alert(res.message);
                }
            });
    };

    function newItemPriceInsert(_data)
    {
        if (!_data) return false;
        var data = _data,
            $box = $('#newItem'),
            $priceAreas = $box.find(data.html.block),
            total = data.codes.length,
            successCounter = 0,
            priceData = [];
        var returnPercent = function(num, total)
        {
            return 100 - Math.round((num / total) * 100);
        };

        var setComma = function(num)
        {
            var str = String(num);
            return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
        };
        var createHtm = function()
        {
            $.each($priceAreas, function(index)
            {
                var priceHtm = (function()
                    {
                        if (parseInt(priceData[index].coupon_price, 10) !== 0)
                        { // 할인 적용가가 0일경우 할인율이 없으므로 판매가 적용.
                            return data.html.price.replace(data.discount, setComma(priceData[index].coupon_price));
                        }
                        else
                        {
                            return data.html.price.replace(data.discount, setComma(priceData[index].selling_price));
                        }
                    })(),
                    dcPriceHtm = (function()
                    {
                        if (parseInt(priceData[index].coupon_price, 10) !== 0)
                        {
                            return data.html.dc_price
                                .replace(data.price, setComma(priceData[index].selling_price))
                                .replace(data.percent, returnPercent(priceData[index].coupon_price, priceData[index].selling_price));
                        }
                        else
                        {
                            return '<span class="dc_price"></span>';
                        }
                    })();
                $(this).append(priceHtm).append(dcPriceHtm);
            });
        };
        $.each(data.codes, function(index)
        {
            // console.log( index );
            OpGoods_price__call(this, function(price)
            {
                priceData[index] = price;
                successCounter++;
                if (successCounter === total)
                {
                    createHtm();
                }
            });
        });
    }

    // showroom view.
    function showRoomFnc(data)
    {
        var $block = $('#showRoomList'),
            $objs = $block.find('.show_room_info'),
            $infoDetail = $('#showRoomInfoDetail'),
            timer = null;
        var showInfo = function($element)
        {
            var code = $element.data('code'),
                posX = parseInt($element.css('left'), 10),
                posY = parseInt($element.css('top'), 10),
                source = $('#showRoom-template').html(),
                template = Handlebars.compile(source),
                html = $(template(data[code]));

            $infoDetail.trigger('mouseenter').html(html)
            if ($infoDetail.css('display') === 'none')
            {
                $infoDetail.fadeIn('fast').css(
                    {
                        'top': posY + $element.height(),
                        'left': posX + $element.width()
                    });
            }
            else
            {
                $infoDetail.fadeIn('fast').animate(
                    {
                        'top': posY + $element.height(),
                        'left': posX + $element.width()
                    });
            }
        };
        var hideInfo = function() {

        };
        var hideInfoTimer = function()
        {
            if (timer === null)
            {
                timer = setTimeout(function()
                {
                    $infoDetail.fadeOut('fast');
                }, 500);
            };

        }
        $objs.on('mouseenter', function()
        {
            showInfo($(this));
        }).on('mouseleave', function()
        {
            hideInfoTimer();
        });
        $infoDetail.on('mouseenter', function()
        {
            if (timer !== null)
            {
                clearTimeout(timer);
                timer = null;
            }
        }).on('mouseleave', function()
        {
            hideInfoTimer();
        });
    };

    //2018-10-18 김지혜 삭제
    /*function collection(data)
    {
        var $block = $('#collection_list'),
            source = $('#collection-template').html(),
            template = Handlebars.compile(source),
            html = $(template(data)),
            dragBtn = $('#dragBtn'),
            dragLine = $('#dragLine'),
            dragMax = 1150,
            boxW = 440,
            boxMargin = 20,
            descriptionW = 275,
            totalWidth = 0,
            counter = 0,
            addMargin = 0,
            page = 0,
            totalPage = data.list.length,
            updatePageW = dragMax / (totalPage - 1);

        var addMarginFnc = function()
        {
            return $(window).width() / 440 / 2;
        };

        var windowCenter = function()
        {
            return $(window).width() / 2;
        };
        var activeChecker = function(element)
        {
            if (element.index() !== page)
            {
                element.animate(
                {
                    'width': boxW
                },
                {
                    'duration': 200,
                    'easing': 'easeOutQuad',
                    complete: function()
                    {
                        $(this).removeClass('active');
                    }
                });
            }
        }
        var blockPos = function(next)
        {
            if (page === next)
            {
                return false
            }
            else
            {
                page = next;
            }

            var pos = windowCenter() - ((boxW + boxMargin) / 2 + (boxW + boxMargin) * page);
            // console.log(pos)
            $block.find('.active').animate(
            {
                'width': boxW
            },
            {
                'duration': 200,
                'easing': 'easeOutQuad',
                complete: function()
                {
                    $(this).removeClass('active');
                }
            });

            $block.stop().animate(
            {
                'margin-left': pos
            },
            {
                'duration': 200,
                'easing': 'linear',
                complete: function()
                {

                    $block.find('.collection_item').eq(page).animate(
                    {
                        'width': boxW + descriptionW
                    },
                    {
                        'duration': 200,
                        'easing': 'easeInQuad',
                        complete: function()
                        {
                            $(this).addClass('active');
                            activeChecker($(this));
                        }
                    })

                    // $block.find('.collection_item').eq(page).find('.collection_info').show('slide',function(){
                    // 	$(this).parent().addClass('active');
                    // });
                }
            });
        };
        var returnPercent = function(num, total)
        {
            return 100 - Math.round((parseInt(num, 10) / parseInt(total, 10)) * 100);
        };
        // $.each( html.find('img'), function(){
        // 	$(this).one('load', function(){
        // 		var _this = $(this);
        // 		// _this.data('width', _this.width()+20 );
        // 		// console.log(counter , data.list.length)
        // 		// if( counter === data.list.length-1 ){
        // 		// 	totalWidth += _this.data('width');
        // 		// 	$block.css({
        // 		// 		'width': totalWidth + descriptionW
        // 		// 	});
        // 		// } else {
        // 		// 	counter ++;
        // 		// 	totalWidth += _this.data('width');
        // 		// }
        // 	});
        // } );
        $.each(html.find('.js-price'), function(index)
        {
            var htm = '';
            if (data.list[index].dc_price !== '0')
            {
                htm += '<span class="js-discount">' + data.list[index].dc_price + '</span>';
                htm += '<span class="dc_price"><s class="del_price">' + data.list[index].price + '</s>';
                htm += ' (' + returnPercent(data.list[index].dc_price, data.list[index].price) + '% <span class="spr-common spr_ico_arrow_down"></span>)';

            }
            else
            {
                htm += '<span class="js-discount">' + data.list[index].price + '</span>'
            }
            $(this).append(htm);
        });
        $block.css('width', (boxW + boxMargin) * (totalPage) + descriptionW);
        $block.html(html);
        dragBtn.draggable(
        {
            axis: 'x',
            containment: "parent",
            cursor: "move",
            create: function(event, ui)
            {
                var next = Math.floor(575 / updatePageW);
                blockPos(next);
                // console.log(page);
            },
            drag: function(event, ui)
            {
                //console.log( ui.position.left );

                var next = Math.floor(ui.position.left / updatePageW);
                blockPos(next);
                // console.log(page);
            },
            start: function(event, ui) {

            },
            stop: function(event, ui) {

            }
        });
        $(window).on('resize', function()
        {
            var pos = windowCenter() - ((boxW + boxMargin) / 2 + (boxW + boxMargin) * page);
            $block.stop().animate(
            {
                'margin-left': pos
            },
            {
                'duration': 200,
                'easing': 'linear'
            });
        });
    };*/

    /*var bigBannerArray = [
        '<li class="main_banner_item" style="background-image:url(/assets/images/data/171109_main_banner_01.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="#" class="main_banner_link"><em class="title" style="left:348px; top:175px;">심플한 디자인과<br>합리적인 가성비를<br>중시한다면?!</em><span class="description" style="left:352px; top:375px;">감성 디자인 가구 트리빔하우스, 최대 50% 할인!</span></a></li>',
        '<li class="main_banner_item" style="background-image:url(/assets/images/data/171109_main_banner_02.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="#" class="main_banner_link"><em class="title" style="left:348px; top:195px;">실내 온도 높이는<br>아늑한 러그 모음</em><span class="description" style="left:352px; top:328px;">아늑한 러그 모음</span></a></li>',
        '<li class="main_banner_item" style="background-image:url(/assets/images/data/171109_main_banner_03.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="#" class="main_banner_link"><em class="title" style="left:348px; top:175px;">가격, 기능, 디자인,<br>어느 하나도 놓칠수 없는<br>당신에게...</em><span class="description" style="left:352px; top:375px;">동화속나무 전 제품 할인!</span></a></li>',
        '<li class="main_banner_item" style="background-image:url(/assets/images/data/171109_main_banner_04.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="#" class="main_banner_link"><em class="title" style="left:348px; top:195px;">홈 카페<br>완성하기 참 쉽다~</em><span class="description" style="left:352px; top:328px;">칼리타, 하리오, 러브라믹스 최대 20% 할인</span></a></li>'
    ];

    $(function()
    {
        if ($('body').data('showroom') === true)
        {
            showRoomFnc(showRoomData);
        }
        else
        {
            $('#show_room').hide();
        }
        if ($('body').data('newitem') === true)
        {
            newItemPriceInsert(newItemData)
        }
        if ($('body').data('collection') === true)
        {
            collection(collectionData);
        }
        else
        {
            $('#collectionBlock').hide();
        }

        $('.lazy-img').lazyload(
        {
            'dffect': 'fadeIn',
            'data_attribute': 'origin'
        });

        etahUi.bigBanner(
        {
            htmlArray: bigBannerArray
        });

        // 2016-11-11

        function getRandomArbitrary(min, max)
        {
            return Math.random() * (max - min) + min;
        }

        // new item / new brand 를 랜덤으로 노출.
        if (Math.floor(getRandomArbitrary(0, 2)) === 0)
        {
            changeItemBrandTab('I');
        }
        else
        {
            changeItemBrandTab('B')
        }

        // best item / etah's choice 를 랜덤으로 노출.
        // 개발 반영시 사용하시려면 주석을 풀어 주세요.
        // if( Math.floor( getRandomArbitrary( 0, 2 ) ) === 0 ){
        // 	getEtahChoice('B');
        // } else {
        // 	getEtahChoice('E');
        // }

    });*/
    //2018-10-18 김지혜 삭제  -- end


    //=====================================
    // NEW ITEM, BRAND 탭 변경
    //=====================================
    function changeItemBrandTab(val)
    {
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

    // 2016-08-23 성능 개선을 위한 수정.
    // function mainTabMenu(){
    // 	var tabBox = $('.main_tab_list'),
    // 	 	tabItems = tabBox.find('.main_tab_item'),
    // 		tabLink = tabItems.find('a'),
    // 		brandCont = $('#newBrand'),
    // 		newItemCont = $('#newItem');
    // 		tabLink.click(function(){
    // 			var thisHref = $(this).attr('href');
    // 			tabLink.parents(tabItems).removeClass('active');
    // 			$(this).parents(tabItems).addClass('active');

    // 			if( $(this).attr('href') === '#newBrand' ) {
    // 				if( !brandCont.data('html') ) {
    // 					brandCont.html( $('#newBrandHtml').html() );
    // 					brandCont.data('html', true);
    // 				}
    // 				brandCont.show();
    // 				newItemCont.hide();
    // 			} else {
    // 				$('.new_item').hide();
    // 				$('.new_brand').hide();
    // 				$(thisHref).show();

    // 			}
    // 			return false;
    // 		})

    // }
    // mainTabMenu();
</script>