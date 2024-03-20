  <link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="templates/default/js/jquery.1.4/jquery.js"></script>
<script type="text/javascript" src="templates/default/js/jquery-ui.min.js"></script>
<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
	<?php
	$title = FSText :: _('Cấu hình giao diện gian hàng'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	
//	$this -> dt_form_begin();
//		
//	TemplateHelper::dt_edit_text(FSText :: _('Tên gian hàng'),'name',@$data -> name);
//	TemplateHelper::dt_edit_selectbox(FSText::_('Template (Giao diện)'),'template',@$data -> template,0,$template,$field_value = 'id', $field_label='name',$size = 10,0);	
//	$this -> dt_form_end(@$data);
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
  		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Tên gian hàng'); ?><
				</td>
				<td>
					<input type="text" name='name' value="<?php echo @$data->name; ?>" size="70" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Template (Giao diện)'); ?>
				</td>
				<td>
					<select name="etemplate_id"  id="etemplate_id" size="10">
						<?php 
						
						// selected category
						
						if(isset($data->etemplate_id)){
							$compare = $data->etemplate_id;
						} else {
							$compare = 0;
						}
						foreach ($template as $item) {
							$checked = "";
							if($compare == $item->id)
								$checked = "selected=\"selected\"";
								
						?>
							<option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>	
						<?php }?>
					</select>
					<div id="etemplate_image" class="etemplate_image">
						<?php if(isset($data->etemplate_id)){
							 $select_img = $data->etemplate_id;
						}else {
							 $select_img = 0;
						 }
						 foreach ($template as $item) {
							if($select_img == $item->id){?>
								<img src=<?php echo URL_ROOT.@$item->image; ?>>
						<?php 
							}
						 }
						 ?>
					</div>
				</td>
			</tr>
  		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
  <script type="text/javascript">

	  $('#etemplate_id').change(function(){
			template = $(this).val();		
//			html = '<img src=\''+root+'templates/estores/'+template+'/template_small.jpg'+'\' />';
			html = '<img src=\'/nhasachhuongthuy/code/ht_adminn/templates/estores/'+template+'/template_small.png'+'\' />';
			$('#etemplate_image').html(html);
		})

  </script>
  <style>
	  #etemplate_id {
	      border: 1px solid #CCCCCC;
	      float: left;
	      height: 274px;
	      width: 201px;
	  }
	.etemplate_image {
	    border: 2px solid #CCCCCC;
	    float: left;
	    height: 270px;
	    margin-left: 10px;
	    text-align: center;
	    width: 280px;
	}  
	.etemplate_image img{
	    width: 195px;
	}  
  </style>
