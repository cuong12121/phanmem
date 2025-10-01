<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/js/eye.js"></script>

<!-- FOR TAB -->	
<script>
// 	$(document).ready(function() {
// 		$("#tabs").tabs();
// 	});

// 	// Lấy phần tử theo id cũ
// 	let el = document.getElementById("wrap-toolbar");

// 	// Đổi id thành wrap_toolbar
// 	if (el) {
// 	  el.id = "wrap_toolbars";
// 	}

// 	document.addEventListener("DOMContentLoaded", function () {
//     const table = document.getElementById("table_products_search_ajax_list");
//     if (!table) return;

//     // Nếu có <thead> thì lấy, nếu không thì lấy hàng đầu tiên
//     let headerRow = table.querySelector("thead") || table.querySelector("tr");
//     if (!headerRow) return;

//     const cloneHeader = headerRow.cloneNode(true);
//     const floatingHeader = document.createElement("table");
//     floatingHeader.appendChild(cloneHeader);
//     floatingHeader.style.position = "fixed";
//     floatingHeader.style.top = "0";
//     floatingHeader.style.left = table.getBoundingClientRect().left + "px";
//     floatingHeader.style.width = table.offsetWidth + "px";
//     floatingHeader.style.display = "none";
//     floatingHeader.style.background = "#fff";
//     floatingHeader.style.zIndex = "999";

//     document.body.appendChild(floatingHeader);

//     window.addEventListener("scroll", function () {
//         const rect = table.getBoundingClientRect();
//         if (rect.top < 0 && rect.bottom > 0) {
//             floatingHeader.style.display = "table";
//             floatingHeader.style.left = rect.left + "px";
//         } else {
//             floatingHeader.style.display = "none";
//         }
//     });

//     window.addEventListener("resize", function () {
//         floatingHeader.style.width = table.offsetWidth + "px";
//         floatingHeader.style.left = table.getBoundingClientRect().left + "px";
//     });
// });

</script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
$this -> dt_form_begin(0);
?>
<?php
if($data-> status == 2) {
	include 'detail_base_1.php';
} elseif($data-> status == 3) {
	include 'detail_base_2.php';
} elseif($data-> status >= 4) {
	include 'detail_base_3.php';
} else {
	include 'detail_base_0.php';
}
?>
<?php 
$this -> dt_form_end(@$data,0);
?>

