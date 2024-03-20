
// function setMapLocation(value)
// {
// 	if (value in storeList['location'])
// 	{
// 		if (map) {
// 			map.setCenter(new google.maps.LatLng(storeList['location'][value].lat, storeList['location'][value].lng));
// 			map.setZoom(14);
// 			window.setTimeout(function(){
// 				google.maps.event.trigger(marker[value], 'click');
// 			},1000);
// 			jQuery('#store_address').html('<a href="'+storeList['location'][value].link+'" target="_blank" rel="nofollow">'+storeList['location'][value].address+'</a>');
// 			jQuery('#store_detail_info').show();
// 		}
// 	}
// }





function changeCity22($city_id,$id){
	// var domain = window.location.hostname;
	// domain = domain+'/he-thong-cua-hang.html';
    $.ajax({
		type : 'get',
		url : 'index.php?module=department&view=department&raw=1&task=loadDistricts',
		dataType : 'html',
		data: {city_id:$city_id},
		success : function(data){
            location.reload();
            // window.location.href = 'https://suachualaptop24h.com/he-thong-cua-hang.html';
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}

function changeDistrict($city_id,$id){
    $.ajax({
		type : 'get',
		url : 'index.php?module=department&view=department&raw=1&task=get_agency',
		dataType : 'html',
		data: {district_id:$city_id},
		success : function(data){
            location.reload();
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}

$(window).on("load",function(){
    $(".wrapper-list-agency").mCustomScrollbar({
            theme:"minimal"
    });
});
function get_info($city_id,$id){
    $.ajax({
		type : 'get',
		url : 'index.php?module=department&view=department&raw=1&task=get_agency',
		dataType : 'html',
		data: {district_id:$city_id},
		success : function(data){
                $("#"+id).append(data);
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}    

$(document).ready(function(){
	$('.name-agency').click(function(){
		var data_id = $(this).attr('data-id');
		$('.content-map-active .item').hide();
		$('.content-map-active .item-'+data_id).show();
	});

});