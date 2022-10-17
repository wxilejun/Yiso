<?php
    // 不提示错误信息
    error_reporting(0);

    // 表单数据
    function formInfo () {
        if ($_GET != null) {
            // 保存表单数据
            $code = $_GET['code'];
            $number = $_GET['number'];

            return array($code, $number);
        }
    }

    // 写入文件
    function sendInfo ($code, $number) {
        // IP
        $ip_anhui = "222.48.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_beijing = "58.30.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_fujian = "58.22.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_gansu = "118.205.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_guangdong = "58.60.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_guangxi = "116.252.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_guizhou = "58.42.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_hainan = "124.225.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_hebei = "121.20.".mt_rand(0, 255).".".mt_rand(0, 255);
        $ip_henan = "61.163.".mt_rand(0, 255).".".mt_rand(0, 255);

        for ($i = 0; $i < $number; $i ++) {
            // 概率
            $probability = mt_rand(0, 9);
            switch ($probability) {
                case 0:
                    $ip = $ip_henan;
                    break;
                case 1:
                    $ip = $ip_anhui;
                    break;
                case 2:
                    $ip = $ip_beijing;
                    break;
                case 3:
                    $ip = $ip_fujian;
                    break;
                case 4:
                    $ip = $ip_gansu;
                    break;
                case 5:
                    $ip = $ip_guangdong;
                    break;
                case 6:
                    $ip = $ip_guangxi;
                    break;
                case 7:
                    $ip = $ip_guizhou;
                    break;
                case 8:
                    $ip = $ip_hainan;
                    break;
                case 9:
                    $ip = $ip_hebei;
                    break;
            }
            $string = file_get_contents('../database/ipInfo/ipinfo.yiso');
            $file = fopen('../database/ipInfo/ipinfo.yiso', 'w');
            $fwrite = fwrite($file, $string."\r\n".date('Y/m/d')."////".$ip."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null");
        }
        fclose($file);
    }

    $formInfo = formInfo();

    if ($formInfo != null) {
        if ($formInfo[0] == "0110") {
            sendInfo($formInfo[0], $formInfo[1]);
            echo "执行成功";
        } else {
            echo "执行错误";
        }
    }
?>