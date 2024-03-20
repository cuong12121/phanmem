<div class="form_user_head">
	<div class="form_user_head_l">
		<div class="form_user_head_r">
			<div class="form_user_head_c">
				<span class='title_tlb_left'>Hoa h&#7891;ng l&atilde;nh &#273;&#7841;o  </span>
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
	<table cellpadding="6" cellspacing="0" border="1"  bordercolor="#cecece">
		<tr >
			<td width="5%" class="td-left tbl_head">STT </td>
			<td width="35%" class="td-left tbl_head">Lo&#7841;i hoa h&#7891;ng  </td>
			<td width="15%" class="td-left tbl_head">T&#7893;ng hoa h&#7891;ng  </td>
			<td width="15%" class="td-left tbl_head">Hoa h&#7891;ng &#273;&#432;&#7907;c nh&#7853;n </td>
			<td width="17%" class="td-left tbl_head">Hoa h&#7891;ng ch&#432;a &#273;&#432;&#7907;c nh&#7853;n  </td>
			<td width="13%" class="td-right tbl_head">Chi ti&#7871;t  </td>
		</tr>	
		
		<!--	1 COMMISSION	-->
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
			<td class="td-left">Hoa h&#7891;ng v&ocirc; c&ugrave;ng cho gian h&agrave;ng tr&#7921;c tuy&#7871;n   </td>
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
		
		<!--	2 COMMISSION	-->
		<tr >
			<?php 
			$cm_2_all = 0;
			$cm_2_receive = 0;
			$cm_2_non_receive = $cm_2_all-$cm_2_receive;
			
			$total_cm_month += $cm_2_all;
			$total_cm_receive_month += $cm_2_receive;
			$total_cm_non_receive_month += $cm_2_non_receive ;
			?>
			<td class="td-left ">2 </td>
			<td class="td-left">Hoa h&#7892;ng &#273;&#7891;ng h&#432;&#7903;ng doanh thu n&acirc;ng c&#7845;p th&agrave;nh vi&ecirc;n Silver  </td>
			<td class="td-left"><?php echo $cm_2_all;   ?> </td>
			<td class="td-left "><span class='red'><?php echo $cm_2_receive; ?> </span></td>
			<td class="td-left ">
				<?php echo $cm_2_non_receive; ?>
				<?php if(($cm_2_non_receive) > 0) {?>
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
		<!--	end 2 COMMISSION	-->
		
		<!--	3 COMMISSION	-->
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
			<td class="td-left">Hoa h&#7891;ng &#273;&#7891;ng h&#432;&#7903;ng doanh thu EP </td>
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
		
		<!--	4 COMMISSION	-->
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
			<td class="td-left">Hoa h&#7891;ng &#273;&#7891;ng h&#432;&#7903;ng doanh thu n&acirc;ng c&#7845;p th&agrave;nh vi&ecirc;n Gold </td>
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
		
		<!--	5 COMMISSION	-->
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
			<td class="td-left">Hoa h&#7891;ng &#273;&#7891;ng h&#432;&#7903;ng doanh thu gian h&agrave;ng tr&#7921;c tuy&#7871;n </td>
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
		
		<tr class="bold">
			<td class="td-left tbl_footer" colspan="2"> T&#7893;ng s&#7889; </td>
			<td class="td-left tbl_footer"><?php echo $total_cm_month; ?> </td>
			<td class="td-left tbl_footer red"><?php echo $total_cm_receive_month; ?></td>
			<td class="td-left tbl_footer"><?php echo $total_cm_non_receive_month; ?> </td>
			<td class="td-right"> &nbsp;</td>
		</tr>	
	</table>
	<!-- ENd TABLE 							-->
	
	
</div>
<br/>		
						