<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Buyer_VoucherCtl extends Buyer_Controller
{

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

		$this->voucherBaseModel = new Voucher_BaseModel();

	}

	/**
	 * 代金券领取列表
	 * @access public
	 * 
	 */
	public function voucher()
	{
        $cond_row = array();
        $state = request_int('state');
        $cond_row['voucher_owner_id'] = Perm::$userId;
        if($state){
            $cond_row['voucher_state']    = $state;
        }
        $order_row = array('voucher_state'=>'asc','voucher_active_date'=>'desc');
		if ('json' == $this->typ)
		{
            $rows = request_int('pagesize') ? request_int('pagesize') : 20;
            $page = request_int('curpage');
            if($state == 2){
                //把不能用的都查出来
                unset($cond_row['voucher_state']);
                $cond_row['voucher_state:!='] = Voucher_BaseModel::UNUSED;
            }
            $data = $this->voucherBaseModel->getUserVoucherList($cond_row, $order_row, $page, $rows);
            $data['items'] = $this->getVoucherData($data['items']);
            if ($data['page'] < $data['total']) {
                $data['hasmore'] = true;
            } else {
                $data['hasmore'] = false;
            }

            $data['page_total'] = $data['total'];
			return $this->data->addBody(-140, $data);
		}
		else
		{
            $Yf_Page           = new Yf_Page();
            $Yf_Page->listRows = request_int('listRows')?request_int('listRows'):10;
            $rows              = $Yf_Page->listRows;
            $offset            = request_int('firstRow', 0);
            $page              = ceil_r($offset / $rows);
            $data = $this->voucherBaseModel->getUserVoucherList($cond_row, $order_row, $page, $rows);
            $data['items'] = $this->getVoucherData($data['items']);

            $Yf_Page->totalRows = $data['totalsize'];
            $page_nav           = $Yf_Page->prompt();

			include $this->view->getView();
		}
	}
    
	public function delVoucher()
	{
		$voucher_id = request_int('id');
		$flag       = $this->voucherBaseModel->removeVoucher($voucher_id);

		if ($flag !== false)
		{
			$status = 200;
			$msg    = __('success');

		}
		else
		{
			$status = 250;
			$msg    = __('failure');

		}
		$data = array();

		$this->data->addBody(-140, $data, $msg, $status);
	}
    
    /**
     *  代金券数据
     */
    private function getVoucherData($data){
        if(!is_array($data) || !$data){
            return array();
        }
        $shop_id_row = array_column($data, 'voucher_shop_id');
        if(!$shop_id_row){
            return array();
        }
        $Shop_BaseModel = new Shop_BaseModel();
        $shop_rows = $Shop_BaseModel->getBase($shop_id_row);
        if(!$shop_rows){
            return array();
        }
        foreach ($data as $key => $value){
            $data[$key]['voucher_shop_name'] = $shop_rows[$value['voucher_shop_id']]['shop_name'];
            $data[$key]["voucher_state_label"] = __(Voucher_BaseModel::$voucherState[$value["voucher_state"]]);

            $data[$key]["voucher_limit"] = number_format($data[$key]["voucher_limit"]);
            $data[$key]["voucher_end_date"] = date('Y-m-d', strtotime($data[$key]["voucher_end_date"]) + 1);
        }
        return $data;
    }


}

?>