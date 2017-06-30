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
        //        余额查询 积分
        $userModel=new UserModel();
        $money=$userModel->edit($_SESSION['user_info1']['user_id']);
        //        var_dump($money);exit;
        $this->assign($money);
//        分页列表
        $goodsModel=new GoodsModel();
        $data=$goodsModel->getAll();
        $this->assign($data);
//        分页工具
        $page = new Page($data['count'], $data['pageSize'], $data['page'], "?p=home&c=Goods&a=goods&page={page}", 2);
        $page = $page->myde_write();
        $this->assign('page',$page);
        $this->display("goods");
    }
    public function shop(){
        $id=$_GET['id'];
        $shopModel=new ShopModel();
//        调用模型生成订单
        $res=$shopModel->shop($id);
        if($res===FALSE){
            $this->alert( "兑换失败，".$shopModel->getError(), "index.php?p=home&c=goods&a=goods" );
        }
        $this->alert( "兑换成功!请等待管理员发货", "index.php?p=Home&c=goods&a=goods" );
    }
}