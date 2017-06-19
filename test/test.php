<?php
/**
 * Created by PhpStorm.
 * User: fifths
 * Date: 17-6-19
 * Time: 上午9:56
 */

include "../vendor/autoload.php";

$Captcha = new \Captcha\Captcha();

$Captcha->createImage();