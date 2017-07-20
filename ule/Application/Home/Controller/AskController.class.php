<?php
namespace Home\Controller;
use Think\Controller;
class AskController extends CommonController {


	public function index(){
		$index = A('Index');
		$css=parent::staticfile_load('css',array('header','common','ulehelp','footer'));
		$js=parent::staticfile_load('js',array('header','ask'));
		$libfile = array('js'=>array('navfix/navFixed','layui/layui'),'css'=>array('layui/css/layui'));
        $lib=parent::staticfile_load('lib',$libfile);
		echo $index->header($css,$js,$lib);
	
	
		$count= M('ask')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')->count("a.id");
		$Page = new \Think\Page($count,LISTNUM);

		/*注入最新问答*/
		$rss=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name,m.member_email')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')->order('a.ask_add desc')->limit($Page->firstRow.','.$Page->listRows)->select();


		if ($rss) {

			/*重新整理数据*/
			$rs=array();
			foreach ($rss as $key => $value) {
				
				$rs[$key]['id']=$value['id'];
			
				$rs[$key]['ask_title']=$value['ask_title'];
				$rs[$key]['ask_saw']=$value['ask_saw'];
				$rs[$key]['ask_answer']=$value['ask_answer'];
				$face=json_decode($value['member_face'],true);
                 if ($face['small']) {
                    $rs[$key]['member_face']=$face['small'];
                 }else{
                     $rs[$key]['member_face']=HOME_IMG_PATH."default.jpg";
                 }
				$rs[$key]['member_email']=$value['member_email'];
				$rs[$key]['member_name']=$value['member_name'];
				$rs[$key]['memberid']=$value['memberid'];
				$rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
				$rs[$key]['add_time']=timestr($value['ask_add'],time());
				$tags=M('tags')->where('pid='.$value['id'])->select();
				$html=htmlspecialchars_decode($value['ask_content']);
				/*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
				if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
					$rs[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
				};
				
				if (!empty($tags)) {
					$rs[$key]['tags']=$tags;
				}
				

			}
			$this->assign('latest',$rs);
		}


	





		/*注入是否登录信息*/
		$this->assign('haslogin',self::checkUser());


		/*注入会员发帖排行榜*/
		$top_member=M('member')->order('member_integral desc')->limit(10)->select();
		if ($top_member) {

			$topArr=array();

			foreach ($top_member as $key => $value) {
				$face=json_decode($value['member_face'],true);
                if ($face['small']) {
                    $topArr[$key]['member_face']=$face['small'];
                }else{
                     $topArr[$key]['member_face']=HOME_IMG_PATH."default.jpg";
                }

				$topArr[$key]['member_ename']=$value['member_ename'];
				$topArr[$key]['member_email']=$value['member_email'];
				$topArr[$key]['id']=$value['id'];
				$topArr[$key]['member_integral']=$value['member_integral'];
			}


			$this->assign('top_member',$topArr);
		}

		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('count',$count);
		$this->display();
		echo $index->footer();

	}





	/*发布求助*/
	public function addAsk(){

		if (IS_AJAX) {

			$userid=session('userid');
			$title=I('post.title','');
			$contentText=I('post.contentText','');
			$usercode=session('usercode');

			if (empty($title)||mb_strlen($title, 'UTF-8')>50||mb_strlen($title, 'UTF-8')<5) {
				$data['code']=300;
		   		$data['msg']='标题不得为空,字符限制在5至50之内!';
			}elseif (empty($contentText)) {
				$data['code']=400;
		   		$data['msg']='求助详情不得为空！';
			}elseif(!isset($userid)||!isset($usercode)){
				$data['code']=600;
		   		$data['msg']='非法操作';

			}else{


				$date['ask_user']=$userid;
				$date['ask_title']=$title;
				$date['ask_content']=$contentText;
				$date['ask_add']=time();
				
				$rs=M('ask')->add($date);
				if ($rs) {
					
					/*批量添加tags*/
					$tags=I('post.tags','');
					if (!empty($tags)) {
						str_replace('，',',',$tags);
						$tags = explode(',',$tags); 
						$tagsNum=count($tags);
						if ($tagsNum>1) {
								
							/*批量给tag表插入标签*/
							$tagsList=array();
							foreach ($tags as $key => $value) {
								$value=trim($value);
								if (empty($value)) {
									continue;
								}
								$tagsList[$key]=array('name'=>$value,'pid'=>$rs,'user_id'=>$userid,'add_time'=>time());
							}

							M('tags')->addAll($tagsList);

						}else{
							$tagsdata['name']=$tags;
							$tagsdata['pid']=$rs;
							$tagsdata['userid']=$userid;
							$tagsdata['add_time']=time();
							M('tags')->add($tagsdata);
						};
						
						
					}

					/*用户操作添加积分,以及写入会员操作日志*/
					sendAask($userid,1);
					
				

					$data['code']=200;
					$data['askIndex']=U('Ask/index');
		   			$data['msg']='信息添加成功!';

				}else{

					$data['code']=500;
		   			$data['msg']='很遗憾,求助信息添加失败！';
				}

			}
			
			
		    $this->ajaxReturn($data);
		}



		$userid=session('userid');
		$usercode=session('usercode');
		if (isset($userid)&&isset($usercode)) {
			$this->display();
		}else{
			$this->error('非法操作');
		}



	}


	
	/*详情*/
	public function askShow($id=null){


		if (isset($id)&&is_numeric($id)) {
			$index = A('Index');
			$css=parent::staticfile_load('css',array('header','common','ulehelp','ask_show','footer'));
			$js=parent::staticfile_load('js',array('header','ask','askshow'));
			$libfile = array('js'=>array('navfix/navFixed','layui/layui'),'css'=>array('layui/css/layui'));
	        $lib=parent::staticfile_load('lib',$libfile);
			echo $index->header($css,$js,$lib);


			$rs=M('ask')->where('id='.$id)->find();


			if ($rs) {
				$user=M('member')->where('id='.$rs['ask_user'])->find();
				$tags=M('tags')->where('pid='.$rs['id'])->select();

				/*增加阅读次数*/
				M('ask')->where('id='.$rs['id'])->setInc('ask_saw',1); 

				/*查询是否关注问题*/
				$focus['ask_id']=$rs['id'];
				$focus['user_id']=session('userid');
				$focusRs=M('focus_ask')->where($focus)->find();
				if ($focusRs) {
					$this->assign('hasfocus',true);
				}

				/*问题回答列表*/
				$answer=M('ask_answer')->field('a.*,m.id as member_id,m.member_name,m.member_email,m.member_face')->table(array(DB_PREFIX.'ask_answer' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.askpid='.$rs['id'].' AND a.userid=m.id')->order('a.addtime desc')->select();
				if ($answer) {
					$hasAnswer=array();
					foreach ($answer as $key => $value) {
						$hasAnswer[$key]['id']=$value['id'];
						$hasAnswer[$key]['askpid']=$value['askpid'];
						$hasAnswer[$key]['userid']=$value['userid'];
						$hasAnswer[$key]['content']=htmlspecialchars_decode($value['content']);
						$hasAnswer[$key]['addtime']=date('Y/m/d H:i:s',$value['addtime']);
						$hasAnswer[$key]['pid']=$value['pid'];
						$hasAnswer[$key]['member_id']=$value['member_id'];
						$hasAnswer[$key]['member_name']=$value['member_name'];
						$hasAnswer[$key]['member_email']=$value['member_email'];
						$face=json_decode($value['member_face'],true);
						$hasAnswer[$key]['member_face']=$face['small'];
						$hasAnswer[$key]['support']=$value['support'];
						/*这条回复的跟帖*/
						$haschildAnswer=M('ask_answer')->field('a.*,m.id as member_id,m.member_name,m.member_email,m.member_face')->table(array(DB_PREFIX.'ask_answer' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.pid='.$value['id'].' AND a.userid=m.id')->order('addtime asc')->select();
						if ($haschildAnswer) {
							$childAnswer=array();
							foreach ($haschildAnswer as $keychild => $valuechild) {
								$childAnswer[$keychild]['id']=$valuechild['id'];
								$childAnswer[$keychild]['userid']=$valuechild['userid'];
								$childAnswer[$keychild]['content']=htmlspecialchars_decode($valuechild['content']);
								$childAnswer[$keychild]['addtime']=date('Y/m/d H:i:s',$valuechild['addtime']);

								$childAnswer[$keychild]['support']=$valuechild['support'];
								$childAnswer[$keychild]['member_id']=$valuechild['member_id'];
								$childAnswer[$keychild]['member_email']=$valuechild['member_email'];
								$childAnswer[$keychild]['member_name']=$valuechild['member_name'];
								$face=json_decode($valuechild['member_face'],true);
								$childAnswer[$keychild]['member_face']=$face['small'];
							}

							$hasAnswer[$key]['childAnswer']=$childAnswer;
						}


					}

					$this->assign('hasAnswer',$hasAnswer);

				}




				$this->assign('content',$rs);
				$this->assign('tags',$tags);
				$this->assign('addtime',$rs['ask_add']);


				$face=json_decode($user['member_face'],true);
				$this->assign('face',$face['small']);

				$this->assign('user',$user);

			}else{
				$this->error('您要查找的内容不存在!');
			}
			
		}else{
			$this->error('小子,你的非法操作导致需要的页面丢失了哟!');
		}

		if (session('userid')&&session('usercode')) {
			$where['id']=session('userid');
			$where['member_code']=session('usercode');
			$userlogin=M('member')->where($where)->find();
			if ($userlogin) {
				$this->assign('haslogin',true);
			}
			
		}

		$this->display();
		echo $index->footer();

	}


	/*关注问题 ajax请求*/
	public function focusAsk(){

		if (IS_AJAX) {
				
			if ($userid=session('userid')&&$usercode=session('usercode')) {
				$where['id']=session('userid');
				$where['member_code']=session('usercode');
				$user=M('member')->where($where)->find();

				if ($user) {
					
					
					$id=I('post.askid');
					$rs=M('focus_ask')->where('ask_id='.$id.' AND user_id='.session('userid'))->find();
					if ($rs) {
						$data['code']=400;
						$data['msg']='您已关注此求助信息!';
					}else{
						$date['ask_id']=$id;
						$date['user_id']=session('userid');
						$date['focus_time']=time();
						$addfocus=M('focus_ask')->data($date)->add();
						if ($addfocus) {
							$data['code']=200;
							$data['msg']='您已成功关注此求助信息!';
							$data['user']=$user;
						}else{
							$data['code']=500;
							$data['msg']='很遗憾,关注求助信息失败！';
						}
						
					};

				}else{

					$data['code']=300;
					$data['msg']='非法会员信息!';

				};
			}else{
				$data['code']=600;
				$data['msg']='请您先登录!';
			}
			
			$this->ajaxReturn($data);

		};
		$this->error('哈哈哈,小朋友,你走错地方了吧...');
	}



	/*添加回复*/
	public function addAnswer(){

		if (IS_AJAX) {	
			$haslogin=self::checkUser();
			if ($haslogin) {
				$data['userid']=session('userid');
				$data['askpid']=I('post.askpid');
				$data['content']=I('post.content');
				$data['addtime']=time();
				$rs=M('ask_answer')->data($data)->add();
				if ($rs) {

					/*给ask表写入回答条数*/
					M('ask')->where('id='.I('post.askpid'))->setInc('ask_answer',1); 

					sendAask($data['userid'],3);


					$data['code']=200;
					$data['msg']='恭喜您,发布回复成功!';
				}else{
					$data['code']=400;
					$data['msg']='很遗憾,发布回复失败！';
				}

			}else{
				$data['code']=600;
				$data['msg']='请您先登录!';
			}

			$this->ajaxReturn($data);

		}

		$this->error('哈哈哈,小朋友,你走错地方了吧...');

	}



	/*验证是否已经登录并且验证登录信息是否合法*/
	public function checkUser(){

		if ($userid=session('userid')&&$usercode=session('usercode')) {

			$where['id']=session('userid');
			$where['member_code']=session('usercode');
			$user=M('member')->where($where)->find();
			if ($user) {
				return ture;
			}else{
				return false;
			}

		}else{
			return false;
		}

	}


	/*给回答添加评论*/
	public function askAnswerAdd(){
		
		if (IS_AJAX) {
			$haslogin=self::checkUser();
			if ($haslogin) {
				
				$data['pid']=I('post.pid','');
				$data['userid']=session('userid');
				$data['addtime']=time();
				$data['content']=I('post.content','');

				$rs=M('ask_answer')->data($data)->add();
				if ($rs) {
					$data['code']=200;
					$data['msg']='恭喜您,添加回复成功!';
				}else{
					$data['code']=400;
					$data['msg']='很遗憾,添加回复失败!';
				}

			}else{
				$data['code']=600;
				$data['msg']='请您先登录!';
			}


			$this->ajaxReturn($data);
		}

		$this->error('哈哈哈,小朋友,再胡乱蹿,小尾巴给你剪掉...');

	}




	/*js调用热门求助等信息*/
	public function AjaxLoadData(){

		if (IS_AJAX) {

			/*热门求助,一次性加载数据*/
			// $hot_ask=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')->order('a.ask_answer desc')->select();

			// if ($hot_ask) {

			// 	/*重新整理数据*/
			// 	$rs=array();
			// 	foreach ($hot_ask as $key => $value) {
					
			// 		$rs[$key]['id']=$value['id'];
			// 		$rs[$key]['ask_content']=htmlspecialchars_decode($value['ask_content']);
			// 		$rs[$key]['ask_title']=$value['ask_title'];
			// 		$rs[$key]['ask_saw']=$value['ask_saw'];
			// 		$rs[$key]['ask_answer']=$value['ask_answer'];
			// 		if ($value['member_face']) {
			// 			$rs[$key]['member_face']=$value['member_face'];
			// 		}else{
			// 			$rs[$key]['member_face']=HOME_IMG_PATH."default.jpg";
			// 		}
					
			// 		$rs[$key]['member_name']=$value['member_name'];
			// 		$rs[$key]['memberid']=$value['memberid'];
			// 		$rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
			// 		$rs[$key]['add_time']=timestr($value['ask_add'],time());
			// 		$tags=M('tags')->where('pid='.$value['id'])->select();
			// 		if (!empty($tags)) {
			// 			$rs[$key]['tags']=$tags;
			// 		}
				

			// 	}


			// 	$data['pagesize']=LISTNUM;
			// 	$data['code']=200;
			// 	$data['data']=$rs;
			// 	$data['msg']='获取成功!';




			// }else{

			// 	$data['code']=400;
			// 	$data['msg']='暂无数据!';
			// }

			// $this->ajaxReturn($data);







			/*根据返回的页面加载数据，这样比较有效率*/
			header('Content-Type:text/html;charset=utf-8');

		    // 获取当前页码，默认第一页，设置每页默认显示条数
		    $nowpage = I('get.page', 1, 'intval');


		    /*每页显示的数据量pagesize*/
		    $limits = LISTNUM;

		    // 获取总条数
		    $count=M('ask')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')-> count();

		    if ($count) {
		    	/*计算获取到当前页码之后从数据库中的哪条开始取我们规定的条数*/
			    $since=$nowpage* $limits-$limits;


			    // 计算总页面
			    $allpage = ceil($count / $limits);
			    $allpage = intval($allpage);


			    $lists=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name,m.member_email')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')->limit($since, $limits)->order('a.ask_answer desc')->select();


			    if ($lists) {

					/*重新整理数据*/
					$rs=array();
					foreach ($lists as $key => $value) {
						
						$rs[$key]['id']=$value['id'];

						/*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
						if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
							$rs[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
						};
						$rs[$key]['ask_title']=$value['ask_title'];
						$rs[$key]['ask_saw']=$value['ask_saw'];
						$rs[$key]['ask_answer']=$value['ask_answer'];

						$face=json_decode($value['member_face'],true);

		                if ($face['small']) {
		                    $rs[$key]['member_face']=$face['small'];
		                }else{
		                     $rs[$key]['member_face']=HOME_IMG_PATH."default.jpg";
		                }

						$rs[$key]['member_name']=$value['member_name'];
						$rs[$key]['member_email']=$value['member_email'];
						$rs[$key]['memberid']=$value['memberid'];
						$rs[$key]['memberurl']=U('Home/Usercenter/index?id='.$value['memberid']);
						$rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
						$rs[$key]['add_time']=timestr($value['ask_add'],time());
						$tags=M('tags')->where('pid='.$value['id'])->select();

						if ($tags) {
							$arrtag=array();
							foreach ($tags as $keys => $values) {
								$arrtag[$keys]['name']=$values['name'];
								$arrtag[$keys]['tagurl']=U("Ask/searchAskTag?tag=".$values['name']);
							}
							$rs[$key]['tags']=$arrtag;

						}
					

					}
				}

				 // ajax 分页输出
		   		 $info = array('lists'=>$rs,'allpage'=>$allpage,'nowpage'=>$nowpage,'pagesize'=>$limits,'code'=>200,'msg'=>'请求成功！');

		    }else{
		    	 // ajax 分页输出
		   		 $info = array('lists'=>$rs,'allpage'=>$allpage,'nowpage'=>$nowpage,'pagesize'=>$limits,'code'=>400,'msg'=>'暂无数据！');
		    }   
		   
		    $this->ajaxReturn($info,'json');
	
		}
		
		$this->error('哈哈哈,小朋友,再胡乱蹿,小尾巴给你剪掉...');
	}




	/*待回复ajax传递数据方法*/
	public function waitBack()
	{
		if (IS_AJAX) {
		

		/*根据返回的页面加载数据，这样比较有效率*/
			header('Content-Type:text/html;charset=utf-8');

		    // 获取当前页码，默认第一页，设置每页默认显示条数
		    $nowpage = I('get.page', 1, 'intval');


		    /*每页显示的数据量pagesize*/
		    $limits = LISTNUM;

		    // 获取总条数
		    $count=M('ask')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_answer=0 AND a.ask_user=m.id')-> count();


		    if ($count) {
		    	/*计算获取到当前页码之后从数据库中的哪条开始取我们规定的条数*/
			    $since=$nowpage* $limits-$limits;


			    // 计算总页面
			    $allpage = ceil($count / $limits);
			    $allpage = intval($allpage);


			    $lists=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name,m.member_email')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_answer=0 AND a.ask_user=m.id')->limit($since, $limits)->order('a.ask_add desc')->select();


			    if ($lists) {

					/*重新整理数据*/
					$rs=array();
					foreach ($lists as $key => $value) {
						
						$rs[$key]['id']=$value['id'];
						/*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
						if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
							$rs[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
						};
						$rs[$key]['ask_title']=$value['ask_title'];
						$rs[$key]['ask_saw']=$value['ask_saw'];
						$rs[$key]['ask_answer']=$value['ask_answer'];
						$face=json_decode($value['member_face'],true);
		                 if ($face['small']) {
		                    $rs[$key]['member_face']=$face['small'];
		                 }else{
		                     $rs[$key]['member_face']=HOME_IMG_PATH."default.jpg";
		                 }
						
						
						$rs[$key]['member_name']=$value['member_name'];
						$rs[$key]['member_email']=$value['member_email'];
						$rs[$key]['memberid']=$value['memberid'];
						$rs[$key]['memberurl']=U('Home/Usercenter/index?id='.$value['memberid']);
						$rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
						$rs[$key]['add_time']=timestr($value['ask_add'],time());
						$tags=M('tags')->where('pid='.$value['id'])->select();
						if ($tags) {
							$arrtag=array();
							foreach ($tags as $keys => $values) {
								$arrtag[$keys]['name']=$values['name'];
								$arrtag[$keys]['tagurl']=U("Ask/searchAskTag?tag=".$values['name']);
							}
							$rs[$key]['tags']=$arrtag;

						}
					

					}
				}

				 // ajax 分页输出
		   		 $info = array('lists'=>$rs,'allpage'=>$allpage,'nowpage'=>$nowpage,'pagesize'=>$limits,'counts'=>$count,'code'=>200,'msg'=>'请求成功！');

		    }else{
		    	 // ajax 分页输出
		   		 $info = array('lists'=>$rs,'allpage'=>$allpage,'nowpage'=>$nowpage,'pagesize'=>$limits,'code'=>400,'msg'=>'暂无数据！');
		    }   
		   
		    $this->ajaxReturn($info,'json');
	
		}
		
		$this->error('哈哈哈,小朋友,再胡乱蹿,小尾巴给你剪掉...');
	}




	/*检索答案*/
	public function searchAsk(){

		if (IS_GET) {
			$title=I('get.title','');

			if (!empty($title)) {
			

				$count=M('ask')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_title LIKE "%'.$title.'%" AND a.ask_user=m.id')->count("a.id");

				$Page = new \Think\Page($count,LISTNUM);


				$rss=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name,m.member_email')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_title LIKE "%'.$title.'%" AND a.ask_user=m.id')->limit($Page->firstRow.','.$Page->listRows)->order('a.ask_add desc')->select();

				

				if ($rss) {

						/*重新整理数据*/
						$rs=array();
						foreach ($rss as $key => $value) {
							
							$rs[$key]['id']=$value['id'];
						

							/*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
							if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
								$rs[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
							};

							$rs[$key]['ask_title']=$value['ask_title'];
							$rs[$key]['ask_saw']=$value['ask_saw'];
							$rs[$key]['ask_answer']=$value['ask_answer'];
							$face=json_decode($value['member_face'],true);
							$rs[$key]['member_face']==$face['small'];
							$rs[$key]['member_email']=$value['member_email'];
							$rs[$key]['member_name']=$value['member_name'];
							$rs[$key]['memberid']=$value['memberid'];
							$rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
							$rs[$key]['add_time']=timestr($value['ask_add'],time());
							$tags=M('tags')->where('pid='.$value['id'])->select();
							if (!empty($tags)) {
								$rs[$key]['tags']=$tags;
							}
							

						}



					$this->assign('title',$title);
					$this->assign('info',$rs);
					$show = $Page->show();// 分页显示输出
					$this->assign('page',$show);// 赋值分页输出
					$this->assign('count',$count);
				}else{
					$this->assign('title',$title);
				}

			}else{

				$this->assign('titlempty',true);

			}

			

		}



		$index = A('Index');
		$css=parent::staticfile_load('css',array('header','common','ulehelp','footer'));
		$js=parent::staticfile_load('js',array('header','ask'));
		$libfile = array('js'=>array('navfix/navFixed','layui/layui'),'css'=>array('layui/css/layui'));
        $lib=parent::staticfile_load('lib',$libfile);
		echo $index->header($css,$js,$lib);



		$this->display('search');
		echo $index->footer();

	}



	/*检索tag标签，在tag表中查找*/
	public function searchAskTag(){

 		// // 1. 初始化
        //  $ch = curl_init();
        //  // 2. 设置选项，包括URL
        //  curl_setopt($ch,CURLOPT_URL,"http://www.devdo.net");
        //  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //  curl_setopt($ch,CURLOPT_HEADER,0);
        //  // 3. 执行并获取HTML文档内容
        //  $output = curl_exec($ch);
        //  if($output === FALSE ){
        //  echo "CURL Error:".curl_error($ch);
        //  }
        //  // 4. 释放curl句柄
        //  curl_close($ch);

		if (IS_GET) {
			$tag=I('get.tag','');

			if (!empty($tag)) {

				$where['name']=$tag;
				$count=M('tags')->table(array(DB_PREFIX.'tags'=>'t',DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m'))->where('t.name ="'.$tag.'" AND t.pid=a.id AND a.ask_user=m.id')->count("t.id");
				$Page = new \Think\Page($count,LISTNUM);
				$rss=M('tags')
				->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name,m.member_email,t.name as tagname')
				->table(array(DB_PREFIX.'tags'=>'t',DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m'))
				->where('t.name ="'.$tag.'" AND t.pid=a.id AND a.ask_user=m.id')
				->limit($Page->firstRow.','.$Page->listRows)
				->order('a.ask_add desc')
				->select();

				if ($rss) {

						/*重新整理数据*/
						$rs=array();
						foreach ($rss as $key => $value) {
							
							$rs[$key]['id']=$value['id'];
							

							/*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
							if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
								$rs[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
							};

							$rs[$key]['ask_title']=$value['ask_title'];
							$rs[$key]['ask_saw']=$value['ask_saw'];
							$rs[$key]['ask_answer']=$value['ask_answer'];
							$face=json_decode($value['member_face'],true);
							$rs[$key]['member_face']==$face['small'];
							$rs[$key]['member_email']=$value['member_email'];
							$rs[$key]['member_name']=$value['member_name'];
							$rs[$key]['memberid']=$value['memberid'];
							$rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
							$rs[$key]['add_time']=timestr($value['ask_add'],time());
							$tags=M('tags')->where('pid='.$value['id'])->select();
							if (!empty($tags)) {
								$rs[$key]['tags']=$tags;
							}
							

						}


					$this->assign('title',$tag);
					$this->assign('info',$rs);
					$show = $Page->show();// 分页显示输出
					$this->assign('page',$show);// 赋值分页输出
					$this->assign('count',$count);

				}else{
					$this->assign('title',$tag);
				}

			}else{

				$this->assign('titlempty',true);

			}

			

		}



		$index = A('Index');
		$css=parent::staticfile_load('css',array('header','common','ulehelp','footer'));
		$js=parent::staticfile_load('js',array('header','ask'));
		$libfile = array('js'=>array('navfix/navFixed','layui/layui'),'css'=>array('layui/css/layui'));
        $lib=parent::staticfile_load('lib',$libfile);
		echo $index->header($css,$js,$lib);



		$this->display('search');
		echo $index->footer();

	}








}