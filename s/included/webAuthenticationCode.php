<?php
    // 生成验证码 (方法 Function)
    function verifyCode () {
        // 设置页面类型
        header("Content-Type: image/png");

        // 画布宽高
        $verifyCodeWidth = 100;
        $verifyCodeHeight = 50;

        // 创建画布
        $verifyCodeImage = imagecreatetruecolor($verifyCodeWidth, $verifyCodeHeight);
        // 设置画布颜色
        $verifyCodeImageRed = imagecolorallocate($verifyCodeImage, 220, 0, 0);
        $verifyCodeImageGreen = imagecolorallocate($verifyCodeImage, 0, 255, 0);
        $verifyCodeImageBlue = imagecolorallocate($verifyCodeImage, 0, 0, 255);
        $verifyCodeImageBlack = imagecolorallocate($verifyCodeImage, 0, 0, 0);
        $verifyCodeImageBaiSe = imagecolorallocate($verifyCodeImage, 255, 255, 255);
        // 填充颜色
        $verifyCodeImageFill = imagefill($verifyCodeImage, 0, 0, $verifyCodeImageBlack);
        // 实现划线
        imageline($verifyCodeImage, 0, 0, 100, 0, $verifyCodeImageBaiSe);
        $lineHeight = 0;
        $lineRand = mt_rand(1, 9);
        for ($i = 0; $i < mt_rand(10, 20); $i ++) {
            $lineHeight += $lineRand;
            imageline($verifyCodeImage, 0, $lineHeight, 100, $lineHeight, $verifyCodeImageBaiSe);
        }
        // 实现写字
        $textRand = mt_rand(1, 9999);
        $verifyCodeImageText = imagestring($verifyCodeImage, 4, 30, 20, $textRand, $verifyCodeImageBaiSe);
        imagepng($verifyCodeImage);
        imagedestroy($verifyCodeImage);
        
        // 验证码数据
        setcookie("yanZhengMa", $textRand, time() + 60, "/");
    }

    // 执行
    verifyCode();
?>