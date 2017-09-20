<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Buyer_InvoiceCtl extends Controller
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
		
		$this->invoiceModel = new InvoiceModel();
	}

	/**
	 * 首页
	 *
	 * @access public
	 */
	public function addInvoice()
	{
		$add_row['user_id']              = Perm::$row['user_id'];                    //会员id
		$add_row['invoice_title']        = request_string('invoice_title');        //发票抬头
		$add_row['invoice_state']        = request_int('invoice_state');            //发票类型 1普通发票 2电子发票 3增值税发票
		$add_row['invoice_company']      = request_string('invoice_company');        //单位名称
		$add_row['invoice_code']         = request_string('invoice_code');            //纳税人识别号
		$add_row['invoice_reg_addr']     = request_string('invoice_reg_addr');        //注册地址
		$add_row['invoice_reg_phone']    = request_string('invoice_reg_phone');    //注册电话
		$add_row['invoice_reg_bname']    = request_string('invoice_reg_bname');        //开户银行
		$add_row['invoice_reg_baccount'] = request_string('invoice_reg_baccount');    //银行账户
		$add_row['invoice_rec_name']     = request_string('invoice_rec_name');        //收票人姓名
		$add_row['invoice_rec_phone']    = request_string('invoice_rec_phone');    //收票人手机号
		$add_row['invoice_rec_email']    = request_string('invoice_rec_email');    //收票人邮箱
		$add_row['invoice_rec_province'] = request_string('invoice_rec_province'); //收票人省份
		$add_row['invoice_goto_addr']    = request_string('invoice_goto_addr');    //送票地址
		$add_row['invoice_province_id'] = request_int('invoice_province_id');
		$add_row['invoice_city_id'] = request_int('invoice_city_id');
		$add_row['invoice_area_id'] = request_int('invoice_area_id');

		//判断添加的发票信息是什么类型。普通发票可存多条记录，电子发票与增值税发票只存一条记录
		if ($add_row['invoice_state'] != InvoiceModel::INVOICE_NORMAL)
		{
			if ($add_row['invoice_title'] == "个人")
			{
				unset($add_row['invoice_title']);
			}
			//查找数据库中是否已存在该记录
			$cond_row = array(
				'user_id' => $add_row['user_id'],
				'invoice_state' => $add_row['invoice_state'],
			);
			$res      = $this->invoiceModel->getOneByWhere($cond_row);
			if ($res)
			{
				$flag = $this->invoiceModel->editInvoice($res['invoice_id'], $add_row);
				$invoice_id = $res['invoice_id'];
			}
			else
			{
				$flag = $this->invoiceModel->addInvoice($add_row,true);
				$invoice_id = $flag;
			}
		}
		else
		{
			$flag = $this->invoiceModel->addInvoice($add_row,true);
			$invoice_id = $flag;
		}


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
		$data = array('invoice_id'=>$invoice_id);
		$this->data->addBody(-140, $data, $msg, $status);

	}

	//修改发表信息
	public function editInvoice()
	{
		$user_id    = Perm::$row['user_id'];                    //会员id
		$invoice_id = request_string('invoice_id');        //发票id

		$edit_row['invoice_title']        = request_string('invoice_title');        //发票抬头
		$edit_row['invoice_company']      = request_string('invoice_company');        //单位名称
		$edit_row['invoice_code']         = request_string('invoice_code');            //纳税人识别号
		$edit_row['invoice_reg_addr']     = request_string('invoice_reg_addr');        //注册地址
		$edit_row['invoice_reg_phone']    = request_string('invoice_reg_phone');    //注册电话
		$edit_row['invoice_reg_bname']    = request_string('invoice_reg_bname');        //开户银行
		$edit_row['invoice_reg_baccount'] = request_string('invoice_reg_baccount');    //银行账户
		$edit_row['invoice_rec_name']     = request_string('invoice_rec_name');        //收票人姓名
		$edit_row['invoice_rec_phone']    = request_string('invoice_rec_phone');    //收票人手机号
		$edit_row['invoice_rec_email']    = request_string('invoice_rec_email');    //收票人邮箱
		$edit_row['invoice_rec_province'] = request_string('invoice_rec_province'); //收票人省份
		$edit_row['invoice_goto_addr']    = request_string('invoice_goto_addr');    //送票地址
		

		//验证用户
		$cond_row = array(
			'user_id' => $user_id,
			'invoice_id' => $invoice_id
		);

		$rs = $this->invoiceModel->getByWhere($cond_row);

		if ($rs)
		{
			$flag = $this->invoiceModel->editInvoice($invoice_id, $edit_row);
		}
		else
		{
			$flag = false;
		}

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

	//删除发表信息
	public function delInvoice()
	{
		$user_id    = Perm::$row['user_id'];                //会员id
		$invoice_id = request_string('invoice_id');        //发票id

		//验证用户
		$cond_row = array(
			'user_id' => $user_id,
			'invoice_id' => $invoice_id
		);

		$rs = $this->invoiceModel->getByWhere($cond_row);

		if ($rs)
		{
			$flag = $this->invoiceModel->removeInvoice($invoice_id);
		}
		else
		{
			$flag = false;
		}

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


}

?>