<form id="updFile" name="updFile" method="post" enctype="multipart/form-data">

    <div class="score_box">
        <input type="hidden" id="goods_code"		name="goods_code"		value="<?=$goods_code?>">	<!--상품코드-->
        <input type="hidden" id="pre_page_C"		name="pre_page_C"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
        <input type="hidden" id="limit_num_C"		name="limit_num_C"		value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
        <input type="hidden" id="total_cnt_C"		name="total_cnt_C"		value="<?=$total_cnt?>">	<!--전체 문의글 갯수-->
        <input type="hidden" id="totla_page_C"		name="total_page_C"		value="<?=$total_page?>">	<!--전체 페이지 수-->
        <input type="hidden" id="next_C"			name="next_C"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->

        <?
        $i = 0;
        $total_grade		= 0;	//전체 평점
        $tot_grade_val01	= 0;	//품질 평점 합산
        $tot_grade_val02	= 0;	//배송 평점 합산
        $tot_grade_val03	= 0;	//가격 평점 합산
        $tot_grade_val04	= 0;	//디자인 평점 합산
        $total_goods_grade	= 0;	//품질+배송+가격+디자인 평점 합산
        $grade_val01		= 0;	//품질 평점
        $grade_val02		= 0;	//배송 평점
        $grade_val03		= 0;	//가격 평점
        $grade_val04		= 0;	//디자인 평점

        foreach($total_comment_val as $row){
            $grade_val01 += $row['GRADE_VAL01'];
            $grade_val02 += $row['GRADE_VAL02'];
            $grade_val03 += $row['GRADE_VAL03'];
            $grade_val04 += $row['GRADE_VAL04'];
            $total_goods_grade += $row['TOTAL_GRADE_VAL'];
            $i++;
        }
        @$tot_grade_val01 = $grade_val01/$i*20;
        @$tot_grade_val02 = $grade_val02/$i*20;
        @$tot_grade_val03 = $grade_val03/$i*20;
        @$tot_grade_val04 = $grade_val04/$i*20;
        @$total_grade = $total_goods_grade/(5*$i)*100;
        ?>

        <?if($template_gb=='B'){ //공방상품평?>
            <div class="score_all">
                <span class="title">만족도</span>
                <span class="star_grade star_grade__big"><span class="score" style="width:<?=$total_grade?>%;"></span></span>
                <span class="score">
                    <strong>
                        <?
                        if($total_grade>0 && $total_grade<=20) {
                            echo "불만족";
                        } else if($total_grade>20 && $total_grade<=40) {
                            echo "미흡";
                        } else if($total_grade>40 && $total_grade<=60) {
                            echo "보통";
                        } else if($total_grade>60 && $total_grade<=80) {
                            echo "만족";
                        } else if($total_grade>80 && $total_grade<=100) {
                            echo "아주만족";
                        }
                        ?>
                    </strong>
                </span>
            </div>
        <?} else {  //일반상품평?>
            <div class="score_all">
                <span class="title">전체평점</span>
                <span class="star_grade star_grade__big"><span class="score" style="width:<?=$total_grade?>%;"></span></span>
                <span class="score"><strong><?=ceil($total_grade)?></strong>/100</span>
            </div>
            <ul class="score_list">
                <li class="score_item">
                    <span class="title">품질</span>
                    <span class="star_grade"><span class="score" style="width:<?=$tot_grade_val01?>%;"></span></span>
                </li>
                <li class="score_item">
                    <span class="title">배송</span>
                    <span class="star_grade"><span class="score" style="width:<?=$tot_grade_val02?>%;"></span></span>
                </li>
                <li class="score_item">
                    <span class="title">가격</span>
                    <span class="star_grade"><span class="score" style="width:<?=$tot_grade_val03?>%;"></span></span>
                </li>
                <li class="score_item">
                    <span class="title">디자인</span>
                    <span class="star_grade"><span class="score" style="width:<?=$tot_grade_val04?>%;"></span></span>
                </li>
            </ul>
        <?}?>
    </div>

    <div class="board_list board_list_comment">
        <table class="board_list_table">
            <caption>상품평 리스트</caption>
            <colgroup>
                <col style="width:66px;" />
                <col style="width:107px;" />
                <col style="width:93px;" />
                <col />
                <col style="width:72px;" />
                <col style="width:129px;" />
            </colgroup>
            <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">평점</th>
                <th scope="col" colspan="2">상품평</th>
                <th scope="col">작성자</th>
                <th scope="col">작성일</th>
            </tr>
            </thead>
            <tbody id="comment_body">
            <? $i = $total_cnt;
            if($i != 0){
                foreach($goods_comment as $row){	?>
                    <tr id="open_comment<?=$i?>" class="">
                        <!-- 코멘트 열리면 클래스 active 추가 -->
                        <td><?=$i?></td>
                        <td>
                            <span class="star_grade"><span class="score" style="width:<?=$row['TOTAL_GRADE_VAL']*20?>%;"></span></span>
                        </td>
                        <td class="image">
                            <!--<? if($row['FILE_PATH']){?><a href="javascript:showImgWin('<?=$row['FILE_PATH']?>');"><img src="<?=$row['FILE_PATH']?>" alt="" width="60" height="60"/></a><? }?>-->
                        </td>
                        <td class="comment">
                            <div class="goods_detail__string">
                                <p class="name"><?=$row['GOODS_OPTION_NM']?></p>
                                <!--                                <p class="description">Flat Table 400 - black</p>-->
                            </div>
                            <div>
                                <?if(count($row['FILE_PATH']) != 0){
                                    foreach($row['FILE_PATH'] as $file){?>
                                        <?
                                        $exif = @exif_read_data($file['FILE_PATH']); //2019-12-02 이미지 회전되어 나오는 문제
                                        $degree = 0;
                                        if(!empty($exif['Orientation'])) {
                                            switch($exif['Orientation']) {
                                                case 8:  $degree = -90;   break;
                                                case 3:  $degree = 180;   break;
                                                case 6:  $degree = 90;    break;
                                                default: $degree = 0;    break;
                                            }
                                        }

                                        ?>
                                        <a href="javascript:showImgWin('<?=$file['FILE_PATH']?>', '<?=$degree?>');"><img src="<?=$file['FILE_PATH']?>" alt="" width="60" height="60" style="transform: rotate(<?=$degree?>deg);"/></a>
                                        <?
                                    }
                                }?>
                            </div>
                            <p class="goods_comment">
                                <?=nl2br(iconv_substr((str_replace("<br />","\n",$row['CONTENTS'])),0,300,"utf-8"))?>
                                <?if(iconv_strlen((str_replace("<br />","\n",$row['CONTENTS'])), "utf-8")>300){?>
                                    <span style="display: none;" id="hidContents<?=$i?>"><?=nl2br(iconv_substr((str_replace("<br />","\n",$row['CONTENTS'])),300))?></span>
                                <?}?>
                            </p>
                            <?if(iconv_strlen((str_replace("<br />","\n",$row['CONTENTS'])), "utf-8")>300){?>
                                <ul class="btn_list btn_list__reply position_right">
                                    <li><button type="button" class="btn_white btn_white__small" type="button" class="btn_white btn_white__small" onclick="javascript:folding_contents('M', <?=$i?>)" id="fold_btn<?=$i?>">더보기</button></li>
                                </ul>
                            <?}?>
                            <?if(!empty($row['CUST_NO']) && ($row['CUST_NO'] == $this->session->userdata('EMS_U_NO_'))){?>
                                <ul class="btn_list btn_list__reply position_right">
                                    <li><button type="button" class="btn_white btn_white__small" onClick="javascript:modify_comment_layer(<?=$row['CUST_GOODS_COMMENT']?>);">수정</button></li>
                                    <li><button type="button" class="btn_white btn_white__small" onClick="javascript:delete_comment(<?=$row['CUST_GOODS_COMMENT']?>);">삭제</button></li>
                                </ul>
                            <?}?>
                        </td>
                        <td><?=substr($row['CUST_ID'],0,3)."****"?></td>
                        <td><?=substr($row['CUST_GOODS_COMMENT_REG_DT'],0,10)?></td>
                    </tr>
                    <? $i--;
                }
            } else {	?>
                <tr>
                    <td colspan="6">등록 된 상품평이 없습니다.</td>
                </tr>
            <? }?>
            </tbody>
        </table>
    </div>
    <div class="position_area">
        <div id="comment_pagination_position">
            <? if(0 < $total_cnt){	?>
                <div class="page" id="comment_pagination">
                    <ul class="page_list">
                        <? $total_page = ceil($total_cnt/$limit_num);
                        if(1 <= $total_page){	?>
                            <li class="page_item active"><a href="javascript:jsPaging_Comment(1);">1</a></li>
                        <? }
                        if(2 <= $total_page){	?>
                            <li class="page_item"><a href="javascript:jsPaging_Comment(2);">2</a></li>
                        <? }
                        if(3 <= $total_page){	?>
                            <li class="page_item"><a href="javascript:jsPaging_Comment(3);">3</a></li>
                        <? }
                        if(4 <= $total_page){	?>
                            <li class="page_item"><a href="javascript:jsPaging_Comment(4);">4</a></li>
                        <? }
                        if(5 <= $total_page){	?>
                            <li class="page_item"><a href="javascript:jsPaging_Comment(5);">5</a></li>
                        <? }?>
                    </ul>
                    <? if($total_page != 1 && $total_page > 5){	?>
                        <a href="javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging(6);" class="page_next">
                            Next<span class="spr-common spr_arrow_right"></span>
                        </a>
                    <? }?>
                </div>
            <? }?>
        </div>
        <!--	<a href="javascript:jsWrite_Comment();" class="btn_write position_right" --><?// if($this->session->userdata('EMS_U_ID_')){?><!-- data-ui="toggle-btn" data-target="#prd_comment_layer"--><?//}?><!--상품평쓰기</a>-->
        <span onclick="jsWrite_Comment();" class="btn_write position_right" <? if($this->session->userdata('EMS_U_ID_')){?> data-ui="toggle-btn" data-target="#prd_comment_layer"<?}?> style="cursor:pointer;">상품평쓰기</span>
    </div>

    <div class="prd_inquiry_layer" id="prd_comment_layer">
        <h3 class="prd_inquiry_layer_title">상품평 쓰기</h3>
        <dl class="prd_inquiry_layer_line">
            <dt class="title"><label for="prdComment0101">만족도</label></dt>
            <dd class="data">
                <?if($template_gb=='B'){ //공방상품평?>
                    <div class="select_wrap" style="width:688px;">
                        <select id="prdComment0505" name="grade_val05">
                            <option value="">만족도</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>
                <?} else {  //일반상품평?>
                    <div class="select_wrap" style="width:166px;">
                        <select id="prdComment0101" name="grade_val01" style="width:166px;">
                            <option value="">품질</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>

                        </select>
                    </div>
                    <div class="select_wrap" style="width:166px;">
                        <label for="prdComment0102">배송만족도 선택</label>
                        <select id="prdComment0102" name="grade_val02" style="width:166px;">
                            <option value="">배송</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>
                    <div class="select_wrap" style="width:166px;">
                        <label for="prdComment0103">가격만족도 선택</label>
                        <select id="prdComment0103" name="grade_val03" style="width:166px;">
                            <option value="">가격</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>
                    <div class="select_wrap" style="width:166px;">
                        <label for="prdComment0104">디자인만족도 선택</label>
                        <select id="prdComment0104" name="grade_val04" style="width:166px;">
                            <option value="">디자인</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>
                <?}?>
            </dd>
        </dl>
        <dl class="prd_inquiry_layer_line">
            <dt class="title"><label for="prdComment0201">상품평</label></dt>
            <dd class="data">
			<textarea class="input_text" id="comment_contents" name="comment_contents" style="width: 688px;" placeholder=" * 20자 이상 구매평을 남겨주셔야 등록이 가능합니다.
 * 텍스트 구매평 1000점 마일리지 / 사진 추가시 2000점 마일리지
 * 후기하고 관련 된 상품의 사진 아니면 마일리지 추후 차감 될수 있습니다.
 * 구매평 적립 제외 : 실 결제금액이 5000원 미만인경우 상품평 작성에 대한 마일리지 적립이 제외됩니다.
 * 동일상품에 대한 구매평 적립혜택은 1회로 제한 되며 적립후 30일 경과시 구매평 적립혜택을 다시 받을수 있습니다. "></textarea>
            </dd>
        </dl>
        <div class="prd_inquiry_layer_line" id="tblFileUpload">
            <dl class="prd_inquiry_layer_line" name="row[]">
                <dt class="title"><label for="file_url_0">이미지</label></dt>
                <dd class="data">
                    <input type="text" id="file_url_0" name="file_url[]" placeholder="jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다." class="input_text" style="width: 565px;" readonly>
                    <a href="javaScript:jsDel(0);" class="spr-mypage spr-btn_delete" title="이미지삭제"></a>
                    <label for="fileUpload_0" class="btn_white btn_search">찾아보기</label>
                    <input type="file" id="fileUpload_0" name="fileUpload[]" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this, 0);">
                    <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/display/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                </dd>
            </dl>
        </div>
        <ul class="btn_list">
            <li><button type="button" class="btn_positive btn_positive__min" onClick="javascript:jsComment();">등록하기</button></li>
            <li><button type="button" class="btn_negative btn_negative__min" data-ui="toggle-btn" onClick="javascript:$('#prd_comment_layer').hide();">취소</button></li>
        </ul>
    </div>
</form>

<div id="modify_comment"></div> <!--상품평 수정하기 레이어-->

<script type="text/javascript">
    <? if(isset($_GET['gb'])){	?>
    setTimeout(function(){
        jsWrite_Comment();
    }, 500);
    <? }?>
    //=========================================
    // 이미지 보여주기
    //=========================================
    function showImgWin(img1, degree)
    {
        var x,y,w,h,loadingMsg;
        w=300;h=100;
        x=Math.floor( (screen.availWidth-(w+12))/2 );y=Math.floor( (screen.availHeight-(h+30))/2 );
        loadingMsg="<table width=100% height=100%><tr><td valign=center align=center><font size='2' color='#ff6600' face='termanal'>NOW LOADING...</font></td></tr></table>";
        with( window.open("","",'height='+h+',width='+w+',top='+y+',left='+x+',scrollbars=yes,resizable=yes') ) {
            document.write(
                "<body topmargin=0 rightmargin=0 bottommargin=0 leftmargin=0>",
                loadingMsg,
                "<img src=\""+img1+"\" width=500 height=500 style=\"transform:rotate("+degree+"deg)\" hspace=0 vspace=0 border=0 onmousedown=\"window.close();\" onload=\"document.title=this.src;document.body.removeChild(document.body.children[0]);window.resizeTo(500,500);window.moveTo(Math.floor( (screen.availWidth-(this.width+12))/2),Math.floor( (screen.availHeight-(this.height+30))/2 ));\"><br>",
                "</body>");
            focus();
        }
    }

    //===============================================================
    // 상품평쓰기 버튼을 누를 시, 로그인 상태 체크
    //===============================================================
    function jsWrite_Comment(){
        var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){
            setTimeout(function(){
                if(confirm("로그인 후 상품평 쓰기가 가능합니다. \n로그인하시겠습니까?")){
                    location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                }
            },100);
        }
    }

    //===============================================================
    // 파일경로 보여주기
    //===============================================================
    function viewFileUrl(input, idx){
        if($("#fileUpload_"+idx).val()){	//파일 확장자 확인
            if(!imgChk($("#fileUpload_"+idx).val())){
                alert("jpg, gif, png 파일만 업로드 가능합니다.");

                //파일 초기화
                $("#fileUpload_"+idx).replaceWith($("#fileUpload_"+idx).clone(true));
                $("#fileUpload_"+idx).val('');
                $("#file_url_"+idx).val('');
                return false;
            }
        }

        if(input.files[0].size > 1024*5000){	//파일 사이즈 확인
            alert("파일의 최대 용량을 초과하였습니다. \n파일은 5MB(5120KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

            //파일 초기화
            $("#fileUpload_"+idx).replaceWith($("#fileUpload_"+idx).clone(true));
            $("#fileUpload_"+idx).val('');
            $("#fileUpload_"+idx).val('');
            return false;
        }
        else {
            $("#file_url_"+idx).val($("#fileUpload_"+idx).val());
        }
    }

    //===============================================================
    // 지우기
    //===============================================================
    function jsDel(idx){
        $("#fileUpload_"+idx).replaceWith($("#fileUpload_"+idx).clone(true));
        $("#fileUpload_"+idx).val('');

        $("#file_url_"+idx).val('');
    }

    //===============================================================
    // 추가이미지
    //===============================================================
    function jsAdd(){
        var index = document.getElementsByName("row[]").length;

        if(index == 5 ) {
            alert("이미지는 최대 5개까지 업로드 가능합니다.");
            return false;
        }

        $("#tblFileUpload").append(
            "<dl class=\"prd_inquiry_layer_line\" name=\"row[]\">" +
            "<dt class=\"title\"><label for=\"file_url_"+index+"\">이미지</label></dt>" +
            "<dd class=\"data\">" +
            "<input type=\"text\" id=\"file_url_"+index+"\" name=\"file_url[]\" placeholder=\"jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.\" class=\"input_text\" style=\"width: 565px;\" readonly> " +
            "<a href=\"javaScript:jsDel("+index+");\" class=\"spr-mypage spr-btn_delete\" title=\"이미지삭제\"></a> " +
            "<label for=\"fileUpload_"+index+"\" class=\"btn_white btn_search\">찾아보기</label> " +
            "<input type=\"file\" id=\"fileUpload_"+index+"\" name=\"fileUpload[]\" class=\"file_upload_hidden\" onChange=\"javaScript:viewFileUrl(this, "+index+");\"> " +
            "<button class=\"file_puls_btn\" onclick=\"return false;\"><img src=\"/assets/images/display/btn_plus.png\" alt=\"\" onclick=\"javaScript:jsAdd();\"></button> " +
            "</dd>" +
            "</dl>"
        )

    }

    //===============================================================
    // 확장자 체크 함수 생성
    //===============================================================
    function imgChk(str){
        var pattern = new RegExp(/\.(gif|jpg|jpeg|png)$/i);

        if(!pattern.test(str)) {
            return false;
        } else {
            return true;
        }
    }

    //===============================================================
    // 페이징
    //===============================================================
    function jsPaging_Comment(page){
        var goods_code  = $("input[name=goods_code]").val();		//상품코드
        var pre_page	= $("input[name=pre_page_C]").val();		//이전페이지
        var total_cnt	= $("input[name=total_cnt_C]").val();		//전체 갯수
        var limit_num	= $("input[name=limit_num_C]").val();		//한 페이지당 보여줄 갯수
        var idx			= total_cnt - limit_num * (page - 1);		//순번 역순
        var next		= $('input[name=next_C]').val();			//다음페이지를 만들지 말지 비교를 위한 변수

        $.ajax({
            type: 'POST',
            url: '/goods/comment_paging',
            dataType: 'json',
            data: {goods_code : goods_code, page : page, limit : limit_num},
            error: function(res) {
                alert('Database Error');
                alert(res.responseText);
            },
            success: function(res) {
                if(res.status == 'ok'){
                    var comment = res.comment;
                    var comment_temp = "";

                    for(var i=0; i<comment.length; i++){
                        var total_grade = "";
                        total_grade = comment[i]['TOTAL_GRADE_VAL'];


                        comment_temp += "<tr id=\"open_comment"+idx+"\" class=\"\">" +
                            "<td>"+idx+"</td>" +
                            "<td><span class=\"star_grade\"><span class=\"score\" style=\"width:"+total_grade*20+"%;\"></span></span></td><td class=\"image\">";

//                        if(comment[i]['FILE_PATH']) {
//                            comment_temp += "<a href=\"javascript:showImgWin('"+comment[i]['FILE_PATH']+"');\"><img src=\""+comment[i]['FILE_PATH']+"\" alt=\"\" width=\"60\" height=\"60\"/></a>";
//                        }

                        comment_temp += "</td>" +
                            "<td class=\"comment\">" +
                            "<div class=\"goods_detail__string\"><p class=\"name\">"+comment[i]['GOODS_OPTION_NM']+"</p></div>" +
                            "<div>";

                        if(comment[i]['FILE_PATH'].length != 0){
                            for(var a=0;a<comment[i]['FILE_PATH'].length;a++){
                                comment_temp += "<a href=\"javascript:showImgWin('"+comment[i]['FILE_PATH'][a]['FILE_PATH']+"');\"><img src=\""+comment[i]['FILE_PATH'][a]['FILE_PATH']+"\" alt=\"\" width=\"60\" height=\"60\"/></a>";
                            }
                        }

                        comment_temp += "</div>" +
                            "<p class=\"goods_comment\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(0,300).replace(/(\n|\r\n)/g, '<br>');

                        if(comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').length > 300){
                            comment_temp += "<span style=\"display: none;\" id=\"hidContents"+idx+"\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(300).replace(/(\n|\r\n)/g, '<br>')+"</span>";
                        }

                        comment_temp += "</p>";

                        if(comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').length > 300){
                            comment_temp += "<ul class=\"btn_list btn_list__reply position_right\">" +
                                "<li><button type=\"button\" class=\"btn_white btn_white__small\" type=\"button\" class=\"btn_white btn_white__small\" onclick=\"javascript:folding_contents('M', "+idx+")\" id=\"fold_btn"+idx+"\">더보기</button></li>" +
                                "</ul>";
                        }


                        if( (comment[i]['CUST_NO'] != null) && (comment[i]['CUST_NO'] == '<?=$this->session->userdata('EMS_U_NO_')?>') ){
                            comment_temp += "<ul class=\"btn_list btn_list__reply position_right\">" +
                                "<li><button type=\"button\" class=\"btn_white btn_white__small\" onClick=\"javascript:modify_comment_layer("+comment[i]['CUST_GOODS_COMMENT']+");\">수정</button></li>" +
                                "<li><button type=\"button\" class=\"btn_white btn_white__small\" onClick=\"javascript:delete_comment("+comment[i]['CUST_GOODS_COMMENT']+");\">삭제</button></li>" +
                                "</ul>";
                        }

                        comment_temp += "</td>" +
                            "<td>"+comment[i]['CUST_ID']+"</td>" +
                            "<td>"+comment[i]['CUST_GOODS_COMMENT_REG_DT']+"</td>" +
                            "</tr>";

                        idx--;
                    }


                    var strHtmlPag = makePaginationHtml_Comment(page, next, limit_num);
                    $("#comment_pagination").remove();
                    $("#comment_pagination_position").append(strHtmlPag);

                    var page_c = page % 5;
                    if(page_c == 0){	//클래스 입힐 페이지의 위치를 알아내기 위해
                        page_c = 5;
                    }

                    $("#comment_body").html(comment_temp);
                    $("div#comment_pagination li.page_item:nth-child("+pre_page+")").removeClass('active');		//이전페이지 클래스 삭제
                    $("div#comment_pagination li.page_item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
                    $("input[name=pre_page_C]").val(page);		//페이지 이동 전의 페이지 저장


                }
                else alert(res.message);
            }
        })
    }

    /****************************/
    /* 페이징 HTML 만들기 함수  */
    /****************************/
    function makePaginationHtml_Comment(currPage, nextPage, limitNum){
        var strHtmlPag	= "";
        var totalPage	= $("input[name=total_page_C]").val();
        var next = "";	//다음페이지를 만들지 말지 비교를 위한 변수

        strHtmlPag+="<div class=\"page\" id=\"comment_pagination\">";
        if(nextPage != 0){
            strHtmlPag+="<a href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())-1); jsPaging_Comment("+parseInt(5*nextPage)+");\" class=\"page_prev\"> <span class=\"spr-common spr_arrow_left\"></span>Pre</a>";
        }
        strHtmlPag+="<ul class=\"page_list\">";

        if(parseInt(5*nextPage+1) <= totalPage){
            strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+1)+");\">"+parseInt(5*nextPage+1)+"</a></li>";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+2) <= totalPage){
            strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+2)+");\">"+parseInt(5*nextPage+2)+"</a></li>";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+3) <= totalPage){
            strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+3)+");\">"+parseInt(5*nextPage+3)+"</a></li>";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+4) <= totalPage){
            strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+4)+");\">"+parseInt(5*nextPage+4)+"</a></li>";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+5) <= totalPage){
            strHtmlPag+="<li class=\"page_item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+5)+");\">"+parseInt(5*nextPage+5)+"</a></li>";
        } else {
            next = 'N';
        }

        strHtmlPag+="</ul>";

        if(currPage != totalPage && totalPage > 5 && next != 'N'){
            strHtmlPag+="<a href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())+1); jsPaging_Comment("+parseInt(5*nextPage+6)+");\" class=\"page_next\">Next<span class=\"spr-common spr_arrow_right\"></span></a>";
            strHtmlPag+="</div>";
        }

        return strHtmlPag;
    }

</script>

<script>
    //=====================================
    // 상품평 내용 더보기/접기
    //=====================================
    function folding_contents(gb, idx) {

        if(gb == 'M') {
            $("#hidContents"+idx).css("display", "inline");  //내용보이기
            $("#fold_btn"+idx).removeAttr("onclick");
            $("#fold_btn"+idx).attr("onclick", "javaScript:folding_contents('F',"+idx+")");

            $("#fold_btn"+idx).text($("#fold_btn"+idx).text() == '더보기' ? "접기" : "더보기");
        }

        if(gb == 'F') {
            $("#hidContents"+idx).css("display", "none");  //내용보이기
            $("#fold_btn"+idx).removeAttr("onclick");
            $("#fold_btn"+idx).attr("onclick", "javaScript:folding_contents('M',"+idx+")");
            $("#fold_btn"+idx).text($("#fold_btn"+idx).text() == '더보기' ? "접기" : "더보기");
        }

    }

    //=====================================
    // 상품평 수정 레이어
    //=====================================
    function modify_comment_layer(comment_no) {
        $.ajax({
            type: 'GET',
            url: '/mywiz/update_goods_comment',
            async: false,
            dataType: 'json',
            data: { comment_no : comment_no },
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    $("#modify_comment").html(res.modify_comment);
                    $('#layer_comment_modify').show();
                }
                else alert(res.message);
            }
        })
    }

    //=====================================
    // 상품평 삭제하기
    //=====================================
    function delete_comment(comment_cd){
        setTimeout(function(){
            if(confirm("상품평을 삭제하시겠습니까?")){
                $.ajax({
                    type: 'POST',
                    url: '/mywiz/delete_goods_comment',
                    dataType: 'json',
                    data: {  comment_cd:comment_cd},
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            alert("삭제되었습니다.");
                            location.reload();
                        }
                        else alert(res.message);
                    }
                });
            }
        },100);
    }
</script>