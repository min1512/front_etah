<link rel="stylesheet" href="/assets/css/display.css?ver=1.7">

<div class="contents contents__nav srp">

    <div class="contents_inner ">
        <div class="location position_area">
            <h2 class="title_page title_page__line">
                검색결과
            </h2>
            <ul class="location_list position_right">
                <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="/goods2/goods_search?keyword=<?=$keyword?>">검색결과</a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item">
                    <a href="#" class="active">
                        <?
                        switch($gubun){
                            case 'E': echo "기획전";break;
                            case 'M': echo "매거진";break;
                            case 'T': echo "연관태그";break;
                            case 'G': echo "상품";break;
                            default : echo "상세검색";break;
                        }
                        ?>
                    </a>
                </li>
            </ul>
        </div>

        <p class="srp_result_text">
            <a href="/goods2/goods_search?keyword=<?=$keyword?>"><em class="bold">'<?=$keyword?>'</em> 통합 검색결과</a>
        </p>

<?
//기획전 검색결과 상세
if($gubun=='E'){?>
        <div class="srp_project_box">
            <h2 class="title_page title_page__line">
                <b>기획전</b><em class="bold_yel">(<?=number_format($list_cnt)?>개)</em>
            </h2>

            <!-- 카테고리 필터 -->
            <div class="option_button position_area srp_option_area">
                <div class="position_left">
                    <div class="select_wrap select_wrap_cate">
                        <h4 class="srp-cate-tit srp-cate-tit1"><?=($order_by=='B')?'최신순':'인기순'?></h4>
                        <ul id="srp-cate" class="srp-cate1">
                            <li><a href="#none" <?=($order_by=='B')?'class="on"':''?> onclick="javaScript:search_goods('O', 'B');">최신순</a></li>
                            <li><a href="#none" <?=($order_by=='A')?'class="on"':''?> onclick="javaScript:search_goods('O', 'A');">인기순</a></li>
                        </ul>
                    </div>
                    <div class="select_wrap select_wrap_cate">
                        <h4 class="srp-cate-tit srp-cate-tit2"><?=(!empty($cur_category))?$cur_category['CATE_NM2']:'카테고리 전체'?></h4>
                        <ul id="srp-cate" class="srp-cate2">
                            <li><a href="#none" onclick="javaScript:search_goods('C', '')" <?=(empty($cur_category))?'class="on"':''?>>카테고리 전체</a></li>
                            <?foreach($arr_cate1 as $c1){?>
                                <li <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>>
                                    <a href="#none" <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><?=$c1['NAME']?></a>
                                    <ul <?=($cur_category['CATE_CD1']==$c1['CODE'])?'style="display:block;"':''?>>
                                        <?foreach($arr_cate2 as $c2){
                                            if($c2['PARENT_CODE'] == $c1['CODE']){?>
                                            <li><a href="#none" onclick="javaScript:search_goods('C', '<?=$c2['CODE']?>')" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a></li>
                                        <?}
                                        }?>
                                    </ul>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- //카테고리 필터 -->


            <ul class="srp_project_list">
                <?foreach($list as $lt){?>
                <li><a href="/goods/event/<?=$lt['PLAN_EVENT_CD']?>">
                        <div class="img"><img src="<?=$lt['IMG_URL']?>" alt="<?=$lt['TITLE']?>"></div>
                        <div class="txt">
                            <div class="txt-inner">
                                <span><?=$lt['TITLE']?></span>
                            </div>
                        </div>
                    </a></li>
                <?}?>
            </ul>
        </div>
<?
//매거진 검색결과 상세
}else if($gubun=='M'){?>
        <div class="srp_magazine_box">
            <h2 class="title_page title_page__line">
                <b>매거진</b><em class="bold_yel">(<?=number_format($list_cnt)?>개)</em>
            </h2>

            <!-- 카테고리 필터 -->
            <div class="option_button position_area srp_option_area">
                <div class="position_left">
                    <div class="select_wrap select_wrap_cate">
                        <h4 class="srp-cate-tit srp-cate-tit1"><?=($order_by=='B')?'최신순':'인기순'?></h4>
                        <ul id="srp-cate" class="srp-cate1">
                            <li><a href="#none" <?=($order_by=='B')?'class="on"':''?> onclick="javaScript:search_goods('O', 'B');">최신순</a></li>
                            <li><a href="#none" <?=($order_by=='A')?'class="on"':''?> onclick="javaScript:search_goods('O', 'A');">인기순</a></li>
                        </ul>
                    </div>
                    <div class="select_wrap select_wrap_cate">
                        <h4 class="srp-cate-tit srp-cate-tit2"><?=(!empty($cur_category))?$cur_category['CATE_NM2']:'카테고리 전체'?></h4>
                        <ul id="srp-cate" class="srp-cate2">
                            <li><a href="#none" onclick="javaScript:search_goods('C', '')" <?=(empty($cur_category))?'class="on"':''?>>카테고리 전체</a></li>
                            <?foreach($arr_cate1 as $c1){?>
                                <li <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>>
                                    <a href="#none" <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><?=$c1['NAME']?></a>
                                    <ul <?=($cur_category['CATE_CD1']==$c1['CODE'])?'style="display:block;"':''?>>
                                        <?foreach($arr_cate2 as $c2){
                                            if($c2['PARENT_CODE'] == $c1['CODE']){?>
                                                <li><a href="#none" onclick="javaScript:search_goods('C', '<?=$c2['CODE']?>')" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a></li>
                                            <?}
                                        }?>
                                    </ul>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- //카테고리 필터 -->


            <div class="prd_list">
                <?foreach($list as $lt){?>
                    <div class="item">
                        <a href="/magazine/detail/<?=$lt['MAGAZINE_NO']?>">
                            <div class="img-wrap auto-img">
                                <div class="img">
                                    <img src="<?=$lt['IMG_URL']?>">
                                </div>
                                <div class="layer"></div>
                                <div class="status">
                                    <span class="like"><?=$lt['LOVE']?></span>
                                    <span class="share"><?=$lt['SHARE']?></span>
                                    <span class="view">조회 <?=$lt['HITS']?></span>
                                </div>
                                <?if( isset($lt['END_DT']) && ($lt['END_DT']<date("Y-m-d H:i:s")) ){?>
                                    <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                        <?
                                        $gb = substr($lt['CATEGORY_CD'],0,1);

                                        if($gb=='4') echo "<p>SOLD OUT</p>";
                                        if($gb=='9') echo "<p>이벤트 종료</p>";
                                        ?>
                                    </div>
                                <?}?>
                            </div>
                            <div class="txt">
                                <p class="cate"><?=$lt['CATEGORY_NM']?></p>
                                <p class="date"><?=substr($lt['REG_DT'],0,10)?></p>
                                <p class="sub"><?=$lt['TITLE']?></p>
                            </div>
                        </a>
                    </div>
                <?}?>
            </div>
        </div>
<?
//상품 검색결과 상세
}else if( ($gubun=='G') || ($gubun=='T') ){ ?>
        <div class="brand_check srp_b">
            <h3 class="brand_check_title">브랜드</h3>
            <ul class="brand_check_list">
                <?
                $srp_brand = explode("|", substr($brand,1));

                $i = 0;
                foreach ($arr_brand as $key => $value) {
                    ?>
                    <li class="checkbox_area">
                        <input type="checkbox" class="checkbox" id="formBrandCheck<?= $i ?>" value="<?= $key ?>" name="search_brand" <?=in_array($key,$srp_brand)?'checked':''?>>
                        <label class="checkbox_label" for="formBrandCheck<?= $i ?>"><?= $value['NM'] ?> <span class="num">(<?= $value['CNT'] ?>)</span></label>
                    </li>
                    <? $i++;
                } ?>
            </ul>
            <button type="button" class="brand_check_btn" data-ui="toggle-class" data-target=".brand_check" data-class="active"><span class="spr-common spr_btn_more"></span></button>
        </div>
        <div class="confirm-btn">
            <button type="button" onclick="javaScript:search_goods('B', '');">확인</button>
        </div>


        <div class="basic_goods_list">
            <h2 class="title_page title_page__line">
                <b><?= ($gubun == 'G') ? '상품' : '#' . $tag_keyword ?></b><em
                        class="bold_yel">(<?= number_format($list_cnt) ?>개)</em>
            </h2>

            <!-- 카테고리 필터 -->
            <div class="option_button position_area srp_option_area">
                <div class="position_left">
                    <div class="select_wrap select_wrap_cate">
                        <h4 class="srp-cate-tit srp-cate-tit1">
                            <?
                            switch ($order_by) {
                                case 'A':echo '인기순';break;
                                case 'B':echo '신상품순';break;
                                case 'C':echo '낮은가격순';break;
                                case 'D':echo '높은가격순';break;
                                default :echo '인기순';break;
                            } ?>
                        </h4>
                        <ul id="srp-cate" class="srp-cate1">
                            <li><a href="#none" <?= ($order_by == 'B') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'B');">신상품순</a></li>
                            <li><a href="#none" <?= ($order_by == 'A') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'A');">인기순</a></li>
                            <li><a href="#none" <?= ($order_by == 'C') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'C');">낮은가격순</a></li>
                            <li><a href="#none" <?= ($order_by == 'D') ? 'class="on"' : '' ?> onclick="javaScript:search_goods('O', 'D');">높은가격순</a></li>
                        </ul>
                    </div>
                    <div class="select_wrap select_wrap_cate">
                        <h4 class="srp-cate-tit srp-cate-tit2"><?=(!empty($cur_category))?$cur_category['CATE_NM3']:'카테고리 전체'?></h4>
                        <ul id="srp-cate" class="srp-cate2">
                            <?
                            foreach ($arr_cate1 as $c1) { ?>
                                <li <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><a href="#none"><?= $c1['NAME'] ?></a>
                                    <ul <?=($cur_category['CATE_CD1']==$c1['CODE'])?'style="display:block;"':''?>>
                                        <?
                                        foreach ($arr_cate2 as $c2) {
                                            if ($c2['PARENT_CODE'] == $c1['CODE']) { ?>
                                                <li <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><a href="#none"><?= $c2['NAME'] ?></a>
                                                    <ul <?=($cur_category['CATE_CD2']==$c2['CODE'])?'style="display:block;"':''?>>
                                                        <?
                                                        foreach ($arr_cate3 as $c3) {
                                                            if ($c3['PARENT_CODE'] == $c2['CODE']) {
                                                                ?>
                                                                <li><a href="#none" onclick="javaScript:search_goods('C', '<?= $c3['CODE'] ?>');"  <?=($cur_category['CATE_CD3']==$c3['CODE'])?'class="on"':''?>><?= $c3['NAME'] ?></a></li>
                                                            <?
                                                            }
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
<!--                                        <input type="checkbox" checked="" onchange="T.toggleToobarStatus()" value="1"-->
<!--                                               name="status" class="input-checkbox" id="toolbar-active" onclick="search_goods('D','');">-->
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
                                        <?$range = '|'.(string)$price_min?>
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
                <?foreach($list as $lt){
                    @$gPrice = $arr_price[$lt['fields']['goods_cd']];

                    //가격데이터 있는것만 표시
                    if(!empty($gPrice)) {?>
                        <li class="goods_item">
                            <div class="img">
                                <a href="/goods/detail/<?=$lt['fields']['goods_cd']?>" class="img_link"><img src="<?=$lt['fields']['img_url']?>" alt="<?=$lt['fields']['goods_nm']?>"></a>
                                <div class="tag-wrap">
                                    <?if(isset($gPrice['DEAL'])){?>
                                        <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                    <?}?>
                                    <?if($gPrice['GONGBANG']=='G'){?>
                                        <!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>-->
                                    <?}else if($gPrice['GONGBANG']=='C'){?>
                                        <!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>-->
                                    <?}?>
                                </div>
                                <ul class="goods_action_menu">
                                    <li class="goods_action_item">
                                        <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$lt['fields']['goods_cd']?>','','');">
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
                                                <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$lt['fields']['img_url']?>','<?=$lt['fields']['goods_nm']?>');">
                                                    <span class="spr-common spr_share_pinter"></span>
                                                    <span class="spr-common spr-bgcircle3"></span>
                                                    <span class="button_text">핀터레스트</span>
                                                </button>
                                            </li>
                                            <li class="goods_sns_item">
                                                <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','','<?=$lt['fields']['goods_nm']?>');">
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
                            <a href="/goods/detail/<?=$lt['fields']['goods_cd']?>" class="goods_item_link">
                                <span class="brand"><?=$lt['fields']['brand_nm']?></span>
                                <span class="name"><?=$lt['fields']['goods_nm']?></span>
                                <span class="price">
                                    <?if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){
                                        $price = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
                                        echo number_format($price);

                                        $sale_percent = (($gPrice['SELLING_PRICE'] - $price)/$gPrice['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <span class="dc_price">
                                        <s class="del_price"><?=number_format($gPrice['SELLING_PRICE'])?></s> (<?=floor((($gPrice['SELLING_PRICE']-$price)/$gPrice['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                    </span>
                                    <?}else{
                                        echo number_format($price = $gPrice['SELLING_PRICE']);
                                    } ?>
                                </span>
                                <span class="icon_block">
                                        <? if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){
                                            ?>
                                            <span class="spr-common spr_ico_coupon"></span>
                                            <?
                                        }
                                        if($gPrice['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                            ?>
                                            <span class="spr-common spr_ico_mileage"></span>
                                        <?}
                                        if(($gPrice['PATTERN_TYPE_CD'] == 'FREE') || ( $gPrice['DELI_LIMIT'] > 0 && $price > $gPrice['DELI_LIMIT'])){
                                            ?>
                                            <span class="spr-common spr_ico_free_shipping"></span>
                                        <?}?>
                                </span>
                            </a>
                        </li>
                    <?}
                }?>
            </ul>
        </div>
<?}?>

        <?=$pagination?>

    </div>
</div>

<!--<script src="/assets/js/common.js"></script>-->
<script type="text/javascript">
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

<script type="text/javascript">
    //====================================
    // 조건별 검색
    //====================================
    function search_goods(kind, val){
        var keyword     = '<?=$keyword?>';
        var gb          = '<?=$gubun?>';
        var tag_keyword = '<?=$tag_keyword?>';

        var brand       = '<?=$brand?>';
        var order_by    = '<?=$order_by?>';
        var category    = '<?=$category?>';
        var deliv_type  = '<?=$deliv_type?>';
        var country     = '<?=$country?>';
        var price_limit = '<?=$price_limit?>';

        //브랜드
        if(kind=='B') {
            $("input[name=search_brand]:checked").each(function() {
                val += '|'+$(this).val();
            });

            brand = val;
        }

        //정렬
        if(kind=='O') {
            order_by = val;
        }

        //카테고리
        if(kind=='C') {
            category = val;
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

        document.location.href = "/goods2/goods_search?keyword="+keyword+"&gb="+gb+"&tag_keyword="+tag_keyword+"&brand="+brand+"&order_by="+order_by+"&category="+category+"&deliv_type="+deliv_type+"&country="+country+"&price_limit="+price_limit;
    }
</script>

<script type="text/javascript">
    //google_gtag
    <?if($gubun=='E'){
    $event_list = array();
    foreach($list as $key=> $lt){
        $event_list[$key]['id'] = $lt['PLAN_EVENT_CD'];
        $event_list[$key]['name'] = 'ETAH - promotion';
    }
    $event_list = json_encode($event_list);
    ?>
    var viewEvent_array = new Object();
    viewEvent_array = <?=$event_list?>;
    //    console.log(viewEvent_array);

    gtag('event', 'view_promotion', {
        "promotions": viewEvent_array
    });
    <?}else if($gubun=='M'){
    $magazine_list = array();
    foreach($list as $key=> $lt){
        $magazine_list[$key]['id'] = $lt['MAGAZINE_NO'];
        $magazine_list[$key]['name'] = 'ETAH - MAGAZINE';
    }
    $magazine_list = json_encode($magazine_list);
    ?>
    var viewMagazine_array = new Object();
    viewMagazine_array = <?=$magazine_list?>;
    //    console.log(viewMagazine_array);

    gtag('event', 'view_magazine', {
        "promotions": viewMagazine_array
    });
    <?}
    else if( ($gubun=='G') || ($gubun=='T') ){?>
    var viewItem_array = new Object();
    <? $goods_array = array();
    foreach($list as $key => $grow){
        $goods_array[$key]['id'       ] = $grow['fields']['goods_cd'];
        $goods_array[$key]['name'     ] = $grow['fields']['goods_nm'];
        $goods_array[$key]['list_name'] = 'viewItem_list';
        $goods_array[$key]['brand'] = $grow['fields']['brand_nm'];
        @$gPrice = $arr_price[$grow['fields']['goods_cd']];
        $goods_array[$key]['price'    ] = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
    }
    $goods_array = json_encode($goods_array);?>
    viewItem_array = <?=$goods_array?>;
    //        console.log(viewItem_array);
    gtag('event', 'view_item_list', {
        "items": viewItem_array
    });
    <?}?>
</script>