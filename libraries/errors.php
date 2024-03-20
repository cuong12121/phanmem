<?php
class Errors
{
	var $msg;
	var $type;
	function __construct($str = '')
	{
	}
	
	function _($msg='',$type='')
	{
		Errors :: setError($msg,$type);
	}
	function setError($msg='',$type='')
	{
		if($msg)
		{
			switch ($type)
			{
				case'error':
					
					if(!isset($_SESSION['msg_error']))
					{
						$msg_error = array();
					}
					else
					{
						$msg_error = $_SESSION['msg_error'];
					}
					$msg_error[] = $msg;
					$_SESSION['msg_error'] = $msg_error;	
					break;
				case'alert':
					if(!isset($_SESSION['msg_alert']))
					{
						$msg_alert = array();
					}
					else
					{
						$msg_alert = $_SESSION['msg_alert'];
					}
					$msg_alert[] = $msg;
					$_SESSION['msg_alert'] = $msg_alert;	
					break;
				case'':
				default:
					if(!isset($_SESSION['msg_suc']))
					{
						$msg_suc = array();
					}
					else
					{
						$msg_suc = $_SESSION['msg_suc'];
					}
					$msg_suc[] = $msg;
					$_SESSION['msg_suc'] = $msg_suc;	
					break;
			}
			$_SESSION['have_redirect'] = 1;
		}
	}
	
}