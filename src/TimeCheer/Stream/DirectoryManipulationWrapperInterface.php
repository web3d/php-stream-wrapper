<?php

/**
 * PHP Stream Wrapper
 * 
 * 对PHP官方文档中Class Synopsis的解读与分解
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 */

namespace TimeCheer\Stream;

/**
 * 目录操作相关接口
 */
interface DirectoryManipulationWrapperInterface extends WrapperInterface
{
	/**
	 * 创建目录，响应mkdir()函数
         * @since PHP 5, PHP 7
	 * @link http://www.php.net/manual/en/streamwrapper.mkdir.php
	 * @param string $path
	 * @param int $mode
	 * @param int $options
	 * @return boolean
	 */
	public function mkdir( $path, $mode, $options );

	/**
	 * 目录或文件重命名，响应rename()函数
         * @since PHP 5, PHP 7
	 * @link http://www.php.net/manual/en/streamwrapper.rename.php
	 * @param string $path_from
	 * @param string $path_to
	 * @return boolean
	 */
	public function rename( $path_from, $path_to );

	/**
	 * 删除目录，响应rmdir()函数
         * @since PHP 5, PHP 7
	 * @link http://www.php.net/manual/en/streamwrapper.rmdir.php
	 * @param string $path
	 * @param int $options
	 */
	public function rmdir( $path, $options );
}