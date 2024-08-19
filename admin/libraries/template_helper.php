<?php 
class TemplateHelper
{
	var $controle ;

	function __contruct($controle){
		$this -> controle = $controle;
	}
	
	public static function reverse_status($cid,$field, $value_new,$module,$view)
	{

		if($value_new != 1)
		{
			
			$html =  "<div id='cb_".$cid."_".$field."'><a  title=\"Disable item\" onclick=\"return ajax_listItemTask('$cid','$field','$value_new','$module','$view')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"".URL_ADMIN."templates/default/images/published.png\"></a></div>";
		}
		else
		{
			$html =  "<div id='cb_".$cid."_".$field."'><a i title=\"Enable item\" onclick=\"return ajax_listItemTask('$cid','$field','$value_new','$module','$view')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"".URL_ADMIN."templates/default/images/unpublished.png\"></a></div>";
		}		
		return $html;
	}
	public static function published($cid, $status)
	{
		if($status != 'published')
		{
			
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"".URL_ADMIN."templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"".URL_ADMIN."templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	
	public static function  dt_date_pick($title, $name, $value, $default = '', $size = 60, $comment = '',$class_col1='col-md-2',$class_col2='col-md-10',$class_col3 ='col-md-6') {
		if (! isset ( $value )) $value = $default;
		//$value = escape($value);
		echo '<div class="form-group">';
		echo '	<label class="'.$class_col1.' col-xs-12 control-label">' . $title . '</label>';
		echo '	<div class="'.$class_col2.' col-xs-12">';
		echo '	<div class="row">';
		echo '	<div class="'.$class_col3.' col-xs-6">';
		echo '		<input class="form-control" type="text" name="' . $name . '"  readonly="true" id="' . $name . '" value="' . htmlspecialchars ( $value ) . '" size="' . $size . '"/>';	
		echo '	</div>';
		echo '		<a class="fl-left fa fa-calendar" href="javascript:void(0)" onclick="javascript:NewCssCal (\''.$name.'\',\'YYYYmmdd\',\'arrow\',true,\'24\')">';
		//echo '			<img border="0" alt="Calenda" src="templates/default/images/cal.gif">';
		echo '		</a>';
		echo '	</div>';
		if ($comment) echo '<span class=\'comment\'>' . $comment . '</span>';
		echo '	</div>';
		echo '</div>';
		echo '<script type="text/javascript" src="../admin_esw_2/templates/default/js/datetimepicker.js"></script>';
	}
	
	public static function  datetimepicke($title, $name, $value, $default = '', $size = 60, $comment = '',$class_col1='col-md-2',$class_col2='col-md-10',$class_col3 ='col-md-6') {
		if (! isset ( $value )) $value = $default;
		//$value = escape($value);
		echo '<link rel="stylesheet" type="text/css" media="screen" href="../admin_esw_2/templates/default/css/bootstrap-datetimepicker.min.css">
		';
		echo '<div class="form-group">';
		echo '	<label class="'.$class_col1.' col-xs-12 control-label">' . $title . '</label>';
		echo '	<div class="'.$class_col2.' col-xs-12">';
		echo '	<div class="input-group date datetimepicker" id="datetimepicker_'.$name.'">';
		echo '		<input class="form-control" type="text" name="' . $name . '"  id="' . $name . '"  value="' . htmlspecialchars ( $value ) . '" size="' . $size . '"/>';	
		echo '		<span class="input-group-addon">
		<span class="glyphicon glyphicon-calendar"></span>
		</span>';
		echo '	</div>';
		if ($comment) echo '<span class=\'comment\'>' . $comment . '</span>';
		echo '	</div>';
		echo '</div>';
		echo '<script src="../admin_esw_2/templates/default/js/moment.js">
		</script><script src="../admin_esw_2/templates/default/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
		$(function() {
			$(".datetimepicker").datetimepicker({
				format: "YYYY-MM-DD HH:mm:ss"
				});
				});
				</script> 
				';
			}

			public static function edit_grapesjs($link)
			{
				$html =  "<a title=\"Edit Layer\" target=\"_blank\" href=\"$link\">";
				$html .="<img  border=\"0\" alt=\"Views\" src=\"".URL_ADMIN."templates/default/images/display.png\" /></a>";
				return $html;
			}
			
			public static function  jscolorpicker($title, $name, $value, $default = 'FFFFFF', $size = 10, $comment = '',$class_col1='col-md-2',$class_col2='col-md-10') {
				if (! isset ( $value )) $value = $default;
		//$value = escape($value);
				echo '<script type="text/javascript" src="../admin_esw_2/templates/default/js/jscolor.js"></script>';
				echo '<div class="form-group">';
				echo '	<label class="'.$class_col1.' col-xs-12 control-label" >' . $title . '</label>';
				echo '	<div class="'.$class_col2.' col-xs-12">';
				echo '		<input class="jscolor form-control" type="text" name="' . $name . '"  id="' . $name . '" value="' . htmlspecialchars ( $value ) . '" size="' . $size . '"/>';	
				if ($comment) echo '<span class=\'comment\'>' . $comment . '</span>';
				echo '	</div>';
				echo '</div>';
			}
	/*
	 * For special case.
	 * Reserve with published
	 */
	public static function published2($cid, $status)
	{
		if($status != 'unpublished')
		{
			
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"".URL_ADMIN."templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"".URL_ADMIN."templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	public static function activated($cid, $status)
	{
		if($status != 'activated')
		{
			
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"".URL_ADMIN."templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"".URL_ADMIN."templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	
	public static function changeStatus($cid, $status)
	{
		if(substr(trim($status),0,2) == 'un')
		{
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"".URL_ADMIN."templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"".URL_ADMIN."templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	public static function viewStatus($cid, $status)
	{
		if(substr(trim($status),0,2) == 'un')
		{
			$html =  "<img border=\"0\" alt=\"Enabled status\" src=\"".URL_ADMIN."templates/default/images/published.png\">";
		}
		else
		{
			$html =  "<img border=\"0\" alt=\"Disable status\" src=\"".URL_ADMIN."templates/default/images/unpublished.png\">";
		}		
		return $html;
	}
	public static  function views($link)
	{
		$html =  "<a style='font-size:20px;' title=\"Xem\" href=\"$link\">";
		$html .= " <i class='fa fa-link'></i></a>";
		return $html;
	}
	public static function edit($link)
	{
		$html =  "<a title=\"Sửa\" href=\"$link\">";
		$html .="<img  border=\"0\" alt=\"Sửa\" src=\"".URL_ADMIN."templates/default/images/edit.png\" /></a>";
		return $html;
	}

	public static function list_action($id,$list_action,$module,$view){
		$html = '<div class="wrap_action">';
		$html .= '<a title="Thao tác" href="javascript:void(0)" onclick="open_list_action('."'a_action_".$id."'".')" class="a_action" id="a_action_'.$id.'"><img  border="0" alt="Thao tác" src="'.URL_ADMIN.'templates/default/images/action.png" /></a>';
		$html .= '<div class="d_action hide" id="d_action_'.$id.'">';
		foreach ($list_action as $key => $value) {
			$link  = FSRoute::_("index.php?module=".$module."&view=".$view."&task=".$key."&id=".$id);
			$html .= '<div class="item">';
			if($key == 'edit' || $key == 'revoke') {
				$html .= '<a target="" href="'.$link.'">';
			} else {
				$html .= '<a target="_blank" href="'.$link.'">';
			}
			
			$html .= '<img  border="0" alt="'.$value.'" src="'.URL_ADMIN.'templates/default/images/'.$key.'.png" />';
			$html .= $value.'</a>';
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	
	/*
	 * $title_field is Title
	 * field_select is value of fields in thead 
	 * field_sorting is value of fields is sorting.
	 * sort_direct: asc, desc
	 */
	public static function order_field($title_field,$field_select, $field_sorting  = '', $sort_direct ='')
	{
		$url = $_SERVER['REQUEST_URI'];
		$url =  trim(preg_replace('/&sortby=[a-zA-Z0-9_]+/i', '', $url)); // field
		$url =  trim(preg_replace('/&sort=[a-z]+/i', '', $url));  // direct
		
		$sort_direct = $sort_direct?$sort_direct:'asc';
		$sort_direct_continue = $sort_direct == 'asc' ? 'desc' : 'asc';
		$link = $url.'&sortby='.$field_select.'&sort='.$sort_direct_continue;
		if($field_select == $field_sorting)
		{
			$html  =  "<a title=\"Click to sort by this column\" href=\"$link\">";
			$html .= $title_field ;
			$html .= "<img alt=\"$sort_direct\" src=\"".URL_ADMIN."templates/default/images/sort_$sort_direct.png\">";
			$html .= "</a>";
			
		}
		else
		{
			$html =  "<a title=\"Click to sort by this column\" href=\"$link\">$title_field</a>";
		}
		return $html ; 
	}
	/* USE SESSTION
	 * $title_field is Title
	 * field_select is value of fields in thead 
	 * field_sorting is value of fields is sorting.
	 * sort_direct: asc, desc
	 */
	public static  function orderTable($title_field,$field_select, $field_sorting , $sort_direct)
	{
		$sort_direct = $sort_direct?$sort_direct:'asc';
		$sort_direct_continue = $sort_direct == 'asc' ? 'desc' : 'asc';
		if($field_select == $field_sorting)
		{
			$html  =  "<a title=\"Click to sort by this column\" href=\"javascript:tableOrdering('$field_select','$sort_direct_continue','');\">";
			$html .= $title_field ;
			$html .= "<img alt=\"$sort_direct\" src=\"".URL_ADMIN."templates/default/images/sort_$sort_direct.png\">";
			$html .= "</a>";
			
		}
		else
		{
			$html =  "<a title=\"Click to sort by this column\" href=\"javascript:tableOrdering('$field_select','$sort_direct_continue','');\">$title_field</a>";
		}
		return $html ; 
	}
	/*
	 * rows > 0 ? textarea: input
	 * name: field_name
	 * display: echo 
	 */
	public static  function edit_text($name,$value,$i,$size = 3,$rows = 1){
		if($rows > 1){
			$html = '<textarea class="form-control" rows="'.$rows.'" cols="'.$size.'" name="'.$name.'_'.$i.'" >'.htmlspecialchars($value).'</textarea>';
			$html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.htmlspecialchars($value).'"/>';
		}else{
			$html = '<input class="form-control" type="text" name="'.$name.'_'.$i.'"  value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
			$html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.htmlspecialchars($value).'"/>';
		}
		return $html;
	}
	/*
	 * rows > 0 ? textarea: input
	 * name: field_name
	 */
	public static function edit_selectbox($name,$value,$i,$arry_select = array(),$field_value = 'id', $field_label='name',$size = 1,$multi  = 0,$class=''){
		$class = $class? $class:'chosen-select';
		if(!$multi){
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html = '<select class="form-control chosen-select" name="'.$name.'_'.$i.'" id="'.$name.'_'.$i.'" '.$html_sized.'>';
			$compare  = 0;
			if(@$value)
				$compare = $value;
			$j = 0;
			if(count($arry_select) && $arry_select){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(!$compare && !$j){
							$checked = "selected=\"selected\"";
						} else {
							if($compare === ($select_item->$field_value))
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						$checked = "";
						if(!$compare && !$j){
							$checked = "selected=\"selected\"";
						} else {
							if($compare == $key)
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
			$html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.$value.'"/>';
		} else {
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html = '<select class="form-control chosen-select-no-results" name="'.$name.'_'.$i.'[]" id="'.$name.'_'.$i.'" '.$html_sized.'  multiple="multiple">';
			$array_value  = isset($value)?explode(',',$value):array();
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(in_array($select_item->$field_value,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						if(in_array($name,$array_value))
							$checked = "selected=\"selected\"";
						
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
			$html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.$value.'"/>';
		}
		
		return $html;
	}
	/*
	 * Show one item in array
	 * name: field_name
	 */
	public static function text_in_array($name,$value,$i,$arry_select = array(),$field_value = 'id', $field_label='name'){
		$html = '';
		if(count($arry_select) && $arry_select){
			if(is_object(end($arry_select))){
				foreach ($arry_select as $select_item) {
					if($value === ($select_item->$field_value)){
						$html .= $select_item -> $field_label;
						break;	
					}
				}
				
			} else {
				if(isset($arry_select[$value])){
					$html .= $arry_select[$value];
				}
			}
		}
		$html .= '';
		
		return $html;
	}
	
	function changeLimit($arr_limit){
		$url = $_SERVER['REQUEST_URI'];
		$limit = FSInput::get('limit',0,'int');
		$html  = '<div style="text-align: center; font-weight: bold; margin-top: 10px;">';
		$html .= "<select name=\"changeLimit\" id=\"changeLimit\" onchange=\"change_limit( this.value,'".$url."' );\" >";
		$html .= '<option value="" >Limit</option>';
		if(count($arr_limit)){
			foreach ($arr_limit as $limit_item) {
				$checked = "";
				if($limit_item == $limit){
					$checked = "selected=\"selected\"";
				}
				$html .= '<option value="'.$limit_item.'" '.$checked.'>'.$limit_item.'</option>';
			}
		}
		$html .= '</select>';
		$html .='</div>';
		return $html;
	}  
	/****
	 * For list
	 * config: array(title,field,ordering,type,col_width,no_col,no_col_sepa,align,arr_params,display_label)
	 * type: text, datetime, date, image, edit_text,edit_selectbox, published,edit,change_status,
	 * text: display string 
	 * @ordering: ordering this cols
	 * display_label: display title into body 
	 * no_col_sepa: sepa in col (default: break line)
	 * arr_params by type: edit_text($size,$rows)
	 * 						text (have_link_edit,public static function)
	 * 						label 
	 * 						image(search,replace,have_link_edit,with,heigh)
	 * 						edit_selectbox(arry_select,field_value,field_label,size,multi)
	 * 						change_status(function)
	 * 	 * ==============
	 * $params: the hidden tag name need add in form
	 * 
	 */ 
	public static function genarate_form_liting($controle,$module,$view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination = null,$params = array(),$first='index.php'){

		$module =$_GET['module'];
		$view= $_GET['view'];

		if(!isset($list_config) && !count($list_config)){
			return;	
		}

		$total_col =  0;
		if(!empty($list_config)){
			$total_col =  count($list_config)+2;
		}

		$error_img = "";
		$prefix = $module.'_'.$view.'_';


		if(@$fitler_config['type']=='no_auto') {
			$html_filter = !empty($fitler_config)? TemplateHelper::create_filter_2($fitler_config,$prefix) : '';
		} else {
			$html_filter = !empty($fitler_config)? TemplateHelper::create_filter($fitler_config,$prefix) : '';
		}
		
		$link = $first.'?module='.$module.'&view='.$view;
		if(count($params)){
			foreach($params as $name => $param){
				$link .= '&'.$name.'='.$param;
			}
		}

		$link = FSRoute::_($link);
		$html_begin = '<div class="panel panel-default">
		
		<div class="panel-body" >
		<form class="form-horizontal" action="'.$link.'" name="adminForm" method="post">';
		$i = 1;
		$arr_head  = array();
		$arr_config = array();
		$arr_field_change = array();
		$view_view = '';
		$view_module = '';
		$view_task = '';
		$field_value = 'id';
		
		// Đánh số thứ tự
		$page = isset($pagination -> page)?$pagination -> page:0;
		$page = $page < 1?1:$page;
		$limit = isset($pagination -> limit)?$pagination -> limit:10;
		$start = ($page - 1)*$limit;
		foreach($list_config as $item){
			$col = $i;
			if(isset($item['no_col']))
				$col = $item['no_col'];
			if(!isset($arr_head[$col])){
				$col_width = isset($item['col_width'])?'width="'.$item['col_width'].'"':'';
				if(!isset($item['ordering']) || empty($item['ordering'])){
					$arr_head[$col] = '<th class="title 1" '.$col_width.' >'.FSText :: _($item['title']).'</th>';
				}else{
					$arr_head[$col] = '<th class="title 2" '.$col_width.' >'.TemplateHelper::orderTable(FSText :: _($item['title']), @$item['field'],@$sort_field,@$sort_direct).'</th>';
				}
				$arr_config[$col] = array();
			}
            //var_dump($list_config[$i]['module']);
			if(!empty($list_config[$i]['field_value'])){
				$field_value = $list_config[$i]['field_value'];
			}
			
			if(!empty($list_config[$i]['module'])){
				$view_module = $list_config[$i]['module'];
			}
			if(!empty($list_config[$i]['task'])){
				$view_task  = $list_config[$i]['task'];
			}
			if(!empty($list_config[$i]['view'])){
				$view_view = $list_config[$i]['view'];
			}
			$arr_config[$col][] = $item;
			$type = isset($item['type'])?$item['type']:'text';
			if($type == 'edit_text' || $type == 'edit_selectbox'){
				$arr_field_change[] = $item['field'];
			}
			$i ++;
			
		}
		$html_head = '<div class="dataTable_wrapper">
		<table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered"><thead><tr>';
		$html_head .= '<th width="30px" ></th>
		<th width="30px" >
		<input class="checkbox-custom" id="checkAll_box" type="checkbox" onclick="checkAll('.count($list).')" value="" name="toggle">
		<label for="checkAll_box" class="checkbox-custom-label"></label>
		</th>';
		$html_head .= implode('',$arr_head);
		$html_head .= '</tr></thead>';
		$html_body = '<tbody>';
		$total = 0;
		
		if(!count($list)){
		}else{
			$i = 0;
			$view_task = $view_task? '&task='.$view_task:'';
			
			foreach($list as $row){

			    //var_dump($item['module']); 
				$link_edit = FSRoute::_("index.php?module=".$module."&view=".$view."&task=edit&id=".$row->id."&page=".$page);
				
				$link_view = FSRoute::_("index.php?module=".$view_module."&view=".$view_view.$view_task."&".$field_value."=".$row->id);

				$link_view_gav = FSRoute::_("index.php?module=".$module."&view=movingaverage").'?'.$field_value."=".$row->id;
				
				$html_body .= '<tr class="row'.($i%2).'">';
				$html_body .= '<td>'.($i+$start+1).'<input type="hidden" name="id_'.$i.'" value="'.$row->id.'"/> </td>';

				if($module == 'products' && $view == 'products' || $module == 'news' && $view == 'news'){

					$permission = FSSecurity::check_permission($module, $view, 'published');
					$permission_orther = FSSecurity::check_permission_other($module, $view, 'published');

					if($permission && $permission_orther){
						$html_body .= '<td>
						<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'">
						<label for="cb'.$i.'" class="checkbox-custom-label"></label>
						</td>';
					}

					if($permission && !$permission_orther){
						if($row-> creator_id ==  $_SESSION['ad_userid']){
							$html_body .= '<td>
							<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'">
							<label for="cb'.$i.'" class="checkbox-custom-label"></label>
							</td>';
						}else{
							$html_body .= '<td>
							<label for="cb'.$i.'" class="checkbox-custom-label"></label>
							</td>';
						}
					}

					if(!$permission && !$permission_orther){
						$html_body .= '<td>
						<label for="cb'.$i.'" class="checkbox-custom-label"></label>
						</td>';
					}
				}elseif($module == 'order' && $view == 'upload'){
					if($row-> is_print == 1){
						$html_body .= '<td>Đã in</td>';	
					}else{
						$html_body .= '<td>
						<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'">
						<label for="cb'.$i.'" class="checkbox-custom-label"></label>
						</td>';
						
					}
					
				}elseif($module == 'order' && $view == 'upload'){
					if($row-> is_print == 1){
						$html_body .= '<td>Đã in</td>';	
					}else{
						$html_body .= '<td>
						<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'">
						<label for="cb'.$i.'" class="checkbox-custom-label"></label>
						</td>';
						
					}
				}elseif($module == 'warehouses' && $view == 'bill' || $module == 'warehouses' && $view == 'bill_transfer' || $module == 'warehouses' && $view == 'check'){
					if($row-> status == 4){
						$html_body .= '<td>Đã hoàn thành</td>';	
					}else{
						$html_body .= '<td>
						<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'">
						<label for="cb'.$i.'" class="checkbox-custom-label"></label>
						</td>';
					}
				}
				else{
					$html_body .= '<td>
					<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'">
					<label for="cb'.$i.'" class="checkbox-custom-label"></label>
					</td>';
				}

				
				if(@$row->total_after_discount){
					$total += $row -> total_after_discount;
				} 

				if($module == 'shops' && $view == 'recharges'){
					if(@$row->money){
						$total += $row -> money;
					} 
				}               
				
				foreach($arr_config as $col){
					if(!count($col)){
						continue;
					}
					if(isset($col[0]['align']))
						$html_body .= '<td class = "'.$col[0]['align'].'">';
					else 
						$html_body .= '<td><div class="wrap_list_pr">';
					$j = 0;
					foreach($col as $item){
						if($j > 0){
							if(@$item['no_col_sepa'])
								$html_body .= $item['no_col_sepa'];
							else
								$html_body .= '<br/><div class="break_line">&nbsp;</div>';
						}
						
						$field = isset($item['field'])?$item['field']:null;	
						$type = isset($item['type'])?$item['type']:'text';

						

						$display_label = isset($item['display_label'])?$item['display_label']:0;
						if($display_label)
							$html_body .= $item['title'].': ';

						switch($type){
							case 'published':
							if($module == 'products' && $view == 'products' || $module == 'news' && $view == 'news'){
								$permission = FSSecurity::check_permission($module, $view, 'published');
								$permission_orther = FSSecurity::check_permission_other($module, $view, 'published');
								if($permission && $permission_orther){
									$html_body .= TemplateHelper::reverse_status(($row -> id),$item['field'],$row->published?"0":"1",$module,$view);
								}

								if($permission && !$permission_orther){
									if($row-> creator_id ==  $_SESSION['ad_userid']){
										$html_body .= TemplateHelper::reverse_status(($row -> id),$item['field'],$row->published?"0":"1",$module,$view);
									}else{
										$html_body .= $row->published == 0 ? FSText::_('Không kích hoạt'):FSText::_('Kích hoạt');
									}
								}

								if(!$permission && !$permission_orther){
									$html_body .= $row->published == 0 ? FSText::_('Không kích hoạt'):FSText::_('Kích hoạt');
								}
							}else{
								$permission = FSSecurity::check_permission($module, $view, 'published');
								if (!$permission){
									$html_body .= $row->published == 0 ? FSText::_('Không kích hoạt'):FSText::_('Kích hoạt');
								}else{
									$html_body .= TemplateHelper::reverse_status(($row -> id),$item['field'],$row->published?"0":"1",$module,$view);
								}
							}

							break;
							case 'label':
							$j --;
							break;
							case 'list_action':


							$list_action = $item['list_action'];
							$html_body .= TemplateHelper::list_action(($row -> id),$list_action,$module,$view);
								// print_r($list_action);
							break;

							case 'change_status':
								$inverse = isset($item['arr_params']['inverse'])?$item['arr_params']['inverse']: 0;// nghịch đảo giá trị
								$function = isset($item['arr_params']['function'])?$item['arr_params']['function']: $field;
								$html_body .= TemplateHelper::reverse_status(($row -> id),$item['field'],$row->$field?"0":"1",$module,$view);

								// if($inverse == 1)
								// 	$html_body .= TemplateHelper::changeStatus("cb".($i),$row->$item['field']?$function:"un".$function);
								// else 
								// 	$html_body .= TemplateHelper::changeStatus("cb".($i),$row->$item['field']?"un".$function:$function);
								break;
								case 'edit':
								$html_body .= TemplateHelper::edit($link_edit);
								break;
								case 'view':
								$html_body .= TemplateHelper::views($link_view);
								break;

								case 'view_gav':
								$html_body .= TemplateHelper::views($link_view_gav);
								break;
								
								case 'datetime':
								if(!$row->$field)
									$html_body .= '-';
								else	
									$html_body .= date('d/m/Y H:i',strtotime($row->$field));
								break;
								case 'date':
								$html_body .= date('d/m/Y',strtotime($row->$field));


								break;
								case 'edit_text':
								$size = isset($item['arr_params']['size'])?$item['arr_params']['size']: 10;
								$rows = isset($item['arr_params']['rows'])?$item['arr_params']['rows']: 1;

								

								$html_body .= TemplateHelper::edit_text($field,$row->$field,$i,$size,$rows);
								break;
								case 'edit_selectbox':
								$arry_select = isset($item['arr_params']['arry_select'])?$item['arr_params']['arry_select']: array();
								$field_value = isset($item['arr_params']['field_value'])?$item['arr_params']['field_value']: 'id';
								$field_label = isset($item['arr_params']['field_label'])?$item['arr_params']['field_label']: 'name';
								$multi = isset($item['arr_params']['multi'])?$item['arr_params']['multi']: 0;
								$size = isset($item['arr_params']['size'])?$item['arr_params']['size']: 1;
								$html_body .= TemplateHelper::edit_selectbox($field,$row->$field,$i,$arry_select,$field_value,$field_label,$size,$multi);
								break;
								case 'text_in_array':
								$arry_select = isset($item['arr_params']['arry_select'])?$item['arr_params']['arry_select']: array();
								$field_value = isset($item['arr_params']['field_value'])?$item['arr_params']['field_value']: 'id';
								$field_label = isset($item['arr_params']['field_label'])?$item['arr_params']['field_label']: 'name';
								$html_body .= TemplateHelper::text_in_array($field,$row->$field,$i,$arry_select,$field_value,$field_label);
								break;
								case 'image':
								if(!isset($row -> $field))
									break;
								$link_img = $row -> $field;
								if(!$link_img)
									break;
								if(isset($item['arr_params']['search']) && isset($item['arr_params']['replace'])){
									$link_img = str_replace($item['arr_params']['search'], $item['arr_params']['replace'], $link_img);
								}
								//with,height
								$html_size = '';
								$width = isset($item['arr_params']['width'])?$item['arr_params']['width']:0;
								$height = isset($item['arr_params']['height'])?$item['arr_params']['height']:0;
								if($width)
									$html_size .= ' width = "'.$width.'"'; 
								if($height)
									$html_size .= ' height = "'.$height.'"'; 
								//link
								$have_link_edit = isset($item['arr_params']['have_link_edit'])?$item['arr_params']['have_link_edit']:0;
								if($have_link_edit)
									$html_body .= '<a href="'.$link_view.'"><img onerror="'.$error_img.'" src="'.URL_ROOT.$link_img.'" '.$html_size.' /></a>';
								else
									$html_body .= '<img class="show_all_image" onclick="show_all_image('.$row -> id.')" onerror="'.$error_img.'" src="'.URL_ROOT.$link_img.'" '.$html_size.' />';
								break;
								case 'order':
								$estore_code = 'DH';
								$estore_code .= str_pad($row -> id, 8 , "0", STR_PAD_LEFT);
								$html_body .= $estore_code;
								break;
								case 'format_money':
								// print_r($row);die;
								$html_body .= format_money($row -> $field,' đ','0 đ');
								break;
								case 'text_link':
								$link_web = $item['link']? $item['link']:'';




								
								if($link_web){
									if(@$row->category_alias){
										$link_web = str_replace('ccode=ccode','ccode='.$row->category_alias,$link_web);
									}
									if(@$row->category_alias){
										$link_web = str_replace('cid=cid','cid='.$row->category_id,$link_web);
									}
									$link_web = str_replace('code=code','code='.$row->alias,$link_web);
									$link_web = str_replace('id=id','id='.$row->id,$link_web);


									$link_web = FSRoute::_("$link_web");
									
									// $link_web = FSRoute::_("$link_web");
									$html_body .= '<a target="_blank" href="'.$link_web.'">'.$row -> $field.'</a>';
								}


								break; 


								
								case 'table_name':
								$table_name = $row->$field;
								$table_name = str_replace('fs_products_', '',$table_name);
								$link = 'index.php?module='.$module.'&view=tables&task=edit&tablename='.$table_name;
								$html_body .= '<a href="'.$link.'" title="Sửa bảng" >'.$table_name.'</a>';
                                //$html_body .= format_money($row -> $field,' VNĐ');
								break;
								case 'status':
								$status = 1+$row->status;
								foreach($item['arr_params'] as $value){
                                    //print_r($value->id);
									if($value->id == $status){
										$html_body .= $value->name;
									}   
								}
								break;            
								case 'text':
								if(($field == 'id' || $field == 'code' || $field == 'name') && empty($item['arr_params']['function'])) {

									if($module == 'products' && $field == 'name'){
										$html_body .= '<a onclick="show_info_product('.$row -> id.')" href="javascript:void()">'.$row -> $field.'</a>';
									}else{
										$html_body .= '<a href="'.$link_edit.'">'.$row -> $field.'</a>';
									}
									break;
								}

								default:


								
								if(isset($item['arr_params']['function']) && !empty($item['arr_params']['function'])){
									$function = $item['arr_params']['function'];
									$params_for_function = @$item['arr_params']['params_for_function'];
									if($field){ // nếu định nghĩa field: params sẽ truyền vào là $row -> field
										if($params_for_function)
											$html_body .= 	$function($row -> $field,$params_for_function,$i);
										else 
											$html_body .= 	$function($controle,$row -> $field);
									}else{ // nếu ko định nghĩa field: params sẽ truyền vào là ca $row 
										if($params_for_function)
											$html_body .= 	$function($row,$params_for_function,$i);
										else 
											$html_body .= 	$function($controle,$row);
									}	
								}else{									
									// die;
									if(isset($item['arr_params']['have_link_edit']) && !empty($item['arr_params']['have_link_edit']))
										$html_body .= '<a href="'.$link_edit.'" >'.$row -> $field.'</a>';
									else 
										$html_body .= @$row -> $field;
									break;									
								}
							}
							$j ++;
						}
						$html_body .= '</div></td>';
					}

					$html_body .= '</tr>';
					$i++;
				}
			}

			if($module =='warranty_department'){
				dd($html_body);
			}

			$html_body .= '</tbody></table>';
			if($total){
				$html_body .= '<div class="total-price" >
				<span> '.FSText::_('Tổng tiền').':</span>
				<strong class="red">'.format_money($total,' VNĐ').'</strong>
				</div>'; 
			}


			$html_footer = '<nav aria-label="Page navigation">';
			if(isset($pagination)) {
				$html_footer .=  $pagination->showPagination();
			} 
			if(isset($limit_config)){
				$html_footer .=  TemplateHelper::changeLimit($limit_config,$this->page);
			}
			$html_footer .= '</nav>';
			$html_field_change =  count($arr_field_change)?implode(',',$arr_field_change):'';
			$page = FSInput::get('page',0,'int');
			$limit = FSInput::get('limit',0,'int');
			$html_footer .='<input type="hidden" value="'.@$sort_field.'" name="sort_field" />';
			$html_footer .='<input type="hidden" value="'.@$sort_direct.'" name="sort_direct" />';
			$html_footer .='<input type="hidden" value="'.$module.'" name="module" />';
			$html_footer .='<input type="hidden" value="'.$view.'" name="view" />';
			$html_footer .='<input type="hidden" value="'.($i+1).'" name="total">';
			$html_footer .='<input type="hidden" value="'.FSInput::get('page',0,'int').'" name="page">';
			$html_footer .='<input type="hidden" value="'.$html_field_change.'" name="field_change">';
			$html_footer .='<input type="hidden" value="" name="task">';
			$html_footer .='<input type="hidden" value="0" name="boxchecked">';
			$html_footer .='<input type="hidden" value="'.$page.'" name="page">';
			$html_footer .='<input type="hidden" value="'.$limit.'" name="limit">';
			
			$html = $html_begin.$html_filter.$html_head.$html_body.$html_footer.'</form></div></div>';


//		$html = '<xmp>'.$html_begin.$html_filter.$html_head.$html_body.$html_footer.'</form></div>'.'</xmp>';
			echo $html;
		}
		
	/*
	 * Tạo cột phụ cạnh cột chính
	 * Note: Ko có param Comments
	 */
	static function sub_edit_selectbox($title,$name,$value,$default = '',$arry_select = array(),$field_value = 'id', $field_label='name',$size = 1,$multi  = 0,$add_fisrt_option=0){
		$html = '<span>'.$title.'</span>';
		if(!$multi){
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select name="'.$name.'" id="'.$name.'" '.$html_sized.'>';
			$compare  = 0;
			if(isset($value))
				$compare = $value;
			else 
				$compare = $default;
			
			if($add_fisrt_option){
				$checked = "";
				if(!$compare)
					$checked = "selected=\"selected\"";
				$html .= '<option  value="0" '.$checked.'>--'.$title.'--</option>';
			}	
			$j = 0;
			if(count($arry_select)){
				
				if(is_object(end($arry_select))){
					
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(!$compare && !$j && !$add_fisrt_option){
							$checked = "selected=\"selected\"";
						} else {
							if($compare === ($select_item->$field_value))
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						$checked = "";
						if(!$compare && !$j && !$add_fisrt_option){
							$checked = "selected=\"selected\"";
						} else {
							if($compare == $key)
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}else{
			// not working
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select name="'.$name.'[]" id="'.$name.'" '.$html_sized.' multiple="multiple">';
			$array_value  = isset($value)?explode(',',$value):array();
//			$compare  = 0;
//			if(@$value)
//				$compare = $value;
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(in_array($select_item->$field_value,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						if(in_array($name,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}
		$html .= '';
		return $html;
	}
	/*
	 * FOR DETAIL PAGE
	 * name: field_name
	 * $sub_item: cột phụ
	 */
	static function dt_edit_selectbox($title,$name,$value,$default = '',$arry_select = array(),$field_value = 'id', $field_label='name',$size = 1,$multi  = 0,$add_fisrt_option=0,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 1){
		global $db;
		$module =$_GET['module'];
		$view= $_GET['view'];
		if(!empty($_SESSION[$module][$view])){
			// echo "<pre>";
			// print_r($_SESSION[$module][$view]);
			// die;
			$data_ss = $_SESSION[$module][$view];
			
		}


		$class = $class? $class:'';
		$html = '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.' col-xs-12">
		';
		
		if(!$multi){

			$html_sized = $size > 1 ? "size=$size":"" ;
			if($add_id  == 1){
				$html .= '<select data-placeholder="'.$title.'" class="form-control select2" name="'.$name.'" id="'.$name.'" '.$html_sized.'>';
			}else{
				$html .= '<select data-placeholder="'.$title.'" class="form-control select2" name="'.$name.'" '.$html_sized.'>';
			}
			
			$compare  = 0;
			
			if(!empty($data_ss[$name])){
				$compare = $data_ss[$name];
			}else{
				if(isset($value)){
					$compare = $value;
				}
				else{
					$compare = $default;
				} 
			}
			

			
			if($add_fisrt_option){
				$checked = "";
				if(!$compare)
					$checked = "selected=\"selected\"";
				$html .= '<option  value="0" '.$checked.'>--'.$title.'--</option>';
			}	
			$j = 0;
			if($arry_select && count($arry_select)){
				
				if(is_object(end($arry_select))){
					
					foreach ($arry_select as $select_item) {
						$checked = "";

						if(!$compare && !$j && !$add_fisrt_option){

							$checked = "selected=\"selected\"";
							
						} else {
							if($compare === ($select_item->$field_value))
								$checked = "selected=\"selected\"";
						}

						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';

						$j ++;
					}

					// echo  $html;
					// die;
					

				} else {
					
					foreach ($arry_select as $key => $name) {
						$checked = "";
						if(!$compare && !$j && !$add_fisrt_option){
							$checked = "selected=\"selected\"";
						} else {
							if($compare == $key)
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}else{
			// not working
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select data-placeholder="'.$title.'" class="form-control " name="'.$name.'[]" id="'.$name.'" '.$html_sized.' multiple="multiple">';
          //  if($add_fisrt_option){
//				$html .= '<option>--'.$title.'--</option>';
//			}
			$array_value  = isset($value)?explode(',',$value):array();
			
//			$compare  = 0;
//			if(@$value)
//				$compare = $value;
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(in_array($select_item->$field_value,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						$checked = "";
						
						// if(in_array($name,$array_value))
						if(in_array($key,$array_value))	
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}
		if($sub_item)
			$html .= $sub_item;
		if($comment)
			$html .= '<p class="help-block">'.$comment.'</p>';
		$html .= '</div></div>';
		echo $html;
	}



	static function dt_edit_selectbox_parent($title,$name,$value,$default = '',$arry_select = array(),$field_value = 'id', $field_label='name',$size = 1,$multi  = 0,$add_fisrt_option=0,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10'){
		global $db;
		$module =$_GET['module'];
		$view= $_GET['view'];
		if(!empty($_SESSION[$module][$view])){
			// echo "<pre>";
			// print_r($_SESSION[$module][$view]);
			// die;
			$data_ss = $_SESSION[$module][$view];
			
		}


		$class = $class? $class:'';
		$html = '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.' col-xs-12">
		';
		if(!$multi){

			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select data-placeholder="'.$title.'" class="form-control " name="'.$name.'" id="'.$name.'" '.$html_sized.'>';
			$compare  = 0;
			
			if(!empty($data_ss[$name])){
				$compare = $data_ss[$name];
			}else{
				if(isset($value)){
					$compare = $value;
				}
				else{
					$compare = $default;
				} 
			}
			

			
			if($add_fisrt_option){
				$checked = "";
				if(!$compare)
					$checked = "selected=\"selected\"";
				$html .= '<option  value="0" '.$checked.'>--'.$title.'--</option>';
			}	
			$j = 0;
			if($arry_select && count($arry_select)){
				
				if(is_object(end($arry_select))){
					
					foreach ($arry_select as $select_item) {
						$checked = "";

						if(!$compare && !$j && !$add_fisrt_option){

							$checked = "selected=\"selected\"";
							
						} else {
							if($compare === ($select_item->$field_value))
								$checked = "selected=\"selected\"";
						}

						$html .= '<option class="cate_option" data_parents="'.$select_item->list_parents.'" value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';

						$j ++;
					}

					// echo  $html;
					// die;
					

				} else {
					
					foreach ($arry_select as $key => $name) {
						$checked = "";
						if(!$compare && !$j && !$add_fisrt_option){
							$checked = "selected=\"selected\"";
						} else {
							if($compare == $key)
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}else{
			// not working
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select data-placeholder="'.$title.'" class="form-control " name="'.$name.'[]" id="'.$name.'" '.$html_sized.' multiple="multiple">';
          //  if($add_fisrt_option){
//				$html .= '<option>--'.$title.'--</option>';
//			}
			$array_value  = isset($value)?explode(',',$value):array();
			
//			$compare  = 0;
//			if(@$value)
//				$compare = $value;
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(in_array($select_item->$field_value,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option class="cate_option" data_name="'.$select_item->name.'" data_parents="'.$select_item->list_parents.'" value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						$checked = "";
						
						// if(in_array($name,$array_value))
						if(in_array($key,$array_value))	
							$checked = "selected=\"selected\"";
						$html .= '<option class="cate_option" data_name="'.$select_item->name.'" data_parents="'.$select_item->list_parents.'" value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}
		if($sub_item)
			$html .= $sub_item;
		if($comment)
			$html .= '<p class="help-block">'.$comment.'</p>';
		$html .= '</div></div>';
		echo $html;
	}
	/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */
	public static function dt_tab_title($title){
		echo "<div class='dt_tab_title'>".$title."</div>";
	}
	public static function dt_edit_text($title,$name,$value,$default = '',$size = 60,$rows = 1,$editor = 0,$comment='',$sub_item = '',$class_col1='col-md-2',$class_col2='col-md-10',$class_col_form=''){
		// echo "<pre>";

		// print_r($_SESSION);
		// die;
		global $db;
		$module =$_GET['module'];
		$view= $_GET['view'];
		if(!empty($_SESSION[$module][$view])){
			// echo "<pre>";
			// print_r($_SESSION[$module][$view]);
			// die;
			$data_ss = $_SESSION[$module][$view];
			
		}
		// die;

		if(!isset($value))
			$value = $default;
		$value = html_entity_decode(stripslashes($value),ENT_COMPAT,'UTF-8');
		$html = '';
		echo '<div class="form-group '.$class_col_form.'">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.' col-xs-12">
		';
		if($rows > 1){
			if(!$editor){
				if(!empty($data_ss[$name])){
					echo  '<textarea class="form-control" rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$data_ss[$name].'</textarea>';
				}else{
					echo  '<textarea class="form-control" rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
				}
			} else {
//				echo  '<textarea rows="10" cols="10" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
//				echo "<script>CKEDITOR.replace( '".$name."');</script>";
				$k = 'oFCKeditor_'.$name;
				$oFCKeditor[$k] = new FCKeditor($name) ;
				$oFCKeditor[$k]->BasePath	=  '../libraries/wysiwyg_editor/' ;
				if(!empty($data_ss[$name])){
					$oFCKeditor[$k]->Value		= preg_replace("/rnrn/","",stripslashes($data_ss[$name]));
				}else{
					$oFCKeditor[$k]->Value		= stripslashes(@$value);
				}

				$oFCKeditor[$k]->Width = $size;
				$oFCKeditor[$k]->Height = $rows;
				$oFCKeditor[$k]->Create() ;
			}
		}else{
			if($name == 'price' || $name=='price_old'|| $name=='discount' || $name=='import_price' || $name=='price_pack' || $name=='price_wholesale' || $name=='price_min'){
				if(!empty($data_ss[$name])){
					echo '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($data_ss[$name]).'" size="'.$size.'"/>';
				}else{
					if($value){
						echo'<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.format_money($value,'').'" size="'.$size.'"/>';
					}else{
						echo '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
					}
				}

			}else{
				if(!empty($data_ss[$name])){
					echo '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'. $data_ss[$name] .'" size="'.$size.'"/>'; 	
				}else{
					echo '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.  htmlspecialchars($value) .'" size="'.$size.'"/>';
				}

				
			}
			
		}
		if($sub_item)
			echo  $sub_item;
		if($comment)
			echo '<p class="help-block" id="help-block-'.$name.'" >'.$comment.'</p>';
		echo  '</div></div>';
        //echo $html;
	}

	public static function dt_edit_text_placeholder($title,$name,$value,$default = '',$size = 60,$rows = 1,$editor = 0,$comment='',$sub_item = '',$class_col1='col-md-2',$class_col2='col-md-10',$class_col_form='',$placeholder = 1){
		global $db;
		$module =$_GET['module'];
		$view= $_GET['view'];
		if(!empty($_SESSION[$module][$view])){
			$data_ss = $_SESSION[$module][$view];
		}

		if(!isset($value))
			$value = $default;
		$value = html_entity_decode(stripslashes($value),ENT_COMPAT,'UTF-8');
        $html = '';
		echo '<div class="form-group '.$class_col_form.'">
                <label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
                <div class="'.$class_col2.' col-xs-12">
                ';
		if($rows > 1){
			if(!$editor){
				if(!empty($data_ss[$name])){
					echo  '<textarea placeholder="'.$title.'" class="form-control" rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$data_ss[$name].'</textarea>';
				}else{
					echo  '<textarea placeholder="'.$title.'" class="form-control" rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
				}
			} else {
				$k = 'oFCKeditor_'.$name;
				$oFCKeditor[$k] = new FCKeditor($name) ;
				$oFCKeditor[$k]->BasePath	=  '../libraries/wysiwyg_editor/' ;
				if(!empty($data_ss[$name])){
					$oFCKeditor[$k]->Value		= preg_replace("/rnrn/","",stripslashes($data_ss[$name]));
				}else{
					$oFCKeditor[$k]->Value		= stripslashes(@$value);
				}

				$oFCKeditor[$k]->Width = $size;
				$oFCKeditor[$k]->Height = $rows;
				$oFCKeditor[$k]->Create() ;
			}
		}else{
			if($name == 'price' || $name=='price_old'|| $name=='discount'|| $name=='price2'){
				if(!empty($data_ss[$name])){
					echo '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($data_ss[$name]).'" size="'.$size.'"/>';
				}else{
					if($value){
					   echo'<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.format_money($value,'').'" size="'.$size.'"/>';
					}else{
						echo '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
					}
				}

			}else{
				if(!empty($data_ss[$name])){
					echo '<input placeholder="'.$title.'" type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'. $data_ss[$name] .'" size="'.$size.'"/>'; 	
				}else{
					echo '<input placeholder="'.$title.'" type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.  htmlspecialchars($value) .'" size="'.$size.'"/>';
				}
			}
			
		}
		if($sub_item)
			echo  $sub_item;
		if($comment)
			echo '<p class="help-block" id="help-block-'.$name.'" >'.$comment.'</p>';
		echo  '</div></div>';
        //echo $html;
	}
	
	

	static function dt_notedit_text($title,$name,$value,$default = '',$size = 60,$rows = 1,$editor = 0,$comment='',$sub_item = '',$class_col1='col-md-2',$class_col2='col-md-10'){
		if(!isset($value))
			$value = $default;
		$value = html_entity_decode(stripslashes($value),ENT_COMPAT,'UTF-8');
		$html = '';
		echo '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.' col-xs-12">
		';
		if($rows > 1){
			if(!$editor){
				echo  '<textarea class="form-control" rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
			} else {
//				echo  '<textarea rows="10" cols="10" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
//				echo "<script>CKEDITOR.replace( '".$name."');</script>";
				$k = 'oFCKeditor_'.$name;
				$oFCKeditor[$k] = new FCKeditor($name) ;
				$oFCKeditor[$k]->BasePath	=  '../libraries/wysiwyg_editor/' ;
				$oFCKeditor[$k]->Value		= stripslashes(@$value);
				$oFCKeditor[$k]->Width = $size;
				$oFCKeditor[$k]->Height = $rows;
				$oFCKeditor[$k]->Create() ;
			}
		}else{
			if($name == 'price' || $name=='price_old'|| $name=='discount'){
				if($value)
					echo'<input type="text" class="form-control" disabled name="'.$name.'" id="'.$name.'" value="'.format_money($value,'').'" size="'.$size.'"/>';
				else
					echo '<input type="text" class="form-control" disabled name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
			}else{
				echo '<input type="text" class="form-control" disabled readonly name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($value).'" size="'.$size.'"/>'; 	
			}
			
		}
		if($sub_item)
			echo  $sub_item;
		if($comment)
			echo '<p class="help-block">'.$comment.'</p>';
		echo  '</div></div>';
        //echo $html;
	}
	/*
	 * Tạo cột phụ cạnh cột chính
	 * Note: Ko có param Comments, editor
	 */
	static function sub_edit_text($title,$name,$value,$default = '',$size = 60,$rows = 1,$class_col1='col-md-2',$class_col2='col-md-10'){
		if(!isset($value))
			$value = $default;
		$html = '<span>'.$title.'</span>';
		if($rows > 1){
			$html .=  '<textarea rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
		}else{
			$html .=  '<input class="form-control" type="text" name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
		}
		return $html;
	}
	/*
	 * FOR DETAIL PAGE
	 */
	static function dt_text($title,$value,$default = '',$comment='',$use_htmlspecialchars = 1,$class_col1='col-md-2',$class_col2='col-md-10'){
		if(!isset($value))
			$value = $default;
		echo '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.' col-xs-12">';
		if($use_htmlspecialchars)
			echo htmlspecialchars($value);
		else 
			echo $value;
		
		if($comment)
			echo '<p class="help-block">'.$comment.'</p>';
		echo  '</div></div>';
	}
/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */

static function dt_image($title,$name,$value,$width  = 0,$height = 0,$comment='',$class_col1='col-md-2',$class_col2='col-md-10'){
	$html = '<div class="form-group">
	<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
	<div class="'.$class_col2.' col-xs-12">';
	
	if($value){
		$html_w = $width?' width="'.$width.'" ':'';
		$html_h = $height?' height="'.$height.'" ':'';
		$html .= '<img src="'.$value.'" '.$html_w.' '.$html_h.' /><br/>';
	}
	if($comment)
		$html .= '<p class="help-block">'.$comment.'</p>';
	$html .= '</div></div>';
	echo $html;
}
static function dt_sepa(){
	echo  '<div class="col-xs-12"><div colspan="2"><hr class="sepa"/></div></div>';
}


static function dt_edit_image($title,$name,$value,$width  = 0,$height = 0,$comment='',$class_col1='col-md-2',$class_col2='col-md-10'){


	$module =$_GET['module'];
	$view= $_GET['view'];
	if(!empty($_SESSION[$module][$view])){
		$data_ss = $_SESSION[$module][$view];
	}

	$error_img = "this.src='/images/no-image.png'";

	$module = FSInput::get('module');
	$view = FSInput::get('view');
	$id = FSInput::get('id');
	$html = '<div class="form-group">
	<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
	<div class="'.$class_col2.' col-xs-12">';
	if($value){
		$html_w = $width?' width="'.$width.'" ':'';
		$html_h = $height?' height="'.$height.'" ':'';
		$html .= '<div class="image-area-single" id = "sort_'.$name.'">';
		$html .= '<p><img class="img-responsive" onerror="'.$error_img.'" src="'.$value.'" '.$html_w.' '.$html_h.' /></p>';
		$html .= '<p class="del"><span onclick="remove_image(\''.$module.'\',\''.$view.'\',\''.$id.'\',\''.$name.'\',\'sort_'.$name.'\')"><img src="'.URL_ROOT.'libraries/uploadify/delete.png"></span></p>';
		$html .= '</div>';
	}
	$html .= '<div class="fileUpload btn btn-primary ">
	
	<input type="file" class="" name="'.$name.'" id="'.$name.'" />
	</div>';
	if($comment)
		$html .= '<p class="help-block">'.$comment.'</p>';
	$html .= '</div></div>';
	echo $html;
}

static function dt_edit_image_old($title,$name,$value,$width  = 0,$height = 0,$comment='',$class_col1='col-md-2',$class_col2='col-md-10'){


	$module =$_GET['module'];
	$view= $_GET['view'];
	if(!empty($_SESSION[$module][$view])){
		// echo "<pre>";
		// print_r($_SESSION[$module][$view]);
		// die;
		$data_ss = $_SESSION[$module][$view];
		
	}


	// if(!empty($data_ss[$name])){
	// 	$value = URL_ROOT.$data_ss[$name];
	// }




	$error_img = "this.src='/images/no-image.png'";

	$module = FSInput::get('module');
	$view = FSInput::get('view');
	$id = FSInput::get('id');
	$html = '<div class="form-group">
	<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
	<div class="'.$class_col2.' col-xs-12">';
	if($value){
	// 	echo $value;
	// die;
		$html_w = $width?' width="'.$width.'" ':'';
		$html_h = $height?' height="'.$height.'" ':'';
		$html .= '<div class="image-area-single" id = "sort_'.$name.'">';
		$html .= '<p><img class="img-responsive" onerror="'.$error_img.'" src="'.$value.'" '.$html_w.' '.$html_h.' /></p>';
		$html .= '<p class="del"><span onclick="remove_image(\''.$module.'\',\''.$view.'\',\''.$id.'\',\''.$name.'\',\'sort_'.$name.'\')"><img src="libraries/uploadify/delete.png"></span></p>';
		$html .= '</div>';
	}
	$html .= '<div class="fileUpload btn btn-primary ">
	<span><i class="fa fa-cloud-upload"></i> Upload</span>
	<input type="file" class="upload" name="'.$name.'" id="'.$name.'" />
	</div>';
	if($comment)
		$html .= '<p class="help-block">'.$comment.'</p>';
	$html .= '</div></div>';
	echo $html;
}

	/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */
	static function dt_edit_image2($title,$name,$value,$width  = 0,$height = 0,$comment='',$use_dropzone = 0,$list_other_images = array(),$class_col1='col-md-2',$class_col2='col-md-10'){
		if(!$use_dropzone){
			$html = '<tr><td valign="top" class="key" valign="top">'.$title.'</td><td class="value">';
			if($value){
				$html_w = $width?' width="'.$width.'" ':'';
				$html_h = $height?' height="'.$height.'" ':'';
				$html .= '<img src="'.$value.'" '.$html_w.' '.$html_h.' /><br/>';
			}
			$html .= '<input type="file" name="'.$name.'" id="'.$name.'"  />';
			if($comment)
				$html .= '<p class="help-block">'.$comment.'</p>';
			$html .= '</td></tr>';
		}else{
			$id = FSInput::get('id');
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($id)
				$uploadConfig = base64_encode('edit|'.$id);		
			else
				$uploadConfig = base64_encode('add|'.session_id());

			$list_other_images = TemplateHelper::get_other_images($module ,$uploadConfig);
			$colors = TemplateHelper::get_colors($id);

			$arr_sku_map = array(); 
			$i= 1;
			foreach ($list_other_images as $item) {
				$arr_sku_map['Data'][$i]['AttachmentID']=$item->id;
				$arr_sku_map['Data'][$i]['FileName']=$item->title;
				$arr_sku_map['Data'][$i]['Path'] = URL_ROOT.str_replace('/original/','/original/', $item->image) ;
				$arr_sku_map['Data'][$i]['ColorId'] = $item->color_id;
				$i++;
			}
			if(!count($arr_sku_map)){
				$arr_sku_map['Data'][0]['AttachmentID']= 0;
				$arr_sku_map['Data'][0]['FileName']= '0';
				$arr_sku_map['Data'][0]['Path'] =  '0';
				$arr_sku_map['Data'][0]['ColorId'] = '0';
			}
			$skuConfig  = json_encode($arr_sku_map);
			$html = '
			<link type="text/css" rel="stylesheet" media="all" href="'. URL_ROOT.'libraries/jquery/dropzone/dist/min/dropzone.min.css" />
			<link type="text/css" rel="stylesheet" media="all" href="libraries/dropzone/dropzone.css" />

			<script type="text/javascript" src="'. URL_ROOT.'libraries/jquery/dropzone/dist/min/dropzone.min.js"></script>

			<script>
			$(document).ready(function() {
				var data ='.$skuConfig.';
				var previewNode = document.querySelector("#template");
				var uploadConfig =  $("#uploadConfig").val();
				previewNode.id = "";
				var previewTemplate = previewNode.parentNode.innerHTML;
				previewNode.parentNode.removeChild(previewNode);
				var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
					url: "index2.php?module='.$module.'&view='. $view.'&raw=1&task=upload_other_images&data="+uploadConfig,
					thumbnailWidth: 100,
					thumbnailHeight: 100,
					parallelUploads: 20,
					previewTemplate: previewTemplate,
					autoQueue: true, 
					previewsContainer: "#previews", 
					clickable: ".fileinput-button", 
					removedfile: function(file) {
						console.log(file);
						var reocord_id = $("#id_mage").val();
						$.ajax({
							type: "POST",
							url: "index2.php?module='.$module.'&view='.$view.'&raw=1&task=delete_other_image",
							data: { "name": file.name,"reocord_id":reocord_id,"id":file.size}
							});
							var _ref;
							return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
							},
							success: function(file, response){
                    //alert(response);
								file.previewElement.id = "sort_"+response;
								},  
								init: function () {
									var thisDropzone = this;  
									if (data.Data != "") {
										$.each(data.Data, function (index, item) {
											var mockFile = {
												name: item.FileName,
												title: item.title,
												size: item.AttachmentID
											};
											thisDropzone.emit("addedfile", mockFile);
											thisDropzone.emit("thumbnail", mockFile, item.Path);
											
                                //On the created element added the id property 
											$(mockFile.previewElement).prop("id", "sort_"+item.AttachmentID);
											$(mockFile.previewTemplate).find(".title_dropzon").val(item.FileName);
											
     							//$(mockFile.previewTemplate).find(".dz-color").val(item.ColorId);
     							//select_index = $("#sort_"+item.AttachmentID+" .dz-color option:selected").index();

     							//color_code = $("#sort_"+item.AttachmentID+" .dz-color")[0].options[select_index].style.backgroundColor;
     							//console.log($("#sort_"+item.AttachmentID+" .dz-color"));
     							//$("#sort_"+item.AttachmentID+" .dz-color").css("background-color", color_code);

											});
										}
									}
									});

									$(function() {
										$("#previews").sortable({
											update : function () {
												serial = $("#previews").sortable("serialize");
												$.ajax({
													url: "index2.php?module='.$module.'&view='.$view.'&raw=1&task=sort_other_images",
													type: "post",
													data: serial,
													error: function(){
														alert("Lỗi load dữ liệu");
													}
													});

												}
												});
												
												});

												});
				//function change_color(element){
				//	value = $(element).val();
				//	parent_id =  $(element).parent().attr("id");
				//	id =  parent_id.replace("sort_", "");
				//	var uploadConfig =  $("#uploadConfig").val();
				//	 $.ajax({
				//        type: "POST",
				//        url: "index2.php?module='.$module.'&view='.$view.'&raw=1&task=change_attr_image",
				//        data: { "field": "color","data":uploadConfig,"id":id,"value":value}
				//    });
				//	 element.style.backgroundColor=element.options[element.selectedIndex].style.backgroundColor;
				//}
												
												function change_tile(element){
													value = $(element).val();
													parent_id =  $(element).parent().attr("id");
													id =  parent_id.replace("sort_", "");
													var uploadConfig =  $("#uploadConfig").val();
													$.ajax({
														type: "POST",
														url: "index2.php?module='.$module.'&view='.$view.'&raw=1&task=change_title_attr_image",
														data: {"data":uploadConfig,"id":id,"value":value}
														});
													}
													</script>
													';
													$html .= '<div class="dropzone files" id="previews">';
													$html .= '<div  id="template" class="dz-preview dz-image-preview">';
													$html .= '<div class="dz-details">';
													$html .= '<img data-dz-thumbnail />';
													$html .= '</div>';
													$html .= '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>';
													$html .= '<a class="dz-remove"  data-dz-remove id="">Remove</a>';
													$html .= '<input type="text" onchange="javascript: change_tile(this);" class="form-control title_dropzon" placeholder="Title" style="width:100px;border-radius: 0px;margin-top: 2px;">';                    
				  	//$html .= '<select class="dz-color" onchange="javascript: change_color(this);">';
				  	//$html .= '<option value="0"  style="">Chọn màu</option>';
				  	//if(@$colors ){
					//	foreach($colors as $item){
					//		$html .= '<option value="'.$item -> id.'"  style="background-color: #'.$item -> color_code.'">'. $item -> color_name.'</option>';
					//	}
					//}
					//$html .= '</select>';
													$html .= '</div>';
													
													$html .= '</div>';
													$html .= '<input type="hidden" value="'.$uploadConfig.'" id="uploadConfig" />';
													$html .= '<input type="hidden" value="'.$id.'" id="id_mage" />';
													$html .= '<span class="post_images fileinput-button">Thêm ảnh/video</span>';

												}
												echo $html;
											}
											static function  get_other_images($module = '',$uploadConfig=''){
												$data = base64_decode($uploadConfig);
												$data = explode('|', $data);
												$where ='';
												if($data[0] == 'add')
													$where = 'session_id = \''.$data[1].'\'';
												else
													$where = 'record_id = '.$data[1];

												global $db;
												$query = '  SELECT *
												FROM '.'fs_'.$module.'_images'.' 
												WHERE '.$where.'
												ORDER BY ordering, id DESC';
												$sql = $db->query($query);
												return $db->getObjectList();
											}
											static function  get_colors($rid){
												if(!$rid)
													return;
												$where ='AND record_id = '.$rid;
												global $db;
												$query = '  SELECT *
												FROM fs_products_price
												WHERE 1 = 1 '.$where.' ';
												$sql = $db->query($query);
												return $db->getObjectList();
											}
	/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */
		public static function dt_edit_file($title,$name,$value,$drive_excel,$comment='',$class_col1='col-md-2',$class_col2='col-md-10'){
		$html = '<div class="form-group">
			<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
			<div class="'.$class_col2.'  col-xs-12">';
			
			
			
			if($value){
			    
				if(!file_exists(PATH_BASE.$value)){
				    
				 //   check drive google excel
				
				     $url = 'https://drive.'.DOMAIN.'/get.php??mime=excel&showfile='.$drive_excel;
			   
			    
	    		    if (!empty($drive_excel)) {
	    		        
	                  $html .= '<a style="color: rgba(255, 153, 0, 0.79);" target="_blink" href="' . $url . '">'.$url.'</a><br/>';
	                  
	                } else {
	                  	$html .= '<a style="color: red;" target="_blink" href="javascript:void(0)">Lỗi file11</a><br/>';
	                }
	                
	                
	        
				}else{
					$html .= '<a style="color: rgba(255, 153, 0, 0.79);" href="'.URL_ROOT.$value.'">'.$value.'</a><br/>';
				}
				
			}
				
			$html .= '
			<div class="fileUpload btn btn-primary ">
			<span><i class="fa fa-cloud-upload"></i> Upload</span>
			<input type="file" id="'.$name.'" class="upload" name="'.$name.'"  />
			</div>';
			
			
			if($comment)
				$html .= '<p class="help-block">'.$comment.'</p>';
			$html .= '</div></div>';
			echo $html;
		}

	public static function dt_edit_file_multiple($title,$name,$value,$filePDFAr,$comment='Giữ CTRL để chọn nhiều File tải lên',$class_col1='col-md-2',$class_col2='col-md-10'){
		$html = '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.'  col-xs-12">';
		
		if($value){
			$arr_name = explode('t,t',$value);
			if(!empty($arr_name)){
				$i=0;
				foreach ($arr_name as $name_item) {
					$base_name = basename($name_item);
					if($i == 0){
						$path = str_replace($base_name,'',$name_item);
					}
					if(!file_exists(PATH_BASE.$path.$base_name)){
					    
					  	if(!empty($filePDFAr)){

					  		$filepdf = explode(',', $filePDFAr);

					  		foreach ($filepdf as $key => $val) {

					  			$url = 'https://drive.'.DOMAIN.'/get.php?mime=pdf&showfile='.$val;

					    		$html .= '<a target="_blank" style="color: rgba(255, 153, 0, 0.79);" href="'.$url.'">'.$base_name.'</a><br/>';
					  			
					  		}


					  	}
    				    else{
    				        
    				        $html .= '<a target="_blank" style="color: red;" href="javascript:void(0)">Lỗi File</a><br/>';
    				    }
					
					}else{
						$html .= '<a target="_blank" style="color: rgba(255, 153, 0, 0.79);" href="'.URL_ROOT.$path.$base_name.'">'.$base_name.'</a><br/>';
					}


					$i++;
				}
			}else{
				$html .= '<a style="color: rgba(255, 153, 0, 0.79);" href="'.URL_ROOT.$value.'">'.$value.'</a><br/>';
			}
			
		}
		$html .= '
		<div class="fileUpload btn btn-primary ">
		<span><i class="fa fa-cloud-upload"></i> Upload</span>
		<input type="file" id="'.$name.'" class="upload" name="'.$name.'[]" multiple />
		</div>';
		if($comment)
			$html .= '<p class="help-block">'.$comment.'</p>';
		$html .= '</div></div>';
		echo $html;
	}
	public static function dt_edit_video($title,$name,$value,$comment='',$width  = 0,$height = 0,$class_col1='col-md-2',$class_col2='col-md-10'){
		$error_img = "this.src='/images/no-image.png'";
		$module = FSInput::get('module');
		$view = FSInput::get('view');
		$id = FSInput::get('id');
		$html = '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.'  col-xs-12">';
		
		if($value){
			$html_w = $width?' width="'.$width.'" ':'';
			$html_h = $height?' height="'.$height.'" ':'';
			$html .= '<div class="image-area-single" id = "sort_'.$name.'">';
			$html .= '<p><video "'.$html_w.'" "'.$html_h.'" controls>
			<source src="'.$value.'" type="video/mp4">

			Your browser does not support the video tag.
			</video>
			</p>';
			$html .= '<p class="del"><span onclick="remove_image(\''.$module.'\',\''.$view.'\',\''.$id.'\',\''.$name.'\',\'sort_'.$name.'\')"><img src="libraries/uploadify/delete.png"></span></p>';
			$html .= '</div>';
		}
		$html .= '<div class="fileUpload btn btn-primary ">
		<span><i class="fa fa-cloud-upload"></i> Upload</span>
		<input type="file" class="upload" name="'.$name.'" id="'.$name.'" />
		</div>';
		if($comment)
			$html .= '<p class="help-block">'.$comment.'</p>';
		$html .= '</div></div>';
		echo $html;
	}
	/*
	 * FOR DETAIL PAGE
	 * tag: radio
	 * in case editor: width => size, height => rows
	 */
	public static function dt_checkbox($title,$name,$value,$default = 1,$array_value = array(1 => 'Có', 0 => 'Không' ),$sub_item = '',$comment ='',$class_col1='col-md-2',$class_col2='col-md-10',$creator_id=0){
		if(!$array_value){
			$array_value = array(1 => 'Có', 0 => 'Không' );
		}

		global $db;
		$module =$_GET['module'];
		$view= $_GET['view'];
		if(!empty($_SESSION[$module][$view])){
			// echo "<pre>";
			// print_r($_SESSION[$module][$view]);
			// die;
			$data_ss = $_SESSION[$module][$view];
			
		}
		
		$module = FSInput::get('module');
		$view =  FSInput::get('view',$module);

		if($name =='published' ){
			if($module == 'products' && $view == 'products' || $module == 'news' && $view == 'news'){
				$permission = FSSecurity::check_permission($module, $view, 'published');
				$permission_orther = FSSecurity::check_permission_other($module, $view, 'published');
				if($permission && $permission_orther){
					
				}

				if($permission && !$permission_orther){
					if($creator_id ==  $_SESSION['ad_userid']){
						
					}else{
						return;
					}
				}

				if(!$permission && !$permission_orther){
					return;
				}
			}else{
				$permission = FSSecurity::check_permission($module, $view, 'published');
				if (!$permission){
					return;
				}
			}
		}





		$html = '<div class="form-group">
		<label class="'.$class_col1.' col-xs-12 control-label">'.$title.'</label>
		<div class="'.$class_col2.' col-xs-12">
		';

		if(!empty($data_ss[$name])){
			$compare = $data_ss[$name];
		}elseif(!empty($data_ss) AND empty($data_ss[$name])){
			$compare = 0;
		}else{
			$compare = isset($value)?$value:$default;
		}
		
		
		foreach($array_value as $key => $item){
		    //$html .= '<label class="radio-inline control control--radio">';  
			if($compare == $key){
				$html .= ' <input class="radio-custom" type="radio" name="'.$name.'" value="'.$key.'" checked="checked" id="'.$name.'_'.$key.'" />
				<label for="'.$name.'_'.$key.'" class="radio-custom-label">'.$item.'&nbsp;&nbsp;</label>
				';
			}else{
				$html .= '<input class="radio-custom" type="radio" name="'.$name.'" value="'.$key.'" id="'.$name.'_'.$key.'"  />
				<label for="'.$name.'_'.$key.'" class="radio-custom-label">'.$item.'&nbsp;&nbsp;</label>
				';
			}
            //$html .= '</label>';  
		}
		
		if($sub_item)
			$html .= $sub_item;
		if($comment)
			$html .= '<p class="help-block">'.$comment.'</p>';	
		$html .= '</div></div>';
		echo $html;
	}
/*
	 * Genarate filter
	 * News solution
	 */
public static function create_filter($row,$prefix){
	if(!count($row))
		return;
	$ss_keysearch  = isset($_SESSION[$prefix.'keysearch']) ? $_SESSION[$prefix.'keysearch']:'';
	if(isset($row['search_multipe'])){
		$arr_ss_keysearch = explode(',',$ss_keysearch);
		if($arr_ss_keysearch){
			$arr_ss_keysearch = array_unique($arr_ss_keysearch);
			$ss_keysearch ='';
			foreach ($arr_ss_keysearch as $item) {
				if($item){
					$ss_keysearch .= $item.',';
				}
				
			}
		}
	}
	$class='';
	$html = '';
	$html .= '<div  class="filter_area">';
	$html .= '	<div class="row">';
		//$html .= '		<tr>';
	
	$html_text = '';
	if(isset($row['text_count'])){ 
		$count = $row['text_count'];
		for($i = 0; $i < $count; $i ++) {
			$text_item = $row['text'][$i];
			
			$ss_text   = isset($_SESSION[$prefix.'text'.$i]) ? $_SESSION[$prefix.'text'.$i]:'';
			$type = isset($text_item['type'])?$text_item['type']:'';
			$html_text .= '			<div class="fl-left pd-15" >';
				//$html_text .= 	$text_item['title'];
			$html_text .= 	'<input type="text" placeholder="'.$text_item['title'].'" class="form-control" autocomplete="off" name="text'.$i.'" id="text'.$i.'" value="'.$ss_text.'"  />';
			
			$html_text .= '			</div>';
		}
		$html .= '			<input type="hidden" name="text_count" value="'.$count.'" />';
	}

	if(isset($row['search_multipe'])){
		$html .= '<div class="fl-left pd-15" >';
			//$html .= 				FSText :: _( 'Search' ).':';
		$html .= '	
		<input type="text" placeholder="'.FSText :: _( 'Search').'" name="keysearch" id="search_multipe" value="" class="form-control fl-left"  />
		<span class="input-group-btn fl-left" style="margin-left: -2px;">
		<button onclick="this.form.submit();" class="btn btn-search btn-default hide" type="button">
		<i class="fa fa-search"></i>
		</button>
		</span>
		';
			$html .= '<div id="val_search_multipe">Đang tìm: <span>'.$ss_keysearch.'</span></div>';
		$html .= '</div>';

		

		$html .= $html_text;
		$html .= '<div class="fl-left">';
		$html .= '				<button class="btn btn-outline btn-primary" onclick="this.form.submit();">'.FSText :: _( 'Search' ) . '</button>';

		$html .= '				<button class="btn btn-outline btn-primary btn-reset-form" onclick="document.getElementById(\'search\').value=\'\';';
		
		if(isset($row['text_count'])){ 
			$count = $row['text_count'];
			for($i = 0; $i < $count; $i ++) {
				$html .= '				document.getElementById(\'text'.$i.'\').value=\'\'; ';
			}
		}
		$html .= '				this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">'.FSText :: _( 'Reset' ).'</button>';
		$html .= '			</div>';
	}
	
	if((@$row['search'])){
		$html .= '			<div class="fl-left pd-15" >';
			//$html .= 				FSText :: _( 'Search' ).':';
		$html .= '	
		<input type="text" placeholder="'.FSText :: _( 'Search').'" name="keysearch" id="search" value="'.$ss_keysearch.'" class="form-control fl-left"  />
		<span class="input-group-btn fl-left" style="margin-left: -2px;">
		<button onclick="this.form.submit();" class="btn btn-search btn-default" type="button">
		<i class="fa fa-search"></i>
		</button>
		</span>
		
		';
		
		$html .= '</div>';
		$html .= $html_text;
		$html .= '<div class="fl-left">';
		$html .= '				<button class="btn btn-outline btn-primary" onclick="this.form.submit();">'.FSText :: _( 'Search' ) . '</button>';
		$html .= '				<button class="btn btn-outline btn-primary" onclick="document.getElementById(\'search\').value=\'\';';
		if(isset($row['text_count'])){ 
			$count = $row['text_count'];
			for($i = 0; $i < $count; $i ++) {
				$html .= '				document.getElementById(\'text'.$i.'\').value=\'\'; ';
			}
		}
		$html .= '				this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">'.FSText :: _( 'Reset' ).'</button>';
		$html .= '			</div>';
	}
	if(isset($row['filter_count'])){ 
		$count = $row['filter_count'];
		$html .= '			<input type="hidden" name="filter_count" value="'.$count.'" />';
		for($i = 0; $i < $count; $i ++) {
			$filter_item = $row['filter'][$i];
			$ss_filter   = isset($_SESSION[$prefix.'filter'.$i]) ? $_SESSION[$prefix.'filter'.$i]:'';
			$type = isset($filter_item['type'])?$filter_item['type']:'';
			if($type == 'yesno'){
				$field = isset($filter_item['field'])?$filter_item['field']:'name';
				$html .= '			<div class="fl-left pd-15">';
				$html .= '				<select name="filter'.$i.'" class="form-control '.$class.'" onChange="this.form.submit()">';
				$html .= '					<option value="2"> -- '.$filter_item['title'].' -- </option>';
				
				
				$selected_no = $ss_filter === 0? "selected='selected'":"";
				$selected_yes = $ss_filter === 1? "selected='selected'":"";
				$html .= "<option value='1'  ".$selected_yes."> ". FSText::_('Yes') . "</option>";
				$html .= "<option value='0'  ".$selected_no."> ". FSText::_('No') . "</option>";
				
				$html .= '				</select>';
				$html .= '			</div>';
				continue;
			}
			
			$field = isset($filter_item['field'])?$filter_item['field']:'name';
			$html .= '			<div class="fl-left pd-15">';
			$html .= '				<select name="filter'.$i.'" class="form-control '.$class.'"  onChange="this.form.submit()">';
			$html .= '					<option value="0"> -- '.$filter_item['title'].' -- </option>';
			if(isset($filter_item['list']))		
				if($filter_item['list'])							
					foreach($filter_item['list'] as $key=>$item){
						if(is_object($item)){
							if($item->id == $ss_filter){
								$html .= "<option value='" . $item->id . "'  selected='selected'> ". $item->$field . "</option>";
							}
							else{
								$html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
							}
						} else {
							if($key == $ss_filter){
								$html .= "<option value='" .$key . "'  selected='selected'> ". $item . "</option>";
							}
							else{
								$html .= "<option value='" . $key . "'>" .  $item . "</option>";
							}
						}
					}
					$html .= '				</select>';
					$html .= '			</div>';
				}	
			}
			$html .= '		</div>';
			$html .= '	</row>';
			$html .= '</div>';
			return $html;
		}

		/*
	 * Genarate filter
	 * News solution
	 */
public static function create_filter_2($row,$prefix){
	if(!count($row))
		return;
	$ss_keysearch  = isset($_SESSION[$prefix.'keysearch']) ? $_SESSION[$prefix.'keysearch']:'';
	
	$class='';
	$html = '';
	$html .= '<div  class="filter_area">';
	$html .= '	<div class="row">';
		//$html .= '		<tr>';
	
	$html_text = '';
	if(isset($row['text_count'])){ 
		$count = $row['text_count'];
		for($i = 0; $i < $count; $i ++) {
			$text_item = $row['text'][$i];
			$ss_text   = isset($_SESSION[$prefix.'text'.$i]) ? $_SESSION[$prefix.'text'.$i]:'';
			$type = isset($text_item['type'])?$text_item['type']:'';
			$html_text .= '			<div class="fl-left pd-15" >';
				//$html_text .= 	$text_item['title'];
			$html_text .= 	'<input type="text" placeholder="'.$text_item['title'].'" class="form-control" autocomplete="off" name="text'.$i.'" id="text'.$i.'" value="'.$ss_text.'"  />';
			
			$html_text .= '			</div>';
		}
		$html .= '			<input type="hidden" name="text_count" value="'.$count.'" />';
	}
	
	if(isset($row['search'])){
		$html .= '			<div class="fl-left pd-15" >';
			//$html .= 				FSText :: _( 'Search' ).':';
		$html .= '	
		<input type="text" placeholder="'.FSText :: _( 'Search').'" name="keysearch" id="search" value="'.$ss_keysearch.'" class="form-control fl-left"  />
		<span class="input-group-btn fl-left" style="margin-left: -2px;">
		<button onclick="this.form.submit();" class="btn btn-search btn-default" type="button">
		<i class="fa fa-search"></i>
		</button>
		</span>';
		
		$html .= '</div>';
		$html .= $html_text;

	}
	if(isset($row['filter_count'])){ 
		$count = $row['filter_count'];
		$html .= '			<input type="hidden" name="filter_count" value="'.$count.'" />';
		for($i = 0; $i < $count; $i ++) {
			$filter_item = $row['filter'][$i];
			$ss_filter   = isset($_SESSION[$prefix.'filter'.$i]) ? $_SESSION[$prefix.'filter'.$i]:'';
			$type = isset($filter_item['type'])?$filter_item['type']:'';
			if($type == 'yesno'){
				$field = isset($filter_item['field'])?$filter_item['field']:'name';
				$html .= '			<div class="fl-left pd-15">';
				$html .= '				<select name="filter'.$i.'" id="filter'.$i.'" class="form-control '.$class.'">';
				$html .= '					<option value="2"> -- '.$filter_item['title'].' -- </option>';
				
				$selected_no = $ss_filter === 0? "selected='selected'":"";
				$selected_yes = $ss_filter === 1? "selected='selected'":"";
				$html .= "<option value='1'  ".$selected_yes."> ". FSText::_('Yes') . "</option>";
				$html .= "<option value='0'  ".$selected_no."> ". FSText::_('No') . "</option>";
				
				$html .= '				</select>';
				$html .= '			</div>';
				continue;
			}
			
			$field = isset($filter_item['field'])?$filter_item['field']:'name';
			$html .= '			<div class="fl-left pd-15">';
			$html .= '				<select name="filter'.$i.'" id="filter'.$i.'" class="form-control '.$class.'">';
			$html .= '					<option value="0"> -- '.$filter_item['title'].' -- </option>';
			if(isset($filter_item['list']))		
				if($filter_item['list'])							
					foreach($filter_item['list'] as $key=>$item){
						if(is_object($item)){
							if($item->id == $ss_filter){
								$html .= "<option value='" . $item->id . "'  selected='selected'> ". $item->$field . "</option>";
							}
							else{
								$html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
							}
						} else {
							if($key == $ss_filter){
								$html .= "<option value='" .$key . "'  selected='selected'> ". $item . "</option>";
							}
							else{
								$html .= "<option value='" . $key . "'>" .  $item . "</option>";
							}
						}
					}
					$html .= '				</select>';
					$html .= '			</div>';
				}	
			}
					$html .= '<div class="fl-left">';
		$html .= '				<button class="btn btn-outline btn-primary" onclick="this.form.submit();">'.FSText :: _( 'Search' ) . '</button>';
		$html .= '				<button class="btn btn-outline btn-primary" onclick="document.getElementById(\'search\').value=\'\';';
		if(isset($row['text_count'])){ 
			$count = $row['text_count'];
			for($i = 0; $i < $count; $i ++) {
				$html .= '				document.getElementById(\'text'.$i.'\').value=\'\'; ';
			}
		}
		$html .= '				this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">'.FSText :: _( 'Reset' ).'</button>';
		$html .= '			</div>';
			$html .= '		</div>';
			$html .= '	</row>';
			$html .= '</div>';
			return $html;
		}
		
	}
	?>
