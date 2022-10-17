<?php
    // 不提示错误信息
    error_reporting(0);
    
    // 接受表单数据 (Function)
    function formInfo () {
        $webUrl = $_POST['webUrl'];
        $webAuthenticationCode = $_POST['webAuthenticationCode'];
        $webTitleForm = $_POST['webTitleForm'];
        $webIntroduceForm = $_POST['webIntroduceForm'];
        $webUrlForm = $_POST['webUrlForm'];

        return array("webUrl" => $webUrl, "webAuthenticationCode" => $webAuthenticationCode, "webTitleForm" => $webTitleForm, "webIntroduceForm" => $webIntroduceForm, "webUrlForm" => $webUrlForm);
    }

    // 获取信息函数 (Function)
    function Curl ($URL) {
        $Curl = curl_init();
        // 设置获取地址
        curl_setopt($Curl, CURLOPT_URL, $URL);
        // 设置不直接显示数据
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
        // 设置不验证SSL
        curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        // 设置随机IP
        $suiJiIP = "222.222.".mt_rand(0, 254).".".mt_rand(0, 254);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:$suiJiIP", "CLIENT-IP:$suiJiIP"));

        // 设置多久关闭
        curl_setopt($Curl, CURLOPT_TIMEOUT_MS, 10000);

        // 保存数据
        $Result = curl_exec($Curl);

        // 保存参数信息
        $curlInfo = curl_getinfo($Curl);

        return ["Result" => $Result, "Info" => $curlInfo];
    }

    // 判断是否提交信息
    if (isset($_POST['webSubmit'])) {
        // 保存数据
        $formInfo = formInfo();

        // 判断是否有数据
        if ($formInfo['webTitleForm'] != null) {
            // 获取数据库数据
            $webDatabaseString = file_get_contents('../database/webInfo/webinfo.yiso');
            // 分析总数据
            $webDatabaseArray = explode("\r\n", $webDatabaseString);
            // 把数据循环解析
            for ($i = 0; $i < count($webDatabaseArray); $i ++) {
                // 把每一条的数据解析
                $webDatabaseArray_All = explode("////", $webDatabaseArray[$i]);
                $webDatabaseArray_All_webUrl = $webDatabaseArray_All[2];

                // 判断是否重复
                if ($formInfo['webUrlForm'] == $webDatabaseArray_All_webUrl."/") {
                    $webUrlAgainIf = true;
                } else if ($formInfo['webUrlForm'] == $webDatabaseArray_All_webUrl) {
                    $webUrlAgainIf = true;
                }
            }

            // 判断数据重复
            if ($webUrlAgainIf != true) {
                // 开启可写模式打开文件
                $file = fopen("../database/webInfo/webinfo.yiso", "w");
                // 写入内容
                $file_fwrite = fwrite($file, $webDatabaseString."\r\n".$formInfo['webTitleForm']."////".$formInfo['webIntroduceForm']."////".$formInfo['webUrlForm']."////"."null"."////"."0"."////"."0"."////".date('Y/m/d H:i:s')."////"."null"."////"."null"."////"."null"."////"."null");
                echo "<script>alert('提交成功');</script>";
                fclose($file);
            } else {
                echo "<script>console.log('提交收录: error (已经收录!)');</script>";
                echo "<script>alert('已经收录');</script>";
            }
        }
    }

    // 判断是否获取信息
    if (isset($_POST['webGetInfo'])) {
        // 保存数据
        $formInfo = formInfo();

        // 判断验证码是否正确
        if ($formInfo['webAuthenticationCode'] == $_COOKIE['yanZhengMa']) {
            echo "<script>console.log('验证码正确');</script>";
            
            // 获取数据
            $resultCurl = Curl($formInfo['webUrl']);
            $resultCurl_Info = $resultCurl['Info'];

            // 判断是否获取成功 - 判断是否有重定向
            if ($resultCurl['Info']['redirect_url'] == '') {
                echo "<script>console.log('已获取数据');</script>";
                // var_dump($resultCurl['Result']);

                // 过滤数据 - 保存需要的数据
                $resultStrip_tags = strip_tags($resultCurl['Result'], "<head><meta><title><p><span>");
                // 过滤数据 - 网站信息
                $webIntroduceInfoStrip_tags = strip_tags($resultCurl['Result']);
            } else if ($resultCurl['Info']['redirect_url'] != '') {
                $resultCurl = Curl($resultCurl['Info']['redirect_url']);
                if ($resultCurl['Info']['redirect_url'] != '') {
                    $resultCurl = Curl($resultCurl['Info']['redirect_url']);
                    // 过滤数据 - 保存需要的数据
                    $resultStrip_tags = strip_tags($resultCurl['Result'], "<head><meta><title><p><span>");
                    // 过滤数据 - 网站信息
                    $webIntroduceInfoStrip_tags = strip_tags($resultCurl['Result']);
                    // var_dump($resultCurl);
                } else {
                    // 过滤数据 - 保存需要的数据
                    $resultStrip_tags = strip_tags($resultCurl['Result'], "<head><meta><title><p><span>");
                    // 过滤数据 - 网站信息
                    $webIntroduceInfoStrip_tags = strip_tags($resultCurl['Result']);
                    // var_dump($resultCurl);
                }
            }
        } else {
            echo "<script>alert('验证码错误');</script>";
        }
        // echo "<script>alert('".$_COOKIE['yanZhengMa']."');</script>";
        // echo "<script>alert('".$formInfo['webAuthenticationCode']."');</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一搜 - 向 Yiso 提交收录_自动提交</title>

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

        .padding {
            padding: 10px;
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
            <span>请填写 URL 结构 (http协议/https协议 + 域名)</span>
            <span>提交收录前请获取数据，提交收录不需要填写验证码<br>1. 先填写域名地址再填写验证码，获取信息<br>2. 获取完信息请检查是否有误，然后提交收录<br>如果验证码错误，请刷新页面 (获取信息前请先刷新页面，验证码有效时间 30s)</span>
            <form action="./automation.php" method="post">
                <input type="text" placeholder="域名地址" name="webUrl">
                <a href="./automation.php">刷新页面</a>
                <input type="text" placeholder="验证码" name="webAuthenticationCode">
                <button name="webGetInfo">获取信息</button>
                <img src="./webAuthenticationCode.php" alt="">
            </form>

            <span>推荐使用自动收录</span>
            <span>添加一行代码就可以实现全站自动收录</span>
            <span class="code">&lt;script async type="text/javascript" src="https://s.xlj0.com/s/included/js/automationemploy.js"&gt;&lt;/script&gt;</span>
            <style>
                .code {
                    background-color: #242424;
                    box-shadow: 0 2px 10px #dddddd;
                    border-radius: 20px;
                    padding: 10px;
                    display: block;
                    width: 90%;
                    margin: 0 auto;
                    color: #ffffff;
                    overflow: auto;
                }
            </style>
            <div class="padding">

            </div>
        </div>

        <span>确认信息</span>
        <div>
            <span class="webTitle">请先获取信息</span>
            <span class="webIntroduce">请先获取信息</span>
            <span class="webUrl"><?php if ($formInfo['webUrl'] != null) {echo "网站地址: ".$formInfo['webUrl'];} ?></span>
        </div>

        <div>
            <span></span>
            <form action="./automation.php" method="post" class="infoForm">
                <input type="text" placeholder="网站标题" name="webTitleForm" id="webTitleForm">
                <input type="text" placeholder="网站简介" name="webIntroduceForm" id="webIntroduceForm">
                <input type="text" placeholder="网站地址" name="webUrlForm" id="webUrlForm" value="<?php if ($formInfo['webUrl'] != null) {if (strpos($formInfo['webUrl'], 'http') === 0) {echo $formInfo['webUrl'];} else {echo 'http://'.$formInfo['webUrl'];}} ?>">
                <div>

                </div>
                <button name="webSubmit" class="block">提交数据</button>
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
            font-size: 10px;
        }

        .helpInfo > div > form > a {
            border: none;
            background-color: transparent;
            padding: 10px;
            background-color: #3baaff;
            margin-top: 2px;
            color: #ffffff;
            font-size: 10px;
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

        .block {
            display: block;
            margin: 10px auto 0 auto !important;
        }

        .resultStrip_tags {
            display: none;
        }

        .infoForm {
            display: none;
        }
    </style>

    <div class="resultStrip_tags">
        <?php
            // 输出数据
            if ($resultStrip_tags != null) {
                echo '<div id="resultStrip_tags" style="display: none;">'.$resultStrip_tags.'</div>';
                echo '<div id="webIntroduceInfoStrip_tags" style="display: none;">'.$webIntroduceInfoStrip_tags.'</div>';
            }
        ?>

        <script>
            // 绑定标签
            var resultStrip_tags = document.getElementById('resultStrip_tags');
            var webIntroduceInfoStrip_tags = document.getElementById('webIntroduceInfoStrip_tags');
            // 判断数据是否存在
            if (resultStrip_tags.innerHTML != null) {
                // 绑定展示信息标签
                var webTitleShow = document.getElementsByClassName('webTitle')[0];
                var webIntroduceShow = document.getElementsByClassName('webIntroduce')[0];
                var webUrlShow = document.getElementsByClassName('webUrl')[0];

                var webTitleForm = document.getElementById('webTitleForm');
                var webIntroduceForm = document.getElementById('webIntroduceForm');
                var webUrlForm = document.getElementById('webUrlForm');

                // 获取网页标题信息
                var webTitle = document.getElementsByTagName('title')[1].innerText;
                var webIntroduce = webIntroduceInfoStrip_tags.innerText;

                // 过滤数据
                var newWebIntroduce = webIntroduce.replace(/(^\s*)|(\s*$)/g,"");
                var resultWebIntroduce = newWebIntroduce.replace(/[\r\n]/g,"");
                
                // 设置信息
                webTitleShow.innerText = '网站标题: ' + webTitle;
                webIntroduceShow.innerText = '网站简介: ' + resultWebIntroduce.substring(0, 200);

                webTitleForm.value = webTitle;
                webIntroduceForm.value = webIntroduceShow.innerText.substring(6);

                // 显示信息
                document.getElementsByClassName('infoForm')[0].style.display = 'block';
            }
        </script>
    </div>

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