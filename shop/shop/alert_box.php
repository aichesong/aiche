<div class="tip" style="display: none;">
	<div class="relative">
		<div class="tip-area">
			<h5><span class="icon"></span>提示</h5>
			<div class="tip-cont"></div>
			<div class="clearfix"><a href="javascript:;" class="btn-sure">确定</a> </div>

		</div>
		<a href="javascript:;" class="btn-close"></a>
	</div>
</div>
<style type="text/css">
.tip-area{width:300px;background:#fff;padding:50px 0 20px;position:relative;margin:auto;overflow:hidden;height:100%;box-sizing:border-box;}
.tip-area h5{font-size:14px;position:absolute;left:-25px;top:-24px;background:#ff7c6d;color:#fff;padding: 30px 20px 6px 40px;font-weight:normal;border-radius:26px;letter-spacing:3px;}
.tip-area h5 span{width:16px;height:16px;display:inline-block;background:url(<?= Yf_Registry::get('static_url')?>/images/icon-tip.png) no-repeat;vertical-align:middle;margin-right:6px;}
.tip-area .tip-cont{padding:30px 0;text-align:center;color:#333;}
.tip-area .btn-sure{ text-decoration:none; float:right;line-height:26px;border:1px solid #999;padding:0 10px;margin-right:30px;color:#333;border-radius:2px;font-size:14px;position:absolute;right:0;bottom:18px;}
.tip-area .btn-sure:hover{color:#00a3ee;border-color:#00a3ee;} 

.tip .btn-close{
      text-decoration: none;
    line-height: 26px;
    border: 0;
    padding: 5px 10px;
    margin-right: 0px;
    color: #333;
    border-radius: 2px;
    font-size: 14px;
    margin-top: 5px;
}

a.btn-close{position:absolute;right:-28px;top:-16px;width:30px;height:30px;display:inline-block;background:url(<?= Yf_Registry::get('static_url')?>/images/icon-close.png) no-repeat;cursor:pointer;}
a.btn-close:hover{background:url(<?= Yf_Registry::get('static_url')?>/images/icon-close-hov.png) no-repeat;background-size:cover;transition:0.3s;}
.relative{position:relative;display: inline-block;height:100%;}
.tip{
    width:100%;text-align:center;z-index:999;font-size:16px;
    position:absolute; 
    left:50%; 
    top:50%; 
    width: 300px;
    height: 200px;
    margin-left:-150px;
    margin-top:-200px;
    box-shadow: 0px 0px 16px #ddd;
}

</style>

<script type="text/javascript">
	function alert_box(msg){
						$('.btn-sure').attr('href','javascript:;');  
						$(".tip-cont").html(msg);
						$('.tip').show(); 
	}

	function alert_box_link(msg,link){ 
					
					alert_box(msg);
					$('.btn-sure').attr('href',link);
	}

 
	$('.btn-close').click(function(){ $(".tip").hide(); });
	$('.btn-sure').click(function(){ $(".tip").hide(); });

</script>
