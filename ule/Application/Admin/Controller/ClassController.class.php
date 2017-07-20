<?php
namespace Admin\Controller;
use Think\Controller;

class ClassController extends CommonController {


	public function index(){

		$m=M('class')->order('sort asc')->select();
		$Count=M('class')->count("id");
		$this->assign('count',$Count);
		$this->assign('class',$m);
		$this->display();
	}


	public function addclass(){

		//提交添加数据
		if (IS_AJAX) {

			$date=I('post.');
			$date['time']=date('Y-m-d H:i:s',time());
			//取得下一个增加的id赋值给sort字段
	        $Model = new \Think\Model();
	        $sql="SHOW TABLE STATUS LIKE '".DB_PREFIX."class'";
	        $rs=$Model->query($sql);
	        $date['sort']=$rs[0]['auto_increment'];//赋值下条数据的id

	        if ($date['pid']==0) {
	        	$where['class_name']=$date['class_name'];
	        	$rs1=M('class')->where($where)->find();
	        	if ($rs1) {
	        		$back['state']=0;
	        		$back['message']='对不起，该栏目已经存在,添加未成功！';
	        		return $this->ajaxReturn($back);
	        	}


	        }

	        $m=M('class')->add($date);

			if($m){

				$back['state']=1;
        		$back['message']='恭喜您，添加栏目成功！';
        		$this->ajaxReturn($back);

			}else{

				$back['state']=0;
        		$back['message']='很遗憾，添加栏目失败！';
        		$this->ajaxReturn($back);

			}

		}


		//页面信息注入
		$arr=M('class')->select();
		$class=recursive($arr);
		$this->assign('class',$class);
		$this->display();
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


	/*单个删除*/
	public function delone(){
		
		if ($id=I('get.id')) {

			$rs=M('class')->where('pid='.$id)->find();
			if ($rs) {
				$this->error('要删除父类id,请先删除其子类!');
			}else{

				M('class')->where('id='.$id)->delete();
				$this->redirect('index');
			}

		}
		
	}


	/*排序*/
	public function sort(){

		if (IS_POST) {

			$post=I('post.');
			foreach ($post['sort'] as $key => $value) {
				$date['sort']=$value;
				M('News')->where('id='.$key)->save($date); 
			}
	
			$this->redirect('index');
			
		}

	}


	/*删除*/
	public function del(){

		if (IS_POST) {

			$post=I('post.');
			if ($post['id']) {	
				foreach ($post['id'] as $key => $value) {
					$rs=M('class')->where('pid='.$value)->find(); 
					if ($rs) {
						$this->error('请先删除父类栏目的子类!');
					}else{
						M('class')->where('id='.$value)->delete(); 
					}
					
				}
				$this->redirect('index');
			}else{
				$this->redirect('index');
			}

		}
		
	}


}