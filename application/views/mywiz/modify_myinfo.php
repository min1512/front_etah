					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">개인정보수정</h3>

						<div class="personal_data_modify">
							<form id="infoForm" name="infoForm">
							<table class="normal_table">
								<caption class="hide">배송지정보 입력표</caption>
								<colgroup>
									<col style="width:146px" />
									<col />
								</colgroup>
								<tbody>
									<tr>
										<th scope="row"><label for="formName">이름</label></th>
										<td><input type="text" id="formName" class="input_text" value="<?=$info['CUST_NM']?>" style="width: 260px;" name="member_name" disabled/></td>
									</tr>
									<tr>
										<th scope="row"><label for="formId">아이디</label></th>
										<td><input type="text" id="formId" class="input_text" value="<?=$info['CUST_ID']?>" style="width: 260px;" name="member_id" disabled/></td>
									</tr>
									<tr>
										<th scope="row"><label for="formId_01">새비밀번호</label></th>
										<td>
											<input type="password" id="formId_01" class="input_text" style="width: 260px;" name="member_pw"/>
											<span class="small_text">공백없는 8~16자의 영문/숫자를 조합하여 입력해야합니다.</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formId_02">새비밀번호 확인</label></th>
										<td>
											<input type="password" id="formId_02" class="input_text" style="width: 260px;" name="member_pw2"/>
											<span class="small_text">비밀번호 확인을 위해 다시 한번 입력해주세요.</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formBirth_01">생년월일</label></th>
										<td>
											<div class="select_wrap" style="width:97px;">
												<select id="formBirth_01" style="width:97px;" name="member_birth1">
													<option value="" <?=$info['BIRTH_DY'] ? "" : "selected"?>>----</option>
													<? for($i=1930; $i<2017; $i++){	?>
													<option value="<?=$i?>" <?=substr($info['BIRTH_DY'],0,4) == $i ? "selected" : ""?>><?=$i?></option>
													<? }?>
												</select>
											</div>
											<span class="dash_text">년</span>
											<div class="select_wrap" style="width:97px;">
												<label for="formBirth_02">월선택</label>
												<select id="formBirth_02" style="width:97px;" name="member_birth2">
													<option value="" <?=$info['BIRTH_DY'] ? "" : "selected"?>>--</option>
													<? for($i=1; $i<13; $i++){	?>
													<option value="<?=$i<10 ? "0".$i : $i?>" <?=substr($info['BIRTH_DY'],4,2) == $i ? "selected" : ""?>><?=$i<10 ? "0".$i : $i?></option>
													<? }?>
												</select>
											</div>
											<span class="dash_text">월</span>
											<div class="select_wrap" style="width:97px;">
												<label for="formBirth_03">일선택</label>
												<select id="formBirth_03" style="width:97px;" name="member_birth3">
													<option value="" <?=$info['BIRTH_DY'] ? "" : "selected"?>>--</option>
													<? for($i=1; $i<32; $i++){	?>
													<option value="<?=$i<10 ? "0".$i : $i?>" <?=substr($info['BIRTH_DY'],6,2) == $i ? "selected" : ""?>><?=$i<10 ? "0".$i : $i?></option>
													<? }?>
												</select>
											</div>
											<span class="dash_text">일</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="formAddressInput">주소</label></th>
										<td>
											<div class="td_composition_item">
												<input type="text" id="formAddressInput" class="input_text" style="width: 152px;" name="post_no" disabled value="<?=$info['ZIPCODE']?>"/>
												<!--<button type="button" class="btn_white" onClick="javaScript:searchAddressOpen('I');">우편번호검색</button>-->
												<button type="button" class="btn_white" onclick="execDaumPostcode('formAddressInput','','address1','','address2');">우편번호검색</button>
											</div>
											<div class="td_composition_item">
												<label><input type="text" class="input_text" style="width: 762px;" placeholder="기본 주소" id="address1" name="address1" disabled value="<?=$info['ADDR1']?>"/></label>
											</div>
											<div class="td_composition_item">
												<label><input type="text" class="input_text" style="width: 762px;" placeholder="상세 주소" id="address2" name="address2" value="<?=$info['ADDR2']?>"/></label>
											</div>
											<input type="hidden" name="zipcode" />
											<input type="hidden" name="addr1" />
											<input type="hidden" name="addr2" />
										</td>
									</tr>
								<!--<tr>
										<th scope="row"><label for="formNumSelect01">전화번호</label></th>
										<td>
											<div class="select_wrap" style="width:97px;">
												<select id="formNumSelect01" style="width:97px;" name="phone1">
													<option>02</option>
													<option>031</option>
													<option>032</option>
													<option>064</option>
													<option>055</option>
												</select>
											</div>
											<span class="dash">-</span>
											<label><input type="text" class="input_text" style="width: 100px;" /></label>
											<span class="dash">-</span>
											<label><input type="text" class="input_text" style="width: 100px;" /></label>
										</td>
									</tr>-->
									<tr>
										<th scope="row"><label for="formNumSelect02">휴대폰번호</label></th>
										<td>
											<div class="select_wrap" style="width:97px;">
												<select id="formNumSelect02" style="width:97px;" name="mob_phone1">
													<option <?=$info['arr_phone'][0] == '010' ? "selected" : ""?>>010</option>
													<option <?=$info['arr_phone'][0] == '011' ? "selected" : ""?>>011</option>
													<option <?=$info['arr_phone'][0] == '016' ? "selected" : ""?>>016</option>
													<option <?=$info['arr_phone'][0] == '017' ? "selected" : ""?>>017</option>
													<option <?=$info['arr_phone'][0] == '019' ? "selected" : ""?>>019</option>
												</select>
											</div>
											<span class="dash">- </span>
											<label><input type="text" class="input_text" style="width: 100px;" name="mob_phone2" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" value="<?=$info['arr_phone'][1]?>"/></label>
											<span class="dash">- </span>
											<label><input type="text" class="input_text" style="width: 100px;" name="mob_phone3" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" value="<?=$info['arr_phone'][2]?>"/></label>
										</td>
									</tr>

									<tr>
										<th scope="row"><label for="formEmailInput_01">이메일</label></th>
										<td>
											<input type="hidden" name="hid_email"		value="<?=$info['EMAIL']?>">
											
											<input type="text" class="input_text" id="formEmailInput_01" value="<?=$info['arr_email'][0]?>" style="width: 152px;" name="email1" onkeypress="javaScript:onKeypressEmail();" disabled/>
											<span class="dash">@</span>
											<label><input type="text" class="input_text" value="<?=$info['arr_email'][1]?>" style="width: 159px;" name="email2" onkeypress="javaScript:onKeypressEmail();" disabled/></label>
											<!--<div class="select_wrap" style="width:169px;">
												<label for="formEmailInput_02">메일주소선택</label>
												<select id="formEmailInput_02" style="width:169px;" onChange="javascript:$('input[name=email2]').val(this.value);">
													<option value="">직접입력</option>
													<option value="naver.com">naver.com</option>
													<option value="daum.net">daum.net</option>
													<option value="hotmail.com">hotmail.com</option>
													<option value="nate.com">nate.com</option>
													<option value="yahoo.co.kr">yahoo.co.kr</option>
													<option value="paran.com">paran.com</option>
													<option value="empas.com">empas.com</option>
													<option value="dreamwiz.com">dreamwiz.com</option>
													<option value="freechal.com">freechal.com</option>
													<option value="lycos.co.kr">lycos.co.kr</option>
													<option value="korea.com">korea.com</option>
													<option value="gmail.com">gmail.com</option>
													<option value="hanmir.com">hanmir.com</option>
												</select>
											</div>
											<button type="button" class="btn_white" onClick="javaScript:checkEmail();">중복확인</button>-->
											<input type="hidden" name="email_chk" value="N">
										</td>
									</tr>

                                    <tr>
                                        <th scope="row">성별</th>
                                        <td>
                                            <div class="radio_area radio_area__gray">
                                                <input type="radio" name="mem_gender" class="radio" id="formGender_01" value="MALE" <?if($info['GENDER_GB_CD']=='MALE'){?>checked<?}?>/> <label for="formGender_01" class="radio_label">남자</label>
                                                <input type="radio" name="mem_gender" class="radio" id="formGender_02" value="FEMALE" <?if($info['GENDER_GB_CD']=='FEMALE'){?>checked<?}?>/> <label for="formGender_02" class="radio_label">여자</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">반려동물 유무</th>
                                        <td>
                                            <div class="radio_area radio_area__gray">
                                                <input type="radio" name="petYn" class="radio" id="formPet_01" value="Y" <?if($info['PET_YN']=='Y'){?>checked<?}?>/> <label for="formPet_01" class="radio_label">있음</label>
                                                <input type="radio" name="petYn" class="radio" id="formPet_02" value="N" <?if($info['PET_YN']=='N'){?>checked<?}?>/> <label for="formPet_02" class="radio_label">없음</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">결혼 유무</th>
                                        <td>
                                            <div class="radio_area radio_area__gray">
                                                <input type="radio" name="merry" class="radio" id="formMerry_01" value="Y" <?if($info['MERRY_YN']=='Y'){?>checked<?}?>/> <label for="formMerry_01" class="radio_label">예</label>
                                                <input type="radio" name="merry" class="radio" id="formMerry_02" value="N" <?if($info['MERRY_YN']=='N'){?>checked<?}?>/> <label for="formMerry_02" class="radio_label">아니오</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>추천인 ID</th>
                                        <td>
                                            <input type="hidden" id="chk_rcmdId" name="chk_rcmdId" value="<?=$info['RCMD_ID']?>" />
                                            <input type="text" id="rcmdID" class="input_text" value="<?=$info['RCMD_ID']?>" style="width: 142px;" name="rcmdID" <?if($info['RCMD_ID'] != ''){?>readonly<?}?>>
                                            <button type="button" class="btn_black" style="width: 70px;" <?if($info['RCMD_ID'] == ''){?>onclick="javaScript:jsRecommendId($('#rcmdID').val())"<?}?>>ID 확인</button>
                                        </td>
                                    </tr>

									<tr>
										<th scope="row">SNS 수신동의</th>
										<td>
											<div class="radio_area radio_area__gray">
												<input type="radio" name="sns" class="radio" id="formSnsAggree_01" <?=$info['MOB_REC_YN'] ? "" : "checked='checked'"?> <?=$info['MOB_REC_YN'] == 'Y' ? "checked='checked'" : ""?> value="Y"/> <label for="formSnsAggree_01" class="radio_label">동의함</label>
												<input type="radio" name="sns" class="radio" id="formSnsAggree_02" <?=$info['MOB_REC_YN'] == 'N' ? "checked='checked'" : ""?> value="N" /> <label for="formSnsAggree_02" class="radio_label">동의안함</label>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">이메일 수신동의</th>
										<td>
											<div class="radio_area radio_area__gray">
												<input type="radio" name="email" class="radio" id="formEmailAggree_01" <?=$info['EMAIL_REC_YN'] == 'Y' ? "checked='checked'" : ""?> value="Y"/> <label for="formEmailAggree_01" class="radio_label">동의함</label>
												<input type="radio" name="email" class="radio" id="formEmailAggree_02" <?=$info['EMAIL_REC_YN'] == 'N' ? "checked='checked'" : ""?> value="N"/> <label for="formEmailAggree_02" class="radio_label">동의안함</label>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							</form>
							<ul class="btn_list">
								<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:modifyMyinfo();">정보수정</button></li>
								<li><button type="button" class="btn_negative btn_negative__min" onClick="window.location.href='/mywiz/check_password/MI';">수정취소</button></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<div id="search_address"></div>


			<script type="text/javaScript">
			
			//====================================
			//trim 함수 생성
			//====================================
			function trim(s){
				s = s.replace(/^\s*/,'').replace(/\s*$/,'');
				return s;
			}

			//====================================
			// 이메일 중복확인
			//====================================
			function checkEmail()
			{	
				var email = $("input[name=email]").val()
					, email2 = $("input[name=email2]").val();

				$.ajax({
					type: 'POST',
					url: '/mywiz/check_email',
					dataType: 'json',
					data: {email : email+"@"+email2},
					error: function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
								alert("사용가능합니다.");
								$("input[name=email_chk]").val("Y");
//								location.reload();
						}
						else alert(res.message);
					}
				});
			}

            //===============================================================
            // 추천인 ID 확인
            //===============================================================
            function jsRecommendId(val){
                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

                if(val == '') {
                    alert('추천인 ID를 입력해주세요.');
                    $('#rcmdID').focus();
                    return false;
                }

                if(val == infoForm.member_id.value){
                    alert('본인 ID를 추천인 ID에 입력할 수 없습니다.');
                    $('#rcmdID').focus();
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: 'https://'+SSL_val+'/member/rcmd_id_check',
                    dataType: 'json',
                    data: { 'rcmd_id' : val },
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            $('input[name=chk_rcmdId]').val(res.rcmd_id);
                            alert('사용 가능한 아이디입니다.');
                        }
                        else {
                            alert(res.message);
                        }

                    }
                })
            }

			//====================================
			// 정보수정
			//====================================
			function modifyMyinfo()
			{	
				if(infoForm.member_pw.value == ''){
					alert("비밀번호를 입력해주세요.");
					infoForm.member_pw.focus();
					return false;
				}
				if(infoForm.member_pw.value.length < 8 || infoForm.member_pw.value.length > 16 ){
					alert("비밀번호는 8자리 이상 16자리 이하로 입력하셔야 합니다.");
					infoForm.member_pw.focus();
					return false;
				}
				if (f_is_alpha(infoForm.member_pw)){
					alert("비밀번호는 영소문자와 숫자로만 구성됩니다.");
					infoForm.member_pw.value = "";
					infoForm.member_pw.focus();
					return false;
				}
				if(infoForm.member_pw2.value == ''){
					alert("비밀번호 확인을 입력해주세요.");
					infoForm.member_pw2.focus();
					return false;
				}
				if(infoForm.member_pw.value != infoForm.member_pw2.value){
					alert("비밀번호와 비밀번호 확인이 다릅니다.");
//					infoForm.member_pw.value = "";
//					infoForm.member_pw2.value = "";
					infoForm.member_pw2.focus();
					return false;
				}
				if(!trim(infoForm.mob_phone2.value) || !trim(infoForm.mob_phone3.value)){
					if(!trim(infoForm.mob_phone2.value)){
						alert("휴대전화의 국번을 입력해주세요.");
						infoForm.mob_phone2.focus();
						return false;
					}
					if(infoForm.mob_phone2.value.length < 3){
						alert("휴대전화의 국번은 3자리 이상이어야 합니다.");
						infoForm.mob_phone2.focus();
						return false;
					}
					if(!trim(infoForm.mob_phone3.value)){
						alert("휴대전화의 뒷자리를 입력해주세요.");
						infoForm.mob_phone3.focus();
						return false;
					}
					
					if(infoForm.mob_phone3.value.length < 4){
						alert("휴대전화의 뒷자리는 4자리 이상이어야 합니다.");
						infoForm.mob_phone3.focus();
						return false;
					}
					
				}
				if(infoForm.member_birth1.value || infoForm.member_birth2.value || infoForm.member_birth3.value){
					if(!infoForm.member_birth1.value){
						alert("생년월일을 모두 선택해주세요.");
						infoForm.member_birth1.focus();
						return false;
					}
					if(!infoForm.member_birth2.value){
						alert("생년월일을 모두 선택해주세요.");
						infoForm.member_birth2.focus();
						return false;
					}
					if(!infoForm.member_birth3.value){
						alert("생년월일을 모두 선택해주세요.");
						infoForm.member_birth3.focus();
						return false;
					}
				}
				if(infoForm.email1.value+"@"+infoForm.email2.value != infoForm.hid_email.value){
					if(infoForm.email_chk.value == 'N')
					alert("이메일 중복검사를 해주세요.");
					return false;
				}

                if(infoForm.rcmdID.value != "" && infoForm.chk_rcmdId.value == ""){
                    alert("추천인 ID 확인을 해주셔야 합니다.");
                    infoForm.rcmdID.focus();
                    return false;
                }

				$("input[name=zipcode]").val($("input[name=post_no]").val());
				$("input[name=addr1]").val($("input[name=address1]").val());
				$("input[name=addr2]").val($("input[name=address2]").val());

//				var	stringRegx = /[~!@\#$% <>^&*\()\-=+_\’]/gi; 
//				if( stringRegx.test(infoForm.member_name.value) )
				
				if(confirm("수정하시겠습니까?")){
					var data = $("#infoForm").serialize();
					$.ajax({
						type: 'POST',
						url: '/mywiz/myinfo',
						dataType: 'json',
						data: data,
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

			//====================================
			//패스워드검사,이메일
			//====================================
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

			//====================================
			//이메일 중복검사 체크
			//====================================
			function onKeypressEmail(){
				$("input[name=email_chk]").val("N");
			}

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


			//====================================
			// 우편번호 찾기
			//====================================
			function searchAddressOpen(gb){
				
				$.ajax({
					type: 'POST',
					url: '/mywiz/search_address',
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

			//====================================
			// 주소 클릭시 붙여넣기
			//====================================
			function jsPastepost1(gubun, idx){

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

//				$('span[name=basic_addr]').text($($("input[name='addr_v2[]']").get(idx)).val());
//				$('span[name=post_num]').text($($("input[name='addr_post2[]']").get(idx)).val());
//				$('span[name=basic_addr2]').hide();
//				$('span[name=post_num2]').hide();
//				$('input[name=use_addr]').val($($("input[name='addr_v2[]']").get(idx)).val());
//				$('input[name=use_post]').val($($("input[name='addr_post2[]']").get(idx)).val());
//				$('span[name=basic_addr2]').text($($("input[name='addr_v2[]']").get(idx)).val());
//				$('span[name=post_num2]').text("("+$($("input[name='addr_post2[]']").get(idx)).val()+")");

			}
			</script>