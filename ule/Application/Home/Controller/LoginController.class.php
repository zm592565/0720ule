<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends CommonController {

    public function index(){

        if (IS_AJAX) {
            
            $user=I('post.user','');
            $pass=I('post.password','');

            $pattern="/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/";
            if(preg_match($pattern,$user)){

                $where['member_email']=$user;
                $rs=M('member')->field('id,member_code,member_pass,member_email,member_state,member_name')->where($where)->find();
                if ($rs) {
                    $newPass=PassMakes($pass,$rs['member_code']);
                    if ($newPass==$rs['member_pass']) {
                        $data['code']=200;
                        $data['msg']='恭喜您,登录成功！';
                        session('userid',$rs['id']);
                        session('usercode',$rs['member_code']);
                        session('useremail',$rs['member_email']);
                        session('userstate',$rs['member_state']);
                        session('username',$rs['member_name']);

                    }else{
                        $data['code']=500;
                        $data['msg']='帐号或者密码不匹配，请重新在输入！';
                    }

                }else{
                    $data['code']=400;
                    $data['msg']='您输入的帐号不存在,请重新输入！';
                }

            }else{
                $data['code']=300;
                $data['msg']='非法操作！';
            };

            $this->ajaxReturn($data);

        }


         /*如果登录则跳转到首页*/
        if (A('Ask')->checkUser()) {
           $this->redirect('Home/Index');
        }else{
            /*注入css样式*/
            $css=parent::staticfile_load('css',array('login_reg'));
            $js=parent::staticfile_load('js',array('login'));

            $this->assign('css',$css);
            $this->assign('js',$js);
            $this->display();

        }

    }


    /*注册*/
    public function reg(){

        if (IS_AJAX) {
            
            $email=I('post.email');
            $pass=I('post.pass');

            $patternEmail = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/"; //验证邮箱的正则表达式
            $patternPassword="/^[0-9a-zA-Z_]{6,15}$/";//密码必须是6-15位的字母，数字或者下划线组成

            if(preg_match($patternEmail,$email)&&preg_match($patternPassword,$pass)){

                    $date['member_email']=$email;
                    $date['member_code']=generate_password();
                    $date['member_pass']=PassMakes($pass,$date['member_code']);
                    $date['member_reg_day']=time();
                    $date['member_from']=0;

                    $rs=M('member')->field('member_email,member_code,member_pass,member_reg_day,member_from')->data($date)->add();

                    if ($rs) {
                        $rss=M('member')->where('id='.$rs)->find();
                        session('userid',$rss['id']);
                        session('usercode',$rss['member_code']);
                        session('useremail',$rss['member_email']);

                        $data['code']=200;
                        $data['index']=U('Home/Index');
                        $data['msg']='恭喜您,注册成功！';
                    }else{
                        $data['code']=400;
                        $data['msg']='很遗憾,注册失败！';
                    }

            }else{

                $data['code']=500;
                $data['msg']='帐号或者密码格式不匹配，请重新在输入！';
            }
            
            $this->ajaxReturn($data);

        }


        $check=A('Ask')->checkUser();

        if ($check) {
           
             $this->redirect('Home/Index');

        } else {
           /*注入css样式*/
            $css=parent::staticfile_load('css',array('login_reg'));
            $js=parent::staticfile_load('js',array('login'));

            $this->assign('css',$css);
            $this->assign('js',$js);
            $this->display('reg');
        }
        
        
    }


    /*
        注册时验证邮箱格式是否正确
    */
    public function checkReg_Email(){

        if (IS_AJAX) {
            $email=I('post.email');
            $pattern="/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/";
            if(preg_match($pattern,$email)){

                $date['member_email']=$email;
                $rs=M('member')->where($date)->find();
                if ($rs) {
                    $data['code']=300;
                    $data['msg']='很遗憾,此邮箱已被注册！';
                }else{
                    $data['code']=200;
                    $data['msg']='恭喜您，此邮箱可以注册！';
                }

            }else{

                $data['code']=400;
                $data['msg']='请输入正确的邮箱地址';
            }



            $this->ajaxReturn($data);
        }else{

            $this->error('非法访问！');


        }



    }



    /*注册完之后第一步*/
    public function RegFrist(){

        $check= A('Ask')->checkUser();
        if (!$check) {
           echo "<script>window.parent.location.href='".U('Login/reg')."'</script>";
           return false;
        }else{
            $this->display('frist');
        }

    }


    /*只是更新除头像之外的字段*/
    public function UpfaceImg(){

        $check= A('Ask')->checkUser();
        if (IS_AJAX) {
                       
                $data=I('post.');

                $begin_c=I('post.selcountry');
                $begin_s=I('post.selstate',0);
                $begin_city=I('post.selcity',0);
                
                $member_diplace=array('selcountry'=>$begin_c,'selstate'=>$begin_s,'selcity'=>$begin_city);
                $updata['member_name']=$data['ename'];
                $updata['member_isDijie']=$data['open'];
                $updata['member_diplace']=json_encode($member_diplace);
                $rs=M('member')->where('id='.session('userid'))->data($updata)->save();
                
                if ($rs) {
                    $res['code']=200;
                    $res['msg']='会员资料更新成功'; 
                } else {
                    $res['code']=400;
                    $res['msg']='会员资料更新失败！'; 
                }
                     
            $this->ajaxReturn($res);
        }


        
        if ($check) {
            $this->assign('useremail',session('useremail'));

            $country=M('country')->where('pid=0')->select();
            $sheng=M('country')->where('pid=1')->select();
            $city=M('country')->where('pid=2')->select();

            $this->assign('country',$country);
            $this->assign('sheng',$sheng);
            $this->assign('city',$city);

            $where['id']=session('userid');
            $where['member_code']=session('usercode');
            $user=M('member')->where($where)->find();
            if ($user) {
                $faceUser=json_decode($user['member_face'],true);
               $this->assign('userface',$faceUser['big']);
            }

            $this->display('upface');
        }else{
           echo "<script>window.parent.location.href='".U('Login/reg')."'</script>";
           return false;  
        }
    }




    /*单纯上传头像*/
    public function loadfaceImg(){

        if (IS_AJAX) {

            if($_FILES['file_face']['error']>0){
                $data['code']=900;
                $data['msg']='很遗憾图片上传失败!';

            }else{
                $size=$_FILES['file_face']['size'];
                if ($size>204800) {
                    $data['code']=1000;
                    $data['msg']='图片大小不得超过200KB';
                }else{

                    $name=$_FILES['file_face']['name'];
                    $tmp_name=$_FILES['file_face']['tmp_name'];
                    $type = strtolower(substr($name,strrpos($name,'.')+1));
                    $allow_type=array('jpg','jpeg','gif','png','pjpeg');

                    //判断文件类型是否被允许上传
                    if(!in_array($type, $allow_type)){
                      //如果不被允许，则返回
                      $data['code']=500;
                      $data['msg']='文件格式错误！';
                    }

                    //判断是否是通过HTTP POST上传的
                    if(!is_uploaded_file($tmp_name)){
                        //如果不是通过HTTP POST上传的
                        $data['code']=300;
                        $data['msg']='非法上传！';
                    }


                    /*设定上传路径*/
                    $day=date('Y-m-d',time());
                    $rooturl='./Uploads/face/'.$day.'/';


                    $num=rand(0,time());//给一个随机数
                    $imgName=time().$num.'.'.$type;
                    $new_file = $rooturl.$imgName;/*定义图片路径以及名称*/

                    $backUrl=__ROOT__.'/Uploads/face/'.$day.'/'.$imgName;


                    /*创建存储目录*/
                    if (!is_dir($rooturl)||!is_writeable($rooturl)){       
                    //判断这个主目录不存在，或者这个目录不可写，我们就创建它
                    
                        if (!mkdir($rooturl,0777,1)){
                            /*目录创建失败*/
                            $data['code']=400;
                            $data['msg']='很遗憾目录创建失败!';

                        };
                        
                    };

                    //开始移动文件到相应的文件夹
                    if(move_uploaded_file($tmp_name,$new_file)){

                        $face['native']=$backUrl;
                        $face['big']=parent::facethumb($new_file,120,120);
                        $face['middle']=parent::facethumb($new_file,70,70);
                        $face['small']=parent::facethumb($new_file,40,40);
                        $updata['member_face']=json_encode($face);
                        $rs=M('member')->where('id='.session('userid'))->data($updata)->save();
                        if ($rs) {
                            $data['code']=200;
                            $data['bigimg']=$face['big'];
                            $data['msg']='上传成功!';
                        }else{
                            $data['code']=800;
                            $data['msg']='很遗憾图片上传失败!';
                        }
                       
                    }else{
                        $data['code']=700;
                        $data['msg']='很遗憾上传失败!';
                    }


                }

                
                




            }
          

            $this->ajaxReturn($data);
        }



    }



    public function lastFoot(){
        $check= A('Ask')->checkUser();
        if (!$check) {
            $this->redirect('Home/Login/reg');
        }

        $this->display('second');

    }





    /*退出登录*/
    public function logoutUser(){
        session(null); 
        $this->redirect('Home/Index/index');

    }





}