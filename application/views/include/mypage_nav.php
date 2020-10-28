		<link rel="stylesheet" href="/assets/css/mypage.css?ver=1.0">

		<script type="text/javaScript">

		function jsSetDate(idx, date, date_to){
			for(var i=0; i<4; i++){
				if(idx == i){
					document.getElementById("btn"+i).className = "date_option_button_item active";
					document.getElementById("date_to").value = date_to;
					document.getElementById("date_from").value = date;
				}else{
					document.getElementById("btn"+i).className = "date_option_button_item";
				}
				document.getElementById("date_type").value = idx;
			}
		}

		//=====================================
		// 상품평 쓰기로 이동하기
		//=====================================
		function jsGoodsComment(goods_code){
//			location.href = '/goods/detail/'+goods_code+"?gb=comment";
            location.href = '/goods/detail/'+goods_code+"#prdComment";
		}

		//=====================================
		// 배송조회
		//=====================================
		function deliveryCheck(invoice_no, deli_com){
			switch(deli_com){

                // 굿스플로어 조회
                case '2'  : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/kdexp/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//경동
                case '23' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/korex/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//CJGLS
                case '40' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/korex/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//CJ GLS(HTH통합)
                case '38' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/korex/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//HTH(EDI)
                case '10' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/epost/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//우체국
                case '15' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/chunil/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//천일
                case '19' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/hanjin/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//한진
                case '20' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/lotte/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//롯데
                case '91' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/ems/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                 ); break;	//EMS
                case '96' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/aciexpress/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"          ); break;	//ACI
                case '39' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/ilyang/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//일양
                case '27' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/logen/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//로젠
                case '70' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/usps/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                ); break;	//미국우정청(USPS)
                case '44' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/hanjin/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//네덱스(에스지엔지-한진물류대행)
//                case '24' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/kgbps/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//KGB
                case '45' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/daesin/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//대신
                case '48' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/hdexp/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//합동
                case '14' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/kunyoung/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"            ); break;	//건영

                // 드림택배 조회  --> 2018.08.21부로 부도 KGB로 조회가능.
                case '8'  : window.open(" http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes" ); break;	//드림(옐로우캡)
                case '35' : window.open(" http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes" ); break;	//드림(동부)
                case '47' : window.open(" http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes" ); break;	//드림(KG로지스)

                //KGB택배
                case '24' : window.open(" https://www.kgbps.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"      ); break;  //KGB

                // 별도조회
                case '37' : window.open(" http://innogis-d.com/invoice.asp?invoice="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                        ); break;	//이노지스

                // ETC
				case 'GLOBAL' : window.open(" http://www.tntnhan.com/delivery/trackingSch/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                 ); break;

				// 기타 직배송
				default : alert("배송추적이 불가능한 직배송 상품입니다."); break;
			}
		}
		</script>
			<?if($this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
			<div class="contents mypage">
				<h2 class="page_title">MY PAGE</h2>
				<div class="myinfo">
					<div class="myinfo_greet">
						<span class="spr-mypage spr-profile"></span><em class="bold"><?=$this->session->userdata('EMS_U_NAME_');?></em>님 반갑습니다.
					</div>
					<ul class="myinfo_benefit_list">
					</ul>
				</div>
				<div class="mypage_wrap">
					<ul class="mypage_lnb">
						<li class="mypage_lnb_item">
							<strong class="mypage_lnb_title">나의 쇼핑내역</strong>
							<ul class="mypage_lnb_menu">
								<li class="mypage_lnb_menu_item<?=$nav == 'OD' ? " active" : ""?>"><a href="/mywiz/order">주문&#47;배송조회<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                                <?if(!isset($external)){?>
								<li class="mypage_lnb_menu_item<?=$nav == 'OP' ? " active" : ""?>"><a href="/mywiz/print_order">증빙서류발급<span class="spr-mypage spr-lnb_arrow"></span></a></li>
                                <?}?>
							</ul>
						</li>
					</ul>
				<?}else{?>
				<div class="contents mypage">
				<h2 class="page_title">MY PAGE</h2>
				<div class="myinfo">
					<div class="myinfo_greet">
						<span class="spr-mypage spr-profile"></span><em class="bold"><?=$this->session->userdata('EMS_U_NAME_');?></em>님 반갑습니다.
					</div>
					<ul class="myinfo_benefit_list">
						<li class="myinfo_benefit_item"><span class="spr-mypage spr-mileage"></span>마일리지 : <span class="bold"><a href="/mywiz/mileage"><?=number_format($mileage)?></a>마일</span></li>
						<li class="myinfo_benefit_item"><span class="spr-mypage spr-coupon"></span>쿠폰 : <span class="bold"><a href="/mywiz/coupon/"><?=$coupon?></a>장</span></li>
					</ul>
				</div>
				<div class="mypage_wrap">
					<ul class="mypage_lnb">
						<li class="mypage_lnb_item">
							<strong class="mypage_lnb_title">나의 쇼핑내역</strong>
							<ul class="mypage_lnb_menu">
								<li class="mypage_lnb_menu_item<?=$nav == 'OD' ? " active" : ""?>"><a href="/mywiz/order">주문&#47;배송조회<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<!--<li class="mypage_lnb_menu_item<?=$nav == 'OA' ? " active" : ""?>"><a href="/mywiz/apply_order">취소&#47;반품&#47;교환신청<span class="spr-mypage spr-lnb_arrow"></span></a></li>-->
								<li class="mypage_lnb_menu_item<?=$nav == 'OC' ? " active" : ""?>"><a href="/mywiz/current_order">취소&#47;반품<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<li class="mypage_lnb_menu_item<?=$nav == 'OR' ? " active" : ""?>"><a href="/mywiz/deposit_order">환불&#47;입금내역<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<li class="mypage_lnb_menu_item<?=$nav == 'OP' ? " active" : ""?>"><a href="/mywiz/print_order">증빙서류발급<span class="spr-mypage spr-lnb_arrow"></span></a></li>
							</ul>
						</li>
						<li class="mypage_lnb_item">
							<strong class="mypage_lnb_title">나의 관심목록</strong>
							<ul class="mypage_lnb_menu">
								<li class="mypage_lnb_menu_item<?=$nav == 'I' ? " active" : ""?>"><a href="/mywiz/interest">관심상품<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<!-- 활성화시 클래스 active 추가 -->
								<li class="mypage_lnb_menu_item"><a href="/cart">장바구니<span class="spr-mypage spr-lnb_arrow"></span></a></li>
							</ul>
						</li>
						<li class="mypage_lnb_item">
							<strong class="mypage_lnb_title">나의 혜택관리</strong>
							<ul class="mypage_lnb_menu">
								<li class="mypage_lnb_menu_item<?=$nav == 'M' ? " active" : ""?>"><a href="/mywiz/mileage">마일리지<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<li class="mypage_lnb_menu_item<?=$nav == 'C' ? " active" : ""?>"><a href="/mywiz/coupon">쿠폰현황<span class="spr-mypage spr-lnb_arrow"></span></a></li>
							</ul>
						</li>
						<li class="mypage_lnb_item">
							<strong class="mypage_lnb_title">활동 및 문의</strong>
							<ul class="mypage_lnb_menu">
								<li class="mypage_lnb_menu_item<?=$nav == 'PQ' ? " active" : ""?>"><a href="/mywiz/p_qna">1:1 문의<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<li class="mypage_lnb_menu_item<?=$nav == 'Q' ? " active" : ""?>"><a href="/mywiz/qna">나의 상품 Q&#38;A<span class="spr-mypage spr-lnb_arrow"></span></a></li>
								<li class="mypage_lnb_menu_item<?=$nav == 'GM' ? " active" : ""?>"><a href="/mywiz/goods_comment">상품평<span class="spr-mypage spr-lnb_arrow"></span></a></li>
							</ul>
						</li>
						<li class="mypage_lnb_item">
							<strong class="mypage_lnb_title">회원정보</strong>
							<ul class="mypage_lnb_menu">
                                <li class="mypage_lnb_menu_item<?=$nav == 'D' ? " active" : ""?>">
                                    <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                                        <a href="/mywiz/delivery">배송지관리<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}else{?>
                                        <a href="/mywiz/check_password/D">배송지관리<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}?>
                                </li>
                                <li class="mypage_lnb_menu_item<?=$nav == 'MI' ? " active" : ""?>">
                                    <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                                        <a href="/mywiz/myinfo">개인정보 수정<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}else{?>
                                        <a href="/mywiz/check_password/MI">개인정보 수정<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}?>
                                </li>
                                <li class="mypage_lnb_menu_item<?=$nav == 'ML' ? " active" : ""?>">
                                    <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                                        <a href="/member/leave">회원탈퇴<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}else{?>
                                        <a href="/mywiz/check_password/ML">회원탈퇴<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}?>
                                </li>
                                <li class="mypage_lnb_menu_item<?=$nav == 'MS' ? " active" : ""?>">
                                    <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                                        <a href="https://<?=$_SERVER['HTTP_HOST']?>/mywiz/sns">간편로그인 연동<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}else{?>
                                        <a href="https://<?=$_SERVER['HTTP_HOST']?>/mywiz/check_password/MS">간편로그인 연동<span class="spr-mypage spr-lnb_arrow"></span></a>
                                    <?}?>
                                </li>
							</ul>
						</li>
					</ul>
				<?}?>
