<?php
	
	namespace Home\Controller;
	use Think\Controller;

	class CommonController extends Controller{

		protected function _initialize(){

		      	//从数据库ule_site读取后台配置名称,写入缓存
		      	$sys_all=S('sys_all');
		      	if (empty($sys_all)) {
		      		$m=M('site');
		      		$db=$m->where('id=1')->find();
                    $sys_all = $db;
		      		S('sys_all',$db);
		      	}
		      	define('WEB_SITE', $sys_all['site_name']);/*名称*/
		      	define('WEB_KEYWORD', $sys_all['site_keywords']);
		      	define('WEB_DESCRIPTION', $sys_all['site_description']);

		}	


		/*
		*	给页面动态加载css以及JS文件
		*	注意控件样式与JS的引入路径
		*	lib引用实例 $libfile = array('css' =>array('swiper/swiper-3.4.0.min') ,'js'=>array('swiper
		*	/swiper-3.4.0.jquery.min'));
		*/
		public function staticfile_load($filetype='css',$filenameArr=null){

			if (!empty($filenameArr)) {
				$cssHtml='';
				$jsHtml='';
				$libHtml='';
				$error='<!--nodata-->';
				switch ($filetype) {
				case 'css':
					foreach ($filenameArr as $key => $value) {
					$cssHtml.='<link rel="stylesheet" href="'.HOME_CSS_PATH.$value.'.css" />'.PHP_EOL;
					}
					return $cssHtml;
					break;
				case 'js':
					foreach ($filenameArr as $key => $value) {
					$jsHtml.='<script type="text/javascript" src="'.HOME_JS_PATH.$value.'.js" ></script>'.PHP_EOL;
					}
					return $jsHtml;
					break;
				case 'lib':
					foreach ($filenameArr as $key => $value) {
						if ($key=='css') {
							foreach ($value as $css_value) {
								$libHtml.='<link rel="stylesheet" href="'.HOME_LIB_PATH.$css_value.'.css" />'.PHP_EOL;
							}
							
						}elseif ($key=='js') {
							foreach ($value as $js_value) {
								$libHtml.='<script type="text/javascript" src="'.HOME_LIB_PATH.$js_value.'.js" ></script>'.PHP_EOL;
							}

						}
					}
					return $libHtml;
					break;
				default:
					return $error;
				break;
			}


			}

		}



		/*头像上传裁切方法*/
	  	public function facethumb($file,$width=120,$height=120){

	  		$image = new \Think\Image();
	  		$day=date('Y-m-d',time());
	  		$rooturl='./Uploads/face/'.$day.'/';

	  		if (!is_dir($rooturl)||!is_writeable($rooturl)){		
	  		//判断这个主目录不存在，或者这个目录不可写，我们就创建它
			
				if (!mkdir($rooturl,0777,1)){
					//$this->error('上传目录upload创建失败');
					$date['state']=0;
		  			$date['content']='上传目录upload创建失败';
			  		$this->error('上传目录upload创建失败');

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
	  		$imgname=time().$num.$width.'_'.$height.'.'.$image->type();
	  		$pic=$rooturl.$imgname;
	  		$backUrl=__ROOT__.'/Uploads/face/'.$day.'/'.$imgname;
	  		$image->thumb($width, $height,\Think\Image::IMAGE_THUMB_SCALE)->save($pic);
	  		return $backUrl;

	  	}


	  	/*封面图上传裁切方法*/
	  	public function coverthumb($file,$width=285,$height=170,$folder='thumb'){

	  		$image = new \Think\Image();
	  		$day=date('Y-m-d',time());
	  		$rooturl='./Uploads/'.$folder.'/'.$day.'/';

	  		if (!is_dir($rooturl)||!is_writeable($rooturl)){		
	  		//判断这个主目录不存在，或者这个目录不可写，我们就创建它
			
				if (!mkdir($rooturl,0777,1)){
					//$this->error('上传目录upload创建失败');
					$date['state']=0;
		  			$date['content']='上传目录upload创建失败';
			  		$this->error('上传目录upload创建失败');

				};
				
			};

			//$file='ule/Uploads/thumb/2017-03-30/58dcc8c368560.jpg';
			$openfile=$image->open($file);

	  		// $width = $image->width(); // 返回图片的宽度
	  		// $height = $image->height(); // 返回图片的高度
	  		$type = $image->type(); // 返回图片的类型
	  		if ($type=='jpeg') {
	  			$type='jpg';
	  		}
	  		// $mime = $image->mime(); // 返回图片的mime类型
	  		// $size = $image->size(); // 返回图片的尺寸数组 0 图片宽度 1 图片高度
	  		$num=rand(0,time());//给一个随机数
	  		//$image->thumb(150, 150,\Think\Image::IMAGE_THUMB_FIXED)->save('./thumb.jpg');
	  		$imgname=time().$num.$width.'_'.$height.'.'.$type;
	  		$pic=$rooturl.$imgname;
	  		$backUrl=__ROOT__.'/Uploads/'.$folder.'/'.$day.'/'.$imgname;
	  		$image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save($pic);
	  		return $backUrl;

	  	}



		/*空操作*/
		public function _empty(){        
		//把所有城市的操作解析到city方法        
			$this->error('非法操作');    
		}


	}

	



?>