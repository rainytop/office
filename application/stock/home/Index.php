<?php

namespace app\stock\home;

use Hiland\Utils\DataModel\ModelMate;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $mate4Setting = new ModelMate("stock_setting");
        $settings = $mate4Setting->get(2);
        $setting_date = $settings["settingvalue"];
        $this->assign("setting_date", $setting_date);


        $mate4brand = new ModelMate("stock_brand");
        $condition = array();
        $condition["sdate"] = $setting_date;
        $lists = $mate4brand->select($condition);
        $listsFixed = array();
        foreach ($lists as $item) {
            $prefix = "sz";
            $firstLetter = substr($item["scode"], 0, 1);
            if ($firstLetter == "6") {
                $prefix = "sh";
            }

            $item["scodefixed"] = $prefix . $item["scode"];
            $listsFixed[] = $item;
        }

        //dump($listsFixed);
        $this->assign("lists", $listsFixed);
        $this->assign("test", "test");
        return $this->fetch();
    }
}