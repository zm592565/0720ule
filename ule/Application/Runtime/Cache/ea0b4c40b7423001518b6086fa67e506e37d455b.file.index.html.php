<?php /* Smarty version Smarty-3.1.6, created on 2017-07-20 16:21:23
         compiled from "./Application/Home/View/default\Usercenter\index.html" */ ?>
<?php /*%%SmartyHeaderCode:17119596f0701df9da9-11138212%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea0b4c40b7423001518b6086fa67e506e37d455b' => 
    array (
      0 => './Application/Home/View/default\\Usercenter\\index.html',
      1 => 1500538881,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17119596f0701df9da9-11138212',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f070211033',
  'variables' => 
  array (
    'MessageListUrl' => 0,
    'userPageFace' => 0,
    'userInfo' => 0,
    'country' => 0,
    'selcity' => 0,
    'selstate' => 0,
    'userIno' => 0,
    'fansNum' => 0,
    'hasfocus' => 0,
    'listLine' => 0,
    'value' => 0,
    'listAsk' => 0,
    'tag' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f070211033')) {function content_596f070211033($_smarty_tpl) {?><script type="text/javascript">
	var add_focus="<?php echo U('Home/Index/add_focus');?>
";
	var user_center="<?php echo U('Home/Usercenter/sendMessageUserPage');?>
";
	var MessageList="<?php echo $_smarty_tpl->tpl_vars['MessageListUrl']->value;?>
";
</script>
<div class="ulehelp_box-gray line_top_line">
    		<div class="box_1200 clearfix" style="padding-top: 85px;padding-bottom: 60px;">
    				<div class="user_detail">
	    				<div class="user_face"><img src="<?php echo $_smarty_tpl->tpl_vars['userPageFace']->value;?>
" /></div>
	    				<div class="user_name">
	    				<?php if ($_smarty_tpl->tpl_vars['userInfo']->value['member_ename']){?>
	    				<?php echo $_smarty_tpl->tpl_vars['userInfo']->value['member_ename'];?>

	    				<?php }elseif($_smarty_tpl->tpl_vars['userInfo']->value['member_name']){?>
	    				<?php echo $_smarty_tpl->tpl_vars['userInfo']->value['member_name'];?>

	    				<?php }else{ ?>
	    				<?php echo $_smarty_tpl->tpl_vars['userInfo']->value['member_email'];?>

	    				<?php }?></div>
	    				<div class="user_line"></div>
	    				<div class="user_map"><?php if ($_smarty_tpl->tpl_vars['country']->value){?><?php echo $_smarty_tpl->tpl_vars['country']->value;?>
 - <?php if ($_smarty_tpl->tpl_vars['selcity']->value){?><?php echo $_smarty_tpl->tpl_vars['selcity']->value;?>
<?php }elseif($_smarty_tpl->tpl_vars['selstate']->value){?><?php echo $_smarty_tpl->tpl_vars['selstate']->value;?>
<?php }else{ ?>全境<?php }?><?php }?></div>
	    				<div class="user_info">
	    				<?php if ($_smarty_tpl->tpl_vars['userIno']->value['member_about']){?><?php echo $_smarty_tpl->tpl_vars['userIno']->value['member_about'];?>
<?php }else{ ?>这小子很懒，连个自我介绍都没留...<?php }?>	
	    				</div>
	    				<div class="text-c c-uleblue f-28 pt-20"><?php echo $_smarty_tpl->tpl_vars['userInfo']->value['member_price'];?>
<cite class="f-16 pl-5">元/天</cite></div>
	    				<div class="foucs_box">
	    					<dl>
	    						<dt>关注</dt>
	    						<dd><span><?php echo $_smarty_tpl->tpl_vars['fansNum']->value;?>
</span><cite class="f-14">人</cite></dd>
	    					</dl>
	    					<dl>
	    						<dt>评论</dt>
	    						<dd><span>201</span><cite class="f-14">次</cite></dd>
	    					</dl>
	    				</div>
	    				<button class="add_focus<?php if ($_smarty_tpl->tpl_vars['hasfocus']->value){?> disabled<?php }?>" name="<?php echo $_smarty_tpl->tpl_vars['userInfo']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['hasfocus']->value){?>已关注<?php }else{ ?>关注TA<?php }?></button>
	    				<button class="send_message">发信给TA</button>
	    			</div>
    			
    			<div class="user_list">
    				<div class="list_box">
	    				<div class="user_line_title">TA的地接线路<a href="<?php echo U('Home/Line/index');?>
"><img src="<?php echo @HOME_IMG_PATH;?>
user_more.png"/></a></div>
	    				<div class="line_dl_box clearfix">

	    				<?php if ($_smarty_tpl->tpl_vars['listLine']->value){?>

	    					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listLine']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>

	    						<dl>
		    						<dt><img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['thumb'];?>
"></dt>
		    						<dd class="line_show">
		    							<div class="mid_line">
		    								<img src="<?php echo @HOME_IMG_PATH;?>
line_eye.png" />
		    							</div>
		    							<p><?php echo $_smarty_tpl->tpl_vars['value']->value['view'];?>
</p>
		    						</dd>
		    						<dd class="line_title"><?php echo mb_substr($_smarty_tpl->tpl_vars['value']->value['title'],0,18);?>
</dd>
		    					</dl>

	    					<?php } ?>
	    				<?php }else{ ?>
							<div class="no_data">
								<div class="no_data_box">
									<p class="lh-20 f-12">这小子很懒,什么都还没有发布...</p>
								</div>
							</div>
	    					
	    				<?php }?>

	    					
	    					
	    				</div>
	    				
	    				<div class="user_line_title mt-20">TA发布的悠乐帮<a href="<?php echo U('Home/Ask/index');?>
"><img src="<?php echo @HOME_IMG_PATH;?>
user_more.png"/></a></div>
	    				
	    				<div class="ule_user_help clearfix">
	    					
							<?php if ($_smarty_tpl->tpl_vars['listAsk']->value){?>
								
								<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listAsk']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
								<dl>
									<a class="f-16 text-l pt-10 pb-5 dis_b lh-20 c-uleblue" href="<?php echo $_smarty_tpl->tpl_vars['value']->value['showurl'];?>
" target="_blank" style="margin-bottom: 0px;"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_title'];?>
</a>
									<div class="text-l c-777 f-14 lh-18 text_Hm36"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_content'];?>
</div>
									<div class="tool_box clearfix">
										<?php if ($_smarty_tpl->tpl_vars['value']->value['tags']){?>
										<?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value']->value['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value){
$_smarty_tpl->tpl_vars['tag']->_loop = true;
?>
											<a href='<?php echo U("Ask/searchAskTag?tag=".($_smarty_tpl->tpl_vars['tag']->value['name']));?>
' class="c-999"><?php echo $_smarty_tpl->tpl_vars['tag']->value['name'];?>
</a>
										<?php } ?>
										<?php }?>

										<div class="read_message_box">
											<div class="answer"><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_answer'];?>
</a>个回答</div>
											<div class="read"><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_saw'];?>
</a>人浏览</div>
										</div>
									</div>
								</dl>
								<?php } ?>	
								
							<?php }else{ ?>

								<div class="no_data">
									<div class="no_data_box">
										<p class="lh-20 f-12">这小子很懒,什么都还没有发布...</p>
									</div>
								</div>

							<?php }?>
	    					
							
	    				</div>
	    			</div>
	    			<div class="list_box mt-20">
	    				<div class="user_line_title">给TA留言<cite>已有留言<span class="c-orange pl-5 pr-5">14</span>条</cite></div>
	    				<textarea class="feedback_textarea clearfix" placeholder="对TA说几句吧..."></textarea>
	    				<p class="pl-20 pr-20 clearfix">
	    					<span class="f-l lh-30">最多允许1000个字符</span>
	    					<button type="button" id="sendUserMessage" name="<?php echo $_smarty_tpl->tpl_vars['userInfo']->value['id'];?>
" class="btn btn-secondary size-M f-r">发布留言</button>
	    				</p>
	    				<div class="user_commit clearfix">
	    					<dl>
	    						<dd>
	    							<div class="userpage_face">
	    								<img src="img/person_member.jpg" />
	    							</div>
	    							<a href="#">zm592565@qq.com</a>
	    							<span>发表于 2017/04/29 17:02:37</span>
	    						</dd>
	    						<dt>
	    							一个大男生认认真真看了楼主穿衣技巧，就为了mark下来带女朋友出去拍
	    							一个大男生认认真真看了楼主穿衣技巧，就为了mark下来带女朋友出去拍
	    						</dt>
	    						<div class="clearfix mt-10">
	    							<div class="add_ask f-l">对他说</div>
	    							<div class="do_report f-r">举报</div>
	    							<div class="clearfix"></div>
	    							<div class="ask_add_answer pt-10 pb-10 pl-10 pr-10 clearfix mt-10" style="display: block;">
	      							 
	      							<div class="answer_list clearfix">
	      								<img class="face" src="/ule/Uploads/face/2017-05-16/149493614135037565840_40.png">
	      								<div class="child_box">
		      								<a href="" class="f-l f-12 lh-24 c-uleblue">test1@qq.com</a>
		      								<div class="f-r f-12 lh-24 c-999">
		      									<a href="javascript:;" class="callBack" data="36" name="test1@qq.com">回复</a>
		      									<span class="pipe">|</span>
		      									<a href="javascript:;" name="34" date="36" class="Toreport">举报</a>
		      								</div>
	      									<div class="clearfix"></div>
		      								<div class="clearfix f-14">
		      									测试
		      								</div>
	      									<div class="c-999 f-12 pt-10">2017/06/10 18:58:01</div>
	      								</div>
	      							</div>
	      							<div class="answer_list clearfix">
	      								<img class="face" src="/ule/Uploads/face/2017-05-16/149493614135037565840_40.png">
	      								<div class="child_box">
		      								<a href="" class="f-l f-12 lh-24 c-uleblue">test2@qq.com</a>
		      								<div class="f-r f-12 lh-24 c-999">
		      									<a href="javascript:;" class="callBack" data="36" name="test2@qq.com">回复</a>
		      									<span class="pipe">|</span>
		      									<a href="javascript:;" name="34" date="36" class="Toreport">举报</a>
		      								</div>
	      									<div class="clearfix"></div>
		      								<div class="clearfix f-14">
		      									测试
		      								</div>
	      									<div class="c-999 f-12 pt-10">2017/06/10 18:58:01</div>
	      								</div>
	      							</div>
	      								<input type="text" value="" placeholder="添加回复" style="font-size: 12px;" class="input-text add_send">
	      								<div class="text-l f-l text_num"><span>0</span>/500 字</div>
	      								<button type="button" class="btn size-M mt-10 btn-secondary f-r add_ask_answer">发布</button>
	      							</div>
	    							
	    							
	    						</div>
	    					</dl>
	    					<dl>
	    						<dd>
	    							<div class="userpage_face">
	    								<img src="img/person_member.jpg" />
	    							</div>
	    							<a href="#">zm592565@qq.com</a>
	    							<span>发表于 2017/04/29 17:02:37</span>
	    						</dd>
	    						<dt>
	    							一个大男生认认真真看了楼主穿衣技巧，就为了mark下来带女朋友出去拍
	    							一个大男生认认真真看了楼主穿衣技巧，就为了mark下来带女朋友出去拍
	    						</dt>
	    						<div class="clearfix mt-10">
	    							<div class="add_ask f-l">对他说</div>
	    							<div class="do_report f-r">举报</div>
	    							<div class="clearfix"></div>
	    							<div class="ask_add_answer pt-10 pb-10 pl-10 pr-10 clearfix mt-10" style="display: block;">
	      							 
	      							<div class="answer_list clearfix">
	      								<img class="face" src="/ule/Uploads/face/2017-05-16/149493614135037565840_40.png">
	      								<div class="child_box">
		      								<a href="" class="f-l f-12 lh-24 c-uleblue">test1@qq.com</a>
		      								<div class="f-r f-12 lh-24 c-999">
		      									<a href="javascript:;" class="callBack" data="36" name="test1@qq.com">回复</a>
		      									<span class="pipe">|</span>
		      									<a href="javascript:;" name="34" date="36" class="Toreport">举报</a>
		      								</div>
	      									<div class="clearfix"></div>
		      								<div class="clearfix f-14">
		      									测试
		      								</div>
	      									<div class="c-999 f-12 pt-10">2017/06/10 18:58:01</div>
	      								</div>
	      							</div>
	      							<div class="answer_list clearfix">
	      								<img class="face" src="/ule/Uploads/face/2017-05-16/149493614135037565840_40.png">
	      								<div class="child_box">
		      								<a href="" class="f-l f-12 lh-24 c-uleblue">test1@qq.com</a>
		      								<div class="f-r f-12 lh-24 c-999">
		      									<a href="javascript:;" class="callBack" data="36" name="test1@qq.com">回复</a>
		      									<span class="pipe">|</span>
		      									<a href="javascript:;" name="34" date="36" class="Toreport">举报</a>
		      								</div>
	      									<div class="clearfix"></div>
		      								<div class="clearfix f-14">
		      									测试
		      								</div>
	      									<div class="c-999 f-12 pt-10">2017/06/10 18:58:01</div>
	      								</div>
	      							</div>
	      								<input type="text" value="" placeholder="添加回复" style="font-size: 12px;" class="input-text add_send">
	      								<div class="text-l f-l text_num"><span>0</span>/500 字</div>
	      								<button type="button" class="btn size-M mt-10 btn-secondary f-r add_ask_answer">发布</button>
	      							</div>
	    							
	    							
	    						</div>
	    					</dl>
	    				</div>
	    			</div>
	    			
	    		</div>
      		</div>
   		</div><?php }} ?>