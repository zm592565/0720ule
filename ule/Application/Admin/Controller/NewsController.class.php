<?php
/*资讯管理*/
namespace Admin\Controller;
use Think\Controller;

class NewsController extends CommonController {


	public function index(){

		$rs=M('class')->select();
		$rs=Pagerecursive($rs);
		$this->assign('rs',$rs);
		$Count=M('news')->count("id");
		$Page= new \Think\Page($Count,LISTNUM);
		$result=M('news')
					->table(DB_PREFIX.'news n,'.DB_PREFIX.'class c,'.DB_PREFIX.'from f')
					->where('n.uid=c.id AND n.fromid=f.id')
					->field('n.* ,c.class_name,f.name')
					->limit($Page->firstRow.','.$Page->listRows)
					->order('n.sort asc')
					->select();

		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('count',$Count);
		$this->assign('news',$result);
		$this->display();
	}



	public function pagelist(){

		$id=I('get.id');
		$id=intval($id);
		$where['uid']=$id;
		$Count=M('news')->where($where)->count("id");
		$Page= new \Think\Page($Count,LISTNUM);
		$rs=M('news')
			->table(DB_PREFIX.'news n,'.DB_PREFIX.'class c,'.DB_PREFIX.'from f')
					->where('n.uid='.$id.' AND n.uid=c.id AND n.fromid=f.id')
					->field('n.* ,c.class_name,f.name')
					->limit($Page->firstRow.','.$Page->listRows)
					->order('n.sort desc')
					->select();
		if ($rs) {
			$show = $Page->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出
			$this->assign('count',$Count);
			$this->assign('news',$rs);	
		}
		$this->assign('id',$id);
		$this->display();


	}




	public function add(){
		
		if (IS_POST) {

			$date=I('post.');
			$date['photo']=json_encode($date['photo']);
			$date['time']=time();
			$Model = new \Think\Model();
	        $sql="SHOW TABLE STATUS LIKE '".DB_PREFIX."news'";
	        $rs=$Model->query($sql);
	        $date['sort']=$rs[0]['auto_increment'];//赋值下条数据的id
	        $date['userip']=$_SERVER['SERVER_ADDR'];
			$new=M('news')->add($date);
			if ($new) {
				$this->success('添加信息成功!',U('News/pagelist?id='.$date['uid']));
			}else{

				$this->error('很遗憾，添加数据失败！');

			}


		}else{

			$id=I('get.id');
			$id=intval($id);
			$from=M('from')->select();
			$this->assign('from',$from);
			$arr=M('class')->where('class_type=0')->select();
			$class=recursive($arr);
			$this->assign('class',$class);
			$this->assign('id',$id);
			$this->display();

		}


		
	}

	
	
	public function pagedetail(){
		
		if (IS_POST) {
			

			$date=I('post.');
			$date['uid']=intval($date['id']);
			$date['time']=time();
			$rs=M('page')->where('uid='.$date['id'])->find();

			if ($rs) {
				$where['id']=$rs['id'];
				M('page')->where($where)->field('title,keyword,zhai,content,time')->save($date);

			}else{

				M('page')->field('uid,title,keyword,zhai,content,time')->add($date);

			}
			
			redirect(U('News/pagedetail?id='.$date['id']));

		}



		$id=I('get.id');
		$id=intval($id);
		if ($id) {
			
			$rs=M('page')->where('uid='.$id)->find();

			if ($rs) {
				$rs['content']=htmlspecialchars_decode($rs['content']);
				$this->assign('rs',$rs);
			}

			$this->assign('id',$id);
			$this->display('page');


		}else{

			$this->error('非法操作！');

		}
		




		
	}






	/*编辑*/
	public function update(){


		if (IS_POST) {
				
				$date=I('post.');

				$date['photo']=json_encode($date['photo']);
				// $date['time']=time();
				$date['userip']=$_SERVER['SERVER_ADDR'];
				$rs=M('news')->where('id='.$date['id'])->find();

				if (M('news')->save($date)) {
					$this->success('数据修改成功!',U('News/pagelist?id='.$rs['uid']));
				}else{
					$this->error('很遗憾数据修改失败！','index');
				}
				

		};




		
		if (isset($_GET['id'])) {

			$id=intval($_GET['id']);

			$rs=M('news')->where('id='.$id)->find();

			$rs['content']=htmlspecialchars_decode($rs['content']);
			$rs['photo']=json_decode($rs['photo']);
			$this->assign('rs',$rs);

			$from=M('from')->select();
			$this->assign('from',$from);

			$arr=M('class')->where('class_type=0')->select();
			$class=recursive($arr);
			$this->assign('class',$class);
			$this->display();

		}else{

			$this->error('非法操作！');
		}

		

	}


	/*单个删除*/
	public function delone(){
		
		if ($id=I('get.id')) {
			$rs=M('news')->where('id='.$id)->find();

			if ($rs) {
				$rs1=M('news')->where('id='.$id)->delete();
				if ($rs1) {

		
					//redirect('/New/pagelist/id/'.$rs['uid'], 5, '页面跳转中...');
					$this->redirect('News/pagelist', array('id' => $rs['uid']), 0, '页面跳转中...');

				}else{
					$this->error('很遗憾，操作失败！');
				}
				
			}else{

				$this->error('信息不存在！');
			}

		}
		
	}


	/*排序*/
	public function sort(){

		if (IS_POST) {


			$post=I('post.');
			foreach ($post['sort'] as $key => $value) {
				$date['sort']=$value;
				M('news')->where('id='.$key)->save($date); 
			}
			$this->redirect('pagelist?id='.$post['pid']);
			
		}
		
	}


	/*删除*/
	public function del(){

		if (IS_POST) {

			$post=I('post.');
			if ($post['id']) {	
				foreach ($post['id'] as $key => $value) {
					
					M('news')->where('id='.$value)->delete(); 
					
				}
				$this->redirect('pagelist?id='.$post['pid']);
			}else{
				$this->redirect('pagelist?id='.$post['pid']);
			}

		}
		
	}



	/*默认页*/
	public function page_wel(){

		$this->display();

	}





}