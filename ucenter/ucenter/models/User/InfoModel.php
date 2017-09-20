<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class User_InfoModel extends User_Info
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
	public function getInfoList($cond_row = array(), $order_row = array(), $page=1, $rows=100)
	{
		$data = $this->listByWhere($cond_row, $order_row, $page, $rows);
		foreach ($data["items"] as $key => $value)
		{
			$data["items"][$key]["user_gender1"] = _(User_InfoModel::$userSex[$value["user_gender"]]);
		}
		return  $data;
	}


	public function getInfoByName($user_name)
	{
		$data = array();

		$this->sql->setWhere('user_name', $user_name);
		$data_rows = $this->getInfo('*');

		if ($data_rows)
		{
			$data = array_pop($data_rows);
		}

		return $data;
	}


	public function getUserIdByName($user_name=null)
	{
		$data = array();

		$this->sql->setWhere('user_name', $user_name, 'IN');
		$data_rows = $this->selectKeyLimit();

		if ($data_rows)
		{
			$data = array_pop($data_rows);
		}

		return $data;
	}

	public function userlogin($uid=null)
	{
		$user_info_row = $this->getInfo($uid);
		$user_info_row = array_values($user_info_row);
		$user_info_row = $user_info_row[0];
		$session_id = $user_info_row['session_id'];

		$arr_field = array();
		$arr_field['session_id'] = $session_id;

		if($user_info_row)
		{
			$arr_body = $user_info_row;
			$arr_body['result'] = 1;

			$data = array();
			$data['user_id'] = $user_info_row['user_id'];

			$encrypt_str = Perm::encryptUserInfo($data, $session_id);

			$arr_body['k']=$encrypt_str;
		}
		else
		{
			$arr_body = array();
		}

		return $arr_body;
	}
}
?>