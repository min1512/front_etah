					<div class="mypage_cont member_leave">
						<h3 class="title_page title_page__mypage">회원탈퇴</h3>
						<h4 class="member_leave_title">회원탈퇴 사유</h4>
						<ul class="radio_check_list member_leave_reason">
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_01" checked="checked" value="01"/> <label for="formMemberLeave_01" class="radio_label">아이디(이메일주소) 변경을 위해 탈퇴 후 재가입</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_02" value="02"/> <label for="formMemberLeave_02" class="radio_label">상품 가격 불만</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_03" value="03"/> <label for="formMemberLeave_03" class="radio_label">장기간 부재 (군입대, 유학 등)</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_04" value="04"/> <label for="formMemberLeave_04" class="radio_label">배송 불만</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_05" value="05"/> <label for="formMemberLeave_05" class="radio_label">개인정보 누출 우려</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_06" value="06"/> <label for="formMemberLeave_06" class="radio_label">교환&#47;환불&#47;반품 불만</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_07" value="07"/> <label for="formMemberLeave_07" class="radio_label">상품의 다양성&#47;품질 불만</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_08" value="08"/> <label for="formMemberLeave_08" class="radio_label">사후조치 불만</label>
							</li>
							<li class="radio_area radio_area__gray radio_check_item radio_check_item__form">
								<input type="radio" name="member_leave" class="radio" id="formMemberLeave_09" value="09"/> <label for="formMemberLeave_09" class="radio_label">기타</label>
								<label><input type="text" class="input_text" style="width: 378px;" name="leave_comment"></label>
							</li>
						</ul>
                        <p class="member_leave_text">
                            - 회원 탈퇴 요청 후, 처리 기간이 일주일 정도 소요됩니다. 이 기간 중 홍보 문자, 메일이 발송될 수 있으니 양해 부탁드립니다.<br>
                            - 회원 탈퇴 후, 2주 후 재가입이 가능합니다.<br>
                            - 탈퇴하시게 되면 보유하고 계신 포인트 및 할인 쿠폰은 자동 소멸됩니다.
                        </p>
						<div class="checkbox_area member_leave_agree">
							<input type="checkbox" class="checkbox" id="formMemberLeaveAgree" name="member_leave_agree"> <label class="checkbox_label" for="formMemberLeaveAgree">회원탈퇴 안내를 모두 확인하였으며 회원 탈퇴에 동의합니다.</label>
						</div>
						<ul class="btn_list member_leave_btn">
							<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScipr:member_leave();">회원탈퇴</button></li>
							<li><button type="button" class="btn_negative btn_negative__min" onClick="window.history.back();">탈퇴취소</button></li>
						</ul>
					</div>
				</div>
			</div>

			<script type="text/javaScript">
			//====================================
			// 회원탈퇴
			//====================================
			function member_leave(){
				var leave_cd = $(":input:radio[name=member_leave]:checked").val()
					, leave_comment = $("input[name=leave_comment]").val()
					, leave_agree = $("input:checkbox[name=member_leave_agree]").is(":checked")//.attr('checked');

				if(leave_cd == '09' && !leave_comment){
					alert("기타 사유를 입력해주세요.");
					$("input[name=leave_comment]").focus();
					return false;
				}
				if(!leave_agree){
					alert("회원 탈퇴에 동의하지 않으셨습니다.");
					return false;
				}
				
				if(confirm("회원탈퇴를 하시겠습니까?")){
				<?if($this->session->userdata('EMS_U_SNS') =='Y' && empty($this->session->userdata('sns_kind'))){ //sns연동 고객인데 sns로 로그인 안한경우..?>
                    $.ajax({
                        type: 'POST',
                        url: '/member/sns_gubun',
                        dataType: 'json',
                        error: function(res) {
                            alert('Database Error');
                        },
                        success: function(res) {
                            if(res.status == 'ok'){
                                //								alert("수정되었습니다.");
                                //location.href="/member/leave_finish";
                                alert('앱 연동해제를 위해 로그인 해주시기 바랍니다.');
                                if(res.message == 'N'){
                                    loginWithNaver();
                                }else if(res.message == 'K'){
                                    loginWithKakao();
                                }else{
                                    alert(res.message);
                                }
                            }
                            else alert(res.message);
                        }
                    });
                <?}else{?>
					$.ajax({
						type: 'POST',
						url: '/member/leave',
						dataType: 'json',
						data: { leave_cd : leave_cd,
								leave_comment : leave_comment},
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
	//								alert("수정되었습니다.");
									location.href="/member/leave_finish";
							}
							else alert(res.message);
						}
					});
				<?}?>
				}
			}

            //===============================================================
            // 카카오
            //===============================================================
            function loginWithKakao(){
                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                window.open("https://"+SSL_val+"/member/kakao_login","login-kakao","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
            }
            //===============================================================
            // 네이버
            //===============================================================
            function loginWithNaver(){
                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
            }
			</script>

