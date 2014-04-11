<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Page Generator</title>
<?php include("inc/inc-timestamp.php") ?>
</head>
<body class="page_index">
<?php include("inc/inc-nav.php"); ?>
<!--S 内容 -->
<div class="wrapper">
  <div class="main">
      <div class="page_title"><h2>请选择您的产品或项目</h2></div>
        <ul class="list list_project" id="channelList">
            <li class="item item_add h" id="addChannel"><a href="channel-edit.php?act=insert"><span class="ico_add">+</span><span class="name_cn">添加新项目</span></a></li>
        </ul>
    </div>
</div>
<!--E 内容 -->
<?php include("inc/inc-footer.php"); ?>

<script id="channelListTemplate" type="text/x-jquery-tmpl">
<li>
  <a href="page-list.php?ch_id=${ch_id}&ch_name=${ch_name}">
    <span class="name_en">${ch_ename}</span>
    <span class="name_cn">${ch_name}</span>
  </a>
  <span class="opt_wrap"><i class="ico_delete" data-id="${ch_id}"></i><i class="ico_edit" data-id="${ch_id}"></i></span>
</li>
</script>
<script type="text/javascript">
/* 频道列表页面初始化 */
require(["page/channel-list"], function(channel_list) {
    $(function() {
        channel_list.init();
    });
});
</script>
</body>
</html>