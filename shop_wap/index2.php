<?php 
include __DIR__.'/includes/header.php';
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
<title><?php echo __('首页');?></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
 
<div class="nctouch-home-top fixed-Width">
  <header id="header" class="transparent">
  	<div class="logo"><img class="site_logo" style='height:auto;'></div>

    <div class="header-wrap">
      <a href="tmpl/search.html" class="header-inp"> <i class="icon"></i> <span class="search-input" id="keyword"><?php echo __('请输入关键词');?></span> </a>
    </div>
    <div class="header-r"><a id="header-nav" href="./tmpl/member/chat_list.html"><i class="message"></i>
      <p><?php echo __('消息');?></p>
      <sup></sup></a></div>
  </header>
  <div class="cohesive " id="cohesive_dev"><a href="./tmpl/changecity.html"><span class="city-text sub_site_name_span"><?php echo __('全部');?></span>
  			<i class="icon-drapdown"></i></a></div>
  <div class="slider_list" id="main-container1"></div>
</div>
<div class="nctouch-home-nav fixed-Width">
  <ul>
    <li><a href="tmpl/product_first_categroy.html"><span><i></i></span>
      <p>分类</p>
      </a></li>
    <li><a href="tmpl/cart_list.html"><span><i></i></span>
      <p>购物车</p>
      </a></li>
    <li><a href="tmpl/member/member.html"><span><i></i></span>
      <p>我的商城</p>
      </a></li>
    <li><a href="tmpl/member/signin.html"><span><i></i></span>
      <p>每日签到</p>
      </a>
    </li>
     <li><a href="tmpl/group_buy_index.html"><span><i></i></span>
      <p>团购中心</p>
      </a></li>
    <li><a href="tmpl/integral.html"><span><i></i></span>
      <p>积分商城</p>
      </a></li>
    <li><a href="tmpl/store-list.html"><span><i></i></span>
      <p>店铺列表</p>
      </a></li>
    <li><a href="javascript:;" onclick="payurl()"><span><i></i></span>
      <p id="pay_site_name">网付宝</p>
      </a></li>
  </ul>

<script type="text/javascript">
    if (window.paySiteName)
	{
		document.getElementById('pay_site_name').innerHTML = window.paySiteName;
	}

	 function payurl(){
	  	window.open(PayCenterWapUrl);
	  }
</script>
 
</div>
<div class="nctouch-home-layout" id="main-container2"></div>
<div class="fix-block-r">
	<a href="javascript:void(0);" class="gotop-btn gotop hide" id="goTopBtn"><i></i></a>
</div>
<footer id="footer" class="fixed-Width">
	
	<?php 

	$key = $_SERVER['SERVER_NAME'];
 
	$footer = __DIR__.'/cache/'.$key.'.footer.php';

	if(file_exists($footer)){
			echo file_get_contents($footer);
	}
	?>

</footer>

 
<script type="text/html" id="slider_list">
		<div class="swipe-wrap">
		<% for (var i in item) { %>
			<div class="item">
				<a href="<%= item[i].url %>">
					<img src="<%= item[i].image %>" alt="">
				</a>
			</div>
		<% } %>
		</div>
</script> 
<script type="text/html" id="home1">
	<div class="nctouch-home-block">
	<% if (title) { %>
		<div class="tit-bar"><%= title %></div>
	<% } %>
		<div class="item-pic">
			<a href="<%= url %>">
				<img src="<%= image %>" alt="">
			</a>
		</div>
	</div>
</script> 
<script type="text/html" id="home2">
	<div class="nctouch-home-block">
	<% if (title) { %>
		<div class="tit-bar"><%= title %></div>
	<% } %>
		<ul class="item-pic-l1-r2">
			<li>
				<a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a>
			</li>
			<li>
				<a href="<%= rectangle1_url %>"><img src="<%= rectangle1_image %>" alt=""></a>
			</li>
			<li>
				<a href="<%= rectangle2_url %>"><img src="<%= rectangle2_image %>" alt=""></a>
			</li>
		</ul>
	</div>
</script> 
<script type="text/html" id="home3">
	<div class="nctouch-home-block">
	<% if (title) { %>
		<div class="tit-bar"><%= title %></div>
	<% } %>
		<ul class="item-pic-list">
		<% for (var i in item) { %>
			<li>
				<a href="<%= item[i].url %>"><img src="<%= item[i].image %>" alt=""></a>
			</li>
		<% } %>
		</ul>
	</div>
</script> 
<script type="text/html" id="home4">
	<div class="nctouch-home-block">
	<% if (title) { %>
		<div class="tit-bar"><%= title %></div>
	<% } %>
		<ul class="item-pic-l2-r1">
			<li>
				<a href="<%= rectangle1_url %>"><img src="<%= rectangle1_image %>" alt=""></a>
			</li>
			<li>
				<a href="<%= rectangle2_url %>"><img src="<%= rectangle2_image %>" alt=""></a>
			</li>
			<li>
				<a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a>
			</li>
		</ul>
	</div>
</script> 
<script type="text/html" id="goods">
	<div class="nctouch-home-block item-goods">
	<% if (title) { %>
		<div class="tit-bar"><%= title %></div>
	<% } %>
		<ul class="goods-list">
		<% for (var i in item) { %>
			<li>
				<a href="tmpl/product_detail.html?goods_id=<%= item[i].goods_id %>">
					<div class="goods-pic"><img src="<%= item[i].goods_image %>" alt=""></div>
					<dl class="goods-info">
						<dt class="goods-name"><%= item[i].goods_name %></dt>
						<dd class="goods-price">￥<em><%= item[i].goods_promotion_price %></em></dd>
					</dl>
				</a>
			</li>
		<% } %>
		</ul>
	</div>
</script> 


 
<script type="text/javascript" src="js/zepto.min.js"></script> 
<script type="text/javascript" src="js/template.js"></script> 
<script type="text/javascript" src="js/common.js"></script> 
<script type="text/javascript" src="js/swipe.js"></script> 
<script type="text/javascript" src="js/index.js"></script> 
<script type="text/javascript" src="js/tmpl/footer.js"></script>

<script type="text/javascript" src="js/addtohomescreen.js"></script>
<script>
    addToHomescreen({
            message:'如要把应用程式加至主屏幕,请点击%icon, 然后<strong>加至主屏幕</strong>'
    });
        
    function initialize() {
        // 百度地图API功能
        var geolocation = new BMap.Geolocation();
        var geoc = new BMap.Geocoder();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                var mk = new BMap.Marker(r.point);
                window.coordinate = {'lng':r.point.lng, lat:r.point.lat};
                geoc.getLocation(r.point, function(rs){
                    var addComp = rs.addressComponents;

                    if(addComp.province != null && addComp.province != 'undefined' && addComp.province != ''){
                        //获取分站信息
                        window.addressStr = addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;
                        $.post(ApiUrl + "/index.php?ctl=Base_District&met=getLocalSubsiteWap&typ=json&ua=wap",{province:addComp.province,city:addComp.city,district:addComp.district,street:addComp.street},function(result){

                              if(result.status == 200){
                                  addCookie('sub_site_id',result.data.subsite_id,0);
                              }else{
                                  addCookie('sub_site_id',0,0);
                              }
                              window.location.reload();
                        },'json');
                    }
                });
            } else {
                alert('failed'+this.getStatus());
            }
        },{enableHighAccuracy: true})
    }

    function loadScriptSubsite() {
        var script = document.createElement("script");
        script.src = "http://api.map.baidu.com/api?v=2.0&ak=A83cd06b54e826075981aa381d52b943&callback=initialize";//此为v2.0版本的引用方式
        document.body.appendChild(script);

    }
</script>
</body>
</html>
<?php 
include __DIR__.'/includes/footer.php';
?>