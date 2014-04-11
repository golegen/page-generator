<?php
include_once("zip.class.php");

if(isset($_GET["dir"]) && isset($_GET["file"]))
{
	$dir=$_GET["dir"];
	$file=$_GET["file"];
	$zip = new Zip();
	$zip->setComment("Page Generator Zip file.\nCreated on " . date('l jS \of F Y h:i:s A'));
	$zip->addDirectoryContent($dir,$file);
	$zip->sendZip("$file.zip");
}

?>