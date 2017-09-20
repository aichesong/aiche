var order_id = getQueryString('order_id');
var shop_id = '';
var map_index_id = '';
var map_list = [];
$(function(){
    var key = getCookie('key');
    if(!key){
        window.location.href = WapSiteUrl+'/tmpl/member/login.html';
    }
    $.getJSON(ApiUrl + '/index.php?ctl=Buyer_Order&met=virtual&act=detail&typ=json',{k: getCookie("key"),u: getCookie("id"),order_id:order_id}, function(result) {
        if (result.status == 250) {
            return ;
        }
        result.data.WapSiteUrl = WapSiteUrl;
        $('#order-info-container').html(template.render('order-info-tmpl',result.data));
        $('#buyer_phone').val(result.data.buyer_phone);
        $(".nctouch-vr-order-codes ul li img").each(function(){
            var code_img = $(this);
            $(this).parent().find("span").click( function () { code_img.toggle();});
        });

        // 取消
        $(".cancel-order").click(cancelOrder);
        // 评价
        $(".evaluation-order").click(evaluationOrder);
        // 全部退款
        $('.all_refund_order').click(allRefundOrder);
        $('#resend').click(reSend);
        $('#tosend').click(toSend);

        $.getJSON(ApiUrl + '/index.php?ctl=Buyer_Order&met=getEntityList&typ=json', {k: getCookie("key"),u: getCookie("id"),shop_id:result.data.shop_id},function(result){
            if (result.status == 250) {
                return ;
            }
            $('#list-address-ul').html(template.render('list-address-script',result.data));
            if (result.data.addr_list.length > 0) {
                map_list = result.data.addr_list;
                var _html = '';
                _html += '<dl index_id="0">';
                _html += '<dt>'+ map_list[0].name_info +'</dt>';
                _html += '<dd>'+ map_list[0].address_info +'</dd>';
                _html += '</dl>';
                _html += '<p><a href="tel:'+ map_list[0].phone_info +'"></a></p>';
                $('#goods-detail-o2o').html(_html);
                $('#goods-detail-o2o').on('click','dl',map);
                if (map_list.length > 1) {
                    $('#store_addr_list').html('查看全部'+map_list.length+'家分店地址');
                } else {
                    $('#store_addr_list').html('查看商家地址');
                }
                $('#map_all > em').html(map_list.length);
            } else {
                $('.nctouch-vr-order-location').hide();
            }
        });
        $.animationLeft({
            valve : '#store_addr_list',
            wrapper : '#list-address-wrapper',
            scroll : '#list-address-scroll'
        });
    });

    //取消订单
    function cancelOrder(){
        var order_id = $(this).attr("order_id");

        $.sDialog({
            content: '确定取消订单？',
            okFn: function() { cancelOrderId(order_id); }
        });
    }

    function cancelOrderId(order_id) {
        $.ajax({
            type:"post",
            url: ApiUrl + "/index.php?ctl=Buyer_Order&met=orderCancel&typ=json",
            data: {order_id: order_id, k: getCookie('key'), u: getCookie('id'), user: 'buyer'},
            dataType:"json",
            success:function(result){
                if(result.data && result.status == 200){
                    window.location.reload();
                }
            }
        });
    }

    function reSend(){
        // 从下到上动态显示隐藏内容
        $.animationUp({valve:'',scroll:''});
        $('#buyer_phone').on('blur',function(){
            if ($(this).val() != '' && ! /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test($(this).val())) {
                $(this).val(/\d+/.exec($(this).val()));
            }
        });
    };

    function toSend(){
        var buyer_phone = $('#buyer_phone').val();
        $.ajax({
            type:"post",
            url:ApiUrl+"/index.php?act=member_vr_order&op=resend",
            data:{order_id:order_id,buyer_phone:buyer_phone,key:key},
            dataType:"json",
            success:function(result){
                if(result.data && result.data == 1){
                    $('.nctouch-bottom-mask').addClass('down').removeClass('up');
                } else {
                    $('.rpt_error_tip').html(result.data.error).show();
                }
            }
        });
    }

    // 评价
    function evaluationOrder() {
        var orderId = $(this).attr('order_id');
        location.href = WapSiteUrl + '/tmpl/member/member_vr_evaluation.html?order_id=' + orderId;

    }
    // 全部退款
    function allRefundOrder() {
        var orderId = $(this).attr('order_id');
        location.href = WapSiteUrl + '/tmpl/member/refund_all.html?order_id=' + orderId;
    }

    $('#list-address-scroll').on('click','dl > a,#map_all',map);
    $('#map_all').on('click',map);

    function map(){
        $('#map-wrappers').removeClass('hide').removeClass('right').addClass('left');
        $('#map-wrappers').on('click', '.header-l > a', function(){
            $('#map-wrappers').addClass('right').removeClass('left');
        });
        $('#baidu_map').css('width', document.body.clientWidth);
        $('#baidu_map').css('height', document.body.clientHeight);
        map_index_id = $(this).attr('index_id');
        if (typeof map_index_id != 'string'){
            map_index_id = '';
        }
        if (typeof(map_js_flag) == 'undefined') {
            $.ajax({
                url: WapSiteUrl+'/js/map.js',
                dataType: "script",
                async: false
            });
        }
        if (typeof BMap == 'object') {
            baidu_init();
        } else {
            load_script();
        }
    }
});