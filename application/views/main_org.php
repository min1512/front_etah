			<link rel="stylesheet" href="/assets/css/main.css">

			<div class="contents main">
				<div class="main_banner" id="mainBanner">
					<ul class="main_banner_list">
						<!--<li class="main_banner_item" style="background:url(http://ui.etah.co.kr/assets/images/data/main_banner_160721_01.jpg) no-repeat 50% 0">
							<a href="#">
								<em class="title" style="text-align:center; width:100%; left:0; top:120px">내추럴한 거실 분위기 연출법</em>
								<span class="description" style="text-align:center; width:100%; left:0; top:195px">오크의 잔잔하고 고급스러운 온기가 느껴지는 내추럴우드 거실장</span>
							</a>
						</li>
						<li class="main_banner_item" style="background:url(http://ui.etah.co.kr/assets/images/data/main_banner_160721_02.jpg) no-repeat 50% 0">
							<a href="#">
								<em class="title" style="width:100%; left:360px; top:199px; color:#604226;">북유럽 스타일을 완성하는 <br>패브릭 소품 기획전</em>
								<span class="description" style="width:100%; left:360px; top:335px; color:#604226;">상상후, 라임라잇, 데코토닉의 디자인 쿠션으로 북유럽 거실을 완성하세요.</span>
							</a>
						</li>
						<li class="main_banner_item" style="background:url(http://ui.etah.co.kr/assets/images/data/main_banner_160721_03.jpg) no-repeat 50% 0">
							<a href="#">
								<em class="title" style="text-align:center; width:100%; left:0; top:120px;">패브릭소파로 연출하는 인테리어</em>
								<span class="description" style="text-align:center; width:100%; left:0; top:195px;">편안한 패브릭 소파가 있는 거실공간을 만들어 보세요.</span>
							</a>
						</li>
						<li class="main_banner_item" style="background:url(http://ui.etah.co.kr/assets/images/data/main_banner_160721_04.jpg) no-repeat 50% 0">
							<a href="#">
								<em class="title" style="width:100%; left:362px; top:179px">밤잠 설치는 <br />나의 가족을 위한 <br />시원한 침구</em>
								<span class="description" style="width:100%; left:362px; top:378px">체감 온도 낮춰주는 세사, 쉐르단, 나라데코 등의 ‘여름 침구’</span>
							</a>
						</li>-->
					</ul>
					<!--<?=$top[0]['DISP_HTML']?>-->
					<ul class="main_banner_btn_list">
						<!-- <li class="main_banner_btn_item active">
							<a href="#"><img src="/assets/images/display/big_banner_page.png" alt=""></a>
						</li>
						<li class="main_banner_btn_item">
							<a href="#"><img src="/assets/images/display/big_banner_page.png" alt=""></a>
						</li>
						<li class="main_banner_btn_item">
							<a href="#"><img src="/assets/images/display/big_banner_page.png" alt=""></a>
						</li>
						<li class="main_banner_btn_item">
							<a href="#"><img src="/assets/images/display/big_banner_page.png" alt=""></a>
						</li> -->
					</ul>
				</div>

				<div class="new_area">
					<ul class="main_tab_list">
						<li class="main_tab_item" id="main_tab_item">
							<a href="javaScript:changeItemBrandTab('I');">WEEKLY THEME</a>
						</li>
						<li class="main_tab_item" id="main_tab_brand">
							<a href="javaScript:changeItemBrandTab('B');">BRAND FOCUS</a>
						</li>
					</ul>
					<div id="newItem" class="new_item" style="display:none;">
						<?=$new_item[0]['DISP_HTML']?>
					</div>

					<div id="newBrand" class="new_brand" style="display:none;">
						<script id="newBrandHtml" type="text">
							<?=$new_brand[0]['DISP_HTML']?>
						</script>
					</div>
				</div>

				<?if($showroom[0]['DISP_HTML']){?>
				<div class="show_room" id="show_room">
					<!-- 향후 실제 상품을 이용한 html 이 삽입 됩니다. -->
					<?=$showroom[0]['DISP_HTML']?>
				</div>

				<?}else{?>
				<div class="show_room" id="show_room"></div>
				<script>var showRoomData = "";</script>
				<?}?>

				<div class="best_area">
					<h4 class="title_style">THE CHOICE</h4>
					<!-- <ul class="main_tab_list">
						<li class="main_tab_item" id="bestItem_li">
							<!--<a href="#bestItem" onClick="javaScript:getEtahChoice('B');">BEST ITEM</a>-- >
							<a href="javaScript:getEtahChoice('B');">BEST ITEM</a>
						</li>
						<li class="main_tab_item active"  id="etahsChoice_li">
							<a href="javaScript:getEtahChoice('E');">THE CHOICE</a>
						</li>
					</ul> -->
					<!-- <div id="bestItem" class="main_goods_list" >
						<ul class="goods_list">
							<!-- 요청에 의해 가격 강제 숨김 클래스 main_goods_list 제거 -- >
							<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1176010"><img src="http://image.etah.co.kr/goods/1176010/247_20171219183103_eeeee11111111_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1176010/247_20171219183103_eeeee11111111_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1176010','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1176010','http://image.etah.co.kr/goods/1176010/247_20171219183103_eeeee11111111_300.jpg','[르크루제] 스톤웨어 카술레서빙볼');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1176010','','[르크루제] 스톤웨어 카술레서빙볼');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1176010','http://image.etah.co.kr/goods/1176010/247_20171219183103_eeeee11111111_300.jpg','[르크루제] 스톤웨어 카술레서빙볼');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										르크루제									</span>
									<span class="name">[르크루제] 스톤웨어 카술레서빙볼</span>
									<!--<span class="price">34,500</span>-- >
									<span class="price">
										29,325
										<!--<span class="dc_price">
											<s class="del_price">34,500</s> (15%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">34,500</s> (15%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-- >
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1175938"><img src="http://image.etah.co.kr/goods/1175938/199_20170807155714_crock500_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1175938/199_20170807155714_crock500_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1175938','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1175938','http://image.etah.co.kr/goods/1175938/199_20170807155714_crock500_300.jpg','[르크루제] 스톤웨어 조리기구통 1P');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1175938','','[르크루제] 스톤웨어 조리기구통 1P');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1175938','http://image.etah.co.kr/goods/1175938/199_20170807155714_crock500_300.jpg','[르크루제] 스톤웨어 조리기구통 1P');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										르크루제
									</span>
									<span class="name">[르크루제] 스톤웨어 조리기구통 1P</span>
									<!--<span class="price">27,900</span>-- >
									<span class="price">
										23,715
										<!--<span class="dc_price">
											<s class="del_price">27,900</s> (15%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">27,900</s> (15%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-->
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1247573"><img src="http://image.etah.co.kr/goods/1247573/103294_1_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1247573/103294_1_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1247573','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1247573','http://image.etah.co.kr/goods/1247573/103294_1_300.jpg','바디판타지 바디미스트 236ml 모음 (택 1)');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1247573','','바디판타지 바디미스트 236ml 모음 (택 1)');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1247573','http://image.etah.co.kr/goods/1247573/103294_1_300.jpg','바디판타지 바디미스트 236ml 모음 (택 1)');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										바디판타지									</span>
									<span class="name">바디판타지 바디미스트 236ml 모음 (택 1)</span>
									<!--<span class="price">14,900</span>-- >
									<span class="price">
										11,622
										<!--<span class="dc_price">
											<s class="del_price">14,900</s> (22%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">14,900</s> (22%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-- >
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1136965"><img src="http://image.etah.co.kr/goods/1136965/0327125840_58d88df0cb0dem_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1136965/0327125840_58d88df0cb0dem_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1136965','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1136965','http://image.etah.co.kr/goods/1136965/0327125840_58d88df0cb0dem_300.jpg','[STUDIO M] 소보카이 캬드레 8인치 플레이트 색상 4종 택1 스튜디오엠 107516');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1136965','','[STUDIO M] 소보카이 캬드레 8인치 플레이트 색상 4종 택1 스튜디오엠 107516');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1136965','http://image.etah.co.kr/goods/1136965/0327125840_58d88df0cb0dem_300.jpg','[STUDIO M] 소보카이 캬드레 8인치 플레이트 색상 4종 택1 스튜디오엠 107516');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										스튜디오 엠(일본직구)
									</span>
									<span class="name">[STUDIO M] 소보카이 캬드레 8인치 플레이트 색상 4종 택1 스튜디오엠 107516</span>
									<!--<span class="price">27,100</span>-- >
									<span class="price">
										26,016
										<!--<span class="dc_price">
											<s class="del_price">27,100</s> (4%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">27,100</s> (4%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-- >
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
							<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1248871"><img src="http://image.etah.co.kr/goods/1248871/109527_1_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1248871/109527_1_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1248871','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1248871','http://image.etah.co.kr/goods/1248871/109527_1_300.jpg','주물손잡이/원형세로판/골드');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1248871','','주물손잡이/원형세로판/골드');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1248871','http://image.etah.co.kr/goods/1248871/109527_1_300.jpg','주물손잡이/원형세로판/골드');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										바이핸즈									</span>
									<span class="name">주물손잡이/원형세로판/골드</span>
									<!--<span class="price">32,540</span>-- >
									<span class="price">
										29,611
										<!--<span class="dc_price">
											<s class="del_price">32,540</s> (9%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">32,540</s> (9%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-- >
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
														<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1224509"><img src="http://image.etah.co.kr/goods/1224509/1101090428400m_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1224509/1101090428400m_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1224509','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1224509','http://image.etah.co.kr/goods/1224509/1101090428400m_300.jpg','[francfranc] 아도무 머그컵 2종 세트 프랑프랑 1101090428404');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1224509','','[francfranc] 아도무 머그컵 2종 세트 프랑프랑 1101090428404');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1224509','http://image.etah.co.kr/goods/1224509/1101090428400m_300.jpg','[francfranc] 아도무 머그컵 2종 세트 프랑프랑 1101090428404');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										프랑프랑(일본직구)
									</span>
									<span class="name">[francfranc] 아도무 머그컵 2종 세트 프랑프랑 1101090428404</span>
									<!--<span class="price">26,600</span>-- >
									<span class="price">
										25,500
										<!--<span class="dc_price">
										<s class="del_price">26,600</s> (4%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">26,600</s> (4%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-- >
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
														<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1174110"><img src="http://image.etah.co.kr/goods/1174110/105050_1_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1174110/105050_1_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1174110','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1174110','http://image.etah.co.kr/goods/1174110/105050_1_300.jpg','한일스텐레스 발레리 삼중바닥 스텐냄비 양수18cm');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1174110','','한일스텐레스 발레리 삼중바닥 스텐냄비 양수18cm');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1174110','http://image.etah.co.kr/goods/1174110/105050_1_300.jpg','한일스텐레스 발레리 삼중바닥 스텐냄비 양수18cm');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">
										한일스텐레스									</span>
									<span class="name">한일스텐레스 발레리 삼중바닥 스텐냄비 양수18cm</span>
									<!--<span class="price">23,000</span>-- >
									<span class="price">
										18,400
										<!--<span class="dc_price">
										<s class="del_price">23,000</s> (20%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-- >
										<span class="dc_price">
											<s class="del_price">23,000</s> (20%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-- >
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
														<li class="goods_item">
								<div class="img">
									<!--<a href="/goods/detail/1167588"><img src="http://image.etah.co.kr/goods/1167588/100203_1_300.jpg" alt=""></a>-- >
									<a href="/goods/best_item"><img src="http://image.etah.co.kr/goods/1167588/100203_1_300.jpg" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-- >
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','1167588','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','1167588','http://image.etah.co.kr/goods/1167588/100203_1_300.jpg','물에빠진 조각벽지 (낱장) -스트라이프 MZ020-A');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','1167588','','물에빠진 조각벽지 (낱장) -스트라이프 MZ020-A');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-- >
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','1167588','http://image.etah.co.kr/goods/1167588/100203_1_300.jpg','물에빠진 조각벽지 (낱장) -스트라이프 MZ020-A');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="/goods/best_item" class="goods_item_link">
									<span class="brand">물에빠진벽지</span>
									<span class="name">물에빠진 조각벽지 (낱장) -스트라이프 MZ020-A</span>
									<!--<span class="price">1,420</span>-- >
									<span class="price">
										1,420
										<!--<span class="spr-common spr_ico_mileage"></span>-- >
									</span>
								</a>
							</li>
						</ul>
					</div> -->
					<div id="etahsChoice" class="main_goods_list">
						<ul class="goods_list">
							<!-- 요청에 의해 가격 강제 숨김 클래스 main_goods_list 제거 -->
							<?foreach($etah_choice as $erow){?>
							<li class="goods_item">
								<div class="img">
									<a href="<?=$erow['LINK_URL']?>"><img src="<?=$erow['IMG_URL']?>" width="290" height="290" alt=""></a>
									<ul class="goods_action_menu">
										<!--<li class="goods_action_item">
											<button type="button" class="action_btn">
												<span class="spr-common spr_cart"></span>
												<span class="spr-common spr-bgcircle2"></span>
												<span class="button_text">Add Cart</span>
											</button>
										</li>-->
										<li class="goods_action_item">
											<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$erow['GOODS_CD']?>','','');">
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
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$erow['GOODS_CD']?>','<?=$erow['IMG_URL']?>','<?=$erow['NAME']?>');">
														<span class="spr-common spr_share_pinter"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">핀터레스트</span>
													</button>
												</li>
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$erow['GOODS_CD']?>','','<?=$erow['NAME']?>');">
														<span class="spr-common spr_share_kakao"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">카카오스토리</span>
													</button>
												</li>
												<!--<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
														<span class="spr-common spr_share_insta"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">인스타</span>
													</button>
												</li>-->
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$erow['GOODS_CD']?>','<?=$erow['IMG_URL']?>','<?=$erow['NAME']?>');">
														<span class="spr-common spr_share_facebook"></span>
														<span class="spr-common spr-bgcircle3"></span>
														<span class="button_text">페이스북</span>
													</button>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<a href="<?=$erow['LINK_URL']?>" class="goods_item_link">
									<span class="brand">
										<?=$erow['BRAND_NM']?>
									</span>
									<span class="name"><?=$erow['NAME']?></span>
									<!--<span class="price"><?=number_format($erow['SELLING_PRICE'])?></span>-->
									<span class="price">
										<?
										if($erow['COUPON_CD']){
											$price = $erow['SELLING_PRICE'] - $erow['RATE_PRICE'] - $erow['AMT_PRICE'];
											echo number_format($price);

											/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
											$sale_percent = (($erow['SELLING_PRICE'] - $price)/$erow['SELLING_PRICE']*100);
											$sale_percent = strval($sale_percent);
											$sale_percent_array = explode('.',$sale_percent);
											$sale_percent_string = $sale_percent_array[0];
										?>
										<!--<span class="dc_price">
											<s class="del_price"><?=number_format($erow['SELLING_PRICE'])?></s> (<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>-->
										<span class="dc_price">
											<s class="del_price"><?=number_format($erow['SELLING_PRICE'])?></s> (<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<!--<span class="spr-common spr_ico_coupon"></span>-->
										<?}else{
											echo number_format($erow['SELLING_PRICE']);
										}
										?>
										<!--<span class="spr-common spr_ico_mileage"></span>-->
									</span>
								</a>
							</li>
							<?}?>
						</ul>
					</div>
				</div>

				<div class="collection_area" id="collectionBlock">
					<h4 class="title_style"><?=$collection_t[0]['NAME'] ? $collection_t[0]['NAME'] : "COLLECTION"?></h4>
					<div class="collection_wrap">
						<ul class="collection_list" id="collection_list">

						</ul>
						<div class="drag_controller">
							<div class="drag_area">
								<div type="button" class="drag_btn" style="left:575px;" id="dragBtn"><img src="/assets/images/display/btn_drag.png" alt=""></div>
								<div class="line" id="dragLine"></div>
							</div>
						</div>
						<?foreach($collection as $crow){?>
						<input type="hidden" name="LINK_URL[]"			value="<?=$crow['LINK_URL']?>">
						<input type="hidden" name="IMG_URL[]"			value="<?=$crow['IMG_URL']?>">
						<input type="hidden" name="BRAND_NM[]"			value="<?=$crow['BRAND_NM']?>">
						<input type="hidden" name="GOODS_CD[]"			value="<?=$crow['GOODS_CD']?>">
						<input type="hidden" name="NAME[]"				value="<?=$crow['NAME']?>">
						<input type="hidden" name="SELLING_PRICE[]"		value="<?=number_format($crow['SELLING_PRICE'])?>">
						<input type="hidden" name="PROMOTION_PHRASE[]"	value="<?=$crow['PROMOTION_PHRASE']?>">
						<?}?>
					</div>
				</div>

				<div class="magazine_area">
					<h4 class="title_style">MAGAZINE</h4>
					<ul class="main_magazine_list">
						<?foreach($magazine as $mrow){?>
						<li class="main_magazine_item">
							<a href="<?=$mrow['LINK_URL']?>" class="main_magazine_link">
								<img src="<?=$mrow['MAGAZINE_IMG_URL']?>" alt="배너이미지" width="290" height="290" onerror="this.src='/assets/images/data/main_magazin_6.jpg'" class="lazy-img" data-origin="<?=$mrow['MAGAZINE_IMG_URL']?>" data-origin="" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand"><?=$mrow['NAME'][0]?></em>
									<?if(isset($mrow['NAME'][1])){?>
									<span class="main_magazine_explain">2016 인디룸 출시기념 이벤트</span>
									<?}?>
								</span>
							</a>
						</li>
						<?}?>
						<!--<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_2.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">MOBEL-CARPENTER</em>
									<span class="main_magazine_explain">발수원단</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_3.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">DOMODESIGN</em>
									<span class="main_magazine_explain">원목가구</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_4.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">CHAIR GUIDE</em>
									<span class="main_magazine_explain">의자 가이드</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_5.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">BLOOMINGNME</em>
									<span class="main_magazine_explain">블루밍앤미 40% 할인 이벤트</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_6.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">JOEUNAMU</em>
									<span class="main_magazine_explain">사람과 공간이 어우러지는 가구</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_7.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">INTHEROOM</em>
									<span class="main_magazine_explain">2016 인디룸 출시기념 이벤트</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_8.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">MOBEL-CARPENTER</em>
									<span class="main_magazine_explain">발수원단</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_3.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">DOMODESIGN</em>
									<span class="main_magazine_explain">원목가구</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_4.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">CHAIR GUIDE</em>
									<span class="main_magazine_explain">의자 가이드</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_5.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">BLOOMINGNME</em>
									<span class="main_magazine_explain">블루밍앤미 40% 할인 이벤트</span>
								</span>
							</a>
						</li>
						<li class="main_magazine_item">
							<a href="#" class="main_magazine_link">
								<img src="/assets/images/data/main_magazin_6.jpg" alt="배너이미지" />
								<span class="main_magazine_text">
									<em class="main_magazine_brand">JOEUNAMU</em>
									<span class="main_magazine_explain">사람과 공간이 어우러지는 가구</span>
								</span>
							</a>
						</li>-->
					</ul>
					<a href="/magazine" class="btn_more">more <span class="spr-common spr_arrow_right"></span></a>
				</div>

				<div class="brand_area">
					<ul class="main_brand_tab_list">
						<li class="main_brand_tab_item_01 active" id="main_brand_tab_item_01">
							<!--<a href="#mainBrandCont01">-->
							<a href="javaScript:changeBrandTab(1);">
								<img src="<?=$brand_menu[0]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
								<span class="main_brand_tab_line"></span>
							</a>
						</li>
						<li class="main_brand_tab_item_02" id="main_brand_tab_item_02">
							<a href="javaScript:changeBrandTab(2);">
								<img src="<?=$brand_menu[1]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
								<span class="main_brand_tab_line"></span>
							</a>
						</li>
						<li class="main_brand_tab_item_03" id="main_brand_tab_item_03">
							<a href="javaScript:changeBrandTab(3);">
								<img src="<?=$brand_menu[2]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
								<span class="main_brand_tab_line"></span>
							</a>
						</li>
						<li class="main_brand_tab_item_04" id="main_brand_tab_item_04">
							<a href="javaScript:changeBrandTab(4);">
								<img src="<?=$brand_menu[3]['IMG_URL']?>" alt="브랜드 로고" width="220" height="56"/>
								<span class="main_brand_tab_line"></span>
							</a>
						</li>
					</ul>
					<!-- mainBrandCont01 // -->

					<?
					$bRand = rand(1,3);
					$bTitle = "";
					$arr_brand = array();

					switch($bRand){
						case '1' :	$bTItle = "";
									$arr_brand[0] = 3;
									$arr_brand[1] = 6;		break;
						case '2' :	$bTItle = "main_brand_list__type02";
									$arr_brand[0] = 1;
									$arr_brand[1] = 8;		break;
						case '3' :	$bTItle = "main_brand_list__type03";
									$arr_brand[0] = 2;
									$arr_brand[1] = 7;		break;
					}
					?>
					<ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont01" style="display: block;">

						<?
						$bidx = 1;
						foreach($brand as $b1){
						if($b1['GUBUN'] == 'MAIN_BRAND1'){
							if($b1['SEQ'] > 0){?>
						<li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
							<a href="<?=$b1['LINK_URL']?>" class="main_brand_link">
								<span class="main_brand_img"><img src="<?=$b1['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>"  onerror="this.src='/assets/images/data/no_images.jpg'"/></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b1['BRAND_NM']?></em>
										<span class="text"><?=$b1['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b1['COUPON_CD']){
										$price = $b1['SELLING_PRICE'] - $b1['RATE_PRICE'] - $b1['AMT_PRICE'];

										/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
										$sale_percent = (($b1['SELLING_PRICE'] - $price)/$b1['SELLING_PRICE']*100);
										$sale_percent = strval($sale_percent);
										$sale_percent_array = explode('.',$sale_percent);
										$sale_percent_string = $sale_percent_array[0];
									?>
										<span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b1['SELLING_PRICE'])?></s> (<?=floor((($b1['SELLING_PRICE']-$price)/$b1['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b1['SELLING_PRICE'])?></s> (<?=floor((($b1['SELLING_PRICE']-$price)/$b1['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
									<?}else{
										echo number_format($price = $b1['SELLING_PRICE']);
									}?>
									</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<?
						$bidx++;
								}
							}
						}?>
						<!--<li class="main_brand_item_02">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_2.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_03">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_609x609_1.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_04">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_3.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_05">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_4.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_06">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_609x609_2.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_07">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_5.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_08">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_6.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_09">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_7.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<li class="main_brand_item_10">
							<a href="#" class="main_brand_link">
								<span class="main_brand_img"><img src="http://ui.etah.co.kr/assets/images/data/goods_304x304_8.jpg" alt="배너이미지" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand">Jackson chameleon</em>
										<span class="text">Real Sied Board</span>
								</span>
								<strong class="main_brand_price">320,000</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>-->
					</ul>
					<!-- // mainBrandCont01 -->

					<!-- mainBrandCont02 // -->

					<?
					$bRand = rand(1,3);
					$bTitle = "";
					$arr_brand = array();

					switch($bRand){
						case '1' :	$bTItle = "";
									$arr_brand[0] = 3;
									$arr_brand[1] = 6;		break;
						case '2' :	$bTItle = "main_brand_list__type02";
									$arr_brand[0] = 1;
									$arr_brand[1] = 8;		break;
						case '3' :	$bTItle = "main_brand_list__type03";
									$arr_brand[0] = 2;
									$arr_brand[1] = 7;		break;
					}
					?>
					<ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont02">
						<?
						$bidx = 1;
						foreach($brand as $b2){
						if($b2['GUBUN'] == 'MAIN_BRAND2'){
							if($b2['SEQ'] > 0){?>

						<li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
							<a href="<?=$b2['LINK_URL']?>" class="main_brand_link">
								<span class="main_brand_img"><img src="<?=$b2['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" onerror="this.src='/assets/images/data/no_images.jpg'"/></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b2['BRAND_NM']?></em>
										<span class="text"><?=$b2['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b2['COUPON_CD']){
										$price = $b2['SELLING_PRICE'] - $b2['RATE_PRICE'] - $b2['AMT_PRICE'];

										/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
										$sale_percent = (($b2['SELLING_PRICE'] - $price)/$b2['SELLING_PRICE']*100);
										$sale_percent = strval($sale_percent);
										$sale_percent_array = explode('.',$sale_percent);
										$sale_percent_string = $sale_percent_array[0];
									?>
										<span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b2['SELLING_PRICE'])?></s> (<?=floor((($b2['SELLING_PRICE']-$price)/$b2['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b2['SELLING_PRICE'])?></s> (<?=floor((($b2['SELLING_PRICE']-$price)/$b2['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
									<?}else{
										echo number_format($price = $b2['SELLING_PRICE']);
									}?>
									</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<?
						$bidx++;
								}
							}
						}?>
					</ul>
					<!-- // mainBrandCont02 -->

					<!-- mainBrandCont03 // -->

					<?
					$bRand = rand(1,3);
					$bTitle = "";
					$arr_brand = array();

					switch($bRand){
						case '1' :	$bTItle = "";
									$arr_brand[0] = 3;
									$arr_brand[1] = 6;		break;
						case '2' :	$bTItle = "main_brand_list__type02";
									$arr_brand[0] = 1;
									$arr_brand[1] = 8;		break;
						case '3' :	$bTItle = "main_brand_list__type03";
									$arr_brand[0] = 2;
									$arr_brand[1] = 7;		break;
					}
					?>
					<ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont03">
						<?
						$bidx = 1;
						foreach($brand as $b3){
						if($b3['GUBUN'] == 'MAIN_BRAND3'){
							if($b3['SEQ'] > 0){?>

						<li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
							<a href="<?=$b3['LINK_URL']?>" class="main_brand_link">
								<span class="main_brand_img"><img src="<?=$b3['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" onerror="this.src='/assets/images/data/no_images.jpg'" /></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b3['BRAND_NM']?></em>
										<span class="text"><?=$b3['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b3['COUPON_CD']){
										$price = $b3['SELLING_PRICE'] - $b3['RATE_PRICE'] - $b3['AMT_PRICE'];

										/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
										$sale_percent = (($b3['SELLING_PRICE'] - $price)/$b3['SELLING_PRICE']*100);
										$sale_percent = strval($sale_percent);
										$sale_percent_array = explode('.',$sale_percent);
										$sale_percent_string = $sale_percent_array[0];
									?>
										<span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b3['SELLING_PRICE'])?></s> (<?=floor((($b3['SELLING_PRICE']-$price)/$b3['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b3['SELLING_PRICE'])?></s> (<?=floor((($b3['SELLING_PRICE']-$price)/$b3['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
									<?}else{
										echo number_format($price = $b3['SELLING_PRICE']);
									}?>
									</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<?
						$bidx++;
								}
							}
						}?>

					</ul>
					<!-- // mainBrandCont03 -->

					<!-- mainBrandCont04 // -->
					<?
					$bRand = rand(1,3);
					$bTitle = "";
					$arr_brand = array();

					switch($bRand){
						case '1' :	$bTItle = "";
									$arr_brand[0] = 3;
									$arr_brand[1] = 6;		break;
						case '2' :	$bTItle = "main_brand_list__type02";
									$arr_brand[0] = 1;
									$arr_brand[1] = 8;		break;
						case '3' :	$bTItle = "main_brand_list__type03";
									$arr_brand[0] = 2;
									$arr_brand[1] = 7;		break;
					}
					?>
					<ul class="main_brand_list <?=$bTItle?>" id="mainBrandCont04">
						<?
						$bidx = 1;
						foreach($brand as $b4){
						if($b4['GUBUN'] == 'MAIN_BRAND4'){
							if($b4['SEQ'] > 0){?>

						<li class="main_brand_item_<?=$bidx < 10 ? "0".$bidx : $bidx?>">
							<a href="<?=$b4['LINK_URL']?>" class="main_brand_link">
								<span class="main_brand_img"><img src="<?=$b4['IMG_URL']?>" alt="배너이미지" width="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" height="<?=in_array($bidx,$arr_brand) ? "609" : "304" ?>" onerror="this.src='/assets/images/data/no_images.jpg'"/></span>
								<span class="main_brand_info">
									<span class="main_brand_text">
										<em class="brand"><?=$b4['BRAND_NM']?></em>
										<span class="text"><?=$b4['NAME']?></span>
									</span>
									<strong class="main_brand_price">
									<?if($b4['COUPON_CD']){
										$price = $b4['SELLING_PRICE'] - $b4['RATE_PRICE'] - $b4['AMT_PRICE'];

										/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
										$sale_percent = (($b4['SELLING_PRICE'] - $price)/$b4['SELLING_PRICE']*100);
										$sale_percent = strval($sale_percent);
										$sale_percent_array = explode('.',$sale_percent);
										$sale_percent_string = $sale_percent_array[0];
									?>
										<span class="discount"><?=number_format($price)?></span>
										<!--<span class="dc_price"><s class="del_price"><?=number_format($b4['SELLING_PRICE'])?></s> (<?=floor((($b4['SELLING_PRICE']-$price)/$b4['SELLING_PRICE'])*100)?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>-->
										<span class="dc_price"><s class="del_price"><?=number_format($b4['SELLING_PRICE'])?></s> (<?=floor((($b4['SELLING_PRICE']-$price)/$b4['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)</span>
									<?}else{
										echo number_format($price = $b4['SELLING_PRICE']);
									}?>
									</strong>
								</span>
								<span class="main_brand_line"></span>
								<span class="main_brand_info_bg"></span>
							</a>
						</li>
						<?
						$bidx++;
								}
							}
						}?>

					</ul>
					<!-- // mainBrandCont04 -->
				</div>

				<!--2018-01-29 김지혜 레이어팝업 수정 -->
				<!-- 메인프로모션 레이어 // -->
				<div class="layer layer__view layer_main01" id="layer_main_pop01" style="visibility:hidden">
					<div class="layer_inner">
						<div class="layer_cont">
							<!-- <div class="banner01">
								<img src="/assets/images/data/180116_main_popup_01.jpg" alt="">
								<a href="/mywiz" target="_blank" class="btn-link01"><img src="/assets/images/data/180116_btn_popup01.png" alt=""></a>
							</div>
							<div class="banner01">
								<!-- <img src="/assets/images/data/180116_main_popup_02.jpg" alt=""> - ->
								<img src="/assets/images/data/180117_main_popup_02.jpg" alt="">
								<a href="/goods/event/66" target="_blank" class="btn-link01"><img src="/assets/images/data/180116_btn_popup02.png" alt=""></a>
							</div> -->
							<a href="/mywiz"><img src="/assets/images/data/180124_coupon_banner_2.jpg" alt=""></a>
							<!-- <a href="/goods/event/66"><img src="/assets/images/data/180124_coupon_banner_3.jpg" alt=""></a> -->
							<a href="/goods/event/66"><img src="/assets/images/data/main_popup_2.jpg" alt=""></a>
						</div>
						<div class="bottom-wrap">
							<div class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formMainClose"> <label class="checkbox_label" for="formMainClose">오늘 하루 열지 않음</label>
							</div>
							<a href="#layer_main_pop01" id="full_layer_close" data-ui="layer-closer" class="spr-common btn_close">닫기 X</a>
						</div>
						<!-- <a href="#layer_main_pop01" data-ui="layer-closer" class="spr-common layer_close" title="레이어 닫기"></a> -->
					</div>
				</div>
				<!-- // 메인프로모션 레이어 -->

				<!--20171213 이진호 레이어팝업 추가 -->
				<!-- <div class="layer layer__view layer_main01" id="layer_main_pop01" style="visibility:hidden">
					<div class="layer_inner">
						<div class="layer_cont">
							<img src="/assets/images/data/main_popup_01.jpg" usemap="#001" alt="">
						</div>
						<div class="bottom-wrap">
							<div class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formMainClose"> <label class="checkbox_label" for="formMainClose">오늘 하루 열지 않음</label>
							</div>
							<a href="#layer_main_pop01" id="full_layer_close" data-ui="layer-closer" class="spr-common btn_close">닫기 X</a>
						</div>
				
					</div>
				</div>

				<map name="001">
					<area shape="rect" coords="0,540,466,598" href="/mywiz" target="_blank">
				</map>
				-->

			</div>

				<!--<div class="sns_area">
					<h4 class="title_style">SNS</h4>
					<div class="sns_block">
						<ul class="sns_list" style="width:2170px;">
							<li class="sns_item" style="margin-left:-125px;">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_1.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
							<li class="sns_item">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_2.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
							<li class="sns_item">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_3.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
							<li class="sns_item">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_4.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
							<li class="sns_item">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_5.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
							<li class="sns_item">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_6.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
							<li class="sns_item">
								<a href="#">
									<span class="img"><img src="/assets/images/data/sns_7.jpg" alt=""></span>
									<span class="user_name">cho***</span>
									<span class="title">흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파흑백의 앙상블로 이루어진 소파</span>
								</a>
							</li>
						</ul>
					</div>
					<div class="drag_controller">
						<div class="drag_area">
							<button type="button" class="drag_btn" style="left:575px;"><img src="/assets/images/display/btn_drag.png" alt=""></button>
							<div class="line"></div>
						</div>
					</div>
				</div>
			</div>-->

			<script src="/assets/js/common.js"></script>
			<script type="text/javascript">
			//========================================
			//오늘 하루 창 닫기
			//========================================
			$(document).ready(function() {
				//alert($.cookie('layer_main_pop01'));
				if($.cookie('layer_main_pop01') != 'hidden'){
					$('#layer_main_pop01').show();
					$('#layer_main_pop01').css('visibility','visible');
					//console.log(true);
				}else{
					$('#layer_main_pop01').hide();
				}

				$('#full_layer_close').click(function() {		 
					var chkd = $("#formMainClose").is(":checked");
					if(chkd){
						$.cookie('layer_main_pop01', 'hidden', {expires : 1});
					}
					$('#layer_main_pop01').hide();
				}); 
			});

			//========================================
			//천단위 콤마
			//========================================
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

			//=====================================
		    // NEW ITEM, BRAND 탭 변경
			//=====================================
			function changeItemBrandTab(val){
				var brandCont = $('#newBrand');
				if (val == 'B')
				{
					$('#main_tab_brand').addClass('active');
					$('#main_tab_item').removeClass('active');
					if (!brandCont.data('html'))
					{
						brandCont.html($('#newBrandHtml').html());
						brandCont.data('html', true);
					}
					$('#newBrand').css("display", "");
					$('#newItem').css("display", "none");

				}
				else
				{
					$('#main_tab_item').addClass('active');
					$('#main_tab_brand').removeClass('active');
					$('#newItem').css("display", "");
					$('#newBrand').css("display", "none");
				}
			}

			//=====================================
		    // BEST ITEM, CHOICE 탭 변경
			//=====================================
			function getEtahChoice(val){
				//if(val == 'B'){
				///	$('#bestItem_li').addClass('active');
				////	$('#etahsChoice_li').removeClass('active');
				//	$('#bestItem').css("display","");
				//	$('#etahsChoice').css("display","none");

				//}else{
				//	$('#bestItem_li').removeClass('active');
					$('#etahsChoice_li').addClass('active');
				//	$('#bestItem').css("display","none");
					$('#etahsChoice').css("display","block");
				//}
			}

			</script>

			<script id="showRoom-template" type="text/x-handlebars-template">

				<div class="goods_img">
					<img src="{{src}}" width="120" height="120" alt="">
				</div>
				<span class="brand">
				{{brand}}
				</span>
				<span class="name">{{name}}</span>
				<span class="price">{{price}}</span>
				<a href="{{link}}" class="goods_link">Detail View <span class="spr-common spr_arrow_right"></span></a>

			</script>

			<script id="collection-template" type="text/x-handlebars-template">
				{{#list}}
				<li class="collection_item">
					<span class="collection_img"><img src="{{src}}" alt="" width="440" height="440"></span>
					<div class="collection_info">
						<span class="title">{{brand}}</span>
						<span class="option">{{name}}</span>
						<strong class="price js-price">

					</strong> {{#if info}}
						<span class="info">Information</span>
						<span class="info_text">{{{info}}}</span> {{/if}}
						<a href="{{link}}" class="btn_detail_view">Detail View<span class="spr-common spr_arrow_right"></span></a>
					</div>
				</li>
				{{/list}}
			</script>

		<script>
			var cnt_collection = "<?=count($collection)?>";
//			alert(cnt_collection);

//			for(i=0; i<cnt_collection; i++){
//
//			}

			var aJsonArray = new Array();
			var aJson = new Object();

//			aJson.link = "<?=$collection[0]['LINK_URL']?>";
//			aJson.src = "<?=$collection[0]['IMG_URL']?>";
//			aJson.brnad = "<?=$collection[0]['BRAND_NM']?>";
//			aJson.name = "<?=$collection[0]['NAME']?>";
//			aJson.price = "<?=number_format($collection[0]['SELLING_PRICE'])?>";
//			aJson.info = "<?=$collection[0]['PROMOTION_PHRASE']?>";
//
//			aJsonArray.push(aJson);
//
//			aJson.link = "<?=$collection[1]['LINK_URL']?>";
//			aJson.src = "<?=$collection[1]['IMG_URL']?>";
//			aJson.brnad = "<?=$collection[1]['BRAND_NM']?>";
//			aJson.name = "<?=$collection[1]['NAME']?>";
//			aJson.price = "<?=number_format($collection[1]['SELLING_PRICE'])?>";
//			aJson.info = "<?=$collection[1]['PROMOTION_PHRASE']?>";
//
//			aJsonArray.push(aJson);
//
//			aJson.link = "<?=$collection[2]['LINK_URL']?>";
//			aJson.src = "<?=$collection[2]['IMG_URL']?>";
//			aJson.brnad = "<?=$collection[2]['BRAND_NM']?>";
//			aJson.name = "<?=$collection[2]['NAME']?>";
//			aJson.price = "<?=number_format($collection[2]['SELLING_PRICE'])?>";
//			aJson.info = "<?=$collection[2]['PROMOTION_PHRASE']?>";
//
//			aJsonArray.push(aJson);
//
//			aJson.link = "<?=$collection[3]['LINK_URL']?>";
//			aJson.src = "<?=$collection[3]['IMG_URL']?>";
//			aJson.brnad = "<?=$collection[3]['BRAND_NM']?>";
//			aJson.name = "<?=$collection[3]['NAME']?>";
//			aJson.price = "<?=number_format($collection[3]['SELLING_PRICE'])?>";
//			aJson.info = "<?=$collection[3]['PROMOTION_PHRASE']?>";
//
//			aJsonArray.push(aJson);

//			aJson = {
//							link : "<?=$collection[0]['LINK_URL']?>",
//							src : "<?=$collection[0]['IMG_URL']?>",
//							brnad : "<?=$collection[0]['BRAND_NM']?>",
//							name : "<?=$collection[0]['NAME']?>",
//							price : "<?=number_format($collection[0]['SELLING_PRICE'])?>",
//							info : "<?=$collection[0]['PROMOTION_PHRASE']?>"
//			}
//
//			aJsonArray.push(aJson);
//
//			aJson = {
//							link : "<?=$collection[1]['LINK_URL']?>",
//							src : "<?=$collection[1]['IMG_URL']?>",
//							brnad : "<?=$collection[1]['BRAND_NM']?>",
//							name : "<?=$collection[1]['NAME']?>",
//							price : "<?=number_format($collection[1]['SELLING_PRICE'])?>",
//							info : "<?=$collection[1]['PROMOTION_PHRASE']?>"
//			}
//
//			aJsonArray.push(aJson);
//
//			aJson = {
//							link : "<?=$collection[2]['LINK_URL']?>",
//							src : "<?=$collection[2]['IMG_URL']?>",
//							brnad : "<?=$collection[2]['BRAND_NM']?>",
//							name : "<?=$collection[2]['NAME']?>",
//							price : "<?=number_format($collection[2]['SELLING_PRICE'])?>",
//							info : "<?=$collection[2]['PROMOTION_PHRASE']?>"
//			}
//
//			aJsonArray.push(aJson);
//
//			aJson = {
//							link : "<?=$collection[3]['LINK_URL']?>",
//							src : "<?=$collection[3]['IMG_URL']?>",
//							brnad : "<?=$collection[3]['BRAND_NM']?>",
//							name : "<?=$collection[3]['NAME']?>",
//							price : "<?=number_format($collection[3]['SELLING_PRICE'])?>",
//							info : "<?=$collection[3]['PROMOTION_PHRASE']?>"
//			}
//
//			aJsonArray.push(aJson);

			for(i=0; i<cnt_collection; i++){
				dc = OpGoods_price(document.getElementsByName("GOODS_CD[]")[i].value)['coupon_price'];

//				alert(OpGoods_price(document.getElementsByName("GOODS_CD[]")[i].value)['coupon_price']);

				aJson = {
							link : document.getElementsByName("LINK_URL[]")[i].value,
							src : document.getElementsByName("IMG_URL[]")[i].value,
							brnad : document.getElementsByName("BRAND_NM[]")[i].value,
							name : document.getElementsByName("NAME[]")[i].value,
							price : document.getElementsByName("SELLING_PRICE[]")[i].value,
							dc_price : numberFormat(dc),
							info : document.getElementsByName("PROMOTION_PHRASE[]")[i].value
				};

				aJsonArray.push(aJson);
			}




//			var sJson = JSON.stringify(aJson);

//			alert(sJson);

			var collectionData = {
				list : 	aJsonArray

			};


//			var collectionData = {
//				list: [
//				{
//					'link': "<?=$collection[0]['LINK_URL']?>",
//					'src': "<?=$collection[0]['IMG_URL']?>",
//					'brnad': "<?=$collection[0]['BRAND_NM']?>",
//					'name': "<?=$collection[0]['NAME']?>",
//					'price': "<?=number_format($collection[0]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[0]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[1]['LINK_URL']?>",
//					'src': "<?=$collection[1]['IMG_URL']?>",
//					'brnad': "<?=$collection[1]['BRAND_NM']?>",
//					'name': "<?=$collection[1]['NAME']?>",
//					'price': "<?=number_format($collection[1]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[1]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[2]['LINK_URL']?>",
//					'src': "<?=$collection[2]['IMG_URL']?>",
//					'brnad': "<?=$collection[2]['BRAND_NM']?>",
//					'name': "<?=$collection[2]['NAME']?>",
//					'price': "<?=number_format($collection[2]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[2]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[3]['LINK_URL']?>",
//					'src': "<?=$collection[3]['IMG_URL']?>",
//					'brnad': "<?=$collection[3]['BRAND_NM']?>",
//					'name': "<?=$collection[3]['NAME']?>",
//					'price': "<?=number_format($collection[3]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[3]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[4]['LINK_URL']?>",
//					'src': "<?=$collection[4]['IMG_URL']?>",
//					'brnad': "<?=$collection[4]['BRAND_NM']?>",
//					'name': "<?=$collection[4]['NAME']?>",
//					'price': "<?=number_format($collection[4]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[4]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[5]['LINK_URL']?>",
//					'src': "<?=$collection[5]['IMG_URL']?>",
//					'brnad': "<?=$collection[5]['BRAND_NM']?>",
//					'name': "<?=$collection[5]['NAME']?>",
//					'price': "<?=number_format($collection[5]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[5]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[6]['LINK_URL']?>",
//					'src': "<?=$collection[6]['IMG_URL']?>",
//					'brnad': "<?=$collection[6]['BRAND_NM']?>",
//					'name': "<?=$collection[6]['NAME']?>",
//					'price': "<?=number_format($collection[6]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[6]['PROMOTION_PHRASE']?>"
//				},
//				{
//					'link': "<?=$collection[7]['LINK_URL']?>",
//					'src': "<?=$collection[7]['IMG_URL']?>",
//					'brnad': "<?=$collection[7]['BRAND_NM']?>",
//					'name': "<?=$collection[7]['NAME']?>",
//					'price': "<?=number_format($collection[7]['SELLING_PRICE'])?>",
//					'info': "<?=$collection[7]['PROMOTION_PHRASE']?>"
//				}
//				]
//			};

			/*
				-- YIC 쪽 http://www.etah.co.kr/assets/js2/goods_func.js 의 OpGoods_price 를 참고하여 신규 작성.
				-- callback 함수를 호출 할 수 있도록 수정.
				-- ui.etah 에서는 동작 하지 않음.
				-- dev 혹은 real 에 올라가야 확인이 가능.....
			*/
			function OpGoods_price__call(goods_code, callback)
			{
				$.ajax(
				{
					type: 'POST',
					async: false,
					url: '/goods/goods_price',
					dataType: 'json',
					data:
					{
						goods_code: goods_code
					},
					error: function(res)
					{
						alert('Database Error');

						// locall test code S
						// var price = {
						// 	'selling_price' : 16000, // 판매가
						// 	'coupon_price'  : 14000 // 할인적용가 / 할인적용가가 없을 경우 0
						// };
						// if( callback ) {
						// 	callback ( price );
						// }
						// else {
						// 	return price;
						// }
						// locall test code E
					},
					success: function(res)
					{
						if (res.status == 'ok')
						{
							var price = {
								'selling_price': res.selling_price, // 판매가
								'coupon_price': res.coupon_price // 할인적용가 / 할인적용가가 없을 경우 0
							};
							if (callback)
							{
								callback(price);
							}
							else
							{
								return price;
							}
						}
						else alert(res.message);
					}
				});
			};

			function newItemPriceInsert(_data)
			{
				if (!_data) return false;
				var data = _data,
					$box = $('#newItem'),
					$priceAreas = $box.find(data.html.block),
					total = data.codes.length,
					successCounter = 0,
					priceData = [];
				var returnPercent = function(num, total)
				{
					return 100 - Math.round((num / total) * 100);
				};

				var setComma = function(num)
				{
					var str = String(num);
					return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
				};
				var createHtm = function()
				{
					$.each($priceAreas, function(index)
					{
						var priceHtm = (function()
							{
								if (parseInt(priceData[index].coupon_price, 10) !== 0)
								{ // 할인 적용가가 0일경우 할인율이 없으므로 판매가 적용.
									return data.html.price.replace(data.discount, setComma(priceData[index].coupon_price));
								}
								else
								{
									return data.html.price.replace(data.discount, setComma(priceData[index].selling_price));
								}
							})(),
							dcPriceHtm = (function()
							{
								if (parseInt(priceData[index].coupon_price, 10) !== 0)
								{
									return data.html.dc_price
										.replace(data.price, setComma(priceData[index].selling_price))
										.replace(data.percent, returnPercent(priceData[index].coupon_price, priceData[index].selling_price));
								}
								else
								{
									return '<span class="dc_price"></span>';
								}
							})();
						$(this).append(priceHtm).append(dcPriceHtm);
					});
				};
				$.each(data.codes, function(index)
				{
					// console.log( index );
					OpGoods_price__call(this, function(price)
					{
						priceData[index] = price;
						successCounter++;
						if (successCounter === total)
						{
							createHtm();
						}
					});
				});
			}


			// showroom view.
			function showRoomFnc(data)
			{
				var $block = $('#showRoomList'),
					$objs = $block.find('.show_room_info'),
					$infoDetail = $('#showRoomInfoDetail'),
					timer = null;
				var showInfo = function($element)
				{
					var code = $element.data('code'),
						posX = parseInt($element.css('left'), 10),
						posY = parseInt($element.css('top'), 10),
						source = $('#showRoom-template').html(),
						template = Handlebars.compile(source),
						html = $(template(data[code]));

					$infoDetail.trigger('mouseenter').html(html)
					if ($infoDetail.css('display') === 'none')
					{
						$infoDetail.fadeIn('fast').css(
						{
							'top': posY + $element.height(),
							'left': posX + $element.width()
						});
					}
					else
					{
						$infoDetail.fadeIn('fast').animate(
						{
							'top': posY + $element.height(),
							'left': posX + $element.width()
						});
					}
				};
				var hideInfo = function() {

				};
				var hideInfoTimer = function()
				{
					if (timer === null)
					{
						timer = setTimeout(function()
						{
							$infoDetail.fadeOut('fast');
						}, 500);
					};

				}
				$objs.on('mouseenter', function()
				{
					showInfo($(this));
				}).on('mouseleave', function()
				{
					hideInfoTimer();
				});
				$infoDetail.on('mouseenter', function()
				{
					if (timer !== null)
					{
						clearTimeout(timer);
						timer = null;
					}
				}).on('mouseleave', function()
				{
					hideInfoTimer();
				});
			};

			function collection(data)
			{
				var $block = $('#collection_list'),
					source = $('#collection-template').html(),
					template = Handlebars.compile(source),
					html = $(template(data)),
					dragBtn = $('#dragBtn'),
					dragLine = $('#dragLine'),
					dragMax = 1150,
					boxW = 440,
					boxMargin = 20,
					descriptionW = 275,
					totalWidth = 0,
					counter = 0,
					addMargin = 0,
					page = 0,
					totalPage = data.list.length,
					updatePageW = dragMax / (totalPage - 1);

				var addMarginFnc = function()
				{
					return $(window).width() / 440 / 2;
				};

				var windowCenter = function()
				{
					return $(window).width() / 2;
				};
				var activeChecker = function(element)
				{
					if (element.index() !== page)
					{
						element.animate(
						{
							'width': boxW
						},
						{
							'duration': 200,
							'easing': 'easeOutQuad',
							complete: function()
							{
								$(this).removeClass('active');
							}
						});
					}
				}
				var blockPos = function(next)
				{
					if (page === next)
					{
						return false
					}
					else
					{
						page = next;
					}

					var pos = windowCenter() - ((boxW + boxMargin) / 2 + (boxW + boxMargin) * page);
					// console.log(pos)
					$block.find('.active').animate(
					{
						'width': boxW
					},
					{
						'duration': 200,
						'easing': 'easeOutQuad',
						complete: function()
						{
							$(this).removeClass('active');
						}
					});

					$block.stop().animate(
					{
						'margin-left': pos
					},
					{
						'duration': 200,
						'easing': 'linear',
						complete: function()
						{

							$block.find('.collection_item').eq(page).animate(
							{
								'width': boxW + descriptionW
							},
							{
								'duration': 200,
								'easing': 'easeInQuad',
								complete: function()
								{
									$(this).addClass('active');
									activeChecker($(this));
								}
							})

							// $block.find('.collection_item').eq(page).find('.collection_info').show('slide',function(){
							// 	$(this).parent().addClass('active');
							// });
						}
					});
				};
				var returnPercent = function(num, total)
				{
//					return 100 - Math.round((parseInt(num, 10) / parseInt(total, 10)) * 100);
					return 100 - Math.round((parseInt(renumberFormat(num)) / parseInt(renumberFormat(total))) * 100);
				};
				// $.each( html.find('img'), function(){
				// 	$(this).one('load', function(){
				// 		var _this = $(this);
				// 		// _this.data('width', _this.width()+20 );
				// 		// console.log(counter , data.list.length)
				// 		// if( counter === data.list.length-1 ){
				// 		// 	totalWidth += _this.data('width');
				// 		// 	$block.css({
				// 		// 		'width': totalWidth + descriptionW
				// 		// 	});
				// 		// } else {
				// 		// 	counter ++;
				// 		// 	totalWidth += _this.data('width');
				// 		// }
				// 	});
				// } );
				$.each(html.find('.js-price'), function(index)
				{
					var htm = '';
					if (data.list[index].dc_price !== '0')
					{
						htm += '<span class="js-discount">' + data.list[index].dc_price + '</span>';
						htm += '<span class="dc_price"><s class="del_price">' + data.list[index].price + '</s>';
						htm += ' (' + returnPercent(data.list[index].dc_price, data.list[index].price) + '% <span class="spr-common spr_ico_arrow_down"></span>)';

					}
					else
					{
						htm += '<span class="js-discount">' + data.list[index].price + '</span>'
					}
					$(this).append(htm);
				});
				$block.css('width', (boxW + boxMargin) * (totalPage) + descriptionW);
				$block.html(html);
				dragBtn.draggable(
				{
					axis: 'x',
					containment: "parent",
					cursor: "move",
					create: function(event, ui)
					{
						var next = Math.floor(575 / updatePageW);
						blockPos(next);
						// console.log(page);
					},
					drag: function(event, ui)
					{
						//console.log( ui.position.left );

						var next = Math.floor(ui.position.left / updatePageW);
						blockPos(next);
						// console.log(page);
					},
					start: function(event, ui) {

					},
					stop: function(event, ui) {

					}
				});
				$(window).on('resize', function()
				{
					var pos = windowCenter() - ((boxW + boxMargin) / 2 + (boxW + boxMargin) * page);
					$block.stop().animate(
					{
						'margin-left': pos
					},
					{
						'duration': 200,
						'easing': 'linear'
					});
				});
			};

//개발서버에서는 DB로 꺼내오도록 되어있지만, HTML에 엔터키나 띄어쓰기가 있는 경우 적용되지 않으므로 실서버에서는 직접 하드코딩으로 박아주는 중. 좀 더 개발이 필요할 듯....

			var bigBannerArray = [
//				'<li class="main_banner_item" style="background:url(http://ui.etah.co.kr/assets/images/data/161103_main_banner_01.jpg) no-repeat 50% 0"><a href="http://www.etah.co.kr/goods/event/34" class="main_banner_link"><em class="title" style="left:386px; top:276px;">봄티비리빙 OPEN <br>기념 20% 할인전</em><span class="description" style="left:386px; top:409px;">봄티비리빙의 액자 소품을 할인된 가격으로 만나보세요.</span></a></li>','<li class="main_banner_item" style="background-image:url(http://ui.etah.co.kr/assets/images/data/160921_main_banner_01.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="http://www.etah.co.kr/goods/event/27" class="main_banner_link"><em class="title" style="left:386px; top:161px; font-size: 45px; line-height: 55px;">집에 관한 모든 것,<br />에타의 첫 100명의 회원님이<br />되어주세요!</em><span class="description" style="left:388px; top:335px; line-height: 22px;">에타 회원이 되시면, 브랜드 프로모션 및 마일리지 적립 등을<br />제약없이 참여하실 수 있습니다.</span><span style="position: absolute; top: 420px; left: 390px;"><img src="/assets/images/data/160921_main_banner_01_coupon.jpg" alt="지금 바로 회원가입하시면, 전상품 10% 할인쿠폰을 회원님 ID로 지급해드립니다." /></span></a><span class=" ui-main-banner-out-layer--btn" style="z-index:20;display:block;position: absolute;left: 390px;top: 570px;font-size: 11px;color: #212121;font-weight: bold;border-bottom: 1px solid #5d5855;">쿠폰 사용 전 꼭 확인하세요<span class="spr-common spr-triangle_right_02" style="display: block;position: absolute; right:-12px; top:5px;"></span></span><div class="ui-main-banner-out-layer" style="display:none;position: absolute;left: 390px;top: 595px;z-index: 20;"><ul style="border: 1px solid #8e8883;width: 519px;height: 295px;background: #fff;padding: 45px 0 0 49px;"><li style="overflow: hidden; zoom: 1;"><strong style="color: #212121;font-size: 12px;font-weight: bold;float: left;margin-right: 29px;line-height: 20px;text-decoration: underline;">쿠폰 안내</strong><span style="color: #212121;font-size: 12px;float: left;line-height: 20px;">전 상품에 쿠폰 적용 가능.<br />할인율 10%. 최대 3만원 할인.<br />상품별 추가할인 쿠폰과는 중복 사용 불가</span></li><li style="padding-top: 9px; overflow: hidden; zoom: 1;"><strong style="color: #212121;font-size: 12px;font-weight: bold;float: left;margin-right: 29px;line-height: 20px;text-decoration: underline;">사용 기간</strong><span style="color: #212121;font-size: 12px;float: left;line-height: 20px;">쿠폰 수령 후 1개월 이내</span></li><li style="padding-top: 9px; overflow: hidden; zoom: 1;"><strong style="color: #212121;font-size: 12px;font-weight: bold;float: left;margin-right: 29px;line-height: 20px;text-decoration: underline;">지급 방법</strong><span style="color: #212121;font-size: 12px;float: left;line-height: 20px;">회원가입 후 +1일 오전 10시까지 회원ID로 지급해드립니다.<br />(단, 주말&frasl;공휴일 가입 시+1 영업일에 지급)</span></li><li style="padding-top: 9px; overflow: hidden; zoom: 1;"><strong style="color: #212121;font-size: 12px;font-weight: bold;float: left;margin-right: 29px;line-height: 20px;text-decoration: underline;">확인 방법</strong><span style="color: #212121;font-size: 12px;float: left;line-height: 20px;">로그인 후 마이페이지</span></li><li style="padding-top: 9px; overflow: hidden; zoom: 1;"><strong style="color: #212121;font-size: 12px;font-weight: bold;float: left;margin-right: 29px;line-height: 20px;text-decoration: underline;">사용 방법</strong><span style="color: #212121;font-size: 12px;float: left;line-height: 20px;">주문&frasl;결제 페이지 내 &lt;할인&frasl;혜택 적용&gt;에서 적용가능한쿠폰 선택하거나<br />장바구니에서 상품별 쿠폰 선택하여 적용하실 수 있습니다.</span></li><li style="padding-top: 9px; overflow: hidden; zoom: 1;"><strong style="color: #212121;font-size: 12px;font-weight: bold;float: left;margin-right: 29px;line-height: 20px;text-decoration: underline;">유의 사항</strong><span style="color: #212121;font-size: 12px;float: left;line-height: 20px;">본 이벤트는 회사의 사정으로 내용변경 또는 조기종료 될 수 있습니다..</span></li></ul></div></li>','<li class="main_banner_item" style="background-image:url(http://ui.etah.co.kr/assets/images/data/161103_main_banner_02.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="http://www.etah.co.kr/goods/event/30" class="main_banner_link"><em class="title" style="left:386px; top:276px;">HOMEWORKS<br />수입 소품 기획전</em><span class="description" style="left:388px; top:408px;" >움브라, 인터디자인, 프레젠트, 웨스코, 야마토재팬 신규 입점 브랜드 할인</span></a></li>','<li class="main_banner_item" style="background-image:url(http://ui.etah.co.kr/assets/images/data/160921_main_banner_03.jpg); background-repeat: no-repeat; background-position: 50% 0"><a href="http://www.etah.co.kr/goods/event/22" class="main_banner_link"><em class="title" style="left:386px; top:276px;">올 가을을 장식하는<br />인기 디자인 조명</em><span class="description" style="left:388px; top:408px;" >셀프인테리어의 시작 디자인 조명의 품격 </span></a></li>'
			'<?=$rolling_top?>'
			];

			$(function()
			{
				if ($('body').data('showroom') === true)
				{
					showRoomFnc(showRoomData);
				}
				else
				{
					$('#show_room').hide();
				}
				if( $('body').data('newitem') === true )
				{
		            newItemPriceInsert( newItemData )
	            }
				if ($('body').data('collection') === true)
				{
					collection(collectionData);
				}
				else
				{
					$('#collectionBlock').hide();
				}

				$('.lazy-img').lazyload(
				{
					'dffect': 'fadeIn',
					'data_attribute': 'origin'
				});

				etahUi.bigBanner(
				{
					htmlArray: bigBannerArray
				});
			});


			//=====================================
		    // 브랜드 탭 변경
			//=====================================
			function changeBrandTab(idx) {
				for(i=1; i<5; i++){
					if(i == idx){
						$("#mainBrandCont0"+i).css('display','block');
						$("#main_brand_tab_item_0"+i).addClass('active');
					}else{
						$("#mainBrandCont0"+i).css('display','none');
						$("#main_brand_tab_item_0"+i).removeClass ('active');
					}
				}
			}

//			alert( OpGoods_price(1)['selling_price']);
//			alert( OpGoods_price(1)['coupon_price']);



			//new item best item 랜덤 스크립트 2016-11-11 추가
			function getRandomArbitrary ( min, max ){
                return Math.random() * ( max - min ) + min;
            }
            // new item / new brand 를 랜덤으로 노출.
            if( Math.floor( getRandomArbitrary( 0, 2 ) ) === 0 ){
                changeItemBrandTab('I');
            } else {
                changeItemBrandTab('B')
            }
//             best item / etah's choice 를 랜덤으로 노출.
//             개발 반영시 사용하시려면 주석을 풀어 주세요.
           //  if( Math.floor( getRandomArbitrary( 0, 2 ) ) === 0 ){
           //      getEtahChoice('B');
            // } else {
                 getEtahChoice('E');
          //   }




			</script>



