<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class Pay_PaymentChannelModel extends Pay_PaymentChannel
{

	/**
	 * ��ȡ��ҳ�б�
	 *
	 * @param  int $payment_channel_id ����ֵ
	 * @return array $rows ���صĲ�ѯ����
	 * @access public
	 */
	public function getPaymentChannelList($payment_channel_id = null, $page=1, $rows=100, $sort='asc')
	{
		//��Ҫ��ҳ��θ�Ч������չ
		$offset = $rows * ($page - 1);

		$this->sql->setLimit($offset, $rows);

		$config_key_row = array();
		$config_key_row = $this->selectKeyLimit();

		//��ȡ������Ϣ
		$total = $this->getFoundRows();

		$data_rows = array();

		if ($config_key_row)
		{
			$data_rows = $this->getConfig($config_key_row);
		}

		$data = array();
		$data['page'] = $page;
		$data['total'] = ceil_r($total / $rows);  //total page
		$data['totalsize'] = $data['total'];
		$data['records'] = count($data_rows);
		$data['items'] = array_values($data_rows);

		return $data;
	}


	/*
	 * ��ȡconfig
	 */
	public function getPaymentChannelValue($key)
	{
		if (Yf_Registry::isRegistered($key))
		{
			return Yf_Registry::get($key);
		}
		else
		{
			$config_row = array();

			$config_rows = $this->getConfig($key);

			if ($config_rows)
			{
				$config_row = array_pop($config_rows);

				if ('json' == $config_row['config_datatype'])
				{
					$config_row['config_value'] = decode_json($config_row['config_value']);
				}

				Yf_Registry::set($key, $config_row['config_value']);

			}

			return $config_row['config_value'];
		}
	}
	public function getWayByKey($payment_channel_id=null)
	{
		$this->sql->setWhere('payment_channel_id',$payment_channel_id);
		$config_id_row = $this->selectKeyLimit();
		return $config_id_row;
	}
	public function getPayWaysByCode($payment_channel_code=null)
	{
		if($payment_channel_code)
		{
			$this->sql->setWhere('payment_channel_code',$payment_channel_code);
		}
		$code_ways_row = $this->getPaymentChannel('*');
		return $code_ways_row;
	}
}
?>