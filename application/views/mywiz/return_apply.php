            <link rel="stylesheet" href="/assets/css/mypage.css?ver=1.1">

            <!-- 반품신청 레이어 // -->
			<div class="layer layer_cancel_apply" id="layer_cancel_apply">
				<div class="layer_inner">
					<h1 class="layer_title layer_title__line">반품신청</h1>
					<div class="layer_cont">
						<ul class="bullet_list">
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>신용카드는 승인취소의 방법으로 환불처리가 되고, 체크카드는 승인취소 후 해당 카드 계좌로 입금 됩니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>환불은 최종 반품승인 결정 이후 약 3~5일(주말/공휴일 제외) 소요될 수 있습니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>구매건 중 일부 상품이 반품되는 경우, 카드사에 따라 부분취소 또는 재결제의 방식으로 대금 환급이 진행될 수 있습니다.</li>
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
											옵션명 : <?=$order['GOODS_OPTION_NM']?>
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
											<div class="quantity_select">
												<input type="text" readonly class="quantity_input" value="1" name="qty"/>
												<button type="button" class="quantity_minus_btn" onClick="javaScript:clickQty('M');">
												<span class="text">minus</span>
												<span class="spr-cart btn-minus"></span>
												</button>

												<button type="button" class="quantity_plus_btn" onClick="javaScript:clickQty('P');">
												<span class="text">plus</span>
												<span class="spr-cart btn-plus"></span>
												</button>
											</div>
										</td>
										<td>
										<?
										$str_delivery = "";
										$deli_cost = "";
										switch($order['PATTERN_TYPE_CD']){
											case 'PRICE' :	if($order['DELI_LIMIT']>$order['SELLING_PRICE']){
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
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<h2 class="layer_title_sub">반품방법</h2>
						<table class="normal_table normal_table__bg">
							<caption class="hide">반품 발송여부</caption>
							<colgroup>
								<col style="width:155px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row"><label for="formContact">반품 발송여부</label></th>
									<td>
									<div class="radio_area">
										<input type="radio" name="return_delivery_yn" class="radio" id="formGender01" value="01"/> <label for="formGender01" class="radio_label" onClick="javaScript: $('#deli_a').css('display', ''); $('#deli_c').css('display', ''); $('#deli_b').css('display', 'none');">발송</label>
										<input type="radio" name="return_delivery_yn" class="radio" id="formGender02" value="03"/> <label for="formGender02" class="radio_label" onClick="javaScript: $('#deli_b').css('display', ''); $('#deli_a').css('display', 'none'); $('#deli_c').css('display', 'none');">미발송</label>
									</div>
									</td>
								</tr>
								<tr id='deli_a' style="display:none;">
									<th sope="row"><label for="formContact">반품 발송정보</label></th>
									<td>
										<div class="select_wrap" style="width:150px;">
										<label for="formCancelSelect">발송방법</label>
										<select name="deli_com" style="width:150px;" >
											<option value="" selected>택배사 선택</option>
											<?foreach($deli_list as $row){?>
											<option value="<?=$row['DELIV_COMPANY_CD']?>"><?=$row['CD_NM']?></option>
											<?}?>
										</select>
										</div>
										<input type="text" class="input_text" id="formContact" value="" style="width: 190px;" placeholder="송장번호를 입력해주세요." name="invoice_no" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
									</td>
								</tr>
								<tr id='deli_c' style="display:none;">
									<th sope="row"><label for="formContact">반품 발송일</label></th>
									<td>
										<input type="text" class="input_text" id="formContact" value="" style="width: 190px;" placeholder="예) 2016-05-31" name="invoice_date" onkeyup="this.value=this.value.replace(/[^-0-9]/g,'')"/>
									</td>
								</tr>
								<tr id='deli_b' style="display:none;">
									<th sope="row"><label for="formContact">반품 발송정보</label></th>
									<td>지정반품택배 : 	<?=$order['DELIVERY_NAME']?><input type="hidden" name="deli_com2" value="<?=$order['DELIVERY_CODE']?>"></td>
								</tr>
								<tr>
									<th sope="row"><label for="formContact">반품 배송비</label></th>
									<td>
										<input type="hidden" name="deli_cost" value="<?=$order['RETURN_DELIV_COST']?>">
										<input type="hidden" name="first_deli_cost" value="<?=$order['ORDER_REFER_DELI_COST'] == '0' ? $order['DELI_COST'] : 0?>">
										<?=number_format($order['RETURN_DELIV_COST'])?>원
									</td>
								</tr>
								<tr>
									<th sope="row"><label for="formContact">반품 배송비결제</label></th>
									<td>
									<div class="select_wrap" style="width:475px;">
										<label for="formCancelSelect">반품배송비</label>
										<select id="formCancelSelect" style="width:475px;" name="deli_cost_type" onChange="javaScript:changeDeliCost(this.value);">
											<option value="" selected>반품 배송비결제방식 선택</option>
											<?foreach($return_pay_type as $row){?>
											<option value="<?=$row['RETURN_DELIVFEE_PAY_WAY_CD']?>"><?=$row['RETURN_DELIVFEE_PAY_WAY_CD_NM']?></option>
											<?}?>
										</select>
									</div>
									</td>
								</tr>
						</table>

						<h2 class="layer_title_sub">환불금액</h2>
						<table class="normal_table normal_table__bg">
							<caption class="hide">환불금액 </caption>
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
										<li class="bullet_item">
											<span class="spr-common spr_bg_dot02"></span><span id="str_goods_pri">상품금액 : <?=number_format($order['SELLING_PRICE'])?>원
										</li>
										<li class="bullet_item">
											<span class="spr-common spr_bg_dot02"></span><span id="str_deli_cost">배송비&nbsp;&nbsp;&nbsp;	: 원</span>
											<input type="hidden" id="t_deli_cost">
										</li>
										<li class="bullet_item">
											<span class="spr-common spr_bg_dot02"></span>할인금액 : -<?=number_format($order['DC_AMT'])?>원
										</li>
									</ul>
									<br/>
									</td>
								</tr>
								<tr>
									<td id="str_total_price">
										환불예상금액 : 원						
									</td>
								</tr>
							</tbody>
						</table>

						<h2 class="layer_title_sub">반품사유</h2>
						<table class="normal_table normal_table__bg">
							<caption class="hide">반품사유 선택</caption>
							<colgroup>
								<col style="width:155px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row"><label for="formContact">반품사유</label></th>
									<td>
										<div class="select_wrap" style="width:475px;">
										<label for="formCancelSelect">반품사유</label>
										<select id="formCancelSelect" style="width:475px;" name="reason" onChange="javaScript:changeReturnReason(this.value);">
											<option value="" selected>반품사유 선택</option>
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
						<textarea resize="none" class="input_text detail_cancel_text" style="width: 638px;" placeholder="상세사유를 입력해주세요." name="reason_detail"></textarea>

                        <form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
                            <h2 class="layer_title_sub">파일첨부</h2>
                            <div class="file_plus" id="tblFileUpload">
                                <dl class="prd_inquiry_layer_line" name="row[]">
                                    <dt class="title"><label for="file_url_0">이미지</label></dt>
                                    <dd class="data">
                                        <input type="text" id="file_url_0" name="file_url[]" placeholder="jpg, gif, png 파일만 업로드 가능합니다." class="input_text" style="width: 487px;" readonly>
                                        <a href="javaScript:jsDel(0);" class="spr-mypage spr-btn_delete" title="이미지삭제"></a>
                                        <label for="fileUpload_0" class="btn_white btn_search">찾아보기</label>
                                        <input type="file" id="fileUpload_0" name="fileUpload[]" class="file_upload_hidden" onChange="javaScript:viewFileUrl(this, 0);">
                                        <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/display/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                                    </dd>
                                </dl>
                            </div>
                        </form>

					</div>

					<ul class="btn_list">
						<li><button type="button" class="btn_positive" onClick="javaScript:return_apply('<?=$order['ORDER_REFER_NO']?>');">반품신청</button></li>
						<li><button type="button" class="btn_negative" onClick="javaScript:$('#layer_cancel_apply').attr('class','layer layer_cancel_apply');">신청취소</button></li>
					</ul>
					<a href="#layer_cancel_apply" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>
			</div>
			<!-- // 반품신청 레이어 -->

			<script type="text/javaScript">
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
                    "<dt class=\"title\"><label for=\"file_url_"+index+"\">이미지</label></dt> " +
                    "<dd class=\"data\">" +
                    "<input type=\"text\" id=\"file_url_"+index+"\" name=\"file_url[]\" placeholder=\"jpg, gif 파일, 파일사이즈 총합 2MB까지 업로드 가능합니다.\" class=\"input_text\" style=\"width: 487px;\" readonly> " +
                    "<a href=\"javaScript:jsDel("+index+");\" class=\"spr-mypage spr-btn_delete\" title=\"이미지삭제\"></a> " +
                    "<label for=\"fileUpload_"+index+"\" class=\"btn_white btn_search\">찾아보기</label> " +
                    "<input type=\"file\" id=\"fileUpload_"+index+"\" name=\"fileUpload[]\" class=\"file_upload_hidden\" onChange=\"javaScript:viewFileUrl(this, "+index+");\"> " +
                    "<button class=\"file_puls_btn\" onclick=\"return false;\"><img src=\"/assets/images/display/btn_plus.png\" alt=\"\" onclick=\"javaScript:jsAdd();\"></button> " +
                    "</dd>" +
                    "</dl>"
                )

            }

			//====================================
			// 반품신청
			//====================================
			function return_apply(val){
				var order_refer_no = val, 
					gb = 'RETURN',
					qty = $('input[name=qty]').val(),
					deli_com = $('select[name=deli_com]').val(),
					deli_com2 = $('input[name=deli_com2]').val(),
					invoice_no = $('input[name=invoice_no]').val(),
					invoice_date = $('input[name=invoice_date]').val(),
					first_deli_cost = $('input[name=first_deli_cost]').val(),
					deli_cost = $('input[name=deli_cost]').val(),
					deli_cost_type = $('select[name=deli_cost_type]').val(),
					deli_type = $(":input:radio[name=return_delivery_yn]:checked").val(),
					
					reason = $('select[name=reason]').val(),
					reason_detail = $('textarea[name=reason_detail]').val(),
					state_cd = 'OR01';

				if(!deli_type){
					alert("반품 발송여부를 선택해주세요.");
					return false;
				}
				if(deli_type == '01'){
					if(deli_com == ''){
						alert("발송하신 택배사를 선택해주세요.");
						$('select[name=deli_com]').focus();
						return false;
					}
					if(invoice_no == ''){
						alert("운송장 번호를 입력해주세요.");
						$('input[name=invoice_no]').focus();
						return false;
					}
					if(invoice_date == ''){
						alert("반품 발송일을 입력해주세요.");
						$('input[name=invoice_date]').focus();
						return false;
					}
				}else{
					deli_com = deli_com2;
				}
				if(deli_cost_type == ''){
					alert("반품 배송비 결제 방식을 선택해주세요.");
					$('select[name=deli_cost_type]').focus();
					return false;
				}
				if(reason == ''){
					alert("반품사유를 선택해주세요.");
					$('select[name=reason]').focus();
					return false;
				}
				if(reason_detail == ''){
					alert("상세사유를 입력해주세요.");
					$('textarea[name=reason_detail]').focus();
					return false;
				}
                if( (reason=='04') && ($('#file_url_0').val()=='') ){
                    alert('반품사유가 \'상품 파손/훼손\'의 경우 사진을 첨부해주세요.');
                    return false;
                }
				

				if(confirm("반품신청 하시겠습니까?")){
				
					$.ajax({
						type: 'POST',
						url: '/mywiz/return_apply',
						dataType: 'json',
						data: {	order_refer_no : order_refer_no,
								gb : gb,
								qty : qty,
								deli_com : deli_com,
								invoice_no : invoice_no,
								invoice_date : invoice_date,
								first_deli_cost : first_deli_cost,
								deli_cost : deli_cost,
								deli_cost_type : deli_cost_type,
								deli_type : deli_type,
								reason : reason,
								reason_detail : reason_detail,
								state_cd : state_cd },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
//									alert("반품신청이 완료되었습니다.");
//									location.reload();
                                reg_image(res.return_no);
							}
							else alert(res.message);
						}
					});
				}
			}

            function reg_image(return_no) {

                if($('#file_url_0').val()=='') {
                    alert("반품신청이 완료되었습니다.");
                    location.reload();
                }
                else{
                    var data = new FormData($('#updFile')[0]);

                    data.append('return_no', return_no);

                    $.ajax({
                        type: 'POST',
                        url: '/mywiz/return_apply_image',
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
                                alert("반품신청이 완료되었습니다.");
                                location.reload();
                            }
                            else alert("파일첨부에 실패하였습니다.");
                        }
                    });
                }
            }

			function changeDeliCost(val){
				var return_reason = $('select[name=reason]').val(),
					order_refer_deli_cost = <?=$order['ORDER_REFER_DELI_COST']?>,
					return_deliv_cost = <?=$order['RETURN_DELIV_COST']?>,
					o_deli_cost = <?=$order['DELI_COST']?>;

				
				if(return_reason == '02' || return_reason == '04'){
					$('input[name=first_deli_cost]').val(0);
					$('input[name=deli_cost]').val(0);
					$("#str_deli_cost").text("배송비　 : <?=$order['ORDER_REFER_DELI_COST'] == 0 ? '-0' : '+'.number_format($order['RETURN_DELIV_COST']) ;?>원");
					$("#t_deli_cost").val(order_refer_deli_cost == 0 ? 0 : order_refer_deli_cost );

					var goods_pri = "<?=$order['SELLING_PRICE']?>";
					var qty		  = $('input[name=qty]').val();
					var t_deli_cost = parseInt($("#t_deli_cost").val());
					var	dc_amt	  = <?=$order['DC_AMT']?>;

					var total_price = (goods_pri*qty)+t_deli_cost-dc_amt;
					$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");

				}else{

					$('input[name=first_deli_cost]').val(order_refer_deli_cost == '0' ? o_deli_cost : 0);
					$('input[name=deli_cost]').val(return_deliv_cost);

					var	deli_cost = $('input[name=deli_cost]').val();

					if(val == '02'){
						$("#str_deli_cost").text("배송비　 : <?=$order['ORDER_REFER_DELI_COST'] == 0 ? '-'.number_format($order['RETURN_DELIV_COST']+$order['DELI_COST']) : '-"+numberFormat(deli_cost)+"';?>원");
	//					$("#str_deli_cost").text("배송비　 : 123123123");
	//					$("#t_deli_cost").val(<?=$order['ORDER_REFER_DELI_COST'] == 0 ? ($order['RETURN_DELIV_COST']+$order['DELI_COST']) : 0 ?>);
						$("#t_deli_cost").val(order_refer_deli_cost == 0 ? ( return_deliv_cost + o_deli_cost) : deli_cost );
					}else{
						$("#str_deli_cost").text("배송비　 : -0원");
						$("#t_deli_cost").val(0);
					}
					var goods_pri = "<?=$order['SELLING_PRICE']?>";
					var qty		  = $('input[name=qty]').val();
					var t_deli_cost = parseInt($("#t_deli_cost").val());
					var	dc_amt	  = <?=$order['DC_AMT']?>;

					var total_price = (goods_pri*qty)-(t_deli_cost+dc_amt);
					$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
				}
				
			}

			//========================================
			//천단위 콤마
			//========================================
			function numberFormat(num) {
			   num = String(num);
			   return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,"$1,");
			}
			
			//========================================
			//수량
			//========================================
			function clickQty(gubun){
				if(gubun == 'M'){
					if($('input[name=qty]').val()>1) $('input[name=qty]').val($('input[name=qty]').val()-1);
				}else if(gubun == 'P'){
					if($('input[name=qty]').val()<<?=$order['ORD_QTY']?>) $('input[name=qty]').val(parseInt($('input[name=qty]').val())+1)
				}
				var goods_pri = <?=$order['SELLING_PRICE']?>*$('input[name=qty]').val();
				$("#str_goods_pri").text("상품금액 : "+numberFormat(goods_pri)+"원");

				var deli_cost = parseInt($("#t_deli_cost").val());
				var	dc_amt	  = <?=$order['DC_AMT']?>;

				var total_price = goods_pri-(deli_cost+dc_amt);
				$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
			}
			
			//========================================
			//반품사유
			//========================================
			function changeReturnReason(val){
				var order_refer_deli = <?=$order['ORDER_REFER_DELI_COST']?>;
				var return_deliv_cost = <?=$order['RETURN_DELIV_COST']?>;
				var o_deli_cost = <?=$order['DELI_COST']?>;
				var deli_cost_type = $('select[name=deli_cost_type]').val()
					

				if(val == '02' || val == '04'){
					$('input[name=first_deli_cost]').val(0);
					$('input[name=deli_cost]').val(0);
					$("#t_deli_cost").val(order_refer_deli);
					if(order_refer_deli == 0){//무료배송 일 때
						$("#str_deli_cost").text("배송비　 : -0원");
					}else{

						$("#str_deli_cost").text("배송비　 : +"+numberFormat(order_refer_deli)+"원");
					}

					var goods_pri = "<?=$order['SELLING_PRICE']?>";
					var qty		  = $('input[name=qty]').val();
					var t_deli_cost = parseInt($("#t_deli_cost").val());
					var	dc_amt	  = <?=$order['DC_AMT']?>;

					var total_price = (goods_pri*qty)+t_deli_cost-dc_amt;
					$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
				}else{
					$('input[name=first_deli_cost]').val(order_refer_deli == '0' ? o_deli_cost : 0);
					$('input[name=deli_cost]').val(return_deliv_cost);

					var	deli_cost = $('input[name=deli_cost]').val();


					if(deli_cost_type == '02'){
						$("#str_deli_cost").text("배송비　 : <?=$order['ORDER_REFER_DELI_COST'] == 0 ? '-'.number_format($order['RETURN_DELIV_COST']+$order['DELI_COST']) : '-"+numberFormat(deli_cost)+"';?>원");
						$("#t_deli_cost").val(order_refer_deli == 0 ? ( return_deliv_cost + o_deli_cost) : deli_cost );
					}else{
						$("#str_deli_cost").text("배송비　 : -0원");
						$("#t_deli_cost").val(0);
					}

					var goods_pri = "<?=$order['SELLING_PRICE']?>";
					var qty		  = $('input[name=qty]').val();
					var t_deli_cost = parseInt($("#t_deli_cost").val());
					var	dc_amt	  = <?=$order['DC_AMT']?>;
	
					var total_price = (goods_pri*qty)-(t_deli_cost+dc_amt);
					$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
				}


			}

			</script>