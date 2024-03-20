<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/dropzone/dist/min/dropzone.min.css" />
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/dropzone/fs/dropzone.css" />


<script type="text/javascript" src="../libraries/jquery/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript" src="../libraries/uploadify/jquery.uploadify.js"></script>
			
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
			foreach ($images as $item) {
				$arr_sku_map['Data'][$i]['AttachmentID']=$item->id;
				$arr_sku_map['Data'][$i]['FileName']=$item->name;
				$arr_sku_map['Data'][$i]['Path'] = URL_ROOT.str_replace('/original/','/original/', $item->image) ;
//				$arr_sku_map['Data'][$i]['ColorId'] = $item->color_id;
				$i++;
			}
			$skuConfig  = json_encode($arr_sku_map);
			
?>
<script>
 $(function() {				
					$("#previews").sortable({
						update : function () {
							serial = $("#previews").sortable("serialize");
							$.ajax({
								url: "index2.php?module=images&view=images&raw=1&task=sort_other_images",
								type: "post",
								data: serial,
								error: function(){
									alert("Lỗi load dữ liệu");
								}
							});

						}
					});
					
				});
$(document).ready(function() {

			   	var data ='<?php echo $skuConfig; ?>';
				var previewNode = document.querySelector("#template");
				var uploadConfig =  $("#uploadConfig").val();
				previewNode.id = "";
				var previewTemplate = previewNode.parentNode.innerHTML;
				previewNode.parentNode.removeChild(previewNode);
				
				var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
//					autoProcessQueue: false,
//					  uploadMultiple: true,
//					  parallelUploads: 100,
//					  maxFiles: 100,
				  url: "index2.php?module=images&view=images&raw=1&task=upload_other_images&data="+uploadConfig,
				  thumbnailWidth: 100,
				  thumbnailHeight: 100,
				  parallelUploads: 20,
				  previewTemplate: previewTemplate,
				  autoQueue: true, 
				  previewsContainer: "#previews", 
				  clickable: ".fileinput-button", 
				  removedfile: function(file) {
				  		
					  	var record_id = $("#id_mage").val();
					    $.ajax({
					        type: "POST",
					        url: "index2.php?module=images&view=images&raw=1&task=delete_other_image",
					        data: { "name": file.name,"record_id":record_id,"id":file.size}
					    });
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
				  },
				  
//				  addedfile: function(file) {
//					  console.log('vvv');
//					    file.previewElement = Dropzone.createElement(this.options.previewTemplate);
//					    // Now attach this new element some where in your page
//					  },
				  init: function () {
					  	data = JSON.parse(data);
	                	var thisDropzone = this;
	                    if (data.Data != "") {
	                        $.each(data.Data, function (index, item) {
	                                var mockFile = {
	                                    name: item.FileName,
	                                    size: item.AttachmentID,
	                                    ColorId: item.ColorId
	                                };
	                                thisDropzone.emit("addedfile", mockFile);
	                                thisDropzone.emit("thumbnail", mockFile, item.Path);
	                                thisDropzone.emit("complete", mockFile);

//	                                 console.log(mockFile);
	                                // On the created element added the id property 
         							$(mockFile.previewElement).prop("id", "sort_"+item.AttachmentID);
         							$(mockFile.previewTemplate).find('.dz-color').val(item.ColorId);

//	                       			 $(mockFile.previewTemplate).find('.dz-color').style.backgroundColor = color_code;
//	                       			$('#sort_'+item.AttachmentID+' .dz-color').[0].style.backgroundColor = color_code;
//         							$(mockFile.previewTemplate).find('.dz-color').style.backgroundColor=$(mockFile.previewTemplate).find('.dz-color').options[select_index].style.backgroundColor;
//         							$(mockFile.previewTemplate).find('.dz-color').style.backgroundColor=$('#sort_'+item.AttachmentID+' .dz-color').options[select_index].style.backgroundColor;
	                        });
	                    }
	                    this.on("success", function(file, response) {
	                    	response = JSON.parse(response);
	                    	file.previewElement.id = "sort_"+response.id;
	                    });
	           	 }
				});

				
			  });
			 
</script>


<div class="dropzone files" id="previews" >
	<div  id="template" class="dz-preview dz-image-preview">
		<div class="dz-details">
			<img data-dz-thumbnail />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
		<a class="dz-remove"  data-dz-remove id="">Remove</a>
	</div>
				
</div>
<input type="hidden" value="<?php echo $uploadConfig; ?>" id="uploadConfig" />
<input type="hidden" value="<?php echo $id; ?>" id="id_mage" />
<span class="post_images fileinput-button">Thêm ảnh/video</span>

