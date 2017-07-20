/*悠乐帮添加求助问题文件*/
$(function() {

	$('#subAdd').on('click',function(){

		/*判断求助标题是否合法*/
		var title=$.trim($('#addtitle').val());
		var contentText=$.trim(getContent());
		var tags=$.trim($('#tags').val());

		layui.use(['layer'], function(){
			  var layer = layui.layer;
			  
			  

			  
			if (title==''||title.length<5||title.length>50) {
				layer.msg('标题不得为空,并且字数限制在5至50个字符以内!');
				return false;
			}

			if (contentText=='请输入详细求助信息...'||contentText=='') {
				layer.msg('求助详细信息不得为空!');
				return false;
			}
			
			$.ajax({
				type:"POST",
				url:addPost,
				data:{title:title,contentText:contentText,tags:tags},
				success:function(msg){
					// console.log(msg);
					switch(msg.code){
						case 200:
						// parent.location.reload();//刷新父页面
						parent.location.href=msg.askIndex;
						product_close();
						break;
						case 400:
						layer.msg(msg.msg);
						break;
						case 500:
						layer.msg(msg.msg);
						break;
						case 300:
						layer.msg(msg.msg);
						break;
						case 600:
						layer.msg(msg.msg);
						location.href=IndexPage;
						break;

					}

				}
			});
		})
		
	})






})
// 获得带格式的文本内容
function getContent() {
    var arr = [];
    arr.push(UE.getEditor('editor').getContent());
    return arr
}

// 获得带格式的纯文本内容
 function getPlainTxt() {
        var arr = [];
        arr.push(UE.getEditor('editor').getPlainTxt());
        return arr
 }

// 判断编辑器是否有内容
 function hasContent() {
    var arr = [];
    arr.push(UE.getEditor('editor').hasContents());
    alert(arr);
    return arr
}

/*关闭layer层*/
function product_close(){
	var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
	parent.layer.close(index); //再执行关闭 
}