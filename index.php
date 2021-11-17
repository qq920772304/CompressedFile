<?php

require_once "./vendor/autoload.php";

use Xiong\CompressedFile\ZipOperation;

$zip = new ZipOperation();
$zip->setDecompressionPath(__DIR__.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR);
$zip->setFiles("/wwwroot/test/composer.json");
$zip->setFiles("/wwwroot/test/composer.lock");
$file_name = $zip->ZipPack();
echo $file_name;
