// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template_dropzone");
var uploadConfig =  $('#uploadConfig').val();
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "index2.php?module=product&view=product&raw=1&task=upload_other_images&data="+uploadConfig,
  thumbnailWidth: 100,
  thumbnailHeight: 100,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: true, // Make sure the files aren't queued until manually addeds
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
  removedfile: function(file) {
	  	var id = $('#id_mage').val();

	    $.ajax({
	        type: 'POST',
	        url: '/index.php?module=product&view=product&raw=1&task=delete_other_image',
	        data: { 'name': file.name,'id':id}
	    });
	var _ref;
	return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
  }

});
