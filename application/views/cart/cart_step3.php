<!-- 2017-02-23 추가 -->
<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
    var _nasa={};
    _nasa["cnv"] = wcs.cnv("1","<?=$order['ORDER_AMT']?>"); // 전환유형, 전환가치 설정해야함. 설치매뉴얼 참고: 구매(유형 값 1)의 경우 전환가치는 매번 달라질 것이므로 변수로 입력을 해 놓으시기 바랍니다.
</script>

<!--카페24전환 스크립트 시작 (2017-04-26 : 제거요청)-->
<script type='text/javascript'>
    //           order_id = '1';
    //           order_price = "<?=$order['ORDER_AMT']?>"; // ‘주문가격’ 부분은 ETAH에서 사용하는 주문가격 변수로 수정해야 함
    //var SaleJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
    //           document.write(unescape("%3Cscript id='sell_script' src='"+SaleJsHost+ "etah.cmclog.cafe24.com/sell.js?mall_id=etah' type='text/javascript'%3E%3C/script%3E"));
</script>
<!-- //카페24전환 스크립트 종료 -->


<link rel="stylesheet" href="/assets/css/cart_order.css">

<div class="contents order_page">
    <h2 class="page_title">주문/결제</h2>
    <div class="myinfo">
        <div class="myinfo_greet">
            <span class="spr-cart icon_me"></span><em class="bold"><?=$order['SENDER_NM']?>님 주문번호 : <?=$order_no?></em>
        </div>
        <div class="step_block">
            <ul class="step_list">
                <li class="step_item">
                    <span class="spr-cart icon_cart"></span>
                    <span class="step_text">01. 장바구니</span>
                    <span class="spr-cart arow_right"></span>
                </li>
                <li class="step_item">
                    <span class="spr-cart icon_write"></span>
                    <span class="step_text">02. 주문/결제</span>
                    <span class="spr-cart arow_right"></span>
                </li>
                <li class="step_item active">
                    <span class="spr-cart icon_complete"></span>
                    <span class="step_text">03. 결제완료</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="pay_finish_center">
        결제가 정상적으로 완료 되었습니다.
        <span class="small_text"><?=$order['SENDER_NM']?> 고객님 주문번호는 <strong><?=$order_no?></strong> 입니다.</span>
    </div>
    <ul class="bullet_list bullet_list__line bullet_list__size">
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>결제수단으로 무통장입금(전용계좌) 또는 ARS 결제를 선택하셨다면 입금을 완료하셔야 최종적으로 주문이 처리가 됩니다.</li>
        <!--					<li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>배송 예정일 수정은 입금확인완료 상태에서만 가능합니다.(변경이 어려우시거나 도움이 필요하실 경우 에타 고객센터 1688-3256으로 문의해주세요.)</li>	-->
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>주문/배송과 관련하여 궁금하신 점이 있으시면 회원 로그인 후 마이페이지 > 활동 및 문의 > 1:1문의를 이용해 주세요.</li>
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>비회원 주문하셨다면 주문 내역은 비회원 로그인 후 마이페이지 > 주문/배송조회에서 확인하실 수 있습니다.</li>
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>본 주문 내용은 이메일을 통해 발송되었으며 마이페이지 &gt; 나의 쇼핑내역 &gt; 주문&#47;배송조회에서 확인하실 수 있습니다.</li>
    </ul>

    <h3 class="title_page title_page__large">정보입력</h3>
    <div class="info_input_check">
        <table class="normal_table normal_table__bg">
            <caption class="hide">정보입력</caption>
            <colgroup>
                <col style="width:180px" />
                <col style="width:419px" />
                <col style="width:179px" />
                <col />
            </colgroup>
            <tbody>
            <tr>
                <th sope="row">결제방식</th>
                <td><?=$order['ORDER_PAY_KIND_CD_NM']?></td>
                <th sope="row">총결제금액</th>
                <td><strong class="price"><?=number_format($order['PAY_AMT'])?><span class="won">원</span></strong> <span class="light">(포인트 <?=number_format($order['MILEAGE_AMT'])?>원 사용)</span></td>
            </tr>
            <? if($order['ORDER_PAY_KIND_CD'] == '02') {?>
                <tr>
                    <th sope="row">입금액</th>
                    <td><?=number_format($order['PAY_AMT'])?>원</td>
                    <th sope="row">입금기한</th>
                    <td><?=date("Y-m-d H:i:s", strtotime($order['DEPOSIT_DEADLINE_DY']))?></td>
                </tr>
                <tr>
                    <th sope="row">입금계좌</th>
                    <td><?=$order['BANK_NM']?> <?=$order['BANK_ACCOUNT_NO']?></td>
                    <th sope="row">예금주</th>
                    <td>(주)에타</td>
                </tr>
            <? }?>
            <? if($order['ORDER_PAY_KIND_CD'] == '08') {?>
                <tr>
                    <th sope="row">입금액</th>
                    <td><?=number_format($order['PAY_AMT'])?>원</td>
                    <th sope="row">결제유효기간</th>
                    <td><?=date("Y-m-d H:i:s", strtotime($order['VARS_EXPR_DT']))?></td>
                </tr>
                <tr>
                    <th sope="row">가상번호</th>
                    <td colspan="3"><?=preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $order['VARS_VNUM_NO'])?></td>
                </tr>
            <? }?>
            </tbody>
        </table>
    </div>
    <ul class="bullet_list bullet_list__size">
        <? if($order['ORDER_PAY_KIND_CD'] == '02') {?>
            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>입금계좌번호와 입금예정액이 주문내역과 일치하지 않을 경우 입금확인이 지연되며, 주문일 기준으로 3일차 자정까지 입금확인이 되지않은 경우 주문은 자동으로 최소됩니다.</li>
        <? }?>
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>무통장 입금 시 사용되는 가상계좌는 매주문시마다 새로운 계좌번호(개인전용)가 부여되며 해당 주문에만 유효합니다.</li>
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>ARS 결제 시 사용되는 가상번호는 매주문시마다 새로운 가상번호(개인전용)가 부여되며 해당 주문에만 유효합니다.</li>
        <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>다른 주문건에 대해 가상계좌로 입금하시거나 잘못된 계좌로 입금하시면 자동입금 확인이 되지않으며, 다른 계좌번호로 잘못 입금하신 경우에는 고객센터로 문의주시기 바랍니다.</li>
    </ul>

    <h3 class="title_page title_page__large">주문상품 내역</h3>
    <div class="board_list board_list_cartmodify board_list__finish">
        <table class="board_list_table" summary="주문상품 내역 입니다.">
            <caption>주문상품 내역</caption>
            <colgroup>
                <col width="160px" />
                <col width="*" />
                <col width="143px" />
                <col width="137px" />
                <col width="144px" />
                <col width="144px" />
                <col width="144px" />
            </colgroup>
            <thead>
            <tr>
                <th scope="col">
                    <span class="hide_text">상품이미지</span>
                </th>
                <th scope="col" class="th_goods_data">
                    <span class="th_text">상품정보</span>
                </th>
                <th scope="col">
                    <span class="th_text">수량</span>
                </th>
                <th scope="col">
                    <span class="th_text">상품금액</span>
                </th>
                <th scope="col">
                    <span class="th_text">할인금액</span>
                </th>
                <th scope="col">
                    <span class="th_text">할인금액적용</span>
                </th>
                <th scope="col">
                    <span class="th_text">배송비</span>
                </th>
            </tr>
            </thead>
            <tbody>
            <!-- Google Tag Manager Variable (eMnet) 2018.05.29-->
            <script>
                var bprice = '<?=$order['PAY_AMT']?>';
                var brandIds =[];
            </script>
            <!-- End Google Tag Manager Variable (eMnet) -->
            <?
            //var_dump($refer_data['GOODS_CD']);
            $cart_idx	= 0;
            foreach($refer as $goods_grp){
                $grp_yn = 'N';	//묶음상품여부
                foreach($goods_grp as $row){	?>
                    <tr>
                        <td class="image">
                            <img src="<?=$row['IMG_URL']?>" width=100 height=100 alt="상품 이미지" />
                        </td>
                        <td class="goods_detail__string">
                            <input type="hidden" name="goods_code[]" value="<?=$row['GOODS_CD']?>">
                            <input type="hidden" name="goods_name[]" value="<?=$row['GOODS_NM']?>">
                            <input type="hidden" name="goods_selling_price[]" value="<?=$row['SELLING_PRICE']?>">
                            <input type="hidden" name="goods_cnt[]" value="<?=$row['ORD_QTY']?>">
                            <p class="name"><?=$row['BRAND_NM']?></p>
                            <p class="description"><?=$row['GOODS_NM']?></p>
                            <p class="option"><?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<?}?></p>
                        </td>
                        <td class="quantity">
                            <?=$row['ORD_QTY']?>
                        </td>
                        <td class="price">
                            <p class="price_text"><?=number_format($row['TOTAL_PRICE'])?>원</p>
                        </td>
                        <td class="cupon">
                            <?=number_format($row['DC_AMT'])?>원
                        </td>
                        <td class="price">
                            <p><?=number_format($row['TOTAL_PRICE'] - $row['DC_AMT'])?>원</p>
                        </td>
                        <? if($grp_yn == 'N'){	?>
                            <td class="delivery_type" rowspan="<?=count($goods_grp)?>">
                                <? if($row['PATTERN_TYPE_CD'] == 'NONE'){	?>
                                    <p>착불배송</p>
                                <? } else {?>
                                    <p><?=number_format($row['DELIV_COST'])?>원</p>
                                <? }?>
                            </td>
                            <?
                            $grp_yn = 'Y';
                        }?>
                    </tr>
                    <!-- Google Tag Manager Add Value (eMnet) 2018.05.29-->
                    <script>
                        brandIds.push('<?=$row['GOODS_CD']?>');
                    </script>
                    <!-- End Google Tag Manager Add Value (eMnet) -->
                    <? $cart_idx ++;
                }
            }?>
            </tbody>
        </table>
    </div>

    <h3 class="title_page title_page__large">주문자/배송정보</h3>
    <table class="normal_table normal_table__bg">
        <caption class="hide">주문자/배송정보</caption>
        <colgroup>
            <col style="width:180px" />
            <col />
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
            <td>(<?=strlen($order['RECEIVER_ZIPCODE']) == 6 ? substr($order['RECEIVER_ZIPCODE'],0,3)."-".substr($order['RECEIVER_ZIPCODE'],3,3) : $order['RECEIVER_ZIPCODE']?>) <?=$order['RECEIVER_ADDR1']?> <?=$order['RECEIVER_ADDR2']?></td>
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
        </tbody>
    </table>
    <? if($order['LIVING_FLOOR_CD'] != ''){	?>
        <h3 class="title_page title_page__large">가구 배송정보</h3>

        <table class="normal_table normal_table__bg">
            <caption class="hide">가구 배송정보</caption>
            <colgroup>
                <col style="width:180px" />
                <col />
            </colgroup>
            <tbody>
            <tr>
                <th sope="row">주거층수</th>
                <? if($order['LIVING_FLOOR_CD'] == 'LOW'){	?>
                    <td>1~2층</td>
                <? }else if($order['LIVING_FLOOR_CD'] == 'HIGH'){	?>
                    <td>3층이상</td>
                <? }?>
            </tr>
            <tr>
                <th sope="row">계단폭</th>
                <? if($order['STEP_WIDTH_CD'] == 'LOW'){	?>
                    <td>2m 미만</td>
                <? }else if($order['STEP_WIDTH_CD'] == 'HIGH'){	?>
                    <td>2m 이상</td>
                <? }?>
            </tr>
            <tr>
                <th sope="row">엘리베이터</th>
                <? if($order['ELEVATOR_CD'] == 'SEVEN'){	?>
                    <td>1~7인승</td>
                <? }else if($order['ELEVATOR_CD'] == 'TEN'){	?>
                    <td>8~10인승</td>
                <? }else if($order['ELEVATOR_CD'] == 'ELEVEN'){	?>
                    <td>11인승 이상</td>
                <? }else if($order['ELEVATOR_CD'] == 'NONE'){	?>
                    <td>없음</td>
                <? }else if($order['ELEVATOR_CD'] == 'NOUSE'){	?>
                    <td>사용불가</td>
                <? }?>
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
            </tbody>
        </table>
    <? }?>

    <h3 class="title_page title_page__large">할인/주문금액 정보</h3>
    <div class="dc_order_info">
        <table class="normal_table normal_table__bg">
            <caption class="hide">할인/주문금액 정보</caption>
            <colgroup>
                <col style="width:180px" />
                <col />
            </colgroup>
            <tbody>
            <tr>
                <th sope="row">총 주문금액</th>
                <td><?=number_format($order['ORDER_AMT']+$order['DELIV_COST_AMT'])?>원 ( 착불배송비 제외, 상품금액 <?=number_format($order['ORDER_AMT'])?>원 + 배송비 : <?=number_format($order['DELIV_COST_AMT'])?>원)</td>
            </tr>
            <tr>
                <th sope="row" rowspan="2">할인/혜택</th>
                <td>쿠폰할인 : <?=number_format($order['DC_AMT'])?>원</td>
            </tr>

            <!--	<tr>
                        <th sope="row" rowspan="3">할인/혜택</th>
                        <td>가격할인 : 0원</td>
                    </tr>
                    <tr>
                        <td>쿠폰할인 : -27,000원</td>
                    </tr>		-->
            <tr>
                <td>포인트 : <?=number_format($order['MILEAGE_AMT'])?>원 사용</td>
            </tr>
            <tr>
                <th sope="row">최종결제금액</th>
                <td><strong class="price"><?=number_format($order['PAY_AMT'])?><span class="won">원</span></strong></td>
            </tr>
            </tbody>
        </table>

    </div>

    <?if(isset($order['RETURN_BANK_NM'])){?>
        <h3 class="title_page title_page__large">환불계좌정보</h3>
        <div class="dc_order_info">
            <table class="normal_table normal_table__bg">
                <caption class="hide">환불계좌정보 입력표</caption>
                <colgroup>
                    <col style="width:180px" />
                    <col />
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

    <ul class="btn_list pay_finish_btn">
        <li><button type="button" class="btn_positive" onClick="javascript:location.href = '/mywiz/order';">주문내역보기</button></li>
        <li><button type="button" class="btn_white" onClick="javascript:location.href = '/';">쇼핑계속하기</button></li>
    </ul>
</div>
<script>
    //google_gtag
    var purhase_array = new Object();

    <? $goods_array = array();
    foreach($refer as $goods_grp){
        $grp_yn = 'N';	//묶음상품여부
        foreach($goods_grp as $key => $row){
            $goods_array[$key]['id'       ] = $row['GOODS_CD'];
            $goods_array[$key]['name'     ] = $row['GOODS_NM'];
            $goods_array[$key]['list_name'] = 'purchase_list';
            $goods_array[$key]['quantity' ] = $row['ORD_QTY'];
            $goods_array[$key]['price'    ] = $row['TOTAL_PRICE'] - $row['DC_AMT'];

        }
        $goods_array = json_encode($goods_array);
    }?>

    purhase_array = <?=$goods_array?>;
    console.log(purhase_array);
    gtag('event', 'purchase', {
        "transaction_id": "<?=$order_no?>",
        "affiliation": "ETAH - Web",
        "value": <?=$order['PAY_AMT']?>,
        "currency": "KRW",
        "shipping": <?=$order['DELIV_COST_AMT']?>,
        "items": purhase_array
    });
</script>

<!-- WIDERPLANET PURCHASE SCRIPT START 2017.3.29 -->
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];

    //배열, 변수 생성
    var cartDataCnt		= "<?=$cart_idx?>";
    var cartItemsArray  = new Array();
    var cartItems		= new Object();

    for (var a=0; a<cartDataCnt; a++)
    {
        var cartItems	= new Object();

        cartItems.i	= document.getElementsByName("goods_code[]")[a].value;
        cartItems.t	= document.getElementsByName("goods_name[]")[a].value;
        cartItems.p	= document.getElementsByName("goods_selling_price[]")[a].value;
        cartItems.q	= document.getElementsByName("goods_cnt[]")[a].value;

        cartItemsArray.push(cartItems);
    }

    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",  	/*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
				 *주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",
                ty:"PurchaseComplete",
                device:"web"
                , items : cartItemsArray
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET PURCHASE SCRIPT END 2017.3.29 -->
