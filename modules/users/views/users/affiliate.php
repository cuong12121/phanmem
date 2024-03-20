<?php
global $tmpl, $config;
$tmpl -> addScript('form');
$tmpl -> addScript('affiliate','modules/users/assets/js');
$tmpl -> addStylesheet("affiliate","modules/users/assets/css");
?>
<?php include 'menu_user.php'; ?>
<div class="user_content">
	<h2 class='head_content'>
		<?php echo $config['intro_affiliate']; ?>
	</h2>
	<div class="user_content_inner user_have_point">
		<div class="dlink_affilate"><input type="text" id="link_affilate" readonly value="<?php echo URL_ROOT.'?affiliate='.$data-> affiliate_code; ?>"><a href="javascript:void(0)" onclick="copy_link_affilate()">Copy Link</a></div>
	</div>
</div>

<div class="user_content">
	<h2 class='head_content' id="title_head_content">
		Gửi link bán sản phẩm
	</h2>
	<div class="user_content_inner search_content">
		<div class="search">
			<input type="text" name="name_search" placeholder="Tên sản phẩm" id="name_search">
			<select name="cat_search" id="cat_search">
				<option value="0">Danh mục sản phẩm</option>
				<?php foreach ($cats_products as $cat) { ?>
					<option value="<?php echo $cat-> id; ?>"><?php echo $cat-> name ?></option>
				<?php } ?>
			</select>
			<a class="button_search" href="javascript:void(0)" onclick="search_products(1)">Tìm kiếm</a>
		</div>
		<div class="list_prducts"></div>
	</div>
</div>
