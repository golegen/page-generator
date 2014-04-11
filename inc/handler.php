<?php 
ob_start(); 
include_once("conn.php");
require_once 'global_func.php';
include_once("zip.class.php");

	if(!empty($_GET["act"]))
	{
		$act=$_GET["act"];
		switch($act){

			//插入数据
			case "insert":
				insert();
				break;

			//更新数据	
			case "update":
				update();
				break;

			//频道列表
			case "getChannelList":
				getChannelList();
				break;

			//单个频道
			case "getChannelById":
				getChannelById();
				break;

			//删除频道
			case "delChannelById":
				delChannelById();
				break;
				
			//根据频道获取分类列表
			case "getTypeByChannel":
				getTypeByChannel();
				break;

			//删除分类
			case "delTypeById":
				delTypeById();
				break;
				
			//初始化分类
			case "initType":
				initType();
				break;

			//布局列表
			case "getTemplateList":
				getTemplateList();
				break;

			//根据频道获取布局列表
			case "getTemplateByChannel":
				getTemplateByChannel();
				break;	

			//根据频道获取布局列表
			case "delTemplateById":
				delTemplateById();
				break;		

			//单个布局
			case "getTemplateById":
				getTemplateById();
				break;

			//根据频道获取模块		
			case "getModByChannel":
				getModByChannel();
				break;	

			//单个模块
			case "getModById":
				getModById();
				break;		

			//模块公开度
			case "getModIsPublic":
				getModIsPublic();
				break;

			//删除模块
			case "delModById":
				delModById();
				break;

			//根据频道获取页面列表
			case "getPageListByChannel":
				getPageListByChannel();
				break;

			//根据ID获取页面
			case "getPageById":
				getPageById();
				break;

			//根据用户获取页面
			case "getPageListByUser":
				getPageListByUser();
				break;

			//获取普通用户
			case "getUserList":
				getUserList();
				break;

			//获取管理员
			case "getAdminList":
				getAdminList();
				break;

			//获取单个用户信息
			case "getUserById":
				getUserById();
				break;
				
			//修改用户权限
			case "setUserPower":
				setUserPower();
				break;
				
			//删除页面
			case "delPageById":
				delPageById();
				break;

			//生成页面
			case "createPageById":
				createPageById();
				break;
		}
		mysql_close();
	}
	
	/*插入函数*/
	function insertSql($arr){
		$table = $arr["table"];
		$sql="insert ".$table;
		$col="(";
		$val=" values(";
		while(list($name,$value)=each($arr["value"])){
			
			$temp = str_replace('\\\\','\\',$value);
			$temp = str_replace('\\"','"',$temp);
			$temp = str_replace('\\\'','\'',$temp);
			$col.="$name,";
			if($name=="page_addtime"){
				date_default_timezone_set("Asia/Hong_Kong");
				$temp=str_replace("now()",date("Y-m-d H:i:s"),$temp);
			}
			$val.= u2utf8(json_encode($temp)) .",";
			//$val.=;
		}
		$col=substr($col,0,strlen($col)-1);
		$col.=")";
		$val=substr($val,0,strlen($val)-1);
		$val.=")";
		$sql.=$col.$val;
		return $sql;
	}

	/*更新函数*/
	function updateSql($arr){
		$table = $arr["table"];
		//echo $table;
		$sql="update ".$table." set ";
		while(list($name,$value)=each($arr["value"])){
			$temp_u = str_replace('\\\\','\\',$value);
			$temp_u = str_replace('\\"','"',$temp_u);
			$temp_u = str_replace('\\\'','\'',$temp_u);
			$sql.=$name."=".u2utf8(json_encode($temp_u)) .",";
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$where = $arr["where"];
		$sql.=" where ".$where;
		return $sql;
	}

	/*调用插入方法*/
	function insert(){
		//$json='{"table":"tb_category","value":{"category_name":"123阿萨德发送到阿斯多夫","category_id":30}}';
		$arr=$_POST["data"];
		$table = $arr["table"];
		$sql = insertSql($arr);

		mysql_query($sql);
		$mid = mysql_insert_id();
		if($mid){
			$response = array(
				'success' => 'success',
				'id' => $mid,
				'data' => $arr
			);	
		}else{
			$response = array(
				'error' => 'error',
				'message' => mysql_error()
			);		
		}
		echo json_encode($response);
		
	}

	
	/*调用更新方法*/
	function update(){
		
		$arr=$_POST["data"];
		$table = $arr["table"];
		$where = $arr["where"];
		$sql = updateSql($arr);
		$id =  mysql_query($sql);
		if($id){
			$response = array(
				'success' => 'success',
				'id' => $id,
				'data' => $arr
			);	
		}else{
			$response = array(
				'error' => 'error',
				'message' => mysql_error()
			);		
		}
		echo json_encode($response);
	}
	

	/*获取频道列表*/
	function getChannelList(){
		$sql="SELECT * FROM  tb_channel where ch_parent<>-1 ORDER BY  ch_sort ASC";
		//echo $sql;
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("ch_id"=>$obj->ch_id,
			"ch_parent"=>$obj->ch_parent,
			"ch_name"=>$obj->ch_name,
			"ch_ename"=>$obj->ch_ename,
			"ch_thumbnail"=>$obj->ch_thumbnail,
			"ch_css"=>$obj->ch_css,
			"ch_path"=>$obj->ch_path,
			"ch_sort"=>$obj->ch_sort
			);
			array_push($json_all,$json);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_channel";
		$data->value=$json_all;
		
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据ID获取频道*/
	function getChannelById(){
		$id=$_GET["id"];
		$sql="select * from tb_channel where ch_id=".$id;
		$res=mysql_query($sql);
		$json_all=array();
		if($obj=mysql_fetch_object($res))
		{
			$json_all=array("ch_id"=>$obj->ch_id,
			"ch_parent"=>$obj->ch_parent,
			"ch_name"=>$obj->ch_name,
			"ch_ename"=>$obj->ch_ename,
			"ch_thumbnail"=>$obj->ch_thumbnail,
			"ch_css"=>$obj->ch_css,
			"ch_path"=>$obj->ch_path,
			"ch_sort"=>$obj->ch_sort
			);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_channel";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据ID删除频道*/
	function delChannelById(){
		$id=$_GET["id"];
		
		//删除分类
		$sql = "UPDATE tb_type set type_state =0 where type_channel = " .$id; 
		mysql_query($sql);
		
		// 禁用频道 
		$sql = "UPDATE tb_channel set ch_parent=-1 where ch_id = " .$id; 
		echo mysql_query($sql);
		
	}

	/*根据频道获取分类列表*/
	function getTypeByChannel(){

		$channel=$_GET["channel"];
		
		if($channel!="-1") $channel=" and type_channel=".$channel;
		$sql="SELECT type_id,type_name,type_channel,type_state,type_thumbnail,(select count(mod_id) from tb_mod where mod_type= type_id) as type_count FROM tb_type where type_state=1 $channel";
		//echo $sql;
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("type_id"=>$obj->type_id,
				"type_channel"=>$obj->type_channel,
				"type_name"=>$obj->type_name,
				"type_thumbnail"=>$obj->type_thumbnail,
				"type_count"=>$obj->type_count,
				"type_state"=>$obj->type_state 
			);
			array_push($json_all,$json);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_type";
		$data->value=$json_all;
		
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据ID删除分类*/
	function delTypeById(){
		$type_id=$_GET["id"];
		$sql = "UPDATE tb_type set type_state=0 where type_id = " .$type_id;   //更改分类状态
		if(mysql_query($sql)==1){
			$sql2="UPDATE tb_mod SET mod_state=0 WHERE mod_type=".$type_id;    //更改模块状态
			echo mysql_query($sql2);
			return;
		}
		echo 0;
	}
	
	// 初始化模块分类
	function initType(){

		$channel=$_GET["channel"];
		if($channel<>"-1")
		{
		
			$sql="select type_id from tb_type where type_channel=$channel";
			$res=mysql_query($sql);
		  if(!mysql_fetch_row($res)){
		  	
				$arr=array("文字","图片","按钮","内容模块","选项卡 ","表格","表单","翻页","商品列表","文字列表","系统浮层","辅助浮层","ICON","步骤","轮播","其他");

				foreach($arr as $type_name)
				{
					$sql="INSERT INTO `page_generator`.`tb_type` (`type_channel`, `type_name`, `type_thumbnail`, `type_count`, `type_state`) VALUES ('$channel', '$type_name', '', '0', '1')";
					mysql_query($sql);
				}
				
				$response = array(
					'success' => 'success'
				);	
				echo json_encode($response);
			}
			else{
				$response = array(
					'error' => '数据库已存在！'
				);	
				echo json_encode($response);
			}
		}
		else{
			$response = array(
				'error' => 'error'
			);	
			echo json_encode($response);
		}
		//http://ecd.ecc.com/pg/inc/handler.php?act=initType&channel=-1
	}
	

	/*获取布局列表*/
	function getTemplateList(){
		$sql="select * from tb_template join tb_channel on tmp_channel=ch_id where tmp_channel <> -1";
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("tmp_id"=>$obj->tmp_id,
			"tmp_channel"=>$obj->tmp_channel,
			"ch_name"=>$obj->ch_name,
			"tmp_name"=>$obj->tmp_name,
			"tmp_html"=>$obj->tmp_html,
			"tmp_css"=>$obj->tmp_css,
			"tmp_desc"=>$obj->tmp_desc,
			"tmp_thumbnail"=>$obj->tmp_thumbnail
			);
			array_push($json_all,$json);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_template";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据频道获取布局列表*/
	function getTemplateByChannel(){
		$channel=$_GET["channel"];
		$sql="select * from tb_template join tb_channel on tmp_channel=ch_id where tmp_channel <> -1";
		if($channel!="-1") $sql=$sql." and tmp_channel=".$channel;
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("tmp_id"=>$obj->tmp_id,
			"tmp_channel"=>$obj->tmp_channel,
			"ch_name"=>$obj->ch_name,
			"tmp_name"=>$obj->tmp_name,
			"tmp_html"=>$obj->tmp_html,
			"tmp_css"=>$obj->tmp_css,
			"tmp_desc"=>$obj->tmp_desc,
			"tmp_thumbnail"=>$obj->tmp_thumbnail
			);
			array_push($json_all,$json);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_template";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据ID删除模板*/
	function delTemplateById(){
		$id=$_GET["id"];
		$sql = "UPDATE tb_template set tmp_channel = -1 where tmp_id = " .$id; 
		echo mysql_query($sql);
	}

	/*根据ID获取布局*/
	function getTemplateById(){
		$id=$_GET["id"];
		$sql="select * from tb_template join tb_channel on tmp_channel=ch_id where tmp_id=".$id;
		$res=mysql_query($sql);
		$json_all=array();
		if($obj=mysql_fetch_object($res))
		{
			$json_all=array("tmp_id"=>$obj->tmp_id,
			"tmp_channel"=>$obj->tmp_channel,
			"ch_name"=>$obj->ch_name,
			"tmp_name"=>$obj->tmp_name,
			"tmp_html"=>$obj->tmp_html,
			"tmp_css"=>$obj->tmp_css,
			"tmp_desc"=>$obj->tmp_desc,
			"tmp_thumbnail"=>$obj->tmp_thumbnail
			);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_template";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据频道获取模块列表*/
	function getModByChannel(){
		$channel=$_GET["channel"];
		$sql="SELECT * FROM tb_mod JOIN tb_channel ON mod_channel = ch_id where mod_state =1";
		if($channel!="-1") $sql=$sql." and mod_channel=".$channel;
		$sql = $sql. " ORDER BY mod_sort ASC";
		getModList($sql);
	}

	/*根据公用/私有属性 获取模块列表*/
	function getModIsPublic(){
		$channel=$_GET["channel"];
		$public=$_GET["public"];
		$sql="SELECT * FROM tb_mod JOIN tb_channel ON mod_channel = ch_id where mod_state = 1";
		if($channel!="-1") $sql=$sql." and mod_channel=".$channel;
		if($public!="-1") $sql=$sql." and mod_ispublic=".$public;
		$sql = $sql. " ORDER BY mod_sort ASC";
		getModList($sql);
	}

	/*模块列表方法*/
	function getModList($sql){
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("mod_id"=>$obj->mod_id,
			"mod_name"=>$obj->mod_name,
			"mod_channel"=>$obj->mod_channel,
			"ch_name"=>$obj->ch_name,
			"ch_css"=>$obj->ch_css,
			"mod_html"=>$obj->mod_html,
			"mod_css"=>$obj->mod_css,
			"mod_js"=>$obj->mod_js,
			"mod_type"=>$obj->mod_type,
			"mod_thumbnail"=>$obj->mod_thumbnail,
			"mod_creator"=>$obj->mod_creator,
			"mod_frequency"=>$obj->mod_frequency,
			"mod_state"=>$obj->mod_state,
			"mod_ispublic"=>$obj->mod_ispublic,
			"mod_sort"=>$obj->mod_sort
			);
			array_push($json_all,$json);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_mod";
		$data->value=$json_all;
		
		$out->data=$data;
		echo json_encode($out);
	}

	/*根据ID获取模块*/
	function getModById(){
		$id=$_GET["id"];
		$sql="select tb_mod.* , tb_channel.ch_id, tb_channel.ch_name, tb_channel.ch_css, tb_type.type_id, tb_type.type_name from tb_mod JOIN tb_channel ON mod_channel = ch_id LEFT JOIN tb_type ON mod_type = type_id where mod_id =".$id;
		$res=mysql_query($sql);
		$json_all=array();
		if($obj=mysql_fetch_object($res))
		{
			$json_all=array("mod_id"=>$obj->mod_id,
			"mod_name"=>$obj->mod_name,
			"mod_channel"=>$obj->mod_channel,
			"ch_name"=>$obj->ch_name,
			"ch_css"=>$obj->ch_css,
			"mod_html"=>$obj->mod_html,
			"mod_css"=>$obj->mod_css,
			"mod_js"=>$obj->mod_js,
			"type_id"=>$obj->type_id,
			"type_name"=>$obj->type_name,
			"mod_thumbnail"=>$obj->mod_thumbnail,
			"mod_creator"=>$obj->mod_creator,
			"mod_frequency"=>$obj->mod_frequency,
			"mod_state"=>$obj->mod_state,
			"mod_ispublic"=>$obj->mod_ispublic,
			"mod_sort"=>$obj->mod_sort
			);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_mod";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}
	  
	/*删除模块*/
	function delModById(){
		//$sql="DELETE FROM `tb_page` WHERE `tb_page`.`page_id` = ".$id;
		$mod_id=$_GET["id"];
		$sql = "UPDATE  tb_mod SET  mod_state = 0 WHERE  mod_id =".$mod_id;
		echo mysql_query($sql);	
	}
	
	/*设置模块的使用频率 -1是减一 1是加1*/
	function modFrequencySetting(){
		$mod_id=$_GET["$mod_id"];
		$state=$_GET["state"];
		$sql = 'UPDATE  `tb_mod` SET  `mod_frequency` =  `mod_frequency` + 1  WHERE  `tb_mod`.`mod_id` =' . $mod_id;
		if($state == -1){
			$sql = 'UPDATE  `tb_mod` SET  `mod_frequency` =  `mod_frequency` - 1  WHERE  `tb_mod`.`mod_id` =' . $mod_id;
		}
		mysql_query($sql);
		echo $mod_id;
	}

	/*页面列表函数*/
	function baseSelectPageList($sql){
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("page_id"=>$obj->page_id,
			"page_channel"=>$obj->page_channel,
			"page_title"=>$obj->page_title,
			"page_keyword"=>$obj->page_keyword,
			"page_desc"=>$obj->page_desc,
			"page_directory"=>$obj->page_directory,
			"page_filename"=>$obj->page_filename,
			"tmp_id"=>$obj->tmp_id,
			"tmp_name"=>$obj->tmp_name,
			"tmp_html"=>$obj->tmp_html,
			"tmp_css"=>$obj->tmp_css,
			"page_data"=>$obj->page_data,
			"page_modlist"=>$obj->page_modlist,
			"page_creator"=>$obj->page_creator,
			"page_editor"=>$obj->page_editor,
			"page_thumbnail" =>$obj->page_thumbnail,
			"page_addtime" =>$obj->page_addtime,
			"page_lasttime" =>$obj->page_lasttime,
			"page_state" =>$obj->page_state
			);
			array_push($json_all,$json);
		}
		
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_page";
		$data->value=$json_all;
		$out->data=$data;
		return json_encode($out);	
	}
	
	/*根据频道获取页面列表*/
	function getPageListByChannel(){
		$channel=$_GET["channel"];
		if($channel!="-1") $channel=" and page_channel = ".$channel;
		else $channel="";
		$sql="select * from tb_page join tb_template on page_tmp=tmp_id where page_state = 1 $channel order by page_id desc";
		echo baseSelectPageList($sql);
	}
	
	/*根据用户获取页面列表*/
	function getPageListByUser(){
		$user=$_GET["user"];
		$channel=$_GET["channel"];
		if($channel!="-1") $channel=" and page_channel = ".$channel;
		else $channel="";
		$sql="select * from tb_page join tb_template on page_tmp=tmp_id where page_creator='". $user ."'  and page_state = 1 $channel order by page_id desc";
		echo baseSelectPageList($sql);
	}
	
	/*根据ID获取页面*/
	function getPageById(){
		$id=$_GET["id"];
		$sql="select * from tb_page join tb_template on page_tmp=tmp_id where page_state = 1 and page_id=".$id;
		$res=mysql_query($sql);
		$json_all=array();
		if($obj=mysql_fetch_object($res))
		{
			$json_all=array("page_id"=>$obj->page_id,
			"page_channel"=>$obj->page_channel,
			"page_title"=>$obj->page_title,
			"page_keyword"=>$obj->page_keyword,
			"page_desc"=>$obj->page_desc,
			"page_directory"=>$obj->page_directory,
			"page_filename"=>$obj->page_filename,
			"tmp_id "=>$obj->tmp_id,
			"tmp_name"=>$obj->tmp_name,
			"page_source"=>str_replace('${content}', $obj->page_data, $obj->tmp_html),
			"page_data"=>$obj->page_data,
			"page_modlist"=>$obj->page_modlist,
			"page_creator"=>$obj->page_creator,
			"page_editor"=>$obj->page_editor,
			"page_thumbnail" =>$obj->page_thumbnail,
			"page_addtime" =>$obj->page_addtime,
			"page_lasttime" =>$obj->page_lasttime,
			"page_state" =>$obj->page_state
			);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_page";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}

	/*生成页面*/
	function createPageById(){

		$id=$_GET["id"];
		//获取页面对象
		$page=getPage($id);
		$pagetitle=$page->page_title;
		$description=$page->page_desc;
		$keyword=$page->page_keyword;
		$directory=$page->page_directory;
		$filename=$page->page_filename.".html";

		//替换模板内容
		$tmp_cont=$page->page_source;
		$tmp_cont=str_replace('{{pagetitle}}',$pagetitle,$tmp_cont);
		$tmp_cont=str_replace('{{description}}',$description,$tmp_cont);
		$tmp_cont=str_replace('{{keywords}}',$keyword,$tmp_cont);
		

	    //静态文件目录
	    $page_dir="/file/";

	    //检查目录是否存在
	    $file_dir=syspath().$page_dir.$directory."/";
	    if(!file_exists($file_dir)){
	    	mkdir($file_dir);
	    }

	    //生成文件
	    $path=$file_dir.$filename;
	    $op=fopen($path,"w");
	    $json = new StdClass;
		if(fwrite($op,$tmp_cont)){
			$json->state="success";
			$json->webpath=webpath().$page_dir.$directory."/".$filename;
			$json->filepath=syspath().$page_dir.$directory."/".$filename;
			
			$dir="..".$page_dir.$directory;
			header("Location: zip_api.php?dir=$dir&file=$directory&d=".date('h-i-s-A'));
		}
		else{
			$json->state="fail";
			$json->webpath="";
			$json->filepath="";
		}

		$out = new StdClass;
		$data = new StdClass;
		$data->value=$json;
		$out->data=$data;
		echo json_encode($out);
	}

	/*删除页面*/
	function delPageById(){
		$id=$_GET["id"];
		$sql = "UPDATE  tb_page SET  page_state = 0 WHERE  page_id =".$id;
		echo mysql_query($sql);	
	}

	/*修改用户权限页面*/
	function setUserPower(){
		$userid=$_GET["userid"];
		$power=$_GET["power"];
		$sql = "UPDATE tb_users SET user_power = $power WHERE user_id = $userid";
		echo mysql_query($sql);	
	}

	/* 获取单个用户信息*/
	function getUserById(){
		$userid=$_GET["id"];
		$sql="select * from tb_users where user_id = $userid";
		$res=mysql_query($sql);
		$json_all=array();
		if($obj=mysql_fetch_object($res))
		{
			$json_all=array("user_id"=>$obj->user_id,
			"login_name"=>$obj->login_name,
			"english_name"=>$obj->english_name,
			"chinese_name"=>$obj->chinese_name,
			"full_name"=>$obj->full_name,
			"gender"=>$obj->gender,
			"group_name"=>$obj->group_name,
			"user_power"=>$obj->user_power,
			"user_addtime"=>$obj->user_addtime
			);
		}
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_page";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);
	}

	/* 获取普通用户*/
	function getUserList(){
		getByUserByPower(1);
	}

	/* 获取管理员用户*/
	function getAdminList(){
		getByUserByPower(2);
	}

	/*根据用户级别获取用户列表*/
	function getByUserByPower($power){
		$sql="select * from tb_users where user_power = $power";
		$res=mysql_query($sql);
		$json_all=array();
		while($obj=mysql_fetch_object($res))
		{
			$json=array("user_id"=>$obj->user_id,
			"login_name"=>$obj->login_name,
			"english_name"=>$obj->english_name,
			"chinese_name"=>$obj->chinese_name,
			"full_name"=>$obj->full_name,
			"gender"=>$obj->gender,
			"group_name"=>$obj->group_name,
			"user_power"=>$obj->user_power,
			"user_addtime"=>$obj->user_addtime
			);
			array_push($json_all,$json);
		}
		
		$data = new StdClass;
		$out = new StdClass;
		$data->table="tb_users";
		$data->value=$json_all;
		$out->data=$data;
		echo json_encode($out);	
	}
	
	/*保存草稿*/
	function saveDraftBase($template_id,$arr){
		//插入新数据
		$sql_insert = insertSql($arr);
		mysql_query($sql_insert);
		$mid = mysql_insert_id();
		//更新本条数据
		$arr["value"]["template_parent_id"] = $template_id;
		$sql = updateSql($arr);
		$suc = mysql_query($sql);
		//删除多余草稿
		$del_id = delTemplateDraft($template_id);
		$response = array(
			'error' => 'error',
			'updata_id' => $template_id
		);	
		if($mid && $suc){
			$response = array(
				'success' => 'success',
				'updata_id' => $template_id,
				'insert_id' => $mid,
				'delete_id' => $del_id
			);	
		}
		return $response;
	}
	
	function saveDraft($id){
		$id = (int)$id;
		$arr=$_POST["data"];
		$response = saveDraftBase($id,$arr);
		echo json_encode($response);
	}
	
	/*发布页面*/
	function publishPage($page_id,$template_id){
		$response = array(
			'error' => 'error',
			'updata_id' => $page_id
		);
	
		//保存template 数据
		$arr=$_POST["data"];
		saveDraftBase($template_id,$arr);
		//更新page数据
		$sql="select * from tb_page where page_state = 1 and page_id=".$page_id;
		$res=mysql_query($sql);
		
		//存在该页面
		if($obj=mysql_fetch_object($res)){
			$page_finish_date = empty($obj->page_finish_date) ?  date("Y-m-d H:i:s") : ($obj->page_finish_date);
			$page_type	 	  = $obj->page_type;
			$page_directory   = $obj->page_directory;
			$page_url 		  = $page_type . $page_directory . "/index.html";
			$page_inter_url   = 'project/release/' . $page_directory . "/index.html";
			$page_modify_user = getSessionUser();
			$page_creator   = $obj->page_creator;
			
			//if( empty($page_finish_date) ||  )
			$sql2 = "UPDATE `tb_page` SET `page_url` = '". $page_url ."' , `page_modify_user` = '". $page_modify_user ."', `page_finish_date` = '". $page_finish_date ."'  WHERE `page_id` = ".$page_id;
			$mid =  mysql_query($sql2);
			
			if($mid){
				$response = array(
					'success' => 'success',
					'page_finish_date' => $page_finish_date,
					'page_type' => $page_type,
					'page_directory' => $page_directory,
					'page_url' => $page_url,
					'page_inter_url' => $page_inter_url,
					'page_modify_user' => $page_modify_user,
					'page_creator' => $page_creator
				);
			}//end if
		}//end if
		
		echo json_encode($response);
	}

?>