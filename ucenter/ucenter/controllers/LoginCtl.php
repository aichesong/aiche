<?php
header("Access-Control-Allow-Credentials: true"); 
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';  
header("Access-Control-Allow-Origin:$origin");  

class LoginCtl extends Yf_AppController
{

	public function callback()
	{
		echo 'callback 地址';
	}
	public function select()
	{
		$web['site_logo']       = Web_ConfigModel::value("site_logo");//首页logo

		$BaseAppModel = new BaseApp_BaseAppModel();
		$shop_row = $BaseAppModel->getOne('102');

		$shop_url = '';
		if($shop_row)
		{
			$shop_url = $shop_row['app_url'];
		}

		$type = request_int('type');
		$re_url = Yf_Registry::get('re_url');

		$from = $_REQUEST['callback'];
		$callback = $from?$from:$re_url;

		//根据token获取用户信息
		$token = request_string('t');
		$User_BindConnectModel = new User_BindConnectModel();

		$user_info = $User_BindConnectModel->getBindConnectByToken($token);
		$user_info = current($user_info);
		fb($user_info);

		//查找注册的设置
		$Web_ConfigModel = new Web_ConfigModel();
		$reg_row = $Web_ConfigModel->getByWhere(array('config_type'=>'register'));

		$pwd_str = '';

		//判断是否开启了用户密码必须包含数字
		if($reg_row['reg_number']['config_value'])
		{
			$pwd_str .= "'数字'";
		}

		//判断是否开启了用户密码必须包含小写字母
		if($reg_row['reg_lowercase']['config_value'])
		{
			$pwd_str .= "'小写字母'";
		}

		//判断是否开启了用户密码必须包含大写字母
		if($reg_row['reg_uppercase']['config_value'])
		{
			$pwd_str .= "'大写字母'";
		}

		//判断是否开启了用户密码必须包含符号
		if($reg_row['reg_symbols']['config_value'])
		{
			$pwd_str .= "'符号'";
		}

		if($pwd_str)
		{
			$pwd_str = '密码中必须包含：'.$pwd_str;
		}
		if($pwd_str)
		{
			$pwd_str .= '，';
		}

		$pwd_str .= $reg_row['reg_pwdlength']['config_value'].'-20个字符。';
		include $this->view->getView();
	}

	//第三方注册
	public function bindRegist()
	{
		$token = request_string('token');
		$user_code = request_string('code');
		$mobile    = request_string('mobile');
		$password    = request_string('password');
		$server_id = 0;

		if (!$user_code)
		{
			$this->data->setError('请输入验证码');
			return false;
		}

		if (!$mobile)
		{
			$this->data->setError('请输入手机号');
			return false;
		}

		if (!$password)
		{
			$this->data->setError('请输入密码');
			return false;
		}

		$config_cache = Yf_Registry::get('config_cache');
		$Cache_Lite   = new Cache_Lite_Output($config_cache['default']);

		$user_code_pre = $Cache_Lite->get($mobile);

		if($user_code != $user_code_pre)
		{
			if(DEBUG!==true){
				$user_code_pre = "";
			}
			$this->data->setError('验证码错误');
			return false;
		}

		$rs_row = array();

		//根据token从绑定表中查找用户信息
		$User_BindConnectModel = new User_BindConnectModel();

		//开启事务
		$User_BindConnectModel->sql->startTransaction();

		$bind_info = $User_BindConnectModel->getBindConnectByToken($token);
		$bind_info = current($bind_info);

		if(!$bind_info)
		{
			$this->data->setError('绑定账号不存在');
			return false;
		}

		//判断绑定账户是否已经绑定过用户，已经绑定过用户的账号，不可重复绑定
		if($bind_info['user_id'])
		{
			$this->data->setError('该账号已经绑定用户!');
			return false;
		}

		//判断该账号名是否已经存在
		$User_InfoModel  = new User_InfoModel();
		$User_InfoDetail = new User_InfoDetailModel();
		$user_rows = $User_InfoModel->getInfoByName($bind_info['bind_nickname']);

		//如果用户名已经存在了，则在用户名后面添加随机数
		if($user_rows)
		{
			$bind_info['bind_nickname'] = $bind_info['bind_nickname'].rand(0000,9999);
		}

		//在user_info中插入用户信息
		$Db       = Yf_Db::get('ucenter');
		$seq_name = 'user_id';
		$user_id  = $Db->nextId($seq_name);

		$now_time = time();
		$ip       = get_ip();

		$session_id                         = uniqid();
		$arr_field_user_info                = array();
		$arr_field_user_info['user_id']     = $user_id;
		$arr_field_user_info['user_name']   = $bind_info['bind_nickname'];
		$arr_field_user_info['password']    = $password;
		$arr_field_user_info['action_time'] = $now_time;
		$arr_field_user_info['action_ip']   = $ip;
		$arr_field_user_info['session_id']  = $session_id;

		$user_info_add_flag = $User_InfoModel->addInfo($arr_field_user_info);
		check_rs($rs_row, $user_info_add_flag);

		//在绑定表中插入用户id
		$bind_user_row = array();
		$time = date('Y-m-d H:i:s',time());
		$bind_user_row['user_id'] = $user_id;
		$bind_user_row['bind_time'] = $time;
		$bind_user_row['bind_token'] = $token;
		$bind_edit_flag = $User_BindConnectModel->editBindConnect($bind_info['bind_id'],$bind_user_row);
		check_rs($rs_row, $bind_edit_flag);

		//在user_info_detail表中插入用户信息
		$arr_field_user_info_detail                        = array();
		if($bind_info['bind_gender'] == 1)
		{
			$gender = 1;
		}else
		{
			$gender = 0;
		}
		$qq_logo = substr($bind_info['bind_avator'], 0,strrpos($bind_info['bind_avator'],'/'));
		$qq_logo = $qq_logo.'/40';

		$arr_field_user_info_detail['user_name']           = $bind_info['bind_nickname'];
		$arr_field_user_info_detail['user_mobile']         = $mobile;
		$arr_field_user_info_detail['nickname']            = $bind_info['bind_nickname'];
		$arr_field_user_info_detail['user_avatar']         = $bind_info['bind_avator'];
		$arr_field_user_info_detail['user_avatar_thumb']   = $qq_logo;
		$arr_field_user_info_detail['user_gender']         = $gender;
		$arr_field_user_info_detail['user_reg_time']       = $now_time;
		$arr_field_user_info_detail['user_count_login']    = 1;
		$arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
		$arr_field_user_info_detail['user_lastlogin_ip']   = $ip;
		$arr_field_user_info_detail['user_reg_ip']         = $ip;

		$user_detail_add_flag = $User_InfoDetail->addInfoDetail($arr_field_user_info_detail);
		check_rs($rs_row, $user_detail_add_flag);


		if (is_ok($rs_row) && $User_BindConnectModel->sql->commit())
		{
			$d            = array();
			$d['user_id'] = $user_id;

			$encrypt_str = Perm::encryptUserInfo($d, $session_id);

			$arr_body = array(
				"user_name" => $bind_info['bind_nickname'],
				"server_id" => $server_id,
				"k" => $encrypt_str,
				"user_id" => $user_id
			);

			$this->data->addBody(100, $arr_body);

		}else{
			$User_BindConnectModel->sql->rollBack();
			$this->data->setError('创建用户信息失败');
		}
	}

	//第三方关联登录
	public function bindLogin()
	{
		$token = request_string('token');
		$type = request_int('type');

		$user_name = strtolower(request_string('user_account'));
		$password = request_string('user_password');

		$User_BindConnectModel = new User_BindConnectModel();

		$rs_row = array();

		//开启事务
		$User_BindConnectModel->sql->startTransaction();

		$bind_info = $User_BindConnectModel->getBindConnectByToken($token);
		$bind_info = current($bind_info);

		//判断绑定账户是否已经绑定过用户，已经绑定过用户的账号，不可重复绑定
		if($bind_info['user_id'])
		{
			$this->data->setError('该账号已经绑定用户!');
			return false;
		}

		if (!strlen($user_name))
		{
			$this->data->setError('请输入账号');
			return false;
		}

		if (!strlen($password))
		{
			$this->data->setError('请输入密码');
			return false;
		}

		$User_InfoModel  = new User_InfoModel();
		$User_InfoDetail = new User_InfoDetailModel();

		$user_info_row   = $User_InfoModel->getInfoByName($user_name);

		if (!$user_info_row)
		{
			$this->data->setError('账号不存在');
			return false;
		}

		$pswd =  md5($password);

		if ($pswd != $user_info_row['password'])
		{
			$this->data->setError('密码错误');
			return false;
		}

		if (3 == $user_info_row['user_state'])
		{
			$this->data->setError('用户已经锁定,禁止登录!');
			return false;
		}

		//查找该用户是否已经绑定过其他用户
		$bind_id_row = $User_BindConnectModel->getBindConnectByuserid($user_info_row['user_id'],$type);
		if($bind_id_row)
		{
			$this->data->setError('账号已绑定');
			return false;
		}

		$info_row = $User_InfoDetail->getOne($user_name);

		if(!$info_row['user_mobile'])
		{
			$this->data->setError('该账号未绑定手机号！');
			return false;
		}


		$session_id = $user_info_row['session_id'];
		$arr_body           = $user_info_row;
		$arr_body['result'] = 1;

		$data            = array();
		$data['user_id'] = $user_info_row['user_id'];
		$arr_body['user_id'] = $user_info_row['user_id'];

		$encrypt_str = Perm::encryptUserInfo($data, $session_id);
		$arr_body['k'] = $encrypt_str;

		//插入绑定表
		$time = date('Y-m-d H:i:s',time());
		$User_BindConnectModel = new User_BindConnectModel();
		$bind_array = array(
			'user_id'	=>$user_info_row['user_id'],
			'bind_time'	=>$time,
			'bind_token'=>$token,
		);
		$user_bind_flag = $User_BindConnectModel->editBindConnect($bind_info['bind_id'],$bind_array);
		check_rs($rs_row,$user_bind_flag);


		$arr_field_user_info_detail['user_count_login']    = $info_row['user_count_login'] + 1;
		$arr_field_user_info_detail['user_lastlogin_time'] = time();

		$user_detail_flag = $User_InfoDetail->editInfoDetail($user_name, $arr_field_user_info_detail);
		check_rs($rs_row,$user_detail_flag);


		if (is_ok($rs_row) && $User_BindConnectModel->sql->commit())
		{
			$this->data->addBody(100, $arr_body);

		}else{
			$User_BindConnectModel->sql->rollBack();
			$this->data->setError('关联用户失败');
		}
	}


	public function index()
	{
		$web['site_logo']       = Web_ConfigModel::value("site_logo");//首页logo

		$BaseAppModel = new BaseApp_BaseAppModel();
		$shop_row = $BaseAppModel->getOne('102');

		$shop_url = '';
		if($shop_row)
		{
			$shop_url = $shop_row['app_url'];
		}
		fb($shop_url);

		$act =  request_string('act');

		fb($act);
		//如果已经登录,则直接跳转
		if (Perm::checkUserPerm())
		{
			$data = Perm::$row;

			//查找用户是否绑定了手机号。如果没有绑定的手机号就退出
			$User_InfoDetailModel = new User_InfoDetailModel();
			$user_info = $User_InfoDetailModel->getInfoDetail($data['user_name']);
			$user_info = current($user_info);
			if(!$user_info['user_mobile'])
			{
				$this->loginout();
			}


			$k = $_COOKIE[Perm::$cookieName];
			$u = $_COOKIE[Perm::$cookieId];

			if (isset($_REQUEST['callback']) && $_REQUEST['callback'])
			{
				$url = $_REQUEST['callback'] . '&us=' . $u . '&ks=' . urlencode($k);

			}
			else
			{
				$url = './index.php';
			}

			header('location:' . $url);
		}
		else
		{
			//查找注册的设置
			$Web_ConfigModel = new Web_ConfigModel();
			$reg_row = $Web_ConfigModel->getByWhere(array('config_type'=>'register'));
            if(!isset($reg_row['reg_checkcode']) || !$reg_row['reg_checkcode']){
                //config_value = 1手机，2邮箱，默认手机验证
                $reg_row['reg_checkcode'] = array(
                    'config_key' => 'reg_checkcode',
                    'config_value' => 1,
                    'config_type' => 'register',
                    'config_enable' => 1,
                    'config_comment' => '',
                    'config_datatype' => 'number'
                );
            }
			$pwd_str = '';

			if($reg_row['reg_checkcode']['config_value'] == 2)
			{
				$email_display = 'display';
				$mobile_display = 'none';
				$both_display = 'none';
			}
			elseif($reg_row['reg_checkcode']['config_value'] == 3)
			{
				$email_display = 'none';
				$mobile_display = 'display';
				$both_display = 'display';
			}
			else
			{
				$email_display = 'none';
				$mobile_display = 'display';
				$both_display = 'none';
			}

			//判断是否开启了用户密码必须包含数字
			if($reg_row['reg_number']['config_value'])
			{
				$pwd_str .= "'数字'";
			}

			//判断是否开启了用户密码必须包含小写字母
			if($reg_row['reg_lowercase']['config_value'])
			{
				$pwd_str .= "'小写字母'";
			}

			//判断是否开启了用户密码必须包含大写字母
			if($reg_row['reg_uppercase']['config_value'])
			{
				$pwd_str .= "'大写字母'";
			}

			//判断是否开启了用户密码必须包含符号
			if($reg_row['reg_symbols']['config_value'])
			{
				$pwd_str .= "'符号'";
			}

			if($pwd_str)
			{
				$pwd_str = '密码中必须包含：'.$pwd_str;
			}
			if($pwd_str)
			{
				$pwd_str .= '，';
			}

			$pwd_str .= $reg_row['reg_pwdlength']['config_value'].'-20个字符。';
			if($act == 'reset')
			{
				$this->view->setMet('resetpwd');
			}
			if($act == 'reg')
			{
                
                $Reg_OptionModel = new Reg_OptionModel();
                $reg_opt_rows = $Reg_OptionModel->getByWhere(array('reg_option_active'=>1));
                
                
                
				$this->view->setMet('regist');
			}

			include $this->view->getView();
		}
	}

	public function regist()
	{
		//如果已经登录,则直接跳转
		if (Perm::checkUserPerm())
		{
			$data = Perm::$row;

			$k = $_COOKIE[Perm::$cookieName];
			$u = $_COOKIE[Perm::$cookieId];

			if (isset($_REQUEST['callback']))
			{
				$url = $_REQUEST['callback'] . '&us=' . $u . '&ks=' . urlencode($k);

			}
			else
			{
				$url = './index.php';
			}

			header('location:' . $url);
		}
		else
		{
			if(isset($_REQUEST['callback']))
			{
				$url = './index.php?ctl=Login&act=reg&callback='.urlencode($_REQUEST['callback']);
			}
			else
			{
				$url = './index.php?ctl=Login&act=reg';
			}

			header('location:' . $url);
		}

	}

	public function findpwd()
	{
		$url = './index.php?ctl=Login&act=reset';
		header('location:' . $url);
	}

    /**
	 * 手机获取注册码
	 *
	 * @access public
	 */
	public function regCode(){
		$mobile = request_string('mobile');
        $email = request_string('email');
        $yzm = request_string('yzm');
		if (!Perm::checkYzm($yzm)){
            return $this->data->addBody(-140, array(), __('图形验证码有误'), 250);
		}
        $check_code = mt_rand(100000, 999999);

        if($mobile && Yf_Utils_String::isMobile($mobile)){
            //判断手机号是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkmobile = $User_InfoDetail->checkMobile($mobile);
            if($checkmobile){
                $msg    = __('该手机号已注册');
                $status = 250;
            }else{
                $save_result = $this->_saveCodeCache($mobile,$check_code,'default');
                if(!$save_result){
                    $msg    = __('发送失败');
                    $status = 250;
                }else{
                    //发送短消息
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/','/\[yzm\]/');
                    $replacement = array(Web_ConfigModel::value("site_name"),$check_code);
                    $message_info = $message_model->getTemplateInfo(array('code'=>'regist_verify'), $pattern ,$replacement);
                    if(!$message_info['is_phone']){
                        $this->data->addBody(-140,array() , __('信息内容创建失败'), 250);
                    }
                    $contents = $message_info['content_phone'];
                    $result = Sms::send($mobile, $contents);
                    if ($result){
                        $msg    = __('发送成功');
                        $status = 200;
                    }else{
                        $msg    = __('发送失败');
                        $status = 250;
                    }
                }
            }
        }else if($email && filter_var($email, FILTER_VALIDATE_EMAIL)){
            //判断邮箱是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkemail = $User_InfoDetail->checkEmail($email);
            if($checkemail){
                $msg    = __('该邮箱已注册');
                $status = 250;
            }else{
                $save_result = $this->_saveCodeCache($email,$check_code,'default');
                if(!$save_result){
                    $msg    = __('验证码获取失败');
                    $status = 250;
                }else{
                    //发送邮件
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/','/\[yzm\]/');
                    $replacement = array(Web_ConfigModel::value("site_name"),$message_info);
                    $message_info = $message_model->getTemplateInfo(array('code'=>'regist_verify'), $pattern ,$replacement);
                    if(!$message_info['is_email']){
                        $this->data->addBody(-140,array() , __('信息内容创建失败'), 250);
                    }
                    $title = '注册验证';
                    $contents = $message_info['content_email'];
                    $result = Email::send($email,'', $title, $contents);
                    if ($result)
                    {
                        $msg    = __('发送成功');
                        $status = 200;
                    }else{
                        $msg    = __('发送失败');
                        $status = 250;
                    }
                }
            }
        }else{
            $msg    = __('发送失败');
            $status = 250;
        }

		$data = array();
		if(DEBUG===true){
			$data['user_code'] = $check_code;
		}
        return $this->data->addBody(-140,$data , $msg, $status);
	}


	/**
	 * 手机获取找回密码验证码
	 *
	 * @access public
	 */
	public function findPasswdCode()
	{
		$mobile = request_string('mobile');
        $email = request_string('email');

		$data = array();
		/*$user_name = request_string('user_name');
		//验证手机号是否是用户手机号
		$User_InfoDetail = new User_InfoDetailModel();
		$mobile_info = $User_InfoDetail->getInfoDetail($user_name);
		$mobile_info = array_values($mobile_info);
		$user_mobile = $mobile_info[0]['user_mobile'];
		
		if($mobile != $user_mobile)
		{
			$this->data->setError('请填写注册手机号');
			return false;
		}*/
		//判断用户是否存在  $mobile
		$pattern_phone = '/^1\d{10}$/';
        $pattern_email = '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/';
        $check_code = mt_rand(100000, 999999);
        if(preg_match($pattern_phone, $mobile)){
            //缓存数据
			$save_result = $this->_saveCodeCache($mobile,$check_code,'default');
            if(!$save_result){
                $msg    = '发送失败';
                $status = 250;
            }else{
                //发送短消息
                $contents = '您的验证码是：' . $check_code . '。请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
                $result = Sms::send($mobile, $contents);
                if ($result){
                    $msg    = '发送成功';
                    $status = 200;
                } else {
                    $msg    = '发送失败';
                    $status = 250;
                }
            }
		}else if(preg_match($pattern_email, $email)){
			//缓存数据
			$save_result = $this->_saveCodeCache($email,$check_code,'default');
            if(!$save_result){
                $msg    = '发送失败';
                $status = 250;
            }else{
                //发送短消息
                $contents = '您的验证码是：' . $check_code . '。请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
                $result = Email::send($email,'','找回密码验证码', $contents);
                if ($result){
                    $msg    = '发送成功';
                    $status = 200;
                } else {
                    $msg    = '发送失败';
                    $status = 250;
                }
            }
        }else{
			$msg    = '用户账号不存在';
			$status = 250;
		}
		if(DEBUG===true){
			$data['user_code'] = $check_code;
		}
		$this->data->addBody(-140, $data, $msg, $status);
	}


	public function resetPasswd()
	{
		$user_code = request_string('user_code');
		$from = request_string('from');
		$data           = array();
		$data['mobile'] = request_string('mobile');
        $data['email'] = request_string('email');
		$data['password'] = md5(request_string('user_password'));
		$data['passworderp'] = request_string('user_password');
        $reg_checkcode = request_string('reg_checkcode','1');
		//为erp做的修改密码
		if($from == 'erp' || $from == 'chain')
		{
			$data['user']   = request_string('user_account');
			$User_InfoModel = new User_InfoModel();
			//检测登录状态
			$user_id_row = $User_InfoModel->getInfoByName($data['user']);
			if ($user_id_row)
			{
				//重置密码
				$user_id          = $user_id_row['user_id'];
				$reset_passwd_row = array();
				$reset_passwd_row['password'] = $from == 'erp' ? $data['passworderp'] : $data['password'];
				$flag = $User_InfoModel->editInfo($user_id, $reset_passwd_row);
				if ($flag)
				{
					$msg    = '重置密码成功';
					$status = 200;
				}else{
					$msg    = '重置密码失败';
					$status = 250;
				}
			}else{
				$msg    = '用户不存在';
				$status = 250;
			}
			unset($data['password']);
		}else{
            if ($user_code){
                if($reg_checkcode == 1 || $reg_checkcode == 3){
                    if (!$data['mobile'])
                    {
                        $this->data->setError('手机号不能为空');
                        return false;
                    }
                }else{
                    if (!$data['email'])
                    {
                        $this->data->setError('邮箱不能为空');
                        return false;
                    }
                }
                if (request_string('user_password'))
                {
                    $config_cache = Yf_Registry::get('config_cache');
                    $Cache_Lite   = new Cache_Lite_Output($config_cache['default']);
					if($reg_checkcode == 2)
					{
						$user_code_pre = $Cache_Lite->get($data['email']);
					}else
					{
						$user_code_pre = $Cache_Lite->get($data['mobile']);
					}
                    //$user_code_pre = $reg_checkcode == 1 ? $Cache_Lite->get($data['mobile']) : $Cache_Lite->get($data['email']);
                    if ($user_code == $user_code_pre)
                    {
                        $User_InfoModel = new User_InfoModel();
                        $User_InfoDetailModel = new User_InfoDetailModel();
                        //检测登录状态
						if($reg_checkcode == 2)
						{
							$data['user'] = $User_InfoDetailModel->getUserByEmail($data['email']);
						}else
						{
							$data['user'] = $User_InfoDetailModel->getUserByMobile($data['mobile']);
						}

                        //$data['user'] = $reg_checkcode == 1 ? $User_InfoDetailModel->getUserByMobile($data['mobile']) : $User_InfoDetailModel->getUserByEmail($data['email']);

                        $user_id_row = $User_InfoModel->getInfoByName($data['user']);
                        if ($user_id_row)
                        {
                            //重置密码
                            $user_id          = $user_id_row['user_id'];
                            $reset_passwd_row = array();
                            $reset_passwd_row['password'] = $data['password'];
                            
                            $flag = $User_InfoModel->editInfo($user_id, $reset_passwd_row);
                            if ($flag === 'false')
                            {
                                $msg    = '网路故障，请稍后重试';
                                $status = 250;
                            }else{
                                $msg    = '重置密码成功';
                                $status = 200;
                                 //使验证码失效
								if($reg_checkcode == 2)
								{
									$reg_checkcode == $Cache_Lite->remove($data['email']);
								}else
								{
									$reg_checkcode == $Cache_Lite->remove($data['mobile']);
								}
                                //$reg_checkcode == 1 ? $Cache_Lite->remove($data['mobile']) : $Cache_Lite->remove($data['email']);
                            }
                        }else{
                            $msg    = '用户不存在';
                            $status = 250;
                        }
                    }else{
                        $msg    = '验证码错误'.$Cache_Lite->get($data['email']);
                        $status = 250;
                    }

                }else{
                    $msg    = '密码不能为空';
                    $status = 250;
                }
            }else{
                $msg    = '验证码不能为空';
                $status = 250;
            }
            unset($data['password']);
        }
		$this->data->addBody(-140, array(), $msg, $status);
	}


	public function register()
	{
        $option_value_row = request_row('option');
        $Reg_OptionModel = new Reg_OptionModel();
        $reg_opt_rows = $Reg_OptionModel->getByWhere(array('reg_option_active'=>1));
        
        foreach ($reg_opt_rows as $reg_option_id=>$reg_opt_row)
        {
            if ($reg_opt_row['reg_option_required'])
            {
                if ('' == $option_value_row[$reg_option_id])
                {
                    $this->data->setError('请输入' . $reg_opt_row['reg_option_name']);
                    return false;
                }
            }
        }
        
		$token = request_string('t');

		$app_id = request_int('app_id');

		$user_name = request_string('user_account', null);
		$password  = request_string('user_password', null);


		$user_code = request_string('user_code');
		$mobile    = request_string('mobile');
        $email = request_string('email'); 
        $reg_checkcode = request_int('reg_checkcode',1);
		$server_id = 0;

		if (!$user_name)
		{
			$this->data->setError('请输入账号');
			return false;
		}

		if (!$password)
		{
			$this->data->setError('请输入密码');
			return false;
		}
		if (!$user_code)
		{
			$this->data->setError('请输入验证码');
			return false;
		}
        
        if($reg_checkcode == 1 || $reg_checkcode == 3){
            if (!$mobile)
            {
                $this->data->setError('请输入手机号');
                return false;
            }
        }else{
            if (!$email)
            {
                $this->data->setError('请输入邮箱');
                return false;
            }
        }
		

		$config_cache = Yf_Registry::get('config_cache');
		$Cache_Lite   = new Cache_Lite_Output($config_cache['default']);

		if($reg_checkcode == 2)
		{
			$user_code_pre = $Cache_Lite->get($email);
		}else
		{
			$user_code_pre = $Cache_Lite->get($mobile);
		}
		//$user_code_pre = $reg_checkcode == 1 ? $Cache_Lite->get($mobile) : $Cache_Lite->get($email);

		if ($user_code == $user_code_pre)
		{
			$rs_row = array();

			//用户是否存在
			$User_InfoModel  = new User_InfoModel();
			$User_InfoDetail = new User_InfoDetailModel();

			$user_rows = $User_InfoModel->getInfoByName($user_name);

			if ($user_rows)
			{
				$this->data->setError('用户已经存在,请更换用户名!');
				return false;
			}else{

				$User_InfoModel->sql->startTransaction();

				$Db       = Yf_Db::get('ucenter');
				$seq_name = 'user_id';
				$user_id  = $Db->nextId($seq_name);
				
//				$User_InfoModel->check_input($user_name, $password, $user_mobile);

				$now_time = time();
				$ip       = get_ip();

				$session_id                         = uniqid();
				$arr_field_user_info                = array();
				$arr_field_user_info['user_id']     = $user_id;
				$arr_field_user_info['user_name']   = $user_name;
				$arr_field_user_info['password']    = md5($password);
				$arr_field_user_info['action_time'] = $now_time;
				$arr_field_user_info['action_ip']   = $ip;
				$arr_field_user_info['session_id']  = $session_id;

				$flag = $User_InfoModel->addInfo($arr_field_user_info);
				array_push($rs_row, $flag);
				$arr_field_user_info_detail                        = array();


                //添加mobile绑定.
                //绑定标记：mobile/email/openid  绑定类型+openid
                $bind_id = $reg_checkcode == 1 ? sprintf('mobile_%s', $mobile) : sprintf('email_%s', $email);

                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel->getOne($bind_id);
                
                if (!$bind_info)
                {
                    $time = date('Y-m-d H:i:s',time());

                    //插入绑定表
                    $bind_array = array(
                        'bind_id'=>$bind_id,
                        'user_id'=>$user_id,
                        'bind_type'=> $reg_checkcode == 1 ? $User_BindConnectModel::MOBILE : $User_BindConnectModel::EMAIL ,
                        'bind_time'=>$time
                    );

                    $flag = $User_BindConnectModel->addBindConnect($bind_array);
                    array_push($rs_row, $flag);
                    //绑定关系
                    if($reg_checkcode == 1){
                        $arr_field_user_info_detail['user_mobile_verify']         = 1;
                    }else{
                        $arr_field_user_info_detail['user_email_verify']         = 1;
                    }
                }



				$arr_field_user_info_detail['user_name']           = $user_name;
                if($reg_checkcode == 1){
                    $arr_field_user_info_detail['user_mobile']         = $mobile;
                }else{
                    $arr_field_user_info_detail['user_email']         = $email;
                }
				//$arr_field_user_info_detail['user_mobile_verify']         = 1;
				$arr_field_user_info_detail['user_reg_time']       = $now_time;
				$arr_field_user_info_detail['user_count_login']    = 1;
				$arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
				$arr_field_user_info_detail['user_lastlogin_ip']   = $ip;
				$arr_field_user_info_detail['user_reg_ip']         = $ip;

				$flag = $User_InfoDetail->addInfoDetail($arr_field_user_info_detail);
				array_push($rs_row, $flag);


                $User_OptionModel = new User_OptionModel();


                foreach ($reg_opt_rows as $reg_option_id=>$reg_opt_row)
                {
                    if (isset($option_value_row[$reg_option_id]))
                    {
                        $reg_option_value_row = explode(',', $reg_opt_row['reg_option_value']);

                        $user_option_row = array();
                        $user_option_row['reg_option_id'] = $reg_option_id;
                        $user_option_row['reg_option_value_id'] = $option_value_row[$reg_option_id];
                        $user_option_row['user_id'] = $user_id;
                        $user_option_row['user_option_value'] = isset($reg_option_value_row[$option_value_row[$reg_option_id]]) ? $reg_option_value_row[$option_value_row[$reg_option_id]] : $option_value_row[$reg_option_id];



                        $flag = $User_OptionModel->addOption($user_option_row);

                        array_push($rs_row, $flag);

                    }
                }

                //验证成功使验证码失效
                $reg_checkcode == 1 ? $Cache_Lite->remove($mobile) : $Cache_Lite->remove($email);
			}


			if (is_ok($rs_row) && $User_InfoDetail->sql->commit())
			{
				$d            = array();
				$d['user_id'] = $user_id;

				$encrypt_str = Perm::encryptUserInfo($d, $session_id);

				$arr_body = array(
					"user_name" => $user_name,
					"server_id" => $server_id,
					"k" => $encrypt_str,
					"user_id" => $user_id
				);

				if($token)
				{
					//查找bind绑定表
					$User_BindConnectModel = new User_BindConnectModel();
					$bind_info = $User_BindConnectModel->getBindConnectByToken($token);
					
					$bind_info = $bind_info[0];

					//获取qq缩略头像
					$qq_logo = substr($bind_info['bind_avator'], 0,strrpos($bind_info['bind_avator'],'/'));
					$qq_logo = $qq_logo.'/40';
					//更新用户详情表
					if($bind_info['bind_gender'] == 1)
					{
						$gender = 1;
					}else
					{
						$gender = 0;
					}
					$user_info_detail = array(
								'nickname'         => $bind_info['bind_nickname'],
								'user_avatar'      => $bind_info['bind_avator'],
								'user_gender'      => $gender,
								'user_avatar_thumb'=> $qq_logo,
						);
					

					$User_InfoDetail->editInfoDetail($user_name,$user_info_detail);

					$time = date('Y-m-d H:i:s',time());

					//插入绑定表
					$bind_array = array(
									'user_id'=>$user_id,
									'bind_time'=>$time,
									'bind_token'=>$token,
									);
					$User_BindConnectModel->editBindConnect($bind_info['bind_id'],$bind_array);
				}
				return $this->data->addBody(100, $arr_body);


			}else{
				$User_InfoDetail->sql->rollBack();
				$this->data->setError('创建用户信息失败');
			}
		}
		else
		{
			$msg    = '验证码错误';
			$status = 250;
			if(DEBUG!==true){
				$user_code_pre = "";
			}
			return $this->data->addBody(-1, array('code'=>$user_code_pre), $msg, $status);
		}
	}

	public function loginex()
	{
		$token = request_string('t');
		fb($token);
		$user_name = strtolower($_REQUEST['user_account']);

		if (!$user_name)
		{
			$user_name = strtolower($_REQUEST['user_name']);
		}

		$password = $_REQUEST['user_password'];

		$md5_password = $_REQUEST['md5_password'];

		if (!$password)
		{
			$password = $_REQUEST['password'];
		}

		if (!strlen($user_name))
		{
			$this->data->setError('请输入账号');
			return false;
		}
		

		if (!strlen($password)  && !strlen($md5_password))
		{
			$this->data->setError('请输入密码');
		}
		else
		{
			$User_InfoModel  = new User_InfoModel();
			$User_InfoDetail = new User_InfoDetailModel();
			$user_info_row   = $User_InfoModel->getInfoByName($user_name);

			if (!$user_info_row)
			{
				$this->data->setError('账号不存在');
				return false;
			}

			if($password)
			{
				$pswd =  md5($password);
			}
			if($md5_password)
			{
				$pswd = $md5_password;
			}
			if ($pswd != $user_info_row['password'])
			{
				$this->data->setError('密码错误');
			}
			else
			{
				//$session_id = uniqid();
				$session_id = $user_info_row['session_id'];

				$arr_field               = array();
				$arr_field['session_id'] = $session_id;

				//if ($User_InfoModel->editInfo($user_info_row['user_id'], $arr_field) > 0)
				if (true)
				{
					//$arr_body = array("result"=>1,"user_name"=>$user_info_row['user_name'],"session_id"=>$session_id);
					$arr_body           = $user_info_row;
					$arr_body['result'] = 1;
					//$arr_body['session_id'] = $session_id;

					$data            = array();
					$data['user_id'] = $user_info_row['user_id'];
					
					//$data['session_id'] = $session_id;
					$encrypt_str = Perm::encryptUserInfo($data, $session_id);

					$arr_body['k'] = $encrypt_str;

					//插入绑定表
					if($token)
					{
						//查找bind绑定表
						$User_BindConnectModel = new User_BindConnectModel();
						$bind_info = $User_BindConnectModel->getBindConnectByToken($token);
						
						$bind_info = $bind_info[0];

						//插入绑定表
						$time = date('Y-m-d H:i:s',time());
						$User_BindConnectModel = new User_BindConnectModel();
						$bind_array = array(
										'user_id'	=>$user_info_row['user_id'],
										'bind_time'	=>$time,
										'bind_token'=>$token,
										);
						$User_BindConnectModel->editBindConnect($bind_info['bind_id'],$bind_array);
						
					}

					$this->data->addBody(100, $arr_body);
					
				}
				else
				{
					$this->data->setError('登录失败');
				}
			}

		}


	}
	
	public function login()
	{
        var_dump($_REQUEST);
		$token = request_string('t');
		$type = request_int('type');

		$user_name = strtolower(request_string('user_account'));

		//查找bind绑定表
		$User_BindConnectModel = new User_BindConnectModel();

		if (!$user_name)
		{
			$user_name = strtolower(request_string('user_name'));
		}

		$password = $_REQUEST['user_password'];

		$md5_password = request_string('md5_password');

		if (!$password)
		{
			$password = request_int('password');
		}

		if (!strlen($user_name))
		{
			$this->data->setError('请输入账号');
			return false;
		}


		if (!strlen($password)  && !strlen($md5_password))
		{
			$this->data->setError('请输入密码');
		}
		else
		{
			$User_InfoModel  = new User_InfoModel();
			$User_InfoDetail = new User_InfoDetailModel();

			$bind_id = '';
			$user_info_row = array();
			//添加mobile绑定.
			//绑定标记：mobile/email/openid  绑定类型+openid
			{
				if (filter_var($user_name, FILTER_VALIDATE_EMAIL))
				{
					//邮件登录
					$bind_id = sprintf('email_%s', $user_name);
				}
				elseif (Yf_Utils_String::isMobile($user_name))
				{
					//手机号登录
					$bind_id = sprintf('mobile_%s', $user_name);
				}

				if ($bind_id)
				{
					//查找bind绑定表
					$User_BindConnectModel = new User_BindConnectModel();
					$bind_info = $User_BindConnectModel->getOne($bind_id);

					if ($bind_info)
					{
						//用户名登录
						$user_info_row   = $User_InfoModel->getOne($bind_info['user_id']);
					}
				}


				if ($user_info_row)
				{
				}
				else
				{
					//用户名登录
					$user_info_row   = $User_InfoModel->getInfoByName($user_name);
				}

			}

			if (!$user_info_row)
			{
				$this->data->setError('账号不存在');
				return false;
			}

			if($password)
			{
				$pswd =  md5($password);
			}
			if($md5_password)
			{
				$pswd = $md5_password;
			}
			if ($pswd != $user_info_row['password'])
			{
				$this->data->setError('密码错误');
			}
			else
			{
				if (3 == $user_info_row['user_state'])
				{
					$this->data->setError('用户已经锁定,禁止登录!');
					return false;
				}

				//$session_id = uniqid();
				$session_id = $user_info_row['session_id'];

				$arr_field               = array();
				$arr_field['session_id'] = $session_id;

				//if ($User_InfoModel->editInfo($user_info_row['user_id'], $arr_field) > 0)
				if($user_info_row['user_id'] != 0 && $token)
				{
					$bind_id_row = $User_BindConnectModel->getBindConnectByuserid($user_info_row['user_id'],$type);
					if($bind_id_row)
					{
						$this->data->setError('账号已绑定');
						return false;
					}
				}

				if (true)
				{
					//$arr_body = array("result"=>1,"user_name"=>$user_info_row['user_name'],"session_id"=>$session_id);
					$arr_body           = $user_info_row;
					$arr_body['result'] = 1;
					//$arr_body['session_id'] = $session_id;

					$data            = array();
					$data['user_id'] = $user_info_row['user_id'];

					//$data['session_id'] = $session_id;
					$encrypt_str = Perm::encryptUserInfo($data, $session_id);
					$arr_body['k'] = $encrypt_str;

					//插入绑定表
					if($token)
					{

						$bind_info = $User_BindConnectModel->getBindConnectByToken($token);

						$bind_info = $bind_info[0];

						//插入绑定表
						$time = date('Y-m-d H:i:s',time());
						$User_BindConnectModel = new User_BindConnectModel();
						$bind_array = array(
										'user_id'	=>$user_info_row['user_id'],
										'bind_time'	=>$time,
										'bind_token'=>$token,
										);
						$User_BindConnectModel->editBindConnect($bind_info['bind_id'],$bind_array);

					}

					//
					$info_row = $User_InfoDetail->getOne($user_info_row['user_name']);

					$arr_field_user_info_detail['user_count_login']    = $info_row['user_count_login'] + 1;
					$arr_field_user_info_detail['user_lastlogin_time'] = time();

					$User_InfoDetail->editInfoDetail($user_name, $arr_field_user_info_detail);

					$arr_body['mobile'] = $info_row['user_mobile'];
					$this->data->addBody(100, $arr_body);
					
				}
				else
				{
					$this->data->setError('登录失败');
				}
			}

		}

		if ($jsonp_callback = request_string('jsonp_callback'))
		{
			exit($jsonp_callback . '(' . json_encode($this->data->getDataRows()) . ')');
		}
	}


	/*
	 * 用户退出
	 *
	 *
	 */
	public function loginout()
	{
		if (isset($_COOKIE['key']) || isset($_COOKIE['id']))
		{
			setcookie("key", null, time() - 3600 * 24 * 365);
			setcookie("id", null, time() - 3600 * 24 * 365);
		}

		//如果已经登录,则直接跳转
		if (isset($_REQUEST['callback']))
		{
			$url = urldecode($_REQUEST['callback']);
		}
		else
		{
			$url = Yf_Registry::get('url');
		}


		if ('e' == $this->typ)
		{
			header('location:' . $url);
			die();
		}
		else
		{
			$this->data->addBody(-1, array());

			if ($jsonp_callback = request_string('jsonp_callback'))
			{
				exit($jsonp_callback . '(' . json_encode($this->data->getDataRows()) . ')');
			}
		}
	}

	public function logout()
	{
		$this->loginout();
	}

	/*
	 * 检测用户登录
	 */
	public function checkLogin()
	{
		if (Perm::checkUserPerm())
		{
			$msg = '数据正确';
			$status = 200;
			$data = Perm::$row;

			//user detail
			
			$User_InfoDetailModel = new User_InfoDetailModel();
			$data_info = $User_InfoDetailModel->getOne($data['user_name']);

			$data = array_merge($data, $data_info);

			if (!$data['user_avatar'])
			{
				$data['user_avatar'] =  Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
			}
			$data['k'] = $_COOKIE['key'];
			$data['u'] = $_COOKIE['id'];
			unset($data['password']);
			//unset($data['session_id']);
		}
		else
		{
			$msg = '权限错误';
			$status = 250;
			$data = array();
			$data['k'] = $_COOKIE['key'];
			$data['u'] = $_COOKIE['id'];
		}

		$this->data->addBody(100, $data, $msg, $status);
	}

	public function getUserByName()
	{
		$user_name = request_string('user_name');

		$User_InfoModel = new User_InfoModel();

		$user_id_row = $User_InfoModel->getInfoByName($user_name);

		$data = array();
		if($user_id_row)
		{
			$data = $user_id_row;
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

	public function checkMobile()
	{
		$mobile = request_string('mobile');
		//判断手机号是否已经注册过
		$User_InfoDetail = new User_InfoDetailModel();

		$checkmobile = $User_InfoDetail->checkMobile($mobile);
		$data   = array();
		if($checkmobile)
		{
			$msg    = 'failure';
			$status = 250;
		}
		else
		{
			$msg    = 'success';
			$status = 200;
		}
		$this->data->addBody(-140, $data, $msg, $status);
	}

	public function getUserInfoDetail()
	{
		$user_name = request_string('user_name');

		$User_InfoDetailModel = new User_InfoDetailModel();

		$user_info = $User_InfoDetailModel->getInfoDetail($user_name);
		
		$this->data->addBody(100, $user_info);

	}

	public function checkStatus()
	{
		$data = array();

		//如果已经登录,则直接跳转
		if (Perm::checkUserPerm())
		{
			$data = Perm::$row;

			$k = $_COOKIE[Perm::$cookieName];
			$u = $_COOKIE[Perm::$cookieId];


			$data['ks'] = $k;
			$data['us'] = $u;


			$msg    = '已登录';
			$status = 200;

		}
		else
		{
			$data = Perm::$row;
			$msg    = '未登录';
			$status = 250;
		}

		$this->data->addBody(-1, $data, $msg, $status);

		if ($jsonp_callback = request_string('jsonp_callback'))
		{
			exit($jsonp_callback . '(' . json_encode($this->data->getDataRows()) . ')');
		}
	}

    //门店帐号注册
    public function registerChain()
    {
        $user_name = request_string('user_account', null);
        $password  = request_string('user_password', null);

        $server_id = 0;

        if (!$user_name)
        {
            return $this->data->addBody(-1, array(), '请输入账号', 250);
        }

        if (!$password)
        {
            return $this->data->addBody(-1, array(), '请输入密码', 250);
        }


        $rs_row = array();

        //用户是否存在
        $User_InfoModel  = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();

        $user_rows = $User_InfoModel->getInfoByName($user_name);

        if ($user_rows)
        {
            $arr_body = array(
                "user_name" => $user_name,
                "user_id" => $user_rows['user_id']
            );
            return $this->data->addBody(-1, $arr_body, '用户名已经存在', 250);
        }
        else
        {

            $User_InfoModel->sql->startTransaction();

            $Db       = Yf_Db::get('ucenter');
            $seq_name = 'user_id';
            $user_id  = $Db->nextId($seq_name);

            //$User_InfoModel->check_input($user_name, $password, $user_mobile);

            $now_time = time();
            $ip       = get_ip();

            $session_id                         = uniqid();
            $arr_field_user_info                = array();
            $arr_field_user_info['user_id']     = $user_id;
            $arr_field_user_info['user_name']   = $user_name;
            $arr_field_user_info['password']    = md5($password);
            $arr_field_user_info['action_time'] = $now_time;
            $arr_field_user_info['action_ip']   = $ip;
            $arr_field_user_info['session_id']  = $session_id;

            $flag = $User_InfoModel->addInfo($arr_field_user_info);
            array_push($rs_row, $flag);

            $arr_field_user_info_detail                        = array();
            $arr_field_user_info_detail['user_name']           = $user_name;
            $arr_field_user_info_detail['user_mobile']         = $mobile;
            //$arr_field_user_info_detail['user_mobile_verify']         = 1;
            $arr_field_user_info_detail['user_reg_time']       = $now_time;
            $arr_field_user_info_detail['user_count_login']    = 1;
            $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
            $arr_field_user_info_detail['user_lastlogin_ip']   = $ip;
            $arr_field_user_info_detail['user_reg_ip']         = $ip;

            $flag = $User_InfoDetail->addInfoDetail($arr_field_user_info_detail);
            array_push($rs_row, $flag);

        }

        $app_id   = isset($_REQUEST['app_id']) ? $_REQUEST['app_id'] : 0;
        $Base_App = new Base_AppModel();

        if ($app_id && !($base_app_rows = $Base_App->getApp($app_id)))
        {
            /*
            $base_app_row = array_pop($base_app_rows);

            $arr_field_user_app = array();
            $arr_field_user_app['user_name'] = $user_name;
            $arr_field_user_app['app_id'] = $app_id;
            $arr_field_user_app['active_time'] = time();

            $User_App = new User_AppModel();

            //是否存在
            $user_app_row = $User_App->getAppByNameAndAppId($user_name, $app_id);

            if ($user_app_row)
            {
                // update app_quantity
                $app_quantity_row = array();
                $app_quantity_row['app_quantity'] = $user_app_row['app_quantity'] + 1;
                $flag = $User_App->editApp($user_name, $app_quantity_row);
                array_push($rs_row, $flag);
            }
            else
            {

                $flag = $User_App->addApp($arr_field_user_app);
                array_push($rs_row, $flag);

            }

            $User_AppServerModel = new User_AppServerModel();

            $user_app_server_row = array();
            $user_app_server_row['user_name'] = $user_name;
            $user_app_server_row['app_id'] = $app_id;
            $user_app_server_row['server_id'] = $server_id;
            $user_app_server_row['active_time'] = time();

            $flag = $User_AppServerModel->addAppServer($user_app_server_row);
            */
        }
        else
        {
        }

        if (is_ok($rs_row) && $User_InfoDetail->sql->commit())
        {
            $d            = array();
            $d['user_id'] = $user_id;

            $encrypt_str = Perm::encryptUserInfo($d, $session_id);

            $arr_body = array(
                "user_name" => $user_name,
                "server_id" => $server_id,
                "k" => $encrypt_str,
                "user_id" => $user_id
            );
            $this->data->addBody(100, $arr_body,'sucess',200);
        }
        else
        {
            $Base_App->sql->rollBack();
            return $this->data->addBody(-1, array(), '创建用户信息失败', 250);
        }

    }



	public function regConfig()
	{
		$Web_ConfigModel = new Web_ConfigModel();

		$config_type_row = request_row('config_type');

		fb($config_type_row);
		$rs_row = array();
		foreach ($config_type_row as $config_type)
		{
			$config_value_row = request_row($config_type);

			fb($config_value_row);

			$config_rows = $Web_ConfigModel->getByWhere(array('config_type' => $config_type));

			fb($config_rows);

			foreach ($config_rows as $config_key => $config_row)
			{
				$edit_row = array();

				if (isset($config_value_row[$config_key]))
				{
					if ('json' == $config_row['config_datatype'])
					{
						$edit_row['config_value'] = json_encode($config_value_row[$config_key]);
					}
					else
					{
						$edit_row['config_value'] = $config_value_row[$config_key];
					}
				}
				else
				{
					if ('number' == $config_row['config_datatype'])
					{
						if ('theme_id' != $config_key)
						{
							//$edit_row['config_value'] = 0;
						}
					}
					else
					{
					}
				}

				if ($edit_row)
				{
					$flag = $Web_ConfigModel->editConfig($config_key, $edit_row);

					check_rs($flag, $rs_row);
				}
			}
		}

		$flag = is_ok($rs_row);

		if($flag)
		{
			$msg    = 'success';
			$status = 200;
		}
		else
		{
			$msg    = 'failure';
			$status = 250;
		}
		$this->data->addBody(-1, $edit_row, $msg, $status);
	}
    
    public function checkEmail(){
		$email = request_string('email');

		//判断邮箱号是否已经注册过
		$User_InfoDetail = new User_InfoDetailModel();
		$checkmobile = $User_InfoDetail->checkEmail($email);
		$data   = array();
		if($checkmobile)
		{
			$msg    = 'failure';
			$status = 250;
		}else{
			$msg    = 'success';
			$status = 200;
		}
		$this->data->addBody(-140, $data, $msg, $status);
    }
    
    /**
     *  缓存验证码
     * @param type $key
     * @param type $value
     * @param type $group
     * @return type
     */
    public function _saveCodeCache($key,$value,$group='default'){
        $config_cache = Yf_Registry::get('config_cache');
        if (!file_exists($config_cache[$group]['cacheDir'])){
            mkdir($config_cache[$group]['cacheDir']);
        }
        $Cache_Lite = new Cache_Lite_Output($config_cache[$group]);
        $result = $Cache_Lite->save($value, $key);
        return $result;
    }

	//判断用户是否绑定手机号
	public function checkUserMobile()
	{
		$user_id = request_int('user_id');

		//查找绑定表
		$User_BindConnectModel = new User_BindConnectModel();
		$bind_id_row = $User_BindConnectModel->getBindConnectByuserid($user_id,User_BindConnectModel::MOBILE);

		if($bind_id_row)
		{
			$msg    = 'success';
			$status = 200;
		}else{
			$msg    = 'failure';
			$status = 250;
		}
		$this->data->addBody(-140, array(), $msg, $status);
	}

	public function editNickName()
	{
		$nickname = request_string("nickname");
		$token = request_string('token');

		if (!$nickname || !$token) {
			return $this->data->setError('无效用户名');
		}

		$User_BindConnectModel = new User_BindConnectModel();
		$bind_info = $User_BindConnectModel->getBindConnectByToken($token);
		$bind_info = current($bind_info);

		if (! $bind_info) {
			return $this->data->setError('绑定账号不存在');
		}

		//判断绑定账户是否已经绑定过用户，已经绑定过用户的账号，不可重复绑定
		if ($bind_info['user_id']) {
			return $this->data->setError('该账号已经绑定用户');
		}

		//判断该账号名是否已经存在
		$User_InfoModel  = new User_InfoModel();
		$User_InfoDetail = new User_InfoDetailModel();
		$user_rows = $User_InfoModel->getInfoByName($nickname);

		//如果用户名已经存在了，则在用户名后面添加随机数
		if ($user_rows) {
			return $this->data->setError('已存在该用户名');
		}

		$bind_id = $bind_info['bind_id'];
		$flag = $User_BindConnectModel->editBindConnect($bind_id, ['bind_nickname'=> $nickname]);

		if ($flag) {
			$msg = __('修改成功');
			$status = 200;
		} else {
			$msg = __('修改失败');
			$status = 250;
		}

		$this->data->addBody(-140, ['bind_nickname'=> $nickname], $msg, $status);
	}
}

?>