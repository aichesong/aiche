<?php if (!defined('ROOT_PATH')) {exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/'  . 'header.php';
?>
<link href="<?=$this->view->css?>/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?=$this->view->css_com?>/jquery/plugins/validator/jquery.validator.css">
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>
</head>

<body>

<form method="post" enctype="multipart/form-data" id="manage-form" name="manage-form" class="form-horizontal">
	<div class="ncap-form-default">
		<input  name="payment_channel_id"   id="payment_channel_id"   value=""  type="hidden"/>

		<dl class="row">
			<dt class="tit">
				<label for="payment_channel_code">代码名称</label>
			</dt>
			<dd class="opt">
				<input id="payment_channel_code" name="payment_channel_code" value="" class="ui-input w400" type="text"/>
			</dd>
		</dl>

		<dl class="row">
			<dt class="tit">
				<label for="payment_channel_name">支付名称</label>
			</dt>
			<dd class="opt">
				<input id="payment_channel_name" name="payment_channel_name" value="" class="ui-input w400" type="text"/>
			</dd>
		</dl>

<!--		<dl class="row">
			<dt class="tit">
				<label for="payment_channel_config">支付接口配置信息</label>
			</dt>
			<dd class="opt">
				<textarea id="payment_channel_config" name="payment_channel_config" value="" class="ui-input " style="width: 400px;" ></textarea>
			</dd>
		</dl> -->
                <dl class="row">
			<dt class="tit">
				<label for="payment_channel_config[account]">支付账号</label>
			</dt>
			<dd class="opt">
				<input id="account"  name="payment_channel_config[account]" value="" class="ui-input w400" type="text"/>
			</dd>
		</dl>
                 <dl class="row">
			<dt class="tit">
				<label for="payment_channel_config[key]">支付密钥</label>
			</dt>
			<dd class="opt">
				<input id="key"  name="payment_channel_config[key]" value="" class="ui-input w400" type="text"/>
			</dd>
		</dl>
                <dl class="row">
			<dt class="tit">
				<label for="payment_channel_config[partner]">支付商户号</label>
			</dt>
			<dd class="opt">
				<input id="partner"  name="payment_channel_config[partner]" value="" class="ui-input w400" type="text"/>
			</dd>
		</dl>
                <dl class="row" id="kaifa" style="display: none">
			<dt class="tit">
				<label for="payment_channel_config[appsecret]">开发模式下的秘钥</label>
			</dt>
			<dd class="opt">
				<input id="appsecret"  name="payment_channel_config[appsecret]" value="" class="ui-input w400" type="text" disabled="disabled"/>
			</dd>
		</dl>

		<dl class="row">
			<dt class="tit">
				<label for="payment_channel_wechat">微信中是否可以使用</label>
			</dt>
			<dd class="opt">
				<div class="onoff">
					<label for="enable11" class="cb-enable  ">开启</label>
					<label for="enable10" class="cb-disable  selected">关闭</label>
					<input id="enable11"  name ="payment_channel_wechat"  value="1" type="radio">
					<input id="enable10"  name ="payment_channel_wechat"  checked="checked"  value="0" type="radio">
				</div>
			</dd>
		</dl>

		<dl class="row">
			<dt class="tit">
				<label for="payment_channel_enable">是否启用</label>
			</dt>
			<dd class="opt">
				<div class="onoff">
					<label for="enable1" class="cb-enable  ">开启</label>
					<label for="enable0" class="cb-disable  selected">关闭</label>
					<input id="enable1"  name ="payment_channel_enable"  value="1" type="radio">
					<input id="enable0"  name ="payment_channel_enable"  checked="checked"  value="0" type="radio">
				</div>
			</dd>
		</dl>

	</div>
</form>


<script type="text/javascript">
	var curRow, curCol, curArrears, $grid = $("#grid"), $_form = $("#manage-form"), api = frameElement.api, oper = api.data.oper, rowData = api.data.rowData || {}, callback = api.data.callback;

	initPopBtns();
	initField();

	function initField()
	{
		if (rowData.id)
		{
			$('#payment_channel_id').val(rowData.payment_channel_id);
			$('#payment_channel_code').val(rowData.payment_channel_code);
			$('#payment_channel_name').val(rowData.payment_channel_name);
			$('#payment_channel_config').val(JSON.stringify(rowData.payment_channel_config));
			$('#payment_channel_status').val(rowData.payment_channel_status);
			$('#payment_channel_allow').val(rowData.payment_channel_allow);

			if(rowData.payment_channel_wechat)
			{
				$("#enable11").attr('checked', true);
				$("#enable10").attr('checked', false);
				$('[for="enable11"]').addClass('selected');
				$('[for="enable10"]').removeClass('selected');
			}
			else
			{
				$("#enable1").attr('checked', false);
				$("#enable0").attr('checked', true);
				$('[for="enable1"]').removeClass('selected');
				$('[for="enable0"]').addClass('selected');
			}


			if(rowData.payment_channel_enable)
			{
				$("#enable1").attr('checked', true);
				$("#enable0").attr('checked', false);
				$('[for="enable1"]').addClass('selected');
				$('[for="enable0"]').removeClass('selected');
			}
			else
			{
				$("#enable1").attr('checked', false);
				$("#enable0").attr('checked', true);
				$('[for="enable1"]').removeClass('selected');
				$('[for="enable0"]').addClass('selected');
			}

                     
  //                      var payment_channel_code1 = rowData.payment_channel_code;
//                        var payment_channel_config = rowData.payment_channel_config;
                        if(rowData.payment_channel_code=="wx_native" || rowData.payment_channel_code=="app_wx_native")
                        {
                            $("#account").val(rowData.payment_channel_config["appid"]);
                            $("#key").val(rowData.payment_channel_config["key"]);
                            $("#partner").val(rowData.payment_channel_config["mchid"]);
                            $("#appsecret").val(rowData.payment_channel_config["appsecret"]);
                            $("#kaifa").css("display","block");
                            $("label[for='payment_channel_config[account]']").text("微信公众号身份");
                            $("label[for='payment_channel_config[key]']").text("商户支付密钥");
                            $("label[for='payment_channel_config[partner]']").text("受理商ID");
                            $("#appsecret").attr("disabled",false);
                        }else{
                            var account = rowData.payment_channel_code + "_account";
                            var key =  rowData.payment_channel_code + "_key";
                            var partner =  rowData.payment_channel_code + "_partner";
                            $("#account").val(rowData.payment_channel_config[account]);
                            $("#key").val(rowData.payment_channel_config[key]);
                            $("#partner").val(rowData.payment_channel_config[partner]);
                        }
		}
	}

	function initPopBtns()
	{
		var btn = "add" == oper ? ["保存", "关闭"] : ["确定", "取消"];
		api.button({
			id: "confirm", name: btn[0], focus: !0, callback: function ()
			{
				postData(oper, rowData.id);
				return cancleGridEdit(), $_form.trigger("validate"), !1;
			}
		}, {id: "cancel", name: btn[1]})
	}

	function postData(oper, id)
	{
		$_form.validator({
			ignore: ':hidden',
			theme: 'yellow_bottom',
			timely: 1,
			stopOnError: true,
			fields: {
				//'keyword_find': 'required;'
			},
			valid: function (form)
			{
				var me = this;
				// 提交表单之前，hold住表单，防止重复提交
				me.holdSubmit();

				parent.$.dialog.confirm('修改立马生效,是否继续？', function ()
					{
						/*
						 var keyword_find = $.trim($("#keyword_find").val());

						 var params = {keyword_find: keyword_find, keyword_replace: keyword_replace};
						 */
						var n = "add" == oper ? _("新增") : _("修改");

						Public.ajaxPost(SITE_URL + "?ctl=Payment_Channel&typ=json&met=" + ("add" == oper ? "add" : "edit"), $_form.serialize(), function (resp)
						{
							if (200 == resp.status)
							{
								resp.data['id'] = resp.data['payment_channel_id'];
								parent.parent.Public.tips({content: n + "成功！"});
								callback && "function" == typeof callback && callback(resp.data, oper, window)
							}
							else
							{
								parent.parent.Public.tips({type: 1, content: n + "失败！" + resp.msg})
							}

							// 提交表单成功后，释放hold，如果不释放hold，就变成了只能提交一次的表单
							me.holdSubmit(false);
						})
					},
					function ()
					{
						me.holdSubmit(false);
					});
			},
		}).on("click", "a.submit-btn", function (e)
		{
			$(e.delegateTarget).trigger("validate");
		});
	}

	function cancleGridEdit()
	{
		null !== curRow && null !== curCol && ($grid.jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null)
	}

	//设置表单元素回车事件
	function bindEventForEnterKey()
	{
		Public.bindEnterSkip($_form, function()
		{
			$('#grid tr.jqgrow:eq(0) td:eq(0)').trigger('click');
		});
	}

	function resetForm(t)
	{
		$('#payment_channel_id').val('');
		$('#payment_channel_code').val('');
		$('#payment_channel_name').val('');
		$('#payment_channel_config').val('');
		$('#payment_channel_status').val('');
		$('#payment_channel_allow').val('');
		$('#payment_channel_wechat').val('');
		$('#payment_channel_enable').val('');

	}

	$(".box-main .form-section:has(label)").each(function(i, el)
	{
		var $this = $(el),
			$label = $this.find('label'),
			$input = $this.find('.form-control');

		$input.on('focus', function()
		{
			$this.addClass('form-section-active');
			$this.addClass('form-section-focus');
		});

		$input.on('keydown', function()
		{
			$this.addClass('form-section-active');
			$this.addClass('form-section-focus');
		});

		$input.on('blur', function()
		{
			$this.removeClass('form-section-focus');

			if(!$.trim($input.val()))
			{
				$this.removeClass('form-section-active');
			}
		});

		$label.on('click', function()
		{
			$input.focus();
		});

		if($.trim($input.val()))
		{
			$this.addClass('form-section-active');
		}
	});
</script>


<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>
