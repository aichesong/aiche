<link rel="stylesheet" type="text/css" href="<?=$this->view->css?>/Group-integral.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->view->css?>/base.css" />

<script type="text/javascript" src="<?=$this->view->js_com?>/jquery.js"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/jquery.toastr.min.js"></script>
<script type="text/javascript" src="<?=$this->view->js?>/common.js"></script>
<!--<script type="text/javascript" src="<?/*=$this->view->js*/?>/home.js"></script>-->
<script type="text/javascript" src="<?=$this->view->js?>/receive_voucher.js"></script>

<div class="bbc-voucher-exchange voucher-exchange">
    <?php
    if($data)
    {
    ?>
		<input type="hidden" name="form_submit" value="ok">
        <input type="hidden" name="vid" value="<?=$data['voucher_t_id']?>">
		<div class="pic">
            <span>
                <img src="<?=$data['voucher_t_customimg']?>" alt="<?=$data['voucher_t_title']?>">
            </span>
		</div>
        <dl>
            <dt>
                <?php
                    if($data['voucher_t_points']){
                ?>
                <?=__('您正在使用')?><span class="ml5 mr5"><?=$data['voucher_t_points']?></span><?=__('积分')?>&nbsp;<?=__('兑换')?>&nbsp;1&nbsp;<?=__('张')?><br>
                <?php
                    }else{
                ?>
                <?=__('您正在兑换')?>&nbsp;1&nbsp;<?=__('张')?><br>
                <?php
                    }
                ?>
                <?=$data['voucher_t_title']?>
                （<em><?=__('满')?><?=$data['voucher_t_limit']?><?=__('减')?><?=$data['voucher_t_price']?></em>）
            </dt>
            <dd><?=__('店铺代金券有效期至')?><?=date("Y-m-d", strtotime($data['voucher_t_end_date']))?></dd>
            <dd>
                <?=__('每个ID限领')?>
                <?php if($data['voucher_t_eachlimit'] == 0){  ?><?=__('不限')?>
                <?php }else{ ?>
                    <?=$data['voucher_t_eachlimit']?><?=__('张')?>
                <?php } ?>
            </dd>
        </dl>
		<?php
			}
		?>
</div>
	