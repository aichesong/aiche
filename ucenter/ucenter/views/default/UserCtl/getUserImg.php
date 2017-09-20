<?php if (!defined('ROOT_PATH')){exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/' . 'header.php';
?>
</div>
            <form action="" enctype="multipart/form-data" id="form" name="form" method="post">
              <input type="hidden" name="form_submit" value="ok">
              <div class="ncm-default-form">
                <dl>
                  <dt><?=_('头像预览：')?></dt>
                  <dd>
                    <div class="user-avatar"><span><img  id="image_img"  src="<?php if(!empty($this->user['info']['user_avatar'])){ echo image_thumb($this->user['info']['user_avatar'],120,120);}else{echo image_thumb($this->web['user_avatar'],120,120); } ?>" width="120" height="120" nc_type="avatar"></span></div>
                    <p class="hint mt5"><?=_('完善个人信息资料，上传头像图片有助于您结识更多的朋友。')?><br><span style="color:orange;"><?=_('头像默认尺寸为120x120像素，请根据系统操作提示进行裁剪并生效。')?></span></p>
                  </dd>
                </dl>
                <dl>
                  <dt><?=_('更换头像：')?></dt>
                  <dd>
                    <div > <a href="javascript:void(0);"><span>
                     <input name="user_avatar" id="user_avatar" type="hidden" value="<?=$this->user['info']['user_avatar']?>" />
                      </span>
                      <div id='user_upload' style="float:left;padding-left:10px;" class="upload_img"><?=_('图片上传')?><i class="iconfont icon-tupianshangchuan" style="font-size:21px;float:right;"></i></div>

                      </a> </div>
                  </dd>
                </dl>
				<dl class="bottom">
                      <dt></dt>
                      <dd>
                        <label class="submit-border">
                          <input type="submit" class="submit bbc_btns" value="<?=_('保存修改')?>">
                        </label>
                      </dd>
                </dl>
              </div>
            </form>
        </div>
      </div>
    </div>

</div>
</div>
</div>
</div>
  </div>
</div>
<script type="text/javascript" src="<?=$this->view->js?>/webuploader.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js?>/upload/upload_image.js" charset="utf-8"></script>
<link href="<?= $this->view->css ?>/webuploader.css" rel="stylesheet" type="text/css">
<script>
    //图片上传
    $(function(){

        function upload_image() {
            var user_upload = new UploadImage({
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                imageContainer: '#image_img',
                uploadButton: '#user_upload',
                inputHidden: '#user_avatar'
            });
        }

        var agent = navigator.userAgent.toLowerCase();
        if ( agent.indexOf("msie") > -1 && (version = agent.match(/msie [\d]/), ( version == "msie 8" || version == "msie 9" )) ) {
            upload_image();
        } else {
            cropper_image();
        }

        function cropper_image() {
            $('#user_upload').on('click', function () {
                $.dialog({
                    title: '图片裁剪',
                    content: "url: <?= Yf_Registry::get('url') ?>?ctl=Upload&met=cropperImage&typ=e",
                    data: { width: 120, height: 120, callback: callback },    // 需要截取图片的宽高比例
                    width: '800px',
                    lock: true
                })
            });

            function callback ( respone , api ) {
                $('#image_img').attr('src', respone.url);
                $('#user_avatar').attr('value', respone.url);
                api.close();
            }
        }
/*
        user_upload = new UploadImage({
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            imageContainer: '#image_img',
            uploadButton: '#user_upload',
            inputHidden: '#user_avatar'
        });    */
    })
	//表单提交
	$(document).ready(function(){
        var ajax_url = SITE_URL +'?ctl=User&met=editUserImg&typ=json';
        $('#form').validator({
            ignore: ':hidden',
            theme: 'yellow_right',
            timely: 1,
            stopOnError: false,
            fields: {
            },
            valid:function(form){
                //表单验证通过，提交表单
                $.ajax({
                    url: ajax_url,
                    data:$("#form").serialize(),
                    success:function(a){
                        if(a.status == 200)
                        {
							Public.tips.success("<?=_('操作成功')?>");
                            setTimeout('location.href= SITE_URL +"?ctl=User&met=getUserImg"',1000);//成功后跳转

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
</script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>