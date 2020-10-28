<div class="mypage_cont">
    <h3 class="title_page title_page__line title_page__mypage">
        1:1 문의
        <button type="button" class="btn_inquiry" onClick="location.href='/customer/register_qna'">문의하기</button>
    </h3>
    <div class="board_list board_list__inquiry">
        <table class="board_list_table">
            <caption>1:1 문의 리스트</caption>
            <colgroup>
                <col style="width:125px;" />
                <col style="width:103px;" />
                <col />
                <col style="width:97px;" />
                <col style="width:103px;" />
            </colgroup>
            <thead>
            <tr>
                <th scope="col">처리상태</th>
                <th scope="col">구분</th>
                <th scope="col">제목</th>
                <th scope="col">작성자</th>
                <th scope="col">문의일</th>
            </tr>
            </thead>
            <tbody>
            <?if(empty($qna_list)){?>
                <tr>
                    <td colspan="5">등록된 문의가 없습니다.</td>
                </tr>
            <?}else {
                $idx = ($page - 1) * $sNum + 1;
                foreach ($qna_list as $row) {
                    ?>
                    <tr class="" id="qna<?=$idx?>">
                        <td><?if($row['A_NO'] != null){?>
                                답변완료
                            <?}else{?>
                                답변대기
                            <?}?>
                        </td>
                        <td><?=$row['CS_QUE_TYPE_CD_NM']?></td>
                        <td style="text-align: left;"><a href="javaScript:jsOpen(<?=$idx?>, '<?=$row['CUST_NO']?>','<?=$row['SECRET_YN']?>');" class="link">
                                <?if($row['SECRET_YN'] == 'Y'){?>
                                    비밀글입니다.
                                <?}else{?>
                                    <?=$row['Q_TITLE']?>
                                <?}?>
                            </a></td>
                        <td><?=$row['QUE_CUST_NM']?></td>
                        <td><?=$row['REG_DT']?></td>
                    </tr>
                    <tr class="reply">
                        <td colspan="5">
                            <div class="question">
                                <span class="left">Q</span>
                                <div class="text">
                                    <?=$row['Q_CONTENTS']?>
                                </div>
                            </div>
                            <?if($row['GOODS_CD']){?>
                                <div class="prd_info">
                                    <div class="img"><img src="<?=$row['IMG_URL']?>" width="100" height="100" alt=""></div>
                                    <div class="goods_detail__string">
                                        <p class="goods_cd"><?=$row['GOODS_CD']?></p>
                                        <p class="name"><?=$row['GOODS_NM']?></p>
                                        <p class="description"><?=$row['PROMOTION_PHRASE']?></p>
                                    </div>
                                </div>
                            <?}else if($row['ORDER_GOODS_CD']){?>
                                <div class="prd_info">
                                    <div class="img"><img src="<?=$row['ORDER_GOODS_IMG_URL']?>" width="100" height="100" alt=""></div>
                                    <div class="goods_detail__string">
                                        <p class="goods_cd"><?=$row['ORDER_GOODS_CD']?></p>
                                        <p class="name"><?=$row['ORDER_GOODS_NM']?></p>
                                        <p class="option"><?=$row['ORDER_GOODS_OPTION_NM']?></p>
                                    </div>
                                </div>
                            <?}?>
                            <?if($row['A_CONTENTS'] != null){?>
                                <div class="answer">
                                    <span class="left">A</span>
                                    <div class="text">
                                        <?=$row['A_CONTENTS']?>
                                    </div>
                                </div>
                            <?}?>
                        </td>
                    </tr>
                    <?
                    $idx ++;
                }
            }?>
            </tbody>
        </table>
    </div>

    <div class="page">
        <?=$pagination?>
    </div>
</div>
</div>
</div>
<script type="text/javaScript">
    //=====================================
    // 공지 클릭시 펼쳐보기
    //=====================================
    function jsOpen(idx, id, secret){
        if(secret == 'N'){
            if($("#qna"+idx).attr('class') == ""){		//접혀있는 경우
                $("#qna"+idx).addClass('active');
            } else {		//펼쳐있는 경우
                $("#qna"+idx).removeClass();
            }
        }else{
            <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
            alert('비공개 문의내역은 작성자 본인만 확인하실 수 있습니다.');
            <?}else{?>
            var no = <?=$this->session->userdata('EMS_U_NO_')?>;
            if(no == id){
                if($("#qna"+idx).attr('class') == ""){		//접혀있는 경우
                    $("#qna"+idx).addClass('active');
                } else {		//펼쳐있는 경우
                    $("#qna"+idx).removeClass();
                }
            }else{
                alert('비공개 문의내역은 작성자 본인만 확인하실 수 있습니다.');
            }
            <?}?>
        }
    }
</script>