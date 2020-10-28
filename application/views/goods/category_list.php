<link rel="stylesheet" href="/assets/css/display.css?ver=1.2">

<div class="contents contents__nav lp <?=$type?>">
    <div class="nav" id="nav">
        <h1 class="nav_title"><?=$category['CATE_NAME1']?></h1>
        <ul class="nav_list">
            <?for($a=0; $a<count($nav['CATEGORY_CD1']); $a++){?>
                <li class="nav_item<?=$nav['CATEGORY_CD1'][$a] == $category['CATE_CODE2'] ? " active" : ""?>">
                    <a href="/goods/mid_list/<?=$nav['CATEGORY_CD1'][$a]?>" class="nav_link"><?=$nav['CATEGORY_NM1'][$a]?></a>
                    <ul class="nav_list_2depth">
                        <?for($b=0; $b<count($nav['CATEGORY_CD2'][$a]); $b++){?>
                            <li><a href="/goods/list/<?=$nav['CATEGORY_CD2'][$a][$b]?>" <?=$nav['CATEGORY_CD2'][$a][$b] == $category['CATE_CODE3'] && $cate_gb == 'S' ? "class='active'" : ""?>><?=$nav['CATEGORY_NM2'][$a][$b]?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?}?>
        </ul>
    </div>

    <div class="contents_inner ">
        <div class="location position_area">
            <h2 class="title_page title_page__line">
                <?=$category['CATE_TITLE']?>
            </h2>
            <?if($cate_gb == 'S'){?><!--소분류 카테고리 리스트-->
            <ul class="location_list position_right">
                <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="/category/main/<?=$category['CATE_CODE1']?>"><?=$category['CATE_NAME1']?></a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="/goods/mid_list/<?=$category['CATE_CODE2']?>"><?=$category['CATE_NAME2']?></a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="goods/list/<?=$category['CATE_NAME3']?>" class="active"><?=$category['CATE_NAME3']?></a></li>
            </ul>
            <?}else if($cate_gb == 'M'){?><!--중분류 카테고리 리스트-->
            <ul class="location_list position_right">
                <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="/category/main/<?=$category['CATE_CODE1']?>"><?=$category['CATE_NAME1']?></a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="/goods/mid_list/<?=$category['CATE_CODE2']?>" class="active"><?=$category['CATE_NAME2']?></a></li>
            </ul>
            <?}?>
        </div>

        <?
        if($category_list){    //중카테고리 페이지
            $idx=1; ?>
            <ul class="option_select option_select__category">
                <li class="option_select_item">
                    <span class="option_select_title"><?=$category['CATE_TITLE']?></span>
                    <ul class="option_select_list">
                        <?foreach($category_list as $crow){?>
                            <li class="checkbox_area">
                                <input type="checkbox" class="checkbox" id="formOptionCheck010<?=$idx?>" onClick="javaScript:search_goods('C','<?=$idx?>');" name="chkCate[]" value="<?=$crow['CATEGORY_DISP_CD']?>">
                                <label class="checkbox_label" for="formOptionCheck010<?=$idx?>"><?=$crow['CATEGORY_DISP_NM']?></label>
                            </li>
                            <?$idx++;
                        }?>
                    </ul>
                </li>
            </ul>
        <?}?>

        <?
        $attr_nm = "";
        $i=1;
        if($category_attr){ //소카테고리 페이지
            ?>
            <ul class="option_select">
            <?	foreach($category_attr as $attr){
                if(($attr_nm != "")&&($attr_nm != $attr['ATTR_NAME1'])){
                    $i++;?>
                    </ul>
                    </li>
                    <?
                }
                if($attr_nm != $attr['ATTR_NAME1']){
                    $idx =1;
                    ?>
                    <li class="option_select_item">
                    <span class="option_select_title"><?=$attr['ATTR_NAME1']?></span>
                    <ul class="option_select_list">
                    <li class="checkbox_area">
                        <input type="checkbox" class="checkbox" id="formOptionCheck0<?=$i?>0<?=$idx?>" onClick="javaScript:search_goods('A','<?=$i?>');" name="chkAttr[]" value="<?=$attr['ATTR_CODE2']?>">
                        <label class="checkbox_label" for="formOptionCheck0<?=$i?>0<?=$idx?>"><?=$attr['ATTR_NAME2']?></label>
                    </li>
                    <?		$idx++;
                }else{?>
                    <li class="checkbox_area">
                        <input type="checkbox" class="checkbox" id="formOptionCheck0<?=$i?>0<?=$idx?>" onClick="javaScript:search_goods('A','<?=$i?>');" name="chkAttr[]" value="<?=$attr['ATTR_CODE2']?>">
                        <label class="checkbox_label" for="formOptionCheck0<?=$i?>0<?=$idx?>"><?=$attr['ATTR_NAME2']?></label>
                    </li>
                    <?		$idx++;
                }
                $attr_nm = $attr['ATTR_NAME1'];

            }?>
            </ul>
            </li>
            </ul>
        <?}?>


        <div class="brand_check brand_check_data">
            <h3 class="brand_check_title">브랜드</h3>
            <ul class="brand_check_list">
                <?
                $idx=1;
                foreach($brand_cnt as $brow){?>
                    <li class="checkbox_area">
                        <input type="checkbox" class="checkbox" id="formBrandCheck0<?=$idx?>" value="<?=$brow['BRAND_CD']?>" name="chkBrand[]" <?=$brow['FLAG_YN'] == 'N' ? "" : "checked"?>>
                        <label class="checkbox_label" for="formBrandCheck0<?=$idx?>"><?=$brow['BRAND_NM']?> <span class="num">(<?=$brow['GOODS_CNT']?>)</span></label>
                    </li>
                    <?
                    $idx++;
                }?>
            </ul>
            <button type="button" class="brand_check_btn" data-ui="toggle-class" data-target=".brand_check_data" data-class="active"><span class="spr-common spr_btn_more"></span></button>
        </div>
        <div class="confirm-btn">
            <button type="button" onclick="javaScript:search_goods('B', '');">확인</button>
        </div>

        <?
        //공방클래스 위치
        if($category['CATE_CODE2'] == 24010000){?>
            <div class="brand_check map_check_data">
                <h3 class="brand_check_title">위치</h3>
                <ul class="brand_check_list">
                    <?
                    $idx=1;
                    foreach($map_cnt as $mrow){?>
                        <li class="checkbox_area">
                            <input type="checkbox" class="checkbox" id="formMapCheck0<?=$idx?>" value="<?=$mrow['MAP']?>" name="chkMap[]" <?=$mrow['FLAG_YN'] == 'N' ? "" : "checked"?>>
                            <label class="checkbox_label" for="formMapCheck0<?=$idx?>"><?=$mrow['MAP']?> <span class="num">(<?=$mrow['MAP_CNT']?>)</span></label>
                        </li>
                        <?
                        $idx++;
                    }?>
                </ul>
                <button type="button" class="brand_check_btn" data-ui="toggle-class" data-target=".map_check_data" data-class="active"><span class="spr-common spr_btn_more"></span></button>
            </div>
            <div class="confirm-btn">
                <button type="button" onclick="javaScript:search_goods('M', '');">확인</button>
            </div>
        <?}?>

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

        <div class="basic_goods_list">
            <ul class="goods_list">
                <?foreach($goods as $grow){?>
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

        <?=$pagination?>
    </div>
</div>


<script type="text/javascript">
    check_attr();
    check_cate();

    //====================================
    // 하위속성 체크
    //====================================
    function check_attr()
    {
        var attr_cd = "<?=$attr_cd?>",
            attr = document.getElementsByName("chkAttr[]");

        arr_attr = attr_cd.split("|");
        for( j=0; j<arr_attr.length; j++){
            for( i=0; i<attr.length; i++){
                if(document.getElementsByName("chkAttr[]")[i].value == arr_attr[j+1]){

                    document.getElementsByName("chkAttr[]")[i].checked = true;
                }
            }
        }
    }

    //====================================
    // 카테고리 체크
    //====================================
    function check_cate()
    {
        var cate_cd = "<?=$arr_cate?>",
            cate = document.getElementsByName("chkCate[]");

        arr_cate = cate_cd.split("|");
        for( j=0; j<arr_cate.length; j++){
            for( i=0; i<cate.length; i++){
                if(document.getElementsByName("chkCate[]")[i].value == arr_cate[j+1]){

                    document.getElementsByName("chkCate[]")[i].checked = true;
                }
            }
        }
    }

    //====================================
    // 조건별 검색
    //====================================
    function search_goods(kind, val)
    {
        var limit		= "<?=$limit?>";
        var page		= "<?=$page?>";
        var url			= "<?=$url?>";

        var cate_gb		= "<?=$cate_gb?>";
        var cate_cd		= "<?=$cate_cd?>";
        var arr_cate	= "<?=$arr_cate?>";
        var attr		= "<?=$attr_cd?>";
        var brand_cd	= "<?=$brand_cd?>";
        var map_nm      = "<?=$map_nm?>";
        var order_by    = '<?=$order_by?>';
        var deliv_type  = '<?=$deliv_type?>';
        var country     = '<?=$country?>';
        var price_limit = '<?=$price_limit?>';


        //소분류 카테고리 검색
        if(kind == 'C'){
            var chk_cate = document.getElementsByName("chkCate[]");
            arr_cate = "";
            for( i=0; i<chk_cate.length; i++){
                if(document.getElementsByName("chkCate[]")[i].checked == true){
                    arr_cate += "|"+document.getElementsByName("chkCate[]")[i].value;
                }
            }
            page = 1;
        }

        //카테고리 속성검색
        if(kind == 'A'){
            var chk_attr = document.getElementsByName("chkAttr[]");
            attr = "";
            for( i=0; i<chk_attr.length; i++){
                if(document.getElementsByName("chkAttr[]")[i].checked == true){
                    attr += "|"+document.getElementsByName("chkAttr[]")[i].value;
                }
            }
            page = 1;
        }

        //브랜드
        if(kind == 'B'){
            var b_cnt = "<?=count($brand_cnt)?>";
            brand_cd = "";
            for( i=0; i<b_cnt; i++){
                if(document.getElementById("formBrandCheck0"+(i+1)).checked == true){
                    brand_cd += "|"+document.getElementsByName("chkBrand[]")[i].value;
                }
            }
            page = 1;
        }

        //지역(공방클래스)
        if(kind == 'M'){
            var m_cnt = "<?=count($map_cnt)?>";
            map_nm = "";
            for( i=0; i<m_cnt; i++){
                if(document.getElementById("formMapCheck0"+(i+1)).checked == true){
                    map_nm += "|"+document.getElementsByName("chkMap[]")[i].value;
                }
            }
            page = 1;
        }

        //정렬
        if(kind=='O') {
            order_by = val;
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

        document.location.href = "/goods/"+url+"/"+page+"?limit_num_rows="+limit+"&page="+page+"&cate_gb="+cate_gb+"&cate_cd="+cate_cd+"&arr_cate="+arr_cate+"&attr="+attr+"&brand_cd="+brand_cd+"&map_nm="+map_nm+"&order_by="+order_by+"&deliv_type="+deliv_type+"&country="+country+"&price_limit="+price_limit;
    }
</script>

<!--GA script-->
<script>
    //Impression
    //            ga('require', 'ecommerce', 'ecommerce.js');
    //            <?//foreach ($goods as $grow){?>
    //            ga('ecommerce:addImpression', {
    //                'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
    //                'name': "<?//=$grow['GOODS_NM']?>//",
    //                'category': <?//=$cate_cd?>//,
    //                'brand': '<?//=$grow['BRAND_NM']?>//',
    //                'list': 'Goods Results'
    //            });
    //            <?//}?>
    //            ga('ecommerce:send');
    //
    //            //action
    //            function onProductClick(param,param2) {
    //                var goods_cd = param;
    //                var goods_nm = param2;
    //                ga('ecommerce:addProduct', {
    //                    'id': goods_cd,
    //                    'name': goods_nm
    //                });
    //                ga('ecommerce:setAction', 'click', {list: 'Goods Results'});
    //
    //                // Send click with an event, then send user to product page.
    //                ga('send', 'event', 'UX', 'click', 'Results', {
    //                    hitCallback: function() {
    //                        //alert(goods_cd + '/' + goods_nm);
    //                        document.location = '/goods/detail/'+goods_cd;
    //                    }
    //                });
    //            }
</script>
<!--/GA script-->