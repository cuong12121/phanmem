<?php include_once 'libraries/form/form.php';?>
<div class="frame_display  messages">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>
		<?php $task = FSInput::get('task','inbox');?>	
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class="title">
			<a class="button4" href="<?php echo FSRoute::_('index.php'); ?>" ><span>Soạn tin mới <img alt="a" src="<?php echo  URL_ROOT.'modules/messages/assets/images/arrow-r.gif'; ?>" /> </span></a>
			<?php if($task == 'inbox') {?>
				<a class="button4" href="<?php echo FSRoute::_('index.php'); ?>" ><span> Tin đã nhận <img alt="a" src="<?php echo  URL_ROOT.'modules/messages/assets/images/arrow-b.gif'; ?>" /> </span></a>
			<?php } else { ?>
				<a class="button4" href="<?php echo FSRoute::_('index.php'); ?>" ><span> Tin đã nhận <img alt="a" src="<?php echo  URL_ROOT.'modules/messages/assets/images/arrow-b.gif'; ?>" /> </span></a>
			<?php }?>
			<a class="button4" href="<?php echo FSRoute::_('index.php'); ?>" ><span> Tin đã gửi <img alt="a" src="<?php echo  URL_ROOT.'modules/messages/assets/images/arrow-r.gif'; ?>" /> </span></a>
			</p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
						<div class="form_user_head">
							<div class="form_user_head_l">
								<div class="form_user_head_r">
									<div class="form_user_head_c">
										<span> Thông tin cá nhân của bạn</span>
									</div>					
								</div>					
							</div>					
						</div>	
						<div class="form_user_footer_body">
							<!-- TABLE 							-->
							<table cellpadding="6" cellspacing="0">
								<thead>
									<tr>
										<th>STT</th>
										<th><?php echo FSForm::orderTable("Người gửi",'receiver'); ?></th>
										<th><?php echo FSForm::orderTable("Tiêu đề",'title'); ?></th>
										<th><?php echo FSForm::orderTable("Ngày gửi",'created_time'); ?></th>
										<th><?php echo FSForm::orderTable("Kích thước",'message_size'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php for($i = 0 ; $i < count($data); $i ++ ){?>
									<?php $item = $data[$i]; ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php
												if(!$arr_lname[$item -> sender_id])
													echo "Không biết";
												else 
													echo $arr_lname[$item -> sender_id];
											?>
											</td>
											<td><?php echo $item -> title;  ?></td>
											<td><?php echo date('d-m-Y',strtotime($item -> created_time )); ?></td>
											<td><?php echo $item -> message_size; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>	
							<!-- ENd TABLE 							-->
								<div class="footer_form">
									<?php if(@$pagination) {?>
									<?php echo $pagination->showPagination();?>
									<?php } ?>
								</div>
							<!-- BUTTON				-->
							<!--<div class="form_button">
							<?php 
							$Itemid = FSInput::get('Itemid');
							$link_edit = FSRoute::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
							$link_upgrade = FSRoute::_("index.php?module=users&task=upgrade&Itemid=$Itemid");
							 
							?>
								<a href="<?php echo $link_edit; ?>" class="button3"><span>Thay đổi thông tin cá nhân &#187;</span></a>
								<a href="<?php echo $link_upgrade; ?>" class="button3"><span>Nâng cấp thành viên &#187;</span></a>
							</div>-->
							<!-- end BUTTON				-->
						</div>
						<div class="form_user_footer">
							<div class="form_user_footer_l">
								<div class="form_user_footer_r">
									<div class="form_user_footer_c">
									</div>					
								</div>					
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
