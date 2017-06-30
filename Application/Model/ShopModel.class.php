<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 21:25
 */
class ShopModel extends Model{
    /**
生成订单 完成扣分
     */
    public function shop($good_id){
//        当前用户id
        $id=$_SESSION['user_info1']['user_id'];
        $sql_on_integral="select * from users WHERE user_id=$id";
        $users_int=$this->db->fetchRow($sql_on_integral);
//        当前用户积分
        $integral=$users_int['integral'];
        $sql_goods="select * from goods WHERE goods_id=$good_id";
        $goods=$this->db->fetchRow($sql_goods);
//        当前商品库存
        $goods_num=$goods['num'];
//        当前商品价格
        $goods_integral=$goods['goods_integral'];
        //        扣除积分原因
        $content="兑换".$goods['goods_name']."扣除".$goods['goods_integral'];

//        积分不足的情况
        if($integral<$goods_integral){
            $this->error="积分不足无法兑换";
            return FALSE;
        }
//        库存不足的情况
        if($goods_num<1){
            $this->error="库存不足无法兑换";
            return FALSE;
        }
//        修改到数据库积分
        $up_integral=$integral-$goods_integral;
//        更新用户剩余积分
        $sql_update="update users set integral=$up_integral WHERE user_id=$id";
        $res=$this->db->query($sql_update);
//        加入到积分记录
        $sql_integral_up="insert into integral(user_id,integral_kou,kou_content,state)VALUES ($id,'$goods_integral','$content','扣除')";
        $this->db->query($sql_integral_up);
//        扣除一个库存
        $goods_num_up=$goods_num-1;
        $sum_sql="update goods set `num`=$goods_num_up WHERE goods_id=$good_id";
        $this->db->query($sum_sql);
//        如果扣除积分成功就生成订单
        if($res){
//            订单号码
            $str="ABCDEFGHIJKLMNPQRSTUVWXYABCDEFGHIJKLMNPQRSTUVWXY123456789123456789";
            $re_str=str_shuffle($str);
            $dd_num=substr($re_str,0,8);
            $dd_sql="insert into dd(dd_num,user_id,goods_id,state)VALUES('{$dd_num}',$id,$good_id,0)";
            $this->db->query($dd_sql);
        }
    }
}