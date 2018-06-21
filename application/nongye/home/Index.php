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

    /**
     *
     */
    public function totalproductsA($yearname = '2010')
    {
        $this->assign('title', '近年全国各省份粮食总产量分析（万吨）');
        return $this->modeMap($yearname, '2.provinces-total-products(2010-2012).xlsx');
    }

    public function totalproductsB($yearname = '2010')
    {
        $this->assign('title', '近年全国各省份粮食总产量分析（万吨）');
        return $this->modeBar($yearname, '2.provinces-total-products(2010-2012).xlsx');
    }

    public function firstpercentA($yearname = '2010')
    {
        $this->assign('title', '全国第一产业情况分析');
        return $this->modeMap($yearname, '4.provincesFirstPercent.xlsx');
    }

    public function firstpercentB($yearname = '2010')
    {
        $this->assign('title', '全国第一产业情况分析');
        return $this->modeBar($yearname, '4.provincesFirstPercent.xlsx');
    }


    public function cottonA($yearname = '2010')
    {
        $this->assign('title', '全国各省份棉花总产量对比分析');
        return $this->modeMap($yearname, '3.cotton-products.xlsx');
    }

    public function cottonB($yearname = '2010')
    {
        $this->assign('title', '全国各省份棉花总产量对比分析');
        return $this->modeBar($yearname, '3.cotton-products.xlsx');
    }


    public function milkA($yearname = '2010')
    {
        $this->assign('title', '全国各省份奶类总产量对比分析');
        return $this->modeMap($yearname, '5.milk-products.xlsx');
    }

    public function milkB($yearname = '2010')
    {
        $this->assign('title', '全国各省份奶类总产量对比分析');
        return $this->modeBar($yearname, '5.milk-products.xlsx');
    }

    public function fruitA($yearname = '2010')
    {
        $this->assign('title', '全国各省份水果总产量对比分析');
        return $this->modeMap($yearname, '6.fruit-products.xlsx');
    }

    public function fruitB($yearname = '2010')
    {
        $this->assign('title', '全国各省份水果总产量对比分析');
        return $this->modeBar($yearname, '6.fruit-products.xlsx');
    }

    public function sugarA($yearname = '2010')
    {
        $this->assign('title', '全国各省份糖料总产量对比分析');
        return $this->modeMap($yearname, '7.sugar-products.xlsx');
    }

    public function sugarB($yearname = '2010')
    {
        $this->assign('title', '全国各省份糖料总产量对比分析');
        return $this->modeBar($yearname, '7.sugar-products.xlsx');
    }


    public function persondensityA($yearname = '2010')
    {
        $this->assign('title', '全国各省份人口密度对比分析(人/平方公里)');
        return $this->modeMap($yearname, '8.person-density.xlsx');
    }

    public function persondensityB($yearname = '2010')
    {
        $this->assign('title', '全国各省份人口密度对比分析(人/平方公里)');
        return $this->modeBar($yearname, '8.person-density.xlsx');
    }

    private function modeMap($yearname, $datasourcefilename)
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\" . $datasourcefilename;

        if (Request::instance()->isPost()) {
            WebHelper::download($excelData);
            exit;
        }

        $content = ExcelHelper::getSheetContent($excelData);
        $singleYearData = $this->generateStatesAnnualData($content, $yearname);

        $data = $singleYearData;

        $this->assign("data", $data);
        $this->assign("downFile", $excelData);
        return $this->fetch('modeMap');
    }

    private function modeBar($yearname, $datasourcefilename)
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\" . $datasourcefilename;

        if (Request::instance()->isPost()) {
            WebHelper::download($excelData);
            exit;
        }

        $content = ExcelHelper::getSheetContent($excelData);
        $content = ArrayHelper::multiColumnSort($content, $yearname . '年', SORT_DESC);

        $provincesNames = $this->generateStatesAnnualNames($content, $yearname);
        $provincesValues = $this->generateStatesAnnualValues($content, $yearname);

        $this->assign("provincesNames", $provincesNames);
        $this->assign("data", $provincesValues);
        $this->assign("downFile", $excelData);
        return $this->fetch('modeBar');
    }

    private function generateStatesAnnualValues($statesData, $yearName = '2010')
    {
        $yearName .= "年";
        $result = "";
        foreach ($statesData as $provinceData) {
            if (empty($result)) {
                $result = $provinceData[$yearName];
            } else {
                $result .= "," . $provinceData[$yearName];
            }
        }

        return $result;
    }

    private function generateStatesAnnualNames($statesData)
    {
        $result = "";
        foreach ($statesData as $provinceData) {
            if (empty($result)) {
                $result = "'" . $provinceData['地区'] . "'";
            } else {
                $result .= ",'" . $provinceData['地区'] . "'";
            }
        }

        return $result;
    }

    private function generateStatesAnnualData($statesData, $yearName = '2010')
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

    private function generateStatesAnnualSortedData($statesData, $yearName = '2010')
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