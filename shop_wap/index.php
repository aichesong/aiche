 
<?php 
	include __DIR__.'/includes/header.php';

	if($_GET['qr']){
			setcookie('is_app_guest',1,time()+86400*366);
			$_COOKIE['is_app_guest'] = 1;
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-touch-fullscreen" content="yes" />
	<meta name="format-detection" content="telephone=no"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="msapplication-tap-highlight" content="no" />
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
	<title><?php echo __('首页');?></title>
	<link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/new-style.css">
    <link rel="stylesheet" href="css/index-swiper.css">
    <link rel="stylesheet" href="css/swiper.min.css">
    <script src="js/jquery.js"></script>
    <!-- <script src="js/new-common.js"></script> -->
</head>

<body>
	<!-- 搜索 -->
	<div class="head-fixed">
		<div class="head-ser"> 
			<div class="cohesive " id="cohesive_dev"><a href="./tmpl/changecity.html"><span class="city-text sub_site_name_span"><?php echo __('全部');?><!-- <i class="icon-city"></i> --></span>
  			<i class="icon-drapdown"></i></a></div>
	        <a href="tmpl/search.html" class="header-inps"> 
	        <i class="icon"></i><span class="search-input" id="keyword"><?php echo __('请输入关键词');?></span> 
	        </a>
			<?php if($_COOKIE['is_app_guest']){ ?>
				<a class="qrcode_open scan" href="/qrcode_open"><i class="icon-scan"></i><span>扫一扫</span></a> 
				<script>
					if($(window).width()<360){
						$(".header-inps").css("width","9rem");
					}else{
						$(".header-inps").css("width","10.5rem");
					}
					
				</script>
			<?php }?>
			
			
	        <a id="header-nav" href="./tmpl/member/chat_list.html" class="message"><i></i><span><?php echo __('消息');?></span></a>
	    </div>
	</div>
    <div class="bgf borb1 mrb45 ser-mrt">
    	
	
  		
	    <!--     banner -->
	    <div class="swiper-container swiper-container-new" id="main-container1" style="overflow:hidden;"></div>
	    <div class="swiper-pagination swiper-paginations" id="pagination"></div>
	    
	    <ul class="nav-class tc mrt70">
	        <li><a href="tmpl/integral.html"><i></i>
	    				<p>积分商城</p>
	    			</a></li>
	        <li><a href="tmpl/group_buy_index.html"><i></i>
	    				<p>团购中心</p>
	    			</a></li>
	        <li><a href="tmpl/store-list.html"><i></i>
	    				<p>店铺精选</p>
	    			</a></li>
	        <li><a href="javascript:;"><i></i>
	    				<p>平台红包</p>
	    			</a></li>
	    </ul>
	    <!-- <script type="text/javascript">
		    if (window.paySiteName)
			{
				document.getElementById('pay_site_name').innerHTML = window.paySiteName;
			}

			 function payurl(){
			  	window.open(PayCenterWapUrl);
			  }
		</script> -->
    </div>
    <div class="nctouch-home-layout mrb150" id="main-container2"></div>
    <!--<p class="load-more tc">加载更多</p>-->

    <!-- 底部 -->
    <?php 
				include __DIR__.'/includes/footer_menu.php';
		?>

<script type="text/html" id="slider_list">
	<div class="swiper-wrapper">
	<% for (var i in item) { %>
		<div class="swiper-slide">
			<a href="<%= item[i].url %>">
				<img src="<%= item[i].image %>" class="main-img">
			</a>
		</div>
	<% } %>
	</div>
	
	    
</script> 
<script type="text/html" id="home1">
	<div class="bgf bort1">
		<div class="ad ">
	    	<a href="<%= url %>" class="tc"><img src="<%= image %>" alt=""><% if (title) { %><div class="class-tit"><span><%= title %></span></div><% } %> </a>
	    </div>
	</div>
</script> 
<script type="text/html" id="home2">
	<div class="bgf bort1 borb1 mrb45 padb63">
		<div class="module1">
	    	<% if (title) { %>
	    	<div class="common-tit tc">
	    		<i class="round small"></i>
	    		<i class="round big"></i>
	    		<h4><%= title %></h4>
	    		<i class="round big"></i>
	    		<i class="round small"></i>
	    	</div>
	    	<% } %>
	    	<!-- 布局一（1/3） -->
	    	<div class="layout1">
	    		<div class="big left0"><a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a></div>
	    		<div class="small mrl804">
	    			<a href="<%= rectangle1_url %>" class="mrb22"><img src="<%= rectangle1_image %>" alt=""></a><a href="<%= rectangle2_url %>"><img src="<%= rectangle2_image %>" alt=""></a>
	    		</div>
	    	</div>
	    </div>
	</div>
</script> 
<script type="text/html" id="home3">
	<div class="bgf borb1 mrb45 padb28">
		<% if (title) { %>
		<div class="common-tit tc">
			<i class="round small"></i>
			<i class="round big"></i>
			<h4><%= title %></h4>
			<i class="round big"></i>
			<i class="round small"></i>
		</div>
		<% } %>
		<div class="layout2">
			<ul class="wrap">
				<% for (var i in item) { %>
				<li><a href="<%= item[i].url %>"><img src="<%= item[i].image %>" alt=""></a></li>
				<% } %>
			</ul>
		</div>
	</div>
</script> 
<script type="text/html" id="home4">
	<div class="bgf bort1 borb1 mrb45 padb63">
		<% if (title) { %>
	    	<div class="common-tit tc">
	    		<i class="round small"></i>
	    		<i class="round big"></i>
	    		<h4><%= title %></h4>
	    		<i class="round big"></i>
	    		<i class="round small"></i>
	    	</div>
	    <% } %>
	    	<div class="layout1">
	    		<div class="small mrr352">
	    			<a href="<%= rectangle1_url %>" class="mrb22"><img src="<%= rectangle1_image %>" alt=""></a><a href="<%= rectangle2_url %>"><img src="<%= rectangle2_image %>" alt=""></a>
	    		</div>
	    		<div class="big right0"><a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a></div>
	    	</div>
    </div>
</script> 
<script type="text/html" id="goods">
	<div class="bgf bort1 borb1 mrb45 padb63 mrt20">
		<% if (title) { %>
		<div>
			<h4 class="common-tit2"><i class="icon"></i><span><%= title %></span></h4>
		</div>
		<% } %>

		<ul class="new-goods clearfix wrap">
			<% for (var i in item) { %>
			<li><a href="tmpl/product_detail.html?goods_id=<%= item[i].goods_id %>">
					<div class="overhide"><div class="table"><span class="img-area"><img src="<%= item[i].goods_image %>" alt=""></span></div></div>
					<h5><%= item[i].goods_name %></h5>
					<b>￥<%= item[i].goods_promotion_price %></b>
				</a>
			</li>
			<% } %>
		</ul>
    </div>
</script>

<script type="text/javascript" src="js/zepto.min.js"></script> 
<script type="text/javascript" src="js/template.js"></script> 
<script type="text/javascript" src="js/common.js"></script> 
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
<script type="text/javascript" src="js/swiper.min.js"></script>

</body>

</html>
<?php 
include __DIR__.'/includes/footer.php';
?>
