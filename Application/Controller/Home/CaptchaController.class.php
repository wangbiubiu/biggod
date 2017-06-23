<?php

/**
 * 生产验证码
 */
class CaptchaController extends Controller
{
    /**
     * 生产验证码
     */
    public function index(){
//1.生成随机字符串
        //准备所有可能使用的字符（数字和字母）
        $string1 = "0123456789";
        //打乱字符串
        $string11 = str_shuffle($string1);
        $string22 = str_shuffle($string1);

        $opt = array('+', '*');
        $optrand = $opt[rand(0, 1)];

        //截取指定长度来作为随机验证码
        $num = 1;
//        随机加法第一位
        $random_code1 = substr($string11,0,$num);
        //        随机加法第二位
        $random_code2 = substr($string22,0,$num);

//        放入图片
        $random_code=$random_code1." "."$optrand"." ".$random_code2." = "."?";

        $num1=(int)$random_code1;
        $num2=(int)$random_code2;

        if($optrand=="+"){
        $random_code2=$num1+$num2;
        }
        if($optrand=="*"){
            $random_code2=$num1*$num2;
        }

        //将生成的随机验证码放入session中
        @session_start();
        $_SESSION['random_code'] = $random_code2;

        $captcha_path = PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,19).".jpg";
        $image_info = getimagesize($captcha_path);
        list($width,$height) = $image_info;
//        var_dump($width,$height);exit;
        $image = imagecreatefromjpeg($captcha_path);

//3.字体颜色随机改变
        //准备颜色
        $black = imagecolorallocate($image,0,0,0);
        $white = imagecolorallocate($image,255,255,255);
        //写字
//        imagestring($image,5,$width/3-20,$height/6,$random_code,mt_rand(0,1) ? $black:$white);
//        自定义字体
        imagefttext($image,30,0,$width/5,$height/2+10,mt_rand(0,1) ? $black:$white,"./Public/Admin/captcha/STHUPO.TTF",$random_code);
//        imagefttext($image,25,0,$width/3,$height/2,$white,"./Public/Admin/captcha/STHUPO.TTF","北京欢迎你！");

//4.白色边框
        //imagerectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $col )
//        imagerectangle($image,0,0,$width-1,$height-1,$white);
//       //混淆验证码
//        //1.在验证码添加点（多个）
//        for ($i=0;$i<100;$i++){
//            //imagesetpixel ( resource $image , int $x , int $y , int $color )
//            $color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//            imagesetpixel($image,mt_rand(1,$width-2),mt_rand(1,$height-2),$color);
//        }
//
//        //2.画线
//        for ($i=0;$i<5;$i++){
//            $color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//            //imageline ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
//            imageline($image,mt_rand(1,$width-2),mt_rand(1,$height-2),mt_rand(1,$width-2),mt_rand(1,$height-2),$color);
//        }

//输出图片到浏览器
        header("Content-Type: image/jpeg");
        imagejpeg($image);

//关闭图片资源
        imagedestroy($image);
    }
}