
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
			if($data[$i]->record_id){
				$str_list_id .= $data[$i]->record_id;
				$first=1;
			}
		}
		$print = FSInput::get('print');
		
	}
?>
<div class='compare'>
	<h1 class='page_title'>So sánh sản phẩm</h1>
	<div id="compare-detail" class="wapper-content-page">

		<div class="compare_detail-inner">
			
			<div class="compare_detail-inner-wrap">
				
<!--				<div class="compare_search">-->
					<?php // include_once 'compare_search.php';?>
<!--				</div>-->
				<!--	COMPARE TABLE			-->
				<div class="compare_frame_content">
					<?php include_once 'compare_header.php';?>
				</div>
				<div class="compar_block">
					<?php if($total){?>
					<div id="cmresult" class="compare_result">
						<?php include_once 'compare_result.php';?>
					</div>
					<?php }?>
					<div id="cmlist" class="compar_listprod">
						
					</div>
				</div>
				<input type="hidden" name="table_name" id="table_name" value="<?php echo $tablename;?>">
				<!--	end COMPARE TABLE			-->
				
				
			</div>
		</div>
	</div>
</div>
 