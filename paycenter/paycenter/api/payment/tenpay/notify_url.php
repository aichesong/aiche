<?php

//---------------------------------------------------------
//�Ƹ�ͨ��ʱ����֧����̨�ص�ʾ�����̻����մ��ĵ����п�������
//---------------------------------------------------------
require_once '../../../configs/config.ini.php';

include_once LIB_PATH . '/Api/tenpay/lib/classes/ResponseHandler.class.php';
include_once LIB_PATH . '/Api/tenpay/lib/classes/RequestHandler.class.php';
include_once LIB_PATH . '/Api/tenpay/lib/classes/client/ClientResponseHandler.class.php';
include_once LIB_PATH . '/Api/tenpay/lib/classes/client/TenpayHttpClient.class.php';
include_once LIB_PATH . '/Api/tenpay/lib/classes/function.php';


log_result("�����̨�ص�ҳ��");
Yf_Log::log("r=" . json_encode($_REQUEST), Yf_Log::INFO, 'pay_tenpay_notify');
Yf_Log::log("p=" . json_encode($_POST), Yf_Log::INFO, 'pay_tenpay_notify');
Yf_Log::log("g=" . json_encode($_GET), Yf_Log::INFO, 'pay_tenpay_notify');


$Payment_TenpayWapModel = PaymentModel::create('tenpay');
$verify_result          = $Payment_TenpayWapModel->verifyNotify();

//����ó�֪ͨ��֤���
if ($verify_result)
{
	log_result("��ʱ���ʺ�̨�ص��ɹ�");
	//�������������ҵ���߼�����д�������´�������ο�������
	//�����ֵ��¼
	$Consume_DepositModel = new Consume_DepositModel();
	$rs = $Consume_DepositModel->processDeposit($verify_result);

	if ($rs)
	{
		//����һ���ص�-֪ͨ�̳Ǹ��¶���״̬
		$Consume_DepositModel->notifyShop($verify_result['order_id']);

		echo "SUCCESS";        //�벻Ҫ�޸Ļ�ɾ��
		Yf_Log::log('Process-SUCCESS', Yf_Log::INFO, 'pay_tenpay_notify');
	}
	else
	{
		echo "FAIL";
		Yf_Log::log('Process-FAIL', Yf_Log::ERROR, 'pay_tenpay_notify_error');
		Yf_Log::log('Process-FAIL', Yf_Log::ERROR, 'pay_tenpay_notify');
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else
{
	log_result("��ʱ���ʺ�̨�ص�ʧ��");
	//��֤ʧ��
	echo "FAIL";
	Yf_Log::log($error_msg, Yf_Log::ERROR, 'pay_tenpay_notify_error');
	Yf_Log::log($error_msg, Yf_Log::ERROR, 'pay_tenpay_notify');

}

 

?>