<?php global $tmpl;

$tmpl -> addStylesheet('products_filter_no_cal_dropdown_new_mobile','blocks/products_filter/assets/css');
$tmpl -> addScript('products_filter_no_cal_dropdown_new','blocks/products_filter/assets/js');
$html_filter = '';
$html_filter2 = '';
$html_current= '';
if($cat){
	$tablename = $cat -> tablename;
	$link_dell = FSRoute::_('index.php?module=products&view=cat&cid='.$cat->id.'&ccode='.$cat->alias);
}else{
	$tablename = 'fs_products';
	$link_dell = FSRoute::_('index.php?module=products&view=home');
}
?>


<?php 

$filter_manu = FSInput::get('filter');
$filter_man = explode(",", $filter_manu);
//print_r($filter_man);

$arr_filter_by_field_manufactory = $arr_filter_by_field['manufactory'];
$filter_m = 0;

foreach ($arr_filter_by_field_manufactory as $field_manufac) {
	foreach ($filter_man as $filter_ma) {

		if($field_manufac -> alias == $filter_ma) {
			$filter_m = 1;
			$filter_active = $field_manufac -> filter_value;
			$manufactory_act = $model->get_record('id='.$filter_active,'fs_manufactories');
		}	
	}
}
if (@$manufactory_act-> parent_id > 0) {
	$manufactory_active = $model->get_record('id='.$manufactory_act-> parent_id,'fs_manufactories');
}
else if (@$manufactory_act-> parent_id == 0) {
	$manufactory_active = @$manufactory_act;
}
$parent_manu = array();
foreach ($arr_filter_by_field_manufactory as $field_manufactory) {
	$manufac = $model->get_record_by_id($field_manufactory->filter_value,'fs_manufactories');
	$parent_manu[$manufac -> id] = $manufac -> parent_id;
}

$i = 0;
$j = 0;
foreach ($arr_filter_by_field_manufactory as $filter) {
	$i  = $i + 1;
	$model = new Products_filterBModelsProducts_filter();
	$manufactory = $model->get_record_by_id($filter->filter_value,'fs_manufactories','image');
	$manufactory_name = $model->get_record_by_id($filter->filter_value,'fs_manufactories','name');
	$img = URL_ROOT.str_replace('original','resized', $manufactory->image);
	$str_filter_id = $filter_request ? $filter -> alias:$filter -> alias;
	$link = FSRoute::addParameters('filter',$str_filter_id);

	if(!IS_MOBILE){
		if ($parent_manu[$filter-> filter_value] == 0) {
			if($i < 15){
				if(@$manufactory_act -> id == $filter-> filter_value) {
					$html_filter .= '<a class="active" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';	
				}
				else {
					$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';
				}

			//$html_filter .= '<a class="hidden" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span>"></a>';
			}elseif($i == 15){
				$html_filter .= '<a href="javascript:void(0);" class="morecate">Xem thêm</a>';
			}else{
			//$html_filter .= '<a class="hidden" href="'.$link.'" title="'.$filter ->filter_show.'" ><img src="'.$img.'"></a>';
				$html_filter .= '<a class="hidden limit" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name -> name.'</span></a>';
				if ($i == count($arr_filter_by_field_manufactory)) {
					$html_filter .= '<a href="javascript:void(0);" class="fewcate hidden">Ẩn bớt</a>';
				}
			}
		}
	}else{
		$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';
		//$html_filter .= '<a class="hidden" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span>"></a>';
	}
}

if ($filter_m == 1) {
	foreach ($arr_filter_by_field_manufactory as $filter) {
		$model = new Products_filterBModelsProducts_filter();
		$manufactory = $model->get_record_by_id($filter->filter_value,'fs_manufactories','image');
		$manufactory_name = $model->get_record_by_id($filter->filter_value,'fs_manufactories','name');

		//print_r($manufactory_active);
		$img = URL_ROOT.str_replace('original','resized', $manufactory->image);
		$str_filter_id = $filter_request ? $filter -> alias:$filter -> alias;
		$link = FSRoute::addParameters('filter',$str_filter_id);

		if(!IS_MOBILE){
			if ($parent_manu[$filter-> filter_value] == $manufactory_active -> id) {
				$j = $j + 1;
				if($j < 15){
					if($manufactory_act -> id == $filter-> filter_value) {
						$html_filter2 .= '<a class="active" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';	
					}
					else {
						$html_filter2 .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';
					}
				}elseif($j == 15){
					$html_filter2 .= '<a href="javascript:void(0);" class="morecate">Xem thêm</a>';
				}else{
			//$html_filter .= '<a class="hidden" href="'.$link.'" title="'.$filter ->filter_show.'" ><img src="'.$img.'"></a>';
					$html_filter2 .= '<a class="hidden limit" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name -> name.'</span></a>';
					if ($i == count($arr_filter_by_field_manufactory)) {
						$html_filter .= '<a href="javascript:void(0);" class="fewcate hidden">Ẩn bớt</a>';
					}
				}
			}
		}else{
			$html_filter2 .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';
		//$html_filter .= '<a class="hidden" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span>"></a>';
		}
	}
}


?>

<?php if(!IS_MOBILE){ ?>
	<div class="filter-manufactory">
		<div class="title_filter"><span>Thương hiệu</span></div>
		<?php echo $html_filter; ?>
	</div>
	<?php if($filter_m == 1 && $html_filter2){ ?>
		<div class="filter-manufactory">
			<div class="title_filter"><span>Thương hiệu <strong><?php echo $manufactory_active-> name; ?></strong></span></div>
			<?php echo $html_filter2; ?>
		</div>
	<?php } ?>
<?php }else{ ?>
	<div class="filter-manufactory">
		<div class="title_filter"><span>Thương hiệu</span></div>
		<div class="filter-manufactory-scroll">
			<?php echo $html_filter; ?>
		</div>
	</div>

<?php } ?>

<div class="clear"></div>

