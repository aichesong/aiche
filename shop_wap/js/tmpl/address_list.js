var key = getCookie("key");

$(function ()
{
     var key=getCookie("key");if(!key){location.href="login.html"}

    function s()
    {
        $.ajax({
            type: "post", url: ApiUrl + "/index.php?ctl=Buyer_User&met=address&typ=json", data: {k: key, u:getCookie('id')}, dataType: "json", success: function (e)
            {
                checkLogin(e.login);
                if (e.data.address_list == null)
                {
                    return false
                }
                var s = e.data;
                var t = template.render("saddress_list", s);
                $("#address_list").empty();
                $("#address_list").append(t);
                $(".deladdress").click(function ()
                {
                    var e = $(this).attr("user_address_id");
                    $.sDialog({
                        skin: "block", content: "确认删除吗？", okBtn: true, cancelBtn: true, okFn: function ()
                        {
                            a(e)
                        }
                    })
                })
            }
        })
    }

    s();
    function a(a)
    {
        $.ajax({
            type: "post", url: ApiUrl + "?ctl=Buyer_User&met=delAddress&typ=json", data: {id: a, k: key, u:getCookie('id')}, dataType: "json", success: function (e)
            {
                checkLogin(e.login);
                if (e)
                {
                    s()
                }
            }
        })
    }
});