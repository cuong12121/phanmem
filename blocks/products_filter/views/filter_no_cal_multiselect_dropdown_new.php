<?php global $tmpl,$is_mobile;

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

// echo $pos;
if($pos == '1') {
 	$max = 10;
} else {
	$max = 100;
}

?>
<?php 
$filter_manu = FSInput::get('filter');
$filter_man = explode(",", $filter_manu);

$ccode = FSInput::get('ccode');
$cid = FSInput::get('cid');

$pro_cat = $model->get_record('id='.$cid,'fs_products_categories','id,alias');

// echo'<pre>';
// print_r($pro_cat);

$alias_pro_cat = $pro_cat -> alias.'-';

$filter_man = str_replace($alias_pro_cat,'',$ccode);

//echo $filter_man;
$filter_man = explode(",", $filter_man);


$arr_filter_by_field_manufactory = @$arr_filter_by_field['manufactory'];

$filter_m = 0;

if(!empty($arr_filter_by_field_manufactory)){
	foreach ($arr_filter_by_field_manufactory as $field_manufac) {
		// echo '<pre>';
		// print_r($field_manufac);
		foreach ($filter_man as $filter_ma) {
			//echo $filter_ma;
			if($field_manufac -> alias == $filter_ma) {
				$filter_m = 1;
				$filter_active = $field_manufac -> filter_value;
				$manufactory_act = $model->get_record('id='.$filter_active,'fs_manufactories');
			}	
		}
	}

	//echo $filter_m;


	if (@$manufactory_act-> parent_id > 0) {
		$manufactory_active = $model->get_record('id='.$manufactory_act-> parent_id,'fs_manufactories');
	}
	else if (@$manufactory_act-> parent_id == 0) {
		$manufactory_active = @$manufactory_act;
	}


	$parent_manu = array();

	foreach ($arr_filter_by_field_manufactory as $field_manufactory) {
		// print_r($field_manufactory);
		// die;
		$manufac = $model->get_record_by_id($field_manufactory->filter_value,'fs_manufactories');
		$parent_manu[$manufac -> id] = $manufac -> parent_id;
	}

	$i = 0;
	$j = 0;
	$count_p=0;

	foreach ($arr_filter_by_field_manufactory as $filter) {
		if ($parent_manu[$filter-> filter_value] == 0) {
			$count_p++;
		}
	}

	foreach ($arr_filter_by_field_manufactory as $filter) {
		$model = new Products_filterBModelsProducts_filter();
		$manufactory = $model->get_record_by_id($filter->filter_value,'fs_manufactories','image,id');
		$manufactory_name = $model->get_record_by_id($filter->filter_value,'fs_manufactories','name');
		$img = URL_ROOT.str_replace('/original/','/large/', $manufactory->image);
		$str_filter_id = $filter_request ? $filter -> alias:$filter -> alias;


		$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if(!$manufactory->id){
			continue;
		}

		//$check_emty_product = $model->get_count('category_id_wrapper LIKE "%,'.$cat->id.',%"  AND manufactory =' .$manufactory-> id , 'fs_products','id');
		$check_emty_product = $model->get_count('published = 1 AND is_trash = 0 AND category_id_wrapper LIKE "%,'.$cat->id.',%"  AND manufactory_id_wrapper LIKE "%,' .$manufactory-> id .',%"' , 'fs_products','id');

		// print_r($check_emty_product);
		// die;

		if(!$check_emty_product){
			continue;
		}

		$get_filter = FSInput::get ( 'filter' );
		if ($parent_manu[$filter-> filter_value] == 0) {

			$i = $i + 1;
			if($checkmanu == 1){
				$link = str_replace($filter_old,$filter-> alias,$link);
			}else{
				if(!empty($get_filter)){
					$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat->id.'&ccode='.$cat->alias.'&Itemid=5');
					
					if(!empty($cat->alias1) AND !empty($cat->alias2)){
						$link = str_replace($cat-> alias,$cat->alias1.'-'.$filter-> alias.'-'.$cat->alias2,$link);
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

			//echo $link;
			$link  = preg_replace('#-page([0-9]*)?#is','',$link);
			// echo $link;
			// die;

			if($i < $max){
				if(@$manufactory_act -> id == $filter-> filter_value || @$filter_old == $filter-> alias ) {			
					if(!empty($cat->name1) AND !empty($cat->name2)){
						$html_filter .= '<a class="active" href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span>'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span></span><img src="'.$img.'"></a>'; 
					}else{	
						$html_filter .= '<a class="active" href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$filter ->filter_show.'</span></span><img src="'.$img.'"></a>';
					}
				}	
				else {
					if(!empty($cat->name1) AND !empty($cat->name2)){
						$html_filter .= '<a  href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span >'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span><img src="'.$img.'"></a>';
					}else{
						$html_filter .= '<a  href="'.$link.'" title="'.$filter ->filter_show.'" ><span >'.$filter ->filter_show.'</span><img src="'.$img.'"></a>';
					}
				}
			}

			if($i == $max && !$is_mobile){
				$html_filter .= '<a href="javascript:void(0);" class="morecate">Xem thêm</a>';				
			}


			if($i >= $max){		
				if(!empty($cat->name1) AND !empty($cat->name2)){
					$html_filter .= '<a class="hidden limit" href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span >'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span><img src="'.$img.'"></a>';
				}else{
					$html_filter .= '<a class="hidden limit"  href="'.$link.'" title="'.$filter ->filter_show.'" ><span >'.$filter ->filter_show.'</span><img src="'.$img.'"></a>';
				}


				if($i == $count_p && !$is_mobile){
					$html_filter .= '<a href="javascript:void(0);" class="fewcate hidden">Ẩn bớt</a>';
				}

				
			}

		}
		
	}

	if ($filter_m == 1) {

		foreach ($arr_filter_by_field_manufactory as $filter) {
			$model = new Products_filterBModelsProducts_filter();
			$manufactory = $model->get_record_by_id($filter->filter_value,'fs_manufactories','image');
			$manufactory_name = $model->get_record_by_id($filter->filter_value,'fs_manufactories','name');
			$img = URL_ROOT.str_replace('original','resized', $manufactory->image);
			$str_filter_id = $filter_request ? $filter -> alias:$filter -> alias;
			$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


			if ($parent_manu[$filter-> filter_value] == $manufactory_active -> id) {
				$j = $j + 1;
				if($checkmanu == 1){
					$link = str_replace($filter_old,$filter-> alias,$link);
				}else{
					if(!empty($get_filter)){
						$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat->id.'&ccode='.$cat->alias.'&Itemid=5');
						
						if(!empty($cat->alias1) AND !empty($cat->alias2)){
							$link = str_replace($cat-> alias,$cat->alias1.'-'.$filter-> alias.'-'.$cat->alias2,$link);
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
				$link  = preg_replace('#-page([0-9]*)?#is','',$link);
				//if ($parent_manu[$filter-> filter_value] == $manufactory_active -> id) {	
				
				if($j < 9){
					if($manufactory_act -> id == $filter-> filter_value) {
						if(!empty($cat->name1) AND !empty($cat->name2)){
							$html_filter2 .= '<a class="active" href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span>'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span></span></a>'; 
						}else{	
							$html_filter2 .= '<a class="active " href="'.$link.'" title="'.$filter ->filter_show.'" ><span>'.$filter ->filter_show.'</span></span></a>';
						}
					}

					else {
						if(!empty($cat->name1) AND !empty($cat->name2)){
							$html_filter2 .= '<a  href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span >'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span></a>';
						}else{
							$html_filter2 .= '<a  href="'.$link.'" title="'.$filter ->filter_show.'" ><span >'.$filter ->filter_show.'</span></a>';
						}
					}
				}
				if($j == 9 && !$is_mobile){

					$html_filter2 .= '<a href="javascript:void(0);" class="morecate">Xem thêm</a>';

				}

				if($j >= 9){									
					if(!empty($cat->name1) AND !empty($cat->name2)){
						$html_filter2 .= '<a class="hidden limit" href="'.$link.'" title="'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'" ><span >'.$cat->name1.' '.$filter ->filter_show.' '.$cat->name2.'</span></a>';
					}else{
						$html_filter2 .= '<a class="hidden limit" href="'.$link.'" title="'.$filter ->filter_show.'" ><span >'.$filter ->filter_show.'</span></a>';
					}
					if ($j == count($arr_filter_by_field_manufactory) && !$is_mobile) {
						$html_filter2 .= '<a href="javascript:void(0);" class="fewcate hidden">Ẩn bớt</a>';
					}
				}

			}
		}
	}

}
?>

<?php if(!$is_mobile){ ?>
	<?php if($html_filter){?>
		<?php if($pos == 2) { ?>
			<div class="title_filter"><span>Hãng</span></div>
		<?php } ?>
		<div class="filter-manufactory">
			<div class="filter-manufactory-scroll">
				<?php echo $html_filter; ?>
			</div>
		</div>
	<?php } ?>
	<?php if($filter_m == 1 && $html_filter2){ ?>
		<div class="filter-manufactory filter-manufactory2">
			<div class="filter-manufactory-scroll">	
				<?php echo $html_filter2; ?>
			</div>
		</div>
	<?php } ?>
<?php }else{ ?>
	<div class="filter-manufactory filter-manufactory2-mb">
		<!-- <div class="title_filter"><span>Thương hiệu</span></div> -->
		<div class="filter-manufactory-scroll">
			<?php echo $html_filter; ?>
		</div>
	</div>
	<?php if($filter_m == 1 && $html_filter2){ ?>
		<div class="filter-manufactory filter-manufactory2">
			<div class="filter-manufactory-scroll">
				<?php echo $html_filter2; ?>

			</div>
		</div>
	<?php } ?>
<?php } ?>

<div class="clear"></div>

