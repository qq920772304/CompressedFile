# CompressedFile
PHP 压缩文件成ZIP

PHP 解压ZIP与RAR

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
    $zip->setPwd("");// 无密码可以不填写
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
    $zip->setPwd("");// 无密码可以不填写
    $data = $zip->ZipDecompression();
    return $data;
}
/**
 * 案例3 解压rar
 * @throws Exception
 */
function demo3(){
    $rar = new RarOperation();
    $rar->setCompressedPacketPath("/wwwroot/CompressedFile/public/工作汇报.rar");
    $rar->setDecompressionPath(__DIR__.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."工作汇报");
    $rar->setPwd("");// 无密码可以不填写
    $data = $rar->decompression();
    return $data;
}
~~~
