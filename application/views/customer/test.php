<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAH GUIDE FONTS</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

	</head>

	<body>
	<form id="updFile" name="updFile" method="post" enctype="multipart/form-data">
		<input type="file"name="fileUpload">
		<input type="button" onClick="javsScript:test_upload();" value="전송">
		<input type ="hidden" name="hid_test" value="test">
	</form>
	<form name="updFile2" method="post">
		<input type="test" name="fileUpload">
		<input type="button" onClick="javsScript:test_email();" value="전송">
	</form>
	
	<script>

//	function test_upload(){
//
//	
//	var updFile= document.updFile;
//
////	if( ! $("input[name=file_url]").val()  ){
////		alert("업로드할 파일을 선택해 주세요."); 
//////					$("#excelFile").fo/cus();
////		return;
////	}
////				var lang = "";
////				document.getElementById("lang").value == "EN" ? lang = "영어" : lang = "중국어";
////				if(!confirm(lang+" 정보고시를 업로드하겠습니까?")){
////					return false;
////				}
//
//
//	updFile.method = "POST";
//	updFile.action = "/customer/test_upload";
//	updFile.submit();


//}

//=======================================
// 저장
//=======================================
function test_upload(){
		var goods_code = "";
//		var btn = $('#submitBtn');
//		var btn2 = $('#submitBtn2');
//		var image_main = $("#image_main").val();
//		btn.button('loading');
//		btn2.button('loading');

		var fd = new FormData($('#updFile')[0]);

    $.ajax({
        url: "/customer/do_upload/",
        type: "POST",
        data: fd,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success:  function(data){
			if(data.status == 'ok') {
				alert('저장되었습니다.');
//				btn.button('reset');
//				btn2.button('reset');
//				location.reload();
			} else {
				alert('다시 시도해주세요.');
//				btn.button('reset');
//				btn2.button('reset');
//				jsHiddenDel();
				return false;
			} 
        },
			error: function(res) {
				alert('잠시 후 다시 시도하시기 바랍니다.');
//				console.log(res.responseText);
				alert(res.responseText);
//				btn.button('reset');
//				btn2.button('reset');
//				jsHiddenDel();
				return false;
			}
    });

//		event.preventDefault();

}


function test_email()
{
	$.ajax({
		type: 'POST',
		url: '/customer/test_email',
		dataType: 'json',
		data: {  test:''},
		error: function(res) {
			alert('Database Error');
		},
		success: function(res) {
			if(res.status == 'ok'){
					alert("ok");
//					location.reload();
			}
			else alert(res.message);
		}
	});
}

	</script>

	</body>
	</html>