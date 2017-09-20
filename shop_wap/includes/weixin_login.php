<?php 
function is_weixin()
{ 
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
        return false;
}

if (
		$openWeixinLoginInWeixin &&is_weixin() && !$_GET['ks'] && !$_COOKIE['id']

	) 
{ 
	  header('Location: '.$UCenterApiUrl.'?ctl=Connect_WeixinIn&met=login&callback='.$WapSiteUrl);
	  exit;
}

 