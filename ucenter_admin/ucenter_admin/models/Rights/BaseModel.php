<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class Rights_BaseModel extends Rights_Base
{

	/**
	 * 读取分页列表
	 *
	 * @param  int $rights_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getRightsList($rights_id = null, $page=1, $rows=100, $sort='asc')
	{
		//需要分页如何高效，易扩展
		$offset = $rows * ($page - 1);

		$this->sql->setLimit($offset, $rows);

		$rights_id_row = array();
		$rights_id_row = $this->selectKeyLimit();

		//读取主键信息
		$total = $this->getFoundRows();

		$data_rows = array();

		if ($rights_id_row)
		{
			$data_rows = $this->getRights($rights_id_row);
		}

		$data = array();
		$data['page'] = $page;
		$data['total'] = ceil_r($total / $rows);  //total page
		$data['totalsize'] = $data['total'];
		$data['records'] = count($data_rows);
		$data['items'] = array_values($data_rows);

		return $data;
	}
}
?>