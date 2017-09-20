<?php if($data['items']){ ?>
	<ul class="fn-clear">
<?php
		foreach($data['items'] as $key=>$goods)
		{
 ?>
		<li>
			<div class="goods-image"><img src="<?=image_thumb($goods['goods_image'],140,140)?>" /></div>
			<div class="goods-name"><?=$goods['goods_name']?></div>
			<div class="goods-price"><?=__('销售价')?>：<span><?=$goods['goods_price']?></span></div>
			<div class="goods-btn"><a data-type="btn_add_goods" data-id="<?=$goods['goods_id']?>" data-goods-id="<?=Yf_Registry::get('url')?>?ctl=Goods&met=detail&id=<?=$goods['goods_price']?>"  href="javascript:void(0);" class="button button_green"><i class="iconfont icon-jia"></i><?=__('选择为礼品')?></a></div>
		</li>
<?php 	}	?>
	</ul>
<?php }else{ ?>
    <div class="no_account">
        <img src="<?=$this->view->img?>/ico_none.png">
        <p>暂无符合条件的数据记录</p>
    </div>
<?php
	}
?>

<?php if($page_nav){ ?>
	<div class="goods-page fn-clear">
		<div class="mm">
			<div class="page"><?=$page_nav?></div>
		</div>
	</div>
<?php } ?>