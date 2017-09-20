<?php
/**
 * Created by PhpStorm.
 * User: tech05
 * Date: 2016-11-2
 * Time: 10:08
 */
class Api_Erp_OrderCtl extends Api_Controller{

    public $orderBaseModel;
    public $orderReturnModel;

    public function  __construct(&$ctl, $met, $typ)
    {
        parent::__construct($ctl, $met, $typ);

        $this->orderBaseModel = new Order_BaseModel();
        $this->orderReturnModel = new Order_ReturnModel();
    }


    //erp下载订单
    public function downOrder()
    {

        $Order_BaseModel=new Order_BaseModel();
        if (request_string('end_created'))
        {
            $Order_BaseModel->sql->setWhere('order_create_time',request_string('end_created'),'<=');
        }
        if (request_string('start_created'))
        {
            $Order_BaseModel->sql->setWhere('order_create_time',request_string('start_created'),'>=');
        }
        if (request_row('store_account'))
        {
            $shop_account=request_row('store_account');
        }

        $User_BaseModel = new User_BaseModel();
        $User_BaseModel->sql->setWhere('user_account',$shop_account,'IN');
        $User_BaseModel->sql->setLimit(0,999999999);
        $User_Base = $User_BaseModel->getBase('*');
        $user_id  = array_column($User_Base,'user_id');

        $Shop_BaseModel = new Shop_BaseModel();
        $Shop_BaseModel->sql->setWhere('user_id',$user_id,'IN');
        $Shop_BaseModel->sql->setLimit(0,999999999);
        $Shop_Base = $Shop_BaseModel->getBase('*');
        $shop_id  = array_column($Shop_Base,'shop_id');

        $Order_BaseModel->sql->setWhere('order_status',array(8,9),'NOT IN');//不包括退款退货订单
        $Order_BaseModel->sql->setWhere('shop_id',$shop_id,'IN');
        $Order_BaseModel->sql->setLimit(0,999999999);
        $Order_Base = $Order_BaseModel->getBase('*');

        $Order_GoodsModel=new Order_GoodsModel();
        $Order_GoodsModel->sql->setLimit(0,999999999);
        $Order_Goods = $Order_GoodsModel->getGoods('*');

        $User_InfoModel = new User_InfoModel();
        $User_InfoModel->sql->setLimit(0,999999999);
        $User_Info  = $User_InfoModel->getInfo('*');

        $data=array();
        if($Order_Base){
            foreach($Order_Base as $key=>$value){
                $User_id=$Shop_Base[$value['shop_id']]['user_id'];
                $data['items'][$key]['order_id']=$value['order_id'];
                $data['items'][$key]['shop_id']=$value['shop_id'];
                $data['items'][$key]['store_account']=$User_Base[$User_id]['user_account'];
                $data['items'][$key]['shop_name']=$value['shop_name'];
                $data['items'][$key]['shop_mobile']=$Shop_Base[$value['shop_id']]['shop_tel'];
                $data['items'][$key]['user_id']=$value['buyer_user_id'];
                $data['items'][$key]['user_account']=$value['buyer_user_name'];
                $data['items'][$key]['user_sex']=$User_Info[$value['buyer_user_id']]['user_sex'];
                $data['items'][$key]['user_mobile']=$User_Info[$value['buyer_user_id']]['user_mobile'];
                $data['items'][$key]['user_email']=$User_Info[$value['buyer_user_id']]['user_email'];
                $data['items'][$key]['user_qq']=$User_Info[$value['buyer_user_id']]['user_qq'];
                $data['items'][$key]['user_ww']=$User_Info[$value['buyer_user_id']]['user_ww'];
                $data['items'][$key]['create_time']=strtotime($value['order_create_time']);
                $data['items'][$key]['consignee_mobile']=$value['order_receiver_contact'];
                $data['items'][$key]['consignee_tel']='';
                $data['items'][$key]['consignee']=$value['order_receiver_name'];
                $data['items'][$key]['order_delivery_address_province']='';
                $data['items'][$key]['order_delivery_address_city']='';
                $data['items'][$key]['order_delivery_address_county']='';
                $data['items'][$key]['order_delivery_address_address']='';
                if($value['order_receiver_address']){
                    $order_delivery_address=explode(' ',$value['order_receiver_address']);
                    if($order_delivery_address[0]=='北京' ||$order_delivery_address[0]=='天津' ||$order_delivery_address[0]=='上海' ||$order_delivery_address[0]=='重庆'){
                        $data['items'][$key]['order_delivery_address_province']=$order_delivery_address[0];
                        $data['items'][$key]['order_delivery_address_city']=$order_delivery_address[0];
                        $data['items'][$key]['order_delivery_address_county']=$order_delivery_address[1];
                        for($i=2;$i<count($order_delivery_address);$i++){
                            $data['items'][$key]['order_delivery_address_address'].=$order_delivery_address[$i];
                        }
                    }else{
                        $data['items'][$key]['order_delivery_address_province']=$order_delivery_address[0];
                        $data['items'][$key]['order_delivery_address_city']=$order_delivery_address[1];
                        $data['items'][$key]['order_delivery_address_county']=$order_delivery_address[2];
                        for($i=3;$i<count($order_delivery_address);$i++){
                            $data['items'][$key]['order_delivery_address_address'].=$order_delivery_address[$i];
                        }
                    }
                }
                $data['items'][$key]['des']=$value['order_message'];
                $data['items'][$key]['payment_id']=$value['payment_id'];
                $data['items'][$key]['payment_name']=$value['payment_name'];
                $data['items'][$key]['order_goods_amount']=$value['order_goods_amount'];
                $data['items'][$key]['order_discount_amount']=$value['order_discount_fee'];
                $data['items'][$key]['order_payment']=$value['order_payment_amount'];
                $data['items'][$key]['order_shipping_fee_amount']=$value['order_shipping_fee'];
                $data['items'][$key]['order_shipping_fee']='';
                $data['items'][$key]['voucher_id']=$value['voucher_id'];
                $data['items'][$key]['voucher_number']=$value['voucher_code'];
                $data['items'][$key]['voucher_price']=$value['voucher_price'];
                $data['items'][$key]['order_point_add']=$value['order_points_add'];
                $data['items'][$key]['payment_time']=strtotime($value['payment_time'])>0?strtotime($value['payment_time']):'';
                if($value['order_status']==1){
                    $data['items'][$key]['status']=1;
                }else if($value['order_status']==2 || $value['order_status']==3){
                    $data['items'][$key]['status']=2;
                }else if($value['order_status']==4){
                    $data['items'][$key]['status']=3;
                }else if($value['order_status']==5 || $value['order_status']==6){
                    $data['items'][$key]['status']=4;
                }else if($value['order_status']==7){
                    $data['items'][$key]['status']=0;
                }
                if($value['order_finished_time'] != 0){
                    $data['items'][$key]['order_finished_time']=strtotime($value['order_finished_time']);
                }else{
                    $data['items'][$key]['order_finished_time']=0;
                }

                $data['items'][$key]['discounts']=$value['order_discount_fee'];
                $data['items'][$key]['order_type']=$value['order_is_virtual'];
                $goods_msg=array();
                foreach($Order_Goods as $k=>$v){
                    if($v['order_id']==$value['order_id']){
                        $goods_msg[$k]['id']=$v['order_goods_id'];
                        $goods_msg[$k]['order_id']=$v['order_id'];
                        $goods_msg[$k]['setmeal']=$v['goods_id'];
                        $goods_msg[$k]['pid']=$v['common_id'];
                        $goods_msg[$k]['name']=$v['goods_name'];
                        $goods_msg[$k]['pcatid']=$v['goods_class_id'];
                        $goods_msg[$k]['price']=$v['goods_price'];
                        $goods_msg[$k]['num']=$v['order_goods_num'];
                        $goods_msg[$k]['pic']=$v['goods_image'];
                        $goods_msg[$k]['status']=$data['items'][$key]['status'];
                    }
                }
                $data['items'][$key]['goods_msg']=$goods_msg;
            }
        }
        $this->data->addBody(-140, $data);
    }

    //下载退货退款订单
    public function downreorder()
    {

        $Order_ReturnModel=new Order_ReturnModel();
        if (request_string('start_created'))
        {
            $cond_row['return_add_time:>='] = request_string('start_created');
        }
        if (request_string('end_created'))
        {
            $cond_row['return_add_time:<='] = request_string('end_created');
        }
        if (request_row('store_account'))
        {
            $shop_account=request_row('store_account');
        }

        $User_BaseModel = new User_BaseModel();
        $User_BaseModel->sql->setWhere('user_account',$shop_account,'IN');
        $User_BaseModel->sql->setLimit(0,999999999);
        $User_Base = $User_BaseModel->getBase('*');
        $user_id  = array_column($User_Base,'user_id');

        $Shop_BaseModel = new Shop_BaseModel();
        $Shop_BaseModel->sql->setWhere('user_id',$user_id,'IN');
        $Shop_BaseModel->sql->setLimit(0,999999999);
        $Shop_Base = $Shop_BaseModel->getBase('*');
        $shop_id  = array_column($Shop_Base,'shop_id');

        $cond_row['seller_user_id:IN'] = $shop_id;
        $cond_row['order_goods_id:!='] = 0;
        $Order_Return = $Order_ReturnModel->getReturnList($cond_row, array(), 1, 999999999);
        $Order_GoodsModel=new Order_GoodsModel();
        $Order_GoodsModel->sql->setLimit(0,999999999);
        $Order_Goods = $Order_GoodsModel->getGoods('*');
        $Shop_BaseModel = new Shop_BaseModel();
        $Shop_BaseModel->sql->setLimit(0,999999999);
        $Shop_Base  = $Shop_BaseModel->getBase('*');
        $User_BaseModel = new User_BaseModel();
        $User_BaseModel->sql->setLimit(0,999999999);
        $User_Base  = $User_BaseModel->getBase('*');
        $data=array();
        if($Order_Return['items']){
            foreach($Order_Return['items'] as $key=>$value){
                $data['data'][$key]['order_id']=$value['order_number'];
                $data['data'][$key]['refund_id']=$value['return_code'];
                $data['data'][$key]['member_id']=$value['buyer_user_id'];
                $data['data'][$key]['seller_id']=$value['seller_user_id'];
                $data['data'][$key]['product_id']='';
                $data['data'][$key]['product_name']='';
                foreach($Order_Goods as $k=>$v){
                    if($v['order_goods_id']==$value['order_goods_id']){
                        $data['data'][$key]['product_id']=$v['order_goods_id'];
                        $data['data'][$key]['product_name']=$v['goods_name'];
                        $data['data'][$key]['goods_sku']=$v['order_spec_info'];
                    }
                }

                $data['data'][$key]['refund_price']=$value['return_cash'];
                $data['data'][$key]['reason']=$value['return_reason'];
                if($value['return_type']==1 || $value['return_type']==3){
                    $data['data'][$key]['goods_status']=0;
                }else{
                    $data['data'][$key]['goods_status']=1;
                }
                $data['data'][$key]['type']=2;
                $data['data'][$key]['create_time']=strtotime($value['return_add_time']);
                $data['data'][$key]['close_reason']='';
                $data['data'][$key]['refuse_reason']='';
                $data['data'][$key]['goods_image']=$value['order_goods_pic'];
                $data['data'][$key]['goods_price']=$value['order_goods_price'];
                $data['data'][$key]['goods_num']=$value['order_goods_num'];
                $data['data'][$key]['return_desc']='';
                $data['data'][$key]['warehouse_id']=0;
                $data['data'][$key]['return_express_id']='';
                $data['data'][$key]['return_logistic_num']='';
                $data['data'][$key]['exchangeOrderNum']='';
            }
        }
        $this->data->addBody(-140, $data);
    }
    /**
     * 更新订单状态
     *
     * erp审核更新商城订单状态待发货（待开发）
     * erp发货更新商城订单状态已发货，同时更新物流公司、物流单号、发货时间、最晚收货时间
     * erp退款、退货审核更新商城退款、退货订单状态
     */
    public function updateOrderState()
    {
        $operation  = request_string('operation');

        $update_order = array();

        if ($operation == 'audit') {

        } else if ( $operation == 'consignment' ) {

            $order_number = request_string('order_number');
            $logistics_no = request_string('logistics_no');
            $express_name = request_string('express_name');

            $order_data = $this->orderBaseModel->getByWhere( array('order_id'=> $order_number) );
            if ( empty($order_data) ) return $this->data->addBody(-140, array(), '单据不存在！', 250);

            $expressModel = new ExpressModel();
            $shop_ExpressModel = new Shop_ExpressModel();
            $shop_express_rows = $shop_ExpressModel->getByWhere();
            $express_ids = array_column($shop_express_rows, 'express_id');

            $express_rows = $expressModel->getExpress($express_ids);
            $KExpressName_VId = array_column($express_rows, 'express_id', 'express_name');

            $confirm_order_time = Yf_Registry::get('confirm_order_time');

            $update_order['order_status'] = Order_StateModel::ORDER_WAIT_CONFIRM_GOODS;
            $update_order['order_shipping_time'] = date('Y-m-d H:i:s');
            $update_order['order_receiver_date'] = date('Y-m-d H:i:s', time() + $confirm_order_time);
            $update_order['order_shipping_code'] = $logistics_no;
            $update_order['order_shipping_express_id'] = empty($KExpressName_VId[$express_name]) ? -1 : $KExpressName_VId[$express_name];

            $order_id = $order_number;
            $flag = $this->orderBaseModel->editBase($order_id, $update_order);

        } else if ($operation == 'service') {
            $orderReturnModel = new Order_ReturnModel();
            $order_number = request_string('order_id');
            $order_goods_id = request_string('product_id');
            $order_return = $orderReturnModel->getByWhere(array('order_number'=>$order_number,'order_goods_id'=>$order_goods_id));
            $order_return_id = array_column($order_return , 'order_return_id');
            $flag = $orderReturnModel->editReturn($order_return_id, array('return_state' => Order_ReturnModel::RETURN_SELLER_PASS));
        }

        if ($flag) {
            $msg = 'success';
            $status = 200;
        } else {
            $msg = 'failure';
            $status = 250;
        }

        $this->data->addBody(-140, array(), $msg, $status);
    }
}