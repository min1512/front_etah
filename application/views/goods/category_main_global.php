			<link rel="stylesheet" href="/assets/css/display.css?ver=1.1">

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
                        <h2 class="title_page title_page__line">
                            직구SHOP
                        </h2>
						<ul class="location_list position_right">
							<li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
							<li class="location_item"><a href="/category/main/<?=$category['CATE_CODE3']?>" class="active"><?=$category['CATE_NAME3']?></a></li>
						</ul>
					</div>

                    <?
                    if($category_list){
                        $idx=1; ?>
                        <ul class="option_select option_select__category">
                            <li class="option_select_item">
                                <span class="option_select_title"><?=$category['CATE_TITLE']?></span>
                                <ul class="option_select_list">
                                    <?
                                    $setArray = array_filter(explode('|', $arr_cate));
                                    foreach($category_list as $crow){?>
                                        <li class="checkbox_area">
                                            <input type="checkbox" class="checkbox" id="formOptionCheck010<?=$idx?>" onClick="javaScript:search_goods('C','<?=$idx?>');" name="chkCate[]" value="<?=$crow['CATEGORY_DISP_CD']?>" <?=(in_array($crow['CATEGORY_DISP_CD'],$setArray)?'checked':'')?>>
                                            <label class="checkbox_label" for="formOptionCheck010<?=$idx?>"><?=$crow['CATEGORY_DISP_NM']?></label>
                                        </li>
                                        <?$idx++;
                                    }?>
                                </ul>
                            </li>
                        </ul>
                    <?}?>

                    <div class="brand_check brand_chk">
                        <h3 class="brand_check_title">브랜드</h3>
                        <ul class="brand_check_list">
                            <?
                            $idx=1;
                            foreach($brand_cnt as $brow){?>
                                <li class="checkbox_area">
                                    <input type="checkbox" class="checkbox" id="formBrandCheck0<?=$idx?>" onClick="javaScript:search_goods('B','')" value="<?=$brow['BRAND_CD']?>" name="chkBrand[]" <?=$brow['FLAG_YN'] == 'N' ? "" : "checked"?>>
                                    <label class="checkbox_label" for="formBrandCheck0<?=$idx?>"><?=$brow['BRAND_NM']?> <span class="num">(<?=$brow['GOODS_CNT']?>)</span></label>
                                </li>
                                <?
                                $idx++;
                            }?>
                        </ul>
                        <button type="button" class="brand_check_btn" data-ui="toggle-class" data-target=".brand_chk" data-class="active"><span class="spr-common spr_btn_more"></span></button>
                    </div>

                    <div class="option_button position_area">
                        <ul class="button_list">
                            <li class="button_item"><a href="javaScript:search_goods('P','');" class="button_basic<?=$price_limit == '' ? " active" : ""?>">전체</a></li>
                            <!-- 활성화시 클래스 active 추가 -->
                            <li class="button_item"><a href="javaScript:search_goods('P',3);" class="button_basic<?=$price_limit == '3' ? " active" : ""?>">3만원 이하</a></li>
                            <li class="button_item"><a href="javaScript:search_goods('P',5);" class="button_basic<?=$price_limit == '5' ? " active" : ""?>">5만원 이하</a></li>
                            <li class="button_item"><a href="javaScript:search_goods('P',10);" class="button_basic<?=$price_limit == '10' ? " active" : ""?>">10만원 이하</a></li>
                            <li class="button_item"><a href="javaScript:search_goods('P',30);" class="button_basic<?=$price_limit == '30' ? " active" : ""?>">30만원 이하</a></li>
                            <li class="button_item"><a href="javaScript:search_goods('P',50);" class="button_basic<?=$price_limit == '50' ? " active" : ""?>">30만원 이상</a></li>
                        </ul>
                        <div class="position_right">
                            <ul class="button_list">
                                <li class="button_item"><a href="javaScript:search_goods('L',40);" class="button_basic<?=$limit == '40' ? " active" : ""?>">40개</a></li>
                                <!-- 활성화시 클래스 active 추가 -->
                                <li class="button_item"><a href="javaScript:search_goods('L',80);" class="button_basic<?=$limit == '80' ? " active" : ""?>">80개</a></li>
                                <li class="button_item"><a href="javaScript:search_goods('L',120);" class="button_basic<?=$limit == '120' ? " active" : ""?>">120개</a></li>
                            </ul>
                            <div class="select_wrap">
                                <label for="formMailSelect">인기순</label>
                                <select id="formMailSelect" onChange="javaScript:search_goods('O',this.value);">
                                    <option value="A" <?=$order_by == 'A' ? "selected" : ""?>>신상품순</option>
                                    <option value="B" <?=$order_by == 'B' ? "selected" : ""?>>인기순</option>
                                    <option value="C" <?=$order_by == 'C' ? "selected" : ""?>>낮은가격순</option>
                                    <option value="D" <?=$order_by == 'D' ? "selected" : ""?>>높은가격순</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="basic_goods_list">
                        <ul class="goods_list">
                            <?foreach($goods as $grow){?>
                                <li class="goods_item">
                                    <div class="img">
                                        <a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="img_link"><img src="<?=$grow['IMG_URL']?>" alt=""></a>
                                        <div class="tag-wrap">
                                            <?if(!empty($grow['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                            <?if($grow['CLASS_GUBUN'] == 'C'){?><!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
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

			</div>


            <script src="/assets/js/common.js"></script>
            <script type="text/javascript">
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

            <script type="text/javascript">
                function search_goods(kind, val) {
                    var limit		= "<?=$limit?>";
                    var brand_cd = '<?=$brand_cd?>';
                    var arr_cate = '<?=$arr_cate?>';
                    var price_limit = "<?=$price_limit?>";
                    var order_by	= "<?=$order_by?>";

                    //싱품 디스플레이 개수 변경
                    if(kind == 'L'){
                        limit = val;
                    }

                    //싱품 가격 제한
                    if(kind == 'P'){
                        price_limit = val;
                    }

                    //상품 정렬 변경
                    if(kind == 'O'){
                        order_by = val;
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
                    }

                    //소분류 카테고리 검색
                    if(kind == 'C'){
                        var chk_cate = document.getElementsByName("chkCate[]");
                        arr_cate = "";
                        for( i=0; i<chk_cate.length; i++){
                            if(document.getElementsByName("chkCate[]")[i].checked == true){
                                arr_cate += "|"+document.getElementsByName("chkCate[]")[i].value;
                            }
                        }
                    }

                    var param = "";
                    param += "kind="			+ kind;
                    param += "&price_limit="	+ price_limit;
                    param += "&limit_num_rows="	+ limit;
                    param += "&brand_cd="		+ brand_cd;
                    param += "&arr_cate="		+ arr_cate;
                    param += "&order_by="		+ order_by;

                    document.location.href = "/category/main/20000000?"+param;
                }
            </script>