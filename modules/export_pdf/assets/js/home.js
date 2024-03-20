// $.ajax({
// 		type: "POST",
// 		url: "/index.php?module=home&view=home&task=fetch_pages&raw=1",
// 		data: {cid:85},
// 		cache: false,
// 		success: function(html){
// 			$("#box_product").html(html);
// 			$(".item_tabs").removeClass('active');
// 			$("#item_tab_86").addClass('active');
// 		}
// 	});


function load_product(area_id,cat_id){

	$.ajax({
		type: "POST",
		url: "/index.php?module=home&view=home&task=fetch_pages&raw=1",
		data: {cid:cat_id},
		cache: false,
		success: function(html){
			$(".xemthem-main").hide();
			$("#box_product").html(html);
			$(".item_tabs").removeClass('active');
			$("#item_tab_"+area_id).addClass('active');
		}
	});
}
