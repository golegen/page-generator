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
            <div class="search_wrap"><input type="text" class="input_txt" /><i class="ico_search"></i></div>
        </div>
        <div class="frm_metro frm_page">
            <form onsubmit="return false;">
                <p><label for="page_title">页面名称</label><input type="text" class="txt_metro" placeholder="" id="page_title"></p>
                <p><label for="page_tmp">选择模板</label><select id="page_tmp"></select></p>
                <p><label for="page_keyword">页面关键字</label><input type="text" class="txt_metro" placeholder="更利于查找" id="page_keyword"></p>
                <p><label for="page_desc">页面描述</label><input type="text" class="txt_metro" placeholder="便于搜索引擎收录" id="page_desc"></p>
                <p><label for="page_directory">存放目录名</label><input type="text" class="txt_metro" placeholder="/xxx/" id="page_directory"></p>
                <p><label for="page_filename">文件名</label><input type="text" class="txt_metro" placeholder="英文字母" id="page_filename">.html</p>
                <p class="frm_buttons"><button class="btn_submit" id="btn_page_save">下一步</button></p>
                
                <!--input class="pull-right" type="text" id="paste" placeholder="图片粘贴到这里" style="width:120px;height:26px; line-height: 26px;padding:0 5px;margin-top:2px;">
                <img id="page_thumbnail" width="80" height="80" src="./img/mod.png" alt="" style="display: none;border:1px solid #666; background-color: #99B433;"-->
            </form>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script>
    require(["page/page-edit"], function(page_edit) {
        $(function() {
            page_edit.init();
        });
    });
</script>
</body>
</html>