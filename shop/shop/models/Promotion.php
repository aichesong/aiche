<?php

/**
 * @author     yesai
 */
class Promotion extends Yf_Model
{
	//活动对象初始化
	public $GroupBuy_BaseModel = null;  //团购
	
	public $Increase_BaseModel        = null;    //加价购
	public $Increase_GoodsModel       = null;
	public $Increase_RuleModel        = null;
	public $Increase_RedempGoodsModel = null;
	
	public $Discount_BaseModel  = null;  //显示折扣
	public $Discount_GoodsModel = null;

	public $ManSong_RuleModel = null;  //满减、满送
	public $ManSong_BaseModel = null;
	
	
	/**
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->GroupBuy_BaseModel        = new GroupBuy_BaseModel();
		$this->Increase_BaseModel        = new Increase_BaseModel();
		$this->Increase_GoodsModel       = new Increase_GoodsModel();
		$this->Increase_RuleModel        = new Increase_RuleModel();
		$this->Increase_RedempGoodsModel = new Increase_RedempGoodsModel();
		$this->Discount_BaseModel        = new Discount_BaseModel();
		$this->Discount_GoodsModel       = new Discount_GoodsModel();
		$this->ManSong_BaseModel         = new ManSong_BaseModel();
		$this->ManSong_RuleModel         = new ManSong_RuleModel();
	}

	/*
	 * 商城所有促销活动说明：
	促销互动分为以下几种：
	1、团购：优先级最高，团购中的商品价格以团购价格为准，团购商品有购买上限限制，超过购买上限的无法加入购物车；

	2、限时折扣，如果同一件商品既参加了团购（状态正常），又参加了限时折扣（状态正常），商品价格以团购价格为准，
		否则以限时折扣价格为准，限时折扣活动商品存在购买下限限制，即参加活动的单个商品数量必须满足该数量限制，同一
	    订单中，参加同一活动的不同商品数量不做累加判断

	3、参加限时折扣的商品，有购买下限限制（默认为1），购物车中的商品价格需根据购买数量调整，不满足下限数量的，商品
		仍以原价格计算

	4、加价购活动简介
	参加加价购活动的商品对其本身价格并不会产生影响，即使该商品也在活动规则下的换购商品中
	买家在购物车页面可以自主选择对应的换购商品，每件商品仅可以换购一件，换购商品价格以换购价为准，等级高的规则会覆盖等级低的规格，规则中的
	换购商品数量限制仅用于限定不同的换购商品
	同一订单中，参与同一活动的SKU共同累加的金额用于判断是否满足换购资格；
	同一订单中可以使用多组加价购活动

	5、店铺满减满赠针对店铺所有商品，所以当一笔订单的总金额（包含换购商品的金额），满足规格设定的金额后，即满足活动要求，
	对应的优惠包括减现金和送礼品两种方式中的一种或全部，同一个满即送活动最多可以设置三个规则级别，订单满足的活动规则以满足
	最高规则金额的为准，减除的现金和赠送的礼品亦以该规则为准。
	*/


	public function getGoodsPromotinListByGoodsId($goods_id, $shop_id)
	{
		$ret_rows             = array();
		$ret_rows['discount'] = $this->getXianShiGoodsInfoByGoodsID($goods_id);//限时折扣
		$increase_row         = $this->getIncreaseDetailByGoodsId($goods_id);//加价购
		if ($increase_row)
		{
			$ret_rows['increase'] = $increase_row;
		}

		$cut_gift_row = $this->getShopGiftInfo($shop_id);
		if ($cut_gift_row)
		{
			$ret_rows['cut_gift'] = $cut_gift_row;
		}

		return $ret_rows;
	}

	//查询商品参加的团购活动详情
	public function getGroupBuyInfoByGoodsCommonID($common_id)
	{
		$renew_row = array();
		if (Web_ConfigModel::value('groupbuy_allow'))  //团购开启
		{
			$cond_row['common_id']      = $common_id;
			$cond_row['groupbuy_state'] = GroupBuy_BaseModel::NORMAL;
			$renew_row   = $this->GroupBuy_BaseModel->getGroupBuyDetailByWhere($cond_row);
		}
		return $renew_row;
	}

	//获取商品限时折扣信息
	public function getXianShiGoodsInfoByGoodsID($goods_id)
	{
		$renew_row = array();

		if (Web_ConfigModel::value('promotion_allow')) //商品促销开启，包括限时折扣，满送，加价购
		{
			$cond_row['goods_id']             = $goods_id;
			$cond_row['discount_goods_state'] = Discount_GoodsModel::NORMAL;
			$renew_row  = $this->Discount_GoodsModel->getDiscountGoodsDetailByWhere($cond_row);
		}

		return $renew_row;
	}

	//加价购信息
	public function getIncreaseDetailByGoodsId($goods_id)
	{
		$increase_row = array();
		$renew_row    = array();
		if (Web_ConfigModel::value('promotion_allow')) //商品促销开启，包括限时折扣，满送，加价购
		{
			$cond_row['goods_id'] = $goods_id;
			$cond_row['goods_start_time:<='] = get_date_time();
			$cond_row['goods_end_time:>='] = get_date_time();
			$increase_goods_row   = $this->Increase_GoodsModel->getOneIncreaseGoodsByWhere($cond_row);
			if ($increase_goods_row)
			{
				$renew_row = $increase_row = $this->Increase_BaseModel->getIncreaseActDetail($increase_goods_row['increase_id']);
			}
		}

		return $renew_row;
	}

	/*
	 * 店铺满即送信息
	 *  parameter shop_id
	*/
	public function getShopGiftInfo($shop_id)
	{
		$renew_row = array();

		if (Web_ConfigModel::value('promotion_allow')) //商品促销开启，包括限时折扣，满送，加价购
		{
			$cond_row['shop_id']       = $shop_id;
			$cond_row['mansong_state'] = ManSong_BaseModel::NORMAL;
			$row                       = $this->ManSong_BaseModel->getManSongActItem($cond_row);
			if ($row)
			{
				if ($row['mansong_state'] == ManSong_BaseModel::NORMAL && time() >= strtotime($row['mansong_start_time']))
				{
					$renew_row = $row;
				}
			}
		}

		return $renew_row;
	}


	/*获取整个订单中所有商品的团购和限时折扣促销信息
	*
	 *order_info 订单信息
	 *
	*/
	public function getOrderPromotionInfo($order_info = array())
	{
		$rows              = array();
		$cond_row_groupbuy = array();

		if (empty($order_info))
		{
			//1、获取卖家userId和用户等级
			$userId    = $order_info['buyer_id'];
			$userGrade = $order_info['buyer_grade'];
			$shop_id   = $order_info['shop_id'];

			//2、循环订单中商品
			foreach ($order_info['goods'] as $okey => $goods)
			{
				$goods_id                            = $goods['goods_id'];
				$cond_row_groupbuy['goods_id']       = $goods_id;
				$cond_row_groupbuy['groupbuy_state'] = GroupBuy_BaseModel::NORMAL;
				$groupbuy_row                        = $this->GroupBuy_BaseModel->getGroupBuyDetailByWhere($cond_row_groupbuy);
				if ($groupbuy_row) //团购
				{
					if (Web_ConfigModel::value('groupbuy_allow')) //团购功能开启
					{
						$rows[$shop_id][$goods_id]['groupbuy']['activity_name']  = $groupbuy_row['groupbuy_name'];
						$rows[$shop_id][$goods_id]['groupbuy']['activity_price'] = $groupbuy_row['groupbuy_price'];
						if ($groupbuy_row['groupbuy_upper_limit'] > 0)
						{
							$rows[$shop_id][$goods_id]['groupbuy']['goods_num'] = $groupbuy_row['groupbuy_upper_limit'];
						}
						else
						{
							$rows[$shop_id][$goods_id]['groupbuy']['goods_num'] = $groupbuy_row['groupbuy_upper_limit'];
						}
					}
				}
				else  //限时折扣
				{
					if (Web_ConfigModel::value('promotion_allow')) //促销开启
					{
						$cond_row_discount['goods_id']             = $goods_id;
						$cond_row_discount['shop_id']              = $shop_id;
						$cond_row_discount['goods_lower_limit:<='] = $goods['num'];//限时折扣商品数量限制
						$cond_row_discount['discount_goods_state'] = Discount_GoodsModel::NORMAL;
						$discount_row                              = $this->Discount_GoodsModel->getDiscountGoodsDetailByWhere($cond_row_discount);
						if ($discount_row && time() >= strtotime($discount_row['goods_end_time']))
						{
							$rows[$shop_id][$goods_id]['discount'] = $discount_row;
						}
					}
				}
			}
		}
		
		return $rows;
	}

	/*满即送活动信息*/
	public function getShopOrderGift($shop_id, $order_price)
	{
		$renew_row = array();
		if (Web_ConfigModel::value('promotion_allow')) //促销开启
		{
			$cond_row['shop_id']       = $shop_id;
			$cond_row['mansong_state'] = ManSong_BaseModel::NORMAL;
			$mansong_rows              = $this->ManSong_BaseModel->getManSongActItem($cond_row);
			if ($mansong_rows)
			{
				if ($mansong_rows['mansong_state'] == ManSong_BaseModel::NORMAL && time() >= strtotime($mansong_rows['mansong_start_time']))
				{
					foreach ($mansong_rows['rule'] as $key => $rule)
					{
						if ($order_price >= $rule['rule_price'])
						{
							$renew_row['rule_discount'] = $rule['rule_discount'];
							$renew_row['rule_price'] 	= $rule['rule_price'];
							$renew_row['gift_goods_id'] = $rule['goods_id'];
							$renew_row['shop_id']       = $shop_id;
						}
					}
				}
			}
		}

		return $renew_row;
	}

	//根据订单中已有的商品信息获取对应可以选择的加价购换购商品信息
	/*
	 * order_info 订单信息
	order_info['shop_id']
	order_info['goods_list']
	order_info['goods_list']['goods_id']
	order_info['goods_list']['goods_num']
	order_info['goods_list']['goods_price']
	*/
	public function getOrderIncreaseInfo($order_info = array())
	{
		$ret_row = array();
		if (Web_ConfigModel::value('promotion_allow')) //促销开启
		{
			if ($order_info)
			{
				$shop_id         = $order_info['shop_id'];
                fb($order_info);
                $goods_row                  = array_column($order_info['goods'], 'goods_id');
                $goods_price_row            = array_column($order_info['goods'], 'sumprice', 'goods_id');
				$cond_row['goods_id:IN']   = $goods_row;
				$cond_row['shop_id']       = $shop_id;
				$cond_row['goods_start_time:<='] = get_date_time();
				$cond_row['goods_end_time:>='] = get_date_time();


                //查询出该订单中所有参加活动的商品
				$increase_goods_rows        = $this->Increase_GoodsModel->getIncreaseGoodsByWhere($cond_row);

				if ($increase_goods_rows)
				{
					//每个加价购活动下参加活动的商品
					foreach ($increase_goods_rows as $k => $v)
					{
						$increase_row[$v['increase_id']]['goods'][$v['goods_id']] = $v;
					}

                    $increase_id_row                       = array_column($increase_goods_rows, 'increase_id');
					//一笔订单中参加的所有加价购活动
					$cond_increase_row['increase_id:IN'] = $increase_id_row;
					$cond_increase_row['shop_id']         = $shop_id;
					$cond_increase_row['increase_state'] = Increase_BaseModel::NORMAL;
					$increase_rows                       = $this->Increase_BaseModel->getIncreaseByWhere($cond_increase_row);

					if ($increase_rows)
					{
						foreach ($increase_rows as $kk => $vv)
						{
							$increase_row[$vv['increase_id']]['increase_info'] = $vv;//每个加价购活动信息
						}
					}

					//所有活动的规则信息
					$cond_rule_row['increase_id:IN'] = $increase_id_row;
					$order_rule_row['rule_price']    = 'ASC';
					$increase_rule_rows              = $this->Increase_RuleModel->getIncreaseRuleByWhere($cond_rule_row, $order_rule_row);
					if ($increase_rule_rows)
					{
						foreach ($increase_rule_rows as $rk => $rvalue)
						{
							$increase_row[$rvalue['increase_id']]['rules'][$rvalue['rule_price']] = $rvalue;
						}
					}

					//活动下的所有规则下的换购商品信息
					$cond_row_exc['increase_id:IN'] = $increase_id_row;
					$cond_row_exc['shop_id']        = $shop_id;
					$redemp_goods_rows              = $this->Increase_RedempGoodsModel->getIncreaseRedempGoodsByWhere($cond_row_exc);
					if ($redemp_goods_rows)
					{
						foreach ($redemp_goods_rows as $exk => $exvalue)
						{
							$increase_row[$exvalue['increase_id']]['exc_goods'][$exvalue['rule_id']][$exvalue['redemp_goods_id']] = $exvalue;
						}
					}
					else
					{
						;
					}

					if ($increase_row)
					{
						foreach ($increase_row as $key => $value)
						{
							$increase_goods_price = 0;//同一活动下的商品总金额
							foreach ($value['goods'] as $kk => $vv)
							{
								$increase_goods_price += $goods_price_row[$kk];
							}
							//每个活动下的规则
							$rule_price = 0;

							//需要根据规则金额排序
							//$value['rules'] = ksort($value['rules']);
							// print_r($value['rules']);die;
							$exc_goods = array();
							foreach ($value['rules'] as $kk => $vv)
							{
								if ($increase_goods_price >= $vv['rule_price'] && $vv['rule_price'] >= $rule_price)
								{
									if ($value['exc_goods'][$vv['rule_id']])
									{
										$exc_goods                  = array_merge($exc_goods, $value['exc_goods'][$vv['rule_id']]);
										$ret_row[$key]['exc_goods'] = $exc_goods;
										//$ret_row[$key]['exc_goods'] = $value['exc_goods'][$vv['rule_id']];
										$ret_row[$key]['exc_goods_limit'] = $vv['rule_goods_limit'];
										$ret_row[$key]['rule_info']       = $vv;
										$rule_price                       = $vv['rule_price'];
										$ret_row[$key]['shop_id']         = $shop_id;
									}
									

								}
							}
						}
					}
				}
			}
		}
		
		return $ret_row;
	}

}

?>