<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php  
global $toolbar,$is_letan;
$toolbar->setTitle(FSText :: _('Xử lý') );
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');  
$this -> dt_form_begin(0);
?>
<?php
global $is_kythuat, $is_letan, $is_quanlykho; ?>
<div class="inner_quy_trinh">
	<div class="left">
		<div class="customer">
			<?php echo $customer-> name; ?> <br>
			<?php echo $customer-> phone;?> <br>
			<a href="javascript:void()" class="read_full_cus">Xem thông tin</a>
			<div class="full_cus hide">
				<table>
					<tr>
						<td>Tên:</td>
						<td><?php echo $customer-> name; ?></td>
					</tr>
					<tr>
						<td>Điện thoại:</td>
						<td><?php echo $customer-> phone; ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo $customer-> email; ?></td>
					</tr>
					<tr>
						<td>Địa chỉ:</td>
						<td><?php echo $customer-> address; ?></td>
					</tr>

				</table>
			</div>
		</div>
	</div>
	<div class="main">
		<div class="info info_head">
			<?php echo $data-> machine_type; ?> -  <?php echo $data-> imei; ?><br>
			<?php echo $data-> more_info; ?> <br>
			Hẹn trả: <?php echo $data-> return_time; ?> <br>
			Loại dịch vụ: <?php echo @$arrsv[$data-> services]; ?>
		</div>

		<div class="info kythuat">
			<?php if($data-> technical_id) { 
				$time_step1 = new DateTime($data-> time_step1);
				echo 'Lễ tân <strong>'.$data-> create_user_name.'</strong> đã chuyển đến kỹ thuật: <strong>'.$data-> technical_name .'</strong> (lúc '.$time_step1-> format('H:i:s d/m/Y').')';
			} else {?>
				<?php if($is_letan && $permission_letan) { ?>
					Chuyển đến cho kỹ thuật:
					<select name="kythuat" id="kythuat">
						<?php foreach ($kythuat as $item) { ?>
							<option value="<?php echo $item-> id ?>"><?php echo $item-> username; ?></option>
						<?php } ?>
					</select>
					<li class="c_kt">Chuyển ngay</li>
				<?php } else {
					echo 'Chờ lễ tân <strong>'.$data-> create_user_name.'</strong> chuyển cho kỹ thuật';
				
				} ?>
			<?php } ?>
		</div>

		<?php if($data-> step == 1) { ?>
			<?php if($is_kythuat){?>
				<div class="info">
					<div class="c_themlk">
						<a class='add_services c_button c_them_lk' href="javascript:void(0);" onclick="addServices()" > <?php echo FSText :: _("+ Thêm"); ?> </a>
						<?php for( $iip = 1 ; $iip< 10; $iip ++ ) {?>
							<div id="ip<?php echo $iip; ?>" ></div>
						<?php }?>
						<input type="text" onkeyup="search_acc(0)" class="linh_kien" name="linh_kien_0" id="linh_kien_0" placeholder="Linh kiện cần thiết">
						<div class="inner_cus inner_cus_0"> <div class="auto_cus auto_cus_0"></div><span onclick="close_cus(0)" class="close_cus close_cus_0">x</span> </div>
						<input type="hidden" class="linh_kien" name="linh_kien_id_0" id="linh_kien_id_0">
						<input type="text" class="linh_kien" name="technical_note" id="technical_note" placeholder="Ghi chú">
					</div>
					<li class="c_linhkien c_button">Yêu cầu linh kiện</li>
					<li class="c_start_set2 c_button c_button_ss">Bắt đầu sửa không cần linh kiện</li>
				</div>
			<?php } ?>
		<?php } else if($data-> step > 1) {?>
			<?php if($data-> is_linhkien) { ?>
				<div class="info">
					<?php $time_step2 = new DateTime($data-> time_step2); ?>
					<?php echo 'Kỹ thuật <strong>'.$data-> technical_name.'</strong> đang yêu cầu linh kiện: "';
					$ilk = 0; 
					foreach ($list_lk as $itemlk) {
						if($ilk == 0) {
							echo $itemlk -> name;
						}
						else {
							echo ', '.$itemlk -> name;
						}
						$ilk++; 
					}
					 echo '" (lúc '.$time_step2-> format('H:i:s d/m/Y').')'; ?>
				</div>
			<?php } ?>
		<?php } ?>

		<?php if($data-> is_linhkien){?>
			<?php if($data-> step == 2) { ?>
<!-- 				<?php if($is_quanlykho){ ?>
					<div class="info">
						<li class="c_ylinkien c_button">Cấp link kiện</li>
						<li class="c_nlinkien c_button c_button_no">Không cấp link kiện</li>
					</div>
				<?php } ?> -->

			<?php } else if($data-> step > 2) { ?>
				<div class="info <?php if($data-> is_cap) {echo 'sucess'; } else echo 'danger'; ?>">
					<?php $time_step3 = new DateTime($data-> time_step3); ?>
					<?php echo 'Quản lý kho <strong>'.$data-> user_inventory_name.'</strong>';if($data-> is_cap){ echo ' đã cấp linh kiện: "';
				$ilk = 0; 
					foreach ($list_lk as $itemlk) {
						if($ilk == 0) {
							echo $itemlk -> name;
						}
						else {
							echo ', '.$itemlk -> name;
						}
						$ilk++; 
					}
				} else echo ' không cấp linh kiện "'; echo ' (lúc '.$time_step3-> format('H:i:s d/m/Y').')';?>
				</div>


			<?php } ?>

		<?php } else {

			if($data-> step > 2) { ?>
				<div class="info">
					<?php echo 'Kỹ thuật <strong>'.$data-> technical_name.'</strong>';?> sửa chữa không cần linh kiện
				</div>
			<?php } ?>
		<?php } ?>

		<?php if($data-> step == 3) { ?>
			<?php if($is_kythuat){ ?>
				<div class="info">
					<li class="c_start_set c_button">Bắt đầu sửa</li>
				</div>
			<?php } ?>

		<?php } else if($data-> step > 3) { ?>
			<div class="info">
				<?php $time_step4 = new DateTime($data-> time_step4); ?>
				<?php echo 'Kỹ thuật <strong>'.$data-> technical_name.'</strong> đang sửa chữa'.' (từ '.$time_step4-> format('H:i:s d/m/Y').')';?>
			</div>
		<?php } ?>

		<?php if($data-> step == 4) { ?>
			<?php if($is_kythuat) { ?>
				<div class="info">
					<li class="c_end_set_y c_button">Đã sửa xong</li>
					<li class="c_end_set_n c_button c_button_no">Không sửa được</li>
				</div>
			<?php } ?>

		<?php } else if($data-> step > 4) { ?>
			<div class="info <?php if($data-> is_sua) {echo 'sucess'; } else echo 'danger'; ?>">
				<?php $time_step5 = new DateTime($data-> time_step5); ?>
				<?php echo 'Kỹ thuật <strong>'.$data-> technical_name.'</strong>';if($data-> is_sua){ echo ' đã sửa xong "';} else echo ' không sửa được'; echo ' (lúc '.$time_step5-> format('H:i:s d/m/Y').')';?>
			</div>
		<?php } ?>

		<?php if($data-> step == 5) { ?>
			<?php if(($is_letan && $permission_letan)){?>
				<div class="info">
					<li class="c_call_cus c_button">Gọi báo khách</li>
				</div>
			<?php } ?>

		<?php } else if($data-> step > 5) { ?>
			<div class="info sucess">
				<?php $time_step6 = new DateTime($data-> time_step6); ?>
				<?php echo 'Lễ tân <strong>'.$data-> create_user_name.'</strong> đã gọi báo khách'.' (lúc '.$time_step6-> format('H:i:s d/m/Y').')';?>
			</div>
		<?php } ?>

		<?php if($data-> step == 6) { ?>
			<?php if($is_letan && $permission_letan){?>
				<div class="info">
					<li class="c_finish c_button">Hoàn tất</li>
				</div>
			<?php } ?>

		<?php } else if($data-> step > 6) { ?>
			<div class="info sucess">
				<?php $time_step7 = new DateTime($data-> time_step7); ?>
				<?php echo 'Đã hoàn tất'.' (lúc '.$time_step7-> format('H:i:s d/m/Y').')';?>
			</div>

			<?php if($is_letan && $permission_letan){?>

				<?php if(!@$coupon-> id) { ?>
					<div class="info write">
						<li class="c_write c_button"><a title="Viết hóa đơn" target="_blank" href="/admin/index.php?module=coupon&view=coupon&task=add&receipt=<?php echo $data-> id; ?>">Viết hóa đơn</a></li>
					</div>
				<?php } else { ?>

					<div class="info write2">
						<li class="c_write2 c_button"><a title="Xem / Sửa hóa đơn" target="_blank" href="/admin/index.php?module=coupon&view=coupon&task=edit&id=<?php echo $coupon-> id; ?>">Xem / Sửa hóa đơn</a></li>
					</div>

				<?php } ?>


			<?php } ?>
		<?php } ?>

	</div>
	<div class="right">
		<div class="customer">
			<?php $created_time = new DateTime($data-> created_time); ?>
			Phiếu nhận: <?php echo $data-> id; ?> <br>
			Nhận lúc: <?php echo $created_time-> format('H:i:s d/m/Y');?> <br>
			<a href="index.php?module=receipt&view=receipt&task=see&id=<?php echo $data-> id; ?>" target="_blank" class="read_full_receipt">Xem thông tin</a>
		</div>
	</div>
</div>

<?php $this -> dt_form_end(@$data,0); ?>

<script>

	function add_cus(id, name,i) {
		if(i > 0) {
			$('#linh_kien_id_'+i).val(id);
			$('#linh_kien_'+i).val(name);
			$('.inner_cus_'+i).css('display','none');
		}
		else {
			$('#linh_kien_id_0').val(id);
			$('#linh_kien_0').val(name);
			$('.inner_cus_0').css('display','none');
		}
	}

	function search_acc(i){
		$('.inner_cus_'+i).css('display','block');
		var name = $('#linh_kien_'+i).val();
		$.ajax({
			type : 'get',
			url : 'index.php?module=receipt&view=receipt&raw=1&task=loadcustomer_receipt&stt='+i,
			dataType : 'html',
			data: {name:name},
			success : function(data){
				$('.auto_cus_'+i).html(data);
				if (data==''){
					$('.inner_cus_'+i).css('display','none');
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	}

	var i = 1;
	function addServices()
	{
		max_ordering = $('#max_ordering').val();
		area_id = "#ip"+i;
		ordering = parseInt(max_ordering) + i + 1;
		var htmlString = '';

        //name 
        htmlString +=  "<input type=\"text\" class=\"linh_kien\" placeholder=\"Linh kiện cần thiết\" onkeyup='search_acc("+i+")' name='linh_kien_"+i+"' id='linh_kien_"+i+"'/>";
        htmlString += "<div class='inner_cus inner_cus_"+i+"'> <div class='auto_cus auto_cus_"+i+"'></div><span onclick='close_cus("+i+")' class='close_cus close_cus_"+i+"'>x</span> </div>";
        htmlString +=  "<input type=\"hidden\" name='linh_kien_id_"+i+"' id='linh_kien_id_"+i+"'  />";
      //  alert(htmlString);
      $(area_id).html(htmlString);        
      i++;
      $("#new_field_total").val(i);
  }

  $('.c_kt').click(function(){
  	var technical_id = $('#kythuat').val();
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type :'get',
  		url :'index.php?module=receipt&view=receipt&raw=1&task=savetechnical',
  		dataType : 'html',
  		data: {technical_id:technical_id,receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
				//$('.auto_cus').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});

  })

  $('.c_linhkien').click(function(){
  var technical_note = $('#technical_note').val();
  var receipt_id = <?php echo $data-> id ;?>;
  var arr_id_lk = '';
  var arrid = new Array();

  for (var ilk = 0; ilk < 10; ilk++) {
  	arrid[ilk] = $('#linh_kien_id_'+ilk).val();
  	if(arrid[ilk]) {
  		arr_id_lk += arrid[ilk]+',';
  	}
  }

  $.ajax({
  	type : 'get',
  	url : 'index.php?module=receipt&view=receipt&raw=1&task=savelinh_kien',
  	dataType : 'html',
  	data: {arr_id:arr_id_lk,receipt_id:receipt_id,technical_note:technical_note},
  	success : function(data){
  		location.reload();
				//$('.auto_cus').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});

})

  $('.c_ylinkien').click(function(){
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type : 'get',
  		url : 'index.php?module=receipt&view=receipt&raw=1&task=saveylinh_kien',
  		dataType : 'html',
  		data: {is_cap:1,receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
				//$('.auto_cus').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});
  })

  $('.c_nlinkien').click(function(){
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type : 'get',
  		url : 'index.php?module=receipt&view=receipt&raw=1&task=saveylinh_kien',
  		dataType : 'html',
  		data: {is_cap:0,receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
				//$('.auto_cus').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});
  })



  $('.c_start_set').click(function(){
	//	var accessories = $('#linh_kien').val();
	var receipt_id = <?php echo $data-> id;?>;
	$.ajax({
		type : 'get',
		url : 'index.php?module=receipt&view=receipt&raw=1&task=savestep4',
		dataType : 'html',
		data: {receipt_id:receipt_id},
		success : function(data){
			location.reload();
				//$('.auto_cus').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});

})

  $('.c_start_set2').click(function(){
	//	var accessories = $('#linh_kien').val();
	var receipt_id = <?php echo $data-> id;?>;
	$.ajax({
		type : 'get',
		url : 'index.php?module=receipt&view=receipt&raw=1&task=savestep4',
		dataType : 'html',
		data: {is_linhkien:0,receipt_id:receipt_id},
		success : function(data){
			location.reload();
				//$('.auto_cus').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});

})

  $('.c_end_set_y').click(function(){
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type : 'get',
  		url : 'index.php?module=receipt&view=receipt&raw=1&task=savestep5',
  		dataType : 'html',
  		data: {is_sua: 1,receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
  		},
  		error : function(XMLHttpRequest, textStatus, errorThrown) {}
  	});

  })

  $('.c_end_set_n').click(function(){
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type : 'get',
  		url : 'index.php?module=receipt&view=receipt&raw=1&task=savestep5',
  		dataType : 'html',
  		data: {is_sua: 0,receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
  		},
  		error : function(XMLHttpRequest, textStatus, errorThrown) {}
  	});

  })

  $('.c_call_cus').click(function(){
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type : 'get',
  		url : 'index.php?module=receipt&view=receipt&raw=1&task=savestep6',
  		dataType : 'html',
  		data: {receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
  		},
  		error : function(XMLHttpRequest, textStatus, errorThrown) {}
  	});

  })

  $('.c_finish').click(function(){
  	var receipt_id = <?php echo $data-> id;?>;
  	$.ajax({
  		type : 'get',
  		url : 'index.php?module=receipt&view=receipt&raw=1&task=savestep7',
  		dataType : 'html',
  		data: {receipt_id:receipt_id},
  		success : function(data){
  			location.reload();
  		},
  		error : function(XMLHttpRequest, textStatus, errorThrown) {}
  	});

  })

  $('.read_full_cus').click(function(){
  	$('.full_cus').toggleClass('hide');
  })


</script>

<style>
.left {
	width: 20%;
	float: left;
}

.main {
	width: 60%;
	float: left;
	text-align: center;
}

.right {
	width: 20%;
	float: left;
}

.customer {
	text-align: center;
	background: #f8f8f8;
	border-radius:15px;
	padding: 15px; 
}

.info {
	text-align: center;
	background: #f8f8f8;
	border-radius:15px;
	padding: 15px; 
	width: 50%;
	margin: auto;
	margin-bottom: 30px;
	border: 1px solid #ea7700;
	color: #ea7700;
	position: relative;
}
.info:before {
	content: '';
	width: 4px;
	height: 30px;
	background: #009aff;
	position: absolute;
	left: calc(50% - 2px);
	top: -32px;
}
li {
	list-style: none;
}
.c_kt {
	cursor: pointer;
	background: blue;
	color: #fff;
	padding: 5px;
	border-radius: 5px;
	margin-top: 5px;
}

.c_button {
	cursor: pointer;
	background: blue;
	color: #fff;
	padding: 5px;
	border-radius: 5px;
	margin-top: 5px;
}

.c_button_no {
	cursor: pointer;
	background: red;
	color: #fff;
	padding: 5px;
	border-radius: 5px;
	margin-top: 5px;
}

.c_button_ss {
	cursor: pointer;
	background: orange;
	color: #fff;
	padding: 5px;
	border-radius: 5px;
	margin-top: 5px;
}

.c_write {
	cursor: pointer;
	background: purple;
	color: #fff;
	padding: 5px;
	border-radius: 5px;
	margin-top: 5px;

}

.c_write a {
	color: #fff !important;
}

.write {
	border: 1px solid green;
}

.c_write2 {
	cursor: pointer;
	background: #ff8100;
	color: #fff;
	padding: 5px;
	border-radius: 5px;
	margin-top: 5px;

}

.c_write2 a {
	color: #fff !important;
}

.write2 {
	border: 1px solid #ff8100;
}


.sucess {
	color: green;
	border: 1px solid green;
}

.danger {
	color: red;
	border: 1px solid red;
}

.info_head {
	color: #3da6ea;
	border: 1px solid #3da6ea;	
}

.info_head:before {
	width: 160px;
	height: 6px;
	top: calc(50% - 3px);
	left: -160px;
}
.info_head:after {
	content: '';
	background: #009aff;
	position: absolute;
	width: 160px;
	height: 6px;
	top: calc(50% - 3px);
	right: -160px;

}

.full_cus {
	margin-top: 10px;
}

.linh_kien {
	display: inline;
	max-width: 100%;
	width: auto;
	padding: 3px 10px;
	font-size: 13px;
	margin-bottom: 5px;
	/*// line-height: 1.42857143;*/
	color: #555;
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	text-align: center;
}
.c_themlk {
	position: relative;
}
.c_them_lk {
	position: absolute;
	background: #00ffff;
	left: 0px;
	margin-top: 1px;
	padding: 4px;
	font-size: 11px;
	color: #ff0000 !important;
}

.c_linhkien {
	background: #ff0000;
}


.inner_cus {
	width: 80%;
	background: #fff;
	position: absolute;
	z-index: 99;
	padding: 15px;
	border-radius: 10px;
	border: 1px solid #888;
	display: none;
}
.auto_cus li {
	list-style: none;
	cursor: pointer;
}
.close_cus {
	top: 0px;
	right: 0px;
	display: inline-block;
	position: absolute;
	cursor: pointer;
	padding: 4px 8px;
	color: white;
	font-weight: bold;
	background: red;
	border-radius: 10px;
}

.close_cus:hover {
	background: blue;
}

select {
	padding: 4px;
	border-color: #e0e0e0;
}

</style>