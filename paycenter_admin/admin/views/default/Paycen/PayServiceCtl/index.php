<?php if (!defined('ROOT_PATH')) exit('No Permission');?>
<?php
include TPL_PATH . '/'  . 'header.php';
?>

</head>


<div class="wrapper page">
   <p class="warn_xiaoma"><span></span><em></em></p>
  <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span><em class="close_warn">X</em>
        </div>
        <ul>
            <li></li>
            <li></li>
        </ul> 
  </div>
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>服务费配置</h3>
        <h5>服务费配置情况总览</h5>
      </div>
      <ul class="tab-base nc-row">
          <li><a href="index.php?ctl=Paycen_PayWithdraw&met=index"><span>提现申请</span></a></li>
          <li><a class="current"><span>服务费配置</span></a></li>
      </ul>
    </div>
  </div>
  <div class="ncap-form-default">
  <div class="mod-search cf">
<!--    <div class="fl">
      <ul class="ul-inline">
        <li>
          <input type="text" id="userName" class="ui-input ui-input-ph con" value="请输入会员名称">
        </li>
        <li>
          <label>注册时间:</label>
          <input type="text" id="beginDate" value="2015-12-02" class="ui-input ui-datepicker-input">
          <i>-</i>
          <input type="text" id="endDate" value="2015-12-08" class="ui-input ui-datepicker-input">
        </li>
        <li><a class="ui-btn" id="search">查询<i class="iconfont icon-btn02"></i></a></li>
      </ul>
    </div>-->
    <div class="fr">
        <a class="ui-btn ui-btn-sp mrb" id="btn-add">新增<i class="iconfont icon-btn03"></i></a>
        <a href="javascript:void(0)" class="ui-btn" id="btn-refresh">刷新<i class="iconfont icon-btn01"></i></a>
      </div>
</div> 
<div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
  </div>
 
</div>
<script src="./admin/static/default/js/controllers/payservice/payservice_list.js"></script>
<?php
include TPL_PATH . '/'  . 'footer.php';
?>