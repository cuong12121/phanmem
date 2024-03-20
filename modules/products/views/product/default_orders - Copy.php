<?php if($orders){ ?>
<div class="products_orders" >
<marquee direction="up" onmouseover="this.stop()" onmouseout="this.start()" scrolldelay="1" scrollamount="2" height="50" align="left" syle="overflow-y: hidden;">
                             
                                       


<ul id="products_orders">
<?php foreach($orders as $item){ ?>
	<li class="item item-<?php echo $item -> id;?>">
		Khách hàng <span class="name"><?php echo $item -> sender_name; ?></span> - <span class="phone">(<?php echo substr($item -> sender_telephone, 0, -3).'xxx'; ?>)</span> đã mua <?php echo time_elapsed_string(strtotime($item -> created_time)); ?> trước (<?php echo date('d/m/Y',strtotime($item->created_time)); ?> ) 

	</li>
<?php } ?>
</ul>
 </marquee>
</div>
<?php } ?>