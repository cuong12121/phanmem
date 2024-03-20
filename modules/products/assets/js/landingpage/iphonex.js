$(document).ready(function(){
	scroll_to_session();
}); 
function scroll_to_session(){

	
	
	$(window).scroll(function () {

		st = $(this).scrollTop();		
		var section2_top = $('.section2').offset().top;
		var section2_height = $('.section2').height() ;
		var section2_bottom = section2_top + section2_height ;
		var max_transf = 90;
		var top_transf = 0;
		var section2_content_top = section2_top + top_transf;

		
		 // console.log(st);
		 //  console.log(section2_content_top);
		 // màn hình hiển thị 
		scroll_transfrom($('#design_display'), st, section2_top,section2_height,max_transf,top_transf);

		scroll_transfrom($('#section2_summary'), st, section2_top,80,40,top_transf);
		
		var myVideo = document.getElementById("video_iphonex");
		// $('#video_iphonex').play();


		
		scroll_play_video("video_iphonex",st,$('.section3'),$('.video_iphonex_wrapper'));
		scroll_change_bg('section3',st);

		scroll_play_video("video_super_retina",st,$('.section4'),$('.video_super_retina_wrapper'));
		scroll_transfrom($('.video_super_retina_wrapper'), st, $('.section4').offset().top,$('.section4').height(),90,0);
		scroll_change_bg('section4',st);

		scroll_transfrom($('.iphone_oled_wrapper'), st, $('.section5').offset().top,$('.section5').height(),90,0);
		scroll_change_bg('section5',st);

		scroll_transfrom($('.durable_glass_wrapper'), st, $('.section6').offset().top,$('.section6').height(),90,0);
		scroll_change_bg('section6',st);

		scroll_transfrom($('.face_id_secure_authentication_wrapper'), st, $('.section7').offset().top,$('.section7').height(),90,0);
		scroll_change_bg('section7',st);

		scroll_play_video("face_id_mapping",st,$('.section8'),$('.face_id_mapping_wrapper'));
		scroll_transfrom($('.face_id_mapping_wrapper'), st, $('.section8').offset().top,$('.section8').height(),90,0);
		scroll_change_bg('section8',st);
	

		scroll_play_video("animoji",st,$('.section9'),$('.animoji_wrapper'));
		scroll_transfrom($('.animoji_wrapper'), st, $('.section9').offset().top,$('.section9').height(),90,0);
		// scroll_change_bg('section9',st);
	

		scroll_transfrom($('#camera_top_summary'), st, $('.section10').offset().top,80,40,0);
		scroll_transfrom($('.camera_wrapper'), st, $('.section10').offset().top,$('.section10').height(),90,0);

		scroll_transfrom($('.cpu_wrapper'), st, $('.section11').offset().top,$('.section11').height(),90,0);
		scroll_change_bg('section11',st);

		scroll_transfrom($('#charging_top_summary'), st, $('.section12').offset().top,80,40,0);
		scroll_transfrom($('.charging_wrapper'), st, $('.section12').offset().top,$('.section12').height(),90,0);
		scroll_change_bg('section12',st);

		scroll_transfrom($('#ios_top_summary'), st, $('.section13').offset().top,80,40,0);
		scroll_transfrom($('.ios_wrapper'), st, $('.section13').offset().top,$('.section13').height(),90,0);
		

		scroll_transfrom($('#accessories_top_summary'), st, $('.section14').offset().top,80,40,0);
		scroll_transfrom($('.accessories_wrapper'), st, $('.section14').offset().top,$('.section13').height(),90,0);
		
	});
}

function scroll_play_video(element_id, st, section_contain,wrapper){
	myVideo = document.getElementById(element_id);
	if (st > ( section_contain.offset().top - $(window).height()/2) ) {
		    // $(".section3 video").fadeIn();
		    if(wrapper.hasClass('played') != true){
				myVideo.play();
		   		wrapper.addClass('played');
		    }
		   
		}else{
			if(st < ($('.section3').offset().top - $(window).height() ) ){
				myVideo.load();	
			}
			
			wrapper.removeClass('played');
		}

}

function scroll_transfrom(element, st, pos_top,croll_height,max_transf,top_transf){
	start_top = pos_top + top_transf; 
	pos_bottom = pos_top + croll_height;
	if(st < start_top){
			element.css({'transform' : 'translate(' + 0 +'px, ' + max_transf + 'px)'})
	}else{
		if(st <= pos_bottom){
			var transf = max_transf - (((st - start_top)/croll_height) * max_transf) * 2	;
			if(transf < 0)
				transf = 0;
			if(transf > max_transf)
				transf = max_transf;
			element.css({'transform' : 'translate(' + 0 +'px, ' + transf + 'px)'})	
		}else{
			element.css({'transform' : 'translate(' + 0 +'px, ' + 0 + 'px)'})	
		}
	}
}

function scroll_change_bg(section_contain,st){
	// var element = 
	var feature_top = $('.'+section_contain+' .iphonex_feature').offset().top;
	var feature_height = $('.'+section_contain+' .iphonex_feature').height() + 224;
	// console.log(feature_top);
	// console.log($('.section5  .iphonex_feature').height() );
	// 224: padding
	if (st > feature_top && st < ( feature_top + feature_height ) ) {
		var bg_opacity = (st - feature_top)/feature_height ;	 
		if(bg_opacity < 0.1){
			bg_opacity = 0.1;
		}
					
		$('.'+section_contain+'').css({'background' : 'rgba(195, 195, 195,'+bg_opacity+')' });		
	   
	}else{
		$('.'+section_contain+'').css({'background' : '#FFF'});	
	}
}


