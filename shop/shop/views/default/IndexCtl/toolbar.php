<style>
    .cart_list_ordernum .tm-mcMinus, .cart_list_ordernum .tm-mcPlus {
        width: 14px;
        border-radius: 14px;
        border: 1px solid #bfbfbf;
        position: relative;
        cursor: pointer;
        display: inline-block;
        height: 14px;
        visibility: hidden;
    }

    .cart_list_ordernum s {
        width: 8px;
        height: 2px;
        top: 6px;
        left: 3px;

    }

    .cart_list_ordernum b {
        width: 2px;
        height: 8px;
        top: 3px;
        left: 6px;
    }

    .cart_list_ordernum s, .cart_list_ordernum b {
        position: absolute;
        overflow: hidden;
        background: #bfbfbf;
    }

    .cart_list_ordernum .tm-mcMinusOff s {
        background: #e6e6e6;
    }

    .tm-mcOrderActive .tm-mcMinus, .tm-mcOrderActive .tm-mcPlus {
        visibility: visible;
        background: #f3f3f3;
    }

    .tm-mcDel {
        float: right;
        display: none;
    }

    .tm-mcOrderActive .tm-mcDel {
        display: block;
    }
</style>
<script type="text/javascript" src="<?= $this->view->js ?>/nav.js"></script>
<div class="toolbar-wrap J-wrap">
    <div class="toolbar">
        <div class="toolbar-panels J-panel">
            <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-news toolbar-animate-out ">
                <div class="toolbar-panelff">
                    <div class="padd2">
                        <a class="close_p ml10"><?=__('关闭')?><i class="iconfont icon-youshaungjiantou"></i></a>
                        <p class="view_all"><a href="<?= Yf_Registry::get('url') ?>?ctl=Buyer_Cart&amp;met=cart"><?=__('全屏查看')?></a></p>
                    </div>
                    <div class="tbar-panel-main tbar-panel-main-sidebar news_contents">
                        <ul>

                            <?php if(!empty($Announcement['items'])){?>
                                <?php
                                        foreach($Announcement['items'] as $k=>$v){ ?>
                                    <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Article_Base&article_id=<?= $v['article_id'] ?>" target="_blank">&bull;&nbsp;<?=$v['article_title']?></a></li>
                                    <?php }?>
                                        <?php }else{?>
                                            <div class="item_cons_no">
                                                <?=__('公告为空')?>
                                            </div>
                                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-cart toolbar-animate-out">
                <div class="padd2">
                    <a class="close_p ml10">
                        <?=__('关闭')?><i class="iconfont icon-youshaungjiantou"></i></a>
                    <p class="view_all">
                        <a href="<?=Yf_Registry::get('url')?>?ctl=Buyer_Cart&met=cart">
                            <?=__('全屏查看')?>
                        </a>
                    </p>
                </div>
                <?php $count = 0;
                                if(isset($cart_list) && $cart_list['count']) :
                            ?>
                    <div class="padd2 Js-toolbar-cart">
                        <p class="select_all clearfix ml10 Js-toolbar-cart">
                            <input type="checkbox" class="checkall checkcart rel_top2"><span><?=__('全选')?></span></p>
                    </div>

                  

                        <div class="tbar-panel-main tbar-panel-main-sidebar cart_con Js-toolbar-cart">
                          <form id="form" action="?ctl=Buyer_Cart&met=confirm" method='post'>
                            <?php
                                    $count = $cart_list['count'];
                                        unset($cart_list['count']);
                                        foreach($cart_list as $cartk => $cartv):
                                    ?>
                                <div class="cart_contents">
                                    <div class="cart_contents_head">
                                        <div class="cart_contents_inp">
                                            <input class="tm-mcElectBundle checkitem checkshop checkcart" type="checkbox" value="<?=($cartk)?>">
                                        </div>
                                        <div class="cart_contents_title">
                                            <a href="<?= Yf_Registry::get('url') ?>?ctl=Shop&met=Index&id=<?=($cartv['shop_id'])?>"><span title="<?=($cartv['shop_name'])?>"><?=($cartv['shop_name'])?></span></a>
                                            <?php if(isset($cartv['mansong_info']['rule_discount'])){?>
                                                <?=__('（促销）')?>
                                                    <?php }?>
                                        </div>
                                        <div class="cart_contents_cost">
                                            <strong class="">
                                                <?=format_money($cartv['sprice'])?>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="cart_lists">
                                        <?php foreach($cartv['goods'] as $cartgk => $cartgv):?>
                                            <div class="cart_list" data-cart-id="<?= $cartgv['cart_id']; ?>">
                                                <div class="cart_list_order clearfix">
                                                    <div class="cart_list_orderinp cart-checkbox">
                                                        <input type="checkbox" value="<?=($cartgv['cart_id'])?>" class="checkitem checkcart" name="product_id[]">
                                                    </div>
                                                    <div class="cart_list_orderimg">
                                                        <a href="<?=Yf_Registry::get('url')?>?ctl=Goods_Goods&met=goods&type=goods&gid=<?=($cartgv['goods_id'])?>" target="_blank">
                                                        <img src="<?=image_thumb($cartgv['goods_base']['goods_image'],50,50)?>">
                                                    </a>
                                                    </div>
                                                    <div class="cart_list_ordersize">
                                                        <?php if(is_array($cartgv['goods_base']['spec'])):
                                                            foreach($cartgv['goods_base']['spec'] as $cartgsk => $cartgsv):?>
                                                            <p title="<?=($cartgsv)?>">
                                                                <?php echo  substr(strstr($cartgsv,':'),1);?>
                                                            </p>
                                                            <?php endforeach;
                                                    endif;?>
                                                    </div>
                                                    <div class="cart_list_ordernum">
                                                        <a href="javascript:void(0)" class="tm-mcMinus <?= $cartgv['goods_num'] == 1 ? "tm-mcMinusOff" : "" ?>" hidefocus="true"><s></s></a>
                                                        <span class="tm-mcQuantity"><?=($cartgv['goods_num'])?></span>
                                                        <a href="javascript:void(0)" class="tm-mcPlus" hidefocus="true"><s></s><b></b></a>
                                                    </div>
                                                    <div class="cart_list_ordercost" style="width: 42px;">
                                                        <a href="javascript:void(0)" class="tm-mcDel" title="删除" data-tmc="del">删除</a>
                                                        <strong class="tm-mcPrice"><?=format_money($cartgv['sumprice'])?></strong>
                                                        <input type="hidden" class="goods_sumprice" value="<?=($cartgv['sumprice'])?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach;?>
                                    </div>
                                </div>
                                <?php
                                        endforeach;
                                    ?>
                            </form>
                        </div>
                    
                    <div class="cart_pay Js-toolbar-cart">
                        <div class="padd">
                            <div class="cart_foot clearfix"><span class="have_sel"><?=__('已选')?><i>0</i><?=__('件')?></span>
                                <span class="cartall"><?=Web_ConfigModel::value("monetary_unit")?>0.00</span></div>
                            <div class="topay">
                                <a class="submit-btn-disabled submit-btn bbc_bg_col">
                                    <?=__('结算')?><b class="yuan iconfont icon-iconjiantouyou"></b>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="item_cons_no">
                            <?=__('购物车为空')?>
                        </div>
                        <?php endif;?>
            </div>
            <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-assets toolbar-animate-out">
                <div class="padd">
                    <p>
                        <a href="#" class="close_p">
                            <?=__('关闭')?><i class="iconfont icon-youshaungjiantou"></i></a>
                        <a href="<?= Yf_Registry::get('paycenter_api_url') ?>" class="view_all">
                            <?=__('全屏查看')?>
                        </a>
                    </p>
                    <ul class="assets_overview clearfix">
                        <li>
                            <a href="<?= Yf_Registry::get('url') ?>?ctl=Buyer_Points&met=points">
                                <span><?=@$user_list['user_points'];?></span>
                                <h6><?=__('积分')?></h6>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Yf_Registry::get('url') ?>?ctl=Buyer_User&met=getUserGrade">
                                <span><?=@$user_list['user_growth'];?></span>
                                <h6><?=__('成长值')?></h6>
                            </a>
                        </li>

                    </ul>
                    <div class="other_voucher"></div>
                </div>
            </div>
            <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-follow toolbar-animate-out">
                <div class="padd">
                    <p>
                        <a href="#" class="close_p">
                            <?=__('关闭')?><i class="iconfont icon-youshaungjiantou"></i></a>
                        <a href="<?= Yf_Registry::get('url') ?>?ctl=Buyer_Favorites&met=favoritesShop" class="view_all">
                            <?=__('全屏查看')?>
                        </a>
                    </p>
                    <div class="item_cons">
                        <?php if(!empty($shop_list['items'])){?>
                            <?php
                                        foreach($shop_list['items'] as $k=>$v){ ?>
                                <div class="item">
                                    <img class="brand_logo" src="<?=image_thumb($v['shop_logo'],90,45)?>">
                                    <a class="barnd_shop" href="<?= Yf_Registry::get('url') ?>?ctl=Shop&met=index&typ=e&id=<?=$v['shop_id']?>">
                                        <?=__('进入店铺')?>
                                    </a>
                                    <div class="brand_goodsList">
                                        <?php if(!empty($v['detail']['items'])){?>
                                            <?php foreach($v['detail']['items'] as $kk=>$vv){ ?>
                                                <a href="<?= Yf_Registry::get('url') ?>?ctl=Goods_Goods&met=goods&type=goods&gid=<?=$vv['goods_id']?>">
                                                <img src="<?=image_thumb($vv['common_image'],100,100)?>">
                                                <p class="brand_name" title="<?=$vv['common_name']?>"><?=$vv['common_name']?></p>
                                                <p class="brand_price" title="<?=format_money($vv['common_price'])?>"><?=format_money($vv['common_price'])?></p>
                                            </a>
                                                <?php }?>
                                                    <?php }?>
                                    </div>
                                </div>
                                <?php }?>
                                    <?php }else{?>
                                        <div class="item_cons_no">
                                            <?=__('店铺收藏为空')?>
                                        </div>
                                        <?php }?>
                    </div>
                </div>
            </div>
            <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-history toolbar-animate-out">
                <div class="padd over">
                    <p>
                        <a href="#" class="close_p">
                            <?=__('关闭')?><i class="iconfont icon-youshaungjiantou"></i></a>
                        <a href="<?= Yf_Registry::get('url') ?>?ctl=Buyer_Favorites&met=footprint" class="view_all">
                            <?=__('全屏查看')?>
                        </a>
                    </p>
                    <ul class="history_goods clearfix">
                        <?php if(!empty($footprint_list['items'])){?>
                            <?php
                                            foreach($footprint_list['items'] as $k=>$v){ ?>
                                <?php if(!empty($v['detail'])){?>
                                    <li><a href="<?=Yf_Registry::get('url')?>?ctl=Goods_Goods&met=goods&type=goods&gid=<?=$v['detail']['goods_id']?>"><img src="<?php if(!empty($v['detail']['common_image'])){?><?=image_thumb($v['detail']['common_image'],116,116)?><?php }else{?><?= image_thumb($this->web['goods_image'],116,116)?><?php }?>"/><h5><?=$v['detail']['common_name']?></h5><h6  class="bbc_color"><?=format_money($v['detail']['common_price'])?></h6></a></li>
                                    <?php }?>

                                        <?php }?>
                                            <?php }else{?>
                                                <div class="item_cons_no">
                                                    <?=__('你没有浏览商品')?>
                                                </div>
                                                <?php }?>
                    </ul>
                </div>
            </div>
            <div id="collectGoods" style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-sav toolbar-animate-out">
                <div class="padd over">
                    <p class="padd2">
                        <a href="#" class="close_p">
                            <?=__('关闭')?><i class="iconfont icon-youshaungjiantou"></i></a>
                        <a href="<?= Yf_Registry::get('url') ?>?ctl=Buyer_Favorites&met=favoritesGoods" class="view_all">
                            <?=__('全屏查看')?>
                        </a>
                    </p>
                    <ul class="sav_goods clearfix">
                        <?php if(!empty($goods_list['items'])){?>
                            <?php
                                        foreach($goods_list['items'] as $k=>$v){ ?>
                                <?php if(!empty($v['detail'])){?>
                                    <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Goods_Goods&met=goods&type=goods&gid=<?=$v['goods_id']?>"><img src="<?php if(!empty($v['detail']['goods_image'])){?><?=image_thumb($v['detail']['goods_image'],116,116)?><?php }else{?><?= image_thumb($this->web['goods_image'],116,116)?><?php }?>"/><h5><?=$v['detail']['goods_name']?></h5><h6  class="bbc_color"><?=format_money($v['detail']['goods_price'])?></h6></a></li>
                                    <?php }?>
                                        <?php }?>
                                            <?php }else{?>
                                                <div class="item_cons_no">
                                                    <?=__('你没有收藏商品为空')?>
                                                </div>

                                                <?php }?>
                    </ul>
                </div>
            </div>

        </div>

        <div class="toolbar-header"></div>
        <div class="tbar-tab-news">
            <i class="tab-ico iconfont icon-icongonggao nav_icon news_icon"></i>
            <em class="tab-text "><?=__('通知')?></em>
            <span class="tab-sub J-count hide"></span>
        </div>
         <div class="tbar-tab-online-contact">
            <i class="tab-ico iconfont icon-logo_im nav_icon"></i>
            <em class="tab-text "><?=__('在线联系')?></em>
            <span class="tab-sub J-count hide"></span>
        </div>

        <div class="toolbar-tabs J-tab">
            <div class="nav_head">
                <a href="./index.php?ctl=Buyer_Index&met=index">
                              <img src="<?= Yf_Registry::get('ucenter_api_url') ?>?ctl=Index&met=img&user_id=<?= @Perm::$userId ?>"/>
                            </a>
            </div>
            <div class=" toolbar-tab  tbar-tab-cart shopcli">
                <i class="tab-ico iconfont icon-gouwuche2 nav_icon"></i>
                <!-- <span class="shopic">购物车</span> -->
                <em class="tab-text"><?=__('我的购物车')?></em>
                <span class="tab-sub J-count cart_num_toolbar"><?=($count)?></span>
            </div>
            <div class=" toolbar-tab  tbar-tab-assets">
                <i class="tab-ico iconfont icon-iconyouhuiquan nav_icon"></i>
                <em class="tab-text"><?=__('我的资产')?></em>
            </div>
            <div class=" toolbar-tab tbar-tab-follow ">
                <i class="tab-ico iconfont icon-iconshoucang nav_icon"></i>
                <em class="tab-text"><?=__('我的关注')?></em>
                <span class="tab-sub J-count hide"></span>
            </div>
            <div class=" toolbar-tab tbar-tab-sav ">
                <i class="tab-ico iconfont icon-icoheart nav_icon" id="collect_lable"></i>
                <em class="tab-text"><?=__('我的收藏')?></em>
                <span class="tab-sub J-count hide"></span>
            </div>
            <div class=" toolbar-tab tbar-tab-history ">
                <i class="tab-ico iconfont icon-iconzuji nav_icon"></i>
                <em class="tab-text"><?=__('我的足迹')?></em>
                <span class="tab-sub J-count hide"></span>
            </div>
        </div>
        <div class="toolbar-footer">
            <div class="code_screen">
                <a class="about_code iconfont icon-btnsaoma tab-ico nav_icon" href="#"></a>
                <p class="code_cont">
                    <?php if(Web_ConfigModel::value('mobile_wx')){?>
                        <img src="<?= Web_ConfigModel::value('mobile_wx')?>" />
                    <?php }else{ ?>
                        <img src="<?=Yf_Registry::get('base_url')?>/shop/api/qrcode.php?data=<?=urlencode(Yf_Registry::get('shop_wap_url'))?>" width="100%" height="100%"/>
                    <?php }?>
                </p>
            </div>
            <div>
                <a class="about_top iconfont icon-top about_top tab-ico nav_icon" href="#"></a>
            </div>
        </div>

    </div>

    <div id="J-toolbar-load-hook"></div>

</div>

<script>
    $(function () {
        $("input[type='checkbox'][class='checkcart']").prop("checked", false);
        var _TimeCountDown = $(".fnTimeCountDown");
        _TimeCountDown.fnTimeCountDown();
    })

    //全选
    $('.checkall').click(function () {
        var _self = this;
        $('.checkitem').each(function () {
            if (!this.disabled) {
                $(this).prop('checked', _self.checked);
            }
        });
        $('.checkall').prop('checked', this.checked);
        count();
    });

    function count() {
        var count = 0;
        var num = 0;
        $(".cart-checkbox").find("input[name='product_id[]']:checked").each(function () {
            var value = $(this).val();
            var price = /*($(this).parent().parent().find(".cart_list_ordernum span").html()) * */($(this).parent().parent().find(".cart_list_ordercost .goods_sumprice").val());
            //price = price.replace(/,/g, "");
            price = Number(price);
            count = count + price;
            num++;
        });
        $(".cartall").html('￥' + count.toFixed(2));

        $(".have_sel i").html(num);
        if (num > 0) {
            $(".submit-btn").removeClass("submit-btn-disabled");
        } else {
            $(".submit-btn").addClass("submit-btn-disabled");
        }
    }

    //勾选店铺
    $('.checkshop').click(function () {
        var _self = this;
        if (_self.checked) {
            $(this).parents(".cart_contents").find(".checkitem").prop('checked', true);
        } else {
            $(this).parents(".cart_contents").find(".checkitem").prop('checked', false);
        }

        count();
    });

    //单度选择商品
    $('.checkitem').click(function () {
        var _self = this;
        if (!this.disabled) {
            $(this).prop('checked', _self.checked);

            if (_self.checked) {
                //判断该店铺下的商品是否已全选
                if ($(this).parents('.cart_lists').find(".checkitem").not("input:checked").length == 0) {
                    $(this).parents(".cart_contents").find(".checkshop").prop('checked', true);
                }

                //判断是否所有商品都已选择，如果所有商品都选择了就勾选全选
                if ($(".checkitem").not("input:checked").length == 0) {
                    $('.checkall').prop('checked', true);
                }
            } else {
                //判断该店铺下的商品是否已全选
                if ($(this).parents('.cart_lists').find(".checkitem").not("input:checked").length != 0) {
                    $(this).parents(".cart_contents").find(".checkshop").prop('checked', false);
                }

                //判断全选是否勾选，如果勾选就去除
                if ($(".checkitem").not("input:checked").length != 0) {
                    $('.checkall').prop('checked', false);
                }
            }
        }
        count();
    });

    //结算
    $('.submit-btn').click(function () {

        if (!$(this).is('.submit-btn-disabled')) {
            //获取所有选中的商品id
            var chk_value = []; //定义一个数组
            $("input[name='product_id[]']:checked").each(function () {
                chk_value.push($(this).val()); //将选中的值添加到数组chk_value中
            })

            if (chk_value != "") {
                $('#form').submit();
            }
        }

    });
</script>

<script type="text/javascript">
     $(document).ready(function(){
            var nice_scroll_row = ['.sav_goods', '.cart_con', '.item_cons', '.history_goods', '.news_contents', '.other_voucher', '.contrast_goods'];

            $.each($.unique(nice_scroll_row), function(index, data)
            {
                $scroll_obj= $(data);

                if ($scroll_obj.length > 0)
                {
                    $scroll_obj.niceScroll({
                        cursorcolor: "#666",
                        cursoropacitymax: 1,
                        touchbehavior: false,
                        cursorwidth: "3px",
                        cursorborder: "0",
                        cursorborderradius: "3px",
                        autohidemode: false,
                        nativeparentscrolling:true
                    });
                }
            });
    })
</script>



<?php
//im
 
 if(Web_ConfigModel::value('im_statu')==1){
 
?> 
  
        <script>

         $(function(){
         		var user_account_log;

         		<?php if(!isset($_COOKIE['user_account']) && !$_COOKIE['user_account'] ){?>
         		$.ajax({
			        type: "GET",
			        url: SITE_URL + "?ctl=Index&met=getUserLoginInfo&typ=json",
			        data: {},
			        dataType: "json",
			        success: function(data){ 
			        		user_account_log = data.data.user_account;
			        		getCookie('user_account',user_account_log); 
			        }
			      });
         		<?php }?>


            $.get("<?php echo Yf_Registry::get('base_url');?>"+'/index.php?ctl=Api_IM_Im&met=index',function(h){ 
                    $('#imbuiler').attr('src',h);
                    im_builder_ch();
                    iconbtncomment();
            });

            
            function iconbtncomment(){

                $('.icon-btncomment').click(function(){ 

                	if(!getCookie('user_account')){
                			$("#login_content").show();
						          load_goodseval(SITE_URL  + '?ctl=Index&met=fastLogin','login_content');
						          return;
                	}
                	


                		 
                    var ch_u = $('.chat-enter').attr('rel');
                     if(ch_u == getCookie('user_account')){ 
                        
                         alert_box('不能跟自己聊天'); 
                         return ;
                    }
                    var inner = $('#imbuiler')[0].contentWindow;
                    $('#imbuiler').show();
                    //查看聊天右侧的用户列表有没有，没有就点一下最下面的就出来了。
                    var dis = $('#imbuiler').contents().find('.chat-list').css('display');
                     
                    if(dis!='block'){
                        $('#imbuiler').contents().find('.bottom-bar a').click();     
                    }  
                    inner.chat(ch_u);
                    $('#imbuiler')[0].contentWindow.bottom_bar();
                    return false;
                });
            }
         
            function im_builder_ch(){
                     var onl = $(".tbar-tab-online-contact");   
                     onl.show();
                     
                     onl.click(function(){  
                         $('#imbuiler').show();
                         $('#imbuiler')[0].contentWindow.bottom_bar();
                         $('#imbuiler').contents().find('.bottom-bar a').click(); 
                         return;
                         
                     });
            }
             
         });
     </script>
     
<?php }?>



<script type="application/javascript">

    var flag = true; //避免重复点击，幂等性
    $(".toolbar").on("click", ".tm-mcMinus,.tm-mcPlus", function() {

        var $this = $(this);
        if ($this.hasClass("tm-mcMinusOff")) {
            return false;
        }

        if (flag) {
            flag = false
        } else {
            return Public.tips.warning("请等候，正在为您处理！");
        }

        var $cart = $this.parents(".cart_list"),
            $num = $cart.find(".tm-mcQuantity"),
            $price = $cart.find(".tm-mcPrice"),
            $goodsSumPrice = $cart.find(".goods_sumprice"),
            cartId = $cart.data("cart-id"),
            gNum = $num.text(),
            $gMinus;

        $this.hasClass("tm-mcMinus") ? gNum-- && ($gMinus = $this) : gNum++ && ($gMinus = $this.parent(".cart_list_ordernum").children(".tm-mcMinus"));

        Public.ajaxPost(SITE_URL + "?ctl=Buyer_Cart&met=editCartNum&typ=json", {"cart_id": cartId, "num": gNum},
            function(data) {
                if (data.status == 200) {
                    var price = data.data.price.toFixed(2);
                    $num.text(gNum);
                    $price.text("￥" + price);
                    $goodsSumPrice.val(price);
                    gNum == 1 ? $gMinus.addClass("tm-mcMinusOff") : $gMinus.removeClass("tm-mcMinusOff");

                    count();
                } else {
                    Public.tips.warning(data.msg);
                }

            },
            function() {},
            function() { flag = true; }
        )
    });

    $(".toolbar").on({
        "mouseover": function() {
            triggerMouse(this, "over");
        },
        "mouseout": function() {
            triggerMouse(this, "out");
        }
    }, ".cart_list");

    function triggerMouse(_this, type) {
        var $this = $(_this);
        type == "over"
            ? (!$this.hasClass("tm-mcOrderActive") && $this.addClass("tm-mcOrderActive"))
            : ($this.hasClass("tm-mcOrderActive") && $this.removeClass("tm-mcOrderActive"));
    }

    $(".toolbar").on("click", ".tm-mcDel", function() {
        var $cartGoods = $(this).parents(".cart_list");
        Public.ajaxPost(SITE_URL + "?ctl=Buyer_Cart&met=delCartByCid&typ=json", {id: $cartGoods.data("cart-id")},
            function(data) {
                if (data.status == 200) {
                    getCartNum();
                    $cartGoods.parent().children().length == 1
                        ? $cartGoods.parents(".cart_contents").remove()
                        : $cartGoods.remove();

                    $(".cart_list").length == 0
                        ? getCartList()
                        : count();
                } else {
                    Public.tips.warning(data.msg);
                }
            }
        )
    });
</script>
