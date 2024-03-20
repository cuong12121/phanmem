<?php $text_default = FSText::_('Enter keyword')?>
<?php 
    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'search'){
    	$key = FSInput::get('keyword');
    	if($key){
    		$keyword = $key;
    	}
    }
?>
<div class='search'>
    <form id="search_form" onsubmit="return false;" method="post" name="search_form" action="<?php echo URL_ROOT; ?>" >
	    <input type="text" onblur="if(this.value=='') this.value='<?php echo $text_default; ?>'" onfocus="if(this.value=='<?php echo $text_default; ?>') this.value=''" value="<?php echo $keyword; ?>" id="keyword" name="keyword" class="keyword" />
	    <input type="submit" id='searchbt' name='search' value="<?php echo FSText::_('Search')?>" />
	</form>
</div>