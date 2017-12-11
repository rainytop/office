<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/7
 * Time: 19:29
 */

namespace app\kuaidi\home;


use think\Controller;

class Diqu extends Controller
{
    public function index()
    {
        $emsAreaLevels = config('emsAreaLevels');
        $emsAreaLevelOne = [];
        $emsAreaLevelTwo = [];
        $emsAreaLevelThree = [];
        $emsAreaLevelFour = [];
        $emsAreaLevelFive = [];

        foreach ($emsAreaLevels as $k => $v) {
            $item['name']= $k;
            $item['level']=$v;
            switch ($v) {
                case 1:
                    $emsAreaLevelOne[] = $item;
                    break;
                case 2:
                    $emsAreaLevelTwo[] = $item;
                    break;
                case 3:
                    $emsAreaLevelThree[] = $item;
                    break;
                case 4:
                    $emsAreaLevelFour[] = $item;
                    break;
                case 5:
                    $emsAreaLevelFive[] = $item;
                    break;
                default:
                    break;
            }
        }

        $this->assign("emsAreaLevelOne",$emsAreaLevelOne);
        $this->assign("emsAreaLevelTwo",$emsAreaLevelTwo);
        $this->assign("emsAreaLevelThree",$emsAreaLevelThree);
        $this->assign("emsAreaLevelFour",$emsAreaLevelFour);
        $this->assign("emsAreaLevelFive",$emsAreaLevelFive);

        return $this->fetch();
    }
}