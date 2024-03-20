<div class="form_user_head">
		<div class="form_user_head_l">
			<div class="form_user_head_r">
				<div class="form_user_head_c">
					<span>Doanh thu c&aacute; nh&acirc;n  </span>
				</div>					
			</div>					
		</div>					
	</div>	
	
	<div class="form_user_footer_body">
		
				<!-- TABLE 							-->
				<table cellpadding="6" cellspacing="0" >
					<tr>
						<td class="td-left">
							<span>Doanh s&#7889; Mload th&aacute;ng <?php echo date('m/Y')?> : </span>
							<span class="red bold"><?php echo number_format(@$data_userhistory -> totalsale ? $data_userhistory -> totalsale : 0, 0, ',', '.'); ?></span>
							<span> VND </span>
						</td>
						<td class="td-right">
							<span>T&#7893;ng s&#7889; th&agrave;nh vi&ecirc;n c&#7845;p 1 :</span>
							<span class='green underline'><?php echo @$data_userhistory -> level1usercount ? $data_userhistory -> level1usercount : 0; ?>
										th&agrave;nh vi&ecirc;n  </span>
						</td>
					</tr>
					<tr>
						<td class="td-left">
							<span>Doanh s&#7889; gian h&agrave;ng/n&#259;m : </span>
							<span class='green underline'><?php echo @$data_userhistory -> estore_online ? $data_userhistory -> estore_online : 0; ?> </span>
						</td>
						<td class="td-right">
							<span>Doanh s&#7889; EP th&aacute;ng <?php echo date('m/Y')?> :</span>
							<span class='green underline'>Ch&#432;a c&#7853;p nh&#7853;t </span>
						</td>
					</tr>
					<tr>
						<td class="td-left">
							<span>C&#7845;p &#273;&#7897; th&agrave;nh vi&ecirc;n : </span>
							<span class='red'>
								<?php
								echo showLevel($user->level);
								?>
							</span>
						</td>
						<td class="td-right">
							<span>S&#7889; nh&aacute;nh c&oacute; th&agrave;nh vi&ecirc;n &#273;&#7841;t sao  :</span>
							<span class='green underline'><?php echo @$data_userhistory -> total1_stars_other_tree? $data_userhistory -> total1_stars_other_tree: 0; ?> </span>
						</td>
					</tr>
					
				</table>	
		</div>
		<br/>
			
