<?php
	class UpdateControllersUpdate  extends Controllers
	{
		function __construct()
		{
			$this->view = 'update' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function convert_img_webp(){
			$model = $this -> model;
			$arr_result = $model->convert_img_webp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_ngu(){
			$model = $this -> model;
			$arr_result = $model->update_ngu();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}


		function update_discount(){
			$model = $this -> model;
			$arr_result = $model->update_discount();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		function update_hdshop_order(){
			$model = $this -> model;
			$arr_result = $model->update_hdshop_order();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function save(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->save();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
//			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
//				
//			if($id)
//			{
//				setRedirect($link,FSText :: _('Saved'));	
//			}
//			else
//			{
//				setRedirect($link,FSText :: _('Not save'),'error');	
//			}
		}
		
		/*
		 * Lấy hãng sản xuất theo từng nhóm sản phẩm
		 */
		function get_manufactory(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_manufactory();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/*
		 * Vidic: Lấy danh mục sản phẩm nhóm danh mục
		 */
		function get_category(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_category_navado();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/*
		 * Vidic: Lấy xuất xứ SP
		 */
		function get_origin(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_origin();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		/*
		 * Vidic: Lấy dữ liệu cho bảng mở rộng
		 */
		function get_extends(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_extends();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		/*
		 * Vidic: Lấy dữ liệu cho bảng fs_news từ vidic cũ
		 */
		function add_news(){
			$model = $this -> model;
			$arr_result = $model->add_news_navado();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/*
		 * Vidic: Lấy dữ liệu cho bảng sản phẩm
		 */
		function syn_products(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->syn_products_navado();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/*
		 * Vidic: Cap nhap lai
		 */
		function syn_products_update(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->syn_products_update();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/*
		 *  Vidic: Sửa trường warranty_time trong các bảng mở rộng bị lỗi INT
		 */
		function fix_warranty(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->fix_warranty();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/*
		 * Vidic: Lấy dữ liệu cho bảng fs_content từ bảng page
		 */
		function add_content_from_page(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->add_content_from_page();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_cats(){
			$model = $this -> model;
			$arr_result = $model->syn_cats();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_manufactories(){
			$model = $this -> model;
			$arr_result = $model->syn_manufactories();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_author(){
			$model = $this -> model;
			$arr_result = $model->syn_author();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_pagenumber(){
			$model = $this -> model;
			$arr_result = $model->syn_pagenumber();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_translator(){
			$model = $this -> model;
			$arr_result = $model->syn_translator();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function update_home_cats(){
			$model = $this -> model;
			$arr_result = $model->update_home_cats();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_images(){
			$model = $this -> model;
			$arr_result = $model->syn_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		function add_main_images(){
			$model = $this -> model;
			$arr_result = $model->get_main_image_for_products_navado();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_main_images_msmobile(){
			$model = $this -> model;
			$arr_result = $model->add_main_images_msmobile();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_images_other_msmobile(){
			$model = $this -> model;
			$arr_result = $model->add_images_other_msmobile();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_main_images_news_msmobile(){
			$model = $this -> model;
			$arr_result = $model->add_main_images_news_msmobile();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function find_product_error_image_msmobile(){
			$model = $this -> model;
			$arr_result = $model->find_product_error_image_msmobile();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function find_news_error_image_msmobile(){
			$model = $this -> model;
			$arr_result = $model->find_news_error_image_msmobile();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		function repair_products(){
			$model = $this -> model;
			$arr_result = $model->repair_products();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_other_images(){
			$model = $this -> model;
			$arr_result = $model->add_other_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function new_resize_images(){
			$model = $this -> model;
			$arr_result = $model->new_resize_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function valid_manufactory(){
			$model = $this -> model;
			$arr_result = $model->valid_manufactory();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		/*
		 * Chuyển tin trong category "ảnh" sang dạng tin tức loại ẢNH
		 */
		function convert_to_gallery(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->convert_to_gallery();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		/*
		 * Xử lý summary ( bỏ chữ phunutoday đi)
		 */
		function clear_summary(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->clear_summary();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		/*
		 * Xóa các trường
		 */
		function remove_duplicate(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->remove_duplicate();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		/*
		 * Vidic: Tính lại giá
		 */
		function recal_prices(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->recal_prices();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		/*
		 * Vidic: Sinh tags tự động
		 */
		function generate_tags(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->generate_tags();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}

		/*
		 * Daikin: Get ảnh cho trang tĩnh từ site cũ của Tuấn Anh sang
		 */
		function get_images_inner_4_contents(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_images_inner_4_products_navado();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}

		/*
		 * Daikin: Lấy ảnh chính cho tin tức: trên local và cùng hệ thống
		 */
		function get_main_image_for_news_daikin(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_main_image_for_news_daikin();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}

		function get_main_image_for_news(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_main_image_for_news_navado();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}

		

		function syn_products_daikin(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->syn_products_daikin();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}


		/*
		 * Daikin: Lấy ảnh chính cho tin tức: trên local và cùng hệ thống
		 */
		function get_main_image_for_products_daikin(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_main_image_for_products_daikin();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		
		/*
		 * Daikin: Lấy ảnh phụ cho tin tức: trên local và cùng hệ thống
		 */
		function get_other_image_for_products_daikin(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->get_other_image_for_products_daikin();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		

		/******** EUROHOME **********/
		
		function add_products_wp(){
			$model = $this -> model;
			$arr_result = $model->add_products_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function products_resize_images_wp(){
			$model = $this -> model;
			$arr_result = $model->products_resize_images_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		function update_price_wp(){
			$model = $this -> model;
			$arr_result = $model->update_price_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		
		function products_update_extends(){
			$model = $this -> model;
			$arr_result = $model->products_update_extends();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_images_wp(){
			$model = $this -> model;
			$arr_result = $model->add_images_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_news_cats_wp(){
			$model = $this -> model;
			$arr_result = $model->syn_news_cats_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function syn_news_cats_phapluatnet(){
			$model = $this -> model;
			$arr_result = $model->syn_news_cats_phapluatnet();
		
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function syn_news_toppic_phapluatnet(){
			$model = $this -> model;
			$arr_result = $model->syn_news_toppic_phapluatnet();
		
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		//cover news
		function add_news_phapluatnet(){
			$model = $this -> model;
			$arr_result = $model->add_news_phapluatnet();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		//cover news
		function update_member(){
			$model = $this -> model;
			$arr_result = $model->update_member();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function add_tags_news_phapluatnet(){
			$model = $this -> model;
			$arr_result = $model->add_tags_news_phapluatnet();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function add_user_phapluatnet(){
			$model = $this -> model;
			$arr_result = $model->add_user_phapluatnet();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		//update lại user new
		function news_update_userid_code(){
			$model = $this -> model;
			$arr_result = $model->news_update_userid_code();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		//cover ảnh
		function get_main_image_for_news_phapluat(){
			$model = $this -> model;
			$arr_result = $model-> get_main_image_for_news_phapluat();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		//update lại tên ảnh
		function news_update_image_name_phapluat(){
			$model = $this -> model;
			$arr_result = $model-> news_update_image_name_phapluat();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		//update lại tên old ảnh để hỗ trợ cover ảnh
		function news_update_image_old_name_phapluat(){
			$model = $this -> model;
			$arr_result = $model-> news_update_image_old_name_phapluat();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		


		function add_news_wp(){
			$model = $this -> model;
			$arr_result = $model->add_news_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_images_news_wp(){
			$model = $this -> model;
			$arr_result = $model->add_images_news_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function syn_product_cats_eurohome_wp(){
			$model = $this -> model;
			$arr_result = $model->syn_product_cats_eurohome_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function news_resize_images_wp(){
			$model = $this -> model;
			$arr_result = $model->news_resize_images_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		function add_products_eurohome(){
			$model = $this -> model;
			$arr_result = $model->add_products_eurohome();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function add_news_category_eurohome(){
			$model = $this -> model;
			$arr_result = $model->add_news_category_eurohome();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function add_news_eurohome(){
			$model = $this -> model;
			$arr_result = $model->add_news_eurohome();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_news_images_eurohome(){
			$model = $this -> model;
			$arr_result = $model->add_news_images_eurohome();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function update_size_wp(){
			$model = $this -> model;
			$arr_result = $model->update_size_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_images_other_eurohome_wp(){
			$model = $this -> model;
			$arr_result = $model->add_images_other_eurohome_wp();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function synd_cat_products_suachualt(){
			$model = $this -> model;
			$arr_result = $model->synd_cat_products_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function update_list_parents_category(){
			$model = $this -> model;
			$arr_result = $model->update_list_parents_category();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function synd_manu_suachualt(){
			$model = $this -> model;
			$arr_result = $model->synd_manu_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		function add_products_suachualt(){
			$model = $this -> model;
			$arr_result = $model->add_products_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_products_suachualt(){
			$model = $this -> model;
			$arr_result = $model->update_products_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		function update_fields_fs_tables(){
			$model = $this -> model;
			$arr_result = $model->update_fields_fs_tables();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function synd_cat_news_suachualt(){
			$model = $this -> model;
			$arr_result = $model->synd_cat_news_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function add_news_suachualt(){
			$model = $this -> model;
			$arr_result = $model->add_news_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_news_suachualt(){
			$model = $this -> model;
			$arr_result = $model->update_news_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		

		function synd_cat_aq_suachualt(){
			$model = $this -> model;
			$arr_result = $model->synd_cat_aq_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function add_aq_suachualt(){
			$model = $this -> model;
			$arr_result = $model->add_aq_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}


		function synd_cat_video_suachualt(){
			$model = $this -> model;
			$arr_result = $model->synd_cat_video_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function add_video_suachualt(){
			$model = $this -> model;
			$arr_result = $model->add_video_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function synd_cat_album_suachualt(){
			$model = $this -> model;
			$arr_result = $model->synd_cat_album_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function add_album_suachualt(){
			$model = $this -> model;
			$arr_result = $model->add_album_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function add_image_other_products_suachualt(){
			$model = $this -> model;
			$arr_result = $model->add_image_other_products_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function products_resize_images_product_suachualt(){
			$model = $this -> model;
			$arr_result = $model->products_resize_images_product_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		function products_resize_images_other_product_suachualt(){
			$model = $this -> model;
			$arr_result = $model->products_resize_images_other_product_suachualt();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function news_resize_images_suachua(){
			$model = $this -> model;
			$arr_result = $model->news_resize_images_suachua();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		function album_resize_images_suachua(){
			$model = $this -> model;
			$arr_result = $model->album_resize_images_suachua();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function video_resize_images_suachua(){
			$model = $this -> model;
			$arr_result = $model->video_resize_images_suachua();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function hailinh_update_cat_id_wraper(){
			$model = $this -> model;
			$arr_result = $model->hailinh_update_cat_id_wraper();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_type_price_table(){
			$model = $this -> model;
			$arr_result = $model->update_type_price_table();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function create_field_table_extend(){
			$model = $this -> model;
			$arr_result = $model->create_field_table_extend();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_manu_for_cat(){
			$model = $this -> model;
			$arr_result = $model->update_manu_for_cat();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_cat_id_wraper_extra_history(){
			$model = $this -> model;
			$arr_result = $model->update_cat_id_wraper_extra_history();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		function update_city_for_ward(){
			$model = $this -> model;
			$arr_result = $model->update_city_for_ward();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}


		function cv_html_entity_decode(){
			$model = $this -> model;
			$arr_result = $model->cv_html_entity_decode();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		// function update_loi_kho(){
		// 	$model = $this -> model;
		// 	$arr_result = $model->update_loi_kho();
		// 	parent::display();
		// 	include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		// }

		function add_history_detail_bill(){
			$model = $this -> model;
			$arr_result = $model->add_history_detail_bill();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		// function update_loi_ton(){
		// 	$model = $this -> model;
		// 	$arr_result = $model->update_loi_ton();
		// 	parent::display();
		// 	include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		// }

		// function update_loi_ton_2_12(){
		// 	$model = $this -> model;
		// 	$arr_result = $model->update_loi_ton_2_12();
		// 	parent::display();
		// 	include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		// }


		function update_loi_nhuan_1(){
			$model = $this -> model;
			$arr_result = $model->update_loi_nhuan_1();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}
		

		function update_loi_nhuan_2(){
			$model = $this -> model;
			$arr_result = $model->update_loi_nhuan_2();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_loi_nhuan_3(){
			$model = $this -> model;
			$arr_result = $model->update_loi_nhuan_3();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}

		function update_loi_nhuan_4(){
			$model = $this -> model;
			$arr_result = $model->update_loi_nhuan_4();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';		
		}


		function fast_request($host,$path,$ssl = 0)
		{
			
			$host = str_replace('http://', '', $host);
			$host = str_replace('https://', '', $host);
			$host = str_replace('/', '', $host);

		    // $parts=parse_url($url);
		    if($ssl){
		    	$fp = fsockopen('ssl://'.$host,443,$errno, $errstr, 300);
		    }else{
		    	 $fp = fsockopen($host,80,$errno, $errstr, 300);
		    }

		    $out = "GET ".$path." HTTP/1.1\r\n";
		    $out.= "Host: ".$host."\r\n";
		    $out.= "Content-Length: 0"."\r\n";
		    $out.= "Connection: Close\r\n\r\n";
		    fwrite($fp, $out);
		    fclose($fp);
		}

		function update_loi_nhuan_4_fast(){
			ignore_user_abort(1);
			$link_count = 'admin/index.php?module=update&view=update&task=update_loi_nhuan_4';
			$this -> fast_request(URL_ROOT,$link_count,0);
			ignore_user_abort(0);
		}
		

		
	}
	
?>