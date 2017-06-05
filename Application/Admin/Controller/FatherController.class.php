<?php 
namespace Admin\Controller;
use Think\Controller;
class FatherController extends Controller {

	public function __construct(){
		parent::__construct();
		if(!session('id')){
			$this->error('请登录后操作',U('Back/login'), 1);
		}

    }
}


 ?>