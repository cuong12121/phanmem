<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form method="post" action="/index.php?module=order&view=order&task=update_pack_order" enctype="multipart/form-data">
		<div class="form-group">
		    <label class="col-md-2 col-xs-12 control-label">File excel</label>
		    <div class="col-md-10  col-xs-12">
		        <div class="fileUpload btn btn-primary ">
		            <span><i class="fa fa-cloud-upload"></i> Upload</span>
		            <input type="file" id="file_pdf" class="upload" name="file_pdf[]" multiple="">
		        </div>
		        
		    </div>
		</div>
		<button type="submit">save</button>
	</form>
</body>
</html>