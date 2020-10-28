<form name="updCommentForm" id="updCommentForm" method="post" enctype="multipart/form-data">
    <!-- 상품평 수정하기 레이어 // -->
    <div class="layer layer__view layer_comment_modify" id="layer_comment_modify">
        <div class="layer_inner">
            <h1 class="layer_title layer_title__line">댓글 수정하기</h1>
            <div class="layer_cont">
                <input type="hidden" name="gubun" id="gubun" value="B">
                <input type="hidden" name="comment_no" id="comment_no" value="<?=$comment['COMMENT_NO']?>">
                <dl class="prd_inquiry_layer_line">
                    <dt class="title"><label for="comment_txt">댓글</label></dt>
                    <dd class="data">
                        <textarea class="input_text" id="comment_txt" name="comment_txt" style="width: 688px;"><?=$comment['CONTENTS']?></textarea>
                    </dd>
                </dl>
                <dl class="prd_inquiry_layer_line">
                    <dt class="title"><label for="file_url">이미지</label></dt>
                    <dd class="data">
                        <input type="text" id="file_url" name="file_url" placeholder="jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다." class="input_text" style="width: 605px;" readonly  value="<?=$comment['FILE_PATH']?>">
                        <a href="javaScript:jsDel();" class="spr-mypage spr-btn_delete" title="이미지삭제"></a>
                        <label for="fileUpload" class="btn_white btn_search">찾아보기</label>
                        <input type="file" id="fileUpload" name="fileUpload" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this);">
                    </dd>
                </dl>
            </div>
            <ul class="btn_list">
                <li><button type="button" class="btn_positive" onclick="javaScript:comment_layer_update()">수정하기</button></li>
                <li><button type="button" class="btn_negative" onclick="$(this).parents('.layer').hide(); return false;">수정취소</button></li>
            </ul>
            <a href="#layer_comment_modify" class="spr-common layer_close" title="레이어 닫기" onclick="$(this).parents('.layer').hide(); return false;"></a>
        </div>
        <div class="dimd"></div>
    </div>
    <!-- // 상품평 수정하기 레이어 -->
</form>

<script>
    //===============================================================
    // 파일경로 보여주기
    //===============================================================
    function viewFileUrl(input){
        if($("input[name=fileUpload]").val()){	//파일 확장자 확인
            if(!imgChk($("input[name=fileUpload]").val())){
                alert("jpg, gif 파일만 업로드 가능합니다.");

                //파일 초기화
                $("#fileUpload").replaceWith($("#fileUpload").clone(true));
                $("#fileUpload").val('');
                $("input[name=file_url]").val('');
                return false;
            }
        }

        if(input.files[0].size > 1024*2000){	//파일 사이즈 확인
            alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

            //파일 초기화
            $("#fileUpload").replaceWith($("#fileUpload").clone(true));
            $("#fileUpload").val('');
            $("input[name=file_url]").val('');
            return false;
        }
        else {
            $("input[name=file_url]").val($("input[name=fileUpload]").val());
        }
    }

    //===============================================================
    // 지우기
    //===============================================================
    function jsDel(){
        $("#fileUpload").replaceWith($("#fileUpload").clone(true));
        $("#fileUpload").val('');
        $("input[name=file_url]").val('');
    }

    //===============================================================
    // 확장자 체크 함수 생성
    //===============================================================
    function imgChk(str){
        var pattern = new RegExp(/\.(gif|jpg|jpeg)$/i);

        if(!pattern.test(str)) {
            return false;
        } else {
            return true;
        }
    }

    //===============================================================
    // 매거진 댓글 수정
    //===============================================================
    //매거진 이벤트 상세페이지 댓글 수정
    function comment_layer_update(){
        var data = new FormData($('#updCommentForm')[0]);

        $.ajax({
            type: 'POST',
            url: '/magazine/comment_update',
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
                    alert('수정되었습니다.');
                    location.reload();
                }
                else console.log(res.message);
            }
        })
    }
</script>