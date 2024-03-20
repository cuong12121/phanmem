<?php $estore_code = 'DH';
	  $estore_code .= str_pad($order -> id, 8 , "0", STR_PAD_LEFT);
?>
<h2 class="title-order">Chi tiết đơn hàng</h2>
<div><span class="order-code">Mã số đơn hàng: <strong><?php echo $estore_code?></strong></span></div>
<div><span class="order-code">Trạng thái đơn hàng: <strong><?php echo $this -> showStatus($order -> status); ?></strong></span></div>
<br/>
<table width="100%" cellpadding="4" bordercolor="#525252" border="1" class="table-product-pack">
<thead>
  <tr class="head-tr">
    <td width="6%">TT</td>
    <td width="30%">Tên sản phẩm</td>
    <td width="10%">Giá (vnđ)</td>
    <td width="10%">Số lượng</td>
    <td width="16%">Tổng giá</td>
  </tr>
</thead>
<tbody>
<?php $link_view =FSRoute::_('index.php?module=products&view=order&id='.$data[0]->order_id.'&task=detail&Itemid=45');?>
<?php $stt=1; $total_price=0; foreach($data as $item){?>
	<?php $product = isset($arr_products[$item -> product_id])?$arr_products[$item -> product_id]:'';?>
	<?php $link = FSRoute::_('index.php?module=products&view=product&code='.@$product -> alias.'&id='.$product -> id.'&ccode='.@$product->category_alias.'&Itemid=34');?>
   <tr>
        <td><?php echo $stt;?></td>
        <td class="name-product"><a href="<?php echo $link;?>"><?php echo @$product->name;?></a> </td>
        <td class="price-product"><?php echo format_money($item->price);?></td>
        <td><input disabled="disabled" type="text" height="20px" border="1" name="quantity_13" value="<?php echo $item->count;?>" class="numbers-pro"></td>
        <td class="total-price"><?php echo format_money($item->price);?></td>
  </tr>
  <?php $total_price=$total_price+$item->price;$stt=$stt+1;?>
<?php }?>  
  <tr>
    <td style="text-align: right;" colspan="6">Thành tiền : <span class="total-price"><?php echo format_money($total_price);?></span></td>
  </tr>
</tbody>
</table>
<table width="100%" cellpadding="5" border="0">
  	<tbody>
	  <tr>
		<td colspan="2"><p class="orange upper"><strong>Thông tin người đặt hàng</strong></p></td>
	  </tr>
	  <tr>
		<td width="35%" class="td-left">Tên người đặt hàng : </td>
		<td width="65%"><?php echo $order->sender_name;?></td>
	  </tr>
	  <tr>
		<td class="td-left">Giới tính:</td>
		<td> <?php if($order->sender_sex == 'male'){?>Nam<?php }else{?>Nữ<?php }?></td>
	  </tr>
	  <tr>
		<td class="td-left">Địa chỉ : </td>
		<td><?php echo $order->sender_address;?></td>
	  </tr>
	  <tr>
		<td class="td-left">Email : </td>
		<td><?php echo $order->sender_email;?></td>
	  </tr>
	  <tr>
		<td class="td-left">Điện thoại : </td>
		<td><?php echo $order->sender_telephone;?></td>
	  </tr>
	  <?php if(!empty($order->sender_comments)){?>
	  <tr>
		<td class="td-left">Ghi chú : </td>
		<td><?php echo $order->sender_comments;?></td>
	  </tr>
	  <?php }?>
	  <tr>
		<td colspan="2"><p class="orange upper"><strong>Thông tin người nhận hàng</strong></p></td>
	  </tr>
	  <tr>
		<td width="35%" class="td-left">Tên người đặt hàng : </td>
		<td width="65%"><?php echo $order->recipients_name;?></td>
	  </tr>
	  <tr>
		<td class="td-left">Giới tính:</td>
		<td> <?php if($order->recipients_sex == 'male'){?>Nam<?php }else{?>Nữ<?php }?></td>
	  </tr>
	  <tr>
		<td class="td-left">Địa chỉ : </td>
		<td><?php echo $order->recipients_address;?></td>
	  </tr>
	  <tr>
		<td class="td-left">Email : </td>
		<td><?php echo $order->recipients_email;?></td>
	  </tr>
	  <tr>
		<td class="td-left">Điện thoại : </td>
		<td><?php echo $order->recipients_telephone;?></td>
	  </tr>
	  <?php if(!empty($order->recipients_comments)){?>
	  <tr>
		<td class="td-left">Ghi chú : </td>
		<td><?php echo $order->recipients_comments;?></td>
	  </tr>
	  <?php }?>
	  <tr>
		<td class="td-left">Thời gian nhận hàng : </td>
		<td><?php echo date('H:i d/m/Y',strtotime($order -> received_time)); ?></td>
	  </tr>
	</tbody>
</table>
<a id="print_icon" rel="<?php echo $link_view;?>" class="dt-print" href="javascript:;" onclick="return OpenPrintOrder();"><div></div></a>
<br/>
