<?php
require_once './ucenter/configs/config.ini.php';

extract($_GET);
//�жϵ�ǰ�Ƿ����û���¼
//1.ucenter���Ѿ����û���¼
if(isset($_COOKIE['id']) && $_COOKIE['id'])
{
	//1-1.ucenter�еĵ�¼�û���im�еĵ�¼�û���ͬ
	if($us == $_COOKIE['id'])
	{
		header('Location:'.$callback);
	}else  //1-2.ucenter�еĵ�¼�û���im�еĵ�¼�û���ͬ
	{
		//1-2-1.�˳���ǰ�û�
		if (isset($_COOKIE['key']) || isset($_COOKIE['id']))
		{
			setcookie("key", null, time() - 3600 * 24 * 365);
			setcookie("id", null, time() - 3600 * 24 * 365);
		}

		//1-2-2.��¼IM�е��û�
		if($user_account && $user_password)
		{
			$url = sprintf('%s?ctl=Api&met=login&typ=json&user_account=%s&user_password=%s&callback=%s', 'index.php' , $user_account, $user_password,$callback);
			header('Location:'.$url);
		}

	}
}
else  //2.ucenter��û���û���¼
{
	if($user_account && $user_password)
	{
		$url = sprintf('%s?ctl=Api&met=login&typ=json&user_account=%s&user_password=%s&callback=%s', 'index.php' , $user_account, $user_password,$callback);
		header('Location:'.$url);
	}
}

?>
