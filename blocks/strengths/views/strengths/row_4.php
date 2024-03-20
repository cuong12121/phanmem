<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('row_4','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>

	<div class="block-strengths block-strengths-row-4">
		<?php foreach($list as $item){ ?>
			<div class="item">
				<a class="icon" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> icon; ?></a>
				<div class="content-right">
					<h3><a class="title" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> title; ?></a></h3>
					<a class="summary" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> title2; ?></a>
				</div>
			</div>

		<?php } ?>
	</div>

