<table cellspacing="1" class="admintable">
	<div class="row">
        <div class="box-shadow-col cls product-info">
            <div class="title-col">
                Thông tin chung
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    TemplateHelper::dt_edit_text(FSText :: _('Tên(*)'),'name',@$data -> name,'','',1,0,FSText::_(""));
                ?>
                <div id="data-product-search">
                    <?php 
                        TemplateHelper::dt_edit_text(FSText :: _('Sản phẩm cha'),'parent_id_name',@$data -> parent_id_name,'','',1,0,"","","col-lg-2","col-lg-10 input-product-parent-id");
                    ?>
                    <input type="hidden" name="parent_id" value="" id="product-parent-id">
                    <div class="html-product-search"></div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_selectbox(FSText::_('Loại(*)'),'type_id',@$data -> type_id,0,$types,$field_value = 'id', $field_label='name',$size = 1,0,0,'','','','col-lg-4','col-lg-8');
                        ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_selectbox(FSText::_('Trạng thái'),'status_id',@$data -> status_id,0,$status,$field_value = 'id', $field_label='name',$size = 1,0,0,'','','','col-lg-4','col-lg-8');
                        ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Mã'),'code',@$data -> code,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Mã vạch'),'barcode',@$data -> barcode,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Giá nhập'),'import_price',@$data -> import_price,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('VAT(%)'),'vat',@$data -> vat,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Giá bán lẻ'),'price',@$data -> price,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Giá sỉ'),'price_wholesale',@$data -> price_wholesale,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Giá đón gói'),'price_pack',@$data -> price_pack,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Giá cũ'),'price_old',@$data -> price_old,'','',1,0,"","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-12 col-md-6">
                <?php 
                    
                    TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
                    
                    TemplateHelper::dt_edit_selectbox(FSText::_('Thương hiệu'),'manufactory',@$data -> manufactory,0,$manufactories ,$field_value = 'id', $field_label='name',$size = 1,0,1);
                ?>

                
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php 
                            TemplateHelper::dt_edit_text(FSText :: _('Khối lượng'),'shipping_weight',@$data -> shipping_weight,'','',1,0,"Gr","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php
                            TemplateHelper::dt_edit_text(FSText :: _('Đơn vị tính'),'unit',@$data -> unit,'','',1,0,"VD: cái, chiếc, hộp, lon, gói...","","col-lg-4","col-lg-8");
                        ?>
                    </div>
                </div>

                <div class="size-group cls">
                    <div class="lb">Kích thước (cm)</div>
                    <div class="box-fr cls">
                        <?php
                            TemplateHelper::dt_edit_text(FSText :: _('Dài'),'length',@$data -> length,'','',1,0,'Dài');
                            TemplateHelper::dt_edit_text(FSText :: _('Rộng'),'width',@$data -> width,'','',1,0,'Rộng');
                            TemplateHelper::dt_edit_text(FSText :: _('Cao'),'height',@$data -> height,'','',1,0,'Cao');
                        ?>
                    </div>
                </div>


                <?php
                    TemplateHelper::dt_edit_text(FSText :: _('Link hướng dẫn sử dụng'),'tutorial_link',@$data -> tutorial_link,'','',1,0,FSText::_(""));
                    TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image),100,100,'');
                ?>
            </div>
        </div>
       
    </div>
    <div class="row">
        <div class="col-12 col-md-6 box-shadow-col box-shadow-col-50">
            <div class="title-col">
                Bảo hành
            </div>
        	<?php 
                TemplateHelper::dt_edit_selectbox(FSText::_('Xuất xứ'),'origin_id',@$data -> origin_id,0,$origins ,$field_value = 'id', $field_label='name',$size = 1,0,1);
                TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ bảo hành'),'warranty_address',@$data -> warranty_address,'','',1,0,FSText::_(""));
                TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại'),'warranty_phone',@$data -> warranty_phone,'','',1,0,FSText::_(""));
                TemplateHelper::dt_edit_text(FSText :: _('Số tháng bảo hành'),'warranty',@$data -> warranty,'','',1,0,FSText::_(""));
                TemplateHelper::dt_edit_text(FSText :: _('Link video bảo hành'),'warranty_link',@$data -> warranty_link,'','',1,0,FSText::_(""));
                TemplateHelper::dt_edit_text(FSText :: _('Nội dung bảo hành'),'warranty_content',@$data -> warranty_content,'',650,300,1);
			?>
        </div>
        <div class="col-12 col-md-6 box-shadow-col box-shadow-col-50">
            <div class="title-col">
                Thuộc tính
            </div>
            <?php include_once 'detail_extend.php';?>
        </div>
    </div>

	<input id="data_id" type="hidden" value="<?php echo isset($data) ? $data->id : 0  ?>">
	<input id="cid" type="hidden" value="<?php echo isset($data) ? @$data -> category_id : @$cid  ?>">
</table>