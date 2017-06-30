<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 16:23
 */
class setmoneyModel extends Model{
//    显示充值规则列表
    public function getAll(){
        $sql="select * from setmoney WHERE money_id<>6 ORDER BY money_c";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function insert($data){
        $data['money_c']=(float)$data['money_c'];
        $data['money_s']=(float)$data['money_s'];
        if(empty($data['money_c'])){
            $this->error = "请填写充值金额";
            return false;
        }
        if(is_nan($data['money_c'])){
            $this->error = "请填写正确的充值金额";
            return false;
        }
        if(empty($data['money_s'])){
            $this->error = "请填写赠送金额";
            return false;
        }
        if(is_nan($data['money_s'])){
            $this->error = "请填写正确的赠送金额";
            return false;
        }
        $money_s=round($data['money_s'],2);
        $money_c=round($data['money_c'],2);
//        var_dump($money_s,$money_c);exit;
        $sql="insert into setmoney(money_s,money_c) VALUES ($money_s,$money_c)";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显
    public function edit($id){
        $sql="select * from setmoney WHERE money_id=$id";
        $row=$this->db->fetchRow($sql);
//        var_dump($row);exit;
        return $row;
    }
//    修改
    public function update($data){
        $data['money_c']=(float)$data['money_c'];
        $data['money_s']=(float)$data['money_s'];
        if(empty($data['money_c'])){
            $this->error = "请填写充值金额";
            return false;
        }
        if(is_nan($data['money_c'])){
            $this->error = "请填写正确的充值金额";
            return false;
        }
        if(empty($data['money_s'])){
            $this->error = "请填写赠送金额";
            return false;
        }
        if(is_nan($data['money_s'])){
            $this->error = "请填写正确的赠送金额";
            return false;
        }
        $money_s=round($data['money_s'],2);
        $money_c=round($data['money_c'],2);
        $sql="update setmoney set money_s=$money_s,money_c=$money_c WHERE money_id={$data['id']}";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
    public function delete($id){
        $sql="delete from setmoney WHERE money_id=$id";
        $this->db->query($sql);
    }
}