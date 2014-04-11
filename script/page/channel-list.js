/**
 * @desc: 模块管理页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-19
 */

define(['../module/user', '../module/channel'], function(user, channel){
    return {

        /* 初始化 */
        init: function(){
            /* 高级选项 */
            user.setAsAdminOpt('#addChannel');

            channel.list('#channelListTemplate','#channelList', function(){

                user.setAsAdminOpt('.ico_edit, .ico_delete');

                /* 编辑频道 */
                $('.ico_edit').click(function(){
                    if($(this).attr('data-id') !== ''){
                        location.href = './channel-edit.php?act=update&ch_id='+$(this).attr('data-id');
                    }
                });

                /* 删除频道 */
                $('.ico_delete').click(function(){
                    var id=$(this).attr('data-id');
                    if(id !='' && confirm('确定要删除吗？')){
                        var item = $(this).parents('li');
                        channel.delete(id,function(data){
                            if(data==1) item.remove();
                        })
                    }
                });

                $('li:not(.item)').hover(function(){
                    this.className='on';
                },function(){
                     this.className='';
                });
            });
        }

    }
});