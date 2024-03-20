			    
			    <!--	EXTENDED FIELDS    -->
			    	<?php if(@$extend_fields) { ?>

			    	<table>
			    			<?php 
			    			for($i = 0 ; $i < count($extend_fields); $i ++)
			    			{
			    				if($extend_fields[$i] -> is_price == 1 ) {
			    					continue;
			    				}
			    				$fieldname  = $extend_fields[$i] -> field_name;
			    				$field_display  = $extend_fields[$i] -> field_name_display;
			    				$fieldtype  = $extend_fields[$i] -> field_type;
			    				if($fieldname == 'id' || $fieldname == 'ID' || $fieldname == 'Id')
			    					continue;
			    					
		    					switch ($fieldtype){
									case "text":
										TemplateHelper::dt_edit_text($field_display,$fieldname,@$data_ext -> $fieldname,'',650,450,1); 
										break;
									case "int":
										TemplateHelper::dt_edit_text($field_display,$fieldname,@$data_ext -> $fieldname,'','20');
										break;
									case "foreign_one":
										TemplateHelper::dt_edit_selectbox($field_display,$fieldname,@$data_ext -> $fieldname,0,$data_foreign[$fieldname],'id', 'name',$size = 10,0);
										break;
									case "foreign_multi":
										TemplateHelper::dt_edit_selectbox($field_display,$fieldname,@$data_ext -> $fieldname,0,$data_foreign[$fieldname],'id', 'name',$size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item');
										break;
									case "datetime":
										$value = isset($data_ext -> $fieldname)?strtotime(@$data_ext -> $fieldname):time();
										TemplateHelper::dt_edit_text($field_display,$fieldname,date('d-m-Y H:i:s',$value));
										break;
									default:
										TemplateHelper::dt_edit_text($field_display,$fieldname,@$data_ext -> $fieldname);
										break;
		    					}
			    			}			
			    			?>
			    		
			    	</table>
			    	<?php }?>
			    <!--	end EXTENDED FIELDS    -->
			    
