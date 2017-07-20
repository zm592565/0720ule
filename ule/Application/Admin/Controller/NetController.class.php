<?php

	namespace Admin\Controller;
	use Think\Controller;

	class NetController extends CommonController {


		public function index(){

			

			$Count=M('net')->count("id");
			$Page= new \Think\Page($Count,LISTNUM);
			$result=M('net')
						->table(DB_PREFIX.'net n,'.DB_PREFIX.'admin a')
						->where('n.add_user=a.id')
						->field('n.* ,a.user')
						->limit($Page->firstRow.','.$Page->listRows)
						->order('n.sort asc')
						->select();

			$show = $Page->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出
			$this->assign('count',$Count);
			$this->assign('result',$result);
			$this->display();
		}


		public function add(){

			if (IS_POST) {	
				$data=I('post.');

				if (empty($data['nation'])||empty($data['company_cn'])) {
					$this->error('必填项信息不完整，请重新填写！');
					return ;
				}

				//取得下一个增加的id赋值给sort字段
		        $Model = new \Think\Model();
		        $sql="SHOW TABLE STATUS LIKE '".DB_PREFIX."net'";
		        $rs=$Model->query($sql);
		        $data['sort']=$rs[0]['auto_increment'];//赋值下条数据的id
				$data['net_pic']=json_encode($data['photo']);
				$data['add_user']=session('userid');
				$data['add_time']=time();
				$rs=M('net')->add($data);
				if ($rs) {
					$this->success('恭喜你添加信息成功');
				}else{
					$this->error('很遗憾添加失败');
				}
				return ;
			}

			$this->display();

		}



		/*单个删除*/
		public function delone(){
			
			if ($id=I('get.id')) {

				$rs=M('net')->where('id='.$id)->find();
				if ($rs) {
					M('net')->where('id='.$id)->delete();
					$this->redirect('index');
				}else{

					$this->error('数据不存在，或者操作失败！');
				}

			}
			
		}



		/*前台显示隐藏*/
		public function isShow(){

			$id=I('get.id');
			if (isset($id)) {
				
				$rs=M('net')->where('id='.$id)->find();

				if ($rs['is_show']) {
					$data['is_show']=0;
					M('net')->where('id='.$id)->save($data);

				}else{
					$data['is_show']=1;
					M('net')->where('id='.$id)->save($data);
				}

			}

			$this->redirect('index');


		}




		/*批量删除*/
		public function del(){


			if (IS_POST) {

				$post=I('post.');
				if ($post['id']) {	
					foreach ($post['id'] as $key => $value) {	
						M('net')->where('id='.$value)->delete(); 
					}
					$this->redirect('index');
				}else{
					$this->redirect('index');
				}

			}
		}



		/*批量排序*/
		public function sort(){

			if (IS_POST) {

				$post=I('post.');
	
				foreach ($post['sort'] as $key => $value) {
					$date['sort']=$value;
					M('net')->where('id='.$key)->save($date); 
				}
		
				$this->redirect('index');
				
			}

		}


		/*修改信息*/
		public function update(){

			if (IS_POST) {
				
				$data=I('post.');
				$data['net_pic']=json_encode($data['photo']);
				$rs=M('net')->save($data);

				if ($rs) {
					$this->success('恭喜你信息修改成功！','index');
				}else{

					$this->error('很遗憾信息修改失败！');

				}

				return;

			}




			$id=I('get.id','');
			if (!empty($id)) {
				$rs=M('net')->where('id='.$id)->find();
				if ($rs) {

					$this->assign('rs',$rs);
					$this->display();
				}else{

					$this->error('不存在此数据！');
				}
			}else{

				$this->error('参数错误！');

			}
			

			

		}




	}