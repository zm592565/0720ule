<?php /* Smarty version Smarty-3.1.6, created on 2017-07-19 15:31:38
         compiled from "./Application/Home/View/default\Line\list.html" */ ?>
<?php /*%%SmartyHeaderCode:26574596f0adae19f03-31903805%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0aeed4e11ba3d4a6d46490c771ebc72f11b6ffa5' => 
    array (
      0 => './Application/Home/View/default\\Line\\list.html',
      1 => 1497066366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26574596f0adae19f03-31903805',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'count' => 0,
    'list' => 0,
    'line' => 0,
    'face' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_596f0adb001a5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_596f0adb001a5')) {function content_596f0adb001a5($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="<?php echo @COMMON_CSS_PATH;?>
page.css">
<div class="ulehelp_box-gray line_top_line">
    		<div class="box_1200 clearfix">
    			<ul class="order_line">
    				<li><a <?php if ($_smarty_tpl->tpl_vars['order']->value=='start_time'||$_smarty_tpl->tpl_vars['order']->value==''){?>class="active"<?php }?> href="<?php echo U('Home/Line/index?order=time');?>
">默认排序</a><span class="pipe">|</span></li>
    				<li><a <?php if ($_smarty_tpl->tpl_vars['order']->value=='view'){?>class="active"<?php }?> href="<?php echo U('Home/Line/index?order=read');?>
">浏览最多</a></li>
    			</ul>
    			<div class="f-r all_line">共<span class="pl-5 pr-5 c-orange"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</span>个线路</div>
    		</div>
      		<div class="box_1200 new_line clearfix pb-20">

      			<?php if ($_smarty_tpl->tpl_vars['list']->value){?>

					<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['line']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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

					<?php }else{ ?>

					<p>暂无数据</p>

					<?php }?>

	      	</div>
	      	<div class="box_1200 clearfix pb-20">
				<div class="pagination"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</div>
			</div>
   		</div><?php }} ?>