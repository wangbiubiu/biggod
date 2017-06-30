<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 0:24
 */
class CodeModel extends Model{
//    获取代金券数据
    public function getAll(){
        $sql="SELECT * FROM codes";
        $rows=$this->db->fetchAll($sql);
        foreach($rows as &$row){
            if($row['status']==0)
            {$row['status']= "未使用";}
            else{$row['status']= "已使用";}
        }
//        var_dump($rows);exit;
        return $rows;
    }
//    获取会员数据
    public function user(){
        $sql="select * from `users`";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
//    发放代金劵
    public function insert($data){

        $data['code_money']=(float)$data['code_money'];
        if(is_nan($data['code_money'])){
            $this->error = "请输入正确的金额";
            return false;
        }
        if(empty($data['code_money'])){
            $this->error = "请输入正确的金额";
            return false;
        }
        $str="ABCDEFGHIJKLMNPQRSTUVWXYABCDEFGHIJKLMNPQRSTUVWXY123456789123456789";
        $re_str=str_shuffle($str);
        $str_code=substr($re_str,0,8);

        $code_money=round($data['code_money'],5);

        $sql="insert into codes(code,user_id,code_money) VALUE ('$str_code','{$data['user_id']}','{$code_money}')";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显
    public function edit($id){


        $sql="SELECT * FROM codes WHERE code_id=$id";
        $sql_c="SELECT status FROM codes WHERE code_id=$id";
        $status=$this->db->fetchColumn($sql_c);

        if($status==1){
            $this->error = "代金券已经被使用";
            return FALSE;
        }else{
        $row=$this->db->fetchRow($sql);
        return $row;}
    }
    public function update($data){
        $data['code_money']=(float)$data['code_money'];
        if(is_nan($data['code_money'])){
            $this->error = "请输入正确的金额";
            return false;
        }
        if(empty($data['code_money'])){
            $this->error = "请输入正确的金额";
            return false;
        }
        $str="ABCDEFGHIJKLMNPQRSTUVWXYABCDEFGHIJKLMNPQRSTUVWXY123456789123456789";
        $re_str=str_shuffle($str);
        $str_code=substr($re_str,0,8);
        $code_money=round($data['code_money'],5);
        $sql="update codes set code='$str_code',user_id='{$data['user_id']}',code_money='{$code_money}' WHERE code_id={$data['id']}";
//                var_dump($sql);exit;
        $this->db->query($sql);
    }
//    删除与判断是否删除
    public function delete($id){
        $sql="delete from codes WHERE code_id=$id";
        $sql_c="SELECT status FROM codes WHERE code_id=$id";
        $status=$this->db->fetchColumn($sql_c);
        if($status==0){
            $this->error = "代金没有使用不能删除";
            return FALSE;
        }else{
            //        var_dump($sql);exit;
            $this->db->query($sql);
        }
    }
    public function all($id){
        $sql="select * from codes WHERE user_id=$id and status=0";

//        echo $sql;exit;
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function getAll_se(){
        $sql="select * from codes WHERE user_id={$_SESSION['user_info1']['user_id']}";

        //        echo $sql;exit;
        $rows=$this->db->fetchAll($sql);
        foreach($rows as &$row){
            if($row['status']==0)
            {$row['status']= "未使用";}
            else{$row['status']= "已使用";}
        }
        return $rows;
    }
}