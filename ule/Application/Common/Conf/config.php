<?php

//定义公共路径
define('COMMON_JS_PATH',__ROOT__.'/Public/common/js/');
define('COMMON_CSS_PATH',__ROOT__.'/Public/common/css/');
define('COMMON_IMG_PATH',__ROOT__.'/Public/common/img/');
define('COMMON_GLIDE_PATH',__ROOT__.'/Public/common/glide/');

//定义layer路径
define('ADMIN_LAYER_PATH',__ROOT__.'/Public/layer/');

//定义前台显示条数
define('HOME_LISTNUM', 20);

//定义后台每页显示条数
define('LISTNUM',20);


//定义显示页码数
define('PAGENUM', 20);


//定义数据路链接
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'ule');
define('DB_PREFIX', 'ule_');


return array(
	//'配置项'=>'配置值'
   'DB_HOST' => DB_HOST,
   'DB_USER' => DB_USER,
   'DB_PWD' => DB_PWD,
   'DB_NAME' => DB_NAME,
   'DB_PREFIX' => DB_PREFIX,
   'TOKEN_ON' => false,
   'DB_TYPE'=>'mysql',
  
   'URL_CASE_INSENSITIVE'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    
    'URL_MODEL'             =>  2  ,   // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    
  
  'MODULE_ALLOW_LIST'    =>    array('Home','Admin'),
  //允许访问的模块

	'TMPL_TEMPLATE_SUFFIX'=>'.html',
	//配置模板后缀
		
    
  'SHOW_PAGE_TRACE'		=>	false,
	//配置是否显示调试框
	
	//启用字段缓存
	'DB_FIELDS_CACHE'		=>	false,


	'TMPL_ENGINE_TYPE'=>'Smarty',
	//配置模板引擎

  'TMPL_ACTION_ERROR' => 'Public:404',
   // $this->error 错误定向页面模板设置

  //'TMPL_EXCEPTION_FILE'   =>  THINK_PATH.'Tpl/002.tpl',/*程序出现错误使用的模板*/


  'TMPL_ACTION_SUCCESS'   => 'Public:sucess',
   // $this->sucess 默认成功跳转对应的模板文件

  


);