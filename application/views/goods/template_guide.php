<div class="layer_inner">
	<h1 class="layer_title">구매가이드</h1>

	<?
		$GOODS_GUIDE = 'N';
		$CATEGORY_GUIDE = 'N';
		$BRAND_GUIDE = 'N';

		foreach($goods_buy_guide as $row){
			if($row['gubun'] == 'GOODS_GUIDE'){
				$GOODS_GUIDE = 'Y';
			}
			if($row['gubun'] == 'CATEGORY_GUIDE'){
				$CATEGORY_GUIDE = 'Y';
			}
			if($row['gubun'] == 'BRAND_GUIDE'){
				$BRAND_GUIDE = 'Y';
			}
		}
	if($goods_buy_guide){
		if($GOODS_GUIDE == 'Y'){	?>
	<div class="layer_cont">
		<h2 class="layer_sub_title"><?=$goods_name?><!-- <span class="layer_sub_title_dsc">(상품명)</span>--></h2>
		<div class="layer_insert_html">
			<!-- html 삽입. -->
			<? foreach($goods_buy_guide as $row){
				if($row['gubun'] == 'GOODS_GUIDE'){
					if($row['BUY_GUIDE_BLOG_GB_CD'] == 'TEXT'){	?>
				<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				<?=$row['HEADER_DESC']?>
				</p>
			<?	} else if ($row['BUY_GUIDE_BLOG_GB_CD'] == 'IMG'){	?>
				<p style="text-align:center;margin-bottom:40px"><img src="<?=$row['HEADER_DESC']?>" alt="" width="700"></p>
			<? } else {?>
				<?=$row['HEADER_DESC']?>
			<? }?>
			<? }
			}?>
<!--			<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				네델란드에서 직수입된 사이잘 룩 카페트는 <br>까다로운 국제규격 테스트를 통과하여 GUI 마크를 획득하였습니다.<br>그리고 사용된 울 소재는 엄격한 품질 소재를 거쳐<br>울 마크를 획득한 제품들입니다.
			</p>
			<p style="text-align:center;margin-bottom:40px"><img src="/assets/images/data/data_magazine_01.jpg" alt="" width="700"></p>
			<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				네델란드에서 직수입된 사이잘 룩 카페트는 <br>까다로운 국제규격 테스트를 통과하여 GUI 마크를 획득하였습니다.<br>그리고 사용된 울 소재는 엄격한 품질 소재를 거쳐<br>울 마크를 획득한 제품들입니다.
			</p>
			<p style="text-align:center;margin-bottom:20px"><img src="/assets/images/data/data_magazine_02.jpg" alt="" width="700"></p>
			<p style="text-align:center"><img src="/assets/images/data/data_magazine_03.jpg" alt="" width="700"></p>	-->
		</div>
	</div>
	<? } ?>

	<? if($CATEGORY_GUIDE == 'Y'){	?>
	<div class="layer_cont">
		<h2 class="layer_sub_title"><?=$category_name?><!-- <span class="layer_sub_title_dsc">(카테고리명)</span>--></h2>
		<div class="layer_insert_html">
			<!-- html 삽입. -->
			<? foreach($goods_buy_guide as $row){
				if($row['gubun'] == 'CATEGORY_GUIDE'){
					if($row['BUY_GUIDE_BLOG_GB_CD'] == 'TEXT'){	?>
				<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				<?=$row['HEADER_DESC']?>
				</p>
			<?	} else if ($row['BUY_GUIDE_BLOG_GB_CD'] == 'IMG'){	?>
				<p style="text-align:center;margin-bottom:40px"><img src="<?=$row['HEADER_DESC']?>" alt="" width="700"></p>
			<? } else {?>
				<?=$row['HEADER_DESC']?>
			<? }?>
			<? }
			 }?>
<!--			<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				네델란드에서 직수입된 사이잘 룩 카페트는 <br>까다로운 국제규격 테스트를 통과하여 GUI 마크를 획득하였습니다.<br>그리고 사용된 울 소재는 엄격한 품질 소재를 거쳐<br>울 마크를 획득한 제품들입니다.
			</p>
			<p style="text-align:center;margin-bottom:40px"><img src="/assets/images/data/data_magazine_01.jpg" alt="" width="700"></p>
			<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				네델란드에서 직수입된 사이잘 룩 카페트는 <br>까다로운 국제규격 테스트를 통과하여 GUI 마크를 획득하였습니다.<br>그리고 사용된 울 소재는 엄격한 품질 소재를 거쳐<br>울 마크를 획득한 제품들입니다.
			</p>
			<p style="text-align:center;margin-bottom:20px"><img src="/assets/images/data/data_magazine_02.jpg" alt="" width="700"></p>
			<p style="text-align:center"><img src="/assets/images/data/data_magazine_03.jpg" alt="" width="700"></p>	-->
		</div>
	</div>
	<? }?>

	<? if($BRAND_GUIDE == 'Y'){	?>
	<div class="layer_cont">
		<h2 class="layer_sub_title"><?=$brand_name?><!-- <span class="layer_sub_title_dsc">(브랜드명)</span>--></h2>
		<div class="layer_insert_html">
			<!-- html 삽입. -->
			<? foreach($goods_buy_guide as $row){
				if($row['gubun'] == 'BRAND_GUIDE'){
					if($row['BUY_GUIDE_BLOG_GB_CD'] == 'TEXT'){	?>
				<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				<?=$row['HEADER_DESC']?>
				</p>
			<?	} else if ($row['BUY_GUIDE_BLOG_GB_CD'] == 'IMG'){	?>
				<p style="text-align:center;margin-bottom:40px"><img src="<?=$row['HEADER_DESC']?>" alt="" width="700"></p>
			<? } else {?>
				<?=$row['HEADER_DESC']?>
			<? }?>
			<? }
			 }?>
<!--			<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				네델란드에서 직수입된 사이잘 룩 카페트는 <br>까다로운 국제규격 테스트를 통과하여 GUI 마크를 획득하였습니다.<br>그리고 사용된 울 소재는 엄격한 품질 소재를 거쳐<br>울 마크를 획득한 제품들입니다.
			</p>
			<p style="text-align:center;margin-bottom:40px"><img src="/assets/images/data/data_magazine_01.jpg" alt="" width="700"></p>
			<p style="color:#999;font-size:13px;text-align:center;line-height:25px;margin-bottom:40px">
				네델란드에서 직수입된 사이잘 룩 카페트는 <br>까다로운 국제규격 테스트를 통과하여 GUI 마크를 획득하였습니다.<br>그리고 사용된 울 소재는 엄격한 품질 소재를 거쳐<br>울 마크를 획득한 제품들입니다.
			</p>
			<p style="text-align:center;margin-bottom:20px"><img src="/assets/images/data/data_magazine_02.jpg" alt="" width="700"></p>
			<p style="text-align:center"><img src="/assets/images/data/data_magazine_03.jpg" alt="" width="700"></p>	-->
		</div>
	</div>
	<? }?>
	<? }?>

	<a href="#layer__use_clause" class="spr-common layer_close" title="레이어 닫기" onclick="$(this).parents('.layer').hide(); return false;"></a>
</div>
<div class="dimd"></div>