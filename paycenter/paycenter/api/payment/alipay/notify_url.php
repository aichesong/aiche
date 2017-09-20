<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
require_once '../../../configs/config.ini.php';

Yf_Log::log("r=" . json_encode($_REQUEST), Yf_Log::INFO, 'pay_alipay_notify');
Yf_Log::log("p=" . json_encode($_POST), Yf_Log::INFO, 'pay_alipay_notify');

$mobile_config = require '../../../data/api/alipay/alipayMobileConfig.php';

//获取手机端app_id,如果为手机端则采用手机端方法验证签名正确性
if ($mobile_config['appId'] == $_POST['app_id']) {
	require_once '../../../../libraries/Api/alipayMobile/AopSdk.php'; //init SDK
	$aop = new AopClient; 
	$verify_result = $aop->rsaCheckV1($_POST, NULL, "RSA2");
	spl_autoload_register('__autoload'); //ali SDK覆盖系统__autoload方法
} else {
	$Payment_AlipayWapModel = PaymentModel::create('alipay');
	$verify_result          = $Payment_AlipayWapModel->verifyNotify();
}

Yf_Log::log('$verify_result=' . $verify_result, Yf_Log::INFO, 'pay_alipay_notify');

//计算得出通知验证结果
if ($verify_result)
{
	//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代


	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	if ($mobile_config['appId'] == $_POST['app_id']) {
		$notify_param = $_POST;

		Yf_Log::log(var_export($notify_param,true), Yf_Log::INFO, 'pay_alipay_notify_001_notify_param');

		//插入充值记录, 如果同步数据没有,从订单数据中读取过来
		$notify_row = array();

		$notify_row['order_id'] = $notify_param['out_trade_no'];
		$notify_row['deposit_trade_no'] = $notify_param['trade_no'];
		$notify_row['deposit_subject']      = $notify_param['subject'];
		$notify_row['deposit_body']          = isset($notify_param['body']) ? $notify_param['body'] : '';
		//$notify_row['deposit_buyer_email']  = $notify_param['buyer_email'];
		$notify_row['deposit_gmt_create']  = isset($notify_param['gmt_create']) ? $notify_param['gmt_create'] : '0000-00-00 00:00:00';
		$notify_row['deposit_notify_type']  = $notify_param['notify_type'];
		$notify_row['deposit_quantity']  = isset($notify_param['quantity']) ? $notify_param['quantity'] : '0';
		$notify_row['deposit_notify_time']  = $notify_param['notify_time'];
		$notify_row['deposit_seller_id']  = $notify_param['seller_id'];
		$notify_row['deposit_trade_status']  = $notify_param['trade_status'];
		$notify_row['deposit_is_total_fee_adjust']  = isset($notify_param['is_total_fee_adjust']) ? $notify_param['is_total_fee_adjust'] : 0;
		$notify_row['deposit_total_fee']  = $notify_param['total_fee']?:$notify_param['total_amount'];
		$notify_row['deposit_gmt_payment']  = isset($notify_param['gmt_payment']) ? $notify_param['gmt_payment'] : '0000-00-00 00:00:00';
		//$notify_row['deposit_seller_email']  = $notify_param['seller_email'];
		$notify_row['deposit_gmt_close']  = isset($notify_param['gmt_close']) ? $notify_param['gmt_close'] : '0000-00-00 00:00:00';
		$notify_row['deposit_price']  =     isset($notify_param['price']) ? $notify_param['price'] : '0';
		$notify_row['deposit_buyer_id']  = $notify_param['buyer_id'];
		$notify_row['deposit_notify_id']  = $notify_param['notify_id'];
		$notify_row['deposit_use_coupon']  = isset($notify_param['use_coupon']) ? $notify_param['use_coupon'] : '';
		$notify_row['deposit_payment_type'] = $notify_param['payment_type']?:1;

		$notify_row['deposit_extra_param']     = isset($notify_param['extra_param']) ? $notify_param['extra_param'] : '';
		$notify_row['deposit_service']     = isset($notify_param['exterface']) ? $notify_param['exterface'] : '';
		$notify_row['deposit_sign_type']    = $_REQUEST['sign_type'];
		$notify_row['deposit_sign']         = $_REQUEST['sign'];
		$notify_row['payment_channel_id']   = 1;


	 


		 
	} else {
		$notify_row = $Payment_AlipayWapModel->getNotifyData();
	}


	Yf_Log::log(var_export($notify_row,true), Yf_Log::INFO, '__notify_row_01');


	if ($notify_row)
	{
		Yf_Log::log($Consume_TradeModel, Yf_Log::INFO, '__notify_02');

		if($Payment_AlipayWapModel){
				$Consume_TradeModel = new Consume_TradeModel();
				$notify_row = $Payment_AlipayWapModel->getReturnData($Consume_TradeModel);
		} 
		

		Yf_Log::log(var_export($notify_row,true), Yf_Log::INFO, '__notify_03');

		//查找此支付单的交易类型
		$Union_OrderModel = new Union_OrderModel();
		$data = $Union_OrderModel->getOne($notify_row['order_id']);

		Yf_Log::log(var_export($data,true), Yf_Log::INFO, '__notify_04');


		$trade_type = Trade_TypeModel::$trade_type_row[$data['trade_type_id']];


		Yf_Log::log($trade_type, Yf_Log::INFO, '__notify_trade_type');

		fb($trade_type);
		//购物
		if($trade_type == 'shopping')
		{
			//修改订单表中的各种状态
			$Consume_DepositModel = new Consume_DepositModel();
			$rs                 = $Consume_DepositModel->notifyShop($notify_row['order_id'],$notify_row['buyer_id']);
		}

		if($trade_type == 'deposit')
		{
			Yf_Log::log(var_export($notify_row,true), Yf_Log::INFO, '__deposit_noti');
			//修改充值表的状态
			$Consume_DepositModel = new Consume_DepositModel();
			$rs = $Consume_DepositModel->notifyDeposit($notify_row['order_id'],$notify_row['buyer_id'],$notify_row['payment_channel_id']);
		}

		if ($rs)
		{
			//重定向浏览器
			if($trade_type == 'shopping')
			{
				$app_id = $data['app_id'];

				//查找回调地址
				$User_AppModel = new User_AppModel();
				$user_app = $User_AppModel->getOne($app_id);
				$return_app_url = $user_app['app_url'];
			}

			if($trade_type == 'deposit')
			{
				$return_app_url = Yf_Registry::get('paycenter_api_url')."?ctl=Info&met=index";
			}
			//echo $return_app_url;

			//header("Location: " .$return_app_url);
			//确保重定向后，后续代码不会被执行
			echo "success";
		}
		else
		{
			echo "fail";
		}

		//插入充值记录
		/*$Consume_DepositModel = new Consume_DepositModel();
		//$rs = $Consume_DepositModel->processDeposit($notify_row);

		fb($notify_row);
		if (true)
		{
			//处理一步回调-通知商城更新订单状态
			$Consume_DepositModel->notifyShop($notify_row['order_id']);

			echo "success";        //请不要修改或删除
		}
		else
		{
			echo "fail";
		}*/

		//封装, return $rs


		//$trade_row
	}
	else
	{
		echo "fail";
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else
{
	//验证失败
	echo "fail";
	Yf_Log::log($error_msg, Yf_Log::ERROR, 'pay_alipay_notify_error');
	Yf_Log::log($error_msg, Yf_Log::ERROR, 'pay_alipay_notify');
	exit($error_msg);

	//调试用，写文本函数记录程序运行情况是否正常
	//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>