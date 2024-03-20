<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách các  block hiển thị') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
?>

<div class="form_body">
	<form action="index.php?module=module" name="adminForm" method="post">
		<div  class="filter_area">
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo FSText :: _( 'Search' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo @$_SESSION['module_search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo FSText :: _( 'Search' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo FSText :: _( 'Reset' ); ?></button>
					</td>
					<td nowrap="nowrap">
						<select name="type" class="type" onChange="this.form.submit()">
							<option value="0">T&#7845;t c&#7843; c&#225;c lo&#7841;i</option>
							<?php
							$type_select  = $_SESSION['module_type'];
							foreach($listmoduletype as $item){
								if($item->block == $type_select){
									echo "<option value='" . $item->block . "' selected='selected'>" . $item->name . "</option>";
								}
								else{
									echo "<option value='" . $item->block . "'>" . $item->name . "</option>";
								}
							}
							?>
						</select>
					</td>
					<td nowrap="nowrap">
						<select name="position" class="pos" onChange="this.form.submit()">
							<option value="0">T&#7845;t c&#7843; c&#225;c v&#7883; tr&#237;</option>
							<?php
							$pos_select  = isset($_SESSION['module_position'])?$_SESSION['module_position']:'';
							foreach($positions as $key => $p){
								if($p == $pos_select){
									echo "<option value='" . $key . "' selected='selected'>" . $p . "</option>";
								}
								else{
									echo "<option value='" . $key . "'>" . $p . "</option>";
								}
							} 
							?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div class="form-contents">

			<table class="tbl_form_contents" cellpadding="5" bordercolor="#CCC" border="1">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($listmodule); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo TemplateHelper::orderTable(FSText :: _('Name'),'title',$sort_field,$sort_direct); ?>
					</th>
					
					<th class="title" width="10%">
						<?php echo FSText :: _('Lo&#7841;i'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo TemplateHelper::orderTable(FSText :: _('Ordering'),'ordering',$sort_field,$sort_direct); ?>
					</th>
					<th class="title" width="7%">
						<?php echo TemplateHelper::orderTable(FSText :: _('Published'),'published',$sort_field,$sort_direct); ?>
					</th>
					<th class="title" width="10%">
						<?php echo TemplateHelper::orderTable(FSText :: _('V&#7883; tr&#237;'),'position',$sort_field,$sort_direct); ?>
					</th>
					<th class="title" width="7%">
						<?php echo TemplateHelper::orderTable(FSText :: _('Id'),'id',$sort_field,$sort_direct); ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php foreach ($listmodule as $row) { 
						$link_detail = 'index.php?module=module&task=edit&cid='.$row->id;
						?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td>
								<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="cid[]" id="cb<?php echo $i; ?>">
							</td>
							<td><a href='<?php echo $link_detail; ?>'><?php echo $row->title; ?></a></td>
							<td><?php echo isset($listmoduletype[$row->module])?$listmoduletype[$row->module]->name:$row->module; ?></td>
							<td><?php echo $row->ordering; ?></td>
							<td><?php echo TemplateHelper::published("cb".($i),$row->published?"unpublished":"published"); ?></td>
							<td><?php echo $positions[$row->position]; ?></td>
							<td><?php echo $row->id; ?></td>
						</tr>
						<?php $i++; ?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php echo $pagination->showPagination();?>
		</div>
		<input type="hidden" value="<?php echo $sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo $sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="module" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>