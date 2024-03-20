   $(document).ready(function(){
// x = cleanString('Nguyễn Duy Mạnh');
// alert(x);
link1 = '<a href="https://delecweb.com/ct-danh-gia-seo-:-do-dai-cum-tu-khoa.html" target="_blank" title="Độ dài cụm từ khóa chính">Độ dài cụm từ khóa chính</a>';
link2 = '<a href="https://delecweb.com/ct-cum-tu-khoa-trong-duong-dan-ten-hieu.html" target="_blank" title="Cụm từ khóa chính trong tên hiệu (alias)">Cụm từ khóa chính trong tên hiệu (alias)</a>';
link3 = '<a href="https://delecweb.com/ct-thuoc-tinh-alt-hinh-anh.html" target="_blank" title="Các thuộc tính alt hình ảnh">Các thuộc tính alt hình ảnh</a>';
link4 = '<a href="https://delecweb.com/ct-lien-ket-noi-bo.html" target="_blank" title="Các liên kết nội bộ">Các liên kết nội bộ</a>';
link5 = '<a href="https://delecweb.com/ct-lien-ket-ngoai.html" target="_blank" title="Các liên kết ngoài">Các liên kết ngoài</a>';
link6 = '<a href="https://delecweb.com/ct-cum-tu-khoa-trong-tieu-de.html" target="_blank" title="Cụm từ khóa chính trong Title seo">Cụm từ khóa chính trong Title seo</a>';
link7 = '<a href="https://delecweb.com/ct-chieu-rong-tieu-de-seo.html" target="_blank" title="Chiều rộng tiêu đề Seo">Chiều rộng tiêu đề Seo</a>';
link8 = '<a href="https://delecweb.com/ct-chieu-dai-mo-ta-meta.html" target="_blank" title="Chiều dài mô tả Meta">Chiều dài mô tả Meta</a>';
link9 = '<a href="https://delecweb.com/ct-chieu-dai-van-ban.html" target="_blank" title="Chiều dài của văn bản">Chiều dài của văn bản</a>';
link10 = '<a href="https://delecweb.com/ct-mat-do-cum-tu-khoa.html" target="_blank" title="Mật độ Cụm từ khóa chính">Mật độ Cụm từ khóa chính</a>';

var id = $('input[name=id]').val();
var result = '';
// bắt đầu vào

// content
if($('#content').length) {
	c_content = $('#content').val().toLowerCase();
} else {
	c_content = $('#description').val().toLowerCase();
}

// console.log(c_content);
// length content
result_content1 ="";
result_content2 ="";
result_content3 ="";
result_content = check_content(c_content);
if(result_content[0] == 1) {
	result_content1 = result_content[1];
} else if(result_content[0] == 2) {
	result_content2 = result_content[1];
}
else if(result_content[0] == 3) {
	result_content3 = result_content[1];
}

// image in content

result_content_img1 = "";
result_content_img2 ="";
result_content_img3 ="";

c_keyword = $('#check_keyword').val().toLowerCase();

//alert(c_keyword);
result_content_img = check_content_img(c_content,c_keyword);

if(result_content_img[0] == 1) {
	result_content_img1 = result_content_img[1];
} else if(result_content_img[0] == 2) {
	result_content_img2 = result_content_img[1];
}
else if(result_content_img[0] == 3) {
	result_content_img3 = result_content_img[1];
}


// link in content

url_root = $('#url_root').val();
// console.log(url_root);

result_content_link11 = "";
result_content_link12 ="";
result_content_link13 ="";
result_content_link21 = "";
result_content_link22 ="";
result_content_link23 ="";

result_content_link = check_content_link(c_content,url_root);

if(result_content_link[0] == 1) {
	result_content_link11 = result_content_link[11];
	result_content_link21 = result_content_link[21];
} else {
	if(result_content_link[10] == 1) {
		result_content_link11 = result_content_link[11];
	} else if (result_content_link[10] == 3) {
		result_content_link13 = result_content_link[11];
	}
	if(result_content_link[20] == 1) {
		result_content_link21 = result_content_link[21];
	} else if (result_content_link[20] == 3) {
		result_content_link23 = result_content_link[21];
	}
}


//keywword

//c_keyword = $('#check_keyword').val();
result_keyword1 ="";
result_keyword2 ="";
result_keyword3 ="";
result_keyword = check_main_keyword(c_keyword);
if(result_keyword[0] == 1) {
	result_keyword1 = result_keyword[1];
} else if(result_keyword[0] == 2) {
	result_keyword2 = result_keyword[1];
}
else if(result_keyword[0] == 3) {
	result_keyword3 = result_keyword[1];
}



// alias
c_alias = $('#alias').val().toLowerCase();
result_keyword_alias1 ="";
result_keyword_alias2 ="";
result_keyword_alias3 ="";
c_keyword_x = xoa_dau(c_keyword);
//alert(c_keyword_x);

result_keyword_alias =  check_main_keyword_alias(c_keyword_x,c_alias);
if(result_keyword_alias[0] == 1) {
	result_keyword_alias1 = result_keyword_alias[1];
}
if(result_keyword_alias[0] == 2) {
	result_keyword_alias2 = result_keyword_alias[1];
}
else if(result_keyword_alias[0] == 3) {
	result_keyword_alias3 = result_keyword_alias[1];
}

// Cụm từ khóa chính in seo title

result_main_keyword_title_seo1 ="";
result_main_keyword_title_seo2 ="";
result_main_keyword_title_seo3 ="";
// c_keyword_x = xoa_dau(c_keyword); 
result_main_keyword_title_seo =  check_main_keyword_title_seo(c_keyword,$('#seo_title').val().toLowerCase());
if(result_main_keyword_title_seo[0] == 1) {
	result_main_keyword_title_seo1 = result_main_keyword_title_seo[1];
}
else if(result_main_keyword_title_seo[0] == 3) {
	result_main_keyword_title_seo3 = result_main_keyword_title_seo[1];
}

//description

c_description = $('#seo_description').val().toLowerCase();

result_description1 = "";
result_description2 ="";
result_description3 ="";
result_description = check_seo_description(c_description);
if(result_description[0] == 1) {
	result_description1 = result_description[1];
} else if(result_description[0] == 2) {
	result_description2 = result_description[1];
}
else if(result_description[0] == 3) {
	result_description3 = result_description[1];
}


// seo title

c_title = $('#seo_title').val().toLowerCase();
result_title1 = "";
result_title2 ="";
result_title3 ="";
result_title = check_seo_title(c_title);
if(result_title[0] == 1) {
	result_title1 = result_title[1];
} else if(result_title[0] == 2) {
	result_title2 = result_title[1];
}
else if(result_title[0] == 3) {
	result_title3 = result_title[1];
}

result_main_keyword_content1 = "";
result_main_keyword_content2 ="";
result_main_keyword_content3 ="";
if($('#content').length) {
	result_main_keyword_content = check_main_keyword_content($('#check_keyword').val().toLowerCase(),$('#content').val().toLowerCase());
} else {
	result_main_keyword_content = check_main_keyword_content($('#check_keyword').val().toLowerCase(),$('#description').val().toLowerCase());
}

if(result_main_keyword_content[0] == 1) {
	result_main_keyword_content1 = result_main_keyword_content[1];
} else if(result_main_keyword_content[0] == 2) {
	result_main_keyword_content2 = result_main_keyword_content[1];
}
else if(result_main_keyword_content[0] == 3) {
	result_main_keyword_content3 = result_main_keyword_content[1];
}


if(result_keyword1) {
	result1 = result_keyword1;
	result2 = '';
	result3 = '';
}else {
	result1 = result_keyword1+result_description1+result_title1+result_content1
	+result_keyword_alias1+result_content_img1+result_content_link11+result_content_link21
	+result_main_keyword_title_seo1+result_main_keyword_content1;
	result2 = result_keyword2+result_description2+result_title2+result_content2
	+result_keyword_alias2+result_content_img2+result_content_link12+result_content_link22
	+result_main_keyword_title_seo2+result_main_keyword_content2;
	result3 = result_keyword3+result_description3+result_title3+result_content3
	+result_keyword_alias3+result_content_img3+result_content_link13+result_content_link23
	+result_main_keyword_title_seo3+result_main_keyword_content3;
}



$('.van_de').html(result1);
$('.cai_tien').html(result2);
$('.kq_tot').html(result3);

point_seo();

// hết bắt đầu vào

// bắt đầu sửa

if($('#content').length) {
	CKEDITOR.instances['content'].on('change', function() {
		CKEDITOR.instances['content'].updateElement();
		change_content = $('#content').val().toLowerCase();
// console.log(change_content);
c_keyword = $('#check_keyword').val().toLowerCase();
if(c_keyword) {
	change_result_content_img = check_content_img(change_content,c_keyword);
	if(change_result_content_img[0] == 1) {
		$('.check_content_img').remove();
		$('.van_de').prepend(change_result_content_img[1]);
	} else if(change_result_content_img[0] == 2) {
		$('.check_content_img').remove();
		$('.cai_tien').prepend(change_result_content_img[1]);
	}
	else if(change_result_content_img[0] == 3) {
		$('.check_content_img').remove();
		$('.kq_tot').prepend(change_result_content_img[1]);
	}

	result_content = check_content(change_content);
	if(result_content[0] == 1) {
		$('.check_content').remove();
		$('.van_de').prepend(result_content[1]);
	} else if(result_content[0] == 2) {
		$('.check_content').remove();
		$('.cai_tien').prepend(result_content[1]);
	}
	else if(result_content[0] == 3) {
		$('.check_content').remove();
		$('.kq_tot').prepend(result_content[1]);
	}

	result_content_link = check_content_link(change_content,url_root);
	if(result_content_link[0] == 1) {
		$('.check_content_link').remove();
		$('.van_de').prepend(result_content_link[11]);
		$('.van_de').prepend(result_content_link[21]);
	} else {
		$('.check_content_link').remove();
		if(result_content_link[10] == 3) {
			$('.kq_tot').prepend(result_content_link[11]);
		} else if (result_content_link[10] == 1) {
			$('.van_de').prepend(result_content_link[11]);
		}
		if(result_content_link[20] == 3) {
			$('.kq_tot').prepend(result_content_link[21]);
		} else if (result_content_link[20] == 1) {
			$('.van_de').prepend(result_content_link[21]);
		}
	}

	result_main_keyword_content = check_main_keyword_content($('#check_keyword').val().toLowerCase(),$('#content').val().toLowerCase());
	if(result_main_keyword_content[0] == 1) {
		$('.check_main_keyword_content').remove();
		$('.van_de').prepend(result_main_keyword_content[1]);
	} else if(result_main_keyword_content[0] == 3) {
		$('.check_main_keyword_content').remove();
		$('.kq_tot').prepend(result_main_keyword_content[1]);
	}
}
point_seo()
});
} else {
	CKEDITOR.instances['description'].on('change', function() {
		CKEDITOR.instances['description'].updateElement();
		change_content = $('#description').val().toLowerCase();
// console.log(change_content);
c_keyword = $('#check_keyword').val().toLowerCase();
if(c_keyword) {
	change_result_content_img = check_content_img(change_content,c_keyword);
	if(change_result_content_img[0] == 1) {
		$('.check_content_img').remove();
		$('.van_de').prepend(change_result_content_img[1]);
	} else if(change_result_content_img[0] == 2) {
		$('.check_content_img').remove();
		$('.cai_tien').prepend(change_result_content_img[1]);
	}
	else if(change_result_content_img[0] == 3) {
		$('.check_content_img').remove();
		$('.kq_tot').prepend(change_result_content_img[1]);
	}

	result_content = check_content(change_content);
	if(result_content[0] == 1) {
		$('.check_content').remove();
		$('.van_de').prepend(result_content[1]);
	} else if(result_content[0] == 2) {
		$('.check_content').remove();
		$('.cai_tien').prepend(result_content[1]);
	}
	else if(result_content[0] == 3) {
		$('.check_content').remove();
		$('.kq_tot').prepend(result_content[1]);
	}

	result_content_link = check_content_link(change_content,url_root);
	if(result_content_link[0] == 1) {
		$('.check_content_link').remove();
		$('.van_de').prepend(result_content_link[11]);
		$('.van_de').prepend(result_content_link[21]);
	} else {
		$('.check_content_link').remove();
		if(result_content_link[10] == 3) {
			$('.kq_tot').prepend(result_content_link[11]);
		} else if (result_content_link[10] == 1) {
			$('.van_de').prepend(result_content_link[11]);
		}
		if(result_content_link[20] == 3) {
			$('.kq_tot').prepend(result_content_link[21]);
		} else if (result_content_link[20] == 1) {
			$('.van_de').prepend(result_content_link[21]);
		}
	}

	result_main_keyword_content = check_main_keyword_content($('#check_keyword').val().toLowerCase(),$('#description').val().toLowerCase());
	if(result_main_keyword_content[0] == 1) {
		$('.check_main_keyword_content').remove();
		$('.van_de').prepend(result_main_keyword_content[1]);
	} else if(result_main_keyword_content[0] == 3) {
		$('.check_main_keyword_content').remove();
		$('.kq_tot').prepend(result_main_keyword_content[1]);
	}
}
point_seo()
});
}



$('#title').change(function(){
	change_title =$(this).val();
	change_main_keyword = $('#check_keyword').val().toLowerCase();
	change_seo_title = $('#seo_title').val().toLowerCase();
	change_alias = $('#alias').val().toLowerCase();

	if(!change_seo_title) {	
		$('#seo_title').val(change_title).toLowerCase();
	}
	if(!change_alias) {
		alias = xoa_dau(change_title);
		alias = alias.toLowerCase();
		alias = alias.split(' ').join('-');
		$('#alias').val(alias);
	}
	if(!change_main_keyword) {	
		$('#check_keyword').val(change_title).toLowerCase();
		main_keyword_change();
	}
});

$('#check_keyword').keyup(function(){
	check_keywords = $(this).val();
	main_keyword_change();
})

//alias

$('#alias').keyup(function(){ 
	c_alias = $(this).val();
	change_main_keyword = $('#check_keyword').val().toLowerCase(); 
	if(change_main_keyword) {
		c_keyword_x = xoa_dau(change_main_keyword); 
		result_keyword_alias =  check_main_keyword_alias(c_keyword_x,c_alias);
		if(result_keyword_alias[0] == 2) {
			$('.check_main_keyword_alias').remove();
			$('.cai_tien').prepend(result_keyword_alias[1]);
		}
		else if(result_keyword_alias[0] == 3) {
			$('.check_main_keyword_alias').remove();
			$('.kq_tot').prepend(result_keyword_alias[1]);
		}

	}
	point_seo()

})


$('#seo_description').keyup(function(){
	change_seo_description = $(this).val().toLowerCase();
	if($('#seo_description').val().toLowerCase()) {
		result_description = check_seo_description(change_seo_description);
		if(result_description[0] == 1) {
			$('.check_seo_description').remove();
			$('.van_de').prepend(result_description[1]);
	// result_description1 = result_description[1];
} else if(result_description[0] == 2) {
	$('.check_seo_description').remove();
	$('.cai_tien').prepend(result_description[1]);
}
else if(result_description[0] == 3) {
	$('.check_seo_description').remove();
	$('.kq_tot').prepend(result_description[1]);
}
}
point_seo()
})

$('#seo_title').keyup(function(){
	change_seo_title = $(this).val();
	result_title = check_seo_title(change_seo_title);
	if($('#check_keyword').val().toLowerCase()) {
		if(result_title[0] == 1) {
			$('.check_seo_title').remove();
			$('.van_de').prepend(result_title[1]);
		} else if(result_title[0] == 2) {
			$('.check_seo_title').remove();
			$('.cai_tien').prepend(result_title[1]);
		}
		else if(result_title[0] == 3) {
			$('.check_seo_title').remove();
			$('.kq_tot').prepend(result_title[1]);
		}

		result_main_keyword_title_seo = check_main_keyword_title_seo($('#check_keyword').val().toLowerCase(),$('#seo_title').val());
		if(result_main_keyword_title_seo[0] == 1) {
			$('.check_main_keyword_title_seo').remove();
			$('.van_de').prepend(result_main_keyword_title_seo[1]);
	// result_title1 = result_title[1];
} else if(result_main_keyword_title_seo[0] == 3) {
	$('.check_main_keyword_title_seo').remove();
	$('.kq_tot').prepend(result_main_keyword_title_seo[1]);
}

}

point_seo();
})

// hết bắt đầu sửa

})

// $('.list_keyword .item').click(function(){
// 	keyword = $(this).attr('keyword');
// 	$('#check_keyword').val(keyword);
// 	point_seo();
// })


function main_keyword_change() {
	change_main_keyword = $('#check_keyword').val().toLowerCase();
	if($.trim(change_main_keyword)!= '') {
		if($('#content').length) {
			c_content = $('#content').val().toLowerCase();
		} else {
			c_content = $('#description').val().toLowerCase();
		}
		
// length content
result_content1 ="";
result_content2 ="";
result_content3 ="";
result_content = check_content(c_content);

if(result_content[0] == 1) {
	result_content1 = result_content[1];
} else if(result_content[0] == 2) {
	result_content2 = result_content[1];
}
else if(result_content[0] == 3) {
	result_content3 = result_content[1];
}

// image in content

result_content_img1 = "";
result_content_img2 ="";
result_content_img3 ="";
c_keyword = $('#check_keyword').val().toLowerCase();
result_content_img = check_content_img(c_content,c_keyword);

if(result_content_img[0] == 1) {
	result_content_img1 = result_content_img[1];
} else if(result_content_img[0] == 2) {
	result_content_img2 = result_content_img[1];
}
else if(result_content_img[0] == 3) {
	result_content_img3 = result_content_img[1];
}


// link in content

url_root = $('#url_root').val().toLowerCase();
// console.log(url_root);

result_content_link11 = "";
result_content_link12 ="";
result_content_link13 ="";
result_content_link21 = "";
result_content_link22 ="";
result_content_link23 ="";

result_content_link = check_content_link(c_content,url_root);

if(result_content_link[0] == 1) {
	result_content_link11 = result_content_link[11];
	result_content_link21 = result_content_link[21];
} else {
	if(result_content_link[10] == 1) {
		result_content_link11 = result_content_link[11];
	} else if (result_content_link[10] == 3) {
		result_content_link13 = result_content_link[11];
	}
	if(result_content_link[20] == 1) {
		result_content_link21 = result_content_link[21];
	} else if (result_content_link[20] == 3) {
		result_content_link23 = result_content_link[21];
	}
}


//keywword

//c_keyword = $('#check_keyword').val();
result_keyword1 ="";
result_keyword2 ="";
result_keyword3 ="";
result_keyword = check_main_keyword(c_keyword);
if(result_keyword[0] == 1) {
	result_keyword1 = result_keyword[1];
} else if(result_keyword[0] == 2) {
	result_keyword2 = result_keyword[1];
}
else if(result_keyword[0] == 3) {
	result_keyword3 = result_keyword[1];
}



// alias
c_alias = $('#alias').val().toLowerCase();
result_keyword_alias1 ="";
result_keyword_alias2 ="";
result_keyword_alias3 ="";
c_keyword_x = xoa_dau(c_keyword); 
result_keyword_alias =  check_main_keyword_alias(c_keyword_x,c_alias);
if(result_keyword_alias[0] == 1) {
	result_keyword_alias1 = result_keyword_alias[1];
}
if(result_keyword_alias[0] == 2) {
	result_keyword_alias2 = result_keyword_alias[1];
}
else if(result_keyword_alias[0] == 3) {
	result_keyword_alias3 = result_keyword_alias[1];
}

// Cụm từ khóa chính in seo title

result_main_keyword_title_seo1 ="";
result_main_keyword_title_seo2 ="";
result_main_keyword_title_seo3 ="";
// c_keyword_x = xoa_dau(c_keyword); 
result_main_keyword_title_seo =  check_main_keyword_title_seo(c_keyword,$('#seo_title').val().toLowerCase());
if(result_main_keyword_title_seo[0] == 1) {
	result_main_keyword_title_seo1 = result_main_keyword_title_seo[1];
}
else if(result_main_keyword_title_seo[0] == 3) {
	result_main_keyword_title_seo3 = result_main_keyword_title_seo[1];
}

//description

c_description = $('#seo_description').val().toLowerCase();
result_description1 = "";
result_description2 ="";
result_description3 ="";
result_description = check_seo_description(c_description);
if(result_description[0] == 1) {
	result_description1 = result_description[1];
} else if(result_description[0] == 2) {
	result_description2 = result_description[1];
}
else if(result_description[0] == 3) {
	result_description3 = result_description[1];
}


// seo title

c_title = $('#seo_title').val().toLowerCase();
result_title1 = "";
result_title2 ="";
result_title3 ="";
result_title = check_seo_title(c_title);
if(result_title[0] == 1) {
	result_title1 = result_title[1];
} else if(result_title[0] == 2) {
	result_title2 = result_title[1];
}
else if(result_title[0] == 3) {
	result_title3 = result_title[1];
}


result_main_keyword_content1 = "";
result_main_keyword_content2 ="";
result_main_keyword_content3 ="";
if($('#content').length) {
	result_main_keyword_content = check_main_keyword_content($('#check_keyword').val().toLowerCase(),$('#content').val().toLowerCase());
} else {
	result_main_keyword_content = check_main_keyword_content($('#check_keyword').val().toLowerCase(),$('#description').val().toLowerCase());
}

if(result_main_keyword_content[0] == 1) {
	result_main_keyword_content1 = result_main_keyword_content[1];
} else if(result_main_keyword_content[0] == 2) {
	result_main_keyword_content2 = result_main_keyword_content[1];
}
else if(result_main_keyword_content[0] == 3) {
	result_main_keyword_content3 = result_main_keyword_content[1];
}

// console.log(result_keyword1);


if(result_keyword1) {
	result1 = result_keyword1;
	result2 = '';
	result3 = '';
}else {
	result1 = result_keyword1+result_description1+result_title1+result_content1
	+result_keyword_alias1+result_content_img1+result_content_link11+result_content_link21
	+result_main_keyword_title_seo1+result_main_keyword_content1;
	result2 = result_keyword2+result_description2+result_title2+result_content2
	+result_keyword_alias2+result_content_img2+result_content_link12+result_content_link22
	+result_main_keyword_title_seo2+result_main_keyword_content2;
	result3 = result_keyword3+result_description3+result_title3+result_content3
	+result_keyword_alias3+result_content_img3+result_content_link13+result_content_link23
	+result_main_keyword_title_seo3+result_main_keyword_content3;
}



$('.van_de').html(result1);
$('.cai_tien').html(result2);
$('.kq_tot').html(result3);

}


point_seo()


}


function click_keyword_item(i){
	$('.list_keyword .item').removeClass('item_active');
	stt = $('#keyword_'+i).attr('data-stt');
	$('#check_keyword_active').val(stt);
	$('#keyword_'+i).addClass('item_active');
	reset_keywword();
}


// $('.keyword_item').click(function(){
// 	$('.list_keyword .item').removeClass('item_active');
// 	stt = $(this).attr('data-stt');
// 	$('#check_keyword_active').val(stt);
// 	$(this).addClass('item_active');
// 	main_keyword_change();

// })

function reset_keywword(){
	if($('.keyword_item').length){
		$( ".keyword_item" ).each(function() {
			if($( this ).hasClass( "item_active" )){
				keyword = $(this).attr('keyword');
				$('#check_keyword').val(keyword);
				main_keyword_change();
			}
		});
	}
}

function check_main_keyword(main_keyword){

	result_keyword = new Array();
	if(!main_keyword) {
		result_keyword[1] = '<li class="check_main_keyword"><font>'+link1+':</font> Chưa có cụm từ khóa chính. Cần có cụm từ khóa chính để đánh giá seo!</li>'; 
		result_keyword[0] = 1;
	} else {
		arr_main_keyword = main_keyword.split(' ');
		if(arr_main_keyword.length <= 6) {
			result_keyword[0] = 3;
			result_keyword[1] = '<li class="check_main_keyword"><font>'+link1+':</font> Tốt</li>'; 
		} else {
			result_keyword[0] = 2;
			result_keyword[1] = '<li class="check_main_keyword"><font>'+link1+':</font> Cụm từ khóa chính dài '+arr_main_keyword.length+' từ. Dài hơn so với mức khuyến nghị là 6 từ. Hãy rút gọn!</li>'; 
		}
	}
	return result_keyword;
} 

function check_seo_description(seo_description){
	result_description = new Array();
	if(!seo_description) {
		result_description[1] = '<li class="check_seo_description"><font>'+link8+':</font> Chưa có mô tả meta!</li>'; 
		result_description[0] = 1;
	} else {
		if(seo_description.length <= 120) {
			result_description[0] = 2;
			result_description[1] = '<li class="check_seo_description"><font>'+link8+':</font> Mô tả meta quá ngắn ( '+ seo_description.length +' ký tự). Khuyến nghị từ 120 - 156 ký tự.</li>'; 
		} else if(seo_description.length <= 156)  {
			result_description[0] = 3;
			result_description[1] = '<li class="check_seo_description"><font>'+link8+':</font> Tốt</li>'; 
		}else if(seo_description.length > 156)  {
			result_description[0] = 2;
			result_description[1] = '<li class="check_seo_description"><font>'+link8+':</font> Mô tả meta quá dài ( '+ seo_description.length +' ký tự). Khuyến nghị từ 120 - 156 ký tự.</li>'; 
		}
	}
	return result_description;
}

function check_seo_title(seo_title){
	result_title = new Array();
	if(!seo_title) {
		result_title[1] = '<li class="check_seo_title"><font>'+link7+':</font> Chưa có tiêu đề seo!</li>'; 
		result_title[0] = 1;
	} else {
		if(seo_title.length <= 46) {
			result_title[0] = 2;
			result_title[1] = '<li class="check_seo_title"><font>'+link7+':</font> Tiêu đề Seo quá ngắn ( '+ seo_title.length +' ký tự). Khuyến nghị từ 46 - 70 ký tự.</li>'; 
		} else if(seo_title.length <= 70)  {
			result_title[0] = 3;
			result_title[1] = '<li class="check_seo_title"><font>'+link7+':</font> Tốt</li>'; 
		}else if(seo_title.length > 70)  {
			result_title[0] = 2;
			result_title[1] = '<li class="check_seo_title"><font>Độ dài tiêu đề Seo:</font>Tiêu đề Seo quá dài ( '+ seo_title.length +' ký tự). Khuyến nghị từ 46 - 70 ký tự.</li>'; 
		}
	}
	return result_title;
}

function check_content(content){
	result_content = new Array();
	if(!content) {
		result_content[1] = '<li class="check_content"><font>'+link9+':</font> Chưa có văn bản. Hãy nhập thêm nội dung!</li>'; 
		result_content[0] = 1;
	} else {
		arr_content = content.split(' ');
		if(arr_content.length > 300) {
			result_content[0] = 3;
			result_content[1] = '<li class="check_content"><font>'+link9+':</font> Tốt</li>'; 
		} else {
			result_content[0] = 2;
			result_content[1] = '<li class="check_content"><font>'+link9+':</font> Văn bản dài '+arr_content.length+' từ. Ít hơn so với mức khuyến nghị là 300 từ. Hãy thêm nội dung!</li>'; 
		}
	}

	return result_content;
}

function check_content_img(content,keyword){
	result_content_img = new Array();
	c_alt_img_empty = 0;
	c_alt_img_false = 0;
	result_content_img[1] = '';
	if(content.indexOf('<img') == -1){
		result_content_img[1] = '<li class="check_content_img"><font>'+link3+':</font> Không có ảnh trên trang. Hãy thêm ảnh!</li>'; 
		result_content_img[0] = 1;
	} else {
		var himg = getFromBetween.get(content,"<img","/>");
		
		for(i=0;i<himg.length;i++) {
			arr_himg = himg[i].split('"');
			//console.log(arr_himg);
			for(j=0; j < arr_himg.length; j++) {
				k=j+1;
				//console.log(arr_himg[k]);

				if(arr_himg[j] == 'alt=' || arr_himg[j] == ' alt=' || arr_himg[j] == ' alt= '){
					alt_himg = arr_himg[k];
					//console.log(alt_himg);
				}


			}
			//console.log(arr_himg);

			if(typeof alt_himg === 'undefined') {
				c_alt_img_empty++;
			}else {

				//console.log(keyword);
				new_alt_himg = xoa_dau(alt_himg);
				new_alt_himg = new_alt_himg.toLowerCase();
				// keyword = $('#check_keyword').val();
				keyword = xoa_dau(keyword);
				keyword = keyword.toLowerCase();
				//console.log(keyword);
				arr_new_alt_himg = new_alt_himg.split(' ');
				//console.log(arr_new_alt_himg);

				c_alt_img_ok = 0;
				
				for(x=0;x < arr_new_alt_himg.length; x++) {
					
					if(keyword.indexOf(arr_new_alt_himg[x]) != -1){
						c_alt_img_ok ++;
					}
				}

				if(!c_alt_img_ok) {
					c_alt_img_false ++;
				}
			} 
		}
		if(c_alt_img_empty) {

			result_content_img[1] += '<li class="check_content_img"><font>'+link3+':</font> Có '+c_alt_img_empty+' ảnh trên trang này không có thuộc tính alt mô tả chủ đề văn bản của bạn!</li>'; 
			result_content_img[0] = 2;
		}
		if(c_alt_img_false) {
			result_content_img[1] += '<li class="check_content_img check_content_img_alt_kw"><font>'+link3+':</font> Có '+c_alt_img_false+' ảnh trên trang này có thuộc tính alt mô tả nhưng không chứa Cụm từ khóa chính!</li>'; 
			result_content_img[0] = 2;
			result_content_img[2] = 1;

		}

		if (!c_alt_img_empty && !c_alt_img_false) {
			result_content_img[1] += '<li class="check_content_img check_content_img_alt_kw"><font>'+link3+':</font> Rất tốt.</li>'; 
			result_content_img[0] = 3;
			result_content_img[2] = 1;
		}
	}
	return result_content_img;
}

function check_content_link(content,url){
	result_content_link = new Array();
	count_link_in = 0;
	count_link_out = 0;

	if(content.indexOf('<a') == -1){
		result_content_link[11] = '<li class="check_content_link"><font>'+link4+':</font> Không có đường dẫn nội bộ trên trang. Hãy thêm một số đường dẫn nội bộ!</li>'; 
		result_content_link[21] = '<li class="check_content_link"><font>'+link5+':</font> Không có đường dẫn ngoài trang. Hãy thêm một số đường dẫn ngoài trang!</li>'; 
		result_content_link[0] = 1;
	} else {
		var hlink = getFromBetween.get(content,"<a","</a>");
		for(i=0;i<hlink.length;i++) {
			arr_link = hlink[i].split('"');
			for(j=0;j<arr_link.length;j++) {
				k=j+1;
				if(arr_link[j] == 'href=' || arr_link[j] == ' href='){
					href_link = arr_link[k];
				}
			}
			if(href_link){
				if(href_link.indexOf(url) != -1){
					count_link_in++;
				} else {
					count_link_out++;
				}

			}
		}
		if(count_link_in) {
			result_content_link[10] = 3;
			result_content_link[11] = '<li class="check_content_link"><font>'+link4+':</font> Rất tốt ! Đã có đường dẫn nội bộ trên trang</li>'; 
		} else {
			result_content_link[10] = 1;
			result_content_link[11] = '<li class="check_content_link"><font>'+link4+':</font> Chưa có đường nội bộ trên trang, hãy thêm !</li>'; 
		}
		if(count_link_out) {
			result_content_link[20] = 3;
			result_content_link[21] = '<li class="check_content_link"><font>'+link5+':</font> Rất tốt ! Đã có đường dẫn ngoài trang trên trang</li>'; 
		}else {
			result_content_link[20] = 1;
			result_content_link[21] = '<li class="check_content_link"><font>'+link5+':</font> Chưa có đường dẫn ngoài trang, hãy thêm !</li>'; 
		}
	}
	return result_content_link;
}

function check_main_keyword_alias(c_keyword,c_alias){
// ch_keyword = '';
result_main_keyword_alias = new Array();
if(c_keyword) {
	ch_keyword = c_keyword.split(' ').join('-')
	ch_keyword = ch_keyword.toLowerCase();
}

if (!c_keyword) {
	result_main_keyword_alias[0] = 1;
	result_main_keyword_alias[1] = '<li class="check_main_keyword_alias"><font>'+link2+':</font> Chưa có cụm từ khóa chính. Hãy nhập thêm!</li>'; 
}else
if(c_alias.indexOf(ch_keyword) != -1){
	result_main_keyword_alias[0] = 3;
	result_main_keyword_alias[1] = '<li class="check_main_keyword_alias"><font>'+link2+':</font> Rất tốt!</li>'; 
} else {
	result_main_keyword_alias[0] = 2;
	result_main_keyword_alias[1] = '<li class="check_main_keyword_alias"><font>'+link2+':</font> (Một phần) từ khóa của bạn không xuất hiện trong tên hiệu (alias). Hãy thay đổi!</li>'; 
}
return result_main_keyword_alias;
}

function check_main_keyword_title_seo(c_keyword,c_title_seo){
// ch_keyword = '';
result_main_keyword_title_seo = new Array();
if(!c_keyword){
	result_main_keyword_title_seo[0] = 1;
	result_main_keyword_title_seo[1] = '<li class="check_main_keyword_title_seo"><font>'+link6+':</font> Chưa có Cụm từ khóa chính. Hãy nhập thêm!</li>'; 
}else 
if(c_title_seo.indexOf(c_keyword) != -1){
	result_main_keyword_title_seo[0] = 3;
	result_main_keyword_title_seo[1] = '<li class="check_main_keyword_title_seo"><font>'+link6+':</font> Rất tốt! Cụm từ khóa chính khớp chính xác trong Title seo.</li>'; 
} else {
	result_main_keyword_title_seo[0] = 1;
	result_main_keyword_title_seo[1] = '<li class="check_main_keyword_title_seo"><font>'+link6+':</font> Kiểm tra lại tất cả các từ trong Cụm từ khóa chính có trong Title seo hay chưa?</li>'; 
}
return result_main_keyword_title_seo;
}

function check_main_keyword_content(c_keyword,c_content){
// ch_keyword = '';
arr_count_word = c_content.split(' ');
count_word = arr_count_word.length;
min_kw = Math.floor(count_word/300) + 1;
max_kw = Math.floor(count_word/60) + 1;
c_keyword2 = c_keyword.toLowerCase();
count_kw1 = (c_content.match(new RegExp(c_keyword, "g")) || []).length;
count_kw2 = (c_content.match(new RegExp(c_keyword2, "g")) || []).length;
count_kw = count_kw1 + count_kw2;
result_main_keyword_content = new Array();
if(!c_keyword) {
	result_main_keyword_content[0] = 1;
	result_main_keyword_content[1] = '<li class="check_main_keyword_content"><font>'+link10+':</font>Chưa có cụm từ khóa chính. Hãy nhập thêm !</li>'; 
} else
if(count_word < 300) {
	result_main_keyword_content[0] = 1;
	result_main_keyword_content[1] = '<li class="check_main_keyword_content"><font>'+link10+':</font> Độ dài văn bản quá ngắn, tối thiểu 300 từ. Hãy nhập thêm nội dung để tính mật độ !</li>'; 
} else {
	if(count_kw < min_kw){
		result_main_keyword_content[0] = 1;
		result_main_keyword_content[1] = '<li class="check_main_keyword_content"><font>'+link10+':</font> Xuất hiện '+count_kw+' lần. Mức này ít hơn mức khuyến nghị là '+min_kw+' -> '+max_kw+' lần với độ dài văn bản hiện tại.</li>'; 
	} else if (count_kw <= max_kw ) {
		result_main_keyword_content[0] = 3;
		result_main_keyword_content[1] = '<li class="check_main_keyword_content"><font>'+link10+':</font> Rất tốt. Xuất hiện '+count_kw+' lần. Mức này nằm trong mức khuyến nghị là '+min_kw+' -> '+max_kw+' lần với độ dài văn bản hiện tại.</li>'; 
	} else{
		result_main_keyword_content[0] = 1;
		result_main_keyword_content[1] = '<li class="check_main_keyword_content"><font>'+link10+':</font> Xuất hiện '+count_kw+' lần. Mức này lớn hơn mức khuyến nghị là '+min_kw+' -> '+max_kw+' lần với độ dài văn bản hiện tại.</li>'; 
	}
}

return result_main_keyword_content;
}

function point_seo(){

	list_point_seo = $('#point_seo').val();
	arr_point_seo = list_point_seo.split(',');
	// arr_point_seo = list_point_seo.split(',');
	// console.log(list_point_seo);
	// console.log(arr_point_seo['0']);
	check_keyword_active = $('#check_keyword_active').val();

	var van_de = $(".van_de").find("li").length;
	var cai_tien = $(".cai_tien").find("li").length;
	var kq_tot = $(".kq_tot").find("li").length;
	point = (kq_tot + cai_tien / 2) / (van_de + cai_tien + kq_tot) * 100;
	point = Math.round(point * 100)/100;
	text_point_seo ='Đạt '+point+'%';
	$('#text_point_seo').text(text_point_seo);
	arr_point_seo[check_keyword_active] = point;

	console.log(arr_point_seo);

	new_list_point_seo = arr_point_seo.join(',');

	// alert(new_list_point_seo);
	// $('#point_seo').val(new_list_point_seo);

	$('#point_seo').val(new_list_point_seo);

	$('#text_point_seo').removeClass('text_success').removeClass('text_warning').removeClass('text_danger');
	$('.item_active').removeClass('text_success').removeClass('text_warning').removeClass('text_danger');

	if(point >= 80) {
		$('#text_point_seo').addClass('text_success');
		$('.item_active').addClass('text_success');
	} else if (point >= 50) {
		$('#text_point_seo').addClass('text_warning');
		$('.item_active').addClass('text_warning');
	} else {
		$('#text_point_seo').addClass('text_danger');
		$('.item_active').addClass('text_danger');
	}
}

function xoa_dau(str) {
	if(str) {
		str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
		str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
		str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
		str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
		str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
		str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
		str = str.replace(/đ/g, "d");
		str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "a");
		str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "e");
		str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "i");
		str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "o");
		str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "u");
		str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "y");
		str = str.replace(/Đ/g, "d");
	}

// str = str.replace(" ", "-");
return str;
}


var getFromBetween = {
	results:[],
	string:"",
	getFromBetween:function (sub1,sub2) {
		if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return false;
		var SP = this.string.indexOf(sub1)+sub1.length;
		var string1 = this.string.substr(0,SP);
		var string2 = this.string.substr(SP);
		var TP = string1.length + string2.indexOf(sub2);
		return this.string.substring(SP,TP);
	},
	removeFromBetween:function (sub1,sub2) {
		if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return false;
		var removal = sub1+this.getFromBetween(sub1,sub2)+sub2;
		this.string = this.string.replace(removal,"");
	},
	getAllResults:function (sub1,sub2) {
// first check to see if we do have both substrings
if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return;

// find one result
var result = this.getFromBetween(sub1,sub2);
// push it to the results array
this.results.push(result);
// remove the most recently found one from the string
this.removeFromBetween(sub1,sub2);

// if there's more substrings
if(this.string.indexOf(sub1) > -1 && this.string.indexOf(sub2) > -1) {
	this.getAllResults(sub1,sub2);
}
else return;
},
get:function (string,sub1,sub2) {
	this.results = [];
	this.string = string;
	this.getAllResults(sub1,sub2);
	return this.results;
}
};

limit_charactor($('#title'),75,0);
$('#title').keyup(function(){
	limit_charactor($(this),75,0);
});
	// SEO
	limit_charactor($('#seo_title'),60,1);
	$('#seo_title').keyup(function(){
		limit_charactor($(this),60,1);
	});
	$('#seo_title').change(function(){
		limit_charactor($(this),60,1);
	});
	
	limit_charactor($('#seo_keyword'),160,1);
	$('#seo_keyword').keyup(function(){
		limit_charactor($(this),160,1);
	});
	$('#seo_keyword').change(function(){
		limit_charactor($(this),160,1);
	});	
	
	limit_charactor($('#seo_description'),165,1);
	$('#seo_description').keyup(function(){
		limit_charactor($(this),165,1);
	});
	$('#seo_description').change(function(){
		limit_charactor($(this),165,1);
	});

	function limit_charactor(element,limit,require){
		if(element.length) {
			var length_ch = element.val().length;
			element.next('.count_character').remove();
			if(require == 1){
				if(length_ch > limit){
					var str = element.val();
					element.val(str.substr(0, limit));
					element.after('<span class="count_character">Số kí tự '+limit+'/'+limit+'<br/></span>');
				}else{
					element.after('<span class="count_character">Số kí tự '+length_ch+'/'+limit+'<br/></span>');
				}
			}else{
				element.after('<span class="count_character">Số kí tự '+length_ch+'/'+limit+'<br/></span>');
			}
		}

	}

	// $('.close_cus').click(function(){
	// 	$('.inner_cus').css('display','none');
	// }

	$('#main_keyword').keyup(function(){
		var main_keyword = $(this).val();
		// var stt_active = $('#check_keyword_active').val();
		position = $('#main_keyword').caret();
		sub = main_keyword.substr(0,position);
		arr_sub = sub.split(',');

		stt_active = arr_sub.length-1;

		$('#check_keyword_active').val(stt_active);

		// alert(stt_active);
		var list_point_seo = $('#point_seo').val();
		if($('#content').length) {
			var alt_content = $('#content').val();
		} else {
			var alt_content = $('#description').val();
		}
		
		var data_id = $('#data_id').val();
		var data_module = $('#data_module').val();
		$.ajax({
			type : 'get',
			url : 'index.php?module=seo_keywords&view=seo_keywords&raw=1&task=loadseo_keywords',
			data: {main_keyword:main_keyword,data_id:data_id,data_module:data_module},
			dataType: "text",
			success : function(data){

				if(data == 1){			
					$('#main_keyword').next('.count_character').html('Tên đã tồn tại !');
					$('#main_keyword').next('.count_character').css('color','red');
				}else{
					$('#main_keyword').next('.count_character').html('Bạn có thể sử dụng');
					$('#main_keyword').next('.count_character').css('color','#a0a0a0')
				}

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});

		$.ajax({
			type : 'get',
			url : 'index.php?module=seo_keywords&view=seo_keywords&raw=1&task=update_keywords',
			data: {main_keyword:main_keyword, stt_active:stt_active, list_point_seo:list_point_seo},
			dataType: "html",
			success : function(html){
				$('.list_keyword').html(html);
				reset_keywword();

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	})


	var main_keyword = $('#main_keyword').val();
	var data_id = $('#data_id').val();
	var data_module = $('#data_module').val();

	$.ajax({
		type : 'get',
		url : 'index.php?module=seo_keywords&view=seo_keywords&raw=1&task=loadseo_keywords',
		data: {main_keyword:main_keyword,data_id:data_id,data_module:data_module},
		dataType: "text",
		success : function(data){	
			if(data == 1){			
				$('#main_keyword').next('.count_character').html('Tên đã tồn tại !');
				$('#main_keyword').next('.count_character').css('color','red');
			}else{
				$('#main_keyword').next('.count_character').html('Bạn có thể sử dụng');
				$('#main_keyword').next('.count_character').css('color','#a0a0a0')
			}		
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});




   // alert('change');

   function add_skw(id, title) {
   	$('#main_keyword').val(title);
   	$('#id_main_keyword').val(id);
   	$('.inner_cus').css('display','none');
   	main_keyword_change();
   }


   function check_duplicate(){
   	CKEDITOR.instances['content'].updateElement();
   	$('.check_duplicate').addClass('check_duplicate_load');
   	c_content = $('#content').val().toLowerCase();
   	if(c_content) {
   		url_root = $('#url_root').val();
   		$.ajax({
   			type: "POST",
   			url: "/libraries/yoastseo/ggapi/check.php",
   			data: {c_content:c_content},
   			cache: false,
   			success: function(html){
   				$(".result_duplicate").html(html);
   				$('.check_duplicate').removeClass('check_duplicate_load');
   			},
   			error: function(xhr, status, error){
   				alert('Hệ thống kiểm tra đang quá tải. Vui lòng kiếm tra sau.!');
   				$('.check_duplicate').removeClass('check_duplicate_load');
   			}

   		});
   	}else {
   		alert('Bạn chưa nhập nội dung!');
   	}
   };


