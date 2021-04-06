<?php

namespace app\stock\home;

use Hiland\Utils\Data\StringHelper;
use Hiland\Utils\DataModel\ModelMate;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function ma1()
    {
        $mate4Setting = new ModelMate("stock_setting");
        $settings = $mate4Setting->get(2);
        $setting_date = $settings["settingvalue"];

        $setting_date_fixed = StringHelper::getStringBeforeSeperator($setting_date, " ");
        $this->assign("setting_date", $setting_date_fixed);


        $mate4brand = new ModelMate("stock_brand");
        $condition = array();
        $condition["sdate"] = $setting_date;
        $lists = $mate4brand->select($condition, "scode desc");
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

        $allStockCount = count($listsFixed);
        $this->assign("lists", $listsFixed);
        $this->assign("allStockCount", $allStockCount);
        return $this->fetch();
    }

    public function ma2()
    {
        $mate4Setting = new ModelMate("ss_stock_summary");
        $setting = $mate4Setting->get("commend_last_date_ma", "item_key");
        $setting_date = $setting["item_value"];

        $setting_date_fixed = $setting_date; //StringHelper::getStringBeforeSeperator($setting_date," ");
        $this->assign("setting_date", $setting_date_fixed);


        $mate4brand = new ModelMate("ss_stock_commend");
        $condition = array();
        $condition["trade_date"] = $setting_date;
        $condition["commend_type"] = "ma";

        $lists = $mate4brand->select($condition, "ts_code desc");
        $listsFixed = array();
        foreach ($lists as $item) {
            $ts_code = $item["ts_code"];
            $scodefixed = strtolower(StringHelper::getStringAfterSeperator($ts_code, ".")) . StringHelper::getStringBeforeSeperator($ts_code, ".");

            $item["scodefixed"] = $scodefixed;
            $listsFixed[] = $item;
        }

        $allStockCount = count($listsFixed);
        $this->assign("lists", $listsFixed);
        $this->assign("allStockCount", $allStockCount);
        return $this->fetch();
    }

    public function moo()
    {
        $stock = "688618.SH";
        $postfix= StringHelper::getStringAfterSeperator($stock,".");
        dump($postfix);

    }
}