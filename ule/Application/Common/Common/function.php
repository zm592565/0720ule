<?php
	
	/*
		公共方法页面
		注意,这里的方法不可以和模块里的方法名目相同不然会报错
	*/
	
	
	//分类递归
	function recursive($arr,$pid=0,$level=0){
		
		$date=array();
		foreach ($arr as $value) {
			
			//我们把查询出来的那个数组用来遍历，然后如果uid=0，就把遍历的值装入我们新建的数组$date
			if ($value['pid']==$pid) {

				$value['level']=$level;
				$value['html']=str_repeat('--', $level);
				$value['nsbp']=str_repeat('&nbsp&nbsp',$level);
				
				//判断是否有子类
				$where['pid']=$value['id'];
				$rs=M('class')->where($where)->find();
				if($rs){
					$value['is_child']=true;
				}
				
				$date[]=$value;
				//把遍历的值装入我们新建的数组$date

				$date=array_merge($date,recursive($arr,$value['id'],$level+1));
				//合并数组 pid=0 切没有找到pid=id的

			}

		}

		return $date;
	}



	/*	函数名称：组装密码
		$str 原生密码
		$code 会员自动生成识别码
	*/
	function PassMakes($str,$code){
		$str.=$code;
		return $str=md5(md5($str));
	}



	/*
		函数名称：随机生成用户code
		$length 生成随机码位数
	*/
	function generate_password( $length = 8 ) {
	    // 密码字符集，可任意添加你需要的字符
	    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
	    $code = '';
	    for ( $i = 0; $i < $length; $i++ ) 
	    {
	        // 这里提供两种字符获取方式
	        // 第一种是使用 substr 截取$chars中的任意一位字符；
	        // 第二种是取字符数组 $chars 的任意元素
	        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	        $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	    }

	    return $code;
	}



	/*

	函数名称:截取字符串
	*/
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
	    if(function_exists("mb_substr")){
	        $slice= mb_substr($str, $start, $length, $charset);
	    }elseif(function_exists('iconv_substr')) {
	        $slice= iconv_substr($str,$start,$length,$charset);
	    }else{
	        $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
	        $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
	        $re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
	        $re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
	        preg_match_all($re[$charset], $str, $match);
	        $slice = join("",array_slice($match[0], $start, $length));
	    }    
        $fix='';
        if(strlen($slice) < strlen($str)){
            $fix='...';
        }
        return $suffix ? $slice.$fix : $slice;
}



	/*	
		计算发布的时间，按照秒、小时、天 或者按照正规时间格式显示
		小于60秒按照秒，小于60分钟按照分钟...
		$begin:发布的时间
		$now：现在的时间

	*/

	function timestr($begin,$now)
	{	

		$str='';

		$short=$now-$begin;

		switch ($short) {
			case $short<0:
				$str='时间参数错误！';
				break;
			case 0<$short && $short<60:
				$str= $short."秒前";
				break;
			case 60 < $short && $short < 3600:
				$str=ceil($short / 60)."分钟前";
				break;
			case 3600 < $short && $short < 24*3600:
				$str=ceil($short / 3600)."小时前";
				break;
			case 24*3600 < $short && $short < 7*24*3600:
				$str=ceil($short / (24*3600))."天前";
				break;
			default:
				$str=date('Y-m-d H:i:s', $begin);
				break;
		}


		return $str;

	}
