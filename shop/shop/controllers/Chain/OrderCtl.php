<?php if (!defined('ROOT_PATH')) exit('No Permission');

/**
 * @author     zcg <xinze@live.cn>
 */
class Chain_OrderCtl extends Chain_Controller
{
    public $chainBaseModel = null;
    public $orderGoodsModel = null;
    public $orderBaseModel = null;
    public $goodsBaseModel = null;
    public $goodsImagesModel = null;

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
        $this->chainBaseModel = new Chain_BaseModel();
        $this->orderBaseModel = new Order_BaseModel();
        $this->orderGoodsModel = new Order_GoodsModel();
        $this->goodsBaseModel = new Goods_BaseModel();
        $this->goodsImagesModel = new Goods_ImagesModel();
    }

    /**
     * @author houpeng
     * 读取门店对应的订单数据
     *
     * @access public
     */
    public function index()
    {
        $chain_id = Perm::$chainId;
        $search_state_type = request_string('search_state_type');
        $search_key_type = request_string('search_key_type');
        $keyword = request_string('keyword');
        $Order_StateModel = new Order_StateModel();
        $cond_row = array();
        $cond_row['order_status:='] = 11;
        $cond_row['chain_id:='] = $chain_id;

        if ($search_state_type == 'yes' && $chain_id) {
            $cond_row['order_status:='] = $Order_StateModel::ORDER_FINISH;
        }
        if ('buyer_phone' == $search_key_type) {
            $cond_row['order_receiver_contact:LIKE'] = '%' . $keyword . '%';
        } elseif ('order_sn' == $search_key_type) {
            $cond_row['order_id:LIKE'] = '%' . $keyword . '%';
        }
        $Yf_Page = new Yf_Page();
        $Yf_Page->listRows = 10;
        $rows = $Yf_Page->listRows;
        $offset = request_int('firstRow', 0);
        $page = ceil_r($offset / $rows);
        $data = $this->orderBaseModel->getBaseList($cond_row, array(), $page, $rows);
        $Yf_Page->totalRows = $data['totalsize'];
        $page_nav = $Yf_Page->prompt();
        include $this->view->getView();
    }

    /**
     * 订单处理界面
     *
     * @access public
     */
    public function orderManage()
    {
        $chain_id = Perm::$chainId;
        $order_id = request_string('order_id');

        $cond_row['chain_id:='] = $chain_id;
        $order_detai = $this->orderBaseModel->getOrderDetail($order_id);
        $cahin_base = current($this->chainBaseModel->getByWhere($cond_row));
        $chain_address[] = $cahin_base['chain_province'];
        $chain_address[] = $cahin_base['chain_city'];
        $chain_address[] = $cahin_base['chain_county'];
        $chain_address[] = $cahin_base['chain_address'];
        $chain_address = implode(' ', $chain_address);
        include $this->view->getView();
    }

    /**
     * 订单处理
     *
     * @access public
     */
    public function processOrder()
    {
        $order_state = new Order_StateModel();
        $pickup_code = request_string('pickup_code');
        $order_id = request_string('order_id');
        $shop_id = request_int('shop_id');
        $stock = request_int('stock');
        $goods_id = request_int('goods_id');
        $chain_id = Perm::$chainId;
        $now_time = date('Y-m-d H:i:s', time());

        $order_goodsChainCodeModel = new Order_GoodsChainCodeModel();
        $order_goodsChainCode = current($order_goodsChainCodeModel->getByWhere(array('order_id' => $order_id)));
        if ($pickup_code == $order_goodsChainCode['chain_code_id']) {
            //开启事物
            $this->orderBaseModel->sql->startTransactionDb();

            //修改订单表中的订单状态
            $order_info['order_status'] = $order_state::ORDER_FINISH;
            $order_info['order_finished_time'] = $now_time;
            $flag = $this->orderBaseModel->editBase($order_id, $order_info);

            //修改订单商品表中的订单状态
            $edit_row['order_goods_status'] = $order_state::ORDER_FINISH;
            $order_goods_id = $this->orderGoodsModel->getKeyByWhere(array('order_id' => $order_id));
            $this->orderGoodsModel->editGoods($order_goods_id, $edit_row);

            //将需要确认的订单号远程发送给Paycenter修改订单状态
            //远程修改paycenter中的订单状态
            $key = Yf_Registry::get('shop_api_key');
            $url = Yf_Registry::get('paycenter_api_url');
            $shop_app_id = Yf_Registry::get('shop_app_id');
            $formvars = array();

            $formvars['order_id'] = $order_id;
            $formvars['app_id'] = $shop_app_id;
            $formvars['from_app_id'] = Yf_Registry::get('shop_app_id');
            $rs = get_url_with_encrypt($key, sprintf('%s?ctl=Api_Pay_Pay&met=confirmOrder&typ=json', $url), $formvars);

            //更改自提码使用状态
            $code_row['chain_code_status'] = $order_goodsChainCodeModel::CHAIN_CODE_USE;
            $code_row['chain_code_usetime'] = $now_time;
            $flag=$order_goodsChainCodeModel->editGoodsChainCode($order_goodsChainCode['chain_code_id'], $code_row);

            if ($flag && $this->orderBaseModel->sql->commitDb()) {
                $msg = __('success');
                $status = 200;
            } else {
                $this->orderBaseModel->sql->rollBackDb();
                $m = $this->orderBaseModel->msg->getMessages();
                $msg = $m ? $m[0] : __('failure');
                $status = 250;
            }
        }
        $this->data->addBody(-140, array(), $msg, $status);
    }
}

?>