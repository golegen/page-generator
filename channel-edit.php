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
        </div>
        <div class="frm_metro frm_channel">
            <form onsubmit="return false;">
                <p><label for="ch_name">频道名称</label><input class="txt_metro" type="text" placeholder="" id="ch_name"></p>
                <p><label for="ch_ename">频道英文</label><input class="txt_metro" type="text" placeholder="" id="ch_ename"></p>
                <p><label for="ch_path">外网路径</label><input class="txt_metro" type="text" placeholder="http://" id="ch_path"></p>
                <p><label for="ch_sort">显示排序</label><input class="txt_metro" type="number" value="1" placeholder="" id="ch_sort"></p>
                <p><label for="ch_sort">公用样式</label><textarea spellcheck="false" class="txt_metro" type="text" placeholder="支持引入多个样式，以英文半角分号（;）分隔，可换行书写" id="ch_css"></textarea></p>
                <p><label for="paste">缩略图</label><input id="btn_upload" type="file" style="display:none;"></p>
                <p><img id="ch_thumbnail" width="286" style="display:none;border:1px solid #558CDA;"></p>
                <p class="frm_buttons"><button class="btn_submit" id="btn_channel_save">提 交</button><button type="reset" class="btn_normal" href="./template-list.php?act=list">重 置</button></p>
            </form>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script>
require(["page/channel-edit"], function(channel_edit) {
    $(function() {
        channel_edit.init();
    });
});
</script>
</body>
</html>