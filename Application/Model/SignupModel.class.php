<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/14
 * Time: 23:16
 */
class SignupModel extends Model{
//后台注册
    public function add($data){
//        用户名是否输入
        if(empty($data['username'])){
            $this->error="请输入用户名";
            return FALSE;
        }
//        密码是否输入
        if(empty($data['password'])){
            $this->error="请输入密码";
            return FALSE;
        }
        //        query密码是否输入
        if(empty($data['re_password'])){
            $this->error="请确认密码";
            return FALSE;
        }
        //        密码是否输入
        if($data['password']!=$data['re_password']){
            $this->error="两次输入密码不一致";
            return FALSE;
        }
        //        姓名是否输入
        if(empty($data['realname'])){
            $this->error="请输入姓名";
            return FALSE;
        }
        //        性别是否输入
        if(empty($data['sex'])){
            $this->error="请输入性别";
            return FALSE;
        }

//        验证用户名是否重复
        $sql_re="select count(*) from `members` WHERE username='{$data['username']}'";
//        返回条数
//        var_dump($sql_re);exit;
        $count=$this->db->fetchColumn($sql_re);
        if($count>0){
            $this->error="用户名已经被使用";
            return FALSE;
        }
//        加密
        $password=md5($data['password']);

//        sql添加语句
        $sql="insert into `members`(username,password,realname,telephone,sex,is_admin,photo)VALUES ('{$data['username']}','$password','{$data['realname']}','{$data['telephone']}','{$data['sex']}','{$data['is_admin']}','{$data['photo']}')";
//        执行sql
        $this->db->query($sql);
    }
//前台注册
    public function user($data){
        //        用户名是否输入
        if(empty($data['username'])){
            $this->error="请输入用户名";
            return FALSE;
        }
        //        密码是否输入
        if(empty($data['password'])){
            $this->error="请输入密码";
            return FALSE;
        }
        //        query密码是否输入
        if(empty($data['re_password'])){
            $this->error="请确认密码";
            return FALSE;
        }
        //        密码是否输入
        if($data['password']!=$data['re_password']){
            $this->error="两次输入密码不一致";
            return FALSE;
        }
        //        姓名是否输入
        if(empty($data['realname'])){
            $this->error="请输入姓名";
            return FALSE;
        }
        //        性别是否输入
        if(empty($data['sex'])){
            $this->error="请输入性别";
            return FALSE;
        }

        //        验证用户名是否重复
        $sql_re="select count(*) from `users` WHERE username='{$data['username']}'";
        //        返回条数
        //        var_dump($sql_re);exit;
        $count=$this->db->fetchColumn($sql_re);
        if($count>0){
            $this->error="用户名已经被使用";
            return FALSE;
        }
        //        加密
        $password=md5($data['password']);
//        var_dump($data);exit;

        //        sql添加语句
        $sql="insert into `users`(username,password,realname,telephone,sex,photo)VALUES ('{$data['username']}','$password','{$data['realname']}','{$data['telephone']}','{$data['sex']}','{$data['photo']}')";
        //        执行sql
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
}