<?php /* Smarty version Smarty-3.1.6, created on 2017-07-19 15:33:54
         compiled from "./Application/Home/View/default\Login\reg.html" */ ?>
<?php /*%%SmartyHeaderCode:15896596f0b6210b673-12140986%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b457735e9af8edc41dc8f8d190f602bea2ddee7' => 
    array (
      0 => './Application/Home/View/default\\Login\\reg.html',
      1 => 1494060538,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15896596f0b6210b673-12140986',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'css' => 0,
    'js' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f0b621c96e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f0b621c96e')) {function content_596f0b621c96e($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<title>悠乐-感谢一路有你。</title>
		<!--[if lt IE 9]>
		<script type="text/javascript" src="lib/html5.js"></script>
		<link href="css/H-ui/H-ui.ie.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="lib/respond.min.js"></script>
		<script type="text/javascript" src="lib/PIE_IE678.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="<?php echo @HOME_CSS_PATH;?>
H-ui/H-ui.min.css" />
		<script type="text/javascript" src="<?php echo @COMMON_JS_PATH;?>
jquery-1.11.2.min.js" ></script>
		<script type="text/javascript" src="<?php echo @HOME_LIB_PATH;?>
layer/layer.js" ></script>
		<?php echo $_smarty_tpl->tpl_vars['css']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['js']->value;?>


		<script type="text/javascript">
			regUrl="<?php echo U('Login/reg');?>
";
			checkRegEmail="<?php echo U('Login/checkReg_Email');?>
";
			checkFrist="<?php echo U('Login/RegFrist');?>
";
		</script>
		<!--[if IE 6]>
		<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
		<script>DD_belatedPNG.fix('*');</script>
		<![endif]-->
		
		<style type="text/css">
			body .reg-class .layui-layer-title{background:#c00; color:#fff; border: none;}
			body .reg-class .layui-layer-btn{border-top:1px solid #E9E7E7}
			body .reg-class .layui-layer-btn a{background:#333;}
			body .reg-class .layui-layer-btn .layui-layer-btn1{background:#999;}
			body .reg-class .layui-layer-content{padding: 20px;line-height: 24px;color: #666;text-align: left;}
		</style>
		
	</head>
	<body>
		
		<div class="reg">
			<div class="state_text"><span>注册</span></div>
			<img class="logo_reg clearfix" src="<?php echo @HOME_IMG_PATH;?>
login.png" />
			<form class="pb-20" style="padding-top: 40px;">
				<input type="email" name="email" class="radius input-text" placeholder="输入邮箱地址" style="height: 48px; padding: 10px 15px;" />
				<input type="password" name="pass" class="radius input-text mt-20" placeholder="输入密码" style="height: 48px; padding: 10px 15px;" />
				<input type="password" name="surepass"  class="radius input-text mt-20" placeholder="确认密码" style="height: 48px; padding: 10px 15px;" />
				<div class="text-l dis_b pt-10 pb-20" id="userInstructions">
					<input type="checkbox" name="userInstructions"> 我已经阅读并同意 <a onclick="alertPage('')" class="c-uleblue" href="javascript:;">用户协议</a>
				</div>
				<button type="button" class="reg_btn btn btn-block btn-ule size-XL ule_reg_btn">注册</button>
				<div class="line mt-20"></div>
				<div class="pt-20 pb-30">
					<div class="f-l f-14" style="padding: 4px 0px;">已有帐号/悠乐帐号？</div>
					<a href="<?php echo U('Login/index');?>
" class="btn btn-ule-outline size-M radius f-r" >去登录</a>
				</div>
			</form>
		</div>
		<p class="text-c c-white pt-20" style="width: 100%; z-index: 1;">
			悠乐地接助游平台，专注于整合地接信息，实现旅客和地接人员的双向沟通！<br />
			服务热线：18591980321　全国客服热线 7*24小时为你全身心服务<br />
		</p>
		
	</body>
</html>
<?php }} ?>