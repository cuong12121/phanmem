<div class="form_user_head">
	<div class="form_user_head_l">
		<div class="form_user_head_r">
			<div class="form_user_head_c">
				<span class='title_tlb_left'>Hoa h&#7891;ng qu&#7843;n l&yacute;  </span>
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
	<table cellpadding="6" cellspacing="0">
		<tr >
			<td width="5%" class="td-left tbl_head">STT </td>
			<td width="35%" class="td-left tbl_head">Lo&#7841;i hoa h&#7891;ng  </td>
			<td width="15%" class="td-left tbl_head">T&#7893;ng hoa h&#7891;ng  </td>
			<td width="15%" class="td-left tbl_head">Hoa h&#7891;ng &#273;&#432;&#7907;c nh&#7853;n </td>
			<td width="17%" class="td-left tbl_head">Hoa h&#7891;ng ch&#432;a &#273;&#432;&#7907;c nh&#7853;n  </td>
			<td width="13%" class="td-right tbl_head">Chi ti&#7871;t  </td>
		</tr>	
		
		<!--	1 COMMISSION: Mload compress	-->
		<tr >
			<?php 
			$cm_1_all = 0;
			$cm_1_receive = 0;
			$cm_1_non_receive = $cm_1_all-$cm_1_receive;
			
			$total_cm_month += $cm_1_all;
			$total_cm_receive_month += $cm_1_receive;
			$total_cm_non_receive_month += $cm_1_non_receive ;
			?>
			<td class="td-left ">1 </td>
			<td class="td-left">Hoa h&#7891;ng n&eacute;n t&#7847;ng doanh thu</td>
			<td class="td-left"><?php echo $cm_1_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_1_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_1_non_receive; ?>
				<?php if(($cm_1_non_receive) > 0) {?>
				<span class='reason' id='reason'> L&yacute; do </span>
				<?php }?>
				</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?index.php?module=users&view=commission&task=introduce&Itemid=27"); 
						$link = "#";
				?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		<!--	end 1 COMMISSION	-->
		
		<!--	2 COMMISSION : Silver	-->
		<tr >
			<?php 
			$cm_2_all = @$data_userhistory->silver ?$data_userhistory->silver:0;
			$cm_2_receive = @$data_userhistory->total_paid_silver ?$data_userhistory->total_paid_silver:0;
			$cm_2_non_receive = $cm_2_all-$cm_2_receive;
			
			$total_cm_month += $cm_2_all;
			$total_cm_receive_month += $cm_2_receive;
			$total_cm_non_receive_month += $cm_2_non_receive ;
			?>
			<td class="td-left ">2 </td>
			<td class="td-left">Hoa h&#7891;ng Silver</td>
			<td class="td-left"><?php echo format_money($cm_2_all);   ?> </td>
			<td class="td-left "><span class='red'><?php echo format_money($cm_2_receive); ?> </span></td>
			<td class="td-left ">
				
				<!-- NON RECIEVE and because				-->
				<?php echo number_format($cm_2_non_receive, 0, ',', '.'); ?>
				<?php if(($cm_2_non_receive) > 0) {?>
				<div id='tooltip-target-6' class ='reason-target' >
					<img src="images/reason.jpg" /><span class='red' > L&yacute; do </span>
				</div>
				<div id="tooltip-content-6" class="reason-content tooltip-content" >
					<p class='reason-content-head'>
						B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:
					</p>
					<p class='reason-content-body'>
						Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!
					</p>
				</div>
				<?php }?>
					
				<!-- end NON RECIEVE and because				-->
				
				
				
			</td>
				
			<td class="td-right ">    
				<?php $link  = Route::_("index.php?module=users&view=commission&task=detail&type=silver&Itemid=36");  ?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		<!--	end 2 COMMISSION	-->
		
		<!--	3 COMMISSION: Silver compress	-->
		<tr >
			<?php 
			$cm_3_all = 0;
			$cm_3_receive = 0;
			$cm_3_non_receive = $cm_3_all-$cm_3_receive;
			
			$total_cm_month += $cm_3_all;
			$total_cm_receive_month += $cm_3_receive;
			$total_cm_non_receive_month += $cm_3_non_receive ;
			?>
			<td class="td-left ">3 </td>
			<td class="td-left">Hoa h&#7891;ng n&eacute;n t&#7847;ng Silver</td>
			<td class="td-left"><?php echo $cm_3_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_3_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_3_non_receive; ?>
				<?php if(($cm_3_non_receive) > 0) {?>
				<span class='reason' id='reason'> L&yacute; do </span>
				<?php }?>
				</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?index.php?module=users&view=commission&task=introduce&Itemid=27"); 
						$link = "#";
				?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		<!--	end 3 COMMISSION	-->
		
		<!--	4 COMMISSION : EP revenue compress-->
		<tr >
			<?php 
			$cm_4_all = 0;
			$cm_4_receive = 0;
			$cm_4_non_receive = $cm_4_all-$cm_4_receive;
			
			$total_cm_month += $cm_4_all;
			$total_cm_receive_month += $cm_4_receive;
			$total_cm_non_receive_month += $cm_4_non_receive ;
			?>
			<td class="td-left ">4 </td>
			<td class="td-left">Hoa h&#7891;ng n&eacute;n t&#7847;ng doanh thu EP </td>
			<td class="td-left"><?php echo $cm_4_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_4_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_4_non_receive; ?>
				<?php if(($cm_4_non_receive) > 0) {?>
				<span class='reason' id='reason'> L&yacute; do </span>
				<?php }?>
				</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?index.php?module=users&view=commission&task=introduce&Itemid=27"); 
						$link = "#";
				?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		<!--	end 4 COMMISSION	-->
		
		<!--	5 COMMISSION : income compress	-->
		<tr >
			<?php 
			$cm_5_all = 0;
			$cm_5_receive = 0;
			$cm_5_non_receive = $cm_5_all-$cm_5_receive;
			
			$total_cm_month += $cm_5_all;
			$total_cm_receive_month += $cm_5_receive;
			$total_cm_non_receive_month += $cm_5_non_receive ;
			?>
			<td class="td-left ">5 </td>
			<td class="td-left">Hoa h&#7891;ng n&eacute;n t&#7847;ng thu nh&#7853;p </td>
			<td class="td-left"><?php echo $cm_5_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_5_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_5_non_receive; ?>
				<?php if(($cm_5_non_receive) > 0) {?>
				<span class='reason' id='reason'> L&yacute; do </span>
				<?php }?>
				</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?index.php?module=users&view=commission&task=introduce&Itemid=27"); 
						$link = "#";
				?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		<!--	end 5 COMMISSION	-->
		<!--	6 COMMISSION: Gold	-->
		<tr >
			<?php 
			$cm_6_all = @$data_userhistory->gold ?$data_userhistory->gold:0;;
			$cm_6_receive = @$data_userhistory->total_paid_gold ?$data_userhistory->total_paid_gold:0;
			$cm_6_non_receive = $cm_6_all-$cm_6_receive;
			
			$total_cm_month += $cm_6_all;
			$total_cm_receive_month += $cm_6_receive;
			$total_cm_non_receive_month += $cm_6_non_receive ;
			?>
			<td class="td-left ">6 </td>
			<td class="td-left">Hoa h&#7891;ng Gold</td>
			<td class="td-left"><?php echo format_money($cm_6_all);   ?> </td>
			<td class="td-left "><span class='red'><?php echo format_money($cm_6_receive); ?> </span></td>
			<td class="td-left ">
				
				<!-- NON RECIEVE and because				-->
				<?php echo number_format($cm_6_non_receive, 0, ',', '.'); ?>
				<?php if(($cm_6_non_receive) > 0) {?>
				<div id='tooltip-target-10' class ='reason-target' >
					<img src="images/reason.jpg" /><span class='red' > L&yacute; do </span>
				</div>
				<div id="tooltip-content-10" class="reason-content tooltip-content" >
					<p class='reason-content-head'>
						B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:
					</p>
					<p class='reason-content-body'>
						Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!
					</p>
				</div>
				<?php }?>
					
				<!-- end NON RECIEVE and because				-->
			</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?module=users&view=commission&task=detail&type=gold&Itemid=35"); ?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		
		<!--	end 6 COMMISSION	-->
		<!--	7 COMMISSION	-->
		<tr >
			<?php 
			$cm_7_all = 0;
			$cm_7_receive = 0;
			$cm_7_non_receive = $cm_7_all-$cm_7_receive;
			
			$total_cm_month += $cm_7_all;
			$total_cm_receive_month += $cm_7_receive;
			$total_cm_non_receive_month += $cm_7_non_receive ;
			?>
			<td class="td-left ">7 </td>
			<td class="td-left">Hoa h&#7891;ng n&eacute;n t&#7847;ng Gold</td>
			<td class="td-left"><?php echo $cm_7_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_7_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_7_non_receive; ?>
				<?php if(($cm_7_non_receive) > 0) {?>
				<span class='reason' id='reason'> L&yacute; do </span>
				<?php }?>
				</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?index.php?module=users&view=commission&task=introduce&Itemid=27"); 
						$link = "#";
				?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		<!--	end 7 COMMISSION	-->
		
			<!--	8 COMMISSION	-->
		<tr >
			<?php 
			$cm_8_all = 0;
			$cm_8_receive = 0;
			$cm_8_non_receive = $cm_8_all-$cm_8_receive;
			
			$total_cm_month += $cm_8_all;
			$total_cm_receive_month += $cm_8_receive;
			$total_cm_non_receive_month += $cm_8_non_receive ;
			?>
			<td class="td-left ">8 </td>
			<td class="td-left">Hoa h&#7891;ng n&eacute;n t&#7847;ng gian h&agrave;ng tr&#7921;c tuy&#7871;n</td>
			<td class="td-left"><?php echo $cm_8_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_8_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_8_non_receive; ?>
				<?php if(($cm_8_non_receive) > 0) {?>
				<span class='reason' id='reason'> L&yacute; do </span>
				<?php }?>
				</td>
			<td class="td-right ">
				<?php $link  = Route::_("index.php?index.php?module=users&view=commission&task=introduce&Itemid=27"); 
						$link = "#";
				?>
				<a href="<?php echo $link; ?>" ><span class='cm-read-more'>Xem chi ti&#7871;t 	&#187;</span></a>
		    </td>
		</tr>	
		
		<tr class="bold">
			<td class="td-left tbl_footer" colspan="2"> T&#7893;ng s&#7889; </td>
			<td class="td-left tbl_footer"><?php echo $total_cm_month; ?> </td>
			<td class="td-left tbl_footer red"><?php echo $total_cm_receive_month; ?></td>
			<td class="td-left tbl_footer"><?php echo $total_cm_non_receive_month; ?> </td>
			<td class="td-right">&nbsp;</td>
		</tr>		
	</table>
	<!-- ENd TABLE 							-->
	
	
</div>
<br/>		
						