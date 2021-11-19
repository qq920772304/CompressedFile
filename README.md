# CompressedFile
PHP处理压缩文件（目前不支持文件包含密码）

------

## 注意

1. ​	目录绝对路径（基于绝对路径开发）


## 案例
~~~php
<?php

require_once "./vendor/autoload.php";

use Xiong\CompressedFile\ZipOperation;

/**
 * 案例1 压缩文件成zip
 *
 * @return string 压缩包路径
 * @throws Exception
 */
function demo1(){
    $zip = new ZipOperation();
    $zip->setDecompressionPath(__DIR__.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR);
    $zip->setFileName(time());
    $zip->setFiles("/wwwroot/CompressedFile/index.php");
    $zip->setFiles("/wwwroot/CompressedFile/README.md");
    $file_name = $zip->ZipPack();
    return $file_name;
}

/**
 * 案例2 解压zip
 * @return array 解压后的路径
 * @throws Exception
 */
function demo2(){
    $zip = new ZipOperation();
    $zip->setDecompressionPath(__DIR__.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."1637286267");
    $zip->setCompressedPacketPath("/wwwroot/CompressedFile/public/1637286378.zip");
    $data = $zip->ZipDecompression();
    return $data;
}
~~~
