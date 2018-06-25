<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2018/6/25
 * Time: 9:47
 */

namespace app\nongye\home;


use Hiland\Utils\DataModel\ModelMate;
use think\Controller;

class Api extends Controller
{
    public function getCompanys($productName,$province){
        $mate= new ModelMate('nongye_excellentproduct');
        $condition['productname']= $productName;
        $condition['province']= $province;
        $result= $mate->select($condition);
        $result= array_column($result,"companyname");
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}