<div class=" col-modal-r">
  <label class="mt20">Nhập thông tin của bạn</label>
  <div class="input_text_wrap">
    <input type="text" name="sender_name" id="sender_name" placeholder="Họ và tên"  value="" required type="text" class="input_text" />
  </div>
  <div class="input_text_wrap">
    <input type="text" name="sender_telephone" id="sender_telephone"  placeholder="Điện thoại"  value="" type="tel"  pattern="[0-9]{10}" required class="input_text" />
  </div>
  <div class="input_text_wrap">
    <input type="text" name="sender_email" type="email" id="sender_email"  placeholder="Email"  value="" required class="input_text"  pattern="[a-zA-Z0-9.!#$%&amp;’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+" />
  </div>
  <div class="input_text_wrap">
    <input type="text" name="sender_address" id="sender_address" placeholder="Địa chỉ" value="" class="input_text" />
  </div>

                  <div class="input_text_wrap">
                    <?php $arr_certificates = array(1=>'CMND + Hộ Khẩu',2=>'CMND + Bằng lái xe',3=>'Giấy tờ chứng minh thu nhập',4=>'Sinh viên',5=>'Công chức - Giáo viên'); ?>
                    <select class="customer-option" name="instalment_certificate">
                        <?php foreach($arr_certificates as $key => $name){?>
                          <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                        <?php } ?>                        
                    </select>
                   </div> 

  <div class="input_text_wrap">
    <textarea name="sender_comments" class="input_text" placeholder="Lời nhắn"></textarea>
  </div>

           
</div>            