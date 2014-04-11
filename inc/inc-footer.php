<!--S footer -->
<div class="pg_footer">
    <div class="copyright">
        <p>Copyright © 1998-2012 Tencent Inc. All Rights Reserved.</p>
        <p>Powered & Designed by ECD.</p>
    </div>
</div>
<!--E footer -->
<!--S 返回顶部 -->
<a href="#" type="button" class="go_top off_screen" id="goTop"><i></i></a>
<script type="text/javascript">
var ScrollToTop=ScrollToTop||{
	setup:function(){
		var a=$(window).height()/2;
		$(window).scroll(function(){
			(window.innerWidth?window.pageYOffset:document.documentElement.scrollTop)>=a?$("#goTop").removeClass("off_screen"):$("#goTop").addClass("off_screen")
		});
		$("#goTop").click(function(){
			$("html, body").animate({scrollTop:"0px"},400);
			return false
		})
	}
};
</script>
<script type="text/javascript">
$(document).ready(function(){
	ScrollToTop.setup();
});
</script>
<?php
    require_once("conn.php");
    require_once("global_func.php");

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
<!--E 返回顶部 -->