/**
 * @desc: 模块管理页面脚本
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-11-19
 */

define(['../module/util', '../module/user', '../module/template'], function(util, user, template){
    return {

        /* 初始化 */
        init: function(){
            var ch_id = util.param('ch_id');

            // 为新建布局传入频道id
            $('#btn_add_template').attr('href', $('#btn_add_template').attr('href')+'&ch_id='+ch_id);
            $('#btn_back').attr('href', $('#btn_back').attr('href')+'&ch_id='+ch_id);

            template.listByChannel(ch_id, '#templateListTemplate','#templateList', function(){

                $('li:not(.item)').hover(function(){
                    this.className='on';
                },function(){
                     this.className='';
                });

                $('.ico_edit').click(function(){
                    location.href=$(this).attr("data-url");
                });

                $('.ico_delete').click(function(){
                    var id=$(this).attr('data-id');
                    if(id !='' && confirm('确定要删除吗？')){
                        var item = $(this).parents('li');
                        template.delete(id,function(data){
                            if(data==1) item.remove();
                        })
                    }
                });

            });
        }

    }
});