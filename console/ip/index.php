<?php
    // 不提示错误信息
    error_reporting(0);

    /* 方法 */
    // 防CC系统
    function verificationCC() {
        if ($_COOKIE['verification'] == null) {
            header('Location: ../../verification.html');
        }
    }

    // 验证登录状态
    function ifLogin () {
        if ($_COOKIE['yiso'] != null) {
            include('./admin.php');
        } else {
            header('Location: ./login.php');
        }
    }

    // 退出登录功能
    function outLogin() {
        if ($_GET['outLogin'] == true) {
            setcookie('yiso', null, 0);
        }
    }

    // 今日访问量
    function ipView() {
        $int = 0;
        $file = fopen('../../s/database/ipInfo/ipinfo.yiso', 'r');
        if ($file == null) {
            echo "<script>console.log('文件读取:error');<script>";
        }
        while (($Buffer = fgets($file, 10240)) !== false) {
            $int ++;
        }

        fclose($file);
        return $int;
    }

    // 显示IP功能
    function ipShow($intInfo) {
        $buffer = null;
        $int = 0;
        $bufferArray = [];
        $file = fopen('../../s/database/ipInfo/ipinfo.yiso', 'r');
        if ($file == null) {
            echo "<script>console.log('文件读取:error');<script>";
        }
        while (($Buffer = fgets($file, 10240)) !== false) {
            $buffer = $Buffer;
            $bufferArray[] = $Buffer;
            $int ++;
        }

        $newBufferArray = array_reverse($bufferArray);
        for ($i = 0; $i < $int; $i ++) {
            $array = explode("////", $newBufferArray[$i]);

            if ($i < 100) {
                echo "<span>".$array[$intInfo]."</span>";
            }
        }

        fclose($file);
        return array($buffer, $int);
    }

    // 执行顺序
    function start() {
        verificationCC(); // 防CC系统
        outLogin(); // 退出登录功能
        ifLogin(); // 验证登录状态
    }
    /* 方法 */

    /* -------------------- */
    start();
?>