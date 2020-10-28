<form id="updFileEdit" name="updFileEdit" method="post"  enctype="multipart/form-data">
    <!-- 상품평 수정하기 레이어 // -->
    <div class="layer layer__view layer_comment_modify" id="layer_comment_modify" style="display: none;">
        <div class="layer_inner">
            <h1 class="layer_title layer_title__line">상품평 수정하기</h1>
            <div class="layer_cont">
                <dl class="prd_inquiry_layer_line">
                    <dt class="title"><label for="prdComment0101">만족도</label></dt>
                    <dd class="data">
                        <?if(strlen($comment['GRADE_VAL']) == 1){?>
                            <div class="select_wrap" style="width:688px;">
                                <select id="prdComment0105" style="width:688px;" name="grade5">
                                    <option value="">만족도</option>
                                    <option value=1 <?=$comment['GRADE_VAL1'] == 1 ? "selected" : ""?>>★☆☆☆☆</option>
                                    <option value=2 <?=$comment['GRADE_VAL1'] == 2 ? "selected" : ""?>>★★☆☆☆</option>
                                    <option value=3 <?=$comment['GRADE_VAL1'] == 3 ? "selected" : ""?>>★★★☆☆</option>
                                    <option value=4 <?=$comment['GRADE_VAL1'] == 4 ? "selected" : ""?>>★★★★☆</option>
                                    <option value=5 <?=$comment['GRADE_VAL1'] == 5 ? "selected" : ""?>>★★★★★</option>
                                </select>
                            </div>

                            <input type="hidden" name="hid_grade5"	value="<?=$comment['GRADE_VAL1']?>">
                        <?}else{?>
                            <div class="select_wrap" style="width:166px;">
                                <select id="prdComment0101" style="width:166px;" name="grade1">
                                    <option value="">품질</option>
                                    <option value=1 <?=$comment['GRADE_VAL1'] == 1 ? "selected" : ""?>>★☆☆☆☆</option>
                                    <option value=2 <?=$comment['GRADE_VAL1'] == 2 ? "selected" : ""?>>★★☆☆☆</option>
                                    <option value=3 <?=$comment['GRADE_VAL1'] == 3 ? "selected" : ""?>>★★★☆☆</option>
                                    <option value=4 <?=$comment['GRADE_VAL1'] == 4 ? "selected" : ""?>>★★★★☆</option>
                                    <option value=5 <?=$comment['GRADE_VAL1'] == 5 ? "selected" : ""?>>★★★★★</option>
                                </select>
                            </div>
                            <div class="select_wrap" style="width:166px;">
                                <label for="prdComment0102">배송만족도 선택</label>
                                <select id="prdComment0102" style="width:166px;" name="grade2">
                                    <option value="">배송</option>
                                    <option value=1 <?=$comment['GRADE_VAL2'] == 1 ? "selected" : ""?>>★☆☆☆☆</option>
                                    <option value=2 <?=$comment['GRADE_VAL2'] == 2 ? "selected" : ""?>>★★☆☆☆</option>
                                    <option value=3 <?=$comment['GRADE_VAL2'] == 3 ? "selected" : ""?>>★★★☆☆</option>
                                    <option value=4 <?=$comment['GRADE_VAL2'] == 4 ? "selected" : ""?>>★★★★☆</option>
                                    <option value=5 <?=$comment['GRADE_VAL2'] == 5 ? "selected" : ""?>>★★★★★</option>
                                </select>
                            </div>
                            <div class="select_wrap" style="width:166px;">
                                <label for="prdComment0103">가격만족도 선택</label>
                                <select id="prdComment0103" style="width:166px;" name="grade3">
                                    <option value="">가격</option>
                                    <option value=1 <?=$comment['GRADE_VAL3'] == 1 ? "selected" : ""?>>★☆☆☆☆</option>
                                    <option value=2 <?=$comment['GRADE_VAL3'] == 2 ? "selected" : ""?>>★★☆☆☆</option>
                                    <option value=3 <?=$comment['GRADE_VAL3'] == 3 ? "selected" : ""?>>★★★☆☆</option>
                                    <option value=4 <?=$comment['GRADE_VAL3'] == 4 ? "selected" : ""?>>★★★★☆</option>
                                    <option value=5 <?=$comment['GRADE_VAL3'] == 5 ? "selected" : ""?>>★★★★★</option>
                                </select>
                            </div>
                            <div class="select_wrap" style="width:166px;">
                                <label for="prdComment0104">디자인만족도 선택</label>
                                <select id="prdComment0104" style="width:166px;" name="grade4">
                                    <option value="">디자인</option>
                                    <option value=1 <?=$comment['GRADE_VAL4'] == 1 ? "selected" : ""?>>★☆☆☆☆</option>
                                    <option value=2 <?=$comment['GRADE_VAL4'] == 2 ? "selected" : ""?>>★★☆☆☆</option>
                                    <option value=3 <?=$comment['GRADE_VAL4'] == 3 ? "selected" : ""?>>★★★☆☆</option>
                                    <option value=4 <?=$comment['GRADE_VAL4'] == 4 ? "selected" : ""?>>★★★★☆</option>
                                    <option value=5 <?=$comment['GRADE_VAL4'] == 5 ? "selected" : ""?>>★★★★★</option>
                                </select>
                            </div>

                            <input type="hidden" name="hid_grade1"	value="<?=$comment['GRADE_VAL1']?>">
                            <input type="hidden" name="hid_grade2"	value="<?=$comment['GRADE_VAL2']?>">
                            <input type="hidden" name="hid_grade3"	value="<?=$comment['GRADE_VAL3']?>">
                            <input type="hidden" name="hid_grade4"	value="<?=$comment['GRADE_VAL4']?>">
                        <?}?>
                    </dd>
                </dl>
                <dl class="prd_inquiry_layer_line">
                    <dt class="title"><label for="prdComment0201">상품평</label></dt>
                    <dd class="data">
                        <textarea class="input_text" id="prdComment0201" style="width: 688px;" name="comment"><?=str_replace("<br />","\n",$comment['CONTENTS'])?></textarea>
                    </dd>
                </dl>

                <div class="prd_inquiry_layer_line" id="tblFileUpload2">
                    <input type="hidden" name="comment_cd"  value="<?=$comment['CUST_GOODS_COMMENT']?>"> <!-- 상품평 코드 -->
                    <input type="hidden" name="fileGb"      value="<?=(!empty($comment['FILE_PATH']))?"isEx":""?>"> <!-- 기존파일 유무 -->

                    <?
                    if(!empty($comment['FILE_PATH'])) {
                        $idx = 0;
                        foreach ($comment['FILE_PATH'] as $file) {
                            ?>
                            <dl class="prd_inquiry_layer_line" name="row2[]">
                                <dt class="title"><label for="file_url2_<?=$idx?>">이미지</label></dt>
                                <dd class="data">
                                    <input type="hidden" name="file_no2[]" value="<?=$file['CUST_GOODS_COMMENT_FILE_PATH_NO']?>"> <!-- 첨부파일 번호 -->
                                    <input type="text" id="file_url2_<?=$idx?>" name="file_url2[]" readonly class="input_text" style="width: 565px;" value="<?=$file['FILE_PATH']?>" placeholder="jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.">
                                    <a href="javaScript:jsDel(<?=$idx?>)" class="spr-mypage spr-btn_delete" title="이미지삭제"></a>
                                    <label for="fileUpload2_<?=$idx?>" class="btn_white btn_search">찾아보기</label>
                                    <input type="file" id="fileUpload2_<?=$idx?>" name="fileUpload2[]" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this, <?=$idx?>);">
                                    <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/display/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                                </dd>
                            </dl>
                            <?
                            $idx++;
                        }
                    } else{?>
                        <dl class="prd_inquiry_layer_line" name="row2[]">
                            <dt class="title"><label for="file_url2_0">이미지</label></dt>
                            <dd class="data">
                                <input type="hidden" name="file_no2[]" value=""> <!-- 첨부파일 번호 -->
                                <input type="text" id="file_url2_0" name="file_url2[]" readonly class="input_text" style="width: 565px;" value="" placeholder="jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.">
                                <a href="javaScript:jsDel(0)" class="spr-mypage spr-btn_delete" title="이미지삭제"></a>
                                <label for="fileUpload2_0" class="btn_white btn_search">찾아보기</label>
                                <input type="file" id="fileUpload2_0" name="fileUpload2[]" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this, 0);">
                                <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/display/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                            </dd>
                        </dl>
                    <?}?>
                </div>

            </div>
            <ul class="btn_list">
                <li><button type="button" class="btn_positive" onClick="javaScript:modify_comment(<?=$comment['CUST_GOODS_COMMENT']?>);">수정하기</button></li>
                <li><button type="button" class="btn_negative" onclick="$(this).parents('.layer').hide(); return false;">수정취소</button></li>
            </ul>
            <a href="#layer_comment_modify" class="spr-common layer_close" title="레이어 닫기" onclick="$(this).parents('.layer').hide(); return false;"></a>
        </div>
        <input type="hidden" name="comment_cd">
        <div class="dimd"></div>
    </div>
    <!-- // 상품평 수정하기 레이어 -->
</form>



<script>
    //=====================================
    // trim 함수 생성
    //=====================================
    function trim(s){
        s = s.replace(/^\s*/,'').replace(/\s*$/,'');
        return s;
    }

    //=====================================
    // 지우기
    //=====================================
    function jsDel(idx){
        $("#file_url2_"+idx).val('');
        $("#fileUpload2_"+idx).replaceWith($("#fileUpload2_"+idx).clone(true));
        $("#fileUpload2_"+idx).val('');
    }

    //===============================================================
    // 추가이미지
    //===============================================================
    function jsAdd(){
        var index2 = document.getElementsByName("row2[]").length;

        if(index2 == 5 ) {
            alert("이미지는 최대 5개까지 업로드 가능합니다.");
            return false;
        }

        $("#tblFileUpload2").append(
            "<dl class=\"prd_inquiry_layer_line\" name=\"row2[]\">" +
            "<dt class=\"title\"><label for=\"file_url2_"+index2+"\">이미지</label></dt>" +
            "<dd class=\"data\">" +
            "<input type=\"hidden\" name=\"file_no2[]\" value=\"\"> " +
            "<input type=\"text\" id=\"file_url2_"+index2+"\" name=\"file_url2[]\" readonly class=\"input_text\" style=\"width: 565px;\" value=\"\" placeholder=\"jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.\"> " +
            "<a href=\"javaScript:jsDel("+index2+")\" class=\"spr-mypage spr-btn_delete\" title=\"이미지삭제\"></a> " +
            "<label for=\"fileUpload2_"+index2+"\" class=\"btn_white btn_search\">찾아보기</label> " +
            "<input type=\"file\" id=\"fileUpload2_"+index2+"\" name=\"fileUpload2[]\" class=\"file_upload_hidden\" onChange=\"javaScript:viewFileUrl(this, "+index2+");\"> " +
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

    //=====================================
    // 파일경로 보여주기
    //=====================================
    function viewFileUrl(input, idx){
        if($("#fileUpload2_"+idx).val()){	//파일 확장자 확인
            if(!imgChk($("#fileUpload2_"+idx).val())){
                alert("jpg, gif 파일만 업로드 가능합니다.");

                //파일 초기화
                $("#fileUpload2_"+idx).replaceWith($("#fileUpload2_"+idx).clone(true));
                $("#fileUpload2_"+idx).val('');
                $("#file_url2_"+idx).val('');
                return false;
            }
        }

        if(input.files[0].size > 1024*5000){	//파일 사이즈 확인
            alert("파일의 최대 용량을 초과하였습니다. \n파일은 5MB(5120KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

            //파일 초기화
            $("#fileUpload2_"+idx).replaceWith($("#fileUpload2_"+idx).clone(true));
            $("#fileUpload2_"+idx).val('');
            $("#fileUpload2_"+idx).val('');
            return false;
        }
        else {
            $("#file_url2_"+idx).val($("#fileUpload2_"+idx).val());
        }

    }

    //=====================================
    // 상품평 수정하기
    //=====================================
    function modify_comment(comment_cd){
        var grade1  = $("select[name=grade1]").val()
            , grade2 = $("select[name=grade2]").val()
            , grade3 = $("select[name=grade3]").val()
            , grade4 = $("select[name=grade4]").val()
            , grade5 = $("select[name=grade5]").val()
            , comment = $("textarea[name=comment]").val()

        $('input[name=comment_cd]').val(comment_cd);

        <?if(strlen($comment['GRADE_VAL']) == 1){?>
        if(grade5 == ""){
            alertDelay("만족도 점수를 선택해주세요.");
            $("select[name=grade5]").focus();
            return false;
        }
        <?} else{?>
        if(grade1 == ""){
            alertDelay("품질 만족도 점수를 선택해주세요.");
            $("select[name=grade1]").focus();
            return false;
        }
        if(grade2 == ""){
            alertDelay("배송 만족도 점수를 선택해주세요.");
            $("select[name=grade2]").focus();
            return false;
        }
        if(grade3 == ""){
            alertDelay("가격 만족도 점수를 선택해주세요.");
            $("select[name=grade3]").focus();
            return false;
        }
        if(grade4 == ""){
            alertDelay("디자인 만족도 점수를 선택해주세요.");
            $("select[name=grade4]").focus();
            return false;
        }
        <?}?>

        if(trim(comment) == ""){
            alertDelay("상품평을 입력해주세요.");
            $("textarea[name=comment]").focus();
            return false;
        }

        var data = new FormData($('#updFileEdit')[0]);

        setTimeout(function(){
            if(confirm("상품평을 수정하시겠습니까?")){
                $.ajax({
                    type: 'POST',
                    url: '/mywiz/update_goods_comment',
                    dataType: 'json',
                    data: data,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            alert("수정되었습니다.");
                            location.reload();
                        }
                        else alert(res.message);
                    }
                });
            }
        },100);

    }

    //=====================================
    // 상품평 이미지 변경
    //=====================================
    function update_image(comment_cd){

        var data = new FormData($('#updFileEdit')[0]);

        $.ajax({
            type: 'POST',
            url: '/mywiz/update_image',
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert("수정되었습니다.");
                    location.reload();
                }
                else alert(res.message);
            },
            error: function(res) {
                alert(res);
                alert(res.responseText);
                return false;
            }
        });
    }

</script>