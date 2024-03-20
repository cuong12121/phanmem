<link href="<?php echo URL_ADMIN; ?>templates/default/css/select2-bootstrap.min.css" rel="stylesheet">
<link href="<?php echo URL_ADMIN; ?>templates/default/css/jquery-confirm.min.css" rel="stylesheet">
<link href="<?php echo URL_ADMIN; ?>templates/default/css/select2.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/select2.min.js"></script>
<div id="boxCustomer">
    <div class="card-header cls">
        <ul class="tab-customer">
            <li class="active">Khách hàng</li>
        </ul>
        <div class="header-elements cls">
            <!-- Nhân viên bán hàng -->
            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['id_card'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Nhân viên bán hàng'),'saleman',@$data -> saleman,0,$saleman,$field_value = 'id', $field_label='fullname',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>
            <!-- Nhân viên kỹ thuật -->
            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_user'] ?>
                        </div>
                    </div>
                    <?php 
                        TemplateHelper::dt_edit_selectbox(FSText::_('Nhân viên kỹ thuật'),'technicalStaff',@$data -> technicalStaff,0,$technicalStaff,$field_value = 'id', $field_label='fullname',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapLevelGroupCustomer cls">
        <div class="row-custom">
            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['phone_call'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Điện thoại (F4)'),'customer_phone',@$data -> customer_phone);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['icon_user'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Tên khách'),'customer_name',@$data -> customer_name);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['credit_card'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Mã thẻ'),'customer_card',@$data -> customer_card);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['icon_pen'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Ghi chú'),'note',@$data -> note,'',60,2);
                    ?>
                </div>
            </div>
        </div>

        <!-- col2 -->

        <div class="row-custom">
            <!-- Thành phố -->
            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_map'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Thành phố'),'customer_city',@$data -> customer_city,0,$cities,$field_value = 'id', $field_label='name',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>

            <!-- Quận huyện -->
            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_map'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Quận huyện'),'customer_district',@$data -> customer_district,0,'',$field_value = 'id', $field_label='name',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>

            <!-- Phường xã -->
            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_map'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Phường xã'),'customer_ward',@$data -> customer_ward,0,'',$field_value = 'id', $field_label='name',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['icon_home'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Địa chỉ'),'customer_address',@$data -> customer_address,'',60,2);
                    ?>
                </div>
            </div>
        </div>


        <!-- col3 -->

        <div class="row-custom">
            <div class="form-group-custom">
                <div class="form-group-2-input cls">
                    <div class="input-1">
                        <select name="customer_sex" class="input-1-1">
                            <option value="0">--Giới tính--</option>
                            <option value="1">--Nam--</option>
                            <option value="2">--Nữ--</option>
                            <option value="3">--Khác--</option>
                        </select>
                    </div>
                    <div class="input-2">
                        <input class="input-1-2" type="text" name="customer_birthday" id="customer_birthday" placeholder="Ngày sinh">
                    </div>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="form-group-2-input cls">
                    <div class="input-1">
                        <input class="input-1-1" type="text" name="customer_email" id="customer_email" placeholder="Email">
                    </div>
                    <div class="input-2">
                        <input class="input-1-2" type="text" name="customer_facebook" id="customer_facebook" placeholder="Facebook">
                    </div>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['icon_building'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Công ty'),'customer_building',@$data -> customer_building);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text px-2" >
                            <?php echo $config['icon_hashtag'] ?>
                        </div>
                    </div>
                    <?php 
                       TemplateHelper::dt_edit_text_placeholder(FSText :: _('Mã số thuế'),'customer_tax',@$data -> customer_tax);
                    ?>
                </div>
            </div>
        </div>

        <!-- col4 -->
        <div class="row-custom">

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_user_search'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Nguồn khách'),'customer_source',@$data -> customer_source,0,'',$field_value = 'id', $field_label='name',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_user_group'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Nhóm'),'customer_group',@$data -> customer_group,0,'',$field_value = 'id', $field_label='name',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>

            <div class="form-group-custom">
                <div class="input_group cls">
                    <div class="input-group-icon">
                        <div class="input-group-text">
                            <?php echo $config['icon_rank'] ?>
                        </div>
                    </div>
                    <?php
                        TemplateHelper::dt_edit_selectbox(FSText::_('Cấp độ'),'customer_rank',@$data -> customer_rank,0,'',$field_value = 'id', $field_label='name',$size = 1,0,1,$comment = '',$sub_item = '',$class='chosen-select',$class_col1='col-md-2',$class_col2='col-md-10',$add_id = 0);
                    ?>
                </div>
            </div>
            

           
            <div class="form-group-custom">
                <a onclick="btn_save_customer()" class="btn-save-customer" href="javascript:void(0)"><?php echo $config['icon_user'] ?>Lưu khách hàng</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.select2').select2();
</script>