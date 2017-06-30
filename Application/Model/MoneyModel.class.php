<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 14:05
 */
class MoneyModel extends Model{
//    充值
    public function plus($data){
        $data['money']=(float)$data['money'];
        if(empty($data['money'])){
            $this->error = "请填写金额";
            return false;
        }
        if(is_nan($data['money'])){
            $this->error = "请填写正确的金额";
            return false;
        }
//        接收到的充值金额四舍五入
        $c_money=round($data['money'],2);
//        充值规则
        $sql_money="select * from setmoney WHERE money_c<=$c_money ORDER BY  money_c DESC limit 0,1";
        $set_moneys=$this->db->fetchAll($sql_money);
//        var_dump($set_moneys);exit;
//        echo $set_moneys[0]['money_s'];exit;
//        得出充值规则赠送金额
        $s_money=$set_moneys[0]['money_s'];

//        查询余额
        $sql_money="select * from users WHERE user_id={$data['id']}";
        $userss=$this->db->fetchRow($sql_money);
        $on_money=$userss['money'];
        $sum_money=$userss['sum'];
//        计算出真正充值金额  原有金额 +充值金额 +赠送金额
//        var_dump($c_money);exit;
        $money=$c_money+$on_money+$s_money;
        $sql_c="update users set money=$money,`sum`=$c_money+$sum_money WHERE user_id={$data['id']}";
//        var_dump($sql);exit;
//        更新余额
        $this->db->query($sql_c);
//        充值成功修改VIP等级再次查询sum
        $sql_money="select * from users WHERE user_id={$data['id']}";
        $userss=$this->db->fetchRow($sql_money);
        $sum_money=$userss['sum'];
//        根据充值金额查询升级所需金额
        $sql_rule="select * from setvip WHERE money_c<=$sum_money ORDER BY  money_c DESC limit 0,1";
        $set_vips=$this->db->fetchAll($sql_rule);
//        var_dump($set_vips);exit;
//        充值时升级的等级为
        $set_vip=$set_vips[0]['vip_grade'];
//        var_dump($set_vip);exit;
        //        查询当前等级
        $sql_money="select is_vip from users WHERE user_id={$data['id']}";
        $on_vip=$this->db->fetchColumn($sql_money);
//        var_dump($set_vip,$on_vip);exit;
//        判断当前要设置的vip是否大于原来的vip
        if($set_vip>$on_vip){
            $up_vip=$set_vip;
        }else{
            $up_vip=$on_vip;
        }
//        var_dump($up_vip);exit;
//        更新vip等级
        $sql_up_vip="update users set is_vip=$up_vip WHERE user_id={$data['id']}";
        $this->db->query($sql_up_vip);
//        充值成功更新到记录表
//        查询充值后的会员信息
        $sql_v="select * from users WHERE user_id={$data['id']}";
        $user_c=$this->db->fetchRow($sql_v);
//        var_dump($user_c);exit;
        $sql_vip="insert into histories(user_id,member_id,`type`,amount,remainder) VALUES ('{$user_c['user_id']}','{$_SESSION['user_info']['member_id']}','充值','$c_money','{$user_c['money']}')";
        $this->db->query($sql_vip);
    }
    public function reduce($data){
//        var_dump($data);exit;
        /**
获取当前消费金额  与消费的内容
         */
//        当前套餐金额查询
        $sql_plan="select * from plans WHERE plan_id={$data['plan_id']}";
        $plan=$this->db->fetchRow($sql_plan);
//当前套餐名字
        $plan_name=$plan['name'];
//当前消费金额
        $money_x=$plan['money'];
//        $money_x=(int)$money_x;
//        var_dump($name);exit;
        /**
        获取当前会员的vip等级  与当前等级对应的折扣 setvip表
         * 等级
         * 折扣
         * 余额
         */
        $sql_users="select * from users WHERE user_id={$data['id']}";
        $user=$this->db->fetchRow($sql_users);
//当前余额
        $user_money=$user['money'];
//        当前积分
        $user_integral=$user['integral'];

        $user_vip=$user['is_vip'];
//        根据vip等级查询折扣
        $sql_discount="select vip_discount from setvip WHERE vip_grade=$user_vip";
        $vip_discount=$this->db->fetchColumn($sql_discount);
//当前折扣
        $discount=$vip_discount*0.1;
        /**
         * 代金券的金额 与 是否修改代金券状态
         */
        $sql_code="select code_money from codes WHERE code_id={$data['code_id']}";
//当前代金券金额
        $code_money=$this->db->fetchColumn($sql_code);

        /**
         * 最后消费金额
         */
//打折后的消费金额
        $discount_on_money=$money_x*$discount;
//        打折后并且扣除代金券的金额
//        var_dump($discount_on_money);exit;
        $code_in_money=$discount_on_money-$code_money;
//        更新余额
        $discounting_money=$user_money-$code_in_money;
//        如果打折后的消费金额小于代金券金额 更新后余额就等于当前余额
        if($code_money>=$discount_on_money){
            $discounting_money=$user_money;
        }
//        余额不足拒绝消费
        if($user_money<$code_in_money){
            $this->error="余额不足";
            return FALSE;
        }

//        修改的积分余额和钱的余额
        $fen=(int)$money_x;
        $up_integral=$user_integral+(int)$fen;
        $sql_update_money="update users set money=$discounting_money,integral=$up_integral  WHERE user_id={$data['id']}";
//        var_dump($sql_update_money);exit;
        $result=$this->db->query($sql_update_money);
//        修改代金券状态
                if($code_money!=0){
                    $sql_code_update="update codes set status=1 WHERE code_id={$data['code_id']}";
                    $this->db->query($sql_code_update);
                }
//        添加消费记录
//        查询消费后的余额
        $yu_sql="select money from users WHERE user_id={$data['id']}";
                $yue=$this->db->fetchColumn($yu_sql);
        $sql_xf="insert into histories(user_id,member_id,`type`,amount,content,remainder) VALUES ({$data['id']},'{$data['member_id']}','消费','$code_in_money','{$plan_name}','$yue')";
        $this->db->query($sql_xf);

//        添加积分记录
        if($result){
            $content="消费：“{$plan_name}”，"."获得积分:".(int)$money_x;
            $this->integral_jia($data['id'],(int)$money_x,$content);
        }
    }
//    增加积分方法
    public function integral_jia($user_id,$integral,$content){
        $sql="insert into integral(user_id,integral_jia,jia_content,state)VALUES ($user_id,$integral,'$content','获得')";
        $this->db->query($sql);
    }
}