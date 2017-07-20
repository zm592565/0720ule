<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends CommonController {


	public function index(){
		$index = A('Index');
		echo $index->header();
		self::news_list();
		echo $index->footer();

	}



	public function news_list(){

		$id=I('get.id',22); // 如果不存在$_GET['id'] 则返回22
		$bread=M('class')->where('id='.$id)->find();
		$rss=$this->topId($id);/*获取顶级栏目*/
		$this->assign('page_big',$rss['class_name']);
		$Count=M('news')->where('uid='.$id)->count("id");	
		$Page= new \Think\Page($Count,HOME_LISTNUM);
		$news=M('news')->where('uid='.$id)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

		/*重新组装数组，嵌入详细页链接*/
		$newslist=array();
		foreach ($news as $key => $value) {
			$newslist[$key]['id']=$value['id'];
			$newslist[$key]['title']=$value['title'];
			$newslist[$key]['fromid']=$value['fromid'];
			$newslist[$key]['digest']=$value['digest'];
			$newslist[$key]['uid']=$value['uid'];
			$newslist[$key]['keyword']=$value['keyword'];
			$newslist[$key]['content']=$value['content'];
			$newslist[$key]['time']=$value['time'];
			$newslist[$key]['count']=$value['count'];
			$newslist[$key]['url']=U('News/show_new?id='.$value['id']);
		}
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('count',$Count);
		$this->assign('newslist',$newslist);
		$this->assign('qucik',self::quick_menu($rss['id']));
		$this->assign('bread',$bread);
		$this->display('list');
	}


	/*新闻详情*/
	public function show_new(){

		$index = A('Index');

		$id=I('get.id','');

		if (!empty($id)) {
			
			$rs=M('news')->table(DB_PREFIX.'news n,'.DB_PREFIX.'from f')
					->where('n.id='.$id.' AND n.fromid=f.id')
					->field('n.* ,f.name,f.link')
					->find();
			$rs['content']=htmlspecialchars_decode($rs['content']);
			$this->assign('rs',$rs);

		}else{
			$this->redirect('Index/index');
		}

		

		$this->assign('header',$index->header());
		$this->display('show');
		$this->assign('footer',$index->footer());
	}



	/*新闻快捷导航*/
	public function quick_menu($pid){

		$where['pid']=$pid;
		$rs=M('class')->where($where)->select();
		$menu= array();

		/*对查询大类进行整编*/
		if($pid==24){
			
			foreach ($rs as $key => $value) {

				switch ($value['id']) {
					case '25':
						$menu[$key]['url']=U('News/pageshow?id='.$value['id']);
						$menu[$key]['class_name']=$value['class_name'];
						break;
					case '26':
						$menu[$key]['url']=U('News/pageshow?id='.$value['id']);//投诉与建议
						$menu[$key]['class_name']=$value['class_name'];
						break;
					case '27':
						$menu[$key]['url']=U('News/pageshow?id='.$value['id']);//费用查询
						$menu[$key]['class_name']=$value['class_name'];
						break;
					case '28':
						$menu[$key]['url']=U('Net/index');//海外网点
						$menu[$key]['class_name']=$value['class_name'];
						break;
					case '29':
						$menu[$key]['url']=U('Api/index');
						$menu[$key]['class_name']=$value['class_name'];
						break;
				}

			}



		}else{

			
			$menu= array();
			foreach ($rs as $key => $value) {
				if ($value['class_type']) {
					$menu[$key]['url']=U('News/pageshow?id='.$value['id']);
				}else{
					$menu[$key]['url']=U('News/index?id='.$value['id']);
				}

				
				$menu[$key]['class_name']=$value['class_name'];
			}


		}

		
		return $menu;

	}



	/*单页*/
	public function pageshow(){
		$index = A('Index');
		$id=I('get.id',5);

		if (!empty($id)) {
			
			$where['uid']=$id;
			$rs=M('page')->where($where)->find();
			$class_name=M('class')->where('id='.$id)->find();

			$rs['content']=htmlspecialchars_decode($rs['content']);


			$this->assign('page_title',$class_name['class_name']);
			$rss=$this->topId($id);
			$this->assign('page',$rs);

		}

		$this->assign('page_big',$rss['class_name']);
		$this->assign('qucik',self::quick_menu($rss['id']));
		$this->assign('header',$index->header());
		$this->display('page');
		$this->assign('footer',$index->footer());
	}




	/*确定顶层分类*/
	public function topId($id){

		$date=array();
		$where['id']=$id;
		$rs=M('class')->where($where)->find();
		if ($rs['pid']!=0) {
			$date=array_merge($date,$this->topId($rs['pid']));
		}else{
			$date=$rs;
		}
		return $date;

	}







}