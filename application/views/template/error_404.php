<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAH GUIDE FONTS</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
			.error {
				text-align: center;
				padding-top: 250px;
			}

			.error_title {
				width: 150px;
				height: 53px;
				background: url('/assets/images/error/error_img.jpg') no-repeat 0 0;
				color: #666;
				font-size: 15px;
				line-height: 30px;
				margin: 0 auto;
				font-weight: normal;
				padding-top: 97px;
			}

			.error_text {
				color: #000;
				font-size: 18px;
				line-height: 26px;
				padding: 26px 0 19px 0;
				margin: 0;
			}

			.error_text_list {
				border: 1px solid #eee;
				width: 633px;
				margin: 0 auto;
				padding: 19px 20px 22px 25px;
			}

			.error_text_item {
				font-size: 12px;
				color: #666;
				line-height: 20px;
				text-align: left;
				list-style: none;
				background: url('/assets/images/error/bg_dot.gif') no-repeat 0 50%;
				padding-left: 9px;
			}

			.error_btn_list {
				padding: 0;
				margin: 0;
			}

			.error_btn_item {
				display: inline-block;
				margin-top: 30px;
			}

			.error_btn_item + .error_btn_item {
				margin-left: 5px;
			}

			.btn_black {
				background: #000;
				color: #fff;
				text-align: center;
				font-size: 14px;
				height: 50px;
				line-height: 50px;
				border: 0;
				border-radius: 0;
				width: 159px;
			}

			.btn_gray {
				background: #bbb;
				color: #fff;
				text-align: center;
				font-size: 14px;
				height: 50px;
				line-height: 50px;
				border: 0;
				border-radius: 0;
				width: 159px;
			}
		</style>
	</head>

	<body>
		<div class="error">
			<h1 class="error_title">404 ERROR</h1>
			<p class="error_text">죄송합니다.<br />요청하신 페이지를 찾을 수 없습니다.</p>
			<ul class="error_text_list">
				<li class="error_text_item">일시적으로 요청하신 페이지를 사용하지 못하는 것일 수 있습니다.</li>
				<li class="error_text_item">요청하신 페이지가 변경되었거나 삭제되어 찾을 수 없을 수 있습니다. (이벤트의 경우 종료 후 삭제될 수 있습니다.)</li>
				<li class="error_text_item">문의사항은 고객센터 02-569-6227로 문의주시거나, MY PAGE &gt;1:1문의 등록&#47;수정을 이용하여 주세요.</li>
			</ul>
			<ul class="error_btn_list">
				<li class="error_btn_item"><button type="button" class="btn_black" onClick="javascript:location.href = '/';">홈으로</button></li>
				<!--<li class="error_btn_item"><button type="button" class="btn_gray" onClick="javascript:location.href = '/cart';">이전페이지로</button></li>	-->
			</ul>
		</div>
        <br/><br/><br/><br/><br/><br/><br/><br/>
	</body>

</html>