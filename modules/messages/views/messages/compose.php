<?php 
global $tmpl;
$tmpl -> addScript('form');
//$tmpl -> addScript('tiny_mce','libraries/jquery/tiny_mce');
$tmpl -> addScript('ckeditor','libraries/ckeditor_4.5.5_full','top');
$tmpl -> addScript('compose','modules/messages/assets/js');
$Itemid = FSInput::get('Itemid',0);
$link_back = FSRoute::_("index.php?module=messages&Itemid=$Itemid");
$tmpl -> addStylesheet('compose','modules/messages/assets/css');
$tmpl -> addStylesheet('messages','modules/messages/assets/css');
//$tmpl -> addStylesheet('products_list','modules/estores/assets/css');
$tmpl -> addStylesheet('detail','modules/messages/assets/css');
?>
<h1 >
                    <span><?php echo FSText::_('Soạn mail'); ?></span>
                    
      </h1>
<div class="container-profile row-cl">
    <div class="row">
        
        <div class="frame_display col-sm-12 col-xs-12 <?php echo $tmpl->count_block('pos2')? 'col-md-8':'col-md-12'; ?>">
                <div class="frame-display-ct row-cl">
                	<div class="frame_head">
                		<?php global $tmpl;?>
                		<?php $task = FSInput::get('task','inbox');?>	
                	</div>
                    
                	<div class="form_body">
                			<!-- FORM							-->
                				<?php $url = $_SERVER["REQUEST_URI"]; ?>
                			<form action="<?php echo $url; ?>" id="fontForm" name="fontForm" method="post">
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
                				<div class="form_user_body">
                						<div id = "msg_error"></div>
                						<!--		FORM MAIN - MESSAGE						-->
                                        <div class="col-item-base row-cl">
                                			<div class='value col-sm-9 col-xs-12'>
                                				<input class="text-form-control" type="text" name='recipients_username' id="recipients_username" placeholder="<?php echo FSText::_('Username người nhận') ?>" value='<?php  echo $username; ?>' />
                                            </div>
                                        </div><!-- END: .col-item-base --> 
                                        <div class="col-item-base row-cl">
                                			<div class='value col-sm-9 col-xs-12'>
                                				<input class="text-form-control" type="text" name='subject' id="subject" placeholder="<?php echo FSText::_('Tiêu đề') ?>" value='' />
                                            </div>
                                        </div><!-- END: .col-item-base --> 
                                        
                                        <div class="col-item-base row-cl">   
                                			<div class='value col-sm-9 col-xs-12'>
                                				<textarea class="text-form-control" style="height: 150px;" name='texta_message' id="message" placeholder="<?php echo FSText::_('Nội dung') ?>" ></textarea>
												<script type="text/javascript">
													 CKEDITOR.replace( 'message', {
															skin: 'icy_orange',
															 toolbarGroups: [																																			 
																{ name: 'links' },																
																{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
																{ name: 'paragraph',   groups: [ 'align' ] },
																{ name: 'styles' },
																{ name: 'colors' },
															],
															
														
														 	// skin: 'icy_orange',
															// toolbar: [
																// { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
																// { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
																// '/',																// Line break - next group will be placed in new line.
																// { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
																// { name: 'links' }
		
																	// { name: 'about', items: [ 'base64image','Smiley','basicstyles' ] },
																	// { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
																	// { name: 'styles' },
																	// { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
																	// [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
																	
																	// '/',
																	// { name: 'about', items: [ 'base64image','Smiley','basicstyles' ] }
																// ],
													    	 // toolbar:    
													    		 // [  
						// //							    		  		{ name: 'about', items: [ 'base64image','Smiley','basicstyles' ] },
																		// { name: 'editing',     items: [ 'find', 'selection', 'spellchecker' ] },
																		
																		// { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
																		// { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
																		// { name: 'links' },
																		// { name: 'insert' },
																		// { name: 'forms' },
																		// { name: 'tools' },
																		// { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
																		// { name: 'others' },
																		// '/',
																		// { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
																		// { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
																		// { name: 'styles' },
																		// { name: 'colors' }
		
													    		 // ],   
												    		 //extraPlugins: 'base64image,smiley',
												    		width : "500",
													    	height : "200"
													});
									            </script>     
											</td>
                                            </div>  
                                        </div><!-- END: .col-item-base -->
                                        
                                        <div class="col-item-base row-cl">
                                            <div class="lable col-md-9 col-md-offset-3">
                                                <a class="button4 reply_bt" href="javascript:void(0);" onclick="javascript: sendMail();" ><span><?php echo FSText::_('Send') ?></span></a>
            									<a class="button4 reply_bt" href="javascript:window.location = '<?php echo $link_back; ?>';" ><span><?php echo FSText::_('Quay lại') ?></span></a>
                                            </div>
                                        </div><!-- END: .col-item-base -->
                						<!--		end FORM MAIN - MESSAGE						-->
                				</div>
                                <input type="hidden" name="sender_id" value="<?php echo $_COOKIE['user_id']; ?>" />
                                <input type="hidden" name="sender_username" value="<?php echo FSInput::get('username'); ?>" />
                    
                				<input type="hidden" name="module" value="messages" />
                				<input type="hidden" name="view" value="messages"/>
                				<input type="hidden" name="task" value="save_compose"/>
                				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
                			</form>	<!-- END FORM -->		
                    </div><!-- END: .form_body -->
                </div><!-- END: .frame-display-ct -->
            </div><!-- end: .frame_display -->
      </div> <!-- end: .row -->         
</div><!-- END: .container-profile --> 
