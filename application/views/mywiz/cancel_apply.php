			<!-- 취소신청 레이어 // -->
			<div class="layer layer_cancel_apply" id="layer_cancel_apply">
				<div class="layer_inner">
					<h1 class="layer_title layer_title__line">취소신청</h1>
					<div class="layer_cont">
						<ul class="bullet_list">
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>신용카드는 승인취소의 방법으로 환불처리가 되고, 체크카드는 승인취소 후 해당 카드 계좌로 입금이 될 것입니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>환불은 취소 승인 후 약 3~5일(주말/공휴일 제외) 소요될 수 있습니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>장바구니 구매건 중 일부 상품이 취소되는 경우, 카드사에 따라 부분취소 또는 재결제의 방식으로 대금 환급이 진행될 수 있습니다.</li>
						</ul>
						<!--<h2 class="layer_title_sub">정보입력</h2>
						<table class="normal_table normal_table__bg cancel_apply_input">
							<caption class="hide">정보입력</caption>
							<colgroup>
								<col style="width:155px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row">주문자명</th>
									<td><?=$order['SENDER_NM']?></td>
								</tr>
								<tr>
									<th sope="row">결제수단</th>
									<td><?=$order['ORDER_PAY_KIND_NM']?></td>
								</tr>
								<tr>
									<th sope="row"><label for="formContact">연락처</label></th>
									<td><input type="text" class="input_text" id="formContact" value="<?=$order['SENDER_MOB_NO']?>" style="width: 190px;" /></td>
								</tr>
							</tbody>
						</table>-->

						<h2 class="layer_title_sub">상품정보</h2>
						<div class="board_list cancel_prd_select">
							<table class="board_list_table" summary="장바구니에 담겨진 상품 리스트 입니다.">
								<caption>장바구니 상품 리스트</caption>
								<!--<colgroup>
									<col width="56px" />
									<col width="*" />
									<col width="154px" />
								</colgroup>-->
								<thead>
									<tr>
										<!--<th scope="col">
											<input type="checkbox" id="all_check" class="checkbox" />
											<label for="all_check" class="checkbox_label"><span class="hide">전체선택</span></label>
										</th>-->
										<th scope="col" colspan="3">상품정보</th>
										<th scope="col">상품금액</th>
										<th scope="col" >수량</th>
										<th scope="col">배송비</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<!--<td class="goods_select">
											<input type="checkbox" id="goods_select_0" class="checkbox" />
											<label for="goods_select_0" class="checkbox_label"><span class="hide">[Sofliving] 소프시스 사이드테이블 435</span></label>
										</td>-->
                                        <td>
                                            <img src="<?=$order['IMG_URL']?>" width="100"  height="100" alt="" />
                                        </td>
										<td class="prd_info" colspan="2">

											<?=$order['GOODS_NM']?><br/>
											<!--<?=$order['PROMOTION_PHRASE']?><br/>-->
											옵션명 : <?=$order['GOODS_OPTION_NM']?> <?=$order['SELLING_ADD_PRICE'] > 0 ? " (+".number_format($order['SELLING_ADD_PRICE']).")" : ""?>
										</td>

										<!--<td class="image">
											<img src="<?=$order['IMG_URL']?>" width="100"  height="100" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name"><?=$order['GOODS_NM']?></p>
											<p class="description"><?=$order['PROMOTION_PHRASE']?></p>
											<p class="option"><?=$order['GOODS_OPTION_NM']?></p>
										</td>-->
										<td><?=number_format($order['SELLING_PRICE'])?>원</td>
										<td class="quantity">
                                            <input type="hidden" readonly class="quantity_input" value="<?=$order['ORD_QTY']?>" name="qty"/>
                                            <?=$order['ORD_QTY']?>
										</td>
										<td>
										<?
										$str_delivery = "";
										$deli_cost = "";
										switch($order['PATTERN_TYPE_CD']){
											case 'PRICE' :	if($order['DELI_LIMIT']>(($order['SELLING_PRICE']+$order['SELLING_ADD_PRICE'])*$order['ORD_QTY'])){
																$str_delivery = number_format($order['DELI_COST'])."원";
																$deli_cost = $order['DELI_COST'];
															}else{
																$str_delivery = "무료배송";
																$deli_cost = "0";
															} break;
											case 'FREE'  :	$str_delivery = "무료배송"; 
															$deli_cost = "0";	break;
											case 'STATIC': 	$str_delivery = number_format($order['DELI_COST'])."원";
															$deli_cost = $order['DELI_COST']; break;
										}
										echo $str_delivery;
										?>
										<!--<?=$order['DELIV_COST_AMT'] > 0 ? number_format($order['DELIV_COST_AMT'])."원" : "무료배송"?>-->
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<h2 class="layer_title_sub">환불금액</h2>
						<table class="normal_table normal_table__bg">
							<caption class="hide">환불금액 정보</caption>
							<colgroup>
								<col style="width:155px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row" rowspan="2"><label for="formContact">환불예상금액</label></th>
									<td><!--<?=number_format($order['SELLING_PRICE']-$order['DC_AMT']+$deli_cost)." ( 상품금액:".number_format($order['SELLING_PRICE'])." + 배송비:".number_format($deli_cost)." + 할인금액:".number_format($order['DC_AMT'])." )"?>-->
									<br/>
									<ul class="bullet_list">
										<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>상품금액 : <?=number_format(($order['SELLING_PRICE']+$order['SELLING_ADD_PRICE'])*$order['ORD_QTY'])?>원</li>
										<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>배송비&nbsp;&nbsp;&nbsp;	: <?=number_format($deli_cost)?>원</li>
										<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>할인금액 : -<?=number_format($order['DC_AMT'])?>원</li>
									</ul>
									<br/>
									</td>
								</tr>
								<tr>
									<td>
										환불예상금액 : <?=number_format((($order['SELLING_PRICE']+$order['SELLING_ADD_PRICE'])*$order['ORD_QTY'])-($order['DC_AMT'])+$deli_cost)?>원
										<!--환불예상금액 : <?=number_format($order['TOTAL_PAY_SUM'])?>원-->
									</td>
								</tr>
							</tbody>
						</table>

						<h2 class="layer_title_sub">취소사유</h2>
						<table class="normal_table normal_table__bg">
							<caption class="hide">취소사유 선택</caption>
							<colgroup>
								<col style="width:155px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row"><label for="formContact">취소사유</label></th>
									<td>
										<div class="select_wrap" style="width:475px;">
											<label for="formCancelSelect">취소사유</label>
											<select id="formCancelSelect" style="width:475px;" name="reason">
											<option value="" selected>취소사유 선택</option>
											<?foreach($reason_list as $row){?>
											<option value="<?=$row['CANCEL_RETURN_REASON_CD']?>"><?=$row['CANCEL_RETURN_REASON_CD_NM']?></option>
											<?}?>
										</select>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

						<h2 class="layer_title_sub">상세사유</h2>
						<textarea resize="none" class="input_text detail_cancel_text" style="width: 638px;" name="reason_detail"></textarea>
					
					</div>

					<ul class="btn_list">
						<li><button type="button" class="btn_positive" onClick="javaScript:cancel_apply('<?=$order['ORDER_REFER_NO']?>');">취소신청</button></li>
						<li><button type="button" class="btn_negative" onClick="javaScript:$('#layer_cancel_apply').attr('class','layer layer_cancel_apply');">신청취소</button></li>
					</ul>
					<a href="#layer_cancel_apply" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>
			</div>
			<!-- // 취소신청 레이어 -->

			<script type="text/javaScript">

			//====================================
			// 취소신청
			//====================================
			function cancel_apply(val){
				var order_refer_no = val, 
					gb = 'CANCEL',
					qty = $('input[name=qty]').val(),
					reason = $('select[name=reason]').val(),
					reason_detail = $('textarea[name=reason_detail]').val(),
					state_cd = 'OC01';
				
				if(reason == ''){
					alert("취소사유를 입력해주세요.");
					$('select[name=reason]').focus();
					return false;
				}
				if(reason_detail == ''){
					alert("상세사유를 입력해주세요.");
					$('textarea[name=reason_detail]').focus();
					return false;
				}
				
				if(confirm("취소신청 하시겠습니까?")){
				
					$.ajax({
						type: 'POST',
						url: '/mywiz/cancel_apply',
						dataType: 'json',
						data: {	order_refer_no : order_refer_no,
								gb : gb,
								qty : qty,
								reason : reason,
								reason_detail : reason_detail,
								state_cd : state_cd },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
									alert("취소되었습니다.");
									location.reload();
							}
							else alert(res.message);
						}
					});
				}
			}

			</script>