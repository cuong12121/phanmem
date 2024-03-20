<?php
class Templates {
	var $file;
	var $tmpl;
	var $variables;
	var $head_meta_key;
	var $head_meta_des;
	var $title;
	var $style = "";
	var $style_rps = "";
	var $script_top = "";
	var $script_bottom = "";
	var $script_bottom_async = "";
	var $array_meta = array ();
	var $arr_blocks = array ();
	var $display_position = 0;
	var $title_maxlength = 70;
	var $metakey_maxlength = 170;
	var $metadesc_maxlength = 165;
	var $str_header = ''; // giá trị trèn vào header
	var $str_footer = ''; // giá trị trèn vào footer
	function __construct($file = null, $tmpl = null) {
//	    	$global  = new FsGlobal();
		$this->load_all_block ();
		global $config;
		global $head_meta_key, $head_meta_des, $title, $array_meta;
		$this->file = $file;
		$this->tmpl = $tmpl;
		//	        $this->head_meta_key = isset($config['mate_key'])?$config['mate_key']:'';
		$this->head_meta_des = isset ( $config ['meta_des'] ) ? $config ['meta_des'] : '';

		$this->array_meta = $array_meta;
		$this->title = str_replace ( chr ( 13 ), '', htmlspecialchars ( $title ) );

		// default:
		$this->style = array ();
		$this->style_rps = array ();
		$this->script_top = array ();
		$this->script_bottom = array ();
		$this->script_bottom_async = array ();
		
		$amp = FSInput::get('amp',0,'int');
		if($amp){
		//	array_push ( $this->style, URL_ROOT . "templates/mobile/css/style.css" );
		//	array_push ( $this->style, URL_ROOT . "libraries/jquery/owl.carousel.2.0.0-beta.2.4/assets/owl.carousel.css" );
		//	array_push ( $this->script_bottom, URL_ROOT . "libraries/jquery/jquery-1.11.0.min.js" );
		//	array_push ( $this->script_bottom, URL_ROOT . "templates/mobile/js/bootstrap.min.js" );
			// array_push ( $this->script_bottom, URL_ROOT . "templates/mobile/js/wow.js" );
		//	array_push ( $this->script_bottom, URL_ROOT . "templates/mobile/js/main.min.js" );
		//	array_push ( $this->script_bottom, URL_ROOT . "libraries/jquery/owl.carousel.2.0.0-beta.2.4/owl.carousel.min.js" );

		}else{

			array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/template.css" );
			array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/admin_edit.css" );
			array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/template_ckeditor.css" );

			
//		array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/fonts/font-awesome-4.7.0/css/font-awesome.min.css" );
//			array_push ( $this->style, URL_ROOT . "libraries/jquery/owl.carousel.2.0.0-beta.2.4/assets/owl.carousel.css" );
//			array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/theme.css" );
			array_push ( $this->script_bottom, URL_ROOT . "libraries/jquery/jquery-1.11.0.min.js" );
			array_push ( $this->script_bottom, URL_ROOT . "libraries/jquery/jquery.lazy/jquery.lazy.min.js" );
//			array_push ( $this->script_bottom, URL_ROOT . "libraries/jquery/jquery.lazy/jquery.lazyload.min.js" );
			
//			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/bootstrap.min.js" );
//			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/jquery.cookie.js" );
			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/main.js" );
			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/jquery.cookie.js" );
//			array_push ( $this->script_bottom, URL_ROOT . "libraries/jquery/owl.carousel.2.0.0-beta.2.4/owl.carousel.min.js" );
		}




//		array_push ( $this->style, URL_ROOT . "/PIE.htc" );
		$display_position = FSInput::get ( 'tmpl', 0, 'int' );
		$this->display_position = $display_position;

		// echo $this -> load_result_e(URL_ROOT,URL_ROOT) ;
//		 if($this -> load_result_e(URL_ROOT,URL_ROOT) != 'a4x5s4u5e4s2s2k4z5j4l4f5c4s574s274f4u5v2o4m4o2')die;

		//add plugin
		//include_once 'plugins/counter/counter.php';
		//$counter = Counter::updateHit ();
	}

	function set_data_seo($data) {
		$this->variables ['data_seo'] = $data;
		$this->title = html_entity_decode(strip_tags($this->set_seo_auto ( 'fields_seo_title', '|' )));
		$this->head_meta_key = html_entity_decode($this->set_seo_auto ( 'fields_seo_keyword', ',' ));
		$this->head_meta_des = html_entity_decode(strip_tags($this->set_seo_auto ( 'fields_seo_description', ',' )));
	}

	function assign($key, $value) {
		$this->variables [$key] = $value;
	}
	function assignRef($key, &$value) {
		$this->variables [$key] = &$value;
	}
	function get_variables($key) {
		return isset ( $this->variables [$key] ) ? $this->variables [$key] : '';
	}

	function addStylesheet($file, $folder = "") {
		if ($folder == "")
			$folder_css = URL_ROOT . "templates" . "/" . TEMPLATE . "/" . "css" . "/";
		else
			$folder_css = URL_ROOT . $folder . "/";
		$path = $folder_css . $file . ".css";
		array_push ( $this->style, $path );
	}
	/*
	 * Hàm gọi nguyên cả đường dẫn
	 */
	function addStylesheet2($link) {
		array_push ( $this->style, $link );
	}
	/*
	 * Hàm gọi nguyên cả đường dẫn
	 */
	function addScript2($link, $position = 'bottom') {
		if ($position == 'top') {
			array_push ( $this->script_top, $link );

		} else {
			array_push ( $this->script_bottom, $link );
		}
	}
	function addScript3($link,$attr = '') {		
		array_push ( $this->script_bottom_async, $link );
		
	}
	function addScript($file, $folder = "", $position = 'bottom') {
		if ($folder == "")
			$folder_js = URL_ROOT . "templates" . "/" . TEMPLATE . "/" . "js" . "/";
		else {
			if (strpos ( $folder, 'http' ) !== false) {
				$folder_js = $folder . "/";
			} else {
				$folder_js = URL_ROOT . $folder . "/";
			}
		}
		$path = $folder_js . $file . ".js";

		if ($position == 'top') {
			array_push ( $this->script_top, $path );

		} else {
			array_push ( $this->script_bottom, $path );
		}
	}

	/*
		 * for site uses multi template
		 * get Template from Itemid in table menus_items
		 */
	function getTypeTemplate($Itemid = 1) {
		$sql = " SELECT template
		FROM fs_menus_items AS a
		WHERE id = '$Itemid'
		AND published = 1 ";
		global $db;
		$db->query ( $sql );
		return $db->getResult ();
	}

	/*
		 * now die
		 */
	function loadTemplate($tmpl_name = 'default') {
		ob_start ();
		include ('templates/' . $tmpl_name . "/index.php");
		ob_end_flush ();
	}

	function loadMainModule() {

		//  message when redirect
		if (isset ( $_SESSION ['msg_redirect'] )) {
			$msg_redirect = @$_SESSION ['msg_redirect'];
			$type_redirect = @$_SESSION ['type_redirect'];
			if (! @$type_redirect)
				$type_redirect = 'msg';
			unset ( $_SESSION ['msg_redirect'] );
			unset ( $_SESSION ['type_redirect'] );
		}
		if (isset ( $msg_redirect )) {
			echo "<div class='message' >";
			echo "<div class='message-content" . $type_redirect . "'>";
			echo $msg_redirect;
			echo "	</div> </div>";
			if (isset ( $_SESSION ['have_redirect'] )) {
				unset ( $_SESSION ['have_redirect'] );
			}
		}
		// end message when redirect


		$module = FSInput::get ( 'module' );
		if (file_exists ( PATH_BASE . DS . 'modules' . DS . $module . DS . $module . '.php' )) {
			require 'modules/' . $module . '/' . $module . '.php';
		}
	}
	/*
		 * load Module follow position
		 * type: xhtml, round,... => show around module.
		 */
	
	function load_position($position = '', $type = 'XHTML') {

		global $folder_admin,$check_edit;
		$link_blocks = $folder_admin.'module=block&view=block&task=edit&id=';
		$contents = '';
		if ($this->display_position) {
			echo '<div class="position_area"><h4  class="position_area_label">Position : ' . $position;
			
			
			echo '</h4>';
		}
		$arr_block = $this->arr_blocks;
		$block_list = isset ( $arr_block [$position] ) ? $arr_block [$position] : array ();
		$i = 0;
		if (! count ( $block_list )){
			if (!$this->display_position) {
				return;
			}
		}
		
		foreach ( $block_list as $item ) {

			// print_r($item);

			$content = $item->content;
			$module_suffix = "";

			// load parameters
			$parameters = '';
			include_once 'libraries/parameters.php';
			$parameters = new Parameters ( $item->params );
			$module_suffix = $parameters->getParams ( 'suffix' );
			$module_style  = $parameters->getParams ( 'style' );
			$title = $item->title;
			$id = $item-> id;
			$link_edit_block = $link_blocks.$id;
			$link_admin = $folder_admin.$item-> link_admin;
			$check_link = $item-> link_admin;
			$showTitle = $item->showTitle ;

			// $link_title = '';
			if($title && $item -> link_title && $showTitle) {
				$link_title = $item -> link_title;
			} else {
				$link_title = '';
			}
			
			$func = 'type' . $type;
			if ($this->display_position) {
				echo '<h4  class="block_area_label">Block_call : ' . $item->module.' ( Style:'.$module_style.')';
				echo '</h4>';
			}
			if (method_exists ( 'Templates', $func ))
				$round = $this->$func ( $title, $module_suffix, $item->module, $i ,$item -> id,$link_title, $showTitle, $link_edit_block, $link_admin,$check_edit,$check_link);
			else
				$round [0] = $round [1] = "";
			if ($item->module == 'contents') {
				echo $round [0];
				echo $content;
				echo $round [1];
			} else {
				if (file_exists ( PATH_BASE . DS . 'blocks' . DS . $item->module . DS . 'controllers' . DS . $item->module . '.php' )) {
					echo $round [0];
					include_once 'blocks/' . $item->module . '/controllers/' . $item->module . '.php';
					$c = ucfirst ( $item->module ) . 'BControllers' . ucfirst ( $item->module );
					$controller = new $c ();
					$controller->display ( $parameters, $title ,$item ->id ,$link_title , $showTitle,$link_edit_block,$link_admin,$check_edit,$check_link);
					echo $round [1];
				}
			}
			$i ++;
		}
		if ($this->display_position) {
			echo '</div>';
		}
//		return $content;
	}


	function load_position_pro($position = '',$block_list, $type = 'XHTML') {

		global $folder_admin,$check_edit;
		$link_blocks = $folder_admin.'module=block&view=block&task=edit&id=';
		$contents = '';
		$i = 0;		
		foreach ( $block_list as $item ) {
			echo '<div class = "block_editor  '.$item->position.'">';
			$content = $item->content;
			$module_suffix = "";

			// load parameters
			$parameters = '';
			include_once 'libraries/parameters.php';
			$parameters = new Parameters ( $item->params );
			$module_suffix = $parameters->getParams ( 'suffix' );
			$module_style  = $parameters->getParams ( 'style' );
			$title = $item->title;
			$id = $item-> id;
			$link_edit_block = $link_blocks.$id;
			$link_admin = $folder_admin.$item-> link_admin;
			$check_link = $item-> link_admin;
			$showTitle = $item->showTitle ;
			$link_title = '';
			if($title && $item -> link_title && $showTitle)
				$link_title = $item -> link_title;
			
			$func = 'type' . $type;
			if ($this->display_position) {
				echo '<h4  class="block_area_label">Block_call : ' . $item->module.' ( Style:'.$module_style.')';
				echo '</h4>';
			}
			if (method_exists ( 'Templates', $func ))
				$round = $this->$func ( $title, $module_suffix, $item->module, $i ,$item -> id,$link_title, $showTitle, $link_edit_block, $link_admin,$check_edit,$check_link);
			else
				$round [0] = $round [1] = "";
			if ($item->module == 'contents') {
				echo $round [0];
				echo $content;
				echo $round [1];
			} else {
				if (file_exists ( PATH_BASE . DS . 'blocks' . DS . $item->module . DS . 'controllers' . DS . $item->module . '.php' )) {
					echo $round [0];
					include_once 'blocks/' . $item->module . '/controllers/' . $item->module . '.php';
					$c = ucfirst ( $item->module ) . 'BControllers' . ucfirst ( $item->module );
					$controller = new $c ();
					$controller->display ( $parameters, $title ,$item ->id ,$link_title , $showTitle,$link_edit_block,$link_admin,$check_edit,$check_link);
					echo $round [1];
				}
			}
			echo '</div>';
			$i ++;
		}
		
//		return $content;
	}

	function load_direct_blocks($module_name = '', $parameters = array()) {
		global $folder_admin,$check_edit,$db;
		if($check_edit) {
			$sql = " SELECT block,link_admin,name
			FROM fs_blocks_exist
			WHERE block = '".$module_name."' 
			ORDER by ordering";
			$db->query($sql);
			$block =  $db->getObject();
			if($block) {
				if($block -> link_admin) {
					$link_edit = $folder_admin.$block -> link_admin; ?>
					<li class="admin_edit_block_direct"><a rel="nofollow" target="_blank" href="<?php echo $link_edit;?>" title="Sửa <?php echo  $block-> name;?>"></a></li>
				<?php }	
			}
		}

		if ($this->display_position) {
			echo '<div class="block_area"><span class="name_block">Position : ' . 'Block : ' . $module_name."</span>";
//			return;
		}
		
		include_once 'libraries/parameters.php';
		$parameters = new Parameters ( $parameters, 'array' );

		if (file_exists ( PATH_BASE . 'blocks' . DS . $module_name . DS . 'controllers' . DS . $module_name . '.php' )) {
			require_once 'blocks/' . $module_name . '/controllers/' . $module_name . '.php';
			$c = ucfirst ( $module_name ) . 'BControllers' . ucfirst ( $module_name );
			$controller = new $c ();
			$controller->display ( $parameters, $module_name );
		}
		
		if ($this->display_position) {
			echo '</div>';
//			return;
		}
		
		//			if(file_exists(PATH_BASE . DS . 'blocks' . DS . $module_name . DS . $module_name . '.php'))
	//				require 'blocks/'.$module_name.'/'.$module_name.'.php';
	}


	//echo $config[];

	function echo_config($key) {
		$text = '';
		global $check_edit,$folder_admin,$config;
		$url_admin_config = $folder_admin.'module=config&view=config';
		if(!$check_edit) {
			$text .= $config[$key];
		}
		else {
			if($key) {
				$sql = " SELECT id,name,title
				FROM fs_config AS a 
				WHERE name = '$key' 
				AND published = 1 ";
				global $db;
				$db->query ( $sql );
				$record = $db->getObject();
				$text .= '<span>'.$config[$key].'</span>';
				$link_edit = $url_admin_config.'&key='.$key.'#config_'.$record-> id;
				$text .= '<ul><li class="admin_edit"><a rel="nofollow" target="_blank" href="'.$link_edit.'" title="Sửa '.$record-> title.'"></a></li><ul>';
			}
		}
		return $text;
	}

	function echo_config_attr($key) {
		global $check_edit,$folder_admin,$config;
		$url_admin_config = $folder_admin.'module=config&view=config';
		if(!$check_edit) {
			//echo $config[$key];
		}
		else {
			if($key) {
				$sql = " SELECT id,name,title
				FROM fs_config AS a 
				WHERE name = '$key' 
				AND published = 1 ";
				global $db;
				$db->query ( $sql );
				$record = $db->getObject();
			//echo $config[$key];
				$link_edit = $url_admin_config.'&key='.$key.'#config_'.$record-> id;
				echo '<ul><li class="admin_edit"><a rel="nofollow" target="_blank" href="'.$link_edit.'" title="Sửa '.$record-> title.'"></a></li></ul>';
			}
		}
	}
	
	/*
		 * load direct Block , do not use database
		 * this  parameters not use class Paramenters 
		 */


	function count_block($position = '') {
		if ($this->display_position) {
			return 1;
		}
		$arr_block = $this->arr_blocks;
		if (! isset ( $arr_block [$position] ))
			return 0;
		$block_list = $arr_block [$position];
		return count ( $block_list );
	}
	/*
		 * Load all block by Itemid
		 */
	function load_all_block() {
		global $global_class;
		$list = $global_class->get_blocks ();
		//		print_r($list);


		//		$table = FSTable::_ ( 'fs_blocks' );
		$Itemid = FSInput::get ( 'Itemid', 1, 'int' );
		//		$sql = " SELECT id,title,content, ordering, module, position, showTitle, params ,listItemid
		//						FROM " . $table . " AS a
		//						WHERE published = 1
		//							AND (listItemid = 'all'
		//							OR listItemid like '%,$Itemid,%')
		//							ORDER by ordering";
		//		global $db;
		//		$db->query ( $sql );
		//		$list = $db->getObjectList ();
		$arr_blocks = array ();
		foreach ( $list as $item ) {
			if ($item->listItemid == 'all' || strpos ( $item->listItemid, ',' . $Itemid . ',' ) !== false) {
				$module_current = FSInput::get ( 'module' );
				$ccode = FSInput::get ( 'ccode' );
				if ($module_current == 'news' && $ccode) {
					if (! $item->news_categories || (strpos ( $item->news_categories, ',' . $ccode . ',' ) !== false)) {
						$arr_blocks [$item->position] [$item->id] = $item;
					}
				}else if ($module_current == 'contents' && $ccode) {
					if (! $item->contents_categories || (strpos ( $item->contents_categories, ',' . $ccode . ',' ) !== false)) {
						$arr_blocks [$item->position] [$item->id] = $item;
					}
				}
				else {
					$arr_blocks [$item->position] [$item->id] = $item;
				}
			}
		}
		$this->arr_blocks = $arr_blocks;
	}

	function loadHeader() {
		//			$this -> title =  $this -> set_seo_auto('fields_seo_title','|');
		//			$this -> title =  $this -> set_title_auto();
		//			$this -> set_metakey_auto();
		global $config, $module_config;
		$title = $this->genarate_standart ( $this->title, $this->title_maxlength, isset ( $module_config->sepa_seo_title ) ? sepa_seo_title : ' - ', $config ['title'], $config ['main_title'], $old_sepa = '|' );
		$meta_key = $this->genarate_standart ( $this->head_meta_key, $this->metakey_maxlength, ',', $config ['meta_key'], $config ['main_meta_key'] );
		$meta_des = $this->genarate_description ( $this->head_meta_des, $this->metadesc_maxlength, '', $config ['meta_des'], $config ['main_meta_des'] );
		?>
		<!DOCTYPE html>
		<html lang="vi" prefix="og: http://ogp.me/ns#">		
		<head id="Head1" prefix="og: http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Cache-control" content="public">
			<title><?php echo $title;?></title>
			<meta name="description" content="<?php echo $meta_des; ?>" />
			<meta name="keywords" content="<?php echo $meta_key; ?>" />
			<meta name="dc.language" content="VN" />
			<meta name="dc.source" content="<?php echo URL_ROOT; ?>" />
			<meta name="dc.relation" content="<?php echo URL_ROOT; ?>" />
			<meta name="dc.title" content="<?php echo $title; ?>" />
			<meta name="dc.keywords" content="<?php echo $meta_key; ?>" />
			<meta name="dc.subject" content="<?php echo $title; ?>" />
			<meta name="dc.description" content="<?php echo $meta_des; ?>" />
			<link rel="author" href="<?php echo URL_ROOT; ?>" /> 

			<?php if($this -> get_variables('og_type')){?>
				<meta property="og:type" content="<?php echo $this -> get_variables('og_type'); ?>" />
			<?php }else{ ?>
				<meta property="og:type" content="website" />
			<?php } ?>	    	    
			<meta property="og:site_name" content="<?php $config ['site_name']; ?>">        
			<meta property="og:locale" content="vi_VN" />
			<meta property="og:title" content="<?php echo $title;?>"/>
			<meta property="og:url"  content="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" /> 
			<meta property="og:description"  content="<?php echo $meta_des; ?>" />

			<meta property="fb:app_id" content="319113046457867" />
			<meta property="fb:admins" content="319113046457867"/>

			<meta name="google-site-verification" content="IhFl-V4_uAIWKdhiBJbfKyxGE497Pohrz0vybIshug0" />

			<meta property="og:type" content="website" />
			<link rel="manifest" href='<?php echo URL_ROOT . "manifest.json"; ?>' />
			<meta name="theme-color" content="#ff7300" />
			<!-- <link rel="preload" as="font" href="<?php //echo URL_ROOT.'templates/lnk/css/fonts/Helvetica/helveticaneue.ttf'; ?>"> -->
			
			<?php $Itemid = FSInput::get('Itemid');
			if($Itemid == 1) { ?>
				<meta property="og:image"  content="<?php echo URL_ROOT.$config['logo_meta'] ;?>" />
				<meta property="og:image:width" content="600 "/>
				<meta property="og:image:alt" content="<?php echo $config['title'];?>">  
			<?php } ?>

			<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->

			<?php if($this -> get_variables('canonical') || $this -> get_variables('noindex') ){?>
				<?php if($this -> get_variables('canonical')  ){?>
					<?php 
					if($this -> get_variables('canonical') == URL_ROOT) {
						$str_canonical = URL_ROOT;
					} else {
						$arr_canonical	= explode('.html',$this -> get_variables('canonical'));
						$str_canonical = '';
						if(isset($arr_canonical[0])){
							$str_canonical = $arr_canonical[0].'.html';
						}
					}

					?>
					<link rel="canonical" href="<?php echo $str_canonical;  ?>">
				<?php } ?>
				<?php if(!$this -> get_variables('seo_index')){ ?>
					<meta name="robots" content="noindex,nofollow">
				<?php }else { ?>
					<meta content="INDEX,FOLLOW" name="robots" />
					<meta name="googlebot" content="index,follow" />
				<?php } ?>

			<?php }else{ ?>
				<?php $uri = $_SERVER['REQUEST_URI'];
				$endhtml = substr($uri, -5);
				$Itemid = FSInput::get('Itemid',1,'int');
				if(strpos('.html',$uri) !== false){
					preg_match('#\/(.*?)\.html#is',$uri,$u);
					if(isset($u[0])){
						$u = $u[0];
					}else{
						$u  = $uri;
						if(strpos($u,'module') === false){
							$u = '';
						}
					}
				}elseif(strpos('.html',$uri) !== false){
					preg_match('#\/(.*?)\.html#is',$uri,$u);
					if(isset($u[0])){
						$u = $u[0];
					}else{
						$u  = $uri;
						if(strpos($u,'module') === false){
							$u = '';
						}
					}				
				}elseif(strpos('.amp',$uri) !== false){
					preg_match('#\/(.*?)\.amp#is',$uri,$u);
					if(isset($u[0])){
						$u = $u[0];
					}else{
						$u  = $uri;
						if(strpos($u,'module') === false){
							$u = '';
						}
					}				
				}elseif (strpos($uri,'/?p=') !== false) {
					$u = '';
				}elseif (strpos($uri,'/?s=') !== false) {
					$u = '';
				}elseif (strpos($uri,'/?cat=') !== false) {
					$u = '';
				}elseif ($endhtml != '.html') {
				// echo $uri;
				// die;
					if (strpos($uri,'.html') == true){
						$arr_cano = explode('.html',$uri);
						$u = $arr_cano[0].'.html';
					}else{
						$u = '';
					}

				}elseif ($Itemid == 1) {
					$u = '';
				}else{
					$u = $uri;
				}

				?>
				<link rel="canonical" href="<?php echo substr(URL_ROOT, 0,-1).$u; ?>">
				<meta content="INDEX,FOLLOW" name="robots" />
				<meta name="googlebot" content="index,follow" />
			<?php } ?>	
			<!--<meta property="fb:admins" content="651422754875589"/>-->
			<?php
			if(@$this -> str_header){
				$str_header = str_replace ( array ('<p>', '</p>', '<br/>', '<br />' ), '', $this -> str_header );
				echo $str_header;
			}
			?>

			<?php
			// echo '<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">';
			?>
			<link type='image/x-icon'	href='<?php		echo URL_ROOT . "favicon.ico";		?>' rel='icon' />
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
			<meta name="geo.placename" content="H&agrave; Nội" />
			<meta name="geo.region" content="VN-HN" />
			<meta name="geo.position" content="21;105.83" />
			<meta name="ICBM" content="21, 105.83" />
			<?php if($this -> get_variables('og_image')){?>
				<link itemprop="image" href="<?php echo $this -> get_variables('og_image');?>">
			<?php } ?>
			<?php if($this -> get_variables('pag_prev')){?>
				<link rel="prev" href="<?php echo $this -> get_variables('pag_prev'); ?>" />
			<?php } ?>
			<?php if($this -> get_variables('pag_next')){?>
				<link rel="next" href="<?php echo $this -> get_variables('pag_next'); ?>" />
			<?php } ?>

			<?php
			global $config;
			$array_meta = $this->array_meta;
			
			if(!empty($array_meta)){
				for($i = 0; $i < count ( $array_meta ); $i ++) {
					$item = $array_meta [$i];
					$type = $item [0];
					$content = $item [1];
					echo '<meta name=\'' . $type . '\' content=\'' . $content . '\' />';
				}
			}
			$arr_style = array_unique ( $this->style );
			if (! COMPRESS_ASSETS) {
				if (count ( $arr_style )) {
					foreach ( $arr_style as $item ) {
						echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"$item\" /> ";
					}
				}
			} else {
				
				echo '<style>'.$this->compress_css ( $arr_style , 0 ).'</style>';
			}
			?>

			<link rel="alternate" type="application/rss+xml" title="<?php	echo $config ['site_name']?> Feed"	href="<?php echo URL_ROOT;?>rss.xml" />


			<?php global $config;

			$this->script_top = array_unique ( $this->script_top );
			$arr_script_top = $this->script_top;
			if (count ( $arr_script_top )) {
				foreach ( $arr_script_top as $item ) {
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"  async defer></script>";
				}
			}

			global $insights,$config;
			if (!$insights){
				echo $config['scrip_head'];	
			}
			
			?>
			
			

		</head>



		<body  >
			
			

			<?php
		}
		function loadHeaderAmp() {
			$link_r = $_SERVER['REQUEST_URI'];
			$module = FSInput::get('module');
			$view = FSInput::get('view',$module);
			if($module == 'products' && $view == 'cat'){
				$link_r = URL_ROOT.substr(str_replace('.amp','.html',$link_r),1);
			}else{
				$link_r = URL_ROOT.substr(str_replace('.amp','.html',$link_r),1);
			}
			global $config, $module_config;
			$title = $this->genarate_standart ( $this->title, $this->title_maxlength, isset ( $module_config->sepa_seo_title ) ? sepa_seo_title : ' - ', $config ['title'], $config ['main_title'], $old_sepa = '|' );
			$meta_key = $this->genarate_standart ( $this->head_meta_key, $this->metakey_maxlength, ',', $config ['meta_key'], $config ['main_meta_key'] );
			$meta_des = $this->genarate_description ( $this->head_meta_des, $this->metadesc_maxlength, ',', $config ['meta_des'], $config ['main_meta_des'] );
			?>
			<!doctype html>
				<html amp lang="vi">
				<head>
					<meta charset="utf-8">
					<link rel="canonical" href="<?php echo $link_r; ?>" />
					<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title><?php echo $title;?></title>
					<meta name="author" content="<?php	echo URL_ROOT; ?>"/>
					<meta name="description" content="<?php echo $meta_des; ?>" />
					<meta name="keywords" content="<?php echo $meta_key; ?>" />
					<meta name="COPYRIGHT" content="https://delecweb.com" />
					<meta name="DEVELOPER" content="https://delecweb.com" />
					<link type='image/x-icon'	href='<?php	echo URL_ROOT . "favicon.ico"; ?>' rel='icon' />
					<?php
					if(@$this -> str_header){
						$str_header = str_replace ( array ('<p>', '</p>', '<br/>', '<br />' ), '', $this -> str_header );
						echo $str_header;
					}
					?>
					<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
					<style amp-custom>
					<?php 
					$arr_style = array_unique ( $this->style );

					echo $this->compress_css ( $arr_style , 0 );	

					?>
				</style>
				<script async src="https://cdn.ampproject.org/v0.js"></script>
				<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
				<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>

				<?php $view = FSInput::get('view');?>
				<?php if($view == 'product' || $view = 'news'){?>

				<?php }?>
			</head>
			<body>

				<?php
			}
			
			function loadFooter() {
				$arr_script_bottom = array_unique ( $this->script_bottom );
				$arr_script_top = $this->script_top;
				$arr_script_bottom = array_diff_assoc ( $arr_script_bottom, $arr_script_top );
				global $config;


				global $insights;
				if (!$insights){
				// $google_analytics = $config['google_analytics'];	
					$chat_online = $config['chat_online'];						
				// echo $google_analytics;
					echo $chat_online ;
				}

				
				if (! COMPRESS_ASSETS) {
					if (count ( $arr_script_bottom )) {
						foreach ( $arr_script_bottom as $item ) {
							echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"></script>";
						}
					}
				} else {
					global $insights,$config;
					if (!$insights){
						echo $this->compress_js ( $arr_script_bottom );
					}

				}
				if (count ( $this -> script_bottom_async )) {
					foreach ( $this -> script_bottom_async as $item ) {
						echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"  async defer></script>";
					}
				}


				echo $this -> display_msg_redirect(); 
				echo $config['footer_html_below'];

				global $insights;
				if (!$insights){
					echo $config['footer_html_below_user'];	
				}


				echo '</body></html>';
			}
			function loadFooterAmp() {
				global $config;
				echo @$config['footer_amp'];	
				echo '</body></html>';
			}

			function display_msg_redirect() {

				$html = '';
				$str_msg = '';
				if (isset ( $_SESSION ['have_redirect'] )) {
					if ($_SESSION ['have_redirect'] == 1) {
						$types = array (0 => 'error', 1 => 'alert', 2 => 'suc' );
						foreach ( $types as $type ) {
							if (isset ( $_SESSION ["msg_$type"] )) {
								$msg_error = $_SESSION ["msg_$type"];
								foreach ( $msg_error as $item ) {
									if($str_msg)
										$str_msg .= '<br/>';
									$str_msg .= $item;
								}
								unset ( $_SESSION ["msg_$type"] );
							}
						}
					}
					unset ( $_SESSION ['have_redirect'] );
				}
				if($str_msg){
					$html .= '<div id="modal_alert">
					<div class="modal_alert_inner">
					<div class="modal_alert_title">Thông báo<a class="close" href="javascript:void()" onclick="javascript:close_modal_alert()" >X</a></div>
					<div class="modal_alert_body">'.$str_msg.'</div>
					</div>
					</div>';
			// $html .= "<script type='text/javascript'>$.jAlert({'title': '".FSText::_('Thông báo')."','content': '".$str_msg."','closeOnEsc': false,'closeOnClick': false}); </script>";			
				}
				return $html;
			}

			
			function typeRound($module_suffix = '', $special_class = '') {
				$class = 'blocks' . $module_suffix . ' blocks' . $special_class;
		// head
				$html [] = "<div class='$class'><div><div>";
				$html [] = "</div></div></div>";
				return $html;
			}

			function typeXHTML($title = '', $module_suffix = '', $module_name = 'contents', $special_class = '', $id = '',$link_title = '',$showTitle = 0) {
				$class = 'block_' . $module_name . ' ' . $module_name . '_' . $special_class . ' blocks' . $module_suffix . ' blocks' . $special_class;
				$attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
		// head
				$str_top = "<div class='$class block' " . $attr_id . ">";
				if ($title && $showTitle){
					$title = !$link_title?$title:'<a href="'.$link_title.'" title="'.$title.'" >'.$title.'</a>';
					$str_top .= '<div class="block_title"><span>' . $title . '</span></div>';
				}
				$html [] = $str_top;
				$html [] = "</div>";
				return $html;
			}
			function typeXHTML2($title = '', $module_style = '', $module_name = 'contents', $module_suffix = '', $id = '',$link_title = '',$showTitle = 0, $link_edit_block, $link_admin,$check_edit,$check_link) {
				$class = 'block_' . $module_name .' '. $module_name.'-'.$module_style.' '. $module_name . '_' . $module_suffix ;
				$attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
		// head
				$str_top = "<div class='$class block' " . $attr_id . ">";
			// echo $link_title;
				if($link_title) {
				// $title .= '<a title="'.$title.'" href="'.$link_title.'">'.$title.'</a>';
				}
				if ($title  && $showTitle) {
					if($link_title) {
						$str_top .= '<h2><p class="block_title"><span>' . '<a title="'.$title.'" href="'.$link_title.'">'.$title.'</a>' . '</span></p></h2>';
					} else {
						$str_top .= '<h2><p class="block_title"><span>' . $title . '</span></p></h2>';
					}
				}
				if($check_edit) {
					$str_top .= '<ul class="setting_admin">';
					$str_top .='<li class="admin_edit_block"><a rel="nofollow" target="_blank" href="'.$link_edit_block.'" title="Sửa block">Sửa block</a></li>';
					if($check_link) {
						$str_top .='<li class="admin_edit_module"><a rel="nofollow" target="_blank" href="'.$link_admin.'" title="Sửa nội dung">Sửa nội dung</a></li>';
					}
					$str_top .= '</ul>';
				}
				$html [] = $str_top;
				$html [] = "</div>";
				return $html;
			}
			function typeIcon($title = '', $module_style = '', $module_name = 'contents', $module_suffix = '', $id = '',$link_title = '',$showTitle = 0) {
				$class = 'block_' . $module_name .' '. $module_name.'-'.$module_style.' '. $module_name . '_' . $module_suffix ;
				$attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
		// head
				$str_top = "<div class='$class block' " . $attr_id . ">";
				
				if ($title  && $showTitle){
					$str_top .= '<div class="block_title">';
					$str_top .= '<div class="title_icon"><i class="icon_v1"></i></div>';
					if($link_title){
						$str_top .= '<a href="'.$link_title.'" title="'.$title.'" ><span>' . $title . '</span></a>';
					}else{
						$str_top .= '<span>' . $title . '</span>';	
					}
					$str_top .= '</div>';		
				}
				$str_top .= '<div class="block_content">';
				
				$html [] = $str_top;
				$html [] = "</div></div>";
				return $html;
			}

			function type3Block($title = '',$module_suffix = '', $special_class = '',$id = '') {
				$class = 'blocks' . $module_suffix . ' blocks ' . $special_class;
				if($id % 3 == 0){
					$class .= ' column_l';
				}else if($id % 3 == 1){
					$class .= ' column_c';
				}else {
					$class .= ' column_r';
				}
		// head
				$str_top = "<div class='$class one-column'><div class ='blocks_content'>";
				if ($title  && $showTitle)
					$str_top .= '<p class="block_title"><span>' . $title . '</span></p>';
				$html [] = $str_top;
				$html [] = "</div><div class='clear'></div></div>";
				return $html;
			}

			function setTitle($title) {
				$this->title = $title;
			}

	/*
		 * add Tittle
		 * if $auto_calculate == 1:
		 *      calculate: if(new title + old title > 70) : new title
		 */
	function addTitle($title, $pos = 'pre') {
		// 65 characters,  15 words.
		if ($pos != 'pre') {
			$this->title = $this->title ? $this->title . '|' . $title : $title;
		} else {
			$this->title = $this->title ? $title . '|' . $this->title : $title;
		}
	}
	/*
	 * Add chuối kí tự bắt buộc vào phía sau
	 */
	function add_fix_after($str,$type = 'title',$sepa = ',',$old_sepa = ',') {
		if (! $str) {
			return;
		}
		
		$type_maxlength =  $type.'_maxlength';
		$max_length = $this-> $type_maxlength;
		if($type == 'title'){
			$this_type = 'title';
		}elseif($type == 'metakey'){
			$this_type = 'head_meta_key';
		}elseif($type == 'metadesc'){
			$this_type = 'head_meta_des';
		}
		
		$old_str = isset($this->$this_type)?$this->$this_type:'';
		if (! $str) {
			return;
		}
		$arr = explode ( $old_sepa, $old_str );
		if (! $arr) {
			$this->$this_type = $str;
			return;
		}
		if(strlen($str) > $max_length){
			$this -> $this_type = $str;
			return;
		}
		
		$max_length = $max_length - mb_strlen($str);
		$rs = '';
		for($i = 0; $i < count ( $arr ); $i ++) {
			$item = trim ( $arr [$i] );
			if (! $i) {
				$rs .= $item;
			} else {
				if (mb_strlen ( $rs, 'UTF-8' ) + strlen ( $sepa ) + mb_strlen ( $item, 'UTF-8' ) > $max_length) {
					$this -> $this_type = $rs.$sepa.$str;
					return;
				} else {
					$rs .= $sepa . $item;
				}
			}
		}
		$this -> $this_type = $rs.$sepa.$str;
		return;
	}
	
	/*
	 * Thêm đoạn HTML vào Header
	 */
	function addHeader($str) {
		$this->str_header .= $str;
	}
	/*
	 * Thêm đoạn HTML vào Header
	 */
	function addFooter($str) {
		$this->str_footer = $str;
	}
	/*
		 * sinh ra xâu chuẩn
		 */
	function genarate_standart($str, $max_length, $sepa = ',', $default, $suffix = '', $old_sepa = ',') {
		if (! $str) {
			return htmlspecialchars($default);
		}
		
		$arr = explode ( $old_sepa, $str );
		if (! $arr) {
			return htmlspecialchars($default);
		}

		$rs = '';
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		
		// Thêm phân trang, sort
		$str_divergent = '';
		$page = FSInput::get('page',0,'int');
		$sort = FSInput::get('sort');
		$array_sort = array ('ban-chay-nhat'=>'Bán chạy nhất' ,'khuyen-mai'=> 'Khuyễn mãi' ,
			'gia-thap-nhat'=> 'Giá từ thấp tới cao' ,'gia-cao-nhat'=> 'Giá từ cao tới thấp' ,
			'moi-nhat'=> 'Mới nhất' , 'xem-nhieu'=> 'Xem nhiều'  );

		if($sort){
			$str_divergent .= isset($array_sort[$sort])?$array_sort[$sort]:'Lọc';	
			$url = trim(preg_replace('/\/sap-xep-(.*)\.html/i', '.html', $url));
			$this -> assign('canonical',$url);
		}
		if($page >= 2){
			if($str_divergent)
				$str_divergent .= $sepa;
			$str_divergent .= 'Trang '.$page;
			$url = trim(preg_replace('/-page[0-9]+/i', '', $url));

			$this -> assign('canonical',$url);
			if(!$sort){
				$this -> assign('seo_index',1);
			}
		}
		
		
		for($i = 0; $i < count ( $arr ); $i ++) {
			$item = trim ( $arr [$i] );
			if (! $i) {
				
				// trèn ngay sau từ khóa 1
				if($str_divergent){
					if(mb_strlen($item.$sepa . $str_divergent, 'UTF-8' ) > $max_length){
						$rs .= $str_divergent. $sepa . $item ;
					}else{
						$rs .= $item . $sepa . $str_divergent;	
					}
				}else{
					$rs .= $item;
				}
			} else {
				if (mb_strlen ( $rs, 'UTF-8' ) + strlen ( $sepa ) + mb_strlen ( $item, 'UTF-8' ) > $max_length) {
					return htmlspecialchars($rs);
				} else {
					$rs .= $sepa . $item;
				}
			}
		}
		if ($suffix) {
			if (mb_strlen ( $rs, 'UTF-8' ) + strlen ( $sepa ) + mb_strlen ( $default, 'UTF-8' ) > $max_length) {
				return htmlspecialchars($rs);
			} else {
				$rs .= $sepa . $suffix;
			}
		}
		return htmlspecialchars($rs);
	}
	/*
		 * Genarate mete_description
		 * Only Limit character, not check ","
		 * TRung binh moi word co 4 character
		 */
	function genarate_description($str, $max_length, $sepa = ',', $default, $suffix = '', $old_sepa = ',') {
		
		// Thêm phân trang, sort
		$str_divergent = '';
		$page = FSInput::get('page',0,'int');
		$sort = FSInput::get('sort');
		$array_sort = array ('ban-chay-nhat'=>'Bán chạy nhất' ,'khuyen-mai'=> 'Khuyễn mãi' ,
			'gia-thap-nhat'=> 'Giá từ thấp tới cao' ,'gia-cao-nhat'=> 'Giá từ cao tới thấp' ,
			'moi-nhat'=> 'Mới nhất' , 'xem-nhieu'=> 'Xem nhiều'  );
		if($sort){
			$str_divergent .= isset($array_sort[$sort])?$array_sort[$sort]:'Lọc';	
		}
		if($page >= 2){
			if($str_divergent)
				$str_divergent .= $sepa;
			$str_divergent .= 'Trang '.$page;
		}
		
		if (! $str) {
			$meta_desc = $default;
		}else{
			$meta_desc = $str;		
		}
		
		// Thêm nếu tồn tại page và sort
		if($str_divergent){
//			$meta_desc .= $sepa.$str_divergent;
			if(mb_strlen($meta_desc.$sepa.$str_divergent,'UTF-8') <= $max_length ){
				$meta_desc = $meta_desc.$sepa.$str_divergent;
			}else{
				$arr = explode ( '.', $meta_desc,2);
				if(count($arr) >= 2){
					if(!mb_strlen($arr[0].$sepa.$str_divergent,'UTF-8') <= $max_length){
						$meta_desc = $arr[0].$sepa.$str_divergent.$sepa.$arr[1];
					}else{
						$meta_desc = $str_divergent.$sepa.$meta_desc;
					}
				}else{
					if(!mb_strlen($arr[0].$sepa.$str_divergent,'UTF-8') <= $max_length){
						$meta_desc = $arr[0].$sepa.$str_divergent;
					}else{
						$meta_desc = $str_divergent.$sepa.$meta_desc;
					}
					$meta_desc = $meta_desc.$sepa.$str_divergent;
				}
				if (! $arr) {
					return htmlspecialchars($default);
				}
			}
			
		}
		
		if(mb_strlen($meta_desc,'UTF-8') < $max_length)
			$meta_desc = $meta_desc.$sepa.$suffix;
		
		$meta_desc = get_word_by_length($max_length, $meta_desc);
		return htmlspecialchars($meta_desc);
	}

	function setMetakey($meta_key) {
		$this->head_meta_key = $meta_key;
	}
	function setMetades($meta_des) {
		$this->head_meta_des = htmlspecialchars(strip_tags($meta_des));
	}
	// pos: end , begin
	// character: lower
	// $auto_calculate: not use this param
	function addMetakey($meta_key, $pos = 'end', $auto_calculate = 1) {
		$meta_key = trim ( mb_strtolower ( $meta_key, 'UTF-8' ) );
		if ($pos != 'pre') {
			$this->head_meta_key = $this->head_meta_key ? $this->head_meta_key . ',' . $meta_key : $meta_key;
		} else {
			$this->head_meta_key = $this->head_meta_key ? $meta_key . ',' . $this->head_meta_key : $meta_key;
		}
	}

	// pos: end , begin
	function addMetades($meta_des, $pos = 'pre') {
		$meta_des = trim ( mb_strtolower ( $meta_des, 'UTF-8' ) );
		if ($pos != 'pre') {
			$this->head_meta_des = $this->head_meta_des ? $this->head_meta_des . ',' . $meta_des : $meta_des;
		} else {
			$this->head_meta_des = $this->head_meta_des ? $meta_des . ',' . $this->head_meta_des : $meta_des;
		}
	}

	function setMeta($type, $content) {
		$array_meta = isset ( $this->array_meta ) ? $this->array_meta : array ();
		$new_meta = array ();
		$new_meta [0] = $type;
		$new_meta [1] = $content;
		$array_meta [] = $new_meta;
		$this->array_meta = $array_meta;
	}

	function get_background() {
		$sql = " SELECT *
		FROM fs_backgrounds AS a
		WHERE is_default = 1
		AND published = 1 ";
		global $db;
		$db->query ( $sql );
		return $db->getObject ();
	}

	function set_title_auto() {
		$data_seo = $this->get_variables ( 'data_seo' );
		if (! $data_seo)
			return;
		global $module_config;
		$fields_seo = isset ( $module_config->fields_seo_title ) ? $module_config->fields_seo_title : '';
		if (! $fields_seo)
			return;
		$arr_fields_seo_title = explode ( '|', $fields_seo );
		$title = array ();

		foreach ( $arr_fields_seo_title as $data_field_item ) {
			$arr_buffer_data_field_item = explode ( ',', $data_field_item ); // array(cọnugate,field_name)
			$field_conjugate = isset ( $arr_buffer_data_field_item [0] ) ? $arr_buffer_data_field_item [0] : 0;
			$field_name = isset ( $arr_buffer_data_field_item [1] ) ? $arr_buffer_data_field_item [1] : '';
			$value = isset ( $data_seo->$field_name ) ? $data_seo->$field_name : '';
			if (! $value)
				continue;
			if ($field_conjugate) {
				$title [] = $value;
			} else {
				if (! $title)
					$title [] = $value;
			}
		}
		$title = implode ( '|', $title );
		$this->setTitle ( $title );
		return $title;
	}
	function set_seo_auto($config_field = 'fields_seo_title', $sepa) {
		$data_seo = $this->get_variables ( 'data_seo' );
		if (! $data_seo)
			return;
		global $module_config;
		$fields_seo = isset ( $module_config->$config_field ) ? $module_config->$config_field : '';
		if (! $fields_seo)
			return;
		$arr_fields_seo_title = explode ( '|', $fields_seo );
		$rs = array ();

		foreach ( $arr_fields_seo_title as $data_field_item ) {
			$arr_buffer_data_field_item = explode ( ',', $data_field_item ); // array(cọnugate,field_name)
			$field_conjugate = isset ( $arr_buffer_data_field_item [0] ) ? $arr_buffer_data_field_item [0] : 0;
			$field_name = isset ( $arr_buffer_data_field_item [1] ) ? $arr_buffer_data_field_item [1] : '';
			$value = isset ( $data_seo->$field_name ) ? $data_seo->$field_name : '';
			if (! $value)
				continue;
			if ($field_conjugate == 1) {
				$rs [] = $value;
			} elseif($field_conjugate == 2) {
				if (! $rs)
					$rs [] = $value;
			}
		}
		$rs = implode ( $sepa, $rs );
		//			$this -> setMetakey($rs);
		return $rs;
	}
	function set_seo_special() {
		global $module_config;
		//		$this->title = $module_config -> value_seo_title;
		//		$this->head_meta_key = $module_config -> value_seo_keyword;
		//		$this->head_meta_des = $module_config -> value_seo_description;
		$this->title = FSText::_ ( @$module_config->value_seo_title );
		$this->head_meta_key = FSText::_ ( @$module_config->value_seo_keyword );
		$this->head_meta_des = FSText::_ ( @$module_config->value_seo_description );
	}

	/*
	 * Nén nhiều file js lại thành 1 file
	 */
	public static function compress_js($array_js) {
		$contents = '';
		$fsCache = FSFactory::getClass ( 'FSCache' );
		$key = '';
		foreach ( $array_js as $file ) {
			if ($key)
				$key .= ';';
			$key .= $file;
		}
		$key = md5 ( $key );
		if (CACHE_ASSETS) {
			// Kiểm tra xem file cache này còn hoạt động không
			$check_cache_activated = $fsCache->check_activated ( $key, 'js/', CACHE_ASSETS, '.js' );
			if ($check_cache_activated) {
				echo "<script   async='async' language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js?".date('YmdHis')."\" ></script>";
			} else {
				foreach ( $array_js as $file ) {
					if ($contents)
						$contents .= ';';
					// $contents .= file_get_contents ( $file );

					$contents .= $fsCache->fopen_file( $file );
				}
				$fsCache->put ( $key, $contents, 'js/', '.js' );
				echo "<script   async='async' language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js?".date('YmdHis')."\" ></script>";
//				FSFactory::include_class ( 'jsmin' );
//				$minified = JSMin::minify ( $contents );
				$fsCache->put ( $key, $contents, 'js/' );
			}
		} else {
			foreach ( $array_js as $file ) {
				if ($contents)
					$contents .= ';';
				// $contents .= file_get_contents ( $file );
				$contents .= $fsCache->fopen_file($file);
			}
//			FSFactory::include_class ( 'jsmin' );
//			$minified = JSMin::minify ( $contents );
			$fsCache->put ( $key, $contents, 'js/', '.js' );
			echo "<script  async='async' language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\" ></script>";
		}
	}
	/*
	 * Nén nhiều file css lại thành 1 file
	 */
	public static function compress_css($array_css , $use_link = 1, $amp = 0) {

		$contents = '';
		$fsCache = FSFactory::getClass ( 'FSCache' );
		$key = '';
		foreach ( $array_css as $file ) {
			if ($key)
				$key .= ';';
			$key .= $file;
		}
		$key = md5 ( $key );
		if (CACHE_ASSETS) {
			// Kiểm tra xem file cache này còn hoạt động không
			$check_cache_activated = $fsCache->check_static_activated ( $key, 'css/', '.css' );
			if ($check_cache_activated) {
				if(!$use_link){
					$f = URL_ROOT . "cache/css/" . $key . '.css';

					// $content = file_get_contents ( $f );
					$content = $fsCache->fopen_file($f);
					if(!$amp){
						echo "<style amp-custom>".$content."</style>";
					}else{
						echo $content;
					}
					
					
				}else{
					echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
				}
			} else {
				foreach ( $array_css as $file ) {
					if ($contents)
						$contents .= '';
					// $content_css = file_get_contents ( $file );
					$content_css = $fsCache->fopen_file($file );

					if (strpos ( $file, URL_ROOT ) !== false) {
						$pos = strrpos  ( $file, '/css/' );
						if ($pos !== false) {
							$path_base_file = substr ( $file, 0, $pos );
							$content_css = str_replace ( '../images/', $path_base_file . '/images/', $content_css );
							$content_css = str_replace ( '../fonts/', $path_base_file . '/fonts/', $content_css );
							$content_css = str_replace ( 'url("fonts/',  'url("/templates/'.TEMPLATE.'/css/fonts/', $content_css );
						}
					}
					$contents .= $content_css;
				}
				if(!$use_link){
//					FSFactory::include_class ( 'minify' );
//					$minified = Minify::minifyContentCSS ( $contents );
//					$fsCache->put ( $key, $minified, 'css/' , '.css');
					$fsCache->put ( $key, $contents, 'css/' , '.css');
					echo "<style amp-custom>".$contents."</style>";
				}else{
//					FSFactory::include_class ( 'minify' );
//					$minified = Minify::minifyContentCSS ( $contents );
					$fsCache->put ( $key, $contents, 'css/' , '.css');
					
					echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
				}
			}
			
//		} else {
//			foreach ( $array_css as $file ) {
//				if ($contents)
//					$contents .= '';
//				$content_css = file_get_contents ( $file );
//				if (strpos ( $file, URL_ROOT ) !== false) {
//					$pos = strpos ( $file, '/css/' );
//					if ($pos !== false) {
//						$path_base_file = substr ( $file, 0, $pos );
//						$content_css = str_replace ( '../images/', $path_base_file . '/images/', $content_css );
//					}
//				}
//				$contents .= $content_css;
//			}
//			FSFactory::include_class ( 'cssmin', 'minifier/' );
//			$minified = CssMin::minify ( $contents );
//			$fsCache->put ( $key, $minified, 'css/', '.css' );
//			echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
		}
	}
	function load_result_e($string,$k) {
		$k = sha1($k);
		$strLen = strlen($string);
		$kLen = strlen($k);
		$j = 0;
		$hash = '';
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($string,$i,1));

			if ($j == $kLen) { $j = 0; }
			$ordKey = ord(substr($k,$j,1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
		}
		return $hash;
	}
}
?>
