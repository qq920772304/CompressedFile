<?php


namespace Xiong\CompressedFile;

use Exception;

class CompressionInit
{
    // 文件集合
    protected $file_set = array();
    // 存储路径
    protected $decompression_path = "";
    // 设置压缩文件名
    protected $file_name = "";
    // 压缩包路径
    protected $compressed_packet_path = "";

    /**
     * 设置压缩文件名
     * @param $fileName string 文件名
     */
    public function setFileName($fileName = ""){
        if($fileName != ""){
            $this->file_name = $fileName;
        }else{
            $this->file_name = rand(10,99)."_".time();
        }
    }
    /**
     * 需要压缩的文件
     *
     * @param $path string 文件路径
     * @throws Exception
     */
    public function setFiles(string $path){
        $file_set = $this->file_set;
        // 判断文件是否存在
        if(file_exists($path)){
            $file_set[] = str_replace("\\","/",$path);
            $this->file_set = $file_set;
        }else{
            throw new Exception("文件不存在 ".$path,401);
        }
    }

    /**
     * 设置压缩后存储位置
     *
     * @param $path
     */
    public function setDecompressionPath($path){
        // 判断目录是否存在，如果不存在新建目录
        if(!is_dir($path)){
            $path = str_replace("\\","/",$path);
            mkdir($path,0777,true);
        }
        $this->decompression_path = $path;
    }

    /**
     * 判断文件目录是否存在
     * @throws Exception
     */
    protected function isDecompressionPath(){
        if($this->decompression_path == ""){
            throw new Exception("保存文件目录不存在",401);
        }
    }

    /**
     * 设置压缩包路径
     *
     * @param $path
     * @throws Exception
     */
    public function setCompressedPacketPath($path){
        if(file_exists($path)){
            $compressed_packet_path = str_replace("\\","/",$path);
            $this->compressed_packet_path = $compressed_packet_path;
        }else{
            throw new Exception("文件不存在 ".$path,401);
        }
    }
    /**
     * 判断压缩文件是否存在
     *
     * @throws Exception
     */
    protected function isCompressedPacketPath(){
        if($this->compressed_packet_path == ""){
            throw new Exception("压缩文件不存在".$this->compressed_packet_path,401);
        }
    }

    /**
     * 扫描目录中存在的文件
     *
     * @param $path string 扫描的路径
     * @return array 所有文件路径
     */
    protected function getAllFiles(string $path){
        $path = str_replace("\\","/",$path);
        $str = mb_substr($path,-1,1);
        if($str != "/"){
            $path = $path."/";
        }
        $files = scandir($path);
        $data = array();
        foreach ($files as $key=>$value){
            if($value == "." || $value == ".."){
                continue;
            }else if(is_file($path.$value)){
                $data[] = $path.$value;
            }else{
                $list = $this->getAllFiles($path.$value);
                foreach ($list as $index=>$item){
                    $data[] = $item;
                }
            }
        }
        return $data;
    }
}
