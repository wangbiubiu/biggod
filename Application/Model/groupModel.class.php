<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/22
 * Time: 23:31
 */
//部门的增删查改
class groupModel extends Model{
//    查询部门
    public function gatAll(){
        $sql="select * from `group` ";
//        返回所有部门数据
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
//    添加部门
    public function insert($data){
        if(empty($data['group_name'])){
            $this->error = "请填写内容！";
            return false;
        }
        $sql="insert into `group`(`name`) VALUES ('{$data['group_name']}')";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显
    public function edit($id){
        $sql="select * from `group` WHERE group_id=$id";
        //        部门数据
//        var_dump($sql);exit;
        $row=$this->db->fetchRow($sql);
        return $row;
    }
//  修改
    public function update($data){
        if(empty($data['group_name'])){
            $this->error = "请填写内容！";
            return false;
        }
        $sql="update `group` set `name`='{$data['group_name']}'  WHERE group_id={$data['id']}";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    删除
    public function delete($id){
        $sql="delete from `group` WHERE group_id=$id";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
}