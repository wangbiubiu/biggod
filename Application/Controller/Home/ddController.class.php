<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/23
 * Time: 1:10
 */
class ddController extends PlatformController{
//    显示员工列表
    public function dd(){
        $ddModel=new ddModel;
        $data=$ddModel->all($_SESSION['user_info1']['user_id']);
        $this->assign($data);
        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=home&c=dd&a=dd&page={page}", 2);
        $page = $page->myde_write();
        $this->assign('page',$page);
        $this->display("dd");
    }
    public function qr(){
        $dd_id=$_GET['id'];
//        调用模型修改状态
        $ddModel=new ddModel;
        $ddModel->qrsh($dd_id);
        $this->alert( "确认收货成功", "index.php?p=home&c=dd&a=dd" );
    }
}