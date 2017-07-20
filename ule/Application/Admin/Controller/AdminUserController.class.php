<?php
namespace Admin\Controller;
use Think\Controller;

class AdminUserController extends CommonController {

	/**
	 * 管理员列表
	 */ 
	public function userlist(){

		$m=M('admin');
		$count= $m->count("id");//总数量
	    $Page= new \Think\Page($count,LISTNUM);
	    $Page->rollPage = PAGENUM;//分页行 显示的页数

	    // 实例化分页类 传入总记录数和每页显示的条数
	    $show = $Page->show();// 分页显示输出

	    $result=M()->table(DB_PREFIX.'admin c,'.DB_PREFIX.'auth_group_access a, '.DB_PREFIX.'auth_group b')
					->where("c.id=a.uid AND a.group_id=b.id")
					->field('c.*,b.title')
					->limit($Page->firstRow.','.$Page->listRows)->order('id asc')->select();


		$as=reupdate('id',$result,'AdminUser',array('freeze','update','del'));//组装带id的网址
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('result',$as);

		$this->display();

	}

	/**
	 * 管理员添加
	 */ 
	public function add(){
			if (IS_AJAX) {
				$date=I('post.');
				$date['last_time']=date('Y-m-d H:i:s',time());
				$date['last_ip']=$_SERVER['SERVER_ADDR'];
				$date['pass']=md5($date['pass']);
				if(M('admin')->create($date)){
					$where['user']=$date['user'];
					if (M('admin')->where($where)->find()) {	
						$data['state']=0;
						$data['message'] = "该用户名已经存在，请重新输入！";
						$this->ajaxReturn($data);
						return true;
					}else{
						//物理管理员才显示站点信息
						if($date['groupid']!=4){
							$date['outlets_id']='';
						}	
						$rs = M('admin')->add($date);
						if ($rs) {
							$dd['uid']=$rs;
							$dd['group_id']=$date['groupid'];
							$as=M()->table('think_auth_group_access')->add($dd);
							if ($as) {
								$data['state']=1;
								$data['message']="管理员添加成功！";
								$this->ajaxReturn($data);
							}else{

								$data['state']=0;
								$data['message']="管理员添加失败！";
								$this->ajaxReturn($data);	
							}
							
						}else{
							$data['state']=0;
							$data['message']="很遗憾管理员添加失败！";
							$this->ajaxReturn($data);
						};
					}
				}
			}

		
			//角色list
			$group = M('auth_group')->select();
			$this->assign('group',$group);
			
			//网点list
			$express_outlets = M('express_outlets')->select();
			$this->assign('express_outlets',$express_outlets);
			$this->display();
	}




	/*冻结*/
	public function freeze(){		
		$id=I('get.id');
		$id=intval($id);
		if(isset($id)){
			$rs=M('admin')->where('id='.$id)->find();

			if (!$rs) {
				$this->error('数据不存在！');
			}else{

				if($rs['state']==1){
					$date['state']=0;
				}else{
					$date['state']=1;
				}

				$as=M('admin')->where('id='.$id)->save($date);

				if ($as) {
					$this->redirect('userlist');
				}

			}

		}else{
			$this->error('非法访问！');
		}
	}


	/*修改*/

	public function update(){
		if (IS_AJAX) {
				
				$date=I('post.');
				$update_array = array();	
				
				//物流管理员才显示站点信息
				if($date['groupid']== 4){
					$update_array['outlets_id']=$date['outlets_id'];
				}else{
					$update_array['outlets_id']='';
				}
				
				//密码为空,默认不修改密码
				if(!(empty($date['pass']))){
					$update_array['pass']=md5($date['pass']);
				}
				$update_array['last_time'] = date('Y-m-d H:i:s',time());
				$update_array['last_ip'] = $_SERVER['SERVER_ADDR'];
				$update_array['name'] = trim($date['name']);
				$update_array['email'] = trim($date['email']);
				$update_array['last_ip'] =trim($date['user']);
		
				$rs=M('admin')->where('id='.$date['id'])->save($update_array);

				if ($rs) {
					//$rs是获取到刚添加的数据的主键
					$dd['group_id']=$date['groupid'];
					$as=M()->table(DB_PREFIX.'auth_group_access')->where('uid='.$date['id'])->save($dd);
					$data['state']=1;
					$data['message']="管理员信息修改成功！";
					$this->ajaxReturn($data);
										
				}else{
					$data['state']=0;
					$data['message']="管理员信息修改失败！";
					$this->ajaxReturn($data);
				}
			}

		$id=I('get.id');
		$id=intval($id);
		if (isset($id)) {
			
			$rs=M('admin')->where('id='.$id)->find();
			
			if ($rs) {

				/*注入管理组*/
				$group=M()->table(DB_PREFIX.'auth_group')->select();


				/*注入当前id下的用户权限组的id*/
				$groupid=M()->table(DB_PREFIX.'auth_group_access a, '.DB_PREFIX.'auth_group b')
				->where("a.uid=".$id." AND a.group_id=b.id")
				->field('b.title,a.group_id')
				->find();

				$this->assign('rs',$rs);
				$this->assign('id',$id);
				$this->assign('groupid',$groupid['group_id']);
				$this->assign('group',$group);

			}else{
				$this->error('数据不存在！');
			}


		}

		//网点list
		$express_outlets = M('express_outlets')->select();
		$this->assign('express_outlets',$express_outlets);
		$this->display();

	}


	/*删除*/
	public function del(){
		$id=I('get.id');
		$id=intval($id);
		if (isset($id)) {
			$as=M('admin')->where('id='.$id)->delete();
			$rs=M()->table(DB_PREFIX.'auth_group_access')->where('uid='.$id)->delete();
			if ($as&&$rs) {
				$this->redirect('userlist');
			}else{
				$this->error('数据删除失败！');
			}
		}else{
			$this->error('非法访问！');
		}



	}
	
	/*修改密码*/

	public function upassword(){
		if (IS_AJAX) {			
			$orpassword = I('orpassword');
			$pass = I('pass');
			$condition = array();
			//$condition['pass'] = md5($_POST['orpassword']);
			$condition['id'] = $_SESSION['userid'];
			$admininfo = M('admin')->where($condition)->find();
			//密码为空,默认不修改密码
			if($admininfo['pass'] != md5($orpassword)){
				$data['flag']=2;
				$data['msg']="原密码错误！";
				$this->ajaxReturn($data);
			}else{
				$update_array =array();
				$update_array['pass'] = md5($pass);
				$rs=M('admin')->where(array('id'=>$_SESSION['userid']))->save($update_array);
				if($rs){
					$data['flag']=0;
					$data['msg']="密码修改成功！";
					$this->ajaxReturn($data);
				}else{
					$data['flag']=1;
					$data['msg']="密码修改失败，请重新修改！";
					$this->ajaxReturn($data);
				}
			}	
	
		}else{
			$this->assign('user',$_SESSION['user']);
			$this->display();
		}

	}

}