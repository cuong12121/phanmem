<?php
/*
 * Huy write
 */
// controller


class ProductsControllersProduct extends FSControllers {
	var $module;
	var $view;
	function __construct() {
		parent::__construct ();
		$arr_layout = array (array ('characteristic', 'Thông số kĩ thuật', 'thong-so-ki-thuat' ), array ('accessories', 'Phụ kiện', 'phu-kien' ) );
		$this->arr_layout = $arr_layout;
	}
	function display() {


		// call models
		$model = $this->model;

		$orders =  $model -> get_orders();
    $data = $model->get_product ();

    if (! $data){
      $data_new = $model->get_news ();

      if($data_new){

        $link = FSRoute::_ ( "index.php?module=news&view=news&code=" . trim ( $data_new->alias ) . "&id=" . $data_new->id . "&ccode=" . trim ( $data_new->category_alias ) );
        setRedirect ( $link );
        return;
      }

      setRedirect(FSRoute::_('index.php?module=notfound&view=notfound'),'Sản phẩm này không tồn tại');
    }

    $code = FSInput::get('code');

    $id = FSInput::get('id',0,'int');
    $ccode = FSInput::get('ccode');
    $cid = FSInput::get('cid',0,'int');

    if($code != $data-> alias  || $id != $data-> id ){
      $link = FSRoute::_("index.php?module=products&view=product&code=".trim($data->alias)."&id=".$data -> id."&ccode=".trim($data-> category_alias)."&Itemid=$Itemid");
      setRedirect($link);
    }

    $cat = $model->getCategoryById ( $data->category_id );
    if (! $cat){
      setRedirect(FSRoute::_('index.php?module=notfound&view=notfound'),'Danh mục này không tồn tại');
    }
    if ($cat->alias != $ccode) {
      $Itemid = 6;
      $link = FSRoute::_ ( 'index.php?module=products&view=product&code=' . $data->alias . '&id=' . $data->id . '&ccode=' . $cat->alias . '&Itemid=' . $Itemid );
      setRedirect ( $link );
    }


    $total_compare=0;
    $price =  calculator_price($data->price,$data->price_old,$data -> is_hotdeal,$data->date_start,$data->date_end,$data->manufactory_discount,$data->price_km,$data->discount_km);

    if(isset($_SESSION[$data->tablename])) {
      $arr_prd_compare = $_SESSION[$data->tablename];
      $total_compare =count($arr_prd_compare);
    }

    $orderProducts = $model->setCookie();
    $extend = $model->getProductExt ( $data->tablename, $data->id );
    $data_extends = $model -> get_data_extends( );
        // extension field
    $ext_fields = $model->get_ext_fields ( $data->tablename );


    $str_group_fields = '';
    $arr_ext_fileds_by_group = array();
    if(count($ext_fields)){
      $i = 0;
      foreach($ext_fields as $item){
        if($item -> group_id){
          if($i > 0)
            $str_group_fields .= ',';
          $str_group_fields .= $item -> group_id;
          $i ++; 
          if(!isset($arr_ext_fileds_by_group[$item -> group_id]))
            $arr_ext_fileds_by_group[$item -> group_id] = array();
          $arr_ext_fileds_by_group[$item -> group_id][] = $item;
        }else{
          if(!isset($arr_ext_fileds_by_group[0]))
            $arr_ext_fileds_by_group[0] = array();
          $arr_ext_fileds_by_group[0][] = $item;
        }
      }
    }

    $ext_group_fields = $model ->  get_ext_group_fields($str_group_fields);


        // Nội dung bài viết có insert thêm mẫu bài viết
    $description = $model->insert_keyword_to_content ( $data->description );


    $id_tmp =  preg_match ( '#{temp=(.*?)}#is',  $description, $id_search );
    $id_tmp_replace =  preg_match ( '#{temp=(.*?)}#is',  $description, $id_search_replace );

    if($id_tmp){
      $id_search = $id_search[1];
      $id_replace = $id_search_replace[0];
    }



    if($id_search){
      $tmp_description = $model -> get_record('published = 1 AND id ='.$id_search,'fs_products_description_tmp','content,id');
      $description = str_replace($id_replace, $tmp_description-> content, $description);
    }else{
      if(isset($id_replace)){
        $description = str_replace($id_replace, '', $description);
      }

    }

    


        // seo
    global $tmpl, $module_config;

        // param from config_module
    FSFactory::include_class ( 'parameters' );
    $current_parameters = new Parameters ( isset($module_config->params)?$module_config->params:null );
    $guide = json_decode($current_parameters->getParams ( 'guide'));
    $warranty_detail = json_decode($current_parameters->getParams ( 'warranty_detail'));
    $product_images = $model->getImages ( $data->id );

    
    $product_images_360 = $model->getImages360 ( $data->id );
    $product_video = $model->getVideo ( $data->id );

        // sản phẩm gợi ý ( lấy từ database)
		//echo $data->manufactory;
    $relate_products_list = $model->get_products_in_cat( $data->category_id,$data->manufactory, $data->id,$data->price );

    $types = $model->get_types ();
    $manu = $model->get_record_by_id($data -> manufactory,'fs_manufactories');
    $query_body = $model -> set_query_body($data->id);
                        // $comments = $model -> get_comments($query_body);
                        // $total_point = $smodel -> get_total_point_comments($query_body);
        //			$product_cmp= $model -> get_compare_product($cat->tablename);
		//echo $query_body;die;
                        // die;
                        // $total = $model -> getTotal($query_body);

                        // $rating_count =$total_comment;
                        // $rating_sum= 0;
                        // if ($total_comment) {
                        //         $list_parent = array ();
                        //         $list_children = array ();
                        //         foreach ( $comments as $item ) {
                        //                 if (! $item->parent_id) {
                        //                         $list_parent [] = $item;
                        //                 } else {
                        //                         if (! isset ( $list_children [$item->parent_id] ))
                        //                                 $list_children [$item->parent_id] = array ();
                        //                         $list_children [$item->parent_id] [] = $item;
                        //                 }
                        //                 $rating_sum += $item->rating;
                        //         }
                        // }

    $session_order = $model -> getOrder();
    $user = $model -> get_user();
                        //input info
    $sender_name = isset($session_order-> sender_name)?$session_order-> sender_name:@$user->full_name;
    $sender_sex = isset($session_order->sender_sex)?$session_order->sender_sex:@$user -> sex;
    $sender_address = isset($session_order->sender_address)?$session_order->sender_address:@$user -> address;
    $sender_email = isset($session_order->sender_email)?$session_order->sender_email:@$user -> email;
    $sender_telephone = isset($session_order->sender_telephone)?$session_order->sender_telephone:@$user -> mobilephone;
    $discount_code = isset($session_order->discount_code)?$session_order->discount_code:'';

    $lis_cat_parent = $model->get_list_parent ( $data->category_id_wrapper );
    $breadcrumbs = array ();
    for($i = 0; $i < count ( $lis_cat_parent ); $i ++) {
      $item = $lis_cat_parent [$i];
      $breadcrumbs [] = array (0 => $item->name, 1 => FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $item->alias .'&cid='.$item -> id. '&Itemid=10' ) );
    }
    ///$breadcrumbs[] = array(0=>$data->name, 1 => '');	
    global $tmpl;
    $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
    $tmpl->assign ( 'id', $data -> id );
    FSFactory::include_class ( 'parameters' );
    $current_parameters = new Parameters ( isset($module_config->params)?$module_config->params:null );
    $guide = json_decode($current_parameters->getParams ( 'guide'));
    $this->set_header ( $data );
    $tmpl->set_data_seo ( $data );
                            // call views
    if(!$data->is_special){

      include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }else{

      $product_special = $model->getSpecial( $data->id );
      $department = $model->getDepartment();
      include 'modules/' . $this->module . '/views/' . $this->view . '/default_special.php';
    }
  }
  function ajax_view_fast() {
		// call models
    $model = $this->model;
    $conf = $model -> get_config();

    $hotline=$conf->value;
    $limit_all = FSInput::get ( 'lm' );
    $type = FSInput::get ( 'tp' );
    $ordering=" created_time desc ";
    $list_pro = $model -> get_list($ordering,$limit_all,$type);
    $data = $model->get_product2();
    $id_next=0;
    $id_prev=0;
    $ii=0;
    $hidden="";
    $hidden_prev="";
    foreach ($list_pro as $value) {
      if($value->id==$data->id && @$list_pro[$ii+1]){
        $id_next=$list_pro[$ii+1]->id;
      }
      if($value->id==$data->id && @$list_pro[$ii-1]){
        $id_prev=$list_pro[$ii-1]->id;
      }
      if($data->id==$list_pro[count($list_pro)-1]->id){
        $hidden.=" style='display:none'";
      }else{
        $hidden=" ";
      }
      if($data->id==$list_pro[0]->id){
        $hidden_prev.=" style='display:none'";
      }else{
        $hidden_prev=" ";
      }
      $ii++;
    }
    if (! $data)
     die ( 'S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i' );

   $price =  calculator_price($data->price,$data->price_old,$data -> is_hotdeal,$data->date_start,$data->date_end,$data->manufactory_discount,$data->price_km,$data->discount_km);
//        $price =  calculator_price($data->price,$data->price_old,$data -> is_hotdeal,$data->date_start,$data->date_end,$data->manufactory_discount);

   $extend = $model->getProductExt ( $data->tablename, $data->id );

		// extension field
   $ext_fields = $model->get_ext_fields ( $data->tablename );
//		$data_foreign = $model -> get_data_foreign($ext_fields );
   $str_group_fields = '';
   $arr_ext_fileds_by_group = array();
   if(count($ext_fields)){
     $i = 0;
     foreach($ext_fields as $item){
      if($item -> group_id && ($item->field_name=='xuat_xu' || $item->field_name=='loai_day' )){
       if($i > 0)
        $str_group_fields .= ',';
      $str_group_fields .= $item -> group_id;
      $i ++; 
      if(!isset($arr_ext_fileds_by_group[$item -> group_id]))
        $arr_ext_fileds_by_group[$item -> group_id] = array();
      $arr_ext_fileds_by_group[$item -> group_id][] = $item;
    }else if($item->field_name=='xuat_xu' || $item->field_name=='loai_day' ){
     if(!isset($arr_ext_fileds_by_group[0]))
      $arr_ext_fileds_by_group[0] = array();
    $arr_ext_fileds_by_group[0][] = $item;
  }
}
}
		// echo $str_group_fields;die;
$ext_group_fields = $model ->  get_ext_group_fields($str_group_fields);

		// seo
global $tmpl, $module_config;

$product_images = $model->getImages ( $data->id );
$product_video = $model->getVideo ( $data->id );
$products_in_manufactory = $model->get_products_in_manufactory ( $data->category_id,$data->manufactory, $data->id );

$types = $model->get_types ();
$manu = $model->get_record_by_id($data -> manufactory,'fs_manufactories');
if($extend->xuat_xu){
 $data_xx = $model -> getXuatXuViewFast($extend->xuat_xu);
}
if($extend->loai_day){
 $data_loaiday = $model -> getLoaiDayViewFast($extend->loai_day);
}


include 'modules/' . $this->module . '/views/' . $this->view . '/ajax_load_more_fast.php';
return;
}
function ajax_view_fast_cat() {
		// call models
  $model = $this->model;

  $limit_all = FSInput::get ( 'lm' );
  $type = FSInput::get ( 'tp' );
  $conf = $model -> get_config();
  $data = $model->get_product2();

  $hotline=$conf->value;
  $id_next=0;
  $id_prev=0;
  $ii=0;
  $hidden="";
  $hidden_prev="";
  $id = FSInput::get ( 'id' );
  $id_current=array_search($id, $_SESSION["view_fast"]);
  $id_next=$_SESSION["view_fast"][$id_current+1];

  $id_prev=$_SESSION["view_fast"][$id_current-1];
//                foreach ($list_pro as $value) {
//                    if($value->id==$data->id && @$list_pro[$ii+1]){
//                        $id_next=$list_pro[$ii+1]->id;
//                    }
//                    if($value->id==$data->id && @$list_pro[$ii-1]){
//                        $id_prev=$list_pro[$ii-1]->id;
//                    }
  if(!$id_next){
    $hidden.=" style='display:none'";
  }else{
    $hidden=" ";
  }
  if(!$id_prev){
    $hidden_prev.=" style='display:none'";
  }else{
    $hidden_prev=" ";
  }
//                    $ii++;
//                }
  if (! $data)
   die ( 'S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i' );

 $price =  calculator_price($data->price,$data->price_old,$data -> is_hotdeal,$data->date_start,$data->date_end,$data->manufactory_discount,$data->price_km,$data->discount_km);

 $extend = $model->getProductExt ( $data->tablename, $data->id );

		// extension field
 $ext_fields = $model->get_ext_fields ( $data->tablename );
//		$data_foreign = $model -> get_data_foreign($ext_fields );
 $str_group_fields = '';
 $arr_ext_fileds_by_group = array();
		// if(count($ext_fields)){
		// 	$i = 0;
		// 	foreach($ext_fields as $item){
		// 		if($item -> group_id){
		// 			if($i > 0)
		// 				$str_group_fields .= ',';
		// 			$str_group_fields .= $item -> group_id;
		// 			$i ++; 
		// 			if(!isset($arr_ext_fileds_by_group[$item -> group_id]))
		// 				$arr_ext_fileds_by_group[$item -> group_id] = array();
		// 			$arr_ext_fileds_by_group[$item -> group_id][] = $item;
		// 		}else{
		// 			if(!isset($arr_ext_fileds_by_group[0]))
		// 				$arr_ext_fileds_by_group[0] = array();
		// 			$arr_ext_fileds_by_group[0][] = $item;
		// 		}
		// 	}
		// }
		// $ext_group_fields = $model ->  get_ext_group_fields($str_group_fields);

		// seo
 global $tmpl, $module_config;

 $product_images = $model->getImages ( $data->id );
 $product_video = $model->getVideo ( $data->id );
 $products_in_manufactory = $model->get_products_in_manufactory ( $data->category_id,$data->manufactory, $data->id );

 $types = $model->get_types ();
 $manu = $model->get_record_by_id($data -> manufactory,'fs_manufactories');


 if($extend->xuat_xu){
   $data_xx = $model -> getXuatXuViewFast($extend->xuat_xu);
 }
 if($extend->loai_day){
   $data_loaiday = $model -> getLoaiDayViewFast($extend->loai_day);
 }


 include 'modules/' . $this->module . '/views/' . $this->view . '/ajax_load_more_fast_cat.php';
 return;
}
function show_layout($link_image_remote) {
  $layout = FSInput::get ( 'layout', 'thong-so-ki-thuat' );
  $arr_layout = $this->arr_layout;
  $Itemid = FSInput::get ( 'Itemid' );
  $id = FSInput::get ( 'id' );
  foreach ( $arr_layout as $item ) {
			//				$link  = FSRoute::_("index.php?module=products&view=product&id=$id&layout=$item[2]&Itemid=$Itemid"); 
   $link = FSRoute::addParameters ( 'layout', $item [2] );
   if ($layout == $item [2]) {
    echo "<li class='prd_cat_current'> <span>&nbsp; </span> <a  href='" . $link . "' ><span>" . $item [1] . "</span></a>";
  } else {
    echo "<li class='prd_cat_menu'><span>&nbsp; </span><a  href='" . $link . "' ><span>" . $item [1] . "</span></a>";
  }
}
echo "<li class='prd_cat_menu'><span>&nbsp; </span><a  href='" . $link_image_remote . "' target='_blink' ><span>" . 'Ảnh' . "</span></a>";
}

	/*
		 * Save rating
		 */
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
	function rating_design() {
		$model = $this->model;
		if (! $model->save_rating_design ()) {
			echo '0';
			return;
		} else {
			echo '1';
			return;
		}
	}
	function rating_features() {
		$model = $this->model;
		if (! $model->save_rating_features()) {
			echo '0';
			return;
		} else {
			echo '1';
			return;
		}
	}
	function rating_performance() {
		$model = $this->model;
		if (! $model->save_rating_performance()) {
			echo '0';
			return;
		} else {
			echo '1';
			return;
		}
	}
	function vote_result() {
   $model = $this -> model;
   if(!$model -> save_vote_result()){
    return;
  } else {
    $data = $model->get_product ();
    $html ='';
    $html .='<dl id="vote_grph">';
    $html .='<dt>Thiết kế</dt>';
    $pdesign = $data -> rating_design_sum ? ceil($data -> rating_design_sum /$data -> rating_count_vote): 0 ;
    $pfeatures = $data -> rating_features_sum ? ceil($data -> rating_features_sum /$data -> rating_count_vote): 0 ;
    $pperformance = $data -> rating_performance_sum ? ceil($data -> rating_performance_sum /$data -> rating_count_vote): 0 ;
    $html .='<dd id="vote_grph_design">';
    $html .='<span class="img">';
    $html .='<img width="'.($pdesign*10).'%" src="'.URL_ROOT.'/modules/products/assets/images/spacer.gif">';
    $html .='</span>';
    $html .='<span class="number">'.$pdesign.'</span>';
    $html .='</dd>';
    $html .='<dt>Tính năng</dt>';
    $html .='<dd id="vote_grph_features">';
    $html .='<span class="img">';
    $html .='<img width="'.($pfeatures*10).'%" src="'.URL_ROOT.'/modules/products/assets/images/spacer.gif">';
    $html .='</span>';
    $html .='<span class="number">'.$pfeatures.'</span>';
    $html .='</dd>';
    $html .='<dt>Hiệu suất</dt>';
    $html .='<dd id="vote_grph_performance">';
    $html .='<span class="img">';
    $html .='<img width="'.($pperformance*10).'%" src="'.URL_ROOT.'/modules/products/assets/images/spacer.gif">';
    $html .='</span>';
    $html .='<span class="number">'.$pperformance.'</span>';
    $html .='</dd>';
    $html .='</dl>';
    $html .='<form id="frmVote" name="frmVote" method="post">';
    $html .='<div id="vote_rate">';
    $html .='<select id="pDesign" name="pDesign" title="Design">';
    $html .='<option value="">----</option>';
    for($i = 1; $i <= 10;$i ++){
      $html .='<option>'.$i.'</option>';
    }
    $html .='</select>';
    $html .='<select id="pFeatures" name="pFeatures" title="Features">';
    $html .='<option value="">----</option>';
    for($i = 1; $i <= 10;$i ++){
      $html .='<option>'.$i.'</option>';
    } 
    $html .='</select>';
    $html .='<select id="pPerformance" name="pPerformance" title="Performance">';
    $html .='<option value="">----</option>';
    for($i = 1; $i <= 10;$i ++){
      $html .='<option>'.$i.'</option>';
    }
    $html .='</select>';
    $html .='</div>';
    $html .='<div id="vote_submit">';
    $html .='<span class="number">'.$data -> rating_count_vote.' lần</span>';
    $html .='<span class="submit">';
    $html .='<input id="button_vote" type="button" value="Đánh giá">';
    $html .='<input type="hidden" name="record_id" id="record_id" value="'. $data -> id.'">';	
    $html .='</span>';
    $html .='<br class="clear">';
    $html .='</div>';
    $html .='</form>';
    $html .='<script>$( "#button_vote" ).click(function() {  alert( "Bạn đã đánh giá thiết bị này rồi !" );});</script>';

    echo $html;
    return;
  }
}

	// update hits
function update_hits(){
 $model = new ProductsModelsProduct();
 $product_id = FSInput::get('id');
 $model -> update_hits($product_id);
}

function get_data_foreign($table_name,$value,$type){
 $model = $this -> model;
 return $model -> get_data_foreign($table_name,$value,$type);
}
function fetch_price_product(){
 $model = $this -> model;	
 $price = FSInput::get ( 'price' );	
 $data = $model->get_price_product();
 $html = "";
 $html .="<span>". format_money($price+$data->price,'đ')."</span>";
 echo $html;
 return;
}

function buy(){
			$product_id = FSInput::get('id',0,'int'); // product_id
			$warranty = FSInput::get('warranty'); // product_id
			FSFactory::include_class('errors');
			if(!$product_id)
				Errors::_('Sản phẩm chưa xác định');
      $model = $this -> model;	

      if(!isset($_SESSION['cart'])) {
        $product_list = array();

        $prices = $model -> getPrice();
        if($prices == '-1'){
         Errors::_("Không tồn tại sản phẩm trong giỏ hàng",'error');
         return;
       }
				$product_list[] = array($product_id, 1 ,$prices[0],$prices[1],$warranty); // prdid,quality, price, discount
				
			} else {
				$product_list  = $_SESSION['cart'];
				
				$exist_prd  = 0;
				for ($j = 0; $j < count($product_list); $j ++) {
					$prd = $product_list[$j];

					if($prd[0] == $product_id) {
						$product_list[$j][1] ++;
						$product_list[$j][4] = $warranty;
						$exist_prd ++;
						break;
					} 
				}
				// if not exist product
				if(!$exist_prd) {
					$prices = $model -> getPrice();
					$product_list[count($product_list)] = array($product_id,1,$prices[0],$prices[1],$warranty);
				}
			}
			
			$_SESSION['cart']  = $product_list  ;


			$html ='';
      $html .=' <div class="modal-dialog">';
      $html .=' <div class="modal-content">';
      $html .='<div class="modal-header">';
      $html .='<h4 class="modal-title"><span>Thêm vào giỏ hàng</span></h4>';
      $html .=' </div>';
      $html .='<div class="modal-body">';
      if(!isset($_SESSION['cart'])) {
       $html .=' <div class="check-square mt10"><strong>Sản phẩm đã thêm vào giỏ hàng</strong></div>';
     }else{
      $html .=' <div class="check-square mt10"><strong>Sản phẩm chưa thêm vào giỏ hàng</strong></div>';
    }
    $html .='  </div>';
    $html .=' <div class="modal-footer">';
    $html .=' <button type="button" class="btn btn-default" data-dismiss="modal">Xem tiếp sản phẩm</button>';
    $html .=' <a  href="'. FSRoute::_("index.php?module=products&view=cart&task=eshopcart2").'" class="btn btn-default">Giỏ hàng của bạn</a>';
    $html .=' </div>';
    $html .='</div>';
    $html .='</div>';
    $html .=' </div>';
    echo $html;
    return;
  }		
  function load_price_by_dcare(){
   $value = FSInput::get('value');
   $model = $this->model;
   $data = $model->get_product ();
   if (! $data)
    return;
  if($data -> is_hotdeal){
    if($data -> date_end >  date('Y-m-d H:i:s') && $data->date_start <  date('Y-m-d H:i:s'))
     $price = $data->price;
   else
     $price = $data->price_old;
 }else{
  $price= $data->price;
}
$html ='';
if($value == 1){
 $html .= '<span>'.format_money($price,'đ').'</span>';
}else if($value == 2){
  $html .='<span>'.format_money(($price+300000),'đ').'</span>';
}else{
  $html .= '<span>'.format_money(($price+600000),'đ').'</span>';
}
$html .=' <span></span>';
echo $html;
return;
}
		/*
		 * function save info of sender and recipient
		 */
		function eshopcart2_simple_save(){
			$model = $this -> model;	
			$Itemid = FSInput::get('Itemid',0,'int');
			// get temporary data stored in fs_order:
			$order_id = $model -> eshopcart2_simple_save();
			$Itemid = FSInput::get('Itemid',0,'int');
			if($order_id) {
//				$send_mail  = $model -> mail_to_buyer_simple($order_id);
				$link = FSRoute::_('index.php?module=products&view=cart&task=finished&id='.$order_id.'&Itemid='.$Itemid);
				setRedirect($link,'Đơn hàng của bạn đã được gửi đi. Chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất. Xin cảm ơn!');
			} else {
				$link = FSRoute::_('index.php?module=products&view=cart&task=order&Itemid='.$Itemid);
				setRedirect($link);
			}
		}



    function register_phone(){
      $data['phone'] = FSInput::get('phone_res', '');
      $data['product_id'] = FSInput::get('p_id', '');
      $data['product_name'] = FSInput::get('p_name', '');
      $data['created_time'] = date('Y-m-d H:i:s');
      $id = $this->model->_add($data, 'fs_phone_members');
			$this->send_mail_register_phone($data['phone'],$data['product_name']);
      if(!$id){
       echo "0";die;
     }else{
       echo "1";die;
     }
   }

   function set_header($data, $image_first = '') {
    global $config;
    $link = FSRoute::_ ( "index.php?module=products&view=product&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias."&cid=" . $data->category_id );
    $image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );
    $str = '<meta property="og:image"  content="' . $image . '" />
    <meta property="og:image:width" content="600 "/>
    <meta property="og:image:height" content="315"/>
    ';
    $amp = FSInput::get('amp',0,'int');
    if(!$amp){
      // $str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';
    }else{
      $str .= '
      <script async custom-element="amp-facebook-comments" src="https://cdn.ampproject.org/v0/amp-facebook-comments-0.1.js"></script>
      <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
      <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
      <script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.1.js"></script>
      ';

    }
    // $str .= '<meta property="og:description"  content="' . htmlspecialchars ( $data->summary ) . '" />';

    $rating_value = $data -> rating_count ? round($data -> rating_sum /$data -> rating_count): 4 ;
    $rating_count = $data -> rating_count?$data -> rating_count:1; 


    // $str .= '    
    //  <script type="application/ld+json">
    //  {
    //      "@context": "http://schema.org/",
    //      "@type": "Product",
    //      "name": "'.htmlspecialchars ( $data->name ).'",
    //      "image": "' . $image . '",
    //      "description": "' . htmlspecialchars ( $data->summary ) . '",
    //      "mpn": "' . $data -> id . '",
    //      "brand": {
    //          "@type": "' . htmlspecialchars ( $data->category_name ) . '",
    //          "name": "' . ( $data->manufactory_name ? htmlspecialchars ( $data->manufactory_name ):htmlspecialchars ( $data->summary ) ). '"
    //      },
    //      "aggregateRating": {
    //          "@type": "AggregateRating",
    //          "ratingValue": "'.$rating_value.'",
    //          "reviewCount": "'.$rating_count.'"
    //      },
    //      "offers": {
    //          "@type": "Offer",
    //          "priceCurrency": "VND",
    //          "price": "'.$data -> price.'",
    //          "priceValidUntil": "2020-11-05",
    //          "itemCondition": "http://schema.org/UsedCondition",
    //          "availability": "http://schema.org/InStock",
    //          "seller": {
    //              "@type": "Retail",
    //              "name": "'.URL_ROOT.'"
    //          }
    //      }
    //  }

    //  </script>';

    
    global $tmpl;
    $tmpl->addHeader ( $str );
  }

  function check_phone(){
   global $tmpl, $user;
					 //error_reporting(E_ALL); 
   $phone = FSInput::get('phone');
   $product_id = FSInput::get('product_id');
   $data = $this->model->check_exist_phone($product_id,$phone);

   if($data){
     echo "0";die;
   }else{
     echo "1";die;
   }

 }

 function mail_after_register_phone()
 {
  $phone = FSInput::get('phone_res', '');
  $name = FSInput::get('p_name', '');
						//error_reporting (E_ALL);
  FSFactory::include_class('errors');
						// include 'libraries/fsglobal.php';
  $mailer = FSFactory::getClass('Email','mail');
  $global = new FsGlobal();
						// sender
  $sender_name = FSInput::get('contact_name');
  $sender_email = FSInput::get('contact_email');

						// Recipient

  $to = $global-> getConfig('admin_email');
  $site_name = $global-> getConfig('site_name');

  global $config;
  $subject = 'Thông báo -  Khách hàng đăng kí số điện thoại theo sản phẩm';

  $mailer -> isHTML(true);
  $mailer -> setSender(array($to,$subject));

  $mailer -> AddAddress($to,'admin');
  $mailer -> AddBCC('robocon20062007@gmail.com','pham van huy');
  $mailer -> setSubject(''.html_entity_decode($site_name).' '.$subject);
						// body

  $body = '';
  $body .= '<p align="left">Có khách hàng đăng kí số điện thoại theo sản phẩm:</p>';
  $body .= '<p align="left"><strong>Tên sản phẩm : </strong> '.$name.'</p>';
  $body .= '<p align="left"><strong>Số điện thoại đăng kí : </strong> '.$phone.'</p>';
						//echo $site_name;die;
  $mailer -> setBody($body);
  if(!$mailer ->Send())
   return false;
 return true;
}


function export_product(){
  $model = $this -> model;
  $export = $model ->export_product();
  include 'modules/' . $this->module . '/views/' . $this->view . '/export_product.php';
}







// function get_from_reply(){
//   $num = FSInput::get('num');
//   $html='<div class="comment_form cf form-reply" >
//   <form method="post" name="comment_add_form_'.$num.'" id="comment_add_form'.$num.'" class="form_comment">
//   <div class="wrapper-txt-comment">
//   <textarea id="full_rate'.$num.'" class="txt_input full_rate" placeholder="Viết đánh giá của bạn tại đây..." rows="6" name="full_rate"></textarea>
//   </div>
//   <div class="clearfix">

//   </div>
//   <div class="left-cm fl">
//   <div class="row-cm">
//   <div class="title-comment">
//   Nhập thông tin để bình luận
//   </div>
//   <input type="text" id="name'.$num.'" name="name" placeholder="Họ và tên" value="" class="txt_input name">
//   <input type="text" id="email'.$num.'" name="email" placeholder="Email" class="txt_input email">
//   <input type="text" id="phone'.$num.'" name="phone" placeholder="Điện thoại" class="txt_input phone">
//   <input type="hidden" name="reply_for_id" id="reply_for_id'.$num.'" value="'.$num.'" />
//   </div>
//   </div>
//   <div class="right-cm">
//   <div class="row-cm">
//   <div class="wrapper-capcha cf">
//   <input type="button" class="button submitbt fl" onclick="comment_review('.$num.')" value="Bình luận" id="submitbt">
//   </div>
//   </div>
//   </div>
//   </form>
//   </div>';
//   echo $html;die;
// }

function popup_gallery(){
  $model = $this -> model;
  $productID = FSInput::get('productID');   
  $imageType = FSInput::get('imageType');   
  $colorID = FSInput::get('colorID');     
  $html='';
  switch($imageType){
    case '1':
    $images = $model->getImages ($productID,$colorID );
    if(count($images)){
      $html .='<div class="fotorama" data-auto="false" data-allowfullscreen="true" data-nav="thumbs" data-fit="scaledown" data-thumbwidth="100" data-arrows="true" data-click="false" data-swipe="true">';
      foreach ($images as $item) {
        $small = URL_ROOT.str_replace('/original/','/small/', $item -> image);
        $large = URL_ROOT.str_replace('/original/','/original/', $item -> image);
        $html .='<div class="caption_ps" data-thumb="'.$small.'" data-img="'.$large.'" data-picid="'.$item -> id.'"> </div>';
      }
      $html .='</div>';
    }
    break;
    case '4':
    $data = $model->get_record_by_id ($productID ,'fs_products','video' );
    if($data -> video){
      $query = parse_url($data -> video, PHP_URL_QUERY);
      parse_str($query, $arr);
      $variable = $arr['v'];
    }
        // $videos = $model->getImages ($productID );
        // if(count($videos)){
    $html .='<div class="fotorama" data-auto="false" data-allowfullscreen="true" data-nav="thumbs" data-fit="scaledown" data-thumbwidth="100" data-arrows="true" data-click="false" data-swipe="true">';
          // foreach ($videos as $item) {
    $html .=' <a href="http://www.youtube.com/watch?v='.$variable.'&?autoplay=1" data-thumb="//img.youtube.com/vi/'.$variable.'/maxresdefault.jpg" data-picid="'.$productID.'" data-video="true"></a>';
            // $html .=' <a href="http://www.youtube.com/watch?v=hbbejNuzS-o&?autoplay=1" data-thumb="//img.youtube.com/vi/hbbejNuzS-o/maxresdefault.jpg" data-picid="1124490" data-video="true"></a>';
          // }
    $html .='</div>';
        // }
    break;

    default:
    return; 
  }

  echo $html;
}
}

?>
