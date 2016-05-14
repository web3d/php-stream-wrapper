<?php

/**
 * PHP Stream Wrapper
 * 
 * 对PHP官方文档中Class Synopsis的解读与分解
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 */

namespace TimeCheer\Stream;

/**
 * 简单流包裹接口
 */
interface SimpleStreamWrapperInterface extends WrapperInterface
{

    /**
     * 关闭资源，响应fclose()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-close.php
     * @return boolean
     */
    public function stream_close();

    /**
     * 检查文件指针是否已经在文件末尾，响应feof()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-eof.php
     * @return boolean
     */
    public function stream_eof();

    /**
     * 打开文件或URL为Stream，响应fopen()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-open.php
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param string $opened_path
     * @return boolean
     */
    public function stream_open($path, $mode, $options, &$opened_path);

    /**
     * 从Stream中读取内容，响应fread(), fgets()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-read.php
     * @param int $count
     * @return string
     */
    public function stream_read($count);

    /**
     * 在流中定位指针，响应fseek()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-seek.php
     * @param int $offset
     * @param int $whence
     * @return boolean
     */
    public function stream_seek($offset, $whence = SEEK_SET);

    /**
     * 检索流中指针的位置，响应ftell()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-tell.php
     * @return int
     */
    public function stream_tell();

    /**
     * 向流中写入内容，响应fwrite(), fputs()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-write.php
     * @param string $data
     * @return int
     */
    public function stream_write($data);
}
