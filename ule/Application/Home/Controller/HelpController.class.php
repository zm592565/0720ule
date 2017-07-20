<?php
namespace Home\Controller;
use Think\Controller;
class HelpController extends CommonController {


	public function index(){
		$index = A('Index');
		$css=parent::staticfile_load('css',array('header','common','help','footer'));
		$js=parent::staticfile_load('js',array('help'));
		echo $index->header($css,$js);
		
		/*侧边栏目导航*/
		$menu=self::quick_menu(35);

		$this->assign('slider_menu','帮助中心');
		$this->assign('menu',$menu);
		$this->display();
		echo $index->footer();

	}







	/*新闻快捷导航*/
	public function quick_menu($pid){

		$where['pid']=$pid;
		$rs=M('class')->where($where)->order('sort asc')->select();
		$menu= array();

		/*对查询大类进行整编*/			
		$menu= array();
		foreach ($rs as $key => $value) {
			if ($value['class_type']) {
				$menu[$key]['url']=U('News/pageshow?id='.$value['id']);
			}else{
				$menu[$key]['url']=U('News/index?id='.$value['id']);
			}
			$menu[$key]['class_name']=$value['class_name'];
			$menu[$key]['id']=$value['id'];
		}

		
		return $menu;

	}




	public function PageHelp(){

		if (IS_AJAX) {
			$id=I('post.id','');
			$rs=M('page')->where('uid='.$id)->find();
			if ($rs) {
				$data['code']=200;
				$data['msg']='查询成功！';
		    	$data['title']=$rs['title'];
		    	$data['keyword']=$rs['keyword'];
		    	$data['zhai']=$rs['zhai'];
		    	$data['content']=htmlspecialchars_decode($rs['content']);
			}else{
				$data['code']=400;
				$data['post_id']=$id;
				$data['msg']='暂无数据！';
			}

			$this->ajaxReturn($data);

		}else{
			$this->error('非法访问！');
		}

	}











}