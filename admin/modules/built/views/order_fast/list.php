<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui-1.7.3.custom.css" />
<script type="text/javascript" src="templates/default/js/jquery-ui-1.7.3.custom.min.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<div class="form_body">
	<form action="index2.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>&uid=<?php echo FSInput::get('uid',0,'int'); ?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
//			$filter_config  = array();
//			$fitler_config['search'] = 1; 
//			$fitler_config['filter_count'] = 2;

//		$filter_estore = array();
//			$filter_estore['title'] = FSText::_('Tin thuộc gian hàng'); 
//			$filter_estore['list'] = @$estores; 
//			$filter_estore['field'] = 'estore_name';

//		$fitler_config['filter'][] = $filter_estore;
//			$fitler_config['filter'][] = $filter_categories;
		
			$filter_config  = array();
			$fitler_config['search'] = 1; 
			$fitler_config['filter_count'] = 1;
			$fitler_config['text_count'] = 2;
			
			$text_from_date = array();
			$text_from_date['title'] =  FSText::_('Từ ngày'); 
			
			$text_to_date = array();
			$text_to_date['title'] =  FSText::_('Đến ngày'); 
			
			
			$filter_status = array();
			$filter_status['title'] =  FSText::_('Trạng thái'); 
			$filter_status['list'] = @$array_obj_status; 
			
			$fitler_config['filter'][] = $filter_status;
			$fitler_config['text'][] = $text_from_date;
			$fitler_config['text'][] = $text_to_date;
			echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" bordercolor="#CCCCCC" cellpadding="2">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th>
						<?php echo  TemplateHelper::orderTable(FSText :: _('Mã đơn hàng'), 'a.id',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Người mua'), 'a.sender_name',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Giá trị'), 'total_after_discount',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title"  >
							<?php echo  TemplateHelper::orderTable(FSText :: _('Ngày mua'), 'created_time',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title"  >
							<?php echo  TemplateHelper::orderTable(FSText :: _('Trạng thái'), 'status',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Chi tiết'); ?>
					</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php $total = 0;?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $total += $row -> total_after_discount; ?>
							<?php $link_view = "index2.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td>
									<?php 
									$estore_code = 'DH';
									$estore_code .= str_pad($row -> id, 8 , "0", STR_PAD_LEFT);
									?>
									<a href="<?php echo $link_view;?>"  /> <?php echo $estore_code; ?></a>
								</td>
								<td><?php echo $row -> sender_name; ?>
								</td>
								<td><strong class ="red"><?php echo format_money($row -> total_after_discount); ?></strong><strong><?php echo " VNĐ" ?></strong>
								</td>
								<td><?php echo $row -> created_time; ?>
								</td>
								<td><?php echo $this -> showStatus($row -> status); ?>
								</td>
								<td> <?php echo TemplateHelper::edit($link_view); ?></td>
							</tr>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
					<tr>
						<td colspan="4" align="right">
							<strong> Tổng:</strong>
						</td>
						<td colspan="3" align="left">
							<strong class='red'><?php echo format_money($total); ?></strong> VNĐ
						</td>
					</tr>
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
		<input type="hidden" value="<?php echo FSInput::get('uid',0,'int'); ?>" name="uid">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>