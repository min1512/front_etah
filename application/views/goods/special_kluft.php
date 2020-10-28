<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-11-12
 * Time: 오전 10:57
 */
?>


<link rel="stylesheet" href="/assets/css/display.css">

<div class="contents event popup_event" style="margin-top:30px;">
    <!--    <p class="event_date">행사기간 : 2019-01-21 ~ 2019-12-29</p>-->

    <div class="event_visual">
        <img src="/assets/images/data/kluft_reservation_page01_1.jpg" alt="" />

        <div class="vip_btn_wrap">
            <a type="button" class="" onClick="javascript:jsReservationLayer()">
                <img src="/assets/images/data/btn_kluft.png" alt="" />
            </a>
        </div>
    </div>
    <div class="vip_ex">
<!--        <ul class="event_link list1">-->
<!--            <li><a href="/goods/detail/1932251"><img src="/assets/images/data/bancroft.png"></a></li>-->
<!--            <li><a href="/goods/detail/1932253"><img src="/assets/images/data/preston.png"></a></li>-->
<!--            <li><a href="/goods/detail/1932255"><img src="/assets/images/data/victory.png"></a></li>-->
<!--        </ul>-->
<!--        <ul class="event_link list2">-->
<!--            <li><a href="/goods/detail/1932243"><img src="/assets/images/data/green_point.png"></a></li>-->
<!--            <li><a href="/goods/detail/1932245"><img src="/assets/images/data/chelsea.png"></a></li>-->
<!--            <li><a href="/goods/detail/1932247"><img src="/assets/images/data/sutton.png"></a></li>-->
<!--            <li><a href="/goods/detail/1932249"><img src="/assets/images/data/prospect.png"></a></li>-->
<!--        </ul>-->
<!--        <ul class="event_link list3">-->
<!--            <li><a href="/goods/detail/1932262"><img src="/assets/images/data/talay_latex_pillow.png"></a></li>-->
<!--        </ul>-->
        <ul class="event_link list1">
            <a href="/goods/detail/1932251"><li></li></a>
            <a href="/goods/detail/1932255"><li></li></a>
            <a href="/goods/detail/1932253"><li></li></a>
        </ul>
        <ul class="event_link list2">
            <a href="/goods/detail/1932243"><li></li></a>
            <a href="/goods/detail/1932245"><li></li></a>
            <a href="/goods/detail/1932247"><li></li></a>
            <a href="/goods/detail/1932249"><li></li></a>
        </ul>
        <ul class="event_link list3">
            <a href="/goods/detail/1932262"><li></li></a>
        </ul>
    </div>


    <div class="RESERVATION_LAYER" id="reservation_layer"></div>


<script>
    //====================================
    // 방문예약 레이어 생성
    //====================================
    function jsReservationLayer(){
        $.ajax({
            type: 'POST',
            url: '/goods/reservation_layer',
            dataType: 'json',
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    $("#reservation_layer").prepend(res.reservation_layer);
                }
                else alert(res.message);
            }
        });
    }
</script>