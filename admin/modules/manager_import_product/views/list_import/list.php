<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách') );
	if($_SESSION['ad_groupid'] == 9){
		$toolbar->addButton('export',FSText :: _('Xuất exel'),'','Excel-icon.png');
	}
	if($_SESSION['ad_groupid'] != 3){
		//$toolbar->addButton('add',FSText :: _('Thêm mới'),'','add.png');
		//$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');
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
    $fitler_config['filter_count'] = 0;
    $fitler_config['text_count'] = 2;

   	$filter_status = array();
	$filter_status['title'] = FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_status; 
	$filter_status['field'] = 'name'; 
															
	$fitler_config['filter'][] = $filter_status;	

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Ngày đặt hàng từ'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;
	$prefix = 'manager_import_product_list_import_';
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
					<th>Ngày đặt hàng</th>
					<th>Mã sản phẩm</th>
					<th>Tên</th>
					<th>Số lượng</th>
					<th>Số lượng nhập thực</th>
					<th>ĐVVC</th>
					<th>Mã đơn hàng</th>
					<th>Mã ký gửi</th>
					<th>Ngày phát hành</th>
					<th>Ngày đến kho TQ</th>
					<th>Ngày hàng đến kho</th>
					<th colspan="7">Số lượng thực nhận</th>
					<th colspan="3">Phân hàng MB</th>
					<th colspan="3">Phân hàng MN</th>
					<th>GHI CHÚ[Của NV nhập hàng]</th>
					<th>Phản ánh chất lượng(Phòng bảo hành)</th>
					<th>Hàng thiếu, lỗi vỡ</th>
					<th>Nhập hàng khiếu nại</th>
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
					<td></td>
					<td></td>
					<td>Số kiện</td>
					<td>Số lượng 1 kiện</td>
					<td>Tổng số lượng sp</td>
					<td>Tổng cân nặng cả lô</td>
					<td>Tổng thể tích cả lô</td>
					<td>Nhập kho</td>
					<td>Ghi chú của kho</td>
					<td>Theo dự báo</td>
					<td>Số lượng thực</td>
					<td>Xuất kho</td>
					<td>Theo dự báo</td>
					<td>Số lượng thực</td>
					<td>Xuất kho</td>
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
					<td><?php echo $item->ngay_dat_hang ? date('d/m/Y',strtotime($item->ngay_dat_hang)) : '' ?></td>
					<td><?php echo $item->code_product ?></td>
					<td><?php echo $item->name ?></td>
					<td><?php echo $item-> count ?></td>
					<td><?php echo $item->so_luong_thuc_nhap;?></td>
					<td><?php echo $item->dvvc;?></td>
					<td><?php echo $item->code;?></td>
					<td><?php echo $item->code_deposit;?></td>
					<td><?php echo $item->date_phat_hanh ? date('d/m/Y',strtotime($item->date_phat_hanh)) : '' ?></td>
					<td><?php echo $item->date_to_tq ? date('d/m/Y',strtotime($item->date_to_tq)) : '' ?></td>
					<td><?php echo $item->date_to_ha_noi ? date('d/m/Y',strtotime($item->date_to_ha_noi)) : '' ?></td>
					<td><?php echo $item->so_kien;?></td>
					<td><?php echo $item->so_luong_mot_kien;?></td>
					<td><?php echo $item->tong_so_luong_sp;?></td>
					<td><?php echo $item->tong_can_nang_cua_lo;?></td>
					<td><?php echo $item->tong_the_tich_cua_lo;?></td>
					<td><?php echo TemplateHelper::reverse_status(($item -> id),'nhap_kho',$item->nhap_kho?"0":"1",$this->module,$this->view); ?></td>
					<td><div class="wrap_list_pr"><?php echo $item-> ghi_chu_cua_kho ?></div></td>
					<td><?php echo $item->phan_theo_du_bao_mb;?></td>
					<td><?php echo $item->phan_luong_thuc_mb;?></td>
					<td><?php echo TemplateHelper::reverse_status(($item -> id),'xuat_kho_mb',$item->xuat_kho_mb?"0":"1",$this->module,$this->view); ?></td>
					<td><?php echo $item->phan_theo_du_bao_mn;?></td>
					<td><?php echo $item->phan_luong_thuc_mn;?></td>
					<td><?php echo TemplateHelper::reverse_status(($item -> id),'xuat_kho_mn',$item->xuat_kho_mn?"0":"1",$this->module,$this->view); ?></td>
					<td><div class="wrap_list_pr"><?php echo $item-> note_nhan_vien_nhan_hang ?></div></td>
					<td><div class="wrap_list_pr"><?php echo $item-> phan_anh_phong_bh ?></div></td>
					<td><div class="wrap_list_pr"><?php echo $item-> product_error ?></div></td>
					<td><div class="wrap_list_pr"><?php echo $item-> nhap_hang_khieu_nai ?></div></td>
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
		width: 3500px !important;
		max-width: none !important;
	}
	#dataTables-example .wrap_list_pr{
		max-height: 100px;
		overflow-y: auto;
	}
</style>
