<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class RedPacket_BaseModel extends RedPacket_Base
{
	const UNUSED  = 1;   	//未使用
	const USED    = 2;      //已使用
	const EXPIRED = 3;  	//过期
	

	public static $redpacketState = array(
		self::UNUSED => "未用",
		self::USED => "已用",
		self::EXPIRED => "过期"
	);

	/**
	 * 读取分页列表
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getRedPacketList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		$data = $this->listByWhere($cond_row, $order_row, $page, $rows);
        $expire_row = array();
		foreach ($data["items"] as $key => $value)
		{
			$data["items"][$key]["redpacket_state_label"] = __(self::$redpacketState[$value["redpacket_state"]]);

            if (strtotime($value['redpacket_end_date']) < time())
            {
                $data['items'][$key]['redpacket_state']        = self::EXPIRED;
                $data['items'][$key]['redpacket_state_label'] = __(self::$redpacketState[self::EXPIRED]);
                $expire_row[]                                     = $value['redpacket_id'];
            }
		}

        $this->editRedPacket($expire_row, array('redpacket_state'=>self::EXPIRED));

		return $data;
	}

	//获取用户所有的平台优惠券数量
	public function getAllRedPacketCountByUserId($user_id)
	{
		$cond_row['redpacket_owner_id'] = $user_id;
		return $this->getNum($cond_row);
	}

	//获取用户可用的平台优惠券数量
	public function getAvaRedPacketCountByUserId($user_id)
	{
		$cond_row['redpacket_owner_id']      = $user_id;
		$cond_row['redpacket_start_date:<='] = get_date_time();
		$cond_row['redpacket_end_date:>=']   = get_date_time();
		$cond_row['redpacket_state']         = self::UNUSED;
		return $this->getNum($cond_row);
	}

	public function getRedPacketNumByWhere($cond_row)
	{
        return $this->getNum($cond_row);
	}

	/**
	 * 读取列表
	 *
	 * @param  int $config_key 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getConfigList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		return $this->getByWhere($cond_row, $order_row, $page, $rows);
	}

	//获取用户可使用的店铺平台优惠券
	public function getUserOrderRedPacketByWhere($user_id)
	{
		$cond_row                     	= array();
		$cond_row['redpacket_owner_id'] = $user_id;
		$cond_row['redpacket_state']    = self::UNUSED;
		$order_row['redpacket_id'] 		= 'DESC';
		$rows                      = $this->getByWhere($cond_row, $order_row);
		if ($rows)
		{
			$expire_redpacket = array();
			foreach ($rows as $key => $value)
			{
				if (strtotime($value['redpacket_end_date']) < time())
				{
					$expire_redpacket[] = $value['redpacket_id'];
					unset($rows[$key]); //过期的平台优惠券
				}
			}

			$this->editRedPacket($expire_redpacket, array('redpacket_state' => self::EXPIRED));
		}
		return $rows;
	}

	//平台优惠券使用后，更改状态
	public function changeRedPacketState($redpacket_id, $order_id)
	{
		$rs_row = array();

		$field_row['redpacket_order_id'] = $order_id;
		$field_row['redpacket_state']    = RedPacket_BaseModel::USED;
		$update_flag                   = $this->editRedPacket($redpacket_id, $field_row);
		check_rs($update_flag, $rs_row);

		$redpacket_row = $this->getOne($redpacket_id);

		if ($redpacket_row) //更新平台优惠券模板中平台优惠券已使用数量
		{
			$RedPacket_TempModel = new RedPacket_TempModel();
			$edit_flag         = $RedPacket_TempModel->editRedPacketTemplate($redpacket_row['redpacket_t_id'], array('redpacket_t_used' => 1), true);
			check_rs($edit_flag, $rs_row);
		}

		return is_ok($rs_row);
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