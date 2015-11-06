<?php

/**
 * @author    jimmy jaw <web3d@live.com>
 * @package   TimeCheer\StreamWrapper
 */

/**
 * 按场景拆分接口 - 目录流相关
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 * @package TimeCheer\StreamWrapper
 */
interface TimeCheer_StreamWrapper_DirectoryInterface {

    /**
     * Close directory handle
     * @link http://www.php.net/manual/en/streamwrapper.dir-closedir.php
     * @return boolean
     */
    public function dir_closedir();

    /**
     * Open directory handle
     * @link http://www.php.net/manual/en/streamwrapper.dir-opendir.php
     * @param string $path
     * @param int $options
     * @return boolean
     */
    public function dir_opendir($path, $options);

    /**
     * Read entry from directory handle
     * @link http://www.php.net/manual/en/streamwrapper.dir-readdir.php
     * @return string
     */
    public function dir_readdir();

    /**
     * Rewind directory handle
     * @link http://www.php.net/manual/en/streamwrapper.dir-rewinddir.php
     * @return boolean
     */
    public function dir_rewinddir();
}
