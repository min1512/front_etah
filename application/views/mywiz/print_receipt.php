<!-- 구매영수증 레이어 // -->
<div class="layer layer__view layer_documentary_evidence_02" id="layer_documentary_evidence_02">
    <div class="layer_inner">
        <h1 class="layer_title layer_title__line">구매영수증</h1>
        <div class="layer_cont">
            <div id="documentaryEvidence_02">
                <div class="table_basic_type">
                    <table>
                        <caption>구매영수증</caption>
                        <colgroup>
                            <col style="width:209px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col style="width:47px;" />
                            <col />
                        </colgroup>
                        <thead>
                        <tr>
                            <th colspan="11">구매영수증 (SALES SLIP)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>주문번호</td>
                            <td colspan="10"><?=$order['ORDER_NO']?></td>
                        </tr>
                        <tr>
                            <td>거래일시/TRANS DATE</td>
                            <td colspan="10"><?=str_replace('-','/',substr($order['REG_DT'],0,10))?></td>
                        </tr>
                        <tr>
                            <td>품명/DESCRIPTION</td>
                            <td colspan="10">
                                <?foreach($order_dtl as $drow){?>
                                    <li><?=$drow['GOODS_NM']?></li>
                                <?}?>
                            </td>
                        </tr>
                        <tr>
                            <td>합계/TOTAL</td>
                            <td>￦</td>
                            <td><strong><?=$arr_total_pay[1]?></strong></td>
                            <td><strong><?=$arr_total_pay[2]?></strong></td>
                            <td><strong><?=$arr_total_pay[3]?></strong></td>
                            <td><strong><?=$arr_total_pay[4]?></strong></td>
                            <td><strong><?=$arr_total_pay[5]?></strong></td>
                            <td><strong><?=$arr_total_pay[6]?></strong></td>
                            <td><strong><?=$arr_total_pay[7]?></strong></td>
                            <td><strong><?=$arr_total_pay[8]?></strong></td>
                            <td><strong><?=$arr_total_pay[9]?></strong></td>
                        </tr>
                        <tr>
                            <td>회사명/COMPANY NAME</td>
                            <td colspan="10">(주) ETAH(에타)</td>
                        </tr>
                        <tr>
                            <td>대표자/MASTER</td>
                            <td colspan="10">김의종</td>
                        </tr>
                        <tr>
                            <td>사업자등록번호/BUSINESS NO.</td>
                            <td colspan="10">423 - 81 - 00385</td>
                        </tr>
                        <tr>
                            <td>회사주소/ADDRESS</td>
                            <td colspan="10">서울시 성동구 성수이로 22길 37, 아크밸리지식산업센터 906호 에타</td>
                        </tr>
                        <tr>
                            <td colspan="11">※ 이 영수증은 세금계산서 등 증빙서류로 사용할 수 없습니다.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table_basic_type">
                    <table>
                        <caption>약관동의 정보 표</caption>
                        <colgroup>
                            <col style="width:50%;" />
                            <col />
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>문의전화/ 02-1522-5572<br />HELP DESK/ cs@etah.co.kr</td>
                            <td>서명/SIGNATURE<br /><?=$order['SENDER_NM']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <ul class="btn_list">
                <li><button type="button" class="btn_positive" onclick="printDiv('documentaryEvidence_02')">출력하기</button></li>
            </ul>
        </div>

        <a href="#layer_documentary_evidence_02" class="spr-common layer_close" data-ui="layer-closer" title="레이어 닫기"></a>
    </div>
    <div class="dimd"></div>
</div>
<!-- //구매영수증 레이어 -->