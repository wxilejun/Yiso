<?php
    // 不提示错误信息
    error_reporting(0);
    
    // 接受表单数据
    function formInfo () {
        $webTitle = $_POST['webTitle'];
        $webIntroduce = $_POST['webIntroduce'];
        $webUrl = $_POST['webUrl'];

        return array("webTitle" => $webTitle, "webIntroduce" => $webIntroduce, "webUrl" => $webUrl);
    }

    // 判断是否提交信息
    if (isset($_POST['webSubmit'])) {
        // 保存数据
        $formInfo = formInfo();

        // 获取数据库数据
        $webDatabaseString = file_get_contents('../database/webInfo/webinfo.yiso');
        // 开启可写模式打开文件
        $file = fopen("../database/webInfo/webinfo.yiso", "w");
        // 写入内容
        $file_fwrite = fwrite($file, $webDatabaseString."\r\n".$formInfo['webTitle']."////".$formInfo['webIntroduce']."////".$formInfo['webUrl']."////".$formInfo['webAuthenticationCode']."////"."0"."////"."0"."////".date('Y/m/d H:i:s')."////"."null"."////"."null"."////"."null"."////"."null");
        echo "<script>alert('提交成功');</script>";
        fclose($file);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一搜 - 收录 - 后台</title>

    <!-- 初始化 -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,body {
            height: 100%;
        }
        
        body {
            font-size: 18px;
            position: relative;
        }

        a {
            color: #000000;
            text-decoration: none;
            font-size: 18px;
        }
    </style>

    <!-- 引入 CSS 文件 -->
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>
    <header id="Header">
        <div class="headerRight">
            <span class="headerInfo"><a href="../../index.php">首页</a></span>
            <span class="headerInfo"><a href="https://xlj0.com" target="_Blank">作者</a></span>
        </div>

        <div class="headerLeft">
            <span class="headerTitle">Yiso</span>
        </div>
    </header>

    <div class="Filter">
        
    </div>

    <div class="padding-top">
        <!-- Yiso -->
        <div>

        </div>
    </div>

    <div class="helpInfo">
        <span>提交收录</span>
        <div>
            <span>禁止提交违规信息以及反复提交，域名地址需要携带有 http/https 协议头</span>
            <span>文章地址可以直接把链接粘贴到域名地址</span>
            <form action="./admin.php" method="post">
                <input type="text" placeholder="收录名称" name="webTitle">
                <input type="text" placeholder="介绍信息" name="webIntroduce">
                <input type="text" placeholder="域名地址" name="webUrl">
                <button name="webSubmit">提交收录</button>
            </form>
        </div>
    </div>

    <div class="padding-bottom">

    </div>

    <style>
        .helpInfo {
            width: 80%;
            margin: 10px auto;
            padding: 20px;
            box-shadow: 0 2px 10px #dddddd;
        }

        .helpInfo > span {
            font-weight: 600;
        }

        .helpInfo > div > span {
            font-weight: 200;
            font-size: 15px;
            display: block;
            padding: 10px;
        }

        .helpInfo > div > span > a {
            font-size: 15px !important;
        }

        .padding-bottom {
            padding-bottom: 100px;
        }

        .footer {
            position: fixed;
        }
        
        .helpInfo > div {
            padding-top: 10px;
        }

        .helpInfo > div > form {
            text-align: center;
        }

        .helpInfo > div > form > button {
            border: none;
            background-color: transparent;
            padding: 10px;
            background-color: #3baaff;
            margin-top: 2px;
            color: #ffffff;
        }

        .helpInfo > div > form > input {
            background-color: transparent;
            border: none;
            padding: 10px;
            border: 1px solid #2480c7;
            margin-top: 2px;
            outline: none;
        }

        .helpInfo > div > form > img {
            display: block;
            margin: 10px auto;
            box-shadow: 0 2px 10px #2480c7;
            border-radius: 10px;
        }
    </style>

    <div class="footer">
        <div>
            <span><a href="./index.html">使用须知</a></span>
            <span><a href="./responsibility.html">免责申明</a></span>
            <span><a href="https://beian.miit.gov.cn/#/Integrated/index">豫ICP备2021002284号-1</a></span>
            <span><a href="https://www.beian.gov.cn/portal/index"><img style="vertical-align: middle;" src="https://xlj0.com/usr/themes/line/img/gwbalogo.png">&nbsp;豫公网安公安局备案 41160202000364号</a></span>
        </div>
    </div>

    <!-- 引入 Js 文件 -->
    <script src="../js/canvasText.js"></script>
</body>
</html>