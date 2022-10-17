<?php
    // 不提示错误信息
    error_reporting(0);

    /* 方法函数集 */
    // 验证表单和验证码
    function authenticationInfo () {
        $userName = null;
        $passWord = null;

        if ($_POST['username'] == null) {
            echo "<script>console.log('账号为空');</script>";
        } else {
            echo "<script>console.log('账号表单: ok');</script>";
            if ($_POST['code'] == $_COOKIE['yanZhengMa']) {
                echo "<script>console.log('验证码表单: ok');</script>";
                $userName = $_POST['username'];
                $passWord = $_POST['password'];
            }
        }

        return array($userName, $passWord);
    }

    // 登录功能
    function login () {
        $form = authenticationInfo(); // 验证表单和验证码

        if ($form[0] != null) {
            $file = fopen('../s/database/webInfo/admin.yiso', 'r');
            while (($Buffer = fgets($file, 10240)) !== false) {
                $array = explode("////", $Buffer);
                if ($form[0] == $array[0]) {
                    if ($form[1] == $array[1]) {
                        echo "<script>console.log('登录状态: ok');</script>";
                        setcookie('userName', $form[0], 0);
                        var_dump($_COOKIE['userName']);
                        header('Location: ./index.php');
                    } else {
                        echo "<script>console.log('账号正确: 密码错误');</script>";
                    }
                } else {
                    echo "<script>console.log('没找到账号: 账号错误');</script>";
                }
            }

            fclose($file);
        }
    }

    // 检测登录
    function ifLogin () {
        if ($_COOKIE['userName'] != null) {
            header('Location: ./index.php');
        }
    }
    /* 方法函数集 */

    /* 执行顺序 */
    function start() {
        login(); // 登录功能
        ifLogin(); // 检测登录
    }
    /* 执行顺序 */

    /* -------------------- */
    start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>请先登录</title>

    <!-- 框架文件 -->
    <link rel="stylesheet" href="../css/layui/css/layui.css">

    <style>
        form {
            width: 70%;
            margin: 0 auto auto auto;
            padding: 20px;
        }

        form > div {
            margin: 10px 0;
            text-align: center;
        }

        form > div > img {
            box-shadow: 0 2px 10px #ff0000;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <form class="layui-form" action="./login.php" method="POST">
        <input type="text" name="username" required lay-verify="required" placeholder="账号" autocomplete="off" class="layui-input layui-anim layui-anim-fadein">
        <input type="password" name="password" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input layui-anim layui-anim-fadein" style="margin-top: 4px;">
        <div>
            <img src="../s/included/webAuthenticationCode.php" alt="">
        </div>
        <input type="text" name="code" required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input layui-anim layui-anim-fadein">
        <button class="layui-btn layui-btn-normal layui-anim layui-anim-fadein" style="margin-top: 10px; display: block !important; width: 100%;">登录</button>
    </form>

<script src="../css/layui/layui.js"></script>

</body>
</html>