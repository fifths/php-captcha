<?php

namespace Captcha;

/**
 * Created by PhpStorm.
 * User: fifths
 * Date: 17-6-19
 * Time: 上午9:47
 */
class Captcha
{
    public $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子

    public $code;//验证码

    public $codelen = 4;//验证码长度

    public $width = 120;//宽度

    public $height = 36;//高度

    public $img;//图形资源句柄

    public $font;//指定的字体

    public $fontsize = 20;//指定字体大小

    public $fontcolor;//指定字体颜色

    public function __construct()
    {
        $this->font = dirname(__FILE__) . '/../asset/font/Open_Sans_regular.ttf';
    }

    //随机码
    public function createCode()
    {
        $_len = strlen($this->charset) - 1;
        for ($i = 0; $i < $this->codelen; $i++) {
            $this->code .= $this->charset[mt_rand(0, $_len)];
        }
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    //背景
    public function createBg()
    {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
    }

    //文字
    public function createFont()
    {
        $_x = $this->width / $this->codelen;
        for ($i = 0; $i < $this->codelen; $i++) {
            $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontsize, mt_rand(-30, 30), $_x * $i + mt_rand(1, 5), $this->height / 1.4, $this->fontcolor, $this->font, $this->code[$i]);
        }
    }

    //线条、雪花
    public function createLine()
    {
        //线条
        for ($i = 0; $i < 6; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        //雪花
        for ($i = 0; $i < 100; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
        }
    }

    public function outPut()
    {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }

    public function createImage()
    {
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        $this->outPut();
    }

    public function getCode()
    {
        return strtolower($this->code);
    }
}