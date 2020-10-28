<link rel="stylesheet" href="/assets/css/member.css">

<div class="contents member">
    <h2 class="page_title">MEMBERSHIP</h2>

    <div class="join_box">
        <div class="join_email">
            <form method="post" id="mainform" name="mainform" action="">
                <input type="hidden" id="chk_phone" name="chk_phone" value="" />
                <input type="hidden" id="chk_auth" name="chk_auth" value="" />
                <input type="hidden" id="sns_id" name="sns_id" value="" />
                <input type="hidden" id="return_url" name="return_url" value="<?=$returnUrl?>">
                <h3 class="join_title">휴대전화 인증 회원가입</h3>
                <dl class="join_form_line">
                    <dt class="join_form_title">
                        <label for="formInputId">휴대폰번호</label>
                    </dt>
                    <dd class="join_form_data">
                        <div class="select_wrap" style="width:97px;">
                            <select id="formJoin05_1" name="mem_mobile1" style="width: 97px;">
                                <option value="010" selected>010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="019">019</option>
                            </select>
                        </div>
                        <span class="dash">- </span>
                        <input type="text" id="formJoin05_2" name="mem_mobile2" class="input_text" value="" style="width: 100px; ime-mode:disabled;" maxlength="4" onkeyup="CheckNum(this);"/>
                        <span class="dash">- </span>
                        <input type="text" id="formJoin05_3" name="mem_mobile3" class="input_text" value="" style="width: 100px; ime-mode:disabled;" onkeyup="CheckNum(this);" maxlength="4"/>

                        <br/>
                        <button type="button" class="btn_white" id="auth_btn1" name='auth_btn1'onClick="javascript:SendPhoneAuth();">인증번호 요청</button>
                    </dd>
                </dl>
                <dl class="join_form_line">
                    <dt class="join_form_title">
                        <label for="formInputPw">인증번호 입력</label>
                    </dt>
                    <dd class="join_form_data">
                        <input type="text" id="formJoin06" name="mem_auth" class="input_text" style="width: 200px;">
                        <button type="button" id="auth_btn2"class="btn_white" onClick="javascript:re_SendPhoneAuth();" disabled>인증번호 재요청</button>
                        <p class="join_form_tip">정보입력은 인증문자를 통한 인증 후 가능합니다.</p>
                        <button type="button"  class="btn_positive certi" onClick="javascript:CheckPhone();">인증하기</button>
                        <span class="small_text" id="auth_text"></span>
                    </dd>
                </dl>
            </form>
        </div>

        <div class="join_sns">
            <h3 class="join_title">SNS인증 회원가입</h3>
            <p><button type="button" class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID로 회원가입</button></p>
            <p><button type="button" class="btn_sns kakao" onclick="javascript:loginWithKakao();">카카오ID로 회원가입</button></p>
        </div>
    </div>
    <br/><br/>
</div>


<script type="text/javascript">

    /** 체크박스 전체선택/해제	**/
    function jsChkAll(pBool){
        for (var i=0; i<document.getElementsByName("formAgree[]").length; i++){
            document.getElementsByName("formAgree[]")[i].checked = pBool;
        }
    }

    //==============================================================
    // 숫자입력 유효성 검사
    //==============================================================
    function CheckNum(input){
        var regular = /[^0-9]/;
        var v = input;
        if(regular.test(v.value)){
            alert("숫자만 입력해주세요.");
            v.value = "";
            v.focus();
        }
    }

    //===============================================================
    // 휴대전화 인증번호 보내기
    //===============================================================
    function SendPhoneAuth()
    {
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

        var mem_mobile1 = $("select[name=mem_mobile1]").val();
        var mem_mobile2 = $("input[name=mem_mobile2]").val();
        var mem_mobile3 = $("input[name=mem_mobile3]").val();

        if (mem_mobile2 == "") {
            alert("휴대폰번호를 입력하지 않았습니다.");
            $("input[name=mem_mobile2]").focus();
            return false;
        }

        if (mem_mobile3 == "") {
            alert("휴대폰번호를 입력하지 않았습니다.");
            $("input[name=mem_mobile3]").focus();
            return false;
        }

        if(mem_mobile2.length != 3 && mem_mobile2.length != 4){
            alert("휴대폰번호의 형식에 맞지 않습니다.");
            $("input[name=mem_mobile2]").focus();
            return false;
        }

        if(mem_mobile3.length != 4){
            alert("휴대폰번호의 형식에 맞지 않습니다.");
            $("input[name=mem_mobile3]").focus();
            return false;
        }

        if ($('input[name=chk_phone]').val() != "")
        {
            if(!confirm("인증번호를 재발송 하시겠습니까?")){
                return false;
            }
        }

        var mem_mobile = mem_mobile1+"-"+mem_mobile2+"-"+mem_mobile3;
        $.ajax({
            type: 'POST',
            url: 'https://'+SSL_val+'/member/phone_check',
            dataType: 'json',
            data: { 'mem_mobile' : mem_mobile },
            error: function(res) {
                alert('Database Error');
                alert(res.responseText);
                console.log(res.responseText);
            },
            success: function(res) {
                console.log(res);
                if(res.status == 'ok'){
                    $('input[name=chk_phone]').val(res.mem_mobile);
                    $('input[name=chk_auth]').val(res.auth_code);
                    alert("인증번호가 발송되었습니다.");
                    document.getElementById('auth_btn1').innerText = '인증번호 발송';
                    document.getElementById('auth_btn1').disabled  = true;
                    document.getElementById('auth_btn2').disabled  = false;
                }
                else {
                    alert(res.message);
                    //console.log(res.message);
                    $("input[name=mem_mobile2]").focus();
                }

            }
        })
    }

    //===============================================================
    // 휴대전화 인증번호 다시 보내기
    //===============================================================
    function re_SendPhoneAuth()
    {
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

        var mem_mobile1 = $("select[name=mem_mobile1]").val();
        var mem_mobile2 = $("input[name=mem_mobile2]").val();
        var mem_mobile3 = $("input[name=mem_mobile3]").val();

        if (mem_mobile2 == "") {
            alert("휴대폰번호를 입력하지 않았습니다.");
            $("input[name=mem_mobile2]").focus();
            return false;
        }

        if (mem_mobile3 == "") {
            alert("휴대폰번호를 입력하지 않았습니다.");
            $("input[name=mem_mobile3]").focus();
            return false;
        }

        if(mem_mobile2.length != 3 && mem_mobile2.length != 4){
            alert("휴대폰번호의 형식에 맞지 않습니다.");
            mem_mobile2.focus();
            return false;
        }

        if(mem_mobile3.length != 4){
            alert("휴대폰번호의 형식에 맞지 않습니다.");
            mem_mobile3.focus();
            return false;
        }

        if ($('input[name=chk_phone]').val() != "")
        {
            if(!confirm("인증번호를 재발송 하시겠습니까?")){
                return false;
            }
        }

        var mem_mobile = mem_mobile1+"-"+mem_mobile2+"-"+mem_mobile3;
        $.ajax({
            type: 'POST',
            url: 'https://'+SSL_val+'/member/phone_check',
            dataType: 'json',
            data: { 'mem_mobile' : mem_mobile },
            error: function(res) {
                alert('Database Error');
                alert(res.responseText);
            },
            success: function(res) {
                if(res.status == 'ok'){
                    $('input[name=chk_phone]').val(res.mem_mobile);
                    $('input[name=chk_auth]').val(res.auth_code);
                    alert("인증번호가 발송되었습니다.");
                }
                else {
                    alert(res.message);
                    $("input[name=mem_mobile1]").focus();
                }

            }
        })
    }
    //===============================================================
    // 휴대전화 인증번호 확인
    //===============================================================
    function CheckPhone()
    {
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

        var mem_auth1 = $("input[name=mem_auth]").val();
        var mem_auth2 = $("input[name=chk_auth]").val();
        var mem_mobile = $("input[name=chk_phone]").val();

        if(mem_auth1 == ""){
            alert("인증번호를 입력해주세요.");
            $("input[name=mem_auth").focus();
            return false;
        }

        if(mem_auth1 == mem_auth2){

            $.ajax({
                type: 'POST',
                url: 'https://'+SSL_val+'/member/mobile_auth_check',
                dataType: 'json',
                data: { 'mem_mobile' : mem_mobile, 'auth_code' : mem_auth2 },
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        /* document.getElementById("auth_text").innerHTML = "<font color=blue>인증이 완료되었습니다.</font>";*/
                        $("input[name=chk_auth]").val('Y');
                        alert('인증이 완료되었습니다.');
                        jsJoin();
                    } else {
                        document.getElementById("auth_text").innerHTML = "<font color=red>인증번호가 일치하지 않습니다.</font>";
                    }
                }
            })
        } else {
//		alert("인증번호가 일치하지 않습니다.");
            document.getElementById("auth_text").innerHTML = "<font color=red>인증번호가 일치하지 않습니다.</font>";
        }
    }

    //===============================================================
    // 회원가입
    //===============================================================
    function jsJoin()
    {
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

        var f  = document.mainform;
        f.method = 'POST';
        f.action = "https://"+SSL_val+"/member/member_join";
        f.submit();
    }
    //===============================================================
    // 카카오 회원가입
    //===============================================================
    function loginWithKakao(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/kakao_login","login-naver","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }
    //===============================================================
    // 네이버 회원가입
    //===============================================================
    function loginWithNaver(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }

</script>
