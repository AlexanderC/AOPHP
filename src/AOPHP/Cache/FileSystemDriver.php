<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:42 PM
 */

namespace AOPHP\Cache;


use AOPHP\DocBlock\Block;

class FileSystemDriver implements IDriver
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * @param bool|string $directory
     */
    function __construct($directory = false)
    {
        $directory = (false !== $directory) ? realpath($directory) : false;
        $this->directory = $directory ? : sys_get_temp_dir();
    }

    /**
     * @param string $class
     * @param string $method
     * @return \AOPHP\DocBlock\Block
     */
    public function get($class, $method)
    {
        $file = $this->getFile($class, $method);

        if(is_file($file)) {
            if(false !== ($rawContent = @file_get_contents($file))) {
                return @unserialize($rawContent);
            }
        }

        return false;
    }

    /**
     * @param Block $block
     * @return bool
     */
    public function persist(Block $block)
    {
        $file = $this->getFile($block->getClass(), $block->getMethod());

        return file_put_contents($file, @serialize($block), LOCK_EX | LOCK_NB);
    }

    /**
     * @param Block $block
     * @return bool
     */
    public function invalidate(Block $block)
    {
        $file = $this->getFile($block->getClass(), $block->getMethod());

        if(is_file($file)) {
            return @unlink($file);
        }

        return false;
    }

    /**
     * @param string $class
     * @param string $method
     * @return string
     */
    protected function getFile($class, $method)
    {
        return sprintf('%s/aophp.%s_%s.tpf', $this->directory, sha1($class), sha1($method));
    }
} 