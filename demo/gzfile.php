<?php
define('DEBUG', true);

require dirname(__FILE__) . '/../src/TimeCheer/StreamWrapper/MySQL.php';
stream_register_wrapper('tcmysqlfs', 'TimeCheer_StreamWrapper_MySQL');

$dir_prefix = 'tcmysqlfs://root@localhost/test';

$file_path = $dir_prefix . '/gzfile/.';

mkdir($file_path);

var_dump(file_exists($file_path . '/'));

//写入
$file = $file_path . '/' . time() . '.gz';

$zp = gzopen($file, 'wb');
if (!$zp) {
    echo 'file resource failed.';
}

gzwrite($zp, "_added-gz_");
gzclose($zp);

$ret = gzfile($file);
var_dump($ret);