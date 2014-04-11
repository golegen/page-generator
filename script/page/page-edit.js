/**
 * @desc: 页面编辑页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', '../module/util', '../module/user', '../module/page', '../module/template',  '../module/uploadify'], function($, util, user, page, template){
    return {

        /* 初始化 */
        init: function(){

            var ch_id = util.param('ch_id'),
                page_id = util.param('page_id'),
                page_obj;

            $('#btn_back').attr('href', $('#btn_back').attr('href')+'&ch_id='+ch_id);

            /* 载入页面数据 */
            if(util.param('act') === 'update' && util.param('page_id') !== ''){

                if($.trim(ch_id) !== ''){
                    page.find(util.param('page_id'), function(data){
                            page_obj = data.data.value;

                            $('#page_title').val(page_obj.page_title);
                            /* 只能查看模板名称 */
                            $('#page_tmp').attr('disabled', 'disabled').append('<option>'+page_obj.tmp_name+'</option>');
                            $('#page_keyword').val(page_obj.page_keyword);
                            $('#page_desc').val(page_obj.page_desc);
                            $('#page_directory').val(page_obj.page_directory);
                            $('#page_filename').val(page_obj.page_filename);
                            $('#page_thumbnail').show().attr('src', page_obj.page_thumbnail);
                    });
                }
            }else if(util.param('act') === 'insert'){
                /* 初始化模板选择器 */
                template.selection(ch_id, '#page_tmp');
            }

            $('#btn_page_save').click(function(){

                if($.trim($('#page_title').val()) === ''){ util.message('请输入页面名称'); return;}
                if($.trim($('#page_keyword').val()) === ''){ util.message('请输入页面关键字'); return;}
                if($.trim($('#page_desc').val()) === ''){ util.message('请输入页面描述'); return;}
                if($.trim($('#page_directory').val()) === ''){ util.message('请输入目录名'); return;}
                if($.trim($('#page_filename').val()) === ''){ util.message('请输入文件名'); return;}

                if(util.param('act') === 'insert'){

                    page.add({
                        "page_title": $('#page_title').val(),
                        "page_channel": ch_id,
                        "page_tmp": $('#page_tmp').val(),
                        "page_keyword": $('#page_keyword').val(),
                        "page_desc": $('#page_desc').val(),
                        "page_directory": $('#page_directory').val(),
                        "page_filename": $('#page_filename').val(),
                        "page_creator": user.getUserName(),
                        "page_thumbnail": $('#page_thumbnail').attr('src')
                    }, function(data){
                            data = $.parseJSON(data);
                            if(data.success.toString() == 'success'){
                                /* 保存成功后直接跳转到编辑页面 */
                                location.href = './workshop.php?act=update&ch_id='+ch_id+'&page_id='+data.id;
                            }else{
                                util.message('添加失败，请重试！');
                            }
                    });

                }else if(util.param('act') === 'update'){

                    page.update(util.param('page_id'), {
                        "page_title": $('#page_title').val(),
                        "page_keyword": $('#page_keyword').val(),
                        "page_desc": $('#page_desc').val(),
                        "page_directory": $('#page_directory').val(),
                        "page_filename": $('#page_filename').val(),
                        "page_editor": user.getUserName(),
                        "page_thumbnail": $('#page_thumbnail').attr('src')
                    }, function(data){
                        if($.parseJSON(data).success.toString() == 'success'){
                            /* 更新成功后直接跳转到编辑页面 */
                            location.href = './workshop.php?act=update&ch_id='+ch_id+'&page_id='+page_id;
                        }else{
                            util.message('更新失败，请重试！');
                        }
                    });
                }
            });
        }
    }
});