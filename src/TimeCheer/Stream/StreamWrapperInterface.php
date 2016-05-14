<?php

/**
 * PHP Stream Wrapper
 * 
 * 对PHP官方文档中Class Synopsis的解读与分解
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 */

namespace TimeCheer\Stream;

/**
 * 完整的流包裹接口定义
 */
interface StreamWrapperInterface extends SimpleStreamWrapperInterface
{

    /**
     * 检索基础资源，响应stream_select()函数
     * @since PHP 5 >= 5.3.0, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-cast.php
     * @param int $cast_as
     * @return resource
     */
    public function stream_cast($cast_as);

    /**
     * 清除输出缓存，响应fflush()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-flush.php
     * @return boolean
     */
    public function stream_flush();

    /**
     * 咨询文件锁定，响应flock()函数
     * @since PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-lock.php
     * @param int $operation
     * @return boolean
     */
    public function stream_lock($operation);

    /**
     * 改变流设置,响应touch(),chmod(),chown(),chgrp()
     * @sine PHP 5 >= 5.4.0, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-metadata.php
     * @param string $path
     * @param int $option
     * @param mixed $value
     * @return boolean
     */
    public function stream_metadata($path, $option, $value);

    /**
     * 改变流设置
     * @since PHP 5 >= 5.3.0, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-set-option.php
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     * @return boolean
     */
    public function stream_set_option($option, $arg1, $arg2);

    /**
     * 检索文件资源的信息，响应fstat()函数
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-stat.php
     * @return array
     */
    public function stream_stat();

    /**
     * 将文件截取为指定大小,响应ftruncate()函数
     * @since PHP 5 >= 5.4.0, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.stream-truncate.php
     * @param int $new_size
     * @return boolean
     */
    public function stream_truncate($new_size);

    /**
     * 检索文件的信息，响应所有stat()相关的函数，例如chmod() (安全模式启用),copy(),fileperms(),fileinode(),filesize(),fileowner(),filegroup(),fileatime(),filemtime(),filectime(),filetype(),is_writable(),is_readable(),is_executable(),is_file(),is_dir(),is_link(),file_exists(),lstat(),stat()等
     * @since PHP 4 >= 4.3.2, PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.url-stat.php
     * @param string $path
     * @param int $flags
     * @return array
     */
    public function url_stat($path, $flags);
}
