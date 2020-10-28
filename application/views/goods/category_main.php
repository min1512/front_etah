<link rel="stylesheet" href="/assets/css/display.css?ver=1.2">

<div class="contents contents__nav cpp">
    <div class="nav" id="nav">
        <h1 class="nav_title"><?=$category['CATE_NAME3']?></h1>

        <ul class="nav_list">
            <?for($a=0; $a<count($nav['CATEGORY_CD1']); $a++){?>
                <li class="nav_item">
                    <a href="#" class="nav_link"><?=$nav['CATEGORY_NM1'][$a]?></a>
                    <ul class="nav_list_2depth">
                        <?for($b=0; $b<count($nav['CATEGORY_CD2'][$a]); $b++){?>
                            <li><a href="/goods/list/<?=$nav['CATEGORY_CD2'][$a][$b]?>"><?=$nav['CATEGORY_NM2'][$a][$b]?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?}?>
        </ul>
    </div>

    <div class="contents_inner ">
        <div class="location position_area">
            <ul class="location_list position_right">
                <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="/category/main/<?=$category['CATE_CODE3']?>" class="active"><?=$category['CATE_NAME3']?></a></li>
            </ul>
        </div>
        <?if($top[0]['DISP_HTML']){?>
            <div class="cpp_banner" id="cppBanner">
                <ul class="cpp_banner_list">
                    <!--<li class="cpp_banner_item" style="z-index: 1; background-image: url('/assets/images/data/cpp_banner_1.jpg');" id="cpp_banner_item1">
                        <a href="#">
                            <em class="title">우리집 거실에서<br />나를 즐겁게 하는 소파</em>
                            <span class="description" style=""> Dodot 블라스코 로쉐 민트 소파 30% 할인</span>
                        </a>
                    </li>
                    <li class="cpp_banner_item" style="z-index: 1; background-image: url('/assets/images/data/cpp_banner_2.jpg');" id="cpp_banner_item2">
                        <a href="#">
                            <em class="title">우리집 거실에서<br />나를 즐겁게 하는 소파</em>
                            <span class="description"> Dodot 블라스코 로쉐 민트 소파 30% 할인</span>
                        </a>
                    </li>
                    <li class="cpp_banner_item" style="z-index: 1; background-image: url('/assets/images/data/cpp_banner_3.jpg');" id="cpp_banner_item3">
                        <a href="#">
                            <em class="title">우리집 거실에서<br />나를 즐겁게 하는 소파</em>
                            <span class="description"> Dodot 블라스코 로쉐 민트 소파 30% 할인</span>
                        </a>
                    </li>
                    <li class="cpp_banner_item" style="z-index: 1; background-image: url('/assets/images/data/cpp_banner_4.jpg');" id="cpp_banner_item4">
                        <a href="#">
                            <em class="title">우리집 거실에서<br />나를 즐겁게 하는 소파</em>
                            <span class="description"> Dodot 블라스코 로쉐 민트 소파 30% 할인</span>
                        </a>
                    </li>-->
                </ul>
                <?=$top[0]['DISP_HTML']?>
                <ul class="cpp_banner_btn_list">
                    <!--<li class="cpp_banner_btn_item active" id="cpp_banner_btn_item1">
                        <a href="#"><img src="/assets/images/display/big_banner_page.png" alt="" /></a>
                    </li>
                    <li class="cpp_banner_btn_item" id="cpp_banner_btn_item2">
                        <a href="#"><img src="/assets/images/display/big_banner_page.png" alt="" /></a>
                    </li>
                    <li class="cpp_banner_btn_item" id="cpp_banner_btn_item3">
                        <a href="#"><img src="/assets/images/display/big_banner_page.png" alt="" /></a>
                    </li>
                    <li class="cpp_banner_btn_item" id="cpp_banner_btn_item4">
                        <a href="#"><img src="/assets/images/display/big_banner_page.png" alt="" /></a>
                    </li>-->
                </ul>
            </div>
        <?}?>

        <?if($md_goods[0]['NAME']){?>
            <!--<div class="ethas_chioce">
						<h4 class="title_style">ETAH’S CHOICE</h4>
						<ul class="cpp_goods_list">
							<li class="cpp_goods_item">
								<a href="<?=$md_goods[0]['LINK_URL']?>" class="cpp_goods_link">
									<span class="cpp_goods_info" style="background-color:#<?=$md_goods[0]['RGB']?>">
										<span class="brand"><?=$md_goods[0]['BRAND_NM']?></span>
									<span class="name"><?=$md_goods[0]['GOODS_NM']?></span>
									<strong class="price"><?=number_format($md_goods[0]['SELLING_PRICE'])?></strong>
									</span>
									<span class="cpp_goods_img">
										<img src="<?=$md_goods[0]['IMG_URL']?>" alt="" />
									</span>
									<span class="bg"></span>
								</a>
							</li>
							<li class="cpp_goods_item cpp_goods_item__big">
								<a href="<?=$md_goods[1]['LINK_URL']?>" class="cpp_goods_link">
									<span class="cpp_goods_img" style="background-color:#<?=$md_goods[1]['RGB']?>">
										<img src="<?=$md_goods[1]['IMG_URL']?>" alt="" />
									</span>
									<span class="cpp_goods_info" style="background-color:#<?=$md_goods[1]['RGB']?>">
										<span class="brand"><?=$md_goods[1]['BRAND_NM']?></span>
									<span class="name"><?=$md_goods[1]['GOODS_NM']?></span>
									<strong class="price"><?=number_format($md_goods[1]['SELLING_PRICE'])?></strong>
									</span>
									<span class="bg"></span>
								</a>
							</li>
							<li class="cpp_goods_item">
								<a href="<?=$md_goods[2]['LINK_URL']?>" class="cpp_goods_link">
									<span class="cpp_goods_img">
										<img src="<?=$md_goods[2]['IMG_URL']?>" alt="" />
									</span>
									<span class="cpp_goods_info" style="background-color:#<?=$md_goods[2]['RGB']?>">
										<span class="brand"><?=$md_goods[2]['BRAND_NM']?></span>
									<span class="name"><?=$md_goods[2]['GOODS_NM']?></span>
									<strong class="price"><?=number_format($md_goods[2]['SELLING_PRICE'])?></strong>
									</span>
									<span class="bg"></span>
								</a>
							</li>
							<li class="cpp_goods_item">
								<a href="<?=$md_goods[3]['LINK_URL']?>" class="cpp_goods_link">
									<span class="cpp_goods_info" style="background-color:#<?=$md_goods[3]['RGB']?>">
										<span class="brand"><?=$md_goods[3]['BRAND_NM']?></span>
									<span class="name"><?=$md_goods[3]['GOODS_NM']?></span>
									<strong class="price"><?=number_format($md_goods[3]['SELLING_PRICE'])?></strong>
									</span>
									<span class="cpp_goods_img">
										<img src="<?=$md_goods[3]['IMG_URL']?>" alt="" />
									</span>
									<span class="bg"></span>
								</a>
							</li>
							<li class="cpp_goods_item min_layout_item">
								<a href="<?=$md_goods[4]['LINK_URL']?>" class="cpp_goods_link">
									<span class="cpp_goods_img">
										<img src="<?=$md_goods[4]['IMG_URL']?>" alt="" />
									</span>
									<span class="cpp_goods_info" style="background-color:#<?=$md_goods[4]['RGB']?>">
										<span class="brand"><?=$md_goods[4]['BRAND_NM']?></span>
									<span class="name"><?=$md_goods[4]['GOODS_NM']?></span>
									<strong class="price"><?=number_format($md_goods[4]['SELLING_PRICE'])?></strong>
									</span>
									<span class="bg"></span>
								</a>
							</li>
							<li class="cpp_goods_item cpp_goods_item__big min_layout_item">
								<a href="<?=$md_goods[5]['LINK_URL']?>" class="cpp_goods_link">
									<span class="cpp_goods_img" style="background-color:#<?=$md_goods[5]['RGB']?>">
										<img src="<?=$md_goods[5]['IMG_URL']?>" alt="" />
									</span>
									<span class="cpp_goods_info" style="background-color:#<?=$md_goods[5]['RGB']?>">
										<span class="brand"><?=$md_goods[5]['BRAND_NM']?></span>
									<span class="name"><?=$md_goods[5]['GOODS_NM']?></span>
									<strong class="price"><?=number_format($md_goods[5]['SELLING_PRICE'])?></strong>
									</span>
									<span class="bg"></span>
								</a>
							</li>
						</ul>
					</div>-->


            <div class="tag-wrap">
                <?if(!empty($md_pick[$i]['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
            </div>



            <div class="ethas_chioce">
                <h4 class="title_style">THE CHOICE</h4>
                <ul class="cpp_goods_list">
                    <li class="cpp_goods_item">
                        <a href="/goods/detail/<?=$md_goods[0]['GOODS_CD']?>" class="cpp_goods_link">
                            <span class="cpp_goods_img"><img src="<?=$md_goods[0]['IMG_URL']?>" alt=""></span>
                            <div class="tag-wrap">
                                <?if(!empty($md_goods[0]['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                            </div>
                            <span class="cpp_goods_info">
										<em class="brand"><?=$md_goods[0]['BRAND_NM']?></em>
										<span class="name"><?=$md_goods[0]['NAME']?></span>
									<strong class="price">
										<?
                                        if($md_goods[0]['COUPON_CD']){
                                            $price = $md_goods[0]['SELLING_PRICE'] - $md_goods[0]['RATE_PRICE'] - $md_goods[0]['AMT_PRICE'];
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($md_goods[0]['SELLING_PRICE'] - $price)/$md_goods[0]['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <!--<span class="dc_price"><s class="del_price"><?=number_format($md_goods[0]['SELLING_PRICE'])?></s> (<?=floor((($md_goods[0]['SELLING_PRICE']-$price)/$md_goods[0]['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
                                            <span class="dc_price"><s class="del_price"><?=number_format($md_goods[0]['SELLING_PRICE'])?></s> (<?=floor((($md_goods[0]['SELLING_PRICE']-$price)/$md_goods[0]['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                        <?}else{
                                            echo number_format($md_goods[0]['SELLING_PRICE']);
                                        }?>
									</strong>
									</span>
                            <span class="cpp_goods_bg"></span>
                            <span class="cpp_goods_info_bg" style="background: #<?=$md_goods[0]['RGB']?>;"></span>
                        </a>
                    </li>
                    <li class="cpp_goods_item">
                        <a href="/goods/detail/<?=$md_goods[1]['GOODS_CD']?>" class="cpp_goods_link">
                            <span class="cpp_goods_img"><img src="<?=$md_goods[1]['IMG_URL']?>" alt="이미지"></span>
                            <div class="tag-wrap">
                                <?if(!empty($md_goods[1]['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                            </div>
                            <span class="cpp_goods_info">
										<em class="brand"><?=$md_goods[1]['BRAND_NM']?></em>
										<span class="name"><?=$md_goods[1]['NAME']?></span>
									<strong class="price">
										<?
                                        if($md_goods[1]['COUPON_CD']){
                                            $price = $md_goods[1]['SELLING_PRICE'] - $md_goods[1]['RATE_PRICE'] - $md_goods[1]['AMT_PRICE'];
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($md_goods[1]['SELLING_PRICE'] - $price)/$md_goods[1]['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <!--<span class="dc_price"><s class="del_price"><?=number_format($md_goods[1]['SELLING_PRICE'])?></s> (<?=floor((($md_goods[1]['SELLING_PRICE']-$price)/$md_goods[1]['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>	-->
                                            <span class="dc_price"><s class="del_price"><?=number_format($md_goods[1]['SELLING_PRICE'])?></s> (<?=floor((($md_goods[1]['SELLING_PRICE']-$price)/$md_goods[1]['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                        <?}else{
                                            echo number_format($md_goods[1]['SELLING_PRICE']);
                                        }?>
									</strong>
									</span>
                            <span class="cpp_goods_bg"></span>
                            <span class="cpp_goods_info_bg" style="background: #<?=$md_goods[1]['RGB']?>;"></span>
                        </a>
                    </li>
                    <li class="cpp_goods_item">
                        <a href="/goods/detail/<?=$md_goods[2]['GOODS_CD']?>" class="cpp_goods_link">
                            <span class="cpp_goods_img"><img src="<?=$md_goods[2]['IMG_URL']?>" alt="이미지"></span>
                            <div class="tag-wrap">
                                <?if(!empty($md_goods[2]['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                            </div>
                            <span class="cpp_goods_info">
										<em class="brand"><?=$md_goods[2]['BRAND_NM']?></em>
										<span class="name"><?=$md_goods[2]['NAME']?></span>
									<strong class="price">
										<?
                                        if($md_goods[2]['COUPON_CD']){
                                            $price = $md_goods[2]['SELLING_PRICE'] - $md_goods[2]['RATE_PRICE'] - $md_goods[2]['AMT_PRICE'];
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($md_goods[2]['SELLING_PRICE'] - $price)/$md_goods[2]['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <!--<span class="dc_price"><s class="del_price"><?=number_format($md_goods[2]['SELLING_PRICE'])?></s> (<?=floor((($md_goods[2]['SELLING_PRICE']-$price)/$md_goods[2]['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>	-->
                                            <span class="dc_price"><s class="del_price"><?=number_format($md_goods[2]['SELLING_PRICE'])?></s> (<?=floor((($md_goods[2]['SELLING_PRICE']-$price)/$md_goods[2]['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                        <?}else{
                                            echo number_format($md_goods[2]['SELLING_PRICE']);
                                        }?>
									</strong>
									</span>
                            <span class="cpp_goods_bg"></span>
                            <span class="cpp_goods_info_bg" style="background: #<?=$md_goods[2]['RGB']?>;"></span>
                        </a>
                    </li>
                </ul>
            </div>
        <?}?>


        <?if($weekly_best){?>
            <div class="weekly_best">
                <h4 class="title_style">WEEKLY BEST</h4>
                <!-- 상품 리스트 // -->
                <div class="basic_goods_list">
                    <ul class="goods_list">
                        <?
                        $idx = 1;
                        foreach($weekly_best as $wrow){?>
                            <li class="goods_item<?=$idx > 10 ? " min_layout_item" : ""?>">
                                <div class="img">
                                    <a href="/goods/detail/<?=$wrow['GOODS_CD']?>" class="img_link">
                                        <img src="<?=$wrow['IMG_URL']?>" alt="">
                                        <div class="tag-wrap">
                                            <?if(!empty($wrow['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                        </div>
                                    </a>
                                    <ul class="goods_action_menu">
                                        <!--<li class="goods_action_item">
                                            <button type="button" class="action_btn">
                                                <span class="spr-common spr_cart"></span>
                                                <span class="spr-common spr-bgcircle2"></span>
                                                <span class="button_text">Add Cart</span>
                                            </button>
                                        </li>-->
                                        <li class="goods_action_item">
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$wrow['GOODS_CD']?>','','');">
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
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$wrow['GOODS_CD']?>','<?=$wrow['IMG_URL']?>','<?=$wrow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_pinter"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">핀터레스트</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$wrow['GOODS_CD']?>','','<?=$wrow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_kakao"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">카카오스토리</span>
                                                    </button>
                                                </li>
                                                <!--<li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
                                                        <span class="spr-common spr_share_insta"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">인스타</span>
                                                    </button>
                                                </li>-->
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$wrow['GOODS_CD']?>','<?=$wrow['IMG_URL']?>','<?=$wrow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_facebook"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">페이스북</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>

                                </div>
                                <a href="/goods/detail/<?=$wrow['GOODS_CD']?>" class="goods_item_link">
										<span class="brand">
											<?=$wrow['BRAND_NM']?>
										</span>
                                    <span class="name"><?=$wrow['GOODS_NM']?></span>
                                    <span class="price">
										<?
                                        if($wrow['COUPON_CD_S'] || $wrow['COUPON_CD_G']){
//											$price = $wrow['SELLING_PRICE'] - $wrow['RATE_PRICE'] - $wrow['AMT_PRICE'];
                                            $price = $wrow['SELLING_PRICE'] - ($wrow['RATE_PRICE_S'] + $wrow['RATE_PRICE_G']) - ($wrow['AMT_PRICE_S'] + $wrow['AMT_PRICE_G']);
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($wrow['SELLING_PRICE'] - $price)/$wrow['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <!--<span class="dc_price">
											<s class="del_price"><?=number_format($wrow['SELLING_PRICE'])?></s> (<?=floor((($wrow['SELLING_PRICE']-$price)/$wrow['SELLING_PRICE'])*100) == 0 ? 1 : floor((($wrow['SELLING_PRICE']-$price)/$wrow['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-->
                                            <span class="dc_price">
											<s class="del_price"><?=number_format($wrow['SELLING_PRICE'])?></s> (<?=floor((($wrow['SELLING_PRICE']-$price)/$wrow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
                                            <!--<span class="spr-common spr_ico_coupon"></span>-->
                                        <?}else{
                                            echo number_format($price = $wrow['SELLING_PRICE']);
                                        }?>
										</span>
                                    <span class="icon_block">
											<?if($wrow['COUPON_CD_S'] || $wrow['COUPON_CD_G']){
                                                ?>
                                                <span class="spr-common spr_ico_coupon"></span>
                                                <?
                                            }
                                            if($wrow['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                                ?>
                                                <span class="spr-common spr_ico_mileage"></span>
                                                <?
                                            }
                                            if(($wrow['PATTERN_TYPE_CD'] == 'FREE') || ( $wrow['DELI_LIMIT'] > 0 && $price > $wrow['DELI_LIMIT'])){
                                                ?>
                                                <span class="spr-common spr_ico_free_shipping"></span>
                                            <?}?>
										</span>
                                </a>
                            </li>
                            <?
                            $idx++;
                        }?>
                    </ul>
                </div>
                <!-- // 상품 리스트 -->
            </div>
        <?}?>

        <?if($this->uri->segment(3)==20000000){?>
            <!-- srp -->
            <div class="srp">
                <div class="basic_goods_list">
                    <h2 class="title_page title_page__line">
                        <b>상품</b><em class="bold_yel">(<?=number_format(count($goods_list))?>개)</em>
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
                                        default :echo '인기순';break;
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
                        <?foreach($goods_list as $grow){?>
                            <li class="goods_item">
                                <div class="img">
                                    <a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="img_link"><img src="<?=$grow['IMG_URL']?>" alt=""></a>
                                    <div class="tag-wrap">
                                        <?if(!empty($grow['DEAL'])){?> <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                        <?if($grow['CLASS_GUBUN'] == 'C'){?> <!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
                                        <?if($grow['CLASS_GUBUN'] == 'G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                                    </div>
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
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$grow['GOODS_CD']?>','<?=$grow['IMG_URL']?>','<?=$grow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_pinter"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">핀터레스트</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$grow['GOODS_CD']?>','','<?=$grow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_kakao"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">카카오스토리</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$grow['GOODS_CD']?>','<?=$grow['IMG_URL']?>','<?=$grow['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_facebook"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">페이스북</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="goods_item_link">
									<span class="brand">
                                        <?if($grow['CLASS_GUBUN'] == 'C'){?>[<?=$grow['ADDRESS']?>][<?=$grow['CLASS_TYPE']?>]<?}?>
                                        <?if($grow['CLASS_GUBUN'] == 'G'){?>[<?=$grow['CLASS_TYPE']?>]<?}?>
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
                                            <span class="dc_price">
											<s class="del_price"><?=number_format($grow['SELLING_PRICE'])?></s> (<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
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
            </div>
            <!-- //srp -->
        <?}?>


        <?if($rcmd[0]['DISP_HTML']){?>
            <div class="brand_recommend">
                <h4 class="title_style">BRAND RECOMMENDATION</h4>
                <!--<ul class="brand_recommend_list">
                    <li class="brand_recommend_item" style="background-image: url('/assets/images/data/brand_banner_1.jpg')">
                        <a href="#" class="brand_recommend_link">
                            <em class="title">Multisofa Launching Sale</em>
                            <span class="description"><strong>Byheydey</strong> 멀티소파와 함께 특별한 거실을 만들자.</span>
                        </a>
                    </li>
                    <li class="brand_recommend_item" style="background-image: url('/assets/images/data/brand_banner_2.jpg')">
                        <a href="#" class="brand_recommend_link">
                            <em class="title">Original Firack Up To 30%</em>
                            <span class="description"><strong>Dodot</strong> 오리지널 국민 선반장 피/랙 할인전</span>
                        </a>
                    </li>
                </ul>-->
                <?=$rcmd[0]['DISP_HTML']?>
            </div>
        <?}?>
    </div>
</div>

<script type="text/javascript">
    //====================================
    // 조건별 검색
    //====================================
    function search_goods(kind, val)
    {
        var cate_gb     = '<?=$cate_gb?>';
        var cate_cd     = '<?=$cate_cd?>';
        var order_by    = '<?=$order_by?>';
        var deliv_type  = '<?=$deliv_type?>';
        var country     = '<?=$country?>';
        var price_limit = '<?=$price_limit?>';


        //정렬
        if(kind=='O') {
            order_by = val;
        }

        //카테고리
        if(kind=='C') {
            cate_cd = val;
        }

        //배송
        if(kind=='D') {
            if($('input:checkbox[name="status"]').is(":checked")) {
                val = 'FREE';
            } else {
                val = '';
            }

            deliv_type = val;
        }

        //국가
        if(kind=='N') {
            $("input[name=search_country]:checked").each(function() {
                val += '|'+$(this).val();
            });

            country = val;
        }

        //가격
        if(kind=='P') {
            price_limit = val;
        }

        document.location.href = "/category/main/<?=$this->uri->segment(3)?>?cate_cd="+cate_cd+"&cate_gb="+cate_gb+"&order_by="+order_by+"&deliv_type="+deliv_type+"&country="+country+"&price_limit="+price_limit;


    }
</script>

<script src="/assets/js/common.js"></script>
<script type="text/javascript">
    //				var bigBannerArray = [
    //					'<li class="cpp_banner_item" style="z-index: 1; background-image:url(http://ui.etah.co.kr/assets/images/data/cpp_banner_1_1.jpg);"><a href="#"><em class="title">심플하면서 엣지 있는<br />디자인 원목가구</em><span class="description">다름의 미학 엔토코(ntoco)</span></a></li>'
    //				];

    <?
    //직구샵인 경우 스크립트 사용안함
    if($top_html){?>
        var bigBannerArray = [
            "<?=$top_html?>"
        ];

        etahUi.bigBanner(
            {
                box: $('#cppBanner'),
                insertHtmlArea: $('#cppBanner').find('.cpp_banner_list'),
                pageElement: '<li class="cpp_banner_btn_item"><a href="#"><img src="/assets/images/display/big_banner_page.png" alt=""></a></li> ',
                pageBlock: $('#cppBanner').find('.cpp_banner_btn_list'),
                selectClass: 'active',
                autoSec: 5000,
                htmlArray: bigBannerArray
            });

        etahUi.bigBanner(
            {
                box: $('#cppBanner'),
                list: $('#cppBanner').find('.cpp_banner_item'),
                pageElement: '<li class="cpp_banner_btn_item"><a href="#"><img src="/assets/images/display/big_banner_page.png" alt=""></a></li> ',
                pageBlock: $('#cppBanner').find('.cpp_banner_btn_list'),
                selectClass: 'active',
                autoSec: 5000
            });
    <?}?>


    // 차후 수정 예정
    var nav = $('#nav'),
        navLink = nav.find('.nav_link'),
        itemParent = $('.nav_item'),
        add = 'active';

    $(navLink).click(function()
    {
        var thisParent = $(this).parents('.nav_item');
        $(itemParent).find('.nav_list_2depth').stop().slideUp();

        if ($(thisParent).hasClass(add))
        {
            $(thisParent).addClass(add);
            $(thisParent).find('.nav_list_2depth').stop().slideUp();
        }
        else
        {
            $(thisParent).removeClass(add);
            $(thisParent).find('.nav_list_2depth').stop().slideDown();
        };
        return false;
    });
</script>