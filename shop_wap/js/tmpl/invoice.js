var key = getCookie('key');

$(function() {
    //地址选择
    $.animationLeft({
        valve : '#list-address-valve',
        wrapper : '#list-address-wrapper',
        scroll : '#list-address-scroll'
    });

    // 发票
    $.animationLeft({
        valve : '#invoice-valve',
        wrapper : '#invoice-wrapper',
        scroll : ''
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
    
    
    // 发票选择
    $('#invoice-noneed').click(function(){
        $(this).addClass('sel');
        $('#invoice-need').removeClass('sel');
        $('#invoice_add,#invoice-list').hide();
    });
    $('#invoice-need').click(function(){
        $(this).addClass('sel');
        $('#invoice-noneed').removeClass('sel');
        $('#invoice_add,#invoice-list').show();
        var html = '<option value="明细">明细</option><option value="办公用品">办公用品</option><option value="电脑配件">电脑配件</option><option value="耗材">耗材</option>';
        $('#inc_content').append(html);
        //获取发票列表
        $.ajax({
            type:'post',
            url:ApiUrl+'/index.php?ctl=Buyer_Cart&met=piao&typ=json',
            data:{k:key, u:getCookie('id')},
            dataType:'json',
            success:function(result){
                checkLogin(result.login);
                var html = template.render('invoice-list-script', result.data);
                $('#invoice-list').html(html)
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

    // 发票添加
    $('#invoice-div').find('.btn-l').click(function(){
        //选择需要发表按钮
        if ($('#invoice-need').hasClass('sel')) {
            //判断选择的发票类型
            var invoice_type = $('#invoice_type').find(".checked").find("input[name='inv_title_select']").attr('id');
            add_invoice(invoice_type);
            
        } else {
            $('#invContent').html('不需要发票');
        }
        $('#invoice-wrapper').find('.header-l > a').click();
    });
});

function CompanyTaxNumShow(type,ele)
{
    if(type == 1){
        //显示
        $('#'+ele).find('.js-company-tax-num').removeClass('hide');
    }else{
        //隐藏
        $('#'+ele).find('.js-company-tax-num').addClass('hide');
    }
}

function add_invoice_ajax(data){
    var result = "";
    $.ajax({
        type:'post',
        url: ApiUrl+"?ctl=Buyer_Invoice&met=addInvoice&typ=json",
        data:data,
        dataType: "json",
        async:false,
        success:function(a){
            result = a;
        }
    });
    return result;
}


function add_invoice(invoice_type){
    if(invoice_type == 'norm'){
        var obj = $("#normal");
        var invoice_state = '1';
        var title = obj.find('.checked').find("input[name='inv_ele_title_type']").val() == 'company'  ? obj.find('.checked').find("input[name='inv_ele_title']").val() : '个人';
        var cont  = obj.find("#inc_normal_content").val();
        var invContent = '普通发票'+' '+obj.find('.checked').find("input[name='inv_ele_title']").val()+' '+ cont;
       
    }
    if(invoice_type == 'electronics'){
        var obj = $("#electron");
        var invoice_state = '2';
        var email = obj.find("input[name='inv_ele_email']").val();
        var phone = obj.find("input[name='inv_ele_phone']").val();
        var cont  = obj.find("#inc_content").val();
        var title = obj.find('.checked').find("input[name='inv_ele_title_type']").val() == 'company'  ?obj.find('.checked').find("input[name='inv_ele_title']").val() : '个人';
        var invContent = '电子发票'+' '+obj.find('.checked').find("input[name='inv_ele_title']").val()+' '+ cont;
    }
    if(invoice_type == 'increment'){
         //将增值税发票保存到数库中
        var title = $("#addtax").find("input[name='inv_tax_title']").val();
        var company = $("#addtax").find("input[name='inv_tax_title']").val();
        var code	= $("#addtax").find("input[name='inv_tax_code']").val();
        var addr = $("#addtax").find("input[name='inv_tax_address']").val();
        var phone = $("#addtax").find("input[name='inv_tax_phone']").val();;
        var bname = $("#addtax").find("input[name='inv_tax_bank']").val();
        var bcount = $("#addtax").find("input[name='inv_tax_bankaccount']").val();
        var cname = $("#addtax").find("input[name='inv_tax_recname']").val();
        var cphone = $("#addtax").find("input[name='inv_tax_recphone']").val();
        var province = $("#addtax").find("input[name='invoice_tax_rec_province']").val();
        var caddr = $("#addtax").find("input[name='inv_tax_rec_addr']").val();
        var province_id = $("#addtax").find("input[name='invoice_tax_rec_province']").attr('data-areaid1');
        var city_id = $("#addtax").find("input[name='invoice_tax_rec_province']").attr('data-areaid2');
        var area_id = $("#addtax").find("input[name='invoice_tax_rec_province']").attr('data-areaid3');
        var cont = $("#addtax").find("#inc_tax_content").val();
        var invContent = '增值税发票'+' '+title+' '+ cont;
        var data = {
            invoice_state:'3',
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
            k:key, u:getCookie('id')
        };
        var result = add_invoice_ajax(data);
    }else{
        var invoice_code = $('#company_tax_num').val() ;
        
        var data = {
            invoice_state:invoice_state,
            invoice_title:title,
            invoice_code:invoice_code,
            invoice_rec_phone:phone,
            invoice_rec_email:email,
            k:key, 
            u:getCookie('id')
        };
        var result = add_invoice_ajax(data);
    }
    
    if(result.status == 200)
    {
        $('#invContent').html(invContent);
        $("#order_invoice_title").val(title);
        $("#order_invoice_content").val(cont);
        $("#order_invoice_id").val(result.data.invoice_id);
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
    return ;
}















