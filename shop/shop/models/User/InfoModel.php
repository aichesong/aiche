<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class User_InfoModel extends User_Info
{
	public static $userSex = array(
		"0" => '女',
		"1" => '男',
		"2" => '保密'
	);

	/**
	 * 读取分页列表
	 *
	 * @param  array $cond_row 查询条件
	 * @param  array $order_row 排序信息
	 * @param  array $page 当前页码
	 * @param  array $rows 每页记录数
	 * @return array $data 返回的查询内容
	 * @access public
	 */
	public function getInfoList($cond_row = array(), $order_row = array(), $page = 1, $rows = 100)
	{
		$data = $this->listByWhere($cond_row, $order_row, $page, $rows);
		foreach ($data["items"] as $key => $value)
		{
			$data["items"][$key]["user_sex"] = __(User_InfoModel::$userSex[$value["user_sex"]]);
		}
		return $data;
	}

	/**
	 * 读取一个会员信息
	 *
	 * @param  array $order 查询条件
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getUserInfo($order_row = array())
	{
		return $this->getOneByWhere($order_row);
	}

	/**
	 * 读取头部会员信息
	 *
	 * @param  int $user_id 主键值
	 * @return array $user 返回的查询内容
	 * @access public
	 */
	public function getUserMore($user_id)
	{

		$user = array();

		$user['info'] = $this->getOne($user_id);

		$user_grade_id = $user['info']['user_grade'];

		$this->userGradeModel = new User_GradeModel();
		$user['grade']        = $this->userGradeModel->getOne($user_grade_id);
		if (empty($user['grade']))
		{
			$user['grade']['user_grade_name'] = __('普通会员');
		}
		$this->userResourceModel = new User_ResourceModel();
		$user['points']          = $this->userResourceModel->getOne($user_id);

		$this->voucherBaseModel = new Voucher_BaseModel();

		$cond_row['voucher_owner_id'] = $user_id;
		$vo                           = $this->voucherBaseModel->getCount($cond_row);

		$user['voucher'] = $vo;

		return $user;
	}
	
	//获取用户的直属下级用户数量
	public function getSubQuantity($cond_row)
	{
		return $this->getNum($cond_row);
	}

	//获取所有用户id
	public function getAllUserId()
	{
		$sql = "SELECT
						user_id,user_name
					FROM
						" . TABEL_PREFIX . "user_info
					";
		$rows = $this->sql->getAll($sql);

		if($rows)
		{
			$rows = array_column($rows,'user_id');
		}

		return $rows;
	}

	/**
	 * 获取订单数量
     * 1.实物订单
     * 2.虚拟订单
     * 3.门店自提订单
     * @param type $user_id
     */
    public function getUserOrderCount($user_id){
        $order_count = array();
        $order_model = new Order_BaseModel();
        //待付款
        $cond_row1 = array();
        $cond_row1['buyer_user_id']        = $user_id;
        $cond_row1['order_buyer_hidden:<'] = Order_BaseModel::IS_BUYER_REMOVE;
        $cond_row1['order_status'] = Order_StateModel::ORDER_WAIT_PAY;
        $order_count['wait'] = $order_model->getCount($cond_row1);
        //待发货
        $cond_row2 = array();
        $cond_row2['buyer_user_id']        = $user_id;
        $cond_row2['order_buyer_hidden:<'] = Order_BaseModel::IS_BUYER_REMOVE;
        $cond_row2['order_status:IN'] = array(Order_StateModel::ORDER_WAIT_PREPARE_GOODS,Order_StateModel::ORDER_PAYED);
        $order_count['payed'] = $order_model->getCount($cond_row2);
        //待收货
        $cond_row3 = array();
        $cond_row3['buyer_user_id']        = $user_id;
        $cond_row3['order_buyer_hidden:<'] = Order_BaseModel::IS_BUYER_REMOVE;
        $cond_row3['order_status'] = Order_StateModel::ORDER_WAIT_CONFIRM_GOODS;
        $order_count['confirm'] = $order_model->getCount($cond_row3);
        //待评价
        $cond_row4 = array();
        $cond_row4['buyer_user_id']        = $user_id;
        $cond_row4['order_buyer_hidden:<'] = Order_BaseModel::IS_BUYER_REMOVE;
        $cond_row4['order_status'] = Order_StateModel::ORDER_FINISH;
        $cond_row4['order_buyer_evaluation_status'] = 0; //买家未评价
        $order_count['finish'] = $order_model->getCount($cond_row4);
        //退款退货
        $return_model = new Order_ReturnModel();
        $cond_row5 = array();
        $cond_row5['buyer_user_id']        = $user_id;
        $cond_row5['return_state:!='] = Order_ReturnModel::RETURN_PLAT_PASS;
        $order_count['return'] = $return_model->getCount($cond_row5);
        return $order_count;
    }


}

User_InfoModel::$userSex = array(
	"0" => __('女'),
	"1" => __('男'),
	"2" => __('保密')
);
?>