<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yiso - IP控制台</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,body {
            height: 100%;
        }

        body {
            font-size: 15px;
            font-weight: 200;
        }

        .select {
            user-select: none;
        }

        .pointer {
            cursor: pointer;
        }

        .radius {
            border-radius: 2px;
        }

        .button {
            padding: 5px 5px;
            background-color: #ffffff;
            color: #000000;
        }
        
        .floatRight {
            float: right;
        }

        .floatLeft {
            float: left;
        }

        .paddingLeftRight {
            padding: 0 10% !important;
        }
    </style>

    <link rel="stylesheet" href="../../css/layui/css/layui.css">
</head>
<body>

<style>
    .lineLayout {
        font-size: 15px;
        font-weight: 200;
        width: 60%;
        margin: 0 auto;
        text-align: right;
        padding: 10px;
        overflow: auto;
    }
    
    .lineLayout > span {
        white-space: nowrap;
        overflow: auto;
    }

    .blockLayout {
        width: 60%;
        margin: 0 auto;
    }

    .margin-top {
        margin-top: 10px;
    }

    .box-shadow {
        box-shadow: 0 2px 10px #dddddd;
    }

    .relative {
        position: relative;
    }

    .right {
        position: absolute;
        width: 45%;
        text-align: center;
        right: 5%;
        padding: 10px 0;
        /* overflow: auto; */
    }

    .right span {
        display: block;
        padding: 10px;
        overflow: auto;
    }

    .left {
        width: 45%;
        text-align: center;
        margin-left: 5%;
        padding: 10px 0;
        /* overflow: auto; */
    }

    .left span {
        display: block;
        padding: 10px;
        overflow: auto;
    }

    .margin-bottom {
        margin-bottom: 10px;
    }

    .padding {
        padding: 10px;
    }

    .align-center {
        text-align: center !important;
    }

    .block {
        display: block;
    }

    .inline-block {
        display: inline-block;
    }

    .inline {
        display: inline;
    }

    .none {
        display: none;
    }

    .paddingTopBottom {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    @media screen and (min-width: 900px) {
        .right {
            position: absolute;
            width: 45%;
            text-align: center;
            right: 5%;
            padding: 10px 0;
            /* overflow: auto; */
        }

        .right span {
            display: block;
            padding: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .left {
            width: 45%;
            text-align: center;
            margin-left: 5%;
            padding: 10px 0;
            /* overflow: auto; */
        }

        .left span {
            display: block;
            padding: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>

<ul class="layui-nav layui-bg-blue paddingLeftRight" lay-bar="disabled">
    <li class="layui-nav-item"><a href="../../index.php">Yiso</a></li>
    <li class="layui-nav-item"><a href="./index.php">首页</a></li>
    <li class="layui-nav-item select pointer floatRight">欢迎您 <span class="button radius">退出</span></li>
</ul>

<div class="lineLayout">
    <span>您的IP: <?php echo $_SERVER['HTTP_X_FORWARDED_FOR']; ?></span>
</div>

<div class="blockLayout">
    <span>今日访问量: <?php echo $ipView = ipView(); ?> (因数据量问题，仅计算一天的IP)</span>
</div>

<div class="blockLayout margin-top box-shadow relative margin-bottom">
    <div class="lineLayout">
        <span class="padding block">仅展示最近 100 条IP(部分IP由Yiso进行进一步伪造，防止安全隐患)</span>
    </div>
    <div class="right">
        <span>日期</span>
        
        <?php
            $ipShow = ipShow(0);
        ?>
    </div>

    <div class="left">
        <span>IP</span>

        <?php
            $ipShow = ipShow(1);
        ?>
    </div>
</div>

<div class="blockLayout padding">
    
</div>

<script>
    /* 方法集 */
    // 退出登录
    function outLogin () {
        document.location.href = './index.php?outLogin=true';
    }

    // 监听事件
    function clickListener () {
        var button = document.getElementsByClassName('button')[0];
        button.onclick = function () {
            outLogin();
        };
    }

    // 执行顺序
    function start () {
        clickListener(); // 监听事件
    }
    /* 方法集 */

    /* -------------------- */
    
    // 初始化
    start();
</script>

<script src="../../css/layui/layui.js"></script>
</body>
</html>