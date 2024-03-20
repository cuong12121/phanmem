<div class="content-t" id="content-t1">
	<div class="row">
		<div class="col-12 col-lg-8">
			<div id="boxInfoBasic" class="card">
				<div class="card-header bg-light py-2 header-elements-inline">
					<h5 class="card-title font-weight-semibold"><i class="fa fa-list-alt mr-1"></i> Thông tin</h5>
					<div class="header-elements">
						<span class="mr-1 ">Trạng thái: </span>
						<span type="button" class="badge badge-primary font-size-lg"><?php echo !empty($status[$data->status_id]) ? $status[$data->status_id]->name : '' ?>
						</span>              
					</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-lg-6">
								
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Tên: </label><?php echo $data->name ?>               
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Mã: </label><?php echo $data->code ?>  
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Mã vạch: </label><?php echo $data->code ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Mã sản phẩm cha: </label><?php echo $data->parent_id_name ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Danh mục: </label><?php echo $data->category_name ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Thương hiệu: </label><?php echo $data->manufactory_name ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Người tạo: </label><?php echo $data->creator_name ?>
								</div>
								<div class="input-group col-12 mb-2 ">
									<label class="mr-1">Ngày tạo: </label><?php echo $data->created_time ?>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Giá nhập:</label><?php echo format_money($data->import_price,'₫','0') ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Giá bán lẻ:</label><?php echo format_money($data->price,'₫','0') ?> 
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Giá đón gói:</label><?php echo format_money($data->price_pack,'₫','0') ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Giá sỉ:</label><?php echo format_money($data->price_wholesale,'₫','0') ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Giá cũ:</label> <?php echo format_money($data->price_old,'₫','0') ?>
								</div>
								<div class="input-group col-12 mb-2">
									<label class="mr-1">Đơn vị tính:<?php echo $data->unit ?> </label>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
			<div class="col-12 col-lg-4">
				<div class="imageDetail mb-2 text-center">
					<?php if($data->image){ ?>
					<img src="<?php echo URL_ROOT.$data->image ?>" width="200px">
					<?php } ?>
				</div>
					<div id="boxInfoImage" class="card">
						<div class="card-header bg-light py-2 header-elements-inline">
							<h5 class="card-title font-weight-semibold"><i class="fa fa-list-alt mr-1"></i> Thông tin khác</h5>
							<div class="header-elements">
							</div>
						</div>
						<div class="card-body p-0">
							<table class="table table-borderless table-xs mt-1 mb-1" data-hasblockrows="1">
								<tbody>
									<tr>
										<td>Loại sản phẩm</td>
										<td class="text-right"><?php echo !empty($types[$data->type_id]) ? $types[$data->type_id]->name : '' ?></td>
									</tr>
									<tr>
										<td>Khối lượng</td>
										<td class="text-right"> <?php echo $data-> length ?> gr</td>
									</tr>
									<tr>
										<td>Link hướng dẫn sử dụng</td>
										<td class="text-right"> <?php echo $data-> tutorial_link ?></td>
									</tr>
									<!-- <tr>
										<td>Thể tích</td>
										<td class="text-right"></td>
									</tr><tr>
										<td>Cân nặng</td>
										<td class="text-right"></td>
									</tr><tr>
										<td>Chủng loại</td>
										<td class="text-right"></td>
									</tr><tr>
										<td>Kích thước</td>
										<td class="text-right"></td>
									</tr><tr>
										<td>Màu sắc</td>
										<td class="text-right"></td> -->
									</tr>                </tbody>
								</table>
							</div>
						</div>


					</div>
				</div>
			</div>
			<div class="content-t hide" id="content-t2">
				<?php if(empty($data_warehouses)){
					echo "Không có dữ liệu.";
					return;
				} ?>

				<table id="dataTables-example" class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>
								Kho
							</th>
							<th>
								Tồn
							</th>
							<th>
								Tạm giữ
							</th>
							<th>
								Có thể bán
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
							$amount_total = 0;
							$amount_hold_total = 0;
							foreach ($warehouses as $warehouse) {
							$amount = !empty($data_warehouses[$warehouse->id]-> amount) ? $data_warehouses[$warehouse->id]-> amount : 0;
							$amount_hold = !empty($data_warehouses[$warehouse->id]-> amount_hold) ? $data_warehouses[$warehouse->id]-> amount_hold : 0;
							$amount_total += $amount;
							$amount_hold_total += $amount_hold;

						?>
						<tr>
							<td><?php echo $warehouse->name ?></td>
							<td><?php echo $amount; ?></td>
							<td><?php echo $amount_hold; ?></td>
							<td>
								<?php echo (float)$amount - (float)$amount_hold; ?>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td>Tổng</td>
							<td><?php echo $amount_total ?></td>
							<td><?php echo $amount_hold_total ?></td>
							<td><?php echo (float)$amount_total - (float)$amount_hold_total; ?></td>
						</tr>
					</tbody>
				</table>
			</div>