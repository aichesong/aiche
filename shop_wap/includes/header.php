<?php   
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
include __DIR__.'/../messages/I18N.php';

 
function base_url(){

	$s = $_SERVER['SERVER_NAME'];  
  $top = 'http';
	if($_SERVER['SERVER_PORT'] == 443 || $_SERVER['HTTPS'] == 1 ||$_SERVER['HTTPS'] == 'on')
		$top = 'https';
	return $top."://".$s; 
}

function menu_active($name){
	 if($name == '/index.html' && $_SERVER['REQUEST_URI']=='/')
	 {
	 	return true;
	 }
   if(strpos($_SERVER['REQUEST_URI'],$name)!==false){
   		return true;
   }
   return false;
}

$host = '';
if (isset($_SERVER['HTTP_HOST']))
{
	$host = $_SERVER['HTTP_HOST'];
} 
$shop_wap_config_file = __DIR__.'/../configs/config_' . $host . '.php'; 
if (is_file($shop_wap_config_file))
{
		include $shop_wap_config_file;
}
else
{
	include __DIR__.'/../configs/config.php'; 
}
 
include __DIR__.'/weixin_login.php';

ob_start();

$config_js = __DIR__."/../js/config_".$_SERVER['SERVER_NAME'].".js";
if(file_exists($config_js)){
	$_js_header = file_get_contents($config_js);
  $_js_header = '<script type="text/javascript">'.$_js_header.'</script>';
  $_js_header = str_replace('~',"",$_js_header);
  $_js_header = str_replace('~',"",$_js_header);
  
   
}else{
	include __DIR__.'/js.php';
	$_js_header = ob_get_contents();
}


ob_clean();

ob_start();

 



