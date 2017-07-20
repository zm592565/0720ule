<?php

//定义后台css路径
define('ADMIN_PATH',__ROOT__.'/Public/admin/');
define('ADMIN_CSS_PATH',__ROOT__.'/Public/admin/css/');
define('ADMIN_JS_PATH',__ROOT__.'/Public/admin/js/');
define('ADMIN_IMG_PATH',__ROOT__.'/Public/admin/img/');


return array(
	//'配置项'=>'配置值'

	  'AUTH_CONFIG' => array(
        // 用户组数据表名
        'AUTH_GROUP' => 'ule_auth_group',
        // 用户-用户组关系表
        'AUTH_GROUP_ACCESS' => 'ule_auth_group_access',
        // 权限规则表
        'AUTH_RULE' => 'ule_auth_rule',
        // 用户信息表
        'AUTH_USER' => DB_PREFIX.'admin'
    ),

    'TMPL_ENGINE_CONFIG'  => array(
      'caching' => false,/*禁止smarty缓存*/
     ),
 

);