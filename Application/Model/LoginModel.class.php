<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/15
 * Time: 19:05
 */
class LoginModel extends Model{
//    验证后台
    public function check($data){
        //        先加密才能和数据库对比
        $password=md5($data['password']);
        //        构造sql
        $sql="select * from `members` WHERE username='{$data['username']}' AND password='{$password}'";
//        var_dump($sql);exit;
        $row=$this->db->fetchRow($sql);
        if(empty($row)){
            $this->error=("用户名或密码错误");
            return FALSE;
        }else{
            return $row;
        }
    }
    public function checkByCookie($id,$password){
        //》》1.更加id查询数据中对应的数据
        $sql = "select * from members WHERE member_id={$id}";
        $row = $this->db->fetchRow($sql);
        //            var_dump($row);
        //>>2.将数据库中的密码取出来再次加密和传入的密码进行比对
        $password_in_db = md5($row['password']."_itsource");
        if($password_in_db != $password){
            $this->error = "验证失败！";
            return false;
        }else{
            return $row;
        }
    }
//    验证前台
    public function check2($data){
        //        先加密才能和数据库对比
        $password=md5($data['password']);
        //        构造sql
        $sql="select * from `users` WHERE username='{$data['username']}' AND password='{$password}'";
        //        var_dump($sql);exit;
        $row=$this->db->fetchRow($sql);
        if(empty($row)){
            $this->error=("用户名或密码错误");
            return FALSE;
        }else{
            return $row;
        }
    }
    public function checkByCookie2($id,$password){
        //》》1.更加id查询数据中对应的数据
        $sql = "select * from users WHERE user_id={$id}";
        $row = $this->db->fetchRow($sql);
        //            var_dump($row);
        //>>2.将数据库中的密码取出来再次加密和传入的密码进行比对
        $password_in_db = md5($row['password']."_itsource");
        if($password_in_db != $password){
            $this->error = "验证失败！";
            return false;
        }else{
            return $row;
        }
    }

}