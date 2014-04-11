/**
 * @desc: 频道编辑页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', '../module/util', '../module/user', '../module/channel',  '../module/uploadify'], function($, util, user, channel){
    return {

        /* 初始化 */
        init: function(){

            // 载入频道数据
            if(util.param('act') === 'update' && util.param('ch_id') !== ''){
                // 获取模块 ID
                var id = util.param('ch_id'),
                    channel_obj;

                if($.trim(id) !== ''){
                    channel.find(id, function(data){
                        try{
                            channel_obj = data.data.value;

                            // 展示时换行
                            var ch_css = channel_obj.ch_css;
                            ch_css = ch_css.replace(/;/g, ';\r\n');

                            $('#ch_name').val(channel_obj.ch_name);
                            $('#ch_ename').val(channel_obj.ch_ename);
                            $('#ch_parent').val(channel_obj.ch_parent);
                            $('#ch_css').val(ch_css);
                            $('#ch_path').val(channel_obj.ch_path);
                            $('#ch_sort').val(channel_obj.ch_sort);
                            $('#ch_thumbnail').show().attr('src', channel_obj.ch_thumbnail);

                        }catch(e){
                            util.message('获取数据失败，请重试！');
                        }
                    });
                }
            }

            $('#btn_channel_save').click(function(){
                var ch_css = $('#ch_css').val();
                if(ch_css != ''){
                    // 保存或更新时去掉换行
                    ch_css = ch_css.replace(/(\s|\r\n)*/g, '');
                }

                if(util.param('act') === 'insert'){

                    channel.add({
                        "ch_name": $('#ch_name').val(),
                        "ch_ename": $('#ch_ename').val(),
                        "ch_parent": $('#ch_parent').val(),
                        "ch_thumbnail": $('#ch_thumbnail').attr('src'),
                        "ch_css": ch_css,
                        "ch_path": $('#ch_path').val(),
                        "ch_sort": $('#ch_sort').val()
                    }, function(data){
                        try{
                            if($.parseJSON(data).success.toString() == 'success' && window.confirm('添加成功！是否继续添加？')){
                                location.href = './channel-edit.php?act=insert';
                            }else{
                                location.href = './channel-list.php';
                            }
                        }catch(e){
                            util.message('添加失败，请重试！');
                        }
                    });
                }else if(util.param('act') === 'update'){
                    channel.update(util.param('ch_id'), {
                        "ch_name": $('#ch_name').val(),
                        "ch_ename": $('#ch_ename').val(),
                        "ch_parent": $('#ch_parent').val(),
                        "ch_thumbnail": $('#ch_thumbnail').attr('src'),
                        "ch_css": ch_css,
                        "ch_path": $('#ch_path').val(),
                        "ch_sort": $('#ch_sort').val()
                    }, function(data){
                        try{
                            if($.parseJSON(data).success.toString() == 'success' && window.confirm('更新成功！是否返回列表？')){
                                location.href = './channel-list.php';
                            }
                        }catch(e){
                            util.message('更新失败，请重试！');
                        }
                    });
                }
            });
        }

    }
});