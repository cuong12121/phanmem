<?php
	global $tmpl;
	$tmpl -> addStylesheet("menu_login","blocks/menu_login/assets/css");
?>
<?php $url_current = $_SERVER['REQUEST_URI'];?>
<?php $url_current = substr(URL_ROOT, 0, strlen(URL_ROOT)-1).$url_current; ?>
<div class='menu_login'>
	<div class='label menu_user'>
        <?php echo $_SESSION['username']; ?>
    <div class="clear"></div>
    </div>
	<ul>
	<?php $i=0; foreach($list_user as $name => $link){
	   $i++;
       ?>
		<?php
			$activated = 0; 
			if($link == $url_current){
				$activated = 1;
			}	
		?>
		<li class='menu_item menu_item0<?php echo $i; ?> <?php echo $activated?"activated":""?>'>
			<a href="<?php echo $link; ?>" title="<?php echo $name?>"><?php echo $name; ?></a>
		</li>
	<?php }?>
	</ul>	
</div>