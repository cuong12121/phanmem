
<?php 
	if(!empty($list)){
	foreach ($list as $key => $item){ ?>
	<div class="item">
		<div class="name"><?php echo $item->name ?></div>
		<div class="address"><span>Địa chỉ: </span><?php echo $item->address ?></div>
		<div class="phone"><span>Điện thoại: </span><?php echo $item->phone ?></div>
		<div class="email"><span>Email: </span><?php echo $item->email ?></div>
	</div>
<?php }}else{ echo 'Không tìm thấy kết quả nào' ;} ?>