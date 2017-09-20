var kefu_click = true;
function tidyStoreNewGoodsData(t) {
    if (t.items.length <= 0) {
        return t
    }
    var e = $("#newgoods").find('[addtimetext="' + t.items[0].common_add_time + '"]');
    var o = "";
    $.each(t.items, function (s, r) {
        if (o != r.goods_addtime_text && e.html() == null) {
            t.items[s].goods_addtime_text_show = r.common_add_time;
            o = r.common_add_time
        }
    });
    return t
}
$(function () { 

    var t = getCookie("key");
    var e = getQueryString("shop_id");
    if (!e) {
        window.location.href = WapSiteUrl + "/index.html"
    }
    $("#goods_search").attr("href", "store_search.html?shop_id=" + e);
    $("#store_categroy").attr("href", "store_search.html?shop_id=" + e);
    $("#store_intro").attr("href", "store_intro.html?shop_id=" + e);
    function o() {
        $("#store_sliders").each(function () {
            if ($(this).find(".item").length < 2) {
                return
            }
            Swipe(this, {
                startSlide: 2,
                speed: 400,
                auto: 3e3,
                continuous: true,
                disableScroll: false,
                stopPropagation: false,
                callback: function (t, e) {
                },
                transitionEnd: function (t, e) {
                }
            })
        })
    }

    $.ajax({
        type: "post",
        url: ApiUrl + "/index.php?ctl=Shop&met=getStoreInfo&typ=json",
        data: {k: t, u: getCookie('id'), shop_id: e},
        dataType: "json",
        success: function (t) {
                var tel = t.data.store_info.store_tel; 
                $.getJSON(SiteUrl+'/index.php?ctl=Api_Wap&met=version_im&typ=json',function(r){
                        var st = r.data.im; 
                        if(st == 1){  
                            $('#store_kefu').show();  
                        }else if(tel){
                            kefu_click = false;
                            setTimeout(function(){
                                $('#store_kefu').attr('href',"tel:"+tel).show(); 
                            },500);
                        }
                }); 
             

            var e = t.data;
            var s = e.store_info.store_name + " - 店铺首页";
            document.title = s;
            var r = template.render("store_banner_tpl", e);

            if(getCookie('is_app_guest')){
                $('#shareit_store').attr("href","/share_toall.html?shop_id="+e.store_info.shop_id+"&title="+encodeURIComponent(e.store_info.store_name)+"&img="+e.store_info.store_avatar+"&url="+WapSiteUrl+"/tmpl/store.html?shop_id="+e.store_info.shop_id);
            }

            $("#store_banner").html(r);
            if (e.store_info.is_favorate) {
                $("#store_notcollect").hide();
                $("#store_collected").show()
            } else {
                $("#store_notcollect").show();
                $("#store_collected").hide()
            }
            
            if (e.voucher_list.length > 0) {
                var voucher_list = template.render("voucher_list_tpl", e);
                $("#voucher_list_div").show()
                $("#voucher_list_div").html(voucher_list);
            } else {
                $("#voucher_list_div").hide()
            }
            
            if (e.store_info.mb_title_img) {
                $(".store-top-bg .img").css("background-image", "url(" + e.store_info.mb_title_img + ")")
            } else {
                var a = [];
                a[0] = WapSiteUrl + "/images/store_h_bg_01.jpg";
                a[1] = WapSiteUrl + "/images/store_h_bg_02.jpg";
                a[2] = WapSiteUrl + "/images/store_h_bg_03.jpg";
                a[3] = WapSiteUrl + "/images/store_h_bg_04.jpg";
                a[4] = WapSiteUrl + "/images/store_h_bg_05.jpg";
                var i = Math.round(Math.random() * 4);
                $(".store-top-bg .img").css("background-image", "url(" + a[i] + ")")
            }
            if (e.store_info.mb_sliders.length > 0) {
                var r = template.render("store_sliders_tpl", e);
                $("#store_sliders").html(r);
                o()
            } else {
                $("#store_sliders").parent().hide()
            }

           
           if(kefu_click == true){
                $('.kefu').click(function(){
                    if(!getCookie("key")){
                        alert_box("请先登录");
                        return;
                    }
                    if (window.chatTo)
                    {
                        chatTo(e.store_info.user_name.toString());

                    }
                    else if(window.android)
                    {
                        if(window.android.chatTo)
                        {
                            window.android.chatTo(e.store_info.user_name.toString(),e.store_info.store_name,e.store_info.store_avatar);
                        }

                    }
                    else
                    {
                        window.location.href = WapSiteUrl+'/tmpl/im-chatinterface.html?contact_type=C&contact_you=' + e.store_info.user_name + '&uname=' + getCookie('user_account');
                    }

                })
           } 

            
            var r = template.render("goods_recommend_tpl", e);
            $("#goods_recommend").html(r)
        }
    });
    $("#goods_rank_tab").find("a").click(function () {
        $("#goods_rank_tab").find("li").removeClass("selected");
        $(this).parent().addClass("selected").siblings().removeClass("selected");
        var t = $(this).attr("data-type");
        var o = t == 'collect' ? 'common_collect' : 'common_salenum';
        var s = 3;
        $("[nc_type='goodsranklist']").hide();
        $("#goodsrank_" + t).show();
        if ($("#goodsrank_" + t).html()) {
            return
        }
        $.ajax({
            type: "post",
            url: ApiUrl + "/index.php?ctl=Shop&met=goodsList&sort=desc&typ=json",
            data: {id: e, order: o, num: s, sort: 'desc'},
            dataType: "json",
            success: function (e) {
                if (e.status == 200) {
                    var o = template.render("goodsrank_" + t + "_tpl", e.data);
                    $("#goodsrank_" + t).html(o)
                }
            }
        })
    });
    $("#goods_rank_tab").find("a[data-type='collect']").trigger("click");
    $("#nav_tab").waypoint(function () {
        $("#nav_tab_con").toggleClass("fixed");
       
    }, {offset: "50"});
    function s() {
        var t = {};
        t.id = e;
        var o = new ncScrollLoad;
        o.loadInit({
            url: ApiUrl + "/index.php?ctl=Shop&met=goodsList&order=common_sell_time&sort=desc&typ=json",
            getparam: t,
            tmplid: "newgoods_tpl",
            containerobj: $("#newgoods"),
            iIntervalId: true,
            resulthandle: "tidyStoreNewGoodsData"
        })
    }

    function r() {
        $.ajax({
            type: "post",
            url: ApiUrl + "/index.php?ctl=Shop&met=getShopPromotion&typ=json",
            data: {shop_id: e},
            dataType: "json",
            success: function (t) {
                t.data.shop_id = e;
                var o = template.render("storeactivity_tpl", t.data);

                if ($.trim(o))
                {
                    $("#storeactivity_con").html(o)
                }
            }
        })
    }

    $("#nav_tab").find("a").click(function () {
        $("#nav_tab").find("li").removeClass("selected");
        $(this).parent().addClass("selected").siblings().removeClass("selected");
        $("#storeindex_con,#allgoods_con,#newgoods_con,#storeactivity_con").hide();
        window.scrollTo(0, 0);
        var t = $(this).attr("data-type");
        switch (t) {
            case"storeindex":
                $("#storeindex_con").show();
                o();
                break;
            case"allgoods":
                if (!$("#allgoods_con").html()) {
                    $("#allgoods_con").load("store_goods_list.html", function () {
                        $(".goods-search-list-nav").addClass("posr");
                        $(".goods-search-list-nav").css("top", "0");
                        $("#sort_inner").css("position", "static")
                    })
                }
                $("#allgoods_con").show();
                break;
            case"newgoods":
                if (!$("#newgoods").html()) {
                    s()
                }
                $("#newgoods_con").show();
                break;
            case"storeactivity":
                if (!$("#storeactivity_con").html()) {
                    r()
                }
                $("#storeactivity_con").show();
                break
        }
    });
    $("#store_voucher").click(function () {
        if (!$("#store_voucher_con").html()) {
            $.ajax({
                type: "post",
                url: ApiUrl + "/index.php?ctl=Voucher&met=vList&typ=json",
                data: {store_id: e, gettype: "free"},
                dataType: "json",
                async: false,
                success: function (t) {
                    if (t.status == 200) {
                        var e = template.render("store_voucher_con_tpl", t.data);
                        $("#store_voucher_con").html(e)
                    }
                }
            })
        }
        $.animationUp({valve: ""})
    });
    $("#store_voucher_con").on("click", '[nc_type="getvoucher"]', function () {
        getFreeVoucher($(this).attr("data-tid"))
    });
    $("#store_notcollect").live("click", function () {
        var t = favoriteStore(e);
        if (t) {
            $("#store_notcollect").hide();
            $("#store_collected").show();
            var o;
            var s = (o = parseInt($("#store_favornum_hide").val())) > 0 ? o + 1 : 1;
            $("#store_favornum").html(s);
            $("#store_favornum_hide").val(s)
        }
    });
    $("#store_collected").live("click", function () {
        var t = dropFavoriteStore(e);
        if (t) {
            $("#store_collected").hide();
            $("#store_notcollect").show();
            var o;
            var s = (o = parseInt($("#store_favornum_hide").val())) > 1 ? o - 1 : 0;
            $("#store_favornum").html(s);
            $("#store_favornum_hide").val(s)
        }
    })
});

