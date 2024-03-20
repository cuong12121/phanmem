
<div class="boxPayment">
    <!-- Thông tin thanh toán -->
    <div class="wrap_totalProductMoney cls">
        <div class="col-50">
            <div class="txtbold">
                Tổng tiền hàng
            </div>
            <div class="vat-show" onclick="show_vat(<?php echo $stt_next ?>)">
               VAT <?php echo $config['down_arrow'] ?>
            </div>
        </div>
        <div class="col-50 totalProductMoney">0</div>
    </div>


    <div class="form-group boxDiscountContainner cls" id="boxDiscountContainner">
        <div class="col-50">
            <label class="col-form-label">Chiết khấu <span class="hotKey">(F6)</span></label>
            <span id="txtDisplayDiscountMoney">1.435.500</span>
        </div>
        <div class="col-50 text-right change-discount cls">
            <select id="manualDiscountType" class="form-control changeInfoPayment" title="Loại chiết khấu" data-value="cash">
                <option class="changeManualDiscountType" value="cash" selected="selected">$</option>
                <option class="changeManualDiscountType" value="percent">%</option>
            </select>
            <input type="number" class="form-control textLarge changeInfoPayment hasAddOn text-right autoNumeric" id="manualDiscount" autocomplete="new-password" value="">
        </div>
    </div>



    <!-- Thông tin VAT -->
    <div class="boxDiscountContainner boxViewVAT-<?php echo $stt_next ?> hide">
        <div class="form-group sectionUseAccounting">
            <div class="col-50 lh-36">
                <label class="col-form-label">VAT</label>
            </div>
            <div class="col-50 text-right change-discount cls">
                <select id="manualDiscountType" class="form-control changeInfoPayment" title="Loại chiết khấu" data-value="cash">
                    <option class="changeManualDiscountType" value="cash" selected="selected">$</option>
                    <option class="changeManualDiscountType" value="percent">%</option>
                </select>
                <input type="number" class="form-control textLarge changeInfoPayment hasAddOn text-right autoNumeric" id="manualDiscount" autocomplete="new-password" value="">
            </div>
        </div>


        <div class="form-group sectionUseAccounting">
            <label class="col-50 col-form-label lh-36">Số hóa đơn</label>
            <div class="col-50">
                <input type="text" class="form-control changeInfoPayment textLarge border-bot" id="taxBillCode" autocomplete="new-password">
            </div>
        </div>

        <div class="form-group sectionUseAccounting">
            <label class="col-50 col-form-label lh-36">Ngày xuất hóa đơn</label>
            <div class="col-50">
                <input type="text" class="form-control changeInfoPayment textLarge tbDatePicker border-bot" id="taxBillDate" name="taxBillDate">
            </div>
        </div>
    </div>
    <div class="form-group ">
        <label class="col-50 col-form-label lh-36">Coupon <br>
            <span id="txtDisplayCouponCodeMoney" style="font-size: 90%;opacity: 0.7;"></span>
        </label>
        <div class="col-50">
            <div class="input_group_coupon">
                <input type="text" class="form-control textLarge changeInfoPayment  border-bot" id="couponCode" name="couponCode" autocomplete="new-password">
                <div class="input-group-append">
                    <a href="javascript:" class="input-group-text px-2" id="checkCouponCode" title="Kiểm tra giá trị coupon">
                        <?php echo $config['icon_sync'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
  

    <div class="form-group">
        <div class="col-50">
            <div class="txtbold">Khách cần trả</div>
        </div>
        <div id="subTotal" class="col-50 text-right totalProductMoney color-main">1.000.000</div>
    </div>


    <div class="form-group sectionUseAccounting" id="cashContainer">
        <label class="col-50 col-form-label lh-36">Tiền mặt (F8)</label>
        <div class="col-50">
            <div class="input_group_arrow_left">
                <div class="input-group-prepend copySubTotal" onclick="SubTotal()">
                    <?php echo $config['right_arrow'] ?>
                </div>
                <input type="number" maxlength="10" class="form-control border-bot changeInfoPayment textLarge autoNumeric text-right" id="cash" autocomplete="new-password" value="">
            </div>
        </div>
    </div>

    <div class="form-group sectionUseAccounting">
        <label class="col-50 col-form-label lh-36">Quẹt thẻ</label>
        <div class="col-50">
            <div class="input_group_arrow_left">
                <div class="input-group-prepend copySubTotal" onclick="SubTotal(<?php echo $stt_next ?>,1)">
                    <?php echo $config['right_arrow'] ?>
                </div>
                <input type="number" maxlength="10" class="form-control border-bot changeInfoPayment textLarge autoNumeric text-right" id="creditMoney" autocomplete="new-password" value="">
            </div>
            <div class="creditAccountIdContainer hide creditAccountIdContainer-<?php echo $stt_next ?>">
                <div class="sectionAccountingTextBox creditCodeContainer">
                    <input type="text" maxlength="45" class="form-control border-bot changeInfoPayment" placeholder="Mã giao dịch" autocomplete="new-password">
                </div>
            </div>
        </div>
    </div>

    <div class="btnViewInfoPayments" onclick="ShowInfoPayments(<?php echo $stt_next ?>)" >
        Chuyển khoản, Trả góp
        <span><?php echo $config['down_arrow'] ?></span>
    </div>

    <!-- box hiển thị thêm thông tin thanh toán -->
    <div class="boxViewInfoPayments-<?php echo $stt_next ?> hide">
        <div class="form-group sectionUseAccounting" id="moneyTransferContainer">
            <label class="col-50 col-form-label lh-36">Chuyển khoản</label>
            <div class="col-50">
                <div class="input_group_arrow_left">
                    <div class="input-group-prepend copySubTotal" onclick="SubTotal()">
                        <?php echo $config['right_arrow'] ?>
                    </div>
                    <input type="text" maxlength="10" class="form-control border-bot changeInfoPayment textLarge autoNumeric text-right" id="moneyTransfer" autocomplete="new-password" value="">
                </div>
            </div>
        </div>

        <div class="form-group sectionUseAccounting" id="installmentMoneyContainer">
            <label class="col-50 col-form-label lh-36">Trả góp</label>
            <div class="col-50">
                <div class="input_group_arrow_left">
                    <div class="input-group-prepend copySubTotal" onclick="SubTotal()">
                        <?php echo $config['right_arrow'] ?>
                    </div>
                    <input type="text" maxlength="10" class="form-control border-bot changeInfoPayment textLarge autoNumeric text-right" id="installmentMoney" autocomplete="new-password" value="">
                </div>
                <div id="installmentIdContainer">
                    <div class="sectionAccountingTextBox" id="installmentCodeContainer">
                        <input type="text" maxlength="45" class="form-control changeInfoPayment border-bot" id="installmentCode" placeholder="Mã hợp đồng trả góp" autocomplete="new-password">
                    </div>
                </div>
            </div>
        </div>
     
    </div>

    <div class="form-group">
        <div class="col-50">
            <div class="txtbold ">Tiền thừa</div>
        </div>
        <div class="col-50 text-right totalProductMoney color-main">1.000.000</div>
    </div>

    <div class="form-group">
        <div class="col-50">
            <div class="txtbold red">Còn thiếu</div>
        </div>
        <div class="col-50 text-right totalProductMoney color-red">1.000.000</div>
    </div>
    

    <!-- Lưu hóa đơn -->
    <div class="form-group mb-2 " id="wrapDescription">
        <textarea title="Ghi chú" class="wrapDescription hasAddOn txtAutoHeight form-control" rows="3" id="description" placeholder="Ghi chú"></textarea>
    </div>

    <div class="form-group" id="wrapBtnSave">
        <div class="col-50">
            <a onclick="btn_save_payment()" class="btn-save-customer" href="javascript:void(0)"> <?php echo $config['icon_save'] ?> Lưu (F9)</a>
        </div>
        <div class="col-50">
            <div class="auto-print-payment">
                <input type="checkbox"> Tự động in sau khi lưu
            </div>
            
        </div>
    </div>
</div>