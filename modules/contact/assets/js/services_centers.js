$(document).ready( function(){
	// alert(111);
	$('.btn_search_add').click(function(){

		var manufactories_sl = $('#manufactories_sl').val();
		var province_sl = $('#province_sl').val();

		if(!manufactories_sl ){
			alert("Bạn phải chọn hãng")
			return false;
		}

		if(!province_sl ){
			alert("Bạn phải chọn khu vực")
			return false;
		}

		
		$.ajax({
			type: "POST",
			url: "/index.php?module=contact&view=services_centers&task=ajax_get_services_centers&raw=1",
			data: {manufactories_sl:manufactories_sl,province_sl:province_sl},
			cache: false,
			success: function(html){
				// console.log(html);
				$(".wrapper-list-sv .wrapper-list-all").html(html);
				// $(".item_tabs").removeClass('active');
				// $("#item_tab_"+area_id).addClass('active');
			}
		});
	});

});