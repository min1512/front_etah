<?
$seller_coupon_amt = 0;
if(isset($goods['SELLER_COUPON_CD'])){
    if($goods['SELLER_COUPON_METHOD'] == 'RATE'){
        $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods['SELLER_COUPON_FLAT_RATE']/1000);
    } else if($goods['SELLER_COUPON_METHOD'] == 'AMT'){
        $seller_coupon_amt = $goods['SELLER_COUPON_FLAT_RATE'];
    }

    if($seller_coupon_amt > $goods['SELLER_COUPON_MAX_DISCOUNT'] && $goods['SELLER_COUPON_MAX_DISCOUNT'] != 0){
        $seller_coupon_amt = $goods['SELLER_COUPON_MAX_DISCOUNT'];
    }
}

$item_coupon_amt = 0;
if(isset($goods['ITEM_COUPON_CD'])){
    if($goods['ITEM_COUPON_METHOD'] == 'RATE'){
        $item_coupon_amt = $goods['SELLING_PRICE'] * ($goods['ITEM_COUPON_FLAT_RATE']/100);
    } else if($goods['ITEM_COUPON_METHOD'] == 'AMT'){
        $item_coupon_amt = $goods['ITEM_COUPON_FLAT_RATE'];
    }

    if($item_coupon_amt > $goods['ITEM_COUPON_MAX_DISCOUNT'] && $goods['ITEM_COUPON_MAX_DISCOUNT'] != 0){
        $item_coupon_amt = $goods['ITEM_COUPON_MAX_DISCOUNT'];
    }
}
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
                            <? $idx2 = 0;
                            if($AUTO_COUPON_LIST){
                                foreach($AUTO_COUPON_LIST as $row)	{
                                    if($row['COUPON_KIND_CD'] == 'SELLER'){
                                        $row['COUPON_PRICE'] = $row['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($goods['SELLING_PRICE'] * $row['COUPON_SALE']/100) : $row['COUPON_SALE'];

                                        $row = str_replace("\"","&ldquo;",$row);		//큰따옴표 치환
                                        ?>
                                        <div class="radio_block">
                                            <input type="radio" name="coupon_select_S<?=$idx?>" class="radio" id="coupon_1_1" value="<?=$row['COUPON_CD']?>||<?=$row['WEB_DISP_DC_COUPON_NM'] == '' ? $row['DC_COUPON_NM'] : $row['WEB_DISP_DC_COUPON_NM']?>||<?=$row['COUPON_PRICE']?>||<?=$row['MAX_DISCOUNT']?>"  checked>
                                            <label for="coupon_1_1" class="radio_label">
                                                <!--<span class="coupon_name">브랜드쿠폰 3% (또는 300원) 할인</span>-->
                                                <span class="coupon_name"><?=$row['WEB_DISP_DC_COUPON_NM'] == '' ? $row['DC_COUPON_NM'] : $row['WEB_DISP_DC_COUPON_NM']?></span>
                                                <span class="coupon_info"><?=$row['COUPON_DC_METHOD_CD'] == 'RATE' ? $row['COUPON_SALE'].'%' : number_format($row['COUPON_SALE']).'원'?>할인 <?=$row['MAX_DISCOUNT'] ? "(최대 ".number_format($row['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                            </label>
                                        </div>
                                        <?	$coupon_S_text = $row['MAX_DISCOUNT'] < $row['COUPON_PRICE'] && $row['MAX_DISCOUNT'] != 0 ? number_format($row['MAX_DISCOUNT']) : number_format($row['COUPON_PRICE']);
                                        $idx2++;
                                    }	//END IF
                                    else if($row['COUPON_KIND_CD'] != 'GOODS' || count($AUTO_COUPON_LIST) == 1){	?>
                                        <p>적용 가능한 쿠폰이 없습니다.</p>
                                        <?
                                        $coupon_S_text = 0;
                                    }
                                }	//END FOREACH
                            }
                            else {	?>
                                <p>적용 가능한 쿠폰이 없습니다.</p>
                                <?
                                $coupon_S_text = 0;
                            }
                            ?>
                        </td>
                        <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                        <input type="hidden"	name="seller_coupon_cnt[]"			value="<?=$idx2?>">
                        <td>
                            <span name="coupon_S_text<?=$idx?>"><?=$coupon_S_text?></span><span class="won">원</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <p>에타홈 할인</p>
                        </td>
                        <td>
                            <div class="radio_block">
                                <? $idx2 = 0;
                                $ITEM_COUPON_YN = '';
                                $coupon_E_text = 0;
                                if($AUTO_COUPON_LIST || $CUST_COUPON_LIST){
                                    foreach($AUTO_COUPON_LIST as $row2)	{
                                        if($row2['COUPON_KIND_CD'] == 'GOODS'){

                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods['SELLING_PRICE']) : $row2['COUPON_SALE'];

                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                            ?>
                                            <p>
                                                <input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_I" checked>
                                                <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||아이템쿠폰|| -->

                                                <label for="coupon_E<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                    <!-- <span class="coupon_name">아이템쿠폰 3% (또는 300원) 할인</span>	-->
                                                    <span class="coupon_name" id="coupon_name_E<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?></span>
                                                    <span class="coupon_info"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                </label>
                                                <?	$coupon_E_text = $row2['MAX_DISCOUNT'] < $row2['COUPON_PRICE'] && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']) : number_format($row2['COUPON_PRICE']);
                                                ?>
                                            </p>
                                            <?		$ITEM_COUPON_YN = 'Y';
                                            $idx2++;
                                        }
                                    }	//END FOREACH
                                    foreach($CUST_COUPON_LIST as $row2)	{
                                        if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'N' && $row2['MIN_AMT'] < ($goods['SELLING_PRICE']+$option_add_price)){
                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods['SELLING_PRICE'] : $row2['COUPON_SALE'];

                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환

                                            ?>
                                            <p>
                                                <input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_B||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||바이어쿠폰||쿠폰지급방식||중복여부||쿠폰구분 -->

                                                <label for="coupon_E<?=$idx?>_<?=$idx2?>" class="radio_label">
                                                    <!-- <span class="coupon_name">아이템쿠폰 3% (또는 300원) 할인</span>	-->
                                                    <span class="coupon_name" id="coupon_name_E<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?></span>
                                                    <span class="coupon_info"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                </label>
                                                <? if(!$AUTO_COUPON_LIST){
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

                                    if(($AUTO_COUPON_LIST && ($AUTO_COUPON_LIST[0]['COUPON_KIND_CD'] == 'GOODS') || (@$AUTO_COUPON_LIST[1]['COUPON_KIND_CD'] == 'GOODS')) || $CUST_COUPON_LIST){
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

                                <!--		<p>
												<input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_2_2" checked>
												<label for="coupon_2_2" class="radio_label">
													<span class="coupon_name">쿠폰이름1 2%(또는 200원) 할인</span>
												</label>
											</p>
											<p>
												<input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_2_3" checked>
												<label for="coupon_2_3" class="radio_label">
													<span class="coupon_name">쿠폰이름2 1%(또는 100원) 할인</span>
												</label>
											</p>
											<p>
												<input type="radio" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_2_4" checked>
												<label for="coupon_2_4" class="radio_label">
													<span class="coupon_name">쿠폰 적용 안함</span>
												</label>
											</p>	-->
                            </div>
                        </td>
                        <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                        <input type="hidden"	name="item_coupon_cnt[]"			value="<?=$idx2?>">
                        <td>
                            <span name="coupon_E_text<?=$idx?>"><?=$coupon_E_text?></span><span class="won">원</span>
                        </td>
                    </tr>
                    <!--	<tr id="dup_coupon_0<?=$idx?>" style="display:none">
									<td class="">
										<p>에타중복할인</p>
									</td>
									<td>
										<div class="radio_block">
											<p>적용 가능한 쿠폰이 없습니다.</p>
										</div>
									</td>
									<td>
										0<span class="won">원</span>
									</td>
								</tr>	-->
                    <tr id="dup_coupon_<?=$idx?>">
                        <td class="">
                            <p>에타홈 중복할인</p>
                        </td>
                        <td>
                            <div class="radio_block">

                                <? $idx2 = 0;
                                //										var_dump($CUST_COUPON_LIST);
                                if($CUST_COUPON_LIST){
                                    foreach($CUST_COUPON_LIST as $row2)	{
                                        if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'Y' && $row2['MIN_AMT'] < ($goods['SELLING_PRICE']+$option_add_price)){	//최소금액 이상일때 보임

                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods['SELLING_PRICE'] : $row2['COUPON_SALE'];

                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                            ?>
                                            <p>
                                                <input type="radio" name="coupon_select_C<?=$idx?>" class="radio" id="coupon_C<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('C',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']?>||<?=$row2['MAX_DISCOUNT'] ? $row2['MAX_DISCOUNT'] : 0?>||<?=$row2['COUPON_DTL_NO']?>||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
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

                                <!--	<p>
												<input type="radio" name="coupon_select_C<?=$idx?>" class="radio" id="coupon_3_2" checked>
												<label for="coupon_3_2" class="radio_label">
													<span class="coupon_name">쿠폰이름4 2%(또는 200원) 할인</span>
												</label>
											</p>
											<p>
												<input type="radio" name="coupon_select_C<?=$idx?>" class="radio" id="coupon_3_3" checked>
												<label for="coupon_3_3" class="radio_label">
													<span class="coupon_name">쿠폰 적용 안함</span>
												</label>
											</p>	-->
                            </div>
                        </td>
                        <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 추가쿠폰이 몇개인지 알려주는 변수 -->
                        <input type="hidden"	name="add_coupon_cnt[]"			value="<?=$idx2?>">
                        <td>
                            <span name="coupon_C_text<?=$idx?>"><?=$coupon_C_text?></span><span class="won">원</span>
                        </td>
                    </tr>
                    <tr class="total_coupon_payment">
                        <th scope="row" colspan="2">
                            쿠폰할인 총액
                        </th>
                        <td>
                            <span name="coupon_total_amt_<?=$idx?>"><?=number_format($seller_coupon_amt+$item_coupon_amt)?></span><span class="won">원</span>
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
            <li><button type="button" class="btn_negative" onClick="javascript:Coupon_Reset(<?=$idx?>);">적용취소</button></li>
        </ul>
        <a href="" onClick="javascript:Coupon_Reset(<?=$idx?>);" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
    </div>
    <div class="dimd"></div>
</div>
<!-- // 쿠폰 적용하기 레이어 -->

