<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 14:36
 */
class UserModel extends Model{
    public function getAll($conditons){
        //1.准备sql语句，获取所有数据
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];

        //        让where为空以免收索全部内容报错
        $where = "";
        if( !empty( $conditons ) ){
            $where = " where " . $conditons;
        }

        //获取总条数
        $c_sql = "select count(*) from `users` " . $where;
        $count = $this->db->fetchColumn( $c_sql );

        //每页显示多少条
        $pageSize = 2;

        $start = ($page - 1) * $pageSize;


        //        SELECT * FROM members LEFT JOIN `group` on members.group_id = `group`.group_id
        $sql = "SELECT * FROM users " . $where .
               " limit $start,$pageSize";

        //        var_dump($sql);exit;


        //        $sql="select * from goods";
        $rows = $this->db->fetchAll( $sql );
        $a    = [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
//                var_dump($a);exit;
        //        返回员工数与分页数据
        return $a;
    }
    public function insert($data){
        //        用户名是否输入
        //        var_dump($data);exit;
        if(empty($data['username'])){
            $this->error="请输入用户名";
            return FALSE;
        }
        //        密码是否输入
        if(empty($data['password'])){
            $this->error="请输入密码";
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
        //        var_dump($data);exit;
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


        //        sql添加语句
        $sql="insert into `users`(username,password,realname,telephone,sex,photo,remark)VALUES ('{$data['username']}','$password','{$data['realname']}','{$data['telephone']}','{$data['sex']}','{$data['photo']}','{$data['remark']}')";
        //        执行sql
//                var_dump($sql);exit;
        $this->db->query($sql);
    }
    //    回显
    public function edit($id){
        $sql="SELECT * FROM users WHERE user_id=$id";
        //        var_dump($sql);
        $row=$this->db->fetchRow($sql);
//        var_dump($row);exit;
        return $row;
    }
    public function update($data){
        //        用户名是否输入
        //        var_dump($data);exit;
        if(empty($data['username'])){
            $this->error="请输入用户名";
            return FALSE;
        }
        //        密码是否输入
        if(empty($data['password'])){
            $this->error="请输入密码";
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
        //        var_dump($data);exit;
        //        验证用户名是否重复
        $sql_re="select count(*) from `users` WHERE username='{$data['username']}'";
        //        返回条数
        //        var_dump($sql_re);exit;
        $count=$this->db->fetchColumn($sql_re);
        if($count>1){
            $this->error="用户名已经被使用";
            return FALSE;
        }
        //        加密
        $password=md5($data['password']);

        //        sql添加语句
        $sql="update `users` set username='{$data['username']}',password='$password',realname='{$data['realname']}',telephone='{$data['telephone']}',sex='{$data['sex']}',photo='{$data['photo']}' WHERE user_id={$data['id']}";
        //        执行sql
//                var_dump($sql);exit;
        $this->db->query($sql);
    }
//    会员删除
    public function delete($id){
        $sql="delete from users WHERE user_id=$id";
        $sql_c="select count(*) from histories WHERE user_id=$id";
        $count=$this->db->fetchColumn($sql_c);
//                var_dump($count);exit;
        if($count>0){
            return FALSE;
        }else{
            $this->db->query($sql);}
    }
    public function all(){
        $sql="select * from users";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
}