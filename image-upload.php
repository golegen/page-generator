<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Page Generator</title>
    <?php include("inc/inc-timestamp.php") ?>
    <style>
    #btn_upload{float:none;}
      #btn_upload-queue{display: none;}
    </style>
</head>
<body>
<?php include("inc/inc-nav.php"); ?>


<div class="pb_container" style="padding-top:80px;">

<div style="padding:20px;">
<input id="btn_upload" type="file">
</div>
<div style="margin:20px;">
    <img id="previewImage" src="" alt="" style="max-width:400px;max-height:400px;">
    <br>
    <input id="imageUrl" type="" style="display:none;width:400px;margin-top:20px;">
</div>

<?php
if($handle = opendir('uploads')){
echo "已有文件:<br>";
while (false !== ($file = readdir($handle))){
echo "<ul>";
echo "<li><a href='./uploads/$file' target='_blank'>$file</a></li>";
echo "</ul>";
}
closedir($handle);
}
?>
<script type="text/javascript" src="script/helper/uploadify.js"></script>
<script type="text/javascript">
    $('#btn_upload').uploadify({
        'formData' : {'path': 'temp'},
        'swf'      : 'script/uploadify.swf',
        'uploader' : 'inc/uploadify.php',
        'onUploadComplete' : function(file) {
            $('#previewImage').show().attr('src', './uploads/temp/'+ file.name);
            $('#imageUrl').show().val('./uploads/temp/'+ file.name);
        }
    });
</script>
</div>
</body>
</html>