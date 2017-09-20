<?php

class Api_UserCtl extends Api_Controller
{
	public function getUserInfo()
	{
		$user_id = request_string('user_id');

		$user_info_row = array();

		if ($user_id)
		{
			$User_InfoModel = new User_InfoModel();
			$user_row = $User_InfoModel->getOne($user_id);

			if ($user_row)
			{
				$User_InfoDetailModel = new User_InfoDetailModel();
				$user_info_row = $User_InfoDetailModel->getOne($user_row['user_name']);
			}
			else
			{
			}
		}

		$this->data->addBody(100, $user_info_row);
	}


	//获取列表信息
	public function listUser()
	{
		$skey = request_string('skey');
		$page = $_REQUEST['page'];
		$rows = $_REQUEST['rows'];
		$asc = $_REQUEST['asc'];
		$userInfoModel = new User_InfoDetailModel();

		$items = array();
		$cond_row = array();
		$order_row = array();

		if($skey)
		{
			$cond_row['user_name:LIKE'] = '%'.$skey.'%';
		}

		$data = $userInfoModel->getInfoDetailList($cond_row, $order_row, $page, $rows);

		if($data){
			$msg = 'success';
			$status = 200;
		}
		else{
			$msg = 'failure';
			$status = 250;
		}
		$this->data->addBody(-140,$data,$msg,$status);
	}


    function details()
    {
        $user_name = request_string('id');
        $status = $_REQUEST['server_status'];
        //开启事物
        $User_InfoDetailModel  = new User_InfoDetailModel();
    
        $data = $User_InfoDetailModel->getOne($user_name);
    
        $User_InfoModel = new User_InfoModel();
        $user_id = $User_InfoModel->getUserIdByName($user_name);
    
        //扩展字段
        $User_OptionModel = new User_OptionModel();
        $user_option_rows = $User_OptionModel->getByWhere(array('user_id'=>$user_id));
    

        if ($user_option_rows)
        {
            $Reg_OptionModel = new Reg_OptionModel();
            $reg_opt_rows = $Reg_OptionModel->getByWhere(array('reg_option_active'=>1));
        
        
            foreach ($user_option_rows as $user_option_id=>$user_option_row)
            {
                $user_option_row['reg_option_name'] = $reg_opt_rows[$user_option_row['reg_option_id']]['reg_option_name'];
                
                $user_option_rows[$user_option_id] = $user_option_row;
            }
        }

        $data['user_option_rows'] = $user_option_rows;
        
        $this->data->addBody(-140, $data);
    }

  function add()
	{
		  $user_name 	= request_string('user_name');
			$password 	= request_string('password'); 
			$User_InfoModel = new User_InfoModel();
			$cond_row = array();
			$cond_row['user_name']	 = $user_name;
			$cond_row['password'] 	 = md5($password); 
			$user_info = $User_InfoModel->getOneByWhere($cond_row); 
			$data = array();
			if(!$user_name || !$password){
					$status = 250;
					$msg    = '参数错误';
			}else{
					if($user_info)
					{
						$msg    = '用户已存在';
						$status = 250;
						
					}
					else
					{ 
						$last_id = $User_InfoModel->addInfo($cond_row,true);
						$msg    = 'success';
						$status = 200;
						$data['id'] = $last_id; 
					}
			}
			
			$this->data->addBody(-1, $data, $msg, $status);
	}

	function change()
	{
		$user_name = request_string('id');
		$status = $_REQUEST['server_status'];
		$userInfoModel = new User_InfoModel();

		if($user_name)
		{
			$data['user_state'] = $status;
			
			$user_id = $userInfoModel->getUserIdByName($user_name);
			$flag = $userInfoModel->editInfo($user_id, $data);

			if(false !== $flag)
			{
				$msg = 'success';
				$status = 200;
			}
			else
			{
				$msg = 'failure';
				$status = 250;
			}
		}
		$this->data->addBody(-140,array(),$msg,$status);
	}

	//解除绑定,生成验证码,并且发送验证码
	public function getYzm()
	{

		$type = request_string('type');
		$val  = request_string('val');

		$cond_row['code'] = 'Lift verification';

		$de = $this->messageTemplateModel->getTemplateDetail($cond_row);

		fb($de);
		if ($type == 'mobile')
		{
			$me = $de['content_phone'];

			$code_key = $val;
			$code     = VerifyCode::getCode($code_key);
			$me       = str_replace("[weburl_name]", $this->web['web_name'], $me);
			$me       = str_replace("[yzm]", $code, $me);

			$str = Sms::send($val, $me);
		}
		else
		{
			$me    = $de['content_email'];
			$title = $de['title'];

			$code_key = $val;
			$code     = VerifyCode::getCode($code_key);
			$me       = str_replace("[weburl_name]", Web_ConfigModel::value("site_name"), $me);
			$me       = str_replace("[yzm]", $code, $me);
			$title    = str_replace("[weburl_name]", Web_ConfigModel::value("site_name"), $title);

			$str = Email::send($val, Perm::$row['user_account'], $title, $me);
		}
		$status = 200;
		$data   = array($code);
		$msg    = "success";
		$this->data->addBody(-140, $data, $msg, $status);

	}

	/**
	 * 修改会员密码
	 *
	 * @access public
	 */
	public function editUserPassword()
	{
		$user_name   = request_string('user_id');
		$user_password = request_string('user_password');

		$User_InfoModel = new User_InfoModel();
		$rs_row = array();

		//开启事务
		$User_InfoModel->sql->startTransactionDb();

		if($user_name && $user_password)
		{
			$user_id = $User_InfoModel->getUserIdByName($user_name);

			$edit_user['password'] = md5($user_password);
			$flag = $User_InfoModel->editInfo($user_id,$edit_user);
			check_rs($flag, $rs_row);
		}

		$flag = is_ok($rs_row);

		if ($flag && $User_InfoModel->sql->commitDb())
		{
			$status = 200;
			$msg    = _('success');
		}
		else
		{
			$User_InfoModel->sql->rollBackDb();
			$status = 250;
			$msg    = _('failure');
		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}

	/**
	 * 修改会员头像
	 *
	 * @access public
	 */
	public function editUserImg()
	{
		$user_id   = request_int('user_id');
		$User_Info = new User_Info();
		$user_info = current($User_Info->getInfo($user_id));
		$user_name = $user_info['user_name'];

		$userInfoModel  = new User_InfoDetailModel();
		$edit_user_row['user_avatar'] = request_string('user_avatar');

		$flag = $userInfoModel->editInfoDetail($user_name, $edit_user_row);
//		$data = array();
//		$data[0] = $user_name;
//		$this->data->addBody(-140, $edit_user_row);
		$data = array();
		//echo '<pre>';print_r($flag);exit;
		if ($flag === false)
		{
			$status = 250;
			$msg    = _('failure');
		}
		else
		{
			$status = 200;
			$msg    = _('success');
			$data[0] = $flag;
			$res = $userInfoModel->sync($user_id);
			//$userInfoModel->sync($user_id);
		}
		
		$this->data->addBody(-140, $data, $msg, $status);
	}


	/**
	 * 修改会员信息
	 *
	 * @access public
	 */
	public function editUserInfoDetail()
	{
		$user_id   = request_int('user_id');
		$User_Info = new User_Info();
		$user_info = current($User_Info->getInfo($user_id));
		$user_name = $user_info['user_name'];
		
//		$year    = request_int('year');
//		$month   = request_int('month');
//		$day     = request_int('day');
//		$user_qq = request_string('user_qq');

		$edit_user_row['user_birth']      = request_string('user_birth');
		$edit_user_row['user_gender']     = request_int('user_gender');
		$edit_user_row['user_truename']   = request_string('user_truename');
		$edit_user_row['user_provinceid'] = request_int('province_id');
		$edit_user_row['user_cityid']     = request_int('city_id');
		$edit_user_row['user_areaid']     = request_int('area_id');
		$edit_user_row['user_area']       = request_string('user_area');
		$edit_user_row['nickname']       = request_string('nickname');
		$edit_user_row['user_sign']       = request_string('user_sign');
		$edit_user_row['user_province']       = request_string('user_province');
		$edit_user_row['user_city']       = request_string('user_city');
		
		//$edit_user_row['user_ww'] = $user_ww;
		//echo '<pre>';print_r($edit_user_row);exit;
		$userInfoModel  = new User_InfoDetailModel();
		$userPrivacyModel = new User_PrivacyModel();

		if (!$userPrivacyModel->getOne($user_id))
		{
			$userPrivacyModel->addPrivacy(array('user_id'=>$user_id));
		}

		if (!$userInfoModel->getOne($user_name))
		{
			$userInfoModel->addInfoDetail(array('user_name'=>$user_name));
		}

		//开启事物
		$rs_row = array();
		$userInfoModel->sql->startTransactionDb();

		//$flagPrivacy = $this->userPrivacyModel->editPrivacy($user_id, $rows);
		//check_rs($flagPrivacy, $rs_row);
		$flag = $userInfoModel->editInfoDetail($user_name, $edit_user_row);
		check_rs($flag, $rs_row);
		$flag_status = array();
		$flag_status[0] = $flag;

		$flag = is_ok($rs_row);
		$flag_status[1] = $flag;
		$res = array();
		if ($flag && $userInfoModel->sql->commitDb())
		{
			$status = 200;
			$msg    = _('success');

			$res = $userInfoModel->sync($user_id);
		}
		else
		{
			$userInfoModel->sql->rollBackDb();
			$status = 250;
			$msg    = _('failure');

		}


		$this->data->addBody(-140, $flag_status, $msg, $status);
	}


	/**
	 * 修改会员信息
	 *
	 * @access public
	 */
	public function editUserInfo()
	{
		$user_id   = request_int('user_id');
		$User_Info = new User_Info();
		$user_info = current($User_Info->getInfo($user_id));
		$user_name = $user_info['user_name'];
		$edit_user_row['user_gender']     = request_int('user_gender');
		$edit_user_row['user_avatar']   = request_string('user_logo');
		$user_delete = request_int('user_delete');

		//开启事物
		$User_InfoDetailModel  = new User_InfoDetailModel();
		$rs_row = array();
		$User_InfoDetailModel->sql->startTransactionDb();

		$User_InfoModel = new User_InfoModel();
		$user_row = $User_InfoModel->getOne($user_id);
		if($user_delete)
		{
			$edit_user['user_state'] = 3;
			$flagState =$User_InfoModel->editInfo($user_id,$edit_user);
			check_rs($flagState, $rs_row);
		}
		else
		{
			if($user_row['user_state'] == 3)
			{
				$edit_user['user_state'] = 0;  //解禁后用户状态恢复到未激活
				$flagState =$User_InfoModel->editInfo($user_id,$edit_user);
				check_rs($flagState, $rs_row);
			}
		}

		$flag = $User_InfoDetailModel->editInfoDetail($user_name, $edit_user_row);
		check_rs($flag, $rs_row);

		$flag = is_ok($rs_row);

		if ($flag && $User_InfoDetailModel->sql->commitDb())
		{
			$status = 200;
			$msg    = _('success');


			$User_InfoDetailModel->sync($user_id);
		}
		else
		{
			$User_InfoDetailModel->sql->rollBackDb();
			$status = 250;
			$msg    = _('failure');

		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}
	
	public function checkUserAccount()
	{
		$user_name 	= request_string('user_name');
		$password 	= request_string('password');

		$User_InfoModel = new User_InfoModel();
		$cond_row = array();
		$cond_row['user_name']	 = $user_name;
		$cond_row['password'] 	 = md5($password);

		$user_info = $User_InfoModel->getOneByWhere($cond_row);

		$data = array();
		if($user_info)
		{
			$data['user_id'] 	= $user_info['user_id'];
			$data['user_name'] 	= $user_info['user_name'];
			$msg    = 'success';
			$status = 200;
		}
		else
		{
			$msg    = '用户不存在';
			$status = 250;
		}
		$this->data->addBody(-1, $data, $msg, $status);

	}

	
}

?>