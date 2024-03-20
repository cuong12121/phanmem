<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('aq','blocks/aq/assets/css');
$tmpl -> addScript('aq','blocks/aq/assets/js');
$html = '';
?>


<?php 
$html .= '<div class="aq-block-body">';
	$link_cat = FSRoute::_("index.php?module=aq&view=home&Itemid=89&page=$2");
	$Itemid = 4;
	for($i = 0; $i < count($list); $i ++ ){
		$item = $list[$i];
		$link = FSRoute::_("index.php?module=aq&view=aq&id=".$item-> id."&code=".$item-> alias."&Itemid=$Itemid");
		$html .= '<div class="item cls">';

			$html .= '<div class="question ';	
			$html .= ($i==0)?'minus':'plus'. '">';

				$html .= '<span class="title">'.$item ->question .'</span>';			
			$html .= '</div>';			
			$html .= '<div class="content" id="content-'.($i + 1) .'">';
				$html .= '<div class="content2">'. getWord(25,$item->content).'</div>';			
				$html .= '<a class="link_aq" href="'.$link.'" title = "'. $item ->question .'" >Xem thêm >></a>';			
			$html .= '</div>';
		$html .= '</div>';
	}

	$html .= '<div class="aq_form_send">';
		$html .= '<div class="text_form">';
			$html .= '<div>Bạn vẫn có câu hỏi?</div>';
			$html .= '<div class="view_all">';
		        $html .= '<a href="'. FSRoute::_("index.php?module=aq&view=home").'" title = "Xem thêm câu hỏi" class="">';
		            $html .= 'Xem tất cả';
		        $html .= '</a>';
		    $html .= '</div>';
		$html .= '</div>';
	$html .= '</div>';

$html .= '</div>';
echo $html;
?>
