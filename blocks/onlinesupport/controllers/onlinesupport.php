<?php
/*
 * Huy write
 */
// models 
include 'blocks/onlinesupport/models/onlinesupport.php';

class OnlinesupportBControllersOnlinesupport {
	function __construct() {
	}
	function display($parameters, $title) {
		$style = $parameters->getParams ( 'style' );
		$style = $style ? $style : 'default';
		if ($style == 'bottom') {
		
		} else {
			$model = new OnlinesupportBModelsOnlinesupport ();
			$data = $model->getList ();
			if (! count ( $data ))
				return;
			$html_yahoo = '';
			$html_skype = '';
			$html_email = '';
			$html_hotline  = '';
			$html_avata='';
			foreach ( $data as $item ) {
				if (! $item->display_name)
					continue;
				if ($item->yahoo) {
					$html_yahoo .= '<li>';
					//$html_yahoo .= '	<a href="ymsgr:sendIM?'.$item->yahoo.'&m=Chao+ban%2C+toi+muon+hoi+"'; 
					//					$html_yahoo .= '			style="background-image:url(http://opi.yahoo.com/online?u='.$item->yahoo.'&t=5&l=us) left center no-repeat">';
					//					$html_yahoo .=		$item->display_name.'</a>';
					$html_yahoo .= '<a href="ymsgr:sendIM?' . $item->yahoo . '&m=Chào+bạn%2C+tôi+muốn+hỏi"  rel="nofollow">';
//					$html_yahoo .= '<img border=0 src="http://opi.yahoo.com/online?u=' . $item->yahoo . '&t=5&l=us">&nbsp;</a>';
					$html_yahoo .= '<img src="' . URL_ROOT . 'blocks/onlinesupport/assets/images/yahoo-icon-small.png" alt="My status" />&nbsp;</a>';
					$html_yahoo .= '</li>';
				}
				if ($item->skype) {
					$html_skype .= '<li>';
					$html_skype .= '<a href="skype:' . $item->skype . '?chat"  rel="nofollow"><img src="' . URL_ROOT . 'blocks/onlinesupport/assets/images/skype-icon-small.png" style="border: none;" alt="My status" />&nbsp;</a>';
					$html_skype .= '</li>';
				}
				if ($item->email) {
					$html_email .= '<li>';
					$html_email .= '<a href="mailto:' . $item->email . '?chat"  rel="nofollow">' . $item->display_name . '</a>';
					$html_email .= '</li>';
				}
				if ($item->hotline) {
					$html_hotline .= '<li>';
					$html_hotline .= '<a href="tel:' . $item->hotline . '"  rel="nofollow">';
					$html_hotline .= '<img border=0 src="'.URL_ROOT.'blocks/onlinesupport/assets/images/help_but.png">&nbsp;';
					$html_hotline .= $item->hotline;
					$html_hotline .= '</a>';
					$html_hotline .= '</li>';
				}
				$html_avata .='<img class ="avata" src="'.URL_ROOT.str_replace('/original/', '/resized/',$item -> image).'">&nbsp;';
			}
		}
		include 'blocks/onlinesupport/views/onlinesupport/' . $style . '.php';
	}
}
?>