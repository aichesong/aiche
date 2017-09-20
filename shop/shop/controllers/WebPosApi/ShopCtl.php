<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * Api接口, 让webpos调用
 *
 *
 * @category   Game
 * @package    User
 * @author
 * @copyright
 * @version    1.0
 * @todo
 */
class WebPosApi_ShopCtl extends WebPosApi_Controller
{
    public $shopBaseModel      = null;
    public $userInfoModel     = null;
    public $userBaseModel     = null;


    /**
     * Constructor
     *
     * @param  string $ctl 控制器目录
     * @param  string $met 控制器方法
     * @param  string $typ 返回数据类型
     * @access public
     */
    public function __construct(&$ctl, $met, $typ)
    {
        parent::__construct($ctl, $met, $typ);

        $this->shopBaseModel     = new Shop_BaseModel();
        $this->userInfoModel     = new User_InfoModel();
        $this->userBaseModel     = new User_BaseModel();
    }

    //获取店铺及卖家信息
    public function getShopInfo()
    {
        $data = array();
        $user_id = request_int('user_id');
        $cond_row['user_id'] = $user_id;
        $shop_info = $this->shopBaseModel->getOneByWhere($cond_row);

        if($shop_info)
        {
            $status = 200;
            $data = $shop_info;
        }
        else
        {
            $status = 250;
        }

        $this->data->addBody(-140, $data ,$msg='success' ,$status);
    }


}

?>