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
        <ul class="list">
            <li class="item item_add" id="newModWrap"><a href="module-edit.php?act=insert" id="newMod"><span class="ico_add">+</span><span class="name_cn">添加新组件</span></a></li>
            <li class="item item_page h" id="typeEditWrap"><a id="typeEdit" href="type-edit.php?act=update"><span class="inner"><span class="ico_category"></span><span class="name_cn">分类管理</span></span></a></li>
        </ul>
        <h3 class="title">组件列表</h3>
        <div id="classifiedList">
        </div>
    </div>

</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>

<div class="type_selector"><ul id="modSelectorListTemplate"></ul></div>

<!-- 模块选择器模板 -->
<script id="modSelectorTemplate" type="text/x-jquery-tmpl">
    <li><a href="#type_${type_id}">${type_name}</a></li>
</div>
</script>
<!-- 模块选择器模板 -->

<!-- 模块列表容器模板 -->
<script id="modListTemplate" type="text/x-jquery-tmpl">
    <div class="mod_modlue">
        <div class="mod_hd"><a href="javascript:;"><span class="cate_title">${type_name}</span><span class="show_wrap"><i></i></a></div>
        <div><ul id="${type_id}" class="list_module"></ul></div>
    </div>
</script>    
<!-- 模块列表模板 -->
<script id="modListItemTemplate" type="text/x-jquery-tmpl">
    <li>
        <a href="module-edit.php?act=update&ch_id=${ch_id}&id=${mod_id}"><span class="name_cn">${mod_name}</span><span class="thumb"><img src="${mod_thumbnail}" alt="${mod_name}" /></span></a>
      <span class="opt_wrap">
            <!--  <i data-id="${mod_id}" class="ico_delete" title="删除"></i>
          <i data-url="module-edit.php?act=update&ch_id=${ch_id}&id=${mod_id}" class="ico_edit" title="编辑"></i> -->
                    <i class="ico_copy" title="复制"><span>复制代码</span></i>
        </span>
        <textarea name="" cols="30" rows="10" class="mod_html h">${mod_html}</textarea>
    </li>
</script>
<script type="text/javascript">
/* 模块列表页面初始化 */
require(["page/module-list"], function(module_list) {
    $(function() {
        module_list.init();
    });
});
</script>
<!-- 复制按钮预加载用，尺寸与 ico_copy 相同 -->
<div id="glue"></div>
</body>
</html>