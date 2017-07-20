<?php

namespace Home\Controller;
use Think\Controller;
class InfosendController extends CommonController{

	public function index(){

		$hasLogin=A('Ask');
		if (!$hasLogin->checkUser()) {
			$this->redirect('Home/Login/index');
		}


		$index = A('Index');
			$css=parent::staticfile_load('css',array('header','common','info_send','footer'));
			$js=parent::staticfile_load('js',array('header','common','info_send'));
			$libfile = array('js'=>array('navfix/navFixed','layui/layui','datarange/moment.min','datarange/jquery.daterangepicker.min'),'css'=>array('layui/css/layui','datarange/daterangepicker.min'));
	        $lib=parent::staticfile_load('lib',$libfile);
			echo $index->header($css,$js,$lib);

			$country=M('country')->where('pid=0')->select();
			$sheng=M('country')->where('pid=1')->select();
			$city=M('country')->where('pid=2')->select();

			/*只可以选择从今天开始的一个月的日期*/
			$month=date("Y-m-d", strtotime("+1 months", time()));
			$tody=date("Y-m-d", time());
			$this->assign('country',$country);
			$this->assign('sheng',$sheng);
			$this->assign('city',$city);
			$this->assign('latemonth',$month);
			$this->assign('taday',$tody);
			$this->display();

			echo $index->footer();

	}



	public function getCountryBack(){

		if (IS_AJAX) {
			$pid=I('post.id');
			$type=I('post.type');
			$rs=M('country')->where('id='.$pid)->find();
			/*验证数据是否存在*/
			if ($rs) {


				switch ($rs['has_child']) {
					/*这里首先判断是否有省或者州 如果没有是否有市，如果是0则另做处理*/
					/*
					200说明有省也有市
					300,只有省
					*/
					case 'has_state':
						$state=M('country')->where('pid='.$pid)->select();
						$data['status']  = 200;
						$data['child']  = 'state';
						$data['msg'] ='查询成功,注入省份和城市数据';
						$data['content']=$state;
						$data['type']=$type;
						$data['city']=M('country')->where('pid='.$state[0]['id'])->select();
						break;
					case 'has_city':
						
						$city=M('country')->where('pid='.$pid)->select();
						$data['status']  = 300;
						$data['child']  = 'city';
						$data['msg'] ='查询成功,注入城市数据';
						$data['content']=$city;
						$data['type']=$type;
						break;
					
					default:
						$data['status']  = 400;
						$data['msg'] ='没有下层数据了';
						$data['type']=$type;
						break;
				}

			}else{
				$data['status']  = 5;
				$data['msg'] ='非法数据';
			}

			
			$this->ajaxReturn($data);


		}



	}




	/*上传封面图*/
    public function coverImg($width,$height,$floder){

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
                    // $type = strtolower(substr($name,strrpos($name,'.')+1));
                    $type = $exten[count($exten = explode('.', $name)) - 1];
                    $allow_type=array('jpg','jpeg','gif','png','pjpeg');

                    //判断文件类型是否被允许上传
                    if(!in_array($type, $allow_type)){
                      //如果不被允许，则返回
                      $data['code']=500;
                      $data['msg']='文件格式错误！';
                      $this->ajaxReturn($data);
                    }

                    //判断是否是通过HTTP POST上传的
                    if(!is_uploaded_file($tmp_name)){
                        //如果不是通过HTTP POST上传的
                        $data['code']=300;
                        $data['msg']='非法上传！';
                        $this->ajaxReturn($data);
                    }


                    /*设定上传路径*/
                    $day=date('Y-m-d',time());
                    $rooturl='./Uploads/'.$floder.'/'.$day.'/';


                    $num=rand(0,time());//给一个随机数
                    $imgName=time().$num.'.'.$type;
                    $new_file = $rooturl.$imgName;/*定义图片路径以及名称*/

                    $backUrl=__ROOT__.'/Uploads/'.$floder.'/'.$day.'/'.$imgName;


                    /*创建存储目录*/
                    if (!is_dir($rooturl)||!is_writeable($rooturl)){       
                    //判断这个主目录不存在，或者这个目录不可写，我们就创建它
                    
                        if (!mkdir($rooturl,0777,1)){
                            /*目录创建失败*/
                            $data['code']=400;
                            $data['msg']='很遗憾目录创建失败!';
                            $this->ajaxReturn($data);

                        };
                        
                    };

                    //开始移动文件到相应的文件夹
                    if(move_uploaded_file($tmp_name,$new_file)){

                        $face['thumb']=parent::coverthumb($new_file,$width,$height,$floder);

                      
                        	if (file_exists($new_file)) {
                        	$result = @unlink ($new_file); /*删除原始图片*/
                            $data['code']=200;
                            $data['thumb']=$face['thumb'];
                            $data['msg']='上传成功!';
	                        }else{
	                            $data['code']=800;
	                            $data['msg']='很遗憾图片上传失败!';
	                        }
                        
	                         $this->ajaxReturn($data);
                       
                    }else{
                        $data['code']=700;
                        $data['msg']='很遗憾上传失败!';
                    }


                }

                 $this->ajaxReturn($data);
            }
          

            $this->ajaxReturn($data);
        }



    }





	/*发布地接线路*/
	public function addLines(){

		 if (IS_AJAX) {
		 	$send_user=session('userid');
		 	$send_time=time();
		 	$is_show=1;
		 	$title=I('post.title');

		 	if (!checkStrLength($title,10,100)) {
		 		$return['code']=300;
				$return['msg']='标题字符必须在10-100之间！';
				$this->ajaxReturn($return);
		 	}

			$thumb=I('post.lines_thumb');
			$start_end_time=approve_time(I('post.startEnddate'));




			if (!$start_end_time) {
				$return['code']=400;
				$return['msg']='行程开始以及结束日期不得为空';
				$this->ajaxReturn($return);
			}

			$start_time=$start_end_time['start'];
			$end_time=$start_end_time['end'];

			$begin_c=I('post.selcountry');
			$begin_s=I('post.selstate');
			$begin_city=I('post.selcity');
			$price_last=I('post.money');
			$lines_info=I('post.service_textarea');
			$show_detail=I('post.ContentText');
			
			
			$date['send_user']=$send_user;
			$date['send_time']=$send_time;
			$date['thumb']=$thumb;
			$date['is_show']=$is_show;
			$date['title']=$title;
			$date['begin_c']=$begin_c;
			$date['begin_s']=$begin_s;
			$date['begin_city']=$begin_city;
			$date['price_last']=$price_last;
			$date['lines_info']=$lines_info;
			$date['show_detail']=$show_detail;
			$date['start_time']=$start_time;
			$date['end_time']=$end_time;

			$rs=M('line')->add($date);
			if ($rs) {
				$return['code']=200;
				$return['msg']='恭喜您，地接线路添加成功！';
				
			}else{
				$return['code']=400;
				$return['msg']='很遗憾，地接线路添加失败！';
			}
			
		 	$this->ajaxReturn($return);

		 }


	}









}

?>