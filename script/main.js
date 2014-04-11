/**
 * @desc: 全站主文件，用于全局初始化操作
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-12-10
 */

/* 检查登录 */
require(["module/conf", "module/util", "module/user","module/tmpl", "module/cookie"], function(conf, util, user) {
    $(function() {
        /* 设置系统面包屑 */
        $('#sysTitle').ready(function(){
            $.getJSON(conf.API+'?act=getChannelById&id='+util.param('ch_id'), function(data){
                $.template('sysTitleTemplate', $('#sysTitleTemplate').html());
                $.tmpl('sysTitleTemplate', {
                    title: data.data.value.ch_name
                }).appendTo('#sysTitle');
            });
        });

        /* 显示用户信息（若已登录）*/
        user.showUserInfo('#userInfoTemplate', '#user_info', function(){

            $('#logout').click(function(){
                if(user.isLogin && window.confirm('确定要退出？')){
                    user.logout();
                }
            });

            $('#admin').click(function(e){
                e.preventDefault();
                if(user.isAdmin){
                    alert('您拥有至高无上的权限！');
                }else{
                    alert('对不起，你没有高级权限:(');
                }
            });
        });
    });
});





