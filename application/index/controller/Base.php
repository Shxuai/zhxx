<?php
namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
	public $public_role_list = [];

	public function _initialize()
    {
        //echo '<script>alert("先经过我")</script>';
		
		//echo session('?UID');

		
		$noLoginArr = ['Index/login'];//不需要登陆的操作
		
		$con = request()->controller();//获取当前控制器
		$action = request()->action();//获取当前方法
		$nowDo = $con."/".$action; //拼接字符串
		
		//判断是否在不需要登陆的数组里
		if (!session('?user_info') && !in_array($nowDo,$noLoginArr)){
			if($con != 'Index'){
				if(request()->is_ajax){
					return json(['code'=>'1000','msg'=>'登录超时']);
				}
				else{
					echo '<script> top.location.href="'.url('Index/login').'" </script>';
					exit();
				}
			}
			echo '<script>alert("session过期,请重新登入!")</script>';
			$this->redirect('Index/login');//最好写完整这里,你现在在一个控制器下面不会出错,要是在别的控制器下面你的这个就不是默认是Index了
		}
		elseif($nowDo == "Index/login" && session('?user_info')){
			$this->redirect('Index/index');
		}

		$user_info = session('user_info');

		$user_info =  db("public_user_list")->where('uid' , $user_info['uid'])->find();

		session('user_info',$user_info);
		//var_dump($user_info); die();


		$this->assign("user_info",$user_info);
		
	

		

//		$public_role_list = db('public_role_list')->where('id' , $user_info['role_id'])->find()['auth_id'];
//		$this -> public_role_list = explode(',' , $public_role_list);

//		var_dump($public_role_list);die();



		//$public_role_list = db('public_menu_list')->where('menu_url' , $nowDo)->find();

//		if (!empty($public_role_list)) {
//
//
//
//			//var_dump($public_role_list['id']);die();
//
//			//var_dump ( in_array($public_role_list['id'] , $this -> public_role_list) ); die();
//
//			if ( !in_array($public_role_list['id'] , $this -> public_role_list) ){
//
//
//				$this->error('开发大大已经记录了您的IP以及mac地址</br>请不要尝试非法登入');
//
//
//
//
//			}
//
//
//		}





		
    }
}