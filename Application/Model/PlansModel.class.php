<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/22
 * Time: 23:31
 */
//部门的增删查改
class PlansModel extends Model{
//    查询套餐
    public function gatAll(){
        $sql="select * from plans ";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function gatAll1(){
        $sql="select * from plans WHERE status<>0";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
//    添加套餐
    public function insert($data){
        if(empty($data['name'])){
            $this->error = "请填写套餐名！";
            return false;
        }
        if(empty($data['des'])){
            $this->error = "请填写套餐描述！";
            return false;
        }
        if(empty($data['money'])){
            $this->error = "请填写套餐金额！";
            return false;
        }
        if(!isset($data['status'])){
            $this->error = "请确认套餐是否上架！";
            return false;
        }
        $sql="insert into `plans`(`name`,des,money,status) VALUES ('{$data['name']}','{$data['des']}','{$data['money']}','{$data['status']}')";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显
    public function edit($id){
//        var_dump($id);exit;
        $sql="select * from plans WHERE plan_id=$id";
        //        返回当前
        $row=$this->db->fetchRow($sql);
        return $row;
    }
//  修改
    public function update($data){
        if(empty($data['name'])){
            $this->error = "请填写套餐名！";
            return false;
        }
        if(empty($data['des'])){
            $this->error = "请填写套餐描述！";
            return false;
        }
        if(empty($data['money'])){
            $this->error = "请填写套餐金额！";
            return false;
        }
        if(empty($data['status'])){
            $this->error = "请确认套餐是否上架！";
            return false;
        }
        $sql="update `plans` set `name`='{$data['name']}',`des`='{$data['des']}',`money`='{$data['money']}',`status`='{$data['status']}'  WHERE plan_id={$data['id']}";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    删除
    public function delete($id){
        $sql="delete from `plans` WHERE plan_id=$id";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
}