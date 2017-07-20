<?php /* Smarty version Smarty-3.1.6, created on 2017-07-20 13:22:18
         compiled from "./Application/Home/View/default\Index\index.html" */ ?>
<?php /*%%SmartyHeaderCode:24184596f047d221141-10738217%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '675c8a2336f007bee409b51db36cf7652387708a' => 
    array (
      0 => './Application/Home/View/default\\Index\\index.html',
      1 => 1500452673,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24184596f047d221141-10738217',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f047d7d324',
  'variables' => 
  array (
    'country' => 0,
    'key' => 0,
    'value' => 0,
    'newlines' => 0,
    'line' => 0,
    'face' => 0,
    'member_new' => 0,
    'new_ask' => 0,
    'tag' => 0,
    'hot_ask' => 0,
    'backM' => 0,
    'top_member' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f047d7d324')) {function content_596f047d7d324($_smarty_tpl) {?><script type="text/javascript">
	var add_focus="<?php echo U('Home/Index/add_focus');?>
";
</script>
<div class="banner">
			<!-- Swiper -->
		    <div class="swiper-container">
		        <div class="swiper-wrapper">
		            <div class="swiper-slide"><img src="<?php echo @HOME_IMG_PATH;?>
banner.jpg"/></div>
		            <div class="swiper-slide"><img src="<?php echo @HOME_IMG_PATH;?>
banner.jpg"/></div>
		            <div class="swiper-slide"><img src="<?php echo @HOME_IMG_PATH;?>
banner.jpg"/></div>
		        </div>
		        <!-- Add Pagination -->
		        <div class="swiper-pagination"></div>
		        <div class="swiper-button-prev"></div>
    			<div class="swiper-button-next"></div>
		    </div>
		    <!-- Initialize Swiper -->
		    <script>
		    var swiper = new Swiper('.swiper-container', {
		        pagination: '.swiper-pagination',
		        nextButton: '.swiper-button-next',
		        prevButton: '.swiper-button-prev',
		        paginationClickable: true,
		        spaceBetween: 30,
		        centeredSlides: true,
		        autoplay: 2500,
		        autoplayDisableOnInteraction: false
		       
		    });
		    </script>
		</div>
		<div class="new_line clearfix">   
			<p class="f-26">最热地接线路</p>
			<ul class="clearfix">
			<?php if ($_smarty_tpl->tpl_vars['country']->value){?>

			<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['country']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['key']->value==0){?>
			<li class="active"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</li>
			<?php }else{ ?>
			<li><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</li>
			<?php }?>
			
			<?php } ?>
			<?php }?>

			</ul>

			<?php if ($_smarty_tpl->tpl_vars['newlines']->value){?>
				
				<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['newlines']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
					
					
					
					<div class="top_box hui-fadein <?php if ($_smarty_tpl->tpl_vars['key']->value==0){?>top_box_active <?php }?>clearfix">

					<?php if ($_smarty_tpl->tpl_vars['value']->value){?>

					<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['line']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value){
$_smarty_tpl->tpl_vars['line']->_loop = true;
?>
						<dl>
						<a href='<?php echo U("Home/Line/showLine?id=".($_smarty_tpl->tpl_vars['line']->value['id']));?>
'>
							<dt>
								<div class="line_thumb">
									<img src="<?php echo $_smarty_tpl->tpl_vars['line']->value['thumb'];?>
" />
								</div>
								<div class="line_map">
								<?php if ($_smarty_tpl->tpl_vars['line']->value['cityname']){?>
								<?php echo $_smarty_tpl->tpl_vars['line']->value['cityname'];?>

								<?php }elseif($_smarty_tpl->tpl_vars['line']->value['provincename']){?>
								<?php echo $_smarty_tpl->tpl_vars['line']->value['provincename'];?>

								<?php }else{ ?>
								<?php echo $_smarty_tpl->tpl_vars['line']->value['countryname'];?>

								<?php }?>
								</div>
								<img class="user" src="<?php if (!isset($_smarty_tpl->tpl_vars['face'])) $_smarty_tpl->tpl_vars['face'] = new Smarty_Variable(null);if ($_smarty_tpl->tpl_vars['face']->value = json_decode($_smarty_tpl->tpl_vars['line']->value['member_face'],true)){?><?php echo $_smarty_tpl->tpl_vars['face']->value['small'];?>
<?php }else{ ?>
								<?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>" />
							</dt>
							<dd>
								<div class="hot_line_title"><?php echo msubstr($_smarty_tpl->tpl_vars['line']->value['title'],0,30,'utf-8',true);?>
</div>
								<div class="line_price">
									<em><?php echo $_smarty_tpl->tpl_vars['line']->value['price_last'];?>
</em>元起
									<div class="fly_time">
									<?php echo date('Y/m/d',$_smarty_tpl->tpl_vars['line']->value['start_time']);?>
 出发</div>
								</div>
							</dd>
							</a>
						</dl>
					<?php } ?>

					<?php }?>

						

					</div>

				<?php } ?>

			<?php }?>
			
			<div class="chose_line clearfix">
			<?php if ($_smarty_tpl->tpl_vars['country']->value){?>

			<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['country']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
				<li<?php if ($_smarty_tpl->tpl_vars['key']->value==0){?> class="active"<?php }?>></li>
			<?php } ?>
			<?php }?>
			</div>
			<a class="more f-18" href="<?php echo U('Line/index');?>
">更多地接线路</a>
			
		</div>
		<!--
        	作者：344822559@qq.com
        	时间：2016-12-22
        	描述：地接线路结束
        -->
		
		<div class="guide_box">
			<p class="guide_title">发现·地接导游</p>
			<div class="content_box">
				<div class="content_guide clearfix">

				<?php if ($_smarty_tpl->tpl_vars['member_new']->value){?>

				<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['member_new']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>

					<dl>
						<dt><a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['id']));?>
'><img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['face'];?>
"/></a></dt>
						<dd>
							
							<?php if ($_smarty_tpl->tpl_vars['value']->value['hasfocus']){?>
							<a href="javascript:;" title="已关注此会员" name="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="btn radius size-MINI btn_foucs c-999 disabled" onclick="return false;">已关注</a>
							<?php }else{ ?>
							<a href="javascript:;" title="点击关注此会员" name="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="btn radius size-MINI btn_foucs c-999">关注</a>
							<?php }?>


							<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['id']));?>
' class="f-16 c-666" style="display: block;margin-right: 70px;">
							<?php if ($_smarty_tpl->tpl_vars['value']->value['name']){?><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
<?php }elseif($_smarty_tpl->tpl_vars['value']->value['ename']){?><?php echo $_smarty_tpl->tpl_vars['value']->value['ename'];?>

							<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['value']->value['email'];?>
<?php }?>
							</a>
							<p class="l-18" style="color: #999; margin-bottom: 0px;">已有粉丝<cite class="c-warning pl-5 pr-5"><?php echo $_smarty_tpl->tpl_vars['value']->value['fans'];?>
</cite>个</p>
							<div class="f-13 c-777 mt-5" style="height: 32px;overflow-y: hidden; line-height: 16px;">自我描述：<?php echo msubstr($_smarty_tpl->tpl_vars['value']->value['about'],0,25);?>
</div>
						</dd>
					</dl>
				<?php } ?>
				<?php }?>

					
					<div class="guide_reg">
						<p class="f-18 l-30 c-666" style="margin-bottom: 0px;">悠乐让自由行更自由！</p>
						<p class="f-14 l20 c-999 mb-25">注册悠乐账号，让想找的地接信息拥抱你。</p>
						<a href="<?php echo U('Home/Login/reg');?>
" class="btn_index_reg clearfix">立即注册</a>
						<p class="f-14 c-666 text-c" style="margin-bottom: 0px;">已有悠乐账号？<a href="<?php echo U('Home/Login/index');?>
" class="c-uleblue"><strong>登录</strong></a></p>
						<p class="mt-5 c-999 text-c">或使用<a href="#" class="pl-5"><img src="<?php echo @HOME_IMG_PATH;?>
qq_login_icon.jpg"/></a></p>
					</div>
					<a href="#" class="more f-18">更多地接导游</a>
				</div>
				
			</div>
		</div>
		<!--
        	作者：344822559@qq.com
        	时间：2016-12-22
        	描述：地接导游结束
        -->
		
		<div class="new_line clearfix">
			<p class="f-26">热门游记</p>
			<ul class="clearfix">
				<li class="active">泰国</li>
				<li>日本</li>
				<li>澳大利亚</li>
				<li>美国</li>
				<li>韩国</li>
				<li>加拿大</li>
			</ul>
			<div class="content_box clearfix">
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>
				<a href="#" class="hot_note">
					<img src="<?php echo @HOME_IMG_PATH;?>
pic.jpg" />
					<div class="hot_city">丽江</div>
					<div class="member_box">
						<div class="member_name">zm592565</div>
						<div class="member_read">1096</div>
						<div class="member_message">1096</div>
					</div>
					
				</a>

			</div>
			
			<div class="chose_line clearfix">
				<li class="active"></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</div>
			<a class="more f-18">更多游记</a>
			
		</div>
		<!--
        	作者：zm592565@163.com
        	时间：2016-12-23
        	描述：热门游记结束
        -->
        
        <div class="ule_help new_line clearfix">
        	<p class="f-26">悠乐帮</p>
			<ul class="clearfix">
				<li class="active">最新求助</li>
				<li>热门求助</li>
				<li>待回复</li>
			</ul>
			
			<div class="content_box clearfix pt-10">
				<div class="ule_box_left hui-fadein ule_box_left_active clearfix">



					<?php if ($_smarty_tpl->tpl_vars['new_ask']->value){?>

      						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['new_ask']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
      							<dl>
									<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['memberid']));?>
' class="face">
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
									<div class="text-l c-777 f-14 lh-24 text_Hm36" id="hotline_p">

									<?php echo $_smarty_tpl->tpl_vars['value']->value['ask_content'];?>

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
											<div class="answer"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_answer'];?>
</a>个回答</div>
											<div class="read"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_saw'];?>
</a>人浏览</div>
										</div>
									</div>
								</dl>
      						<?php } ?>

      					<?php }?>				
					
				</div>
				<div class="ule_box_left hui-fadein clearfix">

					<?php if ($_smarty_tpl->tpl_vars['hot_ask']->value){?>

      						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hot_ask']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
      							<dl>
									<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['memberid']));?>
' class="face">
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
									<div class="text-l c-777 f-14 lh-24 text_Hm36" id="hotline_p">

									<?php echo $_smarty_tpl->tpl_vars['value']->value['ask_content'];?>

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
											<div class="answer"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_answer'];?>
</a>个回答</div>
											<div class="read"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_saw'];?>
</a>人浏览</div>
										</div>
									</div>
								</dl>
      						<?php } ?>

      					<?php }?>

				</div>
				<div class="ule_box_left hui-fadein clearfix">

					<?php if ($_smarty_tpl->tpl_vars['backM']->value){?>

      						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['backM']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
      							<dl>
									<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['memberid']));?>
' class="face">
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
									<div class="text-l c-777 f-14 lh-24 text_Hm36" id="hotline_p">

									<?php echo $_smarty_tpl->tpl_vars['value']->value['ask_content'];?>

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
											<div class="answer"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_answer'];?>
</a>个回答</div>
											<div class="read"><a href="#"><?php echo $_smarty_tpl->tpl_vars['value']->value['ask_saw'];?>
</a>人浏览</div>
										</div>
									</div>
								</dl>
      						<?php } ?>

      					<?php }?>


				</div>


				<div class="ule_box_right">
					<div class="help_reg">
						加入悠乐帮<br/>让世界的角角落落都留下你的脚印<br/>还在等什么？
						<div class="pt-10">
							<a class="join_btn f-18 radius" href="<?php echo U('Home/Login/reg');?>
">加入悠乐</a>
						</div>
						<div class="lh-24 f-14 text-l pt-10">已有帐号？立即<a href="<?php echo U('Home/Login');?>
" style="padding-left: 3px; color: #7ceee7; text-decoration: underline;">登录</a></div>
					</div>
					<div class="posts">
						<p class="f-18">悠友发帖榜<a href="<?php echo U('Home/Login/reg');?>
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
									<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['id']));?>
'>
										<img src="<?php if ($_smarty_tpl->tpl_vars['value']->value['member_face']){?><?php echo $_smarty_tpl->tpl_vars['value']->value['member_face'];?>
<?php }else{ ?><?php echo @HOME_IMG_PATH;?>
default.jpg<?php }?>"/>
									</a>
									<a href='<?php echo U("Home/Usercenter/index?id=".($_smarty_tpl->tpl_vars['value']->value['id']));?>
' class="member_name">
										<?php if ($_smarty_tpl->tpl_vars['value']->value['member_name']){?>
										<?php echo $_smarty_tpl->tpl_vars['value']->value['member_name'];?>

										<?php }elseif($_smarty_tpl->tpl_vars['value']->value['member_ename']){?>
										<?php echo $_smarty_tpl->tpl_vars['value']->value['member_ename'];?>

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
        	
        </div><?php }} ?>