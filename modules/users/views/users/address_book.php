<?php
global $tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('address_book','modules/users/assets/js');
$tmpl -> addStylesheet("address_book","modules/users/assets/css");
$tmpl -> addStylesheet("add_address","modules/users/assets/css");
?>
<?php include 'menu_user.php'; ?>
<div class="user_content">
	<h2 class='head_content'>
		Sổ địa chỉ
	</h2>
	<div class="user_content_inner2">
		<a class="button_add_address btn" href="javascript: add_address()"><span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 492 492" style="enable-background:new 0 0 492 492;" xml:space="preserve">
			<g>
				<g>
					<path d="M465.064,207.566l0.028,0H284.436V27.25c0-14.84-12.016-27.248-26.856-27.248h-23.116    c-14.836,0-26.904,12.408-26.904,27.248v180.316H26.908c-14.832,0-26.908,12-26.908,26.844v23.248    c0,14.832,12.072,26.78,26.908,26.78h180.656v180.968c0,14.832,12.064,26.592,26.904,26.592h23.116    c14.84,0,26.856-11.764,26.856-26.592V284.438h180.624c14.84,0,26.936-11.952,26.936-26.78V234.41    C492,219.566,479.904,207.566,465.064,207.566z"/>
				</g>
			</g>
		</svg>Thêm địa chỉ mới</span></a></div>
		<div class="tab_content"></div>
		<div class="list_address cls">
			<?php 
			// print_r($address_book);die;
			if(!empty($address_book)){?>
				<?php foreach ($address_book as $item){ ?>
					<div class="address_item">
						<div class=" row_edit">
							<a class="button_address_other" href="javascript: edit_add_other(<?php echo $item->id;?>)"><font color="#1B99E9">Chỉnh sửa</font></a>
							<?php if(!$item-> is_default) { ?>
								<a class="button_address_remove" href="javascript: remove_address(<?php echo $item->id;?>)"><font color="#1B99E9">Xóa</font></a>
							<?php } ?>
						</div>
						<div class="name">
							<?php echo $item-> full_name; ?>
							<?php if($item-> is_default) { ?>
								<span class="default"><svg x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
									<g>
										<g>
											<path d="M383.841,171.838c-7.881-8.31-21.02-8.676-29.343-0.775L221.987,296.732l-63.204-64.893    c-8.005-8.213-21.13-8.393-29.35-0.387c-8.213,7.998-8.386,21.137-0.388,29.35l77.492,79.561    c4.061,4.172,9.458,6.275,14.869,6.275c5.134,0,10.268-1.896,14.288-5.694l147.373-139.762    C391.383,193.294,391.735,180.155,383.841,171.838z"/>
										</g>
									</g>
									<g>
										<g>
											<path d="M256,0C114.84,0,0,114.84,0,256s114.84,256,256,256s256-114.84,256-256S397.16,0,256,0z M256,470.487    c-118.265,0-214.487-96.214-214.487-214.487c0-118.265,96.221-214.487,214.487-214.487c118.272,0,214.487,96.221,214.487,214.487    C470.487,374.272,374.272,470.487,256,470.487z"/>
										</g>
									</g>
								</svg>Địa chỉ mặc định</span>
							<?php } ?>
						</div>
						<div class="name_address"><span>Địa chỉ: </span>
							<?php echo $item-> address.' '.$item-> ward_name.' '.$item-> district_name.' '.$item-> city_name; ?>
						</div>
						<div class="phone">
							<span>Điện thoại: </span><?php echo $item-> telephone; ?>
						</div>
						<div class="tab_content_address tab_content_<?php echo $item-> id; ?>"></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
