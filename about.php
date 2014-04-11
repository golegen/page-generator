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
                <h2><a href="channel-list.php?act=list" id="btn_back" class="back"></a><span>系统概述</span></h2>
            </div>  
        </div>
        <div class="frm_metro">
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
            <p>这是一个小系统</p>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script>
require(["page/page-list"], function(page_list) {
    $(function() {
    });
});
</script>
</body>
</html>