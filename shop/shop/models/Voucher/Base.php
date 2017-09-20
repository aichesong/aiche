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
class Voucher_Base extends Yf_Model
{
	public $_cacheKeyPrefix  = 'c|voucher_base|';
	public $_cacheName       = 'base';
	public $_tableName       = 'voucher_base';
	public $_tablePrimaryKey = 'voucher_id';

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
	 * @param  int $voucher_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getVoucher($voucher_id = null, $sort_key_row = null)
	{
		$rows = array();
		$rows = $this->get($voucher_id, $sort_key_row);

		return $rows;
	}

	/**
	 * 插入
	 * @param array $field_row 插入数据信息
	 * @param bool $return_insert_id 是否返回inset id
	 * @param array $field_row 信息
	 * @return bool  是否成功
	 * @access public
	 */
	public function addVoucher($field_row, $return_insert_id = false)
	{
		$add_flag = $this->add($field_row, $return_insert_id);

		return $add_flag;
	}

	/**
	 * 根据主键更新表内容
	 * @param mix $voucher_id 主键
	 * @param array $field_row key=>value数组
	 * @return bool $update_flag 是否成功
	 * @access public
	 */
	public function editVoucher($voucher_id, $field_row)
	{
		$update_flag = $this->edit($voucher_id, $field_row);

		return $update_flag;
	}

	/**
	 * 更新单个字段
	 * @param mix $voucher_id
	 * @param array $field_name
	 * @param array $field_value_new
	 * @param array $field_value_old
	 * @return bool $update_flag 是否成功
	 * @access public
	 */
	public function editVoucherSingleField($voucher_id, $field_name, $field_value_new, $field_value_old)
	{
		$update_flag = $this->editSingleField($voucher_id, $field_name, $field_value_new, $field_value_old);

		return $update_flag;
	}

	/**
	 * 删除操作
	 * @param int $voucher_id
	 * @return bool $del_flag 是否成功
	 * @access public
	 */
	public function removeVoucher($voucher_id)
	{
		$del_flag = $this->remove($voucher_id);
		
		return $del_flag;
	}
    
    
    /**
     * 根据条件返回主键id
     * @param type $cond_row
     * @param type $order_row
     * @return type
     */
    public function getId($cond_row,$order_row=array()){
        $key_rows = $this->getKeyByMultiCond($cond_row, $order_row);
        return $key_rows;
    }
    
    /**
	 * 读数量
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getCount($cond_row = array())
	{
		return $this->getNum($cond_row);
	}
}

?>