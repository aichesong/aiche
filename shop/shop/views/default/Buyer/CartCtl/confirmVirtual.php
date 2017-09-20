<?php if (!defined('ROOT_PATH')){exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/' . 'site_nav.php';
?>

<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/shop-cart.css" />
<script type="text/javascript" src="<?=$this->view->js?>/virtual.js"></script>
<script type="text/javascript" src="<?=$this->view->js?>/alert.js"></script>
<script  type="text/javascript" src="<?=$this->view->js_com?>/plugins/jquery.dialog.js"></script>
<link type="text/css" rel="stylesheet" href="<?= $this->view->css_com ?>/jquery/plugins/dialog/green.css">
<link href="<?= $this->view->css ?>/tips.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->view->js?>/common.js"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/jquery.toastr.min.js" charset="utf-8"></script>

	<script>

		var  rpt_list_json = <?=encode_json($data['rpt_list'])?>;
		//平台优惠券
		function iniRpt(order_total) {
			var _tmp,_hide_flag = true;
			$('#rpt').empty();
			$('#rpt').append('<option value="|0.00">-<?=__('选择使用平台优惠券')?>-</option>');
			for (i = 0; i < rpt_list_json.length; i++)
			{
				_tmp = parseFloat(rpt_list_json[i]['redpacket_t_orderlimit']);
				order_total = parseFloat(order_total);
				if (order_total > 0 && order_total >= _tmp.toFixed(2))
				{
					$('#rpt').append("<option value='" + rpt_list_json[i]['redpacket_id'] + '|' + rpt_list_json[i]['redpacket_price'] + "'>" + rpt_list_json[i]['redpacket_title'] + "</option>")
					_hide_flag = false;
				}
			}

			if (_hide_flag)
			{
				$('#rpt_panel').hide();
			}
			else {
				$('#rpt_panel').show();
			}
		}

		//清除平台红包选择
		function clanRpt()
		{
			var allTotal = parseFloat($('.after_total').html());
			var orderRpr = $('#orderRpt').html();
			if(orderRpr !== undefined)
			{
				orderRpr = Number($('#orderRpt').html());
				$('#orderRpt').html('-0.00');
				var paytotal = allTotal + orderRpr*(-1);
				$('.after_total').html(paytotal.toFixed(2));
			}

		}

		$(function(){
			var allTotal = parseFloat($('.after_total').html());

			$('#rpt').on('change',function(){
				var allTotal = parseFloat($('.after_total').html());
				var items = $(this).val().split('|');

				if (items[0] == '')
				{
					var orderRpr = Number($('#orderRpt').html());
					$('#orderRpt').html('-0.00');
					var paytotal = allTotal + Math.abs(orderRpr);
					$('.after_total').html(paytotal.toFixed(2));
				}
				else
				{
					var items = $(this).val().split('|');
					$('#orderRpt').html('-'+number_format(items[1],2));
					var paytotal = allTotal - parseFloat(items[1]);
					if (paytotal < 0) paytotal = 0;

					$('.after_total').html(paytotal.toFixed(2));
				}
			});

			if (rpt_list_json.length == 0)
			{
				$('#rpt_panel').remove();
			}

			if ($('#orderRpt').length > 0)
			{
				iniRpt(allTotal.toFixed(2));
				$('#orderRpt').html('-0.00');
			}

		});
	</script>
<div class="cart-head">
	<div class="wrap">
		<div class="head_cont clearfix">
			<div class="nav_left" style="float:none;">
				<a href="index.php" class=""><img src="<?=$this->web['web_logo']?>"/></a>
				<a class="download iconfont"></a>
			</div>
		</div>
	</div>
</div>
	<div class="wrap">
		<div class="shop_cart_head clearfix">
			<div class="cart_head_left">
				<h4><?=__('填写核对购物信息')?></h4>
				
			</div>
			<div class="cart-head-module clearfix">
				<p class="tips-p"><span><i class="iconfont icon-orders-tips"></i></span><?=__('请仔细填写手机号，以确保电子兑换码准确发到您的手机。')?></p>
				<ul class="cart_process">
					<li class="mycart">
						<div class="fl">
							<i class="iconfont icon-wodegouwuche bbc_color"></i>
								<h4><?=__('我的购物车')?></h4><h4>
							</h4>
						</div>
						
					</li>
					<li class="mycart process_selected1">
						<div class="fl to"></div>
						<div class="fl">
							<i class="iconfont icon-iconquerendingdan bbc_color"></i>
								<h4 class=""><?=__('确认订单')?></h4><h4>
							</h4>
						</div>
						
					</li>
					<li class="mycart">
						<div class="fl to"></div>
						<div class="fl">
							<i class="iconfont icon-icontijiaozhifu"></i>
								<h4><?=__('支付提交')?></h4><h4>
							</h4>
						</div>
						
					</li>
					<li class="mycart">
						<div class="fl to"></div>
						<div class="fl">
							<i class="iconfont icon-dingdanwancheng"></i>
								<h4><?=__('订单完成')?></h4><h4>
							</h4>
						</div>
					</li>
				</ul>

			</div>
			
		</div>
		<div class="ncc-receipt-info">

			<h4 class="confirm"><?=__('支付方式')?></h4>
			<div class="pay_way pay-selected" pay_id="1">
				<i></i><?=__('在线支付')?>
			</div>
    <div class="">
      <h3 class="confirm"><?=__('电子兑换码/券接收方式')?></h3>
    </div>
    <div id="invoice_list" class="ncc-candidate-items">
      <ul style="overflow: visible;">
        <li><?=__('手机号码：')?>
          <div class="parentCls">
            <input name="buyer_phone" class="inputElem text" autocomplete="off" id="buyer_phone" value="" maxlength="11" type="text" onblur="checkmobile()">
            <span id="e_consignee_mobile_error"></span>
          </div>
        </li>
      </ul>
      <p class=""><i class="icon-info-sign"></i><?=__('您本次购买的商品不需要收货地址，请正确输入接收手机号码，确保及时获得“电子兑换码”。可使用您已经绑定的手机或重新输入其它手机号码。')?></p>
    </div>
  </div>
		<h4 class="confirm contfirm_1"><?=__('虚拟服务类商品清单')?></h4>
		<div class="cart_goods">
			<ul class="cart_goods_head clearfix">
				<li class="price_all"><?=__('小计')?>(<?=(Web_ConfigModel::value('monetary_unit'))?>)</li>
				<li class="goods_num goods_num_1"><?=__('数量')?></li>
				<li class="goods_price goods_price_1"><?=__('单价')?>(<?=(Web_ConfigModel::value('monetary_unit'))?>)</li>
				<li class="goods_name goods_name_1"><?=__('商品')?></li>
			</ul>
			<ul class="cart_goods_list clearfix">
				<li>
					<div class="bus_imfor clearfix">
						<p class="bus_name">
							<span>
								<i class="iconfont icon-icoshop"></i>
								<a href="<?= Yf_Registry::get('url') ?>?ctl=Shop&met=index&id=<?=($data['goods_base']['shop_id'])?>" class="cus_ser" ><?=($data['shop_base']['shop_name'])?></a>
								<?php if($data['shop_base']['shop_self_support'] == 'true'){ ?>
									<span><?=__('自营店铺')?></span>
								<?php } ?>
							</span>
							<?php if($data['voucher_base']){?>
							<div style="position:relative; margin-left: 14px;margin-top: 20px;float:left;">
								<a onclick="showVoucher(this)">
									<i class="iconfont  icon-daijinquan"></i><?=__('可用代金券')?>
									<i class="iconfont  icon-iconjiantouxia"></i>
								</a>
								<?php if($data['voucher_base']){?>
									<div class="voucher_detail box_list">
										<ul class="voucher clearfix">
											<?php foreach($data['voucher_base'] as $voukey => $vouval){?>
												<li class="voucher_list">
													<div class="quan_num"><?=format_money($vouval['voucher_price'])?></div>
													<div class="quan_condition">
														<span><?=($vouval['voucher_title'])?></span>
														<span><?=__('有效期: ')?><time><?=($vouval['voucher_start_date'])?></time> <?=__('-')?> <time><?=($vouval['voucher_end_date'])?></time></span>
														<span><?=($vouval['voucher_desc'])?></span>
													</div>
													<div>
														<input type="hidden" name="shop_id" id="shop_id" value="<?=($vouval['voucher_shop_id'])?>">
														<input type="hidden" name="voucher_id" id="voucher_id" value="<?=($voukey)?>">
														<input type="hidden" name="voucher_price" id="voucher_price" value="<?=($vouval['voucher_price'])?>">
														<input type="hidden" name="voucher_code" id="voucher_code" value="<?=($vouval['voucher_code'])?>">
														<a onclick="useVoucher(this)" class="quan_get"><?=__('使用')?></a>
													</div>
												</li>
											<?php }?>
											<div class="bk"><i class="iconfont icon-cuowu"></i></div>

										</ul>

									</div>
								<?php }?>
							</div>
						<?php }?>

							<?php if($data['increase_info']){?>
							<?php foreach($data['increase_info'] as $inckey => $incval){?>
						<p class="bus_sale">
							<span>&bull;<?=__('购物满')?><?=format_money($incval['rule_info']['rule_price'])?></span><?=__('即可购')?><?php if($incval['exc_goods_limit']){echo $incval['exc_goods_limit'].'样'; }?><?=__('商品，')?><span class="sale_tick"><?=__('换购商品：')?></span>
							<i class="get" onclick="get(this)"><?=__('展示')?></i>
						</p>
						<?php } }?>
						</p>
						
					</div>
					<table>
						<tbody class="rel_good_infor">
							<tr>

								<td class="goods_img"><img src="<?=($data['goods_base']['goods_image'])?>"/></td>
								<td class="goods_name" style="width:536px;"><a target="_blank" href="<?= Yf_Registry::get('url') ?>?ctl=Goods_Goods&met=goods&type=goods&gid=<?=($data['goods_base']['goods_id'])?>"><?=($data['goods_base']['goods_name'])?></a>
									<p>
											<input type="hidden" id="goods_id" value="<?=($data['goods_base']['goods_id'])?>">
											<input type="hidden" id="goods_num" value="<?=($nums)?>">
										<?php if(!empty($data['goods_base']['spec'])){foreach($data['goods_base']['spec'] as $sk => $sv){ ?>
											<?=($sv)?> &nbsp;&nbsp;
										<?php }}?>
									</p>
								</td>
								<td class="goods_price goods_price_1 ">
									<?php if($data['goods_base']['old_price'] > 0){?><p class="ori_price"><?=($data['goods_base']['old_price'])?></p><?php }?>
									<p class="now_price"><?=($data['goods_base']['now_price'])?></p>

								</td>
								
								<td class="goods_num goods_num_1">
									<span><?=($nums)?></span>
								</td>
								<td class="price_all">
									<span class="subtotal"><?=($data['goods_base']['sumprice'])?></span>
								</td>
							</tr>
						</tbody>
					</table>
					<span class="shop_voucher"></span>
					<?php if($data['mansong_info']){?>
						<?php if($data['mansong_info']['rule_discount']){?>
							<span><?=__('店铺优惠')?><?=($data['mansong_info']['rule_discount'])?></span>
						<?php }?>

						<?php if($data['mansong_info']['gift_goods_id']){?>
							<img title="<?=($data['mansong_info']['goods_name'])?>" alt="<?=($data['mansong_info']['goods_name'])?>" src="<?=($data['mansong_info']['goods_image'])?>">
							<?=($data['mansong_info']['goods_name'])?>
						<?php }?>
					<?php }?>
					<?php if($data['increase_info']){?>
						<?php foreach($data['increase_info'] as $incgkey => $incgval){?>
							<div class="sale_detail <?=($incgkey)?> box_list">
								<ul class="increase clearfix">
									<input type="hidden" name="increase_id" value="<?=($incgkey)?>">
									<input type="hidden" name="exc_goods_limit" id="exc_goods_limit" value="<?=($incgval['exc_goods_limit'])?>">
									<input type="hidden" name="shop_id" id="shop_id" value="<?=($incgval['shop_id'])?>">
									<?php foreach($incgval['exc_goods'] as $excgkey => $excgval){?>
										<li class="increase_list">
											<input type="hidden" name="redemp_goods_id" id="redemp_goods_id" value="<?=($excgval['redemp_goods_id'])?>">
											<div class=""><img alt="<?=image_thumb($excgval['goods_name'],60,60)?>" src="<?=($excgval['goods_image'])?>"></div>
											<div class="quan_condition">
												<span><?=($excgval['goods_name'])?></span>
												<span><?=__('加购价')?> <?=format_money($excgval['redemp_price'])?></span>
												<input type="hidden" class="redemp_price" value="<?=($excgval['redemp_price'])?>">
												<input type="hidden" class="redemp_price_rate" value="<?=($excgval['redemp_price']*(100-$user_rate)/100)?>">
											</div>
											<div><a onclick="jiabuy(this)" class="quan_get"><?=__('购买')?></a></div>
										</li>
									<?php }?>
									<div class="bk"><i class="iconfont icon-cuowu"></i></div>

								</ul>

							</div>
						<?php }?>
					<?php }?>
				</li>
			</ul>
			
            <div class="goods_remark clearfix">
                <input type="hidden" id="has_physical" name="has_physical" value="<?=$data['has_physical']?>" />
                <?php if($data['has_physical'] == 1){ ?>
				<p class="remarks"><span><?=__('备注：')?></span><input placeholder="<?=__('请填写收货人姓名、地址和联系方式')?>" type="text" id="goodsremarks"></p>
                <?php }else{ ?>
                <p class="remarks"><span><?=__('备注：')?></span><input placeholder="<?=__('补充填写其他信息,如有快递不到也请留言备注')?>" type="text" id="goodsremarks"></p>
                <?php } ?>
			</div>
			<div class="frank clearfix">
				<p class="back_cart"><a></a></p>

				<?php if($data['rpt_list']){ ?>
					<div id="rpt_panel" style="">
						<div class="ncc-store-account">
							<dl>
								<dt style="width:auto;"><?=__('平台红包')?>：</dt>
								<dd class="rule">
									<select nctype="rpt" id="rpt" name="rpt" class="select">

									</select>
								</dd>
								<dd class="sum"><em id="orderRpt" class="subtract">-0.00</em></dd>
							</dl>
						</div>
					</div>
				<?php } ?>


				<p class="submit" style="text-align: center;">
					<span>
						<?=__('订单金额：')?>
						<strong>
							<?=(Web_ConfigModel::value('monetary_unit'))?><i class="total"><?=($data['goods_base']['sumprice'])?></i>
						</strong>
					</span>

					<?php if($user_rate > 0 && (!Web_ConfigModel::value('rate_service_status') ||(Web_ConfigModel::value('rate_service_status') && $data['shop_base']['shop_self_support'] == 'true'))){?>
							<span>
							<?=__('会员折扣：')?>
								<strong>
									<?php $after_total = number_format($data['goods_base']['sumprice'],2,'.','')*$user_rate/100;?>
									-<?=(Web_ConfigModel::value('monetary_unit'))?><i class="rate_total"><?=number_format((100-$user_rate)*$after_total/100,2,'.','')?></i>
								</strong>
						</span>
					<?php }else{$user_rate = 100;}?>

					<?php if($user_rate > 0){?>
						<span>
							<?php $after_total = number_format($data['goods_base']['sumprice'],2,'.','')*$user_rate/100;?>
							<?=__('支付金额：')?>
							<strong>
								<?=(Web_ConfigModel::value('monetary_unit'))?>
								<i class="after_total bbc_color"><?=(number_format($after_total,2,'.','') )?></i>
							</strong>
						</span>
					<?php }?>

					<a id="pay_btn" class="bbc_btns"><?=__('提交订单')?></a>
				</p>

			</div>
		</div>
	</div>

	<!-- 订单提交遮罩 -->
	<div id="mask_box" style="display:none;">
		<div class='loading-mask'></div>
		<div class="loading">
			<div class="loading-indicator">
				<img src="<?= $this->view->img ?>/large-loading.gif" width="32" height="32" style="margin-right:8px;vertical-align:top;"/>
				<br/><span class="loading-msg"><?=__('正在提交订单，请稍后...')?></span>
			</div>
		</div>
	</div>
<script>

	if(<?=($user_rate)?>)
	{
		rate = <?=($user_rate)?>;
	}
	else
	{
		rate = 100;
	}

</script>

<?php
include $this->view->getTplPath() . '/' . 'buyer_footer.php';
?>