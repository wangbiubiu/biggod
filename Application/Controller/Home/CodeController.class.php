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
        $rows=$codeModel->getAll_se();
        $this->assign("rows",$rows);
        $this->display("code");
    }
    public function delete(){
        $id=$_GET['id'];
        //            var_dump($id);exit;
        $codeModel=new CodeModel();
        $res=$codeModel->delete($id);
        if($res===FALSE){
            $this->alert( "删除失败，".$codeModel->getError(), "index.php?p=home&c=code&a=code" );
        }else{
            $this->alert( "删除成功", "index.php?p=home&c=code&a=code" );
        }
    }
}