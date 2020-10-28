<!-- 2017-02-23 -->
<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
    var _nasa={};
    _nasa["cnv"] = wcs.cnv("3","1"); // 전환유형, 전환가치 설정해야함. 설치매뉴얼 참고
</script>


<link rel="stylesheet" href="/assets/css/cart_order.css?ver=1.2">

<div class="contents cart_page">
    <h2 class="page_title">장바구니</h2>

    <form name="buyForm" id="buyForm" method="post">
        <input type="hidden" name="order_gb"	id="order_gb"	 value="">		            <!-- 전체주문/선택주문/바로주문 구분 -->
        <input type="hidden" name="direct_code" id="direct_code" value="">		            <!-- 바로주문시 장바구니코드         -->
        <input type="hidden" name="direct_deli_price" id="direct_deli_price" value="">		<!-- 바로주문시 배송비              -->
        <input type="hidden" name="guest_gb"    id="guest_gb"   value="">                   <!-- 비회원주문시 로그인화면         -->

        <div class="myinfo">
            <div class="myinfo_greet">
                <span class="spr-cart icon_me"></span>
                <? if($this->session->userdata('EMS_U_ID_') != 'GUEST'  && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && $this->session->userdata('EMS_U_ID_')){	?>
                    <em class="bold"><?=$this->session->userdata('EMS_U_NAME_')?></em>님 혜택정보
                    <dl class="my_benefits">
                        <dt>마일리지 :</dt>
                        <dd><?=number_format($mileage)?>P</dd>
                        <dt>쿠폰 :</dt>
                        <dd><a href="/mywiz/coupon"><?=$mycoupon_cnt?>장</a></dd>
                    </dl>
                <? } else {?>
                    <em class="bold">비회원으로 구매중이십니다.</em>
                <? }?>
            </div>
            <div class="step_block">
                <ul class="step_list">
                    <li class="step_item active">
                        <span class="spr-cart icon_cart"></span>
                        <span class="step_text">01. 장바구니</span>
                        <span class="spr-cart arow_right"></span>
                    </li>
                    <li class="step_item">
                        <span class="spr-cart icon_write"></span>
                        <span class="step_text">02. 주문/결제</span>
                        <span class="spr-cart arow_right"></span>
                    </li>
                    <li class="step_item">
                        <span class="spr-cart icon_complete"></span>
                        <span class="step_text">03. 결제완료</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="board_list board_list_cartmodify">
            <table class="board_list_table" summary="장바구니에 담겨진 상품 리스트 입니다.">
                <caption>장바구니 상품 리스트</caption>
                <colgroup>
                    <col width="76px" />
                    <col width="105px" />
                    <col width="*" />
                    <col width="149px" />
                    <col width="110px" />
                    <col width="146px" />
                    <col width="132px" />
                    <col width="132px" />
                    <col width="132px" />
                </colgroup>
                <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" id="all_check" class="checkbox" onClick="javascript:jsChkAll(this.checked)"; checked/>
                        <label for="all_check" class="checkbox_label"><span class="hide">전체선택</span></label>
                    </th>
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
                        <span class="th_text">할인적용금액</span>
                    </th>
                    <th scope="col">
                        <span class="th_text">배송비</span>
                    </th>
                    <th scope="col">
                        <span class="th_text">주문하기</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <!-- Google Tag Manager Variable (eMnet) 2018.05.29-->
                <script>
                    var brandIds = [];
                </script>
                <!-- End Google Tag Manager Variable (eMnet) -->
                <?
                $cart_idx				= 0;	//장바구니 상품수 인덱스
                $idx2					= 0;	//묶음상품수 인덱스
                $total_goods_price		= 0;	//총 상품금액
                $total_cpn_price		= 0;	//총 할인금액
                $total_group_deli_price	= 0;	//총 배송비
                $goods_mileage_save		= 0;	//적립예정마일리지

                $group					= array_keys($cart);
                $group_str				= "";
                //var_dump($group);
                if(count($cart) != 0){
                foreach($cart as $cart_grp){
                    $group_goods = "N";		//묶음배송 여부
                    $group_deli_price	= 0;	//묶음상품 배송비
                    $group_code = $group[$idx2];
                    if($idx2 == 0){
                        $group_str	= $group[$idx2];
                    } else {
                        $group_str	.= "||".$group[$idx2];
                    }	?>
                <input type="hidden"	name="group_code[]"	value="<?=$group_code?>">
                <?	foreach($cart_grp as $row){ ?>
                    <tr>
                        <td class="goods_select">
                            <input type="checkbox" id="goods_select_<?=$cart_idx?>" name="chkGoods[]" class="checkbox" value="<?=$cart_idx?>||<?=$row['CART_NO']?>||<?=$row['DELI_CODE']?>" <? if($row['GOODS_STS_CD'] == 03 && $row['GOODS_OPTION_QTY'] != 0){?>checked<?}?>/>
                            <label for="goods_select_<?=$cart_idx?>" class="checkbox_label"><span class="hide">jacksonchameleon 선택</span></label>
                        </td>
                        <td class="image">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['GOODS_IMG']?>" alt="상품 이미지" width="100" height="100" /></a>
                        </td>
                        <td class="goods_detail__string">
                            <p class="name"><a href="/goods/detail/<?=$row['GOODS_CD']?>" style="color:#000"><?=$row['BRAND_NM']?></a></p>
                            <p class="description"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><? if($row['GOODS_STS_CD'] != 03){?><font style="color:red;">[<?=$row['GOODS_STS_CD_NM']?>]</font> <?}?><?=$row['GOODS_NM']?></a></p>
                            <p class="option"><?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? }?></p>
                            <? if($row['GOODS_OPTION_QTY'] == 0){?><p style="color:red;">-- 해당 옵션은 품절되었습니다.</p><? }?>
                            <p class="change_option">
                                <button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="#layer__cart_03_<?=$cart_idx?>">옵션변경</button>
                            </p>
                        </td>
                        <td class="quantity">
                            <div class="quantity_select">
                                <input type="text" class="quantity_input" name="goods_cnt[]" value="<?=$row['GOODS_CNT']?>" readonly/>
                                <input type="hidden" name="limit_cnt[]" value="<?=$row['BUY_LIMIT_QTY']?>" />

                                <button type="button" class="quantity_minus_btn" onClick="javascript:jsChangeNum(-1, <?=$cart_idx?>,'cart');">
                                    <span class="text">minus</span>
                                    <span class="spr-cart btn-minus"></span>
                                </button>
                                <button type="button" class="quantity_plus_btn" onClick="javascript:jsChangeNum(1, <?=$cart_idx?>,'cart');">
                                    <span class="text">plus</span>
                                    <span class="spr-cart btn-plus"></span>
                                </button>
                            </div>
                            <button type="button" class="btn_white btn_white__small" onClick="javascript:jsChgcart(<?=$row['CART_NO']?>,'CNT',<?=$cart_idx?>);">변경적용</button>
                        </td>
                        <td class="price">	<!-- 상품금액 -->
                            <p class="price_text"><?=number_format(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'])?>원</p>
                        </td>
                        <td class="cupon">	<!-- 할인금액 -->
                            <?
                            $seller_cpn_price	= 0;
                            $item_cpn_price	= 0;
                            if(isset($row['SELLER_COUPON_AMT'])){
                                if($row['SELLER_COUPON_AMT'] > $row['SELLER_COUPON_MAX'] && $row['SELLER_COUPON_MAX'] != 0){
                                    $seller_cpn_price += $row['SELLER_COUPON_MAX'] * $row['GOODS_CNT'];
                                    $total_cpn_price += $row['SELLER_COUPON_MAX'] * $row['GOODS_CNT'];
                                } else {
                                    $seller_cpn_price  += $row['SELLER_COUPON_AMT'] * $row['GOODS_CNT'];
                                    $total_cpn_price += $row['SELLER_COUPON_AMT'] * $row['GOODS_CNT'];
                                }
                            }
                            if(isset($row['ITEM_COUPON_AMT'])){
                                if($row['ITEM_COUPON_AMT'] > $row['ITEM_COUPON_MAX'] && $row['ITEM_COUPON_MAX'] != 0){
                                    $item_cpn_price	 += $row['ITEM_COUPON_MAX'] * $row['GOODS_CNT'];
                                    $total_cpn_price += $row['ITEM_COUPON_MAX'] * $row['GOODS_CNT'];
                                } else {
                                    $item_cpn_price	 += $row['ITEM_COUPON_AMT'] * $row['GOODS_CNT'];
                                    $total_cpn_price += $row['ITEM_COUPON_AMT'] * $row['GOODS_CNT'];
                                }
                            }
                            //$total_cpn_price += $row['COUPON_AMT'] * $row['GOODS_CNT'];	?>
                            <p class="price_text" name="discount_price<?=$cart_idx?>"><?=number_format(($seller_cpn_price + $item_cpn_price))?>원</p><br />
                            <button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="#layer__cart_02_<?=$cart_idx?>">쿠폰선택</button>
                        </td>
                        <td class="price">	<!-- 할인 금액 적용 -->
                            <? if(isset($row['SELLER_COUPON_CD']) || isset($row['ITEM_COUPON_CD'])){
//								$selling_price = ($row['COUPON_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'];	//쿠폰적용된가격은 배송비 계산에 x
//								$selling_price = ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE'] - ($seller_cpn_price + $item_cpn_price))  * $row['GOODS_CNT'];
                                $selling_price = ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE'])  * $row['GOODS_CNT'];
                                ?>
                                <p name="sale_price<?=$cart_idx?>"><?=number_format(($row['COUPON_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?>원</p>
                            <?	} else {
//								$selling_price = ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE'] - ($seller_cpn_price + $item_cpn_price))  * $row['GOODS_CNT'];
                                $selling_price = ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE'])  * $row['GOODS_CNT'];
                                ?>
                                <p name="sale_price<?=$cart_idx?>"><?=number_format(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE'] - $seller_cpn_price + $item_cpn_price) * $row['GOODS_CNT'])?>원</p>
                            <? }?>
                        </td>

                        <? if($group_goods == "N"){
                            $group_selling_price	    = 0;	//묶음 상품 가격 합
                            $group_selling_price_no_cou = 0;
                            $group_goods_cnt		    = 0;	//묶음 상품 총 갯수
                            $j = 0;
                            for($i=$cart_idx; $i<$cart_idx+count($cart_grp); $i++){
                                if(isset($cart_grp[$j]['SELLER_COUPON_CD']) || isset($cart_grp[$j]['ITEM_COUPON_CD'])){
                                    $group_selling_price += ($cart_grp[$j]['SELLING_PRICE'] + $cart_grp[$j]['GOODS_OPTION_ADD_PRICE']) * $cart_grp[$j]['GOODS_CNT'];
                                    $group_selling_price_no_cou += ($cart_grp[$j]['SELLING_PRICE'] + $cart_grp[$j]['GOODS_OPTION_ADD_PRICE'])  * $cart_grp[$j]['GOODS_CNT'];
                                } else {
                                    $group_selling_price += ($cart_grp[$j]['SELLING_PRICE'] + $cart_grp[$j]['GOODS_OPTION_ADD_PRICE']) * $cart_grp[$j]['GOODS_CNT'];
                                    $group_selling_price_no_cou += ($cart_grp[$j]['SELLING_PRICE'] + $cart_grp[$j]['GOODS_OPTION_ADD_PRICE'])  * $cart_grp[$j]['GOODS_CNT'];
                                }
                                $group_goods_cnt		 += $cart_grp[$j]['GOODS_CNT'];
                                $j++;
                            }
                            ?>
                            <input type="hidden" name="group_text[]" value="">
                            <td class="delivery_type" rowspan="<?=count($cart_grp)?>">	<!-- 배송비 -->
                                <?
                                //echo "group_selling_price - ".$group_selling_price."<br/>";
                                //echo "selling_price - ".$selling_price."<br/>";
                                ?>
                                <p><? if( $row['DELI_LIMIT'] == 0 || $row['DELI_LIMIT'] > $group_selling_price ) {	//묶음 배송비
                                        if($row['PATTERN_TYPE_CD'] == 'STATIC'){	//갯수대로 배송비 부과
                                            $group_deli_price += $row['DELI_COST']*$group_goods_cnt;?>
                                            <input type="hidden" id="group_delivery_price" name="group_delivery_price[]"	value="<?=$row['DELI_COST']*$group_goods_cnt?>">
                                            <span name="group_delivery[]"><?=number_format($row['DELI_COST']*$group_goods_cnt)."원"?></span>
                                        <?	} else if($row['PATTERN_TYPE_CD'] == 'PRICE'){	//가격조건
                                            $group_deli_price += $row['DELI_COST'];	?>
                                            <input type="hidden" id="group_delivery_price" name="group_delivery_price[]"	value="<?=$row['DELI_COST']?>">
                                            <span name="group_delivery[]"><?=number_format($row['DELI_COST'])."원"?></span>
                                        <?	} else if($row['PATTERN_TYPE_CD'] == 'FREE'){	//무료배송조건
                                            $group_deli_price += 0;	?>
                                            <input type="hidden" name="goods_delivery_price[]"	value="0">
                                            <span name="group_delivery[]">무료배송</span>
                                        <?	} else {	?>
                                            <input type="hidden" id="group_delivery_price" name="group_delivery_price[]"	value="0">
                                            <span name="group_delivery[]">착불배송</span>
                                        <?	}

                                    } else {	// 2018.03.26.
                                        // 배송비 오류 수정   ?>
                                        <input type="hidden" id="group_delivery_price" name="group_delivery_price[]"	value="0">
                                        <span name="group_delivery[]">착불배송</span>
                                    <? }?>
                                </p>

                                <? if( $row['DELI_LIMIT'] == 0 || $row['DELI_LIMIT']>$selling_price ){	//상품별 배송비
                                    if($row['PATTERN_TYPE_CD'] == 'STATIC'){	//갯수대로 배송비 부과	?>
                                        <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']*$row['GOODS_CNT']?>">
                                    <? } else if($row['PATTERN_TYPE_CD'] == 'PRICE'){	//가격조건	?>
                                        <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']?>">
                                    <? } else if($row['PATTERN_TYPE_CD'] == 'FREE'){	//무료배송조건	?>
                                        <input type="hidden" name="goods_delivery_price[]" value=0>
                                    <? } else {	?>
                                        <input type="hidden" name="goods_delivery_price[]" value=0>
                                    <?	}
                                } else {?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? }?>

                                <button type="button" class="btn_white btn_white__small" data-ui="layer-opener" data-target="#layer__cart_01_<?=$cart_idx?>">지역별 추가배송비</button>
                            </td>
                            <? $group_goods = "Y";
                        } else if($group_goods == "Y"){	//체크해제했을때 배송비를 어떻게 계산해주는지가 관건?>

                            <? if( $row['DELI_LIMIT'] == 0 || $row['DELI_LIMIT']>$selling_price ){	//상품별 배송비
                                if($row['PATTERN_TYPE_CD'] == 'STATIC'){	//갯수대로 배송비 부과	?>
                                    <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']*$row['GOODS_CNT']?>">
                                <? } else if($row['PATTERN_TYPE_CD'] == 'PRICE'){	//가격조건	?>
                                    <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']?>">
                                <? } else if($row['PATTERN_TYPE_CD'] == 'FREE'){	//무료배송조건	?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? } else {	?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <?		}
                            } else {?>
                                <input type="hidden" name="goods_delivery_price[]" value=0>
                            <?		}
                        }?>
                        <td class="order">
                            <p>
                                <button type="button" class="btn_black btn_black__small" onClick="javascript:jsStep2('Direct','<?=$cart_idx?>||<?=$row['CART_NO']?>',
                                        '<?=$row['DELI_COST']?>','<?=$cart_idx?>','<?=$selling_price?>', '<?=$group_goods_cnt?>');">바로주문</button>
                            </p>
                            <p>
                                <button type="button" class="btn_gray btn_gray__small" onClick="javascript:jsInterestGoods(<?=$row['GOODS_CD']?>);">관심상품</button>
                            </p>
                        </td>
                    </tr>
                    <!-- Google Tag Manager Add Value (eMnet) 2018.05.29-->
                    <script>
                        brandIds.push('<?=$row['GOODS_CD']?>');
                    </script>
                    <!-- End Google Tag Manager Add Value (eMnet) 2018.05.29-->

                <input type="hidden" name="cart_code[]"					value="<?=$row['CART_NO']?>">
                <input type="hidden" name="deli_code[]"					value="<?=$row['DELI_CODE']?>||<?=$group_deli_price?>">
                <input type="hidden" name="chk_deli_code[]"				value="<?=$row['DELI_CODE']?>||<?=$group_deli_price?>">	<!--선택상품 주문시 묶음배송비가 변경되면서 deli_code값도 변경되어서 생성 -->
                <input type="hidden" name="goods_code[]"				value="<?=$row['GOODS_CD']?>">
                <input type="hidden" name="goods_name[]"				value="<?=$row['GOODS_NM']?>">
                <input type="hidden" name="goods_state_code[]"			value="<?=$row['GOODS_STS_CD']?>">
                <input type="hidden" name="goods_cate_code1[]"			value="<?=$row['CATEGORY_MNG_CD1']?>">
                <input type="hidden" name="goods_cate_code2[]"			value="<?=$row['CATEGORY_MNG_CD2']?>">
                <input type="hidden" name="goods_cate_code3[]"			value="<?=$row['CATEGORY_MNG_CD3']?>">
                <input type="hidden" name="brand_code[]"				value="<?=$row['BRAND_CD']?>">
                <input type="hidden" name="brand_name[]"				value="<?=$row['BRAND_NM']?>">
                <input type="hidden" name="goods_option_code[]"			value="<?=$row['GOODS_OPTION_CD']?>">
                <input type="hidden" name="goods_option_name[]"			value="<?=$row['GOODS_OPTION_NM']?>">
                <input type="hidden" name="goods_option_add_price[]"	value="<?=$row['GOODS_OPTION_ADD_PRICE']?>">
                <input type="hidden" name="goods_option_qty[]"			value="<?=$row['GOODS_OPTION_QTY']?>">	<!--잔여수량-->
                <input type="hidden" name="goods_img[]"					value="<?=$row['GOODS_IMG']?>">
                <input type="hidden" name="goods_price_code[]"			value="<?=$row['GOODS_PRICE_CD']?>">
                <input type="hidden" name="goods_selling_price[]"		value="<?=$row['SELLING_PRICE']?>">     <!--판매가-->
                <input type="hidden" name="goods_street_price[]"		value="<?=$row['STREET_PRICE']?>">      <!--시중가-->
                <input type="hidden" name="goods_factory_price[]"		value="<?=$row['FACTORY_PRICE']?>">     <!--공급가-->
                <input type="hidden" name="goods_discount_price[]"	value="<?=($seller_cpn_price+$item_cpn_price)/$row['GOODS_CNT']?>">
                <input type="hidden" name="goods_mileage_save_rate[]"	value="<?=$row['GOODS_MILEAGE_SAVE_RATE']?>">
                <input type="hidden" name="goods_coupon_code_s[]"		value="<?=isset($row['SELLER_COUPON_CD']) ? $row['SELLER_COUPON_CD'] : ""?>">	<!--할인쿠폰코드(셀러)           -->
                <input type="hidden" name="goods_coupon_amt_s[]"		value="<?=$seller_cpn_price/$row['GOODS_CNT']?>">	                            <!--쿠폰할인적용금액(셀러쿠폰)   -->
                <input type="hidden" name="goods_coupon_code_i[]"		value="<?=isset($row['ITEM_COUPON_CD']) ? $row['ITEM_COUPON_CD'] : ""?>">		<!--할인쿠폰코드(아이템)         -->
                <input type="hidden" name="goods_coupon_amt_i[]"		value="<?=$item_cpn_price/$row['GOODS_CNT']?>">		                            <!--쿠폰할인적용금액(아이템쿠폰) -->
                                                                                                                                                           <!--					<input type="hidden" name="goods_coupon_num[]"		value="">	                                <!--    할인쿠폰번호          -->
                <input type="hidden" name="goods_add_coupon_no[]"		value="">	                            <!--    추가할인쿠폰넘버      -->
                <input type="hidden" name="goods_add_coupon_code[]"		value="">	                            <!--    추가할인쿠폰코드      -->
                <input type="hidden" name="goods_add_coupon_num[]"		value="">	                            <!--    추가할인쿠폰번호      -->
                <input type="hidden" name="goods_add_coupon_type[]"		value="">	                            <!--    추가할인쿠폰 지급방식 -->
                <input type="hidden" name="goods_add_coupon_gubun[]"	value="">	                            <!--    추가할인쿠폰 구분     -->
                <input type="hidden" name="goods_add_discount_price[]"	value=0>	                            <!--    추가할인쿠폰적용금액  -->
                <input type="hidden" name="deli_policy_no[]"			value="<?=$row['DELIV_POLICY_NO']?>">
                <input type="hidden" name="deli_cost[]"					value="<?=$row['DELI_COST']?>">	        <!--    개별 배송비           -->
                <input type="hidden" name="deli_limit[]"				value="<?=$row['DELI_LIMIT']?>">
                <input type="hidden" name="deli_pattern[]"				value="<?=$row['PATTERN_TYPE_CD']?>">
                <input type="hidden" name="send_nation[]"				value="<?=$row['SEND_NATION']?>">	    <!--    출고국가              -->
                <input type="hidden" name="goods_buy_limit_qty[]"		value="<?=$row['BUY_LIMIT_QTY']?>">    <!--    구매제한 수량          -->
                <input type="hidden" name="goods_tax_gb_cd[]"           value="<?=$row['TAX_GB_CD']?>">        <!--    과세 구분              -->

                                                                                                               <!--2018.03.28 추가
                                                                                                                   인덱스당 현재 상품가격, 묶음상품 총 가격-->
                <input type="hidden" name="idx_price[]"				    value="<?=$selling_price?>">
                <input type="hidden" name="idxs_price[]"				value="<?=$group_selling_price_no_cou?>">

                <?	$total_goods_price	+= (($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT']);
                $goods_mileage_save	+= ($row['SELLING_PRICE']*$row['GOODS_CNT']) * ($row['GOODS_MILEAGE_SAVE_RATE']/1000);	//적립예정마일리지
                $cart_idx++;
                }
                $total_group_deli_price += $group_deli_price;
                $idx2++;
                }
                } else {?>
                    <tr>
                        <td class="goods_select" colspan="9">장바구니에 담긴 상품이 없습니다.</td>
                    </tr>
                <? }?>
                </tbody>
            </table>
        </div>

        <div class="select_action">
            <button type="button" class="btn_white btn_white__small" onClick="javascript:jsDelGoods()";>선택삭제</button>
            <p class="select_action_description" style="left">
                상품페이지에서 쿠폰 선택 적용하신 경우, 장바구니에서 다시 한번 적용해주시면 고맙겠습니다.
            </p>
        </div>

        <div class="payment_schedule_cost">
            <div class="inner total_payment">
                <dl class="payment_data">
                    <dt>총 상품금액</dt>
                    <dd><span name="total_goods_price"><?=number_format($total_goods_price)?></span><span class="won">원</span></dd>
                </dl>
                <dl class="payment_data_option">
                    <dt>상품금액</dt>
                    <dd><span name="total_goods_price"><?=number_format($total_goods_price)?></span><span class="won">원</span></dd>
                </dl>
                <span class="spr-cart icon_minus"></span>
            </div>
            <div class="inner total_discount">
                <dl class="payment_data">
                    <dt>총 할인금액</dt>
                    <dd><span name="total_discount_price"><?=number_format($total_cpn_price)?></span><span class="won">원</span></dd>
                </dl>

                <span class="spr-cart icon_plus"></span>
            </div>
            <div class="inner total_delivery_payment">
                <dl class="payment_data">
                    <dt>총 배송비</dt>
                    <dd><span name="total_delivery_price"><?=number_format($total_group_deli_price)?></span><span class="won">원</span></dd>
                </dl>
                <dl class="payment_data_option">
                    <dt>배송비</dt>
                    <dd><span name="total_delivery_price"><?=number_format($total_group_deli_price)?></span>원 (선불)</dd>
                </dl>
                <span class="spr-cart icon_equal"></span>
            </div>
            <div class="inner total">
                <dl class="payment_data payment_data__point">
                    <dt>결제예정금액</dt>
                    <dd><span name="payment_price"><?=number_format($total_goods_price - $total_cpn_price + $total_group_deli_price)?></span><span class="won">원</span></dd>
                </dl>
                <dl class="payment_data_option">
                    <dt>적립예정 마일리지</dt>
                    <dd><span name="goods_save_mileage"><?=number_format($goods_mileage_save)?></span><span class="won"> P</span></dd>
                </dl>
            </div>
        </div>

        <div class="order_btn_area">
            <button type="button" class="btn_positive btn_positive__min" onClick="javascript:jsStep2('All','');">전체상품주문</button>
            <button type="button" class="btn_negative btn_positive__min" onClick="javascript:jsStep2('Choice','');">선택상품주문</button>
            <button type="button" class="btn_white btn_white__large btn_positive__min" onClick="javascript:location.href = '/';">쇼핑계속하기</button>
        </div>

        <input type="hidden" value="<?=$ENABLE?>" name="np_enable_yn" id="np_enable_yn">
        <div class="naverpay" style="margin-top:-70px;">
            <script type="text/javascript" src="https://pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
            <script type="text/javascript" >
                naver.NaverPayButton.apply({
                    BUTTON_KEY: "CC68CEA7-3129-4153-8D29-BE38810016E1", // 페이에서 제공받은 버튼 인증 키 입력
                    TYPE: "A", // 버튼 모음 종류 설정
                    COLOR: 1, // 버튼 모음의 색 설정
                    COUNT: 1, // 버튼 개수 설정. 구매하기 버튼만 있으면 1, 찜하기 버튼도 있으면 2를 입력.
                    ENABLE: "<?=$ENABLE?>", // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 "N" 입력
                    BUY_BUTTON_HANDLER: jsNaverPay, // 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
                    "":""
                });


                function jsNaverPay() {
                    if(document.getElementsByName("cart_code[]").length < 1){
                        alert("장바구니에 담긴 상품이 없습니다.");
                        return false;
                    }

                    if($("#np_enable_yn").val() == 'N'){
                        alert('네이버페이를 통한 구매가 불가한 상품입니다.');
                        return false;
                    }

                    if($("input[name='chkGoods[]']").is(':checked') == false){
                        alert("선택하신 상품이 없습니다. 상품을 선택해주세요.");
                        return false;
                    }

                    var order_yn = 'Y';

                    $("input:checkbox[name='chkGoods[]']:checked").each(function() {	    // 체크된 것만 값을 뽑아서 배열에 push
                        var idx = $(this).val().split("||")[0];

                        if(document.getElementsByName("goods_state_code[]")[idx].value != "03"){	//판매중인 상품이 아니면
                            alert("선택한 상품중 판매가 불가능한 상품이 있습니다.");
                            order_yn = 'N';
                            return false;
                        }

                        if(document.getElementsByName("goods_option_qty[]")[idx].value == 0){	//옵션품절
                            alert("선택한 상품중 옵션이 품절된 상품이 있습니다.");
                            order_yn = 'N';
                            return false;
                        }
                    });

                    if(order_yn == 'Y'){
                        document.getElementById("order_gb").value = "NP";
                    } else {
                        return false;
                    }

                    var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                    var frm = document.getElementById("buyForm");
                    frm.action = "https://"+SSL_val+"/order/naver_pay";
                    frm.submit();

                }
            </script>
        </div>
        <? if($recommend_goods){		?>
            <h3 class="title_page">장바구니 연관상품</h3>
            <div class="basic_goods_list basic_goods_list__cart">
                <ul class="goods_list">
                    <? foreach($recommend_goods as $row2){	?>
                        <li class="goods_item">
                            <div class="img">
                                <a href="/goods/detail/<?=$row2['GOODS_CD']?>" class="img_link"><img src="<?=$row2['IMG_URL']?>" alt=""></a>
                                <ul class="goods_action_menu">
                                    <!--	<li class="goods_action_item">
                                            <button type="button" class="action_btn">
                                                <span class="spr-common spr_cart"></span>
                                                <span class="spr-common spr-bgcircle2"></span>
                                                <span class="button_text">Add Cart</span>
                                            </button>
                                        </li>		-->
                                    <li class="goods_action_item">
                                        <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('W','<?=$row2['GOODS_CD']?>','','');">
                                            <span class="spr-common spr-heart2"></span>
                                            <span class="spr-common spr-bgcircle2"></span>
                                            <span class="button_text">Add wish list</span>
                                        </button>
                                    </li>
                                    <li class="goods_action_item goods_action_sns">
                                        <button type="button" class="action_btn action_btn__sns">
                                            <span class="spr-common spr_share"></span>
                                            <span class="spr-common spr-bgcircle2"></span>
                                            <span class="button_text">share</span>
                                        </button>
                                        <ul class="goods_sns_list">
                                            <li class="goods_sns_item">
                                                <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','P','<?=$row2['IMG_URL']?>','<?=$row2['GOODS_NM']?>');">
                                                    <span class="spr-common spr_share_pinter"></span>
                                                    <span class="spr-common spr-bgcircle3"></span>
                                                    <span class="button_text">핀터레스트</span>
                                                </button>
                                            </li>
                                            <li class="goods_sns_item">
                                                <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','K','','<?=$row2['GOODS_NM']?>');">
                                                    <span class="spr-common spr_share_kakao"></span>
                                                    <span class="spr-common spr-bgcircle3"></span>
                                                    <span class="button_text">카카오스토리</span>
                                                </button>
                                            </li>
                                            <!--			<li class="goods_sns_item">
                                                            <button type="button" class="action_btn" onClick="javaScript:jsGoodsAction('S','I','','');">
                                                                <span class="spr-common spr_share_insta"></span>
                                                                <span class="spr-common spr-bgcircle3"></span>
                                                                <span class="button_text">인스타</span>
                                                            </button>
                                                        </li>	-->
                                            <li class="goods_sns_item">
                                                <button type="button" onClick="javaScript:jsGoodsAction('S','F','','');" class="action_btn">
                                                    <span class="spr-common spr_share_facebook"></span>
                                                    <span class="spr-common spr-bgcircle3"></span>
                                                    <span class="button_text">페이스북</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                            </div>
                            <a href="#" class="goods_item_link">
						<span class="brand">
							<?=$row2['BRAND_NM']?>
						</span>
                                <span class="name"><a href="/goods/detail/<?=$row2['GOODS_CD']?>"><?=$row2['GOODS_NM']?></a></span>
                                <span class="price"><?=number_format($row2['SELLING_PRICE'])?></span>
                            </a>
                        </li>
                    <? }	?>
                </ul>
            </div>
        <? }?>

        <h3 class="title_page title_page__line">장바구니 이용안내</h3>
        <ul class="bullet_list">
            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>업체별로 배송비가 다를 수 있으며, 자세한 내용은 상품상세페이지의 설명을 참조하시기 바랍니다.</li>
            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>장바구니의 총 예상 결제금액은 쿠폰 및 기타할인, 배송정보가 확정되지 않은 예정 가격으로 실제 최종 결제금액과 차이가 있을 수 있습니다.</li>
        </ul>
    </form>
</div>

<?	if(count($cart) != 0){
    $idx = 0;
    foreach($cart as $cart_grp){
        foreach($cart_grp as $row){
            $seller_coupon_max	= isset($row['SELLER_COUPON_MAX']) ? $row['SELLER_COUPON_MAX'] : 0;
            $item_coupon_max	= isset($row['ITEM_COUPON_MAX']) ? $row['ITEM_COUPON_MAX'] : 0;
            $seller_coupon_amt	= isset($row['SELLER_COUPON_AMT']) ? $row['SELLER_COUPON_AMT'] : 0;
            $item_coupon_amt	= isset($row['ITEM_COUPON_AMT']) ? $row['ITEM_COUPON_AMT'] : 0;

            if($seller_coupon_amt > $seller_coupon_max && $seller_coupon_max != 0){
                $seller_coupon_amt	= $seller_coupon_max * $row['GOODS_CNT'];
            } else {
                $seller_coupon_amt	= $seller_coupon_amt * $row['GOODS_CNT'];
            }

            if($item_coupon_amt > $item_coupon_max && $item_coupon_max != 0){
                $item_coupon_amt	= $item_coupon_max * $row['GOODS_CNT'];
            } else {
                $item_coupon_amt	= $item_coupon_amt * $row['GOODS_CNT'];
            }

//				$goods_price = ($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'] - ($seller_coupon_amt + $item_coupon_amt)*$row['GOODS_CNT'];	// 추가 쿠폰 금액 계산을 위해 상품할인금액을 뺀다	2016-07-20 수정
            $goods_price = $row['SELLING_PRICE']*$row['GOODS_CNT'];
            ?>

            <!-- 쿠폰 적용하기 레이어 // -->
            <div class="layer layer__cart_02" id="layer__cart_02_<?=$idx?>">
                <div class="layer_inner">
                    <h1 class="layer_title">쿠폰 적용하기</h1>
                    <div class="layer_cont">
                        <div class="table_basic_type table_basic_type__side_none_border">
                            <table>
                                <caption>적용가능한 쿠폰 테이블 리스트에서 쿠폰을 선택</caption>
                                <colgroup>
                                    <col width="100px" />
                                    <col width="260px" />
                                    <col width="*" />
                                </colgroup>
                                <thead>
                                <tr>
                                    <th scope="col">할인구분</th>
                                    <th scope="col">쿠폰명</th>
                                    <th scope="col">할인액</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="">
                                        <p>판매자할인</p>
                                    </td>
                                    <td>
                                        <div class="radio_block">
                                            <? $idx2 = 0;
                                            if($row['AUTO_COUPON_LIST']){
                                                foreach($row['AUTO_COUPON_LIST'] as $row2)	{
                                                    if($row2['COUPON_KIND_CD'] == 'SELLER'){

                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods_price) : floor($row2['COUPON_SALE']*$row['GOODS_CNT']);

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                        ?>
                                                        <input type="radio" name="coupon_select_S<?=$idx?>" class="radio" id="coupon_1_1"  value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=($row2['COUPON_PRICE']/$row['GOODS_CNT'])?>||<?=$row2['MAX_DISCOUNT']?>" checked>
                                                        <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액 -->

                                                        <label for="coupon_1_1" class="radio_label">
                                                            <span class="coupon_name"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?></span>
                                                            <span class="coupon_info"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                        </label>
                                                        <?  $coupon_S_text = $row2['MAX_DISCOUNT'] < ($row2['COUPON_PRICE']/$row['GOODS_CNT']) && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']*$row['GOODS_CNT']) : number_format($row2['COUPON_PRICE']);
                                                        $idx2++;
                                                    }//END IF
                                                    else if($row2['COUPON_KIND_CD'] != 'GOODS' || count($row['AUTO_COUPON_LIST']) == 1){	?>
                                                        <p>적용 가능한 쿠폰이 없습니다.</p>
                                                        <?
                                                        $coupon_S_text = 0;
                                                    }
                                                }//END FOREACH
                                            }//END IF
                                            else {	?>
                                                <p>적용 가능한 쿠폰이 없습니다.</p>
                                                <?
                                                $coupon_S_text = 0;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                                    <input type="hidden"	name="seller_coupon_cnt[]"			value="<?=$idx2?>">
                                    <td>
                                        <?=$coupon_S_text?><span class="won">원</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">
                                        <p>에타할인</p>
                                    </td>
                                    <td>
                                        <div class="radio_block">
                                            <? $idx2 = 0;
                                            $ITEM_COUPON_YN = '';
                                            $coupon_E_text = 0;
                                            if($row['AUTO_COUPON_LIST'] || $row['CUST_COUPON_LIST']){
                                                foreach($row['AUTO_COUPON_LIST'] as $row2)	{
                                                    if($row2['COUPON_KIND_CD'] == 'GOODS'){

                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods_price) : floor($row2['COUPON_SALE']*$row['GOODS_CNT']);

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                        ?>
                                                        <p>
                                                            <input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=($row2['COUPON_PRICE']/$row['GOODS_CNT'])?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_I" checked>
                                                            <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||아이템쿠폰|| -->

                                                            <label for="coupon_E<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                                <span class="coupon_name" id="coupon_name_E<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?></span>
                                                                <span class="coupon_info"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                            </label>
                                                            <?	$coupon_E_text = $row2['MAX_DISCOUNT'] < ($row2['COUPON_PRICE']/$row['GOODS_CNT']) && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']*$row['GOODS_CNT']) : number_format($row2['COUPON_PRICE']);	//COUPON_PRICE에 이미 CNT가격포함
                                                            ?>
                                                        </p>
                                                        <?		$ITEM_COUPON_YN = 'Y';
                                                        $idx2++;
                                                    }
                                                }	//END FOREACH
                                                foreach($row['CUST_COUPON_LIST'] as $row2)	{
                                                    if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'N' && $row2['MIN_AMT'] < (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])){
                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods_price : $row2['COUPON_SALE']*$row['GOODS_CNT'];

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환

                                                        ?>
                                                        <p>
                                                            <input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']/$row['GOODS_CNT']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_B||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                            <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||바이어쿠폰||쿠폰지급방식||중복여부||쿠폰구분 -->

                                                            <label for="coupon_E<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                                <span class="coupon_name" id="coupon_name_E<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?></span>
                                                                <span class="coupon_info"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                            </label>
                                                            <? if(!$row['AUTO_COUPON_LIST']){
                                                                $coupon_E_text = 0;
                                                            }?>
                                                        </p>
                                                        <?
                                                        if($ITEM_COUPON_YN == ''){
                                                            $ITEM_COUPON_YN = 'N';
                                                        }

                                                        $idx2++;
                                                    }
                                                }	//END FOREACH

                                                if(($row['AUTO_COUPON_LIST'] && ($row['AUTO_COUPON_LIST'][0]['COUPON_KIND_CD'] == 'GOODS') || (@$row['AUTO_COUPON_LIST'][1]['COUPON_KIND_CD'] == 'GOODS')) || $row['CUST_COUPON_LIST']){
                                                    ?>
                                                    <p>
                                                        <input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('EN',this.value,<?=$idx?>,<?=$idx2?>);"<?if($ITEM_COUPON_YN == 'N'){?>checked<?}?>>
                                                        <label for="coupon_E<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                            <span class="coupon_name">쿠폰 적용 안함</span>
                                                        </label>
                                                    </p>
                                                    <?
                                                } else {	?>
                                                    <p>적용 가능한 쿠폰이 없습니다.</p>
                                                    <?			$coupon_E_text = 0;
                                                }

                                            }	//END IF
                                            else {	?>
                                                <p>적용 가능한 쿠폰이 없습니다.</p>
                                                <?
                                                $coupon_E_text = 0;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                                    <input type="hidden"	name="item_coupon_cnt[]"			value="<?=$idx2?>">
                                    <td>
                                        <span name="coupon_E_text<?=$idx?>"><?=$coupon_E_text?></span><span class="won">원</span>
                                    </td>
                                </tr>
                                <tr id="dup_coupon_<?=$idx?>">
                                    <td class="">
                                        <p>에타중복할인</p>
                                    </td>
                                    <td>
                                        <div class="radio_block">

                                            <? $idx2 = 0;
                                            if($row['CUST_COUPON_LIST']){
                                                foreach($row['CUST_COUPON_LIST'] as $row2)	{
                                                    if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'Y' && $row2['MIN_AMT'] < (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])){	//최소금액 이상일때 보임

                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods_price : $row2['COUPON_SALE']*$row['GOODS_CNT'];

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                        ?>
                                                        <p>
                                                            <input type="radio" name="coupon_select_C<?=$idx?>" class="radio" id="coupon_C<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('C',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']/$row['GOODS_CNT']?>||<?=$row2['MAX_DISCOUNT'] ? $row2['MAX_DISCOUNT'] : 0?>||<?=$row2['COUPON_DTL_NO']?>||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                            <?// var_dump($row2['GUBUN']);?>
                                                            <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||쿠폰번호||쿠폰지급방식||중복여부||쿠폰구분-->
                                                            <label for="coupon_C<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                                <!--	<span class="coupon_name">쿠폰이름3 10%(또는 1,000원) 할인</span>-->
                                                                <span class="coupon_name" id="coupon_name_C<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?></span>
                                                                <span class="coupon_info"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                            </label>
                                                        </p>
                                                        <? $idx2++;
                                                    }	//END IF
                                                } //END FOREACH

                                                if($idx2>0){	//최소금액 이상일때 보임?>
                                                    <p>
                                                        <input type="radio" name="coupon_select_C<?=$idx?>" class="radio" id="coupon_C<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('CN',this.value,<?=$idx?>,<?=$idx2?>);" checked>
                                                        <label for="coupon_C<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                            <span class="coupon_name">쿠폰 적용 안함</span>
                                                        </label>
                                                    </p>
                                                <? } else {	?>
                                                    <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                                    <p>적용 가능한 쿠폰이 없습니다.</p>
                                                <? } ?>
                                                <?
                                                $coupon_C_text = 0;
                                            } //END IF
                                            else {?>
                                                <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                                <p>적용 가능한 쿠폰이 없습니다.</p>
                                                <?
                                                $coupon_C_text = 0;
                                            } ?>
                                        </div>
                                    </td>
                                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 추가쿠폰이 몇개인지 알려주는 변수 -->
                                    <input type="hidden"	name="add_coupon_cnt[]"			value="<?=$idx2?>">
                                    <td>
                                        <span name="coupon_C_text<?=$idx?>"><?=$coupon_C_text?></span><span class="won">원</span>
                                    </td>
                                </tr>
                                <!-- seller & item value :: 쿠폰코드||쿠폰명||할인금액||최대할인금액)
                                     cust value :: 쿠폰코드||쿠폰명||할인금액||최대할인금액||쿠폰번호||쿠폰지급방식||중복여부)	-->
                                <input type="hidden" name="goods_seller_coupon_<?=$idx?>"		value="">
                                <input type="hidden" name="goods_item_coupon_<?=$idx?>"		value="">
                                <input type="hidden" name="goods_cust_coupon_<?=$idx?>"		value="">
                                <tr class="total_coupon_payment">
                                    <th scope="row" colspan="2">
                                        쿠폰할인 총액
                                    </th>
                                    <td>
                                        <span name="coupon_total_amt_<?=$idx?>"><?=number_format(($seller_coupon_amt+$item_coupon_amt))?></span><span class="won">원</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <ul class="bullet_list">
                            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>할인쿠폰은 판매가 기준으로 할인율 적용됩니다.</li>
                        </ul>
                    </div>
                    <ul class="btn_list">
                        <li><button type="button" class="btn_positive" onClick="javascript:Coupon_apply(<?=$idx?>);">쿠폰적용</button></li>
                        <li><button type="button" class="btn_negative" onClick="javascript:jsReset(<?=$idx?>,'CPN');">적용취소</button></li>
                    </ul>
                    <a href="" onClick="javascript:jsReset(<?=$idx?>,'CPN');" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
                </div>
                <div class="dimd"></div>
            </div>
            <!-- // 쿠폰 적용하기 레이어 -->

            <!-- 옵션변경 레이어 // -->
            <div class="layer layer__cart_03" id="layer__cart_03_<?=$idx?>">
                <div class="layer_inner">
                    <h1 class="layer_title layer_title__line">옵션변경</h1>
                    <div class="layer_cont">
                        <div class="board_list">
                            <input type="hidden"	name="dup_option" value="N">		<!-- 중복 옵션 선택 여부-->
                            <table class="board_list_table option_change_table" summary="주문상품 내역 입니다.">
                                <caption>주문상품 내역</caption>
                                <colgroup>
                                    <col width="120px" />
                                    <col width="*" />
                                    <col width="139px" />
                                </colgroup>
                                <tbody>
                                <tr>
                                    <td>
                                        <img src="<?=$row['GOODS_IMG']?>" width="100" height="100" alt="상품 이미지" />
                                    </td>
                                    <td colspan="2" class="goods_detail__string">
                                        <p class="name"><?=$row['BRAND_NM']?></p>
                                        <p class="description"><?=$row['GOODS_NM']?></p>
                                        <p class="price"><?=number_format($row['SELLING_PRICE'])."원"?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        상품옵션선택
                                    </td>
                                    <td colspan="2">
                                        <span class="select">선택1</span>
                                        <div class="select_wrap" style="width:217px;">
                                            <label for="moption1">선택1</label>
                                            <select name="moption1[]" id="moption1" style="width:217px;" onChange="javascript:jsValiOption(this.value,this.options[this.selectedIndex].text,<?=$idx?>)";>
                                                <? foreach($row['GOODS_OPTION'] as $row2){	?>
                                                    <option value="<?=$row2['GOODS_OPTION_CD']?>||<?=$row2['GOODS_OPTION_ADD_PRICE']?>||<?=$row2['QTY']?>" <?if($row['GOODS_OPTION_CD'] == $row2['GOODS_OPTION_CD']){?>selected<?}?>><?=$row2['GOODS_OPTION_NM']?> <? if($row2['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row2['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<? } if($row2['QTY'] == 0){?> [품절] <?}?></option>
                                                <? }?>
                                            </select>
                                        </div>
                                        <span name="duplicate_option[]"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="goods_option">
                                        [<?=$row['BRAND_NM']?>] <span class="name"><?=$row['GOODS_NM']?></span>
                                        <span class="color" name="chk_option_name[]"><?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? }?></span>
                                    </td>
                                    <td class="quantity">
                                        <div class="quantity_select">
                                            <input type="text" readonly class="quantity_input" name="option_cnt[]" value="<?=$row['GOODS_CNT']?>" />
                                            <button type="button" class="quantity_minus_btn" onClick="javascript:jsChangeNum(-1, <?=$idx?>,'option');">
                                                <span class="text">minus</span>
                                                <span class="spr-cart btn-minus"></span>
                                            </button>
                                            <button type="button" class="quantity_plus_btn" onClick="javascript:jsChangeNum(1, <?=$idx?>,'option');">
                                                <span class="text">plus</span>
                                                <span class="spr-cart btn-plus"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>총 주문금액</th>
                                    <td colspan="2" class="price"><span name="total_option_price[]"><?=number_format(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'])?></span>
                                        <span class="won">원</span>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <ul class="btn_list">
                        <li><button type="button" class="btn_positive" onClick="javascript:jsChgcart(<?=$row['CART_NO']?>,'OPT',<?=$idx?>);">옵션변경</button></li>
                        <li><button type="button" class="btn_negative" onClick="javascript:jsReset(<?=$idx?>,'OPT');">변경취소</button></li>
                    </ul>
                    <a href="" onClick="javascript:jsReset(<?=$idx?>,'OPT');" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
                </div>
                <div class="dimd"></div>
            </div>
            <!-- // 옵션변경 레이어 -->

            <?	 $idx ++;
        }
    }
}?>


<?	if(count($cart) != 0){
    $idx = 0;
    foreach($cart as $cart_grp){
        foreach($cart_grp as $row){
            ?>
            <!-- 지역별 추가 배송비 확인 레이어 // -->
            <div class="layer layer__cart_01" id="layer__cart_01_<?=$idx?>">
                <div class="layer_inner">
                    <h1 class="layer_title layer_title__line">지역별 추가 배송비 확인</h1>
                    <div class="layer_cont">
                        <div class="table_basic_type table_basic_type__side_none_border">
                            <table>
                                <caption>제품에 따른 추가 배송비 안내</caption>
                                <colgroup>
                                    <col width="50%" />
                                    <col width="*" />
                                </colgroup>
                                <thead>
                                <tr>
                                    <th scope="col">상품정보</th>
                                    <th scope="col">지역별 추가 배송비</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="goods_detail">
                                        <p class="name"><?=$row['BRAND_NM']?></p>
                                        <p class="description"><?=$row['GOODS_NM']?></p>
                                        <? if(count($cart_grp) != 1){	?>
                                            <p class="shiping_info">외 <?=count($cart_grp)-1?>개의 상품</p>
                                        <? }?>
                                    </td>
                                    <td>
                                        <?// if($row['ADD_DELIVERY']){
                                        //	foreach($row['ADD_DELIVERY'] as $row2){	?>
                                        <!--	<p class="shiping_info"><?=$row2['DELIV_AREA_NM']?>(선불/수량별배송비부과)</p>
										<p class="shiping_payment">배송비 <?=number_format($row2['ADD_DELIV_COST'])?>원</p>
										<br />	-->
                                        <?//	}
                                        //}?>
                                        <p class="shiping_info">제주도 및 도서산간지역 추가 운임 발생 가능<br>(수도권 외 지역 추가운임은 상품페이지 내 설명 참조)</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <ul class="bullet_list">
                            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>상품별로 배송비 및 추가배송비가 다르게 적용됩니다.</li>
                            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>택배사를 통해 배송되는 상품의 경우, 지역별 추가운임을 상품 페이지 내 설명에서 꼭 확인해주십시오.</li>
                            <li class="bullet_item"><span class="spr-common spr_bg_dot02"></span>업체직접배송 또는 설치배송 상품의 경우, 사전에 고객님께 연락을 하고 배송 및 설치를 진행하는 과정에서 추가배송비를 확인하실 수 있으며, 일정 기간 내 연락 부재 시 1:1문의 또는 고객센터로 문의하여 주십시오.</li>
                        </ul>
                    </div>

                    <a href="#layer__cart_01_<?=$idx?>" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
                </div>
                <div class="dimd"></div>
            </div>
            <!-- // 지역별 추가 배송비 확인 레이어 -->
            <?	$idx ++;
        }
    }
}?>
<script src="/assets/js2/cart_coupon.js"></script>
<script type="text/javascript">

    //===============================================================
    // 쿠폰 관련 함수는 /assets/js2/cart_coupon.js 참고
    //===============================================================
    var cart_cnt = "<?=$cart_idx?>";
    var total_sale_price = 0;


    //===============================================================
    //총 금액 재계산
    //===============================================================
    var total_sum_price = function()
    {
        var total_goods_price			= 0;
        var total_discount_price		= 0;	//가격할인
        var total_discount_coupon		= 0;	//쿠폰할인
        var total_mileage_save_price	= 0;	//적립예정 마일리지
        var total_delivery_price		= 0;	//묶음배송비 합계
        var group_cnt					= "<?=count($group)?>";	//장바구니에 들어있는 상품의 배송정책종류 갯수
        var delivery_price				= [];	//묶음배송비 배열

        for(i=0; i<group_cnt; i++){
            delivery_price[i] = 0;

            eval("var selling_price_"+i+" = 0");	//묶음상품비 가변 변수 생성
        }

        if($("input:checkbox[name='chkGoods[]']:checked").val() == undefined){		//체크된 값이 없을 경우
            $('span[name=total_goods_price]').text('0');
            $('span[name=total_discount_price]').text('0');
            $('span[name=total_delivery_price]').text('0');
            $('span[name=payment_price]').text('0');
        } else {
            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	    // 체크된 것만 값을 뽑아서 배열에 push
                var idx = $(this).val().split("||")[0];				                //상품 인덱스
                var deli_code	= $(this).val().split("||")[2];		                //상품 배송정책코드
                var str			= "<?=$group_str?>";				                //장바구니에 들어있는 상품의 배송정책코드 문자열
                var group		= str.split("||");


                //상품 금액 변경
                total_goods_price += (parseInt($($("input[name='goods_selling_price[]']").get(idx)).val()) +
                    parseInt($($("input[name='goods_option_add_price[]']").get(idx)).val())) * parseInt($($("input[name='goods_cnt[]']").get(idx)).val());

                //할인 금액 변경
                total_discount_price += parseInt($($("input[name='goods_discount_price[]']").get(idx)).val())* parseInt($($("input[name='goods_cnt[]']").get(idx)).val());	//상품기본할인
                total_discount_coupon += parseInt($($("input[name='goods_add_discount_price[]']").get(idx)).val());	//추가할인

                //적립예정 마일리지 금액
                total_mileage_save_price += parseInt($($("input[name='goods_selling_price[]']").get(idx)).val()) *
                    parseInt($($("input[name='goods_cnt[]']").get(idx)).val()) * ((parseInt($($("input[name='goods_mileage_save_rate[]']").get(idx)).val()))/1000);

                //배송비 금액 변경
                for(i=0; i<group_cnt; i++){		//계산
                    if(group[i] == deli_code){
                        //2018.08.23 할인가 기준으로 변경 황승업
//					 eval("selling_price_"+i+" += " +
//                         "( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value)  " +
//                         "- parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)) " +
//                         "* parseInt(document.getElementsByName('goods_cnt[]')[idx].value)");
                        //2018.09.17 판매가 기준으로 변경 황승업
                        eval("selling_price_"+i+" += " +
                            "( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value)  " +
                            " - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)) " +
                            "* parseInt(document.getElementsByName('goods_cnt[]')[idx].value)");
                        if(document.getElementsByName("group_text[]")[i].value == ''){
                            document.getElementsByName("group_text[]")[i].value = 'N';
                        } else if(document.getElementsByName("group_text[]")[i].value == 'N'){
                            document.getElementsByName("group_text[]")[i].value = 'Y';
                        }
                        if(document.getElementsByName("deli_limit[]")[idx].value == 0 || document.getElementsByName("deli_limit[]")[idx].value > eval("selling_price_"+i)){
                            if(document.getElementsByName("deli_pattern[]")[idx].value == 'STATIC'){
                                delivery_price[i] += parseInt(document.getElementsByName("deli_cost[]")[idx].value*document.getElementsByName("goods_cnt[]")[idx].value);
                            } else if(document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE'){
                                delivery_price[i] = parseInt(document.getElementsByName("deli_cost[]")[idx].value);
                            } else if(document.getElementsByName("deli_pattern[]")[idx].value == 'FREE'){
                                delivery_price[i] = 0;
                            } else {
                                delivery_price[i] = 0;
                            }
                        } else {
                            delivery_price[i] = 0;
                        }
                    }
                }
            });

            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	//묶음상품 배송비 value를 deli_code에 넣기 위해
                var idx = $(this).val().split("||")[0];
                var deli_code	= $(this).val().split("||")[2];
                var str			= "<?=$group_str?>";				//장바구니에 들어있는 상품의 배송정책코드 문자열
                var group		= str.split("||");

                for(i=0; i<group_cnt; i++){
                    if(group[i] == deli_code){
                        $($("input[name='deli_code[]']").get(idx)).val(deli_code+"||"+delivery_price[i]);
                        $($("input[name='chk_deli_code[]']").get(idx)).val(deli_code+"||"+delivery_price[i]);
                    }
                }
            });

            //2018.03.28 배송비 오류 수정.
            for(i=0; i<group_cnt; i++){		//배송비 표시하기 위해
                total_delivery_price += delivery_price[i];
                var group_text = '';

                if(document.getElementsByName("group_text[]")[i].value == 'Y'){
                    group_text = '(묶음)';
                } else {
                    group_text = '';
                }
                if(delivery_price[i] == 0){
                    $($("span[name='group_delivery[]']").get(i)).text('무료배송 '+group_text);

                    var group_deli_code = $($("input[name='group_code[]']").get(i)).val().split("||")[0];

                    for(j=0; j<document.getElementsByName("goods_code[]").length; j++){
                        if(group_deli_code.split("_")[1] == document.getElementsByName("deli_policy_no[]")[j].value){
                            if(document.getElementsByName("deli_pattern[]")[j].value == 'NONE'){
                                $($("span[name='group_delivery[]']").get(i)).text('착불배송');

                            } else if(document.getElementsByName("deli_pattern[]")[j].value == 'FREE'){
                                $($("span[name='group_delivery[]']").get(i)).text('무료배송');

                            }else if(document.getElementsByName("deli_pattern[]")[j].value == 'STATIC'){
                                var co = document.getElementsByName("deli_cost[]")[j].value;
                                var ct = document.getElementsByName("goods_cnt[]")[j].value;
                                $($("span[name='group_delivery[]']").get(i)).text(numberFormat(co * ct) + "원");

                            }else if(document.getElementsByName("deli_pattern[]")[j].value == 'PRICE') {

                                if (parseInt(document.getElementsByName("deli_limit[]")[j].value) == 0) {
                                    $($("span[name='group_delivery[]']").get(i)).text(numberFormat(document.getElementsByName("deli_cost[]")[j].value) + "원");
                                }
                            }
                            if(document.getElementsByName("deli_pattern[]")[j].value == 'PRICE' && parseInt(document.getElementsByName("deli_limit[]")[j].value) != 0){
                                //2018.08.23 할인가 기준으로 변경 황승업
                                //var pr = (document.getElementsByName("goods_selling_price[]")[j].value - document.getElementsByName("goods_discount_price[]")[j].value) * document.getElementsByName("goods_cnt[]")[j].value;
                                //2018.09.17 판매가 기준으로 변경 황승업
                                if(parseInt(document.getElementsByName("deli_limit[]")[j].value) < parseInt(document.getElementsByName("idxs_price[]")[j].value)){
                                    $($("span[name='group_delivery[]']").get(i)).text('무료배송'+group_text);
                                }else if(parseInt(document.getElementsByName("deli_limit[]")[j].value) > parseInt(document.getElementsByName("idxs_price[]")[j].value)){
                                    $($("span[name='group_delivery[]']").get(i)).text(numberFormat(document.getElementsByName("deli_cost[]")[j].value) + "원");
                                }else {
                                    $($("span[name='group_delivery[]']").get(i)).text('무료배송'+group_text);
                                }
                            }
                        }
                    }
                } else {
                    $($("span[name='group_delivery[]']").get(i)).text(numberFormat(delivery_price[i])+"원");	//배송비 입력 변경
                }
                document.getElementsByName("group_text[]")[i].value = '';	//변수 초기화해야 체크해제하고 다시 체크해도 맞음
            }
            $('span[name=total_goods_price]').text(numberFormat(total_goods_price));
            $('span[name=total_discount_price]').text(numberFormat(total_discount_price+total_discount_coupon));
            $('span[name=total_delivery_price]').text(numberFormat(total_delivery_price));
            $('span[name=payment_price]').text(numberFormat(total_goods_price-total_discount_price-total_discount_coupon+total_delivery_price));

            $('span[name=goods_save_mileage]').text(numberFormat(total_mileage_save_price));
        }

    }

    //===============================================================
    // 체크박스 전체선택/해제
    //===============================================================
    function jsChkAll(pBool){
        for (var i=0; i<document.getElementsByName("chkGoods[]").length; i++){
            document.getElementsByName("chkGoods[]")[i].checked = pBool;
        }

        total_sum_price();	//총 금액 재계산
    }

    //===============================================================
    // 체크한 상품들만 금액 재계산
    //===============================================================
    $(function(){
        $("input:checkbox[name='chkGoods[]']").on('click', function(e) {
            total_sum_price();	//총 금액 재계산
        })
    })

    //===============================================================
    // 레이어 초기화
    //===============================================================
    function jsReset(idx,gb){
        if(gb == 'OPT'){
            $($("span[name='chk_option_name[]']").get(idx)).text(document.getElementsByName("goods_option_name[]")[idx].value);
            document.getElementsByName("moption1[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;
            document.getElementsByName("option_cnt[]")[idx].value = document.getElementsByName("goods_cnt[]")[idx].value;
            $("input[name=dup_option]").val('N');
            $($("span[name='duplicate_option[]']").get(idx)).html('');
            document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(document.getElementsByName("goods_option_add_price[]")[idx].value)) * parseInt(document.getElementsByName("goods_cnt[]")[idx].value));

            $("#layer__cart_03_"+idx).attr('class','layer layer__cart_03');	//레이어 닫기
        } else if(gb == 'CPN'){
            var total_coupon_price	= parseInt(document.getElementsByName("goods_discount_price[]")[idx].value)*parseInt($($("input[name='goods_cnt[]']").get(idx)).val());
            var item_coupon_max		= parseInt(0);
            var item_coupon_amt		= parseInt(0);
            var item_coupon_checked_id	= '';
            var item_coupon_checked_tid = '';
            var item_coupon_checked_name = '';
            var cust_coupon_max		= parseInt(0);
            var cust_coupon_amt		= parseInt(0);

            for(var i=0; i<cart_cnt; i++){
                if(i == idx){
                    var goods_cnt	= parseInt($($("input[name='goods_cnt[]']").get(idx)).val());	//상품갯수

                    if($($("input[name='item_coupon_cnt[]']").get(idx)).val() > 0){
                        for(k=0; k<document.getElementsByName("coupon_select_E"+i).length; k++){
                            document.getElementsByName("coupon_select_E"+i)[k].checked = false;
                        }

                        for(var j=0; j<$($("input[name='item_coupon_cnt[]']").get(i)).val(); j++){
                            if($($("input[name='goods_coupon_code_i[]']").get(idx)).val() == $("#coupon_E"+i+"_"+j).val().split("||")[0]){
                                $("#coupon_E"+i+"_"+j).prop('checked', true);
                                $("#coupon_E"+i+"_"+j).prop('disabled', false);
                                $("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);

                                item_coupon_max	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[3]);
                                item_coupon_amt	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[2]);
                                item_coupon_kind	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[4]);

                                if(item_coupon_kind	== 'COUPON_B'){
                                    if( item_coupon_max < (item_coupon_amt*goods_cnt) && item_coupon_max != 0){
                                        item_coupon_amt = item_coupon_max;
                                    } else {
                                        item_coupon_amt = item_coupon_amt*goods_cnt;
                                    }
                                } else {
                                    if( item_coupon_max < (item_coupon_amt) && item_coupon_max != 0){
                                        item_coupon_amt = item_coupon_max*goods_cnt;
                                    } else {
                                        item_coupon_amt = item_coupon_amt*goods_cnt;
                                    }

                                }
                                $("span[name=coupon_E_text"+i+"]").text(numberFormat(item_coupon_amt));

                                $("#dup_coupon_"+idx).show();
                                break;
                            } else if($($("input[name='goods_coupon_code_i[]']").get(idx)).val() == ""){	//아이템쿠폰 사용안함
                                if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == ''){	//고객쿠폰쪽도 비어있을경우
                                    $("input[name='coupon_select_E"+idx+"']:input[value='']").prop('checked', true);

                                    $("span[name=coupon_E_text"+i+"]").text(0);

                                    $("#dup_coupon_"+idx).show();
                                    break;
                                } else {	//고객쿠폰이 있음

                                    if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == $("#coupon_E"+i+"_"+j).val().split("||")[0]){
                                        $("#coupon_E"+i+"_"+j).prop('checked', true);
                                        $("#coupon_E"+i+"_"+j).prop('disabled', false);
                                        $("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);

                                        item_coupon_max	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[3]);
                                        item_coupon_amt	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[2]);
                                        if( item_coupon_max < (item_coupon_amt*goods_cnt) && item_coupon_max != 0){
                                            item_coupon_amt = item_coupon_max;
                                        } else {
                                            item_coupon_amt = item_coupon_amt*goods_cnt;
                                        }
                                        $("span[name=coupon_E_text"+i+"]").text(numberFormat(item_coupon_amt));

                                        total_coupon_price += item_coupon_amt;

                                        $("#dup_coupon_"+idx).hide();
                                        break;
                                    } else if(j==$($("input[name='item_coupon_cnt[]']").get(i)).val()-1) {	//아이템쿠폰의 고객쿠폰은 아님
                                        $("input[name='coupon_select_E"+idx+"']:input[value='']").prop('checked', true);
                                        $("span[name=coupon_E_text"+i+"]").text(0);

                                        $("#dup_coupon_"+idx).show();
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if($($("input[name='add_coupon_cnt[]']").get(idx)).val() > 0){	//에타중복쿠폰 하나라도 있을경우 체크재점검
                        for(k=0; k<document.getElementsByName("coupon_select_C"+i).length; k++){
                            document.getElementsByName("coupon_select_C"+i)[k].checked = false;
                        }

                        for(var j=0; j<$($("input[name='add_coupon_cnt[]']").get(i)).val(); j++){
                            if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == $("#coupon_C"+i+"_"+j).val().split("||")[0]){
                                $("#coupon_C"+i+"_"+j).prop('checked', true);
                                cust_coupon_max	= parseInt($("#coupon_C"+i+"_"+j).val().split("||")[3]);
                                cust_coupon_amt	= parseInt($("#coupon_C"+i+"_"+j).val().split("||")[2]);
                                if( cust_coupon_max < (cust_coupon_amt*goods_cnt) && cust_coupon_max != 0){
//                                    cust_coupon_amt = cust_coupon_max*goods_cnt;
                                    cust_coupon_amt = cust_coupon_max;
                                } else {
                                    cust_coupon_amt = cust_coupon_amt*goods_cnt;
                                }
                                total_coupon_price += cust_coupon_amt;

                                break;
                            } else if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == ""){	//중복쿠폰사용x
                                $("input[name='coupon_select_C"+idx+"']:input[value='']").prop('checked', true);
                                break;
                            }
                        }	//END FOR
                    }
                }	//END if
            }	//END for

            $("span[name='coupon_C_text"+idx+"']").text(numberFormat(cust_coupon_amt));	//할인액 재계산
            $("span[name='coupon_total_amt_"+idx+"']").text(numberFormat(total_coupon_price));		//총 재계산
            $("#layer__cart_02_"+idx).attr('class','layer layer__cart_02');			//레이어 닫기
        }	//END else if
    }	//END function

    //===============================================================
    // 수량 숫자 증가/감소 버튼
    //===============================================================
    function jsChangeNum(num, idx, gb){
        var frm = document.buyForm;
        if(gb == 'cart'){
            var limit_cnt = parseInt(document.getElementsByName("limit_cnt[]")[idx].value);
            if(limit_cnt == parseInt(document.getElementsByName("goods_cnt[]")[idx].value) && num == 1){
                alert('1회 최대 구매수는 '+limit_cnt+' 개 입니다');
                return false;
            }
            var cnt = parseInt(document.getElementsByName("goods_cnt[]")[idx].value) + parseInt(num);

        } else if(gb == 'option'){
            var limit_cnt = parseInt(document.getElementsByName("limit_cnt[]")[idx].value);
            if(limit_cnt == parseInt(document.getElementsByName("option_cnt[]")[idx].value) && num == 1){
                alert('1회 최대 구매수는 '+limit_cnt+' 개 입니다');
                return false;
            }
            var cnt = parseInt(document.getElementsByName("option_cnt[]")[idx].value) + parseInt(num);
        }

        if(cnt<1){
            cnt = 1;
        }

        if(gb == 'cart'){
            if(document.getElementsByName("goods_option_qty[]")[idx].value < cnt){
                alert("현재 주문가능한 재고수량은 "+document.getElementsByName("goods_option_qty[]")[idx].value+"개 입니다.\n"+document.getElementsByName("goods_option_qty[]")[idx].value+"개 이하로 주문해 주세요.");
                return false;
            }

            document.getElementsByName("goods_cnt[]")[idx].value = cnt;
        } else if(gb == 'option'){
            if(document.getElementsByName("moption1[]")[idx].value.split("||")[2] < cnt){
                alert("현재 주문가능한 재고수량은 "+document.getElementsByName("moption1[]")[idx].value.split("||")[2]+"개 입니다.\n"+document.getElementsByName("moption1[]")[idx].value.split("||")[2]+"개 이하로 주문해 주세요.");
                return false;
            }

            document.getElementsByName("option_cnt[]")[idx].value = cnt;
            var add_option_price = document.getElementsByName("moption1[]")[idx].value.split("||")[1];

            document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(add_option_price)) * parseInt(cnt));
        }

    }

    //===============================================================
    // 천단위 콤마
    //===============================================================
    function numberFormat(num) {
        num = String(num);
        return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,"$1,");
    }

    //===============================================================
    // 천단위 콤마 제거
    //===============================================================
    function renumberFormat(num){
        return num.replace(/^\$|,/g, "") + ""
    }

    //===============================================================
    // 장바구니 선택항목에서 제거
    //===============================================================
    function jsDelGoods(){
        var cartArr = [];
        var cartItemsArray = [];

        $("input:checkbox[name='chkGoods[]']:checked").each(function() {
            cartArr.push($(this).val().split("||")[1]);

        });

        if(cartArr.length == 0){
            alertDelay("삭제할 상품을 선택해주세요.");
            return false;
        }


        for (var a=0; a<cartArr.length; a++)
        {
            var cartItems	= new Object();

            cartItems.id	= cartArr[a];

            cartItemsArray.push(cartItems);
        }

        //google_gtag
        gtag('event', 'remove_from_cart', {
            "items": [
                {
                    "id": cartItemsArray
                }
            ]
        });

        setTimeout(function() {
            if(confirm("선택한 상품을 장바구니에서 제거하시겠습니까?")){
                $.ajax({
                    type: 'POST',
                    url: '/cart/del_cart',
                    async: false,
                    dataType: 'json',
                    data: { chkGoods : cartArr },
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            alert('선택한 상품이 장바구니에서 제거됐습니다.');
                            location.reload();
                        }
                        else alert(res.message);
                    }
                })
            }
        },150);
    }

    //===============================================================
    // 장바구니 수량/옵션 변경
    //===============================================================
    function jsChgcart(cart_no, gb, idx){
        if($("input[name=dup_option]").val() == 'Y'){
            alert("해당 옵션상품은 이미 장바구니에 담겨져있습니다. \n다른 옵션을 선택해주세요.");
            return false;
        }

        setTimeout(function() {
            if (confirm("수량이나 옵션을 변경하게 되면 쿠폰을 다시 재선택하셔야 합니다.")) {
                var option_code = document.getElementsByName("moption1[]")[idx].value;
                if (gb == 'CNT') {
                    var Chgcnt = document.getElementsByName("goods_cnt[]")[idx].value;
                } else if (gb == 'OPT') {
                    var Chgcnt = document.getElementsByName("option_cnt[]")[idx].value;
//			option_code = document.getElementsByName("moption1[]")[idx].value;
                }

                $.ajax({
                    type: 'POST',
                    url: '/cart/chg_cart',
                    dataType: 'json',
                    data: {cart_no: cart_no, gb: gb, cnt: Chgcnt, option_code: option_code},
                    error: function (res) {
                        alert('Database Error');
                    },
                    success: function (res) {
                        if (res.status == 'ok') {
                            location.reload();
                        }
                        else alert(res.message);
                    }
                })
            }
        },150);
    }

    //===============================================================
    // 옵션 선택 값 비교
    //===============================================================
    function jsValiOption(option_value,option_name,idx){
        if(option_value.split("||")[2] == 0){
            alert("해당 옵션은 품절입니다. 다른 옵션을 선택해주세요.");

            $($("span[name='chk_option_name[]']").get(idx)).text(document.getElementsByName("goods_option_name[]")[idx].value);
            document.getElementsByName("moption1[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;

            document.getElementsByName("option_cnt[]")[idx].value = document.getElementsByName("goods_cnt[]")[idx].value;
            $("input[name=dup_option]").val('N');
            $($("span[name='duplicate_option[]']").get(idx)).html('');
            document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(document.getElementsByName("goods_option_add_price[]")[idx].value)) * parseInt(document.getElementsByName("goods_cnt[]")[idx].value));

            return false;
        }

        document.getElementsByName("option_cnt[]")[idx].value = 1;	//옵션 선택할 경우 수량 1개로 초기화

        $($("span[name='duplicate_option[]']").get(idx)).html("");
        $("input[name=dup_option]").val('N');	//중복옵션선택 비교값

        var option_code = option_value.split("||")[0];
        var add_option_price = option_value.split("||")[1];

        for(var i=0; i<cart_cnt; i++){
            if(i != idx){
                if(document.getElementsByName("goods_option_code[]")[i].value == option_code){
                    $($("span[name='duplicate_option[]']").get(idx)).html("<font style='color:red'>이미 선택한 옵션입니다.</font>");
                    $("input[name=dup_option]").val('Y');
                    break;
                }
            }
        }
        $($("span[name='chk_option_name[]']").get(idx)).text(option_name);

        var cnt = document.getElementsByName("option_cnt[]")[idx].value;		//옵션선택수량
        document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(add_option_price)) * parseInt(cnt));	//선택한 옵션금액 재계산
    }

    //===============================================================
    // 관심상품 등록
    //===============================================================
    function jsInterestGoods(goods_code){
        var cust_no = "<?=$this->session->userdata('EMS_U_NO_')?>";
        $.ajax({
            type: 'POST',
            url: '/cart/reg_interest',
            dataType: 'json',
            data: { cust_no : cust_no, goods_cd : goods_code },
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    if(confirm("관심상품 등록이 완료됐습니다. 관심상품 페이지로 이동하시겠습니까?")){
                        location.href = '/mywiz/interest';
                    }
                }
                else alert(res.message);
            }
        })
    }


    //===============================================================
    // 주문/결제 페이지 이동
    //===============================================================
    function jsStep2(gb,cart_no,price, num, sell_price, goods_cnt){
        if(document.getElementsByName("cart_code[]").length < 1){
            alertDelay("장바구니에 담긴 상품이 없습니다.");
            return false;
        }

        if(gb == 'All'){	//전체 상품 주문시
            for(var i=0; i<document.getElementsByName("goods_state_code[]").length; i++){
                if(document.getElementsByName("goods_state_code[]")[i].value != "03"){
                    alertDelay("판매가 불가능한 상품이 포함되어 있습니다. 삭제후 주문해주세요.");
                    return false;
                }
                if(document.getElementsByName("goods_option_qty[]")[i].value == 0){
                    alertDelay("옵션이 품절된 상품이 포함되어 있습니다. 삭제후 주문해주세요.");
                    return false;
                }
            }

            document.getElementById("order_gb").value = "A";
        } else if(gb == 'Choice'){	//선택 상품 주문시
            var order_yn = 'Y';

            if($("input[name='chkGoods[]']").is(':checked') == false){
                alertDelay("선택하신 상품이 없습니다. 상품을 선택해주세요.");
                return false;
            }

            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	    // 체크된 것만 값을 뽑아서 배열에 push
                var idx = $(this).val().split("||")[0];

                if(document.getElementsByName("goods_state_code[]")[idx].value != "03"){	//판매중인 상품이 아니면
                    alertDelay("선택한 상품중 판매가 불가능한 상품이 있습니다.");
                    order_yn = 'N';
                    return false;
                }

                if(document.getElementsByName("goods_option_qty[]")[idx].value == 0){	//옵션품절
                    alertDelay("선택한 상품중 옵션이 품절된 상품이 있습니다.");
                    order_yn = 'N';
                    return false;
                }
            });

            if(order_yn == 'Y'){
                document.getElementById("order_gb").value = "C";
            } else {
                return false;
            }

        } else if(gb == 'Direct'){	//바로 상품 주문시
            document.getElementById("order_gb").value = "D";
            document.getElementById("direct_code").value = cart_no;

            //바로구매 배송비가격
            if(document.getElementsByName("deli_pattern[]")[num].value == 'PRICE'){

                var li = document.getElementsByName("deli_limit[]")[num].value;
                document.getElementById("direct_deli_price").value = price;

                if(parseInt(sell_price) > parseInt(li)){
                    document.getElementById("direct_deli_price").value = 0;
                }
                if(li == 0){
                    document.getElementById("direct_deli_price").value = price;
                }

            }else  if(document.getElementsByName("deli_pattern[]")[num].value == 'STATIC'){
                document.getElementById("direct_deli_price").value = price * goods_cnt;
            }else{
                document.getElementById("direct_deli_price").value = price;
            }
        }

        var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";

        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){	//로그인 안한 경우
            document.getElementById("guest_gb").value = "direct";
        }

        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        var frm = document.getElementById("buyForm");


        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){	//로그인 안한 경우
            frm.action = "https://"+SSL_val+"/member/Guestlogin";
            frm.submit();
        } else {
            frm.action = "https://"+SSL_val+"/cart/OrderInfo";
            frm.submit();
        }

        return true;
    }

    total_sum_price();
</script>


<!-- WIDERPLANET  SCRIPT START 2017.3.29 -->
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
        cartItemsArray.push(cartItems);
    }
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",  	/*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
				 *주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",
                ty:"Cart",
                device:"web"
                , items : cartItemsArray
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET  SCRIPT END 2017.3.29 -->
