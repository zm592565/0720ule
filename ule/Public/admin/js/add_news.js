$(function(){
	
	//提交表单
	$('#submit').click(function(){
		
		var title=$('input[name="title"]').val();
		var copyfrom=$('input[name="copyfrom"]').val();
		var content=getPlainTxt();
		var digest=$('textarea[name="digest"]').val();
		var keyword=$('input[name="keyword"]').val();

		if (title=='') {
			layer.alert('标题不得为空');
			return false;
		}

		if (digest==''&&digest.length<10) {
			layer.alert('摘要不得为空,并且不得小于10个字符');
			return false;
		}


		if (!hasContent()) {
			layer.alert('内容不得为空');
			setFocus();
			return false;
		}

		return true;

	})





})






function getPlainTxt() {
    var arr = [];
    arr.push(UE.getEditor('editor').getPlainTxt());
    return arr;
}

function setFocus() {
    UE.getEditor('editor').focus();
}

 function hasContent() {
    return UE.getEditor('editor').hasContents();
}