<link rel="stylesheet" href="/assets/css/login.css">

<div class="contents login">
    <h2 class="page_title">LOGIN</h2>
    <form method="post" name="mainform" id="mainform">
        <input type="hidden" id="login_gb" name="login_gb" value="">	<!-- 아이디로 로그인인지 이메일로 로그인인지 구분 -->
        <input type="hidden" id="tmp_no" name="tmp_no" value="<?=$tmp_no?>">		<!-- 비회원으로 로그인하고 장바구니를 사용하였을 경우 장바구니 정보를 업데이트 해주기 위해서 임시코드 -->
        <input type="hidden" id="sns_id" name="sns_id" value="">
        <input type="hidden" id="return_url" name="return_url" value="<?=$returnUrl?>">
        <div class="login_box">
            <div class="login_member">
                <h3 class="login_title">회원 로그인</h3>
                <dl class="login_form_line">
                    <dt class="login_form_title">
                        <label for="formInputId">아이디(또는 이메일)</label>
                    </dt>
                    <dd class="login_form_data">
                        <input type="text" id="formInputId" name="mem_id" class="input_text" placeholder="ID 또는 이메일" style="width: 317px;" onKeyPress="javascript:if(event.keyCode == 13){ javaScript:jsLogin(); return false;}"/>
                    </dd>
                </dl>
                <dl class="login_form_line">
                    <dt class="login_form_title">
                        <label for="formInputPw">비밀번호</label>
                    </dt>
                    <dd class="login_form_data">
                        <input type="password" id="formInputPw" name="mem_password" class="input_text" placeholder="비밀번호" style="width: 317px;" onKeyPress="javascript:if(event.keyCode == 13){ javaScript:jsLogin(); return false;}"/>
                    </dd>
                    <dd class="login_form_data">
                        <div class="checkbox_area">
                            <input type="checkbox" class="checkbox" id="formIdSave" name="id_save"/> <label class="checkbox_label" for="formIdSave">아이디 저장</label>
                        </div>
                        <p class="login_form_tip">(개인정보 보호를 위해 개인 PC에서만 이용해 주세요.)</p>
                    </dd>
                </dl>
                <button type="button" class="btn_positive btn_positive__login" onClick="javascript:jsLogin();">로그인</button><br>
                <p><button type="button" class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 로그인</button></p>
                <p><button type="button" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 로그인</button></p>

                <ul class="login_menu">
                    <li class="login_menu_item"><a href="/member/id_search">아이디 찾기</a></li>
                    <li class="login_menu_item"><a href="/member/password_search">비밀번호 찾기</a></li>
                    <li class="login_menu_item"><a href="/member/member_join1">회원가입</a></li>
                </ul>
            </div>


            <div class="login_nonmember">
                <h3 class="login_title">비회원 로그인</h3>
                <dl class="login_form_line">
                    <dt class="login_form_title">
                        <label for="formInputId02">구매자명</label>
                    </dt>
                    <dd class="login_form_data">
                        <input type="text" id="formInputId02" class="input_text" name="order_name" placeholder="주문하신 분 성함" style="width: 317px;" />
                    </dd>
                </dl>
                <dl class="login_form_line">
                    <dt class="login_form_title">
                        <label for="formInputId03">주문번호</label>
                    </dt>
                    <dd class="login_form_data">
                        <input type="text" id="formInputId03" class="input_text" name="order_no" placeholder="주문번호" style="width: 317px;" />
                    </dd>
                    <dd class="login_form_data">
                        <p class="login_form_tip">주문번호를 잊으신 경우, <br />에타 고객센터 1522-5572로 문의하여 주시기 바랍니다.</p>
                    </dd>
                </dl>
                <button type="button" class="btn_negative btn_negative__login" onClick="javascript:jsGuestLogin();">비회원 로그인</button>
                <? if($guest_gb == 'direct'){	?>
                    <div class="nonmember_order">
                        <p class="nonmember_order_text">비회원으로 주문하실 경우, 에타에서 제공되는 쿠폰 할인 및 마일리지 적립 등의 혜택은 받으실 수 없습니다.</p>
                        <a href="javascript:jsGuestOrder();" class="nonmember_order_btn">비회원 주문하기</a>
                    </div>
                <? }?>
            </div>
        </div>
    </form>
</div>

<!-- 상품정보 시작 (비회원 구매를 위해) -->
<form id="goods_form" name="goods_form" method="post">
    <? if($param){	?>
        <?
        //상품상세피이지 - 바로구매
        if(!isset($param['order_gb'])) {?>
            <input type="hidden"	name="cust_no"							value="<?=$param['cust_no']?>">
            <input type="hidden"	name="goods_code"						value="<?=$param['goods_code']?>">
            <input type="hidden"	name="goods_name"						value="<?=$param['goods_name']?>">
            <input type="hidden"	name="goods_img"						value="<?=$param['goods_img']?>">
            <input type="hidden"	name="goods_mileage_save_rate"			value="<?=$param['goods_mileage_save_rate']?>">
            <input type="hidden"	name="goods_price_code"					value="<?=$param['goods_price_code']?>">
            <input type="hidden"	name="goods_selling_price"				value="<?=$param['goods_selling_price']?>">
            <input type="hidden"	name="goods_street_price"				value="<?=$param['goods_street_price']?>">
            <input type="hidden"	name="goods_factory_price"				value="<?=$param['goods_factory_price']?>">
            <input type="hidden"	name="goods_state"						value="<?=$param['goods_state']?>">
            <input type="hidden"	name="brand_code"						value="<?=$param['brand_code']?>">
            <input type="hidden"	name="brand_name"						value="<?=$param['brand_name']?>">
            <input type="hidden"	name="goods_discount_price"				value="<?=$param['goods_discount_price']?>">
            <input type="hidden"	name="goods_coupon_code_s"				value="<?=$param['goods_coupon_code_s']?>">
            <input type="hidden"	name="goods_coupon_amt_s"				value="<?=$param['goods_coupon_amt_s']?>">
            <input type="hidden"	name="goods_coupon_code_i"				value="<?=$param['goods_coupon_code_i']?>">
            <input type="hidden"	name="goods_coupon_amt_i"				value="<?=$param['goods_coupon_amt_i']?>">
            <input type="hidden"	name="deli_policy_no"					value="<?=$param['deli_policy_no']?>">
            <input type="hidden"	name="deli_limit"						value="<?=$param['deli_limit']?>">
            <input type="hidden"	name="deli_cost"						value="<?=$param['deli_cost']?>">
            <input type="hidden"	name="deli_code"						value="<?=$param['deli_code']?>">
            <input type="hidden"	name="goods_delivery_price"				value="<?=$param['goods_delivery_price']?>">
            <input type="hidden"	name="goods_cate_code1"					value="<?=$param['goods_cate_code1']?>">
            <input type="hidden" 	name="goods_cate_code2"					value="<?=$param['goods_cate_code2']?>">
            <input type="hidden"	name="goods_cate_code3"					value="<?=$param['goods_cate_code3']?>">
            <input type="hidden"	name="goods_deliv_pattern_type"			value="<?=$param['goods_deliv_pattern_type']?>">
            <input type="hidden"	name="send_nation"						value="<?=$param['send_nation']?>">	<!--출고국가-->
            <? for($i=0; $i<count($param['goods_cnt']); $i++){	?>
                <input type="hidden"	name="goods_cnt[]"						value="<?=$param['goods_cnt'][$i]?>">
                <input type="hidden"	name="goods_option_code[]"				value="<?=$param['goods_option_code'][$i]?>">
                <input type="hidden"	name="goods_option_name[]"				value="<?=$param['goods_option_name'][$i]?>">
                <input type="hidden"	name="goods_option_add_price[]"			value="<?=$param['goods_option_add_price'][$i]?>">
                <input type="hidden"	name="goods_option_qty[]"				value="<?=$param['goods_option_qty'][$i]?>">
                <input type="hidden"	name="goods_item_coupon_code[]"			value="<?=$param['goods_item_coupon_code'][$i]?>">
                <input type="hidden"	name="goods_item_coupon_price[]"		value="<?=$param['goods_item_coupon_price'][$i]?>">
                <input type="hidden"	name="goods_add_coupon_code[]"			value="<?=$param['goods_add_coupon_code'][$i]?>">
                <input type="hidden"	name="goods_add_discount_price[]"		value="<?=$param['goods_add_discount_price'][$i]?>">
                <input type="hidden"	name="goods_add_coupon_type[]"			value="<?=$param['goods_add_coupon_type'][$i]?>">
                <input type="hidden"	name="goods_add_coupon_gubun[]"			value="<?=$param['goods_add_coupon_gubun'][$i]?>">
                <input type="hidden"	name="goods_coupon_amt[]"				value="<?=$param['goods_coupon_amt'][$i]?>">
                <input type="hidden"	name="goods_add_coupon_no[]"			value="<?=$param['goods_add_coupon_no'][$i]?>">
            <? }?>
        <?
        //장바구니 구매
        }else{?>
            <input type="hidden" name="order_gb"	id="order_gb"	 value="<?=$param['order_gb']?>">		                <!-- 전체주문/선택주문/바로주문 구분 -->
            <input type="hidden" name="direct_code" id="direct_code" value="<?=$param['direct_code']?>">		            <!-- 바로주문시 장바구니코드         -->
            <input type="hidden" name="direct_deli_price" id="direct_deli_price" value="<?=$param['direct_deli_price']?>">	<!-- 바로주문시 배송비               -->

            <? for($i=0;$i<count($param['cart_code']);$i++){?>
                <?if($param['chkGoods'][$i]){?><input type="hidden"     name="chkGoods[]"       value="<?=$param['chkGoods'][$i]?>"><?}?>   <!-- 선택상품주문시 -->
                <?if($param['cart_code'][$i]){?><input type="hidden"    name="cart_code[]"      value="<?=$param['cart_code'][$i]?>"><?}?>  <!-- 전체상품주문시 -->

                <input type="hidden"    name="group_code[]"                 value="<?=$param['group_code'][$i]?>">
                <input type="hidden"    name="goods_cnt[]"                  value="<?=$param['goods_cnt'][$i]?>">
                <input type="hidden"    name="limit_cnt[]"                  value="<?=$param['limit_cnt'][$i]?>">
                <input type="hidden"    name="group_text[]"                 value="<?=$param['group_text'][$i]?>">
                <input type="hidden"    name="group_delivery_price[]"       value="<?=$param['group_delivery_price'][$i]?>">
                <input type="hidden"    name="goods_delivery_price[]"       value="<?=$param['goods_delivery_price'][$i]?>">
                <input type="hidden"    name="deli_code[]"                  value="<?=$param['deli_code'][$i]?>">
                <input type="hidden"    name="chk_deli_code[]"              value="<?=$param['chk_deli_code'][$i]?>">
                <input type="hidden"    name="goods_code[]"                 value="<?=$param['goods_code'][$i]?>">
                <input type="hidden"    name="goods_name[]"                 value="<?=$param['goods_name'][$i]?>">
                <input type="hidden"    name="goods_state_code[]"           value="<?=$param['goods_state_code'][$i]?>">
                <input type="hidden"    name="goods_cate_code1[]"           value="<?=$param['goods_cate_code1'][$i]?>">
                <input type="hidden"    name="goods_cate_code2[]"           value="<?=$param['goods_cate_code2'][$i]?>">
                <input type="hidden"    name="goods_cate_code3[]"           value="<?=$param['goods_cate_code3'][$i]?>">
                <input type="hidden"    name="brand_code[]"                 value="<?=$param['brand_code'][$i]?>">
                <input type="hidden"    name="brand_name[]"                 value="<?=$param['brand_name'][$i]?>">
                <input type="hidden"    name="goods_option_code[]"          value="<?=$param['goods_option_code'][$i]?>">
                <input type="hidden"    name="goods_option_name[]"          value="<?=$param['goods_option_name'][$i]?>">
                <input type="hidden"    name="goods_option_add_price[]"     value="<?=$param['goods_option_add_price'][$i]?>">
                <input type="hidden"    name="goods_option_qty[]"           value="<?=$param['goods_option_qty'][$i]?>">
                <input type="hidden"    name="goods_img[]"                  value="<?=$param['goods_img'][$i]?>">
                <input type="hidden"    name="goods_price_code[]"           value="<?=$param['goods_price_code'][$i]?>">
                <input type="hidden"    name="goods_selling_price[]"        value="<?=$param['goods_selling_price'][$i]?>">
                <input type="hidden"    name="goods_street_price[]"         value="<?=$param['goods_street_price'][$i]?>">
                <input type="hidden"    name="goods_factory_price[]"        value="<?=$param['goods_factory_price'][$i]?>">
                <input type="hidden"    name="goods_discount_price[]"       value="<?=$param['goods_discount_price'][$i]?>">
                <input type="hidden"    name="goods_mileage_save_rate[]"    value="<?=$param['goods_mileage_save_rate'][$i]?>">
                <input type="hidden"    name="goods_coupon_code_s[]"        value="<?=$param['goods_coupon_code_s'][$i]?>">
                <input type="hidden"    name="goods_coupon_amt_s[]"         value="<?=$param['goods_coupon_amt_s'][$i]?>">
                <input type="hidden"    name="goods_coupon_code_i[]"        value="<?=$param['goods_coupon_code_i'][$i]?>">
                <input type="hidden"    name="goods_coupon_amt_i[]"         value="<?=$param['goods_coupon_amt_i'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_no[]"        value="<?=$param['goods_add_coupon_no'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_code[]"      value="<?=$param['goods_add_coupon_code'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_num[]"       value="<?=$param['goods_add_coupon_num'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_type[]"      value="<?=$param['goods_add_coupon_type'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_gubun[]"     value="<?=$param['goods_add_coupon_gubun'][$i]?>">
                <input type="hidden"    name="goods_add_discount_price[]"   value="<?=$param['goods_add_discount_price'][$i]?>">
                <input type="hidden"    name="deli_policy_no[]"             value="<?=$param['deli_policy_no'][$i]?>">
                <input type="hidden"    name="deli_cost[]"                  value="<?=$param['deli_cost'][$i]?>">
                <input type="hidden"    name="deli_limit[]"                 value="<?=$param['deli_limit'][$i]?>">
                <input type="hidden"    name="deli_pattern[]"               value="<?=$param['deli_pattern'][$i]?>">
                <input type="hidden"    name="send_nation[]"                value="<?=$param['send_nation'][$i]?>">
                <input type="hidden"    name="goods_buy_limit_qty[]"        value="<?=$param['goods_buy_limit_qty'][$i]?>">
                <input type="hidden"    name="goods_tax_gb_cd[]"            value="<?=$param['goods_tax_gb_cd'][$i]?>">
                <input type="hidden"    name="idx_price[]"                  value="<?=$param['idx_price'][$i]?>">
                <input type="hidden"    name="idxs_price[]"                 value="<?=$param['idxs_price'][$i]?>">
            <?}?>
        <?}?>
    <? }?>
</form>


<script type="text/javascript">

    //===============================================================
    // 회원로그인
    //===============================================================
    function jsLogin()
    {
        var mf		= document.mainform;

        if( ! $("input[name=mem_id]").val() ){
            alertDelay("아이디를 입력해 주십시오");
            mf.mem_id.focus();
            return false;
        }
        if( ! $("input[name=mem_password]").val() ){
            alertDelay("비밀번호를 입력해 주십시오");
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
            async: false,
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
                    console.log(res.message);
                }
            }
        })

        return true;
    }

    //===============================================================
    // 비회원 주문하기
    //===============================================================
    function jsGuestOrder()
    {
        var param		= $("#goods_form").serialize();
        var frm = document.getElementById("goods_form");
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

//		frm.action = "/cart/GuestOrder";
        frm.action = "https://"+SSL_val+"/cart/OrderInfo";		//주문결제페이지 동의약관이 나오도록 함 (2017-04-20)
        frm.submit();
    }

    //===============================================================
    // 비회원로그인
    //===============================================================
    function jsGuestLogin()
    {
        var mf		= document.mainform;

        if( ! $("input[name=order_name]").val() ){
            alertDelay("구매자 이름을 입력해 주십시오");
            mf.order_name.focus();
            return false;
        }
        if( ! $("input[name=order_no]").val() ){
            alertDelay("주문번호를 입력해 주십시오");
            mf.order_no.focus();
            return false;
        }

        var param = $("#mainform").serialize();
        $.ajax({
            type: 'POST',
            url: '/member/guest_login',
            dataType: 'json',
            data: param,
            error : function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    location.href = "/mywiz";
                }
                else{
                    alert(res.message);
                }
            }
        })

        return true;
    }

    //===============================================================
    // 카카오로그인
    //===============================================================
    function loginWithKakao(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/kakao_login","login-naver","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }
    //===============================================================
    // 네이버로그인
    //===============================================================
    function loginWithNaver(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }


    $(function(){
        if($.cookie('saveid')) $("input:checkbox[id='formIdSave']").attr("checked", true); $("input[name=mem_id]").val($.cookie('saveid'));
    })
</script>