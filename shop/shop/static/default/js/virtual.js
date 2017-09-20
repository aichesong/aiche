/**
 * @author     朱羽婷
 */
$(document).ready(function(){

	window.get = function (e)
	{
		$(e).parent().parent().parent().find(".sale_detail").show();
	}

	window.showVoucher = function(e)
	{
		$(e).parent().parent().parent().find(".voucher_detail").show();
	}

	$(".bk").click(function(){
		$(this).parent().parent().hide();
	})

	function getTransport()
	{
		var address = $(".add_choose").find('p').html();
		var cart_id =[];//定义一个数组
		$("input[name='cart_id']").each(function(){
			cart_id.push($(this).val());//将值添加到数组中
		});

		$.post(SITE_URL  + '?ctl=Seller_Transport&met=getTransportCost&typ=json',{address:address,cart_id:cart_id},function(data)
			{
				console.info(data);
				if(data && 200 == data.status) {
					$.each(data.data ,function(key,val){
						$(".trancon"+key).html(val.con);
						$(".trancost"+key).html(val.cost.toFixed(2));

						//计算店铺合计
						$(".sprice"+key).html(($(".price"+key).html()*1 + val.cost*1).toFixed(2));
					})

					//计算订单中金额
					var total = 0;
					$(".dian_total i").each(function(){
						total += $(this).html()*1;
					});
					$(".total").html(total.toFixed(2));
					//$(".rate_total").html((total*rate/100).toFixed(2));

				}
			}
		);

	}
	var c=$(".goods_num");
	var e=null;
	c.each(function(){
		var g=$(this).find("a");	  //添加减少按钮
		var h=$(this).find("input#nums");  //当前商品数量
		var o=this;
		var f=h.attr("data-max");  //最大值 - 库存
		var i=1;
		var id=h.attr("data-id");  //购物车id
		h.bind("input propertychange",function(){
			var j=this;
			var k=$(j).val();
			e&&clearTimeout(e);
			e=setTimeout(function(){
				var l=Math.max(Math.min(f,k.replace(/\D/gi,"").replace(/(^0*)/,"")||1),i);
				$(j).val(l);
				edit_num(id,l,o);
				if(l==f){
					g.eq(1).attr("class","no_add");
					if(l==i)
						g.eq(0).attr("class","no_reduce")
					else
						g.eq(0).attr("class","reduce")
				}else{
					if(l<=i){
						g.eq(0).attr("class","no_reduce");
						g.eq(1).attr("class","add")
					}else{
						g.eq(0).attr("class","reduce");
						g.eq(1).attr("class","add")
					}
				}
			},50)
		}).trigger("input propertychange").blur(function(){$(this).trigger("input propertychange")}).keydown(function(l){
			if(l.keyCode==38||l.keyCode==40)
			{
				var j=0;
				l.keyCode==40&&(j=1);g.eq(j).trigger("click")
			}
		});
		g.bind("click",function(l){
			if(!$(this).hasClass("no_reduce")){
				var j=parseInt(h.val(),10)||1;
				if($(this).hasClass("add")&&!$(this).hasClass("no_add")){
					$(this).prev().prev().attr("class","reduce");
					if(f>i&&j>=f){
						$(this).attr("class","no_add")
					}
					else
					{
						j++;
						edit_num(id,j,o);
					}
				}else{
					if($(this).hasClass("reduce")&&!$(this).hasClass("no_reduce")){
						j--;
						edit_num(id,j,o);
						$(this).next().next().attr("class","add");
						j<=i&&$(this).attr("class","no_reduce")
					}
				}
				h.val(j)
			}
		})
	})

	function edit_num(id,num,obj){
		gprice = $("#goods_price").val();
		price = gprice * num;
		$('.cell' + id + ' span').html((Number(price).toFixed(2)));
		$(".subtotal_all").html(Number(price).toFixed(2));
	}


	//付款按钮
	$('.submit-btn').click(function(){
		$('#form').submit();
	});

	//验证手机号
	window.checkmobile = function()
	{
		var value = $("#buyer_phone").val();
		var errorFlag = false;
		var errorMessage = "";
		var reg=/^(\+\d{2,3}\-)?\d{11}$/;
		if (value != '') {
			if (!reg.test(value)) {
				errorFlag = true;
				errorMessage = "手机号码格式不正确";
			}
		} else {
			errorFlag = true;
			errorMessage = "请输入手机号码";
		}
		if (errorFlag) {
			$("#e_consignee_mobile_error").html(errorMessage);
			$("#e_consignee_mobile_error").addClass("error-msg");
			return false;
		} else {
			$("#e_consignee_mobile_error").removeClass("error-msg");
			$("#e_consignee_mobile_error").html("");
			return true;
		}

		alert(errorMessage);
	}


	//加价购的商品
	var increase_goods_id = [];
	$(".increase_list").each(function(){
		if($(this).is('.checked'))
		{
			increase_goods_id.push($(this).find("#redemp_goods_id").val());
		}
	})

	//去付款按钮（生成订单）
	$("#pay_btn").click(function(){
                var has_physical = $('#has_physical').val();
                if(typeof(has_physical) != 'undefined' && has_physical == 1){
                    if($('#goodsremarks').val() == ''){
                        $('#goodsremarks').focus();
                        Public.tips.error('请在备注中填写收货信息');
                        return false;
                    }
                }
		//1.获取手机号码
			buyer_phone = $("#buyer_phone").val();
			flag = checkmobile();
		//2.获取商品留言
			remarks = $("#goodsremarks").val();
		//3.获取商品信息（商品id，商品备注）
			goods_id = $("#goods_id").val();
			goods_num = $("#goods_num").val();

		//加价购的商品
		var increase_goods_id = [];
		$(".increase_list").each(function(){
			if($(this).is('.checked'))
			{
				increase_goods_id.push($(this).find("#redemp_goods_id").val());
			}
		})

		//代金券信息
		var voucher_id = [];
		$(".voucher_list").each(function(){
			if($(this).is(".checked"))
			{
				voucher_id.push($(this).find("#voucher_id").val());
			}
		});

		//优惠券信息
		var rpt_info = '';
		var rpt   	= 0;
		if($('#rpt').length > 0)
		{
			rpt_info = $('#rpt').val().split('|');
		}
		if(rpt_info)
		{
			rpt = rpt_info[0];
		}

			if(flag)
			{
				$("#mask_box").show();

				$.ajax({
					url: SITE_URL  + '?ctl=Buyer_Order&met=addVirtualOrder&typ=json',
					data:{buyer_phone:buyer_phone,goods_id:goods_id,goods_num:goods_num,remarks:remarks,increase_goods_id:increase_goods_id,voucher_id:voucher_id,pay_way_id:1,rpt:rpt,from:'pc'},
					dataType: "json",
					contentType: "application/json;charset=utf-8",
					async:false,
					success:function(a){
						console.info(a);

						if(a.status == 200)
						{
							window.location.href = PAYCENTER_URL + "?ctl=Info&met=pay&uorder=" + a.data.uorder+'&order_g_type=virtual';
						}
						else
						{
							Public.tips.error('订单提交失败！');
							//alert('订单提交失败');
						}

					},
					failure:function(a)
					{
						Public.tips.error('操作失败！');
					}
				});
			}
	});

	window.jiabuy = function(e)
	{
		limit = $(e).parents('.increase').find('#exc_goods_limit').val();
		shop_id = $(e).parents('.increase').find('#shop_id').val();

		if($(e).is('.checked'))
		{
			clanRpt();

			$(e).removeClass('checked');
			$(e).parents('.increase_list').removeClass('checked');

			good_price = $(e).parents('.increase_list').find(".redemp_price").val();
			good_price_rate = $(e).parents('.increase_list').find(".redemp_price_rate").val();
			good_price_arate = good_price - good_price_rate;

			//总会员折扣减价
			total_rate = Number(Number($('.rate_total').html()) - good_price_rate*1).toFixed(2);
			$('.rate_total').html(total_rate);

			//总价减价
			total_price = Number(Number($('.total').html())*1-good_price*1).toFixed(2);
			after_total = Number($('.after_total').html());

			$('.total').html(total_price);
			$(".after_total").html((after_total - good_price_arate*1).toFixed(2));


			//修改订单金额后需要修改平台红包
			iniRpt(after_total.toFixed(2));
			$('#orderRpt').html('-0.00');
		}
		else
		{
			//计算已经选择了加价购商品
			num = $(e).parents('.increase').children(".increase_list").find('.checked').length;

			if(limit <= 0 || (limit > 0 && num < limit))
			{
				clanRpt();

				$(e).addClass('checked');
				$(e).parents('.increase_list').addClass('checked');

				good_price = $(e).parents('.increase_list').find(".redemp_price").val();
				good_price_rate = $(e).parents('.increase_list').find(".redemp_price_rate").val();
				good_price_arate = good_price - good_price_rate;

				//总会员折扣加价
				total_rate = Number(Number($('.rate_total').html()) + good_price_rate*1).toFixed(2);
				$('.rate_total').html(total_rate);

				//总价加价
				total_price = Number(Number($('.total').html())*1+good_price*1).toFixed(2);
				after_total = Number($('.after_total').html());

				$('.total').html(total_price);
				$(".after_total").html((after_total + good_price_arate*1).toFixed(2));


				//修改订单金额后需要修改平台红包
				iniRpt(after_total.toFixed(2));
				$('#orderRpt').html('-0.00');
			}


		}

	}

	window.useVoucher = function (e)
	{
		shop_id = $(e).parent().find('#shop_id').val();

		//获取本代金券的价值
		voucher_price = $(e).parent().find("#voucher_price").val();

		if($(e).is('.checked'))
		{
			clanRpt();

			$(e).removeClass("checked");
			$(e).removeClass("bgred");
			$(e).parents('.voucher_list').removeClass('checked');

			//删除代金券信息
			$(".shop_voucher").html("");

			//总价加价
			total_price = Number(Number($('.total').html())*1+voucher_price*1).toFixed(2);
			after_total = Number($('.after_total').html());

			$('.total').html(total_price);
			$(".after_total").html((after_total + voucher_price*1).toFixed(2));

			//修改订单金额后需要修改平台红包
			iniRpt(after_total.toFixed(2));
			$('#orderRpt').html('-0.00');
		}else
		{
			clanRpt();

			$(e).parents(".voucher").find(".checked").removeClass("checked");
			$(e).parents(".voucher").find(".bgred").removeClass("bgred");
			$(e).addClass("checked");
			$(e).addClass("bgred");
			$(e).parents('.voucher_list').addClass('checked');

			//显示代金券信息
			$(".shop_voucher").html("使用" + voucher_price + "元代金券");

			//总价减价
			total_price = Number(Number($('.total').html())*1-voucher_price*1).toFixed(2);
			after_total = Number($('.after_total').html());

			$('.total').html(total_price);
			$(".after_total").html((after_total - voucher_price*1).toFixed(2));

			//修改订单金额后需要修改平台红包
			iniRpt(after_total.toFixed(2));
			$('#orderRpt').html('-0.00');
		}
	}


})
