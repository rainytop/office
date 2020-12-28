<?php

namespace app\stock\home;

use Hiland\Utils\Data\StringHelper;
use Hiland\Utils\DataModel\ModelMate;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $mate4Setting = new ModelMate("stock_setting");
        $settings = $mate4Setting->get(2);
        $setting_date = $settings["settingvalue"];

        $setting_date_fixed= StringHelper::getStringBeforeSeperator($setting_date," ");
        $this->assign("setting_date", $setting_date_fixed);


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

        $allStockCount= count($listsFixed);
        $this->assign("lists", $listsFixed);
        $this->assign("allStockCount", $allStockCount);
        return $this->fetch();
    }
}