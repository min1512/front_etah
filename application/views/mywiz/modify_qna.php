					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">
							1:1 문의 수정
						</h3>

						<div class="mypage_section">
							<form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
							<table class="normal_table cs_center_inquiry">
								<caption class="hide">문의하기 입력표</caption>
								<colgroup>
									<col style="width:146px" />
									<col />
								</colgroup>
								<tbody>
									<tr>
										<th scope="row"><label for="formInquiry0101">문의구분</label></th>
										<td>
											<div class="select_wrap" style="width:169px;">
												<label for="formInquiry0102">상세구분선택</label>
												<select id="formInquiry0102" style="width:169px;" name="type">
													<option value="">상세구분선택</option>
													<?foreach($qna_type as $row){?>
													<option value="<?=$row['CS_QUE_TYPE_CD']?>" <?=$row['CS_QUE_TYPE_CD'] == $qna['CS_QUE_TYPE_CD'] ? "selected" : ""?>><?=$row['CS_QUE_TYPE_CD_NM']?></option>
													<?}?>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0201">상품명</label></th>
										<td>
											<div class="position_area">
												<input type="text" id="formInquiry0201" class="input_text" style="width: 340px;" name="goods_nm" value="<?=$qna['GOODS_NM']?>"/>
												<input type="hidden" name="goods_cd">
												<input type="hidden" name="order_refer_no">
												<a href="javaScript:jsDelete('G');" class="spr-mypage spr-btn_delete" title="상품명삭제"></a>
												<button type="button" class="btn_white" data-ui="layer-opener" data-target="#layer_cs_center_01">주문상품 조회</button>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0301">이름</label></th>
										<td>
											<input type="text" id="formInquiry0301" class="input_text" style="width: 340px;" name="name" value="<?=$qna['QUE_CUST_NM']?>"/>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0401">연락처</label></th>
										<td>
											<input type="text" id="formInquiry0401" class="input_text" style="width: 340px;" name="phone" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" value="<?=$qna['QUE_CUST_PHONE_NO']?>"/>
											<input type="checkbox" class="checkbox" id="formAgree01" name="sms_yn" value="Y" <?=$qna['EMAIL_REPLAY_YN'] == 'Y' ? "checked" : ""?>/> <label class="checkbox_label" for="formAgree01">답변여부 SMS로 받음</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0501">이메일</label></th>
										<td>
											<input type="text" id="formInquiry0501" class="input_text" style="width: 340px;" name="email" value="<?=$qna['EMAIL']?>"/>
											<input type="checkbox" class="checkbox" id="formAgree02" name="email_yn" value="Y" <?=$qna['SMS_REPLAY_YN'] == 'Y' ? "checked" : ""?>/> <label class="checkbox_label" for="formAgree02">답변 이메일로 받음</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0601">제목</label></th>
										<td>
											<input type="text" id="formInquiry0601" class="input_text" style="width: 789px;" name="title" value="<?=$qna['TITLE']?>"/>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0701">내용</label></th>
										<td>
											<textarea resize="none" class="input_text detail_cancel_text" id="formInquiry0701" style="width: 789px;" name="content"><?=$qna['CONTENTS']?></textarea>
										</td>
									</tr>
								</tbody>
									<tr>
										<th scope="row"><label for="formInquiry0801">이미지첨부</label></th>
										<td>
											<div class="position_area">
												<input type="text" id="formInquiry0801" class="input_text" style="width: 340px;" name="file_url" value="<?=$qna['FILE_PATH']?>" disabled/>
												<a href="javaScript:jsDelete('F');" class="spr-mypage spr-btn_delete" title="첨부파일삭제"></a>
												<label for="fileUpload" class="btn_white" >파일찾기</label>
												<input type="file" id="fileUpload" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this);" name="fileUpload">
												<span class="small_text">jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.</span>
											</div>
											<input type="hidden" name="qna_no" value="<?=$qna_no?>">
											<input type="hidden" name="file_url_yn" value="N">
										</td>
									</tr>
									

							</table>
						</form>
						</div>
						<ul class="btn_list">
							<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:modify_qna();">수정하기</button></li>
							<li><button type="button" class="btn_negative btn_negative__min" onClick="javaScript:history.back();">수정취소</button></li>
						</ul>
					</div>
				</div>
			</div>

			<!-- 주문상품 조회 레이어 // -->
			<div class="layer layer layer_cs_center_01" id="layer_cs_center_01">
				<div class="layer_inner">
					<h1 class="layer_title">주문상품 조회</h1>
					<div class="layer_cont">
						<div class="board_list board_list__prd_info">
							<table class="board_list_table">
								<caption>최근주문정보 리스트</caption>
								<colgroup>
									<col style="width:80px" />
									<col style="width:120px;" />
									<col style="width:123px;" />
									<col />
								</colgroup>
								<thead>
									<tr>
										<!--<th scope="col">
											<input type="checkbox" id="all_check" class="checkbox" />
											<label for="all_check" class="checkbox_label"><span class="hide">전체선택</span></label>
										</th>-->
										<th scope="col">선택</th>
										<th scope="col">주문번호</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col" class="title_prd_info">상품명</th>
									</tr>
								</thead>
								<tbody id="test">
								<?if($order){
									foreach($order as $orow){?>
									<tr>
										<!--<td class="goods_select">
											<input type="checkbox" id="goods_select_0" class="checkbox" />
											<label for="goods_select_0" class="checkbox_label"><span class="hide">jacksonchameleon 선택</span></label>
										</td>-->
										<td><input type="radio" name="order_refer" value="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']."||".$orow['GOODS_NM']?>"></td>
										<td><a href="#" class="link"><?=$orow['ORDER_NO']?><br/>(<?=substr($orow['REG_DT'],0, 10)?>)</a></td>
										<td class="image">
											<img src="<?=$orow['IMG_URL']?>" alt="" width="100" height="100"/>
										</td>
										<td class="goods_detail__string">
											<p class="name"><?=$orow['GOODS_NM']?></p>
											<p class="description"><?=$orow['PROMOTION_PHRASE']?></p>
											<p class="option"><?=$orow['GOODS_OPTION_NM']?></p>
										</td>
									</tr>
								<?	}?>
								</tbody>
							</table>
						</div>
						<div class="page" id="page_test">
							<!--<a href="#" class="page_prev">
								<span class="spr-common spr_arrow_left"></span>Pre
							</a>-->
							<ul class="page_list">
								<li class="page_item active"><a href="#">1</a></li>
								<?for($i=2; $i<=$cnt_page; $i++){?>
								<li class="page_item"><a href="javaScript:orderPageNavigation(<?=$i?>);"><?=$i?></a></li>
								<?}?>
								<!--<li class="page_item"><a href="#">3</a></li>
								<li class="page_item"><a href="#">4</a></li>
								<li class="page_item"><a href="#">5</a></li>-->
							</ul>
							<?if($total_page > 5){?>
							<a href="javaScript:orderPageNavigation(2);" class="page_next">
								Next<span class="spr-common spr_arrow_right"></span>
							</a>
							<?}?>
						</div>
								<?}else{?>
									<tr>
										<td colspan="4">주문내역이 없습니다.</td>
									</tr>
									</tbody>
							</table>
						</div>
								<?}?>

									<!--<tr>
										<td class="goods_select">
											<input type="checkbox" id="goods_select_1" class="checkbox" />
											<label for="goods_select_1" class="checkbox_label"><span class="hide">jacksonchameleon 선택</span></label>
										</td>
										<td><a href="#" class="link">2016-01-26-327668</a></td>
										<td class="image">
											<img src="/assets/images/data/data_100x100_01.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
									</tr>-->

						<ul class="btn_list">
							<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:chkOrder($(':input:radio[name=order_refer]:checked').val());">상품적용</button></li>
							<li><button type="button" class="btn_negative btn_negative__min" onClick="javaScript:$('#layer_cs_center_01').attr('class','layer layer_cs_center_01');">적용취소</button></li>
						</ul>
					</div>

					<a href="#layer_cs_center_01" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>
			</div>
			<!-- // 주문상품 조회 레이어 -->


			<script type="text/javaScript">

			//=====================================
			// trim 함수 생성
			//=====================================
			function trim(s){
				s = s.replace(/^\s*/,'').replace(/\s*$/,'');
				return s;
			}

			//=====================================
			// 지우기
			//=====================================
			function jsDelete(val){
				if(val == 'G'){
					$("input[name=goods_nm]").val("");
					$("input[name=goods_cd]").val("");
					$("input[name=order_refer_no]").val("");
				}
				if(val == 'F'){
					$("input[name=file_url]").val("");
					$("input[name=fileUpload]").val("");
					$("input[name=fileUpload]").replaceWith( $("input[name=fileUpload]").clone(true) );
				}
			}

			//=====================================
			// 파일경로 보여주기
			//=====================================
			function viewFileUrl(input){
				if(input.files[0].size > 1024*2000){
					alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

					//파일 초기화
					$("#fileUpload").replaceWith($("#fileUpload").clone(true));
                    $("#fileUpload").val('');
					return false;
				}
				else {
					$("input[name=file_url]").val($("input[name=fileUpload]").val());
				}

			}

			//=====================================
			//패스워드검사,이메일
			//=====================================
			function f_is_alpha( it ){

				//영문 숫자 조합
				var alpha ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				var numeric = '1234567890';
				var blank = ' ';
				var nonkorean = alpha+numeric;
				var i ;
				var t = it.value ;
				for ( i=0; i<t.length; i++ )

					if( nonkorean.indexOf(t.substring(i,i+1)) < 0) {
						break ;
					}

				if ( i != t.length ) {
					return true;
				}

				return false;
			}

			function test(){
				alert($("#flUpload")[0].files[0].size);
//				if( input.files[0].size > (1024*500) ) {
//					alert("파일 최대용량을 초과하였습니다. \n파일은 500KB 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");
//
//					preImg.attr('src', '');
//					input.value="";
//					file.replaceWith( file.clone(true) );
//					return;
//				}
			}

			//=======================================
			// 확장자 체크 함수 생성
			//=======================================
			function imgChk(str){
				var pattern = new RegExp(/\.(gif|jpg|jpeg)$/i);

				if(!pattern.test(str)) {
					return false;
				} else {
					return true;
				}
			}

			//=======================================
			// 한글 체크 함수 생성
			//=======================================
			function korChk(str){
				var pattern = new RegExp(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/);

				return pattern.test(str);
			}

			//====================================
			// 문의작성
			//====================================
			function modify_qna(){
				var data = new FormData($('#updFile')[0]);

				if(trim($("select[name=type]").val()) == ""){
					alert("문의 상세 구분을 선택해주세요.");
					$("select[name=type]").focus();
					return false;
				}
				if(trim($("input[name=name]").val()) == ""){
					alert("문의자 이름을 입력해주세요.");
					$("input[name=name]").focus();
					return false;
				}
				if(trim($("input[name=phone]").val()) == ""){
					alert("연락처를 입력해주세요.");
					$("input[name=phone]").focus();
					return false;
				}
				if( ! trim($("input[name=email]").val()) ){
					alert("이메일을 입력해 주십시오.");
					$("input[name=email]").focus();
					return false;
				}
				if(updFile.email.value.indexOf("@") < 1 || updFile.email.value.indexOf(".") < 3) {
					alert("올바른 이메일 주소가 아닙니다.");
					updFile.email.value = "";
					updFile.email.focus();
					return false;
				}
				if(trim($("input[name=title]").val()) == ""){
					alert("문의 제목을 입력해주세요.");
					$("input[name=title]").focus();
					return false;
				}
				if(trim($("textarea[name=content]").val()) == ""){
					alert("문의 내용을 입력해주세요.");
					$("textarea[name=content]").focus();
					return false;
				}
				if($("input[name=file_url]").val()){
					if(!imgChk($("input[name=file_url]").val())){
						alert("jpg, gif 파일만 업로드 가능합니다.");
						return false;
					}
				}

				if(confirm("1:1문의를 수정하시겠습니까?")){
				
					$.ajax({
						type: 'POST',
						url: '/customer/modify_qna',
//						dataType: 'json',
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
									alert("수정되었습니다.");
									location.reload();
//									location.href="/customer/qna_finish";
							}
							else alert(res.message);
						},
						error: function(res) {
							alert(res);
			//				console.log(res.responseText);
							alert(res.responseText);
			//				btn.button('reset');
			//				btn2.button('reset');
			//				jsHiddenDel();
							return false;
						}
					});
				}
			}

			</script>