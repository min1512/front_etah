<?
$cookieGoodsCd = get_cookie("limit_cd");

if($goods['BUY_LIMIT_QTY'] !='0'){
    $buyMaxCnt = $goods['BUY_LIMIT_QTY'];
}else{
    $buyMaxCnt = 10000;
}
?>

<link rel="stylesheet" href="/assets/css/display.css?ver=1.4.3">
<link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css?ver=1.3">
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",
                ti:"35025",
                ty:"Item",
                device:"web"
                ,items:[{i:"<?=$goods['GOODS_CD']?>",      t:"<?=$goods['GOODS_NM']?>"}]
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>

<div class="contents vip01">
    <div class="location position_area">
        <h2 class="title_page">
            <?=$goods['GOODS_STATE_CD'] != '03' ? "<font color=\"red\">[".$goods['GOODS_STATE']."]</font>" : "" ?>[<?=$goods['BRAND_NM']?>] <?=$goods['GOODS_NM']?>
        </h2>
        <ul class="location_list position_right">
            <li class="location_item"><a href="\">홈</a><span class="spr-common spr_arrow_right"></span></li>
            <li class="location_item"><a href="/category/main/<?=$goods['CATEGORY_MNG_CD1']?>"><?=$goods['CATEGORY_MNG_NM1']?></a><span class="spr-common spr_arrow_right"></span></li>
            <li class="location_item"><a href="/goods/mid_list/<?=$goods['CATEGORY_MNG_CD2']?>"><?=$goods['CATEGORY_MNG_NM2']?></a><span class="spr-common spr_arrow_right"></span></li>
            <li class="location_item"><a href="/goods/list/<?=$goods['CATEGORY_MNG_CD3']?>" class="active"><?=$goods['CATEGORY_MNG_NM3']?></a></li>
        </ul>
    </div>

    <div class="vip_banner" id="vip_banner">
        <!-- 상품 하나일 경우 클래스 vip_banner_one 추가 -->
        <!--					<ul class="vip_banner_corver"></ul>-->
        <ul class="vip_banner_list">
        </ul>

        <a href="#" class="btn_left">
            <img src="/assets/images/display/btn_left.png" alt="이전배너" />
        </a>
        <a href="#" class="btn_right">
            <img src="/assets/images/display/btn_right.png" alt="다음배너" />
        </a>
        <ul class="vip_banner_btn">

        </ul>
    </div>


    <div class="vip_event_banner">
        <?if(count($tag)!=0){?>
            <h3 class="vip_section_title">연관태그</h3>
            <div class="vip_hashtag">
                <?foreach($tag as $tt){?>
                    <a href="/goods2/goods_search?keyword=<?=$tt['TAG_NM']?>&gb=T&tag_keyword=<?=$tt['TAG_NM']?>">#<?=$tt['TAG_NM']?></a>
                <?}?>
            </div>
        <?}?>

        <h3 class="vip_section_title">에타홈 이벤트</h3>
        <table>
            <tbody>
            <tr>
                <td><a href="<?=$event[0]['BANNER_LINK_URL']?>"><img src="<?=$event[0]['BANNER_IMG_URL']?>" alt="" style="width: 100%;"></a></td>
                <td><a href="<?=$event[1]['BANNER_LINK_URL']?>"><img src="<?=$event[1]['BANNER_IMG_URL']?>" alt="" style="width: 100%;"></a></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="vip_inner">
        <div class="tab_menu_wrap">
            <ul class="tab_menu">
                <li class="tab_item active"><a href="#prdImg" class="tab_link">상품정보</a></li>
                <!-- 활성화시 클래스 active 추가 -->
                <li class="tab_item"><a href="#prdRecommend" class="tab_link">추천</a></li>
                <li class="tab_item"><a href="#prdComment" class="tab_link">상품평<?if($cmt_total!=0){?><b style="color:#3A3A3A"><?}?>(<?=$cmt_total?>)<?if($cmt_total!=0){?></b><?}?></a></li>
                <li class="tab_item"><a href="#prdInquiry" class="tab_link">상품문의<?if($qna_total!=0){?><b style="color:#3A3A3A"><?}?>(<?=$qna_total?>)<?if($qna_total!=0){?></b><?}?></a></li>
            </ul>
        </div>

        <div class="vip_prd_info">
            <!-- 상품정보 // -->
            <div class="vip_prd_info_cont func1" id="prdImg">
                <h3 class="info_cont_title">상품정보</h3>
                <?if(count($mdTalk)!=0){?>
                    <div class="vip_md_ment">
                        <h3 class="vip_md_ment_title">MD 추천멘트</h3>
                        <div class="vip_md_ment_contents">
                            <?foreach($mdTalk as $trow){?>
                                <?if($trow['GOODS_DESC_MD_GB_CD']=='TEXT'){?>
                                    <p><?=nl2br($trow['HEADER_DESC'])?></p>
                                <?}?>
                                <?if($trow['GOODS_DESC_MD_GB_CD']=='VIDEO'){?>
                                    <div style="position: relative; padding-top: 56%;">
                                        <iframe src="https://www.youtube.com/embed/<?=$trow['HEADER_DESC']?>" frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%;height: 100%;"></iframe>
                                    </div>
                                <?}?>
                                <?if($trow['GOODS_DESC_MD_GB_CD']=='IMAGE'){?>
                                    <br><img src="<?=$trow['HEADER_DESC']?>" />
                                <?}?>
                            <?}?>
                        </div>
                    </div>
                <?}?>

                <!-- 아이프레임영역 - 아이프레임 높이 스크립트로 제어필요. // -->
                <iframe class="iframe" src="/goods/iframe_prd?goods_code=<?=$goods['GOODS_CD']?>" width="100%"  scrolling="no" border="no" marginwidth="0" marginheight="0" frameborder="0" id="iframe_prd_info"></iframe>
                <!-- // 아이프레임영역 -->

                <?if($goods['CATEGORY_MNG_CD2'] == 24010000){?>
                    <!--지도영역 // -->
                    <div class="vip_basic_info">
                        <div id="map" style="width:830px;height:316px;"></div>

                        <div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);">
                            <a href="https://map.kakao.com" target="_blank" style="float: left;">
                                <img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px">
                            </a>
                            <div style="float: right; position: relative; top: 1px; font-size: 11px;">
                                <a id="path" target="_blank" href="#" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a>
                            </div>
                        </div>
                    </div>
                    <!-- // 지도영역 -->
                <?}?>

                <?if($goods['VENDOR_SUBVENDOR_CD']==10240){?>
                    <div class="kluft_thanks_gift">
                        <img src="/assets/images/data/kluft_reservation_page_PC2.jpg">
                        <div class="vip_btn_wrap">
                            <a type="button" class="" onClick="javascript:jsReservationLayer('<?= $goods['GOODS_CD']?>');">
                                <img src="/assets/images/data/btn_kluft.png" alt="" />
                            </a>
                        </div>
                    </div>
                <?}?>

                <div class="vip_basic_info">
                    <h3 class="info_cont_title">상품&frasl;거래조건 기본정보</h3>
                    <table class="normal_table normal_table__bg">
                        <caption class="hide">배송지정보 입력표</caption>
                        <colgroup>
                            <col style="width:252px" />
                            <col />
                        </colgroup>
                        <tbody>
                        <?  $idx=0;
                        if(isset($goods_extend_info)){
                            foreach($goods_extend_info as $row){	?>
                                <tr>
                                    <th sope="row"><?=$row['branch_name']?></th>
                                    <td><?=$goods_extend['article'.$idx]?></td>
                                </tr>

                                <? $idx++;
                            }
                        }?>
                        </tbody>
                    </table>
                </div>

                <!-- 배송정보 // -->
                <div class="vip_basic_info">
                    <h3 class="info_cont_title">배송정보</h3>
                    <ul class="vip_prd_info_text_list">
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>배송 방법</span>
                            <span class="text"><?=$goods['DELIV_COMPANY_CD'] == '99' ? $goods['BRAND_NM']." 브랜드는 직접 배송을 원칙으로 합니다." : $goods['DELIV_COMPANY_NM']?></span>
                        </li>
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>배송 지역</span>
                            <span class="text">
                                    <?//$str = strvar($goods['DELIV_POLICY_NO']);
                                    $ints = (int)'203174';
                                    if($goods['DELIV_POLICY_NO'] == $ints){?>
                                        서울/경기<?=/*$goods_no_deli[0]['DELIV_AREA_CD'] == true*/ isset($goods_no_deli) ? "(도서/일부 지역은 배송이 불가능 합니다.)" : ""?>
                                    <?}else{?>
                                        전국<?=/*$goods_no_deli[0]['DELIV_AREA_CD'] == true*/ isset($goods_no_deli) ? "(도서/일부 지역은 배송이 불가능 합니다.)" : ""?>
                                    <?}?>
                                    </span>
                        </li>
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>배송 비용</span>
                            <span class="text">
									<? $i=0;
                                    if(@$goods_add_deli){
                                        foreach($goods_add_deli as $row){
                                            if($i==0){
                                                if($goods['PATTERN_TYPE_CD'] == 'PRICE'){
                                                    if($goods['DELI_LIMIT'] > 0){
                                                        if($goods['DELI_LIMIT']>$goods['COUPON_PRICE']){
                                                            $DELI_COST = $goods['DELI_COST'];	?>
                                                            <?=number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)"?>
                                                        <?		} else {
                                                            $DELI_COST = 0;	?>
                                                            무료배송(배송비 유,무/배송표 필 참조)
                                                        <?		}
                                                    } else {
                                                        if($goods['DELI_COST'] != 0){
                                                            $DELI_COST = $goods['DELI_COST'];	?>
                                                            <?=number_format($goods['DELI_COST'])."원"?>
                                                        <?  } else {
                                                            $DELI_COST = 0;	?>
                                                            무료배송(배송비 유,무/배송표 필 참조)
                                                        <? }
                                                    }
                                                } //END PATTERN_TYPE_CD == PRICE
                                                else if($goods['PATTERN_TYPE_CD'] == 'STATIC'){
                                                    $DELI_COST = $goods['DELI_COST'];	?>
                                                    <?=number_format($goods['DELI_COST'])."원"?>
                                                <?  } //END PATTERN_TYPE_CD == STATIC
                                                else if($goods['PATTERN_TYPE_CD'] == 'FREE'){
                                                    $DELI_COST = 0;	?>
                                                    무료배송(배송비 유,무/배송표 필 참조)
                                                <?  } //END PATTERN_TYPE_CD == FREE
                                                else if($goods['PATTERN_TYPE_CD'] == 'NONE'){
                                                    $DELI_COST = 0;	?>
                                                    착불 (상품상세설명참조)
                                                <? }
                                            }
                                            if(isset($row['DELIV_AREA_CD'])){	?>
                                                &#47; <?=$row['DELIV_AREA_NM']?> - <!--<?=number_format($row['ADD_DELIV_COST']+$DELI_COST)?>원	-->
                                                <?=number_format($row['ADD_DELIV_COST'])?>원 추가
                                            <? }?>

                                            <?	$i++;
                                        }
                                    } else {
                                        if($goods['PATTERN_TYPE_CD'] == 'PRICE'){
                                            if($goods['DELI_LIMIT'] > 0){
                                                if($goods['DELI_LIMIT']>$goods['COUPON_PRICE']){
                                                    $DELI_COST = $goods['DELI_COST'];	?>
                                                    <?=number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)"?>
                                                <?		} else {
                                                    $DELI_COST = 0;	?>
                                                    무료배송(배송비 유,무/배송표 필 참조)
                                                <?		}
                                            } else {
                                                if($goods['DELI_COST'] != 0){
                                                    $DELI_COST = $goods['DELI_COST'];	?>
                                                    <?=number_format($goods['DELI_COST'])."원"?>
                                                <?  } else {
                                                    $DELI_COST = 0;	?>
                                                    무료배송(배송비 유,무/배송표 필 참조)
                                                <? }
                                            }
                                        } //END PATTERN_TYPE_CD == PRICE
                                        else if($goods['PATTERN_TYPE_CD'] == 'STATIC'){
                                            $DELI_COST = $goods['DELI_COST'];	?>
                                            <?=number_format($goods['DELI_COST'])."원"?>
                                        <?  } //END PATTERN_TYPE_CD == STATIC
                                        else if($goods['PATTERN_TYPE_CD'] == 'FREE'){
                                            $DELI_COST = 0;	?>
                                            무료배송(배송비 유,무/배송표 필 참조)
                                        <?  } //END PATTERN_TYPE_CD == FREE
                                        else if($goods['PATTERN_TYPE_CD'] == 'NONE'){
                                            $DELI_COST = 0;	?>
                                            착불 (상품상세설명참조)
                                        <? }
                                    }?>
                                <? if(@$goods_no_deli){
                                    foreach($goods_no_deli as $row){
                                        if(isset($row['DELIV_AREA_CD'])){	?>
                                            &#47; <?=$row['DELIV_AREA_NM']?> - 배송 불가
                                        <?		}
                                    }
                                }?>
									</span>
                            <!--<span class="text">서울, 경기 - 무료 &#47; 충천, 강원, 영서 - 50,000원 &#47; 경상, 전라, 영동- 70,000원 &#47; 제주, 도서 - 배송 불가, 착불 배송</span>	-->
                        </li>
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>배송 안내</span>
                            <span class="text">상품페이지에 배송비(지역별 추가 배송비 등) 및 배송가능지역에 관한 브랜드 기준이 있는 경우에는 해당 내용이 우선 적용되오니, 상품상세페이지 내용을 반드시 확인하여 주십시오.<br/>
									(특히, 가구 등의 상품은 지역에 따라 배송제한 및 추가 배송비용이 착불로 발생할 수 있습니다.)<br/>
									차량의 이동이 어려운 일부 도서지역 및 제주도는 배송이 불가할 수도 있으니 반드시 상담 후 주문해 주시길 바랍니다.<br/>
									배송 시 연락처 오기재 및 주소 불분명, 그리고 수취인 부재 시 배송이 지연될 수 있습니다.<br/>
									사다리차 및 엘리베이터 사용 시 발생하는 비용 및 단순변심에 의한 반품/교환 왕복배송비는 고객님께서 부담해주셔야 합니다.
									</span>
                        </li>
                    </ul>
                </div>
                <!-- // 배송정보 -->

                <!-- 교환/환불 // -->
                <div class="vip_basic_info">
                    <h3 class="info_cont_title">반품/환불</h3>
                    <ul class="vip_prd_info_text_list">
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>지정택배사</span>
                            <span class="text"><?=$goods['DELIV_COMPANY_NM']?></span>
                        </li>
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>반품배송비</span>
                            <? if($goods['VENDOR_SUBVENDOR_CD'] == '3782'){ //[3782]지이라이프	?>
                                <span class="text">
                                    배송비 : 3만원 미만 5000원 - 한진<br/>
                                    반품배송비 : 고객센터 (1522-5572)로 문의주세요
                                </span>
                            <? } else if($goods['PATTERN_TYPE_CD'] != 'NONE'){	?>
                                <span class="text"><?=number_format($goods['RETURN_DELIV_COST'])?>원 (편도)</span>
                            <? } else {	?>
                                <span class="text">고객센터(<?=$goods['VENDOR_SUBVENDOR_TEL']?>)로 문의해주세요.</span>
                            <? }?>
                        </li>
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>보내실 곳</span>
                            <span class="text">(<?=strlen($goods['RETURN_ZIPCODE'])==6 ? substr($goods['RETURN_ZIPCODE'],0,3)."-".substr($goods['RETURN_ZIPCODE'],3,3) : $goods['RETURN_ZIPCODE']?>) <?=$goods['RETURN_ADDR']?></span>
                        </li>
                        <li class="vip_prd_info_text_item">
                            <span class="title"><span class="spr-common spr_bg_dot"></span>반품 안내</span>
                            <span class="text">상품페이지에 반품/환불/AS에 관한 브랜드 기준이 있는 경우에는 해당 내용이 본 항목을 우선하여 적용됩니다.<br/>
														반품 신청은 배송완료 후 7일 이내 가능합니다.<br/>
														변심 반품의 경우 왕복배송비를 차감한 금액이 환불되며, 제품 및 포장 상태가 재판매 가능하여야 합니다. (상품 불량인 경우는 배송비를 포함한 전액이 환불됩니다.)<br/>
														출고 이후 환불요청 시 상품 회수 후 처리됩니다.<br/>
														주문제작상품은 변심으로 인한 반품/환불이 불가합니다.<br/>
									</span>
                        </li>
                    </ul>
                </div>
                <!-- // 교환/환불 -->
            </div>
            <!-- // 상품정보 -->

            <!-- 추천 // -->
            <div class="vip_prd_info_cont func1" id="prdRecommend">
                <?if(count($category_goods)!=0){?>
                    <div class="vip_brand_recom">
                        <h3 class="info_cont_title">이 카테고리 베스트 상품</h3>
                        <div class="basic_goods_list">
                            <ul class="goods_list owl-carousel owl-nav1">
                                <?foreach($category_goods as $crow){?>
                                    <li class="goods_item">
                                        <div class="img">
                                            <a href="/goods/detail/<?=$crow['GOODS_CD']?>" class="img_link"><img src="<?=$crow['IMG_URL']?>" alt=""></a>
                                            <div class="tag-wrap">
                                                <?if(!empty($crow['DEAL'])){?>
                                                    <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                                <?}?>
                                                <?if($crow['CLASS_GUBUN']=='C'){?>
                                                    <!--<span class="circle-tag class"><em class="blk">공방<br>클래스</em></span>-->
                                                <?}?>
                                                <?if($crow['CLASS_GUBUN']=='G'){?>
                                                    <!--<span class="circle-tag class"><em class="blk">공방<br>제작상품</em></span>-->
                                                <?}?>
                                            </div>
                                            <ul class="goods_action_menu">
                                                <li class="goods_action_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$crow['GOODS_CD']?>','','');">
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
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$crow['GOODS_CD']?>','<?=$crow['IMG_URL']?>','<?=$crow['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_pinter"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">핀터레스트</span>
                                                            </button>
                                                        </li>
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$crow['GOODS_CD']?>','','<?=$crow['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_kakao"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">카카오스토리</span>
                                                            </button>
                                                        </li>
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$crow['GOODS_CD']?>','<?=$crow['IMG_URL']?>','<?=$crow['GOODS_NM']?>');" >
                                                                <span class="spr-common spr_share_facebook"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">페이스북</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="/goods/detail/<?=$crow['GOODS_CD']?>" class="goods_item_link">
                                            <span class="brand"><?=$crow['BRAND_NM']?> </span>
                                            <span class="name"><?=$crow['GOODS_NM']?></span>
                                            <span class="price">
                                                        <?if($crow['COUPON_CD_S'] || $crow['COUPON_CD_G']){
                                                            $price = $crow['SELLING_PRICE'] - ($crow['RATE_PRICE_S'] + $crow['RATE_PRICE_G']) - ($crow['AMT_PRICE_S'] + $crow['AMT_PRICE_G']);
                                                            echo number_format($price);

                                                            $sale_percent = (($crow['SELLING_PRICE'] - $price)/$crow['SELLING_PRICE']*100);
                                                            $sale_percent = strval($sale_percent);
                                                            $sale_percent_array = explode('.',$sale_percent);
                                                            $sale_percent_string = $sale_percent_array[0];
                                                            ?>
                                                            <span class="dc_price">
                                                                <s class="del_price"><?=number_format($crow['SELLING_PRICE'])?></s> (<?=floor((($crow['SELLING_PRICE']-$price)/$crow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                                            </span>
                                                        <?}else{
                                                            echo number_format($price = $crow['SELLING_PRICE']);
                                                        }?>
                                                    </span>
                                            <span class="icon_block">
                                                        <?if($crow['COUPON_CD_S'] || $crow['COUPON_CD_G']){
                                                            ?>
                                                            <span class="spr-common spr_ico_coupon"></span>
                                                            <?
                                                        }
                                                        if($crow['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                                            ?>
                                                            <span class="spr-common spr_ico_mileage"></span>
                                                            <?
                                                        }
                                                        if(($crow['PATTERN_TYPE_CD'] == 'FREE') || ( $crow['DELI_LIMIT'] > 0 && $price > $crow['DELI_LIMIT'])){
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
                <?}?>

                <div class="vip_brand_recom">
                    <h3 class="info_cont_title"><?= ($plan_event[0]['GUBUN']=='A')?"이 상품이 포함된 기획전":"인기 기획전"?></h3>
                    <div class="dim_subject_list">
                        <ul class="owl-carousel owl-nav1">
                            <?foreach($plan_event as $prow){?>
                                <li class="subject_item">
                                    <a href="/goods/event/<?=$prow['PLAN_EVENT_CD']?>">
                                        <div class="img">
                                            <img src="<?=$prow['IMG_URL']?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="txt-inner">
                                                <span><?=$prow['TITLE']?></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>

                <div class="vip_brand_recom">
                    <h3 class="info_cont_title"><?=($magazine[0]['GUBUN']=='A')?"이 상품이 포함된 매거진":"인기 매거진"?></h3>
                    <div class="dim_subject_list">
                        <ul class="owl-carousel owl-nav1">
                            <?foreach($magazine as $mrow){?>
                                <li class="subject_item">
                                    <a href="/magazine/detail/<?=$mrow['MAGAZINE_NO']?>">
                                        <div class="img">
                                            <img src="<?=$mrow['IMG_URL']?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="txt-inner">
                                                <span><?=$mrow['TITLE']?></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>

                <?if($goods['WEB_DISP_YN']=='Y' && count($brand_goods)!=0){?>
                    <div class="vip_brand_recom">
                        <h3 class="info_cont_title">브랜드관 바로가기</h3>
                        <div class="brand_goods_list">
                            <div class="brand_tag_box">
                                <a href="/goods/brand/<?=$goods['BRAND_CD']?>"><?=$goods['BRAND_NM']?></a>
                            </div>
                            <div class="brand_goods_box">
                                <ul>
                                    <?foreach($brand_goods as $brow){?>
                                        <li><a href="/goods/detail/<?=$brow['GOODS_CD']?>"><img src="<?=$brow['IMG_URL']?>" alt=""></a></li>
                                    <?}?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>

            <!-- 상품평 // -->
            <div class="vip_prd_info_cont func2" id="prdComment">
                <h3 class="info_cont_title">상품평</h3>
                <?=$comment_template?>
            </div>
            <!-- // 상품평 -->

            <!-- 상품문의 // -->
            <div class="vip_prd_info_cont prd_inquiry func2" id="prdInquiry">
                <h3 class="info_cont_title">상품문의</h3>
                <?=$qna_template?>
            </div>
            <!-- // 상품문의 -->
        </div>
    </div>

    <!-- 상품정보 form 시작 -->
    <!-- Google Tag Manager Variable (eMnet) 2018.05.29-->
    <script>
        var brandIds = [];
        brandIds.push('<?=$goods['GOODS_CD']?>');
    </script>
    <!-- End Google Tag Manager Variable (eMnet) -->
    <form id="goods_form" name="goods_form" method="post">
        <input type="hidden" id="cust_no"			name="cust_no"			value="<?=$this->session->userdata('EMS_U_NO_')?>">
        <input type="hidden" id="goods_code"				name="goods_code"				value="<?=$goods['GOODS_CD']?>">
        <input type="hidden" id="goods_name"				name="goods_name"				value="<?=$goods['GOODS_NM']?>">
        <input type="hidden" id="goods_img"					name="goods_img"				value="<?=$goods['img'][0]?>">
        <input type="hidden" id="goods_mileage_save_rate"	name="goods_mileage_save_rate"	value="<?=$goods['GOODS_MILEAGE_SAVE_RATE']?>">
        <input type="hidden" id="goods_price_code"			name="goods_price_code"			value="<?=$goods['GOODS_PRICE_CD']?>">
        <input type="hidden" id="goods_selling_price"		name="goods_selling_price"		value="<?=$goods['SELLING_PRICE']?>">
        <input type="hidden" id="goods_street_price"		name="goods_street_price"		value="<?=$goods['STREET_PRICE']?>">
        <input type="hidden" id="goods_factory_price"		name="goods_factory_price"		value="<?=$goods['FACTORY_PRICE']?>">
        <input type="hidden" id="goods_state"				name="goods_state"				value="<?=$goods['GOODS_STATE_CD']?>">
        <input type="hidden" id="brand_code"				name="brand_code"				value="<?=$goods['BRAND_CD']?>">
        <input type="hidden" id="brand_name"				name="brand_name"				value="<?=$goods['BRAND_NM']?>">
        <input type="hidden" id="goods_buy_limit_qty"       name="goods_buy_limit_qty"		value="<?=$goods['BUY_LIMIT_QTY']?>"> <!--구매제한 수량-->
        <input type="hidden" id="goods_tax_gb_cd"           name="goods_tax_gb_cd"		    value="<?=$goods['TAX_GB_CD']?>"> <!--과세 구분-->
        <input type="hidden" id="goods_discount_price"		name="goods_discount_price"		value="<?=$goods['COUPON_PRICE'] != 0 ? $goods['SELLING_PRICE'] - $goods['COUPON_PRICE'] : 0?>">
        <!-- value :: 쿠폰코드||쿠폰타입||쿠폰할인율(액)||최대할인액 -->
        <input type="hidden" id="goods_coupon_code_s"			name="goods_coupon_code_s"	value="<?=isset($goods['SELLER_COUPON_CD']) ? $goods['SELLER_COUPON_CD']."||".$goods['SELLER_COUPON_METHOD']."||".($goods['SELLER_COUPON_METHOD']=='RATE' ? $goods['SELLER_COUPON_FLAT_RATE'] : $goods['SELLER_COUPON_FLAT_AMT'])."||".$goods['SELLER_COUPON_MAX_DISCOUNT'] : ""?>">
        <?
        $seller_coupon_amt = 0;
        if(isset($goods['SELLER_COUPON_CD'])){
            if($goods['SELLER_COUPON_METHOD'] == 'RATE'){
                $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods['SELLER_COUPON_FLAT_RATE']/1000);
            } else if($goods['SELLER_COUPON_METHOD'] == 'AMT'){
                $seller_coupon_amt = $goods['SELLER_COUPON_FLAT_AMT'];
            }

            if($seller_coupon_amt > $goods['SELLER_COUPON_MAX_DISCOUNT'] && $goods['SELLER_COUPON_MAX_DISCOUNT'] != 0){
                $seller_coupon_amt = $goods['SELLER_COUPON_MAX_DISCOUNT'];
            }
        }

        $item_coupon_amt = 0;
        if(isset($goods['ITEM_COUPON_CD'])){
            if($goods['ITEM_COUPON_METHOD'] == 'RATE'){
                $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods['ITEM_COUPON_FLAT_RATE']/1000);
            } else if($goods['ITEM_COUPON_METHOD'] == 'AMT'){
                $item_coupon_amt = $goods['ITEM_COUPON_FLAT_AMT'];
            }

            if($item_coupon_amt > $goods['ITEM_COUPON_MAX_DISCOUNT'] && $goods['ITEM_COUPON_MAX_DISCOUNT'] != 0){
                $item_coupon_amt = $goods['ITEM_COUPON_MAX_DISCOUNT'];
            }
        }
        ?>

        <input type="hidden" id="goods_coupon_amt_s"			name="goods_coupon_amt_s"		value="<?=$seller_coupon_amt?>">	<!--쿠폰금액 (수량 합 미포함)-->
        <input type="hidden" id="goods_coupon_code_i"			name="goods_coupon_code_i"		value="<?=isset($goods['ITEM_COUPON_CD']) ? $goods['ITEM_COUPON_CD']."||".$goods['ITEM_COUPON_METHOD']."||".($goods['ITEM_COUPON_METHOD']=='RATE' ? $goods['ITEM_COUPON_FLAT_RATE'] : $goods['ITEM_COUPON_FLAT_AMT'])."||".$goods['ITEM_COUPON_MAX_DISCOUNT'] : ""?>">
        <input type="hidden" id="goods_coupon_amt_i"			name="goods_coupon_amt_i"		value="<?=$item_coupon_amt?>">
        <input type="hidden" id="deli_policy_no"			name="deli_policy_no"			value="<?=$goods['DELIV_POLICY_NO']?>">
        <input type="hidden" id="deli_limit"				name="deli_limit"				value="<?=$goods['DELI_LIMIT']?>">
        <input type="hidden" id="deli_cost"					name="deli_cost"				value="<?=$goods['DELI_COST']?>">
        <input type="hidden" id="deli_code"					name="deli_code"				value="<?=$goods['DELI_CODE']?>">
        <input type="hidden" id="goods_cate_code1"			name="goods_cate_code1"				value="<?=$goods['CATEGORY_MNG_CD1']?>">
        <input type="hidden" id="goods_cate_code2"			name="goods_cate_code2"				value="<?=$goods['CATEGORY_MNG_CD2']?>">
        <input type="hidden" id="goods_cate_code3"			name="goods_cate_code3"				value="<?=$goods['CATEGORY_MNG_CD3']?>">
        <input type="hidden" id="goods_deliv_pattern_type"	name="goods_deliv_pattern_type"	value="<?=$goods['PATTERN_TYPE_CD']?>">

        <div class="vip_detail" id="vipSelectOption">
            <div class="vip_detail_top">
                <div class="vip_prd_code"><span>상품번호 : <?=$goods['GOODS_CD']?></span></div>
                <div class="position_area vip_detail_prd_title">
                    <h3 class="title"><?=$goods['GOODS_NM']?></h3>
                </div>
            </div>

            <div class="vip_detail_inner">
                <div class="vip_detail_star"><span class="star_grade star_grade__big"><span class="score" style="width:<?=$goods['TOTAL_GRADE_VAL']*20?>%;"></span></span></div>
                <? if(isset($goods['SELLER_COUPON_CD']) || isset($goods['ITEM_COUPON_CD']))	{	?>
                    <dl class="vip_detail_line">
                        <dt class="title">할인적용가</dt>
                        <?
                        $sale_percent = (($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100);
                        $sale_percent = strval($sale_percent);
                        $sale_percent_array = explode('.',$sale_percent);
                        $sale_percent_string = $sale_percent_array[0];
                        ?>
                        <dd class="data">
                            <strong class="price price__big"><?=number_format($goods['COUPON_PRICE'])?></strong>
                            <span class="tip">
							<!--	<span class="dc_price"><s class="del_price"><span name="selling_price_text"><?=number_format($goods['SELLING_PRICE'])?></span>원</s> (<?=floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100) == 0 ? 1 : floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>	-->
                                <!--									<span class="dc_price"><s class="del_price"><span name="selling_price_text">--><?//=number_format($goods['SELLING_PRICE'])?><!--</span>원</s> (--><?//=floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100) == 0 ? 1 : $sale_percent_string?><!--%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
                                    <span class="dc_price"><s class="del_price"><?=number_format($goods['SELLING_PRICE'])?>원</s> <span class="dc-rate"><?=floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100) == 0 ? 1 : $sale_percent_string?>%</span></span>
                                <!--									<span class="btn_white btn_white__small">쿠폰할인</span>-->
                                <?if(!empty($goods['DEAL'])){?>
                                    <!--<span class="btn_yellow btn_yellow__small">에타딜</span>-->
                                <?}?>
							</span>

                            <? $no_option = "Y";
                            $option_i = 1;
                            foreach($goods_option as $row){
                                if($row['QTY'] > 0){
                                    $no_option = "N";
                                    break;
                                }
                                $option_i ++;
                            }	?>
                            <?	if(count($goods_option) == '' && $no_option == 'N'){	?>
                                <button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="" onClick="javascript:couponLayerOpen('<?=$goods_option[0]['GOODS_OPTION_CD']?>');">쿠폰선택</button>
                            <? }?>
                        </dd>
                    </dl>
                <? } else {?>
                    <dl class="vip_detail_line">
                        <dt class="title">판매가</dt>
                        <dd class="data">
                            <strong class="price price__big"><?=number_format($goods['SELLING_PRICE'])?></strong>
                        </dd>
                    </dl>
                <? }?>
                <? if($goods['GOODS_MILEAGE_SAVE_RATE']){	?>
                    <dl class="vip_detail_line">
                        <dt class="title">마일리지 적립액</dt>
                        <dd class="data">
                            <strong class="price"><?=number_format($goods['SELLING_PRICE']*($goods['GOODS_MILEAGE_SAVE_RATE']/1000))?></strong>
                            <!--		<span class="tip">
								(<?=$goods['GOODS_MILEAGE_SAVE_RATE']/10?>% 적립)
							</span>	-->
                        </dd>
                    </dl>
                <? }?>
                <? if(count($goods_class) != 0){
                    foreach($goods_class as $row)	{?>
                        <dl class="vip_detail_line">
                            <dt class="title"><?=$row['CLASS_ATTR_MAIN']?></dt>
                            <dd class="data"><?=$row['CLASS_ATTR_SUB']?></dd>
                        </dl>
                    <?	}
                }?>
                <!--				<dl class="vip_detail_line">
						<dt class="title">배송비</dt>
						<dd class="data"><? if($goods['DELI_LIMIT'] != 0) {?>
						<input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_LIMIT']>$goods['COUPON_PRICE'] ? $goods['DELI_COST'] : 0 ?>">
						<?=$goods['DELI_LIMIT']>$goods['COUPON_PRICE'] ? number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)" : "무료배송"?>
						<? } else {	?>
						<input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_COST']?>">
							<? if($goods['DELI_COST'] != 0){?>
							<?=number_format($goods['DELI_COST'])."원"?>
							<? } else {	?>
							무료배송
							<?}
                }?>
						</dd>
					</dl>		-->

                <dl class="vip_detail_line">
                    <dt class="title">배송비</dt>
                    <dd class="data">
                            <span>
                            <? if($goods['PATTERN_TYPE_CD'] == 'PRICE') {
                                if($goods['DELI_LIMIT'] > 0){	?>
                                    <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_LIMIT']>$goods['COUPON_PRICE'] ? $goods['DELI_COST'] : 0 ?>">
                                    <?=$goods['DELI_LIMIT']>$goods['COUPON_PRICE'] ? number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)" : "무료배송"?>
                                <? } else {
                                    if($goods['DELI_COST'] != 0){	?>
                                        <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_COST']?>">
                                        <?=number_format($goods['DELI_COST'])."원"?>
                                    <? } else {	?>
                                        무료배송(배송비 유,무/배송표 필 참조)
                                    <?}
                                }
                            } //END PATTERN_TYPE_CD == PRICE
                            else if($goods['PATTERN_TYPE_CD'] == 'STATIC'){	?>
                                <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_COST']?>">
                                <?=number_format($goods['DELI_COST'])."원"?>
                            <?  } //END PATTERN_TYPE_CD == STATIC
                            else if($goods['PATTERN_TYPE_CD'] == 'FREE'){		?>
                                <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="0">
                                무료배송(배송비 유,무/배송표 필 참조)
                            <?  } //END PATTERN_TYPE_CD == FREE
                            else if($goods['PATTERN_TYPE_CD'] == 'NONE'){		?>
                                <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="0">
                                착불 (상품상세설명참조)
                            <? }?>
                            </span> <br>
                        <!-- 2016-11-30 묶음배송 상품 보기 추가	-->
                        <!-- 2017-11-21 묶음배송 상품 보기 명칭 변경 - 배송비 절약-->
                        <? if( ($goods['PATTERN_TYPE_CD'] == 'PRICE' || $goods['PATTERN_TYPE_CD'] == 'FREE') && $goods['PACKED_DELI'] == 'Y'){	?>
                            <a href="/goods/bundle_delivery/<?=$goods['GOODS_CD']?>" class="btn_delivery_charge">묶음배송 가능상품</a>
                        <? }?>
                    </dd>
                </dl>


                <?if($goods['CATEGORY_MNG_CD2'] == 24010000) {?>
                    <dl class="vip_detail_line">
                        <dt class="title">장르</dt>
                        <dd class="data"><?=$goods['CLASS_TYPE']?> 클래스</dd>
                        <dt class="title">위치</dt>
                        <dd class="data"><?=$goods['ADDRESS']?></dd>
                        <dt class="title">기간</dt>
                        <dt class="data">
                            <?=substr($goods['START_DT'],0,10)?> ~
                            <?=substr($goods['END_DT'],0,10)?>
                        </dt>
                    </dl>
                <?}?>

                <div class="vip_detail_brand">
                    <?if($goods['WEB_DISP_YN'] == 'Y'){	?>
                        <a href="/goods/brand/<?=$goods['BRAND_CD']?>" class="btn_brand_shop"><?=$goods['BRAND_NM']?> 브랜드관<span class="spr-common spr-triangle_white_02"></span></a>
                    <? }?>
                </div>

                <? $no_option = "Y";
                $option_i = 1;
                foreach($goods_option as $row){
                    if($row['QTY'] > 0){
                        $no_option = "N";
                        break;
                    } else {
                        if($option_i == count($goods_option)){	//마지막까지 옵션이 없을경우?>
                            <dl class="vip_detail_line">
                                <dt class="title">옵션</dt>
                                <dd class="data"><font color="black"><b>옵션이 모두 품절되었습니다.</font></b></dd>
                            </dl>
                        <?	}
                    }
                    $option_i ++;
                }	?>
                <?	if(count($goods_option) == '' && $no_option == 'N'){	?>
                    <dl class="vip_detail_line">
                        <!--선택된 상품 옵션 -->
                        <input type="hidden" id="goods_option_type"			name="goods_option_type" value="ONLY">
                        <input type="hidden" id="goods_option_code"			name="goods_option_code[]"		value="<?=$goods_option[0]['GOODS_OPTION_CD']?>">
                        <input type="hidden" id="goods_option_name"			name="goods_option_name[]"		value="<?=$goods_option[0]['GOODS_OPTION_NM']?>">
                        <input type="hidden" id="goods_option_add_price"	name="goods_option_add_price[]"		value="<?=$goods_option[0]['GOODS_OPTION_ADD_PRICE']?>">
                        <input type="hidden" id="goods_option_qty"			name="goods_option_qty[]"		value="<?=$goods_option[0]['QTY']?>">
                        <input type="hidden" id="goods_item_coupon_code"	name="goods_item_coupon_code[]" value="<?=isset($goods['ITEM_COUPON_CD']) ? $goods['ITEM_COUPON_CD'] : '' ?>">
                        <input type="hidden" id="goods_item_coupon_price"	name="goods_item_coupon_price[]" value="<?=$item_coupon_amt?>">
                        <input type="hidden" id="goods_add_coupon_code"		name="goods_add_coupon_code[]" value="">
                        <input type="hidden" id="goods_add_discount_price"	name="goods_add_discount_price[]" value=0>
                        <input type="hidden" id="goods_add_coupon_type"		name="goods_add_coupon_type[]" value="">
                        <input type="hidden" id="goods_add_coupon_gubun"	name="goods_add_coupon_gubun[]"	value="">
                        <input type="hidden" id="goods_add_coupon_no"		name="goods_add_coupon_no[]"	value="">
                        <input type="hidden" id="goods_coupon_amt"			name="goods_coupon_amt[]"	value="">	<!--쿠폰적용가-->




                        <dt class="title">수량선택</dt>
                        <dd class="data quantity">
                            <div class="quantity_select">
                                <input type="text" id="goods_cnt" name="goods_cnt[]" onClick="javascript:onlyNumber(this,'A','');" class="quantity_input" value="1">
                                <!--<input type="text" id="goods_cnt" name="goods_cnt[]" onClick="onlyNumber(this)" class="quantity_input" value="1">-->

                                <button type="button" class="quantity_minus_btn"  onClick="javascript:jsChangeNum('A',-1, '');">
                                    <span class="text">minus</span>
                                    <span class="spr-cart btn-minus"></span>
                                </button>
                                <button type="button" class="quantity_plus_btn" onClick="javascript:jsChangeNum('A',1, '');">
                                    <span class="text">plus</span>
                                    <span class="spr-cart btn-plus"></span>
                                </button>
                            </div>
                        </dd>
                    </dl>
                <? } else if(count($goods_option) >= 1 && $no_option == 'N'){?>
                    <dl class="vip_detail_line vip_detail_line__select">
                        <dt class="title"><label for="formOpotionSelect">옵션선택</label></dt>
                        <dd class="data">
                            <div class="select_wrap select_wrap__btn" style="width:290px;">
                                <button type="button" class="ui_select_option" data-target="#selectoption_1" name="select_option_form" data-name="opt_1">옵션을 선택하세요 </button>
                            </div>
                        </dd>

                        <dd class="select_option_wrap" id="selectoption_1" style="display: none;">
                            <button type="button" class='spr-common btn-close-05'></button>
                            <!-- js-template -->
                        </dd>
                    </dl>

                    <dl class="vip_detail_line vip_detail_line__select" id="selectList" style="display:none">
                        <dd class="select_essential_list" id="selectListInner">
                            <dl class="select_essential_item all_order_price">
                                <dt class="title">총 주문금액</dt>
                                <dd class="price"><strong id="total_price"></strong></dd>
                            </dl>
                        </dd>
                    </dl>
                <? }
                if(!$goods_option){	?>
                    <dl class="vip_detail_line">
                        <dt class="title">옵션</dt>
                        <dd class="data"><font color="black"><b>옵션이 등록되어있지 않습니다.</font></b></dd>
                    </dl>
                <? }?>

                <ul class="btn_list vip_detail_btns">
                    <li><button type="button" class="btn_negative btn_negative__min" onClick="javaScript:jsGoodsAction('W','','<?=$goods['GOODS_CD']?>','','');"><span class="spr-common spr-heart"></span>관심상품</button></li>
                    <li><button type="button" class="btn_negative btn_negative__min" onClick="javascript:jsAddCart();"><span class="spr-common spr-bag"></span>장바구니</button></li>
                </ul>

                <button type="button" class="btn_yellow vip_detail_btn_buy" onClick="javascript:jsDirect();"><span class="spr-common spr-card"></span>바로구매</button>

                <?
                /*공방클래스 상품인 경우 네이버페이 구매버튼 노출 안함*/
                if( $goods['CATEGORY_MNG_CD2']!=24010000 ){?>
                    <input type="hidden" value="<?=$ENABLE?>" name="np_enable_yn" id="np_enable_yn">
                    <div class="naverpay">
                        <script type="text/javascript" src="https://pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
                        <script type="text/javascript" >
                            naver.NaverPayButton.apply({
                                BUTTON_KEY: "CC68CEA7-3129-4153-8D29-BE38810016E1", // 페이에서 제공받은 버튼 인증 키 입력
                                TYPE: "A", // 버튼 모음 종류 설정
                                COLOR: 1, // 버튼 모음의 색 설정
                                COUNT: 2, // 버튼 개수 설정. 구매하기 버튼만 있으면 1, 찜하기 버튼도 있으면 2를 입력.
                                ENABLE: "<?=$ENABLE?>", // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 "N" 입력
                                BUY_BUTTON_HANDLER: jsNaverPay, // 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
                                WISHLIST_BUTTON_HANDLER:jaNaverPick, // 찜하기 버튼 이벤트 Handler 함수 등록
                                "":""
                            });

                            //=======================================
                            // 네이버페이 찜하기
                            //=======================================
                            function jaNaverPick() {
                                var goods_cd    = $("#goods_code").val();
                                var goods_name  = $("#goods_name").val();
                                var goods_img   = $("#goods_img").val();
                                var goods_price = $("#goods_selling_price").val() - $("#goods_discount_price").val();

                                if($("#np_enable_yn").val() == 'N'){
                                    alert('네이버페이를 통한 구매가 불가한 상품입니다.');
                                    return false;
                                }

                                $.ajax({
                                    type: 'POST',
                                    url: '/goods/naver_pick',
                                    dataType: 'json',
                                    data: {
                                        'goods_cd'    : goods_cd,
                                        'goods_name'  : goods_name,
                                        'goods_price' : goods_price,
                                        'goods_img'   : goods_img
                                    },
                                    error:	function(res)	{
                                        alert( 'Database Error' );
                                    },
                                    success: function(res) {
                                        if(res.status == 'ok'){
                                            var url = res.url+'?SHOP_ID=np_chfrl677135&ITEM_ID='+res.itemId;
                                            window.open(url,"naver_wishlist","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
                                        }
                                        else{
                                            alert(res.message);
                                        }
                                    }
                                });
                            }

                            //=======================================
                            // 네이버페이 구매하기
                            //=======================================
                            function jsNaverPay() {
                                var goods_option_code   = document.getElementsByName("goods_option_code[]");     //옵션코드
                                var goods_option_cnt    = document.getElementsByName("goods_cnt[]");  //상품수량
                                var buymaxCnt           = "<?=$goods['BUY_LIMIT_QTY']?>";    //구매제한수량

                                if($("#np_enable_yn").val() == 'N'){
                                    alert('네이버페이를 통한 구매가 불가한 상품입니다.');
                                    return false;
                                }

                                if(goods_option_code.length == 0) {
                                    alert("상품 옵션을 선택해 주세요.");
                                    return false;
                                }

                                for(var i=0;i<goods_option_cnt.length;i++) {
                                    if(goods_option_cnt[i].value == 0) {
                                        alert("수량을 입력해 주세요.");
                                        return false;
                                    }

                                    if(goods_option_cnt[i].value > 999) {
                                        alert("수량을 999개 이하로 입력해 주세요.");
                                        return false;
                                    }

                                    //구매제한이 있는 경우
                                    if( buymaxCnt!=0 ) {
                                        if( parseInt(goods_option_cnt[i].value) > parseInt(buymaxCnt) ) {
                                            alert("이 상품은 "+buymaxCnt+"개 이하로 구매하실 수 있습니다. "+buymaxCnt+"개 이하로 구매해 주세요.");
                                            return false;
                                        }
                                    }

                                }

                                if($("input[name=goods_state]").val() != '03'){
                                    alert("죄송합니다. 네이버페이로 구매가 불가능한 상품입니다.");
                                    return false;
                                }

                                //네이버페이로 주문 정보를 등록하는 가맹점 페이지로 이동.
                                // 해당 페이지에서 주문 정보 등록 후 네이버페이 주문서 페이지로 이동.
                                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                                var frm = document.getElementById("goods_form");
                                frm.action = "https://"+SSL_val+"/order/naver_pay";
                                frm.submit();
                            }
                        </script>
                    </div>
                <?}?>
                <!--                <div class="vip_hashtag">-->
                <!--                    --><?//foreach($tag as $tt){?>
                <!--                        <a href="/goods2/goods_search?keyword=--><?//=$tt['TAG_NM']?><!--&gb=T&tag_keyword=--><?//=$tt['TAG_NM']?><!--">#--><?//=$tt['TAG_NM']?><!--</a>-->
                <!--                    --><?//}?>
                <!--                </div>-->

                <ul class="vip_detail_sns">
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:jsGoodsAction('S','F','<?=$goods['GOODS_CD']?>','<?=$goods['img'][0]?>','<?=$goods['GOODS_NM']?>');" class="spr-common spr_share_facebook"> </a>
                    </li>
                    <!--	<li class="vip_detail_sns_item">
                            <a href="#" class="spr-common spr_share_insta"> </a>
                        </li>	-->
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:jsGoodsAction('S','K','<?=$goods['GOODS_CD']?>','','<?=$goods['GOODS_NM']?>');" class="spr-common spr_share_kakao"> </a>
                    </li>
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:jsGoodsAction('S','P','<?=$goods['GOODS_CD']?>','<?=$goods['img'][0]?>','<?=$goods['GOODS_NM']?>');" class="spr-common spr_share_pinter"> </a>
                    </li>
                </ul>
                <!--	<div class="vip_detail_info">
							<strong class="title">Information</strong>
							<p class="text">Model no. <?=$goods['MODEL_NM']?><br /><?=$goods['GOODS_NM']?><br /><?=$goods['DESCRIPTION']?></p>
						</div>	-->
            </div>
            <span class="bg_shadow_bottom"></span>
            <span class="bg_shadow_right"></span>
        </div>
</div>

<div id="goods_buy_guide" class="layer layer__view layer__order_guide_layer" style="display:none;">
    <?=$goods_buy_guide_template?>
</div>

<input type="hidden" id="guest_gb" name="guest_gb" value="">		<!-- 비회원 구매시 바로구매인지 장바구니구매인지 -->
<input type="hidden" id="send_nation" name="send_nation" value="<?=$goods['SEND_NATION']?>">	<!--출고국가-->
</form>

<!-- 상품 이미지 정보 -->
<? $img_idx = 0;
foreach($goods['img'] as $row){		?>
    <input type="hidden"	id="rolling_goods_img_<?=$img_idx?>"	name="rolling_goods_img[]"	value="<?=$row?>">
    <? $img_idx ++;
}?>

<!-- 상품 옵션 정보 -->
<form id="goods_option_form" name="goods_option_form" method="post">
    <? if($goods_option){	?>
        <input type="hidden"	id="option_yn"			name="option_yn"		value="Y">
        <?
        $aa = '';
        foreach($goods_option as $row)	{?>
            <input type="hidden"	id="option_code"		name="option_code[]"	value="<?=$row['GOODS_OPTION_CD']?>">
            <input type="hidden"	id="option_name"		name="option_name[]"	value="<?=$row['GOODS_OPTION_NM']?>">
            <!--	<input type="hidden"	id="option_qty"			name="option_qty[]"		value="<?=$row['QTY']?>">	-->
            <input type="hidden"	id="option_add_price"	name="option_add_price[]"	value="<?=$row['GOODS_OPTION_ADD_PRICE']?>">
            <?	if(($aa == '') && ($row['QTY'] > 0)){
                $aa = substr($row['MOPTION_RESULT'],9,1);
            }
            if(($row['QTY'] > 0) && $aa < substr($row['MOPTION_RESULT'],9,1)){
                $aa = substr($row['MOPTION_RESULT'],9,1);
            }
        }	?>
        <!--	<input type="hidden"	id="moption_result"		name="moption_result"	value="<?=$row['MOPTION_RESULT']?>">	-->
        <input type="hidden"	id="moption_result"		name="moption_result"	value="M_OPTION_<?=$aa?>">

        <?		foreach($goods_moption1 as $row) {?>
            <input type="hidden"	id="moption1"			name="moption1[]"		value="<?=$row['M_OPTION_1']?>">
            <input type="hidden"	id="option_qty"			name="option_qty[]"		value="<?=$row['QTY']?>">
        <?		}
        foreach($goods_moption2 as $row) {?>
            <input type="hidden"	id="moption2"			name="moption2[]"		value="<?=$row['M_OPTION_2']?>">
        <?		}
        foreach($goods_moption3 as $row) {?>
            <input type="hidden"	id="moption3"			name="moption3[]"		value="<?=$row['M_OPTION_3']?>">
        <?		}
        foreach($goods_moption4 as $row) {?>
            <input type="hidden"	id="moption4"			name="moption4[]"		value="<?=$row['M_OPTION_4']?>">
        <?		}
        foreach($goods_moption5 as $row) {?>
            <input type="hidden"	id="moption5"			name="moption5[]"		value="<?=$row['M_OPTION_5']?>">
        <?		}
    } else {?>
        <input type="hidden"	id="option_yn"			name="option_yn"		value="N">
    <? }?>
    <!-- 초반에 옵션 불러올때 멀티옵션 선택에 따라 변경되는 옵션코드를 임시로 넣었다 불러옴 -->
    <input type="hidden"	id="temp_moption_code"		name="temp_moption_code"	value="">
    <input type="hidden"	id="temp_moption_qty"		name="temp_moption_qty"		value="">
    <input type="hidden"	io="temp_moption_subqty"	name="temp_moption_subqty"	value="">	<!--멀티옵션 선택시 옵션 하위들 중 최대 수량 -->
    <input type="hidden"	id="temp_moption_price"		name="temp_moption_price"	value="">
    <input type="hidden"	id="temp_moption"			name="temp_moption"			value="">
</form>

<div class="COUPON_LAYER" id="coupon_layer"></div>
<div class="RESERVATION_LAYER" id="reservation_layer"></div>

</div>

<script src="/assets/js/common.js"></script>
<script src="/assets/js/vip.js?ver=1"></script>
<script src="/assets/js2/goods_coupon.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript">
    (function($) {
        $(document).ready(function(){
            // 공방 제작상품
            $(".vip_brand_recom .owl-carousel").owlCarousel({
                loop: true,
                items: 3,
                margin: 20,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed: 300,
                nav: false,
                dots: false
            });
        });
    })(jQuery);
</script>
<script type="text/javascript">
    $(document).ready(function(){

        // Tabs
        var tab = $('.tab_menu');
        var btnTab = $('.tab_menu a');

        $(btnTab).click(function (e) {
            e.preventDefault();

            if ($(this.hash).hasClass('func2')) {
                $('.vip_prd_info_cont.func1').css('display', 'none');
            } else {
                $('.vip_prd_info_cont.func1').css('display', 'block');
            }

            $('.vip_prd_info_cont').removeClass('active');
            $(this.hash).addClass('active');

            $(this).parent('li').siblings('li').removeClass('active');
            $(this).parent('li').addClass('active');
            $('html,body').animate({scrollTop:$(this.hash).offset().top});
        });

        // 스크롤 시 상품상세 탭 네비 동작
        var tabsOffset = $('.vip_inner .tab_menu').offset().top - 0 // Scroll Up

        $(window).scroll(function () {
            var scroll = $(this).scrollTop();
            if (scroll >= tabsOffset) {
                $('.vip_inner .tab_menu_wrap').addClass('fixed');
            } else if (scroll <= tabsOffset) {
                $('.vip_inner .tab_menu_wrap').removeClass('fixed');
            }
        });

        google_ga('view_item');
    });


    $('.dim_subject_list').each(function(){
        // 이 상품이 포함된 기획전 슬라이드
        $(this).find('.owl-carousel').owlCarousel({
            mouseDrag: $(this).find('.subject_item').size() > 1 ? true:false,
            loop: $(this).find('.subject_item').size() > 1 ? true:false,
            items: 2,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 3000,
            smartSpeed: 300,
            nav: true,
            dots: false
        });
    });

    // 이 카테고리 베스트 상품
    $('.basic_goods_list .owl-carousel').owlCarousel({
        mouseDrag: false,
        loop: true,
        items: 3,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 3000,
        smartSpeed: 300,
        nav: true,
        dots: false
    });
</script>
<script type="text/javascript">

    // 옵션이 단일옵션일 경우 옵션레이어 미리 생성
    if($("input[name='goods_option_type']").val() == 'ONLY'){
        var goods_option_code		= $($("input[name='goods_option_code[]']").get(0)).val();
        var goods_option_add_price	= $($("input[name='goods_option_add_price[]']").get(0)).val();

        couponLayerCreate(goods_option_code,goods_option_add_price);
    }

    <?if($goods['VENDOR_SUBVENDOR_CD']==10240){?>
    //====================================
    // 방문예약 레이어 생성
    //====================================
    function jsReservationLayer(goods_cd){
        $.ajax({
            type: 'POST',
            url: '/goods/reservation_layer',
            dataType: 'json',
            data: { goods_cd : goods_cd},
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    $("#reservation_layer").prepend(res.reservation_layer);
                }
                else alert(res.message);
            }
        });
    }
    <?}?>


    //====================================
    // 쿠폰 레이어 생성
    //====================================
    function couponLayerCreate(opt_code,opt_price){
//	alert(idx);
        $.ajax({
            type: 'POST',
            url: '/goods/coupon_layer',
            dataType: 'json',
            data: { goods_code : document.getElementById("goods_code").value, option_add_price : opt_price, idx : opt_code},
            error: function(res) {
                alert('Database Error');
            },
            async : false,
            success: function(res) {
                if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.search_address);
//				$("#coupon_layer").html(res.coupon_layer);
//				$("#coupon_layer").append(res.coupon_layer);
                    $("#coupon_layer").prepend(res.coupon_layer);
                }
                else alert(res.message);
            }
        });

//	$("#layer__cart_02_"+opt_code).attr('class','layer layer__cart_02 layer__view');

//	var ele = $('#layer__cart_02').find('.layer_inner'),
//		top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
//		left = - (ele.width() / 2);
//	if ( top < $(window).scrollTop() ) {
//		top = $(window).scrollTop();
//	}
//
//	ele.css( {
//		'top' : top,
//		'margin-left' : left
//	} );

    }

    //======================================
    // 쿠폰 레이어 열기
    //======================================
    function couponLayerOpen(opt_code){
        Coupon_Reset(opt_code);
        Coupon_use_check(opt_code);		//사용가능/사용불가능 쿠폰 체크

        $('#layer__cart_02_'+opt_code).removeClass();
        $('#layer__cart_02_'+opt_code).addClass('layer layer__cart_02 layer__view');
    }

    /*****************/
    /** 천단위 콤마 **/
    /*****************/
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

    /******************************/
    /** 수량 숫자 증가/감소 버튼 **/
    /******************************/
    function jsChangeNum(gb,num,val){
        var buymaxCnt = "<?=$goods['BUY_LIMIT_QTY']?>";
        if(gb == 'A'){	//단일 옵션
            var goods_cnt = document.getElementsByName("goods_cnt[]")[0].value;

            if( buymaxCnt == goods_cnt && num == 1){
                alert('1회 최대 구매수는 '+buymaxCnt+' 개 입니다');
                return false;
            }
            var cnt = parseInt(goods_cnt) + parseInt(num);

            if(cnt<1){
                cnt = 1;
            }

            if(document.getElementsByName("goods_option_qty[]")[0].value < cnt){
                alert("현재 주문가능한 재고수량은 "+document.getElementsByName("goods_option_qty[]")[0].value+"개 입니다.\n"+document.getElementsByName("goods_option_qty[]")[0].value+"개 이하로 주문해 주세요.");
                return false;
            }

            //쿠폰이 선택되어있는 경우
            if($($("input[name='goods_add_coupon_code[]']").get(0)).val() != '' || $($("input[name='goods_item_coupon_code[]']").get(0)).val() != $("input[name='goods_coupon_code_i']").val().split("||")[0]){
                if(confirm("수량을 변경하시면, 선택하신 쿠폰이 초기화 됩니다.")){
                    //아이템 쿠폰 히든 값에 넣어놨던 쿠폰들 다 리셋
                    $($("input[name='goods_item_coupon_code[]']").get(0)).val($("input[name='goods_coupon_code_i']").val().split("||")[0]);
                    $($("input[name='goods_item_coupon_price[]']").get(0)).val($("input[name='goods_coupon_amt_i']").val());

                    //바이어쿠폰 히든값을 빈값으로 넣기
                    $($("input[name='goods_add_coupon_code[]']").get(0)).val('');
                    $($("input[name='goods_add_discount_price[]']").get(0)).val(parseInt(0));
                    $($("input[name='goods_add_coupon_type[]']").get(0)).val('');
                    $($("input[name='goods_add_coupon_gubun[]']").get(0)).val('');
                    $($("input[name='goods_add_coupon_no[]']").get(0)).val('');
                } else {
                    return false;
                }
            }

            document.getElementsByName("goods_cnt[]")[0].value = cnt;
            totalPrice();

            $("span[name='coupon_price_text']").text(numberFormat((parseInt($("input[name='goods_selling_price']").val())-parseInt($("input[name='goods_discount_price']").val()))*parseInt(document.getElementsByName("goods_cnt[]")[0].value)));	//쿠폰할인가

            $("span[name='selling_price_text']").text(numberFormat(parseInt($("input[name='goods_selling_price']").val())*parseInt(document.getElementsByName("goods_cnt[]")[0].value)));	//판매가

        } else if(gb == 'B'){	//옵션

            for(var i=0; i<document.getElementsByName("goods_option_code[]").length; i++){
                if(val == document.getElementsByName("goods_option_code[]")[i].value){
                    var idx = i;
                    break;
                }
            }

            var goods_cnt = document.getElementsByName("goods_cnt[]")[idx].value;

            if( buymaxCnt == goods_cnt && num == 1){
                alert('1회 최대 구매수는 '+buymaxCnt+' 개 입니다');
                return false;
            }

            var cnt = parseInt(goods_cnt) + parseInt(num);

            if(cnt<1){
                cnt = 1;
            }

            if(document.getElementsByName("goods_option_qty[]")[idx].value < cnt){
                alert("현재 주문가능한 재고수량은 "+document.getElementsByName("goods_option_qty[]")[idx].value+"개 입니다.\n"+document.getElementsByName("goods_option_qty[]")[idx].value+"개 이하로 주문해 주세요.");
                return false;
            }

            //쿠폰이 선택되어있는 경우
            if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() != '' || $($("input[name='goods_item_coupon_code[]']").get(idx)).val() != $("input[name='goods_coupon_code_i']").val().split("||")[0]){
                if(confirm("수량을 변경하시면, 선택하신 쿠폰이 초기화 됩니다.")){
                    //아이템 쿠폰 히든 값에 넣어놨던 쿠폰들 다 리셋
                    $($("input[name='goods_item_coupon_code[]']").get(idx)).val($("input[name='goods_coupon_code_i']").val().split("||")[0]);
                    $($("input[name='goods_item_coupon_price[]']").get(idx)).val($("input[name='goods_coupon_amt_i']").val());

                    //바이어쿠폰 히든값을 빈값으로 넣기
                    $($("input[name='goods_add_coupon_code[]']").get(idx)).val('');
                    $($("input[name='goods_add_discount_price[]']").get(idx)).val(parseInt(0));
                    $($("input[name='goods_add_coupon_type[]']").get(idx)).val('');
                    $($("input[name='goods_add_coupon_gubun[]']").get(idx)).val('');
                    $($("input[name='goods_add_coupon_no[]']").get(idx)).val('');
                } else {
                    return false;
                }
            }

            document.getElementsByName("goods_cnt[]")[idx].value = cnt;

            var selling_price			= parseInt($("input[name='goods_selling_price']").val());
            var goods_option_add_price	= parseInt($($("input[name='goods_option_add_price[]']").get(idx)).val());
            var seller_coupon_amt		= parseInt($("input[name='goods_coupon_amt_s']").val());
            var item_coupon_amt			= parseInt($($("input[name='goods_item_coupon_price[]']").get(idx)).val());
            var cust_coupon_amt			= parseInt($($("input[name='goods_add_discount_price[]']").get(idx)).val());
            var coupon_price			= ( selling_price + goods_option_add_price ) - ( seller_coupon_amt + item_coupon_amt + cust_coupon_amt);


            //판매금액 적용
            $("s[name=option_selling_price]").eq(idx).text(numberFormat(parseInt(selling_price + goods_option_add_price) * parseInt(cnt)));
            //할인금액 적용
            $("span[name=cpn_price]").eq(idx).text(numberFormat(parseInt(coupon_price) * parseInt(cnt)));

            $($("input[name='goods_coupon_amt[]']").get(idx)).val(parseInt(coupon_price) * parseInt(cnt))

//		totalPrice();
            Total_goods_price();

        }
    }

</script>
<!-- 옵션 선택 된 상품 추가 html 탬플릿 -->
<script id="selectOption-template" type="text/x-handlebars-template">
    <dl class="select_essential_item ui_select_item" data-value="{{value}}" data-price="{{dataPrice}}">
        <input type="hidden" id="goods_option_type"			name="goods_option_type"		value="MULTI">
        <input type="hidden" id="goods_option_code"			name="goods_option_code[]"		value="{{option_code}}">
        <input type="hidden" id="goods_option_name"			name="goods_option_name[]"		value="{{option_name}}">
        <input type="hidden" id="goods_option_add_price"	name="goods_option_add_price[]"	value="{{option_add_price}}">
        <input type="hidden" id="goods_option_qty"			name="goods_option_qty[]"		value="{{len}}">
        <input type="hidden" id="goods_item_coupon_code"	name="goods_item_coupon_code[]" value="{{item_coupon_code}}">
        <input type="hidden" id="goods_item_coupon_price"	name="goods_item_coupon_price[]" value="{{item_coupon_amt}}">
        <input type="hidden" id="goods_add_coupon_code"		name="goods_add_coupon_code[]"  value="">
        <input type="hidden" id="goods_add_discount_price"	name="goods_add_discount_price[]" value=0>
        <input type="hidden" id="goods_add_coupon_type"		name="goods_add_coupon_type[]"  value="">
        <input type="hidden" id="goods_add_coupon_gubun"	name="goods_add_coupon_gubun[]"	value="">
        <input type="hidden" id="goods_add_coupon_no"		name="goods_add_coupon_no[]"	value="">
        <input type="hidden" id="goods_coupon_amt"			name="goods_coupon_amt[]"	value="{{dataPrice}}">	<!--쿠폰적용가-->
        <dt class="select_essential_title">{{option_string}}</dt>
        <dd class="select_essential_info">
            <div class="quantity quantity__min">
                <div class="quantity_select">

                    <input type="text" id="goods_cnt" name="goods_cnt[]" onChange="javascript:onlyNumber(this,'B',{{option_code}});" class="quantity_input" value="1" data-max="{{mpq}}">
                    <input type="text" style="VISIBILITY: hidden; WIDTH: 0px"/>//엔터막기
                    <button type="button" class="quantity_minus_btn" onClick="javascript:jsChangeNum('B',-1,{{option_code}});">
                        <span class="text">minus</span>
                        <span class="spr-common btn-minus-min"></span>
                    </button>
                    <button type="button" class="quantity_plus_btn" onClick="javascript:jsChangeNum('B',1,{{option_code}});">
                        <span class="text">plus</span>
                        <span class="spr-common btn-plus-min"></span>
                    </button>
                </div>
            </div>
            <div class="price ui_price_add">
                <button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="" onClick="javascript:couponLayerOpen({{option_code}});">쿠폰선택</button> <s name="option_selling_price" style="font-weight:lighter">{{selling_price}}</s>&nbsp;&nbsp;<span name="cpn_price">{{price}}</span>
            </div>
            <a href="#" class="btn_delete"><span class="spr-common spr_close_03"></span></a>
        </dd>
    </dl>
</script>
<script type="text/javascript">
    function onlyNumber(obj,gb,val) { //제이쿼리 포커스 아웃처리=>옵션수량부분 input 부분

        $(obj).focusout(function(){

            var buymaxCnt = "<?=$goods['BUY_LIMIT_QTY']?>";

            if(gb == 'A'){	//단일 옵션
                var goods_cnt = document.getElementsByName("goods_cnt[]")[0].value;
                var cnt = parseInt(goods_cnt);

                if(cnt<1 || isNaN(cnt) == true){
                    cnt = 1;
                }

                if(buymaxCnt != 0){
                    if(cnt > buymaxCnt){
                        alert('1회 최대 구매수는 '+buymaxCnt+' 개 입니다');
                        $($("input[name='goods_cnt[]']").get(idx)).val(1);
                        return false;
                    }
                }


                if(document.getElementsByName("goods_option_qty[]")[0].value < cnt){
                    alert("현재 주문가능한 재고수량은 "+document.getElementsByName("goods_option_qty[]")[0].value+"개 입니다.\n"+document.getElementsByName("goods_option_qty[]")[0].value+"개 이하로 주문해 주세요.");
                    $($("input[name='goods_cnt[]']").get(idx)).val(1);
                    return false;
                }

                //쿠폰이 선택되어있는 경우
                if($($("input[name='goods_add_coupon_code[]']").get(0)).val() != '' || $($("input[name='goods_item_coupon_code[]']").get(0)).val() != $("input[name='goods_coupon_code_i']").val().split("||")[0]){
                    if(confirm("수량을 변경하시면, 선택하신 쿠폰이 초기화 됩니다.")){
                        //아이템 쿠폰 히든 값에 넣어놨던 쿠폰들 다 리셋
                        $($("input[name='goods_item_coupon_code[]']").get(0)).val($("input[name='goods_coupon_code_i']").val().split("||")[0]);
                        $($("input[name='goods_item_coupon_price[]']").get(0)).val($("input[name='goods_coupon_amt_i']").val());

                        //바이어쿠폰 히든값을 빈값으로 넣기
                        $($("input[name='goods_add_coupon_code[]']").get(0)).val('');
                        $($("input[name='goods_add_discount_price[]']").get(0)).val(parseInt(0));
                        $($("input[name='goods_add_coupon_type[]']").get(0)).val('');
                        $($("input[name='goods_add_coupon_gubun[]']").get(0)).val('');
                        $($("input[name='goods_add_coupon_no[]']").get(0)).val('');
                    } else {
                        return false;
                    }
                }

                document.getElementsByName("goods_cnt[]")[0].value = cnt;
                totalPrice();

                $("span[name='coupon_price_text']").text(numberFormat((parseInt($("input[name='goods_selling_price']").val())-parseInt($("input[name='goods_discount_price']").val()))*parseInt(document.getElementsByName("goods_cnt[]")[0].value)));	//쿠폰할인가

                $("span[name='selling_price_text']").text(numberFormat(parseInt($("input[name='goods_selling_price']").val())*parseInt(document.getElementsByName("goods_cnt[]")[0].value)));	//판매가

            }
            else if(gb == 'B'){	//옵션

                for(var i=0; i<document.getElementsByName("goods_option_code[]").length; i++){
                    if(val == document.getElementsByName("goods_option_code[]")[i].value){
                        var idx = i;
                        break;
                    }
                }

                var goods_cnt = document.getElementsByName("goods_cnt[]")[idx].value;

                var cnt = parseInt(goods_cnt);
                if(cnt<1 || isNaN(cnt) == true){
                    cnt = 1;
                }

                if(buymaxCnt != 0){
                    if(cnt > buymaxCnt){
                        alert('1회 최대 구매수는 '+buymaxCnt+' 개 입니다');
                        $($("input[name='goods_cnt[]']").get(idx)).val(1);
                        return false;
                    }
                }

                if(document.getElementsByName("goods_option_qty[]")[idx].value < cnt){
                    alert("현재 주문가능한 재고수량은 "+document.getElementsByName("goods_option_qty[]")[idx].value+"개 입니다.\n"+document.getElementsByName("goods_option_qty[]")[idx].value+"개 이하로 주문해 주세요.");
                    $($("input[name='goods_cnt[]']").get(idx)).val(1);
                    return false;
                }

                //쿠폰이 선택되어있는 경우
                if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() != '' || $($("input[name='goods_item_coupon_code[]']").get(idx)).val() != $("input[name='goods_coupon_code_i']").val().split("||")[0]){
                    if(confirm("수량을 변경하시면, 선택하신 쿠폰이 초기화 됩니다.")){
                        //아이템 쿠폰 히든 값에 넣어놨던 쿠폰들 다 리셋
                        $($("input[name='goods_item_coupon_code[]']").get(idx)).val($("input[name='goods_coupon_code_i']").val().split("||")[0]);
                        $($("input[name='goods_item_coupon_price[]']").get(idx)).val($("input[name='goods_coupon_amt_i']").val());

                        //바이어쿠폰 히든값을 빈값으로 넣기
                        $($("input[name='goods_add_coupon_code[]']").get(idx)).val('');
                        $($("input[name='goods_add_discount_price[]']").get(idx)).val(parseInt(0));
                        $($("input[name='goods_add_coupon_type[]']").get(idx)).val('');
                        $($("input[name='goods_add_coupon_gubun[]']").get(idx)).val('');
                        $($("input[name='goods_add_coupon_no[]']").get(idx)).val('');
                    } else {
                        return false;
                    }
                }

                document.getElementsByName("goods_cnt[]")[idx].value = cnt;

                var selling_price			= parseInt($("input[name='goods_selling_price']").val());
                var goods_option_add_price	= parseInt($($("input[name='goods_option_add_price[]']").get(idx)).val());
                var seller_coupon_amt		= parseInt($("input[name='goods_coupon_amt_s']").val());
                var item_coupon_amt			= parseInt($($("input[name='goods_item_coupon_price[]']").get(idx)).val());
                var cust_coupon_amt			= parseInt($($("input[name='goods_add_discount_price[]']").get(idx)).val());
                var coupon_price			= ( selling_price + goods_option_add_price ) - ( seller_coupon_amt + item_coupon_amt + cust_coupon_amt);


                //판매금액 적용
                $("s[name=option_selling_price]").eq(idx).text(numberFormat(parseInt(selling_price + goods_option_add_price) * parseInt(cnt)));
                //할인금액 적용
                $("span[name=cpn_price]").eq(idx).text(numberFormat(parseInt(coupon_price) * parseInt(cnt)));

                $($("input[name='goods_coupon_amt[]']").get(idx)).val(parseInt(coupon_price) * parseInt(cnt))

//		totalPrice();
                Total_goods_price();
            }
        });
    }
</script>

<script type="text/javascript">

    if(document.getElementById("option_yn").value == 'Y'){
        /***********************/
        /*****기본 값 세팅******/
        /***********************/
        var aJsonArray = new Array();
        var aJson = new Object();

        <?  $i = 1;
        if($template_option_list){
        foreach($template_option_list as $row){
        $DEPTH = substr_count($row['SEQ'],"|");
        if($DEPTH == 0){	//멀티옵션1일경우 멀티옵션 2 배열 미리 생성?>
        eval("var moption2Array_"+"<?=$i?>"+" = new Array();");
        <?		$i++;
        } else if($DEPTH == 1){	//멀티옵션2일경우 멀티옵션 3 배열 미리 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];	?>
        eval("var moption3Array_"+"<?=$i.$j?>"+" = new Array();");
        <?		} else if($DEPTH == 2){	//멀티옵션3일경우 멀티옵션 4 배열 미리 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];	?>
        eval("var moption4Array_"+"<?=$i.$j.$k?>"+" = new Array();");
        <?		} else if($DEPTH == 3){ //멀티옵션4일경우 멀티옵션 4 배열 미리 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];	?>
        eval("var moption5Array_"+"<?=$i.$j.$k.$l?>"+" = new Array();");
        <?		}
        }
        }	//END IF
        ?>

        <?  $i = 1;
        if($template_option_list){
        foreach($template_option_list as $row) {
        $DEPTH = substr_count($row['SEQ'],"|");

        if($DEPTH == 0){	//멀티옵션 1 생성?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";

        aJson.link = "#";
        aJson.string = "<?=$row['OPT_NAME']?>";
        aJson.value = "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i?>";
        aJson.price = parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);
        aJson.len = "<?=$row['GOODS_OPTION_QTY']?>";
        aJson.MPQ = 10;

        <? if($MOPTION_RESULT == 'M_OPTION_1'){	?>
        aJson.subOption = 'false';
        <? } else { ?>
        aJson.subOption = 'moption2_<?=$i?>';
        <? }?>

        aJsonArray.push(aJson);
        var aJson = new Object();
        <?		$i++;
        } else if($DEPTH == 1 && ( $MOPTION_RESULT == 'M_OPTION_2' || $MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5' )){	//멀티옵션 2 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];

        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption2_<?=$i?> = new Object();");	//오브젝트 초기화

        eval("moption2_"+"<?=$i?>"+".link = '#';");
        eval("moption2_"+"<?=$i?>").string = "<?=$row['OPT_NAME']?>";
        eval("moption2_"+"<?=$i?>").value = "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i?>";
        eval("moption2_"+"<?=$i?>"+".price = parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption2_"+"<?=$i?>"+".len = "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption2_"+"<?=$i?>"+".MPQ = 10;");

        <? if($MOPTION_RESULT == 'M_OPTION_2'){	?>
        eval("moption2_"+"<?=$i?>"+".subOption = 'false';");
        <? } else { ?>
        eval("moption2_"+"<?=$i?>"+".subOption = 'moption3_<?=$i.$j?>';");
        <? }?>

        eval("moption2Array_"+"<?=$i?>"+".push(moption2_"+"<?=$i?>);");
        eval("var moption2_<?=$i?> = new Object();");	//오브젝트 초기화
        <?		} else if($DEPTH == 2 && ( $MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5' )){	//멀티옵션 3 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption3_<?=$i.$j?> = new Object();");	//오브젝트 초기화

        eval("moption3_"+"<?=$i.$j?>"+".link = '#';");
        eval("moption3_"+"<?=$i.$j?>").string = "<?=$row['OPT_NAME']?>";
        eval("moption3_"+"<?=$i.$j?>").value = "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i.$j?>";
        eval("moption3_"+"<?=$i.$j?>"+".price = parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption3_"+"<?=$i.$j?>"+".len = "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption3_"+"<?=$i.$j?>"+".MPQ = 10;");

        <? if($MOPTION_RESULT == 'M_OPTION_3'){	?>
        eval("moption3_"+"<?=$i.$j?>"+".subOption = 'false';");
        <? } else { ?>
        eval("moption3_"+"<?=$i.$j?>"+".subOption = 'moption4_<?=$i.$j.$k?>';");
        <? } ?>

        eval("moption3Array_"+"<?=$i.$j?>"+".push(moption3_"+"<?=$i.$j?>);");
        eval("var moption3_<?=$i.$j?> = new Object();");	//오브젝트 초기화
        <?		} else if($DEPTH == 3 && ( $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5' )){	//멀티옵션 4 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];
        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption4_<?=$i.$j.$k?> = new Object();");	//오브젝트 초기화

        eval("moption4_"+"<?=$i.$j.$k?>"+".link = '#';");
        eval("moption4_"+"<?=$i.$j.$k?>").string = "<?=$row['OPT_NAME']?>";
        eval("moption4_"+"<?=$i.$j.$k?>").value = "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i.$j.$k?>";
        eval("moption4_"+"<?=$i.$j.$k?>"+".price = parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption4_"+"<?=$i.$j.$k?>"+".len = "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption4_"+"<?=$i.$j.$k?>"+".MPQ = 10;");

        <? if($MOPTION_RESULT == 'M_OPTION_4'){	?>
        eval("moption4_"+"<?=$i.$j.$k?>"+".subOption = 'false';");
        <? } else { ?>
        eval("moption4_"+"<?=$i.$j.$k?>"+".subOption = 'moption5_<?=$i.$j.$k.$l?>';");
        <? }?>

        eval("moption4Array_"+"<?=$i.$j.$k?>"+".push(moption4_"+"<?=$i.$j.$k?>);");
        eval("var moption4_<?=$i.$j.$k?> = new Object();");	//오브젝트 초기화
        <?		} else if($DEPTH == 4 && ( $MOPTION_RESULT == 'M_OPTION_5' )){ //멀티옵션 5 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];
        $m = explode("|",$row['SEQ'])[4];
        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption5_<?=$i.$j.$k.$l?> = new Object();");	//오브젝트 초기화

        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".link = '#';");
        eval("moption5_"+"<?=$i.$j.$k.$l?>").string = "<?=$row['OPT_NAME']?>";
        eval("moption5_"+"<?=$i.$j.$k.$l?>").value = "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i.$j.$k.$l?>";
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".price = parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".len = "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".MPQ = 10;");
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".subOption = 'false';");

        eval("moption5Array_"+"<?=$i.$j.$k.$l?>"+".push(moption5_"+"<?=$i.$j.$k.$l?>);");
        eval("var moption5_<?=$i.$j.$k.$l?> = new Object();");	//오브젝트 초기화
        <?		}

        }
        } //END IF?>

        var bJson = new Object();
        bJson.title = '<?=$goods_option_info['M_OPTION_1_NM']?>';
        <? if($MOPTION_RESULT == 'M_OPTION_5'){	?>
        bJson.subTitle = ['<?=$goods_option_info['M_OPTION_2_NM']?>','<?=$goods_option_info['M_OPTION_3_NM']?>','<?=$goods_option_info['M_OPTION_4_NM']?>','<?=$goods_option_info['M_OPTION_5_NM']?>'];
        <? } else if($MOPTION_RESULT == 'M_OPTION_4'){	?>
        bJson.subTitle = ['<?=$goods_option_info['M_OPTION_2_NM']?>','<?=$goods_option_info['M_OPTION_3_NM']?>','<?=$goods_option_info['M_OPTION_4_NM']?>'];
        <? } else if($MOPTION_RESULT == 'M_OPTION_3'){	?>
        bJson.subTitle = ['<?=$goods_option_info['M_OPTION_2_NM']?>','<?=$goods_option_info['M_OPTION_3_NM']?>'];
        <? } else if($MOPTION_RESULT == 'M_OPTION_2'){	?>
        bJson.subTitle = ['<?=$goods_option_info['M_OPTION_2_NM']?>'];
        <? }	?>

        bJson.options = aJsonArray;
        bJsonString			= JSON.stringify(bJson);
        TotalOptionJson_1	= JSON.parse(bJsonString);

        //제일 큰 옵션 (optionData 배열 생성)
        var cJson = new Object();
        cJson.opt_1 = TotalOptionJson_1;

        <?  $i = 1;
        if($MOPTION_RESULT == 'M_OPTION_2' || $MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5'){

        if($template_option_list){
        foreach($template_option_list as $row){
        $DEPTH = substr_count($row['SEQ'],"|");
        if($DEPTH == 0){	?>
        eval("cJson.moption2_"+"<?=$i?>"+" = moption2Array_"+"<?=$i?>"+";");
        <?		 $i++;
        } else if($DEPTH == 1){
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];

        if($MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5'){		?>
        eval("cJson.moption3_"+"<?=$i.$j?>"+" = moption3Array_"+"<?=$i.$j?>"+";");
        <?			}
        } else if($DEPTH == 2){
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];

        if($MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5'){		?>
        eval("cJson.moption4_"+"<?=$i.$j.$k?>"+" = moption4Array_"+"<?=$i.$j.$k?>"+";");
        <?			}
        } else if($DEPTH == 3){
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];

        if($MOPTION_RESULT == 'M_OPTION_5'){		?>
        eval("cJson.moption5_"+"<?=$i.$j.$k.$l?>"+" = moption5Array_"+"<?=$i.$j.$k.$l?>"+";");
        <?			}
        }
        }	//END FOREACH
        }

        }	//END IF
        ?>
        cJsonString = JSON.stringify(cJson);
        GroupOption = JSON.parse(cJsonString);

        var optionData = GroupOption;		//옵션 생성


        // 가격에 콤마를 추가
        function comma(str)
        {
            str = String(str);
            return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
        }

        // 총 주문금액을 산출
        function totalPrice()
        {
            var priceElement = $('#total_price'),
                priceAddList = $('#selectListInner').find('.ui_select_item'),
                priceTotal = 0;

            if (priceAddList.length > 0)
            {
                $.each(priceAddList, function()
                {
                    var _thisPrice = parseInt($(this).data('price'), 10),
                        _thisLength = parseInt($(this).find('.quantity_input').val());
                    priceTotal += _thisPrice * _thisLength;
                });
                priceElement.text(comma(priceTotal) + '원');
            }
        }
        function returnJsonData(key, callback)
        {
            var data = optionData[key];

            if (typeof callback === 'function')
            {
                callback(data, key);
            }
        }

        // 옵션 레이어에 들어가는 리스트를 생성하여 리턴.
        function commonListHtml(data)
        {
            var html = '';
            $.each(data, function(index)
            {

                var _this = this,
                    _class = (_this.len === 0 || _this.len === '0') ? 'del' : '',
                    length = (function()
                    {
                        if (_this.len === 0 || _this.len === '0')
                        {
                            return ' [품절]';
                        }
                        else if (_this.len === null || _this.len === 'null')
                        {
                            return '';
                        }
                        else
                        {
                            return ' [잔여수량:' + _this.len + '개]';
                        }
                    })(),
                    subOption = (function()
                    {
                        if (_this.subOption !== 'false' && _class !== 'del')
                        {
                            return 'data-name="' + _this.subOption + '" class="ui_sub_option"';
                        }
                        else
                        {
                            if (_class !== 'del')
                            {
                                return 'class="ui_sub_select"';
                            }
                            else
                            {
                                return 'class="ui_sub_not_select"';
                            }

                        }
                    })();

                html += '<li class="select_option_item ' + _class + '">';
                html += '<a href="' + _this.link + '" data-value="' + _this.value + '" ' + subOption + ' data-price="' + _this.price + '" data-max="' + _this.MPQ + '" data-len="' + _this.len + '">';
                if(subOption == 'class="ui_sub_select"' || subOption == 'class="ui_sub_not_select"'){	//더이상 추가할 옵션이 없을경우 재고수량 보여줌
                    var goods_sale_price = parseInt(document.getElementById("goods_form").goods_selling_price.value) - parseInt(document.getElementById("goods_form").goods_discount_price.value);	//상품할인가

                    option_add_price	= parseInt(_this.price) - goods_sale_price;	//옵션추가금액 넣기
                    if(option_add_price > 0){
                        html += _this.string + "(+"+comma(option_add_price)+"원)"+ length;
                    } else if(option_add_price < 0){
                        html += _this.string + "("+comma(option_add_price)+"원)"+ length;
                    } else {
                        html += _this.string + length;
                    }
                } else {
                    html += _this.string;
                }

                html += '</a></li>';
            });

            return html;
        }
        // 옵션 레이어를 생성
        function createOptionHtml(data)
        {
            var html = '<div class="select_option_layer">';
            html += '<span class="title">' + data.title + '</span>';
            html += '<ul class="select_option_list">';
            html += commonListHtml(data.options);
            html += '</ul></div>'
            if (data.subTitle)
            {
                $.each(data.subTitle, function()
                {
                    var subTitleStr = ''
                    subTitleStr += '<div class="select_option_layer">';
                    subTitleStr += '<span class="title">' + this + '</span>';
                    subTitleStr += '</div>';
                    html += subTitleStr;
                });
            }
            return $(html);
        }

        // 추가 옵션 레이어를 생성
        function createAddOptionHtml(data)
        {
            var html = '<ul class="select_option_list">'
            html += commonListHtml(data);
            html += '</ul>';
            return $(html);
        }
        function selectOptionLayer($element, _data)
        {
            var openLayer = $($element.data('target')),
                html = null;
            $('.select_option_wrap').hide();
            if (!openLayer.data('option'))
            {
                html = createOptionHtml(_data);
                openLayer.append(html);
                openLayer.data('option', true);
                openLayer.css(
                    {
                        'top': -(openLayer.find('.select_option_layer').length - 2) * 42
                    }).show();
            }
            else
            {
                openLayer.find('.select_option_title').remove().end()
                    .find('.select_option_list').hide().end()
                    .find('.select_option_layer').eq(0)
                    .find('.select_option_list').show();
                openLayer.show();
            }
        }
        function subOptionLayer($element, _data)
        {
            var openLayer = $element.parents('.select_option_wrap'),
                writeEle = $element.parents('.select_option_layer'),
                _index = writeEle.index(),
                addTitle = '<span class="select_option_title">' + $element.text() + '</span>';
            writeEle.next().append(createAddOptionHtml(_data)).show();

            writeEle
                .find('.select_option_list').hide().end()
                .find('.title').append(addTitle);
        }
        function selectOption(data)
        {
            var goods_sale_price = parseInt(document.getElementById("goods_form").goods_selling_price.value) - parseInt(document.getElementById("goods_form").goods_discount_price.value);

            data.selling_price		= comma(parseInt(document.getElementById("goods_form").goods_selling_price.value));
            data.option_code		= data.value.split("||")[0];	//옵션코드 넣기
            data.option_add_price	= parseInt(data.dataPrice) - goods_sale_price;	//옵션추가금액 넣기

            if(data.option_add_price > 0){
                data.option_name		= data.string.split("(+")[0];	//옵션명 넣기
                data.selling_price		= comma(parseInt(document.getElementById("goods_form").goods_selling_price.value)+parseInt(data.option_add_price));
            } else if(data.option_add_price < 0){
                data.option_name		= data.string.split("(-")[0];	//옵션명 넣기
                data.selling_price		= comma(parseInt(document.getElementById("goods_form").goods_selling_price.value)+parseInt(data.option_add_price));
            } else {
                data.option_name		= data.string.split("[잔여수량:")[0];	//옵션명 넣기
            }
            data.option_string	=  data.string.split("[잔여수량:")[0];	//옵션명 넣기

            if(document.getElementById("goods_coupon_code_i").value != ''){
                data.item_coupon_code	= document.getElementById("goods_coupon_code_i").value.split('||')[0];
                data.item_coupon_amt	= document.getElementById("goods_coupon_amt_i").value;
            } else {
                data.item_coupon_code	= '';
                data.item_coupon_amt	= 0;
            }

            var source = $('#selectOption-template').html(),
                template = Handlebars.compile(source),
                html = $(template(data)),
                box = $('#selectList'),
                box_inner = $('#selectListInner'),
                state = true;

            if ($('#selectList').find('.ui_select_item').length > 0)
            {
                $.each($('#selectList').find('.ui_select_item'), function()
                {
                    if ($(this).data('value') === data.value)
                    {
                        state = false;
                    }
                });

            }
            box.show();
            if (state)
            {
                html.data('opener', data.opener);
                box_inner.prepend(html);
            }
            $('.select_option_wrap').hide();
            totalPrice();
            Total_goods_price();

            couponLayerCreate(data.option_code,data.option_add_price);	//쿠폰레이어 생성
        }
        function removeOption($this)
        {
            var block = $('#selectList');
            $this.parents('.ui_select_item').remove();
            if (block.find('.ui_select_item').length <= 0)
            {
                block.hide();
            }
            else
            {
                totalPrice();
                Total_goods_price();
            }
        }


        $('#vipSelectOption').on('click', '.quantity_select', function()
        {
            // plus & minus event bind
            var maxcnt = '<?=$buyMaxCnt?>';
            var defaultMax = 100, // 최대 구매수량 미지정 시 기본값을 셋팅 합니다. 정책에 따라 수정해 주세요.
                input = $(this).find('.quantity_input'),
                plus = 'quantity_plus_btn',
                minus = 'quantity_minus_btn',
                clickTarget = $(event.target).closest('button'),
                val = parseInt(input.val(), 10),
                maxCounter = (input.data('max')) ? input.data('max') : defaultMax;
        }).on('click', '.btn-close-05', function()
        {
            $(this).parents('.select_option_wrap').hide();
        }).on('click', '.ui_select_option', function()
        {
            // 옵션 선택 레이어 열기

            var _this = $(this);
            returnJsonData(_this.data('name'), function(data, key)
            {
                selectOptionLayer(_this, data);
            });

        }).on('click', '.ui_sub_option', function()
        {
            // 추가 옵션 레이어 열기

            var _this = $(this);
            returnJsonData(_this.data('name'), function(data, key)
            {
                subOptionLayer(_this, data);
            });
            return false;
        }).on('click', '.ui_sub_select', function()
        {
            // 최종 옵션 선택 하여 리스트에 추가.
            var data = {
                'value': $(this).data('value'),
                'string': $(this).text(),
                'price': comma($(this).data('price')),
                'dataPrice': $(this).data('price'),
                'opener': $(this),
                'mpq': $(this).data('max'),
                'len': $(this).data('len')
            };
            selectOption(data);
            return false;
        }).on('click', '.ui_sub_not_select', function()
        {
            // 품절 및 선택 불가 상품

            alert('재고가 부족하여 구매 하실 수 없습니다.')
            return false;
        }).on('click', '.btn_delete', function()
        {
            // 삭제 버튼 클릭

            removeOption($(this));
            return false;
        })

    }
    //===============================================================
    // 상품 바로구매
    //===============================================================
    function jsDirect(){
        var cookieGoodsCd	= "<?=$cookieGoodsCd?>";
        var goodsCd			= "<?=$goods['GOODS_CD']?>";

        if(cookieGoodsCd == goodsCd){
            alertDelay('해당상품은 1일 구매제한이 있습니다.');
            return false;
        }

        var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        var param		= $("#goods_form").serialize();
        var goods_option_code = $("input[name='goods_option_code[]']").val();

        if($("input[name=goods_state]").val() != '03'){
            alertDelay("판매중이 아닌 상품은 구매할 수 없습니다.");
            return false;
        }

        if(goods_option_code == undefined){
            alertDelay("옵션을 선택해주세요.");
            return false;
        }
        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){	//로그인 안한 경우
            document.getElementById("goods_form").guest_gb.value = 'direct';

            var frm = document.getElementById("goods_form");
            frm.action = "https://"+SSL_val+"/member/Guestlogin";
            frm.submit();
        } else {
            var frm = document.getElementById("goods_form");
//		frm.action = "/cart/OrderInfo";
            frm.action = "https://"+SSL_val+"/cart/OrderInfo";
            frm.submit();
        }
    }

    //===============================================================
    // 장바구니에 상품 담기
    //===============================================================
    function jsAddCart(){
        var cookieGoodsCd	= "<?=$cookieGoodsCd?>";
        var goodsCd			= "<?=$goods['GOODS_CD']?>";

        if(cookieGoodsCd == goodsCd){
            alertDelay('해당상품은 1일 구매제한이 있습니다.');
            return false;
        }

        var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
        var param		= $("#goods_form").serialize();
        var goods_option_code = $("input[name='goods_option_code[]']").val();

        if($("input[name=goods_state]").val() != '03'){
            alertDelay("판매중이 아닌 상품은 장바구니에 담을 수 없습니다.");
            return false;
        }

        if(goods_option_code == undefined){
            alertDelay("옵션을 선택해주세요.");
            return false;
        }

        google_ga('add_to_cart');

        $.ajax({
            type: 'POST',
            url: '/cart/insert_cart',
            async: false,
            dataType: 'json',
            data: param,
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    if(window.confirm('장바구니에 상품이 담겼습니다. 확인하시겠습니까?')){
                        location.href='/cart';
                    }
                }
                else alert(res.message);
            }
        });

        return false;
    }

    //===============================================================
    // 로그인 후 문의하기
    //===============================================================
    function jsLogin(){
        var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){
            if(confirm("로그인 후에 문의할 수 있습니다. 로그인 하시겠습니까?")){
                location.href = '/member/login';
            }
        }
    }

    //===============================================================
    // 상품평 등록하기
    //===============================================================
    function jsComment(){
        var data = new FormData($('#updFile')[0]);

        var comment_goods_code	= $("input[name=goods_code]").val();
        var comment_contents	= $("#comment_contents").val();
        var comment_grade_val01	= $("select[name=grade_val01]").val();
        var comment_grade_val02	= $("select[name=grade_val02]").val();
        var comment_grade_val03	= $("select[name=grade_val03]").val();
        var comment_grade_val04	= $("select[name=grade_val04]").val();
        var comment_grade_val05 = $("select[name=grade_val05]").val();
        var mem_id				= "<?=$this->session->userdata('EMS_U_ID_')?>";

        if( comment_grade_val01 == ""){
            alert('품질 만족도를 표시해주시기 바랍니다.');
            $("select[name=grade_val01]").focus();
            return false;
        }

        if( comment_grade_val02 == ""){
            alert('배송 만족도를 표시해주시기 바랍니다.');
            $("select[name=grade_val02]").focus();
            return false;
        }

        if( comment_grade_val03 == ""){
            alert('가격 만족도를 표시해주시기 바랍니다.');
            $("select[name=grade_val03]").focus();
            return false;
        }

        if( comment_grade_val04 == ""){
            alert('디자인 만족도를 표시해주시기 바랍니다.');
            $("select[name=grade_val04]").focus();
            return false;
        }

        if( comment_grade_val05 == ""){
            alert('만족도를 표시해주시기 바랍니다.');
            $("select[name=grade_val05]").focus();
            return false;
        }

        if( ! comment_contents ){
            alert('상품평 내용을 입력하시기 바랍니다.');
            $("input[name=comment_contents]").focus();
            return false;
        }

        if(comment_contents.length < 20){
            alert('20자 이상 구매평을 남겨주세요.');
            $("input[name=comment_contents]").focus();
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '/mywiz/comment_regist',
            dataType: 'json',
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert('등록이 완료 되었습니다.');
                    location.reload();
                }
                else console.log(res.message);
            }
        })

    }
    //===============================================================
    // 상품 문의하기
    //===============================================================
    function jsQna(){
        var qna_goods_code	= $("input[name=goods_code]").val();
        var qna_title		= $("input[name=qna_title]").val();
        var qna_contents	= $('#qna_contents').val();
        var qna_type		= "GOODS";
        var mem_id			= "<?=$this->session->userdata('EMS_U_ID_')?>";

        if( ! qna_title ){
            alert('문의 제목을 입력하시기 바랍니다.');
            $("input[name=qna_title]").focus();
            return false;
        }
//alert(qna_contents);
        if ( ! qna_contents ){
            alert('문의 내용을 입력하시기 바랍니다.');
            $('#qna_contents').focus();
            return false;
        }

        if ($("input[name=qna_secret]").is(':checked') == true)
        {
            $("input[name=qna_secret]").val('Y');
        }

        var qna_secret		= $("input[name=qna_secret]").val();

        $.ajax({
            type: 'POST',
            url: '/mywiz/qna_regist',
            dataType: 'json',
            data: {goods_code : qna_goods_code, title : qna_title, contents : qna_contents, qna_type : qna_type, mem_id : mem_id, secret_yn : qna_secret},
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert('등록이 완료 되었습니다.');
                    location.reload();
                }
                else alert(res.message);
            }
        })

    }

    //==================================================================
    // 이미지 롤링 스크립트
    //==================================================================
    var goods_img_cnt = "<?=count($goods['img'])?>";
    var ImageJsonArray	= new Array();
    var ImageJson		= new Object();

    for (var i=0; i<goods_img_cnt; i++)
    {
        var ImageJson		= new Object();

        ImageJson.type	= "image";
        ImageJson.src	= document.getElementsByName("rolling_goods_img[]")[i].value;

        ImageJsonArray.push(ImageJson);
    }

    var vipBannerItem = ImageJsonArray;

    function vipBannerRoll(data)
    {
        var $box = $('#vip_banner'),
            $view = $box.find('.vip_banner_list'),
            $list = $box.find('.vip_banner_btn'),
            //$corver = $box.find('.vip_banner_corver'),
            $left = $box.find('.btn_left'),
            $right = $box.find('.btn_right'),
            listHtml = '',
            viewHtml = '',
            corverHtml = '',
            moveWidth = 640,
            total = data.length,
            defaultMargin = -440;

        var state = {
            page: 0,
            mode: 'max',
            motion: 'stop'
        };


        var defaultMarginReset = function()
        {
            if ($('body').hasClass('min-layout'))
            {
                defaultMargin = -601;
            }
            else
            {
                defaultMargin = -440;
            }
        }

        // create Html
        var setting = function()
        {
            $.each(data, function(index)
            {
                var _class = (index === 0) ? 'active' : '';
                if (this.type === 'image')
                {
                    listHtml += '<li data-index="' + index + '" data-type="images" class="ui-listclick ' + _class + '"><span>';
                    listHtml += '<img src="' + this.src + '" alt="" width="120" height="120">';
                    listHtml += '</span></li>';

                    viewHtml += '<li class="vip_banner_item ' + _class + '" data-index="' + index + '">';
                    viewHtml += '<img src="' + this.src + '" alt="" width="640" height="640">';
                    viewHtml += '</li>';
                }
                else
                {
                    var poster = (this.poster) ? this.poster : this.thm;
                    listHtml += '<li data-index="' + index + '" data-type="video" class="ui-listclick ">';
                    listHtml += '<img src="' + this.thm + '" alt="" width="120" height="120">';
                    listHtml += '<button type="button" class="btn_play"><img src="/assets/images/display/btn_play.png" alt="play"></button>';
                    listHtml += '</li>';


                    viewHtml += '<li class="vip_banner_item ' + _class + '" data-index="' + index + '">';
                    viewHtml += '<video muted="" preload="auto" loop width="640" poster="' + poster + '">';
                    viewHtml += '<source src="' + this.src + '" type="video/mp4">';
                    if (this.src2)
                    {
                        viewHtml += '<source src="' + this.src2 + '" type="video/webm">';
                    }
                    viewHtml += '</video>'
                    viewHtml += '</li>';
                }
                if (index === 1)
                {
                    corverHtml += '<li class="active"></li>';
                }
                else
                {
                    corverHtml += '<li></li>';
                }

            });
            if (total < 5)
            {
                // console.log( 5-total )
                var i = 0,
                    roof = 5 - total;
                for (i; roof > i; i++)
                {
                    // console.log(i)
                    listHtml += '<li><a href="#"><img src="/assets/images/display/bnr_120x120_none.gif" alt=""></a></li>';
                }
            }
            $view.html(viewHtml);
            $list.html(listHtml);


            if (data.length < 4)
            {
                if (data.length === 1)
                {
                    $box.addClass('vip_banner_one');
                }
                else
                {
                    $view.find('li').last().prependTo($view);
                    //$box.addClass('vip_banner_fadeui');
                    $list.find('li.ui-listclick').on('click', function()
                    {
                        slider($(this).data('index'));
                    });
                    $left.on('click', function()
                    {
                        slider('left');
                        return false;
                    });
                    $right.on('click', function()
                    {
                        slider('right');
                        return false;
                    });
                }
            }
            else
            {
                $view.find('li').last().prependTo($view);
                $list.find('li').on('click', function()
                {
                    slider($(this).data('index'));
                });
                $left.on('click', function()
                {
                    slider('left');
                    return false;
                });
                $right.on('click', function()
                {
                    slider('right');
                    return false;
                });
            }
            $view.css('width', moveWidth * (total + 1));

        };

        var pageChecker = function(string)
        {

            if (string === 'right')
            {
                if (state.page < total - 1)
                {
                    return state.page + 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                if (state.page > 0)
                {
                    return state.page - 1;
                }
                else
                {
                    return total - 1;
                }
            }
        }

        var pageController = function()
        {

            $list.find('li.active').removeClass('active');
            $list.find('li').eq(state.page).addClass('active');

            $view.find('li.active').removeClass('active');
            $view.find('li[data-index=' + state.page + ']').addClass('active');

            if ($list.find('li').eq(state.page).data('type') === 'video')
            {
                $view.find('li[data-index=' + state.page + ']').find('video').get(0).play();
            }
        }

        var fader = function(align)
        {
            if (state.motion === 'play')
            {
                return false;
            }

            state.motion = 'play';

            var move = (function()
                {
                    if (typeof align === 'number')
                    {
                        return parseInt(align, 10);
                    }
                    else
                    {
                        if (align === 'left')
                        {
                            return pageChecker('left');
                        }
                        else
                        {
                            return pageChecker('right');
                        }
                    }
                })(),
                nextElement = $view.find('li[data-index=' + move + ']');
            if (move === state.page)
            {
                state.motion = 'stop';
                return false;
            }
            nextElement.css(
                {
                    'opacity': 0,
                    'z-index': 10
                }).animate(
                {
                    'opacity': 1
                },
                {
                    duration: 200,
                    easing: 'linear',
                    complete: function()
                    {
                        $view.find('li.active').css('z-index', 1);
                        nextElement.css('z-index', ( (total-1 === 1 )?2:total-1) ).addClass('active');
                        state.motion = 'stop';
                        state.page = move;
                        pageController();
                    }
                })

        }

        var slider = function(align)
        {
            if (state.motion === 'play')
            {
                return false;
            }

            state.motion = 'play';
            defaultMarginReset();

            var move = (function()
            {
                if (typeof align === 'number')
                {
                    return state.page - parseInt(align, 10);
                }
                else
                {
                    // return pageChecker( align );
                    if (align === 'left')
                    {
                        return 1;
                    }
                    else
                    {
                        return -1;
                    }
                }
            })();

            if ($list.find('li').eq(state.page).data('type') === 'video')
            {
                $view.find('li[data-index=' + state.page + ']').find('video').get(0).pause();
            }

            if (align === state.page)
            {
                state.motion = 'stop';
                return false;
            }



            var targetNumber = move,
                roofNum = Math.abs(targetNumber, 10),
                item = $view.find('li');

            if (targetNumber < 0)
            { // 클론하여 뒤에 붙임
                $view.css(
                    {
                        'width': moveWidth * (total + roofNum + 1)
                    });

                $.each(item, function(index)
                {
                    if (index < roofNum)
                    {
                        $view.append($(this).clone());
                        $(this).addClass('temp-item');
                    }
                });
            }
            else
            { // 클론하여 앞에 붙임 , margin-left 값을 대입.
                $view.css(
                    {
                        'width': moveWidth * (total + roofNum + 1),
                        'margin-left': -(moveWidth * targetNumber) + defaultMargin + 'px'
                    });
                var j = total - 1;
                for (; j >= 0; j--)
                {
                    // console.log(j)
                    if ((total - 1 - j) < roofNum)
                    {
                        $view.prepend(item.eq(j).clone());
                        item.eq(j).addClass('temp-item');
                    }
                };
                targetNumber = 0;
            }

            $view
                .animate(
                    {
                        'margin-left': moveWidth * targetNumber + defaultMargin
                    },
                    {
                        'duration': 800,
                        'easing': 'easeOutCubic',
                        complete: function()
                        {
                            $view.find('.temp-item').remove()
                                .end().css(
                                {
                                    'width': moveWidth * (total + 1),
                                    'margin-left': defaultMargin
                                });


                            // item = list.find('.banner-item');
                            state.motion = 'stop';
                            if (typeof align === 'string')
                            {
                                state.page = pageChecker(align);
                            }
                            else
                            {
                                state.page = align;
                            }
                            pageController();
                        }
                    });
        }

        setting();
        if (data.length > 4)
        {
            $(window).on('resize', defaultMarginReset)
        }

    }

    vipBannerRoll(vipBannerItem);

    function change_parent_url(url){
        document.location=url;
    }

    //google_gtag
    function google_ga(gtag_event)
    {

        var brand = '['+$("input[name='brand_code']").val() + ']'+$("input[name='brand_name']").val();
        var option_nm = '['+ $("input[name='goods_option_code[]']").val() + ']' + $("input[name='goods_option_name[]']").val();
        var categroy_info = '[' + <?=$goods['CATEGORY_MNG_CD3']?> + ']' + "<?=$goods['CATEGORY_MNG_NM3']?>";
        if(gtag_event == 'view_item'){
            gtag('event', 'view_item', {
                "items": [
                    {
                        "id": $("input[name='goods_code']").val(),
                        "name": $("input[name='goods_name']").val(),
                        "list_name": "view item",
                        "brand": brand,
                        "category": categroy_info,
                        "list_position": 1,
                        "price": $("input[name='goods_selling_price']").val()
                    }
                ]
            });
        }else{
            console.log('add_to_cart');
            gtag('event', 'add_to_cart', {
                "items": [
                    {
                        "id": $("input[name='goods_code']").val(),
                        "name": $("input[name='goods_name']").val(),
                        "list_name": "add cart",
                        "brand": brand,
                        "category": categroy_info,
                        "variant":option_nm,
                        "list_position": 1,
                        "quantity": $("input[name='goods_option_qty[]']").val(),
                        "price": $("input[name='goods_selling_price']").val()
                    }
                ]
            });
        }
    }
</script>
<?if($goods['CATEGORY_MNG_CD2'] == 24010000){?>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a05f67602dc7a0ac2ef1a72c27e5f706&libraries=services"></script>
    <script>
        var mapContainer = document.getElementById('map'), // 지도를 표시할 div
            mapOption = {
                center: new daum.maps.LatLng(37.494940, 127.038061), // 지도의 중심좌표
                level: 3 // 지도의 확대 레벨
            };

        // 지도를 생성합니다
        var map = new daum.maps.Map(mapContainer, mapOption);

        // 주소-좌표 변환 객체를 생성합니다
        var geocoder = new daum.maps.services.Geocoder();

        // 주소로 좌표를 검색합니다
        geocoder.addressSearch('<?=$goods['BRAND_ADDRESS']?>', function(result, status) {

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

                var infowindow = new daum.maps.InfoWindow({
                    content: '<div style="width:250px;text-align:center;padding:6px 0;">' +
                        '<span style="font-weight:600;"><?=$goods['BRAND_NM']?><br/><?=$goods['BRAND_ADDRESS']?></span>' +
                        '</div>'
                });
                infowindow.open(map, marker);

                // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                map.setCenter(coords);

                var path = 'https://map.kakao.com/link/to/<?=$goods['BRAND_ADDRESS']?>' + ','+ x + ',' + y;

                $("#path").attr("href",path);
            }
        });
    </script>
<?}?>
