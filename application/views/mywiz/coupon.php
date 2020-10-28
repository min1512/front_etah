					<div class="mypage_cont">
						<div class="position_area">
							<h3 class="title_page title_page__line title_page__mypage">쿠폰현황</h3>
							<ul class="position_right coupon_check_btn">
								<li class="coupon_check_btn_item">
									<a href="/mywiz/coupon" class="<?=!$last_coupon ? "active" : "";?>">사용가능한 쿠폰</a>
								</li>
								<li class="coupon_check_btn_item">
									<span class="spr-common spr_bg_bar"></span><a href="javaScript:search_coupon('L');" class="<?=$last_coupon ? "active" : "";?>">지난 쿠폰 내역</a>
								</li>
							</ul>
						</div>

	<!-- 2016-10-14 로직 수정해야함
						<div class="coupon_num_search">
							<label>상품번호로 사용가능한 쿠폰 조회</label>
							<input type="text" class="input_text" style="width: 287px;" id="goods_cd" onKeyPress="javascript:if(event.keyCode == 13){ search_coupon(''); return false;}" value="<?=$goods_cd?>"/>
							<button type="button" class="btn_black btn_black__small" onClick="javaScript:search_coupon('');">조회</button>
						</div>
	-->

						<div class="board_list board_list__coupon">
							<table class="board_list_table">
								<caption>쿠폰 정보</caption>
								<colgroup>
									<col style="width:165px;" />
									<col />
									<col style="width:142px;" />
									<col style="width:224px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">쿠폰종류</th>
										<th scope="col" colspan="2">쿠폰정보</th>
										<!--<th scope="col">할인대상</th>-->
										<th scope="col">유효기간</th>
									</tr>
								</thead>
								<tbody>
								<?if($coupon_list){
									foreach($coupon_list as $row){?>
									<tr>
										<td><?=$row['DC_COUPON_NM']?></td>
										<td class="coupon_saving_text" colspan="2">
											<ul class="bullet_list bullet_list__dark">
												<li class="bullet_item">
													<span class="spr-common spr_bg_dot03"></span>
													<?switch($row['BUYER_COUPON_APPLICATION_SCOPE_CD']){
														case 'BRAND'	: echo "브랜드 전용 쿠폰";	break;
														case 'GOODS'	: echo "상품 전용 쿠폰";	break;
														case 'CUST'		: echo "고객 전용 쿠폰";	break;
														case 'CATEGORY' : echo "상품 전용 쿠폰";	break;
													}?>
												</li>
												<?if($row['MIN_AMT']||$row['MAX_DISCOUNT']){?>
												<li class="bullet_item"><span class="spr-common spr_bg_dot03"></span> <?=$row['MIN_AMT'] ? number_format($row['MIN_AMT'])."원 이상 구매시 " : ""?><?=$row['MAX_DISCOUNT'] ? "최대 ".number_format($row['MAX_DISCOUNT'])."할인" : ""?></li>
												<?}?>
											</ul>
										</td>
										<!--<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>-->
										<td>
											<?=$row['COUPON_START_DT']?>~<br /><?=$row['COUPON_END_DT']?> 까지
											<?if($last_coupon){?><br/><?=$row['USE_YN'] == 'N' ? '(사용완료)' : '(기간만료)' ?><?}?>
										</td>
									</tr>
									<?}
								}else{?>
									<tr>
										<td colspan="4">쿠폰내역이 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td>쿠폰명</td>
										<td class="coupon_saving_text">
											<ul class="bullet_list bullet_list__dark">
												<li class="bullet_item"><span class="spr-common spr_bg_dot03"></span>모바일 앱, 모바일 웹, PC웹</li>
												<li class="bullet_item"><span class="spr-common spr_bg_dot03"></span>20,000원 이상 구매시</li>
											</ul>
										</td>
										<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>
										<td>2016-02-10 00:00:00~<br />2016-03-09 23:59:59까지</td>
									</tr>
									<tr>
										<td>쿠폰명</td>
										<td class="coupon_saving_text">
											<ul class="bullet_list bullet_list__dark">
												<li class="bullet_item"><span class="spr-common spr_bg_dot03"></span>모바일 앱, 모바일 웹, PC웹</li>
												<li class="bullet_item"><span class="spr-common spr_bg_dot03"></span>20,000원 이상 구매시</li>
											</ul>
										</td>
										<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>
										<td>2016-02-10 00:00:00~<br />2016-03-09 23:59:59까지</td>
									</tr>-->
								</tbody>
							</table>
						</div>

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
							</ul>
							<a href="#" class="page_next">
								Next<span class="spr-common spr_arrow_right"></span>
							</a>
						</div>-->
						<?=$pagination?>

						<ul class="bullet_list bullet_list__coupon">
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>쿠폰은 중복사용 할 수 없으며, 주문취소/반품시의 쿠폰은 환원됩니다. (쿠폰 사용기간 내)</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>주문취소/반품 시에는, 해당상품에 적용된 할인금액을 제외하고 실제 결제금액만큼 환불됩니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>할인쿠폰 별 사용 유효기간을 꼭 확인하시기 바랍니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>할인쿠폰 사용하여 주문 시, 할인된 금액을 제외하고 실제 결제하신 금액에 대해서 상품의 적립금이 부여됩니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>할인쿠폰은 일부 상품에는 적용되지 않으며 쿠폰의 종류에 따라서 특정상품에만 적용될 수 있습니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>쿠폰금액이 판매금액 보다 높은 경우 잔액은 환원되지 않습니다.</li>
						</ul>
					</div>
				</div>
			</div>

			<script type="text/javaScript">

			//====================================
			// 조회
			//====================================
			function search_coupon(val)
			{
				var	page		= 1
					, goods_cd  = $('#goods_cd').val()
					, last_coupon = "";

				if(val == 'L') last_coupon = val;

				var param = "";
				param += "page="			+ page;
				param += "&goods_cd="		+ goods_cd;
				param += "&last_coupon="	+ last_coupon;

				document.location.href = "/mywiz/coupon_page/"+page+"?"+param;
			}

			</script>