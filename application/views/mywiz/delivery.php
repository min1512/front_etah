					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">배송지관리</h3>

						<div class="btn_area position_area">
							<!--<button type="button" class="btn_white btn_white__small">선택삭제</button>-->
							<button type="button" class="btn_white btn_white__small" onClick="javaScript:baseDelivery();">기본배송지 설정</button>
							<button type="button" class="btn_black btn_black__small position_right" data-ui="layer-opener" data-target="#layer_address_regist">새 배송지 등록</button>
						</div>
						<div class="board_list board_list_address_admin">
							<table class="board_list_table" summary="배송지관리 리스트입니다.">
								<caption>배송지관리</caption>
								<colgroup>
									<col width="72px" />
									<col width="90px" />
									<col width="144px" />
									<col width="*" />
									<col width="134px" />
									<col width="126px" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">
											<!--<input type="checkbox" id="all_check" class="checkbox" onClick="javascript:jsChkAll(this.checked);" />
											<label for="all_check" class="checkbox_label"><span class="hide">전체선택</span></label>-->
										</th>
										<th scope="col">
											<span class="th_text">배송지명</span>
										</th>
										<th scope="col">
											<span class="th_text">받는사람</span>
										</th>
										<th scope="col">
											<span class="th_text">주소</span>
										</th>
										<th scope="col">
											<span class="th_text">휴대전화</span>
										</th>
										<th scope="col">
											<span class="th_text">관리</span>
										</th>
									</tr>
								</thead>
								<tbody>
								<?
								$i=0;
								if($delivery){
									foreach($delivery as $row){?>
									<tr>
										<td class="goods_select">
											<input type="checkbox" id="goods_select_<?=$i?>" class="checkbox" name="chkDeliv[]" onClick="javascript:checkbox('<?=$i?>');" value="<?=$row['CUST_DELIV_ADDR_NO']?>"/>
											<label for="goods_select_<?=$i?>" class="checkbox_label"><span class="hide">선택</span></label>
										</td>
										<td><?=$row['BASE_DELIV_ADDR_YN'] == 'N' ? $row['CUST_DELIV_ADDR_NM'] : $row['CUST_DELIV_ADDR_NM']." (기본)"?></td>
										<td><?=$row['RECV_NM']?></td>
										<td class="comment">
											[<?=$row['ZIPCODE']?>]<br /> <?=$row['ADDR1']." ".$row['ADDR2']?>
										</td>
										<td><?=$row['MOB_NO']?></td>
										<td class="admin">
											<p>
												<button type="button" class="btn_white btn_white__small btn_delete" data-ui="layer-opener" data-target="#layer_address_modify_<?=$i?>">수정</button>
											</p>
											<?if($row['BASE_DELIV_ADDR_YN'] == 'N'){?><button type="button" class="btn_white btn_white__small btn_delete" onClick="javaScript:deleteDelivery('<?=$row['CUST_DELIV_ADDR_NO']?>');">삭제</button><?}?>
										</td>
									</tr>
									<?
									$i++;
									}
								}else{?>
									<tr>
										<td colspan="6">등록된 배송지가 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td class="goods_select">
											<input type="checkbox" id="goods_select_1" class="checkbox" />
											<label for="goods_select_1" class="checkbox_label"><span class="hide">회사 선택</span></label>
										</td>
										<td>회사</td>
										<td>신일오</td>
										<td class="comment">
											480742<br /> [도로명주소] 경기도 의정부시 용현동 신도브레뉴 102동 1425호<br /> [지번주소] 경기도 의정부시 용현동 132번지
										</td>
										<td>010-5879-2458</td>
										<td class="admin">
											<p>
												<button type="button" class="btn_white btn_white__small btn_delete" data-ui="layer-opener" data-target="#layer_address_modify">수정</button>
											</p>
											<button type="button" class="btn_white btn_white__small btn_delete">삭제</button>
										</td>
									</tr>
									<tr>
										<td class="goods_select">
											<input type="checkbox" id="goods_select_2" class="checkbox" />
											<label for="goods_select_2" class="checkbox_label"><span class="hide">집 선택</span></label>
										</td>
										<td>집</td>
										<td>신일오</td>
										<td class="comment">
											480742<br /> [도로명주소] 경기도 의정부시 용현동 신도브레뉴 102동 1425호<br /> [지번주소] 경기도 의정부시 용현동 132번지
										</td>
										<td>010-5879-2458</td>
										<td class="admin">
											<p>
												<button type="button" class="btn_white btn_white__small btn_delete" data-ui="layer-opener" data-target="#layer_address_modify">수정</button>
											</p>
											<button type="button" class="btn_white btn_white__small btn_delete">삭제</button>
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
			


			<!-- 배송지등록 레이어 // -->
			<div class="layer layer_address" id="layer_address_regist">
				<div class="layer_inner">
					<h1 class="layer_title layer_title__line">배송지등록</h1>
					<div class="layer_cont">
						<table class="line_none_table">
							<caption class="hide">배송지등록</caption>
							<colgroup>
								<col style="width:106px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row"><label for="formAddress0101">배송지명</label></th>
									<td><input type="text" class="input_text" id="formAddress0101" style="width: 260px;" /></td>
								</tr>
								<tr>
									<th sope="row"><label for="formAddress0201">받는사람</label></th>
									<td><input type="text" class="input_text" id="formAddress0201" style="width: 260px;" /></td>
								</tr>
								<tr>
									<th sope="row"><label for="formAddress0301">휴대전화</label></th>
									<td>
										<div class="select_wrap" style="width:97px;">
											<select id="formAddress0301" style="width:97px;">
											<option>010</option>
											<option>011</option>
											<option>016</option>
											<option>017</option>
											<option>019</option>
										</select>
										</div>
										<span class="dash">- </span>
										<label><input type="text" class="input_text" style="width: 100px;" id="formAddress0301-2" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/></label>
										<span class="dash">- </span>
										<label><input type="text" class="input_text" style="width: 100px;" id="formAddress0301-3" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/></label>
									</td>
								</tr>
								<tr>
									<th sope="row"><label for="formAddress0401">주소</label></th>
									<td>
										<div class="td_composition_item">
											<input type="text" id="formAddress0401" class="input_text" value="" style="width: 152px;" disabled >
											<!--<button type="button" class="btn_white" onClick="javaScript:searchAddressOpen('R');">우편번호검색</button>-->
											<button type="button" class="btn_white" onclick="execDaumPostcode('formAddress0401','','address1','','address2');">우편번호검색</button>
										</div>
										<div class="td_composition_item">
											<label><input type="text" class="input_text" style="width: 353px;" placeholder="주소"		id="address1" disabled ></label>
										</div>
										<div class="td_composition_item">
											<label><input type="text" class="input_text" style="width: 353px;" placeholder="상세 주소"	id="address2"></label>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<ul class="btn_list">
						<li><button type="button" class="btn_positive" onClick="javaScript:register_delivery();">배송지등록</button></li>
						<li><button type="button" class="btn_negative" data-ui="layer-closer" onClick="javaScript:layerClose('');">등록취소</button></li>
					</ul>
					<a href="#layer_address_regist" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>
			</div>
			<!-- // 배송지등록 레이어 -->

			<?
			$idx = 0;
			foreach($delivery as $drow){?>

			<!-- 배송지수정 레이어 // -->
			<div class="layer layer_address" id="layer_address_modify_<?=$idx?>">
				<div class="layer_inner">
					<h1 class="layer_title layer_title__line">배송지수정</h1>
					<div class="layer_cont">
						<table class="line_none_table">
							<caption class="hide">배송지수정</caption>
							<colgroup>
								<col style="width:106px">
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th sope="row"><label for="formAddress0102">배송지명</label></th>
									<td><input type="text" class="input_text" id="formAddress0102" name= "deli_name<?=$idx?>" value="<?=$drow['CUST_DELIV_ADDR_NM']?>" style="width: 260px;" /></td>
								</tr>
								<tr>
									<th sope="row"><label for="formAddress0202">받는사람</label></th>
									<td><input type="text" class="input_text" id="formAddress0202" name="name<?=$idx?>" value="<?=$drow['RECV_NM']?>" style="width: 260px;" /></td>
								</tr>
								<tr>
									<th sope="row"><label for="formAddress0302">휴대전화</label></th>
									<td>
										<div class="select_wrap" style="width:97px;">
										<select id="formAddress0302" style="width:97px;" name="phone<?=$idx?>">
											<option <?=$drow['arr_mob'][0] == '010' ? "selected" : ""?>>010</option>
											<option <?=$drow['arr_mob'][0] == '011' ? "selected" : ""?>>011</option>
											<option <?=$drow['arr_mob'][0] == '016' ? "selected" : ""?>>016</option>
											<option <?=$drow['arr_mob'][0] == '017' ? "selected" : ""?>>017</option>
											<option <?=$drow['arr_mob'][0] == '019' ? "selected" : ""?>>019</option>
										</select>
										</div>
										<span class="dash">- </span>
										<label><input type="text" class="input_text" style="width: 100px;" value="<?=$drow['arr_mob'][1]?>" id="formAddress0302-2<?=$idx?>" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/></label>
										<span class="dash">- </span>
										<label><input type="text" class="input_text" style="width: 100px;" value="<?=$drow['arr_mob'][2]?>" id="formAddress0302-3<?=$idx?>" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/></label>
									</td>
								</tr>
								<tr>
									<th sope="row"><label for="formAddress0402">주소</label></th>
									<td>
										<div class="td_composition_item">
											<input type="text" id="formAddress0402<?=$idx?>" class="input_text" value="<?=$drow['ZIPCODE']?>" style="width: 152px;" disabled >
											<!--<button type="button" class="btn_white" onClick="javaScript:searchLayerOpen('U');">우편번호검색</button>
											<button type="button" class="btn_white" onClick="javaScript:searchAddressOpen('U');">우편번호검색</button>-->
											<button type="button" class="btn_white" onclick="execDaumPostcode('formAddress0402<?=$idx?>','','address3<?=$idx?>','','address4<?=$idx?>');">우편번호검색</button>
										</div>
										<div class="td_composition_item">
											<label><input type="text" class="input_text" style="width: 353px;" value="<?=$drow['ADDR1']?>" id="address3<?=$idx?>" disabled ></label>
										</div>
										<div class="td_composition_item">
											<label><input type="text" class="input_text" style="width: 353px;" value="<?=$drow['ADDR2']?>" id="address4<?=$idx?>"></label>
										</div>
										<input type="hidden" id="delivery_name<?=$idx?>"	value="<?=$drow['CUST_DELIV_ADDR_NM']?>">
										<input type="hidden" id="receiver_name<?=$idx?>"	value="<?=$drow['RECV_NM']?>">
										<input type="hidden" id="phone1_<?=$idx?>"			value="<?=$drow['arr_mob'][0]?>">
										<input type="hidden" id="phone2_<?=$idx?>"			value="<?=$drow['arr_mob'][1]?>">
										<input type="hidden" id="phone3_<?=$idx?>"			value="<?=$drow['arr_mob'][2]?>">
										<input type="hidden" id="zipcode<?=$idx?>"			value="<?=$drow['ZIPCODE']?>">
										<input type="hidden" id="addr1<?=$idx?>"			value="<?=$drow['ADDR1']?>">
										<input type="hidden" id="addr2<?=$idx?>"			value="<?=$drow['ADDR2']?>">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<ul class="btn_list">
						<li><button type="button" class="btn_positive" onClick="javaScript:update_delivery('<?=$drow['CUST_DELIV_ADDR_NO']?>', <?=$idx?>);">배송지수정</button></li>
						<li><button type="button" class="btn_negative" onClick="javaScript:layerClose('<?=$idx?>');">수정취소</button></li>
					</ul>
					<a href="javaScript:layerClose('<?=$idx?>');" class="spr-common layer_close" title="레이어 닫기"></a>
				</div>
				<div class="dimd"></div>

			</div>
			<!-- // 배송지수정 레이어 -->
			<?
			$idx++;
			}?>

			<div id="search_address"></div>

			
			<script type="text/javaScript">
			//====================================
			//trim 함수 생성
			//====================================
			function trim(s){
				s = s.replace(/^\s*/,'').replace(/\s*$/,'');
				return s;
			}

			//====================================
			// 체크박스 전체선택
			//====================================
			function jsChkAll(pBool){				
				for (var i=0; i<document.getElementsByName("chkDeliv[]").length; i++){
					document.getElementsByName("chkDeliv[]")[i].checked = pBool;
				}
			}

			//====================================
			// 체크박스 하나만 선택
			//====================================
			function checkbox(idx){				
				for (var i=0; i<document.getElementsByName("chkDeliv[]").length; i++){
					if(i == idx){
						document.getElementsByName("chkDeliv[]")[i].checked = true;
					}else{
						document.getElementsByName("chkDeliv[]")[i].checked = false;
					}
				}
			}

			//====================================
			// 레이어 닫기
			//====================================
			function layerClose(idx){
				if(!idx){
					$('#formAddress0101').val("");
					$('#formAddress0201').val("");
					$('#formAddress0301').val("010");
					$('#formAddress0301-2').val("");
					$('#formAddress0301-3').val("");
					$('#formAddress0401').val("");
					$('#address1').val("");
					$('#address2').val("");

					$("#layer_address_regist").attr('class','layer layer_address');
				}else{
					$('#formAddress0102'+idx).val($('#delivery_name'+idx).val());
					$('#formAddress0202'+idx).val($('#receiver_name'+idx).val());
					$('#formAddress0302'+idx).val($('#phone1_'+idx).val());
					$('#formAddress0302-2'+idx).val($('#phone2_'+idx).val());
					$('#formAddress0302-3'+idx).val($('#phone3_'+idx).val());
					$('#formAddress0402').val($('#zipcode'+idx).val());
					$('#address3'+idx).val($('#addr1'+idx).val());
					$('#address4'+idx).val($('#addr2'+idx).val());

					$("#layer_address_modify_"+idx).attr('class','layer layer_address');
				}
			}

			//====================================
			// 우편번호 검색 열기
			//====================================
			function searchLayerOpen(val){
				$("#layer__postal_code_search_01").attr('class','layer layer__postal_code_search layer__view');

				var ele = $('#layer__postal_code_search_01').find('.layer_inner'),
					top = $(window).scrollTop() + ($(window).height() / 2 - ele.outerHeight() / 2),
					left = - (ele.width() / 2);
				if ( top < $(window).scrollTop() ) {
					top = $(window).scrollTop();
				}

				ele.css( {
					'top' : top,
					'margin-left' : left
				} );

				$('#gubun').val(val);
			}

			//====================================
			// 우편번호 검색 닫기(다시검색)
			//====================================
			function searchLayerClose(){
				$('input[name=chk_detailadd]').val('N');
				$('input[name=add_addr]').val('');
				$('input[name=use_addr]').val('');
				$('input[name=use_post]').val('');
				$('span[name=basic_addr]').text('');
				$('span[name=post_num]').text('');
				$('span[name=basic_addr2]').text('');
				$('span[name=post_num2]').text('');
				$('span[name=add_addr2]').text('');

//				$("#layer__postal_code_search_01").attr('class','layer layer__postal_code_search');

				$('span[name=old_addr_cnt]').text('');
				$('ul[name=postalCodeCont01]').html('');	//지번주소

				$('span[name=new_addr_cnt]').text('');
				$('ul[name=postalCodeCont02]').html('');	//지번주소
	
			}

			//====================================
			// 배송지삭제
			//====================================
			function deleteDelivery(deliv_no){
				if(confirm("해당 배송지를 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_delivery',
						dataType: 'json',
						data: { deliv_no : deliv_no },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("삭제되었습니다.");
//								document.location.href = "/mywiz/delivery/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 기본배송지 설정
			//====================================
			function baseDelivery(deliv_no){
				var deliv_no = "";
				deliv_no = $('input[name="chkDeliv[]"]:checkbox:checked').val();

				if(!deliv_no){
					alert("배송지를 선택해주세요.");
					return false;
				}
				

				if(confirm("해당 배송지를 기본 배송지로 설정하시겠습니까?")){
					
					
					$.ajax({
						type: 'POST',
						url: '/mywiz/base_delivery',
						dataType: 'json',
						data: { deliv_no : deliv_no },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("설정되었습니다.");
								document.location.href = "/mywiz/delivery/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 배송지등록
			//====================================
			function register_delivery(){

				var delivery_nm = $("#formAddress0101").val()
					, receiver_nm = $("#formAddress0201").val()
					, phone1 = $("#formAddress0301").val()
					, phone2 = $("#formAddress0301-2").val()
					, phone3 = $("#formAddress0301-3").val()
					, post_no = $("#formAddress0401").val()
					, address1 = $("#address1").val()
					, address2 = $("#address2").val();

				if(!trim(delivery_nm)){
					alert("배송지명을 입력해주세요.");
					$("#formAddress0101").focus();
					return false;
				}
				if(!trim(receiver_nm)){
					alert("받는사람을 입력해주세요.");
					$("#formAddress0201").focus();
					return false;
				}
				if(!trim(phone2)){
					alert("휴대전화의 국번을 입력해주세요.");
					$("#formAddress0301-2").focus();
					return false;
				}
				if(phone2.length < 3){
					alert("휴대전화의 국번은 3자리 이상이어야 합니다.");
					$("#formAddress0301-2").focus();
					return false;
				}
				if(!trim(phone3)){
					alert("휴대전화의 뒷자리를 입력해주세요.");
					$("#formAddress0301-3").focus();
					return false;
				}
				if(phone3.length < 4){
					alert("휴대전화의 뒷자리는 4자리 이상이어야 합니다.");
					$("#formAddress0301-3").focus();
					return false;
				}
				if(!trim(address1)){
					alert("주소를 입력해주세요.");
					$("#address1").focus();
					return false;
				}
				if(!trim(address2)){
					alert("상세주소 입력해주세요.");
					$("#address2").focus();
					return false;
				}

				if(confirm("등록하시겠습니까?")){

					$.ajax({
						type: 'POST',
						url: '/mywiz/register_delivery',
						dataType: 'json',
						data: { delivery_nm		: delivery_nm
								, receiver_nm	: receiver_nm
								, phone			: phone1+"-"+phone2+"-"+phone3
								, post_no		: post_no
								, address1		: address1
								, address2		: address2},
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
									alert("등록되었습니다.");
									document.location.href = "/mywiz/delivery/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 배송지수정
			//====================================
			function update_delivery(val, idx){

				var	deliv_no = val
					, delivery_nm = $("input[name=deli_name"+idx+"]").val()
					, receiver_nm = $("input[name=name"+idx+"]").val()
					, phone1 = $("select[name=phone"+idx+"]").val()
					, phone2 = $("#formAddress0302-2"+idx).val()
					, phone3 = $("#formAddress0302-3"+idx).val()
					, post_no = $("#formAddress0402"+idx).val()
					, address1 = $("#address3"+idx).val()
					, address2 = $("#address4"+idx).val();

				if(!trim(delivery_nm)){
					alert("배송지명을 입력해주세요.");
					$("input[name=deli_name"+idx+"]").focus();
					return false;
				}
				if(!trim(receiver_nm)){
					alert("받는사람을 입력해주세요.");
					$("input[name=name"+idx+"]").focus();
					return false;
				}
				if(!trim(phone2)){
					alert("휴대전화의 국번을 입력해주세요.");
					$("#formAddress0302-2"+idx).focus();
					return false;
				}
				if(phone2.length < 3){
					alert("휴대전화의 국번은 3자리 이상이어야 합니다.");
					$("#formAddress0302-2"+idx).focus();
					return false;
				}
				if(!trim(phone3)){
					alert("휴대전화의 뒷자리를 입력해주세요.");
					$("#formAddress0302-3"+idx).focus();
					return false;
				}
				if(phone3.length < 4){
					alert("휴대전화의 뒷자리는 4자리 이상이어야 합니다.");
					$("#formAddress0302-3"+idx).focus();
					return false;
				}
				if(!trim(address1)){
					alert("주소를 입력해주세요.");
					$("#address3"+idx).focus();
					return false;
				}
				if(!trim(address2)){
					alert("상세주소 입력해주세요.");
					$("#address3"+idx).focus();
					return false;
				}

				if(confirm("수정하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/update_delivery',
						dataType: 'json',
						data: { deliv_no		: deliv_no
								, delivery_nm	: delivery_nm
								, receiver_nm	: receiver_nm
								, phone			: phone1+"-"+phone2+"-"+phone3
								, post_no		: post_no
								, address1		: address1
								, address2		: address2},
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
			}

			//====================================
			// 우편번호 검색(탭 클릭시 탭 전환)
			//====================================
			function jsPostChg(gubun){
				if(gubun == '2'){	//도로명주소 선택한경우
					$('li[name=old_postal]').removeClass();
					$('li[name=new_postal]').addClass('active');
					$('ul[name=postalCodeCont01]').hide();
					$('ul[name=postalCodeCont02]').show();
				} else if(gubun == '1'){	//지번주소 선택한경우
					$('li[name=new_postal]').removeClass();
					$('li[name=old_postal]').addClass('active');
					$('ul[name=postalCodeCont01]').show();
					$('ul[name=postalCodeCont02]').hide();
				}
			}

			//====================================
			// 우편번호 검색
			//====================================
			function jsPostnum(search_dong){
				$.ajax({
						type: 'POST',
						url: '/cart/get_postnum',
						dataType: 'json',
						data: { dong : search_dong },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							$('#loading').show();
							if(res.status == 'ok'){
								//검색시 초기화.
								$('input[name=chk_detailadd]').val('N');
								$('span[name=basic_addr]').text('');
								$('span[name=post_num]').text('');
								$('input[name=add_addr]').val('');
								$('span[name=basic_addr2]').hide();
								$('span[name=post_num2]').hide();

								//검색결과 붙여넣기
								$('span[name=old_addr_cnt]').text('('+res.old_addr_cnt+')');
								$('ul[name=postalCodeCont01]').html(res.old_addr);	//지번주소

								$('span[name=new_addr_cnt]').text('('+res.new_addr_cnt+')');
								$('ul[name=postalCodeCont02]').html(res.new_addr);	//지번주소
							}
							else alert(res.message);
						}
					})
			}
			
			//====================================
			// 주소 클릭시 붙여넣기
			//====================================
			function jsPastepost1(gubun, idx){

				if(gubun == '1'){	//지번주소
					$('span[name=basic_addr]').text($($("input[name='addr_v1[]']").get(idx)).val());
					$('span[name=post_num]').text($($("input[name='addr_post1[]']").get(idx)).val());
					$('span[name=basic_addr2]').hide();
					$('span[name=post_num2]').hide();
					$('input[name=use_addr]').val($($("input[name='addr_v1[]']").get(idx)).val());
					$('input[name=use_post]').val($($("input[name='addr_post1[]']").get(idx)).val());
					$('span[name=basic_addr2]').text($($("input[name='addr_v1[]']").get(idx)).val());
					$('span[name=post_num2]').text("("+$($("input[name='addr_post1[]']").get(idx)).val()+")");
				} else if(gubun == '2'){	//도로명주소
					$('span[name=basic_addr]').text($($("input[name='addr_v2[]']").get(idx)).val());
					$('span[name=post_num]').text($($("input[name='addr_post2[]']").get(idx)).val());
					$('span[name=basic_addr2]').hide();
					$('span[name=post_num2]').hide();
					$('input[name=use_addr]').val($($("input[name='addr_v2[]']").get(idx)).val());
					$('input[name=use_post]').val($($("input[name='addr_post2[]']").get(idx)).val());
					$('span[name=basic_addr2]').text($($("input[name='addr_v2[]']").get(idx)).val());
					$('span[name=post_num2]').text("("+$($("input[name='addr_post2[]']").get(idx)).val()+")");
				}

//				$('span[name=basic_addr]').text($($("input[name='addr_v2[]']").get(idx)).val());
//				$('span[name=post_num]').text($($("input[name='addr_post2[]']").get(idx)).val());
//				$('span[name=basic_addr2]').hide();
//				$('span[name=post_num2]').hide();
//				$('input[name=use_addr]').val($($("input[name='addr_v2[]']").get(idx)).val());
//				$('input[name=use_post]').val($($("input[name='addr_post2[]']").get(idx)).val());
//				$('span[name=basic_addr2]').text($($("input[name='addr_v2[]']").get(idx)).val());
//				$('span[name=post_num2]').text("("+$($("input[name='addr_post2[]']").get(idx)).val()+")");

			}
			

			//====================================
			// 상세주소입력 버튼 클릭시 
			//====================================
			function jsDetailaddr(){
				if(!$('input[name=use_addr]').val()) return false;
			//	$('input[name=use_addr]').val($('input[name=use_addr]').val()+" "+$('input[name=add_addr]').val());
				$('span[name=add_addr2]').text($('input[name=add_addr]').val());
				$('span[name=basic_addr2]').show();
				$('span[name=post_num2]').show();
				$('input[name=chk_detailadd]').val('Y');
			}
			
			

			//====================================
			// 우편번호 찾기
			//====================================
			function searchAddressOpen(gb){
				
				$.ajax({
					type: 'POST',
					url: '/mywiz/search_address',
					dataType: 'json',
					data: { gubun : gb},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.search_address);
							$("#search_address").html(res.search_address);
						}
						else alert(res.message);
					}
				});

				$("#layer__postal_code_search_01").attr('class','layer layer__postal_code_search layer__view');

				var ele = $('#layer__postal_code_search_01').find('.layer_inner'),
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
			// 주소사용
			//====================================
			function jsUseaddr(){
				var gubun = $('#gubun').val();
				if(gubun == 'R'){//배송지 등록일때
					if($('input[name=chk_detailadd]').val() == 'N'){
						alert("상세주소를 입력하여 버튼을 눌러주세요.");
						return false;
					}
					else{
						$('#formAddress0401').val(($('input[name=use_post]').val()).replace('-', ''));
						$('#address1').val($('input[name=use_addr]').val());
						$('#address2').val($('input[name=add_addr]').val());
						$('#layer__postal_code_search_01').removeClass();
						$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
					}
				}else if(gubun == 'U'){//배송지 수정일때
					if($('input[name=chk_detailadd]').val() == 'N'){
						alert("상세주소를 입력하여 버튼을 눌러주세요.");
						return false;
					}
					else{
						$('#formAddress0402').val(($('input[name=use_post]').val()).replace('-', ''));
						$('#address3').val($('input[name=use_addr]').val());
						$('#address4').val($('input[name=add_addr]').val());
						$('#layer__postal_code_search_01').removeClass();
						$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
					}
				}
			}

			
			//====================================
			// 주소 클릭시 붙여넣기
			//====================================
			function jsPastepost(aGubun, idx){
				var gubun = $('#addr_gubun').val();
//alert(gubun);
				if(gubun == 'R'){//배송지 등록일때
//									alert("z");

					if(aGubun == '1'){	//지번주소
						$('#formAddress0401').val($($("input[name='addr_post1[]']").get(idx)).val());
						$('#address1').val($($("input[name='addr_v1[]']").get(idx)).val());

						//레이어 닫기
						$('#layer__postal_code_search_01').removeClass();
						$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
						$('#layer_address_list').removeClass();
						$('#layer_address_list').addClass('layer layer_address_list');
				
					} else if(aGubun == '2'){	//도로명주소
						$('#formAddress0401').val($($("input[name='addr_post2[]']").get(idx)).val());
						$('#address1').val($($("input[name='addr_v2[]']").get(idx)).val());

						//레이어 닫기
						$('#layer__postal_code_search_01').removeClass();
						$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
						$('#layer_address_list').removeClass();
						$('#layer_address_list').addClass('layer layer_address_list');
					}
				}else if(gubun == 'U'){//배송지 수정일때
					if(aGubun == '1'){	//지번주소
						$('#formAddress0402').val($($("input[name='addr_post1[]']").get(idx)).val());
						$('#address3').val($($("input[name='addr_v1[]']").get(idx)).val());

						//레이어 닫기
						$('#layer__postal_code_search_01').removeClass();
						$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
						$('#layer_address_list').removeClass();
						$('#layer_address_list').addClass('layer layer_address_list');
				
					} else if(aGubun == '2'){	//도로명주소
						$('#formAddress0402').val($($("input[name='addr_post2[]']").get(idx)).val());
						$('#address3').val($($("input[name='addr_v2[]']").get(idx)).val());

						//레이어 닫기
						$('#layer__postal_code_search_01').removeClass();
						$('#layer__postal_code_search_01').addClass('layer layer__postal_code_search');
						$('#layer_address_list').removeClass();
						$('#layer_address_list').addClass('layer layer_address_list');
					}
				}
			}

						
			</script>