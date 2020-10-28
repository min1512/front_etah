<!DOCTYPE html>
<Html>
<head>
<meta charset='utf-8'>
<title>[bootstrap] 부트스트랩 – 모달(팝업창이 위에서 내려오는 구조)</title>
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->

<style></style>
<script></script>
</head>
<body>
<div class="container">

	<h2>모달</h2>

	<!-- 버튼 -->
<!--	<button type="button" id="aa" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" >
	  Launch demo modal
	</button>	-->


		<a name="btnEditCoupon[]" class="btn btn-primary btn-sm external" style="display: inline-block; color: black;" data-toggle="modal" data-target="#myModal" data-title="쿠폰선택" data-height="550" data-width="750" data-src="/cart/coupon_2/1"><span class="coopon10_b">검색</span></a>


	<!-- 모달 팝업
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Modal title</h4>
	      </div>
	      <div class="modal-body">
		...
	      </div>
	      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>	-->

							<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title"><span id="title_name">&nbsp;</span></h5>
			</div>
			<div class="modal-body">
				<iframe frameborder="0"></iframe>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


</div>
<script>
/** 쿠폰 modal **/

var width = '100%';
var height = '100%';
$(function(){
    $('a.external').on('click', function(e) {
		alert("ss");
        e.preventDefault();

        var idx = 0;
        var src = "";

		var gCouponCodeUse	= document.getElementsByName("g_coupon_code[]");
		var gCouponNum		= gCouponCodeUse.length;
		var gCouponUseStr	= "";

		for (var i = 0; i < gCouponNum; i++)
		{
			gCouponUse		= gCouponCodeUse[i].value;
			gCouponUseStr	+= gCouponUse+"|";
		}

        if($(this).attr("name") == "btnEditCoupon[]"){
            idx = $("a[name='btnEditCoupon[]']").index(this);
			alert(idx);
            src = $(this).attr('data-src')+"/"+$("input[name='g_coupon_code[]']").eq(idx).attr("value")+"/"+idx+"/"+gCouponUseStr;
//            src = $(this).attr('data-src')+"/"+$("input[name='g_coupon_code[]']").eq(idx).attr("value")+"/"+idx;
  		}
        else if($(this).attr("name") == "btnEditOption[]"){
            idx = $("a[name='btnEditOption[]']").index(this);
            src = $(this).attr('data-src')+"/"+$("input[name='g_option_key[]']").eq(idx).attr("value")+"/"+$("input[name='goods_com_code[]']").eq(idx).attr("value")+"/"+idx;
        }
        else if($(this).attr("name") == "btnEditMemberCoupon"){
			src = $(this).attr('data-src')+"/"+$("input[name='total_goods_price']").attr("value")+"/"+$("input[name='o_coupon_code']").attr("value");
		}

        height = $(this).attr('data-height') || 300;
        width = $(this).attr('data-width') || 400;
        $("#title_name").html($(this).attr('data-title'));

        $("#myModal iframe").attr({'src':src,
            'height': '100%',
            'width': '100%'});

alert(src);
        //$(".modal-body").html('<iframe width="100%" height="100%" frameborder="0" scrolling="yes" allowtransparency="true" src="'+url+'"></iframe>');
    });

    $('#myModal').on('show.bs.modal', function () {
alert("ss");
        $(this).find('.modal-dialog').css({
            /*width:'40%',
            height:'100%',*/
            width: width,
            height: height,
            'padding':'0',
            'margin-top' : '1cm',
            'margin-bottom' : '1cm'
        });
        $(this).find('.modal-content').css({
            height: 'auto',
            //height:'100%',
            'border-radius':'0',
            'padding':'0'
        });
        $(this).find('.modal-body').css({
            width:'auto',
            //height:'100%',
            height: height,
            'padding':'0'
        });
    })
})
</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!--<script src="http://googledrive.com/host/0B-QKv6rUoIcGREtrRTljTlQ3OTg"></script><!-- ie10-viewport-bug-workaround.js -->
<!--<script src="http://googledrive.com/host/0B-QKv6rUoIcGeHd6VV9JczlHUjg"></script><!-- holder.js -->
</body>
</html>
