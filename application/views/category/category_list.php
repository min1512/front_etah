		<div class="contents contents__nav <?=$type?>">
			<?if($type == 'lp'){?><!--카테고리 리스트-->
				<div class="nav" id="nav">
					<h1 class="nav_title"><?=$category['CATE_NAME1']?></h1>

					<ul class="nav_list">
						<?for($a=0; $a<count($nav['CATEGORY_CD1']); $a++){?>
						<li class="nav_item">
							<a href="#" class="nav_link"><?=$nav['CATEGORY_NM1'][$a]?></a>
							<ul class="nav_list_2depth">
								<?for($b=0; $b<count($nav['CATEGORY_CD2'][$a]); $b++){?>
								<li><a href="/goods2/list/<?=$nav['CATEGORY_CD2'][$a][$b]?>" <?=$nav['CATEGORY_CD2'][$a][$b] == $category['CATE_CODE3'] ? "class='active'" : ""?>><?=$nav['CATEGORY_NM2'][$a][$b]?></a></li>
								<?}?>
							</ul>
						</li>
						<?}?>
					</ul>
				</div>

				<div class="contents_inner ">
					<div class="location position_area">
						<h2 class="title_page title_page__line">
							<?=$category['CATE_NAME3']?>
						</h2>
						<ul class="location_list position_right">
							<li class="location_item"><a href="/">홈</a><span class="spr-common spr_arrow_right"></span></li>
							<li class="location_item"><a href="/category/main/<?=$category['CATE_CODE1']?>"><?=$category['CATE_NAME1']?></a><span class="spr-common spr_arrow_right"></span></li>
							<li class="location_item"><a href="#"><?=$category['CATE_NAME2']?></a><span class="spr-common spr_arrow_right"></span></li>
							<li class="location_item"><a href="#" class="active"><?=$category['CATE_NAME3']?></a></li>
						</ul>
					</div>
					<?if($category_attr['ATTR_CODE1']){?>
					<ul class="option_select">
						<li class="option_select_item">
							<a href="#"><img src="/assets/images/data/data_icon_01.jpg" alt="" />일반형</a>
						</li>
						<li class="option_select_item">
							<a href="#"><img src="/assets/images/data/data_icon_02.jpg" alt="" />대리석형</a>
						</li>
						<li class="option_select_item">
							<a href="#"><img src="/assets/images/data/data_icon_03.jpg" alt="" />원목형</a>
						</li>
					</ul>
					<?}?>

			<?}else{?>


				<!--<div class="nav" id="nav">
					<h1 class="nav_title">카테고리</h1>
					<ul class="nav_list nav_list__srp">
						<li class="nav_item active">-->
							<!-- 활성화시 클래스 active 추가 -->
							<!--<a href="#" class="nav_link">전체 <span class="num">(2,600)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">학생가구 <span class="num">(100)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">서재가구 <span class="num">(360)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">거실가구 <span class="num">(260)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">수납용품 <span class="num">(321)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">인테리어 <span class="num">(123)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">침실가구 <span class="num">(12)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">패브릭 <span class="num">(65)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">키즈 <span class="num">(135)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">유아동 <span class="num">(6)</span></a>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">욕실 <span class="num">(160)</span></a>
						</li>
					</ul>
				</div>-->

				<div class="nav" id="nav">
					<h1 class="nav_title">카테고리</h1>
					<ul class="nav_list nav_list__srp">
						<li class="nav_item<?=!$category['CATE_CODE3'] ? " active" : ""?>">
							<!-- 활성화시 클래스 active 추가 -->
							<a href="#" onClick="javaScript:search_goods('C','');" class="nav_link">전체 <span class="num">(<?=number_format($search_cnt)?>)</span></a>
						</li>
						<?foreach($nav as $nrow){?>
						<li class="nav_item<?=$nrow['CATE_CODE3'] == $category['CATE_CODE3'] ? " active" : ""?>">
							<a href="#" onClick="javaScript:search_goods('C','<?=$nrow['CATE_CODE3']?>');" class="nav_link"><?=$nrow['CATE_NAME1']?> <span class="num">(<?=$nrow['CATE_CNT']?>)</span></a>
						</li>
						<?}?>
					</ul>
				</div>

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
							<span class="title">연관 검색어 :</span> 4인식탁, 면피, 패브릭소파, 인테리어, 소파테이블
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

			<?}?>
			

				<!--<div class="nav" id="nav">
					<h1 class="nav_title">가구</h1>
					<ul class="nav_list">
						<li class="nav_item">-->
							<!-- 활성화시 클래스 active 추가 -->
							<!--<a href="#" class="nav_link">거실가구</a>
							<ul class="nav_list_2depth">
								<li><a href="#">가죽소파</a></li>
								<li><a href="#">패브릭소파</a></li>
								<li><a href="#" class="active">소파테이블</a></li>-->
								<!-- 활성화시 클래스 active 추가 -->
								<!--<li><a href="#">거실장</a></li>
								<li><a href="#">리클라이너</a></li>
								<li><a href="#">소가구</a></li>
							</ul>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">주방가구</a>
							<ul class="nav_list_2depth">
								<li><a href="#">가죽소파</a></li>
								<li><a href="#">패브릭소파</a></li>
								<li><a href="#">소파테이블</a></li>
								<li><a href="#">거실장</a></li>
								<li><a href="#">리클라이너</a></li>
								<li><a href="#">소가구</a></li>
							</ul>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">서재&#47;의자</a>
							<ul class="nav_list_2depth">
								<li><a href="#">가죽소파</a></li>
								<li><a href="#">패브릭소파</a></li>
								<li><a href="#">소파테이블</a></li>
								<li><a href="#">거실장</a></li>
								<li><a href="#">리클라이너</a></li>
								<li><a href="#">소가구</a></li>
							</ul>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">학생가구</a>
							<ul class="nav_list_2depth">
								<li><a href="#">가죽소파</a></li>
								<li><a href="#">패브릭소파</a></li>
								<li><a href="#">소파테이블</a></li>
								<li><a href="#">거실장</a></li>
								<li><a href="#">리클라이너</a></li>
								<li><a href="#">소가구</a></li>
							</ul>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">어린이가구</a>
							<ul class="nav_list_2depth">
								<li><a href="#">가죽소파</a></li>
								<li><a href="#">패브릭소파</a></li>
								<li><a href="#">소파테이블</a></li>
								<li><a href="#">거실장</a></li>
								<li><a href="#">리클라이너</a></li>
								<li><a href="#">소가구</a></li>
							</ul>
						</li>
						<li class="nav_item">
							<a href="#" class="nav_link">유아동가구</a>
							<ul class="nav_list_2depth">
								<li><a href="#">가죽소파</a></li>
								<li><a href="#">패브릭소파</a></li>
								<li><a href="#">소파테이블</a></li>
								<li><a href="#">거실장</a></li>
								<li><a href="#">리클라이너</a></li>
								<li><a href="#">소가구</a></li>
							</ul>
						</li>
					</ul>
				</div>-->
				

					<div class="brand_check">
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
						<button type="button" class="brand_check_btn" data-ui="toggle-class" data-target=".brand_check" data-class="active"><span class="spr-common spr_btn_more"></span></button>
					</div>

					<!--<div class="brand_check">
						<h3 class="brand_check_title">브랜드</h3>
						<ul class="brand_check_list">
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck01">
								<label class="checkbox_label" for="formBrandCheck01">데코룸 <span class="num">(12)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck02">
								<label class="checkbox_label" for="formBrandCheck02">시트앤모어 <span class="num">(56)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck03">
								<label class="checkbox_label" for="formBrandCheck03">서프시스 <span class="num">(20)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck04">
								<label class="checkbox_label" for="formBrandCheck04">하우스앤홈 <span class="num">(30)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck05">
								<label class="checkbox_label" for="formBrandCheck05">codi7 <span class="num">(32)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck06">
								<label class="checkbox_label" for="formBrandCheck06">디자인스페이스 <span class="num">(14)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck07">
								<label class="checkbox_label" for="formBrandCheck07">퍼니매스 <span class="num">(12)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck08">
								<label class="checkbox_label" for="formBrandCheck08">펀잇쳐스 <span class="num">(12)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck09">
								<label class="checkbox_label" for="formBrandCheck09">도모디자인 <span class="num">(24)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck10">
								<label class="checkbox_label" for="formBrandCheck10">마켓M <span class="num">(56)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck11">
								<label class="checkbox_label" for="formBrandCheck11">퍼니다움 <span class="num">(42)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck12">
								<label class="checkbox_label" for="formBrandCheck12">다니카 <span class="num">(34)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck13">
								<label class="checkbox_label" for="formBrandCheck13">북클레벤 <span class="num">(22)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck14">
								<label class="checkbox_label" for="formBrandCheck14">두닷 <span class="num">(33)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck15">
								<label class="checkbox_label" for="formBrandCheck15">마켓비 <span class="num">(44)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck16">
								<label class="checkbox_label" for="formBrandCheck16">모티브 <span class="num">(55)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck17">
								<label class="checkbox_label" for="formBrandCheck17">모벨카펜터 <span class="num">(21)</span></label>
							</li>
							<li class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formBrandCheck18">
								<label class="checkbox_label" for="formBrandCheck18">스페이스월 <span class="num">(13)</span></label>
							</li>
						</ul>
						<button type="button" class="brand_check_btn"><span class="spr-common spr_btn_more"></span></button>
					</div>-->


					<div class="option_button position_area">
						<ul class="button_list">
							<li class="button_item"><a href="javaScript:search_goods('P','');" class="button_basic<?=$price_limit == '' ? " active" : ""?>">전체</a></li>
							<!-- 활성화시 클래스 active 추가 -->
							<li class="button_item"><a href="javaScript:search_goods('P',3);" class="button_basic<?=$price_limit == '3' ? " active" : ""?>">3만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',5);" class="button_basic<?=$price_limit == '5' ? " active" : ""?>">5만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',10);" class="button_basic<?=$price_limit == '10' ? " active" : ""?>">10만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',30);" class="button_basic<?=$price_limit == '30' ? " active" : ""?>">30만원</a></li>
							<li class="button_item"><a href="javaScript:search_goods('P',50);" class="button_basic<?=$price_limit == '50' ? " active" : ""?>">50만원 이상</a></li>
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
									<img src="<?=$grow['IMG_URL']?>" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('C','<?=$grow['GOODS_CD']?>','','');">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','<?=$grow['GOODS_CD']?>','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$grow['IMG_URL']?>','<?=$grow['GOODS_NM']?>');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','','<?=$grow['GOODS_NM']?>');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="goods_item_link">
									<span class="brand">
										<?=$grow['GOODS_NM']?>
									</span>
									<span class="name"><?=$grow['PROMOTION_PHRSE']?></span>
									<span class="price"><?=number_format($grow['SELLING_PRICE'])?> <span class="spr-common spr_ico_sale"></span></span>
								</a>
							</li>
							<?}?>
						</ul>
					</div>

					<!--<div class="basic_goods_list">
						<ul class="goods_list">
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_1.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000 <span class="spr-common spr_ico_sale"></span></span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_2.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000 <span class="spr-common spr_ico_sale"></span></span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_3.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000 <span class="spr-common spr_ico_sale"></span></span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_4.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000 <span class="spr-common spr_ico_sale"></span></span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_5.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_6.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_7.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_8.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_1.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_2.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_3.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_4.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_5.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_6.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_7.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_8.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_1.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_2.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_3.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_4.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_5.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_6.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_7.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_8.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_1.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_2.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_3.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_4.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_5.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_6.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_1.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_2.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_3.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_4.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_5.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_6.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_7.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_8.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_1.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<img src="/assets/images/data/goods_290x290_2.jpg" alt="">
									<ul class="goods_action_menu">
										<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>
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
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
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
								<a href="#" class="goods_item_link">
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
						</ul>
					</div>-->

					<!--<div class="page">
						<a href="#" class="page_prev">
							<span class="spr-common spr_arrow_left"></span>Pre
						</a>
						<ul class="page_list">
							<li class="page_item"><a href="#">1</a></li>
							<li class="page_item active"><a href="#">2</a></li>
							<li class="page_item"><a href="#">3</a></li>
							<li class="page_item"><a href="#">4</a></li>
							<li class="page_item"><a href="#">5</a></li>
							<li class="page_item"><a href="#">6</a></li>
							<li class="page_item"><a href="#">7</a></li>
							<li class="page_item"><a href="#">8</a></li>
							<li class="page_item"><a href="#">9</a></li>
							<li class="page_item"><a href="#">10</a></li>
						</ul>
						<a href="#" class="page_next">
							Next<span class="spr-common spr_arrow_right"></span>
						</a>
					</div>-->
					<?=$pagination?>

				</div>
			</div>

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

			//====================================
			// 조건별 검색
			//====================================
			function search_goods(kind, val)
			{
				var limit		= "<?=$limit?>";
				var page		= "<?=$page?>";
				var cate_cd		= "<?=$category['CATE_CODE3']?>";
				var price_limit = "<?=$price_limit?>";
				var order_by	= "<?=$order_by?>";
				var	brand_cd	= "<?=$brand_cd?>";
				var url			= "<?=$url?>";
				var type		= "<?=$type?>";
				var keyword		= "";
				var r_keyword	= "";
				var search_cnt	= "";
				
				
				if(type == 'srp'){
					var keyword		= $('#keyword').val();
					var r_keyword	= $('#r_keyword').val();
					var search_cnt	= $('#search_cnt').val();
				}

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
					var b_cnt = "<?=count($brand_cnt)?>";
						brand_cd = ""; 
					for( i=0; i<b_cnt; i++){
						if(document.getElementById("formBrandCheck0"+(i+1)).checked == true){
							brand_cd += "|"+document.getElementsByName("chkBrand[]")[i].value;
						}
					}
					page = 1;
				}
				//검색결과 카테고리 이동
				if(kind == 'C'){
					cate_cd = val;
					page = 1;
				}

				var param = "";
				param += "kind="			+ kind;
				param += "&cate_cd="		+ cate_cd;
				param += "&limit_num_rows="	+ limit;
				param += "&price_limit="	+ price_limit;
				param += "&page="			+ page;
				param += "&brand_cd="		+ brand_cd;
				param += "&order_by="		+ order_by;
				param += "&keyword="		+ keyword;
				param += "&r_keyword="		+ r_keyword;
				param += "&search_cnt="		+ search_cnt;
	
				document.location.href = "/goods2/"+url+"/"+page+"?"+param;
			}
		</script>

		

