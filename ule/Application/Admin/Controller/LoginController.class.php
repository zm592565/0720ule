<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {

    //初始化执行方法（必须先执行这个）
	//自动运行方法，每次运行这个控制器里的方法的时候都先执行这个方法
    protected function _initialize(){

      	if (isset($_SESSION['user'])&&isset($_SESSION['userid'])){	
      		$this->redirect('Index/index');
      	}
    }


    //首页视图
    public function index(){
    	
		$this->assign('actionUrl',__CONTROLLER__.'/login');	
		$this->display();
						
    }


    //验证登录
    public function login(){

    	//接收数据
    	if(IS_POST){

    		//用户提交的数据查询
			$m=M('admin');

			$post=I('post.');
			$where['user']=$post['user'];
			$where['pass']=md5($post['pass']);


			//注意如果验证码要进行二次验证 必须设置array('reset'=>false)
			//因为按照大神的说明，验证码在不设置这个的时候 验证一次之后就会被销毁，设置了之后就不会了
			$verify = new \Think\Verify(array('reset'=>false));

		    //$verify ->check(用户输入的验证码)
		    if(!$verify ->check($post['code'])){
   	
		    	$this->error('验证码输入错误！','index');
		    }


			$db=$m->where($where)->find();

			if ($db) {
				
				$date['id']=$db['id'];
				$date['last_time']=date('Y-m-d H:i:s',time());
				$date['last_ip']=$_SERVER["REMOTE_ADDR"];
				$date['login_count']=$db['login_count']+1;
				//记录登录时间、登录次数、登录ip
				$m->save($date);



				/*查询管理员权限*/
				$group=M()->table(DB_PREFIX.'auth_group_access a, '.DB_PREFIX.'auth_group b')
					->where("a.uid=".$db['id']." AND a.group_id=b.id")
					->field('b.title,a.group_id')
					->find();


				//写入session id和user	
				session('user',$db['user']);
				session('userid',$db['id']);
				cookie('last_time',$db['last_time']);
				cookie('last_ip',$db['last_ip']);
				cookie('group',$group['title']);
				cookie('group_id',$group['group_id']);
				cookie('login_count',$db['login_count']);

				$this->redirect('Index/index');


			}else{

				$this->error('用户不存在');

			}


    	}else{

    		$this->error('页面不存在');

    	}
    
	    	

    }






    //验证码生成方法
	function VerifyImg(){
		
		$config=array(
						'imageH'=>45,	//图片高度
						'imageW'=>110, 	//图片宽
						'fontSize'=>15, //字体大小
						'fontttf'=>'4.ttf',	//验证码字体名称
						'length'=>4,	//验证码位数
						'bg'        =>  array(242, 242, 242),  // 背景颜色
						'useCurve'  =>  false,            // 是否画混淆曲线
        				'useNoise'  =>  false,            // 是否添加杂点
        				//'expire'=>5,	//验证码有效期
					 );
		
		
		$verify = new \Think\Verify($config);
		$verify -> entry();
		
	}
    
}