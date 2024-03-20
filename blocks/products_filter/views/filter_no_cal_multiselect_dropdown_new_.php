<?php global $tmpl;

$tmpl -> addStylesheet('products_filter_no_cal_dropdown_new','blocks/products_filter/assets/css');
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
$arr_filter_by_field_manufactory = @$arr_filter_by_field['manufactory'];
$filter_m = 0;
if(empty($arr_filter_by_field_manufactory)){
	return false;
}
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
}else if (@$manufactory_act-> parent_id == 0) {
	$manufactory_active = @$manufactory_act;
}

$parent_manu = array();
foreach ($arr_filter_by_field_manufactory as $field_manufactory) {
	$manufac = $model->get_record_by_id($field_manufactory->filter_value,'fs_manufactories');
	$parent_manu[$manufac -> id] = $manufac -> parent_id;
}

$i = 0;
$j = 0;

// printr($arr_filter_by_field_manufactory);

//sắp xếp lại số thứ tự
if($cat->manufactory_related && !empty($cat->manufactory_related) && $cat->manufactory_related !=''){
	$arr_sort_manu = explode(',', $cat->manufactory_related);
	$manf_by_cat_sort = array();
	$s=0;
	foreach ($arr_sort_manu as $it_sort_manu) {
		// echo $it_sort_manu;

		foreach ($arr_filter_by_field_manufactory as $manu_sort ) {
			// echo  $manu_sort->id;
			// die;
			if($it_sort_manu == $manu_sort->filter_value){
				$manf_by_cat_sort [$s] = $manu_sort;
				$s++;

			}
		}
	}
	$arr_filter_by_field_manufactory = $manf_by_cat_sort;
}


// printr($arr_filter_by_field_manufactory);


foreach ($arr_filter_by_field_manufactory as $filter) {


	if($cat->manufactory_related && !empty($cat->manufactory_related) && $cat->manufactory_related != ''){
		$str_manufactory_related = ','.$cat->manufactory_related.',';
		$str_filter_value = ','.$filter->filter_value.',';
		$c_pos = strpos($str_manufactory_related,$str_filter_value);
		if ($c_pos === false) {
			continue;
		}
		
	}

	$model = new Products_filterBModelsProducts_filter();
	$manufactory = $model->get_record_by_id($filter->filter_value,'fs_manufactories','image,id');
	$manufactory_name = $model->get_record_by_id($filter->filter_value,'fs_manufactories','name');
	$img = URL_ROOT.str_replace('original','resized', $manufactory->image);
	$str_filter_id = $filter_request ? $filter -> alias:$filter -> alias;


	$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if(!$manufactory->id){
		continue;
	}
	$check_emty_product = $model->get_count('published =1 AND is_trash = 0 AND category_id_wrapper LIKE "%,'.$cat->id.',%"  AND manufactory =' .$manufactory->id , 'fs_products','id');
	
	if(!$check_emty_product){
		continue;
	}



	$get_filter = FSInput::get ( 'filter' );
	if ($parent_manu[$filter-> filter_value] == 0) {
		$i = $i + 1;
		if($checkmanu == 1){
			$link = str_replace($filter_old,$filter-> alias,$link);
			// echo 1111;

		}else{

			if(!empty($get_filter)){
				$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat->id.'&ccode='.$cat->alias.'&Itemid=5');
				
				if(!empty($cat->alias1) AND !empty($cat->alias2)){
					$link = str_replace($cat->alias,$cat->alias1.'-'.$filter-> alias.'-'.$cat->alias2,$link);
				}else{
					$link = str_replace($cat->alias,$cat->alias.'-'.$filter-> alias,$link);
				}
				$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
			}else{
				if(!empty($cat->alias1) AND !empty($cat->alias2)){
					$link = str_replace($cat->alias,$cat->alias1.'-'.$filter-> alias.'-'.$cat->alias2,$link);
				}else{
					$link = str_replace($cat->alias,$cat->alias.'-'.$filter-> alias,$link);
				}
				$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
			}
			
			
		}
		
		$page = FSInput::get ( 'page' );
		if($page){
			$link = str_replace('-page'.$page.'.html','.html',$link);
		}

		$link = str_replace('/sap-xep-ban-chay-nhat.html','.html',$link);
		$link = str_replace('/sap-xep-khuyen-mai.html','.html',$link);
		$link = str_replace('/sap-xep-gia-thap-nhat.html','.html',$link);
		$link = str_replace('/sap-xep-gia-cao-nhat.html','.html',$link);
		$link = str_replace('/sap-xep-moi-nhat.html','.html',$link);

		if(@$manufactory_act -> id == $filter-> filter_value || @$filter_old == $filter-> alias ) {
			

			if(!empty($cat->name1) AND !empty($cat->name2)){
				$html_filter .= '<a class="active" href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span>'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span></span></a>'; 
			}else{	
				$html_filter .= '<a class="active" href="'.$link.'" title="'.$cat->name.' '.$filter ->filter_show.'" ><span>'.$cat->name.' '.$filter ->filter_show.'</span></span></a>';
			}
		}
		else {
			if(!empty($cat->name1) AND !empty($cat->name2)){
				$html_filter .= '<a  href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span >'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span></a>';
			}else{
				$html_filter .= '<a  href="'.$link.'" title="'.$cat->name.' '.$filter ->filter_show.'" ><span >'.$cat->name.' '.$filter ->filter_show.'</span></a>';
			}
		}
	}
	
}

if ($filter_m == 1 AND 1==2) {
	foreach ($arr_filter_by_field_manufactory as $filter) {
		$model = new Products_filterBModelsProducts_filter();
		$manufactory = $model->get_record_by_id($filter->filter_value,'fs_manufactories','image');
		$manufactory_name = $model->get_record_by_id($filter->filter_value,'fs_manufactories','name');
		$img = URL_ROOT.str_replace('original','resized', $manufactory->image);
		$str_filter_id = $filter_request ? $filter -> alias:$filter -> alias;
		$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		if(1 == 1){
			if ($parent_manu[$filter-> filter_value] == $manufactory_active -> id) {
				$j = $j + 1;
				
				if($manufactory_act -> id == $filter-> filter_value) {
					$html_filter2 .= '<a class="active" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';	
				}
				else {
					$html_filter2 .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';
				}
				
			}
		}else{
			$html_filter2 .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$manufactory_name-> name.'</span></a>';
		}
	}
}


?>

<?php if(!empty($arr_filter_by_field_manufactory)){
	// print_r($arr_filter_by_field_manufactory);

 ?>
<?php if(1 == 1){ ?>

	<div class="filter-manufactory">
		<div class="title_filter"><span>Thương hiệu</span><span class="icon"></div>
		<div class="link_filter"><?php echo $html_filter; ?></div>
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

<?php } ?>