<?php
    /* 保存表单数据 */
    function formInfo () {
        if ($_GET['webTitle'] != null) {
            $webTitle = $_GET['webTitle'];
            $webDecription = $_GET['webDecription'];
            $webKeywords = $_GET['webKeywords'];
            $webUrl = $_GET['webUrl'];

            return array("webTitle" => $webTitle, "webDecription" => $webDecription, "webKeywords" => $webKeywords, "webUrl" => $webUrl);
        }
    }

    // 获取表单数据
    $formInfo = formInfo();
    if ($formInfo != null) {
        // 读取数据
        $webDatabase = file_get_contents('../database/webInfo/webinfo.yiso');
        // 分析数据
        $webDatabase_Array = explode("\r\n", $webDatabase);
        
        // 循环分析数据
        $webUrl = $formInfo['webUrl'];
        var_dump($webUrl);
        for ($i = 0; $i < count($webDatabase_Array); $i ++) {
            // 分析每一条数据
            $webDatabase_Array_All = explode("////", $webDatabase_Array[$i]);
            $webDatabase_webUrl = $webDatabase_Array_All[2];

            // 判断是否重复
            if ($webUrl == $webDatabase_webUrl."/") {
                // 提示信息
                // echo "<script>console.log('提交收录: error (已经收录!)');</script>";

                $webUrlAgainIf = true;
                // break;
            } else if ($webUrl == $webDatabase_webUrl) {
                // 提示信息
                // echo "<script>console.log('提交收录: error (已经收录!)');</script>";
                $webUrlAgainIf = true;
            }
        }

        // var_dump($webUrlAgainIf);
        // 判断重复
        if ($webUrlAgainIf != true) {
            // 写入文件
            $file = fopen('../database/webInfo/webinfo.yiso', 'w');
            $file_fwrite = fwrite($file, $webDatabase."\r\n".$formInfo['webTitle']."////".$formInfo['webDecription']."////".$formInfo['webUrl']."////"."null"."////"."0"."////"."0"."////".date('Y/m/d H:i:s')."////"."null"."////"."null"."////"."null"."////"."null");
            fclose($file);

            // 提示信息
            echo "<script>
                console.log('%cYiso 提醒', 'padding: 10px; background-color: #3e7fff; color: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px #dddddd;');
                console.log('%cYiso 提交收录: http ok', 'padding: 10px; background-color: #3e7fff; color: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px #dddddd;');
            </script>";
        } else {
            // 提示信息
            echo "<script>
                console.log('%cYiso 提醒', 'padding: 10px; background-color: #3e7fff; color: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px #dddddd;');
                console.log('%cYiso 提交收录: error (已经收录!)', 'padding: 10px; background-color: #3e7fff; color: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px #dddddd;');
            </script>";
        }
    }
?>