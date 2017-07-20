/*悠乐帮js文件*/

$(function(){


	/*问题tab切换效果*/
	$('.left_help ul.nav_top li').on('click',function(){

		$(this).addClass('active').siblings().removeClass('active');

		$('.left_help .ule_box_left').eq($(this).index()).addClass('ule_box_left_active').siblings().removeClass('ule_box_left_active');

	})


	/*发布提问弹窗*/
	$('#send_help,#send_box').bind('click',function(){

		/*点击之后判断是否登录，登录就弹出发布*/
		if (loginIS) {

			layui.use(['layer'], function(){
			  var layer = layui.layer;
			  
			  	layer.open({
				  type: 2,
				  title: '发布求助问题',
				  closeBtn: true, //不显示关闭按钮
				  shade: [0.8],
				  area: ['600px', '480px'],
				  //offset: 'rb', //右下角弹出
				  //time: 2000, //2秒后自动关闭
				  anim: 2,
				  content: [addUrl, 'no'], //iframe的url，no代表不显示滚动条
				});


			});


			

		}else{

			/*未登录状态，返回到登录页面*/
			location.href=loginUrl;

		}
		
	})



	/*搜索查询*/
	$('#search_btn').on('click',function() {

		var searchValue=$('#search_v').val();
			$.ajax({
				type:"POST",
				url:searchAsk,
				dataType:'json',
				data:{title:searchValue},
				success:function(data){
					//console.log(data);
				}
			})

	})


})



/*加载热门求助,一次性请求所有数据然后在使用js分页，这里只需要在需要加载的地方调用这个方法*/
function addAjaxLoad(obj){

	var TabIndex=$(obj).index();

	$.ajax({
		type:"POST",
		url:hotHelp,
		dataType:'json',
		success:function(msg){

			layui.use(['laypage', 'layer'], function(){

			var laypage = layui.laypage,layer = layui.layer;

			switch(msg.code){
				case 200:

				var nums = msg.pagesize; //每页出现的数据量
				var pages = Math.ceil(msg.data.length/nums); //得到总页数

				//模拟渲染
				  var render = function(curr){
				    //此处只是演示，实际场景通常是返回已经当前页已经分组好的数据
				    var str = '', last = curr*nums - 1;
				    last = last >= msg.data.length ? (msg.data.length-1) : last;

				    for(var i = (curr*nums - nums); i <= last; i++){


				    	str+="<dl>";
						str+="<a href='"+msg.data[i].memberid+"' class='face'>";
						str+="<img src='"+msg.data[i].member_face+"'/>";
						str+="<span class='c666'>"+msg.data[i].member_name+"</span>";
						str+="<span class='c-999'> 提了一个问题 - "+msg.data[i].add_time+"</span></a>";
						str+="<a class='f-16 text-l pt-10 pb-5 dis_b lh-20 c-uleblue' href='"+msg.data[i].showurl+"' style='margin-bottom: 0px;'>"+msg.data[i].ask_title+"</a>";
						str+="<div class='text-l c-777 f-14 lh-24 text_Hm36'>"+msg.data[i].ask_content+"</div>";
						str+="<div class='tool_box clearfix'>";

						if (msg.data[i].tags) {
							for (var a=0; a < msg.data[i].tags.length; a++) {
								str+="<a href='javascript:;' class='c-999'>"+msg.data[i].tags[a].name+"</a>";
							}								
						}
						str+="<div class='read_message_box'>";
						str+="<div class='answer'><a href='#'>"+msg.data[i].ask_answer+"</a>个回答</div>";
						str+="<div class='read'><a href='#'>"+msg.data[i].ask_saw+"</a>人浏览</div>";			
						str+="	</div></div></dl>";

				    }
				    return str;
				  };
					//调用分页
				  laypage({    
				    cont: $("#askpage"),
				    pages: pages, //得到总页数
				    jump: function(obj){
				    	// console.info(obj.curr);
				      	var htmlSection  =render(obj.curr);

						$('.left_help .ule_box_left').eq(TabIndex).find('#askpage').siblings().remove();

						$('.left_help .ule_box_left').eq(TabIndex).prepend(htmlSection);

				    }
				  });


				break;
				case 400:
				layer.msg(msg.msg)
				break;
				

			} //end switch

		});		 

		}
	});

}




/*实际使用点击加载热门求助分页数据，只加载所需的当前页的数据*/
function HotAsk(curr){
    $.getJSON(hotHelp, {
        page: curr //向服务端传的参数，此处只是演示
    }, function(res){ // 服务器返回的 json 结果
    	//console.trace(res);
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



			$('.left_help .ule_box_left').eq(1).find('#askpage').siblings().remove();
			$('.left_help .ule_box_left').eq(1).prepend(str);


	        layui.use(['laypage', 'layer'], function(){
				var laypage = layui.laypage,layer = layui.layer;

		        //显示分页
		        laypage({
		            cont: $('.left_help .ule_box_left').eq(1).find('#askpage'), // 容器
		            pages: res.allpage,     // 总页数(后台的)
		            curr: res.nowpage, //当前页(后台获取到的)
		            jump: function(obj, first){ //触发分页后的回调(单击页码后)
		                if(!first){ //点击跳页触发函数自身，并传递当前页：obj.curr
		                    HotAsk(obj.curr);  // (被单击的页码)
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



/*实际使用点击加载待回复求助分页数据，只加载所需的当前页的数据*/
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