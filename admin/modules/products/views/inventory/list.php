<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Tồn kho') );
// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
//$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('export_nomal',FSText :: _('Export'),'','Excel-icon.png');
?>
<div class="panel panel-default">
	<div class="panel-body">
		
	<?php 
		$link_sm = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);
	?>
	<form action="<?php echo $link_sm; ?>" name="adminForm" method="post">

		<?php 
		
		$filter_config  = array();
		$fitler_config['search'] = 1; 
		$fitler_config['filter_count'] = 0;
		$fitler_config['text_count'] = 0;

		$text_from_date = array();
		$text_from_date['title'] =  FSText::_('Từ ngày'); 

		$text_to_date = array();
		$text_to_date['title'] =  FSText::_('Đến ngày'); 

		$text_userid = array();
		$text_userid['title'] =  FSText::_('Userid'); 

		$filter_status = array();
		$filter_status['title'] =  FSText::_('Trạng thái'); 
		$filter_status['list'] = @$array_obj_status;


		$filter_ship_unit = array();
		$filter_ship_unit['title'] =  FSText::_('Đơn vị vận chuyển'); 
		$filter_ship_unit['list'] = @$array_shipping_unit;

		$fitler_config['filter'][] = $filter_status;
		$fitler_config['filter'][] = $filter_ship_unit;
		$fitler_config['text'][] = $text_from_date;
		$fitler_config['text'][] = $text_to_date;
		$fitler_config['text'][] = $text_userid;
		echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table id="dataTables-example" class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th width="3%">
							STT
						</th>
						<th width="3%">
							<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
						</th>

						<th>
							<?php echo TemplateHelper::orderTable(FSText :: _('Sản phẩm'), 'a.id',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th>
							<?php echo TemplateHelper::orderTable(FSText :: _('SKU'), 'a.id',@$sort_field,@$sort_direct) ; ?>
						</th>

						<?php foreach ($warehouses as $item) { ?>
						<th>
							<?php echo  TemplateHelper::orderTable(FSText :: _($item->name), 'a.id',@$sort_field,@$sort_direct) ; ?>
						</th>
						<?php } ?>
						<th>
							<?php echo TemplateHelper::orderTable(FSText :: _('Tổng'), 'a.id',@$sort_field,@$sort_direct) ; ?>
						</th>
					
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					
					<?php if(@$list){?>
						<?php foreach ($list as $row){
							$total = 0;
						?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td><?php echo $row -> name; ?></td>
								<td><?php echo $row -> code; ?></td>
								<?php foreach ($warehouses as $item){
									$warehouses_product = $model -> get_record('product_id = '.$row->id . ' AND warehouses_id = ' . $item->id,'fs_warehouses_products','amount');
									if(!empty($warehouses_product)){
										$total += $warehouses_product-> amount;
									}
								?>
									<td>
										<?php echo @$warehouses_product-> amount ? @$warehouses_product-> amount : 0; ?>
									</td>
								<?php } ?>
								<td><?php echo $total ?></td>
							</tr>
					<?php $i++; ?>
					<?php }?>
					<?php }?>

			</tbody>
		</table>
</div>
<div class="footer_form">
	<?php if(@$pagination) {?>
		<?php echo $pagination->showPagination();?>
	<?php } ?>
</div>

<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
<input type="hidden" value="<?php echo $this -> module;?>" name="module">
<input type="hidden" value="<?php echo $this -> view;?>" name="view">
<input type="hidden" value="" name="task">
<input type="hidden" value="0" name="boxchecked">
</form>
</div>
</div>
</div>
