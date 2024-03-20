
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php  
	global $tmpl;
	$tmpl->addStylesheet('template');?>
	<?php    $tmpl->loadHeader();?>
	<script language="JavaScript" type="text/javascript">
		//function select_print()
//		{
//			html =  document.getElementById('print').innerHTML;
//			area_show =  document.getElementById('print-content-raw');
//			area_hidden =  document.getElementById('print-content');
//			area_show.innerHTML = html;
//			document.getElementById('print').innerHTML = "";
//		}
	</script>
</head>
<!--
	Huy:
	Print in scope: id="print"
-->
<body <?php /*?>onload="select_print()"<?php */?> style="width:1024px;margin:0px auto;">

	<div class='print-head'>
		<a href=""><?php echo URL_ROOT; ?></a>
		<hr/>
	</div>
	
	<!-- MAIN					-->
	<div class='print-body'>
		<div id="print-content-raw">
		</div>
		<div id="print-content" >
				<?php  echo $main_content; ?>
		</div>
	</div>
	<!-- end MAIN					-->
	<div style="clear: both;"></div>
	<div class='print-footer'>
		<div style="background: none repeat scroll 0% 0% rgb(238, 238, 238); padding: 5px;">
			<a href="javascript:window.print();">
				<img border="0" style="cursor: pointer;" src="<?php echo  URL_ROOT.'templates/default/images/print_site.png'; ?>" alt="" />
				</a>
			<hr/>
			<div style="font-family: Arial; font-size: xx-small;"> 
				Copyright 2010 <?php echo URL_ROOT;?>
			</div>
		</div>
	</div>		
</body>
</html>