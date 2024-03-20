<div class="form_user_head">
	<div class="form_user_head_l">
		<div class="form_user_head_r">
			<div class="form_user_head_c">
				<span class='title_tlb_left'>Hoa h&#7891;ng c&#417; b&#7843;n   </span>
				<span class='title_tlb_right'>&#272;&#417;n v&#7883; t&iacute;nh : VND</span>
			</div>					
		</div>					
	</div>					
</div>	
<div class="form_user_footer_body">	
		<?php 
		$total_cm_month = 0;
		$total_cm_receive_month = 0;
		$total_cm_non_receive_month = 0;
		?>
		<table cellpadding="6" cellspacing="0" >
			<tr >
				<td width="5%" class="td-left tbl_head">STT </td>
				<td width="35%" class="td-left tbl_head">Lo&#7841;i hoa h&#7891;ng  </td>
				<td width="15%" class="td-left tbl_head">T&#7893;ng hoa h&#7891;ng  </td>
				<td width="15%" class="td-left tbl_head">Hoa h&#7891;ng &#273;&#432;&#7907;c nh&#7853;n </td>
				<td width="17%" class="td-left tbl_head">Hoa h&#7891;ng ch&#432;a &#273;&#432;&#7907;c nh&#7853;n  </td>
				<td width="13%" class="td-right tbl_head">Chi ti&#7871;t  </td>
			</tr>	
			
			<!--	INTRODUCE COMMISSION	-->
			<tr >
				<?php 
				$cm_intro_all = @$data_userhistory->totalintroducecommission ?$data_userhistory->totalintroducecommission:0;
				$cm_intro_receive = @$data_userhistory->total_paid_introduce ?$data_userhistory->total_paid_introduce:0;
				$cm_intro_non_receive = $cm_intro_all-$cm_intro_receive;
				
				$total_cm_month += $cm_intro_all;
				$total_cm_receive_month += $cm_intro_receive;
				$total_cm_non_receive_month += $cm_intro_non_receive ;
				?>
				<td class="td-left ">1 </td>
				<td class="td-left">Hoa h&#7891;ng gi&#7899;i thi&#7879;u   </td>
				<td class="td-left"><?php echo number_format($cm_intro_all, 0, ',', '.');   ?> </td>
				<td class="td-left "><span class='red'><?php echo number_format($cm_intro_receive, 0, ',', '.');  ?> </span></td>
				<td class="td-left ">
					<?php echo number_format($cm_intro_non_receive, 0, ',', '.'); ?>
					<?php if(($cm_intro_non_receive) > 0) {?>
					<div id='tooltip-target-1' class ='reason-target' >
						<img src="images/reason.jpg" /><span class='red' > L&yacute; do </span>
					</div>
					<div id="tooltip-content-1" class="reason-content tooltip-content" >
						<p class='reason-content-head'>
							B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:
						</p>
						<p class='reason-content-body'>
							Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!
						</p>
					</div>
					<?php }?>
					
					
				</td>
				<td class="td-right ">
					<a href="<?php echo Route::_("index.php?module=users&view=commission&task=detail&type=introduce&Itemid=27");?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
			    </td>
			</tr>	
			<!--	end INTRODUCE COMMISSION	-->
			
			<!--	REVENUE COMMISSION	-->
			<tr >
				<?php 
				$cm_revenue_all = @$data_userhistory->totalsalecommission ?$data_userhistory->totalsalecommission:0;
				$cm_revenue_receive = @$data_userhistory->total_paid_sale ?$data_userhistory->total_paid_sale:0;
				$cm_revenue_non_receive = $cm_revenue_all-$cm_revenue_receive;       
				
				$total_cm_month += $cm_revenue_all;
				$total_cm_receive_month += $cm_revenue_receive;
				$total_cm_non_receive_month += $cm_revenue_non_receive ;
				?>
				<td  class="td-left " >2 </td>
				<td class="td-left">Hoa h&#7891;ng th&#7909; &#273;&#7897;ng    </td>
				<td class="td-left"><?php echo number_format($cm_revenue_all, 0, ',', '.');   ?> </td>
				<td class="td-left "><span class='red'><?php echo number_format($cm_revenue_receive, 0, ',', '.'); ?> </span></td>
				<td class="td-left ">
					<?php echo number_format($cm_revenue_non_receive, 0, ',', '.'); ?>
					<?php if(($cm_revenue_non_receive) > 0) {?>
					<div id='tooltip-target-2' class ='reason-target' >
						<img src="images/reason.jpg" /><span class='red' > L&yacute; do </span>
					</div>
					<div id="tooltip-content-2" class="reason-content tooltip-content" >
						<p class='reason-content-head'>
							B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:
						</p>
						<p class='reason-content-body'>
							Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!
						</p>
					</div>
					<?php }?>
					
					
				</td>
				<td class="td-right ">
					<a href="<?php echo Route::_("index.php?module=users&view=commission&task=detail&type=passive&Itemid=28");?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
			    </td>
			</tr>	
			<!--	end REVENUE COMMISSION	-->
			
			
			<!--	INTRODUCE ESTORE COMMISSION	-->
			<tr >
				<?php 
				$cm_intro_estore_all = 0;
				$cm_intro_estore_receive = 0;
				$cm_intro_estore_non_receive = 0;
				
				$total_cm_month += $cm_intro_estore_all;
				$total_cm_receive_month += $cm_intro_estore_receive;
				$total_cm_non_receive_month += $cm_intro_estore_non_receive ;
				?>
				<td class="td-left ">3 </td>
				<td class="td-left">Hoa h&#7891;ng t&#432; v&#7845;n gian h&agrave;ng </td>
				<td class="td-left"><?php echo number_format($cm_intro_estore_all, 0, ',', '.');   ?> </td>
				<td class="td-left "><span class='red'><?php echo  number_format($cm_intro_estore_receive, 0, ',', '.'); ?> </span></td>
				<td class="td-left ">
					<?php echo number_format($cm_intro_estore_non_receive, 0, ',', '.'); ?>
					<?php if(($cm_intro_estore_non_receive) > 0) {?>
						
						<div id='tooltip-target-3' class ='reason-target' >
							<img src="images/reason.jpg" /><span class='red' > L&yacute; do </span>
						</div>
						<div id="tooltip-content-3" class="reason-content tooltip-content" >
							<p class='reason-content-head'>
								B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:
							</p>
							<p class='reason-content-body'>
								Ch&#432;a c&#7853;p nh&#7853;t 
							</p>
						</div>
						
					<?php }?>
					</td>
				<td class="td-right ">
					<a href="<?php echo Route::_("index.php?index.php?module=users&view=commission&task=intro_estore&Itemid=28");?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
			    </td>
			</tr>	
			<!--	end INTRODUCE ESTORE COMMISSION	-->
			
			<!--	INTRODUCE ESTORE COMMISSION	-->
			<tr >
				<?php 
				$cm_buy_all = 0;
				$cm_buy_receive = 0;
				$cm_buy_non_receive = 0;
				
				$total_cm_month += $cm_buy_all;
				$total_cm_receive_month += $cm_buy_receive;
				$total_cm_non_receive_month += $cm_buy_non_receive ;
				?>
				<td class="td-left ">4 </td>
				<td class="td-left">Hoa h&#7891;ng doanh thu mua h&agrave;ng  </td>
				<td class="td-left"><?php echo number_format($cm_buy_all, 0, ',', '.');   ?> </td>
				<td class="td-left "><span class='red'><?php echo number_format($cm_buy_receive, 0, ',', '.'); ?> </span></td>
				<td class="td-left ">
					<?php echo number_format($cm_buy_non_receive, 0, ',', '.'); ?>
					<?php if(($cm_buy_non_receive) > 0) {?>
						<div id='tooltip-target-4' class ='reason-target' >
							<img src="images/reason.jpg" /><span class='red' > L&yacute; do </span>
						</div>
						<div id="tooltip-content-4" class="reason-content tooltip-content" >
							<p class='reason-content-head'>
								B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:
							</p>
							<p class='reason-content-body'>
								Ch&#432;a c&#7853;p nh&#7853;t 
							</p>
						</div>
					<?php }?>
					</td>
				<td class="td-right ">
					<a href="<?php echo Route::_("index.php?index.php?module=users&view=commission&task=buy&Itemid=28");?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
			    </td>
			</tr>	
			<!--	end INTRODUCE ESTORE COMMISSION	-->
			
			
			<tr class="bold">
				<td class="td-left tbl_footer" colspan="2"> T&#7893;ng s&#7889; </td>
				<td class="td-left tbl_footer"><?php echo number_format($total_cm_month, 0, ',', '.'); ?> </td>
				<td class="td-left tbl_footer red"><?php echo number_format($total_cm_receive_month, 0, ',', '.'); ?></td>
				<td class="td-left tbl_footer"><?php echo number_format($total_cm_non_receive_month, 0, ',', '.'); ?> </td>
				<td class="td-right"> &nbsp;</td>
			</tr>	
		</table>
		<!-- ENd TABLE 							-->
		
		
</div>
	
<script type="text/javascript">
$(document).ready(function(){
	for(i = 1; i < 15; i ++)
	{
		tooltipId = "#tooltip-target-"+i;
		$(tooltipId).ezpz_tooltip();	
	}
	
//	$("#tooltip_target").ezpz_tooltip({
//		contentId: 'tooltip_content',
//		showContent: function(content) {
//			content.fadeIn('slow');
//		},
//		hideContent: function(content) {
//			// if the showing animation is still running, be sure to stop it
//			// and clear the animation queue. otherwise, repeatedly hovering will
//			// cause the content to blink.
//			content.stop(true, true).fadeOut('slow');
//		}
//	});
	

});


</script>				
