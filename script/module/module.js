/**
 * @desc: 模块管理类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-19
 */

define(['jquery', './conf', './user', './util', './type', './tmpl'], function($, conf, user, util){
    return {

        /* 添加模块 */
        add: function(obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=insert',{
                "data":{
                    "table": "tb_mod",
                    "value":{
                        "mod_channel": obj.mod_channel,
                        "mod_name": obj.mod_name,
                        "mod_html": obj.mod_html,
                        "mod_css": obj.mod_css,
                        "mod_js": obj.mod_js,
                        "mod_type": obj.mod_type,
                        "mod_thumbnail": obj.mod_thumbnail,
                        "mod_creator": obj.mod_creator,
                        "mod_frequency": obj.mod_frequency,
                        "mod_state": obj.mod_state,
                        "mod_ispublic": obj.mod_ispublic,
                        "mod_sort": obj.mod_sort
                    }
                }
            }, callback);
        },

        /* 删除模块 */
        remove: function(id, callback){
            if(!user.isAdmin) return;

            $.getJSON(conf.API+'?act=delModById&id='+id, callback);
        },

        /* 修改模块 */
        update: function(id, obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=update',{
                "data":{
                    "table": "tb_mod",
                    "value":{
                        "mod_channel": obj.mod_channel,
                        "mod_name": obj.mod_name,
                        "mod_html": obj.mod_html,
                        "mod_css": obj.mod_css,
                        "mod_js": obj.mod_js,
                        "mod_type": obj.mod_type,
                        "mod_thumbnail": obj.mod_thumbnail,
                        "mod_creator": obj.mod_creator,
                        "mod_frequency": obj.mod_frequency,
                        "mod_state": obj.mod_state,
                        "mod_ispublic": obj.mod_ispublic,
                        "mod_sort": obj.mod_sort
                    },
                    "where":"mod_id="+id
                }
            }, callback);
        },

        /* 查找模块 */
        find: function(id, callback){
            $.getJSON(conf.API+'?act=getModById&id='+id, callback);
        },

        /* 模块预览 */
        preview: function(html_source, css_source, js_source, stylesheet_url){

            previewFrame = $(conf.SELECTOR_PREVIEW_FRAME)[0];

            previewFrame = (previewFrame.contentWindow) ?
                previewFrame.contentWindow : (previewFrame.contentDocument.document) ?
                previewFrame.contentDocument.document : previewFrame.contentDocument;

            /* for firefox append bug */
            previewFrame.document.close();

            previewFrame.document.open();

            // 载入样式表
            if(stylesheet_url){

                // 支持多个样式表，每行一个，以分号分隔
                var stylesheets = stylesheet_url.replace(/[\s\r\n]/g,'').split(';');
                for(var i= 0, j =  stylesheets.length; i<j; i++){
                    // 每次拉取最新样式
                    previewFrame.document.write('<link rel="stylesheet" href="'+stylesheets[i]+'?t='+(+new Date)+'" >');
                }
            }
            // 载入样式字串
            if(css_source){
                css_source = util.format(css_source, 'css');
                /* 预留padding 10px */
                previewFrame.document.write('<style>html,body{padding:10px 0 !important;}</style>');
                previewFrame.document.write('<style>'+css_source+'</style>');
            }
            // 载入 HTML 代码
            if(html_source){
                html_source = util.format(html_source, 'html');
                previewFrame.document.write(html_source);

                // 禁止点击
                previewFrame.document.write('<script>var a = document.getElementsByTagName("a"); for (var m = 0, n = a.length; m<n; m++){ (function () { a[m].onclick = function(){ return false; } })(); }</script>');

            }
            // 载入 JS 代码
            if(js_source){
                js_source = util.format(js_source, 'js');
                previewFrame.document.write('<script>'+'try{'+js_source +'}catch(e){ alert("JavaScript脚本异常，请检查代码");}' +'</script>');
            }

            /* 尼玛 $(previewFrame) 为啥只能get不能set了? */
            if(previewFrame.document.body && $(conf.SELECTOR_PREVIEW_FRAME).attr('data-previewed') === undefined){
                setTimeout(function(){
                    /* 自动调整高度 */
                    $(conf.SELECTOR_PREVIEW_FRAME).hide()
                        .attr({
                            'height': previewFrame.document.body.scrollHeight,
                            'data-previewed': ''
                        }).slideDown(100);
                }, 200);
            }
        },

        /* 模块列表 */
        listByChannel: function(ch_id/* channel id */, template/* list template */, appendTo/* list container */){
            if(!template || !appendTo){ return; }

            $.getJSON(conf.API+'?act=getModByChannel&channel='+ch_id, function(data) {

                if(data.data.value.length !== 0){
                    var mod_list = data.data.value;

                    // cache template
                    $.template('modListTemplate', $(template).html());

                    for(var i = 0, j = mod_list.length; i < j; i++){
                        // 列表项模板
                        $.tmpl('modListTemplate',{
                            "classname": util.classname(),  // 随机 class 名
                            "ch_id": ch_id,
                            "mod_id": mod_list[i].mod_id,
                            "mod_thumbnail": mod_list[i].mod_thumbnail,
                            "mod_name": mod_list[i].mod_name
                        }).appendTo(appendTo);
                    }
                }
            });
        },

        /* 按分类输出的模块列表 */
        listByChannelClassified: function(ch_id/* channel id */, itemTemplate/* list item template */, listTemplate/* list template */, appendTo/* lists container */, callback/* callback */){

            $.getJSON(conf.API+'?act=getModByChannel&channel='+ch_id, function(data) {

                if(data.data.value.length !== 0){
                    var mod_list = data.data.value;

                    // 获取分类列表
                    $.getJSON(conf.API+'?act=getTypeByChannel&channel='+ch_id, function(data){
                        if(data.data.value.length !== 0){

                            var type_list = data.data.value;

                            // 类型id与名称map
                            var type_array = [];
                            for(var m = 0, n = type_list.length; m < n; m++){
                                type_array[type_list[m].type_id] = type_list[m].type_name;
                            }

                            // 配置是否已生成分类容器
                            var type_config = {};

                            // cache template
                            $.template('modListItemTemplate', $(itemTemplate).html());
                            $.template('modListTemplate', $(listTemplate).html());

                            for(var i = 0, j = mod_list.length; i < j; i++){

                                var type_id = 'type_'+mod_list[i].mod_type;
                                if(!type_config[mod_list[i].mod_type]){
                                    $.tmpl('modListTemplate', {
                                        "type_name": type_array[mod_list[i].mod_type],
                                        "type_id": type_id
                                    }).appendTo(appendTo);

                                    type_config[mod_list[i].mod_type] = mod_list[i].mod_type;
                                }

                                // 列表项模板
                                $.tmpl('modListItemTemplate',{
                                    "classname": util.classname(),  // 随机 class 名
                                    "ch_id": ch_id,
                                    "mod_id": mod_list[i].mod_id,
                                    "mod_thumbnail": mod_list[i].mod_thumbnail,
                                    "mod_name": mod_list[i].mod_name,
                                    "mod_html": mod_list[i].mod_html,
                                    "mod_css": mod_list[i].mod_css
                                }).appendTo('#'+type_id);
                            }

                            if(callback && typeof callback === 'function'){
                                callback();
                            }
                        }
                    });
                }
            });
        }
    }
});