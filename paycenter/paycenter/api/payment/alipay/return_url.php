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

Yf_Log::log("r=" . json_encode($_REQUEST), Yf_Log::INFO, 'pay_alipay_return');
Yf_Log::log("g=" . json_encode($_GET), Yf_Log::INFO, 'pay_alipay_return');
Yf_Log::log("p=" . json_encode($_POST), Yf_Log::INFO, 'pay_alipay_return');

$Payment_AlipayWapModel = PaymentModel::create('alipay');
$verify_result          = $Payment_AlipayWapModel->verifyReturn();

Yf_Log::log('$verify_result=' . $verify_result, Yf_Log::INFO, 'pay_alipay_return');

//修正支付宝Android Webview下和浏览器下urlencode不同问题。
if (!$verify_result)
{
    $_GET['notify_id'] = urlencode($_GET['notify_id']);
    $verify_result          = $Payment_AlipayWapModel->verifyReturn();
}


//计算得出通知验证结果
if ($verify_result)
{
	//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代


	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

	//解密（如果是RSA签名需要解密，如果是MD5签名则下面一行清注释掉）
	//$notify_data = $alipayNotify->decrypt($_POST['notify_data']);
	$notify_data = $_GET;

	//交易状态
	if (isset($_GET['trade_status']))
	{
		if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS')
		{
			//交易目前所处的状态。成功状态的值只有两个：
			//TRADE_FINISHED（普通即时到账的交易成功状态）；
			//TRADE_SUCCESS（开通了高级即时到账或机票分销产品后的交易成功状态）
			//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序


			$Consume_TradeModel = new Consume_TradeModel();
			$notify_row = $Payment_AlipayWapModel->getReturnData($Consume_TradeModel);

			//查找此支付单的交易类型
			$Union_OrderModel = new Union_OrderModel();
			$data = $Union_OrderModel->getOne($notify_row['order_id']);

			$trade_type = Trade_TypeModel::$trade_type_row[$data['trade_type_id']];

			//购物
			if($trade_type == 'shopping')
			{
				//修改订单表中的各种状态
				$Consume_DepositModel = new Consume_DepositModel();
				$rs                 = $Consume_DepositModel->notifyShop($notify_row['order_id'],$notify_row['buyer_id']);
			}

			if($trade_type == 'deposit')
			{
				Yf_Log::log(var_export($notify_row,true), Yf_Log::INFO, '__deposit');

				//修改充值表的状态
				$Consume_DepositModel = new Consume_DepositModel();
				$rs = $Consume_DepositModel->notifyDeposit($notify_row['order_id'],$notify_row['buyer_id'],$notify_row['payment_channel_id']);
			}


			//重定向浏览器
			if($trade_type == 'shopping')
			{
				$app_id = $data['app_id'];

				//查找回调地址
				$User_AppModel = new User_AppModel();
				$user_app = $User_AppModel->getOne($app_id);

				$return_app_url = $user_app['app_url'].'?ctl=Buyer_Order&met=physical';

			}

			if($trade_type == 'deposit')
			{
				$return_app_url = Yf_Registry::get('paycenter_api_url')."?ctl=Info&met=index";
			}

			header("Location: " .$return_app_url);
			//确保重定向后，后续代码不会被执行
			exit;

		}
		else
		{
			echo "fails";
			Yf_Log::log('trade_status 失败:' . $_GET['trade_status'], Yf_Log::ERROR, 'pay_alipay_return_error');
			Yf_Log::log('trade_status 失败:' . $_GET['trade_status'], Yf_Log::ERROR, 'pay_alipay_return');
		}
	}
	else
	{
		//验证失败
		echo "failss";
		Yf_Log::log('trade_status 失败', Yf_Log::ERROR, 'pay_alipay_return_error');
		Yf_Log::log('trade_status 失败', Yf_Log::ERROR, 'pay_alipay_return');
	}
}

else
{
	//验证失败
	echo "failsss";
	Yf_Log::log('签名验证失败', Yf_Log::ERROR, 'pay_alipay_return_error');
	Yf_Log::log('签名验证失败', Yf_Log::ERROR, 'pay_alipay_return');
	//调试用，写文本函数记录程序运行情况是否正常
	//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>