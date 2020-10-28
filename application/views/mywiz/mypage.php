
					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">진행중인주문</h3>
						<ul class="mypage_section mypage_order_progress">
							<li>
								입금대기중
								<a href="/mywiz/order" class="link"><?=$order_state['A']?></a>
							</li>
							<li>
								결제완료
								<a href="/mywiz/order" class="link"><?=$order_state['B']?></a>
							</li>
							<li>
								배송준비중
								<a href="/mywiz/order" class="link"><?=$order_state['C']?></a>
							</li>
							<li>
								배송중
								<a href="/mywiz/order" class="link"><?=$order_state['D']?></a>
							</li>
							<li>
								배송완료
								<a href="/mywiz/order" class="link"><?=$order_state['E']?></a>
							</li>
							<li>
								취소&#47;반품
								<a href="/mywiz/current_order" class="link"><?=$order_state['F']?></a>
							</li>
						</ul>

						<div class="position_area position_area__mypage">
							<h3 class="title_page title_page__mypage">최근주문정보</h3>
							<a href="/mywiz/order" class="position_right btn_text">more</a>
						</div>

						<div class="board_list board_list__prd_info mypage_section">
							<table class="board_list_table">
								<caption>최근주문정보 리스트</caption>
								<colgroup>
									<col style="width:173px;" />
									<col style="width:134px;" />
									<col />
									<col style="width:71px;" />
									<col style="width:149px;" />
									<col style="width:97px;" />
									<col style="width:125px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">주문번호</th>
										<th scope="col"><span class="hide_text">상품이미지</span></th>
										<th scope="col" class="title_prd_info">상품정보</th>
										<th scope="col">수량</th>
										<th scope="col">취소&#47;반품</th>
										<th scope="col">상품금액</th>
										<th scope="col">주문상태</th>
									</tr>
								</thead>
								<tbody>
								<?if($order){
									$order_no = "";
									foreach($order as $orow){?>
									<tr>
										<?if($order_no != $orow['ORDER_NO']){?>
										<td class="order_number" rowspan="<?=$cnt_order_refer[$orow['ORDER_NO']]?>">
											<a href="/mywiz/order_detail/<?=$orow['ORDER_NO']?>" class="link"><?=$orow['ORDER_NO']?><br/>(<?=$orow['REG_DT']?>)</a>
											<button type="button" class="btn_white btn_white__small" onClick="javaScript:location.href='/mywiz/order_detail/<?=$orow['ORDER_NO']?>'">상세보기</button>
										</td>
										<?}?>
										<td class="image">
											<a href="/goods/detail/<?=$orow['GOODS_CD']?>"><img src="<?=$orow['IMG_URL']?>" alt="" width="100" height="100"/></a>
										</td>
										<td class="goods_detail__string">
											<p class="name"><a href="/goods/detail/<?=$orow['GOODS_CD']?>"><?=$orow['GOODS_NM']?></a></p>
											<p class="description"><?$orow['PROMOTION_PHRASE']?></p>
											<p class="option"><?=$orow['GOODS_OPTION_NM']?></p>
										</td>
										<td><?=$orow['ORD_QTY']?></td>
										<td><?=$orow['CANCEL_CHANGE_RETURN']?></td>
										<td><?=number_format($orow['SELLING_PRICE'])?>원</td>
										<td><?=$orow['ORDER_REFER_PROC_STS_CD_NM']?><br />
										<? if( $row['COMMENT_YN']=='Y' && $orow['MEMBER_YN']=='Y' ){	?>
										<button type="button" class="btn_white btn_white__small position_right" onClick="javaScript:jsGoodsComment(<?=$orow['GOODS_CD']?>);">상품평쓰기</button>
										<? }?></td>
									</tr>
								<?
									$order_no = $orow['ORDER_NO'];
									}
								}else{?>
									<tr>
										<td colspan="7">주문 내역이 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td class="order_number" rowspan="2">
											<a href="/mywiz/order_detail/" class="link">2016-01-26-327668</a>
											<button type="button" class="btn_white btn_white__small" onClick="javaScipt:goOrderDetail();">상세보기</button>
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
										<td>0</td>
										<td>353,500</td>
										<td>입금대기</td>
									</tr>
									<tr>

										<td class="image">
											<img src="/assets/images/data/data_100x100_03.jpg" alt="" />
										</td>
										<td class="goods_detail__string">
											<p class="name">Jacksonchameleon</p>
											<p class="description">Flat Table 400 - black</p>
											<p class="option">블랙 &#47; 800mm</p>
										</td>
										<td>1</td>
										<td>0</td>
										<td>353,500</td>
										<td>입금대기</td>
									</tr>-->
								</tbody>
							</table>

							<ul class="bullet_list">
								<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>주문 상품의 <span class="bullet_underline">교환을 원하시는 고객님께서는 상품 수령 후 7일 이내에 <strong>고객센터 페이지에서 좌측 메뉴에 1:1문의&gt;문의하기에 접수/신청</strong></span>하여 주시면 교환 방법에 대해 자세히 안내 드리겠습니다.<br>내용은 고객센터&gt;자주 찾는 질문 참조해주시면 고맙겠습니다.</li>

							</ul>
						</div>
						<?if($this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
						<div class="position_area position_area__mypage">
							<h3 class="title_page title_page__mypage">1:1 문의</h3>
							<a href="/mywiz/p_qna" class="position_right btn_text">more</a>
						</div>

						<div class="mypage_section board_list board_list__inquiry">
							<table class="board_list_table">
								<caption>1:1 문의 리스트</caption>
								<colgroup>
									<col style="width:132px;" />
									<col />
									<col style="width:97px;" />
									<col style="width:125px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">구분</th>
										<th scope="col">제목</th>
										<th scope="col">문의일</th>
										<th scope="col">처리상태</th>
									</tr>
								</thead>
								<tbody>
								<?
								$idx=0;
								if($qna_list){
									foreach($qna_list as $qrow){?>
									<tr class="" id="qna<?=$idx?>">
										<td><?=$qrow['CS_QUE_TYPE_CD_NM']?></td>
										<td class="comment"><a href="javaScript:jsOpen(<?=$idx?>);" class="link"><?=$qrow['Q_TITLE']?></a></td>
										<td><?=$qrow['Q_REG_DT']?></td>
										<td><?=$qrow['A_NO'] ? "답변완료" : "답변대기"?></td>
									</tr>
									<tr class="reply">
										<td colspan="4">
											<div class="question">
												<span class="left">Q</span>
												<div class="text">
													<?=$qrow['Q_CONTENTS']?>
												</div>
											</div>
											<?if($qrow['ORDER_GOODS_CD']){?>
											<div class="prd_info">
												<div class="img"><img src="<?=$qrow['ORDER_GOODS_IMG_URL']?>" alt="" width="100" height="100"></div>
												<div class="goods_detail__string">
													<p class="name"><?=$qrow['ORDER_GOODS_NM']?></p>
													<!--<p class="description">Flat Table 400 - black</p>-->
													<p class="option"><?=$qrow['ORDER_GOODS_OPTION_NM']?></p>
												</div>
											</div>
											<?}?>
											<?if($qrow['A_NO']){?>
											<div class="answer">
												<span class="left">A</span>
												<div class="text">
													<?=$qrow['A_CONTENTS']?>
												</div>
											</div>
											<?}?>
										</td>
									</tr>
								<?
									$idx++;
									}
								}else{?>
									<tr>
										<td colspan="4">등록된 문의가 없습니다.</td>
									</tr>
								<?}?>
									<!--<tr>
										<td>주문&#47;결제</td>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>배송</td>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>환불</td>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>
									<tr>
										<td>교환</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
										<td>답변대기</td>
									</tr>-->
								</tbody>
							</table>
						</div>
						<?}?>


						<h3 class="title_page title_page__mypage">배송상태 안내</h3>
						<ul class="mypage_section delivery_info_list">
							<li class="delivery_info_item pay">
								<span class="spr-mypage spr-ico_card"></span>
								<p class="info">
									<em class="title">결제완료</em><br /> 판매자가 주문을<br />확인하기 전입니다.
								</p>
							</li>
							<li class="delivery_info_item ready">
								<span class="spr-mypage spr-ico_ready"></span>
								<p class="info">
									<em class="title">상품준비중</em><br /> 주문하신 상품을<br />준비중입니다.
								</p>
								<span class="spr-mypage spr-arrow"></span>

							</li>
							<li class="delivery_info_item send">
								<span class="spr-mypage spr-ico_send"></span>
								<p class="info">
									<em class="title">배송준비중</em><br /> 준비된 상품이 곧<br />발송될 예정입니다.
								</p>
								<span class="spr-mypage spr-arrow"></span>
							</li>
							<li class="delivery_info_item start">
								<span class="spr-mypage spr-ico_start"></span>
								<p class="info">
									<em class="title">배송중</em><br /> 주문하신 상품이<br />출발하였습니다.
								</p>
								<span class="spr-mypage spr-arrow"></span>
							</li>
							<li class="delivery_info_item home">
								<span class="spr-mypage spr-ico_home"></span>
								<p class="info">
									<em class="title">배송완료</em><br /> 상품이 고객님께<br />도착했습니다.
								</p>
								<span class="spr-mypage spr-arrow"></span>
							</li>
						</ul>
						<ul class="bullet_list">
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>배송지 수정 및 구매취소는 주문하신 배송상품이 '결제완료' 상태일 때만 가능합니다.</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>환불 요청은 '배송완료 다음날부터 7일'까지 가능합니다. (환불은 '배송준비중' 상태일 때 부터 요청가능)</li>
							<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>환불 요청 후 1~3일 내에 택배사에서 고객님께 연락 후 상품을 수거하게 되니 잠시 기다려 주세요.</li>
						</ul>
					</div>
				</div>
			</div>

			<script type="text/javaScript">
			//=====================================
			// 문의 클릭시 펼쳐보기
			//=====================================
			function jsOpen(idx){
				if($("#qna"+idx).attr('class') == ""){		//접혀있는 경우
					$("#qna"+idx).addClass('active');
				} else {		//펼쳐있는 경우
					$("#qna"+idx).removeClass();
				}
			}
			</script>