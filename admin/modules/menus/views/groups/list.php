<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Menu Group List ') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'unpublished.png');
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;

	//$filter_categories = array();
	//$filter_categories['title'] = FSText::_('Group'); 
	//$filter_categories['list'] = @$groups; 
	//$filter_categories['field'] = 'group_name'; 
	
	//$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						
	//	CONFIG	
    $list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'group_name', 'type'=>'text','col_width' => '20%','align'=>'left');
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'View','type'=>'view','module'=>'menus','view'=>'items');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	//$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
    
    TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		
?>