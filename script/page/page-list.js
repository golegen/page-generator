/**
 * @desc: 页面列表页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-20
 */

define(['jquery', '../module/util', '../module/user', '../module/page'], function($, util, user, page){
    return {

        /* 初始化 */
        init: function(){

            user.setAsAdminOpt('#templateListWrap');

            var ch_id = util.param('ch_id');

            /* 为新建页面传入频道id */
            $('#btn_add_page').attr('href', $('#btn_add_page').attr('href')+'&ch_id='+ch_id);
            $('#templateList').attr('href', $('#templateList').attr('href')+'&ch_id='+ch_id);
            $('#moduleList').attr('href', $('#moduleList').attr('href')+'&ch_id='+ch_id);
            $('#btn_back').attr('href', $('#btn_back').attr('href')+'&ch_id='+ch_id);

            /* 拉取该频道下全部页面 */
//            page.listByChannel(ch_id, '#pageListTemplate', '#pageList', function(){
            page.listByUserByChannel(user.getUserName(),util.param('ch_id'), '#pageListTemplate', '#pageList', function(){

                /* 删除页面 */
                $('.ico_delete').click(function(){
                    if($(this).attr('data-id') !== '' && window.confirm('确定要删除？')){
                        var item =  $(this).parents('li');
                        page.remove($(this).attr('data-id'), function(){
                            item.remove();
                        });
                    }
                });

                /* 编辑页面 */
                $('.ico_edit').click(function(){
                    if($(this).attr('data-id') !== ''){
                        location.href = './page-edit.php?act=update&ch_id='+ch_id+'&page_id='+$(this).attr('data-id');
                    }
                });

                $('li:not(.item)').hover(function(){
                    this.className='on';
                },function(){
                     this.className='';
                });

                $('.list_page li>a').click(function(){
                    $("#pg_dialog").show();
                    $("#pg_dialog iframe").attr("src",this.href).blur();
                    $(".pg_dialog_close").click(function(){
                        $("#pg_dialog").hide();
                    });

                    var id=$(this).attr('data-id');
                    var channel=$(this).attr('data-channel');

                    $('#btn_download').click(function(){
                         location.href='inc/handler.php?act=createPageById&id='+id;
                         return false;
                    });
                    
                    $('#btn_edit').click(function(){
                         location.href='workshop.php?act=update&page_id='+id+'&ch_id='+channel;
                         return false;
                    });

                    $('#btn_share').click(function(){
                        location.href='share.php?page_id='+id+'&ch_id='+channel;
                        return false;
                    });
                    
                    return false;
                });

            });

        }

    }
});