(function($){$.fn.ajaxContent=function(options){var defaults=$.extend({},$.fn.ajaxContent.defaults,options);if(defaults.debug=='true'){debug(this)};return this.each(function(){var $obj=$(this);var o=$.meta?$.extend({},defaults,$obj.data()):defaults;var url=$obj.attr('href');var $target=$(o.target);$obj.bind(o.event,function(){if(o.loader=='true'){var loadingMessage;if(o.loaderType=='img'){loadingMessage='<img class="ajaxload" src=\"'+o.loadingMsg+'\"/>'}$target.html(loadingMessage)}$('a.'+o.currentClass).removeClass(o.currentClass);$obj.addClass(o.currentClass);$.ajax({type:o.type,url:url,success:function(msg){$target.html(msg);if(typeof o.success=='function'){o.success($obj,$target,msg)}},error:function(){$target.html("<p>"+o.errorMsg+"</p>");if(typeof o.error=='function'){o.error($target)}}});return false})})};function debug($obj){if(window.console&&window.console.log)window.console.log('selection count: '+$obj.size()+'  with class:'+$obj.attr('class'))}})(jQuery);$.fn.ajaxContent.defaults={target:'#ajaxContent',type:'get',event:'click',loader:'true',loaderType:'text',loadingMsg:'Loading...',errorMsg:' ',currentClass:'selected',success:'',error:'',debug:'false'};