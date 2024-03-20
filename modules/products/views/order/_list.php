<?php 
//global $tmpl;
//$tmpl -> addScript('form');
//$Itemid = FSInput::get('Itemid');
//$noWord = 30; // limit char
//$url = $_SERVER["REQUEST_URI"]; 
//$fsform = FSFactory::getClass('fsform','form');
//if(isset($_GET['filter'])){
//	$filter = $_GET['filter'];
//} 
//else{
//	$filter = '';		
//}
?>
<?php 
/*
 * Tuan write
 */
    global $tmpl;
    $tmpl->setTitle($title);
    $tmpl -> addStylesheet("users_logged","modules/users/includes/css");
    $tmpl -> addStylesheet("jquery-ui","libraries/jquery/datepicker");
    $tmpl -> addStylesheet("datepicker","libraries/jquery/datepicker");
    $tmpl -> addScript("money","modules/users/includes/js");
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
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
						<?php 
						$link_action = "index.php?module=products&view=order";
						$link_action .= "&service=".FSInput::get('service');
						if(FSInput::get('date_from')&& FSInput::get('date_to'))
							$link_action .= "&date_from=".FSInput::get('data_from')."&date_to=".FSInput::get('data_to');
						$link_action .= '&Itemid=45';
						$link_action = FSRoute::_($link_action);
						?>
                       		<div class='prd_search_area'>
							<form action="<?php echo $link_action?>" method="get" name="frm_search_pro_inse"  >
								<p><b>Từ ngày :</b>
								<input type="text" name='date_from' id='date_from' value ="<?php echo FSInput::get('date_from'); ?>"/>
								<b>Đến ngày :</b>
								<input type="text" name='date_to' id='date_to' value ="<?php echo FSInput::get('date_to');?>" />
								
								<input type="submit" value="Tìm kiếm" class='button11' ></p>
								<input type="hidden" name='module' value='products' />
								<input type="hidden" name='view' value='order' />
								<input type="hidden" name='Itemid' value='<?php echo FSInput::get('Itemid',1,'int'); ?>' />
							</form>
						</div>
						
							<div class="form_user_footer_body">
									<!-- TABLE 							-->
									<table cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE">
										<thead>
											<tr>
												<th width="30">STT</th>
												<th>Thông tin đơn hàng </th>
												<th width="117" ><?php echo $fsform -> orderTable("Doanh số EP",'total_after_discount'); ?></th>
												<th width="117"><?php echo $fsform -> orderTable("Ngày đặt hàng ",'created_time'); ?></th>
												<th width="117"><?php echo $fsform -> orderTable("Trạng thái ",'status'); ?></th>
												<th width="117"><?php echo '&nbsp'; ?></th>
											</tr>
										</thead>
										<tbody>
											<?php for($i = 0 ; $i < count($data); $i ++ ){?>
											<?php
												 $item = $data[$i];
												 $link_view =FSRoute::_('index.php?module=products&view=order&id='.$item->id.'&task=detail&Itemid=23');
												 $add_url = "";
												 if(FSInput::get('sortby'))
												 {
												 	$add_url .= '&sortby='.FSInput::get('sortby');	
												 }
												 if(FSInput::get('sort'))
												 {
												 	$add_url .= '&sort='.FSInput::get('sort');	
												 }
											?>
												<tr class='row<?php echo ($i%2); ?>'>
													<td align="center">
														<strong><?php echo ($i+1); ?></strong><br/>
													</td>
													
													<td> 
														<?php 
													 	$estore_code = 'DH';
													 	$estore_code .= str_pad($item -> id, 8 , "0", STR_PAD_LEFT);
														?>
														<p>M&#227; &#273;&#417;n h&#224;ng: <span class='orange'><?php echo $estore_code ?></span><br/></p>
														<p>	T&#7893;ng ti&#7873;n <strong class='orange'><?php  echo format_money($item -> total_after_discount); ?> </strong></p>
													</td>
													
													<!--		PRICE EPS	-->
													<td> 
														<strong class='prd_price_eps orange'>
															<?php
															echo calculate_eps_value($item -> total_before_discount - $item -> total_after_discount); ?>
														</strong> EP
													</td>
													<td>
														<?php echo date('d/m/Y',strtotime($item->created_time));?>
													</td>
													<td><?php 
														echo $this -> showStatus($item -> status);
													?></td>
													<td><a href='<?php echo $link_view; ?>'> Xem chi ti&#7871;t </a></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>	
								<!-- ENd TABLE 							-->
									
								<!-- BUTTON				-->
								<!--<div class="form_button">
								<?php 
								
								$link_edit =FSRoute::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
								$link_upgrade =FSRoute::_("index.php?module=users&task=upgrade&Itemid=$Itemid");
								?>
									<a href="<?php echo $link_edit; ?>" class="button3"><span>Thay &#273;&#7893;i th&#244;ng tin c&#225; nh&#226;n &#187;</span></a>
									<a href="<?php echo $link_upgrade; ?>" class="button3"><span>N&#226;ng c&#7845;p th&#224;nh vi&#234;n &#187;</span></a>
								</div>-->
								<!-- end BUTTON				-->
							</div>
							<div class="form_user_footer">
								<div class="form_user_footer_l">
									<div class="form_user_footer_r">
										<div class="form_user_footer_c">
											<div class="footer_form">
													<?php if(@$pagination) {?>
													<?php echo $pagination->showPagination();?>
													<?php } ?>
											</div>
											
											
										</div>					
									</div>					
								</div>					
							</div>		
							
							
							<input type="hidden" name="sort" value="<?php echo FSInput::get('sort',''); ?>">
							<input type="hidden" name="sortby" value="<?php echo FSInput::get('sortby',''); ?>">
							
							<input type="hidden" name="module" value="products">
							<input type="hidden" name="view" value="order">
							<input type="hidden" name="Itemid" value="<?php echo FSInput::get('Itemid'); ?>">
						</form>			
						<!-- end FORM	MAIN - ORDER						-->
						
					</div>
				</div>
				
			</div>	
		</div>	
<script type="text/javascript">
<?php 
$url = $_SERVER['REQUEST_URI'];
$url =  trim(preg_replace('/&filter=[0-9]+/i', '', $url));
?>
link = '<?php echo $url;?>';
$('#filter').change(function(){
	status = $('#filter').val();
	if(status){
		link +=  '&filter='+status;
	}
	window.location = link;
});
	
</script>
		
