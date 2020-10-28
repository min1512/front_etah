					<?
					$date_today = date("Y-m-d", time());
					$date_w1 = date("Y-m-d", strtotime("-1 week"));
					$date_m1 = date("Y-m-d", strtotime("-1 month"));
					$date_m2 = date("Y-m-d", strtotime("-3 month"));
					$date_m3 = date("Y-m-d", strtotime("-6 month"));
					?>
					
					<div class="mypage_cont">
						<h3 class="title_page title_page__line title_page__mypage">나의 상품 Q&#38;A</h3>

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

						<div class="btn_area">
							<button type="button" class="btn_white btn_white__small" onClick="javaScript:chk_delete_goods_qna();">선택삭제</button>
						</div>


						<div class="board_list board_list_qnamodify">
							<table class="board_list_table">
								<caption>나의 Q&#38;A 리스트</caption>
								<colgroup>
									<col width="72px" />
									<col style="width:130px;" />
									<col style="width:184px;" />
									<col />
									<col style="width:129px;" />
									<col style="width:145px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">
											<input type="checkbox" id="all_check" class="checkbox" onClick="javascript:jsChkAll(this.checked);" />
											<label for="all_check" class="checkbox_label"><span class="hide">전체선택</span></label>
										</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col">상품정보</th>
										<th scope="col">문의제목</th>
										<th scope="col">처리상태</th>
										<th scope="col">작성일</th>
									</tr>
								</thead>
								<tbody>
								<?if($qna_list){
									$idx = 0;
									foreach($qna_list as $row){?>
									<tr class="" id="qna<?=$idx?>">
										<td class="goods_select">
											<input type="checkbox" id="text_select_<?=$idx?>" class="checkbox" name="chkQna[]" value="<?=$row['CS_NO']?>"/>
											<label for="text_select_<?=$idx?>" class="checkbox_label"><span class="hide">선택</span></label>
										</td>
										<td class="image">
											<a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" alt="상품 이미지" width="100" height="100"></a>
										</td>
										<td class="goods_detail__string">
											<p class="name"><?=$row['BRAND_NM']?></p>
											<p class="description"><?=$row['GOODS_NM']?></p>
										</td>
										<td class="qna_text">
											<a href="javaScript:jsOpen(<?=$idx?>);" class="link"><?=$row['Q_TITLE']?></a>
										</td>
										<td>
											<?=$row['A_NO'] ? "답변완료" : "답변대기"?>
										</td>
										<td>
											<?=$row['Q_REG_DT']?>
										</td>
									</tr>
									<tr class="reply">
										<td colspan="6">
											<div class="position_area">
												<div class="question">
													<span class="left">Q</span>
													<div class="text">
														<?=$row['Q_CONTENTS']?>
													</div>
												</div>
												<!--<div class="prd_info">
													<div class="img"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" width="100" height="100" alt=""></a></div>
													<div class="goods_detail__string">
														<p class="name"><?=$row['BRAND_NM']?></p>
														<p class="description"><?=$row['GOODS_NM']?></p>
														<p class="option">블랙 / 800mm</p>
													</div>
												</div>-->
											<?if($row['A_NO']){?>
												<div class="answer">
													<span class="left">A</span>
													<div class="text">
														<?=$row['A_CONTENTS']?>
													</div>
												</div>
											<?}?>
												<ul class="btn_list btn_list__reply position_right">
													<li><button type="button" class="btn_white btn_white__small" onClick="javaScript:delete_goods_qna('<?=$row['CS_NO']?>', '<?=$row['Q_NO']?>');">삭제</button></li>
													<li><button type="button" class="btn_white btn_white__small" onClick="javaScript:open_layout(<?=$idx?>, '<?=$row['A_NO']?>');">수정</button></li>
												</ul>
											</div>
										</td>
									</tr>
									<?
									$idx++;
									}
								}else{?>
									<tr>
										<td colspan="6">등록된 문의가 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td class="image">
											<img src="/assets/images/data/data_100x100_02.jpg" alt="상품 이미지">
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
										</td>
										<td class="qna_text">
											<a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
										</td>
										<td>답변완료</td>
										<td>
											2016-03-25
										</td>
									</tr>
									<tr>
										<td class="image">
											<img src="/assets/images/data/data_100x100_03.jpg" alt="상품 이미지">
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
										</td>
										<td class="qna_text">
											<a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
										</td>
										<td>답변대기</td>
										<td>
											2016-03-25
										</td>
									</tr>
									<tr>
										<td class="image">
											<img src="/assets/images/data/data_100x100_02.jpg" alt="상품 이미지">
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
										</td>
										<td class="qna_text">
											<a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
										</td>
										<td>답변대기</td>
										<td>
											2016-03-25
										</td>
									</tr>
									<tr>
										<td class="image">
											<img src="/assets/images/data/data_100x100_02.jpg" alt="상품 이미지">
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
										</td>
										<td class="qna_text">
											<a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
										</td>
										<td>답변대기</td>
										<td>
											2016-03-25
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
			
			<!-- Q&#38;A 수정하기 레이어 // -->
			<?
			$qidx=0;
			foreach($qna_list as $qrow){?>
			<div class="layer layer_qna" id="layer_qna_modify<?=$qidx?>">
				<div class="layer_inner">
					<h1 class="layer_title">Q&#38;A 수정하기</h1>
					<div class="layer_cont">
						<table class="normal_table normal_table__bg">
							<caption class="hide">Q&#38;A 수정하기</caption>
							<colgroup>
								<col style="width:135px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row">상품명</th>
									<td><span class="bold">[<?=$qrow['BRAND_NM']?>]</span> <?=$qrow['GOODS_NM']?></td>
								</tr>
								<tr>
									<th sope="row"><label for="formEmailAddress">문의제목</label></th>
									<td><input type="text" class="input_text" id="formEmailAddress" value="<?=$qrow['Q_TITLE']?>" style="width: 310px;" name="title<?=$qidx?>"/></td>
								</tr>
								<tr>
									<th sope="row"><label for="formContent">내용</label></th>
									<td>
										<textarea resize="none" class="input_text" id="formContent" style="width: 488px;" name="content<?=$qidx?>"><?=str_replace('<br />',"\n",$qrow['Q_CONTENTS'])?></textarea>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<ul class="btn_list">
						<li><button type="button" class="btn_positive" onClick="javaScipr:modify_goods_qna(<?=$qidx?>, <?=$qrow['Q_NO']?>);">수정하기</button></li>
						<li><button type="button" class="btn_negative" onClick="javaScript: close_layout(<?=$qidx?>);">수정취소</button></li>
					</ul>
					<a href="#layer_qna_modify<?=$qidx?>" data-ui="layer-closer" class="spr-common layer_close" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>
			</div>
			<?
			$qidx++;
			}?>
			<!-- // Q&#38;A 수정하기 레이어 -->

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
	
				document.location.href = "/mywiz/qna_page/"+page+"?"+param;
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

			//====================================
			// 체크박스 전체선택
			//====================================
			function jsChkAll(pBool){				
				for (var i=0; i<document.getElementsByName("chkQna[]").length; i++){
					document.getElementsByName("chkQna[]")[i].checked = pBool;
				}
			}

			//=====================================
			// 레이어 열기
			//=====================================
			function open_layout(idx, answer){
				
				if(answer){
					alert("답변이 달린 문의는 수정하실 수 없습니다.");
					return false;
				}else{
					//레이어 열기
					$("#layer_qna_modify"+idx).attr('class','layer layer_qna layer__view');
				}
			}

			//=====================================
			// 레이어 닫기
			//=====================================
			function close_layout(idx){
				
				//레이어 초기화
				$("#layer_qna_modify"+idx).attr('class','layer layer_qna');
			}

			//=====================================
			// 상품문의 수정하기
			//=====================================
			function modify_goods_qna(idx, qna_no){

				var title = $("input[name=title"+idx+"]").val(),
					content = $("textarea[name=content"+idx+"]").val();

//				alert(title);
				
				if(confirm("상품평을 수정하시겠습니까?")){
					
					$.ajax({
						type: 'POST',
						url: '/mywiz/update_goods_qna',
						dataType: 'json',
						data: { qna_no : qna_no,
								title : title, 
								content : content
							},
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("수정되었습니다.");
								location.reload();
							}
							else alert(res.message);
						}
					});
				}
			}

			//=====================================
			// 상품문의 삭제하기
			//=====================================
			function delete_goods_qna(qna_no, qna_con_no){

				if(confirm("문의를 삭제하시겠습니까?")){
					
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_qna',
						dataType: 'json',
						data: { qna_no : qna_no, 
								qna_con_no : qna_con_no
							},
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

			//====================================
			// 선택삭제
			//====================================
			function chk_delete_goods_qna(){
				var qnaArr = new Array();
				$("input:checkbox[name='chkQna[]']:checked").each(function() {
					qnaArr.push($(this).val());     // 체크된 것만 값을 뽑아서 배열에 push
				});

				if(qnaArr.length == 0){
					alert("삭제할 문의를 선택해주세요.");
					return false;
				}

				if(confirm("선택한 문의를 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/chk_delete_qna',
						dataType: 'json',
						data: { qnaArr : qnaArr },
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