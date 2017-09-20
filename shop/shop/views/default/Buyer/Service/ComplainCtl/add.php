<?php if (!defined('ROOT_PATH'))
{
    exit('No Permission');
} ?>
<?php
include $this->view->getTplPath() . '/' . 'buyer_header.php';
?>

    <link href="<?= $this->view->css_com ?>/jquery/plugins/lightbox/css/jquery.lightbox.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/jquery.lightbox.min.js"></script>

    <div class="aright">
        <div class="member_infor_content">
            <div class="div_head  tabmenu clearfix">
                <ul class="tab pngFix clearfix">
                    <li class="active">
                        <a><?=__('交易投诉申请')?></a>
                    </li>
                </ul>
            </div>
        <div class="ncm-flow-layout" id="ncmComplainFlow">
            <div class="ncm-flow-container" style="width: 100%;">
                <div class="ncm-flow-step" style="text-align: center;">
                    <dl id="state_new" class="step-first current1">
                        <dt><?=__('新投诉')?></dt>
                        <dd class="bg"></dd>
                    </dl>
                    <dl id="state_appeal">
                        <dt><?=__('待申诉')?></dt>
                        <dd class="bg"></dd>
                    </dl>
                    <dl id="state_talk">
                        <dt><?=__('对话中')?></dt>
                        <dd class="bg"></dd>
                    </dl>
                    <dl id="state_handle">
                        <dt><?=__('待仲裁')?></dt>
                        <dd class="bg"></dd>
                    </dl>
                    <dl id="state_finish">
                        <dt><?=__('已完成')?></dt>
                        <dd class="bg"></dd>
                    </dl>
                </div>
                <div class="ncm-default-form">
                    <form id="form" action="#" method="post">
                        <dl>
                            <dt><?=__('选择投诉主题：')?></dt>
                            <dd>
                                <?php foreach ($data['subject'] as $v)
                                { ?>
                                    <p><input type="radio" name="complain_subject_id"
                                              value="<?= $v['complain_subject_id'] ?>"> <?= $v['complain_subject_content'] ?>
                                    </p>
                                    <p class="tips"><?= $v['complain_subject_desc'] ?></p>
                                <?php } ?>
                            </dd>
                            <dt><?=__('投诉内容：')?></dt>
                            <dd><textarea id="complain_content" name="complain_content" class="w400 textarea_text"></textarea></dd>
                            <dt><?=__('上传投诉证据：')?></dt>
                            <dd>
                                <input id="inputHidden" value="" type="hidden"/>
                                <div id="uploader-demo">
                                    <div id="fileList" class="uploader-list"></div>
                                    <div id="filePicker" class="bbc_btns"><?=__('选择图片')?></div>
                                </div>
                            </dd>

                        </dl>
                        <dl class="foot">

                            <input type="hidden" name="goods_id" value="<?= $data['goods_id'] ?>">
                            <dt>&nbsp;</dt>
                            <dd>
                                <label id="handle_submit" class="submit-border bbc_btns">
                                    <input type="button" value="<?=__('确认提交')?>" class="submit bbc_btns">
                                </label>
                            </dd>

                        </dl>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $('#filePicker').click(function ()
            {
                $(function ()
                {
                    aloneImage = $.dialog({
                        content: 'url: ' + SITE_URL + '?ctl=Upload&met=image&typ=e',
                        data: {callback: getImageList},
                        height: 600
                    })
                })

                function getImageList(imageList)
                {
                    for (i = 0; i < imageList.length; i++)
                    {
                        $('#fileList').append('<li><img src="' + imageList[i].src + '" /><input type="hidden" name="complain_pic[]" value="' + imageList[i].src + '"></li>')
                    }
                }
            })
            $(document).ready(function ()
            {
                $('#form').validator({
                    ignore: ':hidden',
                    theme: 'yellow_right',
                    timely: 1,
                    stopOnError: false,
                    fields: {'complain_content': 'required'},
                    valid: function (form)
                    {
                        //表单验证通过，提交表单
                        $.ajax({
                            url: SITE_URL + '?ctl=Buyer_Service_Complain&met=addComplain&typ=json',
                            data: $("#form").serialize(),
                            success: function (a)
                            {
                                if (a.status == 200)
                                {
                                    location.href = "./index.php?ctl=Buyer_Service_Complain&met=index";
                                }
                                else
                                {
                                    Public.tips.error('<?=__('操作失败！')?>');
                                }
                            }
                        });
                    }

                }).on("click", "#handle_submit", function (e)
                {
                    $(e.delegateTarget).trigger("validate");
                });


            });
        </script>
    </div>
    </div>
<?php
include $this->view->getTplPath() . '/' . 'buyer_footer.php';
?>