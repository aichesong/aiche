<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
} ?>
<?php
include $this->view->getTplPath() . '/' . 'header.php';

// 当前管理员权限
$admin_rights = $this->adminRights;
// 当前页父级菜单 同级菜单 当前菜单
$menus = $this->adminMenus;
?>
<link href="<?= $this->view->css ?>/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?= $this->view->css_com ?>/jquery/plugins/validator/jquery.validator.css">
<script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>
<style>
	
	.dx-warning {
		background: #FFF;
		border: 5px solid #ffba00;
		padding: 20px;
		margin-bottom: 30px
	}
	
	.dx-warning h2 {
		margin: 0;
		margin-bottom: 20px;
		padding-bottom: 15px;
		border-bottom: 2px solid #f0f0f0
	}
	
	.dx-warning ol {
		margin-top: 20px
	}
	
	.dx-warning li {
		margin: 5px 0
	}

</style>
</head>
<body>
<div class="wrapper page">
	<div class="fixed-bar">
		<div class="item-title">
			<div class="subject">
				<h3>系统工具&nbsp;</h3>
				<h5>更新</h5>
			</div>
			<ul class="tab-base nc-row">
				<li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=plugin"><span>插件管理</span></a></li>
				<li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=cacheManage"><span>清理缓存</span></a></li>
				<li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=validator"><span>程序检测</span></a></li>
				<li><a class="current" ><span>更新管理中心</span></a></li>
                <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=updateShop"><span>更新商城</span></a></li>
			</ul>
		</div>
	</div>

	<!-- 操作说明 -->
	<p class="warn_xiaoma"><span></span><em></em></p>
	<div class="explanation" id="explanation">
		<div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
			<h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
			<span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em></div>
		<ul>
			<li></li>
			<li>&nbsp;</li>
		</ul>
	</div>
	
	<?php
	if ( $update )
	{
		ob_end_flush();
		
		
		$allow_relaxed_file_ownership = false;
		
		
		try{
			
			$result = $upgrader->upgrade( $update, array(
				'allow_relaxed_file_ownership' => $allow_relaxed_file_ownership
			) );
			
			
			$time = 2;
			$url = "<?= Yf_Registry::get('url') ?>?ctl=Config&met=update";
			
			//header("Refresh:{$time}; url={$url}");
			
		}
		catch(Exception $e)
		{
		    update_feedback($e->getMessage());
		    update_feedback('<p>安装失败！</p>');
		    update_feedback('<p><a class="ui-btn" id="reinstall">重新安装<i class="iconfont"></i></a></p>');
			//print_r($e->getMessage());
		}
	}
	?>

</div>


<script>
    $('#reinstall').on("click", function (e)
    {
        window.location.href = "<?= Yf_Registry::get('url') ?>?ctl=Config&met=update&upgrade=1";
    });


</script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>


