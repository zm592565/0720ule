$(function(){

	//后台登陆验证
	$('#login_action').submit(function(){

		//验证用户名：4-22位必须是英文数字 下划线的组合
		var user=$('input[name="username"]').val();
		if(!/^[0-9a-zA-Z_-]+$/.test(user)){
			
			var text='账号格式不对,请重新输入.';

			layer.tips(text, '#input_user', {
			  tips: [1, '#42c5bd'] //还可配置颜色
			});

			return false;

		}


		//验证码验证
		var code=$('input[name="code"]').val();
		if (!/^([0-9]|[a-z]|[A-Z]){4}$/.test(code)) {

			var text='验证码格式有误,请重新输入.';

			layer.tips(text, '.code', {
			  tips: [1, '#42c5bd'] //还可配置颜色
			});

			return false;		

		}


		return true;

	});

	

})
