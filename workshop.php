<?php
/**
 * @desc: 页面编辑
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-27
 */
require_once("inc/conn.php");
require_once 'inc/global_func.php';

/* 输出页面数据 */
$page_obj = getPage($_GET["page_id"]);
echo $page_obj -> page_source;

if($_GET['act'] == 'update'){
    /* 输出数据到页面 */
    $modList = $page_obj -> page_modlist;
    $pageTitle = $page_obj -> page_title;
?>

<!-- S 控制面板代码 -->
<script data-main="script/main.js" src="script/require-jquery.js"></script>
<div class="pg_panel_wrap">
    <div class="pg_panel_header">
        <h2>操作面板</h2>
        <div class="pg_panel_opt">
        	<a href="#" id="btn_back" class="back"><i class="ico_back"></i><br />返回</a>
            <a href="#" id="previewPage" class="preview"><i class="ico_preview"></i><br />预览</a>
            <a href="#" id="clearPage" class="clear"><i class="ico_clear"></i><br />清空</a>
            <button id="savePage" class="btn_submit" title="Shift + S">保存页面</button>
            <label for="autoSave" style="cursor:pointer;" title="5分钟自动保存">
                <input id="autoSave" type="checkbox" name="" style="vertical-align: -2px;margin-right:3px;">自动保存
            </label>
        </div>
    </div>
    <div class="pg_panel_modlist">
        <div id="classifiedList"></div>
    </div>

    <!-- 模块列表容器模板 -->
    <script id="modListTemplate" type="text/x-jquery-tmpl">
        <h3>${type_name}
<!--            <i class="angle_outter">◆</i><i class="angle_inner">◆</i>-->
        </h3>
        <div><ul id="${type_id}" class="mod_list list_con" ></ul></div>
    </script>

    <!-- 模块列表模板 -->
    <script id="modListItemTemplate" type="text/x-jquery-tmpl">
        <li class="mod_wrap ${classname}" data-id="${mod_id}" data-title="${mod_name}">
            <img src="${mod_thumbnail}" alt="">
            <textarea class="md_html">${mod_html}</textarea>
            <textarea class="md_css">${mod_css}</textarea>
        </li>
    </script>

    <!-- 数据存储区 -->
    <input id="modList" type="hidden" value="<?= $modList ?>">
    <input id="pageTitle" type="hidden" value="<?= $pageTitle ?>">

    <script type="text/javascript">
        /* 编辑状态脚本 */
        require(["page/workshop"], function(workshop) {
            $(function() {
                workshop.init();
            });
        });
    </script>
</div>

<!-- 图片设置面板内容 -->
<script id="panelImageTemplate" type="text/x-jquery-tmpl">
    <div class="pg_popup">
        <div class="pg_popup_hd"><h3>[图片链接] 设置面板</h3><button class="close">&times;</button></div>
        <div class="pg_popup_cont">
            <div class="pg_popup_frm pg_popup_image">
                <div class="option">
                    <label for="picSrc">图片地址</label>
                    <input type="text" id="picSrc" placeholder="http://ecd.tencent.com/xxx.png" />
                </div>
                <div class="option">
                    <label for="linkURL">链接地址</label>
                    <input type="text" id="linkURL"  placeholder="http://ecd.tencent.com/" />
                </div>
                <div class="option">
                    <label for="picWidth">图片大小</label>
                    <input id="picWidth" type="number" min="0"> &times; <input id="picHeight" type="number"  min="0">
                </div>
                <!--div class="option">
                    <label>排列方式</label>
                    <span class="frm_radio"><input type="radio" id="block" name="openlink"><label for="block">换行</label></span>
                    <span class="frm_radio"><input type="radio" id="inline" name="openlink" checked="checked"><label for="inline">不换行</label></span>
                </div-->
            </div>
        </div>
        <div class="pg_popup_ft">
            <button class="btn_submit">确认并关闭</button>
            <!--<button class="cancel">取消并关闭</button>-->
        </div>
    </div>
</script>

<!-- 文本设置面板内容 -->
<script id="panelTextTemplate" type="text/x-jquery-tmpl">
    <div class="pg_popup">
        <div class="pg_popup_hd"><h3>[段落] 设置面板</h3><button class="close">&times;</button></div>
        <div class="pg_popup_cont">
            <div class="pg_popup_frm pg_popup_text">
                <div class="fontbutton">
                    <label>文本（整体）样式</label>
                    <ul>
                        <li class="bold"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                        <li class="justifyleft"><a href="javscript:;" title="居左对齐" class="texticon"><span></span></a></li>
                        <li class="justifycenter"><a href="javscript:;" title="局中对齐" class="texticon"><span></span></a></li>
                        <li class="justifyright"><a href="javscript:;" title="居右对齐" class="texticon"><span></span></a></li>
                    </ul>
                </div>
                <div class="fontoption" style="left:70px;top:102px;display:none;" id="fontname">
                    <ul class="fontname">
                        <li style="font-family:Arial">Arial</li>
                        <li style="font-family:Tahoma">Tahoma</li>
                        <li style="font-family:Verdana">Verdana</li>
                        <li style="font-family:Comic Sans MS">Comic Sans MS</li>
                        <li style="font-family:Times New Roman">Times New Roman</li>
                        <li style="font-family:微软雅黑">微软雅黑</li>
                        <li style="font-family:宋体">宋体</li>
                        <li style="font-family:楷体">楷体</li>
                        <li style="font-family:隶书">隶书</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:100px;top:102px;display:none;" id="fontsize">
                    <ul class="fontsize">
                        <li>10</li>
                        <li>12</li>
                        <li>14</li>
                        <li>18</li>
                        <li>24</li>
                        <li>30</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:130px;top:102px;display:none;" id="fgcolor">
                    <ul class="fgcolor">
                        <li style="background:#000" data-color="#000" title="#000"></li>
                        <li style="background:#333" data-color="#333" title="#333"></li>
                        <li style="background:#666" data-color="#666" title="#666"></li>
                        <li style="background:#999" data-color="#999" title="#999"></li>
                        <li style="background:#369" data-color="#369" title="#369"></li>
                        <li style="background:#f60" data-color="#f60" title="#f60"></li>
                    </ul>
                </div>
                <div class="fontbutton">
                    <label>文本（选中）样式</label>
                    <ul>
                        <li class="bold" data-range="partial"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline" data-range="partial"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname" data-range="partial"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize" data-range="partial"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor" data-range="partial"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                        <li class="insertlink" data-range="partial"><a href="javscript:;" title="插入链接" class="texticon"><span>@</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="pg_popup_ft">
            <button class="btn_submit">确认并关闭</button>&nbsp;
<!--            <button class="cancel">取消并关闭</button>-->
        </div>
    </div>
</script>

<!-- 链接设置面板内容 -->
<script id="panelLinkTemplate" type="text/x-jquery-tmpl">
    <div class="pg_popup">
        <div class="pg_popup_hd"><h3>[链接] 设置面板</h3><button class="close">&times;</button></div>
        <div class="pg_popup_cont">
            <div class="pg_popup_frm pg_popup_link">
                <div class="fontbutton">
                    <label>链接样式</label>
                    <ul>
                        <li class="bold"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                    </ul>
                </div>
                <div class="fontoption" style="left:70px;top:102px;display:none;" id="fontname">
                    <ul class="fontname">
                        <li style="font-family:Arial">Arial</li>
                        <li class="selected" style="font-family:Tahoma">Tahoma</li>
                        <li style="font-family:Verdana">Verdana</li>
                        <li style="font-family:Comic Sans MS">Comic Sans MS</li>
                        <li style="font-family:Times New Roman">Times New Roman</li>
                        <li style="font-family:微软雅黑">微软雅黑</li>
                        <li style="font-family:宋体">宋体</li>
                        <li style="font-family:楷体">楷体</li>
                        <li style="font-family:隶书">隶书</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:100px;top:102px;display:none;" id="fontsize">
                    <ul class="fontsize">
                        <li>10</li>
                        <li>12</li>
                        <li>14</li>
                        <li>18</li>
                        <li>24</li>
                        <li>30</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:130px;top:102px;display:none;" id="fgcolor">
                    <ul class="fgcolor">
                        <li style="background:#000" data-color="#000" title="#000"></li>
                        <li style="background:#333" data-color="#333" title="#333"></li>
                        <li style="background:#666" data-color="#666" title="#666"></li>
                        <li style="background:#999" data-color="#999" title="#999"></li>
                        <li style="background:#369" data-color="#369" title="#369"></li>
                        <li style="background:#f60" data-color="#f60" title="#f60"></li>
                    </ul>
                </div>
                <div class="option">
                    <label for="linkText">链接文本</label>
                    <input type="text" id="linkText" />
                </div>
                <div class="option">
                    <label for="linkURL">链接地址</label>
                    <input type="text"  value="http://" placeholder="http://ecd.tencent.com/" id="linkURL" />
                </div>
                <div class="option">
                    <label>打开方式</label>
                    <span class="frm_radio"><input type="radio" id="blank" name="openlink" /><label for="blank">新窗口打开</label></span>
                    <span class="frm_radio"><input type="radio" id="self" name="openlink" /><label for="self">原窗口打开</label></span>
                </div>
            </div>
        </div>
        <div class="pg_popup_ft">
            <button class="btn_submit">确认并关闭</button>&nbsp;
<!--            <button class="cancel">取消并关闭</button>-->
        </div>
    </div>
</script>

<!-- 表格设置面板内容 -->
<script id="panelTableTemplate" type="text/x-jquery-tmpl">
    <div class="pg_popup">
        <div class="pg_popup_hd"><h3>[表格] 设置面板</h3><button class="close">&times;</button></div>
        <div class="pg_popup_cont">
            <div class="pg_popup_frm pg_popup_table">
                    <div class="fontbutton">
                        <label>文本（整体）样式</label>
                        <ul>
                            <li class="bold"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                            <li class="underline"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                            <li class="fontname"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                            <li class="fontsize"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                            <li class="fgcolor"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                            <li class="justifyleft"><a href="javscript:;" title="居左对齐" class="texticon"><span></span></a></li>
                            <li class="justifycenter"><a href="javscript:;" title="局中对齐" class="texticon"><span></span></a></li>
                            <li class="justifyright"><a href="javscript:;" title="居右对齐" class="texticon"><span></span></a></li>
                        </ul>
                    </div>
                    <div class="fontoption" style="left:70px;top:102px;display:none;" id="fontname">
                        <ul class="fontname">
                            <li style="font-family:Arial">Arial</li>
                            <li style="font-family:Tahoma">Tahoma</li>
                            <li style="font-family:Verdana">Verdana</li>
                            <li style="font-family:Comic Sans MS">Comic Sans MS</li>
                            <li style="font-family:Times New Roman">Times New Roman</li>
                            <li style="font-family:微软雅黑">微软雅黑</li>
                            <li style="font-family:宋体">宋体</li>
                            <li style="font-family:楷体">楷体</li>
                            <li style="font-family:隶书">隶书</li>
                        </ul>
                    </div>
                    <div class="fontoption" style="left:100px;top:102px;display:none;" id="fontsize">
                        <ul class="fontsize">
                            <li>10</li>
                            <li>12</li>
                            <li>14</li>
                            <li>18</li>
                            <li>24</li>
                            <li>30</li>
                        </ul>
                    </div>
                    <div class="fontoption" style="left:130px;top:102px;display:none;" id="fgcolor">
                        <ul class="fgcolor">
                            <li style="background:#000" data-color="#000" title="#000"></li>
                            <li style="background:#333" data-color="#333" title="#333"></li>
                            <li style="background:#666" data-color="#666" title="#666"></li>
                            <li style="background:#999" data-color="#999" title="#999"></li>
                            <li style="background:#369" data-color="#369" title="#369"></li>
                            <li style="background:#f60" data-color="#f60" title="#f60"></li>
                        </ul>
                    </div>
                    <div class="fontbutton">
                        <label>文本（选中）样式</label>
                        <ul>
                            <li class="bold" data-range="partial"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                            <li class="underline" data-range="partial"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                            <li class="fontname" data-range="partial"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                            <li class="fontsize" data-range="partial"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                            <li class="fgcolor" data-range="partial"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                            <li class="insertlink" data-range="partial"><a href="javscript:;" title="插入链接" class="texticon"><span>@</span></a></li>
                        </ul>
                    </div>
                    <div class="option">
                        <label>表格行列操作（不支持跨行/列操作）</label>
                        <button id="addRow">复制此行</button>
                        <button id="removeRow">移除此行</button>
                        <button id="addCol">复制此列</button>
                        <button id="removeCol">移除此列</button>
                    </div>
                    <!--div class="fontbutton">
                        <label>表格单元格操作（不支持交错合并）</label>
                        <button id="joinRight">向右合并</button>
                        <button id="joinDown">向下合并</button>
                    </div-->
                    <div class="option">
                        <label>第 <strong id="tableColIndex">1</strong> 列 宽度设置（点选单位可获得当前计算值）</label>
                        <input type="number" id="tableWidth" style="margin-right:20px;">
                        <span class="frm_radio"><label for="percent"><input type="radio" id="percent" name="openlink"/>百分比</label></span>
                        <span class="frm_radio"><label for="pixel"><input type="radio" id="pixel" name="openlink"/>像素</label></span>
                    </div>
                    <!-- 面板中的提示信息 -->
                    <div class="panel_message" id="panelMessage" style="display:none;">操作提示</div>
            </div>
        </div>
        <div class="pg_popup_ft">
            <button class="btn_submit">确认并关闭</button>&nbsp;
<!--            <button class="cancel">取消并关闭</button>-->
        </div>
    </div>
</script>

<!-- TAB设置面板内容 -->
<script id="panelTabTemplate" type="text/x-jquery-tmpl">
    <div class="pg_popup">
        <div class="pg_popup_hd"><h3>[TAB] 设置面板</h3><button class="close">&times;</button></div>
        <div class="pg_popup_cont">
            <div class="pg_popup_frm pg_popup_tab">
                <div class="fontbutton">
                    <label>文本（整体）样式</label>
                    <ul>
                        <li class="bold"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                        <li class="justifyleft"><a href="javscript:;" title="居左对齐" class="texticon"><span></span></a></li>
                        <li class="justifycenter"><a href="javscript:;" title="局中对齐" class="texticon"><span></span></a></li>
                        <li class="justifyright"><a href="javscript:;" title="居右对齐" class="texticon"><span></span></a></li>
                    </ul>
                </div>
                <div class="fontoption" style="left:70px;top:102px;display:none;" id="fontname">
                    <ul class="fontname">
                        <li style="font-family:Arial">Arial</li>
                        <li style="font-family:Tahoma">Tahoma</li>
                        <li style="font-family:Verdana">Verdana</li>
                        <li style="font-family:Comic Sans MS">Comic Sans MS</li>
                        <li style="font-family:Times New Roman">Times New Roman</li>
                        <li style="font-family:微软雅黑">微软雅黑</li>
                        <li style="font-family:宋体">宋体</li>
                        <li style="font-family:楷体">楷体</li>
                        <li style="font-family:隶书">隶书</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:100px;top:102px;display:none;" id="fontsize">
                    <ul class="fontsize">
                        <li>10</li>
                        <li>12</li>
                        <li>14</li>
                        <li>18</li>
                        <li>24</li>
                        <li>30</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:130px;top:102px;display:none;" id="fgcolor">
                    <ul class="fgcolor">
                        <li style="background:#000" data-color="#000" title="#000"></li>
                        <li style="background:#333" data-color="#333" title="#333"></li>
                        <li style="background:#666" data-color="#666" title="#666"></li>
                        <li style="background:#999" data-color="#999" title="#999"></li>
                        <li style="background:#369" data-color="#369" title="#369"></li>
                        <li style="background:#f60" data-color="#f60" title="#f60"></li>
                    </ul>
                </div>
                <div class="fontbutton">
                    <label>文本（选中）样式</label>
                    <ul>
                        <li class="bold" data-range="partial"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline" data-range="partial"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname" data-range="partial"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize" data-range="partial"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor" data-range="partial"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                        <li class="insertlink" data-range="partial"><a href="javscript:;" title="插入链接" class="texticon"><span>@</span></a></li>
                    </ul>
                </div>
                <div class="option">
                    <label>TAB 选项调整（* 选中 | 分割）</label>
                    <input type="text" id="tabContent">
                </div>
            </div>
        </div>
        <div class="pg_popup_ft">
            <button class="btn_submit">确认并关闭</button>
            <!--<button class="cancel">取消并关闭</button>-->
        </div>
    </div>
</script>

<!-- 列表设置面板内容 -->
<script id="panelListTemplate" type="text/x-jquery-tmpl">
    <div class="pg_popup">
        <div class="pg_popup_hd"><h3>[列表] 设置面板</h3><button class="close">&times;</button></div>
        <div class="pg_popup_cont">
            <div class="pg_popup_frm pg_popup_tab">
                <div class="fontbutton">
                    <label>文本（整体）样式</label>
                    <ul>
                        <li class="bold"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                        <li class="justifyleft"><a href="javscript:;" title="居左对齐" class="texticon"><span></span></a></li>
                        <li class="justifycenter"><a href="javscript:;" title="局中对齐" class="texticon"><span></span></a></li>
                        <li class="justifyright"><a href="javscript:;" title="居右对齐" class="texticon"><span></span></a></li>
                    </ul>
                </div>
                <div class="fontoption" style="left:70px;top:102px;display:none;" id="fontname">
                    <ul class="fontname">
                        <li style="font-family:Arial">Arial</li>
                        <li style="font-family:Tahoma">Tahoma</li>
                        <li style="font-family:Verdana">Verdana</li>
                        <li style="font-family:Comic Sans MS">Comic Sans MS</li>
                        <li style="font-family:Times New Roman">Times New Roman</li>
                        <li style="font-family:微软雅黑">微软雅黑</li>
                        <li style="font-family:宋体">宋体</li>
                        <li style="font-family:楷体">楷体</li>
                        <li style="font-family:隶书">隶书</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:100px;top:102px;display:none;" id="fontsize">
                    <ul class="fontsize">
                        <li>10</li>
                        <li>12</li>
                        <li>14</li>
                        <li>18</li>
                        <li>24</li>
                        <li>30</li>
                    </ul>
                </div>
                <div class="fontoption" style="left:130px;top:102px;display:none;" id="fgcolor">
                    <ul class="fgcolor">
                        <li style="background:#000" data-color="#000" title="#000"></li>
                        <li style="background:#333" data-color="#333" title="#333"></li>
                        <li style="background:#666" data-color="#666" title="#666"></li>
                        <li style="background:#999" data-color="#999" title="#999"></li>
                        <li style="background:#369" data-color="#369" title="#369"></li>
                        <li style="background:#f60" data-color="#f60" title="#f60"></li>
                    </ul>
                </div>
                <div class="fontbutton">
                    <label>文本（选中）样式</label>
                    <ul>
                        <li class="bold" data-range="partial"><a title="粗体" class="texticon" href="javscript:;"><span>B</span></a></li>
                        <li class="underline" data-range="partial"><a title="下划线" class="texticon" href="javscript:;"><span>U</span></a></li>
                        <li class="fontname" data-range="partial"><a href="javscript:;" title="字体名称"><span>Aa</span></a></li>
                        <li class="fontsize" data-range="partial"><a href="javscript:;" title="字号" class="texticon"><span>A</span></a></li>
                        <li class="fgcolor" data-range="partial"><a href="javscript:;" title="文本颜色" class="texticon"><span>A</span></a></li>
                        <li class="insertlink" data-range="partial"><a href="javscript:;" title="插入链接" class="texticon"><span>@</span></a></li>
                    </ul>
                </div>
                <div class="option">
                    <label>列表项操作</label>
                    <button type="text" id="addItem">增添一项</button>
                    <button type="text" id="removeItem">减少一项</button>
                </div>
            </div>
        </div>
        <div class="pg_popup_ft">
            <button class="btn_submit">确认并关闭</button>
            <!--<button class="cancel">取消并关闭</button>-->
        </div>
    </div>
</script>

<?php
}else if($_GET['act'] == 'preview'){
?>
<script data-main="script/main.js" src="script/require-jquery.js"></script>
<script type="text/javascript">
    /* 预览状态脚本 */
    require(["page/workshop"], function(workshop) {
        $(function() {
            workshop.preview();
        });
    });
</script>
<?php
}
?>
<?php
if(isset($_COOKIE['pg_uid']))
    echo '<script type="text/javascript">var userinfo='.getUserById($_COOKIE["pg_uid"]).'</script>';
function getUserById($userid){
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
    return json_encode($out);
}
?>