<?php
/*
 * Huy write
 */

class Loadmore
{
	var $limit;
	var $total;
	var $page;
	var $url;
	var $pagecurrent;
	
	function __construct($pagecurrent,$limit,$total,$page,$url = ''){
			$this->limit = $limit;
			$this->total = $total;
			$this->page = $page;
			$this->pagecurrent = $pagecurrent;
			if($url)
				$this->url = $url;
			else
			{
				$url = $_SERVER['REQUEST_URI'];
				$this->url = $url;
			}
	}
	

function create_link_with_page($url,$page){
		
		if(!IS_REWRITE){
			$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
			
			if(!$page || $page == 1){
				return $url;
			} else {
				return $url.'&page='.$page;
			}
		} else {
			if($url == '' || $url == '/')
				$url = '/trang-chu.html';
			if(!$page || $page == 1){
				$url = trim(preg_replace('/-page[0-9]+/i', '', $url));
				if($url == '/sim.html')
					return URL_ROOT;
				return $url;
			} else {
				$search = preg_match('#-page([0-9]+)#is',$url,$main);
				if($search){
					$url = preg_replace('/-page[0-9]+/i','-page'.$page, $url);
				} else {
					$url = preg_replace('/.html/i','-page'.$page.'.html', $url);
				}
				return $url;
			}
		}
	}
	
	function create_link_with_page_ajax($url,$page){
		
		$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
		
		if(!$page || $page == 1){
			return $url;
		} else {
			return $url.'&page='.$page;
		}
	}
	
	function showLoadmore($maxpage = 5)
	{
	
		$current_page = FSInput::get('page');
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			//WRITE prefix on screen
			$html  .= "<div class='pagination'>";
		
			//Write Next
			if(($current_page < $num_of_page) && ($num_of_page > 1)){
				$html .= "<a id='load_more_button' class='load_more'  data-pagecurrent='".$this->pagecurrent."' title='Next page' data-nextpage='".$this->limit."' href='javascript: void(0);' data-list='list-product-hot'>Xem thêm sảm phẩm</a>";
			}
			$html .= "</div>";
		}
		
		return $html;
	}
}