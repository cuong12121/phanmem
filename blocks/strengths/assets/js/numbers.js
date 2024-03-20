$(function() {
	$(window).scroll(function () {
		element_id = $('.block-strengths-numbers');
		st2 = $(this).scrollTop();
		if (st2 > ( element_id.offset().top - $(window).height()) + 100 ) {
			if (!element_id.hasClass('hello')) {
				element_id.addClass('hello');
				$('.txt').each(function( index ) {
					var txt = $(this).attr('data-t');
					var id = $(this).attr('id');
					var dis = 2000 / (txt);
					var count = setInterval(function(){
						// alert(id);
						var txt_old_t = $('#'+id).text();
						// console.log(txt_old_t);
						var txt_old = parseInt(txt_old_t);
						if(txt >= 20000) {
							txt_new = txt_old + 200;
						}
						else if(txt >= 5000) {
							txt_new = txt_old + 40;
						} else if(txt >= 1000) {
							txt_new = txt_old + 10;
						}
						else {
							txt_new = txt_old + 1;
						}
						
						$('#'+id).text(txt_new);
						if(txt >= 20000) {
							if(txt_old >= txt - 200) {
								clearInterval(count);
							}
						} else
						if(txt >= 5000) {
							if(txt_old >= txt - 40) {
								clearInterval(count);
							}
						} else
						if(txt >= 1000) {
							if(txt_old >= txt - 10) {
								clearInterval(count);
							}
						}
						else {
							if(txt_old >= txt - 1) {
								clearInterval(count);
							}
						}

					},dis)

				});
			}

		}

	})
})