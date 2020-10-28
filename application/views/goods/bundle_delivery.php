			<link rel="stylesheet" href="/assets/css/display.css?ver=1">

			<div class="contents lp_bundle_delivery">
				<!-- 최근본상품 // -->
				<div class="lately_prd_box">
					<div class="lately_prd_inner">
						<h3 class="lately_prd_title">최근 본 상품</h3>
						<a href="/goods/detail/<?=$goods['GOODS_CD']?>" class="lately_prd_link">
							<span class="lately_prd_img"><img src="<?=$goods['IMG_URL']?>" alt="" width=92 height=92 /></span>
							<span class="lately_prd_info">
								<span class="brand"><?=$goods['BRAND_NM']?></span>
							<span class="name"><?=$goods['GOODS_NM']?></span>
							</span>
						</a>
						<ul class="lately_prd_price">
							<li class="lately_prd_price_item">
								<span class="title">가격</span>:
								<strong class="price bold"><?=number_format($goods['SELLING_PRICE'])?></strong>
							</li>
							<li class="lately_prd_price_item">
								<span class="title">할인금액</span>:
								<span class="price"><?=number_format($goods['COUPON_AMT'])?></span>
							</li>

							<li class="lately_prd_price_item">
								<span class="title">배송비</span>:
								<span class="price"><?=number_format($goods['DELI_COST'])?></span>
							</li>
						</ul>
					</div>
					<p class="lately_prd_text">최근 보신 상품 및 아래 상품들을 <strong class="bold"><?=number_format($goods['DELI_LIMIT'])?>원</strong> 이상 장바구니에 담으실 경우 무료배송이 가능합니다.</p>
				</div>
				<!-- // 최근본상품 -->

                <!-- 카테고리 필터 -->
                <div class="option_button position_area srp_option_area col4">
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

				<div class="basic_goods_list">
					<ul class="goods_list">
						<? foreach($goodsList as $row){	?>
						<li class="goods_item">
							<div class="img">
								<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="img_link"><img src="<?=$row['IMG_URL']?>" alt=""></a>
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
												<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
													<span class="spr-common spr_share_pinter"></span>
													<span class="spr-common spr-bgcircle3"></span>
													<span class="button_text">핀터레스트</span>
												</button>
											</li>
											<li class="goods_sns_item">
												<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','','<?=$row['GOODS_NM']?>');">
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
							<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="goods_item_link">
								<span class="brand">
									<?=$row['BRAND_NM']?>
								</span>
								<span class="name"><?=$row['GOODS_NM']?></span>
								<span class="price">
									<?
									if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
//											$price = $row['SELLING_PRICE'] - $row['RATE_PRICE'] - $row['AMT_PRICE'];
										$price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
										echo number_format($price);

										/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
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
						<? }?>
					</ul>
				</div>
				<?=$pagination?>
			</div>

			<script type="text/javaScript">

			//====================================
			// 조건별 검색
			//====================================
			function search_goods(kind, val)
			{
				var limit			= "<?=$limit?>";
				var page			= "<?=$page?>";
				var	deli_policy_no	= "<?=$deli_policy_no?>";
				var goods_code		= "<?=$goods_code?>";
                var cate_gb         = '<?=$cate_gb?>';

                var cate_cd     = '<?=$cate_cd?>';
                var order_by    = '<?=$order_by?>';
                var deliv_type  = '<?=$deliv_type?>';
                var country     = '<?=$country?>';
                var price_limit = '<?=$price_limit?>';

                //정렬
                if(kind=='O') {
                    order_by = val;
                    page	 = 1;
                }

                //카테고리
                if(kind=='C') {
                    cate_cd = val;
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

                document.location.href = "/goods/bundle_delivery_page/"+page+"?&goods_code="+goods_code+"&limit_num_rows="+limit+"&page="+page+"&deli_policy_no="+deli_policy_no+"&order_by="+order_by+"&cate_gb="+cate_gb+"&cate_cd="+cate_cd+"&deliv_type="+deliv_type+"&country="+country+"&price_limit="+price_limit;

			}
			</script>