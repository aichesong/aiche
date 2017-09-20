<?php

$cf = include __DIR__.'/config.php';
$api_token_file = __DIR__.'/~token_autocreate.php';
if(!file_exists($api_token_file)){
     $data = json_decode(file_get_contents( $cf['ApiUrl'] . '?ctl=ImApi&met=getImConfig&typ=json' ));
    $appid = $data->data->im_appId; 
    $apptoken = $data->data->im_appToken;
    file_put_contents($api_token_file, json_encode(array('appid'=>$appid,'token'=>$apptoken)));
}else{
    $data = json_decode(file_get_contents($api_token_file),true);
    $appid = $data['appid'];
    $apptoken = $data['token'];
}


return array(
	'appid'=>$appid,
    'apptoken'=>$apptoken,
    'ApiUrl'=>$cf['ApiUrl'],
    'SnsUrl'=>$cf['SnsUrl'],
    'UCenterApiUrl'=>$cf['UCenterApiUrl'],
    'pagesize'=>$cf['pagesize'],
);