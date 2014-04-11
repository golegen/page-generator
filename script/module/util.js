/**
 * @desc: 乱七八糟的功能类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-19
 */

define(['jquery', './tmpl', './ui', './beautify', './beautify-css', './beautify-html'], function($){
    return {

        /* 获取 URL 参数 */
        param: function(name) {
            return decodeURI((new RegExp('[^\\w]'+name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
        },

        /* 列表项的随机 class */
        classname: function(){
            return 'item_'+parseInt(Math.random()*6+1, 10);
        },

        /* 统一出错提示 */
        message: function(msg, box/* optional */){
            if(!box){
                $('<span id="pg_msg_box" style="top:'+(200+$(document).scrollTop())+'px;">'+msg+'</span>')
                    .appendTo('body')
                    .show().delay(2000).fadeOut(500, function(){
                        $(this).remove();
                    });
            }
        },

        /* 格式化，方便统一管理格式化策略 */
        format: function(source_text, type){
            switch (type){
                case 'html':
                    return style_html(source_text);
                case 'css':
                    // return css_beautify(source_text); css暂时不格式化，保持一行
                    return source_text;
                case 'js':
                    return js_beautify(source_text);
                default:
                    return source_text;
            }
        },

        /* 粘贴图像并获取数据，仅 Chrome 支持 */
        paste: function(ev, callback){
            var clipboardData,items,item;

            // 判断剪贴板中是否有图片
            if(ev&&(clipboardData=ev.clipboardData)&&(items=clipboardData.items)&&(item=items[0])&&item.kind=='file'&&item.type.match(/^image\//i)){
                var blob = item.getAsFile(),reader = new FileReader();

                reader.onload=function(){
                    callback(event.target.result);
                };

                reader.readAsDataURL(blob);
                return false;
            }
        },

        /* 清除代码中的自定义标签 */
        clean: function(source){
            /* 去掉 data-pg="xxx" */
            source = source.replace(/\s?data-pg="\w*?"/g,'');
            source = source.replace(/\s?data-type="\w*?"/g,'');

            return source;
        },

        /* 动态载入样式表 */
        loadStyle: function(url){
            var link = document.createElement("link");
            link.rel = "stylesheet";
            link.type = "text/css";
            link.href = url;
            var head = document.getElementsByTagName("head")[0];
            head.appendChild(link);
        },

        //动态载入样式代码
        loadStyleString: function(css){
            var style = document.createElement("style");
            style.type = "text/css";
            try{
                style.appendChild(document.createTextNode(css));
            } catch (ex){
                style.styleSheet.cssText = css; //IE
            }
            var head = document.getElementsByTagName("head")[0];
            head.appendChild(style);
        }
    }
});