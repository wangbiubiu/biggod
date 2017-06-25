<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/22
 * Time: 22:58
 */
//部门的添加修改删除与显示
class GroupController extends PlatformController{
//    部门列表
    public function group(){
        $groupModel=new groupModel();
//        查询所有部门
        $rows=$groupModel->gatAll();
        $this->assign("rows",$rows);
//        var_dump($rows);exit;
        $this->display("group");
    }
//    部门添加
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($data);
//            调用模型完成添加
            $groupModel=new groupModel();
            $row=$groupModel->insert($data);
//            失败返回添加页面
            if($row===FALSE){
                $this->alert( "添加失败，".$groupModel->getError(), "index.php?p=Admin&c=Group&a=add" );
//                $this->redirect("index.php?p=Admin&c=Group&a=add","添加失败".$groupModel->getError(),2);
            }
//            成功跳转到列表页
            $this->alert( "添加成功", "index.php?p=Admin&c=Group&a=group" );
//            $this->redirect("index.php?p=Admin&c=Group&a=group");
        }else{//显示添加页面
            $this->display("add");
        }
    }
//    修改与回显
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
//            接收POST——id
//            var_dump($_POST);
            $data=$_POST;
            $groupModel=new groupModel();
            $row=$groupModel->update($data);
            //            失败返回修改
            if($row===FALSE){
                $this->alert( "添加失败，".$groupModel->getError(), "index.php?p=Admin&c=Group&a=edit&id={$data['id']}" );
            }
            //            成功跳转到列表页
            $this->alert( "修改成功", "index.php?p=Admin&c=Group&a=group" );


        }else{
            $id=$_GET['id'];
//            var_dump($id);exit;
//            调用模型回显
            $groupModel=new groupModel();
            $row=$groupModel->edit($id);
//            var_dump($row);
            $this->assign($row);
            $this->display("edit");
        }
    }
//    删除
    public function delete(){
        $id=$_GET['id'];
//        var_dump($id);
        //            调用模型删除

        $groupModel=new groupModel();
        $res=$groupModel->delete($id);
        if($res===FALSE){
            $this->alert( "删除失败，该分组有员工", "index.php?p=Admin&c=Group&a=group" );
        }else{
        $this->alert( "删除成功!", "index.php?p=Admin&c=Group&a=group" );
        }
    }
}