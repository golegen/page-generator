/**
 * @desc: 模块编辑页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', '../module/util', '../module/user','../module/channel', '../module/module', '../module/type', '../module/tmpl', '../module/uploadify'], function($, util, user, channel, module, type){
    return {

        /* 初始化 */
        init: function(){

            var ch_id = util.param('ch_id');
            $('#btn_back').attr('href', $('#btn_back').attr('href') + '&ch_id='+ ch_id);

            // 载入模块数据
            if(util.param('act') === 'update' && util.param('id') !== ''){
                // 获取模块 ID
                var id = util.param('id'),
                    mod_obj;

                if($.trim(id) !== ''){
                    module.find(id, function(data){
                        try{
                            mod_obj = data.data.value;

                            $.template('modViewTemplate', $('#modViewTemplate').html());
                            $.template('modEditTemplate', $('#modEditTemplate').html());

                            if(user.isAdmin){
                                $.tmpl('modEditTemplate',{
                                    mod_name: mod_obj.mod_name,
                                    mod_thumbnail: mod_obj.mod_thumbnail,
                                    mod_html: util.format(mod_obj.mod_html, 'html'),
                                    mod_css: util.format(mod_obj.mod_css, 'css'),
                                    ch_css: util.format(mod_obj.ch_css, 'css')
                                }).appendTo('#modPanel');

                                if(mod_obj.mod_ispublic == 0){
                                    $('.frm_radio input').eq(0).attr('checked', 'checked').end().eq(1).removeAttr('checked');
                                }else if(mod_obj.mod_ispublic == 1){
                                    $('.frm_radio input').eq(1).attr('checked', 'checked').end().eq(0).removeAttr('checked');
                                }

                                /* 载入模块分类 */
                                type.selection(ch_id, '#typeSelect', mod_obj.type_id);

                                /* 隐藏空图片框 */
                                if($('#mod_thumbnail').attr('src') == ''){
                                    $('#mod_thumbnail').hide();
                                }

                                // 粘贴预览图片
                                $('#paste')[0].onpaste = function(e){
                                    util.paste(e, function(data){
                                        $('#mod_thumbnail').show().attr('src', data);
                                    });
                                };
                            }else{
                                var ispublic = mod_obj.mod_ispublic === 1 ? '公共' : '私有';

                                $.tmpl('modViewTemplate', {
                                    mod_name: mod_obj.mod_name,
                                    mod_type: mod_obj.type_id,
                                    mod_ispublic: ispublic,
                                    mod_thumbnail: mod_obj.mod_thumbnail,
                                    mod_html: util.format(mod_obj.mod_html, 'html'),
                                    mod_css: util.format(mod_obj.mod_css, 'css'),
                                    ch_css: util.format(mod_obj.ch_css, 'css')
                                }).appendTo('#modPanel');
                            }

                            if(mod_obj.mod_thumbnail !== ''){
                                $('#mod_thumbnail').show();
                            }

                            module.preview(mod_obj.mod_html, mod_obj.mod_css, mod_obj.mod_js, mod_obj.ch_css);
                        }catch(e){

                        }
                    });
                }
            }else if(util.param('act') === 'insert'){

                /* 设置频道基础样式 */
                if(util.param('ch_id') !== ''){
                    channel.find(util.param('ch_id'), function(data){
                        if(data.data.value.length !== 0){
                            var channel_obj = data.data.value;
                            $('#ch_css').val(channel_obj.ch_css);
                        }
                    });
                }

                if(user.isAdmin){
                    $.template('modEditTemplate', $('#modEditTemplate').html());
                    $.tmpl('modEditTemplate').appendTo('#modPanel');
                    type.selection(ch_id, '#typeSelect');

                    // 粘贴预览图片
                    $('#paste')[0].onpaste = function(e){
                        util.paste(e, function(data){
                            $('#mod_thumbnail').show().attr('src', data);
                        });
                    };
                }
            }

            // 添加/更新 模块
            $('#btn_mod_save').live('click', function(e){
                e.preventDefault();

                // 新增的模块对象
                var new_mod = {
                    "mod_channel": util.param('ch_id')||0,
                    "mod_name": $('#mod_name').val(),
                    "mod_html": $('#mod_html').val(),
                    "mod_css": $('#mod_css').val(),
                    "mod_js": $('#mod_js').val(),
                    "mod_type": $('#typeSelect').val(),
                    "mod_thumbnail": $('#mod_thumbnail').attr('src'),
                    "mod_creator": user.getUserName(),
//                    "mod_frequency": obj.mod_frequency,
//                    "mod_state": obj.mod_state,
                    "mod_ispublic": $('.frm_radio input:checked').val()
//                    "mod_sort": obj.mod_sort
                };

                if(util.param('act') === 'insert'){
                        module.add(new_mod, function(data){
                            if($.parseJSON(data).success.toString() == 'success'){
                                util.message('添加成功！');

                                /* 添加成功之后改为更新操作 */
                                location.href = document.URL.replace('insert', 'update') + '&id=' + $.parseJSON(data).id;

//                                if(window.confirm('添加成功！是否继续添加？')){
//                                    location.href = './module-edit.php?act=insert&ch_id='+util.param('ch_id');
//                                }else{
//                                    location.href = './module-list.php?ch_id='+util.param('ch_id');
//                                }
                            }else{
                                util.message('添加失败，请重试！');
                            }
                        });
                }else if(util.param('act') === 'update' && (id = util.param('id'))){
                        module.update(id, new_mod,function(data) {
                            if($.parseJSON(data).success.toString() == 'success'){
                                util.message('更新成功！');
//                                location.href = './module-list.php?ch_id='+util.param('ch_id');
                            }else{
                                util.message('更新失败，请重试！');
                            }
                        });
                }
            });

            // 删除模块
            $('.btn_mod_delete').live('click', function(e){
                e.preventDefault();
                if(id && window.confirm('确定要删除？慎重啊！')){
                    module.remove(id, function(){
                        util.message('删除成功！');
                        location.href = './module-list.php?ch_id='+util.param('ch_id');
                    });
                }
            });

            // 预览
            $('#btn_mod_preview').live('click', function(e){
                e.preventDefault();
                module.preview($('#mod_html').val(), $('#mod_css').val(), $('#mod_js').val(), $('#ch_css').val());
            });
        }

    }
});