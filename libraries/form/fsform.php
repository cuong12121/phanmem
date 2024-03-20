<?php 
/*
 * Huy write
 * This class support fsform : ordering
 */
class FSForm
{
	
	/*
	 * $title_field is Title
	 * field_name is value of fields in thead 
	 * sort_direct: asc, desc
	 */
	function orderTable($field_title,$field_name)
	{
		// url not set pagination
		$url = $_SERVER['REQUEST_URI'];
//		$pos = strpos($url,'.php?');
//		$url  = substr($url,($pos+5)); 
		
//		if(!IS_REWRITE)
//			$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
//		else 
//			$url =  trim(preg_replace('/-page[0-9]+/i', '', $url));
		
		$url =  trim(preg_replace('/&sort=.*[\&]*/i', '', $url)); // not sort,
		$url =  trim(preg_replace('/&sortby=.*[\&]*/i', '', $url)); // not sort,
		$this->url = $url;
		// sort direct current
		$sort_direct_current = FSInput::get('sort','desc');
		// sort field current
		$sort_field_current =     FSInput::get('sortby','desc');
		
		// class
		$class_desc = '';
		$class_asc = '';
		// field is sorting.
		if($field_name == $sort_field_current)
		{
			if($sort_direct_current == 'desc')
			{
				$class_desc = 'current'; 
			}
			else
			{
				$class_asc = 'current';
			}
		}
		
		$url_desc = $url."&sort=desc&sortby=$field_name";
		$url_asc = $url."&sort=asc&sortby=$field_name";
//		$url_desc = Route::_($url."&sort=desc&sortby=$field_name");
//		$url_asc = Route::_($url."&sort=asc&sortby=$field_name");
				
		$html = "";
		$html .=  "<span class='fsform-head'>". $field_title . "</span>";
		$html .= "<p class='fsform-button'>";
		$html .=  "<a class='$class_desc sort_desc' title='".FSText::_('sort desc')."' href='$url_desc'><img alt='desc' src='".URL_ROOT."libraries/form/images/order-down.png' title='".$field_name.' desc'."'</a>";
		$html .=  "<a class='$class_asc sort_asc' title='".FSText::_('sort asc')."' href='$url_asc'><img alt='desc' src='".URL_ROOT."libraries/form/images/order-up.png' title='".$field_name.' asc'."'</a>";
		$html .= "</p>";
		return $html ; 
	}
	/*
	 * Display status of item
	 * $status_current: status current
	 * $field_des: des of field to show int title
	 * $url: NOT &status=...
	 */
	function status($status_current = 0,$field_des='',$url=''){
		$html = ""; 
		if(!$status_current){
			$url = $url.'&status=1';
			$html .=  "<a class='' title='$field_des' href='$url'><img alt='desc' src='".URL_ROOT."libraries/form/images/published.png' /></a>";
		}else {
			$url = $url.'&status=0';
			$html .=  "<a class='' title='$field_des' href='$url'><img alt='desc' src='".URL_ROOT."libraries/form/images/unpublished.png' /></a>";
		}
		return $html;
	}
    /**
     * Lay link sap xep
     * 
     * @param   $sortby: Tham so can sap xep
     * @param   $sort  : Kieu sap xep
     * 
     * @return  String: Url xắp xếp
     * 
     */ 
    function get_link_order( $sortby, $sort = 'ASC'){
		$url = $_SERVER['REQUEST_URI'];
		$url =  trim( preg_replace( '/&sort=.*[\&]*/i', '', $url));
		$url =  trim( preg_replace( '/&sortby=.*[\&]*/i', '', $url));
        $url .= '&sort='.$sort.'&sortby='.$sortby;
		return $url; 
	}
}
?>