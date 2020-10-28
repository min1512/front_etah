
<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAHOME GUIDE FONTS</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="/assets/css/iframe.css?ver=1.3">

	</head>

	<body>
		<div class="vip_banner_info">
		
			<div class="vip_banner_info_img">
                <!-- 업체 공지 이미지 //-->
                <div align="center">
                    <?if( !empty($goods_desc[0]['SUBVENDOR_NOTICE']) ){?>
                        <p><img alt="" src="<?=$goods_desc[0]['SUBVENDOR_NOTICE']?>" /></p>
                    <?}?>
                </div>
                <!-- // 업체 공지 이미지 -->
			</div>
			<br/>

            <div align="center">
            <?if($goods_desc[0]['TEMPLATE_GB_CD']){?>
                <?	foreach($goods_desc as $row){?>
                    <div align="center">
                        <?if($row['NOTICE_IMG_URL'] != null){?>
                        <img src="<?=$row['NOTICE_IMG_URL']?>">
                        <?}?>
                        <img src="<?=$row['TITLE_IMG_URL']?>" />
                    </div>
                <?	}?>

<!--                <p style="font-size: large"><b>--><?//=$goods_desc[0]['BRAND_NM']?><!--</b></p><br>-->
<!--                --><?//	foreach($img as $erow){
//                    if($erow['TYPE_CD'] == 'TITLE'){?>
<!--                        <div class="vip_banner_info_img"><img src="--><?//=$erow['IMG_URL']?><!--" alt="" /></div>-->
<!--                    --><?//}
//                }?>
            <?}?>
			<?	foreach($goods_desc as $row) {
					 if($row['GOODS_DESC_BLOG_GB_CD'] == 'IMG'){	?>
						<div class="vip_banner_info_img"><img src="<?=$row['HEADER_DESC']?>" alt="" /></div>
					<? } else if($row['GOODS_DESC_BLOG_GB_CD'] == 'TEXT'){	?>
						<p class="vip_banner_info_text"><?=$row['HEADER_DESC']?></p>
					<? } else if($row['GOODS_DESC_BLOG_GB_CD'] == 'HTML'){	?>
						<div class="descHtml"><?=$row['HEADER_DESC']?></div>
					<? } else if($row['GOODS_DESC_BLOG_GB_CD'] == 'VIDEO'){?>
                         <div style="position: relative; padding-top: 56%;">
                             <iframe src="https://www.youtube.com/embed/<?=$row['HEADER_DESC']?>" frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%;height: 100%;"></iframe>
                         </div>
                     <? }?>
			<?	}?>

                <br/>

            <?if($goods_desc[0]['TEMPLATE_GB_CD']){?>

                <?	foreach($img as $erow2){
                    if($erow2['TYPE_CD'] != 'TITLE'){ ?>
                        <div class="vip_banner_info_img"><img src="<?=$erow2['IMG_URL']?>" alt="" /></div>
                    <?}
                }?>

                <?	foreach($goods_desc as $row){?>
                    <div align="center">
                        <img src="<?=$row['DELIV_IMG_URL']?>" />
                    </div>
                <?	}?>
            <?}?>
            </div>
		</div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".descHtml a").attr("target", "_blank");
            });
        </script>
    </body>
</html>