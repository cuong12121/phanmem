<?php 
global $tmpl, $config, $is_mobile;
$tmpl -> addScript("jquery.autocomplete.min","blocks/search/assets/js");
$tmpl -> addStylesheet('search','blocks/search/assets/css');
$tmpl -> addScript("search.min","blocks/search/assets/js");
?>
<?php $text_default = ""?>
<?php 
    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'products'){
    	$key = FSInput::get('keyword');
    	
    	if($key){
    		$keyword = $key;
    		$keyword = urldecode($keyword);
			$keyword = str_replace('+',' ',$keyword);
			
    	}
    }
?>
<div id="search" class="search search-contain s_close fr">
	<div class="search-content">
	<?php $link = FSRoute::_('index.php?module=products&view=search');?>
		    <form action="<?php echo $link; ?>" name="search_form" id="search_form" method="get" onsubmit="javascript: submit_form_search();return false;" >
				<input type="text" value="<?php echo $keyword; ?>" aria-label="Tìm kiếm sản phẩm" placeholder="<?php echo $is_mobile ? 'Tìm kiếm...' : 'Tìm kiếm sản phẩm...' ?>" id="keyword" name="keyword" class="keyword input-text" />

				<button type="submit" class="button-search button" aria-label="tìm kiếm">
					<svg aria-hidden="true" data-prefix="far" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-search fa-w-16"><path d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" class=""></path></svg>
				</button>

	            <input type='hidden'  name="module" value="news"/>
		    	<input type='hidden'  name="module" id='link_search' value="<?php echo FSRoute::_('index.php?module=products&view=search&keyword=keyword'); ?>" />
				<input type='hidden'  name="view" value="search"/>
				<input type='hidden'  name="Itemid" value="10"/>
			</form>
	</div>
  
</div>