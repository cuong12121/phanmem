<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ADMIN; ?>/templates/default/css/jquery-ui.css" />

<script src="<?php echo URL_ROOT.'libraries/jquery/jsxlsx';?>/shim.min.js"></script>
<script src="<?php echo URL_ROOT.'libraries/jquery/jsxlsx';?>/xlsx.full.min.js"></script>
<script src="<?php echo URL_ROOT ?>libraries/chartjs/dist/Chart.min.js"></script>
<script src="<?php echo URL_ROOT ?>libraries/chartjs/samples/utils.js"></script>

<?php 
	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 0; 
$fitler_config['filter_count'] = 2;		

$dates = array(0=> 'Hôm nay',1=> 'Hôm qua',2=> 'Tuần này',3=> 'Tuần trước',4=> 'Tháng này',5=> 'Tháng trước');

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Thời gian'); 
$filter_warehouses['list'] = @$dates; 
$filter_warehouses['field'] = 'name'; 	

$filter_warehouses_2 = array();
$filter_warehouses_2['title'] = FSText::_('Kho hàng'); 
$filter_warehouses_2['list'] = @$warehouses; 
$filter_warehouses_2['field'] = 'name'; 

$fitler_config['filter'][] = $filter_warehouses;
$fitler_config['filter'][] = $filter_warehouses_2;	

$list_config = array();

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

<div class="row">

	<div class="col_1 col-lg-8">
		<div class="list_total">
			<div class="item item_1">
				<div class="innner">
					<div class="title"><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 512 512"><path d="M23 23v466h466v-18H41v-82.184l85.854-57.234 70.023 70.022 65.133-260.536L387.28 203.7 455.07 95.73l19.317 11.858 6.102-71.1-60.644 37.616 19.884 12.207-59.01 93.99-130.732-65.366-62.865 251.462-57.98-57.978L41 367.184V23H23z"/></svg>Doanh thu</div>
					<div class="number"><?php echo format_money($total_price_done,'đ','0đ'); ?></div>
					<div class="percent"><?php echo $total_order_done; ?> đơn hàng</div>
				</div>
			</div>
			<div class="item item_2">
				<div class="innner">
					<div class="title"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 491.123 491.123" style="enable-background:new 0 0 491.123 491.123;" xml:space="preserve">
						<g>
							<g>
								<path d="M470.223,0.561h-89.7c-9.4,0-16.7,6.3-19.8,14.6l-83.4,263.8h-178.3l-50-147h187.7c11.5,0,20.9-9.4,20.9-20.9    s-9.4-20.9-20.9-20.9h-215.9c-18.5,0.9-23.2,18-19.8,26.1l63.6,189.7c3.1,8.3,11.5,13.6,19.8,13.6h207.5c9.4,0,17.7-5.2,19.8-13.6    l83.4-263.8h75.1c11.5,0,20.9-9.4,20.9-20.9S481.623,0.561,470.223,0.561z"/>
								<path d="M103.223,357.161c-36.5,0-66.7,30.2-66.7,66.7s30.2,66.7,66.7,66.7s66.7-30.2,66.7-66.7S139.723,357.161,103.223,357.161z     M128.223,424.861c0,14.6-11.5,26.1-25,26.1c-13.6,0-25-11.5-25-26.1s11.5-26.1,25-26.1    C117.823,398.861,129.323,410.261,128.223,424.861z"/>
								<path d="M265.823,357.161c-36.5,0-66.7,30.2-66.7,66.7s30.2,66.7,66.7,66.7c37.5,0,66.7-30.2,66.7-66.7    C332.623,387.361,302.323,357.161,265.823,357.161z M290.923,424.861c0,14.6-11.5,26.1-25,26.1c-13.5,0-25-11.5-25-26.1    s11.5-26.1,25-26.1C280.423,398.861,291.923,410.261,290.923,424.861z"/>
							</g>
						</g>
					</svg>Đơn hàng</div>
					<div class="number"><?php echo format_money($total_price_list,'đ','0đ'); ?></div>
					<div class="percent"><?php echo $total_order; ?> đơn hàng</div>
				</div>
			</div>
			<div class="item item_3">
				<div class="innner">
					<div class="title"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482 482" style="enable-background:new 0 0 482 482;" xml:space="preserve">
						<g>
							<g>
								<polygon points="279.8,244.8 258.2,257.3 258.2,482 452.7,369.7 452.7,145   "/>
								<polygon points="315,43.3 240.2,0 40.3,115.4 115.2,158.7   "/>
								<polygon points="440,115.4 353.8,66.3 154,181.7 165.4,187.6 240.2,230.8 314.6,187.9   "/>
								<polygon points="138.9,264.3 103.1,245.9 103.1,188.7 29.3,146.2 29.3,369.3 222.4,480.8 222.4,257.7 138.9,209.6   "/>
							</g>
						</g>
					</svg>Tồn kho</div>
					<div class="pw_wrapper">
						<svg width="38px" fill="#fff" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 489.533 489.533" style="enable-background:new 0 0 489.533 489.533;" xml:space="preserve">
<g>
	<path d="M268.175,488.161c98.2-11,176.9-89.5,188.1-187.7c14.7-128.4-85.1-237.7-210.2-239.1v-57.6c0-3.2-4-4.9-6.7-2.9   l-118.6,87.1c-2,1.5-2,4.4,0,5.9l118.6,87.1c2.7,2,6.7,0.2,6.7-2.9v-57.5c87.9,1.4,158.3,76.2,152.3,165.6   c-5.1,76.9-67.8,139.3-144.7,144.2c-81.5,5.2-150.8-53-163.2-130c-2.3-14.3-14.8-24.7-29.2-24.7c-17.9,0-31.9,15.9-29.1,33.6   C49.575,418.961,150.875,501.261,268.175,488.161z"/>
</g>
</svg>
<!-- 						<div class="number"><?php echo format_money($total_price_warehouses,'đ','0đ'); ?></div>
						<div class="percent"><?php echo $total_count_warehouses; ?> Sản phẩm</div> -->
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
<!-- 		<div class="panel-heading">
			<h3 class="box-title">Doanh thu so với tháng trước</h3>
		</div> -->
		<!-- /.box-header -->
		<!-- form start -->
		<div class="panel-body panel-body_1">
			<div id="canvas-holder_1" >
				<canvas id="ctx_line_month"></canvas>
			</div>
		</div>
	</div><!-- /.box -->
</div>
</div>

<style>
	.list_total .item {
		width: calc(100% / 3 - 30px);
		float: left;
		margin: 15px;
		text-align: center;
		color: #fff;
		padding: 10px;
		border-radius: 5px;
	}
	.list_total .item .title {
		text-transform: uppercase;
		font-size: 16px;
	}
	.list_total .item .title svg {
		width: 20px;
		margin-right: 10px;
		fill: #fff;
		transform: translate(3px, 3px);
	}
	.item_1 {
		background: green;
	}
	.item_2 {
		background: orange;
	}
	.item_3 {
		background: #a1887f;
	}

	.dataTable_wrapper {
		display: none;
	}


</style>


<?php
$config_line_month_label = '';
$config_line_month_value1 = '';
$config_line_month_value2 = '';
for ($i=1; $i < 32; $i++) { 
	$config_line_month_label .= $i.',';
}

foreach ($list_month_now_day as $item) {
	$config_line_month_value1 .= $item.',';
}

foreach ($list_month_last_day as $item) {
	$config_line_month_value2 .= $item.',';
}

$config_line_month_label = trim($config_line_month_label,',');

?>

<script>

	var config_ctx_line_month = {
		type: 'line',
		data: {
			labels: [<?php echo $config_line_month_label; ?>],
			datasets: [
			{
				label: 'Tháng này',
				backgroundColor: "deepSkyBlue",
				borderColor: "deepSkyBlue",
				data: [
				<?php echo $config_line_month_value1; ?>
				],
				fill: false,
			},{
				label: 'Tháng trước',
				backgroundColor: "red",
				borderColor: "red",
				data: [
				<?php echo $config_line_month_value2; ?>
				],
				fill: false,
			}]
		},
		options: {
			responsive: true,
			title: {
				display: true,
				text: 'Doanh thu So với tháng trước'
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Ngày'
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Doanh thu'
					}
				}]
			}
		}
	};

	window.onload = function() {
		var ctx_line_month = document.getElementById('ctx_line_month').getContext('2d');
		window.myLine = new Chart(ctx_line_month, config_ctx_line_month);
	};

	$.ajax({
		type : 'get',
		url : '<?php echo URL_ADMIN; ?>/index.php?module=warehouses&view=overview&raw=1&task=get_pw_wrapper',
		dataType : 'html',
		data: {},
		success : function(data){
      		$('.pw_wrapper').html(data);
      	},
      	error : function(XMLHttpRequest, textStatus, errorThrown) {}
      });  
  </script>