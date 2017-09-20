$(function ()
{
    var e = getCookie("key");
    if (!e)
    {
        location.href = "login.html"
    }
    template.helper("isEmpty", function (e)
    {
        for (var t in e)
        {
            return false
        }
        return true
    });
    // $.ajax({
    //     type: "post", url: ApiUrl + "/index.php?ctl=Buyer_Message&met=message&typ=json", data: {k: e, u: getCookie('id'), recent: 1, op:'get_user_list', from:'wap'}, dataType: "json", success: function (t)
    //     {
    //         checkLogin(t.login);
    //         var a = t.data;
    //         $("#messageList").html(template.render("messageListScript", a));
    //         $(".msg-list-del").click(function ()
    //         {
    //             var t = $(this).attr("t_id");
    //             $.ajax({
    //                 type: "post", url: ApiUrl + "/index.php?ctl=Buyer_Message&met=delUserMessage&typ=json", data: {k: e, u: getCookie('id'), t_id: t}, dataType: "json", success: function (e)
    //                 {
    //                     if (e.status == 200)
    //                     {
    //                         location.reload()
    //                     }
    //                     else
    //                     {
    //                         $.sDialog({skin: "red", content: e.data.error, okBtn: false, cancelBtn: false});
    //                         return false
    //                     }
    //                 }
    //             })
    //         })
    //     }
    // })

    $.ajax({
        type: "post", url: ImApiUrl + "/index.php?ctl=Api_Chatlog&met=getMessage&typ=json", data: {u: getCookie('user_account')}, dataType: "json", success: function (t)
        {
            console.log(checkLogin(t.login));
            $("#messageList").html(template.render("messageListScript", t));
            $(".msg-list-del").click(function ()
            {
                var t = $(this).attr("t_id");
                $.ajax({
                    type: "post", url: ImApiUrl + "/index.php?ctl=Api_Chatlog&met=delMessage&typ=json", data: {k: e, u: getCookie('id'), t_id: t}, dataType: "json", success: function (e)
                    {
                        if (e.status == 200)
                        {
                            location.reload()
                        }
                        else
                        {
                            $.sDialog({skin: "red", content: e.data.error, okBtn: false, cancelBtn: false});
                            return false
                        }
                    }
                })
            })
        }
    })
});