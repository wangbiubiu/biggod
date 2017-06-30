<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 14:36
 */
class ddModel extends Model{
    public function getAll($conditons){
        //1.准备sql语句，获取所有数据
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];

        //        让where为空以免收索全部内容报错
        $where = "";
        if( !empty( $conditons ) ){
            $where = " where " . $conditons;
        }

        //获取总条数
        $c_sql = "select count(*) from dd " . $where;
        $count = $this->db->fetchColumn( $c_sql );

        //每页显示多少条
        $pageSize = 2;

        $start = ($page - 1) * $pageSize;


        //        SELECT * FROM members LEFT JOIN `group` on members.group_id = `group`.group_id
        $sql = "SELECT * FROM dd " . $where .
               " limit $start,$pageSize";

        //        var_dump($sql);exit;


        //        $sql="select * from goods";
        $rows = $this->db->fetchAll( $sql );
//        用户名
        foreach($rows as $k=>&$v){
            $realname=$this->db->fetchColumn("select realname from users WHERE user_id={$v['user_id']}");
            $v['user_id']=$realname;
        }
//        商品名
        foreach($rows as $k=>&$v1){
            $realname=$this->db->fetchColumn("select goods_name from goods WHERE goods_id={$v1['goods_id']}");
            $v1['goods_id']=$realname;
        }



        $a    = [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
        return $a;
    }
    public function qr($dd_id){
        $sql_qr="select state from dd WHERE dd_id=$dd_id";
        $state=$this->db->fetchColumn($sql_qr);
        if($state==1){
            $this->error="发货失败，该订单已发货";
            return FALSE;
        }
        if($state==2){
            $this->error="发货失败，该订单已完成";
            return FALSE;
        }


        $sql="update dd set state=1 WHERE dd_id=$dd_id";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    后台订单列表
    public function all($id){
        //1.准备sql语句，获取所有数据
        $page = empty($_GET['page']) ? 1 : $_GET['page'];

        //获取总条数
        $count = $this->db->fetchColumn("select count(*) from dd WHERE user_id=$id");

        //每页显示多少条
        $pageSize = 2;

        $start = ($page-1)*$pageSize;
        $sql = "select * from dd WHERE user_id=$id limit $start,$pageSize";
        //2.执行sql语句
        $rows = $this->db->fetchAll($sql);

        //        用户名
        foreach($rows as $k=>&$v){
            $realname=$this->db->fetchColumn("select realname from users WHERE user_id={$v['user_id']}");
            $v['user_id']=$realname;
        }
        //        商品名
        foreach($rows as $k=>&$v1){
            $realname=$this->db->fetchColumn("select goods_name from goods WHERE goods_id={$v1['goods_id']}");
            $v1['goods_id']=$realname;
        }

        return ['rows'=>$rows,'page'=>$page,'count'=>$count,'pageSize'=>$pageSize];
    }
    public function qrsh($dd_id){
        $sql="update dd set state=2 WHERE dd_id=$dd_id";
        //        var_dump($sql);exit;
        $this->db->query($sql);
    }
}