<?php  
	global $toolbar;
		
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '30%','align'=>'left','arr_params'=>array('have_link_edit'=> 1));
	$list_config[] = array('title'=>'Màu','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'name','size'=>10));
	$list_config[] = array('title'=>'Tổng','field'=>'total','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>2));
	$list_config[] = array('title'=>'CN1','field'=>'slcn1','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>1));
	$list_config[] = array('title'=>'CN2','field'=>'slcn2','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>1));
	$list_config[] = array('title'=>'CN3','field'=>'slcn3','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>1));
	$list_config[] = array('title'=>'Giá','field'=>'slcn3','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>1));
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
