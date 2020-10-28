					<?
					$date_today = date("Y-m-d", time());
					$date_w1 = date("Y-m-d", strtotime("-1 week"));
					$date_m1 = date("Y-m-d", strtotime("-1 month"));
					$date_m2 = date("Y-m-d", strtotime("-3 month"));
					$date_m3 = date("Y-m-d", strtotime("-6 month"));
					?>

					<div class="mypage_cont">
						<h3 class="title_page title_page__line title_page__mypage"><?=$title?></h3>
						<?if($this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
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
						<?}?>


						<div class="board_list board_list__prd_info">
							<table class="board_list_table">
								<caption>최근주문정보 리스트</caption>
								<colgroup>
									<col style="width:173px;" />
									<col style="width:134px;" />
									<col />
									<col style="width:71px;" />
									<col style="width:129px;" />
									<col style="width:97px;" />
									<col style="width:125px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">주문번호</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col" class="title_prd_info" <?=($nav=='OP')?"colspan='2'":""?>>상품정보</th>
										<th scope="col">수량</th>
										<?if($nav != 'OP'){?>
											<th scope="col">상품금액</th>
											<th scope="col">배송비</th>
										<?}else{?>
										<th scope="col">결제금액</th>
										<?}?>
										<th scope="col">주문상태</th>
									</tr>
								</thead>
								<tbody>
								<?if($order){
									$order_no = "";
									$deliv_no = "";
									$idx = 0;
									foreach($order as $row){?>
									<tr>
										<?if($order_no != $row['ORDER_NO']){?>
										<td class="order_number" rowspan="<?=$cnt_order_refer[$row['ORDER_NO']]?>">
											<a href="/mywiz/order_detail/<?=$row['ORDER_NO']?>" class="link"><?=$row['ORDER_NO']?><br/>(<?=$row['REG_DT']?>)</a>
											<button type="button" class="btn_white btn_white__small" onClick="javaScript:location.href='/mywiz/order_detail/<?=$row['ORDER_NO']?>'">상세보기</button>
										</td>
										<?}?>
										<td class="image">
											<a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" width="100"  height="100" alt="" /></a>
										</td>
										<td class="goods_detail__string" <?=($nav=='OP')?"colspan='2'":""?>>
											<p class="name"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><?=$row['GOODS_NM']?></a></p>
											<p class="description"><?=$row['PROMOTION_PHRASE']?></p>
											<p class="option"><?=$row['GOODS_OPTION_NM']?></p>
										</td>
										<td><?=$row['ORD_QTY']?></td>
										<?
										if($nav == 'OP'){
											if($order_no != $row['ORDER_NO']){?>
										<td class="order_status" rowspan="<?=$cnt_order_refer[$row['ORDER_NO']]?>">
											<span class="string"><?=number_format($row['REAL_PAY_AMT'])?>원</span>
											<?	if($row['ORDER_PAY_KIND_CD'] == '01'){?>
												<button type="button" class="btn_white btn_white__small" onClick="javaScript:printCardStatement(<?=$row['ORDER_NO']?>);">카드결제</button><br/>
												<button type="button" class="btn_white btn_white__small" onClick="javaScript:printReceipt(<?=$row['ORDER_NO']?>);">영수증</button>
												<?}else if($row['ORDER_PAY_KIND_CD'] == '02'){?>
												<button type="button" class="btn_white btn_white__small" onClick="javaScript:printCashReceipt(<?=$row['ORDER_NO']?>);">현금결제</button><br/>
												<button type="button" class="btn_white btn_white__small" onClick="javaScript:printReceipt(<?=$row['ORDER_NO']?>);">영수증</button>
												<?}
											}?>
										</td>
										<?}?>
									<?if($nav != 'OP'){?>
										<td class="order_status">
											<span class="string"><?=number_format($row['SELLING_PRICE'])?>원</span>
										<?if(($row['DELIV_POLICY_NO'] != $deliv_no) || ($row['ORDER_NO'] != $order_no) ){?>
										<td rowspan="<?=$cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']]?>">
                                            <?if($row['ORDER_DELIV_COST'] >= 0 && $row['PATTERN_TYPE_CD'] != 'NONE'){?>
											<?=$row['ORDER_DELIV_COST'] > 0 ? number_format($row['ORDER_DELIV_COST'])."원" : "무료배송" ?>
                                            <?}else{?>
                                            착불
                                            <?}?>
										</td>
									<?	}
									}?>
										<td class="order_status">
											<span class="string"><?=$row['ORDER_REFER_PROC_STS_CD_NM']?></span>
											<?if($nav != 'OP'){?>
                                                <?if($row['CANCEL_YN']=='Y' && !in_array($row['ORDER_PAY_KIND_CD'], array('09','10'))){?>
                                                    <button type="button" class="btn_white btn_white__small" onClick="javaScript:cancelApplyOpen(<?=$row['ORDER_REFER_NO']?>);">취소신청</button>
                                                <?}?>
                                                <?if($row['DELIVE_YN']=='Y'){
                                                    if($row['SEND_NATION'] == 'KR'){	//국내배송일경우?>
                                                        <button type="button" class="btn_white btn_white__small" onClick="javaScript:deliveryCheck('<?=$row['INVOICE_NO']?>','<?=$row['DELIV_COMPANY_CD']?>');">배송조회</button><br/>
                                                    <? } else {	// 해외배송일경우?>
                                                        <button type="button" class="btn_white btn_white__small" onClick="javaScript:deliveryCheck('<?=$row['INVOICE_NO']?>','GLOBAL');">배송조회</button><br/>
                                                    <? } ?>
                                                <?}?>
                                                <?if($row['RETURN_YN']=='Y' && !in_array($row['ORDER_PAY_KIND_CD'], array('09','10'))){?>
                                                    <button type="button" class="btn_white btn_white__small" onClick="javaScript:returnApplyOpen(<?=$row['ORDER_REFER_NO']?>);">반품신청</button>
                                                    <?if($row['COMMENT_YN']=='Y' && $orow['MEMBER_YN']=='Y'){?>
                                                        <button type="button" class="btn_white btn_white__small position_right" onClick="javaScript:jsGoodsComment(<?=$row['GOODS_CD']?>);">상품평쓰기</button>
                                                    <?}?>
                                                <?}?>
											<?}?>
										</td>
									</tr>
								<?	$order_no = $row['ORDER_NO'];
									$deliv_no = $row['DELIV_POLICY_NO'];
									}
								}else{?>
									<tr>
										<td colspan="<?=$nav == 'OP' ? "6" : "7"?>">주문 내역이 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td class="order_number">
											<a href="#" class="link">2016-01-26-327668</a>
										</td>
										<td class="image">
											<img src="/assets/images/data/data_100x100_02.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>2,000</td>
										<td>353,500</td>
										<td class="order_status">
											<span class="string">배송중</span>
											<button type="button" class="btn_white btn_white__small">배송추적</button>
										</td>
									</tr>
									<tr>
										<td class="order_number">
											<a href="#" class="link">2016-01-26-327668</a>
										</td>
										<td class="image">
											<img src="/assets/images/data/data_100x100_03.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>무료배송</td>
										<td>353,500</td>
										<td class="order_status">
											<span class="string">배송완료</span>
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
						<br />
						<ul class="bullet_list">
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>주문 상품의 <span class="bullet_underline">교환을 원하시는 고객님께서는 상품 수령 후 7일 이내에 <strong>고객센터 페이지에서 좌측 메뉴에 1:1문의&gt;문의하기에 접수/신청</strong></span>하여 주시면 교환 방법에 대해 자세히 안내 드리겠습니다.<br>내용은 고객센터&gt;자주 찾는 질문 참조해주시면 고맙겠습니다.</li>

						</ul>
				<!--		<br/><p>※ 주문 상품의 교환을 원하시는 고객님께서는 상품 수령 후 7일 이내에 고객센터 페이지에서 좌측 메뉴에 1:1문의 > 문의하기에 접수/신청하여 주시면 교환 방법에 대해 자세히 안내 드리겠습니다. 관련 내용은 고객센터 > 자주 찾는 질문 참조해주시면 고맙겠습니다.</p>	-->
					</div>
				</div>
			</div>

			<div id="print"></div>

			<!-- 현금영수증 신청 레이어 // -->
			<div class="layer layer_documentary_evidence_05" id="layer_documentary_evidence_05">
				<div class="layer_inner">
					<h1 class="layer_title layer_title__line">현금영수증&#47;세금계산서 안내</h1>
					<div class="layer_cont">
						<ul class="process_progress">
							<li class="process_progress_item">
								<span class="spr-common spr_bg_process_active">01. 신청</span>
								<span class="spr-common spr_bg_arrow"></span>
							</li>
							<li class="process_progress_item">
								<span class="spr-common spr_bg_process">02. 처리중</span>
								<span class="spr-common spr_bg_arrow"></span>
							</li>
							<li class="process_progress_item">
								<span class="spr-common spr_bg_process">03. 발급완료</span>
							</li>
						</ul>

						<ul class="document_evidence_info">
							<li class="document_evidence_info_item">
								<em class="point">현금영수증 :</em> 현금결제 및 실시간 계좌이체, 모바일 안심결제로 구매시 해외배송비 금액을 제외한 구매금액으로<br /> 현금영수증이 자동 발급됩니다.
								<ul class="bullet_list">
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>세금계산서 신청을 원하시면 현금영수증(지출증빙용)으로 신청하여 주시기 바랍니다.</li>
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>입금완료전까지 현금영수증 신청정보를 병경하실 수 있습니다.</li>
								</ul>
							</li>
							<li class="document_evidence_info_item">
								<em class="point">세금계산서 :</em> 세금계산서를 발급하지 않습니다.
								<ul class="bullet_list">
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>세금계산서 신청을 원하시면 현금영수증(지출증빙용)으로 신청하여 주시기 바랍니다.</li>
									<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>현금영수증(지출증빙용)은 세금계산서 대용으로 매입세엑공제를 받을 수 있습니다.</li>
								</ul>
							</li>
							<li class="document_evidence_info_item">
								<em class="point">신용카드 매출전표 :</em> 신용카드 구매시에는 카드매출전표가 자동발급됩니다.<br /> 부가세법 시행령 제 57조 2항에 의거하여, 신용카드 전표는 세금계산서 대용으로 매입세액공제를 받을 수 있습니다.
							</li>
							<li class="document_evidence_info_item">
								<em class="point">전세계배송비 계산서 :</em> 해외배송비에 대한 카드매출전표는 자동으로 발급됩니다.현금영수증이 필요하신 경우에는<br /> 주문완료 후 “나의쇼핑정보 > 주문내역 > 전세계배송건 주문상세” 화면에서 신청하실 수 있습니다.
							</li>
						</ul>

						<h2 class="layer_title_sub">현금영수증 VS 신용카드매출전표</h2>

						<div class="table_basic_type">
							<table>
								<caption>신용카드매출전표</caption>
								<colgroup>
									<col style="width:227px;" />
									<col style="width:227px;" />
									<col />
								</colgroup>
								<thead>
									<tr>
										<th>구분</th>
										<th>현금영수증</th>
										<th>신용카드매출전표</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>신청가능조건</td>
										<td>Smile cash (현금성), 계좌이체,<br />모바일안심결제 등 현금결제시</td>
										<td>신용카드 결제시</td>
									</tr>
									<tr>
										<td>신청기한</td>
										<td>자동신청, 신청정보변경은<br />입금완료전까지 가능</td>
										<td>자동신청, 주문완료 후 정보변경 불가</td>
									</tr>
									<tr>
										<td>발급대상금액</td>
										<td>결제금액에서 해외배송비를<br />차감한 금액</td>
										<td>결제금액에서 해외배송비를<br />차감한 금액</td>
									</tr>
									<tr>
										<td>계산서/영수증상 발급일</td>
										<td>입금완료일, 환불일</td>
										<td>카드승인일, 카드승인 취소일</td>
									</tr>
									<tr>
										<td>발급가능시점</td>
										<td>입금완료 후 2일 이내</td>
										<td>카드승인 후 2일 이내</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<a href="#layer_documentary_evidence_05" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>
			</div>
			<!-- // 현금영수증 신청 레이어 -->

			<script type="text/javaScript">

			//====================================
			// 조회
			//====================================
			function jsSearch()
			{
				var date_from	= $('#date_from').val(),
					date_to		= $('#date_to').val(),
					date_type	= $('#date_type').val(),
					nav			= "<?=$nav?>",
					title		= "<?=$title?>",
					page		= 1;

				var param = "";
				param += "page="			+ page;
				param += "&nav="			+ nav;
				param += "&title="			+ title;
				param += "&date_from="		+ date_from;
				param += "&date_to="		+ date_to;
				param += "&date_type="		+ date_type;

				document.location.href = "/mywiz/order_page/"+page+"?"+param;
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
							$("#print").html(res.cancel_apply);
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
							$("#print").html(res.cancel_apply);
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

			//=====================================
			// 카드매출전표
			//=====================================
			function printCardStatement(order_no){
				data = '';
				$.ajax({
					type: 'POST',
					url: '/mywiz/print_card_statement',
					dataType: 'json',
					data: {order_no:order_no},
					error: function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
//							$("#print").html(res.card_statement);
							window.open(res.order['RECEIPT_URL'],"PRINT_CARD_STATEMENT","width=500, height=1000, menubar=no, status=no, resizable=yes, scrollbars=no");
//							alert(res.order['RECEIPT_URL']);
//							alert("반품신청이 완료되었습니다.");
//							location.reload();
						}
						else alert(res.message);
					}
				});

				$("#layer_documentary_evidence_03").attr('class','layer layer_documentary_evidence_03 layer__view');

				var ele = $('#layer_documentary_evidence_03').find('.layer_inner'),
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
			// 현금영수증
			//=====================================
			function printCashReceipt(order_no){
				data = '';
				$.ajax({
					type: 'POST',
					url: '/mywiz/print_cash_receipt',
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