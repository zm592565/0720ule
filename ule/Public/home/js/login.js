/*
 * 项目名称：悠乐登录
 * 文件介绍：JS效果文件
 * 开发人员：344822559@qq.com
 * 开发时间：2017-04-08
 * */

$(function(){


	/*js验证登录邮箱格式*/
	$("input[name='user']").change(function(){
		checkLoginData('user',$(this).val(),'请输入正确的邮箱地址',"#forgetPassword");
	})

	/*js验证登录密码格式*/
	$("input[name='password']").change(function(){
		checkLoginData('password',$(this).val(),'密码必须是6-15位的字母、数字、_组成！',"#forgetPassword");
	})


	/*验证通过登录*/
	$('.login_btn').on('click',function(){

		var userVal=$("input[name='user']").val();
		var passwordVal=$("input[name='password']").val();
		var user=checkLoginData('user',userVal,'请输入正确的邮箱地址',"#forgetPassword");
		if (!user) {
			return false;
		}

		var password=checkLoginData('password',passwordVal,'密码必须是6-15位的字母、数字、_组成！',"#forgetPassword");
		if (!password) {
			return false;
		}
		
		if (user&&password) {
			$.ajax({
				type:"POST",
				url:urlLocal,
				data:{user:userVal,password:passwordVal},
				success:function(msg){
					switch(msg.code){
						case 200:
						//layer.msg(msg.msg);
						location.href=websiteUrl;
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

					}

				}
			});

		}

	})


	// 注册页面JS验证

	/*用户协议是否选中*/
	var userInstructions=false;
	$('input[name="userInstructions"]').on('click',function(){
		userInstructions=$(this).is(':checked');
	})

	/*js验证注册邮箱格式*/
	$("input[name='email']").change(function(){
		var Regemail=checkLoginData('user',$(this).val(),'请输入正确的邮箱地址',"#userInstructions");

		if (Regemail) {
			$RegVal=$("input[name='email']").val();
			/*调用底部方法验证邮箱是否已经被注册*/
			checkEmailHave($RegVal,checkRegEmail);

		}else{
			return false;
		}


	})
	
	/*js验证注册密码格式*/
	$("input[name='pass']").change(function(){
		return checkLoginData('password',$(this).val(),'密码必须是6-15位的字母，数字或者下划线组成',"#userInstructions");
	})

	/*js验证注册确认密码格式*/
	$("input[name='surepass']").change(function(){
		var pass=$("input[name='pass']").val();
		var surepass=$(this).val();
		$message="输入密码不一致，请检查后重新输入！";
		if (pass!=surepass) {
			
			IsHaveAlert($message)
			return false;

		}

		return checkLoginData('password',surepass,'密码必须是6-15位的字母，数字或者下划线组成',"#userInstructions");	

	})


	/*提交数据*/
	$('.reg_btn').on('click',function(){

		var emailVal=$("input[name='email']").val();
		var surepassVal=$("input[name='surepass']").val();
		var passVal=$("input[name='pass']").val();

		/*js验证注册邮箱格式*/
		var email=checkLoginData('user',emailVal,'请输入正确的邮箱地址',"#userInstructions");
		if (!email) {
			return false;
		}else{
			/*验证邮箱是否被注册*/
			var EmailHave=checkEmailHave(emailVal,checkRegEmail);
			if (!EmailHave) {
				return false;
			}
		}

		/*js验证注册密码格式*/
		var pass=checkLoginData('password',passVal,'密码必须是6-15位的字母，数字或者下划线组成',"#userInstructions");
		if (!pass) {
			return false;
		}


		/*js验证注册确认密码格式*/
		var surepass=checkLoginData('password',surepassVal,'确认密码必须是6-15位的字母，数字或者下划线组成',"#userInstructions");
		if (!surepass) {
			return false;
		}

		
		var $message="输入密码不一致，请检查后重新输入！";
		if (passVal!=surepassVal) {
			
			IsHaveAlert($message)
			return false;

		}

		if (!userInstructions) {
			layer.msg('请您阅读用户协议并同意！', {
			    time: 2000//20s后自动关闭
			});
			return false;
		}


		/*提交数据*/
		$.ajax({
				type:"POST",
				url:regUrl,
				data:{email:emailVal,pass:passVal,surepass:surepassVal},
				success:function(msg){
					switch(msg.code){
						case 200:
						/*弹出一个iframe层*/
						var UrlIndex=msg.index;
						layer.open({
						  type: 2,
						  title: false,
						  closeBtn:true,
						  shadeClose: false,
						  shade: 0.8,
						  anim:2,
						  scrollbar:false,
						  area: ['400px', '550px'],
						  content: checkFrist, //iframe的url
						  cancel:function(){
						  	alert('跳转到个人中心，让会员完善资料，目前没有个人中心让跳转到首页');
						  	parent.location.href=UrlIndex;//注册成功跳到个人中心让他完善资料
						  }
						}); 

						break;
						case 400:
						layer.msg(msg.msg);
						break;
						case 500:
						layer.msg(msg.msg);
						break;

					}

				}
			});


	})






});


function checkLoginData($type,$str,$message,$id){

	var user = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; //验证邮箱的正则表达式
	var password=/^[0-9a-zA-Z_]{6,15}$/;//密码必须是6-15位的字母，数字或者下划线组成
	var pattern='';
	var warning='<div class="Huialert Huialert-danger">'+$message+'</div>';
	var is_show=true;

	if($('.Huialert').length && $('.Huialert').length>0) {
		is_show=false;
	}

	switch($type){
		case 'user':
		pattern=user;
		break;
		case 'password':
		pattern=password;
		break;

	}


	if(!pattern.test($str))
    {
    	if (is_show) {
    		$($id).after(warning);
    	}else{
    		$('.Huialert').text($message);    	
   		}
       return false;
    }else{
    	$('.Huialert').remove();
    	return true;
    }



};



/*注册页面弹出用户注册协议*/
function alertPage($str){

	// 用户须知
	var userInstructions="欢迎您来到悠乐地接(u-le.net)!</br>";
		userInstructions+="　　悠乐地接在此为您提供各项服务的同时，谨此提示您需认真仔细阅读本法律声明的各项条款，并及时关注本法律声明的任何变化。在此感谢您的支持和配合。</br>";
		userInstructions+="　　悠乐地接（www.u-le.net），所有刊登内容，以及所提供的信息资料，目的是为了更好地服务您，悠乐地接不保证所有信息、文本、图形、链接及其它项目的绝对准确性和完整性，仅供您参照使用。在网站SNS社区中，您发表的文章或图片仅代表作者本人观点，与本网站立场无关，作者文责自负。</br>";
		userInstructions+="　　网站会员之间通过本网站相识、交往中所发生或可能发生的任何心理、生理上的伤害和经济上的损失，本网站不承担任何责任。会员因为违反本社区规定而触犯中华人民共和国法律的，责任自负，本网站不承担任何责任。由于非故意及不可抗拒的原因（含系统维护和升级），导致的用户数据丢失、服务暂停或停止，本网站不承担赔偿及其他连带的法律责任。</br>";
		userInstructions+="　　如您（单位或个人）认为本网站某部分内容有侵权嫌疑，敬请立即通知我们，我们将在第一时间予以更改或删除。</br>";
		userInstructions+="　　凡以任何方式登陆网站或直接、间接使用本网站资料者，视为自愿接受本网站声明的约束。本声明未涉及的问题参见国家有关法律法规，当本声明与国家法律法规冲突时，以国家法律法规为准。</br>";
		userInstructions+="©版权所有2009-2010，悠乐地接(u-le.net)</br>";
		userInstructions+="未经悠乐地接书面特别授权，请勿转载或建立镜像，违者依法必究</br>";
	if ($str=='') {
		$pageHtml=userInstructions;
	}else{
		$pageHtml=$str;
	}

	layer.open({
	  type: 1,
	  skin: 'reg-class',
	  title:false,
	  shade:0.5,
	  area: ['550px', '400px'], //宽高
	  content: $pageHtml
	});

}


/*验证邮箱是否已经被注册*/
function checkEmailHave($email,$posturl){

	var hasEmail=false;
	/*提交数据*/
	$.ajax({
			type:"POST",
			url:$posturl,
			data:{email:$email},
			async:false,
			success:function(msg){

				switch(msg.code){
					case 200:
					 //layer.msg(msg.msg);
					// location.href='http://www.baidu.com';
						hasEmail=true;
						break;
					case 300:
						IsHaveAlert(msg.msg);	
						break;
					case 400:
						IsHaveAlert(msg.msg);
						break;

				}

			}
		});

	return hasEmail;
}


/*验证页面是否有警示框*/
function IsHaveAlert($msg){

	if($('.Huialert').length && $('.Huialert').length>0) {
		$('.Huialert').text($msg);
	}else{
		var warning='<div class="Huialert Huialert-danger"><i class="icon-remove"></i>'+$msg+'</div>';
		$('#userInstructions').after(warning);
	}


}
