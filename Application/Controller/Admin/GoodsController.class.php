<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 14:27
 */
class GoodsController extends PlatformController{
//    显示商品列表
    public function goods(){
        $goodsModel=new GoodsModel();
        $data=$goodsModel->getAll();
        $this->assign($data);

        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=Admin&c=Goods&a=goods&page={page}", 2);
        $page = $page->myde_write();
        $this->assign('page',$page);
        $this->display("goods");
    }
//    添加会员
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//                        var_dump($_POST);exit;
            $photo=$_FILES['photo'];

            $uploadModel = new UploadModel();
            $logo_path = $uploadModel->uploadOne($photo,"photo/");
            //            上传成功 返回路径；失败返回false
            if($logo_path===FALSE){
                //               使用默认头像
                $logo_path ="photo/20170621/111.png";
                //                $this->alert( "上传图片失败！".$uploadModel->getError(), "index.php?p=Admin&c=Members&a=add" );
                //         $this->redirect("index.php?p=Home&c=Goods&a=add","上传图片失败！".$uploadModel->getError(),3);
            }
            //路径保存到$data中 添加
            //                var_dump($logo_path);exit;
            $data['photo'] = $logo_path;
            //            var_dump($data);exit;
            //            调用模型注册
            $GoodsModel=new GoodsModel();
            $res=$GoodsModel->insert($data);
            //            注册失败给出提示
            if($res===FALSE){
                $this->alert( "添加失败，".$GoodsModel->getError(), "index.php?p=Admin&c=goods&a=add" );
                //                $this->redirect("index.php?p=Home&c=Signup&a=signup","注册失败，".$signupModel->getError(),3);
            }
            //
            $this->alert( "添加成功!", "index.php?p=Admin&c=goods&a=goods" );
        }else{
            $this->display("add");
        }
    }
//    回显与修改
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
//                        var_dump($_POST);exit;
            $data=$_POST;
            //            var_dump($_POST);exit;
            $photo=$_FILES['photo'];
            //            echo "<pre>";
            //                        var_dump($photo);exit;
            //                        var_dump($photo);exit;
            //            exit;
            //
            $uploadModel = new UploadModel();
            $logo_path = $uploadModel->uploadOne($photo,"photo/");
            //            上传成功 返回路径；失败返回false
            if($logo_path===FALSE){
                //               使用默认头像
                $id=$data['id'];
                $GoodsModel=new GoodsModel();
                $row=$GoodsModel->edit($id);
                //                var_dump($row);exit;
                $logo_path ="{$row['goods_logo']}";
                //                $this->alert( "上传图片失败！".$uploadModel->getError(), "index.php?p=Admin&c=Members&a=add" );
                //         $this->redirect("index.php?p=Home&c=Goods&a=add","上传图片失败！".$uploadModel->getError(),3);
            }
            //路径保存到$data中 添加
            //                var_dump($logo_path);exit;
            $data['photo'] = $logo_path;
            //                        var_dump($data);exit;
            //            调用模型注册
            $GoodsModel=new GoodsModel();
            $res=$GoodsModel->update($data);
            //            注册失败给出提示
            if($res===FALSE){
                $this->alert( "修改失败，".$GoodsModel->getError(), "index.php?p=Admin&c=goods&a=edit&id={$data['id']}" );
                //                $this->redirect("index.php?p=Home&c=Signup&a=signup","注册失败，".$signupModel->getError(),3);
            }
            //            注册成功跳转至登录界面
            $this->alert( "修改成功!", "index.php?p=Admin&c=goods&a=goods" );
        }else{
//                        var_dump($_GET);exit;
            //            回显
            $id=$_GET['id'];
            $GoodsModel=new GoodsModel();
            $row=$GoodsModel->edit($id);
            $this->assign($row);
            //            var_dump($row);exit;
            $this->display("edit");
        }
    }
    public function delete(){
        $id=$_GET['id'];
//                var_dump($id);exit;
        $GoodsModel=new GoodsModel();
        $GoodsModel->delete($id);

            $this->alert( "删除成功!", "index.php?p=Admin&c=goods&a=goods" );

    }
}