$(function() {

    var headerClone = $('#header').clone();
    $(window).scroll(function(){
        if ($(window).scrollTop() <= $('#main-container1').height()) {
            headerClone = $('#header').clone();
            $('#header').remove();
            headerClone.addClass('transparent').removeClass('');
            headerClone.prependTo('.nctouch-home-top');
        } else {
            headerClone = $('#header').clone();
            $('#header').remove();
            headerClone.addClass('').removeClass('transparent');
            headerClone.prependTo('body');
        }
    });

  

   
    if(getCookie('sub_site_id') == '' || getCookie('sub_site_id') == 'undefined' || getCookie('sub_site_id') == null){
            loadScriptSubsite();
    }
    var sub_site_id = getCookie('sub_site_id');
    $.ajax({
        url: ApiUrl + "/index.php?ctl=Index&met=index&typ=json&ua=wap&sub_site_id="+sub_site_id,
        type: 'get',
        dataType: 'json',
        success: function(result) {
            var data = result.data;
            var html = '';
            if(typeof(data.subsite_is_open) == 'undefined' || !data.subsite_is_open){
//                $("#subsite_dev").hide();
                $('#cohesive_dev').hide();
            }else{
                if(typeof(data.sub_site_name) != 'undefined' && sub_site_id > 0){
                    $('.sub_site_name_span').html(data.sub_site_name);
                }else{
                    $('.sub_site_name_span').html('全部');
                }
            }
            $(".site_logo").attr('src',data.site_logo);

            $.each(data.module_data, function(k, v) {
                $.each(v, function(kk, vv) {
                    switch (kk) {
                        case 'slider_list':
                        case 'home3':
                            $.each(vv.item, function(k3, v3) {
                                vv.item[k3].url = buildUrl(v3.type, v3.data);
                            });
                            break;

                        case 'home1':
                            vv.url = buildUrl(vv.type, vv.data);
                            break;

                        case 'home2':
                        case 'home4':
                            vv.square_url = buildUrl(vv.square_type, vv.square_data);
                            vv.rectangle1_url = buildUrl(vv.rectangle1_type, vv.rectangle1_data);
                            vv.rectangle2_url = buildUrl(vv.rectangle2_type, vv.rectangle2_data);
                            break;
                    }
                    if (k == 0) {
                        $("#main-container1").html(template.render(kk, vv));
                    } else {
                        html += template.render(kk, vv);
                    }
                    return false;
                });
               
            });
            var mySwiper = new Swiper(".swiper-container-new", {
                slidesPerView: "auto",
                centeredSlides: !0,
                watchSlidesProgress: !0,
                pagination: "#pagination",
                paginationClickable: !0,
                loop:true,
                onProgress: function(a) {
                    var b, c, d;
                    for (b = 0; b < a.slides.length; b++) c = a.slides[b], d = c.progress, scale = 1 - Math.min(Math.abs(.2 * d), 1), es = c.style, es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = "translate3d(0px,0," + -Math.abs(150 * d) + "px)"
                },
                onSetTransition: function(a, b) {
                    for (var c = 0; c < a.slides.length; c++) es = a.slides[c].style, es.webkitTransitionDuration = es.MsTransitionDuration = es.msTransitionDuration = es.MozTransitionDuration = es.OTransitionDuration = es.transitionDuration = b + "ms"
                }
            });

            $("#main-container2").html(html);

            // $('.slider_list').each(function() {
            //     if ($(this).find('.item').length < 2) {
            //         return;
            //     }

            //     Swipe(this, {
            //         startSlide: 2,
            //         speed: 400,
            //         auto: 3000,
            //         continuous: true,
            //         disableScroll: false,
            //         stopPropagation: false,
            //         callback: function(index, elem) {},
            //         transitionEnd: function(index, elem) {}
            //     });
            // });

        }
    });

});

