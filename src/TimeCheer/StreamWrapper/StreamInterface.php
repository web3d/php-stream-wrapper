<?php

/**
 * @author    jimmy jaw <web3d@live.com>
 * @package   TimeCheer\StreamWrapper
 */

/**
 * 按场景拆分接口 - 文件流相关所有操作
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 * @package TimeCheer\StreamWrapper
 */
interface TimeCheer_StreamWrapper_StreamInterface extends TimeCheer_StreamWrapper_StreamBaseInterface {

    /**
     * Retrieve the underlaying resource
     * @link http://www.php.net/manual/en/streamwrapper.stream-cast.php
     * @param int $cast_as
     * @return resource
     */
    public function stream_cast($cast_as);

    /**
     * Flushes the output
     * @link http://www.php.net/manual/en/streamwrapper.stream-flush.php
     * @return boolean
     */
    public function stream_flush();

    /**
     * Advisory file locking
     * @link http://www.php.net/manual/en/streamwrapper.stream-lock.php
     * @param int $operation
     * @return boolean
     */
    public function stream_lock($operation);

    /**
     * Change stream options
     * @link http://www.php.net/manual/en/streamwrapper.stream-metadata.php
     * @param string $path
     * @param int $option
     * @param mixed $value
     * @return boolean
     */
    public function stream_metadata($path, $option, $value);

    /**
     * Change stream options
     * @link http://www.php.net/manual/en/streamwrapper.stream-set-option.php
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     * @return boolean
     */
    public function stream_set_option($option, $arg1, $arg2);

    /**
     * Retrieve information about a file resource
     * @link http://www.php.net/manual/en/streamwrapper.stream-stat.php
     * @return array
     */
    public function stream_stat();

    /**
     * Truncate stream
     * @link http://www.php.net/manual/en/streamwrapper.stream-truncate.php
     * @param int $new_size
     * @return boolean
     */
    public function stream_truncate($new_size);

    /**
     * Retrieve information about a file
     * @link http://www.php.net/manual/en/streamwrapper.url-stat.php
     * @param string $path
     * @param int $flags
     * @return array
     */
    public function url_stat($path, $flags);
}
