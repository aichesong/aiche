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
    <%if(data.length > 0){%>
        <ul class="nctouch-evaluation-goods">
            <%for(var i=0; i<data.length; i++){%>
            <% if(data[i].length > 1){ %>
                <%for(var j=0; j<data[i].length; j++){ %>
                    <li>
                        <%if(j>0){%><span>追加评价</span><%}%>
                        <div class="evaluation-info">
                            <div class="goods-pic">
                                <img src="<%=data[i][j].goods_image%>"/>
                            </div>
                            <dl class="goods-info">
                                <dt class="goods-name"><%=data[i][j].goods_name%></dt>
                                <dd class="goods-rate">￥<%=data[i][j].goods_price%></dd>
                            </dl>
                        </div>
                        <div class="evaluation-inp-block">
                            <dl class="evalu-again">
                                <dt>
                                    <span>评论时间：<%=data[i][j].create_time%></span>
                                    <span class="evalu-again-tit">商品评价：<div class="goods-raty"><i class="star<%=data[i][j].scores%>"></i></div></span>
                                </dt>
                            </dl>
                            <% if(data[i][j].content){%>
                            <textarea class="text-area" readonly="readonly"><%=data[i][j].content%></textarea>
                            <% }%>
                            <!-- <input type="text" class="textarea" value="<%=data[i].content%>"> -->
                            <input type="hidden" class="evaluation_goods_id" name="evaluation_goods_id" value="<%=data[i][j].evaluation_goods_id%>"/>
                        </div>
                        <div class="evaluation-upload-block">
                            <div class="potimg-again-tit"><p>晒&nbsp;图：</p></div>
                            <div class="clearfix">
                                <% for(k=0;k < data[i][j].image_row.length;k++){ %>
                                <div class="goods_geval">
                                    <img src="<%=data[i][j].image_row[k]%>">
                                </div>
                                <% } %>
                            </div>
                        </div>
                    </li>
                    <% } %>
                <%}else{%>
            <%for(var j=0; j<data[i].length; j++){ %>
            <li>
                <div class="evaluation-info">
                    <div class="goods-pic">
                        <img src="<%=data[i][j].goods_image%>"/>
                    </div>
                    <dl class="goods-info">
                        <dt class="goods-name"><%=data[i][j].goods_name%></dt>
                        <dd class="goods-rate">￥<%=data[i][j].goods_price%></dd>
                    </dl>
                </div>
                <div class="evaluation-inp-block">
                    <dl class="evalu-again">
                        <dt>
                            <span>评论时间：<%=data[i][j].create_time%></span>
                            <span class="evalu-again-tit">商品评价：<div class="goods-raty"><i class="star<%=data[i][j].scores%>"></i></div></span>
                        </dt>
                    </dl>
                    <% if(data[i][j].content){%>
                    <textarea class="text-area" readonly="readonly"><%=data[i][j].content%></textarea>
                    <% }%>
                    <!-- <input type="text" class="textarea" value="<%=data[i].content%>"> -->
                    <input type="hidden" class="evaluation_goods_id" name="evaluation_goods_id" value="<%=data[i][j].evaluation_goods_id%>"/>
                </div>
                <div class="evaluation-upload-block">
                    <div class="potimg-again-tit"><p>晒&nbsp;图：</p></div>
                    <div class="clearfix">
                        <% for(k=0;k < data[i][j].image_row.length;k++){ %>
                        <div class="goods_geval">
                            <img src="<%=data[i][j].image_row[k]%>">
                        </div>
                        <% } %>
                    </div>
                </div>
                <a class="btn-l mt5 mb5">追加评价</a>
            </li>
            <%}%>
            <%}%>
            <%}%>
        </ul>
            <%}%>
</script>
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>

<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/tmpl/member_evaluation_again.js"></script>
<script type="text/javascript" src="../../js/tmpl/footer.js"></script>
</body>
</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>