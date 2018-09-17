<?php
/**
 * Created by PhpStorm.
 * User: fifths
 * Date: 17-6-19
 * Time: 上午9:56
 */

include "../vendor/autoload.php";

/*$Captcha = new \Captcha\Captcha();

$Captcha->createImage();*/

$Captcha = new \Captcha\NewCaptcha();
$image = $Captcha->createImage();
header('Content-type:image/png');
imagepng($image);
imagedestroy($image);
