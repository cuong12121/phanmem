<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/retail.css' ?>" />
<?php 
    $title = @$data ? FSText::_('Edit'): FSText::_('Bán lẻ'); 
    global $toolbar, $config;
    $toolbar->setTitle($title);
    // $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    // $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  
?>

<div class="wraps-retail">
    <div id="boxHeader" class="cls">
        <div id="boxSearch">
            <div class="input_group cls">
                <div class="input-group-prepend cls">
                    <div class="btn-icon">
                        <?php echo $config['icon_search'] ?>
                    </div>
                    <input type="text" id="tbLoadProduct" placeholder="(F3) Tìm sản phẩm" class="form-control" autocomplete="new-password">
                   
                        <div class="wrap-product-search">
                            
                        
                        </div>
                   
                </div>
                
                <div id="wrapDefaultQuantity" class="showQuantity">
                    <input type="text" id="defaultQuantity" class="form-control autoNumeric text-right" placeholder="SL" title="Số lượng" autocomplete="new-password" value="">
                </div>

                <div id="wrapManualQuantity" title="Nhập bằng đầu đọc mã vạch">
                    <?php echo $config['iconScanner'] ?>
                </div>

            </div>
        </div>
        <div id="boxTabs">
            <div id="wrapTabs">
                <div id="moveLeft" class="moveTab opacity_0">
                    <a href="javascript:">
                        <?php echo $config['left_arrow'] ?>
                    </a>
                </div>
                <div id="contentTabs">
                    <ul class="listTabs cls">
                        
                        <li class="tabInvoice tabInvoice-1 active tabInvoice-show" data-tab="1">
                            <a onclick="tabInvoice(this)"  href="javascript:;" data-tab="1">Hóa đơn 1</a>
                            <span onclick="closeTab(this)" class="closeTab" title="Đóng" data-tab="1">
                                x
                            </span>
                        </li>
                       
                    </ul>
                </div>
                <div id="moveRight" class="moveTab moveright opacity_0">
                    <a href="javascript:">
                        <?php echo $config['left_arrow'] ?>
                    </a>
                </div>
                <div id="tabAdd" role="presentation" title="Thêm mới (F1)">
                    <a href="javascript:">
                        <?php echo $config['icon_plus'] ?>
                    </a>
                </div>
                <input id="count-tab-show" type="hidden" value="1">
            </div>
        </div>
        <div id="boxIcons">
            <a href="javascript:" title="Danh sách tạo gần đây">
                <?php echo $config['shopping_cart'] ?>
            </a>
            <a href="javascript:" title="Đổi doanh nghiệp" class="change_shop">
                <?php echo $config['icon_home'] ?>
            </a>
        </div>
    </div>

    <div id="boxContent">
        <div class="boxContentTab boxContentTab-1 cls">
            <div class="boxLeft">
                <?php include('boxProducts.php'); ?>
                <?php include('boxCustomer.php'); ?>
            </div>
            <?php include('boxPayment.php'); ?>
        </div>
    </div>


    <input id="data_id" type="hidden" value="<?php echo isset($data) ? $data->id : 0  ?>">
</div>



<div class="popup">
    
</div>
    






<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/retail.js' ?>"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />