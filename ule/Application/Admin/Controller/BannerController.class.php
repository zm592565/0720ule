<?php

	namespace Admin\Controller;
	use Think\Controller;

	/*广告管理类*/
	class BannerController extends CommonController {


		public function index(){

			/*注入树形结构*/
			$rs=M('bclass')->select();
			$data=array();
			if ($rs) {
				foreach ($rs as $key => $value) {
					$data[$key]['id']=$value['id'];
					$data[$key]['name']=$value['class_name'];
					$data[$key]['open']=true;
					$data[$key]['pId']=0;
					$data[$key]['url']=U('Banner/bannerdata?id='.$value['id']);
					$data[$key]['target']='testIframe';
				}
			}
			
			$this->assign('rs',json_encode($data));

			
			$this->display();
		}


		/*添加广告位分类*/
		public function add(){

			if (IS_AJAX) {

				$date=I('post.');
				$date['time']=time();
				$date['add_user']=session('user');
				$rs=M('bclass')->add($date);

				if($rs){

					$back['state']=1;
	        		$back['message']='恭喜您，添加栏目成功！';
	        		$this->ajaxReturn($back);

				}else{

					$back['state']=0;
	        		$back['message']='很遗憾，添加栏目失败！';
	        		$this->ajaxReturn($back);

				}

			}


			$this->display();
		}


		/*广告位列表*/
		public function bannerlist(){
			$rs=M('bclass')->select();
			$this->assign('class',$rs);
			$this->display();
		}





		/*修改广告位*/
		public function updatebanner(){


			if (IS_AJAX) {
				$date=I('post.');
				$date['time']=time();
				$date['add_user']=session('user');
				$rs=M('bclass')->save($date);

				if($rs){

					$back['state']=1;
	        		$back['message']='恭喜您，添加栏目成功！';
	        		$this->ajaxReturn($back);

				}else{

					$back['state']=0;
	        		$back['message']='很遗憾，添加栏目失败！';
	        		$this->ajaxReturn($back);

				}


			}

			/*显示修改信息*/
			$id=I('get.id','');
			if (!empty($id)) {
				$rs=M('bclass')->where('id='.$id)->find();
				$this->assign('rs',$rs);
			}

			$this->display();
		}


		/*删除广告位*/
		public function delbanner(){

			$id=I('get.id','');
			if (!empty($id)) {
				$rs=M('bclass')->where('id='.$id)->delete();
				
				if($rs){

					$this->redirect('bannerlist');

				}else{

					$this->error('很遗憾，删除数据失败！');

				}

			}

		}



		/*添加广告*/
		public function addbanner(){

			if (IS_AJAX) {
				$date=I('post.');
				$date['banner_thumb']=json_encode($date['banner_thumb']);
				$date['time']=time();
				$rs=M('banner')->add($date);

				if ($rs) {
					$back['state']=1;
	        		$back['message']='恭喜您，添加广告成功！';
	        		$back['addurl']=U('Banner/addbanner?id='.$date['banner_class']);
	        		$back['returnurl']=U('Banner/bannerdata?id='.$date['banner_class']);
	        		$this->ajaxReturn($back);
				}else{

					$back['state']=0;
	        		$back['message']='很遗憾，广告添加失败！';
	        		$back['addurl']=U('Banner/addbanner?id='.$date['banner_class']);
	        		$back['returnurl']=U('Banner/bannerdata?id='.$date['banner_class']);
	        		$this->ajaxReturn($back);

				}

			}
			

			$this->assign('banner_class',I('get.id'));
			$this->display();
		}


		/*广告列表*/
		public function bannerdata(){

			$id=I('get.id','');
			if (!empty($id)) {
				
				$class_name=M('bclass')->where('id='.$id)->find();
				$count=M('banner')->where('banner_class='.$id)->count();
				

				if ($count) {
					$Page= new \Think\Page($count,LISTNUM);
					$rs=M('banner')->where('banner_class='.$id)->limit($Page->firstRow.','.$Page->listRows)
					->order('id asc')->select();

					$dataarr=array();
					foreach ($rs as $key => $value) {
						
						$dataarr[$key]['id']=$value['id'];
						$dataarr[$key]['banner_name']=$value['banner_name'];
						$dataarr[$key]['sort']=$value['sort'];
						$dataarr[$key]['banner_info']=$value['banner_info'];
						$dataarr[$key]['is_show']=$value['is_show'];
						$dataarr[$key]['time']=$value['time'];
						$dataarr[$key]['update']=$value['time'];
						$dataarr[$key]['del']=U('Banner/delbannerdata?delid='.$value['id'].'&classid='.$id);

					}


					$show = $Page->show();// 分页显示输出
					$this->assign('page',$show);// 赋值分页输出
					$this->assign('count',$count);
					$this->assign('rs',$dataarr);
					$this->assign('id',$id);
				}
				
				$this->assign('bclass',$class_name['class_name']);
				
			}

			$addBtn=U('addbanner?id='.$id);/*注入添加广告按钮带分类的ID链接*/
			$this->assign('addBtn',$addBtn);
			

			$this->display('bannerdatelist');
		}



		public function delbannerdata(){
			$id=I('get.delid','');
			$classid=I('get.classid','');

			if (!empty($id)) {
				$rs=M('banner')->where('id='.$id)->delete();
				if ($rs) {
					
					$this->redirect('bannerdata?id='.$classid);
				}else{

					$this->error('很遗憾，删除数据失败！');

				}
			}



		}



		/*广告位排序*/
		public function sort(){

			if (IS_POST) {

				$post=I('post.');
				foreach ($post['sort'] as $key => $value) {
					$date['sort']=$value;
					M('banner')->where('id='.$key)->save($date); 
				}
		
				$this->redirect('bannerdata?id='.$post['pid']);
				
			}


		}





	}