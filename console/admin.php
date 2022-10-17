<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yiso 控制台</title>

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

    <link rel="stylesheet" href="../css/layui/css/layui.css">
</head>
<body>

<ul class="layui-nav layui-bg-blue paddingLeftRight" lay-bar="disabled">
    <li class="layui-nav-item"><a href="./index.php">Yiso</a></li>
    <li class="layui-nav-item"><a href="./index.php">首页</a></li>
    <li class="layui-nav-item select pointer floatRight"><?php echo $_COOKIE['userName']; ?> <span class="button radius">退出</span></li>
</ul>

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

<script src="../css/layui/layui.js"></script>
</body>
</html>