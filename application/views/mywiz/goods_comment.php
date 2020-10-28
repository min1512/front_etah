<?
$date_today = date("Y-m-d", time());
$date_w1 = date("Y-m-d", strtotime("-1 week"));
$date_m1 = date("Y-m-d", strtotime("-1 month"));
$date_m2 = date("Y-m-d", strtotime("-3 month"));
$date_m3 = date("Y-m-d", strtotime("-6 month"));
?>

<div class="mypage_cont">
    <h3 class="title_page title_page__line title_page__mypage">상품평</h3>

    <div class="date_option">
        <input type="hidden" id="date_type" value="<?=$date_type?>">
        <ul class="date_option_button">
            <li class="date_option_button_item<?=$date_type == '0' ? ' active' : ''?>" id="btn0">
                <button type="button" class="btn_white" onClick="javaScipt:jsSetDate(0,'<?=$date_w1?>','<?=$date_today?>');">1주일</button>
            </li>
            <li class="date_option_button_item<?=$date_type == '1' ? ' active' : ''?>" id="btn1">
                <!-- 활성화시 클래스 active 추가 -->
                <button type="button" class="btn_white" onClick="javaScipt:jsSetDate(1,'<?=$date_m1?>','<?=$date_today?>');">1개월</button>
            </li>
            <li class="date_option_button_item<?=$date_type == '2' ? ' active' : ''?>" id="btn2">
                <button type="button" class="btn_white" onClick="javaScipt:jsSetDate(2,'<?=$date_m2?>','<?=$date_today?>');">3개월</button>
            </li>
            <li class="date_option_button_item<?=$date_type == '3' ? ' active' : ''?>" id="btn3">
                <button type="button" class="btn_white" onClick="javaScipt:jsSetDate(3,'<?=$date_m3?>','<?=$date_today?>');">6개월</button>
            </li>
        </ul>

        <div class="date_option_select">
            <div class="date_option_select_item">
                <input type="text" class="input_text datepicker" readonly id="date_from" value="<?=$date_from?>" />
                <button type="date" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
            </div>
            <span class="date_option_select_item">~</span>
            <div class="date_option_select_item">
                <input type="text" class="input_text datepicker" readonly id="date_to" value="<?=$date_to?>"/>
                <button type="date" class="btn_calendar" ><span class="spr-common spr-calendar"></span></button>
            </div>
            <button type="button" class="btn_black btn_black__small" onClick="javaScript:jsSearch();">조회</button>
        </div>
    </div>


    <div class="board_list board_list_comment">
        <table class="board_list_table">
            <caption>상품평 리스트</caption>
            <colgroup>
                <col style="width:150px;">
                <col style="width:150px;">
                <col style="width:80px;">
                <col>
                <col style="width:80px;">
                <col style="width:145px;">
            </colgroup>
            <thead>
            <tr>
                <th scope="col"><span class="hide_text">상품이미지</span></th>
                <th scope="col">상품정보</th>
                <th scope="col" colspan="2">리뷰내용</th>
                <th scope="col">평점</th>
                <th scope="col">작성일</th>
            </tr>
            </thead>
            <tbody>
            <?
            $idx=0;
            if($comment){
                foreach($comment as $row){?>
                    <tr class="" id="comment<?=$idx?>">
                        <!-- 클릭시 클래스 active 추가 -->
                        <td class="image">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" width="100" height="100" alt="상품 이미지"></a>
                        </td>
                        <td class="goods_detail__string">
                            <p class="name"><?=$row['GOODS_NM']?></p>
                            <p class="description"><?=$row['GOODS_OPTION_NM']?></p>
                        </td>
                        <td >

                        </td>
                        <td class="comment">
                            <div>
                                <?if(isset($row['FILE_PATH'])){
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
                                        <img src="<?=$file['FILE_PATH']?>" alt="" width="60" height="60" style="transform: rotate(<?=$degree?>deg);">
                                        <?
                                    }
                                }?>
                            </div>
                            <p class="goods_comment"><?=$row['CONTENTS']?></p>
                            <ul class="btn_list btn_list__reply position_right">
                                <li><button type="button" class="btn_white btn_white__small" onClick="javaScript:modify_comment_layer(<?=$row['CUST_GOODS_COMMENT']?>);">수정</button></li>
                                <li><button type="button" class="btn_white btn_white__small" onClick="javaScript:delete_comment(<?=$row['CUST_GOODS_COMMENT']?>);">삭제</button></li>
                            </ul>
                        </td>
                        <td>
                            <span class="star_grade"><span class="score" style="width:<?=$row['TOTAL_GRADE']*20?>%;"></span></span>
                        </td>
                        <td>
                            <?=substr($row['CUST_GOODS_COMMENT_REG_DT'],0,10)?>
                        </td>
                    </tr>
                    <?
                    $idx++;
                }
            }else{
                ?>
                <tr>
                    <td colspan="5">등록된 상품평이 없습니다.</td>
                </tr>
            <?}?>

            <!--<tr>
                <td class="image">
                    <img src="/assets/images/data/data_100x100_02.jpg" alt="상품 이미지">
                </td>
                <td class="goods_detail__string">
                    <p class="name">Jacksonchameleon</p>
                    <p class="description">Flat Table 400 - black</p>
                </td>
                <td class="review_content">
                    <a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
                </td>
                <td>
                    <span class="star_grade"><span class="score" style="width:80%;"></span></span>
                </td>
                <td>
                    2016-03-25
                </td>
            </tr>
            <tr>
                <td class="image">
                    <img src="/assets/images/data/data_100x100_03.jpg" alt="상품 이미지">
                </td>
                <td class="goods_detail__string">
                    <p class="name">Jacksonchameleon</p>
                    <p class="description">Flat Table 400 - black</p>
                </td>
                <td class="review_content">
                    <a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
                </td>
                <td>
                    <span class="star_grade"><span class="score" style="width:80%;"></span></span>
                </td>
                <td>
                    2016-03-25
                </td>
            </tr>
            <tr>
                <td class="image">
                    <img src="/assets/images/data/data_100x100_02.jpg" alt="상품 이미지">
                </td>
                <td class="goods_detail__string">
                    <p class="name">Jacksonchameleon</p>
                    <p class="description">Flat Table 400 - black</p>
                </td>
                <td class="review_content">
                    <a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
                </td>
                <td>
                    <span class="star_grade"><span class="score" style="width:80%;"></span></span>
                </td>
                <td>
                    2016-03-25
                </td>
            </tr>
            <tr>
                <td class="image">
                    <img src="/assets/images/data/data_100x100_02.jpg" alt="상품 이미지">
                </td>
                <td class="goods_detail__string">
                    <p class="name">Jacksonchameleon</p>
                    <p class="description">Flat Table 400 - black</p>
                </td>
                <td class="review_content">
                    <a href="#" class="link">제품 컬러가 사이트와 비교해서 실제로 보면 너무 조금<br />흐린 감이 있는데 정상인가요?</a>
                </td>
                <td>
                    <span class="star_grade"><span class="score" style="width:80%;"></span></span>
                </td>
                <td>
                    2016-03-25
                </td>
            </tr>-->
            </tbody>
        </table>
    </div>

    <!--<div class="page">
        <a href="#" class="page_prev">
            <span class="spr-common spr_arrow_left"></span>Pre
        </a>
        <ul class="page_list">
            <li class="page_item"><a href="#">1</a></li>
            <li class="page_item active"><a href="#">2</a></li>
            <li class="page_item"><a href="#">3</a></li>
            <li class="page_item"><a href="#">4</a></li>
            <li class="page_item"><a href="#">5</a></li>
        </ul>
        <a href="#" class="page_next">
            Next<span class="spr-common spr_arrow_right"></span>
        </a>
    </div>-->
    <?=$pagination?>
</div>
</div>
</div>

<div id="modify_comment"></div> <!--상품평 수정하기 레이어-->

<script type="text/javaScript">
    //====================================
    // 조회
    //====================================
    function jsSearch()
    {
        var date_from	= $('#date_from').val(),
            date_to		= $('#date_to').val(),
            date_type	= $('#date_type').val(),
            page		= 1;

        var param = "";
        param += "page="			+ page;
        param += "&date_from="		+ date_from;
        param += "&date_to="		+ date_to;
        param += "&date_type="		+ date_type;

        document.location.href = "/mywiz/comment_page/"+page+"?"+param;
    }

    //=====================================
    // 클릭시 펼쳐보기
    //=====================================
    function jsOpen(idx){
        if($("#comment"+idx).attr('class') == ""){		//접혀있는 경우
            $("#comment"+idx).addClass('active');
        } else {		//펼쳐있는 경우
            $("#comment"+idx).removeClass();
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
    }

    //=====================================
    // 지우기
    //=====================================
    function jsDelete(idx){
        $("input[name=file_url_"+idx+"]").val("");
        $("input[name=fileUpload_"+idx+"]").val("");
        $("input[name=fileUpload_"+idx+"]").replaceWith( $("input[name=fileUpload_"+idx+"]").clone(true) );

//				alert($("input[name=file_url_"+idx+"]").val());
    }

    //=====================================
    // datepicker
    //=====================================
    $(function()
    {
        $(".datepicker").datepicker(
            {
                showOn: "button",
                dateFormat: 'yy-mm-dd',
                //numberOfMonths: 1,
                prevText: "",
                nextText: "",
                monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                dayNames: ["일", "월", "화", "수", "목", "금", "토"],
                dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
                dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
                showMonthAfterYear: true,
                yearSuffix: ".",
            });
    });

</script>