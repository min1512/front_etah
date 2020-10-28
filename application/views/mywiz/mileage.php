					<?
					$date_today = date("Y-m-d", time());
					$date_w1 = date("Y-m-d", strtotime("-1 week"));
					$date_m1 = date("Y-m-d", strtotime("-1 month"));
					$date_m2 = date("Y-m-d", strtotime("-3 month"));
					$date_m3 = date("Y-m-d", strtotime("-6 month"));
					?>
					
					<div class="mypage_cont">
						<div class="position_area">
							<h3 class="title_page title_page__line title_page__mypage">마일리지</h3>
							<p class="position_right mileage_text">현재 사용 가능한 마일리지 : <em class="bold"><?=number_format($mileage)?>마일</em></p>
						</div>


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


						<div class="board_list board_list__mileage">
							<table class="board_list_table">
								<caption>마일리지 정보</caption>
								<colgroup>
									<col style="width:127px;" />
									<col style="width:83px;" />
									<col />
									<col style="width:168px;" />
									<col style="width:135px;" />
									<col style="width:146px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">일자</th>
										<th scope="col">유형</th>
										<th scope="col" colspan="3">내용</th>
										<th scope="col">마일리지 내역</th>
									</tr>
								</thead>
								<tbody>
								<?if($mileage_list){
									foreach($mileage_list as $row){?>
									<tr>
										<td><?=$row['REG_DT']?></td>
										<td><?=$row['TYPE'] == 'S' ? "적립" : ($row['TYPE'] == 'C' ? "취소" : "사용")?></td>
										<td class="mileage_saving_text" colspan="3" style="text-align: center;">
                                            <?
                                            switch($row['TYPE']) {
                                                case 'S':
                                                    echo "<p>".$row['SAVING_REASON_ETC']."</p>";
                                                    break;
                                                case 'C':
                                                    echo "주문취소( <a href='/mywiz/order_detail/".$row['ORDER_NO']."'>".$row['ORDER_NO']."</a> )";
                                                    break;
                                                case 'P':
                                                    echo "주문결제( <a href='/mywiz/order_detail/".$row['ORDER_NO']."'>".$row['ORDER_NO']."</a> )";
                                            }
                                            ?>
                                        </td>
										<td>
                                            <?
                                            switch($row['TYPE']) {
                                                case 'S':
                                                    echo number_format($row['MILEAGE_AMT']);
                                                    break;
                                                case 'C':
                                                    echo number_format(substr($row['MILEAGE_AMT'],1));
                                                    break;
                                                case 'P':
                                                    echo '-'.number_format($row['MILEAGE_AMT']);
                                                    break;
                                            }
                                            ?>
                                        </td>
									</tr>
									<?}
								}else{?>
									<tr>
										<td colspan="6">마일리지 내역이 없습니다.</td>
									</tr>
									<!--<tr>
										<td>2016-01-28</td>
										<td>구매</td>
										<td class="mileage_saving_text">에타 메일수신 동의 이벤트 적립금<br />(유효기간 : 2016-08-30)</td>
										<td>2016-02-10 00:00:00~<br />2016-03-09 23:59:59까지</td>
										<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>
										<td>0</td>
									</tr>
									<tr>
										<td>2016-01-28</td>
										<td>적립</td>
										<td class="mileage_saving_text">미사용티켓 100% 환불 (바이헤이데이<br />베스트 신상품 20% 할인)</td>
										<td>2016-02-10 00:00:00~<br />2016-03-09 23:59:59까지</td>
										<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>
										<td>0</td>
									</tr>
									<tr>
										<td>2016-01-28</td>
										<td>적립</td>
										<td class="mileage_saving_text">미사용티켓 100% 환불 (바이헤이데이<br />베스트 신상품 20% 할인)</td>
										<td>2016-02-10 00:00:00~<br />2016-03-09 23:59:59까지</td>
										<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>
										<td>0</td>
									</tr>
									<tr>
										<td>2016-01-28</td>
										<td>적립</td>
										<td class="mileage_saving_text">미사용티켓 100% 환불 (바이헤이데이<br />베스트 신상품 20% 할인)</td>
										<td>2016-02-10 00:00:00~<br />2016-03-09 23:59:59까지</td>
										<td><button type="button" class="btn_white btn_white__small">상세보기</button></td>
										<td>0</td>
									</tr>-->
								<?}?>
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
					page		= 1;

				var param = "";
				param += "page="			+ page;
				param += "&date_from="		+ date_from;
				param += "&date_to="		+ date_to;
				param += "&date_type="		+ date_type;
	
				document.location.href = "/mywiz/mileage_page/"+page+"?"+param;
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