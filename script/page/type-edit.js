/**
 * @desc: 组件分类编辑页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-23
 */

define(['jquery', '../module/util', '../module/user', '../module/type'], function($, util, user, type){
    return {

        /* 初始化 */
        init: function(){

            $('#btn_back').attr('href', $('#btn_back').attr('href')+'&ch_id='+util.param('ch_id'));

            var list_bind = function(){
                type.listByChannel(util.param('ch_id'),'#typeTemplate','#typeList', function(){
                    $('#typeList li .del').click(function(){
                        if($(this).attr('data-count') != '0'){
                            util.message('该分类下已有组件，无法删除')
                        }else{
                            var that = $(this);
                            type.remove(that.attr('data-id'), function(){
                                that.parents('li').remove();
                                util.message('删除成功！');
                            });
                        }
                    });
                });
            };
            list_bind();

            function addType(){
                type.add({
                    "type_channel": util.param('ch_id'),
                    "type_name": $('#type_name').val()
                }, function(data){
                    if($.parseJSON(data).data.value.length !== 0){
                        // 刷新列表
                        $('#type_name').val('');
                        $('#typeList').empty();
                        list_bind();
                    }
                });
            }

            $('#btn_add_type').click(function(){
                addType();
            });

            $(document).keyup(function(e){
                if(e.which == 13){
                    addType();
                }
            })
        }

    }
});