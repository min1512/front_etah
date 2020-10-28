<link rel="stylesheet" href="/assets/css/display.css?ver=1.3">

<div class="contents contents__nav srp">
    <div class="contents_inner ">
        <div class="location position_area">
            <h2 class="title_page title_page__line">
                검색결과
            </h2>
            <ul class="location_list position_right">
                <li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
                <li class="location_item"><a href="#" class="active">검색결과</a></li>
            </ul>
        </div>

        <p class="srp_result_text">
            <em class="bold">'<?=$keyword?>'</em> 통합 검색결과<em class="bold_yel">(<?=number_format($search_cnt)?>개)</em>

            <?if($search_cnt == 0) {?>
            <div class="srp_result_text prd_none_text">
                <p class="small_text">검색어가 올바르게 입력되었는지 확인해 주세요.</p>
                <div class="prd_none_text_list">
                    <ul class="bullet_list">
                        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>상품명을 모르시면 관련 단어만 입력해 보셔도 좋습니다.</li>
                        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>한글을 영어로 혹은 영어를 한글로 입력했는지 확인해보세요.</li>
                    </ul>
                    <ul class="bullet_list">
                        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>검색어의 띄어쓰기를 조정해 보세요. (예 : 흰컵 → 흰 컵)</li>
                        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>보다 일반적이고 넓은 의미의 단어로 재검색해 보세요.</li>
                    </ul>
                </div>
            </div>
            <?}?>
        </p>



        <?if(!empty($brand)){
            foreach($brand as $brow){
        ?>
                <div class="srp_brand">
                    <a href="/goods/brand/<?=$brow['BRAND_CD']?>?srp=<?=$keyword?>">
                        <img src="http://ui.etah.co.kr/assets/images/display/btn_home.png" alt=""/><em class="bold_yel"><?=$brow['BRAND_NM']?></em> 브랜드관 바로가기
                    </a>
                </div>
        <?
            }
        }?>


        <?if(!empty($tag)){?>
        <div class="srp_keyword_box">
            <div class="srp_keyword">
                <h2 class="title_page title_page__line">
                    <b>연관 태그</b><em class="bold_yel">(<?=number_format(count($tag))?>개)</em>
                    <?foreach($tag as $trow){?>
                        <a href="/goods2/goods_search?keyword=<?=$keyword?>&gb=T&tag_keyword=<?=$trow['TAG_NM']?>" class="tag">#<?=$trow['TAG_NM']?></a>
                    <?}?>
                </h2>
            </div>
        </div>
        <?}?>


        <?if($planEvent_cnt != 0){?>
        <div class="srp_project_box">
            <h2 class="title_page title_page__line">
                <b>기획전</b><em class="bold_yel">(<?=number_format($planEvent_cnt)?>개)</em>
                <p class="srp_ex"><button onclick="$(this).siblings('span').toggle();">?</button><span>‘<?=$keyword?>’의 상품을 포함한 기획전</span></p>
                <span style="float:right;font-size:11pt;"><sub><a href="/goods2/goods_search?keyword=<?=$keyword?>&gb=E" class="btn_more">더보기 <img src="/assets/images/main/ico_arrow.png"></a></sub></span>
            </h2>
            <ul class="srp_project_list">
                <?foreach($planEvent as $erow){?>
                <li><a href="/goods/event/<?=$erow['PLAN_EVENT_CD']?>">
                        <div class="img"><img src="<?=$erow['IMG_URL']?>" alt=""></div>
                        <div class="txt">
                            <div class="txt-inner">
                                <span><?=$erow['TITLE']?></span>
                            </div>
                        </div>
                    </a></li>
                <?}?>
            </ul>
        </div>
        <?}?>

        <?if($goods_cnt != 0){?>
        <div class="basic_goods_list">
            <h2 class="title_page title_page__line">
                <b>상품</b><em class="bold_yel">(<?=number_format($goods_cnt)?>개)</em>
                <span style="float:right;font-size:11pt;"><sub><a href="/goods2/goods_search?keyword=<?=$keyword?>&gb=G" class="btn_more">더보기 <img src="/assets/images/main/ico_arrow.png"></a></sub></span>
            </h2>
            <ul class="goods_list">
                <?foreach($goods as $grow){?>
                    <li class="goods_item">
                        <div class="img">
                            <a href="/goods/detail/<?=$grow['fields']['goods_cd']?>" class="img_link"><img src="<?=$grow['fields']['img_url']?>" alt="<?=$grow['fields']['goods_nm']?>"></a>
                            <div class="tag-wrap">
                                <?@$gPrice = $arr_price[$grow['fields']['goods_cd']]?>
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
                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$grow['fields']['img_url']?>','<?=$grow['fields']['goods_nm']?>');">
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
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$grow['fields']['img_url']?>','<?=$grow['fields']['goods_nm']?>');">
                                                <span class="spr-common spr_share_pinter"></span>
                                                <span class="spr-common spr-bgcircle3"></span>
                                                <span class="button_text">핀터레스트</span>
                                            </button>
                                        </li>
                                        <li class="goods_sns_item">
                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','','<?=$grow['fields']['goods_nm']?>');">
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
                        <a href="/goods/detail/<?=$grow['fields']['goods_cd']?>" class="goods_item_link">
									<span class="brand">
										<?=$grow['fields']['brand_nm']?>
									</span>
                            <span class="name"><?=$grow['fields']['goods_nm']?></span>
                            <span class="price">
                                <?
                                @$gPrice = $arr_price[$grow['fields']['goods_cd']];
                                if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){
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
                <?}?>
                <li class="goods_item last-item">
                    <div class="img">
                        <a href="#" class="img_link"><img src="/assets/images/data/goods_290x290_5.jpg" alt=""></a>
                        <ul class="goods_action_menu">
                            <li class="goods_action_item">
                                <button type="button" class="action_btn">
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
                                        <button type="button" class="action_btn">
                                            <span class="spr-common spr_share_pinter"></span>
                                            <span class="spr-common spr-bgcircle3"></span>
                                            <span class="button_text">핀터레스트</span>
                                        </button>
                                    </li>
                                    <li class="goods_sns_item">
                                        <button type="button" class="action_btn">
                                            <span class="spr-common spr_share_kakao"></span>
                                            <span class="spr-common spr-bgcircle3"></span>
                                            <span class="button_text">카카오스토리</span>
                                        </button>
                                    </li>
                                    <li class="goods_sns_item">
                                        <button type="button" class="action_btn">
                                            <span class="spr-common spr_share_facebook"></span>
                                            <span class="spr-common spr-bgcircle3"></span>
                                            <span class="button_text">페이스북</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <a href="/goods2/goods_search?keyword=<?=$keyword?>&gb=G">
                        <div class="more_bg">
                            <p>검색결과<br>더보기<br>( + )</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <?}?>


        <?if($magazine_cnt != 0){?>
        <div class="srp_magazine_box">
            <h2 class="title_page title_page__line">
                <b>매거진</b><em class="bold_yel">(<?=number_format($magazine_cnt)?>개)</em>
                <span style="float:right;font-size:11pt;"><sub><a href="/goods2/goods_search?keyword=<?=$keyword?>&gb=M" class="btn_more">더보기 <img src="/assets/images/main/ico_arrow.png"></a></sub></span>
            </h2>
            <div class="prd_list">
                <?foreach($magazine as $mrow){?>
                <div class="item">
                    <a href="/magazine/detail/<?=$mrow['MAGAZINE_NO']?>">
                        <div class="img-wrap auto-img">
                            <div class="img">
                                <img src="<?=$mrow['IMG_URL']?>">
                            </div>
                            <div class="layer"></div>
                            <div class="status">
                                <span class="like"><?=$mrow['LOVE']?></span>
                                <span class="share"><?=$mrow['SHARE']?></span>
                                <span class="view">조회 <?=$mrow['HITS']?></span>
                            </div>
                            <?if( isset($mrow['END_DT']) && ($mrow['END_DT']<date("Y-m-d H:i:s")) ){?>
                                <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                    <?
                                    $gb = substr($mrow['CATEGORY_CD'],0,1);

                                    if($gb=='4') echo "<p>SOLD OUT</p>";
                                    if($gb=='9') echo "<p>이벤트 종료</p>";
                                    ?>
                                </div>
                            <?}?>
                        </div>
                        <div class="txt">
                            <p class="cate"><?=$mrow['CATEGORY_NM']?></p>
                            <p class="date"><?=substr($mrow['REG_DT'],0,10)?></p>
                            <p class="sub"><?=$mrow['TITLE']?></p>
                        </div>
                    </a>
                </div>
                <?}?>
            </div>
        </div>
        <?}?>

    </div>
</div>


<script>
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
    }
    //이미지가 모두 로드 된 후 실행
    jQuery.event.add(window,"load",function(){
        calcImgSize();
    });

    //google_gtag
    var viewItem_array = new Object();
    <? $goods_array = array();
    foreach($goods as $key => $grow){
        $goods_array[$key]['id'       ] = $grow['fields']['goods_cd'];
        $goods_array[$key]['name'     ] = $grow['fields']['goods_nm'];
        $goods_array[$key]['list_name'] = 'viewItem_list';
        $goods_array[$key]['brand'] = $grow['fields']['brand_nm'];
        @$gPrice = $arr_price[$grow['fields']['goods_cd']];
        $goods_array[$key]['price'    ] = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
    }
    $goods_array = json_encode($goods_array);?>
    viewItem_array = <?=$goods_array?>;
//    console.log(viewItem_array);
    gtag('event', 'view_item_list', {
        "items": viewItem_array
    });
</script>