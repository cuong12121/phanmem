function changeCity22($city_id,$id){

    $.ajax({
		type : 'get',
		url : 'index.php?module=department&view=department&raw=1&task=loadDistricts',
		dataType : 'html',
		data: {city_id:$city_id},
		success : function(data){
            location.reload();
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


$(function(){
	$('.button_map').click(function(){
		var body = $("html, body");
		body.stop().animate({scrollTop:$('#map_canvas').offset().top}, 500, 'swing', function() { 
		}); 
	});

	$('.list-image-r .owl-carousel').owlCarousel({
          loop:true,
          nav:true,
          navText: [
            "‹",
            "›"
            ],
          dots:false,
          pagination:true,
          dots: false,
          autoplay: true,
          autoplayTimeout:3000,
          items:1,
          lazyLoad : true
    });
	
	
});

