<?php global $tmpl;
	$tmpl -> addStylesheet('default','plugins/comments/assets/css');
	$tmpl -> addScript('default','plugins/comments/assets/js');
	$url = $_SERVER['REQUEST_URI'];
	$module = FSInput::get ( 'module' );
	$view = FSInput::get ( 'view' );
	$rid = FSInput::get ( 'id' );

	$return = base64_encode($url);



?>
<div class="full-screen-mobile"></div>


<div class='comments'>		
	<?php if(isset($data)){ ?>
		<div class='tab_label'><span>Có <strong><?php echo $data -> comments_published; ?></strong> bình luận, đánh giá</span> <strong>về <?php echo isset($data -> name)?$data -> name:$data -> title; ?></strong>
		
		</div>
	<?php } ?>
	<form method="post" class="comment_keyword_wrapper" onsubmit="return search_comment();">                
		<input type="text" id="comment_keyword" name="comment_keyword" placeholder="Tìm theo nội dung, người gửi...">		
		<button type="submit" class="button-search button">
			<svg aria-hidden="true" data-prefix="far" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-search fa-w-16"><path fill="currentColor" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" class=""></path></svg>
			
		</button>
	</form>
	<div id="_info_comment" class="cls">
		<?php if($view=='instalment'){ ?>
			<?php include 'comments_tree_instalment.php'; ?>
		<?php } else{?>
			<?php include 'comments_tree.php'; ?>
		<?php } ?>

	</div>
	<?php include 'comments_form.php'; ?>

		
</div>

