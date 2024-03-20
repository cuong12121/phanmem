<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="../libraries/uploadify/myuploadify.js"></script>
	<style>
		#sortableImagesVideoReview { list-style-type: none; margin: 0; padding: 0; }
		#sortableImagesVideoReview li {  margin:10px 10px 20px; cursor:move; text-align: center;background:#FFFFFF;}
		#sortableImagesVideoReview li div{ margin:0px auto;}
		#sortableImagesVideoReview span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
		#sortableImagesVideoReview span:hover{ text-decoration:underline;}
		#sortableImagesVideoReview font{ padding:0px 2px; color:#000000;}
		#sortableImagesVideoReview li .image-area-single p{ margin: 0; padding: 0;}
		#sortableImagesVideoReview li .image-area-single{background-color: #FFFFFF;
			border-radius: 3px;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
			float: left;
			margin-right: 22px;
			padding: 10px;
			position: relative;}
			#sortableImagesVideoReview li .image-area-single .img{ overflow:hidden;}
			#sortableImagesVideoReview li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
			#sortableImagesVideoReview li .image-area-single .del img{ opacity: 0.5;}
			#sortableImagesVideoReview li .image-area-single .del img:hover{ opacity: 1;}
		</style>
	</head>
	<body>
		<ul id="sortableImagesVideoReview">
			<?php if($listImagesVideoReview){?>
				<?php foreach($listImagesVideoReview as $item){ 
					$dd=substr($item->image, -3);
			?>
				<li id="sort_item_video_review_<?php echo $item->id;?>">
					<div class="image-area-single">
						<p class="img">
						  <img width="210" height="120" src="<?php echo URL_ROOT.$item->image;?>" alt="Ảnh">
						</p>
						<p class="del" align="center"><span onclick="removeElementimage('sort_item_video_review_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><img src="../libraries/uploadify/delete.png"/></span></p>
					</div>
					<input style="width: 300px; float: left;margin-right: 10px;" name="titleElement" placeholder="Tiêu đề" id="titleElement" onchange="addTitleElementimage(this.value,'sort_item_video_review_<?php echo $item->id;?>','<?php echo $item->id; ?>')" value="<?php echo $item->title;?>" />
	
					<input style="width: 300px; float: left;margin-right: 10px;" name="linkElement" placeholder="Link" id="linkElement" onchange="addLinkElementimage(this.value,'sort_item_video_review_<?php echo $item->id;?>','<?php echo $item->id; ?>')" value="<?php echo $item->link;?>" />

					<div class='clearfix'></div>	
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
<script type="text/javascript">
	function addLinkElementimage(linkElement,divNum,data) {
		$.ajax({
			url: "index2.php?module=products&view=products&raw=1&task=addLinkAjaxImagesVideoReview",
			type: "get",
			data: "data="+data+"&linkElement="+linkElement,
			error: function(){
				alert("Không thêm được dữ liệu (-.-)");
			}
		});
	}



	function addTitleElementimage(titleElement,divNum,data) {
		$.ajax({
			url: "index2.php?module=products&view=products&raw=1&task=addTitleAjaxImagesVideoReview",
			type: "get",
			data: "data="+data+"&titleimage="+titleElement,
			error: function(){
				alert("Không thêm được dữ liệu (-.-)");
			}
		});
	}

	function removeElementimage(divNum,data) {
		if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
			var d = document.getElementById('sortableImagesVideoReview');
			var olddiv = document.getElementById(divNum);
			// alert(divNum);
			$.ajax({
				url: "index.php?module=products&view=products&raw=1&task=deleteAjaxImagesVideoReview",
				type: "get",
				data: "data="+data,
				error: function(){
					alert("Lỗi xoa dữ liệu");
				},
				success: function(){

					d.removeChild(olddiv);
				}
			});
		}else{
			return false;
		}
	}
	$(function() {
		$("#sortableImagesVideoReview").sortable({
			update : function () {
				serial = $('#sortableImagesVideoReview').sortable('serialize');
				$.ajax({
					url: "index2.php?module=products&view=products&raw=1&task=sortAjaxImagesVideoReview",
					type: "post",
					data: serial,
					error: function(){
						alert("Lỗi load dữ liệu");
					}
				});

			}
		});
		
	});
</script>
</body>
</html>