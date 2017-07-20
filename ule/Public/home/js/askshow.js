/*
 * 项目名称：悠乐1.0.1版本
 * 文件介绍：求助详情页JS效果文件
 * 开发人员：344822559@qq.com
 * 开发时间：2017-04-27
 * */


$(function(){
	
	//加载编辑框
	var ue = UE.getEditor('editor',{
					autoHeight: false,
					//wordCount:true,
					maximumWords:10000,
					initialContent:"请输入回复信息..."
				});
	
	
	/*点击回答问题按钮滚动到提交问题输入框*/
	$("#ask").on('click',function(){
		//点击按钮滚动到指定位置
		$("html,body").animate({scrollTop:($('#answer_box').offset().top)-150},1000);
		var ue = UE.getEditor('editor');
		ue.focus();
	})
	
	/*点击追加评论弹出输入框*/
	$('.ask_cimmit .add_ask').on('click',function(){
		$(this).siblings('.ask_add_answer').animate({
			opacity: 'toggle'
		},'fast');
	})
	
	/*统计添加评论字数*/
	$('.ask_cimmit .ask_add_answer .add_send').bind('change',function(){
		var nowtext=$(this).val().length;
		var max=500;
		if(nowtext>max){
			$(this).css('border','1px solid #ef8647');
			$(this).val($(this).val().substr(0,max));
			return false;
		}else{
			$(this).css('border','');
			$(this).siblings('.text_num').find('span').text(nowtext);
		}
	})


	// 添加关注问题【首先判断是否关注过，若关注则按钮变灰，若无则给ule_focus_ask添加记录】
	$('#focus').on('click',function(){
		if(!$(this).hasClass('disabled')){
			var askid=$(this).attr('name');


			layui.use(['layer'], function(){
			  var layer = layui.layer;

				$.ajax({
					type:"POST",
					url:focusURL,
					data:{askid:askid},
					success:function(msg){
						switch(msg.code){
							case 200:
							$('#focus').addClass('disabled').removeClass('btn-secondary').text('已关注');
							layer.msg(msg.msg);
							break;
							case 300:
							layer.msg(msg.msg);
							break;
							case 400:
							layer.msg(msg.msg);
							break;
							case 500:
							layer.msg(msg.msg);
							break;
							case 600:
							layer.msg(msg.msg, {
							   time: 0 //不自动关闭
							  ,btn: ['去登录', '关闭']
							  ,yes: function(index){
							    layer.close(index);
							   	location.href=loginUrl;
							  }
							});
							break;
						}

					}
				});

				});


		};
	
	})



	/*发布回答*/
	$('#add_answer').bind('click',function(){
		var askpid=$(this).attr('value');
		var hascotent=UE.getEditor('editor').hasContents();

		layui.use(['layer'], function(){
			  var layer = layui.layer;

		if (hascotent) {
			var defaultText=UE.getEditor('editor').getContentTxt();
			if (defaultText=='请输入回复信息...') {
				layer.msg('回复内容不得为空!');
				return false;
			}
			var content=UE.getEditor('editor').getContent();
				$.ajax({
					type:"POST",
					url:add_answer,
					data:{askpid:askpid,content:content},
					success:function(msg){
						console.log(msg);
						switch(msg.code){
							case 200:
							layer.msg(msg.msg);
							location.reload();
							break;
							case 400:
							layer.msg(msg.msg);
							break;
							case 600:
							layer.msg(msg.msg);
							break;
					}	}
				})



		}else{
			layer.msg('回复内容不得为空!');
			return false;

		}

		})

	})



	/*点击回答下面的回答按钮显示艾特*/
	$('.ask_add_answer').find('.answer_list .callBack').on('click',function(){
		var backName='@'+ $(this).attr('name')+' ';
		var askid=$(this).attr('data');
		$(this).parent().parent().parent().parent().find('.add_send').val(backName);
		// $(this).parent().parent().parent().parent().find('.askpid').val(askid);
	})
	

	/*添加对他说*/
	$('.ask_add_answer').find('.add_ask_answer').on('click',function(){

		var askid=$(this).siblings('.askpid').val();
		var content=$(this).siblings('.add_send').val();

		layui.use(['layer'], function(){
			  var layer = layui.layer;

		if (content=='') {
			layer.msg('回复内容不得为空！');
			return false;
		}

		$.ajax({
			type:"POST",
			url:askAnswerAdd,
			data:{pid:askid,content:content},
			success:function(msg){
				switch(msg.code){
					case 200:
					layer.msg(msg.msg);
					location.reload();
					break;
					case 400:
					layer.msg(msg.msg);
					break;
					case 600:
					layer.msg(msg.msg);
					break;
			}	}
		})

		})

	})


})