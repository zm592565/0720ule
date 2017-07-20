/*
 * 项目名称：悠乐注册成功之后晚上资料页面
 * 文件介绍：JS效果文件
 * 开发人员：344822559@qq.com
 * 开发时间：2017-05-06
 * */


$(function(){

	/*完善资料*/
	$('#addface').on('click',function(){

		var ename=$('input[name="ename"]').val();
		var selcountry=$('select[name="selcountry"]').val();
		var selstate=$('select[name="selstate"]').val();
		var selcity=$('select[name="selcity"]').val();
		var open=$('#checkoff').val();
		 layui.use(['layer'], function(){
		 	var layer=layui.layer;
		 	if (ename.length>20) {
		 		layer.alert('昵称不得超过20个字符！',{
		 			btnAlign:'c',
		 			contentAlign:'c',
		 			title:'提示'
		 		});
		 		return false;
			}

		

		 /*提交数据*/
		$.ajax({
			type:"POST",
			url:localurl,
			data:{ename:ename,selcountry:selcountry,selstate:selstate,selcity:selcity,open:open},
			async:true,
			success:function(msg){
				switch(msg.code){
					case 200:
						location.href=lastFoot;
						break;
					case 400:
						layer.msg(msg.msg);
						break;	

				}

			}
		});


	 })	



	})




})


function changeImg(){

	 	var strs = new Array(); //定义一数组
        var pic1= $('input[name="file_face"]').val();
        strs = pic1.split('.');
        var suffix = strs [strs .length - 1];
        layui.use(['layer'], function(){
            	var layer=layui.layer;

        if (suffix != 'jpg' && suffix != 'gif' && suffix != 'jpeg' && suffix != 'png') {
            
            	layer.alert('请上传正确的图片类型！',{
            		btnAlign:'c',
            		title:'警告'
            	});
            	return false;
           
            
        }else{

        /*上传图片*/
        var formData = new FormData($( "#uploadForm" )[0]); 

            $.ajax({
                url: loadfaceImg,
                type: "POST",
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                success:function(msg){
                	switch(msg.code){
						case 200:
							$('#imghead').attr('src',msg.bigimg);
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
							 layer.msg(msg.msg);
							break;
						case 700:
							layer.msg(msg.msg);
							break;
						case 800:
							layer.msg(msg.msg);
							break;
						case 900:
							layer.msg(msg.msg);
							break;
						case 1000:
							layer.msg(msg.msg);
							break;

					}


                }
            });

        	

        }
    })
} 




function checkArea(obj,type){

	countryid=$(obj).val();
	var selectName=$(obj).attr('name');
	var countryid=Number(countryid);

	 	$.ajax({
		type:"POST",
		url:getBack,
		dataType:'json',
		data:{id:countryid,type:type},
		success:function(data){
			//console.log(data)
			if (data.type=='state') {
				switch(data.status){
					case 300:
					var html='';
					for (var i=0; i < data.content.length; i++) {
						html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
					}
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().show();
					$('select[name="selcity"]').append(html);
					break;

					default :
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().hide();
				}

				return ;
			}

			switch(data.status){
				case 200:
				var html='';
				
				for (var i=0; i < data.content.length; i++) {
					html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
				}

				var cityHtml='';
				if (data.city.length) {

					for (var i=0; i < data.city.length; i++) {
						cityHtml+='<option value="'+data.city[i].id+'">'+data.city[i].name+'</option>';
					}

				}else{
					cityHtml='<option value="0">没有城市信息</option>';
				}

				$('select[name="selstate"]').parent().show();
				$('select[name="selstate"]').empty();
				$('select[name="selcity"]').empty();
				$('select[name="selstate"]').append(html);
				$('select[name="selcity"]').append(cityHtml);
				break;

				case 300:

				if (selectName=='selstate') {
					var html='';
					for (var i=0; i < data.content.length; i++) {
						html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
					}
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().show();
					$('select[name="selcity"]').append(html);
					
				}else{

					var html='';
					for (var i=0; i < data.content.length; i++) {
						html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
					}
					$('select[name="selstate"]').empty();
					$('select[name="selstate"]').parent().hide();
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().show();
					$('select[name="selcity"]').append(html);
					
				}
				break;
				
				default :
      			$('select[name="selstate"]').empty();
				$('select[name="selcity"]').empty();
				$('select[name="selstate"]').parent().hide();
				$('select[name="selcity"]').parent().hide();

			}


		}

		
	})

}