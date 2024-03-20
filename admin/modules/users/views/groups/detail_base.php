<table cellspacing="1" class="admintable">
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_checkbox(FSText ::_('Published'),'published',@$data -> published,1);
	?>

	<div class="roles-wrap">
		<div class="role-title">Phân quyền</div>
		<div class="wrap-module">
			<?php foreach ($list_module as $module_it) { ?>
				<div class="module-item">
					<div class="title-md">
						<?php echo $module_it-> module ?>
					</div>
					<div class="wrap-view">
						<?php foreach ($arr_view[$module_it->module] as $view_it) { ?>
							<div class="view-item">
								<div class="title-v">
									<?php echo $view_it-> view ?>
									<!-- <span onclick="select_view_all()">Chọn cả</span>
									<span onclick="unselect_view_all()">Bỏ cả</span> -->
								</div>
								<div class="wrap-task">
									<?php foreach ($arr_task[$module_it->module][$view_it->view] as $task_it) {
										$checked = '';
										$pos = strpos($data-> str_task,','.$task_it->id.',');
										if ($pos !== false) {
										    $checked = 'checked';
										}
									?>
										<div class="title-task">
											<input <?php echo $checked; ?> type="checkbox" class="checkbox-task" name="check_task[]" value="<?php echo $task_it-> id ?>">
											<?php echo $task_it-> description ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>


</table>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/groups.css' ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/groups.js' ?>"></script>
