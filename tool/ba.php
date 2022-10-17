<?php
    // 不提示错误信息
    error_reporting(0);

    // 判断是否进行安全验证 - 防CC
    $verification = verificationForm();

    $userIf = null;
    if ($_COOKIE['verification'] == null) {
        header('Location: ../index.html');
        $userIf = null;
    }

    function verificationForm () {
        if ($_POST['verificationCode'] != null) {
            setcookie("verification", "true", 0);
        }
    }

    /* 方法 */
    // 获取网页源码
    // CURL
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

    // 查询备案
    function selectDoMainName () {
        if ($_POST['domainname'] != null) {
            $curl = Curl('https://icp.chinaz.com/'.$_POST['domainname']);
            // var_dump($curl);
            if ($curl['Info']['redirect_url'] != '') {
                // var_dump($curl);
                $curl = Curl('https://icp.chinaz.com/'.$_POST['domainname']);
                // var_dump($curl);
                $tags = strip_tags($curl['Result'], "<ul><li><p><strong><a><font>");
                return ['result' => $curl['Result'], 'info' => $curl['Info'], 'tags' => $tags];
            } else {
                $tags = strip_tags($curl['Result'], "<ul><li><p><strong><a><font>");
                return ['result' => $curl['Result'], 'info' => $curl['Info'], 'tags' => $tags];
            }
        }
    }

    function htmlToStringFuncation ($html) {
        $html = htmlspecialchars($html);
        $html = str_ireplace(chr(13), "<br>", $html);
        $html = str_ireplace(chr(32), " ", $html);
        $html = str_ireplace("[_[", "<", $html);
        $html = str_ireplace(")_)", ">", $html);
        $html = str_ireplace("|_|"," ", $html);
        return trim($html);
    }
    /* 方法 */

    /* 执行 */
    $selectDoMainName = selectDoMainName();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一搜 - 域名备案查询</title>

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
            -webkit-tap-highlight-color: transparent;
        }

        .layout {
            width: 70%;
            margin: 0 auto;
        }
        
        .padding {
            padding: 10px;
        }

        .margin {
            margin: 10px;
        }

        .flex {
            display: flex;
        }

        .flex a {
            text-align: center;
            flex-grow: 1;
            white-space: nowrap;
            font-size: 15px;
            font-weight: 200;
            padding: 10px;
            display: inline-block;
            box-shadow: 0 2px 10px #dddddd;
            background-color: #004981;
            color: #ffffff;
            margin: 0 2px;
            border-radius: 20px;
        }

        .overflow-auto {
            overflow: auto;
        }

        .height-50px {
            height: 50px;
        }

        .box-shadow {
            box-shadow: 0 2px 10px #dddddd;
        }

        .border-radius {
            border-radius: 20px;
        }

        .text-align-center {
            text-align: center;
        }

        .margin {
            margin: 10px;
        }

        .margin-top-bottom {
            margin: 10px auto;
        }

        div.centerDiv {
            width: 80%;
            margin: 10px auto;
        }

        input.textInfo {
            border: none;
            background-color: #00000000;
            border: 1px solid #acacac;
            border-radius: 2px;
            color: #3a3a3a;
            padding: 10px;
            font-size: 18px;
            max-width: 90%;
        }

        button.Button {
            background-color: #58bcff;
            padding: 10px;
            color: #ffffff;
            border-radius: 4px;
            user-select: none;
            cursor: pointer;
            border: 1px solid #58bcff;
            display: inline-block;
            margin-top: 1em;
        }

        /* 结果显示 */
        .resultInfo {
            /* background-color: #686868; */
            padding: 4px 1%;
            color: #454545;
            /* display: inline-block; */
            width: 80%;
            font-size: 20px;
            cursor: pointer;
            line-height: 1.5em;
        }

        /* 结果显示 Style */
        .resultShowStyle {
            margin-top: 0.2em;
            display: inline-block;
        }

        .resultShowStyleSpan {
            background-color: #dddddd;
            margin-top: 0.2em;
            transition: all 100ms linear;
        }
        .resultShowStyleSpan:hover {
            background-color: #f0f0f0;
            transition: all 100ms linear;
        }

        /* API容器 */
        div.apiDiv {
            /* background-color: #58bcff !important; */
            border-radius: 2px;
            /* color: #ffffff; */
            width: 70%;
            word-wrap: break-word;
            word-break: break-all;
            margin: 0 auto;
        }

        /* 选项按钮 */
        .aButton {
            color: #000000;
            text-decoration: none;
            font-size: 0.9em;
            padding: 4px 6px;
            border: 1px solid #dddddd;
            border-radius: 2px;
        }

        .colorSuccess {
            background-color: #000000;
            color: #ffffff;
            font-size: 0.9em;
            border-radius: 4px;
            display: none;
        }

        .display-none {
            display: none;
        }

        .border-radius {
            border-radius: 20px;
        }

        @media screen and (max-width: 900px) {
            .footer {
                background-color: #ffffff80;
            }
        }

        @media screen and (min-width: 900px) {
            .footer {
                background-color: #ffffff80;
            }
        }
    </style>

    <!-- Yiso 开发者: XLJ (独立完成开发) -->
    <!-- XLJ: Yiso 就像是我一手带大的孩子! 我爱它 -->

    <!-- 引入 CSS 文件 -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header id="Header">
        <div class="headerRight">
            <span class="headerInfo"><a href="../index.php">首页</a></span>
            <span class="headerInfo"><a href="https://xlj0.com" target="_Blank">作者</a></span>
        </div>

        <div class="headerLeft">
            <span class="headerTitle">Yiso</span>
        </div>
    </header>

    <div class="Filter">
        
    </div>

    <!-- 搜索加载动画 -->
    <div class="loadingAnimation">
        <div class="loadingAnimationBackground">
            <span>Yiso</span>
        </div>
    </div>

    <style>
        .loadingAnimation {
            background-color: #ffffff;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            z-index: 100;
            display: none;
        }
        
        .loadingAnimation > div {
            width: 100%;
            height: 200px;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            margin-top: -100px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .loadingAnimation > div > span {
            line-height: 200px;
            font-size: 4em;
            font-weight: 400;
            user-select: none;
        }
    </style>

    <div class="padding-top">
        <!-- Yiso -->
        <div>
            
        </div>
    </div>

    <div class="layout text-align-center">
        <span>域名备案查询</span>
    </div>

    <div class="searchInfo">
        <form action="./ba.php" method="post">
            <input type="text" placeholder="域名" class="searchInput" name="domainname" id="info">
            <button class="searchButton" name="searchButton">查询</button>
        </form>
    </div>

    <div class="display-none">
        <?php
            if ($selectDoMainName['tags'] != null) {
                echo $selectDoMainName['tags'];
            }
        ?>
    </div>

    <input type="text" id="copy_Input" class="display-none">

    <div class="padding layout text-align-center overflow-auto margin-top-bottom">
        <span id="md5Info"></span>
    </div>

    <div style="width: 70%; margin: 0 auto; padding: 10px; margin-bottom: 20px; background-color: #f5f5f5;" id="xinXiFenXi">
        <span style="border-bottom: 1px solid #dddddd;">信息分析</span>
        <p style="margin-top: 10px; font-size: 0.8em; color: #a03434;" id="nameInfoText">...</p>
        <p style="margin-top: 10px; font-size: 0.8em; color: #666;" id="natureInfoText">...</p>
        <p style="margin-top: 10px; font-size: 0.8em; color: #666;" id="pageNameInfoText" class="display-none">...</p>
        <p style="margin-top: 10px; font-size: 0.8em; color: #666;" id="doMainNameInfoText" class="display-none">...</p>
        <p style="margin-top: 10px; font-size: 0.8em; color: #666;" id="timeInfoText" class="display-none">...</p>

        <script>
            var infoTime = document.getElementsByClassName('clearfix');
            var infoName = document.getElementsByClassName('bg-gray clearfix');
            var infoNature = document.getElementsByClassName('fl fwnone');
            var infoPageName = document.getElementsByClassName('clearfix');
            var infoDoMainName = document.getElementsByClassName('Wzno');
            
            if (info != null) {
                nameInfoText.innerText = '备案单位名称: ' + infoName[0].getElementsByTagName('p')[0].getElementsByTagName('a')[0].innerText;
                natureInfoText.innerText = '备案单位性质: ' + infoNature[0].innerText;
                pageNameInfoText.style.display = 'block';
                pageNameInfoText.innerText = '备案名称: ' + infoPageName[5].getElementsByTagName('p')[0].innerText;
                doMainNameInfoText.style.display = 'block';
                doMainNameInfoText.innerText = '备案域名: ' + infoDoMainName[0].innerText;
                timeInfoText.style.display = 'block';
                timeInfoText.innerText = '备案时间: ' + infoTime[8].getElementsByTagName('p')[0].innerText;
            }
        </script>
    </div>

    <div style="width: 70%; margin: 0 auto; text-align: right;">
        <span style="cursor: pointer; user-select: none; padding: 10px; box-shadow: 0 2px 4px #dddddd; display: none; position: relative; z-index: 10; border-radius: 20px;" id="copy_Button">全部复制</span>
    </div>

    <div class="centerDiv resultInfo" style="width: 70%; transition: all 200ms linear; background-color: #615e5e; color: #ffffff; max-height: 400px; overflow: scroll; font-size: 0.8em; display: none; padding: 10px; border-radius: 20px; box-shadow: 0 2px 10px #000000;" id="Main">
        <span id="yuanMa">
            <?php
                if ($getCode['result'] != null || $newResult['result'] != null) {
                    echo "<script>
                        Main.style.display = 'block';

                        copy_Button.style.display = 'inline';

                        xinXiFenXi.style.display = 'block';

                        setTimeout(function(){
                            Main.style.width = '64%';
                            Main.style.transition = 'all 200ms linear';
                        }, 200);

                        setTimeout(function(){
                            Main.style.width = '70%';
                            Main.style.transition = 'all 200ms linear';
                        }, 500);
                    </script>";

                    if ($getCode['result'] != null) {
                        echo htmlToStringFuncation($getCode['result']);
                    }
                }
            ?>
        </span>

        <script>
            copy_Button.onclick = function() {
                copy_Input.value = yuanMa.innerText;
                copy_Input.style.display = 'inline-block';
                copy_Input.select();
                if (document.execCommand('copy')) {
                    copy_Input.style.display = 'none';
                    copy_Input.value = '';
                    layer.msg('复制成功');
                }
            }
        </script>
    </div>

    <!-- 功能导航 -->
    <div class="layout padding box-shadow border-radius">
        <div class="flex overflow-auto">
            <a href="./md5.php"><span>MD5生成</span></a>
            <a href="./ym.php"><span>获取网页源码</span></a>
            <a href="./ba.php"><span>查询备案</span></a>
        </div>
    </div>

    <div class="padding">
        
    </div>

    <!-- 搜索后加载动画 -->
    <script>
        // 绑定标签
        var searchButton = document.getElementsByClassName('searchButton')[0];
        var loadingAnimation = document.getElementsByClassName('loadingAnimation')[0];
        var info = document.getElementById('info');
        var md5Info = document.getElementById('md5Info');
        // 显示加载动画
        searchButton.onclick = function () {
            // 设置显示
            loadingAnimation.style.display = 'block';
        }
    </script>

    <style>
        .recentlyEmployLeft span a {
            font-size: 15px;
            display: inline-block;
            width: 50%;
        }

        .padding-bottom {
            padding-top: 100px;
        }

        .footer {
            position: fixed;
        }

        .recentlyEmployRight span {
            line-height: 20px;
        }

        .recentlyEmployLeft span {
            line-height: 20px;
        }

        .Logo {
            text-align: center;
        }

        .Logo img {
            width: 164.5px;
            height: 68px;
        }

        .ipInfo {
            width: 80%;
            margin: 20px auto;
        }

        .ipInfo {
            font-size: 15px;
            font-weight: 200;
            text-align: center;
        }

        .userIpInfo {
            display: none;
        }

        .block {
            display: block;
        }

        .weight {
            font-weight: 400;
        }

        .padding {
            padding: 10px;
        }

        .inline-block {
            display: inline-block;
        }

        .colorRed {
            color: #dc5050;
        }

        /* 当屏幕展示的内容小于 900px 时 */
        @media screen and (max-width: 900px) {
            .recentlyEmploy span {
                height: 30px !important;
            }
        }
                
        /* 当屏幕展示内容大于 900px 时 */
        @media screen and (min-width: 900px) {
            .recentlyEmployRight {
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .recentlyEmployRight span {
                overflow: hidden !important;
                text-overflow: ellipsis;
            }

            .recentlyEmployLeft span {
                overflow: hidden !important;
                text-overflow: ellipsis;
            }

            .recentlyEmploy span {
                height: 30px !important;
            }
        }
    </style>

    <div class="padding-bottom">

    </div>

    <div class="footer">
        <div>
            <span><a href="./help/index.html">使用须知</a></span>
            <span><a href="./help/responsibility.html">免责申明</a></span>
            <span><a href="https://beian.miit.gov.cn/#/Integrated/index">豫ICP备2021002284号-1</a></span>
            <span><a href="https://www.beian.gov.cn/portal/index"><img style="vertical-align: middle;" src="https://xlj0.com/usr/themes/line/img/gwbalogo.png">&nbsp;豫公网安公安局备案 41160202000364号</a></span>
        </div>
    </div>

    <!-- 引入 Js 文件 -->
    <script src="../js/canvasText.js"></script>
    <script src="../css/layui/layui.js"></script>
    <script>
        !function(n){"use strict";function d(n,t){var r=(65535&n)+(65535&t);return(n>>16)+(t>>16)+(r>>16)<<16|65535&r}function f(n,t,r,e,o,u){return d((u=d(d(t,n),d(e,u)))<<o|u>>>32-o,r)}function l(n,t,r,e,o,u,c){return f(t&r|~t&e,n,t,o,u,c)}function g(n,t,r,e,o,u,c){return f(t&e|r&~e,n,t,o,u,c)}function v(n,t,r,e,o,u,c){return f(t^r^e,n,t,o,u,c)}function m(n,t,r,e,o,u,c){return f(r^(t|~e),n,t,o,u,c)}function c(n,t){var r,e,o,u;n[t>>5]|=128<<t%32,n[14+(t+64>>>9<<4)]=t;for(var c=1732584193,f=-271733879,i=-1732584194,a=271733878,h=0;h<n.length;h+=16)c=l(r=c,e=f,o=i,u=a,n[h],7,-680876936),a=l(a,c,f,i,n[h+1],12,-389564586),i=l(i,a,c,f,n[h+2],17,606105819),f=l(f,i,a,c,n[h+3],22,-1044525330),c=l(c,f,i,a,n[h+4],7,-176418897),a=l(a,c,f,i,n[h+5],12,1200080426),i=l(i,a,c,f,n[h+6],17,-1473231341),f=l(f,i,a,c,n[h+7],22,-45705983),c=l(c,f,i,a,n[h+8],7,1770035416),a=l(a,c,f,i,n[h+9],12,-1958414417),i=l(i,a,c,f,n[h+10],17,-42063),f=l(f,i,a,c,n[h+11],22,-1990404162),c=l(c,f,i,a,n[h+12],7,1804603682),a=l(a,c,f,i,n[h+13],12,-40341101),i=l(i,a,c,f,n[h+14],17,-1502002290),c=g(c,f=l(f,i,a,c,n[h+15],22,1236535329),i,a,n[h+1],5,-165796510),a=g(a,c,f,i,n[h+6],9,-1069501632),i=g(i,a,c,f,n[h+11],14,643717713),f=g(f,i,a,c,n[h],20,-373897302),c=g(c,f,i,a,n[h+5],5,-701558691),a=g(a,c,f,i,n[h+10],9,38016083),i=g(i,a,c,f,n[h+15],14,-660478335),f=g(f,i,a,c,n[h+4],20,-405537848),c=g(c,f,i,a,n[h+9],5,568446438),a=g(a,c,f,i,n[h+14],9,-1019803690),i=g(i,a,c,f,n[h+3],14,-187363961),f=g(f,i,a,c,n[h+8],20,1163531501),c=g(c,f,i,a,n[h+13],5,-1444681467),a=g(a,c,f,i,n[h+2],9,-51403784),i=g(i,a,c,f,n[h+7],14,1735328473),c=v(c,f=g(f,i,a,c,n[h+12],20,-1926607734),i,a,n[h+5],4,-378558),a=v(a,c,f,i,n[h+8],11,-2022574463),i=v(i,a,c,f,n[h+11],16,1839030562),f=v(f,i,a,c,n[h+14],23,-35309556),c=v(c,f,i,a,n[h+1],4,-1530992060),a=v(a,c,f,i,n[h+4],11,1272893353),i=v(i,a,c,f,n[h+7],16,-155497632),f=v(f,i,a,c,n[h+10],23,-1094730640),c=v(c,f,i,a,n[h+13],4,681279174),a=v(a,c,f,i,n[h],11,-358537222),i=v(i,a,c,f,n[h+3],16,-722521979),f=v(f,i,a,c,n[h+6],23,76029189),c=v(c,f,i,a,n[h+9],4,-640364487),a=v(a,c,f,i,n[h+12],11,-421815835),i=v(i,a,c,f,n[h+15],16,530742520),c=m(c,f=v(f,i,a,c,n[h+2],23,-995338651),i,a,n[h],6,-198630844),a=m(a,c,f,i,n[h+7],10,1126891415),i=m(i,a,c,f,n[h+14],15,-1416354905),f=m(f,i,a,c,n[h+5],21,-57434055),c=m(c,f,i,a,n[h+12],6,1700485571),a=m(a,c,f,i,n[h+3],10,-1894986606),i=m(i,a,c,f,n[h+10],15,-1051523),f=m(f,i,a,c,n[h+1],21,-2054922799),c=m(c,f,i,a,n[h+8],6,1873313359),a=m(a,c,f,i,n[h+15],10,-30611744),i=m(i,a,c,f,n[h+6],15,-1560198380),f=m(f,i,a,c,n[h+13],21,1309151649),c=m(c,f,i,a,n[h+4],6,-145523070),a=m(a,c,f,i,n[h+11],10,-1120210379),i=m(i,a,c,f,n[h+2],15,718787259),f=m(f,i,a,c,n[h+9],21,-343485551),c=d(c,r),f=d(f,e),i=d(i,o),a=d(a,u);return[c,f,i,a]}function i(n){for(var t="",r=32*n.length,e=0;e<r;e+=8)t+=String.fromCharCode(n[e>>5]>>>e%32&255);return t}function a(n){var t=[];for(t[(n.length>>2)-1]=void 0,e=0;e<t.length;e+=1)t[e]=0;for(var r=8*n.length,e=0;e<r;e+=8)t[e>>5]|=(255&n.charCodeAt(e/8))<<e%32;return t}function e(n){for(var t,r="0123456789abcdef",e="",o=0;o<n.length;o+=1)t=n.charCodeAt(o),e+=r.charAt(t>>>4&15)+r.charAt(15&t);return e}function r(n){return unescape(encodeURIComponent(n))}function o(n){return i(c(a(n=r(n)),8*n.length))}function u(n,t){return function(n,t){var r,e=a(n),o=[],u=[];for(o[15]=u[15]=void 0,16<e.length&&(e=c(e,8*n.length)),r=0;r<16;r+=1)o[r]=909522486^e[r],u[r]=1549556828^e[r];return t=c(o.concat(a(t)),512+8*t.length),i(c(u.concat(t),640))}(r(n),r(t))}function t(n,t,r){return t?r?u(t,n):e(u(t,n)):r?o(n):e(o(n))}"function"==typeof define&&define.amd?define(function(){return t}):"object"==typeof module&&module.exports?module.exports=t:n.md5=t}(this);
//# sourceMappingURL=md5.min.js.map
    </script>
</body>
</html>