<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/29/13
 * @time 1:56 PM
 */

namespace AOPHP\Cache;


use AOPHP\DocBlock\Block;

class MemcachedDriver implements IDriver
{
    /**
     * @var \Memcached
     */
    protected $instance;

    /**
     * @param \Memcached $instance
     */
    public function __construct(\Memcached $instance)
    {
        $this->instance = $instance;
    }

    /**
     * @param string $class
     * @param string $method
     * @return \AOPHP\DocBlock\Block
     */
    public function get($class, $method)
    {
        $key = self::getKey($class, $method);

        return $this->instance->get($key);
    }

    /**
     * @param Block $block
     * @return bool
     */
    public function persist(Block $block)
    {
        $key = self::getKey($block->getClass(), $block->getMethod());

        return $this->instance->set($key, $block);
    }

    /**
     * @param Block $block
     * @return bool
     */
    public function invalidate(Block $block)
    {
        $key = self::getKey($block->getClass(), $block->getMethod());

        return $this->instance->delete($key);
    }

    /**
     * @param string $class
     * @param string $method
     * @return string
     */
    protected function getKey($class, $method)
    {
        return sprintf('aophp_%s_%s', sha1($class), sha1($method));
    }

    /**
     * @return \Memcached
     */
    public function getInstance()
    {
        return $this->instance;
    }
} 