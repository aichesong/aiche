<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Order_InvoiceModel extends Order_Invoice
{
	const INVOICE_NORMAL   = 1;     //普通发票
	const INVOICE_ELECTRON = 2;     //电子发票
	const INVOICE_ADDTAX   = 3;     //增值税发票

	public function __construct()
	{
		parent::__construct();

		$this->invoiceState = array(
			'1' => __("普通发票"),
			'2' => __("电子发票"),
			'3' => __("增值税发票"),
		);
	}

	public function addInvoiceByInviceId($invoice_id = null,$invoice_title = null,$invoice_content = null)
	{
		$InvoiceModel = new InvoiceModel();
		$invoice = $InvoiceModel->getOne($invoice_id);

		unset($invoice['invoice_id']);
		unset($invoice['id']);
		unset($invoice['invoice_title']);
		$invoice['invoice_content'] = $invoice_content;
		$invoice['invoice_title'] = $invoice_title;
		$order_invoice_id = $this->addInvoice($invoice,true);

		return $order_invoice_id;
	}

	public function addInvoiceByInvice($invoice_title = null,$invoice_content = null)
	{
		$cond_row = array();
		$cond_row['user_id'] = Perm::$userId;
		$cond_row['invoice_state'] = 1;
		$cond_row['invoice_title'] = $invoice_title;
		$cond_row['invoice_content'] = $invoice_content;

		$order_invoice_id = $this->addInvoice($cond_row,true);
		return $order_invoice_id;
	}
    
    
    public function getOrderInvoiceId($invoice_id,$invoice_title,$invoice_content){
        $order_invoice_id = 0;
		if($invoice_title)
		{
			if($invoice_id)
			{
				$order_invoice_id = $this->addInvoiceByInviceId($invoice_id,$invoice_title,$invoice_content);
			} else {
				$order_invoice_id = $this->addInvoiceByInvice($invoice_title,$invoice_content);
			}
		}
        return $order_invoice_id;
    } 
}

?>