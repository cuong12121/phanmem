<?php if(!empty($orders) && count($orders) > 1){ ?>
<div class="products_orders" >
                                     


<ul id="products_orders">
	<?php $i = 0; ?>
<?php foreach($orders as $item){ ?>
	<li class="item item-<?php echo $item -> id;?>  <?php echo $i ? 'hide':''; ?>">
		Khách hàng <span class="name"><?php echo $item -> sender_name; ?></span> - <span class="phone">(<?php echo substr($item -> sender_telephone, 0, -3).'xxx'; ?>)</span> đã mua <?php echo time_elapsed_string(strtotime($item -> created_time)); ?> (<?php echo date('d/m/Y',strtotime($item->created_time)); ?>) 
		<i class="icon_v1"></i>
	</li>
<?php $i ++; ?>
<?php } ?>
</ul>

</div>
<?php } ?>