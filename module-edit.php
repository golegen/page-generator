<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Page Generator - 模块管理</title>
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
        <div class="frm_metro frm_mod">
            <form onsubmit="return false;"  id="modPanel">

            </form>
            <!-- 组件编辑模板 -->
            <script id="modEditTemplate" type="text/x-jquery-tmpl">
                <div class="frm_left">
                    <p><label for="mod_name">组件名称</label><input id="mod_name" type="text" autofocus class="txt_metro" value="${mod_name}"/></p>
                    <p><label for="typeSelect">组件类型</label><select id="typeSelect"></select></p>
                    <p id="radioModTypeWrap">
                        <label for="">组件属性</label>
                        <label class="frm_radio">
                            <input type="radio" name="mod_type" checked value="0">
                            <span>私有</span>
                        </label>
                        <label class="frm_radio">
                            <input type="radio" name="mod_type" value="1">
                            <span>公共</span>
                        </label>
                    </p>
                    <p><label for="paste">缩略图</label><input  class="txt_metro" type="text" id="paste" placeholder="页面截图粘贴至此" style=""></p>
                    <p><img id="mod_thumbnail" src="${mod_thumbnail}" style="max-width:286px;display:none;border:1px solid #558CDA;"></p>
                    <p class="frm_buttons">
                        <button id="btn_mod_save" class="btn_submit">保存</button>
                        <button id="btn_mod_preview" class="btn_normal">预览</button>
                        <a class="btn_mod_delete" href="#" title="慎用">删除组件</a>
                    </p>
                </div>
                <div class="frm_right">
                    <p><label for="paste">组件HTML</label><textarea id="mod_html" class="txt_metro">${mod_html}</textarea></p>
                    <p><label for="paste">组件样式</label><textarea id="mod_css" class="txt_metro">${mod_css}</textarea></p>
                    <p class="preview_wrap"><iframe id="preview" frameborder="0" scrolling="no" width="680" height="0"></iframe></p>
                </div>
                <input id="ch_css" type="hidden" name="" value="${ch_css}">
            </script>
            <!-- 组件预览模板 -->
            <script id="modViewTemplate" type="text/x-jquery-tmpl">
                <div class="frm_left">
                    <p><label for="mod_name">组件名称</label><span>${mod_name}</span></p>
                    <p><label for="typeSelect">组件类型</label><span>${mod_type}</span></p>
                    <p>
                        <label for="">组件属性</label>
                        <span>${mod_ispublic}</span>
                    </p>
                    <p><label for="paste">缩略图</label><img id="mod_thumbnail" src="${mod_thumbnail}" style="max-width:286px;display:none;border:1px solid #558CDA;"></p>
                </div>
                <div class="frm_right">
                    <p><label for="paste">组件HTML</label><textarea id="mod_html" class="txt_metro">${mod_html}</textarea></p>
                    <p><label for="paste">组件样式</label><textarea id="mod_css" class="txt_metro">${mod_css}</textarea></p>
                    <p class="preview_wrap"><iframe id="preview" frameborder="0" scrolling="no" width="680" height="0"></iframe></p>
                </div>
            </script>
        </div>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>
<script type="text/javascript">
/* 模块编辑页面初始化 */
require(["page/module-edit"], function(module_edit) {
    $(function() {
        module_edit.init();
    });
});
</script>
</body>
</html>