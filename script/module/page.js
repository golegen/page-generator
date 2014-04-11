/**
 * @desc: 页面管理类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', './conf', './user', './util', './tmpl'], function($, conf, user, util){
    return {

        /* 添加页面 */
        add: function(obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=insert',{
                "data":{
                    "table": "tb_page",
                    "value":{
                        "page_channel": obj.page_channel,
                        "page_title": obj.page_title,
                        "page_keyword": obj.page_keyword,
                        "page_desc": obj.page_desc,
                        "page_directory": obj.page_directory,
                        "page_filename": obj.page_filename,
                        "page_tmp": obj.page_tmp,
                        "page_source": obj.page_source,
                        "page_data": obj.page_data,
                        "page_modlist": obj.page_modlist,
                        "page_creator": obj.page_creator,
                        "page_editor": obj.page_editor,
                        "page_addtime": 'now()',
                        "page_thumbnail": obj.page_thumbnail,
                        "page_state": 1
                    }
                }
            }, callback);
        },

        /* 修改页面 */
        update: function(id, obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=update',{
                "data":{
                    "table": "tb_page",
                    "value":{
                        "page_channel": obj.page_channel,
                        "page_title": obj.page_title,
                        "page_keyword": obj.page_keyword,
                        "page_desc": obj.page_desc,
                        "page_directory": obj.page_directory,
                        "page_filename": obj.page_filename,
                        "page_tmp": obj.page_tmp,
                        "page_source": obj.page_source,
                        "page_data": obj.page_data,
                        "page_modlist": obj.page_modlist,
                        "page_creator": obj.page_creator,
                        "page_editor": obj.page_editor,
                        "page_thumbnail": obj.page_thumbnail,
                        "page_state": obj.page_state
                    },
                    "where":"page_id="+id
                }
            }, callback);
        },

        /* 查找页面 */
        find: function(id, callback){
            $.getJSON(conf.API+'?act=getPageById&id='+id, callback);
        },

        /* 删除页面 */
        remove: function(id, callback){
            if(!user.isAdmin) return;

            $.getJSON(conf.API+'?act=delPageById&id='+id, callback);
        },

        /* 根据用户获取页面列表 */
        listByUserByChannel: function(user/* username */, channel/* channel */, template/* list template */, appendTo/* list container */, callback/* callback */){
            if($.trim(user) === ''){ return; }
            if(!channel){ channel = -1; }

            $.getJSON(conf.API+'?act=getPageListByUser&user='+user+'&channel='+channel, function(data){
                    var page_list = data.data.value;

                    // cache template
                    $.template('pageListTemplate', $(template).html());

                    for(var i = 0, j = page_list.length; i < j; i++){

                        // 列表项模板
                        $.tmpl('pageListTemplate',{
                            "classname": util.classname(),
                            "page_id": page_list[i].page_id,
                            "page_channel": page_list[i].page_channel,
                            "page_title": page_list[i].page_title,
                            "page_thumbnail": page_list[i].page_thumbnail
                        }).appendTo(appendTo);
                    }

                    if(callback && typeof callback === 'function'){
                        callback();
                    }
            });
        },

        /* 根据频道获取页面列表 */
        listByChannel: function(ch_id/* channel id */, template/* list template */, appendTo/* list container */, callback/* callback */){
            $.getJSON(conf.API+'?act=getPageListByChannel&channel='+ch_id, function(data){
                if(data.data.value.length !== 0){
                    var page_list = data.data.value;

                    // cache template
                    $.template('pageListTemplate', $(template).html());

                    for(var i = 0, j = page_list.length; i < j; i++){

                        // 列表项模板
                        $.tmpl('pageListTemplate',{
                            "classname": util.classname(),
                            "page_id": page_list[i].page_id,
                            "page_channel": page_list[i].page_channel,
                            "page_title": page_list[i].page_title,
                            "page_thumbnail": page_list[i].page_thumbnail
                        }).appendTo(appendTo);
                    }

                    if(callback){
                        callback();
                    }
                }
            });
        }
    }
});