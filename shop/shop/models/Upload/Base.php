<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 *
 *
 * @category   Framework
 * @package    __init__
 * @author     Xinze <xinze@live.cn>
 * @copyright  Copyright (c) 2016, 黄新泽
 * @version    1.0
 * @todo
 */
class Upload_Base extends Yf_Model
{
	public $_cacheKeyPrefix  = 'c|upload|';
	public $_cacheName       = 'upload';
	public $_tableName       = 'upload_base';
	public $_tablePrimaryKey = 'upload_id';

	public $uploadAlbumModel;

	/**
	 * @param string $user User Object
	 * @var   string $db_id 指定需要连接的数据库Id
	 * @return void
	 */
	public function __construct(&$db_id = 'shop', &$user = null)
	{
		$this->_tableName = TABEL_PREFIX . $this->_tableName;
		$this->_cacheFlag = CHE;
		parent::__construct($db_id, $user);

		$this->uploadAlbumModel = new Upload_AlbumModel();
	}

	/**
	 * 根据主键值，从数据库读取数据
	 *
	 * @param  int $upload_id 主键值
	 * @return array $rows 返回的查询内容
	 * @access public
	 */
	public function getUpload($upload_id = null, $sort_key_row = null)
	{
		$rows = array();
		$rows = $this->get($upload_id, $sort_key_row);

		return $rows;
	}

	/**
	 * 插入
	 * @param array $field_row 插入数据信息
	 * @param bool $return_insert_id 是否返回inset id
	 * @param array $field_row 信息
	 * @return bool  是否成功
	 * @access public
	 */
	public function addUpload($field_row, $return_insert_id = false)
	{
		$add_flag = $this->add($field_row, $return_insert_id);

		//添加图片默认在相册里增加一条记录

		if ($add_flag && $field_row['upload_type'] == 'image' && $field_row['album_id'] != Upload_BaseModel::UPLOAD_IMAGE_UNGROUP)
		{
			$update_album['album_num'] = 1;
			$this->uploadAlbumModel->edit($field_row['album_id'], $update_album, true);
		}

		return $add_flag;
	}

	/**
	 * 根据主键更新表内容
	 * @param mix $upload_id 主键
	 * @param array $field_row key=>value数组
	 * @return bool $update_flag 是否成功
	 * @access public
	 */
	public function editUpload($upload_id = null, $field_row)
	{
		$update_flag = $this->edit($upload_id, $field_row);

		return $update_flag;
	}

	/**
	 * 更新单个字段
	 * @param mix $upload_id
	 * @param array $field_name
	 * @param array $field_value_new
	 * @param array $field_value_old
	 * @return bool $update_flag 是否成功
	 * @access public
	 */
	public function editUploadSingleField($upload_id, $field_name, $field_value_new, $field_value_old)
	{
		$update_flag = $this->editSingleField($upload_id, $field_name, $field_value_new, $field_value_old);

		return $update_flag;
	}

	/**
	 * 删除操作
	 * @param int $upload_id
	 * @return bool $del_flag 是否成功
	 * @access public
	 */
	public function removeImage($upload_id)
	{
		$upload_base = $this->getUpload($upload_id);
		$upload_base = pos($upload_base);

		$del_flag = $this->remove($upload_id);

		//删除图片默认在相册减少一条记录

		if ($del_flag && $upload_base['upload_type'] == 'image' && $upload_base['album_id'] != Upload_BaseModel::UPLOAD_IMAGE_UNGROUP)
		{
			$update_album['album_num'] = -1;
			$this->uploadAlbumModel->edit($upload_base['album_id'], $update_album, true);
		}
		return $del_flag;
	}
}

?>