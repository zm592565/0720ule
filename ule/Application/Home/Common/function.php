<?php
	
	/*一些公共方法*/


	/*会增加积分,并且写入会员操作日志*/
	function sendAask($userid,$member_score_id)
	{
		$do=M('member_score')->where('id='.$member_score_id)->find();
		if($do){
			$addscore=M('member')->where('id='.$userid)->setInc('member_integral',$do['add_score']);
			/*给member_do写入操作日志*/
			if ($addscore) {
				$dos['userID']=$userid;
				$dos['user_do']=$do['name'];
				$dos['add_int']=$do['add_score'];
				$dos['add_time']=time();
				M('member_do')->add($dos);
			}
		}	

	}


	/*
	替换字符串
	$search:需要替换的字符
	$replace:要替换成的目标字段
	$str:在该字段中查找并替换
	*/
  	function strRep($search,$replace,$str){
  		$str=trim($str);
  		return str_replace($search, $replace, $str);
  	}
  	



  	/*
  	根据正则进行替换
  	$str:查找的载体
  	$replace：替换结果
  	$partten：正则表达式
  	*/
  	function replaceStr($str,$replace,$partten){
		$rs=preg_replace($partten,$replace,$str);
		if ($rs) {
			return $rs;
		}else{
			return false;
		}
  	}


  	/*把使用区间时间控件的日期格式转换成两个标准的时间戳*/
  	function approve_time($time_str){

  		$dataTime=trim($time_str);
		// $parent='/^((\d{4}-(0[1-9]|1[1-2])-(0[1-9]|2[0-9]|3[0-1])))[\s]{1}至[\s]{1}((\d{4}-(0[1-9]|1[1-2])-(0[1-9]|2[0-9]|3[0-1])))$/';
		// $has=preg_match($parent, $dataTime,$ms);

		$arrTime=explode('至',$dataTime);
		if ($arrTime) {
			/*如果有值说明匹配成功*/
				$arr['start']=strtotime(trim($arrTime[0]));
				$arr['end']=strtotime(trim($arrTime[1]));
				return $arr;
		}else{
				return false;
		}

  	}



  	/*
  	判断字符串是否大于设定的长度
  	$min:必须大于的长度
  	$max:必须小于的长度
  	*/
  	function checkStrLength($str,$min,$max,$coding='UTF8'){
  		$num=mb_strlen($str,$coding); 
  		if ($min<$num&&$num<$max) {
  			return true;
  		}else{
  			return false;
  		}
  	}





  	/*查找html中的图片，返回第一个找到的图片信息*/
  	function searchImg($html)
  	{
  		$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i";
		$rs=preg_match($pattern, $html,$matches);

		if ($rs) {
			return $matches[1];
		}else{
			return false;
		}

		
  	}



  	



?>