<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/15
 * Time: 18:57
 */
class IndexController extends PlatformController{
    public function index(){
//        充值送
        $setmoneyModel= new setmoneyModel();
        $rows=$setmoneyModel->getAll();
//        var_dump($rows);exit;
        $this->assign("rows",$rows);
        //        VIP
        $setvipModel=new SetvipModel;
        $row=$setvipModel->getAll();
//        var_dump($row);exit;
        $this->assign("vips",$row);

        //        余额查询
        $userModel=new UserModel();
        $money=$userModel->edit($_SESSION['user_info1']['user_id']);
//        var_dump($money);exit;
        $this->assign($money);
        //        积分查询
        $this->display("index");
    }
}