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
    <title>确认订单</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_common.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_cart.css">
    <style>
        .jia-shop .fr a.min {
            background: #d5d5d5;
        }
        .jia-shop .fr a.min.disabled, .jia-shop .fr a.max.disabled{
            background: #eeeeee;
        }
    </style>
</head>
<body>
<header id="header" class="fixed">
    <div class="header-wrap">
        <div class="header-l"> <a href="javascript:history.go(-1)"> <i class="back"></i> </a> </div>
        <div class="header-title">
            <h1>确认订单</h1>
        </div>
        <div class="header-r"> <a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
    </div>
    <div class="nctouch-nav-layout">
        <div class="nctouch-nav-menu"> <span class="arrow"></span>
            <ul>
                <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                <li><a href="../../tmpl/search.html"><i class="search"></i>搜索</a></li>
                <li><a href="../../tmpl/member/member.html"><i class="member"></i>我的商城</a></li>
                <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
            </ul>
        </div>
    </div>
</header>
<div id="container-fcode" class="hide">
    <div class="fcode-bg">
        <div class="con">
            <h3>您正在购买“F码”商品</h3>
            <h5>请输入所知的F码序列号并提交验证<br/>
                系统效验后可继续完成下单</h5>
            <input type="text" name="fcode" id="fcode" placeholder="" />
            <p class="fcode_error_tip" style="display:none;color:red;"></p>
            <a href="javascript:void(0);" class="submit">提交验证</a> </div>
    </div>
</div>
<div class="nctouch-main-layout mb20">
    <div class="nctouch-cart-block">
        <!--正在使用的默认地址Begin-->
        <div class="nctouch-cart-add-default borb1"><a href="javascript:void(0);" id="list-address-valve"><i class="icon-add"></i>
            <dl>
                <input type="hidden" class="inp" name="address_id" id="address_id"/>
                <dt>收货人：<span id="true_name"></span><span id="mob_phone"></span></dt>
                <dd><span id="address"></span></dd>
            </dl>
            <i class="icon-arrow"></i></a></div>
        <!--正在使用的默认地址End-->
    </div>
    <!--选择收货地址Begin-->
    <div id="list-address-wrapper" class="nctouch-full-mask hide">
        <div class="nctouch-full-mask-bg"></div>
        <div class="nctouch-full-mask-block">
            <div class="header">
                <div class="header-wrap">
                    <div class="header-l"> <a href="javascript:void(0);"> <i class="back"></i> </a> </div>
                    <div class="header-title">
                        <h1>收货地址管理</h1>
                    </div>
                </div>
            </div>
            <div class="nctouch-main-layout" style="display: block; position: absolute; top: 0; right: 0; left: 0; bottom:2rem; overflow: hidden; z-index: 1;" id="list-address-scroll">
                <ul class="nctouch-cart-add-list" id="list-address-add-list-ul">
                </ul>
            </div>
            <div id="addresslist" class="mt10" style="position: absolute; right: 0; left: 0; bottom: 0; z-index: 1;"> <a href="javascript:void(0);" class="btn-l" id="new-address-valve">新增收货地址</a> </div>
        </div>
    </div>
    <!--选择收货地址End-->
    <!--新增收货地址Begin-->
    <div id="new-address-wrapper" class="nctouch-full-mask hide">
        <div class="nctouch-full-mask-bg"></div>
        <div class="nctouch-full-mask-block">
            <div class="header">
                <div class="header-wrap">
                    <div class="header-l"> <a href="javascript:void(0);"> <i class="back"></i> </a> </div>
                    <div class="header-title">
                        <h1>新增收货地址</h1>
                    </div>
                </div>
            </div>
            <div class="nctouch-main-layout" id="new-address-scroll">
                <div class="nctouch-inp-con">
                    <form id="add_address_form">
                        <ul class="form-box">
                            <li class="form-item">
                                <h4>收货人姓名</h4>
                                <div class="input-box">
                                    <input type="text" class="inp" name="true_name" id="vtrue_name" autocomplete="off" oninput="writeClear($(this));"/>
                                    <span class="input-del"></span> </div>
                            </li>
                            <li class="form-item">
                                <h4>联系手机</h4>
                                <div class="input-box">
                                    <input type="tel" class="inp" name="mob_phone" id="vmob_phone" autocomplete="off" oninput="writeClear($(this));"/>
                                    <span class="input-del"></span> </div>
                            </li>
                            <li class="form-item">
                                <h4>地区选择</h4>
                                <div class="input-box">
                                    <input name="area_info" type="text" class="inp" id="varea_info" autocomplete="off" onchange="btn_check($('form'));" readonly/>
                                </div>
                            </li>
                            <li class="form-item">
                                <h4>详细地址</h4>
                                <div class="input-box">
                                    <input type="text" class="inp" name="vaddress" id="vaddress" autocomplete="off" oninput="writeClear($(this));"/>
                                    <span class="input-del"></span> </div>
                            </li>
                        </ul>
                        <div class="error-tips"></div>
                        <div class="form-btn"><a href="javascript:void(0);" class="btn">保存地址</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--新增收货地址End-->


   

    <!--发票信息Begin-->
    <div class="nctouch-cart-block">
        <div class="mrl54 borb1 pdt2">
            <a href="javascript:void(0);" class="posr" id="invoice-valve">
            <h3>发票信息：</h3>
            <div class="current-con">
                <p id="invContent">不需要发票</p>
                <input type="hidden" name="invoice_id">
            </div>
            <i class="icon-arrow"></i> </a>  
        </div>
   </div>
    <!--发票信息End-->

    <!--管理发票信息Begin-->
    <div id="invoice-wrapper" class="nctouch-full-mask hide">
        <div class="nctouch-full-mask-bg"></div>
        <div class="nctouch-full-mask-block">
            <div class="header">
                <div class="header-wrap">
                    <div class="header-l"> <a href="javascript:void(0);"> <i class="back"></i> </a> </div>
                    <div class="header-title">
                        <h1>管理发票信息</h1>
                    </div>
                </div>
            </div>
            <div class="nctouch-main-layout"  style="width:100%;height:100%; overflow-y:scroll;">
                <div class="nctouch-sel-box">
                    <div class="sel-con">
                        <div class="tic-tab"><a href="javascript:void(0);" class="sel" id="invoice-noneed">不需要开发票</a></div>
                        <div class="tic-tab"> <a href="javascript:void(0);" id="invoice-need">需要开发票</a></div>
                    </div>
                </div>
                <div id="invoice-div" class="">
                    <div class="nctouch-inp-con" id="invoice_add" style="display:none">
                        <ul class="form-box">
                            <li class="form-item mrl0 bgf5">
                                <div id="invoice_type" class="input-box btn-style">
                                    <label class="checked">
                                        <input type="radio" checked="checked" name="inv_title_select" value="normal" id="norm" >
                                        普通发票 </label>
                                    <label>
                                        <input type="radio" name="inv_title_select" value="electronics" id="electronics">
                                        电子发票 </label>
                                    <label>
                                        <input type="radio" name="inv_title_select" value="increment" id="increment">
                                        增值税发票 </label>
                                </div>
                            </li>
                        </ul>

                        <ul id="invoice-list" class="nctouch-sel-list bort1 borb1">
                        </ul>
                    </div>
                    <div class="nctouch-inp-con" id="invoice_normal_add" style="display: none;">
                        <ul class="form-box">
                            <li class="form-item" id="inv-title-li1">
                                <h4>发票抬头</h4>
                                <div class="input-box">
                                    <input type="text" class="inp" name="inv_normal_add_title" placeholder="输入个人或企业名称">
                                    <span class="input-del"></span> </div>
                            </li>
                            <li class="form-item">
                                <h4>发票内容</h4>
                                <div class="input-box">
                                    <select id="inv_normal_add_content" name="inv_normal_add_content" class="select">
                                        <option value="明细">明细</option>
                                        <option value="办公用品">办公用品</option>
                                        <option value="电脑配件">电脑配件</option>
                                        <option value="耗材">耗材</option>
                                    </select>
                                    <i class="arrow-down"></i> </div>
                            </li>
                        </ul>
                    </div>
                    <a href="javascript:void(0);" class="btn-l mt10">确定</a> 
                    <div style="width:100%; height: 50px;">
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
    <!--管理发票信息End-->
     <!--付款方式Begin-->
    <div class="nctouch-cart-block borb1">
        <div class="mrl54 pdb2">
           <a href="javascript:void(0);" class="posr" id="select-payment-valve">
            <h3>支付方式：</h3>
            <div class="current-con">在线付款</div>
            <input type="hidden" name="pay-selected" id="pay-selected" value="1">
            <!--<div class="current-con">货到付款</div>-->
            <i class="icon-arrow"></i> </a> 
        </div> 
    </div>
        
    <!--付款方式End-->

    <!--选择付款方式Begin-->
    <div id="select-payment-wrapper" class="nctouch-full-mask hide">
        <div class="nctouch-full-mask-bg"></div>
        <div class="nctouch-full-mask-block">
            <div class="header">
                <div class="header-wrap">
                    <div class="header-l"> <a href="javascript:void(0);"> <i class="back"></i> </a> </div>
                    <div class="header-title">
                        <h1>选择支付方式</h1>
                    </div>
                </div>
            </div>
            <div class="nctouch-main-layout">
                <div class="nctouch-sel-box">
                    <h4 class="tit">支付方式</h4>
                    <div class="sel-con"> <a href="javascript:void(0);" class="sel" id="payment-online">在线支付</a> <a href="javascript:void(0);" id="payment-offline">货到付款</a></div>
                </div>
            </div>
        </div>
    </div>
    <!--选择付款方式End-->

    <!--商品列表Begin-->
    <div id="goodslist_before" class="mt5">
        <div id="deposit"> </div>
    </div>
    <!--商品列表End-->

    <!--合计支付金额Begin-->
    <div id="rptVessel" class="nctouch-cart-block mt5">
        <div class="current-con">
            <dl class="total-money">
            合计：<span class="col4 fz8">￥<em id="totalPrice">0.00</em></span>
            </dl>
            <dl class="total-money rate-money" style="display: none;">
                会员折扣：<span class="col-red">-￥<em id="ratePrice">0.00</em></span>
            </dl>
        </div>
    </div>
    <!--合计支付金额End-->

    <!--红包使用Begin-->
    <!--<div id="rptVessel" class="nctouch-cart-block mt5">
        <div class="input-box">
            <label>
                <input type="checkbox" class="checkbox" id="useRPT"/>
                平台红包 <span class="power"><i></i></span> </label>
            <p id="rptInfo"></p>
        </div>
    </div>-->
    <!--红包使用End-->

    <!--底部总金额固定层Begin-->
    <div class="nctouch-cart-bottom">
        <div class="total"><span id="online-total-wrapper"></span>
            <dl class="total-money">
                <!--<dt>合计：</dt>
                <dd>￥<em id="totalPrice"></em></dd>-->
                <dt>支付总金额：</dt>
                <dd>￥<em id="totalPayPrice"></em></dd>
            </dl>
        </div>
        <div class="check-out"><a href="javascript:void(0);" id="ToBuyStep2">提交订单</a></div>
    </div>
    <!--底部总金额固定层End-->
    <div class="nctouch-bottom-mask">
        <div class="nctouch-bottom-mask-bg"></div>
        <div class="nctouch-bottom-mask-block">
            <div class="nctouch-bottom-mask-tip"><i></i>点击此处返回</div>
            <div class="nctouch-bottom-mask-top">
                <p class="nctouch-cart-num">本次交易需在线支付<em id="onlineTotal">0.00</em>元</p>
                <p style="display:none" id="isPayed"></p>
                <a href="javascript:void(0);" class="nctouch-bottom-mask-close"><i></i></a> </div>
            <div class="nctouch-inp-con nctouch-inp-cart">
                <ul class="form-box" id="internalPay">
                    <p class="rpt_error_tip" style="display:none;color:red;"></p>
                    <li class="form-item" id="wrapperUseRCBpay">
                        <div class="input-box pl5">
                            <label>
                                <input type="checkbox" class="checkbox" id="useRCBpay" autocomplete="off" />
                                使用充值卡支付 <span class="power"><i></i></span> </label>
                            <p>可用充值卡余额 ￥<em id="availableRcBalance"></em></p>
                        </div>
                    </li>
                    <li class="form-item" id="wrapperUsePDpy">
                        <div class="input-box pl5">
                            <label>
                                <input type="checkbox" class="checkbox" id="usePDpy" autocomplete="off" />
                                使用预存款支付 <span class="power"><i></i></span> </label>
                            <p>可用预存款余额 ￥<em id="availablePredeposit"></em></p>
                        </div>
                    </li>
                    <li class="form-item" id="wrapperPaymentPassword" style="display:none">
                        <div class="input-box"> <span class="txt">输入支付密码</span>
                            <input type="password" class="inp" id="paymentPassword" autocomplete="off" />
                            <span class="input-del"></span> </div>
                        <a href="../member/member_paypwd_step1.html" class="input-box-help" style="display:none"><i>i</i>尚未设置</a> </li>
                </ul>
                <div class="nctouch-pay">
                    <div class="spacing-div"><span>在线支付方式</span></div>
                    <div class="pay-sel">
                        <label style="display:none">
                            <input type="radio" name="payment_code" class="checkbox" id="alipay" autocomplete="off" />
                            <span class="alipay">支付宝</span></label>
                        <label style="display:none">
                            <input type="radio" name="payment_code" class="checkbox" id="wxpay_jsapi" autocomplete="off" />
                            <span class="wxpay">微信</span></label>
                    </div>
                </div>
                <div class="pay-btn"> <a href="javascript:void(0);" id="toPay" class="btn-l">确认支付</a> </div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="goods_list">
    <% var store_cart_list = glist; %>
    <% for (var k in store_cart_list) { %>
    <div class="nctouch-cart-container">
        <dl class="nctouch-cart-store">
            <dt><i class="icon-store"></i><%=store_cart_list[k].shop_name%><span data-store_id="<%=k%>" class="store-cod-supported" style="display:none;">（该店铺不支持选定收货地址的货到付款）</span>
                <% if (store_cart_list[k].voucher_base != '') { %>
        <!--						<span class="handle">
							<a href="javascript:void(0);" class="voucher animation-up animation-up<%=k%>"><i></i>使用代金券</a>
						</span>-->
                <% } %>
            </dt>
            <% if(store_cart_list[k].mansong_info.common_id != 0){ %>
            <dd class="store-activity">
                <em>满即送</em>
                <span><%if(store_cart_list[k].mansong_info.rule_discount){%>店铺优惠<%=store_cart_list[k].mansong_info.rule_discount%>。<%}%><%if(store_cart_list[k].mansong_info.goods_name){%><%=store_cart_list[k].mansong_info.goods_name%><%if (store_cart_list[k].mansong_info.goods_image) {%>，送<img src="<%=store_cart_list[k].mansong_info.goods_image%>"><%}%><%}%></span>
            </dd>
            <% } %>
        </dl>
        <ul class="nctouch-cart-item">
            <% for (var l in store_cart_list[k].goods) { var v1 = store_cart_list[k].goods[l]%>
            <li class="buy-item bgf6" data-buy_able="<%=v1.buy_able%>" data-goods_name="<%=v1.goods_base.goods_name%>">
                <div class="buy-li">
                     <div class="goods-pic">
                        <input type="hidden" name="cart_id" value="<%=v1.cart_id%>">
                        <a href="<%=WapSiteUrl%>/tmpl/product_detail.html?goods_id=<%=v1.goods_id%>">
                            <img src="<%=v1.goods_base.goods_image%>"/>
                        </a>
                    </div>
                    <dl class="goods-info">
                        <dt class="goods-name">
                            <a href="<%=WapSiteUrl%>/tmpl/product_detail.html?goods_id=<%=v1.goods_id%>">
                                <%=v1.goods_base.goods_name%><% if(!v1.buy_able){ %> <span style="color: #db4453;">无货</span><% } %>
                            </a>
                        </dt>
                        <dd class="goods-type"><%=v1.goods_base.spec_str%></dd>
                    </dl>
                    <div class="goods-subtotal">
                        <span class="goods-price">￥<em><%=sprintf('%.2f', v1.now_price)%></em></span>
                    </div>
                    <div class="goods-num">
                        <em>x<%=v1.goods_num%></em>
                    </div>
                    <div class="notransport" style="display:none;"><p>该商品不支持配送</p></div>
                </div>
                
            </li>
            <% } %>
        </ul>

        <!-- 新增代金券 -->
        <% if (store_cart_list[k].voucher_base && store_cart_list[k].voucher_base.length > 0) { %>
            <% var voucher_list = store_cart_list[k].voucher_base; %>
            <div class="order-vou trigger_shop_voucher" id="trigger_shop_voucher_<%= store_cart_list[k].shop_id; %>" data-current_index="<%= k; %>">
                <div class="tit-sale">代金券</div>
                <div class="fr sale-cons">
                    <% for (var a = 0; a < voucher_list.length; a++) { %>
                        <p class="js_voucher_info" id="voucher_info<%= voucher_list[a].voucher_id; %>">
                            <span>￥<%= voucher_list[a].voucher_price %>&nbsp;&nbsp;&nbsp;&nbsp;满<%= voucher_list[a].voucher_limit %>立减<%= voucher_list[a].voucher_price %>元</span>
                        </p>
                    <% } %>
                    <div class="item-more"></div>
                </div>
            </div>
            <!-- 新增代金券 -->
           <!--  代金券弹出框内容 -->
            <div class="quan-ar nctouch-bottom-mask shop_voucher_html"  id="shop_voucher_html_<%= store_cart_list[k].shop_id; %>">
                <div class="nctouch-bottom-mask-bg"></div>
                <div class="nctouch-bottom-mask-block">
                    <h3 class="tc">代金券</h3>
                    <ul class="drap-ar">
                        <% for (var a = 0; a < voucher_list.length; a++) { %>
                            <li>
                                <input style="margin-bottom: 5px;" type="radio" id="shop_voucher<%= voucher_list[a].voucher_id; %>" name="shop_voucher<%= store_cart_list[k].shop_id; %>" data-promotion_type="voucher" data-voucher_id="<%= voucher_list[a].voucher_id; %>" data-voucher_price="<%= voucher_list[a].voucher_price; %>">
                                <label for="voucher_id<%= voucher_list[a].voucher_id; %>">
                                    <strong>￥<%= voucher_list[a].voucher_price %></strong>
                                    <span>满<%= voucher_list[a].voucher_limit %>立减<%= voucher_list[a].voucher_price %></span>
                                </label>
                            </li>
                        <% } %>
                    </ul>
                    <p class="new-btn JS_close"><a href="javascript:void(0)" class="btns">关闭</a></p>

                </div>
            </div>
        <% } %>
        <!--  代金券弹出框内容 -->

        <!-- 加价购 -->
        <% if (store_cart_list[k].jia_jia_gou && store_cart_list[k].jia_jia_gou.length > 0) { %>
            <%
                var jia_jia_gou = store_cart_list[k].jia_jia_gou;
            %>
            <div class="order-vou trigger_shop_jjg" id="trigger_shop_jjg_<%= store_cart_list[k].shop_id; %>" data-current_index="<%= k; %>">
                <div class="tit-sale">加价购</div>
                <div class="fr sale-cons" id="jjg_rule_info<%= store_cart_list[k].shop_id; %>">
                    <p>
                        <span>
                            <!-- 多个加价购多条规则多个换购商品 -->
                            <% for(var a = 0; a < jia_jia_gou.length; a++) { %>
                                <!-- 活动规则 -->
                                <% var rules = jia_jia_gou[a].rule; %>
                                <% for (var b = 0; b < rules.length; b++) { %>
                                    购物满￥<%= rules[b].rule_price %>即可加价换购<%= rules[b].rule_goods_limit %>件
                                    <!-- 活动规则加价商品 -->
                                    <% var redemption_goods = rules[b].redemption_goods; %>
                                    <% for (var c = 0; c < redemption_goods.length; c++) { %>
                                        <%= redemption_goods[c].goods_name; %>
                                    <% } %>
                                <% } %>
                            <% } %>
                            <!-- 多个加价购多条规则多个换购商品 -->
                        </span>
                    </p>
                    <div class="item-more"></div>
                </div>
                <div id="jjg_rule_checked<%= store_cart_list[k].shop_id; %>" style="display: none;" class="fr sales-text"></div>
            </div>

        <!-- 加价购 -->

        <!--  加价购弹出框内容 -->
            <div class="quan-ar nctouch-bottom-mask jia-shop-area shop_jjg_html" id="shop_jjg_html_<%= store_cart_list[k].shop_id; %>">
                <div class="nctouch-bottom-mask-bg"></div>
                <div class="nctouch-bottom-mask-block">
                    <h3 class="tc">加价购</h3>
                    <!-- 加价购活动规则循环 -->
                    <div class="jia-gou-height">
                    <% for(var a = 0; a < jia_jia_gou.length; a++) { %>
                        <!-- 活动规则 -->
                        <% var rules = jia_jia_gou[a].rule; %>
                        <% for (var b = 0; b < rules.length; b++) { %>

                            <div class="item-li">
                                <p class="tit-tip">
                                    <input type="radio" id="shop_jjg<%= rules[b].rule_id; %>" name="shop_jjg<%= store_cart_list[k].shop_id; %>" data-promotion_type="jjg" data-rule_id="<%= rules[b].rule_id; %>" data-rule_goods_limit="<%= rules[b].rule_goods_limit; %>" />
                                    <label for="jjg_rule<%= rules[b].rule_id %>">
                                        <span>购物满￥<%= rules[b].rule_price; %>，最多可购买<%= rules[b].rule_goods_limit; %>件</span>
                                    </label>
                                </p>
                                <ul class="nctouch-cart-item">
                                    <!-- 活动规则加价商品 -->
                                    <% var redemption_goods = rules[b].redemption_goods; %>
                                    <% for (var c = 0; c < redemption_goods.length; c++) { %>
                                        <li class="buy-item">
                                            <div class="bgf6 buy-li js_jjg_li">
                                                <div class="goods-pic">
                                                    <a href="javascript:void(0)">
                                                        <img src="<%= redemption_goods[c].goods_image; %>">
                                                    </a>
                                                </div>
                                                <dl class="goods-info">
                                                    <dt class="goods-name">
                                                        <a href="<%= WapSiteUrl; %>/tmpl/product_detail.html?goods_id=<%= redemption_goods[c].goods_id; %>">
                                                            <%= redemption_goods[c].goods_name; %>
                                                        </a>
                                                    </dt>
                                                    <dd class="goods-type"></dd>
                                                </dl>
                                                <div class="goods-subtotal">
                                                    <span class="goods-price">￥<em><%= redemption_goods[c].goods_price; %></em></span>
                                                </div>
                                                <div class="goods-num" style="display: none">
                                                    <em></em>
                                                </div>
                                            </div>
                                             <div class="jia-shop clearfix">
                                                <p class="fl">加价购<em>￥<%= redemption_goods[c].redemp_price; %></em></p>
                                                <div class="fr mrt4 JS_operation">
                                                    <span><a href="javascript:void(0)" class="min disabled">-</a></span>
                                                    <span>
                                                        <input type="number" readonly="readonly" value="0" name="jjg_goods<%= rules[b].rule_id; %>" data-jjg_goods_id="<%= redemption_goods[c].goods_id %>" data-promotion_price="<%= redemption_goods[c].redemp_price %>">
                                                    </span>
                                                    <span><a href="javascript:void(0)" class="max">+</a></span>
                                                </div>
                                            </div>
                                        </li>
                                    <% } %>
                                </ul>

                            </div>
                        <% } %>
                    <% } %>
                    <!-- 加价购活动规则循环 -->
                    <p class="new-btn JS_close"><a href="javascript:void(0)" class="btns">完成</a></p>
                </div>
                </div>
            </div>
        <% } %>
        <!--  加价购弹出框内容 -->


        <div class="nctouch-cart-subtotal">
            <dl id="voucher<%=k%>" style="display: none;">
                <dt>代金券</dt>
                <dd><em id="vourchPrice<%=k%>"></em>元</dd>
                <input type="hidden" class="voucher_list" id="vourch_id<%=k%>" name="vourch_id" value="">
            </dl>
            <dl class="borb1">
                <dt>物流配送</dt>
                <dd><em id="storeFreight<%=k%>">0.00</em>元</dd>
            </dl>
            <dl class="message">
                <dt>买家留言：</dt>
                <dd>
                    <input type="text" name="remarks" placeholder="店铺订单留言" rel="<%=k%>" id="storeMessage<%=k%>">
                </dd>
            </dl>
            <div class="store-total">
                本店合计：<span><em id="storeTotal<%=k%>" class="js_store_total"></em></span>元
            </div>
            <% if(store_cart_list[k].mansong_info.rule_discount){ %>
                <div class="store-total">
                    满<%= store_cart_list[k].mansong_info.rule_price; %>立减<%= store_cart_list[k].mansong_info.rule_discount; %>：<span><em>-<%= store_cart_list[k].mansong_info.rule_discount; %></em></span>
                </div>
            <% } %>
        </div>


        <% if (store_cart_list[k].voucher_base != '') { %>
        <div class="nctouch-bottom-mask nctouch-bottom-mask<%=k%>">
            <div class="nctouch-bottom-mask-bg"></div>
            <div class="nctouch-bottom-mask-block">
                <!--<div class="nctouch-bottom-mask-tip"><i></i>点击此处返回</div>-->
                <div class="nctouch-bottom-mask-top store-voucher">
                    <i class="icon-store"></i>
                    <%=store_cart_list[k].shop_name%>&nbsp;&nbsp;领取店铺代金券
                    <a href="javascript:void(0);" class="nctouch-bottom-mask-close"><i></i></a>
                </div>
                <div class="nctouch-bottom-mask-rolling nctouch-bottom-mask-rolling<%=k%>">
                    <div class="nctouch-bottom-mask-con">
                        <ul class="nctouch-voucher-list">
                            <% for (var j in store_cart_list[k].voucher_base) {
                            var voucher = store_cart_list[k].voucher_base[j];%>
                            <li>
                                <dl>
                                    <dt class="money">面额<em><%=voucher.voucher_price%></em>元</dt>
                                    <dd class="need">需消费<%=voucher.voucher_limit%>使用</dd>
                                    <dd class="time">至<%=voucher.voucher_end_date%>前使用</dd>
                                </dl>
                                <a href="javascript:void(0);" class="btn" onclick="getvoucher(<%=voucher.voucher_id%>)" data-tid=<%=voucher.voucher_id%>>领取</a>
                            </li>
                            <% } %>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <% } %>

        <% } %>
</script>
<script type="text/html" id="order-voucher-script">
    <div class="nctouch-bottom-mask-bg"></div>
    
</script>
<script type="text/html" id="list-address-add-list-script">
    <% var address_list = address; %>
    <% if(address[0].user_address_id != 0){ %>
    <% for (var i=0; i<address_list.length; i++) { %>
    <li <% if ( (!isEmpty(address_id) && address_list[i].user_address_id == address_id) || (isEmpty(address_id) && address_list[i].user_address_default == 1) ) { %>class="selected"<% } %> data-param="{user_address_id:'<%=address_list[i].user_address_id%>',user_address_contact:'<%=address_list[i].user_address_contact%>',user_address_phone:'<%=address_list[i].user_address_phone%>',user_address_area:'<%=address_list[i].user_address_area%>',user_address_area:'<%=address_list[i].user_address_area%>',user_address_area_id:'<%=address_list[i].user_address_area_id%>',user_address_city_id:'<%=address_list[i].user_address_city_id%>',user_address_address:'<%=address_list[i].user_address_address%>'}"> <i></i>
    <dl>
        <dt>收货人：<span id=""><%=address_list[i].user_address_contact%></span><span id=""><%=address_list[i].user_address_phone%></span><% if (address_list[i].user_address_default == 1) { %><sub>默认</sub><% } %></dt>
        <dd><span id=""><%=address_list[i].user_address_area %>&nbsp;<%=address_list[i].user_address_address %></span></dd>
    </dl>
    </li>
    <% }} %>
</script>
<script type="text/html" id="invoice-list-script">
    <div  id="normal">
        <!-- 新增 -->
         <label class="checked"><i></i>
            <input type="radio" name="inv_ele_title" id="inv_ele_title" checked="checked" value="个人"/>
            <span >个人</span>
        </label>
        <label class="input-box"><i></i>
            <input type="radio" name="invoice_id" <% if (electron.length > 0) {%> value="<%=electron[0].invoice_id%>" <% } %>/>
            <span >企业</span>
            <input <% if (electron.length > 0) {%> id="inv_<%=electron[0].inv_id%>" <% } %> type="text" class="inp_input" name="inv_ele_title" <% if (electron.length > 0) {%>value="<%=electron[0].invoice_title%>"<% } %> placeholder="输入个人或企业名称">
        </label>



        <% if (normal.length > 0) {%>
        <ul class="form-box">
           <!--  <li class="form-item" id="inv-title-li">
                <h4>发票抬头</h4>
                <div class="input-box">
                    <select id="inc_normal_title" name="inv_normal_title" class="select">
                        <% for (var i=0; i<normal.length; i++) { %>
                        <option value="<%=normal[i].invoice_title%>"><%=normal[i].invoice_title%></option>
                        <% } %>
                    </select>
                    <i class="arrow-down"></i>
                </div>
            </li> -->

            <li class="form-item">
                <h4>发票内容</h4>
                <div class="input-box">
                    <select id="inc_normal_content" name="inv_normal_content" class="select">
                        <option value="明细">明细</option>
                        <option value="办公用品">办公用品</option>
                        <option value="电脑配件">电脑配件</option>
                        <option value="耗材">耗材</option>
                    </select>
                    <i class="arrow-down"></i>
                </div>
            </li>
        </ul>
        <% } %>

       <!--  <label id="invoiceNew"><i></i>
            <input type="checkbox" name="invoice" style="display: none;" <% if (normal.length == 0) { %>checked="checked"<% } %> value="0"/><span>新增发票内容</span>
        </label> -->
    </div>



    <div id="electron" style="display: none;">
        <label class="checked"><i></i>
            <input type="radio" name="inv_ele_title" checked="checked" value="个人"/>
            <span >个人</span>
        </label>
        <label class="input-box"><i></i>
            <input type="radio" name="invoice_id" <% if (electron.length > 0) {%> value="<%=electron[0].invoice_id%>" <% } %>/>
            <span >企业</span>
            <input <% if (electron.length > 0) {%> id="inv_<%=electron[0].inv_id%>" <% } %> type="text" class="inp_input" name="inv_ele_title" <% if (electron.length > 0) {%>value="<%=electron[0].invoice_title%>"<% } %> placeholder="输入个人或企业名称">
        </label>
        <ul class="form-box">
            <li class="form-item">
                <h4>发票内容</h4>
                <div class="input-box">
                    <select id="inc_content" name="inv_ele_content" class="select">
                        <option value="明细">明细</option>
                        <option value="办公用品">办公用品</option>
                        <option value="电脑配件">电脑配件</option>
                        <option value="耗材">耗材</option>
                    </select>
                    <i class="arrow-down"></i>
                </div>
            </li>
            <li class="form-item">
                <h4>手  &nbsp;机  &nbsp;号 </h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_ele_phone" <% if (electron.length > 0) {%>value="<%=electron[0].invoice_rec_phone%>"<% } %> placeholder="输入收票人手机号">
                </div>
            </li>
            <li class="form-item">
                <h4>电子邮箱</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_ele_email" <% if (electron.length > 0) {%>value="<%=electron[0].invoice_rec_email%>"<% } %> placeholder="输入收票人电子邮箱">
                </div>
            </li>
        </ul>
        <style>
            .inp_input {
                border: 0 none !important;
                color: #000;
                font-size: 0.6rem;
                line-height: 0.95rem;
                min-height: 0.95rem;
                width: 90%;
            }
        </style>
    </div>

    <div  id="addtax" style="display: none;">
        <ul class="form-box">
            <li class="form-item">
                <h4>单位名称</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_title" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_company%>"<% } %> placeholder="输入单位名称">
                </div>
            </li>
            <li class="form-item">
                <h4>纳税人识别码</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_code" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_code%>"<% } %> placeholder="输入纳税人识别码">
                </div>
            </li>
            <li class="form-item">
                <h4>注册地址</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_address" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_reg_addr%>"<% } %> placeholder="输入注册地址">
                </div>
            </li>
            <li class="form-item">
                <h4>注册电话</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_phone" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_reg_phone%>"<% } %> placeholder="输入注册电话">
                </div>
            </li>
            <li class="form-item">
                <h4>开户银行</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_bank" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_reg_bname%>"<% } %> placeholder="输入开户银行">
                </div>
            </li>
            <li class="form-item">
                <h4>银行账户</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_bankaccount" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_reg_baccount%>"<% } %> placeholder="输入银行账户">
                </div>
            </li>
            <li class="form-item">
                <h4>发票内容</h4>
                <div class="input-box">
                    <select id="inc_tax_content" name="inv_tax_content" class="select">
                        <option value="明细">明细</option>
                        <option value="办公用品">办公用品</option>
                        <option value="电脑配件">电脑配件</option>
                        <option value="耗材">耗材</option>
                    </select>
                    <i class="arrow-down"></i>
                </div>
            </li>
            <li class="form-item">
                <h4>收票人姓名</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_recname" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_rec_name%>"<% } %> placeholder="输入收票人姓名">
                </div>
            </li>
            <li class="form-item">
                <h4>收票人手机</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_recphone" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_rec_phone%>"<% } %> placeholder="输入收票人手机">
                </div>
            </li>
            <li class="form-item">
                <h4>收票人省份</h4>
                <div class="input-box">
                    <input type="text" id="invoice_area_info" class="inp" name="invoice_tax_rec_province" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_rec_province%>" data-areaid1="<%=addtax[0].invoice_province_id%>" data-areaid2="<%=addtax[0].invoice_city_id%>" data-areaid3="<%=addtax[0].invoice_area_id%>" data-areaid="<%=addtax[0].invoice_province_id%>" <% } %> placeholder="输入收票人省份">
                </div>
            </li>
            <li class="form-item">
                <h4>详细地址</h4>
                <div class="input-box">
                    <input type="text" class="inp" name="inv_tax_rec_addr" <% if (addtax.length > 0) {%>value="<%=addtax[0].invoice_goto_addr%>"<% } %> placeholder="输入收票人详细地址">
                </div>
            </li>
        </ul>
    </div>

</script>

<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/iscroll.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../..//js/fly/requestAnimationFrame.js"></script>
<script type="text/javascript" src="../../js/fly/zepto.fly.min.js"></script>
<script type="text/javascript" src="../../js/tmpl/order_payment_common.js"></script>
<script type="text/javascript" src="../../js/tmpl/buy_step1.js"></script>
<script type="text/javascript" src="../../js/tmpl/integral_product_buy.js"></script>

</body>
</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>