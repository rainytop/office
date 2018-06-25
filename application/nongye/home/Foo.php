<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2018/6/22
 * Time: 8:24
 */

namespace app\nongye\home;


use app\nongye\model\nongye_excellentproduct;
use Hiland\Utils\DataModel\CommonModel;
use Hiland\Utils\DataModel\ModelMate;
use think\Controller;
use think\Db;

class Foo extends Controller
{
    public function index(){

    }

    public function get($id=5){
        //$entityObject= new CommonModel('nongye_excellentproduct');
        //$result= $entityObject->find($id);

        $mate= new ModelMate('nongye_excellentproduct');
        //$result= $mate->find('id='. $id);
        //$result= $mate->select("id<$id");
        //$result= $mate->get($id);
        //$result= $mate->getValue($id,'brandname');

        //$result= $mate->queryValue('brandname', "1=1");
        //$result= $mate->setInc('id=6','pax',2);
        //$result= $mate->setDec('id=6','pax',1);
        //$result= $mate->getCount('id>5');
        //$result= $mate->setValue(6,'pax',20);
        //$result= $mate->delete('id=181');

        $entity['id']=184;
        $entity['province']='山东省';
        $entity['area']='临沂水利局2';
        $entity['brandname']='新大米';
        $result= $mate->interact($entity);


        //$result= $mate->queryObject;

        //$dbQuery= Db::name('cms_menu');
        //$dbQuery= Db::table('dp_cms_menu');
        //$result= $dbQuery->select("id=@id");

        dump($result);
//        $entityObject= new nongye_excellentproduct();
//        $queryObject= $entityObject->getQuery();
//        //dump($queryObject);
//
//        dump($entityObject->find("id=@id"));
//
//        dump(nongye_excellentproduct::get(@id));
//
//        //nongye_excellentproduct::
//        //dump(nongye_excellentproduct::);
//
//
//        $result = $queryObject->find("id=@id");
//        dump($result);
    }
}