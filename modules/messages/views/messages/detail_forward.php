<?php 
global $tmpl;
$tmpl -> addScript('form');
$Itemid = FSInput::get('Itemid',0);
$link_back = FSRoute::_("index.php?module=messages&Itemid=$Itemid");
?>
						<!-- FORM							-->
							<?php $url = $_SERVER["REQUEST_URI"]; ?>
						<form action="<?php echo $url; ?>" name="fontForm" method="post" onsubmit="javascript: return checkSubmitForwardForm();">
							<div class="form_user_head">
								<div class="form_user_head_l">
									<div class="form_user_head_r">
										<div class="form_user_head_c">
											<span><strong>Chuy&#7875;n ti&#7871;p</strong> </span>
										</div>					
									</div>					
								</div>					
							</div>	
							<div class="form_user_body">
								
								<div class="form_user_body_inner">
									<div id = "msg_error_f"></div>
									<!--		FORM MAIN - MESSAGE						-->
									<table width="100%" cellpadding="5" >
										<tr>
											<td></td>
											<td>
												<span class='red'></span>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>Danh s&#225;ch ng&#432;&#7901;i nh&#7853;n</td>
											<td>
												<input type="text" name='recipients' id='recipients_f'/>
											</td>
										</tr>
										<tr>
											<td> <span class='red'>*</span>Ti&#234;u &#273;&#7873;</td>
											<td>
												<input type="text" name='subject' id='subject_f' value='<?php echo "Fwd: ".$data->subject; ?>'/>
											</td>
										</tr>
										<tr>
											<td> <span class='red'>*</span>N&#7897;i dung</td>
											<td>
												<textarea rows="8" cols="30" name='message' id='message_f'><?php echo strip_tags($data -> message); ?></textarea>
											</td>
										</tr>
										<tr>
											<td ></td>
											<td >
												<input type="submit" value="&#272;&#7891;ng &#253;" name = 'submit_bt' class='button5' />
												<br/>
												<br/>
											</td>
										</tr>
									</table>
									<!--		end FORM MAIN - MESSAGE						-->
									
								</div>
							</div>
							<input type="hidden" name="module" value="messages">
							<input type="hidden" name="view" value="messages">
							<input type="hidden" name="message_id" value="<?php echo FSInput::get('id'); ?>">
							<input type="hidden" name="task" value="save_forward">
							<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
						</form>			
