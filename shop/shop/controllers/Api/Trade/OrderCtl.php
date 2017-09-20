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
class Api_Trade_OrderCtl extends Api_Controller
{
	
	public $Order_BaseModel = null;

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
		$this->Order_BaseModel = new Order_BaseModel();

		$this->tradeOrderModel = new Order_BaseModel();
		
	}

	/*
	 * 获取商品订单列表
	 * */
	public function getOrderList()
	{
		$page = request_int('page', 1);
		$rows = request_int('rows', 100);

		$order_row = array();
		$sidx      = request_string('sidx');
		$sord      = request_string('sord', 'asc');
		$action    = request_string('action');

		if ($sidx)
		{
			$order_row[$sidx] = $sord;
		}
		
		if (request_string('order_id'))
		{
			$cond_row['order_id:LIKE'] = request_string('order_id') . '%';
		}
		if (request_string('buyer_name'))
		{
			$cond_row['buyer_user_name:LIKE'] = request_string('buyer_name') . '%';
		}
		if (request_string('shop_name'))
		{
			$cond_row['shop_name:LIKE'] = request_string('shop_name') . '%';
		}
		if (request_string('payment_number'))
		{
			$cond_row['payment_number:LIKE'] = '%'.request_string('payment_number') . '%';
		}
		if (!empty($action) && $action == 'virtual')
		{
			$cond_row['order_is_virtual'] = Order_BaseModel::ORDER_IS_VIRTUAL;
		}
		if (request_string('payment_date_f'))
		{
			$cond_row['payment_time:>='] = request_string('payment_date_f');
		}
		if (request_string('payment_date_t'))
		{
			$cond_row['payment_time:<='] = request_string('payment_date_t');
		}
        //分站筛选
        $sub_site_id = request_int('sub_site_id');
        $sub_flag = true;
        if($sub_site_id > 0){
            //获取站点信息
            $Sub_SiteModel = new Sub_SiteModel();
            $sub_site_district_ids = $Sub_SiteModel->getDistrictChildId($sub_site_id);
            if(!$sub_site_district_ids){
                $sub_flag = false;
            }else{
                $cond_row['district_id:IN'] = $sub_site_district_ids;
            }
        }
        if($sub_flag == false){
            $status = 250;
			$msg    = __('分站信息获取失败');
            $this->data->addBody(-140, array(), $msg, $status);
        }else{
            $data = $this->Order_BaseModel->getPlatOrderList($cond_row, array(), $page, $rows);
            if ($data['records'] > 0)
            {
                $status = 200;
                $msg    = __('success');
            }
            else
            {
                $status = 250;
                $msg    = __('没有满足条件的结果哦');
            }
            $this->data->addBody(-140, $data, $msg, $status);
        }
		
	}

	/*
	 * 取消订单
	 * */
	public function cancelOrder()
	{
		$order_id = request_string('order_id');

		$data['order_status']          = Order_StateModel::ORDER_CANCEL;
		$data['order_cancel_identity'] = Order_BaseModel::CANCEL_USER_SYSTEM;

		$flag = $this->Order_BaseModel->editBase($order_id, $data);

		if ($flag != false)
		{
			$msg    = __('success');
			$status = 200;
		}
		else
		{
			$msg    = __('failure');
			$status = 250;
		}
		$this->data->addBody(-140, array(), $msg, $status);
	}

	/**
	 * 获取订单详细信息
	 */
	public function getOrderInfo()
	{
		$order_id = request_string('order_id');

		$data = $this->Order_BaseModel->getPhysicalInfoData(array('order_id' => $order_id));
		
		if ($data)
		{
			$msg    = __('success');
			$status = 200;
		}
		else
		{
			$msg    = __('failure');
			$status = 250;
		}

		$this->data->addBody(-140, $data, $msg, $status);
	}

	/**
	 * 收到货款
	 */
	public function receivePay()
	{
		$order_id                     = request_string('order_id');
		$data['payment_number']       = request_string('payment_number');
		$data['payment_time']         = request_string('payment_date');
		$data['payment_name']         = request_string('payment_name');
		$data['payment_other_number'] = request_string('payment_other_number');
		$data['order_status']         = Order_StateModel::ORDER_PAYED;


		$flag = $this->Order_BaseModel->editBase($order_id, $data);

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

		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function getPaymentNum()
	{
		$data['payment_number'] = $this->Order_BaseModel->createPaymentNum();

		$msg    = __('success');
		$status = 200;
		$this->data->addBody(-140, $data, $msg, $status);
	}

	//修改订单状态(数组支付成功)
	public function editOrderRowSatus()
	{
		$order_id = request_row('order_id');
		$uorder_id = request_string('uorder_id');

		//开启事物
		$this->tradeOrderModel->sql->startTransactionDb();

		if (is_array($order_id))
		{
			$order_id = array_filter($order_id);

			$order_id_str = implode(',',$order_id);

			foreach ($order_id as $key => $val)
			{
				$flag = $this->tradeOrderModel->editOrderStatusAferPay($val,$uorder_id);

				$order_base = $this->tradeOrderModel->getOne($val);
                $payment_name = $order_base['payment_name'];
				//如果存才采购单，改变采购单状态
				$sp_order = $this->tradeOrderModel->getByWhere(array('order_source_id'=>$val));
				if(!empty($sp_order)){
					foreach ($sp_order as $k => $v) {
						$this->tradeOrderModel->editOrderStatusAferPay($v['order_id']);

						//请求paycenter,扣除分销商的钱
						$key      = Yf_Registry::get('shop_api_key');
						$url         = Yf_Registry::get('paycenter_api_url');
						$shop_app_id = Yf_Registry::get('shop_app_id');
						$formvars = array();
						$formvars['app_id']					= $shop_app_id;
						$formvars['from_app_id'] 			 = $shop_app_id;
						$formvars['uorder']             = $v['payment_number'];
						$formvars['buyer_id']           = $v['buyer_user_id'];

						$rs = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=reduceDistMoney&typ=json',$url), $formvars);
					}
				}

				if ($flag && !$order_base['order_is_virtual'] && !$order_base['chain_id']) //2017-07-10加入判断：门店自提订单不需要通知商家发货
				{
					$message           = new MessageModel();
					$code              = 'place_your_order';
					$message_user_id   = $order_base['seller_user_id'];
					$message_user_name = $order_base['seller_user_name'];
					$shop_name         = $order_base['shop_name'];
					$message->sendMessage($code, $message_user_id, $message_user_name, $val, $shop_name, 1, 1);

				}

				$buyer_user_id = $order_base['buyer_user_id'];
				$buyer_user_name = $order_base['buyer_user_name'];
			}
		}
		else
		{
			$order_id_str = $order_id;

			$flag = $this->tradeOrderModel->editOrderStatusAferPay($order_id,$uorder_id);

			$order_base = $this->tradeOrderModel->getOne($order_id);
            $payment_name = $order_base['payment_name'];
            
			if ($flag && !$order_base['chain_id']) //2017-07-10加入判断：门店自提订单不需要通知商家发货
			{
				$message           = new MessageModel();
				$code              = 'place_your_order';
				$message_user_id   = $order_base['seller_user_id'];
				$message_user_name = $order_base['seller_user_name'];
				$shop_name         = $order_base['shop_name'];
				$message->sendMessage($code, $message_user_id, $message_user_name, $order_id_str, $shop_name, 1, 1);
			}

			$buyer_user_id = $order_base['buyer_user_id'];
			$buyer_user_name = $order_base['buyer_user_name'];

		}
        //将支付名称改为 白条支付
        if(request_string('payment_channel_code') === 'baitiao'){
            $payment_name = $payment_name ? $payment_name.'/白条支付' : '白条支付';
            $this->Order_BaseModel->editBase($order_id,array('payment_name'=>$payment_name));
        }


		if ($flag && $this->tradeOrderModel->sql->commitDb())
		{
			/**
			 *  加入统计中心
			 */
			$analytics_data = array();
			if(is_array($order_id)){
				$analytics_data['order_id'] = $order_id;
			}else{
				$analytics_data['order_id'] = array($order_id);
			}
			$analytics_data['status'] =  Order_StateModel::ORDER_PAYED;
			Yf_Plugin_Manager::getInstance()->trigger('analyticsUpdateOrderStatus',$analytics_data);
			/******************************************************************/
			
			$status = 200;
			$msg    = __('success');

			//付款成功提醒
			//$order_id
			$message = new MessageModel();
			$message->sendMessage('Payment reminder', $buyer_user_id, $buyer_user_name, $order_id = $order_id_str, $shop_name = NULL, 0, MessageModel::ORDER_MESSAGE);
		}
		else
		{
			$this->tradeOrderModel->sql->rollBackDb();
			$m      = $this->tradeOrderModel->msg->getMessages();
			$msg    = $m ? $m[0] : __('failure');
			$status = 250;
		}
		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);

	}

    //后台显示数据查询
    public function getEvaluateList()
    {
        $page = request_int('page');
        $rows = request_int('rows');
        $Goods_EvaluationModel = new Goods_EvaluationModel();

		$cond_row = array();

		$goods_name = request_string('goods_name');
		$shop_name  = request_string('shop_name');
		$member_name = request_string('member_name');
		$scores		= request_string('scores');
		$start_time = request_string('start_time');
		$end_time	= request_string('end_time');

		if($goods_name)
		{
			$cond_row['goods_name:LIKE'] ='%'.$goods_name.'%';
		}

		if($shop_name)
		{
			$cond_row['shop_name:LIKE'] ='%'.$shop_name.'%';
		}

		if($member_name)
		{
			$cond_row['member_name:LIKE'] ='%'.$member_name.'%';
		}

		if($scores)
		{
			$cond_row['scores'] = $scores;
		}

		if($start_time)
		{
			$cond_row['create_time:>='] = $start_time;
		}

		if($end_time)
		{
			$cond_row['create_time:<='] = $end_time;
		}

        $data = $Goods_EvaluationModel->listByWhere($cond_row, array(), $page, $rows);

        if($data)
        {
            $msg = __('success');
            $status = 200;
        }
        else
        {
            $msg = __('failure');
            $status = 250;
        }

        $this->data->addBody(-140,$data,$msg,$status);
    }

    public function removeEvaluate()
    {
        $id = request_int('id');
        $Goods_EvaluationModel = new Goods_EvaluationModel();
        $flag = $Goods_EvaluationModel->removeEvalution($id);

        if($flag)
        {
            $msg = __('success');
            $status = 200;
        }
        else
        {
            $msg = __('failure');
            $status = 250;
        }

        $this->data->addBody(-140, array(), $msg, $status);
    }

    public function getShopEvaluateList()
    {
        $page = request_int('page');
        $rows = request_int('rows');
        $Shop_EvaluationModel = new Shop_EvaluationModel();
        $Shop_BaseModel       = new Shop_BaseModel();
        $User_BaseModel       = new User_BaseModel();

		$cond_row = array();

		$evaluation_desccredit    = request_string('evaluation_desccredit');
		$evaluation_servicecredit = request_string('evaluation_servicecredit');
		$evaluation_deliverycredit = request_string('evaluation_deliverycredit');
		$start_time = request_string('start_time');
		$end_time   = request_string('end_time');

		if($evaluation_desccredit)
		{
			$cond_row['evaluation_desccredit'] = $evaluation_desccredit;
		}

		if($evaluation_servicecredit)
		{
			$cond_row['evaluation_servicecredit'] = $evaluation_servicecredit;
		}

		if($evaluation_deliverycredit)
		{
			$cond_row['evaluation_deliverycredit'] = $evaluation_deliverycredit;
		}

		if($start_time)
		{
			$cond_row['evaluation_create_time:>='] = $start_time;
		}

		if($end_time)
		{
			$cond_row['evaluation_create_time:<='] = $end_time;
		}

        $data = $Shop_EvaluationModel->listByWhere($cond_row , array(), $page, $rows);
        $items = $data['items'];
        unset($data['items']);
        if(!empty($items))
        {
            foreach($items as $key=>$value)
            {
                $shop_id = $value['shop_id'];
                $user_id = $value['user_id'];
                if($shop_id)
                {
                    $data_shop = $Shop_BaseModel->getOne($shop_id);
                    if($data_shop)
                        $items[$key]['shop_name'] = $data_shop['shop_name'];
                    else
                        $items[$key]['shop_name'] = '';
                }
                if($user_id)
                {
                    $data_user = $User_BaseModel->getOne($user_id);
                    if($data_user)
                        $items[$key]['user_name'] = $data_user['user_account'];
                    else
                        $items[$key]['user_name'] = '';
                }
            }
        }
        $data['items'] = $items;

        if($items)
        {
            $msg = __('success');
            $status = 200;
        }
        else
        {
            $msg = __('failure');
            $status = 250;
        }

        $this->data->addBody(-140,$data,$msg,$status);
    }

    public function removeShopEvaluate()
    {
        $id = request_int('id');
        $Shop_EvaluationModel = new Shop_EvaluationModel();
        $flag = $Shop_EvaluationModel->removeEvalution($id);

        if($flag)
        {
            $msg = __('success');
            $status = 200;
        }
        else
        {
            $msg = __('failure');
            $status = 250;
        }

        $this->data->addBody(-140, array(), $msg, $status);
    }


	public function CountAmount()
	{
		$order_id = request_string('id');
		$Order_BaseModel = new Order_BaseModel();
		$order_ids  = explode(',',$order_id);
		$data = $Order_BaseModel->getByWhere(array('order_id:in'=>$order_ids));
		$data = array_values($data);
		$money = 0;
		if(!empty($data))
		{
			foreach($data as $key=>$value)
			{
				$money+=$value['order_goods_amount'];
			}
		}
		$result = array();
		$result['money'] = $money;
		$this->data->addBody(-140, $result);
	}
    public function getListByOrderId(){
        $union_id = request_string('order_ids');
        $union_ids = explode(',', $union_id);
        if($union_ids){
            $order_model = new Order_BaseModel();
            $cond_row = array(
                'order_id:IN'=>$union_ids
            );
            $order_row = array('order_create_time'=>'desc');
            $order_list = $order_model->listByWhere($cond_row, $order_row);
            if(isset($order_list['items']) && $order_list){
                $this->data->addBody(-140, $order_list['items']);
            }else{
                $this->data->addBody(-140, array(),__('failure'),250);
            }
            
        }else{
            $this->data->addBody(-140, array(),__('failure'),250);
        }
        
    }


	public function editOrderSubPay()
	{
		$order_id = request_row('order_id');
		$order_sub_user = request_int('order_sub_user');

		$Order_BaseModel = new Order_BaseModel();
		$edit_row = array();
		$edit_row['order_sub_pay'] = Order_StateModel::SUB_USER_PAY;
		$edit_row['order_sub_user'] = $order_sub_user;

		$flag = $Order_BaseModel->editBase($order_id,$edit_row);

		if($flag)
		{
			$msg = __('success');
			$status = 200;
		}
		else
		{
			$msg = __('failure');
			$status = 250;
		}

		$this->data->addBody(-140, array(), $msg, $status);
	}

	//根据订单号获取订单商品
	public function getGoodsByOrderId()
	{
		$order_id = request_string('order_id');

		$Order_GoodsModel = new Order_GoodsModel();
		$order_goods = $Order_GoodsModel->getByWhere(array('order_id'=>$order_id));

		$this->data->addBody(-140, $order_goods);

	}

}

?>