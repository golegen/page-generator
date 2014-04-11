<?php
ob_start();

$out_url = 'http://passport.oa.com/modules/passport/signout.ashx';
$LPATH = "http://".$_SERVER["HTTP_HOST"];        //主机名
$dirname=dirname($_SERVER["REQUEST_URI"]);
if($dirname!= "/") $LPATH .= $dirname;         //路径
$myurl = $LPATH."/oa_login.php";

$title = 'Page Generator';
$post_url = "$out_url?url=".urlencode($myurl)."&title=".urlencode($title);

setcookie('pg_uname',NULL,0,"/");
header("Location: $post_url");

ob_end_flush();
?>