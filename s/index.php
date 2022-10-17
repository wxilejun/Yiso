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

    // 把HTML代码转换成字符串 (代码是在网上找的)
    function htmlToString ($content){								//定义自定义函数的名称
        $content = htmlspecialchars($content);                //转换文本中的特殊字符
        $content = str_ireplace(chr(13),"<br>",$content);		//替换文本中的换行符
        $content = str_ireplace(chr(32)," ",$content);		//替换文本中的 
        $content = str_ireplace("[_[","<",$content);			//替换文本中的小于号
        $content = str_ireplace(")_)",">",$content);			//替换文本中的大于号
        $content = str_ireplace("|_|"," ",$content);				//替换文本中的空格
        return trim($content);								//删除文本中首尾的空格
    }

    /* search */
    // 配置搜索引擎数据库文件路径地址
    $webDatabasePath = "./database/webInfo/webinfo.yiso";
    // include('./html/search.php');
    
    // 网站标题
    function formInfo ($searchInfo) {
        if ($searchInfo != null) {
            // 设置搜索信息 - 搜索框
            // 设置网页标题信息 - 网页标题
            echo "<script>
                var searchInput = document.getElementsByClassName('searchInput')[0];
                searchInput.value = '".$searchInfo."';
                
                var pageTitle = document.getElementsByTagName('title')[0];
                pageTitle.innerText = '".$searchInfo." - 一搜';
            </script>";

            // 返回逻辑值
            $formInfoIf = true;
            return $formInfoIf;
        } else {
            // 返回逻辑值
            $formInfoIf = false;
            return $formInfoIf;
        }
    }

    // 判断是否有数据
    $searchInfo = $_GET['searchInput'];
    $formInfo = formInfo($searchInfo);
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
        }

        .border-radius {
            border-radius: 20px !important;
        }

        .color-blue {
            color: #1699fd;
        }
    </style>

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

    <div class="searchInfo">
        <form action="./index.php" method="get" class="searchForm">
            <input type="text" placeholder="一搜就有，一搜就知道" class="searchInput border-radius" name="searchInput">
            <button type="submit" class="searchButton border-radius" name="searchButton">搜索</button>
        </form>
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

    <div class="searchInfoNav">
        <form action="./index.php" method="get">
            <span>引索选项</span>
            <input type="text" name="searchInput" style="display: none;" value="<?php echo $searchInfo; ?>">
            <button class="searchNavSubmit" type="submit" name="searchNavOne" value="true">默认搜索</button>
        </form>
    </div>

    <!-- 搜索后加载动画 -->
    <script>
        // 绑定标签
        var searchNavSubmit = document.getElementsByClassName('searchNavSubmit')[0];
        // 显示加载动画
        searchNavSubmit.onclick = function () {
            // 设置显示
            loadingAnimation.style.display = 'block';
        }
    </script>

    <?php
        /* 引索选项 - 选择搜索内容的方式 */
        // 获取表单数据
        $searchNavOne = $_GET['searchNavOne'];
        // 判断是否点击了选项
        // $searchNavInfoIf - 是否搜索逻辑值
        $searchNavInfoIf = null;
        if (isset($searchNavOne)) {
            $searchNavInfoIf = true;
            $_GET['searchInput'] = $searchInfo;
        } else {
            $searchNavInfoIf = false;
        }
    ?>

    <style>
        .searchInfo {
            margin-top: 0;
            margin-top: 80px;
        }

        .searchInfoList > div > div {
            overflow: auto;
        }

        .searchInfoList > div > div span {
            white-space: nowrap;
        }

        .padding-top {
            padding-top: 100px;
        }

        .footer {
            position: fixed;
        }

        .searchInfoListTitle > a {
            font-size: 15px;
        }

        .recentlyEmployRight span {
            line-height: 20px;
        }

        .recentlyEmployLeft span {
            line-height: 20px;
        }

        .showMore {
            text-align: center;
            padding: 10px;
            border-radius: 0 !important;
            background-color: #ffcece;
            /* color: #ffffff; */
            font-size: 15px;
            display: none;
            user-select: none;
            cursor: pointer;
        }

        .showMore > form {
            margin: 0;
            padding: 0;
        }

        .showMore > form > span {
            margin: 0;
            padding: 0;
            font-weight: 500 !important;
        }

        .showMore > form > input {
            display: none;
        }

        a {
            -webkit-tap-highlight-color: transparent;
        }

        /* 当屏幕展示内容的宽度小于 900px 时 */
        @media screen and (max-width: 900px) {
            .searchInfoListRight {
                display: none;
            }

            .searchInfoListLeft {
                width: 100%;
            }

            .recentlyEmploy span {
                height: 30px !important;
            }

            .footer {
                display: none;
            }
        }

        /* 当屏幕展示内容的宽度大于 900px 时 */
        @media screen and (min-width: 900px) {
            .recentlyEmployRight {
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .recentlyEmployRight span {
                overflow: hidden !important;
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

            .footer {
                background-color: #ffffff80;
            }
        }
    </style>

    <style>
        .recentlyEmployLeft span a {
            font-size: 15px;
            display: inline-block;
            width: 50%;
        }

        .recentlyEmploy {
            margin-top: 20px;
        }

        .searchInfoListLeft {
            box-shadow: none;
        }

        .searchInfoListLeft > div {
            box-shadow: 0 2px 10px #dddddd;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .searchInfoListRight {
            /* position: relative; */
            box-shadow: 0 2px 10px #ffffff;
        }

        .searchInfoListRight > div {
            box-shadow: 0 2px 10px #dddddd;
            border-radius: 2px;
        }

        .networkLand {
            display: none;
        }

        .margin-top {
            margin-top: 10px;
        }

        .weight {
            font-weight: 200;
        }

        .font-size {
            font-size: 15px;
        }

        .padding-left-right {
            padding: 0 20px;
        }

        .padding-bottom {
            padding-bottom: 10px;
        }

        .margin-bottom {
            margin-bottom: 10px;
        }

        .inline-block {
            display: inline-block;
        }

        .color-red {
            color: #fa5555;
        }

        .color-blue {
            color: #1699fd;
        }

        .color-green {
            color: #4ebf48;
        }
    </style>

    <div class="searchInfoList">
        <div class="searchInfoListRight">
            <div class="border-radius">
                <span class="searchInfoListTitle">Yiso 小提示</span>
                <span class="searchInfoListIntroduce">如果有违规内容请您积极检举<br>xlj@xlj0.com/QQ:480003862</span>
            </div>

            <div class="margin-top networkLand border-radius">
                <span class="searchInfoListTitle">网络地皮</span>
                <span class="searchInfoListIntroduce">一个字符 50元/年 (随时溢价)<br>颜色字符 100元/年 (随时溢价)<br>仅限出售这块区域，禁止放违法广告</span>
                <span class="searchInfoListIntroduce padding-bottom">例如: </span>
                <span class="searchInfoListIntroduce"><a href="https://bbs.xlj0.com" class="font-size color-red" target="_Blank">Tooc公益论坛</a></span>
                <span class="searchInfoListIntroduce"><a href="https://www.7e.hk/baremetal/buy.html" class="font-size color-blue" target="_Blank">奇异裸金属服务器 -199元</a></span>
                <span class="searchInfoListIntroduce">图片广告位: 120元/月 1200/年</span>
                <a href="https://www.7e.hk/baremetal/buy.html" target="_blank"><img class="ad-img" src="../img/ad/ad-02.jpg" alt="" /></a>
                <style>
                    .ad-img {
                       width: 100%;
                       background-size: 100%;
                    }
                </style>
            </div>
        </div>
        <div class="searchInfoListLeft">
            <div id="tips">
                <span class="searchInfoListTitle">Tips</span>
                <span class="searchInfoListIntroduce">找到不到想要的结果?<br> <a href="https://s.xlj0.com/s/included/automation.php" class="color-blue">提交收录</a> ，这样下次就能直接找到啦</span>
            </div>

            <style>
                .searchInfoListUrl {
                    font-size: 15px;
                    font-weight: 200;
                    /* padding: 20px 20px 10px 20px; */
                    color: #4ebf48;
                    width: 50%;
                    display: inline-block;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .searchInfoListDate {
                    font-size: 15px;
                    font-weight: 200;
                    /* padding: 20px 20px 10px 20px; */
                    width: 50%;
                    text-align: right;
                    overflow: auto;
                    float: right;
                }

                .searchInfoListLeft > div > .searchInfoListUrlDiv {
                    padding: 0 20px 20px 20px;
                }

                .searchInfoListTitle > svg {
                    padding: 0 5px;
                    display: none;
                }

                .userAuthentication {
                    display: none;
                }

                .searchInfoListIntroduce {
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .searchInfoNav {
                    width: 80%;
                    margin: 0 auto 10px auto;
                    font-size: 15px;
                    text-align: right;
                    font-weight: 200;
                }

                .searchInfoNav > form input {
                    display: none;
                }

                .searchNavSubmit {
                    background-color: transparent;
                    border: none;
                    font-size: 15px;
                    color: #1699fd;
                    font-weight: bold;
                }
            </style>

            <?php
                /* 搜索算法 V4.0 */
                /* 搜索核心 */
                // $searchInfo - 搜索的关键词或内容
                function searchAlgorithm ($searchInfo) {
                    echo "<script>loadingAnimation.style.display = 'block';</script>";
                    $file = fopen('./database/webInfo/webinfo.yiso', 'r');
                    
                    while (($Buffer = fgets($file, 10240)) !== false) {
                        $webArray = explode("////", $Buffer);

                        // 搜索算法
                        preg_match_all("/".$searchInfo."/i", $webArray[0], $webSearch, PREG_PATTERN_ORDER);

                        if ($webSearch[0][0] != null) {
                            echo "<div>";
                            echo '<div><span class="searchInfoListTitle"><a href="'.htmlToString($webArray[2]).'" target="_Blank">'.htmlToString($webArray[0]).'</a>
                            <svg style="display: none;" class="blackAuthentication" t="1652096347930" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5614" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#000000" p-id="5615" data-spm-anchor-id="a313x.7781069.0.i33" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#000000" p-id="5616" data-spm-anchor-id="a313x.7781069.0.i32" class="selected"></path></svg>
                            <svg style="display: none;" class="blueAuthentication" t="1652095384687" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1928" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1296db" p-id="1929" data-spm-anchor-id="a313x.7781069.0.i0" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1296db" p-id="1930" data-spm-anchor-id="a313x.7781069.0.i1" class="selected"></path></svg>
                            <svg style="display: none;" class="greenAuthentication" t="1652096073147" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3092" data-spm-anchor-id="a313x.7781069.0.i16" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1afa29" p-id="3093" data-spm-anchor-id="a313x.7781069.0.i17" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1afa29" p-id="3094" data-spm-anchor-id="a313x.7781069.0.i15" class="selected"></path></svg>
                            <svg style="display: none;" class="redAuthentication" t="1652095867061" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2212" data-spm-anchor-id="a313x.7781069.0.i7" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#d81e06" p-id="2213" data-spm-anchor-id="a313x.7781069.0.i5" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#d81e06" p-id="2214" data-spm-anchor-id="a313x.7781069.0.i6" class="selected"></path></svg>
                            </span></div>';
                            echo '<span class="searchInfoListIntroduce">'.htmlToString($webArray[1]).'</span>';
                            echo '<span class="userAuthentication">'.htmlToString($webArray[5]).'</span>';
                            echo '<div class="searchInfoListUrlDiv"><span class="searchInfoListUrl">'.htmlToString($webArray[2]).'</span><span class="searchInfoListDate">'.htmlToString($webArray[6]).'</span></div>';
                            echo "</div>";

                            // var_dump($webSearch[0]);

                            // 隐藏信息
                            echo "<script>document.getElementById('tips').style.display = 'none';</script>";

                            // 隐藏加载动画
                            echo "<script>loadingAnimation.style.display = 'none';</script>";
                            // 显示网络地皮 - networkLand
                            echo "<script>document.getElementsByClassName('networkLand')[0].style.display = 'block';</script>";
                        } else {
                            // 隐藏加载动画
                            echo "<script>loadingAnimation.style.display = 'none';</script>";
                        }

                    }

                    fclose($file);
                }

                // 最近搜索算法
                function searchAlgorithmNavNew ($searchInfo, $length) {
                    $file = fopen('./database/webInfo/webinfo.yiso', 'r');
                    $int = 0;
                    $array = array();
                    while (($Buffer = fgets($file, 10240)) !== false) {
                        $array[] = $Buffer;
                        $int ++;
                    }

                    fclose($file);
                    // var_dump($Buffer);

                    $newArray = array_reverse($array);

                    if ($length == "null") {
                        global $len;
                        $len = $int;
                    } else {
                        global $len;
                        $len = $length;
                    }

                    $second = 0;
                    for ($i = 0; $i < $int; $i ++) {
                        $webArray = explode("////", $newArray[$i]);

                        // 搜索算法
                        preg_match_all("/".$searchInfo."/i", htmlToString($webArray[0]), $webSearch, PREG_PATTERN_ORDER);

                        // var_dump($webSearch);

                        if ($webSearch[0][0] != null) {
                            if ($second < $len) {
                                echo "<div>";
                                echo '<div class="searchInfoListLayout"><span class="searchInfoListTitle"><a href="'.htmlToString($webArray[2]).'" target="_Blank">'.htmlToString($webArray[0]).'</a>
                                <svg style="display: none;" class="blackAuthentication" t="1652096347930" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5614" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#000000" p-id="5615" data-spm-anchor-id="a313x.7781069.0.i33" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#000000" p-id="5616" data-spm-anchor-id="a313x.7781069.0.i32" class="selected"></path></svg>
                                <svg style="display: none;" class="blueAuthentication" t="1652095384687" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1928" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1296db" p-id="1929" data-spm-anchor-id="a313x.7781069.0.i0" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1296db" p-id="1930" data-spm-anchor-id="a313x.7781069.0.i1" class="selected"></path></svg>
                                <svg style="display: none;" class="greenAuthentication" t="1652096073147" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3092" data-spm-anchor-id="a313x.7781069.0.i16" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1afa29" p-id="3093" data-spm-anchor-id="a313x.7781069.0.i17" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1afa29" p-id="3094" data-spm-anchor-id="a313x.7781069.0.i15" class="selected"></path></svg>
                                <svg style="display: none;" class="redAuthentication" t="1652095867061" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2212" data-spm-anchor-id="a313x.7781069.0.i7" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#d81e06" p-id="2213" data-spm-anchor-id="a313x.7781069.0.i5" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#d81e06" p-id="2214" data-spm-anchor-id="a313x.7781069.0.i6" class="selected"></path></svg>
                                </span></div>';
                                echo '<span class="searchInfoListIntroduce">'.htmlToString($webArray[1]).'</span>';
                                echo '<span class="userAuthentication">'.htmlToString($webArray[5]).'</span>';
                                echo '<div class="searchInfoListUrlDiv"><span class="searchInfoListUrl">'.htmlToString($webArray[2]).'</span><span class="searchInfoListDate">'.htmlToString($webArray[6]).'</span></div>';
                                echo "</div>";

                                // var_dump($webSearch[0]);

                                // 隐藏信息
                                echo "<script>document.getElementById('tips').style.display = 'none';</script>";

                                // 隐藏加载动画
                                echo "<script>loadingAnimation.style.display = 'none';</script>";
                                // 显示网络地皮 - networkLand
                                // 搜索结果显示完成后
                                echo "<script>
                                    document.getElementsByClassName('networkLand')[0].style.display = 'block';
                                    var showMore = true;
                                    // var infonull = true;
                                </script>";
                                $second ++;
                            }
                        } else {
                            // 隐藏加载动画
                            echo "<script>loadingAnimation.style.display = 'none';</script>";
                        }
                    }
                }

                // 防CC系统
                if ($_COOKIE['verification'] == true) {
                    // 如果选用其他搜索方式
                    if ($_GET['searchNavOne'] == true) {
                        searchAlgorithm($searchInfo);
                    } else {
                        // 显示更多收录
                        if ($_GET['showMore'] == "more") {
                            // 继续显示更多
                            if ($_GET['showLength'] != null) {
                                $searchLength = $_GET['showLength'] + 10;
                                $_GET['showLength'] = $searchLength;
                            }
                            searchAlgorithmNavNew($searchInfo, $searchLength);
                        } else {
                            // 显示 10 条
                            $int = 10;
                            searchAlgorithmNavNew($searchInfo, $int);
                            $_GET['showLength'] = $int;
                        }
                    }
                }
            ?>

            <div class="showMore">
                <form action="./index.php" id="showMore">
                    <span>加载更多</span>
                    <input type="text" name="searchInput" class="searchInfo" value="<?php echo $_GET['searchInput']; ?>">
                    <input type="text" name="showLength" class="searchInfo" value="<?php echo $_GET['showLength']; ?>">
                    <input type="text" name="showMore" value="more">
                </form>
            </div>

            <script>
                /* 加载更多 */
                var showLength = document.getElementsByClassName('searchInfo')[1];
            </script>

            <script>
                // 认证信息 - 收录网站认证信息 0 = 未认证, 1-4 依次 蓝，绿，黑，红
                var userAuthentication = document.getElementsByClassName('userAuthentication');
                // 黑验证标
                var blueAuthentication = document.getElementsByClassName('blueAuthentication');
                var greenAuthentication = document.getElementsByClassName('greenAuthentication');
                var blackAuthentication = document.getElementsByClassName('blackAuthentication');
                var redAuthentication = document.getElementsByClassName('redAuthentication');
                // 循环把所有标签都绑定 - 进行验证
                for (i = 0; i < userAuthentication.length; i ++) {
                    if (userAuthentication[i].innerText == 4) {
                        redAuthentication[i].style.display = 'inline-block';
                    } else if (userAuthentication[i].innerText == 3) {
                        blackAuthentication[i].style.display = 'inline-block';
                    } else if (userAuthentication[i].innerText == 2) {
                        greenAuthentication[i].style.display = 'inline-block';
                    } else if (userAuthentication[i].innerText == 1) {
                        blueAuthentication[i].style.display = 'inline-block';
                    } else if (userAuthentication == 0) {
                        // 未认证
                    }
                }

                // 加载收录结果后显示内容
                if (showMore == true) {
                    var showMore = document.getElementsByClassName('showMore')[0];
                    showMore.style.display = 'block';

                    var searchLayout = document.getElementsByClassName('searchInfoListLayout');
                    if (searchLayout.length < 10 || searchLayout.length < showLength.value) {
                        showMore.style.display = 'none';
                    }
                }

                // 显示更多
                var more = document.getElementById('showMore');
                showMore.onclick = function () {
                    more.submit();
                }

                /* 方法 */
                // 收录结果数据为空处理
                function infoNull () {
                    if (infonull == true) {
                        console.log('JavaScript:infoNull():ok');
                        var searchIntroduce = document.getElementsByClassName('searchInfoListIntroduce');
                        for (var i = 0; i < searchIntroduce.length; i ++) {
                            if (searchIntroduece[i].innerHTML == null) {
                                console.log(i);
                            }
                        }
                    }
                }
                /* 方法 */

                /* --------------------- */
                
                // 执行顺序
                infoNull();
            </script>
        </div>
    </div>

    <!-- 最近收录 -->
    <div class="recentlyEmploy">
        <span>最近收录</span>
        <div class="recentlyEmployRight">
            <span>XLJ记录代码的博客</span>
            <?php
                if ($_COOKIE['verification'] == true) {
                    // 解析最近收录内容
                    $file = fopen('./database/webInfo/webinfo.yiso', 'r');
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
            <span><a href="https://xlj0.com">XLJ的博客</a> <svg t="1652071822127" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1928" width="200" height="200"><path d="M445.7472 959.0784a66.88768 66.88768 0 0 1-99.90144-26.76736 113.74592 113.74592 0 0 0-114.76992-66.2528 66.88768 66.88768 0 0 1-73.1136-73.13408 113.74592 113.74592 0 0 0-66.27328-114.76992 66.88768 66.88768 0 0 1-26.76736-99.90144 113.74592 113.74592 0 0 0 0-132.5056 66.88768 66.88768 0 0 1 26.76736-99.90144 113.74592 113.74592 0 0 0 66.2528-114.76992 66.88768 66.88768 0 0 1 73.13408-73.1136 113.74592 113.74592 0 0 0 114.76992-66.27328 66.88768 66.88768 0 0 1 99.90144-26.76736 113.74592 113.74592 0 0 0 132.5056 0 66.88768 66.88768 0 0 1 99.90144 26.76736 113.74592 113.74592 0 0 0 114.76992 66.2528 66.88768 66.88768 0 0 1 73.1136 73.13408 113.74592 113.74592 0 0 0 66.27328 114.76992 66.88768 66.88768 0 0 1 26.76736 99.90144 113.74592 113.74592 0 0 0 0 132.5056 66.88768 66.88768 0 0 1-26.76736 99.90144 113.74592 113.74592 0 0 0-66.2528 114.76992 66.88768 66.88768 0 0 1-73.13408 73.1136 113.74592 113.74592 0 0 0-114.76992 66.27328 66.88768 66.88768 0 0 1-99.90144 26.76736 113.74592 113.74592 0 0 0-132.5056 0z" fill="#d81e06" p-id="1929" data-spm-anchor-id="a313x.7781069.0.i0" class=""></path><path d="M416.58368 368.64v12.75904c-3.3792 0-6.63552 0.8192-9.78944 2.47808-3.13344 1.65888-4.7104 4.85376-4.7104 9.58464 0 5.20192 2.048 11.81696 6.16448 19.8656l6.79936 13.45536 8.06912 16.30208 92.8768 195.01056 90.68544-192.16384c4.64896-9.8304 9.05216-18.8416 13.23008-27.01312l3.09248-5.95968c5.07904-9.68704 7.61856-16.42496 7.61856-20.21376 0-6.9632-5.75488-10.73152-17.3056-11.264l-3.01056-0.08192V368.64H737.28v12.75904c-9.66656 0-16.6912 3.44064-21.03296 10.28096a172.032 172.032 0 0 0-8.13056 13.96736l-133.67296 287.45728A40.96 40.96 0 0 1 537.31328 716.8h-46.42816a40.96 40.96 0 0 1-37.0688-23.53152l-138.07616-293.43744a23.77728 23.77728 0 0 0-10.15808-11.34592 85.66784 85.66784 0 0 0-14.90944-5.89824L286.72 381.39904V368.64h129.86368z" fill="#ffffff" p-id="1930" data-spm-anchor-id="a313x.7781069.0.i1" class="selected"></path></svg></span>
            <?php
                if ($_COOKIE['verification'] == true) {
                    // 解析最近收录内容
                    $file = fopen('./database/webInfo/webinfo.yiso', 'r');
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
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.$webArray[0].'</a><svg t="1652095384687" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1928" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1296db" p-id="1929" data-spm-anchor-id="a313x.7781069.0.i0" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1296db" p-id="1930" data-spm-anchor-id="a313x.7781069.0.i1" class="selected"></path></svg></span>';
                            } else if ($webArray[5] == 2) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.$webArray[0].'</a><svg t="1652096073147" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3092" data-spm-anchor-id="a313x.7781069.0.i16" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#1afa29" p-id="3093" data-spm-anchor-id="a313x.7781069.0.i17" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#1afa29" p-id="3094" data-spm-anchor-id="a313x.7781069.0.i15" class="selected"></path></svg></span>';
                            } else if ($webArray[5] == 3) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.$webArray[0].'</a><svg t="1652096347930" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5614" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#000000" p-id="5615" data-spm-anchor-id="a313x.7781069.0.i33" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#000000" p-id="5616" data-spm-anchor-id="a313x.7781069.0.i32" class="selected"></path></svg></span>';
                            } else if ($webArray[5] == 4) {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.$webArray[0].'</a><svg t="1652095867061" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2212" data-spm-anchor-id="a313x.7781069.0.i7" width="200" height="200"><path d="M484.522667 77.192533l-307.2 134.997334A68.266667 68.266667 0 0 0 136.533333 274.653867V486.229333c0 129.5872 57.9584 245.384533 160.085334 325.188267l176.0256 124.2112a68.266667 68.266667 0 0 0 78.711466 0l174.6944-123.221333C829.508267 731.5968 887.466667 615.799467 887.466667 486.229333V274.670933a68.266667 68.266667 0 0 0-40.789334-62.498133l-307.2-134.997333a68.266667 68.266667 0 0 0-54.954666 0zM204.8 274.670933l307.2-134.997333 307.2 134.997333V486.229333c0 108.305067-48.0768 204.373333-133.853867 271.394134L512 879.837867l-174.6944-123.221334C252.8768 690.551467 204.8 594.500267 204.8 486.1952V274.670933z" fill="#d81e06" p-id="2213" data-spm-anchor-id="a313x.7781069.0.i5" class="selected"></path><path d="M682.666667 358.4l48.264533 48.264533-221.866667 221.866667a34.133333 34.133333 0 0 1-48.264533 0l-136.533333-136.533333L372.5312 443.733333l112.401067 112.384L682.666667 358.4z" fill="#d81e06" p-id="2214" data-spm-anchor-id="a313x.7781069.0.i6" class="selected"></path></svg></span>';
                            } else {
                                echo '<span><a href="'.$webArray[2].'" target="_Blank">'.$webArray[0].'</a></span>';
                            }
                        }

                        unset($Buffer);
                        unset($array);
                        unset($newArray);
                    }
                }
            ?>
        </div>
    </div>

    <?php
        /* 判断是否显示 - 最近收录 */
        // 判断是否搜索
        if ($formInfo != false) {
            // 隐藏信息 - JavaScript实现
            echo "<script>
                var recentlyEmploy = document.getElementsByClassName('recentlyEmploy')[0];
                recentlyEmploy.style.display = 'none';
            </script>";
        }
    ?>

    <div class="padding-top">

    </div>

    <div class="footer">
        <div>
            <span><a href="../help/index.html">使用须知</a></span>
            <span><a href="../help/responsibility.html">免责申明</a></span>
            <span><a href="https://beian.miit.gov.cn/#/Integrated/index">豫ICP备2021002284号-1</a></span>
            <span><a href="https://www.beian.gov.cn/portal/index"><img style="vertical-align: middle;" src="https://xlj0.com/usr/themes/line/img/gwbalogo.png">&nbsp;豫公网安公安局备案 41160202000364号</a></span>
        </div>
    </div>

    <?php formInfo($searchInfo); ?>

    <!-- 引入 Js 文件 -->
    <script src="./js/canvasText.js"></script>
</body>
</html>