<?php

namespace Captcha;

class NewCaptcha
{
    /**
     * @var int
     */
    protected $length = 4;

    /**
     * @var int
     */
    protected $width = 120;

    /**
     * @var int
     */
    protected $height = 36;

    /**
     * @var int
     */
    protected $angle = 15;

    /**
     * @var int
     */
    protected $lines = 3;

    /**
     * @var string
     */
    protected $characters = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';

    /**
     * @var array
     */
    protected $fonts = [];

    /**
     * @var string
     */
    protected $fontDir;

    /**
     * @var array
     */
    protected $fontColors = ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'];

    /**
     * @var array
     */
    protected $backgrounds = [];

    /**
     * @var
     */
    protected $code;

    /**
     * @var
     */
    protected $image;

    public function __construct()
    {
        $this->fontDir = dirname(__FILE__) . '/../asset/font/';
        $file = scandir($this->fontDir);
        array_splice($file, 0, 2);
        $this->fonts = array_values($file);
    }

    public function createBg()
    {
        $this->image = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->image, 216, 216, 216);
        imagefilledrectangle(
            $this->image,
            0,
            $this->height,
            $this->width,
            0,
            $color
        );
    }

    public function createCode()
    {
        $_len = strlen($this->characters) - 1;
        for ($i = 0; $i < $this->length; $i++) {
            $this->code .= $this->characters[mt_rand(0, $_len)];
        }
    }

    public function createLine()
    {
        //线条
        for ($i = 0; $i < $this->lines; $i++) {
            $fontColor = $this->fontColor();
            $color = imagecolorallocate($this->image, $fontColor[0], $fontColor[1], $fontColor[2]);
            imageline(
                $this->image,
                rand(0, $this->width) + $i * rand(0, $this->height),
                mt_rand(0, $this->height),
                mt_rand(0, $this->width),
                mt_rand(0, $this->height),
                $color
            );
        }
    }

    function hex2rgb($hexColor)
    {
        $color = str_replace('#', '', $hexColor);
        if (strlen($color) > 3) {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        } else {
            $color = $hexColor;
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }

    public function createFont()
    {
        $_x = $this->width / $this->length;
        for ($i = 0; $i < $this->length; $i++) {
            $fontColor = $this->fontColor();
            $color = imagecolorallocate($this->image, $fontColor[0], $fontColor[1], $fontColor[2]);
            imagettftext(
                $this->image,
                20,
                mt_rand(-30, 30),
                $_x * $i + mt_rand(1, 5),
                $this->height / 1.4,
                $color,
                $this->font(),
                $this->code[$i]
            );
        }
    }

    protected function font()
    {
        $font = $this->fontDir . $this->fonts[rand(0, count($this->fonts) - 1)];
        return $font;
    }

    public function outPut()
    {
        header('Content-type:image/png');
        imagepng($this->image);
        imagedestroy($this->image);
    }

    public function createImage()
    {
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        return $this->image;
    }

    protected function fontColor()
    {
        if (!empty($this->fontColors)) {
            $value = $this->hex2rgb($this->fontColors[mt_rand(0, count($this->fontColors) - 1)]);
            $color = [$value['r'], $value['g'], $value['b']];
        } else {
            $color = [mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)];
        }
        return $color;
    }

    /**
     * @return string
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param string $characters
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}