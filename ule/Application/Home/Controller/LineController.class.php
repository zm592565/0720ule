<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

/*地接线路*/
class LineController extends CommonController {


	public function index($order='time'){
		$index = A('Index');
		$css=parent::staticfile_load('css',array('header','common','line','footer'));
		$js=parent::staticfile_load('js',array('header'));
		$libfile = array('js'=>array('navfix/navFixed','layui/layui'),'css'=>array('layui/css/layui'));
        $lib=parent::staticfile_load('lib',$libfile);
		echo $index->header($css,$js,$lib);

		switch ($order) {
			case 'time':
				$orderBy='start_time';
				break;
			case 'read':
				$orderBy='view';
				break;
			default:
				$orderBy='start_time';
				break;
		}


		self::orderByline($orderBy);



		$this->display('list');
		echo $index->footer();

	}


	/*列表*/
	public function orderByline($order){

		$Model = new Model();

		$count=M('line')->count('id');

		$Page = new \Think\Page($count,HOME_LISTNUM);

		$rs=$Model->query("SELECT line.*, country.name as countryName
				, province.name as provinceName
				, member.member_face
				, city.name as cityName
				, member.member_name as memberName
				, member.member_email as memberEmail From ule_line line
				left join ule_member member on line.send_user = member.id
				left join ule_country country on line.begin_c = country.id
				left join ule_country province on line.begin_s = province.id
				left join ule_country city on line.begin_city = city.id
				Order by line.".$order." DESC limit ".$Page->firstRow.",".$Page->listRows);


		$this->assign('list',$rs);
		$this->assign('order',$order);
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('count',$count);


	}



	/*线路详情页*/
	public function showLine($id){

		echo $id;

	}







}