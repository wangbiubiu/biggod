<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 11:18
 */
class RankingController extends PlatformController{
    public function ranking(){

        $rankingModel=new RankingModel;
        //        充值排行
        $rows_c=$rankingModel->getAll_c();
        $this->assign("rows_c",$rows_c);
        //        消费排行
        $rows_x=$rankingModel->getAll_x();
        $this->assign("rows_x",$rows_x);
        //        服务排行
        $rows_f=$rankingModel->getAll_f();
        $this->assign("rows_f",$rows_f);

        $this->display("ranking");
    }
}