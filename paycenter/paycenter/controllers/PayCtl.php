<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}
/**
 * 支付入口
 * @author     Cbin
 */
class PayCtl extends Controller
{
	//支付分发在PaymentWay目录中
	public function __call($name,$arg){
		$cls =  "PaymentWay_".ucfirst($name); 
		$cls = new $cls; 
		$met = $name; 
		$cls->$met();
		exit;
	}
	/**
	 *
	 * @param  string $ctl 控制器目录
	 * @param  string $met 控制器方法
	 * @param  string $typ 返回数据类型
	 * @access public
	 */
	public function __construct(&$ctl, $met, $typ)
	{
		parent::__construct($ctl, $met, $typ);
	}

	/**
	 * 微信二维码支付
	 * 构造 url
	 * @param product_id产品ID
	 */
	public function structWXurl()
	{
		// 第一步 参数过滤
		$product_id  = trim($_REQUEST['product_id']);
		if (!$product_id || is_int($product_id))
		{
			$this->data->setError('参数错误');
			$this->data->printJSON();
			die;
		}

		// 第二步  调用url生成类
		$pw = new Payment_WxQrcodeModel();
		$url = $pw->url($product_id);
		include $this->view->getView();
	}

	/**
	 * 微信二维码支付
	 * 生成二维码
	 */
	public function structWXcode()
	{
		require_once MOD_PATH.'/Payment/phpqrcode/phpqrcode.php';
		$url = urldecode($_REQUEST["data"]);
		QRcode::png($url);
	}

	/**
	 * 微信二维码支付
	 * 微信回调
	 */
	public function WXnotify()
	{
		// 确定支付
		$pw = new Payment_WxQrcodeModel();
		$pw->notify();

		// 支付金额写入数据库
		// code
	}

	/**
	 * 使用余额支付
	 *
	 */
	public function money()
	{
		$trade_id = request_string('trade_id');

		//如果订单号为合并订单号，则获取合并订单号的信息
		$Union_OrderModel = new Union_OrderModel();

		//开启事物
		$Consume_DepositModel = new Consume_DepositModel();

		$uorder = $Union_OrderModel->getOne($trade_id);
		$data = array();

		//判断订单状态是否为等待付款状态
		if($uorder['order_state_id'] == Order_StateModel::ORDER_WAIT_PAY)
		{
			$pay_flag = false;
			$pay_user_id = 0;
			//判断当前用户是否是下单者，并且订单状态是否是待付款状态
			if($uorder['buyer_id'] == Perm::$userId)
			{
				$pay_flag = true;
				$pay_user_id = $uorder['buyer_id'];
			}
			else
			{
				//判断当前用户是否是下单者的主管账户
				$key      = Yf_Registry::get('shop_api_key');
				$url         = Yf_Registry::get('shop_api_url');
				$shop_app_id = Yf_Registry::get('shop_app_id');
				$formvars = array();

				$formvars['app_id']					= $shop_app_id;
				$formvars['user_id']     = Perm::$userId;
				$formvars['sub_user_id'] = $uorder['buyer_id'];

				$sub_user = get_url_with_encrypt($key, sprintf('%s?ctl=Api_User_Info&met=checkSubUser&typ=json',$url), $formvars);
				if(!empty($sub_user['data']) && $sub_user['status'] == 200)
				{
					$pay_flag = true;
					$pay_user_id = Perm::$userId;
				}
			}

			if($pay_flag)
			{
				//修改订单表中的各种状态
				$flag = $Consume_DepositModel->notifyShop($trade_id,$pay_user_id);
				if ($flag['status'] == 200)
				{
					//查找回调地址
					$User_AppModel = new User_AppModel();
					$user_app = $User_AppModel->getOne($uorder['app_id']);
					$return_app_url = $user_app['app_url'];

					$data['return_app_url'] = $return_app_url;

					$msg    = 'success';
					$status = 200;
				}
				else
				{
					$msg    = _('failure');
					$status = 250;
				}
			}
			else
			{
				$msg    = _('failure');
				$status = 250;
			}
		}
		else
		{
			$msg    = _('failure');
			$status = 250;
		}

		$this->data->addBody(-140, $data, $msg, $status);
	}

	//主管账号待支付
	public function subpay()
	{
		$trade_id = request_string('trade_id');

		//如果订单号为合并订单号，则获取合并订单号的信息
		$Union_OrderModel = new Union_OrderModel();

		$uorder = $Union_OrderModel->getOne($trade_id);
		$inorder = $uorder['inorder'];

		$uorder_id = $trade_id;
		$order_id = explode(",",$inorder);
		array_filter($order_id);
		$data = array();

		$flag = false;
		//判断当前用户是否是下单者，并且订单状态是否是待付款状态
		if($uorder['buyer_id'] == Perm::$userId && $uorder['order_state_id'] == Order_StateModel::ORDER_WAIT_PAY)
		{
			$key      = Yf_Registry::get('shop_api_key');
			$url         = Yf_Registry::get('shop_api_url');
			$shop_app_id = Yf_Registry::get('shop_app_id');
			$formvars = array();

			$formvars['app_id']					= $shop_app_id;
			$formvars['sub_user_id']     = Perm::$userId;

			$sub_user = get_url_with_encrypt($key, sprintf('%s?ctl=Api_User_Info&met=getSubUser&typ=json',$url), $formvars);

			$rs_row = array();
			//获取当前用户的主管账号
			if($sub_user['status'] == 200 && $sub_user['data']['count'] > 0)
			{
				//将该笔订单的交易明细表中的支付者修改为主管账号
				$Consume_RecordModel = new Consume_RecordModel();
				$cond_row = array();
				$cond_row['order_id:IN'] = $order_id;
				$cond_row['user_type'] = 2;
				$consume = $Consume_RecordModel->getByWhere($cond_row);
				$consume_id = array_values(array_column($consume,'consume_record_id'));

				$edit_row = array();
				$edit_row['user_id'] = $sub_user['data']['sub']['user_id'];
				$edit_row['user_nickname'] = $sub_user['data']['sub']['user_account'];
				fb($edit_row);
				$edit_flag = $Consume_RecordModel->editRecord($consume_id,$edit_row);
				check_rs($edit_flag,$rs_row);
                //修改这笔订单的支付人
                $order_edit_row = array();
                $order_edit_row['pay_user_id'] = $sub_user['data']['sub']['user_id'];
                $Consume_TradeModel = new Consume_TradeModel();
                $flag = $Consume_TradeModel->editTrade($order_id,$order_edit_row);
                check_rs($flag, $rs_row);
            
				if(is_ok($rs_row))
				{
					$Consume_TradeModel = new Consume_TradeModel();
					$consume_record = $Consume_TradeModel->getOne($order_id);
					$app_id = $consume_record['app_id'];

					$User_AppModel = new User_AppModel();
					$app_row = $User_AppModel->getOne($app_id);

					$return_app_url = $app_row['app_url'];

					$data['return_app_url'] = $return_app_url;

					$key = $app_row['app_key'];
					$url = $app_row['app_url'];
					$shop_app_id = $app_id;

					$formvars = array();
					$formvars = $_POST;
					$formvars['app_id'] = $shop_app_id;
					$formvars['order_id'] = $order_id;
					$formvars['order_sub_user'] = $sub_user['data']['sub']['user_id'];

					fb($formvars);

					//远程修改订单表中的order_sub_pay = 1:主管账号支付
					$rs = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Trade_Order&met=editOrderSubPay&typ=json', $url), $formvars);

                    if($rs['status'] == 200)
                    {
                        $flag = true;
                    }
				}
			}
		}

		if($flag)
		{
			$msg    = _('success');
			$status = 200;
		}else
		{
			$msg    = _('failure');
			$status = 250;
		}

		$this->data->addBody(-140, $data, $msg, $status);
	}


	/**
	 * 使用支付宝支付
	 *
	 */
	public function alipay()
	{
		$trade_id = request_string('trade_id');

		//如果订单号为合并订单号，则获取合并订单号的信息
		$Union_OrderModel = new Union_OrderModel();
		$trade_row        = $Union_OrderModel->getOne($trade_id);

		//判断订单状态是否为等待付款状态
		if($trade_row['order_state_id'] == Order_StateModel::ORDER_WAIT_PAY)
		{
			$pay_flag = false;
			$pay_user_id = 0;
			//判断当前用户是否是下单者，并且订单状态是否是待付款状态
			if($trade_row['buyer_id'] == Perm::$userId)
			{
				$pay_flag = true;
				$pay_user_id = $trade_row['buyer_id'];
			}
			else
			{
				//判断当前用户是否是下单者的主管账户
				$key      = Yf_Registry::get('shop_api_key');
				$url         = Yf_Registry::get('shop_api_url');
				$shop_app_id = Yf_Registry::get('shop_app_id');
				$formvars = array();

				$formvars['app_id']					= $shop_app_id;
				$formvars['user_id']     = Perm::$userId;
				$formvars['sub_user_id'] = $trade_row['buyer_id'];

				$sub_user = get_url_with_encrypt($key, sprintf('%s?ctl=Api_User_Info&met=checkSubUser&typ=json',$url), $formvars);
				if(!empty($sub_user['data']) && $sub_user['status'] == 200)
				{
					$pay_flag = true;
					$pay_user_id = Perm::$userId;
				}
			}

			if($pay_flag)
			{
				if ($trade_row)
				{
					$Payment = PaymentModel::create('alipay');
					$Payment->pay($trade_row);
				}
				else
				{
					echo"<script>alert('支付失败,请重新支付');history.go(-1);</script>";
				}
			}
			else
			{
				echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
			}
		}
		else
		{
			echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
		}

	}




	
	
	/**
	 * 使用银联在线支付
	 *
	 */
	public function unionpay()
	{
		$trade_id = request_string('trade_id');

		//如果订单号为合并订单号，则获取合并订单号的信息
		$Union_OrderModel = new Union_OrderModel();
		$trade_row        = $Union_OrderModel->getOne($trade_id);

		//判断订单状态是否为等待付款状态
		if($trade_row['order_state_id'] == Order_StateModel::ORDER_WAIT_PAY)
		{
			$pay_flag = false;
			$pay_user_id = 0;
			//判断当前用户是否是下单者，并且订单状态是否是待付款状态
			if($trade_row['buyer_id'] == Perm::$userId)
			{
				$pay_flag = true;
				$pay_user_id = $trade_row['buyer_id'];
			}
			else
			{
				//判断当前用户是否是下单者的主管账户
				$key      = Yf_Registry::get('shop_api_key');
				$url         = Yf_Registry::get('shop_api_url');
				$shop_app_id = Yf_Registry::get('shop_app_id');
				$formvars = array();

				$formvars['app_id']					= $shop_app_id;
				$formvars['user_id']     = Perm::$userId;
				$formvars['sub_user_id'] = $trade_row['buyer_id'];

				$sub_user = get_url_with_encrypt($key, sprintf('%s?ctl=Api_User_Info&met=checkSubUser&typ=json',$url), $formvars);
				if(!empty($sub_user['data']) && $sub_user['status'] == 200)
				{
					$pay_flag = true;
					$pay_user_id = Perm::$userId;
				}
			}

			if($pay_flag)
			{
				if ($trade_row)
				{
					$Payment = PaymentModel::create('unionpay');
					$Payment->pay($trade_row);
				}
				else
				{
					echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
				}
			}
			else
			{
				echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
			}
		}
		else
		{
			echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
		}

	}

	/**
	 * 使用微信支付
	 *
	 */
	public function wx_native()
	{
		$trade_id = request_string('trade_id');

		//如果订单号为合并订单号，则获取合并订单号的信息
		$Union_OrderModel = new Union_OrderModel();
		$trade_row        = $Union_OrderModel->getOne($trade_id);

		//判断订单状态是否为等待付款状态
		if($trade_row['order_state_id'] == Order_StateModel::ORDER_WAIT_PAY)
		{
			$pay_flag = false;
			$pay_user_id = 0;
			//判断当前用户是否是下单者，并且订单状态是否是待付款状态
			if($trade_row['buyer_id'] == Perm::$userId)
			{
				$pay_flag = true;
				$pay_user_id = $trade_row['buyer_id'];
			}
			else
			{
				//判断当前用户是否是下单者的主管账户
				$key      = Yf_Registry::get('shop_api_key');
				$url         = Yf_Registry::get('shop_api_url');
				$shop_app_id = Yf_Registry::get('shop_app_id');
				$formvars = array();

				$formvars['app_id']					= $shop_app_id;
				$formvars['user_id']     = Perm::$userId;
				$formvars['sub_user_id'] = $trade_row['buyer_id'];

				$sub_user = get_url_with_encrypt($key, sprintf('%s?ctl=Api_User_Info&met=checkSubUser&typ=json',$url), $formvars);
				if(!empty($sub_user['data']) && $sub_user['status'] == 200)
				{
					$pay_flag = true;
					$pay_user_id = Perm::$userId;
				}
			}

			if($pay_flag)
			{
				if ($trade_row)
				{
					$Payment = PaymentModel::create('wx_native');
					$Payment->pay($trade_row);
				}
				else
				{
					echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
				}
			}
			else
			{
				echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
			}
		}
		else
		{
			echo"<script>alert('支付失败，请重新支付');history.go(-1);</script>";
		}

	}

	/**
	 * @param $uorder_data
	 * @return boolean
	 * 检查订单是否为付款状态
	 */
	private function checkOrderStatus ($uorder_data)
	{
		if ($uorder_data['order_state_id'] == Order_StateModel::ORDER_WAIT_PAY) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * 暂时手机端无联合付款，手机端支付为全款支付
	 * 手机端支付->修改pay_union_order状态
	 * union_online_pay_amount = trade_payment_amount
	 * union_cards_pay_amount = union_cards_return_amount = union_money_pay_amount = union_money_return_amount = 0;
	 */

	/**
	 * PHP服务端SDK生成APP支付订单信息 （支付宝）
	 */
	public function createAliOrder()
	{
		$uorder_id = request_string('uorder_id');

		//检查参数
		if (empty($uorder_id)) {
			return $this->data->addBody(-140, [], _('无效访问参数'), 250);
		}

		$unionOrderModel = new Union_OrderModel();
		$uorder_data = $unionOrderModel->getOne($uorder_id);

		$unionOrderModel->editUnionOrder($uorder_id, ['union_online_pay_amount'=> $uorder_data['trade_payment_amount'],
														'union_cards_pay_amount'=> 0,
														'union_cards_return_amount'=> 0,
														'union_money_pay_amount'=> 0,
														'union_money_return_amount'=> 0
													]);

		//检查订单是否为付款状态
		if (!$this->checkOrderStatus($uorder_data)) {
			return $this->data->addBody(-140, [], _('订单状态不为待付款状态'), 250);
		}

		require_once './libraries/Api/alipayMobile/AopSdk.php'; //init SDK

		$aop = new AopClient;
		//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
		$request = new AlipayTradeAppPayRequest();
		//SDK已经封装掉了公共参数，这里只需要传入业务参数

		$bizcontent = <<<EOT
{
					"body":"$uorder_data[trade_title]",
					"subject": "App支付",
					"out_trade_no": "$uorder_data[union_order_id]",
					"timeout_express": "30m",
					"total_amount": "$uorder_data[trade_payment_amount]",
					"product_code": "QUICK_MSECURITY_PAY"
				}
EOT;

		$request->setNotifyUrl(Yf_Registry::get('base_url') . "/paycenter/api/payment/alipay/notify_url.php"); //商户外网可以访问的异步地址
		$request->setBizContent($bizcontent);
		//这里和普通的接口调用不同，使用的是sdkExecute
		$response = $aop->sdkExecute($request);
		$this->data->addBody(-140, ['orderString'=> $response], 'success', 200);
	}

	/**
	 * 微信统一下单，返回app （生成预付订单）
	 */
	public function createWXOrder()
	{
		$uorder_id = request_string('uorder_id');
		if (empty($uorder_id)) {
			return $this->data->addBody(-140, [], _('无效访问参数'), 250);
		}

		$unionOrderModel = new Union_OrderModel();

		//恢复ConsumeTrade表金额记录，之前数据可能有误
		$uorder_data = $unionOrderModel->getOne($uorder_id);

		$urow = $unionOrderModel->getByWhere(array('inorder'=>$uorder_data['inorder']));
		$uorder_id_row = array_column($urow,'union_order_id');

		//订单支付的总金额
		$payment_amount = $uorder_data['trade_payment_amount'];

		$edit_union_order_row = ['union_online_pay_amount'=> $payment_amount,
			'union_cards_pay_amount'=> 0,
			'union_money_pay_amount'=> 0
		];

		$flag = $unionOrderModel->editUnionOrder($uorder_id_row, $edit_union_order_row);

		fb($flag);

		if ($flag === false) {
			return $this->data->addBody(-140, [], _('交易订单记录初始化失败'), 250);
		}

		//单据详情
		$order_row = array_merge(reset($urow), $edit_union_order_row);

		fb($order_row);
		$payment_model = PaymentModel::create('wx_native');
		$result = $payment_model->pay($order_row, true);

		$this->data->addBody(-140, ['orderString'=> $result, 'APPID'=> APPID_DEF, 'MCHID'=> MCHID_DEF], 'success', 200);
	}
}