<?php


// 读取文件
function read_file($filepath)
{
    if (!file_exists($filepath)) {
        return "";  // 不存在
    }
    $f = fopen($filepath, "r");
    $fstr = fread($f, filesize($filepath));
    fclose($f);
    return $fstr;
}

// 写入文件
function write_file($filepath, $str)
{
    $f = fopen($filepath, "w");
    fwrite($f, $str);
    fclose($f);
    return true;
}



?>