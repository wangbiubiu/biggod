<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 17:07
 */
class Planscontroller extends PlatformController{
    public function plans(){
        $plansModel=new PlansModel();
        $rows=$plansModel->gatAll();
        $this->assign("rows",$rows);
        $this->display("plans");
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=$_POST;
            //            var_dump($data);
            //            调用模型完成添加
            $plansModel=new plansModel();
            $row=$plansModel->insert($data);
            //            失败返回添加页面
            if($row===FALSE){
                $this->alert( "添加失败，".$plansModel->getError(), "index.php?p=Admin&c=plans&a=add" );
                //                $this->redirect("index.php?p=Admin&c=Group&a=add","添加失败".$groupModel->getError(),2);
            }
            //            成功跳转到列表页
            $this->alert( "添加成功", "index.php?p=Admin&c=plans&a=plans" );
            //            $this->redirect("index.php?p=Admin&c=Group&a=group");
        }else{//显示添加页面
            $this->display("add");
        }
    }
    //    修改与回显
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            //            接收POST——id
            //            var_dump($_POST);
            $data=$_POST;
            $plansModel=new PlansModel();
            $row=$plansModel->update($data);
            //            失败返回修改
            if($row===FALSE){
                $this->alert( "添加失败，".$plansModel->getError(), "index.php?p=Admin&c=plans&a=edit&id={$data['id']}" );
            }
            //            成功跳转到列表页
            $this->alert( "修改成功", "index.php?p=Admin&c=plans&a=plans" );


        }else{
            $id=$_GET['id'];
//                        var_dump($id);exit;
            //            调用模型回显
            $plansModel=new PlansModel();
            $row=$plansModel->edit($id);
//                        var_dump($row);exit;
            $this->assign($row);
            $this->display("edit");
        }
    }
    //    删除
    public function delete(){
        $id=$_GET['id'];
        //        var_dump($id);
        //            调用模型删除

        $plansModel=new PlansModel();
        $plansModel->delete($id);

            $this->alert( "删除成功!", "index.php?p=Admin&c=plans&a=plans" );

    }


}