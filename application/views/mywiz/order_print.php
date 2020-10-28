					<?
					$date_today = date("Y-m-d", time());
					$date_w1 = date("Y-m-d", strtotime("-1 week"));
					$date_m1 = date("Y-m-d", strtotime("-1 month"));
					$date_m2 = date("Y-m-d", strtotime("-3 month"));
					$date_m3 = date("Y-m-d", strtotime("-6 month"));
					?>

					<div class="mypage_cont">
						<h3 class="title_page title_page__line title_page__mypage">증빙서류발급</h3>

						<div class="date_option">
							<input type="hidden" id="date_type" value="<?=$date_type?>">
							<ul class="date_option_button">
								<li class="date_option_button_item<?=$date_type == '0' ? ' active' : ''?>" id="btn0">
									<button type="button" class="btn_white" onClick="javaScipt:jsSetDate(0,'<?=$date_w1?>','<?=$date_today?>');">1주일</button>
								</li>
								<li class="date_option_button_item<?=$date_type == '1' ? ' active' : ''?>" id="btn1">
									<!-- 활성화시 클래스 active 추가 -->
									<button type="button" class="btn_white" onClick="javaScipt:jsSetDate(1,'<?=$date_m1?>','<?=$date_today?>');">1개월</button>
								</li>
								<li class="date_option_button_item<?=$date_type == '2' ? ' active' : ''?>" id="btn2">
									<button type="button" class="btn_white" onClick="javaScipt:jsSetDate(2,'<?=$date_m2?>','<?=$date_today?>');">3개월</button>
								</li>
								<li class="date_option_button_item<?=$date_type == '3' ? ' active' : ''?>" id="btn3">
									<button type="button" class="btn_white" onClick="javaScipt:jsSetDate(3,'<?=$date_m3?>','<?=$date_today?>');">6개월</button>
								</li>
							</ul>

							<div class="date_option_select">
								<div class="date_option_select_item">
									<input type="text" class="input_text" readonly id="date_from" value="<?=$date_from?>" />
									<button type="date" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
								</div>
								<span class="date_option_select_item">~</span>
								<div class="date_option_select_item">
									<input type="text" class="input_text" readonly id="date_to" value="<?=$date_to?>"/>
									<button type="date" class="btn_calendar" ><span class="spr-common spr-calendar"></span></button>
								</div>
								<button type="button" class="btn_black btn_black__small" onClick="javaScript:jsSearch();">조회</button>
							</div>
						</div>


						<div class="board_list board_list__prd_info">
							<table class="board_list_table">
								<caption>최근주문정보 리스트</caption>
								<colgroup>
									<col style="width:173px;" />
									<col style="width:134px;" />
									<col />
									<col style="width:71px;" />
									<col style="width:129px;" />
									<col style="width:97px;" />
									<col style="width:125px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">주문번호</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col" class="title_prd_info">상품정보</th>
										<th scope="col">수량</th>
										<th scope="col">배송비</th>
										<th scope="col">결제금액</th>
										<th scope="col">주문상태</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="order_number"><a href="#" class="link">2016-01-26-327668</a></td>
										<td class="image">
											<img src="/assets/images/data/data_100x100_01.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>무료배송</td>
										<td class="order_status"><span class="string">353,500</span><button type="button" class="btn_white btn_white__small">증빙인쇄</button></td>
										<td class="order_status"><span class="string">발송전</span><button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="#layer_cancel_apply">취소신청</button></td>
									</tr>
									<tr>
										<td class="order_number"><a href="#" class="link">2016-01-26-327668</a></td>
										<td class="image">
											<img src="/assets/images/data/data_100x100_02.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>2,000</td>
										<td class="order_status"><span class="string">353,500</span><button type="button" class="btn_white btn_white__small">증빙인쇄</button></td>
										<td class="order_status"><span class="string">입금대기</span><button type="button" class="btn_white btn_white__small">배송추적</button></td>
									</tr>
									<tr>
										<td class="order_number"><a href="#" class="link">2016-01-26-327668</a></td>
										<td class="image">
											<img src="/assets/images/data/data_100x100_03.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>무료배송</td>
										<td class="order_status"><span class="string">353,500</span><button type="button" class="btn_white btn_white__small">증빙인쇄</button></td>
										<td class="order_status">배송완료</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="page">
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
						</div>
					</div>
				</div>
			</div>