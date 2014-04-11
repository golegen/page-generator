<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Page Generator</title>
<?php include("inc/inc-timestamp.php") ?>
</head>
<body>
<?php include("inc/inc-nav.php"); ?>
<!--S 内容 -->
<div class="wrapper">
    <div class="main">
        <div class="main_hd">
            <div class="page_title">
                <h2><a href="channel-list.php?act=list" id="btn_back" class="back"></a><span>用户管理</span></h2>
            </div>  
        </div>
        <div class="frm_metro frm_userlist">
            <form onsubmit="return false;">
                <h3 class="title">管理员</h3>
                <script id="adminUserListTemplate" type="text/x-jquery-tmpl">
                    <li data-id="${user_id}" data-power="${user_power}"><a href=""><img src="http://dayu.oa.com/avatars/${english_name}/avatar.jpg" alt=""><span>${english_name}<br/>${chinese_name}</span></a></li>
                </script>
                <script id="commonUserListTemplate" type="text/x-jquery-tmpl">
                    <li data-id="${user_id}" data-power="${user_power}"><a href=""><img src="http://dayu.oa.com/avatars/${english_name}/avatar.jpg" alt=""><span>${english_name}<br/>${chinese_name}</span></a></li>
                </script>
                <div class="userlist_wrap"><!-- 对象拖进容器时，添加类 userlist_wrap_hover -->
                    <ul id="adminUserList"></ul>
                </div>   
                <h3 class="title">普通用户</h3>
                <div class="userlist_wrap">
                    <ul id="commonUserList"></ul>
                </div>
                <!--p class="frm_buttons"><button class="btn_submit" id="btn_channel_save">确 定</button></p-->
            </form>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script>
require(["page/user-list"], function(user_list) {
    $(function() {
        user_list.init();
    });
});
</script>
</body>
</html>