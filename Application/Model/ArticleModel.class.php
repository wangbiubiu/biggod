<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/25
 * Time: 15:13
 */
class ArticleModel extends Model{
//    活动主页
    public function getAll(){
        $time=time();
        $sql="select * from article WHERE `end`>$time";
        $rows=$this->db->fetchAll($sql);
//        $row=[];
//        foreach($rows as $k=>$v){
//            if(strtotime($v['end'])<strtotime($time)){
//                $row=$v;
//            }
//        }
//        var_dump($a); echo ;exit;

        return $rows;
    }
    public function getAll1(){
        $sql="select * from article ";
        $rows=$this->db->fetchAll($sql);
        //        $row=[];
        //        foreach($rows as $k=>$v){
        //            if(strtotime($v['end'])<strtotime($time)){
        //                $row=$v;
        //            }
        //        }
        //        var_dump($a); echo ;exit;

        return $rows;
    }


//    添加活动
    public function insert($data){
        if(empty($data['title'])){
            $this->error = "请填写活动标题！";
            return false;
        }
        if(empty($data['content'])){
            $this->error = "请填写活动内容！";
            return false;
        }
        if(empty($data['start'])){
            $this->error = "请填写活动开始日期！";
            return false;
        }
        if(empty($data['end'])){
            $this->error = "请填写活动结束日期！";
            return false;
        }
        $data['start']=strtotime($data['start']);
        $data['end']=strtotime($data['end']);
        $sql="insert into article(title,content,start,`end`,admin)VALUE ('{$data['title']}','{$data['content']}','{$data['start']}','{$data['end']}','{$_SESSION['user_info']['realname']}')";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }
//    回显活动
    public function edit($id){
        $sql="select * from article WHERE article_id=$id";
        $row=$this->db->fetchRow($sql);
//        var_dump($row);exit;
        return $row;
    }
//    修改活动
    public function update($data){
        if(empty($data['title'])){
            $this->error = "请填写活动标题！";
            return false;
        }
        if(empty($data['content'])){
            $this->error = "请填写活动内容！";
            return false;
        }
        if(empty($data['start'])){
            $this->error = "请填写活动开始日期！";
            return false;
        }
        if(empty($data['end'])){
            $this->error = "请填写活动结束日期！";
            return false;
        }
        $data['start']=strtotime($data['start']);
        $data['end']=strtotime($data['end']);
        $sql="update article set admin='{$_SESSION['user_info']['realname']}',title='{$data['title']}',content='{$data['content']}',start='{$data['start']}',`end`='{$data['end']}' WHERE article_id={$data['id']}";
//                var_dump($sql);exit;
        $this->db->query($sql);
    }
    public function delete($id){
        $sql="delete from article WHERE article_id=$id";
//        var_dump($sql);exit;
        $this->db->query($sql);
    }

}