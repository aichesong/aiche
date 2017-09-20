<?php if (!defined('ROOT_PATH')) exit('No Permission');
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
	public function getBaseList($user_id = null, $page=1, $rows=100, $sort='asc')
	{
		//需要分页如何高效，易扩展
		$offset = $rows * ($page - 1);

		$this->sql->setLimit($offset, $rows);

		$user_id_row = array();
		$user_id_row = $this->selectKeyLimit();

		//读取主键信息
		$total = $this->getFoundRows();

		$data_rows = array();

		if ($user_id_row)
		{
			$data_rows = $this->getBase($user_id_row);
		}

		$data = array();
		$data['page'] = $page;
		$data['total'] = ceil_r($total / $rows);  //total page
		$data['totalsize'] = $data['total'];
		$data['records'] = count($data_rows);
		$data['items'] = array_values($data_rows);

		return $data;
	}

	public function getBaseIdByAccount($user_account = null)
	{
		$this->sql->setWhere('user_account',$user_account);
		$data = $this->selectKeyLimit();

		return $data;
	}
	
	/**
	 * 读取一个会员信息
	 *
	 * @param  array $order 查询条件
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getUserBase($order_row = array())
	{
		return $this->getOneByWhere($order_row);
	}
        
        public function  getPayBaseList($cond_row = array(),$order_row = array(), $page=1, $rows=20, $sort='asc')
        {
            $getBaseList = $this->listByWhere($cond_row ,$order_row, $page, $rows, $sort);
            $user_resource = new User_ResourceModel();
            foreach ($getBaseList['items'] as $key => $value)
			{
                    $user_resource_list =$user_resource->getone($value['user_id']);
                    $getBaseList['items'][$key] = array_merge($getBaseList['items'][$key], $user_resource_list);
            }
           
            return $getBaseList;
        }
}
?>