<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/23
 * Time: 1:10
 */
class ddController extends PlatformController{
//    显示员工列表
    public function dd(){
//        获取表搜索数据
        $userModel=new UserModel();
        $rows=$userModel->All();
//        var_dump($rows);exit;
        $this->assign("users",$rows);


//        获取员工数据分页
        $conditons = [];
        //        是否传用户
        if(!empty($_POST['user_id'])){
            $conditons[] = "user_id = {$_POST['user_id']}";
        }

        $ddModel=new ddModel;
        //        传入搜索内容
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $cond=implode(" and ",$conditons);
//            var_dump($cond);exit;
        }else{
            $cond=isset($_GET['cond'])?$_GET['cond']:"";
            //            var_dump($cond);exit;
        }

        $data =$ddModel->getAll($cond);//获取所有的商品数据
        //分配数据到页面
        $this->assign($data);
        //        var_dump($data);exit;
        //        分页
        $cond=urlencode($cond);

        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=Admin&c=dd&a=dd&page={page}&cond={$cond}", 2);

        $page = $page->myde_write();
        $this->assign('page',$page);

        $this->display("dd");
    }
    public function qr(){
        $dd_id=$_GET['id'];
//        调用模型修改状态
        $ddModel=new ddModel;
        $res=$ddModel->qr($dd_id);
        if($res===FALSE){
            $this->alert( "{$ddModel->getError()}", "index.php?p=Admin&c=dd&a=dd" );
        }
        $this->alert( "确认发货成功", "index.php?p=Admin&c=dd&a=dd" );
    }
}