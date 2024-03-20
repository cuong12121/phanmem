
  function load_form(){
    let phone = $("#phone_number").val();
      $.ajax({
    type: "POST",
    url: "/index.php?module=contents&view=contents&task=fetch_warranty&raw=1",
    data: {phone:phone,code:phone},
    cache: false,
    success: function(html){
      $("#box_search").html(html);
    }
  });
  }



warranty();
function warranty(){

  $('.warr_inner').click(function(){
    var id = $(this).attr('id');


    $('.warr_inner').removeClass('warr_active');
    $(this).addClass('warr_active');



    content_id = id.replace('title_','form_');


    $('.form_').addClass('hide');
    $('#'+content_id).removeClass('hide');
  });

  $('.title_inner_l').click(function(){
    $(this).parent().removeClass('be_r').addClass('be_l');
  });
  $('.title_inner_r').click(function(){
    $(this).parent().removeClass('be_l').addClass('be_r');
  });

  
}

$(document).ready( function(){

  check_code();

  $('#smform').click(function(){
    if(!check_Formsubmit()){
      return false;
      
      //document.buy_fast_form.submit();
    }
    else{
      $('#buy_fast_form').submit();
    }
    
  })

});

function check_code(){
  $('#code_buy_fast').blur(function(){
    if($(this).val() != ''){

      $.ajax({url: root+"index.php?module=home&task=ajax_check_code&raw=1",
        data: {code: $(this).val()},
        dataType: "text",
        success: function(result) {
          $('label.username_check').prev().remove();
          $('label.username_check').remove();
          if(result == 1){
            invalid('code_buy_fast','Mã máy này đã tồn tại. Bạn hãy nhập mã máy khác');
            $('#smform').addClass('hide');
          } else {
            valid('code_buy_fast');
            $('<br/><div class=\'label_success username_check\'>'+'Mã máy này được chấp nhận'+'</div>').insertAfter($('#code_buy_fast').parent().children(':last'));
            // alert('abc');
            $('#smform').removeClass('hide');
          }
        }
      });
    }
  });
}


function check_Formsubmit()
{
  $('label.label_error').prev().remove();
  $('label.label_error').remove();


  if(!notEmpty("name_buy_fast","Bạn phải nhập họ tên"))
  {
    return false;
  }
  if(!notEmpty("code_buy_fast","Bạn phải nhập mã máy"))
  {
    return false;
  }
  if(!notEmpty("telephone_buy_fast","Bạn phải nhập số điện thoại"))
  {
    return false;
  }
  if(!isPhone("telephone_buy_fast","Bạn nhập số điện thoại không hợp lệ")){

    return false;
  }
  // if(!notEmpty("message","Hãy nhập nội dung")){
  //  return false;
  
  else{
    $('#smform').prop("disabled", true);
    return true;
  }
  
}

