<?php 
/**
 * 自动检测所有配置，对不对。
 * 不对的，也可直接覆盖的。
 * configs目录要有 777 权限。
 * 同时可以检测 md5 32位的配置是否正确。
 * /check.php?server=21232f297a57a5a743894a0e4a801fc3
 *
 * 
 */
header("Content-type: text/html; charset=utf-8");                 

//基础查找项目的目录
$base_dir = dirname(__FILE__).'/';
//允许的INI配置
$allow_ini = array(
	//'connect',
	'imbuilder_api',
	'paycenter_api',
	'shop_api',
	//'sms',
	'ucenter_api',
	'im_api',
	'analytics_api',
);
 
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
date_default_timezone_set('Asia/Shanghai'); 
$shop_key = 'shop';
$shop_admin = 'shop_admin';
$ucenter = 'ucenter';
$ucenter_admin = 'ucenter_admin';
$paycenter = 'paycenter';
$paycenter_admin = 'paycenter_admin';
$imbuilder = 'imbuilder';
$imbuilder_admin = 'imbuilder_admin';
$analytics_key = 'analytics';

/**
 * 要安装什么就在这里配置吧。
 * 不需要的可以隐藏
 * @var array
 */
$dirs = array(
		$analytics_key=>'analytics/configs',
		$shop_key=>'shop/configs',
		$shop_admin=>'shop_admin/configs',
		$ucenter=>'ucenter/configs',
		$ucenter_admin=>'ucenter_admin/configs',
		$paycenter=>'paycenter/configs',
		$paycenter_admin=>'admin/configs',
		$imbuilder=>'im/configs',
		$imbuilder_admin=>'admin/configs',
);
$im_in_shop = $dirs[$shop_key];


$server = trim($_GET['server']);

foreach($dirs as $k=>$v){ 
		$list = file::find($base_dir.$k.'/'.$v);
		foreach($list['file'] as $fi){
			foreach($allow_ini as $in){
				if(strpos(file::name($fi),$in)!==false){
					$str = array();
					//原样读取PHP文件里面的内容
					$handle = @fopen($fi, "r");
					if ($handle) {
					    while (($buffer = fgets($handle, 4096)) !== false) {

							$regex = '/\$([a-zA-Z_]+).*=[\s]+(.*)/i';
					    	if(preg_match($regex, $buffer, $matches)){
					    	   $matches[2]  = trim($matches[2] );
					    	   $matches[2]  = str_replace("'",'',$matches[2] );
					    	   $matches[2]  = str_replace("\"","",$matches[2]);
					    	   $matches[2]  = str_replace(";","",$matches[2]);
							   $str[$matches[1]] =  $matches[2] ;
							   $onlykey[$matches[1]] = $matches[2];
							}

					        
					    }
					    if (!feof($handle)) {
					        echo "文件读取失败!\n";
					        
					    }
					    fclose($handle);
					}
					if(!$server){
						if( strlen(file::name($fi)) >= 32 ){
							continue;
						}
					}else{
						if( strpos( file::name($fi) ,$server  ) === false ){
							 
							continue;
						}
					}
					 
					$out[$k][$fi] = $str;
					$out1[$k][file::name($fi)] = $str;
				}
			}
			
		}
}

if(count($out) < 1){
	echo "找不到要检测的文件哦！";
	exit;
}
foreach($onlykey as $v=>$val){
	$n .= "'".$v."',\n";
}
//允许修改的变量
//echo $n;
//print_r('<pre>');
//print_r($out1);
$default_key = $out1[$shop_key]['shop_api.ini.php']['shop_api_key'];
//print_r($default_key);


$type = $_GET['type'];
switch ($type) {
	//修复工具
	case 'fixed_configs':
		$form_ele = '';
		$i = 1;

		$form_ele .= '
			 
					<div class="form-group ">
					    <label style="display:block;height:25px;line-height:25px;">统一KEY</label>
					    <input type="text" class="form-control"
					     id="key" value="'.$default_key.'"  >
					  </div>
			 
		';

		foreach($onlykey as $k=>$v){

			 
				$fe = substr($k,0,strpos($k,'_'));
				$k1 = $k;
				if($k=='imbuilder_erp_key'){
					$k1 = $k." 对应 im_key";
				}
				$form_ele .= '
				 
						<div class="form-group '.$fe.'">
						    <label style="display:block;height:25px;line-height:25px;">'.$k1.'</label>
						    <input type="text" class="form-control"
						     name="'.$k.'" value="'.$v.'"  >
						  </div>
				 
			';
		}

		echo <<<ETO
			<!DOCTYPE html>
			<html lang="zh-CN">
			 
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
			<title>配置修复小能手</title>
			<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
			<style>
			body{
				padding:20px;

			}
			 
			</style>
			<body>

			<h1>特莱力商城 <small>配置修复小能手</small></h1><br>
					<ul class="nav nav-tabs">
					  <li role="presentation"  ><a href="?type=">配置文件检测</a></li>
					  <li role="presentation" class="active"><a href="?type=">一键配置</a></li>
					</ul>

					 <h1>配置这里面的内容，要注意</h1>
					 <form method="post" action="?type=set_configs&server=$server">
						 
						 $form_ele
						   
					 
						  <button style="padding: 10px;
		    clear: both;
		    display: block;
		    font-size: 82px;
		    width: 355px;
		   " type="submit" class="btn btn-default">预览</button>
						 
					</form>


					<script>
							$(function(){
								
								$("#key").blur(function(){ 
										 var key = $(this).val().trim();
										 $("input").each(function(i){
												var name = $(this).attr('name');
												if(name && name.indexOf('_key')!=-1){
													$(this).val(key);
												} 
										 });
								});

							});
					
					</script>


			</body>

			</html>

ETO;

exit;
		break;
	case "set_configs":
		//全局设置
		 
		foreach ($out as $key => $value) {
			foreach($value as $php_config_file=>$v_arr){
				if(!is_writable($php_config_file)){
					 echo "文件：".$php_config_file." 不可写。<br>";
				}else{

					foreach($v_arr as $k2=>$v2){
						$v_arr[$k2] = trim($_POST[$k2]);
					}

					$new_write_content[$key][$php_config_file] = $v_arr;
				}
			}
		}
		$out = $new_write_content;
	 	if($_GET['do'] == 'overwrite'){



	 		echo "<style>
			.alert-danger{color:red;}
			.alert-success{color:blue;}
	 	</style>";
 
	 		if($im_in_shop){
	 			$im_config_in_shop = $base_dir.$shop_key.'/im/config.php';
	 			@unlink($base_dir.$shop_key.'/im/~token_autocreate.php');
	 			$im_config_in_shop_array = array(
	 					'ApiUrl'=>$out1[$imbuilder]['im_api.ini.php']['im_api_url'],
	 					'SnsUrl'=>$out1[$ucenter]['ucenter_api.ini.php']['ucenter_api_url'],
	 					'UCenterApiUrl'=>$out1[$ucenter]['ucenter_api.ini.php']['ucenter_api_url'],
	 					'pagesize'=>10,
	 			);
	 			 
	 			if(is_writable($im_config_in_shop)){
	 				file_put_contents($im_config_in_shop,"<?php\n return ".
	 					var_export($im_config_in_shop_array,true).";");
	 			}else{
	 				echo "<div style='color:red;'>写入shop/im/config.php失败！</div>";
	 			}
	 		}
	 		echo "<div style='color:red;'>请手动修改 shop/im/config.php 中 ，SnsUrl 这个KEY对应的VALUE</div>";
	 		foreach($out as $key=>$volist){
	 			foreach($volist as $k=>$v){
		 			if(is_writable($k)){
		 					$wt = "";
		 					foreach($v as $kk=>$vv){

		 						if(is_numeric($vv)){
		 							$wt .= "\$".$kk." = ".$vv.";\n";
		 							
		 						}else{
		 							$wt .= "\$".$kk." = '".$vv."';\n";	
		 						}
		 						
		 					}
		 					file_put_contents($k,"<?php\n".$wt);
 
		 					echo "<div class='alert alert-success'>".$k." 文件写入成功！</div>";
		 					flush();

		 			}else{

		 				echo "<div class='alert alert-danger'>".$k." 哎呀，写文件失败鸟！</div>";
		 				$error_write[$key] = $k;
		 			}
		 		}
	 		}
	 		if($error_write){
	 			echo "<div class='alert alert-danger'>写入失败，莫紧张！改了权限，直接刷新本页面！我会消失滴！！！</div>";
	 			dd($error_write);
	 		}else{
	 			echo "<div class='alert alert-danger'>神器打完收工，看效果吧！</div>";
	 		}
	 		exit;
	 	}
	 	
		break;
	default:
		# code...
		break;
}

function dd($str){
	print_r('<pre>');
	print_r($str);
	print_r('</pre>');
}
 
//把配置文件里面的KEY VALUE显示出来，准备做比较
$error_nums = 0;
foreach ($out as $key => $value) {
	$checkit .= '<ul class="list-group">';
	$checkit .= '<li href="#" class="list-group-item active">
				  '.$key.'
				  </li>';

	foreach($value as $k=>$v){

		$checkit .= '<li class="list-group-item alert alert-success">'.
					file::name($k). ' 配置文件</li>';	

		foreach($v as $k1=>$v1){
				$error = "";
				if($onlykey[$k1] != $v1 || 
					(strpos($k1,'_key')!==false && trim($v1) != $default_key)

				) {
					 
					$error = 'alert alert-danger';
					$error_nums++;	
				}
				
				$checkit .= ' <li style="padding-left:50px;" class=" list-group-item '.$error.'">'.$k1.'=>'.$v1.'</li>';	
		}
		
	}
	$checkit .= "</ul>";
	
}
if($type == 'set_configs'){
	$error_nums = 0;
	
	$overwritesubmit ="<form method='post' action='?type=set_configs&do=overwrite&server=".$server."'>";
	foreach($_POST as $k=>$v){
		$overwritesubmit.="<input type='hidden' name='".$k."' value='".$v."'>";

	}
	$overwritesubmit.="<input type='submit' value='执行本次覆盖文件！'></form>";

	$h1 = "<h2>覆盖原来的配置文件！<small>拉到底，执行吧！</small></h2>";
}
if($error_nums){
	$has_error = "<div style='margin-top:20px;' class='alert alert-danger'>
	存在 $error_nums 处错误，这配置配的有问题啊！

	<a href='?type=fixed_configs&server=".$server."' style='margin-left:30px;color:blue;' onclick='return confirm(\"注意前方高能，修复神器提取完成！\");'>用神器修复吧！</a>
	</div>";

}else{
	$has_error = "<div style='margin-top:20px;' class='alert alert-success'>
	 	恭喜，配置文件全是正确的。

		 <a href='?type=fixed_configs&server=".$server."' style='margin-left:30px;color:blue;' onclick='return confirm(\"注意前方高能，修复神器提取完成！\");'>配置不对，我要修改！</a>
		</div>

	</div>";
}
 
echo <<<ETO
<!DOCTYPE html>
<html lang="zh-CN">
 
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<title>检测所有配置是否正确</title>
 
<style>
body{
	padding:20px;

}
</style>
<body>

<h1>特莱力商城 <small>配置文件检测</small> </h1><br>

		 

		 $has_error
		$h1


		
		   $checkit
		 
		$overwritesubmit

</body>

</html>
ETO;

























/**
  *  ＭＹＳＱＬ　数据库操作,本地SQL如果有错误会自动打开错误，线上无法打开错误信息。
  *
  *   
  * @time 2014-2015
  */
/** 
*  
* <code> 
*
*连接数据库
*DB::w(["mysql:dbname=hello;host=127.0.0.1","root","123456",'drupal']);
*
*主库
*DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test"])
*
*从库
*DB::r([ ["mysql:dbname=cdn;host=127.0.0.1","test","test"] ]);
*
*自定义连接数据库
*DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test" ,"user"])
*注意其中 user 当操作数据库时需要使用　DB::w('user')
*
*支持mysql 数据库。如order by ,
*请在 $db->table('table')->order_by('id desc');
*其他方法依次类推
*
*
*以下为操作数据库的具体事例
*
*主库
*$db = DB::w();
*
*从库
*$db = DB::r();　
*
*写入数据库记录
*echo $db->insert('posts',['name'=>'test']);
*	 	
*更新数据库记录
*$db->update('posts',['name'=>'abcaaa'],'id=?',[1]);
*	 	
*删除记录
*$db->delete('posts','id=?',[1]);
*
*打开DEBUG查看具体的sql,仅限本地使用。
*
*$db->log();
*$r = $db->table('posts')
*	->select('a.id,a.name')
*	->left_join('aa as b')
*	->on('b.id=a.id')
*	->where('a.name=?',['abc']) 
*	->or_where('a.name=?',['abc'])
*	->limit(10)
*	->offset(1)
*	->order_by('a.id asc')
*	->all(); 
*		
* 对应生成的sql如下
*
*	select a.id ,a.name from posts
*	left join aa as b 
*	on b.id = a.id
*	where a.name=?
*	or a.name = ?
*	limit 10
*	offset 1
*	order by a.id asc
*		
*输出数据库lgo	
*dump($db->log());
*			
*
*
*数据库查寻
*
*查寻一条记录
*$r = $db->table('posts')
*	->where('name=?',['abc'])  
*	->one();  
*
* 
*
*DB::w()->from(table)
*	->pager([
*	   'url'=>url,
*	   'page'=>10,
*	   'class'=>'pagination',
*	   'count'=>'count(*) num'
*	]);
*		
*IN 操作
*$in = [1,2];
*DB::w()->from('files')
*	->where('id in ('.DB::in($in).')',$in)
*	->all(); 
*
*按值排序
*DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)
*		->order_by("FIELD ( id ,".implode(',' , $in).") ")
*		->all(); 
*		
*
*指写入数据
*	DB::w()->insert_batch('user',[
*		 ['username'=>'admin','email'=>'test@msn.com'],
*		
*		  ['username'=>'admin','email'=>'test@msn.com'],
*	])
*
*
*导入文件到数据库　(如果要避免重复，需要设置唯一索引)
*	 DB::w()->load_file('test',WEB.'/1.csv',[
*		'body'
*	]); 
*		
*</code>
**/
 
class db{ 
	/**
	*　pdo句柄
	*/
	public $pdo; 
	/**
	* query
	*/
	public $query;
	/**
	* ar结构
	*/
	protected $ar;
	 
	/**
	* 日志
	*/
	static $log;
	static $debug = false;
	/**
	*sql 
	*/
	protected $sql;
	/**
	*sql对应的value
	*/
	protected $value;
	protected $key;
	/**
	* 数据库连接是否成功
	*/
	public $active = false;
	/**
	*where 条件
	*/
	public $where; 
	/**
	*　DSN连接信息
	*/
	protected $dsn;
	/**
	* 数据库用户名
	*/
	protected $user;
	/**
	*数据库密码
	*/
	protected $pwd;
	public $connect;
	 
	public $key_batch;
	static $mark = []; //记录所有连接的最后值
	/**
	* 从库
	*/
	static $read;
	/**
	* 主库
	*/
	static $write;
	/**
	*where 条件 
	*/
	static $_set_where;
 
	
	
	public $queryCount = 0;
	public $queries = array();
	  
	/**
	* mysql in() 特殊操作，由于pdo中使用占位符?
	*
	* DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)->all(); 
	*
	* @example 　
	*
	* $in = [1,2];
	*
	* DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)->all(); 
	*
	* @param array $name 　 
	* @return string
	*/ 
	static function in($name){
		return str_repeat ('?, ',  count ($name) - 1) . '?';
	}
	/**
	* 与table 方法相同
	* @example 　DB::w()->from(table)
	* @param string $table 　 
	* @return object
	*/
	function from($table){  
		$this->table($table);
		return $this;
	}
	 
	/**
	* 直接返回主键一行对象 无需要再加->one()
	* @example 　DB::w()->from(table)->pk(1);
	* @param int $id 　 
	* @return object
	*/
	function pk($id){
		return $this->where('id=?',[$id])->one();
	}
    
	/**
	* 构造函数
	* @param string $dsn 　  mysql:dbname=testdb;host=127.0.0.1
	* @param string $user 　  dbuser
	* @param string $pwd 　  dbpass
	* @return 
	*/
	public function __construct($dsn="mysql:dbname=test;host=127.0.0.1",
					$user="root",$pwd="111111",$exceptions = false){  
		try {
			$this->dsn = $dsn;
			$this->user = $user;
			$this->pwd = $pwd; 
		    $this->pdo = new PDO($dsn, $user, $pwd,[
		    	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
		    	PDO::ATTR_CASE => PDO::CASE_LOWER,
		     	PDO::ATTR_DEFAULT_FETCH_MODE =>  PDO::FETCH_OBJ,
		     	PDO::MYSQL_ATTR_LOCAL_INFILE => true,
		    ]);
		    $this->active = true;
		    $this->connect = [
		    	'dsn'=>$dsn,
		    	'user'=>$user,
		    	'pwd'=>$pwd,
		    	'active'=>$active, 
		    ];
		} catch (PDOException $e) { 
			$this->active = false; 
		} 
	} 
	/**
	* 设置从库的连接以及打开从库，随机打开一个从库连接
	* @example 设置从库　DB::r([ ["mysql:dbname=taijimr;host=127.0.0.1","test","test"] ]);
	* @example 读取从库　DB::r();
	* @param int $db　可指定要打开的从库的第几个 　 
	* @return DBobject
	*/
	static function r($db = NULL){
		if(!isset(static::$read)){
			$i = array_rand ($db , 1);
			$config = $db[$i];
			if(!$config)
				$config = $db; 
			static::$read = new Static($config[0],$config[1],$config[2]); 
		}
		$default = 'r'; 
		static::$mark[$default] = $default;
		unset(static::$read[$default]->ar,static::$read[$default]->where);
		return static::$read;
	}
	/**
	
	
	*/
	/**
	* 设置主库的连接以及打开从库，随机打开一个从库连接
	* @example 设置主库　DB::w(["mysql:dbname=taijimr;host=127.0.0.1","test","test"]);
	* @example 设置主库t　DB::w(["mysql:dbname=taijimr;host=127.0.0.1","test","test",'t']);
	*
	*
	* @example 读取主库　DB::w();
	* @example 读取主库t　DB::w('t');
	* @param string $config　指定打开哪个主库　默认 w　 
	* @return DBobject
	*/
	static function w($config='w'){
		if(is_array($config)) $default = $config[3]?:'w';
		else $default = $config;
		if(!isset(static::$write[$default])){  
			static::$mark[$default] = $default;
			static::$write[$default] = new Static($config[0],$config[1],$config[2],true);  
		} 
		unset(static::$write[$default]->ar,static::$write[$default]->where); 
		return static::$write[$default];
	}
	/**
	* 返回SQL 信息
	*  
 	* @example 　dump(DB::w()->log()); 
	* @return array
	*/	
	public function log(){
		 return static::$log;
	}
 
	/**
	* select 查寻字段
	* @example  DB::w()->select("id,name");
	* @param string $str　数据库中的字段以,分隔　 
	* @return DBobject
	*/
	public function select($str = "*"){
		$this->ar['SELECT'] = $str;
		return $this;
	}
	/**
	* 统计
	* @example  DB::w()->select("id,name")->count("count(*) num")->one();
	* @param string $str　count(*) num 
	* @return DBobject
	*/
	public function count($str = "count(*) num"){
		$this->ar['SELECT'] = $str;
		return $this;
	}
	/**
	* 内部函数 将 ['username'=>'admin','email'=>'test@msn.com'] 
	* 转换成 "username = ? ,email = ? " ,['admin' , 'test@msn.com']
	* @param array $arr 
	* @return void
	*/ 
	protected function _to_sql($arr){
		foreach($arr as $k=>$v){
			$key[] = "`".$k."`=? "; 
		} 
		$key = implode(",",$key);  
		$value = array_values($arr); 
		$this->key = $key;
		$this->value = $value;
	} 
	/**
	* 批量写入数据
	*
	* @example  
	*<code>
	*
	*	insert_batch('user',[
	*		['username'=>'admin','email'=>'test@msn.com'],
	* 		['username'=>'admin','email'=>'test@msn.com'],
	*	])
	*</code>
	* @param string $table
	* @param array $arr
	* @return object
	*/
	public function insert_batch($table,$arr = []){ 
		$this->_to_sql_batch($arr);
		$this->sql = "INSERT INTO $table ($this->key) $this->key_batch";   
		return $this->exec(true);
	} 
	/**
	* 内部函数
	*/
	protected function _to_sql_batch($arrs){ 
		$set_value = false;
		unset($this->key_batch);
		foreach($arrs as $arr){
			unset($vo,$vs);
			foreach($arr as $k=>$v){
				$key[$k] = "`".$k."`";   
				$vo[] = "?";
				$value[] = $v; 
			}   
			if(false === $set_value ) $vs = "values";  
			$this->key_batch[] = "$vs(".implode(',',$vo).") ";
			$set_value = true;
		}
		$key = implode(",",$key);   
		$this->key = $key;
		$this->key_batch = implode(",",$this->key_batch);   
		$this->value = $value;  
	}
	/**
	* 加载文件到数据库，导入大数据时使用
	* 如果要避免重复，需要设置唯一索引
	*
	* @example 
	*
	*<code>
	*
	*	DB::w()->load_file('test',WEB.'/1.csv',[
	*		'body'
	*	]); 
	*
	*</code>
	* @param string $str　count(*) num 
	* @return int
	*/
	public function load_file($table,$file,$data = [],$arr = [
		'FIELDS'=>',',
		'ENCLOSED'=>'\"',
		'LINES'=>'\r\n',
		'CHARACTER'=>"utf8",
		//'IGNORE'=>1,
	]){
		$file = str_replace('\\','/',$file);
		if($data){
			$filed = "(`".implode('`,`',$data);
			$filed .="`)"; 
		}
		foreach($arr as $k=>$v){
			$arr[strtoupper($k)] = $v;
		}
		$this->sql = "LOAD DATA LOCAL INFILE '".$file."' REPLACE INTO  TABLE ".$table."
		  CHARACTER SET ".$arr['CHARACTER']."
		  FIELDS TERMINATED BY '".$arr['FIELDS']."' ENCLOSED BY '".$arr['ENCLOSED']."'
		  LINES TERMINATED BY '".$arr['LINES'] ."' ".$filed;
		if($arr['IGNORE'])
			$this->sql .= " IGNORE ".$arr['IGNORE']." LINES;"; 
		return $this->exec(true); 
	}
	/**
	* 写入数据
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->insert('user',['username'=>'admin','email'=>'test@msn.com'])
	*
	*</code>
	* @param string $table　表名
	* @param array $arr　字段名对应值　
	* @return int
	*/
	public function insert($table,$arr = []){ 
		$this->_to_sql($arr);
		$this->sql = "INSERT INTO $table SET ".$this->key; 
		return $this->exec(true);
	} 
	/**
	* 删除数据
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->delete('posts','id=?',[1]); 
	*
	*</code>
	* @param string $table  表名
	* @param string $condition  　条件　
	* @param array $value   	条件对应的值，可为字符，多值时必须是数组
	* @return int
	*/
	public function delete($table,$condition=null,$value=[]){ 
		$this->sql = "DELETE FROM $table ";
		if($condition)
			$this->sql .= "WHERE $condition ";
		if($value){
			if(!is_array($value)) $value = [$value];
			$this->_to_sql($value); 
		}   
		return $this->exec();
	}
	/**
	* 更新数据
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->update('posts',['name'=>'abc2'],'id=?',[1]); 
	*
	*</code>
	* @param string $table  表名
	* @param array $set  更新　字段对应值　
	* @param string $condition  　条件　
	* @param array $value   	条件对应的值，可为字符，多值时必须是数组
	* @return int
	*/
	public function update($table,$set = [] ,$condition=null,$value=[]){
		$this->_to_sql($set);
		$this->sql = "UPDATE $table SET ".$this->key;
		if($condition)
			$this->sql .= "WHERE $condition ";
		if($value){
			if(!is_array($value)) $value = [$value];
 			$this->value = array_merge($this->value,$value);
		}  
		return $this->exec();
	}
	/**
	* 表名
	* 　
	* @param string $table  表名
	*
	* @return object
	*/
	public function table($table){ 
		$this->ar['TABLE'] = $table; 
		return $this;
	}
	/**
	* 执行查寻一条记录
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->table('user')->one();
	*
	*</code>
	*
	* @return object
	*/
	public function one(){
		$this->_query();
		return $this->query->fetch(PDO::FETCH_OBJ);
	}
 	/**
	* 执行查寻多条条记录
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->table('user')->all();
	*
	*</code>
	*
	* @return object
	*/
	public function all(){
		$this->_query(); 
		return $this->query->fetchAll(); 
	}
	/**
	* 支持纯SQL,直接返回查寻的结果集对象
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->sql('select * from user where id=?',1); 
	*
	*</code>
	* @param string $sql 完整的ＳＱＬ
	* @param array $value  pdo bind value
 	*
	* @return object
	*/
	public function sql($sql,$value=null){
		$this->sql = $sql;
		if($value && !is_array($value)) $value = [$value];
		$this->value = $value;   
		$this->exec(); 
		return $this;
	}
	/**
	* 内部函数
	*/
	protected function _query($keep_ar = false){  
		static::$_set_where = false;
		$value = [];
		if(!$this->ar['TABLE']) return $this;
		$sql = "select ".($this->ar['SELECT']?:'*')." FROM ".$this->ar['TABLE'];
		$s = $this->ar['SELECT'];
		$t = $this->ar['TABLE'];
		unset($this->ar['SELECT'],$this->ar['TABLE']); 
 		if($this->ar){
			foreach($this->ar AS $key=>$condition){
				if(strpos($key,'WHERE')!==false && static::$_set_where===false){
					$sql .= " WHERE 1=1  "; 
					static::$_set_where = true;
				}
				if(is_array($condition)){
					foreach($condition as $str=>$vo){
				 		$sql .= " ". $k." ".$str." "; 
				 	 	$value = array_merge($value,$vo);
				 	}
				}else{
					if(strpos($key,'WHERE')!==false)
						 $sql .= " ". $condition." ";
					else
						$sql .= " ".$key." ". $condition." ";
			 	}
			}
		}   
		//使用后要删除 $this->ar
		if(false === $keep_ar){
			unset($this->ar,$this->where); 
		}else{
			$this->ar['SELECT'] = "*";
			$this->ar['TABLE'] = $t;
		}
		$this->sql = $sql;
		$this->value = $value;   
		$this->exec(); 
		return $this;
	 
	}
	/**
	*　内部函数
	*/
	protected function exec($insert = false){  
		//记录日志 
		$log = ['sql'=>$this->sql,'value'=>$this->value];
		static::$log[] = $log; 
		
		
		/**** profile log  ***/
		if(static::$debug === true){
			$start = $this->getTime();
		}
		/**** profile log end ***/
		
		
		$this->query = $this->pdo->prepare($this->sql , [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);  
		$execute = $this->query->execute( $this->value );
		$last_id = $this->pdo->lastInsertId();  
		
		/**** profile log  ***/
		if(  static::$debug === true ){
		 	$this->queryCount += 1; 
			$query = $this->pdo->prepare("EXPLAIN ".$this->sql , [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
			$explain = $query->execute( $this->value ); 
		 

			 

		}

		/**** profile log end ***/
		
		
        if(!$execute){ 
        	$info = $this->query->errorInfo()[2];  
        	 
         	if(static::$debug === true ){  
         		static::$log['errors'][] = $info;
         		$errors = $this->sql;
         		if($this->value){
         			$errors.="\n Value:".json_encode($this->value);
         		}
         		throw new \Exception('SQL ERROR:'.$info."<br>".$errors,400);
        	}
        	return false;
        }
        
	    return $last_id?:null; 
	}
	static $space = 0;
	/**
	*　方法名不存在时，执行该函数. 支持mysql更多的方法
	*/
	public function __call ($name ,$arg = [] ){ 
		$name = strtoupper($name);
		$key = $arg[0];
		$vo = $arg[1];
		if($name=='WHERE') $name = "AND_WHERE";
		$name = str_replace('_',' ',$name);  
		if(strpos($name,'WHERE')!==false){  
			$arr = explode(' ',$name);
			$key = $arr[0]." ".$key;
			if(!is_array($vo)) $vo = [$vo];
		} 
		self::$space++;

		for($i=0;$i<self::$space;$i++){
			$span .=" ";
		}
		$key = $span. $key;

		if($vo){
			$this->ar[$name][$key] = $vo;

		}else if($key){  
			$this->ar[$name] = $key;
		}
		 
		return $this;
	} 
}
 
/**
  *   File 操作  
  *
  * 
  * @author Sun <sunkang@wstaichi.com>
  * @copyright http://www.wstaichi.com 
  * @time 2014-2015
  */
 
class file
{  
 	static $obj = [];  
	 
	/**
	* 查看目录下的所有目录及文件
	* 
	*
	* @example  File::find($dir , $find="*" )   
	* @param string $dir 目录 
	* @param string $find 　 所有文件,默认为*
	* @return void
	*/
	static function find($dir,$find='*'){
		$ar = static::__find($dir,$find);   
 	 	static::$obj = [];
 	    return $ar;
	} 
	 
	/**
	* 内部使用,查看目录下的所有目录及文件
	*/	
	static function __find($dir_path,$find='*'){
		static::$obj['dir'][] = $dir_path;
		foreach(glob($dir_path."/*") as $v){ 
			if(is_dir($v)){
				static::$obj['dir'][] = $v;
				static::__find($v,$find);
			}else{
				if($find != '*'){
					if(strpos($v,$find)!==false){
						static::$obj['file'][] = $v;
					}  
				}else{
					static::$obj['file'][] = $v;
				}
				
			} 
		}    
	 	return static::$obj;
	}
	
	 
   
     
	 
	/**
	* 取文件名　返回类似 1.jpg
	* 
	*
	* @param string $name  
	* @return string
	*/
	static function name($name){ 
		return substr($name,strrpos($name,'/')+1); 
	}
 
	/**
	* 返回后缀 如.jpg 
	* 
	*
	* @param string $url 　 
	* @return string
	*/
	static function ext($url){
		if(strpos($url,'?')!==false){
			$url = substr($url,0,strrpos($url,'?'));
		}
		return substr($url,strrpos($url,'.')+1); 
	} 
	/**
	* 反射class取文件名
	*/
	function file_name($class = null){
		$reflector = new \ReflectionClass($class);
		return  $reflector->getFileName();
	}
	/**
	* 返回文件目录，不包括文件名
	* 
	*
	* @param string $file_name 　 
	* @return string
	*/
	static function dir($file_name){ 
		return substr($file_name,0, strrpos($file_name,'/'));
	}
	 
 
   
   
}