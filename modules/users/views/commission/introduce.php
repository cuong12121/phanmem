<?php
	global $tmpl;
	$tmpl -> addStylesheet('logged','modules/users/assets/css');
?>
<div class="frame_display  introduce_cm">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>	
		<?php $Itemid = FSInput::get('Itemid'); ?>
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class='title'><span>Hoa h&#7891;ng gi&#7899;i thi&#7879;u </span></p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
					<div id = "msg_error"></div>
					
							<!--			PERSON COMMISSION				-->
							<div class="commission_person">
								<?php include 'commission_person.php';?>
							</div>
							
							
							<!--			INTRO COMMISSION				-->
							<div class="introduce_commission">
								<div class="form_user_head">
									<div class="form_user_head_l">
										<div class="form_user_head_r">
											<div class="form_user_head_c">
												<span>Chi ti&#7871;t hoa h&#7891;ng gi&#7899;i thi&#7879;u th&aacute;ng <?php echo date('m/Y'); ?>  </span>
												<div >&#272;&#417;n v&#7883; t&iacute;nh : VND</div>
											</div>					
										</div>					
									</div>					
								</div>	
								<div class="form_user_footer_body">	
										<table cellpadding="6" cellspacing="0">
											<tr >
												<td class="td-left tbl_head">C&#7845;p &#273;&#7841;i l&yacute; </td>
												<td class="td-left tbl_head">S&#7889; th&agrave;nh vi&ecirc;n  </td>
												<td class="td-left tbl_head">T&#7893;ng hoa h&#7891;ng  </td>
												<td class="td-left tbl_head">Hoa h&#7891;ng &#273;&#432;&#7907;c nh&#7853;n </td>
												<td class="td-right tbl_head">Hoa h&#7891;ng ch&#432;a &#273;&#432;&#7907;c nh&#7853;n </td>
											</tr>	
											<?php 
												$total_cm_month = 0; 
												$total_cm_receive_month = 0; 
												$total_cm_non_receive_month = 0; 
												$hight_paid_level = @$cm_intro_detail -> hight_paid_level ? $cm_intro_detail -> hight_paid_level: 0;
											?>
											<?php for($i = 0 ; $i < 7; $i ++ ){?>
											<tr>
												<td class="td-left"><?php echo $i + 1; ?></td>
												<td class="td-left">
													<?php
														$level_count_field = "level".($i+1)."usercount";
														echo @$cm_intro_detail -> $level_count_field? $cm_intro_detail -> $level_count_field : 0;
													?>
												
												</td>
												<td class="td-left"> 
													<?php
														$level_total_field = "level".($i+1)."totalic";
														$level_total =  @$cm_intro_detail -> $level_total_field? $cm_intro_detail -> $level_total_field: 0;
														echo number_format($level_total, 0, ',', '.');
														$total_cm_month  += $level_total;
													?>
												</td>
												<td class="td-left red">
													<?php
														if(($i+1)<= $hight_paid_level)
														{
															echo  number_format($level_total, 0, ',', '.');
															$total_cm_receive_month  += $level_total;
														}
														else
														{
															echo 0;
														}
													?>
												</td>
												<td class="td-right">
													<?php
														if(($i+1)<= $hight_paid_level)
														{
															echo 0;
														}
														else 
														{
															echo number_format($level_total, 0, ',', '.');
															$total_cm_non_receive_month  += $level_total;
														}
													?>
												</td>
												
											</tr>
											
											<?php }?>
											
											<tr class="bold">
												<td class="td-left" colspan="2">T&#7893;ng s&#7889; </td>
												<td class="td-left"><?php echo number_format($total_cm_month, 0, ',', '.'); ?> </td>
												<td class="td-left"><?php echo number_format($total_cm_receive_month, 0, ',', '.'); ?></td>
												<td class="td-right "><?php echo number_format($total_cm_non_receive_month, 0, ',', '.'); ?> </td>
											</tr>	
										</table>
										<!-- ENd TABLE 							-->
							</div>
							<!--		end	INTRO COMMISSION				-->		
						</div>
						<?php 
						if($hight_paid_level < 7)
						{
						?>
							<div class="orange alert-max-count"><img src="images/alert-member.jpg" alt="alert-member.jpg" /><span>
							B&#7841;n ch&#432;a &#273;&#7911; &#273;i&#7873;u ki&#7879;n nh&#7853;n hoa h&#7891;ng t&#7915; c&#7845;p  <?php echo ($hight_paid_level+1)?> tr&#7903; l&ecirc;n
							</span></div>
						<?php 	
						}
						?>
						
						<div class="statics-commission">
							<h3>Th&#7889;ng k&ecirc; h&agrave;ng th&aacute;ng </h3>
							<form action="index.php" >
							<?php 
								$year_current = date('Y');
								$month_current = date('m');
							?>
							<table cellspacing="15" >
								<tr>
									<td>T&#7915; th&aacute;ng </td>
									<td>
										<select name="month_from" id = "month_from">
										<?php for($i = 0; $i < 12; $i ++){?>
											<option  value="<?php echo ($i+1) ?>" <?php echo $month_current == ($i+1)? "selected='selected'":""; ?>  ><?php echo ($i+1) ?></option>
										<?php }?>
										</select>
									</td>
									<td>
										<select name="year_from" id="year_from">
										<?php for($i = $year_current; $i >= 2008; $i --){?>
											<option  value="<?php echo ($i) ?>" <?php echo $year_current == ($i)? "selected='selected'":""; ?>  ><?php echo ($i) ?></option>
										<?php }?>
										</select>
									</td>
									<td rowspan="2">
										<a class="button3" href="javascript:load_commission_month();"><span>Th&#7889;ng k&ecirc;   </span></a>
									</td>
								</tr>
								<tr>
									<td>&#272;&#7871;n th&aacute;ng  </td>
									<td>
										<select name="month_to" id="month_to">
										<?php for($i = 0; $i < 12; $i ++){?>
											<option  value="<?php echo ($i+1) ?>" <?php echo $month_current == ($i+1)? "selected='selected'":""; ?>  ><?php echo ($i+1) ?></option>
										<?php }?>
										</select>
									</td>
									<td>
										<select name="year_to" id="year_to">
										<?php for($i = $year_current; $i >= 2008; $i --){?>
											<option  value="<?php echo ($i) ?>" <?php echo $year_current == ($i)? "selected='selected'":""; ?>  ><?php echo ($i) ?></option>
										<?php }?>
										</select>
									</td>
								</tr>
							</table>
							<div id="loading" style="display:none"><img src="images/ajax-loader.gif" /></div>
							<div id="ajax_cm_months">
								
							</div>
							</form>
						</div>
						<div class="txt_condition">
							<h3>&#272;i&#7873;u ki&#7879;n nh&#7853;n hoa h&#7891;ng (&aacute;p d&#7909;ng cho c&#7843; hoa h&#7891;ng gi&#7899;i thi&#7879;u v&agrave; hoa h&#7891;ng th&#7909; &#273;&#7897;ng):</h3>
							<?php // echo $config_condition_receive_commission; ?>
							<div>
								<ul>
									<li class='li-parent'>
										&#272;&#7889;i v&#7899;i th&agrave;nh vi&ecirc;n m&#7899;i gia nh&#7853;p, trong th&aacute;ng &#273;&#7847;u ti&ecirc;n &#273;&#432;&#7907;c h&#432;&#7903;ng hoa h&#7891;ng gi&#7899;i thi&#7879;u v&agrave; hoa h&#7891;ng th&#7909; &#273;&#7897;ng c&#7911;a c&#7845;p 1 m&agrave; kh&ocirc;ng c&#7847;n b&#7845;t c&#7913; &#273;i&#7873;u ki&#7879;n g&igrave;.
									</li>
									<li class='li-parent'>
										K&#7875; t&#7915; th&aacute;ng th&#7913; 2, ho&#7863;c c&#7845;p 2 tr&#7903; &#273;i, &#273;&#7875; nh&#7853;n &#273;&#432;&#7907;c hoa h&#7891;ng gi&#7899;i thi&#7879;u ho&#7863;c hoa h&#7891;ng th&#7909; &#273;&#7897;ng th&igrave; doanh s&#7889; M-Load mua v&agrave;o t&agrave;i kho&#7843;n 2(T&agrave;i kho&#7843;n b&aacute;n h&agrave;ng) t&#7889;i thi&#7875;u l&agrave; 2,500,000&#273;/th&aacute;ng v&agrave; th&#7887;a m&atilde;n c&aacute;c &#273;i&#7873;u ki&#7879;n sau:
									</li>
									<li class='li-child'>
										H&#432;&#7903;ng c&#7845;p 1, 2: T&#7847;ng 1 c&oacute; 3 &#273;&#7841;i l&yacute; tr&#7903; l&ecirc;n.
									</li>
									<li class='li-child'>
										H&#432;&#7903;ng c&#7845;p 3, 4, 5: T&#7847;ng 1 c&oacute; 5 &#273;&#7841;i l&yacute; tr&#7903; l&ecirc;n.
									</li>
									<li class='li-child'>
										H&#432;&#7903;ng c&#7845;p 6: T&#7847;ng 1 c&oacute; 10 &#273;&#7841;i l&yacute; tr&#7903; l&ecirc;n.
									</li>
									<li class='li-child'>
										H&#432;&#7903;ng c&#7845;p 7: T&#7847;ng 1 c&oacute; 15 &#273;&#7841;i l&yacute; tr&#7903; l&ecirc;n.
									</li>
								</ul>
								
							</div>
						</div>
					</div>
				</div>
				<div class="form_right">
					<?php $tmpl -> loadModules('right-inner','Round'); ?>
				</div>
				
			</div>	
		</div>	
	</div>
</div>

<script type="text/javascript">
//<![CDATA[

$("#loading").ajaxStart(function(){
	   $(this).show();
	 });
$("#loading").ajaxStop(function(){
$(this).hide();
}); 
function load_commission_month()
{
	month_from = $("#month_from").val();
	year_from = $("#year_from").val();
	month_to = $("#month_to").val();
	year_to = $("#year_to").val();
	$.ajax({
//		  url: "index.php?module=users&view=commission&task=ajax_load_intro&raw=1&yt="+year_to+"&yf="+year_from+"&mt="+month_to+"&mf="+month_from+"",
		  url: "index.php?module=users&view=commission&task=ajax_load_commission&type=introduce&raw=1&yt="+year_to+"&yf="+year_from+"&mt="+month_to+"&mf="+month_from+"",
		  cache: false,
		  success: function(json){
		  		json = jQuery.trim(json);
//				console.log("=="+json+"==");
		    	if(json != '1')
		    	{
//			    	console.log('bi loi');
		    		document.getElementById('ajax_cm_months').innerHTML = json;
		    		return 0;
		    	}
		    	else
		    	{
		    		console.log('ngon');
					return 1;	
					return true;
		    	}
		  },
		  error: function()
		  {
			 alert('error');
			 return false;
		  }
		});
//	console.log('kq');
//	return false;
}
</script>