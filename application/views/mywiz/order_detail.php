
					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">주문&#47;배송상세</h3>
						<div class="mypage_section order_delivery_detail">
							<table class="normal_table">
								<caption class="hide">회원가입 필수항목 입력표</caption>
								<colgroup>
									<col style="width:145px" />
									<col />
								</colgroup>
								<tbody>
									<tr>
										<th sope="row">주문일/주문번호</th>
										<td><?=substr($order['REG_DT'],0,10)?> / <?=$order['ORDER_NO']?></td>
									</tr>
									<tr>
										<th sope="row">결제방법</th>
										<td>
											<?
											$str_pay_kind = "";
											switch($order['ORDER_PAY_KIND_CD']){
												case '01' : $str_pay_kind = $order['CARD_COMPANY_NM']. " ";
															$order['FREE_INTEREST_YN'] == 'Y' ? $str_pay_kind .= "무이자 " : "";
															if($order['CARD_MONTH']){
																$str_pay_kind .= $order['CARD_MONTH']."개월 할부";
															}else{
																$str_pay_kind .= "일시불";
															}
															$str_pay_kind .= "<br/>".$order['ORDER_PAY_COMPLETE_DT'];
															echo $str_pay_kind; break;
												case '02' :
															if($order['ORDER_REFER_PROC_STS_CD']=='OA00' || $order['ORDER_REFER_PROC_STS_CD']=='OA01' || $order['ORDER_REFER_PROC_STS_CD']=='OA02'){
																$str_pay_kind = "무통장입금 (".$order['BANK_NM']." ".$order['BANK_ACCOUNT_NO']." / 예금주 : 에타몰)<br />입금기한 : ".date("Y-m-d H:i:s", strtotime($order['DEPOSIT_DEADLINE_DY']))." (입금 기한까지 입금하지 않으시면 자동취소 됩니다.)";
																echo $str_pay_kind;
															}else{
																$str_pay_kind = "무통장입금";
																echo $str_pay_kind;
															}
															break;
                                                case '03' :
                                                            $str_pay_kind = '실시간계좌이체';
                                                            echo $str_pay_kind;
                                                            break;
                                                case '04' :
                                                            $str_pay_kind = "마일리지";
                                                            echo $str_pay_kind;
                                                            break;
                                                case '05' :
                                                            $str_pay_kind = '휴대폰 결제';
                                                            echo $str_pay_kind;
                                                            break;
                                                case '07' :
                                                            $str_pay_kind = '카카오페이';
                                                            echo $str_pay_kind;
                                                            break;
                                                case '08' :
                                                            if($order['ORDER_REFER_PROC_STS_CD']=='OA00' || $order['ORDER_REFER_PROC_STS_CD']=='OA01' || $order['ORDER_REFER_PROC_STS_CD']=='OA02'){
                                                                $str_pay_kind = "ARS결제 (가상번호 : ".preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $order['VARS_VNUM_NO']).")<br />입금기한 : ".date("Y-m-d H:i:s", strtotime($order['VARS_EXPR_DT']))." (입금 기한까지 입금하지 않으시면 자동취소 됩니다.)";
                                                                echo $str_pay_kind;
                                                            }else{
                                                                $str_pay_kind = "ARS결제";
                                                                echo $str_pay_kind;
                                                            }
                                                            break;
                                                case '09' :
                                                            $str_pay_kind = $order['ORDER_PAY_KIND_NM'];
                                                            echo $str_pay_kind;
                                                            break;
                                                case '10' :
                                                            $str_pay_kind = '이벤트';
                                                            echo $str_pay_kind;
                                                            break;

											}
											?>
										</td>
									</tr>
									<tr>
										<th sope="row">주문금액</th>
										<td><em class="price"><?=number_format($order['ORDER_AMT']+$order['DELIV_COST_AMT'])?><span class="won">원</span></em>
											<span>(상품금액 : <?=number_format($order['ORDER_AMT'])?>원 <?=$order['DELIV_COST_AMT'] ? "+ 배송비 : ".number_format($order['DELIV_COST_AMT'])."원" : ""?>)</span>
										</td>
									</tr>
									<tr>
										<th sope="row">할인금액</th>
										<td><em class="price"><?=number_format($order['DC_AMT'])?><span class="won">원</span></em>
											<span><?=$order['DC_AMT']>0 ? "(쿠폰할인 : ".number_format($order['DC_AMT'])."원)" : ""?></span>
										</td>
									</tr>
									<tr class="bold">
										<th sope="row">총 결제금액</th>
										<td>
											<div class="position_area">
												<strong class="price"><?=number_format($order['TOTAL_PAY_SUM'])?><span class="won">원</span></strong>
                                                <?
                                                if($order['PAY_MILEAGE']) {
                                                    if($order['REAL_PAY_AMT'] == 0) {
                                                        echo "(마일리지 : ".number_format($order['PAY_MILEAGE'])."원)";
                                                    } else {
                                                        echo "(".$order['ORDER_PAY_KIND_NM']." : ".number_format($order['R_PAY_AMT'])."원 + 마일리지 : ".number_format($order['PAY_MILEAGE'])."원)";
                                                    }
                                                } else {
                                                    echo "";
                                                }
                                                ?>

                                                <?if( !in_array($order['ORDER_PAY_KIND_CD'], array('09','10')) ){?>
                                                    <button type="button" class="btn_white btn_white__small position_right" onClick="javaScript:printReceipt(<?=$order['ORDER_NO']?>);">영수증출력</button>
                                                <?}?>
											</div>
										</td>
									</tr>
									<!--<tr>
										<th sope="row">적립혜택</th>
										<td>상품 구매완료시 2000마일리지 적립</td>
									</tr>-->
									<!--<tr>
										<th sope="row">주문일/주문번호</th>
										<td>2016-03-12 / 2016031114384</td>
									</tr>
									<tr>
										<th sope="row">결제방법</th>
										<td>무통장입금(농협 79012755939177 / 예금주 : 에타몰)<br />입금기한 : 2016-03-12 23:59 (입금 기한까지 입금하지 않으시면 자동취소 됩니다.)</td>
									</tr>
									<tr>
										<th sope="row">주문금액</th>
										<td><em class="price">52,250<span class="won">원</span></em></td>
									</tr>
									<tr>
										<th sope="row">배송비</th>
										<td><em class="price">2,000<span class="won">원</span></em></td>
									</tr>
									<tr class="bold">
										<th sope="row">총 결제금액</th>
										<td>
											<div class="position_area">
												<strong class="price">52,250<span class="won">원</span></strong>
												<button type="button" class="btn_white btn_white__small position_right">영수증출력</button>
											</div>
										</td>
									</tr>
									<tr>
										<th sope="row">적립혜택</th>
										<td>상품 구매완료시 2000마일리지 적립</td>
									</tr>-->
								</tbody>
							</table>
						</div>

						<h3 class="title_page title_page__mypage">상품정보</h3>
						<div class="mypage_section board_list board_list__prd_info">
							<table class="board_list_table">
								<caption>상품정보</caption>
								<colgroup>
									<col style="width:128px;" />
									<col style="width:104px;" />
									<col />
									<col style="width:51px;" />
									<col style="width:129px;" />
									<col style="width:75px;" />
									<col style="width:129px;" />
									<col style="width:75px;" />
									<col style="width:123px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">상품코드</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col" class="title_prd_info">상품정보</th>
										<th scope="col">수량</th>
										<th scope="col">상품금액</th>
										<th scope="col">할인금액</th>
										<th scope="col">할인적용금액</th>
										<th scope="col">배송비</th>
										<th scope="col">진행상태</th>
									</tr>
								</thead>
								<tbody>
									<?
									$deli_no = "";
									foreach($order_dtl as $row){?>
									<tr>
										<td class="order_number">
											<?=$row['GOODS_CD']?>
										</td>
										<td>
											<a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" width="100" height="100" alt="" /></a>
										</td>
										<td class="goods_detail__string">
											<p class="name"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><?=$row['GOODS_NM']?></a></p>
											<p class="description"><?=$row['PROMOTION_PHRASE']?></p>
											<p class="option"><?=$row['GOODS_OPTION_NM']?><?if($row['SELLING_ADD_PRICE'] > 0){?><br/>옵션추가금액 : <?=number_format($row['SELLING_ADD_PRICE'])?> <?}?> </p>
										</td>
										<td><?=$row['ORD_QTY']?><?if(in_array($row['ORDER_REFER_PROC_STS_CD'], $state_cd)){?><br/><p style="color:#FF5E00;">(-<?=number_format($row['CANCEL_RETURN_QTY'])?>)</p><?}?></td>
										<td><?=number_format(($row['SELLING_PRICE']+$row['SELLING_ADD_PRICE'])*$row['ORD_QTY'])?>원</td>
										<td><?=number_format($row['SUM_R_DC_AMT'])?>원</td>
										<td><?=number_format($row['SUM_GOODS_SELIING_PRICE']-($row['SUM_R_DC_AMT']))?>원<?if(in_array($row['ORDER_REFER_PROC_STS_CD'], $state_cd)){?><br/><p style="color:#FF5E00;">(<?=number_format($row['CANCEL_RETURN_REAL_PAY_AMT']+$row['ORDER_DELIV_COST'])?> )</p><?}?> </td>
										<?if($row['DELIV_POLICY_NO'] != $deli_no){?>
										<td rowspan="<?=$row['GROUP_DELI_ROW']?>">
                                            <?if($row['PATTERN_TYPE_CD'] == 'NONE'){?>
                                                착불
                                            <?}else{?>
											    <?=$row['ORDER_DELIV_COST'] > 0 ? number_format($row['ORDER_DELIV_COST'])."원" : "무료배송" ?>
                                            <?}?>
										</td>
										<?}?>
										<td class="order_status">
											<span class="string"><span class="string"><?=$row['ORDER_REFER_PROC_STS_CD_NM']?></span></span>
											<?if($row['CANCEL_YN']=='Y' && !in_array($order['ORDER_PAY_KIND_CD'], array('09','10'))){?>
                                                <button type="button" class="btn_white btn_white__small" onClick="javaScript:cancelApplyOpen(<?=$row['ORDER_REFER_NO']?>);">취소신청</button>
                                            <?}?>
                                            <?if($row['DELIVE_YN']=='Y'){
                                                if($row['SEND_NATION'] == 'KR'){	//국내배송일경우?>
                                                    <button type="button" class="btn_white btn_white__small" onClick="javaScript:deliveryCheck('<?=$row['INVOICE_NO']?>','<?=$row['DELIV_COMPANY_CD']?>');">배송조회</button><br/>
                                                <? } else {	// 해외배송일경우?>
                                                    <button type="button" class="btn_white btn_white__small" onClick="javaScript:deliveryCheck('<?=$row['INVOICE_NO']?>','GLOBAL');">배송조회</button><br/>
                                                <? } ?>
                                            <?}?>
											<?if($row['RETURN_YN']=='Y' && !in_array($order['ORDER_PAY_KIND_CD'], array('09','10'))){?>
												<button type="button" class="btn_white btn_white__small" onClick="javaScript:returnApplyOpen(<?=$row['ORDER_REFER_NO']?>);">반품신청</button>
                                                <?if($row['COMMENT_YN']=='Y' && $orow['MEMBER_YN']=='Y'){?>
                                                    <button type="button" class="btn_white btn_white__small position_right" onClick="javaScript:jsGoodsComment(<?=$row['GOODS_CD']?>);">상품평쓰기</button>
                                                <?}?>
											<?}?>
										</td>
									</tr>
									<?
									$deli_no = $row['DELIV_POLICY_NO'];
									}?>
									<!--<tr>
										<td class="order_number">
											327668
										</td>
										<td>
											<img src="/assets/images/data/data_100x100_01.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>55,000</td>
										<td>2,750</td>
										<td>52,250</td>
										<td>무료배송</td>
										<td class="order_status">
											<span class="string">입금대기</span>
											<button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="#layer_cancel_apply">취소신청</button>
										</td>
									</tr>-->
								</tbody>
							</table>
							<ul class="bullet_list">
								<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>주문 상품의 <span class="bullet_underline">교환을 원하시는 고객님께서는 상품 수령 후 7일 이내에 <strong>고객센터 페이지에서 좌측 메뉴에 1:1문의&gt;문의하기에 접수/신청</strong></span>하여 주시면 교환 방법에 대해 자세히 안내 드리겠습니다.<br>내용은 고객센터&gt;자주 찾는 질문 참조해주시면 고맙겠습니다.</li>

							</ul>
						<!--	<br/><p>※ 주문 상품의 교환을 원하시는 고객님께서는 상품 수령 후 7일 이내에 고객센터 페이지에서 좌측 메뉴에 1:1문의 > 문의하기에 접수/신청하여 주시면 교환 방법에 대해 자세히 안내 드리겠습니다. 관련 내용은 고객센터 > 자주 찾는 질문 참조해주시면 고맙겠습니다.</p>	-->
						</div>

						<h3 class="title_page title_page__mypage">배송지정보</h3>
						<div class="mypage_section">
							<table class="normal_table normal_table__bg">
								<caption class="hide">배송지정보 입력표</caption>
								<colgroup>
									<col style="width:180px">
									<col>
								</colgroup>
								<tbody>
									<tr>
										<th sope="row">주문하시는분</th>
										<td><?=$order['SENDER_NM']?></td>
									</tr>
									<tr>
										<th sope="row">받으시는분</th>
										<td><?=$order['RECEIVER_NM']?></td>
									</tr>
									<tr>
										<th sope="row">배송지주소</th>
										<td><?="(".$order['RECEIVER_ZIPCODE'].") ".$order['RECEIVER_ADDR1']." ".$order['RECEIVER_ADDR2']?></td>
									</tr>
									<tr>
										<th sope="row">휴대폰번호</th>
										<td><?=$order['RECEIVER_MOB_NO']?></td>
									</tr>
									<tr>
										<th sope="row">전화번호</th>
										<td><?=$order['RECEIVER_PHONE_NO']?></td>
									</tr>
									<tr>
										<th sope="row">배송시요청사항</th>
										<td><?=$order['DELIV_MSG']?></td>
									</tr>

									<!--<tr>
										<th sope="row">주문하시는분</th>
										<td>백아경</td>
									</tr>
									<tr>
										<th sope="row">받으시는분</th>
										<td>신일오</td>
									</tr>
									<tr>
										<th sope="row">배송지주소</th>
										<td>(480-742) 경기도 의정부시 용현동 신도브레뉴아파트 102동 1403호</td>
									</tr>
									<tr>
										<th sope="row">휴대폰번호</th>
										<td>010-0000-0000</td>
									</tr>
									<tr>
										<th sope="row">전화번호</th>
										<td>010-0000-0000</td>
									</tr>
									<tr>
										<th sope="row">배송시요청사항</th>
										<td>부재시 경비실에 맡겨주세요.</td>
									</tr>-->
								</tbody>
							</table>
						</div>

						<?if($order['PARENT_CATEGORY_MNG_CD'] == '10000000' || $order['CATEGORY_MNG_CD'] == '18010000'){?>
						<h3 class="title_page title_page__mypage">가구 배송정보</h3>
						<div class="mypage_section">
							<table class="normal_table normal_table__bg">
								<caption class="hide">가구 배송정보 입력표</caption>
								<colgroup>
									<col style="width:180px">
									<col>
								</colgroup>
								<tbody>
									<tr>
										<th sope="row">주거층수</th>
										<td>
										<?
										switch($order['LIVING_FLOOR_CD']){
											case 'LOW' : echo "1~2층"; break;
											case 'HIGH': echo "3층 이상"; break;
										}
										?>
										</td>
									</tr>
									<tr>
										<th sope="row">계단폭</th>
										<td>
										<?
										switch($order['STEP_WIDTH_CD']){
											case 'LOW' : echo "2m 미만"; break;
											case 'HIGH': echo "2m 이상"; break;
										}
										?>
										</td>
									</tr>
									<tr>
										<th sope="row">엘리베이터</th>
										<td>
										<?
										switch($order['ELEVATOR_CD']){
											case 'SEVEN'	: echo "1~7인승"; break;
											case 'TEN'		: echo "8~10인승"; break;
											case 'ELEVEN'	: echo "11인승 이상"; break;
											case 'NONE'		: echo "없음"; break;
											case 'NOUSE'	: echo "사용불가"; break;
										}
										?>
										</td>
									</tr>
									<tr>
										<th sope="row">제품 설치공간</th>
										<td>예. 제품 설치할 공간을 확보하였습니다.</td>
									</tr>
									<tr>
										<th sope="row">사다리차 필요</th>
										<td>예. 사다리차가 필요한 경우 사다리차 사용에 동의합니다.</td>
									</tr>
									<tr>
										<th sope="row">사다리차 이용 부담</th>
										<td>예. 사다리차 이용 부담금에 동의합니다.</td>
									</tr>
									<!--<tr>
										<th sope="row">주문하시는분</th>
										<td>백아경</td>
									</tr>
									<tr>
										<th sope="row">받으시는분</th>
										<td>신일오</td>
									</tr>
									<tr>
										<th sope="row">배송지주소</th>
										<td>(480-742) 경기도 의정부시 용현동 신도브레뉴아파트 102동 1403호</td>
									</tr>
									<tr>
										<th sope="row">휴대폰번호</th>
										<td>010-0000-0000</td>
									</tr>
									<tr>
										<th sope="row">전화번호</th>
										<td>010-0000-0000</td>
									</tr>
									<tr>
										<th sope="row">배송시요청사항</th>
										<td>부재시 경비실에 맡겨주세요.</td>
									</tr>-->
								</tbody>
							</table>
						</div>
						<?}?>

                        <?if(isset($order['RETURN_BANK_NM'])){?>
                        <h3 class="title_page title_page__mypage">환불계좌정보</h3>
                        <div class="mypage_section">
                            <table class="normal_table normal_table__bg">
                                <caption class="hide">환불계좌정보 입력표</caption>
                                <colgroup>
                                    <col style="width:180px">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th sope="row">환불은행명</th>
                                    <td><?=$order['RETURN_BANK_NM']?></td>
                                </tr>
                                <tr>
                                    <th sope="row">환불계좌번호</th>
                                    <td><?=$order['RETURN_ACCOUNT_NO']?></td>
                                </tr>
                                <tr>
                                    <th sope="row">환불예금주명</th>
                                    <td><?=$order['RETURN_CUST_NM']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?}?>

						<ul class="btn_list">
							<li><button type="button" class="btn_positive btn_positive__min" onClick="javaScript:history.back();">목록으로</button></li>
						</ul>

					</div>
				</div>
			</div>

			<div id="cancel_return_format"></div>

			<div id="print"></div>

			<script  language="javaScript">

			//====================================
			// 인쇄
			//====================================
			function content_print()
			{
                var initBody = document.body.innerHTML;
                window.onbeforeprint = function(){
                    document.body.innerHTML = document.getElementById('print').innerHTML;
                }
                window.onafterprint = function(){
                    document.body.innerHTML = initBody;
                }
                window.print();
            }

			//====================================
			// 취소신청 열기
			//====================================
			function cancelApplyOpen(order_refer_no){

				$.ajax({
					type: 'POST',
					url: '/mywiz/cancel_apply_format',
					dataType: 'json',
					data: { order_refer_no : order_refer_no	},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.cancel_apply);
							$("#cancel_return_format").html(res.cancel_apply);
						}
						else alert(res.message);
					}
				});

				$("#layer_cancel_apply").attr('class','layer layer_cancel_apply layer__view');

				var ele = $('#layer_cancel_apply').find('.layer_inner'),
					top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
					left = - (ele.width() / 2);
				if ( top < $(window).scrollTop() ) {
					top = $(window).scrollTop();
				}

				ele.css( {
					'top' : top,
					'margin-left' : left
				} );


			}

			//====================================
			// 반품신청 열기
			//====================================
			function returnApplyOpen(order_refer_no){

				$.ajax({
					type: 'POST',
					url: '/mywiz/return_apply_format',
					dataType: 'json',
					data: { order_refer_no : order_refer_no	},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.cancel_apply);
							$("#cancel_return_format").html(res.cancel_apply);
						}
						else alert(res.message);
					}
				});

				$("#layer_cancel_apply").attr('class','layer layer_cancel_apply layer__view');

				var ele = $('#layer_cancel_apply').find('.layer_inner'),
					top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
					left = - (ele.width() / 2);
				if ( top < $(window).scrollTop() ) {
					top = $(window).scrollTop();
				}

				ele.css( {
					'top' : top,
					'margin-left' : left
				} );


			}

			//=====================================
			// 증빙인쇄
			//=====================================
			function printReceipt(order_no){
				data = '';
				$.ajax({
					type: 'POST',
					url: '/mywiz/print_receipt',
					dataType: 'json',
					data: {order_no:order_no},
					error: function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
							$("#print").html(res.receipt);
//							alert("반품신청이 완료되었습니다.");
//							location.reload();
						}
						else alert(res.message);
					}
				});

				$("#layer_documentary_evidence_02").attr('class','layer layer_documentary_evidence_02 layer__view');

				var ele = $('#layer_documentary_evidence_02').find('.layer_inner'),
					top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
					left = - (ele.width() / 2);
				if ( top < $(window).scrollTop() ) {
					top = $(window).scrollTop();
				}

				ele.css( {
					'top' : top,
					'margin-left' : left
				} );
			}
			</script>


