<?php
function getPage($id){
	$sql="select * from tb_page join tb_template on page_tmp=tmp_id where page_state = 1 and page_id=".$id;
	$res=mysql_query($sql);
	if($obj=mysql_fetch_object($res)){
		$obj->page_source=str_replace('${content}', $obj->page_data, $obj->tmp_html);
		return $obj;
	}
	else return 0;
}

function u2utf8($str){
	return preg_replace("/\\\u([\da-f]{4})/ie", 'iconv("UCS-2BE","utf-8",pack("H4","\\1"))', $str);
}

/* html代码过滤 */
function html_filter($html_source){
    if($html_source != ''){
        /* 去掉 data-pg, data-id */
        $regex = '/\s?data-(pg|id)="\w{2,15}"\s?/i';
        return preg_replace($regex, '', $html_source);
    }
    return 'No Input';
}

function syspath(){
	$S=explode("/",$_SERVER['PHP_SELF']);
    $path=$_SERVER['DOCUMENT_ROOT']."/{$S[1]}";
    return $path;
}
function webpath(){
	$S=explode("/",$_SERVER['PHP_SELF']);
	return "http://".$_SERVER['HTTP_HOST']."/{$S[1]}";
}
?>