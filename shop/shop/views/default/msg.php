<?php if (!defined('ROOT_PATH')){exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/' . 'site_nav.php';
?>
<link rel="stylesheet" type="text/css" href="./shop/static/default/css/404.css" media="screen" />
<div id="da-wrapper" class="fluid">
	<div id="da-content">
		<div class="da-container clearfix">
			<div id="da-error-wrapper">
				<div id="da-error-pin"></div>
				<div id="da-error-code">
					<span><?=$msg_type?></span> </div>
				<h1 class="da-error-heading"><?=$msg?></h1>
				<p> <a href="./index.php"><?=__('点击进入首页')?></a></p>
			</div>
		</div>
	</div>
</div>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>

