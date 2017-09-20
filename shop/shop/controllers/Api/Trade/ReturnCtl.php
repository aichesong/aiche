<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * Api接口, 让App等调用
 *
 *
 * @category   Game
 * @package    User
 * @author     Xinze <xinze@live.cn>
 * @copyright  Copyright (c) 2015, 黄新泽
 * @version    1.0
 * @todo
 */
class Api_Trade_ReturnCtl extends Api_Controller
{

	const PAY_SITE = "http://paycenter.yuanfeng021.com/";
	//const PAY_SITE	 = "http://localhost/repos/paycenter/";
	public $Order_BaseModel         = null;
	public $Order_ReturnModel       = null;
	public $Order_ReturnReasonModel = null;
	public $Order_GoodsModel        = null;

	/**
	 * Constructor
	 *
	 * @param  string $ctl 控制器目录
	 * @param  string $met 控制器方法
	 * @param  string $typ 返回数据类型
	 * @access public
	 */
	public function __construct(&$ctl, $met, $typ)
	{
		parent::__construct($ctl, $met, $typ);
		$this->Order_BaseModel         = new Order_BaseModel();
		$this->Order_ReturnModel       = new Order_ReturnModel();
		$this->Order_ReturnReasonModel = new Order_ReturnReasonModel();
		$this->Order_GoodsModel        = new Order_GoodsModel();

	}

	public function getReasonList()
	{
		$page                             = request_int('page', 1);
		$rows                             = request_int('rows', 10);
		$oname                            = request_string('sidx');
		$osort                            = request_string('sord');
		$cond_row                         = array();
		$sort                             = array();
		$sort['order_return_reason_sort'] = "ASC";
		if ($oname != "number")
		{
			$sort[$oname] = $osort;
		}
		$data = array();
		$data = $this->Order_ReturnReasonModel->getReturnReasonList($cond_row, $sort, $page, $rows);
		$this->data->addBody(-140, $data);
	}

	public function addReasonBase()
	{
		$field['order_return_reason_content'] = request_string("order_return_reason_content");
		$field['order_return_reason_sort']    = request_int("order_return_reason_sort");
		$flag                                 = $this->Order_ReturnReasonModel->addReturn($field, true);
		if ($flag)
		{
			$msg    = __('success');
			$status = 200;
		}
		else
		{
			$msg    = __('failure');
			$status = 250;
		}

		$data = array();

		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function editReason()
	{
		$id   = request_int("id");
		$data = $this->Order_ReturnReasonModel->getOne($id);
		$this->data->addBody(-140, $data);
	}

	public function editReasonBase()
	{
		$id                                   = request_int("order_return_reason_id");
		$field['order_return_reason_content'] = request_string("order_return_reason_content");
		$field['order_return_reason_sort']    = request_int("order_return_reason_sort");
		$flag                                 = $this->Order_ReturnReasonModel->editReturn($id, $field);
		if ($flag)
		{
			$msg    = __('success');
			$status = 200;
		}
		else
		{
			$msg    = __('failure');
			$status = 250;
		}

		$data = array();

		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function delReason()
	{
		$id   = request_int("id");
		$flag = $this->Order_ReturnReasonModel->removeReturn($id);
		if ($flag)
		{
			$msg    = __('success');
			$status = 200;
		}
		else
		{
			$msg    = __('failure');
			$status = 250;
		}

		$data = array();

		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function getReturnWaitList()
	{
		$type                = request_int("otyp", Order_ReturnModel::RETURN_TYPE_ORDER);
		$return_code         = request_string("return_code");
		$seller_user_account = request_string("seller_user_account");
		$buyer_user_account  = request_string("buyer_user_account");
		$order_goods_name    = request_string("order_goods_name");
		$order_number        = request_string("order_number");
		$start_time          = request_string("start_time");
		$end_time            = request_string("end_time");
		$min_cash            = request_float("min_cash");
		$max_cash            = request_float("max_cash");

		$page     = request_int('page', 1);
		$rows     = request_int('rows', 10);
		$oname    = request_string('sidx');
		$osort    = request_string('sord');
		$cond_row = array();
		$sort     = array();
		if ($oname != "number")
		{
			$sort[$oname] = $osort;
		}

		if ($return_code)
		{
			$cond_row['return_code'] = $return_code;
		}
		if ($seller_user_account)
		{
			$cond_row['seller_user_account'] = $seller_user_account;
		}
		if ($buyer_user_account)
		{
			$cond_row['buyer_user_account'] = $buyer_user_account;
		}
		if ($order_goods_name)
		{
			$cond_row['order_goods_name:LIKE'] = '%' . $order_goods_name . '%';
		}
		if ($start_time)
		{
			$cond_row['return_add_time:>='] = $start_time;
		}
		if ($end_time)
		{
			$cond_row['return_add_time:<='] = $end_time;
		}
		if ($min_cash)
		{
			$cond_row['return_cash:>='] = $min_cash;
		}
		if ($max_cash)
		{
			$cond_row['return_cash:<='] = $max_cash;
		}
		$cond_row['return_state:IN'] = array('0'=>Order_ReturnModel::RETURN_SELLER_UNPASS,'1'=>Order_ReturnModel::RETURN_SELLER_GOODS);
		$cond_row['return_type']  = $type;
		$cond_row['behalf_deliver:!=']  = Order_ReturnModel::BEHALF_DELIVER_SHOP;
		$data                     = array();
		$data                     = $this->Order_ReturnModel->getReturnList($cond_row, $sort, $page, $rows);
		$this->data->addBody(-140, $data);
	}

	public function getReturnAllList()
	{
		$type                = request_int("otyp", Order_ReturnModel::RETURN_TYPE_ORDER);
		$return_code         = request_string("return_code");
		$seller_user_account = request_string("seller_user_account");
		$buyer_user_account  = request_string("buyer_user_account");
		$order_goods_name    = request_string("order_goods_name");
		$order_number        = request_string("order_number");
		$start_time          = request_string("start_time");
		$end_time            = request_string("end_time");
		$min_cash            = request_float("min_cash");
		$max_cash            = request_float("max_cash");

		$page     = request_int('page', 1);
		$rows     = request_int('rows', 10);
		$oname    = request_string('sidx');
		$osort    = request_string('sord');
		$cond_row = array();
		$sort     = array();
		if ($oname != "number")
		{
			$sort[$oname] = $osort;
		}

		if ($return_code)
		{
			$cond_row['return_code'] = $return_code;
		}
		if ($seller_user_account)
		{
			$cond_row['seller_user_account'] = $seller_user_account;
		}
		if ($buyer_user_account)
		{
			$cond_row['buyer_user_account'] = $buyer_user_account;
		}
		if ($order_goods_name)
		{
			$cond_row['order_goods_name:LIKE'] = '%' . $order_goods_name . '%';
		}
		if ($start_time)
		{
			$cond_row['return_add_time:>='] = $start_time;
		}
		if ($end_time)
		{
			$cond_row['return_add_time:<='] = $end_time;
		}
		if ($min_cash)
		{
			$cond_row['return_cash:>='] = $min_cash;
		}
		if ($max_cash)
		{
			$cond_row['return_cash:<='] = $max_cash;
		}
		$cond_row['return_type'] = $type;
		$data                    = array();
		$data                    = $this->Order_ReturnModel->getReturnList($cond_row, $sort, $page, $rows);
		$this->data->addBody(-140, $data);
	}



	public function detail()
	{
		$data['id']    = request_int('id');
		$id            = request_int('id');
		$data          = $this->Order_ReturnModel->getReturnBase($id);
		$data['order'] = $this->Order_BaseModel->getOne($data['order_number']);
		$this->data->addBody(-140, $data);
	}

	public function agree()
	{
		$Order_StateModel        = new Order_StateModel();
		$order_return_id         = request_int("order_return_id");
		$return_platform_message = request_string("return_platform_message");
		$return                  = $this->Order_ReturnModel->getOne($order_return_id);
		fb($return);

		//判断商家是否同意退款
		if($return['return_state'] == Order_ReturnModel::RETURN_SELLER_UNPASS)
		{
			//不同意
			$data = array();
			$data['return_platform_message'] = $return_platform_message;
			$data['return_state']            = Order_ReturnModel::RETURN_PLAT_PASS;
			$data['return_finish_time']      = get_date_time();
			$rs_row                          = array();
			$this->Order_ReturnModel->sql->startTransactionDb();
			$edit_flag = $this->Order_ReturnModel->editReturn($order_return_id, $data);
			check_rs($edit_flag, $rs_row);

			//根据order_id查找订单信息
			$order_base = $this->Order_BaseModel->getOne($return['order_number']);
			fb($order_base);

			//如果是分销商的进货单则同时退掉买家订单
			if($order_base['order_source_id'])
			{
				$dist_return = $this->Order_ReturnModel->getOneByWhere(array('order_number' => $order_base['order_source_id'],'return_type'=>$return['return_type']));

				$this->refuseDist($dist_return['order_return_id'],$data);
			}

			if ($return['return_goods_return'])
			{
				//商家拒绝退款退货3
				$goods_data['goods_refund_status'] = Order_GoodsModel::REFUND_REF;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}
			else
			{
				$goods_data['goods_return_status'] = Order_GoodsModel::REFUND_REF;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}

		}
		else
		{
			//同意
			$data = array();
			$data['return_platform_message'] = $return_platform_message;
			$data['return_state']            = Order_ReturnModel::RETURN_PLAT_PASS;
			$data['return_finish_time']      = get_date_time();
			$rs_row                          = array();
			$this->Order_ReturnModel->sql->startTransactionDb();
			$edit_flag = $this->Order_ReturnModel->editReturn($order_return_id, $data);
			check_rs($edit_flag, $rs_row);

			//根据order_id查找订单信息
			$order_base = $this->Order_BaseModel->getOne($return['order_number']);

			//如果是分销商的进货单则同时退掉买家订单
			fb($order_base);
			if($order_base['order_source_id'])
			{
				$dist_return = $this->Order_ReturnModel->getOneByWhere(array('order_number' => $order_base['order_source_id'],'return_type'=>$return['return_type']));
				$this->agreeDist($dist_return['order_return_id'],$data);
			}

			if ($return['return_goods_return'])
			{
				//商品退换情况为完成2
				$goods_data['goods_refund_status'] = Order_GoodsModel::REFUND_COM;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}
			else
			{
				$goods_data['goods_return_status'] = Order_GoodsModel::REFUND_COM;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}
			$ogoods_data = array();
			$ogoods_data['order_goods_returnnum'] = $return['order_goods_num'];
			$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $ogoods_data,true);
			check_rs($edit_flag, $rs_row);


			//退款金额，退货数量，交易佣金退款更新到订单表中
			$order_edit = array();
			//判断商品金额是否全都退还，如果全部退还订单状态修改为完成状态(用订单商品数判断)
			//订单中所有商品数量
			$order_goods = $this->Order_GoodsModel->getByWhere(array('order_id'=>$return['order_number'],'order_goods_amount:>'=>0));
			$order_all_goods_num      = array_sum(array_column($order_goods, 'order_goods_num'));

			//查找该笔订单已经完成的退款，退货
			$order_return = $this->Order_ReturnModel->getByWhere(array(
																	 'order_number' => $return['order_number'],
																	 'return_state' => Order_ReturnModel::RETURN_PLAT_PASS
																 ));
			//订单已经退还的商品数量
			$order_return_num = array_sum(array_column($order_return, 'order_goods_num'));

			$order_edit['order_refund_amount'] = $return['return_cash'];
			$order_edit['order_return_num'] = $return['order_goods_num'];
			$order_edit['order_commission_return_fee'] = $return['return_commision_fee'];
			$order_edit['order_rpt_return'] = $return['return_rpt_cash'];

			$edit_flag  = $this->Order_BaseModel->editBase($return['order_number'], $order_edit,true);
			check_rs($edit_flag, $rs_row);
			if($order_all_goods_num == $order_return_num && $order_base['order_status'] !== $Order_StateModel::ORDER_FINISH)
			{
				$order_edit_row = array();
				$order_edit_row['order_status'] = $Order_StateModel::ORDER_FINISH;

				$edit_flag2  = $this->Order_BaseModel->editBase($return['order_number'], $order_edit_row);
				check_rs($edit_flag2, $rs_row);
			}

			if($edit_flag)
			{
				//判断该笔订单是否是主账号支付，如果是主账号支付，则将退款金额退还主账号
				if($order_base['order_sub_pay'] == Order_StateModel::SUB_SELF_PAY)
				{
					$return_user_id = $return['buyer_user_id'];
					$return_user_name = $return['buyer_user_account'];
				}
				if($order_base['order_sub_pay'] == Order_StateModel::SUB_USER_PAY)
				{
					//查找主管账户用户名
					$User_BaseModel = new  User_BaseModel();
					$sub_user_base = $User_BaseModel->getOne($order_base['order_sub_user']);

					$return_user_id = $order_base['order_sub_user'];
					$return_user_name = $sub_user_base['user_account'];
				}

				$key      = Yf_Registry::get('shop_api_key');
				$url         = Yf_Registry::get('paycenter_api_url');
				$shop_app_id = Yf_Registry::get('shop_app_id');

				$formvars             = array();
				$formvars['app_id']        = $shop_app_id;
				$formvars['user_id']  = $return_user_id;
				$formvars['user_account'] = $return_user_name;
				$formvars['seller_id'] = $return['seller_user_id'];
				$formvars['seller_account'] = $return['seller_user_account'];
				$formvars['amount']   = $return['return_cash'];
				$formvars['return_commision_fee']   = $return['return_commision_fee'];
				$formvars['order_id'] = $return['order_number'];
				$formvars['goods_id'] = $return['order_goods_id'];
				$formvars['payment_id'] = $order_base['payment_id'];

				//SP分销单没有payment_other_number这个字段值会报错，所以在此做判断
				if($order_base['payment_other_number'])
				{
					$formvars['uorder_id'] = $order_base['payment_other_number'];
				}
				else
				{
					$formvars['uorder_id'] = $order_base['payment_number'];
				}


				//平台同意退款（只增加买家的流水）
				$rs                   = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=refundBuyerTransfer&typ=json', $url), $formvars);
				$data['for']  =           $formvars;
				if ($rs['status'] == 200)
				{
					check_rs(true, $rs_row);
				}
				else
				{
					check_rs(false, $rs_row);
				}
				$edit_flag = is_ok($rs_row);
			}

			//如果订单金额全数退还需要将订单商品，支付中心的订单状态修改为订单完成(未发货)
			if($order_all_goods_num == $order_return_num && $order_base['order_status'] == Order_StateModel::ORDER_PAYED)
			{
				$goods_data['order_goods_status'] = $Order_StateModel::ORDER_FINISH;
				$order_goods_ids_row = $this->Order_GoodsModel->getByWhere(array('order_id'=>$return['order_number']));
				$order_goods_ids = current($order_goods_ids_row);
				$ed_flag                         = $this->Order_GoodsModel->editGoods($order_goods_ids['order_goods_id'], $goods_data);
				check_rs($ed_flag, $rs_row);

				//将需要确认的订单号远程发送给Paycenter修改订单状态
				//远程修改paycenter中的订单状态
				$key      = Yf_Registry::get('shop_api_key');
				$url         = Yf_Registry::get('paycenter_api_url');
				$shop_app_id = Yf_Registry::get('shop_app_id');
				$formvars = array();

				$formvars['order_id']    = $return['order_number'];
				$formvars['app_id']        = $shop_app_id;
				$formvars['from_app_id'] = Yf_Registry::get('shop_app_id');

				$rs = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=confirmOrder&typ=json', $url), $formvars);

				if($rs['status'] == 250)
				{
					$rs_flag = false;
					check_rs($rs_flag,$rs_row);
				}
			}

		}
		$data['rs'] = $rs_row;

		$flag = is_ok($rs_row);

		if ($flag && $this->Order_ReturnModel->sql->commitDb())
		{
			$status = 200;
			$msg    = __('success');

			/**
			 *  加入统计中心
			 */
			//如果$return['order_goods_id']为0则为退款
			if($return['order_goods_id'])
			{
				$order_goods_data = $this->Order_GoodsModel->getOne($return['order_goods_id']);
				$order_return_goods_id = $order_goods_data['goods_id'];
				$order_goods_num = $return['order_goods_num'];
			}
			else
			{
				$order_goods_data = $this->Order_GoodsModel->getGoodsListByOrderId($return['order_number']);
				if(count($order_goods_data['items']) == 1)
				{
					$order_return_goods_id = $order_goods_data['items'][0]['goods_id'];
				}
				else
				{
					$order_return_goods_id = 0;
				}
				$order_goods_num = $order_goods_data['items'][0]['order_goods_num'];
			}

			$analytics_data = array(
				'order_id'=>array($return['order_number']),
				'return_cash'=>$return['return_cash'],
				'order_goods_num'=>$order_goods_num,
				'order_goods_id'=>$order_return_goods_id,
				'status'=>9	//暂时将退款退货统一处理
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsUpdateOrderStatus',$analytics_data);
			/******************************************************************/
		}
		else
		{
			$this->Order_ReturnModel->sql->rollBackDb();
			$status = 250;
			$msg    = __('failure');
		}
		$this->data->addBody(-140, $data, $msg, $status);

	}

	public function refuse()
	{
		$Order_StateModel        = new Order_StateModel();
		$order_return_id         = request_int("order_return_id");
		$return_platform_message = request_string("return_platform_message");
		$return                  = $this->Order_ReturnModel->getOne($order_return_id);

		$data['return_platform_message'] = $return_platform_message;
		$data['return_state']            = Order_ReturnModel::RETURN_PLAT_UNPASS;
		$data['return_finish_time']      = get_date_time();
		$rs_row                          = array();
		$this->Order_ReturnModel->sql->startTransactionDb();
		$edit_flag = $this->Order_ReturnModel->editReturn($order_return_id, $data);
		check_rs($edit_flag, $rs_row);


		if($return['return_state'] == Order_ReturnModel::RETURN_SELLER_UNPASS)
		{
			//不同意
			if ($return['return_goods_return'])
			{
				//商家拒绝退款退货3
				$goods_data['goods_refund_status'] = Order_GoodsModel::REFUND_REF;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}
			else
			{
				$goods_data['goods_return_status'] = Order_GoodsModel::REFUND_REF;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}

		}
		else
		{
			//同意
			if ($return['return_goods_return'])
			{
				//商品退换情况为完成2
				$goods_data['goods_refund_status'] = Order_GoodsModel::REFUND_COM;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}
			else
			{
				$goods_data['goods_return_status'] = Order_GoodsModel::REFUND_COM;
				$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
				check_rs($edit_flag, $rs_row);
			}
		}



		$data['rs'] = $rs_row;
		if ($edit_flag && $this->Order_ReturnModel->sql->commitDb())
		{
			$status = 200;
			$msg    = __('success');

			/**
			 *  加入统计中心
			 */
			//如果$return['order_goods_id']为0则为退款
			if($return['order_goods_id'])
			{
				$order_goods_data = $this->Order_GoodsModel->getOne($return['order_goods_id']);
				$order_return_goods_id = $order_goods_data['goods_id'];
				$order_goods_num = $return['order_goods_num'];
			}
			else
			{
				$order_goods_data = $this->Order_GoodsModel->getGoodsListByOrderId($return['order_number']);
				if(count($order_goods_data['items']) == 1)
				{
					$order_return_goods_id = $order_goods_data['items'][0]['goods_id'];
				}
				else
				{
					$order_return_goods_id = 0;
				}
				$order_goods_num = $order_goods_data['items'][0]['order_goods_num'];
			}

			$analytics_data = array(
				'order_id'=>array($return['order_number']),
				'return_cash'=>$return['return_cash'],
				'order_goods_num'=>$order_goods_num,
				'order_goods_id'=>$order_return_goods_id,
				'status'=>9	//暂时将退款退货统一处理
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsUpdateOrderStatus',$analytics_data);
			/******************************************************************/
		}
		else
		{
			$this->Order_ReturnModel->sql->rollBackDb();
			$status = 250;
			$msg    = __('failure');
		}
		$this->data->addBody(-140, $data, $msg, $status);

	}

	public function CountAmount()
	{
		$order_id = request_string('id');
		$Order_ReturnModel = new Order_ReturnModel();
		$order_ids  = explode(',',$order_id);
		$data = $Order_ReturnModel->getByWhere(array('order_return_id:in'=>$order_ids));
		$data = array_values($data);
		$money = 0;
		if(!empty($data))
		{
			foreach($data as $key=>$value)
			{
				$money+=$value['return_cash'];
			}
		}
		$result = array();
		$result['money'] = $money;
		$this->data->addBody(-140, $result);
	}

	//不同意分销退款/退货
	public function refuseDist($order_return_id,$data)
	{
		$return                  = $this->Order_ReturnModel->getOne($order_return_id);

		$rs_row                          = array();
		$edit_flag = $this->Order_ReturnModel->editReturn($order_return_id, $data);
		check_rs($edit_flag, $rs_row);

		if ($return['return_goods_return'])
		{
			//商家拒绝退款退货3
			$goods_data['goods_refund_status'] = Order_GoodsModel::REFUND_REF;
			$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
			check_rs($edit_flag, $rs_row);
		}
		else
		{
			$goods_data['goods_return_status'] = Order_GoodsModel::REFUND_REF;
			$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
			check_rs($edit_flag, $rs_row);
		}

	}

	//同意分销退款/退货
	public function agreeDist($order_return_id,$data)
	{
		$Order_StateModel        = new Order_StateModel();
		$return                  = $this->Order_ReturnModel->getOne($order_return_id);
		fb($return);

		//根据order_id查找订单信息
		$order_base = $this->Order_BaseModel->getOne($return['order_number']);

		$rs_row                          = array();

		$edit_flag = $this->Order_ReturnModel->editReturn($order_return_id, $data);
		check_rs($edit_flag, $rs_row);

		if ($return['return_goods_return'])
		{
			//商品退换情况为完成2
			$goods_data['goods_refund_status'] = Order_GoodsModel::REFUND_COM;
			$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
			check_rs($edit_flag, $rs_row);
		}
		else
		{
			$goods_data['goods_return_status'] = Order_GoodsModel::REFUND_COM;
			$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $goods_data);
			check_rs($edit_flag, $rs_row);
		}
		$ogoods_data = array();
		$ogoods_data['order_goods_returnnum'] = $return['order_goods_num'];
		$edit_flag                         = $this->Order_GoodsModel->editGoods($return['order_goods_id'], $ogoods_data,true);
		check_rs($edit_flag, $rs_row);

		$sum_data['order_refund_amount']         = $return['return_cash'];
		$sum_data['order_commission_return_fee'] = $return['return_commision_fee'];
		$edit_flag = $this->Order_BaseModel->editBase($return['order_number'], $sum_data, true);
		check_rs($edit_flag, $rs_row);

		//订单中所有商品数量
		$order_goods = $this->Order_GoodsModel->getByWhere(array('order_id'=>$return['order_number'],'order_goods_amount:>'=>0));
		$order_all_goods_num      = array_sum(array_column($order_goods, 'order_goods_num'));

		//查找该笔订单已经完成的退款，退货
		$order_return = $this->Order_ReturnModel->getByWhere(array(
																 'order_number' => $return['order_number'],
																 'return_state' => Order_ReturnModel::RETURN_PLAT_PASS
															 ));
		//订单已经退还的商品数量
		$order_return_num = array_sum(array_column($order_return, 'order_goods_num'));

		if($order_all_goods_num == $order_return_num && $order_base['order_status'] !== $Order_StateModel::ORDER_FINISH)
		{
			$order_edit_row = array();
			$order_edit_row['order_status'] = $Order_StateModel::ORDER_FINISH;

			$edit_flag2  = $this->Order_BaseModel->editBase($return['order_number'], $order_edit_row);
			check_rs($edit_flag2, $rs_row);
		}

		if($edit_flag)
		{
			$key      = Yf_Registry::get('shop_api_key');
			$url         = Yf_Registry::get('paycenter_api_url');
			$shop_app_id = Yf_Registry::get('shop_app_id');

			$formvars             = array();
			$formvars['app_id']        = $shop_app_id;
			$formvars['user_id']  = $return['buyer_user_id'];
			$formvars['user_account'] = $return['buyer_user_account'];
			$formvars['seller_id'] = $return['seller_user_id'];
			$formvars['seller_account'] = $return['seller_user_account'];
			$formvars['amount']   = $return['return_cash'];
			$formvars['return_commision_fee']   = $return['return_commision_fee'];
			$formvars['order_id'] = $return['order_number'];
			$formvars['goods_id'] = $return['order_goods_id'];
			$formvars['uorder_id'] = $order_base['payment_other_number'];
			$formvars['payment_id'] = $order_base['payment_id'];

			$rs   = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=refundBuyerTransfer&typ=json', $url), $formvars);
		}

		//如果订单金额全数退还需要将订单商品，支付中心的订单状态修改为订单完成(未发货)
		if($order_all_goods_num == $order_return_num && $order_base['order_status'] == Order_StateModel::ORDER_PAYED)
		{
			$goods_data['order_goods_status'] = $Order_StateModel::ORDER_FINISH;
			$order_goods_ids_row = $this->Order_GoodsModel->getByWhere(array('order_id'=>$return['order_number']));
			$order_goods_ids = current($order_goods_ids_row);
			fb('111');
			$ed_flag                         = $this->Order_GoodsModel->editGoods($order_goods_ids['order_goods_id'], $goods_data);
			check_rs($ed_flag, $rs_row);

			//将需要确认的订单号远程发送给Paycenter修改订单状态
			//远程修改paycenter中的订单状态
			$key      = Yf_Registry::get('shop_api_key');
			$url         = Yf_Registry::get('paycenter_api_url');
			$shop_app_id = Yf_Registry::get('shop_app_id');
			$formvars = array();

			$formvars['order_id']    = $return['order_number'];
			$formvars['app_id']        = $shop_app_id;
			$formvars['from_app_id'] = Yf_Registry::get('shop_app_id');

			$rs = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=confirmOrder&typ=json', $url), $formvars);

			if($rs['status'] == 250)
			{
				$rs_flag = false;
				check_rs($rs_flag,$rs_row);
			}
		}
	}
}

?>