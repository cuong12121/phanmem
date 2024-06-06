<?php 
global $tmpl;
$tmpl -> addStylesheet('compare','modules/products/assets/css');
$tmpl -> addScript('compare','modules/products/assets/js');
$Itemid = FSInput::get('Itemid');
$str_list_id = 0;
$first = 0;
$total = count(@$data);
if($total){
	for($i  = 0; $i < $total; $i ++){
		if($first != 0)
			$str_list_id .= ',';
		if(@$data[$i]->record_id){
			$str_list_id .= $data[$i]->record_id;
			$first=1;
		}
	}
	$print = FSInput::get('print');

}
?>

<div class='compare'>
	<h1 class='page_title'><span><?php echo $title; ?></span></h1>
	<input type="hidden" value="<?php echo $str_ids; ?>" id="str_ids_product">
<!-- 	<div class="export_file" onclick="export_file()">
		<svg version="1.1" width="15px" height="15px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M352,288.994v127.008H64v-288h96v-64H32c-17.664,0-32,14.336-32,32v352c0,17.696,14.336,32,32,32h352 c17.696,0,32-14.304,32-32V288.994H352z"></path></g></g><g><g><path d="M505.6,131.202l-128-96c-4.8-3.648-11.328-4.224-16.736-1.504c-5.44,2.72-8.864,8.256-8.864,14.304v48h-48 c-97.056,0-176,78.944-176,176c0,7.424,5.12,13.888,12.32,15.584c1.216,0.288,2.464,0.416,3.68,0.416 c5.952,0,11.552-3.328,14.304-8.832l3.776-7.52c24.544-49.12,73.888-79.648,128.8-79.648H352v48 c0,6.048,3.424,11.584,8.832,14.304c5.408,2.72,11.936,2.144,16.768-1.504l128-96c4.032-3.008,6.4-7.776,6.4-12.8 S509.632,134.21,505.6,131.202z"></path></g></g></svg> Xuất ra file
	</div> -->
	<div class="clear"></div>
	<div id="compare-detail" class="wapper-content-page">
		<div class="compare_detail-inner">
			<div class="compare_detail-inner-wrap">
				<div   id="results" class="compar_block">
					<div id="cmresult" class="compare_result">
						<?php 
						if(!IS_MOBILE) {
							include_once 'compare_result.php';
						} else {
							include_once 'compare_result_mobile.php';
						}
						?>
					</div>
					<div id="cmlist" class="compar_listprod">

					</div>
				</div>
				<input type="hidden" name="table_name" id="table_name" value="<?php echo $tablename;?>">
			</div>
		</div>
	</div>
	<h3 class="description" style="margin-top: 20px;">
		<?php 
		global  $config;
		echo str_replace('{name}',$h3,$config['note_ss']); ?>
	</h3>
	<br/>
</div>
