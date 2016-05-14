<?php

namespace TimeCheer\Stream;

class Wrapper
{

    /**
     * 列出PHP内置的wrapper协议
     * @var array
     */
    protected $builtIn;

    /**
     * 所有加载了的wrapper协议
     * @var array
     */
    protected $loaded;

    public function __construct()
    {
        $this->builtIn = stream_get_wrappers();
        $this->loaded = array();
    }

    /**
     * 判断指定的wrapper协议是否存在
     * @param string $protocol
     * @return boolean
     */
    public function has($protocol)
    {
        if (in_array($protocol, $this->loaded)) {
            return true;
        }
        if (in_array($protocol, $this->builtIn)) {
            return true;
        }

        return false;
    }

    /**
     * 判断指定协议是否是PHP内置
     * @param string $protocol
     * @return boolean
     */
    public function isBuiltIn($protocol)
    {
        if (!$this->has($protocol)) {
            throw new \InvalidArgumentException('Given protocol "' . $protocol . '" does not exists in the current context!');
        }
        if (in_array($protocol, $this->loaded)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 注册新的wrapper协议
     * @param WrapperInterface $wrapper
     * @param int $options 默认0 - 代表本地系统; 如果是URL协议格式 - STREAM_IS_URL
     * @return boolean
     */
    public function register(WrapperInterface $wrapper, $options = 0)
    {
        return stream_wrapper_register($wrapper->getProtocol(), get_class($wrapper), $options);
    }

    /**
     * 注销指定的wrapper协议
     * @param WrapperInterface $wrapper
     * @return boolean
     */
    public function unregister(WrapperInterface $wrapper)
    {
        $protocol = $wrapper->getProtocol();
        if (!$this->has($protocol)) {
            return false;
        }

        stream_wrapper_unregister($protocol);
        if ($this->isBuiltIn($protocol)) {
            $this->restore($protocol);
        }

        return true;
    }

    /**
     * 当指定协议注销后,恢复系统内置协议
     * @param string $protocol 要恢复的协议
     * @return boolean
     */
    protected function restore($protocol)
    {
        return stream_wrapper_restore($protocol);
    }

}
