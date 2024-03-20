<?php  	global $tmpl,$config;
$tmpl -> addStylesheet('landingpages','modules/landingpages/assets/css');
$tmpl -> addScript('detail','modules/landingpages/assets/js');
FSFactory::include_class('fsstring');
$print = FSInput::get('print',0);
?>
<div class="landingpages_detail landingpages">
<?php //echo html_entity_decode($data-> html);
// echo $data-> html;
$new_data = '';
$arr_data = preg_split('/(<img[^>]+\>)/i', html_entity_decode($data-> html), -1, PREG_SPLIT_DELIM_CAPTURE);
foreach ($arr_data as $idata) {
	if (strpos($idata, '<img') !== false) {
		preg_match( '@src="([^"]+)"@' , $idata, $match );
		$src = array_pop($match);
		$src = str_replace(URL_ROOT,'',$src);
		$block = $model-> get_record('image="'.$src.'"','fs_blocks_display','*');
		if($block) {
			// $arr_params = explode(" ",$block-> params);
			// $params = array();
			// foreach ($arr_params as $key => $value) {
			// 	if($value) {
			// 		$arr_value =  explode("=",rtrim($value));
			// 		$params[$arr_value[0]] = $arr_value[1];
			// 	}
			// }
			// echo $tmpl -> load_direct_blocks($block-> module,$block-> title,$block-> link_title,$params);
			$position = $block-> position;
			echo $tmpl -> load_position_display($position);
		}
		else {
			echo $idata;
		}
	} else {
		echo $idata;	
	}
}
?>
</div>
<style>
<?php echo $data-> css; ?>
</style>
<!-- <script>
	<?php //echo html_entity_decode($data-> js); ?>
</script> -->


