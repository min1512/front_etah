			<link rel="stylesheet" href="/assets/css/display.css">

			<div class="contents vip">

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
					<ul class="vip_banner_corver"></ul>
					<ul class="vip_banner_list">
						<!-- <li class="vip_banner_item"><img src="/assets/images/data/bnr_640x640_01.jpg" alt=""/></li>
						<li class="vip_banner_item active"><img src="/assets/images/data/bnr_640x640_02.jpg" alt="" /></li>
						<li class="vip_banner_item"><img src="/assets/images/data/bnr_640x640_03.jpg" alt="" /></li>
						<li class="vip_banner_item"><img src="/assets/images/data/bnr_640x640_04.jpg" alt="" /></li> -->
					</ul>

					<a href="#" class="btn_left">
						<img src="/assets/images/display/btn_left.png" alt="이전배너" />
					</a>
					<a href="#" class="btn_right">
						<img src="/assets/images/display/btn_right.png" alt="다음배너" />
					</a>
					<ul class="vip_banner_btn">
						<!-- <li>
							<a href="#">
								<img src="/assets/images/data/bnr_120x120_01.jpg" alt=""/>
							</a>
						</li>
						<li class="active">
							<a href="#">
								<img src="/assets/images/data/bnr_120x120_02.jpg" alt=""/>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="/assets/images/data/bnr_120x120_03.jpg" alt=""/>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="/assets/images/data/bnr_120x120_04.jpg" alt=""/>
							</a>
						</li>
						<li>
							<img src="/assets/images/data/bnr_120x120_05.jpg" alt=""/>
							<button type="button" class="btn_play"><img src="/assets/images/display/btn_play.png" alt="play"/></button>
						</li> -->
					</ul>
				</div>

				<div class="vip_inner">
					<!-- 아이프레임영역 - 아이프레임 높이 스크립트로 제어필요. // -->
					<iframe class="iframe" src="/goods/iframe_prd?goods_code=<?=$goods['GOODS_CD']?>" width="100%"  scrolling="no" border="no" marginwidth="0" marginheight="0" frameborder="0" id="iframe_prd_info"></iframe>
					<!-- // 아이프레임영역 -->
					<div class="vip_brand_recom">
						<h3 class="vip_section_title">동일 브랜드 추천상품</h3>
						<div class="basic_goods_list">
							<ul class="goods_list">
								<? foreach($brand_goods as $row){	?>
								<li class="goods_item">
									<div class="img">
										<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="img_link"><img src="<?=$row['IMG_URL']?>" alt=""></a>
										<ul class="goods_action_menu">
										<!--	<li class="goods_action_item">
												<button type="button" class="action_btn">
													<span class="spr-common spr_cart"></span>
													<span class="spr-common spr-bgcircle2"></span>
													<span class="button_text">Add Cart</span>
												</button>
											</li>	-->
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
											<!--		<li class="goods_sns_item">
														<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
															<span class="spr-common spr_share_insta"></span>
															<span class="spr-common spr-bgcircle3"></span>
															<span class="button_text">인스타</span>
														</button>
													</li>	-->
													<li class="goods_sns_item">
														<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');" >
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
										<span class="price"><?=number_format($row['SELLING_PRICE'])?></span>
									</a>
								</li>
								<? }?>
								<!--	<li class="goods_item">
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
								</li>	-->
							</ul>
						</div>
					</div>

					<?if($goods['BRAND_DESC']){?>
					<div class="vip_brand_about">
						<h3 class="vip_section_title">ABOUT BRAND</h3>
						<div class="vip_brand_about_img"><img src="<?=$goods['BRAND_IMG']?>" alt="" /></div>
						<!-- 브랜드 한글 설명 --><p class="vip_brand_about_text"><?=$goods['BRAND_DESC']?></p>
						<!--<p class="vip_brand_about_text">Jackeson Chameleon’s Motto is ‘The New Balance’<br /> People always want the something new and they want to be different from others. At the same time,<br /> the Word ‘New’ always makes us feel unfamilliar.<br /> We beillieve that our motto ‘The
							New Balance’ will make you feel more comfortable with the New and Unfamillear.<br /> Our study and effort that we put into making the furniture will make your life more enjoyable.<br /> We hope you enjoy your life whit Jackson Chameleon aroud you.</p>-->
					</div>
					<?}?>

					<div class="vip_prd_info">
						<ul class="tab_menu">
							<li class="tab_item active"><a href="#prdComment" class="tab_link">상품평</a></li>
							<!-- 활성화시 클래스 active 추가 -->
							<li class="tab_item"><a href="#prdInquiry" class="tab_link">상품문의</a></li>
							<li class="tab_item"><a href="#prdDelivery" class="tab_link">배송정보</a></li>
							<li class="tab_item"><a href="#prdRefund" class="tab_link">교환&#47;환불</a></li>
						</ul>

						<!-- 상품평 // -->
						<div class="vip_prd_info_cont" id="prdComment" style="display: block;">
							<?=$comment_template?>
						</div>
						<!-- // 상품평 -->

						<!-- 상품문의 // -->
						<div class="vip_prd_info_cont prd_inquiry" id="prdInquiry">
							<?=$qna_template?>
						</div>
						<!-- // 상품문의 -->

						<!-- 배송정보 // -->
						<div class="vip_prd_info_cont" id="prdDelivery">
							<ul class="vip_prd_info_text_list">
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 방법</span>
									<span class="text"><?=$goods['DELIV_COMPANY_CD'] == '99' ? $goods['BRAND_NM']." 브랜드는 직접 배송을 원칙으로 합니다." : $goods['DELIV_COMPANY_NM']?></span>
								</li>
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 지역</span>
									<span class="text">전국 <?=$goods_no_deli[0]['DELIV_AREA_CD'] == true ? "(도서/일부 지역은 배송이 불가능 합니다.)" : ""?></span>
								</li>
				<!--			<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 기간</span>
									<span class="text">서울, 경기 7~20일 &#47; 지방 10~30일 (천재지변, 명절 연휴 등 사유 발생 시에는 배송 기간에서 제외됩니다.</span>
								</li>	-->
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 비용</span>
									<span class="text">
									<? $i=0;
										foreach($goods_add_deli as $row){
											if($i==0){	?>
											<?=$goods['DELI_COST'] == 0 ? "무료배송" : number_format($goods['DELI_COST'])."원"?>
										<? }
											if(isset($row['DELIV_AREA_CD'])){	?>
										&#47; <?=$row['DELIV_AREA_NM']?> - <?=number_format($row['ADD_DELIV_COST']+$goods['DELI_COST'])?>원
										<? }?>

									<?	$i++;
										}?>
									<? foreach($goods_no_deli as $row){
											if(isset($row['DELIV_AREA_CD'])){	?>
										&#47; <?=$row['DELIV_AREA_NM']?> - 배송 불가
									<?		}
										}?>
									</span>
									<!--<span class="text">서울, 경기 - 무료 &#47; 충천, 강원, 영서 - 50,000원 &#47; 경상, 전라, 영동- 70,000원 &#47; 제주, 도서 - 배송 불가, 착불 배송</span>	-->
								</li>
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 안내</span>
									<span class="text">배송 시 연락처 불분명 또는 부재 시 배송이 지연될 수 있습니다. 수취인 부재, 주소 불분명, 연락처 오기재로 인한 오배송 또는 수취거부 및 단순 변심에 의한 반품, 교환의 경우 고객님께서 왕복 배송비를 부담하셔야 합니다.<br />
									사다리차 및 엘리베이터 사용 시 발생하는 비용은 고객님의 부담입니다.<br />
									차량의 이동이 어려운 일부 도시지역 및 제주도는 배송이 불가능할 수도 있으니 반드시 상담 후 주문해 주시기 바랍니다.<br /></span>
								</li>
							</ul>
						</div>
						<!-- // 배송정보 -->

						<!-- 교환/환불 // -->
						<div class="vip_prd_info_cont" id="prdRefund">
							<ul class="vip_prd_info_text_list">
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>지정택배사</span>
									<span class="text"><?=$goods['DELIV_COMPANY_NM']?></span>
								</li>
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>반품배송비</span>
									<span class="text"><?=number_format($goods['RETURN_DELIV_COST'])?>원</span>
								</li>
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>보내실 곳</span>
									<span class="text">(<?=strlen($goods['RETURN_ZIPCODE'])==6 ? substr($goods['RETURN_ZIPCODE'],0,3)."-".substr($goods['RETURN_ZIPCODE'],3,3) : $goods['RETURN_ZIPCODE']?>) <?=$goods['RETURN_ADDR']?></span>
								</li>
						<!--		<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 비용</span>
									<span class="text">서울, 경기 - 무료 &#47; 충천, 강원, 영서 - 50,000원 &#47; 경상, 전라, 영동- 70,000원 &#47; 제주, 도서 - 배송 불가, 착불 배송</span>
								</li>
								<li class="vip_prd_info_text_item">
									<span class="title"><span class="spr-common spr_bg_dot"></span>배송 안내</span>
									<span class="text">배송 시 연락처 불분명 또는 부재 시 배송이 지연될 수 있습니다. 수취인 부재, 주소 불분명, 연락처 오기재로 인한 오배송 또는 수취거부 및 단순 변심에 의한 반품, 교환의 경우 고객님께서 왕복 배송비를 부담하셔야 합니다.<br />
									사다리차 및 엘리베이터 사용 시 발생하는 비용은 고객님의 부담입니다.<br />
									차량의 이동이 어려운 일부 도시지역 및 제주도는 배송이 불가능할 수도 있으니 반드시 상담 후 주문해 주시기 바랍니다.<br /></span>
								</li>	-->
							</ul>
						</div>
						<!-- // 교환/환불 -->
					</div>
				</div>
		<!-- 상품정보 form 시작 -->
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
		<input type="hidden" id="goods_discount_price"		name="goods_discount_price"		value="<?=$goods['SELLING_PRICE'] - $goods['COUPON_PRICE']?>">
		<input type="hidden" id="goods_coupon_code_s"		name="goods_coupon_code_s"	value="<?=isset($goods['SELLER_COUPON_CD']) ? $goods['SELLER_COUPON_CD']."||".$goods['SELLER_COUPON_METHOD']."||".($goods['SELLER_COUPON_METHOD']=='RATE' ? $goods['SELLER_COUPON_FLAT_RATE'] : $goods['SELLER_COUPON_FLAT_AMT'])."||".$goods['SELLER_COUPON_MAX_DISCOUNT'] : ""?>">
		<input type="hidden" id="goods_coupon_code_i"		name="goods_coupon_code_i"		value="<?=isset($goods['ITEM_COUPON_CD']) ? $goods['ITEM_COUPON_CD']."||".$goods['ITEM_COUPON_METHOD']."||".($goods['ITEM_COUPON_METHOD']=='RATE' ? $goods['ITEM_COUPON_FLAT_RATE'] : $goods['ITEM_COUPON_FLAT_AMT'])."||".$goods['ITEM_COUPON_MAX_DISCOUNT'] : ""?>">
		<input type="hidden" id="deli_policy_no"			name="deli_policy_no"			value="<?=$goods['DELIV_POLICY_NO']?>">
		<input type="hidden" id="deli_limit"				name="deli_limit"				value="<?=$goods['DELI_LIMIT']?>">
		<input type="hidden" id="deli_cost"					name="deli_cost"				value="<?=$goods['DELI_COST']?>">
		<input type="hidden" id="deli_code"					name="deli_code"				value="<?=$goods['DELI_CODE']?>">

				<div class="vip_detail">
					<div class="vip_detail_top position_area">
						<h2 class="brand_title"><img src="<?=$goods['BRAND_LOGO_IMG']?>" alt="" width="36" height="36"/><?=$goods['BRAND_NM']?></h2>
						<a href="/goods/brand/<?=$goods['BRAND_CD']?>" class="position_right btn_brand_shop">Brand Shop <span class="spr-common spr-triangle_right"></span></a>
					</div>
					<div class="vip_detail_inner">
						<div class="position_area vip_detail_prd_title">
							<h3 class="title"><?=$goods['GOODS_NM']?></h3>
							<strong class="price"><?=number_format($goods['SELLING_PRICE'])?>원</strong>
							<a href="#" class="position_right btn_guide"><span class="spr-common spr_btn_guide"></span>Guide</a>
						</div>
						<? if(isset($goods['SELLER_COUPON_CD']) || isset($goods['ITEM_COUPON_CD']))	{?>
						<dl class="vip_detail_line">
							<dt class="title">할인적용가</dt>
							<dd class="data"><strong class="price"><?=number_format($goods['COUPON_PRICE'])?>원</strong> <span class="tip">(<?=$goods['COUPON_INFO']?>)</span></dd>
						</dl>
						<? }?>
						<dl class="vip_detail_line">
							<dt class="title">제조사&#47;브랜드</dt>
							<dd class="data"><?=$goods['BRAND_NM']?></dd>
						</dl>
						<dl class="vip_detail_line">
							<dt class="title">배송가능지역</dt>
							<dd class="data">전국 <?=$goods_no_deli[0]['DELIV_AREA_CD'] == true ? "(도서산간 제외)" : ""?></dd>
						</dl>
						<? if(count($goods_class) != 0){
							foreach($goods_class as $row)	{?>
						<dl class="vip_detail_line">
							<dt class="title"><?=$row['CLASS_ATTR_MAIN']?></dt>
							<dd class="data"><?=$row['CLASS_ATTR_SUB']?></dd>
						</dl>
						<?	}
						}?>
						<dl class="vip_detail_line">
							<dt class="title">배송비</dt>
							<dd class="data"><? if($goods['DELI_LIMIT'] != 0) {?>
							<input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_LIMIT']>$goods['SELLING_PRICE'] ? $goods['DELI_COST'] : 0 ?>">
							<?=$goods['DELI_LIMIT']>$goods['SELLING_PRICE'] ? number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)" : "무료배송"?>
							<? } else {	?>
							<input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_COST']?>">
								<? if($goods['DELI_COST'] != 0){?>
								<?=number_format($goods['DELI_COST'])."원"?>
								<? } else {	?>
								무료배송
								<?}
							}?>
							</dd>
						</dl>
						<dl class="vip_detail_line vip_detail_line__select">
							<dt class="title"><label for="formNumSelect">수량선택</label></dt>
							<dd class="data">
								<div class="select_wrap" style="width:304px;">
									<select id="formNumSelect" name="goods_cnt" style="width:304px;">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
								</div>
							</dd>
						</dl>
						<dl class="vip_detail_line vip_detail_line__select">
							<dt class="title"><label for="formOpotionSelect">옵션선택</label></dt>
							<dd class="data">
							<? if($goods_option){	//옵션이 있을 경우?>
								<div class="select_wrap" style="width:304px;">
									<select id="formOpotionSelect" name="goods_option_code" style="width:304px;">
										<option value="" selected>옵션을 선택하세요</option>
										<? foreach($goods_option as $row)	{?>
										<option value="<?=$row['GOODS_OPTION_CD']?>||<?=$row['GOODS_OPTION_NM']?>||<?=$row['GOODS_OPTION_ADD_PRICE']?>">
										<?=$row['GOODS_OPTION_NM']?><? if($row['GOODS_OPTION_ADD_PRICE'] && $row['GOODS_OPTION_ADD_PRICE']>0){?>&nbsp;(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<?}?><?if($row['QTY'] && $row['QTY']>0){?>&nbsp;- 재고 : <?=$row['QTY']?>개<?}?></option>
										<? }?>
									</select>
								</div>
								<? } else {	//옵션이 없을 경우
									echo "옵션이 없습니다.";
									}?>
							</dd>
						</dl>

						<ul class="btn_list vip_detail_btns">
							<li><button type="button" class="btn_negative btn_negative__min" onClick="javaScript:jsGoodsAction('W','','<?=$row['GOODS_CD']?>','','');"><span class="spr-common spr-heart"></span>관심상품</button></li>
							<li><button type="button" class="btn_negative btn_negative__min" onClick="javascript:jsAddCart();"><span class="spr-common spr-bag"></span>장바구니</button></li>
						</ul>

						<button type="button" class="btn_positive btn_positive__min vip_detail_btn_buy" onClick="javascript:jsDirect();"><span class="spr-common spr-card"></span>바로구매</button>

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
		<input type="hidden" id="guest_gb" name="guest_gb" value="">		<!-- 비회원 구매시 바로구매인지 장바구니구매인지 -->
	</form>

	<!-- 상품 이미지 정보 -->
	<? $img_idx = 0;
		foreach($goods['img'] as $row){		?>
			<input type="hidden"	id="rolling_goods_img_<?=$img_idx?>"	name="rolling_goods_img[]"	value="<?=$row?>">
	<? $img_idx ++;
		}?>

</div>

<script src="/assets/js/common.js"></script>
<script src="/assets/js/vip.js"></script>
<script type="text/javascript">
$(function()
			{
					// vip tab
					$('.tab_menu .tab_link').click(function()
					{
						var thisHref = $(this).attr('href');
						$('.tab_item').removeClass('active');
						$(this).parent('.tab_item').addClass('active');
						$('.vip_prd_info_cont').hide();
						$(thisHref).css('display', 'block');
						console.log(thisHref)
						return false;
					});
			});

//===============================================================
// 상품 바로구매
//===============================================================
function jsDirect(){
	var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
	var param		= $("#goods_form").serialize();

	if($("input[name=goods_state]").val() != '03'){
		alert("판매중이 아닌 상품은 구매할 수 없습니다.");
		return false;
	}

	if($("select[name=goods_option_code]").val() == ""){
		alert("옵션을 선택해주세요.");
		$("select[name=goods_option_code]").focus();
		return false;
	}

	if($("select[name=goods_option_code]").val() == undefined){
		alert("옵션이 없는 해당 상품은 구매할 수 없습니다.");
		return false;
	}

	if(SESSION_ID == '' || SESSION_ID == 'GUEST'){	//로그인 안한 경우
		document.getElementById("goods_form").guest_gb.value = 'direct';

		var frm = document.getElementById("goods_form");
		frm.action = "/member/Guestlogin";
		frm.submit();
	} else {
		var frm = document.getElementById("goods_form");
		frm.action = "/cart/OrderInfo";
		frm.submit();
	}
}

//===============================================================
// 장바구니에 상품 담기
//===============================================================
function jsAddCart(){
	var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
	var param		= $("#goods_form").serialize();
	var goods_code	= document.getElementById("goods_form").goods_code.value;
	var goods_cnt	= document.getElementById("goods_form").goods_cnt.value;
	var goods_option_code = document.getElementById("goods_form").goods_option_code.value;

	if($("input[name=goods_state]").val() != '03'){
		alert("판매중이 아닌 상품은 장바구니에 담을 수 없습니다.");
		return false;
	}

	if($("select[name=goods_option_code]").val() == ""){
		alert("옵션을 선택해주세요.");
		$("select[name=goods_option_code]").focus();
		return false;
	}

	if($("select[name=goods_option_code]").val() == undefined){
		alert("옵션이 없는 해당 상품은 장바구니에 담을 수 없습니다.");
		return false;
	}

	if(SESSION_ID == ''){
		location.href = '/member/login';
	}
	else if(SESSION_ID == 'GUEST' || SESSION_ID == ''){
		if(confirm("로그인 후에 장바구니에 상품을 담을 수 있습니다. \n회원가입하시겠습니까?")){
			location.href = '/member/member_join';
		}
	}
	else {
		$.ajax({
			type: 'POST',
			url: '/cart/insert_cart',
			dataType: 'json',
			data: param,
			error: function(res) {
				alert('Database Error');
			},
			success: function(res) {
				if(res.status == 'ok'){
					if(confirm('장바구니에 상품이 담겼습니다. 확인하시겠습니까?')){
						location.href='/cart';
					}
				}
				else alert(res.message);
			}
		})
	}

	return false;
}

//===============================================================
// 로그인 후 문의하기
//===============================================================
function jsLogin(){
	var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

	if(SESSION_ID == '' || SESSION_ID == 'GUEST'){
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
	var comment_title		= $("input[name=comment_title]").val();
	var comment_contents	= $("#comment_contents").val();
	var comment_grade_val01	= $("select[name=grade_val01]").val();
	var comment_grade_val02	= $("select[name=grade_val02]").val();
	var comment_grade_val03	= $("select[name=grade_val03]").val();
	var comment_grade_val04	= $("select[name=grade_val04]").val();
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

	if( ! comment_title ){
		alert('상품평 제목을 입력하시기 바랍니다.');
		$("input[name=comment_title]").focus();
		return false;
	}

	if( ! comment_contents ){
		alert('상품평 내용을 입력하시기 바랍니다.');
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
			else alert(res.message);
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

	$.ajax({
		type: 'POST',
		url: '/mywiz/qna_regist',
		dataType: 'json',
		data: {goods_code : qna_goods_code, title : qna_title, contents : qna_contents, qna_type : qna_type, mem_id : mem_id},
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
//var vipBannerItem = [
//			{
//				'type': 'image', // image or video
//				'src': '/assets/images/data/bnr_640x640_01.jpg'
//			},
//			{
//				'type': 'image', // image or video
//				'src': '/assets/images/data/bnr_640x640_02.jpg'
//			},
//			{
//				'type': 'image', // image or video
//				'src': '/assets/images/data/bnr_640x640_03.jpg'
//			},
//			{
//				'type': 'image', // image or video
//				'src': '/assets/images/data/bnr_640x640_04.jpg'
//			},
//			{
//				'type': 'video', // image or video
//				'thm': '/assets/images/data/bnr_120x120_05.jpg',
//				'poster': '/assets/images/data/bnr_120x120_05.jpg',
//				'src': '/assets/images/data/traffic_gray.mp4',
//				'src2': '/assets/images/data/traffic_gray.webm'
//			}];

function vipBannerRoll(data)
{
	var $box = $('#vip_banner'),
		$view = $box.find('.vip_banner_list'),
		$list = $box.find('.vip_banner_btn'),
		$corver = $box.find('.vip_banner_corver'),
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
				corverHtml += '<li class="active" ></li>';
			}
			else
			{
				corverHtml += '<li ></li>';
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
				$.each($view.find('li'), function(index)
				{
					$(this).css('z-index', total - index);
				});
				$box.addClass('vip_banner_fadeui');
				$list.find('li.ui-listclick').on('click', function()
				{
					fader($(this).data('index'));
				});
				$left.on('click', function()
				{
					fader('left');
					return false;
				});
				$right.on('click', function()
				{
					fader('right');
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
			$corver.html(corverHtml);
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
				nextElement.css('z-index', total - 1).addClass('active');
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
			// console.log( state.page, move, targetNumber );
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
			//debugger;
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
</script>
