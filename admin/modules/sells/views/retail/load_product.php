<?php if(!empty($data)){?>
	<tr>
        <td class="text-center">4</td>
        <td class="text-center"></td>
        <td class="colName">
            <span class="productCode" title="Mã sản phẩm">668E-RE-00</span>
            <br>
            <a class="productName" title="Tên sản phẩm" target="_blank" href="">Máy Massage Cầm Tay Trị Liệu Đau Lưng -đỏ-Không size</a>
        </td>
        <td class="hasProductBatch position-relative hide"></td>
        <td class="hasProductUnit showHideProductUnit colUnit"></td>
        <td class="text-right colPrice" data-price="191900" title="Giá sản phẩm">
            <input title="Giá sản phẩm" style="width: 90px !important;float: right;" type="text" autocomplete="off" maxlength="10" class="tbPrice textbox-only-border-bottom keyCodeChange form-control text-right autoNumeric p-1" value="191900">
        </td>

        <td class="text-right">
            <div>
                <input autocomplete="off" title="Số lượng" style="width: 56px !important;" data-available="4" maxlength="10" class="qtt textbox-only-border-bottom form-control keyCodeChange float-right text-right p-1" value="1">
            </div>
        </td>

        <td class="text-right">
            <div>
                <div class="d-inline-block available-qtt  text-success " data-value="4" title="Tồn trong kho: 4">4</div>
            </div>
        </td>

        <td class="text-right colProductMoney showHideProductTotalPrice " title="Tổng tiền">191.900</td>

        <td class="text-right colDiscount showHideProductDiscount ">
            <div style="float: right">
                <div class="input-group">
                    <select style="width: 35px;" class="typePsDiscount form-control border-0" title="Loại chiết khấu"><option value="cash" selected="selected">$</option><option value="percent">%</option></select>
                    <input title="Giá trị chiết khấu" style="width: 78px;" type="text" autocomplete="off" class="autoNumeric psDiscount textbox-only-border-bottom keyCodeChange form-control text-right p-1" value="">
                </div>
                <div title="Giá trị tiền mặt" class="psDiscountValue font-size-sm"></div>
            </div>
        </td>

        <td class="text-right colTotalProductPrice">191.900</td>

        <td class="text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-light pl-1 btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:;" class="dropdown-item btnProductAct">
                        <i class="fal fa-plus mr-2"></i> Quà tặng, BHMR, Ghi chú</a><a href="javascript:;" class="dropdown-item text-danger btnProductRemove"><i class="fal fa-trash mr-2"></i> Xóa sản phẩm</a>
                </div>
            </div>
        </td>
    </tr>
<?php } ?>