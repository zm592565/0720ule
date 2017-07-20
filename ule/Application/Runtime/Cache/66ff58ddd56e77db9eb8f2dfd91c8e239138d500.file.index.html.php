<?php /* Smarty version Smarty-3.1.6, created on 2017-07-20 13:35:22
         compiled from "./Application/Home/View/default\Login\index.html" */ ?>
<?php /*%%SmartyHeaderCode:250285970411a3a1d52-13179395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66ff58ddd56e77db9eb8f2dfd91c8e239138d500' => 
    array (
      0 => './Application/Home/View/default\\Login\\index.html',
      1 => 1493725220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '250285970411a3a1d52-13179395',
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
  'unifunc' => 'content_5970411a44e10',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5970411a44e10')) {function content_5970411a44e10($_smarty_tpl) {?><!DOCTYPE html>
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
			var urlLocal="<?php echo U('Login/index');?>
";
			var websiteUrl="<?php echo U('Home/Index/index');?>
";
		</script>
		<!--[if IE 6]>
		<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
		<script>DD_belatedPNG.fix('*');</script>
		<![endif]-->
	</head>
	<body>
		
		<div class="reg">
			<div class="state_text"><span>登录</span></div>
			<img class="logo_reg clearfix" src="<?php echo @HOME_IMG_PATH;?>
login.png" />
			<form class="pb-20" style="padding-top: 40px;" action="/">
				<input type="text" name="user" class="radius input-text" placeholder="输入悠乐账号" style="height: 48px; padding: 10px 15px;" />
				<input type="password" name="password" class="radius input-text mt-20" placeholder="输入密码" style="height: 48px; padding: 10px 15px;" />
				<a href="#" id="forgetPassword" class="text-r dis_b c-uleblue pt-10 pb-10">忘记密码？</a>
				<button type="button" class="login_btn btn btn-block btn-ule size-XL ule_reg_btn">登录</button>
				<div class="line mt-20"></div>
				<div class="pt-20 pb-30">
					<div class="f-l f-14" style="padding: 4px 0px;">没有账号？</div>
					<a href="<?php echo U('Login/reg');?>
" class="btn btn-ule-outline size-M radius f-r" >注册</a>
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