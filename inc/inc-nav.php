<?php
// 检验登录状态
if(!isset($_COOKIE['pg_uname'])) header('Location: ./oa_login.php');
$LPATH = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];   
setcookie("last_login_page",$LPATH,time()+3600*24*5,"/");
?>
<!--S 头部 -->
<header>
<div class="pg_header">
    <div class="pg_header_bd cf">
        <h1 class="pg_logo"><a href="./"><i class="logo"></i><i class="title"></i><span class="mask_layer"><i class="mask"></i></span></a></h1>
        <div class="pg_header_r">
            <div id="user_info" class="user_wrap"></div>
            <!-- 用户信息模板 -->
            <script id="userInfoTemplate" type="text/x-jquery-tmpl">
                <img id="avatar" src="${avatar}" alt="user" />
                <span id="login" style="cursor:pointer">${username}</span>
                <span id="logout" style="cursor:pointer">退出</span>
            </script>
            <ul class="nav">
                <li><a href="users.php">用户管理</a></li><li><a id="admin" href="about.php">系统概述</a></li>
            </ul>
        </div>
        <i class="shadow_bg"></i>
    </div>
</div>
</header>
<!--E 头部 -->

