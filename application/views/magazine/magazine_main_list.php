<link rel="stylesheet" href="/assets/css/display.css?ver=1.0">

<div class="contents magazine">
    <!-- 카테고리 // -->
    <div class="nav" id="nav">
        <h1 class="nav_title">컨텐츠</h1>
        <ul class="nav_list">
            <?for($i=0;$i<count($nav['CATEGORY_CD1']);$i++) {?>
                <li class="nav_item <?=substr($nav['CATEGORY_CD1'][$i], 0, 1) == substr($this->uri->segment(3), 0, 1) ? "active" : ""?>">
                    <?if(substr($nav['CATEGORY_CD1'][$i], 0, 1)==9) {?>
                        <a href="/magazine/mid_list/<?=$nav['CATEGORY_CD1'][$i]?>"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <?}else {?>
                        <a href="#" class="nav_link"><?=$nav['CATEGORY_NM1'][$i]?></a>
                    <?}?>
                    <ul class="nav_list_2depth">
                        <?for($j=0;$j<count($nav['CATEGORY_CD2'][$i]);$j++) {?>
                            <li><a href="/magazine/list/<?=$nav['CATEGORY_CD2'][$i][$j]?>" <?=$nav['CATEGORY_CD2'][$i][$j] == $this->uri->segment(3) ? "class='active'" : ""?>><?=$nav['CATEGORY_NM2'][$i][$j]?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?}?>
        </ul>
    </div>
    <!-- // 카테고리 -->

    <h2 class="title_page title_page__line">
        <b>홈족피디아<span class="mini_tit">이거 알고 있었어?</span></b>
        <span style="float:right;font-size:11pt;">
            <sub>전체 <?=$count[0]?> <a href="/magazine/mid_list/40000000" class="btn_more">더보기<img src="/assets/images/main/ico_arrow.png"></a></sub>
        </span>
    </h2>

    <div class="section prd_list">
        <?foreach($homejok as $hrow){?>
            <div class="item">
                <a href="/magazine/detail/<?=$hrow['MAGAZINE_NO']?>">
                    <div class="img-wrap auto-img">
                        <div class="img">
                            <img src="<?=$hrow['IMG_URL']?>">
                        </div>
                        <div class="layer"></div>
                        <div class="status">
                            <span class="like"><?=$hrow['LOVE']?></span>
                            <span class="share"><?=$hrow['SHARE']?></span>
                            <span class="view">조회 <?=$hrow['HITS']?></span>
                        </div>
                        <?if(isset($hrow['END_DT']) && ($hrow['END_DT']<date("Y-m-d H:i:s"))){?>
                            <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                <p style="font-size: 20px;color: #E4E4E4;">SOLD OUT</p>
                            </div>
                        <?}?>
                    </div>
                    <div class="txt">
                        <p class="cate"><?=$hrow['CATEGORY_NM']?></p>
                        <p class="date"><?=substr($hrow['REG_DT'],0,10)?></p>
                        <p class="sub"><?=$hrow['TITLE']?></p>
                    </div>
                </a>
            </div>
        <?}?>
    </div>

    <h2 class="title_page title_page__line">
        <b>트렌드 매거진<span class="mini_tit">리빙 트렌드를 한눈에</span></b>
        <span style="float:right;font-size:11pt;">
            <sub>전체 <?=$count[1]?> <a href="/magazine/mid_list/50000000" class="btn_more">더보기<img src="/assets/images/main/ico_arrow.png"></a></sub>
        </span>
    </h2>
    <div class="section prd_list">
        <?foreach($trend as $trow){?>
            <div class="item">
                <a href="/magazine/detail/<?=$trow['MAGAZINE_NO']?>">
                    <div class="img-wrap auto-img">
                        <div class="img">
                            <img src="<?=$trow['IMG_URL']?>">
                        </div>
                        <div class="layer"></div>
                        <div class="status">
                            <span class="like"><?=$trow['LOVE']?></span>
                            <span class="share"><?=$trow['SHARE']?></span>
                            <span class="view">조회 <?=$trow['HITS']?></span>
                        </div>
                    </div>
                    <div class="txt">
                        <p class="cate"><?=$trow['CATEGORY_NM']?></p>
                        <p class="date"><?=substr($trow['REG_DT'],0,10)?></p>
                        <p class="sub"><?=$trow['TITLE']?></p>
                    </div>
                </a>
            </div>
        <?}?>
    </div>

    <h2 class="title_page title_page__line">
        <b>에타홈 클래스<span class="mini_tit">취미생활로 워라벨라이프</span></b>
        <span style="float:right;font-size:11pt;">
            <sub>전체 <?=$count[2]?> <a href="/magazine/mid_list/70000000" class="btn_more">더보기<img src="/assets/images/main/ico_arrow.png"></a></sub>
        </span>
    </h2>

    <div class="section prd_list">
        <?foreach($class as $crow){?>
            <div class="item">
                <a href="/magazine/detail/<?=$crow['MAGAZINE_NO']?>">
                    <div class="img-wrap auto-img">
                        <div class="img">
                            <img src="<?=$crow['IMG_URL']?>">
                        </div>
                        <div class="layer"></div>
                        <div class="status">
                            <span class="like"><?=$crow['LOVE']?></span>
                            <span class="share"><?=$crow['SHARE']?></span>
                            <span class="view">조회 <?=$crow['HITS']?></span>
                        </div>
                    </div>
                    <div class="txt">
                        <p class="cate"><?=$crow['CATEGORY_NM']?></p>
                        <p class="date"><?=substr($crow['REG_DT'],0,10)?></p>
                        <p class="sub"><?=$crow['TITLE']?></p>
                    </div>
                </a>
            </div>
        <?}?>
    </div>

    <h2 class="title_page title_page__line">
        <b>브랜드</b>
        <span style="float:right;font-size:11pt;">
            <sub>전체 <?=$count[3]?> <a href="/magazine/mid_list/60000000" class="btn_more">더보기<img src="/assets/images/main/ico_arrow.png"></a></sub>
        </span>
    </h2>


    <div class="section prd_list">
        <?foreach($brand as $brow){?>
            <div class="item">
                <a href="/magazine/detail/<?=$brow['MAGAZINE_NO']?>">
                    <div class="img-wrap auto-img">
                        <div class="img">
                            <img src="<?=$brow['IMG_URL']?>">
                        </div>
                        <div class="layer"></div>
                        <div class="status">
                            <span class="like"><?=$brow['LOVE']?></span>
                            <span class="share"><?=$brow['SHARE']?></span>
                            <span class="view">조회 <?=$brow['HITS']?></span>
                        </div>
                    </div>
                    <div class="txt">
                        <p class="cate"><?=$brow['CATEGORY_NM']?></p>
                        <p class="date"><?=substr($brow['REG_DT'],0,10)?></p>
                        <p class="sub"><?=$brow['TITLE']?></p>
                    </div>
                </a>
            </div>
        <?}?>
    </div>

    <h2 class="title_page title_page__line">
        <b>이벤트</b>
        <span style="float:right;font-size:11pt;">
            <sub>전체 <?=$count[4]?> <a href="/magazine/mid_list/90000000" class="btn_more">더보기<img src="/assets/images/main/ico_arrow.png"></a></sub>
        </span>
    </h2>
    <div class="section prd_list">
        <?foreach($event as $erow){?>
            <div class="item">
                <a href="/magazine/detail/<?=$erow['MAGAZINE_NO']?>">
                    <div class="img-wrap auto-img">
                        <div class="img">
                            <img src="<?=$erow['IMG_URL']?>">
                        </div>
                        <div class="layer"></div>
                        <div class="status">
                            <span class="like"><?=$erow['LOVE']?></span>
                            <span class="share"><?=$erow['SHARE']?></span>
                            <span class="view">조회 <?=$erow['HITS']?></span>
                        </div>
                        <?if($erow['END_DT']<date("Y-m-d H:i:s")){?>
                            <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                <p style="font-size: 20px;color: #E4E4E4;">이벤트 종료</p>
                            </div>
                        <?}?>
                    </div>
                    <div class="txt">
                        <p class="cate"><?=$erow['CATEGORY_NM']?></p>
                        <p class="date"><?=substr($erow['REG_DT'],0,10)?></p>
                        <p class="sub">
                            <?if($erow['END_DT']>date("Y-m-d H:i:s")){?>
                                [진행중]
                            <?} else {?>
                                [종료]
                            <?}?>
                            <?=$erow['TITLE']?>
                        </p>
                    </div>
                </a>
            </div>
        <?}?>
    </div>
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