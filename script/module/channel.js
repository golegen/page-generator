/**
 * @desc: 频道管理类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-19
 */

define(['jquery', './conf', './user', './util', './tmpl'], function($, conf, user, util){
    return {

        /* 添加频道 */
        add: function(obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=insert',{
                "data":{
                    "table": "tb_channel",
                    "value":{
                        "ch_name": obj.ch_name,
                        "ch_ename": obj.ch_ename,
                        "ch_parent": obj.ch_parent,
                        "ch_thumbnail": obj.ch_thumbnail,
                        "ch_css": obj.ch_css,
                        "ch_path": obj.ch_path,
                        "ch_sort": obj.ch_sort
                    }
                }
            }, callback);
        },

        /* 修改频道 */
        update: function(id, obj, callback){
            if(!user.isAdmin) return;

            $.post(conf.API+'?act=update',{
                "data":{
                    "table": "tb_channel",
                    "value":{
                        "ch_name": obj.ch_name,
                        "ch_ename": obj.ch_ename,
                        "ch_parent": obj.ch_parent,
                        "ch_thumbnail": obj.ch_thumbnail,
                        "ch_css": obj.ch_css,
                        "ch_path": obj.ch_path,
                        "ch_sort": obj.ch_sort
                    },
                    "where":"ch_id="+id
                }
            }, callback);
        },

        /* 删除频道 */
        delete: function(id, callback){
            if(!user.isAdmin) return;

            $.getJSON(conf.API+'?act=delChannelById&id='+id, callback);
        },

        /* 查找频道 */
        find: function(id, callback){
            $.getJSON(conf.API+'?act=getChannelById&id='+id, callback);
        },

        /* 频道选择器 */
        selection: function(select/* ID of select element */, selectedIndex/* current selected */){
            $.getJSON(conf.API+'?act=getChannelList', function(data){
                if(data.data.value.length !== 0){

                    var channel_list = data.data.value;

                    $(select).empty();
                    for(var i = 0, j = channel_list.length; i < j; i++){
                        $(select).append('<option value="'+channel_list[i].ch_id+'">'+channel_list[i].ch_name+'</option>');
                    }
                    if(selectedIndex){
                        $(select).val(selectedIndex);
                    }
                }
            });
        },

        /* 获取频道列表 */
        list: function(template/* list template */, appendTo/* list container */, callback/* callback */){
            $.getJSON(conf.API+'?act=getChannelList', function(data){
                if(data.data.value.length !== 0){
                    var channel_list = data.data.value;

                    // cache template
                    $.template('channelListTemplate', $(template).html());

                    for(var i = 0, j = channel_list.length; i < j; i++){
                        
                        // 列表项模板
                        $.tmpl('channelListTemplate',{

                            "classname": util.classname(),
                            "ch_id": channel_list[i].ch_id,
                            "ch_name": channel_list[i].ch_name,
                            "ch_ename": channel_list[i].ch_ename,
                            "ch_thumbnail": channel_list[i].ch_thumbnail

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