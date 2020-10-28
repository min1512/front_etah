<link rel="stylesheet" href="/assets/css/login.css">
			<?if($member['type'] == 'id'){?>
			<div class="contents login_search">
				<h2 class="page_title page_title__search">아이디 찾기</h2>

				<div class="login_box">
					<p class="search_finish_text"><span class="bold">아이디 찾기 완료되었습니다.</span>아이디 찾기 결과 고객님의 아이디 정보는 아래와 같습니다.</p>

					<p class="search_finish_id">아이디 <strong class="bold"><?=$member['hid_id']?></strong> 입니다.<br />(<?=substr($member['reg_dt'],0,10)?> 가입)</p>

					<ul class="btn_list btn_list_search">
						<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:location.href='/member/login';">로그인</button></li>
						<li><button type="button" class="btn_negative btn_negative__min" onClick="javaScript:location.href='/member/password_search';">비밀번호 찾기</button></li>
					</ul>
				</div>
			</div>
			<?}else{?>
			<div class="contents login_search">
				<h2 class="page_title page_title__search">비밀번호 찾기</h2>

				<div class="login_box">
					<p class="search_finish_pw"><strong class="bold"><?=$member['email']?></strong>으로 임시 비밀번호를 발송하였습니다.</p>
					<p class="search_finish_pw_small">임시 비밀번호로 로그인 후 마이페이지에서 비밀번호를 변경하여주시기 바랍니다.</p>

					<ul class="btn_list btn_list_search">
						<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:location.href='/member/login';">로그인</button></li>
					</ul>
				</div>
			</div>
			<?}?>