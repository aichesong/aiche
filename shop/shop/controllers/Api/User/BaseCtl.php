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
class Api_User_BaseCtl extends Api_Controller
{


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

		$this->userBaseModel = new User_BaseModel();
	}

	public function getUserList()
	{

		$key            = Yf_Registry::get('ucenter_api_key');
		$url            = Yf_Registry::get('ucenter_api_url');
		$data['app_id'] = Yf_Registry::get('shop_app_id');
		$data['ctl']    = 'Api';
		$data['met']    = 'getAppServerList';
		$data['typ']    = 'json';
		$data['rows']   = '999999999999';

		$result = get_url_with_encrypt($key, $url, $data);

		$data['page']      = $result['data']['page'];
		$data['records']   = $result['data']['records'];
		$data['total']     = $result['data']['total'];
		$data['totalsize'] = $result['data']['totalsize'];
		$data['items']     = $result['data']['items'];

		foreach ($data['items'] as $key => $value)
		{
			$data['items'][$key]['id'] = $value['server_id'];
			if ($value['server_state'] == 0)
			{
				$data['items'][$key]['delete'] = true;
			}
			elseif ($value['server_state'] == 1)
			{
				$data['items'][$key]['delete'] = false;
			}
		}

		$msg    = $result['msg'];
		$status = $result['status'];

		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function change()
	{
		$key            = Yf_Registry::get('ucenter_api_key');
		$url            = Yf_Registry::get('ucenter_api_url');
		$data['app_id'] = Yf_Registry::get('shop_app_id');
		$data['ctl']    = 'Api';
		$data['met']    = 'virifyUserAppServer';
		$data['typ']    = 'json';

		if ($_REQUEST['server_status'] == 0)
		{
			$data['server_state'] = 1;
			$data['server_id']    = $_REQUEST['id'];
			$data['user_name']    = '';
			//$data['server_state'] = 1;//$_REQUEST['server_status'];
			$result = get_url_with_encrypt($key, $url, $data);
			if ($result)
			{
				if ($result['status'] == 200)
				{
					$status = 200;
					$msg    = 'success';
				}
				elseif ($result['status'] == 250)
				{
					$status = 250;
					$msg    = $result['msg'];
				}
			}
			else
			{
				$status = 250;
				$msg    = 'failure';
			}
		}
		else
		{
			$status = 250;
			$msg    = '该用户已经开通服务';
		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function save()
	{
		$data = $_REQUEST;

		if (request_int('service_id'))
		{
			$id = $_REQUEST['service_id'];
			unset($data['service_id']);

			$key               = Yf_Registry::get('ucenter_api_key');
			$url               = Yf_Registry::get('ucenter_api_url');
			$data['app_id']    = Yf_Registry::get('shop_app_id');
			$data['ctl']       = 'Api';
			$data['met']       = 'editUserAppServer';
			$data['typ']       = 'json';
			$data['server_id'] = $id;
			$result            = get_url_with_encrypt($key, $url, $data);

			if ($result)
			{
				if ($result['status'] == 200)
				{
					$status = 200;
					$msg    = 'success';
				}
				else
				{
					$status = 250;
					$msg    = $result['msg'];
				}
			}
			else
			{
				$status = 250;
				$msg    = 'failure';
			}
		}
		else
		{
			$key            = Yf_Registry::get('ucenter_api_key');
			$url            = Yf_Registry::get('ucenter_api_url');
			$data['app_id'] = Yf_Registry::get('shop_app_id');
			$data['ctl']    = 'Api';
			$data['met']    = 'addUserAppServer';
			$data['typ']    = 'json';

			$result = get_url_with_encrypt($key, $url, $data);
			if ($result)
			{
				if ($result['status'] == 200)
				{
					$status = 200;
					$msg    = 'success';
				}
				else
				{
					$status = 250;
					$msg    = $result['msg'];
				}
			}
			else
			{
				$status = 250;
				$msg    = 'failure';
			}
		}
		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function list1()
	{
		$key            = Yf_Registry::get('ucenter_api_key');
		$url            = Yf_Registry::get('ucenter_api_url');
		$data['app_id'] = Yf_Registry::get('shop_app_id');
		$data['ctl']    = 'Api';
		$data['met']    = 'getAppServerList';
		$data['typ']    = 'json';
		$data['rows']   = '999999999999';

		$id = $_REQUEST['id'];

		$result = get_url_with_encrypt($key, $url, $data);

		$data1 = $result['data']['items'];

		foreach ($data1 as $key => $value)
		{
			if ($value['server_id'] != $id)
			{
				unset($data1[$key]);
			}
			else
			{
				$data_rs = $data1[$key];
			}
		}
		if ($data_rs)
		{
			$msg    = 'success';
			$status = 200;
		}
		else
		{
			$msg    = 'failure';
			$status = 250;
		}

		$this->data->addBody(-140, $data_rs, $msg, $status);
	}

}

?>