<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 19:58
 */
class SetvipController extends PlatformController{
//    列表
public function setvip(){
    $setvipModel=new SetvipModel;
    $rows=$setvipModel->getAll();
    $this->assign("rows",$rows);
    $this->display("setvip");
}
//添加功能规则
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
            //            var_dump($data);exit;
            $setvipModel= new setvipModel();
            $res=$setvipModel->insert($data);

            if($res===FALSE){
                $this->alert( "添加规则失败，".$setvipModel->getError(), "index.php?p=Admin&c=Setvip&a=add" );
            }
            $this->alert( "添加规则成功", "index.php?p=Admin&c=Setvip&a=Setvip" );
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
            $setvipModel= new SetvipModel();
            $row=$setvipModel->update($data);
            if($row===FALSE){
                $this->alert( "修改规则失败，".$setvipModel->getError(), "index.php?p=Admin&c=Setvip&a=add&id={$_POST['id']}" );
            }
            $this->alert( "修改规则成功", "index.php?p=Admin&c=Setvip&a=Setvip" );
        }else{
            //回显
            $id=$_GET['id'];
            //            var_dump($id);exit;
            $setvipModel= new SetvipModel();
            $row=$setvipModel->edit($id);
            $this->assign($row);
            $this->display("edit");
        }
    }
    public function delete(){
        $id=$_GET['id'];
        //        var_dump($id);exit;
        $setvipModel= new SetvipModel();
        $setvipModel->delete($id);
        $this->alert( "删除规则成功", "index.php?p=Admin&c=Setvip&a=Setvip" );
    }

}