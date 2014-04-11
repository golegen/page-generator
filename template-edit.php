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
                <h2 id="sysTitle"><a href="template-list.php?act=list" id="btn_back" class="back"></a></h2>
                <script id="sysTitleTemplate" type="text/x-jquery-tmpl">
                    <span>${title}</span>
                </script>
            </div>
        </div>
        <div class="frm_metro frm_template">
            <form onsubmit="return false;">
                <div class="frm_left">
                    <p><label for="tmp_name">模板名称</label><input class="txt_metro" type="text" placeholder="中文名称" id="tmp_name"></p>
                    <p><label for="tmp_desc">模板描述</label><input class="txt_metro" type="text" placeholder="简要的描述信息" id="tmp_desc"></p>
                    <p><label for="paste">缩略图</label><input class="txt_metro"  type="text" id="paste" placeholder="页面截图粘贴至此"></p>
                    <p><img id="tmp_thumbnail" style="max-width:286px;display:none;border:1px solid #558CDA;"></p>
                    <p class="frm_buttons"><button class="btn_submit" id="btn_template_save">保 存</button><button type="reset" class="btn_normal" href="./template-list.php?act=list">重 置</button></p>
                </div>
                <div class="frm_right">
                    <p><label for="tmp_html">模板HTML（保存时自动引入下方模板CSS代码）</label><textarea class="txt_metro" placeholder="<!DOCTYPE html>" value="" autofocus="" id="tmp_html"></textarea></p>
                    <p><label for="tmp_css">模板CSS（保存时自动嵌入上方模板HTML中）</label><textarea id="tmp_css" class="txt_metro" placeholder='模板默认引入样式，支持link或style形式'></textarea></p>
                    
                </div>
            </form>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script>
require(["page/template-edit"], function(template_edit) {
    $(function() {
        template_edit.init();
    });
});
</script>
</body>
</html>