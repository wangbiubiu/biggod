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
}