			<div class="mypage_cont">
						<h3 class="title_page title_page__mypage"><?=$title?> <span class="title_page_text">(회원님의 개인정보 보호를 위해 비밀번호를 다시 한번 입력해 주시기 바랍니다.)</span></h3>

						<div class="personal_data_password">
							<label for="formPassword">비밀번호</label>
							<input type="password" id="formPassword" class="input_text" style="width: 252px;" onKeyPress="javascript:if(event.keyCode == 13){ check_password(); return false;}" autofocus/>
							<button type="button" class="btn_black" onClick="javaScript:check_password();">비밀번호확인</button>
						</div>
					</div>
				</div>
			</div>

			<script type="text/javaScript">
			//====================================
			// 회원로그인
			//====================================
			function check_password()
			{
				var password = $("#formPassword").val()
					, type = "<?=$nav?>";

				switch(type){
					case 'D' : url = '/mywiz/delivery';	break;
					case 'MI' : url = '/mywiz/myinfo';	break;
					case 'ML' : url = '/member/leave';	break;
                    case 'MS' : url = '/mywiz/sns';	break;
				}

				$.ajax({
					type: 'POST',
					url: '/mywiz/check_password',
					dataType: 'json',
					data: { password : password },
					error : function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
							location.href = url;
						}
						else{
							alert(res.message);
							$("#formPassword").focus();
						}
					}
				})

				return true;
			}
			</script>