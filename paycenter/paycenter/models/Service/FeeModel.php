<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class Service_FeeModel extends Service_Fee
{

	/**
	 * 读取分页列表
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getFeeList($cond_row, $page=1, $rows=100, $sort='asc')
	{
            return $this->listByWhere($cond_row);
	}


	/*
	 * 获取config
	 */
	public function getFeeById($id)
	{
		$this->sql->setWhere('id',$id);
		$data = $this->getFee("*");

		return $data;
	}

}
?>