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
                <h2 id="sysTitle"><a href="channel-list.php?act=list" id="btn_back" class="back"></a></h2>
                <script id="sysTitleTemplate" type="text/x-jquery-tmpl">
                    <span>${title}</span>
                </script>
            </div>
            <div class="search_wrap"><input type="text" class="input_txt" /><i class="ico_search"></i></div>
        </div>
        <ul class="list list_ico">
            <li class="item item_add"><a id="btn_add_page" href="./page-edit.php?act=insert"><span class="ico_add">+</span><span class="name_cn">新建页面</span></a></li>
            <li class="item item_page h" id="templateListWrap"><a id="templateList" href="template-list.php?act=list"><span class="inner"><span class="ico_template"></span><span class="name_cn">模板列表</span></span></a></li>
            <li class="item item_page"><a id="moduleList" href="module-list.php?act=list"><span class="inner"><span class="ico_page"></span><span class="name_cn">组件列表</span></span></a></li>
        </ul>
        <ul id="pageList" class="list list_page">
        </ul>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<!-- S 浮层 -->
<div id="pg_dialog" style="display:none">
    <div class="pg_dialog_mask"></div>
    <div class="pg_dialog_cont">
        <div class="pg_dialog_close">&times</div>
        <iframe src="" frameborder="0" scrolling="auto"></iframe>
        <div class="pg_dialog_opt">
            <p><button class="btn_submit" id="btn_share" >邮件分享</button></p>
            <p><button class="btn_submit" id="btn_download">打包下载</button></p>
            <p><button class="btn_normal" id="btn_edit">再次编辑</button></p>
        </div>
    </div>
</div>
<!-- E 浮层 -->

<script id="pageListTemplate" type="text/x-jquery-tmpl">
<li><a href="workshop.php?act=preview&ch_id=${page_channel}&page_id=${page_id}" data-id="${page_id}" data-channel="${page_channel}" target="_blank" title="${page_title}"><span class="thumb"><img src="img/icon_page.png" alt="${page_title}" /></span><span class="name_cn">${page_title}</span></a><span class="opt_wrap"><i data-id="${page_id}" class="ico_delete" title="删除"></i><i data-id="${page_id}" class="ico_edit" title="编辑"></i></span></li>
</script>
<script>
require(["page/page-list"], function(page_list) {
    $(function() {
        page_list.init();
    });
});
</script>
</body>
</html>