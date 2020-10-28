<link rel="stylesheet" href="/assets/css/display.css?ver=1.1">

<div class="contents magazine srp">

    <div class="nav" id="nav">
        <h1 class="nav_title">컨텐츠</h1>

        <ul class="nav_list">
            <?for($i=0;$i<count($nav['CATEGORY_CD1']);$i++) {?>
                <li class="nav_item <?=$nav['CATEGORY_CD1'][$i] == $category['CATEGORY_CD'] ? "active" : ""?>">
                    <?if($nav['CATEGORY_CD1'][$i]==90000000) {?>
                        <a href="/magazine/mid_list/<?=$nav['CATEGORY_CD1'][$i]?>"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <?}else {?>
                        <a href="#" class="nav_link"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <?}?>
                    <ul class="nav_list_2depth">
                        <?for($j=0;$j<count($nav['CATEGORY_CD2'][$i]);$j++) {?>
                            <li><a href="/magazine/list/<?=$nav['CATEGORY_CD2'][$i][$j]?>"><?=$nav['CATEGORY_NM2'][$i][$j]?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?}?>
        </ul>
    </div>


    <h2 class="title_page title_page__line">
        <b><?=$category['CATEGORY_NM']?></b><em class="bold_yel">(<?=number_format($totalCnt)?>개)</em>
    </h2>

    <!-- 카테고리 필터 -->
    <div class="option_button position_area srp_option_area">
        <div class="position_left">
            <div class="select_wrap select_wrap_cate">
                <h4 class="srp-cate-tit srp-cate-tit1">
                    <?
                    switch($order){
                        case 'A': echo '최신순';break;
                        case 'B': echo '인기순';break;
                        case 'C': echo '진행중';break;
                        case 'D': echo '종료';break;
                        default: echo '최신순';break;
                    }
                    ?>
                </h4>
                <ul id="srp-cate" class="srp-cate1">
                    <?if($category['CATEGORY_CD'] == 90000000) {?>
                        <li><a href="#none" onclick="javaScript:search_magazine('A')" <?=$order == 'A' ? "class='on'" : ""?>>최신순</a></li>
                        <li><a href="#none" onclick="javaScript:search_magazine('C')" <?=$order == 'C' ? "class='on'" : ""?>>진행중</a></li>
                        <li><a href="#none" onclick="javaScript:search_magazine('D')" <?=$order == 'D' ? "class='on'" : ""?>>종료</a></li>
                    <?} else{?>
                        <li><a href="#none" onclick="javaScript:search_magazine('A')" <?=$order == 'A' ? "class='on'" : ""?>>최신순</a></li>
                        <li><a href="#none" onclick="javaScript:search_magazine('B')" <?=$order == 'B' ? "class='on'" : ""?>>인기순</a></li>
                    <?}?>
                </ul>
            </div>
        </div>
    </div>
    <!-- //카테고리 필터 -->

    <div class="section prd_list">
        <?foreach($list as $row) {?>
            <div class="item">
                <a href="/magazine/detail/<?=$row['MAGAZINE_NO']?>">
                    <div class="img-wrap auto-img">
                        <div class="img">
                            <img src="<?=$row['IMG_URL']?>">
                        </div>
                        <div class="layer"></div>
                        <div class="status">
                            <span class="like"><?=$row['LOVE']?></span>
                            <span class="share"><?=$row['SHARE']?></span>
                            <span class="view">조회 <?=$row['HITS']?></span>
                        </div>
                        <?if(isset($row['END_DT']) && ($row['END_DT']<date("Y-m-d H:i:s"))){?>
                            <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                            <?if($category['CATEGORY_CD'] == 90000000) {?>
                                <p style="font-size: 20px;color: #E4E4E4;">이벤트 종료</p>
                            <?}else{?>
                                <p style="font-size: 20px;color: #E4E4E4;">SOLD OUT</p>
                            <?}?>
                            </div>
                        <?}?>
                    </div>
                    <div class="txt">
                        <p class="cate"><?=$row['CATEGORY_NM']?></p>
                        <p class="date"><?=substr($row['REG_DT'],0,10)?></p>
                        <p class="sub">
                            <?if($category['CATEGORY_CD'] == 90000000) {?>
                                <?if($row['END_DT']>date("Y-m-d H:i:s")){?>
                                    [진행중]
                                <?} else {?>
                                    [종료]
                                <?}?>
                            <?}?>
                            <?=$row['TITLE']?>
                        </p>
                    </div>
                </a>
            </div>
        <?}?>
    </div>

    <?=$pagination?>
</div>


<script type="text/javascript">
    var nav = $('#nav'),
        navLink = nav.find('.nav_link'),
        itemParent = $('.nav_item'),
        add = 'active';

    $(navLink).click(function()
    {
        var thisParent = $(this).parents('.nav_item');
        $(itemParent).find('.nav_list_2depth').stop().slideUp();

        if ($(thisParent).hasClass(add))
        {
            $(thisParent).addClass(add);
            $(thisParent).find('.nav_list_2depth').stop().slideUp();
        }
        else
        {
            $(thisParent).removeClass(add);
            $(thisParent).find('.nav_list_2depth').stop().slideDown();
        };
        return false;
    });
</script>

<script type="text/javascript">
    function search_magazine(val) {
        document.location.href = "?kind="+val;
    }

    //calculate image size
    function calcImgSize() {
        $("img", ".auto-img").each(function() {
            var $el = $(this);
            $el.parents(".img").addClass(function() {
                var $height = $el.height();
                var $width = $el.width();
                if ($height > $width) return "port";
                else return "land";
            });
        });
    };

    //이미지가 모두 로드 된 후 실행
    jQuery.event.add(window,"load",function(){
        calcImgSize();
    });
</script>
