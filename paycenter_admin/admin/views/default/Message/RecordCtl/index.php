<?php if (!defined('ROOT_PATH')) exit('No Permission');?>
<?php
include TPL_PATH . '/'  . 'header.php';
?>
</head>
<style>
		body{overflow-y:hidden;}
		.matchCon{width:200px;}
		.matchCon1{width:200px;}
		#tree{background-color: #fff;width: 225px;border: solid #ddd 1px;margin-left: 5px;height:100%;}
		h3{background: #EEEEEE;border: 1px solid #ddd;padding: 5px 10px;}
		.grid-wrap{position:relative;}
		.grid-wrap h3{border-bottom: none;}
		#tree h3{border-style:none;border-bottom:solid 1px #D8D8D8;}
		.quickSearchField{padding :10px; background-color: #f5f5f5;border-bottom:solid 1px #D8D8D8;}
		#searchCategory input{width:165px;}
		.innerTree{overflow-y:auto;}
		#hideTree{cursor: pointer;color:#fff;padding: 0 4px;background-color: #B9B9B9;border-radius: 3px;position: absolute;top: 5px;right: 5px;}
		#hideTree:hover{background-color: #AAAAAA;}
		#clear{display:none;}
</style>
</head>
<body>
<div class="wrapper">
	<div class="mod-search cf">
		<div class="fl">
            <ul class="ul-inline">
				<li>
					<input type="text" id="matchCon" class="ui-input ui-input-ph matchCon" value="按发送人查询">
				</li>
				<li>
					<input type="text" id="matchCon1" class="ui-input ui-input-ph matchCon1" value="按接收人查询">
				</li>
				<li>
                  <label>日期:</label>
                  <input type="text" id="beginDate" value="2015-12-02" class="ui-input ui-datepicker-input">
                  <span>-</span>
                  <input type="text" id="endDate" value="2015-12-08" class="ui-input ui-datepicker-input">
                </li>
                <li><a class="mrb more" id="moreCon">(高级搜索)</a></li>
				<li><a class="ui-btn mrb" id="search">查询</a></li>
			</ul>
		</div>
	</div>
	<div class="cf">
		<div class="grid-wrap fl cf">
			<h3>消息记录:<span id='currentCategory'></span></h3>
			<table id="grid">
			</table>
			<div id="page"></div>
		</div>

	</div>
</div>
<script src="./admin/static/default/js/controllers/message/record.js"></script>
<?php
include TPL_PATH . '/'  . 'footer.php';
?>