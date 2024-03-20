<?php 
	class BreadcrumbsMessages
	{
		function getBreadcrumbs()
		{
			$rs = array();
			$view = Cinput::get('view');
			$task = Cinput::get('task');
			
			$rs[0][0] = "Trang c&#225; nh&#226;n";
			$rs[0][1] = Route::_("index.php?module=users&task=detail&Itemid=20");
			switch( $task)
			{
				case 'compose':
					$rs[1][0] = "So&#7841;n tin nh&#7855;n";
					$rs[1][1] = "";
					break;
				case 'inbox':
					$rs[1][0] = "H&#7897;p th&#432; &#273;&#7871;n";
					$rs[1][1] = "";
					break;
				case 'outbox':
					$rs[1][0] = "H&#7897;p th&#432; &#273;&#227; g&#7917;i";
					$rs[1][1] = "";
					break;
				default:
					$rs[1][0] = "Tin nh&#7855;n c&#225; nh&#226;n";
					$rs[1][1] = "";
					break;
				
			}
			return $rs;
		}
	}
?>