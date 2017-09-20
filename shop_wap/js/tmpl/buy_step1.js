var key = getCookie('key');
// buy_stop2使用变量
var ifcart = getQueryString('ifcart');
if(ifcart==1){
    if(getQueryString('point_cart_id'))
    {
        var cart_id = getQueryString('point_cart_id');
        var cart_type = 'point';
    }
    else 
    {
        var cart_id = getQueryString('cart_id')
    }
    // var cart_id = getQueryString('cart_id') ? getQueryString('cart_id') : getQueryString('point_cart_id');
    cart_id = cart_id.split(',');
}else{
    var cart_id = getQueryString("goods_id")+'|'+getQueryString("buynum");
}
var pay_name = 'online';
var invoice_id = 0;
var address_id,vat_hash,offpay_hash,offpay_hash_batch,voucher,pd_pay,password,fcode='',rcb_pay,rpt,payment_code;
var message = {};
// change_address 使用变量
var freight_hash,city_id,area_id,province_id;
// 其他变量
var area_info;
var goods_id;



function isEmptyObject(e) {
    var t;
    for (t in e)
        return !1;
    return !0
}

//领取代金券
function getvoucher(id){
    getFreeVoucher(id);
}
$(function() {
    console.info(cart_id);
    var isIntegral = getQueryString("isIntegral");

    // 地址列表
    $('#list-address-valve').click(function(){
        var address_id = $(this).find("#address_id").val();
        $.ajax({
            type:'post',
            url:ApiUrl+"/index.php?ctl=Buyer_Cart&met=confirm&typ=json",
            data:{k:key, u:getCookie('id'),product_id:cart_id},
            dataType:'json',
            async:false,
            success:function(result){
                checkLogin(result.login);
                if(result.data.address==null){
                    return false;
                }
                //console.info(result);
                var data = result.data;
                data.address_id = address_id;
                var html = template.render('list-address-add-list-script', data);
                $("#list-address-add-list-ul").html(html);
            }
        });
    });
    $.animationLeft({
        valve : '#list-address-valve',
        wrapper : '#list-address-wrapper',
        scroll : '#list-address-scroll'
    });

    // 地区选择
    $('#list-address-add-list-ul').on('click', 'li', function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        eval('address_info = ' + $(this).attr('data-param'));
        _init(address_info.user_address_id);
        //console.info(address_info);
        $('#true_name').html(address_info.user_address_contact);
        $('#mob_phone').html(address_info.user_address_phone);
        $('#address').html(address_info.user_address_area + address_info.user_address_address);
        $("#address_id").val(address_info.user_address_id);
        $('#list-address-wrapper').find('.header-l > a').click();
    });

    // 地址新增
    $.animationLeft({
        valve : '#new-address-valve',
        wrapper : '#new-address-wrapper',
        scroll : ''
    });
    // 支付方式
    $.animationLeft({
        valve : '#select-payment-valve',
        wrapper : '#select-payment-wrapper',
        scroll : ''
    });

    // 地区选择
    $('#new-address-wrapper').on('click', '#varea_info', function(){

        $.areaSelected({
            success : function(data){
                //console.info(data);
                province_id = data.area_id_1;
                city_id = data.area_id_2;
                area_id = data.area_id_3;
                area_info = data.area_info;
                $('#varea_info').val(data.area_info);
            }
        });
    });

    //增值税发票中的地区选择
    $('#invoice-list').on('click', '#invoice_area_info', function(){
        $.areaSelected({
            success: function (a)
            {
                $("#invoice_area_info").val(a.area_info).attr({"data-areaid1": a.area_id_1, "data-areaid2": a.area_id_2, "data-areaid3": a.area_id_3, "data-areaid": a.area_id, "data-areaid2": a.area_id_2 == 0 ? a.area_id_1 : a.area_id_2})
            }
        });
    });

    // 发票
    $.animationLeft({
        valve : '#invoice-valve',
        wrapper : '#invoice-wrapper',
        scroll : ''
    });


    template.helper('isEmpty', function(o) {
        var b = true;
        $.each(o, function(k, v) {
            b = false;
            return false;
        });
        return b;
    });

    template.helper('pf', function(o) {
        return parseFloat(o) || 0;
    });

    template.helper('p2f', function(o) {
        return (parseFloat(o) || 0).toFixed(2);
    });

    var _init = function (address_id) {
        var totals = 0;
        var gptotl = 0; //商品总价
        var cptotal = 0; //运费总价
        var vototal = 0; //优惠活动总价
        // 购买第一步 提交

        $.ajax({//提交订单信息
            type:'post',
            url:ApiUrl+'/index.php?ctl=Buyer_Cart&met=confirm&typ=json',
            dataType:'json',
            data:{k:key, u:getCookie('id'),product_id:cart_id,ifcart:ifcart,address_id:address_id,cart_type:cart_type},
            success:function(result){
                console.info(result);
                checkLogin(result.login);
                if (result.status == 250) {
                    $.sDialog({
                        skin:"red",
                        content:result.data.msg,
                        okBtn:false,
                        cancelBtn:false
                    });
                    return false;
                }

                if(result.data.user_rate == 0)
                {
                    result.data.user_rate = 100;
                }
                // 商品数据
                result.data.address_id = address_id;
                result.data.WapSiteUrl = WapSiteUrl;
                delete result.data.glist.count
                var html = template.render('goods_list', result.data);
                $("#deposit").html(html);


                for (var i in result.data.glist) {
                    $.animationUp({
                        valve : '.animation-up' + i,          // 动作触发，为空直接触发
                        wrapper : '.nctouch-bottom-mask' + i,    // 动作块
                        scroll : '.nctouch-bottom-mask-rolling' + i,     // 滚动块，为空不触发滚动
                    });
                }

                // 默认地区相关
                if ($.isEmptyObject(result.data.address)) {
                    $.sDialog({
                        skin:"block",
                        content:'请添加地址',
                        okFn: function() {
                            $('#new-address-valve').click();
                        },
                        cancelFn: function() {
                            history.go(-1);
                        }
                    });
                    return false;
                }

                result.data.address && result.data.address.length > 0 && insertHtmlAddress(result.data.address, address_id);

                // 代金券
                voucher = '';
                voucher_temp = [];
                for (var k in result.data.glist.voucher_base) {
                    voucher_temp.push([result.data.glist.voucher_base[k].voucher_t_id + '|' + k + '|' + result.data.glist.voucher_base[k].voucher_price]);
                }
                voucher = voucher_temp.join(',');
                console.info(voucher);
                console.info(voucher_temp);
                console.info(result.data.glist.voucher_base);
                var rate_reduce = 0;//订单中自营店铺折扣减少的总金额
                for (var k in result.data.glist) {
                    if(result.data.cost.length > 0)
                    {
                        cost = result.data.cost[k].cost;
                    }
                    else
                    {
                        cost = 0;
                    }
                    // 总价
                    allprice = result.data.glist[k].sprice*1 + cost*1;
                    if(allprice < 0)
                    {
                        allprice = 0
                    }

                    $('#storeTotal' + k).html(allprice.toFixed(2));
                    $('#storeFreight' + k).html(cost);

                    totals += parseFloat(result.data.glist[k].sprice*1 + cost*1);
                    gptotl +=parseFloat(result.data.glist[k].sprice);
                    cptotal +=parseFloat(cost);
                    if(result.data.glist[k].shop_self_support == 'true')
                    {
                        rate_reduce += parseFloat(result.data.glist[k].sprice) * (100 - result.data.user_rate)/100;
                    }
                    if(result.data.glist[k].mansong_info && result.data.glist[k].mansong_info.rule_discount)
                    {
                        vototal += parseFloat(result.data.glist[k].mansong_info.rule_discount);
                    }

                    // 留言
                    message[k] = '';
                    $('#storeMessage' + k).on('change', function(){
                        message[k] = $(this).val();
                    });
                }

                password = '';

                // 计算总价
                var total_price = totals;
                if (total_price <= 0) {
                    total_price = 0;
                }
                if(cptotal <= 0)
                {
                    cptotal = 0;
                }
                if(gptotl <= 0)
                {
                    gptotl = 0;
                }
                $('#totalPrice,#onlineTotal').html(total_price.toFixed(2));
                var rate_price = rate_reduce;
                var total_rate_price = cptotal + (gptotl - rate_price) - vototal;
                if(total_rate_price <= 0)
                {
                    total_rate_price = 0
                }

                if (!isIntegral) {
                    $('#totalPayPrice').html(total_rate_price.toFixed(2));
                }

                console.info(gptotl);
                console.info(cptotal);
                console.info(vototal);
                console.info(rate_price);
                // var rate_price = gptotl * (100 - result.data.user_rate)/100;

                $("#ratePrice").html(rate_price.toFixed(2));

                $(".rate-money").show();

                /*****加价购、代金券*****/
                initPromotionWindow();
                /*****加价购、代金券*****/
            }
        });
    }

    rcb_pay = 0;
    pd_pay = 0;

    //查找用户的默认地址
    $.ajax({
        type: 'post',
        url: ApiUrl + '/index.php?ctl=Buyer_User&met=getUserConfigAddress&typ=json',
        dataType: 'json',
        data: {k: key, u: getCookie('id')},
        success: function (result)
        {
            if(result.data)
            {
                address_id = result.data.id;
            }
            _init(address_id);
        }
    })


    // 初始化


    // 插入地址数据到html
    var insertHtmlAddress = function (address, address_id) {

        console.info(address);
        var address_info = {};

        for ( var i=0; i<address.length; i++ ) {

            if(address_id != 0 )
            {
                if ( address[i].user_address_id == address_id ) {
                    //address_info.address_id = address[i].user_address_area_id;
                    address_info.address_id = address[i].user_address_id;
                    address_info.user_address_contact = address[i].user_address_contact;
                    address_info.provice_id = address[i].user_address_provice_id;
                    address_info.city_id = address[i].user_address_city_id;
                    address_info.area_id = address[i].user_address_area_id;
                    address_info.user_address_phone = address[i].user_address_phone;
                    address_info.user_address_area = address[i].user_address_area;
                    address_info.user_address_address = address[i].user_address_address;
                }
            }
            else
            {
                if (address[i].user_address_default) {
                    //address_info.address_id = address[i].user_address_area_id;
                    address_info.address_id = address[i].user_address_id;
                    address_info.user_address_contact = address[i].user_address_contact;
                    address_info.provice_id = address[i].user_address_provice_id;
                    address_info.city_id = address[i].user_address_city_id;
                    address_info.area_id = address[i].user_address_area_id;
                    address_info.user_address_phone = address[i].user_address_phone;
                    address_info.user_address_area = address[i].user_address_area;
                    address_info.user_address_address = address[i].user_address_address;

                }
            }

        }

        if(!isEmptyObject(address_info))
        {
            address_id = address_info.address_id;
            $('#true_name').html(address_info.user_address_contact);
            $('#mob_phone').html(address_info.user_address_phone);
            $('#address').html(address_info.user_address_area + address_info.user_address_address);
        }
        else
        {
            $('#address').html('未选择收货地址');
        }

        $("#address_id").val(address_id);
        area_id = address_info.area_id;
        city_id = address_info.city_id;
        province_id = address_info.provice_id;

        $('#ToBuyStep2').parent().addClass('ok');
    }

    // 支付方式选择
    // 在线支付
    $('#payment-online').click(function(){
        pay_name = 'online';
        $('#select-payment-wrapper').find('.header-l > a').click();
        $('#select-payment-valve').find('.current-con').html('在线支付');
        $("#pay-selected").val('1');
        $(this).addClass('sel').siblings().removeClass('sel');
    })
    // 货到付款
    $('#payment-offline').click(function(){
        pay_name = 'offline';
        $('#select-payment-wrapper').find('.header-l > a').click();
        $('#select-payment-valve').find('.current-con').html('货到付款');
        $("#pay-selected").val('2');
        $(this).addClass('sel').siblings().removeClass('sel');
    })

    // 地址保存
    $.sValid.init({
        rules:{
            vtrue_name:"required",
            vmob_phone:"required",
            varea_info:"required",
            vaddress:"required"
        },
        messages:{
            vtrue_name:"姓名必填！",
            vmob_phone:"手机号必填！",
            varea_info:"地区必填！",
            vaddress:"街道必填！"
        },
        callback:function (eId,eMsg,eRules){
            if(eId.length >0){
                var errorHtml = "";
                $.map(eMsg,function (idx,item){
                    errorHtml += "<p>"+idx+"</p>";
                });
                errorTipsShow(errorHtml);
            }else{
                errorTipsHide();
            }
        }
    });
    $('#add_address_form').find('.btn').click(function(){
        if($.sValid()){
            var param = {};
            param.k = key;
            param.user_address_contact = $('#vtrue_name').val();
            param.user_address_phone = $('#vmob_phone').val();
            param.user_address_address = $('#vaddress').val();
            param.address_area = $('#varea_info').val();
            param.province_id = province_id;
            param.city_id = city_id;
            param.area_id = area_id;

            param.user_address_default = 0;

            param.u = getCookie('id');

            $.ajax({
                type:'post',
                url:ApiUrl+"/index.php?ctl=Buyer_User&met=addAddressInfo&typ=json",
                data:param,
                dataType:'json',
                success:function(result){
                    //console.info(result);
                    if (result.status == 200) {
                        //param.address_id = result.data.address_id;
                        _init(result.data.user_address_id);
                        $('#true_name').html(result.data.user_address_contact);
                        $('#mob_phone').html(result.data.user_address_phone);
                        $('#address').html(result.data.user_address_area + result.data.user_address_address);
                        $("#address_id").val(result.data.user_address_id);
                        $('#new-address-wrapper,#list-address-wrapper').find('.header-l > a').click();
                    }
                }
            });
        }
    });
    // 发票选择
    $('#invoice-noneed').click(function(){
        $(this).addClass('sel').siblings().removeClass('sel');
        $('#invoice_add,#invoice-list').hide();
        invoice_id = 0;
    });
    $('#invoice-need').click(function(){
        $(this).addClass('sel').siblings().removeClass('sel');
        $('#invoice_add,#invoice-list').show();

        html = '<option value="明细">明细</option><option value="办公用品">办公用品</option><option value="电脑配件">电脑配件</option><option value="耗材">耗材</option>';
        $('#inc_content').append(html);
        //获取发票列表
        $.ajax({
            type:'post',
            url:ApiUrl+'/index.php?ctl=Buyer_Cart&met=piao&typ=json',
            data:{k:key, u:getCookie('id')},
            dataType:'json',
            success:function(result){
                checkLogin(result.login);
                //console.info(result);
                //console.info(result.data);
                var html = template.render('invoice-list-script', result.data);
                $('#invoice-list').html(html)
                if (result.data.normal.length > 0) {
                    invoice_id = result.data.normal[0].invoice_id;
                }
            }
        });
    })
    // 发票类型选择
    $('input[name="inv_title_select"]').click(function(){
        //增值税发票
        if ($(this).val() == 'increment') {
            $('#invoice-list>#addtax').show();
            $('#invoice-list>#electron').hide();
            $('#invoice-list>#normal').hide();

        } //电子发票
        else if($(this).val() == 'electronics') {
            $('#invoice-list>#electron').show();
            $('#invoice-list>#normal').hide();
            $('#invoice-list>#addtax').hide();
        }//普通发票
        else
        {
            $('#invoice-list>#normal').show();
            $('#invoice-list>#electron').hide();
            $('#invoice-list>#addtax').hide();
        }
    });
    $('#invoice-div').on('click', '#invoiceNew', function()
    {
        if($(this).is(".checked"))
        {
            $(this).removeClass('checked');
            $('#invoice_normal_add').hide();

            title = $("#invoice_normal_add").find("input[name='inv_normal_add_title']").val();
            cont  = $("#invoice_normal_add").find("#inv_normal_add_content").val();

            var data = {invoice_state:invoice_state,
                invoice_title:title,
                k:key, u:getCookie('id')};

            flag = add_invoice(data);
        }
        else
        {
            invoice_id = 0;
            $('#invoice_normal_add').show();
        }
    });


    $('#invoice-list').on('click', 'label', function(){
        invoice_id = $(this).find('input').val();
    });

    var add_invoice = function(e)
    {
        var result = "";
        $.ajax({
            type:'post',
            url: ApiUrl+"?ctl=Buyer_Invoice&met=addInvoice&typ=json",
            data:e,
            dataType: "json",
            async:false,
            success:function(a){
                result = a;
            }
        });
        return result;
    }
    // 发票添加
    $('#invoice-div').find('.btn-l').click(function(){
        //选择需要发表按钮
        if ($('#invoice-need').hasClass('sel')) {
            //判断选择的发票类型
            invoice_type = $('#invoice_type').find(".checked").find("input[name='inv_title_select']").attr('id');
            //普通发票
            if(invoice_type == 'norm')
            {
                //判断有没有新增的发票抬头
                invoice_state = 1;
                type = "普通发票";
                if($('#invoiceNew').hasClass('checked'))
                {
                    title = $("#invoice_normal_add").find("input[name='inv_normal_add_title']").val();
                    cont  = $("#invoice_normal_add").find("#inv_normal_add_content").val();

                    var data = {invoice_state:invoice_state,
                                invoice_title:title,
                                k:key, u:getCookie('id')};

                    flag = add_invoice(data);
                }
                else
                {
                    title = $("#normal").find("#inv_ele_title").val();
                    cont = $("#normal").find("#inc_normal_content").val();
                    flag = {status:200,data:{invoice_id:''}}
                }
            }

            //电子发票
            if(invoice_type == 'electronics')
            {
                //将电子发票保存到数据库
                type  = '电子发票';
                title = $("#electron").find('.checked').find("input[name='inv_ele_title']").val();
                phone = $("#electron").find("input[name='inv_ele_phone']").val();
                email = $("#electron").find("input[name='inv_ele_email']").val();
                cont  = $("#electron").find("#inc_content").val();
                var data = {invoice_state:'2',
                    invoice_title:title,
                    invoice_rec_phone:phone,
                    invoice_rec_email:email,
                    k:key, u:getCookie('id')};

                flag = add_invoice(data);
            }

            //增值税发票
            if(invoice_type == 'increment')
            {
                //将增值税发票保存到数库中
                type = '增值税发票';
                title = $("#addtax").find("input[name='inv_tax_title']").val();
                company = $("#addtax").find("input[name='inv_tax_title']").val();
                code	= $("#addtax").find("input[name='inv_tax_code']").val();
                addr = $("#addtax").find("input[name='inv_tax_address']").val();
                phone = $("#addtax").find("input[name='inv_tax_phone']").val();;
                bname = $("#addtax").find("input[name='inv_tax_bank']").val();
                bcount = $("#addtax").find("input[name='inv_tax_bankaccount']").val();
                cname = $("#addtax").find("input[name='inv_tax_recname']").val();
                cphone = $("#addtax").find("input[name='inv_tax_recphone']").val();
                province = $("#addtax").find("input[name='invoice_tax_rec_province']").val();
                caddr = $("#addtax").find("input[name='inv_tax_rec_addr']").val();

                province_id = $("#addtax").find("input[name='invoice_tax_rec_province']").attr('data-areaid1');
                city_id = $("#addtax").find("input[name='invoice_tax_rec_province']").attr('data-areaid2');
                area_id = $("#addtax").find("input[name='invoice_tax_rec_province']").attr('data-areaid3');


                cont = $("#addtax").find("#inc_tax_content").val();
                var data = {invoice_state:'3',
                    invoice_title:title,
                    invoice_company:company,
                    invoice_code:code,
                    invoice_reg_addr:addr,
                    invoice_reg_phone:phone,
                    invoice_reg_bname:bname,
                    invoice_reg_baccount:bcount,
                    invoice_rec_name:cname,
                    invoice_rec_phone:cphone,
                    invoice_rec_province:province,
                    invoice_province_id:province_id,
                    invoice_city_id:city_id,
                    invoice_area_id:area_id,
                    invoice_goto_addr:caddr,
                    k:key, u:getCookie('id')};

                //console.info(data);

                flag = add_invoice(data);
            }

            if(flag.status == 200)
            {
                $('#invContent').html(type + ' ' + title + ' ' + cont);
                $("input[name='invoice_id']").val(flag.data.invoice_id);
            }
            else
            {
                $.sDialog({
                    content: '操作失败',
                    okBtn:false,
                    cancelBtnText:'返回',
                    cancelFn: function() { }
                });
            }
        } else {
            $('#invContent').html('不需要发票');
        }
        $('#invoice-wrapper').find('.header-l > a').click();
    });


    // 支付
    $('#ToBuyStep2').click(function(){
        var buy_able = 1;
        var goods_name = '';
        $('.buy-item').each(function(){
            if($(this).data('buy_able') == 0){
                buy_able = $(this).data('buy_able');
                goods_name = $(this).data('goods_name');
                return false;
            }
        });
        if(buy_able == 0){
            $.sDialog({
                content: '商品【'+goods_name+'】不在配送范围，请更换收货地址或者选择其他商品！',
                okBtn:true,
                cancelBtn:true,
                cancelBtnText:'取消',
                okBtnText:'返回购物车',
                okFn: function() { history.back();  }
            });
            return false;
        }

        if($("#totalPayPrice").html() >= 99999999.99)
        {
            $.sDialog({
                content: '订单金额过大，请分批购买！',
                okBtn:false,
                cancelBtnText:'返回',
                cancelFn: function() { history.back(); }
            });

            return;

        }

        //1.获取收货地址
        address_contact = $("#true_name").html();
        address_address = $("#address").html();
        address_phone   = $("#mob_phone").html();
        address_id = $("#address_id").val();

        if(address_id == 'undefined')
        {
            $.sDialog({
                skin:"red",
                content:'请选择收货地址！',
                okBtn:false,
                cancelBtn:false
            });

            return false;
        }


        //2.获取发票信息
        invoice = $("#invContent").html();
        invoice_id = $("input[name='invoice_id']").val();

        //3.获取商品信息（商品id，商品备注）
        var cart_id =[];//定义一个数组
        $("input[name='cart_id']").each(function(){
            cart_id.push($(this).val());//将值添加到数组中
        });

        var remark = [];
        var shop_id = [];
        $("input[name='remarks']").each(function(){
            shop_id.push($(this).attr("rel"));
            remark.push($(this).val());//将值添加到数组中
        });

        /****************获取促销信息****************/
        var promotion_rows = getAllPromotionData(),
            increase_arr = [], //加价购
            voucher_ids = []; //代金券

        if (promotion_rows !== false && !$.isEmptyObject(promotion_rows)) {
                for(var k_shop_id in promotion_rows) {
                    promotion_rows[k_shop_id].voucher_id && voucher_ids.push(promotion_rows[k_shop_id].voucher_id);

                    if (promotion_rows[k_shop_id].jjg_goods_data) {
                        for (var i = 0, promotion_data = promotion_rows[k_shop_id].jjg_goods_data, length = promotion_data.length; i < length; i++) {
                            increase_arr.push({
                                increase_shop_id: k_shop_id,
                                increase_goods_id: promotion_data[i].goods_id,
                                increase_goods_num: promotion_data[i].goods_num,
                                increase_price: promotion_data[i].goods_promotion_price
                            });
                        }
                    }
                }
           }
        /****************获取促销信息****************/

        //获取支付方式
        pay_way_id = $("#pay-selected").val();

        $.ajax({
            type:'post',
            url: ApiUrl  + '?ctl=Buyer_Order&met=addOrder&typ=json',
            data: {
                receiver_name: address_contact,
                receiver_address: address_address,
                receiver_phone: address_phone,
                invoice: invoice,
                invoice_id: invoice_id,
                cart_id: cart_id,
                shop_id: shop_id,
                remark: remark,
                pay_way_id: pay_way_id,
                address_id: address_id,
                k: key,
                u: getCookie('id'),
                from: "wap",
                increase_arr: increase_arr, //加价购
                voucher_id: voucher_ids //代金券
            },
            dataType: "json",
            success:function(a){
                console.info(a);
                if(a.status == 200)
                {
                    delCookie('cart_count');
                    //重新计算购物车的数量
                    getCartCount();
                    //alert(PayCenterWapUrl + "?ctl=Info&met=pay&uorder=" + a.data.uorder);
                    if(pay_way_id == 1)
                    {
                        window.location.href = PayCenterWapUrl + "?ctl=Info&met=pay&uorder=" + a.data.uorder;
                        return false;
                    }
                    else
                    {
                        window.location.href = WapSiteUrl + '/tmpl/member/order_list.html';
                        return false;
                    }

                }
                else
                {
                    if(a.msg != 'failure')
                    {
                       /* Public.tips.error(a.msg);*/
                        $.sDialog({
                            content: a.msg,
                            okBtn:false,
                            cancelBtnText:'返回',
                            cancelFn: function() { /*history.back();*/ }
                        });
                    }else
                    {
                        /*Public.tips.error('订单提交失败！');*/
                        $.sDialog({
                            content: '订单提交失败！',
                            okBtn:false,
                            cancelBtnText:'返回',
                            cancelFn: function() { /*history.back();*/ }
                        });
                    }

                    //alert('订单提交失败');
                }
            },
            failure:function(a)
            {
                Public.tips.error('操作失败！');
                //$.dialog.alert("操作失败！");
            }
        });

    });
    
});

//初始化加价购和代金券弹框
function initPromotionWindow() {

    var $trigger_jjg_list = $("div.trigger_shop_jjg"), //加价购
        $trigger_shop_voucher_list = $("div.trigger_shop_voucher"); //代金券

    if ($trigger_jjg_list.length == 0 && $trigger_shop_voucher_list == 0) {
        return false; //订单列表商品没有加价购和代金券活动
    }

    //初始化事件
    $trigger_jjg_list.each(function(i, e){
        var shop_id = e.id.replace("trigger_shop_jjg_", ""),
            options = {
                valve: "#trigger_shop_jjg_" +shop_id,
                wrapper: "#shop_jjg_html_" + shop_id,
                close: calculateJJG,
                scroll: ""
            };

        $.animationUp(options);
    });

    $trigger_shop_voucher_list.each(function(i, e){
        var shop_id = e.id.replace("trigger_shop_voucher_", ""),
            options = {
                valve: "#trigger_shop_voucher_" +shop_id,
                wrapper: "#shop_voucher_html_" + shop_id,
                close: calculateVoucher,
                scroll: ""
            };

        $.animationUp(options);
    });

    //获得原始价格，并记录上次改变金额数量
    var $totalPrice = $("#totalPrice"),  //合计
        $totalPayPrice = $("#totalPayPrice"); //支付金额

    var store_amount_data = {}, //所有店铺金额信息
        $store_total_list = $(".js_store_total"); //获取所有店铺合计

    $store_total_list.each(function(i, e) {
        var index = e.id.replace("storeTotal", "");
        store_amount_data["store_total_" + index] = $(e);
        store_amount_data["jjg_change_amount_" + index] = 0;
        store_amount_data["voucher_change_amount_" + index] = 0;
    });

    //radio取消
    $(document).on("click", "input[type='radio']", function() {
        var status = $(this).data("status");

        if (status) {
            this.checked = false;
            $(this).data("status", false)
        } else {
            $(this).data("status", true)
        }
    });

    //加价购商品的数量事件
    $(document).on("click", "a.min, a.max", function() {
        //判断是否允许改变商品数量
        var $operation = $(this);
        if($operation.hasClass("disabled")) {
            return false;
        }

        $operation.hasClass("min")
            ? _minusGoodsNum($operation)
            : _addGoodsNum($operation);

        _showCheckedGoodsNum($operation);
    });

    function _showCheckedGoodsNum($operation)
    {
        var goodsNum = $operation.parents("div.JS_operation").find("input[type='number']").val(),
            $goodsNum = $operation.parents("li").find("div.goods-num");

        if (parseInt(goodsNum)) {
            $goodsNum.show().find("em").text("x" + goodsNum);
        } else {
            $goodsNum.hide();
        }
    }

    //获取规则信息
    function _getRuleData($operation)
    {
        var $input = $operation.parents("div.JS_operation").find("input"); //获取input

        //获取当前加价购规则内商品上限
        var $radio = $operation.parents("div.item-li").find("input[type='radio']"),
            rule_id = $radio.data('rule_id'),
            rule_goods_limit = $radio.data('rule_goods_limit');

        return {
            '$input': $input,
            '$radio': $radio,
            'rule_id': rule_id,
            'rule_goods_limit': rule_goods_limit
        }
    }

    function _minusGoodsNum($operation)
    {
        var rule_data = _getRuleData($operation),
            $input = rule_data.$input,
            $radio = rule_data.$radio,
            changed_num = $input.val()*1 - 1; //变化后数量

        $input.val(changed_num); //改变数量

        if (changed_num == 0) { //锁上当前商品减法
            $operation.addClass("disabled");
        }
        //解锁当前规则所有的加法
        $radio.parents("div.item-li").find("a.max").removeClass("disabled");
    }

    function _addGoodsNum($operation)
    {
        var rule_data = _getRuleData($operation),
            rule_id = rule_data.rule_id,
            rule_goods_limit = rule_data.rule_goods_limit,
            $input = rule_data.$input,
            $radio = rule_data.$radio,
            now_goods_num = 0;

        $input.val($input.val()*1 + 1); //改变数量

        //获取当前规则下所有商品数量
        $("input[name=\"jjg_goods" + rule_id + "\"]").each(function (i, e){
            now_goods_num += e.value*1;
        });

        //解锁当前规则所有符合条件的减法
        $radio.parents("div.item-li").find("a.min").each(function(i, e){
            var $current_input = $(e).parents("div.JS_operation").find("input");
            if ($current_input.val() > 0) {
                $(e).removeClass("disabled");
            }
        });

        //当前规则下所有商品加法禁用
        if (now_goods_num == rule_goods_limit) {
            $radio.parents("div.item-li").find("a.max").addClass("disabled");
        }
    }

    //计算加价购金额
    function calculateJJG(trigger_element)
    {
        var shop_id = trigger_element.id.replace("trigger_shop_jjg_", ""),
            current_index = $(trigger_element).data("current_index"),
            $radio = $("#shop_jjg_html_" + shop_id).find("input[type='radio']:checked");

        restoreAmount(current_index, "jjg"); //还原当前价格，重新计算

        if ($radio.length == 0){
            showJJGChecked(false, shop_id);
            store_amount_data["jjg_change_amount_" + current_index] = 0;
            return false;
        }

        var rule_id = $radio.data("rule_id"),
            $input_list = $("input[name=\"jjg_goods"+ rule_id +"\"]"),
            checked_goods_price_sum = 0,
            checked_goods_rows = [];

        $input_list.each(function(i, e) {

            if (this.value > 0) {
                checked_goods_rows.push({
                    'goods_promotion_price': $(e).data("promotion_price"),
                    'goods_num': this.value
                });
                checked_goods_price_sum += $(e).data("promotion_price") * this.value;
            }
        });

        if (checked_goods_price_sum == 0) {
            showJJGChecked(false, shop_id);
            return false; //不参与加价购活动
        }

        showJJGChecked(true, shop_id, checked_goods_rows); //展示选择加价购信息
        changeMoney(current_index, checked_goods_price_sum, "add", "jjg"); //计算金额
    }

    //计算代金券
    function calculateVoucher(trigger_element)
    {
        var shop_id = trigger_element.id.replace("trigger_shop_voucher_", ""),
            current_index = $(trigger_element).data("current_index"),
            $radio = $("#shop_voucher_html_" + shop_id).find("input[type='radio']:checked");

        restoreAmount(current_index, "voucher"); //还原当前价格，重新计算

        if ($radio.length == 0){
            showVoucherChecked(false);
            store_amount_data["voucher_change_amount_" + current_index] = 0;
            return false;
        }

        var voucher_id = $radio.data("voucher_id"),
            voucher_price = $radio.data("voucher_price");

        showVoucherChecked(true, voucher_id);
        changeMoney(current_index, voucher_price, 'minus', "voucher");
    }

    //改变金额
    function changeMoney(index, amount, operation_type, promotion_type)
    {
        if (operation_type == "minus") {
            amount = -amount;
        }

        if (promotion_type == "jjg") {
            store_amount_data["jjg_change_amount_" + index] = amount;
        } else {
            store_amount_data["voucher_change_amount_" + index] = amount;
        }

        var $storeTotal = store_amount_data["store_total_" + index];

        $storeTotal.text(($storeTotal.text()*1 + amount).toFixed(2));
        $totalPrice.text(($totalPrice.text()*1 + amount).toFixed(2));
        $totalPayPrice.text(($totalPayPrice.text()*1 + amount).toFixed(2));
    }

    //还原金额
    function restoreAmount(index, promotion_type)
    {
        var changeAmount, //改变金额
            $storeTotal = store_amount_data["store_total_" + index],
            storeTotalVal = $storeTotal.text()*1,
            totalPriceVal = $totalPrice.text()*1,
            totalPayPriceVal = $totalPayPrice.text()*1;

        //首先执行还原操作
        if (promotion_type == "jjg") {
            changeAmount = store_amount_data["jjg_change_amount_" + index];
        } else {
            changeAmount = store_amount_data["voucher_change_amount_" + index];
        }

        storeTotalVal -= changeAmount;
        totalPriceVal -= changeAmount;
        totalPayPriceVal -= changeAmount;

        $storeTotal.text(storeTotalVal.toFixed(2));
        $totalPrice.text(totalPriceVal.toFixed(2));
        $totalPayPrice.text(totalPayPriceVal.toFixed(2));
    }

    //展示选择加价购信息
    function showJJGChecked(checked, shop_id, checked_goods_rows)
    {
        var $jjg_rule_info = $("#jjg_rule_info" + shop_id),
            $jjg_rule_checked = $("#jjg_rule_checked" + shop_id);

        if (checked) {
            $jjg_rule_info.hide();
            $jjg_rule_checked.empty().show();

            var append_html = "";
            for(var i = 0, len = checked_goods_rows.length; i < len; i++) {
                append_html += "<li>加价购￥" + checked_goods_rows[i].goods_promotion_price + "X" + checked_goods_rows[i].goods_num + "</li>"
            }

            $jjg_rule_checked.append("<ul>"+ append_html +"</ul>");
        } else {
            $jjg_rule_info.show();
            $jjg_rule_checked.hide();
        }
    }

    //展示代金券信息
    function showVoucherChecked(checked, voucher_id)
    {
        if (checked) {
            $("p.js_voucher_info").hide();
            $("#voucher_info" + voucher_id).show();
        } else {
            $("p.js_voucher_info").show();
        }
    }
}

/**
 * 返回需要的加价购、代金券数据
 *
 * return {shop_id: object}
 *
 * object = {
 *     voucher_id: voucher_id,
 *     rule_id: rule_id,
 *     jjg_goods_data: [{
 *         goods_id: goods_id,
 *         goods_num: goods_num,
 *         goods_increase_price: goods_increase_price
 *     }]
 * }
 */
function getAllPromotionData () {
    var jjg_list = $("input[type='radio'][data-promotion_type='jjg']:checked"),
        voucher_list = $("input[type='radio'][data-promotion_type='voucher']:checked"),
        promotion_list = jjg_list.concat(voucher_list);

    if (promotion_list.length == 0) {
        return false;
    }

    var result_data = {};

    $(promotion_list).each(function(i, e) {
        var shop_id,
            promotion_type= $(e).data("promotion_type");

        if (promotion_type == "jjg") {
            shop_id = e.name.replace("shop_jjg", "");
            var jjg_goods_data = [], //选中加价购的商品
                rule_id = $(e).data("rule_id"),
                $checked_rule_goods_list = $("input[name='jjg_goods" + rule_id + "']");

            $checked_rule_goods_list.each(function(i, e){
                if (e.value > 0) {
                    jjg_goods_data.push({
                        "goods_id": $(e).data("jjg_goods_id"),
                        "goods_num": e.value,
                        "goods_promotion_price": $(e).data("promotion_price"),
                    });
                }
            });

            if (jjg_goods_data.length > 0) {
                if (! result_data[shop_id]) {
                    result_data[shop_id] = {};
                }
                result_data[shop_id]['rule_id'] = rule_id;
                result_data[shop_id]['jjg_goods_data'] = jjg_goods_data;
            }
        } else {
            shop_id = e.name.replace("shop_voucher", "");

            var voucher_id = $(e).data("voucher_id");
            if (! result_data[shop_id]) {
                result_data[shop_id] = {};
            }
            result_data[shop_id]['voucher_id'] = voucher_id;
        }
    });

    return result_data;
}