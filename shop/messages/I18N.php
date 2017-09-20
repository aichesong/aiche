<?php
 
$language_id = "zh_CN"; 
 

global $arrlist,$lang_file_trans;
//debug
/*
if(isset($_GET['lang'])  ){
	$language_id = $_GET['lang'];
	setcookie('lang_selected',$language_id);
}



if(isset($_COOKIE['lang_selected']) && $_COOKIE['lang_selected']){
	$language_id = $_COOKIE['lang_selected'];
}*/



$arrlist = array();
$dir = dirname(__FILE__).'/';
$file = $dir.$language_id."/app.php";

 
$lang_file_trans = $file;
if(file_exists($file)){
	$arrlist = include $file;
	$arrlist['lang'] = $language_id;
}

include __DIR__.'/baidu_transapi.php';
function youdaotran($str){
	return $str;
	return baidu_translate($str)['trans_result'][0]['dst'] ; 

	 
}
 

function __($str)
{
	global $arrlist,$lang_file_trans;
	 
	if(!$arrlist[$str]){
	 	 $arrlist[$str] =  youdaotran($str)?:$str."EN"; 
		 file_put_contents( $lang_file_trans , "<?php return ".var_export($arrlist, true).";");
	}
	 
	return $arrlist[$str]?$arrlist[$str]:$str;
}
