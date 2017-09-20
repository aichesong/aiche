<?php if (!defined('ROOT_PATH'))
{
    exit('No Permission');
} ?>
<?php
include $this->view->getTplPath() . '/' . 'header.php';
?>
<link href="<?= $this->view->css ?>/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?= $this->view->css_com ?>/jquery/plugins/validator/jquery.validator.css">
<link href="<?= $this->view->css_com ?>/webuploader.css" rel="stylesheet" type="text/css">
<style>
body{background: #fff;}
</style>
</head>
<body>
<form method="post" name="manage-form" id="manage-form" action="<?= Yf_Registry::get('url') ?>?act=goods&amp;op=goods_lockup">
    <input type="hidden" name="form_submit" value="ok">
    <input type="hidden" name="common_id_input">
    <div class="ncap-form-default">
        <dl class="row">
            <dt class="tit">
                <label class="cat_other_name" for="cat_other_name"><em>*</em>分类别名:</label>
            </dt>
            <dd class="opt">
              <input type="text" maxlength="20" value="" name="cat_other_name" id="cat_other_name" class="input-txt">
              <span class="err"></span>
              <p class="notic">必填项。设置别名后，别名将会替代原分类名称展示在分类导航菜单列表中。</p>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label>分类图片</label>
            </dt>
            <dd class="opt">
            <div>
                <img id="cat_image" name="setting[cat_logo]" alt="选择图片" src="./shop_admin/static/common/images/image.png" class="image-line" />
                </div>
                <div>
                <div class="image-line" style="margin-left: 10px;" id="cat_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                <input id="cat_logo" name="setting[cat_logo]" value="" class="ui-input w400" type="hidden"/>
                </div>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label>关联分类:</label>
            </dt>
            <dd class="opt">
                <?php if (!empty($data['cat'])){ ?>
    <?php
    foreach ($data['cat'] as $key_cat => $value_cat)
    {
        ?>
            <div style="width: 950px;float: left">
                <b>
                    <input type="checkbox" name="recommend_cat_higher" class="higher_level_<?php print($value_cat['cat_id']);?>" data="0" onchange="cat_lower(this)" value="<?php print($value_cat['cat_id']);?>" ><?php print($value_cat['cat_name']);?>
                    <a href="javascript:;" class="a_<?php print($value_cat['cat_id']);?>" onclick="a_click(this)" value="<?php print($value_cat['cat_id']);?>" data="0">▼</a>
                </b>

            </div>

            <?php if(isset($value_cat['sub'])&&!empty($value_cat['sub'])) { ?>
                <?php foreach($value_cat['sub'] as $k_cat=>$val_cat){ ?>
                    <div style="width: 180px;float: left;display:none" class="lower_level_<?php print($value_cat['cat_id']);?>">
                        <label style="margin-left: 20px;">
                            <input type="checkbox" name="recommend_cat" value="<?php print($val_cat['cat_id']);?>"
                                   id="recommend_<?php print($val_cat['cat_id']); ?>"><?php print($val_cat['cat_name']);?>
                        </label>
                    </div>
                <?php } ?>
            <?php } ?>


    <?php }} ?>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label>推荐品牌:</label>
            </dt>
            <dd class="opt">
                <?php
if (!empty($data['brand'])):
    foreach ($data['brand'] as $k_brand => $v_brand):?>
                        <div style="width: 950px;float: left">
                            <b><?php print($v_brand['catname']); ?></b>
                        </div>

                            <?php foreach ($v_brand['brand'] as $key_brand => $val_brand): ?>
                                <div style="width: 180px;float:left">
                                    <label style="width:180px;">
                                        <input type="checkbox" value="<?php print($val_brand['brand_id']); ?>" name="brand_value"
                                               id="brand_<?php print($val_brand['brand_id']); ?>"><?php print($val_brand['brand_name']); ?>
                                    </label>
                                </div>
                            <?php endforeach;?>
    <?php endforeach;
endif;
?>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label>广告图1:</label>
            </dt>
			<dd class="opt">
			    <div style="float: left">
                <img id="adv_image" name="setting[adv_logo]" alt="选择图片" src="./shop_admin/static/common/images/image.png" class="image-line" />
                </div>
                <div style="float: left">
                <div class="image-line" style="margin-left: 10px;" id="adv_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                <input id="adv_logo" name="setting[adv_logo]" value="" class="ui-input w400" type="hidden"/>
                </div>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label>广告图2:</label>
            </dt>
			<dd class="opt">
			<div style="float: left">
			    <div style="float: left">
                    <img id="advs_image" name="setting[advs_logo]" alt="选择图片" src="./shop_admin/static/common/images/image.png" class="image-line" />
                </div>
                <div style="float: left">
                    <div class="image-line" style="margin-left: 10px;" id="advs_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                    <input id="advs_logo" name="setting[advs_logo]" value="" class="ui-input w400" type="hidden"/>
                </div>
            </dd>
        </dl>
    </div>
</form>
<script>
    //图片上传
    $(function(){
        setting_logo_upload = new UploadImage({
            thumbnailWidth: 190,
            thumbnailHeight: 150,
            imageContainer: '#adv_image',
            uploadButton: '#adv_upload',
            inputHidden: '#adv_logo'
        });

        cat_logo_upload = new UploadImage({
            thumbnailWidth: 190,
            thumbnailHeight: 150,
            imageContainer: '#cat_image',
            uploadButton: '#cat_upload',
            inputHidden: '#cat_logo'
        });

        buyer_logo_upload = new UploadImage({
            thumbnailWidth: 190,
            thumbnailHeight: 150,
            imageContainer: '#advs_image',
            uploadButton: '#advs_upload',
            inputHidden: '#advs_logo'
        });
    })
    //显示与隐藏子级分类
    function cat_lower(obj)
    {
        //a标签没有点击显示子级的情况下点击输入框显示子级
        if($(obj).attr('data') == 0 && $('.a_'+$(obj).val()).attr('data') == 0)
        {
            $(obj).attr('data', 1);
            $('.a_'+$(obj).val()).html('▲');//a标签倒三角改为正三角
            $('.lower_level_'+$(obj).val()).show();
            $('.lower_level_'+$(obj).val()).find('input').prop('checked',true);
        }
        //a标签点击显示子级的情况下点击输入框选中所有当前子级
        else if($(obj).attr('data') == 0 && $('.a_'+$(obj).val()).attr('data') == 1)
        {
            $(obj).attr('data', 1);
            $('.a_'+$(obj).val()).html('▲');//a标签倒三角改为正三角
            $('.a_'+$(obj).val()).attr('data', 0);//a标签data状态改为0
            $('.higher_level_'+$(obj).val()).attr('checked','checked');
            $('.lower_level_'+$(obj).val()).find('input').prop('checked',true);
        }
        //点击输入框隐藏所有子级
        else if($(obj).attr('data') == 1)
        {
            $(obj).attr('data', 0);
            $('.a_'+$(obj).val()).html('▼');//a标签正三角改为倒三角
            $('.lower_level_'+$(obj).val()).hide();
        }
    }
    //点击a标签显示与隐藏子级分类
    function a_click(obj)
    {
        //输入框没有点击的情况下点击a标签
        if($(obj).attr('data') == 0 && $('.higher_level_'+$(obj).attr('value')).attr('data') == 0)
        {
            $(obj).attr('data', 1);
            $(obj).html('▲');//a标签正三角改为倒三角
            $('.lower_level_'+$(obj).attr('value')).show();
            $('.lower_level_'+$(obj).attr('value')).find('input').removeAttr('checked');
        }
        //输入框点击显示子级的情况下点击a标签选中所有当前子级
        else if($(obj).attr('data') == 0 && $('.higher_level_'+$(obj).attr('value')).attr('data') == 1)
        {
            $(obj).attr('data', 1);
            $('.higher_level_'+$(obj).attr('value')).attr('data', 0);//输入框data状态改为0
            $('.lower_level_'+$(obj).attr('value')).find('input').removeAttr('checked');
            $('.higher_level_'+$(obj).attr('value')).removeAttr('checked');
        }
        //点击a标签隐藏所有子级
        else if($(obj).attr('data') == 1)
        {
            $(obj).attr('data', 0);
            $(obj).html('▼');//a标签正三角改为倒三角
            $('.lower_level_'+$(obj).attr('value')).hide();
        }
    }

</script>
<script type="text/javascript" src="<?= $this->view->js_com ?>/webuploader.js" charset="utf-8"></script>
<script type="text/javascript" src="<?= $this->view->js ?>/models/upload_image.js" charset="utf-8"></script>
<script type="text/javascript" src="<?= $this->view->js ?>/controllers/goods/listCatNav.js" charset="utf-8"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>