<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Bán hàng ra kho') );
	$toolbar->addButton('import_barcode_warehouse_sales',FSText :: _('Nhập từ barcode'),'','barcode.png');
	$toolbar->addButton('import_excel_warehouse_sales',FSText :: _('Import excel'),'','Excel-icon.png');
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 5;
    $fitler_config['text_count'] = 2;


    $filter_houses = array();
	$filter_houses['title'] = FSText::_('Giờ'); 
	$filter_houses['list'] = @$houses; 
	$filter_houses['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_houses;


    $filter_warehouses = array();
	$filter_warehouses['title'] = FSText::_('Kho'); 
	$filter_warehouses['list'] = @$warehouses; 
	$filter_warehouses['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_warehouses;


	$filter_platforms = array();
	$filter_platforms['title'] = FSText::_('Sàn'); 
	$filter_platforms['list'] = @$platforms; 
	$filter_platforms['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_platforms;

	$filter_shipping_unit = array();
	$filter_shipping_unit['title'] = FSText::_('Đơn vị vận chuyển'); 
	$filter_shipping_unit['list'] = @$shipping_unit; 
	$filter_shipping_unit['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_shipping_unit;	


	$filter_shoot = array();
	$filter_shoot['title'] = FSText::_('Trạng thái'); 
	$filter_shoot['list'] = array(1=>'Đã bắn',2=>'Chưa bắn');
	$fitler_config['filter'][] = $filter_shoot;


	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;

	//	CONFIG	
	$list_config = array();

	$list_config[] = array('title'=>'Tracking Code','field'=>'tracking_code','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Order number','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '8%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Shop','field'=>'shop_code','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Mã sku','field'=>'sku','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Mã màu','field'=>'color','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Mã size','field'=>'size','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'SKU nhanh','field'=>'sku_nhanh','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Giá SP','field'=>'product_price','ordering'=> 1, 'type'=>'format_money','col_width' => '10%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Số lượng','field'=>'count','ordering'=> 1, 'type'=>'text','col_width' => '6%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Tổng số tiền','field'=>'total_price','ordering'=> 1, 'type'=>'format_money','col_width' => '10%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Ngày','field'=>'date','ordering'=> 1, 'type'=>'datetime');

	$list_config[] = array('title'=>'Đơn vị vận chuyển','field'=>'shipping_unit_name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

	//$list_config[] = array('title'=>'Edit','type'=>'edit');
    //$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
    
?>


<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>

<style>
.fixedHeader {
  position: fixed;
  top: 0px;
  display: none;
  background: #fff;
  z-index: 99;
}
.fixedHeader th {
  background: #fff;
}
</style>
<script>
// Lấy phần tử theo id cũ
	let el = document.getElementById("wrap-toolbar");

	// Đổi id thành wrap_toolbar
	if (el) {
	  el.id = "wrap_toolbars";
	}

  document.addEventListener("DOMContentLoaded", function() {
  const table = document.querySelector("#dataTables-example");
  const thead = table.querySelector("thead");

  // Clone thead
  const clone = thead.cloneNode(true);
  clone.classList.add("fixedHeader");
  table.parentNode.insertBefore(clone, table);

  function matchColumnWidths() {
    const origTh = thead.querySelectorAll("th");
    const cloneTh = clone.querySelectorAll("th");
    origTh.forEach((th, i) => {
      cloneTh[i].style.width = th.offsetWidth + "px";
    });
    clone.style.width = table.offsetWidth + "px";
  }

  // Match widths after page load and on resize
  matchColumnWidths();
  window.addEventListener("resize", matchColumnWidths);

  window.addEventListener("scroll", function() {
    const rect = table.getBoundingClientRect();
    if (rect.top < 56 && rect.bottom > 0) {
      clone.style.display = "table-header-group";
    } else {
      clone.style.display = "none";
    }
  });
});
</script>  
