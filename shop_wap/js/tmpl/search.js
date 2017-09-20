$(function ()
{
    Array.prototype.unique = function ()
    {
        var e = [];
        for (var t = 0; t < this.length; t++)
        {
            if (e.indexOf(this[t]) == -1)
            {
                e.push(this[t])
            }
        }
        return e
    };
    var e = decodeURIComponent(getQueryString("keyword"));
    if (e)
    {
        $("#keyword").val(e);
        writeClear($("#keyword"))

        if(window.localStorage){

            if (('undefined' != typeof window.localStorage['his_list']))
            {
                var td = window.localStorage['his_list'].split(',');
            }
            else
            {
                var td = [];
            }


            if (-1 == $.inArray(e, td))
            {
                td.push(e);
            }

            window.localStorage['his_list'] = td;
        }else{
        }

    }
//    $("#keyword").on("input", function ()
//    {
//        var e = $.trim($("#keyword").val());
//        if (e == "")
//        {
//            $("#search_tip_list_container").hide()
//        }
//        else
//        {
//            $.getJSON(ApiUrl + "/index.php?act=goods&op=auto_complete", {term: $("#keyword").val()}, function (e)
//            {
//                if (!e.data.error)
//                {
//                    var t = e.data;
//                    t.WapSiteUrl = WapSiteUrl;
//                    if (t.list.length > 0)
//                    {
//                        $("#search_tip_list_container").html(template.render("search_tip_list_script", t)).show()
//                    }
//                    else
//                    {
//                        $("#search_tip_list_container").hide()
//                    }
//                }
//            })
//        }
//    } );
    var f = getQueryString("f");
    var groupbuy_type = getQueryString("groupbuy_type");
    if(f === 'groupbuy'){
        $('.goods-class').hide(); 
        search_type = 'groupbuy_keyword'+groupbuy_type;
        
    }else{
        $('.goods-class').show();
        search_type = 'keyword';//默认按商品搜索
    }
    
    //搜索点击下拉选择搜索类型
    $('.goods-class').click(function(){
        var display = $('.goods-class-sel').css('display');
        if(display == 'none')
        {
            $('.goods-class-sel').show();
        }
        else
        {
            $('.goods-class-sel').hide();
        }
    })
    
    //点击选择搜索商品还是店铺
    $('.goods-class-sel').on('click', 'li', function(){
        $('.search_kind').removeClass('active');
        $(this).addClass('active');
        var type_name = $(this).find('span').html();
        $('.goods-class').find('span').html(type_name);
        $('.goods-class-sel').hide();
        if(type_name == '宝贝')
            search_type = 'keyword';
        else
            search_type = 'shop';
    })

    $(".input-del").click(function ()
    {
        $(this).parent().removeClass("write").find("input").val("")
    });
    template.helper("$buildUrl", buildUrl);
    $.getJSON(ApiUrl + "/index.php?ctl=Index&met=getSearchKeyList&typ=json", function (e)
    {
        var hot_list = e.data.list;
        if(typeof(hot_list) !== 'undefined'  && hot_list!==''){
          
            for (var i = 0; i < hot_list.length; i++) {
//                $('#hot_kw_url').append('<li><a class="hot_kw_url_click">' + hot_list[i] + '</a></li>');
                $('#hot_kw_url').append('<li><a  href="javascript:;">' + hot_list[i] + '</a></li>');
            }
        }

//        $("#hot_list_container").html(template.render("hot_list", t));
//        $("#search_his_list_container").html(template.render("search_his_list", t))
    });
    
    $("#header-nav").click(function ()
    {
	//判断cookie是否存在
        var kw = $("#keyword").val();
        if(kw)
        {
            add_keyword_cookie(kw);
        }
	    window.location.href = buildUrl(search_type, kw);
    });

    //热门搜索和历史记录根据当前搜索类型搜索
    $('#hot_kw_url,#history_kw_url').on('click', 'li', function(){
        var kw = $(this).find('a').html();
        if(kw)
        {
            add_keyword_cookie(kw);
        }
        window.location.href = buildUrl(search_type, kw);
    })

    //清空历史记录
    $('#clear-history').click(function(){
        $.sDialog({
            content: "确认清空历史记录？", okFn: function () {
                clear_history();
                $('.history-keyword').hide();
            }
        })
    });

    //清空历史记录
    function clear_history()
    {
        delCookie('hisSearch');
        $('#history_kw_url li').remove();
    }
    // 初始化搜索记录
    initlist();
    function initlist() {
        var history_wd = getCookie('hisSearch');
        $('#history_kw_url li').remove();
        if (history_wd) {
            history_wds = history_wd.split(',');
            for (var i = 0; i < history_wds.length; i++) {
                $('#history_kw_url').append('<li><a href="javascript:;">' + history_wds[i] + '</a></li>');
            }
        }else{
            $('.history-keyword').hide();
        }
        return ;
    };
//    function go_keyword_url(keyword){
//        //添加搜索记录
//        add_keyword_cookie(keyword);
//        window.location.href = buildUrl("keyword", keyword);
//    } 
    
    function add_keyword_cookie(kw){
        kw = $.trim(kw);
        var history_wd = getCookie('hisSearch');
        if (history_wd) {
            history_wds = history_wd.split(',');
            var wk_flag = 0;
            for (var i = 0; i < history_wds.length; i++) {
                if(history_wds[i] === kw){
                    //存在就跳出
                    wk_flag = 1;
                    break;
                }
                else if(!kw)
                {
                    wk_flag = 1;
                    break;
                }
            }
            if(wk_flag === 0){
                //添加
                addCookie('hisSearch',kw + ',' + history_wd);
            }
        }else{
            //添加
            addCookie('hisSearch', kw);
        }
        return ;
    }

});