<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/7
 * Time: 14:26
 */

namespace app\index\controller;


use Hiland\Utils\Data\StringHelper;
use think\Controller;

class Foo extends Controller
{
    public function index(){
        $data= "i like this game!";
        $before= StringHelper::getSeperatorBeforeString($data,"like");
        dump($before);
    }
}