<?php 
include __DIR__.'/../../includes/header.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>订单退款</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
</head>
<body>
<header id="header">
    <div class="header-wrap">
        <div class="header-l"> <a href="javascript:history.go(-1)"> <i class="back"></i> </a> </div>
        <div class="header-title">
            <h1>订单退款</h1>
        </div>
        <div class="header-r"> <a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
    </div>
    <div class="nctouch-nav-layout">
        <div class="nctouch-nav-menu"> <span class="arrow"></span>
            <ul>
                <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
            </ul>
        </div>
    </div>
</header>
<div class="nctouch-main-layout mb20">
    <div class="nctouch-order-list" id="order-info-container"></div>
    <div class="special-tips">
        <!--<p>特别提示：退款凭证选择直接拍照或从手机相册上传图片时，请注意图片尺寸控制在1M以内，超出请压缩裁剪后再选择上传！</p>-->
        <p id="allow_refund_amount" style="text-align: center;"></p>
    </div>
    <form>
        <div class="nctouch-inp-con">
            <ul class="form-box">
                <li class="form-item">
                    <h4>退款原因</h4>
                    <div class="input-box">
                        <!--<input type="text" class="inp" value="取消订单，全部退款" readonly="readonly">-->
                        <select id="res_content" class="select" name="return_reason_id"></select>
                    </div>
                </li>
                <li class="form-item">
                    <h4>退款金额</h4>
                    <div class="input-box">
                        <input id="return_cash" name="return_cash" type="text" class="inp" value="">
                    </div>
                </li>
                <li class="form-item">
                    <h4>退款说明</h4>
                    <div class="input-box">
                        <input type="text" class="inp" name="return_message" placeholder="申请原因！">
                    </div>
                </li>
                <!--<li class="form-item upload-item">
                    <h4>退款凭证</h4>
                    <div class="input-box">
                        <div class="nctouch-upload"> <a href="javascript:void(0);"> <span>
              <input type="file" hidefocus="true" size="1" class="input-file" name="refund_pic" id="">
              </span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                            <input type="hidden" name="refund_pic[0]" value="" />
                        </div>
                        <div class="nctouch-upload"> <a href="javascript:void(0);"> <span>
              <input type="file" hidefocus="true" size="1" class="input-file" name="refund_pic" id="">
              </span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                            <input type="hidden" name="refund_pic[1]" value="" />
                        </div>
                        <div class="nctouch-upload"> <a href="javascript:void(0);"> <span>
              <input type="file" hidefocus="true" size="1" class="input-file" name="refund_pic" id="">
              </span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                            <input type="hidden" name="refund_pic[2]" value="" />
                        </div>
                    </div>
                </li>-->
            </ul>
            <div class="error-tips"></div>
            <div class="form-btn"><a href="javascript:;" class="btn-l">提交</a></div>
        </div>
    </form>
</div>
<footer id="footer"></footer>
<script type="text/html" id="order-info-tmpl">
    <div class="nctouch-order-item mt5">
        <div class="nctouch-order-item-head">
            <a href="<%=WapSiteUrl%>/tmpl/store.html?store_id=<%=order.shop_id%>" class="store"><i class="icon"></i><%=order.shop_name%><i class="arrow-r"></i></a>
        </div>
        <div class="nctouch-order-item-con">
            <%for(i=0; i<goods_list.length; i++){%>
            <div class="goods-block detail">
                <a href="<%=WapSiteUrl%>/tmpl/product_detail.html?goods_id=<%=goods_list[i].goods_id%>">
                    <div class="goods-pic">
                        <img src="<%=goods_list[i].goods_image%>">
                    </div>
                    <dl class="goods-info">
                        <dt class="goods-name"><%=goods_list[i].goods_name%></dt>
                        <!--<dd class="goods-type"><%=goods_list[i].goods_spec%></dd>-->
                    </dl>
                    <div class="goods-subtotal">
                        <span class="goods-price">￥<em><%=goods_list[i].goods_price%></em></span>
                        <span class="goods-num">x<%=goods_list[i].order_goods_num%></span>
                    </div>
                </a>
            </div>
            <%}%>
        </div>
    </div>
</script>
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>

<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/tmpl/refund_all.js"></script>
</body>
</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>