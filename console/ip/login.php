<?php
    // 不提示错误信息
    error_reporting(0);

    /* 方法 */
    // 登录系统
    function login() {
        if ($_POST['password'] != null) {
            if ($_POST['password'] == 'yiso') {
                setcookie('yiso', 'true', 0);
                header('Location: ./index.php');
            }
        }
    }

    // 执行顺序
    function start() {
        login(); // 登录系统
    }
    /* 方法 */

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
    <link rel="stylesheet" href="../../css/layui/css/layui.css">

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
        <input type="password" name="password" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input layui-anim layui-anim-fadein" style="margin-top: 4px;">
        <button class="layui-btn layui-btn-normal layui-anim layui-anim-fadein" style="margin-top: 10px; display: block !important; width: 100%;">登录</button>
    </form>

<script src="../../css/layui/layui.js"></script>

</body>
</html>