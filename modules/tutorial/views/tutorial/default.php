<?php  	global $tmpl, $config;
	$tmpl -> addScript('form');
	$tmpl -> addStylesheet('default','modules/tutorial/assets/css');
	$tmpl -> addScript("detail","modules/tutorial/assets/js");
	FSFactory::include_class('fsstring');
	$print = FSInput::get('print',0);

	$check_img = check_image($data->image,'');
	if(!$check_img){
		$tmpl -> addStylesheet('nav_no_back');
	}
?>


<div class="<?php echo ($check_img)?'detail_main_menu_fixed_img':'detail_main_menu_fixed';?>">
	<div class="tutorial_home">
	<?php if($check_img){?>
		<div class="banner_img_menu" style="background-image: url(<?php echo str_replace('original', 'compress', $data->image);?>);">
			<?php //echo set_image_webp($data->image,'compress',@$data->title,'',0,'');?>
			<div class="page_title_img">
				<div class="container">
					<h1 class="heading_title">
						<span><?php echo $data->title;?></span>
					</h1>
					<div class="heading_title_core"><?php echo $data->name_core;?></div>
				</div>		
			</div>
			<div class="elementor-shape elementor-shape-bottom">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
					<path class="elementor-shape-fill" d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
					c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
					c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z"></path>
				</svg>
			</div>
		</div>
	<?php }?>
		<div class="tutorial_contents">
			<?php if($data->content){?>
				<div class="elementor_section_text summary_top">
					<div class="container container3">		
						<?php echo $data->content;?>
					</div>
				</div>
			<?php }?>
			<?php if(!empty($tabs_menu)){?>
				<div class="tutorial_tabs container cls">
					<div class="block_title">Tổng quan về nội dung</div>
					<div class=" tutorial_tabs_body cls">
						<?php foreach ($tabs_menu as $tab_it){ ?>
							<div class="tab_item" id="tab_item_<?php echo $tab_it->id;?> ">
								<figure class="image">									
									<?php echo set_image_webp($tab_it->img_menu,'compress',@$tab_it->name,'lazy',1,''); ?>															
								</figure>
								<div class="box_content">
									<div class="title_core">
										<?php echo $tab_it->title_core;?>
									</div>
									<div class="title">
										<?php echo $tab_it->title_menu;?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php }?>
			<?php 
			if(!empty($list)){?>
				<?php 
					//$is_back_before = 0;
					foreach ($list as $item){
						$is_content = 0;
						$is_video = 0;
						$is_img = 0;
						$is_title = 0;
						$is_container = 0;
						$is_image_text = 0;
						// 1: content, 2: img, 3:video 4:conatiner, 5: background text
						if($item->types == 1){
							$class_types = 'content container';
							$is_content = 1;
						}elseif($item->types == 2){
							$class_types = 'full';						
							$is_img = 1;
						}elseif($item->types == 3){
							$class_types = 'full';
							$is_video = 1;
						}
						elseif($item->types == 4){
							$class_types = 'container';
							$is_container = 1;
						}elseif($item->types == 5){
							$class_types = 'image_text';
							$is_image_text = 1;
						}

						if($item->is_title == 1){
							$is_title = 1;
						}

						$class_range = '';
						$is_range = '';	
						if($item->range == 2){
							$class_range = 'elementor_section_wrap_range';
							$is_range = 1;						
						}



						$color = '';
						$background = '';
						$color_curved = '';
						//$padding_bot = '';
						if($item->color){
							$color = 'color:'.$item->color.';';
						}
						$is_background = 0;
						if($item->background){
							$background = 'background-color:'.$item->background.';';
							//$padding_bot = 'padding_bottom';	
							$is_back = 1;
							//$is_back_before = 0;											
						}else {
							//$is_back_before = 1;
						}

						//echo $is_back_before ;

						//viền cong
						$is_curved = 0;
						$curved = '';
						if($item->is_curved == 1){
							$is_curved = 1;
							$curved = 'curved';
						}


						if($item->color_curved){
							$color_curved = $item->color_curved;
						}

						//check thằng trước có background hay k
						
					?>
					<div class="elementor_section_wrap <?php echo ($is_curved)?'elementor_section_wrap_curved':'';?>  <?php echo ($is_range)?$class_range:'';?>" <?php echo ($color || $background)?'style = "'.$color.$background.'"':'';?>>
						<?php if($is_curved){?>
							<div class="elementor-shape elementor-shape-top">
								<svg fill = "<?php echo $color_curved;?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
									<path fill = "<?php echo $color_curved;?>" class="elementor-shape-fill" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3
									c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3
									c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z"></path>
								</svg>
							</div>
							<?php if($is_img || $is_image_text){?>
								<div class="elementor-shape elementor-shape-bottom">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
										<path class="elementor-shape-fill" d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
										c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
										c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z"></path>
									</svg>
								</div>
							<?php }?>
						<?php }?>

						<div class="elementor_section elementor_section_<?php echo $class_types;?> <?php echo ($is_container)?'container':'';?>" id="elementor_section_<?php echo $item->id;?>" >
							<?php if($is_title){?>
								<?php if($item->title_core){?>
									<div class="title_core"><?php echo $item->title_core;?></div>
								<?php }?>

								<?php if($item->title && $item->types != 2){?>
									<h2 class="block_title <?php echo ($item->types != 1)?'container elementor_section_content':'';?>" <?php echo ($color)?'style = "'.$color.'"':'';?>>
										<?php echo  $item->title ;?>
									</h2>	
								<?php }?>
							<?php }?>

							<?php if($item->description){?>
								<div class="elementor_section_text <?php echo ($is_content)?'section_content':''?> <?php echo ($is_video)?'elementor_section_text_video':''?>">
									<?php //echo $item->description;?>

									<?php 
										$description = $item->description;
										$des = '';
										$html = '';

										if (strpos($description, '{{videos:') !== false || strpos($description, '{{aq:all}}') !== false  ||strpos($description, '{{cstrength:') !== false || strpos($description, '{{certifications:') !== false || strpos($description, '{{creasons:') !== false || strpos($description, '{{cstatistics:') !== false || strpos($description, '{{news:') !== false || strpos($description, '{{cmaterial:') !== false ){


											$description2 = str_replace('{{videos:','}}videos:',$description);
											$description2 = str_replace('{{aq:all','}}aq:all',$description2);
											$description2 = str_replace('{{cstrength:','}}cstrength:',$description2);
											$description2 = str_replace('{{certifications:','}}certifications:',$description2);
											$description2 = str_replace('{{creasons:','}}creasons:',$description2);
											$description2 = str_replace('{{cstatistics:','}}cstatistics:',$description2);
											$description2 = str_replace('{{news:','}}news:',$description2);
											$description2 = str_replace('{{cmaterial:','}}cmaterial:',$description2);

											$arr_des = explode("}}", $description2);

											foreach ($arr_des as $item_des) {
												$arr_item = explode(":", $item_des);										
												if($arr_item[0]=='videos') {
													$list_product_in = array();
													$list_product_in = $model-> get_video_in($arr_item[1]);
													$list = $list_product_in;
													//include 'default_video_in.php';

													if(!empty($list)){
														foreach ($list as $it_vi) {
															echo $tmpl -> load_direct_blocks('videos',array('style'=>'video_product','link'=>$it_vi->file_flash ,'img'=>$it_vi->image,'title'=>$it_vi->title)); 
														}
													}

													//$des .= $html;

												}elseif($arr_item[0]=='aq' && $arr_item[1]=='all') {
													$list_aq_in = array();
													$list_aq_in = $model-> get_aq_in($data-> aq_related);
													$list = $list_aq_in;
													include 'default_aq_in.php';
													//$des .= $html;
												}elseif($arr_item[0]=='news' && $arr_item[1]=='all') {
													$list_news_in = array();
													$list_news_in = $model-> get_news_in($data-> news_related);
													$list = $list_news_in;
													$title =  $item->title;
													// echo '<pre>';
													// print_r($list);
													// die;
													include './blocks/newslist/views/newslist/column22.php';

													//$des .= $html;
												}elseif($arr_item[0]=='cstrength'){
													$list_stre_in = array();
													$list_stre_in = $model-> get_cat_stre_in($arr_item[1]);

													$list = $list_stre_in;
													include 'default_streng_in.php';

												}elseif($arr_item[0]=='cmaterial'){
													$list_stre_in = array();
													$list_stre_in = $model-> get_cat_material_in($arr_item[1]);

													$list = $list_stre_in;
													//include 'default_streng_in.php';
													include './blocks/material/views/material/default.php';

												}elseif($arr_item[0]=='certifications'){
													$list_cer_in = array();

													$cat_cer = $model->get_list_cat_certifications($arr_item[1]);
													$list_cer_in = $model-> get_cer_in($arr_item[1]);
													$list = $list_cer_in;
													$cat = $cat_cer;

													include './blocks/certifications/views/certifications/slideshow_cat.php';

												}elseif($arr_item[0]=='creasons'){
													$list = array();
													$arr_cat = array();
													$arr_cat = $model->get_list_cat_creasons($arr_item[1]);

													if(!empty($arr_cat)){
														foreach ($arr_cat as $cat) {
															$list = $model-> get_creasons_in($cat->id);
															//echo '<pre>';
															// print_r($cat);
															include './blocks/reasons/views/reasons/default.php';
															//die;
														}
													}

												}elseif($arr_item[0]=='cstatistics'){

													$list = array();
													$arr_cat = array();
													$arr_cat = $model->get_list_cat_strengths3($arr_item[1]);
													
													if(!empty($arr_cat)){

														foreach ($arr_cat as $cat) {

															$list = $model-> get_strengths3_in($cat->id);
															
															//echo '<pre>';
															// print_r($cat);
															include './blocks/strengths3/views/strengths3/numbers2.php';
															//die;
														}
													}

												}else {
													echo  $item_des;

													
												}
											}
										}else {
											echo $description;
										}
										//echo $des;																			
									?>
								</div>
							<?php }?>
						</div>						
					</div>
				<?php } ?>

			<?php }?>
		</div>
	</div>

<input type="hidden" value="<?php echo $data->id; ?>" name='tutorial_id' id='tutorial_id'  />
<div class="clear"></div>
</div>

