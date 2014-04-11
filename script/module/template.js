/**
 * @desc: 布局模板管理类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-27
 */

define(['jquery', './conf', './user', './util', './type', './tmpl'], function($, conf, user, util){
    return {

        /* 添加模板 */
        add: function(obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=insert',{
                "data":{
                    "table": "tb_template",
                    "value":{
                        "tmp_channel": obj.tmp_channel,
                        "tmp_name": obj.tmp_name,
                        "tmp_html": obj.tmp_html,
                        "tmp_css": obj.tmp_css,
                        "tmp_desc": obj.tmp_desc,
                        "tmp_thumbnail": obj.tmp_thumbnail
                    }
                }
            }, callback);
        },

        /* 修改模板 */
        update: function(id, obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=update',{
                "data":{
                    "table": "tb_template",
                    "value":{
                        "tmp_channel": obj.tmp_channel,
                        "tmp_name": obj.tmp_name,
                        "tmp_html": obj.tmp_html,
                        "tmp_css": obj.tmp_css,
                        "tmp_desc": obj.tmp_desc,
                        "tmp_thumbnail": obj.tmp_thumbnail
                    },
                    "where":"tmp_id="+id
                }
            }, callback);
        },

        /* 删除频道 */
        delete: function(id, callback){
            if(!user.isAdmin) return;

            $.getJSON(conf.API+'?act=delTemplateById&id='+id, callback);
        },

        /* 查找模块 */
        find: function(id, callback){
            $.getJSON(conf.API+'?act=getTemplateById&&id='+id, callback);
        },

        /* 模板选择器 */
        selection: function(ch_id/* channel id */, select/* ID of select element */, selectedIndex/* current selected */){
            $.getJSON(conf.API+'?act=getTemplateByChannel&channel='+ch_id, function(data){
                if(data.data.value.length !== 0){

                    var template_list = data.data.value;

                    $(select).empty();
                    for(var i = 0, j = template_list.length; i < j; i++){
                        $(select).append('<option value="'+template_list[i].tmp_id+'">'+template_list[i].tmp_name+'</option>');
                    }
                    if(selectedIndex){
                        $(select).val(selectedIndex);
                    }
                }
            });
        },

        /* 获取布局列表 */
        list: function(template/* list template */, appendTo/* list container */, callback/* callback */){
            if(!template || !appendTo){ return; }

            $.getJSON(conf.API+'?act=getTemplateList', function(data) {

                if(data.data.value.length !== 0){
                    var template_list = data.data.value;

                    // cache template
                    $.template('templateListTemplate', $(template).html());

                    for(var i = 0, j = template_list.length; i < j; i++){
                        // 列表项模板
                        $.tmpl('templateListTemplate',{
                            "classname": util.classname(),  // 随机 class 名
                            "tmp_id": template_list[i].tmp_id,
                            "tmp_channel": template_list[i].tmp_channel,
                            "tmp_name": template_list[i].tmp_name,
                            "tmp_html": template_list[i].tmp_html,
                            "tmp_css": template_list[i].tmp_css,
                            "tmp_desc": template_list[i].tmp_desc,
                            "tmp_thumbnail": template_list[i].tmp_thumbnail
                        }).appendTo(appendTo);
                    }

                    if(callback && typeof callback === 'function'){
                        callback();
                    }
                }
            });
        },

        /* 根据频道获取布局列表 */
        listByChannel: function(ch_id/* channel id */, template/* list template */, appendTo/* list container */, callback/* callback */){

            $.getJSON(conf.API+'?act=getTemplateByChannel&channel='+ch_id, function(data) {

                if(data.data.value.length !== 0){
                    var template_list = data.data.value;

                    // cache template
                    $.template('templateListTemplate', $(template).html());

                    for(var i = 0, j = template_list.length; i < j; i++){
                        // 列表项模板
                        $.tmpl('templateListTemplate',{
                            "classname": util.classname(),  // 随机 class 名
                            "tmp_id": template_list[i].tmp_id,
                            "tmp_channel": template_list[i].tmp_channel,
                            "tmp_name": template_list[i].tmp_name,
                            "tmp_html": template_list[i].tmp_html,
                            "tmp_css": template_list[i].tmp_css,
                            "tmp_desc": template_list[i].tmp_desc,
                            "tmp_thumbnail": template_list[i].tmp_thumbnail==""?"img/icon_template.png":template_list[i].tmp_thumbnail
                        }).appendTo(appendTo);
                    }

                    if(callback && typeof callback === 'function'){
                        callback();
                    }
                }
            });
        }
    }
});