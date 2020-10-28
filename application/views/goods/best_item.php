			<link rel="stylesheet" href="/assets/css/display.css?ver=1.3">

			<div class="contents etah_best_item">
                <div class="nav" id="nav">
                    <h1 class="nav_title">베스트 100</h1>
                    <ul class="nav_list">
                        <li class="nav_item"><a href="/goods/best_item" class="nav_link">전체</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=10000000" class="nav_link">가구</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=11000000" class="nav_link">인테리어소품</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=14000000" class="nav_link">조명</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=19000000" class="nav_link">주방</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=22000000" class="nav_link">식품</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=21000000" class="nav_link">디지털/가전</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=17000000" class="nav_link">생활/욕실</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=15000000" class="nav_link">침구</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=23000000" class="nav_link">뷰티</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=13000000" class="nav_link">DIY</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=16000000" class="nav_link">가드닝</a></li>
                        <li class="nav_item"><a href="/goods/best_item?C=24000000" class="nav_link">에타홈클래스</a></li>
                    </ul>
                </div>

                <div class="contents_inner">
                    <div class="location position_area">
                        <ul class="location_list position_right">
                            <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                            <li class="location_item"><a href="/goods/best_item" <?if($CATE_CD==''){?>class="active"<?}?>>베스트 100</a></li>
                            <?if(!empty($CATE_CD)){?>
                                <li class="location_item"><a href="/goods/best_item?C=<?=$CATE_CD?>" class="active"><span class="spr-common spr_arrow_right"></span><?=$CATE_NM?></a></li>
                            <?}?>
                        </ul>
                    </div>

                    <h2 class="page_title">
                        베스트 100
                    </h2>

                    <div class="basic_goods_list">
                        <ul class="goods_list">
                            <?
                            $idx=1;
                            foreach($goods as $row){?>
                            <li class="goods_item">
                                <div class="img">
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="img_link">
                                        <img src="<?=$row['IMG_URL']?>" alt="" width="290" height="290">
                                        <div class="tag-wrap">
                                            <?if(!empty($row['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                            <?if($row['CLASS_GUBUN']=='C'){?><!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
                                            <?if($row['CLASS_GUBUN']=='G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                                        </div>
                                    </a>
                                    <ul class="goods_action_menu">
                                        <li class="goods_action_item">
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$row['GOODS_CD']?>','','');">
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
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_pinter"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">핀터레스트</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$row['GOODS_CD']?>','','<?=$row['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_kakao"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">카카오스토리</span>
                                                    </button>
                                                </li>
                                                <li class="goods_sns_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
                                                        <span class="spr-common spr_share_facebook"></span>
                                                        <span class="spr-common spr-bgcircle3"></span>
                                                        <span class="button_text">페이스북</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="goods_item_link">
                                    <span class="best_num"><?=$idx?></span>
                                    <span class="brand">
                                        <?=$row['BRAND_NM']?>
                                    </span>
                                    <span class="name"><?=$row['GOODS_NM']?></span>
                                    <!--<span class="price">
                                        <?=number_format($row['SELLING_PRICE'])?>
                                        <span class="dc_price"><s class="del_price">452,000</s> (25%<span class="spr-common spr_ico_arrow_down"></span>)</span>
                                    </span>-->
                                    <span class="price">
                                        <?
                                        if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                            $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                            echo number_format($price);
                                            $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <!--<span class="dc_price">
                                            <s class="del_price"><?=number_format($row['SELLING_PRICE'])?></s> (<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                        </span>-->
                                        <span class="dc_price">
                                            <s class="del_price"><?=number_format($row['SELLING_PRICE'])?></s> (<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                        </span>
                                        <!--<span class="spr-common spr_ico_coupon"></span>-->
                                        <?}else{
                                            echo number_format($price = $row['SELLING_PRICE']);
                                        }?>
                                    </span>
                                    <span class="icon_block">
                                        <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                        ?>
                                        <span class="spr-common spr_ico_coupon"></span>
                                        <?
                                        }
                                        if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                        ?>
                                        <span class="spr-common spr_ico_mileage"></span>
                                        <?
                                        }
                                        if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){
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
                </div>
			</div>
            <!--GA script-->
            <script>
                //Impression
//                ga('require', 'ecommerce', 'ecommerce.js');
//                <?//foreach ($goods as $grow){?>
//                ga('ecommerce:addImpression', {
//                    'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
//                    'name': "<?//=$grow['GOODS_NM']?>//",
//                    'category': <?//=$grow['CATEGORY_CD']?>//,
//                    'brand': '<?//=$grow['BRAND_NM']?>//',
//                    'list': 'Best_item Results'
//                });
//                <?//}?>
//                ga('ecommerce:send');
//
//                //action
//                function onProductClick(param,param2) {
//                    var goods_cd = param;
//                    var goods_nm = param2;
//                    ga('ecommerce:addProduct', {
//                        'id': goods_cd,
//                        'name': goods_nm
//                    });
//                    ga('ecommerce:setAction', 'click', {list: 'Best_item Results'});
//
//                    // Send click with an event, then send user to product page.
//                    ga('send', 'event', 'UX', 'click', 'Results', {
//                        hitCallback: function() {
//                            //alert(goods_cd + '/' + goods_nm);
//                            document.location = '/goods/detail/'+goods_cd;
//                        }
//                    });
//                }
            </script>
            <!--/GA script-->