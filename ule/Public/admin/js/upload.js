$(function(){

	var inputHeight=243;
	var layerIframe=200;

	$('#upload').on('click',function(){

		var uploadurl=$('input[name="uploadurl"]').val();
		layer.open({
		  type: 2,
		  title: '上传缩略图',
		  shadeClose: true,
		  shade: 0.8,
		  area: ['500px', inputHeight+'px'],
		  content: uploadurl //iframe的url
		}); 

	})
	

	//upload上传图片页面点击增加上传input
	$('.btn_upload_add').click(function(){

		var uploadHtml='<div  class="cl text-c row upimg_input">\n'+
				'<span class="btn-upload form-group">\n'+
				  '<input class="input-text upload-url radius" type="text" name="uploadfile-1" id="uploadfile-1" readonly>\n'+
				  '<a href="javascript:void();" class="btn btn-primary radius" style="height: auto">浏览文件</a>\n'+
				  '<input type="file" multiple name="photo[]" class="input-file">\n'+
				'</span>\n'+
			'</div>';

		$('#upload_form .upimg_input:last').after(uploadHtml);

		inputHeight+=46;
		layerIframe+=46;
		$(".layui-layer-iframe", parent.document).css('height',inputHeight+'px');
		$(".layui-layer-content iframe", parent.document).css('height',layerIframe+'px');

	})



})



	//因为需要上传之后关闭弹窗，所以需要异步加载
	function ajaxUpload(){

		var id='#upload';//需要添加的id
		var url=$('#upload_form').attr('action');
		var formData = new FormData($( "#upload_form" )[0]);

		$.ajax({
			url: url,  
	        type: 'POST',  
	        data: formData,  
	        async: false,  
	        cache: false,  
	        contentType: false,  
	        processData: false,
	        success: function (returndata) {


	        	if (returndata.state==0) {

	          		 parent.layer.msg(returndata.content, {icon: 5,time:1000});
					 return false;

	          	}else{

	          		console.log(returndata);


	          		/*添加隐藏的大图*/
	          		// $big='<input type="hidden" name="big" value="'+returndata.path+'"/>';
	          		// // $(window.parent.document.body).find(id).after($big);
	          		// $(window.parent.document.body).find(id).append("<b>Hello</b>");
	          		


	          		//因为我们返回的上传成功的图片地址有可能是个数组，所以要在jq里进行数组遍历然后赋值给生成的input
	          		$.each(returndata.url,function(n,value) {

	          				$str='<p class="pt-5"><input class="input-text" name="photo[]" value="'+value+'"/></p>';

	          				//给父级栏目里添加几个input网址
	          			 	var a=$(window.parent.document.body).find(id).after($str);
           					
           			})

	          		parent.layer.msg(returndata.content, {icon: 6,time:1000});           
	            	var index = parent.layer.getFrameIndex(window.name);	 
					parent.layer.close(index);

	          	}




	        }
		})



	}