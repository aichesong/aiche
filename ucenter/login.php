<?php
require_once './ucenter/configs/config.ini.php';

$code = '';
$state = '';

extract($_GET);
if($code)
{
	$url = sprintf('%s?ctl=Connect_Qq&met=callback&code=%s&callback=%s', Yf_Registry::get('ucenter_api_url') , $code, urlencode($state));
	header('Location:'.$url);
}else
{
	$url = sprintf('%s?ctl=Login', Yf_Registry::get('ucenter_api_url'));
	header('Location:'.$url);
}
?>
