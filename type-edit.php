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
                <h2 id="sysTitle"><a href="module-list.php?act=list" id="btn_back" class="back"></a></h2>
                <script id="sysTitleTemplate" type="text/x-jquery-tmpl">
                    <span>${title}</span>
                </script>
            </div>
        </div>
        <div class="frm_type">
            <div class="add_type">
                <input  type="text" class="txt_metro" id="type_name" placeholder="分类名称"/><button class="btn_submit" id="btn_add_type">添加分类</button>
            </div>
            <div class="typelist">
                <h3 class="title">已有分类</h3>
                <ul id="typeList"></ul>
                <script id="typeTemplate" type="text/x-jquery-tmpl">
                    <li>
                        ${type_name}
                        <span class="del" data-id="${type_id}" data-count="${type_count}">&times</span>
                        <span class="count">(${type_count})</span>
                    </li>
                </script>
            </div>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>

<script>
require(["page/type-edit"], function(type_edit) {
    $(function() {
        type_edit.init();
    });
});
</script>
</body>
</html>