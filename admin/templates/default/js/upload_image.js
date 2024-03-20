

    $('#upload_files').on('change',function(){

        $('#image_upload_form').ajaxForm({           
            target:'#images_preview',
            beforeSubmit:function(e){
                $('.image_uploading').show();
            },
            success:function(e){
                $('.image_uploading').hide();
                 alert("oke");
            },
            error:function(e){
                 alert("fasf");
            }
        }).submit();
    });


