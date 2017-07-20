<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class UsercenterController extends CommonController{

	public function index($id=null){
		if (empty($id)) {
			$this->error('非法访问！');
		}
		$index = A('Index');
		$css=parent::staticfile_load('css',array('header','common','userPage','footer'));
		$js=parent::staticfile_load('js',array('header','userpage'));
		$libfile = array('js'=>array('navfix/navFixed','layui/layui'),'css'=>array('layui/css/layui'));
        $lib=parent::staticfile_load('lib',$libfile);
		echo $index->header($css,$js,$lib);


		$rss=M('member')->where('id='.$id)->find();

		if (!$rss) {
			$this->error('信息不存在或者错误~');
		}



        /*判断当前登录会员是否关注此个人主页的会员*/
        $userid=session('userid');
        if($userid){
            $rsFans=M('fans')->where('userid='.$userid.' AND pid='.$id)->find();
            if ($rsFans) {
                $this->assign('hasfocus',true);
            }else{
                $this->assign('hasfocus',false);
            }
        }




		$face=json_decode($rs['member_face'],true);
        if ($face['small']) {
           $userPageFace=$face['big'];
        }else{
           $userPageFace=HOME_IMG_PATH."default.jpg";
        }

        $diplace=json_decode($rs['member_diplace'],true);

        if ($diplace['selcountry']==''||empty($diplace['selcountry'])) {
            $this->assign('country','未定义国家');
        }else{
             $country=M('country')->where('id='.$diplace['selcountry'])->find();
             $this->assign('country',$country['name']);
        }


       

        if ($diplace['selstate']==''||empty($diplace['selstate'])) {
        	$this->assign('selstate',false);
        }else{
        	 $selstate=M('country')->where('id='.$diplace['selstate'])->find();
        	 $this->assign('selstate',$selstate['name']);
        }

        if ($diplace['selcity']==''||empty($diplace['selcity'])) {
        	$this->assign('selcity',false);
        }else{
        	 $selstate=M('country')->where('id='.$diplace['selcity'])->find();
        	 $this->assign('selcity',$selstate['name']);
        }
       
     
    
        $this->assign('userPageFace',$userPageFace);
        $this->assign('userInfo',$rss);
        $this->assign('MessageListUrl',U('Home/Usercenter/MessageList?id='.$rss['id']));

        /*我的粉丝数（关注我的人）*/
        $fansNum=M('fans')->where('pid='.$id)->count('id');
        $this->assign('fansNum',$fansNum);



        /*我发布的地接线路*/
        $listLine=M('line')->where('send_user='.$id)->select();
        $this->assign('listLine',$listLine);


        /*我发布的悠乐幇*/
            $hot_ask=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('ask_user='.$id.' AND a.ask_user=m.id')->order('a.ask_add desc')->select();

            if ($hot_ask) {

             /*重新整理数据*/
             $rs=array();
             foreach ($hot_ask as $key => $value) {
                    
                 $rs[$key]['id']=$value['id'];
                 //$rs[$key]['ask_content']=htmlspecialchars_decode($value['ask_content']);

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
                 $rs[$key]['memberid']=$value['memberid'];
                 $rs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
                 $rs[$key]['add_time']=timestr($value['ask_add'],time());
                 $tags=M('tags')->where('pid='.$value['id'])->select();
                 if (!empty($tags)) {
                     $rs[$key]['tags']=$tags;
                 }
                

             }

             $this->assign('listAsk',$rs);

            }

		$this->display();


        echo $index->footer();
	}


	


    /*个人主页ajax发布留言*/
    public function sendMessageUserPage(){

        if (IS_AJAX) {
            $hasLogin=A('Ask')->checkUser();

            if (!$hasLogin) {
                $data['code']=300;
                $data['msg']='留言需要您先登录悠乐';
            }else{

                $adddata['content']=I('post.content');
                $adddata['pid']=0;
                $adddata['senduser']=session('userid');
                $adddata['touser']=I('post.touser');
                $adddata['addtime']=time();
                $adddata['messType']=3;

                $rs=M('comments')->add($adddata);

                if ($rs) {
                    $data['code']=200;
                    $data['msg']='恭喜您,留言成功。';
                }else{
                    $data['code']=400;
                    $data['msg']='很遗憾,留言失败!'; 
                }
               
            }

            $this->ajaxReturn($data);

        }


    }




    /*留言列表ajax分页请求*/
    public function MessageList($id)
    {
        if (IS_AJAX) {


        /*根据返回的页面加载数据，这样比较有效率*/
            header('Content-Type:text/html;charset=utf-8');

            // 获取当前页码，默认第一页，设置每页默认显示条数
            $nowpage = I('get.page', 1, 'intval');


            /*每页显示的数据量pagesize*/
            $limits = LISTNUM;

            // 获取总条数
            $count=M('comments')
            ->table(array(DB_PREFIX.'comments' =>'c' ,DB_PREFIX.'member'=>'m' ))
            ->where('c.touser='.$id.' AND c.messType=3')
            -> count();


                if ($count) {
                    /*计算获取到当前页码之后从数据库中的哪条开始取我们规定的条数*/
                    $since=$nowpage* $limits-$limits;


                    // 计算总页面
                    $allpage = ceil($count / $limits);
                    $allpage = intval($allpage);

                    $Model = new Model();

                    $lists=$Model->query("SELECT c.*,sen.*,tou.* From ule_comments c
                                    left join ule_member sen on c.senduser = sen.id 
                                    left join ule_member tou on c.touser = tou.id 
                                    where c.touser=".$id." AND c.pid=0 AND c.messType=3
                                    Order by c.addtime DESC limit ".$since.", ".$limits);


                    // $lists=M('ask')->field('a.*')
                    // ->table(array(DB_PREFIX.'comments' =>'a' ,DB_PREFIX.'member'=>'m' ))
                    // ->where('a.touser='.$id.' AND a.senduser=m.id AND a.pid=0 AND a.messType=3')
                    // ->limit($since, $limits)
                    // ->order('a.addtime desc')
                    // ->select();


                     
               
                $this->ajaxReturn($lists,'json');
        
            }
        }
            // $this->error('哈哈哈,小朋友,再胡乱蹿,小尾巴给你剪掉...');
        

    }





	









}

?>