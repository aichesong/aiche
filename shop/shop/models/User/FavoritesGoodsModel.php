<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class User_FavoritesGoodsModel extends User_FavoritesGoods
{

	/**
	 * 读取分页列表
	 *
	 * @param  array $cond_row 查询条件
	 * @param  array $order_row 排序信息
	 * @param  array $page 当前页码
	 * @param  array $rows 每页记录数
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getFavoritesGoodsList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		return $this->listByWhere($cond_row, $order_row, $page, $rows);
	}
	
	
	/**
	 * 读取收藏商品
	 *
	 * @param  array $order_row 查询条件
	 * @return array $data 返回的查询内容
	 * @access public
	 */
	public function getFavoritesGoodsAll($order_row)
	{
		$data = $this->getByWhere($order_row);

		return $data;
	}

	/**
	 * 读取一个收藏商品
	 *
	 * @param  array $order_row 查询条件
	 * @return array $data 返回的查询内容
	 * @access public
	 */
	public function getFavoritesGoods($order_row)
	{
		$data = $this->getOneByWhere($order_row);

		return $data;
	}
	
	/**
	 * 读取收藏商品及详情，必需传递user_id
	 *
	 * @param  array $cond_row 查询条件
	 * @param  array $order_row 排序信息
	 * @param  array $page 当前页码
	 * @param  array $rows 每页记录数
	 * @return array $data 返回的查询内容
	 * @access public
	 */
	public function getFavoritesGoodsDetail($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		$data = array();
		$data = $this->listByWhere($cond_row, $order_row);

		if ($data['items'])
		{
			$goods_id_row = array();
			$goods_id_row = array_column($data['items'], 'goods_id');
			
			$this->goodsBaseModel = new Goods_BaseModel();

			$de   = $this->goodsBaseModel->getGoodsListByGoodId($goods_id_row);
			$data = array();
			if ($de)
			{
				//查出有详情的商品
				
				$goods_id_row  = array();
				$goods_id_rows = array_column($de, 'goods_id');

				$goods_id_row['goods_id: in'] = $goods_id_rows;
				
				$goods_id_row['user_id'] = $cond_row['user_id'];

				$data = $this->listByWhere($goods_id_row, $order_row, $page, $rows);

				foreach ($data['items'] as $key => $val)
				{
					
					if (in_array($val['goods_id'], $goods_id_rows))
					{
						$data['items'][$key]['detail'] = $de[$val['goods_id']];
					}
					else
					{
						unset($data['items'][$key]);
					}
					
				}
			}
		}
		return $data;
	}

	/**
	 * 收藏数量-应该可以冗余入user resource 表中
	 *
	 * @param  int $user_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getFavoritesGoodsNum($user_id = null)
	{
		if ($user_id)
		{
			$shop_id_str = ' user_id = ' . $user_id;
		}
		else
		{
			$shop_id_str = '';
		}

		$sql = '
			SELECT count(favorites_goods_id) num
			FROM ' . $this->_tableName . '
			WHERE 1 AND ' . $shop_id_str . '
		';

		$data = $this->sql->getRow($sql);

		return @$data['num'];
	}
}

?>