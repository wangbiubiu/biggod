<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/25
 * Time: 17:52
 */
class OrderModel extends Model{
//    预约信息查询
    public function getAll(){
//        $sql="select * from `order`,`group`,members where `order`.barber=members.member_id and members.group_id=`group`.group_id";
     $sql="select * from `order`";
     $rows=$this->db->fetchAll($sql);
     return $rows;
    }
    public function getAll1(){
        //        $sql="select * from `order`,`group`,members where `order`.barber=members.member_id and members.group_id=`group`.group_id";
        $sql="select * from `order` WHERE user_id='{$_SESSION['user_info1']['user_id']}'";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
//    员工查询
    public function all(){
        $sql="select * from members WHERE is_admin<>1";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
//    查询套餐
    public function all2(){
        $sql="select * from plans";
        $rows=$this->db->fetchAll($sql);
        return $rows;

    }

    public function insert($data){
        if(empty($data['real_name'])){
            $this->error = "请填写姓名！";
            return false;
        }
        if(empty($data['phone'])){
            $this->error = "请填电话！";
            return false;
        }
        if(empty($data['barber'])){
            $this->error = "请选择美发师！";
            return false;
        }
        if(empty($data['data'])){
            $this->error = "请选择预约日期！";
            return false;
        }
        if(empty($data['plan'])){
            $this->error = "请选择套餐！";
            return false;
        }
        $sql="insert into `order`(real_name,phone,barber,`data`,content,plan,user_id) VALUES ('{$data['real_name']}','{$data['phone']}','{$data['barber']}','{$data['data']}','{$data['content']}','{$data['plan']}','{$_SESSION['user_info1']['user_id']}')";
//                var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显
    public function edit($id){
        $sql_c="select status from `order` WHERE order_id=$id";
        $res=$this->db->fetchColumn($sql_c);
//                var_dump($res);exit;
        if($res>0){
            $this->error = "该预约已被处理，不能再修改！";
            return false;
        }
        $sql="select * from `order` WHERE order_id=$id";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
    public function update($data){
        if(empty($data['real_name'])){
            $this->error = "请填写姓名！";
            return false;
        }
        if(empty($data['phone'])){
            $this->error = "请填电话！";
            return false;
        }
        if(empty($data['barber'])){
            $this->error = "请选择美发师！";
            return false;
        }
        if(empty($data['data'])){
            $this->error = "请选择预约日期！";
            return false;
        }
        if(empty($data['plan'])){
            $this->error = "请选择套餐！";
            return false;
        }
        $sql="update `order` set real_name='{$data['real_name']}',phone='{$data['phone']}',barber='{$data['barber']}',`data`='{$data['data']}',content='{$data['content']}',plan='{$data['plan']}' WHERE order_id={$data['id']}";
        //                var_dump($sql);exit;
        $this->db->query($sql);
    }
    public function delete($id){
        $sql="delete from `order` WHERE order_id=$id";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
    public function delete1($id){
        $sql_s="select status from `order` WHERE order_id=$id";
        $res=$this->db->fetchColumn($sql_s);
        if($res==0){
            return FALSE;
        }
        $sql="delete from `order` WHERE order_id=$id";
        //        var_dump($sql);exit;
        $this->db->query($sql);
    }

    //        显示预约请求;
    public function count(){
        $sql="select count(*) as `count` from `order` WHERE status=0";
        $count=$this->db->fetchColumn($sql);
        $arr=['count'=>$count];
//        var_dump($count);exit;
        return $arr;
    }
//    处理预约
    public function yes($data){
        $sql="update `order` set status='{$data['status']}',reply='{$data['reply']}' WHERE order_id={$data['id']}";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
    public function count1(){
        $sql="select count(*) as `count` from dd WHERE state=0";
        $count=$this->db->fetchColumn($sql);
        $arr=['count1'=>$count];
        //        var_dump($count);exit;
        return $arr;
    }
}