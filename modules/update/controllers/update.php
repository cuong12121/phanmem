<?php
	class UpdateControllersUpdate  extends FSControllers
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
			$arr_result = $model->get_category();
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
			$arr_result = $model->add_news();
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
			$arr_result = $model->syn_products();
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
			$arr_result = $model->add_main_images();
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
	}
	
?>