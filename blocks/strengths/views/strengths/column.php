<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('column','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>
<div class="title-block-strengths-column cls">
	<div class="right-tt">
		<div class="title">Cam kết chính hiệu bởi</div>
		<div class="summary cls">
			<div class="l-sum">
				<img src="<?php echo URL_ROOT . "images/config/xiaomiicon.png" ?>" alt="Xiaomi" />
			</div>
			<div class="r-sum">
				<div class="text">
					Xiaomi Word - Phố Vọng
				</div>
				<div class="location">Hà Nội</div>
			</div>
		</div>
	</div>
</div>

<div class="block-strengths-column-wan cls">
	<div class="wan-l">
		Thời gian bảo hành
	</div>
	<div class="wan-r">
		12 tháng
	</div>
</div>

<div class="block-strengths block-strengths-2 block-strengths-column">
	
	<?php foreach($list as $item){ ?>
		<div class="item">
			<a href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> icon; ?></a>
			<div class="content-right">
				<a class="title" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> title; ?></a>
				<a class="summary" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> summary; ?></a>
			</div>
		</div>
	<?php } ?>

	
</div>

