<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('breadcrumbs_simple','blocks/breadcrumbs/assets/css');
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
			<?php foreach($breadcrumbs as $item){?>
			<li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
			
				<?php if(!$item[1]){?>
					
					<span itemprop="name"><?php echo $item[0]; ?></span>
					<meta content="<?php echo ($i + 2); ?>" itemprop="position">
				<?php } else {?>

					<a title='<?php echo $item[0]; ?>' href="<?php echo $item[1]; ?>" itemprop="item" >
						 <span itemprop="name"><?php echo $item[0]; ?></span>
						 <meta content="<?php echo ($i + 2); ?>" itemprop="position">
					</a>
				<?php }?>
				
			</li>
		
				<?php $i ++;?>								
			<?php }?>
	</ul>
</div>
<?php }?>

