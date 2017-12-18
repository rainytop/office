<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/7
 * Time: 14:13
 */
namespace app\kuaidi\home;

use think\Controller;

class Index extends Controller
{
    /**
     * 入口方法
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }
}