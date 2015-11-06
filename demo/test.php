<?php

require dirname(__FILE__) . '/../src/TimeCheer/StreamWrapper/Adapter/MySQL.php';
stream_register_wrapper('tcmysqlfs', 'TimeCheer_StreamWrapper_Adapter_MySQL');

$dir_prefix = 'tcmysqlfs://root@localhost/test';

$file_path = $dir_prefix . '/ssss';

mkdir($file_path);

//rename($path_file, '/ssss/21222'); //error Cannot rename a file across wrapper types

//rmdir($path_file);exit;

//写入
$file = $file_path . '/' . time() . '.txt';
$fp = fopen($file, 'w');
if (!$fp) {
    echo 'file resource failed.';
}

fwrite($fp, "asdfasdfa_______ttt");
fclose($fp);

//追加
$fp = fopen($file, 'a');
if (!$fp) {
    echo 'file resource failed.';
}

fwrite($fp, "_added_");
fwrite($fp, "_added2222_");
fwrite($fp, "_added2322_");
fclose($fp);

//读取
$fp = fopen($file, 'r');
if (!$fp) {
    echo 'file resource failed.';
}
echo fread($fp, 20000);
            
fclose($fp);
