					<?
					$date_today = date("Y-m-d", time());
					$date_w1 = date("Y-m-d", strtotime("-1 week"));
					$date_m1 = date("Y-m-d", strtotime("-1 month"));
					$date_m2 = date("Y-m-d", strtotime("-3 month"));
					$date_m3 = date("Y-m-d", strtotime("-6 month"));
					?>
					
					<div class="mypage_cont">
						<h3 class="title_page title_page__line title_page__mypage">
							1:1 문의
							<button type="button" class="btn_inquiry" onClick="javaScript:location.href='/customer/register_qna';">문의하기</button>
						</h3>

						<div class="date_option" id="date_option">
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
						<div class="board_list board_list__inquiry">
							<table class="board_list_table">
								<caption>1:1 문의 리스트</caption>
								<colgroup>
									<col style="width:75px;" />
									<col style="width:103px;" />
									<col />
									<col style="width:97px;" />
									<col style="width:125px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">번호</th>
										<th scope="col">구분</th>
										<th scope="col">제목</th>
										<th scope="col">문의일</th>
										<th scope="col">처리상태</th>
									</tr>
								</thead>
								<tbody>
								<?if($qna_list){
									$idx=($page - 1) * $sNum + 1;
									foreach($qna_list as $row){?>
									<tr class="" id="qna<?=$idx?>">
										<td><?=$idx?></td>
										<td><?=$row['CS_QUE_TYPE_CD_NM']?></td>
										<td class="comment"><a href="javaScript:jsOpen('<?=$idx?>');" class="link"><?=$row['Q_TITLE']?></a></td>
										<td><?=$row['Q_REG_DT']?></td>
										<td><?=$row['A_NO'] ? "답변완료" : "답변대기"?></td>
									</tr>
									<tr class="reply">
										<td colspan="5">
											<div class="position_area">
												<div class="question">
													<span class="left">Q</span>
													<div class="text">
														<?=$row['Q_CONTENTS']?>
														<?if($row['FILE_PATH']){?><div class="img"><img src="<?=$row['FILE_PATH']?>" alt="" width="100" height="100"></div><?}?>
													</div>
												</div>

												<?if($row['ORDER_GOODS_CD']){?>
												<div class="prd_info">
													
													<div class="img"><img src="<?=$row['ORDER_GOODS_IMG_URL']?>" alt="" width="100" height="100"></div>
													<div class="goods_detail__string">
														<p class="name"><?=$row['ORDER_GOODS_NM']?></p>
														<!--<p class="description">Flat Table 400 - black</p>-->
														<p class="option"><?=$row['ORDER_GOODS_OPTION_NM']?></p>
													</div>
													
												</div>
								

												<?}?>
												
												<?if($row['A_NO']){?>
												<div class="answer">
													<span class="left">A</span>
													<div class="text">
														<?=$row['A_CONTENTS']?>
													</div>
												</div>
												<?}else{?>
												<ul class="btn_list btn_list__reply position_right">
													<li><button type="button" class="btn_white btn_white__small" onClick="javaScript:delete_qna('<?=$row['CS_NO']?>');">삭제</button></li>
													<li><button type="button" class="btn_white btn_white__small" onClick="javaScript:location.href='/mywiz/modify_qna/<?=$row['CS_NO']?>'">수정</button></li>
												</ul>
												<?}?>
											</div>
										</td>
									</tr>
									<?
									$idx++;
									}
								}else{?>
									<tr>
										<td colspan="5">등록된 문의가 없습니다.</td>
									</tr>
								<?}?>
									
									<!--<tr>
										<td>주문&#47;결제</td>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>배송</td>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>환불</td>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>교환</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>상품</td>
										<td class="comment"><a href="#" class="link">상품이 생각보다 작은데 사이즈가 맞는건지 궁금합니다.</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>주문&#47;결제</td>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
										<td>2016-02-16</td>
										<td>답변완료</td>
									</tr>
									<tr>
										<td>배송</td>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
										<td>2016-02-16</td>
										<td>답변완료</td>
									</tr>
									<tr>
										<td>환불</td>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
										<td>2016-02-16</td>
										<td>답변완료</td>
									</tr>
									<tr>
										<td>교환</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
										<td>답변완료</td>
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
					page		= 1;

				var param = "";
				param += "page="			+ page;
				param += "&date_from="		+ date_from;
				param += "&date_to="		+ date_to;
				param += "&date_type="		+ date_type;
	
				document.location.href = "/mywiz/p_qna_page/"+page+"?"+param;
			}

			//=====================================
			// 문의 클릭시 펼쳐보기
			//=====================================
			function jsOpen(idx){
				if($("#qna"+idx).attr('class') == ""){		//접혀있는 경우
					$("#qna"+idx).addClass('active');
				} else {		//펼쳐있는 경우
					$("#qna"+idx).removeClass();
				}
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

			//=====================================
			// 문의 삭제하기
			//=====================================
			function delete_qna(qna_no){
				if(confirm("문의를 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_qna',
						dataType: 'json',
						data: {	qna_no: qna_no	},
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
									alert("삭제되었습니다.");
									location.reload();
							}
							else alert(res.message);
						}
					});
				}
			}


			</script>