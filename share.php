<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Page Generator</title>
<?php include("inc/inc-timestamp.php") ?>
<script type="text/javascript" src="http://top.oa.com/js/tcc.js"></script>
</head>
<body>
<?php include("inc/inc-nav.php"); ?>
<!--S 内容 -->
<div class="wrapper">
    <div class="main">
        <div class="main_hd">
            <div class="page_title">
                <h2><a href="channel-list.php?act=list" id="btn_back" class="back"></a><span>邮件分享</span></h2>
            </div>  
        </div>
        <div class="frm_metro frm_share">
            <form onsubmit="return false;">
                <p><label for="">收件人</label>
                    <script>new Tcc.UserChooser({id: 'mail_addressee', name: 'mail_addressee', choosertype:1 , inputType: 1, user_chooser_class :'txt_metro'});</script></p>
                <p><label for="">抄送人</label>
                    <script>new Tcc.UserChooser({id: 'mail_cc', name: 'mail_addressee', choosertype:1 , inputType: 1, user_chooser_class :'txt_metro'});</script></p>
                <p><label for="">主  题</label><input class="txt_metro" type="text" placeholder="【前端开发待确认】" id="mail_topic"></p>    
                <p><label for="">页面截图</label></p>      
                <p class="frm_buttons"><button class="btn_submit" id="btn_channel_save">发 送</button><button type="reset" class="btn_normal" href="./template-list.php?act=list">重 置</button></p>
            </form>
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