/**
 * @desc: 页面编辑页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-27
 */

define(['jquery','../module/conf', '../module/util', '../module/user', '../module/module', '../module/page', './panel', '../module/ui'], function($, conf, util, user, module, page, panel){

    return {

        /* 预览初始化 */
        preview: function(){
            /* 设置页面标题 */
            $(document).keyup(function(e){
               if(e.which === 27){
                   parent.$("#pg_dialog").hide();
               }
            });

            page.find(util.param('page_id'), function(data){
                $('title').text(data.data.value.page_title);
            });
        },

        /* 编辑初始化 */
        init: function(){
            console.log('xxxx')

            /* 【测试用】载入操作面板样式，测试完成后直接在页面引入样式 */
            util.loadStyle('css/edit-panel.css?t='+(+new Date));
            util.loadStyle('css/lib/jquery-ui-1.9.2.custom.min.css?t='+(+new Date));

            if(util.param('ch_id')){

                /* 拉取模块列表 */
                var ch_id = util.param('ch_id');

                $('title').text($('#pageTitle').val());

                module.listByChannelClassified(ch_id, '#modListItemTemplate','#modListTemplate', '#classifiedList', function(){
                    /* 折叠成手风琴效果 */
                    $('#classifiedList').accordion({
                        heightStyle: "content",
                        collapsible: true
                    });

                    /* 为返回按钮添加频道id */
                    $('#btn_back').click(function(){
                        location.href = './page-list.php?ch_id=' + util.param('ch_id');
                    });

                    /* 模块拖动 */
                    $(conf.SELECTOR_MOD_WRAP)
                        .draggable({
                            scroll: false,
                            helper: "clone",
                            revert: "invalid"
//                            ,connectToSortable: conf.SELECTOR_TEMPLATE_DROPPABLE
                        });

                    /* 模块放置 */
                    $.layout = $(conf.SELECTOR_TEMPLATE_DROPPABLE);
                    $.mod_list = $('#modList');

                    /* 初始载入页面的模块初始化 */
                    $(conf.SELECTOR_MOD_DROPPABLE).droppable({
                        greedy: true,
                        hoverClass: "drop-hover"
                    }).droppable('option', 'hoverClass', 'md_highlight')
                        .droppable({
                            drop: function(event, ui){
                                $(ui.draggable.find('.md_html').text()).clone()
                                    .attr(conf.ATTR_MOD_ID, ui.draggable.attr(conf.ATTR_MOD_ID))
                                    .appendTo(this);

                                util.loadStyleString(ui.draggable.find('.md_css').text());

                                $.mod_list.val($.mod_list.val() + ui.draggable.attr(conf.ATTR_MOD_ID) + '|');
                            }
                        });

                    /* 模块放置区域初始化 */
                    $.layout.droppable({
                            hoverClass: "layout_highlight",
                            drop: function(event, ui){
                                var dropped = $(ui.draggable.find('.md_html').text()).clone();
                                dropped.attr(conf.ATTR_MOD_ID, ui.draggable.attr(conf.ATTR_MOD_ID))
                                    .attr(conf.ATTR_COMMON, conf.ATTR_VALUE_MOD)
                                    .appendTo(this);
                                util.loadStyleString(ui.draggable.find('.md_css').text());

                                $.mod_list.val($.mod_list.val() + ui.draggable.attr(conf.ATTR_MOD_ID) + '|');

                                /* 模块可嵌套区域 - 可嵌套其他模块 */
                                var container = dropped.find(conf.SELECTOR_MOD_DROPPABLE);

                                if(container.length !== 0){
                                    container.droppable({
                                        greedy: true,
                                        hoverClass: "md_highlight",
                                        drop: function(event, ui){
                                            $(ui.draggable.find('.md_html').text()).clone()
                                                .attr(conf.ATTR_MOD_ID, ui.draggable.attr(conf.ATTR_MOD_ID))
                                                .attr(conf.ATTR_COMMON, conf.ATTR_VALUE_MOD)
                                                .appendTo(this);
                                            util.loadStyleString(ui.draggable.find('.md_css').text());

                                            $.mod_list.val($.mod_list.val() + ui.draggable.attr(conf.ATTR_MOD_ID) + '|');
                                        }
                                    });
                                }
                            }
                        }).click(function(e){
                            $.curEditElement = $(e.target);

                            if($.curMd){
                                $.curMd.removeClass(conf.CLASSNAME_MOD_CURRENT);
                            }

                            /* 模块嵌套时 $(e.target).parents('[data-pg="md"]') 可能多于1个 */
                            var curMd = $(e.target).attr(conf.ATTR_COMMON) === conf.ATTR_VALUE_MOD ?
                                $(e.target) : $(e.target).parents(conf.SELECTOR_MOD).eq(0);

                            curMd.addClass(conf.CLASSNAME_MOD_CURRENT);
                            $.curMd = curMd;

                            if(!panel.hasPanel()){
                                $('.pg_popup').hide();
                            }

                            e.preventDefault();
                            e.stopPropagation();

                        }).dblclick(function(e){
                            if(!$.isAttrPanelOpen){
                                util.message('双击编辑操作仅在右键属性面板打开时有效');
                            }else{
                                $.curEditElement = $(e.target);

                                if($.lastEdit){
                                    $.lastEdit.removeClass(conf.CLASSNAME_MOD_CURRENT);
                                    $.lastEdit.removeAttr('contentEditable');
                                }

                                /* 模块嵌套时 $(e.target).parents('[data-pg="md"]') 可能多于1个 */
                                var curMd = $(e.target).attr(conf.ATTR_COMMON) === conf.ATTR_VALUE_MOD ?
                                    $(e.target) : $(e.target).parents(conf.SELECTOR_MOD).eq(0);

                                curMd.attr('contentEditable',conf.IS_CONTENT_EDITABLE);
                                $.lastEdit = $.curMd = curMd;
                            }

                            e.preventDefault();
                            e.stopPropagation();

                        }).bind('contextmenu', function(e){
                            $.curEditElement = $(e.target);

                            if($.curMd){
                                $.curMd.removeClass(conf.CLASSNAME_MOD_CURRENT);
                            }
                            /* 模块嵌套时 $(e.target).parents('[data-pg="md"]') 可能多于1个 */
                            var curMd = $(e.target).attr(conf.ATTR_COMMON) === conf.ATTR_VALUE_MOD ?
                                $(e.target) : $(e.target).parents(conf.SELECTOR_MOD).eq(0);

                            curMd.addClass(conf.CLASSNAME_MOD_CURRENT);
                            $.curMd = curMd;

                            /* 判断是否有面板 */
                            if(!panel.hasPanel()){
                                $('.pg_popup').hide();
                            }

                            /* 打开属性面板 */
                            panel.init({
                                top: e.pageY - $(document).scrollTop() - 10,
                                left: e.pageX + 220
                            });

                            e.preventDefault();
                            e.stopPropagation();

                        }).sortable({
                            items: conf.SELECTOR_MOD,
                            helper: "clone",
//                            axis: "y",
                            connectWith: conf.SELECTOR_MOD,
                            placeholder: "ui-state-highlight",
                            forcePlaceholderSize: true,
                            start: function(e, ui){
                                /* 在排序时给 placeholder 限制宽高，防止表格等宽度为 100% 的组件移除编辑区域 */
                                ui.placeholder.height(ui.item.height())
                                    .width($.layout.width());
                                ui.helper.height(ui.item.height()).addClass('ui-draggable-helper');
                            },
                            beforeStop: function(event, ui){
                                ui.helper.removeClass('ui-draggable-helper');
                            }
                        });

                    /* 对当前模块的操作 */
                    $(document).keyup(function(e){
                        if($.curMd){
                            /* 键盘操作 */
                            var key = e.which;

                            /* 上移 */
                            if(e.shiftKey && (key === 38)){
                                $.curMd.insertBefore($.curMd.prev());
                            }

                            /* 下移 */
                            if(e.shiftKey && (key === 40)){
                                $.curMd.insertAfter($.curMd.next());
                            }

                            /* 删除 */
                            if(key === 46){
                                var mod_id = $.curMd.attr(conf.ATTR_MOD_ID);
                                /* 从模块列表中删除 */
                                $.mod_list.val($.mod_list.val().replace(new RegExp(mod_id+'\\|?'),''));
                                $.curMd.remove();
                            }
                        }
                    }).click(function(e){
                            if(e.target.tagName === 'A'){
                                e.preventDefault();
                            }

                            /* 取消选中 */
                            $(conf.SELECTOR_MOD_CURRENT).removeClass(conf.CLASSNAME_MOD_CURRENT);
                            /* 当前组件失去焦点不显示面板 */
                            if($.curMd && !$.curMd.hasClass(conf.CLASSNAME_MOD_CURRENT)){
                                $('.pg_popup').hide();
                                $.curMd = null;
                            }
                    });

                    /* 保存代码 */
                    $.saveCode = function(callback){
                        util.message('保存中，请稍后...');

                        page.update(util.param('page_id'), {
                            "page_data":$.layout.html().trim(),
                            "page_modlist": $('#modList').val(),
                            "page_editor": user.getUserName()
                        }, callback);
                    };

                    /* 自动保存 */
                    $('#autoSave').click(function(){
                        if($(this).attr('checked') == 'checked'){
                            util.message('自动保存已开启');
                            $.autoSaveTimer = setInterval(function(){
                                $.saveCode(function(data){
                                    if($.parseJSON(data).success.toString() == 'success'){
                                        util.message('保存成功！');
                                    }else{
                                        util.message('更新失败，请重试！');
                                    }
                                });
                            }, conf.AUTO_SAVE_INTERVAL);
                        }else{
                            util.message('自动保存已关闭');
                            clearInterval($.autoSaveTimer);
                        }
                    });

                    $('#savePage').click(function(){
                        $.saveCode(function(data){
                            if($.parseJSON(data).success.toString() == 'success'){
                                util.message('保存成功！');
                            }else{
                                util.message('更新失败，请重试！');
                            }
                        });
                    });

                    $(document).keyup(function(e){
                        if(e.shiftKey && e.which == 83){
                            $.saveCode(function(data){
                                if($.parseJSON(data).success.toString() == 'success'){
                                    util.message('保存成功！');
                                }else{
                                    util.message('更新失败，请重试！');
                                }
                            });
                        }
                    });

                    /* 清空页面数据 */
                    $('#clearPage').click(function(){
                        $.layout.html('');
                        $('#modList').val('');
                    });

                    /* 预览页面 */
                    $('#previewPage').click(function(){
                        $.saveCode(function(data){
                            if($.parseJSON(data).success.toString() == 'success'){
                                util.message('保存成功！');
                                var page_url = location.href.replace('update', 'preview');
                                window.open(page_url,"newwindow", "height=800, width=1225");
                            }else{
                                util.message('更新失败，请重试！');
                            }
                        });
                    });
                });
            }

            /* 禁止编辑区域的右键菜单 */
            $(conf.SELECTOR_TEMPLATE_DROPPABLE).bind('contextmenu', function(e){
                e.preventDefault();
            });

        }

    }
});