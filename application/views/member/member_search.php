<link rel="stylesheet" href="/assets/css/login.css">

			<div class="contents login_search">
				<h2 class="page_title page_title__search"><?=$title?></h2>

				<div class="login_box">
						<h3 class="login_title">회원 가입정보로 찾기</h3>
						<?if($type == 'password'){?>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<label for="formInputName">아이디</label>
							</dt>
							<dd class="login_form_data">
								<input type="text" id="formInputName" class="input_text" style="width: 317px;" name="id"/>
							</dd>
						</dl>
						<?}?>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<label for="formInputName">이름</label>
							</dt>
							<dd class="login_form_data">
								<input type="text" id="formInputName" class="input_text" style="width: 317px;" name="name"/>
							</dd>
						</dl>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<label for="formInputEmail">이메일</label>
							</dt>
							<dd class="login_form_data">
								<input type="text" id="formInputEmail" class="input_text" style="width: 73px;" name="email1"/>
								<span class="dash">@</span>
								<input type="text" id="formInputEmail" class="input_text" style="width: 73px;" name="email2"/>
								<div class="select_wrap" style="width:107px;">
									<label for="formMailSelect">이메일선택</label>
									<select id="formMailSelect" style="width:107px;" onChange="javascript:$('input[name=email2]').val(this.value);">
										<option value=''>직접입력</option>
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
							</dd>
							<dd class="login_form_data">
								<?if($type == 'id'){?><p class="login_form_tip">간편인증은 아이디의 일부가 ***로 표시됩니다.<br />회원정보에 등록된 이름, 이메일을 입력해주세요.</p><?}?>
							</dd>
						</dl>
						<button type="button" class="btn_positive btn_positive__search" onClick="javaScript:searchMember();">확인</button>
					</div>

					<form id="hidForm" name="hidForm" method="post">
						<input type="hidden" name="email">
						<input type="hidden" name="id">
						<input type="hidden" name="hid_id">
						<input type="hidden" name="reg_dt">
						<input type="hidden" name="type">
					</form>

					<!--<div class="login_nonmember">
						<h3 class="login_title">본인인증으로 찾기</h3>
						<p class="login_form_tip">2016년 1월 이후 가입자는 본인인증으로 찾기가 불가합니다.</p>
						<div class="search_certify">
							<div class="search_certify_handphone">
								<div class="search_certify_box">
									<span class="spr-login login_ico_handphone"></span>
								</div>
								<button type="button" class="btn_negative btn_negative__min">휴대폰 인증</button>
							</div>
							<div class="search_certify_ipin">
								<div class="search_certify_box">
									<span class="spr-login login_ico_ipin"></span>
								</div>
								<button type="button" class="btn_negative btn_negative__min">아이핀 인증</button>
							</div>
						</div>
					</div>
				</div>-->
			</div>

			<script type="text/javaScript">

			//====================================
			// ID찾기
			//====================================
			function searchMember()
			{
				var type = "<?=$type?>"
					, name = $("input[name=name]").val()
					, email = $("input[name=email1]").val()+"@"+$("input[name=email2]").val()
					, id = "";

				if(type == 'password') id = $("input[name=id]").val();
				$.ajax({
					type: 'POST',
					url: '/member/search_member',
					dataType: 'json',
					data: { name : name , email : email, id : id, type: type},
					error : function(res) {
						alert('Database Error');
						alert(res.responseText);
					},
					success: function(res) {
						if(res.status == 'ok'){
//							location.href="/member/id_search_finish?name="+name+"&email="+email;
//							alert(res.member);
							$("input[name=id]").val(res.member['CUST_ID']);
							$("input[name=email]").val(res.member['EMAIL']);
							$("input[name=hid_id]").val(res.member['ID']);
							$("input[name=reg_dt]").val(res.member['REG_DT']);
							$("input[name=type]").val(type);

							var v = document.hidForm;
							v.target = "_self";
							v.action = "/member/search_finish";
							v.submit();
						}
						else {
							alert(res.message);
						}
					}
				})
			}

			</script>