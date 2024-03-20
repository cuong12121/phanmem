  <script src="<?php echo URL_ROOT ?>libraries/chartjs/dist/Chart.min.js"></script>
  <script src="<?php echo URL_ROOT ?>libraries/chartjs/samples/utils.js"></script>
  <!-- <script src="<?php echo URL_ROOT ?>libraries/raphael/raphael-min.js"></script> -->

  <?php

  $config_statistical2_label = '';
  $config_statistical2_bg = '';
  $config_statistical2_value = '';

  $total_value2 = 0;

  foreach ($statistical2['row'] as $key => $value) {
  	$total_value2 += $statistical2['total_ton'][$key];
  }

  foreach ($statistical2['row'] as $key => $value) {
  	$config_statistical2_label .= '"'.$value[0].'",';
  	$config_statistical2_bg .= '"'.$value[3].'",';

    if($total_value2) {
        $config_statistical2_value .= '"'.round(($statistical2['total_ton'][$key]/$total_value2*100),2).'",';
    } else {
        $config_statistical2_value .= '"'.'0'.'",';
    }
  	
  }

  $config_statistical2_label = trim($config_statistical2_label,',');
  $config_statistical2_bg = trim($config_statistical2_bg,',');
  $config_statistical2_value = trim($config_statistical2_value,',');



  $config_statistical1_label = '';
  $config_statistical1_bg = '';
  $config_statistical1_value = '';

  $total_value = 0;

  foreach ($statistical1['row'] as $key => $value) {
  	$total_value += $statistical1['total_price'][$key];
  }

  foreach ($statistical1['row'] as $key => $value) {
  	$config_statistical1_label .= '"'.$value[0].'",';
  	$config_statistical1_bg .= '"'.$value[3].'",';
    if($total_value) {
        $config_statistical1_value .= '"'.round((@$statistical1['total_price'][$key]/$total_value*100),2).'",';
    } else {
        $config_statistical1_value .= '"'.'0'.'",';
    }
  	
  }

  $config_statistical1_label = trim($config_statistical1_label,',');
  $config_statistical1_bg = trim($config_statistical1_bg,',');
  $config_statistical1_value = trim($config_statistical1_value,',');
  ?>

  <div class="statisticals statistical1">
  	<div class="statisticals_chart">
  		<div class="col_1">
  			<!-- general form elements -->
  			<div class="panel panel-success">
  				<div class="panel-heading">
  					<h5 class="box-title">Tỉ lệ giá trị hàng tồn kho theo ngày bán hàng (%)</h5>
  				</div><!-- /.box-header -->
  				<!-- form start -->
  				<div class="panel-body panel-body_1">
  					<div id="canvas-holder_1" >
  						<canvas id="statistical1"></canvas>
  					</div>
  				</div>
  			</div><!-- /.box -->
  		</div>
  	</div>
  	<div class="statisticals_table">
  		<table style="width: 100%;" class="table table-hover table-striped table-bordered">
  			<thead>
  				<tr>
  					<th width="30px">Chu kỳ</th>
  					<th width="30px">Số sản phẩm</th>
  					<th width="30px">Tồn có thể bán</th>
  					<th width="30px">Tổng giá trị tồn</th>
  					<th width="30px">% Giá trị tồn</th>
  					<th width="30px">% Giá TB/SP</th>
  				</tr>
  			</thead>
  			<tbody>
  				<?php 
  				$total_count = 0;
  				$total_p = 0;
  				$total_price = 0;
  				foreach ($statistical1['row'] as $key => $value) { 
  					$total_p = $total_p+ $statistical1['count'][$key];
  					$total_count = $total_count+ $statistical1['total_ton'][$key];
  					$total_price = $total_price + $statistical1['total_price'][$key];
  					?>
  					<tr>
  						<td><?php echo $value[0]; ?></td>
  						<td><?php echo $statistical1['count'][$key]; ?></td>
  						<td><?php echo $statistical1['total_ton'][$key]; ?></td>
  						<td><?php echo format_money($statistical1['total_price'][$key],'đ','0đ'); ?></td>
  						<td><?php echo $total_value?@round(($statistical1['total_price'][$key]/$total_value*100),2):0; ?>%</td>
  						<td><?php if($statistical1['total_ton'][$key]) { echo format_money(round((@$statistical1['total_price'][$key]/$statistical1['total_ton'][$key])),'đ','0đ');} else { echo '0';} ?></td>
  					</tr>
  				<?php } ?>

  				<tr>
  					<td>Tổng tồn</td>
  					<td><?php echo $total_p; ?></td>
  					<td><?php echo $total_count; ?></td>
  					<td><?php echo format_money($total_price,'đ','0đ'); ?></td>
  					<td>100%</td>
  					<td><?php if($total_count) { echo format_money(round((@$total_price/$total_count)),'đ','0đ');} else { echo '0';} ?></td>
  				</tr>
  				<tr>
  					<td>Cần nhập thêm</td>
  					<td><?php echo $statistical_buy['total_p']; ?></td>
  					<td><?php echo $statistical_buy['total_count']; ?></td>
  					<td><?php echo format_money($statistical_buy['total_price']); ?></td>
  					<td>&nbsp;</td>
  					<td><?php if($statistical_buy['total_count']) { echo format_money(round((@$statistical_buy['total_price']/$statistical_buy['total_count'])),'đ','0đ');} else { echo '0';} ?></td>
  				</tr>
  			</tbody>
  		</table>
  	</div>
  	<div class="clearfix"></div>
  </div>

  <div class="statisticals statistical2">
  	<div class="statisticals_chart">
  		<div class="col_1">
  			<!-- general form elements -->
  			<div class="panel panel-success">
  				<div class="panel-heading">
  					<h5 class="box-title">Tỉ lệ bán ra (%)</h5>
  				</div><!-- /.box-header -->
  				<!-- form start -->
  				<div class="panel-body panel-body_1">
  					<div id="canvas-holder_1" >
  						<canvas id="statistical2"></canvas>
  					</div>
  				</div>
  			</div><!-- /.box -->
  		</div>
  	</div>
  	<div class="statisticals_table">
  		<table style="width: 100%;" class="table table-hover table-striped table-bordered">
  			<thead>
  				<tr>
  					<th width="30px">Tỉ lệ bán ra</th>
  					<th width="30px">Số sản phẩm</th>
  					<th width="30px">Tồn có thể bán</th>
  					<th width="30px">Tỉ lệ</th>
  					<th width="30px">SL cần nhập</th>
  				</tr>
  				<?php 
  				$total_count2 = 0;
  				$total_buy2 = 0;
  				foreach ($statistical2['row'] as $key => $value) {  
  					$total_count2 += $statistical2['count'][$key];
  					$total_buy2 += @$statistical2['buy'][$key];
  					?>
  					<tr>
  						<td><?php echo $value[0]; ?></td>
  						<td><?php echo $statistical2['count'][$key]; ?></td>
  						<td><?php echo $statistical2['total_ton'][$key]; ?></td>
  						<td><?php echo $total_value2?round($statistical2['total_ton'][$key] / $total_value2 * 100,2):0; ?>%</td>
  						<td><?php echo $statistical2['buy'][$key]; ?></td>
  					</tr>
  				<?php } ?>
  				<tr>
  					<td>Tổng</td>
  					<td><?php echo $total_count2; ?></td>
  					<td><?php echo $total_value2; ?></td>
  					<td>100%</td>
  					<td><?php echo $total_buy2; ?></td>
  				</tr>

  			</thead>
  			<tbody>
  			</tbody>
  		</table>
  	</div>
  	<div class="clearfix"></div>
  </div>

  <style>
  	.statisticals_chart {
  		width: 30%;
  		float: left;
  	}
  	.statisticals_table {
  		width: 67%;
  		float: right;
  	}
  	#page-wrapper .panel-body {
  		padding: 0px 0;
  		padding: 10px;
  	}
  </style>


  <script>

  	var config_statistical1 = {
  		type: 'pie',
  		data: {
  			datasets: [{
  				data: [<?php echo $config_statistical1_value; ?> ],
  				backgroundColor: [<?php echo $config_statistical1_bg; ?>],
  				label: 'Dataset 1'
  			}],
  			labels: [<?php echo $config_statistical1_label; ?>]
  		},
  		options: {
  			responsive: true
  		}
  	};

  	var config_statistical2 = {
  		type: 'pie',
  		data: {
  			datasets: [{
  				data: [<?php echo $config_statistical2_value; ?> ],
  				backgroundColor: [<?php echo $config_statistical2_bg; ?>],
  				label: 'Dataset 1'
  			}],
  			labels: [<?php echo $config_statistical2_label; ?>]
  		},
  		options: {
  			responsive: true
  		}
  	};


  	window.onload = function() {

  		var statistical1 = document.getElementById('statistical1').getContext('2d');
  		window.myPie = new Chart(statistical1, config_statistical1);

  		var statistical2 = document.getElementById('statistical2').getContext('2d');
  		window.myPie = new Chart(statistical2, config_statistical2);

		// var ctx = document.getElementById('chart-device_type').getContext('2d');
		// window.myPie = new Chart(ctx, config_device_type);

		// var ctx2 = document.getElementById('chart-brown').getContext('2d');
		// window.myPie2 = new Chart(ctx2, config_browser);

	};
</script>