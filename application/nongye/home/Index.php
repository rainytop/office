<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/7
 * Time: 14:13
 */

namespace app\nongye\home;

use Hiland\Utils\Office\ExcelHelper;
use think\Controller;

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

    public function operators2()
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\operators-2017.xlsx";
        $content = ExcelHelper::getSheetContent($excelData);
        $contentSorted = array();
        foreach ($content as $row) {
            $contentSorted[$row['类别']][] = $row;
        }

        dump($contentSorted);
    }

    /**
     * 农业生产经营人员数量和结构
     */
    public function operators()
    {
        $physicalRoot = PHYSICAL_ROOT_PATH;
        $excelData = $physicalRoot . "\\public\\static\\agriculturedata\\operators-2017.xlsx";
        $content = ExcelHelper::getSheetContent($excelData);

        $contentSorted = array();
        foreach ($content as $row) {
            $contentSorted[$row['类别']][] = $row;
        }

        //dump($contentSorted);
        $data = "";
        $serieData= "";
        $serieDataSelected="";

        $i = 0;
        foreach ($contentSorted as $k => $v) {
            if ($k) {
                //dump($k);
                $serieName = $k;
                if($serieData){
                    $serieData.= ",'$serieName'";
                }else{
                    $serieData= "'$serieName'";
                }

                if($serieDataSelected){
                    $serieDataSelected.= ",'$serieName' : false";
                }else{
                    $serieDataSelected= "'$serieName' : false";
                }

                $serie = $this->generateSerieDatas($serieName, $v,$i);
                $i++;

                if ($data) {
                    $data .= "," . $serie;
                } else {
                    $data .= $serie;
                }
            }
        }

        $this->assign("data", $data);
        $this->assign("serieData",$serieData);
        $this->assign("serieDataSelected",$serieDataSelected);
        return $this->fetch();
    }

    /**
     * @param $rowIndex
     * @param $serieName
     * @param $dataOfCategory 某一个类别下包括各个项目所有的多行数据
     * @return string
     */
    public function generateSerieDatas($serieName, $dataOfCategory,$rowIndex)
    {
        $dataOfAll= $this->generateSerieData4Area($serieName, $dataOfCategory,$rowIndex,"全国","16.6%");
        $dataOfEast= $this->generateSerieData4Area($serieName, $dataOfCategory,$rowIndex,"东部地区","33.2%");
        $dataOfMiddle= $this->generateSerieData4Area($serieName, $dataOfCategory,$rowIndex,"中部地区","49.8%");
        $dataOfWest= $this->generateSerieData4Area($serieName, $dataOfCategory,$rowIndex,"西部地区","66.4%");
        $dataOfNortEast= $this->generateSerieData4Area($serieName, $dataOfCategory,$rowIndex,"东北地区","83%");
        return "$dataOfAll,$dataOfEast,$dataOfMiddle,$dataOfWest,$dataOfNortEast";
    }

    /**
     * @param $rowIndex
     * @param $serieName
     * @param $dataOfCategory
     * @return string
     */
    public function generateSerieData4Area($serieName, $dataOfCategory,$rowIndex,$areaName,$centerX)
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
            if(empty($singleName)){
                $singleName= $areaName;
            }
            $singleValue = $singleItem["$areaName"];
            $dataString .= "{value:$singleValue, name:'$singleName'}";
        }
        $serie .= "$dataString]
                }";
        return $serie;
    }
}