<?php if (!defined('ROOT_PATH')) {exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/'  . 'header.php';
?>
<div class="ncap-form-default">
    <dl class="row">
        <dt class="tit">
            <label class="licence_domain" for="licence_domain"><em>*</em>用户名称 :</label>
        </dt>
        <dd class="opt"><?=$data['user_name']?></dd>
      
    </dl>
	<?php foreach ($data['user_option_rows'] as $user_option_row):?>
		<?php if($user_option_row['reg_option_name']):?>
			<dl class="row">
				<dt class="tit">
					<label class="licence_domain" for="licence_domain"><em>*</em><?=$user_option_row['reg_option_name']?> :</label>
				</dt>
				<dd class="opt"><?=$user_option_row['user_option_value']?></dd>
			</dl>
		<?php endif;?>
	<?php endforeach; ?>
</div>