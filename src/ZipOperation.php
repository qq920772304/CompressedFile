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
     * 解压zip文件
     *
     * @return array 解压后的文件路径
     * @throws Exception
     */
    public function ZipDecompression(){
        $this->isExtZip();
        return $this->decompression();
    }

    /**
     * 把zip解压，并返回对应的路径
     *
     * @return array
     */
    private function decompression(){
        // 判断压缩文件是否存在
        $compressed_packet_path = $this->compressed_packet_path;
        $decompression_path = $this->decompression_path;
        $temp_path = sys_get_temp_dir().DIRECTORY_SEPARATOR."compress".rand(10,999)."_".time();
        if(is_dir($temp_path)){
            mkdir($temp_path,0777,true);
        }
        $this->isCompressedPacketPath();
        $this->isDecompressionPath();
        $res = $this->ext_zip->open($compressed_packet_path);
        if($res === true){
            $this->ext_zip->extractTo($temp_path);
            $this->ext_zip->close();
            // 把临时目录的所有文件拷贝到指定目录
            $files = $this->getAllFiles($temp_path);
            $data = $this->moveFileToSpecifyDirectory($files,$decompression_path,$temp_path);
            // 删除所有临时文件和目录
            $this->delDirAndFile($temp_path);
            return $data;
        }else{
            throw new Exception("无法打开压缩包".$compressed_packet_path,401);
        }

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
        $file_name = $this->file_name;
        if($file_name == ""){
            $this->setFileName();
        }
        $filename = $filename.$this->file_name.".zip";
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
