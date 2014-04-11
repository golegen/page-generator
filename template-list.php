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
                <h2 id="sysTitle"><a href="page-list.php?act=list" id="btn_back" class="back"></a></h2>
                <script id="sysTitleTemplate" type="text/x-jquery-tmpl">
                    <span>${title}</span>
                </script>
            </div>
        </div>
        <ul class="list list_ico">
            <li class="item item_add"><a id="btn_add_template" href="./template-edit.php?act=insert"><span class="ico_add">+</span><span class="name_cn">新建模板</span></a></li>
            <span id="templateList"></span>
        </ul>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script id="templateListTemplate" type="text/x-jquery-tmpl">
<li>
    <a href="template-edit.php?tmp_id=${tmp_id}&ch_id=${tmp_channel}&act=update">
        <span class="thumb"><img src="${tmp_thumbnail}" alt="${tmp_name}" style="max-height:105px;max-width:198px"></span>
        <span class="name_cn">${tmp_name}</span>
    </a>
    <span class="opt_wrap"><i data-id="${tmp_id}" class="ico_delete" title="删除"></i><i data-url="template-edit.php?tmp_id=${tmp_id}&ch_id=${tmp_channel}&act=update" class="ico_edit" title="编辑"></i></span>
</li>
</script>

<script>
require(["page/template-list"], function(template_list) {
    $(function() {
        template_list.init();
    });
});
</script>
</body>
</html>