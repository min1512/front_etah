			<link rel="stylesheet" href="/assets/css/member.css">

			<div class="contents member">
				<div class="member_join_finish" style="height:100%;">
				<?php if($this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
					<h2 class="page_title page_title__small">1:1 문의가 정상적으로 등록되었습니다.</h2>
					<p class="page_text">문의내역은 마이페이지 > 1:1 문의에서 확인하실 수 있습니다.</p>
					<ul class="btn_list">
						<li><button type="button" class="btn_positive btn_positive__min" onClick="javascript:location.href = '/mywiz/p_qna'">1:1문의내역</button></li>
						<li><button type="button" class="btn_negative btn_negative__min" onClick="javascript:location.href = '/'">홈으로</button></li>
					</ul>
					<div>
						<!--<img src="/assets/images/data/bnr_1000x340.jpg" alt="배너이미지" />-->
					</div>
				<?}else{?>
					<h2 class="page_title page_title__small">비회원 문의가 정상적으로 등록되었습니다.</h2>
					<p class="page_text">문의내역은 기입하신 이메일에서 확인하실 수 있습니다.</p>
					<ul class="btn_list">
						<!--<li><button type="button" class="btn_positive btn_positive__min" onClick="javascript:location.href = '/member/login'">로그인하기</button></li>-->
						<li><button type="button" class="btn_negative btn_negative__min" onClick="javascript:location.href = '/'">홈으로</button></li>
					</ul>
					<div>
						<!--<img src="/assets/images/data/bnr_1000x340.jpg" alt="배너이미지" />-->
					</div>
				<?}?>
				</div>
			</div>