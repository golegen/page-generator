/**
 * @desc: 各种属性面板
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-12-18
 */

define(['jquery', '../module/conf', '../module/util', '../module/editor','../module/tmpl', '../module/ui'], function($, conf, util, editor){

    /* 面板位置 */
    var _panelTop,
        _panelLeft,
        _closeCallback,
        _saveCallback,
        _curMdStored;

    /* 保存原始未操作的组件 */
    var history = (function(){
        var _set = function(md){
            md = md || $.curMd;
            _curMdStored = md.clone(true);
        };

        var _get = function(){
            if(_curMdStored !== undefined){
                return _curMdStored;
            }
        };

        var _restore = function(md){
            md = md || $.curMd;
            if(_curMdStored){
                md.replaceWith(_curMdStored);
            }
        };

        return {
            set: _set, // 保存当前模块
            get: _get, // 获取当前记录
            restore: _restore // 恢复当前操作模块
        }
    })();

    /* 根据模板初始化属性面板 */
    var initPanel = function(templateName, callback){

        if($.isAttrPanelOpen){
            $('.pg_popup').remove();
        }else{
            $.isAttrPanelOpen = true;
            history.set($.curMd);
        }

        /* 打开面板则不能排序 */
        $.layout.sortable("disable").enableSelection();
        $.isMdSortable = false;

        $.template(templateName, $('#'+templateName).html());
        $.tmpl(templateName).appendTo('body');

        $('.pg_popup').ready(function(){

            /* 调整浮层位置及拖动样式 */
            $('.pg_popup').css('top', _panelTop)
                .css('left', _panelLeft)
                .draggable({
                    handle: "h3",
                    start: function(){
                        $(conf.SELECTOR_TEMPLATE_DROPPABLE).droppable({ hoverClass: "false" });
                        $(conf.SELECTOR_MOD_DROPPABLE).droppable({ hoverClass: "false" });
                    },
                    stop: function(){
                        $(conf.SELECTOR_TEMPLATE_DROPPABLE).droppable({ hoverClass: "drop-hover" })
                            .droppable('option', 'hoverClass', 'layout_highlight');
                        $(conf.SELECTOR_MOD_DROPPABLE).droppable({ hoverClass: "drop-hover" })
                            .droppable('option', 'hoverClass', 'md_highlight');
                    }
                }).click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                }).bind('contextmenu', function(e){
                    /* 禁止浮层上再点击右键 */
                    e.preventDefault();
                    e.stopPropagation();
                });

            /* 关闭浮层 */
            $('.pg_popup .close, .pg_popup .cancel').click(function(){
                /* 关闭并恢复组件初始状态 */
                close(true);
            });

            /* 确认并关闭 */
            $('.pg_popup .btn_submit').click(function(){
                if(_saveCallback && typeof _saveCallback === 'function'){
                    _saveCallback($('.pg_popup'));
                }
                close();
            });

            /* ESC 关闭 */
            $(document).keyup(function(e){
                if(e.which === 27){
                    close();
                }
            });

            if(callback && typeof callback === 'function'){
                callback();
            }
        });
    };

    /* 关闭面板 */
    var close = function(isRestore){
        if(_closeCallback && typeof _closeCallback === 'function'){
            _closeCallback($('.pg_popup'));
        }

        $('.pg_popup').addClass('pg_popup_hide');
        setTimeout(function(){
            $('.pg_popup').remove();
        }, 500);

        if($.curMd){
            $.curMd.removeAttr('contentEditable');
        }

        /* 关闭面板后才可以对组件进行排序 */
        $.layout.sortable("enable").disableSelection();
        $.isMdSortable = true;
        $.isAttrPanelOpen = false;

        /* 关闭时是否恢复 */
        if(isRestore){
            history.restore($.curMd);
        }
    };

    /* 默认操作 */
    var defaultOpt = function(e){
        $('.fontoption').hide();
        e.stopPropagation();
    };

    var panelMessage = function(msg){
        $('#panelMessage').html(msg).show().delay(4000).slideUp(500);
    };

    /* 文本操作 */
    var textEditBind = function(){

        /* 加粗 */
        $('.pg_popup .bold').mousedown(function(e){
            defaultOpt(e);

            if($(this).attr('data-range') != 'partial'){
                /* 链接和段落默认直接设置整体样式 */
                $.curMd.css('font-weight') === 'bold' ?
                    $.curMd.css('font-weight', 'normal') :
                        $.curMd.css('font-weight', 'bold');
            }else{
                editor.bold();
            }
        });

        /* 下划线 */
        $('.pg_popup .underline').mousedown(function(e){
            defaultOpt(e);

            if($(this).attr('data-range') != 'partial'){
                /* 链接和段落默认直接设置整体样式 */
                $.curMd.css('text-decoration') === 'underline' ?
                    $.curMd.css('text-decoration', 'none') :
                        $.curMd.css('text-decoration', 'underline');
            }else{
                editor.underline();
            }
        });

        /* 字体 */
        $('.pg_popup .fontname').mousedown(function(e){
            defaultOpt(e);

            $('#fontname').hide();
            var that = $(this);

            if($(this).attr('data-range') === 'partial'){
                $('#fontname').show().css('top','170px');
            }else{
                $('#fontname').show().css('top','102px');
            }

            $('#fontname li').unbind('mousedown').mousedown(function(e){
                if(that.attr('data-range') === 'partial'){
                    var text = editor.edit.getSelectedText();
                    if($.trim(text) !== ''){
                        /* 应用多个样式 */
                        if($('[data-pg="cur_edit"]')[0]){
                            $('[data-pg="cur_edit"]').css('font-family', $(this).text());
                        }else{
                            editor.insertHTML('<span data-pg="cur_edit" style="font-family:'+$(this).text()+'">'+text+'</span>');
                        }

                        /* 保持新增节点的选中状态 */
                        var span = $('[data-pg="cur_edit"]')[0];
                        if(span){
                            var range = window.getSelection().getRangeAt(0);
                            range.setStart(span, 0);
                            window.getSelection().addRange(range);
                        }
                        /* 单击组件时删除属性 */
                        $.curMd.click(function(){
                            $('[data-pg="cur_edit"]').removeAttr('data-pg');
                        });
                    }
                }else{
                    $.curMd.css('font-family', $(this).text());
                }
                $('#fontname').hide();
                e.stopPropagation();
            });
        });

        /* 字号 */
        $('.pg_popup .fontsize').mousedown(function(e){
            defaultOpt(e);

            $('#fontsize').hide();
            var that = $(this);

            if($(this).attr('data-range') === 'partial'){
                $('#fontsize').show().css('top','170px');
            }else{
                $('#fontsize').show().css('top','102px');
            }

            $('#fontsize li').unbind('mousedown').mousedown(function(e){
                var text = editor.edit.getSelectedText();

                if(that.attr('data-range') === 'partial'){
                    if($.trim(text) !== ''){
                        /* 应用多个样式 */
                        if($('[data-pg="cur_edit"]')[0]){
                            $('[data-pg="cur_edit"]').css('font-size', $(this).text()+'px');
                        }else{
                            editor.insertHTML('<span data-pg="cur_edit" style="font-size:'+$(this).text()+'px">'+text+'</span>');
                        }

                        /* 保持新增节点的选中状态 */
                        var span = $('[data-pg="cur_edit"]')[0];
                        if(span){
                            var range = window.getSelection().getRangeAt(0);
                            range.setStart(span, 0);
                            window.getSelection().addRange(range);
                        }
                        /* 单击组件时删除属性 */
                        $.curMd.click(function(){
                            $('[data-pg="cur_edit"]').removeAttr('data-pg');
                        });
                    }
                }else{
                    $.curMd.css('font-size', $(this).text()+'px');
                }
                $('#fontsize').hide();
                e.stopPropagation();
            });
        });

        /* 颜色 */
        $('.pg_popup .fgcolor').mousedown(function(e){
            defaultOpt(e);

            $('#fgcolor').hide();
            var that = $(this);

            if($(this).attr('data-range') === 'partial'){
                $('#fgcolor').show().css('top','170px');
            }else{
                $('#fgcolor').show().css('top','102px');
            }

            $('#fgcolor li').unbind('mousedown').mousedown(function(e){
                var text = editor.edit.getSelectedText();

                if(that.attr('data-range') === 'partial'){
                    if($.trim(text) !== ''){
                        /* 应用多个样式 */
                        if($('[data-pg="cur_edit"]')[0]){
                            $('[data-pg="cur_edit"]').css('color', $(this).attr('data-color'));
                        }else{
                            editor.insertHTML('<span data-pg="cur_edit" style="color:'+$(this).attr('data-color')+'">'+text+'</span>');
                        }

                        /* 保持新增节点的选中状态 */
                        var span = $('[data-pg="cur_edit"]')[0];
                        if(span){
                            var range = window.getSelection().getRangeAt(0);
                            range.setStart(span, 0);
                            window.getSelection().addRange(range);
                        }
                        /* 单击组件时删除属性 */
                        $.curMd.click(function(){
                            $('[data-pg="cur_edit"]').removeAttr('data-pg');
                            e.stopPropagation();
                        });
                    }
                }else{
                    $.curMd.css('color', $(this).attr('data-color'));
                }
                $('#fgcolor').hide();
                e.stopPropagation();
            });
        });

        /* 对齐 */
        $('.pg_popup .justifyleft, .pg_popup .justifycenter, .pg_popup .justifyright').mousedown(function(e){
            defaultOpt(e);
            var alignType = $(this).attr('class').replace('justify','');
            $.curMd.css('text-align', alignType);
        });

        /* 添加链接 */
        $('.pg_popup .insertlink').mousedown(function(e){
            defaultOpt(e);
            editor.createLink();
        });
    };

    return {
        /* 判断是否具有自定义功能 */
        hasPanel: function(){
            for(var i = 0, j = conf.ATTR_VALUE_MOD_TYPE_ARRAY.length; i<j; i++){
                if(conf.ATTR_VALUE_MOD_TYPE_ARRAY[i] === $.curMd.attr(conf.ATTR_MOD_TYPE)){
                    return true;
                }
            }
            return false;
        },

        /* 初始化 */
        init: function(option){

            option = option || {};
            option.trigger = option.trigger || $.curMd;
            option.top = option.top || 200;
            option.left = option.left || 500;

            /* 避免底部超出屏幕 */
            var maxTop = $(window).height() - 300;
            if(option.top >= maxTop){
                option.top = maxTop;
            }else{
                option.top = option.top - 100; // 约面板2/3高度
            }

            _panelTop = option.top;
            _panelLeft = option.left + 20;
            _closeCallback = null;
            _saveCallback = null;

            /* 段落 */
            if($.curMd.attr(conf.ATTR_MOD_TYPE) === conf.ATTR_VALUE_MOD_TYPE_TEXT){
                initPanel('panelTextTemplate', function(){
                    /* 文本操作区域 */
                    textEditBind();
                });
            }

            /* 图片 */
            if($.curMd.attr(conf.ATTR_MOD_TYPE) === conf.ATTR_VALUE_MOD_TYPE_IMAGE){
                initPanel('panelImageTemplate', function(){
                    var image = $.curMd.find('img');
                    $('#picSrc').val(image.attr('src'));
                    $('#linkURL').val($.curMd.attr('href'));

                    if(image.css('display') === 'block' || $.curMd.css('display') === 'block'){
                        $('#block').attr('checked', 'checked');
                    }else{
                        $('#inline').attr('checked', 'checked');
                    }

                    $('.frm_radio input:radio').click(function(e){
                        $.curMd.css('display', $(this).attr('id'));
                        image.css('display', $(this).attr('id'));
                        e.stopPropagation();
                    });

                    $('#picWidth').val(image.width()).bind('click keyup', function(){
                        image.width($(this).val())
                    });
                    $('#picHeight').val(image.height()).bind('click keyup', function(){
                        image.height($(this).val())
                    });
                    _saveCallback = function(){
                        $.curMd.attr('href', $('#linkURL').val());
                        image.attr('src', $('#picSrc').val());
                    };
                });
            }

            /* 链接 */
            if($.curMd.attr(conf.ATTR_MOD_TYPE) === conf.ATTR_VALUE_MOD_TYPE_LINK){
                initPanel('panelLinkTemplate', function(){
                    /* 文本操作区域 */
                    textEditBind();

                    $('#linkText').val($.curMd.text()).keyup(function(){
                        $.curMd.text($(this).val()).attr('title',$(this).val());
                    });
                    $('#linkURL').val($.curMd.attr('href')).keyup(function(){
                        $.curMd.attr('href', $(this).val());
                    });

                    $.curMd.attr('target') === '_blank' ?
                        $('#blank').attr('checked', 'checked'):
                            $('#self').attr('checked', 'checked');

                    $('#blank').click(function(){
                        $.curMd.attr('target', '_blank');
                    });
                    $('#self').click(function(){
                        $.curMd.attr('target', '_self');
                    });
                });
            }

            /* 表格 */
            if($.curMd.attr(conf.ATTR_MOD_TYPE) === conf.ATTR_VALUE_MOD_TYPE_TABLE){
                initPanel('panelTableTemplate', function(){
                    /* 文本操作区域 */
                    textEditBind();

                    var table = $.curMd[0].tagName == 'TABLE' ? $.curMd : $.curMd.find('table'),
                        curRow, curCell, curCellColIndex, curGridColIndex, curCellRowIndex, curGridRowIndex;

                    /* 当前选中单元格初始化 */
                    function selectCell(cell){

                        /* reset */
                        curCellColIndex = -1;
                        curGridColIndex = -1;
                        curCellRowIndex = -1;
                        curGridRowIndex = -1;

                        /* 获取当前单元格 */
                        if(cell[0].tagName == 'TH' || cell[0].tagName == 'TD'){
                            curCell = cell;
                        }else if(curCell.parents('th').length > 0){
                            curCell = cell.parents('th');
                        }else if(curCell.parents('td').length > 0){
                            curCell = cell.parents('td');
                        }

                        /* 获取当前行 */
                        curRow = curCell.parents('tr');

                        /* 获取当前单元格列索引 */
                        if(curCell[0].tagName == 'TD'){
                            curCellColIndex = curRow.children().index(curCell[0]);
                        }else{
                            curCellColIndex = curRow.children().index(curCell.parents('td')[0]);
                        }

                        /* 获取当前单元格行索引，不会跨过 thead 和 tbody 计算索引 */
                        curCellRowIndex = curRow.prevAll().length;

                        /* 获取当前单元格在网格中的列索引 */
                        curCell.prevAll().each(function(){
                            if($(this).attr('colspan') != undefined){
                                curGridColIndex += ($(this).attr('colspan') - 0);
                            }else{
                                curGridColIndex++;
                            }
                        });
                        /* 加上当前单元格计数 */
                        curGridColIndex++;

                        /* 获取当前单元格在网格中的行索引，与当前单元格的行索引一致，因为含有 rowspan 的单元隶属于所跨的第一行 */
                        curGridRowIndex = curCellRowIndex;

                        /* 当前列样式 */
                        $('#tableColIndex').text(curCellColIndex+1);
                        /* 当前列含有跨列单元格时显示混乱
                        $.curMd.find('.pg_cur_col').removeClass('pg_cur_col');
                        $.curMd.find('tr').each(function(){
                            $(this).children().eq(curCellColIndex).addClass('pg_cur_col');
                        });*/

                    }
                    /* 面板初始化时执行一次 */
                    selectCell(($.curEditElement));

                    /* 点击时重新初始化单元格 */
                    $.curMd.bind('click', function(e){
                        if($.curMd){
                            selectCell($(e.target));
                        }
                    });

                    /* 行列添加删除复制 */
                    $('#addRow').click(function(){
                        var canAdd = true;
                        curRow.children().each(function(){
                           if($(this).attr('rowspan') != undefined && $(this).attr('rowspan') > 0){
                               canAdd = false;
                           }
                        });
                        if(canAdd){
                            curRow.clone().insertAfter(curRow);
                        }else{
                            panelMessage('提示：此行含有跨行单元格，不能复制');
                        }
                    });
                    $('#removeRow').click(function(){
                        var canRemove = true,
                            trs = $.curMd.find('tr');

                        curRow.children().each(function(){
                            if($(this).attr('rowspan') != undefined && $(this).attr('rowspan') > 0){
                                canRemove = false;
                            }
                        });
                        if(canRemove){
                            /* 至少保留两行两列，包含左侧有标题和顶部有标题 */
                            if(trs.length > 2){
                                curRow.remove();
                            }else{
                                panelMessage('提示：至少保留两行两列');
                            }
                        }else{
                            panelMessage('提示：此行含有跨行单元格，不能移除');
                        }
                    });

                    /* 添加和删除列时没有做跨行列判断，太特么难了 */
                    $('#addCol').click(function(){
                        var trs = $.curMd.find('tr'), td;

                        trs.each(function(){
                            td = $(this).children().eq(curCellColIndex);
                            td.clone().insertAfter(td);
                        });
                    });
                    $('#removeCol').click(function(){
                        $.curMd.find('tr').each(function(){
                            var td = $(this).children().eq(curCellColIndex);
                            if($(this).children().length > 2){
                                td.remove();
                            }
                        });
                    });

                    /* 当前列宽度设置 */
                    var unit = 'px';
                    $('#percent').click(function(){
                        unit = '%';
                        $('#tableWidth').val((curRow.children().eq(curCellColIndex).width()*100/table.width()).toFixed(2));
                        /*
                        * 切换单位时不能应用即时预览，因为计算的结果会有偏差
                        * 形成恶性循环，每次切换都变一点点，所以在切换时仅显示初始的计算值
                        * 在输入框调整时才实时预览
                        */
                    });
                    $('#pixel').click(function(){
                        unit = 'px';
                        $('#tableWidth').val(parseInt(curRow.children().eq(curCellColIndex).width(), 10));
                    });
                    $('#tableWidth').bind('click blur keyup', function(){
                        curCell.css('width', $(this).val() + unit);
                    });

                    /* 单元格合并 */
                    $('#joinRight').click(function(){
                        /* 向右合并 */
                        if(curCell){
                            var colSpan = curCell.attr('colspan') != undefined ? curCell.attr('colspan') : 1;
                            /* 每次只允许合并一个单元格 */
                            if(curCell.nextAll().length > 0){
                                curCell.attr('colspan', (colSpan - 0)+1).next().remove();

                                /* 处理当前单元格包办 rowspan 的情况 */
                                if(curCell.attr('rowspan') != undefined && (curCell.attr('rowspan') - 0) > 1){
                                    var rows = curCell.attr('rowspan') - 0;

                                    while(rows-- > 1){
                                        curRow.nextAll().eq(rows - 1).children().eq(curCellColIndex).remove();
                                    }
                                }
                            }
                        }
                    });
                    $('#joinDown').click(function(){
                        /* 向下合并 */
                        if(curCell){
                            var rowSpan = curCell.attr('rowspan') != undefined ? curCell.attr('rowspan') : 1;
                            /* 每次只允许合并一个单元格 */
                            if(curRow.nextAll().length > 0){
                                curCell.attr('rowspan', (rowSpan - 0)+1);
                                /* 当前行为未合并的第一行 */
                                curRow.nextAll().eq(rowSpan-1).children().eq(curCellColIndex).remove();

                                /* 处理当前单元格包含 colspan 的情况 */
                                if(curCell.attr('colspan') != undefined && (curCell.attr('colspan') - 0) > 1){
                                    var cols = curCell.attr('colspan') - 0;

                                    while(cols-- > 1){
                                        curRow.nextAll().eq(rowSpan-1).children().eq(curCellColIndex).remove();
                                    }
                                }
                            }
                        }
                    });

                    _saveCallback = function(){
                        curRow.removeClass('pg_cur_row');
                        $.curMd.find('tr').each(function(){
                            $(this).children().eq(curCellColIndex).removeClass('pg_cur_col');
                        });
                    };

                    _closeCallback = function(){
                        curRow.removeClass('pg_cur_row');
                        $.curMd.find('tr').each(function(){
                            $(this).children().eq(curCellColIndex).removeClass('pg_cur_col');
                        });
                    };
                });
            }

            /* 列表 */
            if($.curMd.attr(conf.ATTR_MOD_TYPE) === conf.ATTR_VALUE_MOD_TYPE_LIST){
                initPanel('panelListTemplate', function(){
                    /* 文本操作区域 */
                    textEditBind();

                    $('#addItem').click(function(){
                        var items = $.curMd.find(conf.SELECTOR_MOD_REPEATABLE),
                            item = items.eq(items.length - 1);
                        item.clone().insertAfter(item);
                    });

                    $('#removeItem').click(function(){
                        var items = $.curMd.find(conf.SELECTOR_MOD_REPEATABLE),
                            item = items.eq(items.length - 1);
                        if(items.length > 1){
                            item.remove();
                        }
                    });
                });
            }

            /* TAB */
            if($.curMd.attr(conf.ATTR_MOD_TYPE) === conf.ATTR_VALUE_MOD_TYPE_TAB){
                initPanel('panelTabTemplate', function(){
                    /* 文本操作区域 */
                    textEditBind();

                    var items = $.curMd.find(conf.SELECTOR_MOD_REPEATABLE),
                        classArray = conf.SELECTOR_MOD_REPEATABLE_CURRENT_ARRAY,
                        tabStr = '',
                        curClass = 'on';

                    if(items.length > 0){
                        items.each(function(){
                            for(var i = 0, j = classArray.length; i < j; i++){
                                if($(this).hasClass(classArray[i])){
                                    curClass = classArray[i];
                                    tabStr += '*';
                                }
                            }
                            tabStr += $.trim($(this).text()) + ' | ';
                        });
                        $('#tabContent').val(tabStr.substr(0,tabStr.length-2));
                    }

                    _saveCallback = function(){


                        var item = items.eq(0).removeClass(curClass),
                            repeatableContainer = $.curMd.find(conf.SELECTOR_MOD_REPEATABLE).parent(),
                            newTabStr = $('#tabContent').val(),
                            newTabArray;

                        if(newTabStr.substr(-1) == '|'){
                            /* 防止结尾有空项 */
                            newTabStr = newTabStr.replace(/\|*$/g,'');
                        }
                        newTabArray = newTabStr.split('|');

                        $.curMd.find(conf.SELECTOR_MOD_REPEATABLE).remove();
                        for(var i = 0, j = newTabArray.length; i<j; i++){
                            if(newTabArray[i].indexOf('*') != -1){
                                item.clone().text($.trim(newTabArray[i]).substring(1))
                                    .addClass(curClass).appendTo(repeatableContainer);
                            }else{
                                item.clone().text(newTabArray[i]).appendTo(repeatableContainer);
                            }
                        }

                    };
                });
            }
        }

    }
});