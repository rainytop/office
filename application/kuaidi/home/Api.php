<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/9
 * Time: 9:54
 */

namespace app\kuaidi\home;


use Hiland\Utils\Data\EncodingHelper;
use think\Controller;

class Api extends Controller
{
    public function deliverFee($provinceName = '')
    {
        $result = "";
        $provinceName = urldecode($provinceName);

        $emsAreaLevels = config('emsAreaLevels');
        if (array_key_exists($provinceName, $emsAreaLevels)) {
            $emsAreaLevel = $emsAreaLevels[$provinceName];
            return json_encode("第 $emsAreaLevel 类地区", JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode("尚未开通的地区", JSON_UNESCAPED_UNICODE);
        }
    }
}