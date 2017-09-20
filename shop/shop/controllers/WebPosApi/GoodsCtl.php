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
class WebPosApi_GoodsCtl extends WebPosApi_Controller
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
    }
	
    /**
	 * 获取店铺商品列表
	 *
	 * @access public
	 */
	public function getShopGoodsBaseList()
	{
		$cond_row  = array();
		$order_row = array();
		
		$page = request_int('page');
		$rows = request_int('rows');

		$cond_row['shop_id'] = request_int('shop_id');    //店铺ID
		$Goods_CommonModel   = new Goods_CommonModel();
		$Goods_BaseModel     = new Goods_BaseModel();

		//查询分类品牌和分类关联属性
		$brand_property = $this->getBrandAndProperty();
		if ( !empty($brand_property['common_ids']) )
		{
			$cond_row['common_id:IN'] = $brand_property['common_ids'];
		}
		
		$skey = request_string('skey');  //搜索的商品信息，需要区分扫码枪和商品名搜索
		
		if(request_string('searchIndex') == 'barcode')
		{
			$cond_row['goods_code'] = $skey;   //区分扫码枪录入，码枪查询的商品需要多传入一个参数
		}
		else
		{
			$cond_row['goods_name:LIKE'] = '%'.$skey.'%'; //商品名称搜索
		}

		//分类id
		$cat_id   = request_int('assistId');

		if ($cat_id > 0)
		{
			$Goods_CatModel = new Goods_CatModel();
			//查找该分类下所有的子分类
			$cat_list   = $Goods_CatModel->getCatChildId($cat_id);
			$cat_list[] = $cat_id;
			fb($cat_list);
			fb("分类列表");

			//查找该分类的父级分类
			$parent_cat_id = $Goods_CatModel->getCatParentTree($cat_id);

			$cond_row['cat_id:IN'] = $cat_list;
		}

		//商品common_id
		$com_id = request_int('common_id');
		if ($com_id)
		{
			$cond_row['common_id:IN'] = $com_id;
		}

		//商品搜索（总）
		$search = request_string('keywords');

		$searchkey = request_string('searkeywords');


		if($searchkey)
		{
			$sear_row[] = '%'.$searchkey.'%';
		}

		if ($search)
		{
			$sear_row[] = '%'.$search.'%';

			$cond_row['goods_name:LIKE'] = $sear_row;

			//记录搜索关键词
			$Search_WordModel                  = new Search_WordModel();
			$search_cond_row['search_keyword'] = $search;

			$search_row = $Search_WordModel->getSearchWordInfo($search_cond_row);

			if ($search_row)
			{
				$search_data                = array();
				$search_data['search_nums'] = $search_row['search_nums'] + 1;

				$flag = $Search_WordModel->editSearchWord($search_row['search_id'], $search_data);
			}
			else
			{
				$search_data                      = array();
				$search_data['search_keyword']    = $search;
				$search_data['search_char_index'] = Text_Pinyin::pinyin($search, '');
				$search_data['search_nums']       = 1;
				$flag                             = $Search_WordModel->addSearchWord($search_data);
			}
		}
		
		$order_row['goods_price']  	= 'ASC';
		$order_row['common_id'] 	= 'DESC';

		$cond_row['goods_stock:>'] 		= 0;							//库存大于0
		$cond_row['goods_is_shelves']   = Goods_BaseModel::GOODS_UP;	//只显示上架的商品

		$data = $Goods_BaseModel->getBaseList($cond_row,$order_row,$page,$rows);
        if($data['items'])
        {
            foreach($data['items'] as $key=>$value)
            {
                $data['items'][$key]['goods_spec'] = array_values(current(array_values($value['goods_spec'])));
            }
        }
	
		fb($data);

		$this->data->addBody(-140, $data);
	}
	
	
	/**
	 * 查询分类品牌和分类关联属性
	 * @return array
	 */
	public function getBrandAndProperty ()
	{
		$cat_id = request_int('assistId');
		$brand_id = request_int('brand_id');
		$property_id = request_int('property_id');
		$property_value_id =request_int('property_value_id');
		$search_property = request_row('search_property');

		if ( !empty($cat_id) )
		{
			//存储查询条件
			$search_string = '';
			$property_value_ids = array();

			if ( !empty($property_id) )
			{
				$search_property[$property_id] = $property_value_id;
			}

			$goodsCatModel = new Goods_CatModel();
			$goodsTypeModel = new Goods_TypeModel();
			$goodsBrandModel = new Goods_BrandModel();

			$cata_data = $goodsCatModel->getCat($cat_id);

			$cata_data = pos($cata_data);
			$type_id = $cata_data['type_id'];

			if ($type_id)
			{
				$data = $goodsTypeModel->getTypeInfo($type_id);
			}

			if ( !empty($data['property']) )
			{
				//过滤类型为 text property
				foreach ($data['property'] as $key => $property_data)
				{
					if ( $property_data['property_format'] == 'text' || empty($property_data['property_format']) || empty($property_data['property_values']) )
					{
						unset($data['property'][$key]);
					}
					else
					{
						//拼接搜索条件
						if ( !empty($search_property[$property_data['property_id']]) )
						{
							$property_value_id = $search_property[$property_data['property_id']];

							$property_array = array();
							$property_array['property_name'] = $property_data['property_name'];
							$property_array['property_value_id'] = $property_value_id;
							$property_array['property_value_name'] = $property_data['property_values'][$property_value_id]['property_value_name'];
							$search_property[$property_data['property_id']] = $property_array;

							unset($data['property'][$key]);
						}
					}
				}

				$data['search_property'] = $search_property;

				if ( !empty($data['search_property']) )
				{
					foreach ($data['search_property'] as $property_id => $property_data)
					{
						$property_value_id = $property_data['property_value_id'];
						$string = "search_property[$property_id]=$property_value_id&";
						$search_string .= $string;

						$property_value_ids[] = $property_value_id;
					}
				}

				$data['search_string'] = $search_string;
			}

			if ( !empty($brand_id) )
			{
				unset($data['brand']);

				$data['search_string'] .= "brand_id=$brand_id&";

				$search_brand =  $goodsBrandModel->getBrand($brand_id);
				if ( !empty($search_brand) )
				{
					$data['search_brand'] = pos($search_brand);
				}

			}
			else if ( !empty($data['brand']) )
			{
				$brand_list = $goodsBrandModel->getBrand($data['brand']);

				$data['brand_list'] = $brand_list;
			}


			//过滤出所有符合筛选条件的common_id
			if ( !empty($property_value_ids) )
			{
				$condi_pro_index['property_value_id:IN'] = array(72, 82);
				$goodsPropertyIndexModel = new Goods_PropertyIndexModel();
				$property_index_list = $goodsPropertyIndexModel->getByWhere( $condi_pro_index );
				$common_ids = array_column($property_index_list, 'common_id');

				$data['common_ids'] = $common_ids;
			}


			//如果有下级分类，则取出展示
			$child_cat = $goodsCatModel->getChildCat($cat_id);
			if ( !empty($cat_id) )
			{
				$data['child_cat'] = $child_cat;
			}

			return $data;
		}
	}
}

?>