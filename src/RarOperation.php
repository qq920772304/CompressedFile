<?php

namespace Xiong\CompressedFile;

use Exception;

class RarOperation extends CompressionInit
{
    /**
     * 判断rar扩展是否存在
     * @throws Exception
     */
    private function isExtRar(){
        $exts = get_loaded_extensions();
        if(!in_array("rar",$exts)){
            throw new Exception("php的rar扩展不存在",401);
        }
    }

    /**
     * 解压rar文件
     *
     * @return array 解压后文件路径
     * @throws Exception
     */
    public function decompression(){
        // 判断压缩文件是否存在
        $this->isCompressedPacketPath();
        $this->isDecompressionPath();
        // 获取对应目录
        $compressed_packet_path = $this->compressed_packet_path;
        $decompression_path = $this->decompression_path;
        $arch = \RarArchive::open($compressed_packet_path,$this->password);
        if($arch === false){
            throw new Exception("无法打开压缩包".$compressed_packet_path,401);
        }
        if($arch->isBroken()){
            throw new Exception("压缩包是损坏的".$compressed_packet_path,401);
        }else if($arch->isSolid()){
            throw new Exception("当前压缩包不可用".$compressed_packet_path,401);
        }
        $entries = $arch->getEntries();
        $data = array();
        foreach ($entries as $en){
            $en->extract($decompression_path,$decompression_path.$en->getName());
            $data[] = $decompression_path.$en->getName();
        }
        $arch->close();
        return $data;
    }
}
