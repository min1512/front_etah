<div class="board_list">
	<input type="hidden" id="goods_code"	name="goods_code"	value="<?=$goods_code?>">	<!--상품코드-->
	<input type="hidden" id="pre_page"		name="pre_page"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
	<input type="hidden" id="limit_num"		name="limit_num"	value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
	<input type="hidden" id="total_cnt"		name="total_cnt"	value="<?=$total_cnt?>">	<!--전체 문의글 갯수-->
	<input type="hidden" id="totla_page"	name="total_page"	value="<?=$total_page?>">	<!--전체 페이지 수-->
	<input type="hidden" id="next"			name="next"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->
	<table class="board_list_table">
		<caption>상품평 리스트</caption>
		<colgroup>
			<col style="width:66px;" />
			<col style="width:108px;" />
		<!--	<col style="width:71px;" />	-->
			<col />
			<col style="width:72px;" />
			<col style="width:129px;" />
		</colgroup>
		<thead>
			<tr>
				<th scope="col">번호</th>
				<th scope="col">답변상태</th>
			<!--<th scope="col">문의유형</th>	-->
				<th scope="col">문의제목</th>
				<th scope="col">작성자</th>
				<th scope="col">작성일</th>
			</tr>
		</thead>
		<tbody id="qna_body">
	<?  $i = $total_cnt;
		if($i != 0){
			foreach($goods_qna as $row)	{	?>
			<tr id="open_qna<?=$i?>" class="">
				<!-- 코멘트 열리면 클래스 active 추가 -->
				<td><?=$i?></td>
				<td><?=$row['ANSWER_YN']?></td>
			<!--	<td><?=$row['CS_QUE_TYPE_CD']?></td>	-->
				<td class="comment">
					<?if($row['SECRET_YN'] == 'Y' && $row['REAL_ID'] != $this->session->userdata('EMS_U_ID_')){?><a href="javascript:alert('비밀글은 작성자만 조회할 수 있습니다.');" class="link"><?} else {?><a href="javascript:jsOpen(<?=$i?>);" class="link"><?} if($row['SECRET_YN'] == 'Y'){?> <span class="spr-common spr-ico-lock"></span><?}?><?=$row['Q_TITLE']?></a>
				</td>
				<td><?=substr($row['CUST_ID'],0,3)."****"?></td>
				<td><?=substr($row['REG_DT'],0,10)?></td>
			</tr>
			<tr class="reply">
				<td colspan="5"><?=$row['Q_CONTENTS']?><? if($row['A_CONTENTS']){?><br/><br/>[답변]<br/><?=$row['A_CONTENTS']?><?}?></td>
			</tr>
		<? $i--;
			}
		} else {	?>
			<tr>
				<td colspan="5">등록 된 상품 문의가 없습니다.</td>
			</tr>
		<? }?>
		</tbody>
	</table>
</div>
<div class="position_area" id="qna_pagination_position">
	<? if(0 < $total_cnt){	?>
	<div class="page" id="qna_pagination">
	<!--	<a href="#" class="page_prev">
			<span class="spr-common spr_arrow_left"></span>Pre
		</a>	-->
		<ul class="page_list">
		<? $total_page = ceil($total_cnt/$limit_num);
			if(1 <= $total_page){	?>
			<li class="page_item active"><a href="javascript:jsPaging(1);">1</a></li>
		<? }
			if(2 <= $total_page){	?>
			<li class="page_item"><a href="javascript:jsPaging(2);">2</a></li>
		<? }
			if(3 <= $total_page){	?>
			<li class="page_item"><a href="javascript:jsPaging(3);">3</a></li>
		<? }
			if(4 <= $total_page){	?>
			<li class="page_item"><a href="javascript:jsPaging(4);">4</a></li>
		<? }
			if(5 <= $total_page){	?>
			<li class="page_item"><a href="javascript:jsPaging(5);">5</a></li>
		<? }?>
		</ul>
		<? if($total_page != 1 && $total_page > 5){	?>
		<a href="javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging(6);" class="page_next">
			Next<span class="spr-common spr_arrow_right"></span>
		</a>
		<? }?>
	</div>
	<? }?>
	<a href="javascript:jsLogin();" class="btn_write position_right" <? if($this->session->userdata('EMS_U_ID_')){?> data-ui="toggle-btn" data-target="#prd_inquiry_layer" <?}?>>문의하기</a>
</div>
<div class="prd_inquiry_layer" id="prd_inquiry_layer">
	<h3 class="prd_inquiry_layer_title">상품 문의하기</h3>
	<dl class="prd_inquiry_layer_line">
		<dt class="title">문의제목</dt>
		<dd class="data"><input type="text" class="input_text" name="qna_title" style="width: 690px;" /></dd>
	</dl>
	<dl class="prd_inquiry_layer_line">
		<dt class="title">문의내용</dt>
		<dd class="data">
			<textarea class="input_text" id="qna_contents" style="width: 690px;"></textarea>
		</dd>
		<dd class="data checkbox_area"><input type="checkbox" class="checkbox" id="formSecretInquiry" name="qna_secret" value="N"> <label class="checkbox_label" for="formSecretInquiry">비밀글로 문의하기 <span class="tip">(판매자와 본인만 확인 가능합니다.)</span></label></dd>
	</dl>
	<ul class="btn_list">
		<li><button type="button" class="btn_positive btn_positive__min" onClick="javascript:jsQna();">문의하기</button></li>
		<li><button type="button" class="btn_negative btn_negative__min" data-ui="toggle-btn" data-target="#prd_inquiry_layer">취소</button></li>
	</ul>
</div>


<script type="text/javascript">
//===============================================================
// 상품 문의 클릭시 펼쳐보기
//===============================================================
function jsOpen(idx){
	if($("#open_qna"+idx).attr('class') == ""){		//접혀있는 경우
		$("#open_qna"+idx).addClass('active');
	} else {		//펼쳐있는 경우
		$("#open_qna"+idx).removeClass();
	}
}

//===============================================================
// 페이징
//===============================================================
function jsPaging(page){
	var goods_code  = $("input[name=goods_code]").val();		//상품코드
	var pre_page	= $("input[name=pre_page]").val();			//이전페이지
	var total_cnt	= $("input[name=total_cnt]").val();			//전체 갯수
	var limit_num	= $("input[name=limit_num]").val();			//한 페이지당 보여줄 갯수
	var idx			= total_cnt - limit_num * (page - 1);		//순번 역순
	var next		= $('input[name=next]').val();				//다음페이지를 만들지 말지 비교를 위한 변수
	var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

	$.ajax({
			type: 'POST',
			url: '/goods/qna_paging',
			dataType: 'json',
			data: {goods_code : goods_code, page : page, limit : limit_num},
			error: function(res) {
				alert('Database Error');
				alert(res.responseText);
			},
			success: function(res) {
				if(res.status == 'ok'){
					var qna = res.qna;
					var qna_temp = "";

					for(var i=0; i<qna.length; i++){
						qna_temp += "<tr id=\"open_qna"+idx+"\" class=\"\"><td>"+idx+"</td> <td>"+qna[i]['ANSWER_YN']+"</td><td class=\"comment\"> ";
						if(qna[i]['SECRET_YN'] == 'Y' && qna[i]['REAL_ID'] != session_id){
							qna_temp += "<a href=\"javascript:alert('비밀글은 작성자만 조회할 수 있습니다.');\" class=\"link\">";
						} else {
							qna_temp += "<a href=\"javascript:jsOpen("+idx+");\" class=\"link\">";
						}

						if(qna[i]['SECRET_YN'] == 'Y'){
							qna_temp += "<span class=\"spr-common spr-ico-lock\"></span>";
						}

						qna_temp += qna[i]['Q_TITLE']+"</a> </td> <td>"+qna[i]['CUST_ID']+"</td> <td>"+qna[i]['REG_DT']+"</td> </tr> <tr class=\"reply\"> <td colspan=\"5\">"+qna[i]['Q_CONTENTS'];

						if(qna[i]['A_CONTENTS']){
							qna_temp += "<br /><br />[답변]<br />";
							qna_temp += qna[i]['A_CONTENTS'];
						}
						qna_temp += "</td> </tr>";

						idx --;
					}

					var strHtmlPag = makePaginationHtml(page, next, limit_num);
					$("#qna_pagination").remove();
					$("#qna_pagination_position").append(strHtmlPag);

					var page_c = page % 5;
					if(page_c == 0){	//클래스 입힐 페이지의 위치를 알아내기 위해
						page_c = 5;
					}

					$("#qna_body").html(qna_temp);
					$("div#qna_pagination li.page_item:nth-child("+pre_page+")").removeClass('active');		//이전페이지 클래스 삭제
					$("div#qna_pagination li.page_item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
					$("input[name=pre_page]").val(page);		//페이지 이동 전의 페이지 저장


				}
				else alert(res.message);
			}
		})
}

/****************************/
/* 페이징 HTML 만들기 함수  */
/****************************/
function makePaginationHtml(currPage, nextPage, limitNum){
	var strHtmlPag	= "";
	var totalPage	= $("input[name=total_page]").val();
	var next = "";	//다음페이지를 만들지 말지 비교를 위한 변수

	strHtmlPag+="<div class=\"page\" id=\"qna_pagination\">";
	if(nextPage != 0){
		strHtmlPag+="<a href=\"javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())-1); jsPaging("+parseInt(5*nextPage)+");\" class=\"page_prev\"> <span class=\"spr-common spr_arrow_left\"></span>Pre</a>";
	}
		strHtmlPag+="<ul class=\"page_list\">";

	if(parseInt(5*nextPage+1) <= totalPage){
		strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging("+parseInt(5*nextPage+1)+");\">"+parseInt(5*nextPage+1)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+2) <= totalPage){
		strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging("+parseInt(5*nextPage+2)+");\">"+parseInt(5*nextPage+2)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+3) <= totalPage){
		strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging("+parseInt(5*nextPage+3)+");\">"+parseInt(5*nextPage+3)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+4) <= totalPage){
		strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging("+parseInt(5*nextPage+4)+");\">"+parseInt(5*nextPage+4)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+5) <= totalPage){
		strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging("+parseInt(5*nextPage+5)+");\">"+parseInt(5*nextPage+5)+"</a></li>";
	} else {
		next = 'N';
	}

		strHtmlPag+="</ul>";

	if(currPage != totalPage && totalPage > 5 && next != 'N'){
		strHtmlPag+="<a href=\"javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging("+parseInt(5*nextPage+6)+");\" class=\"page_next\">Next<span class=\"spr-common spr_arrow_right\"></span></a>";
		strHtmlPag+="</div>";
	}

	return strHtmlPag;
}

</script>