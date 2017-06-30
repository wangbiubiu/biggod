<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 14:36
 */
class GoodsModel extends Model{
    public function getAll(){
        //1.准备sql语句，获取所有数据
        $page = empty($_GET['page']) ? 1 : $_GET['page'];

        //获取总条数
        $count = $this->db->fetchColumn("select count(*) from goods");

        //每页显示多少条
        $pageSize = 2;

        $start = ($page-1)*$pageSize;
        $sql = "select * from goods limit $start,$pageSize";
        //2.执行sql语句
        $rows = $this->db->fetchAll($sql);

        return ['rows'=>$rows,'page'=>$page,'count'=>$count,'pageSize'=>$pageSize];

    }
    public function insert($data){
        //        var_dump($data);exit;
        if(empty($data['goods_name'])){
            $this->error="请输入商品名";
            return FALSE;
        }

        if(empty($data['goods_integral'])){
            $this->error="请输入积分";
            return FALSE;
        }
        //        姓名是否输入
        if(empty($data['num'])){
            $this->error="请输入库存";
            return FALSE;
        }
//        var_dump($data);exit;
        $sql="insert into goods(goods_name,goods_integral,num,goods_logo)VALUES ('{$data['goods_name']}','{$data['goods_integral']}','{$data['num']}','{$data['photo']}')";
//                var_dump($sql);exit;
        $this->db->query($sql);
    }
    //    回显
    public function edit($id){
        $sql="SELECT * FROM goods WHERE goods_id=$id";
        //        var_dump($sql);
        $row=$this->db->fetchRow($sql);
//        var_dump($row);exit;
        return $row;
    }
    public function update($data){
        //        var_dump($data);exit;
        if(empty($data['goods_name'])){
            $this->error="请输入商品名";
            return FALSE;
        }

        if(empty($data['goods_integral'])){
            $this->error="请输入积分";
            return FALSE;
        }
        //        姓名是否输入
        if(empty($data['num'])){
            $this->error="请输入库存";
            return FALSE;
        }
        //        var_dump($data);exit;
        $sql="update goods set goods_name='{$data['goods_name']}',goods_integral='{$data['goods_integral']}',num='{$data['num']}',goods_logo='{$data['photo']}' WHERE goods_id={$data['id']}";
        //                var_dump($sql);exit;
        $this->db->query($sql);
    }
//    会员删除
    public function delete($id){
        $sql="delete from goods WHERE goods_id=$id";

            $this->db->query($sql);
    }
}