<?php
/*
 * 服务器模型
 * */
namespace Admin\Model;
use Think\Model;
class LogisticsInforModel extends Model {
    protected $tableName = 'logistics_infor';
     /* 自动验证 */
   protected $_validate = array(
    array('pack_info', 'require', '没有填写单号！', self::EXISTS_VALIDATE,  self::MODEL_INSERT),
    array('state',     'require', '没有选择状态！', self::EXISTS_VALIDATE,  self::MODEL_INSERT)
  );
}