<?php

/**
 * PHP Stream Wrapper
 * 
 * 对PHP官方文档中Class Synopsis的解读与分解
 * @link http://www.php.net/manual/en/class.streamwrapper.php
 */

namespace TimeCheer\Stream;

/**
 * 目录存取相关
 */
interface DirectoryStreamWrapperInterface extends WrapperInterface
{
	/**
	 * 关闭目录句柄，响应closedir()函数
	 * @link http://www.php.net/manual/en/streamwrapper.dir-closedir.php
	 * @return boolean
 	 */
	public function dir_closedir();

	/**
	 * 打开目录句柄，响应opendir()函数
	 * @link http://www.php.net/manual/en/streamwrapper.dir-opendir.php
	 * @param string $path
	 * @param int $options
	 * @return boolean
	 */
	public function dir_opendir($path, $options);

	/**
	 * 从目录句柄读取条目，响应readdir()函数
	 * @link http://www.php.net/manual/en/streamwrapper.dir-readdir.php
	 * @return string
	 */
	public function dir_readdir();

	/**
	 * 倒回目录句柄，响应rewinddir()函数
	 * @link http://www.php.net/manual/en/streamwrapper.dir-rewinddir.php
	 * @return boolean
	 */
	public function dir_rewinddir();
}