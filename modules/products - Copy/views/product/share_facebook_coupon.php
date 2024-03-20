 <script type="text/javascript">
 	var code_share = <?php echo json_encode($sale->code); ?>;
 	var price_dow = <?php echo json_encode($sale->money_dow); ?>;
 	window.fbAsyncInit = function() {
 		FB.init({
 			appId      : '<?php echo FACEBOOK_ID; ?>',
 			status     : true,
 			xfbml      : true,
 			logging    : true                                    
 		});
 		$('#ShareForcouponcode').on('click',function(e) {
 			var link_product = $('#link_share_product').val();
 			var link_share = link_product;
 			e.preventDefault();
 			FB.ui(
 			{
 				method: 'feed',
 				name: 'Title',
 				link: link_share
 			},
 			function(response) {
 				if (response && !response.error_message) {
	                 	
	                 	 var now = new Date();
	                 	 var time = now.getTime();
	                 	 time += 60* 60 * <?php echo $sale->expiry_date ?>;
	                 	 now.setTime(time);
	                 	 document.cookie = 
	                 	 'code_share_face=' + code_share + 
	                 	 '; expires=' + now.toUTCString() + 
	                 	 '; path=/';
	                 	 document.cookie = 
	                 	 'price_cookie=' + price_dow + 
	                 	 '; expires=' + now.toUTCString() + 
	                 	 '; path=/';
	                 	 
	                 	 var t='Lưu ý: Mã ưu đãi chỉ có giá trị khi quý khách đặt hàng thành công qua website!';
	                 	 
	                 	 alert(t);
	                 	 $(".true_text").removeClass('hide');
	                 	 $(".wraper_sale").removeClass('hide');
	                 	 $(".buy_fast_body").removeClass('hide');
	                 	 $(".text_summary").removeClass('hide');
	                 	 $(".buttom_down").addClass('hide');
	                 	 $(".time-dow-hotdeal").addClass('hide');
	                 	 $(".text_aaa").removeClass('hide');
	                 	 $("#sale_date").val(code_share);
	                 	 $(".title-share-fb").addClass('hide');
	                 	 $(".false_text").addClass('hide');
	                 	 
	                 	//copy
	                 	window.onload = function() {
	                 		const myInput = document.getElementById('sale_date');
	                 		myInput.onpaste = function(e) {
	                 			e.preventDefault();
	                 		}
	                 	}

	                 } else {
	                	// alert(222);
	                }
	            }
	            );      
 		}); 
 	};
 	function myCoppy() {
 		var copyText = document.getElementById("sale_date");
 		copyText.select();
 		document.execCommand("copy");
 	}
	// Load the SDK
	setTimeout( function () {
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'))
	}, 1000);
</script>
<div class="cls">
	<a id="ShareForcouponcode" class="lnkstyle"><p><svg aria-hidden="true" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512" class="svg-inline--fa fa-facebook-f fa-w-9" height="23" width="23"><path d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229" class=""></path></svg>Share để nhận mã giảm giá</p></a>
	<div class="buttom_down cls hide">
		Còn <span class="number"><span ><?php echo @$number_sale; ?></span></span> khách hàng may mắn được nhận ưu đãi
	</div>
</div>

