					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">주요서비스 바로가기</h3>
						<ul class="mypage_section mypage_order_progress mypage_order_progress__cs">
							<li>
								<a href="/customer/register_qna" class="link">
									<span class="spr-mypage spr-inquiry"></span>
									<span class="text">1:1 문의하기</span>
								</a>
							</li>
							<li>
								<a href="/mywiz/order" class="link">
									<span class="spr-mypage spr-order"></span>
									<span class="text">주문&#47;배송</span>
								</a>
							</li>
							<li>
								<a href="/mywiz/current_order" class="link">
									<span class="spr-mypage spr-cancel"></span>
									<span class="text">취소&#47;반품&#47;교환</span>
								</a>
							</li>
							<li>
								<a href="/mywiz/mileage" class="link">
									<span class="spr-mypage spr-mileage"></span>
									<span class="text">마일리지</span>
								</a>
							</li>
							<li>
								<a href="/mywiz/coupon" class="link">
									<span class="spr-mypage spr-coupon"></span>
									<span class="text">쿠폰</span>
								</a>
							</li>
							<li>
								<a href="/mywiz/check_password/MI" class="link">
									<span class="spr-mypage spr-admin"></span>
									<span class="text">회원&#47;정보관리</span>
								</a>
							</li>
						</ul>
						
						<div class="position_area position_area__mypage">
							<h3 class="title_page title_page__mypage">자주 찾는 질문 베스트 10</h3>
							<a href="/customer/faq" class="position_right btn_text">more</a>
						</div>

						<div class="mypage_section board_list board_list__inquiry">
							<table class="board_list_table">
								<caption>자주 찾는 질문 베스트 10</caption>
								<colgroup>
									<col style="width:115px;" />
									<col style="width:166px;" />
									<col />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">번호</th>
										<th scope="col">구분</th>
										<th scope="col">제목</th>
									</tr>
								</thead>
								<tbody>
									<?
									$i=0;
									foreach($faq as $frow){?>
									<tr id="open_faq<?=$i?>" class="">
										<!-- 클릭시 active 클래스 추가 -->
										<td><?=$i+1?></td>
										<td><?=$frow['CS_QUE_TYPE_CD_NM']?></td>
										<td class="comment"><a href="javaScript:jsOpen('F',<?=$i?>);" class="link"><?=$frow['TITLE']?></a></td>
									</tr>
									<tr class="reply">
										<td colspan="3"><?=$frow['CONTENT']?></td>
									</tr>
									<?
									$i++;
									}?>
									<!--<tr>
										<td>2</td>
										<td>주문&#47;배송</td>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>3</td>
										<td>취소&#47;반품&#47;교환</td>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>4</td>
										<td>마일리지</td>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>5</td>
										<td>상품</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>6</td>
										<td>주문&#47;배송</td>
										<td class="comment"><a href="#" class="link">상품이 생각보다 작은데 사이즈가 맞는건지 궁금합니다.</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>7</td>
										<td>취소&#47;반품&#47;교환</td>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>8</td>
										<td>마일리지</td>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>9</td>
										<td>상품</td>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>10</td>
										<td>주문&#47;배송</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>-->
								</tbody>
							</table>
						</div>

						<div class="position_area position_area__mypage">
							<h3 class="title_page title_page__mypage">공지사항</h3>
							<a href="/customer/notice" class="position_right btn_text">more</a>
						</div>

						<div class="mypage_section board_list board_list__inquiry board_list__notice">
							<table class="board_list_table">
								<caption>공지사항</caption>
								<colgroup>
									<col />
									<col style="width:147px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">제목</th>
										<th scope="col">등록일</th>
									</tr>
								</thead>
								<tbody>
								<?
								if($notice){
									$idx=0;
									foreach($notice as $nrow){?>
									<tr id="open_notice<?=$idx?>" class="">
										<!-- 클릭시 active 클래스 추가 -->
										<td class="comment"><a href="javaScript:jsOpen('N',<?=$idx?>);" class="link"><?=$nrow['TITLE']?></a></td>
										<td><?=$nrow['REG_DT']?></td>
									</tr>
									<tr class="reply">
										<td colspan="2"><?=$nrow['CONTENT']?>

                                        <?
                                        if (strlen($nrow['FILE_NAME']) != 0) {
                                            $file_names = explode(',', $nrow['FILE_NAME']);
                                            $file_paths = explode(',', $nrow['FILE_PATH']);
                                            for ($i=0; $i < count($file_names); $i++){
                                                ?>
                                                <br><a style="text-decoration: underline" href="<?=$file_paths[$i]?>" download="<?=$file_names[$i]?>"><?=$file_names[$i]?></a><br>
                                                <?
                                            }
                                        }
                                        ?>
                                        </td>
									</tr>
									
								<?
									$idx++;
									}
								}else{?>
									<td colspan="2">등록된 공지사항이 없습니다.</td>
								<?}?>
									<!--<tr class="reply">
										<td colspan="2">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="2">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="2">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="2">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="2">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>-->
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		
			<script type="text/javaScript">
			//=====================================
			// 문의 클릭시 펼쳐보기
			//=====================================
			function jsOpen(type,idx){
				var tr_id = "";
				type == 'F' ? tr_id = "#open_faq" : tr_id = "#open_notice";

				if($(tr_id+idx).attr('class') == ""){		//접혀있는 경우
					$(tr_id+idx).addClass('active');
				} else {		//펼쳐있는 경우
					$(tr_id+idx).removeClass();
				}
			}
			</script>