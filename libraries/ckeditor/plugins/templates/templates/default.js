/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates( 'default', {
	// The name of sub folder which hold the shortcut preview images of the
	// templates.
	imagesPath: CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The templates definitions.
	templates: [ 
	{
    	title: '',
    	image: 'image_d.jpg',
    	description: 'Ảnh liền kề.',
    	html: '<div class="image center" style="display:inline-block;">'+
    	            	
    	'<img align="middle" alt="Mô tả ảnh 1" height="" width="496"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
    	'</br>'+		            	            	          	
    	'<img align="middle" alt="Mô tả ảnh 2" height="" width="496"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+	            	
    	'<div  style="text-align:center;width:100%;">'+
    	'Mô tả ảnh 2...'+
    	'</div>'+
    	            	
    	'</div>'+
    	'<div class="clear"></div>'
    	
    },
	{
	            	title: 'Ảnh căn giữa',
	            	image: 'image_center.jpg',
	            	description: 'Ảnh căn giữa.',
	            	html: '<center><figure class="image center" >'+	            	
	            	'<img align="middle" alt="Mô tả ảnh 2" height="" width="496"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+	            	
	            	'<figcaption>'+
	            	'Mô tả ảnh 1...'+
	            	'</figcaption>'+	            	
	            	'</figure></center>'+
	            	'<p>&nbsp;</p>'
	            	
	            },
	            {
	            	title: 'Ảnh căn trái',
	            	image: 'image_left.jpg',
	            	description: 'Ảnh căn trái.',
	            	html: '<div class="image_l cls" id="image_l">'+
	            	'<div class="frame_image" style="float:left; width:50%">'+
	            		'<img align="middle" alt="Mô tả ảnh 2" height="" width="496"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
	            	'</div>'+
	            	'<div class="content" style="float:right;width:calc(50% - 40px)">'+
		            	'<div class="content_title"><span style="font-size:20px;color:#000"><strong>'+
		            		'Tiêu đề'+
		            	'</strong></span></div>'+
		            	'<div class="description_inner scroll-bar">'+
			            	'<div class="content_inner">'+
			            		'Nội dung'+
			            	'</div>'+
		            	'</div>'+
	            	'</div>'+
	            	'</div>'+
	            	'<div style="clear:both">&nbsp;</div>'
	            },
	            {
	            	title: 'Ảnh căn phải',
	            	image: 'image_right.jpg',
	            	description: 'Ảnh căn phải.',
	            	html: '<div class="image_r cls" id="image_r">'+
	            	'<div class="frame_image" style="float:right; width:50%" >'+
	            		'<img align="middle" alt="Mô tả ảnh 2" height="" width="496"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
	            	'</div>'+
	            	'<div class="content" style="float:left;width:calc(50% - 40px)">'+
		            	'<div class="content_title"><span style="font-size:20px;color:#000"><strong>'+
		            		'Tiêu đề'+
		            	'</strong></span>'+'</div>'+
		            	'<div class="description_inner scroll-bar">'+
			            	'<div class="content_inner">'+
			            		'Nội dung'+
			            	'</div>'+
		            	'</div>'+
	            	'</div>'+
	            	'</div>'+
	            	'<div style="clear:both">&nbsp;</div>'
	            },
	            {
	            	title: 'Văn bản trong ảnh',
	            	image: 'text_inside_image.jpg',
	            	description: 'Văn bản trong ảnh',
	            	html: '<div class="text_inside cls" id="text_inside" style="position:relative">'+
	            	'<div class="frame_images">'+
	            		'<img align="middle" alt="Mô tả ảnh 2" height="" width="496"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
	            	'</div>'+
	            	'<div class="contents" style="position:absolute;width:500px;top:5px;right:0;text-align:left">'+
		            	'<div class="content_title"><span style="font-size:20px;color:#000"><strong>'+
		            		'Tiêu đề'+
		            	'</strong></span>'+'</div>'+
		            	'<div class="description_inner scroll-bar">'+
			            	'<div class="content_inner">'+
			            		'Nội dung'+
			            	'</div>'+
		            	'</div>'+
	            	'</div>'+
	            	'</div>'+
	            	'<div style="clear:both">&nbsp;</div>'
	            },
	            {
	            	title: 'Điểm mạnh sản phẩm (tối đa 4)',
	            	image: 'strengths_4.jpg',
	            	description: 'Điểm mạnh sản phẩm (tối đa4)',
	            	html:'<div class="strengths" id="strengths_content">'+

		            	'<div class="title_strengths">'+
		            	'<span style="font-size:20px;color:#000">'+
		            		'Tiêu đề'+
		            		'</span>'+
		            	'</div>'+

		            	

		            	'<div class="contents" style="display:flex;flex-wrap:wrap;position:relative">'+

			            	'<div class="frame_images" style="position:absolute;max-width:400px;left:50%;top:50%;transform:translate(-50%,-50%)">'+
			            		'<img align="middle" alt="Mô tả ảnh 2" height="" width="400px"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
			            	'</div>'+

			            	'<div class="item item1" style="position:relative;width:50%;margin-bottom:15px;box-sizing:border-box;padding: 0px 160px 0px 100px;"><p class="title_str">Điểm mạnh 1</p><p>Nội dung điểm mạnh 1</p>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 1" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class=" item item2" style="position:relative;width:50%;margin-bottom:15px;box-sizing:border-box;padding-left:260px;"><p class="title_str">Điểm mạnh 2</p><p>Nội dung điểm mạnh 2</p>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 2" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class="item item3" style="position:relative;width:50%;box-sizing:border-box;padding: 0px 160px 0px 100px;"><p class="title_str">Điểm mạnh 3</p><p>Nội dung điểm mạnh 3</p>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 3" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class="item item4" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><p class="title_str">Điểm mạnh 4</p><p>Nội dung điểm mạnh 4</p>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 4" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	
		            	'</div>'+

	            	'</div>'+
	            	'<div style="clear:both">&nbsp;</div>'
	            },
	            {
	            	title: 'Điểm mạnh sản phẩm (tối đa 6)',
	            	image: 'strengths_6.jpg',
	            	description: 'Điểm mạnh sản phẩm (tối đa 6)',
	            	html:'<div class="strengths" id="strengths_content">'+

		            	'<div class="title_strengths" style="text-align:center; margin-bottom:100px;">'+
		            	'<span style="font-size:25px;color:#000;text-align:center;display:block;">'+
		            		'Tiêu đề'+
		            		'</span>'+
		            	'</div>'+

		            	

		            	'<div class="contents" style="display:flex;flex-wrap:wrap;position:relative">'+

			            	'<div class="frame_images" style="position:absolute;max-width:400px;left:50%;top:50%;transform:translate(-50%,-50%)">'+
			            		'<img align="middle" alt="Mô tả ảnh 2" height="" width="400px"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
			            	'</div>'+

			            	'<div class="item item1" style="position:relative;width:50%;margin-bottom:15px;box-sizing:border-box;padding: 0px 160px 0px 100px;"><span class="title_str">Điểm mạnh 1</span><div class="content_des">Nội dung điểm mạnh 1</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 1" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class=" item item2" style="position:relative;width:50%;margin-bottom:15px;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 2</span><div class="content_des">Nội dung điểm mạnh 2</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 2" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class="item item3" style="position:relative;width:50%;box-sizing:border-box;padding: 0px 160px 0px 100px;"><span class="title_str">Điểm mạnh 3</span><div class="content_des">Nội dung điểm mạnh 3</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 3" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class="item item4" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 4</span><p>Nội dung điểm mạnh 4</p>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 4" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	'<div class="item item5" style="position:relative;width:50%;box-sizing:border-box;padding: 0px 160px 0px 100px;"><span class="title_str">Điểm mạnh 5</span><div class="content_des">Nội dung điểm mạnh 3</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 5" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	'<div class="item item6" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 6</span><div class="content_des">Nội dung điểm mạnh 4</div>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 6" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
		            	'</div>'+

	            	'</div>'+
	            	'<div style="clear:both">&nbsp;</div>'
	            },{
	            	title: 'Điểm mạnh sản phẩm (tối đa 8)',
	            	image: 'strengths_8.jpg',
	            	description: 'Điểm mạnh sản phẩm (tối đa 8)',
	            	html:'<div class="strengths" id="strengths_content">'+

		            	'<div class="title_strengths" style="text-align:center; margin-bottom:100px;">'+
		            	'<span style="font-size:25px;color:#000;text-align:center;display:block;">'+
		            		'Tiêu đề'+
		            		'</span>'+
		            	'</div>'+

		            	

		            	'<div class="contents" style="display:flex;flex-wrap:wrap;position:relative">'+

			            	'<div class="frame_images" style="position:absolute;max-width:400px;left:50%;top:50%;transform:translate(-50%,-50%)">'+
			            		'<img align="middle" alt="Mô tả ảnh 2" height="" width="400px"  src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg"/>'+
			            	'</div>'+

			            	'<div class="item item1" style="position:relative;width:50%;margin-bottom:15px;box-sizing:border-box;padding: 0px 160px 0px 100px;"><span class="title_str">Điểm mạnh 1</span><div class="content_des">Nội dung điểm mạnh 1</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 1" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class=" item item2" style="position:relative;width:50%;margin-bottom:15px;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 2</span><div class="content_des">Nội dung điểm mạnh 2</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 2" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class="item item3" style="position:relative;width:50%;box-sizing:border-box;padding: 0px 160px 0px 100px;"><span class="title_str">Điểm mạnh 3</span><div class="content_des">Nội dung điểm mạnh 3</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 3" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+

			            	'<div class="item item4" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 4</span><p>Nội dung điểm mạnh 4</p>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 4" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	'<div class="item item5" style="position:relative;width:50%;box-sizing:border-box;padding: 0px 160px 0px 100px;"><span class="title_str">Điểm mạnh 5</span><div class="content_des">Nội dung điểm mạnh 5</div>'+
			            		'<img align="middle" class="effect_img" width="50px" alt="Mô tả ảnh 5" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	'<div class="item item6" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 6</span><div class="content_des">Nội dung điểm mạnh 6</div>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 6" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	'<div class="item item7" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 7</span><div class="content_des">Nội dung điểm mạnh 7</div>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 7" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:10px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
			            	'<div class="item item8" style="position:relative;width:50%;box-sizing:border-box;padding-left:260px;"><span class="title_str">Điểm mạnh 8</span><div class="content_des">Nội dung điểm mạnh 8</div>'+
			            		'<img valign="middle" class="effect_img" width="50px" alt="Mô tả ảnh 8" height="" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" style="position:absolute;left:220px;top:50%;transformt:translate(-50%,-50%)">'+
			            	'</div>'+
		            	'</div>'+

	            	'</div>'+
	            	'<div style="clear:both">&nbsp;</div>'
	            },
	            {
	            	title: 'Chùm ảnh - 1:1',
	            	image: 'imageset_11.jpg',
	            	description: 'Chùm ảnh, 1 trái 1 phải',
	            	html: '<table align="center" class="image center">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td><img align="middle" alt="" height="293" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="220" /></td>'+
	            	'<td><img align="middle" alt="Mô tả ảnh." height="293" src="../images/image_default_ver.jpg" width="220" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td class="image_desc" colspan="2">Mô tả ảnh.</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Chùm ảnh - 1:2',
	            	image: 'imageset_12.jpg',
	            	description: 'Chùm ảnh, 1 trái 2 phải',
	            	html: '<table align="center" class="image center">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td rowspan="2"><img align="middle" alt="Mô tả ảnh." height="400" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="300" /></td>'+
	            	'<td><img align="middle" alt="" height="195" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="140" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td><img align="middle" alt="" height="195" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="140" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td class="image_desc" colspan="2">Mô tả ảnh.</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Chùm ảnh - 1:3',
	            	image: 'imageset_13.jpg',
	            	description: 'Chùm ảnh, 1 trái 3 phải',
	            	html: '<table align="center" class="image center">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td rowspan="3"><img align="middle" alt="Mô tả ảnh." height="400" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="300" /></td>'+
	            	'<td><img align="middle" alt="" height="120" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="155" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td><img align="middle" alt="" height="120" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="155" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td><img align="middle" alt="" height="120" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="155" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td class="image_desc" colspan="2">Mô tả ảnh.</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Chùm ảnh - 1/3',
	            	image: 'imageset_1-3.jpg',
	            	description: 'Chùm ảnh, 1 trên 3 dưới',
	            	html: '<table align="center" class="image center">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td colspan="3"><img align="middle" alt="" height="334" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="450" /></td>'+
	            	' </tr>'+
	            	'<tr>'+
	            	'<td><img align="middle" alt="" height="197" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="144" /></td>'+
	            	'<td><img align="middle" alt="" height="197" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="144" /></td>'+
	            	'<td><img align="middle" alt="" height="197" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="144" /></td>'+
	            	' </tr>'+
	            	'<tr>'+
	            	'<td class="image_desc" colspan="3">Mô tả ảnh.</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Ghép 2 ảnh thành 1 ảnh',
	            	image: 'imageset_11.jpg',
	            	description: 'Ghép 2 ảnh thành 1 ảnh',
	            	html: '<table align="center" class="image center" style="border-collapse:collapse;">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td style="padding: 5px 0 5px 5px;"><img align="middle" alt="Mô tả ảnh." height="293" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="220" /></td>'+
	            	'<td style="padding:5px 5px 5px 0;"><img align="middle" alt="" height="293" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="220" /></td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td class="image_desc" colspan="2">Mô tả ảnh.</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Trích dẫn - Giữa',
	            	image: 'quote_center.jpg',
	            	description: 'Hộp trích dẫn, canh lề giữa',
	            	html: '<table align="center" class="quote center" width="400">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td>Ông Nguyễn Khắc Hiếu, phó ban chỉ đạo thực hiện công ước khí hậu và nghị định thư Kyoto của Việt Nam cho biết Việt Nam đã thực hiện xong các nghĩa vụ được quy định trong Nghị định thư Kyoto. Ông nói Việt Nam sẽ tiếp tục đàm phán trong tư thế thành viên của nhóm G77. Trong 10 thành phố lớn nằm trong danh sách nguy cơ cao của OECD vào năm 2070, có 9 thành phố thuộc châu Á. Trong số này Calcutta và Mumbai của Ấn Độ đứng hàng đầu. TP Hồ Chí Minh, Hải Phòng (Việt Nam) đứng hàng thứ ba, còn lại là Dhaka (Bangladesh), Quảng Châu và Thượng Hải (Trung Quốc), Bangkok (Thái Lan) và Yangon (Myanmar)&hellip;</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Trích dẫn - Trái',
	            	image: 'quote_left.jpg',
	            	description: 'Hộp trích dẫn, canh lề trái',
	            	html: '<table align="left" class="quote leftside" width="400">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td>Ông Nguyễn Khắc Hiếu, phó ban chỉ đạo thực hiện công ước khí hậu và nghị định thư Kyoto của Việt Nam cho biết Việt Nam đã thực hiện xong các nghĩa vụ được quy định trong Nghị định thư Kyoto. Ông nói Việt Nam sẽ tiếp tục đàm phán trong tư thế thành viên của nhóm G77. Trong 10 thành phố lớn nằm trong danh sách nguy cơ cao của OECD vào năm 2070, có 9 thành phố thuộc châu Á. Trong số này Calcutta và Mumbai của Ấn Độ đứng hàng đầu. TP Hồ Chí Minh, Hải Phòng (Việt Nam) đứng hàng thứ ba, còn lại là Dhaka (Bangladesh), Quảng Châu và Thượng Hải (Trung Quốc), Bangkok (Thái Lan) và Yangon (Myanmar)&hellip;</td>'+
	            	' </tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Trích dẫn - Phải',
	            	image: 'quote_right.jpg',
	            	description: 'Hộp trích dẫn, canh lề phải',
	            	html: '<table align="right" class="quote rightside" width="400">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td>Ông Nguyễn Khắc Hiếu, phó ban chỉ đạo thực hiện công ước khí hậu và nghị định thư Kyoto của Việt Nam cho biết Việt Nam đã thực hiện xong các nghĩa vụ được quy định trong Nghị định thư Kyoto. Ông nói Việt Nam sẽ tiếp tục đàm phán trong tư thế thành viên của nhóm G77. Trong 10 thành phố lớn nằm trong danh sách nguy cơ cao của OECD vào năm 2070, có 9 thành phố thuộc châu Á. Trong số này Calcutta và Mumbai của Ấn Độ đứng hàng đầu. TP Hồ Chí Minh, Hải Phòng (Việt Nam) đứng hàng thứ ba, còn lại là Dhaka (Bangladesh), Quảng Châu và Thượng Hải (Trung Quốc), Bangkok (Thái Lan) và Yangon (Myanmar)&hellip;</td>'+
	            	'</tr>'+
	            	' </tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Trích dẫn nền xám',
	            	image: 'template_quote.gif',
	            	description: 'Trích dẫn nền nền xám chữ đen',
	            	html: '<table align="right" cellpadding="0" cellspacing="0" class="template_quote_xam">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td class="innerbox">'+
	            	'<div class="content_quote">'+
	            	'<div class="quote_open">&nbsp;</div>'+
	            	'<strong>Because of the way they controlled the game in the first half, I am happy to settle for a draw</strong>'+
	            	'<div class="quote_close">&nbsp;</div>'+
	            	'</div>'+
	            	'<div class="note">Jose Mourinho</div>'+
	            	'</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Trích dẫn nền đỏ',
	            	image: 'template_quote.gif',
	            	description: 'Trích dẫn nền đỏ chữ trắng',
	            	html: '<table align="right" border="0" cellpadding="0" cellspacing="0" class="template_quote" style="MARGIN: 5px" width="208">'+
	            	'<tbody>'+
	            	' <tr>'+
	            	'<td width="5">&nbsp;</td>'+
	            	'<td bgcolor="#b40000" style="font-size: 11px; color: #fff; font-family: verdana">'+
	            	'<div>'+
	            	'<div style="margin: 5px">'+
	            	'<div style="float: left; background-image: url(/common/v3/images/q1_std.gif); width: 20px; background-repeat: no-repeat; height: 13px">&nbsp;</div>'+
	            	'<strong>Because of the way they controlled the game in the first half, I am happy to settle for a draw</strong>'+
	            	'<div style="float: right; background-image: url(/common/v3/images/q2_std.gif); width: 20px; background-repeat: no-repeat; height: 13px">&nbsp;</div>'+
	            	'</div>'+
	            	'</div>'+
	            	'<div>Jose Mourinho</div>'+
	            	'</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Multimedia - Box phải ',
	            	image: 'quote_right.jpg',
	            	description: 'Hộp nhúng multimedia, canh lề phải',
	            	html: '<table align="right" class="quote multimedia rightside" width="200">'+
	            	'<tbody>'+
	            	'<tr valign="top">'+
	            	'<td>'+
	            	'<table class="image leftside">'+
	            	'<tbody>'+
	            	'<tr>'+
	            	'<td><img align="middle" alt="" height="89" src="../images/template_image_multimedia_default.gif" width="89" /></td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'Xăng tăng giá, người ta nghĩ ngay đến việc đi lại, phí sinh hoạt tăng theo</td>'+
	            	'</tr>'+
	            	'<tr>'+
	            	'<td class="media-content leftbox">'+
	            	'<div class="icon-video">&nbsp;</div>'+
	            	'Xem <a href="http://megafun.vn" taget="_blank"> clip nhạc chế của ca sĩ Cáp Anh Tài</a> phổ theo nhạc bài hát yêu lại từ đầu của Khắc Việt</td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<p>&nbsp;</p>'
	            },
	            {
	            	title: 'Multimedia - Box Giữa',
	            	image: 'quote_center.jpg',
	            	description: 'Hộp nhúng multimedia, canh lề giữa',
	            	html: '<table align="center" class="quote multimedia center" width="400">'+
	            		'<tbody>'+
	            		'<tr valign="top">'+
	            	'<td>'+
	            	'<table class="image leftside">'+
	            	'<tbody>'+
	            	'<tr>'+
	            		'<td><img align="middle" alt="" height="89" src="../libraries/ckeditor/plugins/templates/templates/images/noimage.jpg" width="89" /></td>'+
	            	'</tr>'+
	            	'</tbody>'+
	            	'</table>'+
	            	'<div>Xăng tăng giá, người ta nghĩ ngay đến việc đi lại, phí sinh hoạt tăng theo</div>'+
	            	'<div class="media-content">'+
	            	'<div class="icon-video">&nbsp;</div>'+
	            	'Xem <a href="http://megafun.vn" taget="_blank"> clip nhạc chế của ca sĩ Cáp Anh Tài</a> phổ theo nhạc bài hát yêu lại từ đầu của Khắc Việt</div>'+
	            	'</td>'+
	            '</tr>'+
	            '</tbody>'+
	            '</table>'+
	            '<p>&nbsp;</p>'
	            },
	            ]
} );


