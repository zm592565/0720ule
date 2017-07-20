<?php /* Smarty version Smarty-3.1.6, created on 2017-07-19 15:04:29
         compiled from "./Application/Home/View/default\Public\404.html" */ ?>
<?php /*%%SmartyHeaderCode:15742596f047d93a230-56640778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '782a68c5e3878c58c6a3bef153e4bf2e04d11aaa' => 
    array (
      0 => './Application/Home/View/default\\Public\\404.html',
      1 => 1493214898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15742596f047d93a230-56640778',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f047da3903',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f047da3903')) {function content_596f047da3903($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<title>悠乐地接-对不起您的页面走丢了...</title>
		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo @HOME_LIB_PATH;?>
html5.js"></script>
		<link href="<?php echo @HOME_CSS_PATH;?>
H-ui/H-ui.ie.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo @HOME_LIB_PATH;?>
respond.min.js"></script>
		<script type="text/javascript" src="<?php echo @HOME_LIB_PATH;?>
PIE_IE678.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="<?php echo @HOME_CSS_PATH;?>
H-ui/H-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo @HOME_CSS_PATH;?>
404.css" />
		<!--[if IE 6]>
		<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
		<script>DD_belatedPNG.fix('*');</script>
		<![endif]-->
	</head>
	<body>
		<div class="cloud_right"></div>
		<div class="cloud_top"></div>
		<div class="cloud_left"></div>
		
		<div class="desk">
			<div class="error_logo"></div>
			<div class="error_text">	
			<p><?php if (isset($_smarty_tpl->tpl_vars['message']->value)){?><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php }?></p>
			<a href="<?php echo U('Home/Index/index');?>
" class="btn btn-warning size-L radius">返回首页</a>
			</div>
		</div>
		<div class="desk_leg"></div>
		<div class="montain"></div>
	</body>
</html>
<?php }} ?>