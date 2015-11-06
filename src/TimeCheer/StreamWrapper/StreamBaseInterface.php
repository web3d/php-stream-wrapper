<?php

/**
 * @author    jimmy jaw <web3d@live.com>
 * @package   TimeCheer\StreamWrapper
 */

/**
 * 按场景拆分接口 - 文件流相关基础操作
 * @link http://www.php.net/manual/en/streamwrapper.php
 * @package TimeCheer\StreamWrapper
 */
interface TimeCheer_StreamWrapper_StreamBaseInterface {

    /**
     * Close a resource
     * @link http://www.php.net/manual/en/streamwrapper.stream-close.php
     * @return boolean
     */
    public function stream_close();

    /**
     * Tests for end-of-file on a file pointer
     * @link http://www.php.net/manual/en/streamwrapper.stream-eof.php
     * @return boolean
     */
    public function stream_eof();

    /**
     * Opens file or URL
     * @link http://www.php.net/manual/en/streamwrapper.stream-open.php
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param string $opened_path
     * @return boolean
     */
    public function stream_open($path, $mode, $options, &$opened_path);

    /**
     * Read from stream
     * @link http://www.php.net/manual/en/streamwrapper.stream-read.php
     * @param int $count
     * @return string
     */
    public function stream_read($count);

    /**
     * Seeks to specific location in a stream
     * @link http://www.php.net/manual/en/streamwrapper.stream-seek.php
     * @param int $offset
     * @param int $whence
     * @return boolean
     */
    public function stream_seek($offset, $whence = SEEK_SET);

    /**
     * Retrieve the current position of a stream
     * @link http://www.php.net/manual/en/streamwrapper.stream-tell.php
     * @return int
     */
    public function stream_tell();

    /**
     * Write to stream
     * @link http://www.php.net/manual/en/streamwrapper.stream-write.php
     * @param string $data
     * @return int
     */
    public function stream_write($data);
}
