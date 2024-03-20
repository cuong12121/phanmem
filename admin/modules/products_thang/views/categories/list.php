<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Categories') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
		
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'treename','ordering'=> 1, 'type'=>'text','col_width' => '30%','align'=>'left','arr_params'=>array('have_link_edit'=> 1));
	//$list_config[] = array('title'=>'Tablename','field'=>'tablename','ordering'=> 1, 'type'=>'text','col_width' => '20%','align'=>'left');
//	$list_config[] = array('title'=>'Tính lại bộ lọc','field'=>'','ordering'=> 0, 'type'=>'text','col_width' => '20%','arr_params'=>array('function'=> 'view_genarate_filter'));
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	// $list_config[] = array('title'=>'Trọng lượng','field'=>'kilogam','ordering'=> 1, 'type'=>'text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	//$list_config[] = array('title'=>'Home','field'=>'show_in_homepage','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'home'));
	//$list_config[] = array('title'=>'Show danh mục con','field'=>'is_show_home_subcat','ordering'=> 1, 'type'=>'change_status');
	// $list_config[] = array('title'=>'XH menu','field'=>'show_in_menu','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'show_in_menu'));

	// $list_config[] = array('title'=>'Show danh mục con trang chủ','field'=>'is_show_home_subcat','ordering'=> 1, 'type'=>'change_status');

	// $list_config[] = array('title'=>'Danh mục combo','field'=>'is_combo','ordering'=> 1, 'type'=>'change_status');
	// $list_config[] = array('title'=>'Hải Linh vận chuyển','field'=>'hai_linh_ship','ordering'=> 1, 'type'=>'change_status');

	
//	$list_config[] = array('title'=>'Import','field'=>'id','type'=>'text','arr_params'=>array('function'=>'link_import'));
	$list_config[] = array('title'=>'Edit','type'=>'edit');

	// $list_config[] = array('title'=>'Chuyển SP đến danh mục khác','field'=>'id', 'type'=>'text','col_width' => '10%','arr_params'=>array('function'=>'view_move_product'));

	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
		$list_config[] = array('title'=>'Người sửa','field'=>'action_username','ordering'=> 1, 'type'=>'action');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);

?>

<input type="hidden" id="id_move" value="">
<input type="hidden" id="id_move_to" value="">
<div id="popup_categories">
	<div class="close-pu">X</div>
	<div class="title-pu">Chọn danh mục muốn chuyển đến</div>

	<ul class="navmenu cls">
		
	</ul>
	<div class="btn-to"><span onclick="javascript:move_category()">Chuyển đến</span></div>
</div>

<script type="text/javascript">
	function set_id_move(id){
		$('#id_move').val();
		$('#id_move_to').val();
		$('#id_move').val(id);

		$.ajax({url: "index.php?module=products&view=categories&task=ajax_get_categories&raw=1",
			data: {id_move: id},
			dataType: "text",
			success: function(text) {
				$("#popup_categories .navmenu").html(text);
				$('#popup_categories').show();
			}
		});
	}

	function set_id_move_to(id){
		$('#id_move_to').val();
		$('#id_move_to').val(id);
		$('#popup_categories a').css('color','#000');
		$('.menu_a_'+id).css('color','red');
	}

	function move_category(){
		var id_move = $('#id_move').val();
		var id_move_to = $('#id_move_to').val();

		if(!id_move){
			alert('chưa tìm được danh mục muốn chuyển');
			return false;
		}

		if(!id_move_to){
			alert('chưa tìm được danh mục chuyển đến');
			return false;
		}


		if(id_move == id_move_to){
			alert('Bạn phải phọn danh mục khác');
			return false;
		}


		$.ajax({url: "index.php?module=products&view=categories&task=ajax_move_category&raw=1",
			data: {id_move: id_move,id_move_to:id_move_to},
			dataType: "text",
			success: function(text) {
				$('#popup_categories').hide();
				alert(text);
			}
		});




	}

	$('#popup_categories .close-pu').click(function(){
		$('#popup_categories').hide();
	});
</script>


<style type="text/css">
	#popup_categories{
		display: none;
	    position: fixed;
	    top: 50%;
	    left: 50%;
	    background: white;
	    z-index: 2;
	    transform: translate(-50%, -50%);
	    padding: 10px;
	    border: 2px solid #cccc;
	}
	#popup_categories .navmenu{
		width: 600px;
    	height: 350px;
    	overflow: scroll;
	}
	

	.title-pu{
		text-align: center;
	    font-size: 20px;
	    font-weight: bold;
	    margin-bottom: 18px;
	}
	.close-pu{
		display: inline-block;
	    float: right;
	    padding: 0px 10px;
	    color: red;
	    font-weight: bold;
	    font-size: 17px;
	    cursor: pointer;
	}
	.btn-to{
		text-align: center;
	}

	.btn-to span{
		padding: 10px;
	    background: #007cff;
	    color: #fff;
	    cursor: pointer;
	    border-radius: 3px;
	}

</style>