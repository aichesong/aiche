<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class User_BaseModel extends User_Base
{

	/**
	 * 读取分页列表
	 *
	 * @param  int $user_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getBaseList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		return $this->getByWhere($cond_row, $order_row, $page, $rows);
	}

	public function getBaseIdByAccount($user_account = null)
	{
		$data = $this->getByWhere(array('user_account' => $user_account));

		return $data['items'];
	}
	
	/**
	 * 读取会员信息
	 *
	 * @param  int $user_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getUserInfo($order_row = array())
	{
		return $this->getOneByWhere($order_row);
	}

	public function getUserIdByAccount($user_account)
	{
		$user_id_row = array();

		$this->_multiCond['user_account'] = $user_account;

		$user_id_row = $this->getKeyByMultiCond($this->_multiCond);

		return $user_id_row;
	}

	/**
	 * 根据账号获取店铺信息
	 *
	 * @param $user_account int
	 * @return array
	 */
	public function getStoreInfoByUserAccount ($user_account)
	{
		$user_rows = $this->getByWhere(['user_account'=> $user_account]);

		if (empty($user_rows)) { //没有对应用户信息
			return [];
		}

		$user_data = current($user_rows);
		$user_id = $user_data['user_id'];

		$shopBaseModel = new Shop_BaseModel();
		$shop_rows = $shopBaseModel->getByWhere(['user_id'=> $user_id]);

		if (empty($shop_rows)) { //没有对应店铺信息
			return [];
		}

		$shop_data = current($shop_rows);

		return $shop_data;
	}
}

?>