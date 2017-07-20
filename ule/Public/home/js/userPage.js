/*
 * 项目名称：悠乐1.0.1版本
 * 文件介绍：求助详情页JS效果文件
 * 开发人员：344822559@qq.com
 * 开发时间：2017-04-27
 * */


$(function(){
	
	$('.user_commit .ask_add_answer').hide();
	
	/*点击追加评论弹出输入框*/
	$('.user_commit .add_ask').on('click',function(){
		$(this).siblings('.ask_add_answer').animate({
			opacity: 'toggle'
		},'fast');
	})
	
	/*统计添加评论字数*/
	$('.user_commit .ask_add_answer .add_send').bind('input propertychange',function(){
		var nowtext=$(this).val().length;
		checkTextLength(nowtext,20,$(this).siblings('.text_num').find('span'))
	})
	
	
	/*点击回答下面的回答按钮显示艾特*/
	$('.ask_add_answer').find('.answer_list .callBack').on('click',function(){
		var backName='@'+ $(this).attr('name')+' ';
		var askid=$(this).attr('data');
		$(this).parent().parent().parent().parent().find('.add_send').val(backName);
		// $(this).parent().parent().parent().parent().find('.askpid').val(askid);
	})



	/*点击添加关注*/
	$('.add_focus').on('click',function(){

	  	var url=add_focus;
		var pid=$(this).attr('name');
		var dom_btn=$(this);

		layui.use(['layer'], function(){
			  var layer = layui.layer;
				$.post(add_focus, { pid: pid},
				   function(data){
				   	// console.info(data);
				    switch(data.state){
				    	case 300:
					    	dom_btn.attr('title','已关注此会员');
					    	dom_btn.addClass('disabled');
					    	dom_btn.text('已关注');
					    	$('.foucs_box dl').eq(0).find('dd span').text(data.fansNum)
					    	layer.msg(data.msg);
				    		break;
						default :
							layer.msg(data.msg);
							break;
				    }
				});

			})
	})



	/*发布留言*/
	$('#sendUserMessage').on('click',function(){
		var feedback_url=user_center;
		var feedback_textarea=$('.feedback_textarea').val();
		var touser=$(this).attr('name');
		layui.use(['layer'], function(){

			if (feedback_textarea=='') {
				layer.msg('留言不得为空！');
				return false;
			}

			if (feedback_textarea.length>1000) {
				layer.msg('留言字符不得大于1000！');
				return false;
			}


			$.post(feedback_url, { content:feedback_textarea,touser:touser},
				   function(data){
				   	// console.info(data);
				    switch(data.code){
				    	case 300:
					    	layer.msg(data.msg);
				    		break;
						default :
							layer.msg(data.msg);
							break;
				    }
				});



		})

	})



$(document).on('click',function(){

		
		$.post(MessageList,
			function(data){
				console.info(data);
				    
		});



});










})









/*ajax请求回答列表*/
function backMessage(curr){

    $.getJSON(backMessageUrl, {
        page: curr //向服务端传的参数，此处只是演示
    }, function(res){ // 服务器返回的 json 结果

    	switch(res.code){

    		case 200:

    		var str='';
	        for(var i = 0; i < res.lists.length; i++){

		        /*拼接的html字符串*/
		        str+="<dl>";
				str+="<a href='"+res.lists[i].memberurl+"' class='face'>";
				str+="<img src='"+res.lists[i].member_face+"'/>";
				if (res.lists[i].member_name) {
					str+="<span class='c666'>"+res.lists[i].member_name+"</span>";
				}else{
					str+="<span class='c666'>"+res.lists[i].member_email+"</span>";
				}
				str+="<span class='c-999'> 提了一个问题 - "+res.lists[i].add_time+"</span></a>";
				str+="<a class='f-16 text-l pt-10 pb-5 dis_b lh-20 c-uleblue' href='"+res.lists[i].showurl+"' target='_blank' style='margin-bottom: 0px;'>"+res.lists[i].ask_title+"</a>";
				str+="<div class='text-l c-777 f-14 lh-24 text_Hm36'>"+res.lists[i].ask_content+"</div>";
				str+="<div class='tool_box clearfix'>";

				if (res.lists[i].tags) {
					for (var a=0; a < res.lists[i].tags.length; a++) {
						str+="<a href='"+res.lists[i].tags[a].tagurl+"' class='c-999'>"+res.lists[i].tags[a].name+"</a>";
					}								
				}
				str+="<div class='read_message_box'>";
				str+="<div class='answer'><a href='#'>"+res.lists[i].ask_answer+"</a>个回答</div>";
				str+="<div class='read'><a href='#'>"+res.lists[i].ask_saw+"</a>人浏览</div>";			
				str+="	</div></div></dl>";

			}


			$('.left_help .ule_box_left').eq(2).find('#askpage').siblings().remove();
			$('.left_help .ule_box_left').eq(2).prepend(str);


	        layui.use(['laypage', 'layer'], function(){
				var laypage = layui.laypage,layer = layui.layer;

		        //显示分页
		        laypage({
		            cont: $('.left_help .ule_box_left').eq(2).find('#askpage'), // 容器
		            pages: res.allpage,     // 总页数(后台的)
		            curr: res.nowpage, //当前页(后台获取到的)
		            jump: function(obj, first){ //触发分页后的回调(单击页码后)
		                if(!first){ //点击跳页触发函数自身，并传递当前页：obj.curr
		                    backMessage(obj.curr);  // (被单击的页码)
		                }
		            }
		        });

	   		});

	        break;

	        case 400:
	        layui.use(['laypage', 'layer'], function(){
				var laypage = layui.laypage,layer = layui.layer;
			       layer.msg(res.msg);

		   		});
	        break;
    	}


    });
};



