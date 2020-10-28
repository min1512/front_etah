<link rel="stylesheet" href="/assets/css/display.css?ver=1.0">
			<div class="contents contents__nav srp">

				<div class="nav" id="nav">
					<h1 class="nav_title">카테고리</h1>
                    <ul>
                        <li class="nav_item<?=!$cate_cd ? " active" : ""?>">
                             <a href="#" onClick="javaScript:search_goods('C','');" class="nav_link">전체
                                 <?if($search_cnt < 10000){?>
                                     <span class="num">(<?=number_format($search_cnt)?>)</span>
                                 <?}?>
                             </a>
                        </li>
                    </ul>
                    <ul class="nav_list">
                      <?// '카테고리' . $cate_nm?>
                        <?
                        //var_dump($cate_nm);
                        if($cate_cd1 = explode('|', $cate_cd)){
                            $cate_cd2 = $cate_cd1[0];
                            $cate_cd3 = $cate_cd1[1];
                            //$cate_nm3 = $cate_nm1[2];
                        }
                       /* if(!$cate_nm2){*/?>
						<?foreach($arr_cate_nm as $key=>$crow){?>
						<li class="nav_item<?=$crow['code'] == $cate_cd2 ? " active" : ""?>" >
							<a href="#" onClick="javaScript:search_goods('C','<?=$crow['code']?>');" class="nav_link<?=$key == $cate_cd2 ? " active" : ""?>"><?=$key?><!--<span class="num">(<?/*=number_format($crow['cnt'])*/?>)</span>-->
                                <?if($search_cnt < 10000){?>
                                    <span class="num">(<?=number_format($crow['cnt'])?>)</span>
                                <?}?>
                            </a>
                            <ul class="nav_list_2depth" id="nav_items">
                                <?foreach($arr_cate_nm2 as $bkey=>$brow){
                                    if($crow['code'] == $brow['parent_code']){?>
                                    <li>
                                        <?if(!$cate_cd2){?>
                                        <a href="#" onClick="javaScript:search_goods('C','<?=$crow['code'].'|'.$brow['code']?>');" class="nav_link<?=$brow['code'] == $cate_cd2 ? " active" : ""?>"><?=$bkey?>
                                            <?if($search_cnt < 10000){?>
                                                <span class="num">(<?=number_format($brow['cnt'])?>)</span>
                                            <?}?>
                                        </a>
                                        <?}else{?>
                                            <a href="#" onClick="javaScript:search_goods('C','<?=$crow['code'].'|'.$brow['code']?>');" class="nav_link<?=$brow['code'] == $cate_cd3  ? " active" : ""?>"><?=$bkey?>
                                                <?if($search_cnt < 10000){?>
                                                    <span class="num">(<?=number_format($brow['cnt'])?>)</span>
                                                <?}?>
                                            </a>
                                        <?}?>
                                    </li>
                                <?}
                                }?>
                            </ul>
						</li>
						<?
                        }
                        ?>
					</ul>
				</div>
				<?if($search_cnt > 0){?>
				<div class="contents_inner ">
					<div class="location position_area">
						<h2 class="title_page title_page__line">
							검색결과
						</h2>
						<ul class="location_list position_right">
							<li class="location_item"><a href="\">홈</a><span class="spr-common spr_arrow_right"></span></li>
							<li class="location_item"><a href="#" class="active">검색결과</a></li>
						</ul>
					</div>

					<p class="srp_result_text">
						<em class="bold"><?=$r_keyword ? str_replace('||',', ',$r_keyword) : $keyword?></em> 검색어로 <em class="bold"><?=number_format($search_cnt)?>개</em>의 상품이 검색되었습니다.
					</p>

					<div class="srp_keyword_box">
						<div class="srp_keyword">
							<!--<span class="title">연관 검색어 :</span> 4인식탁, 면피, 패브릭소파, 인테리어, 소파테이블-->
						</div>
						<dl class="srp_keyword_research">
							<dt class="title">결과 내 재검색</dt>
							<dd class="data">
								<!-- search // -->
								<div class="search">
									<form action="">
										<fieldset class="search_form">
											<legend>검색</legend>
											<input type="hidden" id ="keyword"		value="<?=$keyword?>">
											<input type="hidden" id ="r_keyword"	value="<?=$r_keyword?>">
											<input type="hidden" id ="search_cnt"	value="<?=$search_cnt?>">
											<input type="text" id="contents_search" class="search_input" onKeyPress="javascript:if(event.keyCode == 13){ search('r'); return false;}"/>
											<button type="button" class="search_submit" title="검색" onClick="javaScript:search('r');"><span class="spr-common"></span></button>
										</fieldset>
									</form>
								</div>
								<!-- // search -->
							</dd>
						</dl>
					</div>

					<div class="brand_check">
						<h3 class="brand_check_title">브랜드</h3>
						<ul class="brand_check_list">
							<!--<?
							$idx=1;
							foreach($brand_cnt as $brow){?>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck0<?=$idx?>" onClick="javaScript:search_goods('B','')" value="<?=$brow['BRAND_CD']?>" name="chkBrand[]" <?=$brow['FLAG_YN'] == 'N' ? "" : "checked"?>>
								<label class="checkbox_label" for="formBrandCheck0<?=$idx?>"><?=$brow['BRAND_NM']?> <span class="num">(<?=$brow['GOODS_CNT']?>)</span></label>
							</li>
							<?
							$idx++;
							}?>-->
							<?
							$idx=1;
							//var_dump('브랜드쪽'.$cate_nm);
							for($i = 0; $i < count($arr_brand_nm['BRAND_NM']); $i++){
							?>

							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck0<?=$idx?>" onClick="javaScript:search_goods('B','<?=$cate_cd?>')" value="<?=$arr_brand_nm['BRAND_NM'][$i]?>" name="chkBrand[]" >
								<label class="checkbox_label" for="formBrandCheck0<?=$idx?>"><?=$arr_brand_nm['BRAND_NM'][$i]?> <span class="num">(<?=$arr_brand_nm['BRAND_CNT'][$i]?>)</span></label>
							</li>
							<?
							$idx++;
							}
							?>
						</ul>
						<button type="button" class="brand_check_btn" data-ui="toggle-class" data-target=".brand_check" data-class="active"><span class="spr-common spr_btn_more"></span></button>
					</div>

					<div class="option_button position_area">
						<ul class="button_list">
							<li class="button_item" style="height:35px;"><!--<a href="javaScript:search_goods('P','');" class="button_basic<?=$price_limit == '' ? " active" : ""?>">전체</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',3);" class="button_basic<?=$price_limit == '3' ? " active" : ""?>">3만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',5);" class="button_basic<?=$price_limit == '5' ? " active" : ""?>">5만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',10);" class="button_basic<?=$price_limit == '10' ? " active" : ""?>">10만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',30);" class="button_basic<?=$price_limit == '30' ? " active" : ""?>">30만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',50);" class="button_basic<?=$price_limit == '50' ? " active" : ""?>">50만원 이상</a>--></li>
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
									<a href="/goods/detail/<?=$grow['fields']['goods_cd']?>" class="img_link"><img src="<?=$grow['fields']['img_url']?>" alt=""></a>
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
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$grow['fields']['goods_cd']?>','','');">
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
						</ul>
					</div>

					<?=$pagination?>
				</div>
				<?}else{?>
				<div class="contents_inner ">
					<div class="location position_area">
						<h2 class="title_page title_page__line">
							검색결과
						</h2>
						<ul class="location_list position_right">
							<li class="location_item"><a href="#">홈</a><span class="spr-common spr_arrow_right"></span></li>
							<li class="location_item"><a href="#" class="active">검색결과</a></li>
						</ul>
					</div>

					<div class="srp_result_text prd_none_text">
						<em class="bold"><?=$r_keyword ? str_replace('||',', ',$r_keyword) : $keyword?></em>에 대한 검색 결과가 없습니다.

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
				</div>
				<?}?>


		<script src="/assets/js/common.js"></script>
		<script type="text/javascript">
			// 차후 수정 예정.
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
			check_brand();
			//====================================
			// 브랜드 체크
			//====================================
			function check_brand()
			{
				var brand_nm = "<?=$brand_nm?>",
					brand = document.getElementsByName("chkBrand[]");

				arr_brand = brand_nm.split("|");
				for( j=1; j<arr_brand.length; j++){
					for( i=0; i<brand.length; i++){
						if(document.getElementsByName("chkBrand[]")[i].value == arr_brand[j]){

							document.getElementsByName("chkBrand[]")[i].checked = true;
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
				var cate_cd		= "<?=$cate_cd?>";
				var price_limit = "<?=$price_limit?>";
				var order_by	= "<?=$order_by?>";
				var	brand_nm	= "<?=$brand_nm?>";
				var keyword		= $('#keyword').val();
				var r_keyword	= $('#r_keyword').val();
				var search_cnt	= $('#search_cnt').val();

				//싱품 디스플레이 개수 변경
				if(kind == 'L'){
					limit = val;
					page = 1;
				}
				//싱품 가격 제한
				if(kind == 'P'){
					price_limit = val;
					page = 1;
				}
				//상품 정렬 변경
				if(kind == 'O'){
					order_by = val;
					page = 1;
				}
				//브랜드
				if(kind == 'B'){
					var b_cnt = document.getElementsByName("chkBrand[]").length;
						brand_nm = "";
					for( i=0; i<b_cnt; i++){
						if(document.getElementsByName("chkBrand[]")[i].checked == true){
							brand_nm += "|"+document.getElementsByName("chkBrand[]")[i].value;
						}
					}
                    cate_cd = val.replace('&','%%');
					page = 1;
				}
				//카테고리 속성검색
				if(kind == 'A'){
					var chk_attr = document.getElementsByName("chkAttr[]");
					attr = "";
					for( i=0; i<chk_attr.length; i++){
						if(document.getElementById("formOptionCheck010"+(i+1)).checked == true){
							attr += "|"+document.getElementsByName("chkAttr[]")[i].value;
						}
					}
					page = 1;
				}
				//검색결과 카테고리 이동
				if(kind == 'C'){
                    cate_cd = val;
                    brand_nm = '';
					page = 1;
				}

				var param = "";
				param += "kind="			+ kind;
				param += "&cate_cd="		+ cate_cd;
				param += "&limit_num_rows="	+ limit;
				param += "&price_limit="	+ price_limit;
				param += "&page="			+ page;
				param += "&brand_nm="		+ brand_nm;
				param += "&order_by="		+ order_by;
				param += "&keyword="		+ keyword;
				param += "&r_keyword="		+ r_keyword;
				param += "&search_cnt="		+ search_cnt;

				document.location.href = "/goods2/goods_search/"+page+"?"+param;
			}
            $(".nav_list a").click(function(){
                $(this).next().slideDown().parent().siblings().children(".nav_list_2depth");

                return true;
            });
		</script>
        <!--GA script-->
        <script>
            //Impression
//            ga('require', 'ecommerce', 'ecommerce.js');
//            <?//foreach ($goods as $grow){?>
//            ga('ecommerce:addImpression', {
//                'id': <?//=$grow['fields']['goods_cd']?>//,                   // Product details are provided in an impressionFieldObject.
//                'name': "<?//=$grow['fields']['goods_nm']?>//",
//                'category': <?//=$grow['fields']['category_3_cd']?>//,
//                'brand': '<?//=$grow['fields']['brand_cd']?>//',
//                'list': 'Search Results'
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
//                ga('ecommerce:setAction', 'click', {list: 'Search Results'});
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
