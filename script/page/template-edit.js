/**
 * @desc: 频道编辑页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', '../module/util', '../module/user', '../module/template', '../module/channel'], function($, util, user, template, channel){
    return {

        /* 初始化 */
        init: function(){

            // 粘贴预览图片
            $('#paste')[0].onpaste = function(e){
                util.paste(e, function(data){
                    $('#tmp_thumbnail').show().attr('src', data);
                });
            };

            var act = util.param('act'),
                ch_id = util.param('ch_id');

            $('#btn_back').attr('href', $('#btn_back').attr('href') + '&ch_id=' + ch_id);

            // 载入模板数据
            if(util.param('act') === 'update' && util.param('tmp_id') !== ''){
                // 获取频道 ID
                var id = util.param('tmp_id'),
                    template_obj;

                if($.trim(id) !== ''){
                    template.find(id, function(data){
                        try{
                            template_obj = data.data.value;

                            $('#tmp_name').val(template_obj.tmp_name);
                            $('#tmp_html').val(template_obj.tmp_html);
                            $('#tmp_css').val(template_obj.tmp_css);
                            $('#tmp_desc').val(template_obj.tmp_desc);
                            if(template_obj.tmp_thumbnail!=""){
                                $('#tmp_thumbnail').show().attr('src', template_obj.tmp_thumbnail);
                                template_obj = null;
                            }

                            // 如果模板样式为空则载入频道样式
                            if($('#tmp_css').val() == ''){
                                // 载入频道样式
                                channel.find(ch_id, function(data){
                                    var ch_css = data.data.value.ch_css;
                                    ch_css = ch_css.replace(/\r\n|\s|;$/,'');

                                    var linkArray = ch_css.split(';'),
                                        linkString = '';

                                    while(linkArray.length > 0){
                                        linkString += '<link rel="stylesheet" href="'+linkArray.pop()+'" />\r\n';
                                    }
                                    $('#tmp_css').val(linkString);
                                });
                            }

                        }catch(e){
                            util.message('获取数据失败，请重试！');
                        }
                    });
                }
            }

            // 替换模板html中的样式
            function replaceStyle(template_html/* 模板html */, ch_css/* 频道样式 */){
                if(template_html && template_html !== ''){
                    if(template_html.indexOf('CH_STYLE') != -1){
                        // 包含频道样式（标签为硬编码，如果在编辑时被改动，将不被替换）
                        template_html = template_html.replace(/<!--\s+S\s+CH_STYLE\s+-->[\s\S]*<!--\s+E\s+CH_STYLE\s+-->/g, '<!-- S CH_STYLE -->'+ch_css+'<!-- E CH_STYLE -->');
                    }else{
                        // 未包含频道样式
                        template_html = template_html.replace(/<\/head>/, '<!-- S CH_STYLE -->'+ch_css+'<!-- E CH_STYLE --></head>');
                    }
                }
                return template_html;
            }

            $('#btn_template_save').click(function(){

                if(util.param('act') === 'insert'){

                    template.add({
                        "tmp_channel": util.param('ch_id'),
                        "tmp_name": $('#tmp_name').val(),
                        "tmp_html": replaceStyle($('#tmp_html').val(), $('#tmp_css').val()),
                        "tmp_css": $('#tmp_css').val(),
                        "tmp_desc": $('#tmp_desc').val(),
                        "tmp_thumbnail": $('#tmp_thumbnail').attr('src')
                    }, function(data){
                        try{
                            if($.parseJSON(data).success.toString() == 'success'){
                                util.message('保存失败！');
                            }

//                            if($.parseJSON(data).success.toString() == 'success' && window.confirm('添加成功！是否继续添加？')){
//                                location.href = './template-edit.php?act=insert&ch_id='+util.param('ch_id');
//                            }else{
//                                location.href = './template-list.php?ch_id='+util.param('ch_id');
//                            }
                        }catch(e){
                            util.message('保存失败！');
                        }
                    });
                }else if(util.param('act') === 'update'){
                    template.update(util.param('tmp_id'), {
                        "tmp_channel": util.param('ch_id'),
                        "tmp_name": $('#tmp_name').val(),
                        "tmp_html": replaceStyle($('#tmp_html').val(), $('#tmp_css').val()),
                        "tmp_css": $('#tmp_css').val(),
                        "tmp_desc": $('#tmp_desc').val(),
                        "tmp_thumbnail": $('#tmp_thumbnail').attr('src')
                    }, function(data){
                            if($.parseJSON(data).success.toString() == 'success'){
                                util.message('更新成功！');
//                                if(window.confirm('更新成功！是否返回列表？')){
//                                    location.href = './template-list.php?ch_id='+util.param('ch_id');
//                                }
                            }else{
                                util.message('更新失败！');
                            }
                    });
                }
            });
        }

    }
});