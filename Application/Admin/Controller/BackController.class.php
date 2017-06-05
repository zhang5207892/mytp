<?php 
namespace Admin\Controller;
use Think\Controller;
use \Org\Net\IpLocation;

class BackController extends Controller {
	// 完成后台的登录
	public function login(){
		// 验证
		if(IS_POST){
			// 登录的验证
			$adminModel = D("Admin");
			// 自定义一个 4 代表登录
			// create 方法有两个参数 第一个参数是提交的数据
			//  验证的时间，时间可以自己定义 定义4代表登录
			if($adminModel->create(I('post.'), 4)){
				// 登录的判断
				// 成功 true 用户名不存在返回1 密码错误2
				$loginStatus = $adminModel->login();
				if( $loginStatus === true){
					//登录成功记录相关用户信息
					$this->sav();
					// 登录成功，跳转到后台的首页
					$this->success('处理成功！', U('Index/index'));
					exit();
				}else{
					//1:用户名不存在 2:密码错误
					$this->sav($code=$loginStatus);
					$loginStatus == 1 ? $this->error('用户名不存在！') : $this->error('密码错误！');;
				}
			}else{
				//验证码错误记录 3代表验证码错误
				$this->sav($code=3);
				$this->error('处理失败！'. $adminModel->getError());
			}
		}
    	
		$this->display();
    }
    // 完成退出
    public function logout()
    {
    	$adminModel = D("Admin");
    	$adminModel->logout();
    	$this->success('处理成功！', U('Back/login'));
    	exit();
    }
    //生成验证码
    public function code()
    {	

    	// 实例化配置一定的参数
    	$config = array(    
    		'imageW'  	  =>    160,    // 验证码宽度
    		'imageH'      =>    60,     // 验证码高度
    		'length'	  =>	3,		// 验证码长度
    		'useNoise'	  =>	false,	// 杂点
    		'useCurve'    =>	false,  // 混淆曲线
    	);

    	$Verify = new \Think\Verify($config);
    	$Verify->entry();
    }
	private function  sav($code=4){
		$data['username']= I('post.username');
		//当前时间
		$data['currentTime']=time();
		//当前使用的游览器-该方法放到Common内
		$data['ExplorerVersion']=get_broswer();
		//当前使用的操作系统-该方法放到Common内
		$data['os']=get_os();
		//获取ip地址
		$ip = get_client_ip();
		//引入UTFWry.dat定位地点文件，tp框架原是没有的，需下载
		$Ipdat = new IpLocation('UTFWry.dat');
		$area = $Ipdat->getlocation($ip);
		//定位地点为GBK，需转UT8存数据库
		$data['Location']=mb_convert_encoding($area['country'],'utf-8', 'gbk');
		if($code){
			switch($code){
				case 1:
					$data['error']='用户名不存在';
					break;
				case 2:
					$data['error']='密码错误';
					break;
				case 3:
					$data['error']='验证码错误';
					break;
				case 4:
					$data['error']='登录成功';
					break;
			}
		}
		//存入数据库表
		$User = M("login");
		$User->add($data);
}
}
 ?>
