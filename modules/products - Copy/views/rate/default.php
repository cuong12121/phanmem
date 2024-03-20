<?php global $tmpl,$is_mobile;
$tmpl -> addStylesheet('default','plugins/rates/assets/css');
$tmpl -> addStylesheet('rate','modules/products/assets/css');
$tmpl -> addScript('default','plugins/rates/assets/js');
$url = $_SERVER['REQUEST_URI'];
$module = FSInput::get ( 'module' );
$view = FSInput::get ( 'view' );
$rid = FSInput::get ( 'id' );

$return = base64_encode($url);
$tmpl -> addScript('form');


?>

<div class="full-screen-mobile"></div>
<div id="rate_preview">
	<div id="rates_rate">
		<div class='rates'>		
			<?php if(isset($data)){ ?>
				<div class='tab_label'><span>Có <strong><?php echo $data -> rates_published; ?></strong> đánh giá</span> <strong>về <?php echo isset($data -> name)?$data -> name:$data -> title; ?></strong>

				</div>
			<?php } ?>
			<div class="toprt">
				<div class="crt">
					<?php if(!$is_mobile){ ?>
						<div class="lcrt" >
		                        
		                        <div class="prd">
		                            <div class="left">
		                                <img src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $data -> image); ?>" >
		                            </div>
		                            <div class="right">
		                                <b><?php echo $data->name; ?></b>
		                                        <strong><?php echo format_money($data -> price).''?></strong>
		                                        <span class="hisprice"><?php echo format_money($data -> price_old).''?></span>
		                                <?php $link_vie = FSRoute::_('index.php?module=products&view=product&code='.$data -> alias.'&ccode='.$data->category_alias.'&id='.$data->id.'&cid='.$data->category_id); ?>
		                                <a href="<?php echo $link_vie; ?>" class="btn" title="Xem chi tiết">Xem chi tiết</a>
		                            </div>
		                        </div>
		                </div>
		             <?php } ?>
	              
						<div class="<?php echo !$is_mobile?'bcrt':'lcrt'; ?>">
							<?php if(!$is_mobile){ ?>
								<span>SAO TRUNG BÌNH</span>
							<?php } ?>
							
							<b><?php  $total_rate = ($count5*5 + $count4*4 + $count3*3 + $count2*2  + $count1*1); echo round($total_rate/$total,1);  ?> <i class="iconcom-star"></i></b>
						<?php if(!$is_mobile){ ?>
							<a href="javascript:showInputRating()">Gửi đánh giá của bạn</a>
						<?php } ?>
						
						</div>
				
					<div class="rcrt">
						<div class="r">
							<span class="t">5 <i></i></span>
							<div class="bgb">
								<div class="bgb-in" style="width: <?php echo $total?round(($count5/$total)*100):0; ?>%" ></div>
							</div>
							<span class="<?php echo $count5?'c':'n'; ?>" onclick="<?php echo $count5?'ratingCmtList('.$count5.',5)':''  ?>" data-buy="2"><strong><?php echo $count5; ?></strong> đánh giá</span>
						</div>

						<div class="r">
							<span class="t">4 <i></i></span>
							<div class="bgb">

								<div class="bgb-in" style="width: <?php echo $total?round(($count4/$total)*100):0; ?>%"></div>
							</div>
							<span class="<?php echo $count4?'c':'n'; ?>" onclick="<?php echo $count4?'ratingCmtList('.$count4.',4)':''  ?>" data-buy="0"><strong><?php echo $count4; ?></strong> đánh giá</span>
						</div>

						<div class="r">
							<span class="t">3 <i></i></span>
							<div class="bgb">
								<div class="bgb-in" style="width: <?php echo $total?round(($count3/$total)*100):0; ?>%"></div>
							</div>
							<span class="<?php echo $count3?'c':'n'; ?>" onclick="<?php echo $count3?'ratingCmtList('.$count3.',3)':''  ?>" data-buy="0"><strong><?php echo $count3; ?></strong> đánh giá</span>
						</div>

						<div class="r">
							<span class="t">2 <i></i></span>
							<div class="bgb">
								<div class="bgb-in" style="width: <?php echo $total?round(($count2/$total)*100):0; ?>%"></div>
							</div>
							<span class="<?php echo $count2?'c':'n'; ?>" onclick="<?php echo $count2?'ratingCmtList('.$count2.',2)':''  ?>" data-buy="0"><strong><?php echo $count2; ?></strong> đánh giá</span>
						</div>

						<div class="r">
							<span class="t">1 <i></i></span>
							<div class="bgb">
								<div class="bgb-in" style="width: <?php echo $total?round(($count1/$total)*100):0; ?>%"></div>
							</div>
							<span class="<?php echo $count1?'c':'n'; ?>" onclick="<?php echo $count1?'ratingCmtList('.$count1.',1)':''  ?>" data-buy="0"><strong><?php echo $count1; ?></strong> đánh giá</span>
						</div>

					</div>
					<?php if($is_mobile){ ?>
						<div class="bcrt">
							<a href="javascript:showInputRating()">Gửi đánh giá của bạn</a>
						</div>
					<?php } ?>
					
				</div>
				<div class="clr"></div>


				<?php include 'rates_form.php'; ?>

			</div>
			<div id="_info_rate" class="cls">
				<?php include 'rates_tree.php'; ?>

			</div>
			


		</div>
	</div>
</div>

