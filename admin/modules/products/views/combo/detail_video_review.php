<div style="color: red">Nhập ảnh có kích thước 500 x 286 px</div>
<p id="msgVideoReview"></p>
<input type="file" id="multiFilesVideoReview" name="files_video_review[]" multiple="multiple"/>
<label for="multiFilesVideoReview" id="label_up_Video_Review">Chọn ảnh</label>
<div id="fileQueueVideoReview"></div>
<div id="feedsVideoReview"></div>
<script type="text/javascript">
    
        $('#label_up_Video_Review').on('click', function(){
          $('#msgVideoReview').html('');   
      })
        $('#multiFilesVideoReview').on('change', function () {
            // alert(11);
            var form_data = new FormData();
            var ins = document.getElementById('multiFilesVideoReview').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("files_video_review[]", document.getElementById('multiFilesVideoReview').files[x]);
            }
            $.ajax({

                        url: 'index.php?module=products&view=products&raw=1&task=uploadAjaxVideoReview&data=<?php echo $uploadConfig;?>")', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            $('#fileQueueVideoReview').html(response); // display success response from the PHP script
                            $("#feedsVideoReview").load("index.php?module=products&view=products&raw=1&task=getAjaxImagesVideoReview&data=<?php echo $uploadConfig;?>");
                            $('#msgVideoReview').html('Đã upload xong !');
                            
                        },
                        error: function (response) {
                            $('#fileQueueVideoReview').html(response); // display error response from the PHP script
                            $("#feedsVideoReview").load("index.php?module=products&view=products&raw=1&task=getAjaxImagesVideoReview&data=<?php echo $uploadConfig;?>");
                        }
                    });
        });
  
    $("#feedsVideoReview").load("index.php?module=products&view=products&raw=1&task=getAjaxImagesVideoReview&data=<?php echo $uploadConfig;?>");
</script>
<style>
    #msgVideoReview {
        color: #3da6ea;
        font-size: 15px;
    }
    #multiFilesVideoReview {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    #multiFilesVideoReview + label {
        font-size: 1.25em;
        font-weight: 700;
        color: white;
        background-color: black;
        display: inline-block;
        cursor: pointer;
        padding: 10px 20px;
        box-sizing: bỏ;
        box-sizing: border-box;
        border-radius: 20px;
        transition: 0.5s;
    }

    #multiFilesVideoReview:focus + label,
    #multiFilesVideoReview + label:hover {
        background-color: red;
    }
</style>