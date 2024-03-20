<div class='count_status'>
	<div class="form_user_head">
			<div class="form_user_head_l">
				<div class="form_user_head_r">
					<div class="form_user_head_c">
						<br />
						<h1><span> &nbsp; &nbsp;Thống kê các đơn hàng  </span></h1>
					</div>					
				</div>					
			</div>					
		</div>	
		
		<div class="form_user_footer_body">
			
					<!-- TABLE 							-->
					<table cellpadding="6" cellspacing="0" width="100%" >
						<tr>
							<td class="td-left">
								<span>Tổng số đơn hàng :  </span>
								<span class="red bold">
									<?php 
									$total = 0;
									for($i = 0; $i < 5; $i ++){
										$total += $count_status[$i];
									}
									echo $total;
									?>
								</span>
							</td>
							<?php $i = 0;?>
							<?php foreach($array_status as $key => $name){?>
								<td class="td-right">
									<span class=''><?php echo $name?></span>:
									<strong class='red'><?php echo $count_status[$key]?></strong>
								</td>
								<?php if(($i + 2)%3 == 0){?>
									</tr><tr>
								<?php }?>
								<?php $i ++;?>
							<?php }?>
							<td class="td-right">&nbsp;</td>
						</tr>
						
					</table>	
			</div>
</div>
			
