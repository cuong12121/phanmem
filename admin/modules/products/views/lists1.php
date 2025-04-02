<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .table-container {
            max-height: 400px; /* Giới hạn chiều cao bảng */
            overflow-y: auto; /* Cho phép cuộn dọc */
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
            position: sticky;
            top: 0; /* Giữ tiêu đề ở trên cùng */
            z-index: 10;
        }
        img {
            max-width: 50px;
            height: auto;
        }

        body #page-wrapper .btn-outline a{
            color: #fff;
        }
    </style>
</head>
<body>
<div class="form_head">
    <div id="wrap-toolbar" class="wrap-toolbar">
        <div class="fl">
            <h1 class="page-header">Products</h1>
            <!--end: .page-header -->
            <!-- /.row -->    
        </div>
        <div class="fr">
            <a class="toolbar" onclick="javascript: submitbutton('export')" href="#">
                <span title="Xuất exel" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/Excel-icon.png') no-repeat"></span>
                Xuất exel
            </a>
            <a class="toolbar" onclick="javascript: submitbutton('print_barcode_open')" href="#">
                <span title="In mã vạch" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/print.png') no-repeat"></span>
                In mã vạch
            </a>
            <a class="toolbar" onclick="javascript: submitbutton('add')" href="#">
                <span title="Thêm mới" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/add.png') no-repeat"></span>
                Thêm mới
            </a>
            <a class="toolbar" onclick="javascript: submitbutton('reset_amount_hold')" href="#">
                <span title="Reset tạm giữ" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/remove.png') no-repeat"></span>
                Reset tạm giữ
            </a>
            <a class="toolbar" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Bạn phải chọn ít nhất một bản ghi');}else{ submitbutton('remove')} " href="#">
                <span title="Xóa" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/remove.png') no-repeat"></span>
                Xóa
            </a>      
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!--end: .wrap-toolbar-->
</div>


<form  action="https://<?= DOMAIN  ?>/admin/product/search-fast/check" name="adminForm" method="get">    
    <div class="filter_area">
        <div class="row">

            <div class="fl-left pd-15"> 
                <input type="text" placeholder="Tìm kiếm" name="search" id="search" value="" class="form-control fl-left">
                <span class="input-group-btn fl-left" style="margin-left: -2px;">
                <button type="submit" class="btn btn-search btn-default" type="button">
                <i class="fa fa-search"></i>
                </button>
                </span>
            </div>
            <div class="fl-left">               
                <button class="btn btn-outline btn-primary" type="submit">Tìm kiếm</button>             
                <button class="btn btn-outline btn-primary"><a href="https://<?= DOMAIN  ?>/admin/product?get_template=1">Reset</a>  </button>           
            </div>
             
            
        </div>
    </div>
</form> 

<!-- thêm form post sản phẩm -->

<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" action="https://dienmayai.com/admin/product" name="adminForm" method="post">
            <div class="filter_area">
                <div class="row">
                    <input type="hidden" name="text_count" value="0">           
                    <div class="fl-left pd-15"> 
                        <input type="text" placeholder="Tìm kiếm" name="keysearch" id="search" value="" class="form-control fl-left">
                        <span class="input-group-btn fl-left" style="margin-left: -2px;">
                        <button onclick="this.form.submit();" class="btn btn-search btn-default" type="button">
                        <i class="fa fa-search"></i>
                        </button>
                        </span>
                    </div>
                    <div class="fl-left">               <button class="btn btn-outline btn-primary" onclick="this.form.submit();">Tìm kiếm</button>             <button class="btn btn-outline btn-primary" onclick="document.getElementById('search').value='';                this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button>           </div>
                    <input type="hidden" name="filter_count" value="2">         
                    <div class="fl-left pd-15">
                        <select name="filter0" class="form-control " onchange="this.form.submit()">
                            <option value="0"> -- Danh mục -- </option>
                            <option value="1">Dự Án Hải Sản</option>
                            <option value="2">Đồ chơi</option>
                            <option value="3">Sản phẩm TLC</option>
                            <option value="5">Đèn &amp; Trang trí</option>
                            <option value="6">Các mã xả tồn sẽ dừng bán</option>
                            <option value="7">Điện thoại &amp; Máy tính bảng</option>
                            <option value="8">Bếp &amp; Phòng ăn</option>
                            <option value="9">Bách hóa Online</option>
                            <option value="10">Sức khỏe</option>
                            <option value="11">Giường ngủ &amp; Nhà tắm</option>
                            <option value="12">Âm thanh</option>
                            <option value="13">Văn phòng phẩm và nghề thủ công</option>
                            <option value="14">Thiết bị thông minh</option>
                            <option value="15">Đồ gia dụng</option>
                            <option value="16">Giày dép &amp; Quần áo nam</option>
                            <option value="17">Ôtô, Xe máy &amp; Thiết bị định vị</option>
                            <option value="18">Áo điều hòa- Dũng Hoan</option>
                            <option value="19">Thể thao &amp; Hoạt động ngoài trời</option>
                            <option value="20">Sách NTBook</option>
                            <option value="21">Máy ảnh &amp;&nbsp;Máy bay camera</option>
                            <option value="22">Trẻ sơ sinh &amp; Trẻ nhỏ</option>
                            <option value="23">Dụng cụ sửa chữa nhà cửa</option>
                            <option value="24">Túi xách và Vali túi du lịch</option>
                            <option value="25">Đồng hồ, Mắt kính, Trang sức</option>
                            <option value="26">Các mã dừng bán hẳn</option>
                            <option value="27">Làm đẹp</option>
                            <option value="28">Màn hình &amp; Máy in</option>
                            <option value="29">Giày dép &amp; Quần áo nữ</option>
                            <option value="30">Nội thất &amp; Sắp xếp</option>
                            <option value="31">Máy vi tính &amp; Laptop</option>
                            <option value="32">Chăm sóc nhà cửa</option>
                            <option value="33">Chăm sóc thú cưng</option>
                            <option value="34">Ngoài trời &amp; sân vườn</option>
                            <option value="35">TV &amp; Video</option>
                            <option value="36">Sản phẩm Seka</option>
                            <option value="37">DAKYANG</option>
                        </select>
                    </div>
                    <div class="fl-left pd-15">
                        <select name="filter1" class="form-control " onchange="this.form.submit()">
                            <option value="0"> -- Kho -- </option>
                            <option value="1">Kho Hà Nội</option>
                            <option value="2">Kho Hồ Chí Minh</option>
                            <option value="3">Kho test</option>
                            <option value="4">Kho hàng Cao Duy Hoan</option>
                            <option value="5">Tầng 1</option>
                            <option value="6">Kho Văn La</option>
                            <option value="7">Kho Văn Phú</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="dataTable_wrapper">
                <table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30px"></th>
                            <th width="30px">
                                <input class="checkbox-custom" id="checkAll_box" type="checkbox" onclick="checkAll(50)" value="" name="toggle">
                                <label for="checkAll_box" class="checkbox-custom-label"></label>
                            </th>
                            <th class="title 1">Ảnh</th>
                            <th class="title 2" width="15%"><a title="Click to sort by this column" href="javascript:tableOrdering('barcode','desc','');">Mã vạch</a></th>
                            <th class="title 2" width="15%"><a title="Click to sort by this column" href="javascript:tableOrdering('id','desc','');">Mã</a></th>
                            <th class="title 2" width="20%"><a title="Click to sort by this column" href="javascript:tableOrdering('name','desc','');">Tên</a></th>
                            <th class="title 2"><a title="Click to sort by this column" href="javascript:tableOrdering('import_price','desc','');">Giá nhập</a></th>
                            <th class="title 2"><a title="Click to sort by this column" href="javascript:tableOrdering('price','desc','');">Giá bán</a></th>
                            <th class="title 2"><a title="Click to sort by this column" href="javascript:tableOrdering('price_pack','desc','');">Giá bán đóng gói</a></th>
                            <th class="title 2"><a title="Click to sort by this column" href="javascript:tableOrdering('price_min','desc','');">Giá bán thấp nhất</a></th>
                            <th class="title 2"><a title="Click to sort by this column" href="javascript:tableOrdering('product_transfer','desc','');">Hàng chuyển kho</a></th>
                            <th class="title 2" width="5%"><a title="Click to sort by this column" href="javascript:tableOrdering('amount','desc','');">Tồn</a></th>
                            <th class="title 1" width="5%">Tổng tồn</th>
                            <th class="title 1" width="5%">Tạm giữ</th>
                            <th class="title 1" width="5%">Có thể bán</th>
                            <th class="title 1">Sửa</th>
                            <th class="title 2"><a title="Click to sort by this column" href="javascript:tableOrdering('id','desc','');">Id</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row0">
                            <td>1<input type="hidden" name="id_0" value="37899080"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899080" name="id[]" id="cb0">
                                <label for="cb0" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899080</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899080">O118</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899080)" href="javascript:void()">Đế đỡ (Phụ kiện chân máy chiếu 118O)</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899080">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899080">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899080">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899080"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899080">37899080</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>2<input type="hidden" name="id_1" value="37899079"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899079" name="id[]" id="cb1">
                                <label for="cb1" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899079</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899079">O118-BK-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899079)" href="javascript:void()">Đế đỡ (Phụ kiện chân máy chiếu 118O) - Màu đen - Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899079">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899079">1</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899079">-1</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899079"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899079">37899079</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>3<input type="hidden" name="id_2" value="37899078"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899078" name="id[]" id="cb2">
                                <label for="cb2" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899078)" onerror="" src="https://dienmayai.com/images/products/2025/03/31/original/123_1743392810.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899078</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899078">N054-RE-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899078)" href="javascript:void()">Váy ngủ N054 - Màu đỏ - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899078">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899078">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899078">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899078"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899078">37899078</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>4<input type="hidden" name="id_3" value="37899077"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899077" name="id[]" id="cb3">
                                <label for="cb3" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899077)" onerror="" src="https://dienmayai.com/images/products/2025/03/31/original/123_1743392679.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899077</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899077">N054-RE-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899077)" href="javascript:void()">Váy ngủ N054 - Màu đỏ - Size L</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899077">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899077">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899077">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899077"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899077">37899077</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>5<input type="hidden" name="id_4" value="37899076"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899076" name="id[]" id="cb4">
                                <label for="cb4" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899076)" onerror="" src="https://dienmayai.com/images/products/2025/03/31/original/ao-choang-k054-mau-den-khong-size_1743392651.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899076</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899076">N054-BK-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899076)" href="javascript:void()">Váy ngủ N054 - Màu đen - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899076">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899076">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899076">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899076"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899076">37899076</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>6<input type="hidden" name="id_5" value="37899075"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899075" name="id[]" id="cb5">
                                <label for="cb5" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899075)" onerror="" src="https://dienmayai.com/images/products/2025/03/31/original/ao-choang-k054-mau-den-khong-size_1743392617.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899075</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899075">N054-BK-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899075)" href="javascript:void()">Váy ngủ N054 - Màu đen - Size L</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899075">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899075">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899075">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899075"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899075">37899075</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>7<input type="hidden" name="id_6" value="37899074"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899074" name="id[]" id="cb6">
                                <label for="cb6" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899074)" onerror="" src="https://dienmayai.com/images/products/2025/03/31/original/123_1743392512.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899074</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899074">K054-RE-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899074)" href="javascript:void()">Áo choàng K054 - Màu đỏ - Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899074">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899074">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899074">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899074"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899074">37899074</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>8<input type="hidden" name="id_7" value="37899073"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899073" name="id[]" id="cb7">
                                <label for="cb7" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899073)" onerror="" src="https://dienmayai.com/images/products/2025/03/31/original/ao-choang-k054-mau-den-khong-size_1743392460.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899073</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899073">K054-BK-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899073)" href="javascript:void()">Áo choàng K054 - Màu đen - Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899073">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899073">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899073">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899073"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899073">37899073</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>9<input type="hidden" name="id_8" value="37899072"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899072" name="id[]" id="cb8">
                                <label for="cb8" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899074</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899072">L751</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899072)" href="javascript:void()"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">229.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899072">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899072">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899072">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899072"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899072">37899072</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>10<input type="hidden" name="id_9" value="37899071"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899071" name="id[]" id="cb9">
                                <label for="cb9" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899073</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899071">K751</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899071)" href="javascript:void()"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">605.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899071">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899071">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899071">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899071"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899071">37899071</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>11<input type="hidden" name="id_10" value="37899070"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899070" name="id[]" id="cb10">
                                <label for="cb10" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899071</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899070">J751</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899070)" href="javascript:void()"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">519.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899070">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899070">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899070">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899070"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899070">37899070</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>12<input type="hidden" name="id_11" value="37899069"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899069" name="id[]" id="cb11">
                                <label for="cb11" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899069</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899069">H751</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899069)" href="javascript:void()"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">371.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899069">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899069">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899069">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899069"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899069">37899069</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>13<input type="hidden" name="id_12" value="37898946"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37898946" name="id[]" id="cb12">
                                <label for="cb12" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37898946)" onerror="" src="https://dienmayai.com/images/products/2025/03/28/sJdvmlp.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899069</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37898946">N061-BE-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37898946)" href="javascript:void()">Váy ngủ N061 - Màu be - Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">110.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37898946">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37898946">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37898946">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37898946"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37898946">37898946</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>14<input type="hidden" name="id_13" value="37899068"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899068" name="id[]" id="cb13">
                                <label for="cb13" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899068)" onerror="" src="https://dienmayai.com/images/products/2025/03/26/original/ocphoto-764657126-121695_1742964765.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899068</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899068">K015-BK-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899068)" href="javascript:void()">Áo choàng K015 - Màu đen - Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899068">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899068">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899068">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899068"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899068">37899068</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>15<input type="hidden" name="id_14" value="37899067"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899067" name="id[]" id="cb14">
                                <label for="cb14" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899067)" onerror="" src="https://dienmayai.com/images/products/2025/03/26/original/ocphoto-764657126-09659_1742964745.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899067</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899067">K015-WH-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899067)" href="javascript:void()">Áo choàng K015 - Màu trắng - Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">6</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899067">6</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899067">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899067">6</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899067"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899067">37899067</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>16<input type="hidden" name="id_15" value="37899066"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899066" name="id[]" id="cb15">
                                <label for="cb15" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899066)" onerror="" src="https://dienmayai.com/images/products/2025/03/26/original/ocphoto-764657126-071983_1742964723.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899066</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899066">K015-BE-00</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899066)" href="javascript:void()">Áo choàng K015 - Màu be- Không size</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">9</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899066">9</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899066">1</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899066">8</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899066"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899066">37899066</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>17<input type="hidden" name="id_16" value="37899062"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899062" name="id[]" id="cb16">
                                <label for="cb16" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899062)" onerror="" src="https://dienmayai.com/images/products/2025/03/26/original/screenshot_1_1742964191.png"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899062</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899062">K015</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899062)" href="javascript:void()">Áo choàng K015</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899062">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899062">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899062">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899062"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899062">37899062</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>18<input type="hidden" name="id_17" value="37899061"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899061" name="id[]" id="cb17">
                                <label for="cb17" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899061)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/nPv5xCX.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899066</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899061">N063-BK-05</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899061)" href="javascript:void()">Váy ngủ N063 - Màu đen - Size L</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899061">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899061">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899061">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899061"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899061">37899061</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>19<input type="hidden" name="id_18" value="37899060"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899060" name="id[]" id="cb18">
                                <label for="cb18" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899060)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/nPv5xCX.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899065</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899060">N063-BK-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899060)" href="javascript:void()">Váy ngủ N063 - Màu đen - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899060">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899060">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899060">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899060"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899060">37899060</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>20<input type="hidden" name="id_19" value="37899059"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899059" name="id[]" id="cb19">
                                <label for="cb19" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899059)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/zVWj4IK.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899064</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899059">N063-GR-05</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899059)" href="javascript:void()">Váy ngủ N063 - Màu xanh - Size L</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899059">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899059">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899059">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899059"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899059">37899059</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>21<input type="hidden" name="id_20" value="37899058"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899058" name="id[]" id="cb20">
                                <label for="cb20" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899058)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/zVWj4IK.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899063</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899058">N063-GR-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899058)" href="javascript:void()">Váy ngủ N063 - Màu xanh - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899058">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899058">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899058">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899058"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899058">37899058</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>22<input type="hidden" name="id_21" value="37899057"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899057" name="id[]" id="cb21">
                                <label for="cb21" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899057)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/e6KDBrr.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899062</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899057">N063-RE-05</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899057)" href="javascript:void()">Váy ngủ N063 - Màu đỏ - Size L</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899057">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899057">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899057">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899057"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899057">37899057</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>23<input type="hidden" name="id_22" value="37899056"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899056" name="id[]" id="cb22">
                                <label for="cb22" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899056)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/e6KDBrr.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899061</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899056">N063-RE-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899056)" href="javascript:void()">Váy ngủ N063 - Màu đỏ - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899056">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899056">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899056">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899056"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899056">37899056</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>24<input type="hidden" name="id_23" value="37899055"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899055" name="id[]" id="cb23">
                                <label for="cb23" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899055)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/EgkHvLg.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899060</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899055">N063-PK-05</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899055)" href="javascript:void()">Váy ngủ N063 - Màu hồng - Size L</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899055">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899055">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899055">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899055"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899055">37899055</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>25<input type="hidden" name="id_24" value="37899054"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899054" name="id[]" id="cb24">
                                <label for="cb24" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899054)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/EgkHvLg.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899059</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899054">N063-PK-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899054)" href="javascript:void()">Váy ngủ N063 - Màu hồng - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899054">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899054">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899054">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899054"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899054">37899054</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>26<input type="hidden" name="id_25" value="37899053"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899053" name="id[]" id="cb25">
                                <label for="cb25" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899053)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/EgkHvLg.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899058</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899053">N063</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899053)" href="javascript:void()">Váy ngủ N063</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">100.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899053">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899053">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899053">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899053"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899053">37899053</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>27<input type="hidden" name="id_26" value="37899052"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899052" name="id[]" id="cb26">
                                <label for="cb26" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899052)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/C2ba3S4.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899057</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899052">N103-BE-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899052)" href="javascript:void()">Bộ đồ ngủ N103 - Màu be - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">155.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">2</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899052">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899052">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899052">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899052"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899052">37899052</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>28<input type="hidden" name="id_27" value="37899051"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899051" name="id[]" id="cb27">
                                <label for="cb27" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899051)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/C2ba3S4.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899056</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899051">N103-BE-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899051)" href="javascript:void()">Bộ đồ ngủ N103 - Màu be - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">155.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">1</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899051">1</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899051">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899051">1</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899051"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899051">37899051</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>29<input type="hidden" name="id_28" value="37899050"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899050" name="id[]" id="cb28">
                                <label for="cb28" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899050)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/Rev5O22.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899055</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899050">N103-PK-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899050)" href="javascript:void()">Bộ đồ ngủ N103 - Màu hồng - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">155.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899050">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899050">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899050">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899050"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899050">37899050</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>30<input type="hidden" name="id_29" value="37899049"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899049" name="id[]" id="cb29">
                                <label for="cb29" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899049)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/Rev5O22.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899054</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899049">N103-PK-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899049)" href="javascript:void()">Bộ đồ ngủ N103 - Màu hồng - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">155.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899049">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899049">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899049">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899049"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899049">37899049</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>31<input type="hidden" name="id_30" value="37899048"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899048" name="id[]" id="cb30">
                                <label for="cb30" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899048)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/Rev5O22.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899053</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899048">N103</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899048)" href="javascript:void()">Bộ đồ ngủ N103</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">155.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899048">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899048">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899048">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899048"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899048">37899048</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>32<input type="hidden" name="id_31" value="37899047"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899047" name="id[]" id="cb31">
                                <label for="cb31" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899047)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/ukp7pnn.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899052</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899047">N101-BE-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899047)" href="javascript:void()">Bộ đồ ngủ N101 - Màu be - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">220.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">2</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899047">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899047">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899047">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899047"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899047">37899047</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>33<input type="hidden" name="id_32" value="37899046"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899046" name="id[]" id="cb32">
                                <label for="cb32" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899046)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/ukp7pnn.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899051</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899046">N101-BE-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899046)" href="javascript:void()">Bộ đồ ngủ N101 - Màu be - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">220.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">3</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899046">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899046">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899046">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899046"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899046">37899046</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>34<input type="hidden" name="id_33" value="37899045"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899045" name="id[]" id="cb33">
                                <label for="cb33" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899045)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/ukp7pnn.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899050</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899045">N101</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899045)" href="javascript:void()">Bộ đồ ngủ N101</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899045">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899045">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899045">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899045"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899045">37899045</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>35<input type="hidden" name="id_34" value="37899044"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899044" name="id[]" id="cb34">
                                <label for="cb34" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899044)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/7q3HyOt.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899049</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899044">N100-BE-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899044)" href="javascript:void()">Bộ đồ ngủ N100 - Màu be - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">2</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899044">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899044">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899044">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899044"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899044">37899044</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>36<input type="hidden" name="id_35" value="37899043"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899043" name="id[]" id="cb35">
                                <label for="cb35" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899043)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/7q3HyOt.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899048</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899043">N100-BE-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899043)" href="javascript:void()">Bộ đồ ngủ N100 - Màu be - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">3</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899043">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899043">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899043">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899043"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899043">37899043</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>37<input type="hidden" name="id_36" value="37899042"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899042" name="id[]" id="cb36">
                                <label for="cb36" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899042)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/7q3HyOt.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899047</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899042">N100</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899042)" href="javascript:void()">Bộ đồ ngủ N100</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899042">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899042">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899042">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899042"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899042">37899042</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>38<input type="hidden" name="id_37" value="37899041"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899041" name="id[]" id="cb37">
                                <label for="cb37" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899041)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/72ExsG0.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899046</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899041">N099-WH-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899041)" href="javascript:void()">Bộ đồ ngủ N099 - Màu trắng - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">2</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899041">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899041">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899041">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899041"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899041">37899041</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>39<input type="hidden" name="id_38" value="37899040"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899040" name="id[]" id="cb38">
                                <label for="cb38" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899040)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/72ExsG0.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899045</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899040">N099-WH-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899040)" href="javascript:void()">Bộ đồ ngủ N099 - Màu trắng - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">3</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899040">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899040">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899040">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899040"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899040">37899040</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>40<input type="hidden" name="id_39" value="37899039"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899039" name="id[]" id="cb39">
                                <label for="cb39" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899039)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/72ExsG0.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899044</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899039">N099</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899039)" href="javascript:void()">Bộ đồ ngủ N099</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">255.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899039">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899039">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899039">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899039"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899039">37899039</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>41<input type="hidden" name="id_40" value="37899038"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899038" name="id[]" id="cb40">
                                <label for="cb40" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899038)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/q5GWd9P.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899043</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899038">N098-BE-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899038)" href="javascript:void()">Bộ đồ ngủ N098 - Màu be - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">135.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">2</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899038">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899038">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899038">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899038"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899038">37899038</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>42<input type="hidden" name="id_41" value="37899037"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899037" name="id[]" id="cb41">
                                <label for="cb41" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899037)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/q5GWd9P.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899042</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899037">N098-BE-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899037)" href="javascript:void()">Bộ đồ ngủ N098 - Màu be - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">135.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">3</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899037">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899037">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899037">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899037"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899037">37899037</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>43<input type="hidden" name="id_42" value="37899036"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899036" name="id[]" id="cb42">
                                <label for="cb42" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899036)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/q5GWd9P.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899041</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899036">N098</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899036)" href="javascript:void()">Bộ đồ ngủ N098</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">135.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899036">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899036">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899036">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899036"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899036">37899036</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>44<input type="hidden" name="id_43" value="37899035"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899035" name="id[]" id="cb43">
                                <label for="cb43" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899035)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/e5aa2EV.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899040</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899035">N097-WH-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899035)" href="javascript:void()">Bộ đồ ngủ N097 - Màu trắng - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">275.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">3</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899035">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899035">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899035">3</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899035"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899035">37899035</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>45<input type="hidden" name="id_44" value="37899034"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899034" name="id[]" id="cb44">
                                <label for="cb44" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899034)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/e5aa2EV.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899039</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899034">N097-WH-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899034)" href="javascript:void()">Bộ đồ ngủ N097 - Màu trắng - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">275.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">2</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899034">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899034">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899034">2</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899034"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899034">37899034</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>46<input type="hidden" name="id_45" value="37899033"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899033" name="id[]" id="cb45">
                                <label for="cb45" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899033)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/e5aa2EV.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899038</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899033">N097</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899033)" href="javascript:void()">Bộ đồ ngủ N097</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">275.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899033">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899033">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899033">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899033"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899033">37899033</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>47<input type="hidden" name="id_46" value="37899032"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899032" name="id[]" id="cb46">
                                <label for="cb46" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899032)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/dE3kmPF.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899037</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899032">N096-BL-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899032)" href="javascript:void()">Bộ đồ ngủ N096 - Màu xanh dương - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">240.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899032">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899032">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899032">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899032"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899032">37899032</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>48<input type="hidden" name="id_47" value="37899031"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899031" name="id[]" id="cb47">
                                <label for="cb47" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899031)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/dE3kmPF.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899036</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899031">N096-BL-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899031)" href="javascript:void()">Bộ đồ ngủ N096 - Màu xanh dương - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">240.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899031">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899031">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899031">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899031"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899031">37899031</a></div>
                            </td>
                        </tr>
                        <tr class="row0">
                            <td>49<input type="hidden" name="id_48" value="37899030"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899030" name="id[]" id="cb48">
                                <label for="cb48" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899030)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/RQNzASo.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899035</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899030">N096-PK-04</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899030)" href="javascript:void()">Bộ đồ ngủ N096 - Màu hồng - Size M</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">240.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899030">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899030">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899030">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899030"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899030">37899030</a></div>
                            </td>
                        </tr>
                        <tr class="row1">
                            <td>50<input type="hidden" name="id_49" value="37899029"> </td>
                            <td>
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="37899029" name="id[]" id="cb49">
                                <label for="cb49" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><img class="show_all_image" onclick="show_all_image(37899029)" onerror="" src="https://dienmayai.com/images/products/2025/03/25/RQNzASo.jpeg"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">37899034</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blank" href="https://dienmayai.com/admin/warehouses/bill_detail/37899029">N096-PK-03</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a onclick="show_info_product(37899029)" href="javascript:void()">Bộ đồ ngủ N096 - Màu hồng - Size S</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">240.000 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr">0 đ</div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899029">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/view-amount-hold/37899029">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a target="_blink" href="https://dienmayai.com/admin/product/inventory-detail/37899029">0</a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a title="Sửa" href="https://dienmayai.com/admin/product/edit/37899029"><img border="0" alt="Sửa" src="https://dienmayai.com/admin/templates/default/images/edit.png"></a></div>
                            </td>
                            <td>
                                <div class="wrap_list_pr"><a href="https://dienmayai.com/admin/product/edit/37899029">37899029</a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation">
                    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[8448]</span> </div>
                    <ul class="pagination">
                        <li><a class="title_pagination">Trang</a></li>
                        <li><a title="Page 1" class="current">[1]</a></li>
                        <li><a title="Page 2" href="https://dienmayai.com/admin/product?page=2">2</a></li>
                        <li><a title="Page 3" href="https://dienmayai.com/admin/product?page=3">3</a></li>
                        <li><a title="Page 4" href="https://dienmayai.com/admin/product?page=4">4</a></li>
                        <li><a title="Page 5" href="https://dienmayai.com/admin/product?page=5">5</a></li>
                        <li><a title="Page 6" href="https://dienmayai.com/admin/product?page=6">6</a></li>
                        <b>..</b> 
                        <li><a aria-label="Previous" title="Next page" href="https://dienmayai.com/admin/product?page=2">›</a></li>
                        <li><a aria-label="Next" title="Last page" href="https://dienmayai.com/admin/product?page=169">»</a></li>
                    </ul>
                </nav>
                <input type="hidden" value="" name="sort_field"><input type="hidden" value="asc" name="sort_direct"><input type="hidden" value="products" name="module"><input type="hidden" value="products" name="view"><input type="hidden" value="51" name="total"><input type="hidden" value="0" name="page"><input type="hidden" value="" name="field_change"><input type="hidden" value="" name="task"><input type="hidden" value="0" name="boxchecked"><input type="hidden" value="0" name="page"><input type="hidden" value="0" name="limit">
            </div>
        </form>
    </div>
    <style>
        .filter_area select{
        width: 120px;
        }
        .panel{
        position: relative;
        } 
        .scrolltable{
        position: absolute;
        background: #fff;
        top:0;
        width: 250%;
        }
        .scrolltable th{
        width: 117px;    
        }   
        .remove_border{
        border:0 !important;
        }
        .scrolltable th:nth-child(1), .scrolltable th:nth-child(2){
        width: 30px !important;
        }
        .scrolltable th:nth-child(6){
        width: 300px !important;
        }
        .wrap_list_pr{
        width: 100px;
        }
        tr td:nth-child(6) .wrap_list_pr{
        width:283px !important;
        }
        tr td:nth-child(6){
        width: 300px !important;
        }
        tr th:nth-child(6){
        width: 300px !important;
        }
        tr td:nth-child(1), tr td:nth-child(2){
        width: 30px !important;
        }
        tr th:nth-child(1), tr th:nth-child(2){
        width: 30px !important;
        }
        .dataTable_wrapper{
        overflow-x: unset !important;
        }
        #page-wrapper .table-bordered>thead>tr>th, #page-wrapper .table-bordered>tbody>tr>td {
        width: 117px;
        }
    </style>
    <div id="export_form" class="export_form">
        <p>Nhập giới hạn export</p>
        <label>Export từ</label>
        <input type="text" placeholder="Export từ" class="form-control" name="export_from" id="export_from" value="0">
        <label>Export tới</label>
        <input type="text" placeholder="Export tới" class="form-control" name="export_to" id="export_to" value="500">
        <button type="button" onclick="javascript:call_export()">Export</button>
        <a href="javascript:void(0)" onclick="javascript:close_export()" id="close_export" class="close_export">X</a>
    </div>
    <link type="text/css" rel="stylesheet" media="all" href="https://dienmayai.com/admin/modules/products/assets/css/products.css?t=1743579528">
    <script type="text/javascript" src="https://dienmayai.com/admin/modules/products/assets/js/products.js?t=1743579528"></script>
    <div id="popup-image" class="popup-page-list">
        <div class="close-pu" onclick="close_popup()">
            X
        </div>
        <div class="show-html">
        </div>
    </div>
    <div id="show_info_product" class="popup-page-list">
        <div class="close-pu" onclick="close_popup()">
            X
        </div>
        <div class="tabs-info">
            <div class="tab tab1 active_tab" data-id="1" onclick="show_tab_content(this)">
                Thông tin
            </div>
            <div class="tab" data-id="2" onclick="show_tab_content(this)">
                Tồn kho
            </div>
        </div>
        <div class="contents-info">
        </div>
    </div>
    <style type="text/css">
        .dataTable_wrapper tr th:nth-child(10) a,.dataTable_wrapper tr td:nth-child(10){
        color: red !important;
        }
    </style>
    <script>
        $(document).ready(function() {
                $('.form-horizontal').scroll(function() {
                  // Lấy vị trí cuộn hiện tại của trang
                  var scrollPosition = $(this).scrollTop();
        
                    if(scrollPosition>=200){
                        $('.scrolltable').show();
        
                    } 
                    else{
                        $('.scrolltable').hide();
                    }   
                  
               
                    if(!$('.table-bordered thead').hasClass('scrolltable')){
                        
                        $('.table-bordered thead').addClass('scrolltable');
                        
                        
                        $('.scrolltable tr th').addClass('remove_border');
        
                    }  
                      
                });
                 
            });
    </script>
</div>


<!-- end form -->

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Mã vạch</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Giá bán</th>
                <th>Giá nhập</th>
                <th>Giá bán đóng gói</th>
                <th>Giá bán thấp nhất</th>
                
                <th>Hàng đã xuất</th>
                <th>Tồn</th>
                <th>Tổng tồn (Tổng tồn = Tồn - Hàng đã xuất)</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
                foreach($list as $value):

                    $id_pd = $value->id;

                    
                    // echo($id_pd);

                    $query  = "SELECT amount FROM fs_status_packed WHERE 1=1 AND product_id = $id_pd AND status<2";
                    $product_sale = $db->getTotal($query);                     
            ?>
            <tr>
                <td> <?php if(!empty($value->image)){ ?> <img src="/<?= $value->image  ?>" alt="Ảnh SP"> <?php } ?></td>
                <td><?= $value->id ?></td>
                <td><?= $value->code ?></td>
                <td><?= $value->name ?></td>
                <td><?= number_format((float)$value->price, 0, ',', '.')   ?></td>
                <td><?= number_format((float)$value->import_price, 0, ',', '.')   ?></td>
                <td><?= number_format((float)$value->price_pack, 0, ',', '.')   ?></td>
                <td><?= number_format((float)$value->price_min, 0, ',', '.')   ?></td>

                
                <td><?= $product_sale ?></td>

                <td><?= $value->amount  ?></td>
                <td><?= (int)$value->amount - (int)$product_sale ?></td>
            </tr>
            
            <?php
                endforeach;
            ?>
            <!-- Thêm nhiều dòng hơn nếu cần -->
        </tbody>
    </table>

    
</div>

<nav aria-label="Page navigation">
    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[8044]</span> </div>
    <ul class="pagination">
        <li><a class="title_pagination">Trang</a></li>
        <?php
            if($page>1){
        ?>
        <li><a title="Page 2" href="https://dienmayai.com/admin/product?page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
        <?php
            }
        ?>
        <li><a title="Page 2" href="https://dienmayai.com/admin/product?page=<?= intval($page) ?>"><?= intval($page) ?></a></li>
        
    
        <li><a aria-label="Next" title="Last page" href="https://dienmayai.com/admin/product?page=<?= intval($page)+1 ?>"><?= intval($page)+1 ?></a></li>
    </ul>
</nav>
  <script type="text/javascript" src="https://dienmayai.com/admin/templates/default/js/jquery-confirm.min.js"></script>
        <script type="text/javascript" src="https://dienmayai.com/admin/templates/default/js/select2.min.js"></script>
<script type="text/javascript" src="https://dienmayai.com/admin/templates/default/js/helper.js?t=1743337731"></script>
     <!-- Bootstrap Core JavaScript -->
        <script src="https://dienmayai.com/admin/templates/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="https://dienmayai.com/admin/templates/default/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="https://dienmayai.com/admin/templates/default/bower_components/raphael/raphael-min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="https://dienmayai.com/admin/templates/default/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="https://dienmayai.com/admin/templates/default/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
        <script src="https://dienmayai.com/admin/templates/default/bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
        <script>
            $(document).ready(function() {
                $('#dataTables-example1').DataTable({
                    responsive: true,
                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ trên mỗi trang",
                        "zeroRecords": "Không tìm thấy gì - xin lỗi",
                        "info": "Đang ở trang _PAGE_ của _PAGES_",
                        "infoEmpty": "Không có dữ liệu có sẵn",
                        "infoFiltered": "(lọc từ tổng số hồ sơ _MAX_)",
                        "search": "Tìm kiếm nhanh:",
                        paginate: {
                            first:    '«',
                            previous: '‹',
                            next:     '›',
                            last:     '»'
                        },
                    },
                    select: {
                        style: 'multi'
                    },
                    "lengthMenu": [ 10 ,20, 30, 40 , 50],
                    "columnDefs": [
                    { "orderable": false, "targets": 1 }
                    ]
                });

            });
        </script>
        <!-- Custom Theme JavaScript -->
        <script src="https://dienmayai.com/admin/templates/default/dist/js/sb-admin-2.js"></script>
        <script src="https://dienmayai.com/admin/templates/default/dist/js/jquery.cookie.js"></script>
        <!-- Custom select chosen.jquery.js -->
        <script src="https://dienmayai.com/admin/templates/default/js/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {no_results_text: "Không tìm thấy "},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:"Không tìm thấy "},
              '.chosen-select-width'     : {width:"95%"}
          }
          for (var selector in config) {
              $(selector).chosen(config[selector]);
          }
      </script>

</body>
</html>