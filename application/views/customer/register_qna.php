					<div class="mypage_cont">
						<?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
						<h3 class="title_page title_page__mypage">비회원 문의하기</h3>
						<?}else{?>
						<h3 class="title_page title_page__mypage">문의하기</h3>
						<?}?>
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
											<!--<div class="select_wrap" style="width:169px;">
												<select id="formInquiry0101" style="width:169px;">
													<option>1:1 문의</option>
												</select>
											</div>-->
											<div class="select_wrap" style="width:340px;">
												<label for="formInquiry0102">상세구분선택</label>
												<select id="formInquiry0102" style="width:340px;" name="type">
													<option value="">상세구분선택</option>
													<?foreach($qna_type as $row){?>
													<option value="<?=$row['CS_QUE_TYPE_CD']?>"><?=$row['CS_QUE_TYPE_CD_NM']?></option>
													<?}?>
												</select>
											</div>
                                            <?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
                                            <div class="checkbox_area">
                                                <input type="checkbox" class="checkbox" id="secret_content" name="secret_yn" value="Y" checked/> <label class="checkbox_label" for="secret_content">비밀글</label>
                                            </div>
                                            <?}?>
										</td>
									</tr>
									<?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
									<tr>
										<th scope="row"><label for="formInquiry0201">상품명</label></th>
										<td>
											<div class="position_area">
												<input type="text" id="formInquiry0201" class="input_text" style="width: 340px;" name="goods_nm" disabled/>
												<a href="javaScript:jsDelete('G');" class="spr-mypage spr-btn_delete" title="상품명삭제"></a>
												
												<button type="button" class="btn_white" data-ui="layer-opener" data-target="#layer_cs_center_01">주문상품 조회</button>
											</div>
										</td>
									</tr>
									<?}?>
									<tr>
										<th scope="row"><label for="formInquiry0301">이름</label></th>
										<td>
											<input type="text" id="formInquiry0301" class="input_text" style="width: 340px;" name="name"/>
											<input type="hidden" name="goods_cd">
											<input type="hidden" name="order_refer_no">
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0401">연락처</label></th>
										<td>
											<input type="text" id="formInquiry0401" class="input_text" style="width: 340px;" name="phone" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                                            <div class="checkbox_area">
                                                <input type="checkbox" class="checkbox" id="formAgree01" name="sms_yn" value="Y"/> <label class="checkbox_label" for="formAgree01">답변여부 SMS로 받음</label>
                                            </div>
                                            <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                                                <div class="checkbox_area">
                                                    <input type="checkbox" class="checkbox" id="formAgree03_1"> <label class="checkbox_label" for="formAgree03_1">개인정보 수집·이용에 동의</label>
                                                </div>
                                                <button type="button" class="btn_white" data-ui="layer-opener" data-target="#layer_form_agree03">내용보기</button>
                                            <?}?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0501">이메일</label></th>
										<td>
											<input type="text" id="formInquiry0501" class="input_text" style="width: 340px;" name="email"/>
											<?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
                                                <div class="checkbox_area">
                                                    <input type="checkbox" class="checkbox" id="formAgree02" name="email_yn" value="Y"/> <label class="checkbox_label" for="formAgree02">답변 이메일로 받음</label>
                                                </div>
											<?}else{?>
                                                <div class="checkbox_area">
                                                    <input type="checkbox" class="checkbox" id="formAgree03_2"> <label class="checkbox_label" for="formAgree03_2">개인정보 수집·이용에 동의</label>
                                                </div>
                                                <button type="button" class="btn_white" data-ui="layer-opener" data-target="#layer_form_agree03">내용보기</button>
                                                <br/><span>* 비회원 문의는 이메일로 답변을 받아보실수있습니다.</span>
                                                <input type="hidden" name="email_yn" value="Y">
											<?}?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0601">제목</label></th>
										<td>
											<input type="text" id="formInquiry0601" class="input_text" style="width: 789px;" name="title"/>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formInquiry0701">내용</label></th>
										<td>
											<textarea resize="none" class="input_text detail_cancel_text" id="formInquiry0701" style="width: 789px;" name="content" placeholder="* 문의하실 주문번호 or 상품번호를 남겨주세요."></textarea>
										</td>
									</tr>
								</tbody>
									<tr>
										<th scope="row"><label for="formInquiry0801">이미지첨부</label></th>
										<td>
											<div class="position_area">
												<input type="text" id="formInquiry0801" class="input_text" style="width: 340px;" name="file_url" disabled/>
												<a href="javaScript:jsDelete('F');" class="spr-mypage spr-btn_delete" title="첨부파일삭제"></a>
												<label for="fileUpload" class="btn_white" >파일찾기</label>
												<input type="file" id="fileUpload" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this);" name="fileUpload">
												<span class="small_text">jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.</span>
											</div>
										</td>
									</tr>

							</table>
						</form>
						</div>
						<ul class="btn_list">
							<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:register_qna();">문의하기</button></li>
							<!--<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:test_upload();">문의하기</button></li>-->
							<li><button type="button" class="btn_negative btn_negative__min" onClick="javaScript:location.href='/customer/'">문의취소</button></li>
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
										<td><input type="radio" name="order_refer" id="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']?>" value="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']."||".$orow['GOODS_NM']?>"></td>
										<td>
                                            <label for="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']?>">
                                                <?=$orow['ORDER_NO']?><br/>(<?=substr($orow['REG_DT'],0, 10)?>)
                                            </label>
                                        </td>
										<td class="image">
                                            <label for="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']?>">
                                                <img src="<?=$orow['IMG_URL']?>" alt="" width="100" height="100"/>
                                            </label>
										</td>
										<td class="goods_detail__string">
                                            <label for="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']?>">
                                                <p class="name"><?=$orow['GOODS_NM']?></p>
                                                <p class="description"><?=$orow['PROMOTION_PHRASE']?></p>
                                                <p class="option"><?=$orow['GOODS_OPTION_NM']?></p>
                                            </label>
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

            <!-- 개인정보 수집·이용 동의 레이어 // -->
            <div class="layer layer_form_agree03" id="layer_form_agree03">
                <div class="layer_inner">
                    <h1 class="layer_title">개인정보 수집·이용 동의</h1>
                    <div class="layer_cont">
                        <div class="use_clause_box">
                            <ul class="use_clause_list">
                                <li>
                                    <span class="title">■ [필수] 개인정보 수집·이용 동의</span>

                                    <div class="table_basic_type">
                                        <table>
                                            <caption>개인정보 수집·이용 동의 정보 표</caption>
                                            <colgroup>
                                                <col style="width: 180px;">
                                                <col style="width: 220px;">
                                                <col>
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th scope="col">목적</th>
                                                <th scope="col">항목</th>
                                                <th scope="col">보유기간</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>이용자 식별 및 본인여부 확인</td>
                                                <td>성명, 아이디, 비밀번호, 비밀번호 힌트</td>
                                                <td>답변 등록 후 7일까지</td>
                                            </tr>
                                            <tr>
                                                <td>계약 이행을 위한 연락 민원<br> 등 고객 고충 처리</td>
                                                <td>연락처(이메일, 휴대전화번호)</td>
                                                <td>답변 등록 후 7일까지</td>
                                            </tr>
                                            <tr>
                                                <td>만 14세 미만 아동인지 확인</td>
                                                <td>법정 생년월일</td>
                                                <td>답변 등록 후 7일까지</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul>
                                        <li>※ 서비스 제공을 위해서 필요한 최소한의 개인정보이므로 동의를 해 주셔야 서비스를 이용하실 수 있습니다.</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a href="#layer_form_agree03" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
                </div>
                <div class="dimd"></div>
            </div>
            <!-- // 개인정보 수집·이용 동의 레이어 -->

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
			function register_qna(){
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
                <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                if($("#formAgree03_1").is(":checked") == false || $("#formAgree03_2").is(":checked") == false){
                    alert("개인정보 수집·이용에 동의해주시기 바랍니다.");
                    return false;
                }
                <?}?>

				if(confirm("1:1문의를 등록하시겠습니까?")){
				
					$.ajax({
						type: 'POST',
						url: '/customer/register_qna',
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
									alert("등록되었습니다.");
									location.href="/customer/qna_finish";
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

			//====================================
			// 주문내역 페이징
			//====================================
			function orderPageNavigation( page ){
				var totalPage = "<?=$total_page?>",
					endPage = Math.ceil(page/5)*5,
					startPage = endPage-4,
					active = "";

				if(endPage > totalPage){
					endPage = totalPage;
//					startPage = Math.ceil(page%5);
				}

//				alert(page%5);

//				alert(startPage);

				$.ajax({
					type: 'POST',
					url: '/customer/order_page',
					dataType: 'json',
					data: { page : page},
					error: function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
//							alert(res.result[0]['SELLING_PRICE'].replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,'));
//							alert(Math.ceil(0.																																							2));
							var str_result = "";
							var str_page = "";
							var pre	= "<a href=\"javaScript:orderPageNavigation("+(page-1)+");\" class='page_prev'> <span class='spr-common spr_arrow_left'></span>Pre</a>";
							var next = "<a href=\"javaScript:orderPageNavigation("+(page+1)+");\" class='page_next'> Next	<span class='spr-common spr_arrow_right'></span></a>";

							if(page == 1) pre = "";
							if(totalPage <= page) next = "";

							for(i=0; i<res.order.length; i++){

								str_result += "<tr> " +
                                    "<td>" +
                                    "<input type='radio' name='order_refer' id='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"' value='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"||"+res.order[i]['GOODS_NM']+"'>" +
                                    "</td> " +
                                    "<td>" +
                                    "<label for='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"'>" +
                                    "<a href='#' class='link'>"+res.order[i]['ORDER_NO']+"<br/>("+res.order[i]['REG_DT'].substr(0,10)+")</a>" +
                                    "</label>" +
                                    "</td> " +
                                    "<td class='image'>" +
                                    "<label for='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"'>" +
                                    "<img src='"+res.order[i]['IMG_URL']+"' alt='' width='100' height='100'/>" +
                                    "</label>" +
                                    "</td> " +
                                    "<td class='goods_detail__string'> " +
                                    "<label for='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"'>" +
                                    "<p class='name'>"+res.order[i]['GOODS_NM']+"</p> " +
                                    "<p class='description'>"+res.order[i]['PROMOTION_PHRASE']+"</p> " +
                                    "<p class='option'>"+res.order[i]['GOODS_OPTION_NM']+"</p> " +
                                    "</label>" +
                                    "</td> " +
                                    "</tr>";
							}
							str_page = pre+"<ul class='page_list'> ";
							for(idx=startPage; idx<=endPage ; idx++){
								if(page == idx){
									active = "active";
								}else{
									active = "";
								}

								str_page += "<li class='page_item "+active+"'><a href='javaScript:orderPageNavigation("+idx+");'>"+idx+"</a></li>";
							}

							str_page +=" </ul>"+next;

//

							$("#page_test").html(str_page);
							$("#test").html(str_result);

						}
						else alert(res.message);
					}
				});
			}

			//=====================================
			// 상품선택(주문선택)
			//=====================================
			function chkOrder(val){
				if(!val){
					alert("적용하실 상품을 선택해주세요.");
					return false;
				}
				arr_value = val.split("||");
				$("input[name=goods_nm]").val(arr_value[2]);
				$("input[name=goods_cd]").val(arr_value[1]);
				$("input[name=order_refer_no]").val(arr_value[0]);

				$('#layer_cs_center_01').attr('class','layer layer_cs_center_01');
//				alert($("input[name=goods_nm]").val());


			}


			</script>



