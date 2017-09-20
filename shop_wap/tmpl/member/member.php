<?php 
include __DIR__.'/../../includes/header.php';
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="msapplication-tap-highlight" content="no">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1">
<title>我的商城</title>
<link rel="stylesheet" type="text/css" href="../../css/base.css">
<link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
</head>
<body>
<header id="header" class="transparent">
    <div class="header-wrap">
        <!-- <div class="header-l"> <a href="member_account.html"> <i class="set"></i> </a> </div> -->
        <div class="header-l">
            <a href="javascript:history.go(-1)">
                <i class="back back2"></i>
            </a>
        </div>
        <div class="header-title">
            <h1>我的商城</h1>
        </div>
        <div class="header-r"> <a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
    </div>
    <div class="nctouch-nav-layout">
        <div class="nctouch-nav-menu"> <span class="arrow"></span>
            <ul>
                <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                 <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                 <li><a href="javascript:;"><i class="mall"></i>我的商城</a></li>
                <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
            </ul>
        </div>
    </div>
</header>
<div class="scroller-body mrb300">
    <div class="scroller-box">
        <div class="member-top member-top1"></div>
        <div class="member-collect borb1"></div>
        <div class="member-center bort1 mt5 ">
            <dl>
                <dt><a href="order_list.html">
                    <h3>我的订单</h3>
                    <h5>查看全部订单<i class="arrow-r"></i></h5>
                </a></dt>
                <dd>
                    <ul id="order_ul">
                    </ul>
                </dd>
            </dl>
            <dl class="mt5 bort1">
                <dt><a id="paycenter">
                    <h3><i class="mc-02"></i>我的财产</h3>
                    <h5>查看全部财产<i class="arrow-r"></i></h5>
                </a></dt>
                <dd>
                    <ul class="property-overview">
                        <li>
                            <h3><i></i><span>余额</span></h3>
                            <strong id="user_money">￥1200</strong>
                        </li>
                        <li>
                            <h3><i></i><span>积分</span></h3>
                            <strong id="user_points">800</strong>
                        </li>
                    </ul>
                </dd>
                <!--  <dt><a href="../cart_list.html">
                    <h3><i class="mc-02"></i>我的购物车</h3>
                    <h5>查看购物车<i class="arrow-r"></i></h5>
                </a></dt> -->
            </dl>
            <dl class="bort1">
                 <dt><a href="member_voucher.html">
                    <h3><i class="mc-03"></i>代金券</h3>
                    <h5><i class="arrow-r"></i></h5>
                </a></dt>
            </dl>
            <dl class="mt5 bort1">
                <dt><a href="address_list.html">
                    <h3><i class="mc-04"></i>收货地址管理</h3>
                    <h5><i class="arrow-r"></i></h5>
                </a></dt>
            </dl>
            <dl style="border-top: solid 0.05rem #EEE;">
                <dt><a href="member_account.html">
                    <h3><i class="mc-05"></i>用户设置</h3>
                    <h5><i class="arrow-r"></i></h5>
                </a></dt>
            </dl>
            <!-- <dl style="border-top: solid 0.05rem #EEE;" class="mt5">
                <dt><a href="directseller.php">
                    <h3><i class="mc-06"></i>分销中心</h3>
                    <h5><i class="arrow-r"></i></h5>
                </a></dt>
            </dl>-->
        </div>
    </div>
    <footer id="footer"></footer>
    <!-- 底部 -->
    <?php 
    include __DIR__.'/../../includes/footer_menu.php';
    ?>
</div>

<script type="text/javascript" src="../../js/zepto.js"></script> 
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/tmpl/member.js"></script>
<script type="text/javascript" src="../../js/tmpl/footer.js"></script>


</body></html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>