<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/23
 * Time: 1:10
 */
class MembersController extends PlatformController{
//    显示员工列表
    public function members(){
//        获取表搜索数据
        $groupModel=new groupModel();
        $rows=$groupModel->gatAll();
//        var_dump($rows);exit;
        $this->assign("groups",$rows);


//        获取员工数据分页
        $conditons = [];
        //        是否传入分组
        if(!empty($_POST['group_id'])){
            $conditons[] = "group_id = {$_POST['group_id']}";
        }
        //        是否传入性别
        if(!empty($_POST['sex'])){
            $conditons[] = "sex = '{$_POST['sex']}'";
        }

        //判断姓名
        if(!empty($_POST['realname'])){
            $conditons[] = "realname like '%{$_POST['realname']}%'";
        }

        //判断电话
        if(!empty($_POST['telephone'])){
            $conditons[] = "telephone like '%{$_POST['telephone']}%'";
        }

        $membersModel=new MembersModel;
        //        传入搜索内容
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $cond=implode(" and ",$conditons);
//            var_dump($cond);exit;
        }else{
            $cond=isset($_GET['cond'])?$_GET['cond']:"";
            //            var_dump($cond);exit;
        }

        $data =$membersModel->getAll($cond);//获取所有的商品数据
        //分配数据到页面
        $this->assign($data);
        //        var_dump($data);exit;
        //        分页
        $cond=urlencode($cond);

        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=Admin&c=Members&a=members&page={page}&cond={$cond}", 2);

        $page = $page->myde_write();
        $this->assign('page',$page);

        $this->display("members");
    }
//    添加员工
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($_POST);exit;
            $photo=$_FILES['photo'];
            //            echo "<pre>";
//            var_dump($photo);exit;
            //                        var_dump($photo);exit;
            //            exit;

//
                $uploadModel = new UploadModel();
            $logo_path = $uploadModel->uploadOne($photo,"photo/");
            //            上传成功 返回路径；失败返回false
            if($logo_path===FALSE){
//               使用默认头像
                $logo_path ="photo/20170621/123.png";
//                $this->alert( "上传图片失败！".$uploadModel->getError(), "index.php?p=Admin&c=Members&a=add" );
//         $this->redirect("index.php?p=Home&c=Goods&a=add","上传图片失败！".$uploadModel->getError(),3);
            }
                //路径保存到$data中 添加
//                var_dump($logo_path);exit;
                $data['photo'] = $logo_path;
            //            var_dump($data);exit;
            //            调用模型注册
            $membersModel=new MembersModel;
            $res=$membersModel->insert($data);
            //            注册失败给出提示
            if($res===FALSE){
                $this->alert( "添加失败，".$membersModel->getError(), "index.php?p=Admin&c=Members&a=add" );
                //                $this->redirect("index.php?p=Home&c=Signup&a=signup","注册失败，".$signupModel->getError(),3);
            }
            //            注册成功跳转至登录界面
            $this->alert( "添加成功!", "index.php?p=Admin&c=Members&a=members" );
        }else{
//            显示组
            $groupModel=new groupModel();
            $rows=$groupModel->gatAll();
            //        var_dump($rows);exit;
            $this->assign("groups",$rows);
            $this->display("add");

        }
    }
//    修改与回显
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
//            var_dump($_POST);exit;

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
                $membersModel=new MembersModel;
                $row=$membersModel->edit($id);
//                var_dump($row);exit;
                $logo_path ="{$row['photo']}";
                //                $this->alert( "上传图片失败！".$uploadModel->getError(), "index.php?p=Admin&c=Members&a=add" );
                //         $this->redirect("index.php?p=Home&c=Goods&a=add","上传图片失败！".$uploadModel->getError(),3);
            }
            //路径保存到$data中 添加
            //                var_dump($logo_path);exit;
            $data['photo'] = $logo_path;
//                        var_dump($data);exit;
            //            调用模型注册
            $membersModel=new MembersModel;
            $res=$membersModel->update($data);
            //            注册失败给出提示
            if($res===FALSE){
                $this->alert( "修改失败，".$membersModel->getError(), "index.php?p=Admin&c=Members&a=edit&id={$data['id']}" );
                //                $this->redirect("index.php?p=Home&c=Signup&a=signup","注册失败，".$signupModel->getError(),3);
            }
            //            注册成功跳转至登录界面
            $this->alert( "修改成功!", "index.php?p=Admin&c=Members&a=members" );

        }else{
//            var_dump($_GET);exit;
//            回显
            $id=$_GET['id'];
            $membersModel=new MembersModel;
            $row=$membersModel->edit($id);
            $this->assign($row);
//            var_dump($row);exit;
//显示组
            $groupModel=new groupModel();
            $rows=$groupModel->gatAll();
            //        var_dump($rows);exit;
            $this->assign("groups",$rows);

            $this->display("edit");
        }
    }
    public function delete(){
        $id=$_GET['id'];
//        var_dump($id);exit;
        $membersModel=new MembersModel;
        $res=$membersModel->delete($id);
        if($res===FALSE){
            $this->alert( "删除失败，该员工有服务记录！", "index.php?p=Admin&c=Members&a=members" );
        }else{
        $this->alert( "删除成功!", "index.php?p=Admin&c=Members&a=members" );
        }
    }
}