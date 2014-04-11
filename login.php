<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Page Generator - 模块管理</title>
    <?php
    include("inc/inc-timestamp.php");
    if(isset($_COOKIE["pg_uname"])){
        header('Location: ./channel-list.php');
    }
    ?>
</head>
<body>
<div style="padding: 200px 100px">
    先将就一下吧哈，输入你的rtx账号就能登陆，kaiye，williamsli，laserji，howelin几个账号有高级权限
    <br>
    <input type="text" id="username">
    <button type="button" id="submit">登陆</button>
</div>

</body>
<script type="text/javascript">
    require(["jquery", "module/conf", "module/user"], function($, conf, user) {
        $(function() {
            $('#submit').click(function(){
                if($.trim($('#username').val()) != ''){
                    user.login($('#username').val());
                }else{
                    alert('不能空啊哥')
                }
            });
            $('#username').keyup(function(e){
                if(e.which == 13){
                    if($.trim($('#username').val()) != ''){
                        user.login($('#username').val());
                    }else{
                        alert('不能空啊哥')
                    }
                }
            })
        });
    });
</script>
</html>