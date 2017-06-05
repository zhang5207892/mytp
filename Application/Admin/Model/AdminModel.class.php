<?php 
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model{

	
	//自动验证规则
	protected $_validate = array(
		//  登录的时候使用这条规则去验证验证码，4代表登录
		array('code', '_code', '验证码不正确', 1, 'callback',  4),
	);
	// 表单的数据方法
	protected function _code($code)
	{
		// 完成验证的逻辑
		// 返回true代表验证通过
		// 返回false代表验证不通过
		$verify = new \Think\Verify();    
		return $verify->check($code, '');
	}


	/**
	 * 完成登录验证
	 * 成功 true 用户名不存在返回1 密码错误2
	 */
	public function login()
	{
		$username = I('post.username');
		$password = I('post.password');
		$where = " username = '$username'";
		// 获取用户的信息
		$userInfo = $this->where($where)->find();
		if($userInfo){
			// 做密码的判断
			if($userInfo['password'] == md5($password)){
				// 登录成功，将数据保存到session里面
				session('id', $userInfo['id']);
				session('username', $userInfo['username']);
				// 更新用户的登录时间
				// setField 用来设置某个字段的值
				$this->where($where)->setField('logintime', time());
				return true;

			}else{
				return 2;
			}
		}else{
			// 用户名不存在
			return 1;
		}
	}


	public function logout()
	{
		// 清除session
		session(null);
	}




	/**********私有方法供该对象调用************/
	// 一般自己定义的私有方法都是用_(一个下划线开头)
	private function _time(){
		return time();
	}

}


 ?>