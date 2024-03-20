<?php 
global $tmpl;
$tmpl -> addStylesheet('compare','modules/products/assets/css');
$Itemid = FSInput::get('Itemid');
$str_list_id = 0;
$first = 0;
$total = count($data);
for($i  = 0; $i < $total; $i ++){
	if($first != 0)
			$str_list_id .= ',';
	if($data[$i]->record_id){
		$str_list_id .= $data[$i]->record_id;
		$first=1;
	}
}
$row_table = 100;
$row_label = 20;
$row_width =( $row_table - $row_label ) / $total;
$print = FSInput::get('print');

$col = count($data) < 5 ? count($data): 4;
//echo $col;
?>
<div class='compare'>
	<h1 class='page_title'>So sánh sản phẩm</h1>
	<div id="compare-detail" class="wapper-content-page">
		<div id="compare-head-t">
			<div class="compare-head-t-l">
				<div class="compare-head-t-r">
				</div>	
			</div>	
		</div>	
		<div class="compare_detail-inner">
			
			<div class="compare_detail-inner-wrap compare_<?php echo $col?>_cols">
				
				<!--	COMPARE TABLE			-->
				<?php include_once 'compare_header.php';?>
				
				<div id="results" class="compar_block">
					<div id="cmresult" class="compar_result">
						<?php include_once 'compare_result.php';?>
					</div>
					<div id="cmlist" class="compar_listprod">
						
					</div>
				</div>
				<!--	end COMPARE TABLE			-->
				
				
			</div>
		</div>
	</div>
</div>
