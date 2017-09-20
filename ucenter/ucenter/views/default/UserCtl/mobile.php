<?php if (!defined('ROOT_PATH')){exit('No Permission');}

include $this->view->getTplPath() . '/' . 'header.php';
?>
<link rel="stylesheet" href="<?= $this->view->css ?>/security.css">
  
</div>
<div class="form-style-layout">
    <div class="form-style">
    	<div class="step clearfix">
        	<dl class="step-first current">
            	<dt><?=_('1.验证身份')?></dt>
            </dl>
        	<dl class="current">
            	<dt><?=_('2.绑定手机')?></dt>
                <dd></dd>
            </dl>
        	<dl class="">
            	<dt><?=_('3.绑定完成')?></dt>
                <dd></dd>
            </dl>
        </div>
        <form id="form" name="form"  method="post">
		<input type="hidden" value="mobile_verify" name="act">
			
			<div class="bind-area">
				<dl class="clearfix">
					<dt><em class="icon-must">*</em><?=_('手机：')?></dt>
					<dd>
						<?php if($op = "mobile" && $data['user_mobile_verify'] != 1 && $data['user_mobile']){?>
							<input type="hidden" name="user_mobile" id="user_mobile" value="<?=$data['user_mobile']?>" />
							<?=$data['user_mobile']?>
						<?php }else{?>
							<input type="text" name="user_mobile" id="user_mobile" class="text" value="" />
						<?php }?>
					</dd>
				</dl>
                <dl>
                <dt><em>*</em><?=_('图形验证码')?>：</dt>
                
                <dd>
                    <input type="text"  name="img_yzm" id="img_yzm" maxlength="6" class='text w110' placeholder="<?=_('请输入验证码')?>" default="<i class=&quot;i-def&quot;></i><?=_('看不清？点击图片更换验证码')?>"  />
                    &nbsp;&nbsp;&nbsp;
                    <img onClick="get_randfunc(this);" title="<?=_('换一换')?>" class="img-code" style="cursor:pointer;" src='./libraries/rand_func.php'/>
                   
                </dd>

                </dl>
				<dl class="clearfix">
					<dt><em class="icon-must">*</em><?=_('手机验证码：')?></dt>
					<dd>
						<input type="text" name="yzm" id="yzm" class="text w60" value="" onchange="javascript:checkyzm();"/>
						<input type="button" class="btn-send wid-reset" data-type="mobile" value="<?=_('获取手机验证码')?>" />
					</dd>
				</dl>
				<!-- <input type="submit" value="提交" class="big-submit"> -->
				<input type="submit" value="<?=_('提交')?>" class="big-submit">
			</div>

        </form>
	</div>
</div>

<script type="text/javascript">
var icon = '<i class="iconfont icon-exclamation-sign"></i>';
$(".btn-send").click(function(){
	var patrn = /^1\d{10}$/;
    var val = $('#user_mobile').val();
	if(!val){
        Public.tips.error(<?=_('请填写手机')?>); return;
	}
	else if(!patrn.test(val)){  
        Public.tips.error(<?=_('请填写正确的手机')?>);return;
	}
	else{
		var url = SITE_URL +'?ctl=User&met=getMobile&typ=json';
		var sj = new Date();
		var pars = 'shuiji=' + sj+'&verify_type=mobile&verify_field='+val; 
		$.post(url, pars, function (data)
		{
			if(200 == data.status){
				msg = "<?=_('获取手机验证码')?>";
				$(".btn-send").attr("disabled", "disabled");
				$(".btn-send").attr("readonly", "readonly");
				//$("#user_mobile").attr("disabled", "disabled");
				$("#user_mobile").attr("readonly", "readonly");
			
                var img_yzm = $('#img_yzm').val();
				$.post(SITE_URL +'?ctl=User&met=getMobileYzm&typ=json', 'mobile=' + val + '&yzm=' + img_yzm, function (resp){
                    if(resp.status == 200){
                        t = setTimeout(countDown,1000);
                    }else{
                        $('.img-code').click();
                        $(".btn-send").attr("disabled", false);
                        $(".btn-send").attr("readonly", false);
                        $("#user_mobile").attr("readonly", false);
                        Public.tips.error(resp.msg);
                        return;
                    }
                },'json');
			}else{		
                Public.tips.error(data.msg);return;
			}
		});
	}
});
var delayTime = 60;
function countDown()
{
	delayTime--;
	$(".btn-send").val(delayTime + "<?=_('秒后重新获取')?>");
	if (delayTime == 0) {
		delayTime = 60;
		$(".btn-send").val(msg);
		$(".btn-send").removeAttr("disabled");
		$(".btn-send").removeAttr("readonly");
		$("#user_mobile").removeAttr("disabled");
		$("#user_mobile").removeAttr("readonly");
		clearTimeout(t);
	}
	else
	{
		t=setTimeout(countDown,1000);
	}
}
flag = false;
function checkyzm(){
	$("label.error").remove();
	var yzm = $.trim($("#yzm").val());
	var mobile = $.trim($("#user_mobile").val());

	var obj = $(".btn-send");
	if(yzm == ''){
		obj.addClass('red');
	 	$("<label class='error'>"+icon+"<?=_('请填写验证码')?></label>").insertAfter(obj);
		return false;
	}
	var url = SITE_URL +'?ctl=User&met=checkMobileYzm&typ=json';

	$.post(url, {'yzm':yzm,'mobile':mobile}, function(a){
			flag = false;
	        if (a.status == 200)
	        {
				flag = true;
	        }
	        else
	        {
				
	        	obj.addClass('red');
				$("<label class='error'>"+icon+"<?=_('验证码错误')?></label>").insertAfter(obj);
				return flag;
	        }
	});
	return flag;
}
$(".submit").click(function(){
		var obj = $(".btn-send");
			
        var ajax_url = SITE_URL +'?ctl=User&met=editMobileInfo&typ=json';
       
        $('#form').validator({
            ignore: ':hidden',
            theme: 'yellow_right',
            timely: 1,
            stopOnError: false,
			
            fields: {
                'user_mobile': 'required;',
                'yzm':'required;',
            },
            valid:function(form){
                //表单验证通过，提交表单
                $.ajax({
                    url: ajax_url,
                    data:$("#form").serialize(),
                    success:function(a){
                        if(a.status == 200)
                        {
							Public.tips.success("<?=_('操作成功！')?>");
                            location.href= SITE_URL +"?ctl=User&met=security";
                        }else if(a.status == 240){
							obj.addClass('red');
							$("<label class='error'>"+icon+"<?=_('验证码错误')?></label>").insertAfter(obj);
						}
                        else
                        {
                            Public.tips.error("<?=_('操作失败！')?>");
                        }
                    }
                });
            }

        });

    });
    //点击验证码
    function get_randfunc(obj)
    {
        var sj = new Date();
        url = obj.src;
        obj.src = url + '?' + sj;
    }
</script>
</div>
</div>
</div>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>
