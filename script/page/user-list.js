/**
 * @desc: 用户列表页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2013-01-28
 */

define(['jquery', '../module/util', '../module/user', '../module/ui'], function($, util, user){
    return {

        /* 初始化 */
        init: function(){

            function sortableInit(){
                $('.userlist_wrap ul').sortable({
                    helper: "clone",
                    connectWith: '.userlist_wrap ul',
                    revert: true,
                    delay: 150,
                    forcePlaceholderSize: true,
                    receive: function(event, ui){
                        var user_id = ui.item.attr('data-id'),
                            user_power = ui.item.attr('data-power');

                        if(user_power == '1'){
                            user.setUserPower(user_id, '2', function(){
                                ui.item.attr('data-power', '2');
                                util.message('已设置为管理员');
                            });
                        }else if(user_power == '2'){
                            user.setUserPower(user_id, '1', function(){
                                ui.item.attr('data-power', '1');
                                util.message('已打回普通用户');
                            });
                        }
                    }

                }).disableSelection();
            }

            user.listCommonUser('#commonUserListTemplate', '#commonUserList', function(){
                sortableInit();
            });
            user.listAdminUser('#adminUserListTemplate', '#adminUserList', function(){
                sortableInit();
            });
        }
    }
});