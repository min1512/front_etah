
<!--2018.10.18기준 이전 메인화면-->
<link rel="stylesheet" href="/assets/css/main.css">
<link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css">

<div class="contents main">
    <div class="main_banner" id="mainBanner">
        <ul class="main_banner_list">
        </ul>
        <ul class="main_banner_btn_list">
        </ul>
    </div>

    <div class="new_area">
        <ul class="main_tab_list">
            <li class="main_tab_item" id="main_tab_item">
                <a href="javaScript:changeItemBrandTab('I');">WEEKLY THEME</a>
            </li>
            <li class="main_tab_item" id="main_tab_brand">
                <a href="javaScript:changeItemBrandTab('B');">BRAND FOCUS</a>
            </li>
        </ul>
        <div id="newItem" class="new_item" style="display:none;">
            <?=$new_item[0]['DISP_HTML']?>
            <script>
                var newItemData = {
                    'html' : {
                        'block' : 'strong.js-price',
                        'price' : '<span class="js-discount">{{discount}}</span>',
                        'dc_price' : '<span class="dc_price"><s class="del_price">{{price}}</s> ({{percent}} % <span class="spr-common spr_ico_arrow_down"></span> )</span>'
                    },
                    'discount' : '{{discount}}',
                    'price' : '{{price}}',
                    'percent' : '{{percent}}',
                    'codes' : ['1215683','1099385','1091847','1225599']
                };
            </script>
        </div>

        <div id="newBrand" class="new_brand" style="display:none;">
            <script id="newBrandHtml" type="text">
							<?=$new_brand[0]['DISP_HTML']?>
			</script>
        </div>
    </div>

    <?if($showroom[0]['DISP_HTML']){?>
        <div class="show_room" id="show_room">
            <?=$showroom[0]['DISP_HTML']?>

        </div>

    <?}else{?>
        <div class="show_room" id="show_room"></div>
        <script>var showRoomData = "";</script>
    <?}?>


    <div class="best_area">
        <h4 class="title_style">MD 픽!</h4>
        <div id="etahsChoice" class="main_goods_list">
            <ul class="goods_list">
                <?foreach($etah_choice as $erow){?>
                    <li class="goods_item">
                        <div class="img">
                            <a href="<?=$erow['LINK_URL']?>"><img src="<?=$erow['IMG_URL']?>" width="290" height="290" alt=""></a>
                            <ul class="goods_action_menu">
                                <li class="goods_action_item">
                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$erow['GOODS_CD']?>','','');">
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
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$erow['GOODS_CD']?>','<?=$erow['IMG_URL']?>','<?=$erow['NAME']?>');">
                                                <span class="spr-common spr_share_pinter"></span>
                                                <span class="spr-common spr-bgcircle3"></span>
                                                <span class="button_text">핀터레스트</span>
                                            </button>
                                        </li>
                                        <li class="goods_sns_item">
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$erow['GOODS_CD']?>','','<?=$erow['NAME']?>');">
                                                <span class="spr-common spr_share_kakao"></span>
                                                <span class="spr-common spr-bgcircle3"></span>
                                                <span class="button_text">카카오스토리</span>
                                            </button>
                                        </li>
                                        <li class="goods_sns_item">
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$erow['GOODS_CD']?>','<?=$erow['IMG_URL']?>','<?=$erow['NAME']?>');">
                                                <span class="spr-common spr_share_facebook"></span>
                                                <span class="spr-common spr-bgcircle3"></span>
                                                <span class="button_text">페이스북</span>
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <a href="<?=$erow['LINK_URL']?>" class="goods_item_link">
									<span class="brand">
										<?=$erow['BRAND_NM']?>
									</span>
                            <span class="name"><?=$erow['NAME']?></span>
                            <!--<span class="price"><?=number_format($erow['SELLING_PRICE'])?></span>-->
                            <span class="price">
										<?
                                        if($erow['COUPON_CD']){
                                            $price = $erow['SELLING_PRICE'] - $erow['RATE_PRICE'] - $erow['AMT_PRICE'];
                                            echo number_format($price);


                                            $sale_percent = (($erow['SELLING_PRICE'] - $price)/$erow['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <!--<span class="dc_price">
											<s class="del_price"><?=number_format($erow['SELLING_PRICE'])?></s> (<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-->
                                            <span class="dc_price">
											<s class="del_price"><?=number_format($erow['SELLING_PRICE'])?></s> (<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
                                        <?}else{
                                            echo number_format($erow['SELLING_PRICE']);
                                        }
                                        ?>
									</span>
                        </a>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>

    <div class="collection_area" id="collectionBlock">
        <h4 class="title_style"><?=$collection_t[0]['NAME'] ? $collection_t[0]['NAME'] : "COLLECTION"?></h4>
        <div class="collection_wrap">
            <ul class="collection_list" id="collection_list">

            </ul>
            <div class="drag_controller">
                <div class="drag_area">
                    <div type="button" class="drag_btn" style="left:575px;" id="dragBtn"><img src="/assets/images/display/btn_drag.png" alt=""></div>
                    <div class="line" id="dragLine"></div>
                </div>
            </div>
            <?foreach($collection as $crow){?>
                <input type="hidden" name="LINK_URL[]"			value="<?=$crow['LINK_URL']?>">
                <input type="hidden" name="IMG_URL[]"			value="<?=$crow['IMG_URL']?>">
                <input type="hidden" name="BRAND_NM[]"			value="<?=$crow['BRAND_NM']?>">
                <input type="hidden" name="GOODS_CD[]"			value="<?=$crow['GOODS_CD']?>">
                <input type="hidden" name="NAME[]"				value="<?=$crow['NAME']?>">
                <input type="hidden" name="SELLING_PRICE[]"		value="<?=number_format($crow['SELLING_PRICE'])?>">
                <input type="hidden" name="PROMOTION_PHRASE[]"	value="<?=$crow['PROMOTION_PHRASE']?>">
            <?}?>
        </div>
    </div>

    <div class="magazine_area">
        <h4 class="title_style">매거진</h4>
        <ul class="main_magazine_list">
            <?foreach($magazine as $mrow){?>
                <li class="main_magazine_item">
                    <a href="<?=$mrow['LINK_URL']?>" class="main_magazine_link">
                        <img src="<?=$mrow['MAGAZINE_IMG_URL']?>" alt="배너이미지" width="290" height="290" onerror="this.src='/assets/images/data/main_magazin_6.jpg'" class="lazy-img" data-origin="<?=$mrow['MAGAZINE_IMG_URL']?>" data-origin="" alt="배너이미지" />
                        <span class="main_magazine_text">
									<em class="main_magazine_brand"><?=$mrow['NAME'][0]?></em>
                            <?if(isset($mrow['NAME'][1])){?>
                                <span class="main_magazine_explain">2016 인디룸 출시기념 이벤트</span>
                            <?}?>
								</span>
                    </a>
                </li>
            <?}?>
        </ul>
        <a href="/magazine" class="btn_more">more <span class="spr-common spr_arrow_right"></span></a>
    </div>

    <div class="brand_area">
        <ul class="main_brand_tab_list">
            <li class="main_brand_tab_item_01 active" id="main_brand_tab_item_01">
                <!--<a href="#mainBrandCont01">-->
                <a href="javaScript:changeBrandTab(1);">
                    <img src="<?=$brand_menu[0]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
                    <span class="main_brand_tab_line"></span>
                </a>
            </li>
            <li class="main_brand_tab_item_02" id="main_brand_tab_item_02">
                <a href="javaScript:changeBrandTab(2);">
                    <img src="<?=$brand_menu[1]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
                    <span class="main_brand_tab_line"></span>
                </a>
            </li>
            <li class="main_brand_tab_item_03" id="main_brand_tab_item_03">
                <a href="javaScript:changeBrandTab(3);">
                    <img src="<?=$brand_menu[2]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
                    <span class="main_brand_tab_line"></span>
                </a>
            </li>
            <li class="main_brand_tab_item_04" id="main_brand_tab_item_04">
                <a href="javaScript:changeBrandTab(4);">
                    <img src="<?=$brand_menu[3]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
                    <span class="main_brand_tab_line"></span>
                </a>
            </li>
        </ul>
        <!-- mainBrandCont01 // -->


        <?
        $bRand = rand(1,3);
        $bTitle = "";
        $arr_brand = array();

        switch($bRand){
            case '1' :	$bTItle = "";
                $arr_brand[0] = 3;
                $arr_brand[1] = 6;		break;
            case '2' :	$bTItle = "main_brand_list__type02";
                $arr_brand[0] = 1;
                $arr_brand[1] = 8;		break;
            case '3' :	$bTItle = "main_brand_list__type03";
                $arr_brand[0] = 2;
                $arr_brand[1] = 7;		break;
        }
        ?>
        <ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont01" style="display: block;">

            <?
            $bidx = 1;
            foreach($brand as $b1){
                if($b1['GUBUN'] == 'MAIN_BRAND1'){
                    if($b1['SEQ'] > 0){?>
                        <li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
                            <a href="<?=$b1['LINK_URL']?>" class="main_brand_link">
                                <span class="main_brand_img"><img src="<?=$b1['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>"  onerror="this.src='/assets/images/data/no_images.jpg'"/></span>
                                <span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b1['BRAND_NM']?></em>
										<span class="text"><?=$b1['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b1['COUPON_CD']){
                                        $price = $b1['SELLING_PRICE'] - $b1['RATE_PRICE'] - $b1['AMT_PRICE'];
                                        $sale_percent = (($b1['SELLING_PRICE'] - $price)/$b1['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b1['SELLING_PRICE'])?></s> (<?=floor((($b1['SELLING_PRICE']-$price)/$b1['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b1['SELLING_PRICE'])?></s> (<?=floor((($b1['SELLING_PRICE']-$price)/$b1['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                    <?}else{
                                        echo number_format($price = $b1['SELLING_PRICE']);
                                    }?>
									</strong>
								</span>
                                <span class="main_brand_line"></span>
                                <span class="main_brand_info_bg"></span>
                            </a>
                        </li>
                        <?
                        $bidx++;
                    }
                }
            }?>
        </ul>
        <!-- // mainBrandCont01 -->

        <!-- mainBrandCont02 // -->


        <?
        $bRand = rand(1,3);
        $bTitle = "";
        $arr_brand = array();

        switch($bRand){
            case '1' :	$bTItle = "";
                $arr_brand[0] = 3;
                $arr_brand[1] = 6;		break;
            case '2' :	$bTItle = "main_brand_list__type02";
                $arr_brand[0] = 1;
                $arr_brand[1] = 8;		break;
            case '3' :	$bTItle = "main_brand_list__type03";
                $arr_brand[0] = 2;
                $arr_brand[1] = 7;		break;
        }
        ?>
        <ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont02">
            <?
            $bidx = 1;
            foreach($brand as $b2){
                if($b2['GUBUN'] == 'MAIN_BRAND2'){
                    if($b2['SEQ'] > 0){?>

                        <li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
                            <a href="<?=$b2['LINK_URL']?>" class="main_brand_link">
                                <span class="main_brand_img"><img src="<?=$b2['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" onerror="this.src='/assets/images/data/no_images.jpg'"/></span>
                                <span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b2['BRAND_NM']?></em>
										<span class="text"><?=$b2['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b2['COUPON_CD']){
                                        $price = $b2['SELLING_PRICE'] - $b2['RATE_PRICE'] - $b2['AMT_PRICE'];
                                        $sale_percent = (($b2['SELLING_PRICE'] - $price)/$b2['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b2['SELLING_PRICE'])?></s> (<?=floor((($b2['SELLING_PRICE']-$price)/$b2['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b2['SELLING_PRICE'])?></s> (<?=floor((($b2['SELLING_PRICE']-$price)/$b2['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                    <?}else{
                                        echo number_format($price = $b2['SELLING_PRICE']);
                                    }?>
									</strong>
								</span>
                                <span class="main_brand_line"></span>
                                <span class="main_brand_info_bg"></span>
                            </a>
                        </li>
                        <?
                        $bidx++;
                    }
                }
            }?>
        </ul>
        <!-- // mainBrandCont02 -->

        <!-- mainBrandCont03 // -->

        <?
        $bRand = rand(1,3);
        $bTitle = "";
        $arr_brand = array();

        switch($bRand){
            case '1' :	$bTItle = "";
                $arr_brand[0] = 3;
                $arr_brand[1] = 6;		break;
            case '2' :	$bTItle = "main_brand_list__type02";
                $arr_brand[0] = 1;
                $arr_brand[1] = 8;		break;
            case '3' :	$bTItle = "main_brand_list__type03";
                $arr_brand[0] = 2;
                $arr_brand[1] = 7;		break;
        }
        ?>
        <ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont03">
            <?
            $bidx = 1;
            foreach($brand as $b3){
                if($b3['GUBUN'] == 'MAIN_BRAND3'){
                    if($b3['SEQ'] > 0){?>

                        <li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
                            <a href="<?=$b3['LINK_URL']?>" class="main_brand_link">
                                <span class="main_brand_img"><img src="<?=$b3['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" onerror="this.src='/assets/images/data/no_images.jpg'" /></span>
                                <span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b3['BRAND_NM']?></em>
										<span class="text"><?=$b3['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b3['COUPON_CD']){
                                        $price = $b3['SELLING_PRICE'] - $b3['RATE_PRICE'] - $b3['AMT_PRICE'];
                                        $sale_percent = (($b3['SELLING_PRICE'] - $price)/$b3['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b3['SELLING_PRICE'])?></s> (<?=floor((($b3['SELLING_PRICE']-$price)/$b3['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b3['SELLING_PRICE'])?></s> (<?=floor((($b3['SELLING_PRICE']-$price)/$b3['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                    <?}else{
                                        echo number_format($price = $b3['SELLING_PRICE']);
                                    }?>
									</strong>
								</span>
                                <span class="main_brand_line"></span>
                                <span class="main_brand_info_bg"></span>
                            </a>
                        </li>
                        <?
                        $bidx++;
                    }
                }
            }?>
        </ul>
        <!-- // mainBrandCont03 -->

        <!-- mainBrandCont04 // -->
        <?
        $bRand = rand(1,3);
        $bTitle = "";
        $arr_brand = array();

        switch($bRand){
            case '1' :	$bTItle = "";
                $arr_brand[0] = 3;
                $arr_brand[1] = 6;		break;
            case '2' :	$bTItle = "main_brand_list__type02";
                $arr_brand[0] = 1;
                $arr_brand[1] = 8;		break;
            case '3' :	$bTItle = "main_brand_list__type03";
                $arr_brand[0] = 2;
                $arr_brand[1] = 7;		break;
        }
        ?>
        <ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont04">
            <?
            $bidx = 1;
            foreach($brand as $b4){
                if($b4['GUBUN'] == 'MAIN_BRAND4'){
                    if($b4['SEQ'] > 0){?>

                        <li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
                            <a href="<?=$b4['LINK_URL']?>" class="main_brand_link">
                                <span class="main_brand_img"><img src="<?=$b4['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" onerror="this.src='/assets/images/data/no_images.jpg'"/></span>
                                <span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b4['BRAND_NM']?></em>
										<span class="text"><?=$b4['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b4['COUPON_CD']){
                                        $price = $b4['SELLING_PRICE'] - $b4['RATE_PRICE'] - $b4['AMT_PRICE'];
                                        $sale_percent = (($b4['SELLING_PRICE'] - $price)/$b4['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b4['SELLING_PRICE'])?></s> (<?=floor((($b4['SELLING_PRICE']-$price)/$b4['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b4['SELLING_PRICE'])?></s> (<?=floor((($b4['SELLING_PRICE']-$price)/$b4['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                    <?}else{
                                        echo number_format($price = $b4['SELLING_PRICE']);
                                    }?>
									</strong>
								</span>
                                <span class="main_brand_line"></span>
                                <span class="main_brand_info_bg"></span>
                            </a>
                        </li>
                        <?
                        $bidx++;
                    }
                }
            }?>
        </ul>
        <!-- // mainBrandCont04 -->
    </div>
    <!-- 메인프로모션 레이어 // -->
    <div class="layer layer__view layer_main01" id="layer_main_pop01" style="visibility:hidden">
        <div class="layer_inner">
            <div class="layer_cont">
                <!-- <a href="/goods/event/66"><img src="/assets/images/data/main_popup02_181001.jpg" alt=""></a> -->
                <a href="/goods/event/66"><img src="/assets/images/data/main_popup02_181016.jpg" alt=""></a>
                <a href="http://www.etah.co.kr/goods/event/375"><img src="/assets/images/data/main_popup03_180910.jpg" alt=""></a>
            </div>
            <div class="bottom-wrap">
                <div class="checkbox_area">
                    <input type="checkbox" class="checkbox" id="formMainClose"> <label class="checkbox_label" for="formMainClose">오늘 하루 열지 않음</label>
                </div>
                <a href="#layer_main_pop01" id="full_layer_close" data-ui="layer-closer" class="spr-common btn_close">닫기 X</a>
            </div>
        </div>
    </div>
    <!-- // 메인프로모션 레이어 -->
</div>
<script src="/assets/js/common.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
<script>
    (function($) {
        $(document).ready(function(){
            //팝업슬라이드
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
        });
    })(jQuery);
</script>

<script type="text/javascript">
    //========================================
    //오늘 하루 창 닫기
    //========================================
    $(document).ready(function() {
        //alert($.cookie('layer_main_pop01'));
        if($.cookie('layer_main_pop01') != 'hidden'){
            $('#layer_main_pop01').show();
            $('#layer_main_pop01').css('visibility','visible');
            //console.log(true);
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

    //========================================
    //천단위 콤마
    //========================================
    function numberFormat(num) {
        num = String(num);
        return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,"$1,");
    }

    /**********************/
    /** 천단위 콤마 제거 **/
    /**********************/
    function renumberFormat(num){
        return num.replace(/^\$|,/g, "") + ""
    }

    //=====================================
    // NEW ITEM, BRAND 탭 변경
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
</script>

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
    {{#list}}
    <li class="collection_item">
        <span class="collection_img"><img src="{{src}}" alt="" width="440" height="440"></span>
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
    {{/list}}
</script>

<script>
    var cnt_collection = "<?=count($collection)?>";
    var aJsonArray = new Array();
    var aJson = new Object();
    for(i=0; i<cnt_collection; i++){
        dc = OpGoods_price(document.getElementsByName("GOODS_CD[]")[i].value)['coupon_price'];
        aJson = {
            link : document.getElementsByName("LINK_URL[]")[i].value,
            src : document.getElementsByName("IMG_URL[]")[i].value,
            brnad : document.getElementsByName("BRAND_NM[]")[i].value,
            name : document.getElementsByName("NAME[]")[i].value,
            price : document.getElementsByName("SELLING_PRICE[]")[i].value,
            dc_price : numberFormat(dc),
            info : document.getElementsByName("PROMOTION_PHRASE[]")[i].value
        };

        aJsonArray.push(aJson);
    }

    var collectionData = {
        list : 	aJsonArray

    };

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
                    alert('Database Error');
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
                        {
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

    };


    function collection(data)
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
                    }
                });
        };
        var returnPercent = function(num, total)
        {
            return 100 - Math.round((parseInt(renumberFormat(num)) / parseInt(renumberFormat(total))) * 100);
        };
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
    };


    var bigBannerArray = [
        '<?=$rolling_top?>'
    ];

    $(function()
    {
        if ($('body').data('showroom') === true)
        {
            showRoomFnc(/*showRoomData*/);
        }
        else
        {
            $('#show_room').hide();
        }
        if( $('body').data('newitem') === true )
        {
            newItemPriceInsert( newItemData )
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
        //메인 팝업 슬라이드
        etahUi.bigBanner(
            {
                htmlArray: bigBannerArray
            });
    });

    //new item best item 랜덤 스크립트
    function getRandomArbitrary ( min, max ){
        return Math.random() * ( max - min ) + min;
    }
    // new item / new brand 를 랜덤으로 노출.
    if( Math.floor( getRandomArbitrary( 0, 2 ) ) === 0 ){
        changeItemBrandTab('I');
    } else {
        changeItemBrandTab('B')
    }
</script>