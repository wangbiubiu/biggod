<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 13:53
 */
class moneyController extends PlatformController{
//    充值
    public function plus(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($data);exit;
            $moneyModel=new MoneyModel();
            $res=$moneyModel->plus($data);
            if($res===FALSE){
                $this->alert( "充值失败，".$moneyModel->getError(), "index.php?p=Admin&c=Money&a=plus&id={$data['id']}" );
            }
            $this->alert( "充值成功", "index.php?p=Admin&c=User&a=user" );

        }else{
            $setmoneyModel= new setmoneyModel();
            $rows=$setmoneyModel->getAll();
            $this->assign("rows",$rows);

            $setvipModel=new SetvipModel;
            $row=$setvipModel->getAll();
            //        var_dump($row);exit;
            $this->assign("vips",$row);

            $id=$_GET['id'];
            $id=["id"=>$id];
//            var_dump($id);exit;
            $this->assign($id);
            $this->display("plus");
        }
    }
//    消费
    public function reduce(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
//            var_dump($data);exit;
            $moneyModel=new MoneyModel();
            $res=$moneyModel->reduce($data);
            if($res===FALSE){
                $this->alert( "扣除金额失败，".$moneyModel->getError(), "index.php?p=Admin&c=Money&a=reduce&id={$data['id']}" );
            }
            $this->alert( "扣除金额成功", "index.php?p=Admin&c=User&a=user" );

        }else{
//            选择员工
            $membersModel=new MembersModel();
            $rows_member=$membersModel->getAll1();
            $this->assign("members",$rows_member);

//            套餐
            $plansModel=new PlansModel();
            $rows=$plansModel->gatAll1();
            $this->assign("plans",$rows);
//代金券
            $id=$_GET['id'];
            $codeModel=new CodeModel();
            $codes=$codeModel->all($id);
//            var_dump($codes);exit;
            $this->assign("codes",$codes);


            $userModel=new UserModel();
            $row=$userModel->edit($id);
            $this->assign($row);

            $setvipModel=new SetvipModel();
            $vip=$setvipModel->vip($row['is_vip']);
            $this->assign($vip);

            $this->display("reduce");
        }
    }
}