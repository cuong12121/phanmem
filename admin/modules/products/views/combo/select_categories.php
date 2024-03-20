<?php 
	$title = FSText::_('L&#7921;a ch&#7885;n c&#225;c danh m&#7909;c'); 
	global $toolbar;
	$toolbar->setTitle($title);
?>

<div class="form_body">
	<div class="title">Chọn danh mục sản phẩm</div>
	<form method="post" name="adminForm" action="index.php?module=products&view=products&task=search" style="width: 353px;">
	<div class="filter_area">
		<table>
			<tbody>
				<tr>
					<td align="left">
						Tìm kiếm:
						<input id="search" class="text_area" type="text" value="<?php echo isset ($_REQUEST['keysearch']) ? $_REQUEST['keysearch'] : ''  ?>" name="keysearch">
					</td>
					<td>
						<button onclick="javascript: this.form.submit();">Tìm kiếm</button>
						<button onclick="document.getElementById('search').value=''; this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button>
					</td>
					</tr>
				</tbody>
		</table>
		</div>
	</form>	
	<div id="cssmenu">
		<ul class="navmenu cls">
			<?php echo $get_menu_tree;?>
		</ul> 
	</div>
</div>


<div class="clear"></div>


<style type="text/css">
	.clear{
		clear: bold;
	}
	#cssmenu .link_search {
	    display: inline-block;
	    margin-right: 20px;
	    font-weight: bold;
	}
	#cssmenu .navmenu{
		display: flex;
		flex-wrap: wrap;
		width: 100%;
		margin:0px -40px;
	}
	#cssmenu .level0{
		width: calc(100% / 3 - 80px);
		margin:0px 40px 20px;
		line-height: 26px;
		font-weight: bold;
	}
	#cssmenu li{
		position: relative;
	}

	#cssmenu a{
		color: #000 !important;
	}
	#cssmenu span{
		position: absolute;
	    right: 0px;
	    top: 0px;
	    display: inline-block;
	    border: 1px solid #000;
	    width: 20px;
	    height: 20px;
	    text-align: center;
	    cursor: pointer;
	    line-height: 17px;
    	font-size: 15px;
	}
	#cssmenu .sub-menu{
		display: none;
	}

	.display_open{
		display: block !important;
	}
</style>

<script type="text/javascript">
	$('#cssmenu span').click(function(){
		$(this).parent().find('>.sub-menu').toggleClass('display_open');
		$(this).toggleClass("minus");
		if($(this).hasClass('minus')){
			$(this).html('-');
		}else{
			$(this).html('+');
		}
	});


	function submitbutton(pressbutton,cid) {
		submitform(pressbutton,cid);
	}
	/**
	* Submit the admin form
	*/
	function submitform(pressbutton,cid){
		if (pressbutton) {
			url_current = window.location.href;
			url_current = url_current.replace('#','');
			if(cid)
				window.location.href=url_current+'&task='+pressbutton+'&cid='+cid;
			else
				window.location.href=url_current+'&task='+pressbutton;
			return;
		}
	}
</script>