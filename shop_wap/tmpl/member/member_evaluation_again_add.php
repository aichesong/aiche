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
    <title>追加评价</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
</head>
<body>
<header id="header">
    <div class="header-wrap">
        <div class="header-l"> <a href="javascript:history.go(-1)"> <i class="back"></i> </a> </div>
        <div class="header-title">
            <h1>追加评价</h1>
        </div>
    </div>
</header>
<div class="nctouch-main-layout" id="member-evaluation-div"> </div>
<footer id="footer" class="posr"></footer>
<script type="text/html" id="member-evaluation-script">
    <div class="special-tips">
        <p>特别提示：评价晒图选择直接拍照或从手机相册上传图片时，请注意图片尺寸控制在1M以内，超出请压缩裁剪后再选择上传！</p>
    </div>
    <form>
        <ul class="nctouch-evaluation-goods">
            <li>
                <div class="evaluation-info">
                    <div class="goods-pic">
                        <img src="<%=data.goods_image%>"/>
                    </div>
                    <dl class="goods-info">
                        <dt class="goods-name"><%=data.goods_name%></dt>
                        <dd class="goods-rate">评价内容</dd>
                    </dl>
                </div>
                <div class="evaluation-inp-block">
                    <input type="text" class="textarea" id="content" name="content" placeholder="亲，写点什么吧，您的意见对其他买家有很大帮助！">
                    <input type="hidden" name="evaluation_goods_id" id="evaluation_goods_id" value="<%=data.evaluation_goods_id%>"/>
                    <input type="hidden" name="order_goods_id" id="order_goods_id" value="<%=data.goods_base.order_goods_id%>"/>
                </div>
                <div class="evaluation-upload-block">
                    <div class="tit"><i></i><p>晒&nbsp;图</p></div>
                    <div class="nctouch-upload">
                        <a href="javascript:void(0);">
                            <span><input type="file" hidefocus="true" size="1" class="input-file" name="upfile" id=""></span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                        <input type="hidden" name="goods[evaluate_image][0]" class="evaluate_image_0" value="" />
                    </div>
                    <div class="nctouch-upload">
                        <a href="javascript:void(0);">
                            <span><input type="file" hidefocus="true" size="1" class="input-file" name="upfile" id=""></span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                        <input type="hidden" name="goods[evaluate_image][1]" class="evaluate_image_1" value="" />
                    </div>
                    <div class="nctouch-upload">
                        <a href="javascript:void(0);">
                            <span><input type="file" hidefocus="true" size="1" class="input-file" name="upfile" id=""></span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                        <input type="hidden" name="goods[evaluate_image][2]" class="evaluate_image_2" value="" />
                    </div>
                    <div class="nctouch-upload">
                        <a href="javascript:void(0);">
                            <span><input type="file" hidefocus="true" size="1" class="input-file" name="upfile" id=""></span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                        <input type="hidden" name="goods[evaluate_image][3]" class="evaluate_image_3" value="" />
                    </div>
                    <div class="nctouch-upload">
                        <a href="javascript:void(0);">
                            <span><input type="file" hidefocus="true" size="1" class="input-file" name="upfile" id=""></span>
                            <p><i class="icon-upload"></i></p>
                        </a>
                        <input type="hidden" name="goods[evaluate_image][4]" class="evaluate_image_4" value="" />
                    </div>
                </div>
            </li>
        </ul>
        <a class="btn-l mt5 mb5">提交</a>
        <form>
</script>
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>

<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/tmpl/member_evaluation_again_add.js"></script>
<script type="text/javascript" src="../../js/tmpl/footer.js"></script>
</body>
</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>