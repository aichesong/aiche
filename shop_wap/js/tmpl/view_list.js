var key = getCookie("key");
$(function ()
{
    var e = new ncScrollLoad;
    e.loadInit({
        url: ApiUrl + "/index.php?ctl=Buyer_Favorites&met=footprintwap&typ=json",
        getparam: {k: key, u:getCookie('id')},
        tmplid: "viewlist_data",
        containerobj: $("#viewlist"),
        iIntervalId: true,
        data: {WapSiteUrl: WapSiteUrl}
    });
    $("#clearbtn").click(function ()
    {
        $.ajax({
            type: "post", url: ApiUrl + "/index.php?ctl=Buyer_Favorites&met=delFootPrint&typ=json", data: {k: key, u:getCookie('id')}, dataType: "json", async: false, success: function (e)
            {
                if (e.status == 200)
                {
                    location.href = WapSiteUrl + "/tmpl/member/views_list.html"
                }
                else
                {
                    $.sDialog({skin: "red", content: e.data.error, okBtn: false, cancelBtn: false})
                }
            }
        })
    })
});
