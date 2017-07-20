<?php
namespace Home\Controller;
use Think\Controller;

/*全球地址库信息

    1.先使用callchina方法加载中国 省市县信息
    2.使用index加载剩余的地址信息

*/
class MapController extends CommonController {
   
        public function index(){

        header("Content-type: text/html; charset=utf-8"); 
        $file= 'LocList.xml';

        $list=simplexml_load_file($file);


    


        $res=array();


        foreach ($list->CountryRegion as $key=>$value) {
            $arr=array();
            $arr['CountryRegion']['name']=(string)$value['Name'];
            $arr['CountryRegion']['code']=(string)$value['Code'];
            $area=$value->State;

            if ($area) {
                
                /*遍历省份*/
                foreach ($area as $state => $sheng) {

                    $code=(string)$sheng['Code'];
                    $name=(string)$sheng['Name'];
                    if (!empty($code)&&!empty($name)) {
                        $ars=array();
                        $ars['code']=$code;
                        $ars['name']=$name;
                        $ars['pid']=(string)$value['Code'];
                        
                        if ($sheng->City) {
                            /*省份下的城市遍历*/
                            $upcity=array();
                            foreach ($sheng->City as $keycity => $valuecity) {
                                $test['code']=(string)$valuecity['Code'];
                                $test['name']=(string)$valuecity['Name'];
                                $upcity[]=$test;
                                unset($test);

                            }

                            $ars['city']=$upcity;
                            $arr['State'][]=$ars;
                            unset($upcity);
                        }else{
                            $arr['State'][]=$ars;


                        }
                        

                        
                    }else{
                        $arr['State']='no';

                        /*判断是否有城市列表*/
                        if($area->City){

                            foreach ($sheng->City as $keycity => $valuecity) {
                                $test['code']=(string)$valuecity['Code'];
                                $test['name']=(string)$valuecity['Name'];
                                $upcity[]=$test;
                                unset($test);
                            }

                            $arr['city']=$upcity;
                            unset($upcity);

                        };





                    }
                    
                }

            }
            
            




            
            array_push($res, $arr);

        }


        //print_r($res);
        exit();

        foreach ($res as $keyss => $valuess) {
                
            //$valuess['CountryRegion']['name'];//国家名
            //$valuess['CountryRegion']['code'];/*国家代号*/
            //$valuess['State'];//这个国家是有省份设置

            /*写入国家数据*/
            $country['code']=$valuess['CountryRegion']['code'];;
            $country['name']=$valuess['CountryRegion']['name'];;
            $country['pid']=0;
            $country['ename']='N';

            if ($valuess['State']=='no'&&$valuess['city']) {
                $has_childc='has_city';
            }elseif(is_array($valuess['State'])){
                $has_childc='has_state';
            }else{
                $has_childc=0;
            }
            $country['has_child']=$has_childc;/*设置有州*/
            $countryid=M('country')->data($country)->add();

            if ($valuess['State']=='no') {
                
                /*直接遍历城市*/
                foreach ($valuess['city'] as $keyc => $valuec) {
                    
                    $city['code']=$valuec['code'];;
                    $city['name']=$valuec['name'];;
                    $city['pid']=$countryid;
                    $city['ename']='C';
                    $city['has_child']=0;
                    M('country')->data($city)->add();

                }
                

            }elseif(isset($valuess['State'])&&is_array($valuess['State'])){

                /*遍历省*/
                foreach ($valuess['State'] as $keya => $valuea) {
                    $valuea['code'];//省的code
                    $valuea['name'];//省的code

                    /*写入省份信息*/
                    $shenge['code']=$valuea['code'];
                    $shenge['name']=$valuea['name'];
                    $shenge['pid']=$countryid;
                    $shenge['ename']='S';
                    if ($valuea['city']){
                        $shenge['has_child']='has_city';
                    }else{
                        $shenge['has_child']=0;
                    }
                    
                    $shengid=M('country')->data($shenge)->add();


                    /*遍历省下面的市*/
                    if ($valuea['city']) {
                        
                        foreach ($valuea['city'] as $keyd => $valued) {
                            

                            $cityd['code']=$valued['code'];
                            $cityd['name']=$valued['name'];
                            $cityd['pid']=$shengid;
                            $cityd['ename']='C';
                            $cityd['has_child']=0;
                            M('country')->data($cityd)->add();

                        }


                    }


                    



                }





            }



        }






        









    }







    /*解析中国*/
    public function callchina(){

        header("Content-type: text/html; charset=utf-8"); 
        $file= 'china.xml';
        $list=simplexml_load_file($file);
        //exit();
        $arr=array();
        $country['code']='cn';
        $country['name']='中国';
        $country['pid']=0;
        $country['ename']='N';
        $country['has_child']='hasstate';/*设置有州*/
        $countryid=M('country')->data($country)->add();
        foreach ($list->State as $key => $value) {
            $sheng['code']=(string)$value['Code'];
            $sheng['name']=(string)$value['Name'];
            $sheng['ename']='S';
            $sheng['pid']=$countryid;
            $sheng['has_child']='has_city';
            $shengid=M('country')->data($sheng)->add();
            foreach ($value->City as $keys => $values) {
                
                $city['code']=(string)$values['Code'];
                $city['name']=(string)$values['Name'];
                $city['pid']=$shengid;
                $city['ename']='C';
                if ($values->Region) {
                    $city['has_child']='has_xian';
                }else{
                    $city['has_child']=0;
                }
                
                //$sheng['city'][]=$city;
                $cityid=M('country')->data($city)->add();

                if ($values->Region) {
                    foreach ($values->Region as $keyss=> $valuess) {
                        $xian['code']=(string)$valuess['Code'];
                        $xian['name']=(string)$valuess['Name'];
                        $xian['pid']=$cityid;
                        $xian['ename']='X';
                        $xian['has_child']=0;
                        M('country')->data($xian)->add();
                    }
                }

                



            }




            //$arr[]=$sheng;

            //M('country')->data($sheng)->add();

        }


        //print_r($arr);




    }




}