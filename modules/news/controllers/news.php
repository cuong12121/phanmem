	<?php
	/*
	* Huy write
	*/
	// controller


	class NewsControllersNews extends FSControllers {
		var $module;
		var $view;
		function display() {
		// call models
			$model = $this->model;

			$data = $model->get_news();
		// check xfem id co dung ko
		// Ok da hieu :d

			$point_default = $this -> cal_point($data);
	    // $count = $this -> cal_count($data);
			$point = $data -> rating_count ? round($data -> rating_sum /$data -> rating_count): $point_default;

	    // echo $point;  


			$id = FSInput::get ( 'id', 0, 'int' );
			$amp = FSInput::get ( 'amp', 0, 'int' );

			if (! $data) {
				setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Link này không tồn tại') );
			}



			$code = FSInput::get('code');
			$ccode = FSInput::get('ccode');
			$category_id = $data -> category_id;
			$category = $model -> get_category_by_id($category_id);
			if(!$category){
				setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Danh mục không tồn tại') );
			}
			if ($code != $data->alias || $id != $data->id) {
				$link = FSRoute::_ ( "index.php?module=news&view=news&code=" . trim ( $data->alias ) . "&id=" . $data->id . "&ccode=" . trim ( $data->category_alias )."&amp=".$amp );
				setRedirect ( $link );
			}

			$authors = $model -> get_records('published = 1','fs_news_author','*','','','id');

		// relate
			$relate_news_list = $model->getRelateNewsList ( $category_id );
		// tin liên quan theo tags
			$relate_news_list_by_tags = $model->get_relate_by_tags ( $data->tags, $data->id, $category_id );
			$total_content_relate = count ( $relate_news_list );

		// chèn keyword  vào trong nội dung

		// sản phẩm gợi ý ( lấy từ database)
			$relate_products_list = $model->get_products_related ( $data->products_related);
		// if(!$relate_products_list){
		// 	//	lấy  danh sách  tin tức liên quan theo tag
		// 	$relate_products_list = $model->get_products_relate_tags ( $data->tags);
		// 	$limit_products_center = 4;
		// 	$total_relate_products = count($relate_products_list);
		// 	if($total_relate_products < $limit_products_center){
		// 		$str_prds_id = '';
		// 		if(count($relate_products_list)){
		// 			foreach($relate_products_list as $item){
		// 				if($str_prds_id)
		// 					$str_prds_id .= ',';
		// 				$str_prds_id .= $item -> id;
		// 			}
		// 		}
		// 		$hot_products = $model->get_products_hot ( $str_prds_id ,($limit_products_center - $total_relate_products ) );
		// 		$relate_products_list = count($relate_products_list)?array_merge($relate_products_list,$hot_products):$hot_products;
		// 	}
		// }
		// $products_new = $model->get_products_new (4 );

		// //products_types
		// $types = $model->get_types ();

			if($data->tag_group) {

				$tag_group = $model->get_products_tag_group ( $data->tag_group);

			}

		$description = $this->insert_link_keyword ( $data->content );//nội dung bài viết
		// if(!$amp ){
		$description = $this -> table_of_contents($description,4);
		// }
		
		
		$breadcrumbs = array ();
		$breadcrumbs [] = array (0 => FSText::_('Tin tức'), 1 => FSRoute::_ ( 'index.php?module=news&view=home&Itemid=2' ) );
		$breadcrumbs [] = array (0 => $category->name, 1 => FSRoute::_ ( 'index.php?module=news&view=cat&cid=' . $data->category_id . '&ccode=' . $data->category_alias ) );
		//			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
		global $tmpl, $module_config;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'title', $data->title );
		$tmpl->assign ( 'tags_news', $data->tags );
		$tmpl->assign ( 'products_related', $data->products_related );
		$tmpl->assign ( 'news_related', $data->news_related );
	//		$tmpl->assign ( 'og_image', URL_ROOT . $data->image );
		// seo
		if(!empty($data->schema)){
			$tmpl->addHeader($data->schema);
		}
		$this->set_header ( $data );
		$tmpl->set_data_seo ( $data );
		
		// call views			
		include 'modules/' . $this->module . '/views/' . $this->view.($amp?'_amp':'') . '/default.php';
	}



	// check captcha
	function check_captcha() {
		$captcha = FSInput::get ( 'txtCaptcha' );
		
		if ($captcha == $_SESSION ["security_code"]) {
			return true;
		} else {
		}
		return false;
	}

	function rating() {
		$model = $this->model;
		if (! $model->save_rating ()) {
			echo '0';
			return;
		} else {
			echo '1';
			return;
		}
	}
	function count_views() {
		$model = $this->model;
		if (! $model->count_views ()) {
			echo 'hello';
			return;
		} else {
			echo '1';
			return;
		}
	}
	// update hits
	function update_hits() {
		$model = new NewsModelsNews ();
		$news_id = FSInput::get ( 'id' );
		$id = $model->update_hits ( $news_id );
		if ($id) {
			echo 1;
		} else {
			echo 0;
		}
		return;
	}
	/*
		 * Tạo ra các tham số header ( cho fb)
		 */
	function set_header($data, $image_first = '') {
		global $config;
		FSFactory::include_class('fsstring');
		$link = FSRoute::_ ( "index.php?module=news&view=news&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias );
		$str = '<meta property="og:title"  content="' . htmlspecialchars ( $data->title ) . '" />
		<meta property="og:type"   content="website" />
		';
		$image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );

		$str_content = htmlspecialchars(FSString::getWord(300,$data -> content));
		

		$str .= '<meta property="og:image"  content="' . $image . '" />
		<meta property="og:image:width" content="600 "/>
		<meta property="og:image:height" content="315"/>
		<meta property="og:image:alt" content="'.htmlspecialchars ( $data->title ).'" />
		';


		include 'simple_html_dom.php';
		$dom = new simple_html_dom();

		$html_des = $dom->load($data-> content);

		$p_des = $html_des->find('p');

		$list_img = '';

		if(@$html_des->find('img')) {
			foreach ($html_des->find('img') as $img) {
				$url = URL_ROOT.str_replace('/upload_images','upload_images',$img-> src);
				if($url) {
					$list_img .= '"'.str_replace('.webp','',$url).'",';
				}
			}
		}

		$list_img  = trim($list_img,',');

		$p_des_last = end($p_des);


		$amp = FSInput::get('amp',0,'int');
		$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
		if(!$amp && $lang == 'vi'){
			$str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';
		}
		$str .= '<meta property="og:description"  content="' . htmlspecialchars ( $data->summary ) . '" />';
		$data-> seo_description = str_replace('"','',$data-> seo_description);
		$data-> seo_description = str_replace('“','',$data-> seo_description);
		$data-> seo_description = str_replace('”','',$data-> seo_description);

		$data-> title = str_replace('"','',$data-> title);
		$data-> title = str_replace('“','',$data-> title);
		$data-> title = str_replace('”','',$data-> title);


		$str .= '
		<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Article",
			"inLanguage": "vi-VN",
			"isFamilyFriendly": true,
			"articleSection": "'.$data-> category_name.'",
			"accessMode": 
			[
			"textual",
			"visual"
			],
			"About": 
			[
			{
				"@type": "Thing",
				"image": ['.$list_img.'		
				],
				"@id": "'.$link.'#about", 
				"url": "'.$link.'", 
				"mainEntityOfPage": "'.$link.'",
				"name": "'.$data-> title.'",
				"description": "'.$data-> seo_description.'"
			}
			],

			"schemaVersion": "9.0",
			"name": "'.$data-> title.'",
			"alternativeHeadline": "'.$data-> title.'",
			"headline": "'.$data-> title.'",
			"url": "'.$link.'", 
			"@id": "'.$link.'#'.$data-> alias.'", 
			"description": "'.$data-> seo_description.'",
			"disambiguatingDescription": "'.$data-> seo_description.'",
			"datePublished": "'.$data-> updated_time.'",
			"dateCreated": "'.$data-> updated_time.'",
			"dateModified": "'.$data-> updated_time.'",
			"mainEntityOfPage": "'.$link.'", 
			"image": ['
			.$list_img.
			'],
			"thumbnailUrl":   "'.$image.'",
			"wordCount": "'.str_word_count($data-> content).'",
			"timeRequired": "5",
			"copyrightYear": "điền năm phát hành",
			"typicalAgeRange": "18 - 75",
			"pageStart": "'.$data->  title.'",
			"articleBody": "'.str_replace('”','',str_replace('“','',str_replace('"','',html_entity_decode($html_des-> plaintext)))).'",    
			"pageEnd": "'.$p_des_last-> plaintext.'",	
			"genre":"'.$data->  title.'",

			"copyrightHolder": 
			{
				"@type": "Organization",
				"name": "Vinalnk",
				"url": "https://vinalnk.com/",
				"@id": "kg:/g/11g9h0tjcp",
				"logo": 
				{
					"@type": "ImageObject",
					"url": "'.URL_ROOT.$config['logo'].'",
					"width":  "144",
					"height": "38"
				}
				},

				"acquireLicensePage":"https://vinalnk.com/ct-bao-mat.html",
				"audience":{
					"@context":"https://schema.org",
					"@type":"Audience",
					"audienceType":[
					"Businessperson",
					"EducationalAudience",
					"MedicalAudience",
					"PeopleAudience",
					"Researcher"
					],
					"sameAs":[
					"https://en.wikipedia.org/wiki/Businessperson"
					],
					"url":"https://vi.wikipedia.org/wiki/Doanh_nh%C3%A2n",
					"name":"Doanh nhân",
					"geographicArea":{
						"@type":"AdministrativeArea",
						"url":"https://vi.wikipedia.org/wiki/Th%C3%A0nh_ph%E1%BB%91_H%E1%BB%93_Ch%C3%AD_Minh",
						"@id":"kg:/m/0hn4h",
						"name":"Thành Phố Hồ Chí Minh"
					}

					},
					"creativeWorkStatus":"Published",

					"publisher": {
						"@type": "Organization",
						"@id": "kg:/g/11g9h0tjcp"
						},
						"accountablePerson": {
							"@type": "Person",
							"@id": "https://vinalnk.com/ct-evans-nguyen.html#person"
							},
							"creator": {
								"@type": "Person",
								"@id": "https://vinalnk.com/ct-evans-nguyen.html#person"
								},
								"author": {
									"@type": "Person",
									"knowsLanguage": [
									"Vietnamese",
									"English"
									],
									"knows":[
									{
										"@context":"https://schema.org",
										"@type":"Person",
										"sameAs":["https://www.youtube.com/channel/UCctXZhXmG-kf3tlIXgVZUlw"],
										"name":"gary vaynerchuk",
										"jobTitle":"CEO",
										"WorksFor":"Vayner Media",
										"birthDate":"1975-11-13T17:00:00.000Z",
										"url":"https://www.garyvaynerchuk.com/",
										"@id":"kg:/m/026w6n_",
										"mainEntityOfPage":"https://www.garyvaynerchuk.com/",
										"image":"https://aftermarq.com/wp-content/uploads/2018/03/Garyv-1170x650.jpg"

									}
									],
									"knowsAbout":[

									{
										"@type":"Specialty",
										"additionalType":[
										"https://www.google.com/search?q=iphone&kponly=&kgmid=/m/027lnzs"
										],
										"sameAs":[
										"https://vi.wikipedia.org/wiki/IPhone"
										],
										"name":"Điện thoại",
										"description":"✓ Apple iPhone cũ chính hãng giá rẻ ✓thu máy cũ đổi máy mới ✓trả góp lãi suất 0% tại vinalnk.com ✓giao hàng toàn quốc ảo hành uy tín",
										"url":"https://vinalnk.com/dien-thoai-pc1.html",
										"@id":"kg:/m/027lnzs"
									}
									],
									"gender": "https://schema.org/Male",
									"name": "Nguyễn Hoàng Lưu",
									"url": "https://vinalnk.com/ct-evans-nguyen.html",
									"@id": "https://vinalnk.com/ct-evans-nguyen.html#person",
									"mainEntityOfPage": "https://vinalnk.com/ct-evans-nguyen.html",
									"familyName":"Nguyễn",
									"additionalName":"Hoàng",
									"givenName":"Lưu",
									"height":"1m65",

									"jobTitle":{
										"@type":"DefinedTerm",
										"name":"CEO",
										"description":"CEO là viết tắt của từ Chief Executive Officer, có nghĩa là giám đốc điều hành, giữ trách nhiệm thực hiện những chính sách của hội đồng quản trị. Ở những tập đoàn có tổ chức chặt chẽ, các bạn sẽ thấy chủ tịch hội đồng quản trị thường đảm nhận luôn chức vụ CEO này",
										"url":[
										"https://vi.wikipedia.org/wiki/T%E1%BB%95ng_gi%C3%A1m_%C4%91%E1%BB%91c_%C4%91i%E1%BB%81u_h%C3%A0nh"
										]
										},

										"image": "https://vinalnk.com/images/config/vinalnk-logo_1626701176.jpg",
										"email": "nguyenluu110392@gmail.com",
										"telephone": "0918503608",
										"birthDate":"1992-03-11",

										"worksFor": {
											"@type": "Organization",
											"name": "Vinalnk",
											"url": "https://vinalnk.com/",
											"@id": "kg:/g/11g9h0tjcp",
											"logo": {
												"@type":"ImageObject",
												"url":"https://vinalnk.com/images/config/vinalnk-logo_1626701176.jpg",
												"sameAs" : 
												[
												"https://about.me/vinalnk",
												"https://twitter.com/Vinalnk1",
												"https://www.youtube.com/channel/UC4Zx2RDcMHYYgYVSlsyyp-Q",
												"https://www.instagram.com/vinalnk/"
												],
												"award":" Vinalnk - Top 05 hệ thống phân phối điện thoại nhất Việt Nam"
												},

												"location": {
													"@type": "PostalAddress",
													"addressCountry": "Việt Nam",
													"name": "Trụ sở chính",
													"addressLocality": "Hồ Chí Minh, Việt nam",
													"addressRegion": "Hồ Chí Minh",
													"streetAddress": "22/31A Đ. Số 8, Hiệp Bình Phước, Thủ Đức, Thành phố Hồ Chí Minh 700000",
													"postalCode": "700000"
												}
												},
												"nationality": {
													"@type": "Country",
													"@id": "kg:m/01crd5",
													"url": "https://vi.wikipedia.org/wiki/Vi%E1%BB%87t_Nam",
													"name": "Việt Nam",
													"sameAs": [
													"https://en.wikipedia.org/wiki/Vietnam",
													"https://www.wikidata.org/wiki/Q881"
													],
													"logo": "https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Flag_of_Vietnam.svg/1200px-Flag_of_Vietnam.svg.png",
													"hasMap": "https://goo.gl/maps/Dp61Jti5wUhiTqrZ9"
													},

													"alumniOf":	[
													{
														"@type":"EducationalOrganization",
														"name":"Đại học Quốc tế RMIT Việt Nam",
														"@id":"kg:/m/04g0808",
														"description":"Học viện Công nghệ Hoàng gia Melbourne là một trường đại học Úc hoạt động tại Việt Nam với hai học sở tại thành phố Hồ Chí Minh và Hà Nội. Phân hiệu tại Việt Nam của trường có tên chính thức là Đại học RMIT Việt Nam, thường được gọi là RMIT Việt Nam trong khi cơ sở chính tại Úc được biết đến với tên gọi Đại học RMIT.",
														"url":"https://www.rmit.edu.vn/vi",
														"logo":"https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/RMIT_University_Logo.svg/263px-RMIT_University_Logo.svg.png"
														},
														{
															"@type":"EducationalOrganization",
															"name":"Marie Curie High School",
															"id":"kg:/m/03qjtfv",
															"description":"Nguyễn Thượng Hiền High School is a public high school in Hồ Chí Minh City, Vietnam. It was established in 1970 under the name Tân Bình High School. Being one of the four advanced public magnet schools in the city, Nguyễn Thượng Hiền ranks thirtieth nationally in the 2012 Vietnam university admission ranking.",
															"url":"http://mariecurie.edu.vn/",
															"logo":"http://mariecurie.edu.vn/upload/hinhanh/logo-7109.png"
														}
														]
													}
												}
												</script>';	

	if(@$html_des->find('img') && 1==1) {
													foreach ($html_des->find('img') as $img) {
														$url = URL_ROOT.str_replace('/upload_images','upload_images',$img-> src);

														$alt = $img->getAttribute('alt');

														preg_match ( '#height:(.*?)px#is', $img, $height );

														preg_match ( '#width:(.*?)px#is', $img, $width );


														if($url) {
															$url = str_replace('.webp','',$url);
															$str .= '<script type="application/ld+json">
															{
																"@context":"https://schema.org",
																"@type":"ImageObject",
																"keywords":[
																"'.$alt.'"],
																"About":
																{
																	"@type":"Thing",
																	"image":"'.$url.'",
																	"url":"'.$link.'",
																	"mainEntityOfPage":"'.$link.'",
																	"name":"'.$data-> title.'",
																	"description":"'.$data-> seo_description.'"
																	},
																	"name":"'.$data-> seo_keyword.'",
																	"contentUrl":"'.$url.'",
																	"url":"'.$url.'",
																	"contentSize":"200KB",
																	"width":'.@$width[1].',
																	"height":'.@$height[1].',
																	"uploadDate":"'.$data-> updated_time.'",
																	"caption":"'.$data-> seo_title.'",
																	"alternativeHeadline":"'.$data-> title.'",
																	"description":"'.$data-> seo_description.'",
																	"sourceOrganization":
																	{
																		"@type":"Organization",
																		"name":"Vinalnk",
																		"url":"https://vinalnk.com/",
																		"logo": {
																			"@type": "ImageObject",
																			"url": "'.URL_ROOT.$config['logo'].'",
																			"width":  144,
																			"height": 38
																			},
																			"location":
																			{
																				"@type": "PostalAddress",
																				"addressCountry": "Việt Nam",
																				"name": "Thành phố Hồ Chí Minh",
																				"addressLocality": "Hồ Chí Minh, Việt Nam",
																				"addressRegion": "Việt Nam",
																				"streetAddress": "22/31A Đ. Số 8, Hiệp Bình Phước, Thủ Đức, Thành phố Hồ Chí Minh 700000",
																				"postalCode": "700000"

																			}
																			},
																			"Publisher":
																			{
																				"@type":"Organization",
																				"name":"Vinalnk",
																				"url":"https://vinalnk.com/",
																				"logo": {
																					"@type": "ImageObject",
																					"url": "'.URL_ROOT.$config['logo'].'",
																					"width":  144,
																					"height": 38
																				}
																				},
																				"Creator":
																				{
																					"@type":"Organization",
																					"name":"Vinalnk",
																					"url":"https://vinalnk.com/",
																					"logo": {
																						"@type": "ImageObject",
																						"url": "'.URL_ROOT.$config['logo'].'",
																						"width":  144,
																						"height": 38
																					}
																					},
																					"Producer":
																					{
																						"@type":"Organization",
																						"name":"Vinalnk",
																						"url":"https://vinalnk.com/",
																						"logo": {
																							"@type": "ImageObject",
																							"url": "'.URL_ROOT.$config['logo'].'",
																							"width":  144,
																							"height": 38
																						}
																						},
																						"copyrightHolder":
																						{
																							"@type":"Organization",
																							"name":"Vinalnk",
																							"url":"hhttps://vinalnk.com/",
																							"logo": {
																								"@type": "ImageObject",
																								"url": "'.URL_ROOT.$config['logo'].'",
																								"width":  144,
																								"height": 38
																								
																								},
																								"location":
																								{
																									"@type": "PostalAddress",
																									"addressCountry": "Việt Nam",
																									"name": "Thành phố Hồ Chí Minh",
																									"addressLocality": "Hồ Chí Minh, Việt Nam",
																									"addressRegion": "Việt Nam",
																									"streetAddress": "22/31A Đ. Số 8, Hiệp Bình Phước, Thủ Đức, Thành phố Hồ Chí Minh 700000",
																									"postalCode": "700000"
																								}
																								},
																								"author":
																								{
																									"@type":"Person",
																									"url":"https://vinalnk.com/ct-evans-nguyen.html",
																									"mainEntityOfPage":"https://vinalnk.com/ct-evans-nguyen.html",
																									"@id":"https://vinalnk.com/ct-evans-nguyen.html#person",
																									"name":"Evans Nguyễn",
																									"sameAs":
																									[
																									"https://www.facebook.com/evansnguyen1992/",
																									"https://www.youtube.com/channel/UCZgnxmN0it-vdtMUKuQTueQ/about",
																									"https://www.instagram.com/evansnguyen1992/"
																									],
																									"image":"https://vinalnk.com/upload_images/images/2021/06/24/nguyen-luu.jpg"
																								}
																							}
																							</script>';
																						}
																					}
																				}



																				global $tmpl;
																				$tmpl->addHeader ( $str );
																			}

				function amp_add_size_into_img($content){
																				preg_match_all('#<img(.*?)>#is',$content,$images);
																				$arr_images = array();
																				if(!count($images[0]))
																					return $content;
																				$i = 0;
																				foreach($images[0] as $item){			

																					unset($height);
																					preg_match('#height([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item,$height);

																					if(!isset($height[3])){
																						$item_new = str_replace('<img','<img height="400" ', $item);
	// $content = str_replace($item,$item_new, $content);
																					}elseif(!$height[3]){
																						$item_new = preg_replace('%height([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'height="402"', $item);

	// $content = str_replace($item,$item_new, $content);
																					}else{
																						$item_new = $item;
	// $content = str_replace($item,$item_new, $content);
																					}

																					unset($width);
																					preg_match('#width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item_new,$width);
																					if(!isset($width[3])){
																						$item_new_2 = str_replace('<img','<img width="600" ', $item_new);
	// $content = str_replace($item_new,$item_new_2, $content);
																					}elseif(!$width[3]){
																						$item_new_2 = preg_replace('%width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'width="602"', $item_new);
	// $content = str_replace($item_new,$item_new_2, $content);
																					}else{
																						$item_new_2 = preg_replace('%width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'width="601"', $item_new);
	// $content = str_replace($item_new,$item_new_2, $content);
																					}

																					if($item != $item_new_2){
																						$content = str_replace($item,$item_new_2, $content);
																					}


																				}

																				return $content;	
																			}

																			function table_of_contents($html_string, $depth){
		/*AutoTOC function written by Alex Freeman
		* Released under CC-by-sa 3.0 license
		* http://www.10stripe.com/  */
		


		//get the headings down to the specified depth
		$pattern = '/<h[2-'.$depth.']*[^>]*>.*?<\/h[2-'.$depth.']>/';
		$whocares = preg_match_all($pattern,$html_string,$winners);

		if(empty($winners[0]))
			return $html_string;
		$arr_h = $winners[0];
		$toc = '';
		$last_level = 0;
		$fsstring = FSFactory::getClass('FSString','','../');

		foreach ($arr_h as $h_tag) {
			$innerTEXT = trim(strip_tags($h_tag));
			$innerTEXT = str_replace("'", '', $innerTEXT);
			$innerTEXT = html_entity_decode($innerTEXT, ENT_NOQUOTES); 

			$alias = $fsstring -> stringStandart($innerTEXT);
			$h_id =  str_replace(' ','_',$innerTEXT);

			preg_match('#<h([1-6]*)#is',$h_tag,$level);
			$level = intval(empty($level[1])?2:$level[1]);


			if($level > $last_level)
				$toc .= "<ol class='toc-".$level."'>";
			else{
				$toc .= str_repeat('</li></ol>', $last_level - $level);
				$toc .= '</li>';
			}

			$toc .= "<li><a href='#".$alias."' title='".$innerTEXT."'>".$innerTEXT."</a>";

			$last_level = $level;

			$h_tag_news = preg_replace('/<h([1-6]*)/','<h$1 id="'.$alias.'"',$h_tag);
			$html_string = str_replace($h_tag, $h_tag_news, $html_string);
		}
		$toc .= str_repeat('</li></ol>', $last_level);
		$html_with_toc = $toc ;
		
		//reformat the results to be more usable
		
		$heads = implode("\n",$winners[0]);	
		

		//plug the results into appropriate HTML tags
		$contents = '<div class="all_toc"><span class="close_toc">-</span><div id="toc"> 
		<p id="toc-header">Nội dung bài viết </p>
		<ul>
		'.$html_with_toc.'
		</ul>
		</div></div>'.$html_string;		
		return $contents ;
	}

	function table_of_contents_($html_string, $depth){
		/*AutoTOC function written by Alex Freeman
		* Released under CC-by-sa 3.0 license
		* http://www.10stripe.com/  */
		


		//get the headings down to the specified depth
		$pattern = '/<h[2-'.$depth.']*[^>]*>.*?<\/h[2-'.$depth.']>/';
		$whocares = preg_match_all($pattern,$html_string,$winners);

		//reformat the results to be more usable
		$heads = implode("\n",$winners[0]);
		$heads = str_replace('<a name="','<a href="#',$heads);
		$heads = str_replace('</a>','',$heads);
		$heads = preg_replace('/<h([1-'.$depth.'])>/','<li class="toc$1">',$heads);
		$heads = preg_replace('/<\/h[1-'.$depth.']>/','</a></li>',$heads);

		//plug the results into appropriate HTML tags
		$contents = '<div id="toc"> 
		<p id="toc-header">Contents</p>
		<ul>
		'.$heads.'
		</ul>
		</div>'.$html_string;
		return $contents ;
	}


	function cal_point($data){
		$point = $data -> rating_count ? round(($data -> rating_sum /$data -> rating_count),2): 0;
		if(!$point){
			$a  = ($data -> id  * 3 ) % 30;
			$a =  $a > 15 ? (30 - $a) : $a;
			$a = (35 + $a)/10; 
			$point = $a;
		}
		return $point;
	}

	function cal_count($data){
		$count = $data -> rating_count ?  $data -> rating_count : 0;
		if(!$count){
			$a  = ($data -> id * 4) % 50;
			$a =  $a > 25 ? (50 - $a) : $a;
			$a = 5 + $a; 
			$count = $a;
		}
		return $count;
	}
}

?>