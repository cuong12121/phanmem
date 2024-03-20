<?php
class FSSecurity
{
	function __construct()
	{
		
	}
	function checkLogin()
	{
		$redirect = base64_encode($_SERVER['REQUEST_URI']);
		if(!isset($_COOKIE['user_id']))
		{
			$Itemid = 11;
			$url = FSRoute::_('index.php?module=users&view=users&task=login&Itemid='.$Itemid.'&redirect='.$redirect);
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
		else {
//			if(!isset($_COOKIE['username']) || !$_COOKIE['username'])
//			{
//				$task = FSInput::get('task');
//				$module = FSInput::get('module');
//				$view = FSInput::get('view');
//				if($module=='users' && $view=='users' && ($task=='edit' || $task=='edit_save')){
//					return true;
//				}
//				$Itemid = 11;
//				$url = FSRoute::_('index.php?module=users&view=users&task=edit&Itemid='.$Itemid.'&redirect='.$redirect);
//				$msg = FSText :: _("Bạn phải bổ sung thêm thông tin");
//				setRedirect($url,$msg,'error');
//			}
			return true;
		}
	}
	
/*
	 * Kiểm tra cả login và đủ thông tin
	 */
	function check_full_info(){
		$redirect = base64_encode($_SERVER['REQUEST_URI']);
		if(!isset($_COOKIE['user_id']))
		{
			$Itemid = 11;
			$url = FSRoute::_('index.php?module=users&view=users&task=login&Itemid='.$Itemid.'&redirect='.$redirect);
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
		if(!isset($_COOKIE['username']) || !$_COOKIE['username'] || !isset($_COOKIE['full_name'])|| !$_COOKIE['full_name']){
			$task = FSInput::get('task');
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($module=='users' && $view=='users' && ($task=='edit' || $task=='edit_save')){
				return true;
			}
			$Itemid = 11;
			$url = FSRoute::_('index.php?module=users&view=users&task=edit&Itemid='.$Itemid.'&redirect='.$redirect);
			$msg = FSText :: _("Bạn phải bổ sung đầy đủ thông tin để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
		return true;
	}
	
	function checkEsoresLogin(){
		$this -> checkLogin();
		if(!isset($_COOKIE['estore_id']))
		{
			echo "<script>alert('You do not have permission');history.go(-1)</script>";
			return false;
		}
		else 
			return true;
	}
	
	// check for estore : saneps
	function checkEsoresLogin1()
	{
		if(!isset($_COOKIE['e-email']))
		{
			$Itemid = 9;
			$url = FSRoute::_("index.php?module=estores&task=login&Itemid=$Itemid");
			$msg = FSText :: _("B&#7841;n ph&#7843;i &#273;&#259;ng nh&#7853;p gian h&#224;ng &#273;&#7875; s&#7917; d&#7909;ng t&#237;nh n&#259;ng n&#224;y");
			setRedirect($url,$msg,'error');
		}
		else 
			return true;
	}
}