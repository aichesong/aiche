<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class User_InfoDetailModel extends User_InfoDetail
{
	public static $userSex = array(
		"0" => '女',
		"1" => '男',
		"2" => '保密'
	);
	/**
	 * 读取分页列表
	 *
	 * @param  int $licence_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getInfoDetailList($cond_row = array(), $order_row = array(), $page=1, $rows=100)
	{
		$data = $this->listByWhere($cond_row, $order_row, $page, $rows);
		
		$User_InfoModel = new User_InfoModel();
		
		$user_name_row = array_column($data['items'], 'user_name');
		
		$user_base_rows = $User_InfoModel->getByWhere(array('user_name:IN'=>$user_name_row));
		
		$user_base_name_rows = array();
		foreach ($user_base_rows as $user_base_row)
		{
			$user_base_name_rows[$user_base_row['user_name']] = $user_base_row;
		}
		
		foreach ($data['items'] as $k => $item)
		{
			$item['user_reg_time'] = date('Y-m-d H:i:s', $item['user_reg_time']);
			$item['user_lastlogin_time'] = date('Y-m-d H:i:s', $item['user_lastlogin_time']);
			$item['user_id'] = $user_base_name_rows[$item['user_name']]['user_id'];
			$item['user_state'] = $user_base_name_rows[$item['user_name']]['user_state'];
			$item['user_gender1'] = _(User_InfoDetailModel::$userSex[$item['user_gender']]);
			
			$data['items'][$k] = $item;
		}
		
		return $data;
	}

	public function checkMobile($mobile=null)
	{
		$this->sql->setWhere('user_mobile',$mobile);
		$data = $this->getInfoDetail('*');
		return $data;
	}

    public function checkEmail($email=null)
	{
		$this->sql->setWhere('user_email',$email);
		$data = $this->getInfoDetail('*');
		return $data;
	}
    
	public function getUserByMobile($mobile=null)
	{
		$this->sql->setWhere('user_mobile',$mobile);
		$data = $this->getInfoDetail('*');
		$data = current($data);
		$name = $data['user_name'];
		return $name;
	}
    
    public function getUserByEmail($email=null)
	{
		$this->sql->setWhere('user_email',$email);
		$data = $this->getInfoDetail('*');
		$data = current($data);
		$name = $data['user_name'];
		return $name;
	}

	/**
	 * 根据主键值，从数据库读取数据
	 *
	 * @param  int   $user_name  主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getInfoDetailByUserId($user_id=null)
	{
		$this->sql->setWhere('user_id', $user_id);
		$data = $this->getInfoDetail('*');
		$data = current($data);
		return $data;
	}

	public function sync($user_id)
	{
		$edit_user_row = array();
		$user_info_row = array();
		
		if ($user_id)
		{
			$User_InfoModel = new User_InfoModel();
			$user_row = $User_InfoModel->getOne($user_id);

			$edit_user_row['user_id'] = $user_id;
			$edit_user_row['user_delete'] = $user_row['user_state']==3 ? 1 : 0;

			if ($user_row)
			{
				$User_InfoDetailModel = new User_InfoDetailModel();
				$user_info_row = $User_InfoDetailModel->getOne($user_row['user_name']);

				$edit_user_row['user_mobile']     = $user_info_row['user_mobile'];
				$edit_user_row['user_email']      = $user_info_row['user_email'];

				$edit_user_row['user_sex']        = $user_info_row['user_gender'];
				$edit_user_row['user_realname']   = $user_info_row['user_truename'];
				$edit_user_row['user_qq']         = $user_info_row['user_qq'];

				$edit_user_row['user_avatar']     = $user_info_row['user_avatar'] ? $user_info_row['user_avatar'] : Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');;

				$edit_user_row['user_provinceid'] = $user_info_row['user_provinceid'];
				$edit_user_row['user_cityid']     = $user_info_row['user_cityid'];
				$edit_user_row['user_areaid']     = $user_info_row['user_areaid'];
				$edit_user_row['user_area']       = $user_info_row['user_area'];
				$edit_user_row['user_birthday']   = $user_info_row['user_birth'];
			}
			else
			{
			}
		}
		
		fb($edit_user_row);
		if ($edit_user_row)
		{

            //同步， 需要同步启用的
            $cond_row = array();
            $cond_row['app_id:IN'] = array(102, 103, 105);

			$Base_App = new Base_AppModel();
			$base_app_rows = $Base_App->getByWhere($cond_row);
//			echo '<pre>';print_r($base_app_rows);exit;

			$res = array();
//			return $base_app_rows;
			foreach ($base_app_rows as $base_app_row)
			{
				$url = $base_app_row['app_url'];

				if ($url)
				{
					$key = $base_app_row['app_key'];
//					if($key == 'HANZaFR0Aw08PV1U')
//					{
//						$key = 'HANZaFR0Aw08PV1U02RzCW114UWXa26AUiIO';
//					}
					$formvars = $edit_user_row;
					$formvars['app_id']        = $base_app_row['app_id'];

					//需要从后台数据彻底解决，临时只适用官网
					if($url == 'http://www.im-builder.com/')
					{
						$url = 'http://api.im-builder.com/index.php';
					}
					$url = sprintf('%s?ctl=%s&met=%s&typ=%s', $url, 'Api_User_Info', 'editUserInfo', 'json');

					//权限加密数据处理
					$init_rs = get_url_with_encrypt($key, $url, $formvars);
					$res[]['url'] = $url;
					$res[] = $init_rs;

					if (200 == $init_rs['status'] && $init_rs['data'])
					{
						$init_flag = true;

						//更新状态app server 信息及状态
					}
					else
					{
						$init_flag = false;
					}
				}
			}
			return $res;
		}
	}


}
?>