<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 16:23
 */
class SetvipModel extends Model{
//    显示会员规则列表
    public function getAll(){
        $sql="select * from setvip WHERE set_vip_id<>1 ORDER BY vip_grade";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function insert($data){
        $data['money_c']=(float)$data['money_c'];
        if(empty($data['money_c'])){
            $this->error = "请填写金额";
            return false;
        }
        if(is_nan($data['money_c'])){
            $this->error = "请填写正确的金额";
            return false;
        }
        if(empty($data['vip_grade'])){
            $this->error = "请定义vip等级";
            return false;
        }
        if(empty($data['vip_discount'])){
            $this->error = "请定义折扣";
            return false;
        }
        $money_c=round($data['money_c'],2);
//        var_dump($money_s,$money_c);exit;
        $sql="insert into setvip(vip_grade,money_c,vip_discount) VALUES ('{$data['vip_grade']}','$money_c','{$data['vip_discount']}')";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显
    public function edit($id){
        $sql="select * from setvip WHERE set_vip_id=$id";
        $row=$this->db->fetchRow($sql);
//        var_dump($row);exit;
        return $row;
    }
    public function vip($vip){
        $sql="select * from setvip WHERE vip_grade=$vip";
        $row=$this->db->fetchRow($sql);
        //        var_dump($row);exit;
        return $row;
    }
//    修改
    public function update($data){
        $data['money_c']=(float)$data['money_c'];
        if(empty($data['money_c'])){
            $this->error = "请填写金额";
            return false;
        }
        if(is_nan($data['money_c'])){
            $this->error = "请填写正确的金额";
            return false;
        }
        if(empty($data['vip_grade'])){
            $this->error = "请定义vip等级";
            return false;
        }
        if(empty($data['vip_discount'])){
            $this->error = "请定义折扣";
            return false;
        }
        $money_c=round($data['money_c'],2);
        //        var_dump($money_s,$money_c);exit;
        $sql="update setvip set vip_grade='{$data['vip_grade']}',money_c='$money_c',vip_discount='{$data['vip_discount']}' WHERE set_vip_id={$data['id']}";
        //        var_dump($sql);exit;
        $this->db->query($sql);
    }
    public function delete($id){
        $sql="delete from setvip WHERE set_vip_id=$id";
        $this->db->query($sql);
    }
}