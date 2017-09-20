$(function () {
    var e = getCookie("key");
    if (!e) {
        window.location.href = WapSiteUrl + "/tmpl/member/login.html";
        return
    }
    var r = getQueryString("order_id");
    $.getJSON(ApiUrl + "/index.php?ctl=Buyer_Order&met=evaluation&act=add&typ=json", {key: e, order_id: r}, function (a) {
        if (a.status == 250) {
            $.sDialog({skin: "red", content: a.datas.error, okBtn: false, cancelBtn: false});
            return false
        }
        var t = template.render("member-evaluation-script", a.data);
        $("#member-evaluation-div").html(t);
        $(".star-level").find("i").click(function () {
            var e = $(this).index();
            for (var r = 0; r < 5; r++) {
                var a = $(this).parent().find("i").eq(r);
                if (r <= e) {
                    a.removeClass("star-level-hollow").addClass("star-level-solid")
                } else {
                    a.removeClass("star-level-solid").addClass("star-level-hollow")
                }
            }
            $(this).parent().next().val(e + 1)
        });
        $(".btn-l").click(function () {
            var a = $("form").serializeArray();
            var t = {};
            t.key = e;
            t.order_id = r;
            for (var l = 0; l < a.length; l++) {
                t[a[l].name] = a[l].value
            }

            var evaluation = new Array();
            var evaluation_little = new Array();
            var order_goods_id = $('#order_goods_id').val();

            evaluation_little.push(order_goods_id);
            evaluation_little.push(t["goods[" + order_goods_id + "][score]"]);
            evaluation_little.push('goods');
            evaluation_little.push(t["goods[" + order_goods_id + "][comment]"]);
            evaluation_little.push('');

            evaluation.push(evaluation_little);


            $.ajax({
                type: "post",
                url: ApiUrl + "/index.php?ctl=Goods_Evaluation&met=addGoodsEvaluation&typ=json",
                data: {evaluation: evaluation},
                dataType: "json",
                async: false,
                success: function (e) {
                    checkLogin(e.login);
                    if (e.status == 250) {
                        $.sDialog({skin: "red", content: e.datas.error, okBtn: false, cancelBtn: false});
                        return false
                    }
                    window.location.href = WapSiteUrl + "/tmpl/member/vr_order_list.html"
                }
            })
        })
    })
});