<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class IndexCtl extends Yf_AppController
{
    public function index()
    {
		//如果已经登录,则直接跳转
		if (!Perm::checkUserPerm())
		{
			$data = Perm::$row;

			$k = $_COOKIE[Perm::$cookieName];
			$u = $_COOKIE[Perm::$cookieId];

			if (isset($_REQUEST['callback']) && $_REQUEST['callback'] )
			{
				$url = $_REQUEST['callback'] . '&us=' . $u . '&ks=' . urlencode($k);

			}
			else
			{
				$url = './index.php?ctl=Login';
			}

			header('location:' . $url);
		}

		$url = './index.php?ctl=User&met=getUserInfo';

		header('location:' . $url);
        //include $this->view->getView();
    }

    public function main()
    {
		include $this->view->getView();
    }

	public function img()
	{
		$user_id = request_int('user_id');

		if ($user_id)
		{
			$User_InfoModel = new User_InfoModel();
			$user_row = $User_InfoModel->getOne($user_id);

			if ($user_row)
			{
				$User_InfoDetailModel = new User_InfoDetailModel();
				$user_info_row = $User_InfoDetailModel->getOne($user_row['user_name']);

				//原图
				if ($user_info_row['user_avatar'])
				{
					location_to($user_info_row['user_avatar']);
				}
				else
				{
					$img_url = Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
					location_to($img_url);
				}
			}
			else
			{
				$img_url = Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
				location_to($img_url);
			}
		}
		else
		{
			$img_url = Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
			location_to($img_url);
		}
	}

}
?>