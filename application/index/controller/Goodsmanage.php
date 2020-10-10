<?php
namespace app\index\controller;

use think\Request;
use PHPExcel_IOFactory;
use PHPExcel;

class Goodsmanage extends Base
{
    public function goods_type_list()
    {


		return $this -> fetch();
	}


    public function goods_list()
    {


        return $this -> fetch();
    }

    public function goods_add()
    {


        return $this -> fetch();
    }

}
