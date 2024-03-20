<!-- //<script type="text/javascript" src="scripts/upload_image.js"></script> -->
<!-- //<p id="msg">Test</p> -->
<p id="msg"></p>
<input type="file" id="multiFilesimg" name="filesimg[]" multiple="multiple"/>
<label for="multiFilesimg" id="label_up_img">Chọn ảnh</label>
<!-- <button id="upload" type="button">Upload</button> -->

<div id="fileQueueimg"></div>
<div id="feedsimg"></div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('#label_up_img').on('click', function(){
          $('#msg').html('');   
        })
        $('#multiFilesimg').on('change', function () {
            var form_data = new FormData();
            var ins = document.getElementById('multiFilesimg').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("filesimg[]", document.getElementById('multiFilesimg').files[x]);
            }
            $.ajax({
                        url: 'index.php?module=partners&view=partners&raw=1&task=uploadAjaxImagespn&id=<?php echo $id;?>&data=<?php echo $uploadConfig;?>")', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            $('#fileQueueimg').html(response); // display success response from the PHP script
                            $("#feedsimg").load("index.php?module=partners&view=partners&raw=1&task=getAjaxImagespn&data=<?php echo $uploadConfig;?>");
                            $('#msg').html('Đã upload xong !');
                            
                        },
                        error: function (response) {
                            $('#fileQueueimg').html(response); // display error response from the PHP script
                            $("#feedsimg").load("index.php?module=partners&view=partners&raw=1&task=getAjaxImagespn&data=<?php echo $uploadConfig;?>");
                        }
                    });
        });
    });
    $("#feedsimg").load("index.php?module=partners&view=partners&raw=1&task=getAjaxImagespn&data=<?php echo $uploadConfig;?>");
</script>
<style>
#msg {
    color: #3da6ea;
    font-size: 15px;
}
#multiFilesimg {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
#multiFilesimg + label {
    font-size: 1.25em;
    font-weight: 700;
    color: white;
    background-color: black;
    display: inline-block;
    cursor: pointer;
    padding: 10px 20px;
   
    box-sizing: border-box;
    border-radius: 20px;
    transition: 0.5s;
}

#multiFilesimg:focus + label,
#multiFilesimg + label:hover {
    background-color: red;
}
</style>