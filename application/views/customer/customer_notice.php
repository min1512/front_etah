					<div class="mypage_cont">
						<h3 class="title_page title_page__mypage">공지사항</h3>

						<div class="mypage_section board_list board_list__inquiry board_list__notice">
							<table class="board_list_table">
								<caption>공지사항</caption>
								<colgroup>
									<col style="width:115px;" />
									<col />
									<col style="width:177px;" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col">번호</th>
										<th scope="col">제목</th>
										<th scope="col">등록일</th>
									</tr>
								</thead>
								<tbody>
									<?
									$idx = ($page - 1) * $sNum + 1;
									foreach($notice as $row){?>
									<tr class="" id="notice<?=$idx?>">
										<!-- 클릭시 active 클래스 추가 -->
										<td><?=$idx?></td>
										<td class="comment"><a href="javaScript:jsOpen(<?=$idx?>);" class="link"><?=$row['TITLE']?></a></td>
										<td><?=substr($row['REG_DT'],0,10)?></td>
									</tr>
                                    <tr class="reply">
                                        <td colspan="3"><?=$row['CONTENT']?>

                                            <?
                                            if (strlen($row['FILE_NAME']) != 0) {
                                                $file_names = explode(',', $row['FILE_NAME']);
                                                $file_paths = explode(',', $row['FILE_PATH']);
                                                for ($i=0; $i < count($file_names); $i++){
                                                    ?>
                                                    <br><a href="<?=$file_paths[$i]?>" download="<?=$file_names[$i]?>"><?=$file_names[$i]?></a><br>
                                                    <?
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
									<?
									$idx ++;
									}?>
									<!--<tr>
										<td>9</td>
										<td class="comment"><a href="#" class="link">무통장으로 결제했는데 계좌번호를 잊어버렸어요. 어찌해야 하나요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>8</td>
										<td class="comment"><a href="#" class="link">어제 배송이 왔는데 생각보다 너무 늦은감도 있고 상품도 컬러가 다르네요.</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>7</td>
										<td class="comment"><a href="#" class="link">반품 접수 후 환불까지 얼마나 기간이 걸릴까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>6</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>5</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>4</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>3</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>2</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
									</tr>
									<tr>
										<td>1</td>
										<td class="comment"><a href="#" class="link">상품이 깨져서 왔는데 바로 포장 개방 후에도 교환이 가능할까요?</a></td>
										<td>2016-02-16</td>
									</tr>
									<tr class="reply">
										<td colspan="3">안녕하세요 에타몰입니다.<br />개인 구매회원 경우, 고객센터(☎1688-4945), 1:1문의 게시판으로 문의주시면 대량구매관련 안내를 드리겠습니다. <br />법인 구매회원의 경우, 법인사업자 구매혜택 쿠폰을 이용하여 대량구매를 하시면 할인받으실 수 있습니다. <br />감사합니다.</td>
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

			<script type="text/javaScript">
			//=====================================
			// 공지 클릭시 펼쳐보기
			//=====================================
			function jsOpen(idx){
				if($("#notice"+idx).attr('class') == ""){		//접혀있는 경우
					$("#notice"+idx).addClass('active');
				} else {		//펼쳐있는 경우
					$("#notice"+idx).removeClass();
				}
			}
			</script>