<?
if($event['PLAN_EVENT_CD'] == '66' && $this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST'){
redirect('/goods/event/77');
}
?>

			<link rel="stylesheet" href="/assets/css/display.css?ver=1.0">
			<br>
			<div class="contents event">
                <!--
	            2018.02.21 행사기간 제거.
				<p class="event_date">행사기간 : <?/*=$event['START_TIME']*/?> ~ <?/*=$event['END_TIME']*/?></p>-->
				<div class="event_visual">
				<?if($event['PLAN_EVENT_CD'] == '66'){?>
					<img src="<?=$event['EVENT_IMG_URL']?>" alt="" usemap="#066" id="map_cursor" width="1220"/>
				<?}else if($event['PLAN_EVENT_CD'] == '77'){?>
					<img src="<?=$event['EVENT_IMG_URL']?>" alt="" usemap="#077" id="map_cursor" width="1220"/>
				<?}else{?>
					<img src="<?=$event['EVENT_IMG_URL']?>" alt="" id="map_cursor" width="1220"/>
				<?}?>
				</div>

				<map name="066">
					<area shape="rect" coords="674,978,1157,1039" href="https://<?=$_SERVER['HTTP_HOST']?>/member/login" />
				</map>
				<map name="077">
                    <a href="#goods<?=$cidx?>" >
                        <area shape="rect" coords="674,978,1157,1039" href="#goods0" onClick="javaScript:clickEvent('<?=$cidx?>');" style="cursor:pointer;" onmouseover="javascript:$('#map_cursor').css('cursor','pointer');" onmouseout="javascript:$('#map_cursor').css('cursor','auto');" /></a>
					<!--<area shape="rect" coords="616,2076,991,2140" onclick="javascript:jsGetCoupon(<?=$event['EVENT_COUPON_CD']?>);" style="cursor:pointer;" onmouseover="javascript:$('#map_cursor').css('cursor','pointer');" onmouseout="javascript:$('#map_cursor').css('cursor','auto');" />-->
				</map>
				<!-- 쿠폰있을 경우 (기획전에 쿠폰코드를 추가해야함!)//2017-03-07 -->
				<? if($event['EVENT_COUPON_CD']){?>
					<?if($event['PLAN_EVENT_CD'] != '77'){?>
						<div class="coupon_event">
							<h2 class="coupon_event_title"><?=$event['EVENT_COUPON_NM']?></h2>
							<span class="coupon_event_coupon">
								<img src="<?=$event['EVENT_COUPON_IMG']?>" alt="" />
							</span>
							<button type="button" class="btn_positive btn_positive__coupon" onClick="javascript:jsGetCoupon(<?=$event['EVENT_COUPON_CD']?>);">
								쿠폰받기
							</button>
							<? if($event['ISSUE_COUPON_DESC'] != ''){	?>
							<div class="coupon_event_note">
								<h3 class="coupon_event_note_title">쿠폰 사용 시 유의사항</h3>
								<ul class="bullet_list">
							<!--		<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>진행기간 : 2017-01-31 ~ 재고 소진 시 (event 종료 시 공지사항 게시)</li>
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>사은품은 주문 시 입력하신 배송지로 상품과 별도로 발송됩니다.</li>
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>사은품은 중복 증정 되지 않으며, 취소/반품 시 제공되지 않습니다.</li>
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>핸드메이드 상품이라 표면이 매끄럽지 않을 수 있으나, 초를 사용하시면 자연스럽게 녹아서 사라질 것입니다.</li>
							-->
							<?
								$coupon_text = explode('<br>',$event['ISSUE_COUPON_DESC']);

								foreach($coupon_text as $row){
							?>
								<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span><?=trim($row)?></li>
								</ul>
							<?
								}
							?>
							</div>
							<? }?>
						</div>
					<?}?>
				<? }?>
				<ul class="section_tab_list">
					<?
					$cidx=0;
					$cate_name = "";
					foreach($goods as $crow){
						if($crow['NAME'] != $cate_name){?>
					<li <?=$cidx == 0 ? "class='active'" : ""?> id="cate<?=$cidx?>"><!-- 상단 카테고리 -->
						<a href="#goods<?=$cidx?>" onClick="javaScript:clickEvent('<?=$cidx?>');">
							<?=$crow['NAME']?>
							<span class="section_tab_line"></span>
						</a>
					</li>
					<?
						$cate_name = $crow['NAME'];
						$cidx++;
						}
					}
					?>
				</ul>
				<?
				$i=0;
				$idx = 0;
				$cate_name = "";
				foreach($goods as $row){;
					if($cate_name != $row['NAME']){
						if($idx != 0){?>
				</ul>
					</div>
					<!-- // 상품 리스트 -->
				</div>
				<?		}?>
				<div class="event_section" id="goods<?=$i?>"><!-- 카테 상세 -->
					<h4 class="title_page"><strong><?=$row['NAME']?></strong></h4>
					<!-- 상품 리스트 // -->
					<div class="basic_goods_list">
						<ul class="goods_list">
				<?
					$cate_name = $row['NAME'];
					$i++;
					}
					if($cate_name == $row['NAME']){?>

							<li class="goods_item">
								<div class="img">
									<a href="/goods/detail/<?=$row['GOODS_CD']?>"  class="img_link"><img src="<?=$row['IMG_URL']?>" alt="" height=290></a>
                                    <div class="tag-wrap">
                                        <?if(isset($row['DEAL'])){?>
                                            <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                        <?}?>
                                        <?if($row['GONGBANG']=='G'){?>
                                            <!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>-->
                                        <?}else if($row['GONGBANG']=='C'){?>
                                            <!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>-->
                                        <?}?>
                                    </div>
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
												<li class="goods_sns_item">
													<button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
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
											$price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
											echo number_format($price);
											$sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
											$sale_percent = strval($sale_percent);
											$sale_percent_array = explode('.',$sale_percent);
											$sale_percent_string = $sale_percent_array[0];
										?>
										<span class="dc_price">
											<s class="del_price"><?=number_format($row['SELLING_PRICE'])?></s> (<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
										</span>
										<?}else{
											echo number_format($price = $row['SELLING_PRICE']);
										} ?>
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
										<?}
										if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){
										?>
										<span class="spr-common spr_ico_free_shipping"></span>
										<?}?>
									</span>
								</a>
							</li>
						<?
								$cate_name = $row['NAME'];
								$idx ++;
						}?>

				<?}?>

				</ul>
					</div>
					<!-- // 상품 리스트 -->
				</div>
			</div>


			<script type="text/javaScript">
            //google_gtag
            gtag('event', 'select_content', {
                "promotions": [
                    {
                        "id": "<?=$event['PLAN_EVENT_CD']?>",
                        "name": "ETAH - promotion"
                    }
                ]
            });

			function clickEvent(val){
				var idx = "<?=$cidx?>";
				for(i=0; i<idx; i++){
					if(val == i){
						$('#cate'+i).addClass('active');
					}else{
						$('#cate'+i).removeClass('active');
					}
				}


//				$('#bestItem_li').removeClass('active');
//				$('#etahsChoice_li').addClass('active');
//				$('#bestItem').css("display","none");
//				$('#etahsChoice').css("display","");
			}

//===============================================
// 쿠폰받기 (2017-03-07)
//===============================================
function jsGetCoupon(coupon_code){
	var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";

	if(SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST' || SESSION_ID == ''){
		location.href = '/member/login';
	}
	else {
		$.ajax({
			type: 'POST',
			url: '/goods/get_event_coupon',
			dataType: 'json',
			data: { coupon_code : coupon_code },
			error: function(res) {
				alert('Database Error');
			},
			success: function(res) {
				if(res.status == 'ok'){
					alert("쿠폰 발급이 완료되었습니다.");
				}
				else alert(res.message);
			}
		})
	}
}

function jsGetCouponsss(coupon_code){
	alert(coupon_code);
}
</script>