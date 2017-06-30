<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 20:01
 */
class OrderController extends PlatformController{
    public function order(){
//        查询所有预约
        $orderModel=new OrderModel();
        $rows=$orderModel->getAll();
//        var_dump($rows);exit;

        foreach($rows as &$row)
        if($row['status']==0)
            {$row['status']= "请等待管理员处理";}
        elseif($row['status']==1)
            {$row['status']= "已接受预约";}
        else
            {$row['status']= "预约失败";}
//            var_dump($rows);exit;
        $this->assign("rows",$rows);
        $this->display("order");
    }
    public function yes(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
//            var_dump($_POST);exit;
            $data=$_POST;
            $orderModel=new OrderModel();
            $orderModel->yes($data);
            $this->alert( "回复成功", "index.php?p=Admin&c=order&a=order" );
        }else{
        $id=$_GET['id'];
        $id=["id"=>$id];
//        var_dump($id);exit;
            $this->assign($id);
            $this->display("yes");
        }
    }
//    删除预约
    public function delete1(){
        $id=$_GET['id'];
        $orderModel = new OrderModel();
        $res=$orderModel->delete1($id);
        if($res===FALSE){
            $this->alert( "回复后才能删除", "index.php?p=Admin&c=order&a=order" );
        }
        $this->alert( "删除预约记录", "index.php?p=Admin&c=order&a=order" );
    }
}