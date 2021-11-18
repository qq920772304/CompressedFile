<?php

namespace Xiong\CompressedFile;

use Exception;
use ZipArchive;

class ZipOperation extends CompressionInit
{
    private $ext_zip;
    /**
     * 构造zip类
     *
     * ZipOperation constructor.
     */
    public function __construct(){
        $this->ext_zip = new ZipArchive;
    }

    /**
     * 把文件压缩成zip，并返回路径
     *
     * @return string 压缩包路径
     * @throws Exception
     */
    public function ZipPack(){
        $this->isExtZip();
        return $this->zipAssemble();
    }

    /**
     * 把文件设置为压缩文件
     *
     * @return string
     * @throws Exception
     */
    private function zipAssemble(){
        $this->isDecompressionPath();
        $filename = $this->decompression_path;
        $str = mb_substr($filename,-1,1);
        $file_name = $this->file_name;
        if($file_name == ""){
            $this->setFileName();
        }
        if($str == "/"){
            $filename = $filename.$this->file_name.".zip";
        }else{
            $filename = $filename."/".$this->file_name.".zip";
        }
        $this->ext_zip->open($filename,ZipArchive::CREATE);
        $file_set = $this->file_set;
        if(count($file_set) == 0){
            throw new Exception("没有设置文件，无法进行压缩zip",401);
        }
        foreach ($this->file_set as $key=>$value){
            $this->ext_zip->addFile($value,basename($value));
        }
        $this->ext_zip->close();
        return $filename;
    }
    /**
     * 判断zip扩展是否存在
     * @throws Exception
     */
    private function isExtZip(){
        $exts = get_loaded_extensions();
        if(!in_array("zip",$exts)){
            throw new Exception("php的zip扩展不存在",401);
        }
    }
}
