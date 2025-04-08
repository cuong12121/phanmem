$(document).ready(function() {
	$('.select2').select2();
});


function format_money(number){
    var number = number+'';
    var format_money = "";
    while (parseInt(number) > 999) {
        format_money = "." + number.slice(-3) + format_money;
        number = number.slice(0, -3);
    } 
    return result = number + format_money;
}

$(".tbDatePicker").datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});




$(document).ready(function(){
	// window.history.forward(1);
	// alert(123);
	// var hei = $('#page-wrapper').height()+100;
	// var min_hei = $('#page-wrapper').attr('height')+100;
	// var w_hei = $( window ).height() - 50;
	// var w_width = $( window ).width();
	// if (w_width > 600 ) {
	// 	if (min_hei > w_hei ) {
	// 		$('.sidebar').css('min-height',min_hei);	
	// 	} 
	// 	else {
	// 		if (hei > w_hei) {
	// 			$('.sidebar').css('min-height',hei);	
	// 		}
	// 		else {
	// 			$('.sidebar').css('min-height',w_hei);
	// 		}
	// 	}
	// }

	// $('.cropimage').click(function(){
	// 	$('.popup_cropimage').removeClass('popup_cropimage_hide');
	// })

	// $('.close_popup_cropimage').click(function(){
	// 	$('.popup_cropimage').addClass('popup_cropimage_hide');
	// })
});

var md = $("input[name*='module']").val();
var view = $("input[name*='view']").val();

$("#page-wrapper #search_multipe").focus();
// $("#page-wrapper #search_multipe").keyup(function(){
// 	var str_key = $(this).val();
// 	$("#page-wrapper #search_multipe").val('');
// 	$.ajax({
// 		url: "/admin/index.php?module="+md+"&view="+view+"&task=ajax_set_ss_search_multipe&raw=1",
// 		data: {str_key:str_key},
// 		dataType: "text",
// 		success: function(text) {
// 			$("#page-wrapper #search_multipe").val('');
// 			$('#val_search_multipe span').html(text);
// 		}
// 	});
// 	$('.btn-search').trigger("click");
// });




// var str_key = $("#page-wrapper #search_multipe").val();
// $("#page-wrapper #search_multipe").val('');
// $.ajax({
// 	url: "/admin/index.php?module="+md+"&view="+view+"&task=ajax_set_ss_search_multipe&raw=1",
// 	data: {str_key:str_key},
// 	dataType: "text",
// 	success: function(text) {
// 		$("#page-wrapper #search_multipe").val('');
// 		$('#val_search_multipe span').html(text);
// 		// $('.btn-search').trigger("click");
// 	}
// });



$('.btn-reset-form').click(function(){
	$.ajax({
		url: "/admin/index.php?module="+md+"&view="+view+"&task=ajax_unset_ss&raw=1",
		data: {ok:1},
		dataType: "text",
		success: function(text) {
			
		}
	});
});	

$('.click_popup_time').click(function(){
	name = $(this).attr('id');
	name = name.replace('click_popup_time_','');
	$('#popup_time_'+name).toggleClass('hide');
})

$('.input_popup_time').change(function(){
	id = $(this).attr('id');
	id = id.replace('hour_','');
	id = id.replace('min_','');
	update_published_hour(id);
})

$('.input_hourmin').click(function() {
	name = $(this).attr('id');
	// name = name.replace('click_popup_time_','');
	$('#popup_time_'+name).toggleClass('hide');
})

$('.uphour').click(function(){
	id = $(this).attr('id');
	name = id.replace('uphour_','');
	hour = $('#hour_'+name).val();
	new_hour = parseInt(hour) + 1;
	$('#hour_'+name).val(new_hour);
	update_published_hour(name);
})

$('.downhour').click(function(){
	id = $(this).attr('id');
	name = id.replace('downhour_','');
	hour = $('#hour_'+name).val();
	new_hour = parseInt(hour) - 1;
	$('#hour_'+name).val(new_hour);
	update_published_hour(name);
})

$('.upmin').click(function(){
	id = $(this).attr('id');
	name = id.replace('upmin_','');
	hour = $('#min_'+name).val();
	new_hour = parseInt(hour) + 1;
	$('#min_'+name).val(new_hour);
	update_published_hour(name);
})

$('.downmin').click(function(){
	id = $(this).attr('id');
	name = id.replace('downmin_','');
	hour = $('#min_'+name).val();
	new_hour = parseInt(hour) - 1;
	$('#min_'+name).val(new_hour);
	update_published_hour(name);
})

function update_published_hour(name){
	hour = $('#hour_'+name).val();
	min = $('#min_'+name).val();
	hour_min = hour+':'+min;
	$('#'+name).val(hour_min);
}



function ajax_listItemTask(id,field, value_new,module,view)
{
	$url = "index.php?module="+module+"&view="+view+"&raw=1&task=ajax_reverse";

	$.ajax({		
		url: "/admin/index.php?module="+module+"&view="+view+"&raw=1&task=ajax_reverse",
		type: "get",
		data:{field:field,id:id,value:value_new},
		error: function(){
			alert("Lỗi");
		},
		success: function(result){
			console.log(result);
			if(result == 0 || result == '0'){
				$('.popup-notification').css({"background-color": "#5dd214", "display": "block"});
				$('.popup-notification').html('Cập nhật thành công !');
				setTimeout(function(){ 
					$('.popup-notification').css({"display": "none"});;
				},2000);
				$('#cb_'+id+'_'+field).html('<a i title="Enable item" class="icon_published" onclick="return ajax_listItemTask(\''+id+'\',\''+field+'\',\''+1+'\',\''+module+'\',\''+view+'\')\" href="javascript:void(0);"><img border="0" alt="Disable status" src="/admin/templates/default/images/unpublished.png"></a></div>');

			}else if(result == '-1' || result == -1 ){
				$('.popup-notification').html('Có lỗi xảy ra!');
				$('.popup-notification').css({"background-color": "red", "display": "block"});
				setTimeout(function(){ 
					$('.popup-notification').css({"display": "none"});;
				},2000);
			}else{
				$('.popup-notification').css({"background-color": "#5dd214", "display": "block"});
				$('.popup-notification').html('Cập nhật thành công !');
				setTimeout(function(){ 
					$('.popup-notification').css({"display": "none"});;
				},2000);
				$('#cb_'+id+'_'+field).html('<a i title="Enable item" class="icon_published" onclick="return ajax_listItemTask(\''+id+'\',\''+field+'\',\''+0+'\',\''+module+'\',\''+view+'\')\" href="javascript:void(0);"><img border="0" alt="Disable status" src="/admin/templates/default/images/published.png"></a></div>');

			}

		}
	});
}

function edit_text_ajax(id,element_id,field,module,view)
{
	// alert('121212');
	value_new = $('#'+element_id).val();
	// alert(value_new);
	$.ajax({		
		url: "index.php?module="+module+"&view="+view+"&raw=1&task=edit_text_ajax",
		type: "get",
		data:{field:field,id:id,value:value_new},
		error: function(){
			alert("Lỗi");
		},
		success: function(result){
			console.log(result);
			if(result == 0 || result == '0'){
				$('.popup-notification').css({"background-color": "#5dd214", "display": "block"});
				$('.popup-notification').html('Cập nhật thành công !');
				setTimeout(function(){ 
					$('.popup-notification').css({"display": "none"});;
				},2000);
				$('#cb_'+id+'_'+field).html('<a i title="Enable item" onclick="return ajax_listItemTask(\''+id+'\',\''+field+'\',\''+1+'\',\''+module+'\',\''+view+'\')\" href="javascript:void(0);"><img border="0" alt="Disable status" src="templates/default/images/unpublished.png"></a></div>');

			}else if(result == '-1' || result == -1 ){
				$('.popup-notification').html('Có lỗi xảy ra!');
				$('.popup-notification').css({"background-color": "red", "display": "block"});
				setTimeout(function(){ 
					$('.popup-notification').css({"display": "none"});;
				},2000);
			}else{
				$('.popup-notification').css({"background-color": "#5dd214", "display": "block"});
				$('.popup-notification').html('Cập nhật thành công !');
				setTimeout(function(){ 
					$('.popup-notification').css({"display": "none"});;
				},2000);
				$('#cb_'+id+'_'+field).html('<a i title="Enable item" onclick="return ajax_listItemTask(\''+id+'\',\''+field+'\',\''+0+'\',\''+module+'\',\''+view+'\')\" href="javascript:void(0);"><img border="0" alt="Disable status" src="templates/default/images/published.png"></a></div>');

			}

		}
	});
}

function showFormAdd() {
	alert('ok');
    // $('.form-post-pd').removeClass('none');
    // $('.form-search-pd').addClass('none');
}



/**
* Default function.  Usually would be overriden by the component
*/
function submitbutton(pressbutton) {
	if(pressbutton == 'remove'){
		if(confirm('Bạn có chắc chắn muốn xóa?'))
			submitform(pressbutton);
	}else{
		console.log(pressbutton);
		submitform(pressbutton);
	}
}
/**
* Submit the admin form
*/



function submitform(pressbutton){
	const d = new Date();
	let time = d.getTime();
	if(pressbutton == 'export'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		window.open(url_current+'/export?time='+time);
		return;
	}

	if(pressbutton == 'excel_nhat'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		window.open(url_current+'/excel_nhat?time='+time);
		return;
	}

	if(pressbutton == 'statistic_packages'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		url_current = url_current.replace('packages/package','packages/statistic');
		window.open(url_current);
		return;
	}

	if(pressbutton == 'import_barcode_warehouse_sales'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		url_current = url_current.replace('warehouse_sales/sales','warehouse_sales/barcode');
		window.open(url_current);
		return;
	}

	if(pressbutton == 'import_excel_warehouse_sales'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		url_current = url_current.replace('warehouse_sales/sales','warehouse_sales/excel');
		window.open(url_current);
		return;
	}


	if(pressbutton == 'import_barcode_refund'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		url_current = url_current.replace('refunds/refund','refunds/barcode');
		window.open(url_current);
		return;
	}

	if(pressbutton == 'import_excel_refund'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		url_current = url_current.replace('refunds/refund','refunds/excel');
		window.open(url_current);
		return;
	}

	if(pressbutton == 'import_excel_packages'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		url_current = url_current.replace('packages/package','packages/excel');
		window.open(url_current);
		return;
	}


	if(pressbutton == 'excel_misa'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		window.open(url_current+'/excel_misa?time='+time);
		return;
	}

	if(pressbutton == 'excel_tong_ngay'){
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		window.open(url_current+'/excel_tong_ngay?time='+time);
		return;
	}


	if(pressbutton == 'print_barcode_open'){
		url_current = window.location.href;
		url_current = url_current.replace('/admin/product','/admin/built/built/edit/1');
		window.open(url_current+'?time='+time);
		return;
	}


	if(pressbutton == 'add_time'){
		add_time_profits();
		return;
	}

	if (pressbutton) {

		if(pressbutton=='apply_order'||pressbutton=='save_order'){

			const isConfirmed = confirm("Đơn hàng có mã tracking này đã được đánh, bạn có muốn đánh lại đơn này không?");
		    if (!isConfirmed) {
		      e.preventDefault(); // Người dùng bấm Cancel
		    }
		    

		}
		// return
		
		document.adminForm.task.value=pressbutton;
	}
	if (typeof document.adminForm.onsubmit == "function") {
		document.adminForm.onsubmit();
	}
	document.adminForm.submit();
}
/* 
 * Ordering 
 */
 function tableOrdering( order, dir, task ) {
 	var form = document.adminForm;
 	form.sort_field.value 	= order;
 	form.sort_direct.value	= dir;
 	submitform( task );
 }
/*
 * Check checkbox
 */
 function isChecked(isitchecked){
 	if (isitchecked == true){
 		document.adminForm.boxchecked.value++;
 	}
 	else {
 		document.adminForm.boxchecked.value--;
 	}
 }
 function checkAll( n, fldName ) {
 	if (!fldName) {
 		fldName = 'cb';
 	}
 	var f = document.adminForm;
 	var c = f.toggle.checked;
 	var n2 = 0;
 	for (i=0; i < n; i++) {
 		cb = eval( 'f.' + fldName + '' + i );
 		if (cb) {
 			cb.checked = c;
 			n2++;
 		}
 	}
 	if (c) {
 		document.adminForm.boxchecked.value = n2;
 	} else {
 		document.adminForm.boxchecked.value = 0;
 	}
 }
 function listItemTask(id, task)
 {
 	var f = document.adminForm;
 	cb = eval( 'f.' + id );
 	if (cb) {
 		for (i = 0; true; i++) {
 			cbx = eval('f.cb'+i);
 			if (!cbx) break;
 			cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        submitbutton(task);
 }
 return false;
}
function deleteMenu(id,parent_id,url){
	var r=confirm("Bạn chắc chắn muốn xóa ?")
	if (r==true){
		$.get(url, { id:id,parent_id:parent_id },
			function(data){
				$('.'+data).remove();
				alert("Xóa thành công !");
			});
	}
}
/**** CREATE LINKED*******/
function creat_link(object){
	window.open("index2.php?module=menus&view=items&task=linked&object=" + object, "","height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
function link_to_data(str_link){
	window.opener.document.getElementById("mnu_link").value = str_link;
	window.close();
}
function link_from_linked()
{
	ob = document.getElementById( "linked" );
	if( ob.value == 0 ){
		alert( "You have not created a link !" );
		ob.focus();
		return false;
	}
	window.opener.document.getElementById("mnu_link").value = ob.value;
	window.close();
}
/*************** CHECK FORM ***************/
//If the length of the element's string is 0 then display helper message
function notEmpty(elemid, helperMsg){
	elem  = $('#'+elemid);
	if(elem.val().length == 0){
		invalid(elemid,helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	else
	{
		valid(elemid);
		return true;
	}
}

function notImageEmpty(elemid, helperMsg){
	if($('#'+elemid+'_exist').length > 0){
		return true;
	}
	elem  = $('#'+elemid);
	if(elem.val().length == 0){
		invalid(elemid,helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	else
	{
		valid(elemid);
		return true;
	}
}

//If the element's string matches the regular expression it is all numbers
function isNumeric(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
elem.focus();
return false;
}
}
//If the element's string matches the regular expression it is all letters
function isAlphabet(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
elem.focus();
return false;
}
}
//If the element's string matches the regular expression it is numbers and letters
function isAlphanumeric(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
elem.focus();
return false;
}
}
// Limit length
function lengthRestriction(elemid, min, max){
	elem  = document.getElementById(elemid);
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = "Please enter between " +min+ " and " +max+ " characters";
//		alert("Please enter between " +min+ " and " +max+ " characters");
elem.focus();
return false;
}
}
// Select box ( multi select)
function madeSelection(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var i;
	for (i=0; i<elem.options.length; i++) {
		console.log(elem.options[i].value);
		if (elem.options[i].selected && ( elem.options[i].value != "") ){
			return true;
		}
	}
	document.getElementById('msg_error').innerHTML = helperMsg;
	return false;
}
// Email
function emailValidator(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
elem.focus();
return false;
}
}


// Password and repassword
function checkMatchPass(helperMsg){
	elem_value  = document.getElementById('password').value;
	elem2_value  = document.getElementById('repass').value;
	if(elem_value != elem2_value )
	{
		document.getElementById('msg_error').innerHTML = helperMsg;
		return false;
	}
	return true;
}

/* Upgrade */
function init_position_box(box){
	var winH = $(window).height();
	var winW = $(window).width();
	box.css('top',  winH/2 - box.height()/2);
	box.css('left', winW/2 - box.width()/2);
}
/*
 * Change border color where valid
 */
 function valid(element){
 	$("#"+element).removeClass("redborder");
 	$("#"+element).parent().find('.label_error').prev().remove();
 	$("#"+element).parent().find('.label_error').remove();
 	$("#"+element).parent().find('.label_success').prev().remove();
 	$("#"+element).parent().find('.label_success').remove();
 }
/*
 * Change border color where invalid
 */
 function invalid(element,helperMsg){
 	$("#"+element).parent().find('.label_error').prev().remove();
 	$("#"+element).parent().find('.label_error').remove();
 	$("#"+element).parent().find('.label_success').prev().remove();
 	$("#"+element).parent().find('.label_success').remove();
 	$('<br/><div class=\'label_error\'>'+helperMsg+'</div>').insertAfter($('#'+element).parent().children(':last'));
 	$("#"+element).addClass("redborder");
 	$("#"+element).focus();
 }
//Select box ( one select)
function check_selection(elemid, helperMsg){
	elem  = $('#'+elemid);
	if(elem.val() == 0 || elem.val() == '0' || elem.val() == ''){
		invalid(elemid,helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	else
	{
		valid(elemid);
		return true;
	}
}

$(document).ready(function(){
	$(window).scroll(function(){
		if ($(this).scrollTop() > 300) {
			$('.scrollToTop').fadeIn().addClass('active');
		} else {
			$('.scrollToTop').fadeOut().removeClass('active');
		}
	});
	
	//Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
	/* Tính lại width của toolbar*/
	var $width = $('#box-content').width();
	$('#wrap-toolbar').css('width', $width+'px');
	$(window).resize(function () {	 
		var $width = $('#box-content').width();
		$('#wrap-toolbar').css('width', $width+'px');
	});
	/* Đính thanh toolbar lên top */
	$(window).scroll(function () {
		if ($(this).scrollTop() > 150) {
			//$('#wrap-toolbar').css({'position':'fixed', 'top':'0','left':'0','width':'100%', 'z-index': '9999'});
			$('#wrap-toolbar').addClass('toolbar-fix');
			$('.head_new').addClass('toolbar-fix');
		} else {
			//$('#wrap-toolbar').css({'position':'relative', 'top':'auto','z-index': '1'});
			$('#wrap-toolbar').removeClass('toolbar-fix');
			$('.head_new').removeClass('toolbar-fix');
		}
	});
	/* Hiển thị menu hiện tại */
	current = $('.selected').parent().parent().parent('ul');
	if(current){
		current.show();
		parrent_current = $('.selected').parent().parent().parent().parent().parent('ul');
		if(parrent_current)
			parrent_current.show();
	}
	$('#menu-bar .has-child .a_has_child').click(function(){
		var $child =  $(this).parent().next('ul:first');
		if($($child).css("display") == "none")
			$($child).css("display", "block");
		else
			$($child).css("display", "none");
	});
	/* Gán chiều cao tối thiểu cho Box content */
	// var min_height = $('#sidebar').height();
	// $('#box-content').css('min-height', min_height+'px'); 
});
function remove_image(module,view,id,field,divNum) {
	if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
		$.ajax({
			url: "/admin/index.php?module="+module+"&view="+view+"&raw=1&task=delete_image",
			type: "get",
			data:{ field:field,id:id },
			error: function(){
				alert("Lỗi xoa dữ liệu");
			},
			success: function(){
				$( "#"+divNum ).remove();
			}
		});
	}else{
		return false;
	}
}


$('.vat').click(function(){
	$('.vat').toggleClass('vatactive');
	$('.dvat').toggleClass('hide');
})


function open_list_action(id_a){
	id_d = id_a.replace('a_action_','d_action_');
	check = $('#'+id_d).hasClass('hide');
	$('.d_action').addClass('hide');
	if(check) {
		$('#'+id_d).removeClass('hide');
	} else {
		$('#'+id_d).addClass('hide');
	}
}


function format_money_text(number){
	//Định dạng lại giá
	var number = number.toString();
	var format_money = "";
	while (parseInt(number) > 999) {
		format_money = "." + number.slice(-3) + format_money;
		number = number.slice(0, -3);
	} 
	result = number + format_money + 'đ';
	return result;
}

