<?php /* Smarty version Smarty-3.1.6, created on 2017-07-19 15:32:12
         compiled from "./Application/Home/View/default\Ask\search.html" */ ?>
<?php /*%%SmartyHeaderCode:9090596f0afcc77372-06339120%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4004bd0097c5a567a29703caceee82c43eecb029' => 
    array (
      0 => './Application/Home/View/default\\Ask\\search.html',
      1 => 1496466587,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9090596f0afcc77372-06339120',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'titlempty' => 0,
    'count' => 0,
    'title' => 0,
    'info' => 0,
    'value' => 0,
    'tag' => 0,
    'page' => 0,
    'top_member' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f0afceec0b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f0afceec0b')) {function content_596f0afceec0b($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="<?php echo @COMMON_CSS_PATH;?>
page.css">
<script type="text/javascript">
	var loginIS="<?php echo session('userid');?>
";
	var addUrl="<?php echo U('Home/Ask/addAsk');?>
";
	var loginUrl="<?php echo U('login/index');?>
";
	var hotHelp="<?php echo U('Home/Ask/AjaxLoadData');?>
";
	var backMessageUrl="<?php echo U('Home/Ask/waitBack');?>
";
	var searchAsk="<?php echo U('Home/Ask/searchAsk');?>
";
</script>
<div class="box_ulehelp">
      			<div class="ask_sub">
      				<form action="<?php echo U('Home/Ask/searchAsk');?>
" method="get">
	      				<input placeholder="发布求助前请先搜索，该问题之前是否已经发布过！" type="text" name="title"  id="search_v" class="input-text radius" />
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
      			
      			<div class="left_help clearfix">
					
					<?php if ($_smarty_tpl->tpl_vars['titlempty']->value){?>
					<div class="ule_box_left ule_box_left_active clearfix">
					<dl class="text-c c-warning f-14">搜索关键词不得为空!</dl>
					</div>
					<?php }else{ ?>
						
					<div class="nav_top clearfix">
      					
      					<div class="f-l lh-24 f-14">
							<?php if ($_smarty_tpl->tpl_vars['count']->value){?>
							悠乐为您找到关于<cite class="c-warning" style="padding-left: 3px;padding-right: 3px">"<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"</cite>的结果<cite class="c-success" style="padding-left: 3px;padding-right: 3px"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</cite>条
							<?php }else{ ?>
							很遗憾没有找到你搜索的<cite class="c-warning" style="padding-left: 3px;padding-right: 3px">"<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"</cite>的结果
							<?php }?>
      					</div>
      					<a <?php if (U('Home/Ask/checkUser')){?> href="javascript:;" id="send_box" <?php }else{ ?> href="<?php echo U('Home/Login/index');?>
" <?php }?> class="post_send radius"><i class="Hui-iconfont Hui-iconfont-add"></i>发布求助</a>
      				</div>
      				<div class="ule_box_left ule_box_left_active clearfix">
      					
      					<?php if ($_smarty_tpl->tpl_vars['info']->value){?>

      						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
      							<dl>
									<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['memberid'];?>
" class="face">
										<img src="<?php if ($_smarty_tpl->tpl_vars['value']->value['member_face']){?><?php echo $_smarty_tpl->tpl_vars['value']->value['member_face'];?>
<?php }else{ ?><?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>" />
										<span class="c666">
										<?php if ($_smarty_tpl->tpl_vars['value']->value['member_name']){?>
											<?php echo $_smarty_tpl->tpl_vars['value']->value['member_name'];?>

										<?php }else{ ?>
											<?php echo $_smarty_tpl->tpl_vars['value']->value['member_email'];?>

										<?php }?>
										</span>
										<span class="c-999">提了一个问题 - <?php echo $_smarty_tpl->tpl_vars['value']->value['add_time'];?>
</span>
									</a>
									<a class="f-16 text-l pt-10 pb-5 dis_b lh-20 c-uleblue" href='<?php echo $_smarty_tpl->tpl_vars['value']->value['showurl'];?>
' target="_blank" style="margin-bottom: 0px;"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_title'];?>
</a>
									<div class="text-l c-777 f-14 lh-24 text_Hm36"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_content'];?>
</div>
									<div class="tool_box clearfix">
									<?php if ($_smarty_tpl->tpl_vars['value']->value['tags']){?>
									<?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value']->value['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value){
$_smarty_tpl->tpl_vars['tag']->_loop = true;
?>
										<a href="<?php echo U("Ask/searchAskTag?tag=".($_smarty_tpl->tpl_vars['tag']->value['name']));?>
" class="c-999"><?php echo $_smarty_tpl->tpl_vars['tag']->value['name'];?>
</a>
									<?php } ?>
									<?php }?>
										<div class="read_message_box">
											<div class="answer"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_answer'];?>
</a>个回答</div>
											<div class="read"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_saw'];?>
</a>人浏览</div>
										</div>
									</div>
								</dl>
      						<?php } ?>

      						<div class="pagination" style="margin-top:20px"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</div>
      					<?php }else{ ?>
      					<dl>
      						<p class="f-12 c-999 text-c">暂无查询结果...</p>
      					</dl>
      					<?php }?>	

      				</div>


					<?php }?>

      				
      				
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


<?php }} ?>