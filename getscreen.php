<?php
if(isset($_GET["ch"]) && isset($_GET["page"])){
	$ch=$_GET["ch"];
	$page=$_GET["page"];
	echo shell_exec("./phantomjs ./script/page/getscreen.js $ch $page");
}
?>