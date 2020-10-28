
			<div class="quick" id="quick">
				<div class="quick_menu">
					<ul class="quick_menu_list">
						<li class="quick_menu_item">
							<a href="#cart_area" onClick="changeTitle('cart','장바구니');">
								<span class="spr-common spr-bag"></span>
								<span class="counter"><?=$quick['cart_cnt']?></span>
							</a>
						</li>
						<li class="quick_menu_item">
							<a href="#wish_area" onClick="changeTitle('wish','관심상품');">
								<span class="spr-common spr-heart"></span>
								<span class="counter"><?=$quick['wish_cnt']?></span>
							</a>
						</li>
						<li class="quick_menu_item">
							<a href="#view_area" onClick="changeTitle('view','최근 본 상품');">
								<span class="spr-common spr-clock"></span>
								<span class="counter"><?=$quick['view_cnt']?></span>
							</a>
						</li>
					</ul>
					<a href="#top" type="button" class="quick_top">
						<span class="spr-common arrow_top"></span> TOP
					</a>
					<div class="quick_menu_bg"></div>
				</div>
				<div class="quick_box" style="right:-293px;">
					<h3 class="cart_title" id="title_quick">장바구니 <a href="/cart" class="spr-common spr_btn_go cart_go" title="장바구니 바로가기"></a></h3>
					<a href="#close" class="cart_close spr-common spr-close" title="장바구니 닫기"></a>
					<ul class="quick_menu_list quick_menu_list__inner">
						<li class="quick_menu_item active">
							<a href="#cart_area" onClick="changeTitle('cart','장바구니');">
								<span class="spr-common spr-bag"></span>
								<span class="counter"><?=$quick['cart_cnt']?></span>
								<span class="spr-common spr-bgcircle"></span>
							</a>
						</li>
						<li class="quick_menu_item">
							<a href="#wish_area" onClick="changeTitle('wish','관심상품');">
								<span class="spr-common spr-heart"></span>
								<span class="counter"><?=$quick['wish_cnt']?></span>
								<span class="spr-common spr-bgcircle"></span>
							</a>
						</li>
						<li class="quick_menu_item">
							<a href="#view_area" onClick="changeTitle('view','최근 본 상품');">
								<span class="spr-common spr-clock"></span>
								<span class="counter"><?=$quick['view_cnt']?></span>
								<span class="spr-common spr-bgcircle"></span>
							</a>
						</li>
					</ul>
					<div class="quick_contents" id="cart_area" style="display:none;">
						<?
						if($quick['cart']){?>
						<ul class="goods_list goods_list__single" id="quick_cart">
						<?	foreach($quick['cart'] as $crow){?>
							<li class="goods_item">
								<a href="/goods/detail/<?=$crow['GOODS_CD']?>" class="goods_item_link">
									<span class="img">
										<img src="<?=$crow['IMG_URL']?>" alt="">
									</span>
									<span class="brand">
										<?=$crow['BRAND_NM']?>
									</span>
									<span class="name"><?=$crow['GOODS_NM']?></span>
									<span class="name"><?=$crow['GOODS_OPTION_NM']?></span>
									<span class="price"><?=number_format($crow['SELLING_PRICE'])?></span>
								</a>
							</li>

						<?	}?>
						</ul>
						<?}else{?>
							<p class="quick_prd_none">해당 상품이 없습니다.</p>
						<?}?>
							<!--<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>-->

						<div class="page" id="cart_page">
							<!--<a href="#" class="page_prev">
								<span class="spr-common spr_arrow_left"></span>Pre
							</a>-->
							<ul class="page_list">
								<li class="page_item active"><a href="javaScript:pageNavigation('C',1);">1</a></li>
								<?if($quick['cart_cnt']>2){?><li class="page_item"><a href="javaScript:pageNavigation('C',2);">2</a></li>
							</ul>
							<a href="javaScript:pageNavigation('C',2);" class="page_next">
								Next<span class="spr-common spr_arrow_right"></span>
							</a>
							<?}else{?>
							</ul>
							<?}?>
						</div>
					</div>
					<div class="quick_contents" id="wish_area">
						<?if($quick['wish']){?>
						<ul class="goods_list goods_list__multi" id="quick_wish">
							<?foreach($quick['wish'] as $wrow){?>
							<li class="goods_item">
								<a href="/goods/detail/<?=$wrow['GOODS_CD']?>" class="goods_item_link">
									<span class="img">
										<img src="<?=$wrow['IMG_URL']?>" alt="" width="100" height="100">
									</span>
									<span class="brand">
										<?=$wrow['BRAND_NM']?>
									</span>
									<span class="name"><?=$wrow['GOODS_NM']?></span>
									<span class="price"><?=number_format($wrow['SELLING_PRICE'])?></span>
								</a>
							</li>
						<?	}?>
						</ul>
						<?}else{?>
							<p class="quick_prd_none">해당 상품이 없습니다.</p>
						<?}?>
							<!--<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_1.jpg" alt="">
									</span>
									<span class="brand">
										Domo design overflow text cut overflow text cut
									</span>
									<span class="name">보가트 거실장 overflow text cut overflow text cut</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_1.jpg" alt="">
									</span>
									<span class="brand">
										Domo design overflow text cut overflow text cut
									</span>
									<span class="name">보가트 거실장 overflow text cut overflow text cut</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>-->
						<div class="page" id="wish_page">
							<!--<a href="#" class="page_prev">
								<span class="spr-common spr_arrow_left"></span>Pre
							</a>-->
							<ul class="page_list">
								<li class="page_item active"><a href="javaScript:pageNavigation('W',1);">1</a></li>
								<?if($quick['wish_cnt']>6){?><li class="page_item"><a href="javaScript:pageNavigation('W',2);">2</a></li>
							</ul>
							<a href="javaScript:pageNavigation('W',2);" class="page_next">
								Next<span class="spr-common spr_arrow_right"></span>
							</a>
							<?}else{?>
							</ul>
							<?}?>
						</div>
					</div>
					<div class="quick_contents" id="view_area" style="display:none">
						<?if($quick['view']){?>
						<ul class="goods_list goods_list__multi" id="quick_view">

						<?	foreach($quick['view'] as $vrow){?>
							<li class="goods_item">
								<a href="/goods/detail/<?=$vrow['GOODS_CD']?>" class="goods_item_link">
									<span class="img">
										<img src="<?=$vrow['IMG_URL']?>" alt="" width="100" height="100">
									</span>
									<span class="brand">
										<?=$vrow['BRAND_NM']?>
									</span>
									<span class="name"><?=$vrow['GOODS_NM']?></span>
									<span class="price"><?=number_format($vrow['SELLING_PRICE'])?></span>
								</a>
							</li>
						<?	}?>
						</ul>
						<?}else{?>
							<p class="quick_prd_none">해당 상품이 없습니다.</p>
						<?}?>
							<!--<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_1.jpg" alt="">
									</span>
									<span class="brand">
										Domo design overflow text cut overflow text cut
									</span>
									<span class="name">보가트 거실장 overflow text cut overflow text cut</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_1.jpg" alt="">
									</span>
									<span class="brand">
										Domo design overflow text cut overflow text cut
									</span>
									<span class="name">보가트 거실장 overflow text cut overflow text cut</span>
									<span class="price">356,000</span>
								</a>
							</li>
							<li class="goods_item">
								<a href="#" class="goods_item_link">
									<span class="img">
										<img src="/assets/images/data/goods_160x160_2.jpg" alt="">
									</span>
									<span class="brand">
										Domo design
									</span>
									<span class="name">보가트 거실장</span>
									<span class="price">356,000</span>
								</a>
							</li>-->
						<div class="page" id="view_page">
							<!--<a href="#" class="page_prev">
								<span class="spr-common spr_arrow_left"></span>Pre
							</a>-->
							<ul class="page_list">
								<li class="page_item active"><a href="javaScript:pageNavigation('V',1);">1</a></li>
								<?if($quick['view_cnt']>6){?><li class="page_item"><a href="javaScript:pageNavigation('V',2);">2</a></li>
							</ul>
							<a href="javaScript:pageNavigation('V',2);" class="page_next">
								Next<span class="spr-common spr_arrow_right"></span>
							</a>
							<?}else{?>
							</ul>
							<?}?>
						</div>
					</div>
				</div>
			</div>

			<script type="text/javaScript">
			function pageNavigation( type, page ){
				var cnt = "";

				switch (type){
					case 'C': cnt = "<?=$quick['cart_cnt']?>"; 
							  page_int = "2";
							  page_type = "#cart_page"; 
							  quick_type = "#quick_cart"; break;
					case 'W': cnt = "<?=$quick['wish_cnt']?>"; 
							  page_int = "6";
							  page_type = "#wish_page"; 
							  quick_type = "#quick_wish"; break;
					case 'V': cnt = "<?=$quick['view_cnt']?>"; 
							  page_int = "6";
							  page_type = "#view_page"; 
							  quick_type = "#quick_view"; break;
				}
//				alert(cnt);
				$.ajax({
					type: 'POST',
					url: '/quick/page',
					dataType: 'json',
					data: {type : type, page : page},
					error: function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
//							alert(res.result[0]['SELLING_PRICE'].replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,'));
							var str_result = "";
							var str_page = "";
							var pre	= "<a href=\"javaScript:pageNavigation(\'"+type+"\',"+(page-1)+");\" class='page_prev'> <span class='spr-common spr_arrow_left'></span>Pre</a>";
							var next = "<a href=\"javaScript:pageNavigation(\'"+type+"\',"+(page+1)+");\" class='page_next'> Next	<span class='spr-common spr_arrow_right'></span></a>";

							if(page == 1) pre = "";
							if(Math.ceil((cnt/page_int)) <= page) next = "";

							for(i=0; i<res.result.length; i++){
								str_result += "<li class='goods_item'> <a href='/goods/detail/"+res.result[i]['GOODS_CD']+"' class='goods_item_link'> <span class='img'><img src='"+res.result[i]['IMG_URL']+"' alt=''  width='100' height='100'></span> <span class='brand'>"+res.result[i]['BRAND_NM']+"</span> <span class='name'>"+res.result[i]['GOODS_NM']+"</span> <span class='name'>"+res.result[i]['GOODS_OPTION_NM']+"</span> <span class='price'>"+res.result[i]['SELLING_PRICE'].replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,')+"</span>	</a></li>";
							}
							if(page % 2 == 0){
								str_page = pre+" <ul class='page_list'> <li class='page_item'><a href=\"javaScript:pageNavigation('"+type+"',"+(page-1)+");\">"+(page-1)+"</a></li><li class='page_item active'><a href=\"javaScript:pageNavigation(\'"+type+"\',"+page+");\">"+page+"</a></li></ul>"+next;
							}else{
								str_page = pre+" <ul class='page_list'> <li class='page_item active'><a href=\"javaScript:pageNavigation('"+type+"',"+page+");\">"+page+"</a></li>";
								if(Math.ceil((cnt/page_int)) > page) str_page += "<li class='page_item'><a href=\"javaScript:pageNavigation(\'"+type+"\',"+(page+1)+");\">"+(page+1)+"</a></li></ul>"+next;
							}

							$(page_type).html(str_page);
							$(quick_type).html(str_result);

						}
						else alert(res.message);
					}
				});
			}

			function changeTitle(kind, val){
//				$("#title").html("<a href='/cart/'>"+val+"</a>");
				kind == 'wish' ? kind = 'mywiz/interest' : kind = kind;
				if(kind == 'view'){//최근본상품
					$("#title_quick").text(val);
				}else{
					$("#title_quick").html(val+' <a href="/'+kind+'" class="spr-common spr_btn_go cart_go" title="장바구니 바로가기"></a>');
				}
			}
			</script>
