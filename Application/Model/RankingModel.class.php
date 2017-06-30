<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 0:22
 */
class RankingModel extends Model{
    public function getAll_c(){
        $sql="SELECT user_id ,sum(amount) as money from histories WHERE `type`='充值' group by user_id ORDER BY money desc limit 0,3";
//        var_dump($sql);exit;
        $rows=$this->db->fetchAll($sql);

        foreach($rows as $k=>&$v){
            $realname=$this->db->fetchColumn("select realname from users WHERE user_id={$v['user_id']}");
            $v['user_id']=$realname;
        }
        return $rows;
    }

    public function getAll_x(){
        $sql="SELECT user_id ,sum(amount) as money_x from histories WHERE `type`='消费' group by user_id ORDER BY money_x desc limit 0,3";

        $rows=$this->db->fetchAll($sql);

        foreach($rows as $k=>&$v){
            $realname=$this->db->fetchColumn("select realname from users WHERE user_id={$v['user_id']}");
            $v['user_id_x']=$realname;
        }
//        var_dump($rows);exit;
        return $rows;

    }
    public function getAll_f(){
        $sql="SELECT member_id ,count(member_id) as ci from histories WHERE `type`='消费' group by member_id ORDER BY ci desc  limit 0,3";

        $rows=$this->db->fetchAll($sql);
        foreach($rows as $k=>&$v){
            $realname=$this->db->fetchColumn("select realname from members WHERE member_id={$v['member_id']}");
            $v['member_id']=$realname;
        }
//                var_dump($rows);exit;
        return $rows;
    }


}