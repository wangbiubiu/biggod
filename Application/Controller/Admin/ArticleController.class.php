<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/25
 * Time: 14:40
 */
class ArticleController extends PlatformController{
    //    活动主页
    public function article(){
        $articleModel = new ArticleModel();
        $rows=$articleModel->getAll();
        $this->assign("articles",$rows);
        $this->display("article");
    }
//    活动列表
    public function index(){
        $articleModel = new ArticleModel();
        $rows=$articleModel->getAll1();
        $this->assign("articles",$rows);
        $this->display("index");
    }

//    添加活动
    public function add(){
        if( $_SERVER['REQUEST_METHOD'] == "POST" ){
//            echo $_POST['content'];
            $data=$_POST;
            $articleModel = new ArticleModel();
            $res=$articleModel->insert($data);
            if($res===FALSE){
                $this->alert( "发布活动失败，".$articleModel->getError(), "index.php?p=Admin&c=Article&a=add" );
            }
            $this->alert( "发布活动成功", "index.php?p=Admin&c=Article&a=article" );
        }else{
            $this->display( "add" );
        }
    }
//    修改活动
    public function edit(){
        if( $_SERVER['REQUEST_METHOD'] == "POST" ){
            $data=$_POST;
//            var_dump($data);exit;
            $articleModel = new ArticleModel();
            $res=$articleModel->update($data);
            if($res===FALSE){
                $this->alert( "修改活动失败，".$articleModel->getError(), "index.php?p=Admin&c=Article&a=edit&id={$data['id']}" );
            }
            $this->alert( "修改活动成功", "index.php?p=Admin&c=Article&a=index" );

        }else{
            $id=$_GET['id'];
            $articleModel = new ArticleModel();
            $row=$articleModel->edit($id);
            $this->assign($row);
            $this->display("edit");
        }
    }
    public function delete(){
        $id=$_GET['id'];
        $articleModel = new ArticleModel();
        $articleModel->delete($id);
        $this->alert( "删除成功", "index.php?p=Admin&c=Article&a=index" );
    }
}