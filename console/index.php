<?php
    // 不提示错误信息
    error_reporting(0);
    
    // verificationCC() 防CC系统
    // indexStart() 加载首页

    /* 方法函数集 */
    // 验证是否为正常流量防止恶意流量攻击
    // $_COOKIE['verification']; 储存在COOKIE里的验证信息
    function verificationCC () {
        if ($_COOKIE['verification'] == null) {
            header('Location: ../verification.html');
        } else {
            indexStart(); // 加载首页
            userVerification(); // 登录检测系统
        }
    }

    // 加载首页
    function indexStart() {
        include('./admin.php');
    }

    // 登录检测系统
    function userVerification() {
        if ($_COOKIE['userName'] == null) {
            echo "<script>console.log('userVerification: 登录错误');</script>";
            header('Location: ./login.php');
        }
    }

    // 退出登录
    function outLogin () {
        if ($_GET['outLogin'] == true) {
            setcookie('userName', null);
        }
    }

    // 加载排序
    function loadIndex() {
        verificationCC(); // 防CC系统
        outLogin(); // 退出登录
    }
    /* 方法函数集 */

    /* -------------------- */

    // 初始化
    loadIndex();
?>