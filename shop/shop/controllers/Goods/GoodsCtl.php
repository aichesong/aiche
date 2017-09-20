<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Zhuyt
 */
class Goods_GoodsCtl extends Controller
{

	public function __construct(&$ctl, $met, $typ)
	{
		parent::__construct($ctl, $met, $typ);
		$this->initData();
		$this->web = $this->webConfig();
		$this->nav = $this->navIndex();
		$this->cat = $this->catIndex();

	}

	/**
	 * 商品列表页
	 *
	 * @access public
	 */
	public function goodslist()
	{
		$cond_row = array();

		$Goods_CommonModel = new Goods_CommonModel();

		//查询分类品牌和分类关联属性
		$brand_property = $this->getBrandAndProperty();
		if ( !empty($brand_property['common_ids']) )
		{
			if ( count($brand_property['common_ids']) == 1 && $brand_property['common_ids'][0] === false )
			{
				$cond_row['common_id'] = -1;
			}
			else
			{
				$cond_row['common_id:IN'] = $brand_property['common_ids'];
			}
		}

		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = request_int('rows',12);
		$rows              = $Yf_Page->listRows;
		$offset            = request_int('firstRow', 0);
		$page              = ceil_r($offset / $rows);

        $wap_pagesize = request_int('pagesize');
		$wap_curpage = request_int('curpage');

		if ( !empty($wap_pagesize) )
		{
			$rows = $wap_pagesize;
		}

		if ( !empty($wap_curpage) )
		{
			$page = $wap_curpage;
		}

		//分类id
		$cat_id = request_int('cat_id');

		$Goods_CatModel = new Goods_CatModel();
		if ($cat_id)
		{
			//查找该分类下所有的子分类
			$cat_list   = $Goods_CatModel->getCatChildId($cat_id);
			$cat_list[] = $cat_id;
			fb($cat_list);
			fb("分类列表");

			//查找该分类的父级分类
			$parent_cat_id = $Goods_CatModel->getCatParentTree($cat_id);

			$cond_row['cat_id:IN'] = $cat_list;
		}

		//不显示供货商商品
		$shopBaseModel = new Shop_BaseModel();
		$shop_list  = $shopBaseModel -> getByWhere(array('shop_type' => 1));
		$shop_ids   = array_column($shop_list,'shop_id');
		$cond_row['shop_id:IN'] =  $shop_ids;

		//商品品牌
		$brand_id = request_int('brand_id');
		if ($brand_id)
		{
			$cond_row['brand_id:in'] = $brand_id;
		}

		//商品common_id
		$com_id = request_int('common_id');
		if ($com_id)
		{
			$cond_row['common_id:IN'] = $com_id;
		}

		//商品的配送区域
		//获取默认区域
		if(!isset($_COOKIE['area'])) {
            $cookid_area = $this->getCookieArea();
        } else {
            $Base_DistrictModel = new Base_DistrictModel();
            $dist = current($Base_DistrictModel->getByWhere(array('district_name'=>$_COOKIE['area'])));
            setcookie("goodslist_area_id", $dist['district_id']);
            $cookid_area = $Base_DistrictModel->getCookieDistrictName($dist['district_name'],2);
            setcookie("goodslist_area_name", $cookid_area['area']);
        }
        
		$transport_id = request_string('transport_id', isset($cookid_area['city']['id']) ? $cookid_area['city']['id'] : '');
		$transport_area = request_string('transport_area', isset($cookid_area['area']) ? $cookid_area['area'] : '请选择地区');
        
        //获取该售卖区域的所有模板
        if($transport_id > 0){
            $Transport_AreaModel = new Transport_AreaModel();
            $transport_area_list = $Transport_AreaModel->getAreaTemplate($transport_id);
            if($transport_area_list){
                $transport_area_id = array_column($transport_area_list,'id');
                $transport_area_id[] = 0;
                $cond_row['transport_area_id:IN'] = $transport_area_id;
            }
        }

		//pc分站
        if(isset($_COOKIE['sub_site_id']) && $_COOKIE['sub_site_id'] > 0){
            $sub_site_id = $_COOKIE['sub_site_id'];
            $pc_site = true;
        }
        
        //wap分站
        if(request_string('ua') === 'wap'){
            $sub_site_id = request_int('sub_site_id');
            $wap_site = true;
						unset($cond_row['transport_area_id:IN']);
        }
//        $op4 = request_string('op4');

        //获取分站信息
        if(Web_ConfigModel::value('subsite_is_open') && isset($sub_site_id) && $sub_site_id > 0){
            //获取站点信息
            $Sub_SiteModel = new Sub_SiteModel();
            $sub_site_district_ids = $Sub_SiteModel->getDistrictChildId($sub_site_id);
            if($sub_site_district_ids){
                $cond_row['district_id:IN'] = $sub_site_district_ids;
            }
        }

		//商品搜索（总）
		//用户输入都是不靠谱的！
		$_REQUEST['keywords'] = htmlspecialchars(strip_tags($_REQUEST['keywords']));
		$search =  request_string('keywords');
 
		$searchkey = request_string('searkeywords');

        $sear_row=array();
		if($searchkey)
		{
			$sear_row[] = '%'.$searchkey.'%';
		}

		if ($search)
        {
            /**
             * 统计中心
             */
            $analytics_ip = get_ip();
            $analytics_data = array(
                'keywords'=>$search,
                'ip'=>$analytics_ip,
                'date'=>date('Y-m-d')
            );
            Yf_Plugin_Manager::getInstance()->trigger('analyticsKeywords',$analytics_data);
            /**********************************************************************/

            $sear_row[] = '%' . $search . '%';
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
        if($sear_row){
            $cond_row['common_name:LIKE'] = $sear_row;
        }

		$cond_row['shop_status'] = Shop_BaseModel::SHOP_STATUS_OPEN;

		//上架时间，销量，价格，评论数
		$order_row = array();
		$act       = request_string('act');
		$actorder    = strtolower(request_string('actorder','desc'));
        if($actorder === 'desc'){
            $next_order = 'asc';
        }else{
            $next_order = 'desc';
        }
        
        //上架时间,这里用商品入库时间
        if ($act === 'all')
        {
            $order_row['common_id'] = $actorder;
        }
        //销量
        if ($act === 'sale')
        {
            $order_row['common_salenum'] = $actorder;
        }
		
        //销量
        if ($act === 'sale')
        {
            $order_row['common_salenum'] = $actorder;
        }

        //价格
        if ($act === 'price')
        {
            $order_row['common_price'] = $actorder;
        }

        //评论数
        if ($act === 'evaluate')
        {
            $order_row['common_evaluate'] = $actorder;
        }

		

		$op1 = request_string('op1');
		$op2 = request_string('op2');
		$op3 = request_string('op3');
		
		if ($op1)
		{
			//仅显示有货
			if ($op1 === 'havestock')
			{
				$cond_row['common_stock:>'] = 0;
			}
		}

		if ($op2)
		{
			//仅显示促销商品
			if ($op2 === 'active')
			{
				$cond_row['common_is_xian:!='] = 0;
				$cond_row['common_is_jia:!=']  = 0;
			}

		}
        
        //用于判断自营是否显示
//        $self_shop_show_key = !$sub_site_id ? 'self_shop_show' : 'self_shop_show_'.$sub_site_id;
//
//		if (Web_ConfigModel::value($self_shop_show_key) == 1)
//		{
//			//显示自营
//			if ($op3 === 'ziying')
//			{
//				$cond_row['shop_self_support'] = 1;
//			}
//
//        }else{
//            $cond_row['shop_self_support'] = 0;
//        }

		$own_shop = request_int('own_shop');
		$other_shop = request_int('other_shop');
		//自营店铺和入驻店铺同时选择，则不对该条搜索条件处理
		if (
			($own_shop || $other_shop)
			&&
			! ($own_shop && $other_shop)
		) {
			if ($own_shop) {
				$cond_row['shop_self_support'] = 1;
			} else {
				$cond_row['shop_self_support'] = 0;
			}
		}

		
		$price_from = request_float('price_from');
		if($price_from)
		{
			$cond_row['common_price:>='] = $price_from;
		}

		$price_to = request_float('price_to');
		if($price_to)
		{
			$cond_row['common_price:<='] = $price_to;
		}

		$virtual = request_float('isvirtual');
		if($virtual)
		{
			$cond_row['common_is_virtual'] = Goods_CommonModel::GOODS_VIRTUAL;
		}


		//判断是否有属性
		$property_value_row       = array();
		$cond_row['common_state'] = Goods_CommonModel::GOODS_STATE_NORMAL;
		$cond_row['common_verify'] = Goods_CommonModel::GOODS_VERIFY_ALLOW;

		

		//wap站临时关闭分销商品 sun
		if($wap_site === true){
		 		 //必须不是代发货的 说明才不是分销的商品 
		 	  	$cond_row['common_parent_id'] = 0;  
			  	$hot_cond_row['common_parent_id'] =   1;  
		}

  

		$data                     = $Goods_CommonModel->getGoodsList($cond_row, $order_row, $page, $rows, $property_value_row);
		$data['transport_area'] = $transport_area;

		$Yf_Page->totalRows = $data['totalsize'];
		$page_nav           = $Yf_Page->prompt();
		//推广产品
		$recommend_cond_row['common_state'] = Goods_CommonModel::GOODS_STATE_NORMAL;
		$recommend_cond_row['common_verify'] = Goods_CommonModel::GOODS_VERIFY_ALLOW;

		$recommend_order_row['common_is_recommend'] = 'DESC';

		//热卖推荐
		$hot_sale      = array();
		$brand_row     = array();
		$cat_row       = array();
		$recommend_row = array();



		//热卖推荐，查找商城中销量最多的商品
		$hot_order_row['common_salenum'] = 'DESC';
		$hot_sale                        = $Goods_CommonModel->getGoodsList($cond_row, $hot_order_row, 1, 3);
		$hot_sale                        = $hot_sale['items'];
		if (!$hot_sale)
		{
			$hot_cond_row['common_state'] = Goods_CommonModel::GOODS_STATE_NORMAL;
			$hot_cond_row['common_verify'] = Goods_CommonModel::GOODS_VERIFY_ALLOW;
            if($sub_site_district_ids){
                $hot_cond_row['district_id:IN'] = $sub_site_district_ids;
            }
			$hot_order_row['common_salenum'] = 'DESC';
			$hot_sale                        = $Goods_CommonModel->getGoodsList($hot_cond_row, $hot_order_row, 1, 3);
			$hot_sale                        = $hot_sale['items'];
		}


		//获取推广商品
		$Goods_RecommendModel = new Goods_RecommendModel();
		$recommond_cond_row   = array();
		$recommond_order_row  = array();
		//如果有查找的分类就显示该分类下的推广商品，如果没有传递分类就显示最新设置的分类推广
		if ($cat_id)
		{
			$recommond_cond_row['goods_cat_id'] = $cat_id;
		}
		else
		{
			$recommond_order_row['goods_recommend_id'] = 'DESC';
		}
        
        //如果有分站，查询分站
        if($sub_site_id){
            $recommond_cond_row['sub_site_id'] = $sub_site_id;
        }
        
        
		$recommend_row = $Goods_RecommendModel->getRccommonGoodsInfo($recommond_cond_row, $recommond_order_row);

		//如果商城没有设定推广商品，则将最新发布的四件商品作为推广商品显示
		if (!$recommend_row)
		{
			$recommend_order_row['common_is_recommend'] = 'DESC';
			$recommend_order_row['common_id']           = 'DESC';
            if($sub_site_district_ids){
                $recommend_cond_row['district_id:IN'] = $sub_site_district_ids;
            }
			$recommend_row                              = $Goods_CommonModel->getGoodsList($recommend_cond_row, $recommend_order_row, 1, 4);
			$recommend_row                              = $recommend_row['items'];
		}	

		//获取品牌信息
		$Goods_TypeModel = new Goods_TypeModel();
		$type_cond_row   = array();
		//如果有查找的分类就显示该分类的相关品牌，如果没有传递分类就不显示品牌
		if ($cat_id)
		{
			$type_cond_row['cat_id'] = $cat_id;
			$brand_row               = $Goods_TypeModel->getTypeBrand($type_cond_row);
		}

		//获取分类信息
		$Goods_TypeBrandModel = new Goods_TypeBrandModel();
		$tbrand_cond_row      = array();
		//如果有品牌就显示该品牌下的分类，如果没有就不显示分类
		if ($brand_id)
		{
			$tbrand_cond_row['brand_id'] = $brand_id;
			$cat_row                     = $Goods_TypeBrandModel->getBrandType($tbrand_cond_row);
		}

		$title             = Web_ConfigModel::value("category_title");//首页名;
		$this->keyword     = Web_ConfigModel::value("category_keyword");//关键字;
		$this->description = Web_ConfigModel::value("category_description");//描述;
		$this->title       = str_replace("{sitename}", Web_ConfigModel::value("site_name"), $title);
		$this->keyword       = str_replace("{sitename}", Web_ConfigModel::value("site_name"), $this->keyword);
		$this->description       = str_replace("{sitename}", Web_ConfigModel::value("site_name"), $this->description);

		//商品分类{name}{sitename} 是否会发生变化
		if ($cat_id) { //当用户搜索选中分类
			$selected_cat_rows = $Goods_CatModel->getCat($cat_id);
			$selected_cat_data = current($selected_cat_rows);
			$selected_cat_name = $selected_cat_data['cat_name'];

			$this->title       = str_replace('{name}', $selected_cat_name, $this->title);
		} else { //当用户搜索没有选中分类
			$this->title       = str_replace('商品分类{name}', "$search-", $this->title);
		}

		if ('json' == $this->typ)
		{
			$this->data->addBody(-140, $data);

		}
		else
		{
			include $this->view->getView();
		}
	}

	function search()
	{
		$sphinx_search_flag = false;
		$sphinx_search_host = false;
		$sphinx_search_port = false;
		$key                = request_string('key');

		//是否启用Sphinx搜索
		if ($sphinx_search_flag && $key && extension_loaded("sphinx") && extension_loaded("scws"))
		{
			$b_time = microtime(true);
			//$key = "我是一个测试";
			$index = "product_search";

			$so    = new Yf_Search_Scws($key);
			$words = $so->getResult();

			$sc = new SphinxClient();
			$sc->SetServer($sphinx_search_host, $sphinx_search_port);
			#$sc->SetMatchMode(SPH_MATCH_ALL);
			$sc->SetMatchMode(SPH_MATCH_EXTENDED);
			$sc->SetArrayResult(TRUE);


			$sc->setFilter('shop_statu', array(1));
			$sc->setFilter('p_status', array(1));
			$sc->setFilter('is_shelves', array(1));
			//$sc->setFilter('tg', array(crc32('false')));

			if (!empty($_GET['ptype']) and $_GET['ptype'] >= 0 and $_GET['ptype'] < count($ptype))
			{
				$sc->setFilter('type', array($_GET[ptype]));
			}

			if (isset($_GET['province']))
			{
				$sc->setFilter('provinceid', array(intval($_GET['province'])));
			}

			$order = '';

			if ($orderby == 1)
			{
				$order .= "sales DESC";
			}
			elseif ($orderby == 2)
			{
				$order .= "clicks DESC";
			}
			elseif ($orderby == 3)
			{
				$order .= "goodbad DESC";
			}
			elseif ($orderby == 4)
			{
				$order .= "uptime DESC";
			}
			elseif ($orderby == 5)
			{
				$order .= "price ASC";
			}
			elseif ($orderby == 6)
			{
				$order .= "price DESC";
			}
			else
			{
				$order .= "rank DESC, uptime DESC";
			}

			$sc->SetSortMode(SPH_SORT_EXTENDED, $order);

			if ($_GET['firstRow'])
			{
				$start = $_GET['firstRow'];
			}
			else
			{
				$start = 0;
			}

			$sc->SetLimits($start, 30, 1000);    // 最大结果集10000

			$res = $sc->Query($words, $index);

			$prol = array();

			if ($res['matches'])
			{
				foreach ($res['matches'] as $matches)
				{
					$matches['attrs']['id'] = $matches['id'];
					$prol[]                 = $matches['attrs'];
				}

			}


			include_once("includes/page_utf_class.php");
			$page           = new Page;
			$page->url      = $config['weburl'] . '/';
			$page->listRows = 30;

			if (!$page->__get('totalRows'))
			{
				$page->totalRows = $res['total'];
			}

			$prolist['list']  = $prol;
			$prolist['page']  = $page->prompt();
			$prolist['count'] = $res['total'];
			$tpl->assign("info", $prolist);
			unset($prolist);
		}

	}

	/**
	 * 商品详情页  goodsdetailinfo
	 *
	 * @access public
	 */
	public function goodDetail()
	{
		$goods_id = request_int('goods_id');

		$Goods_BaseModel = new Goods_BaseModel();
		$goods_base = $Goods_BaseModel->getGoodsInfo($goods_id);
		
		//计算商品价格
		if (isset($goods_base['goods_base']['promotion_price']) && !empty($goods_base['goods_base']['promotion_price']) && $goods_base['goods_base']['promotion_price'] < $goods_base['goods_base']['goods_price'])
		{
			$goods_base['goods_base']['old_price']  = $goods_base['goods_base']['goods_price'];
			$goods_base['goods_base']['now_price']  = $goods_base['goods_base']['promotion_price'];
			$goods_base['goods_base']['down_price'] = $goods_base['goods_base']['down_price'];
		}
		else
		{
			$goods_base['goods_base']['old_price']  = 0;
			$goods_base['goods_base']['now_price']  = $goods_base['goods_base']['goods_price'];
			$goods_base['goods_base']['down_price'] = 0;
		}

		$this->data->addBody(-140, $goods_base);

	}

	public function getGoodsidByCid()
	{
		$cid = request_int('cid');


		$Goods_CommonModel = new Goods_CommonModel();
		$property_value_row       = array();
		$cond_row['common_id'] = $cid;
		$data                     = $Goods_CommonModel->getGoodsList($cond_row);

		$goods_id = $data['items'][0]['goods_id'];

		$this->data->addBody(-140, array('goods_id' => $goods_id));

	}

	/**
	 * 获取商品详情页面商品详情
	 *
	 * 2017.6.15 hp
	 */
	public function getGoodsDetailFormat()
	{
		$goods_id = request_int('gid');
		//关联样式
		$Goods_BaseModel = new Goods_BaseModel();
		$Goods_CommonModel = new Goods_CommonModel();
		$Goods_FormatModel = new Goods_FormatModel();
		$goods_data        = $Goods_BaseModel->getOne($goods_id);
		$common_id         = $goods_data['common_id'];
		$common_data       = $Goods_CommonModel->getOne($common_id);
		$goods_detail    = $Goods_BaseModel->getGoodsDetailInfoByGoodId($goods_id);
		$goods_check     = $Goods_BaseModel->checkGoodsII($goods_id);
		$data = [];
		if($goods_detail && $goods_check)
		{
			if ($common_data)
			{
				$common_formatid_top = $common_data['common_formatid_top'];
				if ($common_formatid_top)
				{
					//商品详情头部信息
					$goods_format_top = $Goods_FormatModel->getOne($common_formatid_top);
					if(isset($goods_format_top)&&!empty($goods_format_top))
					{
						$data['goods_format_top'] = $goods_format_top['content'];
					}
					else
					{
						$data['goods_format_top'] = '';
					}
				}
				else
				{
					$data['goods_format_top'] = '';
				}

				$common_formatid_bottom = $common_data['common_formatid_bottom'];
				if ($common_formatid_bottom)
				{
					//商品详情底部信息
					$goods_format_bottom = $Goods_FormatModel->getOne($common_formatid_bottom);
					if(isset($goods_format_bottom)&&!empty($goods_format_bottom))
					{
						$data['goods_format_bottom'] = $goods_format_bottom['content'];
					}
					else
					{
						$data['goods_format_bottom'] = '';
					}
				}
				else
				{
					$data['goods_format_bottom'] = '';
				}
				//商品品牌名
				if($goods_detail['common_base']['brand_name'])
				{
					$data['brand_name'] = $goods_detail['common_base']['brand_name'];
				}
				else
				{
					$data['brand_name'] = '';
				}
				//商品详情
				$data['common_detail'] = $goods_detail['common_base']['common_detail'];
				//jquery img lazyload
				$data['common_detail_lazy'] =  str_replace("src=","class='lazy' width=800 height=800  data-original=",$data['common_detail']);
			 
				//商品属性
				$data['common_property_row'] = $goods_detail['common_base']['common_property_row'];
			}
			$this->data->addBody(-140,$data);
		}
	}
	
	/**
	 * 商品详情页  goodsdetailinfo
	 *
	 * @access public
	 */
	public function goods()
	{
		$cid = request_int('cid');
		$goods_id        = request_int('gid', request_int('goods_id'));
		//如果传递过来的是common_id，则从此common_id中的goods_id中选择一个有效的goods_id 
		if($cid && !$goods_id)
		{ 
			$Goods_CommonModel = new Goods_CommonModel();
			$cond_row       = array();
			$cond_row['common_id'] = $cid;
			$data                     = $Goods_CommonModel->getGoodsList($cond_row);

			$goods_id = $data['items'][0]['goods_id'];
		}

		//区分wap pc端
		if ( $this->typ == 'json' )
		{
			$is_wap = true;
		}
		else
		{
			$is_wap = false;
		}
		$goods_data = array();

		//添加商品点击数
		$Goods_BaseModel = new Goods_BaseModel();
		$good_click_row  = array('goods_click' => '1');
		$Goods_BaseModel->editBase($goods_id, $good_click_row, true);

		//1.商品信息（商品活动信息，评论数，销售数，咨询数）
		$goods_detail    = $Goods_BaseModel->getGoodsDetailInfoByGoodId($goods_id);

		//如果是wap  
		//wap站临时关闭分销商品 sun
	 
    if(request_string('ua') === 'wap'){ 
        $wap_site = true;
        $check = $goods_detail['common_base']['common_parent_id']; 
 
        if($goods_detail && $check > 0 ){
        	unset($goods_detail);
        } 
    }
		
 

		$goods_check     = $Goods_BaseModel->checkGoodsII($goods_id);

		if (!$goods_detail || !$goods_check)
		{
			$this->view->setMet('404');
		}
		else
		{
			$user_id = Perm::$userId;
			//添加用户足迹
			if (Perm::checkUserPerm())
			{
				$user_id = Perm::$userId;

				$User_FootprintModel = new User_FootprintModel();

				//先判断该用户是否浏览过该商品
				$foot_cond_row['user_id']   = $user_id;
				$foot_cond_row['common_id'] = $goods_detail['goods_base']['common_id'];
				$foot_id                    = $User_FootprintModel->getKeyByWhere($foot_cond_row);

				//如果用户曾经浏览过该商品则修改浏览时间
				if ($foot_id)
				{
					$edit_foot_row                   = array();
					$edit_foot_row['footprint_time'] = get_date_time();
					$User_FootprintModel->editFootprint($foot_id, $edit_foot_row);
				}
				else
				{
					//如果没有浏览过改商品则插入数据
					$read_add_row                   = array();
					$read_add_row['user_id']        = $user_id;
					$read_add_row['common_id']      = $goods_detail['goods_base']['common_id'];
					$read_add_row['footprint_time'] = get_date_time();
					$User_FootprintModel->addFootprint($read_add_row);
				}
			}

			$Goods_CatModel = new Goods_CatModel();
			//查找该分类的父级分类
			$parent_cat = $Goods_CatModel->getCatParent($goods_detail['goods_base']['cat_id']);
			$cat_info = $Goods_CatModel->getOne($goods_detail['goods_base']['cat_id']);
			if($cat_info)
			{
				$cat_info['ext'] = 1;
				$parent_cat[] = $cat_info;
			}


			//判断此商品是否被关注过
			$User_FavoritesGoodsModel = new User_FavoritesGoodsModel();
			$user_favorites_goods_row['user_id'] = $user_id;
			$user_favorites_goods_row['goods_id'] = $goods_detail['goods_base']['goods_id'];
			$user_favorites_goods = $User_FavoritesGoodsModel->getKeyByWhere($user_favorites_goods_row);
			if($user_favorites_goods)
			{
				$isFavoritesGoods = true;
			}
			else
			{
				$isFavoritesGoods = false;
			}

			//计算商品的销售数量1.直接显示本件商品的销售数量，2.显示本类common商品的销售数量

			$common_goods = $Goods_BaseModel->getByWhere(array('common_id' => $goods_detail['goods_base']['common_id']));
			$count_sale   = 0;
			foreach ($common_goods as $comkey => $comval)
			{
				$count_sale += $comval['goods_salenum'];
			}
			$goods_detail['goods_base']['count_sale'] = $count_sale;

			//获取商品所在地
			$Base_DistrictModel = new Base_DistrictModel();
			$goods_location_row = $Base_DistrictModel->getByWhere(array('district_id:IN' => $goods_detail['common_base']['common_location']));
			$goods_location = '';
			if($goods_location_row)
			{
				$goods_location_row = array_values($goods_location_row);
				foreach($goods_location_row as $localkey => $localval)
				{
					$goods_location .= $localval['district_name'].'  ';
				}
			}
 
			if(Web_ConfigModel::value('Plugin_Directseller'))
			{			
				$goods_detail['recImages'] = '';
				//推荐者上传的图片
				$PluginManager = Yf_Plugin_Manager::getInstance();
				$data = $PluginManager->trigger('rec_goods');
				$goods_detail['recImages'] = isset($data['Plugin_Directseller_recGoods']) ? $data['Plugin_Directseller_recGoods'] : ''; 
				//--END 
			}
 
			//2.店铺信息
			$Shop_BaseModel = new Shop_BaseModel();
			$shop_detail    = $Shop_BaseModel->getShopDetail($goods_detail['goods_base']['shop_id']);
            //判断是否显示自营店铺
            if(isset($_COOKIE['sub_site_id']) && $_COOKIE['sub_site_id'] > 0){
                $sub_site_id = $_COOKIE['sub_site_id'];
            }
            $self_shop_show_key = !$sub_site_id ? 'self_shop_show' : 'self_shop_show_'.$sub_site_id;
            $check_shop_show = $shop_detail['shop_self_support'] == 'true' && !Web_ConfigModel::value($self_shop_show_key) ? false : true;
            
            if(!$shop_detail || !$check_shop_show){
                $this->view->setMet('404');
            }
			//查找该店铺下的实体店铺
			$Shop_EntityModel = new Shop_EntityModel();
			$entity_shop = $Shop_EntityModel->getByWhere(array("shop_id" => $goods_detail['goods_base']['shop_id']));

			//检测商品是否已经下架
			$goods_status = 1;
			if ($goods_detail['goods_base']['goods_is_shelves'] != Goods_BaseModel::GOODS_UP || $goods_detail['common_base']['common_state'] != Goods_CommonModel::GOODS_STATE_NORMAL)
			{
				$goods_status = 0;
			}
			//检查是否为店主本人
			$shop_owner = 0;

			if ($shop_detail['shop_id'] == Perm::$shopId  || $shop_detail['user_id'] == Perm::$userId)
			{
				$shop_owner = 1;
			}

            //判断是否可以门店自提
            $Chain_GoodsModel=new Chain_GoodsModel();
            $chain_row['shop_id:=']=$goods_detail['goods_base']['shop_id'];
            $chain_row['goods_id:=']=$goods_id;
            $chain_row['goods_stock:>']=0;

            $chain_goods=$Chain_GoodsModel->getByWhere($chain_row);
            $goods_detail['chain_stock']=0;

            if($chain_goods){
                $goods_detail['chain_stock']=1;
            }

			//如果使用售卖区域（现在商品表中暂时没有字段表面售卖区域）


			$IsHaveBuy = 0;
			if ($user_id)
			{
				//团购商品是否已经开始
				//查询该用户是否已购买过该商品
				$Order_GoodsModel                          = new Order_GoodsModel();
				$order_goods_cond['common_id']             = $goods_detail['goods_base']['common_id'];
				$order_goods_cond['buyer_user_id']         = $user_id;
				$order_goods_cond['order_goods_status:!='] = Order_StateModel::ORDER_REFUND_FINISH;
				$order_goods_cond['order_goods_status:!='] = Order_StateModel::ORDER_CANCEL;
				$order_list                                = $Order_GoodsModel->getByWhere($order_goods_cond);

				$order_goods_count = 0;
                foreach($order_list as $val){
                    if($val['order_goods_benefit'] && $val['common_id']==$goods_detail['goods_base']['common_id']){
                        $order_goods_count+=$val['order_goods_num'];
                    }

                }
				if (isset($goods_detail['goods_base']['promotion_type']))
				{
					$promotion_type = $goods_detail['goods_base']['promotion_type'];

					if ($promotion_type == 'groupbuy')
					{
						//检测是否限购数量
						$upper_limit = $goods_detail['goods_base']['upper_limit'];
						if ($upper_limit > 0 && $order_goods_count >= $upper_limit)
						{
							$IsHaveBuy = 1;
						}
					}
				}


				//商品限购数量判断
				if ($goods_detail['common_base']['common_limit'] > 0 && $order_goods_count >= $goods_detail['common_base']['common_limit'])
				{
					$IsHaveBuy = 1;
				}

			}

            $IsOfflineBuy=0;
            if($user_id){
                //团购商品是否已经开始
                //查询该用户是否已购买过该商品
                $Order_GoodsModel                          = new Order_GoodsModel();
                $order_goods_cond['common_id']             = $goods_detail['goods_base']['common_id'];
                $order_goods_cond['buyer_user_id']         = $user_id;
                $order_goods_cond['order_goods_status:!='] = Order_StateModel::ORDER_REFUND_FINISH;
                $order_goods_cond['order_goods_status:!='] = Order_StateModel::ORDER_CANCEL;
                $order_list                                = $Order_GoodsModel->getByWhere($order_goods_cond);

                $order_goods_count = count($order_list);

                if (isset($goods_detail['goods_base']['promotion_type']))
                {
                    $promotion_type = $goods_detail['goods_base']['promotion_type'];
                   
                    if ($promotion_type == 'xianshi')
                    {

                        
                        $lower_limit = $goods_detail['goods_base']['lower_limit'];
                        if ($lower_limit > 0 && $order_goods_count < $lower_limit)
                        {
                            $IsOfflineBuy = $lower_limit;
                        }
                    }
                }

            }


			//计算限购数量
			if (isset($goods_detail['goods_base']['upper_limit']))
			{
				if ($goods_detail['goods_base']['upper_limit'] && $goods_detail['common_base']['common_limit'])
				{
					if ($goods_detail['goods_base']['upper_limit'] >= $goods_detail['common_base']['common_limit'])
					{
						$goods_detail['buy_limit'] = $goods_detail['common_base']['common_limit'];
					}
					else
					{
						$goods_detail['buy_limit'] = $goods_detail['goods_base']['upper_limit'];
					}
				}
				elseif ($goods_detail['goods_base']['upper_limit'] && !$goods_detail['common_base']['common_limit'])
				{
					$goods_detail['buy_limit'] = $goods_detail['goods_base']['upper_limit'];
				}
				elseif (!$goods_detail['goods_base']['upper_limit'] && $goods_detail['common_base']['common_limit'])
				{
					$goods_detail['buy_limit'] = $goods_detail['common_base']['common_limit'];
				}
				else
				{
					$goods_detail['buy_limit'] = 0;
				}
			}
			else
			{
				$goods_detail['buy_limit'] = $goods_detail['common_base']['common_limit'];
			}


			$shop_id = $shop_detail['shop_id'];
			$Goods_CommonModel   = new Goods_CommonModel();
			if ($shop_id)
			{
				$data_recommon       = $Goods_CommonModel->listByWhere(array(
																		   'shop_id' => $shop_id
																	   ), array('common_is_recommend' => 'desc','common_sell_time' => 'desc'), 0, 4);
				$data_recommon_goods = $Goods_CommonModel->getRecommonRow($data_recommon);

				//推荐商品
				$data_foot_recommon       = $Goods_CommonModel->listByWhere(array(
																				'shop_id' => $shop_id
																			), array('common_is_recommend' => 'DESC'), 0, 5);
				$data_foot_recommon_goods = $Goods_CommonModel->getRecommonRow($data_foot_recommon);

				//热门销售
				$data_hot_salle = $Goods_CommonModel->getHotSalle($shop_id, $is_wap);
				$data_salle     = $Goods_CommonModel->getRecommonRow($data_hot_salle);
				//热门收藏
				$data_hot_collect = $Goods_CommonModel->getHotCollect($shop_id);
				$data_collect     = $Goods_CommonModel->getRecommonRow($data_hot_collect);

				//商品咨询数量
				$Consult_BaseModel = new Consult_BaseModel();
				$data_consult      = $Consult_BaseModel->getByWhere(array(
																		'goods_id' => $goods_id,
																		'shop_id' => $shop_id
																	));
				$consult_num       = count($data_consult);
			}
			
		}
		$title             = Web_ConfigModel::value("product_title");//首页名;
		$this->keyword     = Web_ConfigModel::value("product_keyword");//关键字;
		$this->description = Web_ConfigModel::value("product_description");//描述;
		$this->title       = str_replace("{sitename}", Web_ConfigModel::value("site_name"), $title);
		$this->title       = str_replace("{name}", $goods_detail['goods_base']['goods_name'], $this->title);
		$this->keyword       = str_replace("{sitename}", Web_ConfigModel::value("site_name"), $this->keyword);
		$this->keyword       = str_replace("{name}", $goods_detail['goods_base']['goods_name'], $this->keyword);
		$this->description       = str_replace("{sitename}", Web_ConfigModel::value("site_name"), $this->description);
		$this->description        = str_replace("{name}", $goods_detail['goods_base']['goods_name'], $this->description );

		if($goods_data){
			$this->shopCustomServiceModel = new Shop_CustomServiceModel;
			
			$cond_row['shop_id'] = $goods_data['shop_id'];
			
			$service = $this->shopCustomServiceModel->getServiceList($cond_row);
			if($service['items']){
				foreach($service['items'] as $key => $val)
				{
					//QQ
					if($val['tool'] == 1)
					{
						$service[$key]["tool"] = "<a target='_blank' href='http://wpa.qq.com/msgrd?v=3&uin=".$val['number']."&site=qq&menu=yes'><img border='0' src='http://wpa.qq.com/pa?p=2:".$val['number'].":41 &amp;r=0.22914223582483828' alt='点击这里'></a>";
					}
					//旺旺
					if($val['tool'] == 2)
					{
						$service[$key]["tool"] = "<a target='_blank' href='http://www.taobao.com/webww/ww.php?ver=3&amp;touid=".$val['number']."&amp;siteid=cntaobao&amp;status=1&amp;charset=utf-8' ><img border='0' src='http://amos.alicdn.com/online.aw?v=2&amp;uid=".$val['number']."&amp;site=cntaobao&s=1&amp;charset=utf-8' alt='点击这里' /></a>";
					}
					//IM
					if($val['tool'] ==3)
					{
						$service[$key]["tool"] = '<a href="javascript:;" class="chat-enter" onclick="return chat(\''.$val['number'].'\');"><img src="'.$this->view->img.'/icon-im.gif" alt=""></a>';
					}
					//$service[$key]["tool"] = $val['tool'];
					$service[$key]["number"] = $val['number'];
					$service[$key]["name"] = $val['name'];
					$service[$key]["id"] = $val['id'];

					if($val['type']==1)
					{
						$de['after'][] = $service[$key];	
					}
					else
					{
						$de['pre'][] = $service[$key];
					}
				}
				$service = array();
				$service = $de;
			}

		}



		// 促销活动没开始的时候，最低购买数是1，而不是活动的最低购买数。 $IsOfflineBuy = 0
		// sun
		if(isset($goods_detail['goods_base']['promotion_type']) && $goods_detail['goods_base']['promotion_type']){
	      $now_time = time();
	      $start_time = strtotime($goods_detail['goods_base']['groupbuy_starttime']);
	      $end_time = strtotime($goods_detail['goods_base']['groupbuy_endtime']);
	      if($start_time > $now_time){
	          $goods_detail['goods_base']['lower_limit'] = 1;
	          $IsOfflineBuy = 0 ;
	      }
	      if($end_time > $now_time && $start_time < $now_time){
	          $time_tips = __('距结束'); 
	      } 
	   }    
	 
	   
        
		if ('json' == $this->typ)
		{
			/**
			 * ly wap 端返回数据
			 *
			 */
			$data 					= array();
			$goods_eval_list 		= array();
			$goods_evaluate_info 	= array();
			$goods_hair_info 		= array();
			$goods_image  			= '';
			$goods_info 			= array();
			$spec_list 				= array();
			$spec_image				= array();
			$store_info 			= array();
			$mansong_info			= array();
			$common_id 				= $goods_detail['common_base']['common_id'];

			//商品详情
			$goods_info = array_merge($goods_detail['common_base'], $goods_detail['goods_base']);

			if (empty($goods_info['common_spec_name'])) {
				$goods_info['common_spec_name'] = "";
				$goods_info['common_spec_value'] = "";
			}

			//好评率
			$Goods_EvaluationModel =  new Goods_EvaluationModel();
			$all_count    = $Goods_EvaluationModel->countEvaluation($common_id, 'all');
			$good_count   = $Goods_EvaluationModel->countEvaluation($goods_detail['common_base']['common_id'], 'good');
			if($all_count != 0)
			{
				$good_pre   = round($good_count / $all_count * 100);
			}
			else
			{
				$good_pre   = 100;
			}

			//配送信息
			$goods_hair_info['content'] 	= $goods_detail['shop_base']['shipping'];
			$goods_hair_info['if_store_cn'] = empty($goods_detail['goods_base']['goods_stock']) ? __('无货') : __('有货');
			$goods_hair_info['if_store'] 	= empty($goods_detail['goods_base']['goods_stock']) ? false : true;
			
            //定位
            $subSiteModel = new Sub_SiteModel();
            $lbs_geo = request_string('lbs_geo');
            $lbs_geo_array = explode(',', $lbs_geo);
            if(in_array($lbs_geo_array[0], array('province:上海市','province:北京市','province:天津市','province:重庆市'))){
                $level = 3;
            } else {
                $level = 2;
            }
            
            $user_lbs_geo = $subSiteModel->getLbsGeo($lbs_geo,$level);
            //获取默认配送区域运费
            if($goods_detail['common_base']['transport_area_id']){
                if($user_lbs_geo['district_id']){
                    $area_model = new Transport_AreaModel();
                    $isSale = $area_model->isSale($goods_detail['common_base']['transport_area_id'], $user_lbs_geo['district_id']);
                    if(!$isSale){
                        $goods_hair_info['content'] = '无货';
                        $goods_hair_info['if_store_cn'] = '无货';
                        $goods_hair_info['if_store'] = false;
                    }else{
                        $transportInfo = $Goods_BaseModel->getTransportInfo($user_lbs_geo['district_id'], $goods_detail['common_base']['common_id']);
                        $goods_hair_info['content'] = $transportInfo['data']['transport_str'];
                        if($transportInfo['result'] == false){
                            $goods_hair_info['if_store_cn'] = '无货';
                            $goods_hair_info['if_store'] = false;
                        }
                    }
                }
                
            }else{
                $goods_hair_info['content'] = '无货';
                $goods_hair_info['if_store_cn'] = '无货';
                $goods_hair_info['if_store'] = false;
            }
			if (isset($user_lbs_geo['district_name']) && $user_lbs_geo['district_name'] ){
				$goods_hair_info['area_name'] = __($user_lbs_geo['district_name']);
				$goods_hair_info['district_id'] = $user_lbs_geo['district_id'];

				$goods_hair_info['transport_data'] = $this->getTramsportData($goods_hair_info['district_id'], $common_id);
			} else {
				$goods_hair_info['area_name'] = __('全国');
				$goods_hair_info['district_id'] = 0;
			}
			//图片信息
			if ( isset($goods_detail['goods_base']['image_row']) && !empty($goods_detail['goods_base']['image_row']) )
			{
				$images_list = array_column($goods_detail['goods_base']['image_row'], 'images_image');
				$images_list = array_map(function ($img) {
					return image_thumb($img, 360, 360);
				}, $images_list);
				$goods_image = implode(',', $images_list);
			}
			else
			{
				$goods_image = $goods_detail['goods_base']['goods_image'];
			}

			//满送
			$mansong_info = $goods_detail['mansong_info'];

			if ( !empty($goods_detail['common_base']['common_spec_name']) )
			{
				//商品规格
				$spec_list = $Goods_BaseModel->createSGIdByWap($goods_detail['common_base']['common_id']);

				//商品规格颜色图
				if ( !empty($goods_detail['common_base']['common_spec_value_color']) )
				{
					$spec_image = $goods_detail['common_base']['common_spec_value_color'];
				}
			}
 
			//店铺信息
			$store_info['is_own_shop'] 	=	$shop_detail['shop_self_support'];
			$store_info['member_id'] 	=	$shop_detail['user_id'];
			$store_info['member_name'] 	=	$shop_detail['user_name'];
			$store_info['store_id'] 	=	$shop_detail['shop_id'];
			$store_info['store_name'] 	=	$shop_detail['shop_name'];
			$store_info['store_logo'] 	=	$shop_detail['shop_logo'];
			$store_info['store_tel']   = $shop_detail['shop_tel'];
			$store_credit = array();

			$store_credit['store_deliverycredit'] 	=	array();
			$store_credit['store_deliverycredit']['credit']	= number_format($shop_detail['shop_send_scores'], 2, '.', '');
			$store_credit['store_deliverycredit']['text']	= "物流";

			$store_credit['store_desccredit'] 		=	array();
			$store_credit['store_desccredit']['credit']		= number_format($shop_detail['shop_desc_scores'], 2, '.', '');
			$store_credit['store_desccredit']['text']		= "描述";

			$store_credit['store_servicecredit'] 	=	array();
			$store_credit['store_servicecredit']['credit']	= number_format($shop_detail['shop_service_scores'], 2, '.', '');
			$store_credit['store_servicecredit']['text']	= "服务";

			$store_info['store_credit'] = $store_credit;

			$data['goods_id']				= $goods_id;
			$data['goods_info'] 			= $goods_info; 				//商品详情

			$data['goods_commend_list'] 	= $data_salle; 				//推荐商品（销量）
			$data['goods_eval_list'] 		= $goods_eval_list; 		//商品评论
			$data['goods_evaluate_info'] 	= $goods_evaluate_info; 	//商品评论

			$data['goods_hair_info'] 		= $goods_hair_info; 		//售卖区域
			$data['goods_image'] 			= $goods_image; 			//商品图片
			$data['mansong_info'] 			= $mansong_info; 			//商品满送
			if(empty($spec_list))
			{
				$spec_list['重量'] = '';
			}
			$data['spec_list'] 			= $spec_list; 				//商品规格
			$data['spec_image'] 			= $spec_image; 				//商品颜色
			$data['store_info'] 			= $store_info; 				//店铺信息
			$data['buyer_limit']           = $goods_detail['buy_limit'];  //限购数量
			$data['is_favorate']			= $isFavoritesGoods;		//是否收藏过商品
			$data['shop_owner']			= $shop_owner;				//是否为店主
			$data['isBuyHave']				= $IsHaveBuy;				//是否已达限购数量
			$data['good_pre']             = $good_pre;   				//好评率

			if(Web_ConfigModel::value('Plugin_Directseller'))
			{
				$data['rec_images']             = $goods_detail['recImages'];//推荐者上传图片
			}

			foreach($data['goods_commend_list'] as $dkey=>$dval)
			{
				if($data['goods_commend_list'][$dkey]['common_spec_name'] == null)
					$data['goods_commend_list'][$dkey]['common_spec_name'] = '';
				if($data['goods_commend_list'][$dkey]['common_spec_value'] == null)
					$data['goods_commend_list'][$dkey]['common_spec_value'] = '';
				if($data['goods_commend_list'][$dkey]['common_property'] == null)
					$data['goods_commend_list'][$dkey]['common_property'] = '';
				if($data['goods_commend_list'][$dkey]['common_location'] == null)
					$data['goods_commend_list'][$dkey]['common_location'] = '';
				if($data['goods_commend_list'][$dkey]['common_distributor_description'] == null)
					$data['goods_commend_list'][$dkey]['common_distributor_description'] = '';
			}

			

			//获取商品的促销信息
			$promotion_info = $this->getPromotionInfo($goods_id);
			$data['promotion_info'] = $promotion_info;
			$this->data->addBody(-140,$data);
		}
		else
		{
            //获取商品的物流和运费信息
            $cookie_area = $this->getCookieArea();
            if($cookie_area['city']['id']){
                $transportInfo = $this->getTramsportData($cookie_area['city']['id'], $goods_detail['goods_base']['common_id']);
                $transportInfo['area'] = $cookie_area['area'];
                $transportInfo['area_id'] = $cookie_area['city']['id'];
            }else{
                $transportInfo = array();
            }
            $goods_detail['transport'] = $transportInfo;
			include $this->view->getView();
		}
	}
	
	/**
	 * 取得商品信息
	 *
	 * @access public
	 */
	public function getGoodsDetailInfo()
	{
		$goods_id = request_int("gid");

		//商品detail信息
		$Goods_BaseModel = new Goods_BaseModel();
		$data['goods']   = $Goods_BaseModel->getGoodsDetailInfoByGoodId($goods_id);

		$this->data->addBody(-140, $data);

		return $data;
	}

	/**
	 * 获取店铺分类
	 *
	 * @access public
	 */

	public function getShopCat() {
		$shop_id = request_int("shop_id");
		$shopGoodCatModel = new Shop_GoodCatModel();
		$cat_row['shop_id'] = $shop_id;
		$shop_cat           = $shopGoodCatModel->getGoodCatList($cat_row);

		if ('json' == $this->typ)
		{
			$shopBaseModel = new Shop_BaseModel();
			$shop_base = $shopBaseModel->getBase($shop_id);
			$shop_base = pos($shop_base);

			$shop_cat = array_values($shop_cat);
			$data['store_goods_class'] = $shop_cat;
			$data['shop_id'] 		   = $shop_id;
			$data['shop_name'] 		   = $shop_base['shop_name'];
			$this->data->addBody(-140, $data);
		}
		else
		{
			include $this->view->getView();
		}

	}
	
	/**
	 * 取得商品销售信息
	 *
	 * @access public
	 */
	public function getGoodsSaleList()
	{
		$goods_id          = request_int('goods_id');
		$Yf_Page           = new Yf_Page();
		$Yf_Page->listRows = 10;
		$rows              = $Yf_Page->listRows;
		$offset            = request_int('firstRow', 0);
		$page              = ceil_r($offset / $rows);
		
		$Order_GoodsModel     = new Order_GoodsModel();
		$cond_row             = array();
		$cond_row['goods_id'] = $goods_id;
		$data                 = $Order_GoodsModel->getGoodSaleList($cond_row, array('order_goods_id' => 'DESC'), $page, $rows);

		fb($data);
		fb('销售记录');
		$Yf_Page->totalRows = $data['totalsize'];
		$page_nav           = $Yf_Page->ajaxprompt();

		include $this->view->getView();
	}

	/*
	 * 获取商品咨询
	 */
	public function getConsultListRows()
	{
		$goods_id = request_int('goods_id');

		$Yf_Page = new Yf_Page();
		//$Yf_Page->listRows = 1;
		$rows   = $Yf_Page->listRows;
		$offset = request_int('firstRow', 0);
		$page   = ceil_r($offset / $rows);

		$ConsultBaseModel     = new Consult_BaseModel();
		$cond_row             = array();
		$cond_row['goods_id'] = $goods_id;
		$consult_base_data    = $ConsultBaseModel->getBaseList($cond_row, array(), $page, $rows);

		$Yf_Page->totalRows = $consult_base_data['totalsize'];
		$page_nav           = $Yf_Page->ajaxprompt();

		//头部
		$Web_ConfigModel = new Web_ConfigModel();
		$head            = $Web_ConfigModel->getConfigValue('consult_header_text');

		include $this->view->getView();
	}

	/**
	 * 取得商品评价信息
	 *
	 * @access public
	 */
	public function getGoodsEvaluationList()
	{
		$common_id = request_int('common_id');
		$type     = request_string('type', 'all');
		$source   = request_string('sou', 'pc');

		if ( $this->typ == 'json' )
		{
			//wap  根据goods_id 找 common_d
			$goods_id = request_int('goods_id');
			$goodsBaseModel = new Goods_BaseModel();
			$goods_base = $goodsBaseModel->getBase($goods_id);
			$goods_base = pos($goods_base);
			$common_id = $goods_base['common_id'];
		}

		$Goods_EvaluationModel = new Goods_EvaluationModel();
		//获取商品的评价信息
		$all_count    = $Goods_EvaluationModel->countEvaluation($common_id, 'all');
		$img_count    = $Goods_EvaluationModel->countEvaluation($common_id, 'image');
		$good_count   = $Goods_EvaluationModel->countEvaluation($common_id, 'good');
		$middle_count = $Goods_EvaluationModel->countEvaluation($common_id, 'middle');
		$bad_count    = $Goods_EvaluationModel->countEvaluation($common_id, 'bad');
		
		if ($all_count != 0)
		{
			$good_pre   = round($good_count / $all_count * 100);
			$middle_pre = round($middle_count / $all_count * 100);
			$bad_pre    = round($bad_count / $all_count * 100);
		}
		else
		{
			$good_pre   = 100;
			$middle_pre = 100;
			$bad_pre    = 100;
		}


		//获取商品的评价列表
		$Yf_Page = new Yf_Page();
		$Yf_Page->listRows = 10;
		$rows   = $Yf_Page->listRows;
		$offset = request_int('firstRow', 0);
		$page   = ceil_r($offset / $rows);

		$order_row             = array();
		$cond_row['common_id']  = $common_id;
		$cond_row['status:!='] = Goods_EvaluationModel::DISPLAY;
		$order_row['create_time'] = 'DESC';
		$order_row['status'] = 'DESC';

		if ( $this->typ == 'json' )
		{
			$page = request_int('curpage');
			$rows	 = request_int('page');

			switch($type)
			{
				case 1:
					$type = 'good';
					break;
				case 2:
					$type = 'middle';
					break;
				case 3:
					$type = 'bad';
					break;
				case 4:
					$type = 'image';
					break;
				default:
					$type = 'all';
					break;
			}
		}

		$data = $Goods_EvaluationModel->getEvaluationList($cond_row, $order_row, $page, $rows, $type);

		fb($data);
		fb('评论列表');

		$Yf_Page->totalRows = $data['totalsize'];
		$page_nav           = $Yf_Page->ajaxprompt();


		if ( $source == 'wap' )
		{
			$this->data->addBody(-140, $data);
		}
		else
		{
			include $this->view->getView();
		}
	}

	/**
	 * 收藏商品
	 *
	 * @author     Zhuyt
	 */
	public function collectGoods()
	{
		$goods_id = request_int('goods_id');

		if (Perm::checkUserPerm())
		{
			$user_id = Perm::$userId;
			//用户登录情况下,插入用户收藏商品表
			$add_row             = array();
			$add_row['user_id']  = $user_id;
			$add_row['goods_id'] = $goods_id;

			$User_FavoritesGoodsModel = new User_FavoritesGoodsModel();
			//开启事物
			$User_FavoritesGoodsModel->sql->startTransactionDb();

			$res = $User_FavoritesGoodsModel->getFavoritesGoods($add_row);

			if ($res)
			{
				$flag        = false;
				$data['msg'] = __("您已收藏过该商品！");

			}
			else
			{
				$add_row['favorites_goods_time'] = get_date_time();


				$User_FavoritesGoodsModel->addGoods($add_row);

				//商品详情中收藏数量增加
				$Goods_BaseModel           = new Goods_BaseModel();
				$goods_base = $Goods_BaseModel->getOne($goods_id);
				$edit_row                  = array();
				$edit_row['goods_collect'] = '1';
				$flag                      = $Goods_BaseModel->editBase($goods_id, $edit_row, true);

				//商品common中
				$Goods_CommonModel = new Goods_CommonModel();
				$edit_common_row = array();
				$edit_common_row['common_collect'] = '1';
				$Goods_CommonModel = $Goods_CommonModel->editCommonTrue($goods_base['common_id'],$edit_common_row);

			}


		}
		else
		{
			$flag = false;
		}

		if ($flag && $User_FavoritesGoodsModel->sql->commitDb())
		{
			$status      = 200;
			$msg         = __('success');
			$data['msg'] = $data['msg'] ? $data['msg'] : __("收藏成功！");

			//删除收藏商品成功添加数据到统计中心
			$analytics_data = array(
				'product_id'=>$goods_id,
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsProductCollect',$analytics_data);
			/******************************************************/
		}
		else
		{
			$User_FavoritesGoodsModel->sql->rollBackDb();
			$m           = $User_FavoritesGoodsModel->msg->getMessages();
			$msg         = $m ? $m[0] : __('failure');
			$status      = 250;
			$data['msg'] = $data['msg'] ? $data['msg'] : __("收藏失败！");
		}

		$this->data->addBody(-140, $data, $msg, $status);
	}

	/**
	 * 取消收藏商品
	 *
	 * @author     Zhuyt
	 */
	public function canleCollectGoods()
	{
		$goods_id = request_int('goods_id');

		if (Perm::checkUserPerm())
		{
			$user_id = Perm::$userId;
			//用户登录情况下,删除用户收藏商品
			$fav_row             = array();
			$fav_row['user_id']  = $user_id;
			$fav_row['goods_id'] = $goods_id;

			$User_FavoritesGoodsModel = new User_FavoritesGoodsModel();
			//开启事物
			$User_FavoritesGoodsModel->sql->startTransactionDb();
			$res = $User_FavoritesGoodsModel->getFavoritesGoods($fav_row);

			if ($res)
			{
				$User_FavoritesGoodsModel->removeGoods($res['favorites_goods_id']);
			}

			//商品详情中收藏数量减少
			$Goods_BaseModel           = new Goods_BaseModel();
			$goods_base				   = $Goods_BaseModel->getOne($goods_id);
			$edit_row                  = array();
			$edit_row['goods_collect'] = '-1';
			$flag                      = $Goods_BaseModel->editBase($goods_id, $edit_row, true);

			//商品common中收藏数量减少
			$Goods_CommonModel = new Goods_CommonModel();
			$edit_common_row = array();
			$edit_common_row['common_collect'] = '1';
			$Goods_CommonModel = $Goods_CommonModel->editCommonTrue($goods_base['common_id'],$edit_common_row);
		}
		else
		{
			$flag = false;
		}

		if ($flag && $User_FavoritesGoodsModel->sql->commitDb())
		{
			$status = 200;
			$msg    = __('success');
		}
		else
		{
			$User_FavoritesGoodsModel->sql->rollBackDb();
			$m      = $User_FavoritesGoodsModel->msg->getMessages();
			$msg    = $m ? $m[0] : __('failure');
			$status = 250;
		}
		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}


	public function getGoodsIdBySpec()
	{
		$common_id = request_int('common_id');
		$spec      = request_row('spec');

		$Goods_BaseModel = new Goods_BaseModel();
		$res             = $Goods_BaseModel->getBaseSpecByCommonId($common_id);

		natsort($spec);
		$data = array();
		foreach ($res as $ke => $val)
		{
			$key = array_keys($val);
			natsort($key);
			if ($key == $spec)
			{
				$data['goods_id'] = $ke;
			}
		}

		$this->data->addBody(-140, $data);
	}

	//虚拟兑换码过期之前提醒
	public function VirtualCodeAuto()
	{
		$Goods_CommonModel = new Goods_CommonModel();
		//1.查找出过期退款的虚拟商品
		$goods_cond_row['common_is_virtual'] = Goods_CommonModel::GOODS_VIRTUAL;
		$goods_cond_row['common_virtual_refund'] =	Goods_CommonModel::GOODS_VIRTUAL_REFUND;
		$goods_cond_row['common_virtual_date:<'] = date("Y-m-d H:i:s",strtotime("+2 day"));
		$common_base = $Goods_CommonModel->getByWhere($goods_cond_row);
		$common_id = array_column($common_base,'common_id');

		//2.查找出虚拟订单中未使用的订单商品
		$order_goods_cond_row['order_goods_status'] = Order_StateModel::ORDER_WAIT_CONFIRM_GOODS;

		//3.查找出不为退款订单商品
		$order_goods_cond_row['goods_refund_status'] = Order_GoodsModel::REFUND_NO;

		$order_goods_cond_row['common_id:IN'] = $common_id;

		$Order_GoodsModel = new Order_GoodsModel();
		$order_goods = $Order_GoodsModel->getByWhere($order_goods_cond_row);

		foreach($order_goods as $key => $val)
		{
			//兑换码即将到期提醒
			//[end_time]
			$message = new MessageModel();
			$message->sendMessage('Redemption code is about to expire reminder', $val['buyer_user_id'], __('亲爱的会员'), $order_id = NULL, $shop_name = NULL, 0, 1, $end_time = $common_base[$val['common_id']]['common_virtual_date']);
		}

	}

    /**
     *  获取运费和售卖区域
     */
	public function getTramsport()
	{
		$area_id = request_int('area_id');
		$common_id = request_int('common_id');

		$result = $this->getTramsportData($area_id, $common_id);
		$data = $result;
        $status = $result['result'] ? 200 : 250;
        $msg = $result['result'] ? 'success' : 'failure';
		return $this->data->addBody(-140, $data, $msg, $status);
	}

	private function getTramsportData($area_id, $common_id)
	{
		$goodsBaseModel = new Goods_BaseModel();
		$result = $goodsBaseModel->getTransportInfo($area_id, $common_id);

		return $result;
	}

	/**
	 * 查询分类品牌和分类关联属性
	 * @return array
	 */
	public function getBrandAndProperty ()
	{
		$cat_id = request_int('cat_id');
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
				$this->filterBySpec($property_value_ids, $data);
//				$condi_pro_index['property_value_id:IN'] = $property_value_ids;
//				$goodsPropertyIndexModel = new Goods_PropertyIndexModel();
//				$property_index_list = $goodsPropertyIndexModel->getByWhere( $condi_pro_index );
//				$common_ids = array_column($property_index_list, 'common_id');
//
//				$data['common_ids'] = $common_ids;
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

	//交易快照
	public function snapshot()
	{
		$order_id = request_string('order_id');
		$goods_id = request_int('goods_id');

		$Order_GoodsSnapshotModel = new Order_GoodsSnapshotModel();
		$snapshot = $Order_GoodsSnapshotModel->getByWhere(array('order_id'=>$order_id,'goods_id'=>$goods_id));

		$snapshot = current($snapshot);

		//商品详情
		$Goods_BaseModel = new Goods_BaseModel();
		$goods_base = $Goods_BaseModel->getOne($snapshot['goods_id']);

		//查找店铺信息
		$Shop_BaseModel = new Shop_BaseModel();
		$shop_detail    = $Shop_BaseModel->getShopDetail($snapshot['shop_id']);

		$Shop_CompanyModel = new Shop_CompanyModel();
		$shop_company = $Shop_CompanyModel->getOne($shop_detail['shop_id']);

		//订单信息
		$Order_BaseModel = new Order_BaseModel();
		$order_base = $Order_BaseModel->getOne($snapshot['order_id']);
		fb($order_base);

		include $this->view->getView();
	}

	/**
	 * ly
	 * wap 获取商品详情信息
	 */

	public function getCommonDetail()
	{
		$goods_id = request_int('goods_id');

		$goodsBaseModel  		= new Goods_BaseModel();
		$goodsCommonDetailModel = new Goods_CommonDetailModel();

		$goods_base = $goodsBaseModel->getBase($goods_id);
		$goods_base = pos($goods_base);

		$common_id = $goods_base['common_id'];
		$common_detail_base = $goodsCommonDetailModel->getCommonDetail($common_id);
		$common_detail_base = pos($common_detail_base);

		$data = array();
		$data['common_body'] = str_replace('type=webp', 'type=jpg', $common_detail_base['common_body']);

		$this->data->addBody(-140, $data);
	}

    /**
     * zcg
     * 取得门店信息
     *
     * @access public
     */
    public function getChain()
    {
        $chain_id = request_int("chain_id");
        $Chain_BaseModel=new Chain_BaseModel();
        $chan_base=current($Chain_BaseModel->getBase($chain_id));
        include $this->view->getView();
    }

    /**
     * zcg
     * 取得门店
     *
     * @access public
     */
    public function chain()
    {
		//地区
        $district_parent_id = request_int('pid', 0);
        $Base_DistrictModel = new Base_DistrictModel();
        $district = $Base_DistrictModel->getDistrictTree($district_parent_id);
		$Chain_GoodsModel = new Chain_GoodsModel();
		$Chain_UserModel = new Chain_UserModel();
		$Shop_BaseModel = new Shop_BaseModel();
		$user_id = Perm::$userId;
        $shop_id = request_int("shop_id");
        $goods_id = request_int("goods_id");
		$goods_shop_info = $Chain_GoodsModel->getOneByWhere(['goods_id'=>$goods_id]);
		$chain_info = $Chain_UserModel->getOneByWhere(['user_id'=>$user_id]);
		//判断当前买家是否是当前门店商品店家
		if($chain_info && $goods_shop_info['shop_id'] == $chain_info['shop_id'])
		{
			return false;
		}
		else
		{
			$buyer_shop_info = $Shop_BaseModel->getOneByWhere(['user_id'=>$user_id]);
			if($buyer_shop_info && $buyer_shop_info['shop_id'] == $goods_shop_info['shop_id'])
			{
				return false;
			}
		}
		
        $chain_GoodsModel = new Chain_GoodsModel();
		$chain_BaseModel = new Chain_BaseModel();

		$chain_goods_where = [
			'shop_id'=> $shop_id,
			'goods_id'=> $goods_id,
			'goods_stock:>'=> 0
		];

        $chain_goods_rows = $chain_GoodsModel->getByWhere($chain_goods_where);
		$chain_ids = array_column($chain_goods_rows, 'chain_id');
        $chain_rows = $chain_BaseModel->getBase($chain_ids);

		$chain_provinces = [];
		$chain_cities = [];
		
		foreach($chain_rows as $chain_data){
			$chain_province_id = $chain_data['chain_province_id'];
			$chain_city_id = $chain_data['chain_city_id'];

			$chain_provinces[$chain_province_id][] = $chain_city_id;
			$chain_cities[$chain_city_id][] = $chain_data;
		}

		//获取定位地址
		$current_location_info = current_location();
		$current_province = $current_location_info['province'];

		$chain_provinces = json_encode($chain_provinces);
		$chain_cities = json_encode($chain_cities);
        include $this->view->getView();
    }

	private function filterBySpec($property_value_ids, &$data)
	{
		$common_ids = array();
		$condition_search = array();
		$goodsPropertyIndexModel = new Goods_PropertyIndexModel();

		foreach ($property_value_ids as $key => $property_value_id)
		{
			$condition_search['property_value_id'] = $property_value_id;

			$property_index_list = $goodsPropertyIndexModel->getByWhere( $condition_search );

			if (empty($property_index_list))
			{
				return $data['common_ids'][] = false;
			}
			else
			{
				$property_index_list = array_column($property_index_list, 'common_id');

				if ( $key == 0 )
				{
					$common_ids = $property_index_list;
				}
				else
				{
					$common_ids = array_intersect($common_ids, $property_index_list);

					if (empty($common_ids))
					{
						return $data['common_ids'][] = false;
					}
				}
			}
		}
		return $data['common_ids'] = array_values($common_ids);
	}

	//当用户点击查看商品详情时，向统计中心发送数据
	public function analytic_goods()
	{
		$goods_id = request_int('goods_id');//商品id和店铺id不会同时存在
		$shop_id = request_int('shop_id');
		$skip_url = request_string('url');
		$from = request_string('from');
		$uv = request_int('uv_num');
		$date = date("Y-m-d", strtotime(request_string('date')));
//		echo '<pre>';print_r($uv);exit;
		if($goods_id)
		{
			$Goods_Base = new Goods_BaseModel;
			$goodsbase = current($Goods_Base->getBase($goods_id));
			$analytics_data = array(
				'product_id'=>$goods_id,
				'product_name'=>$goodsbase['goods_name'],
				'shop_id'=>$goodsbase['shop_id'],
				'date'=>$date,
				'url'=>$skip_url,
				'from'=>$from,
				'uv_num'=>$uv,
			);
//			echo '<pre>';print_r($analytics_data);exit;
			Yf_Plugin_Manager::getInstance()->trigger('analyticsUvCount',$analytics_data);
			/******************************************************/
		}
		elseif($shop_id)
		{
			$analytics_data = array(
				'shop_id'=>$shop_id,
				'date'=>$date,
				'url'=>$skip_url,
				'from'=>$from,
				'uv_num'=>$uv,
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsUvCount',$analytics_data);
			/******************************************************/
		}
		else
		{
			$analytics_data = array(
				'date'=>$date,
				'url'=>$skip_url,
				'from'=>$from,
				'uv_num'=>$uv,
			);
			Yf_Plugin_Manager::getInstance()->trigger('analyticsUvCount',$analytics_data);
			/******************************************************/
		}
	}

	public function checkTask()
	{
		//需要设计规则,随机触发.

		//db需要为master
		$Base_CronModel = new Base_CronModel();
		$rows           = $Base_CronModel->checkTask();

		fb($rows);
	}

	/**
	 * 获取最近两条评论信息
	 */

	public function getGoodsNewReview()
	{
		$goods_id = request_int('goods_id');
		$goodsBaseModel = new Goods_BaseModel();
		$goods_base = $goodsBaseModel->getBase($goods_id);
		$goods_base = pos($goods_base);
		$common_id = $goods_base['common_id'];

		$order_row             = array();
		$cond_row['common_id']  = $common_id;
		$cond_row['status:!='] = Goods_EvaluationModel::DISPLAY;
		 
		if($_GET['sort'] == 'scores'){
				$order_row['scores'] = 'DESC';
		}else{
			$order_row['create_time'] = 'DESC';
		}
		

		$order_row['status'] = 'DESC';

		$Goods_EvaluationModel = new Goods_EvaluationModel();
		$goods_review_rows = $Goods_EvaluationModel->getEvaluationList($cond_row, $order_row, $page = 1, $rows = 1, 'good');

		$result_review_rows = [];

		foreach ($goods_review_rows['items'] as $k=> $val) {
			$row = current($val);
			$row['spec_val_str'] = implode(',', $row['goods_spec']);
			$result_review_rows[] = $row;
		}

		$num = $Goods_EvaluationModel->getEvalutionNum($cond_row);

		$this->data->addBody(-140, ['goods_review_rows'=> $result_review_rows,'num'=>$num]);
	}

	/**
	 * author yuli
	 * 获取促销信息，此方法不考虑团购情况和限时折扣
	 *
	 * 促销分为两类：
	 * 		1、针对于商品=>加价购
	 * 		2、不针对于商品=>满即送
	 *
	 * @param $goods_id int
	 * @return array
	 */
	public function getPromotionInfo($goods_id)
	{
		$goodsBaseModel = new Goods_BaseModel();
		$goods_data = $goodsBaseModel->getOne($goods_id);

		$result = [];

		$shop_id = $goods_data['shop_id'];

		$result['jia_jia_gou'] = $this->getPromotionByJiaJia($goods_id, $shop_id);
		$result['man_song'] = $this->getPromotionByManSong($shop_id);
        $voucher_model = new Voucher_TempModel();
        $voucher_list = $voucher_model->getShopVoucher($shop_id);
        $result['voucher_list'] = $voucher_list['items'] ? $voucher_list['items'] : array();
		return array_filter($result);
	}

	/**
	 * 加价购，判断该商品是否启用加价购促销信息
	 * 同一时间同一商品只有一个加价购活动
	 * @param $goods_id int
	 * @param $shop_id int
	 * @return boolean or array
	 */
	private function getPromotionByJiaJia($goods_id, $shop_id)
	{
		$increaseBaseModel = new Increase_BaseModel;

		//获取正常的加价购列表
		$increase_rows = $increaseBaseModel->getByWhere([
			'shop_id'=> $shop_id, //对应店铺
			'increase_state'=> Increase_BaseModel::NORMAL //活动状态正常
		]);

		if (empty($increase_rows)) {
			return false; //没有该促销信息
		}

		//筛选出加价购促销是否含有所需要的商品
		$increase_ids = array_keys($increase_rows);
		$increaseGoodsModel = new Increase_GoodsModel;

		$increase_goods_rows = $increaseGoodsModel->getByWhere([
			'increase_id:IN'=> $increase_ids,
			'goods_id'=> $goods_id
		]);

		if (empty($increase_goods_rows)) {
			return false; //没有该商品促销信息
		}

        //商品启用了加价购促销
		$answer_increase_data = current($increase_goods_rows);
		$answer_increase_id = $answer_increase_data['increase_id'];

		$jia_jia_data = $increaseBaseModel->getIncreaseActDetail($answer_increase_id);

		//格式化redemption_goods
		foreach ($jia_jia_data['rule'] as $k=> $rule) {
			$jia_jia_data['rule'][$k]['redemption_goods'] = array_values($rule['redemption_goods']);
		}
		
		return $jia_jia_data;
	}

	/**
	 * 限时折扣
	 * 同一时间同一商品只有一个限时活动
	 * @param $goods_id int
	 * @param $shop_id int
     * @return boolean or array
	 */
	private function getPromotionByXianShi($goods_id, $shop_id)
	{
		$discountBaseModel = new Discount_BaseModel();

        $discount_rows = $discountBaseModel->getByWhere([
            'shop_id'=> $shop_id, //对应店铺
            'discount_state'=> Discount_BaseModel::NORMAL //活动状态正常
        ]);

        if (empty($discount_rows)) {
            return false; //没有该促销信息
        }

        //筛选出限制折扣促销是否含有所需要的商品
        $discount_ids = array_keys($discount_rows);
        $discountGoodsModel = new Discount_GoodsModel;

        $discount_goods_rows = $discountGoodsModel->getByWhere([
            'discount_id:IN'=> $discount_ids,
            'goods_id'=> $goods_id
        ]);

        if (empty($discount_goods_rows)) {
            return false; //没有该商品促销信息
        }
        //商品启用了限制折扣促销
        return current($discount_goods_rows);
	}

	/**
	 * 满送
	 * 同一时间只有一个满送活动
	 * @param $shop_id int
	 * @return boolean or array
	 */
	private function getPromotionByManSong($shop_id)
	{
		$manSongBaseModel = new ManSong_BaseModel();

		$mansong_rows = $manSongBaseModel->getByWhere([
			'shop_id'=> $shop_id, //对应店铺
			'mansong_state'=> ManSong_BaseModel::NORMAL //活动状态正常
		]);

		if (empty($mansong_rows)) {
			return false; //没有该促销信息
		}

		$result_mansong_rows = $manSongBaseModel->getManSongActItem([
			'mansong_id:IN'=> array_keys($mansong_rows)
		]);

		return $result_mansong_rows;
	}
    
    /**
     * 获取地区并设置cookie
     * @return type
     */
    private function getCookieArea(){
        if(!isset($_COOKIE['goodslist_area_id'])) {
            $ip = get_ip();
            $Sub_SiteModel = new Sub_SiteModel();
            $area_array = $Sub_SiteModel->getIPLoc_sina_new($ip);
            $district = $Sub_SiteModel->areaConvert($area_array);
            if(!$district['province']){
                //默认数据
                setcookie("goodslist_area_id", 143);
                setcookie("goodslist_area_name", '上海 黄浦区');
                $cookid_area = array();
                $cookid_area['area'] = '上海 黄浦区';
                $cookid_area['city']['id'] = 143;   
            }else{
                $Base_DistrictModel = new Base_DistrictModel();
                if(in_array($district['province'], array('北京','上海','重庆','天津'))){
                    $cookid_area = $Base_DistrictModel->getCookieDistrictName($district['province'],2);
                    setcookie("goodslist_area_id", $cookid_area['city']['id']); 
                    setcookie("goodslist_area_name", $cookid_area['area']);
                }else{
                    $area_info = $Base_DistrictModel->getDistrictDetailByName($district['province'].' '.$district['city']);
                    $cookid_area = array(
                        'area'=>$district['province'].' '.$district['city'],
                        'provice'=>array('id'=>$area_info[0]['district_id'],'name'=>$area_info[0]['district_name']),
                        'city'=> array('id'=>$area_info[1]['district_id'],'name'=>$area_info[1]['district_name'])
                    );
                    setcookie("goodslist_area_id", $area_info[1]['district_id']); 
                    setcookie("goodslist_area_name", $cookid_area['area']);
                }
            }
        } else {
            $cookid_area = array();
            $cookid_area['area'] = $_COOKIE['goodslist_area_name'];
            $cookid_area['city']['id'] = $_COOKIE['goodslist_area_id'];    
        }
        return $cookid_area;
    }
    
    /**
     * 获取地区并设置cookie
     * @return type
     */
    public function getArea(){
        $cookie_area = $this->getCookieArea();
        return $this->data->addBody(-140, $cookie_area);
    }
    
}

?>