<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        #sortable_image { list-style-type: none; margin: 0; padding: 0; }
        #sortable_image li {  margin: 10px; cursor:move;  float: left; text-align: center;background:#FFFFFF;}
        #sortable_image li div{ margin:0px auto;}
        #sortable_image span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
        #sortable_image span:hover{ text-decoration:underline;}
        #sortable_image font{ padding:0px 2px; color:#000000;}
        #sortable_image li .image-area-single p{ margin: 0; padding: 0;}
        #sortable_image li .image-area-single{background-color: #FFF; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.25); padding:10px; position: relative;}
        #sortable_image li .image-area-single .img{ overflow:hidden;}
        #sortable_image li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
        #sortable_image li .image-area-single .del img{ opacity: 0.5;}
        #sortable_image li .image-area-single .del img:hover{ opacity: 1;}
    </style>
</head>
<body>
<ul id="sortable_image">
	<?php foreach($list_other_images as $item){ ?>
		<li id="sort_<?php echo $item->id;?>">
			<div class="image-area-single">
				<p class="img"><img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image)?>" /></p>
				<p class="del" align="center"><span onclick="remove_image('sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><img src="../libraries/uploadify/delete.png"/></span></p>
			</div>
		</li>
	<?php } ?>
</ul>
<script type="text/javascript">
function remove_image(divNum,data) {
	  if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
		  var d = document.getElementById('sortable_image');
		  var olddiv = document.getElementById(divNum);
		  $.ajax({
				url: "index2.php?module=<?php echo $this->module;?>&view=<?php echo $this->view;?>&raw=1&task=delete_other_image",
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
		$("#sortable_image").sortable({
			update : function () {
				serial = $('#sortable_image').sortable('serialize');
				$.ajax({
					url: "index2.php?module=<?php echo $this->module;?>&view=<?php echo $this->view;?>&raw=1&task=sort_other_images",
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