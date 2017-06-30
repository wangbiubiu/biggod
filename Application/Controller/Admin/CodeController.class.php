<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 0:07
 */
class CodeController extends PlatformController{
    public function code(){
//        代金劵列表
        $codeModel=new CodeModel();
        $rows=$codeModel->getAll();
        $this->assign("rows",$rows);
//        会员
        $codeModel=new CodeModel();
        $users=$codeModel->user();
        $this->assign("users",$users);
        $this->display("code");
    }
//    添加
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($data);exit;
            $codeModel=new CodeModel();
            $res=$codeModel->insert($data);
            if($res===FALSE){
                $this->alert( "发放失败，".$codeModel->getError(), "index.php?p=Admin&c=code&a=add" );
            }

            $this->alert( "发放成功", "index.php?p=Admin&c=code&a=code" );
        }else{
            $codeModel=new CodeModel();
            $rows=$codeModel->user();
            $this->assign("users",$rows);
            $this->display("add");
        }
    }
//    已使用的代金券不能修改
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
            $codeModel=new CodeModel();
            $res=$codeModel->update($data);
            if($res===FALSE){
                $this->alert( "修改失败，".$codeModel->getError(), "index.php?p=Admin&c=code&a=edit&id={$data['id']}" );
            }
            $this->alert( "修改成功", "index.php?p=Admin&c=code&a=code" );
        }else{
//            回显
            $codeModel=new CodeModel();
            $rows=$codeModel->user();
            $this->assign("users",$rows);

            $id=$_GET['id'];
//            var_dump($id);exit;
            $codeModel=new CodeModel();
            $row=$codeModel->edit($id);
            if($row===FALSE){
                $this->alert( "修改失败，".$codeModel->getError(), "index.php?p=Admin&c=code&a=code" );
            }
//            var_dump($row);exit;
            $this->assign($row);
            $this->display("edit");
        }
    }
//    删除  未使用的代金券不能被删除
    public function delete(){
        $id=$_GET['id'];
        //            var_dump($id);exit;
        $codeModel=new CodeModel();
        $res=$codeModel->delete($id);
        if($res===FALSE){
            $this->alert( "删除失败，".$codeModel->getError(), "index.php?p=Admin&c=code&a=code" );
        }else{
            $this->alert( "删除成功", "index.php?p=Admin&c=code&a=code" );
        }
    }
}