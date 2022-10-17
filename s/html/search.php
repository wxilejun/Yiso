<?php
    // 不提示错误信息
    error_reporting(0);

    /* 搜索引擎数据库 */
    // 获取文件 - 网页数据库文件
    $file = file_get_contents($webDatabasePath);

    // /* 解析数据库信息 */
    // // 划分数量 - 数据库有多少条数据
    // $webDatabaseArray = explode("\r\n", $webDatabase);
    // // 解析数据 - 把每条数据的每个信息解析出来
    // for ($i = 0; $i < count($webDatabaseArray); $i ++) {
    //     // 解析每条数据的每个数据 - 用分隔符函数把数据解析出来
    //     $webDatabaseArrayAllInfo = explode("////", $webDatabaseArray[$i]);

    //     /* 解析每条数据 */
    //     // 把索引数组变成关联数组 - 使用 list 函数
    //     list($webTitle, $webIntroduce, $webPassword, $webAuthentication, $webUserAuthentication, $webReserve_1, $webReserve_2, $webReserve_3, $webReserve_4) = $webDatabaseArrayAllInfo;
    //     // echo $webTitle.$webIntroduce;
    //     // var_dump($webDatabaseArrayAllInfo);
    // }
?>