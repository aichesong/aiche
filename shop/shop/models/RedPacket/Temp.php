<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 *
 *
 * @category   Framework
 * @package    __init__
 * @author     Xinze <xinze@live.cn>
 * @copyright  Copyright (c) 2010, 黄新泽
 * @version    1.0
 * @todo
 */
class RedPacket_Temp extends Yf_Model
{
	public $_cacheKeyPrefix  = 'c|redpacket_template|';
	public $_cacheName       = 'redpacket';
	public $_tableName       = 'redpacket_template';
	public $_tablePrimaryKey = 'redpacket_t_id';

	/**
	 * @param string $user User Object
	 * @var   string $db_id 指定需要连接的数据库Id
	 * @return void
	 */
	public function __construct(&$db_id = 'shop', &$user = null)
	{
		$this->_tableName = TABEL_PREFIX . $this->_tableName;
		$this->_cacheFlag = CHE;
		parent::__construct($db_id, $user);
	}

	/**
	 * 根据主键值，从数据库读取数据
	 *
	 * @param  int $redpacket_t_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getRedPacketTempByWhere($cond_row, $order_row = array())
	{
		$rows = array();
		$rows = $this->getOneByWhere($cond_row, $order_row);
		if ($rows)
		{
			$rows['redpacket_t_end_date'] = date("Y-m-d", strtotime($rows['redpacket_t_end_date']));
		}

		return $rows;
	}

	public function getRedPacketTempById($redpacket_t_id = null, $sort_key_row = null)
	{
		$rows = array();
		$rows = $this->getOne($redpacket_t_id, $sort_key_row);

		return $rows;
	}


	/**
	 * 更新单个字段
	 * @param mix $redpacket_t_id
	 * @param array $field_row_name
	 * @param array $field_row_value_new
	 * @param array $field_row_value_old
	 * @return bool $update_flag 是否成功
	 * @access public
	 */
	public function editRedPacketTempSingleField($redpacket_t_id, $field_row_name, $field_row_value_new, $field_row_value_old)
	{
		$update_flag = $this->editSingleField($redpacket_t_id, $field_row_name, $field_row_value_new, $field_row_value_old);

		return $update_flag;
	}

}

?>