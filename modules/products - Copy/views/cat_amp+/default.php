<?php 
	global $tmpl; 
	$tmpl -> addStylesheet('products_amp');
	$tmpl -> addStylesheet('cat_amp','modules/'.$this -> module.'/assets/css');
?>












	<div class="products-cat">
		<div class="field_title">
			<div  class="title-name">
				<div class="cat-title">
					<div class="cat-title-main" id="cat-<?php echo $cat_root -> alias;?>">
						<div class="title_icon">
							<i class="icon_v1"></i>
							<h1><?php echo $title; ?></h1>	
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<select class="order-select" name="order-select">
				<option value="">Sắp xếp theo</option>			             
				<?php 
				foreach($array_menu as $item) {
					$link = FSRoute::addParameters('sort',$item[0]);	
					?>
					<option <?php echo $sort == $item[0] ? 'selected="selected"':''; ?> value="<?php echo $link; ?>"><?php echo $item[1]?></option>
				<?php }?>	
			</select>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>

		<section class='products-cat-frame'> 
			<div class='products-cat-frame-inner description'>
				<?php if($description){?>
					<article class='cat_summary cls'>
						<?php  if(!IS_MOBILE){ ?>
							<?php if($tmpl->count_block('banner_cat_summary')) {?>
								<div class="banner_cat_summary">
									<?php  echo $tmpl -> load_position('banner_cat_summary','XHTML2'); ?>
								</div>
							<?php }?>
						<?php }?>
						<div class="summary_content">
							<?php echo $cat -> summary; ?>
						</div>
					</article>
				<?php }?>
				<?php include_once 'default_grid.php';?>
			</div>
		</section>
		<?php if($pagination) echo $pagination->showPagination(3); ?>
		<?php if($relate_news){?>
			<div id="prodetails_tab50" class="prodetails_tab">
				<?php 	
				$title_relate =  'Tin tức về '.$cat -> name;
				$relate_type = 3;
				$list_related = $relate_news;
				$blanks = 0;
				include 'news_related/vertical.php';
				?>
			</div>
		<?php }?>
		<div class="cat_description">
			<?php echo $cat-> description; ?>
		</div>
	</div>



	<?php include 'default_remarketing.php';?>