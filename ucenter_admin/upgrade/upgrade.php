<?php 
if(!defined('MY_UPGRADER')){exit('failed');}
@set_time_limit(0);
ignore_user_abort(TRUE);
$file = __DIR__."/log/~upgrade.php_files.php";
$db  = __DIR__."/log/~upgrade.db_sql.php";


if(!is_writable($file)){
      echo __("升级文件不存在！");
      exit;
}
$arr = include $file;
if(count($arr) < 1){
      echo __("升级文件不存在！");
      exit;
}
echo '<div class="license">';
if(is_file($db) && trim(file_get_contents($db)) ){
    $r = R::exec(file_get_contents($db));
    if($r){
        
        echo "<h1>".__("数据库升级完成")."</h1>";
        echo "<ol>";
        echo "<li class='line'><span class='yes'><i class='iconfont'></i>完成</span>数据库升级</li>";
        echo "</ol>";
        flush();
    }else{

        echo '<div class="license">';
        echo "<h1>".__("数据库升级失败")."</h1>";
        echo "<ol>";
        echo "<li class='line'>数据库升级失败了，请联系官方！</li>";
        echo "</ol>";
        echo "</div>";
        exit;
    }
}


 

echo "<h1>".__("文件升级")."</h1>";
echo "<ol>";
echo "<li class='line'>".__("需要升级文件数")."：".count($arr)."</li>";
$error_count = 0;
foreach($arr as $k=>$re){ 
      file_put_contents($k,file_get_contents($re));
      if(!is_writable($k)){ 
          $error_count++;
          $lab = "<span class='no'><i class='iconfont'></i>失败</span>"; 
      } 
			$lab = "<span class='yes'><i class='iconfont'></i>成功</span>";
      echo "<li class='line'>".$lab.$k."</li>"; 
      flush();
			
}

if($error_count>0){
	echo "<li class='line' style='color:red;'>".$error_count.__("部分文件升级失败，建议手动恢复 pack/config.php，再次升级！")."</li>";
}

echo "</ol>";
echo "</div>"; 
echo "<h1 style='border:0;color:green;'>".__("恭喜，升级完成")."</h1>";


$list = scandir(__DIR__.'/zip/');
foreach ($list as $v) {
    if(!in_array($v,array('.','..'))){
        $rm = __DIR__.'/zip/'.$v;
        if(is_dir($rm)){
            file::rmdir($rm);
        }elseif(is_file($rm)){
           unlink($rm);
        }
        
        
    }
   
}
 
unlink($file);
unlink($db);
exit;

