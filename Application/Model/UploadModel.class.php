<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/18
 * Time: 21:47
 */
class UploadModel extends Model{
//    上传图片
    public function uploadOne($file,$dir=''){
//        根据error
        if($file['error'] != 0){
            $this->error = "文件上传失败！";
            return false;
        }
//根据size
        $max_size = 2*1024*1024;//允许上传的最大文件大小
        if($file['size'] > $max_size){
            $this->error = "文件太大~！";
            return false;
        }
//根据type
        $allow_types = ['image/gif','image/jpeg','image/pjpeg','image/png','image/x-png'];//允许上传的类型
        if(!in_array($file['type'],$allow_types)){
            $this->error = "请上传图片！";
            return false;
        }
//        是否为post请求提交的图片
        if(!is_uploaded_file($file['tmp_name'])){
            $this->error = "不是上传的文件~！";
            return false;
        }
//        准备文件名
        $filename=uniqid("IT_").strrchr($file['name'],".");
        //自动创建文件夹 创建在这个文件名下
        $dir .= date("Ymd")."/";
        if(!is_dir(UPLOADS_PATH.$dir)){//判定文件夹是否存在
            mkdir(UPLOADS_PATH.$dir,0777,true);
        }

        //完整的路径名 绝对路径
        $full_name = UPLOADS_PATH.$dir.$filename;
//判断
        if(!move_uploaded_file($file['tmp_name'],$full_name)){
            $this->error = "移动文件失败！";
            return false;
        }
//        返回地址添加到数据库
//        var_dump($dir.$filename);exit;
        return $dir.$filename;
    }
}