<?php

namespace TimeCheer\Stream;

/**
 * Unlink操作接口
 */
interface UnlinkWrapperInterface extends WrapperInterface
{

    /**
     * 删除文件,unlink() rmdir()
     * @since PHP 5, PHP 7
     * @link http://www.php.net/manual/en/streamwrapper.unlink.php
     * @param string $path
     * @return boolean
     */
    public function unlink($path);
}
