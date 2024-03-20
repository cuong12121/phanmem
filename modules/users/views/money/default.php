<?php 
/*
 * Tuan write
 */
    global $tmpl;
    $tmpl->setTitle($title);
    $tmpl -> addStylesheet("users_logged","modules/users/assets/css");
    $tmpl -> addStylesheet("jquery-ui","libraries/jquery/datepicker");
    $tmpl -> addStylesheet("datepicker","libraries/jquery/datepicker");
    $tmpl -> addScript("money","modules/users/assets/js");
    $tmpl -> addScript("jquery.ui.core","libraries/jquery/datepicker");
    $tmpl -> addScript("jquery.ui.datepicker","libraries/jquery/datepicker");
    
    //$Itemid = FSInput::get('Itemid',1);
    //$redirect = FSInput::get('redirect');
    
    $page = FSInput::get('page');
	if(!$page)
		$tmpl->addTitle($title);
	else 
		$tmpl->addTitle($title.' - Trang '.$page);
    
?>  
<div id="login-form" class ="frame_large" >
    <div class="frame_large_head">
        <div class="frame_large_head_l">
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="frame_large_head_r">&nbsp;
        </div>
    </div>
    <div class="frame_large_body">
           
            <!--   FRAME COLOR        -->
            <div class='frame_color'>
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                    	<?php 
						$link_action = "index.php?module=users&view=money";
						$link_action .= "&service=".FSInput::get('service');
						if(FSInput::get('date_from')&& FSInput::get('date_to'))
							$link_action .= "&date_from=".FSInput::get('data_from')."&date_to=".FSInput::get('data_to');
						$link_action .= '&Itemid=107';
						$link_action = FSRoute::_($link_action);
						?>
                       		<div class='prd_search_area'>
							<form action="<?php echo $link_action?>" method="get" name="frm_search_pro_inse"  >
								<p><b>Từ ngày :</b>
								<input type="text" name='date_from' id='date_from' value ="<?php echo FSInput::get('date_from'); ?>"/>
								<b>Đến ngày :</b>
								<input type="text" name='date_to' id='date_to' value ="<?php echo FSInput::get('date_to');?>" />
								<b>Dịch vụ</b>
								<select name="service" id="service" >
								<option value =''> -- Dịch vụ -- </option>
								
								<?php
								$total_data_list = count($data);								
									for($i = 0; $i < $total_data_list; $i ++){
										$checked = "";
										$service = $data[$i];
										if($service->service_name == FSInput::get('service'))
											$checked = " selected=\"selected\"";
								?>								
								<option value="<?php echo $service->service_name; ?>"<?php echo $checked;?>>
								<?php echo $service->service_name; ?>
								</option>
									<?php } ?>								
								</select>
								<input type="submit" value="Tìm kiếm" class='button11' ></p>
								<input type="hidden" name='module' value='users' />
								<input type="hidden" name='view' value='money' />
								<input type="hidden" name='type' value='<?php echo FSInput::get('type'); ?>' />
								<input type="hidden" name='Itemid' value='<?php echo FSInput::get('Itemid',1,'int'); ?>' />
							</form>
						</div>
                    	<br />
                    		
							<!-- PRODUCT LIST		-->
								<div class="form_user_footer_body">
								<table cellpadding="0" cellspacing="0"  border="1" bordercolor="#D1D1D1" width="100%" >
											<thead>
												<tr align="center" bgcolor="white">
													<td  width="40" ><b>STT</b></td>
													<td  width="150" ><b>Thời gian</b></td>
													<td  width="150"><b>Số tiền</b></td>
													<td ><b>Dịch vụ</b></td>
											  	</tr>
											  </thead>
											<tbody>
											<?php 												
											$total_users_list = count($list);
												if($total_users_list){
														for($i = 0; $i < $total_users_list; $i ++){
															$item = $list[$i];
															echo '<tr class="row'.($i%2).'">';
															echo "<td>";
															echo $i+1;
															echo "</td>";
															echo "<td>";
															echo date('H:i d/m/Y',strtotime($item->created_time));
															echo "</td>";
															echo "<td>";
															echo format_money($item->money);
															echo "</td>";
															echo "<td>";
															echo $item->description;
															echo "</td>";
															echo "</tr>";
															}?>
															
											</tbody>
											<tfoot>
												<tr><td colspan="7">
													<div class='pagination_t'>
														<?php if($pagination) echo $pagination->showPagination(3);
														}else{
														echo "";
														}?>
													</div>
												</td></tr>
											</tfoot>
										</table>	
								</div>		
										<!-- ENd TABLE 							-->
							<!-- end PRODUCT LIST		-->
							<div class='clear'></div>
						<!--	end SEARCH AREA	-->
                    
                   <!--  end CONTENT IN FRAME      -->
           
                    </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
            <!--   end FRAME COLOR        -->
            
           
           
        
    </div>
    <div class="frame_large_footer">
        <div class="frame_large_footer_l">&nbsp;</div>
        <div class="frame_large_footer_r">&nbsp;</div>
    </div>
   </div>