<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
} ?>
<?php
include $this->view->getTplPath() . '/' . 'header.php';
?>
<!-- author：309558639 | team：http://www.yuanfengerp.com/ -->
<script>
	var CONFIG = {
		DEFAULT_PAGE: true,
		//SERVICE_URL: './index.php?ctl=Service'
	};
	//系统参数控制
	var SYSTEM = {
		version: 1,
		skin: "default",
		curDate: '1423619990432',  //系统当前日期
		DBID: '88887785', //账套ID
		serviceType: '15', //账套类型，13：表示收费服务，12：表示免费服务
		userName: 'Demo', //用户名
		companyName: 'Paycenter',	//公司名称
		companyAddr: '',	//公司地址
		phone: '',	//公司电话
		fax: '',	//公司传真
		postcode: '',	//公司邮编
		startDate: '2015-11-18', //启用日期
		invEntryCount: '',//试用版单据分录数
		rights: {},//权限列表
		taxRequiredCheck: 1,
		taxRequiredInput: 13,
		isAdmin: true, //是否管理员
		siExpired: false,//是否过期
		siType: 2, //服务版本，1表示基础版，2表示标准版
		siVersion: 4, //1表示试用、2表示免费（百度版）、3表示收费，4表示体验版
		shortName: "",//shortName


	};

	SYSTEM.categoryInfo = {};

	//区分服务支持
	SYSTEM.servicePro = SYSTEM.siType === 2 ? 'forbscm3' : 'forscm3';
	var cacheList = {};	//缓存列表查询
	//全局基础数据


	//缓存登陆用户
	function getUser()
	{
		Public.ajaxGet('', {}, function (data)
		{
			if (data.status === 200)
			{
				SYSTEM.realName = (data.data[0].user_account);
			}
			else if (data.status === 250)
			{
				SYSTEM.realName = '';
			}
			else
			{
				Public.tips({type: 1, content: data.msg});
			}
		});
	}
	;


	//缓存时间
	function initDate()
	{
		var a = new Date,
			b = a.getFullYear(),
			c = ("0" + (a.getMonth() + 1)).slice(-2),
			d = ("0" + a.getDate()).slice(-2);
		SYSTEM.beginDate = b + "-" + c + "-01", SYSTEM.endDate = b + "-" + c + "-" + d
	}
	//左上侧版本标识控制
	function markupVension()
	{
		var imgSrcList = {
			base: '/css/default/img/icon_v_b.png',	//基础版正式版
			baseExp: '/css/default/img/icon_v_b_e.png',	//基础版体验版
			baseTrial: '/css/default/img/icon_v_b_t.png',	//基础版试用版
			standard: '/css/default/img/icon_v_s.png', //标准版正式版
			standardExp: './admin/static/default/css/img/icon_v_s_e.png', //标准版体验版
			standardTrial: '/css/default/img/icon_v_s_t.png' //标准版试用版
		};
		var imgModel = $("<img id='icon-vension' src='' alt=''/>");
		if (SYSTEM.siType === 1)
		{
			switch (SYSTEM.siVersion)
			{
				case 1:
					imgModel.attr('src', imgSrcList.baseTrial).attr('alt', '基础版试用版');
					break;
				case 2:
					imgModel.attr('src', imgSrcList.baseExp).attr('alt', '免费版（百度版）');
					break;
				case 3:
					imgModel.attr('src', imgSrcList.base).attr('alt', '基础版');//标准版
					break;
				case 4:
					imgModel.attr('src', imgSrcList.baseExp).attr('alt', '基础版体验版');//标准版
					break;
			}
			;
		}
		else
		{
			switch (SYSTEM.siVersion)
			{
				case 1:
					imgModel.attr('src', imgSrcList.standardTrial).attr('alt', '标准版试用版');
					break;
				case 3:
					imgModel.attr('src', imgSrcList.standard).attr('alt', '标准版');//标准版
					break;
				case 4:
					imgModel.attr('src', imgSrcList.standardExp).attr('alt', '标准版体验版');//标准版
					break;
			}
			;
		}
		;

	}
	;
</script>
<link href="./admin/static/default/css/base.css" rel="stylesheet" type="text/css">
<link href="./admin/static/default/css/default.css" rel="stylesheet" type="text/css" id="defaultFile">
<script src="./admin/static/default/js/libs/tabs.js?ver=20140430"></script>
</head>
<body>
<div id="container" class="cf">
	<div class="col-hd cf">
		<div class="left"><a class="company" id="companyName" href="javascript:;" title=""></a></div>
		<div class="right cf">
			<?php
			$ucenter_api_url_row = parse_url(Yf_Registry::get('ucenter_api_url'));
			$ucenter_admin_url   = Yf_Registry::get('ucenter_admin_url');

			$shop_api_url_row = parse_url(Yf_Registry::get('shop_api_url'));
			$shop_admin_url     = Yf_Registry::get('shop_admin_url');


			?>
			<ol>
				<li><a href="<?= $ucenter_admin_url ?>" target="_blank"><i class="nav_href">UCenter</i></a></li>
				<li><a href="<?= $shop_admin_url ?>" target="_blank"><i class="nav_href">商城系统</i></a></li>
<!-- 			<li><a href="<?= Yf_Registry::get('url') ?>?ctl=Login&met=loginout"><i class="nav_href">广告系统</i></a></li>
				<li><a href="<?= Yf_Registry::get('url') ?>?ctl=Login&met=loginout"><i class="nav_href">大数据</i></a></li>
				<li><a href="<?= Yf_Registry::get('url') ?>?ctl=Login&met=loginout"><i class="nav_href">备份系统</i></a></li>
				<li><a href="<?= $im_api_url ?>" target="_blank"><i class="nav_href">IM系统</i></a></li> -->
				<li><img src="<?= Yf_Registry::get('ucenter_api_url') ?>?ctl=Index&met=img&user_id=<?= Perm::$userId ?>">

					<div><span><?= Perm::$row['user_account'] ?></span>

						<div>
				</li>
				<li><a href="#"><i class="iconfont icon-top01"></i></a></li>
				<li><a href="#"><i class="iconfont icon-top02"></i></a></li>
				<li><a href="index.php?ctl=Login&met=loginout"><i class="iconfont icon-top03"></i></a></li>
			</ol>
		</div>
	</div>

	<div class="col-bd">
		<div id="col-side">

			<div class="nav-wrap hidden cf"><!--订单-->
				<ul id="nav" class="cf">
					<li class="item item-setting cur">
						<a href="javascript:void(0);" class="setting main-nav"><i class="iconfont icon-silde02"></i>

							<p>设置</p><s></s></a>
					</li>

					<li class="item item-manage ">
						<a href="javascript:void(0);" class="setting main-nav"><i class="iconfont icon-zijinguanli"></i>

							<p>资金</p><s></s></a>
					</li>

					<li class="item user-manage ">
						<a href="javascript:void(0);" class="setting main-nav"><i class="iconfont icon-huiyuan"></i>

							<p>会员</p><s></s></a>
					</li>


					<li class="item tongji-manage ">
						<a href="javascript:void(0);" class="setting main-nav"><i class="iconfont icon-tongji"></i>

							<p>统计</p><s></s></a>
					</li>
				</ul>
				<div id="sub-nav">
					<ul class="cur cf" id="setting-base">

						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Config&met=site&typ=e&config_type%5B%5D=site" rel="pageTab" tabid="site-setting" tabtxt="基础设置">基础设置</a>
						</li>

						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Config&met=api&typ=e&config_type%5B%5D=api" rel="pageTab" tabid="api-setting" tabtxt="API设置">API设置</a>
						</li>
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Payment_Channel&met=index&typ=e" rel="pageTab" tabid="sale_order_manage"
																  tabtxt="支付方式设置">支付方式设置</a></li>

						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=User_App&met=index" rel="pageTab" tabid="sale_order_manage" tabtxt="支付应用管理">支付应用管理</a>
						</li>

						<?php if(is_dir(APPPATH.'/../upgrade')){ ?>
                        <li>
                        <i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Config&met=update" rel="pageTab" tabid="sale_order_manage" tabtxt="版本管理">版本管理</a>
                        </li>
						<?php } ?>

					</ul>

					<ul class="cf" id="setting-manage">
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_PayWithdraw&met=index" rel="pageTab" tabid="PayWithdraw_Withdraw"
																  tabtxt="提现服务">提现服务</a>
						</li>

						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_PayCard&met=index" rel="pageTab" tabid="Paycen_PayCard" tabtxt="购物卡管理">购物卡管理</a>
						</li>
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_PayRecord&met=index" rel="pageTab" tabid="Paycen_PayRecord" tabtxt="资金明细">资金明细</a>
						</li>
					</ul>

					<ul class="cf" id="setting-manage">
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_PayBase&met=index" rel="pageTab" tabid="Paycen_PayBase" tabtxt="支付会员管理">支付会员管理</a>
						</li>
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_PayInfo&met=index" rel="pageTab" tabid="Paycen_PayInfo" tabtxt="实名认证">实名认证</a>
						</li>
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_BtInfo&met=index" rel="pageTab" tabid="Paycen_BtInfo" tabtxt="白条管理">白条管理</a>
						</li>
					</ul>

					<ul class="cf" id="setting-manage">
						<li>
							<i class="iconfont icon-point"></i><a data-right="BU_QUERY" href="index.php?ctl=Paycen_PayCapital&met=getCapitallist" rel="pageTab" tabid="Paycen_PayCapital"
																  tabtxt="系统资金总览">系统资金总览</a>
						</li>
					</ul>

				</div>
			</div>
		</div>

		<div id="col-main">
			<div id="main-bd">
				<div class="page-tab" id="page-tab"></div>
			</div>
		</div>
	</div>
</div>
<div id="selectSkin" class="shadow dn">
	<ul class="cf">
		<li><a id="skin-default"><span></span>
				<small>经典</small>
			</a></li>
		<li><a id="skin-blue"><span></span>
				<small>丰收</small>
			</a></li>
		<li><a id="skin-green"><span></span>
				<small>小清新</small>
			</a></li>
	</ul>
</div>
<!--暂时屏蔽未开发菜单-->
<script>
	$('.soon').click(function ()
	{
		parent.Public.tips({type: 2, content: '为防止测试人员乱改数据，演示站功能受限，暂时屏蔽。'});
	});
</script>
<script src="./admin/static/default/js/controllers/default.js"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>
