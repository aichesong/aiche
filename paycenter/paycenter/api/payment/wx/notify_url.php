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

$Payment_WxNativeModel = PaymentModel::create('wx_native');
$verify_result          = $Payment_WxNativeModel->verifyNotify();

Yf_Log::log('$verify_result=' . $verify_result, Yf_Log::INFO, 'pay_wxnative_notify');

//计算得出通知验证结果
if ($verify_result)
{
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	$notify_row = $Payment_WxNativeModel->getNotifyData();
	
	if ($notify_row)
	{
		//插入充值记录
		$Consume_DepositModel = new Consume_DepositModel();
		//$rs = $Consume_DepositModel->processDeposit($notify_row);
		
		if (true)
		{
			//查找此支付单的交易类型
			$trade_type = Trade_TypeModel::$trade_type_row[$notify_row['trade_type_id']];

			fb($trade_type);
			//购物
			if($trade_type == 'shopping')
			{
				//处理一步回调-通知商城更新订单状态
				//修改订单表中的各种状态
				$Consume_DepositModel = new Consume_DepositModel();
				$rs                 = $Consume_DepositModel->notifyShop($notify_row['order_id'],$notify_row['buyer_id']);
			}

			if($trade_type == 'deposit')
			{
				//修改充值表的状态
				$Consume_DepositModel = new Consume_DepositModel();
				$rs = $Consume_DepositModel->notifyDeposit($notify_row['order_id'],$notify_row['buyer_id'],$notify_row['payment_channel_id']);
			}


			
			echo "SUCCESS";        //请不要修改或删除
			Yf_Log::log('Process-SUCCESS', Yf_Log::INFO, 'pay_wxnative_notify');
		}
		else
		{
			echo "FAIL";
			Yf_Log::log('Process-FAIL', Yf_Log::ERROR, 'pay_wxnative_notify_error');
			Yf_Log::log('Process-FAIL', Yf_Log::ERROR, 'pay_wxnative_notify');
		}
	}
	else
	{
		echo "FAIL";
		Yf_Log::log('Process-FAIL', Yf_Log::ERROR, 'pay_wxnative_notify_error');
		Yf_Log::log('Process-FAIL', Yf_Log::ERROR, 'pay_wxnative_notify');
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else
{
	//验证失败
	echo "FAIL";
	Yf_Log::log($error_msg, Yf_Log::ERROR, 'pay_wxnative_notify_error');
	Yf_Log::log($error_msg, Yf_Log::ERROR, 'pay_wxnative_notify');

}
?>