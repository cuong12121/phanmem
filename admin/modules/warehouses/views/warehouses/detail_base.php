<table cellspacing="1" class="admintable">
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);

	?>
	<div>
		<label for="parent" class="col-md-2 col-xs-12 ">Kho cha</label>

		<div class="col-md-10 col-xs-12">	
			<select name="parent" id="parent" class="form-control">

			  	<option value="0">Không chọn</option>

			  	<?php 
			  		foreach ($datas as $key => $value) :
			  			# code...
			  		
			  	?>
			  	<option value="<?= $value->id ?>"> <?= $value->name ?></option>
			  	<?php 
			  		endforeach;
			  	?>
			  	
			</select>
		</div>
	</div>
	

	<?php
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,5,0);
	TemplateHelper::dt_checkbox(FSText ::_('Published'),'published',@$data -> published,1);
	?>
</table>
