<?php

/**
 * PHP Stream Wrapper
 * 
 * 对PHP官方文档中Class Synopsis的解读与分解
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 */

namespace TimeCheer\Stream;

/**
 * 本接口为所有接口的基接口
 */
interface WrapperInterface
{

    /**
     * 定义协议,即底层所包裹的引擎如“tcmysql” “tcredis”等,开发者根据自己的场景自行定义
     * @return string
     */
    public function getProtocol();
}
