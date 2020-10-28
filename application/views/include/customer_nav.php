
<link rel="stylesheet" href="/assets/css/mypage.css?ver=1.0">

<div class="contents mypage">
    <h2 class="page_title page_title__kor">고객센터</h2>
    <?if($type != "REG_QNA"){?>
        <div class="inquiry_search_box">
            <label for="formInquirySearch">자주 찾는 질문검색</label>
            <input type=" text" id="formInquirySearch" placeholder="검색어를 입력해 주세요." class="input_text" style="width: 436px;" name="faq_keyword" onKeyPress="javascript:if(event.keyCode == 13){ faqSearch(); return false;}" value="<?=$keyword?>">
            <button type="button" class="btn_black btn_search" onClick="javaScript:faqSearch();">검색</button>
            <!--<ul class="keyword_list">
                <li class="keyword_item"><a href="#">배송</a></li>
                <li class="keyword_item"><a href="#">환불</a></li>
                <li class="keyword_item"><a href="#">쿠폰</a></li>
                <li class="keyword_item"><a href="#">주문확인</a></li>
                <li class="keyword_item"><a href="#">교환</a></li>
            </ul>-->
        </div>
    <?}?>
    <div class="mypage_wrap">
        <div class="mypage_lnb_wrap">
            <ul class="mypage_lnb">
                <li class="mypage_lnb_item">
                    <a href="/customer/faq"><strong class="mypage_lnb_title">자주 찾는 질문</strong></a>
                    <ul class="mypage_lnb_menu">
                        <li class="mypage_lnb_menu_item <?=$type == 'GOODS' ? "active" : ""?>"><a href="/customer/faq/GOODS">상품<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <!-- 활성화시 클래스 active 추가 -->
                        <li class="mypage_lnb_menu_item <?=$type == 'ORDER__SHIPPING' ? "active" : ""?>"><a href="/customer/faq/ORDER__SHIPPING">주문&#47;배송<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'CANCEL__RETURN__CHANGE' ? "active" : ""?>"><a href="/customer/faq/CANCEL__RETURN__CHANGE">취소&#47;반품<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'PAY' ? "active" : ""?>"><a href="/customer/faq/PAY"><!--환불&#47;입금내역-->결제<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'MILEAGE' ? "active" : ""?>"><a href="/customer/faq/MILEAGE">마일리지<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'COUPON' ? "active" : ""?>"><a href="/customer/faq/COUPON">쿠폰<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'MEMBER' ? "active" : ""?>"><a href="/customer/faq/MEMBER">회원&#47;정보관리<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'EVENT' ? "active" : ""?>"><a href="/customer/faq/EVENT">이벤트<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <li class="mypage_lnb_menu_item <?=$type == 'ETC' ? "active" : ""?>"><a href="/customer/faq/ETC">기타<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                    </ul>
                </li>
                <li class="mypage_lnb_item">
                    <strong class="mypage_lnb_title">1:1 문의</strong>
                    <ul class="mypage_lnb_menu">
                        <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                            <li class="mypage_lnb_menu_item <?=$type == 'QNA' ? "active" : ""?>"><a href="/customer/register_qna">비회원 문의하기<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <?}else{?>
                            <li class="mypage_lnb_menu_item <?=$type == 'QNA' ? "active" : ""?>"><a href="/customer/register_qna">문의하기<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                        <?}?>
                        <li class="mypage_lnb_menu_item <?=$type == 'QNA_LIST' ? "active" : ""?>"><a href="/customer/qna_list_all">묻고 답하기<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                    </ul>
                </li>
                <li class="mypage_lnb_item">
                    <a href="/customer/notice"><strong class="mypage_lnb_title">공지사항</strong></a>
                </li>
            </ul>
            <dl class="cs_use_info">
                <dt class="title">고객센터 이용안내</dt>
                <dd class="num">1522-5572</dd>
                <dd class="time">월~금 10:00~17:30</dd>
                <dd class="time">(점심시간: 12:00~13:00)</dd>
                <dd class="holiday">주말&#47;공휴일 휴무</dd>
            </dl>
        </div>

        <script type="text/javaScript">

            //====================================
            // 날짜선택
            //====================================
            function jsSetDate(idx, date){
                for(var i=0; i<4; i++){
                    if(idx == i){
                        document.getElementById("btn"+i).className = "date_option_button_item active";
                        document.getElementById("date_from").value = date;
                    }else{
                        document.getElementById("btn"+i).className = "date_option_button_item";
                    }
                    document.getElementById("date_type").value = idx;
                }
            }

            //====================================
            // 검색
            //====================================
            function faqSearch(){
                var page = 1;
                var keyword = $("input[name=faq_keyword]").val();
//				var type = "<?=$type?>";

                var param = "";
                param += "page="			+ page;
                param += "&type="			+ "";
                param += "&keyword="		+ keyword;
                document.location.href = "/customer/faq_page/"+page+"?"+param;
            }
        </script>


