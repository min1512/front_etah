<link rel="stylesheet" href="/assets/css/member.css">
<div class="mypage_cont">
    <h3 class="title_page title_page__mypage">간편로그인 연동하기</h3>

    <div class="personal_data_modify">
        <form method="post" name="mainform" id="mainform">
            <div class="personal_data_password">

                <p align="center">
                    <?if($sns_data == null){?>
                    <button type="button" class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 연동하기</button>
                    <button type="button" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 연동하기</button></p>
                <?}else{
                    if(strpos($sns_data,'N') !== false){?>
                        <button type="button" class="btn_sns naver" >네이버ID 연동중</button>
                    <?}else{?>
                        <button type="button" class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 연동하기</button>
                    <?}?>
                    <?if(strpos($sns_data,'K') !== false){?>
                        <button type="button" class="btn_sns kakao">카카오ID 연동중</button>
                    <?}else{?>
                        <button type="button" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 연동하기</button>
                    <?}?>
                <?}?>
                </p>

            </div>
        </form>
    </div>
</div>
</div>
</div>

<div id="search_address"></div>

<script>
    //===============================================================
    // 카카오 변경
    //===============================================================
    function loginWithKakao(){
        if(confirm('연동하시겠습니까?')) {
            var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
            window.open("https://"+SSL_val+"/member/kakao_login","login-kakao","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
        }

        return false;
    }
    //===============================================================
    // 네이버 변경
    //===============================================================
    function loginWithNaver(){
        if(confirm('연동하시겠습니까?')) {
            var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
            window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
        }

        return false;
    }

</script>