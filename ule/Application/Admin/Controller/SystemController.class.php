<?php
namespace Admin\Controller;
use Think\Controller;

/*系统设置类*/
class SystemController extends CommonController {


	public function index(){




		$rs=M('system')->where('id=1')->find();

		
		$this->assign('rs',$rs);
		$this->display();
	}

	
	public function update(){


		if (IS_POST) {
					
			$date=I('post.');
			$rs=M('system')->where('id='.$date['id'])->save($date);
			if ($rs) {
				
				$this->success('修改成功',U('System/index'));

			}else{
				$this->redirect('System/index');
			}


		}



	}


}