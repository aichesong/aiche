

if (typeof Public !="undefined" && $.isFunction(Public.tips.warning))
{
	Public.tips.warning("系统未授权!");
}
else if($.isFunction($.dialog) && $.isFunction($.dialog.confirm))
{
	$.dialog.confirm( '系统未授权!', function(){}, function(){} )
}
else
{
	alert("系统未授权!")
}