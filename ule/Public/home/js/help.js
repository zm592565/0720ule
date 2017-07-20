/*
 * 项目名称：悠乐帮助中心
 * 文件介绍：JS效果文件
 * 开发人员：344822559@qq.com
 * 开发时间：2017-04-11
 * */

$(function(){

	// 默认第一个侧边栏的数据要预加载
	$('.help_menu ul li:first-child').addClass('active');
	
	/*提交数据*/
	$.ajax({
				type:"POST",
				url:PageUrl,
				data:{id:$('.help_menu ul li:first-child').attr('id')},
				success:function(msg){
					switch(msg.code){
						case 200:
							$('.help_content .content').text();
							$('.help_content .content').empty();
							$('.help_content p').text(msg.title);
							$('.help_content .content').html(msg.content);
							break;
						case 400:
							$('.help_content .content').text();
							$('.help_content .content').empty();
							$('.help_content p').text(msg.title);
							$('.help_content .content').html(msg.content);
							break;
						 default:
							alert('暂无数据');
							break;
					}

				}
		});






	$('.help_menu ul li').on('click',function(){
		$(this).addClass('active').siblings().removeClass('active');
		$id=$(this).attr('id');
		/*提交数据*/
		$.ajax({
				type:"POST",
				url:PageUrl,
				data:{id:$id},
				success:function(msg){
					console.log(msg);
					switch(msg.code){
						case 200:
							$('.help_content .content').text();
							$('.help_content .content').empty();
							$('.help_content p').text(msg.title);
							$('.help_content .content').html(msg.content);
							break;
						case 400:
							$('.help_content .content').text();
							$('.help_content .content').empty();
							$('.help_content p').text(msg.title);
							$('.help_content .content').html(msg.content);
							break;
						 default:
							layer.msg('暂无数据...');
							break;
					}

				}
			});

	})

})