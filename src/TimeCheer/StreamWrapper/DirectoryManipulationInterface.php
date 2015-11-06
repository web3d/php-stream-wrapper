<?php

/**
 * @author    jimmy jaw <web3d@live.com>
 * @package   TimeCheer\StreamWrapper
 */

/**
 * 按场景拆分接口 - 目录操作相关
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 * @package TimeCheer\StreamWrapper
 */
interface TimeCheer_StreamWrapper_DirectoryManipulationInterface {

    /**
     * Create a directory
     * @link http://www.php.net/manual/en/streamwrapper.mkdir.php PHP official documentation
     * @param string $path
     * @param int $mode
     * @param int $options
     * @return boolean
     */
    public function mkdir($path, $mode, $options);

    /**
     * Rename a directory
     * @link http://www.php.net/manual/en/streamwrapper.rename.php PHP official documentation
     * @param string $path_from
     * @param string $path_to
     * @return boolean
     */
    public function rename($path_from, $path_to);

    /**
     * Remove a directory
     * @link http://www.php.net/manual/en/streamwrapper.rmdir.php PHP official documentation
     * @param string $path
     * @param int $options
     */
    public function rmdir($path, $options);
}
