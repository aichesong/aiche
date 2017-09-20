<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class Consume_TradeModel extends Consume_Trade
{
	/**
	 * 读取分页列表
	 *
	 * @param  int $consume_trade_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getTradeList($consume_trade_id = null, $page=1, $rows=100, $sort='asc')
	{
		//需要分页如何高效，易扩展
		$offset = $rows * ($page - 1);

		$this->sql->setLimit($offset, $rows);

		$consume_trade_id_row = array();
		$consume_trade_id_row = $this->selectKeyLimit();

		//读取主键信息
		$total = $this->getFoundRows();

		$data_rows = array();

		if ($consume_trade_id_row)
		{
			$data_rows = $this->getTrade($consume_trade_id_row);
		}

		$data = array();
		$data['page'] = $page;
		$data['total'] = ceil_r($total / $rows);  //total page
		$data['totalsize'] = $data['total'];
		$data['records'] = count($data_rows);
		$data['items'] = array_values($data_rows);

		return $data;
	}

	/**
	 * 根据订单号读取信息
	 *
	 * @param  int $order_id 订单id
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getTradeByOrderId($order_id)
	{
		$cond_row = array('order_id'=>$order_id);

		$row = array();
		$rows = $this->getMultiCond($cond_row);
		if ($rows)
		{
			$row = reset($rows);
		}

		return $row;
	}

	public function getTradeByState($user_id = null,$status = null,$type = null)
	{
		if($status)
		{
			$this->sql->setWhere('order_state_id',$status);
		}
		if($type == 1)//1-卖家
		{
			$this->sql->setWhere('seller_id',$user_id);
		}
		if($type == 2)//2-买家
		{
			$this->sql->setWhere('buy_id',$user_id);
		}

		$data = $this->getTrade("*");
		return $data;
	}

	public function getConsumeTradeByOid($order_id = null)
	{
		$this->sql->setWhere('order_id',$order_id);
		$data = $this->getTrade("*");

		$data = current($data);

		return $data;
	}

	public function editConsumeTrade($order_id = null,$edit_uorder_row = array())
	{
        if(!is_array($order_id)){
            $order_ids = explode(",",$order_id);
            $order_ids[] = $order_id;
        }else{
            $order_ids = $order_id;
        }
        
		//修改支付订单支付类型
        $Union_OrderModel = new Union_OrderModel();
		$uorder_row = $Union_OrderModel->getByWhere(array('inorder:IN' => $order_ids));
		$uorder_id_row = array_column($uorder_row,'union_order_id');
		
		$Union_OrderModel->editUnionOrder($uorder_id_row,$edit_uorder_row);
        
        //更新交易记录表的支付类型
        if($edit_uorder_row['payment_channel_id'] == Payment_ChannelModel::BAITIAO){
            $edit_uorder_row['trade_payment_amount'] = 0;
        }
        $retsult = $this->editTrade($order_ids,$edit_uorder_row);
        
        return $retsult;
	}

	//白条订单还款
	//$user_id  还款用户id
	//$user_return_credit 还款金额
	public function returnCredit($user_id,$user_return_credit)
	{
		//查找出所有用白条支付并且trade_payment_amount 小于 order_payment_amount
		$sql = "
					SELECT
						*
					FROM
						" . TABEL_PREFIX . "consume_trade where buyer_id=".$user_id." and payment_channel_id=".Payment_ChannelModel::BAITIAO." and trade_payment_amount < order_payment_amount ORDER BY trade_create_time asc
					";
		$rows = $this->sql->getAll($sql);

		foreach($rows as $key => $val)
		{
			$edit_row = array();
			$diff = $val['order_payment_amount'] - $val['trade_payment_amount'];
			//如果该笔订单剩余应还金额大于还款金额，则该笔订单部分还款。否则该笔订单全额还款。
			if($diff >= $user_return_credit)
			{
				$edit_row['trade_payment_amount'] = $val['trade_payment_amount'] + $user_return_credit;
				$user_return_credit = 0;
			}
			else
			{
				$edit_row['trade_payment_amount'] = $val['order_payment_amount'];
				$user_return_credit = $user_return_credit - $diff;
			}

			$result = $this->editTrade($val['consume_trade_id'],$edit_row);

			if($user_return_credit == 0)
			{
				break;
			}

		}

		return $result;

	}

	public function getTradeId($symbol = null)
	{
		$sql = "
					SELECT
						consume_trade_id
					FROM
						" . TABEL_PREFIX . "consume_trade where payment_channel_id=9 ". $symbol ."
					";
		$rows = $this->sql->getAll($sql);

		if($rows)
		{
			$rows = array_column($rows,'consume_trade_id');
		}

		return $rows;
	}
}
?>