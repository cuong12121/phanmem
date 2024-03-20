<?php
	global $tmpl,$config; 
	$tmpl -> addStylesheet('hotdeal','blocks/countdown/assets/css');
	$tmpl -> addScript('hotdeal','blocks/countdown/assets/js');
?>
<?php 
	//$time = date('Y-m-d H:i:s');
	//$time_event = $config['time_event'];
	//$name_even = $config['name_even'];
	//$link_even = $config['link_even'];
?>

<?php 
	// echo '<pre>';
	// print_r($data);
	// die;
?>


<?php if( ($data->published == 1 ) && ($data-> status == 1)) {?>


	<div class="header_event">
		<div class="container cls">
			<div class="even_item cls">

				<?php if($data-> status == 1){?>
					<div class="name_even">
						
						<?php if($data-> link){?>
							<a href="" title="<?php echo $data-> title;?>">
						<?php }?>
							<?php echo $data-> title;?>
						<?php if($data-> link){?>
							</a>
						<?php }?>
					</div>
				<?php }?>

				<?php if($data-> status == 1){?>					
					<div id="time-dow-hotdeal">
						<div class="time">
							<div id="day_h" class="time_1"></div>
						</div>
						<div class="time">
							<div id="hours_h" class="time_1"></div> 
						</div>
						<div class="time">
							<div id="min_h" class="time_1"></div> 
						</div>
						<div class="time">
							<div id="sec_h" class="time_1"></div>
						</div>
					</div>
				<?php }?>
			</div>
		</div>
		<div class="closed_event">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.9 21.9" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 21.9 21.9">
				<path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"></path>
			</svg>
		</div>
		<script>	
			// Set the date we're counting down to
			var set_time_h = '<?php echo $data-> date_end; ?>';
				
			var countDownDate_h = new Date(set_time_h).getTime();
			// Update the count down every 1 second
			var x_h = setInterval(function() {
			  // Get todays date and time
			  var now_h = new Date().getTime();
			  // Find the distance between now and the count down date
			  var distance_h = countDownDate_h - now_h;
			  // Time calculations for days, hours, minutes and seconds
			  var days_h = Math.floor(distance_h / (1000 * 60 * 60 * 24));
			  var hours_h = Math.floor((distance_h % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var minutes_h = Math.floor((distance_h % (1000 * 60 * 60)) / (1000 * 60));
			  var seconds_h = Math.floor((distance_h % (1000 * 60)) / 1000);
			  // Display the result in the element with id="demo"
			  if(days_h<10) {
			  	days_h = 0 + days_h;
			  }
			  if(seconds_h<10) {
			  	seconds_h = 0+seconds_h;
			  }
			  document.getElementById("day_h").innerHTML = days_h +':';
			  document.getElementById("hours_h").innerHTML = hours_h +':';
			  document.getElementById("min_h").innerHTML = minutes_h +':';
			  document.getElementById("sec_h").innerHTML = seconds_h;
			  // If the count down is finished, write some text 
			  if (distance_h < 0) {
			  	clearInterval(x_h);
			  	document.getElementById("text-time-dow-hotdeal").innerHTML = "Đã kết thúc";
			  }
			}, 1000);
		</script>
	</div>
<?php }?>