<?php /* Smarty version Smarty-3.1.6, created on 2017-07-19 16:26:05
         compiled from "./Application/Home/View/default\Ask\askShow.html" */ ?>
<?php /*%%SmartyHeaderCode:1258596f04788fac39-37568693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6d1edae997835f306a6f7af72c22c19f6e48a1c' => 
    array (
      0 => './Application/Home/View/default\\Ask\\askShow.html',
      1 => 1500452762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1258596f04788fac39-37568693',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f0478c541d',
  'variables' => 
  array (
    'content' => 0,
    'user' => 0,
    'face' => 0,
    'tags' => 0,
    'value' => 0,
    'haslogin' => 0,
    'hasfocus' => 0,
    'hasAnswer' => 0,
    'child' => 0,
    'top_member' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f0478c541d')) {function content_596f0478c541d($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'F:\\wamp\\www\\ule\\ThinkPHP\\Library\\Vendor\\Smarty\\plugins\\modifier.date_format.php';
?><link rel="stylesheet" type="text/css" href="<?php echo @COMMON_CSS_PATH;?>
/page.css">
<script type="text/javascript">
	var loginIS="<?php echo session('userid');?>
";
	var addUrl="<?php echo U('Home/Ask/addAsk');?>
";
	var loginUrl="<?php echo U('login/index');?>
";
	var focusURL="<?php echo U('Home/Ask/focusAsk');?>
";
	var add_answer="<?php echo U('Home/Ask/addAnswer');?>
";
	var askAnswerAdd="<?php echo U('Home/Ask/askAnswerAdd');?>
";
</script>
<div class="box_ulehelp">

		<div class="ask_sub">
			<form action="<?php echo U('Home/Ask/searchAsk');?>
" method="get">
				<input placeholder="发布求助前请先搜索，该问题之前是否已经发布过！" name="title" type="text"  id="search_v" class="input-text radius" />
				<button type="submit" id="search_btn" class="btn btn-warning radius ml-10">搜索答案</button>
		
			<?php if (U('Home/Ask/checkUser')){?>
			<button type="button" id="send_help" class="btn btn-success radius ml-10">发布求助</button>
			<?php }else{ ?>
			<a href="<?php echo U('Home/Login/index');?>
" class="btn btn-success radius ml-10">发布求助</a>
			<?php }?>
			</form>
			
		</div>
</div>
      	<div class="ulehelp_box-gray">
      		<div class="box_1200 clearfix pt-20 pb-20">
      			
      			<nav class="breadcrumb c-999 f-12" style="border: none;"><a class="c-uleblue" href="<?php echo U('Home/Index/index');?>
">首页</a><span class="c-999 en">&gt;</span><a class="c-uleblue" href="<?php echo U('Home/Ask/index');?>
">悠乐帮</a><span class="c-999 en">&gt;</span><?php echo $_smarty_tpl->tpl_vars['content']->value['ask_title'];?>
</nav>
      			<div class="left_help">

      				<div class="ask_show_box">



      					<div class="pt-20 pl-20 pr-20 pb-20">
      						<p class="f-20 pt-10"><?php echo $_smarty_tpl->tpl_vars['content']->value['ask_title'];?>
</p>
      						<div class="user_link">
      							<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['user']->value['id']));?>
' class="">
      								<img src="<?php if ($_smarty_tpl->tpl_vars['face']->value){?><?php echo $_smarty_tpl->tpl_vars['face']->value;?>
<?php }else{ ?><?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>"/>
      							</a>
      							<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['user']->value['id']));?>
' class="c-888">
      							<?php if ($_smarty_tpl->tpl_vars['user']->value['member_name']){?>
									<?php echo $_smarty_tpl->tpl_vars['user']->value['member_name'];?>

								<?php }else{ ?>
									<?php echo $_smarty_tpl->tpl_vars['user']->value['member_email'];?>

								<?php }?>
      							</a>
      							<span class="c-999 pl-10">发表于 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['content']->value['ask_add'],"Y/m/d H:i:s");?>
</span>
      						</div>
      						<div class="pt-20 c-777 f-15 lh-30 pb-20">
      							<?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['content']->value['ask_content']);?>

      						</div>
      						<div class="clearfix tags_ask">
      						<?php if ($_smarty_tpl->tpl_vars['tags']->value){?>
	      						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
	      							<a href="<?php echo U("Ask/searchAskTag?tag=".($_smarty_tpl->tpl_vars['value']->value['name']));?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</a>
	      						<?php } ?>
      						<?php }?>
      						</div>
  							<div class="tool_ask_show">
								<div class="answer"><a href="#"><?php echo $_smarty_tpl->tpl_vars['content']->value['ask_answer'];?>
</a>个回答</div>
								<div class="read"><a href="#"><?php echo $_smarty_tpl->tpl_vars['content']->value['ask_saw'];?>
</a>人浏览</div>
								<div class="f-r">
									<button id="ask" class="btn size-M btn-success">回答问题</button>
									<?php if ($_smarty_tpl->tpl_vars['haslogin']->value){?>
										<button class="btn size-M <?php if ($_smarty_tpl->tpl_vars['hasfocus']->value){?>disabled <?php }else{ ?> btn-secondary<?php }?>" id="focus" type="button" name="<?php echo $_smarty_tpl->tpl_vars['content']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['hasfocus']->value){?>已关注<?php }else{ ?>关注问题<?php }?></button>			
									<?php }else{ ?>
									<a class="btn size-M btn-secondary" href="<?php echo U('Home/Login/index');?>
">关注问题</a>
									<?php }?>

								</div>
							</div>
      					</div>
      					<div class="line mb-20"></div>




      					<?php if ($_smarty_tpl->tpl_vars['hasAnswer']->value){?>

      					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hasAnswer']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>

      					<div class="pl-20 pb-20">
      						<div class="ask_cimmit">
      							<div class="support"><?php echo $_smarty_tpl->tpl_vars['value']->value['support'];?>
</div>
      							<div class="cimmit_user_link f-12 mb-20">
	      							<a href="#" class="">
	      							<img src="<?php if ($_smarty_tpl->tpl_vars['value']->value['member_face']){?><?php echo $_smarty_tpl->tpl_vars['value']->value['member_face'];?>
<?php }else{ ?><?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>"/>
	      							</a>
	      							<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['member_id'];?>
" class="c-888 f-15">
	      							<?php if ($_smarty_tpl->tpl_vars['value']->value['member_name']){?>
	      							<?php echo $_smarty_tpl->tpl_vars['value']->value['member_name'];?>

	      							<?php }else{ ?>
	      							<?php echo $_smarty_tpl->tpl_vars['value']->value['member_email'];?>

	      							<?php }?>
	      							</a>
	      							<span class="c-999 pl-10">发表于 <?php echo $_smarty_tpl->tpl_vars['value']->value['addtime'];?>
</span>
	      						</div>
      							<div class="pr-20 c-777 f-15 pb-20 lh-30">
	      							<?php echo $_smarty_tpl->tpl_vars['value']->value['content'];?>

	      						</div>
	      						<div class="mb-20 clearfix">
	      							<div class="add_ask f-l">对他说</div>
	      							<div class="do_report f-r">举报</div>
	      							<div class="clearfix"></div>
	      							<div class="ask_add_answer pt-10 pb-10 pl-10 pr-10 clearfix mt-10" <?php if ($_smarty_tpl->tpl_vars['value']->value['childAnswer']){?>style="display:block"<?php }?>>
	      							<?php if ($_smarty_tpl->tpl_vars['value']->value['childAnswer']){?> 
	      							<?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value']->value['childAnswer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
?>
	      							<div class="answer_list clearfix">
	      								<img class="face" src="<?php if ($_smarty_tpl->tpl_vars['child']->value['member_face']){?><?php echo $_smarty_tpl->tpl_vars['child']->value['member_face'];?>
<?php }else{ ?><?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>">
	      								<div class="child_box">
	      								<a href="" class="f-l f-12 lh-24 c-uleblue">
	      									<?php if ($_smarty_tpl->tpl_vars['child']->value['member_name']){?><?php echo $_smarty_tpl->tpl_vars['child']->value['member_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['child']->value['member_email'];?>
<?php }?>
	      								</a>
	      								<div class="f-r f-12 lh-24 c-999">
	      									<a href="javascript:;" class="callBack" data=<?php echo $_smarty_tpl->tpl_vars['child']->value['id'];?>
 name="<?php if ($_smarty_tpl->tpl_vars['child']->value['member_name']){?><?php echo $_smarty_tpl->tpl_vars['child']->value['member_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['child']->value['member_email'];?>
<?php }?>">回复</a>
	      									<span class="pipe">|</span>
	      									<a href="javascript:;" name="<?php echo $_smarty_tpl->tpl_vars['child']->value['member_id'];?>
" date="<?php echo $_smarty_tpl->tpl_vars['child']->value['id'];?>
" class="Toreport">举报</a>
	      								</div>
	      								<div class="clearfix"></div>
	      								<div class="clearfix f-14">
	      									<?php echo $_smarty_tpl->tpl_vars['child']->value['content'];?>

	      								</div>
	      								<div class="c-999 f-12 pt-10"><?php echo $_smarty_tpl->tpl_vars['child']->value['addtime'];?>
</div>
	      								</div>
	      							</div>
	      							<?php } ?>
	      							<?php }?>
	      								<input type="hidden" name="pid" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="askpid">
	      								<input type="text" value="" placeholder="添加回复" style="font-size: 12px;" class="input-text add_send"></input>
	      								<div class="text-l f-l text_num"><span>0</span>/500 字</div>
	      								<button type="button" class="btn size-M mt-10 btn-secondary f-r add_ask_answer">发布</button>
	      							</div>
	      						</div>
	      						<div class="border-b"></div>
      						</div>
      					</div>
      					<?php } ?>
      					<?php }?>



      					<div id="answer_box" class="pr-20 pb-20" style="padding-left: 80px;">
  							<script id="editor" name="content" type="text/plain" style="width:100%;height:200px;"></script>
  							<div class="clearfix pt-10">
  							<?php if ($_smarty_tpl->tpl_vars['haslogin']->value){?>
  								<button type="button" class="btn btn-secondary size-M f-r" id="add_answer" value="<?php echo $_smarty_tpl->tpl_vars['content']->value['id'];?>
">回复提问</button>
  							<?php }else{ ?>
  								<a href="<?php echo U('Home/Login/index');?>
" class="btn btn-secondary size-M f-r">回复提问</a>
  							<?php }?>

  							<span class="lh-30 f-l">最多允许<cite class="c-orange">10000</cite>个字符</span>
  							</div>
  						</div>
      					
      					
      				</div>
      				
      			</div>
      			
      			<div class="right_help">
      				
      				<div class="ule_box_right">
					<div class="help_reg" style="margin-top: 0px">
						加入悠乐帮<br/>让世界的角角落落都留下你的脚印<br/>还在等什么？
						<div class="pt-10">
							<a class="join_btn f-18 radius" target="_blank" href="<?php echo U('Login/reg');?>
">加入悠乐</a>
						</div>
						<div class="lh-24 f-14 text-l pt-10">已有帐号？立即<a target="_blank" href="<?php echo U('Login/index');?>
" style="padding-left: 3px; color: #7ceee7; text-decoration: underline;">登录</a></div>
					</div>
					<div class="posts">
						<p class="f-18">悠友发帖榜<a  target="_blank" href="<?php echo U('Login/reg');?>
">悠乐帮招募中</a></p>

						<?php if ($_smarty_tpl->tpl_vars['top_member']->value){?>

							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['top_member']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>

							<dl>


								<dt <?php if ($_smarty_tpl->tpl_vars['key']->value==0){?>class="one"<?php }elseif($_smarty_tpl->tpl_vars['key']->value==1){?>class="two"<?php }elseif($_smarty_tpl->tpl_vars['key']->value==2){?>class="three"<?php }?>><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</dt>


								<dd>
									<a href="#">
										<img src="<?php if ($_smarty_tpl->tpl_vars['value']->value['member_face']){?><?php echo $_smarty_tpl->tpl_vars['value']->value['member_face'];?>
<?php }else{ ?><?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>"/>
									</a>
									<a href="#" class="member_name">
										<?php if ($_smarty_tpl->tpl_vars['value']->value['member_name']){?>
										<?php echo $_smarty_tpl->tpl_vars['value']->value['member_name'];?>

										<?php }else{ ?>
										<?php echo $_smarty_tpl->tpl_vars['value']->value['member_email'];?>

										<?php }?>
									</a>
									<span><strong><?php echo $_smarty_tpl->tpl_vars['value']->value['member_integral'];?>
</strong>分</span>
								</dd>
							</dl>

							<?php } ?>

						<?php }?>

						
					</div>
				</div>
      			</div>
      			
      			
      			
      			
      		</div>
      		
      	</div>
      	<script type="text/javascript" src="<?php echo @UEDITOR_PATH;?>
ueditor/1.4.3/ueditor.config_home.js"></script>
		<script type="text/javascript" src="<?php echo @UEDITOR_PATH;?>
ueditor/1.4.3/ueditor.all.min.js"> </script>
		<script type="text/javascript" src="<?php echo @UEDITOR_PATH;?>
ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>



		<?php }} ?>