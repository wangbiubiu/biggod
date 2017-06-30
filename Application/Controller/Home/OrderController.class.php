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
        $rows=$orderModel->getAll1();
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
//    添加预约
    public function add(){
        if( $_SERVER['REQUEST_METHOD'] == "POST" ){
            //            echo $_POST['content'];
//            var_dump($_POST);exit;
            $data=$_POST;
            $orderModel = new OrderModel();
            $res=$orderModel->insert($data);
            if($res===FALSE){
                $this->alert( "预约失败，".$orderModel->getError(), "index.php?p=Home&c=order&a=add" );
            }
            $this->alert( "预约成功", "index.php?p=Home&c=order&a=order" );
        }else{
//            获取所有美发师
            $orderModel = new OrderModel();
            $row=$orderModel->all();
            $this->assign("rows",$row);
            //            获取所有套餐
            $plansModel=new PlansModel();
            $rows=$plansModel->gatAll1();
            $this->assign("plans",$rows);

            $this->display( "add" );
        }
    }
//    修改回显  预约
    public function edit(){
        if( $_SERVER['REQUEST_METHOD'] == "POST" ){
            $data=$_POST;
//            var_dump($_POST);exit;
            $orderModel = new OrderModel();
            $res=$orderModel->update($data);
            if($res===FALSE){
                $this->alert( "修改预约失败，".$orderModel->getError(), "index.php?p=Home&c=order&a=edit&id={$data['id']}" );
            }
            $this->alert( "修改预约成功", "index.php?p=Home&c=order&a=order" );
        }else{
//            回显
            $id=$_GET['id'];
//            var_dump($id);
            //            获取所有美发师
            $orderModel = new OrderModel();
            $row=$orderModel->all();
            $this->assign("rows",$row);
            //            获取所有套餐
            $orderModel = new OrderModel();
            $plan=$orderModel->all2();
            $this->assign("plans",$plan);

//            获取回显数据
            $orderModel = new OrderModel();
            $edit=$orderModel->edit($id);
            if($edit===FALSE){
                $this->alert( "修改预约失败，".$orderModel->getError(), "index.php?p=Home&c=order&a=order" );
            }
            $this->assign($edit);
//            var_dump($edit);exit;
            $this->display("edit");
        }
    }
//    删除预约
    public function delete(){
        $id=$_GET['id'];
        $orderModel = new OrderModel();
        $orderModel->delete($id);
        $this->alert( "删除预约记录", "index.php?p=Home&c=order&a=order" );
    }



}