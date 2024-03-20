<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Msmobile product feed</title>
<style type="text/css">
table {
	border-collapse: collapse;
	
}

</style>
</head>

<body>
<table border="1" bordercolor="#EEE" cellpadding="10" cellspacing="0" width="200%">
	<tr style="font-weight:bold;">
		<td>ID</td>
		<td>ID2</td>
		<td>Item title</td>
		<td>Final URL</td>
		<td>Image URL</td>
		<td>Item subtitle</td>		
		<td>Item description</td>
		<td>Item category</td>
		<td>Price</td>
		<td>Sale price</td>
		
		<td>Contextual keywords</td>		
	
	</tr>
	


<?php foreach($list as $item){ ?>
	<?php $link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias); ?>
	<tr>
	<td><?php echo $item -> id; ?></td>
	<td><?php echo $item -> id; ?></td>
	<td><?php echo $item -> name; ?></td>
	<td><?php echo $link; ?></td>	
	<td><?php echo URL_ROOT.str_replace('/original/', '/large/', $item -> image); ?></td>
	
	<td>Nguyên Zin 100%</td>	
	<td>Bảo Hành Rơi Vỡ 13 Tháng</td>
	<td><?php  echo $item -> category_name; ?></td>	
	<td><?php echo  $item -> price; ?></td>
	<td><?php echo  $item -> price; ?></td>
	
	<td></td>
</tr>
<?php } ?>

</table>
</body>
</html>