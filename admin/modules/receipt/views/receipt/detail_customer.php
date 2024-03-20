<table cellspacing="1" class="admintable">
    <div class="form-group" id="form_name">
        <label class="col-md-2 col-xs-12 control-label">Tên khách hàng</label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="name" id="name" value="<?php echo @$data-> name; ?>" size="60">
            <div class="inner_cus2">
                <div class="auto_cus2">
                </div>
                <span class="close_cus2">x</span>
            </div>
        </div>
    </div>
    <div class="form-group" id="form_phone">
        <label class="col-md-2 col-xs-12 control-label">Số điện thoại</label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo @$data-> phone; ?>" size="60">
            <div class="inner_cus">
                <div class="auto_cus">
                </div>
                <span class="close_cus">x</span>
            </div>
        </div>
    </div>
    <div class="form-group" id="form_imei">
        <label class="col-md-2 col-xs-12 control-label">IMEI máy</label>
        <div class="col-md-10 col-xs-12">
            <input type="text" class="form-control" name="imei" id="imei" value="<?php echo @$data-> imei; ?>" size="60">
            <div class="inner_cus3">
                <div class="auto_cus3">
                </div>
                <span class="close_cus3">x</span>
            </div>
        </div>
    </div>
</table>

<script>

    $('.close_cus').click(function(){
       $('.inner_cus').css('display','none');
   })
    $('.close_cus2').click(function(){
       $('.inner_cus2').css('display','none');
   })
    $('.close_cus3').click(function(){
       $('.inner_cus3').css('display','none');
   })

    $('#phone').keyup(function(){
        $('.inner_cus').css('display','block');
        var phone = $(this).val();
        $.ajax({
          type : 'get',
          url : 'index.php?module=receipt&view=receipt&raw=1&task=loadcustomer',
          dataType : 'html',
          data: {phone:phone},
          success : function(data){
            $('.auto_cus').html(data);
            if (data==''){
               $('.inner_cus').css('display','none');
           }
       },
       error : function(XMLHttpRequest, textStatus, errorThrown) {}
   });
       // alert('change');
   })

    $('#imei').keyup(function(){
        $('.inner_cus3').css('display','block');
        var phone = $(this).val();
        $.ajax({
          type : 'get',
          url : 'index.php?module=receipt&view=receipt&raw=1&task=loadcustomer3',
          dataType : 'html',
          data: {phone:phone},
          success : function(data){
            $('.auto_cus3').html(data);
            if (data==''){
               $('.inner_cus3').css('display','none');
           }
       },
       error : function(XMLHttpRequest, textStatus, errorThrown) {}
   });
       // alert('change');
   })



    $('#name').keyup(function(){
        $('.inner_cus2').css('display','block');
        var name = $(this).val();
        $.ajax({
          type : 'get',
          url : 'index.php?module=receipt&view=receipt&raw=1&task=loadcustomer2',
          dataType : 'html',
          data: {name:name},
          success : function(data){
            $('.auto_cus2').html(data);
            if (data==''){
               $('.inner_cus2').css('display','none');
           }
       },
       error : function(XMLHttpRequest, textStatus, errorThrown) {}
   });
       // alert('change');
   })

    function add_cus(phone, name, imei , device_name) {
        $('#phone').val(phone);
        $('#name').val(name);
        $('#imei').val(imei);
        $('#device_name').val(device_name);
        $('.inner_cus').css('display','none');
         $('.inner_cus2').css('display','none');
          $('.inner_cus3').css('display','none');
    }
</script>
<style>

.inner_cus {
    width: 50%;
    background: #fff;
    position: absolute;
    z-index: 99;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #888;
    display: none;
}
.auto_cus li {
    list-style: none;
    cursor: pointer;
}
.close_cus {
    top: 0px;
    right: 0px;
    display: inline-block;
    position: absolute;
    cursor: pointer;
    padding: 4px 8px;
    color: white;
    font-weight: bold;
    background: red;
    border-radius: 10px;
}

.close_cus:hover {
    background: blue;
}

.inner_cus2 {
    width: 50%;
    background: #fff;
    position: absolute;
    z-index: 99;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #888;
    display: none;
}
.auto_cus2 li {
    list-style: none;
    cursor: pointer;
}
.close_cus2 {
    top: 0px;
    right: 0px;
    display: inline-block;
    position: absolute;
    cursor: pointer;
    padding: 4px 8px;
    color: white;
    font-weight: bold;
    background: red;
    border-radius: 10px;
}
.close_cus2:hover {
    background: blue;
}

.inner_cus3 {
    width: 50%;
    background: #fff;
    position: absolute;
    z-index: 99;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #888;
    display: none;
}
.auto_cus3 li {
    list-style: none;
    cursor: pointer;
}
.close_cus3 {
    top: 0px;
    right: 0px;
    display: inline-block;
    position: absolute;
    cursor: pointer;
    padding: 4px 8px;
    color: white;
    font-weight: bold;
    background: red;
    border-radius: 10px;
}
.close_cus3:hover {
    background: blue;
}
</style>