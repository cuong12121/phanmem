
<table cellspacing="1" class="admintable">


	<?php

	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	// TemplateHelper::dt_edit_text(FSText :: _('Title2'),'title2',@$data -> title2); 
	// TemplateHelper::dt_edit_text(FSText :: _('Icon (SVG)'),'icon',@$data -> icon);
	// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),150,150,'');
	TemplateHelper::dt_edit_selectbox(FSText::_('Shop'),'shop_id',@$data -> shop_id,0,$shop,$field_value = 'id', $field_label='name',$size = 1,0,1);

	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);

	TemplateHelper::dt_edit_text(FSText :: _('HdProductCode'),'HdProductCode',@$data -> HdProductCode);

	TemplateHelper::dt_edit_text(FSText :: _('SkuTemplates'),'SkuTemplates',@$data -> SkuTemplates,'',100,4);

	TemplateHelper::dt_edit_text(FSText :: _('TitleTemplates'),'TitleTemplates',@$data -> TitleTemplates,'',100,4,0,'Variables: $TITLE_KEYWORD_1$, $TITLE_KEYWORD_2$, $TITLE_KEYWORD_3$, $TITLE_KEYWORD_4$, $MODEL_RUNNER$');

	TemplateHelper::dt_edit_text(FSText :: _('MaxNumListing'),'MaxNumListing',@$data -> MaxNumListing,100);

	TemplateHelper::dt_edit_text(FSText :: _('ModelRunnerStartFrom'),'ModelRunnerStartFrom',@$data -> ModelRunnerStartFrom,1);

	TemplateHelper::dt_edit_text(FSText :: _('TitleKeywords'),'TitleKeywords',@$data -> TitleKeywords,'',100,4);

	TemplateHelper::dt_edit_text(FSText :: _('BulletSetsHtml'),'BulletSetsHtml',@$data -> BulletSetsHtml,'',650,450,1);

	TemplateHelper::dt_edit_text(FSText :: _('DescriptionTemplateHtml'),'DescriptionTemplateHtml',@$data -> DescriptionTemplateHtml,'',650,450,1);

	TemplateHelper::dt_edit_text(FSText :: _('Brands'),'Brands',@$data -> Brands);

	TemplateHelper::dt_edit_text(FSText :: _('Models'),'Models',@$data -> Models);

	TemplateHelper::dt_edit_selectbox(FSText::_('Color'),'color_id',@$data -> color_id,0,$color,$field_value = 'id', $field_label='name',$size = 1,0,1);

	
	TemplateHelper::dt_edit_selectbox(FSText::_('WarrantyType'),'warrantytype_id',@$data -> warrantytype_id,0,$warrantytype,$field_value = 'id', $field_label='name',$size = 1,0,1);

	TemplateHelper::dt_edit_selectbox(FSText::_('Warranty'),'warranty_id',@$data -> warranty_id,0,$warranty,$field_value = 'id', $field_label='name',$size = 1,0,1);

	
	TemplateHelper::dt_edit_text(FSText :: _('WarrantyHtml'),'WarrantyHtml',@$data -> WarrantyHtml,'',650,450,1);
	TemplateHelper::dt_edit_text(FSText :: _('VideoUrl'),'VideoUrl',@$data -> VideoUrl);

	TemplateHelper::dt_edit_text(FSText :: _('PackageContentHtml'),'PackageContentHtml',@$data -> PackageContentHtml,'',650,450,1);

	TemplateHelper::dt_edit_text(FSText :: _('ProductionCountry'),'ProductionCountry',@$data -> ProductionCountry);

	TemplateHelper::dt_edit_selectbox(FSText::_('Hazmat'),'hazmat_id',@$data -> hazmat_id,0,$hazmat,$field_value = 'id', $field_label='name',$size = 1,0,1);

	TemplateHelper::dt_edit_text(FSText :: _('PriceSaleMin'),'PriceSaleMin',@$data -> PriceSaleMin);

	TemplateHelper::dt_edit_text(FSText :: _('PriceSaleMax'),'PriceSaleMax',@$data -> PriceSaleMax);

	TemplateHelper::dt_edit_text(FSText :: _('MaxNumImages'),'MaxNumImages',@$data -> MaxNumImages);

	TemplateHelper::dt_edit_text(FSText :: _('MainImages'),'MainImages',@$data -> MainImages,'',100,9);

	TemplateHelper::dt_edit_text(FSText :: _('Images'),'Images',@$data -> Images,'',100,9);

	TemplateHelper::dt_edit_text(FSText :: _('WeightKg'),'WeightKg',@$data -> WeightKg);
	TemplateHelper::dt_edit_text(FSText :: _('WidthCm'),'WidthCm',@$data -> WidthCm);
	TemplateHelper::dt_edit_text(FSText :: _('HeightCm'),'HeightCm',@$data -> HeightCm);
	TemplateHelper::dt_edit_text(FSText :: _('LengthCm'),'LengthCm',@$data -> LengthCm);
	TemplateHelper::dt_edit_text(FSText :: _('Stock'),'Stock',@$data -> Stock);




	// TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	// TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	// TemplateHelper::dt_edit_text(FSText :: _('Link'),'link',@$data -> link);

	?>

</table>

<?php if(@$data) { 

	$TitleKeywords = $data-> TitleKeywords;
	$arr_TitleKeywords = explode("\n", $TitleKeywords);

	$MainImages = $data-> MainImages;
	$arr_MainImages = explode("\n", $MainImages);

	$Images = $data-> Images;
	$arr_Images = explode("\n", $Images);

	if((!$data-> MaxNumImages || $data-> MaxNumImages > @count($arr_Images))&& !empty($arr_Images)) {
		$data-> MaxNumImages = @count($arr_Images);
	}

	// echo 1;die;


				// echo $TitleKeywords;
				// print_r($arr_TitleKeywords);
				// shuffle($arr_TitleKeywords);
	?>
	<table id="table_result" style="display: none;">
		<thead>
			<tr>
			</tr>
			<tr>
				<th width="200px">Danh mục</th>
				<th width="200px">Dòng sản phẩm</th>
				<th width="200px">Thương hiệu</th>
				<th width="200px">Nhóm màu</th>
				<th width="200px">Tên</th>
				<th width="200px">Tên (Tiếng Anh)</th>
				<th width="200px">Mô tả sản phẩm</th>
				<th width="200px">Mô tả sản phẩm (Tiếng Anh)</th>
				<th width="200px">Thông tin nổi bật</th>
				<th width="200px">Bảo hành</th>
				<th width="200px">Chất liệu nguy hiểm</th>
				<th width="200px">Loại bảo hành</th>
				<th width="200px">Thơi gian bảo hành</th>
				<th width="200px">Warranty Policy (English)</th>
				<th width="200px">Đường dẫn video</th>
				<th width="200px">Giá</th>
				<th width="200px">Giá đặc biệt</th>
				<th width="200px">Ngày bắt đầu KM</th>
				<th width="200px">Ngày kết thúc KM</th>
				<th width="200px">Seller SKU</th>
				<th width="200px">AssociatedSku</th>
				<th width="200px">Số lượng</th>
				<th width="200px">Bộ sản phẩm</th>

				<th width="200px">Chiều dài gói hàng (cm) *</th>
				<th width="200px">Chiều rộng gói hàng (cm) *</th>
				<th width="200px">Chiều cao gói hàng (cm) *</th>
				<th width="200px">Khối lượng gói hàng (kg) *</th>

				<th width="200px">MainImage</th>

				<?php if($data-> MaxNumImages) { 
					for ($i=0; $i < $data-> MaxNumImages; $i++) { ?>
						<th width="200px">Image<?php echo $i+2; ?></th>
					<?php } ?>
				<?php } ?>

				<th width="200px">Mã vạch</th>
				<th width="200px">Xuất xứ</th>

				<th width="200px">Từ khóa tìm kiếm</th>
			</tr>
			<tr>
				<th width="200px">PrimaryCategory</th>
				<th width="200px">model</th>
				<th width="200px">brand</th>
				<th width="200px">color_family</th>
				<th width="200px">name</th>
				<th width="200px">name_en</th>
				<th width="200px">description</th>
				<th width="200px">description_en</th>
				<th width="200px">short_description</th>
				<th width="200px">product_warranty</th>
				<th width="200px">Hazmat</th>
				<th width="200px">warranty_type</th>
				<th width="200px">warranty</th>
				<th width="200px">product_warranty_en</th>
				<th width="200px">video</th>
				<th width="200px">price</th>
				<th width="200px">special_price</th>
				<th width="200px">special_from_date</th>
				<th width="200px">special_to_date</th>
				<th width="200px">SellerSku</th>
				<th width="200px">AssociatedSku</th>
				<th width="200px">quantity</th>
				<th width="200px">package_content</th>

				<th width="200px">package_length</th>
				<th width="200px">package_width</th>
				<th width="200px">package_height</th>
				<th width="200px">package_weight</th>

				<th width="200px">MainImage</th>

				<?php if($data-> MaxNumImages) { 
					for ($i=0; $i < $data-> MaxNumImages; $i++) { ?>
						<th width="200px">Image<?php echo $i+2; ?></th>
					<?php } ?>
				<?php } ?>

				<th width="200px">barcode_ean</th>
				<th width="200px">production_country</th>
				<th width="200px">std_search_keywords</th>
			</tr>

		</thead>




		<?php if(!$data-> MaxNumListing || $data-> MaxNumListing > @count($arr_TitleKeywords)) {
			$data-> MaxNumListing = count($arr_TitleKeywords);
		} ?>


		<?php for ($i=0; $i < $data-> MaxNumListing; $i++) {  

			$arr_MainImages_new = $arr_MainImages;
			shuffle($arr_MainImages_new);

			$arr_Images_new = $arr_Images;
			shuffle($arr_Images_new);

			$arr_TitleKeywords_new = $arr_TitleKeywords;
			$TitleKeywords_curent = @$arr_TitleKeywords_new[$i];
			unset($arr_TitleKeywords_new[$i]);
			$TITLE_KEYWORD_1 = $TitleKeywords_curent;
			shuffle($arr_TitleKeywords_new);
			$TITLE_KEYWORD_2 = @$arr_TitleKeywords_new[0];
			$TITLE_KEYWORD_3 = @$arr_TitleKeywords_new[1];
			$TITLE_KEYWORD_4 = @$arr_TitleKeywords_new[2];

			$TitleTemplates = $data-> TitleTemplates;
			$TitleTemplates = str_replace('$TITLE_KEYWORD_1$',$TITLE_KEYWORD_1,$TitleTemplates);
			$TitleTemplates = str_replace('$TITLE_KEYWORD_2$',$TITLE_KEYWORD_2,$TitleTemplates);
			$TitleTemplates = str_replace('$TITLE_KEYWORD_3$',$TITLE_KEYWORD_3,$TitleTemplates);
			$TitleTemplates = str_replace('$TITLE_KEYWORD_4$',$TITLE_KEYWORD_4,$TitleTemplates);

			$content = htmlspecialchars($data-> DescriptionTemplateHtml);
			$content = str_replace('src="/upload_images','src="'.URL_ROOT.'/upload_images',$content);

			?>
			<tr>
				<td><?php echo $data-> category_name; ?></td>
				<td><?php echo $data-> Models; ?></td>
				<td><?php echo $data-> Brands; ?></td>
				<td><?php echo $data-> color_name; ?></td>
				<td><?php echo $TitleTemplates; ?></td>
				<td><?php echo $TitleTemplates; ?></td>
				<td><?php echo htmlspecialchars('<h1>'.$TitleTemplates.'</h1><br />'.$content); ?></td>
				<td></td>
				<td><?php echo htmlspecialchars(str_replace('src="/upload_images','src="'.URL_ROOT.'/upload_images',$data-> BulletSetsHtml)); ?></td>
				<td><?php echo $data-> WarrantyHtml; ?></td>
				<td><?php echo $data-> hazmat_name; ?></td>
				<td><?php echo $data-> warrantytype_name; ?></td>
				<td><?php echo $data-> warranty_name; ?></td>
				<td></td>
				<td><?php echo $data-> VideoUrl; ?></td>
				<td></td>
				<td>
					<?php 
					$PriceSaleMin = $data-> PriceSaleMin / 1000;
					$PriceSaleMax = $data-> PriceSaleMax / 1000;
					$PriceSale = rand($PriceSaleMin,$PriceSaleMax)*1000;
					echo $PriceSale;
					?>

				</td>
				<td></td>
				<td></td>
				<td><?php echo $data-> SkuTemplates.'-'.str_pad($i+1, 5 , "0", STR_PAD_LEFT); ?></td>
				<td><?php echo $data-> SkuTemplates.'-'.str_pad($i+1, 5 , "0", STR_PAD_LEFT); ?></td>
				<td><?php echo $data-> Stock; ?></td>
				<td><?php echo htmlspecialchars($data-> PackageContentHtml); ?></td>

				<td><?php echo $data-> LengthCm; ?></td>
				<td><?php echo $data-> WidthCm; ?></td>
				<td><?php echo $data-> HeightCm; ?></td>
				<td><?php echo $data-> WeightKg; ?></td>

				<td><?php echo $arr_MainImages_new[0]; ?></td>

				<?php if($data-> MaxNumImages) { 
					for ($j=0; $j < $data-> MaxNumImages; $j++) { ?>
						<th width="200px"><?php echo $arr_Images_new[$j]; ?></th>
					<?php } ?>
				<?php } ?>

				<td></td> <!-- mã vạch -->
				<td><?php echo $data-> ProductionCountry; ?></td>
				<td></td> <!-- tìm kiếm -->

			</tr>

		<?php } ?>

	</table>

<?php } ?>





<script  type="text/javascript" language="javascript">
	function export_excel(){
		fileName = '<?php echo @$data-> name; ?>';
		fileType = 'xlsx';
		var table = document.getElementById("table_result");
		var wb = XLSX.utils.table_to_book(table, {sheet: '<?php echo @$data-> name; ?>'});

		var wscols = [
		{wch:5},
		{wch:20}
		];

		wb['!cols'] = wscols;
			// ws['!cols'] = wscols;
			return XLSX.writeFile(wb, null || fileName + "." + (fileType || "xlsx"));
		};




		$(function() {
			$( "#date_end" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
			$( "#date_end").change(function() {
				document.formSearch.submit();
			});
			$( "#date_start" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
			$( "#date_start").change(function() {
				document.formSearch.submit();
			});

			$("select#categories_filter").change(function(){
				var cat_ft_id = $(this).val();
				var cat_ft_str = ","+cat_ft_id+",";		
				$( ".cate_option" ).removeClass('hidden');
				$( ".cate_option" ).each(function(index) {
					var parent = $(this).attr('data_parents') ;
					var has_string = parent.indexOf(cat_ft_str);
					if(has_string == -1){
						$(this).addClass('hidden');
					}
				});
				if(!cat_ft_id || cat_ft_id == 0){
					$(".cate_option").removeClass('hidden');
				}
			});

		//show danh mục phụ
		$("#category_id_wrapper").change(function(){
			var category_id_wrapper_sl='';
			$('#category_id_wrapper :selected').each(function(){
				category_id_wrapper_sl += $(this).attr('data_name') + ', ';
			});
			$('#category_id_wrapper_select').html(category_id_wrapper_sl);
		});	



	});
</script>


<style type="text/css">
	#category_id_wrapper {
		width: 600px;
		height: 250px;
	}
</style>