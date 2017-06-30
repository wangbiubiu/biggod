<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 23:26
 */
class HistoriesModel extends Model{
    public function getAll($conditons){
        //1.准备sql语句，获取所有数据
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];

        //        让where为空以免收索全部内容报错
        $where = "";
        if( !empty( $conditons ) ){
            $where = " where " . $conditons;
        }

        //获取总条数
        $c_sql = "select count(*) from `histories` " . $where;
        $count = $this->db->fetchColumn( $c_sql );

        //每页显示多少条
        $pageSize = 2;

        $start = ($page - 1) * $pageSize;


        //        SELECT * FROM members LEFT JOIN `group` on members.group_id = `group`.group_id
        $sql = "SELECT * FROM histories " . $where .
               " order by `time` desc limit $start,$pageSize";
        //        var_dump($sql);exit;


        //        $sql="select * from goods";
        $rows = $this->db->fetchAll( $sql );
//        var_dump($rows);exit;
        foreach($rows as $k=>&$v){
//            echo $v['user_id']."=";
            $username=$this->db->fetchColumn("select realname from users WHERE user_id={$v['user_id']}");
            $v['user_id']=$username;
            $member=$this->db->fetchColumn("select realname from members WHERE member_id={$v['member_id']}");
            $v['member_id']=$member;
        }
//              exit;
        $a    = [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
        //                var_dump($a);exit;
        //        返回员工数与分页数据
        return $a;
    }
    public function getAll1($conditons){
        //1.准备sql语句，获取所有数据
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];

        //        让where为空以免收索全部内容报错
        $where = "";
        if( !empty( $conditons ) ){
            $where = " where " . $conditons;
        }

        //获取总条数
        $c_sql = "select count(*) from `histories` " . $where;
        $count = $this->db->fetchColumn( $c_sql );

        //每页显示多少条
        $pageSize = 2;

        $start = ($page - 1) * $pageSize;
        //        SELECT * FROM members LEFT JOIN `group` on members.group_id = `group`.group_id
        $sql = "SELECT * FROM histories " . $where.
               " order by `time` desc limit $start,$pageSize";
//                var_dump($sql);exit;


        //        $sql="select * from goods";
        $rows = $this->db->fetchAll( $sql );
        //        var_dump($rows);exit;
        foreach($rows as $k=>&$v){
            //            echo $v['user_id']."=";
            $username=$this->db->fetchColumn("select realname from users WHERE user_id={$v['user_id']}");
            $v['user_id']=$username;
            $member=$this->db->fetchColumn("select realname from members WHERE member_id={$v['member_id']}");
            $v['member_id']=$member;
        }
        //              exit;
        $a    = [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
        //                var_dump($a);exit;
        //        返回员工数与分页数据
        return $a;
    }
    public function users(){
        $sql="select * from users";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function members(){
        $sql="select * from members";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }

}