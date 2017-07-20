<?php
namespace Admin\Controller;
use Think\Controller;

class MemberController extends CommonController {


	public function index(){

		$Count=M('member')->count("id");
		$Page= new \Think\Page($Count,LISTNUM);
		$rs=M('member')->order('member_reg_day asc')->limit($Page->firstRow.','.$Page->listRows)->select();

		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('count',$Count);
		$this->assign('member',$rs);
		$this->display();
	}


	/*添加会员*/
	public function addMember(){

		//提交添加数据
		if (IS_AJAX) {

			$date=I('post.');
			$date['member_email']=trim($date['member_email']);

			/*查询是否已有相同账号*/
			$Member=M('member');
			$where['member_email']=$date['member_email'];
			$have=$Member->where($where)->find();

			if (!!$have) {
				
					$back['state']=0;
	        		$back['message']='账号已存在！';
	        		return $this->ajaxReturn($back);


			}else{

					

	        		$date['member_pass']=trim($date['member_pass']);
					$date['member_pass_enter']=trim($date['member_pass_enter']);
					if ($date['member_pass']==$date['member_pass_enter']) {

						/*用户识别码*/
						$code=generate_password();
						$date['member_reg_day']=time();
						$date['member_from']=1;
						$date['member_code']=$code;
						$date['member_pass']=PassMake($date['member_pass'],$code);

						$result=$Member->add($date);

						if ($result) {
							$back['state']=1;
			        		$back['message']='恭喜你，会员账号添加成功！';
			        		return $this->ajaxReturn($back);
						}else{

							$back['state']=0;
			        		$back['message']='很遗憾，会员账号添加失败！';
			        		return $this->ajaxReturn($back);
						};




					}else{

						$back['state']=0;
		        		$back['message']='密码不一致！';
		        		return $this->ajaxReturn($back);

					};



			};




		};


		//页面信息注入
		$this->display();
	}




	/*修改会员状态：冻结||正常*/
	function updateMemberState($id,$state){

		
		switch ($state) {
			case '0':
				$data['member_state']=1;
				break;

			case '1':
				$data['member_state']=0;
				break;

			default:
				$data['member_state']=0;
				break;
		}

		$rs=M('member')->where('id='.$id)->save($data);
		if ($rs) {
			$this->redirect('Member/index');
		}else{
			$this->error('很遗憾,会员状态修改失败！','Member/index');
		}

	}



	/*修改密码*/
	function updatePass(){


		if(IS_AJAX){
			$date=I('post.');
			$date['id']=intval($date['id']);
			$rs=M('member')->where('id='.$date['id'])->find();
			if ($rs) {	

				$date['member_pass']=trim($date['member_pass']);
				$date['member_pass_enter']=trim($date['member_pass_enter']);

				if($date['member_pass']==$date['member_pass_enter']&&!empty($date['member_pass'])){
						$save['id']=$rs['id'];
						$save['member_pass']=PassMake($date['member_pass'],$rs['member_code']);
						$rss=M('member')->save($save);
						if ($rss) {
							$back['state']=1;
				    		$back['message']='恭喜你，密码修改成功！';
				    		return $this->ajaxReturn($back);
						}else{
							$back['state']=0;
				    		$back['message']='很遗憾，密码修改失败！';
				    		return $this->ajaxReturn($back);
						}

				}else{

					$back['state']=0;
		    		$back['message']='密码不一致！';
		    		return $this->ajaxReturn($back);
				}


			}else{

				$back['state']=0;
	    		$back['message']='会员信息不存在！';
	    		return $this->ajaxReturn($back);

			}

			

		}



		$id=I('get.id',0);
		if ($id) {
			$rs=M('member')->where('id='.$id)->find();

			if ($rs) {
				$this->assign('rs',$rs);
			}else{

				$this->error('很遗憾，没有找到相关会员信息！');

			}

		}else{
			$this->error('参数错误！');

		}





		$this->display('update');

	}


	/*删除用户*/
	function delUser($id){

		$rs=M('member')->where('id='.$id)->delete();
		if ($rs) {
			$this->redirect('Member/index');
		}else{
			$this->error('很遗憾,操作失败！','Member/index');
		}

	}









	/*测试密码重现*/
	function passM(){
		$pass_before='c5629d2b9f4fbb8f9c018dfdb2f3601a';
		$code="Y~=t{qfs";
		$pass=PassMake('592565',$code);

		echo "数据库密码：".$pass_before.'----'."新生成密码：".$pass;

		if ($pass_before===$pass) {
			echo "相同";
		}

		mytest();
	}







	/*编辑*/
	public function update(){

		if (IS_AJAX) {

			$date=I('post.');
			$date['time']=date('Y-m-d H:i:s',time());
			$where['id']=intval($date['id']);
	        $m=M('class')->where($where)->save($date);

			if($m){

				$back['state']=1;
        		$back['message']='恭喜您，栏目编辑成功！'.$id;
        		$this->ajaxReturn($back);

			}else{

				$back['state']=0;
        		$back['message']='很遗憾，栏目编辑失败！'.$id;
        		$this->ajaxReturn($back);

			}

		}





		
		if ($id=I('get.id')) {
			$rs=M('class')->where('id='.$id)->find();
			$class=M('class')->select();
			$this->assign('rs',$rs);
			$this->assign('class',$class);
			$this->display('update');
		}else{

			$this->error('非法操作！');
		}

		

	}





}