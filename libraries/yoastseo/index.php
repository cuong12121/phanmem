<script  type="text/javascript" src="<?php echo URL_ROOT ?>libraries/yoastseo/yoast.js"></script>
<script  type="text/javascript" src="<?php echo URL_ROOT ?>libraries/yoastseo/caret/position/jquery.caret.js"></script>
<link rel='stylesheet' type='text/css' href="<?php echo URL_ROOT ?>libraries/yoastseo/yoast.css" />
<div class="phan_tich">
	<p><strong style="color: #3da6ea; font-size: 20px;">Phân tích SEO : </strong><span id="text_point_seo"></span></p>
	<!-- <input type="hidden" name="point_seo" id="point_seo"> -->
	<input type="hidden" name="point_seo" id="point_seo" value="<?php echo $data-> point_seo; ?>">
	<div class="result_seo cls">
		<div class="result_seo_inner panel panel-danger">
			<div class="panel-heading">Các vấn đề</div>
			<div class="van_de panel-body">
			</div>
		</div>
		<div class="result_seo_inner panel panel-warning">
			<div class="panel-heading">Các cải tiến</div>
			<div class="cai_tien panel-body">
			</div>
		</div>
		<div class="result_seo_inner panel panel-success">
			<div class="panel-heading">Kết quả tốt</div>
			<div class="kq_tot panel-body">
			</div> 
		</div>
	</div>
	<input type="hidden" value="<?php echo URL_ROOT; ?>" id="url_root">
</div>
