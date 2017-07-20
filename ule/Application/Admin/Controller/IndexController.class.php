<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Auth;

class IndexController extends CommonController {


    //首页视图
    public function index(){


   		//权限控制 
  		$auth=new Auth();

  		/*
			check的第一个参数是rule的name值，也就是说判断group_acess里记录
			的uid表示用户的id ，groupid就是所在的组的id 检测当前的这个用户的组是否包含目前需要的这个rule表的这个权限
			group_id=1的时候是超级管理员什么权限都有 所以不需要验证权限
			
  		*/

		if (cookie('group_id')!=1) {
			
			/*是否有系统管理的权限*/
			$auth->check("1",session('userid')) ? $this->assign('sys',true) : $this->assign('sys',false);

			/*是否有管理员管理的权限*/
			$auth->check("2",session('userid')) ? $this->assign('admin_list',true) : $this->assign('admin_list',false);
			

			/*是否有会员管理的权限*/
			$auth->check("3",session('userid')) ? $this->assign('member',true) : $this->assign('member',false);
			

			/*是否有评论管理的权限*/
			$auth->check("4",session('userid')) ? $this->assign('comment',true) : $this->assign('comment',false);
			

			/*是否有内容管理的权限*/
			$auth->check("5",session('userid')) ? $this->assign('content',true) : $this->assign('content',false);
			
		}else{

			$this->assign('content',true);
			$this->assign('comment',true);
			$this->assign('member',true);
			$this->assign('sys',true);
			$this->assign('admin_list',true);

		}



  		$this->display('layout/layout');						
    }


    //默认主页
    public function welcome(){
      $this->display();
    }

}