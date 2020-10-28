					<?
					$date_today = date("Y-m-d", time());
					$date_w1 = date("Y-m-d", strtotime("-1 week"));
					$date_m1 = date("Y-m-d", strtotime("-1 month"));
					$date_m2 = date("Y-m-d", strtotime("-3 month"));
					$date_m3 = date("Y-m-d", strtotime("-6 month"));
					?>

					<div class="mypage_cont">
						<h3 class="title_page title_page__line title_page__mypage"><?=$title?></h3>

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
									<input type="text" class="input_text datepicker" readonly id="date_from" value="<?=$date_from?>" />
									<button type="date" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
								</div>
								<span class="date_option_select_item">~</span>
								<div class="date_option_select_item">
									<input type="text" class="input_text datepicker" readonly id="date_to" value="<?=$date_to?>"/>
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
									<col style="width:125px;" />
									<col style="width:97px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">주문번호</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col" class="title_prd_info" colspan="2">상품정보</th>
										<th scope="col">수량</th>
										<th scope="col">상품금액</th>
										<th scope="col">주문상태</th>
										<!--<th scope="col">상세내역</th>-->
									</tr>
								</thead>
								<tbody>
								<?if($order_list){
									foreach($order_list as $row){?>
									<tr>
										<td class="order_number">
											<a href="/mywiz/order_detail/<?=$row['ORDER_NO']?>" class="link"><?=$row['ORDER_NO']?><br/>(<?=$row['REG_DT']?>)</a>
											<button type="button" class="btn_white btn_white__small" onClick="javaScript:location.href='/mywiz/order_detail/<?=$row['ORDER_NO']?>'">상세보기</button>
										</td>
										<td class="image">
											<a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" alt="" width="100" height="100"/></a>
										</td>
										<td class="goods_detail__string" colspan="2">
											<p class="name"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><?=$row['GOODS_NM']?></a></p>
											<p class="description"><?=$row['PROMOTION_PHRASE']?></p>
											<p class="option"><?=$row['GOODS_OPTION_NM']?></p>
										</td>
										<td><?=$row['QTY']?></td>
										<td><?=number_format($row['SELLING_PRICE'])?>원</td>
										<td class="order_status">
											<span class="string"><?=$row['ORDER_REFER_PROC_STS_CD_NM']?></span>
											<!--<button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="#layer_cancel_apply">취소신청</button>-->
										</td>
										<!--<td><button type="button" class="btn_white btn_white__small" onClick="javaScript:location.href='/mywiz/order_detail/<?=$row['ORDER_NO']?>'">상세보기</button></td>-->
									</tr>
								<?	}
								}else{?>
									<tr>
										<td colspan="7">주문 내역이 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td class="order_number">
											<a href="#" class="link">2016-01-26-327668</a>
										</td>
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
										<td>353,500</td>
										<td class="order_status">
											<span class="string">배송중</span>
											<button type="button" class="btn_white btn_white__small">배송추적</button>
										</td>
									</tr>
									<tr>
										<td class="order_number">
											<a href="#" class="link">2016-01-26-327668</a>
											</td>
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
										<td>353,500</td>
										<td class="order_status">
											<span class="string">배송완료</span>
										</td>
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
					</div>
				</div>
			</div>


			<script type="text/javaScript">

			//====================================
			// 조회
			//====================================
			function jsSearch()
			{
				var date_from	= $('#date_from').val(),
					date_to		= $('#date_to').val(),
					date_type	= $('#date_type').val(),
					nav			= "<?=$nav?>",
					title		= "<?=$title?>",
					page		= 1;

				var param = "";
				param += "page="			+ page;
				param += "&nav="			+ nav;
				param += "&title="			+ title;
				param += "&date_from="		+ date_from;
				param += "&date_to="		+ date_to;
				param += "&date_type="		+ date_type;
	
				document.location.href = "/mywiz/current_order_page/"+page+"?"+param;
			}

			//=====================================
			// datepicker
			//=====================================
			$(function()
			{
				$(".datepicker").datepicker(
				{
					showOn: "button",
					dateFormat: 'yy-mm-dd',
					//numberOfMonths: 1,
					prevText: "",
					nextText: "",
					monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
					monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
					dayNames: ["일", "월", "화", "수", "목", "금", "토"],
					dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
					dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
					showMonthAfterYear: true,
					yearSuffix: ".",
				});
			});


			</script>