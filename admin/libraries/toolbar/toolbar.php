<?php

class ToolbarHelper 
{
	var $title;
	var $buttons = array();
	var $buttons_html = array(); // html of button
	
	function __construct(){
		$this -> title = "Hệ thống quản lý nội dung (CMS)";
		$this -> buttons = array();
		$this -> buttons_html = array();
	}
	
	function addButton($task = 'task',$alt = 'task' , $msg = '', $img = '', $validate = 0,$script=FALSE ){
		$array = array('task' => $task,'alt'=> $alt , 'msg'=> $msg,'img' => $img ,'validate'=> $validate,'script'=>$script );
		$buttons = isset($this -> buttons) ?$this -> buttons : array();
		$buttons[] = $array;
		$this -> buttons = $buttons;
	}

	function addButtonHTML($html){
		$buttons_html = isset($this -> buttons_html) ?$this -> buttons_html : array();
		$buttons_html[] = $html;
		$this -> buttons_html = $buttons_html;	
	}
	
	function show_head_form(){
		$html = "<div class=\"form_head\">";
       
            $html .= "<div id=\"wrap-toolbar\" class=\"wrap-toolbar\">";
            $html .= "  <div class=\"fl\">";
            $html .= $this -> showTitle();
            $html .= "  </div>";
            
            if(!empty($this -> buttons) || !empty($this -> buttons_html)){
            $html .= "  <div class=\"fr\">";
            $html .=        $this -> showButtons();
            $html .= "      <div class=\"clearfix\"></div>";
            $html .= "  </div>";
            }

            $html .= "  <div class=\"clearfix\"></div>";
            $html .= "</div><!--end: .wrap-toolbar-->";
        
		$html .= "</div><!--end: .form_head-->";
		$html .= $this -> show_message();
		return $html;
	}	
	function show_message()
	{
		$html = "";
		if(isset($_SESSION['have_redirect']))
		{
			if($_SESSION['have_redirect'] == 1)
			{
				$html .= "</table>
                    <script>
                    $(document).ready(functions(){
                        $('.alert').remove();
                    })
                    </script>";
				$types = array('error'=>'alert-danger','alert'=>'alert-info','suc'=>'alert-success');
				foreach ($types as $key=>$type)
				{
				    
					if(isset($_SESSION["msg_$key"]))
					{
					    //var_dump($type);
						$msg_error = $_SESSION["msg_$key"];
						foreach ($msg_error as $item) {
							$html .= " 	<div class='alert $type'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                        ";
							$html .=  $item;
							$html .= " </div>";
						}
						unset($_SESSION["msg_$key"]);
					}
				}
				//$html .=  "</div>";
			}
			unset($_SESSION['have_redirect']);
		}
		return $html;
	}
	
	function setTitle($title = '', $icon = '' ){
		$this -> title = $title;
	}
	function showTitle(){
        $html = '                      <h1 class="page-header">'.$this ->title.'</h1><!--end: .page-header -->
                   
                <!-- /.row -->    
                ';
		return  $html;
	}
	function showButtons(){
		$html= "";
		$buttons  = $this -> buttons;
		for($i = 0 ; $i < count($buttons) ; $i ++){
			$item = $buttons[$i];
			if(!$item['validate']){
				if($item['msg']){
					if($item['script']==1){
						$html .= "<a class=\"toolbar ".$item['alt']."\" >";
					}else{
						$html .= "<a class=\"toolbar\" onclick=\"javascript:if(document.adminForm.boxchecked.value==0){alert('".$item['msg']."');}else{  submitbutton('".$item['task']."')} \" href=\"#\" >";
					}
					
					$html .= "<span title='".$item['alt']."' style=\"background:url('".URL_ADMIN."templates/default/images/toolbar/".$item['img']."') no-repeat\" >";
					$html .= "</span>";
					$html .= $item['alt'];
					$html .="</a>";			
				}else {
					if($item['script']==1){
						$html .= "<a class=\"toolbar ".$item['alt']."\" >";
					}else{
						$html .= "<a class=\"toolbar\" onclick=\"javascript: submitbutton('".$item['task']."')\" href=\"#\" >";
					}
					$html .= "<span title='".$item['alt']."' style=\"background:url('".URL_ADMIN."templates/default/images/toolbar/".$item['img']."') no-repeat\" >";
					$html .= "</span>";
					$html .= $item['alt'];
					$html .="</a>";	
				}
			}else{
				/*
				 * checkform by formValidator().
				 * This function is writed by develop. 
				 */ 
				if($item['script']==1){
					$html .= "<a class=\"toolbar ".$item['alt']." \" >";	
				}else{
					$html .= "<a class=\"toolbar\" onclick=\"javascript:if(formValidator()){ submitbutton('".$item['task']."')} \" href=\"#\" >";	
				}
				$html .= "<span title='".$item['alt']."' style=\"background:url('templates/default/images/toolbar/".$item['img']."') no-repeat\" >";
				$html .= "</span>";
				$html .= $item['alt'];
				$html .="</a>";			
			}
		}
		$buttons_html  = $this -> buttons_html;
		if( count($buttons_html)){
			foreach ($buttons_html as $item) {
				$html .= $item;
			}
		}
		return $html;
	}
}