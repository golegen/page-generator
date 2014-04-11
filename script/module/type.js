/**
 * @desc: 模块分类管理类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-22
 */

define(['jquery', './conf', './user', './util','./tmpl'], function($, conf, user, util){
    return {
        /* 添加分类 */
        add: function(obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=insert',{
                "data":{
                    "table": "tb_type",
                    "value":{
                        "type_id": obj.type_id,
                        "type_channel": obj.type_channel,
                        "type_name": obj.type_name,
                        "type_thumbnail": obj.type_thumbnail,
                        "type_count": obj.type_count,
                        "type_state": obj.type_state
                    }
                }
            }, callback);
        },

        /* 删除分类 */
        remove: function(id, callback){
            if(!user.isAdmin) return;

            $.getJSON(conf.API+'?act=delTypeById&id='+id, callback);
        },

        /* 修改分类 */
        update: function(id, obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=update',{
                "data":{
                    "table": "tb_type",
                    "value":{
                        "type_id": obj.type_id,
                        "type_channel": obj.type_channel,
                        "type_name": obj.type_name,
                        "type_thumbnail": obj.type_thumbnail,
                        "type_count": obj.type_count,
                        "type_state": obj.type_state
                    },
                    "where":"type_id="+id
                }
            }, callback);
        },

        /* 分类选择器 */
        selection: function(ch_id/* channel id */, select/* ID of select element */, selectedValue/* current selected */){
            $.getJSON(conf.API+'?act=getTypeByChannel&channel='+ch_id, function(data){
                if(data.data.value.length !== 0){

                    var type_list = data.data.value;

                    $(select).empty();
                    for(var i = 0, j = type_list.length; i < j; i++){
                        $(select).append('<option value="'+type_list[i].type_id+'">'+type_list[i].type_name+'</option>');
                    }
                    $(select).val(selectedValue);
                }
            });
        },

        /* 根据id获取分类 */
        getTypeNameById: function(typeId/* ID of type */){
            $.getJSON(conf.API+'?act=getTypeByChannel&channel='+ch_id, function(data){
                if(data.data.value.length !== 0){
                    var type_list = data.data.value;

                    for(var i = 0, j = type_list.length; i < j; i++){
                        if(type_list[i].type_id === typeId){
                            console.log(type_list[i].type_name);
//                            $.type_name = type_list[i].type_name;
                        }
                    }
                }
            });
            console.log($.type_name)
        },

        /* 根据频道获取模块分类列表 */
        listByChannel: function(ch_id/* channel id */,template/* list template */, appendTo/* list container */, callback/* callback */){
            $.getJSON(conf.API+'?act=getTypeByChannel&channel='+ch_id, function(data){
                if(data.data.value.length !== 0){

                    var type_list = data.data.value;

                    // cache template
                    $.template('modTypeListTemplate', $(template).html());

                    for(var i = 0, j = type_list.length; i < j; i++){

                        // 列表项模板
                        $.tmpl('modTypeListTemplate',{

                            "classname": util.classname(),
                            "type_id": type_list[i].type_id,
                            "type_channel": type_list[i].type_channel,
                            "type_name": type_list[i].type_name,
                            "type_thumbnail": type_list[i].type_thumbnail,
                            "type_count": type_list[i].type_count,
                            "type_state": type_list[i].type_state

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