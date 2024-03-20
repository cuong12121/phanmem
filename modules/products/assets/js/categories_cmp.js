compare_js(1);
del_product_cmp(1);
delete_all_cmp(1);
direct_link_cmp(1);
del_product(1);

function compare_js(){
	$('.check_compare').click(function(){
		var id=$(this).attr('id');
		if(this.checked == true){
			var img=$(this).parent().next().find('img').attr('src');
			var alt = $(this).parent().next().find('img').attr('alt'); 
			var table_name=$(this).attr('table_name');
			this_element = $(this);
			$.get('/index.php?module=products&view=cat&task=created_session&raw=1&id_product='+id+'&table_name='+table_name, function(data,this_element){
				if(data > 3){
					alert("Bạn chỉ có thể chọn tối đa 3 sản phẩm");
					$('#'+id).attr('checked', false);
				}else{
					 $('.cmp_prd_order_'+data).find('img').attr('src',img);
					 $('.cmp_prd_order_'+data).attr('id','cmp_prd_'+id);
					 $('.cmp_prd_order_'+data).addClass( "cmp_prd_"+id);
					 $('.cmp_prd_order_'+data).find('.cmp_prd_name').show('');
					 $('.cmp_prd_order_'+data).find('.txt_name').text( alt );
				}
			});
		}else{
			var table_name=$(this).attr('table_name');
			$.get('/index.php?module=products&view=cat&task=del_product&raw=1&id_product='+id+'&table_name='+table_name);
			$('.cmp_prd_'+id).find('img').attr('src','/templates/digiworld/images/noavatar.jpg');
			$('.cmp_prd_'+id).find('.txt_name').text('');
			$('.cmp_prd_'+id).find('.cmp_prd_name').hide('');
			$('.cmp_prd_'+id).attr('id','');
			$('.cmp_prd_'+id).removeClass( "cmp_prd_"+id);
		}
	});
}
//xóa sản phẩm vừa chọn trên danh sách vừa chọn
function del_product(){
	$('.del-product-cmp').click(function(){
		var id=$(this).parent().parent().attr('id');
		id = id.split("_");
		id = id[2]; 
		var table_name=$(this).attr('table_name');
		
		$.get('/index.php?module=products&view=cat&task=del_product&raw=1&id_product='+id+'&table_name='+table_name);
		
		$('.cmp_prd_'+id).find('img').attr('src','/templates/digiworld/images/noavatar.jpg');
		$('.cmp_prd_'+id).find('.cmp_prd_name').hide('');
		$('.cmp_prd_'+id).find('.txt_name').text('');
		$('.cmp_prd_'+id).attr('id','');
		$('#'+id).prop('checked', false);
		
	});
}
function del_product_cmp(){
	
	$('.del-product').click(function(){
		var id=$(this).attr('lang');
		var table_name=$(this).attr('table_name');
		var pos=$(this).attr('pos');
		$.get('/index.php?module=products&view=categories&task=del_product&raw=1&id_product='+id+'&table_name='+table_name+'&pos='+pos);
		$('#compare-'+pos).attr('src','/templates/default/images/apple-avatar.jpg');
		$('#'+id+' .bg-white').css('display','none');
		$('#'+id+' .bg-white-list').css({'display':'none'});
		$('#'+id).removeClass('click_off').addClass('click_on');
		$('#button-del-'+pos+' .del-product').css({'display':'none'}).removeAttr("table_name").removeAttr("lang").removeAttr("pos");
	});
}
function delete_all_cmp(){
	$('.delete-all').click(function(){
		var table_name=$(this).attr('table_name');
		$.get('/index.php?module=products&view=cat&task=delete_all_compare&raw=1&table_name='+table_name,function(data){
			location.reload();
		});
	});
}
function direct_link_cmp(){
	$('.compare-all').click(function(){
		var table_name=$(this).attr('table_name');
		var root_id=$('#root_id').attr('value');
		$.get('/index.php?module=products&view=cat&task=direct_link&raw=1&table_name='+table_name+'&root_id='+root_id,function(data){
			if(data != 0){
				if(is_rewrite == 0){
					link = '/index.php?module=products&view=compare'+data+'&cid='+root_id+'&Itemid=38';
				}else {
					link = '/so-sanh-san-pham/'+root_id+'.html'+data;
				}
				location.href=link;
			}else{
				alert("Bạn phải chọn ít nhất 2 sản phẩm");
			}
			
		});
	});
}