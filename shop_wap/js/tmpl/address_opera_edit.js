$(function ()
{
    var a = getQueryString("user_address_id");
    var e = getCookie("key");
    $.ajax({
        type: "post", url: ApiUrl + "/index.php?ctl=Buyer_User&met=address&act=edit&typ=json", data: {k:e,u:getCookie('id'), id: a}, dataType: "json", success: function (a)
        {
            checkLogin(a.login);
            $("#true_name").val(a.data.address_list.user_address_contact);
            $("#mob_phone").val(a.data.address_list.user_address_phone);
            $("#area_info").val(a.data.address_list.user_address_area).attr({"data-areaid1": a.data.address_list.user_address_province_id, "data-areaid2": a.data.address_list.user_address_city_id, "data-areaid3": a.data.address_list.user_address_area_id, "data-areaid": a.data.address_list.user_address_province_id});
            $("#address").val(a.data.address_list.user_address_address);
            var e = a.data.address_list.user_address_default == "1" ? true : false;
            $("#is_default").prop("checked", e);
            if (e)
            {
                $("#is_default").parents("label").addClass("checked")
            }
        }
    });
    $.sValid.init({
        rules: {true_name: "required", mob_phone: "required", area_info: "required", address: "required"},
        messages: {true_name: "姓名必填！", mob_phone: "手机号必填！", area_info: "地区必填！", address: "街道必填！"},
        callback: function (a, e, r)
        {
            if (a.length > 0)
            {
                var d = "";
                $.map(e, function (a, e)
                {
                    d += "<p>" + a + "</p>"
                });
                errorTipsShow(d)
            }
            else
            {
                errorTipsHide()
            }
        }
    });
    $(".btn").click(function ()
    {
        if ($.sValid())
        {
            var r = $("#true_name").val();
            var d = $("#mob_phone").val();
            var i = $("#address").val();

            var province_id = $("#area_info").attr("data-areaid1");
            var city_id = $("#area_info").attr("data-areaid2");
            var area_id = $("#area_info").attr("data-areaid3");

            var n = $("#area_info").val();

            var o = $("#is_default").attr("checked") ? 1 : 0;
            $.ajax({
                type: "post",
                url: ApiUrl + "/index.php?ctl=Buyer_User&met=editAddressInfo&typ=json",
                data: {k:e,u:getCookie('id'), user_address_contact: r, user_address_phone: d, province_id: province_id, city_id: city_id, area_id: area_id, user_address_address: i, address_area: n, user_address_default: o, user_address_id: a},
                dataType: "json",
                success: function (a)
                {
                    if (a)
                    {
                        location.href = WapSiteUrl + "/tmpl/member/address_list.html"
                    }
                    else
                    {
                        location.href = WapSiteUrl
                    }
                }
            })
        }
    });


    $("#area_info").on("click", function ()
    {
        $.areaSelected({
            success: function (a)
            {
                $("#area_info").val(a.area_info).attr({"data-areaid1": a.area_id_1, "data-areaid2": a.area_id_2, "data-areaid3": a.area_id_3, "data-areaid": a.area_id, "data-areaid2": a.area_id_2 == 0 ? a.area_id_1 : a.area_id_2})
            }
        })
    })
});