<?php
	if(!isset($_COOKIE['pg_uname'])) header('Location: ./oa_login.php');
	else header('Location: ./channel-list.php');
?>