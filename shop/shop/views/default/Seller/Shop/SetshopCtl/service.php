<?php if (!defined('ROOT_PATH')){exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/' . 'seller_header.php';
?>

    <input type='hidden' name='shop_id' value="<?=$data['shop_id']?>">
    <div class="form-style">
        <dl>
            <dt><?=__('售后服务：')?></dt>
            <dd>
                <textarea class="text textarea service" style="width:70%" name="service"><?=$data['shop_common_service']?></textarea>
                <p class="inp_warn_text" style="width: 300px;"><?=__('售后服务不能超过200个汉字，现在剩余')?><strong id="word"><?=__('200')?></strong><?=__('个字')?></p>
            </dd>
        </dl>

        <dl>
            <dt></dt>
            <dd>
            <input type="hidden" name="op" value="edit" />
            <input type="submit" class="button bbc_seller_submit_btns" value="<?=__('确认提交')?>" />
            </dd>
        </dl>
    </div>

<script>
    //控制售后服务的字数
    $(function(){
        length = $(".service").val().length;
        nums = 200 - length;
        if(length > 199){
            $(".service").val($(".service").val().substring(0,200));
        }
        var nums = 200 - length;
        if(nums <= 0)
        {
            nums = 0
        }
        $(".service").parent().find("#word").text(nums);

        $(".service").keyup(function(){
            var len = $(this).val().length;
            if(len > 199){
                $(this).val($(this).val().substring(0,200));
            }
            var num = 200 - len;
            if(num <= 0)
            {
                num = 0
            }
            $(this).parent().find("#word").text(num);
        });
    });


    $(".bbc_seller_submit_btns").click(function()
    {
        var ajax_url = './index.php?ctl=Seller_Shop_Setshop&met=editShopCommonService&typ=json';
        var common_service = $(".service").val();
        $.post(ajax_url,{"common_service":common_service} ,function(a) {

            if (a.status == 200)
            {
                Public.tips.success('<?=__('操作成功！')?>');
            }
            else
            {
                if (a.msg != 'failure')
                {
                    Public.tips.error(a.msg);
                }
                else
                {
                    Public.tips.error('<?=__('操作失败！')?>');
                }

            }
        })
    })







</script>

<?php
include $this->view->getTplPath() . '/' . 'seller_footer.php';
?>

