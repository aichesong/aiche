<?php
if (!defined('ROOT_PATH'))
{
    if (is_file('../../../shop/configs/config.ini.php'))
    {
        require_once '../../../shop/configs/config.ini.php';
    }
    else
    {
        die('请先运行index.php,生成应用程序框架结构！');
    }

    //不会重复包含, 否则会死循环: web调用不到此处, 通过crontab调用
    $Base_CronModel = new Base_CronModel();
    $rows = $Base_CronModel->checkTask(); //并非指执行自己, 将所有需要执行的都执行掉, 如果自己达到执行条件,也不执行.

    //终止执行下面内容, 否则会执行两次
    return ;
}


Yf_Log::log(__FILE__, Yf_Log::INFO, 'crontab');

$file_name_row = pathinfo(__FILE__);
$crontab_file = $file_name_row['basename'];

fb($crontab_file);


//执行任务
$orderReturnModel       = new Order_ReturnModel();
$Order_BaseModel = new Order_BaseModel();
//开启事物

$cond_row['return_state'] = 1;
$Returnlist = $orderReturnModel->getByWhere( $cond_row );

if ( !empty($Returnlist) )
{
        $message = new MessageModel();

        foreach ( $Returnlist as $return_id => $return_detail )
        {
			$return_add_time = strtotime($return_detail['return_add_time']);
			$time = time()-7*24*60*60;
			if($return_add_time<$time){
				
				$cond_row = array();
				$cond_row['return_state'] = 2;
				$cond_row['return_shop_time'] = get_date_time();
				$flag = $orderReturnModel->editReturn($return_detail['order_return_id'],$cond_row);

                $order = $Order_BaseModel->getOne($return_detail['order_number']);


                $key      = Yf_Registry::get('shop_api_key');
                $url         = Yf_Registry::get('paycenter_api_url');
                $shop_app_id = Yf_Registry::get('shop_app_id');

                $formvars             = array();
                $formvars['app_id']        = $shop_app_id;
                $formvars['user_id']  = $order['buyer_user_id'];
                $formvars['user_account'] = $order['buyer_user_name'];
                $formvars['seller_id'] = $order['seller_user_id'];
                $formvars['seller_account'] = $order['seller_user_name'];
                $formvars['amount']   = $order['order_payment_amount'];
                $formvars['order_id'] = $return_detail['order_number'];
                $formvars['goods_id'] = $return_detail['order_goods_id'];
                $formvars['uorder_id'] = $order['payment_number'];


                $rs                   = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=refundTransfer&typ=json', $url), $formvars);


				
				if($return_detail['return_type'] == '2'){
					
					//退货提醒
					//$order_id
					$message->sendMessage('Return reminder',$return_detail['buyer_user_id'], $return_detail['buyer_user_account'], $return_detail['order_number'], $shop_name = NULL, 1, 1);
				}else{
					//退款提醒
					//$order_id
					$message->sendMessage('Refund reminder',$shop_detail['user_id'], $shop_detail['user_name'], $order_id, $shop_name = NULL, 1, 1);
				}
			}
           
        }

}


return true;
?>