<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="../libraries/uploadify/myuploadify.js"></script>
	<style>
		#sortableimg_Content {     list-style-type: none;
			margin: 0;
			padding: 0;
			display: flex;
			flex-wrap: wrap;
			align-listImagesContents: center; }
			#sortableimg_Content li { float: left;
				margin: 10px 10px 20px;
				cursor: move;
				text-align: center;
				background: #FFFFFF;
				width: calc(25% - 20px);}
				#sortableimg_Content li div{ margin:0px auto;}
				#sortableimg_Content span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
				#sortableimg_Content span:hover{ text-decoration:underline;}
				#sortableimg_Content font{ padding:0px 2px; color:#000000;}
				#sortableimg_Content li .image-area-single p{ margin: 0; padding: 0;}
				#sortableimg_Content li .image-area-single{background-color: #FFFFFF;
					border-radius: 3px;
					box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
					float: left;
					margin-right: 22px;
					padding: 10px;
					position: relative;}
					#sortableimg_Content li .image-area-single .img{ overflow:hidden;}
					#sortableimg_Content li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
					#sortableimg_Content li .image-area-single .del img{ opacity: 0.5;}
					#sortableimg_Content li .image-area-single .del img:hover{ opacity: 1;}
					.cls::after {
						content: '';
						display: block;
						clear: both;
					}
					.delete_Content{
						float: right;

					}
					.delete_Content a{
						font-size: 1.25em;
						font-weight: 700;
						color: white;
						background-color: #ff0000;
						display: inline-block;
						cursor: pointer;
						padding: 10px 20px;
						color: #fff !important;

						box-sizing: border-box;
						border-radius: 20px;
						transition: 0.5s;
					}
					.clear, .clearfix {
						clear: both;
					}
				</style>
			</head>
			<body>
				<?php if($listImagesContent){?>

					<div class="clear"></div>
					<?php
					$dd=substr($listImagesContent->img_menu, -3);
					$uploadConfig = base64_encode('edit|'.$listImagesContent->record_id);		
					?>
					<div id="feedsContent">
						<div id="sort_<?php echo $listImagesContent->id;?>">
							<div class="image-area-single">
								<p class="img">

									<img width="60px" height="60px" src="<?php echo URL_ROOT.str_replace('/original/','/small/',$listImagesContent -> img_menu)?>" alt="Ảnh">
								</p>

								<p class="del" align="center"><span onclick="removeElementimageContent('sort_<?php echo $listImagesContent->id;?>','<?php echo $listImagesContent->id; ?>')"><img src="../libraries/uploadify/delete.png"/></span></p>



							</div>

							<div class='clearfix'></div>	
						</div>
					</div>

				<?php } ?>

				<script type="text/javascript">
					function removeElementimageContent(divNum,data) {
						if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
							var d = document.getElementById('feedsContent');
							var olddiv = document.getElementById(divNum);
							$.ajax({
								url: "index.php?module=tutorial&view=tutorial&raw=1&task=delete_other_image_Content",
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


				</script>
			</body>
			</html>
