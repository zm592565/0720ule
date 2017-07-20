<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class IndexController extends CommonController {
    public function index(){
        $css=parent::staticfile_load('css',array('header','index','footer'));
        $js=parent::staticfile_load('js',array('login','index'));
        $libfile = array('css' =>array('swiper/swiper-3.4.0.min') ,'js'=>array('swiper/swiper-3.4.0.jquery.min','navfix/navFixed','layer/layer'));
        $lib=parent::staticfile_load('lib',$libfile);
    	echo $header=self::header($css,$js,$lib);
    	echo $index_data=self::index_data();
    	echo $footer=self::footer();

    }

    public function header($css,$js,$lib,$send_text='发布地接'){   
    	$this->assign('css',$css);
        $this->assign('js',$js);
        $this->assign('lib',$lib);
         $this->assign('send_text',$send_text);
        $this->assign('hasLogin',A('Ask')->checkUser());
    	return $this->display('public/header');
    }



    public function index_data(){ 	

        /*加载最新地接线路*/
        $Model = new Model(); // 实例化一个model对象 没有对应任何数据表
        /*返回发帖数量最多的国家 获取地接线路表中所在地接国家超过10个线路以上的国家*/
        $rs=$Model->query("SELECT l.begin_c,c.name FROM ule_line as l,ule_country as c where l.begin_c=c.id GROUP BY l.begin_c having(count(l.begin_c)>=1) ORDER BY count(l.begin_c) DESC limit 6");

        
        /*注入国家信息*/
        if ($rs) {
            $this->assign('country',$rs);
        }

        $liesList=array();
        foreach ($rs as $key => $value) {

            $liesList[$key]=$Model->query("SELECT line.*, country.name as countryName
, province.name as provinceName
, member.member_face
, city.name as cityName
, member.member_name as memberName
, member.member_email as memberEmail From ule_line line
left join ule_member member on line.send_user = member.id
left join ule_country country on line.begin_c = country.id
left join ule_country province on line.begin_s = province.id
left join ule_country city on line.begin_city = city.id where line.begin_c=".$value['begin_c']."
Order by line.start_time DESC limit 8");
        }


        $this->assign('newlines',$liesList);




        /*注入会员发帖排行榜*/
        $top_member=M('member')->order('member_integral desc')->limit(10)->select();
        if ($top_member) {

            $topArr=array();

            foreach ($top_member as $key => $value) {
                $face=json_decode($value['member_face'],true);
                $topArr[$key]['member_face']=$face['small'];
                $topArr[$key]['member_ename']=$value['member_ename'];
                $topArr[$key]['member_email']=$value['member_email'];
                $topArr[$key]['id']=$value['id'];
                $topArr[$key]['member_integral']=$value['member_integral'];
            }


            $this->assign('top_member',$topArr);
        }



        /*注入最新悠乐帮*/
            $hot_ask=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')->order('a.ask_add desc')->limit(5)->select();

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

             $this->assign('new_ask',$rs);

            }


             /*注入热门求助*/
            $hot_ask=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_user=m.id')->order('a.ask_answer desc')->limit(5)->select();

            if ($hot_ask) {

             /*重新整理数据*/
             $hotrs=array();
             foreach ($hot_ask as $key => $value) {
                    
                 $hotrs[$key]['id']=$value['id'];
                 //$rs[$key]['ask_content']=htmlspecialchars_decode($value['ask_content']);

                /*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
                if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
                    $hotrs[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
                };

                 $hotrs[$key]['ask_title']=$value['ask_title'];
                 $hotrs[$key]['ask_saw']=$value['ask_saw'];
                 $hotrs[$key]['ask_answer']=$value['ask_answer'];
                 $face=json_decode($value['member_face'],true);
                 if ($face['small']) {
                    $hotrs[$key]['member_face']=$face['small'];
                 }else{
                     $hotrs[$key]['member_face']=HOME_IMG_PATH."default.jpg";
                 }
                    
                 $hotrs[$key]['member_name']=$value['member_name'];
                 $hotrs[$key]['memberid']=$value['memberid'];
                 $hotrs[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
                 $hotrs[$key]['add_time']=timestr($value['ask_add'],time());
                 $tags=M('tags')->where('pid='.$value['id'])->select();
                 if (!empty($tags)) {
                     $hotrs[$key]['tags']=$tags;
                 }
                

             }

             $this->assign('hot_ask',$hotrs);

            }


            /*注入待回复*/
            $lists=M('ask')->field('a.id,a.ask_content,a.ask_title,a.ask_saw,a.ask_answer,a.ask_add,m.id as memberid,m.member_face,m.member_name,m.member_email')->table(array(DB_PREFIX.'ask' =>'a' ,DB_PREFIX.'member'=>'m' ))->where('a.ask_answer=0 AND a.ask_user=m.id')->limit(5)->order('a.ask_add desc')->select();

            if ($lists) {

             /*重新整理数据*/
             $backM=array();
             foreach ($lists as $key => $value) {
                    
                 $backM[$key]['id']=$value['id'];
                 //$rs[$key]['ask_content']=htmlspecialchars_decode($value['ask_content']);

                /*查询当前的内容里是否有图片如果有则提出来第一张图片作为缩略图显示*/
                if ($noImgHtml=replaceStr(htmlspecialchars_decode($value['ask_content']),'','/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i')) {
                    $backM[$key]['ask_content']=msubstr(strip_tags($noImgHtml),0,180,'utf-8',true);/*去除html标签后截取字符串，如果最后一个属性设置为true 则显示省略号,false 则不显示省略号*/
                };

                 $backM[$key]['ask_title']=$value['ask_title'];
                 $backM[$key]['ask_saw']=$value['ask_saw'];
                 $backM[$key]['ask_answer']=$value['ask_answer'];
                 $face=json_decode($value['member_face'],true);
                 if ($face['small']) {
                    $backM[$key]['member_face']=$face['small'];
                 }else{
                     $backM[$key]['member_face']=HOME_IMG_PATH."default.jpg";
                 }
                    
                 $backM[$key]['member_name']=$value['member_name'];
                 $backM[$key]['memberid']=$value['memberid'];
                 $backM[$key]['showurl']=U('Home/Ask/askShow?id='.$value['id']);
                 $backM[$key]['add_time']=timestr($value['ask_add'],time());
                 $tags=M('tags')->where('pid='.$value['id'])->select();
                 if (!empty($tags)) {
                     $backM[$key]['tags']=$tags;
                 }
                

             }

             $this->assign('backM',$backM);

            }



            /*首页最新地接会员*/
            $memberlist=M('member')->field('id,member_name name,member_ename ename,member_face face,member_diplace diplace,member_about about,member_email email')->where('member_isDijie=1 AND member_state=1')->order('member_reg_day desc')->limit(4)->select();



            if ($memberlist) {
                $check= A('Ask')->checkUser();
                $member_new=array();

                foreach ($memberlist as $key => $value) {
                    $member_new[$key]['id']=$value['id'];
                    $member_new[$key]['fans']=M('fans')->where('pid='.$value['id'])->Count('id');

                    if ($check) {
                        $userid=session('userid');
                        $hasfocus=M('fans')->where('userid='.$userid.' AND pid='.$value['id'])->find();
                        if ($hasfocus) {
                            $isfocus=true;
                        }else{
                            $isfocus=false;
                        }
                        $member_new[$key]['hasfocus']=$isfocus;

                    }


                    $member_new[$key]['name']=$value['name'];
                    $member_new[$key]['ename']=$value['ename'];
                    $member_new[$key]['email']=$value['email'];
                    $face=json_decode($value['face'],true);
                     if ($face['small']) {
                        $member_new[$key]['face']=$face['middle'];
                     }else{
                        $member_new[$key]['face']=HOME_IMG_PATH."default.jpg";
                     }
                    $member_new[$key]['diplace']=$value['diplace'];
                    if (empty($value['about'])) {
                        $about='这个人很懒，什么都木有留下...';
                    }else{
                        $about=$value['about'];
                    }
                    

                    $member_new[$key]['about']=$about;
                }

                 $this->assign('member_new',$member_new);
            }



        $this->display();

    }


    /*最新地接会员关注*/
    public function add_focus(){

        if (IS_AJAX) {

            $check= A('Ask')->checkUser();

            if ($check) {
                $pid=I('post.pid');
                $userid=session('userid');
                $hasfocus=M('fans')->where('userid='.$userid.' AND pid='.$pid)->find();
                if ($hasfocus) {
                   $data['state']=200;
                   $data['msg']="您已关注此会员！";
                }else{
                    $add['userid']=$userid;
                    $add['pid']=$pid;
                    $add['addfans_time']=time();
                    $addfans=M('fans')->add($add);
                    if ($addfans) {

                        $fansNum=M('fans')->where('pid='.$pid)->Count('id');
                        if ($fansNum) {
                           $data['fansNum']=$fansNum;
                        }
                        $data['state']=300;
                        $data['msg']="关注成功！";
                    }else{
                        $data['state']=400;
                        $data['msg']="很遗憾，关注会员失败。";
                    }

                }

            }else{
                $data['state']=500;
                $data['msg']="关注操作需要您先登录！";
            }

            $this->ajaxReturn($data);
           

        }

       


    }




    /*页脚*/
    public function footer(){


        $where['pid']=0;
        $rs=M('class')->where($where)->limit(5)->select();
        $data_arr=array();
        foreach ($rs as $key => $value) {
            if ($value['pid']==0) {
                $data_arr[$key]['top']=$value;
               
                $mast=array();
                $list=M('class')->where('pid='.$value['id'])->limit(5)->select();
                foreach ($list as $keys => $values) {
                    
                    if ($values['class_type']==1) {

                        switch ($values['id']) {
                            case 29:
                                $mast[$keys]['url']=U('Api/index');/*包裹追踪*/
                                break;
                            case 28:
                                $mast[$keys]['url']=U('Net/index');/*网点查询*/
                                break;
                            default:
                                $mast[$keys]['url']=U('News/pageshow?id='.$values['id']); 
                                break;
                        }


                        
                       
                    }else{
                        $mast[$keys]['url']=U('News/index?id='.$values['id']);
                    }



                    $mast[$keys]['class_name']=$values['class_name'];

                }

                $data_arr[$key]['list']=$mast;
            }
        }


        



        $this->assign('footer_menu',$data_arr);

    	return $this->display('public/footer');
    }




   





}