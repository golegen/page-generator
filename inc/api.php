<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8" />
<title></title>
<style type="text/css">
	a{color:blue;text-decoration:none;margin:0 20px 0 0;}
	li{color:#666;font-family:tahoma;line-height:24px;}
</style>
</head>
<body>
<h1>API接口调用方法 <em>handler.php?act=</em></h1>
<h3>JSON 格式化工具 <a href="http://jsonlint.com/" target="_blank">http://jsonlint.com/</a></h3>
<iframe style="background:#eee" id="api" name="api" width="100%" frameborder="0"></iframe>
<ul>
	<li>
		<h2>新增/修改</h2>
		<ul>
			<li><a href="handler.php?act=insert" target="api">新增 insert</a>  通过POST方式传递JSON格式数据如：
		{"table":"tb_channel","value":{"ch_name":"新频道","ch_ename":"new channel","ch_parent":0}}</li>
			<li><a href="handler.php?act=update" target="api">更新 update</a>通过POST方式传递JSON格式数据如：
		{"table":"tb_channel","value":{"ch_name":"新频道2","ch_ename":"new channel2","ch_parent":0},"<strong style="color:red;">where</strong>":"ch_id=2"} where是更新的条件</li>
		</ul>
	</li>
	<li>
		<h2>频道</h2>
		<ul>
			<li><a href="handler.php?act=getChannelList" target="api">获取频道列表 getChannelList</a></li>
			<li><a href="handler.php?act=getChannelById&id=1" target="api">根据ID 获取频道 getChannelById&id=1</a></li>
			<li><a href="handler.php?act=delChannelById&id=1" target="api">根据ID 删除频道 delChannelById&id=1</a></li>
		</ul>
	</li>
	<li>
		<h2>模板</h2>
		<ul>
			<li><a href="handler.php?act=getTemplateList" target="api">获取模板列表  getTemplateList</a></li>
			<li><a href="handler.php?act=getTemplateByChannel&channel=1" target="api">根据频道 获取模板列表  getTemplateByChannel&channel=1</a> channel=-1 表示不区分频道</li>
			<li><a href="handler.php?act=getTemplateById&id=1" target="api">根据ID 获取模板  getTemplateById&id=1</a> </li>
			<li><a href="handler.php?act=delTemplateById&id=1" target="api">根据ID 删除模板  delTemplateById&id=1</a> </li>
		</ul>
	</li>
	<li>
		<h2>分类</h2>
		<ul>
			<li><a href="handler.php?act=getTypeByChannel&channel=1" target="api">根据频道 获取分类列表 getTypeByChannel&channel=1</a> channel=-1 表示不区分频道</i>
			<li><a href="handler.php?act=delTypeById&id=999" target="api">根据ID 删除分类 delTypeById&id=999</a></li>
		</ul>
	</li>
	<li>
		<h2>模块</h2>
		<ul>
			<li><a href="handler.php?act=getModByChannel&channel=2" target="api">根据频道 获取模块 getModByChannel&channel=2</a> channel=-1 表示不区分频道</li>
			<li><a href="handler.php?act=getModById&id=1" target="api">根据ID 获取模块 getModById&id=1</a></li>
			<li><a href="handler.php?act=getModIsPublic&channel=-1&public=1" target="api">根据公用/私有获取模块列表 getModIsPublic&channel=-1&public=1</a> channel=-1 表示不区分频道  public=-1 表示不区分公有/私有 </li>
			<li><a href="handler.php?act=delModById&id=22" target="api">根据ID 删除模块 delModById&id=22</a></li>
		</ul>
	</li>
	<li>
		<h2>页面</h2>
		<ul>
			<li><a href="handler.php?act=getPageListByChannel&channel=1" target="api">根据频道 获取页面列表 getPageListByChannel&channel=1</a> channel=-1 表示不区分频道</li>
			<li><a href="handler.php?act=getPageListByUser&user=williamsli&channel=-1" target="api">根据频道 获取页面列表 getPageListByUser&user=williamsli&channel=-1</a></li>
			<li><a href="handler.php?act=getPageById&id=1" target="api">根据ID 获取页面列表 getPageById&id=1</a></li>
			<li><a href="handler.php?act=delPageById&id=22000" target="api">根据ID 删除页面 delPageById&id=22000</a></li>
			<li><a href="handler.php?act=createPageById&id=1" target="api">根据ID 生成页面 createPageById&id=1</a></li>
		</ul>
	</li>
	<li>
		<h2>用户相关</h2>
		<ul>
			<li><a href="handler.php?act=getAdminList" target="api">获取管理员 getAdminList</a></li>
			<li><a href="handler.php?act=getUserList" target="api">获取普通用户 getUserList</a></li>
			<li><a href="handler.php?act=setUserPower&userid=17075&power=2" target="api">设置用户权限 setUserPower</a></li>
			<li><a href="handler.php?act=getUserById&id=17075" target="api">获取单个用户信息 getUserById</a></li>
		</ul>
	</li>
</ul>

</body>
</html>