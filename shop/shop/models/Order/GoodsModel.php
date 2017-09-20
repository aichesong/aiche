<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Order_GoodsModel extends Order_Goods
{
	const EVALUATION_YES = 1;        //已评价
	const EVALUATION_NO  = 0;        //未评价
	const EVALUATION_AGAIN  = 2;     //追加评价
	const REFUND_NO      = 0;  //无退款退货
	const REFUND_IN      = 1;	//退款退货中
	const REFUND_COM     = 2;  //退款退货完成
	const REFUND_REF     = 3;  //商户不同意退款退货

	/**
	 * 读取分页列表
	 *
	 * @param  int $goods_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getBaseList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		$data            = $this->listByWhere($cond_row, $order_row, $page, $rows);
		$Order_BaseModel = new Order_BaseModel();
		if ($data['items'])
		{
			foreach ($data['items'] as $key => $val)
			{
				$order_base                                 = $Order_BaseModel->getOne($val['order_id']);
				$data['items'][$key]['buyer_user_name']     = $order_base['buyer_user_name'];
				$data['items'][$key]['order_finished_time'] = $order_base['order_finished_time'];
			}
		}
		return $data;
	}

	/**
	 * 商品销售列表
	 *
	 * @author Zhuyt
	 */
	public function getGoodSaleList($cond_row = array(), $order_row = array(), $page, $rows)
	{
		$data = $this->listByWhere($cond_row, $order_row, $page, $rows);

		$Order_BaseModel = new Order_BaseModel();
		if ($data['items'])
		{
			foreach ($data['items'] as $key => $val)
			{
				$order = $Order_BaseModel->getOne($val['order_id']);

				$data['items'][$key]['order'] = $order;
			}
		}

		fb($data);
		return $data;
	}

	/**
	 * 商品销售数量
	 *
	 * @author Zhuyt
	 */
	public function getGoodsSaleNum($goods_id = null)
	{
		$data = $this->listByWhere(array('goods_id' => $goods_id));

		$count = count($data['items']);

		return $count;
	}

	/**
	 * 获取订单产品列表
	 *
	 * @param  int $goods_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getGoodsListByOrderId($order_id, $order_row = array(), $page = 1, $rows = 100)
	{
		if (is_array($order_id))
		{
			$cond_row = array('order_id:IN' => $order_id);
		}
		else
		{
			$cond_row = array('order_id' => $order_id);
		}

		return $this->listByWhere($cond_row);
	}

	/**
	 * 获取订单产品详情
	 *
	 * @param  int $order_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getGoodsDetail($cond_row)
	{

		return $this->getOneByWhere($cond_row);
	}


	/**
	 * @param $common_id
	 * @param $time array
	 * @return number
	 * 获取用户购买商品数量
	 */
	public function getGoodsPurchaseNumByUser($common_id, $time = [])
	{
		$user_id = Perm::$userId;

		//有效订单状态
		$order_goods_status = [
			Order_StateModel::ORDER_PAYED, //已付款
			Order_StateModel::ORDER_WAIT_PREPARE_GOODS, //待发货
			Order_StateModel::ORDER_WAIT_CONFIRM_GOODS, //已发货
			Order_StateModel::ORDER_RECEIVED, //已签收
			Order_StateModel::ORDER_FINISH, //已完成
		];

		//筛选条件
		$condi = [
			'order_goods_status:IN'=> $order_goods_status,
			'buyer_user_id'=> $user_id,
			'common_id'=> $common_id
		];

		if (! empty($time)) {
			$condi['order_goods_time:>='] = $time['start_time'];
			$condi['order_goods_time:<='] = $time['end_time'];
		}
		
		$order_goods_rows = $this->getByWhere($condi);

		//没有购买记录
		if (empty($order_goods_rows)) {
			return 0;
		}

		return array_sum(array_column($order_goods_rows, 'order_goods_num'));
	}
    
    /**
     * 根据条件获取商品的售卖数量
     */
    public function getOrderGoodsNum($cond_row){
        $count = $this->getCount($cond_row);
        $list = $this->getByWhere($cond_row,array(),1,$count);
        $num = 0;
        if($list){
            foreach ($list as $value){
                $num += $value['order_goods_num'];
            }
        }
        
        return $num;
    }
    
 
}

?>