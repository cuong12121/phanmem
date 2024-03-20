<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Lịch sử') );
	
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
		

		//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;
	$fitler_config['text_count'] = 2;

	$filter_users = array();
	$filter_users['title'] = FSText::_('Thành viên'); 
	$filter_users['list'] = @$users; 
	$filter_users['field'] = 'username'; 

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
			
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');
	 
	 
	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;


	
	$fitler_config['filter'][] = $filter_users;	

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Username','field'=>'username','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Userid','field'=>'user_id','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Module','field'=>'module','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Module con','field'=>'view','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Task','field'=>'task','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Id ảnh hưởng','field'=>'ids_action','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Mô tả','field'=>'','type'=>'','arr_params'=>array('function'=>'description_history'));
	$list_config[] = array('title'=>'IP','field'=>'ipaddress','ordering'=> 1, 'type'=>'text');
	
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	// $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>