<?php
	
	/*
		公共方法页面
	*/




	//分类递归
	function Pagerecursive($arr,$pid=0,$level=0){
		
		$date=array();
		foreach ($arr as $key=>$value) {
			
			//我们把查询出来的那个数组用来遍历，然后如果uid=0，就把遍历的值装入我们新建的数组$date
			if ($value['pid']==$pid) {

				$value['level']=$level;

				if ($value['class_type']==0) {
				
					$value['url']=U('News/pagelist?id='.$value['id']);


				}else{
					$value['url']=U('News/pagedetail?id='.$value['id']);

					$value['icon']="../../Public/admin/img/docx.gif";

				}
				

				if($value['pid']==0){
					$date[]='{ id:'.$value['id'].', pId:'.$value['pid'].', name:"'.$value['class_name'].'",open:true,url:"'.$value['url'].'", target:"testIframe"},';
				}else{
					$date[]='{ id:'.$value['id'].', pId:'.$value['pid'].', name:"'.$value['class_name'].'",url:"'.$value['url'].'",target:"testIframe",icon:"'.$value['icon'].'"},';
				}
				
				//把遍历的值装入我们新建的数组$date

				$date=array_merge($date,Pagerecursive($arr,$value['id'],$level+1));
				//合并数组 pid=0 切没有找到pid=id的
			}

		}

		return $date;
	}




















	//整理编辑网址
	function reupdate($str,$arr,$model,$act){
		

		if (is_array($arr)) {
			
			foreach ($arr as $key => $value) {
				
				if (is_array($value)) {

				 	$date[$key]=reupdate($str,$value,$model,$act);

				 }else{


				 	if ($key==$str) {
						
						if (is_array($act)) {
							
							foreach ($act as $values) {
								$date[$values.'url']=U($model.'/'.$values.'?'.$str.'='.$value);
							}

						}else{

							$date[$act.'url']=U($model.'/'.$act.'?'.$str.'='.$value);

						}



					}

					$date[$key]=$value;

				 }
				

			}

			return($date);
		}else{

			return 'DateType is error!';

		}

	}



	/*	函数名称：组装密码
		$str 原生密码
		$code 会员自动生成识别码
	*/
	function PassMake($str,$code){
		$str.=$code;
		return $str=md5(md5($str));

	}





	//栏目图片上传
	function uploadImg(){
		$upload = new \Think\Upload();// 实例化上传类    
		$upload->maxSize   =     3145728 ;// 设置附件上传大小    
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
		$upload->savePath  =      './Public/Uploads/'; // 设置附件上传目录    // 上传文件     
		$info   =   $upload->upload();    
		if(!$info) {// 上传错误提示错误信息        
			$this->error($upload->getError());    
		}else{// 上传成功        
			$this->success('上传成功！');    
		}
	}