<?php
namespace Admin\Controller;
use Think\Controller;

class FromController extends CommonController {


	public function index(){

		$m=M('from');

		$count= $m->count("id");//总数量
	    $Page= new \Think\Page($count,LISTNUM);
	    $Page->rollPage = PAGENUM;//分页行 显示的页数

	    // 实例化分页类 传入总记录数和每页显示的条数
	    $show = $Page->show();// 分页显示输出

	    $result=$m->limit($Page->firstRow.','.$Page->listRows)->order('id asc')->select();

		$this->assign('page',$show);// 赋值分页输出
		$this->assign('result',$result);// 赋值分页输出
		$this->assign('count',$count);

		$this->display();
	}


	public function add(){

		//提交添加数据
		if (IS_AJAX) {

			$date=I('post.');
			$date['date']=date('Y-m-d H:i:s',time());
			$where['name']=$date['name'];
			if (M('from')->where($where)->find()) {
				$back['state']=0;
        		$back['message']='对不起，该来源名已经存在,添加未成功！';
        		return $this->ajaxReturn($back);
			}


	        $m=M('from')->add($date);

			if($m){

				$back['state']=1;
        		$back['message']='恭喜您,添加来源成功！';
        		return $this->ajaxReturn($back);

			}else{

				$back['state']=0;
        		$back['message']='很遗憾，添加未成功！';
        		return $this->ajaxReturn($back);

			}

		}

		$this->display();
	}




	/*编辑*/
	public function update(){
		
		if ($id=I('get.id')) {
			$rs=M('from')->where('id='.$id)->find();
			$this->assign('rs',$rs);
			$this->display('add');
		}else{

			$this->error('非法操作！');
		}


	}


	/*单个删除*/
	public function delone(){
		
		if ($id=I('get.id')) {
			$rs=M('from')->where('id='.$id)->find();
			if ($rs) {
				M('from')->where('id='.$id)->delete();
				$this->redirect('index');
			}else{
	
				$this->error('数据不存在！');
			}

		}else{
			$this->error('非法操作！');
		}
		
	}


}