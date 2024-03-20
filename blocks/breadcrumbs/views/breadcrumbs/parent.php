<?php
global $tmpl,$config, $is_mobile; 
$tmpl -> addStylesheet('parent','blocks/breadcrumbs/assets/css');
if($is_mobile){
	$tmpl -> addScript('parent','blocks/breadcrumbs/assets/js');
}

?>	
<?php if(isset($breadcrumbs) && !empty($breadcrumbs)){?>
<div class='breadcrumbs_wrapper' itemscope itemtype="http://schema.org/WebPage">
	<ul class="breadcrumb" itemscope="itemscope" itemtype="https://schema.org/BreadcrumbList">
	
		<li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
			<a title='<?php echo $config['site_name'] ?>' href="<?php echo URL_ROOT?>" itemprop="item" >
				 <span itemprop="name"><?php echo FSText::_('Trang chủ')?></span>
				 <meta content="1" itemprop="position">
			</a>
			
		</li>
		<?php $i = 0; ?>
			<?php foreach($breadcrumbs as $item){
				$link_rq = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			?>

			<li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
				<?php if(!$item[1]){?>
					<span itemprop="name"><?php echo $item[0]; ?></span>
					<meta content="<?php echo ($i + 2); ?>" itemprop="position">
				<?php } else {?>
					<a title='<?php echo $item[0]; ?>' href="<?php echo $item[1] == $link_rq ? 'javascript:void(0)' : $item[1];?>" itemprop="item" >
						<span itemprop="name"><?php echo $item[0]; ?></span>
						<meta content="<?php echo ($i + 2); ?>" itemprop="position">
					</a>
					<?php if(!empty($item[2])){ ?>
					<div class="parent_sub cls">
						<?php foreach ($item[2] as $it) { ?>
							<a href="<?php echo $it[1]== $link_rq ? 'javascript:void(0)' : $it[1]; ?>" title="<?php echo $it[0] ?>"><?php echo $it[0] ?></a>
						<?php } ?>
					</div>
					<?php } ?>
				<?php }?>
			</li>
		
				<?php $i ++;?>								
			<?php }?>
	</ul>
</div>
<?php }?>

