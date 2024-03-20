<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách') );
	if($_SESSION['ad_groupid'] != 3){
		$toolbar->addButton('add',FSText :: _('Thêm mới'),'','add.png');
		$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');
	}
	//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
?>
<div class="panel panel-default">
	<div class="panel-body">
		


	<div class="form_body">
	

	<form class="form-horizontal" action="<?php echo FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view); ?>" name="adminForm" method="post">
		
<?php
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 1;
    $fitler_config['text_count'] = 0;

   	$filter_status = array();
	$filter_status['title'] = FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_status; 
	$filter_status['field'] = 'name'; 
															
	$fitler_config['filter'][] = $filter_status;	

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;
	$prefix = 'manager_import_product_viet_nam_import_products_';
?>	
	<div class="filter_area">
		<?php echo TemplateHelper::create_filter($fitler_config,$prefix); ?>
	</div>


	<div class="dataTable_wrapper">
		<table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered">
			<thead>
				<tr>
					<th>STT</th>
					<th width="20px">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th>Ngày thực hiện</th>
					<th>Mã gian hàng</th>
					<th>Mã sản phẩm</th>
					<th>Tên sản phẩm</th>
					<th>Chi tiết yêu cầu</th>
					<th>Số lượng</th>
					<th>Yêu cầu nhập cho miền</th>
					<th>Trạng thái</th>
					<th>Duyệt nhập</th>
					<th colspan="2">Phân miền</th>
					<th>Ghi chú gọi hàng</th>
					<th>Giá nhập</th>
					<th>Thông tin NCC</th>
					<th>Ngày xử lý</th>
					<th>Ngày hàng đến kho</th>
					<th>Phân việc cho nhân viên</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>MB</td>
					<td>MN</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>

				<?php $i = 1; foreach ($list as $item){
					$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view.'&task=edit&id='.$item->id);
				?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle"></td>
					<td><?php echo $item->ngay_thuc_hien ? date('d/m/Y',strtotime($item->ngay_thuc_hien)) : '' ?></td>
					<td><?php echo $item-> ma_gian_hang ?></td>
					<td><a href="<?php echo $link ?>"><?php echo $item-> code_product ?></a></td>
					<td><div class="wrap_list_pr"><a href="<?php echo $link ?>"><?php echo $item-> name ?></a></div></td>
					<td><div class="wrap_list_pr"><?php echo $item-> description ?></div></td>
					<td><?php echo $item-> count ?></td>
					<td><?php echo $item-> yeu_cau_kho ?></td>
					<td><?php echo @$array_status[$item-> status] ?></td>
					<td><?php echo @$array_import[$item-> is_import] ?></td>
					<td><?php echo $item->phan_luong_thuc_mb;?></td>
					<td><?php echo $item->phan_luong_thuc_mn;?></td>
					<td><div class="wrap_list_pr"><?php echo $item-> note_nhan_vien_nhan_hang ?></div></td>
					<td><?php echo $item-> price_import ?></td>
					<td><div class="wrap_list_pr"><?php echo $item-> thong_tin_ncc ?></div></td>
					<td><?php echo $item-> ngay_dat_hang ? date('d/m/Y',strtotime($item-> ngay_dat_hang)) : '' ?></td>
					<td><?php echo $item->date_to_ha_noi ? date('d/m/Y',strtotime($item->date_to_ha_noi)) : '' ?></td>
					
					<td><?php echo @$users[$item->employees_id]-> fullname ?></td>
				
					
				
					
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="footer_form">
			<?php if(@$pagination) {?>
				<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
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




<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/profits.css?t='.time(); ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/profits.js?t='.time(); ?>"></script>



<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>

<style type="text/css">
	.note-top{
		color: red;
	    font-size: 16px;
	    margin-bottom: 15px;
	    text-align: center;
	}
	#dataTables-example{
		width: 2600px !important;
		max-width: none !important;
	}
	#dataTables-example .wrap_list_pr{
		max-height: 100px;
		overflow-y: auto;
	}
</style>
