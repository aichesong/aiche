$(function () {
    var e = getCookie("key");
    var u = getCookie("id");
    if (!e) {
        window.location.href = WapSiteUrl + "/tmpl/member/login.html";
        return
    }
    var a = getQueryString("order_id");
    $.getJSON(ApiUrl + "/index.php?ctl=Buyer_Order&met=evaluation&act=add&typ=json", {k: e,u:u, order_id: a}, function (r) {
        if (r.status == 250) {
            $.sDialog({skin: "red", content: r.msg, okBtn: false, cancelBtn: false});
            return false
        }
        var l = template.render("member-evaluation-script", r.data);
        $("#member-evaluation-div").html(l);
        $('input[name="upfile"]').ajaxUploadImage({
            url: ApiUrl + "/index.php?ctl=Upload&action=uploadImage",
            data: {key: e},
            start: function (e) {
                e.parent().after('<div class="upload-loading"><i></i></div>');
                e.parent().siblings(".pic-thumb").remove()
            },
            success: function (e, a) {
                checkLogin(a.login);
                if (a.state != 'SUCCESS') {
                    e.parent().siblings(".upload-loading").remove();
                    $.sDialog({skin: "red", content: "图片尺寸过大！", okBtn: false, cancelBtn: false});
                    return false
                }
                e.parent().after('<div class="pic-thumb"><img src="' + a.url + '"/></div>');
                e.parent().siblings(".upload-loading").remove();
                e.parents("a").next().val(a.url)
            }
        });
        $(".star-level").find("i").click(function () {
            var e = $(this).index();
            for (var a = 0; a < 5; a++) {
                var r = $(this).parent().find("i").eq(a);
                if (a <= e) {
                    r.removeClass("star-level-hollow").addClass("star-level-solid")
                } else {
                    r.removeClass("star-level-solid").addClass("star-level-hollow")
                }
            }
            $(this).parent().next().val(e + 1)
        });
        $(".btn-l").click(function () {
            var r = $("form").serializeArray();
            var l = {};
            l.key = e;
            l.order_id = a;
            for (var t = 0; t < r.length; t++) {
                l[r[t].name] = r[t].value
            }
            var evaluation = new Array();
            var order_goods_id_list = new Array();
            var order_goods_ids = $('input[name="order_goods_ids"]');
            order_goods_ids.each(function(){
                order_goods_id_list.push($(this).val());
            });
            //转换数据
            for(var ts = 0; ts < order_goods_id_list.length; ts++) {
                var evaluation_little = new Array();
                var order_goods_id = order_goods_id_list[ts];
                evaluation_little.push(order_goods_id);                              //order_goods_id
                evaluation_little.push(l["goods[" + order_goods_id + "][score]"]);   //source
                evaluation_little.push('good');                                      //默认good 懒得算了
                evaluation_little.push(l["goods[" + order_goods_id + "][comment]"]); //comment
                evaluation_little.push(l["goods[" + order_goods_id + "][anony]"]); //是否匿名

                //计算imgurl
                var imgurl = new String();
                for( var tsi = 0; tsi < 5; tsi++ ) {
                    if ( l["goods[" + order_goods_id + "][evaluate_image][" + tsi + "]"].length > 0 ) {
                        imgurl += l["goods[" + order_goods_id + "][evaluate_image][" + tsi + "]"];
                        if ( l["goods[" + order_goods_id + "][evaluate_image][" + (tsi) + "]"].length > 0 ) {
                            imgurl += ','
                        }
                    }

                }
                evaluation_little.push(imgurl);                                       //url

                evaluation.push(evaluation_little);
            }

            $.ajax({
                type: "post",
                url: ApiUrl + "/index.php?ctl=Goods_Evaluation&met=addGoodsEvaluation&typ=json",
                data: {evaluation: evaluation, k:getCookie('key'), u: getCookie('id')},
                dataType: "json",
                async: false,
                success: function (e) {
                    checkLogin(e.login);
                    if (e.status == 250) {
                        $.sDialog({skin: "red", content: e.datas.error, okBtn: false, cancelBtn: false});
                        return false
                    }
                    window.location.href = WapSiteUrl + "/tmpl/member/order_list.html"
                }
            })
        })
    })
});