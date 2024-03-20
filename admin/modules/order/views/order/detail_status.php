
<div class="step-order">
	<div class="item <?php echo $order->status >= 0 && $order->status !=6 ? 'actived-stt' : '' ?>">
		<span class="number-step"><span class="nb">1</span><span class="txt-step">Mới tiếp nhận</span></span>
		<div class="line"></div>
	</div>
	<div class="item <?php echo $order->status >= 1 && $order->status !=6 ? 'actived-stt' : '' ?>">
		<span class="number-step">
			<?php if($order->status < 1  && $order->status ==0 ){?>
				<a class="nb" href="javascript: pending_order(<?php echo $order ->id; ?>)" >2</a>
			<?php }else{?>
				<span class="nb">2</span>
			<?php } ?>
			<span class="txt-step">Đang xử lý</span>
		</span>
		<div class="line"></div>
	</div>

	<div class="item <?php echo $order->status >= 2 && $order->status !=6 ? 'actived-stt' : '' ?>">
		<span class="number-step">
			<?php if($order->status < 2 && $order->status ==1 ){?>
				<a class="nb" href="javascript: warehouse_transfer_order(<?php echo $order ->id; ?>)" >3</a>
			<?php }else{?>
				<span class="nb">3</span>
			<?php } ?>
			<span class="txt-step">Chuyển qua kho đóng gói</span>
		</span>
		<div class="line"></div>
	</div>


	<div class="item <?php echo $order->status >= 4 && $order->status !=6 ? 'actived-stt' : '' ?>">
		<span class="number-step">
			<?php if($order->status < 3 && $order->status == 2){?>
				<a class="nb" href="javascript: ship_order(<?php echo $order ->id; ?>)" >4</a>
			<?php }else{?>
				<span class="nb">4</span>
			<?php } ?>
			
			<span class="txt-step">Đang tiến hành giao</span>
		</span>
		<div class="line"></div>
	</div>
	<div class="item <?php echo $order->status == 5 && $order->status !=6 ? 'actived-stt' : '' ?>">
		<span class="number-step">
			<?php if($order->status < 5 && $order->status == 4){?>
				<a class="nb" href="javascript: finished_order(<?php echo $order ->id; ?>)" >5</a>
			<?php }else{?>
				<span class="nb">5</span>
			<?php } ?>
			<span class="txt-step">Hoàn tất</span>
		</span>
	</div>
</div>

<div class="clear"></div>


<div class="form_user_head_c">
					<span class='bold red'>Tr&#7841;ng th&#225;i &#273;&#417;n h&#224;ng</span>
				</div>				
	<div class="form_user_footer_body">
		<!-- TABLE 							-->
		<!--	RECIPIENCE INFO				-->
		<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">
			<tbody> 

			  <tr>
				<td width="173px"><b>Trạng thái đơn hàng</b></td>
				<td>
					<strong class = "red"><?php echo $this -> showStatus($order->status )?></strong>
				</td>
			  </tr>

			<?php if(1==2){ ?>

			<?php if($order->status < 1 || !$order->status  ){?>
			 	<tr>
					<td>Đang xử lý: </td>
					<td>
						Bạn hãy click vào <a href="javascript: pending_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để chuyển sang<strong> đang xử lý</strong> đơn hàng này
						<br/>
					</td>
			  </tr>
			<?php }?>

			<?php if($order->status < 2 || !$order->status  ){?>
			 	<tr>
					<td>Đã chuyển qua kho: </td>
					<td>
						Bạn hãy click vào <a href="javascript: warehouse_transfer_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để chuyển sang<strong> đã chuyển qua kho</strong> đơn hàng này
						<br/>
					</td>
			  </tr>
			<?php }?>

			<?php if($order->status < 3 || !$order->status  ){?>
			 	<tr>
					<td>Đã đóng gói: </td>
					<td>
						Bạn hãy click vào <a href="javascript: pack_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để chuyển sang<strong> đã đóng gói</strong> đơn hàng này
						<br/>
					</td>
			  </tr>
			<?php }?>

			<?php if($order->status < 4 || !$order->status  ){?>
			 	<tr>
					<td>Đang tiến hành giao: </td>
					<td>
						Bạn hãy click vào <a href="javascript: ship_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để chuyển sang<strong> đang tiến hành giao</strong> đơn hàng này
						<br/>
					</td>
			  </tr>
			<?php }?>

			<?php if($order->status < 5 || !$order->status  ){?>
			 	<tr>
					<td>Hoàn tất đơn hàng: </td>
					<td>
						Bạn hãy click vào <a href="javascript: finished_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để <strong> hoàn tất</strong> đơn hàng này
						<br/>
					</td>
			  </tr>
			<?php }?>

			<?php }?>



			<?php if($order->status < 5 || !$order->status  ){?>
				<tr>
					<td>HỦY ĐƠN HÀNG: </td>
					<td>
						Bạn hãy click vào <a href="javascript: cancel_order(<?php echo $order ->id; ?>)" ><strong class='red'> ĐÂY</strong></a> nếu bạn muốn <strong> hủy đơn hàng </strong>này
						<br/>
					</td>
			  	</tr>	
			<?php }?>

			</tbody>
		</table>
			
	</div>
<script>

	function pending_order(order_id){
		if(confirm('Bạn có chắc chắn đơn hàng này chuyển sang trạng thái đang xử lý?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=change_satus_order&status=1';
		}
	}

	function warehouse_transfer_order(order_id){
		if(confirm('Bạn có chắc chắn đơn hàng này chuyển sang trạng thái đã chuyển qua kho đóng gói?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=change_satus_order&status=2';
		}
	}

	// function pack_order(order_id){
	// 	if(confirm('Bạn có chắc chắn đơn hàng này chuyển sang trạng thái đã đóng gói?')){
	// 		window.location='index.php?module=order&view=order&id='+order_id+'&task=change_satus_order&status=3';
	// 	}
	// }

	function ship_order(order_id){
		if(confirm('Bạn có chắc chắn đơn hàng này chuyển sang trạng thái đang giao hàng?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=change_satus_order&status=4';
		}
	}

	function finished_order(order_id){
		if(confirm('Bạn có chắc chắn đơn hàng này chuyển sang trạng thái hoàn tất?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=change_satus_order&status=5';
		}
	}

	function cancel_order(order_id){
		if(confirm('Bạn có chắc chắn đơn hàng này chuyển sang trạng thái hủy?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=change_satus_order&status=6';
		}
	}

	
</script>



<style type="text/css">
	.step-order{
		display: flex;
		flex-wrap: wrap;
		margin-bottom: 60px;
	}
	.step-order .item{
		width: calc(100% / 6);
	    text-align: center;
	    position: relative;
	}

	.number-step .nb{
		position: absolute;
	    width: 40px;
	    height: 40px;
	    border: 3px solid #dddcdc;
	    border-radius: 50%;
	    font-size: 20px;
	    padding-top: 4px;
	    top: 21px;
	    left: 50%;
	    transform: translateX(-50%);
	    background: #fff;
	    z-index: 2;
	}
	.item .line{
		width: 100%;
	    height: 3px;
	    background: #dddcdc;
	    content: "";
	    left: 50%;
	    position: absolute;
	    top: 40px;
	}

	.actived-stt .number-step .nb{
		color: #fff;
		border: 3px solid #3da6ea;
		background: #3da6ea;
	}
	.actived-stt .line{
		background: #3da6ea;
	}

	.form_user_head_c{
		text-align: center;
	    font-weight: bold;
	    text-transform: unset;
	    font-size: 18px;
	    text-transform: uppercase;
	    margin-top: 74px;
	    margin-bottom: 15px;
	}
	    
</style>