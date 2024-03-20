<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT.'modules/products/assets/css/favourite.css'; ?>" />
<script language="javascript" type="text/javascript" src="<?php echo URL_ROOT.'modules/products/assets/js/favourite.js'; ?>"></script>
<h2 class='head_content'>
	Danh sách sản phẩm yêu thích
</h2>
	<div class="tab_content_inner favourites">
		<!-- FORM							-->
		<?php $url = $_SERVER["REQUEST_URI"]; ?>
		<form action="<?php echo $url; ?>" name="fontForm" method="post">
			<div class="form_user_footer_body">
				<table width="100%" cellpadding="6" cellspacing="0" border="1" bordercolor="#DDDDDD">
					<thead>
						<tr class="head-tr"  bgcolor="#25B7E9">
							<th>Sản phẩm</th>
							<th>Thêm  vào vào ngày</th>
							<th>Thêm vào giỏ hàng</th>
							<th><b>Xóa</b></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $item){?>
					<?php
					$favourite = $this -> get_favourite($item->id);
					$link_view = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_root_alias);
					$link_del = 'index.php?module=products&view=favourites&task=delete&id='.$item->id;
					$discount ='';		
					if($item -> is_hotdeal){
						if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
							$price = $item->price;
							$price_old = $item->price_old;
						}else{
							$price = $item->price_old;
							$price_old = '';
						}
					}else{
						$price= $item->price;
						$price_old = $item->price_old;
					}
					?>
						<tr>
							<td  class="td-img"> 
								<a class="pull-left"  href="<?php echo $link_view?>" >
									<img width="80px" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image)?>" alt="<?php echo $item->name;?>">
								</a>
								<div class="media-body">
									<h4 class="media-heading">
										<a href="<?php echo $link_view?>" ><?php echo $item->name;?></a>
									</h4>
									<?php echo ($item->warranty)?'Bảo hành '.$item->warranty:''?>
									<p class='price'><span class='red'><?php echo format_money($price, 'VNĐ');?> </span></p>
									<input type="hidden" id="price_calculator" name="price_calculator" value="<?php echo $price;?>" >
								</div>	
							</td>
							<td align="center"> 
								<span><?php echo date('d-m-Y ',strtotime($favourite -> created_time)); ?></span>
							</td>
							<td align="center"> 
								<a href="javascript: buy_add(<?php echo $item ->id; ?>)" class="button buy_add"> <span class="icon"></span> Thêm vào giỏ hàng</a>
							</td>
							<td align="center" class="remove-fav">
								<a href="javascript: onTask('<?php echo $link_del; ?>','B&#7841;n ch&#7855;c ch&#7855;n mu&#7889;n x&#243;a')">
									<img src="<?php echo  URL_ROOT.'images/remove_fav.png';?>" alt="del"  />
								</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					
				</table>	
			</div>
		</form>			
	</div>

<script type="text/javascript">
	function onTask(link,msg)
	{
		if(msg)
		{	
			if(confirm(msg))
			{
				window.location = link;	
			}
		}
	}
		
</script>