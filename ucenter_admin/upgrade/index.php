<?php
//升级系统
error_reporting(0);
define("MY_UPGRADER", true);
//向API请求的类型
require __DIR__.'/config.php'; 
 
//
$base_config_db = require __DIR__."/../".$dir_name."/configs/db.ini.php";
require __DIR__."/../".$dir_name."/configs/shop_api.ini.php";
require __DIR__."/../".$dir_name."/configs/ucenter_api.ini.php";
$curl_url =  "http://license.yuanfeng.cn/index.php";
if(strpos($ucenter_api_url,'/index.php')!==false){
    $curl_url = str_replace("/index.php","",$curl_url); 
}
if(substr($curl_url,-1) !='/'){
    $curl_url = $curl_url."/";
} 
$curl_url = $curl_url."upgrade_/upgrade.php"; 

require __DIR__."/../libraries/Yf/Hash.php";
if(!$_GET['id'] || !$_GET['key']){exit;}
Yf_Hash::setKey('token_'.$_GET['id']);
$decrypt_str =  Yf_Hash::decrypt($_GET['key']);

parse_str($decrypt_str, $now_data);
if($now_data['id']!=10001 ){
	exit('access deny');
} 
$url_string = "&id=".$_GET['id']."&key=".$_GET['key'];
 
?>

<link rel='stylesheet' id='buttons-css'  href='./static/css/buttons.css?ver=4.5.2' type='text/css' media='all' />
<link rel='stylesheet' id='install-css'  href='./static/css/install.css?ver=4.5.2' type='text/css' media='all' />
<body class='wp-core-ui'>
<?php 

header("Content-type: text/html; charset=utf-8");  
require __DIR__.'/vendor/autoload.php';
include __DIR__.'/file.php';
include __DIR__.'/rb.php';
 
R::setup( 'mysql:host='.$base_config_db['host'].';dbname='.$base_config_db['database'].'',
        $base_config_db['user'], $base_config_db['password'] );

use Alchemy\Zippy\Zippy; 
$zippy = Zippy::load();  
$base_path = realpath(__DIR__.'/../');

include __DIR__.'/../messages/I18N.php';     

$curl_type_count = strlen($curl_type)+1;

$zip_path = __DIR__."/zip";
if(!is_dir($zip_path)) mkdir($zip_path,true,0777);
if(!is_writable($zip_path)){
    exit(__('目录不可写').":".$zip_path);
}
/**
 * 各个系统升级
 */
$type = $_GET['type'];
$dir = __DIR__."/../pack";


if(!is_writable($dir)){
		exit(__('目录不可写').":".$dir);
}

$version = include $dir.'/version.php';
//当前本地版本号
$current_version = $version['version'];
$current_version_text = $version['text'];
$r = json_decode(file_get_contents($curl_url."?type=".$curl_type."&version=".$current_version),true);
$up_db = __DIR__."/log/~upgrade.db_sql.php";
if($r['lastest']){
    if(!$_GET['do']){
        echo "<h1>"."当前版本号：".$current_version."</h1><p style='color:red;font-size:20px;'>".$r['lastest']."</p>";
        echo "<div class='step'>
                 <a href='?do=1".$url_string."' class='button button-large button-primary'>".__("请确认升级信息")."</a></div>";
        exit;
    }

    if($_GET['do'] == 2){
        include __DIR__.'/upgrade.php'; 
        exit;
    }
    
}else{
    echo "<h1>".__('版本最新')." ".$current_version."</h1><p style='color:green;font-size:20px;'>".__('已经是最新版本了，无需升级！')."</p>";
    exit;
}


 
if(count($r['zip'])>0){
    echo "<ol>";
	//把包下载下来
	foreach($r['zip'] as $zip_url){
				$file = __DIR__."/zip/".substr($zip_url,strrpos($zip_url,'/'));
                $file_name = file::name($zip_url);
				if(!file_exists($file)){
							try {
								    if (downloader::get($zip_url, $file )) {
								         echo "<li class='line'>".__("下载升级包".$file_name )."完成</li>";
								         flush();
                                         echo "<li class='line'>".__("解压升级包中……")."</li>";
                                         flush();
								         $archive = $zippy->open($file);  
                                         $archive->extract($zip_path."/");
                                         echo "<li class='line'>".__("解压升级包完成")."</li>";
								         flush();
								    }
								} catch (Exception $e) {
								    echo "<li class='line'>".__('下载升级包失败了，请重试！'.$file."</li>");
								    flush();
								}
				}
				
	} 
    echo "</ol>";
    //比较文件
    $c1 = count($r['zip']);
    $i = 0;
    $db_sql = "";

    foreach($r['zip'] as $zip_url){
        $file_name = substr(file::name($zip_url),0,-4);
        $file_name = substr($file_name,$curl_type_count);
        $find_dir = "/zip/".$file_name;
         
        $unzip_dir = __DIR__.$find_dir;
        $list = file::find($unzip_dir)['file'];

        foreach($list as $v){  
                if(file::name($v)=='db.sql') {
                	  $db_sql_content = file_get_contents($v);
                	  if($db_sql_content)
                    	$db_sql .= $db_sql_content; 
                    continue;
                }
                $n = $base_path.str_replace($unzip_dir,'',$v);
                $compare[$n] =  $v;
        }

        foreach($compare as $k=>$v){ 
            if(!file_exists($k) || 
            	!file_exists($v) ||
            	(md5(@file_get_contents($k)) != md5(@file_get_contents($v)))){  
                $replace[$k] = $v;
            } 
        } 
         
    }

     
    file_put_contents(__DIR__."/log/~upgrade.php_files.php","<?php return ".var_export($replace,true).";");
    if(trim($db_sql)){
        file_put_contents($up_db,$db_sql);    
    }
    


    echo '<div class="license">';

    if($db_sql){
        echo "<h1>".__("升级数据")."</h1>";
        echo "<ol style='overflow-y:auto;height:300px;border:1px solid #ccc;'>"; 
        echo  file_get_contents($up_db); 
        echo "</ol>"; 

    }
    


    echo "<h1>".__("有以下文件将被覆盖")."</h1>";
    echo "<ol>";
    $not_run = false;
    foreach($replace as $k=>$v){
        $lab = "<span class='yes'><i class='iconfont'></i>可写</span>";
        if(!is_writable($v)){
            $not_run = true;
            $lab = "<span class='no'><i class='iconfont'></i>不可写</span>";
        }
        echo "<li class='line'>".$lab.$k."</li>";

    }
    echo "</ol>";
    echo "</div>";
    if(!is_writable(__DIR__."/")){
        echo "<h1>".__("请确保目录可写，否则无法进行升级!")."</h1>";
        exit;
    }
    
   
    if($not_run != true){
        echo "<div class='step'>
                 <a href='?do=2".$url_string."' class='button button-large button-primary'>".__("确认升级")."</a></div>";
    }else{
        
    }
    

	return ; 

}
?>


</body>



<?php

 

class downloader {
 
    /**
     * download file to local path
     *
     * @param       $url
     * @param       $save_file
     * @param int   $speed
     * @param array $headers
     * @param int   $timeout
     * @return bool
     * @throws Exception
     */
    static function get($url, $save_file, $speed = 10240, $headers = array(), $timeout = 10) {
        $url_info = self::parse_url($url);
        if (!$url_info['host']) {
            throw new Exception('Url is Invalid');
        }
 
        // default header
        $def_headers = array(
            'Accept'          => '*/*',
            'User-Agent'      => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)',
            'Accept-Encoding' => 'gzip, deflate',
            'Host'            => $url_info['host'],
            'Connection'      => 'Close',
            'Accept-Language' => 'zh-cn',
        );
 
        // merge heade
        $headers = array_merge($def_headers, $headers);
        // get content length
        $content_length = self::get_content_size($url_info['host'], $url_info['port'], $url_info['request'], $headers, $timeout);
 
        // content length not exist
        if (!$content_length) {
            throw new Exception('Content-Length is Not Exists');
        }
        // get exists length
        $exists_length = is_file($save_file) ? filesize($save_file) : 0;
        // get tmp data file
        $data_file = $save_file . '.data';
        // get tmp data
        $exists_data = is_file($data_file) ? json_decode(file_get_contents($data_file), 1) : array();
        // check file is valid
        if ($exists_length == $content_length) {
            $exists_data && @unlink($data_file);
            return true;
        }
        // check file is expire
        if ($exists_data['length'] != $content_length || $exists_length > $content_length) {
            $exists_data = array(
                'length' => $content_length,
            );
        }
        // write exists data
        file_put_contents($data_file, json_encode($exists_data));
 
        try {
            $download_status = self::download_content($url_info['host'], $url_info['port'], $url_info['request'], $save_file, $content_length, $exists_length, $speed, $headers, $timeout);
            if ($download_status) {
                @unlink($data_file);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return true;
    }
 
    /**
     * parse url
     *
     * @param $url
     * @return bool|mixed
     */
    static function parse_url($url) {
        $url_info = parse_url($url);
        if (!$url_info['host']) {
            return false;
        }
        $url_info['port']    = $url_info['port'] ? $url_info['host'] : 80;
        $url_info['request'] = $url_info['path'] . ($url_info['query'] ? '?' . $url_info['query'] : '');
        return $url_info;
    }
 
    /**
     * download content by chunk
     *
     * @param $host
     * @param $port
     * @param $url_path
     * @param $headers
     * @param $timeout
     */
    static function download_content($host, $port, $url_path, $save_file, $content_length, $range_start, $speed, &$headers, $timeout) {
        $request = self::build_header('GET', $url_path, $headers, $range_start);
        $fsocket = @fsockopen($host, $port, $errno, $errstr, $timeout);
        stream_set_blocking($fsocket, TRUE);
        stream_set_timeout($fsocket, $timeout);
        fwrite($fsocket, $request);
        $status = stream_get_meta_data($fsocket);
        if ($status['timed_out']) {
            throw new Exception('Socket Connect Timeout');
        }
        $is_header_end = 0;
        $total_size    = $range_start;
        $file_fp       = fopen($save_file, 'a+');
        while (!feof($fsocket)) {
            if (!$is_header_end) {
                $line = @fgets($fsocket);
                if (in_array($line, array("\n", "\r\n"))) {
                    $is_header_end = 1;
                }
                continue;
            }
            $resp        = fread($fsocket, $speed);
            $read_length = strlen($resp);
            if ($resp === false || $content_length < $total_size + $read_length) {
                fclose($fsocket);
                fclose($file_fp);
                throw new Exception('Socket I/O Error Or File Was Changed');
            }
            $total_size += $read_length;
            fputs($file_fp, $resp);
            // check file end
            if ($content_length == $total_size) {
                break;
            }
            sleep(1);
            // for test
            //break;
        }
        fclose($fsocket);
        fclose($file_fp);
        return true;
 
    }
 
    /**
     * get content length
     *
     * @param $host
     * @param $port
     * @param $url_path
     * @param $headers
     * @param $timeout
     * @return int
     */
    static function get_content_size($host, $port, $url_path, &$headers, $timeout) {
        $request = self::build_header('HEAD', $url_path, $headers);
        $fsocket = @fsockopen($host, $port, $errno, $errstr, $timeout);
        stream_set_blocking($fsocket, TRUE);
        stream_set_timeout($fsocket, $timeout);
        fwrite($fsocket, $request);
        $status = stream_get_meta_data($fsocket);
        $length = 0;
        if ($status['timed_out']) {
            return 0;
        }
        while (!feof($fsocket)) {
            $line = @fgets($fsocket);
            if (in_array($line, array("\n", "\r\n"))) {
                break;
            }
            $line = strtolower($line);
            // get location
            if (substr($line, 0, 9) == 'location:') {
                $location = trim(substr($line, 9));
                $url_info = self::parse_url($location);
                if (!$url_info['host']) {
                    return 0;
                }
                fclose($fsocket);
                return self::get_content_size($url_info['host'], $url_info['port'], $url_info['request'], $headers, $timeout);
            }
            // get content length
            if (strpos($line, 'content-length:') !== false) {
                list(, $length) = explode('content-length:', $line);
                $length = (int)trim($length);
            }
        }
        fclose($fsocket);
        return $length;
 
    }
 
    /**
     * build header for socket
     *
     * @param     $action
     * @param     $url_path
     * @param     $headers
     * @param int $range_start
     * @return string
     */
    static function build_header($action, $url_path, &$headers, $range_start = -1) {
        $out = $action . " {$url_path} HTTP/1.0\r\n";
        foreach ($headers as $hkey => $hval) {
            $out .= $hkey . ': ' . $hval . "\r\n";
        }
        if ($range_start > -1) {
            $out .= "Accept-Ranges: bytes\r\n";
            $out .= "Range: bytes={$range_start}-\r\n";
        }
        $out .= "\r\n";
 
        return $out;
    }
}
 
 
 
/*
try {
    if (downloader::get('http://dzs.aqtxt.com/files/11/23636/201604230358308081.rar', 'test.rar')) {
        //todo
        echo 'Download Succ';
    }
} catch (Exception $e) {
    echo 'Download Failed';
}
*/