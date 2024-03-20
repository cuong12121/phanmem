<?php 
$tmpl -> addScript('related','modules/'.$this -> module.'/assets/css');
//$tmpl -> addStylesheet('cat_masory','modules/'.$this -> module.'/assets/css');
$tmpl -> addScript('masonry.pkgd','libraries/jquery/masonry/dist/');
$tmpl -> addScript('related_masory','modules/'.$this -> module.'/assets/js');
$tmpl -> addStylesheet('related','modules/'.$this -> module.'/assets/css');?>
<?php if($list_related && count($list_related)){?>
	<div class='vertical related'>
	<h3 class="relate_title"><span><?php echo $title_relate; ?></span></h3>
		<div class='related_content_wrapper'>
			<div class='related_content'>
			    <?php $tmp = 0; ?>
				<?php foreach($list_related as $item){ ?>
			        <?php $tmp++; ?>
					<?php $link     = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);?>
				
			        <div class="item ">					
				        <div class="item_inner">					
				            <?php if($item->image){?>
								<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
								<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
									<img alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>" />
								</a>
							<?php }?>
				            
				              <div class="price_area">
				                <div class='price'><?php echo format_money(@$item -> price).''?></div>
				            	<?php if($item -> price_old){?>
				            		<div class='price_old'><?php echo format_money($item -> price_old).''?></div>
				            	<?php }?>
				            	<div class='clear'></div>
				            </div>
				            <h3 class="name"><a  href="<?php echo $link;?>" title='<?php echo $item->name;?>'><?php echo $item->name;?></a></h3>
				            <div class='info_other'>
				            	<?php if($item->size_name){?>
				            		<span class='size'><?php echo $item -> size_name; ?></span>	
				            	<?php }?>
				            	<span class='like'><?php echo $item -> like; ?></span>
				            	<span class='comments_no'><?php echo $item -> comments_published; ?></span>
				             </div>
				            <div class='info_owner'>
				            	<span class='full_name'>
				            		<?php if($item -> user_image){?>
				            		<img alt="Thông tin người đăng" src="<?php echo URL_ROOT.$item -> user_image; ?>" width="27" height="27"/>	
					            	<?php }else{?>
					            		<img alt="Thông tin người đăng" src="<?php echo URL_ROOT.'images/no-avatar.jpg'; ?>" width="27" height="27"/>
					            	<?php }?>
				            		<font><?php echo $item -> user_full_name; ?></font>
				            	</span>
				            	<?php if($item -> user_city){?>
				            		<span class='user_city'><?php echo $item -> user_city; ?></span>
				            	<?php }?>
				            	<div class="clear"></div>
				             </div>
				        </div><!--end: .item-->
			        </div><!--end: .item-->
				<?php }//end: foreach($list as $item) ?>
		    
			</div><!--end: .related_content-->
		</div><!--end: .related_content_wrapper-->
	</div><!--end: .vertical-->
<?php } ?>
