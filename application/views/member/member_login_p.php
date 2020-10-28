<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAHOME GUIDE FONTS</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="/assets/css/main.css">
		<link rel="stylesheet" href="/assets/css/member.css">
		<link rel="stylesheet" href="/assets/css/login.css">
		<link rel="stylesheet" href="/assets/css/common.css">
		<link rel="stylesheet" href="/assets/css/display.css">

		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

	</head>

	<body>
		<div class="wrap">
			<div class="contents login">
				<h2 class="page_title">LOGIN</h2>
				<form method="post" name="mainform" id="mainform">
				<input type="hidden" id="login_gb" name="login_gb" value="">	<!-- 아이디로 로그인인지 이메일로 로그인인지 구분 -->

				<div class="login_box">
					<div class="login_member">
						<h3 class="login_title">회원 로그인</h3>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<label for="formInputId">아이디(또는 이메일)</label>
							</dt>
							<dd class="login_form_data">
								<input type="text" id="formInputId" name="mem_id" class="input_text" placeholder="ID 또는 이메일" style="width: 317px;"/>
							</dd>
						</dl>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<label for="formInputPw">비밀번호</label>
							</dt>
							<dd class="login_form_data">
								<input type="password" id="formInputPw" name="mem_password" class="input_text" placeholder="비밀번호" style="width: 317px;"/>
							</dd>
							<dd class="login_form_data">
								<div class="checkbox_area">
									<input type="checkbox" class="checkbox" id="formIdSave" name="id_save"/> <label class="checkbox_label" for="formIdSave">아이디 저장</label>
								</div>
								<p class="login_form_tip">(개인정보 보호를 위해 개인 PC에서만 이용해 주세요.)</p>
							</dd>
						</dl>
						<button type="button" class="btn_positive btn_positive__login" onClick="javascript:jsLogin();">로그인</button>
						<ul class="login_menu">
							<li class="login_menu_item"><a href="#">아이디 찾기</a></li>
							<li class="login_menu_item"><a href="#">비밀번호 찾기</a></li>
							<li class="login_menu_item"><a href="/member/member_join">회원가입</a></li>
						</ul>
					</div>

					<div class="login_nonmember">
						<h3 class="login_title">비회원 로그인</h3>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<label for="formInputId02">구매자명</label>
							</dt>
							<dd class="login_form_data">
								<input type="text" id="formInputId02" class="input_text" placeholder="ID 또는 이메일ID" style="width: 317px;" />
							</dd>
						</dl>
						<dl class="login_form_line">
							<dt class="login_form_title">
								<div class="radio_area">
									<input type="radio" name="a" class="radio" id="formOrderNum" /> <label for="formOrderNum" class="radio_label">주문번호</label>
									<input type="radio" name="a" class="radio" id="formcellNum" /> <label for="formcellNum" class="radio_label">휴대폰번호</label>
								</div>
							</dt>
							<dd class="login_form_data">
								<label><input type="text" class="input_text" placeholder="주문 시 입력한 휴대폰번호(-없이 입력)" style="width: 225px;" /></label><button type="button" class="btn_white btn_certify">휴대폰인증</button>
							</dd>
							<dd class="login_form_data">
								<p class="login_form_tip">주문번호를 잊으신 경우, <br />에타홈 고객센터 1688-4945로 문의하여 주시기 바랍니다.</p>
							</dd>
						</dl>
						<button type="button" class="btn_negative btn_negative__login">비회원 로그인</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript">

//===============================================================
// 회원로그인
//===============================================================
function jsLogin()
{
	var mf		= document.mainform;

	if( ! $("input[name=mem_id]").val() ){
		alert("아이디를 입력해 주십시오");
		mf.mem_id.focus();
		return false;
	}
	if( ! $("input[name=mem_password]").val() ){
		alert("비밀번호를 입력해 주십시오");
		mf.mem_password.focus();
		return false;
	}

	var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
		if(exptext.test($("input[name=mem_id]").val())==true){	//이메일 형식인지 아이디 형식인지 구분
			mf.login_gb.value = "email";
		} else {
			mf.login_gb.value = "id";
		}

	//아이디저장
	if (mf.id_save.checked == true)	{
		$.cookie('saveid', mf.mem_id.value, { expires: 7, path: '/' });
	}
	else {
		$.removeCookie('saveid', { path: '/' });
	}

	var param = $("#mainform").serialize();
	$.ajax({
		type: 'POST',
		url: '/member/login',
		dataType: 'json',
		data: param,
		error : function(res) {
			alert('Database Error');
		},
		success: function(res) {
			if(res.status == 'ok'){
				location.href = "<?=$returnUrl?>";
			}
			else{
				alert(res.message);
			}
		}
	})

	return true;
}

$(function(){
		if($.cookie('saveid')) $("input:checkbox[id='formIdSave']").attr("checked", true); $("input[name=mem_id]").val($.cookie('saveid'));
	})
</script>