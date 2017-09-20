<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class Buyer_FavoritesCtl extends Buyer_Controller
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
		
		$this->userFavoritesGoodsModel = new User_FavoritesGoodsModel();
		$this->goodsBaseModel          = new Goods_BaseModel();
		$this->goodsCommonModel        = new Goods_CommonModel();
		$this->shopBaseModel           = new Shop_BaseModel();
		$this->goodsCatModel           = new Goods_CatModel();
		$this->userFavoritesShopModel  = new User_FavoritesShopModel();
		$this->userFootprintModel      = new User_FootprintModel();
	}
	
	/**
	 *收藏商品信息
	 *
	 * @access public
	 */
	public function favoritesGoods()
	{
		
		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = request_int('listRows')?request_int('listRows'):18;
		$rows              = $Yf_Page->listRows;
		$offset            = request_int('firstRow', 0);
		$page              = ceil_r($offset / $rows);
		$page_nav          = '';
		$user_id           = Perm::$userId;

		$cond_row['user_id'] = $user_id;
		
		$data = $this->userFavoritesGoodsModel->getFavoritesGoodsDetail($cond_row, array('favorites_goods_time' => 'DESC'), $page, $rows);
		
		if ($data)
		{
			$Yf_Page->totalRows = $data['totalsize'];
			$page_nav           = $Yf_Page->prompt();
		}
		if ('json' == $this->typ)
		{
			$data['items'] = array_values($data['items']);
//			echo '<pre>';print_r($data);exit;
			$this->data->addBody(-140, $data);
		}
		else
		{
			include $this->view->getView();
		}

	}

	/**
	 *删除收藏商品信息
	 *
	 * @access public
	 */
	public function delFavoritesGoods()
	{
		$userId   = Perm::$userId;
		$goods_id = request_int('id');
		
		$order_row['user_id']  = $userId;
		$order_row['goods_id'] = $goods_id;
		
		$de = $this->userFavoritesGoodsModel->getFavoritesGoods($order_row);

		if('json' == request_string('typ'))
		{
			$favorites_goods_id = $de['favorites_goods_id'];
		}
		else
		{
			$favorites_goods_id = $de[0];
		}
		
		$flag = $this->userFavoritesGoodsModel->removeGoods($favorites_goods_id);

		if ($flag === false)
		{
			$status = 250;
			$msg    = __('failure');
		}
		else
		{
			$status = 200;
			$msg    = __('success');

			//删除收藏商品成功添加数据到统计中心
			$analytics_data = array(
				'product_id'=>$goods_id,
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsProductCancleCollect',$analytics_data);
		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);

	}
	
	/**
	 *收藏店铺信息
	 *
	 * @access public
	 */
	public function favoritesShop()
	{
		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = request_int('listRows')?request_int('listRows'):5;
		$rows              = $Yf_Page->listRows;
		$offset            = request_int('firstRow', 0);
		$page              = ceil_r($offset / $rows);
		
		$user_id             = Perm::$userId;
		$cond_row['user_id'] = $user_id;
		
		$data = $this->userFavoritesShopModel->getFavoritesShops($cond_row, array('favorites_shop_time' => 'DESC'), $page, $rows);
		
		$Yf_Page->totalRows = $data['totalsize'];
		$page_nav           = $Yf_Page->prompt();
		
		if ('json' == $this->typ)
		{
			/*
			$shop_id_row = array_column($data['items'], 'shop_id');

			//获取单个店铺数据
			$Goods_CommonModel = new Goods_CommonModel();
			$goods_num   = $Goods_CommonModel->getCommonStateNum($data['items']['shop_id'], -1);

			$data['items']['shop_collect'] = $goods_num;
			*/
//			echo '<pre>';print_r($data);exit;
			$this->data->addBody(-140, $data);
		}
		else
		{
			include $this->view->getView();
		}

	}

	/**
	 *删除收藏店铺信息
	 *
	 * @access public
	 */
	public function delFavoritesShop()
	{
		$userId  = Perm::$userId;
		$shop_id = request_int('id');

		$cond_row['user_id'] = $userId;
		$cond_row['shop_id'] = $shop_id;
		
		$de = $this->userFavoritesShopModel->getFavoritesShop($cond_row);

		if('json' == request_string('typ'))
		{
			$favorites_shop_id = $de['favorites_shop_id'];
		}
		else
		{
			$favorites_shop_id = $de[0];
		}
		$flag = $this->userFavoritesShopModel->removeShop($favorites_shop_id);
		
		if ($flag === false)
		{
			$status = 250;
			$msg    = __('failure');
		}
		else
		{
			//维护shop_base冗余字段 shop_collect

			$this->shopBaseModel->editBaseCollectNum($shop_id, ['shop_collect'=> -1], true);

			$status = 200;
			$msg    = __('success');
			//取消店铺收藏成功添加数据到统计中心

			$analytics_data = array(
				'shop_id'=>$shop_id,
				'date'=>date('Y-m-d'),
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsShopCancleCollect',$analytics_data);
		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);

	}

	/**
	 *个人足迹信息 - 按照日期分页
	 *
	 * @access public
	 */
	public function footprint()
	{
		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = request_int('listRows')?request_int('listRows'):10;
		$rows              = $Yf_Page->listRows;
		$offset            = request_int('firstRow', 0);
		$page              = ceil_r($offset / $rows);

		$user_id              = Perm::$userId;
		$order_row['user_id'] = $user_id;
		$classid              = request_int('classid');

		$data = $this->userFootprintModel->getFootprintList($order_row, array('footprint_time' => 'DESC'));

		$page_nav = '';
		$arr      = array();
		$cat      = array();
		if ($data['items'])
		{
			//查出有详情的
			$goodsid                 = array();
			$goodsid['common_id:in'] = array_column($data['items'], 'common_id');

			$goods_cat = $this->goodsCommonModel->getGoodsByCommonId($goodsid);
			//分类名搜索
			if ($classid)
			{
				$goodsid['cat_id'] = $classid;
			}

			$goodsall = $this->goodsCommonModel->getGoodsByCommonId($goodsid);

			$goodsallid                   = array();
			$goodsallid                   = array_column($goodsall['items'], 'common_id');
			$class = '';
			if($goodsallid){
				$class = implode(',',$goodsallid);
			}
			$goodsall_row['user_id']      = $user_id;
			$goodsall_row['common_id:in'] = $goodsallid;

			$data = array();
			$data = $this->userFootprintModel->getFootprintList($goodsall_row, array('footprint_time' => 'DESC'));

			//获取时间
			$re = array();
			$re = array_column($data['items'], 'footprint_time');

			$re = array_unique($re);

			$footprint_row['user_id']           = $user_id;
			$footprint_row['footprint_time:in'] = $re;
			$footprint_row['common_id:in'] = $goodsallid;
			//获取所有有详情的足迹
			$foot = $this->userFootprintModel->getFootprintAll($footprint_row);

			//以时间为分类分出足迹
			$ce = array();
			foreach ($foot as $k => $v)
			{
				$ce[$v['footprint_time']][$k] = $v;
			}

			krsort($ce);

			$data = array();
			foreach ($ce as $k => $v)
			{
				$data[][$k] = $v;
			}

			$goods_id = array();
			$goods_id = array_column($goodsall['items'], 'common_id');

			//以common_id为下标
			$commonAll = array();
			foreach ($goodsall['items'] as $k => $v)
			{
				$commonAll[$v['common_id']] = $v;
			}

			foreach ($data as $kk => $vv)
			{
				foreach ($vv as $ke => $ve)
				{
					foreach ($ve as $k => $v)
					{
						if (in_array($v['common_id'], $goods_id))
						{
							$data[$kk][$ke][$k]['detail'] = $commonAll[$v['common_id']];
						}
					}

				}
			}

			$total     = ceil_r(count($data) / $rows);
			$start     = ($page - 1) * $rows;
			$data_rows = array_slice($data, $start, $rows);

			fb($data);
			fb('data');

			$arr              = array();
			$arr['page']      = $page;
			$arr['total']     = $total;  //total page
			$arr['totalsize'] = count($data);
			$arr['records']   = count($data_rows);
			$arr['items']     = array_values($data_rows);

			if (!empty($goods_cat['items']))
			{

				$cat_id = array_column($goods_cat['items'], 'cat_id');

				$cat_id = array_unique($cat_id);

				foreach ($cat_id as $k => $v)
				{
					$cat_name = $this->goodsCatModel->getNameByCatid($v);
					if ($cat_name != '未分组')
					{
						$cat[$k]['cat_name'] = $cat_name;
						$cat[$k]['cat_id']   = $v;
					}
				}
			}

			$Yf_Page->totalRows = $arr['totalsize'];
			$page_nav           = $Yf_Page->prompt();

		}

		fb($arr);
		fb('arr');

		if ('json' == $this->typ)
		{
			$data        = array();
			$data['cat'] = $cat;
			foreach($arr['items'] as $akey=>$aval)
			{
				if(is_array($aval))
				{
					$aval = array_values($aval);
					$arr['items'][$akey] = $aval;
				}
				foreach($aval as $ake=>$ava)
				{
					if(is_array($ava))
					{
						$ava = array_values($ava);
						$arr['items'][$akey][$ake] = $ava;
					}
				}
			}
			$data['arr'] = $arr;
//			echo '<pre>';print_r($arr);exit;
			fb($data);
			$this->data->addBody(-140, $data);
		}
		else
		{
			include $this->view->getView();
		}

	}


	/**
	 *个人足迹信息  wap
	 *
	 * @access public
	 */
	public function footprintwap()
	{

		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = $size = request_int('listRows')?request_int('listRows'):10;
		$rows              = $Yf_Page->listRows;
		$page              = (int)$_GET['curpage'];

		$user_id              = Perm::$userId;
		$order_row['user_id'] = $user_id;
		$classid              = request_int('classid'); 
		$data = $this->userFootprintModel->getFootprintList($order_row, array('footprint_time' => 'DESC'),$page,$size);
		
		if(!$data['items']){
			return;
		}
		 
		$goodsid                 = array();
		$cond = array_column($data['items'], 'common_id');
		$goodsid['common_id:in'] = $cond;
 		$tb = TABEL_PREFIX."goods_common"; 
 		$order_by = implode(",",$cond);
 		$condition  = " where common_id in (".$order_by.")";
 		$sql = "select * from ".$tb." ".$condition." order by field(common_id,".$order_by.")";  
		$goods_cat = $this->goodsCommonModel->sql->getAll($sql); 
		foreach ($goods_cat as $key => $value) {
			$goods_cat[$key]['goods_id'] = json_decode($value['goods_id'],true)[0]['goods_id'];
		}
		$data['arr']['items'] = $goods_cat;
 
		$page_nav = '';
		$arr      = array();
		$cat      = array(); 
		$data['hasmore'] = $page >= $data['total'] ?false:true;
	 
		$this->data->addBody(-140, $data);
	 
		 

	}

	/**
	 *个人足迹信息 - 按照商品分页
	 *
	 * @access public
	 */
	public function footprintGoods()

	{
		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = request_int('listRows')?request_int('listRows'):4;
		$rows              = $Yf_Page->listRows;
		$offset            = request_int('firstRow', 0);
		$page              = ceil_r($offset / $rows);

		$user_id              = Perm::$userId;
		$order_row['user_id'] = $user_id;

		$data = $this->userFootprintModel->getFootprintList($order_row, array('footprint_time' => 'DESC'),$page, $rows);

		fb($data);
		fb('data1');

		if ($data['items'])
		{
			foreach($data['items'] as $key => $val)
			{
				$goods_common = $this->goodsCommonModel->getOne($val['common_id']);
				$data['items'][$key]['goods_common'] = $goods_common;
			}

		}

		$Yf_Page->totalRows = $data['totalsize'];
		$page_nav           = $Yf_Page->prompt();

		$this->data->addBody(-140, $data);

	}




	
	/**
	 *删除足迹信息
	 *
	 * @access public
	 */
	public function delFootprint()
	{
		$userId         = Perm::$userId;
		$footprint_time = request_string('time');
		$common_id = request_string('id');
		
		$order_row['user_id']        = $userId;

		if ($footprint_time)
		{
			$order_row['footprint_time'] = $footprint_time;
		}
		 if ($common_id)
		{
			$order_row['common_id:in'] = $common_id;
		} 
		
		$de = $this->userFootprintModel->getFootprintAll($order_row);

		//开启事物
		$rs_row = array();
		$this->userFootprintModel->sql->startTransactionDb();
		
		$footprint_ids = array_column($de, 'footprint_id');
		
		$flag = $this->userFootprintModel->removeFootprint($footprint_ids);
		
		check_rs($flag, $rs_row);
		
		$flag = is_ok($rs_row);
		if ($flag !== false && $this->userFootprintModel->sql->commitDb())
		{
			$status = 200;
			$msg    = __('success');
		}
		else
		{
			$this->userFootprintModel->sql->rollBackDb();
			$status = 250;
			$msg    = __('failure');
		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);

	}

	/**
	 *
	 * 判断商品是否被收藏 wap
	 */
	public function getGoodsFI ()
	{
		$goods_id = request_int('fav_id');
		$user_id = Perm::$userId;

		$fav_result = $this->userFavoritesGoodsModel->getByWhere(array('user_id' => $user_id, 'goods_id' => $goods_id));

		$data = array();

		if (!empty($fav_result))
		{
			$data['favorites_info'] = pos($fav_result);
			$status = 200;
			$msg    = __('success');
		}
		else
		{
			$status = 250;
			$msg    = __('failure');
		}

		$this->data->addBody(-140, $data, $msg, $status);
	}
	
}

?>