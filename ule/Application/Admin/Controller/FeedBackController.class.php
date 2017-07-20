<?php
/**
 * 评论
 */
namespace Admin\Controller;
use Think\Controller;

class FeedBackController extends CommonController {
	/**
	 * 列表
	 */
	public function index(){
		$count= M('message')->count("id");
		$Page = new \Think\Page($count,LISTNUM);

		$feedback_list=M('message')->field('s.id,s.message_info,s.state,s.add_time,m.member_name,s.admire') ->table(array(DB_PREFIX.'member'=>'m',DB_PREFIX.'message'=>'s')) ->where('s.user_id=m.id')->limit($Page->firstRow.','.$Page->listRows)->order('add_time desc')->select();
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('count',$count);
		$this->assign('feedback_list',$feedback_list);
		$this->display();
	}
	/**
	 * 删除单条
	 */
	public function delOne(){
		$return_array = array('state'=>0,'info'=>'删除失败');
		$id = I('id',0);

		if(!empty($id)){
			$condition = array();
			$condition['id'] = $id;
			$feedback_Model = M('message');
			$re = $feedback_Model->where($condition)->delete();
			if(!empty($re)){
				$return_array = array('state'=>1,'info'=>'删除成功');
			}
		}

		echo json_encode($return_array);
	}


	/*显示或者隐藏留言信息*/
	function updateMessageState($id,$state){

		
		switch ($state) {
			case '0':
				$data['state']=1;
				break;

			case '1':
				$data['state']=0;
				break;

			default:
				$data['state']=0;
				break;
		}

		$rs=M('message')->where('id='.$id)->save($data);
		if ($rs) {
			$this->redirect('FeedBack/index');
		}else{
			$this->error('很遗憾,会员状态修改失败！','FeedBack/index');
		}

	}



}