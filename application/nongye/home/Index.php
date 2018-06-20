<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/7
 * Time: 14:13
 */

namespace app\nongye\home;

use Hiland\Utils\Data\ArrayHelper;
use Hiland\Utils\Office\ExcelHelper;
use Hiland\Utils\Web\WebHelper;
use think\Controller;
use think\Request;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function foo()
    {
        dump(2222222222);
    }

    /**
     *
     */
    public function totalproductsA($yearname = '2010')
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\2.provinces-total-products(2010-2012).xlsx";

        if (Request::instance()->isPost()) {
            WebHelper::download($excelData);
            exit;
        }

        $content = ExcelHelper::getSheetContent($excelData);
        $singleYearData = $this->generateStatesAnnualProductsData($content, $yearname);

        $data = $singleYearData;

        $this->assign("data", $data);
        $this->assign("downFile", $excelData);
        return $this->fetch();
    }

    public function totalproductsB($yearname = '2010')
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\2.provinces-total-products(2010-2012).xlsx";

        if (Request::instance()->isPost()) {
            WebHelper::download($excelData);
            exit;
        }

        $content = ExcelHelper::getSheetContent($excelData);
//        $dd=array_column($content,$yearname.'年');
//        dump($dd);
        //array_multisort(array_column($content,$yearname.'年'),SORT_DESC,$content);

        $content= ArrayHelper::multiColumnSort($content,$yearname.'年',SORT_DESC);
        dump($content);

        $singleYearData = $this->generateStatesAnnualProductsData($content, $yearname);

        $data = $singleYearData;

        $this->assign("data", $data);
        $this->assign("downFile", $excelData);
        return $this->fetch();
    }

    private function generateStatesAnnualProductsData($statesData, $yearName = '2010')
    {
        $yearName .= "年";
        $result = "";
        foreach ($statesData as $provinceData) {
            if (empty($result)) {
                $result = "{name: '" . $provinceData['地区'] . "', value: " . $provinceData[$yearName] . "}";
            } else {
                $result .= ",\r\n{name: '" . $provinceData['地区'] . "', value: " . $provinceData[$yearName] . "}";
            }
        }

        return $result;
    }

    private function generateStatesAnnualProductsSortedData($statesData, $yearName = '2010')
    {
        $yearName .= "年";
        $result = "";
        foreach ($statesData as $provinceData) {
            if (empty($result)) {
                $result = "{name: '" . $provinceData['地区'] . "', value: " . $provinceData[$yearName] . "}";
            } else {
                $result .= ",\r\n{name: '" . $provinceData['地区'] . "', value: " . $provinceData[$yearName] . "}";
            }
        }



        return $result;
    }

    /**
     * 农业生产经营人员数量和结构
     */
    public function operators()
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\1.operators-2017.xlsx";
        $downFile = $excelData;
        if (Request::instance()->isPost()) {
            WebHelper::download($downFile);
            exit;
        }


        $content = ExcelHelper::getSheetContent($excelData);

        $contentSorted = array();
        foreach ($content as $row) {
            $contentSorted[$row['类别']][] = $row;
        }

        //dump($contentSorted);
        $data = "";
        $serieData = "";
        $serieDataSelected = "";

        $i = 0;
        foreach ($contentSorted as $k => $v) {
            if ($k) {
                //dump($k);
                $serieName = $k;
                if ($serieData) {
                    $serieData .= ",'$serieName'";
                } else {
                    $serieData = "'$serieName'";
                }

                if ($serieDataSelected) {
                    $serieDataSelected .= ",'$serieName' : false";
                } else {
                    $serieDataSelected = "'$serieName' : false";
                }

                $serie = $this->generateOperatorSerieDatas($serieName, $v, $i);
                $i++;

                if ($data) {
                    $data .= "," . $serie;
                } else {
                    $data .= $serie;
                }
            }
        }

        $this->assign("data", $data);
        $this->assign("serieData", $serieData);
        $this->assign("serieDataSelected", $serieDataSelected);


        $this->assign("downFile", $downFile);
        return $this->fetch();
    }

    public function downFile($fileName)
    {
        if (empty($fileName)) {
            $physicalRoot = PHYSICAL_ROOT_PATH;
            $fileName = $physicalRoot . "\\public\\static\\agriculturedata\\1.operators-2017.xlsx";
        }
        WebHelper::download($fileName);
        exit;
    }

    /**
     * @param $rowIndex
     * @param $serieName
     * @param $dataOfCategory 某一个类别下包括各个项目所有的多行数据
     * @return string
     */
    public function generateOperatorSerieDatas($serieName, $dataOfCategory, $rowIndex)
    {
        $dataOfAll = $this->generateOperatorSerieData4Area($serieName, $dataOfCategory, $rowIndex, "全国", "16.6%");
        $dataOfEast = $this->generateOperatorSerieData4Area($serieName, $dataOfCategory, $rowIndex, "东部地区", "33.2%");
        $dataOfMiddle = $this->generateOperatorSerieData4Area($serieName, $dataOfCategory, $rowIndex, "中部地区", "49.8%");
        $dataOfWest = $this->generateOperatorSerieData4Area($serieName, $dataOfCategory, $rowIndex, "西部地区", "66.4%");
        $dataOfNortEast = $this->generateOperatorSerieData4Area($serieName, $dataOfCategory, $rowIndex, "东北地区", "83%");
        return "$dataOfAll,$dataOfEast,$dataOfMiddle,$dataOfWest,$dataOfNortEast";
    }

    /**
     * @param $rowIndex
     * @param $serieName
     * @param $dataOfCategory
     * @return string
     */
    public function generateOperatorSerieData4Area($serieName, $dataOfCategory, $rowIndex, $areaName, $centerX)
    {
        $radiusB = 0;
        $radiusE = 60;

//                if ($rowIndex > 0) {
//                    $radiusB = 60 * $rowIndex + 15;
//                    $radiusE = 60 * $rowIndex + 60;
//                }
        if ($rowIndex > 0) {
            $radiusB = 80;
            $radiusE = 110;
        }

        $serie = "{
                        name:'$serieName',
                        type:'pie',
                        selectedMode: 'single',
                        radius : [$radiusB, $radiusE],
                        center : ['$centerX', 200],

                        // for funnel
                        x: '20%',
                        width: '40%',
                        funnelAlign: 'right',
                        max: 1548,

                        itemStyle : {
                            normal : {
                                label : {
                                    position : 'inner'
                                                },
                                labelLine : {
                                    show : false
                                                }
                            }
                        },
                        data:[";

        $dataString = "";
        foreach ($dataOfCategory as $singleItem) {
            if ($dataString) {
                $dataString .= ",";
            }

            $singleName = $singleItem['项目'];
            if (empty($singleName)) {
                $singleName = $areaName;
            }
            $singleValue = $singleItem["$areaName"];
            $dataString .= "{value:$singleValue, name:'$singleName'}";
        }
        $serie .= "$dataString]
                }";
        return $serie;
    }
}