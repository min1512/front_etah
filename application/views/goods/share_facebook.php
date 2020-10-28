
<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETA HOME GUIDE FONTS</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
		<meta property="og:type" content="website" />
		<meta id="web_title"	property="og:title"			content="ETAHOME" />
		<meta id="web_app_id"	property="og:app_id"		content="1597015307262780" />
		<meta id="web_url"		property="og:url"			content="<?=base_url()?>goods/detail/<?=$goods_code?>" />
		<meta id="web_image"	property="og:image"			content="<?=isset($img)?$img:''?>" />
		<meta id="web_desc"		property="og:description"	content="<?=isset($title)?$title:''?>" />

		<!--<meta id="web_title" property="og:url"			content="웹 페이지 URL" />-->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>


<body>
	<div class="wrap">

	</div>
</body>

<script>
//alert($('#web_desc').attr('content'));
var goods_code = "<?=$goods_code?>",
	url = '<?=base_url()?>'+'goods/detail/'+goods_code,
	img = "<?=$img?>",
	title = "<?=$title?>";

	console.log(url);

//  window.fbAsyncInit = function() {
//    FB.init({
//      appId      : '1597015307262780',
//      xfbml      : true,
//      version    : 'v2.6'
//    });
//  };
//
//  FB.ui({
//  method: 'share',
//  href: 'https://developers.facebook.com/docs/',
//	}, function(response){});
//
//  (function(d, s, id){
//     var js, fjs = d.getElementsByTagName(s)[0];
//     if (d.getElementById(id)) {return;}
//     js = d.createElement(s); js.id = id;
//     js.src = "//connect.facebook.net/ko_KR/sdk.js";
//     fjs.parentNode.insertBefore(js, fjs);
//   }(document, 'script', 'facebook-jssdk'));




location.href="http://www.facebook.com/sharer/sharer.php?u="+url;

//window.open("http://www.facebook.com/sharer/sharer.php?u="+url+"&t="+title,"","width=550, height=300, status=yes, resizable=no, scrollbars=no");

</script>

<!--<div
  class="fb-like"
  data-share="true"
  data-like="false"
  >
</div> -->