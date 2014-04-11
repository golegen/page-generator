/**
 * @desc: 模块列表页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', '../module/util', '../module/user','../module/channel', '../module/module', '../module/type', '../module/ZeroClipboard'], function($, util, user, channel, module, type){
    return {

        /* 初始化 */
        init: function(){
            var ch_id = util.param('ch_id');
            if(ch_id !== ''){
                user.setAsAdminOpt('#typeEditWrap, #newModWrap');

                $('#newMod').attr('href', $('#newMod').attr('href')+'&ch_id='+ch_id);
                $('#typeEdit').attr('href', $('#typeEdit').attr('href')+'&ch_id='+ch_id);
                $('#btn_back').attr('href', $('#btn_back').attr('href')+'&ch_id='+ch_id);

                type.listByChannel(ch_id, '#modSelectorTemplate','#modSelectorListTemplate');

                module.listByChannelClassified(ch_id, '#modListItemTemplate','#modListTemplate', '#classifiedList', function(){

                    user.setAsAdminOpt('.ico_edit, .ico_delete');

                    // 分类列表展开收起
                    // $('#classifiedList ul').hide();
                    $('.mod_hd').click(function(){
                        $(this).next().toggle('230');
                        var obj = $(this).find(".cate_title").next();

                        if($(obj).hasClass("hidden_wrap")) $(obj).removeClass("hidden_wrap");
                        else $(obj).addClass("hidden_wrap")
                    });

                    // 删除模块
                    $('.ico_delete').click(function(){
                        if($(this).attr('data-id') !== '' && window.confirm('确定要删除？')){
                            var item =  $(this).parents('.item');
                            module.remove($(this).attr('data-id'), function(){
                                item.remove();
                            });
                        }
                    });

                    // 编辑模块
                    $('.ico_edit').click(function(){
                        if($(this).attr('data-url') !== ''){
                            location.href = $(this).attr('data-url');
                        }
                    });

                    // 拷贝模块代码
                    ZeroClipboard.setMoviePath( 'script/ZeroClipboard10.swf' );
                    var clip = new ZeroClipboard.Client();
                    clip.setHandCursor(true);
                    clip.glue('glue');
                    clip.addEventListener( 'mouseover', function(client){
                        $(client.domElement).parents('li').addClass('on');
                    });
                    clip.addEventListener( 'mouseout', function(client){
                        $(client.domElement).parents('li').removeClass('on');
                    });
                    clip.addEventListener( 'complete', function(){
                        util.message('复制成功！');
                    });

                    $('.ico_copy').mouseover(function(){
                            var txt = $(this).parents('li').find('.mod_html').text();
                            txt = util.clean(txt);

                            clip.setText(txt);
                            clip.reposition(this);
                    });

                    $('.list_module li').hover(function(){
                        this.className = 'on';
                    },function(){
                         this.className = '';
                    });

                });
            }
        }

    }
});