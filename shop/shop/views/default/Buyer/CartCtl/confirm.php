<?php if (!defined('ROOT_PATH')){exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/' . 'site_nav.php';
?>

	<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/shop-cart.css" />
	<script type="text/javascript" src="<?=$this->view->js?>/cart.js"></script>
	<script type="text/javascript" src="<?=$this->view->js?>/alert.js"></script>
	<script  type="text/javascript" src="<?=$this->view->js_com?>/plugins/jquery.dialog.js"></script>
	<link type="text/css" rel="stylesheet" href="<?= $this->view->css_com ?>/jquery/plugins/dialog/green.css">
	<link href="<?= $this->view->css ?>/tips.css" rel="stylesheet">
	<script type="text/javascript" src="<?=$this->view->js?>/common.js"></script>
	<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/jquery.toastr.min.js" charset="utf-8"></script>

	<div class="cart-head">
		<div class="wrap">
			<div class="head_cont clearfix">
				<div class="nav_left" style="float:none;">
					<a href="index.php" class=""><img src="<?=$this->web['web_logo']?>"/></a>
					<a href="#" class="download iconfont"></a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="wrap">
		<div class="shop_cart_head clearfix">
			<div class="cart_head_left">
				<h4><?=__('确认订单')?></h4>
				
			</div>
			<div class="cart-head-module clearfix">
				<p class="tips-p"><span><i class="iconfont icon-orders-tips"></i></span><?=__('请仔细核对收货,发货等信息,以确保物流快递能准确投递')?>.</p>
				<ul class="cart_process">
					<li class="mycart">
						<div class="fl">
							<i class="iconfont icon-wodegouwuche bbc_color"></i>
							<h4><?=__('我的购物车')?><h4>
						</div>
					
					</li>
					<li class="mycart process_selected1">
						<div class="fl to"></div>
						<div class="fl">
							<i class="iconfont icon-iconquerendingdan bbc_color"></i>
							<h4 class=""><?=__('确认订单')?><h4>
						</div>
						
						
					</li>
					<li class="mycart">
						<div class="fl to"></div>
						<div class="fl">
							<i class="iconfont icon-icontijiaozhifu"></i>
							<h4><?=__('支付提交')?><h4>
						</div>
						
						
					</li>
					<li class="mycart">
						<div class="fl to"></div>
						<div class="fl">
							<i class="iconfont icon-dingdanwancheng"></i>
							<h4><?=__('订单完成')?><h4>
						</div>
						
					</li>
				</ul>
			</div>
			
		</div>
		<ul class="receipt_address clearfix">
		<div id="address_list">
		<?php if(isset($data['address'])){$total = 0; $total_dian_rate = 0; foreach ($data['address'] as $key => $value) {
		?>
			<li class="<?php if(!$address_id && $value['user_address_default'] == 1){?>add_choose<?php }?><?php if($address_id && $value['user_address_id'] == $address_id){?>add_choose<?php }?> " id="addr<?=($value['user_address_id'])?>">
				<input type ="hidden" id="address_id" value="<?=($value['user_address_id'])?>">
				<input type="hidden" id="user_address_province_id" value="<?=($value['user_address_province_id'])?>">
				<input type="hidden" id="user_address_city_id" value="<?=($value['user_address_city_id'])?>">
				<input type="hidden" id="user_address_area_id" value="<?=($value['user_address_area_id'])?>">
				<div class="editbox">
					<a class="edit_address" data_id="<?=($value['user_address_id'])?>"><?=__('编辑')?></a>
					<a class="del_address" data_id="<?=($value['user_address_id'])?>"><?=__('删除')?></a>
				</div>
				<h5><?=($value['user_address_contact'])?></h5>
				<p class="addr-len"><?=($value['user_address_area'])?> <?=($value['user_address_address'])?></p><span class="phone"><?=($value['user_address_phone'])?></span>
				
			</li>
			<?php }}?>
			<script>
				$(function(){
					if(".addr-len"){

					}
				})
			</script>
		</div>
			<div class="add_address">
				<a><?=__('+')?></a>
			</div>
		</ul>

		<h4 class="confirm"><?=__('支付方式')?></h4>
			<div class="pay_way pay-selected" pay_id="1">
				<i></i><?=__('在线支付')?>
			</div>
			<div class="pay_way" pay_id="2">
				<i></i><?=__('货到付款')?>
			</div>

		<h4 class="confirm"><?=__('确认商品信息')?></h4>
		<div class="cart_goods">
			<ul class='cart_goods_head clearfix'>
				<li class="price_all"><?=__('小计')?>(<?=(Web_ConfigModel::value('monetary_unit'))?>)</li>
				<li class="confirm_sale"><?=__('优惠')?></li>
				<li class="goods_num"><?=__('数量')?></li>
				<li class="goods_price"><?=__('单价')?>(<?=(Web_ConfigModel::value('monetary_unit'))?>)</li>
				<li class="goods_name"><?=__('商品')?></li>
				<li class="cart_goods_all"></li>
			</ul>

			<?php unset($data['glist']['count']); foreach($data['glist'] as $key=>$val){ ?>

				<!-- S 计算店铺的会员折扣和总价 -->
				<?php
				$reduced_money = 0;//满送活动优惠的金额单独赋予一个变量
				$voucher_money = 0;//代金券活动优惠的金额单独赋予一个变量
				//判断后台是否开启了会员折扣，如果开启会员折扣则判断是否为自营店铺。计算店铺的折扣
				if(!Web_ConfigModel::value('rate_service_status') ||(Web_ConfigModel::value('rate_service_status') && $val['shop_self_support'] == 'true'))
				{
					//如果是分销商购买经销商店铺产品，则不享受经销商店铺折扣
					if($data['distribution_shop_id'] == $key)
					{
						$dian_rate = 0;
					}
					else
					{
						$dian_rate = $val['sprice']*(100-$user_rate)/100;
					}
				}
				else
				{
					$dian_rate = 0;
				}

				//扣除折扣后店铺的店铺价格（本店合计）
				$shop_all_cost = number_format($val['sprice']-$dian_rate,2,'.','');

				?>
				<!-- E 计算店铺的会员折扣和总价 -->
			<ul class="cart_goods_list clearfix">
				<li>
					<div class="bus_imfor clearfix">
						<p class="bus_name">
							<span>
								<i class="iconfont icon-icoshop"></i>
								<a href="<?= Yf_Registry::get('url') ?>?ctl=Shop&met=index&id=<?=($key)?>"><?=($val['shop_name'])?></a>
								<?php if($val['shop_self_support'] == 'true'){ ?>
									<span><?=__('自营店铺')?></span>
								<?php } ?>
							</span>
							<?php if($val['increase_info']){?>
							<?php foreach($val['increase_info'] as $inckey => $incval){?>
							<p class="bus_sale">
								<span>&bull;<?=__('购物满')?> <?=format_money($incval['rule_info']['rule_price'])?> </span><?=__('即可加价购买')?><?php if($incval['exc_goods_limit']){echo $incval['exc_goods_limit'].'样'; }?><?=__('商品，')?><a><?=__('加价购商品：')?></a>
								<i class="get" onclick="get(this)"><?=__('展示')?></i>
							</p>
						<?php } }?>
						</p>

					</div>
					<table>
						<tbody class="rel_good_infor rel_good_infor2">
						<?php foreach($val['goods'] as $k=>$v){ ?>
							<tr>
								<td class="goods_sel">
									<p>
										<input type="hidden" name="cart_id" value="<?=($v['cart_id'])?>">
									</p>
								</td>
								<td class="goods_img"><img src="<?=($v['goods_base']['goods_image'])?>"/></td>
								<td class="goods_name_reset">
									<a  target="_blank" href="<?= Yf_Registry::get('url') ?>?ctl=Goods_Goods&met=goods&type=goods&gid=<?=($v['goods_base']['goods_id'])?>"><?=($v['goods_base']['goods_name'])?></a>
									<p>
										<?php if(!empty($v['goods_base']['spec'])){foreach($v['goods_base']['spec'] as $sk => $sv){ ?>
											<?=($sv)?> &nbsp;&nbsp;
										<?php }}?>
									</p>
								</td>

								<td class="goods_price">
									<?php if($v['old_price'] > 0){?><p class="ori_price"><?=($v['old_price'])?></p><?php }?>
									<p class="now_price"><?=($v['now_price'])?></p>

								</td>
								<td class="goods_num">
									<span><?=($v['goods_num'])?></span>
								</td>
								<td class="confirm_sale">
									<?php if(isset($v['goods_base']['promotion_type'])): ?>
										<?php if($v['goods_base']['promotion_type'] == 'groupbuy' && $v['goods_base']['groupbuy_starttime'] < date('Y-m-d H:i:s') && $v['goods_base']['groupbuy_endtime'] > date('Y-m-d H:i:s') ): ?>
											<p class="sal_price"><?=__('团购')?></p>
											<?php if($v['goods_base']['down_price']): ?><p><?=__('直降')?><?=format_money($v['goods_base']['down_price'])?></p><?php endif; ?>
										<?php endif;?>
										<?php if($v['goods_base']['promotion_type'] == 'xianshi' && $v['goods_base']['groupbuy_starttime'] < date('Y-m-d H:i:s') && $v['goods_base']['groupbuy_endtime'] > date('Y-m-d H:i:s') ): ?>
											<p class="sal_price"><?=__('限时折扣')?></p>
											<?php if($v['goods_base']['down_price']): ?><p><?=__('每件直降')?><?=format_money($v['goods_base']['down_price'])?></p><?php endif; ?>
										<?php endif;?>
									<?php endif; ?>
								</td>
								<td class="price_all">
									<span class="subtotal"><?=($v['sumprice'])?></span>
									<?php if(!$v['buy_able']){?><p class="colred"><?=__('无货')?></p><?php }?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				<?php foreach($val['goods'] as $increakey=>$increaval){ ?>
					<?php
					$cart_total_price = $increaval['now_price'] * $increaval['goods_num'];
//					if(count($val['goods']) == 1)
//					{
////						$cart_total_price = $increaval['now_price'];
//						$cart_total_price = $increaval['now_price'] * $increaval['goods_num'];
//					}
//					else
//					{
//						$cart_goods_price = array_column($val['goods'], 'now_price');
//						$cart_total_price = $increaval['now_price'] * $increaval['goods_num'];
//					}
//					echo '<pre>';print_r($cart_total_price);exit;
					?>

					<?php if($increaval['goods_base']['increase_info']){ ?>
						<?php foreach($increaval['goods_base']['increase_info']['rule'] as $increasekey=>$increaseval){ ?>
<!--							--><?php //echo '<pre>';print_r([$cart_total_price, $increaseval['rule_price']]);exit;?>
							<?php if($cart_total_price > $increaseval['rule_price'] || $cart_total_price == $increaseval['rule_price']){ ?>
							<?php foreach($increaseval['redemption_goods'] as $redempotionkey=>$redempotionval){ ?>
									<?php if($increaseval['rule_goods_limit'] == 0){
										$increaseval['rule_goods_limit'] = $redempotionval['goods_stock'];
									}?>
				<div class="clearfix bgf <?php echo $increaval['goods_base']['increase_info']['shop_id'];?>">
					<div class="add-buy clearfix">
						<div class="fl left">
							<i class="iconfont icon-add-buy"></i>
							<h5>加价购</h5>
						</div>
						<div class="right">
							<table>
								<tbody>
								<tr>
									<td class="w240"><input class="select_increase" rule_id="<?php echo $increaseval['rule_id'];?>" goods_price="<?php echo $redempotionval['redemp_price'];?>" shop_price="<?=(number_format($val['sprice'],2,'.',''))?>" shop_id="<?php echo $increaval['goods_base']['increase_info']['shop_id'];?>" type="checkbox">&nbsp;<span>购物满<?=(Web_ConfigModel::value('monetary_unit'))?><?php echo $increaseval['rule_price'];?><?php if($increaseval['rule_goods_limit'] > 0){?>，最多可购<?php echo $increaseval['rule_goods_limit'];?>件<?php }?></span></td>
									<td class="w90 tc"><img src="<?php echo $redempotionval['goods_image'];?>"></td>
									<td class="w240"><h3><?php echo $redempotionval['goods_name'];?></h3></td>
									<td class="w150 tc" data_price="<?php echo $redempotionval['redemp_price'];?>">加价购<?=(Web_ConfigModel::value('monetary_unit'))?><?php echo $redempotionval['redemp_price'];?></td>
									<td class="w90 tc"><div class="num-sel"><a class="declick" href="javascript:;">-</a><input class="increase_num" goods_id="<?php echo $redempotionval['goods_id'];?>" data-max="<?php echo $increaseval['rule_goods_limit'];?>" type="text" value="1"><a class="inclick">+</a></div></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php }}}}} ?>

				<!-- 后期修改加价购2017.8.2 -->
				<!-- <div class="more-buy">
			        <h4>加价购</h4>
			        <div class="inline morder-buy-con">
			            <p class="sel-goods"><span>购物满￥100.00，最多可购1件</span><i class="icon"></i></p> -->
			            <!-- 点击.sel-goods下拉列表 -->
			            <!-- <div class="quan-ar jia-shop-are">
			                <div class="jia-gou-height"> -->
			                	<!-- 遍历div.item-li -->
			                    <!-- <div class="item-li">
			                        <p class="tit-tip">
			                            <input type="radio">
			                            <label for="jjg_rule16">
			                                <span>购物满￥60.00，最多可购买2件</span>
			                            </label>
			                        </p>
			                        <ul class="nctouch-cart-item"> -->
			                            <!-- 活动规则加价商品 -->
			                           <!--  <li class="buy-item">
			                                <div class="bgf6 buy-li pd10">
			                                    <div class="goods-pic">
			                                        <a href="javascript:void(0)">
			                                            <img src="http://shop.local.yuanfeng021.com/image.php/shop/data/upload/media/d3aabd05be45670d48e2685d1e1f5992/10104/51/image/20170522/1495439019807673.jpg">
			                                        </a>
			                                    </div>
			                                    <dl class="goods-info">
			                                        <dt class="goods-name">
			                                            <a href="">
			                                                                    测试20170524
			                                                                </a>
			                                        </dt>
			                                        <dd class="goods-type">颜色：蓝色，尺寸：s</dd>
			                                    </dl>
			                                    <div class="goods-subtotal">
			                                        <span class="goods-price">￥<em>12.00</em></span>
			                                    </div>
			                                    <div class="goods-num">
			                                        <em>x1</em>
			                                    </div>
			                                </div>
			                                <div class="jia-shop clearfix">
			                                    <p class="fl">加价购<em>￥10.00</em></p>
			                                    <div class="fr mrt4 JS_operation">
			                                        <span><a href="javascript:void(0)" class="min disabled">-</a></span>
			                                        <span><input type="number" readonly="readonly" value="0"></span>
			                                        <span><a href="javascript:void(0)" class="max">+</a></span>
			                                    </div>
			                                </div>
			                            </li>
			                        </ul>
			                    </div> -->
			               <!--  </div>
			            </div>
			        </div>
			    </div> -->



			<div class="goods_remark clearfix">
					<p class="remarks"><span><?=__('备注：')?></span><input type="text" class="remarks_content" name="remarks" id="<?=($key)?>" placeholder="<?=__('限45个字（定制类商品，请将购买需求在备注中做详细说明）')?>"><?=__('提示：请勿填写有关支付、收货、发票方面的信息')?></p>
				
				<div class="order_total">
					<p class="clearfix">
						<span><?=__('商品金额')?></span>
						<i class="price<?=($key)?>"><?=(number_format($val['sprice'],2,'.',''))?></i>
					</p>
					<p class="clearfix trans<?=($key)?>">
						<span><?=__('物流运费')?></span>
                        <?php if($data['cost'][$key]['cost'] > 0){?>
                            <strong class="trancon<?=($key)?>"><?=($data['cost'][$key]['con'])?></strong>
                            <i class="trancost<?=($key)?>">
                                <?=(number_format($data['cost'][$key]['cost'],2))?>
                                <input type="hidden" class="shop_trancost<?=($key)?>" value="<?=(number_format($data['cost'][$key]['cost'],2))?>">
                            </i>
                        <?php }else{ ?>
                            <i class="trancost<?=($key)?>">0</i>
                            <input type="hidden" class="shop_trancost<?=($key)?>" value="0.00">
                        <?php }?>
					</p>

					<?php if(!Web_ConfigModel::value('rate_service_status') ||(Web_ConfigModel::value('rate_service_status') && $val['shop_self_support'] == 'true')){
						?>

						<?php if($dian_rate > 0 ){ ?>
							<p class="clearfix">
								<span><?=__('会员折扣')?></span>
								<em></em>
								<i><?=__("-")?><i class="shoprate<?=($key)?>"><?=number_format($dian_rate,2,'.','')?></i></i>
							</p>
						<?php } ?>

					<?php }?>

					<p class="dian_total clearfix">
						<span class=""><?=__('本店合计')?></span>
						<em></em>
						<i class="sprice<?=($key)?>">
							<?php
							echo number_format($data['cost'][$key]['cost']+$val['sprice']-$dian_rate,2,'.','');
							?>
						</i>
					</p>

					<!--新增-->
					<?php if(!empty($val['mansong_info'])){?>
						<?php if($val['mansong_info']['rule_discount']){?>
							<?php $reduced_money = $val['mansong_info']['rule_discount'];?>
					<p class="clearfix">
							<span><i class="iconfont icon-manjian fln mr4 f22 middle"></i><?=__('满')?><?=($val['mansong_info']['rule_price'])?><?=__('立减')?><?=($val['mansong_info']['rule_discount'])?></span>
						<em></em>
						<i class="msprice<?=($key)?>">
							-<?=($val['mansong_info']['rule_discount'])?>
						</i>
						</p>
						<?php }?>
						<?php if($val['mansong_info']['gift_goods_id']){?>
							<?=__('送')?>&nbsp;<a href="<?= Yf_Registry::get('url') ?>?ctl=Goods_Goods&met=goods&gid=<?=($val['mansong_info']['gift_goods_id'])?>"><img title="<?=($val['mansong_info']['goods_name'])?>" alt="<?=($val['mansong_info']['goods_name'])?>" src="<?=image_thumb($val['mansong_info']['goods_image'],60,60)?>"></a>
							<?=($val['mansong_info']['goods_name'])?>
						<?php }?>
					<?php }?>

					<?php if(isset($val['distributor_rate'])){?>
						<p class="clearfix">
						<span><?=__('分销商优惠')?></span>
						<i><?=number_format($val['distributor_rate'],2,'.','')?></i>
						</p>
					<?php }?>
					
					
				</div>
					<!-- S 平台红包  只有自营店铺可以使用平台红包-->
				<input type="hidden" class="redpacked_id redpacket_<?=($key)?>">
					<?php if($val['shop_self_support'] == 'true' && $data['rpt_list']){?>
						<div class="hongb redpacket<?=($key)?>">
							<span><?=__('红包：')?></span>
							<div class="hongb-sel">
								<input type="hidden" class="red_shop_id" value="<?=($key)?>">
								<div class="hongb-text">
									<i class="icon icon-hongb"></i>
									<span><em class="redtitle"><?=__('请选择你的平台红包金额')?></em><b class="price"><em class="price redprice">0.00</em><?=__('￥')?></b></span>
								</div>
								<div class="hongb-sel-btn" onclick="hongbmorebtn(this)" data="1"><i class="icon up"></i></div>
								<ul class="hongb-more">
									<li><?=__('请选择你的平台红包金额')?></li>
									<?php foreach($data['rpt_list'] as $redkey => $redval){?>
										<?php if($shop_all_cost >= $redval['redpacket_t_orderlimit']){?>
											<li class="redpacket_list red<?=($redval['redpacket_id'])?>" value="<?=$redval['redpacket_price']?>" id="<?=($redval['redpacket_id'])?>">
												<?=$redval['redpacket_title']?>
											</li>
										<?php }?>
									<?php }?>
								</ul>
							</div>
						</div>
					<?php }?>
				<!--- E 平台红包 ---->

			</div>
			<div class="tlr bgf">
				<!--优惠劵-->
				<?php if($val['voucher_base']){?>
					<p class="inline">
						<select class="select">
							<option value="0" shop_id="<?=($val['voucher_base'][0]['voucher_shop_id'])?>">----------------------------请选择优惠劵----------------------------</option>
							<?php foreach($val['voucher_base'] as $voukey => $vouval){ ?>
						<!--判断店铺合计是否满足代金券的使用条件-->
						<?php if($shop_all_cost >= $vouval['voucher_limit']){ ?>
						<option value="<?=($vouval['voucher_price'])?>" voucher_id="<?=$vouval['voucher_id']?>" shop_id="<?=($vouval['voucher_shop_id'])?>"><?=(Web_ConfigModel::value('monetary_unit'))?><?=($vouval['voucher_price'])?>&nbsp;<?=($vouval['voucher_title'])?>&nbsp;<time><?=($vouval['voucher_start_date'])?></time> <?=__('-')?> <time><?=($vouval['voucher_end_date'])?></time></option>
						<?php } ?>
				<?php } ?>
						</select>
					</p>
				<?php } ?>
				<!--如果有购物车商品所属店铺优惠券，则默认显示优惠券使用0-->
				<?php if($val['voucher_base']){?>
				<p class="inline vou-sels shop_voucher<?=($key)?>">
                    <span>代金券优惠</span>
                    <i>
						<?=$voucher_money?>
					</i>
                </p>
					
				<?php } ?>
			</div>
			<?php
				$total += $data['cost'][$key]['cost']+$val['sprice'];
				$total_dian_rate += $dian_rate;
				//促销活动优惠的价格单独赋值一个变量
				$promotion_reduced[] = $reduced_money; //满减
				$voucher_reduced[] = $voucher_money;   //优惠劵
				$promotion_money = array_sum($promotion_reduced) + array_sum($voucher_reduced);//促销活动优惠的总价格
			}?>
			<div class="frank clearfix">
				<div class="invoice tl">
					<h3><?=__('发票信息')?></h3>
					<div class="invoice-cont">
						<input type="hidden" name="invoice_id" value="">
						<input type="hidden" name="invoice_content" value="">
						<input type="hidden" name="invoice_title" value="">
						<span class="mr10"> <?=__('不开发票')?> </span><a class="invoice-edit"><?=__('修改')?></a>
					</div>
				</div>

				<p class="back_cart"><a id="back_cart"><i class="iconfont icon-iconjiantouzuo rel_top2"></i><?=__('返回我的购物车')?></a></p>

				<p class="submit" style="text-align: center;">
					<span>
						<?=__('订单金额：')?>
                            <strong>
							<?=(Web_ConfigModel::value('monetary_unit'))?><i class="total" total_price="<?=(number_format($total,2,'.','') )?>"><?=(number_format($total,2,'.','') )?></i>
                            </strong>
					</span>

					<?php if($user_rate > 0 ){?>
						<?php if( $total_dian_rate > 0 ){?>
							<span>
								<?=__('会员折扣：')?>
								<strong>
									-<?=(Web_ConfigModel::value('monetary_unit'))?><i class="rate_total"><?=number_format($total_dian_rate,2,'.','')?></i>
								</strong>
							</span>
						<?php }?>
					<?php }else{$user_rate = 100;}?>

					<span>
						<?php $after_total = number_format($total-$total_dian_rate-$promotion_money,2,'.','');?>
						<?=__('支付金额：')?>
						<strong class="common-color">
							<?=(Web_ConfigModel::value('monetary_unit'))?><i class="after_total bbc_color" after_total="<?=(number_format($after_total,2,'.','') )?>"><?=(number_format($after_total,2,'.','') )?></i>
						</strong>
					</span>

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
	var app_id = <?=(Yf_Registry::get('shop_app_id'))?>;
	var buy_able = <?=intval($buy_able) ? intval($buy_able) : 1?>;

	$(function(){
		$(".remarks_content").val("");
		$(".remarks_content").keyup(function(){
			var len = $(this).val().length;
			if(len > 45){
				$(this).val($(this).val().substring(0,45));
			}
		});
		var voucher_price = 0;
		var total_price = 0;//店铺加价购商品总金额
		var old_order_price = parseFloat($('.submit').find('.total').attr('total_price'));//没选择加价购商品前的订单总金额
		var old_pay_price = parseFloat($('.submit').find('.after_total').attr('after_total'));//没选择加价购商品前的支付总金额

		//下拉列表选中优惠券金额
		$(".select").change(function(){
			$(this).find("option[value="+ $(this).val() +"]").attr("selected",true);
			var shop_id = $(this).find('option:selected').attr('shop_id');
			if($(this).val() == 0)
			{
				$(".shop_voucher"+shop_id).children("i").html($(this).val());
			}
			else
			{
				$(".shop_voucher"+shop_id).children("i").html("-"+$(this).val());
			}
			$(".select").find('option:selected').each(function(){
				voucher_price += parseFloat($(this).val());
			})
			$('.clearfix.bgf.status').each(function(){
				if($(this).find('input:checkbox').is(':checked'))
				{
					var goods_price = parseFloat($(this).find('.select_increase:checked').attr('goods_price'));
					var now_num = parseInt($(this).find('.select_increase:checked').parents('tr:eq(0)').find('.increase_num').val());
					total_price +=+(goods_price*now_num);
				}
			})
			$('.submit').find('.after_total').html((old_pay_price + (total_price) - (voucher_price)).toFixed(2));
			voucher_price = 0;
			total_price = 0;
		});

		//选择减少加价购商品数量
		$('.declick').on('click', function(e){
			var num = parseInt($(this).next().val());
			var check_status = $(this).parents('tr:eq(0)').find('input:checkbox').is(':checked');
			var goods_price = parseFloat($(this).parents('tr:eq(0)').find('input:checkbox').attr('goods_price'));
			console.info($(this).parents('tr:eq(0)').find('.w150.tc').html());
			if(num > 1)
			{
				$(this).next().val(num-1);
				var price_goods = parseFloat($(this).next().val() * goods_price);//
				var html = '加价购￥'+ price_goods;
//				$(this).parents('tr:eq(0)').find('.w150.tc').html(html).attr('data_price', price_goods);
				if(check_status)
				{
					//当选中的时候点击减少加价购商品，当前店铺总金额和结算总金额都要随着变化
					var shop_id = $(this).parents('tr:eq(0)').find('input:checkbox').attr('shop_id');
					var shop_price = parseInt($(this).parents('tr:eq(0)').find('input:checkbox').attr('shop_price'));//商品金额
					var now_num = $(this).next().val();//当前加价购商品数量

					$(".select").find('option:selected').each(function(){
						voucher_price += parseFloat($(this).val());
					})
					$('.clearfix.bgf.status').each(function(){
						if($(this).find('input:checkbox').is(':checked'))
						{
							var goods_price = parseFloat($(this).find('.select_increase:checked').attr('goods_price'));
							var now_num = parseInt($(this).find('.select_increase:checked').parents('tr:eq(0)').find('.increase_num').val());
							total_price +=+(goods_price*now_num);
						}
					})
					$('.price'+shop_id).html((shop_price + total_price).toFixed(2));
					$('.sprice'+shop_id).html((shop_price + total_price).toFixed(2));
					$('.submit').find('.total').html((old_order_price + total_price).toFixed(2));
					$('.submit').find('.after_total').html((old_pay_price + total_price - voucher_price).toFixed(2));
					total_price = 0;
					voucher_price = 0;
				}
			}

		})
		//选择增加加价购商品数量
		$('.inclick').on('click', function(e){
			var num = parseInt($(this).prev().val());
			var num_max = parseInt($(this).prev().attr('data-max'));//最多购买数
			//点击增加按钮时判断当前加价购商品有没有被选中
			var check_status = $(this).parents('tr:eq(0)').find('input:checkbox').is(':checked');
			var goods_price = parseFloat($(this).parents('tr:eq(0)').find('input:checkbox').attr('goods_price'));
			console.info($(this).parents('tr:eq(0)').find('.w150.tc').html());
			if(num < num_max)
			{
				$(this).prev().val(num+1);
				var price_goods = ($(this).prev().val() * goods_price).toFixed(2);//保留两位小数
				var html = '加价购￥'+ price_goods;
//				$(this).parents('tr:eq(0)').find('.w150.tc').html(html).attr('data_price', price_goods);
				if(check_status)
				{
					//当选中的时候点击增加加价购商品，当前店铺总金额和结算总金额都要随着变化
					var shop_id = $(this).parents('tr:eq(0)').find('input:checkbox').attr('shop_id');
					var now_num = parseInt($(this).prev().val());//当前加价购商品数量
					var shop_price = parseFloat($(this).parents('tr:eq(0)').find('input:checkbox').attr('shop_price'));//本店合计
					console.info(shop_price);

					$(".select").find('option:selected').each(function(){
						voucher_price += parseFloat($(this).val());
					})
					$('.clearfix.bgf.status').each(function(){
						if($(this).find('input:checkbox').is(':checked'))
						{
							var goods_price = parseFloat($(this).find('.select_increase:checked').attr('goods_price'));
							var now_num = parseInt($(this).find('.select_increase:checked').parents('tr:eq(0)').find('.increase_num').val());
							total_price +=+(goods_price*now_num);
						}
					})
					$('.price'+shop_id).html((shop_price + total_price).toFixed(2));
					$('.sprice'+shop_id).html((shop_price + total_price).toFixed(2));
					$('.submit').find('.total').html((old_order_price + total_price).toFixed(2));
					$('.submit').find('.after_total').html((old_pay_price + total_price - voucher_price).toFixed(2));
					total_price = 0;
					voucher_price = 0;
				}
			}
		})

		//当输入框获取焦点时，获取当前的商品数量
		$('.increase_num').on('focus', function(){
			old_goods_num = parseInt($(this).val());
			console.info('old_goods_num++++++'+old_goods_num);
		})

		//判断加价购输入框手动输入的内容
		$('.increase_num').on('keyup', function(){
			//最大限购数量^[1-9]\\d*$
			var num_max = parseInt($(this).attr('data-max'));
			var shop_price = parseFloat($(this).parents('tr:eq(0)').find('input:checkbox').attr('shop_price'));//本店合计
			var goods_price = parseFloat($(this).parents('tr:eq(0)').find('input:checkbox').attr('goods_price'));//商品价格
			var shop_id = $(this).parents('tr:eq(0)').find('input:checkbox').attr('shop_id');
			var check_status = $(this).parents('tr:eq(0)').find('input:checkbox').is(':checked');
			if(! /^[1-9]\d*$/.test(this.value) || $(this).val() < 1)
			{
				$(this).val(1);
				$(this).blur();
				var price_goods = (1 * goods_price).toFixed(2);//保留两位小数
				var html = '加价购￥'+ price_goods;
//				$(this).parents('tr:eq(0)').find('.w150.tc').html(html).attr('data_price', price_goods);
				//判断当前加价购商品是否被选中，如果选中将总计价格做相应修改
				if(check_status)
				{
					if(old_goods_num > 1)
					{
						var diff_num = old_goods_num - 1;
						$('.price'+shop_id).html((shop_price + goods_price*diff_num).toFixed(2));
						$('.sprice'+shop_id).html((shop_price + goods_price*diff_num).toFixed(2));
					}
				}
			}
			else if($(this).val() > num_max)
			{
				$(this).val(num_max);
				$(this).blur();
				var now_num = $(this).val();//输入之后的加价购数量
				var price_goods = (now_num * goods_price).toFixed(2);//保留两位小数
				var html = '加价购￥'+ price_goods;
//				$(this).parents('tr:eq(0)').find('.w150.tc').html(html).attr('data_price', price_goods);
				if(check_status)
				{
					//如果现在数量不等于输入之前的数量，则把订单总金额作相应改变
					if(now_num < old_goods_num)
					{
						var diff_num = old_goods_num - now_num;
						$('.price'+shop_id).html((shop_price + (goods_price*diff_num)).toFixed(2));
						$('.sprice'+shop_id).html((shop_price + (goods_price*diff_num)).toFixed(2));
					}
					else if(now_num > old_goods_num)
					{
						var diff_num = now_num - old_goods_num;
						$('.price'+shop_id).html((shop_price + (goods_price*diff_num)).toFixed(2));
						$('.sprice'+shop_id).html((shop_price + (goods_price*diff_num)).toFixed(2));
					}
				}
			}
			else if($(this).val() <= num_max)
			{
				var now_num = $(this).val();
				$(this).val(now_num);
				$(this).blur();
				var price_goods = (now_num * goods_price).toFixed(2);//保留两位小数
				var html = '加价购￥'+ price_goods;
//				$(this).parents('tr:eq(0)').find('.w150.tc').html(html).attr('data_price', price_goods);
				if(check_status)
				{
					//如果现在数量不等于输入之前的数量，则把订单总金额作相应改变
					if(now_num < old_goods_num)
					{
						var diff_num = old_goods_num - now_num;
						$('.price'+shop_id).html((shop_price + (goods_price*now_num)).toFixed(2));
						$('.sprice'+shop_id).html((shop_price + (goods_price*now_num)).toFixed(2));
					}
					else if(now_num > old_goods_num)
					{
						var diff_num = now_num - old_goods_num;
						$('.price'+shop_id).html((shop_price + (goods_price*now_num)).toFixed(2));
						$('.sprice'+shop_id).html((shop_price + (goods_price*now_num)).toFixed(2));
					}
				}
			}
			$(".select").find('option:selected').each(function(){
				voucher_price += parseFloat($(this).val());
			})
			$('.clearfix.bgf.status').each(function(){
				if($(this).find('input:checkbox').is(':checked'))
				{
					var goods_price = parseFloat($(this).find('.select_increase:checked').attr('goods_price'));
					var now_num = parseInt($(this).find('.select_increase:checked').parents('tr:eq(0)').find('.increase_num').val());
					total_price +=+(goods_price*now_num);
				}
			})
			$('.submit').find('.total').html((old_order_price + total_price).toFixed(2));
			$('.submit').find('.after_total').html((old_pay_price + total_price - voucher_price).toFixed(2));
			total_price = 0;
			voucher_price = 0;
		})
		var total_shop_price = 0;//店铺加价购商品总金额
		//点击选择一个加价购商品
		$('.select_increase').on('click', function() {
			var shop_id = $(this).attr('shop_id');
			var shop_price = parseFloat($(this).attr('shop_price'));//本店合计

			if ($(this).is(':checked')) {
				$(this).attr('checked', true);
				$(this).parents('.clearfix.bgf.' + shop_id).addClass('status');
			}
			else {
				$(this).attr('checked', false);
				$(this).parents('.clearfix.bgf.' + shop_id).removeClass('status');
				//当某个店铺取消选择加价购商品时，将当前店铺的商品总价恢复，总订单金额改变
				//循环累加当前店铺选中的加价购商品
			}

			$(".select").find('option:selected').each(function () {
				voucher_price += parseFloat($(this).val());
			});
			//循环累加当前店铺选中的加价购商品
			$('.clearfix.bgf.' + shop_id).each(function () {
				if ($(this).find('input:checkbox').is(':checked')) {
					var goods_price = parseFloat($(this).find('.select_increase:checked').attr('goods_price'));
					var now_num = parseInt($(this).find('.select_increase:checked').parents('tr:eq(0)').find('.increase_num').val());
					total_shop_price += +(goods_price * now_num);
				}
			})

			$('.price' + shop_id).html((shop_price + total_shop_price).toFixed(2));
			$('.sprice' + shop_id).html((shop_price + total_shop_price).toFixed(2));

			$('.clearfix.bgf.status').each(function () {
				if ($(this).find('input:checkbox').is(':checked')) {
					var goods_price = parseFloat($(this).find('.select_increase:checked').attr('goods_price'));
					var now_num = parseInt($(this).find('.select_increase:checked').parents('tr:eq(0)').find('.increase_num').val());
					total_price += +(goods_price * now_num);
				}
			})

			console.info(total_price);
			$('.submit').find('.total').html((old_order_price + total_price).toFixed(2));
			$('.submit').find('.after_total').html((old_pay_price + total_price - voucher_price).toFixed(2));
			total_shop_price = 0;
			total_price = 0;
			voucher_price = 0;
		})
	});
</script>
<?php
include $this->view->getTplPath() . '/' . 'buyer_footer.php';
?>