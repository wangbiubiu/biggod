<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/15
 * Time: 18:57
 */
class IndexController extends PlatformController{
    public function index(){
//        显示预约请求;
        $orderModel=new OrderModel();
        $coun=$orderModel->count();
        $coun1=$orderModel->count1();
//        var_dump($coun);exit;
//        exit;
        $this->assign($coun1);

        $this->assign($coun);
        $this->display("index");
    }
}