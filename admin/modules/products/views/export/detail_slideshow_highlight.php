<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/dropzone/dist/min/dropzone.min.css" />
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/dropzone/fs/dropzone.css" />
<script type="text/javascript" src="../libraries/jquery/dropzone/dist/min/dropzone.min.js">
	alert(1234);
</script>
<script type="text/javascript" src="../libraries/uploadify/jquery.uploadify.js"></script> 	
<script></script>	
<?php 

$Itemid_detail = 31;
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
if(isset($data->id) && $data->id){
	$uploadConfig = base64_encode('edit|'.$data->id);
}else{
	$uploadConfig = base64_encode('add|'.session_id());	
}
$arr_sku_map = array(); 
			$i= 0;
			if(isset($slideshow_highlight) && $slideshow_highlight){
				foreach ($slideshow_highlight as $item) {
					$arr_sku_map['Data'][$i]['AttachmentID']=$item->id;
					$arr_sku_map['Data'][$i]['FileName']=$item->title;
					$arr_sku_map['Data'][$i]['Path'] = URL_ROOT.str_replace('/original/','/original/', $item->image) ;
					$arr_sku_map['Data'][$i]['ColorId'] = $item->color_id;
					$i++;
				}
			}
			$skuConfig_slideshow_highlight  = json_encode($arr_sku_map);
			
?>
<script>
$(function() {	
					$("#previews_slideshow_highlight").sortable({
						update : function () {
							serial_slideshow_highlight = $("#previews_slideshow_highlight").sortable("serialize");
							$.ajax({
								url: "index2.php?module=products&view=products&raw=1&task=sort_other_slideshow_highlight",
								type: "post",
								data: serial_slideshow_highlight,
								error: function(){
									alert("Lỗi load dữ liệu");
								}
							});

						}
					});
					
				});
$(document).ready(function() {


			   	var data ='<?php echo $skuConfig_slideshow_highlight; ?>';
				var previewNode_slideshow_highlight = document.querySelector("#template_slideshow_highlight");
				var uploadConfig_slideshow_highlight =  $("#uploadConfig_slideshow_highlight").val();
				previewNode_slideshow_highlight.id = "";
				var previewTemplate_slideshow_highlight = previewNode_slideshow_highlight.parentNode.innerHTML;
				previewNode_slideshow_highlight.parentNode.removeChild(previewNode_slideshow_highlight);
				
				var myDropzone_slideshow_highlight = new Dropzone('#previews_slideshow_highlight', { // Make the whole body a dropzone
//					autoProcessQueue: false,
//					  uploadMultiple: true,
//					  parallelUploads: 100,
//					  maxFiles: 100,
				  url: "index2.php?module=products&view=products&raw=1&task=upload_other_slideshow_highlight&data="+uploadConfig_slideshow_highlight,
				  thumbnailWidth: 100,
				  thumbnailHeight: 100,
				  parallelUploads: 20,
				  previewTemplate: previewTemplate_slideshow_highlight,
				  autoQueue: true, 
				  previewsContainer: "#previews_slideshow_highlight", 
				  clickable: ".fileinput-button_slideshow_highlight", 
				  removedfile: function(file) {
				  		
					  	var record_id = $("#id_mage_slideshow_highlight").val();
					    $.ajax({
					        type: "POST",
					        url: "index2.php?module=products&view=products&raw=1&task=delete_other_slideshow_highlight",
					        data: { "name": file.name,"record_id":record_id,"id":file.size}
					    });
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
				  },
				  

				  init: function () {
					  	data = JSON.parse(data);
	                	var thisDropzone = this;
	                    if (data.Data != "") {
	                        $.each(data.Data, function (index, item) {
	                                var mockFile = {
	                                    name: item.FileName,
	                                    size: item.AttachmentID,
	                                    // ColorId: item.ColorId
	                                };
	                                thisDropzone.emit("addedfile", mockFile);
	                                thisDropzone.emit("thumbnail", mockFile, item.Path);
	                                thisDropzone.emit("complete", mockFile);

	                                // On the created element added the id property 
         							$(mockFile.previewElement).prop("id", "sort_"+item.AttachmentID);
         						
	
	                        });
	                    }
	                    this.on("success", function(file, response) {
	                    	response = JSON.parse(response);
	                    	file.previewElement.id = "sort_"+response.id;
	                    });
	           	 }
				});

				
			  });
			 
// function change_color(element){
// 	value = $(element).val();
// 	parent_id =  $(element).parent().attr('id');
// 	id =  parent_id.replace("sort_", "");
// 	var uploadConfig =  $("#uploadConfig").val();
// 	 $.ajax({
//         type: "POST",
//         url: "index2.php?module=products&view=products&raw=1&task=change_attr_slideshow_highlight",
//         data: { "field": "color","data":uploadConfig,"id":id,"value":value}
//     });
// 	 element.style.backgroundColor=element.options[element.selectedIndex].style.backgroundColor;
// }
</script>


<div class="dropzone files" id="previews_slideshow_highlight" >
	<div  id="template_slideshow_highlight" class="dz-preview dz-image-preview">
		<div class="dz-details">
			<img data-dz-thumbnail />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
		<a class="dz-remove"  data-dz-remove id="">Remove</a>
			
	
	</div>
				
</div>
<input type="hidden" value="<?php echo $uploadConfig; ?>" id="uploadConfig_slideshow_highlight" />
<input type="hidden" value="<?php if(isset($id)){echo $id;} ?>" id="id_mage_slideshow_highlight" />
<span class="post_images_slideshow_highlight fileinput-button_slideshow_highlight">Thêm ảnh/video</span>

