<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 16:13
 */
class SetmoneyController extends PlatformController{
//    显示列表
    public function setmoney(){
        $setmoneyModel= new setmoneyModel();
        $rows=$setmoneyModel->getAll();
        $this->assign("rows",$rows);
        $this->display("setmoney");
    }
    //    添加充值规则
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($data);exit;
        $setmoneyModel= new setmoneyModel();
            $res=$setmoneyModel->insert($data);

            if($res===FALSE){
                $this->alert( "添加规则失败，".$setmoneyModel->getError(), "index.php?p=Admin&c=Setmoney&a=add" );
            }
            $this->alert( "添加规则成功", "index.php?p=Admin&c=Setmoney&a=setmoney" );
        }
        else{
            $this->display("add");
        }
    }
//    修改规则
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($data);exit;
            $setmoneyModel= new setmoneyModel();
            $row=$setmoneyModel->update($data);
            if($row===FALSE){
                $this->alert( "修改规则失败，".$setmoneyModel->getError(), "index.php?p=Admin&c=Setmoney&a=add&id={$_POST['id']}" );
            }
            $this->alert( "修改规则成功", "index.php?p=Admin&c=Setmoney&a=setmoney" );
        }else{
            //回显
            $id=$_GET['id'];
//            var_dump($id);exit;
            $setmoneyModel= new setmoneyModel();
            $row=$setmoneyModel->edit($id);
            $this->assign($row);
            $this->display("edit");
        }
    }
    public function delete(){
        $id=$_GET['id'];
//        var_dump($id);exit;
        $setmoneyModel= new setmoneyModel();
        $setmoneyModel->delete($id);
        $this->alert( "删除规则成功", "index.php?p=Admin&c=Setmoney&a=setmoney" );
    }
}