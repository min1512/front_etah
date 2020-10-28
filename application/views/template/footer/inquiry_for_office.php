			<link rel="stylesheet" href="/assets/css/display.css?ver=1.1">
			
			<div class="contents inquiry_office">
				<h2 class="page_title">입점문의</h2>
				<div class="inquiry_office_inner">
					<ol class="inquiry_office_progress">
						<li class="inquiry_office_progress_item">
							<span class="spr-common spr_ico_inquiry_office_01"></span>
							<span class="title">입점업체<br />문의</span><br />
							<span class="explain">입점문의 작성</span>
							<span class="spr-common spr_ico_inquiry_office_arrow"></span>
							<span class="line"></span>
						</li>
						<li class="inquiry_office_progress_item">
							<span class="spr-common spr_ico_inquiry_office_02"></span>
							<span class="title">담당MD 검토 후<br />연락</span><br />
							<span class="explain">검토결과 E-Mail로<br />발송</span>
							<span class="spr-common spr_ico_inquiry_office_arrow"></span>
						</li>
						<li class="inquiry_office_progress_item">
							<span class="spr-common spr_ico_inquiry_office_03"></span>
							<span class="title">입점의뢰서<br />작성</span><br />
							<span class="explain">회원정보 입력 및<br />구비서류를 발송</span>
							<span class="spr-common spr_ico_inquiry_office_arrow"></span>
						</li>
						<li class="inquiry_office_progress_item">
							<span class="spr-common spr_ico_inquiry_office_04"></span>
							<span class="title">담당MD<br />입점 승인</span><br />
							<span class="explain">회원정보 검증&#47;접수된<br />구비서류 심사</span>
							<span class="spr-common spr_ico_inquiry_office_arrow"></span>
						</li>
						<li class="inquiry_office_progress_item">
							<span class="spr-common spr_ico_inquiry_office_05"></span>
							<span class="title">계약체결 및<br />상품 업로드</span><br />
							<span class="explain">구비서류 최종확인<br />상품 업로드</span>
							<span class="spr-common spr_ico_inquiry_office_arrow"></span>
						</li>
						<li class="inquiry_office_progress_item">
							<span class="spr-common spr_ico_inquiry_office_06"></span>
							<span class="title">담당MD 승인 후<br />상품판매</span><br />
							<span class="explain">상품 검토 후<br />판매 승인</span>
						</li>
					</ol>


                    <form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
					<div class="inquiry_office_table_wrap">
						<h3 class="table_title">문의내용 입력</h3>
						<table class="normal_table">
							<caption>문의내용 입력표</caption>
							<colgroup>
								<col style="width:145px" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th><label for="inquiryForm0101">회사명</label></th>
									<td>
										<input type="text" id="inquiryForm0101" class="input_text" value="" style="width: 260px;" name="company_nm"/>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0201">사업장주소</label></th>
									<td>
										<div class="td_composition_item">
											<input type="text" id="inquiryForm0201" class="input_text" value="" style="width: 144px;" name="post_no" disabled>
											<!--<button type="button" class="btn_white" onClick="javaScript:searchAddressOpen('I');" >우편번호찾기</button>-->
											<button type="button" class="btn_white" onclick="execDaumPostcode('inquiryForm0201','','address1','','address2');">우편번호검색</button>
										</div>
										<div class="td_composition_item">
											<label><input type="text" class="input_text" style="width: 804px;" id="address1" name="address1" disabled ></label>
										</div>
										<div class="td_composition_item">
											<label><input type="text" class="input_text" style="width: 804px;" id="address2" name="address2" ></label>
										</div>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0301">상품카테고리</label></th>
									<td>
										<div class="select_wrap" style="width:168px;">
											<label for="inquiryForm0301">상품카테고리</label>
											<select id="formMailSelect" style="width:168px;" name="category" onChange="javaScript:if(this.value == 'write'){ $('#disp_cate').css('display','');}else{$('#disp_cate').css('display','none');}">
												<!--<option value="">상품카테고리</option>-->
												<option value="write" checked>직접입력</option>
												<?foreach($category_list as $crow){?>
												<option value="<?=$crow['CATEGORY_DISP_NM']?>"><?=$crow['CATEGORY_DISP_NM']?></option>
												<?}?>
												
											</select>
										</div>
										<label id="disp_cate" ><input type="text" class="input_text" value="" style="width: 159px;" name="category_write"/></label>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0401">브랜드&#47;상품명</label></th>
									<td>
										<input type="text" id="inquiryForm0401" class="input_text" value="" style="width: 260px;" name="brand_goods_nm"/>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0501">상품&#47;회사설명</label></th>
									<td>
										<textarea id="inquiryForm0501" class="input_text" value="" style="width: 804px;" name="company_desc"></textarea>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0601">담당자명</label></th>
									<td>
										<input type="text" id="inquiryForm0601" class="input_text" value="" style="width: 260px;" name="name"/>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0701">전화번호</label></th>
									<td>
										<input type="text" id="inquiryForm0701" class="input_text" value="" style="width: 260px;" name="phone"/>
									</td>
								</tr>
								<tr>
									<th><label for="inquiryForm0801">이메일</label></th>
									<td>
										<input type="text" id="inquiryForm0801" class="input_text" value="" style="width: 260px;" name="email"/>
									</td>
								</tr>
                                <tr>
                                    <th><label for="inquiryForm0901">사이트주소</label></th>
                                    <td>
                                        <input type="text" id="inquiryForm0901" class="input_text" value="" style="width: 260px;" name="siteMapUrl"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="inquiryForm1001">파일첨부</label></th>
                                    <td>
                                        <div class="position_area">
                                            <input type="text" id="inquiryForm1001" class="input_text" style="width: 340px;" name="file_url" value="" disabled/>
                                            <a href="javaScript:jsDel();" class="spr-mypage spr-btn_delete" title="첨부파일삭제"></a>
                                            <label for="fileUpload" class="btn_white">파일찾기</label>
                                            <input type="file" id="fileUpload" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this);" name="fileUpload">
                                            <span class="small_text">pdf, ppt파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.</span>
                                        </div>
                                    </td>
                                </tr>
							</tbody>
						</table>

						<h3 class="table_title">입점&#47;제휴문의 및 상담을 위한 정보수집동의</h3>
						<div class="inquiry_info_agree">
							<p class="inquiry_info_agree_text">(주)에타는 개인정보보호법, 정보통신망 이용촉진 및 정보보호 등에 관한 법률 등 관련 법령 상의 개인정보보호 규정을 준수하며, 서비스 제공을 위하여 필요한 최소한의 <br />정보만을 아래와 같이 수집 및 이용하고 있습니다.</p>
							<div class="table_basic_type">
								<table>
									<caption>약관동의 정보 표</caption>
									<colgroup>
										<col style="width:321px;" />
										<col style="width:320px;" />
										<col />
									</colgroup>
									<thead>
										<tr>
											<th>수집항목</th>
											<th>이용목적</th>
											<th>보유기간</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>입점&#47;제휴 문의자가 입력한 회사명, 사업장주소<br />담당자명, 전화번호, 이메일</td>
											<td>입점&#47;제휴 상담 및 검토</td>
											<td>수집된 정보는 입점&#47;제휴문의 및 상담서비스가<br />종료되는 시점까지</td>
										</tr>
									</tbody>
								</table>
							</div>
							<p class="inquiry_info_agree_text">귀하는 개인정보제공 등에 관해 동의하지 않거나 거부할 권리가 있으며, 정보 제공을 거부하는 경우 해당 정보가 필요한 일부 서비스의 제공이 제한될 수 있습니다.</p>
							<p class="checkbox_area">
								<input type="checkbox" class="checkbox" id="formofficeAgree" name="chk_agree"/>
								<label class="checkbox_label" for="formofficeAgree">입점&#47;제휴문의 및 상담을 위한 개인정보를 수집하는데 동의합니다. </label>
							</p>
						</div>
					</div>
                    </form>

					<ul class="btn_list" style="margin-top:60px;">
						<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:information_submit();">문의하기</button></li>
						<li><button type="button" class="btn_negative btn_negative__min" onClick="history.back();">문의취소</button></li>
					</ul>


				</div>

			</div>

			<div id="search_address"></div>

			<script type="text/javaScript">

			//====================================
			// 우편번호 검색(탭 클릭시 탭 전환)
			//====================================
			function jsPostChg(gubun){
				if(gubun == '2'){	//도로명주소 선택한경우
					$('li[name=old_postal]').removeClass();
					$('li[name=new_postal]').addClass('active');
					$('ul[name=postalCodeCont01]').hide();
					$('ul[name=postalCodeCont02]').show();
				} else if(gubun == '1'){	//지번주소 선택한경우
					$('li[name=new_postal]').removeClass();
					$('li[name=old_postal]').addClass('active');
					$('ul[name=postalCodeCont01]').show();
					$('ul[name=postalCodeCont02]').hide();
				}
			}

			//====================================
			// 우편번호 검색
			//====================================
			function jsPostnum(search_dong){
				$.ajax({
						type: 'POST',
						url: '/cart/get_postnum',
						dataType: 'json',
						data: { dong : search_dong },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							$('#loading').show();
							if(res.status == 'ok'){
								//검색시 초기화.
								$('input[name=chk_detailadd]').val('N');
								$('span[name=basic_addr]').text('');
								$('span[name=post_num]').text('');
								$('input[name=add_addr]').val('');
								$('span[name=basic_addr2]').hide();
								$('span[name=post_num2]').hide();

								//검색결과 붙여넣기
								$('span[name=old_addr_cnt]').text('('+res.old_addr_cnt+')');
								$('ul[name=postalCodeCont01]').html(res.old_addr);	//지번주소

								$('span[name=new_addr_cnt]').text('('+res.new_addr_cnt+')');
								$('ul[name=postalCodeCont02]').html(res.new_addr);	//지번주소
							}
							else alert(res.message);
						}
					})
			}
			
			//====================================
			// 주소 클릭시 붙여넣기
			//====================================
			function jsPastepost(gubun, idx){

				if(gubun == '1'){	//지번주소
					$('span[name=basic_addr]').text($($("input[name='addr_v1[]']").get(idx)).val());
					$('span[name=post_num]').text($($("input[name='addr_post1[]']").get(idx)).val());
					$('span[name=basic_addr2]').hide();
					$('span[name=post_num2]').hide();
					$('input[name=use_addr]').val($($("input[name='addr_v1[]']").get(idx)).val());
					$('input[name=use_post]').val($($("input[name='addr_post1[]']").get(idx)).val());
					$('span[name=basic_addr2]').text($($("input[name='addr_v1[]']").get(idx)).val());
					$('span[name=post_num2]').text("("+$($("input[name='addr_post1[]']").get(idx)).val()+")");
				} else if(gubun == '2'){	//도로명주소
					$('span[name=basic_addr]').text($($("input[name='addr_v2[]']").get(idx)).val());
					$('span[name=post_num]').text($($("input[name='addr_post2[]']").get(idx)).val());
					$('span[name=basic_addr2]').hide();
					$('span[name=post_num2]').hide();
					$('input[name=use_addr]').val($($("input[name='addr_v2[]']").get(idx)).val());
					$('input[name=use_post]').val($($("input[name='addr_post2[]']").get(idx)).val());
					$('span[name=basic_addr2]').text($($("input[name='addr_v2[]']").get(idx)).val());
					$('span[name=post_num2]').text("("+$($("input[name='addr_post2[]']").get(idx)).val()+")");
				}

			}
			

			//====================================
			// 상세주소입력 버튼 클릭시 
			//====================================
			function jsDetailaddr(){
				if(!$('input[name=use_addr]').val()) return false;
			//	$('input[name=use_addr]').val($('input[name=use_addr]').val()+" "+$('input[name=add_addr]').val());
				$('span[name=add_addr2]').text($('input[name=add_addr]').val());
				$('span[name=basic_addr2]').show();
				$('span[name=post_num2]').show();
				$('input[name=chk_detailadd]').val('Y');
			}
			
			//====================================
			// 주소사용
			//====================================
			function jsUseaddr(){
				if($('input[name=chk_detailadd]').val() == 'N'){
					alert("상세주소를 입력하여 버튼을 눌러주세요.");
					return false;
				}
				else{
					$('input[name=post_no]').val(($('input[name=use_post]').val()).replace('-', ''));
					$('input[name=address1').val($('input[name=use_addr]').val());
					$('input[name=address2').val($('input[name=add_addr]').val());
					$('#layer__postal_code_search_01').removeClass();
					$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
				}
			}

			//====================================
			// 레이어 닫기
			//====================================
			function layerClose(idx){
				if(!idx){
					$('#formAddress0101').val("");
					$('#formAddress0201').val("");
					$('#formAddress0301').val("010");
					$('#formAddress0301-2').val("");
					$('#formAddress0301-3').val("");
					$('#formAddress0401').val("");
					$('#address1').val("");
					$('#address2').val("");

					$("#layer_address_regist").attr('class','layer layer_address');
				}else{
					$('#formAddress0102').val($('#delivery_name'+idx).val());
					$('#formAddress0202').val($('#receiver_name'+idx).val());
					$('#formAddress0302').val($('#phone1_'+idx).val());
					$('#formAddress0302-2').val($('#phone2_'+idx).val());
					$('#formAddress0302-3').val($('#phone3_'+idx).val());
					$('#formAddress0402').val($('#zipcode'+idx).val());
					$('#address3').val($('#addr1'+idx).val());
					$('#address4').val($('#addr2'+idx).val());

					$("#layer_address_modify_"+idx).attr('class','layer layer_address');
				}
			}

			//====================================
			// 우편번호 검색 열기
			//====================================
			function searchLayerOpen(val){
				$("#layer__postal_code_search_01").attr('class','layer layer__postal_code_search layer__view');

				var ele = $('#layer__postal_code_search_01').find('.layer_inner'),
					top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
					left = - (ele.width() / 2);
				if ( top < $(window).scrollTop() ) {
					top = $(window).scrollTop();
				}

				ele.css( {
					'top' : top,
					'margin-left' : left
				} );

				$('#gubun').val(val);
			}

			//====================================
			// 우편번호 검색 닫기(다시검색)
			//====================================
			function searchLayerClose(){
				$('input[name=chk_detailadd]').val('N');
				$('input[name=add_addr]').val('');
				$('input[name=use_addr]').val('');
				$('input[name=use_post]').val('');
				$('span[name=basic_addr]').text('');
				$('span[name=post_num]').text('');
				$('span[name=basic_addr2]').text('');
				$('span[name=post_num2]').text('');
				$('span[name=add_addr2]').text('');

//				$("#layer__postal_code_search_01").attr('class','layer layer__postal_code_search');

				$('span[name=old_addr_cnt]').text('');
				$('ul[name=postalCodeCont01]').html('');	//지번주소

				$('span[name=new_addr_cnt]').text('');
				$('ul[name=postalCodeCont02]').html('');	//지번주소
	
			}

            //=======================================
            // URL 형식 체크 함수 생성
            //=======================================
            function urlChk(str){
                var pattern = new RegExp(/^(((http(s?))\:\/\/)?)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?$/);

                if(!pattern.test(str)) {
                    return false;
                } else {
                    return true;
                }
            }

			//====================================
			// 문의하기
			//====================================
			function information_submit(){
                var data = new FormData($('#updFile')[0]);
                data.append("post_no", $('input[name=post_no]').val());
                data.append("address1", $('input[name=address1]').val());

				var company_nm = $('input[name=company_nm]').val(), 
					post_no = $('input[name=post_no]').val(),
					address1 = $('input[name=address1]').val(),
					address2 = $('input[name=address2]').val(),
					category = $('select[name=category]').val(),
					name = $('input[name=name]').val(),
					phone = $('input[name=phone]').val(),
					email = $('input[name=email]').val(),
					category_write = $('input[name=category_write]').val(),
					brand_goods_nm = $('input[name=brand_goods_nm]').val(),
					company_desc = $('textarea[name=company_desc]').val(),
                    siteMapUrl = $('input[name=siteMapUrl]').val();

				if(company_nm == ""){
					alert("회사명을 입력해주세요.");
					$('input[name=company_nm]').focus();
					return false;
				}
				if((post_no == "")||(address1 == "")){
					alert("주소를 입력해주세요.");
					$('input[name=post_no]').focus();
					return false;
				}
				if(address2 == ""){
					alert("상세주소를 입력해주세요.");
					$('input[name=address2]').focus();
					return false;
				}
				if(category == ""){
					alert("카테고리를 선택해주세요.");
					$('select[name=category]').focus();
					return false;
				}else if(category == "write"){
					if(category_write == ""){
						alert("카테고리를 입력해주세요.");
						$('input[name=category_write]').focus();
						return false;
					}
				}
				if(brand_goods_nm == ""){
					alert("브랜드/상품명 입력해주세요.");
					$('input[name=brand_goods_nm]').focus();
					return false;
				}
				if(company_desc == ""){
					alert("상품/회사설명을 입력해주세요.");
					$('textarea[name=company_desc]').focus();
					return false;
				}
				if(name == ""){
					alert("담당자명을 입력해주세요.");
					$('input[name=name]').focus();
					return false;
				}
				if(phone == ""){
					alert("전화번호를 입력해주세요.");
					$('input[name=phone]').focus();
					return false;
				}
				if(email == ""){
					alert("이메일을 입력해주세요.");
					$('input[name=email]').focus();
					return false;
				}
				if(email.indexOf("@") < 1 || email.indexOf(".") < 3) {
					alert("올바른 이메일 주소가 아닙니다.");
//					updFile.email.value = "";
					$('input[name=email]').focus();
					return false;
				}
                if(siteMapUrl != ""){
                    if(!urlChk(siteMapUrl)){
                        alert("사이트주소URL을 다시 확인하십시오!");
                        $('input[name=siteMapUrl]').focus();
                        return false;
                    }
                }
                if($("input[name=fileUpload]").val()){
                    if(!fileChk($("input[name=fileUpload]").val())){
                        alert("ppt, pdf 파일만 업로드 가능합니다.");
                        return false;
                    }
                }
				if(!($("input[name=chk_agree]").is(":checked"))){
					alert("입점/제휴문의 및 상담을 위한 개인정보를 수집하는데 동의하셔야만 입점문의가 가능합니다.");
					$('input[name=chk_agree]').focus();
					return false;
				}

				$.ajax({
					type: 'POST',
					url: '/footer/inquiry_for_office',
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
                            location.href="/footer/inquiry_for_office";
						}
						else alert(res.message);
					}
				});

			}


			//====================================
			// 우편번호 찾기
			//====================================
			function searchAddressOpen(gb){
				
				$.ajax({
					type: 'POST',
					url: '/footer/search_address',
					dataType: 'json',
					data: { gubun : gb},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.search_address);
							$("#search_address").html(res.search_address);
						}
						else alert(res.message);
					}
				});

				$("#layer__postal_code_search_01").attr('class','layer layer__postal_code_search layer__view');

				var ele = $('#layer__postal_code_search_01').find('.layer_inner'),
					top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
					left = - (ele.width() / 2);
				if ( top < $(window).scrollTop() ) {
					top = $(window).scrollTop();
				}

				ele.css( {
					'top' : top,
					'margin-left' : left
				} );

				
			}

			//====================================
			// 주소 클릭시 붙여넣기
			//====================================
			function jsPastepost(aGubun, idx){
				if(aGubun == '1'){	//지번주소
					$("input[name='post_no']").val($($("input[name='addr_post1[]']").get(idx)).val());
					$("input[name='address1']").val($($("input[name='addr_v1[]']").get(idx)).val());

					//레이어 닫기
					$('#layer__postal_code_search_01').removeClass();
					$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
					$('#layer_address_list').removeClass();
					$('#layer_address_list').addClass('layer layer_address_list');
			
				} else if(aGubun == '2'){	//도로명주소
					$("input[name='post_no']").val($($("input[name='addr_post2[]']").get(idx)).val());
					$("input[name='address1']").val($($("input[name='addr_v2[]']").get(idx)).val());

					//레이어 닫기
					$('#layer__postal_code_search_01').removeClass();
					$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
					$('#layer_address_list').removeClass();
					$('#layer_address_list').addClass('layer layer_address_list');
				}
            }

            //=======================================
            // 확장자 체크 함수 생성
            //=======================================
            function fileChk(str){
                var pattern = new RegExp(/\.(ppt|pptx|pdf)$/i);

                if(!pattern.test(str)) {
                    return false;
                } else {
                    return true;
                }
            }

            //===============================================================
            // 파일경로 지우기
            //===============================================================
            function jsDel(){
                $("#fileUpload").replaceWith($("#fileUpload").clone(true));
                $("#fileUpload").val('');
                $("input[name=file_url]").val('');
            }

            //=====================================
            // 파일경로 보여주기
            //=====================================
            function viewFileUrl(input){
                if($("input[name=fileUpload]").val()){	//파일 확장자 확인
                    if(!fileChk($("input[name=fileUpload]").val())){
                        alert("ppt, pdf 파일만 업로드 가능합니다.");

                        //파일 초기화
                        $("#fileUpload").replaceWith($("#fileUpload").clone(true));
                        $("#fileUpload").val('');
                        $("input[name=file_url]").val('');
                        return false;
                    }
                }

                if(input.files[0].size > 1024*2000){
                    alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

                    //파일 초기화
                    $("#fileUpload").replaceWith($("#fileUpload").clone(true));
                    $("input[name=file_url]").val('');
                    return false;
                }

                else {
                    $("input[name=file_url]").val($("input[name=fileUpload]").val());
                }

            }

            </script>

