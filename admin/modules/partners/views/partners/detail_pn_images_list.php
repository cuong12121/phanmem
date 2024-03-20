<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="../libraries/uploadify/myuploadify.js"></script>
    <style>
        #sortableimg { list-style-type: none; margin: 0; padding: 0; }
        #sortableimg li {  margin:10px 10px 20px; cursor:move; text-align: center;background:#FFFFFF;}
        #sortableimg li div{ margin:0px auto;}
        #sortableimg span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
        #sortableimg span:hover{ text-decoration:underline;}
        #sortableimg font{ padding:0px 2px; color:#000000;}
        #sortableimg li .image-area-single p{ margin: 0; padding: 0;}
        #sortableimg li .image-area-single{background-color: #FFFFFF;
		    border-radius: 3px;
		    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
		    float: left;
		    margin-right: 22px;
		    padding: 10px;
		    position: relative;}
        #sortableimg li .image-area-single .img{ overflow:hidden;}
        #sortableimg li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
        #sortableimg li .image-area-single .del img{ opacity: 0.5;}
        #sortableimg li .image-area-single .del img:hover{ opacity: 1;}
    </style>
</head>
<body>
<ul id="sortableimg">
	<?php if($listimages){?>
		<?php foreach($listimages as $item){ 
			$dd=substr($item->image, -3);

			?>
			<li id="sort_<?php echo $item->id;?>">
				<div class="image-area-single">
					<p class="img">

				<!-- <video width="320" height="240" controls>
				  <source src="<?php echo URL_ROOT.$item->image;?>" type="video/<?php echo $dd; ?>">
			
				</video> -->
				<img width="320" height="240" src="<?php echo URL_ROOT.$item->image;?>" alt="Ảnh">

					</p>
					<p class="del" align="center"><span onclick="removeElementimage('sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><img src="../libraries/uploadify/delete.png"/></span></p>
				</div>
				<textarea name="summary_other_image" placeholder="Mô tả ảnh nhập ở đây!" style="float: left;" cols="60" rows="8"  id="titleElement" onchange="addTitleElementimage(this.value,'sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><?php echo $item->summary;?></textarea>
				<div class='clearfix'></div>	
			</li>
		<?php } ?>
	<?php } ?>
</ul>
<script type="text/javascript">
function addTitleElementimage(titleElement,divNum,data) {

		$.ajax({
			url: "index.php?module=partners&view=partners&raw=1&task=add_title_other_imagess",
			type: "get",
			data: "data="+data+"&titleimage="+titleElement,
			error: function(){
				alert("Không thêm được tiêu đề (-.-)");
			}
		});
	}
function removeElementimage(divNum,data) {
	  if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
		  var d = document.getElementById('sortableimg');
		  var olddiv = document.getElementById(divNum);
		  $.ajax({
				url: "index.php?module=partners&view=partners&raw=1&id=<?php echo $item->record_id;?>&task=delete_other_imagess",
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
		$("#sortableimg").sortable({
			update : function () {
				serial = $('#sortableimg').sortable('serialize');
				$.ajax({
					url: "index.php?module=partners&view=partners&raw=1&task=sort_other_imagess",
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