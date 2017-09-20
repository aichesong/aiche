<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class Api_UpdateCtl extends Yf_AppController
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
	}

	/**
	 * 检测证书正确与否
	 *
	 * @access public
	 */
	public function checkLicence()
	{
		$licence_key = request_string('licence_key');
		$env_row['domain'] = request_string('domain', @$_SERVER['HTTP_REFERER']);

		$lic = new Yf_Licence_Maker();
		$res = $lic->check($licence_key, file_get_contents(APP_PATH . '/data/licence/public.pem'), $env_row);

		if ($res)
		{
			$status = 200;
			$msg = _('success');
		}
		else
		{
			$data['licence_key']            = $licence_key  ; // 授权码
			$data['licence_log_domain']     = $env_row['domain']; // 域名

			$data['licence_log_date']       = date('Y-m-d'); // 有效期开始与结束1
			$data['licence_log_state']      = 0; //

			$Base_AppLicenceLogModel = new Base_AppLicenceLogModel();
			$Base_AppLicenceLogModel->addAppLicenceLog($data);


			$status = 250;
			$msg = _('failure');
		}


		if ('json' == $this->typ)
		{
			$this->data->addBody(-140, array(), $msg, $status);
		}
		else
		{
			include $this->view->getView();
		}
	}
}
?>