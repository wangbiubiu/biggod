<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 15:46
 */
class IntegralController extends PlatformController{
    public function integral(){
//        搜索按钮
        $HistoriesModel=new HistoriesModel;
        $users=$HistoriesModel->users();
        $this->assign("users",$users);

        $conditons = [];

        //        是否传入会员
        if(!empty($_POST['user_id'])){
            $conditons[] = "user_id = '{$_POST['user_id']}'";
        }

        $IntegralModel=new IntegralModel;
        //        传入搜索内容
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $cond=implode(" and ",$conditons);
            //            var_dump($cond);exit;
        }else{
            $cond=isset($_GET['cond'])?$_GET['cond']:"";
            //            var_dump($cond);exit;
        }
        $data =$IntegralModel->getAll($cond);
        //分配数据到页面
        $this->assign($data);
        //        var_dump($data);exit;
        //        分页
        $cond=urlencode($cond);

        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=Admin&c=integral&a=integral&page={page}&cond={$cond}", 2);

        $page = $page->myde_write();
        $this->assign('page',$page);



        $this->display("integral");
    }

}