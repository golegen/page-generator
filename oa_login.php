<?php
ob_start();
require_once 'inc/TOF_Client.class.php';
$tof = new TOF_Client();
$english_name = $tof->getUser();

$LPATH = "http://".$_SERVER["HTTP_HOST"];        //主机名
$dirname=dirname($_SERVER["REQUEST_URI"]);
if($dirname!= "/") $LPATH .= $dirname;         //路径

if(isset($english_name)){
	$last_url =  $LPATH ."/channel-list.php";
	if(isset($_COOKIE['last_login_page'])){
		$last_url = $_COOKIE['last_login_page'];
	}
	header("location: ".$last_url);
	exit();
}

ob_end_flush();
?>