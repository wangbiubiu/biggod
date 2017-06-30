<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 23:25
 */
class HistoriesController extends PlatformController{
    public function histories(){
        //        获取员工数据分页
        $conditons = [];
        $conditons[] = "user_id = '{$_SESSION['user_info1']['user_id']}'";
        //        是否传入会员
        if(!empty($_POST['user_id'])){
            $conditons[] = "user_id = '{$_SESSION['user_info1']['user_id']}'";
        }
        //        是否传入员工
        if(!empty($_POST['member_id'])){
            $conditons[] = "member_id = '{$_POST['member_id']}'";
        }
        //        是否传入类型
        if(!empty($_POST['type'])){
            $conditons[] = "type = '{$_POST['type']}'";
        }
//        var_dump($conditons);exit;
        $HistoriesModel=new HistoriesModel;
        //        传入搜索内容
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $cond=implode(" and ",$conditons);
            //            var_dump($cond);exit;
        }else{
            $cond=isset($_GET['cond'])?$_GET['cond']:"user_id = '{$_SESSION['user_info1']['user_id']}'";
            //            var_dump($cond);exit;
        }
        $data =$HistoriesModel->getAll1($cond);
        //分配数据到页面
        $this->assign($data);
        //        var_dump($data);exit;
        //        分页
        $cond=urlencode($cond);

        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=Home&c=Histories&a=histories&page={page}&cond={$cond}", 2);

        $page = $page->myde_write();
        $this->assign('page',$page);

//        查询所有员工信息与会员信息
        $HistoriesModel=new HistoriesModel;
        $users=$HistoriesModel->users();
        $this->assign("users",$users);

        $members=$HistoriesModel->members();
        $this->assign("members",$members);

        $this->display("historises");
    }


}