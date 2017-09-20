<?php if (!defined('ROOT_PATH')) {exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/'  . 'header.php';
?>
<link href="<?=$this->view->css?>/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?=$this->view->css_com?>/jquery/plugins/validator/jquery.validator.css">
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>
</head>
<body>
<div class="wrapper page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>基础设置&nbsp;</h3>
                <h5>网站全局内容基本选项设置</h5>
            </div>
            <ul class="tab-base nc-row">
                <li><a class="current" href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=ucenterApi&config_type%5B%5D=api"><span>本系统 API设置</span></a></li>
                <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=site&config_type%5B%5D=site"><span>基础设置</span></a></li>
                <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=settings&typ=e&config_type%5B%5D=site"><span>站点Logo</span></a></li>
                <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=avatar&typ=e&config_type%5B%5D=site"><span>用户默认头像</span></a></li>
                <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=seo&typ=e&config_type%5B%5D=seo"><span>SEO配置</span></a></li>
            </ul>
        </div>
    </div>
    <?php

  ?>
    <!-- 操作说明 -->
    <p class="warn_xiaoma"><span></span><em></em></p><div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em></div>
        <ul>
            <li>我们的商城系统在开发的时候,网站前台与后台进行了独立开发独立部署的设计理念,这样便于各个子系统与管理员后台进行分布式多台服务器上部署成为可能。
                提高了系统的抗压能力与安全等级。在这里可以配置商城系统与各子系统之间通讯的API与Key值配置</li>
        </ul>
    </div>
    <form method="post" id="ucenter-shop_api-setting-form" name="ucenterSettingForm">
        <input type="hidden" name="config_type[]" value="ucenter_api"/>

        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="site_name">Ucenter URL</label>
                </dt>
                <dd class="opt">
                    <input id="ucenter_api_url" name="ucenter_api[ucenter_api_url]" value="<?=Yf_Registry::get('ucenter_api_url')?>" class="w400 ui-input " type="text"/>

                    <p class="notic">Ucenter又称大用户中心,是我们开发的用于整合多个子系统用户的独立用户中心系统,实现用户的单点登录和登出,用户的统一化管理。</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="site_name">Ucenter key</label>
                </dt>
                <dd class="opt">
                    <input id="ucenter_api_key" name="ucenter_api[ucenter_api_key]" value="<?=Yf_Registry::get('ucenter_api_key')?>" class="ui-input w400" type="text"/>

                    <p class="notic">请填写商城系统与Ucenter通讯的Key值,此处的值要与Ucenter后台应用的值保持一致</p>
                </dd>
            </dl>
	
			<dl class="row">
				<dt class="tit">
					<label for="site_name">Ucenter后台 URL</label>
				</dt>
				<dd class="opt">
					<input id="ucenter_admin_api_url" name="ucenter_api[ucenter_admin_api_url]" value="<?= Yf_Registry::isRegistered('ucenter_admin_api_url') ? Yf_Registry::get('ucenter_admin_api_url') : ''?>" class="w400 ui-input " type="text"/>
			
					<p class="notic"></p>
				</dd>
			</dl>
			
            <div class="bot"><a href="javascript:void(0);" class="ui-btn ui-btn-sp ucenter-submit-btn">确认提交</a></div>
        </div>
    </form>

</div>

<script type="text/javascript">
</script>
<script type="text/javascript" src="<?=$this->view->js?>/controllers/config.js" charset="utf-8"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>