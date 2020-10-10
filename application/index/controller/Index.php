<?php
namespace app\index\controller;

use think\Request;
use PHPExcel_IOFactory;
use PHPExcel;

class Index extends Base
{
    public function index()
    {






//		$this->assign('userName',session('user_info')['username']);
//		$this->assign('true_name',session('user_info')['true_name']);

		return $this -> fetch();
	}
	


    public function login()
    {
		
		if(request()->isAjax()){


//		    var_dump(input('post.username'));die();


			$user_info =  db("public_user_list")->where('username' , input('post.username'))->find();


			
			if (empty($user_info )){

				
				$res = ['msg'=>'用户不存在'];
				


			}else if (input('post.password') == $user_info['password']){
				
				$res = ['msg'=>'登入成功'];
				session('user_info', $user_info );
				
			} else {
				$res = ['msg'=>'密码错误'];
			}
			
			return json($res);

		}
		
		
		
		return $this -> fetch();
	}

    public function frame()
    {


        return $this -> fetch();

    }
	

	public function logout(){


		session(null);

		echo '<script> top.location.href="'.url('Index/login').'" </script>';
		exit();



	}


	public function change_passwd(){


        if(request()->isAjax()){

            $req = request()->param();
//            var_dump(session('user_info'));die();
            if (session('user_info')['password'] == $req['old_password']){




                if (db('public_user_list')
                    ->where('uid',session('user_info')['uid'])
                    ->update(['password' => $req['new_password']])){

                    $res = json(['status'=>1,'msg'=>"修改成功！请重新登入。"]);

                } else {

                    $res = json(['status'=>-1,'msg'=>"修改失败！请联系管理员。"]);

                }

            } else {


                $res = json(['status'=>-1,'msg'=>"修改失败！原密码错误。"]);

            }

            return $res;

        }




        return $this -> fetch();

    }


	


}
