<?php
/*
 * Huy write
 */

class Pagination
{
	var $limit;
	var $total;
	var $page;
	var $url;
	
	function __construct($limit,$total,$page,$url = ''){
		if(!$limit)
			$limit = 20;
		$this->limit = $limit;
		$this->total = $total;
		$this->page = $page;
		if($url){
			$this->url = URL_ROOT.'admin/'.$url;
		}else
		{
			$url = $_SERVER['REQUEST_URI'];
			$url =  trim(preg_replace('/^\//', '', $url));
//			$url = substr($url,strlen(URL_ROOT_REDUCE));
			
			$url =  trim(preg_replace('/\?page=[0-9]+/i', '', $url));
			$this->url = URL_ROOT.$url;
		}
	}
	
	function create_link_with_page($url,$page){
		$url =  trim(preg_replace('/\?page=[0-9]+/i', '', $url));
		if(!$page || $page == 1){
			return $url;
		} else {
			return $url.'?page='.$page;
		}
	}
	
	/*
	 * maxpage is max page is show. But It is not last pageg.
	 * ex: 1,2,3,4..100.=> 4 is max page 
	 */
	function showPagination($maxpage = 5)
	{
		$previous = "&lsaquo;";
//		$previous = "<img src='".URL_ROOT."images/page_previous.gif' alt='previous page'>";
		$next = "&rsaquo;";
//		$next = "<img src='".URL_ROOT."images/page_next.gif' alt='previous page'>";
		$first_page = "&#171;";
//		$first_page = "<img src='".URL_ROOT."images/page_first.gif' alt='first page'> ";
		$last_page = "&#187;";
//		$last_page = "<img src='".URL_ROOT."images/page_last.gif' alt='last page'>";
		
		$current_page = FSInput::get('page');
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
		$html .=  "<div style='text-align: center; font-weight: bold; margin-top: 30px;'><font>" . FSText :: _('Tổng') . "</font> : <span style='color:red'>[".$this->total."]</span> </div>";
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			$start_page = $current_page - $maxpage;
			if($start_page <= 0)
				 $start_page = 1;
			
			$end_page = $current_page + $maxpage;
			
			if($end_page > $num_of_page) 
				$end_page = $num_of_page;
			
			//WRITE prefix on screen
			
			$html  .= "<ul class='pagination'>";
		
			$html .=  "<li><a class='title_pagination'>" . FSText :: _('Page') . "</a></li> ";
			//Write Previous
			if(($current_page > 1) && ($num_of_page > 1)){
				$html .= "<li><a title='first_page' href='" . Pagination::create_link_with_page($this->url,0) . "' title='".FSText :: _('First page')."' >" . $first_page . "</a></li>";
				$html .= "<li><a title='pre_page' href='" . Pagination::create_link_with_page($this->url , ($current_page-1)) . "' title='".FSText :: _('Previous')."' >" . $previous . "</a></li>";
				if($start_page !=1)
					 $html .= " <b>..</b> ";
			}
			for($i=$start_page; $i<=$end_page; $i++){
				if($i != $current_page){
					if($i == 1)
					 	$html .= "<li><a title='Page " . $i . "' href='" . Pagination::create_link_with_page($this->url,0 ) . "' >" . $i . "</a></li>";
					 else
					 	$html .= "<li><a title='Page " . $i . "' href='" . Pagination::create_link_with_page($this->url,$i ) . "' >" . $i . "</a></li>"; 
				}
				else{
					 $html .= "<li><a title='Page " . $i . "' class='current'>[" . $i . "]</a></li>";
				}
			}
			//Write Next
			if(($current_page < $num_of_page) && ($num_of_page > 1)){
				if($end_page < $num_of_page) 
					$html .= " <b>..</b> ";
				$html .= "<li><a aria-label='Previous' title='Next page' href='" . Pagination :: create_link_with_page ($this -> url ,($current_page+1)) . "' >" . $next . "</a></li>";
				$html .= "<li><a aria-label='Next' title='Last page' href='" . Pagination :: create_link_with_page ($this -> url ,$num_of_page) . "' >" . $last_page . "</a></li>";
			}
			$html .= "</ul>";
		}
		
		return $html;
	}
}