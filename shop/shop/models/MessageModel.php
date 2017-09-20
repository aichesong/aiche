<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class MessageModel extends Message
{
    const ORDER_MESSAGE   = 1;//订单信息
    const USER_MESSAGE = 3;//账户信息
    const OTHER_MESSAGE = 4;//其他信息

	public static $messagePhone = array(
		"0" => '关闭',
		"1" => '开启'
	);

	/**
	 * 读取分页列表
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getMessageList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		
		$data = $this->listByWhere($cond_row, $order_row, $page, $rows);
		
		return $data;
	}
	
	/**
	 * 删除选中的消息
	 *
	 * @param  array $config_array 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function removeMessageSelected($config_array = array())
	{

		foreach ($config_array as $key => $value)
		{
			$flag = $this->removeMessage($value);
		}
	}

	/**
	 * 读取详情
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getMessageDetail($order_row = array())
	{
		$data = $this->getOneByWhere($order_row);
		return $data;
	}

	/**
	 * 读数量
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getCount($cond_row = array())
	{
		return $this->getNum($cond_row);
	}

	
	/**
	 * 发送站内信,短信,邮件
	 *
	 * @param  int $config_key 主键值
	 * @return array $flag 返回的发送的状态
	 * @access public
	 */
	public function sendMessage($code, $message_user_id, $message_user_name, $order_id = NULL, $shop_name = NULL, $message_mold = 0, $message_type = 1, $end_time = Null,$common_id=NULL,$goods_id=NULL,$des=NULL, $start_time = Null,$goods_name=NULL,$av_amount=NULL,$freeze_amount=NULL,$ztm=NULL,$chain_name=NULL,$content_mobile=NULL)
	{
		$send_row['code'] = $code;
		
		$this->messageTemplateModel = new Message_TemplateModel();

		$de = $this->messageTemplateModel->getTemplateDetail($send_row);
		
		$user_row['user_id'] = $message_user_id;
		
		$this->userInfo = new User_InfoModel();

		$member = $this->userInfo->getUserInfo($user_row);

		$info = 0;
        $flag = false;
		if ($message_mold == 0)
		{
			$this->messageSettingModel = new Message_SettingModel();
			
			$message = $this->messageSettingModel->getSettingDetail($user_row);
			if($message){
			$arr = explode(',', $message['message_template_all']);

			if (in_array($de['id'], $arr))
			{
				$info   = 1;
				$mobile = $member['user_mobile'];
				$email  = $member['user_email'];
			}
			}else{
				$mobile = "";
				$email  = "";
			}
		}
		else
		{
			$mobile = $member['user_mobile'];
			$email  = $member['user_email'];
			$info   = 1;
		}

        if($content_mobile)
        {
            $mobile = $content_mobile;
        }

		//先判断平台是否开启站内信
		if($de['is_mail'] == 1)
        {
            //1。平台设置强制发送 2。平台未设置强制发送，用户选择发送
            if($de['force_mail'] == 1 || ($de['force_mail'] == 0 && $info == 1))
            {
                $me = $de['content_mail'];

                $time     = get_date_time();
                $web_name = Web_ConfigModel::value("site_name");

                $me = str_replace("[order_id]", $order_id, $me);
                $me = str_replace("[date]", $time, $me);
                $me = str_replace("[weburl_name]", $web_name, $me);
                $me = str_replace("[name]", $shop_name, $me);
                $me = str_replace("[shop_name]", $shop_name, $me);
                $me = str_replace("[end]", $end_time, $me);
                $me = str_replace("[start_time]", $start_time, $me);
                $me = str_replace("[weburl_url]", Yf_Registry::get('url'), $me);
                $me = str_replace("[common_id]", $common_id, $me);
                $me = str_replace("[goods_id]", $goods_id, $me);
                $me = str_replace("[des]", $des, $me);
                $me = str_replace("[av_amount]", $av_amount, $me);
                $me = str_replace("[freeze_amount]", $freeze_amount, $me);
                $me = str_replace("[goods_name]", $goods_name, $me);
                $me = str_replace("[ztm]", $ztm, $me);
                $me = str_replace("[chain_name]", $chain_name, $me);

                $orders_row['message_content']     = $me;
                $orders_row['message_create_time'] = $time;
                $orders_row['message_mold']        = $message_mold;
                $orders_row['message_type']        = $message_type;
                $orders_row['message_title']       = $de['name'];
                $orders_row['message_user_id']     = $message_user_id;
                $orders_row['message_user_name']   = $message_user_name;

                $flag = $this->addMessage($orders_row);
            }

        }

		//先判断后台是否开启了短信功能，用户手机号是否存在
		if($de['is_phone'] == 1  && $mobile)
        {
            //1.判断后台是否开启了强制接受  2.平台未开启强制接受，用户选择开启接受
            if($de['force_phone'] == 1  || ($de['force_phone'] == 0 && $info == 1))
            {
                $phone = $de['content_phone'];

                $time     = get_date_time();
                $web_name = Web_ConfigModel::value("site_name");

                $phone = str_replace("[order_id]", $order_id, $phone);
                $phone = str_replace("[date]", $time, $phone);
                $phone = str_replace("[weburl_name]", $web_name, $phone);
                $phone = str_replace("[name]", $shop_name, $phone);
                $phone = str_replace("[shop_name]", $shop_name, $phone);
                $phone = str_replace("[end]", $end_time, $phone);
                $phone = str_replace("[start_time]", $start_time, $phone);
                $phone = str_replace("[weburl_url]", Yf_Registry::get('url'), $phone);
                $phone = str_replace("[common_id]", $common_id, $phone);
                $phone = str_replace("[goods_id]", $goods_id, $phone);
                $phone = str_replace("[des]", $des, $phone);
                $phone = str_replace("[av_amount]", $av_amount, $phone);
                $phone = str_replace("[freeze_amount]", $freeze_amount, $phone);
                $phone = str_replace("[goods_name]", $goods_name, $phone);
                $phone = str_replace("[ztm]", $ztm, $phone);
                $phone = str_replace("[chain_name]", $chain_name, $phone);

                $str = Sms::send($mobile, $phone);
                $flag = true;
            }

        }

        //先判断后台是否开启了邮件功能，用户邮箱是否存在
        if($de['is_email'] == 1  && $email)
        {
            //1.判断后台是否开启了强制接受  2.平台未开启强制接受，用户选择开启接受
            if($de['force_email'] == 1  || ($de['force_email'] == 0 && $info == 1))
            {
                $emails = $de['content_email'];
                $title  = $de['title'];

                $time     = get_date_time();
                $web_name = Web_ConfigModel::value("site_name");
                $user_name = Web_ConfigModel::value("email_id");

                $emails = str_replace("[order_id]", $order_id, $emails);
                $emails = str_replace("[date]", $time, $emails);
                $emails = str_replace("[weburl_name]", $web_name, $emails);
                $emails = str_replace("[name]", $shop_name, $emails);
                $emails = str_replace("[shop_name]", $shop_name, $emails);
                $emails = str_replace("[end]", $end_time, $emails);
                $emails = str_replace("[start_time]", $start_time, $emails);
                $emails = str_replace("[weburl_url]", Yf_Registry::get('url'), $emails);
                $emails = str_replace("[common_id]", $common_id, $emails);
                $emails = str_replace("[goods_id]", $goods_id, $emails);
                $emails = str_replace("[user_name]", $user_name, $emails);
                $emails = str_replace("[des]", $des, $emails);
                $emails = str_replace("[av_amount]", $av_amount, $emails);
                $emails = str_replace("[freeze_amount]", $freeze_amount, $emails);
                $emails = str_replace("[goods_name]", $goods_name, $emails);
                $emails = str_replace("[ztm]", $ztm, $emails);
                $emails = str_replace("[chain_name]", $chain_name, $emails);

                $title  = str_replace("[weburl_name]", $web_name, $title);


                $str = Email::sendMail($email, $message_user_name, $title, $emails);
                $flag = true;
            }

        }
        
		return $flag;
	}
}

?>