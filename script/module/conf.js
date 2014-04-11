/**
 * @desc: 通用设置
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-12-07
 */

define(function(){

    var _CONF = {};

        /* Cookie：用户名 */
        _CONF.COOKIE_USERNAME = 'pg_uname';

        /* 站点首页地址 */
        _CONF.PAGE_DEFAULT = 'channel-list.php';

        /* 登陆页地址 */
        _CONF.PAGE_LOGIN = 'login.php';

        /*注销页地址 */
        _CONF.PAGE_LOGOUT = 'oa_logout.php';

        /* 基础 api 地址 */
        _CONF.API = 'inc/handler.php';

        /* 模块内容是否双击后可编辑 */
        _CONF.IS_CONTENT_EDITABLE = true;

        /* 自动保存时间间隔 */
        _CONF.AUTO_SAVE_INTERVAL = 1000*60*5;

        /* 组件通用标识 */
        _CONF.ATTR_COMMON = 'data-pg';

        /* 组件id标识 */
        _CONF.ATTR_MOD_ID = 'data-id';

        /* 组件类型标识 */
        _CONF.ATTR_MOD_TYPE = 'data-type';

        /* 标识组件类型的属性值 */
        _CONF.ATTR_VALUE_MOD_TYPE_TEXT = 'text';
        _CONF.ATTR_VALUE_MOD_TYPE_IMAGE = 'image';
        _CONF.ATTR_VALUE_MOD_TYPE_LINK = 'link';
        _CONF.ATTR_VALUE_MOD_TYPE_TABLE = 'table';
        _CONF.ATTR_VALUE_MOD_TYPE_TAB = 'tab';
        _CONF.ATTR_VALUE_MOD_TYPE_LIST = 'list';

        /* 集合成数组，方便使用 */
        _CONF.ATTR_VALUE_MOD_TYPE_ARRAY = [
            _CONF.ATTR_VALUE_MOD_TYPE_TEXT,
            _CONF.ATTR_VALUE_MOD_TYPE_IMAGE,
            _CONF.ATTR_VALUE_MOD_TYPE_LINK,
            _CONF.ATTR_VALUE_MOD_TYPE_TABLE,
            _CONF.ATTR_VALUE_MOD_TYPE_TAB,
            _CONF.ATTR_VALUE_MOD_TYPE_LIST
        ];

        /* 标识模板的可拖放区域 */
        _CONF.ATTR_VALUE_TEMPLATE_DROPPABLE = 'layout';

        /* 标识组件的属性值 */
        _CONF.ATTR_VALUE_MOD = 'md';

        /* 标识组件的可拖放区域的属性值 */
        _CONF.ATTR_VALUE_MOD_DROPPABLE = 'md-container';

        /* 标识组件的可重复区域的属性值 */
        _CONF.ATTR_VALUE_MOD_REPEATABLE = 'repeatable';

        /* 预览用 IFRAME */
        _CONF.SELECTOR_PREVIEW_FRAME = '#preview';

        /* 可拖动组件的外层容器 */
        _CONF.SELECTOR_MOD_WRAP = '.mod_wrap';

        /* 当前选中组件样式 */
        _CONF.SELECTOR_MOD_CURRENT = '.md_cur';
        _CONF.CLASSNAME_MOD_CURRENT = 'md_cur';

        /* 模板的可编辑区域 */
        _CONF.SELECTOR_TEMPLATE_DROPPABLE = '['+_CONF.ATTR_COMMON+'="'+_CONF.ATTR_VALUE_TEMPLATE_DROPPABLE+'"]';

        /* 组件的选择器 */
        _CONF.SELECTOR_MOD = '['+_CONF.ATTR_COMMON+'="'+_CONF.ATTR_VALUE_MOD+'"]';

        /* 组件的可嵌套区域选择器 */
        _CONF.SELECTOR_MOD_DROPPABLE = '['+_CONF.ATTR_COMMON+'="'+_CONF.ATTR_VALUE_MOD_DROPPABLE+'"]';

        /* 标识组件的可重复区域的选择器 */
        _CONF.SELECTOR_MOD_REPEATABLE = '['+_CONF.ATTR_COMMON+'="'+_CONF.ATTR_VALUE_MOD_REPEATABLE+'"]';

        /* 可重复组件当前项的选择器数组 */
        _CONF.SELECTOR_MOD_REPEATABLE_CURRENT_ARRAY = ['on', 'cur', 'current'];

    return _CONF;
});