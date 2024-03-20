<?php 
global $tmpl;
$tmpl -> addScript('form');
//$tmpl -> addScript('thickbox','libraries/jquery/thickbox');
//$tmpl -> addStylesheet('thickbox','libraries/jquery/thickbox');
$tmpl -> addStylesheet('messages','modules/messages/assets/css');
//$tmpl -> addStylesheet('products_list','modules/estores/assets/css');
$tmpl -> addStylesheet('detail','modules/messages/assets/css');
$Itemid = FSInput::get('Itemid');
?>
<?php $fsform = FSFactory::getClass('fsform','form'); ?>
<h1 >
                    <span><?php echo FSText::_('Thư đã gửi'); ?></span>
                    
      </h1>
      
<div class="container-profile row-cl">
                
    <div class="row">
        
        <div class="frame_display col-sm-12 col-xs-12 <?php echo $tmpl->count_block('pos2')? 'col-md-8':'col-md-12'; ?>">
            <div class="frame-display-ct row-cl">
            	<div class="frame_head">
            		<?php global $tmpl;?>
            		<?php $task = FSInput::get('task','inbox');?>	
            	</div><!-- END: .frame_head -->
                
        		<div class="form_body row-cl">
    						<!-- FORM							-->
            					<?php $url = $_SERVER["REQUEST_URI"]; ?>
            				<form action="<?php echo $url; ?>" name="fontForm" method="post">
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
                                	
    							<div class="form_user_footer_body">
    									<div id = "msg_error"></div>
    									<div class="content-inbox row-cl">
											<?php for($i = 0 ; $i < count($data); $i ++ ){?>
											<?php
												 $item = $data[$i];
												 $readed = strstr($item -> readers_id , "'".$_COOKIE['user_id']."'");
												 $readed  = ($readed === false) ? 'unread': '';
												 $link_view = FSRoute::_("index.php?module=messages&view=messages&task=detail&id=".$item->id."&Itemid=".$Itemid."");
												 $link_view_fast = FSRoute::_("index.php?module=messages&task=view_fast&raw=1&id=".$item->id."&Itemid=".$Itemid."");
												 if($item->recipients_id){
													 $arr_recipients_username = explode(',',$item->recipients_username);
													 $first_member_recipient_username = str_replace("'","",$arr_recipients_username[0]);
													 $arr_recipients_userid = explode(',',$item->recipients_id);
													 $first_member_recipient_userid = str_replace("'","",$arr_recipients_userid[0]);
												 }
            									 $link_member = FSRoute::_("index.php?module=members&view=member&username=".@$first_member_recipient_username."&id=".@$first_member_recipient_userid);
											?>
												<div class='item-inbox row-cl row<?php echo ($i%2) . ' '. $readed; ?>'>
													<div class="form-item-checkbox indicator row-cl">
            												 <?php if(!@$arr_member[$first_member_recipient_userid] -> image){ ?>
            														  <a class="email-sender" href="<?php echo $link_member; ?>" >
            														  	<img src="<?php echo URL_ROOT.'images/no-avatar.jpg'; ?>" width="80" height="80" />
            												 		</a>
                                                                    <?php }else{ ?>
                                                                        <a class="email-sender" href="<?php echo $link_member; ?>" >
                                                                        	<img src="<?php echo URL_ROOT.$arr_member[$first_member_recipient_userid] -> image; ?>" width="80" height="80" />	
                                                                        </a>
            														<?php } ?>
                                                    </div><!-- END: .form-item-checkbox -->
                                                    
													<div class="item-inbox-view row-cl">
                                                         <div class="item-inbox-link row-cl">
                                                            <a class="email-recipient" href="<?php echo $link_member;?>" >
    															<?php echo @$first_member_recipient_username; ?>
    														</a>
                                                            <p class="created_time"><?php echo show_datetime($item -> created_time ); ?></p>
                                                            <div class='clear'></div>
                                                        </div><!-- END: .item-inbox-link -->
                                                        
                                                        
                                                        <?php 
    													   $link_del = FSRoute::_("index.php?module=messages&task=delete&last_task=outbox&id=".$item->id."&Itemid=$Itemid&")
    													?>
                                                        <div class="item-view-content row-cl">
                                                            <a class="item-delete" href="<?php echo $link_del; ?>">
                                                                <img src="<?php echo  URL_ROOT.'modules/messages/assets/images/icon-delete.png'; ?>" alt="del"  />
                                                            </a>
                                                            <a class="item-delete" href="<?php echo $link_view; ?>">
                                                                <img src="<?php echo  URL_ROOT.'modules/messages/assets/images/icon-edit.png'; ?>" alt="view"  />
                                                            </a>
                                                                   <p class='subject'>
	                                                                   	<a class="" href="<?php echo $link_view; ?>" >
	                                                                   		<?php echo $item -> subject;  ?></p>
	                                                                   	</a>
<!--																		<?php // echo $item -> message;  ?></p>-->
																	<p>
                                                                    <div class='clear'></div>
                                                        </div><!-- END: .item-view-content -->
													</div><!-- END: .item-inbox-view -->
                                                    
<!--													<div><?php echo $item -> message_size ? $item -> message_size : 0; ?> B</div>-->
											
<!--													<div><a title="Xem tin nh&#7855;n"  class="thickbox"  href="<?php echo $link_view_fast; ?>">Xem</a></div>-->
            											<div class='clear'></div>
												</div><!-- END: .item-inbox -->
											<?php } ?>
    							     </div><!-- END: .content-inbox -->
    								
                                    	
    								<!-- <div class="form_button">
    								<?php 
    								//$link_edit = FSRoute::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
    								//$link_upgrade = FSRoute::_("index.php?module=users&task=upgrade&Itemid=$Itemid");
    								?>
    									<a href="<?php //echo $link_edit; ?>" class="button3"><span>Thay &#273;&#7893;i th&#244;ng tin c&#225; nh&#226;n &#187;</span></a>
    									<a href="<?php //echo $link_upgrade; ?>" class="button3"><span>N&#226;ng c&#7845;p th&#224;nh vi&#234;n &#187;</span></a>
    								</div> -->
                                    
                                    
    							</div><!-- END: .form_user_footer_body -->
                                		
    							<div class="footer_form">
    									<?php if(@$pagination) {?>
    									   <?php echo $pagination->showPagination();?>
    									<?php } ?>
    							</div><!-- END: .footer_form -->
    							
    							<input type="hidden" name="sort" value="<?php echo FSInput::get('sort',''); ?>">
    							<input type="hidden" name="sortby" value="<?php echo FSInput::get('sortby',''); ?>">
    							
    							<input type="hidden" name="module" value="messages">
    							<input type="hidden" name="view" value="messages">
    							<input type="hidden" name="task" value="">
    							<input type="hidden" name="last_task" value="outbox">
    							<input type="hidden" name="boxchecked" value="0">
    							<input type="hidden" name="Itemid" value="<?php echo FSInput::get('Itemid'); ?>">
    						</form><!-- END: FORM  -->			
                </div><!-- END: .form_body -->
            	</div>
            </div>
		</div><!-- END: .frame_display -->
    </div>
</div><!-- END: .container-profile -->

