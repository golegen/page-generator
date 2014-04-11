<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>帮助文档 - Page Generator</title>
    <?php include("inc/inc-timestamp.php") ?>
</head>
<body>
<?php include("inc/inc-nav.php"); ?>
<div class="pb_container">
    <div class="main">
        <div class="pg_start">
            <h2 id="add_module">添加组件</h2>
            <p>
                点击顶部导航“频道列表”，找到欲添加的模块所在频道，点击频道进入，点击“新建模块”，输入 HTML，CSS 后，预览无问题后，上传截图，保存即可。
            </p>
        </div>
    </div>
</div>
<div class="footer">
    <div class="container-fluid">
        <p class="copyright">&copy; 2012 <a class="ecd" href="http://ecd.tencent.com/" target="_blank">E-Commerce User Experience Design</a> <a href="#">系统概述</a><a href="#">使用帮助</a><a target="_blank" href="http://icase.oa.com/response/contact?Dept=ecd&Name=Page Generator&Admin[0]=williamsli">意见反馈</a></p>
    </div>
</div>

<script>
    require(["page/page-list"], function(page_list) {
        $(function() {
            page_list.init();
        });
    });
</script>
</body>
</html>