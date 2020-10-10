<?php
namespace app\index\controller;

use http\Client\Curl\User;
use think\Request;
use PHPExcel_IOFactory;
use PHPExcel;

class Agent extends Base
{
    public function agent_list()
    {

        if(request()->isAjax()){
            //基础分页
//            var_dump(input("param.req",false));die();
            $limit = input("param.limit",false);
            $page = input("param.page",false);

            $work_number = input("param.work_number",false);
            $name = input("param.name",false);
            $class = input("param.class",false);
            $department = input("param.department",false);
            $job_description = input("param.job_description",false);
            $job_level = input("param.job_level",false);
            $job_class = input("param.job_class",false);
            $entry_date = input("param.entry_date",false);
            $quit_date = input("param.quit_date",false);
            $is_stay = input("param.is_stay",false);
            $is_allocation = input("param.is_allocation",false);



            if($limit === false || $page === false) return json(['code'=>-1,'msg'=>'参数错误']);


            

            $db = db("hr_roster");


            if(!empty($work_number)) {

                $db -> where("work_number" ,'like' ,'%'.$work_number.'%');

            }

            if(!empty($name)) {

                $db -> where("name" ,'like' ,'%'.$name.'%');

            }

            if(!empty($class)) {

                $db -> where("class" ,'like' ,'%'.$class.'%');

            }

            if(!empty($department)) {

                $db -> where("department" ,'like' ,'%'.$department.'%');

            }

            if(!empty($job_description)) {

                $db -> where("job_description" ,'like' ,'%'.$job_description.'%');

            }

            if(!empty($job_level)) {

                $db -> where("job_level" ,'like' ,'%'.$job_level.'%');

            }

            if(!empty($job_class)) {

                $db -> where("job_class" ,'like' ,'%'.$job_class.'%');

            }

            if(!empty($job_class)) {

                $db -> where("job_class" ,'like' ,'%'.$job_class.'%');

            }

            if(!empty($is_stay)) {

                $db -> where("is_stay" ,(int)$is_stay);

            }

            if(!empty($is_allocation)) {

                $db -> where("is_allocation" ,(int)$is_allocation);

            }

            if(!empty($entry_date)) {

                $entry_date = explode(" - ",$entry_date);
                $db -> where("entry_date" , '<=' ,$entry_date[0]);
                $db -> where("entry_date" , '>=' ,$entry_date[1]);

            }

            if(!empty($quit_date)) {

                $quit_date = explode(" - ",$quit_date);
                $db -> where("quit_date" , '<=' ,$quit_date[0]);
                $db -> where("quit_date" , '>=' ,$quit_date[1]);

            }


            $db -> where("delete",0);//将已删除的剔除




            $data = $db->paginate($limit); //自带的分页查询



//            var_dump($data);die();




            $data = json_decode(json_encode($data),true);


            for ($i = 0; $i < count($data['data']); $i++){

                unset($data['data'][$i]['delete']);
                unset($data['data'][$i]['time_stamp']);
                unset($data['data'][$i]['user_name']);
                unset($data['data'][$i]['user_stamp']);


                //是否借调 1借调0未借调
                if($data['data'][$i]['is_allocation'] == 0){

                    $data['data'][$i]['is_allocation'] = '未借调';

                } elseif ($data['data'][$i]['is_allocation'] == 1){

                    $data['data'][$i]['is_allocation'] = '已借调';

                }


                //是否已婚 1有0无
                if($data['data'][$i]['is_married'] == 0){

                    $data['data'][$i]['is_married'] = '未婚';

                } elseif ($data['data'][$i]['is_married'] == 1){

                    $data['data'][$i]['is_married'] = '已婚';

                }


                //是否拥有职称 1有0无
                if($data['data'][$i]['is_professional'] == 0){

                    $data['data'][$i]['is_professional'] = '无职称';

                } elseif ($data['data'][$i]['is_professional'] == 1){

                    $data['data'][$i]['is_professional'] = '有职称';

                }

                //就职状态 1在职0离职
                if($data['data'][$i]['is_stay'] == 0){

                    $data['data'][$i]['is_stay'] = '离职';

                } elseif ($data['data'][$i]['is_stay'] == 1){

                    $data['data'][$i]['is_stay'] = '在职';

                }

                //性别 1男0女
                if($data['data'][$i]['sex'] == 0){

                    $data['data'][$i]['sex'] = '女';

                } elseif ($data['data'][$i]['sex'] == 1){

                    $data['data'][$i]['sex'] = '男';

                }



            }


            return json(['code'=>0,'count'=>$data['total'],'data'=>$data['data']]);
        }

		return $this -> fetch();
	}

    public function agent_authentication_date()
    {

        if(request()->isAjax()){
            //基础分页
//            var_dump(input("param.req",false));die();
            $limit = input("param.limit",false);
            $page = input("param.page",false);

//            $work_number = input("param.work_number",false);
//            $name = input("param.name",false);
//            $class = input("param.class",false);
//            $department = input("param.department",false);
//            $job_description = input("param.job_description",false);
//            $job_level = input("param.job_level",false);
//            $job_class = input("param.job_class",false);
//            $entry_date = input("param.entry_date",false);
//            $quit_date = input("param.quit_date",false);
//            $is_stay = input("param.is_stay",false);
//            $is_allocation = input("param.is_allocation",false);



            if($limit === false || $page === false) return json(['code'=>-1,'msg'=>'参数错误']);



            $db = db("hr_authentication_date");


//            if(!empty($work_number)) {
//
//                $db -> where("work_number" ,'like' ,'%'.$work_number.'%');
//
//            }
//



            $db -> where("delete",0);//将已删除的剔除




            $data = $db->paginate($limit); //自带的分页查询



//            var_dump($data);die();




            $data = json_decode(json_encode($data),true);

//
//            for ($i = 0; $i < count($data['data']); $i++){
//
//                unset($data['data'][$i]['delete']);
//                unset($data['data'][$i]['time_stamp']);
//                unset($data['data'][$i]['user_name']);
//                unset($data['data'][$i]['user_stamp']);
//
//
//                //是否借调 1借调0未借调
//                if($data['data'][$i]['is_allocation'] == 0){
//
//                    $data['data'][$i]['is_allocation'] = '未借调';
//
//                } elseif ($data['data'][$i]['is_allocation'] == 1){
//
//                    $data['data'][$i]['is_allocation'] = '已借调';
//
//                }
//
//
//                //是否已婚 1有0无
//                if($data['data'][$i]['is_married'] == 0){
//
//                    $data['data'][$i]['is_married'] = '未婚';
//
//                } elseif ($data['data'][$i]['is_married'] == 1){
//
//                    $data['data'][$i]['is_married'] = '已婚';
//
//                }
//
//
//                //是否拥有职称 1有0无
//                if($data['data'][$i]['is_professional'] == 0){
//
//                    $data['data'][$i]['is_professional'] = '无职称';
//
//                } elseif ($data['data'][$i]['is_professional'] == 1){
//
//                    $data['data'][$i]['is_professional'] = '有职称';
//
//                }
//
//                //就职状态 1在职0离职
//                if($data['data'][$i]['is_stay'] == 0){
//
//                    $data['data'][$i]['is_stay'] = '离职';
//
//                } elseif ($data['data'][$i]['is_stay'] == 1){
//
//                    $data['data'][$i]['is_stay'] = '在职';
//
//                }
//
//                //性别 1男0女
//                if($data['data'][$i]['sex'] == 0){
//
//                    $data['data'][$i]['sex'] = '女';
//
//                } elseif ($data['data'][$i]['sex'] == 1){
//
//                    $data['data'][$i]['sex'] = '男';
//
//                }
//
//
//
//            }
//

            return json(['code'=>0,'count'=>$data['total'],'data'=>$data['data']]);
        }

        return $this -> fetch();
    }


    public function import()
    {


        return $this -> fetch();
    }

    public function agent_list5()
    {


        return $this -> fetch();
    }



    public function agent_list3()
    {


        return $this -> fetch();
    }




    public function agent_list4()
    {


        return $this -> fetch();
    }


    public function agent_list2()
    {


        return $this -> fetch();
    }

}
