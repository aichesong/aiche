
<script type="text/javascript" src="<?=$this->view->js_com ?>/plugins/jquery.yf_slider.js" charset="utf-8"></script>
<script type="text/javascript">
//图片延迟加载
(function($) {
    $.fn.nc_lazyload_init = function() {
        this.each(function() {
            $(this).after($(this).val().replace(/src=/gi, 'data-src='));
        }).remove();
    };
})(jQuery);

//图片延迟加载
(function($) {
    $.fn.nc_lazyload = function() {
        var lazy_items = [];
        this.each(function() {
            if($(this).attr("data-src") !== undefined){
                var lazy_item = {
                    object: $(this),
                    url: $(this).attr("data-src")
                };
                lazy_items.push(lazy_item);
            }
        });

        var load_img = function() {
            var window_height = $(window).height();
            var scroll_top = $(window).scrollTop();

            $.each(lazy_items, function(i, lazy_item) {
                if(lazy_item.object) {
                    item_top = lazy_item.object.offset().top - scroll_top;
                    if(item_top >= 0 && item_top < window_height) {
                        if(lazy_item.url) {
                            lazy_item.object.attr("src",lazy_item.url);
                        }
                        lazy_item.object = null;
                    }
                }
            });
        };
        load_img();
        $(window).bind("scroll", load_img);
    };
})(jQuery);
</script>
<div id="store_decoration_area" class="store-decoration-page">
<textarea class="lazyload_container" rows="10" cols="30" style="display:none;">
    <?php if(!empty($decoration_detail['block_list']) && is_array($decoration_detail['block_list'])) {?>
    <?php foreach($decoration_detail['block_list'] as $block) {?>
    <?php require('store_decoration_block.php');?>
    <?php } ?>
    <?php } ?>
</textarea>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //图片延迟加载
        $(".lazyload_container").nc_lazyload_init();
        $("img").nc_lazyload();

        //幻灯片
        $('[nctype="store_decoration_slide"]').yf_slider();
    });
</script>
