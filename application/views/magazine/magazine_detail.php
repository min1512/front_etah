<link rel="stylesheet" href="/assets/css/display.css?ver=1.1.1">
<link rel="stylesheet" href="/assets/css/mypage.css">

<div class="contents vip02">

    <div class="nav" id="nav">
        <h1 class="nav_title">컨텐츠</h1>
        <ul class="nav_list">
            <?for($i=0;$i<count($nav['CATEGORY_CD1']);$i++) {?>
                <li class="nav_item <?=substr($nav['CATEGORY_CD1'][$i], 0, 1) == substr($detail['CATEGORY_CD2'] ,0 ,1) ? "active" : ""?>">
                    <?if(substr($nav['CATEGORY_CD1'][$i], 0, 1)==9) {?>
                        <a href="/magazine/mid_list/<?=$nav['CATEGORY_CD1'][$i]?>"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <?}else {?>
                        <a href="#" class="nav_link"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <?}?>
                    <ul class="nav_list_2depth">
                        <?for($j=0;$j<count($nav['CATEGORY_CD2']);$j++) {?>
                            <li><a href="/magazine/list/<?=$nav['CATEGORY_CD2'][$i][$j]?>" <?=$nav['CATEGORY_CD2'][$i][$j] == $detail['CATEGORY_CD2'] ? "class='active'" : ""?>><?=$nav['CATEGORY_NM2'][$i][$j]?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?}?>
        </ul>
    </div>

    <div class="location position_area">
        <h2 class="title_page">
            <?=$detail['TITLE']?>
        </h2>
        <ul class="location_list position_right">
            <li class="location_item"><a href="/magazine/mid_list/<?=$detail['CATEGORY_CD1']?>"><?=$detail['CATEGORY_NM1']?></a><span class="spr-common spr_arrow_right"></span></li>
            <li class="location_item"><a href="/magazine/list/<?=$detail['CATEGORY_CD2']?>"><?=$detail['CATEGORY_NM2']?></a><span class="spr-common spr_arrow_right"></span></li>
            <li class="location_item"><a href="#" class="active"><?=$detail['TITLE']?></a></li>
        </ul>
    </div>

    <div class="vip_inner">
        <div class="vip_prd_info">
            <div class="vip_prd_info_cont">
                <?foreach($magazine as $row){
                    if($row['MAGAZINE_CONTENTS_GB_CD'] == 'IMG'){	?>
                        <div class="magazine_img"><img src="<?=$row['HEADER_DESC']?>" alt="" /></div>
                    <?} else if($row['MAGAZINE_CONTENTS_GB_CD'] == 'TEXT'){?>
                        <p class="magazine_text"><?=$row['HEADER_DESC']?></p>
                    <?} else if($row['MAGAZINE_CONTENTS_GB_CD'] == 'HTML'){?>
                        <?=$row['HEADER_DESC']?>
                    <?} else if($row['MAGAZINE_CONTENTS_GB_CD'] == 'VIDEO'){?>
                        <div style="text-align: center;">
                            <iframe width="600" height="300" src="https://www.youtube.com/embed/<?=$row['HEADER_DESC']?>" frameborder="0"></iframe>
                        </div>
                    <?}
                }?>

                <?if($categoryGubun == 7 || $categoryGubun == 8) {?>
                    <div id="map" style="width:auto;height:300px;"></div>
                    <div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);">
                        <a href="https://map.kakao.com" target="_blank" style="float: left;">
                            <img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px">
                        </a>
                        <div style="float: right; position: relative; top: 1px; font-size: 11px;">
                            <a id="path" target="_blank" href="#" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a>
                        </div>
                    </div>
                <?}?>
            </div>

            <div class="vip_prd_info_cont">
                <!-- 댓글 영역// -->
                <?if($categoryGubun == 9){?>     <!-- 이벤트 댓글 영역// -->
                    <h3 class="info_cont_title">댓글 <?=$detail['COMMENT_CNT']?></h3>
                    <div class="board_list board_list_comment">
                        <input type="hidden" id="magazine_no"		name="magazine_no"		value="<?=$this->uri->segment(3)?>">	<!--상품코드-->
                        <input type="hidden" id="pre_page_C"		name="pre_page_C"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
                        <input type="hidden" id="limit_num_C"		name="limit_num_C"		value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
                        <input type="hidden" id="total_cnt_C"		name="total_cnt_C"		value="<?=$detail['COMMENT_CNT']?>">	<!--전체 문의글 갯수-->
                        <input type="hidden" id="totla_page_C"		name="total_page_C"		value="<?=$total_page?>">	<!--전체 페이지 수-->
                        <input type="hidden" id="next_C"			name="next_C"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->

                        <table class="board_list_table">
                            <caption>댓글 리스트</caption>
                            <colgroup>
                                <col style="width:66px;" />
                                <col style="width:93px;" />
                                <col />
                                <col style="width:72px;" />
                                <col style="width:129px;" />
                            </colgroup>
                            <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col" colspan="2">댓글</th>
                                <th scope="col">작성자</th>
                                <th scope="col">작성일</th>
                            </tr>
                            </thead>
                            <tbody id="comment_body">
                            <?
                            $idx = $detail['COMMENT_CNT'];
                            foreach($magazine_comment as $row) {?>
                                <tr class="active">
                                    <!-- 코멘트 열리면 클래스 active 추가 -->
                                    <td><?=$idx?></td>
                                    <td class="image">
                                        <?if(!empty($row['FILE_PATH'])){?>
                                            <img src="<?=$row['FILE_PATH']?>" alt="" style="width:60px;height:60px;" onclick="$('#pop-thumb<?=$idx?>').addClass('layer__view');">

                                            <!-- // 썸네일 팝업 레이어 -->
                                            <div class="layer layer_big_thumb" id="pop-thumb<?=$idx?>">
                                                <div class="layer_inner">
                                                    <h1 class="layer_title layer_title__line">이미지</h1>
                                                    <div class="layer_cont">
                                                        <img src="<?=$row['FILE_PATH']?>" alt="image" style="width: 100%;">
                                                    </div>
                                                    <a href="#layer_big_thumb" class="spr-common layer_close" title="레이어 닫기" onclick="$('#pop-thumb<?=$idx?>').removeClass('layer__view');"></a>
                                                </div>
                                                <div class="dimd"></div>
                                            </div>
                                            <!-- 썸네일 팝업 레이어 // -->
                                        <?}?>
                                    </td>
                                    <td class="comment">
                                        <?=nl2br(iconv_substr((str_replace("<br />","\n",$row['CONTENTS'])),0,300,"utf-8"))?>
                                        <?if(iconv_strlen((str_replace("<br />","\n",$row['CONTENTS'])), "utf-8")>300){?>
                                            <span style="display: none;" id="hidContents<?=$idx?>"><?=nl2br(iconv_substr((str_replace("<br />","\n",$row['CONTENTS'])),300))?></span>
                                            <ul class="btn_list btn_list__reply position_right">
                                                <li><button type="button" class="btn_white btn_white__small" type="button" class="btn_white btn_white__small" onclick="javascript:folding_contents('M', <?=$idx?>)" id="fold_btn<?=$idx?>">더보기</button></li>
                                            </ul>
                                        <?}?>
                                        <?if($row['CUST_NO']==$this->session->userdata('EMS_U_NO_')) {?>
                                            <ul class="btn_list btn_list__reply">
                                                <li><button type="button" class="btn_white btn_white__small" onclick="javascript:comment_update_layer(<?=$row['COMMENT_NO']?>)">수정</button></li>
                                                <li><button type="button" class="btn_white btn_white__small" onclick="javascript:jsDelComment(<?=$row['COMMENT_NO']?>)">삭제</button></li>
                                            </ul>
                                        <?}?>
                                    </td>
                                    <td><?=$row['CUST_ID']?></td>
                                    <td><?=$row['REG_DT']?></td>
                                </tr>

                                <!-- 상품평 수정하기 레이어 // -->
                                <div id="modify_comment"></div>
                                <!-- // 상품평 수정하기 레이어 -->
                                <?
                                $idx--;
                            }?>
                            </tbody>
                        </table>
                    </div>
                <?} else {?>
                    <div class="comment">
                        <div class="page-info">
                            <span>좋아요 <i><?=$detail['LOVE_CNT']?></i></span><span>공유 <i><?=$detail['SHARE']?></i></span><span>댓글 <i><?=$detail['COMMENT_CNT']?></i></span><span>조회 <i><?=$detail['HITS']?></i></span>
                        </div>
                        <p class="comment-count">댓글 <?=$detail['COMMENT_CNT']?></p>

                        <form name="regCommentForm" id="regCommentForm" method="post">
                            <div class="write-layer">
                                <div class="spr-mypage spr-profile"></div>
                                <div class="comment-input">
                                    <input type="hidden" id="magazine_no" name="magazine_no" value="<?=$detail['MAGAZINE_NO']?>">	<!--매거진번호-->
                                    <textarea name="comment_contents" id="comment_contents" cols="30" rows="2"></textarea>
                                    <button type="button" class="btn_positive" onclick="javascript:jsRegComment()">등록</button>
                                </div>
                            </div>
                        </form>

                        <div class="read-layer">
                            <input type="hidden" id="magazine_no"		name="magazine_no"		value="<?=$this->uri->segment(3)?>">	<!--상품코드-->
                            <input type="hidden" id="pre_page_C"		name="pre_page_C"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
                            <input type="hidden" id="limit_num_C"		name="limit_num_C"		value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
                            <input type="hidden" id="total_cnt_C"		name="total_cnt_C"		value="<?=$detail['COMMENT_CNT']?>">	<!--전체 문의글 갯수-->
                            <input type="hidden" id="totla_page_C"		name="total_page_C"		value="<?=$total_page?>">	<!--전체 페이지 수-->
                            <input type="hidden" id="next_C"			name="next_C"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->

                            <ul class="comment-list" id="comment_body">
                                <?foreach($magazine_comment as $row) {?>
                                    <li class="comment-box">
                                        <span class="author"><?=$row['CUST_ID']?></span>
                                        <span id="commentText<?=$row['COMMENT_NO']?>">
                                        <span class="date"><?=$row['REG_DT']?></span>
                                        <p class="text"><?=$row['CONTENTS']?>﻿</p>
                                            <?if($row['CUST_NO']==$this->session->userdata('EMS_U_NO_')) {?>
                                                <div class="modify">
                                                <button type="button" class="btn_negative" onclick="javascript:jsDelComment(<?=$row['COMMENT_NO']?>)">삭제</button>
                                                <button type="button" class="btn_white" onclick="javascript:change_input(<?=$row['COMMENT_NO']?>, '<?=$row['CONTENTS']?>')">수정</button>
                                            </div>
                                            <?}?>
                                        </span>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                <?}?>
                <!-- //댓글 영역 -->

                <!--댓글 페이지번호-->
                <div class="position_area" >
                    <div id="comment_pagination_position">
                    <? if(0 < $detail['COMMENT_CNT']){	?>
                        <div class="page" id="comment_pagination">
                            <!--	<a href="#" class="page_prev">
                                    <span class="spr-common spr_arrow_left"></span>Pre
                                </a>	-->
                            <ul class="page_list">
                                <? $total_page = ceil($detail['COMMENT_CNT']/$limit_num);
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
                    <?if($categoryGubun == 9){?>
                        <span onclick="jsWrite_Comment();" class="btn_write position_right" <? if($this->session->userdata('EMS_U_ID_')){?> data-ui="toggle-btn" data-target="#prd_comment_layer"<?}?> style="cursor:pointer;">댓글쓰기</span>
                    <?}?>
                </div>

                <form name="regCommentForm" id="regCommentForm" method="post" enctype="multipart/form-data">
                    <div class="prd_inquiry_layer" id="prd_comment_layer">
                        <h3 class="prd_inquiry_layer_title">댓글 쓰기</h3>
                        <input type="hidden" id="magazine_no" name="magazine_no" value="<?=$detail['MAGAZINE_NO']?>">	<!--매거진번호-->
                        <dl class="prd_inquiry_layer_line">
                            <dt class="title"><label for="comment_contents">댓글</label></dt>
                            <dd class="data">
                                <textarea class="input_text" id="comment_contents" name="comment_contents" style="width: 688px;"></textarea>
                            </dd>
                        </dl>
                        <dl class="prd_inquiry_layer_line">
                            <dt class="title"><label for="file_url">이미지</label></dt>
                            <dd class="data">
                                <input type="text" id="file_url" name="file_url" placeholder="jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다." class="input_text" style="width: 605px;" disabled>
                                <a href="javaScript:jsDel();" class="spr-mypage spr-btn_delete" title="이미지삭제"></a>
                                <label for="fileUpload" class="btn_white btn_search">찾아보기</label>
                                <input type="file" id="fileUpload" name="fileUpload" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this);">
                            </dd>
                        </dl>
                        <ul class="btn_list">
                            <li><button type="button" class="btn_positive btn_positive__min" onclick="javascript:jsRegComment()">등록하기</button></li>
                            <li><button type="button" class="btn_negative btn_negative__min" data-ui="toggle-btn" onClick="javascript:$('#prd_comment_layer').hide();">취소</button></li>
                        </ul>
                    </div>
                </form>
            </div>

            <div class="vip_prd_info_cont">
                <?if($categoryGubun == 7 && count($magazineGoods)!=0) {?>
                    <div class="vip_brand_recom">
                        <h3 class="info_cont_title">이 공방 상품보기</h3>
                        <div class="basic_goods_list">
                            <ul class="goods_list">
                                <?foreach($magazineGoods as $row){?>
                                    <li class="goods_item">
                                        <div class="img">
                                            <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="img_link"><img src="<?=$row['IMG_URL']?>" alt=""></a>
                                            <div class="tag-wrap">
                                                <?if($row['CLASS_GUBUN'] == 'C'){?><!--<span class="circle-tag class"><em class="blk">에타홈<br>클래스</em></span>--><?}?>
                                                <?if($row['CLASS_GUBUN'] == 'G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                                            </div>
                                            <ul class="goods_action_menu">
                                                <li class="goods_action_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$row['GOODS_CD']?>','','');">
                                                        <span class="spr-common spr-heart2"></span>
                                                        <span class="spr-common spr-bgcircle2"></span>
                                                        <span class="button_text">Add wish list</span>
                                                    </button>
                                                </li>
                                                <li class="goods_action_item goods_action_sns">
                                                    <button type="button" class="action_btn action_btn__sns">
                                                        <span class="spr-common spr_share"></span>
                                                        <span class="spr-common spr-bgcircle2"></span>
                                                        <span class="button_text">share</span>
                                                    </button>
                                                    <ul class="goods_sns_list">
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_pinter"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">핀터레스트</span>
                                                            </button>
                                                        </li>
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$row['GOODS_CD']?>','','<?=$row['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_kakao"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">카카오스토리</span>
                                                            </button>
                                                        </li>
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_facebook"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">페이스북</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>

                                        <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="goods_item_link">
                                    <span class="brand">
                                        <?=$row['BRAND_NM']?>
                                    </span>
                                            <span class="name"><?=$row['GOODS_NM']?></span>
                                            <span class="price">
                                        <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                            $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                            echo number_format($price);

                                            $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <span class="dc_price">
                                        <s class="del_price"><?=number_format($row['SELLING_PRICE'])?></s> (<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                        </span>
                                        <?}else{
                                            echo number_format($price = $row['SELLING_PRICE']);
                                        }?>
                                    </span>
                                            <span class="icon_block">
                                        <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){?>
                                            <span class="spr-common spr_ico_coupon"></span>
                                        <?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){ ?>
                                            <span class="spr-common spr_ico_mileage"></span>
                                        <?} if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){?>
                                            <span class="spr-common spr_ico_free_shipping"></span>
                                        <?}?>
                                    </span>
                                        </a>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                <?}?>

                <!--관련 상품 추천-->
                <?if(($categoryGubun==5 || $categoryGubun==6) && count($magazineAboutGoods) != 0){?>
                    <div class="vip_brand_recom">
                        <h3 class="info_cont_title">관련 상품 추천</h3>
                        <div class="basic_goods_list">
                            <ul class="goods_list">
                                <?foreach($magazineAboutGoods as $row){?>
                                    <li class="goods_item">
                                        <div class="img">
                                            <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="img_link">
                                                <img src="<?=$row['IMG_URL']?>" alt="">
                                                <div class="tag-wrap">
                                                    <?if(!empty($row['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                                </div>
                                            </a>
                                            <ul class="goods_action_menu">
                                                <li class="goods_action_item">
                                                    <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','','<?=$row['GOODS_CD']?>','','');">
                                                        <span class="spr-common spr-heart2"></span>
                                                        <span class="spr-common spr-bgcircle2"></span>
                                                        <span class="button_text">Add wish list</span>
                                                    </button>
                                                </li>
                                                <li class="goods_action_item goods_action_sns">
                                                    <button type="button" class="action_btn action_btn__sns">
                                                        <span class="spr-common spr_share"></span>
                                                        <span class="spr-common spr-bgcircle2"></span>
                                                        <span class="button_text">share</span>
                                                    </button>
                                                    <ul class="goods_sns_list">
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_pinter"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">핀터레스트</span>
                                                            </button>
                                                        </li>
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','<?=$row['GOODS_CD']?>','','<?=$row['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_kakao"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">카카오스토리</span>
                                                            </button>
                                                        </li>
                                                        <li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">
                                                                <span class="spr-common spr_share_facebook"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">페이스북</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="/goods/detail/<?=$row['GOODS_CD']?>" class="goods_item_link">
                                        <span class="brand">
                                            <?=$row['BRAND_NM']?>
                                        </span>
                                            <span class="name"><?=$row['GOODS_NM']?></span>
                                            <span class="price">
                                            <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                                echo number_format($price);

                                                $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                $sale_percent = strval($sale_percent);
                                                $sale_percent_array = explode('.',$sale_percent);
                                                $sale_percent_string = $sale_percent_array[0];
                                                ?>
                                                <span class="dc_price">
                                                <s class="del_price"><?=number_format($row['SELLING_PRICE'])?></s> (<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common spr_ico_arrow_down"></span>)
                                            </span>
                                            <?}else{
                                                echo number_format($price = $row['SELLING_PRICE']);
                                            }?>
                                        </span>
                                            <span class="icon_block">
                                        <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                            ?>
                                            <span class="spr-common spr_ico_coupon"></span>
                                            <?
                                        }
                                        if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                            ?>
                                            <span class="spr-common spr_ico_mileage"></span>
                                            <?
                                        }
                                        if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){
                                            ?>
                                            <span class="spr-common spr_ico_free_shipping"></span>
                                        <?}?>
                                    </span>
                                        </a>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                <?}?>

                <!--다른 매거진 더보기-->
                <?if($categoryGubun!=9 && count($otherMagazine) != 0){?>
                    <div class="vip_brand_recom">
                        <h3 class="info_cont_title">
                            <?if($categoryGubun == 7){?>비슷한 공방 클래스 보기<?}else{?>다른 매거진 더보기<?}?>
                        </h3>
                        <div class="basic_goods_list">
                            <ul class="goods_list">
                                <? foreach($otherMagazine as $row){	?>
                                    <li class="goods_item">
                                        <div class="img">
                                            <a href="/magazine/detail/<?=$row['MAGAZINE_NO']?>" class="img_link"><img src="<?=$row['IMG_URL']?>" alt=""></a>
                                        </div>
                                        <a href="/goods/detail/<?=$row['MAGAZINE_NO']?>" class="goods_item_link">
                                    <span class="brand">
                                        <?=$row['CATEGORY_NM']?>
                                    </span>
                                            <span class="name"><?=$row['TITLE']?></span>
                                        </a>
                                    </li>
                                <? }?>
                            </ul>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>


        <!-- 매거진 form 시작 -->
        <div class="vip_detail" id="vipSelectOption">
            <div class="vip_detail_top">
                <div class="vip_prd_code"><span><?=$detail['CATEGORY_NM2']?></span></div>
                <div class="position_area vip_detail_prd_title">
                    <h3 class="title">
                        <?if($detail['CATEGORY_CD2'] == 90010000) {
                            if($detail['END_DT'] < date('Y-m-d H:i:s')){?>
                                [종료]
                            <?} else {?>
                                [진행중]
                            <?}
                        }?>
                        <?=$detail['TITLE']?>
                    </h3>
                    <p><?=strftime("%Y년 %m월 %d일 %H:%M", strtotime($detail['REG_DT']))?></p>
                    <!-- <button type="button" class="position_right btn_guide" data-ui="layer-opener" data-target="#layer__order_guide_layer"><span class="spr-common spr_btn_guide"></span>Guide</button> -->
                </div>
            </div>
            <div class="vip_detail_inner">
                <ul class="btn_list vip_detail_btns">
                    <li><button type="button" class="btn_negative btn_negative__min <?echo ($heart=='Y')?'active':''?>" onClick="javaScript:jsLoveAction(<?=$detail['MAGAZINE_NO']?>);"><span class="spr-common spr-heart"></span>좋아요 <?=$detail['LOVE_CNT']?></button></li>
                    <li><button type="button" class="btn_negative btn_negative__min" >조회수 <?=$detail['HITS']?></button></li>
                </ul>

                <?if($categoryGubun == 4 || $categoryGubun == 5 || $categoryGubun == 6) {?>
                    <a href="/magazine/goods_plus?magazineCode=<?=$detail['MAGAZINE_NO']?>&category=<?=$detail['CATEGORY_CD2']?>">
                        <button type="button" class="btn_yellow vip_detail_btn_buy">매거진 상품 모아보기</button>
                    </a>
                <?}?>
                <?if($categoryGubun == 7) {?>
                    <a href="/goods/brand/<?=$detail['BRAND_CD']?>">
                        <button type="button" class="btn_yellow vip_detail_btn_buy">이 공방의 브랜드관 가기</button>
                    </a>
                <?}?>

                <input type="text" value="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" id="url" style="opacity: 0;"><br>
                <b>공유하기</b> <?=$detail['SHARE']?>회
                <br><br>
                <ul class="vip_detail_sns">
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:jsMagazineAction('F', '<?=$detail['MAGAZINE_NO']?>', '<?=$detail['TITLE']?>', '<?=$detail['IMG_URL']?>')" class="spr-common spr_share_facebook"> </a>
                    </li>
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:jsMagazineAction('K', '<?=$detail['MAGAZINE_NO']?>', '<?=$detail['TITLE']?>', '<?=$detail['IMG_URL']?>')" class="spr-common spr_share_kakao"> </a>
                    </li>
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:jsMagazineAction('N', '<?=$detail['MAGAZINE_NO']?>', '<?=$detail['TITLE']?>', '<?=$detail['IMG_URL']?>')" class="spr-common spr_ico_blog"> </a>
                    </li>
                    <li class="vip_detail_sns_item">
                        <a href="javaScript:copyCurrentUrl()" class="spr-common spr_share" style="filter: invert(100%);"></a>
                    </li>
                </ul>
            </div>
            <span class="bg_shadow_bottom"></span>
            <span class="bg_shadow_right"></span>
        </div>
    </div>



    <!--공유하기-->
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/vip.js"></script>
    <script type="text/javascript">
        //google_gtag
//        console.log(<?//=$detail['MAGAZINE_NO']?>//);
        gtag('event', 'select_content', {
            "promotions": [
                {
                    "id": "<?=$detail['MAGAZINE_NO']?>",
                    "name": "ETAH - magazine"
                }
            ]
        });

        // 인접 레이어팝업 - 친구에게 공유하기
        $(function(){
            var layerBtn = $('[data-layer="layer-opener2"]');

            $(layerBtn).on('click', function(){
                var thisHref = $(this).attr('href');
                $(thisHref).addClass('layer__view');
                return false;
            });

            $("html").click(function(e){
                if(!$(e.target).hasClass('layer2')) {  //인접팝업(layer-wrap2) 바깥쪽 클릭 시 닫음
                    $("#layerSnsShare2").removeClass('layer__view');
                }
            });
        });

        // vip tab
        $('.tab_menu .tab_link').click(function()
        {
            var thisHref = $(this).attr('href');
            $('.tab_item').removeClass('active');
            $(this).parent('.tab_item').addClass('active');
            $('.vip_prd_info_cont').hide();
            $(thisHref).css('display', 'block');
            console.log(thisHref)
            return false;
        });

        //=====================================
        // 링크 복사하기
        //=====================================
        function copyCurrentUrl() {
            var copyText = document.getElementById("url");
            copyText.select();
            document.execCommand("copy");
            alert("URL이 복사되었습니다.");
        }

        //=====================================
        // SNS 공유하기
        //=====================================
        function jsMagazineAction(share, val, title, img) {
            var url = '<?=base_url()?>'+'magazine/detail/'+val;
            // var url = 'http://www.etah.co.kr/magazine/detail/'+val;
            //네이버
            if(share == 'N') {
                var url = encodeURI(encodeURIComponent(url));
                var title = encodeURI(title);
                window.open("https://share.naver.com/web/shareView.nhn?url=" + url + "&title=" + title, '', 'width=626,height=436');
            }
            //페이스북
            else if(share == 'F'){
                window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url)+'&title='+title+'&img='+img,'facebook-share-dialog','width=626,height=436');
            }
            //카카오스토리
            else if(share == 'K'){
                shareStory(url,title);
            }
            //카카오톡
            else if(share == 'T'){
                shareKakaoTalk(url, img, title);
            }

            $.ajax({
                type: 'POST',
                url: '/magazine/magazine_share',
                dataType: 'json',
                data: {'magazine_no' : val}
            })
        }
        //=====================================
        // 카카오스토리 공유하기
        //=====================================
        function shareStory(url, text) {
            Kakao.Story.share({
                url: url,
                text: text
            });
        }

        //=====================================
        // 카카오톡 공유하기
        //=====================================
        Kakao.init('a05f67602dc7a0ac2ef1a72c27e5f706');

        function shareKakaoTalk(url, img, title){
            //카카오링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
            Kakao.Link.sendDefault({
                objectType: 'feed',
                content: {
                    title: title,
                    imageUrl: img,
                    link: {
                        mobileWebUrl: url,
                        webUrl: url
                    }
                },
                buttons: [
                    {
                        title: '자세히 보기',
                        link: {
                            mobileWebUrl: url,
                            webUrl: url
                        }
                    }
                ]
            });
        }

    </script>

    <!--지도 API //-->
    <?if($categoryGubun == 7 || $categoryGubun == 8) {?>
        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a05f67602dc7a0ac2ef1a72c27e5f706&libraries=services"></script>
        <script>
            var mapContainer = document.getElementById('map'), // 지도를 표시할 div
                mapOption = {
                    center: new daum.maps.LatLng(37.494940, 127.038061), // 지도의 중심좌표
                    level: 3 // 지도의 확대 레벨
                };

            // 지도를 생성합니다
            var map = new daum.maps.Map(mapContainer, mapOption);

            // 주소-좌표 변환 객체를 생성합니다
            var geocoder = new daum.maps.services.Geocoder();

            // 주소로 좌표를 검색합니다
            geocoder.addressSearch('<?=$detail['ADDRESS']?>', function(result, status) {

                // 정상적으로 검색이 완료됐으면
                if (status === daum.maps.services.Status.OK) {

                    var coords = new daum.maps.LatLng(result[0].y, result[0].x);
                    x = result[0].y;
                    y = result[0].x;

                    // 결과값으로 받은 위치를 마커로 표시합니다
                    var marker = new daum.maps.Marker({
                        map: map,
                        position: coords
                    });

                    var infowindow = new daum.maps.InfoWindow({
                        content: '<div style="width:250px;text-align:center;padding:6px 0;">' +
                        '<span style="font-weight:600;"><?=$detail['ADDRESS']?></span>' +
                        '</div>'
                    });
                    infowindow.open(map, marker);

                    // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                    map.setCenter(coords);

                    var path = 'https://map.kakao.com/link/to/<?=$detail['ADDRESS']?>' + ','+ x + ',' + y;

                    $("#path").attr("href",path);
                }
            });
        </script>
    <?}?>
    <!--// 지도 API-->

    <script type="text/javascript">
        var nav = $('#nav'),
            navLink = nav.find('.nav_link'),
            itemParent = $('.nav_item'),
            add = 'active';

        $(navLink).click(function()
        {
            var thisParent = $(this).parents('.nav_item');
            $(itemParent).find('.nav_list_2depth').stop().slideUp();

            if ($(thisParent).hasClass(add))
            {
                $(thisParent).addClass(add);
                $(thisParent).find('.nav_list_2depth').stop().slideUp();
            }
            else
            {
                $(thisParent).removeClass(add);
                $(thisParent).find('.nav_list_2depth').stop().slideDown();
            };
            return false;
        });
    </script>


    <script type="text/javascript">
        //===============================================================
        // 댓글쓰기 버튼을 누를 시, 로그인 상태 체크
        //===============================================================
        function jsWrite_Comment(){
            var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

            if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){
                setTimeout(function(){
                    if(confirm("로그인 후 댓글 쓰기가 가능합니다. \n로그인하시겠습니까?")){
                        location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                    }
                },100);
            }
        }

        //===============================================================
        // 매거진 좋아요
        //===============================================================
        function jsLoveAction(magazine_no) {

            var magazine_no = magazine_no;

            var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
            if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST') {
                if(confirm("로그인 후 이용가능합니다. \n로그인하시겠습니까?")){
                    location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                    return false;
                } else {
                    return false;
                }
            }

            $.ajax({
                type: 'POST',
                url: '/magazine/magazine_love',
                dataType: 'json',
                data: {'magazine_no' : magazine_no},
                error: function(res) {
                    alert(res);
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
//                    alert(res.message);
                        location.reload();
                    }
                    else alert(res.message);
                }
            })
        }

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
        // 매거진 댓글 등록하기
        //===============================================================
        function jsRegComment(){
            var data = new FormData($('#regCommentForm')[0]);
            var comment_contents	= $("#comment_contents").val();
            var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST') {
                if(confirm("로그인 후 댓글 쓰기가 가능합니다. \n로그인하시겠습니까?")){
                    location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                    return false;
                } else {
                    return false;
                }
            }

            console.log(data);
            if( ! comment_contents ){
                alert('댓글을 입력하시기 바랍니다.');
                $("input[name=comment_contents]").focus();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '/magazine/comment_regist',
                dataType: 'json',
                data: data,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                error: function(res) {
                    alert(res);
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        location.reload();
                    }
                    else alert(res.message);
                }
            })

        }

        //===============================================================
        // 매거진 댓글 수정
        //===============================================================
        //댓글 수정 입력란
        function change_input(val, txt){
            $("#commentText"+val).html("<div class=\"comment-input\">" +
                "<textarea name=\"upd_comment_contents\" id=\"upd_comment_contents\" cols=\"30\" rows=\"2\">"+txt.replace(/<br \/>/gi, '\n')+"</textarea>" +
                "<button type=\"button\" class=\"btn_white\" onclick=\"javascript:jsUpdComment("+val+")\">수정</button>");
        }

        //매거진 상세페이지 댓글 수정
        function jsUpdComment(val){
            var gubun = 'A';
            var txt = $("#upd_comment_contents").val();

            $.ajax({
                type: 'POST',
                url: '/magazine/comment_update',
                dataType: 'json',
                data: {
                    'gubun' : gubun,
                    'comment_no' : val,
                    'comment_txt' : txt
                },
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

        //댓글 수정 레이어
        function comment_update_layer(val){
            $.ajax({
                type: 'POST',
                url: '/magazine/comment_update_layer',
                dataType: 'json',
                data: { 'comment_no' : val },
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        $("#modify_comment").html(res.modify_comment);
                    }
                    else console.log(res.message);
                }
            })
        }

        //===============================================================
        // 매거진 댓글 삭제
        //===============================================================
        function jsDelComment(comment_no) {
            if(!confirm('삭제하시겠습니까?')) {
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '/magazine/comment_delete',
                dataType: 'json',
                data: {'comment_no' : comment_no},
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        alert('삭제되었습니다');
                        location.reload();
                    }
                    else alert(res.message);
                }
            })
        }

        //=====================================
        // 댓글 내용 더보기/접기
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


        //===============================================================
        // 페이징
        //===============================================================
        function jsPaging_Comment(page){
            var magazine_no  = $("input[name=magazine_no]").val();		//매거진 번호
            var pre_page	= $("input[name=pre_page_C]").val();		//이전페이지
            var limit_num	= $("input[name=limit_num_C]").val();		//한 페이지당 보여줄 갯수
            var next		= $('input[name=next_C]').val();			//다음페이지를 만들지 말지 비교를 위한 변수

            $.ajax({
                type: 'POST',
                url: '/magazine/comment_paging',
                dataType: 'json',
                data: {magazine_no : magazine_no, page : page, limit : limit_num},
                error: function(res) {
                    alert('Database Error');
                    alert(res.responseText);
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        var comment = res.comment;
                        var comment_temp = "";

                        var idx = <?=$detail['COMMENT_CNT']?> - (limit_num * (page-1));
                        <?if($categoryGubun == 9){?>
                        for(var i=0; i<comment.length; i++){
                            comment_temp += "<tr class=\"active\">" +
                                "<td>"+idx+"</td>" +
                                "<td class=\"image\">";

                            if( comment[i]['FILE_PATH'] ){
                                comment_temp += "<img src=\""+comment[i]['FILE_PATH']+"\" alt=\"\" style=\"width:60px;height:60px;\" onclick=\"$('#pop-thumb"+idx+"').addClass('layer__view');\">" +
                                    "<div class=\"layer layer_big_thumb\" id=\"pop-thumb"+idx+"\">" +
                                    "<div class=\"layer_inner\">" +
                                    "<h1 class=\"layer_title layer_title__line\">이미지</h1>" +
                                    "<div class=\"layer_cont\"><img src=\""+comment[i]['FILE_PATH']+"\" alt=\"image\" style=\"width: 100%;\"></div>" +
                                    "<a href=\"#layer_big_thumb\" class=\"spr-common layer_close\" title=\"레이어 닫기\" onclick=\"$('#pop-thumb"+idx+"').removeClass('layer__view');\"></a>" +
                                    "</div>" +
                                    "<div class=\"dimd\"></div>" +
                                    "</div>";
                            }

                            comment_temp += "</td><td class=\"comment\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(0,300).replace(/(\n|\r\n)/g, '<br>');

                            if(comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').length > 300){
                                comment_temp += "<span style=\"display: none;\" id=\"hidContents"+idx+"\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(300).replace(/(\n|\r\n)/g, '<br>')+"</span>" +
                                    "<ul class=\"btn_list btn_list__reply position_right\">" +
                                    "<li><button type=\"button\" class=\"btn_white btn_white__small\" type=\"button\" class=\"btn_white btn_white__small\" onclick=\"javascript:folding_contents('M', "+idx+")\" id=\"fold_btn"+idx+"\">더보기</button></li>" +
                                    "</ul>";
                            }


                            if (comment[i]['CUST_NO'] == '<?=$this->session->userdata('EMS_U_NO_')?>'){
                                comment_temp += "<ul class=\"btn_list btn_list__reply\">" +
                                    "<li><button type=\"button\" class=\"btn_white btn_white__small\" onclick=\"comment_update_layer(" + comment[i]['COMMENT_NO'] + ")\">수정</button></li>" +
                                    "<li><button type=\"button\" class=\"btn_white btn_white__small\" onclick=\"jsDelComment(" + comment[i]['COMMENT_NO'] + ")\">삭제</button></li>" +
                                    "</ul>";
                            }

                            comment_temp += "</td>" +
                                "<td>"+comment[i]['CUST_ID']+"</td>" +
                                "<td>"+comment[i]['REG_DT']+"</td></tr>";

                            comment_temp += "<div id=\"modify_comment\"></div>";

                            idx--;
                        }

                        <?} else{?>
                        for(var i=0; i<comment.length; i++){
                            comment_temp += "<li class=\"comment-box\">" +
                                "<span class=\"author\">"+comment[i]['CUST_ID']+"</span>" +
                                "<span id=\"commentText"+comment[i]['COMMENT_NO']+"\">" +
                                "<span class=\"date\">"+comment[i]['REG_DT']+"</span>" +
                                "<p class=\"text\">"+comment[i]['CONTENTS']+"</p>";
                            if (comment[i]['CUST_NO'] == '<?=$this->session->userdata('EMS_U_NO_')?>'){
                                comment_temp += "<div class=\"modify\">" +
                                    "<button type=\"button\" class=\"btn_negative\" onclick=\"jsDelComment(" + comment[i]['COMMENT_NO'] + ")\">삭제</button>" +
                                    "<button type=\"button\" class=\"btn_white\" onclick=\"change_input(" + comment[i]['COMMENT_NO'] + ", '" + comment[i]['CONTENTS'] + "')\">수정</button>" +
                                    "</div>";
                            }
                            comment_temp += "</li>";
                        }
                        <?}?>

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
            });
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
                strHtmlPag+="<a href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())-1); jsPaging_Comment("+parseInt(5*nextPage)+");\" class=\"page_prev\"><span class=\"spr-common spr_arrow_left\"></span>Pre</a>";
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

