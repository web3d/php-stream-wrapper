<?php

/**
 * @author    jimmy jaw <web3d@live.com>
 * @package   TimeCheer\StreamWrapper
 */

/**
 * 按场景拆分接口 - 文件删除相关
 * @link http://www.php.net/manual/en/streamwrapper.unlink.php
 * @package TimeCheer\StreamWrapper
 */
interface TimeCheer_StreamWrapper_UnlinkInterface {

    /**
     * Delete a file
     * @link http://www.php.net/manual/en/streamwrapper.unlink.php
     * @param string $path
     * @return boolean
     */
    public function unlink($path);
}
