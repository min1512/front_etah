<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-04-05
 * Time: 오후 3:48
 */
?>
<link rel="stylesheet" href="/assets/css/display.css">
<div class="contents magazine">

    <div class="nav" id="nav">
        <h1 class="nav_title">매거진</h1>

        <ul class="nav_list">
            <?for($i=0;$i<count($nav['CATEGORY_CD1']);$i++) {?>
                <li class="nav_item <?=substr($nav['CATEGORY_CD1'][$i], 0, 1) == substr($cate_cd ,0 ,1) ? "active" : ""?>">
                    <a href="#" class="nav_link"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <ul class="nav_list_2depth">
                        <?for($j=0;$j<count($nav['CATEGORY_CD2']);$j++) {?>
                            <li><a href="/magazine/list/<?=$nav['CATEGORY_CD2'][$i][$j]?>" <?=$nav['CATEGORY_CD2'][$i][$j] == $cate_cd ? "class='active'" : ""?>><?=$nav['CATEGORY_NM2'][$i][$j]?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?}?>
        </ul>
    </div>

    <h2 class="title_page title_page__line">
        <b>매거진 상품 모아보기</b>
        <span style="float:right;font-size:11pt;"><sub>전체 <?=$totalCnt?></sub></span>
    </h2>
    <?if(count($goodsList) == 0) {?>
        <br><br>
        <h3 style="text-align: center">상품이 없습니다.</h3>
    <?} else {?>
        <br><br>
        <div class="basic_goods_list">
            <ul class="goods_list">
                <?foreach($goodsList as $grow){?>
                    <li class="goods_item">
                        <div class="img">
                            <a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="img_link">
                                <img src="<?=$grow['IMG_URL']?>" alt="">
                                <div class="tag-wrap">
                                    <?if(!empty($grow['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
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
                                            <?=$grow['BRAND_NM']?>
                                        </span>
                            <span class="name"><?=$grow['GOODS_NM']?></span>
                            <span class="price">
                                            <?
                                            if($grow['COUPON_CD_S'] || $grow['COUPON_CD_G']){
    //											$price = $grow['SELLING_PRICE'] - $grow['RATE_PRICE'] - $grow['AMT_PRICE'];
                                                $price = $grow['SELLING_PRICE'] - ($grow['RATE_PRICE_S'] + $grow['RATE_PRICE_G']) - ($grow['AMT_PRICE_S'] + $grow['AMT_PRICE_G']);
                                                echo number_format($price);
                                                ?>
                                                <span class="dc_price">
                                                <s class="del_price"><?=number_format($grow['SELLING_PRICE'])?></s> (<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)
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
    <?}?>

    <?=$pagination?>
</div>

<script type="text/javascript">
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