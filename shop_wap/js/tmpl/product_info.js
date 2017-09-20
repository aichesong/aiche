$(function () {
    var o = getQueryString("goods_id");
    $.ajax({
        url: ApiUrl + "/index.php?ctl=Goods_Goods&met=getCommonDetail&typ=json",
        data: {goods_id: o},
        type: "get",
        success: function (o) {
            $(".fixed-tab-pannel").html(o.data.common_body)
        }
    });
    $("#goodsDetail").click(function () {
        window.location.href = WapSiteUrl + "/tmpl/product_detail.html?goods_id=" + o
    });
    $("#goodsBody").click(function () {
        window.location.href = WapSiteUrl + "/tmpl/product_info.html?goods_id=" + o
    });
    $("#goodsEvaluation").click(function () {
        window.location.href = WapSiteUrl + "/tmpl/product_eval_list.html?goods_id=" + o
    })
    $('body').on('click', '#goodsRecommendation', function () {
        window.location.href = WapSiteUrl + '/tmpl/product_recommendation.html?goods_id=' + o;
    });
});