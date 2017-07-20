<?php
	
	namespace Home\Controller;
	use Think\Controller;

	/*空控制器报错*/
	class EmptyController extends CommonController{

		public function index()
		{
			$this->error();
		}

	}

	



?>