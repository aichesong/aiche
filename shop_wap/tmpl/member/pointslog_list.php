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
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>积分明细</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
</head>

<body>
    <header id="header">
        <div class="header-wrap">
            <div class="header-l"><a href="javascript:history.go(-1)"><i class="back"></i></a></div>
            <div class="header-title">
                <h1>积分明细</h1>
            </div>
            <div class="header-r"> <a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
        </div>
        <div class="nctouch-nav-layout">
            <div class="nctouch-nav-menu"> <span class="arrow"></span>
                <ul>
                    <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                    <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                    <li><a href="member.html"><i class="member"></i>我的商城</a><sup></sup></li>
                    <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="nctouch-main-layout">
        <div id="pointscount" class="nctouch-asset-info"></div>
        <ul id="pointsloglist" class="nctouch-log-list">
        </ul>
    </div>
    <footer id="footer" class="bottom"></footer>
    <script type="text/html" id="pointscount_model">
        <div class="container point">
            <i class="icon"></i>
            <dl>
                <dt>我的积分</dt>
                <dd><em><%=point;%></em></dd>
            </dl>
        </div>
    </script>
    <script type="text/html" id="list_model">
        <% var points=items; %>
        <% if(points.length >0){%>
            <% for (var k in points) { var v = points[k]; %>
                <li>
                    <dl><dt><%=v.stagetext;%></dt>
                        <dd>
                            <%=v.points_log_desc;%>
                        </dd>
                    </dl>
                    <% if(v.points_log_points >0){%>
                        <div class="money add">+
                            <%=v.points_log_points;%>
                        </div>
                        <%}else{%>
                            <div class="money reduce">
                                <%=v.points_log_points;%>
                            </div>
                            <%}%>
                                <time class="date">
                                    <%=v.points_log_time;%>
                                </time>
                </li>
                <%}%>
                    <li class="loading">
                        <div class="spinner"><i></i></div>数据读取中</li>
                    <%
        }else {
        %>
                        <div class="nctouch-norecord signin" style="top: 70%;">
                            <div class="norecord-ico"><i></i></div>
                            <dl>
                                <dt>您还没有任何积分记录</dt>
                                <dd>每日签到或购买商品可获取积分</dd>
                            </dl>
                        </div>
                        <%
        }
        %>
    </script>
    
    <script type="text/javascript" src="../../js/zepto.min.js"></script>
    <script type="text/javascript" src="../../js/template.js"></script>
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/ncscroll-load.js"></script>
    <script>
        $(function () {
            var key = getCookie('key');
            if (!key) {
                window.location.href = WapSiteUrl + '/tmpl/member/login.html';
                return;
            }

            //渲染list
            var load_class = new ncScrollLoad();
            load_class.loadInit({
                'url': ApiUrl + '/index.php?ctl=Buyer_Points&met=points&typ=json',
                'getparam': {
                    'k': key,
                    u:getCookie('id')
                },
                'tmplid': 'list_model',
                'containerobj': $("#pointsloglist"),
                'iIntervalId': true
            });

            //获取我的积分
            $.getJSON(ApiUrl + '/index.php?ctl=Points&met=detail&typ=json&id=<%=v.id%>',{
                'key': key,
                'fields': 'point'
            }, function (result) {

                var html = template.render('pointscount_model', result);
                $("#pointscount").html(html);
            });
        });
    </script>
</body>

</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>