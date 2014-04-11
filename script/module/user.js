/**
 * @desc: 登录类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-12-10
 */

define(['jquery','./conf', './user', './cookie', './tmpl'], function($, conf){

    /* 暴露一个全局变量 */
    var userinfo = window.userinfo.data.value;

    return {

        /* 是否管理员 */
        isAdmin: (function(){
            return userinfo.user_power == '2';
        })(),

        /* 登录 */
        login: function(username){
            $.cookie(conf.COOKIE_USERNAME, username, {
                expires: 1  // 一天
            });
            $.cookie(conf.COOKIE_USERNAME, username, {
                expires: 1  // 一天
            });
            location.href = conf.PAGE_DEFAULT;
        },

        /* 登出 */
        logout: function(){
            location.href = conf.PAGE_LOGOUT;
        },

        /* 获取用户名 */
        getUserName: function(){
            return userinfo.english_name;
        },

        /* 显示用户信息 */
        showUserInfo: function(template/* info panel template */, appendTo/* container */, callback/* callback */){

            $.template('userInfoTemplate', $(template).html());

            $.tmpl('userInfoTemplate', {
                username: userinfo.english_name,
                avatar: 'http://dayu.oa.com/avatars/'+userinfo.english_name+'/avatar.jpg'
            }).appendTo(appendTo);

            if(callback && typeof callback === 'function'){
                callback();
            }
        },

        /* 展示高级用户选项 */
        setAsAdminOpt: function(selector){
            if(userinfo.user_power == '2'){
                $(selector).removeClass('h').show(); // just in case
            }else{
                $(selector).addClass('h').hide();
            }
        },

        /* 获取普通用户列表 */
        listCommonUser: function(commonUserListTemplate, commonUserAppendTo, callback){

            $.getJSON(conf.API+'?act=getUserList', function(data) {
                if(data.data.value.length !== 0){
                    var user_list = data.data.value;

                    // cache template
                    $.template('commonUserListTemplate', $(commonUserListTemplate).html());

                    for(var i = 0, j = user_list.length; i < j; i++){
                        $.tmpl('commonUserListTemplate',{
                            "user_id": user_list[i].user_id,
                            "login_name": user_list[i].login_name,
                            "english_name": user_list[i].english_name,
                            "chinese_name": user_list[i].chinese_name,
                            "full_name": user_list[i].full_name,
                            "gender": user_list[i].gender,
                            "group_name": user_list[i].group_name,
                            "user_power": user_list[i].user_power,
                            "user_addtime": user_list[i].user_addtime
                        }).appendTo(commonUserAppendTo);
                    }

                    if(callback && typeof callback === 'function'){
                        callback();
                    }
                }
            });
        },


        /* 获取普通用户列表 */
        listAdminUser: function(adminUserListTemplate, adminUserAppendTo, callback){

            $.getJSON(conf.API+'?act=getAdminList', function(data) {
                if(data.data.value.length !== 0){
                    var user_list = data.data.value;

                    // cache template
                    $.template('adminUserListTemplate', $(adminUserListTemplate).html());

                    for(var i = 0, j = user_list.length; i < j; i++){
                        $.tmpl('adminUserListTemplate',{
                            "user_id": user_list[i].user_id,
                            "login_name": user_list[i].login_name,
                            "english_name": user_list[i].english_name,
                            "chinese_name": user_list[i].chinese_name,
                            "full_name": user_list[i].full_name,
                            "gender": user_list[i].gender,
                            "group_name": user_list[i].group_name,
                            "user_power": user_list[i].user_power,
                            "user_addtime": user_list[i].user_addtime
                        }).appendTo(adminUserAppendTo);
                    }
                }

                if(callback && typeof callback === 'function'){
                    callback();
                }
            });
        },

        /* 设置用户权限 */
        setUserPower: function(user_id, power, callback){
            $.get(conf.API+'?act=setUserPower&userid='+user_id+'&power='+power, callback);
        }

    }
});