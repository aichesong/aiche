<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Order_GoodsVirtualCodeModel extends Order_GoodsVirtualCode
{
	const SHOP_STATUS_OPEN  = 3;    //开启
	const VIRTUAL_CODE_NEW = 0;     //虚拟兑换码未使用
	const VIRTUAL_CODE_USED = 1;	//虚拟兑换码已使用 

	public function __construct()
	{
		parent::__construct();
		$this->codeUse = array(
			'0' => __('已使用'),
			'1' => __('未使用'),
		);
	}


	public function getVirtualCode($cond_row = array())
	{
		$data = $this->getByWhere($cond_row);

		foreach ($data as $key => $val)
		{
			$data[$key]['code_status'] = $this->codeUse[$val['virtual_code_status']];
		}

		return $data;
	}

}

?>