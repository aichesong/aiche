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
                <h3>互联登录&nbsp;</h3>
                <h5>公共平台账号登录配置</h5>
            </div>
            <ul class="tab-base nc-row">
                <li><a class="current"><span>互联登录</span></a></li>
            </ul>
        </div>
    </div>
    <?php

  ?>
    <!-- 操作说明 -->

    <p class="warn_xiaoma"><span></span><em></em></p>
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em>
        </div>
        <ul>
            <li>可以将其它大型平台的登录方式和Ucenter进行整合,实现微信,新浪微薄等等可以在网站前台快速登录。</li>
        </ul>
    </div>

    <form method="post" id="connect-qq-setting-form" name="settingForm">
        <input type="hidden" name="config_type[]" value="connect"/>

        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="site_name">QQ AppId</label>
                </dt>
                <dd class="opt">
                    <input id="qq_app_id" name="connect[qq_app_id]" value="<?=($data['qq_app_id']['config_value'])?>" class="w400 ui-input " type="text"/>

                    <p class="notic">[<a href="http://connect.qq.com/">申请API</a>]</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="site_name">QQ AppKey</label>
                </dt>
                <dd class="opt">
                    <input id="qq_app_key" name="connect[qq_app_key]" value="<?=($data['qq_app_key']['config_value'])?>" class="w400 ui-input " type="text"/>
                    <p class="notic"></p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="site_name">是否开启</label>
                </dt>
                <dd class="opt">
                        <input id="qq_status" name="connect[qq_status]"  value="1" type="radio" <?=($data['qq_status']['config_value']=='1' ? 'checked' : '')?>>
						<label title="开启"  for="qq_status">开启QQ互联</label>

						&nbsp;&nbsp;
                        <input id="qq_status" name="connect[qq_status]"  value="0" type="radio" <?=($data['qq_status']['config_value']=='1' ? '' : 'checked')?>>
						<label title="开启"  for="qq_status">关闭QQ互联</label>
                    <p class="notic"></p>
                </dd>
            </dl>
            <div class="bot"><a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">确认提交</a></div>
        </div>
    </form>

   <form method="post" id="connect-weibo-setting-form" name="settingForm">
        <input type="hidden" name="config_type[]" value="connect"/>

        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="site_name">Weibo AppId</label>
                </dt>
                <dd class="opt">
                    <input id="weibo_app_id" name="connect[weibo_app_id]" value="<?=($data['weibo_app_id']['config_value'])?>" class="w400 ui-input " type="text"/>

                    <p class="notic">[<a href="http://open.weibo.com/connect">申请API</a>]</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="site_name">Weibo AppKey</label>
                </dt>
                <dd class="opt">
                    <input id="weibo_app_key" name="connect[weibo_app_key]" value="<?=($data['weibo_app_key']['config_value'])?>" class="w400 ui-input " type="text"/>
                    <p class="notic"></p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="site_name">是否开启</label>
                </dt>
                <dd class="opt">
                        <input id="weibo_status" name="connect[weibo_status]"  value="1" type="radio" <?=($data['weibo_status']['config_value']=='1' ? 'checked' : '')?>>
						<label title="开启"  for="weibo_status">开启Weibo互联</label>
                        &nbsp;&nbsp;<input id="weibo_status" name="connect[weibo_status]"  value="0" type="radio" <?=($data['weibo_status']['config_value']=='1' ? '' : 'checked')?>>
						<label title="关闭"  for="weibo_status">关闭Weibo互联</label>
                    <p class="notic"></p>
                </dd>
            </dl>
            <div class="bot"><a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">确认提交</a></div>
        </div>
    </form>


    <form method="post" id="connect-weixin-setting-form" name="settingForm">
        <input type="hidden" name="config_type[]" value="connect"/>

        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="site_name">Weixin AppId</label>
                </dt>
                <dd class="opt">
                    <input id="weixin_app_id" name="connect[weixin_app_id]" value="<?=($data['weixin_app_id']['config_value'])?>" class="w400 ui-input " type="text"/>

                    <p class="notic">[<a href="http://open.weixin.qq.com">申请API</a>]</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="site_name">Weixin AppKey</label>
                </dt>
                <dd class="opt">
                    <input id="weixin_app_key" name="connect[weixin_app_key]" value="<?=($data['weixin_app_key']['config_value'])?>" class="w400 ui-input " type="text"/>
                    <p class="notic"></p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="site_name">是否开启</label>
                </dt>
                <dd class="opt">
                        <input id="weixin_status" name="connect[weixin_status]"  value="1" type="radio" <?=($data['weixin_status']['config_value']=='1' ? 'checked' : '')?>>
						<label title="开启"  for="weixin_status">开启Weixin互联</label>
						&nbsp;&nbsp;
                        <input id="weixin_status" name="connect[weixin_status]"  value="0" type="radio" <?=($data['weixin_status']['config_value']=='1' ? '' : 'checked')?>>
						<label title="关闭"  for="weixin_status">关闭Weixin互联</label>
                    <p class="notic"></p>
                </dd>
            </dl>
            <div class="bot"><a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">确认提交</a></div>
        </div>
    </form>

</div>

<script type="text/javascript">
</script>
<script type="text/javascript" src="<?=$this->view->js?>/controllers/config.js" charset="utf-8"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>