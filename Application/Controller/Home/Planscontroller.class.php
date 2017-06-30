<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 17:07
 */
class Planscontroller extends PlatformController{
    public function plan(){
        $plansModel=new PlansModel();
        $rows=$plansModel->gatAll();
        $this->assign("rows",$rows);
        $this->display("plans");
    }
}