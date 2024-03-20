	<?php 
	//	CONFIG	

	$fitler_config  = array();
	$list_config = array();
	$list_config[] = array('title'=>'#','field'=>'value','ordering'=> 1, 'type'=>'text', 'arr_params'=>array('function'=>'view_image_money'));
	// $list_config[] = array('title'=>'','field'=>'note','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Nội dung','field'=>'note','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Số điểm','field'=>'value','ordering'=> 1, 'type'=>'text', 'arr_params'=>array('function'=>'view_value'));
// 	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
// 	$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
// 	$list_config[] = array('title'=>'Category','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
// 	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
// 	$list_config[] = array('title'=>'Tổng views','field'=>'hits','ordering'=> 1, 'type'=>'text');
// 	// $list_config[] = array('title'=>'Xóa cache','field'=>'id','type'=>'remove','arr_params'=>array('function'=>'remove_cache'));
// 	$list_config[] = array('title'=>'Tin hot','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hot'));
// 	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
// 	$list_config[] = array('title'=>'Seo đạt','field'=>'point_seo','ordering'=> 1,'type'=>'point_seo');
// $list_config[] = array('title'=>'Edit','type'=>'edit');
// 	// $list_config[] = array('title'=>'Comment','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_comment'));
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
// //	$list_config[] = array('title'=>'Người tạo tin','field'=>'user_post','ordering'=> 1, 'type'=>'text');
// 	$list_config[] = array('title'=>'Người sửa','field'=>'action_username','ordering'=> 1, 'type'=>'action');
	// $list_config[] = array('title'=>'Lịch sử','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_history'));
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	TemplateHelper::genarate_form_liting2($this, $this->module,$this -> view,$history_point,$fitler_config,$list_config,@$sort_field,@$sort_direct,@$pagination);
	?>

	<style>
	.money_icon svg{
		width: 40px;
		height: 40px;
	}
	.point_down  svg {
		fill: gray;
	}
	.point_up svg {
		fill: #f6a700;
	}
	.point_down  {
		font-size: 20px;
		font-weight: bold;
		color: gray;
	}
	.point_up  {
		font-size: 20px;
		font-weight: bold;
		color: #f6a700;
	}
	tr th :nth-child(2) {
		display: none;
	}
	tr td :nth-child(2) {
		display: none;
	}
</style>