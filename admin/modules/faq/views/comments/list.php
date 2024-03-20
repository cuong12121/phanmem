<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Comment tin tức') );
//	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['text_count'] = 1;

	$text_record_id = array();
	$text_record_id['title'] =  'Id bài viết';
	$fitler_config['text'][] = $text_record_id;
	
	//	CONFIG	
	$list_config = array();
//	$list_config[] = array('title'=>'Comment','field'=>'comment','type'=>'text','col_width' => '30%');
	$list_config[] = array('title'=>'Bài viết','field'=>'title','ordering'=> 1, 'type'=>'text','col_width' => '40%');
	$list_config[] = array('title'=>'Id bài viết','field'=>'record_id','ordering'=> 1, 'type'=>'text','display_label'=>0,'col_width' => '6%');
//	$list_config[] = array('title'=>'Category','field'=>'category_name','ordering'=> 1, 'type'=>'text','col_width' => '20%');
//	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
