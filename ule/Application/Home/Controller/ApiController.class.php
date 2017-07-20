<?php
	


	/*包裹查询接口*/
	namespace Home\Controller;
	use Think\Controller;
	class ApiController extends CommonController {


		public function index(){
			header("content-Type: text/html; charset=Utf-8"); 
			/*接收查询的单号*/
			$bagno=I('bagNo','');
			if (!empty($bagno)) {
				$bagno=str_replace('，', ',', $bagno);

				$arr = explode(',', $bagno);
                if(count($arr) > 5) {
                    $selectarr = array_slice($arr, 0, 5);
                }else{
                    $selectarr = $arr;
                }
				foreach ($arr as $key => $value) {
					$arr[$key]='"'.$value.'"';
				}
				$b='';
				$b.=join($arr,',');
				//注入当前查询单号到该页面
				$this->assign('bagno',$b);
                $bagno = implode(',',$selectarr);
				$rs=$this->data($bagno);
                //print_r($rs);
                //exit();
				$endrs= array();
				foreach ($rs as $key => $value) {
                    $endrs[$key] = array();
                    if(!empty($value)){
                        $edition = array();
                        foreach ($value as $keys => $values) {
                            if(!empty($values['eventDate'])) {
                                $endrs[$key][$keys]['eventDate'] = date('Y-m-d H:i:s', strtotime($values['eventDate']));
                                $endrs[$key][$keys]['toCustomerDesc'] = $values['toCustomerDesc'];
                                $endrs[$key][$keys]['toCustomerSummaryDesc'] = str_replace(array('【', '】', ',上一站是', '快件在'), array(' ', ' ', '', '由'), $values['toCustomerSummaryDesc']);
                                if ($values['scantype'] == '派件') {
                                    $endrs[$key][$keys]['toCustomerSummaryDesc'] = str_replace('的', '的派件人', $endrs[$key][$keys]['toCustomerSummaryDesc']);
                                }
                                if (strstr($endrs[$key][$keys]['toCustomerSummaryDesc'], ',扫描员是', true)) {
                                    $endrs[$key][$keys]['toCustomerSummaryDesc'] = strstr($endrs[$key][$keys]['toCustomerSummaryDesc'], ',扫描员是', true);
                                }
                                if ($values['scantype'] == '收件') {
                                    $endrs[$key][$keys]['toCustomerSummaryDesc'] .= ' 已收件';
                                }
                                $endrs[$key][$keys]['toCustomerSummaryDesc'] = preg_replace("/(.*)(由 )(.*)( 扫描)/", "$1", $endrs[$key][$keys]['toCustomerSummaryDesc']);
                                //$aa=str_replace('【', '<span style="color:#167ff5;padding:0px 3px;">', $values['toCustomerSummaryDesc']);
                                //$endrs[$key][$keys]['toCustomerSummaryDesc']=str_replace('】','</span>',$aa);
                            }
                        }
                        // 准备要排序的数组
                        foreach ($endrs[$key] as $k => $v) {
                            $edition[$k] = $v['eventDate'];
                        }
                        $data = &$endrs[$key];
                        //print_r($edition);
                        array_multisort($edition, SORT_DESC, $data);
                        //$endrs[$key] = array_reverse($endrs[$key]);
                    }
					
				}


				$this->assign('result',$endrs);
				
				

			}
			/*注入快捷导航*/
			$quick=A('News')->quick_menu(24);
			$this->assign('qucik',$quick);

			$index = A('Index');
			$this->assign('header',$index->header());
			$this->display('search');
			$this->assign('footer',$index->footer());
			

		}

        public function test(){
            header("content-Type: text/html; charset=Utf-8");
            /*接收查询的单号*/
            $bagno=I('bagNo','');
            if (!empty($bagno)) {
                $bagno=str_replace('，', ',', $bagno);

                $arr=explode(',', $bagno);

                foreach ($arr as $key => $value) {
                    $arr[$key]='"'.$value.'"';
                }
                $b='';
                $b.=join($arr,',');
                //注入当前查询单号到该页面
                $this->assign('bagno',$b);
                $rs=$this->data($bagno);
                //print_r($rs);
                //exit();
                $endrs=array();
                foreach ($rs as $key => $value) {
                    $endrs[$key] = array();
                    $edition = array();
                    if(!empty($value)){
                        foreach ($value as $keys => $values) {
                            if(!empty($values['eventDate'])) {
                                $endrs[$key][$keys]['eventDate'] = date('Y-m-d H:i:s', strtotime($values['eventDate']));
                                $endrs[$key][$keys]['toCustomerDesc'] = $values['toCustomerDesc'];
                                $endrs[$key][$keys]['toCustomerSummaryDesc'] = str_replace(array('【', '】', ',上一站是', '快件在'), array(' ', ' ', '', '由'), $values['toCustomerSummaryDesc']);
                                if ($values['scantype'] == '派件') {
                                    $endrs[$key][$keys]['toCustomerSummaryDesc'] = str_replace('的', '的派件人', $endrs[$key][$keys]['toCustomerSummaryDesc']);
                                }
                                if (strstr($endrs[$key][$keys]['toCustomerSummaryDesc'], ',扫描员是', true)) {
                                    $endrs[$key][$keys]['toCustomerSummaryDesc'] = strstr($endrs[$key][$keys]['toCustomerSummaryDesc'], ',扫描员是', true);
                                }
                                if ($values['scantype'] == '收件') {
                                    $endrs[$key][$keys]['toCustomerSummaryDesc'] .= ' 已收件';
                                }
                                $endrs[$key][$keys]['toCustomerSummaryDesc'] = preg_replace("/(.*)(由 )(.*)( 扫描)/", "$1", $endrs[$key][$keys]['toCustomerSummaryDesc']);
                                //$aa=str_replace('【', '<span style="color:#167ff5;padding:0px 3px;">', $values['toCustomerSummaryDesc']);
                                //$endrs[$key][$keys]['toCustomerSummaryDesc']=str_replace('】','</span>',$aa);
                            }
                        }
                        // 准备要排序的数组
                        foreach ($endrs[$key] as $k => $v) {
                            $edition[$k] = $v['eventDate'];
                        }
                        $data = &$endrs[$key];
                        //print_r($edition);
                        array_multisort($edition, SORT_DESC, $data);
                        //$endrs[$key] = array_reverse($endrs[$key]);
                    }

                }


                $this->assign('result',$endrs);



            }
            /*注入快捷导航*/
            $quick=A('News')->quick_menu(24);
            $this->assign('qucik',$quick);

            $index = A('Index');
            $this->assign('header',$index->header());
            $this->display('search');
            $this->assign('footer',$index->footer());


        }

        public function data($billcode){
			/*
			 * 国际物流
			 * */
			$apiurl = 'http://120.25.202.160:9188/StoIntlBizPlmt/getconsignmentevents';//正式地址
			//$apiurl = 'http://120.25.202.160:9188/StoIntlBizPlmt/getconsignmentevents';//测试地址
			$post_data = array();
			$post_data['logistics_interface']  = $this->getQueryJson($billcode);
			$post_data['logistic_provider_id'] = 'SIOW';
			$post_data['data_digest'] = strtoupper(md5($post_data['logistics_interface'].$post_data['logistic_provider_id']));
			$post_data['msg_type'] = "JSON";
			$post_data['interface_name'] = "getconsignmentevents";
			$post_data['version'] = "1.0";
			$fields_string = http_build_query($post_data);
			$curl = curl_init($apiurl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
			$data = curl_exec($curl);
			curl_close($curl);
			$arr = json_decode($data,TRUE);
			//print_r($arr);
			/*
			 * 国内物流
			 * */
			$apiurl = 'http://222.66.109.133/track.aspx?billcode='.$billcode;//正式地址
			//$apiurl = 'http://222.66.109.133/test.aspx?billcode='.$billcode;//测试地址
			$result = file_get_contents($apiurl);
			$result = iconv("GB2312", "UTF-8//IGNORE", $result);
            $result = str_replace(array('摇恳咽占'),array('堃'),$result);
			$arrXml = $this->xmltoarray($result);
            //print_r($arrXml);
            /*
             * 海外物流
             * */
            $apiurl = 'http://216.218.220.202:8080/track.php?billcode='.$billcode;//正式地址
            $result = file_get_contents($apiurl);
            $result_data = json_decode($result,true);
            //print_r($result_data);
            //exit;
			$datamerge = $this->mergeData($arr,$arrXml,$result_data);
			return $datamerge;
			//print_r($datamerge);

		}



		//Xml转数组,包括根键忽略空元素和属性，尚有重大错误
		function xml_to_array($xml)
		{
		    $reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
		    if(preg_match_all($reg, $xml, $matches))
		    {
		        $count = count($matches[0]);
		        $arr = array();
		        for($i = 0; $i < $count; $i++)
		        {
		            $key = $matches[1][$i];
		            $val = $this->xml_to_array( $matches[2][$i] );  // 递归
		            if(array_key_exists($key, $arr))
		            {
		                if(is_array($arr[$key]))
		                {
		                    if(!array_key_exists(0,$arr[$key]))
		                    {
		                        $arr[$key] = array($arr[$key]);
		                    }
		                }else{
		                    $arr[$key] = array($arr[$key]);
		                }
		                $arr[$key][] = $val;
		            }else{
		                $arr[$key] = $val;
		            }
		        }
		        return $arr;
		    }else{
		        return $xml;
		    }
		}


		// Xml 转 数组, 不包括根键
		function xmltoarray($xml)
		{

		    $arr = $this->xml_to_array($xml);
		    $key = array_keys($arr);
		    return $arr[$key[0]];
		}
		/*
		 * 处理提交的数据
		 * $id 运单号
		 * */
		function getQueryJson($id){
		    $array = array();
		    $array['consignment']['consignmentNo'] = $id;
		    $array['consignment']['languageCode'] = 'En';
		    $array['consignment']['refNo'] = $id;
		    return json_encode($array);
		}
		/*
		 * 物流数据合并
		 * */
		function mergeData($arr = array(),$arr1 = array(),$arr2 = array()){
		    $mergearr = array();
            /*
             * 处理海外物流
             * */
            if(!empty($arr2['resultData'])){
                foreach($arr2['resultData'] as $key0 =>$val0){
                    if(array_key_exists($key0, $mergearr)) continue;
                    foreach($val0 as $k=>$log){
                        $mergearr[$key0][$k]['scantype'] = '';
                        $mergearr[$key0][$k]['eventDate'] = $log['time'];
                        $mergearr[$key0][$k]['toCustomerDesc'] = $log['context'].' '.$log['context'];
                        $mergearr[$key0][$k]['toCustomerSummaryDesc'] = $log['context'].' '.$log['place'];
                    }
                }
            }
		    /*
		     * 处理国际物流数组
		     * */
		    if(isset($arr['resultData']['track']) && !empty($arr['resultData']['track'])){
		        foreach($arr['resultData']['track'] as $key =>$value){
		            //print_r($value);
                    if(!array_key_exists($value['consignmentNo'], $mergearr)) $mergearr[$value['consignmentNo']] = array();
		            $mergearr[$value['consignmentNo']] = array_merge($mergearr[$value['consignmentNo']],$value['consignmentEvents']);
		        }
		    }
		    /*
		     * 国内物流数组
		     * */
		    if(isset($arr1['track']['billcode'])){
		        if(!array_key_exists($arr1['track']['billcode'], $mergearr)) $mergearr[$arr1['track']['billcode']] = array();
                $temp_arr = array();
                if(isset($arr1['track']['detail'])) {
                    $temp_arr[0]['scantype'] = $arr1['track']['detail']['scantype'];
                    $temp_arr[0]['eventDate'] = $arr1['track']['detail']['time'];
                    $temp_arr[0]['toCustomerDesc'] = $arr1['track']['detail']['memo'];
                    $temp_arr[0]['toCustomerSummaryDesc'] = $arr1['track']['detail']['memo'];
                }
		        $mergearr[$arr1['track']['billcode']] = array_merge($mergearr[$arr1['track']['billcode']],$temp_arr);
		    }else {
                //print_r($arr1);
		        foreach ($arr1['track'] as $key => $value) {
		        	/*
                    if(!is_array($value)) {
                        $mergearr[$value] = array();
                        continue;
                    }
		        	*/
		            if(!array_key_exists($value['billcode'], $mergearr)) $mergearr[$value['billcode']] = array();
                    if(isset($value['detail'])) {
                        $temp_arr = array();
                        if(isset($value['detail']['time'])){
                            $temp_arr[0]['scantype'] = $value['detail']['scantype'];
                            $temp_arr[0]['eventDate'] = $value['detail']['time'];
                            $temp_arr[0]['toCustomerDesc'] = $value['detail']['memo'];
                            $temp_arr[0]['toCustomerSummaryDesc'] = $value['detail']['memo'];
                        }else {
                            foreach ($value['detail'] as $key1 => $value1) {
                                $temp_arr[$key1]['scantype'] = $value1['scantype'];
                                $temp_arr[$key1]['eventDate'] = $value1['time'];
                                $temp_arr[$key1]['toCustomerDesc'] = $value1['memo'];
                                $temp_arr[$key1]['toCustomerSummaryDesc'] = $value1['memo'];
                            }
                        }
                        $mergearr[$value['billcode']] = array_merge($mergearr[$value['billcode']], $temp_arr);
                    }
		        }
		    }
            //print_r($mergearr);
            //exit;
		    return $mergearr;
		}



}