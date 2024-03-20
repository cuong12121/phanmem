<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
    
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Menu'));
    global $position;

    TemplateHelper::dt_edit_selectbox(FSText::_('Group'),'group_id',@$data->group_id,0,$groups,$field_value = 'id', $field_label='group_name',$size = 1,0);
    //TemplateHelper::dt_checkbox(FSText::_('Lọc nhóm'),'filter_group',0,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data->parent_id,0,$list,$field_value = 'id', $field_label='treename',$size = 1,0,1);

    //TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục banner'),'banner_id',@$data->banner_id,0,$cat_banner,$field_value = 'id', $size = 1,0,1);

    TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục banner'),'banner_id',@$data -> banner_id,0,$cat_banner,$field_value = 'id', $field_label='name',$size = 1,0,1);

    TemplateHelper::dt_edit_image(FSText :: _('Ảnh'),'image',str_replace('/original/','/original/',URL_ROOT.@$data->image),100,200,'Kích cỡ ảnh: 230x340');
    ?>
     <input type="hidden" name="parent_id_old" id="parent_id_old" value="<?php echo isset($data->parent_id)?@$data->parent_id:0?>"/>
    <?php 
    TemplateHelper::dt_checkbox(FSText::_('Target'),'target',@$data -> target,0,array('_self'=>FSText :: _("Current window"),'_blank'=>FSText :: _("New window")));
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    //TemplateHelper::dt_checkbox(FSText::_('Hiện icon nháy'),'show_dot',@$data -> show_dot,0);
    //TemplateHelper::dt_checkbox(FSText::_('Hiện icon hot'),'show_hot',@$data -> show_hot,0); 
    TemplateHelper::dt_checkbox(FSText::_('Chỉ trên điện thoại'),'is_mobile',@$data -> is_mobile,0); 
     TemplateHelper::dt_checkbox(FSText::_('Nofollow'),'nofollow',@$data -> nofollow,0);
    TemplateHelper::dt_checkbox(FSText::_('Kiểu hiển thị'),'is_type',@$data -> is_type,0,array(0=>'dropdown',1=>'mega dropdown'));
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Link'),'link',@$data -> link);
  
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả ngắn'),'description_short',@$data -> description_short,'',100,3);
	TemplateHelper::dt_edit_text(FSText :: _('Icon SVG'),'icon',@$data -> icon,'',100,3);
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',650,450,1);
	?>
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6 col-xs-12">
    	<div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-link"></i> <?php echo FSText :: _('Create link'); ?>
            </div>
            <div class="panel-body">
    			<ul>
    				<?php 
    				if($create_link){
    					foreach ($create_link as $item) { 
    						if(!$item -> link_menu){
    							echo '<li><strong>'.$item -> treename.'</strong><li>'; 
    						} else {
    							if($item -> add_parameter){
    								echo '<li><a href="javascript: created_indirect(\''.$item -> link_menu.'\',\''.$item->id.'\');">'.$item -> treename .'</a><li>'; 
    							} else {
    								echo '<li><a href="javascript: created_direct(\''.$item -> link_menu.'\');">'.$item -> treename .'</a><li>';
    							}
    						}
    						
    						
    					}
    				}
    				?>
    			</ul>
            </div><!-- END: .panel-body -->  
    	</div><!-- END: .panel -->
    </div>
    </div>		
<?php 
    $this -> dt_form_end(@$data,1,0);
?>

<!-- END BODY-->
<script type="text/javascript">
	$(document).ready( function(){
		$("select#group_id").change(function(){
			filter_group();
            $("#parent_id").trigger("chosen:updated");
		});
		$("#filter_group_1").click(function(){
			filter_group();
            $("#parent_id").trigger("chosen:updated");
		});
	});
	function created_direct(link){
		$('#link').val(link);
	}
	function created_indirect(link,created_link_id){
		$('#link').val(link);
		window.open("index2.php?module=menus&view=items&task=add_param&id="+created_link_id, "","height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
	}
	function filter_group(){
			var group_id = $('#group_id').val();
			console.log($('#filter_group_1').is(':checked'));
			var filter_group = $('#filter_group_1').is(':checked') == true?1:0;
			var parent_id_old = $('#parent_id_old').val();
			$.ajax({url: "index.php?module=menus&view=items&task=ajax_get_menu_by_group&raw=1",
					data: {group_id: group_id,filter_group:filter_group},
					dataType: "text",
					
					success: function(text) {
						if(text == '')
							return;
						j = eval("(" + text + ")");
						
						var options = '';
						for (var i = 0; i < j.length; i++) {
							if(parent_id_old == j[i].id)
								options += '<option value="' + j[i].id + '" selected="selected">' + j[i].name + '</option>';
							else
								options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
						}
						$('#parent_id').html(options);
                        $("#parent_id").trigger("chosen:updated");
//						elemnent_fisrt = $('#parent_id option:first').val();
					}
				});
	}
</script>
