<table cellspacing="1" class="admintable">
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);

	?>
	<div>
		<label for="parent" class="col-md-2 col-xs-12 ">Kho cha</label>

		<div class="col-md-10 col-xs-12">	
			<select name="parent" id="parent" class="form-control">

			  	<option value="0"><?= $data->parent?></option>

			  	<?php 
			  		$checked = '';
			  		foreach ($datas as $key => $value) :
			  			if(!empty($data->id)):
			  				$checked = $value->id == $data->parent?'checked':'';
			  			endif;	
			  			# code...
			  		
			  	?>
			  	<option value="<?= $value->id ?>" <?= $checked  ?>> <?= $value->name ?></option>
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
