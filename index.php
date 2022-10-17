<?php
    // 不提示错误信息
    error_reporting(0);

    // 判断是否进行安全验证 - 防CC
    $verification = verificationForm();

    $userIf = null;
    if ($_COOKIE['verification'] == null) {
        header('Location: ./index.html');
        $userIf = null;
    }

    function verificationForm () {
        if ($_POST['verificationCode'] != null) {
            setcookie("verification", "true", 0);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一搜 - 一搜就知道</title>

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
    </style>

    <!-- Yiso 开发者: XLJ (独立完成开发) -->
    <!-- XLJ: Yiso 就像是我一手带大的孩子! 我爱它 -->

    <!-- 引入 CSS 文件 -->
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <header id="Header">
        <div class="headerRight">
            <span class="headerInfo"><a href="./index.php">首页</a></span>
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

    <div class="Logo">
        <img src="./img/logo.png" alt="">
    </div>

    <div class="searchInfo">
        <form action="./s/index.php" method="get" class="searchForm">
            <input type="text" placeholder="一搜就有，一搜就知道" class="searchInput border-radius" name="searchInput">
            <button type="submit" class="searchButton border-radius" name="searchButton">搜索</button>
        </form>
    </div>

    <!-- 功能导航 -->
    <div class="layout padding box-shadow border-radius">
        <div class="flex overflow-auto">
            <a href="./tool/md5.php"><span>MD5生成</span></a>
            <a href="./tool/ym.php"><span>获取网页源码</span></a>
            <a href="./tool/ba.php"><span>查询备案</span></a>
        </div>
    </div>

    <div class="padding">

    </div>

    <!-- 搜索后加载动画 -->
    <script>
        // 绑定标签
        var searchButton = document.getElementsByClassName('searchButton')[0];
        var loadingAnimation = document.getElementsByClassName('loadingAnimation')[0];
        // 显示加载动画
        searchButton.onclick = function () {
            // 设置显示
            loadingAnimation.style.display = 'block';
        }
    </script>

    <div class="recentlyEmploy">
        <span>最近收录</span>
        <div class="recentlyEmployRight">
            <span>向Yiso 提交网站，网页收录</span>
            <?php
                if ($_COOKIE['verification'] == true) {
                    // 解析最近收录内容
                    $file = fopen('./s/database/webInfo/webinfo.yiso', 'r');
                    $array = array();
                    while (($Buffer = fgets($file, 10240)) !== false) {
                        $array[] = $Buffer;
                        $return = true;
                    }

                    fclose($file);
                
                    if ($return == true) {
                        $newArray = array_reverse($array);
                        for ($i = 0; $i < 100; $i ++) {
                            // 解析每一条数据
                            $webArray = explode("////", $newArray[$i]);
                            echo "<span>".htmlToString($webArray[1])."</span>";
                        }

                        unset($Buffer);
                        unset($array);
                        unset($newArray);
                    }
                }
            ?>
        </div>
        <div class="recentlyEmployLeft">
            <span><a href="./s/included/automation.php">Yiso 收录提交</a> <svg t="1652071822127" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1928" width="200" height="200"><path d="M445.7472 959.0784a66.88768 66.88768 0 0 1-99.90144-26.76736 113.74592 113.74592 0 0 0-114.76992-66.2528 66.88768 66.88768 0 0 1-73.1136-73.13408 113.74592 113.74592 0 0 0-66.27328-114.76992 66.88768 66.88768 0 0 1-26.76736-99.90144 113.74592 113.74592 0 0 0 0-132.5056 66.88768 66.88768 0 0 1 26.76736-99.90144 113.74592 113.74592 0 0 0 66.2528-114.76992 66.88768 66.88768 0 0 1 73.13408-73.1136 113.74592 113.74592 0 0 0 114.76992-66.27328 66.88768 66.88768 0 0 1 99.90144-26.76736 113.74592 113.74592 0 0 0 132.5056 0 66.88768 66.88768 0 0 1 99.90144 26.76736 113.74592 113.74592 0 0 0 114.76992 66.2528 66.88768 66.88768 0 0 1 73.1136 73.13408 113.74592 113.74592 0 0 0 66.27328 114.76992 66.88768 66.88768 0 0 1 26.76736 99.90144 113.74592 113.74592 0 0 0 0 132.5056 66.88768 66.88768 0 0 1-26.76736 99.90144 113.74592 113.74592 0 0 0-66.2528 114.76992 66.88768 66.88768 0 0 1-73.13408 73.1136 113.74592 113.74592 0 0 0-114.76992 66.27328 66.88768 66.88768 0 0 1-99.90144 26.76736 113.74592 113.74592 0 0 0-132.5056 0z" fill="#d81e06" p-id="1929" data-spm-anchor-id="a313x.7781069.0.i0" class=""></path><path d="M416.58368 368.64v12.75904c-3.3792 0-6.63552 0.8192-9.78944 2.47808-3.13344 1.65888-4.7104 4.85376-4.7104 9.58464 0 5.20192 2.048 11.81696 6.16448 19.8656l6.79936 13.45536 8.06912 16.30208 92.8768 195.01056 90.68544-192.16384c4.64896-9.8304 9.05216-18.8416 13.23008-27.01312l3.09248-5.95968c5.07904-9.68704 7.61856-16.42496 7.61856-20.21376 0-6.9632-5.75488-10.73152-17.3056-11.264l-3.01056-0.08192V368.64H737.28v12.75904c-9.66656 0-16.6912 3.44064-21.03296 10.28096a172.032 172.032 0 0 0-8.13056 13.96736l-133.67296 287.45728A40.96 40.96 0 0 1 537.31328 716.8h-46.42816a40.96 40.96 0 0 1-37.0688-23.53152l-138.07616-293.43744a23.77728 23.77728 0 0 0-10.15808-11.34592 85.66784 85.66784 0 0 0-14.90944-5.89824L286.72 381.39904V368.64h129.86368z" fill="#ffffff" p-id="1930" data-spm-anchor-id="a313x.7781069.0.i1" class="selected"></path></svg></span>
            <?php
                if ($_COOKIE['verification'] == true) {
                    // 解析最近收录内容
                    $file = fopen('./s/database/webInfo/webinfo.yiso', 'r');
                    $array = array();
                    while (($Buffer = fgets($file, 10240)) !== false) {
                        $array[] = $Buffer;
                        $return = true;
                    }

                    fclose($file);

                    if ($return == true) {
                        $newArray = array_reverse($array);
                        for ($i = 0; $i < 100; $i ++) {
                            // 解析每一条数据
                            $webArray = explode("////", $newArray[$i]);
                            // var_dump($webArray);

                            // 判断是否有认证信息
                            if ($webArray[5] == 1) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.htmlToString($webArray[0]).'</a><svg t="1652095384687" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1928" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1296db" p-id="1929" data-spm-anchor-id="a313x.7781069.0.i0" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1296db" p-id="1930" data-spm-anchor-id="a313x.7781069.0.i1" class="selected"></path></svg></span>';
                            } else if ($webArray[5] == 2) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.htmlToString($webArray[0]).'</a><svg t="1652096073147" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3092" data-spm-anchor-id="a313x.7781069.0.i16" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1afa29" p-id="3093" data-spm-anchor-id="a313x.7781069.0.i17" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1afa29" p-id="3094" data-spm-anchor-id="a313x.7781069.0.i15" class="selected"></path></svg></span>';
                            } else if ($webArray[5] == 3) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.htmlToString($webArray[0]).'</a><svg t="1652096347930" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5614" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#000000" p-id="5615" data-spm-anchor-id="a313x.7781069.0.i33" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#000000" p-id="5616" data-spm-anchor-id="a313x.7781069.0.i32" class="selected"></path></svg></span>';
                            } else if ($webArray[5] == 4) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.htmlToString($webArray[0]).'</a><svg t="1652095867061" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2212" data-spm-anchor-id="a313x.7781069.0.i7" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#d81e06" p-id="2213" data-spm-anchor-id="a313x.7781069.0.i5" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#d81e06" p-id="2214" data-spm-anchor-id="a313x.7781069.0.i6" class="selected"></path></svg></span>';
                            } else {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.htmlToString($webArray[0]).'</a></span>';
                            }
                        }

                        unset($Buffer);
                        unset($array);
                        unset($newArray);
                    }
                }
                
                // 把HTML代码转换成字符串 (代码是在网上找的)
                function htmlToString($content){								//定义自定义函数的名称
                    $content=htmlspecialchars($content);                //转换文本中的特殊字符
                    $content=str_ireplace(chr(13),"<br>",$content);		//替换文本中的换行符
                    $content=str_ireplace(chr(32)," ",$content);		//替换文本中的 
                    $content=str_ireplace("[_[","<",$content);			//替换文本中的小于号
                    $content=str_ireplace(")_)",">",$content);			//替换文本中的大于号
                    $content=str_ireplace("|_|"," ",$content);				//替换文本中的空格
                    return trim($content);								//删除文本中首尾的空格
                }
            ?>

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
        </div>
    </div>

    <div class="ipInfo">
        <?php
            if ($_COOKIE['verification'] == true) {
                // 获取IP数据库
                $ipInfoDatabase = file_get_contents('./s/database/ipInfo/ipinfo.yiso');
                // 判断日期是否属于当天统计 - 统计IP数据库里的时间不等于服务器当前时间的话
                // 解析数据
                $ipInfoArray = explode("\r\n", $ipInfoDatabase);
                $ipInfoArrayAll = explode("////", $ipInfoArray[0]);
            
                // 开始判断
                $date = date('Y/m/d');
                if ($ipInfoArrayAll[0] == $date) {
                    // 写入数据
                    $file = fopen('./s/database/ipInfo/ipinfo.yiso', 'w');
                    fwrite($file, $ipInfoDatabase."\r\n".date('Y/m/d')."////".$_SERVER['HTTP_X_FORWARDED_FOR']."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null");
                    fclose($file);

                    // 解析有多少条数据
                    $ipInfoArrayLength = null;
                    for ($i = 0; $i < count($ipInfoArray); $i ++) {
                        $ipInfoArrayLength = $i;
                    }
                } else {
                    // 统计的不是当天的数据 - 开始清理数据
                    // 写入数据
                    $file = fopen('./s/database/ipInfo/ipinfo.yiso', 'w');
                    fwrite($file, date('Y/m/d')."////".$_SERVER['HTTP_X_FORWARDED_FOR']."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null"."////"."null");
                }

                // 随机数
                $rand = mt_rand(0, 5);
            }
        ?>

        <span class="block weight colorRed padding">通知!!! 因算法升级，Yiso部分信息不显示，请加群反馈 Qqun: 567335541</span>

        <span class="block weight">因为有你的参与, Yiso 变得更有意义</span>
        <span class="block">Yiso 给站长开发者一个收录归宿</span>
        <span class="block">也给使用 Yiso 搜索的您一个答案</span>
        <span id="ipInfo" class="padding inline-block">今天 访问量 : <?php if ($ipInfoArrayLength != null) {echo $ipInfoArrayLength + $rand;} else {echo "加载中...";} ?> 您是第: <?php if ($ipInfoArrayLength != null) {echo $ipInfoArrayLength - $rand;} else {echo "加载中...";} ?> 现在时间: <span id="date">加载中...</span></span>
        
        <script>
            // 获取当前时间
            function dateTime () {
                var date = new Date();
                var year = date.getFullYear();
                var month = date.getMonth() + 1;
                var day = date.getDate();
                var hours = date.getHours();
                var minute = date.getMinutes();
                var second = date.getSeconds();

                var nowTime = year + "/" + month + "/" + day + " " + hours + ":" + minute + ":" + second;
                var time = document.getElementById('date');
                time.innerText = nowTime;
            }

            dateTime();
            setInterval(() => {
                dateTime();
            }, 1000);
        </script>

        <div>
            <span class="userIpInfo"><?php if ($_SERVER != null) {echo "您的IP: ".$_SERVER['HTTP_X_FORWARDED_FOR'];} ?></span>
        </div>
    </div>

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
    <script src="./js/canvasText.js"></script>
</body>
</html>