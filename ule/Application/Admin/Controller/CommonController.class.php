<?php

	namespace Admin\Controller;
	use Think\Controller;
	use Think\Auth;


	//许多公共的方法可以写在这里
	class CommonController extends Controller{


		//自动运行方法，每次运行这个控制器里的方法的时候都先执行这个方法
		//相当于class里的初始化__c开头的这个
		  protected function _initialize(){

		  		

		      	if (!isset($_SESSION['user'])||!isset($_SESSION['userid'])){	
		      		$this->redirect('Login/index');
		      	}


		      	//从数据库ule_site读取后台配置名称,写入缓存
		      	$sys_all=S('sys_all');
		      	if (empty($sys_all)) {
		      		$m=M('site');
		      		$db=$m->where('id=1')->find();
                    $sys_all  = $db;
		      		S('sys_all',$db);
		      	}
		      	define('ADMIN_NAME', $sys_all['site_admin_name']);/*后台名称*/
		      	define('ADMIN_VERSION', $sys_all['site_admin_version']);/*版本号*/
		      	define('ADMIN_INFO', '');/*foot信息*/
		      	define('ADMIN_DESCRIPTION', $sys_all['site_description']);/*description信息*/
		      	define('ADMIN_KEYWORD', $sys_all['site_keywords']);/*关键词*/

		  }

		  

		  //退出登录
		  public function logout(){

		  	session(null);
	        session('[destroy]');
	        cookie(null); // 清空当前设定前缀的所有cookie值
	        $this->redirect('Login/index');

		  }



		/*清除使用S函数缓存的数据*/
	    public function clearDate(){

	    	if (IS_AJAX) {
	    		$res = \Think\Cache::getInstance()->clear();
	    		if ($res) {
	    			$back['state']=1;
	    			$back['message']='缓存清除成功';
	    			$this->ajaxReturn($back);
	    		}

	    	}else{
	    		$this->error('非法访问!');
	    	}

	       
	    }




		  //缩略图上传
		  public function upload($path='thumb',$width=100,$height=50){
		  
		  	if (IS_AJAX) {
		  	
		  	
		  		$upload = new \Think\Upload();// 实例化上传类    
		  		$upload->maxSize   =     524288 ;//最大不能超过512kb
		  		// 设置附件上传大小    
		  		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
		  		// 设置附件上传类型    
		  		$upload->rootPath  =    './Uploads'; 
		  		// 设置附件上传根目录

		  		if (!is_dir($upload->rootPath)||!is_writeable($upload->rootPath)){		
		  		//判断这个主目录不存在，或者这个目录不可写，我们就创建它
				
					if (!mkdir($upload->rootPath,0777,1)){
						//$this->error('上传目录upload创建失败');
						$date['state']=0;
			  			$date['content']='上传目录upload创建失败';
				  		$this->ajaxReturn($date);

					};
					
				};


				/*存储路径地址编辑*/
				$rooturl=__ROOT__.'/Uploads';


		  		$upload->savePath  =     '/'.$path.'/';
		  		// 设置附件上传（子）目录


		  		// 上传文件  
		  		$info   =   $upload->upload();   


		  		if(!$info) {
			  		// 上传错误提示错误信息        
			  		//$this->error($upload->getError()); 
			  		//echo $upload->getError();
		  			$date['state']=0;
		  			$date['content']=$upload->getError();
			  		$this->ajaxReturn($date);

		  		}else{

		  			// 上传成功 
		  			//注意这里要判断是否上传了多个图片
		  			/*这里是大图*/
		  			$path=array();
		  			foreach($info as $file){        
		  				$path[]= $rooturl.$file['savepath'].$file['savename'];//文件存储路径
		  			}

		  			
		  			//$path：存储着当前上传的大图的地址
		  			

		  			/*如果需要生成小缩略图可以放开底下的*/
		  			//创建一个数组来存储被裁切过的图片的地址
		  			$min=array();/*小图*/
		  			
		  			$day=date('Y-m-d',time());
		  			$save=$upload->rootPath."/min/".$day."/";//存储路径



		 			//使用遍历调用生成缩略图的方法，来执行裁切和生成一定规格的缩略图
		  			foreach ($path as $key => $value) {
		  				
		  				$width=$width;//缩略图宽度
		  				$height=$width;//缩略图高度
		  				$min[]=$this->thumb($value,$width,$height,$save);
		  			}

		  			

		  			$date['state']=1;
		  			$date['content']='上传成功！';
		  			$date['url']=$path;/*大图*/
		  			$date['min']=$save;/*xiao图*/
			  		$this->ajaxReturn($date);

		  		}
			}
		  		$this->display('Public/upload');

		  	}




		  	//生成缩略图
		  	public function thumb($file,$width=200,$height=200,$save){

		  		$image = new \Think\Image();

		  		if (!is_dir($save)||!is_writeable($save)){		
		  		//判断这个主目录不存在，或者这个目录不可写，我们就创建它
				
					if (!mkdir($save,0777,1)){
						//$this->error('上传目录upload创建失败');
						$date['state']=0;
			  			$date['content']='上传目录upload创建失败';
				  		$this->ajaxReturn($date);;

					};
					
				};

				//$file='ule/Uploads/thumb/2017-03-30/58dcc8c368560.jpg';

				$image->open($file);

		  		// $width = $image->width(); // 返回图片的宽度
		  		// $height = $image->height(); // 返回图片的高度
		  		$type = $image->type(); // 返回图片的类型
		  		// $mime = $image->mime(); // 返回图片的mime类型
		  		// $size = $image->size(); // 返回图片的尺寸数组 0 图片宽度 1 图片高度
		  		$num=rand(0,time());//给一个随机数
		  		//$image->thumb(150, 150,\Think\Image::IMAGE_THUMB_FIXED)->save('./thumb.jpg');
		  		$image->thumb($width, $height,\Think\Image::IMAGE_THUMB_FIXED)->save($save.time().$num.'.'.$image->type());
		  		return $minImgUrl=$save.time().$num.'.'.$image->type();

		  	}






		}
