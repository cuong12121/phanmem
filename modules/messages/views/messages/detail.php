<?php 
global $tmpl;
$tmpl -> addScript('form');
$tmpl -> addScript('tiny_mce','libraries/jquery/tiny_mce');
$tmpl -> addScript('detail','modules/messages/assets/js');
$tmpl -> addStylesheet('detail','modules/messages/assets/css');

$tmpl -> addStylesheet('messages','modules/messages/assets/css');

$Itemid = FSInput::get('Itemid');
$id = FSInput::get('id');
// sim_number of sender
$senderid = str_replace("'","",$data -> sender_id);
?>
<?php $fsform = FSFactory::getClass('fsform','form'); ?>
<h1 >
                    <span><?php echo FSText::_('Soạn mail'); ?></span>
                    
      </h1>
<div class="container-profile row-cl">
    <div class="row">
        <?php if($tmpl->count_block('pos2')) {?>
            <div class='left-program row-cl col-xs-12 col-md-4 col-sm-12'>
                <?php  echo $tmpl -> load_position('pos2'); ?>
            </div><!-- END: .left-program -->
        <?php }?>
        
        <div class="frame_display col-sm-12 col-xs-12 <?php echo $tmpl->count_block('pos2')? 'col-md-8':'col-md-12'; ?>">
            <div class="frame-display-ct row-cl">
                	<div class="frame_head">
                		<?php global $tmpl;?>
                		<?php $task = FSInput::get('task','inbox');?>	
                	</div>
                	<div class="frame_body row-cl">
                		
                		<div class="form_body row-cl">
                					<!--	MESSAGE END REPLY				-->
                					<div class="form_user">
                						<!-- FORM							-->
            					<div class="form_user_head">
            						<a href="<?php echo FSRoute::_("index.php?module=messages&view=messages&task=inbox&Itemid=45"); ?>" class='button4 reply_bt ' >
            							<span>Hộp thư đến</span>
            						</a>
            						<a href="<?php echo FSRoute::_("index.php?module=messages&view=messages&task=outbox&Itemid=45"); ?>" class='button4 reply_bt ' >
            							<span>Thư đã gửi</span>
            						</a>
            						<a href="<?php echo FSRoute::_("index.php?module=messages&view=messages&task=compose&Itemid=45"); ?>" class='button4 reply_bt ' id="compose-button">
            							<span>Soạn thư</span>
            						</a>
            					</div><!-- END: .form_user_head -->	
                							<div class="form_user_body row-cl">
                									<!--		FORM MAIN - MESSAGE						-->
                                                    <div class="item-inbox row-cl">
                    									   <div class='email-head'>
                        										<div class='email-head-left'>
                        											<p class='email-sender'> <?php echo FSText::_('Sender') ?>: 
                        												<?php
                        													if(!@$arr_fullname[$senderid]){
                        																echo ' <span>'.$data -> sender_username.'</span>';																
                        															}else {
                        																//echo @$arr_fullname[$senderid];
                        																echo ' <span>'.@$arr_username[$senderid].'</span>';
                        															}													
                        													?>
                        											</p>
                        											<?php if($data ->recipients_id){?>
                        												<p class='email-recipient'> <?php echo FSText::_('Recipient') ?>: 
                        													<?php
                        														$str_recipients = $data ->recipients_id;
                        														$str_recipients = str_replace("'","",$str_recipients);
                        														$arr_recipients  = explode(",",$str_recipients);
                        														if(count($arr_recipients))
                        														{
                        															$i = 0;
                        															foreach ($arr_recipients as $recipient) {
                        																if(!@$arr_fullname[$recipient]){
                        																	echo $recipient;																
                        																}else {
                        																    echo ' <span>'.@$arr_username[$recipient].'</span>';
                        																	echo ' ('.@$arr_fullname[$recipient].')';
                        																	
                        																}																
                        																
                        																if(($i+1) < count($arr_recipients))
                        																{
                        																	echo ", ";
                        																}	
                        																$i ++;
                        															}
                        														}
                        													?>
                        												</p>
                        											<?php }?>
                        										</div>
                                                                <p class='email-head-right created_time'><?php echo show_datetime($data -> created_time); ?></p>
                                                                
                    										<div class='clear'> </div>
                    									</div><!-- END: .email-head -->
                    									<div class='email-body row-cl'>
                    										<?php echo $data -> message; ?>
                    									</div><!-- END: .email-body -->
                                                    </div><!-- END: .body-sender -->
                                                    
                									<!--		end FORM MAIN - MESSAGE						-->
                									<!--		FORM Reply - MESSAGE						-->
                									<?php 
                									if(count($replies)) { 
                										foreach ($replies as $reply) {
                									?>
                                                    <div class="item-inbox row-cl" >
                        									<div class='email-head row-cl'>
                        										<div class='email-head-left'>
                        											<p class='email-sender'> <?php echo FSText::_('Sender') ?>: 
                        												<?php
                        													
                        													if(!@$arr_fullname[$reply -> sender_id])
                        														echo "Kh&#244;ng bi&#7871;t";
                        													else 
                        														echo '<span>'.@$arr_username[$reply -> sender_id].'</span>';
                        													?>
                        											</p>
                        											<p class='email-recipient'> <?php echo FSText::_('Recipient') ?>: 
                        												<?php
                        													$str_r_recipients = $reply ->recipients_id;
                        													$str_r_recipients = str_replace("'","",$str_r_recipients);
                        													$arr_r_recipients  = explode(",",$str_r_recipients);
                        													if(count($arr_r_recipients))
                        													{
                        														$i = 0;
                        														foreach ($arr_r_recipients as $recipient) {
                        															if(!@$arr_fullname[$recipient])
                        																echo "Kh&#244;ng bi&#7871;t";
                        															else 
                        																echo '<span>'.@$arr_username[$recipient].'</span>';
                                                                                        echo ' ('.@$arr_fullname[$recipient].')';
                        																
                        															// separate	
                        															if(($i+1) < count($arr_r_recipients))
                        															{
                        																echo ", ";
                        															}	
                        															$i ++;	
                        														}
                        													}
                        												?>
                        											</p>
                        										</div>
                        										<p class='email-head-right created_time'><?php echo show_datetime($reply -> created_time); ?></p>
                        										<div class='clear'></div>
                        									</div><!-- END: .email-head -->
                        									<div class='email-body row-cl'>
                        											<?php echo $reply -> message; ?>
                        									</div><!-- END: .email-body -->
                                                    </div><!-- END: .body-email -->
                									<?php 
                										}
                									}?>
                									<!--		end FORM MAIN - MESSAGE						-->
                							</div>
                							<div class="form_user_footer row-cl">
    											<?php if($data -> sender_username != 'Admin'){?>
    												<a title="<?php echo FSText::_('Reply') ?>"  class="reply_bt button4"  href="javascript:void(0);"><span><?php echo FSText::_('Reply') ?></span></a>
    												<!-- <a title="<?php //echo FSText::_('Forward') ?>"  class="forward_bt button4"  href="javascript:void(0);"><span><?php //echo FSText::_('Forward') ?></span></a> -->
    											<?php }?>						
                							</div>		
                					</div>
                					<!--	end MESSAGE END REPLY				-->
                					
                					<!--	REPLY FROM 				-->
                					
                					<div id="reply"  style='display: none;'>
                						<?php 
                							array_push($arr_recipients,$senderid);
                							array_unique($arr_recipients);
                							$arr_members = $arr_recipients;
                							$arr_members_without_me  = array();
                							
                							for($i = 0 ; $i < count($arr_members); $i ++ )
                							{
                								if($arr_members[$i] != $_COOKIE['user_id'])
                								{
                									if(isset($arr_username[$arr_members[$i]]))
                										$arr_members_without_me[] = @$arr_username[$arr_members[$i]] ;
                								}
                							}
                							$str_members_without_me = implode("; ",$arr_members_without_me);
                							?>
                						<?php include_once 'detail_reply.php'; ?>
                					</div>
                					<!--	end REPLY FROM 				-->
                					
                					<!--	FORWARD FROM 				-->
                					<div id="forward" style='display: none;'>
                						<?php include_once 'detail_forward.php'; ?>
                					</div>
                					<!--	end FORWARD FROM 				-->
               	
                		</div>	
                </div>
            </div>
        </div><!-- end: .frame_display -->
    </div>
</div><!-- END: .container-profile -->
