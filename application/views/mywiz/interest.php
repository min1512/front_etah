
					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">관심상품</h3>
						<div class="btn_area">
							<button type="button" class="btn_white btn_white__small" onClick="javaScript:chkInterestDelete();">선택삭제</button>
							<!--<button type="button" class="btn_white btn_white__small">선택상품 장바구니담기</button>-->
						</div>
						<div class="board_list board_list__prd_info board_list_mypagemodify">
							<table class="board_list_table" summary="장바구니에 담겨진 상품 리스트 입니다.">
								<caption>장바구니 상품 리스트</caption>
								<colgroup>
									<col width="72px" />
									<col width="130px" />
									<col width="*" />
									<col width="157px" />
									<col width="103px" />
									<col width="156px" />
									<col width="146px" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">
											<input type="checkbox" id="all_check" class="checkbox" onClick="javascript:jsChkAll(this.checked);"/>
											<label for="all_check" class="checkbox_label"><span class="hide">전체선택</span></label>
										</th>
										<th scope="col">
											<span class="hide_text">상품이미지</span>
										</th>
										<th scope="col" class="title_prd_info">
											<span class="th_text">상품정보</span>
										</th>
										<th scope="col">
											<span class="th_text">판매금액</span>
										</th>
										<th scope="col">
											<span class="th_text">배송비</span>
										</th>
										<th scope="col">
											<span class="th_text">공유하기</span>
										</th>
										<th scope="col">
											<span class="th_text">삭제</span>
										</th>
									</tr>
								</thead>
								<tbody>
								<?
								if($total_cnt){
									$i=0;
									foreach($wish_list as $row){?>
									<tr>
										<td class="goods_select">
											<input type="checkbox" id="goods_select_<?=$i?>" class="checkbox" name="chkGoods[]" value="<?=$row['GOODS_CD']?>"/>
											<label for="goods_select_<?=$i?>" class="checkbox_label"><span class="hide"><?=$row['BRAND_NM']?> 선택</span></label>
										</td>
										<td class="image">
											<a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" alt="상품 이미지" width="100" height="100"/></a>
										</td>
										<td class="goods_detail__string">
											<a href="/goods/detail/<?=$row['GOODS_CD']?>"><p class="name"><?=$row['BRAND_NM']?></p></a>
											<p class="description"><?=$row['GOODS_NM']?></p>
											<!--<p class="option">블랙 / 800mm</p>-->
										</td>
										<td class="price">
											<p class="price_text"><?=number_format($row['SELLING_PRICE'])?>원</p>
										</td>
										<td class="delivery_type">
											<p>
											<? 
											if( $row['DELI_LIMIT'] >= 0 || $row['DELI_LIMIT']>$row['SELLING_PRICE'] ){
												echo number_format($row['DELI_COST'])."원";
											}else{	
												echo "무료배송";
											}
											?>
											</p>
										</td>
										<td class="share">
											<ul class="sns_list">
												<li><a href="#" class="spr-common spr_sns_facebook" onClick="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">페이스북</a></li>
												<!--<li><a href="#" class="spr-common spr_sns_insta" onClick="javaScript:jsGoodsAction('S','I','','');">인스타그램</a></li>-->
												<li><a href="#" class="spr-common spr_sns_pinter" onClick="javaScript:jsGoodsAction('S','P','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');">핀터래스트</a></li>
											</ul>
										</td>
										<td class="order ">
											<p>
												<!--<button type="button" class="btn_black btn_black__small btn_now_pay">바로구매</button>-->
											</p>
											<button type="button" class="btn_white btn_white__small btn_delete" onClick="javaScipr:interestDelete(<?=$i?>);">삭제</button>
										</td>
									</tr>
									<?
									$i++;
									}
								}else{?>
									<tr>
										<td colspan="7"> 등록된 관심상품이 없습니다.</td>
									</tr>
								<?}?>
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

			<script type="text/javaScript">

			//====================================
			// 체크박스 전체선택
			//====================================
			function jsChkAll(pBool){				
				for (var i=0; i<document.getElementsByName("chkGoods[]").length; i++){
					document.getElementsByName("chkGoods[]")[i].checked = pBool;
				}
			}

			//====================================
			// 삭제
			//====================================
			function interestDelete(idx){
				var goods_cd = document.getElementsByName("chkGoods[]")[idx].value;
				if(confirm("해당 상품을 관심상품에서 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_interest',
						dataType: 'json',
						data: { goods_cd : goods_cd },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("삭제되었습니다.");
								document.location.href = "/mywiz/interest/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 선택삭제
			//====================================
			function chkInterestDelete(){
				var goodsArr = new Array();
				$("input:checkbox[name='chkGoods[]']:checked").each(function() {
					goodsArr.push($(this).val());     // 체크된 것만 값을 뽑아서 배열에 push
				});

				if(goodsArr.length == 0){
					alert("삭제할 상품을 선택해주세요.");
					return false;
				}

				if(confirm("선택한 상품들을 관심상품에서 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/chk_delete_interest',
						dataType: 'json',
						data: { goodsArr : goodsArr },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("삭제되었습니다.");
								document.location.href = "/mywiz/interest/";
							}
							else alert(res.message);
						}
					});
				}
			}
			</script>