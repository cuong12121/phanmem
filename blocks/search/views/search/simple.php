<?php 
global $tmpl;
// $tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery.ui');
// $tmpl -> addScript("jquery-ui","libraries/jquery/jquery.ui");
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
$tmpl -> addStylesheet('search_simple','blocks/search/assets/css');
$tmpl -> addScript("search_simple","blocks/search/assets/js");

$link = FSRoute::_('index.php?module=products&view=search');
?>
<?php 
    $text_default = FSText::_('');
    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'products'){
        $key = FSInput::get('keyword');
        if($key){
            $keyword = $key;
        }
    }
?>
<div id="lindo_f_mb" class="row"  data-spy="affix" data-offset-top="0">
<div class="col-xs-7 col-md-12">
<div id="search_simple" class="search_simple">
	<div class="search_simple_content">
		    <form action="<?php echo $link; ?>" name="search_form" id="search_form_simple" method="get" onsubmit="javascript: submit_form_search();return false;" >
		    	<input type="text" value="<?php echo $keyword; ?>"  placeholder="Tìm kiếm sản phẩm" id="keyword_simple" name="keyword_simple" class="keyword_simple input-text" />
		        <input type="submit" class="button-search  searchbt_simple" id='searchbt_simple' value="" />
       			<input type='hidden'  id='link_search_simple' value="<?php echo $link; ?>" />
		    </form>
	</div>
</div></div>
<div class="col-xs-3 col-md-12">
<div class="lindo_logo visible-xs">
<a href="http://msmobile.com.vn" title="msmobile">
<img src="http://msmobile.com.vn/images/logo-trang.png" alt="logo msmobile">
</a>
</div>
</div>

<?php /*?><div class="col-xs-7  visible-xs col-md-12">
<div id="search_simple" class="search_simple">
	<div class="search_simple_content">
		    <form action="<?php echo $link; ?>" name="search_form" id="search_form_simple" method="get" onsubmit="javascript: submit_form_search();return false;" >
		    	<input type="text" value="<?php echo $keyword; ?>"  placeholder="Bạn tìm gì..." id="keyword_simple" name="keyword_simple" class="keyword_simple input-text" />
		        <input type="submit" class="button-search  searchbt_simple" id='searchbt_simple' value="" />
       			<input type='hidden'  id='link_search_simple' value="<?php echo $link; ?>" />
		    </form>
	</div>
</div>

<p class="lindo_header_hotline">
<span class="hidden-xs">Tư vấn:</span> <a href="tel:19006893" title="19006893" rel="nofollow"><i aria-hidden="true" class="fa fa-phone"></i> 1900 6893</a>
</p>
</div>
<?php */?>
<div class="col-xs-2  visible-xs col-md-12">
<div class="push-button"><a rel="nofollow" class="" href="#menu_left">Menu</a></div>
</div>
</div>