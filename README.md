# CompressedFile
PHP处理压缩文件（目前不支持文件包含密码）

# 案例
~~~
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
    $zip->setFiles("/wwwroot/CompressedFile/composer.json");
    $zip->setFiles("/wwwroot/CompressedFile/composer.lock");
    $file_name = $zip->ZipPack();
    return $file_name;
}

~~~
