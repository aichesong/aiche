<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Adv_WidgetNavModel extends Adv_WidgetNav
{

	/**
	 * 读取分页列表
	 *
	 * @param  int $widget_cat_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getWidgetNavList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		return $this->listByWhere($cond_row, $order_row, $page, $rows);
	}
}

?>